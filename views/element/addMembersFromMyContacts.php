<style>
	
	/* MODAL */

	@media screen and (min-width: 768px) {
		#modalDirectoryForm #modal-scope .modal-dialog{
			width:760px
		}
	}
	#modalDirectoryForm  .modal-header, 
	#modalDirectoryForm  .modal-footer{
		background-color: #EAEAEA !important;
		color: #2D6569 !important;
		display: block !important;
	}

	#modalDirectoryForm  .modal-header button.close{
		color: 2D6569 !important;
		opacity: 0.6 !important;
	}
	#modalDirectoryForm  #list-scroll-type{
		max-height:400px;
		min-height:250px;
		overflow-y:auto; 
		overflow-x:hidden; 
		padding-top:15px;
		border-left: 1px solid rgba(128, 128, 128, 0.26);
	}
	#modalDirectoryForm  #list-scroll-type .panel-default,
	#modalDirectoryForm  #list-scroll-type .panel-heading,
	#modalDirectoryForm  #list-scroll-type .panel-body{
		margin-bottom: 0px;
	}

	#modalDirectoryForm  #list-scroll-type .input-group{
		margin-bottom:10px;
	}
	#modalDirectoryForm  #list-scroll-type input.form-control{
		border-radius: 0px 4px 4px 0px !important;
		text-align: left!important;
	}

	#modalDirectoryForm .modal .panel-heading{
		padding: 0px;
		min-height: auto;
		background-color: transparent;
		border: none;
	}

	#modalDirectoryForm .form-control{
		/*width:unset;*/
		padding: 0px 5px;
	}
	#modalDirectoryForm .modal input#search-contact{
		width: 66.66666667%;
		margin-top: -8px;
		margin-right: 0px;
		padding-left: 10px;
		padding-right: 10px;
		/*height: 52px;*/
		border-radius: 0px;
		text-align:left;
		background-color: rgba(255, 255, 255, 0.54);
	}

	#modalDirectoryForm .modal .panel-heading h4{
		margin:0px;
		font-size: 18px !important;
		background-color: rgba(114, 114, 114, 0.1);
		padding: 10px;
		border-radius: 0px;
	}
	#modalDirectoryForm .modal-body{
		padding: 0px 15px;
	}

	#modalDirectoryForm .panel-body{
		background-color: transparent !important;
	}
	#modalDirectoryForm .modal .panel{
		padding: 0px;
		background-color: transparent;
		border: none;
		box-shadow: none;
	}
	#modalDirectoryForm .modal ul{
		list-style: none !important;
		padding-left: 0px;
		margin-bottom:20px;
	}

	#modalDirectoryForm .modal .list-group{
		margin-bottom:0px !important;
	}
	#modalDirectoryForm .modal #list-scroll-type ul{
		margin-bottom:0px !important;
	}
	#modalDirectoryForm .modal #menu-type ul li{
		font-size:16px;
	}
	#modalDirectoryForm .modal #menu-type ul li i{
		width:20px;
		text-align: center;
	}
	#modalDirectoryForm .modal #menu-type ul li a:hover{
		color:inherit !important;	
		text-decoration: underline;
	}
	#modalDirectoryForm .modal .btn-scroll-type{
		border:none!important;
	    padding: 3px;
	    text-align: left;
	    /*width: 100%;*/
	}
	#modalDirectoryForm .modal .btn-select-contact{
		min-width:70% !important;
	}

	#modalDirectoryForm .modal #menu-type .btn-scroll-type{
		border:none!important;
	    padding: 2px;
		text-align: left;
		width: 92%;
		margin-left: 4%;
		padding: 6px 4px 4px 8px;
		margin-bottom: 3px;
		background:transparent !important;
	}
	#modalDirectoryForm .modal #menu-type .btn-scroll-type:hover{
		background-color:rgba(0, 0, 0, 0.04) !important;
	}
	#modalDirectoryForm .modal #scope-postal-code{
		width: 99%;
		display: none;
		margin-left: -1% !important;
	}
	#modalDirectoryForm .modal .info-contact{
		display: inline-block !important;
		vertical-align: middle;
	}
	#modalDirectoryForm .modal .scope-city-contact{
		text-overflow: ellipsis;
		white-space: nowrap;
		overflow: hidden;
		max-width: 160px;
		display: inline-block;
		height: 15px;
	 } 
	#modalDirectoryForm .modal .scope-name-contact{
		display: inline-block;
	    vertical-align: middle;
	    text-align: left;
	    max-width: 200px;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	    overflow: hidden;
	    font-size: 12px;
	}
	#modalDirectoryForm .modal .thumb-send-to {
	    width: 35px;
	    height: 35px;
	    background-color: #DADADA;
	    border-radius: 4px;
	    margin:5px;
	}
	#modalDirectoryForm .modal .text-light{
		font-weight:500;
		color:#8C8C8C !important;
	}

	#modalDirectoryForm .modal h4 {
	    font-size : 14px;
	}

	#modalDirectoryForm .modal #menu-type h4 {
	    background-color: rgba(35, 83, 96, 0.15);
		color: #2D6569;
		width: 100%;
		float: left;
		padding: 10px 10px 10px 20px;
		margin: 0;
		margin-bottom: 10px;
	}
	.btn-is-admin{
		text-decoration: line-through;
		display:none;
	}
	.divRoles{
		margin:5px;
		display:none;
	}
	.btn-is-admin.selected{
		display:inline;
	}
	.divRoles.selected{
		display:block;
	}
	.btn-is-admin.selected.isAdmin {
		text-decoration: none;
	}
	.btn-is-admin.selected.isAdmin a{
		color:#5cb85c!important;
	}

	.dropdown-menu-invite{
		top:31px;
	}


	#listEmailGrid  .item_map_list{
		padding:10px 10px 10px 0px !important; 
		margin-top:0px;
		text-decoration:none;
		background-color:white;
		border: 1px solid rgba(0, 0, 0, 0.08); /*rgba(93, 93, 93, 0.15);*/
		/*text-align: center;*/
	}
	#listEmailGrid  .item_map_list_blue{
		background-color:rgba(0, 0, 0, 0.08);
		padding:10px 10px 10px 0px !important; 
		margin-top:0px;
		text-decoration:none;
		border: 1px solid rgba(0, 0, 0, 0.08); /*rgba(93, 93, 93, 0.15);*/
		/*text-align: center;*/
	}
	#listEmailGrid .item_map_list .left-col .thumbnail-profil{
		width: 75px;
		height: 75px;
	}


</style>

<div id="addMembers">
	<input type="hidden" id="parentOrganisation" name="parentOrganisation" value="<?php echo $parentId; ?>"/>
</div>

<div id="formSendMailInvite" class="hidden">
	<div class="text-red"><i class="fa fa-ban"></i> <?php echo Yii::t("common","No results match in your search"); ?></div>
	<hr>
	<h3 class='text-dark'><i class="fa fa-angle-down"></i> <?php echo Yii::t("common","Invite by mail"); ?></h3>
	<div id="addMembers" style="line-height:40px; padding:0px;" autocomplete="off" submit='false'>
		<input type="hidden" id="parentOrganisation" name="parentOrganisation" value="<?php echo (string)$parentId; ?>"/>
	    <input type="hidden" id="memberId" name="memberId" value=""/>
        <div class="form-group" id="addMemberSection">

        	<input type="radio" value="citoyens" name="memberType" data-fa="user" checked> <i class="fa fa-user"></i> <?php echo Yii::t("common","a citizen"); ?>
        	<?php if($type != "events" || Authorisation::isElementAdmin($parentId, $type, @Yii::app()->session["userId"])){ ?>
        		<input type="radio" value="organizations" name="memberType" data-fa="group" style="margin-left:25px;"> <i class="fa fa-group"></i> <?php echo Yii::t("common","an organization"); ?>
        	<?php } ?>
			<div class="input-group">
		      <span class="input-group-addon" id="basic-addon1">
		        <i class="fa fa-user text-dark searchIcon tooltips" id="fa-type-contact-mail"></i>
		      </span>
		      <input class="form-control" placeholder="Son nom" id="memberName" name="memberName" value=""/>
		    </div>
		    <div class="input-group">
		      <span class="input-group-addon" id="basic-addon1">
		        <i class="fa fa-envelope-o text-dark searchIcon tooltips"></i>
		      </span>
		      <input class="member-email form-control text-left" placeholder="Son address@email.xxx" 
		      		 autocomplete="off" id="memberEmail" name="memberEmail" value=""/>
		    </div>
		    <div class="input-group organization-type">
		      <span class="input-group-addon" id="basic-addon1">
		        <i class="fa fa-users text-dark searchIcon tooltips"></i>
		      </span>
		      <select class="member-organization-type form-control text-left" autocomplete="off" id="organizationType" name="organizationType" value=""/>
		    </div>
		    <div class="col-md-12 no-padding">
		    	<span id='isAdminDiv' ><input type="checkbox" id="memberIsAdmin" value="true"> <i class="fa fa-user-secret"></i> <?php echo Yii::t("common","Add as admin"); ?></span>
		    	<button class="btn btn-primary pull-right" onclick="sendInvitationMailAddMember()">
		    		<i class="fa fa-send"></i> <?php echo Yii::t("common","Send invitation"); ?>
		    	</button>
        	</div>
        	<div class="col-md-12 padding-15 text-right" id="loader-send-mail-invite" style="margin-bottom:10px;">
		    </div>
		</div>
    </div>       		
</div>


<script type="text/javascript">
var elementType = "<?php echo $type; ?>";
var elementId = "<?php echo $parentId; ?>"
var myContactsMembers = $.extend( true, {}, myContacts );
var listContact = new Array();
var newMemberInCommunity = false;
var isElementAdmin= "<?php echo Authorisation::isElementAdmin($parentId, $type, @Yii::app()->session["userId"]) ?>";
var contactTypes = [{ name : "people", color: "yellow", icon:"user", label:"People" }];
var listMails = {};
var rolesList=[ tradCategory.financier, tradCategory.partner, tradCategory.sponsor, tradCategory.organizor, tradCategory.president, tradCategory.director, tradCategory.speaker, tradCategory.intervener];
if(elementType != "<?php echo Event::COLLECTION ?>" || isElementAdmin)
	contactTypes.push({ name : "organizations", color: "green", icon:"group", label:"Organizations" });


var members = <?php echo json_encode(@$members) ?>;

var addLinkDynForm = {
	inputType : "scope",
	title1 : trad["Add members ..."],
	title2 : trad["Among my contacts ..."],
	title3 : trad["Others ..."],
	btnCancelTitle : trad["Close"],
	btnSaveTitle : trad["Add this contacts"],
	btnResetTitle : trad["Cancel all"],
	values : myContactsMembers,
	mainTitle : trad["Invite your contacts"],
	labelBtnOpenModal : "<span class='text-dark'><i class='fa fa-group'></i> "+trad["Select among my contacts"]+"</span>",
	contactTypes : contactTypes
};

var addLinkDynFormInvite = {
	inputType : "scope",
	title1 : trad["Invite your contacts"],
	title2 : trad["Among my contacts ..."],
	title3 : trad["Others ..."],
	btnCancelTitle : trad["Close"],
	btnSaveTitle : trad["Add this contacts"],
	btnResetTitle : trad["Cancel all"],
	values : myContactsMembers,
	mainTitle : trad["Invite your contacts"],
	labelBtnOpenModal : "<span class='text-dark'><i class='fa fa-group'></i> "+trad["Select among my contacts"]+"</span>",
	contactTypes : contactTypes
};

var addLinkSearchMode = "contacts";
jQuery(document).ready(function() {

	mylog.log("here");
	if(elementType != "citoyens")
		buildModal(addLinkDynForm, "modalDirectoryForm");
	else
		buildModalInvite(addLinkDynFormInvite, "modalDirectoryForm");

	$("#select-type-search-contacts, #a-select-type-search-contacts").click(function(){
		switchContact();
	});

	$("#select-type-search-all, #a-select-type-search-all").click(function(){
		$("#select-type-search-all").prop("checked", true);
		$("#btn-save").removeClass("hidden");
		$("#list-scroll-type").html('<i class="fa fa-search fa-4x padding-15 center-block text-grey"></i>');
		$("#search-contact").attr("placeholder", trad["Research a name or e-mail address..."]);
		addLinkSearchMode = "all";
		filterContact($("#search-contact").val());
	});

	$.each(organizationTypes, function(k, v) {
   		$(".member-organization-type").append($("<option />").val(k).text(tradCategory[k]));
	});
	bindInvite();
});

function excludeMembers(contacts, members){
	mylog.log("excludeMembers",contacts, members, notEmpty(contacts), notNull(contacts));

	//delete mes contacts qui sont déjà membre
	if(members != null && notNull(contacts) && contacts.length > 0){
		$.each(members, function(idUser, value){
			if(typeof value != "undefined"){
				var type = notEmpty(value["typeSig"]) ? value["typeSig"] : notEmpty(value["type"]) ? value["type"] : null;
				if(type != null){
					var found = false; var parentFound = false;
					if(notEmpty(contacts[type]))
					$.each(contacts[type], function(key, contact){ 
						if(notEmpty(contact)){
							var contactId = notEmpty(contact["_id"]) ? contact["_id"]["$id"] : notEmpty(contact["id"]) ? contact["id"] : null;
							if(idUser == contactId){
								found = key;
							}
						}
					});
					if(notEmpty(contacts[type])){ //console.log("typeof", typeof contacts[type]);
						if(typeof contacts[type] == "array"){
							if(found!==false) contacts[type].splice(found,1);
						}else if(typeof contacts[type] == "object"){ 
							if(found!==false) delete contacts[type][found];
						}
					}
				}
			}
		});
	}
	//delete le parent qui se trouve aussi dans la liste des contact du floop
	if(elementType != "<?php echo Event::COLLECTION ?>" && elementType != "<?php echo Project::COLLECTION ?>"){
		typeElt = elementType ;
		if(elementType == "citoyens") typeElt = "people" ;
		if(notNull(contacts) && notEmpty(contacts[typeElt])){
			$.each(contacts[typeElt], function(key, contact){ 
				if(typeof contact != "undefined"){
					if(notEmpty(contact)){
						var contactId = notEmpty(contact["_id"]) ? contact["_id"]["$id"] : notEmpty(contact["id"]) ? contact["id"] : null;
						if(contactId == elementId){
							delete contacts[typeElt][key];
							return;
						}
					}
				}
			});
		}
	}
}

function switchContact(){
	mylog.log("switchContact");
	$("#select-type-search-contacts").prop("checked", true);
	$("#btn-save").removeClass("hidden");
	$("#search-contact").attr("placeholder", trad.searchamongcontact+"...");
	showMyContactInModalAddMembers(addLinkDynForm, "#list-scroll-type");
	addLinkSearchMode = "contacts";
	filterContact($("#search-contact").val());
}



function setInviteInput(num){
	mylog.log("setInviteInput", num);
	var person = tabObject[num];
	var personId = person["id"];
	mylog.log(person, personId);
	
	$('#div-invite-search-all #inviteName').val(person["name"]);
	$('#div-invite-search-all #inviteId').val(personId);
	$("#div-invite-search-all #ficheUser-ficheName").text(person["name"]);
	$("#div-invite-search-all #ficheUser-btnProfil").attr("href", "#page.type.citoyens.id."+person["id"]);


	
	if (person.address != null) {
		//Address : CP + Locality
		$("#div-invite-search-all #ficheUser-address").text(((typeof person.address.postalCode == "undefined")?trad["UnknownLocality"]:person.address.postalCode+" ")+person.address.addressLocality);
	}
	
	if (person.email != null) {
		//Email
		$("#div-invite-search-all #ficheUser-email").text(person.email);
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
	//$("#div-invite-search-all #ficheUser-tags").html('<div class="pull-left"><i class="fa fa-tags"></i> '+tagsStr+'</div>');
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
		$('.disconnectBtn').show();
		$('.connectBtn').hide();
	} else {
		$('.disconnectBtn').hide();
		$('.connectBtn').show();
	}

	//Show / Hide steps
	$("#div-invite-search-all #dropdown_searchInvite").css({"display" : "none" });
	$("#div-invite-search-all #step3").addClass("hidden");
	$("#div-invite-search-all #ficheUser").removeClass("hidden");

}

function newInvitation(){
	$("#div-invite-search-all #dropdown_searchInvite").css({"display" : "none" });
	$("#div-invite-search-all #ficheUser").addClass("hidden");
	$("#div-invite-search-all #step3").removeClass("hidden");
	
	$('#div-invite-search-all #inviteId').val("");
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if(emailReg.test( $("#div-invite-search-all #inviteSearch").val() )){
		$('#div-invite-search-all #inviteEmail').val( $("#div-invite-search-all #inviteSearch").val());
		$("#div-invite-search-all #inviteName").val("");
	}else{
		$("#div-invite-search-all #inviteName").val($("#div-invite-search-all #inviteSearch").val());
		$("#div-invite-search-all #inviteEmail").val("");
	}

	$("#inviteText").val("<?php echo Yii::t("person","Hello, \\nCome and meet me on that website!\\nAn email, your town and you are connected to your city!\\nYou can see everything that happens in your city and act for the commons."); ?>");
	//runinviteFormValidation();
}
	
function bindEventScopeModal(){
	mylog.log("bindEventScopeModal");
	/* initialisation des fonctionnalités de la modale SCOPE */
	//parcourt tous les types de contacts
	$.each(contactTypes, function(key, type){ //mylog.log("BINDEVENT CONTACTTYPES : " + type.name);
		//initialise le scoll automatique de la liste de contact
		$("#btn-scroll-type-"+type.name).click(function(){

			//console.log("click btn scroll type : "+type.name+ " " + $("#scroll-type-"+type.name).position().top);
			if($("#select-type-search-contacts").prop("checked")==false){
				$("#select-type-search-contacts").prop("checked", true);
				switchContact();
				console.log("end reload");
			}
			//mylog.log("click btn scroll type : "+type.name+ " " + $("#scroll-type-"+type.name).position().top);
			$('#list-scroll-type').animate({
				scrollTop: $('#list-scroll-type').scrollTop() + $("#scroll-type-"+type.name).position().top 
			}, 400);
		});
		//initialisation des boutons pour selectionner toutes les checkbox d'un type de contact
		$("#chk-all-type"+type.name).click(function(){
			$(".chk-scope-"+type.name).prop("checked", $(this).prop('checked'));
		});
	});
	
	$("#search-contact").keyup(function(){
		filterContact($(this).val());
	});

	$("#btn-cancel").click(function(){
		if(newMemberInCommunity && (currentView=="detail" || currentView=="directory")) {
			urlCtrl.loadByHash(location.hash);
		}
	});
	$("#btn-save").click(function(){
		sendInvitation();
	});
	$("#btn-reset-scope").click(function(){
		$.each($('.modal input:checkbox'), function(){
			$(this).prop("checked", false);
		});
		$("#scope-postal-code").val("");
	});

	// $("#a-select-type-search-contacts").click(function(){
	// 	$("#select-type-search-contacts").prop("checked", true);
	// });

	// $("#a-select-type-search-all").click(function(){
	// 	$("#select-type-search-all").prop("checked", true);
	// });

	
}


function bindEventScopeContactsModal(){
	//initialise la selection d'une checkbox contact au click sur le bouton qui lui correspond
	mylog.log("bindEventScopeContactsModal");
	// QUESTION BOUBOULE : IS THAT USED BECAUSE NEXT ONE DO THE SAME ???????? @tango @rapha 
	$(".btn-chk-contact").click(function(){ 
		var id = $(this).attr("idcontact"); 
		var type = $(this).attr("typecontact");
		//console.log(".btn-chk-contact click", type);

		var check = !$("#chk-scope-"+id).prop('checked');
		$("#chk-scope-"+id).prop("checked", check);
		if(check){
			if(type != "organizations")
				$("[data-id='"+id+"'].btn-is-admin").addClass("selected");
			$("[data-id='"+id+"'].divRoles").addClass("selected");
		}else
		$("[data-id='"+id+"'].btn-is-admin, [data-id='"+id+"'].divRoles").removeClass("selected");
	});

	$(".chk-contact").click(function(){ 
		var id = $(this).attr("idcontact"); 
		var type = $(this).attr("typecontact");
		//console.log(".btn-chk-contact click", id);

		var check = $(this).prop('checked');
		//$("#chk-scope-"+id).prop("checked", check);
		
		if(check){
			if(type != "organizations")
				$("[data-id='"+id+"'].btn-is-admin").addClass("selected");
			$("[data-id='"+id+"'].divRoles").addClass("selected");
		}else
			$("[data-id='"+id+"'].btn-is-admin, [data-id='"+id+"'].divRoles").removeClass("selected");
	});

	$(".btn-is-admin").click(function(){
		if($(this).hasClass("isAdmin"))
			$(this).removeClass("isAdmin");
		else
			$(this).addClass("isAdmin");
	});
	$('.tagsRoles').select2({tags:rolesList});
}

function buildModal(fieldObj, idUi){
	mylog.log("buildModal", fieldObj, idUi);
	//var fieldClass = " select2TagsInput select2ScopeInput";
    var fieldHTML = "";    		
	fieldHTML += '<div class="modal fade" id="modal-scope" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
				  '<div class="modal-dialog">'+
				    '<div class="modal-content">'+
				      '<div class="modal-header">'+
				        //'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
				        '<input type="text" id="search-contact" class="form-control pull-right" placeholder="'+trad.searchamongcontact+'...">' +
						'<h4 class="modal-title" id="myModalLabel"><i class="fa fa-search"></i> '+fieldObj.title1+'</h4>'+
				      '</div>'+
				      '<div class="modal-body">'+
					      '<div class="row no-padding bg-light">'+
					      	'<div class="col-md-4 col-sm-4 no-padding">'+
						        '<div class="panel panel-default">  '+	
									'<div class="panel-body no-padding">'+
										'<div class="list-group" id="menu-type">'+
											'<ul class="col-xs-12 col-sm-12 col-md-12 no-padding">';
	fieldHTML += 							'<h4 class="text-dark"> '+
												'<input type="radio" name="select-type-search" id="select-type-search-contacts" value="contacts" checked> '+
												'<a href="javascript:" id="a-select-type-search-contacts" class="text-dark">'+fieldObj.title2+'</a>'+
											'</h4>';
											$.each(fieldObj.contactTypes, function(key, type){
	fieldHTML += 								'<li>'+
													'<div id="btn-scroll-type-'+type.name+'" class="btn btn-default btn-scroll-type text-'+type.color+'">' +
														//'<input type="checkbox" name="chk-all-type'+type.name+'" id="chk-all-type'+type.name+'" value="'+type.name+'"> '+
														'<span style="font-size:16px;"><i class="fa fa-'+type.icon+'"></i> ' + trad[type.label] + "</span>" +
													'</div>'+
												'</li>';
											});									
	fieldHTML += 							'</ul>';
	fieldHTML += 							'<ul class="col-xs-6 col-sm-12 col-md-12 no-margin no-padding select-population">' + 
												'<h4 class="text-dark"> '+	
													'<input type="radio" name="select-type-search" id="select-type-search-all" value="contacts"> '+
													'<a href="javascript:" id="a-select-type-search-all" class="text-dark">'+fieldObj.title3+'</a>'+
												'</h4>';
	/*											$.each(fieldObj.contactTypes, function(key, type){
	fieldHTML += 								'<li>'+
													'<div id="btn-scroll-type-'+type.name+'" class="btn btn-default btn-scroll-type text-'+type.color+'">' +
														'<input type="checkbox" name="chk-all-type'+type.name+'" id="chk-all-type'+type.name+'" value="'+type.name+'"> '+
														'<span style="font-size:16px;"><i class="fa fa-'+type.icon+'"></i> ' + type.label + "</span>" +
													'</div>'+
												'</li>';
											});	*/
	fieldHTML +=							'</ul>' +
										'</div>'+
									'</div>'+
								'</div>' +
					      	'</div>'+
					      	'<div class="no-padding pull-right col-md-8 col-sm-8 col-xs-12 bg-white" id="list-scroll-type">';
	fieldHTML += 			'</div>' +
						'</div>'+
					  '</div>'+
				      '<div class="modal-footer">'+
				      	'<button id="btn-reset-scope" type="button" class="btn btn-default btn-sm pull-left"><i class="fa fa-repeat"></i> '+fieldObj.btnResetTitle+'</button>'+
				      	'<button id="btn-cancel" type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> '+fieldObj.btnCancelTitle+'</button>'+
				      	'<button id="btn-save" type="button" class="btn btn-success btn-sm" data-dismiss="modal"><i class="fa fa-check"></i> '+fieldObj.btnSaveTitle+'</button>'+
				      '</div>'+
				    '</div><!-- /.modal-content -->'+
				  '</div><!-- /.modal-dialog -->';

	if($("body #"+idUi).length > 0) $("body #"+idUi).html(fieldHTML);
	else $('body').prepend("<div id='"+idUi+"'>"+fieldHTML+"</div>");

	showMyContactInModalAddMembers(fieldObj, "#list-scroll-type");
	bindEventScopeModal();
}

function showMyContactInModalAddMembers(fieldObj, jqElement){
	mylog.log("showMyContactInModalAddMembers1", fieldObj, jqElement);
    
	var contacts = (notNull(fieldObj.values) ? fieldObj.values : new Array() );
	excludeMembers(contacts, members);
	fieldObj.values = contacts;

    var fieldHTML = "";
   
	$.each(fieldObj.contactTypes, function(key, type){
		mylog.log("fieldObj.contactTypes", key, type, typeof type);
	fieldHTML += 			'<div class="panel panel-default" id="scroll-type-'+type.name+'">  '+	
								'<div class="panel-heading">'+
									'<h4 class="text-'+type.color+'"><i class="fa fa-'+type.icon+'"></i> '+trad[type.label]+'</h4>'+			
								'</div>'+
								'<div class="panel-body no-padding">'+
									'<div class="list-group padding-5">'+
										'<ul>';
										if(typeof fieldObj.values[type.name] != "undefined")
										$.each(fieldObj.values[type.name], function(key2, value){ 
										if(typeof value != "undefined"){
											var cp = (typeof value.address != "undefined" && notNull(value.address) && typeof value.address.postalCode != "undefined") ? value.address.postalCode : typeof value.cp != "undefined" ? value.cp : "";
											var city = (typeof value.address != "undefined" && notNull(value.address) && typeof value.address.addressLocality != "undefined") ? value.address.addressLocality : "";
											var profilThumbImageUrl = (typeof value.profilThumbImageUrl != "undefined" && value.profilThumbImageUrl != "") ? baseUrl+'/'+ value.profilThumbImageUrl : assetPath + "/images/news/profile_default_l.png";
											var name =  typeof value.name != "undefined" ? value.name : 
														typeof value.username != "undefined" ? value.username : "";
											//mylog.log("data contact +++++++++++ "); mylog.dir(value);
											var thisKey = key+''+key2;
											//var thisValue = notEmpty(value["_id"]['$id']) ? value["_id"]['$id'] : "";
											var thisValue = getObjectId(value);
											if(name != "") {
	fieldHTML += 							'<li>';
												if (type.name == "people") {
	fieldHTML +=									'<small id="isAdmin'+getObjectId(value)+'" class="btn-is-admin 													pull-right text-grey margin-top-10" data-id="'+thisKey+'">'+
													'<a href="javascript:">admin <i class="fa fa-user-secret"></i></a>'+
													'</small>';
												}
	fieldHTML +=								'<div class="btn btn-default btn-scroll-type btn-select-contact"  												id="contact'+thisKey+'">' +
													'<div class="col-md-1 no-padding"><input type="checkbox" name="scope-'+type.name+'" class="chk-scope-'+type.name+' chk-contact" id="chk-scope-'+thisKey+'" idcontact="'+thisKey+'" value="'+thisValue+'" data-type="'+type.name+'"></div> '+
													'<div class="btn-chk-contact col-md-11 no-padding" idcontact="'+thisKey+'" typecontact="'+type.name+'">' +
														'<img src="'+ profilThumbImageUrl+'" class="thumb-send-to" height="35" width="35">'+
														'<span class="info-contact">' +
															'<span class="scope-name-contact text-dark text-bold" idcontact="'+thisKey+'">' + value.name + '</span>'+
															'<br/>'+
															'<span class="scope-cp-contact text-light" idcontact="'+thisKey+'">' + cp + ' </span>'+
															'<span class="scope-city-contact text-light" idcontact="'+thisKey+'">' + city + '</span>'+
														'</span>' +
													'</div>' +
												'</div>';
												if(isElementAdmin){
	fieldHTML +=									'<div class="divRoles col-md-12 col-sm-12 col-xs-12" data-id="'+thisKey+'"">'+
														'<input id="tagsRoles'+getObjectId(value)+'" class="tagsRoles" type="" data-type="select2" name="roles" placeholder="<?php echo Yii::t("common","Add a role") ?>" value="" style="width:100%;">'+
													'</div>';	
												}
	fieldHTML +=								'</li>';
											}
										}
										});									
	fieldHTML += 						'</ul>' +	
									'</div>'+
								'</div>'+
							'</div>';
	});
	$(jqElement).html(fieldHTML);
	bindEventScopeContactsModal();
}


function filterContact(searchVal){
	mylog.log("filterContact", searchVal, "==", addLinkSearchMode);

	if(addLinkSearchMode == "contacts"){
		$("#btn-save").removeClass("hidden");
		//masque/affiche tous les contacts présents dans la liste
		if(searchVal != "")	$(".btn-select-contact").hide();
		else				$(".btn-select-contact").show();
		//recherche la valeur recherché dans les 3 champs "name", "cp", et "city"
		$.each($(".scope-name-contact"), function() { checkSearch($(this), searchVal); });
		$.each($(".scope-cp-contact"), 	 function()	{ checkSearch($(this), searchVal); });
		$.each($(".scope-city-contact"), function() { checkSearch($(this), searchVal); });
	}else if(addLinkSearchMode == "all"){
		if(searchVal.length>2){
	    	clearTimeout(timeout);
		    timeout = setTimeout(function(){
		    	$("#iconeChargement").css("visibility", "visible");
		    	autoCompleteEmailAddMember(searchVal);
		    }, 500);

	    }else{
	    	//$("#addMembers #dropdown_search").css({"display" : "none" });
	    	//$("#iconeChargement").css("visibility", "hidden")
	    }
	}
}

function autoCompleteEmailAddMember(searchValue){
	mylog.log("autoCompleteEmailAddMember");
	$("#btn-save").removeClass("hidden");
	var data = {
		"search" : searchValue,
		"elementId" : elementId
	};
	if (elementType == "<?php echo Event::COLLECTION ?>" && !isElementAdmin)
		data.searchMode = "personOnly";

	$("#list-scroll-type").html("<div class='padding-10'><i class='fa fa-spin fa-refresh'></i> "+trad.currentlyresearching+"</div>");
	$.ajax({
		type: "POST",
        url: baseUrl+'/'+moduleId+'/search/searchmemberautocomplete',
        data: data,
        dataType: "json",
        success: function(data){
        	if(!data){
        		toastr.error(data.content);
        	}else{
        		if(!notEmpty(data.citoyens) && !notEmpty(data.organizations)){
        			$("#list-scroll-type").html("");
        			var formInvite = $("#formSendMailInvite").html();
        			formInvite = "<div class='padding-10'>"+formInvite+"</div>";
        			$("#list-scroll-type").html(formInvite);
        			$("#memberName").val($("#search-contact").val());
        			$("#btn-save").addClass("hidden");
        			$(".organization-type").hide();
        			$("input[name='memberType']").click(function(){
        				$("#fa-type-contact-mail").removeClass("fa-user").removeClass("fa-group").addClass("fa-"+$(this).data("fa"));
        				if ($(this).data('fa') == 'group') {
        					$("#isAdminDiv").hide();
        					$(".organization-type").show();
        				} else {
        					$("#isAdminDiv").show();
        					$(".organization-type").hide();
        				}
        			});
        			
        		}else{
	        		listContact = {"people" : data.citoyens, "organizations" : data.organizations};
	        		var addLinkDynForm = {
						"values" : listContact,
				        "contactTypes" : contactTypes
					};
	        		showMyContactInModalAddMembers(addLinkDynForm, "#list-scroll-type");
        		}
  			}
		}	
	})
}

//si l'élément contient la searchVal, on l'affiche
function checkSearch(thisElement, searchVal, type){
	var content = thisElement.html();
	var found = content.search(new RegExp(searchVal, "i"));
	if(found >= 0){
		var id = thisElement.attr("idcontact");
		$("#contact"+id).show();
	}
}

function sendInvitation(){
	var connectType = "member";
	//if ($("#addMembers #memberIsAdmin").val() == true) connectType = "admin";
	 var params = {
		"childs" : new Array(),
		//"organizationType" : $("#addMembers #organizationType").val(),
		"parentType" : elementType,
		"parentId" : $("#addMembers #parentOrganisation").val(),
		"connectType" : connectType
	};

	$.each($("#list-scroll-type input:checkbox"), function(key, val){
		if($(this).prop("checked") == true){
			var id = $(this).val();
			var type = $(this).data("type");// == "people" ? "citoyens" : $(this).data("type"); 
			var name = "";
			var contactPublicFound = new Array();
			var connectType = "";
			var roles = "";
			if (typeof $("#tagsRoles"+id).val() != "undefined" && $("#tagsRoles"+id).val() != ""){ 
		        roles = $("#tagsRoles"+id).val().split(",");   
		      } 
			if(addLinkSearchMode == "all") { contactPublicFound = listContact;
			}else if(addLinkSearchMode=="contacts"){ contactPublicFound = myContactsMembers; }

			$.each(contactPublicFound[type], function(k, contact){
				if (typeof contact != undefined && contact != null) {
					var idObj = getObjectId(contact);mylog.log("azioueaoziueiazue : ", idObj, id);
					if(idObj == id){mylog.log("azioueaoziueiazue XXX : ", idObj);
						name = notEmpty(contact['name']) ? contact['name'] : "";
						email = notEmpty(contact['email']) ? contact['email'] : "";
					}
				}
			});
			
			if ($("#isAdmin"+id).hasClass("isAdmin")) {
				connectType = "admin";
			}
			/*if ($("#tagsRoles"+id).val() != ""){
				roles = $("#tagsRoles"+id).val().split(",");	
			}*/

			mylog.log("add this element ?", email, type, id, name);
			if(type != "" && id != "" && name != "")
				pushChild={ 
		          "childId" : id, 
		          "childName" : name, 
		          "childEmail" : email, 
		          "childType" : type,  
		          "connectType" : connectType 
		        } 
        	if(typeof roles != "undefined" && roles != "") 
          		pushChild.roles=roles; 
        	params["childs"].push(pushChild) 
		}
	});
	mylog.log("params constructed");
	mylog.dir(params);
	//mylog.dir(myContacts);
	//return;

	
	//mylog.log(params);
	mylog.log("send ajax invite");
	/*$.blockUI({
		message : "<h4 style='font-weight:300' class='text-dark padding-10'><i class='fa fa-spin fa-circle-o-notch'></i><br>Processing<br><blockquote><p>la Liberté est la reconnaissance de la nécessité.</p><cite title='Hegel'>Hegel</cite></blockquote></h4>"
	});*/
	processingBlockUi();

	$.ajax({
        type: "POST",
        url: baseUrl+'/'+moduleId+'/link/multiconnect',
        data: params,
        dataType: "json",
        success: function(data){
        	if(!data.result){
        		toastr.error(data.msg);
        		$.unblockUI();
        		//checkIsLoggued();
        	}
        	else {
        		toastr.success(data.msg);
        		mylog.log(data);
        		/*$.each(data.newMembers, function(k, newMember){
	        		mylog.log("neewsMens >>>>");
	        		mylog.log(newMember);
	        		mapType = newMember.childType;
			        if(newMember.childType=="<?php echo Person::COLLECTION ?>")
			            mapType="people";
			        mapElements.push(newMember);
				});*/
				/*if(typeof(mapUrl) != "undefined"){
					if(typeof(mapUrl.detail.load) != "undefined" && mapUrl.detail.load)
						mapUrl.detail.load = false;
					if(typeof(mapUrl.directory.load) != "undefined" && mapUrl.directory.load)
						mapUrl.directory.load = false;
				}*/
				if(data.onlyOrganization)
					loadDataDirectory("members", "users");
				else
					loadDataDirectory("guests", "send");
				//urlCtrl.loadByHash(location.hash);
				
				$.unblockUI();
        	}
        	mylog.log(data.result);   
        },
        error:function (xhr, ajaxOptions, thrownError){
          toastr.error( thrownError );
          $.unblockUI();
        } 
	});
}

function sendInvitationMailAddMember(){ mylog.log("sendInvitationMailAddMember");
	$("#loader-send-mail-invite").html('<i class="fa fa-spinner fa-spin fa-refresh"></i> Envoi en cours...');
	var connectType = "member";
	if ($("#addMembers #memberIsAdmin").is(':checked')) connectType = "admin";
	var params = {
		"childId" : $("#addMembers #memberId").val(),
		"childName" : $("#addMembers #memberName").val(),
		"childEmail" : $("#addMembers #memberEmail").val(),
		"childType" : $("#addMembers [name='memberType']:checked").val(), 
		"organizationType" : $("#addMembers #organizationType").val(),
		"parentType" : "<?php echo $type;?>",
		"parentId" : $("#addMembers #parentOrganisation").val(),
		"connectType" : connectType
	};

	//mylog.log(params);
	if($("#addMembers #memberName").val() == "") { $("#loader-send-mail-invite").html('Merci d\'indiquer une nom'); return; }
	if($("#addMembers #memberEmail").val() == "") { $("#loader-send-mail-invite").html('Merci d\'indiquer une addresse e-mail'); return; }

	$.ajax({
        type: "POST",
        url: baseUrl+'/'+moduleId+'/link/connect',
        data: params,
        dataType: "json",
        success: function(data){
        	if(!data.result){
        		toastr.error(data.msg);
        		$("#loader-send-mail-invite").html('');
        		//checkIsLoggued();
        	}
        	else {
        		toastr.success(data.msg);
        		mylog.log(data);
        		//if(typeof updateOrganisation != "undefined" && typeof updateOrganisation == "function")
        		//	updateOrganisation( data.member,  $("#addMembers #memberType").val());
               	//setValidationTable(data.newElement,data.newElementType, false);
               	mapType = data.newElementType;
               	if(data.newElementType=="<?php echo Person::COLLECTION ?>")
               		mapType="people";
               	mapElements.push(data.newElement);
               	//Minus 1 on number of invit
               	if ($("#addMembers #memberId").val().length==0){
	               	var count = parseInt($("#numberOfInvit").data("count")) - 1;
					$("#numberOfInvit").html(count + ' invitation(s)');
					$("#numberOfInvit").data("count", count);
				}
				
				$("#search-contact").val("");
				$("#addMembers #memberId").val("");
                $("#addMembers #memberType").val("");
                $("#addMembers #memberName").val("");
                $("#addMembers #memberEmail").val("");
                $("#addMembers #memberIsAdmin").val("");
                $('#addMembers #organizationType').val("");
				$("#addMembers #memberIsAdmin").val("false");
				$('#addMembers #memberEmail').parents().eq(1).show();
				//$("[name='my-checkbox']").bootstrapSwitch('state', false);
				$("#loader-send-mail-invite").html('');
				//showSearch();
				if(typeof(mapUrl) != "undefined"){
					if(typeof(mapUrl.detail.load) != "undefined" && mapUrl.detail.load)
						mapUrl.detail.load = false;
					if(typeof(mapUrl.directory.load) != "undefined" && mapUrl.directory.load)
						mapUrl.directory.load = false;
				}
				newMemberInCommunity = true;
        	}
        	mylog.log(data.result);   
        },
        error:function (xhr, ajaxOptions, thrownError){
          toastr.error( thrownError );
          $("#loader-send-mail-invite").html('');
        } 
	});
}
/*function runinviteFormValidation(el) {
	var forminvite = $('.form-invite');
	var errorHandler2 = $('.errorHandler', forminvite);
	var successHandler2 = $('.successHandler', forminvite);
	alert("runInvinte");
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
				minlength : 2,
				required : true
			},
			inviteEmail : {
				required : true
			}
		},
		messages : {
			inviteName : "* Please specify a name",
			inviteSearch : "* Please specify a email"
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
			var parentId = $(".form-invite .invite-parentId").val();
			var invitedUserName = $("#inviteName").val();
			var invitedUserEmail = $("#inviteEmail").val();
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
		        	msgEmail : $("#inviteText").val()
		        },
				type:"POST",
		    })
		    .done(function (data) {
		    	$.unblockUI();
		        if (data &&  data.result) {               
		        	toastr.success('L\'invitation a été envoyée avec succès!');
		        	addFloopEntity(data.invitedUser.id, "<?php echo Person::COLLECTION ?>", data.invitedUser);
				      $('#inviteSearch').val("");
					//Minus 1 on number of invit
					var count = parseInt($("#numberOfInvit").data("count")) - 1;
					$("#numberOfInvit").html(count + ' invitation(s)');
					$("#numberOfInvit").data("count", count);
					backToSearch();
		        } else {
		        	$.unblockUI();
					toastr.error(data.msg);
		        }
		    });
		}
	});
};*/
// ***************** Invite *********************
function bindInvite(){

	$("#btn-save-invite").off().on('click', function()
	{
		$(this).prop("disabled",true);
		$(this).find("i").removeClass("fa-send").addClass("fa-spinner fa-spin");
		if(listMails.length == 0)
    		toastr.error("Veuillez sélectionner une adresse mail.");
    	else if($("#inviteEmail").val()=="" || $("#inviteName").val()==""){
    		if($("#inviteEmail").val()=="" && $("#inviteEmail").parent().find(".error-block-invite").length <=0)
    			$("#step3 #inviteEmail").parent().append("<span class='text-red error-block-invite'><i>* Veuillez ajouter un email</i></span>");
    		if($("#inviteName").val()=="" && $("#inviteName").parent().find(".error-block-invite").length <=0)
    			$("#step3 #inviteName").parent().append("<span class='text-red error-block-invite'><i>* Veuillez ajouter un nom</i></span>");	
    		$(this).prop("disabled",false);
			$(this).find("i").removeClass("fa-spin fa-spinner").addClass("fa-send");
    	}
    	else{
    		if($(".error-block-invite").length>=0)
    			$(".error-block-invite").remove();
    		mylog.log("listMails", listMails);
    		if(Object.keys(listMails).length==0){
    			dataInvite={msgEmail : $("#inviteText").val(),
		        	invitedUserName : $("#inviteName").val(),
		        	invitedUserEmail : $("#inviteEmail").val(),
		        	listMails:{}
		        };
    		} else{
    			dataInvite={
    				msgEmail : $("#inviteText").val(),
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
			        	$('#inviteSearch').val("");
			        	$("#div-invite-search-all #step3 #inviteName").val("");
			        	$("#div-invite-search-all #step3 #inviteEmail").val("");
			        	$("#div-invite-search-all #step3").addClass("hidden");
						//backToSearch();
						$("#div-invite-search-all #step3 #btn-save-invite").prop("disabled",false);
						$("#div-invite-search-all #step3 #btn-save-invite").find("i").removeClass("fa-spin fa-spinner").addClass("fa-send");
			        } else {
			        	$.unblockUI();
						toastr.error(data.msg);
						$("#div-invite-search-all #step3 #btn-save-invite").prop("disabled",false);
						$("#div-invite-search-all #step3 #btn-save-invite").find("i").removeClass("fa-spin fa-spinner").addClass("fa-send");
			        }
				}
		    })
		    .done(function (data){
		    	$.unblockUI();
		        
		    });
    	}
  	});

	$(".invite-search").click(function(){
		var section = $(this).data("section");
		mylog.log("section", section);
		var listSections = [ "all", "gmail", "gplus", "file", "saisir"];
		$.each(listSections, function(key, type){
			if(type != section)
				$("#div-invite-search-"+type).addClass("hidden");
		});
		$("#div-invite-search-"+section).removeClass("hidden");
		$("#listEmailGrid").html("");
		$("#countContacts").addClass("hidden");
	});

	$('#inviteSearch').keyup(function(e){
	    var search = $('#inviteSearch').val();
	    if(search.length>2){
	    	clearTimeout(timeout);
			timeout = setTimeout('autoCompleteInviteSearch2("'+encodeURI(search)+'")', 500); 
		 }else{
		 	$("#div-invite-search-all #dropdown_searchInvite").css({"display" : "none" });	
		 }	
	});

	$(".connectBtn").off().on("click", function() {
			var thiselement = this;
			follow(typeObj.person.col, $('#div-invite-search-all #inviteId').val(), userId, typeObj.person.col, function(){
			mylog.log('callback connectPerson');
			$(thiselement).children().removeClass("fa-spinner fa-spin").addClass("fa-link");			
			$('.disconnectBtn').show();
			$('.connectBtn').hide();
			//TODO add in myContacts
				//listFollowsId.push($("#newInvite #inviteId").val());

			$('#inviteSearch').val("");
			
		});
	});

	$(".disconnectBtn").off().on("click", function() {
		var thiselement = this;
		var idToDisconnect = $('#div-invite-search-all #inviteId').val();
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
			$('.disconnectBtn').hide();
			$('.connectBtn').show();
			$('#inviteSearch').val("");
			
			
		});
	});

	$("#submitAfficher").off().on("click", function() {
		var mails = $("#textareaMails").val().split(/[\s\n;]+/);
		checkAndGetMails(mails);
	});
	

	$(".form-importFile #fileEmail").change(function(e) {
		$("#list-contact").html("");
    	$("#listEmailGrid").html("");
		var ext = $(".form-importFile input#fileEmail").val().split(".").pop().toLowerCase();
		if($.inArray(ext, ["csv"]) == -1) {
			alert('Upload CSV');
			return false;
		} 
		
		if (e.target.files != undefined) {
			var reader = new FileReader();
			mylog.log("reader", reader);
			
			reader.onload = function(e) {
				var csvval = e.target.result.split("\n");
				checkAndGetMails(csvval);
			};
			reader.readAsText(e.target.files.item(0));
		}else{
			toastr.error("Nous n'avons pas réussie à lire votre fichier.")
		}
		return false;
	});
}

function checkAndGetMails(mails){
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
									'<a href="javascript:;" onclick="checkedMail(\''+idMail+'\', \''+valueMails+'\',  \'\');">';
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
									'<span class="text-xss" > '+ valueMails.trim() +" : "+ data[valueMails] + '</span><br/>'+
								'</div></li>';
				}
				
			});
			$("#listEmailGrid").html(text2);
			$("#nbContacts").html(0);
			$("#allContacts").html(nbContact);
			$("#countContacts").removeClass("hidden");
			bind2();
		}
	});
}

function bind2() {
	$(".checkboxList").change(function() {
		checkedMail($(this).data("id"), $(this).data("mail"), $(this).data("name"));
	});
};

function checkedMail(id, mail, name) {
	mylog.log("checkedMail", id, mail, name, typeof listMails[mail]);
	if( typeof listMails[mail] != "undefined" ){
		$( "#"+id ).removeClass("item_map_list_blue");
		$( "#"+id ).addClass("item_map_list");
		$("#checkbox"+id).prop("checked", false);
		delete(listMails[mail]);
	}else{
		$( "#"+id ).removeClass("item_map_list");
		$( "#"+id ).addClass("item_map_list_blue");
		$("#checkbox"+id).prop("checked", true);
		listMails[mail] = name ;
	}
	$("#nbContacts").html(Object.keys(listMails).length);
};


function autoCompleteInviteSearch2(search){
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
			
			$("#div-invite-search-all #dropdown_searchInvite").html(str);
			$("#div-invite-search-all #dropdown_searchInvite").css({"display" : "inline" });
		}
	);	
}


function buildModalInvite(fieldObj, idUi){
	mylog.log("buildModalInvite", fieldObj, idUi);
	//var fieldClass = " select2TagsInput select2ScopeInput";
    var fieldHTML = "";    		
	fieldHTML += '<div class="modal fade" id="modal-scope" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
				  '<div class="modal-dialog">'+
				    '<div class="modal-content">'+
				      '<div class="modal-header">'+
				        '<div class="col-xs-6" ><h4 class="modal-title" id="myModalLabel"><i class="fa fa-search"></i> '+fieldObj.title1+'</h4></div>'+
						'<div class="col-xs-6 hidden" id="countContacts" ><h4 class="modal-title pull-right"><span id="nbContacts"></span> / <span id="allContacts"></span> contacts selectionnées</h4></div>'+
				      '</div>'+
				      '<div class="modal-body">'+
					      '<div class="row no-padding bg-light">'+
					      	'<div class="col-md-4 col-sm-4 no-padding">'+
						        '<div class="panel panel-default">  '+	
									'<div class="panel-body no-padding">'+
										'<div class="list-group" id="menu-type">';
	fieldHTML +=							'<ul class="col-xs-6 col-sm-12 col-md-12 no-margin no-padding select-population">' + 
												'<h4 class="text-dark"> '+	
													'<input type="radio" id="invite-search-all" name="select-type-search" class="invite-search" data-section="all" value="contacts" checked="checked"> '+
													'<label for="invite-search-all" class="text-dark">Recherche</label>'+
												'</h4>'+
											'</ul>';
	// fieldHTML +=							'<ul class="col-xs-6 col-sm-12 col-md-12 no-margin no-padding select-population">' + 
	// 											'<h4 class="text-dark"> '+	
	// 												'<input type="radio" id="invite-search-gmail" name="select-type-search" class="invite-search" data-section="gmail" value="contacts"> '+
	// 												'<label for="invite-search-gmail" class="text-dark">Gmail</label>'+
	// 											'</h4>'+
	// 										'</ul>' ;
	// fieldHTML +=							'<ul class="col-xs-6 col-sm-12 col-md-12 no-margin no-padding select-population">' + 
	// 											'<h4 class="text-dark"> '+	
	// 												'<input type="radio" id="invite-search-gplus" name="select-type-search" class="invite-search" data-section="gplus" value="contacts"> '+
	// 												'<label for="invite-search-gplus" class="text-dark">Google +</label>'+
	// 											'</h4>'+
	// 										'</ul>' ;
	fieldHTML +=							'<ul class="col-xs-6 col-sm-12 col-md-12 no-margin no-padding select-population">' + 
												'<h4 class="text-dark"> '+	
													'<input type="radio" id="invite-search-file" name="select-type-search" class="invite-search" data-section="file" value="contacts"> '+
													'<label for="invite-search-file" class="text-dark">Import de fichier</label>'+
												'</h4>'+
											'</ul>' ;
	fieldHTML +=							'<ul class="col-xs-6 col-sm-12 col-md-12 no-margin no-padding select-population">' + 
												'<h4 class="text-dark"> '+	
													'<input type="radio" id="invite-search-saisir" name="select-type-search" class="invite-search" data-section="saisir" value="contacts"> '+
													'<label for="invite-search-saisir" class="text-dark">Saisir</label>'+
												'</h4>'+
											'</ul>' +
										'</div>'+
									'</div>'+
								'</div>' +
					      	'</div>'+
					      	'<div class="no-padding pull-right col-md-8 col-sm-8 col-xs-12 bg-white" id="list-scroll-type">'+
								'<div id="div-invite-search-all" class="">'+
									'<input class="invite-searchInput form-control text-left" placeholder="Un nom, un e-mail ..." autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">' +
						        		'<ul class="dropdown-menu dropdown-menu-invite" id="dropdown_searchInvite" style="">' +
											'<li class="li-dropdown-scope">-</li>' +
										'</ul>' +
									'</input>' +
									'<hr>'+
									'<div class="form-group hidden" id="ficheUser">'+
										'<div class="col-md-12 text-center">'+
											'<div class="photoInvited text-center">'+
											'</div>'+
											'<a class="pending btn btn-xs btn-red tooltips" data-toggle="tooltip" data-placement="bottom" title="Cette personne a déjà été invité, mais na pas encore rejoint le réseau">Cette personne a déjà été invité, mais n\'a pas encore rejoint le réseau</a>'+

											'<a href="javascript:;" class="connectBtn btn btn-lg tooltips " data-placement="top" data-original-title="Suivre cette personne" ><i class=" connectBtnIcon fa fa-link "></i> Suivre cette personne</a>'+
											'<a href="javascript:;" class="disconnectBtn btn btn-lg tooltips " data-placement="top" data-original-title="Ne plus suivre cette personne" ><i class=" disconnectBtnIcon fa fa-unlink "></i> Ne plus suivre cette personne</a>'+
											'<hr>'+
											'<h4 id="ficheUser-ficheName" name="ficheUser-ficheName"></h4>'+
											'<a href="" data-toggle="modal" data-target="#modal-scope"  class="btn btn-default lbh" id="ficheUser-btnProfil">Aller sur sa page</a><br>'+
											'<input id="inviteId" name="inviteId" type="hidden" value="">'+
											'<span id="ficheUser-email" name="ficheUser-email" ></span><br><br>'+
											'<span id="ficheUser-address" name="ficheUser-address" ></span><br><br>'+
											'<span id="ficheUser-tags" name="ficheUser-tags" ></span><br>'+
											'<br>'+
										'</div>'+
									'</div>'+
									'<div class="row hidden" id="step3">'+
										'<div class="row margin-bottom-10">'+
											'<div class="col-md-1 col-md-offset-1" id="iconUser">'+	
									           	'<i class="fa fa-user fa-2x"></i>'+
									       	'</div>'+
									       '	<div class="col-md-9">'+
												'<input class="invite-name form-control" placeholder="Name" id="inviteName" name="inviteName" value="" />'+
											'</div>'+
										'</div>'+
										'<div class="row margin-bottom-10">'+
											'<div class="col-md-1 col-md-offset-1">'+	
								           		'<i class="fa fa-envelope-o fa-2x"></i>'+
								           	'</div>'+
						    	        	'<div class="col-md-9">'+
												'<input class="invite-email form-control" placeholder="Email" id="inviteEmail" name="inviteEmail" value="" />'+
											'</div>'+
										'</div>'+
										'<div class="row margin-bottom-10">'+
											'<div class="col-md-1 col-md-offset-1">	'+
								           		'<i class="fa fa-align-justify fa-2x"></i>'+
								           	'</div>'+
						    	        	'<div class="col-md-9">'+
												'<textarea class="invite-text form-control" id="inviteText" name="inviteText" rows="4" />'+
											'</div>'+
										'</div>'+
										'<div class="row margin-bottom-10">'+
											'<div class="col-md-11">'+
												'<div class="form-group">'+
										    	    '<button class="btn bg-dark pull-right" id="btn-save-invite" ><i class="fa fa-send"></i> <?php echo Yii::t("common","Send invitation"); ?></button> '+
										    		'<button class="btn btn-danger pull-right btnCancel" style="margin-right:10px;" id="btnCancelStep3" >Annuler</button>'+
										    	'</div>'+
										    '</div>'+
									   ' </div>'+
									'</div>'+
								'</div>' +
								'<div id="div-invite-search-gmail" class="hidden">'+
									'Inviter vos contacts Gmail' +
								'</div>' +
								'<div id="div-invite-search-gplus" class="hidden">'+
									'Publier sur Google +, pour inviter vos amis a rejoindre Communecter' +
								'</div>' +
								'<div id="div-invite-search-file" class="hidden">'+
									'<form class="form-importFile">'+
										'<div class="col-xs-12">'+
											'Fichier (CSV) : <input type="file" id="fileEmail" name="fileEmail" accept=".csv">'+
										'</div>'+
									'</form><br/><hr/><br/>' +
								'</div>' +
								'<div id="div-invite-search-saisir" class="hidden">'+
									'<form class="form-writeMails">'+
										'<div class="col-xs-12">'+
											'<textarea id="textareaMails" class="form-control col-xs-12" rows="5"></textarea>'+
											'<a href="javascript:" class="btn btn-succes col-xs-12" id="submitAfficher">Vérification</a>'+
										'</div>'+
									'</form>'+
								'</div>'+
								'<div id="listEmailGrid" class="margin-bottom-10"></div>'+
					      	'</div>' +
						'</div>'+
					  '</div>'+
				      '<div class="modal-footer">'+
				      	'<button id="btn-cancel-invite" type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> '+fieldObj.btnCancelTitle+'</button>'+
				      	'<button id="btn-save-invite" type="button" class="btn btn-success btn-sm" data-dismiss="modal"><i class="fa fa-check"></i> '+fieldObj.btnSaveTitle+'</button>'+
				      '</div>'+
				    '</div><!-- /.modal-content -->'+
				  '</div><!-- /.modal-dialog -->';

	if($("body #"+idUi).length > 0) $("body #"+idUi).html(fieldHTML);
	else $('body').prepend("<div id='"+idUi+"'>"+fieldHTML+"</div>");
	bindEventScopeModal();
}
</script>