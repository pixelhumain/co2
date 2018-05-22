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
	width: 92%;
	margin-left: 4%;
	padding: 6px 4px 4px 8px;
	margin-bottom: 3px;
	background:transparent !important;
}

#modal-invite .btn-scroll-type:hover{
	background-color:rgba(0, 0, 0, 0.04) !important;
}

</style>

<div class="<?php if(empty($search) || $search == false){ ?> portfolio-modal modal fade <?php } ?>" id="modal-invite" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-content padding-top-15">
		<?php if(empty($search) || $search == false){ ?>
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
								else
									echo Yii::t("common","Invite members");
							?>
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
						<li role="presentation">
							<a href="javascript:" class="" id="menuImportFile">
								<div id="titleImportFile" class='radius-10 padding-10 text-grey text-dark'>
									<i class="fa fa-upload fa-2x"></i> 
									<?php echo Yii::t("invite","Import a file"); ?> 
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
					</ul>
				</div>
			</div>
			<div class="row " id="divSearchInvite">
				<div id="step1-search" class="modal-body col-xs-6" >
					<div class="form-group">
						<input type="text" class="form-control text-left" placeholder='<?php echo Yii::t("invite", "A name, an e-mail..."); ?>' autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">
						<div class="col-xs-12" id="dropdown-search-invite" style="max-height: 400px; overflow: auto;"></div>
						<form id="form-invite" class="box-login col-xs-12" style="padding:5px">
						<!-- <div class="col-xs-12" id="form-invite" style="padding:5px"> -->
							<div class="modal-body text-center">
								<h2 class="text-green">
									<i class="fa fa-plus-circle padding-bottom-10"></i>
									<span class="font-light"> <?php echo Yii::t("person","Invite someone"); ?></span>
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
										<textarea class="invite-text form-control" id="inviteText" name="inviteText" rows="4" placeholder="<?php echo Yii::t("invite","Custom message"); ?> "></textarea>
									</div>
								</div>

							</div>
							<div class="errorHandler alert alert-danger"></div>
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								<hr>
								<button class="btn btn-primary" id="btnInviteNew" ><i class="fa fa-add"></i> <?php echo Yii::t("invite","Add to the list"); ?> </button>
							</div>
						</form>
					</div>
				</div>
				<div id="step1-import" class="modal-body col-xs-6">
					<div class="form-group">
						<label for="fileEmail" > <?php echo Yii::t("invite","Files (CSV)"); ?> : <input type="file" id="fileEmail" name="fileEmail" accept=".csv"> </label>
					</div>
				</div>
				<div id="step1-mycontacts" class="modal-body col-xs-6" >
					<div class="form-group">
						<div class="col-xs-12" id="dropdown-mycontacts-invite" style="max-height: 400px; overflow: auto;"></div>
					</div>
				</div>
				<div id="step2" class="modal-body col-xs-6" >
					<div class="form-group">
						<div class="col-xs-12">
							<h4> <?php echo Yii::t("invite","List of persons invited"); ?></h4>
							<div class="col-xs-12" id="dropdown-invite" style="max-height: 400px; overflow: auto;"></div>
						</div>
						<div class="col-xs-12" style="margin-top: 10px;">
							<button id="btnValider" >
								<i class="fa fa-check"> </i><?php echo Yii::t("common","Invite"); ?> 
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="divResult">
				<div id="stepResult" class="modal-body col-xs-12" >
					<div class="form-group">
						<div class="col-xs-12">
							<h4> <?php echo Yii::t("common", "Results") ;?> </h4>
							<div class="col-xs-12" id="dropdown-result"" style="max-height: 400px; overflow: auto;"></div>
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
	// var members = <?php //echo json_encode( $members ); ?>;
	var contactTypes = {
			citoyens : { color: "yellow", icon:"user", label:"People" },
			organizations :	{ color: "green", icon:"group", label:"Organizations" } 
		};

	var isElementAdmin= "<?php echo Authorisation::isElementAdmin($parentId, $parentType, @Yii::app()->session["userId"]) ?>";

	var listInvite = { 
		citoyens : {},
		organizations : {},
		invites : {},
	};

	jQuery(document).ready(function() {
		// mylog.log("members", members);
		initInvite();
		bindInvite();
		fadeInView("step1-search");
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
			} else if(inView == "step1-import") {
				$("#modal-invite #divSearchInvite").show();
				$("#modal-invite #step1-import").show();
			} else if(inView == "step1-mycontacts") {
				$("#modal-invite #divSearchInvite").show();
				$("#modal-invite #step1-mycontacts").show();
			}else if(inView == "result"){
				$("#modal-invite #divResult").show();
				$("#modal-invite #dropdown-result").show();
			}
		} else {
			toastr.error("Ajouter les users");
		}

		
	}

	function initInvite(){
		$("#modal-invite #divSearchInvite").hide();
		$("#modal-invite #divResult").hide();
		$("#modal-invite #step1-search").hide();
		$("#modal-invite #step1-import").hide();
		$("#modal-invite #step1-mycontacts").hide();
		$("#modal-invite #step2").hide();
		$("#modal-invite #form-invite").hide();

		$("#modal-invite #dropdown-invite").html("");
		$("#modal-invite #dropdown-search-invite").html("");
		$("#modal-invite #dropdown-result").html("");

		$("#modal-invite #inviteSearch").val("");
		$("#modal-invite #inviteName").val("");
		$("#modal-invite #inviteEmail").val("");

		$("#modal-invite .errorHandler").hide();
		
	}

	function bindInvite(){

		$("#modal-invite #menuMyContacts").click(function() {
			mylog.log("menuMyContacts");
			fadeInView("step1-mycontacts");
			myContactsToListInvites();
		});


		$("#modal-invite #menuImportFile").click(function() {
			mylog.log("menuImportFile");
			fadeInView("step1-import");
		});

		$("#modal-invite #menuInviteSomeone").click(function() {
			fadeInView("step1-search");
		});

		$("#modal-invite #fileEmail").change(function(e) {
			mylog.log("fileEmail");
			$.blockUI({
				message : '<span class="homestead"><i class="fa fa-spin fa-circle-o-noch"></i> Merci de patienter ...</span>'
			});
			//$("#listEmailGrid").html("");
			var ext = $("#modal-invite input#fileEmail").val().split(".").pop().toLowerCase();
			mylog.log("ext", ext);
			if($.inArray(ext, ["csv"]) == -1) {
				toastr.error(tradDynForm.youMustUseACSVFormat);
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
						listInvite.invites[keyUniqueByMail(mail)] = {
							name : name,
							mail : mail,
							msg : msg
						} ;
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
			mylog.log("#modal-invite #btnValider", Object.keys(listInvite.organizations).length, Object.keys(listInvite.citoyens).length);
			if( Object.keys(listInvite.organizations).length > 0 || 
				Object.keys(listInvite.citoyens).length > 0 || 
				Object.keys(listInvite.invites).length > 0 ) {
				mylog.log("#modal-invite #btnValider here");


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
						mylog.log("link/multiconnect success", data);
						var nbInvites = data.length;
						var str = "";
						if(typeof data.citoyens != "undefined"){
							$.each(data.citoyens, function(key, value){
								mylog.log("contactsList.invites key, value", key, value);
								if(value.result == true){
									str += "<li class='li-dropdown-scope'>";
										str +="<div class='btn-scroll-type' >";
												str += '<span class="text-dark text-bold">' + value.newElement.name + ' a été invité-e </span>';
										str += "</div>";
									str += "</li>";
								}else{
									str += "<li class='li-dropdown-scope'>";
										str +="<div class='btn-scroll-type' >";
											str += '<span class="text-dark text-bold">' + value.msg + '</span>';
										str += "</div>";
									str += "</li>";
								}
							});
						}

						if(typeof data.invites != "undefined"){
							$.each(data.invites, function(key, value){
								mylog.log("contactsList.invites key, value", key, value);
								if(value.result == true){
									str += "<li class='li-dropdown-scope'>";
										str +="<div class='btn-scroll-type' >";
												str += '<span class="text-dark text-bold">' + value.newElement.name + ' a été invité-e </span>';
										str += "</div>";
									str += "</li>";
								}else{
									str += "<li class='li-dropdown-scope'>";
										str +="<div class='btn-scroll-type' >";
											str += '<span class="text-dark text-bold">' + value.msg + '</span>';
										str += "</div>";
									str += "</li>";
								}
							});
						}

						if(typeof data.organizations != "undefined"){
							$.each(data.organizations, function(key, value){
								mylog.log("contactsList.invites key, value", key, value);
								if(value.result == true){
									str += "<li class='li-dropdown-scope'>";
										str +="<div class='btn-scroll-type' >";
												str += '<span class="text-dark text-bold">' + value.newElement.name + ' a été invité-e </span>';
										str += "</div>";
									str += "</li>";
								}else{
									str += "<li class='li-dropdown-scope'>";
										str +="<div class='btn-scroll-type' >";
											str += '<span class="text-dark text-bold">' + value.msg + '</span>';
										str += "</div>";
									str += "</li>";
								}
							});
						}
						
						listInvite = { 
							citoyens : {},
							organizations : {},
							invites : {},
						};
						fadeInView("result");
						$("#modal-invite #dropdown-result").html(str);
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
	}

	function bindAdd(){
		$('#modal-invite .add-invite').click(function(e){

			var id = $(this).data("id");
			var type = $(this).data("type");
			var name = $(this).data("name");
			var profilThumbImageUrl = $(this).data("profilThumbImageUrl");
			mylog.log(".add-invite", id, type, name, profilThumbImageUrl);

			inMyC = false ;
			if(parentType == "citoyens")
				inMyC = inMyContacts(type,id)

			if(inMyC == false){
				if(type == "citoyens"){
					if(typeof listInvite.citoyens[id] == "undefined"){
						listInvite.citoyens[id] = { 
							name : name,
							profilThumbImageUrl : profilThumbImageUrl
						} ;
					}else{
						toastr.error(tradDynForm.alreadyInTheList);
					}
				}else if(type == "organizations"){
					if(typeof listInvite.organizations[id] == "undefined"){
						listInvite.organizations[id] = { 
							name : name,
							profilThumbImageUrl : profilThumbImageUrl
						} ;
					}else{
						toastr.error(tradDynForm.alreadyInTheList);
					}
				}
				showElementInvite(listInvite, true);
				bindRemove();
			}else{
				toastr.error("In My Contacts");
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
		if(parentType == "organizations"){
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
		if(invite == true){
			var str = "";
			dropdown = "#dropdown-invite";
		}else{
			var str = "<div class='col-xs-12'><div class='btn-scroll-type'><a href='javascript:;' onclick='newInvitation()' >Pas trouvé ? Lancer une invitation à rejoindre votre réseau !</a></div></div>";
		}
		
		if(notNull(contactsList.citoyens) && Object.keys(contactsList.citoyens).length ){
			str += '<div class="col-xs-12">'+
						'<h5 class="padding-10 text-'+contactTypes.citoyens.color+'"><i class="fa fa-'+contactTypes.citoyens.icon+'"></i> '+contactTypes.citoyens.label+'<hr></h5>'+			
					'</div>';
			$.each(contactsList.citoyens, function(key, value){
				mylog.log("contactsList.citoyens key, value", key, value);
				str += htmlListInvite(key, value, invite, "citoyens", invite);

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
				str += htmlListInvite(key, value, invite, "invites", invite);

				if(typeof value.roles != "undefined" || typeof value.roles == null){
					var tagRolesList = [] ;
					$.each(value.roles, function(i,k) { tagRolesList.push( {id:k,text:k} ); });
					addRoles[key] = tagRolesList;
				}
			});
			listNotExits = false;
		}

		if(notNull(contactsList.organizations) && Object.keys(contactsList.organizations).length ){
			str += '<div class="col-xs-12">'+
						'<h5 class="padding-10 text-'+contactTypes.organizations.color+'"><i class="fa fa-'+contactTypes.organizations.icon+'"></i> '+contactTypes.organizations.label+'<hr></h5>'+			
					'</div>';
			$.each(contactsList.organizations, function(key, value){
				mylog.log("contactsList.organizations key, value", key, value);
				str += htmlListInvite(key, value, invite, "organizations", invite);
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

	function htmlListInvite(id, elem, invite, type, role=false){
		//( typeof elem.id != "undefined" ? elem.id : elem.email )
		mylog.log("htmlListInvite", id, elem, invite, type, role);
		var typeList = type ;
		if(type ==  "invites" )
			type = "citoyens";

		var inMyContact = inMyContacts(type,id);

		var profilThumbImageUrl = (typeof elem.profilThumbImageUrl != "undefined" && elem.profilThumbImageUrl != "") ? baseUrl+'/'+ elem.profilThumbImageUrl : "";
		var str = "<div class='col-xs-12'>";
			var classStr = " ";
			if(invite == true){
				str+='<button class="btn btn-link text-red tooltips col-xs-2 remove-invite" '+
						'id="'+id+'Remove" '+
						'name="'+id+'Remove" '+
						'data-toggle="tooltip" data-placement="top" '+
						'data-type="'+type+'" ' +
						'data-type-list="'+typeList+'" ' +
						'data-id="'+id+'" ' + 
						'data-toggle="tooltip" data-placement="top" title="Remove" >'+
						'<i class="fa fa-remove"></i>'+
						'</button>';
			} else {
				classStr = " add-invite";
			}

			str +="<div class='btn-scroll-type "+classStr+"'"+
					" data-id='"+id+"' "+
					'id="'+id+'AddList" '+
					'name="'+id+'AddList"'+
					" data-name='"+elem.name+"' "+
					" data-profilThumbImageUrl='"+profilThumbImageUrl+"' "+
					'data-type-list="'+typeList+'" ' +
					" data-type='"+type+"' >";
				if(profilThumbImageUrl != "")
					str += '<img src="'+ profilThumbImageUrl+'" class="thumb-send-to" height="35" width="35"> ';
				else {
					if(type == "citoyens")
						str += '<i class="fa fa-user "></i> ';
					else if(type == "organizations")
						str += '<i class="fa fa-users "></i> ';
				}

				str += '<span class="text-dark text-bold">' + elem.name + '</span>';
				if(inMyContact == true)
					str += ' <span class="text-dark text-bold text-green follows tooltips"> '+
								'<i class="fa fa-link" data-toggle="tooltip" data-placement="top" title="'+trad.follows+'" alt="" data-original-title="'+trad.follows+'"></i>'+
							'</span>';
				
				if(invite == true && parentType != "citoyens"){
					str += '<div class="divRoles col-md-12 col-sm-12 col-xs-12" data-id="'+id+'" data-type="'+type+'" data-type-list="'+typeList+'" >'+
								'<input id="tagsRoles'+id+'" class="tagsRoles" type="text" data-type="select2" name="roles" placeholder="Add a role" value="" style="width:100%;">'+
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
				$.each(data, function(keyMails, valueMails){
					mylog.log("keyMails valueMails", keyMails, valueMails, typeof valueMails);
					
					if(typeof valueMails == "object"){
						listInvite.citoyens[valueMails.id] = { 
							name : valueMails.name,
							profilThumbImageUrl : valueMails.profilThumbImageUrl
						} ;
					} else {
						listInvite.invites[keyUniqueByMail(keyMails)] = {
							name : keyMails,
							email : keyMails,
							msg : ""
						} ;
					}
					
				});
				showElementInvite(listInvite, true);
				$.unblockUI();
			}
		});
	}


	function myContactsToListInvites(){
		var listMyContacts = {
			citoyens : {},
			organizations : {}
		} ;
		$.each(myContacts.people, function(key, value){
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


