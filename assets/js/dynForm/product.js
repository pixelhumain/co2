dynForm = {
    jsonSchema : {
	    title : tradDynForm["addclassified"],
	    icon : "bullhorn",
	    type : "object",	    
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
	    		dyFInputs.setSub("bg-azure");
	    		$("#ajaxFormModal #toBeValidated").val(true);
	    	},
	    	onload : function(data){
	    	},
	    },
	    beforeBuild : function(){
	    	dyFObj.setMongoId('products',function(){
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
            type : dyFInputs.inputHidden(),
            price : dyFInputs.price(),
            //devise : dyFInputs.inputSelect("Devise", "Iniquez la monnaie utilisée pour votre annonce", ["€", "$"]),
            name : dyFInputs.name( "classified" ) ,
            description : dyFInputs.textarea("Description", "..."),
            image : dyFInputs.image(),
            medias : dyFInputs.videos,
            contactInfo : dyFInputs.inputText(tradDynForm["contactinfo"], tradDynForm["telemail"]+" ..."),
            location : dyFInputs.location,
            tags : dyFInputs.tags(),
            parentId : dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
            toBeValidated : dyFInputs.inputHidden(),
	    }
	}
};