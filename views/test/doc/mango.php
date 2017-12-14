<?php
if (!isset($_SESSION["MangoPayDemo"])) $_SESSION["MangoPayDemo"] = array();
if (!isset($_SESSION["MangoPayDemoConfig"])) $_SESSION["MangoPayDemoConfig"] = array();
require_once("inc/config.php");

$stepId = isset($_GET["stepId"]) ? (int) $_GET["stepId"] : 0;
$steps = array();
$steps[] = array("step"=>"Welcome", "file"=>"intro.php", "docsLink"=>"");
$steps[] = array("step"=>"Setup Client credentials", "file"=>"client.php", "docsLink"=>"sandbox-credentials/");
$steps[] = array("step"=>"Create Natural User", "file"=>"user-create-natural.php", "docsLink"=>"users/natural-users/");
$steps[] = array("step"=>"Create Wallet for Natural User", "file"=>"wallet-create.php", "docsLink"=>"wallets/");
$steps[] = array("step"=>"Create Legal User", "file"=>"user-create-legal.php", "docsLink"=>"users/legal-users/");
$steps[] = array("step"=>"Create Wallet for Legal User", "file"=>"wallet-create2.php", "docsLink"=>"wallets/");
$steps[] = array("step"=>"Create PayIn Card Web", "file"=>"payin-card-web.php", "docsLink"=>"payins/payins-card-web/");
$steps[] = array("step"=>"Review PayIn Card Web", "file"=>"payin-card-web-review.php", "checkResult"=>true, "docsLink"=>"payins/");
$steps[] = array("step"=>"Create Card Registration", "file"=>"card-reg.php", "docsLink"=>"card-registration/");
$steps[] = array("step"=>"Finish Card Registration", "file"=>"card-reg-put.php", "checkResult"=>true, "docsLink"=>"card-registration/");
$steps[] = array("step"=>"Do PayIn Card Direct", "file"=>"payin-card-direct.php", "checkResult"=>true, "docsLink"=>"payins/payindirectcard/");
$steps[] = array("step"=>"Setup a PreAuth", "file"=>"preauth.php", "checkResult"=>true, "docsLink"=>"card/pre-authorization/");
$steps[] = array("step"=>"Do a PayIn PreAuth", "file"=>"payin-card-preauth.php", "checkResult"=>true, "docsLink"=>"payins/preauthorized-payin/");
$steps[] = array("step"=>"Do a PayIn Refund", "file"=>"refund-payin.php", "checkResult"=>true, "docsLink"=>"refund/%e2%80%a2-refund-a-pay-in/");
$steps[] = array("step"=>"Do a Transfer", "file"=>"transfer.php", "checkResult"=>true, "docsLink"=>"transfers/");
$steps[] = array("step"=>"Create a Bank Account (of IBAN type)", "file"=>"bankaccount.php", "docsLink"=>"bank-accounts/");
$steps[] = array("step"=>"Do a PayOut", "file"=>"payout.php", "docsLink"=>"pay-out-bank-wire/");
$steps[] = array("step"=>"Submit a KYC Document", "file"=>"kyc.php", "docsLink"=>"kyc/");
$steps[] = array("step"=>"Do a Transfer Refund", "file"=>"refund-transfer.php", "checkResult"=>true, "docsLink"=>"refund/%e2%80%a2-refund-a-transfer/");
$steps[] = array("step"=>"Finished", "file"=>"end.php", "docsLink"=>"");

$totalStepsIndex = count($steps)-1;

if (isset($_POST["SetUpClientCreds"])) {
	Yii::app()->params["mangoPay"]["ClientId"] = $_POST["ClientId"];
	Yii::app()->params["mangoPay"]["ClientPassword"] = $_POST["Password"];
	header("Location: index.php?stepId=".($stepId+1));	
	die();
}

function pre_dump($r) {
	echo "<pre>";
		var_dump($r);
	echo "</pre>";
}

function getDemoScript($stepId) {
	global $steps;
	$script = explode("//Display",file_get_contents("../../modules/co2/views/test/doc/scripts/".$steps[$stepId]["file"]));
	//return htmlentities(trim(str_replace("<?php","",$script[0])));
	return trim(str_replace("<?php","",$script[0]));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>MANGOPAY Demo workflow</title>
        <link href="//fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet" type="text/css"> 
        <link href="style.css" rel="stylesheet" type="text/css"> 
		<link href="syntaxhighlighter/shThemeDefault.css" rel="stylesheet" type="text/css" />
        <style>
            .flyer span {
            	width:<?php echo ceil(100*$stepId/$totalStepsIndex); $startFrom = ceil(100*$stepId/($totalStepsIndex+1)); ?>%;
            }
            @-webkit-keyframes progressBar {
			    from { width: <?php echo $startFrom; ?>%; }
			}
			@keyframes progressBar {
			    from { width: <?php echo $startFrom; ?>%; }
			}
			@-moz-keyframes progressBar {
			    from { width: <?php echo $startFrom; ?>%; }
			}
        </style>
        <script type="text/javascript" src="syntaxhighlighter/shCore.js"></script>
		<script type="text/javascript" src="syntaxhighlighter/shBrushPhp.js"></script>
		<script>SyntaxHighlighter.defaults['toolbar'] = false;SyntaxHighlighter.defaults['auto-links'] = false;SyntaxHighlighter.defaults['gutter'] = false;SyntaxHighlighter.all();</script>
    </head>
    <body>
    	<div id="loading"><div></div></div>
    	<div id="main">
    		<div class="header"></div>
    		<div class="container">    			
<?php
if (empty($_SESSION["MangoPayDemo"]) && $stepId>2) {
	echo "<br><div class='notice'>The demo has either been finished or has timed out - please <a href='index.php'>start again</a></div><br>";
	
}elseif (in_array($stepId, array_keys($steps))) {
	?>
	<div class="flyer"><span></span></div>
	
	<a href="https://docs.mangopay.com/api-references/<?php echo $steps[$stepId]["docsLink"]; ?>" class="next docs" target="_blank"><?php echo $steps[$stepId]["docsLink"] ? "View docs for this method" : "View full docs"; ?></a>
	
	<h1><?php echo $steps[$stepId]["step"]; ?></h1>
	
	<div class="containerInner">
	<?php 
	$apiError = false;
	try {
		if ($stepId>1 && $stepId<$totalStepsIndex) {
			echo "<h2>Code example</h2>";
			//echo "<pre class='script'>".getDemoScript($stepId)."</pre>";
			echo "<script type='syntaxhighlighter' class='brush:php'><![CDATA[".getDemoScript($stepId)."]]></script>";
			echo "<br>";
			echo "<h2>Returned object</h2>";
		}
		include("scripts/".$steps[$stepId]["file"]); 
		
	} catch (MangoPay\Libraries\ResponseException $e) {
    	$apiError = true;
	    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
	    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
	    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
	    
	} catch (MangoPay\Libraries\Exception $e) {
	    $apiError = true;
	    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
	}
	?>
	
	<?php 
	if ($apiError) {
		echo "<div class='notice'>The API call failed :-(</div>";
	}else{
		if (isset($extraInfo)) {
			echo "<div class='notice helper'>$extraInfo</div>";
		}
		if (isset($nextButton)) {
			if (isset($nextButton["url"])) echo "<a href='".$nextButton["url"]."' class='next customButton' onclick='addActive(this)'>".$nextButton["text"]."</a>";
		}elseif (isset($steps[$stepId]["checkResult"]) && !in_array($result->Status, array("VALIDATED", "SUCCEEDED"))) {
			echo "<div class='notice'>The previous call is <i>".$result->Status."</i> beacuse of <i>".$result->ResultMessage."</i> so you can not carry on with the demo</div>";
		}elseif ($stepId<$totalStepsIndex) { 
			echo "<a href='index.php?stepId=".($stepId+1)."' class='next' onclick='addActive(this)'>Next: ".$steps[$stepId+1]["step"]."</a>";
		}
	}		
	?>
	<div class="clear"></div>
	</div>
	<?php
}else{
	echo "Unknown step requested";
}

?>
</div>
</div>
<script>
	function addActive(what) {
		what.className = what.className + " clicked";
		var d = document.getElementById("loading");
		d.className = d.className + " active";
		var m = document.getElementById("main");
		m.className = m.className + " clicked";
	}
	function toggle(id) {
		var what = document.getElementById(id);
		what.style.display = what.style.display === 'none' ? '' : 'none';
	}
</script>
</body>
</html>