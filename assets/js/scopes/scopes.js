function constructScopesHtml(news){
	html="";
    $.each(myScopes[myScopes.type], function(key, value){
    	var disabled = (value.active == false && !news) ? "disabled" : "";
    	var btnType = (myScopes.type=="multiscopes") ? "multiscope" : "communexion";
    	if(typeof value.name == "undefined") value.name = key;
    	if(news){
    		btnScopeAction="<span class='manageMultiscopes tooltips margin-right-5 margin-left-10' "+
    			"data-add='true' data-scope-value='"+key+"' "+
    			"data-toggle='tooltip' data-placement='top' "+
    			"data-original-title='Add zones to news'>"+
    				"<i class='fa fa-plus-circle'></i>"+
    			"</span>";
    	}else{
	    	if(myScopes.type=="multiscopes")
	    		btnScopeAction="<span class='manageMultiscopes tooltips margin-right-5 margin-left-10' "+
	    			"data-add='false' data-scope-value='"+key+"' "+
	    			"data-toggle='tooltip' data-placement='top' "+
	    			"data-original-title='Remove from my favorites places'>"+
	    				"<i class='fa fa-times-circle'></i>"+
	    			"</span>";
	    	else{
	    		if(typeof myScopes.multiscopes[key] != "undefined")
	    			btnScopeAction="<span class='manageMultiscopes active tooltips margin-right-5 margin-left-10' "+
	    				"data-add='0' data-scope-value='"+key+"' "+
	    				"data-toggle='tooltip' data-placement='top' "+
	    				"data-original-title='Remove from my favorites places'>"+
	    					"<i class='fa fa-star'></i>"+
	    				"</span>";
	    		else
	    			btnScopeAction="<span class='manageMultiscopes tooltips margin-right-5 margin-left-10' "+
	    				"data-add='true' data-scope-value='"+key+"' "+
	    				"data-toggle='tooltip' data-placement='top' "+
	    				"data-original-title='Add to my favorites places'>"+
	    					"<i class='fa fa-star-o'></i>"+
	    				"</span>";
	    	}
    	}
    	html += "<div class='scope-order "+disabled+" text-red' data-level='"+value.level+"''>"+
    				btnScopeAction+
    				"<span data-toggle='dropdown' data-target='dropdown-multi-scope' "+
	                    "class='item-scope-checker item-scope-input' "+
	                    'data-scope-value="'+key+'" '+
						'data-scope-name="'+value.name+'" '+
						'data-scope-type="'+value.type+'" '+
						'data-scope-level="'+value.type+'" ' +
						'data-btn-type="'+btnType+'" '+
						'data-level="'+value.level+'">' + 
	                    value.name + 
                	"</span>"+
                "</div>";
	});	
    return html;
}

function changeCommunexionScope(scopeValue, scopeName, scopeType, scopeLevel, values, notSearch, testCo, appendDom){
	communexionObj=scopeObject(values);
	myScopes.open=communexionObj;
	var newsAction=(notNull(appendDom) && appendDom.indexOf("scopes-news-form") >= 0) ? true : false;
    $(appendDom).html(constructScopesHtml(newsAction));
    $(appendDom+" .scope-order").sort(sortSpan) // sort elements
                  .appendTo(appendDom); // append again to the list
	if(newsAction) bindScopesNewsEvent();
	else{
		search.count=true;
		startSearch(0, indexStepInit);
		bindScopesInputEvent();
	}
}
function getCommunexionLabel(){
	if(typeof myScopes.communexion != "undefined" && Object.keys(myScopes.communexion).length>0){
		var level=0;
		var nameCommunexion="";
		$.each(myScopes.communexion, function(e, v){
			if(v.level > level){
				level=v.level;
				nameCommunexion=v.name;
			}
		});
		$(".communexion-btn-label").html(nameCommunexion);
	}else{
		$("#communexion-news-btn, #communexion-btn").hide();
	}
};
function getSearchLocalityObject(){ 
	var res = {};
	var searchingOnLoc=myScopes[myScopes.type];
	if(notNull(searchingOnLoc)){
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
	if(scopeValue == "") return;
	if(myScopes.type=="communexion")
		newMultiScope=myScopes.communexion[scopeValue];
	else
		newMultiScope=myScopes.open[scopeValue];
	newMultiScope.active=true;
	myScopes.multiscopes[scopeValue] = newMultiScope;
	saveMultiScope();
}


function removeFromMultiscope(scopeValue){
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
    $("#searchOnCity").off().on("keyup", function(e){
        if(e.keyCode == 13){
            //initTypeSearch("cities");
            searchTypeGS = ["cities"];
            startGlobalSearch(0, 30, "#filter-scopes-menu");
            //startSearch($(this).val(), null, null);
            //$(".btn-directory-type").removeClass("active");
         }
    });
}
function bindScopesInputEvent(news){
	$(".manageMultiscopes").off().on("click", function(){
		addScope=$(this).data("add");
		scopeValue=$(this).data("scope-value");
		if(addScope){
			addToMultiscope(scopeValue);
			$(this).removeClass("text-red").addClass("active").data("add",false).attr("data-original-title","Remove from favorites");
			$(this).find("i").removeClass("fa-star-o").addClass("fa-star");
		}else{
			removeFromMultiscope(scopeValue);
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
		if($(this).hasClass("active")){
			$(this).removeClass("active");
			$(this).find("i.fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
			myScopes.type="open";
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
		if(search.app=="territorial") searchEngine.initTerritorialSearch();
		search.count=true;
        startSearch(0, indexStepInit);
        bindScopesInputEvent();
	});
	$(".item-scope-input").off().on("click", function(){ 
        scopeValue=$(this).data("scope-value");
        typeSearch=$(this).data("btn-type");
        scopeActiveScope(scopeValue);
        if(myScopes.type!="open")
        	localStorage.setItem("myScopes",JSON.stringify(myScopes));
        search.count=true;
        if(location.hash.indexOf("#live") >= 0 || location.hash.indexOf("#freedom") >= 0){
            startNewsSearch(true)
        } 
        else if (location.hash.indexOf("#interoperability") >= 0) {
            initTypeSearchInterop();
            startSearchInterop(0,30);
        }
        else{
            if(search.app=="territorial") searchEngine.initTerritorialSearch();
            startSearch(0, indexStepInit); 
        }
    });
    $(".item-globalscope-checker").off().on('click', function(){  
        //$(".item-globalscope-checker").addClass("inactive");
        //$(this).removeClass("inactive");
        var notSearch = $(this).data("scope-notsearch");
        //var testCo = false;
        //if($(this).hasClass("communecterSearch")){
        var testCo = true;
        $("#searchOnCity").val("");
        $(".dropdown-result-global-search").hide(700).html("");
        myScopes.type="open";
        localStorage.setItem("myScopes",JSON.stringify(myScopes));
        //}
        if(search.app=="territorial") searchEngine.initTerritorialSearch();
        mylog.log("globalscope-checker",  $(this).data("scope-name"), $(this).data("scope-type"));
        changeCommunexionScope($(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"), $(this).data("scope-level"),
                         $(this).data("scope-values"),  notSearch, testCo, $(this).data("append-container")) ;
    });
}
function countFavoriteScope(){
	count=0;
	if(notNull(myScopes.multiscopes))
		count=Object.keys(myScopes.multiscopes).length;
	$(".count-favorite").html(count);
}
function setCommunexion(){ 
	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+"/element/getCommunexion/",
		dataType: "json",
		success: function(data){
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
    mylog.log("scopeActive", scopeValue);
    if(myScopes.type!="multiscopes"){
    	$.each(myScopes[myScopes.type],function(e,v){
    		if(e!=scopeValue)
    			myScopes[myScopes.type][e].active=false;
    		else
    			myScopes[myScopes.type][e].active=true;
    	});
    	$(".scopes-container .item-scope-input i.fa").addClass("fa-circle-o");
        $(".scopes-container .item-scope-input i.fa").removeClass("fa-check-circle");
        $(".scopes-container .scope-order").addClass("disabled");
        //if(myScopes.open[scopeValue].active){
	    $(".scopes-container [data-scope-value='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-circle-o");
	    $(".scopes-container [data-scope-value='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-check-circle");
	    $(".scopes-container [data-scope-value='"+scopeValue+"'].item-scope-input").parent().removeClass("disabled");
	    //}
    }else{
	    if(!myScopes.multiscopes[scopeValue].active){
	    	myScopes.multiscopes[scopeValue].active = true;
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-circle-o");
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-check-circle");
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input").parent().removeClass("disabled");
	    }else{
	    	myScopes.multiscopes[scopeValue].active = false;
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-circle-o");
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-check-circle");
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input").parent().addClass("disabled");
	    }
	}
}
function sortSpan(a, b){
    return ($(b).data('level')) < ($(a).data('level')) ? 1 : -1;    
}
function scopeObject(values){
	communexionObj={};
	if(typeof values == "string")
		values = jQuery.parseJSON(values);	
	if(typeof values.level1 != "undefined"){
		objToPush={
			name:values.level1Name,
			type:"level1",
			active:false,
			level:1,
			countryCode:values.country
		}
		communexionObj[values.level1]=objToPush;

	}
	if(typeof values.level2 != "undefined"){
		objToPush={
			name:values.level2Name,
			type:"level2",
			active:false,
			level:2,
			countryCode:values.country
		}
		communexionObj[values.level2]=objToPush;
	}
	if(typeof values.level3 != "undefined"){
		objToPush={
			name:values.level3Name,
			type:"level3",
			active:false,
			level:3,
			countryCode:values.country
		}
		communexionObj[values.level3]=objToPush;
	}
	if(typeof values.level4 != "undefined"){
		objToPush={
			name:values.level4Name,
			type:"level4",
			active:false,
			level:4,
			countryCode:values.country
		}
		communexionObj[values.level4]=objToPush;
	}
	if(typeof values.cp != "undefined"){
		objToPush={
			name:values.cp,
			type:"cp",
			active:false,
			level:5,
			countryCode:values.country
		}
		communexionObj[values.cp]=objToPush;
	}
	objToPush={
		name:values.cityName,
		type:"city",
		active:true,
		level:6,
		countryCode:values.country
	}
	communexionObj[values.city]=objToPush;
	return communexionObj;
}