To run these examples, we need a ClientId and Password. You can either provide your own below (that you created for the Sandbox environment or <a href="https://docs.mangopay.com/api-references/sandbox-credentials/" target="_blank">get one here</a>), or you can just use the demo ones below if you prefer.<br><br>

<form method="post">
	<input type="hidden" name="SetUpClientCreds" />
	<table>
		<tr>
			<th>ClientId</th>
			<td><input type="text" name="ClientId" value="<?php echo MangoPayAPIClientId; ?>" /></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input type="text" name="Password" value="<?php echo MangoPayAPIPassword; ?>" /></td>
		</tr>
	</table>
	<input type="submit" value="Next: <?php echo $steps[$stepId+1]["step"]; ?>" class="next" onclick="addActive(this)">
</form>
<?php $nextButton=array(); ?>