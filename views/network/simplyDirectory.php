<style>
	.dropdown_searchListNW{
		min-height: 100%;
	}
	.sub-menu-social{
	 	margin-top: -30px;
	 }
</style>

<div class="col-md-12 no-padding" id="repertory" style="background-color: white">
	<div id="dropdown_search_result" class="col-md-12 col-sm-12 col-xs-12"></div>
	<div id="dropdown_search" class="col-md-12 container list-group-item dropdown_searchListNW"></div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="ficheInfoDetail"></div>

<script type="text/javascript">
var contextMapNetwork = [];
var currentKFormType = "";
var indexStepInit = 100;
var searchPrefTag = null ;
var indexStep = indexStepInit;
var scrollEnd = false;

contextData = {};

var tagsActived = {};
var disableActived = false;
var citiesActived = [] ;
var typesActived = [] ;
var rolesActived = [] ;
var classifiedsActived = [] ;
var searchValNetwork = "";

var loadingData = false;
var mapElements = new Array();
var tagsFilter = new Array();

var nwVar = {
	mainTag : [],
	sourceKey : [],
	searchTag : [],
	searchCategory : [],
	searchLocalityNAME : [],
	searchLocalityCODE_POSTAL_INSEE : [],
	searchLocalityDEPARTEMENT : [],
	searchLocalityINSEE : [],
	searchLocalityREGION : [],
	searchType : [],
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

	$("#right_tool_map").removeClass("hidden-sm").hide( 700 );
	hideScrollTop = true;
	checkScroll();
	var timeoutSearch = setTimeout(function(){ }, 100);
	setTimeout(function(){ $("#input-communexion").hide(300); }, 300);
	// // mylog.log("indexStepInit", indexStepInit);
	bindButtonOpenForm();
	startSearchSimply(0, indexStepInit);
});

function initVar(){
	searchPrefTag = ( typeof networkJson.request.searchPrefTag != "undefined" ?  networkJson.request.searchPrefTag : null ) ;

	if( typeof networkJson.request.pagination != "undefined" && networkJson.request.pagination > 0)
		indexStepInit = networkJson.request.pagination ;

	citiesActived = ( ((typeof networkJson.request.searchLocalityNAME == "undefined") || networkJson == null) ? [] : networkJson.request.searchLocalityNAME);

	if( notEmpty(citiesActived) ){
		var cA = [];
		$.each(citiesActived,function(k,v){
			cA.push(v.toUpperCase());
		});
		citiesActived = cA ;
	}

	indexStep = indexStepInit;
	var allSearchParams = ["mainTag", "sourceKey", "searchType", "searchTag","searchCategory","searchLocalityNAME","searchLocalityCODE_POSTAL_INSEE","searchLocalityDEPARTEMENT","searchLocalityINSEE","searchLocalityREGION"];
	$.each(allSearchParams,function(k,v){
		nwVar[v] = ( ( typeof networkJson.request[v] != "undefined" && $.isArray(networkJson.request[v]) ) ? networkJson.request[v] : [] );
	});

	var btnSearch = '<div class="btn-group btn-group-lg tooltips" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="'+trad.searchbyname+'">'+
					'<button type="button" class="btn btn-map " id="btn-search">'+
					'<i class="fa fa-chevron-left"></i></button>'+
				'</div>';
	$("#btn-back").parent().replaceWith(btnSearch);
	$("#mapLegende").addClass("hidden");

	if(typeof networkJson.request.parent != "undefined" &&
		typeof networkJson.request.parent.id != "undefined" &&
		typeof networkJson.request.parent.type != "undefined" ){
		contextData = networkJson.request.parent ;
	}
}

function addTooltips(){
	 // mylog.log("addTooltips");
	if(typeof networkJson.skin != "undefined" && typeof networkJson.skin.tooltips != "undefined"){
		$.each(networkJson.skin.tooltips,function(k,v){
			 // mylog.log("addTooltips", k,v);
			$( k ).addClass("tooltips");
			$( k ).data( "toggle", "tooltip" );
			$( k ).data( "placement", "bottom" );
			$( k ).attr( "title", v );
		});
	}
}

function bindNetwork(){
	 // mylog.log("bindNetwork");
	$('#btn-toogle-map').click(function(e){ 
		showMapNetwork(); 
		updateMap(); 
	});
	
	$('.reset').on('click', function() {
		 // mylog.log(".reset");
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
		if( notEmpty(citiesActived) ){
			var cA = [];
			$.each(citiesActived,function(k,v){
				cA.push(v.toUpperCase());
			});
			citiesActived = cA ;
		}
		typesActived = [] ;
		rolesActived = [] ;
		classifiedsActived = [] ;
		searchValNetwork = "";
		chargement();
	});

	$("#btn-search").click(function(){
		 // mylog.log("#btn-search", $("#right_tool_map").is(":visible"));
		if(!$("#right_tool_map").is(":visible")){
			$("#right_tool_map").show( 700 );
			$("#btn-search").find("i").removeClass("fa-chevron-left").addClass("fa-chevron-right");
		}else {
			$("#right_tool_map").hide( 700 );
			$("#btn-search").find("i").removeClass("fa-chevron-right").addClass("fa-chevron-left");
		}
			
	});

	$('#btn-menu-launch').click(function(){
		 // mylog.log("#btn-menu-launch", $(this).hasClass("active"));
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
		 // mylog.log(".showHideMoreTitleMap");
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
}

function showMapNetwork(show){
	 // mylog.log("showMapNetwork", show, isMapEnd);
	 // mylog.log("typeof SIG : ", typeof Sig);

	if(typeof Sig == "undefined") show = false;

	if( typeof show == "undefined") 
		show = !isMapEnd;
	 // mylog.log("show", show);
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
		$(".btn-group-map").removeClass("hidden");
		
		$(".my-main-container").animate({
			top: -1000,
			opacity:0,
		}, 'slow' );
		setTitle(networkJson.skin.title , "", networkJson.skin.title, networkJson.skin.title, networkJson.skin.shortDescription);
		setTimeout(function(){ 
			$(".my-main-container").hide();
		}, 1000);
		var timer = setTimeout("Sig.constructUI()", 1000);

	}else{
		isMapEnd =false;
		hideMapLegende();
		$(".btn-group-map").hide( 700 );
		$(".main-bottom-menu").hide( 700 );
		showMenuNetwork(false);
		$(".btn-menu5, .btn-menu-add").show();
		$(".panel_map").hide(1);
		$(".main-col-search").animate({ top: 0, opacity:1 }, 800 );
		$(".my-main-container").animate({
			top: 50,
			opacity:1
		}, 'slow' );
		setTitle(networkJson.skin.title , "", networkJson.skin.title, networkJson.skin.title, networkJson.skin.shortDescription);
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
	 // mylog.log("showMenuNetwork", show);
	if(typeof show == "undefined") 
		show = $("#main-top-menu").css("opacity") == 1;
	
	if(show){
		$("#titleMapTop").show( 700 );
		$("#btn-menu-launch").show( 700 );
		$("#btn-toogle-map").html("<i class='fa fa-list'></i>");
		$("#btn-toogle-map").attr("title", trad.list);
		$("#btn-toogle-map").attr("data-original-title", trad.list);
		$("#btn-toogle-map").removeClass("resizer");
		$(".main-menu-left").hide( 700 );
		$("#menuTopList").hide( 700 );
		$(".main-top-menu").removeClass("bg-white");
	}
	else{
		$("#titleMapTop").hide( 700 );
		$("#btn-menu-launch").hide( 700 );
		$("#btn-toogle-map").html("<i class='fa fa-map-marker'></i>");
		$("#btn-toogle-map").attr("data-original-title", trad.map);
		$("#btn-toogle-map").addClass("resizer");
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
	 // mylog.log("startSearchSimply", indexMin, indexMax, indexStep);
	$("#listTagClientFilter").html('spiner');
	if(loadingData) return;
	loadingData = true;

	// console.log("loadingData true");
	indexStep = indexStepInit;
	var name = $('#searchBarText').val();
	if(typeof indexMin == "undefined") indexMin = 0;
	if(typeof indexMax == "undefined") indexMax = indexStep;
	// currentIndexMin = indexMin;
	// currentIndexMax = indexMax;
	if(indexMin == 0 && indexMax == indexStep) {
		//totalData = 0;
		mapElements = new Array();
	}
	// if(name.length>=3 || name.length == 0){
	var locality = "";
	autoCompleteSearchSimply(name, locality, indexMin, indexMax);
}

function autoCompleteSearchSimply(name, locality, indexMin, indexMax){
	 // mylog.log("autoCompleteSearchSimply", name, locality, indexMin, indexMax);
	var levelCommunexionName = { 
		1 : "INSEE",
		2 : "CODE_POSTAL_INSEE",
		3 : "DEPARTEMENT",
		4 : "REGION"
	};
	//var searchBy = levelCommunexionName[levelCommunexion];


	//To merge Category and tags which are finally all tags
	var searchTagGlobal = [];
	if (undefined !== nwVar.searchTag && nwVar.searchTag.length) $.merge(searchTagGlobal,nwVar.searchTag) ;
	if (undefined !== nwVar.searchCategory && nwVar.searchCategory.length) $.unique($.merge(searchTagGlobal,nwVar.searchCategory)) ;
	 // mylog.log("searchTagGlobal : "+searchTagGlobal);

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

	 // mylog.log("searchTagsSimply", searchTagsSimply);

	var data = {
		"name" : name,
		"scope" : (notNull(networkJson.scope) ? networkJson.scope : null),
		"searchType" : nwVar.searchType,
		"searchTag" : searchTagGlobal,
		"filtreTag" : searchTagsSimply,
		"searchLocalityNAME" : nwVar.searchLocalityNAME,
		"searchLocalityCODE_POSTAL_INSEE" : nwVar.searchLocalityCODE_POSTAL_INSEE,
		"searchLocalityDEPARTEMENT" : nwVar.searchLocalityDEPARTEMENT,
		"searchLocalityINSEE" : nwVar.searchLocalityINSEE,
		"searchLocalityREGION" : nwVar.searchLocalityREGION,
		//"searchBy" : searchBy,
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

	if(typeof networkJson.request.parent != "undefined" &&
		typeof networkJson.request.parent.id != "undefined" &&
		typeof networkJson.request.parent.type != "undefined" )
		data.parent = networkJson.request.parent;
	//console.log("loadingData true");
	loadingData = true;

	str = "<i class='fa fa-circle-o-notch fa-spin'></i>";
	$(".btn-start-search").html(str);
	$(".btn-start-search").addClass("bg-azure");
	$(".btn-start-search").removeClass("bg-dark");
	//$("#dropdown_search").css({"display" : "inline" });
	//if(indexMin > 0)
	//$("#btnShowMoreResult").html("<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...");
	//else
	//$("#dropdown_search").html("<center><span class='search-loaderr text-dark' style='font-size:20px;'><i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...</span></center>");
	if(isMapEnd){
		$.blockUI({
			message : "<div class='col-xs-12 text-center'><div class='col-md-offset-2 col-md-8 bg-white'><h1 class='homestead text-red'><span class='text-dark'>"+trad.welcomeon+"</span><br/><span>"+networkJson.skin.title+"</span><br/></h1><i class='fa fa-spin fa-circle-o-notch'></i><span class='text-dark'> "+trad.initofmap+" </span></div></div>",
		});
	}


	if( notNull(networkJson.dataSrc) ) {
		 // mylog.log("networkJson.dataSrc");
		$.ajax({
			type: "POST",
			url: baseUrl+"/" + moduleId + "/element/getdatabyurl",
			data: { url : networkJson.dataSrc , json : false},
			dataType: "json",
			error: function (data){
				 // mylog.log("error");
				mylog.dir(data);
			},
			success: function (data) { 
				 // mylog.log("data", data);

				if(notNull(data.entities)){
					var val = {
						res : []
					} ;

					$.each(data.entities, function(i, v) {
						v["id"] = i;
						val.res.push(v);
					});

					data = val ;
				}

				dataSuccess(data, indexMin, indexMax, locality);
				
			}
		});
	} else {
		$.ajax({
			type: "POST",
			url: baseUrl+"/" + moduleId + "/search/simplyautocomplete",
			data: data,
			dataType: "json",
			error: function (data){
				 // mylog.log("error");
				mylog.dir(data);
			},
			success: function(data){
				dataSuccess(data, indexMin, indexMax); 
				//geoShapeCity();
			}
		});
	}
}

function dataSuccess(data, indexMin, indexMax, locality){
	 // mylog.log("dataSuccess", data, !data.res, indexMin, indexMax, locality);
	if(!data.res) {
		toastr.error(data.content); 
	} else {
		if(data.res.length){
			var countData = 0;
			$.each(data.res, function(i, v) { if(v.length!=0){ countData++; } });

			if(typeof networkJson.request.oneElement != "undefined" && networkJson.request.oneElement == true){
				filterTags(data.filters.tags);
				filterType(data.filters.types);
				$("#divRolesMenu").removeClass("hidden");
			} else {
				$("#divRolesMenu").addClass("hidden");
			}
			
			bindAutocomplete();
			str = "";
			var city, postalCode = "";
			var mapElements = new Array();
			var htmlCO2 = "";
			htmlCO2 = directory.showResultsDirectoryHtml(data.res);
			//parcours la liste des résultats de la recherche
			countResult=Object.keys(data.res).length;
			 // mylog.log("data.res ", data.res);
			$.each(data.res, function(i, o) {
				 // mylog.log("Search ", o);
				 // mylog.log("Tags element", o.tags);
				mapElements.push(o);
				contextMapNetwork.push(o);
			}); //end each
		
			if(str == "") {
				$(".btn-start-search").html("<i class='fa fa-search'></i>");
				if(indexMin == 0){
					//ajout du footer
					var msg = trad.noresult;
					if(name == "" && notNull(locality) && locality == "") 
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
				}

				$("#dropdown_search").html(htmlCO2);
				refreshResultHeader(countResult);

				//On met à jour les filtres
				loadFilters();
				initBtnLink();
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
			} //end else (str=="")

			//signal que le chargement est terminé
			 // mylog.log("test");
			loadingData = false;
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
	geoShapeCity();
	$.unblockUI();
}

function tagActivedUpdate(checked, tag, parent){
	 // mylog.log("tagActivedUpdate", checked, tag, parent,tagsActived, typeof tagsActived[parent], (typeof tagsActived[parent] == "undefined"));
	if(checked== false){
		tagsActived[parent].splice($.inArray(tag, tagsActived[parent]),1);
	}
	else{
		if(typeof tagsActived[parent] == "undefined"){
			tagsActived[parent] = [];
		}
		tagsActived[parent].push(tag);
	}
}
function refreshResultHeader(count){
	if(count=="loading"){
		str='<h4 style="font-weight:300" class=" text-dark padding-10">'+
			'<i class="fa fa-spin fa-circle-o-notch"></i><br>'+trad.currentlyloading+'...'+
		  '</h4>';
	}
	else{             
		if(count == 0)      totalDataGSMSG = "<i class='fa fa-ban'></i> "+trad.noresult;
        else if(count == 1) totalDataGSMSG = count + " "+trad.result;   
        else if(count > 1)  totalDataGSMSG = count + " "+trad.results;   
        str='<h4 style="font-weight:300" class=" text-dark padding-10">'+
			totalDataGSMSG+
		'</h4>';
	}
	$("#dropdown_search_result").html(str);
}
function chargement(){
	$(".searchEntityContainer").hide(700);
	refreshResultHeader("loading");
	setTimeout(function(){ updateMap(); }, 1000);
}

function bindAutocomplete(){
	$(".tagFilterAuto").off().click(function(e){
		 // mylog.log(".tagFilter",  $(this));
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
		 // mylog.log(".rolesFilterAuto", checked, role);
		rolesActivedUpdate(checked, role);
		chargement();
	});

	$(".classifiedsFilterAuto").off().click(function(e){
		var checked = false ;
		if($(this).hasClass( "active" ) == false){
			$(this).addClass("active");
			checked = true;
		}else{
			$(this).removeClass("active");
		}
		var role = $(this).data("filtre");
		mylog.log(".classifiedsFilterAuto", checked, role);
		classifiedsActivedUpdate(checked, role);
		chargement();
	});
}



function loadFilters(){
	 // mylog.log("loadFilters");
	var displayLimit = 10;
	var classToHide = "";
	var i = 0;
	var breadcum  = "";
	//All desacactivate
	$('.villeFilter').prop("checked", false );
	$('.tagFilter').prop("checked", false );
	$('.categoryFilter').prop("checked", false );

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

	$(".tagFilter").click(function(e){
		 // mylog.log(".tagFilter",  $(this));
		 // mylog.log("label :", $(this).hasClass( "active" ));

		var checked = false;
		if($(this).hasClass( "active" ) == false){
			$(this).addClass("active");
			checked = true;
			
		}else{
			$(this).removeClass("active");
		}

		var filtre = $(this).data("filtre");
		var parent = $(this).data("parent");
		 // mylog.log("parent",parent);
		 // mylog.log("filtre",filtre);
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
		 // mylog.log(".villeFilter",  $(this));
		var checked = false;
		if($(this).hasClass( "active" ) == false){
			$(this).addClass("active");
			checked = true;
		}else{
			$(this).removeClass("active");
		}

		var ville = $(this).data("value");
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
	 // mylog.log("breadcrumGuide", newLevel, level, url);
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
	 // mylog.log("getAjaxFiche Network", url, breadcrumLevel, isMapEnd);
	$("#ficheInfoDetail").empty();
	if(location.hash == ""){
		history.pushState(null, "New Title", '?src='+networkParams+url);
	}
	
	if(isMapEnd){
		pathTitle= trad.cartography;
		pathIcon = "map-marker";
		showMapNetwork();
	}else{
		pathTitle= trad.list;
		pathIcon = "list";
	}
	allReadyLoad = true;
	urlHash=url;
	pageView=false;
	if(urlHash.indexOf("page") >= 0){
		 // mylog.log("here");
		if(urlHash.indexOf("#@") != -1)
			url= "/app/"+urlHash.replace( "#@","" ).replace( /\./g,"/" );
		else
			url= "/app/"+urlHash.replace( "#","" ).replace( /\./g,"/" );

				 // mylog.log("url", url);
				$("#repertory").hide( 700 );
				$(".main-menu-left").hide( 700 );
				$("#ficheInfoDetail").show( 700 );
				$(".main-col-search").removeClass("col-md-10 col-md-offset-2 col-sm-9 col-sm-offset-3").addClass("col-md-12 col-sm-12");
				
				$.blockUI({
					message : "<h4 style='font-weight:300' class='text-dark padding-10'><i class='fa fa-spin fa-circle-o-notch'></i><br>"+trad.currentlyloading+" ...</span></h4>"
				});
				 // mylog.log("networkParams", networkParams);
				
				getAjax('#ficheInfoDetail', baseUrl+'/'+moduleId+url+'?src='+networkParams, function(){
					$.unblockUI();
					 // mylog.log(contextData);
					//Construct breadcrumb
					if(breadcrumLevel != false){
						$html= '<i class="fa fa-chevron-right fa-1x text-red breadcrumChevron" style="padding: 0px 10px 0px 10px;" data-value="'+breadcrumLevel+'"></i>'+'<a href="javascript:;" onclick="breadcrumGuide('+breadcrumLevel+',\''+urlHash+'\')" class="breadcrumAnchor text-dark" data-value="'+breadcrumLevel+'">'+contextData.name+'</a>';
						$("#breadcrum").append($html);
					}
				},"html");
	} else if( 	urlHash.indexOf("default.view") < 0 &&
				urlHash.indexOf("news") < 0 &&
				urlHash.indexOf("network") < 0 && 
				urlHash.indexOf("invite") < 0 ){
		 // mylog.log("here2");
		pageView=true;
		var urlSplit = "";
		if(urlHash.indexOf("#@") != -1)
			urlSplit=urlHash.replace( "#@","" ).split(".");
		else
			urlSplit=urlHash.replace( "#","" ).split(".");
		 // mylog.log("urlSplit", urlSplit);
		if(typeof urlSplit == "string")
			slug=urlSplit;
		else
			slug=urlSplit[0];
		$.ajax({
  			type: "POST",
  			url: baseUrl+"/"+moduleId+"/slug/getinfo/key/"+slug,
  			dataType: "json",
  			success: function(data){
		  		if(data.result){
		  			var urlHash="#page.type."+data.contextType+".id."+data.contextId;
		  		}
		  		url= "/app/"+urlHash.replace( "#","" ).replace( /\./g,"/" );
				 // mylog.log("url", url);
				$("#repertory").hide( 700 );
				$(".main-menu-left").hide( 700 );
				$("#ficheInfoDetail").show( 700 );
				$(".main-col-search").removeClass("col-md-10 col-md-offset-2 col-sm-9 col-sm-offset-3").addClass("col-md-12 col-sm-12");
				
				$.blockUI({
					message : "<h4 style='font-weight:300' class='text-dark padding-10'><i class='fa fa-spin fa-circle-o-notch'></i><br>"+trad.currentlyloading+" ...</span></h4>"
				});
				 // mylog.log("networkParams", networkParams);
				
				getAjax('#ficheInfoDetail', baseUrl+'/'+moduleId+url+'?src='+networkParams, function(){
					$.unblockUI();
					 // mylog.log(contextData);
					//Construct breadcrumb
					if(breadcrumLevel != false){
						$html= '<i class="fa fa-chevron-right fa-1x text-red breadcrumChevron" style="padding: 0px 10px 0px 10px;" data-value="'+breadcrumLevel+'"></i>'+'<a href="javascript:;" onclick="breadcrumGuide('+breadcrumLevel+',\''+urlHash+'\')" class="breadcrumAnchor text-dark" data-value="'+breadcrumLevel+'">'+contextData.name+'</a>';
						$("#breadcrum").append($html);
					}
				},"html");
			}
		});
	}
}


function reverseToRepertory(){
	 // mylog.log("reverseToRepertory", isMapEnd);
	if(isMapEnd)
		showMapNetwork();
	updateMap();
	$("#ficheInfoDetail").hide( 700 );
	$("#dropdown_search").show();
	$(".main-col-search").removeClass("col-md-12 col-sm-12").addClass("col-md-10 col-md-offset-2 col-sm-9 col-sm-offset-3");
	//$("#dropdown_search").show();
	$("#repertory").show();
	$(".main-menu-left").show( 700 );
	$html = '<a href="javascript:;" onclick="breadcrumGuide(0)" class="breadcrumAnchor text-dark" style="font-size:20px;">'+trad.list+'</a>';
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
function and(tags,tagList) {
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
function or(tags,tagList) {
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

function cityActivedUpdate(checked, city){
	 // mylog.log("cityActivedUpdate", checked, city);
	if(checked== false){
		citiesActived.splice($.inArray(city.toUpperCase(), citiesActived),1);
	} else {
		citiesActived.push(city.toUpperCase());
	}
}

function  typeActivedUpdate(checked, type){
	 // mylog.log("typeActivedUpdate", checked, type);
	if(checked== false){
		typesActived.splice($.inArray(type, typesActived),1);
	} else {
		typesActived.push(type);
	}
}

function  rolesActivedUpdate(checked, role){
	 // mylog.log("rolesActivedUpdate", checked, role);
	if(checked== false){
		rolesActived.splice($.inArray(role, rolesActived),1);
	} else {
		rolesActived.push(role);
	}
}

function  classifiedsActivedUpdate(checked, role){
	 // mylog.log("rolesActivedUpdate", checked, role);
	if(checked== false){
		classifiedsActived.splice($.inArray(role, classifiedsActived),1);
	} else {
		classifiedsActived.push(role);
	}
}

function addTab(tab, tab2){
	 // mylog.log("addTab", tab, tab2);
	var res = [];
	$.each(tab2, function(key2, value2){
		 // mylog.log("addTab value2 ", key2, value2);
		$.each(tab, function(key1, value1){
			 // mylog.log("addTab key1 ", key1, value1);
			var t = value1.slice();
			t.push(value2);
			res.push(t);
		});
	});
	 // mylog.log("addTab res", res);
	return res ;
}

function orAndAnd(allFiltres){
	 // mylog.log("orAndAnd", allFiltres);
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
	 // mylog.log("orAndAnd Res", res);
	return res ;
}

function getAllTags(allFiltres){
	 // mylog.log("getAllTags", allFiltres);
	var res = [];
	$.each(allFiltres, function(keyF, valueFiltre){
		if(valueFiltre.length > 0){
			$.each(valueFiltre, function(key, value){
				res.push(value);
			});
		}
	});
	 // mylog.log("getAllTags Res", [res]);
	return [res] ;
}

function andAndOr(allFiltres){
	 // mylog.log("andAndOr", allFiltres);
	var res = [];
	$.each(allFiltres, function(keyF, valueFiltre){
		if(valueFiltre.length > 0){
			res.push(valueFiltre);
		}
	});
	 // mylog.log("andAndOr Res", res);
	return res ;
}

function updateMap(){
	mylog.log("updateMap", tagsActived, disableActived, classifiedsActived, classifiedsActived.length);
	$(".searchEntityContainer").hide();
	var params = ((typeof networkJson.filter == "undefined" || typeof networkJson.filter.paramsFiltre == "undefined") ? null :  networkJson.filter.paramsFiltre);
	var test = [];
	var verb = "and";
	var elementNetwork = [];
	if(typeof networkJson.request.oneElement != "undefined" && typeof networkJson.request.sourceKey != "undefined" && networkJson.request.oneElement == true){
		
		 elementNetwork = networkJson.request.sourceKey[0].split("@");
		  // mylog.log("elementNetwork", elementNetwork);
	}

	if ( params != null && ( (params.conditionBlock == "and" || typeof params.conditionBlock == "undefined" ) && params.conditionTagsInBlock == "and" ) )
		test = getAllTags(tagsActived);
	else if ( params != null && ( (params.conditionTagsInBlock == "or" || typeof params.conditionTagsInBlock == "undefined" ) && params.conditionBlock == "or" ) ) {
		test = getAllTags(tagsActived);
		verb = "or";
	} else if ( params != null && ( (params.conditionBlock == "or" || typeof params.conditionBlock == "undefined" ) && 
			(params.conditionTagsInBlock == "and" || typeof params.conditionTagsInBlock == "undefined") ) ) {
		test = andAndOr(tagsActived);
	} else
		test = orAndAnd(tagsActived);

	mylog.log("updateMap testNetwork", test);

	 // mylog.log("searchValNetwork", searchValNetwork);
	var filteredList = [];
	var add = false;
	if(test.length > 0){
		$.each(test,function(keyTags,tags){
			$.each(contextMapNetwork,function(k,v){
				if(typeof v.tags != "undefined" && v.tags != null)
					add = ( (verb == "and") ? and( tags, v.tags ) : or( tags, v.tags ) );
				else
					add= false;
				 // mylog.log("configFiltre", add, disableActived, v.disabled, v.address.addressLocality, citiesActived, typesActived, rolesActived);
				if(	add && 
					( 	disableActived == false || 
						(disableActived == true && typeof v.disabled != "undefined" && v.disabled == true) ) && 
					( citiesActived.length == 0  || 
						(	typeof v.address != "undefined" && 
							typeof v.address.addressLocality != "undefined" && 
							$.inArray( v.address.addressLocality.toUpperCase(), citiesActived ) >= 0  ) ) &&
					( typesActived.length == 0  || 
						(	typeof v.typeSig != "undefined" && 
							$.inArray( v.typeSig, typesActived ) >= 0  ) ) &&
					( rolesActived.length == 0  || 
						(isLinks(v, elementNetwork[0]) ) ) && 

					( classifiedsActived.length == 0  || 
						(isClassifiedsActived(v, elementNetwork[0]) ) ) && 

					( 	searchValNetwork.length == 0 || 
						( 	v.name.search( new RegExp( searchValNetwork, "i" ) ) >= 0  ) ) )  {
					 // mylog.log("v.tags", v.tags);
					filteredList = addTabMap(v, filteredList);
					$(".container_"+v.type+"_"+v.id).show();
				}
			});
		});
	}else{
		if( disableActived == true || citiesActived.length > 0 || 
			typesActived.length > 0 || rolesActived.length > 0 || classifiedsActived.length > 0 || 
			searchValNetwork.length > 0)  {
			$.each(contextMapNetwork,function(k,v){
				if(	( 	disableActived == false || 
						(disableActived == true && typeof v.disabled != "undefined" && v.disabled == true) ) && 
					( citiesActived.length == 0  || 
						(	typeof v.address != "undefined" && 
							typeof v.address.addressLocality != "undefined" && 
							$.inArray( v.address.addressLocality.toUpperCase(), citiesActived ) >= 0 ) ) &&
					( typesActived.length == 0  || 
						(	typeof v.typeSig != "undefined" && 
							$.inArray( v.typeSig, typesActived ) >= 0  ) ) &&
					( rolesActived.length == 0  || 
						(isLinks(v, elementNetwork[0]) ) )  &&

					( classifiedsActived.length == 0  || 
						(isClassifiedsActived(v, elementNetwork[0]) ) ) && 

					( 	searchValNetwork.length == 0 || 
						( 	v.name.search( new RegExp( searchValNetwork, "i" ) ) >= 0 ) ) ) {
					filteredList = addTabMap(v, filteredList);
				}
			});
		}else{
			filteredList = contextMapNetwork;
		}
	}
	$.each(filteredList, function(e,v){
		$(".contain_"+v.type+"_"+v.id).show(700);
	});

	countResult=filteredList.length;
	refreshResultHeader(countResult);
	 // mylog.log("filteredList", filteredList);
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
	 // mylog.log("isLinks", element, id);
	var res = false ;
	 // mylog.log("rolesActived", rolesActived);
	if(rolesActived.length){
		$.each(rolesActived,function(k,v){
			 // mylog.log(v, element);
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

function isClassifiedsActived(element, id){
	mylog.log("isClassifiedsActived", element, id);
	var res = false ;

	if(classifiedsActived.length){
		$.each(classifiedsActived,function(k,v){
			 // mylog.log(v, element);
			if(v == element.typeClassified ){
					res = true ;
					return true;
			}
		});
	}
	return res ;
}

function filterTags(tags){
	 // mylog.log("filterTags", tags);
	if(typeof tags != "undefined" ){
		str = '<div class="panel-heading">'+
	          '<h4 class="panel-title" onclick="manageCollapse(\'tags\', \'false\')">'+
	            '<a data-toggle="collapse" href="#tags" style="color:#719FAB" data-label="tags">'+trad.alltags+ 
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
	 // mylog.log("filterType", types);
	if(typeof tags != "undefined" ){
		str = '<div class="panel-heading">'+
	          '<h4 class="panel-title" onclick="manageCollapse(\'types\', \'false\')">'+
	            '<a data-toggle="collapse" href="#types" style="color:#719FAB" data-label="types">'+trad.alltypes+  
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

function geoShapeCity(){
	 // mylog.log("geoShapeCity");

	if(typeof networkJson.skin.geoShape != "undefined" && networkJson.skin.geoShape == true){
		var data = null
		if(typeof networkJson.request.searchLocalityNAME != "undefined")
			data = { name : networkJson.request.searchLocalityNAME };
		else if(typeof networkJson.request.searchLocalityINSEE != "undefined")
			data = { insee : networkJson.request.searchLocalityINSEE };
		else if(typeof networkJson.request.searchLocalityID != "undefined")
			data = { id : networkJson.request.searchLocalityID } ;
		 // mylog.log("geoShapeCity", data);
		if(data != null){
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/city/getgeoshape/",
				data: data,
				dataType: "json",
				success: function(data){
					//var geoShape = [] ;
					$.each(data,function(k,v){
	          			if(typeof v.geoShape != "undefined"){
	          				var geoShape = Sig.inversePolygon(v.geoShape.coordinates[0]);
	          				Sig.addPolygon(geoShape);
	          				//geoShape = geoShape.concat(Sig.inversePolygon(v.geoShape.coordinates[0]))
							// Sig.showPolygon(geoShape);
							setTimeout(function(){
								//Sig.map.fitBounds(geoShape);
								Sig.map.invalidateSize();
							}, 1500);
	          			}
						
	          		});
				}
			});
		}
	}
	
	
}

</script>
