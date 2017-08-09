dynForm = {
    jsonSchema : {
	    title : tradDynForm["addcontact"],
	    icon : "user",
	    type : "object",
	    onLoads : {
	    	"sub" : function(){

    		 	
	    	},
	    	//pour creer un contact depuis un element existant
	    	"contact" : function(){
	    		if( contextData && contextData.id )
					$("#ajaxFormModal #parentId").val( contextData.id );
    			if( contextData && contextData.type )
    				$("#ajaxFormModal #parentType").val( contextData.type ); 
				
				console.log("input name ? ", $('#ajaxFormModal #name').length);
				$('#ajaxFormModal #name').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
				$('#ajaxFormModal #email').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
				$('#ajaxFormModal #role').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
				$('#ajaxFormModal #telephone').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
			}
	    },
	    afterSave : function(){
	    	dyFObj.closeForm();	
	    	urlCtrl.loadByHash(location.hash);
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> "+tradDynForm["infocreatecontact"]+"</p>",
            },
            name : dyFInputs.name("citoyens", {}, true),
	        similarLink : dyFInputs.similarLink,
	        email : dyFInputs.email(tradDynForm["mainemail"], "exemple@mail.com"),
	        role : dyFInputs.inputText(tradDynForm["contactrole"], tradDynForm["contactrole"]),
	        phone : dyFInputs.inputText(tradDynForm["contactphone"], tradDynForm["contactphone"]),
            idContact : dyFInputs.inputHidden(),
            parentId :dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
	        index : dyFInputs.inputHidden()
	    }
	}
};