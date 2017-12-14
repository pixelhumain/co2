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
            inviteSearch : dyFInputs.inviteSearch,
	        /*invitedUserName : dyFInputs.invitedUserName,
	        invitedUserEmail : dyFInputs.invitedUserEmail,*/
	       "preferences[publicFields]" : dyFInputs.inputHidden([]),
            "preferences[privateFields]" : dyFInputs.inputHidden([]),
            "preferences[isOpenData]" : dyFInputs.inputHidden(false)
	    }
	}
};