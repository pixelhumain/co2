dynForm = {
    jsonSchema : {
	    title : "Ajouter un contact",
	    icon : "user",
	    type : "object",
	    onLoads : {
	    	//pour creer un contact depuis un element existant
	    	"initUser" : function(){
	    		if( notEmpty(userConnected) ) {
	    			if( notEmpty(userConnected.email) ) 
	    				$("#ajaxFormModal #email").val( userConnected.email );
	    			if( notEmpty(userConnected.name) ) 
	    				$("#ajaxFormModal #name").val( userConnected.name ); 
	    		} 
					
			}
	    },
	    beforeSave : function(){
	    	elementLib.closeForm();	
	    	url.loadByHash(location.hash);
	    },
	    afterSave : function(){
	    	elementLib.closeForm();
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Si vous voulez ajouter un nouveau contact de façon à faciliter les échanges</p>",
            },
            name : typeObjLib.inputText("Nom / Prénom", "Comment vous appelez vous", { required : true }),
            //name : typeObjLib.name(),
            email : typeObjLib.email,
	        role :{
				inputType : "text",
				placeholder : "C'est à quel sujet",
				label : "Objet de votre message"
            },
	        message : typeObjLib.texte
	    }
	}
};