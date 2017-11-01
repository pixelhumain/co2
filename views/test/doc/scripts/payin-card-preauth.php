<?php
$PayIn = new \MangoPay\PayIn();
$PayIn->CreditedWalletId = $_SESSION["MangoPayDemo"]["WalletForNaturalUser"];
$PayIn->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$PayIn->PaymentType = \MangoPay\PayInPaymentType::Card;
$PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPreAuthorized();
$PayIn->PaymentDetails->PreauthorizationId = $_SESSION["MangoPayDemo"]["PreAuth"];
$PayIn->DebitedFunds = new \MangoPay\Money();
$PayIn->DebitedFunds->Currency = "EUR";
$PayIn->DebitedFunds->Amount = 950;
$PayIn->Fees = new \MangoPay\Money();
$PayIn->Fees->Currency = "EUR";
$PayIn->Fees->Amount = 550;
$PayIn->ExecutionType = \MangoPay\PayInExecutionType::Direct;
$PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
$result = $mangoPayApi->PayIns->Create($PayIn);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PayInCardPreAuth"] = $result->Id;