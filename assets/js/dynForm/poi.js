dynForm = {
    jsonSchema : {
	    title : tradDynForm["addpoi"],
	    icon : "map-marker",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
	    		dyFInputs.setSub("bg-green-poi");
	    	},
	    	onload : function(data){
	    		if(data && data.section && data.type && data.subtype ){
	    			$("#ajaxFormModal #id").val(data.id);
	    			$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+data.section+" > "+data.type+" > "+data.subtype+"</h4>" );
					$(".sectionBtntagList").hide();
					$(".typeBtntagList").hide();
	    		} else
	    			$(".typeBtntagList,.nametext, .descriptiontextarea, .contactInfotext, .locationlocation, .urlsarray, .imageuploader, .tagstags, #btn-submit-form").hide();
	    	},
	    },
	    beforeSave : function(){
	    	
	    	var tagAndTypes = "";
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
	    		$(".nametext, .descriptiontextarea, .contactInfotext, .locationlocation, .urlsarray, .imageuploader, .tagstags, #btn-submit-form").hide();
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
            		var filt = (poi.currentLeftFilters != null ) ? poi[poi.currentLeftFilters] : poi.filters; 
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
	            		$("#ajaxFormModal #section").val( ( $(this).hasClass('active') ) ? $(this).data('key') : "" );
						//$(".sectionBtn:not(.active)").hide();
						var sectionKey = $(this).data('key');
						//alert(sectionKey);
						var what = { title : tradDynForm["inwhichcategoryforpoi"]+" ?", 
				                         icon : poi.sections[sectionKey].icon }
						if( jsonHelper.notNull( "poi.sections."+sectionKey+".filters" ) ){
				            //alert('build btns menu'+poi.sections[sectionKey].filters);
				            poi.currentLeftFilters = poi.sections[sectionKey].filters;
				            var filters = poi[poi.currentLeftFilters]; 
				            directory.sectionFilter( filters, ".typeBtntagList",what,'btn');
				            dyFObj.elementObj.dynForm.jsonSchema.actions.initTypeBtn();
				        }
				        else if( poi.currentLeftFilters != null ) {
				            //alert('rebuild common list'); 
				            directory.sectionFilter( poi.filters, ".typeBtntagList",what,'btn');
				            dyFObj.elementObj.dynForm.jsonSchema.actions.initTypeBtn()
				            poi.currentLeftFilters = null;
				        }
						$(".breadcrumbcustom").html( "<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.elementObj.dynForm.jsonSchema.actions.clear()'><i class='fa fa-times'></i></a> "+$(this).data('tag')+"</h4>");
						$(".sectionBtntagList").hide();
	            	});
	            }
            },
            section : dyFInputs.inputHidden(),
	        typeBtn :{
                label : tradDynForm["inwhichcategoryforpoi"]+" ? ",
	            inputType : "tagList",
                placeholder : "Choisir une catégorie",
                list : poi.filters,
                trad:tradCategory,
                init : function(){
                	poi.currentLeftFilters = null;
                	dyFObj.elementObj.dynForm.jsonSchema.actions.initTypeBtn();
	            }
            },
            type : dyFInputs.inputHidden(),
            subtypeSection : {
                inputType : "custom",
                html:"<div class='subtypeSection'></div>"
            },
            subtype : dyFInputs.inputHidden(),
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