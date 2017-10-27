<?php
$PayIn = new \MangoPay\PayIn();
$PayIn->CreditedWalletId = $_SESSION["MangoPayDemo"]["WalletForNaturalUser"];
$PayIn->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$PayIn->PaymentType = \MangoPay\PayInPaymentType::Card;
$PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
$PayIn->DebitedFunds = new \MangoPay\Money();
$PayIn->DebitedFunds->Currency = "EUR";
$PayIn->DebitedFunds->Amount = 599;
$PayIn->Fees = new \MangoPay\Money();
$PayIn->Fees->Currency = "EUR";
$PayIn->Fees->Amount = 0;
$PayIn->ExecutionType = \MangoPay\PayInExecutionType::Direct;
$PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
$PayIn->ExecutionDetails->SecureModeReturnURL = "http".(isset($_SERVER['HTTPS']) ? "s" : null)."://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."?stepId=".($stepId+1);
$PayIn->ExecutionDetails->CardId = $_SESSION["MangoPayDemo"]["Card"];
$result = $mangoPayApi->PayIns->Create($PayIn);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PayInCardDirect"] = $result->Id;
if ($result->ExecutionDetails->SecureModeNeeded && $result->Status!=\MangoPay\PayInStatus::Failed) {
	$nextButton = array("url"=>$result->ExecutionDetails->SecureModeRedirectURL, "text"=>"Go to 3DS payment page");
}
