<?php 

  $cssAnsScriptFilesModule = array(
    '/assets/css/default/responsive-calendar.css',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);
  
  $cssAnsScriptFilesModule = array(
    '/js/default/responsive-calendar.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

    $params = CO2::getThemeParams();

    $page = "search";
    if(!@$type){  $type = "all"; }

    if(@$type=="events")    { $page = "agenda"; }
    if(@$type=="classified"){ $page = "annonces"; }
    if(@$type=="vote")      { $page = "power"; }
    if(@$type=="place")     { $page = "place"; }

    if(@$type=="cities")    { $lblCreate = ""; }

    if($params["title"] == "Kgougle") $page = "social";
    
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                            array(  "layoutPath"=>$layoutPath ,
                                    "page" => $page,
                                    "type" => @$type) ); 
?>

<style>
    
    #page #dropdown_search{
    	min-height:500px;
        /*margin-top:30px;*/
    }
    #page .row.headerDirectory{
        margin-top: 20px;
        display: none;
    }
    #page p {
        font-size: 13px;
    }
    .container-result-search {
        border-top:1px solid #eee;
        padding-top:15px;
    }

    /*.homestead{
        font-family:unset!important;
    }*/
    /*
    .main-btn-scopes{
        position: absolute;
        top: 85px;
        left: 18px;
        z-index: 10;
        border-radius: 0 50%;
    }*/

    .btn-create-page{
        margin-top:0px;
        z-index: 10;
        border-radius: 0 50%;
        -ms-transform: rotate(7deg);
        -webkit-transform: rotate(7deg);
        transform: rotate(-45deg);
    }
    .btn-create-page:hover{
        background-color: white!important;
        color:#34a853!important;
        border: 2px solid #34a853!important;

    }
    .main-btn-scopes {
        margin-top: 7px;
    }

    .scope-min-header{
        float: left;
        margin-top: 27px;
        margin-left: 35px;
    }

    .links-create-element .btn-create-elem{
        margin-top:25px;
    }

    .subtitle-search{
        display: none;
        /*width: 100%;
        text-align: center;*/
    }
       
    .breadcrum-communexion{ 
         margin-top:25px;
    }

    .breadcrum-communexion .item-globalscope-checker{
        border-bottom:1px solid #e6344d;
    }
    .item-globalscope-checker.inactive{
        color:#DBBCC1 !important;
        border-bottom:0px;
        margin(top:-6px;)
    }
    .item-globalscope-checker:hover,
    .item-globalscope-checker:active,
    .item-globalscope-checker:focus{
        color:#e6344d !important;
        border-bottom:1px solid #e6344d;
        text-decoration: none !important;
    }
    header .container, 
    .header .container{
        padding-bottom: 40px;
    }

    .btn-directory-type.bg-white {
        background-color: #F2F2F2 !important;
    }

    /*##content-social .btn-directory-type.active {
        background-color: #2C3E50 !important;
        color : white;
    }*/

    .searchEntityContainer.pull-right.classified{
        clear: right;
    }
    .searchEntityContainer.pull-left.classified{
        clear: left;
    }

    .carousel-inner > .item > img.img-responsive{
        display: inline !important;
        max-height: 400px !important;
    }

    .btn-select-type-anc.active,
    .btn-select-type-anc:active,
    .btn-select-type-anc:focus{
        color: white !important;
        background-color: #2C3E50;
    }
</style>


<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding shadow pageContent" id="content-social" style="min-height:700px;">

    <?php if(@$type=="events"){ ?>
    <div class="col-md-12 no-padding calendar"></div>
    <div class="responsive-calendar-init hidden"> 
      <div class="responsive-calendar light col-md-12 no-padding">   
          <div class="day-headers">
            <div class="day header">Lun</div>
            <div class="day header">Mar</div>
            <div class="day header">Mer</div>
            <div class="day header">Jeu</div>
            <div class="day header">Ven</div>
            <div class="day header">Sam</div>
            <div class="day header">Dim</div>
          </div>
          <div class="days" data-group="days"></div>   
          <div class="controls">
              <a id="btn-month-before" class="text-white" data-go="prev"><div class="btn"><i class="fa fa-arrow-left"></i></div></a>
              <h4 class="text-white"><span data-head-month></span> <span data-head-year></span></h4>
              <a id="btn-month-next" class="text-white" data-go="next"><div class="btn"><i class="fa fa-arrow-right"></i></div></a>
          </div>
      </div>
    </div>
    <?php } ?>

    <?php if(@$type!="cities"){ ?>
        <div class="col-md-2 col-sm-2 col-xs-12 no-padding">
            <?php if(@$type=="all"){ ?>
            <button class="btn btn-default letter-<?php echo @$params["pages"]["#".$page]["colorBtnCreate"]; ?> hidden-xs btn-menu-left-add pull-right margin-top-25 main-btn-create tooltips"
                    data-target="#dash-create-modal" data-toggle="modal"
                    data-toggle="tooltip" data-placement="top" 
                    title="<?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>">
                <i class="fa fa-plus-circle"></i> <?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>
            </button>
            <?php }else{ ?>
            <button class="btn btn-default letter-<?php echo @$params["pages"]["#".$page]["colorBtnCreate"]; ?> hidden-xs btn-menu-left-add pull-right margin-top-25 main-btn-create tooltips" data-type="<?php echo @$type; ?>"
                    data-toggle="tooltip" data-placement="top" 
                    title="<?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>">
                <i class="fa fa-plus-circle"></i> <?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>
            </button>
            <?php } ?>

        </div>

        <?php //var_dump(Yii::app()->request->cookies['communexionActivated']);
              //var_dump(CO2::getCommunexionCookies()); 
        ?>

        <div id="container-scope-filter"  class="col-md-10 col-sm-10 col-xs-12 padding-5">
            <?php $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); ?>
        </div>
    <?php } ?>


	<div class="col-md-12 col-sm-12 col-xs-12 padding-5" id="page"></div>

    <?php if(@$type=="all" && !empty(Yii::app()->session["userId"]) ){ ?>
    <div class="col-md-12 col-sm-12 col-xs-12 padding-5 text-center">
        <!-- <hr style="margin-bottom:-20px;"> -->
        <button class="btn btn-default btn-circle-1 btn-create-page bg-green-k text-white tooltips" 
            data-target="#dash-create-modal" data-toggle="modal"
            data-toggle="tooltip" data-placement="top" 
            title="Créer une nouvelle page">
                <i class="fa fa-times" style="font-size:18px;"></i>
        </button>
        <h5 class="text-center letter-green margin-top-25">Créer une page</h5>
        <h5 class="text-center">
            <small>             
                <span class="text-green">associations</span> 
                <span class="text-azure">entreprises</span> 
                <span class="text-purple">projets</span> 
                <span class="text-turq">groupes</span>
                <span class="text-red">service public</span>
            </small>
        </h5><br>
    </div>
    <?php } ?>

</div>


<?php $this->renderPartial($layoutPath.'modals.'.Yii::app()->params["CO2DomainName"].'.pageCreate', array()); ?>

<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>$page)); ?>



<script type="text/javascript" >

var type = "<?php echo @$type ? $type : 'all'; ?>";
var typeInit = "<?php echo @$type ? $type : 'all'; ?>";
var page = "<?php echo @$page; ?>";
var titlePage = "<?php echo @$params["pages"]["#".$page]["subdomainName"]; ?>";

//var TPL = "kgougle";

//allSearchType = ["persons", "NGO", "LocalBusiness", "projects", "Group"];

var currentKFormType = "";

jQuery(document).ready(function() {

    setTitle("", "", titlePage);

    initKInterface({"affixTop":320});
    
    var typeUrl = "?nopreload=true";
    if(type!='') typeUrl = "?type="+type+"&nopreload=true";
	getAjax('#page' ,baseUrl+'/'+moduleId+"/default/directoryjs"+typeUrl,function(){ 

        $(".btn-directory-type").click(function(){
            var typeD = $(this).data("type");

            if(typeD == "events"){
                var typeEvent = $(this).data("type-event");
                searchSType = typeEvent;
            }

            initTypeSearch(typeD);
            mylog.log("search.php",searchType);
            setHeaderDirectory(typeD);
            loadingData = false;
            startSearch(0, indexStepInit, searchCallback);
            KScrollTo("#content-social");

            $(".btn-directory-type").removeClass("active");
            $(this).addClass("active");
        });

        $(".btn-open-filliaire").click(function(){
            KScrollTo("#content-social");
        });
         
         //anny double section filter directory
        <?php if(@$type == "classified" || @$type == "place"  ){ ?>
            initClassifiedInterface();
        <?php } ?>

        bindLeftMenuFilters();

        //console.log("init Scroll");
        $(window).bind("scroll",function(){  
            mylog.log("test scroll", scrollEnd);
            if(!loadingData && !scrollEnd && !isMapEnd){
                  var heightWindow = $("html").height() - $("body").height();
                  if( $(this).scrollTop() >= heightWindow - 400){
                    startSearch(currentIndexMin+indexStep, currentIndexMax+indexStep, searchCallback);
                  }
            }
        });


        loadingData = false; 
        initTypeSearch(type);
        startSearch(0, indexStepInit, searchCallback);

    },"html");

    /*$("#main-btn-start-search, .menu-btn-start-search").off().click(function(){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            KScrollTo("#content-social");
    });*/

    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
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
            KScrollTo("#content-social");
         }
    });

    $("#input-search-map").keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        $("#main-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
         }
    });

    $("#menu-map-btn-start-search, #main-search-bar-addon").click(function(){
        initTypeSearch(typeInit);
        startSearch(0, indexStepInit, searchCallback);
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

    /*$(".btn-decommunecter").click(function(){
        alert();
        activateGlobalCommunexion(false);
    });*/

    if(page == "annonces" || page == "agenda" || page == "power"){
        setTimeout(function(){
            KScrollTo("#content-social");  
        }, 1000);
    }
    $(".tooltips").tooltip();

    //currentKFormType = "Group";
    //dyFObj.openForm ("organization");
});


function initTypeSearch(typeInit){
    //var defaultType = $("#main-btn-start-search").data("type");

    if(typeInit == "all") {
        searchType = ["persons", "organizations", "projects"];
        //if( $('#main-search-bar').val() != "" ) searchType.push("cities");

        indexStepInit = 30;
    }
    else{
        searchType = [ typeInit ];
        indexStepInit = 100;
    }
}

/* -------------------------
CLASSIFIED
----------------------------- */
var section = "";
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
        $(".btn-select-type-anc, .btn-select-category-1, .keycat").removeClass("active");
        $(".keycat").addClass("hidden");
        $(this).addClass("active");

        section = $(this).data("type-anc");
        sectionKey = $(this).data("key");
        //alert("section : " + section);

        if( sectionKey == "forsale" || sectionKey == "forrent"){
            $("#section-price").show(200);
            KScrollTo("#section-price");
        }
        else {
            $("#section-price").hide();
            $("#priceMin").val("");
            $("#priceMax").val("");
            KScrollTo("#dropdown_search");
        }

        /*
        if( sectionKey == "forsale" || sectionKey == "forrent" || sectionKey == "location" || sectionKey == "donation" || 
            sectionKey == "sharing" || sectionKey == "lookingfor" || sectionKey == "job" || sectionKey == "all" ){
            //$(".subsub").show(300);
            $('#searchTags').val(section);
            //KScrollTo("#section-price");
            startSearch(0, indexStepInit, searchCallback); 
        } */
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

        $('#searchTags').val(section);
        //KScrollTo(".top-page");
        startSearch(0, indexStepInit, searchCallback); 


        if(typeof classified.sections[sectionKey] != "undefined") {
            $(".label-category").html("<i class='fa fa-"+ classified.sections[sectionKey]["icon"] + "'></i> " + classified.sections[sectionKey]["label"]);
            $(".label-category").removeClass("letter-blue letter-red letter-green letter-yellow").addClass("letter-"+classified.sections[sectionKey]["color"])
            $(".fa-title-list").removeClass("hidden");
        }
    });

    $(".btn-select-category-1").off().on("click", function(){
        searchType = [ typeInit ];
        $(".btn-select-category-1").removeClass("active");
        $(this).addClass("active");

        var classType = $(this).data("keycat");
        $(".keycat").addClass("hidden");
        $(".keycat-"+classType).removeClass("hidden");   

        //alert("classType : "+classType);

        $('#searchTags').val(section+","+classType);
        startSearch(0, indexStepInit, searchCallback);  
    });

    $(".keycat").off().on("click", function(){

        searchType = [ typeInit ];
        $(".keycat").removeClass("active");
        $(this).addClass("active");
        var classSubType = $(this).data("keycat");
        var classType = $(this).data("categ");
        //alert("classSubType : "+classSubType);
        $('#searchTags').val(section+","+classType+","+classSubType);
        KScrollTo("#menu-section-classified");
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



/* -------------------------
AGENDA
----------------------------- */

<?php if(@$type == "events"){ ?>
var calendarInit = false;
function showResultInCalendar(mapElements){
  mylog.log("showResultInCalendar xxx");
  mylog.dir(mapElements);

  var events = new Array();
  $.each(mapElements, function(key, thisEvent){
    
    var startDate = exists(thisEvent["startDateTime"]) ? thisEvent["startDateTime"].substr(0, 10) : "";
    var endDate = exists(thisEvent["endDateTime"]) ? thisEvent["endDateTime"].substr(0, 10) : "";
    var cp = "";
    var loc = "";
    if(thisEvent["address"] != null){
        var cp = exists(thisEvent["address"]["postalCode"]) ? thisEvent["address"]["postalCode"] : "" ;
        var loc = exists(thisEvent["address"]["addressLocality"]) ? thisEvent["address"]["addressLocality"] : "";
    }
    var position = cp + " " + loc;

    var name = exists(thisEvent["name"]) ? thisEvent["name"] : "";
    var thumb_url = notEmpty(thisEvent["profilThumbImageUrl"]) ? baseUrl+thisEvent["profilThumbImageUrl"] : "";
    
    if(typeof events[startDate] == "undefined") events[startDate] = new Array();
    events[startDate].push({  "id" : thisEvent["_id"]["$id"],
                              "thumb_url" : thumb_url, 
                              "startDate": startDate,
                              "endDate": endDate,
                              "name" : name,
                              "position" : position });
  });

  //mylog.dir(events);

  if(calendarInit == true) {
    $(".calendar").html("");
  }

  $(".calendar").html($(".responsive-calendar-init").html());

  var aujourdhui = new Date();
  var  month = (aujourdhui.getMonth()+1).toString();
  if(aujourdhui.getMonth() < 10) month = "0" + month;
  var date = aujourdhui.getFullYear().toString() + "-" + month;
  
  $(".responsive-calendar").responsiveCalendar({
          time: date,
          events: events
        });


  $(".responsive-calendar").show();

  calendarInit = true;
}

<?php } ?>


/* -------------------------
END AGENDA
----------------------------- */

</script>