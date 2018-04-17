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
	<div class="open-block col-xs-12 no-padding">
		<a href="javascript:;" class="btn-show-block col-xs-12">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-min.png" width="25" height="20"/> <span>on communecter</span>
			<span class="hover-line pull-right text-azure"><i class="fa fa-pencil"></i> edit </span>
		</a>
	</div>
	<div class="show-block col-xs-12">
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-envelope-o"></i> Invitation to join an organization, a project or an event</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="invite" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-check"></i> Confirmation to be part of an organization, a project or an event</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="confirm" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-rss"></i> You have a new followers</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="follow" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-at"></i> Mentions of you in comments and news</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="mention" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-newspaper-o"></i> Someone writes a news on your wall</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="add" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-thumbs-up"></i> Activity on one of your news (Comment/Like/Unlike)</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="comment,like,unlike" checked="false" class="BSswitch">
		</div>
		<!--<div class="col-xs-12 padding-5 notification-label">
			<label>Someone comments one of your news or answers to your comment</label>
			<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-width="50" d4ta-height="15" dat0-onstyle="success" data-on=" " data-off=" ">
		</div>-->
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-user-plus"></i> Registration of people you invited</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="register" checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-comments"></i> Message about one of your classified or a ressource</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " data-sub="contact" checked="false" class="BSswitch">
		</div>
	</div>
</div>
<div id="mails-settings" class="contain-section-params col-xs-12">
	<div class="open-block col-xs-12 no-padding">
		<a href="javascript:;" class="btn-show-block col-xs-12" data-name="mymails">
			<i class="fa fa-envelope"></i> <span>Alert by mail</span>
			<span class="hover-line pull-right text-azure"><i class="fa fa-pencil"></i> edit </span>
		</a>
	</div>
	<div class="show-block col-xs-12">
		<span>
			Veuillez régler vos préférences d'alertes mail, vous trouverez les différentes options possibles et la description des alertes choisies par niveau
		</span>
		<div class="dropdown no-padding col-xs-12 margin-bottom-20">
			<a data-toggle="dropdown" class="btn btn-default col-md-12 col-sm-12 col-xs-12 dropdown-settings" href="javascript:;">
				<span class="changeValueDrop">By default</span> <i class="fa fa-caret-down" style="font-size:inherit;"></i>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li>
					<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="desactivated" data-type="<?php echo Person::COLLECTION ?>" data-id="<?php echo Yii::app()->session["userId"] ?>">
						Desactivated
					</a>
				</li>
				<li>
					<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="low" data-type="<?php echo Person::COLLECTION ?>" data-id="<?php echo Yii::app()->session["userId"] ?>">
						Low
					</a>
				</li>
				<li>
					<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="default" data-type="<?php echo Person::COLLECTION ?>" data-id="<?php echo Yii::app()->session["userId"] ?>">
						By default
					</a>
				</li>
				<li>
					<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="high" data-type="<?php echo Person::COLLECTION ?>" data-id="<?php echo Yii::app()->session["userId"] ?>">
						High
					</a>
				</li>
			</ul>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	bindEventsSettings();
});
</script>