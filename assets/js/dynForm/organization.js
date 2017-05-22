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
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-"+typeObj["organization"].color+"'>"+
                		"Faire connaître votre Organisation n'a jamais été aussi simple !<br>" +
					    "Créez votre page en quelques secondes,<br>puis rajoutez des détails,<br>selon vos besoins ...<hr>" +
					 "</p>",
            },
	        name : dyFInputs.name("organization"),
	        similarLink : dyFInputs.similarLink,
	        type : dyFInputs.inputSelect("Type d'organisation", "Type d'organisation", organizationTypes, { required : true }),
            role : dyFInputs.inputSelect(	"Votre rôle",
            								"Quel est votre rôle ?", 
            								{ admin : trad.administrator, member : trad.member, creator : trad.justCitizen }, 
            								{ required : true } ),
            tags : dyFInputs.tags(),
            location : dyFInputs.location,
	        image : dyFInputs.image( "#organization.detail.id."+uploadObj.id ),
            email : dyFInputs.email(),
	        shortDescription : dyFInputs.textarea("Description courte", "...",{ maxlength: 140 }),
	        url : dyFInputs.inputUrl(),
            "preferences[publicFields]" : dyFInputs.inputHidden([]),
            "preferences[privateFields]" : dyFInputs.inputHidden([]),
            "preferences[isOpenData]" : dyFInputs.inputHidden(true),
            "preferences[isOpenEdition]" : dyFInputs.inputHidden(true)
	    }
	}
};