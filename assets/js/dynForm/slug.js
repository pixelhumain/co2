dynForm = {
    jsonSchema : {
	    title : tradDynForm.addslug,
	    icon : "edit",
	    onLoads : {
	    	sub : function(){
    			if( contextData && contextData.id )
					$("#ajaxFormModal #parentId").val( contextData.id );
    			if( contextData && contextData.type )
    				$("#ajaxFormModal #parentType").val( contextData.type ); 
    		},
	    },
	    beforeBuild : function(){
	    	
	    },
	    save : function() { 
	    	
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-dark'><i class='fa fa-info-circle'></i> "+tradDynForm.infouslug+" <hr></p>",
            },
	        slug : dyFInputs.slug("Slug", "Slug", {minlength : 3}),
	        parentId : dyFInputs.inputHidden(null, { required : true }),
            parentType : dyFInputs.inputHidden(null, { required : true })
	    }
	}
};