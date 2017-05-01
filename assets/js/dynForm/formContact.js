dynForm = {
	    jsonSchema : {
	    title : "Envoyer un email",
	    icon : "user",
	    type : "object",
	    onLoads : {
	    	//pour creer un contact depuis un element existant
	    	"init" : function(){

	    		function filterFormContact() {
					$('#ajaxFormModal #emailSender').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
					$('#ajaxFormModal #names').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
					$('#ajaxFormModal #contentMsg').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
					$('#ajaxFormModal #subject').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
					$("#ajaxFormModal #captcha").realperson({length: 4});
				}

				function initRealPerson() {
					lazyLoad(	themeUrl+"/assets/vendor/jquery_realperson_captcha/jquery.realperson.min.js",
								themeUrl+"/assets/vendor/jquery_realperson_captcha/jquery.realperson.css", 
								filterFormContact, true);
				}

	    		if( notEmpty(userConnected) ) {
	    			if( notEmpty(userConnected.email) ) 
	    				$("#ajaxFormModal #emailSender").val( userConnected.email );
	    			if( notEmpty(userConnected.name) ) 
	    				$("#ajaxFormModal #names").val( userConnected.name ); 
	    		}

				lazyLoad( themeUrl+"/assets/vendor/jquery_realperson_captcha/jquery.plugin.js",null, initRealPerson, true );
				
			}
	    },
	    beforeSave : function(){
	    	$("#ajaxFormModal #captchaUserVal").val($("#ajaxFormModal #captcha").val());
	        $("#ajaxFormModal #captchaHash").val($("#ajaxFormModal #captcha").realperson('getHash'));
	    },
	    afterSave : function(){
	    	dyFObj.closeForm();
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Envoyer un mail</p>",
            },
            names : dyFoInputs.inputText("Nom / Prénom", "Comment vous appelez vous", { required : true }),
            emailSender : dyFoInputs.inputText("Votre addresse e-mail", "votre addresse e-mail : exemple@mail.com", { required : true, email : true }),
	        subject : dyFoInputs.inputText("Objet de votre message", "C'est à quel sujet", { required : true } ),
	        contentMsg : dyFoInputs.textarea(null, null, { required : true }),
	        captcha :{
				inputType : "captcha"
            },
	        captchaUserVal : dyFoInputs.inputHidden(),
            captchaHash :dyFoInputs.inputHidden()
	    }
	}
};