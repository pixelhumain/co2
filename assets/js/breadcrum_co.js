
function bindCommunexionScopeEvents(){
    $(".btn-decommunecter").off().on('click',function(){
        activateGlobalCommunexion(false); 
    });

    $(".item-globalscope-checker").click(function(){  
        $(".item-globalscope-checker").addClass("inactive");
        $(this).removeClass("inactive");
        mylog.log("globalscope-checker",  $(this).data("scope-name"), $(this).data("scope-type"));
        setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"), $(this).data("scope-level"),
                         $(this).data("scope-values"),  $(this).data("scope-notsearch")) ;
    });
    
    $(".item-scope-input").click(function(){ 
        scopeValue=$(this).data("scope-value");
        if($(this).hasClass("disabled")){
            $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-circle-o");
            $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-check-circle");
            $("[data-scope-value='"+scopeValue+"'].item-scope-input").removeClass("disabled");
        }else{
            $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").addClass("fa-circle-o");
            $("[data-scope-value='"+scopeValue+"'] .item-scope-checker i.fa").removeClass("fa-check-circle");
            $("[data-scope-value='"+scopeValue+"'].item-scope-input").addClass("disabled");
        }
        toogleScopeMultiscope( $(this).data("scope-value") );
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
            activateGlobalCommunexion(true);
            if(actionOnSetGlobalScope=="save")
                $(".item-globalscope-checker").attr('disabled', true);
        }else{
            communecterUser();
        }
    });
}
function activateGlobalCommunexion(active, firstLoad){  
	mylog.log("activateGlobalCommunexion", active);
    $.cookie('communexionActivated', active, { expires: 365, path: "/" });
    communexion.state=active;
    if(active){
        headerHtml='<i class="fa fa-university"></i> ' + communexion.currentName + "<small class='text-dark'>.CO</small>"
        //setGlobalScope($.cookie('communexionValue'), communexion.currentName, $.cookie('communexionType'), $.cookie('communexionLevel'));
        $("#container-scope-filter").html(getBreadcrumCommunexion());
        if(actionOnSetGlobalScope=="save")
            $("#scopeListContainerForm").html(getBreadcrumCommunexion());
        //startSearch(0, indexStepInit,searchCallback);
        if(actionOnSetGlobalScope=="filter"){
            if(location.hash.indexOf("#live") >=0)
                startNewsSearch(true);
            else if(!firstLoad)
                startSearch(0, indexStepInit,searchCallback);
        }
        bindCommunexionScopeEvents();
    }else{
        headerHtml='<a href="#" class="menu-btn-back-category" data-target="#modalMainMenu" data-toggle="modal">'+
                '<img src="'+themeUrl+'/assets/img/LOGOS/'+domainName+'/logo-head-search.png" height="60" class="inline">'+
                '</a>';
        saveCookieMultiscope();
        //rebuildSearchScopeInput();
        showTagsScopesMin();
        bindCommunexionScopeEvents();

        if(actionOnSetGlobalScope=="filter"){
            if(location.hash.indexOf("#live") >=0)
                startNewsSearch(true);
            else if(!firstLoad)
                startSearch(0, indexStepInit,searchCallback);
        }
    }
    $("#main-scope-name").html(headerHtml);
    $('.tooltips').tooltip();
}
function getBreadcrumCommunexion(){
    var tips="";

    if(typeof communexion.cities != "undefined") {
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
											'data-scope-name="'+communexion.values.level4Name+'" '+
											'data-scope-type="'+communexion.communexionType+'" '+
											'data-scope-level="level4">'+
										'<i class="fa fa-angle-right"></i>  '+communexion.values.level4Name+
									'</button>';
	}

	if(communexion.communexionType=="city"){
		htmlCommunexion+= '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
							'class="btn btn-link text-red item-globalscope-checker homestead tooltips ';
								if( communexion.currentLevel != "cp" )
									htmlCommunexion+="inactive";
			htmlCommunexion+= 	'" data-scope-value="'+communexion.values.cp+'" '+
								'data-scope-name="'+communexion.values.cp+'" '+
								'data-scope-type="'+communexion.communexionType+'" '+
								'data-scope-level="cp" '+
								'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'">'+
							'<i class="fa fa-angle-right"></i>  '+communexion.values.cp+
						'</button>'+
						'<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
							'class="btn btn-link text-red item-globalscope-checker homestead ';
								if( communexion.currentLevel != "city" )
										htmlCommunexion+="inactive";
			htmlCommunexion+= 	'" data-scope-value="'+communexion.values.city+'" '+
								'data-scope-name="'+communexion.values.cityName+'" '+
								'data-scope-type="city" '+
								'data-scope-level="city">'+
							'<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+
						'</button>';
    }else{
        htmlCommunexion+= '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
                    'class="btn btn-link text-red item-globalscope-checker homestead tooltips ';
								if( communexion.currentLevel != "cp" )
									htmlCommunexion+="inactive";
			htmlCommunexion+= 	'" data-scope-value="'+communexion.values.city+'" '+
                    'data-scope-name="'+communexion.values.cityName+'" '+
                    'data-scope-type="'+communexion.communexionType+'" '+
                    'data-scope-level="cp" '+
                    'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'"'+'>'+
                    '<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+' (toute la ville)'+
                '</button>'+
                '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
                    'class="btn btn-link text-red item-globalscope-checker homestead  ';
								if( communexion.currentLevel != "city" )
										htmlCommunexion+="inactive";
			htmlCommunexion+= 	'"data-scope-value="'+communexion.values.city+'" '+
                    'data-scope-name="'+communexion.values.cityName+'" '+
                    'data-scope-type="'+communexion.communexionType+'" '+
                    'data-scope-level="city">'+
                    '<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+
                '</button>';
    }
    htmlCommunexion+= '</div>'+
        '</div>';
    return htmlCommunexion;
}