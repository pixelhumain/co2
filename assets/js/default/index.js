
function startNewCommunexion(country){ 

	clearTimeout(timeoutSearch);

	var locality = $('#searchBarPostalCode').val();
	locality = locality.replace(/[^\w\s-']/gi, '');

	$(".search-loader").html("<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...");

	var data = {"name" : name, "locality" : locality, "country" : country, "searchType" : [ "cities" ], "searchBy" : "ALL"  };
    var countData = 0;
    var oneElement = null;
	mylog.log(data);
    $.blockUI({
		message : "<h1 class='homestead text-dark'><i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...</span></h1>"
	});

    $.ajax({
      type: "POST",
          url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
          data: data,
          dataType: "json",
          error: function (data){
            mylog.log("error");
          	mylog.dir(data);
            $(".search-loader").html("<i class='fa fa-ban'></i> "+trad.noresult);
          },
          success: function(data){
          	mylog.log("success, try to load sig");
          	mylog.dir(data);
            if(!data){
              toastr.error(data.content);
            }else{


            $.each(data, function(i, v) {
	            if(v.length!=0){
	              $.each(v, function(k, o){ countData++; });
	            }
	        });

	        if(countData == 0){
	        	$(".search-loader").html("<i class='fa fa-ban'></i> "+trad.noresult);
	        }else{
	        	$(".search-loader").html("<i class='fa fa-crosshairs'></i> Sélectionnez une commune ...");
	        	showMap(true);
	        	Sig.showMapElements(Sig.map, data);
	        	
	        }

	        $.unblockUI();

          }
          
      }
    });
}

function resizeInterface()
{
  mylog.log("resize");
  var height = $("#mapCanvasBg").height() - 55;
  $("#ajaxSV").css({"minHeight" : height});
  //$("#menu-container").css({"minHeight" : height});
  var heightDif = $("#search-contact").height() + $("#floopHeader").height() + 80 /* top */ + 0 /* bottom */;
  var menuTopHeight = $("#mainNav").height();// - $(".toolbar").height();
  
  //mylog.log("heightDif", heightDif);
  $(".floopScroll").css({"minHeight" : height-heightDif});
  $(".floopScroll").css({"maxHeight" : height-heightDif});

  height = $("#mapCanvasBg").height() - 200;
  $("#scroll-dashboard-dda").css("maxHeight", height);

  //$(".my-main-container").css("min-height", $(".sigModuleBg").height()-menuTopHeight);
  //$(".my-main-container").css("max-height", $(".sigModuleBg").height()-menuTopHeight);
  //$(".my-main-container").css("height", $(".sigModuleBg").height()-menuTopHeight);
  //$(".main-col-search").css("min-height", $(".sigModuleBg").height());
  //$("ul.notifList").css({"maxHeight" : height-heightDif});

}

function checkScroll(){
	$(".main-top-menu").animate({
 							top: 0,
 							opacity:1
					      }, 500 );
		
}

var currentScrollTop = 0;
var isMapEnd = false;
function showMap(show)
{
	if(show != false && CoSigAllReadyLoad == false){
		console.log("showMap", show, "elementsMap", Sig.preloadElementsMap);
		mapBg = Sig.loadMap("mapCanvas", initSigParams);
	    Sig.showIcoLoading(false);
	    if( typeof formInMap == "undefined" || formInMap.actived != true)
	    	Sig.showMapElements(Sig.map, Sig.preloadElementsMap, Sig.preloadIconLegende, Sig.preloadTextLegende);
	}
	
    if(mapBg == null) return;

	mylog.log("typeof SIG : ", typeof Sig);
	if(typeof Sig == "undefined") show = false;
  
	//chargement de la carte
	mylog.log("showMap");
	if(show === undefined) show = !isMapEnd;
	var mainContainer = (typeof networkJson != "undefined" && networkJson != null) ? ".my-main-container" : ".main-container" ;
	if(show){
		isMapEnd =true;
		showNotif(false);

		currentScrollTop = $('html').scrollTop();
		
		showTopMenu(true);
		if(Sig.currentMarkerPopupOpen != null){
			Sig.currentMarkerPopupOpen.fire('click');
		}
		
		$(".btn-group-map").show( 700 );
		$("#right_tool_map").show(700);
		$(".toolbar-bottom").hide(700);
		$("body").addClass("inSig");

		$(mainContainer).animate({
     							//top: -1000,
     							opacity:0,
						      }, 'slow' );

		setTimeout(function(){ $(mainContainer).hide(); }, 100);
		var timer = setTimeout("Sig.constructUI()", 1000);
		
	}else{
		isMapEnd = false;
		//hideMapLegende();

		var iconMap = "map-marker";
		if(typeof ICON_MAP_MENU_TOP != "undefined") iconMap = ICON_MAP_MENU_TOP;
		$("body").removeClass("inSig");
		$(mainContainer).animate({
     							//top: 50,
     							opacity:1
						      }, 'slow' );
		setTimeout(function(){ 
			$(mainContainer).show();
			$('html, body').stop().animate({
	            scrollTop: currentScrollTop
	        }, 500, ''); 
		}, 100);

		$(".toolbar-bottom").show(200);
	}
		
}

function setScopeValue(btn){ mylog.log("setScopeValue");
	if( typeof btn === "object" ){
		//récupère les valeurs
		inseeCommunexion = btn.attr("insee-com");
		cityNameCommunexion = btn.attr("name-com");
		cpCommunexion = btn.attr("cp-com");
		regionNameCommunexion = btn.attr("reg-com");
		countryCommunexion = btn.attr("ctry-com");
		latCommunexion = btn.attr("lat-com");
		lngCommunexion = btn.attr("lng-com");
		if(typeof(btn.attr("nbCpByInsee-com")) != "undefined"){
			nbCpbyInseeCommunexion = btn.attr("nbCpByInsee-com");
			cityInseeCommunexion = btn.attr("cityInsee-com");
		} else {
			nbCpbyInseeCommunexion = undefined;
			cityInseeCommunexion = undefined;

		}
		//var path = location.pathname;
		//setCookies();
		//definit le path du cookie selon si on est en local, ou en prod
		
		setCookies(location.pathname);
		
		$(".search-loader").html("<i class='fa fa-check'></i> Vous êtes communecté à " + cityNameCommunexion + ', ' + cpCommunexion);
		$(".lbl-btn-menu-name-city .lbl-btn-menu").html(cityNameCommunexion);// + ", " + cpCommunexion);
		
		$("#btn-geoloc-auto-menu .fa-crosshairs").attr("data-original-title", cityNameCommunexion);
		$("#btn-geoloc-auto-menu .fa-crosshairs").attr("title", cityNameCommunexion);
		$("#btn-geoloc-auto-menu").off(); //click(function(){ urlCtrl.loadByHash("#city.detail.insee." + inseeCommunexion+"."+"postalCode."+cpCommunexion) });
		$("#btn-geoloc-auto-menu").attr("href", '#city.detail.insee.' + inseeCommunexion+'.'+'postalCode.'+cpCommunexion);
		$("#btn-geoloc-auto-menu").data("hash", "#city.detail.insee." + inseeCommunexion+"."+"postalCode."+cpCommunexion);
		//mylog.log("HASHHHHHHHHHHHHHHHHHHHH", $("#btn-geoloc-auto-menu").data("hash"));
		$("#btn-menuSmall-mycity").attr("href", '#city.detail.insee.' + inseeCommunexion+"."+"postalCode."+cpCommunexion);
				
		$("#btn-citizen-council-commun").attr("href", '#rooms.index.type.cities.id.' + countryCommunexion+'_' + inseeCommunexion+'-'+cpCommunexion);

		$("#btn-citizen-council-commun").data("hash", "#rooms.index.type.cities.id." + countryCommunexion+"_" + inseeCommunexion+"-"+cpCommunexion);
				
		$("#btn-menuSmall-citizenCouncil").attr("href", '#rooms.index.type.cities.id.' + countryCommunexion+'_' + inseeCommunexion+'-'+cpCommunexion);
				
		
		if(location.hash.indexOf("#default.twostepregister") == -1)
		$("#searchBarPostalCode").val(cityNameCommunexion);

		selectScopeLevelCommunexion(levelCommunexion);

  		$(".menu-left-container .visible-communected, .menuSmall .visible-communected").show(400);
  		$(".menu-left-container .hide-communected, .menuSmall .hide-communected").hide(400);
  		
  		if(!userId)
  		$(".btn-geoloc-auto").attr("onclick", 
  			"urlCtrl.loadByHash('#rooms.index.type.cities.id.' + countryCommunexion + '_'+ inseeCommunexion + '-'+ cpCommunexion)");

  		
		Sig.clearMap();
		mylog.log("hash city ? ", location.hash.indexOf("#default.city"));
		if(location.hash == "#default.home"){
			//showLocalActorsCityCommunexion();
			urlCtrl.loadByHash("#city.detail.insee."+inseeCommunexion+".postalCode."+cpCommunexion);
		}else
		if(location.hash == "#default.directory"){
			startSearch();
		}else
		if(location.hash == "#default.agenda"){
			startSearch();
		}else
		if(location.hash == "#default.news"){
			startSearch();
			showMap(false);
		}else
		if(location.hash.indexOf("#city.detail") >= 0) {
			//showLocalActorsCityCommunexion();
			if(location.hash != "#city.detail.insee." + inseeCommunexion+"."+"postalCode."+cpCommunexion){
				urlCtrl.loadByHash("#city.detail.insee."+inseeCommunexion+".postalCode."+cpCommunexion);
			}else{
				$("#btn-communecter").html("<i class='fa fa-check'></i> COMMUNECTÉ");
	    		$("#btn-communecter").attr("onclick", "");
	    		toastr.success('Vous êtes communecté à ' + cityNameCommunexion);
    		}
			//showMap(false);
		}else
		if(location.hash.indexOf("#default.twostepregister") >= 0) {
			
			showMap(false);
			$("#tsr-commune-name-cp").html(cityNameCommunexion + ", " + cpCommunexion);

			$("#conf-commune").html(cityNameCommunexion + ", " + cpCommunexion);

			$("#TSR-load-conf-communexion").html("<h1><i class='fa fa-spin fa-circle-o-notch text-white'></i></h1>");
			showTwoStep("load-conf-communexion");
			setCookies();
			$(".btn-param-postal-code").attr("data-original-title", cityNameCommunexion + " en détail");
			//$(".btn-param-postal-code").attr("onclick", "urlCtrl.loadByHash('#city.detail.insee."+inseeCommunexion+"')");
			$(".search-loader").html("<i class='fa fa-check'></i> Vous êtes communecté : " + cityNameCommunexion + ', ' + cpCommunexion);
			$(".lbl-btn-menu-name-city .lbl-btn-menu").html(cityNameCommunexion);
			setTimeout(function(){ achiveTSRAddress(); /*showTwoStep("street");*/  }, 2000);
			//showMap(false);
		}else{
			//showLocalActorsCityCommunexion();
			urlCtrl.loadByHash("#city.detail.insee."+inseeCommunexion+".postalCode."+cpCommunexion);
		}
	}
	
  	mylog.log("setScopeValue", inseeCommunexion, cityNameCommunexion, cpCommunexion);
}

function showLocalActorsCityCommunexion(){

	urlCtrl.loadByHash("#city.detail.insee."+inseeCommunexion+".postalCode."+cpCommunexion);
	return;

	mylog.log("showLocalActorsCityCommunexion");
	var data = { "name" : "", 
 			 "locality" : inseeCommunexion,
 			 "searchType" : [ "persons", "organizations", "projects", "events", "cities" ], 
 			 "searchBy" : "INSEE",
    		 "indexMin" : 0, 
    		 "indexMax" : 500  
    		};

	setTitle("Les acteurs locaux : <span class='text-red'>" + cityNameCommunexion + ", " + cpCommunexion + "</span>","spin fa-circle-o-notch","Les acteurs locaux : " + cityNameCommunexion + ", " + cpCommunexion);

	$.blockUI({
		message : "<h1 class='homestead text-red'><i class='fa fa-spin fa-circle-o-notch'></i> " + cpCommunexion + " : Commune<span class='text-dark'>xion en cours ...</span></h1>"
	});

	showMap(true);
	
	$.ajax({
      type: "POST",
          url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
          data: data,
          dataType: "json",
          error: function (data){
             mylog.log("error"); mylog.dir(data);          
          },
          success: function(data){
            if(!data){ toastr.error(data.content); }
            else{
            	//mylog.dir(data);
            	Sig.showMapElements(Sig.map, data);
				setTitle("Les acteurs locaux : <span class='text-red'>" + cityNameCommunexion + ", " + cpCommunexion + "</span>","connect-develop","Les acteurs locaux : " + cityNameCommunexion + ", " + cpCommunexion );
				$(".search-loader").html("<i class='fa fa-check'></i> Vous êtes communecté à " + cityNameCommunexion + ', ' + cpCommunexion);
				
				toastr.success('Vous êtes communecté !<br/>' + cityNameCommunexion + ', ' + cpCommunexion);
				$.unblockUI();
            }
          }
 	});

}


var topMenuActivated = true;
function showTopMenu(show){ 

	if(typeof show == "undefined") 
		show = $("#main-top-menu").css("opacity") == 1;
	
	if(show){
		$(".main-top-menu").animate({ top: 0, opacity:1 }, 500 );
	}
	else{
		$(".main-top-menu").animate({ top: -60, opacity:0 }, 500 );
	}
}


function initFloopDrawer(){
	mylog.log("initFloopDrawer");
	//mylog.dir(myContacts);
	if(myContacts != null){
      var floopDrawerHtml = buildListContactHtml(myContacts, userId);
      $("#floopDrawerDirectory").html(floopDrawerHtml);
      initFloopScrollByType();

      //$("#floopDrawerDirectory").hide();
      if($(".tooltips").length) {
        $('.tooltips').tooltip();
      }
      $("#btnFloopClose").click(function(){
      	showFloopDrawer(false);
      });
      $(".main-col-search").mouseenter(function(){
      	showFloopDrawer(false);
      });

      bindEventFloopDrawer();
    }
}

// function initBtnScopeList(){
// 	$(".btn-scope-list").click(function(){
// 		setInputPlaceValue(this);
// 	});
// }

function setInputPlaceValue(thisBtn){
	//if(location.hash == "#default.home"){
		//$("#autoGeoPostalCode").val($(thisBtn).attr("val"));
	//}else{
		$("#searchBarPostalCode").val($(thisBtn).attr("val"));
		
		mylog.log("setInputPlaceValue")
		$("#input-communexion").show();
		//$("#searchBarPostalCode").animate({"width" : "350px !important", "padding-left" : "70px !important;"}, 200);
		setTimeout(function(){ $("#input-communexion").hide(300); }, 300);
	  	
	//}
	//$.cookie("HTML5CityName", 	 $(thisBtn).attr("val"), 	   { path : '/ph/' });
	startNewCommunexion();
}

//var communexionActivated = false;
function toogleCommunexion(init){ //this = jQuery Element
  
  if(init != true)
  communexionActivated = !communexionActivated;
	
  mylog.log("communexionActivated", communexionActivated);
  if(communexionActivated){
    //btn.removeClass("text-red");
    //btn.addClass("bg-red");
    $(".btn-activate-communexion, .btn-param-postal-code").removeClass("text-red");
    $(".btn-activate-communexion, .btn-param-postal-code").addClass("bg-red");
    $("#searchBarPostalCode").val(cityNameCommunexion);

    if(inseeCommunexion != "")
    	$(".search-loader").html("<i class='fa fa-check'></i> Vous êtes communecté à " + cityNameCommunexion + ', ' + cpCommunexion);
				
   // $("#searchBarPostalCode").animate({"width" : "0px !important", "padding-left" : "51px !important;"}, 200);
    //$(".lbl-scope-list").html("<i class='fa fa-check'></i> " + cityNameCommunexion.toLowerCase() + ", " + cpCommunexion);
    selectScopeLevelCommunexion(levelCommunexion);
    $(".lbl-scope-list").show(400);
    mylog.log("inseeCommunexion", inseeCommunexion);
    //setScopeValue(inseeCommunexion);
    //showInputCommunexion();
  }else{
    $(".btn-activate-communexion, .btn-param-postal-code").addClass("text-red");
    $(".btn-activate-communexion, .btn-param-postal-code").removeClass("bg-red");
    //$("#searchBarPostalCode").animate({"width" : "350px !important", "padding-left" : "70px !important;"}, 200);
    
    $(".search-loader").html("<i class='fa fa-times'></i> Communection désactivée (" + cityNameCommunexion + ', ' + cpCommunexion + ")");
				
    $(".lbl-scope-list").hide(400);
    $("#searchBarPostalCode").val("");
  }
}

function initBtnToogleCommunexion(){
	toogleCommunexion(true);
}

function showInputCommunexion(){
	clearTimeout(timeoutCommunexion);
	mylog.log("showCommunexion");
	$("#searchBarPostalCode").css({"width" : "0px !important", "padding-left" : "51px !important;"}, 200);

	if(communexionActivated)
	$("#searchBarPostalCode").animate({"width" : "350px !important", "padding-left" : "70px !important;"}, 200 );
	
	$("#input-communexion").show(300);
	//$(".main-col-search").animate({ opacity:0.3 }, 200 );
	$(".hover-info,.hover-info2").hide();
}

//niv 1 : city
//niv 2 : CP
//niv 3 : department
//niv 4 : region
//niv 4 : pays / global / tout
var levelCommunexion = 1;
function selectScopeLevelCommunexion(level){

	//var department = "";
	var department = inseeCommunexion;
	mylog.log("selectScopeLevelCommunexion", countryCommunexion, $.inArray(countryCommunexion, ["RE", "NC","GP","GF","MQ","YT","PM"]));

	if($.inArray(countryCommunexion, ["RE", "NC","GP","GF","MQ","YT","PM"]) >= 0){
		department = cpCommunexion.substr(0, 3);
	}else{
		department = cpCommunexion.substr(0, 2);
	}

	var change = (level != levelCommunexion);

	$(".btn-scope").removeClass("selected");
	$(".btn-scope-niv-"+level).addClass("selected");
	levelCommunexion = level;

	if(level == 1) endMsg = "à " + cityNameCommunexion + ", " + cpCommunexion;
	if(level == 2) {
		if(typeof(cityInseeCommunexion)!="undefined")
			endMsg = "à la ville de " + cityInseeCommunexion;
		else
			endMsg = "au code postal " + cpCommunexion;
	}
	if(level == 3) endMsg = "au département " + department;
	//if(level == 3) endMsg = "au département ";
	if(level == 4) endMsg = "à votre région " + regionNameCommunexion;
	if(level == 5) endMsg = "à l'ensemble du réseau";

	if(change){
		toastr.success('Les données sont maintenant filtrées par rapport ' + endMsg);
		$('.search-loader').html("<i class='fa fa-check'></i> Vous êtes connecté " + endMsg)
	}

	
	if(level == 1) endMsg = cityNameCommunexion + ", " + cpCommunexion;
	if(level == 2){ 
		if(typeof(cityInseeCommunexion)!="undefined")
			endMsg = cityInseeCommunexion;
		else
			endMsg = cpCommunexion;
	}
	//if(level == 3) endMsg = "Département " + department;
	if(level == 3) endMsg = "Département " + department;
	if(level == 4) endMsg = "Votre région " + regionNameCommunexion;
	if(level == 5) endMsg = "Tout le réseau";
	
	if(!communexionActivated)
    toogleCommunexion();

	$(".lbl-scope-list").html("<i class='fa fa-check'></i> " + endMsg);

	$(".btn-scope-niv-5").attr("data-original-title", "Niveau 5 - Tout le réseau");
	$(".btn-scope-niv-4").attr("data-original-title", "Niveau 4 - Région " + regionNameCommunexion);
	$(".btn-scope-niv-3").attr("data-original-title", "Niveau 3 - Département " + department);
	//$(".btn-scope-niv-3").attr("data-original-title", "Niveau 3 - Département ");
	if(typeof(cityInseeCommunexion)!="undefined"){
		$(".btn-scope-niv-2").attr("data-original-title", "Niveau 2 - Ville entière : " + cityInseeCommunexion);
	}
	else{
		$(".btn-scope-niv-2").attr("data-original-title", "Niveau 2 - Code postal : " + cpCommunexion);
	}
	$(".btn-scope-niv-1").attr("data-original-title", "Niveau 1 - " + cityNameCommunexion + ", " + cpCommunexion);
	$('.tooltips').tooltip();

	if(typeof startSearch == "function")
	startSearch();
}

function setCookies(){ 
	mylog.log("setCookies");
	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+"/element/getCommunexion/",
		dataType: "json",
		success: function(data){
			communexion = data ;
		}
	});
}