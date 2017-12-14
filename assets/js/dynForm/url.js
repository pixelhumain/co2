dynForm = {
    jsonSchema : {
	    title : tradDynForm["addurl"],
	    icon : "link",
	    type : "object",
	    onLoads : {
	    	sub : function(){
    			$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-url");
    		 	
    		 	$("#ajax-modal-modal-title").html(
    		 		$("#ajax-modal-modal-title").html()+
    		 		" <br><small class='text-white'>"+tradDynForm["speakingas"]+" : <span class='text-dark'>"+contextData.name+"</span></small>" );
    		
    		 	if( contextData && contextData.id )
					$("#ajaxFormModal #parentId").val( contextData.id );
    			if( contextData && contextData.type )
    				$("#ajaxFormModal #parentType").val( contextData.type ); 
    		},
	    },
	    afterSave : function(){
			dyFObj.closeForm();
		    urlCtrl.loadByHash( location.hash );
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> "+tradDynForm["infocreateurl"]+".</p>",
            },
            title : dyFInputs.inputText(tradDynForm["name"], tradDynForm["titleurl"], { required : true }),
	        url : dyFInputs.inputText(tradDynForm["linkUrl"], tradDynForm["linkUrl"], { required : true, url : true }),
            type : dyFInputs.inputSelect(tradDynForm["urltype"], tradDynForm["choosetype"], urlTypes, { required : true }),
            index : dyFInputs.inputHidden(),
            parentId : dyFInputs.inputHidden(null, { required : true }),
            parentType : dyFInputs.inputHidden(null, { required : true })
	    }
	}
};