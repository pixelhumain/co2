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
        //searchObject.text="";
        tagsArray=[];
        $.each(filliaireCategories[fKey]["tags"], function(key, tag){
            tag=(typeof tradTags[tag] != "undefined") ? tradTags[tag] : tag;
            tagsArray.push(tag);
            //searchObject.text+="#"+tag+" ";
        });
        $('#tagsFilterInput').val(tagsArray).trigger("change");
        //$("#filter-thematic-menu").hide();
        //$("#main-search-bar, #second-search-bar").val(searchObject.text);
        //mylog.log("myMultiTags", myMultiTags);
        
        /*searchObject.page=0;
        pageCount=true;
        searchObject.count=true;
        if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
        
        startSearch(0, indexStepInit, searchCallback);*/
    });
    $(".btn-tags-start-search").off().on("click", function(){
        searchObject.tags=$('#tagsFilterInput').val().split(",");
        searchObject.page=0;
        pageCount=true;
        searchObject.count=true;
        if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
        $(".dropdown-tags").removeClass("open");
        activeTagsFilter();
        startSearch(0, indexStepInit, searchCallback);
    });
    $(".btn-tags-refresh").off().on("click", function(){
        searchObject.tags=[];
        $('#tagsFilterInput').val("").trigger("change");
        searchObject.page=0;
        pageCount=true;
        searchObject.count=true;
        if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
        $(".dropdown-tags").removeClass("open");
        activeTagsFilter();
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
    //.menu-btn-start-search,
    $("#menu-map-btn-start-search,  #main-search-bar-addon").off().on("click", function(){
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
    classifieds.currentLeftFilters = null;
    $('#menu-section-'+typeInit).removeClass("hidden");
    $("#btn-create-classified").click(function(){
         dyFObj.openForm('classified');
    });    
}

function bindLeftMenuFilters () { 
    $(".btn-directory-type").click(function(){
        var typeD = $(this).data("type");
        scrollH= ($("#filter-thematic-menu").is(":visible")) ? 250 : 91;
        //simpleScroll(scrollH);
       
        if(typeD == "events"){
            if($(this).hasClass("active")){
                $(this).removeClass("active");    
                delete searchObject.searchSType;
                $(".dropdown-types .dropdown-toggle").removeClass("active").html("Type <i class='fa fa-angle-down'></i>");
            }else{
                $(".btn-directory-type").removeClass("active");
                $(this).addClass("active");
                var typeEvent = $(this).data("type-event");
                 $(".dropdown-types .dropdown-toggle").addClass("active").html(tradCategory[typeEvent]+" <i class='fa fa-angle-down'></i>");
                searchObject.searchSType = typeEvent;
            }
        }else{
            if(typeD=="all")
                $(".dropdown-types .dropdown-toggle").removeClass("active").html("Type <i class='fa fa-angle-down'></i>");
            else
                $(".dropdown-types .dropdown-toggle").addClass("active").html(tradCategory[typeD]+" <i class='fa fa-angle-down'></i>");
            $(".btn-directory-type").removeClass("active");
            $(this).addClass("active");
        }
        initTypeSearch(typeD);
        if(typeD=="all"){
            searchAllEngine.initInjectData();
            searchAllEngine.initSearch();
        }
        loadingData = false;
        pageCount=true;
        searchObject.page=0;
        if(Object.keys(searchObject.countType).length>1) searchObject.count=false; 
        else searchObject.count=true;
        pageEvent=false;
        searchObject.type=searchType;
        startSearch(0, indexStepInit, searchCallback);
    });
    $(".btn-select-type-anc").off().on("click", function(){
        searchType = [ typeInit ];
        indexStepInit = 100;
        pageCount=true;
        searchObject.count=true;
        typeClass = $(this).data("type-anc");
        typeKey = $(this).data("key");    
        if( typeKey == "classifieds" || typeKey == "jobs" || typeKey == "all"){
            $(".dropdown-price").show(200);
            setTimeout(function(){
                KScrollTo("#container-scope-filter");
            }, 400);
        }
        else {
            $(".dropdown-price").hide();
            $("#priceMin").val("");
            $("#priceMax").val("");
            delete searchObject.priceMin;
            delete searchObject.priceMax;
            KScrollTo("#container-scope-filter");
        }
        $(".dropdown-section .dropdown-toggle").html(trad.section+" <i class='fa fa-angle-down'></i>");
        $(".dropdown-category .dropdown-toggle").html(trad.category+" <i class='fa fa-angle-down'></i>");
        $(".dropdown-subType .dropdown-toggle").html(trad.subcategory+" <i class='fa fa-angle-down'></i>");
        $(".dropdown-section .dropdown-toggle, .dropdown-category .dropdown-toggle, .dropdown-subType .dropdown-toggle").removeClass("active");
        if( $(this).hasClass( "active" ) )
        {
            typeKey = null;
            //searchObject.tags=[];
            if(typeof searchObject.searchSType != "undefined") delete searchObject.searchSType;
            $('.classifiedSection').remove();
            $(".label-category, .resultTypes").html("");
            $(".dropdown-types .dropdown-toggle").removeClass("active").html(trad.type+" <i class='fa fa-angle-down'></i>");
            $(".dropdown-section, .dropdown-category, .dropdown-subType").hide(700);
            
        } 
        else 
        {
            $(".dropdown-types .dropdown-toggle").addClass("active").html(typeClass+" <i class='fa fa-angle-down'></i>");
            $(".dropdown-section, .dropdown-category, .dropdown-subType").show();
            searchObject.searchSType=typeKey;
            initCategoryClassifieds(typeKey);
            /*if( jsonHelper.notNull("modules."+typeKey) ){
                //alert('build left menu'+classified.sections[sectionKey].filters);
               // classifieds.currentLeftFilters = classifieds[typeKey].categories;
                var filters = modules[typeKey].categories; 
                var what = { title : filters.label, 
                             icon : filters.icon }
                directory.sectionFilter( filters, ".classifiedFilters",what);
                bindLeftMenuFilters ();
            }*/
            /*else if(classifieds.currentLeftFilters != null) {
                var what = { title : classifieds.currentLeftFilters.label, 
                             icon : classifieds.currentLeftFilters.icon }
                directory.sectionFilter( classifieds.currentLeftFilters, "#menuLeft",what);
                bindLeftMenuFilters ();
                classifieds.currentLeftFilters = null;
            }*/
        }
        $(".btn-select-type-anc, .btn-select-section, .btn-select-category, .keycat").removeClass("active");
        //if(bindEcoSource())
           //bindEcoSource();
        $(".btn-select-source").click(function(){
            var key = $(this).data("key");
            $(".dropdown-sources .dropdown-toggle").addClass("active").html($(this).data("source")+" <i class='fa fa-angle-down'></i>");
            if(key == "co"){
                delete searchObject.source;
                startSearch(0, indexStepInit, searchCallback);
            }else{
                searchObject.source = key;
                if( typeof interop == "undefined" ){
                    lazyLoad( modules.interop.assets+'/js/interop.js', null , function(data){
                        if( typeof interopObj == "undefined" ){
                           lazyLoad( modules.interop.assets+'/js/init.js', null, function(data){
                                interopObj[key].startSearch();
                            } ); 
                       }else{
                            interopObj[key].startSearch(); 
                       }
                    });
                } else {
                    interopObj[key].startSearch();
                }
            }
        });

        $(".keycat").addClass("hidden");
        if(typeof searchObject.section != "undefined") delete searchObject.section;
        if(typeof searchObject.category != "undefined") delete searchObject.category;
        if(typeof searchObject.subType != "undefined") delete searchObject.subType;
        if(typeof searchObject.searchSType != "undefined") $(this).addClass("active");
        startSearch(0, indexStepInit, searchCallback);
            
    });
    $(".btn-select-section").off().on("click", function()
    {    
        searchType = [ typeInit ];
        indexStepInit = 100;
        pageCount=true;
        searchObject.count=true;
        $(".dropdown-category .dropdown-toggle").html(trad.category+" <i class='fa fa-angle-down'></i>");
        $(".dropdown-subType .dropdown-toggle").html(trad.subcategory+" <i class='fa fa-angle-down'></i>");
        $(".dropdown-category .dropdown-toggle, .dropdown-subType .dropdown-toggle").removeClass("active")
        if( $(this).hasClass( "active" ) )
        {
            sectionKey = null;
            //searchObject.tags=[];
            if(typeof searchObject.section != "undefined") delete searchObject.section;
            $('.classifiedSection').remove();
            $(".label-category, .resultTypes").html("");
            $(".dropdown-section .dropdown-toggle").removeClass("active").html(trad.section+" <i class='fa fa-angle-down'></i>");
        } 
        else 
        {
            section = $(this).data("type-anc");
            sectionKey = $(this).data("key");
            $(".dropdown-section .dropdown-toggle").addClass("active").html(tradCategory[sectionKey]+" <i class='fa fa-angle-down'></i>");
            if( $(this).data("key") == "all" ) delete searchObject.section;//sectionKey = "";
            else searchObject.section =  sectionKey;
        }
        $(".btn-select-section, .btn-select-category, .keycat").removeClass("active");
        $(".keycat").addClass("hidden");
        
        if(typeof searchObject.category != "undefined") delete searchObject.category;
        if(typeof searchObject.subType != "undefined") delete searchObject.subType;
        if(typeof searchObject.section != "undefined")
            $(this).addClass("active");

        startSearch(0, indexStepInit, searchCallback); 

        if(sectionKey && typeof modules[searchObject.searchSType].categories.sections[sectionKey] != "undefined") {
            var label = modules[searchObject.searchSType].categories.sections[sectionKey]["label"];
            $(".label-category").html("<i class='fa fa-"+ modules[searchObject.searchSType].categories.sections[sectionKey]["icon"] + "'></i> " + tradCategory[label]);
            $('.classifiedSection').remove();
            $(".resultTypes").append( "<span class='classifiedSection text-azure text-bold hidden-xs pull-right'><i class='fa fa-"+ modules[searchObject.searchSType].categories.sections[sectionKey]["icon"] + "'></i> " + modules[searchObject.searchSType].categories.sections[sectionKey]["label"]+'<i class="fa fa-times text-red resetFilters"></i></span>');
            $(".label-category").removeClass("letter-blue letter-red letter-green letter-yellow").addClass("letter-azure");//+classifieds[searchObject.searchStype].sections[sectionKey]["color"])
            $(".fa-title-list").removeClass("hidden");
        }
    });

    $(".btn-select-category").off().on("click", function(){ 
        searchType = [ typeInit ];
        var searchTxt = "";
        //var section = searchObject.tags.join(",");//$('#searchTags').val();
        var classType = $(this).data("keycat");
        console.log("bindLeftMenuFilters sectionKey", sectionKey);
        // Event for count in DB
        pageCount=true;
        searchObject.count=true;
        if(typeof searchObject.subType != "undefined") delete searchObject.subType;
        $(".dropdown-subType .dropdown-toggle").removeClass("active").html(trad.subcategory+" <i class='fa fa-angle-down'></i>");
        if( $(this).hasClass( "active" ) ){
            if(typeof searchObject.category != "undefined") delete searchObject.category;
            //searchObject.tags=[sectionKey];//searchTxt = sectionKey;
            $(this).removeClass( "active" );
            $(".keycat-"+classType).addClass("hidden").removeClass("active"); 
            $(".dropdown-category .dropdown-toggle").removeClass("active").html(trad.category+" <i class='fa fa-angle-down'></i>");
        }else{
            $(".btn-select-category").removeClass("active");
            $(this).addClass("active");
            $(".keycat").addClass("hidden");
            $(".keycat-"+classType).removeClass("hidden");  
            searchObject.category=classType;
            $(".dropdown-category .dropdown-toggle").addClass("active").html(tradCategory[classType]+" <i class='fa fa-angle-down'></i>");
        }
        startSearch(0, indexStepInit, searchCallback);  
    });

    /*TERLA FILTER TO MUTUALIZE 
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
    });*/

    $(".keycat").off().on("click", function(){
        searchObject.types = [ typeInit ];
        var searchTxt = "";
        var classType = $(this).data("categ");
        var classSubType = $(this).data("keycat");
        // Event for count in DB
        pageCount=true;
        searchObject.count=true;
        if( $(this).hasClass( "active" ) ){
            if(typeof searchObject.subType != "undefined") delete searchObject.subType;
            $(".dropdown-subType .dropdown-toggle").removeClass("active").html(trad.subcategory+" <i class='fa fa-angle-down'></i>");
            $(this).removeClass( "active" );
        }else{
            $(".keycat").removeClass("active");
            $(this).addClass("active");
            $(".dropdown-subType .dropdown-toggle").addClass("active").html(tradCategory[classSubType]+" <i class='fa fa-angle-down'></i>");
            searchObject.subType=classSubType;
            searchObject.category=classType;
        }

        KScrollTo("#container-scope-filter");
        startSearch(0, searchObject.indexStep, searchCallback);  
    });
    $('.dropdown-menu[aria-labelledby="dropdownPrice"], .dropdown-menu[aria-labelledby="dropdownTags"]').on('click', function(event){
        // The event won't be propagated up to the document NODE and 
        // therefore delegated events won't be fired
        event.stopPropagation();
    });
    $(".btn-price-filter").off().on("click",function(){
        if($(this).data("key")=="reset"){
            $(".dropdown-price .dropdown-toggle").removeClass("active").html(trad.price+" <i class='fa fa-angle-down'></i>");
            if(typeof searchObject.priceMin != "undefined") delete searchObject.priceMin;
            if(typeof searchObject.priceMax != "undefined") delete searchObject.priceMax;
            if(typeof searchObject.devise != "undefined") delete searchObject.devise;
            $("#priceMin, #priceMax, #devise").val("");
        }else{
            if(typeof $("#priceMin").val() != "undefined" && $("#priceMin").val()!="")
                searchObject.priceMin=$("#priceMin").val();
            else if(typeof searchObject.priceMin != "undefined")
                delete searchObject.priceMin;
            if(typeof $("#priceMax").val() != "undefined" && $("#priceMax").val()!="")
                searchObject.priceMax=$("#priceMax").val();
            else if(typeof searchObject.priceMax != "undefined")
                delete searchObject.priceMax;
            if(typeof $("#devise").val() != "undefined" && $("#devise").val()!="" && $("#devise").val()!="all")
                searchObject.devise=$("#devise").val();
            else if(typeof searchObject.devise != "undefined")
                delete searchObject.devise;
            activePriceFilter();
        }
        $(".dropdown-price").removeClass("open");
        pageCount=true;
        searchObject.count=true;
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
  if(typeof searchObject.types != "undefined" && searchObject.types.length==1 && (searchObject.initType=="all" || searchObject.initType=="news")){
    searchConstruct.searchType=searchObject.types;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="types="+searchObject.types.join(",");
  }else{
    searchConstruct.searchType=searchObject.types;
  }
  if(typeof searchObject.tags != "undefined" && searchObject.tags.length > 0){
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
  if(typeof searchObject.category != "undefined"){
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="category="+searchObject.category;
    searchConstruct.category = searchObject.category;
  }
  if(typeof searchObject.subType != "undefined"){
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="subType="+searchObject.subType;
    searchConstruct.subType = searchObject.subType;
  }
  if(typeof searchObject.priceMin != "undefined"){
    searchConstruct.priceMin = searchObject.priceMin; 
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="priceMin="+searchObject.priceMin;
  }
  if(typeof searchObject.priceMax != "undefined"){
    searchConstruct.priceMax = searchObject.priceMax;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="priceMax="+searchObject.priceMax;
  }
  if(typeof searchObject.devise != "undefined"){ 
    searchConstruct.devise = searchObject.devise;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="devise="+searchObject.devise;
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
  if(typeof searchObject.source != "undefined"){ 
    searchConstruct.source = searchObject.source;
    getStatus+=(getStatus!="") ? "&":"";
    getStatus+="source="+searchObject.source;
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

  // if(typeof custom != "undefined"){
  //   getStatus+=(getStatus!="") ? "&":"";
  //   getStatus+="cityxx="+custom.id;
  // }

  // Locality
  getStatus=getUrlSearchLocality(getStatus);
  searchConstruct.locality = getSearchLocalityObject();
  countActiveFilters();
  //Construct url with all necessar params
  hashT=location.hash.split("?");
  if(getStatus != "")
    location.hash=hashT[0].substring(0)+"?"+getStatus;
  else
    location.hash=hashT[0];

  return searchConstruct;
}
function countActiveFilters(){
    count=$("#filters-nav .dropdown .dropdown-toggle.active").length;
    if(count>0)
        $(".btn-show-filters .badge").removeClass('hide badge-tranparent').addClass("animated bounceIn badge-success").html(count);
    else
        $(".btn-show-filters .badge").removeClass('animated bounceIn badge-success').addClass("hide badge-tranparent").html("");
}
function initSearchObject(){
    showFiltersInterface();
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
                if((searchObject.initType!= "all" && searchObject.initType!= "news") && e=="types") delete searchObject[e];
                else if (e=="types"){searchObject[e]=[v]; delete searchObject.ranges;}
                if(searchObject.initType!="classifieds" && $.inArray(e,["devise","priceMin","priceMax"]) > -1) delete searchObject[e];
                if(searchObject.initType!="events" && $.inArray(e,["startDate","endDate"]) > -1) delete searchObject[e];
                if(searchObject.initType=="all" && e=="searchSType") delete searchObject[e];  
                if($.inArray(searchObject.initType, ["all", "events", "news"])>-1 && $.inArray(e,["section","category","subType"]) > -1) delete searchObject[e];
                if($.inArray(e,["cities","zones","cp"]) > -1) $.each(v.split(","), function(i, j){ initScopesResearch.ids.push(j) });
                if(e=="tags"){
                    searchObject.tags=[];
                    $.each(v.split(","), function(i, j){searchObject.tags.push(j) });
                } 
                if(typeof searchObject[e] != "undefined")
                    activeFiltersInterface(e, v, searchObject.initType); 
            }); 
            console.log("searchafter",searchObject);
            if(initScopesResearch.key!="" && initScopesResearch.ids.length > 0)
                checkMyScopeObject(initScopesResearch, $_GET);
        }
    }else{
        appendScopeBreadcrum();
        activeFiltersInterface("tags", searchObject.tags);
    }
    if(searchObject.initType=="classifieds") 
        activeClassifiedFilters();
}
function activeClassifiedFilters(){
    if(typeof searchObject.priceMin != "undefined" || typeof searchObject.priceMax != "undefined" || typeof searchObject.devise != "undefined")
       activePriceFilter();
    if(typeof searchObject.searchSType =="undefined")
        $(".dropdown-section, .dropdown-category, .dropdown-subType").hide();
    else
        initCategoryClassifieds(searchObject.searchSType);
    //if(typeof searchObject.category =="undefined")
     //   $(".dropdown-subType").hide();

}
function initCategoryClassifieds(typeKey){
    if( jsonHelper.notNull("modules."+typeKey) ){
        //alert('build left menu'+classified.sections[sectionKey].filters);
       // classifieds.currentLeftFilters = classifieds[typeKey].categories;
        var filters = modules[typeKey].categories; 
        var what = { title : filters.label, 
                     icon : filters.icon }
        directory.sectionFilter( filters, ".classifiedFilters",what);
        bindLeftMenuFilters ();
    }
}
function activePriceFilter(){
    str="";
    if(typeof searchObject.priceMin != "undefined")
        str+=(typeof searchObject.priceMax != "undefined") ?  searchObject.priceMin+" - " : "Sup. à "+searchObject.priceMin;
    if(typeof searchObject.priceMax != "undefined")
        str+=(typeof searchObject.priceMin != "undefined") ?  searchObject.priceMax : "Inf. à "+searchObject.priceMax;
    if(typeof searchObject.devise != "undefined")
        str+= " "+searchObject.devise;
    $(".dropdown-price .dropdown-toggle").addClass("active").html(str+" <i class='fa fa-angle-down'></i>");
}
function activeTagsFilter(){
    countTags=0;
    labelTags="";
    $.each(searchObject.tags, function(e, v){
        if(v!=""){
            countTags++;
            if(countTags <=2)
                labelTags+= (labelTags!="") ? ", "+v : v;
        }else{
            searchObject.tags.splice(e,1);
        } 
    });
    labelEnd=(countTags>2) ? labelTags+ " +"+(countTags-2) : labelTags;
    if(labelEnd!="")
        $(".dropdown-tags .dropdown-toggle").addClass("active").html(labelEnd+" <i class='fa fa-angle-down'></i>");
    else
        $(".dropdown-tags .dropdown-toggle").removeClass("active").html(trad.tags+" <i class='fa fa-angle-down'></i>");
}     
function initCategoriesApp(){
    str='';
    $.each(categoriesFilters, function(e,v){
        dataType="data-type-event='"+e+"' data-type='events'";
        countBadge="";
        if(searchObject.initType=="all"){
            dataType="data-type='"+e+"'";
            countBadge='<span class="count-badge-filter" id="count'+e+'"></span>';
        }
        textColor= (typeof v.color != "undefined") ? "text-"+v.color : "";
        icon = (typeof v.icon != "undefined") ? "<i class='fa fa-"+v.icon+"'></i> " : "";
        str+='<button class="btn btn-directory-type padding-10 '+textColor+'" '+dataType+'>'+
                icon+ 
                '<span class="elipsis label-filter">'+tradCategory[e]+'</span>'+
                countBadge+
            '</button><br class="hidden-xs">';
    });
    $(".dropdown-types .dropdown-menu").html(str);
    bindLeftMenuFilters();
}
function showFiltersInterface(){ 
    if(searchObject.initType=="classifieds"){
        $(".dropdown-section, .dropdown-types, .dropdown-category, .dropdown-subType, .dropdown-price").show();
        str="";
        $.each(["classifieds","ressources","jobs"], function(key,entry){
            //$.each(modules[entry].categories, function(e,v){
                str+='<div class="col-md-4 col-sm-4 col-xs-6 no-padding">'+
                        '<button class="btn btn-default col-md-12 col-sm-12 padding-10 bold elipsis btn-select-type-anc" '+
                        'data-type-anc="'+tradCategory[modules[entry].categories.labelFront]+'" data-key="'+entry+'" '+
                        'data-type="classifieds">'+
                            '<i class="fa fa-'+modules[entry].categories.icon+'"></i> '+
                            tradCategory[modules[entry].categories.labelFront]+
                        '</button>'+
                    '</div>';
            //});
        });
        $(".dropdown-types .dropdown-menu").html(str);
        bindLeftMenuFilters();
    }else if(searchObject.initType=="events"){
        initCategoriesApp();
        $(".dropdown-section, .dropdown-category, .dropdown-sources, .dropdown-subType, .dropdown-price").hide();
        $(".dropdown-types").show();
    }else if(searchObject.initType=="all"){
        initCategoriesApp();
        $(".dropdown-section, .dropdown-category, .dropdown-sources, .dropdown-subType, .dropdown-price").hide();
        $(".dropdown-types").show();
    }else if(searchObject.initType=="news"){
        str="";
        $.each([{"key":"all", "label":"all", "icon":"newspaper-o"},{"key":"news", "label":"onlynews", "icon":"rss"},{"key":"activityStream","label":"activityCommunecter", "icon":"map-marker"},{"key":"surveys", "label":"surveys", "icon":"gavel"}], function(key,entry){
            //$.each(modules[entry].categories, function(e,v){
                str+='<div class="col-xs-12 no-padding">'+
                        '<button class="btn btn-default bold elipsis btn-news-type-filters col-xs-12" '+
                        'data-type-anc="'+entry.key+'" data-key="'+entry.key+'" data-label="'+entry.label+'" '+
                        'data-type="news">'+
                            '<i class="fa fa-'+entry.icon+'"></i> '+
                            tradCategory[entry.label]+
                        '</button>'+
                    '</div>';
            //});
        });
        $(".dropdown-types .dropdown-menu").html(str);
        $(".dropdown-section, .dropdown-category, .dropdown-sources, .dropdown-subType, .dropdown-price").hide();
    }
}
function activeFiltersInterface(filter,value){
    if(filter=="section"){
        $(".dropdown-section .dropdown-toggle").addClass("active").html(tradCategory[value]+" <i class='fa fa-angle-down'></i>");
        //$(".btn-select-type-anc[data-key='"+value+"']").addClass("active");
    }
    if(filter=="searchSType"){
        $(".dropdown-types .dropdown-toggle").addClass("active").html(tradCategory[value]+" <i class='fa fa-angle-down'></i>");
        if(searchObject.initType=="events")
            $(".btn-directory-type[data-type-event='"+value+"']").addClass("active");
        else{
            $(".dropdown-section, .dropdown-category, .dropdown-subType").show();
            $(".btn-select-category[data-keycat='"+value+"']").addClass("active");
            $(".keycat[data-categ='"+value+"']").removeClass("hidden");
        }
    }
    if(filter=="tags"){
        $('#tagsFilterInput').val(searchObject.tags).trigger("change");
        countTags=0;
        labelTags="";
        $.each(searchObject.tags, function(e, v){
            countTags++;
            labelTags+= (labelTags!="") ? ", "+v : v; 
        });
        activeTagsFilter();
    }
    if(filter=="category"){
        $(".dropdown-category .dropdown-toggle").addClass("active").html(tradCategory[value]+" <i class='fa fa-angle-down'></i>");
        $(".keycat[data-keycat='"+value+"'][data-categ='"+searchObject.searchSType+"']").addClass("active");
        $(".dropdown-subType").show();
    }
    if(filter=="subType"){
        $(".dropdown-subType .dropdown-toggle").addClass("active").html(tradCategory[value]+" <i class='fa fa-angle-down'></i>");
        $(".keycat[data-keycat='"+value+"'][data-categ='"+searchObject.searchSType+"']").addClass("active");
    }
    if(filter=="types"){
        $(".dropdown-types .dropdown-toggle").addClass("active").html(tradCategory[value]+" <i class='fa fa-angle-down'></i>");
        $(".btn-directory-type").removeClass("active");
        $(".btn-directory-type[data-type='"+value+"']").addClass("active");
    }
    if(filter=="priceMin" || filter=="priceMax"){
        $("#section-price #"+filter).val(value);
    }
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
            classifieds : 0,
            poi : 0,
            news : 0,
            places : 0,
            ressources : 0
        };
    },
    initRanges: function(){
        searchObject.ranges={
            organizations : { indexMin : 0, indexMax : 30, waiting : 30 },
            projects : { indexMin : 0, indexMax : 30, waiting : 30 },
            events : { indexMin : 0, indexMax : 30, waiting : 30 },
            citoyens : { indexMin : 0, indexMax : 30, waiting : 30 },
            classifieds : { indexMin : 0, indexMax : 30, waiting : 30 },
            poi : { indexMin : 0, indexMax : 30, waiting : 30 },
            news : { indexMin : 0, indexMax : 30, waiting : 30 },
            places : { indexMin : 0, indexMax : 30, waiting : 30 },
            ressources : { indexMin : 0, indexMax : 30, waiting : 30},
            cities : { indexMin : 0, indexMax : 30, waiting : 30 }
        };
    },
    initSearch: function (){ 
        //Search on all
        searchAllEngine.initRanges();
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