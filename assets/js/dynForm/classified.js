dynForm = {
    jsonSchema : {
	    title : "Publier une annonce",
	    icon : "bullhorn",
	    type : "object",	    
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	subPoi : function(){
	    		if(contextData.type && contextData.id ){
    				$('#ajaxFormModal #parentId').val(contextData.id);
	    			$("#ajaxFormModal #parentType").val( contextData.type ); 
	    		}
	    		
	    	},
	    	onload : function(){
	    		$(".typeBtntagList, .nametext, .descriptiontextarea, .pricetext, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags").hide();
	    	},
	    	/*,
	    	loadData : function(data){
		    	mylog.warn("--------------- loadData ---------------------",data);
		    	$('#ajaxFormModal #name').val(data.name);
		    	$('#ajaxFormModal #type').val(data.type);
		    	$('#ajaxFormModal #parentId').val(data.parentId);
	    		$("#ajaxFormModal #parentType").val( data.parentType ); 
		    },*/
	    },
	    beforeSave : function(){
	    	var tagAndTypes = $("#ajaxFormModal #tags").val();

	    	if( $("#ajaxFormModal #section").val() )
	    		tagAndTypes += ","+$("#ajaxFormModal #section").val();
	    	if( $("#ajaxFormModal #type").val() )
	    		tagAndTypes += ","+$("#ajaxFormModal #type").val();
	    	if( $("#ajaxFormModal #subtype").val() )
	    		tagAndTypes += ","+$("#ajaxFormModal #subtype").val();
	    	$("#ajaxFormModal #tags").val( tagAndTypes );
	    	
	    	if( typeof $("#ajaxFormModal #description").code === 'function' )  
	    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    	if($('#ajaxFormModal #parentId').val() == "" && $('#ajaxFormModal #parentType').val() ){
		    	$('#ajaxFormModal #parentId').val(userId);
		    	$("#ajaxFormModal #parentType").val( "citoyens" ); 
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
	    		$(".typeBtntagList, .nametext, .descriptiontextarea, .pricetext, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags").hide();
	    	}
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"",//<p><i class='fa fa-info-circle'></i> Une Annonce est un élément assez libre qui peut etre géolocalisé ou pas, qui peut etre rataché à tous les éléments.</p>",
            },
            breadcrumb : {
                inputType : "custom",
                html:"",
            },
            sectionBtn :{
                label : "De quel type d'annonce s'agit-il ? ",
	            inputType : "tagList",
                placeholder : "Choisir un type",
                list : freedomCategories,
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
	            	});
	            }
            },
            section : typeObjLib.hidden,
	        typeBtn :{
                label : "Dans quelle catégorie souhaitez-vous publier votre annonce ? ",
	            inputType : "tagList",
                placeholder : "Choisir une catégorie",
                list : classifiedTypes,
                init : function(){
	            	$(".typeBtn").off().on("click",function()
	            	{
	            		
	            		$(".typeBtn").removeClass("active btn-dark-blue text-white");
	            		$( "."+$(this).data('key')+"Btn" ).toggleClass("active btn-dark-blue text-white");
	            		$("#ajaxFormModal #type").val( ( $(this).hasClass('active') ) ? $(this).data('tag') : "" );
	            		
	            		$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='elementLib.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a>  "+$(".sectionBtn.active").data('tag')+" > "+$(".typeBtn.active").data('tag')+"</h4>" );
	            		$(".typeBtntagList").hide();

	            		//$(".typeBtn:not(.active)").hide();
	            		$("#ajaxFormModal #subtype").val("");
	            		fieldHTML = "";
	            		$.each(classifiedTypes[ $(this).data('key') ]["subcat"], function(k,v) { 
	            			fieldHTML += '<div class="col-md-6 padding-5">'+
        									'<a class="btn tagListEl subtypeBtn '+k+'Btn " data-tag="'+v+'" href="javascript:;">'+v+'</a>' +
	            						"</div>";
	            		});
	            		$(".subtypeSection").html('<hr class="col-md-12 no-padding">'+
	            								  '<label class="col-md-12 text-left control-label no-padding" for="typeBtn">'+
	            								  	'<i class="fa fa-chevron-down"></i> Sous-catégorie'+
	            								  '</label>' +
	            								  fieldHTML );

	            		$(".subtypeBtn").off().on("click",function()
		            	{
		            		$( ".subtypeBtn" ).removeClass("active");
		            		$(this).addClass("active");
		            		$("#ajaxFormModal #subtype").val( ( $(this).hasClass('active') ) ? $(this).data('tag') : "" );
		            		$(".nametext, .descriptiontextarea, .pricetext, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags").show();
		            		//$(".subtypeBtn:not(.active)").hide();

		            		$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='elementLib.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+$(".sectionBtn.active").data('tag')+" > "+$(".typeBtn.active").data('tag')+" > "+$(".subtypeBtn.active").data('tag')+"</h4>" );
		            		$(".subtypeSectioncustom").hide();
						});
	            	});
	            }
            },
            type : typeObjLib.hidden,
            subtypeSection : {
                inputType : "custom",
                html:"<div class='subtypeSection'></div>"
            },
            subtype : typeObjLib.hidden,
            price : typeObjLib.price,
            name : typeObjLib.name("classified"),
            description : typeObjLib.description,
            image : typeObjLib.image( "#classified.detail.id."+uploadObj.id ),
            contactInfo : typeObjLib.contactInfo,
            location : typeObjLib.location,
            tags : typeObjLib.tags(),
            parentId : typeObjLib.hidden,
            parentType : typeObjLib.hidden,
	    }
	}
};