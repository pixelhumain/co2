dynForm = {
    jsonSchema : {
	    title : tradDynForm["addurl"],
	    icon : "link",
	    type : "object",
	    onLoads : {
	    	sub : function(){
    			dyFInputs.setSub("bg-url");
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