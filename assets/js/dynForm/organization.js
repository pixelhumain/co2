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
		    	url.loadByHash( location.hash );	
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
	        type : typeObjLib.typeOrga,
            role : typeObjLib.role,
            tags : typeObjLib.tags(),
            location : typeObjLib.location,
	        image : typeObjLib.image( "#organization.detail.id."+uploadObj.id ),
            formshowers : {
            	label : "En détails",
                inputType : "custom",
                html:
				"<a class='btn btn-default text-dark w100p' "+
					"href='javascript:;' "+
					"onclick='$(\".emailtext,.descriptiontextarea,.urltext\").slideToggle();activateMarkdown(\"#ajaxFormModal #description\");'>"+
					"<i class='fa fa-plus'></i> options (email, desc, urls, telephone)</a>",
            },
            email : typeObjLib.emailOptionnel,
	        description : typeObjLib.description,
            url : typeObjLib.url,
	        /*telephone : {
	        	placeholder : "Téléphne",
	            inputType : "text",
	            init : function(){
	            	$(".telephonetext").css("display","none");
	            }
	        },*/
            "preferences[publicFields]" : typeObjLib.hiddenArray,
            "preferences[privateFields]" : typeObjLib.hiddenArray,
            "preferences[isOpenData]" : typeObjLib.hiddenTrue,
            "preferences[isOpenEdition]" : typeObjLib.hiddenTrue
	    }
	}
};