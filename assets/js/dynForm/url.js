dynForm = {
    jsonSchema : {
	    title : "Ajouter une url",
	    icon : "link",
	    type : "object",
	    onLoads : {
	    	sub : function(){
    			$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-url");
    		 	
    		 	$("#ajax-modal-modal-title").html(
    		 		$("#ajax-modal-modal-title").html()+
    		 		" <br><small class='text-white'>en tant que : <span class='text-dark'>"+contextData.name+"</span></small>" );
    		
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
                html:"<p><i class='fa fa-info-circle'></i> Partagez des liens qui vous intéresse, pour les rendre accessibles à tous.</p>",
            },
            title : dyFInputs.inputText("Nom", "Titre de l'URL", { required : true }),
	        url : dyFInputs.inputText("URL du lien", "URL du lien", { required : true, url : true }),
            type : dyFInputs.inputSelect("Type de l'URL", "Choisir un type", urlTypes, { required : true }),
            index : dyFInputs.inputHidden(),
            parentId : dyFInputs.inputHidden(null, { required : true }),
            parentType : dyFInputs.inputHidden(null, { required : true })
	    }
	}
};