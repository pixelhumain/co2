dynForm = {
    jsonSchema : {
	    title : "Ajouter un contact",
	    icon : "user",
	    type : "object",
	    onLoads : {
	    	//pour creer un contact depuis un element existant
	    	"contact" : function(){
	    		if( contextData && contextData.id )
					$("#ajaxFormModal #parentId").val( contextData.id );
    			if( contextData && contextData.type )
    				$("#ajaxFormModal #parentType").val( contextData.type ); 
			}
	    },
	    afterSave : function(){
	    	elementLib.closeForm();	
	    	urlCtrl.loadByHash(location.hash);
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Si vous voulez ajouter un nouveau contact de façon à faciliter les échanges</p>",
            },
            name : dyFoInputs.name("citoyens", {}, true),
	        similarLink : dyFoInputs.similarLink,
	        email : dyFoInputs.email,
	        role : dyFoInputs.inputText("Role du contact", "Role du contact"),
	        phone : dyFoInputs.inputText("Téléphone du contact", "Téléphone du contact"),
            idContact : dyFoInputs.inputHidden(),
            parentId :dyFoInputs.inputHidden(),
            parentType : dyFoInputs.inputHidden(),
	        index : dyFoInputs.inputHidden()
	    }
	}
};