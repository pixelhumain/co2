function initSearchInterface(){
    
  /*  $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            $(".btn-directory-type").removeClass("active");
            KScrollTo("#content-social");
        }
    });*/
    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            searchPage=0;
            search.value = $(this).val();
            pageCount=true;
            search.count=true;
            if(search.app=="territorial") searchEngine.initTerritorialSearch();
            //if(typeof search.value == "undefined")
            startSearch(0, indexStepInit, searchCallback);
           // else
             //   autoCompleteSearch(search.value, null, null, null, null);
            pageCount=false;
            //KScrollTo("#dropdown_search");
         }
    });
    $("#main-search-bar").change(function(){
        $("#second-search-bar").val($(this).val());
    });

    $("#second-search-bar").keyup(function(e){
        //$("#main-search-bar").val($(this).val());
        //$("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            //initTypeSearch(typeInit);
            simpleScroll('#page');
            searchPage=0;
            search.value = $(this).val();
            search.count=true;
            pageCount=true;
            if(search.app=="territorial") searchEngine.initTerritorialSearch();
            //if(typeof search.value == "undefined")
            startSearch(0, indexStepInit, searchCallback);
            //else
             //   autoCompleteSearch(search.value, null, null, null, null);
            $(".btn-directory-type").removeClass("active");
            //KScrollTo("#content-social");
         }
    });

   /* $("#second-search-bar").keyup(function(e){
        $("#main-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            $(".btn-directory-type").removeClass("active");
            KScrollTo("#content-social");
         }
    });*/

    $("#input-search-map").off().keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        $("#main-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            if(typeInit == "all") initTypeSearch("allSig");
            else initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            $(".btn-directory-type").removeClass("active");
         }
    });

    $("#menu-map-btn-start-search, #menu-btn-start-search, #main-search-bar-addon").off().click(function(){
        $("#second-search-bar").val($("#input-search-map").val());
        $("#main-search-bar").val($("#input-search-map").val());
        console.log("typeInit", typeInit);
        if(typeInit == "all") initTypeSearch("allSig");
        else initTypeSearch(typeInit);
        startSearch(0, indexStepInit, searchCallback);
        $(".btn-directory-type").removeClass("active");
    });

    $(".btn-create-elem").click(function(){
        currentKFormType = $(this).data("ktype");
        var type = $(this).data("type");
        setTimeout(function(){
                    dyFObj.openForm(type);
                 },300);
        
    });

    $(".main-btn-create").click(function(){
        currentKFormType = $(this).data("ktype");
        var type = $(this).data("type");

        if(type=="all"){
            $("#dash-create-modal").modal("show");
            return;
        }

        if(type=="events") type="event";
        if(type=="vote") type="entry";
        dyFObj.openForm(type);
    });
    
}

function startSearchTerla(indexMin, indexMax, callBack){
    var name = $("#second-search-bar").val() != "" ? $("#second-search-bar").val() : $("#new-search-bar").val();
    memorySearch = name;
    var data = {
      "name" : name, 
      "tpl" : "searchTerla",
      "locality" : "",//locality, 
      "searchType" : searchType, 
      "searchTag" : ($('#searchTags').length ) ? $('#searchTags').val().split(',') : [] ,
      "indexMin" : indexMin, 
      "indexMax" : indexMax
    };

    //alert();
    $.blockUI({ message : themeObj.blockUi.processingMsg});
    $.ajax({
        type: "POST",
        url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
        data: data,
        //dataType: "json",
        error: function (data){
             mylog.log(">>> error autocomplete search"); 
             //mylog.dir(data);   
             $(".main-container").html(data.responseText);  
             $("#searchVal").html(name);  
             //signal que le chargement est terminé
            loadingData = false;     
            $.unblockUI();
        },
        success: function(data){ 
            mylog.log(">>> success startSearchTerla", data); //mylog.dir(data);
            $(".main-container").html(data);
            $.unblockUI();
           /* if(!data){ 
              toastr.error(data.content); 
            } 
            else 
            {   
            }*/
           
            //affiche les éléments sur la carte
            //Sig.showMapElements(Sig.map, mapElements, "search", "Résultats de votre recherche");
                        
            //if(typeof callBack == "function")
            //  callBack();
        }
    });
}


/* -------------------------
CLASSIFIED
----------------------------- */
var section = "";
var sectionKey;
var classType = "";
var classSubType = "";
function initClassifiedInterface(){ return;
    classified.currentLeftFilters = null;
    $('#menu-section-'+typeInit).removeClass("hidden");
    $("#btn-create-classified").click(function(){
         dyFObj.openForm('classified');
    });    
}

function bindLeftMenuFilters () { 

    $(".btn-select-type-anc").off().on("click", function()
    {    
        searchType = [ typeInit ];
        indexStepInit = 100;
        
        if( $(this).hasClass( "active" ) )
        {
            sectionKey = null;
            $('#searchTags').val("");
            $('.classifiedSection').remove();
            $(".label-category,.resultTypes").html("");
        } 
        else 
        {

            section = $(this).data("type-anc");
            sectionKey = $(this).data("key");
            //alert("section : " + section);

            if( sectionKey == "forsale" || sectionKey == "forrent" || sectionKey == "job"){
                $("#section-price").show(200);
                setTimeout(function(){
                    KScrollTo("#container-scope-filter");
                }, 400);
            }
            else {
                $("#section-price").hide();
                $("#priceMin").val("");
                $("#priceMax").val("");
                KScrollTo("#container-scope-filter");
            }

            if( jsonHelper.notNull("classified.sections."+sectionKey+".filters") ){
                //alert('build left menu'+classified.sections[sectionKey].filters);
                classified.currentLeftFilters = classified.sections[sectionKey].filters;
                var filters = classified[ classified.currentLeftFilters ]; 
                var what = { title : classified.sections[sectionKey].label, 
                             icon : classified.sections[sectionKey].icon }
                directory.sectionFilter( filters, ".classifiedFilters",what);
                bindLeftMenuFilters ();
                
            }
            else if(classified.currentLeftFilters != null) {
                //alert('rebuild original'); 
                var what = { title : classified.sections[sectionKey].label, 
                             icon : classified.sections[sectionKey].icon }
                directory.sectionFilter( classified.filters, ".classifiedFilters",what);
                bindLeftMenuFilters ();
                classified.currentLeftFilters = null;
            }
            $('#searchTags').val(sectionKey);
        }

        $(".btn-select-type-anc, .btn-select-category-1, .keycat").removeClass("active");
        $(".keycat").addClass("hidden");
        

        if(sectionKey)
            $(this).addClass("active");

        startSearch(0, indexStepInit, searchCallback); 

        if(sectionKey && typeof classified.sections[sectionKey] != "undefined") {
            var label = classified.sections[sectionKey]["labelFront"];
            $(".label-category").html("<i class='fa fa-"+ classified.sections[sectionKey]["icon"] + "'></i> " + tradCategory[label]);
            $('.classifiedSection').remove();
            $(".resultTypes").append( "<span class='classifiedSection text-azure text-bold hidden-xs pull-right'><i class='fa fa-"+ classified.sections[sectionKey]["icon"] + "'></i> " + classified.sections[sectionKey]["label"]+'<i class="fa fa-times text-red resetFilters"></i></span>');
            $(".label-category").removeClass("letter-blue letter-red letter-green letter-yellow").addClass("letter-"+classified.sections[sectionKey]["color"])
            $(".fa-title-list").removeClass("hidden");
        }
    });

    $(".btn-select-category-1").off().on("click", function(){ //alert("onclick");
        searchType = [ typeInit ];
        var searchTxt = "";
        var section = $('#searchTags').val();
        var classType = $(this).data("keycat");
        console.log("bindLeftMenuFilters sectionKey", sectionKey);
        
        if( $(this).hasClass( "active" ) ){
            searchTxt = sectionKey;
            $(this).removeClass( "active" );
            $(".keycat-"+classType).addClass("hidden"); 
        }else{
            $(".btn-select-category-1").removeClass("active");
            $(this).addClass("active");

            $(".keycat").addClass("hidden");
            $(".keycat-"+classType).removeClass("hidden");  

            if(typeof sectionKey != "undefined" && typeof sectionKey != null)
                searchTxt = sectionKey+",";
            
            searchTxt += classType; 
        }
        $('#searchTags').val(searchTxt);
        startSearch(0, indexStepInit, searchCallback);  
    });

    $(".btn-select-category-services").off().on("click", function(){ //alert("onclick");
        var tags = "";
        var keycat = $(this).data("keycat");
        if( $(this).hasClass( "active" ) ){
            $(".btn-select-category-services[data-keycat='"+keycat+"']").removeClass( "active" );
            $(".btn-select-category-services[data-keycat='"+keycat+"']").prop( "checked", false );
        }else{
            $(".btn-select-category-services[data-keycat='"+keycat+"']").addClass("active");
            $(".btn-select-category-services[data-keycat='"+keycat+"']").prop( "checked", true );
        }
        
        //.filterMenuMap

        $.each($("#page .btn-select-category-services"), function (key, value){
            console.log("checked ?", $(this).val());
            if($(this).hasClass( "active" )){
                if(tags!="") tags+=",";
                tags+=$(this).data("keycat");
            }
        });
        $('#searchTags').val(tags);
        startSearch(0, indexStepInit, searchCallback); 
    });

    $(".keycat").off().on("click", function(){
        searchType = [ typeInit ];
        var searchTxt = "";
        var classType = $(this).data("categ");
        var classSubType = $(this).data("keycat");
        if( $(this).hasClass( "active" ) ){
            searchTxt = sectionKey+","+classType;
            $(this).removeClass( "active" );
        }else{
            $(".keycat").removeClass("active");
            $(this).addClass("active");
            
            searchTxt = sectionKey+","+classType+","+classSubType;
        }

        $('#searchTags').val( searchTxt );
        KScrollTo("#container-scope-filter");
        startSearch(0, indexStepInit, searchCallback);  
    });

    $("#btn-create-classified").off().on("click", function(){
         dyFObj.openForm('classified');
    });

    $("#priceMin").filter_input({regex:'[0-9]'}); //[a-zA-Z0-9_] 
    $("#priceMax").filter_input({regex:'[0-9]'}); //[a-zA-Z0-9_] 

    $('#main-search-bar, #second-search-bar, #input-search-map').filter_input({regex:'[^@\"\`/\(|\)/\\\\]'}); //[a-zA-Z0-9_] 

 }

/* -------------------------
END CLASSIFIED
----------------------------- */

/* ----------------------------
        SEARCH ENGINE
-------------------------------*/
var searchEngine = {
    injectData : {},
    allResults : {},
    searchCount: {},
//jQuery(document).ready(function() {
    //setTitle("Espace administrateur : Répertoire","cog");
    //initTypeSearch("all");
   // initInjectData();
    //initTerritorialSearch();
   // startSearch(0, indexStepInit, searchCallback);
  //startSearch(0, 30, null);   
    //initKInterface();
    //initSearchInterface();
    //initViewTable(results);
    /*if(openingFilter != "")
        $('.filter'+openingFilter).trigger("click");
    $(window).bind("scroll",function(){  
      mylog.log("test scroll", scrollEnd, loadingData);
      if(!loadingData && !scrollEnd && !isMapEnd){
        var heightWindow = $("html").height() - $("body").height();
        if( $(this).scrollTop() >= heightWindow - 800){
          startSearch(10, 30, null);
      }
    }
  });
  loadingData = false;*/ 
        
   // initPageTable(results.count.citoyens);

//}); 
    initInjectData: function(){
        searchEngine.injectData={
            organizations : 0,
            projects : 0,
            events : 0,
            citoyens : 0,
            classified : 0,
            poi : 0,
            news : 0,
            place : 0,
            ressource : 0,
            city : 0
        };
    },
    initTerritorialSearch: function (){ console.log("initTerritorialSearch");
        search.ranges={
            organizations : { indexMin : 0, indexMax : 30, waiting : 30 },
            projects : { indexMin : 0, indexMax : 30, waiting : 30 },
            events : { indexMin : 0, indexMax : 30, waiting : 30 },
            citoyens : { indexMin : 0, indexMax : 30, waiting : 30 },
            classified : { indexMin : 0, indexMax : 30, waiting : 30 },
            poi : { indexMin : 0, indexMax : 30, waiting : 30 },
            news : { indexMin : 0, indexMax : 30, waiting : 30 },
            places : { indexMin : 0, indexMax : 30, waiting : 30 },
            ressources : { indexMin : 0, indexMax : 30, waiting : 30 },
            city : { indexMin : 0, indexMax : 30, waiting : 30 },
        };
        initTypeSearch("all");
        searchEngine.allResults={};
        search.app="territorial";
        pageCount=false;
        $(window).bind("scroll",function(){  
            mylog.log("test scroll", scrollEnd, loadingData);
            if(!loadingData && !scrollEnd && !isMapEnd && search.app=="territorial"){
                var heightWindow = $("html").height();// - $("body").height();
                if( $(this).scrollTop() >= heightWindow - 1200)
                    startSearch(10, 30, null);
            }
        });
          //check search.value Or locality filtering to add persons in the research
        //initTypeSearch("all");
    },
    prepareAllSearch: function(data){
        sorting=[];
        searchType=[];
        $i=0;
        resToShow={};
        searchEngine.initInjectData();
        $.each(data, function(e,v){
            searchEngine.allResults[e]=v;
        });
        $.each(searchEngine.allResults, function(e,v ){
            if (searchType.indexOf(v.type) == -1)
                searchType.push(v.type);
            sorting.push(v.sorting);
        });
        sorting.sort().reverse();
        sorting=sorting.splice(0,30);
        $.each(sorting, function(e, v){
            $.each(searchEngine.allResults, function(key, value){
              if(v==value.sorting){
                resToShow[key]=value;
                searchEngine.injectData[value.type]++;
                delete searchEngine.allResults[key];
                $i++;
              }
            });
        });
        $.each(searchEngine.injectData, function (type, v){ console.log("search range", type);
            if(v==0)
              removeSearchType(type);
            else{
              search.ranges[type].indexMin=search.ranges[type].indexMax;
              search.ranges[type].indexMax=search.ranges[type].indexMin+v;
            }
          });
        return resToShow;
    }
};