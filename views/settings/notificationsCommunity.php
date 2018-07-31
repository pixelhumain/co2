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
    		<h4 class="title"><i class="fa fa-bell"></i> <?php echo Yii::t("settings", "Settings on your community's notifications") ?></h4>
    	</div>
    	<div id="settingsScrollByType" class="pull-left"></div>
    		<a href="javascript:;" id="btnSettingsInfos" class="text-dark pull-right margin-right-20"><i class="fa fa-info-circle"></i> <span class="hidden-xs"> <?php echo Yii::t("common", "Infos") ?></span></a>
    	<input type="text" id="search-in-settings" class="form-control" placeholder="<?php echo Yii::t("common","Search name, slug, postal code, city ...") ?>">
    </div>
    <div id="community-settings-list"></div>
</div>
<div class="modal fade" role="dialog" id="modalExplainSettings" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green text-white">
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> <?php echo Yii::t("settings","All informations about your community's notifications") ?></h4>
            </div>
            <div class="modal-body center text-dark hidden" id="modalSendAgainSuccessContent"></div>
            <div class="modal-body center text-dark">
                <h5 class="no-margin uppercase"><i class="fa fa-cogs"></i> <?php echo Yii::t("settings","You will set parameters of notifications you received about <b>activity on elements that you are connected : organizations, projects and events</b>")?></h5><br/>
                <span class="no-margin">
                    <b><?php echo Yii::t("common", "Notifications") ?>:</b> <small><?php echo Yii::t("settings", "Alerts you receive inside communecter") ?></small><br/>
                    <b><?php echo Yii::t("common", "Mails") ?>:</b> <small><?php echo Yii::t("settings", "Alerts you received on your email adress") ?></small><br/> 
                    <hr/>
                    <i class="fa fa-check"></i> <?php echo Yii::t("settings","Be free to desactivate all your notifications or set it <b>by level</b>") ?>.<br/>
                    <i class="fa fa-check"></i> <?php echo Yii::t("settings","Find <b>all options</b> linked to </b>its level</b>.<br/> Of course, <b>higher</b> level <b>includes</b> options of <b>lower</b> level of notifications") ?><br/>
                    <i class="fa fa-check"></i> <?php echo Yii::t("settings","Some options are only done for administrator of the community and will be indicated in the following list by <b>a status 'only admin'</b>") ?><br/>
                </span>
                <hr>
                <h5><i class="fa fa-angle-down"></i> <?php echo Yii::t("settings", "Low")?>:</h5><br/>
                <small>
                <i class="fa fa-gavel" style="width:20px;"></i> <b><?php echo Yii::t("settings","Demand to join the community of an element (only admin)")?></b><br>
                <i class="fa fa-at" style="width:20px;"></i> <b><?php echo Yii::t("settings","Mention in a comment or a news")?></b><br>
                <i class="fa fa-comment" style="width:20px;"></i> <b><?php echo Yii::t("settings","Message for classified or ressource") ?></b><br>
                </small>
                <hr>
                <h5><i class="fa fa-angle-down"></i> <?php echo Yii::t("settings", "By default")?>:</h5><br/>
                <small>
                <i class="fa fa-rss" style="width:20px;"></i> <b><?php echo Yii::t("settings","New post on a wall of an element")?></b><br>
                <i class="fa fa-thumbs-up" style="width:20px;"></i> <b><?php echo Yii::t("settings","Activity on a post and in the collaborative space (comment, like, unlike, vote)")?></b><br>
                <i class="fa fa-plus" style="width:20px;"></i> <b><?php echo Yii::t("settings","Adding of an event, a project, a ressources, etc.") ?></b><br>
                <i class="fa fa-link" style="width:20px;"></i> <b><?php echo Yii::t("settings","New followers on an element") ?></b><br>
                <i class="fa fa-gavel" style="width:20px;"></i> <b><?php echo Yii::t("settings","Activity on collaborative space : proposals, new rooms, actions, ammend and resolutions") ?></b><br>
                <i class="fa fa-camera" style="width:20px;"></i> <b><?php echo Yii::t("settings","Add in the library: photos, files, bookmarks, videos") ?></b><br>
                </small>
                <hr>
                <h5><i class="fa fa-angle-down"></i> <?php echo Yii::t("settings", "High")?>:</h5><br/>
                <small>
                <i class="fa fa-check-circle" style="width:20px;"></i> <b><?php echo Yii::t("settings","Demand has been validated by another")?></b><br>
                <i class="fa fa-envelope" style="width:20px;"></i> <b><?php echo Yii::t("settings","Invitation to join community has been sent")?></b><br>
                <i class="fa fa-share-alt" style="width:20px;"></i> <b><?php echo Yii::t("settings","Answer to an invitation") ?></b><br>
                <i class="fa fa-pencil" style="width:20px;"></i> <b><?php echo Yii::t("settings","Update of general informations") ?></b><br> 
                </small>    
            </div>
            <div class="modal-footer">
            <!--data-dismiss="modal"-->
                 <button type="button" class="btn btn-default"><i class="fa fa-times"></i> <?php echo Yii::t("common","Close") ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	settings.getCommunitySettings("notifications");
    if(searchInCommunity!=""){
        $("#search-in-settings").val(searchInCommunity);
        settings.filterSettingsCommunity(searchInCommunity);
    }
});
</script>