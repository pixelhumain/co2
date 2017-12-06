dynForm = {
    jsonSchema : {
	    title : tradDynForm["addcontact"],
	    icon : "user",
	    type : "object",
	    onLoads : {
	    	onload : function(){
	    		$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-dark");


	    		if( contextData && contextData.id )
					$("#ajaxFormModal #parentId").val( contextData.id );
    			if( contextData && contextData.type )
    				$("#ajaxFormModal #parentType").val( contextData.type ); 
				
				console.log("input name ? ", $('#ajaxFormModal #name').length);
				$('#ajaxFormModal #name').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
				$('#ajaxFormModal #email').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
				$('#ajaxFormModal #role').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
				$('#ajaxFormModal #telephone').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});

			},
			
	    	//pour creer un contact depuis un element existant
	    	sub : function(){
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
            name : dyFInputs.name("contact", {}, true),
	        similarLink : dyFInputs.similarLink,
	        email : dyFInputs.text(tradDynForm["mainemail"], "exemple@mail.com"),
	        role : dyFInputs.inputText(tradDynForm["contactrole"], tradDynForm["contactrole"]),
	        phone : dyFInputs.inputText(tradDynForm["contactphone"], tradDynForm["contactphone"]),
            idContact : dyFInputs.inputHidden(),
            parentId :dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
	        index : dyFInputs.inputHidden()
	    }
	}
};