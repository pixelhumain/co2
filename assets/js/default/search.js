function initSearchInterface(){
    
    if(searchObject.text != "") $("#main-search-bar, #second-search-bar").val(searchObject.text);
    $(".theme-header-filter").off().on("click",function(){
            if(!$("#filter-thematic-menu").is(":visible") || $(this).hasClass("toogle-filter"))
                $("#filter-thematic-menu").toggle();
    });
    $("#filters-container-menu .theme-header-filter, #filters-container-menu .scope-header-filter").click(function(){
        simpleScroll(0, 500);
    });

    $(".scope-header-filter").off().on("click",function(){
        $("#searchOnCity").trigger("click");
    });
    
    $(".btn-select-filliaire").off().on("click",function(){
        mylog.log(".btn-select-filliaire");
        var fKey = $(this).data("fkey");
        myMultiTags = {};
        searchObject.text="";
        $.each(filliaireCategories[fKey]["tags"], function(key, tag){
            tag=(typeof tradTags[tag] != "undefined") ? tradTags[tag] : tag;
            searchObject.text+="#"+tag+" ";
        });
        $("#filter-thematic-menu").hide();
        $("#main-search-bar, #second-search-bar").val(searchObject.text);
        mylog.log("myMultiTags", myMultiTags);
        
        searchObject.page=0;
        pageCount=true;
        searchObject.count=true;
        if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
        
        startSearch(0, indexStepInit, searchCallback);
    });
    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13 || $(this).val() == "" ){
            searchObject.page=0;
            searchObject.text = $(this).val();
            pageCount=true;
            searchObject.count=true;
            if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
            startSearch(0, indexStepInit, searchCallback);
        }
    });
    $("#main-search-bar").change(function(){
        $("#second-search-bar").val($(this).val());
    });

    $("#second-search-bar").keyup(function(e){
        $("#main-search-bar").val($(this).val());
        //$("#input-search-map").val($(this).val());
        if(e.keyCode == 13 || $(this).val() == ""){
            //initTypeSearch(typeInit);
            scrollH= ($("#filter-thematic-menu").is(":visible")) ? 250 : 0;
            simpleScroll(scrollH);
            searchPage=0;
            searchObject.text = $(this).val();
            searchObject.count=true;
            pageCount=true;
            if(searchObject.initType=="territorial") searchAllEngine.initSearch();
            //if(typeof searchObject.text == "undefined")
            startSearch(0, indexStepInit, searchCallback);
            //else
             //   autoCompleteSearch(searchObject.text, null, null, null, null);
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
            searchObject.text = $(this).val();
            searchObject.count=true;
            pageCount=true;
            if(searchObject.app=="territorial") searchAllEngine.initSearch();
            startSearch(0, indexStepInit, searchCallback);
            $(".btn-directory-type").removeClass("active");
         }
    });

    $("#menu-map-btn-start-search, .menu-btn-start-search, #main-search-bar-addon").off().on("click", function(){
        scrollH= ($("#filter-thematic-menu").is(":visible")) ? 250 : 0;
        simpleScroll(scrollH);
        if($(this).hasClass("menu-btn-start-search"))
            searchObject.text=$("#second-search-bar").val();
        else if ($(this).hasClass("input-group-addon"))   
            searchObject.text=$("#main-search-bar").val();
        else
            searchObject.text=$("#input-search-map").val();
        $("#second-search-bar, #main-search-bar, #input-search-map").val(searchObject.text);
        searchPage=0;
        searchObject.count=true;
        pageCount=true;
        if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
        //if(typeInit == "all") initTypeSearch("allSig");
        //else initTypeSearch(typeInit);
        startSearch(0, indexStepInit, searchCallback);
        $(".btn-directory-type").removeClass("active");
    });


    $(".main-btn-create").off().on("click",function(){
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
        pageCount=true;
        searchObject.count=true;
        
        if( $(this).hasClass( "active" ) )
        {
            sectionKey = null;
            //searchObject.tags=[];
            if(typeof searchObject.section != "undefined") delete searchObject.section;
            $('.classifiedSection').remove();
            $(".label-category,.resultTypes").html("");
        } 
        else 
        {
            section = $(this).data("type-anc");
            sectionKey = $(this).data("key");
            //alert("section : " + section);

            if( sectionKey == "forsale" || sectionKey == "forrent" || sectionKey == "job" || sectionKey == "all"){
                $("#section-price").show(200);
                setTimeout(function(){
                    KScrollTo("#container-scope-filter");
                }, 400);
            }
            else {
                $("#section-price").hide();
                $("#priceMin").val("");
                $("#priceMax").val("");
                delete searchObject.priceMin;
                delete searchObject.priceMax;
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
            if( $(this).data("key") == "all" ) delete searchObject.section;//sectionKey = "";
            else searchObject.section =  sectionKey;
        }

        $(".btn-select-type-anc, .btn-select-category-1, .keycat").removeClass("active");
        $(".keycat").addClass("hidden");
        
        if(typeof searchObject.searchSType != "undefined") delete searchObject.searchSType;
        if(typeof searchObject.subType != "undefined") delete searchObject.subType;
        if(typeof searchObject.section != "undefined")
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

    $(".btn-select-category-1").off().on("click", function(){ 
        //alert(".btn-select-category-1");
        searchType = [ typeInit ];
        var searchTxt = "";
        //var section = searchObject.tags.join(",");//$('#searchTags').val();
        var classType = $(this).data("keycat");
        console.log("bindLeftMenuFilters sectionKey", sectionKey);
        // Event for count in DB
        pageCount=true;
        searchObject.count=true;
        if(typeof searchObject.subType != "undefined") delete searchObject.subType;
        if( $(this).hasClass( "active" ) ){
            if(typeof searchObject.searchSType != "undefined") delete searchObject.searchSType;
            //searchObject.tags=[sectionKey];//searchTxt = sectionKey;
            $(this).removeClass( "active" );
            $(".keycat-"+classType).addClass("hidden").removeClass("active"); 
        }else{
            $(".btn-select-category-1").removeClass("active");
            $(this).addClass("active");

            $(".keycat").addClass("hidden");
            $(".keycat-"+classType).removeClass("hidden");  
            searchObject.searchSType=classType;
            //if(typeof sectionKey != "undefined" && typeof sectionKey != null)
            //    searchObject.tags=[sectionKey];//searchTxt = sectionKey+",";
            //searchObject.tags.push(classType);
            //searchTxt += classType; 
        }

        //$('#searchTags').val(searchTxt);
        //alert("section : " + $('#searchTags').val());
        startSearch(0, indexStepInit, searchCallback);  
    });

    $(".btn-select-category-services").off().on("click", function(){ alert("onclick");
        searchObject.tags=[];//tags = "";
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
                //if(tags!="") tags+=",";
                searchObject.tags.push($(this).data("keycat"));//tags+=$(this).data("keycat");
            }
        });
        //$('#searchTags').val(tags);
        startSearch(0, indexStepInit, searchCallback); 
    });

    $(".keycat").off().on("click", function(){
        searchObject.types = [ typeInit ];
        //searchObject.tags=[];
        var searchTxt = "";
        var classType = $(this).data("categ");
        var classSubType = $(this).data("keycat");
        // Event for count in DB
        pageCount=true;
        searchObject.count=true;
        if( $(this).hasClass( "active" ) ){
            //searchObject.tags.push(classType);
            //if(typeof sectionKey != "undefined" && typeof sectionKey != null)
            //    searchObject.tags.push(sectionKey);//searchTxt = sectionKey+","+classType;
            if(typeof searchObject.subType != "undefined") delete searchObject.subType;
            //else
                //searchTxt = classType;
            $(this).removeClass( "active" );
        }else{
            $(".keycat").removeClass("active");
            $(this).addClass("active");
            searchObject.subType=classSubType;
            searchObject.searchSType=classType;
            //searchObject.tags.push(classType, classSubType);
            //if(typeof sectionKey != "undefined" && typeof sectionKey != null)
            //    searchObject.tags.push(sectionKey);
                //searchTxt = sectionKey+","+classType+","+classSubType;
            //else
              //  searchTxt = classType+","+classSubType;
        }

        //$('#searchTags').val( searchTxt );
        //alert("section : " + $('#searchTags').val());
        KScrollTo("#container-scope-filter");
        startSearch(0, searchObject.indexStep, searchCallback);  
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
function constructSearchObjectAndGetParams(){
  onchangeClick=false;
  getStatus="";//location.hash+"?";
  var searchConstruct={};
  if(searchObject.text != ""){
    searchConstruct.name=searchObject.text;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="text="+searchObject.text;
  }
  if(typeof searchObject.types != "undefined" && searchObject.types.length==1 && searchObject.initType=="all"){
    searchConstruct.searchType=searchObject.types;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="types="+searchObject.types.join(",");
  }else{
    searchConstruct.searchType=searchObject.types;
  }
  if(searchObject.tags != ""){
    searchConstruct.searchTags=searchObject.tags;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="tags="+searchObject.tags.join(",");
  }
  if(typeof searchObject.page != "undefined" && searchObject.page>0){
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="page="+(searchObject.page+1);
  }
  if(typeof searchObject.searchSType != "undefined"){
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="searchSType="+searchObject.searchSType;
    searchConstruct.searchSType = searchObject.searchSType;
  }
  if(typeof searchObject.section != "undefined"){
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="section="+searchObject.section;
    searchConstruct.section = searchObject.section;
  }
  if(typeof searchObject.subType != "undefined"){
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="subType="+searchObject.subType;
    searchConstruct.subType = searchObject.subType;
  }
  if(typeof searchObject.startDate != "undefined"){
    if(searchObject.text==""){
      getStatus+=(getStatus!="") ? "&":"";
      getStatus+="startDate="+searchObject.startDate;
      searchConstruct.startDate = searchObject.startDate;
      $(".calendar").show(700);
    }else
      $(".calendar").hide(700);
  }
  if(typeof searchObject.endDate != "undefined"){
    if(searchObject.text==""){
      getStatus+=(getStatus!="") ? "&":"";
      getStatus+="endDate="+searchObject.endDate;
      searchConstruct.endDate = searchObject.endDate;
    }
  }
  if(typeof searchObject.indexMin != "undefined" && notNull(searchObject.indexMin)){
    searchConstruct.indexMin=searchObject.indexMin;
  }
  if(typeof searchObject.initType != "undefined")
    searchConstruct.initType=searchObject.initType;
  if(typeof searchObject.count != "undefined" && searchObject.count)
    searchConstruct.count=searchObject.count;
  if(typeof searchObject.ranges != "undefined")
    searchConstruct.ranges=searchObject.ranges;
  if(typeof searchObject.countType != "undefined")
    searchConstruct.countType=searchObject.countType;

  if(typeof $("#priceMin").val() != "undefined" && $("#priceMin").val()!=""){
    searchObject.priceMin=$("#priceMin").val();
    searchConstruct.priceMin = searchObject.priceMin; 
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="priceMin="+searchObject.priceMin;
  }else if(typeof searchObject.priceMin != "undefined")
    delete searchObject.priceMin;
  if(typeof $("#priceMax").val() != "undefined" && $("#priceMax").val()!=""){
    searchObject.priceMax=$("#priceMax").val();
    searchConstruct.priceMax = searchObject.priceMax;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="priceMax="+searchObject.priceMax;
  }else if(typeof searchObject.priceMax != "undefined")
    delete searchObject.priceMax;
  if(typeof $("#devise").val() != "undefined" && $("#devise").val()!="" && $("#devise").val()!="all"){ 
    searchObject.devise=$("#devise").val();
    searchConstruct.devise = searchObject.devise;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="devise="+searchObject.devise;
  }else if(typeof searchObject.devise != "undefined")
    delete searchObject.devise;

  // Locality
  getStatus=getUrlSearchLocality(getStatus);
  searchConstruct.locality = getSearchLocalityObject();
  //Construct url with all necessar params
  hashT=location.hash.split("?");
  if(getStatus != "")
    location.hash=hashT[0].substring(0)+"?"+getStatus;
  else
    location.hash=hashT[0];

  return searchConstruct;
}
function initSearchObject(){
    if(location.hash.indexOf("?") > -1){
        getParamsUrls=location.hash.split("?");
        var parts = getParamsUrls[1].split("&");
        var $_GET = {};
        var initScopesResearch={"key":"","ids":[]};
        for (var i = 0; i < parts.length; i++) {
            var temp = parts[i].split("=");
            $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
        }
        if(Object.keys($_GET).length > 0){
            $.each($_GET, function(e,v){
                if(e=="scopeType") initScopesResearch.key=v; else searchObject[e]=v;
                // Check on types on search app
                if(searchObject.initType!= "all" && e=="types") delete searchObject[e];
                else if (e=="types"){searchObject[e]=[v]; delete searchObject.ranges;}
                if(searchObject.initType!="classified" && $.inArray(e,["devise","priceMin","priceMax"]) > -1) delete searchObject[e];
                if(searchObject.initType!="events" && $.inArray(e,["startDate","endDate"]) > -1) delete searchObject[e];
                if(searchObject.initType=="all" && e=="searchSType") delete searchObject[e];  
                if($.inArray(searchObject.initType, ["all", "events"])>-1 && $.inArray(e,["section","subType"]) > -1) delete searchObject[e];
                if($.inArray(e,["cities","zones","cp"]) > -1) $.each(v.split(","), function(i, j){ initScopesResearch.ids.push(j) });
                if(typeof searchObject[e] != "undefined")
                    activeFiltersInterface(e, v, searchObject.initType); 
            }); 
            console.log("searchafter",searchObject);
            if(initScopesResearch.key!="" && initScopesResearch.ids.length > 0)
                checkMyScopeObject(initScopesResearch, $_GET);
        }
    }else
        appendScopeBreadcrum();
}
function activeFiltersInterface(filter,value){
    if(filter=="section"){
        $(".btn-select-type-anc[data-key='"+value+"']").addClass("active");
    }
    if(filter=="searchSType"){
        if(searchObject.initType=="events")
            $(".btn-directory-type[data-type-event='"+value+"']").addClass("active");
        else{
            $(".btn-select-category-1[data-keycat='"+value+"']").addClass("active");
            $(".keycat[data-categ='"+value+"']").removeClass("hidden");
        }
    }
    if(filter=="subType"){
        $(".keycat[data-keycat='"+value+"'][data-categ='"+searchObject.searchSType+"']").addClass("active");
    }
    if(filter=="types"){
        $(".btn-directory-type").removeClass("active");
        $(".btn-directory-type[data-type='"+value+"']").addClass("active");
    }
    if(filter=="priceMin" || filter=="priceMax")
        $("#section-price #"+filter).val(value);
    if(filter=="devise")
        $('#section-price #devise option[value="'+value+'"]').attr("selected",true)
    if(filter=="page"){
        searchObject.page=(Number(value)-1);
        searchObject.indexMin=searchObject.indexStep*searchObject.page;

        if(searchObject.initType != "all" || (typeof searchObject.types != "undefined" && searchObject.types.length == 1 ))
            pageCount=true;
    }
}
var searchAllEngine = {
    injectData : {},
    allResults : {},
    searchCount: {},
    initInjectData: function(){
        searchAllEngine.injectData={
            organizations : 0,
            projects : 0,
            events : 0,
            citoyens : 0,
            classified : 0,
            poi : 0,
            news : 0,
            places : 0,
            ressources : 0
        };
    },
    initSearch: function (){ 
        //Search on all
        searchObject.ranges={
            organizations : { indexMin : 0, indexMax : 30, waiting : 30 },
            projects : { indexMin : 0, indexMax : 30, waiting : 30 },
            events : { indexMin : 0, indexMax : 30, waiting : 30 },
            citoyens : { indexMin : 0, indexMax : 30, waiting : 30 },
            classified : { indexMin : 0, indexMax : 30, waiting : 30 },
            poi : { indexMin : 0, indexMax : 30, waiting : 30 },
            news : { indexMin : 0, indexMax : 30, waiting : 30 },
            places : { indexMin : 0, indexMax : 30, waiting : 30 },
            ressources : { indexMin : 0, indexMax : 30, waiting : 30},
            cities : { indexMin : 0, indexMax : 30, waiting : 30 }
        };
        initTypeSearch("all");
        searchAllEngine.allResults={};
        if(typeof searchObject.page != "undefined") delete searchObject.page;
        pageCount=false;
        scrollEnd=false;
        $(window).bind("scroll",function(){  
            mylog.log("test scroll", scrollEnd, loadingData);
            if(!loadingData && !scrollEnd && !isMapEnd && typeof searchObject.ranges != "undefined"){
                var heightWindow = $("html").height();// - $("body").height();
                if( $(this).scrollTop() >= heightWindow - 1200)
                    startSearch(10, 30, null);
            }
        });;
    },
    prepareAllSearch: function(data){
        sorting=[];
        searchObject.types=[];
        $i=0;
        resToShow={};
        searchAllEngine.initInjectData();
        $.each(data, function(e,v){
            searchAllEngine.allResults[e]=v;
        });
        $.each(searchAllEngine.allResults, function(e,v ){
            if (searchObject.types.indexOf(v.type) == -1)
                searchObject.types.push(v.type);
            sorting.push(v.sorting);
        });
        sorting.sort().reverse();
        sorting=sorting.splice(0,30);
        $.each(sorting, function(e, v){
            $.each(searchAllEngine.allResults, function(key, value){
              if(v==value.sorting){
                resToShow[key]=value;
                searchAllEngine.injectData[value.type]++;
                delete searchAllEngine.allResults[key];
                $i++;
              }
            });
        });
        $.each(searchAllEngine.injectData, function (type, v){ console.log("search range", type);
            if(v==0)
              removeSearchType(type);
            else{
              searchObject.ranges[type].indexMin=searchObject.ranges[type].indexMax;
              searchObject.ranges[type].indexMax=searchObject.ranges[type].indexMin+v;
            }
          });
        return resToShow;
    }
};