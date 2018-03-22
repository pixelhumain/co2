<style>

#modal-invite .dropdown-menu{
	top:65%;
	left : 15px;

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
                        				echo Yii::t("invite","Search or invite members");
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
					<hr>
				</div>
			</div>
            <div class="row links-create-element">
                <div class="col-xs-6">
                    <div id="" class="modal-body">
                    	<div class="col-xs-12" id="step1">
							<div class="form-group">
								<input type="text" class="form-control text-left" placeholder="Un nom, un e-mail ..." autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">
								<ul class="dropdown-menu col-md-10" id="dropdown_searchInvite" style="">
									<li class="li-dropdown-scope"></li>
								</ul>
							</div>
						</div>
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
	//var parentType = "<?php echo $parentType; ?>";
	var members = <?php echo json_encode( $members ); ?>;
	var rolesList=[ tradCategory.financier, tradCategory.partner, tradCategory.sponsor, tradCategory.organizor, tradCategory.president, tradCategory.director, tradCategory.speaker, tradCategory.intervener];
	var contactTypes = [{ name : "people", color: "yellow", icon:"user", label:"People" }];
	var isElementAdmin= "<?php echo Authorisation::isElementAdmin($parentId, $parentType, @Yii::app()->session["userId"]) ?>";

	jQuery(document).ready(function() {
		mylog.log("members", members);
		bindInvite();

	});


	function bindInvite(){
		$('#modal-invite #inviteSearch').keyup(function(e){
			var search = $('#modal-invite #inviteSearch').val();
			mylog.log("#modal-invite #inviteSearch", search);
			if(search.length>2){
				clearTimeout(timeout);
				timeout = setTimeout('autoCompleteInvite("'+encodeURI(search)+'")', 500); 
			}else{
				$("#modal-invite #dropdown_searchInvite").css({"display" : "none" });	
			}
		});
	}


	function autoCompleteInvite(search){
		mylog.log("autoCompleteInvite", search);
		if (search.length < 3) { return }
		tabObject = [];

		var data = { 
			"search" : search,
			"searchMode" : "personOnly"
		};
		mylog.log("url", baseUrl+'/'+moduleId+"/search/searchmemberautocomplete");


		$.ajax({
			type: "POST",
		    url: baseUrl+'/'+moduleId+"/search/searchmemberautocomplete",
		    data: data,
		    dataType: "json",
		    success: function(data){
		    	mylog.log("autoCompleteInvite success", data);
		  //   	listContact = {"people" : data.citoyens, "organizations" : data.organizations};
    //     		var addLinkDynForm = {
				// 	"values" : listContact,
			 //        "contactTypes" : contactTypes
				// };

		    	showElementInvite(data);
		  //   	var str = "<li class='li-dropdown-scope'><a href='javascript:;' onclick='newInvitation()'>Pas trouvé ? Lancer une invitation à rejoindre votre réseau !</li>";
				// var compt = 0;
				// var city, postalCode = "";
				// $.each(data.citoyens, function(k, v) { 
				// 	city = "";
				// 	mylog.log(v);
				// 	postalCode = "";
				// 	var htmlIco ="<i class='fa fa-user fa-2x'></i>";
				// 	if(v.id != userId) {
				// 		tabObject.push(v);
				// 		mylog.log(v);
		 	// 			if(v.profilThumbImageUrl != ""){
		 	// 				htmlIco= "<img width='25' height='25' alt='image' class='img-circle' src='"+baseUrl+v.profilThumbImageUrl+"'/>"
		 	// 			}
		 	// 			if (v.address != null) {
		 	// 				city = v.address.addressLocality;
		 	// 				postalCode = v.address.postalCode;
		 	// 			}
		  // 				str += 	"<li class='li-dropdown-scope'>" +
		  // 						"<a href='javascript:;' onclick='setInviteInput("+compt+");'>"+htmlIco+" "+v.name ;

		  // 				if(typeof postalCode != "undefined")
		  // 					str += "<br/>"+postalCode+" "+city;
		  // 				str += "</a></li>";

		  // 				compt++;
	  	// 			}
				// });
				// $("#modal-invite #dropdown_searchInvite").html(str);
		 	// 	$("#modal-invite #dropdown_searchInvite").css({"display" : "inline" });
		 	}
		});



		// ajaxPost("", baseUrl+"/"+moduleId+"/search/searchmemberautocomplete", data,
		// 	function (data){
		// 		var str = "<li class='li-dropdown-scope'><a href='javascript:;' onclick='newInvitation()'>Pas trouvé ? Lancer une invitation à rejoindre votre réseau !</li>";
		// 		var compt = 0;
		// 		var city, postalCode = "";
		// 		$.each(data["citoyens"], function(k, v) { 
		// 			city = "";
		// 			mylog.log(v);
		// 			postalCode = "";
		// 			var htmlIco ="<i class='fa fa-user fa-2x'></i>"
		// 			if(v.id != userId) {
		// 				tabObject.push(v);
		// 				mylog.log(v);
		//  				if(v.profilThumbImageUrl != ""){
		//  					var htmlIco= "<img width='25' height='25' alt='image' class='img-circle' src='"+baseUrl+v.profilThumbImageUrl+"'/>"
		//  				}
		//  				if (v.address != null) {
		//  					city = v.address.addressLocality;
		//  					postalCode = v.address.postalCode;
		//  				}
		//   				str += 	"<li class='li-dropdown-scope'>" +
		//   						"<a href='javascript:;' onclick='setInviteInput("+compt+");'>"+htmlIco+" "+v.name ;

		//   				if(typeof postalCode != "undefined")
		//   					str += "<br/>"+postalCode+" "+city;
		//   				str += "</a></li>";

		//   				compt++;
	 //  				}
		// 		});
				
		// 		$("#modal-invite #dropdown_searchInvite").html(str);
		// 		$("#modal-invite #dropdown_searchInvite").css({"display" : "inline" });
		// 	}
		// );	
	}

function showElementInvite(contactsList){
	var str = "<li class='li-dropdown-scope'><a href='javascript:;' onclick='newInvitation()'>Pas trouvé ? Lancer une invitation à rejoindre votre réseau !</a></li>";

	if(notNull(contactsList.citoyens)){
		$.each(contactsList.citoyens, function(key, value){
			mylog.log("contactsList key, value", key, value);
			var profilThumbImageUrl = (typeof value.profilThumbImageUrl != "undefined" && value.profilThumbImageUrl != "") ? baseUrl+'/'+ value.profilThumbImageUrl : assetPath + "/images/news/profile_default_l.png";


			str += "<li class='li-dropdown-scope'>";
				str +="<div class='btn-scroll-type add-name-contact' id='"+key+"' >";
					str += '<img src="'+ profilThumbImageUrl+'" class="thumb-send-to" height="35" width="35">';
					str += '<span class="text-dark text-bold">' + value.name + '</span>';
				str += "</div>";
			str += "</li>";
		});
	}
	
	$("#modal-invite #dropdown_searchInvite").html(str);
	$("#modal-invite #dropdown_searchInvite").css({"display" : "inline" });
}


function showElementInviteOld(fieldObj){
	mylog.log("showElementInvite", fieldObj);
    
	var contacts = (notNull(fieldObj.values) ? fieldObj.values : new Array() );
	fieldObj.values = contacts;
    var fieldHTML = "";
   
	$.each(fieldObj.contactTypes, function(key, type){

		mylog.log("fieldObj.contactTypes", key, type, typeof type);
		fieldHTML += '<div class="panel panel-default" id="scroll-type-'+type.name+'">  '+
						'<div class="panel-heading">'+
							'<h4 class="text-'+type.color+'"><i class="fa fa-'+type.icon+'"></i> '+trad[type.label]+'</h4>'+
						'</div>'+
						'<div class="panel-body no-padding">'+
							'<div class="list-group padding-5">'+
								'<ul>';
								if(typeof fieldObj.values[type.name] != "undefined")
									$.each(fieldObj.values[type.name], function(key2, value){
										mylog.log("TESTTEST", key2, value);
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
												fieldHTML += '<li>';
												if (type.name == "people") {
													fieldHTML += '<small id="isAdmin'+getObjectId(value)+'" class="btn-is-admin pull-right text-grey margin-top-10" data-id="'+thisKey+'">'+
																	'<a href="javascript:">admin <i class="fa fa-user-secret"></i></a>'+
																'</small>';
												}
												fieldHTML += '<div class="btn btn-default btn-scroll-type btn-select-contact" id="contact'+getObjectId(value)+'">' +
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
	$("#modal-invite #dropdown_searchInvite").html(fieldHTML);
	$("#modal-invite #dropdown_searchInvite").css({"display" : "inline" });
	//bindEventScopeContactsModal();
}


</script>