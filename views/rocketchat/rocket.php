<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function(event) { 

			// set token in parent window for use by RocketChat as part of login sequence
			window.parent.postMessage({ 
			event: 'login-with-token',
			loginToken: '<?php echo Yii::app()->session["loginToken"]; ?>'
			}, "https://chat.communecter.org");

		});
		</script>
	</head>


	<body>
		<div style="width:100%;text-align:center;padding-top:64px;">
		<h1 style="color:white">Checking Login</h1>
		<?php /* ?>
		<h4><?php echo $msg; ?></h4>
		*/ ?>
		</div>
	</body>
</html>