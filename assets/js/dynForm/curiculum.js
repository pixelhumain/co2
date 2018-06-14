dynForm = {
	saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
    jsonSchema : {
	    title : trad.addCuriculum,
	    icon : "group",
	    //type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	onload : function(){
	    		//dyFInputs.setHeader("bg-green");
    	   	},
	    	sub : function(){
				//$("#ajax-modal-modal-title").html( "<i class='fa fa-"+typeIcon+"'></i> "+typeName );
	            
				//$("#ajax-modal .modal-header").removeClass("bg-dark bg-red bg-purple bg-green bg-green-poi bg-orange bg-turq bg-yellow bg-url bg-azure").addClass("bg-"+typeObj[currentKFormType].color);
				//$("#ajax-modal .infocustom p").removeClass("text-dark text-red text-purple text-green text-green-poi text-orange text-turq text-yellow text-url text-azure").addClass("text-"+typeObj[currentKFormType].color);

	    	},
	    },
	    beforeBuild : function(){
	    	
	    	
	    },
	    beforeSave : function(){
	    	//if (typeof $("#ajaxFormModal #description").code === 'function' ) 
	    	//	$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    },
	    afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else { 
		    	mylog.log("here", isMapEnd);
		    	if(typeof networkJson != "undefined")
					isMapEnd = true;
				dyFObj.closeForm();
				urlCtrl.loadByHash( uploadObj.gotoUrl );
	        }
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-"+typeObj["organization"].color+"'>"+
                		//"Faire connaître votre Organisation n'a jamais été aussi simple !<br>" +
					   // tradDynForm["infocreateorganization"]+" ...<hr>" +
					 "</p>",
            },
	        competenceKeys : dyFInputs.tags(),
            location : dyFInputs.location,
	        //image : dyFInputs.image(),
            motivation : dyFInputs.textarea(tradDynForm["explainMotivation"], "...",{ maxlength: 500 }),
	        url : dyFInputs.inputUrl()
	    }
	}
};