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
		margin-top: 133px !important;
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
<div class="settingsHeader bg-white no-padding">
 	<div class="settings-header">
		<h4 class="title"><i class="fa fa-bell"></i> <?php echo Yii::t("settings", "Confidentiality of your community data and edition") ?></h4>
	</div>
	<div id="settingsScrollByType" class="pull-left"></div>
		<a href="javascript:;" id="btnSettingsInfos" class="text-dark pull-right margin-right-20"><i class="fa fa-info-circle"></i> <span class="hidden-xs"> All infos</span></a>
	<input type="text" id="search-in-settings" class="form-control" placeholder="<?php echo Yii::t("common","Search name, slug, postal code, city ...") ?>">
</div>
<div id="community-settings-list"></div>
</div>
<div id="modalConfidentialityCommunity">
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	settings.getCommunitySettings("confidentiality");
});
</script>