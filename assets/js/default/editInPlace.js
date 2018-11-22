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
						"mobile","fax", "facebook", "twitter", "gpplus", "github", "skype", "instagram","telegram","diaspora","mastodon"];
		
		$.each(listFields, function(i,value) {
			mylog.log("listFields", value, typeof contextData[value]);
			if(typeof contextData[value] != "undefined" && contextData[value].length == 0)
				$("."+value).val("<i>"+trad.notSpecified+"<i>");
		});
		mylog.log("-----------------changeHiddenFields END----------------------");
	}

	function updateCalendar() {
		if(contextData.type == typeObj.event.col){
			getAjax(".calendar",baseUrl+"/"+moduleId+"/event/calendarview/id/"+contextData.id +"/pod/1?date=1",null,"html");
		}
	}

	function removeAddresses (index, formInMap){

		bootbox.confirm({
			message: trad.suredeletelocality+"<span class='text-red'></span>",
			buttons: {
				confirm: {
					label: trad.yes,
					className: 'btn-success'
				},
				cancel: {
					label: trad.no,
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

								if(formInMap == true){
									$(".locationEl"+ index).remove();
									dyFInputs.locationObj.elementLocation = null;
									dyFInputs.locationObj.elementLocations.splice(ix,1);
									//TODO check if this center then apply on first
									//$(".locationEl"+dyFInputs.locationObj.countLocation).remove();
								}
								else
									urlCtrl.loadByHash(location.hash);
					    	}
					    }
					});
				}
			}
		});		
	}

	function bindDynFormEditable(){ 
		$(".btn-update-when").off().on( "click", function(){
			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				dynForm : {
					jsonSchema : {

						title : trad["Update date"],
						icon : "fa-key",
						onLoads : {
							initUpdateWhen : function(){
								mylog.log("initUpdateInfo");
								$("#ajax-modal .modal-header").removeClass("bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
											  					  .addClass("bg-dark");
							}
						},
						beforeSave : function(){
							mylog.log("beforeSave");
							var allDay = $("#ajaxFormModal #allDay").is(':checked');
							$("#ajaxFormModal #allDayHidden").val(allDay);
					    	removeFieldUpdateDynForm(contextData.type);
					    	
					    	var dateformat = "DD/MM/YYYY";
					    	//var outputFormat="YYYY-MM-DD";
					    	if (! allDay && contextData.type == typeObj.event.col) {
					    		var dateformat = "DD/MM/YYYY HH:mm" ;
					    		//var outputFormat="YYYY-MM-DD HH::mm";
					    	}
					  //   	$("#ajaxFormModal #startDate").val( moment( $("#ajaxFormModal #startDate").val(), dateformat).format(outputFormat));
							// $("#ajaxFormModal #endDate").val( moment( $("#ajaxFormModal #endDate").val(), dateformat).format(outputFormat));
							$("#ajaxFormModal #startDate").val( moment( $("#ajaxFormModal #startDate").val(), dateformat).format());
							$("#ajaxFormModal #endDate").val( moment( $("#ajaxFormModal #endDate").val(), dateformat).format());
					    },

						afterSave : function(data){
							mylog.dir(data);
							if(data.result&& data.resultGoods && data.resultGoods.result){
								if(typeof data.resultGoods.values.allDay != "undefined"){
									contextData.allDay = data.resultGoods.values.allDay;

									$("#allDayAbout").html((contextData.allDay ? trad["yes"] : trad["no"]));
								}  
								if(typeof data.resultGoods.values.startDate != "undefined"){
									contextData.startDate = data.resultGoods.values.startDate;
									//contextData.startDateDB = data.resultGoods.values.startDate;
									//$("#startDateAbout").html(moment(contextData.startDate).local().locale("fr").format(formatDateView));
									//$("#startDateAbout").html(directory.returnDate(contextData.startDate, formatDateView));
								}  
								if(typeof data.resultGoods.values.endDate != "undefined"){
									contextData.endDate = data.resultGoods.values.endDate;
									//contextData.endDateDB = data.resultGoods.values.endDate;
									//$("#endDateAbout").html(moment(contextData.endDate).local().locale("fr").format(formatDateView));
									//$("#endDateAbout").html(directory.returnDate(contextData.endDate, formatDateView));
								}
								initDateHeaderPage(contextData);
								initDate();
								updateCalendar();
							}
							//urlCtrl.loadByHash(location.hash);
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

			var typeDate = "date";
			if(contextData.type == typeObj.event.col){
				var checked = (notNull(contextData.allDay) && contextData.allDay == true) ?  true : false ;
				form.dynForm.jsonSchema.properties.allDay = dyFInputs.allDay(checked);
				form.dynForm.jsonSchema.properties.allDayHidden = dyFInputs.inputHidden(checked);
				mylog.log("allDay", checked)
				if(checked == false )
					typeDate = "datetime";
				
			}
			
			
			form.dynForm.jsonSchema.properties.startDate = dyFInputs.startDateInput(typeDate);
			form.dynForm.jsonSchema.properties.endDate = dyFInputs.endDateInput(typeDate);

			var dataUpdate = {
				block : "when",
		        id : contextData.id,
		        typeElement : contextData.type,
			};
			
			if(notEmpty(contextData.startDateDB))
				dataUpdate.startDate = moment(contextData.startDateDB/*,"YYYY-MM-DD HH:mm"*/).local().format(formatDatedynForm);

			if(notEmpty(contextData.endDateDB))
				dataUpdate.endDate = moment(contextData.endDateDB/*,"YYYY-MM-DD HH:mm"*/).local().format(formatDatedynForm);

			mylog.log("btn-update-when", form, dataUpdate, formatDatedynForm);
			dyFObj.openForm(form, "initUpdateWhen", dataUpdate);
		});

		$(".btn-update-info").off().on( "click", function(){ 
			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				dynForm : {
					jsonSchema : {
						title : trad["Update general information"],
						icon : "fa-key",
						type: "object",
						onLoads : {
							initUpdateInfo : function(){
								mylog.log("initUpdateInfo");
								$(".emailOptionneltext").slideToggle();
								$("#ajax-modal .modal-header").removeClass("bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
											  					  .addClass("bg-dark");
							},
							onload : function (data) { 
								//this is a hack too a strange bug
								//this select doesn't carry it's value
								if( contextData.type == typeObj.event.col || contextData.type == typeObj.organization.col )
									$("#type").val(data.type);
							}
						},
						beforeSave : function(){
							mylog.log("beforeSave");
							removeFieldUpdateDynForm(contextData.type);
					    },
						afterSave : function(data){
							mylog.dir(data);
							if(data.result&& data.resultGoods && data.resultGoods.result){

								if(typeof data.resultGoods.values.name != "undefined"){
									contextData.name = data.resultGoods.values.name;
									$("#nameHeader > .name-header").html(contextData.name);
									$("#nameAbout").html(contextData.name);
									if(inMyContacts(contextData.type, contextData.id))
										changeNameFloopEntity(contextData.id, contextData.type, contextData.name);
								}

								if(typeof data.resultGoods.values.username != "undefined"){
									contextData.username = data.resultGoods.values.username;
									$("#usernameAbout").html(contextData.username);
								}
									
								if(typeof data.resultGoods.values.tags != "undefined"){
									contextData.tags = data.resultGoods.values.tags;
									var strHeader = "";
									var strAbout = trad["notSpecified"];
									if($('.header-tags').length && typeof contextData.tags != "undefined" && contextData.tags.length > 0){
										strAbout = "" ;
										$.each(contextData.tags, function (key, tag){
											/*str +=	'<div class="tag label label-danger pull-right" data-val="'+tag+'">'+
														'<i class="fa fa-tag"></i>'+tag+
													'</div>';*/
											strHeader += '<span class="badge letter-red bg-white" style="vertical-align: top;">#'+tag+'</span>';
											/*if(typeof globalTheme == "undefined" || globalTheme != "network")
												addTagToMultitag(tag);*/
											strAbout +=	'<span class="badge letter-red bg-white">'+tag+'</span>';
										});
									}
									$('.header-tags').html(strHeader);
									$('#tagsAbout').html(strAbout);
									if(strHeader == "" && typeof contextData.address == "undefined")
										$('.header-address-tags').addClass("hidden");
									else
										$('.header-address-tags').removeClass("hidden");

									if(strHeader == "")
										$('#separateurTag').addClass("hidden");
									else
										$('#separateurTag').removeClass("hidden");

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
									$('#avancementAbout').html(trad[contextData.avancement] );
								}

								if(typeof data.resultGoods.values.type != "undefined"){

									if(contextData.type == typeObj.organization.col ){
										contextData.typeOrga = data.resultGoods.values.type;
										$(".pastille-type-element").removeClass("bg-azure bg-red bg-green bg-turq").addClass("bg-"+typeObj[contextData.typeOrga]["color"]);
										$("#nameHeader").find("i").removeClass("fa-university fa-industry fa-users fa-group").addClass("fa-"+typeObj[contextData.typeOrga]["icon"]);
									}
									else
										contextData.typeEvent = data.resultGoods.values.type;
									//$("#typeHeader").html(data.resultGoods.values.type);
									$("#typeAbout").html(tradCategory[data.resultGoods.values.type]);
									$("#typeHeader .type-header").html(tradCategory[data.resultGoods.values.type]);
								}

								if(typeof data.resultGoods.values.email != "undefined"){
									mylog.log("update email");
									contextData.email = data.resultGoods.values.email;
									$("#emailAbout").html(contextData.email);
								}

								if(typeof data.resultGoods.values.url != "undefined"){
									mylog.log("update url");
									contextData.url = data.resultGoods.values.url.trim();
									if(contextData.url != "" ){
										$("#webAbout").html('<a href="'+contextData.url+'" target="_blank" id="urlWebAbout" style="cursor:pointer;">'+contextData.url+'</a>');
									}else{
										$("#webAbout").html("<i>"+trad["notSpecified"]+"</i>");
									}
								}  
									
								if(typeof data.resultGoods.values.birthDate != "undefined"){
									mylog.log("update birthDate");
									contextData.birthDate = data.resultGoods.values.birthDate;
									$("#birthDateAbout").html(moment(contextData.birthDate).local().format("DD/MM/YYYY"));
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

								if(typeof data.resultGoods.values.parent != "undefined"){
									mylog.log("modif parent", data.resultGoods.values.parent);
									contextData.parent = data.resultGoods.values.parent.parent;
									contextData.parentId = data.resultGoods.values.parent.parentId;
									contextData.parentType = data.resultGoods.values.parent.parentType;

									var htmlAbout = "<i>"+trad["notSpecified"]+"</i>";
									var htmlHeader = "";

									if(notEmpty(contextData.parentId) && contextData.parentId != "dontKnow"){
										htmlAbout = '<a href="#page.type.'+contextData.parentType+'.id.'+contextData.parentId+'" class="lbh">'+ 
											'<i class="fa fa-'+dyFInputs.get(contextData.parentType).icon+'"></i> '+
											contextData.parent.name+'</a><br/>';

										htmlHeader =((contextData.type == typeObj.event.col) ? trad["Planned on"] : trad.carriedby ) ;
										htmlHeader += htmlAbout;
									}

									$("#parentAbout").html(htmlAbout);
									$("#parentHeader").html(htmlHeader);
								}

								if(typeof data.resultGoods.values.organizer != "undefined"){
									mylog.log("modif organizer", data.resultGoods.values.organizer);

									contextData.organizer = data.resultGoods.values.organizer.organizer;
									contextData.organizerId = data.resultGoods.values.organizer.organizerId;
									contextData.organizerType = data.resultGoods.values.organizer.organizerType;

									var html = "<i>"+trad["notSpecified"]+"</i>";
									var htmlHeader = "";

									if(notEmpty(contextData.organizerId) && contextData.organizerId!="dontKnow"){
										html = '<a href="#page.type.'+contextData.organizerType+'.id.'+contextData.organizerId+'" class="lbh">'+ 
													'<i class="fa fa-'+dyFInputs.get(contextData.organizerType).icon+'"></i> '+
												data.resultGoods.values.organizer.organizer.name+'</a><br/>';
										htmlHeader = tradDynForm.organizedby + " " + html;
									}
									
									$("#organizerAbout").html(html);
									$("#organizerHeader").html(htmlHeader);
								}
							}
							dyFObj.closeForm();
							changeHiddenFields();
						},
						properties : {
							block : dyFInputs.inputHidden(),
							name : dyFInputs.name(contextData.type),
							similarLink : dyFInputs.similarLink,
							typeElement : dyFInputs.inputHidden(),
							isUpdate : dyFInputs.inputHidden(true)
						}
					}
				}
			};

			if(contextData.type == typeObj.person.col ){
				form.dynForm.jsonSchema.properties.username = dyFInputs.inputText("Username", "Username", { required : true });
				form.dynForm.jsonSchema.properties.birthDate = dyFInputs.birthDate;
			}

			if(contextData.type == typeObj.organization.col ){
				form.dynForm.jsonSchema.properties.type = dyFInputs.inputSelect(tradDynForm.organizationType, tradDynForm.organizationType, organizationTypes, { required : true });
			}else if(contextData.type == typeObj.event.col ){
				mylog.log("Type event ", typeObj.event.col, contextData.type);
				form.dynForm.jsonSchema.properties.type = dyFInputs.inputSelect(tradDynForm.eventTypes, tradDynForm.eventTypes, eventTypes, { required : true });
			}else if( contextData.type == typeObj.project.col ){
				form.dynForm.jsonSchema.properties.avancement = dyFInputs.inputSelect(tradDynForm.theprojectmaturity, tradDynForm.projectmaturity, avancementProject);
			}

			form.dynForm.jsonSchema.properties.tags = dyFInputs.tags();
			if($.inArray(contextData.type, [typeObj.organization.col, typeObj.person.col, typeObj.project.col, typeObj.event.col]) > -1 ){
				var ruleMail = ( (contextData.type == typeObj.person.col) ? { email: true, required : true } : { email: true } ) ;
				form.dynForm.jsonSchema.properties.email = dyFInputs.email(tradDynForm.mainemail, tradDynForm.mainemail, ruleMail);
			}
			
			if(contextData.type == typeObj.person.col || contextData.type == typeObj.organization.col ){
				form.dynForm.jsonSchema.properties.fixe= dyFInputs.inputText(tradDynForm["fix"],tradDynForm["enterfixnumber"]);
				form.dynForm.jsonSchema.properties.mobile= dyFInputs.inputText(tradDynForm["mobile"],tradDynForm["entermobilenumber"]);
				form.dynForm.jsonSchema.properties.fax= dyFInputs.inputText(tradDynForm["fax"],tradDynForm["enterfaxnumber"]);
			}

			if(contextData.type != typeObj.poi.col) 
				form.dynForm.jsonSchema.properties.url = dyFInputs.inputUrl();


			var listParent =  ["organizations"] ;

			if(contextData.type == typeObj.event.col)
				listParent =  ["events"] ;
			else if(contextData.type == typeObj.project.col)
				listParent =  ["organizations", "projects"] ;

			if(contextData.type == typeObj.event.col || contextData.type == typeObj.project.col){
				form.dynForm.jsonSchema.properties.parentId = {
		         	label : tradDynForm["ispartofelement"]+" ?",
	            	inputType : "select",
	            	class : "",
	            	placeholder : tradDynForm["ispartofelement"]+" ?",
	            	options : firstOptions(),
	            	"groupOptions" : parentList( listParent, contextData.parentId, contextData.parentType ),
	            	init : function(){ 
	            		mylog.log("init ParentId");
		            	$("#ajaxFormModal #parentId").off().on("change",function(){
							var selected = $(':selected', this);
		            		mylog.log("change ParentId", selected, selected.data('type'));
	    					$("#ajaxFormModal #parentType").val(selected.data('type'));
		            	});
		            }
	            };

	            form.dynForm.jsonSchema.properties.parentType = dyFInputs.inputHidden();
	        }

            if(contextData.type == typeObj.event.col){
            	form.dynForm.jsonSchema.properties.organizerId =  dyFInputs.organizerId(contextData.parentId, contextData.parentType);
	            form.dynForm.jsonSchema.properties.organizerType = dyFInputs.inputHidden();
            }
            
			
			var dataUpdate = {
				block : "info",
		        id : contextData.id,
		        typeElement : contextData.type,
		        name : contextData.name,	
			};
			if(notNull(contextData.slug) && contextData.slug.length > 0)
				dataUpdate.slug = contextData.slug;

			if(notNull(contextData.tags) && contextData.tags.length > 0)
				dataUpdate.tags = contextData.tags;

			if(contextData.type == typeObj.person.col ){
				if(notNull(contextData.username) && contextData.username.length > 0)
					dataUpdate.username = contextData.username;
				if(notEmpty(contextData.birthDate))
					dataUpdate.birthDate = moment(contextData.birthDate).local().format("DD/MM/YYYY");
			}
			
			mylog.log("ORGA ", contextData.type, typeObj.organization.col, dataUpdate.type);
			
			if(contextData.type == typeObj.organization.col ){
				mylog.log("ORGA type", contextData.typeOrga, contextData.typeOrganization);
				if(notEmpty(contextData.typeOrga))
					dataUpdate.type = contextData.typeOrga;
				mylog.log("ORGA resultType", dataUpdate.type);
			}else if(contextData.type == typeObj.event.col ){
				if(jsonHelper.notNull("contextData.typeEvent") )
					dataUpdate.type = contextData.typeEvent;
			}else if(contextData.type == typeObj.project.col ){
				if(notEmpty(contextData.avancement))
					dataUpdate.avancement = contextData.avancement;
			}

			if($.inArray(contextData.type, [typeObj.organization.col, typeObj.person.col, typeObj.project.col, typeObj.event.col]) > -1 ){
				mylog.log("test email", contextData, contextData.email);
				if(notEmpty(contextData.email)) {
					mylog.log("test email2", contextData, contextData.email);
					dataUpdate.email = contextData.email;
				}
				if(notEmpty(contextData.fixe))
					dataUpdate.fixe = contextData.fixe;
				if(notEmpty(contextData.mobile))
					dataUpdate.mobile = contextData.mobile;
				if(notEmpty(contextData.fax))
					dataUpdate.fax = contextData.fax;
			}
			
			if(contextData.type != typeObj.poi.col && notEmpty(contextData.url)) 
				dataUpdate.url = contextData.url;

			if(notEmpty(contextData.parentId)) 
				dataUpdate.parentId = contextData.parentId;
			else
				dataUpdate.parentId = "dontKnow";

			if(notEmpty(contextData.parentType)) 
				dataUpdate.parentType = contextData.parentType;

			if(notEmpty(contextData.organizerId)) 
				dataUpdate.organizerId = contextData.organizerId;

			if(notEmpty(contextData.organizerType)) 
				dataUpdate.organizerType = contextData.organizerType;
			
			mylog.log("dataUpdate", dataUpdate);
			dyFObj.openForm(form, "initUpdateInfo", dataUpdate);
		});

		$(".btn-update-descriptions").off().on( "click", function(){

			var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				dynForm : {
					jsonSchema : {
						title : trad["Update description"],
						icon : "fa-key",
						onLoads : {
							
							markdown : function(){
								dataHelper.activateMarkdown("#ajaxFormModal #description");
								$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
											  					  .addClass("bg-dark");
								//bindDesc("#ajaxFormModal");
							}
						},
						afterSave : function(data){
							mylog.dir(data);
							if(data.result&& data.resultGoods && data.resultGoods.result){
								if(data.resultGoods.values.shortDescription=="")
									$(".contentInformation #shortDescriptionAbout").html('<i>'+trad["notSpecified"]+'</i>');
								else
									$(".contentInformation #shortDescriptionAbout").html(data.resultGoods.values.shortDescription);
								$(".contentInformation #shortDescriptionAboutEdit").html(data.resultGoods.values.shortDescription);
								$("#shortDescriptionHeader").html(data.resultGoods.values.shortDescription);
								if(data.resultGoods.values.description=="")
									$(".contentInformation #descriptionAbout").html(dataHelper.markdownToHtml('<i>'+trad["notSpecified"]+'</i>'));
								else
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
							shortDescription : 	dyFInputs.textarea(tradDynForm["shortDescription"], "...",{ maxlength: 140 }),
							description : dyFInputs.textarea(tradDynForm["longDescription"], "..."),
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
						title : trad["Update network"],
						icon : "fa-key",
						onLoads : {
							sub : function(){
								$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
											  				  .addClass("bg-dark");
								//bindDesc("#ajaxFormModal");
							}
						},
						beforeSave : function(){
							mylog.log("beforeSave", contextData["socialNetwork"]);
					    	//removeFieldUpdateDynForm(contextData.type);
					    	var SNetwork = [ "telegram", "github", "skype", "twitter", "facebook", "gpplus", "instagram", "diaspora", "mastodon"];
							$.each(SNetwork, function(key, val){ 
								mylog.log("val", val);
								mylog.log("val2", $("#ajaxFormModal #"+val).val(), $("#ajaxFormModal #"+val).length);

								if(	notNull(contextData["socialNetwork"]) && 
									notNull(contextData["socialNetwork"][val]) &&
									( 	$("#ajaxFormModal #"+val).length &&
										$("#ajaxFormModal #"+val).val().trim() == contextData["socialNetwork"][val] ) ) {
									mylog.log("if", val);
									$("#ajaxFormModal #"+val).remove();
								} else if (	(	!notNull(contextData["socialNetwork"]) || 
												!notNull(contextData["socialNetwork"][val]) ) && $("#ajaxFormModal #"+val).length ){
									mylog.log("else", val);
									$("#ajaxFormModal #"+val).remove();
								}
									
							});
					    },
						afterSave : function(data){
							mylog.dir(data);
							if(data.result&& data.resultGoods && data.resultGoods.result){

								if(!notEmpty(contextData.socialNetwork))
									contextData.socialNetwork = {};

								if(typeof data.resultGoods.values.telegram != "undefined"){
									contextData.socialNetwork.telegram = data.resultGoods.values.telegram.trim();
									if(contextData.socialNetwork.telegram.length != 0 )
										changeNetwork('#divTelegram', '#telegramAbout', 'https://web.telegram.org/#/im?p=@'+contextData.socialNetwork.telegram, 'https://web.telegram.org/#/im?p=@'+contextData.socialNetwork.telegram);
									else
										changeNetwork('#divTelegram', '#telegramAbout', contextData.socialNetwork.telegram, contextData.socialNetwork.telegram);
								}

								if(typeof data.resultGoods.values.diaspora != "undefined"){
									contextData.socialNetwork.diaspora = data.resultGoods.values.diaspora.trim();
									changeNetwork('#divDiaspora', '#diasporaAbout', contextData.socialNetwork.diaspora, contextData.socialNetwork.diaspora);
								}

								if(typeof data.resultGoods.values.mastodon != "undefined"){
									contextData.socialNetwork.mastodon = data.resultGoods.values.mastodon.trim();
									changeNetwork('#divMastodon', '#mastodonAbout', contextData.socialNetwork.mastodon, contextData.socialNetwork.mastodon);
								}

								if(typeof data.resultGoods.values.facebook != "undefined"){
									contextData.socialNetwork.facebook = data.resultGoods.values.facebook.trim();
									changeNetwork('#divFacebook','#facebookAbout', contextData.socialNetwork.facebook, contextData.socialNetwork.facebook);
								}

								if(typeof data.resultGoods.values.twitter != "undefined"){
									contextData.socialNetwork.twitter = data.resultGoods.values.twitter.trim();
									changeNetwork('#divTwitter','#twitterAbout', contextData.socialNetwork.twitter, contextData.socialNetwork.twitter);
								}

								if(typeof data.resultGoods.values.github != "undefined"){
									contextData.socialNetwork.github = data.resultGoods.values.github.trim();
									changeNetwork('#divGithub','#githubAbout', contextData.socialNetwork.github, contextData.socialNetwork.github);
								}

								if(typeof data.resultGoods.values.skype != "undefined"){
									contextData.socialNetwork.skype = data.resultGoods.values.skype.trim();
									changeNetwork('#divSkype','#skypeAbout', contextData.socialNetwork.skype, contextData.socialNetwork.skype);
								}

								if(typeof data.resultGoods.values.gpplus != "undefined"){
									contextData.socialNetwork.gpplus = data.resultGoods.values.gpplus.trim();
									changeNetwork('#divGpplus','#gpplusAbout', contextData.socialNetwork.gpplus, contextData.socialNetwork.gpplus);
								}

								if(typeof data.resultGoods.values.instagram != "undefined"){
									contextData.socialNetwork.instagram = data.resultGoods.values.instagram.trim();
									changeNetwork('#divInstagram','#instagramAbout', contextData.socialNetwork.instagram, contextData.socialNetwork.instagram);
								}
							}
							dyFObj.closeForm();
							changeHiddenFields();
						},

						properties : {
							block : dyFInputs.inputHidden(),
							typeElement : dyFInputs.inputHidden(),
							isUpdate : dyFInputs.inputHidden(true), 
							skype : dyFInputs.inputUrl(tradDynForm["linkSkype"]),
							github : dyFInputs.inputUrl(tradDynForm["linkGithub"]), 
							gpplus : dyFInputs.inputUrl(tradDynForm["linkGplus"]),
							twitter : dyFInputs.inputUrl(tradDynForm["linkTwitter"]),
							facebook :  dyFInputs.inputUrl(tradDynForm["linkFacebook"]),
							instagram :  dyFInputs.inputUrl(tradDynForm["linkInstagram"]),
					        diaspora :  dyFInputs.inputUrl(tradDynForm["linkDiaspora"]),
					        mastodon :  dyFInputs.inputUrl(tradDynForm["linkMastodon"]),
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

			if(notEmpty(contextData.socialNetwork) )
			{
				if( notEmpty(contextData.socialNetwork.twitter) )
					dataUpdate.twitter = contextData.socialNetwork.twitter;
				if( notEmpty(contextData.socialNetwork.gpplus) )
					dataUpdate.gpplus = contextData.socialNetwork.gpplus;
				if( notEmpty(contextData.socialNetwork.github) )
					dataUpdate.github = contextData.socialNetwork.github;
				if( notEmpty(contextData.socialNetwork.skype) )
					dataUpdate.skype = contextData.socialNetwork.skype;
				if( notEmpty(contextData.socialNetwork.telegram) )
					dataUpdate.telegram = contextData.socialNetwork.telegram;
				if( notEmpty(contextData.socialNetwork.facebook) )
					dataUpdate.facebook = contextData.socialNetwork.facebook;
				if(notEmpty(contextData.socialNetwork.instagram))
					dataUpdate.instagram = contextData.socialNetwork.instagram;
				if( notEmpty(contextData.socialNetwork.diaspora) )
					dataUpdate.diaspora = contextData.socialNetwork.diaspora;
				if( notEmpty(contextData.socialNetwork.mastodon) )
					dataUpdate.mastodon = contextData.socialNetwork.mastodon;
			}
			dyFObj.openForm(form, "sub", dataUpdate);

			
		});
	}
	
	function changeNetwork(id, idUrl, url, str){
		mylog.log("changeNetwork", id, idUrl, url, str.length);
		//$(id).attr('href', url);

		if(str.length == 0)
			$(id).html(trad.notSpecified);
		else
			$(id).html('<a href="'+idUrl+'" target="_blank" id="'+id+'" class="socialIcon" >'+str+'</a>');



		
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


	/*function bindDesc(parent){
		$(".maxlengthTextarea").off().keyup(function(){
			var name = "#" + $(this).attr("id") ;
			mylog.log(".maxlengthTextarea", parent+" "+name, $(this).attr("id"), $(parent+" "+name).val().length, $(this).val().length);
			$(parent+" #maxlength"+$(this).attr("id")).html($(parent+" "+name).val().length);
			maxlengthshortDescription
		});
	}*/


	function updateUrl(ind, title, url, type) {
		mylog.log("updateUrl", ind, title, url, type);
		var params = {
			title : title,
			type : type,
			url : url,
			index : ind.toString()
		}
		mylog.log("params",params);
		dyFObj.openForm( 'url','sub', params);
	}

	function updateRoles(childId, childType, childName, connectType, roles) {
		var form = {
				saveUrl : baseUrl+"/"+moduleId+"/link/removerole/",
				dynForm : {
					jsonSchema : {
						title : tradDynForm.modifyoraddroles+"<br/>"+childName,// trad["Update network"],
						icon : "fa-key",
						onLoads : {
							sub : function(){
								$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
											  				  .addClass("bg-dark");
								//bindDesc("#ajaxFormModal");
							}
						},
						beforeSave : function(){
							mylog.log("beforeSave");
					    	//removeFieldUpdateDynForm(contextData.type);
					    },
						afterSave : function(data){
							mylog.dir(data);
							dyFObj.closeForm();
							loadDataDirectory(connectType, "user", true);
							//changeHiddenFields();
						},
						properties : {
							contextId : dyFInputs.inputHidden(),
							contextType : dyFInputs.inputHidden(), 
							roles : dyFInputs.tags(rolesList, tradDynForm["addroles"] , tradDynForm["addroles"]),
							childId : dyFInputs.inputHidden(), 
							childType : dyFInputs.inputHidden(),
							connectType : dyFInputs.inputHidden()
						}
					}
				}
			};

			var dataUpdate = {
		        contextId : contextData.id,
		        contextType : contextData.type,
		        childId : childId,
		        childType : childType,
		        connectType : connectType,
			};

			if(notEmpty(roles))
				dataUpdate.roles = roles.split(",");
			dyFObj.openForm(form, "sub", dataUpdate);		
	}
	function updateBookmark(id) {
		mylog.log("updBook",id);
		filesUp=docsList[id];
		var params=new Object;
		params.id=id;
		if(filesUp.url != "undefined")
			params.url=filesUp.url;
		if(filesUp.name != "undefined")
			params.name=filesUp.name;
		if(filesUp.tags != "undefined")
			params.tags=filesUp.tags;
		if(filesUp.description != "undefined")
			params.description=filesUp.description;
		mylog.log("params",params);
		dyFObj.openForm( 'bookmark','sub', params);
	}


	function updateContact(ind, name, email, role, telephone) {
		mylog.log("updateContact", ind, name, email, role, telephone);
		dataUpdate = { index : ind.toString() } ;
		if(name != "undefined")
			dataUpdate.name = name;
		if(email != "undefined")
			dataUpdate.email = email;
		if(role != "undefined")
			dataUpdate.role = role;
		if(telephone != "undefined")
			dataUpdate.phone = telephone;
		mylog.log("dataUpdate", dataUpdate);
		dyFObj.openForm ('contactPoint','sub', dataUpdate);
	}
	function updateDocument(id, title) {
		mylog.log("updateDocument", id, name);
		dataUpdate = { docId : id } ;
		if(title != "undefined")
			dataUpdate.title = title;
		mylog.log("dataUpdate", dataUpdate);
		dyFObj.openForm ('document','sub', dataUpdate);
	}

	function removeUrl(ind) {
		bootbox.confirm({
			message: trad["suretodeletelink"]+"<span class='text-red'></span>",
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
			}
		});
		
	}

	function removeContact(ind) {
		bootbox.confirm({
			message: trad["suretodeletecontact"]+"<span class='text-red'></span>",
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
					param = new Object;
			    	param.name = "contacts";
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
			}
		});
	}

	function updateNetwork(id) {
		mylog.log("updateNetwork", id);
		$.ajax({
			type: "POST",
			url: baseUrl+"/"+moduleId+"/network/get/id/"+id,
			data: {},
			dataType: "json",
			success: function(data){
				mylog.log("data", data);
				var update = {};
				update.id = id;
				update.visible = data.visible;
				update["skin[title]"] = data.skin.title;
				update["skin[shortDescription]"] = data.skin.title;
				update["skin[logo]"] = data.skin.logo;
				update["displayCommunexion"] = dataHelper.stringToBool(data.skin.displayCommunexion);
				//update["add"] = dataHelper.stringToBool(data.skin.add);
				update["request[scope]"] = data.request.scope;
				update["request[searchType]"] = data.request.searchType;
				update["request[searchTag]"] = data.request.searchTag;
				update["request[sourceKey]"] = data.request.sourceKey;

				update.visible = data.visible;

				var filters = [] ;
				var i = 0 ;
				$.each(data.filter.linksTag, function(cat, fil){
					var f = {};
					f.name = cat;
					$.each(fil,function(ktag,vtag) {
						i = 0 ;
						if(ktag == "tags"){
							mylog.log("updateNetwork vtag", typeof vtag, vtag);
							$.each(vtag,function(k,v) {
								f["keyVal"+i] = k ;
								f["tagskeyVal"+i] = v.toString();
								i++;
							});
							
						}
					});
					filters.push( f );
				});
				update.filter = filters;
				dyFObj.openForm( 'network','sub', update);
			}
		});
		
	}

	function removeNetwork(id) {
		bootbox.confirm({
			message: trad["suretodeletecontact"]+"<span class='text-red'></span>",
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
				alert("Voir avec TIBTIB");
				// if (!result) {
				// 	return;
				// } else {
				// 	param = new Object;
			 //    	param.id = id;
			 //    	param.userId = userId;
				// 	$.ajax({
				//         type: "POST",
				//         url: baseUrl+"/"+moduleId+"/network/remove",
				//         data: param,
				//        	dataType: "json",
				//     	success: function(data){
				//     		mylog.log("data", data);
				// 	    	if(data.result){
				// 				toastr.success(data.msg);
				// 				urlCtrl.loadByHash(location.hash);
				// 	    	}
				// 	    }
				// 	});
				// }
			}
		});
	}

	function removeFieldUpdateDynForm(collection){
		mylog.log("------------------------ removeFieldUpdateDynForm", collection);
		var fieldsElement = [ 	"name", "slug", "tags", "email", "url", "fixe", "mobile", "fax", 
								"telegram", "github", "skype", "twitter", "facebook", "gpplus",
								"diaspora","mastodon"];
		var fieldsPerson = ["username",  "birthDate"];
		var fieldsProject = [ "avancement", "startDate", "endDate", "parentId" ];
		var fieldsOrga = [ "type", "parentId" ];
		var fieldsEvent = [ "type", "startDate", "endDate", "parentId", , "organizerId"];

		var SNetwork = [ "telegram", "github", "skype", "twitter", "facebook", "gpplus","diaspora","mastodon"];

		if(collection == typeObj.person.col)
			fieldsElement = fieldsElement.concat(fieldsPerson);
		else if(collection == typeObj.project.col)
			fieldsElement = fieldsElement.concat(fieldsProject);
		else if(collection == typeObj.organization.col)
			fieldsElement = fieldsElement.concat(fieldsOrga)
		else if(collection == typeObj.event.col)
			fieldsElement = fieldsElement.concat(fieldsEvent);
		var valCD = "";


		$.each(fieldsElement, function(key, val){ 

			valCD = val;
			if(val == "type" && collection == typeObj.organization.col)
				valCD = "typeOrga";
			else if(val == "type" && collection == typeObj.event.col)
				valCD = "typeEvent";

			mylog.log("val", val, valCD);
			mylog.log("val2", $("#ajaxFormModal #"+val).length);
			if(	$("#ajaxFormModal #"+val).length && 
				( 	( 	typeof contextData[valCD] != "undefined" && 
						contextData[valCD] != null && 
						$("#ajaxFormModal #"+val).val() == contextData[valCD] 
					) ||  
					( 	( 	typeof contextData[valCD] == "undefined" || 
							contextData[valCD] == null ) && 
						$("#ajaxFormModal #"+val).val().trim().length == 0 ) || 
					//social network
					( 	$.inArray( val, SNetwork ) >= 0 && 
						( 	typeof contextData["socialNetwork"] != "undefined" && 
							contextData["socialNetwork"] != null ) && 
						(
							( 	typeof contextData["socialNetwork"][val] != "undefined" || 
								contextData["socialNetwork"][val] != null && 
								$("#ajaxFormModal #"+val).val().trim() == contextData["socialNetwork"][val] )
							||
							( 	( 	typeof contextData["socialNetwork"][val] == "undefined" || 
								contextData["socialNetwork"][val] == null ) && 
							$("#ajaxFormModal #"+val).val().trim().length == 0 ) )
					)
				) 
			) {
				$("#ajaxFormModal #"+val).remove();
			}
			else if(val == "birthDate"){
				var dateformat = "DD/MM/YYYY";
			    $("#ajaxFormModal #"+val).val( moment( $("#ajaxFormModal #"+val).val(), dateformat).format());
			}

		});
	}


