<?php
$cs = Yii::app()->getClientScript(); 
$cssAnsScriptFilesTheme = array(
	//SELECT2
	'/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css',
	'/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js' , 
	'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
  	'/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js' ,
);
//if ($type == Project::COLLECTION)
//	array_push($cssAnsScriptFilesTheme, "/assets/plugins/Chart.js/Chart.min.js");
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
<div id="notifications-settings" class="contain-section-params col-xs-12">
	<div class="settings-header">
		<h4 class="title"><i class="fa fa-bell"></i> <?php echo Yii::t("settings", "Settings of notifications system linked to your user account") ?></h4>
	</div>
	<div class="open-block col-xs-12 no-padding">
		<a href="javascript:;" class="btn-show-block col-xs-12">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-min.png" width="25" height="20"/> <span><?php echo Yii::t("settings", "on communecter") ?></span>
			<span class="hover-line pull-right text-azure"><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "edit") ?> </span>
		</a>
	</div>
	<div class="show-block col-xs-12">
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-envelope-o"></i> <?php echo Yii::t("settings", "Invitation to join an organization, a project or an event") ?></label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="invite" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-check"></i> <?php echo Yii::t("settings", "Confirmation to be part of an organization, a project or an event") ?></label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="confirm" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-rss"></i> <?php echo Yii::t("settings", "You have a new followers") ?></label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="follow" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-at"></i> <?php echo Yii::t("settings", "Mentions of you in comments and news") ?></label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="mention" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-newspaper-o"></i> <?php echo Yii::t("settings", "Someone writes a news on your wall") ?></label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="add" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-thumbs-up"></i> <?php echo Yii::t("settings", "Activity on one of your news (Comment/Like/Unlike)") ?></label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="comment,like,unlike" checked="false" class="BSswitch">
		</div>
		<!--<div class="col-xs-12 padding-5 notification-label">
			<label><?php echo Yii::t("settings", "Someone comments one of your news or answers to your comment") ?></label>
			<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-width="50" d4ta-height="15" dat0-onstyle="success" data-on=" " data-off=" ">
		</div>-->
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-user-plus"></i> <?php echo Yii::t("settings", "Registration of people you invited") ?></label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="register" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-comments"></i> <?php echo Yii::t("settings", "Message about one of your classified or a ressource") ?></label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="contact" checked="false" class="BSswitch">
		</div>
	</div>
</div>
<div id="mails-settings" class="contain-section-params col-xs-12">
	<div class="open-block col-xs-12 no-padding">
		<a href="javascript:;" class="btn-show-block col-xs-12" data-name="mymails">
			<i class="fa fa-envelope"></i> <span><?php echo Yii::t("settings", "Alert by mail") ?></span>
			<span class="hover-line pull-right text-azure"><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "edit") ?> </span>
		</a>
	</div>
	<div class="show-block col-xs-12">
		<span class="col-xs-12 text-center">
			<i class="fa fa-info-circle"></i><br/><?php echo Yii::t("settings","Be free to desactivate all your notifications about activity on your user account or set it <b>by level</b>.") ?><br/>
            <?php echo Yii::t("settings","Find <b>all options</b> linked to </b>its level</b>.<br/> Of course, <b>higher</b> level <b>includes</b> options of <b>lower</b> level of notications.") ?><br/>
		</span>
		<hr>
		<div class="dropdown no-padding col-xs-12 margin-bottom-20 margin-top-20">
			<a data-toggle="dropdown" class="btn btn-default col-md-12 col-sm-12 col-xs-12 dropdown-settings" href="javascript:;">
				<span class="changeValueDrop"><?php echo Yii::t("settings", "By default") ?></span> <i class="fa fa-caret-down" style="font-size:inherit;"></i>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li>
					<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="desactivated" data-type="<?php echo Person::COLLECTION ?>" data-id="<?php echo Yii::app()->session["userId"] ?>">
						<h4 class="list-group-item-heading"><i class="fa fa-ban"></i> <?php echo Yii::t("settings", "Desactivated") ?></h4>
                        <p class="list-group-item-text small"><?php echo Yii::t("settings", "Desactivate all email notifications about your account activity") ?></p>
						
					</a>
				</li>
				<li>
					<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="low" data-type="<?php echo Person::COLLECTION ?>" data-id="<?php echo Yii::app()->session["userId"] ?>">
						<h4 class="list-group-item-heading"><i class="fa fa-ban"></i> <?php echo Yii::t("settings", "Low") ?></h4>
                        <p class="list-group-item-text small"><?php echo Yii::t("settings", "Get minimum of notifications by email") ?></p>
					</a>
				</li>
				<li>
					<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="default" data-type="<?php echo Person::COLLECTION ?>" data-id="<?php echo Yii::app()->session["userId"] ?>">
						<h4 class="list-group-item-heading"><i class="fa fa-ban"></i> <?php echo Yii::t("settings", "By default") ?></h4>
                        <p class="list-group-item-text small"><?php echo Yii::t("settings", "Basic package of notifications") ?></p>
					</a>
				</li>
				<li>
					<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="high" data-type="<?php echo Person::COLLECTION ?>" data-id="<?php echo Yii::app()->session["userId"] ?>">
						<h4 class="list-group-item-heading"><i class="fa fa-ban"></i> <?php echo Yii::t("settings", "High") ?></h4>
                        <p class="list-group-item-text small"><?php echo Yii::t("settings", "Keep connect to all activities linked to your user account") ?></p>
					</a>
				</li>
			</ul>
        </div>
        <hr>
        <div class="col-xs-12 text-center padding-10" 
						 style="border: 1px solid rgba(128, 128, 128, 0.3); margin: 10px;">
        <h5><i class="fa fa-angle-down"></i> <?php echo Yii::t("settings", "Low")?>:</h5>
        <small>
        <i class="fa fa-envelope-o" style="width:20px;"></i> <b><?php echo Yii::t("settings","Invitation to join an organization, a project or an event")?></b><br>
        <i class="fa fa-check" style="width:20px;"></i> <b><?php echo Yii::t("settings","Confirmation to be part of an organization, a project or an event")?></b><br>
        <i class="fa fa-comment" style="width:20px;"></i> <b><?php echo Yii::t("settings","Message for classified or ressource") ?></b><br>
        </small>
        <hr>
        <h5><i class="fa fa-angle-down"></i> <?php echo Yii::t("settings", "By default")?>:</h5>
        <small>
        <i class="fa fa-newspaper-o" style="width:20px;"></i> <b><?php echo Yii::t("settings","Someone writes a news on your wall")?></b><br>
        <i class="fa fa-thumbs-up" style="width:20px;"></i> <b><?php echo Yii::t("settings","Activity on your post (comment, like, unlike)")?></b><br>
        <i class="fa fa-at" style="width:20px;"></i> <b><?php echo Yii::t("settings","Mentions of you in comments and news") ?></b><br>
        <i class="fa fa-rss" style="width:20px;"></i> <b><?php echo Yii::t("settings","You have a new followers") ?></b><br>
        </small>
        <hr>
        <h5><i class="fa fa-angle-down"></i> <?php echo Yii::t("settings", "High")?>:</h5>
        <small>
        <i class="fa fa-user-plus" style="width:20px;"></i> <b><?php echo Yii::t("settings","Registration of people you invited")?></b><br>
        </small>
        </div>
    </div>
</div>
<script type="text/javascript">
var preferences=<?php echo json_encode(@$preferences) ?>;
jQuery(document).ready(function() {
	settings.initNotificationsAccount(preferences);
	settings.bindEventsSettings();
});
</script>