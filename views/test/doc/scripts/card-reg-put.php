<?php
$cardRegisterPut = $mangoPayApi->CardRegistrations->Get($_SESSION["MangoPayDemo"]["CardReg"]);
$cardRegisterPut->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];
$result = $mangoPayApi->CardRegistrations->Update($cardRegisterPut);

//Display result
pre_dump($result);

$extraInfo = "Remember that you have 30 minutes to either do a PayIn Direct or setup a PreAuth with this card, otherwise it will become unsuable";
$_SESSION["MangoPayDemo"]["Card"] = $result->CardId;