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
	    	dyFObj.closeForm();	
	    	urlCtrl.loadByHash(location.hash);
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Facilitez les rencontres en indiquant les coordonnées des personnes en lien avec cette page</p>",
            },
            name : dyFInputs.name("citoyens", {}, true),
	        similarLink : dyFInputs.similarLink,
	        email : dyFInputs.email("E-mail principal", "exemple@mail.com"),
	        role : dyFInputs.inputText("Role du contact", "Role du contact"),
	        phone : dyFInputs.inputText("Téléphone du contact", "Téléphone du contact"),
            idContact : dyFInputs.inputHidden(),
            parentId :dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
	        index : dyFInputs.inputHidden()
	    }
	}
};