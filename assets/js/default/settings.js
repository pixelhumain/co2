var tradLabel={
	"default" : "By default",
	"desactivated" : "Desactivated",
	"low" : "Low",
	"high" : "High",
}
var settings = {
	bindEventsConfidentiality : function(contextId, contextType){ 		
		$(".confidentialitySettings").off().on("click",function(){
	    	param = new Object;
	    	param.type = $(this).attr("type");
	    	param.value = $(this).attr("value");
	    	param.typeEntity = contextType;
	    	param.idEntity = contextId;
			$(".btn-group-"+param.type+" .btn").removeClass("active");
			$(this).addClass("active");
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
	},
	bindButtonConfidentiality : function(preferences){
		var fieldPreferences={};
		$.each(nameFields, function(e, v){
			fieldPreferences[v]=true;
		});
		//To checked private or public
		$.each(typePreferences, function(e, typePref){
			$.each(fieldPreferences, function(field, hidden){
				if(notNull(preferences) && typeof preferences[typePref] != "undefined" && $.inArray(field, preferences[typePref])>-1){
					$('.btn-group-'+field+' > button[value="'+typePref.replace("Fields", "")+'"]').addClass('active');
					fieldPreferences[field]=false;		
				}
			});
		});
		//To checked if there are hidden
		$.each(fieldPreferences, function(field, hidden){
			if(hidden) $('.btn-group-'+field+' > button[value="hide"]').addClass('active');
		});
		$.each(typePreferencesBool, function(field, typePrefB){
			if(notNull(preferences) && typeof preferences[typePrefB] != "undefined" && preferences[typePrefB] == true)
				$('.btn-group-'+typePrefB+' > button[value="true"]').addClass('active');	
			else
				$('.btn-group-'+typePrefB+' > button[value="false"]').addClass('active');
		});
	},
	bindEventsSettings : function(){
		$(".BSswitch").bootstrapSwitch();
	   	$(".BSswitch").on("switchChange.bootstrapSwitch", function (event, state) {
	    	settings.savePreferencesNotification("notifications",state, "citoyens", userId, $(this).data("sub"));
	    });
	   	$(".btn-show-block").click(function(){
	   		$(".show-block").hide(700);
	   		$(this).parents().eq(1).find(".show-block").show(700);
	   		/*if($(this).data("name")=="community")
	   			settings.getCommunitySettings();*/
	   		if($(this).data("name")=="mymails")
	   			settings.settingsCommunityEvents();

	   	});
	},
	initNotificationsAccount: function(preferences){
		if(typeof preferences.notifications != "undefined"){
			$.each(preferences.notifications, function(e, v){
				$(".BSswitch[data-sub='"+e+"'").removeAttr("checked");
			});
		}
		if(typeof preferences.mails != "undefined"){
			$("#mails-settings .changeValueDrop").text(tradLabel[preferences.mails]);
		}
	},
	settingsCommunityEvents : function(){
		$(".settingsCommunity").off().on("click", function() {
			settings.savePreferencesNotification($(this).data("settings"),$(this).data("value"), $(this).data("type"), $(this).data("id"));
			$(this).parents().eq(2).find(".dropdown-settings .changeValueDrop").html(tradSettings[$(this).data("value")]);
		});
		$("#community-settings #search-in-settings").keyup(function(){
			settings.filterSettingsCommunity($(this).val());
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
	},
	//recherche text par nom, cp, city, slug
	filterSettingsCommunity: function(searchVal){
		//console.log("filtercommunity-settings(searchVal)", searchVal);
		//masque/affiche tous les contacts présents dans la liste
		if(searchVal != "")	$("#community-settings .notification-label-communtiy").hide();
		else				$("#community-settings .notification-label-communtiy").show();
		//recherche la valeur recherché dans les 3 champs "name", "cp", et "city"
		$.each($("#community-settings .name-contact"), function() { settings.checkItemSearch($(this), searchVal); });
		$.each($("#community-settings .slug-contact"), function() { settings.checkItemSearch($(this), searchVal, "slug"); });
		$.each($("#community-settings .cp-contact"),   function() { settings.checkItemSearch($(this), searchVal); });
		$.each($("#community-settings .city-contact"), function() { settings.checkItemSearch($(this), searchVal); });
	},
	//si l'élément contient la searchVal, on l'affiche
	checkItemSearch : function(thisElement, searchVal, type){
		var content = (typeof type != "undefined" && type=="slug") ? thisElement.val() : thisElement.html();
		var found = content.search(new RegExp(searchVal, "i"));
		if(found >= 0){
			var id = thisElement.attr("idcontact");
			//console.log("$('.community-settings .contact"+id+"').show()");
			$("#community-settings .contact"+id).show();
		}
	},
	showHideOldElements : function(type) {
		$(".oldSettingsCommunity"+type).toggle("slow");
	},
	// Return true if the endDate of the Element is before the current Date. 
	isOldElement : function(value) {
		var endDate = (typeof value["endDate"] != undefined) ? value["endDate"] : "";
		if (endDate == "") return false;
		return new Date(endDate) < new Date();
	},
	savePreferencesNotification : function(settingsName, settingsValue, parentType, parentId, settingsSubName){
		var updateSettings={
			"settings" : settingsName,
			"value" : settingsValue,
			"type" : parentType,
			"id" : parentId
		};
		if(notNull(settingsSubName)) updateSettings.subName=settingsSubName;
		$.ajax({
		  	type: "POST",
		  	url: baseUrl+"/"+moduleId+"/element/updatesettings",
		  	data: updateSettings,
		  	success: function(data){
		  		if(data.result){
		  			if($.inArray(updateSettings.settings, ["mails", "notifications"])>0)
		  				settings.updateMyContacts(updateSettings);
					toastr.success(tradSettings.notificationsSettingsSuccess);
		  		}
				else
					toastr.error(data.msg);
		  	},
		  	dataType: "json"
		});
	},
	updateMyContacts : function(values){
		//typeContact=(values.type=="citoyens") ? "people" : values.type;
		if(typeof myContacts[values.type] != "undefined" && typeof myContacts[values.type][values.id] != "undefined"){
			myContacts[values.type][values.id][values.settings]=values.value;
		}
	},
	getCommunitySettings : function(typeSet){
		var scrollContent = "";
		var str = "";
		if(typeof myContacts != "undefined"){
			$.each(myContacts, function(type, array){
				if(type != "citoyens"){
			
			scrollContent += "<a href='javascript:' id='btn-scroll-type-"+type+"' class='text-"+typeObj[typeObj[type].sameAs].color+" btn-scroll-type pull-left'><i class='fa fa-"+typeObj[typeObj[type].sameAs].icon+"'></i> <span class='hidden-xs'>"+trad['my'+type]+"</span></a>";
			str += 		'<div class="panel panel-default scroll-container col-xs-12 no-padding" id="scroll-type-'+type+'">  '+	
							'<div class="panel-heading">';
				str += 			'<h4 class="text-'+typeObj[typeObj[type].sameAs].color+'">'+
									'<i class="fa fa-'+typeObj[typeObj[type].sameAs].icon+'"></i> <span class="">'+trad['my'+type]+"</span>";
									if (type == "events" || type == "projects") {
				str += 					'<button onclick="settings.showHideOldElements(\''+type+'\')" class="tooltips btn btn-default btn-sm pull-right btn_shortcut_add text-'+typeObj[typeObj[type].sameAs].color+'" data-placement="left" data-original-title="'+trad["showhideold"+type]+'">'+
											'<i class="fa fa-history"></i>'+
										'</button>';		
									}
				str += 			'</h4>'+
							'</div>';
								
					$.each(array, function(e, value){
						if(typeof value.isFollowed == "undefined" 
							&& typeof value.toBeValidated == "undefined" 
							&& (typeSet!="confidentiality" || (typeof value.isAdmin != "undefined" && typeof value.isAdminPending == "undefined"))){
							var oldElement = isOldElement(value);
							var profilThumbImageUrl = (typeof value.profilThumbImageUrl != "undefined" && value.profilThumbImageUrl != "") ? baseUrl + value.profilThumbImageUrl : assetPath + "/images/thumb/default_"+defaultImg+".png";
							var id = (typeof value._id != "undefined" && typeof value._id.$id != "undefined") ? value._id.$id : id;
							var setNotif = (typeof value.notifications != "undefined") ? tradSettings[value.notifications] : tradSettings["bydefault"];
							var setMails = (typeof value.mails != "undefined") ? tradSettings[value.mails] : tradSettings["bydefault"];
							var elementClass = oldElement ? "oldSettingsCommunity"+type : "";
							var elementStyle = oldElement ? "display:none" : ""; 
							var cp = (typeof value.address != "undefined" && notNull(value.address) && typeof value.address.postalCode != "undefined") ? value.address.postalCode : typeof value.cp != "undefined" ? value.cp : "";
							var city = (typeof value.address != "undefined" && notNull(value.address) && typeof value.address.addressLocality != "undefined") ? value.address.addressLocality : "";
							str+='<div class="col-xs-12 padding-5 notification-label-communtiy '+elementClass+' contact'+id+'" style="'+elementStyle+'" id="settingsItem-'+type+'-'+id+'" idcontact="'+id+'">'+
									'<div class="btn-chk-contact col-md-6 col-sm-4 col-xs-12">' +
										'<img src="'+ profilThumbImageUrl+'" class="thumb-send-to bg-'+typeObj[typeObj[type].sameAs].color+' pull-left" height="35" width="35">'+
										'<span class="info-contact col-xs-10 margin-top-5">' +
											'<span class="name-contact text-dark text-bold elipsis pull-left" idcontact="'+id+'">' + value.name + '</span>'+
											'<input type="hidden" class="slug-contact" idcontact="'+id+'" value="'+value.slug+'">'+
											'<br/>'+
											'<span class="cp-contact text-light pull-left" idcontact="'+id+'">' + cp + '&nbsp;</span>'+
											'<span class="city-contact text-light pull-left" idcontact="'+id+'">' + city + '</span>'+
										'</span>' +
									'</div>';
								if(typeSet=="notifications")
									str+=settings.getToolbarSettingsNotifications(setNotif, setMails, type, id);
								else if(typeSet=="confidentiality")
									str+=settings.getToolbarSettingsConfidentiality(type,id);
							str+='</div>';
						}
					});
					str+="</div>";
				}
			});
			$("#community-settings-list").html(str);
			$("#settingsScrollByType").html(scrollContent);
			settings.settingsCommunityEvents();
		}
	},
	getToolbarSettingsNotifications: function(setNotif, setMails, type, id){
		html='<div class="col-md-3 col-sm-4 col-xs-6">'+
				'<div class="dropdown no-padding col-xs-12 margin-bottom-20">'+
      				'<a data-toggle="dropdown" class="btn btn-default col-md-12 col-sm-12 col-xs-12 dropdown-settings" href="javascript:;">'+
      					'<i class="fa fa-bell"></i> <span class="hidden-xs">Notifs : </span><span class="changeValueDrop">'+setNotif+'</span> <i class="fa fa-caret-down" style="font-size:inherit;"></i>'+
      				'</a>'+
						'<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">'+
  						'<li>'+
      						'<a href="javascript:;" class="settingsCommunity" data-settings="notifications" data-value="desactivated" data-type="'+type+'" data-id="'+id+'">'+
      							tradSettings.desactivated+
      						'</a>'+
    					'</li>'+
    					'<li>'+
      						'<a href="javascript:;" class="settingsCommunity" data-settings="notifications" data-value="low" data-type="'+type+'" data-id="'+id+'">'+
      							tradSettings.low+
      						'</a>'+
    					'</li>'+
    					'<li>'+
      						'<a href="javascript:;" class="settingsCommunity" data-settings="notifications" data-value="default" data-type="'+type+'" data-id="'+id+'">'+
      							tradSettings.bydefault+
      						'</a>'+
    					'</li>'+
    					'<li>'+
      						'<a href="javascript:;" class="settingsCommunity" data-settings="notifications" data-value="high" data-type="'+type+'" data-id="'+id+'">'+
      							tradSettings.high+
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
      								tradSettings.desactivated+
      						'</a>'+
    					'</li>'+
    					'<li>'+
      						'<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="low" data-type="'+type+'" data-id="'+id+'">'+
      							tradSettings.low+
      						'</a>'+
    					'</li>'+
    					'<li>'+
      						'<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="default" data-type="'+type+'" data-id="'+id+'">'+
      							tradSettings.bydefault+
      						'</a>'+
    					'</li>'+
    					'<li>'+
      						'<a href="javascript:;" class="settingsCommunity" data-settings="mails" data-value="high" data-type="'+type+'" data-id="'+id+'">'+
      							tradSettings.high+
      						'</a>'+
    					'</li>'+
					'</ul>'+
        		'</div>'+
        	'</div>';
		return html;
	},
	getToolbarSettingsConfidentiality: function(type, id){
		html='<div class="col-md-6 col-sm-6 col-xs-6">'+
				
      				'<a class="btn btn-default col-md-12 col-sm-12 col-xs-12 dropdown-settings" href="javascript:;" onclick="settings.showPanelConfidentiality(\''+type+'\',\''+id+'\',true)">'+
      					'<i class="fa fa-cogs"></i> '+tradSettings.settings+
      				'</a>'+
						
        	'</div>';
		return html;
	},
	showPanelConfidentiality: function(type, id, modal){
		ajaxPost('#modalConfidentialityCommunity' ,baseUrl+'/'+moduleId+"/settings/confidentiality/type/"+type+"/id/"+id+"/modal/true",
			 null,function(){
			 	$("#modal-confidentiality").modal("show");
			 },"html");
	},
	bindMyAccountSettings : function(element){
		$("#btn-update-password-setting").click(function(){
			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/person/changepassword",
				dynForm : {
					jsonSchema : {
						title : trad["Change password"],
						icon : "fa-key",
						onLoads : {
					    	//pour creer un subevnt depuis un event existant
					    	onload : function(){
					    		//dyFInputs.setHeader("bg-green");

					    		$("#ajax-modal .modal-header").addClass("bg-dark");
				                $("#ajax-modal .infocustom p").addClass("text-dark");
				    	   	}
				    	},
						afterSave : function(data){
							dyFObj.closeForm();
						},
						properties : {
							mode : dyFInputs.inputHidden(),
							userId : dyFInputs.inputHidden(),
							oldPassword : dyFInputs.password(trad["Old password"]),
							newPassword : dyFInputs.password("", { required : true, minlength : 8 } ),
							newPassword2 : dyFInputs.password(trad["Repeat your new password"], {required : true, minlength : 8, equalTo : "#ajaxFormModal #newPassword"})	
						}
					}
				}
			};
			//alert("btn-update-password");
			var dataUpdate = {
				mode : "changePassword",
		        userId : userId
		    };

			dyFObj.openForm(form, null, dataUpdate);
			//lert("btn-update-password");
		});

		$("#btn-delete-element-setting").on("click", function(){
	    	$("#modal-delete-element").modal("show");
	    });

	    $("#downloadProfil-setting").click(function () {
			$.ajax({
				url: baseUrl+"/"+moduleId+"/data/get/type/citoyens/id/"+contextData.id ,
				type: 'POST',
				dataType: 'json',
				async:false,
				crossDomain:true,
				complete: function () {},
				success: function (obj){
					mylog.log("obj", obj);
					$("<a/>", {
					    "download": "profil.json",
					    "href" : "data:application/json," + encodeURIComponent(JSON.stringify(obj))
					  }).appendTo("body")
					  .click(function() {
					    $(this).remove()
					  })[0].click() ;
				},
				error: function (error) {
					
				}
			});
		});
	},
}

/*function getHeaderCommunitySettings(){
 	var HTML = '<div class="settingsHeader bg-white no-padding">'+
				'<div id="settingsScrollByType" class="pull-left"></div>' +
				'<a href="javascript:;" id="btnSettingsInfos" class="text-dark pull-right margin-right-20"><i class="fa fa-info-circle"></i> <span class="hidden-xs"> All infos</span></a>' +
				'<input type="text" id="search-in-settings" class="form-control" placeholder="'+trad.searchnamepostalcity+'">'+
			'</div>';

	return HTML;
}*/
