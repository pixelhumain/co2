function bindAboutPodElement() {
		$("#editGeoPosition").click(function(){
			Sig.startModifyGeoposition(contextData.id, contextType, contextData);
			showMap(true);
		});
		
		$("#editElementDetail").on("click", function(){
			switchModeElement();
		});		

		$("#btn-update-password").off().on( "click", function(){
			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/person/changepassword",
				dynForm : {
					jsonSchema : {
						title : trad["Change password"],
						icon : "fa-key",
						afterSave : function(data){
							elementLib.closeForm();
						},
						properties : {
							mode : typeObjLib.hidden,
							userId : typeObjLib.hidden,
							oldPassword : typeObjLib.password(trad["Old password"]),
							newPassword : typeObjLib.password("", { required : true, minlength : 8 } ),
							newPassword2 : typeObjLib.password(trad["Repeat your new password"], {required : true, minlength : 8, equalTo : "#ajaxFormModal #newPassword"})	
						}
					}
				}
			};

			var dataUpdate = {
				mode : "changePassword",
		        userId : userId
		    };
			elementLib.openForm(form, null, dataUpdate);
		});

		$("#downloadProfil").click(function () {
			$.ajax({
				url: baseUrl + "/communecter/data/get/type/citoyens/id/"+contextData.id ,
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

	    $(".confidentialitySettings").click(function(){
	    	param = new Object;
	    	param.type = $(this).attr("type");
	    	param.value = $(this).attr("value");
	    	param.typeEntity = contextType;
	    	param.idEntity = contextData.id;
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

		$("#editConfidentialityBtn").on("click", function(){
	    	mylog.log("confidentiality", seePreferences);
	    	$("#modal-confidentiality").modal("show");
	    	if(seePreferences=="true"){
	    		param = new Object;
		    	param.name = "seePreferences";
		    	param.value = false;
		    	param.pk = contextData.id;
				$.ajax({
			        type: "POST",
			        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextType,
			        data: param,
			       	dataType: "json",
			    	success: function(data){
				    	//toastr.success(data.msg);
				    	if(data.result){
							$("#divSeePreferencesHeader").addClass("hidden");
							$('#editConfidentialityBtn').removeClass("btn-red");
				    	}
				    }
				});
	    	}
	    	
	    });

		$(".panel-btn-confidentiality .btn").click(function(){
			var type = $(this).attr("type");
			var value = $(this).attr("value");
			$(".btn-group-"+type + " .btn").removeClass("active");
			$(this).addClass("active");
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
				        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextType,
				        data: param,
				       	dataType: "json",
				    	success: function(data){
					    	if(data.result){
								toastr.success(data.msg);
								url.loadByHash("#page.type."+contextData.type+".id."+contextData.id+".view.detail");
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
				        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextType,
				        data: param,
				       	dataType: "json",
				    	success: function(data){
					    	if(data.result){
								toastr.success(data.msg);
								url.loadByHash("#page.type."+contextData.type+".id."+contextData.id+".view.detail");
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
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/type/"+contextType,
				dynForm : {
					jsonSchema : {
						title : trad["Change password"],
						icon : "fa-key",
						onLoads : {
							initWhen : function(){
								if(notNull(element.allDay) && element.allDay == true)
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
									element.allDay = data.resultGoods.values.allDay;
									$("#contentGeneralInfos #allDay").html(element.allDay);
								}  
								if(typeof data.resultGoods.values.endDate != "undefined"){
									element.startDate = data.resultGoods.values.startDate;
									$("#contentGeneralInfos #startDate").html(moment(element.startDate).local().format(formatDateView));
								}  
								if(typeof data.resultGoods.values.endDate != "undefined"){
									element.endDate = data.resultGoods.values.endDate;
									$("#contentGeneralInfos #endDate").html(moment(element.endDate).local().format(formatDateView));
								}  
								updateCalendar();
							}
							elementLib.closeForm();
						},
						properties : {
							block : typeObjLib.hidden,
							typeElement : typeObjLib.hidden,
							isUpdate : typeObjLib.hiddenTrue,
							startDate : typeObjLib.startDateInput,
							endDate : typeObjLib.endDateInput,
						}
					}
				}
			};

			if(element.type == "<?php echo Event::COLLECTION; ?>"){
				form.dynForm.jsonSchema.properties.allDay = typeObjLib.allDay;
			}

			form.dynForm.jsonSchema.properties.startDate = typeObjLib.startDateInput;
			form.dynForm.jsonSchema.properties.endDate = typeObjLib.endDateInput;

			var dataUpdate = {
				block : "when",
		        id : element.id,
		        typeElement : contextData.type,
			};
			
			if(notEmpty(element.startDate))
				dataUpdate.startDate = moment(element.startDate).local().format(formatDatedynForm);

			if(notEmpty(element.endDate))
				dataUpdate.endDate = moment(element.endDate).local().format(formatDatedynForm);

			mylog.log("btn-update-when", form, dataUpdate);
			elementLib.openForm(form, "initWhen", dataUpdate);
		});


		$(".btn-update-info").off().on( "click", function(){

			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/type/"+contextType,
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
									element.name = data.resultGoods.values.name;
									$("#nameHeader").html(element.name);
									$("#nameAbout").html(element.name);
								}

								if(typeof data.resultGoods.values.username != "undefined"){
									element.username = data.resultGoods.values.username;
									$("#usernameAbout").html(element.username);
								}
									
								if(typeof data.resultGoods.values.tags != "undefined"){
									element.tags = data.resultGoods.values.tags;
									var str = "";
									if($('#divTagsHeader').length){
										$.each(element.tags, function (key, tag){
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
									element.avancement = data.resultGoods.values.avancement.trim();
									val=0;
							    	if(element.avancement=="idea")
										val=5;
									else if(element.avancement=="concept")
										val=20;
									else if (element.avancement== "started")
										val=40;
									else if (element.avancement == "development")
										val=60;
									else if (element.avancement == "testing")
										val=80;
									else if (element.avancement == "mature")
										val=100;
									$('#progressStyle').val(val);
									$('#labelProgressStyle').html(element.avancement);
									$('#avancementAbout').html(trad["Project maturity"] + " : " + trad[element.avancement] );
								}

								if(typeof data.resultGoods.values.type != "undefined"){

									if(element.type == typeObj.organization.col )
										element.typeOrga = data.resultGoods.values.typeEvent;
									else
										element.typeEvent = data.resultGoods.values.typeEvent;
									//$("#typeHeader").html(data.resultGoods.values.type);
									$("#typeAbout").html(trad[data.resultGoods.values.type]);
								}

								if(typeof data.resultGoods.values.email != "undefined"){
									mylog.log("update email");
									element.email = data.resultGoods.values.email;
									$("#emailAbout").html(element.email);
								}

								if(typeof data.resultGoods.values.url != "undefined"){
									mylog.log("update url");
									element.url = data.resultGoods.values.url;
									$("#urlAbout").html(element.url);
									$("#urlAbout").attr("href", element.url);
								}  
									
								if(typeof data.resultGoods.values.birthDate != "undefined"){
									mylog.log("update birthDate");
									element.birthDate = data.resultGoods.values.birthDate;
									$("#birthDateAbout").html(moment(element.birthDate).local().format("DD MM YYYY"));
								}

								if(typeof data.resultGoods.values.fixe != "undefined"){
									mylog.log("update fixe");
									element.fixe = parsePhone(data.resultGoods.values.fixe);
									$("#fixeAbout").html(element.fixe);
								}

								if(typeof data.resultGoods.values.mobile != "undefined"){
									mylog.log("update mobile");
									element.mobile = parsePhone(data.resultGoods.values.mobile);
									$("#mobileAbout").html(element.mobile);
								}

								if(typeof data.resultGoods.values.fax != "undefined"){
									mylog.log("update fax");
									element.fax = parsePhone(data.resultGoods.values.fax);
									$("#faxAbout").html(element.fax);
								}
							}
							elementLib.closeForm();
							changeHiddenFields();
						},
						properties : {
							block : typeObjLib.hidden,
							name : typeObjLib.name(element.type),
							typeElement : typeObjLib.hidden,
							isUpdate : typeObjLib.hiddenTrue
						}
					}
				}
			};

			if(element.type == typeObj.person.col ){
				form.dynForm.jsonSchema.properties.username = typeObjLib.username;
				form.dynForm.jsonSchema.properties.birthDate = typeObjLib.birthDate;
			}

			if(element.type == typeObj.organization.col ){
				form.dynForm.jsonSchema.properties.type = typeObjLib.typeOrga;
				form.dynForm.jsonSchema.properties.tags = typeObjLib.tags();
			}

			if(element.type == typeObj.project.col ){
				form.dynForm.jsonSchema.properties.avancement = typeObjLib.avancementProject;
			}

			if(element.type == typeObj.person.col || element.type == typeObj.organization.col ){
				form.dynForm.jsonSchema.properties.email = typeObjLib.email;
				
			}
			form.dynForm.jsonSchema.properties.url = typeObjLib.url;
			form.dynForm.jsonSchema.properties.fixe= typeObjLib.phone;
			form.dynForm.jsonSchema.properties.mobile= typeObjLib.mobile;
			form.dynForm.jsonSchema.properties.fax= typeObjLib.fax;

			var dataUpdate = {
				block : "info",
		        id : element.id,
		        typeElement : contextData.type,
		        name : element.name,	
			};
			
			if(notNull(element.tags) && element.tags.length > 0)
				dataUpdate.tags = element.tags;

			if(element.type == typeObj.person.col ){
				if(notNull(element.tags) && element.username.length > 0)
					dataUpdate.username = element.username;
				if(notEmpty(element.birthDate))
					dataUpdate.birthDate = element.birthDate;
			}

			if(element.type == typeObj.organization.col ){
				if(notEmpty(element.typeOrga))
					dataUpdate.type = element.typeOrga;
			}
			if(element.type == typeObj.project.col ){
				if(notEmpty(element.avancement))
					dataUpdate.avancement = element.avancement;
			}
			if(element.type == typeObj.person.col || element.type == typeObj.organization.col ){
				if(notEmpty(element.email)) 
					dataUpdate.email = element.email;
			}

			if(notEmpty(element.url)) 
				dataUpdate.url = element.url;
			if(notEmpty(element.fixe))
				dataUpdate.fixe = element.fixe;
			if(notEmpty(element.mobile))
				dataUpdate.mobile = element.mobile;
			if(notEmpty(element.fax))
				dataUpdate.fax = element.fax;

			mylog.log("dataUpdate", dataUpdate);
			elementLib.openForm(form, "initUpdateInfo", dataUpdate);
		});

		$(".btn-update-descriptions").off().on( "click", function(){

			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/type/"+contextType,
				dynForm : {
					jsonSchema : {
						title : trad["Change password"],
						icon : "fa-key",
						onLoads : {
							markdown : function(){
								activateMarkdown("#ajaxFormModal #description");
								bindDesc("#ajaxFormModal");
							}
						},
						afterSave : function(data){
							mylog.dir(data);
							if(data.result && data.resultGoods.result){shortDescriptionHeader
								$(".contentInformation #shortDescriptionAbout").html(data.resultGoods.values.shortDescription);
								$("#shortDescriptionHeader").html(data.resultGoods.values.shortDescription);
								$(".contentInformation #descriptionAbout").html(markdownToHtml(data.resultGoods.values.description));
								$("#descriptionMarkdown").val(data.resultGoods.values.description);
							}
							elementLib.closeForm();
							changeHiddenFields();
						},
						properties : {
							block : typeObjLib.hidden,
							typeElement : typeObjLib.hidden,
							isUpdate : typeObjLib.hiddenTrue,
							shortDescription : 	typeObjLib.shortDescription,
							description : typeObjLib.description,
						}
					}
				}
			};

			var dataUpdate = {
				block : "descriptions",
		        id : element.id,
		        typeElement : contextData.type,
		        name : element.name,
		        shortDescription : $(".contentInformation #shortDescriptionAbout").html(),
				description : $("#descriptionMarkdown").val(),	
			};

			elementLib.openForm(form, "markdown", dataUpdate);
		});


		$(".btn-update-network").off().on( "click", function(){
			if(element.type == typeObj.person.col ){
				var form = {
					saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/type/"+contextType,
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
										element.telegram = data.resultGoods.values.telegram.trim();
										changeNetwork('#telegramAbout', element.telegram, 'https://web.telegram.org/#/im?p=@'+element.telegram);
									}

									if(typeof data.resultGoods.values.facebook != "undefined"){
										element.facebook = data.resultGoods.values.facebook.trim();
										changeNetwork('#facebookAbout', element.facebook, element.facebook);
									}

									if(typeof data.resultGoods.values.twitter != "undefined"){
										element.twitter = data.resultGoods.values.twitter.trim();
										changeNetwork('#twitterAbout', element.twitter, element.twitter);
									}

									if(typeof data.resultGoods.values.gitHub != "undefined"){
										element.gitHub = data.resultGoods.values.gitHub.trim();
										changeNetwork('#gitHubAbout', element.gitHub, element.gitHub);
									}

									if(typeof data.resultGoods.values.skype != "undefined"){
										element.skype = data.resultGoods.values.skype.trim();
										changeNetwork('#skypeAbout', element.skype, element.skype);
									}

									if(typeof data.resultGoods.values.gpplus != "undefined"){
										element.gpplus = data.resultGoods.values.gpplus.trim();
										changeNetwork('#gpplusAbout', element.gpplus, element.gpplus);
									}
								}
								elementLib.closeForm();
								changeHiddenFields();
							},
							properties : {
								block : typeObjLib.hidden,
								typeElement : typeObjLib.hidden,
								isUpdate : typeObjLib.hiddenTrue,
								telegram : typeObjLib.telegram,
								skype : typeObjLib.skype,
								gitHub : typeObjLib.github,
								gpplus : typeObjLib.googleplus,
						        twitter : typeObjLib.twitter,
						        facebook : typeObjLib.facebook
							}
						}
					}
				};

				var dataUpdate = {
					block : "network",
			        id : element.id,
			        typeElement : contextData.type,
				};

				if(notEmpty(element.twitter))
					dataUpdate.twitter = element.twitter;
				if(notEmpty(element.gpplus))
					dataUpdate.gpplus = element.gpplus;
				if(notEmpty(element.gitHub))
					dataUpdate.gitHub = element.gitHub;
				if(notEmpty(element.skype))
					dataUpdate.skype = element.skype;
				if(notEmpty(element.telegram))
					dataUpdate.telegram = element.telegram;
				if(notEmpty(element.facebook))
					dataUpdate.facebook = element.facebook;

				elementLib.openForm(form, null, dataUpdate);

			}
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
		//var url = urls[ind] ;
		var params = {
			title : title,
			type : type,
			url : url,
			index : ind
		}
		mylog.log("params",params);
		elementLib.openForm( 'url','parentUrl', params);
	}

	function removeUrl(ind) {
		param = new Object;
    	param.name = "urls";
    	param.value = {index : ind};
    	param.pk = contextData.id;
		param.type = contextData.type;
		$.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextType,
	        data: param,
	       	dataType: "json",
	    	success: function(data){
	    		mylog.log("data", data);
		    	if(data.result){
					toastr.success(data.msg);
					url.loadByHash(location.hash);
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
			if($("#ajaxFormModal #"+val).length && notNull(element[val]) && $("#ajaxFormModal #"+val).val() == element[val])
				$("#ajaxFormModal #"+val).remove();
		});
	}


