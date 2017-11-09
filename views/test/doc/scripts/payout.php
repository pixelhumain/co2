<?php
$PayOut = new \MangoPay\PayOut();
$PayOut->AuthorId = $_SESSION["MangoPayDemo"]["UserLegal"];
$PayOut->DebitedWalletId = $_SESSION["MangoPayDemo"]["WalletForLegalUser"];
$PayOut->DebitedFunds = new \MangoPay\Money();
$PayOut->DebitedFunds->Currency = "EUR";
$PayOut->DebitedFunds->Amount = 610;
$PayOut->Fees = new \MangoPay\Money();
$PayOut->Fees->Currency = "EUR";
$PayOut->Fees->Amount = 125;
$PayOut->PaymentType = \MangoPay\PayOutPaymentType::BankWire;
$PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
$PayOut->MeanOfPaymentDetails->BankAccountId = $_SESSION["MangoPayDemo"]["BankAccount"];
$result = $mangoPayApi->PayOuts->Create($PayOut);

//Display result
pre_dump($result);

$_SESSION["MangoPayDemo"]["PayOut"] = $result->Id;
