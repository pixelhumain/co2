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
    }N
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
    <input class="form-control" id="main-search-bar" placeholder="<?php echo Yii::t("common", "Search a page ...");?>" type="text">
    <span class="input-group-addon bg-white" id="main-search-bar-addon">
        <i class="fa fa-search"></i>
    </span>
</div>

<div style='text-align:center;'>
    <button class="btn btn-default" id="main-btn-start-search-interop">
        <i class="fa fa-search"></i> Lancer la recherche
    </button>
</div>

    <div id="container-scope-filter"  class="col-md-10 col-sm-10 col-xs-12 padding-5">
        <?php $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); ?>
    </div>

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
      <?php } ?>
    </button>
  <?php } ?>
  <hr class="col-md-12 col-sm-12 col-xs-12 no-padding" id="before-section-result">
</div>

<div id="all_activity" class="hidden col-sm-12 col-md-12 hidden-xs hidden-sm text-left"></div>

<div id="container-result-interop_search" class="container-result-search col-xs-12 bg-white">

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
        <button id="btn-eco-doct" class="btn text-blue btn-directory-type" data-type="eco_doct">
            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo_open_data_educ.jpg'> 
            <span class="hidden-xs">Ecoles doct</span>
        </button><br class="hidden-xs">
        <button id="btn-membres-univ" class="btn text-blue btn-directory-type" data-type="membres_univ">
            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo_open_data_educ.jpg'> 
            <span class="hidden-xs">Membres univ.</span>
        </button><br class="hidden-xs">
        <button id="btn-struc-recherche" class="btn text-blue btn-directory-type" data-type="struct_recherche">
            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo_open_data_educ.jpg'> 
            <span class="hidden-xs">Struc. recherche</span>
        </button><br class="hidden-xs">
        <button id="btn-etab-recherche" class="btn text-blue btn-directory-type" data-type="etab_recherche">
            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo_open_data_educ.jpg'> 
            <span class="hidden-xs">Etab. recherche</span>
        </button><br class="hidden-xs">
        <hr class="hidden-xs">
    </div> 
    <div id="dropdown_search" class="col-md-8 col-sm-8 col-xs-10 padding-10"></div>
    <div id="listTags" class="col-sm-2 col-md-2 hidden-xs hidden-sm text-left"></div>
</div>  

<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding shadow" id="content-social" style="min-height:700px;">

    <div class="col-md-12 col-sm-12 col-xs-12 padding-5" id="page"></div>

</div>

<script type="text/javascript">	

    var filliaireCategories = <?php echo json_encode($filliaireCategories); ?>;
    searchTags = $("#searchTags").val();

    var all_interop_data = [];
    var city_data = {};

    var headerParams = {
        "wikidata"    : { color: "grey",   icon: "group",   name: "Wikidata" },
        "datagouv"    : { color: "red",   icon: "bullhorn",   name: "DataGouv" },
        "osm"    : { color: "green",   icon: "bullhorn",   name: "Open Street Map" },
        "ods"    : { color: "azure",   icon: "bullhorn",   name: "OpenDatasoft" },
        "datanova"    : { color: "yellow",   icon: "bullhorn",   name: "Datanova" },
        "pole_emploi" : { color: "blue",   icon: "bullhorn",   name: "Pole emploi" },
        "etab_recherche" : { color: "blue",   icon: "bullhorn",   name: "Etablissement impliqués dans la recherche" },
        "eco_doct" : { color: "blue",   icon: "bullhorn",   name: "Ecole doctorales accrédité" },
        "membres_univ" : { color: "blue",   icon: "bullhorn",   name: "Membres des universités de France" },
        "struct_recherche" : { color: "blue",   icon: "bullhorn",   name: "Structures de recherche" },
    }

    // if( typeof themeObj != "undefined" && typeof themeObj.headerParams != "undefined" )
    // {
    //   $.each(themeObj.headerParams,function(k,v) 
    //   { 
    //     headerParams[k] = v;
    //   });
    // }

	jQuery(document).ready(function() {
        initKInterface({"affixTop":320}); 
        initTypeSearchInterop();
        typeD = "wikidata";

        $('.moduleTitle').append('<br/><a href="javascript:OpenDynFormForProposeOpenData()">Vous avez des données Open Data que vous souhaiteriez incorporez dans Communecter ? N\'attendez plus ! Proposez vous même vos sources de données libres et faites les valoriser !!!</a>');

        $(".btn-decommunecter").click(function(){
            activateGlobalCommunexion(false);
        });

        $(".btn-directory-type").click(function(){

        	mylog.log('LE TYPE DE DIRECTORY SOUHAITE : ', $(this).data("type") );
            typeD = $(this).data("type");
            putInteropImageOnTitle(typeD);
            initTypeSearchInterop();
            startSearchInterop(0, 30);
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

            startSearchInterop(0, 30);
            KScrollTo("#container-result-interop_search");
        });  

        $("#main-btn-start-search-interop").click(function() {

            initTypeSearchInterop();
            startSearchInterop(0, 30);
            KScrollTo("#container-result-interop_search");

        });

        $(window).bind("scroll",function(){  mylog.log("test scroll", scrollEnd);
            if(!loadingData && !scrollEnd && !isMapEnd){
    		    var heightWindow = $("html").height() - $("body").height();
    		    if( $(this).scrollTop() >= heightWindow - 400){
    		    	if (typeD == "all_interop" )
                    	nb_of_stop = 0;

                    if ( (typeD !== "all_interop" && part_data.length == 30) || typeD == "all_interop" ) {
                    	scrollEnd = true;
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

    	var indexStep = 30;
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
        scrollEnd = false;
        all_interop_data = [];
        all_interop_url = [];
        totalData = 0;
        nb_of_stop = 0;
        startNow = 0;
        endNow = 30;
        indexMin = 0;
        indexMax = 30;
    }

    function getUrlForInteropResearch(indexMin, indexMax) {

        all_interop_url = [];
        var url_interop = "";

        city_id = getCityId();
        type_zone = getTypeZone();

        city_data = getCityDataById(city_id, type_zone);

        var geoShape = getGeoShapeForOsm(city_data.geoShape);
        var geofilter = getGeofilterPolygon(city_data.geoShape);
        var city_wikidataID = city_data.wikidataID;
        var city_insee = city_data.insee;

        if (searchTags !== "") {
        	var libelle_activity = getLibelleActivity();
            var amenity_filter = getAmenityFilter();
            var rome_letters = getRomeActivityCodeFromThematic(searchTags);
        } else {
        	var libelle_activity = null;
            var amenity_filter = null;
            var rome_letters = null;
        }

        if (typeD !== "undefined") {
	        if (typeD == "wikidata") {
	            url_interop = getUrlInteropForWiki(city_wikidataID);
	        } else if (typeD == "datagouv") {
	            url_interop = getUrlInteropForDatagouv(city_insee);
	        } else if (typeD == "osm") {
	            url_interop = getUrlInteropForOsm(geoShape, amenity_filter);
	        } else if (typeD == "ods") {
	            url_interop  = getUrlInteropForOds(geofilter, libelle_activity);
	        } else if (typeD == "datanova") {
	            url_interop = getUrlInteropForDatanova(geofilter);
	        } else if (typeD == "pole_emploi") {
	            url_interop = getUrlInteropForPoleEmploi(city_insee, rome_letters);
	        } else if (typeD == "membres_univ") {
	        	url_interop = getUrlInteropForEducMembre(geofilter);
	        } else if (typeD == "etab_recherche") {
	        	url_interop = getUrlInteropForEducEtab(geofilter);
	        } else if (typeD == "eco_doct") {
	        	url_interop = getUrlInteropForEducEcole(geofilter);
	        } else if (typeD == "struct_recherche") {
	        	url_interop = getUrlInteropForEducStruct(geofilter);
	        }

	        else if (typeD == "all_interop") {
	            all_interop_url = [];
	            if (searchTags == "") {
	            	url_interop = getUrlInteropForWiki(city_wikidataID);
		            all_interop_url.push(url_interop);

		            url_interop = getUrlInteropForDatagouv(city_insee);
		            all_interop_url.push(url_interop);

		            url_interop = getUrlInteropForOsm(geoShape, amenity_filter);
		            all_interop_url.push(url_interop);

		            url_interop  = getUrlInteropForOds(geofilter, libelle_activity);
		            all_interop_url.push(url_interop);

		            url_interop = getUrlInteropForDatanova(geofilter);
		            all_interop_url.push(url_interop);
  
		            url_interop = getUrlInteropForEducMembre(geofilter);
					all_interop_url.push(url_interop);

					url_interop = getUrlInteropForEducEtab(geofilter);
					all_interop_url.push(url_interop);

					url_interop = getUrlInteropForEducEcole(geofilter);
					all_interop_url.push(url_interop);

					url_interop = getUrlInteropForEducStruct(geofilter);
					all_interop_url.push(url_interop);

		            if (text_search_name == "") {
			            url_interop = getUrlInteropForPoleEmploi(city_insee, rome_letters);
			            all_interop_url.push(url_interop);     
		            }
	            } else {
	            	url_interop = getUrlInteropForOsm(geoShape, amenity_filter);
		            all_interop_url.push(url_interop);

		            url_interop  = getUrlInteropForOds(geofilter, libelle_activity);
		            all_interop_url.push(url_interop);

	 				if (text_search_name == "") {
			            url_interop = getUrlInteropForPoleEmploi(city_insee, rome_letters);
			            all_interop_url.push(url_interop);     
		            }
	            }                
	        }
        }

        return url_interop;
    }

    function startSearchInterop(indexMin, indexMax) {

        if (typeof(typeD) == "undefined") {
            typeD = "wikidata";
        }

	    indexStep = 30;

		text_search_name = ($('#main-search-bar').length>0) ? $('#main-search-bar').val() : "";

	    currentIndexMin = indexMin;
	    currentIndexMax = indexMax;

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

    	mylog.log("nouvelle url à passer dans l'auto complete : ", url_interop);

	    loadingData = true;
	    
	    str = "<i class='fa fa-circle-o-notch fa-spin'></i>";
	    $(".btn-start-search").html(str);
	    $(".btn-start-search").addClass("bg-azure");
	    $(".btn-start-search").removeClass("bg-dark");
	    
	    if(indexMin > 0)
	    $("#btnShowMoreResult").html("<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...");
	    else
	    $("#dropdown_search").html("<center><span class='search-loaderr text-dark' style='font-size:20px;'><i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...</span></center>");
	      
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
                // $('#dropdown_search').append("<br/><div><h1>Something went wrong during this research ... </h1></div>");   
                $("#dropdown_search").html("<center><span class='search-loaderr text-dark' style='font-size:20px;'></i> Something went wrong during this research ...</span></center>");
	        },
	        success: function(data){ mylog.log("success autocomplete INTEROP search", data); 
	        	toastr.success("Une partie des données est arrivé");

	            all_data_for_map = [];

	            if (data.length > 0) {
	                if (data[0]["source"]["key"] == "convert_ods" || data[0]["source"]["key"] == "convert_datanova" || data[0]["source"]["key"] == "convert_educ_struct" || data[0]["source"]["key"] == "convert_educ_etab" || data[0]["source"]["key"] == "convert_educ_membre" || data[0]["source"]["key"] == "convert_educ_ecole") {
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

	            startNow = startNow + 30;
	            endNow = endNow + 30;

	            if(!part_data){ toastr.error(part_data.content); }
	            else {
	                countData = 0;

	                $.each(part_data, function(i, v) { 
	                    countData++; 
	                });

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

	                if ((Object.keys(part_data).length > 0 && typeD == "all_interop") || (typeD !== "all_interop") ){
		                str += directory.showResultsDirectoryHtml(part_data);
	                
	              
		                if(str == "") { 
		                    $.unblockUI();
		                    showMap(false);
		                    $(".btn-start-search").html("<i class='fa fa-refresh'></i>"); 
		                    if(indexMin == 0){
		                        //ajout du footer   
		                        var msg = "<i class='fa fa-ban'></i> "+trad.noresult;    
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

		                        $("#dropdown_search").html(str);

		                        if(typeof myMultiTags != "undefined"){
		                            $.each(myMultiTags, function(key, value){ //mylog.log("binding bold "+key);
		                                $("[data-tag-value='"+key+"'].btn-tag").addClass("bold");
		                            });
		                        } 
		                    }

		                    indexMin = startNow;
		                    indexMax = endNow;

	                        $.each(part_data, function(index, value) {
	                            createAndPushItemForMap(value);
	                        });

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

		            if(countData < 30){
		                $("#btnShowMoreResult").remove(); 
		                scrollEnd = true;
		            }else{
		                scrollEnd = false;
		            }

		            if(typeof searchCallback == "function") {
		                searchCallback();
		            }

		            if(mapElements.length==0) mapElements = part_data;
		            else $.extend(mapElements, part_data);     
		        } 
	        }
        });
	}

    function putInteropImageOnTitle(type) {

        $(".moduleTitle").html(
            '<i class="fa fa-database"></i>' +
            ' Module d\'intéropérabilité <br/>' 
        );

        var urlImg = "<img width=100 style='margin-top:20px;' src='<?php echo $this->module->assetsUrl; ?>";

        if (type == "wikidata") {
           	urlImg += "/images/logos/logo-wikidata.png'>";
        } else if (type == "datagouv") {
           	urlImg += "/images/logos/data-gouv-logo.png'>";
        } else if (type == "osm") {
        	urlImg += "/images/logos/OSM-logo.png'>";
        } else if (type == "ods") {
            urlImg += "/images/logos/opendata-soft-logo.png'>";
        } else if (type == "datanova") {
            urlImg += "/images/logos/logo-laposte.png'>";
        } else if (type == "pole_emploi") {
            urlImg += "/images/logos/logo_pole_emploi.png'>";
		}

		$(".moduleTitle").append(urlImg);
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

        var theme_array = getThemeArray();

        var amenity_filter = "";

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

        var activity_array = getActivityArray();

        var libelle_activity = "";

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

        libelle_activity += "&disjunctive.libapen=true";

        return libelle_activity;
    }

    function OpenDynFormForProposeOpenData(mapping = null) {

        var form = {
            saveUrl : baseUrl+"/"+moduleId+"/interoperability/proposeopendatasource",
            icon : "group",
            type : "object",
            dynForm : {
                jsonSchema : {
                    title : "Proposez vos sources Open Data",
                    icon : "fa-group",
                    afterSave : function(data){
                        dyFObj.closeForm();   
                    },
                    properties : {
                        url : dyFInputs.inputUrl("L'url de la source de donnée"),
                        description : dyFInputs.textarea("Présentez rapidement les valeurs de votre source"),
                    }
                }
            }
        };

        dyFObj.openForm(form, null, mapping);

        $(".modal-header").addClass("bg-dark");
    }    

</script>