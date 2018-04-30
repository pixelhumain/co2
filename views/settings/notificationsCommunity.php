<?php
$cs = Yii::app()->getClientScript(); 
$cssAnsScriptFilesTheme = array(
	//SELECT2
	'/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css',
	'/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js' , 
	'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
  	'/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js' ,
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);    
?>
<style>
	

</style>
<div id="community-settings" class="contain-section-params col-xs-12 no-padding">
    <div class="settingsHeader bg-white no-padding">
     	<div class="settings-header">
    		<h4 class="title"><i class="fa fa-bell"></i> <?php echo Yii::t("settings", "Settings of notifications system linked to your user account") ?></h4>
    	</div>
    	<div id="settingsScrollByType" class="pull-left"></div>
    		<a href="javascript:;" id="btnSettingsInfos" class="text-dark pull-right margin-right-20"><i class="fa fa-info-circle"></i> <span class="hidden-xs"> All infos</span></a>
    	<input type="text" id="search-in-settings" class="form-control" placeholder="<?php echo Yii::t("common","Search name, slug, postal code, city ...") ?>">
    </div>
    <div id="community-settings-list"></div>
</div>
<div class="modal fade" role="dialog" id="modalExplainSettings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green text-white">
                <h4 class="modal-title"><i class="fa fa-check"></i> <?php echo Yii::t("login","New email validation succesfully sent !!") ?></h4>
            </div>
            <div class="modal-body center text-dark hidden" id="modalSendAgainSuccessContent"></div>
            <div class="modal-body center text-dark">
                <h4 class="letter-green no-margin"><i class="fa fa-check-circle"></i> <?php echo Yii::t("login","Confirm your email address")?></h4>
                <h4 class="no-margin">
                    <small><?php echo Yii::t("login","in order to attain your account") ?></small>
                </h4>
                <small class="no-margin">
                    <i class="fa fa-lock"></i> <?php echo Yii::t("login","For security reasons, you have to comfirm your email address to be connected") ?>.
                </small>
                <br><br>
                <h5><i class="fa fa-angle-down"></i> <?php echo Yii::t("login", "How can it be done")?> ?</h5>
                <i class="fa fa-envelope-open" style="width:20px;"></i> <b><?php echo Yii::t("login","Verify your emails and your spams") ?></b><br>
                <i class="fa fa-hand-o-up" style="width:20px;"></i> <b><?php echo Yii::t("login","Click on the activating link") ?></b> <?php echo Yii::t("login","which we sent to you") ?>.</br>
                <hr>
                <i class="fa fa-unlock" style="width:20px;"></i> <?php echo Yii::t("login","You will be <b class='letter-green'>automatically connected</b> and redirect on your page") ?>.
                    
            </div>
            <div class="modal-footer">
            <!--data-dismiss="modal"-->
                 <button type="button" class="btn btn-default letter-green"><i class="fa fa-check"></i> <?php Yii::t("login","I understand") ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	settings.getCommunitySettings("notifications");
});
</script>