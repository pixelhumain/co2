<style>
	#panel-first-step{
		text-align: center;
		margin-top:20px;
	}
	#panel-first-step button{
		margin-bottom:5px;
	}

	#ajax-modal .modal-content,
	#formContact .modal-content{
		background-color: rgba(0,0,0,0.6);
	}
	
	#ajax-modal .container,
	#formContact .container{
		background-color: white;
		border-radius: 4px;
	}

	#ajax-modal.portfolio-modal,
	#formContact.portfolio-modal {
		background-color: transparent;
	}

	#ajax-modal .close-modal .lr,
	#ajax-modal .close-modal .rl,
	#formContact .close-modal .lr,
	#formContact .close-modal .rl{
		background-color: white;
	}

	.dropdown_searchListNW{
		min-height: 100%;
	}


</style>

<div class="col-md-12 no-padding" id="repertory" >
	<div id="dropdown_search" class="col-md-12 container list-group-item dropdown_searchListNW"></div>
</div>
<div class="col-md-12 padding-10" id="ficheInfoDetail"></div>

<script type="text/javascript">
//Icons by default categories
var linksTagImages = new Object();
var contextMapNetwork = [];
var allElement = new Array();
var allTags = new Object();
var allTypes = new Object();
var indexStepInit = 100;
var searchPrefTag = null ;
var indexStep = indexStepInit;
var currentIndexMin = 0;
var currentIndexMax = indexStep;
var scrollEnd = false;
var totalData = 0;
var timeout = null;

var tagsActived = {};
var disableActived = false;
var citiesActived = [] ;
var typesActived = [] ;
var rolesActived = [] ;
var searchValNetwork = "";

var loadingData = false;
var mapElements = new Array();
var tagsFilter = new Array();
var mix = "";

var topMenuActivated = true;

var nwVar = {
	mainTag : [],
	sourceKey : [],
	searchType : [],
	searchTag : [],
	searchCategory : [],
	searchLocalityNAME : [],
	searchLocalityCODE_POSTAL_INSEE : [],
	searchLocalityDEPARTEMENT : [],
	searchLocalityINSEE : [],
	searchLocalityREGION : [],

	allmainTag : [],
	allsourceKey : [],
	allsearchType : [],
	allsearchTag : [],
	allsearchCategory : [],
	allsearchLocalityNAME : [],
	allsearchLocalityCODE_POSTAL_INSEE : [],
	allsearchLocalityDEPARTEMENT : [],
	allsearchLocalityINSEE : [],
	allsearchLocalityREGION : [],
}

jQuery(document).ready(function() {

	initVar();
	bindLBHLinks();
	addTooltips();
	bindNetwork();

	if(location.hash == "" || location.hash == "#network.simplydirectory")
		showMapNetwork(true);
	else
		showMapNetwork(false);

	$(".main-menu-left.inSig").hide();
	$("#right_tool_map").removeClass("hidden-sm").hide( 700 );

	topMenuActivated = true;
	hideScrollTop = true;
	checkScroll();
	var timeoutSearch = setTimeout(function(){ }, 100);

	setTimeout(function(){ $("#input-communexion").hide(300); }, 300);
	$(".moduleLabel").html("<i class='fa fa-connectdevelop'></i> <span id='main-title-menu'>Cartographie des Tiers-Lieux </span> <span class='text-red'>MEL</span>");
	$('.tooltips').tooltip();
	
	mylog.log("indexStepInit", indexStepInit);
	startSearchSimply(0, indexStepInit);
});

function initVar(){
	searchPrefTag = ( typeof networkJson.request.searchPrefTag != "undefined" ?  networkJson.request.searchPrefTag : null ) ;

	if( typeof networkJson.request.pagination != "undefined" && networkJson.request.pagination > 0)
		indexStepInit = networkJson.request.pagination ;

  	if(typeof networkJson.filter != "undefined" && typeof networkJson.filter.linksTag != "undefined"){
   		$.each(networkJson.filter.linksTag, function(index, value){ 
   			if(typeof value != "undefined"){
   				linksTagImages[value] = {};
   			}
   		});
   	}

   	citiesActived = ( ((typeof networkJson.request.searchLocalityNAME == "undefined") || networkJson == null) ? [] : networkJson.request.searchLocalityNAME);

   	indexStep = indexStepInit;
   	var allSearchParams = ["mainTag", "sourceKey", "searchType", "searchTag","searchCategory","searchLocalityNAME","searchLocalityCODE_POSTAL_INSEE","searchLocalityDEPARTEMENT","searchLocalityINSEE","searchLocalityREGION"];
   	$.each(allSearchParams,function(k,v){
   		mylog.log("allSearchParams" );
		nwVar[v] = ( ( typeof networkJson.request[v] != "undefined" && $.isArray(networkJson.request[v]) ) ? networkJson.request[v] : [] );
		nwVar["all"+v] = ( ( typeof networkJson.request[v] != "undefined" && $.isArray(networkJson.request[v]) ) ? networkJson.request[v] : [] );
	});


	var btnSearch = '<div class="btn-group btn-group-lg tooltips" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Recherche par nom">'+
					'<button type="button" class="btn btn-map " id="btn-search">'+
					'<i class="fa fa-chevron-left"></i></button>'+
				'</div>';
	$("#btn-back").parent().replaceWith(btnSearch);

	$("#mapLegende").addClass("hidden");
}


function addTooltips(){
	mylog.log("addTooltips");
	if(typeof networkJson.skin != "undefined" && typeof networkJson.skin.tooltips != "undefined"){
		$.each(networkJson.skin.tooltips,function(k,v){
			mylog.log("addTooltips", k,v);
			$( k ).addClass("tooltips");
			$( k ).data( "toggle", "tooltip" );
			$( k ).data( "placement", "bottom" );
			$( k ).attr( "title", v );
		});
	}
}


function bindNetwork(){
	mylog.log("bindNetwork");
	$('#btn-toogle-map').click(function(e){ showMapNetwork(); });
	
	$('.reset').on('click', function() {
		mylog.log(".reset");
		$('.tagFilter').removeClass('active');
		$(".tagFilter").removeAttr("checked");
		$('.villeFilter').removeClass('active');
		$('.villeFilter').removeAttr("checked");
		$('.categoryFilter').removeClass('active');
		$('.categoryFilter').removeAttr("checked");
		$('#input_name_filter').val('');
		tagsActived = {};
		disableActived = false;
		citiesActived = ( ((typeof networkJson.request.searchLocalityNAME == "undefined") || networkJson == null) ? [] : networkJson.request.searchLocalityNAME);
		typesActived = [] ;
		rolesActived = [] ;
		searchValNetwork = "";
		chargement();
	});


	$("#btn-search").click(function(){
		mylog.log("#btn-search", $("#right_tool_map").is(":visible"));
		if(!$("#right_tool_map").is(":visible")){
			$("#right_tool_map").show( 700 );
			$("#btn-search").find("i").removeClass("fa-chevron-left").addClass("fa-chevron-right");
		}else {
			$("#right_tool_map").hide( 700 );
			$("#btn-search").find("i").removeClass("fa-chevron-right").addClass("fa-chevron-left");
		}
			
	});

	$('#btn-menu-launch').click(function(){
		mylog.log("#btn-menu-launch", $(this).hasClass("active"));
		if(!$(this).hasClass("active")){
			$(this).addClass("active");
			$(".main-menu-left").show();
			$(this).find("span").show();
			$(this).find(".firstIcon").removeClass("fa-filter").addClass("fa-angle-left");
		}else{
			$(this).removeClass("active");
			$(this).find("span").hide();
			$(".main-menu-left").hide();
			$(this).find(".firstIcon").removeClass("fa-angle-left").addClass("fa-filter");
		}
	});
	
	$(".showHideMoreTitleMap").click(function(){
		mylog.log(".showHideMoreTitleMap");
		if($(this).find("i").hasClass("fa-angle-down")){
			$(".contentShortInformationMap").show("slow");
			$(".contentTitleMap").addClass("active");	
			$(this).addClass("active");
			$(this).find("i").removeClass("fa-angle-down").addClass("fa-angle-up");
		}else{
			$(this).removeClass("active");
			$(this).find("i").removeClass("fa-angle-up").addClass("fa-angle-down");
			$(".contentShortInformationMap").hide("slow");
			$(".contentTitleMap").removeClass("active");	
		}
		
	});


	if( typeof networkJson.mode == "undefined" || networkJson.mode != "client"){ 
		$('#searchBarText').keyup(function(e){
			clearTimeout(timeoutSearch);
			timeoutSearch = setTimeout(function(){ startSearchSimply(0, indexStepInit); }, 800);
		});
	} 
	
	/***** CHANGE THE VIEW PARAMS  *****/
	// $('#dropdown_params').show();
	
	$('#dropdown_paramsBtn').click(function(event){
		mylog.log("#dropdown_paramsBtn");
		event.preventDefault();
		if($('#dropdown_paramsBtn').hasClass('active')){
			$('#dropdown_params').fadeOut();
			$('#dropdown_params').removeClass('col-md-3');
			$('#dropdown_search').removeClass('col-md-9');
			$('#dropdown_search').addClass('col-md-12');
			$('#dropdown_paramsBtn').removeClass('active');
		}
		else{
			$('#dropdown_params').addClass('col-md-3');
			$('#dropdown_params').fadeIn();
			$('#dropdown_search').addClass('col-md-9');
			$('#dropdown_search').removeClass('col-md-12');
			$('#dropdown_paramsBtn').addClass('active');
		}
	});

	/***** CHANGE THE VIEW GRID OR LIST *****/
	$('#grid').hide();
	$('#list').click(function(event){
		mylog.log("#list");
		event.preventDefault();
		$('#dropdown_search .item').addClass('list-group-item');
		$('.entityTop').removeClass('row');
		$('.entityMiddle').removeClass('row');
		$('.entityBottom').removeClass('row');
		$('.entityTop').addClass('col-md-2');
		$('.entityMiddle').addClass('col-md-12');
		$('.entityBottom').addClass('col-md-4');
		$('#grid').show();
		$('#list').hide();
	});

	$('#grid').click(function(event){
		mylog.log("#grid");
		event.preventDefault();
		$('#dropdown_search .item').removeClass('list-group-item');
		$('#dropdown_search .item').addClass('grid-group-item');
		$('.entityTop').addClass('row');
		$('.entityMiddle').addClass('row');
		$('.entityBottom').addClass('row');
		$('.entityTop').removeClass('col-md-2');
		$('.entityMiddle').removeClass('col-md-12');
		$('.entityBottom').removeClass('col-md-4');
		$('#list').show();
		$('#grid').hide();
	});
}

function showMapNetwork(show){
	mylog.log("showMapNetwork", show, isMapEnd);
	mylog.log("typeof SIG : ", typeof Sig);

	if(typeof Sig == "undefined") show = false;

	if( typeof show == "undefined") 
		show = !isMapEnd;
	mylog.log("show", show);
	if(show){
		isMapEnd =true;
		showNotif(false);

		$("#mapLegende").html("");
		$("#mapLegende").hide();

		showMenuNetwork(true);
		if(Sig.currentMarkerPopupOpen != null){
			Sig.currentMarkerPopupOpen.fire('click');
		}

		$(".btn-group-map").show( 700 );
		$(".main-bottom-menu").show( 700 );
		$(".btn-menu5, .btn-menu-add").hide();
		$("#btn-toogle-map").css("display","inline !important");
		$("#btn-toogle-map").show();
		$(".my-main-container").animate({
			top: -1000,
			opacity:0,
		}, 'slow' );

		setTimeout(function(){ 
			$(".my-main-container").hide();
		}, 1000);
		var timer = setTimeout("Sig.constructUI()", 1000);

	}else{
		isMapEnd =false;
		hideMapLegende();
		$(".btn-group-map").hide( 700 );
		$(".main-bottom-menu").hide( 700 );
		$("#dropdown_params").show( 700 );
		showMenuNetwork(false);
		$(".btn-menu5, .btn-menu-add").show();
		$(".panel_map").hide(1);
		$(".main-col-search").animate({ top: 0, opacity:1 }, 800 );
		$(".my-main-container").animate({
			top: 50,
			opacity:1
		}, 'slow' );

		setTimeout(function(){ 
			$(".my-main-container").show();
			if( !$('.main-menu-left').is(":visible") && location.hash.indexOf("#page") == -1 )
				$(".main-menu-left").show( 700 );
		}, 100);

		if(typeof Sig != "undefined" && Sig.currentMarkerPopupOpen != null){
			Sig.currentMarkerPopupOpen.closePopup();
		}

		if($(".box-add").css("display") == "none" && <?php echo isset(Yii::app()->session['userId']) ? "true" : "false"; ?>)
			$("#ajaxSV").show( 700 );

		checkScroll();
	}
}

function showMenuNetwork(show){ 
	mylog.log("showMenuNetwork", show);
	if(typeof show == "undefined") 
		show = $("#main-top-menu").css("opacity") == 1;
	
	if(show){
		$("#titleMapTop").show( 700 );
		$("#btn-menu-launch").show( 700 );
		$("#btn-toogle-map").html("<i class='fa fa-list'></i>");
		$("#btn-toogle-map").attr("data-original-title", "Annuaire");
		$("#btn-toogle-map").attr("title", "Annuaire");
		$(".main-menu-left").hide( 700 );
		$("#menuTopList").hide( 700 );
		$(".main-top-menu").removeClass("bg-white");
	}
	else{
		$("#titleMapTop").hide( 700 );
		$("#btn-menu-launch").hide( 700 );
		$("#btn-toogle-map").html("<i class='fa fa-map-marker'></i>");
		$("#btn-toogle-map").attr("data-original-title", "Carte");
		$("#menuTopList").show( 700 );
		$(".main-top-menu").addClass("bg-white");
		if($("#btn-menu-launch").hasClass("active"))
			$("#btn-menu-launch").trigger("click");
		if($(".contentTitleMap").hasClass("active"))
			$(".showHideMoreTitleMap").trigger("click");
		if($("#right_tool_map").is(":visible"))
			$("#btn-search").trigger("click");
	}
}

function startSearchSimply(indexMin, indexMax){
	mylog.log("startSearchSimply", indexMin, indexMax, indexStep);
	$("#listTagClientFilter").html('spiner');
	if(loadingData) return;
	loadingData = true;

	// console.log("loadingData true");
	indexStep = indexStepInit;
	var name = $('#searchBarText').val();
	if(typeof indexMin == "undefined") indexMin = 0;
	if(typeof indexMax == "undefined") indexMax = indexStep;
	currentIndexMin = indexMin;
	currentIndexMax = indexMax;
	if(indexMin == 0 && indexMax == indexStep) {
		totalData = 0;
		mapElements = new Array();
	}
	// if(name.length>=3 || name.length == 0){
	var locality = "";
	/*communexionActivated=true;
	levelCommunexion = 1;
	if(communexionActivated){
		if(levelCommunexion == 1) locality = inseeCommunexion;
		if(levelCommunexion == 2) locality = cpCommunexion;
		if(levelCommunexion == 3) locality = cpCommunexion.substr(0, 2);
		if(levelCommunexion == 4) locality = inseeCommunexion;
		if(levelCommunexion == 5) locality = "";
	}*/
	autoCompleteSearchSimply(name, locality, indexMin, indexMax);
}

function autoCompleteSearchSimply(name, locality, indexMin, indexMax){
	mylog.log("autoCompleteSearchSimply", name, locality, indexMin, indexMax);
	var levelCommunexionName = { 
		1 : "INSEE",
		2 : "CODE_POSTAL_INSEE",
		3 : "DEPARTEMENT",
		4 : "REGION"
	};
	var searchBy = levelCommunexionName[levelCommunexion];
	// searchBy = "NAME";
	/*mylog.log("searchLocalityNAME : ",nwVar.searchLocalityNAME);
	mylog.log("searchLocalityCODE_POSTAL_INSEE : ",nwVar.searchLocalityCODE_POSTAL_INSEE);
	mylog.log("searchLocalityDEPARTEMENT : ",nwVar.searchLocalityDEPARTEMENT);
	mylog.log("searchLocalityINSEE : ",nwVar.searchLocalityINSEE);
	mylog.log("searchLocalityREGION : ",nwVar.searchLocalityREGION);
	mylog.log("searchTag : ",nwVar.searchTag);
	mylog.log("searchCategory : ",nwVar.searchCategory);*/

	//To merge Category and tags which are finally all tags
	var searchTagGlobal = [];
	if (undefined !== nwVar.searchTag && nwVar.searchTag.length) $.merge(searchTagGlobal,nwVar.searchTag) ;
	if (undefined !== nwVar.searchCategory && nwVar.searchCategory.length) $.unique($.merge(searchTagGlobal,nwVar.searchCategory)) ;
	mylog.log("searchTagGlobal : "+searchTagGlobal);

	var searchTagsSimply = {} ;
	if(typeof networkJson.filter != "undefined" && typeof networkJson.filter.linksTag != "undefined"){
		$.each(searchTagGlobal, function(i, o) {

			$.each(networkJson.filter.linksTag, function(keyNet, valueNet){

				if(typeof valueNet.tags[o] != "undefined"){
					if(typeof searchTagsSimply[keyNet] == "undefined")
					  searchTagsSimply[keyNet] = [];

					if(typeof valueNet.tags[o] == "string")
					  searchTagsSimply[keyNet].push(valueNet.tags[o]);
					else{
						$.each(valueNet.tags[o], function(keyTags, valueTags){
						  searchTagsSimply[keyNet].push(valueTags);
						});
					}
				}
			});
		});
	}

	mylog.log("searchTagsSimply", searchTagsSimply);

	var data = {
		"name" : name,
		"locality" : "xxxx",
		"searchType" : nwVar.allsearchType,
		"searchTag" : searchTagGlobal,
		"filtreTag" : searchTagsSimply,
		"searchLocalityNAME" : nwVar.searchLocalityNAME,
		"searchLocalityCODE_POSTAL_INSEE" : nwVar.searchLocalityCODE_POSTAL_INSEE,
		"searchLocalityDEPARTEMENT" : nwVar.searchLocalityDEPARTEMENT,
		"searchLocalityINSEE" : nwVar.searchLocalityINSEE,
		"searchLocalityREGION" : nwVar.searchLocalityREGION,
		"searchBy" : searchBy,
		"indexMin" : indexMin,
		"indexMax" : indexMax,
		//"sourceKey" : sourceKey,
		"mainTag" : nwVar.mainTag,
		"searchPrefTag" : searchPrefTag,
	};

	if(typeof networkJson.request.sourceKey != "undefined")
		data.sourceKey = networkJson.request.sourceKey;

	if(typeof networkJson.filter != "undefined" && typeof networkJson.filter.paramsFiltre != "undefined")
		data.paramsFiltre = networkJson.filter.paramsFiltre;

	if(userConnected != null && typeof userConnected.roles.superAdmin != "undefined" && userConnected.roles.superAdmin == true)
		data.disabled = true;

	if(typeof seeDisable != "undefined" && seeDisable == true)
		data.seeDisable = true;

	//console.log("loadingData true");
	loadingData = true;

	str = "<i class='fa fa-circle-o-notch fa-spin'></i>";
	$(".btn-start-search").html(str);
	$(".btn-start-search").addClass("bg-azure");
	$(".btn-start-search").removeClass("bg-dark");
	//$("#dropdown_search").css({"display" : "inline" });
	if(indexMin > 0)
	$("#btnShowMoreResult").html("<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...");
	else
	$("#dropdown_search").html("<center><span class='search-loaderr text-dark' style='font-size:20px;'><i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...</span></center>");
	if(isMapEnd){
		$.blockUI({
			message : "<h1 class='homestead text-red'><i class='fa fa-spin fa-circle-o-notch'></i><span class='text-dark'> En cours ...</span></h1>"
		});
	}
		
	$.ajax({
		type: "POST",
		url: baseUrl+"/" + moduleId + "/search/simplyautocomplete",
		data: data,
		dataType: "json",
		error: function (data){
			console.log("error");
			console.dir(data);
		},
		success: function(data){
			mylog.log("!data.res", !data.res);
			if(!data.res){toastr.error(data.content); }
			else
			{
				if(data.res.length){
					var countData = 0;
					$.each(data.res, function(i, v) { if(v.length!=0){ countData++; } });

					totalData += countData;
					if(typeof networkJson.request.oneElement != "undefined" && networkJson.request.oneElement == true){
						filterTags(data.filters.tags);
						filterType(data.filters.types);
						$("#divRolesMenu").removeClass("hidden");
					}else{
  						$("#divRolesMenu").addClass("hidden");
  					}
					
					bindAutocomplete();
					str = "";
					var city, postalCode = "";
					var mapElements = new Array();
					allTags = data.filters;

					//parcours la liste des résultats de la recherche
					$.each(data.res, function(i, o) {
						var typeIco = i;
						var ico = mapIconTop["default"];
						var color = mapColorIconTop["default"];

						typeIco = o.type;
						ico = ("undefined" != typeof mapIconTop[typeIco]) ? mapIconTop[typeIco] : mapIconTop["default"];
						color = ("undefined" != typeof mapColorIconTop[typeIco]) ? mapColorIconTop[typeIco] : mapColorIconTop["default"];

						htmlIco ="<i class='fa "+ ico +" text-"+color+"'></i>";
						if("undefined" != typeof o.profilThumbImageUrl && o.profilThumbImageUrl != ""){
							var htmlIco= "<img width='80' height='80' alt='' class='img-circle bg-"+color+"' src='"+baseUrl+o.profilThumbImageUrl+"'/>";
						}

						city="";
						var postalCode = o.cp
						if (o.address != null) {
							city = o.address.addressLocality;
							postalCode = o.cp ? o.cp : o.address.postalCode ? o.address.postalCode : "";
						}

						//console.dir(o);
						var id = getObjectId(o);
						var tagsClasses = "";
						var insee = o.insee ? o.insee : "";
						type = o.type;
						if(type=="citoyen") type = "person";

						//Consolidate types
						if(type != "undefined" && type != null){
							if(typeof allTypes[type] != "undefined"){
								allTypes[type] = allTypes[type] + 1;
							}
							else{
								allTypes[type] = 1;
							}
						}

						var url = "javascript:"; //baseUrl+'/'+moduleId+ "/default/simple#" + o.type + ".detail.id." + id;
						var url = baseUrl+'/'+moduleId+ "/default/dir#" + type + ".simply.id." + id;
						// var onclick = 'loadByHash("#organization.simply.id.' + id + '");';
						var onclick = 'getAjaxFiche("#page.type.'+o.typeSig+'.id.'+id+'",1);';
						var onclickCp = "";
						var target = " target='_blank'";
						var dataId = "";
						if(type == "city"){
							url = "javascript:"; //#main-col-search";
							onclick = 'setScopeValue($(this))'; //"'+o.name.replace("'", "\'")+'");';
							onclickCp = 'setScopeValue($(this));';
							target = "";
							dataId = o.name; //.replace("'", "\'");
						}

						//var tags = "";
						var find = false;
						var tags = "";
						var elTagsList = "";
						if(typeof o.tags != "undefined" && o.tags != null){
							$.each(o.tags, function(key, value){
								if(value != ""){
									tags += "<a href='javascript:;' class='badge bg-red btn-tag tagFilter padding-5' data-tag-value='"+slugify(value)+"'>#" + value + "</a> ";
									elTagsList += slugify(value)+" ";
									if(find == false && value in linksTagImages == true){
										find = true;
										o.typeSig = "organizations";
										o.type = "organizations";
									}
								}
							});
						}

						mapElements.push(o);
						contextMapNetwork.push(o);
						// console.log(tagsClasses);
						var name = typeof o.name != "undefined" ? o.name : "";
						var website = (typeof o.url != "undefined" || o.url != null) ? o.url : "";
						var postalCode = (	typeof o.address != "undefined" &&
											typeof o.address.postalCode != "undefined") ? o.address.postalCode : "";

						if(postalCode == "") postalCode = typeof o.cp != "undefined" ? o.cp : "";
						var cityName = (typeof o.address != "undefined" &&
										typeof o.address.addressLocality != "undefined") ? o.address.addressLocality : "";

						var fullLocality = postalCode + " " + cityName;
						fullLocality = fullLocality.trim();
						var description = (	typeof o.shortDescription != "undefined" &&
											o.shortDescription != null) ? o.shortDescription : "";
						if(description == "") description = (	typeof o.description != "undefined" &&
																o.description != null) ? o.description : "";
						description = "";
						if(o.profilMediumImageUrl != "undefined" && o.profilMediumImageUrl != "")
							pathmedium = baseUrl+o.profilMediumImageUrl;
						else
							pathmedium = "<?php echo $this->module->assetsUrl ?>/images/thumbnail-default.jpg";
						shortDescription = (	typeof o.shortDescription != "undefined" &&
												o.shortDescription != null ) ? o.shortDescription : "";

						var startDate = (typeof o.startDate != "undefined") ? "Du "+dateToStr(o.startDate, "fr", true, true) : null;
						var endDate   = (typeof o.endDate   != "undefined") ? "Au "+dateToStr(o.endDate, "fr", true, true)   : null;

						var disabledBorder = ((typeof o.disabled != "undefined" && o.disabled == true) ? "border-red elementDisabled" : "" );
						var disabledText = ((typeof o.disabled != "undefined" && o.disabled == true) ? '<h1 id="disabledList" class="text-red"><?php echo Yii::t("common", "Disabled"); ?></h1>' : "" );


						/***** VERSION SIMPLY *****/
						str += "<div id='"+id+"' class='row list-group-item item searchEntity "+mix+" "+elTagsList+" "+fullLocality+" "+disabledBorder+"' >";
						if( typeof networkJson.result.displayImage != "undefined"){
							str += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 padding-10 center">'+
							'<img class="img-responsive thumbnail" src="'+pathmedium+'" alt="Image"'+ name+'".></div>';
						}
						
						str += "<div class='entityMiddle col-md-5 name' onclick='"+onclick+"'>";
						str += disabledText;
						str += "<a class='entityName text-dark'>" + name + "</a><br/>";
						if(website != null && website.trim() != "")
							str += "<i class='fa fa-desktop fa_url'></i> <a href='"+website+"' target='_blank'>"+website+"</a><br/>";

						if( typeof networkJson.result.fullLocality != "undefined" && fullLocality != ""){
							str += "<div class='entityLocality'><i class='fa fa-home'></i> " + fullLocality + "</div><br/>";
						}
						
						str += "</div>";


						if( typeof networkJson.result.displayType != "undefined"){
							str += "<div class='entityMiddle col-md-2 type '>";
							typeIco = "";
							str += htmlIco+"" + typeIco + "";
							str += "</div>";
						}

						if( typeof networkJson.result.displayShortDescription != "undefined"){
							str += "<div class='entityMiddle col-md-5 type '>"+shortDescription+"</div>";
						}

						target = "";
						str += "<div class='entityBottom col-md-5'>";
						str += "<hr>";
						if(tags=="") tags = "<a href='javascript:;' class='badge bg-red btn-tag'>#</a>";
						str += tags;
						str += "</div>";
						str += "</div>";
					}); //end each
				
					if(str == "") {
						$(".btn-start-search").html("<i class='fa fa-search'></i>");
						if(indexMin == 0){
							//ajout du footer
							var msg = trad.noresult;
							if(name == "" && locality == "") 
								msg = "<h3 class='text-dark'><i class='fa fa-3x fa-keyboard-o'></i><br> Préciser votre recherche pour plus de résultats ...</h3>";
							str += '<div class="center" id="footerDropdown">';
							str += "<hr style='float:left; width:100%;'/><label style='margin-bottom:10px; margin-left:15px;' class='text-white'>"+msg+"</label><br/>";
							str += "</div>";
							$("#dropdown_search").html(str);
							$("#searchBarText").focus();
						}
					}
					else {
						//ajout du footer

						str += '</div><div class="center col-md-12" id="footerDropdown">';
						str += "<hr style='float:left; width:100%;'/><label id='countResult' class='text-white'></label><br/>";
						
						if( typeof networkJson.mode != "undefined" && networkJson.mode != "client" ){
							str += '<button class="btn btn-default" id="btnShowMoreResult"><i class="fa fa-angle-down"></i> Afficher plus de résultat</div></center>';
							str += "</div>";
						}

						//si on n'est pas sur une première recherche (chargement de la suite des résultat)
						if(indexMin > 0){
							//on supprime l'ancien bouton "afficher plus de résultat"
							$("#btnShowMoreResult").remove();
							//on supprimer le footer (avec nb résultats)
							$("#footerDropdown").remove();
							//on calcul la valeur du nouveau scrollTop
							var heightContainer = $(".my-main-container")[0].scrollHeight - 180;
							//on affiche le résultat à l'écran
							$("#dropdown_search").append(str);
						//si on est sur une première recherche
						}else{
							//on affiche le résultat à l'écran
							$("#dropdown_search").html(str);
							//on scroll pour coller le haut de l'arbre au menuTop
							// $(".my-main-container").scrollTop(95);
						}

						//On met à jour les filtres
						if( typeof networkJson.mode != "undefined" && networkJson.mode == "client" ){
							loadClientFilters(allTypes, allTags);
						} else{ 
							loadServerFilters(allTypes, allTags);
						}

						//on affiche par liste par défaut
						$('#list').click();
						//remet l'icon "loupe" du bouton search
						$(".btn-start-search").html("<i class='fa fa-search'></i>");

						//active le chargement de la suite des résultat au survol du bouton "afficher plus de résultats"
						//(au cas où le scroll n'ait pas lancé le chargement comme prévu)
						$("#btnShowMoreResult").mouseenter(function(){
							if(!loadingData){
								startSearchSimply(indexMin+indexStep, indexMax+indexStep);
								$("#btnShowMoreResult").mouseenter(function(){});
							}
						});

						//initialise les boutons pour garder une entité dans Mon répertoire (boutons links)
						// initBtnLink();
					} //end else (str=="")

					//signal que le chargement est terminé
					mylog.log("test");
					loadingData = false;

					if( typeof networkJson.mode != "undefined" && networkJson.mode == "client" ){
						loadClientFeatures();
					} else{ 
						loadServerFeatures();
					}
					//quand la recherche est terminé, on remet la couleur normal du bouton search
					$(".btn-start-search").removeClass("bg-azure");
				}
				
			}
			// console.log("scrollEnd ? ", scrollEnd, indexMax, countData , indexMin);

			//si le nombre de résultat obtenu est inférieur au indexStep => tous les éléments ont été chargé et affiché
			if(indexMax - countData > indexMin){
				$("#btnShowMoreResult").remove();
				scrollEnd = true;
			}else{
				scrollEnd = false;
			}
			//affiche les éléments sur la carte
			Sig.restartMap();
			Sig.showMapElements(Sig.map, mapElements);
			//on affiche le nombre de résultat en bas
			var s = "";
			var length = ($( "div.searchEntity" ).length);
			if(length > 1) s = "s";
			$("#countResult").html(length+" résultat"+s);
			$.unblockUI();
		}
	});
}

function tagActivedUpdate(checked, tag, parent){
	mylog.log("tagActivedUpdate", checked, tag, parent,tagsActived, typeof tagsActived[parent], (typeof tagsActived[parent] == "undefined"));
	if(checked== false){
		tagsActived[parent].splice($.inArray(tag, tagsActived),1);
	}
	else{
		if(typeof tagsActived[parent] == "undefined"){
			tagsActived[parent] = [];
		}
		tagsActived[parent].push(tag);
	}
}

function chargement(){
	mylog.log("chargement");
	processingBlockUi();
	setTimeout(function(){ updateMap(); }, 1000);
}

function bindAutocomplete(){
	$(".tagFilterAuto").off().click(function(e){
		
		mylog.log(".tagFilter",  $(this));
		mylog.log($(this).is( ':checked' ), $(this).prop( 'checked' ), $(this).attr( 'checked' ));
		var checked = $(this).is( ':checked' );
		var val = $(this).attr("value");
		tagActivedUpdate(checked, val, "tags");
		chargement();
		
	});


	$(".typeFilterAuto").off().click(function(e){ 
		var checked = $(this).is( ':checked' );
		var ville = $(this).attr("value");
		typeActivedUpdate(checked, ville);
		chargement();
	});

	$(".rolesFilterAuto").off().click(function(e){
		var checked = $(this).is( ':checked' );
		var role = $(this).attr("value");
		mylog.log(".rolesFilterAuto", checked, role);
		rolesActivedUpdate(checked, role);
		chargement();
	});
}


function loadServerFeatures(){

}

function loadServerFilters(types,tags){
	var displayLimit = 10;
	var classToHide = "";
	var i = 0;
	var breadcum  = "";
	//All desacactivate
	$('.villeFilter').prop("checked", false );
	$('.tagFilter').prop("checked", false );
	$('.categoryFilter').prop("checked", false );

	//One by One Tag
	/*$.each(nwVar.searchTag, function(index, value){
		//Display
		$('.tagFilter[value="'+value+'"]').prop("checked", true );
		if($('.tagFilter[value="'+value+'"]').length)breadcum = breadcum+"<span class='label label-danger tagFilter' value='"+value+"'>"+$('.tagFilter[value="'+value+'"]').attr("data-label")+"</span> ";
		//Open menu
		manageCollapse(value,true);
	});*/

	$.each(nwVar.searchLocalityNAME, function(index, value){
		//Display
		$('.villeFilter[value="'+value+'"]').prop("checked", true );
		//Open menu
		manageCollapse(value,true);
	});

	//One by One Category
	$.each(nwVar.searchCategory, function(index, value){
		$('.categoryFilter[value="'+value+'"]').prop( "checked", true );
		breadcum = breadcum+"<span class='label label-danger categoryFilter' value='"+value+"'>"+value+"</span> ";
	}); 

	$(".tagFilter").off().click(function(e){
		mylog.log(".tagFilter",  $(this));
		mylog.log($(this).is( ':checked' ), $(this).prop( 'checked' ), $(this).attr( 'checked' ));
		var checked = $(this).is( ':checked' );
		var filtre = $(this).attr("value");
		var parent = $(this).data("parent")
		mylog.log("parent",parent);
		if(typeof networkJson.filter != "undefined" && typeof networkJson.filter.linksTag != "undefined"){
			$.each(networkJson.filter.linksTag, function(keyNet, valueNet){
				if(typeof valueNet.tags[filtre] != "undefined"){

					if(typeof valueNet.tags[filtre] == "string"){
						tagActivedUpdate(checked, valueNet.tags[filtre], parent);
					}
					else{
						$.each(valueNet.tags[filtre], function(keyTags, valueTags){
							tagActivedUpdate(checked, valueTags, parent);
						});
					}
				}  
			});
		}

		chargement();	  	
	});

	$(".villeFilter").off().click(function(e){
		var checked = $(this).is( ':checked' );
		var ville = $(this).attr("value");
		cityActivedUpdate(checked, ville);
		chargement();
	});

	$(".categoryFilter").off().click(function(e){
		var category = $(this).attr("value");
		if($(this).is(':checked') == false){
			removeSearchCategory(category);
		}
		else{
			addSearchCategory(category);
		}
		startSearchSimply(0, indexStepInit);
	});

	$(".disableCheckbox").off().click(function(e){
		disableActived = ( (disableActived == false) ? true : false );
		chargement();
	});
}

function breadcrumGuide(level, url){
	newLevel=$(".breadcrumAnchor").length;
	mylog.log("breadcrumGuide", newLevel, level, url);
	if(level==0){
		reverseToRepertory();
	}
	else{
		if(level < newLevel){
			newLevel=false;
			$(".breadcrumAnchor").each(function(){
				value=$(this).data("value");
				if(value > level){
					$(this).remove();
					$(".breadcrumChevron[data-value='"+value+"']").remove();
				}
			});
		}

		if(newLevel == 5){
			$(".breadcrumChevron[data-value='4']").remove();
			$(".breadcrumAnchor[data-value='4']").remove();
			newLevel=4;
		}
		getAjaxFiche(url, newLevel); 
	}
}


function getAjaxFiche(url, breadcrumLevel){
	mylog.log("getAjaxFiche Network", url, breadcrumLevel);
	$("#ficheInfoDetail").empty();
	if(location.hash == ""){
		history.pushState(null, "New Title", '?src='+networkParams+url);
	}
	
	if(isMapEnd){
		pathTitle="Cartographie";
		pathIcon = "map-marker";
		showMapNetwork();
	}else{
		pathTitle="Annuaire";
		pathIcon = "list";
	}

	allReadyLoad = true;
	//location.hash = url;
	urlHash=url;
	mylog.log("urlHash", urlHash);
	if( urlHash.indexOf("type") < 0 && 
		urlHash.indexOf("default.view") < 0 && 
		urlHash.indexOf("gallery") < 0 && 
		urlHash.indexOf("news") < 0 &&
		urlHash.indexOf("network") < 0 && 
		urlHash.indexOf("invite") < 0){

		urlSplit=urlHash.replace( "#","" ).split(".");
		mylog.log(urlHash);

		if(urlSplit[0]=="person")
			urlType="citoyens";
		else
			urlType=urlSplit[0]+"s";

		urlHash="#element."+urlSplit[1]+".type."+urlType+".id."+urlSplit[3];
	}

	if(urlHash.indexOf("news") >= 0){
		urlHash=urlHash+"&isFirst=1";
	}
	mylog.log("urlHash2", urlHash);
	url= "/app/"+urlHash.replace( "#","" ).replace( /\./g,"/" );
	mylog.log("url", url);
	$("#repertory").hide( 700 );
	$(".main-menu-left").hide( 700 );
	$("#ficheInfoDetail").show( 700 );
	$(".main-col-search").removeClass("col-md-10 col-md-offset-2 col-sm-9 col-sm-offset-3").addClass("col-md-12 col-sm-12");
	
	$.blockUI({
		message : "<h4 style='font-weight:300' class='text-dark padding-10'><i class='fa fa-spin fa-circle-o-notch'></i><br>Chargement en cours ...</span></h4>"
	});

	mylog.log("networkParams", networkParams);
	
	getAjax('#ficheInfoDetail', baseUrl+'/'+moduleId+url+'?src='+networkParams, function(){
		$.unblockUI();
		mylog.log(contextData);
		//Construct breadcrumb
		if(breadcrumLevel != false){
			$html= '<i class="fa fa-chevron-right fa-1x text-red breadcrumChevron" style="padding: 0px 10px 0px 10px;" data-value="'+breadcrumLevel+'"></i>'+'<a href="javascript:;" onclick="breadcrumGuide('+breadcrumLevel+',\''+urlHash+'\')" class="breadcrumAnchor text-dark" data-value="'+breadcrumLevel+'">'+contextData.name+'</a>';
			$("#breadcrum").append($html);
		}
	},"html");
}


function reverseToRepertory(){
	mylog.log("reverseToRepertory", isMapEnd);
	if(isMapEnd)
		showMapNetwork();

	updateMap();
	$("#ficheInfoDetail").hide( 700 );
	$(".main-col-search").removeClass("col-md-12 col-sm-12").addClass("col-md-10 col-md-offset-2 col-sm-9 col-sm-offset-3");
	$("#dropdown_search").show();
	$("#repertory").show();
	$(".main-menu-left").show( 700 );
	$html = '<a href="javascript:;" onclick="breadcrumGuide(0)" class="breadcrumAnchor text-dark" style="font-size:20px;">Liste</a>';
	$("#breadcrum").html($html);
	history.replaceState(null, '', window.location.href.split('#')[0]);
	
}

//if all tags exist returns true
//console.log( and( [], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
//console.log( and( ["atelier"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
//console.log( and( ["atelier","coco"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
//console.log( and( ["atelier","commun"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
//console.log( and( ["coco","atelier"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
//console.log( and( ["coco","atelier",'commun'], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
function and(tags,tagList)
{
	var res = true ;
	$.each(tags,function(i,t){
		reg = new RegExp("^"+t+"$","i");
		if( inArrayRegex(tagList,reg) == false ){
    		res = false;
	        return false;
	    }
	});
	return res;
}

//if just one or many tags exist returns true
/*console.log( or( [], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
console.log( or( ["atelier"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
console.log( or( ["atelier","coco"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
console.log( or( ["atelier","commun"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
console.log( or( ["coco","atelier"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));
console.log( or( ["coco","n"], [ "mobilité", "atelier", "commun", "tiers-lieux" ] ));*/
function or(tags,tagList)
{
	res = (!tags.length) ? true :false;
	$.each(tags,function(i,t){
		reg = new RegExp("^"+t+"$","i");
		if( inArrayRegex(tagList,reg) !== false ){
    		res = true;
	        return false;
	    }
		
	});
	return res;
}


function inArrayRegex(tab,regex){
	res = false;
	$.each(tab,function(i,t){
		if(t.match(regex)){
			res = true;
			return false
		}
	});
	return res;
}


function tagActivedUpdate(checked, tag, parent){
	mylog.log("tagActivedUpdate", checked, tag, parent,tagsActived, typeof tagsActived[parent], (typeof tagsActived[parent] == "undefined"));
	if(checked== false){
		tagsActived[parent].splice($.inArray(tag, tagsActived),1);
	}
	else{
		if(typeof tagsActived[parent] == "undefined"){
			tagsActived[parent] = [];
		}
		tagsActived[parent].push(tag);
	}

	//tagsActived = orAndAnd(tagsActived) ;
	//mylog.log("tagsActived", tagsActived);
}

function cityActivedUpdate(checked, city){
	mylog.log("cityActivedUpdate", checked, city);
	if(checked== false){
		citiesActived.splice($.inArray(city, citiesActived),1);
	}
	else{
		citiesActived.push(city);
	}
}


function  typeActivedUpdate(checked, type){
	mylog.log("typeActivedUpdate", checked, type);
	if(checked== false){
		typesActived.splice($.inArray(type, typesActived),1);
	}
	else{
		typesActived.push(type);
	}
}

function  rolesActivedUpdate(checked, role){
	mylog.log("rolesActivedUpdate", checked, role);
	if(checked== false){
		rolesActived.splice($.inArray(role, rolesActived),1);
	}
	else{
		rolesActived.push(role);
	}
}



function addTab(tab, tab2){
	mylog.log("addTab", tab, tab2);
	var res = [];
	$.each(tab2, function(key2, value2){
		$.each(tab, function(key1, value1){
			var t = value1.slice();
			t.push(value2);
			res.push(t);
		});
	});
	mylog.log("addTab res", res);
	return res ;
}

function orAndAnd(allFiltres){
	mylog.log("orAndAnd", allFiltres);
	var res = [];
	$.each(allFiltres, function(keyF, valueFiltre){
		if(valueFiltre.length > 0){
			if(Object.keys(tagsActived)[0] == keyF){
				$.each(valueFiltre, function(key, value){
					res.push([value]);
				});
			}else
				res = addTab(res, valueFiltre);
		}
	});
	mylog.log("orAndAnd Res", res);
	return res ;
}

function getAllTags(allFiltres){
	mylog.log("getAllTags", allFiltres);
	var res = [];
	$.each(allFiltres, function(keyF, valueFiltre){
		if(valueFiltre.length > 0){
			$.each(valueFiltre, function(key, value){
				res.push(value);
			});
		}
	});
	mylog.log("getAllTags Res", [res]);
	return [res] ;
}

function andAndOr(allFiltres){
	mylog.log("andAndOr", allFiltres);
	var res = [];
	$.each(allFiltres, function(keyF, valueFiltre){
		if(valueFiltre.length > 0){
			res.push(valueFiltre);
		}
	});
	mylog.log("andAndOr Res", res);
	return res ;
}



function updateMap(){
	mylog.log("updateMap", tagsActived, disableActived);

	var params = ((typeof networkJson.filter == "undefined" && typeof networkJson.filter.paramsFiltre == "undefined") ? null :  networkJson.filter.paramsFiltre);
	var test = [];
	var verb = "and";
	var elementNetwork = [];
	if(typeof networkJson.request.oneElement != "undefined" && typeof networkJson.request.sourceKey != "undefined" && networkJson.request.oneElement == true){
		
		 elementNetwork = networkJson.request.sourceKey[0].split("@");
		 mylog.log("elementNetwork", elementNetwork);
	}

	//mylog.log("params", params);
	if ( params != null && ( (params.conditionBlock == "and" || typeof params.conditionBlock == "undefined" ) && params.conditionTagsInBlock == "and" ) )
		test = getAllTags(tagsActived);
	else if ( params != null && ( (params.conditionTagsInBlock == "or" || typeof params.conditionTagsInBlock == "undefined" ) && params.conditionBlock == "or" ) ) {
		test = getAllTags(tagsActived);
		verb = "or";
	}
	else if ( params != null && ( (params.conditionBlock == "or" || typeof params.conditionBlock == "undefined" ) && 
			(params.conditionTagsInBlock == "and" || typeof params.conditionTagsInBlock == "undefined") ) ) {
		//verb = "or";
		test = andAndOr(tagsActived);
	}
	else
		test = orAndAnd(tagsActived);

	mylog.log("test", test);

	mylog.log("searchValNetwork", searchValNetwork);
	var filteredList = [];
	var add = false;
	$(".searchEntity").hide();
	if(test.length > 0){
		$.each(test,function(keyTags,tags){
			$.each(contextMapNetwork,function(k,v){
				if(typeof v.tags != "undefined" && v.tags != null)
					add = ( (verb == "and") ? and( tags, v.tags ) : or( tags, v.tags ) );
				else
					add= false;
				mylog.log("configFiltre", disableActived, v.disabled, citiesActived, typesActived, rolesActived);
				if(	add && 
					( 	disableActived == false || 
						(disableActived == true && typeof v.disabled != "undefined" && v.disabled == true) ) && 
					( citiesActived.length == 0  || 
						(	typeof v.address != "undefined" && 
							typeof v.address.addressLocality != "undefined" && 
							$.inArray( v.address.addressLocality, citiesActived ) >= 0  ) ) &&


					( typesActived.length == 0  || 
						(	typeof v.typeSig != "undefined" && 
							$.inArray( v.typeSig, typesActived ) >= 0  ) ) &&
					( rolesActived.length == 0  || 
						(isLinks(v, elementNetwork[0]) ) ) && 

					/*( 	(typeof searchVal == "undefined") || 
						( 	v.name.search( new RegExp( searchVal, "i" ) ) >= 0 || 
							v.address.addressLocality.search( new RegExp( searchVal, "i" ) ) >= 0 ) ) )  {*/

					( 	searchValNetwork.length == 0 || 
						( 	v.name.search( new RegExp( searchValNetwork, "i" ) ) >= 0  ) ) )  {
					
					filteredList = addTabMap(v, filteredList);
					$("#"+v.id).show();
				}
			});
		});
	}else{
		if( disableActived == true || citiesActived.length > 0 || 
			typesActived.length > 0 || rolesActived.length > 0 || 
			searchValNetwork.length > 0)  {

			$.each(contextMapNetwork,function(k,v){
				if(	( 	disableActived == false || 
						(disableActived == true && typeof v.disabled != "undefined" && v.disabled == true) ) && 
					( citiesActived.length == 0  || 
						(	typeof v.address != "undefined" && 
							typeof v.address.addressLocality != "undefined" && 
							$.inArray( v.address.addressLocality, citiesActived ) >= 0 ) ) &&
					( typesActived.length == 0  || 
						(	typeof v.typeSig != "undefined" && 
							$.inArray( v.typeSig, typesActived ) >= 0  ) ) &&
					( rolesActived.length == 0  || 
						(isLinks(v, elementNetwork[0]) ) )  && 

					/*( 	(typeof searchVal == "undefined") || 
						( 	v.name.search( new RegExp( searchVal, "i" ) ) >= 0 || 
							v.address.addressLocality.search( new RegExp( searchVal, "i" ) ) >= 0 ) ) )  {*/


					( 	searchValNetwork.length == 0 || 
						( 	v.name.search( new RegExp( searchValNetwork, "i" ) ) >= 0 ) ) ) {


					filteredList = addTabMap(v, filteredList);
					$("#"+v.id).show();
				}
			});
		}else{
			/*$.each(contextMapNetwork,function(k,v){
				filteredList = addTabMap(v, filteredList);
			});*/
			filteredList = contextMapNetwork;
			$(".searchEntity").show();
		}
	}
	mylog.log("filteredList", filteredList);
	Sig.restartMap();
	Sig.showMapElements(Sig.map,filteredList);
	$.unblockUI();
}

function addTabMap(element, tab){
	if( "undefined" != typeof element.geo && element.geo != null )
		tab.push(element);
	return tab;
}


function isLinks(element, id){
	mylog.log("isLinks", element, id);
	var res = false ;
	mylog.log("rolesActived", rolesActived);
	if(rolesActived.length){
		$.each(rolesActived,function(k,v){
			mylog.log(v, element);
			if(v == "creator" && element.creator == id){
					res = true ;
					return true;
				
			}else if(	v == "admin" && 
						element.links != null &&
						typeof element.links["members"] != "undefined" && 
						typeof element.links["members"][id] != "undefined" && 
						typeof element.links["members"][id].isAdmin != "undefined" && 
						element.links["members"][id].isAdmin == true){
				res = true ;
				return true;
			}else if(	element.links != null && 
						typeof element.links != "undefined" && 
						typeof element.links[ v ] != "undefined" && 
						typeof element.links[ v ][id] != "undefined" ){
				res = true ;
				return true;
			}
		});
	}
	return res ;
}

function filterTags(tags){
	mylog.log("filterTags", tags);
	if(typeof tags != "undefined" ){
		str = '<div class="panel-heading">'+
	          '<h4 class="panel-title" onclick="manageCollapse(\'tags\', \'false\')">'+
	            '<a data-toggle="collapse" href="#tags" style="color:#719FAB" data-label="tags">Tous les tags'+ 
	              '<i class="fa fa-chevron-right right" aria-hidden="true" id="fa_tags"></i>'+
	            '</a>'+
	          '</h4>'+
	        '</div>'+
	        '<div id="list_tags" class="panel-collapse collapse">'+
	          '<ul class="list-group no-margin">';
	          		$.each(tags,function(k,v){
	          			 str += '<li class="list-group-item"><input type="checkbox" class="checkbox tagFilterAuto" value="'+k+'" data-parent="tags" data-label="'+k+'"/>'+k+' (' +v+ ')</li>'
	          		});
	        str +=  '</ul> </div>';

	    $("#divTagsMenu").append(str);
    }
}


function filterType(types){
	mylog.log("filterType", types);
	if(typeof tags != "undefined" ){
		str = '<div class="panel-heading">'+
	          '<h4 class="panel-title" onclick="manageCollapse(\'types\', \'false\')">'+
	            '<a data-toggle="collapse" href="#types" style="color:#719FAB" data-label="types">Tous les types'+ 
	              '<i class="fa fa-chevron-right right" aria-hidden="true" id="fa_tags"></i>'+
	            '</a>'+
	          '</h4>'+
	        '</div>'+
	        '<div id="list_types" class="panel-collapse collapse">'+
	          '<ul class="list-group no-margin">';
	          		$.each(types,function(k,v){
	          			 str += '<li class="list-group-item"><input type="checkbox" class="checkbox typeFilterAuto" value="'+k+'" data-parent="types" data-label="'+k+'"/>'+trad[k]+' (' +v+ ')</li>'
	          		});
	        str +=  '</ul> </div>';

	    $("#divTypesMenu").append(str);
	}
}

</script>
