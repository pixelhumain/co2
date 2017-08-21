<style>

#invite-modal-element .dropdown-menu{
	top:65%;
	left : 15px;

}

#invite-modal-element .nav-tabs > li > a {
    border: 0 none;
    border-radius: 5px;
    color: #8E9AA2;
    min-width: 70px;
    padding: 5px !important;
    margin-bottom:10px;
}
#invite-modal-element .nav-tabs > li > a {
	background-color: transparent !important;
}
#invite-modal-element .nav-tabs > li > a > div:hover {
    background-color: #3C5665;
    color:white !important;
}
#invite-modal-element .nav-tabs > li > a > div:focus {
    background-color: #3C5665;
    color:white !important;
}

#invite-modal-element  #listEmailGrid{
	max-height:400px;
	min-height:250px;
	overflow-y:auto; 
	overflow-x:hidden; 
	padding-top:15px;
	border-left: 1px solid rgba(128, 128, 128, 0.26);
}

</style>
<div class="portfolio-modal modal fade" id="invite-modal-element" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content padding-top-15">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
         	<div class="row">
                <div class="col-lg-12">
                    <h3 class="letter-red no-margin hidden-xs">
                        <i class="fa fa-plus-circle"></i> Inviter ou Rechercher une personne<br>
                    </h3>
                </div>               
            </div>

            <div class="row">
	            <div class="col-md-12 margin-top-15 text-dark menuInvite">
					<ul class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:" class="" id="menuInviteSomeone">
								<div id="titleInviteSomeone" class='radius-10 padding-10 text-yellow text-dark'>
									<i class="fa fa-search fa-2x"></i> Rechercher ...
								</div>
							</a>
						</li>
					  	<!--<li role="presentation">
					  		<a href="#" class="" id="menuGmail">
					  			<div id="titleGmail" class='radius-10 padding-10 text-grey text-dark'>
					  				<i class="fa fa-envelope fa-2x"></i> 
									Gmail
								</div>
					  		</a>
					  	</li> 
					  	<li role="presentation">
					  		<a href="javascript:" class="" id="menuGooglePlus">
					  			<div id="titleGooglePlus" class='radius-10 padding-10 text-grey text-dark'>
					  				<i class="fa fa-google-plus-square fa-2x"></i> 
									Google+
								</div>	  		
					  		</a>
					  	</li> -->
					  	<li role="presentation">
					  		<a href="javascript:" class="" id="menuImportFile">
					  			<div id="titleImportFile" class='radius-10 padding-10 text-grey text-dark'>
					  				<i class="fa fa-upload fa-2x"></i> 
									Importer un fichier
								</div>
					  		</a>
					  	</li>
					  	<li role="presentation">
					  		<a href="javascript:" class="" id="menuWriteMails">
					  			<div id="titleWriteMails" class='radius-10 padding-10 text-grey text-dark'>
					  				<i class="fa fa-pencil-square-o fa-2x"></i> 
									Saisir
								</div>
					  		</a>
					  	</li>
					</ul>
					<hr>
				</div>
			</div>
            <div class="row links-create-element">
                <div class="col-lg-12">
					
                    <div id="" class="modal-body">


                        <form class="form-invite" id="divInviteSomeone" autocomplete="off">
                        	<input class="invite-parentId hide"  id="inviteParentId" name="inviteParentId" type="text"/>
							<input class="invite-id hide" id = "inviteId" name="inviteId" type="text"/>
							<div class="col-xs-12" id="step1">
								<div class="col-md-1 text-right" style="margin-top:5px;">	
					           		<i class="fa fa-search fa-2x"></i> 
					           	</div>
								<div class="col-md-10">
									<div class="form-group">
										<input class="invite-search form-control text-left" placeholder="Un nom, un e-mail ..." autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">
							        		<ul class="dropdown-menu col-md-10" id="dropdown_searchInvite" style="">
												<li class="li-dropdown-scope">-</li>
											</ul>
										</input>
									</div>
								</div>
							</div>
							<div class="col-xs-12 hidden" id="step2">
								<div class="form-group" id="ficheUser">
									<div class="col-md-12 text-center">
										<div class="photoInvited text-center col-md-4">
										</div>
										<a class="pending btn btn-xs btn-red tooltips" data-toggle="tooltip" data-placement="bottom" title="Cette personne a déjà été invité, mais na pas encore rejoint le réseau">Cette personne a déjà été invité, mais n\'a pas encore rejoint le réseau</a>

										<a href="javascript:;" class="connectBtn btn btn-lg tooltips " data-placement="top" data-original-title="Suivre cette personne" ><i class=" connectBtnIcon fa fa-link "></i> <?php echo Yii::t("common","Follow this person") ?></a>
										<a href="javascript:;" class="disconnectBtn btn btn-lg tooltips " data-placement="top" data-original-title="Ne plus suivre cette personne" ><i class=" disconnectBtnIcon fa fa-unlink "></i> <?php echo Yii::t("common","Unfollow this person")?></a>
										<hr>
										<h4 id="ficheUser-ficheName" name="ficheUser-ficheName"></h4>
										<a href="" class="btn btn-default lbh" id="ficheUser-btnProfil">Aller sur sa page</a><br>
										<input id="inviteId" name="inviteId" type="hidden" value="">
										<span id="ficheUser-email" name="ficheUser-email" ></span><br><br>
										<span id="ficheUser-address" name="ficheUser-address" ></span><br><br>
										<span id="ficheUser-tags" name="ficheUser-tags" ></span><br>
										<br>
									</div>
								</div>
							</div>
                            <div class="col-xs-12 hidden" id="step3">
                                <div class="modal-body text-center">
                                    <h2 class="text-green">
                                        <i class="fa fa-plus-circle padding-bottom-10"></i>
                                        <span class="font-light"> Inviter quelqu'un</span>
                                    </h2>
                                    
                                    <div class="row margin-bottom-10">
                                        <div class="col-md-1 col-md-offset-1" id="iconUser">    
                                            <i class="fa fa-user fa-2x"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <input class="invite-name form-control" placeholder="<?php echo Yii::t("common", "Name");?>" id="inviteName" name="inviteName" value="" />
                                        </div>
                                    </div>
                                    <div class="row margin-bottom-10">
                                        <div class="col-md-1 col-md-offset-1">  
                                            <i class="fa fa-envelope-o fa-2x"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <input class="invite-email form-control" placeholder="<?php echo Yii::t("common", "Email");?>" id="inviteEmail" name="inviteEmail" value="" />
                                        </div>
                                    </div>
                                    <div class="row margin-bottom-10">
                                        <div class="col-md-1 col-md-offset-1">  
                                            <i class="fa fa-align-justify fa-2x"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="invite-text form-control" id="inviteText" name="inviteText" rows="4">Bonjour, J'ai découvert un réseau sociétal citoyen appelé "Communecter - être connecté à sa commune". 
Tu peux agir concrétement autour de chez toi et découvrir ce qui s'y passe. Viens rejoindre le réseau sur communecter.org.</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
	                                <hr>
	                                <a href="javascript:;" style="font-size: 13px;" class="btn btn-danger btnCancel" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Retour</a> 
	                                <button class="btn btn-primary" id="btnInviteNew" ><i class="fa fa-send"></i> Inviter</button>
	                            </div>
                            </div>
                            
                        </form>

                        <div id="divImportFile" class="hidden">
							<div class="col-xs-12">
								<label for="fileEmail" > Fichier (CSV) : <input type="file" id="fileEmail" name="fileEmail" accept=".csv"> </label>
								</div><br/><hr/><br/>
						</div>
						<div id="divWriteMails" class="hidden">
							<div class="col-xs-12">
								<textarea id="textareaMails" class="form-control col-xs-12" rows="5"></textarea>
								<a href="javascript:;" class="btn btn-success col-xs-12" id="submitAfficherInvite">Vérification</a>
							</div>
						</div>
						<div class="col-xs-12 hidden" id="countContacts" ><h4 class="modal-title pull-right"><span id="nbContacts"></span> / <span id="allContacts"></span> contacts selectionnées</h4></div>
						<div id="listEmailGrid" class="margin-bottom-10 hidden"></div>
                    </div>
                    <div class="modal-footer hidden">
				      	<button id="btn-cancel-invite" type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Quitter </button>
				      	<button id="btn-save-invite" type="button" class="btn btn-success btn-sm" data-dismiss="modal"><i class="fa fa-check"></i> Inviter</button>
				    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

jQuery(document).ready(function() {
	bindInviteModal();
    runinviteFormValidation();
});

function bindInviteModal(){
	mylog.log("bindInviteModal");

	$("#invite-modal-element  #btn-cancel").click(function(){
		if(newMemberInCommunity && (currentView=="detail" || currentView=="directory")) {
			urlCtrl.loadByHash(location.hash);
		}
	});

	$("#invite-modal-element  #btn-save-invite").off().on('click', function(){
		mylog.log("btn-save-invite");
		$(this).prop("disabled",true);
		$(this).find("i").removeClass("fa-send").addClass("fa-spinner fa-spin");
		if(listMails.length == 0)
    		toastr.error("Veuillez sélectionner une adresse mail.");
    	else{
    		if($(".error-block-invite").length>=0)
    			$(".error-block-invite").remove();
    		mylog.log("listMails", listMails);
    		if(Object.keys(listMails).length==0){
    			dataInvite={msgEmail : $("#invite-modal-element #inviteText").val(),
		        	invitedUserName : $("#invite-modal-element #inviteName").val(),
		        	invitedUserEmail : $("#invite-modal-element #inviteEmail").val(),
		        	listMails:{}
		        };
    		} else{
    			dataInvite={
    				msgEmail : $("#invite-modal-element #inviteText").val(),
		        	listMails:listMails
		        }
    		}
    		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+'/person/follows',
		        dataType : "json",
		        data: dataInvite,
				type:"POST",
				success: function(data){ 
					if (data &&  data.result) {               
			        	toastr.success('L\'invitation a été envoyée avec succès!');
			        	mylog.log(data);
			        	
			        	if(typeof data.data !="undefined"){
				        	$.each(data.data, function(key, elt) {
				        		addFloopEntity(elt.invitedUser.id, "<?php echo Person::COLLECTION ?>", elt.invitedUser);
				        	});
			        	}else
			        		addFloopEntity(data.invitedUser.id, "<?php echo Person::COLLECTION ?>", data.invitedUser);
			        	urlCtrl.loadByHash(location.hash);

			        } else {
			        	$.unblockUI();
						toastr.error(data.msg);
						$("#invite-modal-element #step3 #btn-save-invite").prop("disabled",false);
						$("#invite-modal-element #step3 #btn-save-invite").find("i").removeClass("fa-spin fa-spinner").addClass("fa-send");
			        }
				}
		    })
		    .done(function (data){
		    	$.unblockUI();
		        
		    });
    	}
  	});

	$('#invite-modal-element #inviteSearch').keyup(function(e){
	    var search = $('#invite-modal-element #inviteSearch').val();
	    if(search.length>2){
	    	clearTimeout(timeout);
			timeout = setTimeout('autoCompleteInviteSearch("'+encodeURI(search)+'")', 500); 
		 }else{
		 	$("#invite-modal-element #dropdown_searchInvite").css({"display" : "none" });	
		 }	
	});

	$("#menuInviteSomeone").click(function() {
		fadeInView("divInviteSomeone");
		$("#shareForm").hide();
	});

	$("#menuGmail").click(function() {
		fadeInView("divGmail");
		$("#shareForm").hide();
	});

	$("#menuGooglePlus").click(function() {
		fadeInView("divGooglePlus");
		$("#shareForm").hide();
	});

	$("#menuImportFile").click(function() {
		fadeInView("divImportFile");
		$("#shareForm").hide();
	});

	$("#menuWriteMails").click(function() {
		fadeInView("divWriteMails");
		$("#shareForm").hide();
	});

	$("#divImportFile #fileEmail").change(function(e) {
		mylog.log("fileEmail");
		$.blockUI({
            message : '<span class="homestead"><i class="fa fa-spin fa-circle-o-noch"></i> Merci de patienter ...</span>'
        });
    	$("#listEmailGrid").html("");
		var ext = $("#divImportFile input#fileEmail").val().split(".").pop().toLowerCase();
		mylog.log("ext", ext);
		if($.inArray(ext, ["csv"]) == -1) {
			toastr.error("Vous devez utiliser un format CSV");
			return false;
		} 
		
		if (e.target.files != undefined) {
			var reader = new FileReader();
			mylog.log("reader", reader);
			
			reader.onload = function(e) {
				var csvval = e.target.result.split("\n");
				checkAndGetMailsInvite(csvval);
			};
			reader.readAsText(e.target.files.item(0));
		}else{
			toastr.error("Nous n'avons pas réussie à lire votre fichier.");
		}
		return false;
	});

	$("#invite-modal-element .connectBtn").off().on("click", function() {
			var thiselement = this;
			follow(typeObj.person.col, $('#invite-modal-element #inviteId').val(), userId, typeObj.person.col, function(){
			mylog.log('callback connectPerson');
			$(thiselement).children().removeClass("fa-spinner fa-spin").addClass("fa-link");			
			$('#invite-modal-element .disconnectBtn').show();
			$('#invite-modal-element .connectBtn').hide();
			//TODO add in myContacts
				//listFollowsId.push($("#newInvite #inviteId").val());

			$('#invite-modal-element #inviteSearch').val("");
			
		});
	});

	$("#invite-modal-element .disconnectBtn").off().on("click", function() {
		var thiselement = this;
		var idToDisconnect = $('#invite-modal-element #inviteId').val();
		var typeToDisconnect = "<?php echo Person::COLLECTION ?>";
		disconnectTo(typeObj.person.col,idToDisconnect,userId,typeObj.person.col,'followers',function() {
			mylog.log('callback disconnectPerson');
			$(thiselement).children().removeClass("fa-spinner fa-spin").addClass("fa-unlink");
			//// Find and remove item from an array
			//TODO Remove in myContacts
			// var i = listFollowsId.indexOf(idToDisconnect);
			// if(i != -1) {
			// 	listFollowsId.splice(i, 1);
			// }textmail
			// mylog.log(listFollowsId);
			$('#invite-modal-element .disconnectBtn').hide();
			$('#invite-modal-element .connectBtn').show();
			$('#invite-modal-element #inviteSearch').val("");
			
			
		});
	});

	$("#invite-modal-element #submitAfficherInvite").off().on("click", function() {
		mylog.log("submitAfficherInvite");
		var mails = $("#invite-modal-element #textareaMails").val().split(/[\s\n;]+/);
		checkAndGetMailsInvite(mails);
	});
}
  
function runinviteFormValidation(el) {

    var forminvite = $('.form-invite');
    var errorHandler2 = $('.errorHandler', forminvite);
    var successHandler2 = $('.successHandler', forminvite);

    forminvite.validate({
        errorElement : "span", // contain the error msg in a span tag
        errorClass : 'help-block',
        errorPlacement : function(error, element) {// render error placement for each input type
            if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {// for chosen elements, need to insert the error after the chosen container
                error.insertAfter($(element).closest('.form-group').children('div').children().last());
            } else if (element.parent().hasClass("input-icon")) {

                error.insertAfter($(element).parent());
            } else {
                error.insertAfter(element);
                // for other inputs, just perform default behavior
            }
        },
        ignore : "",
        rules : {
            inviteName : {
                required : true,
                minlength : 2
                
            },
            inviteEmail : {
                required : true
            }
        },
        messages : {
            inviteName : "* <?php echo Yii::t("common","Please specify the name") ?>",//+trad["Please specify a name"],
            inviteEmail : "* <?php echo Yii::t("common","Please enter an email") ?>"//+trad["Please specify a email"]
        },
        invalidHandler : function(invite, validator) {//display error alert on form submit
            successHandler2.hide();
            errorHandler2.show();
        },
        highlight : function(element) {
            $(element).closest('.help-block').removeClass('valid');
            // display OK icon
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
            // add the Bootstrap error class to the control group
        },
        unhighlight : function(element) {// revert the change done by hightlight
            $(element).closest('.form-group').removeClass('has-error');
            // set error class to the control group
        },
        success : function(label, element) {
            label.addClass('help-block valid');
            // mark the current input as valid and display OK icon
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
        },
        submitHandler : function(form) {
            mylog.log("submit handler");
            successHandler2.show();
            errorHandler2.hide();
            $("#invite-modal-element #btnInviteNew").prop("disabled",true);
			$("#invite-modal-element #btnInviteNew").find("i").removeClass("fa-send").addClass("fa-spin fa-spinner");
            var parentId = $(".form-invite .invite-parentId").val();
            var invitedUserName = $("#invite-modal-element #inviteName").val();
            var invitedUserEmail = $("#invite-modal-element #inviteEmail").val();
            $.blockUI({
                message : '<span class="homestead"><i class="fa fa-spin fa-circle-o-noch"></i> Merci de patienter ...</span>'
            });
            $.ajax({
                type: "POST",
                url: baseUrl+"/"+moduleId+'/person/follows',
                dataType : "json",
                data: {
                    parentId : parentId,
                    invitedUserName : invitedUserName,
                    invitedUserEmail : invitedUserEmail,
                    msgEmail : $("#invite-modal-element #inviteText").val()
                }
            })
            .done(function (data) {
                $.unblockUI();
                if (data &&  data.result) {               
                    toastr.success('L\'invitation a été envoyée avec succès!');
                    addFloopEntity(data.invitedUser.id, "<?php echo Person::COLLECTION ?>", data.invitedUser);
                    $("#invite-modal-element #step3").addClass("hidden");
                    $("#invite-modal-element #inviteName").val("");
                    $("#invite-modal-element #inviteEmail").val("");
                    $("#invite-modal-element #inviteText").val('Bonjour, J\'ai découvert un réseau sociétal citoyen appelé "Communecter - être connecté à sa commune".\nTu peux agir concrétement autour de chez toi et découvrir ce qui s\'y passe. Viens rejoindre le réseau sur communecter.org."');
                    $('#invite-modal-element #invite-modal').modal('hide');
                    $('#invite-modal-element #inviteSearch').val("");
                    $("#invite-modal-element #btnInviteNew").prop("disabled",false);
					$("#invite-modal-element #btnInviteNew").find("i").removeClass("fa-spin fa-spinner").addClass("fa-send");
                } else {
                    $.unblockUI();
                    $("#invite-modal-element #btnInviteNew").prop("disabled",false);
					$("#invite-modal-element #btnInviteNew").find("i").removeClass("fa-spin fa-spinner").addClass("fa-send");
                    toastr.error(data.msg);
                }
            });
        }
    });
};


function autoCompleteInviteSearch(search){
	mylog.log("autoCompleteInviteSearch", search);
	if (search.length < 3) { return }
	tabObject = [];

	var data = { 
		"search" : search,
		"searchMode" : "personOnly"
	};
	
	ajaxPost("", '<?php echo Yii::app()->getRequest()->getBaseUrl(true).'/'.$this->module->id?>/search/searchmemberautocomplete', data,
		function (data){
			var str = "<li class='li-dropdown-scope'><a href='javascript:;' onclick='newInvitation()'>Pas trouvé ? Lancer une invitation à rejoindre votre réseau !</li>";
			var compt = 0;
			var city, postalCode = "";
			$.each(data["citoyens"], function(k, v) { 
				city = "";
				mylog.log(v);
				postalCode = "";
				var htmlIco ="<i class='fa fa-user fa-2x'></i>"
				if(v.id != userId) {
					tabObject.push(v);
					console.log(v);
	 				if(v.profilThumbImageUrl != ""){
	 					var htmlIco= "<img width='25' height='25' alt='image' class='img-circle' src='"+baseUrl+v.profilThumbImageUrl+"'/>"
	 				}
	 				if (v.address != null) {
	 					city = v.address.addressLocality;
	 					postalCode = v.address.postalCode;
	 				}
	  				str += 	"<li class='li-dropdown-scope'>" +
	  						"<a href='javascript:;' onclick='setInviteInput("+compt+");'>"+htmlIco+" "+v.name ;

	  				if(typeof postalCode != "undefined")
	  					str += "<br/>"+postalCode+" "+city;
	  					//str += "<span class='city-search'> "+postalCode+" "+city+"</span>" ;
	  				str += "</a></li>";

	  				compt++;
  				}
			});
			
			$("#invite-modal-element #dropdown_searchInvite").html(str);
			$("#invite-modal-element #dropdown_searchInvite").css({"display" : "inline" });
		}
	);	
}

function setInviteInput(num){
	mylog.log("setInviteInput", num);
	var person = tabObject[num];
	var personId = person["id"];
	mylog.log(person, personId);
	
	$('#invite-modal-element #inviteName').val(person["name"]);
	$('#invite-modal-element #inviteId').val(personId);
	$("#invite-modal-element #ficheUser-ficheName").text(person["name"]);
	$("#invite-modal-element #ficheUser-btnProfil").attr("href", "#page.type.citoyens.id."+person["id"]);


	
	if (person.address != null) {
		//Address : CP + Locality
		$("#invite-modal-element #ficheUser-address").text(((typeof person.address.postalCode == "undefined")?trad["UnknownLocality"]:person.address.postalCode+" ")+person.address.addressLocality);
	}
	
	if (person.email != null) {
		//Email
		$("#invite-modal-element #ficheUser-email").text(person.email);
	}
	//Tags
	var tagsStr = "";
	if( "object" == typeof person.tags && person.tags ) {
		$.each( person.tags , function(i,tag){
			tagsStr += "<span class='label label-inverse'>"+tag+"</span> ";
		});
	} else {
		tagsStr += "<span class='label label-inverse'>No Tag</span> ";
	}
	//$("#invite-modal-element #ficheUser-tags").html('<div class="pull-left"><i class="fa fa-tags"></i> '+tagsStr+'</div>');
	$(".photoInvited").empty();
	if (person["profilMediumImageUrl"] != "") {
		$(".photoInvited").html("<img class='img-responsive' src='"+baseUrl+person["profilMediumImageUrl"]+"' />");
	} else {
		$(".photoInvited").html("<span><i class='fa fa-user_circled fa-3x'></i></span>");
	}

	//Pending
	if (person.pending == true) {
		$(".pending").show();
	} else {
		$(".pending").hide();
	}

	//Already in the network of the current user
	;
	//if (listFollowsId.indexOf(personId) != -1) {
	if (inMyContacts("people",personId) == true) {
		$('#invite-modal-element .disconnectBtn').show();
		$('#invite-modal-element .connectBtn').hide();
	} else {
		$('#invite-modal-element .disconnectBtn').hide();
		$('#invite-modal-element .connectBtn').show();
	}

	//Show / Hide steps
	$("#invite-modal-element #dropdown_searchInvite").css({"display" : "none" });
	$("#invite-modal-element #step3").addClass("hidden");
	$("#invite-modal-element #step2").removeClass("hidden");

}

function newInvitation(){
	$("#invite-modal-element #dropdown_searchInvite").css({"display" : "none" });
	$("#invite-modal-element #step2").addClass("hidden");
	$("#invite-modal-element #step3").removeClass("hidden");
	
	$('#invite-modal-element #inviteId').val("");
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if(emailReg.test( $("#invite-modal-element #inviteSearch").val() )){
		$('#invite-modal-element #inviteEmail').val( $("#invite-modal-element #inviteSearch").val());
		$("#invite-modal-element #inviteName").val("");
	}else{
		$("#invite-modal-element #inviteName").val($("#invite-modal-element #inviteSearch").val());
		$("#invite-modal-element #inviteEmail").val("");
	}

	$("#invite-modal-element #inviteText").val("<?php echo Yii::t("person","Hello, \\nCome and meet me on that website!\\nAn email, your town and you are connected to your city!\\nYou can see everything that happens in your city and act for the commons."); ?>");
}

function fadeInView(inView){
	mylog.log("fadeInView", inView);
	$("#invite-modal-element .modal-footer").addClass("hidden");
	$("#invite-modal-element #listEmailGrid").html("");
	if(inView == "divGmail")
	{
		$("#divGmail").removeClass("hidden");
		$("#divInviteSomeone").addClass("hidden");
		$("#divGooglePlus").addClass("hidden");
		$("#divImportFile").addClass("hidden");
		$("#divWriteMails").addClass("hidden");
		$("#divCheckMail").addClass("hidden");
		//changeFocus("titleGmail");
		auth();
	}
	else if(inView == "divInviteSomeone")
	{
		$("#divInviteSomeone").removeClass("hidden");
		$("#divGmail").addClass("hidden");
		$("#divGooglePlus").addClass("hidden");
		$("#divImportFile").addClass("hidden");
		$("#divWriteMails").addClass("hidden");
		$("#divCheckMail").addClass("hidden");
		//changeFocus("titleInviteSomeone");

	}
	else if(inView == "divGooglePlus")
	{
		$("#divGooglePlus").removeClass("hidden");
		$("#divInviteSomeone").addClass("hidden");
		$("#divGmail").addClass("hidden");
		$("#divImportFile").addClass("hidden");
		$("#divWriteMails").addClass("hidden");
		$("#divCheckMail").addClass("hidden");
		//changeFocus("titleGooglePlus");
	}
	else if(inView == "divImportFile")
	{
		$("#divImportFile").removeClass("hidden");
		$("#divInviteSomeone").addClass("hidden");
		$("#divGmail").addClass("hidden");
		$("#divGooglePlus").addClass("hidden");
		$("#divWriteMails").addClass("hidden");
		$("#divCheckMail").addClass("hidden");
		//changeFocus("titleImportFile");
	}
	else if(inView == "divWriteMails")
	{
		$("#divWriteMails").removeClass("hidden");
		$("#divInviteSomeone").addClass("hidden");
		$("#divGmail").addClass("hidden");
		$("#divGooglePlus").addClass("hidden");
		$("#divImportFile").addClass("hidden");
		$("#divCheckMail").addClass("hidden");
		//changeFocus("titleWriteMails");
	}

}

function checkAndGetMailsInvite(mails){
	mylog.log("checkAndGetMailsInvite", mails);
	$.ajax({
		type: "POST",
		url: baseUrl+'/'+moduleId+'/person/getcontactsbymails',
		data: { mailsList : mails },
		dataType: "json",
		success: function(data){
			mylog.log("getcontactsbymails data", data, data.length);
			var nbContact = 0 ;
			var text2 = "" ;
			var idMail = ""
			$.each(mails, function(keyMails, valueMails){
				mylog.log("valueMails", valueMails, typeof data[valueMails]);
				nbContact++;
				idMail = "contact"+nbContact ;
				if(typeof data[valueMails] != "string" ){
					text2 += '<li id="'+idMail+'" class="item_map_list col-xs-12" style="display: inline-block;">'+
								'<div class="col-xs-1"><input id="checkbox'+idMail+'" class="checkboxList" data-id="'+idMail+'" data-mail="'+valueMails+'" data-name="" type="checkbox"></div>'+
								'<label class="col-xs-11" for="checkbox'+idMail+'">'+
									'<a href="javascript:;" onclick="checkedMailInvite(\''+idMail+'\', \''+valueMails+'\',  \'\');">';
						if(typeof data[valueMails] != "undefined" && data[valueMails] != null && typeof data[valueMails].profilThumbImageUrl != "undefined"){
							text2 += '<div class="">'+
										'<img src="'+baseUrl+data[valueMails].profilThumbImageUrl+'" alt="image" width="40" height="40" />'+
										' <span class="text-xss" > '+data[valueMails].name+' : '+ valueMails.trim() + '</span>'+
									'</div>';
						}else{
							text2 += '<div class="">'+
										'<span class="text-xss" > '+ valueMails.trim() + '</span><br/>'+
									'</div>';
						}
					text2 += '</a></label></li>';
				}else{
					text2 += '<li id="'+idMail+'" class="item_map_list col-xs-12" style="display: inline-block;">'+
								'<div class="col-xs-1"></div>'+
								'<div class="col-xs-11">'+
									'<span class="text-xss" > '+ valueMails.trim() + ((data[valueMails] != null) ? ' : '+ data[valueMails] : "" ) + '</span><br/>'+
								'</div></li>';
				}
				
			});
			$("#invite-modal-element #listEmailGrid").html(text2);
			$("#invite-modal-element .modal-footer").removeClass("hidden");
			$("#invite-modal-element #nbContacts").html(0);
			$("#invite-modal-element #allContacts").html(nbContact);
			$("#invite-modal-element #countContacts").removeClass("hidden");
			$("#invite-modal-element #listEmailGrid").removeClass("hidden");
			bindCheckboxInvite();
			$.unblockUI();
		}
	});
}

function bindCheckboxInvite() {
	$("#invite-modal-element .checkboxList").change(function() {
		checkedMailInvite($(this).data("id"), $(this).data("mail"), $(this).data("name"));
	});
};

function checkedMailInvite(id, mail, name) {
	mylog.log("checkedMailInvite", id, mail, name, typeof listMails[mail]);
	if( typeof listMails[mail] != "undefined" ){
		$( "#invite-modal-element #"+id ).removeClass("item_map_list_blue");
		$( "#invite-modal-element #"+id ).addClass("item_map_list");
		$("#invite-modal-element #checkbox"+id).prop("checked", false);
		delete(listMails[mail]);
	}else{
		$( "#invite-modal-element #"+id ).removeClass("item_map_list");
		$( "#invite-modal-element #"+id ).addClass("item_map_list_blue");
		$("#invite-modal-element #checkbox"+id).prop("checked", true);
		listMails[mail] = name ;
	}
	$("#invite-modal-element #nbContacts").html(Object.keys(listMails).length);
};

function initList() {
	$("#invite-modal-element #listEmailGrid").addHidden("hidden");
	$("#invite-modal-element .modal-footer").addHidden("hidden");
	$("#invite-modal-element #countContacts").addHidden("hidden");
};



</script>