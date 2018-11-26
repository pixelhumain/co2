<?php
$cssJs = array(
	//'/assets/css/freelancer.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssJs, Yii::app()->theme->baseUrl);



$cssJs = array(
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssJs, Yii::app()->getRequest()->getBaseUrl(true));

?>

<style>
#modal-invite .dropdown-menu{
	top:65%;
	left : 15px;
	position: relative;

}

#modal-invite .nav-tabs > li > a {
	border: 0 none;
	border-radius: 5px;
	color: #8E9AA2;
	min-width: 70px;
	padding: 5px !important;
	margin-bottom:10px;
}
#modal-invite .nav-tabs > li > a {
	background-color: transparent !important;
}
#modal-invite .nav-tabs > li > a > div:hover {
	background-color: #3C5665;
	color:white !important;
}
#modal-invite .nav-tabs > li > a > div:focus {
	background-color: #3C5665;
	color:white !important;
}

#modal-invite  #listEmailGrid{
	max-height:400px;
	min-height:250px;
	overflow-y:auto; 
	overflow-x:hidden; 
	padding-top:15px;
	border-left: 1px solid rgba(128, 128, 128, 0.26);
}

#modal-invite .btn-scroll-type{
	border:none!important;
	padding: 3px;
	text-align: left;
	/*width: 100%;*/
}
#modal-invite .btn-select-contact{
	min-width:70% !important;
}

#modal-invite .btn-scroll-type{
	border:none!important;
	padding: 2px;
	text-align: left;
	padding: 6px 4px 4px 8px;
	margin-bottom: 3px;
	background:transparent !important;
}
#dropdown-search-invite .listInviteElement{
	cursor: pointer;
}
#modal-invite .listInviteElement:hover,#modal-invite .not-find-inside:hover, .li-dropdown-invite-results a{
	background-color:rgba(0, 0, 0, 0.04) !important;
	cursor: pointer;
}


.btn-is-admin{
	text-decoration: line-through;
	display:inline;
}
.divRoles{
	margin:5px;
}
.btn-is-admin.isAdmin {
	text-decoration: none;
}
.btn-is-admin.isAdmin a{
	color:#5cb85c!important;
}
.listInviteElement .thumb-send-to, .li-dropdown-invite-results .thumb-send-to{
	width: 40px;
    height: 40px;
    border-radius: 50%;
    padding: 3px;
    margin-top: 7px;
 }
 .listInviteElement span.name-invite{
 	margin-top: 7px;	
 }
 .listInviteElement span.follows{
 	font-style: italic;
 	color: gray;
 }
 .listInviteElement .remove-invite{
 	padding: 3px 8px;
    border-radius: 3px;
    margin-top: 19px;
 }
 .li-dropdown-invite-results{
 	list-style: none;
 }
 .li-dropdown-invite-results .success, .li-dropdown-invite-results .error{
 	border-radius:100%; 
    height: 40px;
    line-height: 40px;
    font-size: 25px;
    width: 40px;
    color: white;
 }
.li-dropdown-invite-results .msg-back{
 	font-style: italic;
 }

</style>
<div class="<?php if(empty($search) || $search == false){ ?> portfolio-modal modal fade <?php } ?>" id="modal-invite" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-content padding-top-15">
		<?php
		if(empty($search) || $search == false){ ?>
		<div class="close-modal" data-dismiss="modal">
			<div class="lr">
				<div class="rl">
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="letter-red no-margin hidden-xs">
						<i class="fa fa-plus-circle"></i> 
						<span id="title-invite">
							<?php
								if($parentType == Person::COLLECTION)
									echo Yii::t("invite","Search or invite your contacts");
								else if ($parentType == Event::COLLECTION )
									echo Yii::t("common","Invite people on") ;			
								else if ($parentType == Project::COLLECTION )
									echo Yii::t("common",'Invite contributors on') ;
								else
									echo Yii::t("common","Invite members on");
							?>
							<br/><span class="name-parent bold"></span>
						</span>
						<br>
					</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 margin-top-15 text-dark menuInvite">
					<ul class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:" class="" id="menuInviteSomeone">
								<div id="titleInviteSomeone" class='radius-10 padding-10 text-yellow text-dark'>
									<i class="fa fa-search fa-2x"></i> 
									<?php echo Yii::t("common","Search"); ?> 
								</div>
							</a>
						</li>
						
						<?php
						if($parentType != Person::COLLECTION){
						?>
						<li role="presentation">
							<a href="javascript:" class="" id="menuMyContacts">
								<div id="titleWriteMails" class='radius-10 padding-10 text-grey text-dark'>
									<i class="fa fa-users fa-2x"></i> 
									<?php echo Yii::t("invite","My contacts"); ?>
								</div>
							</a>
						</li>
						<?php
						}
						?>
						<li role="presentation">
							<a href="javascript:" class="" id="menuImportFile">
								<div id="titleImportFile" class='radius-10 padding-10 text-grey text-dark'>
									<i class="fa fa-pencil fa-2x"></i> 
									<?php echo Yii::t("invite","Others");
									//echo Yii::t("invite","Import a file"); ?> 
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="row " id="divSearchInvite">
				<div id="step1-search" class="modal-body col-xs-6" >
					<div class="form-group">
						<input type="text" class="form-control text-left" placeholder='<?php echo Yii::t("invite", "A name, an e-mail..."); ?>' autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">
						<div class="col-xs-12 no-padding" id="dropdown-search-invite" style="max-height: 400px; overflow: auto;"></div>
						<form id="form-invite" class="box-login col-xs-12 no-padding" style="padding:5px">
						<!-- <div class="col-xs-12" id="form-invite" style="padding:5px"> -->
							<div class="modal-body text-center no-padding">
								<h3 class="text-dark">
									<i class="fa fa-plus-circle padding-bottom-10"></i>
									<span class="font-light"> <?php echo Yii::t("person","Invite someone"); ?></span>
								</h3>

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
										<textarea class="invite-text form-control" id="inviteText" name="inviteText" rows="4" placeholder="<?php echo Yii::t("invite","Custom message"); ?> "></textarea>
									</div>
								</div>

							</div>
							<div class="errorHandler alert alert-danger"></div>
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								<hr>
								<button class="btn btn-success" id="btnInviteNew" ><i class="fa fa-add"></i> <?php echo Yii::t("invite","Add to the list"); ?> </button>
							</div>
						</form>
					</div>
				</div>
				<div id="step1-other" class="modal-body col-xs-6">
					<div class="form-group col-xs-12">
						<select id="typeOther" name="typeOther">
							<option value="-1"><?php echo Yii::t("common","Choose"); ?></option>
							<option value="import"><?php echo Yii::t("invite","Import a file"); ?></option>
							<option value="text"><?php echo Yii::t("invite","Write"); ?></option>
						</select>
					</div>
					<div class="form-group col-xs-12" id="step-import">
						<label for="fileEmail" > <?php echo Yii::t("invite","Files (CSV)"); ?> : <input type="file" id="fileEmail" name="fileEmail" accept=".csv"> </label>
					</div>
					<div class="form-group col-xs-12" id="step-text" >
						<textarea id="textarea-invite" rows="10" cols="50"></textarea></br>
						<button id="btnValiderTextarea" class="btn btn-success" >
							<?php echo Yii::t("invite","Check"); ?> 
						</button>
					</div>
					<span id="errorFile" class="col-xs-12 text-red" ></span>
				</div>
				<div id="step1-mycontacts" class="modal-body col-xs-6" >
					<div class="form-group">
						<div class="col-xs-12" id="dropdown-mycontacts-invite" style="max-height: 400px; overflow: auto;"></div>
					</div>
				</div>
				<div id="step2" class="modal-body col-xs-6" >
					<div class="form-group">
						<div class="col-xs-12 no-padding">
							<h4> <?php echo Yii::t("invite","List of persons invited"); ?></h4>
							<div class="col-xs-12 no-padding" id="dropdown-invite" style="max-height: 400px; overflow-y: auto;"></div>
						</div>
						<div class="col-xs-12" style="margin-top: 10px;">
							<button id="btnValider" class="btn btn-success" >
								<?php echo Yii::t("common","Launch invitations"); ?> 
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="divResult">
				<div id="stepResult" class="modal-body col-xs-12" >
					<div class="form-group">
						<div class="col-xs-12">
							<h4> <?php echo Yii::t("invite", "Result of invitations sent") ;?> </h4>
							<div class="col-xs-12" id="dropdown-result"" style="max-height: 400px; overflow: auto;"></div>
							<?php 
							if($parentType == Form::COLLECTION){ 

								?>

								<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/members/id/<?php echo $id; ?>/session/<?php echo $_GET["session"]; ?>" class="btn btn-success margin-top-20 col-xs-12 " id="btn-home" style="font-size:20px;"><i class="fa fa-home"></i> <?php echo Yii::t("invite","See the community") ?></a>
							<?php } else /*if($parentType != Person::COLLECTION) */ {?>
								<button class="btn btn-success margin-top-20 col-xs-12 link-to-community"><i class="fa fa-users"></i> <?php echo Yii::t("invite","See the community") ?></button>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	var parentType = "<?php echo $parentType; ?>";
	var parentId = "<?php echo $parentId; ?>";
	var parentLinks = <?php echo json_encode(@$parentLinks); ?>;
	// var members = <?php //echo json_encode( $members ); ?>;
	var contactTypes = {
			citoyens : { color: "yellow", icon:"user", label: trad.People },
			organizations :	{ color: "green", icon:"group", label: trad.Organizations } 
		};
	var rolesListCustom = <?php echo json_encode(@$roles); ?>;
	var isElementAdmin= "<?php echo Authorisation::isElementAdmin($parentId, $parentType, @Yii::app()->session["userId"]) ?>";

	var listInvite = { 
		citoyens : {},
		organizations : {},
		invites : {},
	};

	var isElementAdmin= "<?php echo Authorisation::isElementAdmin($parentId, $parentType, @Yii::app()->session["userId"]) ?>";

	jQuery(document).ready(function() {
		// mylog.log("members", members);
		if(parentType != "citoyens" && typeof contextData != "undefined")
			$("#title-invite .name-parent").text(contextData.name);
		initInvite();
		bindInvite();
		fadeInView("step1-search");
		if(rolesListCustom.length > 0)
			rolesList = rolesListCustom ;
	});

	function fadeInView(inView){
		mylog.log("fadeInView", inView);

		if( Object.keys(listInvite.organizations).length == 0 &&
			Object.keys(listInvite.citoyens).length == 0 && 
			Object.keys(listInvite.invites).length == 0){
			initInvite();
			if(inView == "step1-search") {
				$("#modal-invite #divSearchInvite").show();
				$("#modal-invite #step1-search").show();
			} else if(inView == "step1-other") {
				$("#modal-invite #divSearchInvite").show();
				$("#modal-invite #step1-other").show();
			} else if(inView == "step1-mycontacts") {
				$("#modal-invite #divSearchInvite").show();
				$("#modal-invite #step1-mycontacts").show();
			}else if(inView == "result"){
				$("#modal-invite #divResult").show();
				$("#modal-invite #dropdown-result").show();
			}
		} else {
			toastr.error(tradDynForm.pleaseValidateTheCurrentInvites);
		}

		
	}

	function initListInvite(){
		listInvite = { 
			citoyens : {},
			organizations : {},
			invites : {},
		};
	}

	function initInvite(){
		$("#modal-invite #divSearchInvite").hide();
		$("#modal-invite #divResult").hide();
		$("#modal-invite #step1-search").hide();
		$("#modal-invite #step1-other").hide();
		$("#modal-invite #step1-mycontacts").hide();
		$("#modal-invite #step2").hide();
		$("#modal-invite #form-invite").hide();
		$("#modal-invite #errorFile").hide();
		$("#modal-invite #step-import").hide();
		$("#modal-invite #step-text").hide();

		$("#modal-invite #dropdown-invite").html("");
		$("#modal-invite #dropdown-search-invite").html("");
		$("#modal-invite #dropdown-result").html("");
		$("#modal-invite #errorFile").html("");

		$("#modal-invite #inviteSearch").val("");
		$("#modal-invite #inviteName").val("");
		$("#modal-invite #inviteEmail").val("");
		$("#fileEmail").val("");

		$("#modal-invite .errorHandler").hide();

		
		
	}

	function bindInvite(){

		$("#modal-invite #menuMyContacts").click(function() {
			mylog.log("menuMyContacts");
			fadeInView("step1-mycontacts");
			myContactsToListInvites();
		});
		$(".link-to-community").click(function(){
			$(".close-modal").trigger("click");
			$(".load-data-community").trigger("click");
		});
		$("#modal-invite #typeOther").change(function(e) {
			mylog.log("typeOther");
			initInvite();
			fadeInView("step1-other");
			if( $(this).val() == "import" ){
				$("#modal-invite #step-import").show();
				$("#modal-invite #step-text").hide();
			} else if( $(this).val() == "text" ){
				$("#modal-invite #step-import").hide();
				$("#modal-invite #step-text").show();
			} else {
				$("#modal-invite #step-import").hide();
				$("#modal-invite #step-text").hide();
			}
		});

		$("#modal-invite #btnValiderTextarea").click(function() {
			var textarea = $("#modal-invite #textarea-invite").val();
			var mailsArray = [] ;
			if(textarea.indexOf("<") > -1)
				textarea = textarea.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi).join(';');
			mailsArray = textarea.split(/[\s\n;,]+/);
			checkAndGetMailsInvite(mailsArray);
		});


		$("#modal-invite #menuImportFile").click(function() {
			mylog.log("menuImportFile");
			fadeInView("step1-other");
		});

		$("#modal-invite #menuInviteSomeone").click(function() {
			fadeInView("step1-search");
		});

		$("#modal-invite #fileEmail").change(function(e) {
			mylog.log("fileEmail");
			$.blockUI({
				message : '<span class="homestead"><i class="fa fa-spin fa-circle-o-noch"></i> '+trad.currentlyloading+'...</span>'
			});
			//$("#listEmailGrid").html("");
			var ext = $("#modal-invite input#fileEmail").val().split(".").pop().toLowerCase();
			mylog.log("ext", ext);
			if($.inArray(ext, ["csv"]) == -1) {
				toastr.error(tradDynForm.youMustUseACSVFormat);
				return false;
			} 

			if (e.target.files != undefined) {
				initListInvite();
				var reader = new FileReader();
				mylog.log("reader", reader);
				reader.onload = function(e) {
					var csvval = e.target.result.split("\n");
					checkAndGetMailsInvite(csvval);
				};
				reader.readAsText(e.target.files.item(0));

			}else{
				toastr.error(tradDynForm.weWereUnableToReadYourFile);
			}
			return false;
		});

		$('#modal-invite #inviteSearch').keyup(function(e){
			var search = $('#modal-invite #inviteSearch').val();
			mylog.log("#modal-invite #inviteSearch", search);
			if(search.length>2){
				clearTimeout(timeout);
				timeout = setTimeout('autoCompleteInvite("'+encodeURI(search)+'")', 500); 
			}else{
				$("#modal-invite #dropdown-search-invite").hide();
				$("#modal-invite #form-invite").hide();
			}
		});

		$('#modal-invite #btnInviteNew').click(function(e){
			var form = $('#form-invite');
			var loginBtn = null;
			form.submit(function(e){ e.preventDefault() });

			var errorHandler = $('.errorHandler', form);

			form.validate({
				rules : {
					inviteEmail : {
						minlength : 2,
						required : true,
						email: true
					},
					inviteName : {
						minlength : 2,
						required : true,
					},
					inviteText : {
						maxlength : 500,
					}
				},
				submitHandler : function(form) {
					errorHandler.hide();
					var mail = $('#modal-invite #inviteEmail').val();
					var msg = $('#modal-invite #inviteText').val();
					var name = $('#modal-invite #inviteName').val();

					if(typeof listInvite.invites[mail] == "undefined"){
						var keyUnique = keyUniqueByMail(mail);
						listInvite.invites[keyUniqueByMail(mail)] = {
							name : name,
							mail : mail,
							msg : msg
						} ;

						if(parentType != "citoyens")
							listInvite.invites[keyUnique].isAdmin = "";

						$('#modal-invite #inviteEmail').val("");
						$('#modal-invite #inviteText').val("");
						$('#modal-invite #inviteName').val("");
						$("#modal-invite #form-invite").hide();
					} else {
						toastr.error(tradDynForm.alreadyInTheList);
					}

					showElementInvite(listInvite, true);
					bindRemove();
				} 
			});
			
			
		});

		$('#modal-invite #btnValider').click(function(e){
			$('#modal-invite #btnValider').prop("disabled", true);
			mylog.log("#modal-invite #btnValider", Object.keys(listInvite.organizations).length, Object.keys(listInvite.citoyens).length);
			if( Object.keys(listInvite.organizations).length > 0 || 
				Object.keys(listInvite.citoyens).length > 0 || 
				Object.keys(listInvite.invites).length > 0 ) {
				mylog.log("#modal-invite #btnValider here");
				// $('#modal-invite #btnValider').prop("disabled", true);
				// $('#modal-invite #btnValider').html("<i class='fa fa-spin fa-circle-o-notch'></i> ");

				// $( ".divRoles" ).each(function(key, value) {
				// 	mylog.log("divRoles", $(this).data("id"), $(this).data("type"));
				// 	listInvite[$(this).data("type")][$(this).data("id")]["roles"] = $("#tagsRoles"+$(this).data("id")).val().split(",");
				// });

				var params = {
					parentId : parentId,
					parentType : parentType,
					listInvite : listInvite
				};

				$.ajax({
					type: "POST",
					url: baseUrl+'/'+moduleId+"/link/multiconnect",
					data: params,
					dataType: "json",
					success: function(data){


						if(parentType == "actions"){
							toastr.info(trad["processing"]);
							// var idProposal = $(this).data("id-action");
							// uiCoop.getCoopData(parentType, parentId, "action", null, idProposal, 
							// 	function(){
							// 		uiCoop.minimizeMenuRoom(true);
							// 		uiCoop.showAmendement(false);
							// 		toastr.success(trad["processing ok"]);
							// 	}, false);
							// $(".close-modal").trigger("click");
							// $(".load-data-community").trigger("click");
						} else {
							mylog.log("link/multiconnect success", data);
							var nbInvites = data.length;
							var str = "";
							if(typeof data.citoyens != "undefined"){
								$.each(data.citoyens, function(key, value){
									if(value.result){
										mylog.log("contactsList.invites key, value", key, value);
										var newElement=(typeof value.newElement != "undefined") ? value.newElement : value.parent;
										var newElementType = (typeof newElementType != "undefined") ? newElementType : "citoyens";
										var profilThumbImageUrl = (typeof newElement.profilThumbImageUrl != "undefined" && newElement.profilThumbImageUrl != "") ? baseUrl + newElement.profilThumbImageUrl : parentModuleUrl + "/images/thumb/default_"+newElementType+".png";		
										var bgThumb=(newElementType=="citoyens") ? "yellow" : "green";
										str += "<li class='li-dropdown-invite-results col-xs-12'>"+
												'<a href="#page.type.'+newElementType+'.id.'+newElement._id.$id+'" target="_blank" class="lbh col-xs-12">'+
													"<div class='success pull-left text-green'><i class='fa fa-check'></i></div>"+
													"<div class='btn-scroll-type pull-left col-xs-10' >"+
														'<img src="'+ profilThumbImageUrl+'" class="thumb-send-to col-xs-3 bg-'+bgThumb+' no-margin" height="35" width="35"> '+
													 	'<span class="text-dark text-bold margin-left-5">'+
															newElement.name + 
														'</span><br/>'+
														'<span class="text-dark text-bold margin-left-5 text-green msg-back">' + value.msg + '</span>'+
											 		"</div>"+
												'</a>'+
											"</li>";
									}
								});
							}

							if(typeof data.invites != "undefined"){
								$.each(data.invites, function(key, value){
									if(value.result){
										mylog.log("contactsList.invites key, value", key, value);
										var newElement=(typeof value.newElement != "undefined") ? value.newElement : value.parent;
										var newElementType = (typeof newElementType != "undefined") ? newElementType : "citoyens";
										var profilThumbImageUrl = (typeof newElement.profilThumbImageUrl != "undefined" && newElement.profilThumbImageUrl != "") ? baseUrl + newElement.profilThumbImageUrl : parentModuleUrl + "/images/thumb/default_"+newElementType+".png";		
										var bgThumb=(newElementType=="citoyens") ? "yellow" : "green";
										str += "<li class='li-dropdown-invite-results col-xs-12'>"+
												'<a href="#page.type.'+newElementType+'.id.'+newElement._id.$id+'" target="_blank" class="lbh col-xs-12">'+
													"<div class='success pull-left text-green'><i class='fa fa-check'></i></div>"+
													"<div class='btn-scroll-type pull-left col-xs-10' >"+
														'<img src="'+ profilThumbImageUrl+'" class="thumb-send-to col-xs-3 bg-'+bgThumb+' no-margin" height="35" width="35"> '+
														'<span class="text-dark text-bold margin-left-5">'+
															newElement.name +
														'</span><br/>'+
														'<span class="text-dark text-bold text-green margin-left-5 msg-back">'+
															'<i class="fa fa-arrow-right"></i> '+trad.invitationsenttojoinco+'</br>'+
															'<i class="fa fa-arrow-right"></i> '+value.msg +
														'</span>'+
													"</div>"+
												'</a>'+
											"</li>";
									}
																
								});
							}

							if(typeof data.organizations != "undefined"){
								$.each(data.organizations, function(key, value){
									if(value.result){
										mylog.log("contactsList.invites key, value", key, value);
										var profilThumbImageUrl = (typeof value.newElement.profilThumbImageUrl != "undefined" && value.newElement.profilThumbImageUrl != "") ? baseUrl + value.newElement.profilThumbImageUrl : parentModuleUrl + "/images/thumb/default_"+value.newElementType+".png";		
										var bgThumb=(value.newElementType=="citoyens") ? "yellow" : "green";	
										str += "<li class='li-dropdown-invite-results col-xs-12'>"+
												'<a href="#page.type.'+value.newElementType+'.id.'+value.newElement._id.$id+'" target="_blank" class="lbh col-xs-12">'+
													"<div class='success pull-left text-green'><i class='fa fa-check'></i></div>"+
													"<div class='btn-scroll-type pull-left col-xs-10' >"+
														'<img src="'+ profilThumbImageUrl+'" class="thumb-send-to col-xs-3 bg-'+bgThumb+' no-margin" height="35" width="35"> '+
														'<span class="text-dark text-bold margin-left-5">'+
														 	value.newElement.name + 
														'</span><br/>'+
														'<span class="text-dark text-bold text-green msg-back margin-left-5">' + value.msg + '</span>'+
													"</div>"+
												"</a>"+
											"</li>";
									}
								});
							}
							$('#modal-invite #btnValider').prop("disabled", false);
							$('#modal-invite #btnValider').html(tradDynForm.launchInvitations);
							initListInvite();
							fadeInView("result");
							$("#modal-invite #dropdown-result").html(str);
						}

						
				 	}
				});
				
			}
		});
	}

	

	function showListInvite(){
		if(Object.keys(listInvite.organizations).length > 0 || Object.keys(listInvite.citoyens).length > 0|| Object.keys(listInvite.invites).length > 0 ){
			$("#modal-invite #step2").show();
		}else{
			$("#modal-invite #step2").hide();
		}
	}

	function bindRoles(){
		$('.tagsRoles').change(function(e) {
			var tag = $(this).val().split(",");
			var parent = $(this).parent() ;
			var id = parent.data("id");
			var type = parent.data("type-list");
			mylog.log("ID : ", id, type, tag);
			mylog.log("ID : ", listInvite[type]);
			mylog.log("ID : ", listInvite[type][id]);
			listInvite[type][id]["roles"] = tag;
		});

		$(".btn-is-admin").click(function(){
			mylog.log(".btn-is-admin");
			var id = $(this).data("id");
			var type = $(this).data("type-list");
			mylog.log(".btn-is-admin : ", id, type);
			if($(this).hasClass("isAdmin")){
				$(this).removeClass("isAdmin");
				listInvite[type][id].isAdmin = "";
			}
			else{
				$(this).addClass("isAdmin");
				listInvite[type][id].isAdmin = "admin";
			}
			
		});
	}

	function inMyLinks(type,id){
		var inMyC = false ;
		if(parentType == "citoyens")
			inMyC = inMyContacts(type,id) ;
		else{
			var typeLink = "members";
			if(parentType == "events")
				typeLink = "attendees";
			else if(parentType == "projects")
				typeLink = "contributors";


			if(	notNull(parentLinks) && 
				notNull(parentLinks[typeLink]) && 
				notNull(parentLinks[typeLink][id]) && 
				notNull(parentLinks[typeLink][id].type) &&
				parentLinks[typeLink][id].type == type  )
				inMyC = true ;
		}

		return inMyC;
	}

	function bindAdd(){
		$('#modal-invite .add-invite').click(function(e){

			var id = $(this).data("id");
			var type = $(this).data("type");
			var name = $(this).data("name");
			var profilThumbImageUrl = $(this).data("profilthumbimageurl");
			mylog.log(".add-invite", id, type, name, profilThumbImageUrl);

			var inMyC = inMyLinks(type,id);
			// if(parentType == "citoyens")
			// 	inMyC = inMyContacts(type,id) ;


			if(inMyC == false){
				if(type == "citoyens"){
					if(typeof listInvite.citoyens[id] == "undefined"){
						listInvite.citoyens[id] = { 
							name : name,
							profilThumbImageUrl : profilThumbImageUrl
						} ;

						if(parentType != "citoyens")
							listInvite.citoyens[id].isAdmin = "";

					}else{
						//tradMsg=(parentType!="citoyens") ? tradDynForm[alreadyInTheList+parentType] : tradDynForm[alreadyInTheList];
						toastr.error(tradDynForm.alreadyInTheList);
					}
				}else if(type == "organizations"){
					if(typeof listInvite.organizations[id] == "undefined"){
						listInvite.organizations[id] = { 
							name : name,
							profilThumbImageUrl : profilThumbImageUrl
						} ;
					}else{
						//tradMsg=(parentType!="citoyens") ? tradDynForm[alreadyInTheList+parentType] : tradDynForm[alreadyInTheList];
						toastr.error(tradDynForm.alreadyInTheList);
					}
				}
				showElementInvite(listInvite, true);
				bindRemove();
			}else{
				tradMsg=(parentType!="citoyens") ? tradDynForm["alreadyInTheList"+parentType] : tradDynForm.thisPersonIsAlreadyOnYourContacts;
				toastr.error(tradMsg);
			}
			
		});
	}

	function bindRemove(){
		$('#modal-invite .remove-invite').click(function(e){
			var id = $(this).data("id");
			var type = $(this).data("type");

			mylog.log(".remove-invite", id , type);

			if(type == "citoyens"){

				if(typeof id != "undefined" && typeof listInvite.citoyens[id] != "undefined"){
					delete listInvite.citoyens[id] ;
				}else if(typeof id != "undefined" && typeof listInvite.invites[id] != "undefined"){
					delete listInvite.invites[id] ;
				}
				
			}else if(type == "organizations"){
				if(typeof listInvite.organizations[id] != "undefined"){
					delete listInvite.organizations[id] ;
				}
			}
			showElementInvite(listInvite, true);
			bindRemove();
		});

	}


	function autoCompleteInvite(search){
		mylog.log("autoCompleteInvite", search);
		if (search.length < 3) { return }
		tabObject = [];

		var searchMode = "personOnly";
		if(parentType != "citoyens" && parentType != "person"){
			searchMode = "mixte";
		}

		var data = { 
			"search" : search,
			"searchMode" : searchMode
		};

		mylog.log("url", baseUrl+'/'+moduleId+"/search/searchmemberautocomplete");
		$.ajax({
			type: "POST",
			url: baseUrl+'/'+moduleId+"/search/searchmemberautocomplete",
			data: data,
			dataType: "json",
			success: function(data){
				mylog.log("autoCompleteInvite success", data);
				showElementInvite(data);
				bindAdd();
			}
		});
	}

	function showElementInvite(contactsList, invite=false, dropdown = "#dropdown-search-invite"){
		mylog.log("showElementInvite", contactsList, invite);
		mylog.log("showElementInvite length", Object.keys(contactsList.citoyens).length);
		//var dropdown = "#dropdown-search-invite";
		var listNotExits = true;
		var addRoles = {};
		var searchInContactsList=(dropdown=="#dropdown-mycontacts-invite") ? true : false;
		var str = "";
		if(invite == true){
			dropdown = "#dropdown-invite";
		}else if(!searchInContactsList){
			var str = "<div class='col-xs-12 no-padding'><div class='btn-scroll-type col-xs-12 not-find-inside padding-20'><a href='javascript:;' onclick='newInvitation()' class='col-xs-12 text-center'>"+trad.notfoundlaunchinvite+" !</a></div></div>";
		}
		if(notNull(contactsList.citoyens) && Object.keys(contactsList.citoyens).length ){
			str += '<div class="col-xs-12 no-padding">'+
						'<h5 class="padding-10 text-'+contactTypes.citoyens.color+'"><i class="fa fa-'+contactTypes.citoyens.icon+'"></i> '+contactTypes.citoyens.label+'<hr></h5>'+			
					'</div>';
			$.each(contactsList.citoyens, function(key, value){
				mylog.log("contactsList.citoyens key, value", key, value);
				str += htmlListInvite(key, value, invite, "citoyens", invite, searchInContactsList);

				if(typeof value.roles != "undefined" || typeof value.roles == null){
					var tagRolesList = [] ;
					$.each(value.roles, function(i,k) { tagRolesList.push( {id:k,text:k} ); });
					addRoles[key] = tagRolesList;
				}
			});

			listNotExits = false;
		}

		if(notNull(contactsList.invites) && Object.keys(contactsList.invites).length ){
			$.each(contactsList.invites, function(key, value){
				mylog.log("contactsList.invites key, value", key, value);
				str += htmlListInvite(key, value, invite, "invites", searchInContactsList);

				if(typeof value.roles != "undefined" || typeof value.roles == null){
					var tagRolesList = [] ;
					$.each(value.roles, function(i,k) { tagRolesList.push( {id:k,text:k} ); });
					addRoles[key] = tagRolesList;
				}
			});
			listNotExits = false;
		}

		if(notNull(contactsList.organizations) && Object.keys(contactsList.organizations).length ){
			str += '<div class="col-xs-12 no-padding">'+
						'<h5 class="padding-10 text-'+contactTypes.organizations.color+'"><i class="fa fa-'+contactTypes.organizations.icon+'"></i> '+contactTypes.organizations.label+'<hr></h5>'+			
					'</div>';
			$.each(contactsList.organizations, function(key, value){
				mylog.log("contactsList.organizations key, value", key, value);
				str += htmlListInvite(key, value, invite, "organizations", searchInContactsList);

				if(typeof value.roles != "undefined" || typeof value.roles == null){
					var tagRolesList = [] ;
					$.each(value.roles, function(i,k) { tagRolesList.push( {id:k,text:k} ); });
					addRoles[key] = tagRolesList;
				}
			});
			listNotExits = false;
		}

		mylog.log("showElementInvite", dropdown);
		$("#modal-invite "+dropdown).html(str);

		$('#modal-invite .tagsRoles').select2({tags:rolesList});

		mylog.log("addRoles", addRoles);
		$.each(addRoles, function(key, value){
			$('#tagsRoles'+key).select2("data",value);
		});
		
		bindRoles();

		$("#modal-invite "+dropdown).show();


		if(listNotExits)
			newInvitation();
		else
			$("#modal-invite #form-invite").hide();

		showListInvite();
	}

	function htmlListInvite(id, elem, invite, type, searchInContactsList){
		//( typeof elem.id != "undefined" ? elem.id : elem.email )
		mylog.log("htmlListInvite", id, elem, invite, type, searchInContactsList);
		var typeList = type ;
		if(type ==  "invites" )
			type = "citoyens";
		var inMyContact = (!searchInContactsList) ? inMyContacts(type,id) : false;
		var profilThumbImageUrl = (typeof elem.profilThumbImageUrl != "undefined" && elem.profilThumbImageUrl != "") ?  elem.profilThumbImageUrl : parentModuleUrl + "/images/thumb/default_"+type+".png";		
		var str = "<div class='col-xs-12 listInviteElement no-padding'>";
			var classStr = "col-xs-10";
			if(invite == true){
				str+='<div class="col-xs-2"><button class="btn bg-red btn-link text-red tooltips pull-left remove-invite" '+
						'id="'+id+'Remove" '+
						'name="'+id+'Remove" '+
						'data-toggle="tooltip" data-placement="top" '+
						'data-type="'+type+'" ' +
						'data-type-list="'+typeList+'" ' +
						'data-id="'+id+'" ' + 
						'data-toggle="tooltip" data-placement="bottom" title="'+trad.clear+'" >'+
						'<i class="fa fa-remove"></i>'+
						'</button></div>';
			} else {
				classStr = "col-xs-12 add-invite";
			}

			str +="<div class='btn-scroll-type "+classStr+"'"+
					" data-id='"+id+"' "+
					'id="'+id+'AddList" '+
					'name="'+id+'AddList"'+
					" data-name='"+elem.name+"' "+
					" data-profilThumbImageUrl='"+profilThumbImageUrl+"' "+
					'data-type-list="'+typeList+'" ' +
					" data-type='"+type+"' >";
				bgThumb=(type=="citoyens") ? "yellow" : "green";
					str += '<img src="'+ baseUrl + profilThumbImageUrl+'" class="thumb-send-to col-xs-3 bg-'+bgThumb+'" height="35" width="35"> ';
				/*else {
					if(type == "citoyens")
						str += '<i class="fa fa-user "></i> ';
					else if(type == "organizations")
						str += '<i class="fa fa-users "></i> ';
				}*/
				marginName= (!inMyContact) ? "margin-top-15" : "";
				str += '<span class="text-dark text-bold name-invite col-xs-9 elipsis '+marginName+'">' + elem.name ; 
				mylog.log("mailalal", typeList, elem.mail, (typeList == "invites" && typeof elem.mail != "undefined"));
				if(typeList == "invites" && typeof elem.mail != "undefined"){
					mylog.log("mailalal", typeList, elem.mail);
					str += ' <'+ elem.mail +'> </span>';
				}
				str += '</span>';

				if(inMyContact == true && parentType=="citoyens")
					str += ' <span class="text-bold col-xs-9 follows tooltips"> '+
								'<i class="fa fa-link" data-toggle="tooltip" data-placement="top" title="'+trad.follows+'" alt="" data-original-title="'+trad.follows+'"></i> In my contacts'+
							'</span>';

				if (invite == true && parentType != "citoyens" && type == "citoyens") {

					var isAdmin = ( (typeof elem.isAdmin != "undefined" && elem.isAdmin == "admin") ? "isAdmin" : "" );
					str += '<small id="isAdmin'+id+'" class="btn-is-admin pull-right text-grey margin-top-20 '+isAdmin+'" data-id="'+id+'" data-type="'+type+'" data-type-list="'+typeList+'" >'+
								'<a href="javascript:">admin <i class="fa fa-user-secret"></i></a>'+
							'</small>';
				}
				
				if(invite == true && parentType != "citoyens"){
					str += '<div class="divRoles col-md-12 col-sm-12 col-xs-12" data-id="'+id+'" data-type="'+type+'" data-type-list="'+typeList+'" >'+
								'<input id="tagsRoles'+id+'" class="tagsRoles" type="text" data-type="select2" name="roles" placeholder="'+tradDynForm.addroles+'" style="width:100%;">'+
							'</div>';	
				}
			str += "</div>";
		str += "</div>";
		return str ;
	}


	function newInvitation(){
		$("#modal-invite #dropdown-search-invite").hide();
		$("#modal-invite #form-invite").show();
		
		
		$('#modal-invite #inviteId').val("");
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if(emailReg.test( $("#modal-invite #inviteSearch").val() )){
			$('#modal-invite #inviteEmail').val( $("#modal-invite #inviteSearch").val());
			var nameEmail = $("#modal-invite #inviteSearch").val().split("@");
			$("#modal-invite #inviteName").val(nameEmail[0]);
		}else{
			$("#modal-invite #inviteName").val($("#modal-invite #inviteSearch").val());
			$("#modal-invite #inviteEmail").val("");
		}

		$("#modal-invite #inviteText").val();
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
				var regexMail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				
				var nbError = 0;
				$.each(data, function(keyMails, valueMails){
					mylog.log("keyMails valueMails", keyMails, valueMails, typeof valueMails);
					
  					
					if(typeof valueMails == "object"){
						listInvite.citoyens[valueMails.id] = { 
							name : valueMails.name,
							profilThumbImageUrl : valueMails.profilThumbImageUrl
						} ;

						if(parentType != "citoyens")
							listInvite.citoyens[valueMails.id].isAdmin = "";

					} else {
						mylog.log("regexMail", keyMails, regexMail.test(keyMails))
						if(regexMail.test(keyMails)){
							listInvite.invites[keyUniqueByMail(keyMails)] = {
								name : keyMails,
								mail : keyMails,
								msg : ""
							} ;

							if(parentType != "citoyens")
								listInvite.invites[keyUniqueByMail(keyMails)].isAdmin = "";
						} else {
							nbError++;
						}
						
					}
					
				});
				showElementInvite(listInvite, true);
				bindRemove();
				mylog.log("nbError", nbError);
				if(nbError > 0){
					$("#modal-invite #errorFile").html(nbError+ " mails ne sont pas valides");
					$("#modal-invite #errorFile").show();
				}

				$.unblockUI();
			}
		});
	}


	function myContactsToListInvites(){
		var listMyContacts = {
			citoyens : {},
			organizations : {}
		} ;

		$.each(myContacts.citoyens, function(key, value){
			mylog.log("myContacts.people", value);
			listMyContacts.citoyens[value._id.$id] = { 
				name : value.name,
				profilThumbImageUrl : value.profilThumbImageUrl
			} ;
		});

		$.each(myContacts.organizations, function(key, value){
			mylog.log("myContacts.organizations", value);
			listMyContacts.organizations[value._id.$id] = { 
				name : value.name,
				profilThumbImageUrl : value.profilThumbImageUrl
			} ;
		});

		showElementInvite(listMyContacts, false, "#dropdown-mycontacts-invite");
		bindAdd();
	}


	function keyUniqueByMail(mail) {
		var keyUnique = "";
		for (var i=0; i < mail.length; i++) {
			keyUnique += mail.charCodeAt(i);
		}
		return keyUnique ;
	}



</script>


