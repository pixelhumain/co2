<?php
$PayInId = $_SESSION["MangoPayDemo"]["PayInCardWeb"];
$Refund = new \MangoPay\Refund();
$Refund->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$Refund->DebitedFunds = new \MangoPay\Money();
$Refund->DebitedFunds->Currency = "EUR";
$Refund->DebitedFunds->Amount = 650;
$Refund->Fees = new \MangoPay\Money();
$Refund->Fees->Currency = "EUR";
$Refund->Fees->Amount = -50;
$result = $mangoPayApi->PayIns->CreateRefund($PayInId, $Refund);

//Display result
pre_dump($result);

$_SESSION["MangoPayDemo"]["Refund"] = $result->Id;