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

	  public function actionDone() {
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
		    $cardRegister = $mangoPayApi->CardRegistrations->Get($_SESSION['cardRegisterId']);
		    $cardRegister->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];
		    $updatedCardRegister = $mangoPayApi->CardRegistrations->Update($cardRegister);

		    if ($updatedCardRegister->Status != \MangoPay\CardRegistrationStatus::Validated || !isset($updatedCardRegister->CardId))
		        die('<div style="color:red;">Cannot create card. Payment has not been created.<div>');

		    // get created virtual card object
		    $card = $mangoPayApi->Cards->Get($updatedCardRegister->CardId);

		    // create temporary wallet for user
		    $wallet = new \MangoPay\Wallet();
		    $wallet->Owners = array( $updatedCardRegister->UserId );
		    $wallet->Currency = $_SESSION['currency'];
		    $wallet->Description = 'Temporary wallet for payment demo';
		    $createdWallet = $mangoPayApi->Wallets->Create($wallet);

		    // create pay-in CARD DIRECT
		    $payIn = new \MangoPay\PayIn();
		    $payIn->CreditedWalletId = $createdWallet->Id;
		    $payIn->AuthorId = $updatedCardRegister->UserId;
		    $payIn->DebitedFunds = new \MangoPay\Money();
		    $payIn->DebitedFunds->Amount = $_SESSION['amount'];
		    $payIn->DebitedFunds->Currency = $_SESSION['currency'];
		    $payIn->Fees = new \MangoPay\Money();
		    $payIn->Fees->Amount = 0;
		    $payIn->Fees->Currency = $_SESSION['currency'];

		    // payment type as CARD
		    $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
		    $payIn->PaymentDetails->CardType = $card->CardType;
		    $payIn->PaymentDetails->CardId = $card->Id;

		    // execution type as DIRECT
		    $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
		    $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';

		    // create Pay-In
		    $createdPayIn = $mangoPayApi->PayIns->Create($payIn);

		    // if created Pay-in object has status SUCCEEDED it's mean that all is fine
		    if ($createdPayIn->Status == \MangoPay\PayInStatus::Succeeded) {
		        print '<div style="color:green;">'.
		                    'Pay-In has been created successfully. '
		                    .'Pay-In Id = ' . $createdPayIn->Id 
		                    . ', Wallet Id = ' . $createdWallet->Id 
		                . '</div>';
		    }
		    else {
		        // if created Pay-in object has status different than SUCCEEDED 
		        // that occurred error and display error message
		        print '<div style="color:red;">'.
		                    'Pay-In has been created with status: ' 
		                    . $createdPayIn->Status . ' (result code: '
		                    . $createdPayIn->ResultCode . ')'
		                .'</div>';
		    }

		} catch (\MangoPay\Libraries\ResponseException $e) {
		    
		    print '<div style="color: red;">'
		                .'\MangoPay\ResponseException: Code: ' 
		                . $e->getCode() . '<br/>Message: ' . $e->getMessage()
		                .'<br/><br/>Details: '; print_r($e->GetErrorDetails())
		        .'</div>';
		}



		$params = array( "ClientId" => $api->Config->ClientId );
		//$this->renderPartial( "doc/mango" , $params );
		//$this->renderPartial( "api/index" , $params );
		$this->renderPartial( "payment" , $params );
	  }

}