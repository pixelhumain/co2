<?php
$cardRegister = new \MangoPay\CardRegistration();
$cardRegister->UserId = $_SESSION["MangoPayDemo"]["UserNatural"];
$cardRegister->Currency = "EUR";
$result = $mangoPayApi->CardRegistrations->Create($cardRegister);

//Display result
pre_dump($result);
		?>
		<br>
		<form action="<?php echo $result->CardRegistrationURL; ?>" method="post">	
			<input type="hidden" name="data" value="<?php echo $result->PreregistrationData; ?>" />
   			<input type="hidden" name="accessKeyRef" value="<?php echo $result->AccessKey; ?>" />
    		<input type="hidden" name="returnURL" value="<?php echo "http".(isset($_SERVER['HTTPS']) ? "s" : null)."://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."?stepId=".($stepId+1); ?>" />
    		<table>
    			<tr>
    				<th>Card number:</th>
    				<td><input type="text" name="cardNumber" size="20" maxlength="30" value="4970100000000154"></td>
    			</tr>
    			<tr>
    				<th>Expiry date:</th>
    				<td><input type="text" name="cardExpirationDate" maxlength="4" size="4" placeholder="MMYY" value="1217"></td>
    			</tr>
    			<tr>
    				<th>CVV:</th>
    				<td><input type="text" name="cardCvx" size="3" maxlength="5"  value="123"></td>
    			</tr>
    		</table>
 	<input type="submit" value="Next: <?php echo $steps[$stepId+1]["step"]; ?>" class="next" onclick="addActive(this)">
		</form>
		
<?php
	$_SESSION["MangoPayDemo"]["CardReg"] = $result->Id;
	$nextButton=array();