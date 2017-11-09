<?php
//require_once '../../pixelhumain/ph/vendor/autoload.php';
require_once '../../modules/co2/views/test/doc/inc/mockStorage.php';

define("MangoPayAPIClientId", empty(Yii::app()->params["mangoPay"]["ClientId"]) ? "demo" : Yii::app()->params["mangoPay"]["ClientId"]);
define("MangoPayAPIPassword", empty(Yii::app()->params["mangoPay"]["ClientPassword"]) ? "SRbaqf9kwpjOxAYtE9tVFVBWAh2waeF7TX4TEcZ4jVFKbm1uaD" : Yii::app()->params["mangoPay"]["ClientPassword"]);

$mangoPayApi = new \MangoPay\MangoPayApi();
$mangoPayApi->Config->ClientId = MangoPayAPIClientId;
$mangoPayApi->Config->ClientPassword = MangoPayAPIPassword;
//$mangoPayApi->Config->TemporaryFolder = __dir__;
$mangoPayApi->OAuthTokenManager->RegisterCustomStorageStrategy(new \MangoPay\DemoWorkflow\MockStorageStrategy());