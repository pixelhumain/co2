dynForm = {
    jsonSchema : {
	    title : "Publier une photo",
	    icon : "camera",
	    beforeBuild : function(){
	    	uploadObj.gotoUrl = location.hash;
	    	uploadObj.contentKey="slider";
			uploadObj.set( contextData.type,contextData.id );
	    },
	    save : function() { 
	    	if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-dark'>"+
                		"Partagez vos photos et vos publications ! <hr>" +
					 "</p>",
            },
	        image : dyFInputs.image(),
	    }
	}
};