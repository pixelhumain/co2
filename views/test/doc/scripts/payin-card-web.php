<?php
$PayIn = new \MangoPay\PayIn();
$PayIn->CreditedWalletId = $_SESSION["MangoPayDemo"]["WalletForNaturalUser"];
$PayIn->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$PayIn->PaymentType = \MangoPay\PayInPaymentType::Card;
$PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
$PayIn->PaymentDetails->CardType = "CB_VISA_MASTERCARD";
$PayIn->DebitedFunds = new \MangoPay\Money();
$PayIn->DebitedFunds->Currency = "EUR";
$PayIn->DebitedFunds->Amount = 2500;
$PayIn->Fees = new \MangoPay\Money();
$PayIn->Fees->Currency = "EUR";
$PayIn->Fees->Amount = 150;
$PayIn->ExecutionType = \MangoPay\PayInExecutionType::Web;
$PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
$PayIn->ExecutionDetails->ReturnURL = "http".(isset($_SERVER['HTTPS']) ? "s" : null)."://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."?stepId=".($stepId+1);
$PayIn->ExecutionDetails->Culture = "EN";
$result = $mangoPayApi->PayIns->Create($PayIn);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PayInCardWeb"] = $result->Id;

$extraInfo = "You can use the test card 4970101122334414 with any expiry date in the future and a CVV of 123 (or any of <a href='http://docs.mangopay.com/api-references/test-payment/' target='_blank'>these other cards</a>)";
$nextButton = array("url"=>$result->ExecutionDetails->RedirectURL, "text"=>"Go to Payment page");