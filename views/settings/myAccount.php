<?php
$cs = Yii::app()->getClientScript(); 
// $cssAnsScriptFilesTheme = array(
// 	//SELECT2
// 	'/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css',
// 	'/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js' , 
// 	'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
//   	'/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js' ,
// );
//if ($type == Project::COLLECTION)
//	array_push($cssAnsScriptFilesTheme, "/assets/plugins/Chart.js/Chart.min.js");
//HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
$cssAnsScriptFiles = array(
     '/assets/css/default/settings.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl); 

    
$cssAnsScriptFilesModule = array(
    '/js/default/settings.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

?>
<div id="myAccount-settings" class="contain-section-params col-xs-12">
	<div class="settings-header text-center">
		<h3 class="title"><i class="fa fa-user-circle "></i> <?php echo Yii::t("settings", "My Account") ?></h3>
	</div>
	<div class="col-xs-12 no-padding">
		<h4 style="text-transform: none;" ><i class="fa fa-unlock-alt  "></i> <?php echo Yii::t("common","Change password"); ?> <a href="javascript:;" id="btn-update-password-setting" class="btn btn-success btn-sm"> <i class="fa fa-pencil "></i> </a> </h4>
	</div>

	<div class="block-account col-xs-12 no-padding">
		<h4 style="text-transform: none;"><i class="fa fa-id-badge"></i> <?php echo Yii::t("common", "Edit slug"); ?> <a href="javascript:;" onclick="updateSlug();" id="" class="btn btn-success btn-sm"> <i class="fa fa-pencil "></i> </a></h4>
	</div>

	<div class="block-account col-xs-12 no-padding">
		<h4 style="text-transform: none;"><i class='fa fa-download'></i> <?php echo Yii::t("common", "Download your profil") ?> <a href="javascript:;" id="downloadProfil-setting" class="btn btn-success btn-sm"> <i class="fa fa-pencil "></i> </a> </h4>
	</div>


	<?php 
	if ( Authorisation::canDeleteElement( (String)$element["_id"], $type, Yii::app()->session["userId"]) && 
			//!@$deletePending && 
			!empty(Yii::app()->session["userId"]) ) {

			$this->renderPartial('../element/confirmDeleteModal', array("id" =>(String)$element["_id"], "type"=>$type));

	?>
	<div class="block-account col-xs-12 no-padding">
		<h4 style="text-transform: none;"><i class='fa fa-trash '></i> <?php echo "Supprimer mon compte"; ?> <a href="javascript:;" id="btn-delete-element-setting" class="btn btn-danger btn-sm"> <i class="fa fa-trash "></i> </a></h4>

<?php } ?>
</div>

<script type="text/javascript">
var element = <?php echo json_encode(@$element) ?>;
jQuery(document).ready(function() {
	settings.bindMyAccountSettings(element);
});
</script>