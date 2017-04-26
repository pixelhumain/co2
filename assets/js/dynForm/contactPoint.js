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
	    	url.loadByHash(location.hash);
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Si vous voulez ajouter un nouveau contact de façon à faciliter les échanges</p>",
            },
            name : typeObjLib.name("citoyens", {}, true),
	        similarLink : typeObjLib.similarLink,
	        email : typeObjLib.email,
	        role : typeObjLib.inputText("Role du contact", "Role du contact"),
	        phone : typeObjLib.inputText("Téléphone du contact", "Téléphone du contact"),
            idContact : typeObjLib.inputHidden(),
            parentId :typeObjLib.inputHidden(),
            parentType : typeObjLib.inputHidden(),
	        index : typeObjLib.inputHidden()
	    }
	}
};