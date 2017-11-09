<?php
//create the doc
$KycDocument = new \MangoPay\KycDocument();
$KycDocument->Type = "IDENTITY_PROOF";
$result = $mangoPayApi->Users->CreateKycDocument($_SESSION["MangoPayDemo"]["UserNatural"], $KycDocument);
$KycDocumentId = $result->Id;

//add a page to this doc
$result2 = $mangoPayApi->Users->CreateKycPageFromFile($_SESSION["MangoPayDemo"]["UserNatural"], $KycDocumentId, "logo.png");

//submit the doc for validation
$KycDocument = new MangoPay\KycDocument();
$KycDocument->Id = $KycDocumentId;
$KycDocument->Status = \MangoPay\KycDocumentStatus::ValidationAsked;
$result3 = $mangoPayApi->Users->UpdateKycDocument($_SESSION["MangoPayDemo"]["UserNatural"], $KycDocument);


//Display result
pre_dump($result3);

$_SESSION["MangoPayDemo"]["KYC"] = $KycDocumentId;
