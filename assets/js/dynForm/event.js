dynForm = {
    jsonSchema : {
	    title : trad.addEvent,
	    icon : "calendar",
	    type : "object",
	    onLoads : {
	    	onload : function(){
	    		$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-orange");
    	   	},
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
	    		
    			$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-orange");
    		 	$("#ajax-modal-modal-title").html(
    		 		$("#ajax-modal-modal-title").html()+
    		 		" <br><small class='text-white'>"+tradDynForm.speakingas+" : <span class='text-dark'>"+contextData.name+"</span></small>" );
    		 	
    		 	
	    		if(contextData && contextData.type == "events"){
	    			$("#ajaxFormModal #parentId").removeClass('hidden');
	    		
    				if( $('#ajaxFormModal #parentId > optgroup > option[value="'+contextData.id+'"]').length == 0 )
	    				$('#ajaxFormModal #parentId > optgroup[label="events"]').prepend('<option value="'+contextData.id+'" selected>'+tradDynForm.ispartof+' : '+contextData.name+'</option>');
	    			else if ( contextData && contextData.id && contextData.type ){
		    			$("#ajaxFormModal #parentId").val( contextData.id );
		    			$("#ajaxFormModal #parentType").val( contextData.type ); 
	    			} else if(userConnected){
						$('#ajaxFormModal #parentId').val( userId );
						$("#ajaxFormModal #parentType").val( "citoyens" );
	    			}
	    				

	    			if ( contextData && typeof contextData.organizerId != "undefined"){
		    			$("#ajaxFormModal #organizerId").val( contextData.organizerId );
	    			}
	    			if(contextData && typeof contextData.organizerType != "undefined")
	    				$("#ajaxFormModal #organizerType").val( contextData.organizerType );
	    			//$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" sur "+contextData.name );
	    			

	    			if(contextData.startDateDB && contextData.endDateDB){
	    				$("#ajaxFormModal").after("<input type='hidden' id='startDateParent' value='"+contextData.startDateDB+"'/>"+
	    										  "<input type='hidden' id='endDateParent' value='"+contextData.endDateDB+"'/>");
	    				$("#ajaxFormModal #startDate").after("<span id='parentstartDate'><i class='fa fa-warning'></i> "+tradDynForm["parentStartDate"]+" : "+ moment( contextData.startDateDB /*,"YYYY-MM-DD HH:mm"*/).format('DD/MM/YYYY HH:mm')+"</span>");
	    				$("#ajaxFormModal #endDate").after("<span id='parentendDate'><i class='fa fa-warning'></i> "+tradDynForm["parentEndDate"]+" : "+ moment( contextData.endDateDB /*,"YYYY-MM-DD HH:mm"*/).format('DD/MM/YYYY HH:mm')+"</span>");
	    			}
	    			//alert($("#ajaxFormModal #parentId").val() +" | "+$("#ajaxFormModal #parentType").val());
	    		}
	    		else {
		    		if( $('#ajaxFormModal #organizerId > optgroup > option[value="'+contextData.id+'"]').length == 0 )
	    				$('#ajaxFormModal #organizerId').prepend('<option data-type="'+typeObj[contextData.type].ctrl+'" value="'+contextData.id+'" selected>'+tradDynForm["organizedby"]+' : '+contextData.name+'</option>');
	    			else if( contextData && contextData.id )
		    			$("#ajaxFormModal #organizerId").val( contextData.id );
	    			if( contextData && contextData.type )
	    				$("#ajaxFormModal #organizerType").val( contextData.type);
	    			//alert($("#ajaxFormModal #organizerId").val() +" | "+$("#ajaxFormModal #organizerType").val());
	    		}
	    	}
	    },
	    beforeBuild : function(){
	    	dyFObj.setMongoId('events',function(){
	    		uploadObj.gotoUrl = '#page.type.events.id.'+uploadObj.id;
	    	});
	    },
	    afterSave : function(){
			if( $(uploadObj.domTarget).fineUploader('getUploads').length > 0 )
		    	$(uploadObj.domTarget).fineUploader('uploadStoredFiles');
		    else { 
	          dyFObj.closeForm(); 
	          urlCtrl.loadByHash( uploadObj.gotoUrl);
	        }
		},
	    beforeSave : function(){
	    	if( !$("#ajaxFormModal #allDay").val())
	    		$("#ajaxFormModal #allDay").val(false);
	    	if( typeof $("#ajaxFormModal #description").code === 'function' )
	    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    	//mylog.log($("#ajaxFormModal #startDate").val(),moment( $("#ajaxFormModal #startDate").val()).format('YYYY/MM/DD HH:mm'));
	    	
	    	//Transform datetime before sending
	    	var allDay = $("#ajaxFormModal #allDay").is(':checked');
	    	var dateformat = "DD/MM/YYYY";
	    	var outputFormat="YYYY-MM-DD";
	    	if (! allDay) {
	    		var dateformat = "DD/MM/YYYY HH:mm";
	    		var outputFormat="YYYY-MM-DD HH::mm";
	    	}
	  		// $("#ajaxFormModal #startDate").val( moment( $("#ajaxFormModal #startDate").val(), dateformat).format(outputFormat));
			// $("#ajaxFormModal #endDate").val( moment( $("#ajaxFormModal #endDate").val(), dateformat).format(outputFormat));

			mylog.log( "HERE", $("#ajaxFormModal #startDate").val(), moment( $("#ajaxFormModal #startDate").val(), dateformat).format() ) ; 
			$("#ajaxFormModal #startDate").val( moment( $("#ajaxFormModal #startDate").val(), dateformat).format() );
			$("#ajaxFormModal #endDate").val( moment(   $("#ajaxFormModal #endDate").val(), dateformat).format() );
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> "+tradDynForm["infocreateevent"]+"...</p>",
            },
            name : dyFInputs.name("event"),
	        similarLink : dyFInputs.similarLink,
	        organizerId :{
	        	label : tradDynForm["whoorganizedevent"]+" ?",
	        	rules : { required : true },
            	inputType : "select",
            	placeholder : tradDynForm["whoorganize"]+" ?",
            	rules : { required : true },
            	options : firstOptions(),
            	groupOptions : myAdminList( ["organizations","projects"] ),
	            init : function(){
	            	$("#ajaxFormModal #organizerId").off().on("change",function(){
	            		
	            		var organizerId = $(this).val();
	            		var organizerType = "notfound";
	            		if(organizerId == "dontKnow" )
	            			organizerType = "dontKnow";
	            		else if( $('#organizerId').find(':selected').data('type') && typeObj[$('#organizerId').find(':selected').data('type')] )
	            			organizerType = $('#organizerId').find(':selected').data('type');
	            		else
	            			organizerType = typeObj["person"].col;

	            		mylog.warn( "organizer",organizerId,organizerType, $('#organizerId').find(':selected').data('type') );
	            		$("#ajaxFormModal #organizerType").val( organizerType );
	            	});
	            }
            },
	        organizerType : dyFInputs.inputHidden(),
	        organizor : {
	            inputType : "finder",
	            label : tradDynForm.whoorganizedevent,
	           	initType: ["projects", "organizations"],
    			multiple : true,
    			openSearch :true,
    			init: function(){
    				finder.init("organizor");
    			}
			},
	        parent : {
	            inputType : "finder",
	            label : tradDynForm.ispartofevent,
	           	multiple : false,
    			initType: ["events"],
    			openSearch :true,
    			init: function(){
    				finder.init("parent");
    			}
			},
	        parentId :{
	         	label : tradDynForm.ispartofevent+" ?",
            	inputType : "select",
            	class : "",
            	placeholder : tradDynForm.ispartofevent+" ?",
            	options : {
            		"":tradDynForm.noparent
            	},
            	"groupOptions" : myAdminList( ["events"] ),
            	init : function(){ mylog.log("init ParentId");
	            	$("#ajaxFormModal #parentId").off().on("change",function(){
	            		mylog.log("on change ParentId");
	            		parentId = $(this).val();
	            		startDateParent = "2000/01/01 00:00";
	            		endDateParent = "2100/01/01 00:00";
	            		if( parentId != "" ){
	            			//Search in the current context
	            			if (typeof contextData != "undefined" && notNull(contextData)) {
	            				if (contextData.type == "events" && contextData.id == parentId) {
	            					mylog.warn("event found in contextData : ",contextData.startDate+"|"+contextData.endDate);
		            				startDateParent = contextData.startDate;
		            				endDateParent = contextData.endDate
	            				}
	            			}
	            			//Search in my contacts list
	            			if(typeof myContacts != "undefined") {
		            			$.each(myContacts.events,function (i,evObj) { 
		            				if( evObj["_id"]["$id"] == parentId){
		            					mylog.warn("event found in my contact list: ",evObj.startDate+"|"+evObj.endDate);
		            					startDateParent = evObj.startDate;
		            					endDateParent = evObj.endDate
			    					}
		            			});
		            		}
		            		$("#startDateParent").val(startDateParent);
		            		$("#endDateParent").val(endDateParent);
		            		$("#parentstartDate").html("<i class='fa fa-warning'></i> "+tradDynForm.eventparentStartDate+" : "+moment( startDateParent ).format('DD/MM/YYYY HH:mm'));
			    			$("#parentendDate").html("<i class='fa fa-warning'></i> "+tradDynForm.eventparentEndDate+" : "+moment( endDateParent ).format('DD/MM/YYYY HH:mm'));
	            		}
	            	});
	            }
            },
            parentType : dyFInputs.inputHidden(),
	        type : dyFInputs.inputSelect(tradDynForm.eventTypes,null,eventTypes, { required : true }),
	        // public : dyFInputs.checkboxSimple("true", "public", {
			      //   							labelText: tradDynForm.isPublic + " ?", 
			      //   							onText:tradDynForm.yes, 
			      //   							offText:tradDynForm.no, 
			      //   							onLabel : tradDynForm.yes,
         //    									offLabel: tradDynForm.no,
         //    									inputId: "#public"
			      //   					}),
		
			public : dyFInputs.checkboxSimple("true", "public", 
				{ "onText" : trad.yes,
				  "offText": trad.no,
				  "onLabel" : tradDynForm.public,
				  "offLabel": tradDynForm.private,
				  //"inputId" : ".amendementDateEnddatetime",
				  "labelText": tradDynForm.makeeventvisible+" ?",
				  //"labelInInput": "Activer les amendements",
				  "labelInformation": tradDynForm.explainvisibleevent
    		}),
	        image : dyFInputs.image(),
            allDay : dyFInputs.allDay(),
            startDate : dyFInputs.startDateInput("datetime"),
            endDate : dyFInputs.endDateInput("datetime"),
            location : dyFInputs.location,
            email : dyFInputs.text(),
            tags : dyFInputs.tags(),
            shortDescription : dyFInputs.textarea(tradDynForm.shortDescription, "...",{ maxlength: 140 }),
            /*formshowers : {
            	label : tradDynForm["indetails"],
                inputType : "custom",
                html:"<a class='btn btn-default  text-dark w100p' href='javascript:;' onclick='$(\".descriptionwysiwyg,.urltext\").slideToggle();activateSummernote(\"#ajaxFormModal #description\");'><i class='fa fa-plus'></i> "+tradDynForm["optiondescrurl"]+"</a>",
            },*/
	        url : dyFInputs.inputUrl(),
            "preferences[publicFields]" :  dyFInputs.inputHidden([]),
            "preferences[privateFields]" : dyFInputs.inputHidden([]),
            "preferences[isOpenData]" :  dyFInputs.inputHidden(true),
            "preferences[isOpenEdition]" :  dyFInputs.inputHidden(true)
	    }
	}
};