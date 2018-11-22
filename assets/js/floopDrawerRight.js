/*
	Pour info, depuis qu'on utilise le nouveau design Tango
	on utilise aussi le floopDrawerRight.js
	floopDrawer.js n'est plus utilisé
*/

//liste des types à afficher avec leurs icons
var floopContactTypes = [	{ name : "projects", 		color: "purple"	, icon:"lightbulb-o"	},
							{ name : "events", 			color: "orange"	, icon:"calendar"		},
							{ name : "citoyens",  		color: "yellow"	, icon:"user"			},
							{ name : "organizations", 	color: "green" 	, icon:"group"			}];
							
var openPanelType = { 	"citoyens" 		 : "citoyens",
						"organizations"  : "organizations",
						"projects" 	 	 : "projects",
						"events" 		 : "events",
					};

var tooltips_lbl = { 	"citoyens" 		  : "Ajouter quelqu'un à votre répertoire.",
						"organizations"   : "Créer une nouvelle organisation",
						"projects" 	 	  : "Créer un nouveau projet",
						"projectsHistory" : trad.showhideoldprojects,
						"events" 		  : "Créer un nouvel événement",
						"eventsHistory"   : trad.showhideoldevents,
					};

var floopTypeUsed = new Array();
var floopShowLock = false;
var timeoutShowFloopDrawer = false;

var floopContacts;

function getFloopContacts(){ return floopContacts; }

function buildListContactHtml(contacts, myId){

	floopContacts = contacts;
	
	var HTML = 			'<div class="floopHeader bg-white">'+
							//'<a href="#person.directory.id.'+userId+'?tpl=directory2" '+
							//	'class="text-white pull-left lbh" style="color:white !important;">'+
								//t("My directory")+
								'<i class="fa fa-link pull-left text-dark" style="margin-right:15px;margin-top:4px;"></i> '+
							//'</a>'+
							'<div id="floopScrollByType" class="pull-left"></div>' +
							'<button id="btnFloopClose"><i class="fa fa-times"></i></button>' +
							
						'</div>';
						HTML += '<i class="fa fa-search" style="padding:15px 0px 15px 11px;"></i><input type="text" id="search-contact" class="form-control" placeholder="'+trad.searchnamepostalcity+'">';
		HTML += 		'<div class="floopScroll">' ;
							
						$.each(floopContactTypes, function(key, type){

							var n=0;
							//compte le nombre d'élément à afficher
							$.each(contacts[type.name], function(key2, value){ n++; });
							//si aucun élément, on affiche pas cette section
							//if(n > 0){
							var urlBtnAdd = "";
							if(type.name == "citoyens") 		 urlBtnAdd = "dyFObj.openForm( 'person')";
							if(type.name == "organizations") urlBtnAdd = "dyFObj.openForm( 'organization')";
							if(type.name == "events") 		 urlBtnAdd = "dyFObj.openForm( 'event')";
							if(type.name == "projects") 	 urlBtnAdd = "dyFObj.openForm( 'project')";

							floopTypeUsed.push(type);

		HTML += 			'<div class="panel panel-default" id="scroll-type-'+type.name+'">  '+	
								'<div class="panel-heading">';
		HTML += 					'<h4 class="text-'+type.color+'">'+
										//'<button onclick="'+urlBtnAdd+'" class="tooltips btn btn-default btn-sm pull-right btn_shortcut_add bg-'+type.color+'" data-placement="left" data-original-title="'+tooltips_lbl[type.name]+'">'+
										//	'<i class="fa fa-search"></i>'+
										//'</button>' +		
										'<i class="fa fa-'+type.icon+'"></i> <span class="">'+trad['my'+type.name]+"</span>";
										if(myId != ""){
		//HTML += 						'<button onclick="'+urlBtnAdd+'" class="tooltips btn btn-default btn-sm pull-right btn_shortcut_add text-'+type.color+'" data-placement="left" data-original-title="'+tooltips_lbl[type.name]+'">'+
		//									'<i class="fa fa-plus"></i>'+
		//								'</button>';
											if (type.name == "events" || type.name == "projects") {
		HTML += 						'<button onclick="showHideOldElements(\''+type.name+'\')" class="tooltips btn btn-default btn-sm pull-right btn_shortcut_add text-'+type.color+'" data-placement="left" data-original-title="'+tooltips_lbl[type.name+'History']+'">'+
											'<i class="fa fa-history"></i>'+
										'</button>';		
											}
										}
		HTML += 					'</h4>'+
								'</div>'+
								'<div class="panel-body no-padding">'+
									'<div class="list-group no-padding">'+
										'<ul id="floopType-'+type.name+'">';
										if($(contacts[type.name]).size() == 0){
		HTML += 							'<label class="no-element"><i class="fa fa-angle-right"></i> Aucun élément</label>';									
										}
										$.each(contacts[type.name], function(key2, value){ 
		HTML += 							getFloopItem(key2, type, value);
										});									
		HTML += 						'</ul>' +	
									'</div>'+	
								'</div>'+
							'</div>';
						});									
		HTML += 		'</div>' +
						'</div>'+
					  '</div>' +
					  '</div>';
		
				

		return HTML;
}


//création HTML d'un élément
function getFloopItem(id, type, value){
	//mylog.log("getFloopItem" , id, type, value);
	var oldElement = isOldElement(value);

	var cp = (typeof value.address != "undefined" && notNull(value.address) && typeof value.address.postalCode != "undefined") ? value.address.postalCode : typeof value.cp != "undefined" ? value.cp : "";
	var city = (typeof value.address != "undefined" && notNull(value.address) && typeof value.address.addressLocality != "undefined") ? value.address.addressLocality : "";
	defaultImg=type.name;
	//if(defaultImg=="people")
	//	defaultImg="citoyens";
	var profilThumbImageUrl = (typeof value.profilThumbImageUrl != "undefined" && value.profilThumbImageUrl != "") ? baseUrl + value.profilThumbImageUrl : assetPath + "/images/thumb/default_"+defaultImg+".png";
	var id = (typeof value._id != "undefined" && typeof value._id.$id != "undefined") ? value._id.$id : id;
	var path = "#page.type."+openPanelType[type.name]+".id."+id;
	var elementClass = oldElement ? "oldFloopDrawer"+type.name : "";
	var elementStyle = oldElement ? "display:none" : ""; 

	var HTML = '<li style="'+elementStyle+'" class="'+elementClass+'" id="floopItem-'+type.name+'-'+id+'" idcontact="'+id+'">' +
					'<a href="'+path+'" class="btn btn-default btn-scroll-type btn-select-contact lbh elipsis contact'+id+'">' +
						'<div class="btn-chk-contact">' +
							'<img src="'+ profilThumbImageUrl+'" class="thumb-send-to bg-'+type.color+'" height="35" width="35">'+
							'<span class="info-contact">' +
								'<span class="name-contact text-dark text-bold" idcontact="'+id+'">' + value.name + '</span>'+
								'<br/>'+
								'<span class="cp-contact text-light pull-left" idcontact="'+id+'">' + cp + '&nbsp;</span>'+
								'<span class="city-contact text-light pull-left" idcontact="'+id+'">' + city + '</span>'+
							'</span>' +
						'</div>' +
					'</a>';
			
			chatName = value.name;
			chatSlug = (value.slug) ? value.slug : ""; 
			chatUsername = (value.username) ? value.username : "";	 

			chatColor = (value.hasRC) ? "text-red" : "";
			HTML += '<button class="btn btn-xs btn-default btn-open-chat pull-right '+chatColor+' contact'+id+'" '+
					'data-name-el="'+value.name+'" data-username="'+chatUsername+'" data-slug="'+chatSlug+'" data-type-el="'+type.name+'"  data-open="'+( (typeof value.preferences != "undefined" && value.preferences.isOpenEdition)?true:false )+'"  data-hasRC="'+( ( value.hasRC )?true:false)+'" data-id="'+id+'">'+
				'<i class="fa fa-comments"></i>'+
			'</button>';
			/*if( value.preferences.isOpenEdition == false )
				HTML += '<i class="fa fa-lock pull-right margin-top-20 margin-right-5 text-light tooltips" '+
							'data-position="left" data-original-title="value.preferences.isOpenEdition == false"></i>';*/
	return HTML+'</li>';
}

var translation = {
		"My people" 		: "Mes contacts",
		"My organizations" 	: "Mes organisations",
		"My projects" 		: "Mes projets",
		"My events" 		: "Mes événements",
		"My directory" 		: "Mon répertoire",
		"Search name, postal code, city ..." : "nom, code postal, ville ..."
}

function t(string){
	if(typeof translation[string] != "undefined"){
		return translation[string];
	}else { return string; }
}
function showFloopDrawer(show){ 
	if(show){
		if($(".floopDrawer" ).css("display") == "none"){
			$(".floopDrawer").stop().show();
			$(".floopDrawer" ).css("width", 0);
			$(".floopDrawer" ).animate( { width: 300 }, 300 );
		}
	}else{
		$(".floopDrawer").hide("fast");
	}
}
function getFloopContactTypes(type){
	var goodType = null;
	$.each(floopContactTypes, function(key, value){
		if(value.name == type) {
			goodType = value;
		}
	});
	return goodType;
}

function bindEventFloopDrawer(){
	
	$(".floopDrawer #search-contact").keyup(function(){
		filterFloopDrawer($(this).val());
	});

	//parcourt tous les types de contacts
	$.each(floopContactTypes, function(key, type){ 
		//initialise le scoll automatique de la liste de contact
		$(".floopHeader #btn-scroll-type-"+type.name).mouseover(function(){

			//var width = $(this).width();
	        //$("#floopDrawerDirectory").css({left:width});
	        //showFloopDrawer(true);
	        var scrollTOP = $('.floopScroll').scrollTop() - $('.floopScroll').position().top +
							$(".floopScroll #scroll-type-"+type.name).position().top;
			$('.floopScroll').scrollTop(scrollTOP);
		});
	});

    $("#ajaxSV,#menu-top-container").mouseenter(function() { 
      if(!floopShowLock)
			showFloopDrawer(false);
    });
    $(".floopDrawer, .floopDrawer #search-contact").mouseover(function() {
      showFloopDrawer(true);
    });
    $(".menuIcon.no-floop-item, .box-add, .blockUI, .mapCanvas").mouseover(function() {
      	if(!floopShowLock)
			showFloopDrawer(false);
    });

    $(".btn-open-chat").click(function(){
    	var nameElo = $(this).data("name-el");
    	var idEl = $(this).data("id");
    	var usernameEl = $(this).data("username");
    	var slugEl = $(this).data("slug");
    	var typeEl = dyFInputs.get($(this).data("type-el")).col;
    	var openEl = $(this).data("open");
    	var hasRCEl = ( $(this).data("hasRC") ) ? true : false;
    	//alert(nameElo +" | "+typeEl +" | "+openEl +" | "+hasRCEl);
    	var ctxData = {
    		name : nameElo,
    		type : typeEl,
    		id : idEl
    	}
    	if(typeEl == "citoyens")
    		ctxData.username = usernameEl;
    	else if(slugEl)
    		ctxData.slug = slugEl;
    	rcObj.loadChat(nameElo ,typeEl ,openEl ,hasRCEl, ctxData );
    });

}

function initFloopScrollByType(){
	var HTML = "";
	$.each(floopTypeUsed, function(key, value){ 
		var type = value.name; //openPanelType[value.name];
		HTML += "<a href='javascript:' id='btn-scroll-type-"+type+"' class='bg-"+value.color+" btn-scroll-type'><i class='fa fa-"+value.icon+"'></i></button>";
	});
	$("#floopScrollByType").html(HTML);
}

//recherche text par nom, cp et city
function filterFloopDrawer(searchVal){
	console.log("filterFloopDrawer(searchVal)", searchVal);
	//masque/affiche tous les contacts présents dans la liste
	if(searchVal != "")	$(".floopDrawer .btn-select-contact, .floopDrawer .btn-open-chat").hide();
	else				$(".floopDrawer .btn-select-contact, .floopDrawer .btn-open-chat").show();
	//recherche la valeur recherché dans les 3 champs "name", "cp", et "city"
	$.each($(".floopDrawer .name-contact"), function() { checkFloopSearch($(this), searchVal); });
	$.each($(".floopDrawer .cp-contact"),   function() { checkFloopSearch($(this), searchVal); });
	$.each($(".floopDrawer .city-contact"), function() { checkFloopSearch($(this), searchVal); });
}

//si l'élément contient la searchVal, on l'affiche
function checkFloopSearch(thisElement, searchVal, type){
	var content = thisElement.html();
	var found = content.search(new RegExp(searchVal, "i"));
	if(found >= 0){
		var id = thisElement.attr("idcontact");
		//console.log("$('.floopDrawer .contact"+id+"').show()");
		$(".floopDrawer .contact"+id).show();
	}
}

//ajout d'un élément dans la liste
function addFloopEntity(entityId, entityType, entityValue){
	mylog.log("addFloopEntity", entityId, entityType, entityValue);
	//Exception with citoyens collection which is managed like people in display
	//if(entityType == "citoyens") entityType = "people";

	floopContacts[entityType][entityId]=entityValue;

	var type = getFloopContactTypes(entityType);

	//We check if the element is already displayed
	if($('#floopItem-'+type.name+'-'+entityId).length < 1){
		var html = getFloopItem(entityId, type, entityValue);
		$("ul#floopType-"+entityType).prepend(html);
	}
	
	$("ul#floopType-"+entityType+" .no-element").hide();
	floopShowLock = true;
    showFloopDrawer(true);

    setTimeout(function(){
    	if ($('.floopScroll').position().top != null ) {
			var scrollTOP = $('.floopScroll').scrollTop() - $('.floopScroll').position().top +
							$(".floopScroll #scroll-type-"+entityType).position().top;
			$('.floopScroll').scrollTop(scrollTOP);
		}
	}, 1000);

	timeoutShowFloopDrawer = setTimeout(function(){
		floopShowLock = false;
		showFloopDrawer(false);
		clearTimeout(timeoutShowFloopDrawer);
	}, 4000);
	//toastr.success("ajout de l'element floop ok");
}

//ajout d'un élément dans la liste
function removeFloopEntity(entityId, entityType){
	//if(entityType == "citoyens") entityType = "people";
	type = getFloopContactTypes(entityType);
	removeFromMyContacts(entityId, entityType);
	$('#floopItem-'+type.name+'-'+entityId).remove();
}
//ajout d'un élément dans la liste
function changeNameFloopEntity(entityId, entityType, entityName){
	//if(entityType == "citoyens") entityType = "people";
	type = getFloopContactTypes(entityType);
	//removeFromMyContacts(entityId, entityType);
	$('#floopItem-'+type.name+'-'+entityId).find(".name-contact").text(entityName);
}
function removeFromMyContacts(entityId, entityType){
	if(typeof floopContacts[entityType][entityId] != "undefined")
		delete floopContacts[entityType][entityId];
}
function showHideOldElements(type) {
	$(".oldFloopDrawer"+type).toggle("slow");
}

// Return true if the endDate of the Element is before the current Date. 
function isOldElement(value) {
	//mylog.log("isOldElement", value);
	var endDate = (typeof value["endDate"] != undefined) ? value["endDate"] : "";
	if (endDate == "") return false;
	return new Date(endDate) < new Date();
}
