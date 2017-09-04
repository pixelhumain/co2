dynForm = {
    jsonSchema : {
	    title : tradDynForm.uploadfile,
	    icon : "file-text-o",
	    beforeBuild : function(){
	    	uploadObj.gotoUrl = location.hash;
	    	uploadObj.contentKey="file";
			uploadObj.set( contextData.type,contextData.id,true);
	    },
	    save : function() { 
	    	if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-dark'><i class='fa fa-info-circle'></i> "+tradDynForm.infouploadfile+" <hr></p>",
            },
	        file : dyFInputs.file(),
	        newsCreation : dyFInputs.checkbox(false,"newsCreation",{labelText: tradDynForm.sharefilesasnews, onText:tradDynForm.yes, offText:tradDynForm.no,labelInInput:tradDynForm.shareit, inputId: "#createNews"}),
	        news: dyFInputs.createNews() 
	    }
	}
};