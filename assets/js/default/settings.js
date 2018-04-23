var tradLabel={
	"default" : "By default",
	"desactivated" : "Desactivated",
	"low" : "Low",
	"high" : "High",
}
var settings = {
	bindEventsConfidentiality : function(contextId, contextType){
		$(".confidentialitySettings").click(function(){
	    	param = new Object;
	    	param.type = $(this).attr("type");
	    	param.value = $(this).attr("value");
	    	param.typeEntity = contextType;
	    	param.idEntity = contextId;
			$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updatesettings",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
			    	toastr.success(data.msg);
			    }
			});
		});
	}
}

function bindEventsSettings(){
	//$('.toggle-btn').bootstrapToggle();
	$(".BSswitch").bootstrapSwitch();
   	$(".BSswitch").on("switchChange.bootstrapSwitch", function (event, state) {
    	savePreferencesNotification("notifications",state, "citoyens", userId, $(this).data("sub"));
    });
   	$(".btn-show-block").click(function(){
   		$(".show-block").hide(700);
   		$(this).parents().eq(1).find(".show-block").show(700);
   		if($(this).data("name")=="community")
   			getCommunitySettings();
   		else($(this).data("name")=="mymails")
   			settingsCommunityEvents();

   	});
};
function settingsCommunityEvents(){
	$(".settingsCommunity").off().on("click", function() {
		savePreferencesNotification($(this).data("settings"),$(this).data("value"), $(this).data("type"), $(this).data("id"));
		$(this).parents().eq(2).find(".dropdown-settings .changeValueDrop").html(tradLabel[$(this).data("value")]);
	});
	$("#community-settings #search-in-settings").keyup(function(){
		filterSettingsCommunity($(this).val());
	});

	//parcourt tous les types de contacts
	$.each(["organizations", "projects", "events"], function(key, type){ 
		//initialise le scoll automatique de la liste de contact
		$(".settingsHeader #btn-scroll-type-"+type).mouseover(function(){
			var scrollTOP = $("#container-settings-view #scroll-type-"+type).position().top;
			$('#container-settings-view').scrollTop(scrollTOP);
		});
	});
	$("#btnSettingsInfos").off().on("click",function(){
		$("#modalExplainSettings").modal("show"); 
	});

}
//recherche text par nom, cp et city
function filterSettingsCommunity(searchVal){
	console.log("filtercommunity-settings(searchVal)", searchVal);
	//masque/affiche tous les contacts présents dans la liste
	if(searchVal != "")	$("#community-settings .notification-label-communtiy").hide();
	else				$("#community-settings .notification-label-communtiy").show();
	//recherche la valeur recherché dans les 3 champs "name", "cp", et "city"
	$.each($("#community-settings .name-contact"), function() { checkItemSearch($(this), searchVal); });
	$.each($("#community-settings .cp-contact"),   function() { checkItemSearch($(this), searchVal); });
	$.each($("#community-settings .city-contact"), function() { checkItemSearch($(this), searchVal); });
}

//si l'élément contient la searchVal, on l'affiche
function checkItemSearch(thisElement, searchVal, type){
	var content = thisElement.html();
	var found = content.search(new RegExp(searchVal, "i"));
	if(found >= 0){
		var id = thisElement.attr("idcontact");
		//console.log("$('.community-settings .contact"+id+"').show()");
		$("#community-settings .contact"+id).show();
	}
}
function showHideOldElements(type) {
	$(".oldSettingsCommunity"+type).toggle("slow");
}

// Return true if the endDate of the Element is before the current Date. 
function isOldElement(value) {
	//mylog.log("isOldElement", value);
	var endDate = (typeof value["endDate"] != undefined) ? value["endDate"] : "";
	if (endDate == "") return false;
	return new Date(endDate) < new Date();
}
function savePreferencesNotification(settingsName, settingsValue, parentType, parentId, settingsSubName){
	var settings={
		"settings" : settingsName,
		"value" : settingsValue,
		"type" : parentType,
		"id" : parentId
	};
	if(notNull(settingsSubName)) settings.subName=settingsSubName;
	$.ajax({
	  	type: "POST",
	  	url: baseUrl+"/"+moduleId+"/element/updatesettings",
	  	data: settings,
	  	success: function(data){
	  		if(data.result)
				toastr.success("Notifications settings well updated");
			else
				toastr.error(data.msg);
	  	},
	  	dataType: "json"
	});
}
function getCommunitySettings(){
	var scrollContent = "";
	var str = "";//getHeaderCommunitySettings(); 
	if(typeof myContacts != "undefined"){
		$.each(myContacts, function(type, array){
			if(type != "people"){
		
		scrollContent += "<a href='javascript:' id='btn-scroll-type-"+type+"' class='text-"+typeObj[typeObj[type].sameAs].color+" btn-scroll-type pull-left'><i class='fa fa-"+typeObj[typeObj[type].sameAs].icon+"'></i> <span class='hidden-xs'>"+trad['my'+type]+"</span></a>";
		str += 		'<div class="panel panel-default scroll-container col-xs-12 no-padding" id="scroll-type-'+type+'">  '+	
						'<div class="panel-heading">';
			str += 			'<h4 class="text-'+typeObj[typeObj[type].sameAs].color+'">'+
								'<i class="fa fa-'+typeObj[typeObj[type].sameAs].icon+'"></i> <span class="">'+trad['my'+type]+"</span>";
								if (type == "events" || type == "projects") {
			str += 					'<button onclick="showHideOldElements(\''+type+'\')" class="tooltips btn btn-default btn-sm pull-right btn_shortcut_add text-'+typeObj[typeObj[type].sameAs].color+'" data-placement="left" data-original-title="'+trad["showhideold"+type]+'">'+
										'<i class="fa fa-history"></i>'+
									'</button>';		
								}
			str += 			'</h4>'+
						'</div>';
							
				$.each(array, function(e, value){
					if(typeof value.isFollowed == "undefined" && typeof value.toBeValidated == "undefined"){
						var oldElement = isOldElement(value);
						var profilThumbImageUrl = (typeof value.profilThumbImageUrl != "undefined" && value.profilThumbImageUrl != "") ? baseUrl + value.profilThumbImageUrl : assetPath + "/images/thumb/default_"+defaultImg+".png";
						var id = (typeof value._id != "undefined" && typeof value._id.$id != "undefined") ? value._id.$id : id;
						var setNotif = (typeof value.notifications != "undefined") ? tradLabel[value.notifications] : tradLabel["default"];
						var setMails = (typeof value.mails != "undefined") ? tradLabel[value.mails] : tradLabel["default"];
						var elementClass = oldElement ? "oldSettingsCommunity"+type : "";
						var elementStyle = oldElement ? "display:none" : ""; 
						var cp = (typeof value.address != "undefined" && notNull(value.address) && typeof value.address.postalCode != "undefined") ? value.address.postalCode : typeof value.cp != "undefined" ? value.cp : "";
						var city = (typeof value.address != "undefined" && notNull(value.address) && typeof value.address.addressLocality != "undefined") ? value.address.addressLocality : "";
						str+='<div class="col-xs-12 padding-5 notification-label-communtiy '+elementClass+' contact'+id+'" style="'+elementStyle+'" id="settingsItem-'+type+'-'+id+'" idcontact="'+id+'">'+
								'<div class="btn-chk-contact col-md-6 col-sm-4 col-xs-12">' +
									'<img src="'+ profilThumbImageUrl+'" class="thumb-send-to bg-'+typeObj[typeObj[type].sameAs].color+' pull-left" height="35" width="35">'+
									'<span class="info-contact col-xs-10 margin-top-5">' +
										'<span class="name-contact text-dark text-bold elipsis pull-left" idcontact="'+id+'">' + value.name + '</span>'+
										'<br/>'+
										'<span class="cp-contact text-light pull-left" idcontact="'+id+'">' + cp + '&nbsp;</span>'+
										'<span class="city-contact text-light pull-left" idcontact="'+id+'">' + city + '</span>'+
									'</span>' +
								'</div>' +
								//'<label class="col-md-6 col-sm-4 col-xs-4 elipsis"><img src='+profilThumbImageUrl+' height="30" width="30"/> <b>'+value.name+'</b></label>'+
								'<div class="col-md-3 col-sm-4 col-xs-6">'+
									'<div class="dropdown no-padding col-xs-12 margin-bottom-20">'+
				          				'<a data-toggle="dropdown" class="btn btn-default col-md-12 col-sm-12 col-xs-12 dropdown-settings" href="javascript:;">'+
				          					'<i class="fa fa-bell"></i> <span class="hidden-xs">Notifs : </span><span class="changeValueDrop">'+setNotif+'</span> <i class="fa fa-caret-down" style="font-size:inherit;"></i>'+
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
					        	'<div class="col-md-3 col-sm-4 col-xs-6">'+
									'<div class="dropdown no-padding col-xs-12 margin-bottom-20">'+
				          				'<a data-toggle="dropdown" class="btn btn-default col-md-12 col-sm-12 col-xs-12 dropdown-settings" href="javascript:;">'+
				          					'<i class="fa fa-envelope"></i> <span class="hidden-xs">Emails : </span><span class="changeValueDrop">'+setMails+'</span> <i class="fa fa-caret-down" style="font-size:inherit;"></i>'+
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
					}
				});
				str+="</div>";
			}
		});
		$("#community-settings-list").html(str);
		$("#settingsScrollByType").html(scrollContent);
		settingsCommunityEvents();
	}
}
function getHeaderCommunitySettings(){
 	var HTML = '<div class="settingsHeader bg-white no-padding">'+
				'<div id="settingsScrollByType" class="pull-left"></div>' +
				'<a href="javascript:;" id="btnSettingsInfos" class="text-dark pull-right margin-right-20"><i class="fa fa-info-circle"></i> <span class="hidden-xs"> All infos</span></a>' +
				'<input type="text" id="search-in-settings" class="form-control" placeholder="'+trad.searchnamepostalcity+'">'+
			'</div>';

	return HTML;
}
