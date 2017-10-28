<?php
$CardPreAuthorization = new \MangoPay\CardPreAuthorization();
$CardPreAuthorization->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$CardPreAuthorization->DebitedFunds = new \MangoPay\Money();
$CardPreAuthorization->DebitedFunds->Currency = "EUR";
$CardPreAuthorization->DebitedFunds->Amount = 1500;
$CardPreAuthorization->SecureMode = "DEFAULT";
$CardPreAuthorization->CardId = $_SESSION["MangoPayDemo"]["Card"];
$CardPreAuthorization->SecureModeReturnURL = "http".(isset($_SERVER['HTTPS']) ? "s" : null)."://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."?stepId=".($stepId+1);
$result = $mangoPayApi->CardPreAuthorizations->Create($CardPreAuthorization);


//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PreAuth"] = $result->Id;
if ($result->SecureModeNeeded && $result->Status!=\MangoPay\CardPreAuthorizationStatus::Failed) {
	$nextButton = array("url"=>$result->SecureModeRedirectURL, "text"=>"Go to 3DS payment page");
}
