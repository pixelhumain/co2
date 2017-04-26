dynForm = {
    jsonSchema : {
	    title : trad.addOrganization,
	    icon : "group",
	    type : "object",
	    beforeBuild : function(){
	    	elementLib.setMongoId('organizations');
	    },
	    beforeSave : function(){
	    	if (typeof $("#ajaxFormModal #description").code === 'function' ) 
	    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    },
	    afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else {
		    	elementLib.closeForm();
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
	        name : typeObjLib.name("organization"),
	        similarLink : typeObjLib.similarLink,
	        type : typeObjLib.inputSelect("Type d'organisation", "Type d'organisation", organizationTypes, { required : true }),
            role : typeObjLib.inputSelect(	"Votre rôle",
            								"Quel est votre rôle ?", 
            								{ admin : trad.administrator, member : trad.member, creator : trad.justCitizen }, 
            								{ required : true } ),
            tags : typeObjLib.tags(),
            location : typeObjLib.location,
	        image : typeObjLib.image( "#organization.detail.id."+uploadObj.id ),
            /*formshowers : {
            	label : "En détails",
                inputType : "custom",
                html:
				"<a class='btn btn-default text-dark w100p' "+
					"href='javascript:;' "+
					"onclick='$(\".emailtext,.descriptiontextarea,.urltext\").slideToggle();activateMarkdown(\"#ajaxFormModal #description\");'>"+
					"<i class='fa fa-plus'></i> options (email, desc, urls, telephone)</a>",
            },*/
            email : typeObjLib.email(),
	        shortDescription : typeObjLib.textarea("Description courte", "...",{ maxlength: 140 }),
	        url : typeObjLib.inputUrl(),
            "preferences[publicFields]" : typeObjLib.inputHidden([]),
            "preferences[privateFields]" : typeObjLib.inputHidden([]),
            "preferences[isOpenData]" : typeObjLib.inputHidden(true),
            "preferences[isOpenEdition]" : typeObjLib.inputHidden(true)
	    }
	}
};