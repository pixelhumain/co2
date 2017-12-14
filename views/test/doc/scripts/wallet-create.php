<?php
$Wallet = new \MangoPay\Wallet();
$Wallet->Owners = array($_SESSION["MangoPayDemo"]["UserNatural"]);
$Wallet->Description = "Demo wallet for User 1";
$Wallet->Currency = "EUR";
$result = $mangoPayApi->Wallets->Create($Wallet);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["WalletForNaturalUser"] = $result->Id;