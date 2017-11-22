function scopeActive(scopeValue){
    mylog.log("scopeActive", scopeValue);
    if(myMultiScopes[scopeValue].active){
        $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-circle-o");
        $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-check-circle");
        $("[data-scope-value='"+scopeValue+"'].item-scope-input").removeClass("disabled");
    }else{
        $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-circle-o");
        $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-check-circle");
        $("[data-scope-value='"+scopeValue+"'].item-scope-input").addClass("disabled");
    }
}

function itenGlobalScopeChecker(elt){
	mylog.log("itenGlobalScopeChecker", elt.data("scope-search"));
    elt.removeClass("inactive");
    var search = elt.data("scope-search");
    var testCo = false;
    mylog.log("itenGlobalScopeChecker search", search);
    if(elt.hasClass("communecterSearch")){
    	mylog.log("itenGlobalScopeChecker here");
        testCo = true;
        communexion.cities = trad.allcitieswiththispostalcode
        $("#main-search-bar").val("");

         mylog.log("itenGlobalScopeChecker indexOf", location.hash.indexOf("#search"));
        if(location.hash.indexOf("#search") != -1){
        	mylog.log("itenGlobalScopeChecker here2");
            search = true;
        }
        toastr.success(trad.thecommunexionhaschanged);
    }
    mylog.log("globalscope-checker",  elt.data("scope-name"), elt.data("scope-type"), search);
    setGlobalScope( elt.data("scope-value"), elt.data("scope-name"), elt.data("scope-type"), elt.data("scope-level"),
                     elt.data("scope-values"), search, testCo) ;
}


function bindCommunexionScopeEvents(){
    $(".btn-decommunecter").off().on('click',function(){
        activateGlobalCommunexion(false); 
    });

    $(".item-globalscope-checker").click(function(){  
        $(".item-globalscope-checker").addClass("inactive");
        mylog.log(".item-globalscope-checker",  $(this).data("scope-name"), $(this).data("scope-type"), $(this).data("scope-level"));
        mylog.log(".item-globalscope-checker search",  $(this).data("scope-search"));
        itenGlobalScopeChecker($(this));
        // $(this).removeClass("inactive");
        // var notSearch = $(this).data("scope-notsearch");
        // var testCo = false;
        // if($(this).hasClass("communecterSearch")){
        //     testCo = true;
        //     communexion.cities = trad.allcitieswiththispostalcode
        //     $("#main-search-bar").val("");
        //     if(location.hash.indexOf("#search")){
        //         notSearch = false;
        //     }
        //     toastr.success(trad.thecommunexionhaschanged);
        // }
        // mylog.log("globalscope-checker",  $(this).data("scope-name"), $(this).data("scope-type"));
        // setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"), $(this).data("scope-level"),
        //                  $(this).data("scope-values"),  notSearch, testCo) ;
    });
    
    $(".item-scope-input").off().on("click", function(){ 
        scopeValue=$(this).data("scope-value");
        
        // if($(this).hasClass("disabled")){
        //     $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-circle-o");
        //     $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-check-circle");
        //     $("[data-scope-value='"+scopeValue+"'].item-scope-input").removeClass("disabled");
        // }else{
        //     $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-circle-o");
        //     $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-check-circle");
        //     $("[data-scope-value='"+scopeValue+"'].item-scope-input").addClass("disabled");
        // }
        toogleScopeMultiscope( $(this).data("scope-value") );
        scopeActive(scopeValue);
        if(actionOnSetGlobalScope=="filter")
            $("#newsstream").html("<div class='col-md-12 text-center'><i class='fa fa-circle'></i> <i class='fa fa-circle'></i> <i class='fa fa-circle'></i><hr style='margin-top: 34px;'></div>");
        $("#footerDropdown").html("<i class='fa fa-circle'></i> <i class='fa fa-circle'></i> <i class='fa fa-circle'></i><hr style='margin-top: 34px;'>");
        var sec = 3;
        if(typeof interval != "undefined") clearInterval(interval);
        interval = setInterval(function(){ 
            if(sec == 1){
                if(actionOnSetGlobalScope=="filter"){
                    if(location.hash.indexOf("#live") >= 0){
                        startNewsSearch(true)
                    } 
                    else if (location.hash.indexOf("#interoperability") >= 0) {
                        initTypeSearchInterop();
                        startSearchInterop(0,30);
                    }
                    else{
                        startSearch(0, indexStepInit); 
                    }
                }
                clearInterval(interval);
            }
            else{
                sec--;
                var str = "";
                for(n=0;n<sec;n++) str += "<i class='fa fa-circle'></i> ";
                str += "<hr style='margin-top: 34px;'>";
                $("#footerDropdown").html(str);
                if(actionOnSetGlobalScope=="filter")
                    $("#newsstream").html("<div class='col-md-12 text-center'>"+str+"</div>");
            }
        }, 800);
        checkScopeMax();
    });

    $(".start-new-communexion").click(function(){
        mylog.log("start-new-communexion", typeof communexion.currentName);
        if (typeof communexion.currentName !== 'undefined'){
            activateGlobalCommunexion(true, true);
            if(actionOnSetGlobalScope=="save")
                $(".item-globalscope-checker").attr('disabled', true);
        }else{
            communecterUser();
        }
    });
}
function activateGlobalCommunexion(active, firstLoad){  
	mylog.log("activateGlobalCommunexion", active, firstLoad);
    mylog.log("activateGlobalCommunexion actionOnSetGlobalScope", actionOnSetGlobalScope);
    $.cookie('communexionActivated', active, { expires: 365, path: "/" });
    communexion.state=active;
    if(active){
        headerHtml='<i class="fa fa-university"></i> ' + communexion.currentName + "<small class='text-dark'>.CO</small>";
        //if(firstLoad)
            $("#container-scope-filter").html(getBreadcrumCommunexion());
        if(actionOnSetGlobalScope=="save")
            $("#scopeListContainerForm").html(getBreadcrumCommunexion());

        if(actionOnSetGlobalScope=="filter"){
            if(location.hash.indexOf("#live") >=0)
                startNewsSearch(true);
            else
                startSearch(0, indexStepInit,searchCallback);
        }
        bindCommunexionScopeEvents();
    }else{
        headerHtml='<a href="#" class="menu-btn-back-category" data-target="#modalMainMenu" data-toggle="modal">'+
                '<img src="'+themeUrl+'/assets/img/LOGOS/'+domainName+'/logo-head-search.png" height="60" class="inline">'+
                '</a>';
        saveCookieMultiscope();
        showTagsScopesMin();
        bindCommunexionScopeEvents();

        if(actionOnSetGlobalScope=="filter"){
            if(location.hash.indexOf("#live") >=0)
                startNewsSearch(true);
            else
                startSearch(0, indexStepInit,searchCallback);
        }
    }
    $("#main-scope-name").html(headerHtml);
    $('.tooltips').tooltip();
}
function getBreadcrumCommunexion(){
    var tips="";

    if(typeof communexion.cities == "string") {
        tips = communexion.cities ;
    }else if(typeof communexion.cities != "undefined") {
    	$.each(communexion.cities,function(e,v){
            tips+=v+" / ";
        });
    }


    htmlCommunexion='<div class="breadcrum-communexion col-md-12">';
    if(actionOnSetGlobalScope=="filter"){
        htmlCommunexion+='<button class="btn btn-link text-red btn-decommunecter tooltips" data-toggle="tooltip" data-placement="top" title="Quitter la communexion">'+
            '<i class="fa fa-times"></i>'+
        '</button>';
    }else{
        htmlCommunexion+='<a class="btn btn-link text-red btn-decommunecter tooltips" data-toggle="tooltip" data-placement="top" title="Quitter la communexion">'+
            '<i class="fa fa-times"></i>'+
        '</a>';
    }

	htmlCommunexion+=	'<i class="fa fa-university fa-2x text-red"></i>'+
							'<div class="getFormLive" style="display:inline-block;">';

	if(communexion.values && communexion.values.level2){
		htmlCommunexion+=			'<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="btn btn-link text-red item-globalscope-checker homestead '; 
											if( communexion.currentLevel != "level2" )
												htmlCommunexion+="inactive";
		htmlCommunexion+=					'" data-scope-value="'+communexion.values.level2+'" '+
											'data-scope-search="'+true+'"' +
											'data-scope-name="'+communexion.values.level2Name+'" '+
											'data-scope-type="'+communexion.communexionType+'" '+
											'data-scope-level="level2">'+
										'<i class="fa fa-angle-right"></i>  '+communexion.values.level2Name+
									'</button>';
	}

	if(communexion.values && communexion.values.level3){
		htmlCommunexion+=			'<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="btn btn-link text-red item-globalscope-checker homestead '; 
											if( communexion.currentLevel != "level3" )
												htmlCommunexion+="inactive";
		htmlCommunexion+=					'" data-scope-value="'+communexion.values.level3+'" '+
											'data-scope-search="'+true+'"' +
											'data-scope-name="'+communexion.values.level3Name+'" '+
											'data-scope-type="'+communexion.communexionType+'" '+
											'data-scope-level="level3">'+
										'<i class="fa fa-angle-right"></i>  '+communexion.values.level3Name+
									'</button>';
	}

	if(communexion.values && communexion.values.level4){
		htmlCommunexion+=			'<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
										'class="btn btn-link text-red item-globalscope-checker homestead ';
											if( communexion.currentLevel != "level4" )
												htmlCommunexion+="inactive";
		htmlCommunexion+= 					'" data-scope-value="'+communexion.values.level4+'" '+
											'data-scope-search="'+true+'"' +
											'data-scope-name="'+communexion.values.level4Name+'" '+
											'data-scope-type="'+communexion.communexionType+'" '+
											'data-scope-level="level4">'+
										'<i class="fa fa-angle-right"></i>  '+communexion.values.level4Name+
									'</button>';
	}
    mylog.log("communexion.values bred", communexion.values);

	if(notNull(communexion.values.postalCodes) && communexion.values.postalCodes.length == 1){
		if(notNull(communexion.cities) && communexion.cities.length != 1){
			htmlCommunexion+= '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
							'class="btn btn-link text-red item-globalscope-checker homestead tooltips ';
								if( communexion.currentLevel != "cp" )
									htmlCommunexion+="inactive";
			htmlCommunexion+= 		'" data-scope-value="'+communexion.values.city+'" '+
									'data-scope-name="'+communexion.values.cp+'" '+
									'data-scope-type="cp" '+
									'data-scope-level="cp" '+
									'data-scope-search="'+true+'"' +
									'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'">'+
								'<i class="fa fa-angle-right"></i>  '+communexion.values.cp+
							'</button>';
		}

		htmlCommunexion+= '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
							'class="btn btn-link text-red item-globalscope-checker homestead ';
							if( communexion.currentLevel != "city" )
									htmlCommunexion+="inactive";
		htmlCommunexion+= 	'" data-scope-value="'+communexion.values.city+'" '+
							'data-scope-name="'+communexion.values.cityName+'" '+
							'data-scope-type="city" '+
							'data-scope-level="city"'+
							'data-scope-search="'+true+'">' +
						'<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+
					'</button>';
	} else {
		htmlCommunexion+= 	'<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
									'class="btn btn-link text-red item-globalscope-checker homestead tooltips ';
								if( communexion.communexionType != "city" )
									htmlCommunexion+="inactive";
		htmlCommunexion+= 		'" data-scope-value="'+communexion.values.city+'" '+
									'data-scope-name="'+communexion.values.cityName+'" '+
									'data-scope-type="city" '+
									'data-scope-level="city" '+
									'data-scope-search="'+true+'"' +
									'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'"'+'>'+
									'<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+' ('+trad.allthecity+')'+
							'</button>';
		htmlCommunexion+= 	'<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
									'class="btn btn-link text-red item-globalscope-checker homestead  ';
								if( communexion.communexionType != "cp" )
										htmlCommunexion+="inactive";
		htmlCommunexion+= 		'"data-scope-value="'+communexion.values.city+'" '+
									'data-scope-name="'+communexion.values.cityName+'" '+
									'data-scope-type="cp" '+
									'data-scope-level="city"'+
									'data-scope-search="'+true+'">' +
									'<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+
							'</button>';
	}


	// if(notNull(communexion.cities) && communexion.cities.length != 1){
	// 	htmlCommunexion+= '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
	// 						'class="btn btn-link text-red item-globalscope-checker homestead tooltips ';
	// 							if( communexion.currentLevel != "cp" )
	// 								htmlCommunexion+="inactive";
	// 		htmlCommunexion+= 	'" data-scope-value="'+communexion.values.city+'" '+
	// 							'data-scope-name="'+communexion.values.cp+'" '+
	// 							'data-scope-type="cp" '+
	// 							'data-scope-level="cp" '+
	// 							'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'">'+
	// 						'<i class="fa fa-angle-right"></i>  '+communexion.values.cp+
	// 					'</button>'+
	// 					'<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
	// 						'class="btn btn-link text-red item-globalscope-checker homestead ';
	// 							if( communexion.currentLevel != "city" )
	// 									htmlCommunexion+="inactive";
	// 		htmlCommunexion+= 	'" data-scope-value="'+communexion.values.city+'" '+
	// 							'data-scope-name="'+communexion.values.cityName+'" '+
	// 							'data-scope-type="city" '+
	// 							'data-scope-level="city">'+
	// 						'<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+
	// 					'</button>';
 //    }else{
 //        htmlCommunexion+= '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
 //                    'class="btn btn-link text-red item-globalscope-checker homestead tooltips ';
	// 							if( communexion.currentLevel != "cp" )
	// 								htmlCommunexion+="inactive";
	// 		htmlCommunexion+= 	'" data-scope-value="'+communexion.values.city+'" '+
 //                    'data-scope-name="'+communexion.values.cityName+'" '+
 //                    'data-scope-type="city" '+
 //                    'data-scope-level="city" '+
 //                    'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'"'+'>'+
 //                    '<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+' ('+trad.allthecity+')'+
 //                '</button>'+
 //                '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
 //                    'class="btn btn-link text-red item-globalscope-checker homestead  ';
	// 							if( communexion.currentLevel != "city" )
	// 									htmlCommunexion+="inactive";
	// 		htmlCommunexion+= 	'"data-scope-value="'+communexion.values.city+'" '+
 //                    'data-scope-name="'+communexion.values.cityName+'" '+
 //                    'data-scope-type="cp" '+
 //                    'data-scope-level="city">'+
 //                    '<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+
 //                '</button>';
 //    }
    htmlCommunexion+= '</div>'+
        '</div>';
    return htmlCommunexion;
}