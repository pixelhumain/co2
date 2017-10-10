dynForm = {
    jsonSchema : {
	    title : "Add a services",
	    icon : "sun-o",
	    type : "object",	    
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
	    		if(typeof contextData != "undefined" && contextData != null && contextData.type && contextData.id ){
    				$('#ajaxFormModal #parentId').val(contextData.id);
	    			$("#ajaxFormModal #parentType").val( contextData.type ); 
	    			$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
							  					  .addClass("bg-azure");
	    		 	$("#ajaxFormModal #toBeValidated").val(true);
	    		 	$("#ajax-modal-modal-title").html(
	    		 		$("#ajax-modal-modal-title").html()+
	    		 		" <br><small class='text-white'>"+tradDynForm["speakingas"]+" : <span class='text-dark'>"+contextData.name+"</span></small>" );
	    		}
	    	},
	    	onload : function(data){
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
	    	dyFObj.setMongoId('services',function(){
	    		uploadObj.gotoUrl = (contextData != null && contextData.type && contextData.id  ) ? "#page.type."+contextData.type+".id."+contextData.id+".view.directory.dir.classified" : location.hash;
	    	});
	    },
	    beforeSave : function(){
	    	var tagAndTypes = ( $("#ajaxFormModal #tags").val() != "" ) ? $("#ajaxFormModal #tags").val()+"," : "" ;

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
		    	loadProducts();
			    //urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
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
            type : dyFInputs.inputSelect(tradDynForm.servicesTypes,null,servicesList, { required : true }),
            name : dyFInputs.name( "service" ) ,
            price : dyFInputs.price(),
            //devise : dyFInputs.inputSelect("Devise", "Iniquez la monnaie utilisée pour votre annonce", ["€", "$"]),
            quantity : dyFInputs.quantity(),
            openingHours : dyFInputs.openingHours(true),
            description : dyFInputs.textarea("Description", "..."),
            image : dyFInputs.image(),
            medias : dyFInputs.videos,
            contactInfo : dyFInputs.inputText(tradDynForm.contactinfo, tradDynForm["telemail"]+" ..."),
            location : dyFInputs.location,
            tags : dyFInputs.tags(),
            parentId : dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
            toBeValidated : dyFInputs.inputHidden(),
	    }
	}
};