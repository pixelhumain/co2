function bindAboutPodElement() {
		$("#editGeoPosition").click(function(){
			Sig.startModifyGeoposition(contextData.id, contextType, contextData);
			showMap(true);
		});
		
		$("#editElementDetail").on("click", function(){
			switchModeElement();
		});		

		$("#changePasswordBtn").click(function () {
			var urlToSend = baseUrl+'/'+moduleId+'/person/changepassword/id/'+userId+'/mode/initSV';
			$.blockUI({
				message : '<div>'+
							'<div class="changePasswordForm"></div>'+
						'</div>', 
				onOverlayClick: $.unblockUI,
				css: {"text-align": "left", "cursor":"default", "width":"50%", "left":"25%" }
			});

			getAjax('.changePasswordForm',urlToSend,function(){

			//$('.bar_tools_post').hide();
			//$('.saySomething').hide();
			},"html");
			//mylog.log("changePasswordbuttton");
			//url.loadByHash('#person.changepassword.id.'+userId+'.mode.initSV', false);
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
								url.loadByHash("#"+contextData.controller+".detail.id."+contextData.id);
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
								url.loadByHash("#"+contextData.controller+".detail.id."+contextData.id);
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

			var properties = {
				block : typeObjLib.hidden,
				typeElement : typeObjLib.hidden,
				isUpdate : typeObjLib.hiddenTrue	
			};

			if(contextData.type == "<?php echo Event::COLLECTION; ?>"){
				properties.allDay = typeObjLib.allDay;
			}

			properties.startDate = typeObjLib.startDateInput;
			properties.endDate = typeObjLib.endDateInput;
			
			var dataUpdate = {
				block : "when",
		        id : contextData.id,
		        typeElement : contextData.type,
			};
			
			if(contextData.startDate.length > 0)
				dataUpdate.startDate = moment(contextData.startDate).local().format(formatDatedynForm);

			if(contextData.endDate.length > 0)
				dataUpdate.endDate = moment(contextData.endDate).local().format(formatDatedynForm);

			mylog.log("dataUpdate", dataUpdate);

			var onLoads = {
				initWhen : function(){
					if(typeof contextData.allDay != "undefined" && contextData.allDay == "true")
						$("#ajaxFormModal #allDay").attr("checked");
				}
			};

			var beforeSave = function(){
				mylog.log("beforeSave");
		    	if($("#ajaxFormModal #allDay").length && $("#ajaxFormModal #allDay").val() == contextData.allDay)
		    		$("#ajaxFormModal #allDay").remove();

		    	if($("#ajaxFormModal #startDate").length && $("#ajaxFormModal #startDate").val() ==  contextData.startDate)
		    		$("#ajaxFormModal #startDate").remove();

		    	if($("#ajaxFormModal #endDate").length && $("#ajaxFormModal #endDate").val() ==  contextData.endDate)
		    		$("#ajaxFormModal #endDate").remove();

		    	var allDay = $("#ajaxFormModal #allDay").is(':checked');
		    	var dateformat = "DD/MM/YYYY";
		    	if (! allDay) 
		    		var dateformat = "DD/MM/YYYY HH:mm" ;
		    	$("#ajaxFormModal #startDate").val( moment( $("#ajaxFormModal #startDate").val(), dateformat).format());
				$("#ajaxFormModal #endDate").val( moment( $("#ajaxFormModal #endDate").val(), dateformat).format());
		    };

			var afterSave = function(data){
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
				elementLib.closeForm();
			};
			
			var saveUrl = baseUrl+"/"+moduleId+"/element/updateblock/type/"+contextType;
			elementLib.editDynForm("Modifier les dates", "fa-calendar", properties, "initWhen", dataUpdate, saveUrl, onLoads, beforeSave, afterSave);
		});


		$(".btn-update-info").off().on( "click", function(){

			mylog.log("btn-update-info");
			var properties = {
				block : typeObjLib.hidden,
				name : typeObjLib.name(contextData.type),
				typeElement : typeObjLib.hidden,
				isUpdate : typeObjLib.hiddenTrue		
			};

			if(contextData.type == typeObj.person.col ){
				properties.username = typeObjLib.username;
				properties.birthDate = typeObjLib.birthDate;
			}

			if(contextData.type == typeObj.organization.col ){
				properties.type = typeObjLib.typeOrga;
				properties.tags = typeObjLib.tags();
			}

			if(contextData.type == typeObj.project.col ){
				properties.avancement = typeObjLib.avancementProject;
			}

			if(contextData.type == typeObj.person.col || contextData.type == typeObj.organization.col ){
				properties.email = typeObjLib.email;
				
			}
			properties.url = typeObjLib.url;
			properties.fixe= typeObjLib.phone;
			properties.mobile= typeObjLib.mobile;
			properties.fax= typeObjLib.fax;

			var dataUpdate = {
				block : "info",
		        id : contextData.id,
		        typeElement : contextData.type,
		        name : contextData.name,	
			};
			
			if(contextData.tags.length > 0)
				dataUpdate.tags = contextData.tags;

			if(contextData.type == typeObj.person.col ){
				if(contextData.username.length > 0)
					dataUpdate.username = contextData.username;
				if(contextData.birthDate.length > 0)
					dataUpdate.birthDate = contextData.birthDate;
			}

			if(contextData.type == typeObj.organization.col ){
				if(contextData.typeOrga.length > 0)
					dataUpdate.type = contextData.typeOrga;
			}
			if(contextData.type == typeObj.project.col ){
				if(contextData.avancement.length > 0)
					dataUpdate.avancement = contextData.avancement;
			}
			if(contextData.type == typeObj.person.col || contextData.type == typeObj.organization.col ){
				if(contextData.email != "") 
					dataUpdate.email = contextData.email;
			}

			if(contextData.url != "") 
				dataUpdate.url = contextData.url;
			if(contextData.fixe.length > 0)
				dataUpdate.fixe = contextData.fixe;
			if(contextData.mobile.length > 0)
				dataUpdate.mobile = contextData.mobile;
			if(contextData.fax.length > 0)
				dataUpdate.fax = contextData.fax;

			mylog.log("dataUpdate", dataUpdate);

			var onLoads = {
				initUpdateInfo : function(){
					mylog.log("initUpdateInfo");
					$(".emailtext").slideToggle();
				}
			};

			var beforeSave = function(){
				mylog.log("beforeSave");
		    	if($("#ajaxFormModal #name").length && $("#ajaxFormModal #name").val() == contextData.name)
		    		$("#ajaxFormModal #name").remove();

		    	if($("#ajaxFormModal #tags").length && $("#ajaxFormModal #tags").val() ==  contextData.tags)
		    		$("#ajaxFormModal #tags").remove();

		    	if(contextData.type == typeObj.person.col ){
			    	if($("#ajaxFormModal #username").length && $("#ajaxFormModal #username").val() == contextData.username)
			    		$("#ajaxFormModal #username").remove();
			    	if($("#ajaxFormModal #birthDate").length && $("#ajaxFormModal #birthDate").val() ==  contextData.birthDate)
			    		$("#ajaxFormModal #birthDate").remove();
			    }

			    if(contextData.type == typeObj.organization.col ){
					if($("#ajaxFormModal #type").length && $("#ajaxFormModal #type").val() ==  contextData.typeOrga)
			    		$("#ajaxFormModal #type").remove();
				}

				if(contextData.type == typeObj.project.col ){
					if($("#ajaxFormModal #avancement").length && $("#ajaxFormModal #avancement").val() ==  contextData.avancement)
			    		$("#ajaxFormModal #avancement").remove();
				}

				if(contextData.type == typeObj.person.col ){
					if($("#ajaxFormModal #email").length && $("#ajaxFormModal #email").val() == contextData.email)
			    		$("#ajaxFormModal #email").remove();
			    }

				if($("#ajaxFormModal #url").length && $("#ajaxFormModal #url").val() == contextData.url)
		    		$("#ajaxFormModal #url").remove();

		    	if($("#ajaxFormModal #fixe").length && $("#ajaxFormModal #fixe").val() ==  contextData.fixe)
		    		$("#ajaxFormModal #fixe").remove();
		    	
		    	if($("#ajaxFormModal #mobile").length && $("#ajaxFormModal #mobile").val() == contextData.mobile)
		    		$("#ajaxFormModal #mobile").remove();

		    	if($("#ajaxFormModal #fax").length && $("#ajaxFormModal #fax").val() ==  contextData.fax)
		    		$("#ajaxFormModal #fax").remove();

		    };

			var afterSave = function(data){
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
						contextData.typeOrga = data.resultGoods.values.typeOrga;
						$("#typeHeader").html(contextData.typeOrga);
						$("#typeAbout").html(contextData.typeOrga);
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
						$("#urlAbout").attr("href", url);
					}  
						
					if(typeof data.resultGoods.values.birthDate != "undefined"){
						mylog.log("update birthDate");
						contextData.birthDate = data.resultGoods.values.birthDate;
						$("#birthDateAbout").html(contextData.birthDate);
					}

					if(typeof data.resultGoods.values.fixe != "undefined"){
						mylog.log("update fixe");
						contextData.fixe = parsePhone(data.resultGoods.values.fixe);
						$("#fixeAbout").html(str);
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
				elementLib.closeForm();
				changeHiddenFields();
			};
			
			var saveUrl = baseUrl+"/"+moduleId+"/element/updateblock/type/"+contextType;
			elementLib.editDynForm("Modifier les coordonnées", "fa-pencil", properties, "", dataUpdate, saveUrl, onLoads, beforeSave, afterSave);
		});

		$(".btn-update-desc").off().on( "click", function(){
			var dataUpdate = { value : $("#descriptionMarkdown").val() } ;
			var properties = {
				value : typeObjLib.description,
				pk : {
		            inputType : "hidden",
		            value : contextData.id
		        },
				name: {
		            inputType : "hidden",
		            value : "description"
		        }
			};

			var onLoads = {
				markdown : function(){
					mylog.log("#btn-update-desc #ajaxFormModal #description");
					activateMarkdown("#ajaxFormModal #value");
				}
			};
			var beforeSave = null ;

			var afterSave = function(data){
				$("#central-container").html(markdownToHtml(data.description));
				$("#descriptionMarkdown").val(data.description);
				//smallMenu.open( markdownToHtml(data.description);
				elementLib.closeForm();		
			};
			
			var saveUrl = baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextType;
			elementLib.editDynForm("Modifier la description", "fa-pencil", properties, "markdown", dataUpdate, saveUrl, onLoads, beforeSave, afterSave);
		});

		$(".btn-update-shortDesc").off().on( "click", function(){
			var dataUpdate = { value : $("#shortDescriptionHeader").html() } ;
			var properties = {
				value : typeObjLib.shortDescription,
				pk : {
		            inputType : "hidden",
		            value : contextData.id
		        },
				name: {
		            inputType : "hidden",
		            value : "shortDescription"
		        }
			};

			var onLoads = null;
			var beforeSave = null ;

			var afterSave = function(data){
				$("#shortDescriptionHeader").html(data.shortDescription);
				elementLib.closeForm();		
			};
			
			var saveUrl = baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextType;
			elementLib.editDynForm("Modifier la description", "fa-pencil", properties, "markdown", dataUpdate, saveUrl, onLoads, beforeSave, afterSave);
		});


		$(".btn-update-network").off().on( "click", function(){
			if(contextData.type == typeObj.person.col ){
				var properties = {
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

				var dataUpdate = {
					block : "network",
			        id : contextData.id,
			        typeElement : contextData.type,
				};
				
				if(contextData.twitter.length > 0)
					dataUpdate.twitter = contextData.twitter;
				if(contextData.gpplus.length > 0)
					dataUpdate.gpplus = contextData.gpplus;
				if(contextData.gitHub.length > 0)
					dataUpdate.gitHub = contextData.gitHub;
				if(contextData.skype.length > 0)
					dataUpdate.skype = contextData.skype;
				if(contextData.telegram.length > 0)
					dataUpdate.telegram = contextData.telegram;
				if(contextData.facebook.length > 0)
					dataUpdate.facebook = contextData.facebook;


				mylog.log("dataUpdate", dataUpdate);

				var onLoads = null;

				
				var beforeSave = function(){
					mylog.log("beforeSave");
			    	
			    	if($("#ajaxFormModal #telegram").length && $("#ajaxFormModal #telegram").val() ==  contextData.telegram)
			    		$("#ajaxFormModal #telegram").remove();

			    	if($("#ajaxFormModal #gitHub").length && $("#ajaxFormModal #gitHub").val() == contextData.gitHub)
			    		$("#ajaxFormModal #gitHub").remove();

			    	if($("#ajaxFormModal #skype").length && $("#ajaxFormModal #skype").val() ==  contextData.skype)
			    		$("#ajaxFormModal #skype").remove();

			    	if($("#ajaxFormModal #twitter").length && $("#ajaxFormModal #twitter").val() ==  contextData.twitter)
			    		$("#ajaxFormModal #twitter").remove();

			    	if($("#ajaxFormModal #facebook").length && $("#ajaxFormModal #facebook").val() ==  contextData.facebook)
			    		$("#ajaxFormModal #facebook").remove();

			    	if($("#ajaxFormModal #gpplus").length && $("#ajaxFormModal #gpplus").val() ==  contextData.gpplus)
			    		$("#ajaxFormModal #gpplus").remove();
			    };

				var afterSave = function(data){
					mylog.dir(data);
					if(data.result && data.resultGoods.result){

						if(typeof data.resultGoods.values.telegram != "undefined"){
							contextData.telegram = data.resultGoods.values.telegram.trim();
							changeNetwork('#telegramAbout', contextData.telegram, 'https://web.telegram.org/#/im?p=@'+contextData.telegram);
						}

						if(typeof data.resultGoods.values.facebook != "undefined"){
							contextData.facebook = data.resultGoods.values.facebook.trim();
							//var iconNetwork = ((contextData.facebook=="")?"":'<i class="fa fa-facebook"></i>');
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
					elementLib.closeForm();
					changeHiddenFields();
				};
				
				var saveUrl = baseUrl+"/"+moduleId+"/element/updateblock/type/"+contextType;
				elementLib.editDynForm("Modifier vos comptes", "fa-pencil", properties, "", dataUpdate, saveUrl, onLoads, beforeSave, afterSave);
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
