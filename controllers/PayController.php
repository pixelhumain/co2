<?php
/**
 * PayController.php
 *
 * @author: Tibor Katelbach<tibor@communecter.org>
 * Date: 11/11/17
 */
class PayController extends CommunecterController {
  

	protected function beforeAction($action) {
	    parent::initPage();
	    return parent::beforeAction($action);
	}



	public function actionIndex() {
		if(@Yii::app()->session["userId"])
		{
		    require_once '../../pixelhumain/ph/vendor/autoload.php';
		    define('MangoPayDemo_ClientId', Yii::app()->params["mangoPay"]["ClientId"] );
			define('MangoPayDemo_ClientPassword', Yii::app()->params["mangoPay"]["ClientPassword"] );
			define('MangoPayDemo_TemporaryFolder', Yii::app()->params["mangoPay"]["TemporaryFolder"]);

			$api = new MangoPay\MangoPayApi();

			// configuration
			$api->Config->ClientId = Yii::app()->params["mangoPay"]["ClientId"];
			$api->Config->ClientPassword = Yii::app()->params["mangoPay"]["ClientPassword"];
			$api->Config->TemporaryFolder = Yii::app()->params["mangoPay"]["TemporaryFolder"];

			$user = Person::getById(Yii::app()->session["userId"]);
			if(!@$user["mangoUserId"]){
				$userM = new MangoPay\UserNatural();
				$userM->FirstName = Yii::app()->session["user"]["name"];
				$userM->LastName = Yii::app()->session["user"]["username"];
				$userM->Email = Yii::app()->session["userEmail"];

				$userM->Birthday = time();
				$userM->Nationality = 'FR';
				$userM->CountryOfResidence = 'FR';
				$userM->Occupation = "programmer";
				$userM->IncomeRange = 3;
				 
				//mUser comes from MangoDB App
				$mUser = $api->Users->Create($userM);
				PHDB::update( Person::COLLECTION,	array("_id" => new MongoId(Yii::app()->session["userId"])),
		            array('$set' => array("mangoUserId"=> $mUser->Id))
		            );
			}else {
				echo "user has mango account : ".$user["mangoUserId"];
				$mUser = $api->Users->GetNatural($user["mangoUserId"]);
			}

			$cardRegister = new \MangoPay\CardRegistration();
			$cardRegister->UserId = $mUser->Id;
			$cardRegister->Currency = (@$_GET["cur"]) ? $_GET["cur"] : "EUR";
			$cardRegister->CardType = (@$_GET["card"]) ? $_GET["card"] : "CB_VISA_MASTERCARD"; //or alternatively MAESTRO or DINERS etc
			$createdCardRegister = $api->CardRegistrations->Create($cardRegister);


			$_SESSION['cardRegisterId'] = $createdCardRegister->Id;
			$_SESSION['amount'] = $_GET["amount"];
			$_SESSION['amount'] = (@$_GET["cur"]) ? $_GET["cur"] : "EUR";

			$params = array( 
				"api" => $api,
				'amount' => $_GET["amount"],
				'currency' => (@$_GET["cur"]) ? $_GET["cur"] : "EUR",
				'createdUser' => $mUser,
				'createdCardRegister' => $createdCardRegister
			 );

			$this->renderPartial( "with_js" , $params );
		} else 
			throw new CHttpException(401,Yii::t("common","Login First"));
	  }

	  public function actionIn() {
	  	if(@Yii::app()->session["userId"])
		{
		    require_once '../../pixelhumain/ph/vendor/autoload.php';
		    define('MangoPayDemo_ClientId', Yii::app()->params["mangoPay"]["ClientId"] );
			define('MangoPayDemo_ClientPassword', Yii::app()->params["mangoPay"]["ClientPassword"] );
			define('MangoPayDemo_TemporaryFolder', Yii::app()->params["mangoPay"]["TemporaryFolder"]);

			$api = new MangoPay\MangoPayApi();

			// configuration
			$api->Config->ClientId = Yii::app()->params["mangoPay"]["ClientId"];
			$api->Config->ClientPassword = Yii::app()->params["mangoPay"]["ClientPassword"];
			$api->Config->TemporaryFolder = Yii::app()->params["mangoPay"]["TemporaryFolder"];
			

			if (!isset($_SESSION['amount'])) {
			    die('<div style="color:red;">No payment has been started<div>');
			}

			try {
			    // update register card with registration data from Payline service
			    //$cardRegister = $api->CardRegistrations->Get($_SESSION['cardRegisterId']);
			    
			    // get created virtual card object
			    $user = Person::getById(Yii::app()->session["userId"]);
			    $card = $api->Cards->Get( $_POST["cardId"] );

			    // create temporary wallet for user
			    $userWallet = new \MangoPay\Wallet();
			    $userWallet->Owners = array( $user["mangoUserId"] );
			    $userWallet->Currency = $_POST['currency'];
			    $userWallet->Description = 'Temporary wallet for payment demo';
			    $createdUserWallet = $api->Wallets->Create($userWallet);

			    // create pay-in CARD DIRECT
			    $payIn = new \MangoPay\PayIn();
			    $payIn->CreditedWalletId = $createdUserWallet->Id;
			    $payIn->AuthorId = $user["mangoUserId"];
			    $payIn->DebitedFunds = new \MangoPay\Money();
			    $payIn->DebitedFunds->Amount = $_POST['obj']['total'];
			    $payIn->DebitedFunds->Currency = $_POST['currency'];
			    $payIn->Fees = new \MangoPay\Money();
			    $payIn->Fees->Amount = 0;
			    $payIn->Fees->Currency = $_POST['currency'];

			    // payment type as CARD
			    $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
			    $payIn->PaymentDetails->CardType = $card->CardType;
			    $payIn->PaymentDetails->CardId = $card->Id;

			    // execution type as DIRECT
			    $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
			    $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';

			    // create Pay-In
			    $createdPayIn = $api->PayIns->Create($payIn);

			    // if created Pay-in object has status SUCCEEDED it's mean that all is fine
			    if ($createdPayIn->Status == \MangoPay\PayInStatus::Succeeded) {
			        echo '<div style="color:green;">'.
			                    'Pay-In has been created successfully. '
			                    .'Pay-In Id = ' . $createdPayIn->Id.'<br/>' 
			                    . ', Wallet Id = ' . $createdUserWallet->Id .'<br/>'
			                    . 'transferring'.'<br/>'
			                . '</div>';
			        /*
			        for each Seller from $_POST['obj']
			        check if has mangoPay account 
			        else create MangoPay\UserLegal();
			        */
			        foreach ($_POST['obj']["sellers"] as $key => $sale) 
			        {
			        	$seller = Person::getById( $key );
						if(!@$seller["mangoSellerId"]){
						
							$sellerM = new MangoPay\UserLegal();
							$sellerM->Name = $seller["name"];
							$sellerM->LegalPersonType = "BUSINESS";
							$sellerM->Email = $seller["email"];
							$sellerM->LegalRepresentativeFirstName = $seller["name"];
							$sellerM->LegalRepresentativeLastName = $seller["username"];
							$sellerM->LegalRepresentativeBirthday = 121271;
							$sellerM->LegalRepresentativeNationality = "FR";
							$sellerM->LegalRepresentativeCountryOfResidence = "RE";
							$mSeller = $api->Users->Create($sellerM);

							echo $seller["name"]." seller account created: ".$seller["mangoSellerId"]."<br/>";
							PHDB::update( Person::COLLECTION,	array("_id" => $seller["_id"] ),
					            array('$set' => array("mangoSellerId"=> $mSeller->Id)) );
						}else {
							echo $seller["name"]." seller has mango account : ".$seller["mangoSellerId"]."<br/>";
							$mSeller = $api->Users->GetLegal($seller["mangoSellerId"]);
						}
				        

					//create a wallet 
						//Note that there is no difference between a Wallet for a Natural User and a Legal User
						$Wallet = new \MangoPay\Wallet();
						$Wallet->Owners = array( $mSeller->Id );
						$Wallet->Description = "Demo wallet as seller";
						$Wallet->Currency = "EUR";
						$createdSellerWallet = $api->Wallets->Create($Wallet);
						echo $seller["name"]." wallet created <br/>";

					//transfer amount from user to seller
						$Transfer = new \MangoPay\Transfer();
						$buyer = Person::getById( Yii::app()->session["userId"] );
						$Transfer->AuthorId = $buyer["mangoUserId"];
						$Transfer->DebitedFunds = new \MangoPay\Money();
						$Transfer->DebitedFunds->Currency = $_POST['currency'];
						$Transfer->DebitedFunds->Amount = $sale["total"];
						
						$Transfer->Fees = new \MangoPay\Money();
						$Transfer->Fees->Currency = $_POST['currency'];
						$Transfer->Fees->Amount = $sale["total"]*0.1;
						$Transfer->DebitedWalletID = $createdUserWallet->Id;
						$Transfer->CreditedWalletId = $createdSellerWallet->Id;
						$result = $api->Transfers->Create($Transfer);
						echo "Trensfer from ".$buyer["name"]." to ".$seller["name"]." <br/>";

			        }
			    }
			    else {
			        // if created Pay-in object has status different than SUCCEEDED 
			        // that occurred error and display error message
			        echo '<div style="color:red;">'.
			                    'Pay-In has been created with status: ' 
			                    . $createdPayIn->Status . ' (result code: '
			                    . $createdPayIn->ResultCode . ')'
			                .'</div>';
			    }

			} catch (\MangoPay\Libraries\ResponseException $e) {
			    
			    echo '<div style="color: red;">'
			                .'\MangoPay\ResponseException: Code: ' 
			                . $e->getCode() . '<br/>Message: ' . $e->getMessage()
			                .'<br/><br/>Details: '; print_r($e->GetErrorDetails())
			        .'</div>';
			}
		} else 
			throw new CHttpException(401,Yii::t("common","Login First"));

	  }

}