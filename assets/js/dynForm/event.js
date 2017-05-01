dynForm = {
    jsonSchema : {
	    title : trad.addEvent,
	    icon : "calendar",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
	    		//alert(contextData.type);
	    		if(contextData.type == "events"){
	    			$("#ajaxFormModal #parentId").removeClass('hidden');
	    		
    				if( $('#ajaxFormModal #parentId > optgroup > option[value="'+contextData.id+'"]').length == 0 )
	    				$('#ajaxFormModal #parentId > optgroup[label="events"]').prepend('<option value="'+contextData.id+'" selected>Fait parti de : '+contextData.name+'</option>');
	    			else if ( contextData && contextData.id ){
		    			$("#ajaxFormModal #parentId").val( contextData.id );
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
	    	dyFObj.setMongoId('events');
	    },
	    afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else {
		    	dyFObj.closeForm();
		    	urlCtrl.loadByHash( location.hash );	
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
            }
	    }
	}
};