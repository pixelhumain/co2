<?php
$User = new MangoPay\UserNatural();
$User->Email = "test_natural@testmangopay.com";
$User->FirstName = "Bob";
$User->LastName = "Briant";
$User->Birthday = 121271;
$User->Nationality = "FR";
$User->CountryOfResidence = "ZA";
$result = $mangoPayApi->Users->Create($User);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["UserNatural"] = $result->Id;