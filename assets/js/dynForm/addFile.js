dynForm = {
    jsonSchema : {
	    title : "Publier un fichier",
	    icon : "file",
	    beforeBuild : function(){
	    	uploadObj.gotoUrl = location.hash;
	    	//uploadObj.contentKey="slider";
			uploadObj.set( contextData.type,contextData.id,true);
	    },
	    save : function() { 
	    	if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-dark'>"+
                		"Share your file here ! <hr>" +
					 "</p>",
            },
	        file : dyFInputs.file(),
	    }
	}
};