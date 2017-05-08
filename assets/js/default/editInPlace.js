function bindAboutPodElement() {
		$("#editGeoPosition").click(function(){
			Sig.startModifyGeoposition(contextData.id, contextData.type, contextData);
			showMap(true);
		});
		
		$("#editElementDetail").on("click", function(){
			switchModeElement();
		});
	}

	function changeHiddenFields() { 
		mylog.log("-----------------changeHiddenFields----------------------");
		//
		listFields = [	"username", "birthDate", "email", "avancement", "url", "fixe",
						"mobile","fax", "facebook", "twitter", "gpplus", "gitHub", "skype", "telegram"];
		
		$.each(listFields, function(i,value) {
			mylog.log("listFields", value, typeof contextData[value]);
			if(typeof contextData[value] != "undefined" && contextData[value].length == 0)
				$("."+value).val("<i>"+trad.notSpecified+"<i>");
		});
		mylog.log("-----------------changeHiddenFields END----------------------");
	}

	function updateCalendar() {
		if(contextData.type == EVENT_COLLECTION){
			getAjax(".calendar",baseUrl+"/"+moduleId+"/event/calendarview/id/"+contextData.id +"/pod/1?date=1",null,"html");
		}
	}

	function removeAddresses (index){

		bootbox.confirm({
			message: trad["suredeletelocality"]+"<span class='text-red'></span>",
			buttons: {
				confirm: {
					label: trad["yes"],
					className: 'btn-success'
				},
				cancel: {
					label: trad["no"],
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				if (!result) {
					return;
				} else {
					var addresses = { addressesIndex : index };
					var param = new Object;
					param.name = "addresses";
					param.value = addresses;
					param.pk = contextData.id;
					$.ajax({
				        type: "POST",
				        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextData.type,
				        data: param,
				       	dataType: "json",
				    	success: function(data){
					    	if(data.result){
								toastr.success(data.msg);
								urlCtrl.loadByHash(location.hash);
					    	}
					    }
					});
				}
			}
		});		
	}

	function updateOrganizer() {
		bootbox.confirm({
			message: 
				trad["udpateorganizer"]+
				buildSelect("organizerId", "organizerId", 
							{"inputType" : "select", "options" : firstOptions(), 
							"groupOptions":myAdminList( ["organizations","projects"] )}, ""),
			buttons: {
				confirm: {
					label: trad["udpateorganizer"],
					className: 'btn-success'
				},
				cancel: {
					label: trad["cancel"],
					className: 'btn-danger'
				}
			},
			
			callback: function (result) {
				if (!result) {
					return;
				} else {
					var organizer = { "organizerId" : organizerId, "organizerType" : organizerType };

					var param = new Object;
					param.name = "organizer";
					param.value = organizer;
					param.pk = contextData.id;
					$.ajax({
				        type: "POST",
				        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextData.type,
				        data: param,
				       	dataType: "json",
				    	success: function(data){
					    	if(data.result){
								toastr.success(data.msg);
								urlCtrl.loadByHash("#page.type."+contextData.type+".id."+contextData.id+".view.detail");
					    	} else {
					    		toastr.error(data.msg);
					    	}
					    }
					});
				}
			}
		}).init(function(){
        	console.log("init de la bootbox !");
        	$("#organizerId").off().on("change",function(){
        		organizerId = $(this).val();
        		if(organizerId == "dontKnow" )
        			organizerType = "dontKnow";
        		else if( $('#organizerId').find(':selected').data('type') && typeObj[$('#organizerId').find(':selected').data('type')] )
        			organizerType = typeObj[$('#organizerId').find(':selected').data('type')].col;
        		else
        			organizerType = typeObj["person"].col;

        		mylog.warn( "organizer",organizerId,organizerType );
        		$("#ajaxFormModal #organizerType ").val( organizerType );
        	});
        })
	}
	
	function buildSelect(id, field, fieldObj,formValues) {
		var fieldClass = (fieldObj.class) ? fieldObj.class : '';
		var placeholder = (fieldObj.placeholder) ? fieldObj.placeholder+required : '';
		var fieldHTML = "";
		if ( fieldObj.inputType == "select" || fieldObj.inputType == "selectMultiple" ) 
        {
       		var multiple = (fieldObj.inputType == "selectMultiple") ? 'multiple="multiple"' : '';
       		mylog.log("build field "+field+">>>>>> select selectMultiple");
       		var isSelect2 = (fieldObj.isSelect2) ? "select2Input" : "";
       		fieldHTML += '<select class="'+isSelect2+' '+fieldClass+'" '+multiple+' name="'+field+'" id="'+field+'" style="width: 100%;height:30px;" data-placeholder="'+placeholder+'">';
			if(placeholder)
				fieldHTML += '<option class="text-red" style="font-weight:bold" disabled selected>'+placeholder+'</option>';
			else
				fieldHTML += '<option></option>';

			var selected = "";
			
			//initialize values
			if(fieldObj.options)
				fieldHTML += buildSelectOptions(fieldObj.options, fieldObj.value);
			
			if( fieldObj.groupOptions ){
				fieldHTML += buildSelectGroupOptions(fieldObj.groupOptions, fieldObj.value);
			} 
			fieldHTML += '</select>';
        }
        return fieldHTML;
	}


	function bindDynFormEditable(){

		$("#btn-update-when").off().on( "click", function(){


			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				dynForm : {
					jsonSchema : {
						title : trad["Change password"],
						icon : "fa-key",
						onLoads : {
							initWhen : function(){
								if(notNull(contextData.allDay) && contextData.allDay == true)
									$("#ajaxFormModal #allDay").attr("checked");
							}
						},
						beforeSave : function(){
							mylog.log("beforeSave");
					    	removeFieldUpdateDynForm(contextData.type);

					    	var allDay = $("#ajaxFormModal #allDay").is(':checked');
					    	var dateformat = "DD/MM/YYYY";
					    	if (! allDay) 
					    		var dateformat = "DD/MM/YYYY HH:mm" ;
					    	$("#ajaxFormModal #startDate").val( moment( $("#ajaxFormModal #startDate").val(), dateformat).format());
							$("#ajaxFormModal #endDate").val( moment( $("#ajaxFormModal #endDate").val(), dateformat).format());
					    },
						afterSave : function(data){
							mylog.dir(data);
							if(data.result && data.resultGoods.result){
								if(typeof data.resultGoods.values.allDay != "undefined"){
									contextData.allDay = data.resultGoods.values.allDay;
									$("#contentGeneralInfos #allDay").html(contextData.allDay);
								}  
								if(typeof data.resultGoods.values.endDate != "undefined"){
									contextData.startDate = data.resultGoods.values.startDate;
									$("#contentGeneralInfos #startDate").html(moment(contextData.startDate).local().format(formatDateView));
								}  
								if(typeof data.resultGoods.values.endDate != "undefined"){
									contextData.endDate = data.resultGoods.values.endDate;
									$("#contentGeneralInfos #endDate").html(moment(contextData.endDate).local().format(formatDateView));
								}  
								updateCalendar();
							}
							dyFObj.closeForm();
						},
						properties : {
							block : dyFInputs.inputHidden(),
							typeElement : dyFInputs.inputHidden(),
							isUpdate : dyFInputs.inputHidden(true)
						}
					}
				}
			};

			if(contextData.type == "<?php echo Event::COLLECTION; ?>"){
				form.dynForm.jsonSchema.properties.allDay = dyFInputs.allDay;
			}

			form.dynForm.jsonSchema.properties.startDate = dyFInputs.startDateInput;
			form.dynForm.jsonSchema.properties.endDate = dyFInputs.endDateInput;

			var dataUpdate = {
				block : "when",
		        id : contextData.id,
		        typeElement : contextData.type,
			};
			
			if(notEmpty(contextData.startDate))
				dataUpdate.startDate = moment(contextData.startDate).local().format(formatDatedynForm);

			if(notEmpty(contextData.endDate))
				dataUpdate.endDate = moment(contextData.endDate).local().format(formatDatedynForm);

			mylog.log("btn-update-when", form, dataUpdate);
			dyFObj.openForm(form, "initWhen", dataUpdate);
		});


		$(".btn-update-info").off().on( "click", function(){

			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				dynForm : {
					jsonSchema : {
						title : trad["Change password"],
						icon : "fa-key",
						onLoads : {
							initUpdateInfo : function(){
								mylog.log("initUpdateInfo");
								$(".emailtext").slideToggle();
							}
						},
						beforeSave : function(){
							mylog.log("beforeSave");
							removeFieldUpdateDynForm(contextData.type);
					    },
						afterSave : function(data){
							mylog.dir(data);
							if(data.result && data.resultGoods.result){

								if(typeof data.resultGoods.values.name != "undefined"){
									contextData.name = data.resultGoods.values.name;
									$("#nameHeader").html(contextData.name);
									$("#nameAbout").html(contextData.name);
								}

								if(typeof data.resultGoods.values.username != "undefined"){
									contextData.username = data.resultGoods.values.username;
									$("#usernameAbout").html(contextData.username);
								}
									
								if(typeof data.resultGoods.values.tags != "undefined"){
									contextData.tags = data.resultGoods.values.tags;
									var str = "";
									if($('#divTagsHeader').length){
										$.each(contextData.tags, function (key, tag){
											str +=	'<div class="tag label label-danger pull-right" data-val="'+tag+'">'+
														'<i class="fa fa-tag"></i>'+tag+
													'</div>';
											if(typeof globalTheme == "undefined" || globalTheme != "network")
												addTagToMultitag(tag);
										});
									}
									$('#divTagsHeader').html(str);
								}

								if(typeof data.resultGoods.values.avancement != "undefined"){
									contextData.avancement = data.resultGoods.values.avancement.trim();
									val=0;
							    	if(contextData.avancement=="idea")
										val=5;
									else if(contextData.avancement=="concept")
										val=20;
									else if (contextData.avancement== "started")
										val=40;
									else if (contextData.avancement == "development")
										val=60;
									else if (contextData.avancement == "testing")
										val=80;
									else if (contextData.avancement == "mature")
										val=100;
									$('#progressStyle').val(val);
									$('#labelProgressStyle').html(contextData.avancement);
									$('#avancementAbout').html(trad["Project maturity"] + " : " + trad[contextData.avancement] );
								}

								if(typeof data.resultGoods.values.type != "undefined"){

									if(contextData.type == typeObj.organization.col )
										contextData.typeOrga = data.resultGoods.values.typeEvent;
									else
										contextData.typeEvent = data.resultGoods.values.typeEvent;
									//$("#typeHeader").html(data.resultGoods.values.type);
									$("#typeAbout").html(trad[data.resultGoods.values.type]);
								}

								if(typeof data.resultGoods.values.email != "undefined"){
									mylog.log("update email");
									contextData.email = data.resultGoods.values.email;
									$("#emailAbout").html(contextData.email);
								}

								if(typeof data.resultGoods.values.url != "undefined"){
									mylog.log("update url");
									contextData.url = data.resultGoods.values.url;
									$("#urlAbout").html(contextData.url);
									$("#urlAbout").attr("href", contextData.url);
								}  
									
								if(typeof data.resultGoods.values.birthDate != "undefined"){
									mylog.log("update birthDate");
									contextData.birthDate = data.resultGoods.values.birthDate;
									$("#birthDateAbout").html(moment(contextData.birthDate).local().format("DD MM YYYY"));
								}

								if(typeof data.resultGoods.values.fixe != "undefined"){
									mylog.log("update fixe");
									contextData.fixe = parsePhone(data.resultGoods.values.fixe);
									$("#fixeAbout").html(contextData.fixe);
								}

								if(typeof data.resultGoods.values.mobile != "undefined"){
									mylog.log("update mobile");
									contextData.mobile = parsePhone(data.resultGoods.values.mobile);
									$("#mobileAbout").html(contextData.mobile);
								}

								if(typeof data.resultGoods.values.fax != "undefined"){
									mylog.log("update fax");
									contextData.fax = parsePhone(data.resultGoods.values.fax);
									$("#faxAbout").html(contextData.fax);
								}
							}
							dyFObj.closeForm();
							changeHiddenFields();
						},
						properties : {
							block : dyFInputs.inputHidden(),
							name : dyFInputs.name(contextData.type),
							typeElement : dyFInputs.inputHidden(),
							isUpdate : dyFInputs.inputHidden(true)
						}
					}
				}
			};

			if(contextData.type == typeObj.person.col ){
				form.dynForm.jsonSchema.properties.username = dyFInputs.username;
				form.dynForm.jsonSchema.properties.birthDate = dyFInputs.birthDate;
			}

			if(contextData.type == typeObj.organization.col ){
				form.dynForm.jsonSchema.properties.type = dyFInputs.inputSelect("Type d'organisation", "Type d'organisation", organizationTypes, { required : true });
			}

			if(contextData.type == typeObj.project.col ){
				form.dynForm.jsonSchema.properties.avancement = dyFInputs.inputSelect("L'avancement du project", "Avancement du projet", avancementProject);
			}

			form.dynForm.jsonSchema.properties.tags = dyFInputs.tags();

			if(contextData.type == typeObj.person.col || contextData.type == typeObj.organization.col ){
				form.dynForm.jsonSchema.properties.email = dyFInputs.email();
			}

			form.dynForm.jsonSchema.properties.url = dyFInputs.inputUrl();
			form.dynForm.jsonSchema.properties.fixe= dyFInputs.inputText("Fixe","Saisir les numéros de téléphone séparer par une virgule");
			form.dynForm.jsonSchema.properties.mobile= dyFInputs.inputText("Mobile","Saisir les numéros de portable séparer par une virgule");
			form.dynForm.jsonSchema.properties.fax= dyFInputs.inputText("Fax","Saisir les numéros de fax séparer par une virgule");

			var dataUpdate = {
				block : "info",
		        id : contextData.id,
		        typeElement : contextData.type,
		        name : contextData.name,	
			};
			
			if(notNull(contextData.tags) && contextData.tags.length > 0)
				dataUpdate.tags = contextData.tags;

			if(contextData.type == typeObj.person.col ){
				if(notNull(contextData.tags) && contextData.username.length > 0)
					dataUpdate.username = contextData.username;
				if(notEmpty(contextData.birthDate))
					dataUpdate.birthDate = contextData.birthDate;
			}

			if(contextData.type == typeObj.organization.col ){
				if(notEmpty(contextData.typeOrga))
					dataUpdate.type = contextData.typeOrga;
			}
			if(contextData.type == typeObj.project.col ){
				if(notEmpty(contextData.avancement))
					dataUpdate.avancement = contextData.avancement;
			}
			if(contextData.type == typeObj.person.col || contextData.type == typeObj.organization.col ){
				if(notEmpty(contextData.email)) 
					dataUpdate.email = contextData.email;
			}

			if(notEmpty(contextData.url)) 
				dataUpdate.url = contextData.url;
			if(notEmpty(contextData.fixe))
				dataUpdate.fixe = contextData.fixe;
			if(notEmpty(contextData.mobile))
				dataUpdate.mobile = contextData.mobile;
			if(notEmpty(contextData.fax))
				dataUpdate.fax = contextData.fax;

			mylog.log("dataUpdate", dataUpdate);
			dyFObj.openForm(form, "initUpdateInfo", dataUpdate);
		});

		$(".btn-update-descriptions").off().on( "click", function(){

			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				dynForm : {
					jsonSchema : {
						title : trad["Change password"],
						icon : "fa-key",
						onLoads : {
							markdown : function(){
								dataHelper.activateMarkdown("#ajaxFormModal #description");
								bindDesc("#ajaxFormModal");
							}
						},
						afterSave : function(data){
							mylog.dir(data);
							if(data.result && data.resultGoods.result){
								$(".contentInformation #shortDescriptionAbout").html(data.resultGoods.values.shortDescription);
								$(".contentInformation #shortDescriptionAboutEdit").html(data.resultGoods.values.shortDescription);
								$("#shortDescriptionHeader").html(data.resultGoods.values.shortDescription);
								$(".contentInformation #descriptionAbout").html(dataHelper.markdownToHtml(data.resultGoods.values.description));
								$("#descriptionMarkdown").html(data.resultGoods.values.description);
							}
							dyFObj.closeForm();
							changeHiddenFields();
						},
						properties : {
							block : dyFInputs.inputHidden(),
							typeElement : dyFInputs.inputHidden(),
							isUpdate : dyFInputs.inputHidden(true),
							shortDescription : 	dyFInputs.textarea("Description courte", "...",{ maxlength: 140 }),
							description : dyFInputs.textarea("Description longue", "..."),
						}
					}
				}
			};

			var dataUpdate = {
				block : "descriptions",
		        id : contextData.id,
		        typeElement : contextData.type,
		        name : contextData.name,
		        shortDescription : $(".contentInformation #shortDescriptionAboutEdit").html(),
				description : $("#descriptionMarkdown").html(),	
			};

			dyFObj.openForm(form, "markdown", dataUpdate);
		});


		$(".btn-update-network").off().on( "click", function(){
			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				dynForm : {
					jsonSchema : {
						title : trad["Change password"],
						icon : "fa-key",
						beforeSave : function(){
							mylog.log("beforeSave");
					    	removeFieldUpdateDynForm(contextData.type);
					    },
						afterSave : function(data){
							mylog.dir(data);
							if(data.result && data.resultGoods.result){

								if(typeof data.resultGoods.values.telegram != "undefined"){
									contextData.telegram = data.resultGoods.values.telegram.trim();
									changeNetwork('#telegramAbout', contextData.telegram, 'https://web.telegram.org/#/im?p=@'+contextData.telegram);
								}

								if(typeof data.resultGoods.values.facebook != "undefined"){
									contextData.facebook = data.resultGoods.values.facebook.trim();
									changeNetwork('#facebookAbout', contextData.facebook, contextData.facebook);
								}

								if(typeof data.resultGoods.values.twitter != "undefined"){
									contextData.twitter = data.resultGoods.values.twitter.trim();
									changeNetwork('#twitterAbout', contextData.twitter, contextData.twitter);
								}

								if(typeof data.resultGoods.values.gitHub != "undefined"){
									contextData.gitHub = data.resultGoods.values.gitHub.trim();
									changeNetwork('#gitHubAbout', contextData.gitHub, contextData.gitHub);
								}

								if(typeof data.resultGoods.values.skype != "undefined"){
									contextData.skype = data.resultGoods.values.skype.trim();
									changeNetwork('#skypeAbout', contextData.skype, contextData.skype);
								}

								if(typeof data.resultGoods.values.gpplus != "undefined"){
									contextData.gpplus = data.resultGoods.values.gpplus.trim();
									changeNetwork('#gpplusAbout', contextData.gpplus, contextData.gpplus);
								}
							}
							dyFObj.closeForm();
							changeHiddenFields();
						},

						properties : {
							block : dyFInputs.inputHidden(),
							typeElement : dyFInputs.inputHidden(),
							isUpdate : dyFInputs.inputHidden(true), 
							skype : dyFInputs.inputUrl("Lien vers Skype"),
							github : dyFInputs.inputUrl("Lien vers Git Hub"), 
							gpplus : dyFInputs.inputUrl("Lien vers Google Plus"),
					        twitter : dyFInputs.inputUrl("Lien vers Twitter"),
					        facebook :  dyFInputs.inputUrl("Lien vers Facebook"),
						}
					}
				}
			};

			if(contextData.type == typeObj.person.col ){
				form.dynForm.jsonSchema.properties.telegram = dyFInputs.inputText("Votre Speudo Telegram","Votre Speudo Telegram");
			}

			var dataUpdate = {
				block : "network",
		        id : contextData.id,
		        typeElement : contextData.type,
			};

			if(notEmpty(contextData.twitter))
				dataUpdate.twitter = contextData.twitter;
			if(notEmpty(contextData.gpplus))
				dataUpdate.gpplus = contextData.gpplus;
			if(notEmpty(contextData.gitHub))
				dataUpdate.gitHub = contextData.gitHub;
			if(notEmpty(contextData.skype))
				dataUpdate.skype = contextData.skype;
			if(notEmpty(contextData.telegram))
				dataUpdate.telegram = contextData.telegram;
			if(notEmpty(contextData.facebook))
				dataUpdate.facebook = contextData.facebook;

			dyFObj.openForm(form, null, dataUpdate);

			
		});
	}

	function changeNetwork(id, url, str){
		mylog.log("changeNetwork", id, url, str);
		$(id).attr('href', url);
		$(id).html(str);
	}

	function parsePhone(arrayPhones){
		var str = "";
		$.each(arrayPhones, function(i,num) {
			if(str != "")
				str += ", ";
			str += num.trim();
		});
		return str ;
	}


	function bindDesc(parent){
		$(".maxlengthTextarea").off().keyup(function(){
			var name = "#" + $(this).attr("id") ;
			mylog.log(".maxlengthTextarea", parent+" "+name, $(this).attr("id"), $(parent+" "+name).val().length, $(this).val().length);
			$(parent+" #maxlength"+$(this).attr("id")).html($(parent+" "+name).val().length);
			maxlengthshortDescription
		});
	}


	function updateUrl(ind, title, url, type) {
		mylog.log("updateUrl", ind, title, url, type)
		var params = {
			title : title,
			type : type,
			url : url,
			index : ind
		}
		mylog.log("params",params);
		dyFObj.openForm( 'url','parentUrl', params);
	}

	function removeUrl(ind) {
		param = new Object;
    	param.name = "urls";
    	param.value = {index : ind};
    	param.pk = contextData.id;
		param.type = contextData.type;
		$.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextData.type,
	        data: param,
	       	dataType: "json",
	    	success: function(data){
	    		mylog.log("data", data);
		    	if(data.result){
					toastr.success(data.msg);
					urlCtrl.loadByHash(location.hash);
		    	}
		    }
		});
	}


	function removeFieldUpdateDynForm(collection){
		var fieldsElement = [ 	"name", "tags", "email", "url", "fixe", "mobile", "fax", 
								"telegram", "gitHub", "skype", "twitter", "facebook", "gpplus"];
		var fieldsPerson = ["username",  "birthDate"];
		var fieldsProject = [ "avancement", "startDate", "endDate" ];
		var fieldsOrga = [ "type" ];
		var fieldsEvent = [ "type", "allDay", "startDate", "endDate"];

		if(collection == typeObj.person.col)
			fieldsElement.concat(fieldsPerson);
		else if(collection == typeObj.project.col)
			fieldsElement.concat(fieldsProject);
		else if(collection == typeObj.organization.col)
			fieldsElement.concat(fieldsOrga)
		else if(collection == typeObj.event.col)
			fieldsElement.concat(fieldsEvent);
		
		$.each(fieldsElement, function(key, val){ 
			if($("#ajaxFormModal #"+val).length && notNull(contextData[val]) && $("#ajaxFormModal #"+val).val() == contextData[val])
				$("#ajaxFormModal #"+val).remove();
		});
	}


