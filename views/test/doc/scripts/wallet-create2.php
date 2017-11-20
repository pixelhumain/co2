<?php
//Note that there is no difference between a Wallet for a Natural User and a Legal User
$Wallet = new \MangoPay\Wallet();
$Wallet->Owners = array($_SESSION["MangoPayDemo"]["UserLegal"]);
$Wallet->Description = "Demo wallet for User 2";
$Wallet->Currency = "EUR";
$result = $mangoPayApi->Wallets->Create($Wallet);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["WalletForLegalUser"] = $result->Id;