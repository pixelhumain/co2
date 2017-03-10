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
	    		
	    	}/*,
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
	    properties : {
	    	info : {
                inputType : "custom",
                html:"",//<p><i class='fa fa-info-circle'></i> Une Annonce est un élément assez libre qui peut etre géolocalisé ou pas, qui peut etre rataché à tous les éléments.</p>",
            },
	        typeBtn :{
                label : "Dans quelle catégorie souhaitez-vous publier votre annonce ?",
	            inputType : "tagList",
                placeholder : "Choisir une catégorie",
                list : classifiedTypes,
                init : function(){
	            	$(".typeBtn").off().on("click",function()
	            	{
	            		$(".typeBtn").removeClass("active btn-dark-blue text-white");
	            		$( "."+$(this).data('tag')+"Btn" ).toggleClass("active btn-dark-blue text-white");
	            		$("#ajaxFormModal #type").val( ( $(this).hasClass('active') ) ? $(this).data('tag') : "" );

	            		$("#ajaxFormModal #subtype").val("");
	            		fieldHTML = "";
	            		$.each(classifiedTypes[ $(this).data('tag') ]["subcat"], function(k,v) { 
	            			fieldHTML += '<div class="col-md-6 padding-5">'+
        									'<a class="btn tagListEl subtypeBtn '+k+'Btn " data-tag="'+v+'" href="javascript:;">'+v+'</a>' +
	            						"</div>";
	            		});			
	            		$(".subtypeSection").html('<hr class="col-md-12 no-padding">'+
	            								  '<label class="col-md-12 text-left control-label no-padding" for="typeBtn">'+
	            								  	'<i class="fa fa-chevron-down"></i> Sous-catégorie'+
	            								  '</label>' +
	            								  fieldHTML);

	            		$(".subtypeBtn").off().on("click",function()
		            	{
		            		$( ".subtypeBtn" ).removeClass("active");
		            		$(this).addClass("active");
		            		$("#ajaxFormModal #subtype").val( ( $(this).hasClass('active') ) ? $(this).data('tag') : "" );
						});
	            	});
	            }
            },
            type : typeObjLib.hidden,
            subtypeSection : {
                inputType : "custom",
                html:"<div class='subtypeSection'></div>",
            },
            subtype : typeObjLib.hidden,
            name : typeObjLib.name("classified"),
            description : typeObjLib.description,
            price : typeObjLib.price,
            location : typeObjLib.location,
            image : typeObjLib.image( "#classified.detail.id."+uploadObj.id ),
            
            // tags :{
            //     inputType : "tags",
            //     placeholder : "Mots clefs",
            //     values : tagsList
            // },
            formshowers : {
            	label : "En détails",
                inputType : "custom",
                html: "<a class='btn btn-primary w100p' href='javascript:;' onclick='$(\".urlsarray\").slideToggle()'><i class='fa fa-plus'></i> d'options</a>",
            },
            urls : typeObjLib.urls,
            parentId : typeObjLib.hidden,
            parentType : typeObjLib.hidden,
	    }
	}
};