This demo will take you through a "typical" workflow of creating Users, doing PayIns, transfering from one Wallet to another and then doing a PayOut. You are of course free to design any workflow you like though! Some very basic examples of the SDK are shown for each example. This is the full program:<br>
<ul>
<?php
	foreach($steps as $i=>$s) {
		$showingScript = $i>1 && $i<$totalStepsIndex;
		if ($i>0) {
			echo "<li>";
				echo $showingScript ? "<a href=\"javascript:toggle('step_script_$i')\" title=\"View demo script\">".$s["step"]."</a>" : $s["step"];
				if ($showingScript) echo "<div id='step_script_$i' style='display:none'><script type='syntaxhighlighter' class='brush:php'><![CDATA[".getDemoScript($i)."]]></script></div>";
			echo "</li>";
		}
	}
?>
</ul>
<br>
For each example given in this demo, you'll also need to include the PHP SDK, and initiate the API call:
<script type='syntaxhighlighter' class='brush:php'><![CDATA[
require_once '../../vendor/autoload.php';
$mangoPayApi = new \MangoPay\MangoPayApi();
$mangoPayApi->Config->ClientId = YourMangoPayAPIClientId;
$mangoPayApi->Config->ClientPassword = YourMangoPayAPIPassword;
$mangoPayApi->Config->TemporaryFolder = /a/writable/folder/somewhere/ideally-out-of-reach-of-your-root/;
]]>
</script>
<br>
Do not use the "Back" button in your browser, or "Refresh" at any point, otherwise you risk breaking this very basic demo :-)
