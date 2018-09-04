dynForm = {
    jsonSchema : {
	    title : tradDynForm.addphotos,
	    icon : "camera",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	onload : function(){
    			//$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
				//		  					  .addClass("bg-orange");
    		 	$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-dark");

    		 	$("#ajax-modal-modal-title").html(
    		 		$("#ajax-modal-modal-title").html()+
    		 		" <br><small class='text-white'>"+tradDynForm["speakingas"]+" : <span class='text-dark'>"+contextData.name+"</span></small>" );
    		 	
    		 }
    	},
	    beforeBuild : function(){
	    	//uploadObj.gotoUrl = location.hash;
	    	uploadObj.contentKey="slider";
			uploadObj.set( contextData.type,contextData.id, "image", uploadObj.contentKey);
	    },
	    save : function() { 
	    	if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-dark'>"+
                		tradDynForm.infoaddphoto+" ! <hr>" +
					 "</p>",
            },
	        image : dyFInputs.image(),
	        folder : {
	            inputType : "folder",
	            label : trad.selectanalbum,
	            emptyMsg:trad.noalbumselected,
	            folderKey : folderId,
	            docType : "image",
	            contentKey: "slider",
	            contextType : contextData.type, 
	            contextId : contextData.id
	        },
	        newsCreation : dyFInputs.checkboxSimple("false", "newsCreation", {
			        							labelText: tradDynForm.shareimagesasnews + " ?", 
			        							onText:tradDynForm.yes, 
			        							offText:tradDynForm.no, 
			        							onLabel : tradDynForm.yes,
            									offLabel: tradDynForm.no,
            									inputId: "#createNews"
			        					}),
	        news: dyFInputs.createNews()
	    }
	}
};