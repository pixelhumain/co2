
function scopeExists(scopeValue){
	return typeof myMultiScopes[scopeValue] != "undefined";
}

function saveMultiScope(){ 
	mylog.log("saveMultiScope() try - userId = ", userId); 
	mylog.dir(myMultiScopes);
	hideSearchResults();
	if(userId != null && userId != ""){
		if(!notEmpty(myMultiScopes)) myMultiScopes = {};
		$.ajax({
			type: "POST",
			url: baseUrl+"/"+moduleId+"/person/updatemultiscope",
			data: {"multiscopes" : myMultiScopes},
			dataType: "json",
			success: function(data){
				mylog.log("updatemultiscope success");	    		
			},
			error: function(error){
				mylog.log("Une erreur est survenue pendant l'enregistrement des scopes");
			}
		});
	}

	showCountScope();
	//rebuildSearchScopeInput();
	setTimeout(function(){ rebuildSearchScopeInput() }, 1000);
	saveCookieMultiscope();
}
function saveCookieMultiscope(){ 
	mylog.log("saveCookieMultiscope", typeof myMultiScopes, myMultiScopes);
	$.cookie('multiscopes',   	JSON.stringify(myMultiScopes), { expires: 365, path: location.pathname });
	/*if(location.hash.indexOf("#city.detail")==0)
		urlCtrl.loadByHash("#default.live");*/
}

function autocompleteMultiScope(){
	var scopeValue = $('#input-add-multi-scope').val();
	var countryCode = $('#select-country').val();
	$("#dropdown-multi-scope-found").html("<li><i class='fa fa-refresh fa-spin'></i></li>");
	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+"/city/autocompletemultiscope",
		data: {
				type: currentScopeType, 
				scopeValue: scopeValue,
				countryCode: countryCode
		},
		dataType: "json",
		success: function(data){
			mylog.log("autocompleteMultiScope() success");
			mylog.dir(data);
			$("#dropdown-multi-scope-found").html(trad.noresult);
			html="";
			var allCP = new Array();
			var allCities = new Array();
			$.each(data.cities, function(key, value){
				if(currentScopeType == "city") { //mylog.log("in scope city");
					//val = value.country + '_' + value.insee;
					val = key;
					lbl = (typeof value.name!= "undefined") ? value.name : ""; //value.name ;
					lblList = lbl + ((typeof value.level3Name!= "undefined") ? " (" +value.level3Name + ")" : "");
					html += '<li><a href="javascript:;" class="addScope" data-val="'+val+'" data-lbl="'+lbl+'" >'+lblList+'</a></li>';

				};
				if(currentScopeType == "cp") { 
					$.each(value.postalCodes, function(key, valueCP){ //mylog.log(allCities);
						val = valueCP.postalCode;
						lbl = valueCP.postalCode ;
						lblList = valueCP.name + ", " +valueCP.postalCode ;
						html += '<li><a href="javascript:;" class="addScope" data-val="'+val+'" data-lbl="'+lbl+'" >'+lblList+'</a></li>';
					});
				}; 
				
				if(currentScopeType == "zone"){
					val = key;
					lbl = (typeof value.name!= "undefined") ? value.name : ""; 
					lblList = lbl + " (" +value.countryCode + ")";
					level = value.level[0];
					html += '<li><a href="javascript:;" class="addScope" data-level="'+level+'" data-val="'+val+'" data-lbl="'+lbl+'" >'+lblList+'</a></li>';

				}
			});
			if(html != "")
			$("#dropdown-multi-scope-found").html(html);
			$("#dropdown-multi-scope-found").mouseleave(function(){
				$(this).hide();
			});

			$(".addScope").click(function(){
				addScopeToMultiscope($(this).data("val"), $(this).data("lbl"), $(this).data("level"));
			});
			
		},
		error: function(error){
			$("#dropdown-multi-scope-found").html("error");
			mylog.log("Une erreur est survenue pendant autocompleteMultiScope");
		}
	});
}
/**********************************************/
function loadMultiScopes(){
	mylog.log("loadMultiScopes");
	$.each(myMultiScopes, function(key, value){
		showScopeInMultiscope(key);
	});
	//bindCommunexionScopeEvents();
	showCountScope();
	saveCookieMultiscope();
}

function showCountScope(){
	mylog.log("showCountScope");
	var count = 0; 
	var types = new Array("city", "cp", "level1", "level2", "level3", "level4");
	//mylog.log("showCountScope");
	//mylog.dir(myMultiScopes);
	$.each(myMultiScopes, function(key, value){
		if(value.active==true) count++;
		//mylog.log(types.indexOf(value.type), value.type);

		var levelType = ( (value.type == "zone") ? "level"+value.level : value.type ) ;

		if(types.indexOf(levelType)>-1)
			types.splice(types.indexOf(levelType), 1);
	});
	$.each(types, function(key, value){
		$("#multi-scope-list-"+value).hide();
	});
	$(".scope-count").html(count);
	//showTagsScopesMin(".list_tags_scopes");
	showEmptyMsg();
}
function selectAllScopes(select){
	if(typeof select == "undefined"){ select = true;
		$.each(myMultiScopes, function(key, value){
			 if(value.active) select = false;
		});
	}
	$.each(myMultiScopes, function(key, value){
		 toogleScopeMultiscope(key, select);
	});
	saveMultiScope();
}
function showScopeInMultiscope(scopeValue){ 
	mylog.log("showScopeInMultiscope()", scopeValue);
	var html = "";
	if(scopeExists(scopeValue)){
		var scope = myMultiScopes[scopeValue];
		mylog.log("scope", scope);
		if(typeof scope.name == "undefined") scope.name = scopeValue;
		var faActive = (myMultiScopes[scopeValue].active == true) ? "check-circle" : "circle-o";
		var classDisable = (myMultiScopes[scopeValue].active == false) ? "disabled" : "";
		html = 
		'<span class="item-scope-input bg-red item-scope-'+scope.type+' '+classDisable+'" data-scope-value="'+scopeValue+'">' +
				'<a href="javascript:" class="item-scope-checker tooltips"' +
					'data-toggle="tooltip" data-placement="bottom" ' +
					'title="Activer/Désactiver" data-scope-value="'+scopeValue+'">' +
					'<i class="fa fa-'+faActive+'"></i>' +
				'</a>' +
				'<span class="item-scope-name" >'+scope.name+'</span>' +
				'<a href="javascript:" class="item-scope-deleter tooltips"' +
					'data-toggle="tooltip" data-placement="bottom" ' +
					'title="Supprimer" data-scope-value="'+scopeValue+'">' +
					'<i class="fa fa-times"></i>' +
			'</a>' +
		'</span>';

		var levelType = ( (scope.type == "zone") ? "level"+scope.level : scope.type ) ;
		mylog.log("levelType", levelType, "#multi-scope-list-"+levelType);
		$("#multi-scope-list-"+levelType).append(html);
		$("#multi-scope-list-"+levelType).show();

		if(actionOnSetGlobalScope=="save")
			$("#scopeListContainerForm").html(html);
		$(".item-scope-checker").off().click(function(){ toogleScopeMultiscope( $(this).data("scope-value")) });
		$(".item-scope-deleter").off().click(function(){ deleteScopeInMultiscope( $(this).data("scope-value")); });
		//showMsgInfoMultiScope("Le scope a bien été ajouté", "success");
	}else{
		html = "";
		//showMsgInfoMultiScope("showScopeInMultiscope error : ce lieu n'existe pas - " + scopeValue, "error");
	}
	
	$(".tooltips").tooltip();
}

//scopeValue est la valeur utilisée pour la recherche
//scopeName est la valeur affichée
function addScopeToMultiscope(scopeValue, scopeName, scopeLevel){
	mylog.log("addScopeToMultiscope", scopeValue, scopeName);
	if(scopeValue == "") return;
	if(!scopeExists(scopeValue)){ 
		mylog.log("adding", scopeValue);
		var scopeType = currentScopeType;
		myMultiScopes[scopeValue] = { name: scopeName, active: true, type: scopeType };
		if(notEmpty(scopeLevel)){
			if(scopeLevel == "1")
				scopeType = "level1";
			else if(scopeLevel == "2")
				scopeType = "level2";
			else if(scopeLevel == "3")
				scopeType = "level3";
			else if(scopeLevel == "4")
				scopeType = "level4";
			myMultiScopes[scopeValue].type = scopeType ;
			myMultiScopes[scopeValue].level = scopeLevel ;
		}
		//myMultiScopes[scopeValue].type = scopeType ;
		mylog.log("myMultiScopes")
		//alert();
		showScopeInMultiscope(scopeValue);
		$("#input-add-multi-scope").val("");
		saveMultiScope();
		showTagsScopesMin();
		bindCommunexionScopeEvents();
	}else{
		showMsgInfoMultiScope("Ce lieu est déjà dans votre liste", "info");
	}
	$("#dropdown-multi-scope-found").hide();
}


function deleteScopeInMultiscope(scopeValue){ mylog.log("deleteScopeInMultiscope(scopeValue)", scopeValue);
	if(scopeExists(scopeValue)){
		delete myMultiScopes[scopeValue];
		$("[data-scope-value=\""+scopeValue+"\"]").remove();
		saveMultiScope();
	}
	//mylog.dir(myMultiScopes);
}

function toogleScopeMultiscope(scopeValue){ mylog.log("toogleScopeMultiscope(scopeValue)", scopeValue);
	if(scopeExists(scopeValue)){
		myMultiScopes[scopeValue].active = !myMultiScopes[scopeValue].active;
		
		if(typeof selected == "undefined") saveMultiScope();
		else myMultiScopes[scopeValue].active = selected;
		
		/*if(myMultiScopes[scopeValue].active){
			$("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-circle-o");
			$("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-check-circle");
			$("[data-scope-value='"+scopeValue+"'].item-scope-input").removeClass("disabled");
		}else{
			$("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-circle-o");
			$("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-check-circle");
			$("[data-scope-value='"+scopeValue+"'].item-scope-input").addClass("disabled");
		}*/
		console.log("before rebuildSearchScopeInput from toogleScope");
		 //rebuildSearchScopeInput();
		 setTimeout(function(){ rebuildSearchScopeInput() }, 1000);
	}else{
		//showMsgInfoMultiScope("Ce scope n'existe pas", "danger");
	}
}

function getMultiScopeList(){ return myMultiScopes; }


function getLocalityForSearch(){

	if(typeof communexion.state == "undefined") communexion.state = false;

	mylog.log("getLocalityForSearch", $.cookie('communexionActivated'), communexion.state);
	if(communexion.state == true ){
	  var searchLocality = {}
	  searchLocality[communexion.currentValue] = { type : communexion.currentLevel, 
													name : communexion.currentName,
													active : true };
	}else{
	  var searchLocality = getMultiScopeForSearch();
	}
	return searchLocality;
}

function getMultiScopeForSearch(){ 
	var res = {};
	mylog.log("getMultiScopeForSearch", myMultiScopes);
	$.each(myMultiScopes, function(key, value){
		mylog.log("getMultiScopeForSearch value.active", value.active);
		if(value.active == true){
			res[key] = value;
			mylog.log("getMultiScopeForSearch search2", res);
		}
	});

	mylog.log("getMultiScopeForSearch search", res);
	return res; 

}


var timerMsgMultiscope;
function showMsgInfoMultiScope(msg, type){
	if(type == "success") msg = "<i class='fa fa-check'></i> " + msg;
	if(type == "danger") msg = "<i class='fa fa-times'></i> " + msg;
	if(type == "info") msg = "<i class='fa fa-info-circle'></i> " + msg;
	
	var id = "#lbl-info-select-multi-scope";
	$(id).html(msg);
	if(type == "success") $(id).addClass("label-success"); else $(id).removeClass("label-success");
	if(type == "danger") $(id).addClass("label-danger"); else $(id).removeClass("label-danger");
	if(type == "info") $(id).addClass("label-info"); else $(id).removeClass("label-info");

	$(id).off().hide();
	$(id).show(200);

	if(typeof timerMsgMultiscope != "undefined") clearTimeout(timerMsgMultiscope);
	timerMsgMultiscope = setTimeout(function(){ $(id).off().hide(500)}, 3000);
}

/**********************************************/

function rebuildSearchScopeInput(){ 
	mylog.log("rebuildSearchScopeInput");
	$("#searchLocalityLEVEL").val("");
	/*****************************************************************************************/
	searchLocalityCITYKEYs = "";
	$.each($('.item-scope-city'), function(key, value){
		if(!$(value).hasClass('disabled')){
			key = $(value).data("scope-value");
			searchLocalityCITYKEYs += (searchLocalityCITYKEYs == "") ? key :   ","+key;
		}
	});
	//mylog.log("searchLocalityCITYKEYs",searchLocalityCITYKEYs);
	if( $("#searchLocalityCITYKEY") )
		$("#searchLocalityCITYKEY").val(searchLocalityCITYKEYs);

	/*****************************************************************************************/
	searchLocalityCODE_POSTALs = "";
	$.each($('.item-scope-cp'), function(key, value){
		if(!$(value).hasClass('disabled')){
			key = $(value).data("scope-value");
			searchLocalityCODE_POSTALs += (searchLocalityCODE_POSTALs == "") ? key :   ","+key;
		}
	});
	//mylog.log("searchLocalityCODE_POSTALs",searchLocalityCODE_POSTALs);
	if( $("#searchLocalityCODE_POSTAL") )
		$("#searchLocalityCODE_POSTAL").val(searchLocalityCODE_POSTALs);


	searchLocalityZONEs = "";
	$.each($('.item-scope-zone'), function(key, value){
		if(!$(value).hasClass('disabled')){
			key = $(value).data("scope-value");
			searchLocalityZONEs += (searchLocalityZONEs == "") ? key :   ","+key;
		}
	});
	//mylog.log("searchLocalityZONEs",searchLocalityZONEs);
	if( $("#searchLocalityZONE") )
		$("#searchLocalityZONE").val(searchLocalityZONEs);

	
	$(".list_tags_scopes").removeClass("tagOnly");
	$(".city-name-locked").html("");
	//if( typeof searchCallback == "function" )
		//searchCallback();
}


function lockScopeOnCityKey(cityKey, cityName){ 
	mylog.log("lockScopeOnCityKey", cityKey, cityName);
	$("#searchLocalityCITYKEY").val(cityKey);
	$("#searchLocalityCODE_POSTAL").val("");
	// $("#searchLocalityDEPARTEMENT").val("");
	// $("#searchLocalityREGION").val("");
	$("#searchLocalityZONE").val("");
	$(".list_tags_scopes").addClass("tagOnly");

	var insee = cityKeyPart(cityKey, "insee");
	var cp = cityKeyPart(cityKey, "cp");
	var url = "#city.detail.insee." + insee;
	if(cp != "") url += ".postalCode." + cityKeyPart(cityKey, "cp");
	
	$(".city-name-locked").html("<a href='javascript:' class='text-red'>"+
									"<i class='fa fa-lock tooltips' id='cadenas' data-toggle='tooltip' data-placement='top' title='"+trad.Unblock+"'></i>"+
								"</a> <a href='"+url+"' class='lbh homestead text-red tooltips' data-toggle='tooltip' data-placement='top' title='"+trad.backtopage+"'>"+ cityName + "</a>" );

	$(".city-name-locked").click(function(){
		rebuildSearchScopeInput();
	});
	$("#cadenas").mouseover(function(){
		$("#cadenas").removeClass("fa-lock").addClass("fa-unlock");
	});
	$("#cadenas").mouseout(function(){
		$("#cadenas").addClass("fa-lock").removeClass("fa-unlock");
	});
}

function openDropdownMultiscope(){
	if(!$("#dropdown-content-multi-scope").hasClass('open'))
	setTimeout(function(){ $("#dropdown-content-multi-scope").addClass('open'); }, 300);
}

function setGlobalScope(scopeValue, scopeName, scopeType, scopeLevel, values, notSearch){  

	mylog.log("setGlobalScope", scopeValue, scopeName, scopeType, scopeLevel, notSearch);

	if(scopeValue == "") return;
	
	mylog.log("myMultiScopes", myMultiScopes, indexStepInit);
	$("#searchLocalityCITYKEY").val("");
	$("#searchLocalityCODE_POSTAL").val("");
	$("#searchLocalityZONE").val("");
	if(scopeType == "city") {$("#searchLocalityCITYKEY").val(scopeValue);} 
	if(scopeType == "cp") $("#searchLocalityCODE_POSTAL").val(scopeValue);
	if(scopeType == "zone") $("#searchLocalityZONE").val(scopeValue);
	$("#searchLocalityLEVEL").val(scopeLevel);
	$("#main-scope-name").html('<i class="fa fa-university"></i> ' + scopeName + "<small class='text-dark'>.CO</small>");

	communexion.currentLevel = scopeLevel;
	communexion.currentName = scopeName;
	communexion.currentValue = scopeValue;

	if(values){
		if(typeof values == "string")
			values = jQuery.parseJSON(values);
		communexion.values = values;
	}

	$.cookie('communexion', communexion, { expires: 365, path: "/" });

	if($("#communexionNameHome").length){
		$("#communexionNameHome").html('Vous êtes <span class="text-dark">communecté à <span class="text-red">'+scopeName+'</span></span>');
		$("#liveNowCoName").html("<span class='text-red'> à "+$(this).data("name-communexion")+"</span>");
		$("#main-search-bar").val("");
		$(".info_co, .input_co").addClass("hidden");
		$("#change_co").removeClass("hidden");
		$("#dropdown_search").html("");
	}

	if(!notNull(notSearch) || notSearch != true)
		activateGlobalCommunexion(true);
	//rebuildSearchScopeInput();
	
	//startSearch(0, indexStepInit, searchCallback);
	//loadByHash(location.hash);
}

//vision city : scoping global for all applications
//levelCO == city cp dep region
