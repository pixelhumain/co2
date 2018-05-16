function constructScopesHtml(news){
	mylog.log("constructScopesHtml", news, notEmpty(news), !notEmpty(news));
	html="";

	var typeScope = (news == true) ? myScopes.typeNews : myScopes.type;

	$.each(myScopes[typeScope], function(key, value){
		mylog.log("constructScopesHtml each", key, value);
		var disabled = (value.active == false && !news) ? "disabled" : "";
		var btnType = (typeScope=="multiscopes") ? "multiscope" : "communexion";
		// if(news != true)
		// 	var btnType = (myScopes.type=="multiscopes") ? "multiscope" : "communexion";
		// else
		// 	var btnType = (myScopes.typeNews=="multiscopes") ? "multiscope" : "communexion";

		if(typeof value.name == "undefined") value.name = value.id;
		if(news){
			btnScopeAction="<span class='manageMultiscopes tooltips margin-right-5 margin-left-10' "+
				"data-add='true' data-scope-value='"+value.id+"' "+
				'data-scope-key="'+key+'" '+
				"data-toggle='tooltip' data-placement='top' "+
				"data-original-title='"+trad.addZoneToNew+"'>"+
					"<i class='fa fa-plus-circle'></i>"+
				"</span>";
		}else{
			if( typeScope=="multiscopes")
			//if( (news != true && myScopes.type=="multiscopes") || (news == true && myScopes.typeNews=="multiscopes") )
				btnScopeAction="<span class='manageMultiscopes tooltips margin-right-5 margin-left-10' "+
					"data-add='false' data-scope-value='"+value.id+"' "+
					'data-scope-key="'+key+'" '+
					"data-toggle='tooltip' data-placement='top' "+
					"data-original-title='"+trad.removeFromMyFavoritesPlaces+"'>"+
						"<i class='fa fa-times-circle'></i>"+
					"</span>";
			else{
				//mylog.log("constructScopesHtml", value.id, key, getScope(key));
				mylog.log("constructScopesHtml key", key);
				if(typeof myScopes.multiscopes[key] != "undefined")
					btnScopeAction="<span class='manageMultiscopes active tooltips margin-right-5 margin-left-10' "+
						"data-add='0' data-scope-value='"+value.id+"' "+
						'data-scope-key="'+key+'" '+
						"data-toggle='tooltip' data-placement='top' "+
						"data-original-title='"+trad.removeFromMyFavoritesPlaces+"'>"+
							"<i class='fa fa-star'></i>"+
						"</span>";
				else
					btnScopeAction="<span class='manageMultiscopes tooltips margin-right-5 margin-left-10' "+
						"data-add='true' data-scope-value='"+value.id+"' "+
						'data-scope-key="'+key+'" '+
						"data-toggle='tooltip' data-placement='top' "+
						"data-original-title='"+trad.addToMyFavoritesPlaces+"'>"+
							"<i class='fa fa-star-o'></i>"+
						"</span>";
			}
		}

    	html += "<div class='scope-order "+disabled+" text-red' data-level='"+value.level+"''>"+
    				btnScopeAction+
    				"<span data-toggle='dropdown' data-target='dropdown-multi-scope' "+
						"class='item-scope-checker item-scope-input' "+
						'data-scope-key="'+key+'" '+
						'data-scope-value="'+value.id+'" '+
						'data-scope-name="'+name+'" '+
						'data-scope-type="'+value.type+'" '+
						'data-scope-level="'+value.type+'" ' +
						'data-scope-country="'+value.country+'" ' +
						'data-btn-type="'+btnType+'" ';
						if(notNull(value.level))
							html += 'data-level="'+value.level+'"';
						html += '>' + 
						value.name + 
					"</span>"+
				"</div>";
	});	
	return html;
}

function changeCommunexionScope(scopeValue, scopeName, scopeType, scopeLevel, values, notSearch, testCo, appendDom){
	mylog.log("changeCommunexionScope", scopeValue, scopeName, scopeType, scopeLevel, values, notSearch, testCo, appendDom);
	mylog.log("changeCommunexionScope appendDom", appendDom);
	communexionObj=scopeObject(values);
	mylog.log("changeCommunexionScope communexionObj",communexionObj);
	myScopes.open=communexionObj;
	var newsAction=(notNull(appendDom) && appendDom.indexOf("scopes-news-form") >= 0) ? true : false;
	mylog.log("changeCommunexionScope newsAction", newsAction);

	$(appendDom).html(constructScopesHtml(newsAction));
	$(appendDom+" .scope-order").sort(sortSpan) // sort elements
				.appendTo(appendDom); // append again to the list
	if(newsAction) bindScopesNewsEvent();
	else{
		searchObject.count=true;
		startSearch(0, indexStepInit);
		bindScopesInputEvent();
	}
}


function getCommunexionLabel(){
	mylog.log("getCommunexionLabel");
	if(typeof myScopes.communexion != "undefined" && Object.keys(myScopes.communexion).length>0){
		var level=0;
		var nameCommunexion="";
		$.each(myScopes.communexion, function(e, v){
			if(v.type == "cities")
				nameCommunexion=v.name;
		});
		$(".communexion-btn-label").html(nameCommunexion);
	}else{
		mylog.log("getCommunexionLabel hide");
		$("#communexion-news-btn, #communexion-btn").hide();
	}
};
function getUrlSearchLocality(urlGet){
	var urlScopeCity = [];
	var urlScopeCp = [];
	var urlScopeZone = [];
	var urlMyScope = "";
	var searchingOnLoc=myScopes[myScopes.type];
	if(notNull(searchingOnLoc)){
		$.each(searchingOnLoc, function(key, value){
			mylog.log("getMultiScopeForSearch value.active", value.active);
			if(value.active == true){
				if(value.type == "cities"){
					keyScope=(typeof value.postalCode == "undefined") ? value.id : value.id+"cp"+value.postalCode;
					keyScope+=(typeof value.allCP == "undefined" && value.allCP) ? "allPostalCode" : "";
					urlScopeCity.push(keyScope);
				}
				else if (value.type == "cp")
					urlScopeCp.push(value.id);
				else if (value.type.indexOf("level") >= 0)
					urlScopeZone.push(value.id);
			}
		});
		if(urlScopeCity.length > 0) urlMyScope+="&cities="+urlScopeCity.join(",");
		if(urlScopeZone.length > 0) urlMyScope+="&zones="+urlScopeZone.join(",");
		if(urlScopeCp.length > 0) urlMyScope+="&cp="+urlScopeCp.join(",");
		if(urlMyScope != ""){
			urlMyScope="scopeType="+myScopes.type+urlMyScope;
			urlGet += (urlGet != "") ? "&"+urlMyScope : urlMyScope  
		}	
	}
//	mylog.log("getMultiScopeForSearch search", res);
	return urlGet;
}
function checkMyScopeObject(initScopeResearch, paramsGet){
	inMyScope=true;
	console.log("initScope",initScopeResearch, "Myscopes", myScopes);
	if(typeof myScopes[initScopeResearch.key] != "undefined"){
		$.each(initScopeResearch.ids,function(e,v){
			if(v.indexOf("cp") > 0){
				tab=v.split("cp");
				if(typeof myScopes[initScopeResearch.key][tab[0]+"cities"+tab[1]] == "undefined"  )
						inMyScope=false;
			}else if(v.indexOf("allPostalCode") > 0){
				tab=v.split("allPostalCode");
				if(typeof myScopes[initScopeResearch.key][tab[0]] == "undefined" 
					|| typeof myScopes[initScopeResearch.key][tab[0]].allCP == "undefined" 
					|| !myScopes[initScopeResearch.key][tab[0]].allCP )
					inMyScope=false;
			}else if(typeof myScopes[initScopeResearch.key][v] == "undefined")
				inMyScope=false;
		});
		if(!inMyScope){
			setOpenBreadCrum(paramsGet);
		}else{
			myScopes.type=initScopeResearch.key
			$.each(myScopes[initScopeResearch.key], function(e, v){
				keyActive=e;
				if(e.indexOf("cities") > 0)
					keyActive=e.replace("cities","");
				if(typeof v.allCP != "undefined" && v.allCP)
					keyActive=e+"allPostalCode";
				if(v.type=="cities" && v.postalCode != "undefined"){
					keyActive=v.id+"cp"+v.postalCode;
				}
				myScopes[initScopeResearch.key][e].active=($.inArray(keyActive, initScopeResearch.ids) > -1)  ? true : false;
			});
		}
	}
}
function setOpenBreadCrum(params){
	setOpenScope={};
	if(typeof params.zones != "undefined"){
		zones=params.zones.split(",");
		setOpenScope.zones=[];
		$.each(zones, function(e,v){
			setOpenScope.zones.push(v);
		});
	}
	if(typeof params.cities != "undefined"){
		cities=params.cities.split(",");
		setOpenScope.cities=[];
		$.each(cities, function(e,v){
			setOpenScope.cities.push(v);
		});
	}
	if(typeof params.cp != "undefined"){
		cp=params.cp.split(",");
		setOpenScope.cp=[];
		$.each(cp, function(e,v){
			setOpenScope.cp.push(v);
		});
	}

	mylog.log("setOpenScope", setOpenScope);
	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+"/zone/getscopebyids",
		data: setOpenScope,
		dataType: "json",
		success: function(data){
			mylog.log("data", data);
			myScopes.open=data.scopes;
		},
		error: function(error){
			toastr.error("waswrong")
			mylog.log();
		}
	});
	myScopes.type="open";
}
function getSearchLocalityObject(){ 
	var res = {};
	var searchingOnLoc=myScopes[myScopes.type];
	if(notNull(searchingOnLoc)){
		//compareMyScopeAndUrlGet()
		$.each(searchingOnLoc, function(key, value){
			mylog.log("getMultiScopeForSearch value.active", value.active);
			if(value.active == true){
				res[key] = value;
				mylog.log("getMultiScopeForSearch search2", res);
			}
		});
	}
//	mylog.log("getMultiScopeForSearch search", res);
	return res; 

}
//scopeValue est la valeur utilisée pour la recherche
//scopeName est la valeur affichée
function addToMultiscope(scopeValue){
	mylog.log("addToMultiscope",scopeValue, myScopes);
	if(scopeValue == "") return;
	if(myScopes.type=="communexion")
		newMultiScope=myScopes.communexion[scopeValue];
		//newMultiScope=  getScope(scopeValue, "communexion");
	else
		//newMultiScope=  getScope(scopeValue, "open");
		newMultiScope=myScopes.open[scopeValue];
	newMultiScope.active=true;
	myScopes.multiscopes[scopeValue] = newMultiScope;
	//myScopes.multiscopes.push(newMultiScope);
	saveMultiScope();
}


function scopeExists(scopeValue){
	return typeof myScopes.multiscopes[scopeValue] != "undefined";
}

function removeFromMultiscope(scopeValue){
	mylog.log("removeFromMultiscope", scopeValue);
	if(scopeExists(scopeValue)){
		delete myScopes.multiscopes[scopeValue];
		saveMultiScope();
	}
}

function saveMultiScope(){ 
	if(userId != null && userId != ""){
		if(!notEmpty(myScopes.multiscopes)) myScopes.multiscopes = {};
		$.ajax({
			type: "POST",
			url: baseUrl+"/"+moduleId+"/person/updatemultiscope",
			data: {"multiscopes" : myScopes.multiscopes},
			dataType: "json",
			success: function(data){
				mylog.log("updatemultiscope success");
			},
			error: function(error){
				mylog.log("Une erreur est survenue pendant l'enregistrement des scopes");
			}
		});
	}
	localStorage.setItem("myScopes",JSON.stringify(myScopes));
}

function bindSearchCity(){
	mylog.log("bindSearchCity");
	$("#searchOnCity").off().on("keyup", function(e){
		if(e.keyCode == 13){
			searchTypeGS = ["cities"];
			startGlobalSearch(0, 30, "#filter-scopes-menu");
		}
	});
}

function bindScopesInputEvent(news){
	mylog.log("bindScopesInputEvent");
	$(".manageMultiscopes").off().on("click", function(){
		mylog.log("manageMultiscopes");
		addScope=$(this).data("add");
		scopeValue=$(this).data("scope-value");
		key=$(this).data("scope-key");
		mylog.log("manageMultiscopes", key);
		if(addScope){
			addToMultiscope(key);
			$(this).removeClass("text-red").addClass("active").data("add",false).attr("data-original-title","Remove from favorites");
			$(this).find("i").removeClass("fa-star-o").addClass("fa-star");
		}else{
			removeFromMultiscope(key);
			if(myScopes.type=="multiscopes")
				$(this).parent().remove();
			else{
				$(this).removeClass("active").addClass("text-red").data("add",true).attr("data-original-title","Add to favorites");
				$(this).find("i").removeClass("fa-star").addClass("fa-star-o");
			}
		}
		countFavoriteScope();
	});

	$("#multiscopes-btn, #communexion-btn").off().on("click", function(){
		mylog.log("#multisopes-btn, #communexion-btn");
		if($(this).hasClass("active")){
			$(this).removeClass("active");
			$(this).find("i.fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
			myScopes.type="open";
			myScopes.open={};
			$(".scopes-container").html("");
		}else{
			$(".btn-menu-scopes").removeClass("active");
			$(".btn-menu-scopes").find("i.fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
			$(this).addClass("active");
			myScopes.type=$(this).data("type");
			$(this).find("i.fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");
			$(".scopes-container").html(constructScopesHtml());
			if(myScopes.type=="communexion")
				$("#filter-scopes-menu .scopes-container .scope-order").sort(sortSpan) // sort elements
					.appendTo("#filter-scopes-menu .scopes-container");
		}
		localStorage.setItem("myScopes",JSON.stringify(myScopes));
		if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
		searchObject.count=true;
		startSearch(0, indexStepInit);
		bindScopesInputEvent();
	});

	$(".item-scope-input").off().on("click", function(){ 
		mylog.log(".item-scope-input");
		scopeValue=$(this).data("scope-value");
		typeSearch=$(this).data("btn-type");
		key=$(this).data("scope-key");
		scopeActiveScope(key);
		if(myScopes.type!="open")
			localStorage.setItem("myScopes",JSON.stringify(myScopes));
		searchObject.count=true;
		if(location.hash.indexOf("#live") >= 0 || location.hash.indexOf("#freedom") >= 0){
			startNewsSearch(true)
		} else if (location.hash.indexOf("#interoperability") >= 0) {
			initTypeSearchInterop();
			startSearchInterop(0,30);
		}
		else{
			if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
			startSearch(0, indexStepInit); 
		}
	});

	$(".item-globalscope-checker").off().on('click', function(){ 
		mylog.log(".item-globalscope-checker");
		var notSearch = $(this).data("scope-notsearch");
		var container = $(this).data("append-container");
		var testCo = true;
		$("#searchOnCity").val("");
		$(".dropdown-result-global-search").hide(700).html("");
		mylog.log(".item-globalscope-checker container", container, container.indexOf("#scopes-news-form"));
		if(container.indexOf("#scopes-news-form") == -1 )
			myScopes.type="open";
		else
			myScopes.typeNews="open";

		localStorage.setItem("myScopes",JSON.stringify(myScopes));
		if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
		mylog.log("globalscope-checker",  $(this).data("scope-name"), $(this).data("scope-type"));




		mylog.log("globalscope-checker values",  myScopes.search[$(this).data("scope-value")]);
		changeCommunexionScope(	$(this).data("scope-value"), $(this).data("scope-name"), 
								$(this).data("scope-type"), $(this).data("scope-level"),
								myScopes.search[$(this).data("scope-value")],  notSearch, testCo, $(this).data("append-container")) ;
	});
}


function countFavoriteScope(){
	count=0;
	if(notNull(myScopes.multiscopes))
		count=Object.keys(myScopes.multiscopes).length;
	$(".count-favorite").html(count);
}
function setCommunexion(){
	mylog.log("setCommunexion");
	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+"/element/getCommunexion/",
		dataType: "json",
		success: function(data){
			mylog.log("setCommunexion success", data);
			if(data){
				myScopes.communexion = scopeObject(data);
			}
			else
				myScopes.communexion={};
			localStorage.setItem("myScopes",JSON.stringify(myScopes));
		}
	});
}
function scopeActiveScope(scopeValue){
	mylog.log("scopeActive", scopeValue, myScopes.type);
	if(myScopes.type!="multiscopes"){
		mylog.log("here", myScopes.type);
		$.each(myScopes[myScopes.type],function(e,v){
			if(e!=scopeValue)
				myScopes[myScopes.type][e].active=false;
			else
				myScopes[myScopes.type][e].active=true;
		});

		$(".scopes-container .item-scope-input i.fa").addClass("fa-circle-o");
		$(".scopes-container .item-scope-input i.fa").removeClass("fa-check-circle");
		$(".scopes-container .scope-order").addClass("disabled");
		$(".scopes-container [data-scope-key='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-circle-o");
		$(".scopes-container [data-scope-key='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-check-circle");
		$(".scopes-container [data-scope-key='"+scopeValue+"'].item-scope-input").parent().removeClass("disabled");
	}else{
		mylog.log("la", myScopes.type);
		if(!myScopes.multiscopes[scopeValue].active){
			myScopes.multiscopes[scopeValue].active = true;
			$("[data-scope-key='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-circle-o");
			$("[data-scope-key='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-check-circle");
			$("[data-scope-key='"+scopeValue+"'].item-scope-input").parent().removeClass("disabled");
		}else{
			myScopes.multiscopes[scopeValue].active = false;
			$("[data-scope-key='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-circle-o");
			$("[data-scope-key='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-check-circle");
			$("[data-scope-key='"+scopeValue+"'].item-scope-input").parent().addClass("disabled");
		}
	}
}
function sortSpan(a, b){
	return ($(b).data('level')) < ($(a).data('level')) ? 1 : -1;    
}
function scopeObject(values){
	mylog.log("scopeObject", values);
	communexionObj={};
	if(typeof values == "string")
		values = jQuery.parseJSON(values);

	if(typeof values.level1 != "undefined"){
		objToPush={
			id:values.level1,
			name:values.level1Name,
			type:"level1",
			active:false,
			level:1,
			countryCode:values.country
		}
		communexionObj[objToPush.id+objToPush.type] = objToPush;
		mylog.log("communexionObj level1", communexionObj);
	}

	if(typeof values.level2 != "undefined" && ( notNull(values.level1) && values.level1 != values.level2 )  ){
		objToPush={
			id:values.level1,
			name:values.level2Name,
			type:"level2",
			active:false,
			level:2,
			countryCode:values.country
		}
		communexionObj[objToPush.id+objToPush.type] = objToPush;
		mylog.log("communexionObj level2", communexionObj);
	}

	if(typeof values.level3 != "undefined" && ( notNull(values.level1) && values.level1 != values.level3 )){
		objToPush={
			id:values.level3,
			name:values.level3Name,
			type:"level3",
			active:false,
			level:3,
			countryCode:values.country
		}
		communexionObj[objToPush.id+objToPush.type] = objToPush;
		mylog.log("communexionObj level3", communexionObj);
	}

	if(typeof values.level4 != "undefined" && ( notNull(values.level1) && values.level1 != values.level4 )){
		objToPush={
			id:values.level4,
			name:values.level4Name,
			type:"level4",
			active:false,
			level:4,
			countryCode:values.country
		}
		communexionObj[objToPush.id+objToPush.type] = objToPush;
		mylog.log("communexionObj level4", communexionObj);
	}
	mylog.log("scopeObject cp", typeof values.postalCode, typeof values.uniqueCp, values.uniqueCp);
	if(typeof values.postalCode != "undefined" && typeof values.uniqueCp != "undefined" && values.uniqueCp == false){
		mylog.log("scopeObject communexionObj cp values", values);

		objToPush={
			id:values.postalCode+values.country+objToPush.type,
			name:values.postalCode,
			type:"cp",
			active:false,
			countryCode:values.country
		}
		communexionObj[objToPush.id] = objToPush;
		mylog.log("scopeObject communexionObj cp", communexionObj);
	}
	
	if(notNull(values.level) && typeof values.level != "undefined"){
			objToPush={
				id:values.id,
				name:values.name,
				type:values.type,
				active:true,
				level:values.numLevel,
				countryCode:values.country
			}
	}else{
		objToPush={
			id:values.city,
			name:((notNull(values.allCP) && values.allCP == false) ?  values.name : values.cityName ) ,
			type:"cities",
			active:((notNull(values.allCP) && values.allCP == false) ?  false : true ) ,
			countryCode:values.country,
			allCP:values.allCP,
			//postalCode:values.postalCode,
		}
		// if( notNull(values.allCP) && values.allCP == false )
		// 	objToPush["postalCode"] = values.postalCode ;
	}
	communexionObj[objToPush.id+objToPush.type] = objToPush;
	mylog.log("scopeObject communexionObj", communexionObj);

	if(notNull(values.allCP) && values.allCP == false){
		objToPush={
			id:values.city,
			name:values.cityName + " ( " +values.postalCode + " ) ",
			type:"cities",
			active:true,
			countryCode:values.country,
			allCP:values.allCP,
			postalCode:values.postalCode,
		}
		communexionObj[objToPush.id+objToPush.type+objToPush.postalCode] = objToPush;
	}
	mylog.log("scopeObject communexionObj", communexionObj);
	return communexionObj;
}