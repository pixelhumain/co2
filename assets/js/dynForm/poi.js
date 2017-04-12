dynForm = {
    jsonSchema : {
	    title : "Formulaire Point d'interet",
	    icon : "map-marker",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	subPoi : function(){
	    		if(contextData.type && contextData.id )
	    		{
    				$('#ajaxFormModal #parentId').val(contextData.id);
	    			$("#ajaxFormModal #parentType").val( contextData.type ); 
	    		}
	    	},
	    	onload : function(){
	    		$(".nametext, .descriptiontextarea, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags, #btn-submit-form").hide();
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
	    	elementLib.setMongoId('poi');
	    },
		afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else {
		    	elementLib.closeForm();	
		    	url.loadByHash( location.hash );
		    }
	    },
	    actions : {
	    	clear : function() {
	    		
	    		$("#ajaxFormModal #section, #ajaxFormModal #type, #ajaxFormModal #subtype").val("");

	    		$(".breadcrumbcustom").html( "");
	    		$(".sectionBtntagList").show(); 
	    		$(".typeBtntagList").hide(); 
	    		$(".subtypeSection").html("");
	    		$(".subtypeSectioncustom").show();
	    		$(".nametext, .descriptiontextarea, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags, #btn-submit-form").hide();
	    	}
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Un Point d'interet est un élément assez libre qui peut etre géolocalisé ou pas, qui peut etre rataché à une organisation, un projet ou un évènement.</p>",
            },
            breadcrumb : {
                inputType : "custom",
                html:"",
            },
            sectionBtn :{
                label : "De quel type de Lieu s'agit-il ? ",
	            inputType : "tagList",
                placeholder : "Choisir un type",
                list : poi.sections,
                trad : trad,
                init : function(){
                	$(".sectionBtn").off().on("click",function()
	            	{
	            		$(".typeBtntagList").show();
	            		$(".sectionBtn").removeClass("active btn-dark-blue text-white");
	            		$( "."+$(this).data('key')+"Btn" ).toggleClass("active btn-dark-blue text-white");
	            		$("#ajaxFormModal #section").val( ( $(this).hasClass('active') ) ? $(this).data('tag') : "" );
						//$(".sectionBtn:not(.active)").hide();
						
						$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='elementLib.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+$(this).data('tag')+"</h4>");
						$(".sectionBtntagList").hide();
						$(".nametext, .descriptiontextarea, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags, #btn-submit-form").show();
	            	});
	            }
            },
            type : typeObjLib.hidden,
	        name : typeObjLib.name("poi"),
	        image : typeObjLib.image(),
            description : typeObjLib.description,
            location : typeObjLib.location,
            tags :typeObjLib.tags(),
            formshowers : {
            	label : "En détails",
                inputType : "custom",
                html: "<a class='btn btn-default text-dark w100p' href='javascript:;' onclick='$(\".urlsarray\").slideToggle()'><i class='fa fa-plus'></i> options (urls)</a>",
            },
            urls : typeObjLib.urlsOptionnel,
            parentId : typeObjLib.hidden,
            parentType : typeObjLib.hidden,
	    }
	}
};