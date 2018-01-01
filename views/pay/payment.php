<?php
// include MangoPay SDK
//require_once '../../vendor/autoload.php';
require_once 'config.php';

// check if payment has been initialized
if (!isset($_SESSION['amount'])) {
    die('<div style="color:red;">No payment has been started<div>');
}

// create instance of MangoPayApi
$mangoPayApi = new \MangoPay\MangoPayApi();
$mangoPayApi->Config->ClientId = Yii::app()->params["mangoPay"]["ClientId"];//MangoPayDemo_ClientId;
$mangoPayApi->Config->ClientPassword = Yii::app()->params["mangoPay"]["ClientPassword"];//MangoPayDemo_ClientPassword;
$mangoPayApi->Config->TemporaryFolder = Yii::app()->params["mangoPay"]["TemporaryFolder"];

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

