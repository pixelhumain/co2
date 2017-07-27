
function bindCommunexionScopeEvents(){
    $(".btn-decommunecter").click(function(){
        activateGlobalCommunexion(false); 
    });
    $(".item-globalscope-checker").click(function(){  
        $(".item-globalscope-checker").addClass("inactive");
        $(this).removeClass("inactive");
        mylog.log("globalscope-checker",  $(this).data("scope-name"), $(this).data("scope-type"));
        setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"), $(this).data("scope-level"),
                         $(this).data("insee-communexion"), $(this).data("name-communexion"), $(this).data("cp-communexion"), 
                         $(this).data("region-communexion"), $(this).data("country-communexion")) ;
    });
    $(".item-scope-input").off().on("click", function(){ 
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
        if (typeof $.cookie('communexionName') !== 'undefined'){
            activateGlobalCommunexion(true);
            if(actionOnSetGlobalScope=="save")
                $(".item-globalscope-checker").attr('disabled', true);
        }else{
            communecterUser();
        }
    });
}
function activateGlobalCommunexion(active, firstLoad){  mylog.log("activateGlobalCommunexion", active);
    $.cookie('communexionActivated', active, { expires: 365, path: "/" });
    globalCommunexion=active;
    if(active){
        headerHtml='<i class="fa fa-university"></i> ' + $.cookie('communexionName') + "<small class='text-dark'>.CO</small>"
        //setGlobalScope($.cookie('communexionValue'), $.cookie('communexionName'), $.cookie('communexionType'), $.cookie('communexionLevel'));
        $("#container-scope-filter").html(getBreadcrumCommunexion());
        if(actionOnSetGlobalScope=="save")
            $("#scopeListContainerForm").html(getBreadcrumCommunexion());
        bindCommunexionScopeEvents();
    }
    else{
        headerHtml='<a href="#" class="menu-btn-back-category" data-target="#modalMainMenu" data-toggle="modal">'+
                '<img src="'+themeUrl+'/assets/img/LOGOS/'+domainName+'/logo-head-search.png" height="60" class="inline margin-bottom-15">'+
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
    tips="";
    if(typeof communexion["values"]["cities"] != "undefined") {
        $.each(communexion["values"]["cities"],function(e,v){
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

    htmlCommunexion+='<i class="fa fa-university fa-2x text-red"></i>'+ 
        '<div class="getFormLive" style="display:inline-block;">'+
            '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
                'class="btn btn-link text-red item-globalscope-checker homestead '; 
                if($.cookie('communexionName')!=communexion.values.regionName)
                    htmlCommunexion+="inactive";
    htmlCommunexion+= '" data-scope-value="'+communexion.values.regionName+'" '+
                'data-scope-name="'+communexion.values.regionName+'" '+
                'data-scope-type="region">'+
                '<i class="fa fa-angle-right"></i>  '+communexion.values.regionName+
            '</button>'+ 
            '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
                'class="btn btn-link text-red item-globalscope-checker homestead ';
                if($.cookie('communexionName')!=communexion.values.depName)
                    htmlCommunexion+="inactive";
    htmlCommunexion+= '" data-scope-value="'+communexion.values.depName+'" '+
                'data-scope-name="'+communexion.values.depName+'" '+
                'data-scope-type="dep">'+
                '<i class="fa fa-angle-right"></i>  '+communexion.values.depName+
            '</button>';
    if(communexion.levelMinCommunexion=="inseeCommunexion"){
        htmlCommunexion+= '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
                    'class="btn btn-link text-red item-globalscope-checker homestead tooltips ';
                    if($.cookie('communexionName')!=communexion.values.cityCp)
                        htmlCommunexion+="inactive";
        htmlCommunexion+= '" data-scope-value="'+communexion.values.cityCp+'" '+
                    'data-scope-name="'+communexion.values.cityCp+'" '+
                    'data-scope-type="cp" '+
                    'data-scope-level="'+communexion.levelMinCommunexion+'" '+
                    'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'">'+
                    '<i class="fa fa-angle-right"></i>  '+communexion.values.cityCp+
                '</button>'+
                '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
                    'class="btn btn-link text-red item-globalscope-checker homestead ';
                    if($.cookie('communexionName')!=communexion.values.cityName)
                        htmlCommunexion+="inactive";
        htmlCommunexion+= '" data-scope-value="'+communexion.values.cityKey+'" '+
                    'data-scope-name="'+communexion.values.cityName+'" '+
                    'data-scope-type="city" '+
                    'data-scope-level="'+communexion.levelMinCommunexion+'">'+
                    '<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+
                '</button>';
    }else{
        htmlCommunexion+= '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
                    'class="btn btn-link text-red item-globalscope-checker homestead tooltips ';
                    if($.cookie('communexionName')!=communexion.values.inseeName)
                        htmlCommunexion+="inactive";
        htmlCommunexion+= '" data-scope-value="'+communexion.values.cityKey+'" '+
                    'data-scope-name="'+communexion.values.inseeName+'" '+
                    'data-scope-type="city" '+
                    'data-scope-level="'+communexion.levelMinCommunexion+'" '+
                    'data-toggle="tooltip" data-placement="bottom" data-original-title="'+tips+'"'+'>'+
                    '<i class="fa fa-angle-right"></i>  '+communexion.values.inseeName+' (toute la ville)'+
                '</button>'+
                '<button data-toggle="dropdown" data-target="dropdown-multi-scope" '+
                    'class="btn btn-link text-red item-globalscope-checker homestead ';
                    if($.cookie('communexionName')!=communexion.values.cityName)
                        htmlCommunexion+='inactive';
        htmlCommunexion+= '" data-scope-value="'+communexion.values.cityKey+'" '+
                    'data-scope-name="'+communexion.values.cityName+'" '+
                    'data-scope-type="cp" '+
                    'data-scope-level="'+communexion.levelMinCommunexion+'">'+
                    '<i class="fa fa-angle-right"></i>  '+communexion.values.cityName+
                '</button>';
    }
    htmlCommunexion+= '</div>'+
        '</div>';
    return htmlCommunexion;
}