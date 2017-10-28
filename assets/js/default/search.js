function initSearchInterface(){
    
    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            $(".btn-directory-type").removeClass("active");
            KScrollTo("#content-social");
        }
    });
    $("#main-search-bar").change(function(){
        $("#second-search-bar").val($(this).val());
    });

    $("#second-search-bar").keyup(function(e){
        $("#main-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            $(".btn-directory-type").removeClass("active");
            KScrollTo("#content-social");
         }
    });

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

    $("#menu-map-btn-start-search, #main-search-bar-addon").off().click(function(){
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

    $(".btn-select-category-1").off().on("click", function(){
        searchType = [ typeInit ];
        var searchTxt = "";
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
