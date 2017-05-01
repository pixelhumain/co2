dynForm = {
    jsonSchema : {
	    title : trad.addOrganization,
	    icon : "group",
	    type : "object",
	    beforeBuild : function(){
	    	dyFObj.setMongoId('organizations');
	    },
	    beforeSave : function(){
	    	if (typeof $("#ajaxFormModal #description").code === 'function' ) 
	    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    },
	    afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else {
		    	dyFObj.closeForm();
		    	urlCtrl.loadByHash( location.hash );	
		    }
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-"+typeObj["organization"].color+"'>"+
                		"Faire connaître votre Organisation n'a jamais été aussi simple !<br>" +
					    "Créez votre page en quelques secondes,<br>puis rajoutez des détails,<br>selon vos besoins ...<hr>" +
					 "</p>",
            },
	        name : dyFoInputs.name("organization"),
	        similarLink : dyFoInputs.similarLink,
	        type : dyFoInputs.inputSelect("Type d'organisation", "Type d'organisation", organizationTypes, { required : true }),
            role : dyFoInputs.inputSelect(	"Votre rôle",
            								"Quel est votre rôle ?", 
            								{ admin : trad.administrator, member : trad.member, creator : trad.justCitizen }, 
            								{ required : true } ),
            tags : dyFoInputs.tags(),
            location : dyFoInputs.location,
	        image : dyFoInputs.image( "#organization.detail.id."+uploadObj.id ),
            email : dyFoInputs.email(),
	        shortDescription : dyFoInputs.textarea("Description courte", "...",{ maxlength: 140 }),
	        url : dyFoInputs.inputUrl(),
            "preferences[publicFields]" : dyFoInputs.inputHidden([]),
            "preferences[privateFields]" : dyFoInputs.inputHidden([]),
            "preferences[isOpenData]" : dyFoInputs.inputHidden(true),
            "preferences[isOpenEdition]" : dyFoInputs.inputHidden(true)
	    }
	}
};