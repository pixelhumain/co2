All done :-)<br>
Why don't you check out this activity on the <a href="https://dashboard.sandbox.mangopay.com" target="_blank">Mangopay Dashboard</a> - you can use the following info:
<table>
	<tr>
		<th>ClientId:</th>
		<td><?php echo MangoPayAPIClientId; ?></td>
	</tr>
	<tr>
		<th>Email:</th>
		<td><?php echo MangoPayAPIClientId=="demo" ? "support@mangopay.com" : "(the one you used when creating your client)"; ?></td>
	</tr>
	<tr>
		<th>Password:</th>
		<td><?php echo MangoPayAPIClientId=="demo" ? "Mangopay1*" : "(the one you created when using the Dashboard for the first time)"; ?></td>
	</tr>
</table>
<br><br>

For your reference, here are the IDs you generated:<br><br>
<table>
<?php 
foreach($_SESSION["MangoPayDemo"] as $k=>$v) {
	echo "<tr>";
		echo "<th>".$k.":</th>";
		echo "<td>".$v."</td>";
	echo "</tr>";
}
unset($_SESSION["MangoPayDemo"]); ?>
</table>
<br><br>
<a href="index.php" class="next back">Want another go?</a>
