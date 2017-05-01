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
            inviteSearch : dyFoInputs.inviteSearch,
	        /*invitedUserName : dyFoInputs.invitedUserName,
	        invitedUserEmail : dyFoInputs.invitedUserEmail,*/
	       "preferences[publicFields]" : dyFoInputs.inputHidden([]),
            "preferences[privateFields]" : dyFoInputs.inputHidden([]),
            "preferences[isOpenData]" : dyFoInputs.inputHidden(false)
	    }
	}
};