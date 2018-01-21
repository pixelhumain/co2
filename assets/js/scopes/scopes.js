function constructScopesHtml(constructScope){
	if(myScopes.type=="open-scope")
		typeSe="open";
	else
		typeSe=myScopes.type;
	html="";
    $.each(myScopes[typeSe], function(key, value){
    	var disabled = value.active == false ? "disabled" : "";
    	var btnType = (myScopes.type=="multiscopes") ? "multiscope" : "communexion";
    	if(typeof value.name == "undefined") value.name = key;
    	if(myScopes.type=="multiscopes")
    		btnScopeAction="<span class='manageMultiscopes active tooltips margin-right-10 margin-left-5' data-add='false' data-scope-value='"+key+"' data-toggle='tooltip' data-placement='top' data-original-title='Remove from my favorites places'><i class='fa fa-times'></i></span>";
    	else{
    		if(typeof myScopes.multiscopes[key] != "undefined")
    			btnScopeAction="<span class='manageMultiscopes active tooltips margin-right-10 margin-left-5' data-add='0' data-scope-value='"+key+"' data-toggle='tooltip' data-placement='top' data-original-title='Remove from my favorites places'><i class='fa fa-star'></i></span>";
    		else
    			btnScopeAction="<span class='manageMultiscopes text-red tooltips margin-right-10 margin-left-5' data-add='true' data-scope-value='"+key+"' data-toggle='tooltip' data-placement='top' data-original-title='add to my favorites places'><i class='fa fa-star-o'></i></span>";
    	}
    	html +=     "<div class='scope-order "+disabled+"' data-level='"+value.level+"''>"+
    				"<span data-toggle='dropdown' data-target='dropdown-multi-scope' "+
                    "class='text-red item-scope-checker item-scope-input' "+
                    'data-scope-value="'+key+'" '+
					'data-scope-name="'+value.name+'" '+
					'data-scope-type="'+value.type+'" '+
					'data-scope-level="'+value.type+'" ' +
					'data-btn-type="'+btnType+'" '+
					'data-level="'+value.level+'">' + 
                    "<i class='fa fa-check-circle'></i> " + value.name + 
                "</span>"+
                btnScopeAction+
                "</div>";
	});	
    return html;
}
/*function constructScopeCommunexion(communexion){
	htmlCommunexion="";
	var tips="";
    if(typeof communexion.cities == "string") {
        tips = communexion.cities ;
    }else if(typeof communexion.cities != "undefined") {
    	$.each(communexion.cities,function(e,v){
            tips+=v+" / ";
        });
    }
	if(communexion.values && communexion.values.level2){
		htmlCommunexion+=			'<span data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="text-red item-scope-checker item-scope-input margin-right-10 '; 
											if( communexion.currentLevel != "level2" )
												htmlCommunexion+="disabled";
		htmlCommunexion+=					'" data-scope-value="'+communexion.values.level2+'" '+
											'data-scope-name="'+communexion.values.level2Name+'" '+
											'data-scope-type="'+communexion.communexionType+'" '+
											'data-scope-level="level2">'+
										'<i class="fa fa-check-circle"></i>  '+communexion.values.level2Name+' <i class="fa fa-star-o"></i>'+
									'</span>';
	}

	if(communexion.values && communexion.values.level3){
		htmlCommunexion+=			'<span data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="text-red item-scope-checker item-scope-input margin-right-10 '; 
											if( communexion.currentLevel != "level3" )
												htmlCommunexion+="disabled";
		htmlCommunexion+=					'" data-scope-value="'+communexion.values.level3+'" '+
											'data-scope-name="'+communexion.values.level3Name+'" '+
											'data-scope-type="'+communexion.communexionType+'" '+
											'data-scope-level="level3">'+
										'<i class="fa fa-check-circle"></i>  '+communexion.values.level3Name+' <i class="fa fa-star-o"></i>'+
									'</span>';
	}

	if(communexion.values && communexion.values.level4){
		htmlCommunexion+=			'<span data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="text-red item-scope-checker item-scope-input margin-right-10 '; 
											if( communexion.currentLevel != "level4" )
												htmlCommunexion+="disabled";
		htmlCommunexion+= 					'" data-scope-value="'+communexion.values.level4+'" '+
											'data-scope-name="'+communexion.values.level4Name+'" '+
											'data-scope-type="'+communexion.communexionType+'" '+
											'data-scope-level="level4">'+
										'<i class="fa fa-check-circle"></i>  '+communexion.values.level4Name+' <i class="fa fa-star-o"></i>'+
									'</span>';
	}

	if(notNull(communexion.cities) && communexion.cities.length != 1){
		htmlCommunexion+= '<span data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="text-red item-scope-checker item-scope-input margin-right-10 tooltips '; 
											if( communexion.currentLevel != "cp" )
												htmlCommunexion+="disabled";
			htmlCommunexion+= 	'" data-scope-value="'+communexion.values.cp+'" '+
								'data-scope-name="'+communexion.values.cp+'" '+
								'data-scope-type="cp" '+
								'data-scope-level="cp" '+
								'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'">'+
							'<i class="fa fa-check-circle"></i>  '+communexion.values.cp+
						'</span>'+
						'<span data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="text-red item-scope-checker item-scope-input margin-right-10 tooltips '; 
											if( communexion.currentLevel != "city" )
												htmlCommunexion+="disabled";
			htmlCommunexion+= 	'" data-scope-value="'+communexion.values.city+'" '+
								'data-scope-name="'+communexion.values.cityName+'" '+
								'data-scope-type="city" '+
								'data-scope-level="city">'+
							'<i class="fa fa-check-circle"></i>  '+communexion.values.cityName+' <i class="fa fa-star-o"></i>'+
						'</span>';
    }else{
        htmlCommunexion+= '<span data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="text-red item-scope-checker item-scope-input margin-right-10 tooltips '; 
											if( communexion.currentLevel != "city" )
												htmlCommunexion+="disabled";
			htmlCommunexion+= 	'" data-scope-value="'+communexion.values.city+'" '+
                    'data-scope-name="'+communexion.values.cityName+'" '+
                    'data-scope-type="city" '+
                    'data-scope-level="city" '+
                    'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'"'+'>'+
                    '<i class="fa fa-check-circle"></i>  '+communexion.values.cityName+' (toute la ville)'+' <i class="fa fa-star-o"></i>'+
                '</span>'+
                '<span data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="text-red item-scope-checker item-scope-input margin-right-10 tooltips '; 
											if( communexion.currentLevel != "cp" )
												htmlCommunexion+="disabled";
			htmlCommunexion+= 	'"data-scope-value="'+communexion.values.city+'" '+
                    'data-scope-name="'+communexion.values.cityName+'" '+
                    'data-scope-type="cp" '+
                    'data-scope-level="city">'+
                    '<i class="fa fa-check-circle"></i>  '+communexion.values.cityName+' <i class="fa fa-star-o"></i>'+
                '</span>';
    }
    return htmlCommunexion;
}*/
function changeCommunexionScope(scopeValue, scopeName, scopeType, scopeLevel, values, notSearch, testCo){
	communexion= new Object;
	communexion.currentLevel = scopeLevel;
	communexion.currentName = scopeName;
	communexion.currentValue = scopeValue;
	communexion.communexionType = scopeType;
	//communexion=scopeObject(communexion);
	alert(scopeLevel+"/"+communexion.currentLevel);
	communexionObj=scopeObject(communexion, values);
	//$.each(values, function(key, name){
	
	//});
	//scopeCommunexionObject(communexion,)
	//if( notNull(testCo)){
	//	if(values){
	//		if(typeof values == "string")
	//			values = jQuery.parseJSON(values);
	//		communexion.values = values;
	//	}else 
		//if(myScopes.type=="communexion")
		//	communexion.values=myScopes.communexion.values;
		//else
		//	communexion.values=myScopes.open.values;
	if(myScopes.type=="communexion"){
		myScopes.communexion=communexionObj;
		localStorage.setItem("myScopes",JSON.stringify(myScopes));
	}
	else{
		myScopes.open=communexionObj;
	}
    $("#open-breacrum-container").html(constructScopesHtml());
    $("#open-breacrum-container .scope-order").sort(sortSpan) // sort elements
                  .appendTo('#open-breacrum-container'); // append again to the list
// sort function callback
	bindScopesInputEvent();

            
}
function getSearchLocalityObject(){ 
	var res = {};
	searchingOnLoc=myScopes.open;
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
	myScopes.multiscopes[scopeValue] = newMultiScope;
	saveMultiScopeHere();
	//bindCommunexionScopeEvents();
}


function removeFromMultiscope(scopeValue){
	if(scopeExists(scopeValue)){
		delete myScopes.multiscopes[scopeValue];
		saveMultiScopeHere();
	}
}
function saveMultiScopeHere(){ 
	mylog.log("saveMultiScope() try - userId = ", userId); 
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
	//showCountScope();
	//rebuildSearchScopeInput();
	//setTimeout(function(){ rebuildSearchScopeInput() }, 1000);
	//saveCookieMultiscope();
}
function bindScopesInputEvent(){
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
				$("#multiscopes-container [data-scope-value=\""+scopeValue+"\"]").remove();
			else{
				$(this).removeClass("active").addClass("text-red").data("add",true).attr("data-original-title","Add to favorites");
				$(this).find("i").removeClass("fa-star").addClass("fa-star-o");
			}
		}

	});
	$(".item-scope-input").off().on("click", function(){ 
        scopeValue=$(this).data("scope-value");
        typeSearch=$(this).data("btn-type");
        // if($(this).hasClass("disabled")){
        //     $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-circle-o");
        //     $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-check-circle");
        //     $("[data-scope-value='"+scopeValue+"'].item-scope-input").removeClass("disabled");
        // }else{
        //     $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-circle-o");
        //     $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-check-circle");
        //     $("[data-scope-value='"+scopeValue+"'].item-scope-input").addClass("disabled");
        // }
        //toogleScopeMultiscope( $(this).data("scope-value") );
        scopeActiveScope(scopeValue, typeSearch);
        //if(actionOnSetGlobalScope=="filter")
          //  $("#newsstream").html("<div class='col-md-12 text-center'><i class='fa fa-circle'></i> <i class='fa fa-circle'></i> <i class='fa fa-circle'></i><hr style='margin-top: 34px;'></div>");
        //$("#footerDropdown").html("<i class='fa fa-circle'></i> <i class='fa fa-circle'></i> <i class='fa fa-circle'></i><hr style='margin-top: 34px;'>");
        //var sec = 3;
        //if(typeof interval != "undefined") clearInterval(interval);
        //interval = setInterval(function(){ 
          //  if(sec == 1){
            //    if(actionOnSetGlobalScope=="filter"){
        if(location.hash.indexOf("#live") >= 0 || location.hash.indexOf("#freedom") >= 0){
            startNewsSearch(true)
        } 
        else if (location.hash.indexOf("#interoperability") >= 0) {
            initTypeSearchInterop();
            startSearchInterop(0,30);
        }
        else{
            if(search.app=="territorial") initTerritorialSearch();
            startSearch(0, indexStepInit); 
        }
              //  }
                //clearInterval(interval);
            /*}
            else{
                sec--;
                var str = "";
                for(n=0;n<sec;n++) str += "<i class='fa fa-circle'></i> ";
                str += "<hr style='margin-top: 34px;'>";
                $("#footerDropdown").html(str);
                if(actionOnSetGlobalScope=="filter")
                    $("#newsstream").html("<div class='col-md-12 text-center'>"+str+"</div>");
            }
        }, 800);*/
        checkScopeMax();
    });
}
function scopeActiveScope(scopeValue, type){
    mylog.log("scopeActive", scopeValue);
    if(type=="communexion"){
    	$.each(myScopes.open,function(e,v){
    		if(e!=scopeValue)
    			myScopes.open[e].active=false;
    		else
    			myScopes.open[e].active=true;
    	});
    	$("#open-breacrum-container .item-scope-input i.fa").addClass("fa-circle-o");
        $("#open-breacrum-container .item-scope-input i.fa").removeClass("fa-check-circle");
        $("#open-breacrum-container .scope-order").addClass("disabled");
        //if(myScopes.open[scopeValue].active){
	    $("#open-breacrum-container [data-scope-value='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-circle-o");
	    $("#open-breacrum-container [data-scope-value='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-check-circle");
	    $("#open-breacrum-container [data-scope-value='"+scopeValue+"'].item-scope-input").parent().removeClass("disabled");
	    //}
    }else{
	    if(myScopes.multiscopes[scopeValue].active){
	    	myScopes.multiscopes[scopeValue].active = true;
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-circle-o");
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-check-circle");
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input").removeClass("disabled");
	    }else{
	    	myScopes.multiscopes[scopeValue].active = false;
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input i.fa").addClass("fa-circle-o");
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input i.fa").removeClass("fa-check-circle");
	        $("[data-scope-value='"+scopeValue+"'].item-scope-input").addClass("disabled");
	    }
	}
}
function sortSpan(a, b){
    return ($(b).data('level')) < ($(a).data('level')) ? 1 : -1;    
}
function scopeObject(communexion, values){
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
		if(communexion.currentLevel=="level1")
			objToPush.active=true;
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
		if(communexion.currentLevel=="level2")
			objToPush.active=true;
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
		if(communexion.currentLevel=="level3")
			objToPush.active=true;
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
		if(communexion.currentLevel=="level4")
			objToPush.active=true;
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
		if(communexion.currentLevel=="cp")
			objToPush.active=true;
		communexionObj[values.cp]=objToPush;
	}
	objToPush={
		name:values.cityName,
		type:"city",
		active:false,
		level:6,
		countryCode:values.country
	}
	if(communexion.currentLevel=="city")
		objToPush.active=true;
	communexionObj[values.city]=objToPush;
	return communexionObj;
}