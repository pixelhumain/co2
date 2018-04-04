<?php
$cs = Yii::app()->getClientScript(); 
$cssAnsScriptFilesTheme = array(
	//SELECT2
	'/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css',
	'/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js' , 
);
//if ($type == Project::COLLECTION)
//	array_push($cssAnsScriptFilesTheme, "/assets/plugins/Chart.js/Chart.min.js");
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>
<style>
	td{padding:5px;}
	.panel-lines {
		padding:10px;

	}
	td, tr{
		text-align: center;
		text-align: -moz-center;
		text-align: -webkit-center;
	}
	.labelNotifications{
		
	}
</style>
<!--<div class="row">
	<div class="col-md-4 col-lg-4 col-sm-4">

		<div class="panel-lines col-md-12 col-sm-12 col-xs-12">
			<span class="labelNotifications">Actions on news (new one, comment, like, dislike)</span>
		</div>
		<div class="panel-lines col-md-12 col-sm-12 col-xs-12">
			<span class="labelNotifications">Comments (answer, like, dislike)</span>
		</div>
		<div class="panel-lines col-md-12 col-sm-12 col-xs-12">
			<span class="labelNotifications">New element (orga, project, event, poi)</span>
		</div>
		<div class="panel-lines col-md-12 col-sm-12 col-xs-12">
			<span class="labelNotifications">Needs published</span>
		</div>
		<div class="panel-lines col-md-12 col-sm-12 col-xs-12">
			<span class="labelNotifications">Discuss, survey, action (new room, new comment)</span>
		</div>
		<div class="panel-lines col-md-12 col-sm-12 col-xs-12">
			<span class="labelNotifications">Votes (new vote, alert before the end of votes, vote's result)</span>
		</div>
	</div>-->
<div class="col-xs-12">
	<h1>My account notifications settings</h1>
	<span> Manage notifications you want to received link to your user account. For your personal notifications inside the platform you can directly activate or desactivate what you want. You can also choose a personal mail notification packages. Of course you are free to desactivate all notifications</span>
</div>
<div id="notifications-settings" class="col-xs-12">
	<h2>Notifications:</h2>
	<div class="col-xs-12">
		<label>Someone invites you to join an organization, a project or an event</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>
	<div class="col-xs-12">
		<label>Someone confirms a demand you did in order to join an organization, a project or an event</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>
	<div class="col-xs-12">
		<label>Someone is following you</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>
	<div class="col-xs-12">
		<label>Someone mentions you in a news or a comment</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>
	<div class="col-xs-12">
		<label>Someone writes a news on your wall</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>
	<div class="col-xs-12">
		<label>Someone likes or unlikes one of your news</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>
	<div class="col-xs-12">
		<label>Someone comments one of your news or answers to your comment</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>
	<div class="col-xs-12">
		<label>Registration of people you invited</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>
	<div class="col-xs-12">
		<label>Someone contacts you about one of your classified or a ressource</label>
		<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="info">
	</div>

</div>
<!--<table>
	<th>
		<tr>
			<td></td><td colspan="2">Personal notifcations</td><td colspan="2">Network notifications</td><td colspan="2">Communected notifications</td>
		</tr>
		<tr>
			<td></td><td>Notifs</td><td>Mail</td><td>Notifs</td><td>Mail</td><td>Notifs</td><td>Mail</td>
		</tr>
		<tr id="news">
			<th class="labelNotifications">Actions on news (new one, comment, like, dislike)</th>
			<td>
				<input class="hide input-settings" name="notification" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
		</tr>
		<tr id="comments">
			<th class="labelNotifications">Comments (answer, like, dislike)</th>
			<td>
				<input class="hide input-settings" name="notification" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
		</tr>
		<tr id="elements">
			<th class="labelNotifications">New element (orga, project, event, poi)</th>
			<td>
				<input class="hide input-settings" name="notification" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
		</tr>
		<tr id="needs">
			<th class="labelNotifications">Needs published</th>
			<td>
				<input class="hide input-settings" name="notification" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
		</tr>
		<tr id="room">
			<th class="labelNotifications">Discuss, survey, action (new room, new comment)</th>
			<td>
				<input class="hide input-settings" name="notification" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
		</tr>
		<tr id="survey">
			<th class="labelNotifications">Votes (new vote, alert before the end of votes, vote's result)</th>
			<td>
				<input class="hide input-settings" name="notification" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="personal">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1" disabled>
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="network">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="notification" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
			<td>
				<input class="hide input-settings" name="mail" data-type="public">
				<input type="checkbox" name="my-checkbox" data-type="notification" data-size="mini" data-label-width="1" data-handle-width="1">
			</td>
		</tr>
	</th>
</table>-->
<script type="text/javascript">
/*defaultNotificationsSettings={
	"notification":{
		"personal":{
			"comments":true,
			"news":true
		},
		"network":{
			"news":true,
			"elements":true,
			"needs":true,
			"room":true,
			"survey":true
		},
		"admin":{
			"follow":true,
			"invite":true,
			"ask":true,
			"confirm":true
		},
		"city":{
			"needs":true,
			"room":true,
			"survey":true	
		}
	},
	"mail":{
		"personal":{
			"comments":true,
			"news":true
		},
		"network":{
			"news":true,
			"elements":true,
			"needs":true,
			"room":true,
			"survey":true
		},
		"admin":{
			"follow":true,
			"invite":true,
			"ask":true,
			"confirm":true
		},
		"city":{
			"needs":false,
			"room":false,
			"survey":false	
		}
	}
}*/
//notificationSettings=defaultNotificationsSettings;
jQuery(document).ready(function() {
	//$('.toggle-btn').bootstrapToggle();
	$('.toggle-btn').off().on("change",function() {
      //alert($(this).prop('checked'));
    });
	/*$("[name='my-checkbox']").on("switchChange.bootstrapSwitch", function (event, state) {
		mylog.log("state = "+state );
		if (state == true) {
			$(this).prev().val(1);
		} else {
			$(this).prev().val(0);
		}		
	});*/
	//initNotificationSettings(notificationSettings);
});

function initNotificationSettings(settings){
	$.each(settings.notification, function(key,data){
		$.each(data,function(e,v){
			if(v==true){
				$("#"+e).find("input[name='notification'][data-type='"+key+"']").val(1);
				$("#"+e).find("input[name='notification'][data-type='"+key+"']").next().find("[name='my-checkbox']").bootstrapSwitch('state', true, true);
			}
		});
	});
	$.each(settings.mail, function(key,data){
		$.each(data,function(e,v){
			if(v==true){
				$("#"+e).find("input[name='mail'][data-type='"+key+"']").val(1);
				$("#"+e).find("input[name='mail'][data-type='"+key+"']").next().find("[name='my-checkbox']").bootstrapSwitch('state', true, true);
			}
		});
	});
}
function onSaveNotificationSettings(){
	
}
</script>