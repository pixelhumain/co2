dynForm = {
    jsonSchema : {
	    title : tradDynForm.uploadfile,
	    icon : "file-text-o",
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
	        //newsCreation : dyFInputs.checkbox(false,"newsCreation",{labelText: tradDynForm.sharefilesasnews, onText:tradDynForm.yes, offText:tradDynForm.no,labelInInput:tradDynForm.shareit, inputId: "#createNews"}),
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