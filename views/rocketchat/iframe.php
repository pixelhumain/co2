<?php if ( !@$iframeOnly ){ ?>
<!DOCTYPE html>
<html>
	<body>
<?php } ?>

<?php 
if ( @Yii::app()->session["userId"] ){ 
$embedPath = (@$embed) ? $path."?layout=embedded" : "" ;
?>

	
<script type="text/javascript">
	window.addEventListener('message', function(e) {
	    console.log(e.data.eventName); // event name
	    console.log(e.data.data); // event data

		if(e.data.eventName==="startup" && e.data.data=== true){

			document.querySelector('iframe').contentWindow.postMessage({
			  externalCommand: 'login-with-token',
			  token: '<?php echo Yii::app()->session["loginToken"]; ?>' }, '*');

			<?php if ( @$path ) { ?>
				document.querySelector('iframe').contentWindow.postMessage({
				  externalCommand: 'go',
				  path: '<?php echo $path ?>'}, '*');
			<?php } ?>

		}
	});
</script>


<iframe id="rc" src="https://chat.communecter.org<?php echo $embedPath ?>" frameborder="0" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:80%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="600px" width="100%" onload="toastr.info('iframe loaded!');"></iframe>


<?php 
} else 
	echo Yii::t('common',"Access denied") ?>



<?php if ( !@$iframeOnly ){ ?>
	</body>
</html>
<?php } ?>