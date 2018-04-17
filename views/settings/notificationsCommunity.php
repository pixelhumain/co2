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

$cssAnsScriptFiles = array(
     '/assets/css/default/settings.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl); 

    
$cssAnsScriptFilesModule = array(
    '/js/default/settings.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


?>
<style>
	.settingsHeader{
		position: fixed;
	    top: 60px;
	    z-index: 100;
	    right: 5px;
    	left: 25%;
	}
	.scroll-container{
		background-color: white !important;
		border:none !important;
		margin-bottom: none !important;
	}
	#community-settings{
		margin-top: 80px !important;
	}
	.btn-scroll-type, #btnSettingsInfos{
		font-size: 18px;
    	font-variant: small-caps;
    	padding: 10px 20px;
	}
	#search-in-settings{
		border-radius: 0px;
	}
	.notification-label-communtiy .thumb-send-to {
	    border-radius: 50%;
	    padding: 3px;
	    margin-top: 7px;
	}
	#modalExplainSettings{
		top: 60px !important;
	}
	@media (max-width: 991px) {
	  .settingsHeader{
	     left: 0px;
		} 
	}
	@media (min-width: 991px) {
		#modalExplainSettings{
			left: 25% !important;
		}
	}

</style>
<div id="community-settings" class="contain-section-params col-xs-12 no-padding">
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
	getCommunitySettings();
});
</script>