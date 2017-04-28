dynForm =  {
    jsonSchema : {
	    title : "Inviter quelqu'un",
	    icon : "user",
	    type : "object",
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Si vous voulez inviter quelqu'un à rejoindre Communecter ...</p>",
            },
            inviteSearch : typeObjLib.inviteSearch,
	        /*invitedUserName : typeObjLib.invitedUserName,
	        invitedUserEmail : typeObjLib.invitedUserEmail,*/
	       "preferences[publicFields]" : typeObjLib.inputHidden([]),
            "preferences[privateFields]" : typeObjLib.inputHidden([]),
            "preferences[isOpenData]" : typeObjLib.inputHidden(false)
	    }
	}
};