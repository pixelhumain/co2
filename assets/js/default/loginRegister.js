
function userValidatedActions() { 
	if (typeof initLoginRegister != "undefined" &&  initLoginRegister.userValidated) {
		$(".errorHandler").hide();
		$(".emailValidated").show();
		$(".form-login #password-login").focus();
	}

	//We are in a process of invitation. The user already exists in the db.
	if (typeof initLoginRegister != "undefined" &&  initLoginRegister.invitor != "") {
		$(".errorHandler").hide();
		$('.pendingProcess').show();
		$('.form-register #registerName').val(initLoginRegister.name);
		$('.form-register #isInvitation').val(true);
		$('#email3').prop('disabled', true);
		$('#inviteCodeLink').hide();
	}
}

function removeParametersWithoutReloading(el) {
	
	urlRedirect=(notNull(el)) ? "?el="+el : "";  

	window.history.pushState("Invitation", 
		"Invitation", 
		location.href.replace(location.search,urlRedirect));
}

var Login = function() {
	"use strict";
	var runBoxToShow = function() {
		var el = $('.box-login');
		if (getParameterByName('box').length) {
			switch(getParameterByName('box')) {
				case "register" :
					el = $('.box-register');
					break;
				case "password" :
					el = $('.box-email');
					emailType = 'password'
					break;
				case "validate" :
					el = $('.box-email');
					emailType = 'validateEmail'
					break;
				default :
					el = $('.box-login');
					break;
			}
		}
	};
		
	//function to return the querystring parameter with a given name.
	var getParameterByName = function(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	};
	var runSetDefaultValidation = function() {
		$.validator.setDefaults({
			errorElement : "span", // contain the error msg in a small tag
			errorClass : 'help-block',
			errorPlacement : function(error, element) {// render error placement for each input type
				if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {
				// for chosen elements, need to insert the error after the chosen container
					error.insertAfter($(element).closest('.form-group').children('div').children().last());
				} else if (element.attr("name") == "card_expiry_mm" || element.attr("name") == "card_expiry_yyyy") {
					error.appendTo($(element).closest('.form-group').children('div'));
				} else {
					error.insertAfter(element);
					// for other inputs, just perform default behavior
				}
			},
			ignore : ':hidden',
			success : function(label, element) {
				label.addClass('help-block valid');
				// mark the current input as valid and display OK icon
				$(element).closest('.form-group').removeClass('has-error');
			},
			highlight : function(element) {
				$(element).closest('.help-block').removeClass('valid');
				// display OK icon
				$(element).closest('.form-group').addClass('has-error');
				// add the Bootstrap error class to the control group
			},
			unhighlight : function(element) {// revert the change done by hightlight
				$(element).closest('.form-group').removeClass('has-error');
				// set error class to the control group
			}
		});
	};

	var runLoginValidator = function() {
		var form = $('.form-login');
		var loginBtn = null;
		/*Ladda.bind('.loginBtn', {
	        callback: function (instance) {
	            loginBtn = instance;
	        }
	    });*/
		form.submit(function(e){e.preventDefault() });
		var errorHandler = $('.errorHandler', form);
		form.validate({
			rules : {
				email : {
					minlength : 2,
					required : true
				},
				password : {
					minlength : 4,
					required : true
				}
			},
			submitHandler : function(form) {
				errorHandler.hide();
				$(".alert").hide();
				//loginBtn.start();
				$(".loginBtn").find(".fa").removeClass("fa-sign-in").addClass("fa-spinner fa-spin");
				var params = {
					"email" : $("#email-login").val(),
                   "pwd" : $("#password-login").val(),
                   "remember" : $("#formLogin #remember").prop("checked") 
                };
			      
		    	$.ajax({
		    	  type: "POST",
		    	  url: baseUrl+"/"+moduleId+"/person/authenticate",
		    	  data: params,
		    	  success: function(data){ 
		    	  	//alert("dyFObj.openForm"+data.result);
		    		  if(data.result){
		    		  	
		    		  	if($("#remember").prop("checked")){
		    		  		var pwdEncrypt = encryptPwd($("#password-login").val());
			    		  	var emailEncrypt = encryptPwd($("#email-login").val());
			    		  	$.cookie("lyame", emailEncrypt, { expires: 180, path : "/" });
			    		  	$.cookie("drowsp", pwdEncrypt, { expires: 180, path : "/" });
			    		  	$.cookie("remember", $("#remember").prop("checked"), { expires: 180, path : "/" });
			    		}

		    		  	
		    		  	var url = requestedUrl;
		    		  	//mylog.warn(url,", has #"+url.indexOf("#"),"count / : ",url.split("/").length - 1 );
		    		  	if(data.goto != null){
		    		  		window.location.href = baseUrl+"/"+moduleId+data.goto;
		    		  	} else if( typeof dyFObj.openFormAfterLogin != "undefined"){
		    		  		userId = data.id;
		    		  		$('#modalLogin').modal("hide");
		    		  		dyFObj.openForm( dyFObj.openFormAfterLogin.type, dyFObj.openFormAfterLogin.afterLoad, dyFObj.openFormAfterLogin.data );
		    		  	} else {
		    		  		userId=data.id;
	        				var hash = location.hash.replace( "#","" );
	        				if(typeof hash != "undefined" && hash != ""){
								var hashT=hash.split(".");
								if(typeof hashT == "string")
									var slug=hashT;
								else
									var slug=hashT[0];
		        				$.ajax({
							      type: "POST",
							          url: baseUrl+"/" + moduleId + "/slug/check",
							          data: {slug:slug},
							          dataType: "json",
							          error: function (data){
							             mylog.log("error"); mylog.dir(data);
							          },
							          success: function(data){
										if (!data.result) 
											window.location.reload();
										else{
											if(location.hash.indexOf("#page") >= 0)
						        				window.location.reload();
						        			//else if( url.split("/").length - 1 <= 3 ) {
						        				//location.hash='#page.type.citoyens.id.'+userId;
						        				//window.location.reload();
						        			//}
						        			else {
						        				//themeParams[]
						        			//	location.hash='#page.type.citoyens.id.'+userId;
						        				window.location.reload();
					        				}
										}
							          }
							 	});
							}else{
			        			if(location.hash.indexOf("#page") >= 0)
			        				window.location.reload();
			        		//	else if( url.split("/").length - 1 <= 3 ) {
			        		//		location.hash='#page.type.citoyens.id.'+userId;
			        		//		window.location.reload();
			        		//	}
			        			else {
			        		//		location.hash='#page.type.citoyens.id.'+userId;
			        				window.location.reload();
		        				}
		        			}
		        		}
		    		  } else {
		    		  	var msg;
		    		  	if (data.msg == "notValidatedEmail") {
							$('.notValidatedEmailResult').show();
		    		  	} else if (data.msg == "betaTestNotOpen") {
		    		  		$('.betaTestNotOpenResult').show();
		    		  	} else if (data.msg == "emailNotFound") {
		    		  		$('.emailNotFoundResult').show();
		    		  	} else if (data.msg == "emailAndPassNotMatch") {
		    		  		$('.emailAndPassNotMatchResult').show();
		    		  	} else if (data.msg == "accountPending") {
		    		  		pendingUserId = data.pendingUserId;
		    		  		$(".errorHandler").hide();
							//$('.register').trigger("click");
							$('.pendingProcess').show();
							var pendingUserEmail = data.pendingUserEmail;
							$('#email3').val(pendingUserEmail);
							$('#email3').prop('disabled', true);
							$('.form-register #isInvitation').val(true);
							$('#modalRegister').modal("show");
		    		  	} else{
		    		  		msg = data.msg;
		    		  		$('.loginResult').html(msg);
							$('.loginResult').show();
		    		  	}
		    		  	$(".loginBtn").find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-sign-in");
						//loginBtn.stop();
		    		  }
		    	  },
		    	  error: function(data) {
		    	  	console.log(data);
		    	  	$(".loginBtn").find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-sign-in");
		    	  	toastr.error("Something went really bad : contact your administrator !");
		    	  	//loginBtn.stop();
		    	  },
		    	  dataType: "json"
		    	});
			    return false; // required to block normal submit since you used ajax
			},
			invalidHandler : function(event, validator) {//display error alert on form submit
				$(".loginBtn").find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-sign-in");
				errorHandler.show();
				//loginBtn.stop();
			}
		});
	};

	var runForgotValidator = function() {
		var form2 = $('.form-email');
		var errorHandler2 = $('.errorHandler', form2);
		var forgotBtn = null;
		Ladda.bind('.forgotBtn', {
	        callback: function (instance) {
	            forgotBtn = instance;
	        }
	    });
		form2.validate({
			rules : {
				email2 : {
					required : true
				}
			},
			submitHandler : function(form) {
				errorHandler2.hide();
				forgotBtn.start();
				var params = { 
					"email" : $("#email2").val(),
					"type"	: "password"
				};
		        $.ajax({
		          type: "POST",
		          url: baseUrl+"/"+moduleId+"/person/sendemail",
		          data: params,
		          success: function(data){
					if (data.result) {
						$('.modal').modal('hide');
		    		  	$("#modalNewPasswordSuccess").modal("show"); 
		    		  	// Hide modal if "Okay" is pressed
					    $('#modalNewPasswordSuccess .btn-default').click(function() {
					        $('.modal').modal('hide');
					    });
					} else if (data.errId == "UNKNOWN_ACCOUNT_ID") {
						toastr.error(data.msg);
						$(".forgotBtn").prop("disabled", false).data("loading", false);
						forgotBtn.stop();
					}
		          },
		          error: function(data) {
		    	  	toastr.error("Something went really bad : contact your administrator !");
		    	  },
		          dataType: "json"
		        });
		        return false;
			},
			invalidHandler : function(event, validator) {//display error alert on form submit
				errorHandler2.show();
				forgotBtn.stop();
			}
		});
	};
	var runEmailValidationValidator = function() {
		var form2 = $('.form-email-activation');
		var errorHandler2 = $('.errorHandler', form2);
		var sendValidateEmailBtn = null;
		Ladda.bind('.sendValidateEmailBtn', {
	        callback: function (instance) {
	            sendValidateEmailBtn = instance;
	        }
	    });
		form2.validate({
			rules : {
				email2 : {
					required : true
				}
			},
			submitHandler : function(form) {
				errorHandler2.hide();
				sendValidateEmailBtn.start();
				var params = { 
					"email" : $("#modalSendActivation #email2").val(),
					"type"	: "validateEmail"
				};
		        $.ajax({
		          type: "POST",
		          url: baseUrl+"/"+moduleId+"/person/sendemail",
		          data: params,
		          success: function(data){
					if (data.result) {
						//$("#modalRegisterSuccessContent").html("<h3><i class='fa fa-smile-o fa-4x text-green'></i><br><br> "+data.msg+"</h3>");
			    		  	$('.modal').modal('hide');
			    		  	$("#modalSendAgainSuccess").modal("show"); 
			    		  	// Hide modal if "Okay" is pressed
						    $('#modalSendAgainSuccess .btn-default').click(function() {
						        $('.modal').modal('hide');
						    	//window.location.href = baseUrl+'/#default.live';
						    	//window.location.href = baseUrl+"/"+moduleId;
						    	//window.location.reload();
						    });
					} else if (data.errId == "UNKNOWN_ACCOUNT_ID") {
						toastr.error(data.msg);
						$(".sendValidateEmailBtn").prop("disabled", false).data("loading", false);
						sendValidateEmailBtn.stop();
						/*if (confirm(data.msg)) {
							$('.box-email').removeClass("animated flipInX").addClass("animated bounceOutRight").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
								$(this).hide().removeClass("animated bounceOutRight");
							});
							$('.box-register').show().addClass("animated bounceInLeft").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
								$(this).show().removeClass("animated bounceInLeft");

							});
						} else {
							window.location.reload();
						}*/
					}
		          },
		          error: function(data) {
		    	  	toastr.error("Something went really bad : contact your administrator !");
		    	  },
		          dataType: "json"
		        });
		        return false;
			},
			invalidHandler : function(event, validator) {//display error alert on form submit
				errorHandler2.show();
				sendValidateEmailBtn.stop();
			}
		});
	};

	var runRegisterValidator = function() { console.log("runRegisterValidator!!!!");
		var form3 = $('.form-register');
		var errorHandler3 = $('.errorHandler', form3);
		var createBtn = null;
		
		/*Ladda.bind('.createBtn', {
	        callback: function (instance) {
	            createBtn = instance;
	        }
	    });*/
	    form3.validate({
			rules : {
				name : {
					required : true,
					minlength : 4
				},
				username : {
					required : true,
					validUserName : true,
					rangelength : [4, 32]
				},
				email3 : {
					required : { 
					 	depends:function(){
					 		$(this).val($.trim($(this).val()));
					 		return true;
					 	}
					},
					email : true
				},
				password3 : {
					minlength : 8,
					required : true
				},
				passwordAgain : {
					equalTo : "#password3",
					required : true
				},
				agree: {
					minlength : 1,
					required : true
				}
			},

			messages: {
				agree: trad["mustacceptCGU"],
			},
			submitHandler : function(form) { console.log("runRegisterValidator submitHandler");
				errorHandler3.hide();
				//createBtn.start();
				$(".createBtn").prop('disabled', true);
	    		$(".createBtn").find(".fa").removeClass("fa-sign-in").addClass("fa-spinner fa-spin");
				var params = { 
				   "name" : $('.form-register #registerName').val(),
				   "username" :$(".form-register #username").val(),
				   "email" : $(".form-register #email3").val(),
                   "pwd" : $(".form-register #password3").val(),
                   "app" : moduleId, //"$this->module->id"
                   "pendingUserId" : pendingUserId,
                   "mode" : REGISTER_MODE_TWO_STEPS
                };
                if($('.form-register #isInvitation').val())
                	params.isInvitation=true;
                if( $("#inviteCode").val() )
			      params.inviteCode = $("#inviteCode").val();

		    	$.ajax({
		    	  type: "POST",
		    	  url: baseUrl+"/"+moduleId+"/person/register",
		    	  data: params,
		    	  success: function(data){
		    		  if(data.result) {
		    		  	//createBtn.stop();
						$(".createBtn").prop('disabled', false);
	    				$(".createBtn").find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-sign-in");
						$("#registerName").val("");
						$("#username").val("");
						$("#email3").val("");
						$("#password3").val("");
						$("#passwordAgain").val("");
						$('#agree').prop('checked', false);
		    		  	console.log(data);
		    		  	if(typeof data.isInvitation != "undefined" && data.isInvitation){
		    		  		toastr.success(data.msg);
		    		  		history.pushState(null, "New Title",'#page.type.citoyens.id.'+data.id);
		    		  		//window.location.href = baseUrl+'#page.type.citoyens.id.'+data.id;
		        			window.location.reload();

		    		  	}
		    		  	else{
		    		  		$('.modal').modal('hide');
		    		  		$("#modalRegisterSuccessContent").html("<h3><i class='fa fa-smile-o fa-4x text-green'></i><br><br> "+data.msg+"</h3>");
			    		  	$("#modalRegisterSuccess").modal({ show: 'true' }); 
			    		  	// Hide modal if "Okay" is pressed
						    $('#modalRegisterSuccess .btn-default').click(function() {
						        mylog.log("hide modale and reload");
						        $('.modal').modal('hide');
						    	//window.location.href = baseUrl+'/#default.live';
						    	window.location.href = baseUrl+"/"+moduleId;
						    	window.location.reload();
						    });
		    		  	}
		        		//urlCtrl.loadByHash("#default.directory");
		    		  }
		    		  else {
						$('.registerResult').html(data.msg);
						$('.registerResult').show();
						$(".createBtn").prop('disabled', false);
	    				$(".createBtn").find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-sign-in");
						//createBtn.stop();
		    		  }
		    	  },
		    	  error: function(data) {
		    	  	toastr.error(trad["somethingwentwrong"]);
		    	  	$(".createBtn").prop('disabled', false);
	    			$(".createBtn").find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-sign-in");
		    	  	//createBtn.stop();
		    	  },
		    	  dataType: "json"
		    	});
			    return false;
			},
			invalidHandler : function(event, validator) {//display error alert on form submit
				errorHandler3.show();
				$(".createBtn").prop('disabled', false);
	    		$(".createBtn").find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-sign-in");
				//createBtn.stop();
			}
		});
	};
	return {
		loaded : false,
		//main function to initiate template pages
		init : function() { 
			
			console.log("init after register");
			var ListPath = [		
				//tka todo : should be loaded on demand
				'/plugins/jquery.dynForm.js',
				'/plugins/jquery-validation/dist/jquery.validate.min.js',
				'/plugins/jQuery-Knob/js/jquery.knob.js',
				'/plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
				'/plugins/jquery.dynSurvey/jquery.dynSurvey.js',

				'/plugins/select2/select2.min.js' , 
				'/plugins/moment/min/moment.min.js' ,
				'/plugins/moment/min/moment-with-locales.min.js',

				// '/plugins/bootbox/bootbox.min.js' , 
				// '/plugins/blockUI/jquery.blockUI.js' , 

				'/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js' , 
				'/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css',
				'/plugins/jquery-cookieDirective/jquery.cookiesdirective.js' , 
				'/plugins/ladda-bootstrap/dist/spin.min.js' , 
				'/plugins/ladda-bootstrap/dist/ladda.min.js' , 
				'/plugins/ladda-bootstrap/dist/ladda.min.css',
				'/plugins/ladda-bootstrap/dist/ladda-themeless.min.css',
				'/plugins/animate.css/animate.min.css'
			];

			lazyLoadMany( ListPath, 
				function() { 
					//console.log("lazyLoadMany count",countLazyLoad,ListPath.length);
					if(countLazyLoad == ListPath.length){
						//alert("List Loaded play callback");
						addCustomValidators();
						runBoxToShow();
						runSetDefaultValidation();
						runLoginValidator();
						runForgotValidator();
						runEmailValidationValidator();
						runRegisterValidator();
						
						Login.loaded = true;
					}
			});
			
		},
		openLogin : function() { 
			if(!Login.loaded)
				Login.init();
			$('#modalLogin').modal("show");
			//$('#modalRegister').modal("show");
		}
	};
}();

var oldCp = "";

function validateUserName() { mylog.log("validateUserName click");
	var username = $('.form-register #username').val();
	if(username.length >= 4) {
		clearTimeout(timeout);
		timeout = setTimeout(function() {
				//mylog.log("bing !");
				if (! isUniqueUsername(username)) { mylog.log("validateUserName notUnik");
					var validator = $( '.form-register' ).validate();
					validator.showErrors({
  						"username": trad["usernamenotunique"]
					});
				}
			}, 3000);
	}
}

function callBackFullSearch(resultNominatim){
	mylog.log("callback ok");
	var ok = Sig.showCityOnMap(resultNominatim, true, "person");
	if(!ok){
		if($('#city').val() != "") {
			findGeoposByInsee($('#city').val(), callbackFindByInseeSuccessRegister);
		}
	}
	//$(".topLogoAnim").hide();

	//setTimeout("setMapPositionregister();", 1000);
}

//quand la recherche par code insee a fonctionné
function callbackFindByInseeSuccessRegister(obj){
	mylog.log("callbackFindByInseeSuccess");
	//si on a bien un résultat
	if (typeof obj != "undefined" && obj != "") {
		//récupère les coordonnées
		var coords = Sig.getCoordinates(obj, "markerSingle");
		//si on a une geoShape on l'affiche
		if(typeof obj.geoShape != "undefined") Sig.showPolygon(obj.geoShape);
		//on affiche le marker sur la carte
		$("#alert-city-found").show();
		//mylog.log("verification contenue obj");
		//mylog.dir(obj);
		Sig.showCityOnMap(obj, true, "person");

		if(typeof obj.name != "undefined"){
			$("#main-title-public2").html("<i class='fa fa-university'></i> "+obj.name);
			$("#main-title-public2").show();
		}

		hideLoadingMsg();
				
		//showGeoposFound(coords, projectId, "projects", projectData);
	}
	else {
		mylog.log("Erreur getlatlngbyinsee vide");
	}
}
	function searchAddressInGeoShape(){
		if($('#cp').val() != "" && $('#cp').val() != null){
			findGeoposByInsee($('#city').val(), callbackFindByInseeSuccessAdd);
		}
	}

	function callbackFindByInseeSuccessAdd(obj){
		mylog.log("callbackFindByInseeSuccessAdd");
		mylog.dir(obj);
		//si on a bien un résultat
		if (typeof obj != "undefined" && obj != "") {
			currentCityByInsee = obj;
			//récupère les coordonnées
			var coords = Sig.getCoordinates(obj, "markerSingle");
			//si on a une street dans le form
			if($('#fullStreet').val() != "" && $('#fullStreet').val() != null){
				//si on a une geoShape dans la reponse obj
				if(typeof obj.geoShape != "undefined") {
					//on recherche avec une limit bounds
					var polygon = L.polygon(obj.geoShape.coordinates);
					var bounds = polygon.getBounds();
					Sig.execFullSearchNominatim(0, bounds);
				}
				else{
					//on recherche partout
					Sig.execFullSearchNominatim(0);
				}
			}
			else{
				Sig.showCityOnMap(obj, true, "person");
			}

			if(typeof obj.name != "undefined"){
				$("#main-title-public2").html("<i class='fa fa-university'></i> "+obj.name);
				$("#main-title-public2").show();
			}
			hideLoadingMsg();
		}
		else {
			mylog.log("Erreur getlatlngbyinsee vide");
		}
	}
//quand la recherche par code insee n'a pas fonctionné
function callbackFindByInseeError(){
	mylog.log("erreur getlatlngbyinsee");
}

function initRegister() {
	$('.form-register #registerName').val("");
	$(".form-register #username").val("");
	$(".form-register #email3").val("");
	$(".form-register #password3").val("");
	$(".form-register #passwordAgain").val("");
	$(".form-register #inviteCode").val("");
}


var CryptoJSAesJson = {
    stringify: function (cipherParams) {
        var j = {ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)};
        if (cipherParams.iv) j.iv = cipherParams.iv.toString();
        if (cipherParams.salt) j.s = cipherParams.salt.toString();
        return JSON.stringify(j);
    },
    parse: function (jsonStr) {
        var j = JSON.parse(jsonStr);
        var cipherParams = CryptoJS.lib.CipherParams.create({ciphertext: CryptoJS.enc.Base64.parse(j.ct)});
        if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv);
        if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s);
        return cipherParams;
    }
};

function encryptPwd(pwd){
	var secureKey = 'JbQmfH"h^W7q86JU1V(<64aEv';
	var encrypted = CryptoJS.AES.encrypt(JSON.stringify(pwd), secureKey, {format: CryptoJSAesJson});
	return encrypted.toString();
}
