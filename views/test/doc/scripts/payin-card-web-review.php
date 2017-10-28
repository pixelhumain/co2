<?php
$result = $mangoPayApi->PayIns->Get($_SESSION["MangoPayDemo"]["PayInCardWeb"]);

//Display result
pre_dump($result);