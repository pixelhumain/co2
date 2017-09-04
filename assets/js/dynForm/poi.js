dynForm = {
    jsonSchema : {
	    title : tradDynForm["addpoi"],
	    icon : "map-marker",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
	    		$("#ajax-modal-modal-title").html(
    		 		$("#ajax-modal-modal-title").html()+
    		 		" <br><small class='text-white'>"+tradDynForm["speakingas"]+" : <span class='text-dark'>"+contextData.name+"</span></small>" );

	    		if(contextData.type && contextData.id )
	    		{
	    			$('#ajaxFormModal #parentId').val(contextData.id);
	    			$("#ajaxFormModal #parentType").val( contextData.type ); 
	    		}
	    	},
	    	onload : function(data){
	    		if(data && data.type){
	    			$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+tradCategory[data.type]+"</h4>");
					$(".sectionBtntagList").hide();
	    		} else
	    			$(".nametext, .descriptiontextarea, .contactInfotext, .locationlocation, .urlsarray, .imageuploader, .tagstags, #btn-submit-form").hide();
	    	},
	    },
	    beforeSave : function(){
	    	
	    	if( $("#ajaxFormModal #section").val() )
	    		$("#ajaxFormModal #type").val($("#ajaxFormModal #section").val());

	    	if( typeof $("#ajaxFormModal #description").code === 'function' )  
	    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    	if($('#ajaxFormModal #parentId').val() == "" && $('#ajaxFormModal #parentType').val() ){
		    	$('#ajaxFormModal #parentId').val( userId );
		    	$("#ajaxFormModal #parentType").val( "citoyens" ); 
		    }
	    },
	    beforeBuild : function(){
	    	dyFObj.setMongoId('poi',function(){
	    		uploadObj.gotoUrl = (contextData != null && contextData.type && contextData.id ) ? "#page.type."+contextData.type+".id."+contextData.id+".view.directory.dir.poi" : location.hash;
	    	});
	    },
		afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else 
		    { 
		        dyFObj.closeForm(); 
		        urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
	        }
	    },
	    canSubmitIf : function () { 
	    	 return ( $("#ajaxFormModal #type").val() ) ? true : false ;
	    },
	    actions : {
	    	clear : function() {
	    		
	    		$("#ajaxFormModal #section, #ajaxFormModal #type, #ajaxFormModal #subtype").val("");

	    		$(".breadcrumbcustom").html( "");
	    		$(".sectionBtntagList").show(); 
	    		$(".typeBtntagList").hide(); 
	    		$(".subtypeSection").html("");
	    		$(".subtypeSectioncustom").show();
	    		$(".nametext, .descriptiontextarea, .contactInfotext, .locationlocation, .urlsarray, .imageuploader, .tagstags, #btn-submit-form").hide();
	    	}
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-"+typeObj["poi"].color+"'>"+
                		tradDynForm["infocreatepoi"]+
                		"<hr>"+
					 "</p>",
            },
            breadcrumb : {
                inputType : "custom",
                html:"",
            },
            sectionBtn :{
                label : tradDynForm["whichkindofpoi"]+" ? ",
	            inputType : "tagList",
                placeholder : "Choisir un type",
                list : poi.sections,
                trad : tradCategory,
                init : function(){
                	$(".sectionBtn").off().on("click",function()
	            	{
	            		$(".typeBtntagList").show();
	            		$(".sectionBtn").removeClass("active btn-dark-blue text-white");
	            		$( "."+$(this).data('key')+"Btn" ).toggleClass("active btn-dark-blue text-white");
	            		$("#ajaxFormModal #type").val( ( $(this).hasClass('active') ) ? $(this).data('key') : "" );
						//$(".sectionBtn:not(.active)").hide();
						
						$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+$(this).data('tag')+"</h4>");
						$(".sectionBtntagList").hide();
						$(".nametext, .descriptiontextarea, .contactInfotext, .locationlocation, .urlsarray, .imageuploader, .tagstags").show();
						dyFObj.canSubmitIf();
	            	});
	            }
            },
            type : dyFInputs.inputHidden(),
	        name : dyFInputs.name("poi"),
	        image : dyFInputs.image(),
            //description : dyFInputs.description,
            description : dyFInputs.textarea(tradDynForm["description"], "..."),
            location : dyFInputs.location,
            tags :dyFInputs.tags(),
            urls : dyFInputs.urls,
            parentId : dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
	    }
	}
};