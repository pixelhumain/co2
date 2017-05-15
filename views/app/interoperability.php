<?php 

$cssAnsScriptFilesModule = array(
    '/js/default/directory.js',
    '/js/interoperability/interoperability.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

  HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                          Yii::app()->theme->baseUrl. '/assets');

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header',
          array( "layoutPath"=>$layoutPath, 
            "page" => "interoperability") ); 
?>

<style>

 	#page .bg-dark {
        color: white !important;
        background-color: #3C5665 !important;
    }
    #page .bg-red{
        background-color:#E33551 !important;
        color:white!important;
    }
    #page .bg-blue{
        background-color: #5f8295 !important;
        color:white!important;
    }
    #page .bg-green{
        background-color:#93C020 !important;
        color:white!important;
    }
    #page .bg-orange{
        background-color:#FFA200 !important;
        color:white!important;
    }
    #page .bg-yellow{
        background-color:#FFC600 !important;
        color:white!important;
    }
    #page .bg-turq{
        background-color: #229296 !important;
        color:white!important;
    }
    #page .bg-purple{
        background-color:#8C5AA1 !important;
        color:white!important;
    }
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

    .colonne {
      display:table-cell;
      padding:10px;
    }

    .logo_interop {
        margin-top: 10px;
        margin-bottom: 10px;
        max-height: 100px;
        width: auto;
        height: auto;
    }
    .lien_interop {
        margin-bottom: 20px;
    }
    
    .lien_interop_single {
        max-height: 134px;
    }

    .colonne {
        display:table-cell;
        padding:25px;
    }

    .disptable {
        display:table;
    }

    .one_opendasoft_item {
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 5px;
    }

.favElBtn, .favAllBtn{
  padding: 5px 8px;
  font-weight: 300;
  margin-bottom:5px;
}
#searchBarTextJS{
  margin-bottom: 15px;
}
.btn-open-filliaire{
  font-weight: 700;
  text-transform: uppercase;
  background-color: #3C5665 !important;
  color: white;
}

#col-btn-type-directory .btn-directory-type,
#sub-menu-left .btn-select-type-anc{
  margin-bottom:5px;
  /*font-weight: 700;*/
  text-transform: uppercase;
  background-color: transparent;
}

#col-btn-type-directory .btn-directory-type .btn-all{
  /*background-color: #F2F2F2;*/
}

.btn-select-filliaire:hover{
  background-color: #F2F2F2;
}
@media (max-width: 768px) {
  #col-btn-type-directory{
    text-align: center!important;
  }
}


</style>

<div class="input-group col-md-6 col-md-offset-3" id="main-input-group" style="margin-bottom:15px;">
    <input class="form-control" id="main-search-bar" placeholder="Rechercher une page ..." type="text">
    <span class="input-group-addon bg-white" id="main-search-bar-addon">
        <i class="fa fa-search"></i>
    </span>
</div>

<div style='text-align:center;'>
    <button class="btn btn-default" id="main-btn-start-search-interop">
        <i class="fa fa-search"></i> Lancer la recherche
    </button>
</div>

<?php     $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); ?>



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden text-center subsub" id="sub-menu-filliaire">
<?php $filliaireCategories = CO2::getContextList("filliaireCategories"); 
      foreach ($filliaireCategories as $key => $cat) { 
  ?>
      <?php if(is_array($cat)) { ?>
      <div class="col-md-2 col-sm-3 col-sm-6 no-padding">
        <button class="btn btn-default col-md-12 col-sm-12 padding-10 bold text-dark elipsis margin-bottom-5 btn-select-filliaire" 
                data-fkey="<?php echo $key; ?>"
                style="border-radius:0px; border-color: transparent; text-transform: uppercase;" 
                data-keycat="<?php echo $cat["name"]; ?>">
          <i class="fa <?php echo $cat["icon"]; ?> fa-2x hidden-xs"></i><br><?php echo $cat["name"]; ?>
        </button>
      </div>
        <?php //foreach ($cat as $key2 => $cat2) { ?>
          <!-- <button class="btn btn-default text-dark margin-bottom-5 margin-left-15 hidden keycat keycat-<?php //echo $key; ?>">
            <i class="fa fa-angle-right"></i> <?php //echo $cat2; ?>
          </button><br class="hidden"> -->
        <?php //} ?>
      <?php } ?>
    </button>
  <?php } ?>
  <hr class="col-md-12 col-sm-12 col-xs-12 no-padding" id="before-section-result">
</div>

<div id="all_activity" class="hidden col-sm-12 col-md-12 hidden-xs hidden-sm text-left"></div>


<div id="container-result-interop_search" class="container-result-search col-xs-12">

    <div class="col-sm-2 col-md-2 col-xs-12 text-right pull-left margin-top-15 no-padding" id="col-btn-type-directory">
        <button class="btn text-black bg-dark btn-open-filliaire">
            <i class="fa fa-th"></i> 
            <span class="hidden-xs">Thématiques</span>
        </button><hr class="hidden-xs">
        <button id="btn-all-interop" class="btn text-grey btn-directory-type" data-type="all_interop">
            <i class="fa fa-search"></i>
            <span class="hidden-xs">TOUS</span>
        </button><br class="hidden-xs">
        <hr class="hidden-xs">
 		<button id="btn-wiki" class="btn text-grey btn-directory-type" data-type="wikidata">
            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo-wikidata.png'> 
            <span class="hidden-xs">Wikidata</span>
        </button><br class="hidden-xs">
        <button id="btn-datagouv" class="btn text-red btn-directory-type" data-type="datagouv">
            <img width=30 src='<?php echo $this->module->assetsUrl; ?>/images/logos/data-gouv-logo.png'> 
            <span class="hidden-xs">DataGouv</span>
        </button><br class="hidden-xs">
        <button id="btn-osm" class="btn text-green btn-directory-type" data-type="osm">
            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/OSM-logo.png'> 
            <span class="hidden-xs">Open Stret Map</span>
        </button><br class="hidden-xs">
        <button id="btn-ods" class="btn text-blue btn-directory-type" data-type="ods">
            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/opendata-soft-logo.png'> 
            <span class="hidden-xs">ODS : Base Sirene</span>
        </button><br class="hidden-xs">
        <button id="btn-ods" class="btn text-yellow btn-directory-type" data-type="datanova">
            <img width=70 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo-laposte.png'> 
            <span class="hidden-xs">La poste</span>
        </button><br class="hidden-xs">
        <button id="btn-pole-emploi" class="btn text-blue btn-directory-type" data-type="pole_emploi">
            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo_pole_emploi.png'> 
            <span class="hidden-xs">Pôle emploi</span>
        </button><br class="hidden-xs">
        <hr class="hidden-xs">
    </div> 
    <div id="dropdown_search" class="col-md-8 col-sm-8 col-xs-10 padding-10"></div>
    <div id="listTags" class="col-sm-2 col-md-2 hidden-xs hidden-sm text-left"></div>
</div>  

<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding shadow" id="content-social" style="min-height:700px;">

    <div class="col-md-12 col-sm-12 col-xs-12 padding-5" id="page"></div>

</div>

<?php

    $this->renderPartial($layoutPath.'footer', array("subdomain"=>"interoperability"));

?>

<script type="text/javascript">	

    var filliaireCategories = <?php echo json_encode($filliaireCategories); ?>;
    searchTags = $("#searchTags").val();
    activity_array = getActivityArray();

    var headerParams = {
        // "poi"           : { color: "black",   icon: "map-marker",   name: "points d'intérêts" },
        // "all_interop"    : { color: "black",   icon: "bullhorn",   name: "all" },
        "wikidata"    : { color: "grey",   icon: "group",   name: "Wikidata" },
        "datagouv"    : { color: "red",   icon: "bullhorn",   name: "DataGouv" },
        "osm"    : { color: "green",   icon: "bullhorn",   name: "Open Street Map" },
        "ods"    : { color: "azure",   icon: "bullhorn",   name: "OpenDatasoft" },
        "datanova"    : { color: "yellow",   icon: "bullhorn",   name: "Datanova" },
        "pole_emploi" : { color: "blue",   icon: "bullhorn",   name: "Pole emploi" }
    }

    if( typeof themeObj != "undefined" && typeof themeObj.headerParams != "undefined" )
    {
      $.each(themeObj.headerParams,function(k,v) 
      { 
        headerParams[k] = v;
      });
    }

	jQuery(document).ready(function() {
        initKInterface({"affixTop":320}); 
        typeD = "wikidata";

        $(".btn-decommunecter").click(function(){
            activateGlobalCommunexion(false);
        });

        $(".btn-directory-type").click(function(){
            typeD = $(this).data("type");
            putInteropImageOnTitle(typeD);
            initTypeSearchInterop();
            startSearchInterop(0, indexStepInit);
            KScrollTo("#container-result-interop_search");
        });

        $(".btn-open-filliaire").click(function(){
            if($("#sub-menu-filliaire").hasClass("hidden")) {
                $("#sub-menu-filliaire").removeClass("hidden");
            }
            else {
                $("#sub-menu-filliaire").addClass("hidden");
            }
        });

        $(".btn-select-filliaire").click(function(){
            var fKey = $(this).data("fkey");
            myMultiTags = {};
            $.each(filliaireCategories[fKey]["tags"], function(key, tag){
                addTagToMultitag(tag);
            });

            initTypeSearchInterop(type);

            startSearchInterop(0, indexStepInit);
            KScrollTo("#container-result-interop_search");
        });  

        $("#main-btn-start-search-interop").click(function() {

            initTypeSearchInterop();
            startSearchInterop(0, indexStepInit);
            KScrollTo("#container-result-interop_search");

        });

        $(window).bind("scroll",function(){  mylog.log("test scroll", scrollEnd);
            if(!loadingData && !scrollEnd && !isMapEnd){
    		    var heightWindow = $("html").height() - $("body").height();
    		    if( $(this).scrollTop() >= heightWindow - 400){
                    if (typeD !== "all_interop") {
                        if (part_data.length == 30) {
                            scrollEnd = true;
                            mylog.log("ON RELANCE LA RECHERCHE AVEC LE SCROLL",scrollEnd);
                            startSearchInterop(currentIndexMin+indexStep, currentIndexMax+indexStep);
                        } 
                    } else {
                        scrollEnd = true;
                        nb_of_strop = 0;
                        mylog.log("ON RELANCE LA RECHERCHE AVEC LE SCROLL MAIS EN VOULANT TOUS LES INTEROP DATA");
                        startSearchInterop(currentIndexMin+indexStep, currentIndexMax+indexStep);
                    }
    		    }
            }
        });

        type = "all_interop";
        indexMin = 0;
        indexMax = 30;

        startNow = 0;
        endNow= 30;

        loadingData = false; 

        var indexStepInit = 100;
    	var indexStep = indexStepInit;
    	var currentIndexMin = 0;
    	var currentIndexMax = indexStep;
    	var totalData = 0;

        // startSearchInterop(0, 30);
    });

    function searchCallback() { 
        directory.elemClass = '.searchEntityContainer ';
        directory.filterTags(true);
        $(".btn-tag").off().on("click",function(){ directory.toggleEmptyParentSection(null,"."+$(this).data("tag-value"), directory.elemClass, 1)});
        $("#searchBarTextJS").off().on("keyup",function() { 
        directory.search ( null, $(this).val() );
        });
    }

    function initTypeSearchInterop(){

        contextTestMap = [];

        all_interop_data = [];

        all_interop_url = [];

        totalData = 0;
        nb_of_strop = 0;

        startNow = 0;
        endNow = 30;

        indexMin = 0;
        indexMax = 30;
    }

    function getUrlForInteropResearch(indexMin, indexMax) {

        all_interop_url = [];

        if (communexion.state == true) {

            var geoShape = getGeoShapeForOsm(communexion.values.geoShape);
            var geofilter = getGeofilterPolygon(communexion.values.geoShape);

            if ( (searchTags == "") && (typeof typeD !== "undefined") ){

                if (typeD == "wikidata") {
                    var url_interop = getUrlInteropForWiki(communexion.values.wikidataID);
                } else if (typeD == "datagouv") {
                    var url_interop = getUrlInteropForDatagouv(communexion.values.inseeCode);
                } else if (typeD == "osm") {
                    var url_interop = getUrlInteropForOsm(geoShape);
                } else if (typeD == "ods") {
                    var url_interop  = getUrlInteropForOds(geofilter);
                } else if (typeD == "datanova") {
                    var url_interop = getUrlInteropForDatanova(geofilter);
                } else if (typeD == "pole_emploi") {
                    var url_interop = getUrlInteropForPoleEmploi(communexion.values.inseeCode);
                } else if (typeD = "all_interop") {
                    all_interop_url = [];

                    var url_interop = getUrlInteropForWiki(communexion.values.wikidataID);
                    all_interop_url.push(url_interop);
                    
                    var url_interop = getUrlInteropForDatagouv(communexion.values.inseeCode);
                    all_interop_url.push(url_interop);
                    
                    var url_interop = getUrlInteropForOsm(geoShape);
                    all_interop_url.push(url_interop);          
                    
                    var url_interop  = getUrlInteropForOds(geofilter);
                    all_interop_url.push(url_interop);
                   
                    var url_interop = getUrlInteropForDatanova(geofilter);
                    all_interop_url.push(url_interop);
                   
                    var url_interop = getUrlInteropForPoleEmploi(communexion.values.inseeCode);
                    all_interop_url.push(url_interop);                       
                }
            } 
            else if (typeof typeD !== "undefined") { //searchTags !== ""

                if (typeD == "ods") {
                    libelle_activity = getLibelleActivity();
                    var url_interop = getUrlInteropForOds(geofilter, libelle_activity);
                }  
                else if (typeD == "osm") {
                    amenity_filter = getAmenityFilter();
                    var url_interop = getUrlInteropForOsm(geoShape, amenity_filter);
                } else if (typeD == "pole_emploi") {
                    rome_letters = getRomeActivityCodeFromThematic(searchTags);
                    var url_interop = getUrlInteropForPoleEmploi(communexion.values.inseeCode, rome_letters);
                } else if (typeD == "all_interop") {

                    amenity_filter = getAmenityFilter();
                    var url_interop = getUrlInteropForOsm(geoShape, amenity_filter);
                    all_interop_url.push(url_interop);

                    libelle_activity = getLibelleActivity();
                    var url_interop = getUrlInteropForOds(geofilter, libelle_activity);
                    all_interop_url.push(url_interop);

                    rome_letters = getRomeActivityCodeFromThematic(searchTags);
                    var url_interop = getUrlInteropForPoleEmploi(communexion.values.inseeCode, rome_letters);
                    all_interop_url.push(url_interop);
                }
            }  
        } else { // communexion.state == false

            scope_value = getScopeValue();

            getCityDataByInsee(scope_value);
            var geoShape = getGeoShapeForOsm(city_data.geoShape);
            var geofilter = getGeofilterPolygon(city_data.geoShape);

            if ( (searchTags == "") && (typeof typeD !== "undefined") ){

                if (typeD == "wikidata") {
                    var url_interop = getUrlInteropForWiki(city_data.wikidataID);
                } else if (typeD == "datagouv") {
                    var url_interop = getUrlInteropForDatagouv(city_data.insee);
                } else if (typeD == "osm") {
                    var url_interop = getUrlInteropForOsm(geoShape);
                } else if (typeD == "ods") {
                    var url_interop  = getUrlInteropForOds(geofilter);
                } else if (typeD == "datanova") {
                    var url_interop = getUrlInteropForDatanova(geofilter);
                } else if (typeD == "pole_emploi") {
                    var url_interop = getUrlInteropForPoleEmploi(city_data.insee);
                } else if (typeD = "all_interop") {
                    all_interop_url = [];
                    
                    var url_interop = getUrlInteropForWiki(city_data.wikidataID);
                    all_interop_url.push(url_interop);

                    var url_interop = getUrlInteropForOsm(geoShape);
                    all_interop_url.push(url_interop);          
                    
                    var url_interop  = getUrlInteropForOds(geofilter);
                    all_interop_url.push(url_interop);
                   
                    var url_interop = getUrlInteropForDatanova(geofilter);
                    all_interop_url.push(url_interop);

                    if (text_search_name == "") {

                        var url_interop = getUrlInteropForDatagouv(city_data.insee);
                        all_interop_url.push(url_interop);

                        var url_interop = getUrlInteropForPoleEmploi(city_data.insee);
                        all_interop_url.push(url_interop);    
                    }                   
                }
            } 
            else if (typeof typeD !== "undefined") { //searchTags !== ""

                if (typeD == "ods") {
                    libelle_activity = getLibelleActivity();
                    var url_interop = getUrlInteropForOds(geofilter, libelle_activity);
                }  
                else if (typeD == "osm") {
                    amenity_filter = getAmenityFilter();
                    var url_interop = getUrlInteropForOsm(geoShape, amenity_filter);
                } else if (typeD == "pole_emploi") {
                    rome_letters = getRomeActivityCodeFromThematic(searchTags);
                    var url_interop = getUrlInteropForPoleEmploi(city_data.insee, rome_letters);
                } else if (typeD == "all_interop") {

                    amenity_filter = getAmenityFilter();
                    var url_interop = getUrlInteropForOsm(geoShape, amenity_filter);
                    all_interop_url.push(url_interop);

                    libelle_activity = getLibelleActivity();
                    var url_interop = getUrlInteropForOds(geofilter, libelle_activity);
                    all_interop_url.push(url_interop);

                    if (text_search_name == "") {
                        rome_letters = getRomeActivityCodeFromThematic(searchTags);
                        var url_interop = getUrlInteropForPoleEmploi(city_data.insee, rome_letters);
                        all_interop_url.push(url_interop);
                    }
                }
            }  
        }
        return url_interop;
    }

    function startSearchInterop(indexMin, indexMax) {

        mylog.log("StartSearch INTEROPERABILITY");

        if (typeof(typeD) == "undefined") {
            // toastr.error("Pas de type de directory selectionné");
            typeD = "wikidata";
        }

	    indexStep = indexStepInit;

		text_search_name = ($('#main-search-bar').length>0) ? $('#main-search-bar').val() : "";
	    
	    // if(name == "" && searchType.indexOf("cities") > -1) return;  

	    // if(typeof indexMin == "undefined") indexMin = 0;
	    // if(typeof indexMax == "undefined") indexMax = indexStep;

	    currentIndexMin = indexMin;
	    currentIndexMax = indexMax;

	    // if(indexMin == 0 && indexMax == indexStep) {
	    //   totalData = 0;
	    //   mapElements = new Array(); 
	    // }
	    // else{ if(scrollEnd) return; }
	    
	    if(name.length>=3 || name.length == 0)
	    {
	      var locality = "";
	      if( communexionActivated )
	      {
	  	    if(typeof(cityInseeCommunexion) != "undefined")
	        {
	    			if(levelCommunexion == 1) locality = cpCommunexion;
	    			if(levelCommunexion == 2) locality = inseeCommunexion;
	    		}else{
	    			if(levelCommunexion == 1) locality = inseeCommunexion;
	    			if(levelCommunexion == 2) locality = cpCommunexion;
	    		}
	        //if(levelCommunexion == 3) locality = cpCommunexion.substr(0, 2);
	        if(levelCommunexion == 3) locality = inseeCommunexion;
	        if(levelCommunexion == 4) locality = inseeCommunexion;
	        if(levelCommunexion == 5) locality = "";

	        mylog.log("Locality : ", locality);
	      } 
	    }  

        var url_interop = getUrlForInteropResearch();
        if (all_interop_url.length > 0 ) {
            all_interop_data = [];
            $.each(all_interop_url,function(index, value) {
                getInteropResults(value);
            });
        } else {
            getInteropResults(url_interop);
        }
    }

    function getInteropResults(url_interop) {

    	mylog.log("nouvelle url à passer dans l'auro complete : ", url_interop);

	    loadingData = true;
	    
	    str = "<i class='fa fa-circle-o-notch fa-spin'></i>";
	    $(".btn-start-search").html(str);
	    $(".btn-start-search").addClass("bg-azure");
	    $(".btn-start-search").removeClass("bg-dark");

        mylog.log("L INDEX MIN EST EGAL A : ", indexMin);
	    
	    if(indexMin > 0)
	    $("#btnShowMoreResult").html("<i class='fa fa-spin fa-circle-o-notch'></i> Recherche en cours ...");
	    else
	    $("#dropdown_search").html("<center><span class='search-loaderr text-dark' style='font-size:20px;'><i class='fa fa-spin fa-circle-o-notch'></i> Recherche en cours ...</span></center>");
	      
	    if(isMapEnd) {
	      $.blockUI({message : "<h1 class='homestead text-red'><i class='fa fa-spin fa-circle-o-notch'></i> Commune<span class='text-dark'>xion en cours ...</span></h1>"});
	    }

    	$.ajax({
        type: "POST",
        url: url_interop,
        dataType: "json",
        error: function (data){
            mylog.log("error autocomplete INTEROP search"); mylog.dir(data);     
            //signal que le chargement est terminé
            loadingData = false;     
        },
        success: function(data){ mylog.log("success autocomplete INTEROP search", data); //mylog.dir(data);

            all_data_for_map = [];

            if (data.length > 0) {
                if ((data[0]["source"]["key"] == "convert_ods") || (data[0]["source"]["key"] == "convert_datanova")) {
                    mylog.log('CE SONT LES DATA DE ODS OU DATANOVA');
                    part_data = data;
                } else {
                    part_data = data.slice(startNow, endNow);
                }
            } else {
                part_data = [];
            }

            mylog.log('PART_DATA POUR CHAQUE INTEROP RESEARCH : ', part_data);

            $.each(part_data,function(index,value) {
                all_interop_data.push(value);
            });

            if (typeD == "all_interop") {

                if (searchTags == "") {
                    if (text_search_name == "") {
                        var nb_of_return = 5;
                    } else {
                        var nb_of_return = 3;
                    }
                } else {
                    if (text_search_name == "") {
                        var nb_of_return = 2;
                    } else {
                        var nb_of_return = 1;
                    }
                }

                if (nb_of_strop < nb_of_return) {
                    nb_of_strop++;
                    return;
                } else {
                    mylog.log("Il ne faut plus faire de return");
                }
            }

            startNow = startNow + 30;
            endNow = endNow + 30;

            if(!part_data){ toastr.error(part_data.content); }
            else
            {
                countData = 0;

                if (typeD !== "all_interop") {
                    $.each(part_data, function(i, v) { 
                        countData++; 
                    });
                } else {
                    $.each(all_interop_data, function(index, value) {
                        countData++;
                    });
                }

                totalData += countData;
            
                str = "";
                var city, postalCode = "";

                //parcours la liste des résultats de la recherche
                //mylog.dir(data);
                str += '<div class="col-md-12 text-left" id="nb_results_search">';
                str += "<h4 style='margin-bottom:10px; margin-left:15px;' class='text-dark'>"+
                        "<i class='fa fa-angle-down'></i> " + totalData + " résultats ";
                str += "<small>";
                if(typeof headerParams != "undefined"){
                    searchType = [];
                    if (typeD == "all_interop") {
                        $.each(headerParams, function(index, value) {
                            searchType.push(index);
                        });
                    } else {
                        searchType.push(typeD);
                    }
                    $.each(searchType, function(key, val){
                        mylog.log(headerParams[val]);
                        var params = headerParams[val];
                        str += "<span class='text-"+params.color+"'>"+
                                "<i class='fa fa-"+params.icon+" hidden-sm hidden-md hidden-lg padding-5'></i> <span class='hidden-xs'>"+params.name+"</span>"+
                              "</span> ";
                    });//console.log("myMultiTags", myMultiTags);
                    $.each(myMultiTags, function(key, val){
                        var params = headerParams[val];
                        str += "<span class='text-dark hidden-xs pull-right'>"+
                                "#"+key+
                              "</span> ";
                    });
                }
                str += "</small>";
                str += "</h4>";
                str += "<hr style='float:left; width:100%;'/>";
                str += "</div>";

                if (typeD == "all_interop") {
                    str += directory.showResultsDirectoryHtml(all_interop_data);
                } else {
                    str += directory.showResultsDirectoryHtml(part_data);
                }
              
                if(str == "") { 
                    $.unblockUI();
                    showMap(false);
                    $(".btn-start-search").html("<i class='fa fa-refresh'></i>"); 
                    if(indexMin == 0){
                        //ajout du footer   
                        var msg = "<i class='fa fa-ban'></i> Aucun résultat";    
                        if(name == "" && locality == "") msg = "<h3 class='text-dark padding-20'><i class='fa fa-keyboard-o'></i> Préciser votre recherche pour plus de résultats ...</h3>"; 
                        str += '<div class="pull-left col-md-12 text-left" id="footerDropdown" style="width:100%;">';
                        str += "<hr style='float:left; width:100%;'/><h3 style='margin-bottom:10px; margin-left:15px;' class='text-dark'>"+msg+"</h3><br/>";
                        str += "</div>";
                        $("#dropdown_search").html(str);
                        $("#searchBarText").focus();
                    } 
                }
                else
                {       
                    //ajout du footer      	
                    str += '<div class="pull-left col-md-12 text-center" id="footerDropdown" style="width:100%;">';
                    str += "<hr style='float:left; width:100%;'/><h3 style='margin-bottom:10px; margin-left:15px;' class='text-dark'>" + totalData + " résultats</h3>";
                    //str += '<span class="" id="">Complétez votre recherche pour un résultat plus précis</span></center><br/>';
                    str += '<button class="btn btn-default" id="btnShowMoreResult"><i class="fa fa-angle-down"></i> Afficher plus de résultat</div></center>';
                    str += "</div>";

                    //si on n'est pas sur une première recherche (chargement de la suite des résultat)
                    if(indexMin > 0){

                        mylog.log("ON CHARGE LA SUITE DES RESULTATS");

                        //on supprime l'ancien bouton "afficher plus de résultat"
                        $("#btnShowMoreResult").remove();
                        //on supprimer le footer (avec nb résultats)
                        $("#footerDropdown").remove();

                        //on calcul la valeur du nouveau scrollTop
                        var heightContainer = $(".main-container")[0].scrollHeight - 180;
                        //on affiche le résultat à l'écran
                        $("#dropdown_search").append(str);
                        //on scroll pour afficher le premier résultat de la dernière recherche
                        $(".my-main-container").animate({"scrollTop" : heightContainer}, 1700);
                        //$(".my-main-container").scrollTop(heightContainer);

                    //si on est sur une première recherche
                    }else{
                        //on affiche le résultat à l'écran
                        mylog.log("ON CHARGE LES PREMIERS RESULTATS");

                        $("#dropdown_search").html(str);

                        if(typeof myMultiTags != "undefined"){
                            $.each(myMultiTags, function(key, value){ //mylog.log("binding bold "+key);
                                $("[data-tag-value='"+key+"'].btn-tag").addClass("bold");
                            });
                        } 
                    }

                    indexMin = startNow;
                    indexMax = endNow;

                    if (typeD == "all_interop") {
                        $.each(all_interop_data, function(index, value) {

                            if (typeof(value.geo) !== "undefined")  {
                                createAndPushItemForMap(value);
                            } 
                        });
                    } else {
                        $.each(part_data, function(index, value) {
                            createAndPushItemForMap(value);
                        });
                    }

                    if (typeD == "datagouv") {
                        contextTestMap = [];
                    }

                    Sig.showMapElements(Sig.map, contextTestMap);


                    $('.add2fav').attr('target', '_blank');
                    //remet l'icon "loupe" du bouton search
                    $(".btn-start-search").html("<i class='fa fa-refresh'></i>");
                    //active les link lbh
                    // bindLBHLinks();

                    $(".start-new-communexion").click(function(){  
                        setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"),
                        $(this).data("insee-communexion"), $(this).data("name-communexion"), $(this).data("cp-communexion"),
                        $(this).data("region-communexion"), $(this).data("country-communexion") ) ;
                        activateGlobalCommunexion(true);
                    });

                    $.unblockUI();
                    $("#map-loading-data").html("");

                    //initialise les boutons pour garder une entité dans Mon répertoire (boutons links)
                    // initBtnLink();
                } //end else (str=="")

                //signal que le chargement est terminé
                loadingData = false;

                //quand la recherche est terminé, on remet la couleur normal du bouton search
                $(".btn-start-search").removeClass("bg-azure");
        	}

            //si le nombre de résultat obtenu est inférieur au indexStep => tous les éléments ont été chargé et affiché
            //mylog.log("SHOW MORE ?", countData, indexStep);

            if(countData < 30){
                $("#btnShowMoreResult").remove(); 
                scrollEnd = true;
            }else{
                scrollEnd = false;
            }

            if(typeof searchCallback == "function") {
                searchCallback();
            }

            // if( typeof page != "undefined" && page == "agenda" && typeof showResultInCalendar != "undefined")
            //   showResultInCalendar(data);

            // $.each(part_data, function(index,value) {
            //     value.id = value.name;
            // });

            if(mapElements.length==0) mapElements = part_data;
            else $.extend(mapElements, part_data);            

            // if (part_data.length < 30) {
            //     $("#btnShowMoreResult").addClass("hidden");
            //     return;
            // }

            // $.each(mapElements, function(index, value) {
            //     new_item_id = parseFloat(value.geo.latitude) + parseFloat(value.geo.longitude);
            //     new_item_id = new_item_id.toString();
            //     new_item_id = new_item_id.replace('\.', '');
            //     new_item_id = parseInt(new_item_id);

            //     value._id = {};
            //     value._id.$id = new_item_id;

            // });
            
            // affiche les éléments sur la carte
            // if(CoSigAllReadyLoad)
            // Sig.showMapElements(Sig.map, mapElements);
            // else{
            //   setTimeout(function(){ 
            //     Sig.showMapElements(Sig.map, mapElements);
            //   }, 3000);
            // }
            }
        });
	}

    function getCityDataByInsee(insee) {

        $.ajax({
            type: "GET",
            url: baseUrl + "/co2/interoperability/get/insee/"+insee,
            async: false,
            success: function(data){ mylog.log("succes get CityDataByInsee", data); //mylog.dir(data);
                // city_data = data;
                $.each(data, function(index, value) {
                    city_data = value;
                });
            }
        });

        return city_data;
    }

    function getScopeValue() {

        $.each(myMultiScopes, function(index, value) {
            if (value.active == true) {
                if (index.indexOf("_") > 0) {
                    scope_value = index;
                } else {
                    scope_value = value.name;
                }
            }
        });

        return scope_value;
    }

    function putInteropImageOnTitle(type) {

        $(".moduleTitle").html(
            '<i class="fa fa-database"></i>' +
            ' Module d\'intéropérabilité'
        );

        if (type == "wikidata") {
            $(".moduleTitle").append(
                "<img width=100 style='margin-top:20px;' src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo-wikidata.png'>"
            );
        } else if (type == "datagouv") {
            $(".moduleTitle").append(
                "<img width=100 style='margin-top:20px;' src='<?php echo $this->module->assetsUrl; ?>/images/logos/data-gouv-logo.png'>" 
            );
        } else if (type == "osm") {
            $(".moduleTitle").append(
                "<img width=100 style='margin-top:20px;' src='<?php echo $this->module->assetsUrl; ?>/images/logos/OSM-logo.png'>"
            );
        } else if (type == "ods") {
            $(".moduleTitle").append(
                "<img width=100 style='margin-top:20px;' src='<?php echo $this->module->assetsUrl; ?>/images/logos/opendata-soft-logo.png'>"
            );
        } else if (type == "datanova") {
            $(".moduleTitle").append(
                "<img width=200 style='margin-top:20px;' src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo-laposte.png'>"
            );
        } else if (type == "pole_emploi") {
            $(".moduleTitle").append(
                "<img width=100 style='margin-top:20px;' src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo_pole_emploi.png'>"
            );
        }
    }

    function createAndPushItemForMap(value) {

        var new_item_id = Math.random(); 
        var new_item_id = new_item_id.toString(); 
        var new_item_id = new_item_id.replace('\.', '');
        var new_item_id = parseInt(new_item_id);
        var item = {
            "_id": {
                "$id" : new_item_id,
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": value.geo.latitude,
                "longitude": value.geo.longitude,
            },
            "name" : value.name,
            "typeSig" : value.type,
            "url" : value.url,
        }
        contextTestMap.push(item);
    }

    function getAmenityFilter() {

        theme_array = getThemeArray();

        amenity_filter = "";

        $.each(theme_array, function(index, value) {
            if (searchTags == index) {
                $.each(value, function(index2, value2) {
                    if (value.length > 0) {
                        amenity_filter += "|" + value2;
                    }
                });
            }
        });

        amenity_filter = amenity_filter.substring(1);

        return amenity_filter;
    }

    function getLibelleActivity() {

        libelle_activity = "";

        $.each(activity_array, function(index, value) {
            if (searchTags == index) {
                $.each(activity_array, function(index, value) {
                    if (searchTags == index) {
                        $.each(value, function(index2, value2) {
                            libelle_activity += "&refine.libapen[]="+value2;
                        });
                    }
                });
                if (libelle_activity == "") {
                    libelle_activity = "&refine.libapen[]=NO AVAILABLE ACTIVITY";
                }
            }
        });

        libelle_activity += "&disjunctive.libapen=true";

        return libelle_activity;
    }

    function getUrlInteropForWiki(wikidataID) {

        if (text_search_name == "") {
            var url_wiki = "http://127.0.0.1/ph/api/convert/wikipedia?url=https://www.wikidata.org/wiki/Special:EntityData/"+wikidataID+".json";
        } else {
            var url_wiki = "http://127.0.0.1/ph/api/convert/wikipedia?url=https://www.wikidata.org/wiki/Special:EntityData/"+wikidataID+".json&text_filter="+text_search_name;
        }

        return url_wiki;
    }

    function getUrlInteropForDatagouv(insee) {

        var url_datagouv = "http://127.0.0.1/ph/api/convert/datagouv?url=https://www.data.gouv.fr/api/1/spatial/zone/fr/town/"+insee+"/datasets";

        return url_datagouv;
    }

    function getUrlInteropForOsm(geoShape, amenity_filter = null) {

        if (amenity_filter == null) {
            if (text_search_name == "") {
                var url_osm = 'http://127.0.0.1/ph/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["name"](poly:"'+geoShape+'");out%20'+endNow+';';
            } else {
                var url_osm = 'http://127.0.0.1/ph/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["name"~"'+text_search_name+'",i](poly:"'+geoShape+'");out%20'+endNow+';';
            }
        } else {

            if (amenity_filter == "") {
                var url_osm = 'http://127.0.0.1/ph/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["amenity"="NIMPORTEQUOI"](poly:"'+geoShape+'");out%20'+endNow+';';
            } else {
                if (text_search_name == "") {
                    var url_osm = 'http://127.0.0.1/ph/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["amenity"~"^('+amenity_filter+')"](poly:"'+geoShape+'");out%20'+endNow+';';
                } else {
                    var url_osm = 'http://127.0.0.1/ph/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["name"~"'+text_search_name+'"]["amenity"~"^('+amenity_filter+')"](poly:"'+geoShape+'");out%20'+endNow+';';
                }
            }
        }                         

        return url_osm;
    }

    function getUrlInteropForOds(geofilter, filter = null) {

        if (text_search_name == "") {
            var url_ods = "http://127.0.0.1/ph/api/convert/ods?url=https://data.opendatasoft.com/api/records/1.0/search/?dataset=sirene%40public&facet=categorie&facet=proden&facet=libapen&facet=siege&facet=libreg_new&facet=saisonat&facet=libtefen&facet=depet&facet=libnj&facet=libtca&facet=liborigine&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
        } else {
            url_ods = "http://127.0.0.1/ph/api/convert/ods?url=https://data.opendatasoft.com/api/records/1.0/search/?dataset=sirene%40public&q="+text_search_name+"&sort=datemaj&facet=categorie&facet=proden&facet=libapen&facet=siege&facet=libreg_new&facet=saisonat&facet=libtefen&facet=depet&facet=libnj&facet=libtca&facet=liborigine&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
        }

        if (filter !== null) {
            url_ods = url_ods + filter;
        }

        return url_ods;
    }

    function getUrlInteropForDatanova(geofilter) {

        if (text_search_name == "") {
            var url_datanova = "http://127.0.0.1/ph/api/convert/datanova?url=https://datanova.laposte.fr/api/records/1.0/search/?dataset=laposte_poincont&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
        } else {
            var url_datanova = "http://127.0.0.1/ph/api/convert/datanova?url=https://datanova.laposte.fr/api/records/1.0/search/?dataset=laposte_poincont&q="+text_search_name+"rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
        }

        return url_datanova;
    }

    function getUrlInteropForPoleEmploi(insee, filter = null) {

        if (filter == null) {
            var url_pole_emploi = "http://127.0.0.1/ph/api/convert/poleemploi?url=https://api.emploi-store.fr/partenaire/infotravail/v1/datastore_search_sql?sql=SELECT%20%2A%20FROM%20%22421692f5%2Df342%2D4223%2D9c51%2D72a27dcaf51e%22%20WHERE%20%22CITY_CODE%22=%27"+insee+"%27%20LIMIT%20"+endNow;
        } else {
            url_pole_emploi = "http://127.0.0.1/ph/api/convert/poleemploi?rome_activity="+filter+"&url=https://api.emploi-store.fr/partenaire/infotravail/v1/datastore_search_sql?sql=SELECT%20%2A%20FROM%20%22421692f5%2Df342%2D4223%2D9c51%2D72a27dcaf51e%22%20WHERE%20%22CITY_CODE%22=%27"+insee+"%27%20LIMIT%20"+endNow;
        }

        return url_pole_emploi;
    }
</script>