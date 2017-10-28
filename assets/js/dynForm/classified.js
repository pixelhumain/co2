dynForm = {
    jsonSchema : {
	    title : tradDynForm["addclassified"],
	    icon : "bullhorn",
	    type : "object",	    
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
	    		if(typeof contextData != "undefined" && contextData != null && contextData.type && contextData.id ){
    				$('#ajaxFormModal #parentId').val(contextData.id);
	    			$("#ajaxFormModal #parentType").val( contextData.type ); 
	    			
	    		 	$("#ajax-modal-modal-title").html(
	    		 		$("#ajax-modal-modal-title").html()+
	    		 		" <br><small class='text-white'>"+tradDynForm["speakingas"]+" : <span class='text-dark'>"+contextData.name+"</span></small>" );
	    		}
	    	},
	    	onload : function(data){
	    		$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
							  					  .addClass("bg-azure");
	    		
	    		if(data && data.section && data.type && data.subtype ){
	    			$("#ajaxFormModal #id").val(data.id);
	    			$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+data.section+" > "+data.type+" > "+data.subtype+"</h4>" );
					$(".sectionBtntagList").hide();
					$(".typeBtntagList").hide();
	    		} else
	    			$(".typeBtntagList, .nametext, .descriptiontextarea, .pricetext, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags, #btn-submit-form, .deviseselect").hide();
	    	
	    		$("#devise").val(deviseDefault);
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
	    beforeBuild : function(){
	    	dyFObj.setMongoId('classified',function(){
	    		uploadObj.gotoUrl = (contextData != null && contextData.type && contextData.id  ) ? "#page.type."+contextData.type+".id."+contextData.id+".view.directory.dir.classified" : location.hash;
	    	});
	    },
	    beforeSave : function(){
	    	var tagAndTypes = ( $("#ajaxFormModal #tags").val() != "" ) ? $("#ajaxFormModal #tags").val()+"," : "" ;

	    	if( $("#ajaxFormModal #section").val() )
	    		tagAndTypes += $("#ajaxFormModal #section").val();
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
	    afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else {
		    	dyFObj.closeForm();
			    urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
		    }
	    },
	    canSubmitIf : function () { 
	    	if( $("#ajaxFormModal #section").val() && $("#ajaxFormModal #type").val() &&  $("#ajaxFormModal #subtype").val() )
	    		return true;
	    	else 
	    		return false;
	    },
	    actions : {
	    	clear : function() {
	    		
	    		$("#ajaxFormModal #section, #ajaxFormModal #type, #ajaxFormModal #subtype").val("");

	    		$(".breadcrumbcustom").html( "");
	    		$(".sectionBtntagList").show(); 
	    		$(".typeBtntagList").hide(); 
	    		$(".subtypeSection").html("");
	    		$(".subtypeSectioncustom").show();
	    		$(".typeBtntagList, .nametext, .descriptiontextarea, .pricetext, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags, .deviseselect").hide();
	    		$("#btn-submit-form").hide(); 
	    	}, 
	    	initTypeBtn : function () { 
	    		$(".typeBtn").off().on("click",function(){
	            		
            		$(".typeBtn").removeClass("active btn-dark-blue text-white");
            		$( "."+$(this).data('key')+"Btn" ).toggleClass("active btn-dark-blue text-white");
            		$("#ajaxFormModal #type").val( ( $(this).hasClass('active') ) ? $(this).data('key') : "" );
            		
            		$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a>  "+$(".sectionBtn.active").data('tag')+" > "+$(".typeBtn.active").data('tag')+"</h4>" );
            		$(".typeBtntagList").hide();

            		//$(".typeBtn:not(.active)").hide();
            		$("#ajaxFormModal #subtype").val("");
            		fieldHTML = "";
            		var filt = (classified.currentLeftFilters != null ) ? classified[classified.currentLeftFilters] : classified.filters; 
            		if(filt[ $(this).data('key') ]["subcat"].length >= 1)
            		{
	            		$.each(filt[ $(this).data('key') ]["subcat"], function(k,v) { 
	            			fieldHTML += '<div class="col-md-6 padding-5">'+
	    									'<a class="btn tagListEl subtypeBtn '+tradCategory[k]+'Btn " data-tag="'+tradCategory[v]+'"  data-key="'+v+'" href="javascript:;">'+tradCategory[v]+'</a>' +
	            						"</div>";
	            		});
	            		$(".subtypeSection").html('<hr class="col-md-12 no-padding">'+
	            								  '<label class="col-md-12 text-left control-label no-padding" for="typeBtn">'+
	            								  	'<i class="fa fa-chevron-down"></i> '+tradDynForm["subcategory"]+
	            								  '</label>' + fieldHTML );

	            		$(".subtypeBtn").off().on("click",function()
		            	{
		            		$( ".subtypeBtn" ).removeClass("active");
		            		$(this).addClass("active");
		            		$("#ajaxFormModal #subtype").val( ( $(this).hasClass('active') ) ? $(this).data('key') : "" );
		            		$(".nametext, .descriptiontextarea, .pricetext, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags, .deviseselect").show();
		            		
		            		if($(".form-group.sectionhidden #section").val() == "donation" ||
		            		   $(".form-group.sectionhidden #section").val() == "sharing" ||
		            		   $(".form-group.sectionhidden #section").val() == "lookingfor"){
		            			$(".pricetext, .deviseselect").hide();
		            		}else{
		            			$(".pricetext, .deviseselect").show();
		            		}
		            		//$(".subtypeBtn:not(.active)").hide();

		            		$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+
		            										$(".sectionBtn.active").data('tag')+" > "+$(".typeBtn.active").data('tag')+" > "+$(".subtypeBtn.active").data('tag')+"</h4>" );
		            		$(".subtypeSectioncustom").hide();
		            		dyFObj.canSubmitIf();
						});
	            	} else {
	            		$(".nametext, .descriptiontextarea, .pricetext, .contactInfotext, .locationlocation, .imageuploader, .formshowerscustom, .tagstags, .deviseselect").show();
	            	}
            	});
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
                label : tradDynForm["whichkindofclassified"]+" ? ",
	            inputType : "tagList",
                placeholder : "Choisir un type",
                list : classified.sections,
                trad : tradCategory,
                init : function(){
                	$(".sectionBtn").off().on("click",function()
	            	{
	            		$(".typeBtntagList").show();
	            		$(".sectionBtn").removeClass("active btn-dark-blue text-white");
	            		$( "."+$(this).data('key')+"Btn" ).toggleClass("active btn-dark-blue text-white");
	            		$("#ajaxFormModal #section").val( ( $(this).hasClass('active') ) ? $(this).data('key') : "" );
						//$(".sectionBtn:not(.active)").hide();
						var sectionKey = $(this).data('key');
						//alert(sectionKey);
						var what = { title : tradDynForm["inwhichcategoryforclassified"]+" ?", 
				                         icon : classified.sections[sectionKey].icon }
						if( jsonHelper.notNull( "classified.sections."+sectionKey+".filters" ) ){
				            //alert('build btns menu'+classified.sections[sectionKey].filters);
				            classified.currentLeftFilters = classified.sections[sectionKey].filters;
				            var filters = classified[classified.currentLeftFilters]; 
				            directory.sectionFilter( filters, ".typeBtntagList",what,'btn');
				            dyFObj.elementObj.dynForm.jsonSchema.actions.initTypeBtn();
				        }
				        else if( classified.currentLeftFilters != null ) {
				            //alert('rebuild common list'); 
				            directory.sectionFilter( classified.filters, ".typeBtntagList",what,'btn');
				            dyFObj.elementObj.dynForm.jsonSchema.actions.initTypeBtn()
				            classified.currentLeftFilters = null;
				        }
						$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+$(this).data('tag')+"</h4>");
						$(".sectionBtntagList").hide();
	            	});
	            }
            },
            section : dyFInputs.inputHidden(),
	        typeBtn :{
                label : tradDynForm["inwhichcategoryforclassified"]+" ? ",
	            inputType : "tagList",
                placeholder : "Choisir une catégorie",
                list : classified.filters,
                trad:tradCategory,
                init : function(){
                	classified.currentLeftFilters = null;
                	dyFObj.elementObj.dynForm.jsonSchema.actions.initTypeBtn();
	            }
            },
            type : dyFInputs.inputHidden(),
            subtypeSection : {
                inputType : "custom",
                html:"<div class='subtypeSection'></div>"
            },
            subtype : dyFInputs.inputHidden(),
            name : dyFInputs.name( "classified" ) ,
            description : dyFInputs.textarea(tradDynForm.description, "..."),
            price : dyFInputs.price(),
            devise : dyFInputs.inputSelect(tradDynForm.currency, tradDynForm.indicatethemoneyused, deviseTheme),
            image : dyFInputs.image(),
            contactInfo : dyFInputs.inputText(tradDynForm.contactinfo, tradDynForm.telemail+" ..."),
            location : dyFInputs.location,
            tags : dyFInputs.tags(),
            parentId : dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
	    }
	}
};