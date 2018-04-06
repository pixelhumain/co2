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
	#notifications-settings .toggle{
		float:right;
		min-height: inherit;
	    min-width: inherit;
	    width: 55px !important;
	    height: 25px !important;
	    margin-top: 5px;
	}
	.btn-show-block{
		font-size: 18px;
		font-weight: 700;
		line-height: 40px;
		cursor: pointer;
	}
	.contain-section-params:not(:first-child) .btn-show-block{
		border-top:1px solid rgba(244,244,244,0.8);  
	}
	.btn-show-block:hover{
		background-color: rgba(244,244,244,0.64);
	}
	.btn-show-block:hover, .btn-show-block:focus{
		text-decoration: none;
	}
	.btn-show-block span{
		vertical-align: sub;
	}
	.btn-show-block .hover-line{
		font-weight:inherit;
		font-size: 12px;
	}
	.btn-show-block:hover .hover-line{
		vertical-align: sub;
		text-decoration: underline !important;
	}
	.show-block{
		display: none;
	}
	.show-block i{
		width: 20px;
    	text-align: center;
    	font-size: 16px;
	}
	.show-block label{
		font-size: 14px;
    	line-height: 34px;
    	font-weight: normal;
    	margin-bottom: inherit;
	}
	.show-block .notification-label{
		line-height: 20px;
		margin-top: 5px;
	}
	.show-block .notification-label:hover{
		background-color: rgba(244,244,244,0.3);
    	border-radius: 2px;
	}
	.show-block .bootstrap-switch{
		height: 25px !important;
    	line-height: 10px !important;
    	min-width: 75px !important;
    	float:right;
    	margin-top: 5px;
	}
	.show-block .bootstrap-switch .bootstrap-switch-handle-on{
		background-color: #5cb85c !important;
		height: 23px;
	}
	.show-block .bootstrap-switch .bootstrap-switch-handle-off{
		box-shadow: inset 0 3px 5px rgba(0,0,0,.125);
		background-color: #e6e6e6 !important;
		height: 23px;
	}
	.show-block .bootstrap-switch .bootstrap-switch-handle-off:hover{
		background-color: #d4d4d4 !important;
	}
	.show-block .bootstrap-switch .bootstrap-switch-handle-on:hover{
		background-color: #449d44 !important;
	}
	.show-block .bootstrap-switch .bootstrap-switch-label{
		background-color: white !important;
		height: 25px;
    	vertical-align: super;
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
<div class="col-xs-12 margin-top-20">
	<!--<span> Manage notifications you want to received link to your user account. For your personal notifications inside the platform you can directly activate or desactivate what you want. You can also choose a personal mail notification packages. Of course you are free to desactivate all notifications</span>-->
</div>
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
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-check"></i> Confirmation to be part of an organization, a project or an event</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-rss"></i> You have a new followers</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-at"></i> Mentions of you in comments and news</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-newspaper-o"></i> Someone writes a news on your wall</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-thumbs-up"></i> Activity on one of your news (Comment/Like/Unlike)</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " checked="false" class="BSswitch">
		</div>
		<!--<div class="col-xs-12 padding-5 notification-label">
			<label>Someone comments one of your news or answers to your comment</label>
			<input class="toggle-btn" checked type="checkbox" data-toggle="toggle" data-width="50" d4ta-height="15" dat0-onstyle="success" data-on=" " data-off=" ">
		</div>-->
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-user-plus"></i> Registration of people you invited</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " checked="false" class="BSswitch">
		</div>
		<div class="col-xs-12 padding-5 notification-label">
			<label><i class="fa fa-comments"></i> Message about one of your classified or a ressource</label>
			<input id="" type="checkbox" data-off-text=" " data-on-text=" " checked="false" class="BSswitch">
		</div>
	</div>
</div>
<div id="mails-settings" class="contain-section-params col-xs-12">
	<div class="open-block col-xs-12 no-padding">
		<a href="javascript:;" class="btn-show-block col-xs-12">
			<i class="fa fa-envelope"></i> <span>Email</span>
			<span class="hover-line pull-right text-azure"><i class="fa fa-pencil"></i> edit </span>
		</a>
	</div>
	<div class="show-block col-xs-12">
		<span>I a m I n </span>
	</div>
</div>
<div id="my-community-settings" class="contain-section-params col-xs-12">
	<div class="open-block col-xs-12 no-padding">
		<a href="javascript:;" class="btn-show-block col-xs-12">
			<i class="fa fa-group"></i> <span>My community</span>
			<span class="hover-line pull-right text-azure"><i class="fa fa-pencil"></i> edit </span>
		</a>
	</div>
	<div class="show-block col-xs-12 getCommunitySettings">
		<span>I a m I n </span>
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
var tradLabel={
	"default" : "By default",
	"desactivated" : "Desactivated",
	"low" : "Low",
	"high" : "High",
}
jQuery(document).ready(function() {
	//$('.toggle-btn').bootstrapToggle();
	$(".BSswitch").bootstrapSwitch();
   	$(".BSswitch").on("switchChange.bootstrapSwitch", function (event, state) {
    		mylog.log("state = "+state );
    	});
   	$(".btn-show-block").click(function(){
   		$(".show-block").hide(700);
   		$(this).parents().eq(1).find(".show-block").show(700);
   		if($(this).parents().eq(1).find(".show-block").hasClass("getCommunitySettings"))
   			getCommunitySettings();
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
function settingsCommunityEvents(){
	$(".settingsCommunity").off().on("click", function() {
		settings=$(this).data("settings");
		value=$(this).data("value");
		type=$(this).data("type");
		id=$(this).data("id");
		$(this).parents().eq(2).find(".dropdown-settings .changeValueDrop").html(tradLabel[value]);
	});
}
function getCommunitySettings(){
	str+="";
	if(typeof myContacts != "undefined"){
		$.each(myContacts, function(type, array){
			if(type != "people"){
				str+="<div class='titleCommunity text-"+typeObj[typeObj[type].sameAs].color+"'><i class='fa fa-"+typeObj[typeObj[type].sameAs].icon+"'></i> My "+type+"</div>";
				$.each(array, function(e, value){
					var profilThumbImageUrl = (typeof value.profilThumbImageUrl != "undefined" && value.profilThumbImageUrl != "") ? baseUrl + value.profilThumbImageUrl : assetPath + "/images/thumb/default_"+defaultImg+".png";
					var id = (typeof value._id != "undefined" && typeof value._id.$id != "undefined") ? value._id.$id : id;
					str+='<div class="col-xs-12 padding-5 notification-label-communtiy">'+
							'<label class="col-md-6 col-sm-4 col-xs-4 elipsis"><img src='+profilThumbImageUrl+' height="30" width="30"/> <b>'+value.name+'</b></label>'+
							'<div class="col-md-3 col-sm-4 col-xs-4">'+
								'<div class="dropdown no-padding col-xs-12 margin-bottom-20">'+
			          				'<a data-toggle="dropdown" class="btn btn-default col-md-12 col-sm-12 col-xs-12 dropdown-settings" href="javascript:;">'+
			          					'<i class="fa fa-bell"></i> <span class="hidden-xs">Notifs : </span><span class="changeValueDrop">By default</span> <i class="fa fa-caret-down" style="font-size:inherit;"></i>'+
			          				'</a>'+
	          						'<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">'+
		          						'<li>'+
		              						'<a href="javascript:;" class="settingsCommunity" data-settings="notifications" data-value="desactivated" data-type="'+type+'" data-id="'+id+'">'+
		              							'Desactivated'+
		              						'</a>'+
		            					'</li>'+
		            					'<li>'+
		              						'<a href="javascript:;" class="settingsCommunity" data-settings="notifications" data-value="low" data-type="'+type+'" data-id="'+id+'">'+
		              							'Low'+
		              						'</a>'+
		            					'</li>'+
		            					'<li>'+
		              						'<a href="javascript:;" class="settingsCommunity" data-settings="notifications" data-value="default" data-type="'+type+'" data-id="'+id+'">'+
		              							'By default'+
		              						'</a>'+
		            					'</li>'+
		            					'<li>'+
		              						'<a href="javascript:;" class="settingsCommunity" data-settings="notifications" data-value="high" data-type="'+type+'" data-id="'+id+'">'+
		              							'High'+
		              						'</a>'+
		            					'</li>'+
									'</ul>'+
				        		'</div>'+
				        	'</div>'+
				        	'<div class="col-md-3 col-sm-4 col-xs-4">'+
								'<div class="dropdown no-padding col-xs-12 margin-bottom-20">'+
			          				'<a data-toggle="dropdown" class="btn btn-default col-md-12 col-sm-12 col-xs-12 dropdown-settings" href="javascript:;">'+
			          					'<i class="fa fa-envelope"></i> <span class="hidden-xs">Emails : </span><span class="changeValueDrop">By default</span> <i class="fa fa-caret-down" style="font-size:inherit;"></i>'+
			          				'</a>'+
	          						'<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">'+
		          						'<li>'+
		              						'<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="desactivated" data-type="'+type+'" data-id="'+id+'">'+
		              								'Desactivated'+
		              						'</a>'+
		            					'</li>'+
		            					'<li>'+
		              						'<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="low" data-type="'+type+'" data-id="'+id+'">'+
		              							'Low'+
		              						'</a>'+
		            					'</li>'+
		            					'<li>'+
		              						'<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="default" data-type="'+type+'" data-id="'+id+'">'+
		              							'By default'+
		              						'</a>'+
		            					'</li>'+
		            					'<li>'+
		              						'<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="high" data-type="'+type+'" data-id="'+id+'">'+
		              							'High'+
		              						'</a>'+
		            					'</li>'+
									'</ul>'+
				        		'</div>'+
				        	'</div>'+
						'</div>';
				});
				str+="</div>";
			}
		});
		$("#my-community-settings .getCommunitySettings").html(str);
		settingsCommunityEvents();
	}
};
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