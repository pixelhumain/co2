<?php
	$cssAnsScriptFilesTheme = array(
    	"/plugins/Chart-2.6.0/Chart.min.js"
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>

<h4>
	<?php echo @$title; ?><br>
	<small><?php echo @$subtitle; ?></small>
</h4>
<hr>