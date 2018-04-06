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

<div class="portfolio-modal modal fade" id="modal-invite" tabindex="-1" role="dialog" aria-hidden="true">
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
						<i class="fa fa-plus-circle"></i> 
						<span id="title-invite">
							<?php
								if($parentType == Person::COLLECTION)
									echo Yii::t("invite","Search or invite your contacts");
								else
									echo Yii::t("invite","Invite members");
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
									<?php echo Yii::t("invite","Search"); ?> 
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
						<li role="presentation">
							<a href="javascript:" class="" id="menuWriteMails">
								<div id="titleWriteMails" class='radius-10 padding-10 text-grey text-dark'>
									<i class="fa fa-pencil-square-o fa-2x"></i> 
									<?php echo Yii::t("invite","Write"); ?>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="row " id="divSearchInvite">
				<div id="step1" class="modal-body col-xs-6" >
					<div class="form-group">
						<input type="text" class="form-control text-left" placeholder="Un nom, un e-mail ..." autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">
						<div class="col-xs-12" id="dropdown-search-invite" style="max-height: 400px; overflow: auto;"></div>
						<div class="col-xs-12" id="form-invite" style="padding:5px">
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
										<textarea class="invite-text form-control" id="inviteText" name="inviteText" rows="4" placeholder="Message personnaliser"></textarea>
									</div>
								</div>

							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								<hr>
								<button class="btn btn-primary" id="btnInviteNew" ><i class="fa fa-add"></i> Ajouter à la liste</button>
							</div>
						</div>
					</div>
				</div>
				<div id="step2" class="modal-body col-xs-6" >
					<div class="form-group">
						<div class="col-xs-12">
							<h4> Liste des personnes a invités</h4>
							<div class="col-xs-12" id="dropdown-invite" style="max-height: 400px; overflow: auto;"></div>
						</div>
						<div class="col-xs-12" style="margin-top: 10px;">
							<button id="btnValider" >
								<i class="fa fa-check"> </i>Valider 
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="divResult">
				<div id="stepResult" class="modal-body col-xs-12" >
					<div class="form-group">
						<div class="col-xs-12">
							<h4> Résultat </h4>
							<ul class="dropdown-menu col-xs-10" id="dropdown-result" style="">
								<li class="li-dropdown-scope"></li>
							</ul>
						</div>
						<div class="col-xs-12" style="margin-top: 10px;">
							<button id="btnValider" >
								<i class="fa fa-check"> </i>Valider 
							</button>
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
	var members = <?php echo json_encode( $members ); ?>;
	var rolesList=[ tradCategory.financier, tradCategory.partner, tradCategory.sponsor, tradCategory.organizor, tradCategory.president, tradCategory.director, tradCategory.speaker, tradCategory.intervener];
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
		mylog.log("members", members);
		bindInvite();

		$("#step2").hide();
		$("#form-invite").hide();
		$("#divResult").hide();

	});

	function bindInvite(){
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

			var mail = $('#modal-invite #inviteEmail').val();
			var msg = $('#modal-invite #inviteText').val();
			var name = $('#modal-invite #inviteName').val();

			if(typeof listInvite.invites[mail] == "undefined"){
				listInvite.invites[mail] = {
					name : name,
					msg : msg
				} ;
				$('#modal-invite #inviteEmail').val("");
				$('#modal-invite #inviteText').val("");
				$('#modal-invite #inviteName').val("");
				$("#modal-invite #form-invite").hide();
			}else{
				toastr.error("Deja la ma gueule");
			}

			showElementInvite(listInvite, true);
			bindRemove();
		});

		$('#modal-invite #btnValider').click(function(e){
			mylog.log("#modal-invite #btnValider", Object.keys(listInvite.organizations).length, Object.keys(listInvite.citoyens).length);
			if( Object.keys(listInvite.organizations).length > 0 || 
				Object.keys(listInvite.citoyens).length > 0 || 
				Object.keys(listInvite.invites).length > 0 ) {
				mylog.log("#modal-invite #btnValider here");

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
						$.each(data, function(key, value){
							mylog.log("contactsList.invites key, value", key, value);
							if(value.result == true){
								str += "<li class='li-dropdown-scope'>";
									str +="<div class='btn-scroll-type' >";
										str += '<span class="text-dark text-bold">' + value.parent.name + ' : </span>';
										str += '<span class="text-dark text-bold">' + value.msg + '</span>';
									str += "</div>";
								str += "</li>";
							}else{
								str += "<li class='li-dropdown-scope'>";
									str +="<div class='btn-scroll-type' >";
										str += '<span class="text-dark text-bold">' + value.parent.name + ' : </span>';
										str += '<span class="text-dark text-bold">' + value.msg + '</span>';
									str += "</div>";
								str += "</li>";
							}
						});

						$("#modal-invite #dropdown-result").html(str);
						$("#divSearchInvite").hide();
						$("#divResult").show();
						$("#modal-invite #dropdown-result").show();
						
				 	}
				});
				
			}
		});
	}

	function showListInvite(){
		if(Object.keys(listInvite.organizations).length > 0 || Object.keys(listInvite.citoyens).length > 0|| Object.keys(listInvite.invites).length > 0 ){
			$("#step2").show();
		}else{
			$("#step2").hide();
		}
	}

	function bindAdd(){
		$('#modal-invite .add-invite').click(function(e){
			var id = $(this).data("id");
			var type = $(this).data("type");
			var name = $(this).data("name");
			var profilThumbImageUrl = $(this).data("profilThumbImageUrl");

			if(type == "citoyens"){
				if(typeof listInvite.citoyens[id] == "undefined"){
					listInvite.citoyens[id] = { 
						name : name,
						profilThumbImageUrl : profilThumbImageUrl
					} ;
				}else{
					toastr.error("Deja la ma gueule");
				}
			}else if(type == "organizations"){
				if(typeof listInvite.organizations[id] == "undefined"){
					listInvite.organizations[id] = { 
						name : name,
						profilThumbImageUrl : profilThumbImageUrl
					} ;
				}else{
					toastr.error("Deja la ma gueule");
				}
			}

			showElementInvite(listInvite, true);
			bindRemove();
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

	function showElementInvite(contactsList, invite=false){
		mylog.log("showElementInvite", contactsList, invite);
		mylog.log("showElementInvite length", Object.keys(contactsList.citoyens).length);
		var dropdown = "#dropdown-search-invite";
		var listNotExits = true;
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
				str += htmlListInvite(key, value, invite, "citoyens");
			});

			listNotExits = false;
		}

		if(notNull(contactsList.invites) && Object.keys(contactsList.invites).length ){
			$.each(contactsList.invites, function(key, value){
				mylog.log("contactsList.invites key, value", key, value);
				str += htmlListInvite(key, value, invite, "citoyens");
			});
			listNotExits = false;
		}

		if(notNull(contactsList.organizations) && Object.keys(contactsList.organizations).length ){
			str += '<div class="col-xs-12">'+
						'<h5 class="padding-10 text-'+contactTypes.organizations.color+'"><i class="fa fa-'+contactTypes.organizations.icon+'"></i> '+contactTypes.organizations.label+'<hr></h5>'+			
					'</div>';
			$.each(contactsList.organizations, function(key, value){
				mylog.log("contactsList.organizations key, value", key, value);
				str += htmlListInvite(key, value, invite, "organizations");
			});
			listNotExits = false;
		}

		mylog.log("showElementInvite", dropdown);
		$("#modal-invite "+dropdown).html(str);
		$("#modal-invite "+dropdown).show();

		if(listNotExits)
			newInvitation();
		else
			$("#modal-invite #form-invite").hide();

		showListInvite();
	}

	function htmlListInvite(id, elem, invite, type){
		//( typeof elem.id != "undefined" ? elem.id : elem.email )
		mylog.log("htmlListInvite", elem, invite);
		var profilThumbImageUrl = (typeof elem.profilThumbImageUrl != "undefined" && elem.profilThumbImageUrl != "") ? baseUrl+'/'+ elem.profilThumbImageUrl : assetPath + "/images/news/profile_default_l.png";
		var str = "<div class='col-xs-12'>";
			var classStr = " ";
			if(invite == true){
				str+='<button class="btn btn-link text-red tooltips col-xs-2 remove-invite" '+
						'id="'+id+'Remove" '+
						'name="'+id+'Remove" '+
						'data-toggle="tooltip" data-placement="top" '+
						'data-type="citoyens" ' +
						'data-id="'+id+'" ' + 
						'data-toggle="tooltip" data-placement="top" title="Remove" >'+
						'<i class="fa fa-remove"></i>'+
						'</button>';
			}else{
				classStr = " add-invite";
			}

			str +="<div class='btn-scroll-type "+classStr+"'"+
					" data-id='"+id+"' "+
					'id="'+id+'AddList" '+
					'name="'+id+'AddList"'+
					" data-name='"+elem.name+"' "+
					" data-profilThumbImageUrl='"+profilThumbImageUrl+"' "+
					" data-type='"+type+"' >";
				str += '<img src="'+ profilThumbImageUrl+'" class="thumb-send-to" height="35" width="35"> ';
				str += '<span class="text-dark text-bold">' + elem.name + '</span>';
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
			$("#modal-invite #inviteName").val("");
		}else{
			$("#modal-invite #inviteName").val($("#modal-invite #inviteSearch").val());
			$("#modal-invite #inviteEmail").val("");
		}

		$("#modal-invite #inviteText").val();
	}

</script>