dynForm = {
    jsonSchema : {
	    title : "Publier une photo",
	    icon : "camera",
	    beforeBuild : function(){
	    	uploadObj.gotoUrl = location.hash;
	    	uploadObj.contentKey="slider";
			uploadObj.set(contextData.type,contextData.id);
	    },
	    save : function() { 
	    	if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
	    },
		/*afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else 
		    { 
		        dyFObj.closeForm(); 
		        urlCtrl.loadByHash( location.hash );
	        }
	    },*/
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-dark'>"+
                		"Partagez vos photos !<hr>" +
					 "</p>",
            },
	        image : dyFInputs.image(),
	    }
	}
};