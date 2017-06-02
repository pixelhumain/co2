dynForm = {
    jsonSchema : {
	    title : trad.addEvent,
	    icon : "calendar",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){

	    		
    			$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-orange");
    		 	
    		 	$("#ajax-modal-modal-title").html(
    		 		$("#ajax-modal-modal-title").html()+
    		 		" <br><small class='text-white'>en tant que : <span class='text-dark'>"+contextData.name+"</span></small>" );

	    		if(contextData.type == "events"){
	    			$("#ajaxFormModal #parentId").removeClass('hidden');
	    		
    				if( $('#ajaxFormModal #parentId > optgroup > option[value="'+contextData.id+'"]').length == 0 )
	    				$('#ajaxFormModal #parentId > optgroup[label="events"]').prepend('<option value="'+contextData.id+'" selected>Fait parti de : '+contextData.name+'</option>');
	    			else if ( contextData && contextData.id ){
		    			$("#ajaxFormModal #parentId").val( contextData.id );
	    			}

	    			if ( contextData && contextData.id ){
		    			$("#ajaxFormModal #organizerId").val( contextData.organizerId );
	    			}
	    			//$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" sur "+contextData.name );
	    			if( contextData && contextData.type )
	    				$("#ajaxFormModal #parentType").val( contextData.type ); 

	    			if(contextData.startDate && contextData.endDate ){
	    				$("#ajaxFormModal").after("<input type='hidden' id='startDateParent' value='"+contextData.startDate+"'/>"+
	    										  "<input type='hidden' id='endDateParent' value='"+contextData.endDate+"'/>");
	    				$("#ajaxFormModal #startDate").after("<span id='parentstartDate'><i class='fa fa-warning'></i> date début du parent : "+moment( contextData.startDate).format('DD/MM/YYYY HH:mm')+"</span>");
	    				$("#ajaxFormModal #endDate").after("<span id='parentendDate'><i class='fa fa-warning'></i> date de fin du parent : "+moment( contextData.endDate).format('DD/MM/YYYY HH:mm')+"</span>");
	    			}
	    			//alert($("#ajaxFormModal #parentId").val() +" | "+$("#ajaxFormModal #parentType").val());
	    		}
	    		else {
		    		if( $('#ajaxFormModal #organizerId > optgroup > option[value="'+contextData.id+'"]').length == 0 )
	    				$('#ajaxFormModal #organizerId').prepend('<option data-type="'+typeObj[contextData.type].ctrl+'" value="'+contextData.id+'" selected>Organisé par : '+contextData.name+'</option>');
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
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else { 
	          dyFObj.closeForm(); 
	          urlCtrl.loadByHash( uploadObj.gotoUrl);
	        }
		},
	    beforeSave : function(){
	    	//alert("onBeforeSave");
	    	
	    	if( !$("#ajaxFormModal #allDay").val())
	    		$("#ajaxFormModal #allDay").val(false);
	    	if( typeof $("#ajaxFormModal #description").code === 'function' )
	    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    	//mylog.log($("#ajaxFormModal #startDate").val(),moment( $("#ajaxFormModal #startDate").val()).format('YYYY/MM/DD HH:mm'));
	    	
	    	//Transform datetime before sending
	    	var allDay = $("#ajaxFormModal #allDay").is(':checked');
	    	var dateformat = "DD/MM/YYYY";
	    	if (! allDay) 
	    		var dateformat = "DD/MM/YYYY HH:mm"
	    	$("#ajaxFormModal #startDate").val( moment( $("#ajaxFormModal #startDate").val(), dateformat).format());
			$("#ajaxFormModal #endDate").val( moment( $("#ajaxFormModal #endDate").val(), dateformat).format());
			//mylog.log($("#ajaxFormModal #startDate").val());
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Si vous voulez créer un nouvel évènement de façon à le rendre plus visible : c'est le bon endroit !!<br>Vous pouvez inviter des participants, planifier des sous évènements, publier des actus lors de l'évènement...</p>",
            },
            name : dyFInputs.name("event"),
	        similarLink : dyFInputs.similarLink,
	        organizerId :{
	        	label : "Qui organise cet événement ?",
	        	rules : { required : true },
            	inputType : "select",
            	placeholder : "Qui organise ?",
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
	        parentId :{
	         	label : "Fait parti d'un évènement ?",
            	inputType : "select",
            	class : "",
            	placeholder : "Fait parti d'un évènement ?",
            	options : {
            		"":"Pas de Parent"
            	},
            	"groupOptions" : myAdminList( ["events"] ),
            	init : function(){ console.log("init ParentId");
	            	$("#ajaxFormModal #parentId").off().on("change",function(){
	            		console.log("on change ParentId");
	            		parentId = $(this).val();
	            		startDateParent = "2000/01/01 00:00";
	            		endDateParent = "2100/01/01 00:00";
	            		if( parentId != "" ){
	            			//Search in the current context
	            			if (typeof contextData != "undefined") {
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
		            		$("#parentstartDate").html("<i class='fa fa-warning'></i> Date de début de l'événement parent : "+moment( startDateParent ).format('DD/MM/YYYY HH:mm'));
			    			$("#parentendDate").html("<i class='fa fa-warning'></i> Date de fin de l'événement parent : "+moment( endDateParent ).format('DD/MM/YYYY HH:mm'));
	            		}
	            	});
	            }
            },
            parentType : dyFInputs.inputHidden(),
	        type : dyFInputs.inputSelect("Type d\'évènement",null,eventTypes, { required : true }),
	        image : dyFInputs.image( ),
            allDay : dyFInputs.allDay(),
            startDate : dyFInputs.startDateInput,
            endDate : dyFInputs.endDateInput,
            location : dyFInputs.location,
            tags : dyFInputs.tags(),
            shortDescription : dyFInputs.textarea("Description courte", "...",{ maxlength: 140 }),
            formshowers : {
            	label : "En détails",
                inputType : "custom",
                html:"<a class='btn btn-default  text-dark w100p' href='javascript:;' onclick='$(\".descriptionwysiwyg,.urltext\").slideToggle();activateSummernote(\"#ajaxFormModal #description\");'><i class='fa fa-plus'></i> options (desc, urls)</a>",
            },
	        url : dyFInputs.inputUrlOptionnel(),
            "preferences[publicFields]" :  dyFInputs.inputHidden([]),
            "preferences[privateFields]" : dyFInputs.inputHidden([]),
            "preferences[isOpenData]" :  dyFInputs.inputHidden(true),
            "preferences[isOpenEdition]" :  dyFInputs.inputHidden(true)
	    }
	}
};