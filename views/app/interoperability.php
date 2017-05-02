<?php 

$cssAnsScriptFilesModule = array(
    '/js/default/directory.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

  HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                          Yii::app()->theme->baseUrl. '/assets');

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header',
          array( "layoutPath"=>$layoutPath, 
            "page" => "interoperability") ); 

    $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); 

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

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden text-center subsub" id="sub-menu-filliaire">
<!-- <h5>Recherche thématique<br><i class='fa fa-chevron-down'></i></h5> -->
<?php $filliaireCategories = CO2::getContextList("filliaireCategories"); 
      //var_dump($categories); exit;
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


<div id="container-result-interop_search" class="container-result-search">

    <div class="col-sm-2 col-md-2 col-xs-12 text-right margin-top-15 no-padding" id="col-btn-type-directory">
        <button class="btn text-black bg-dark btn-open-filliaire">
                <i class="fa fa-th"></i> 
                <span class="hidden-xs">Thématiques</span>
            </button><hr class="hidden-xs">
 		<button id="btn-wiki" class="btn text-grey btn-directory-type" data-type="wikidata">
<!--             <i class="fa fa-wikipedia-w"></i>
 -->            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo-wikidata.png'> 
            <span class="hidden-xs">Wikidata</span>
        </button><br class="hidden-xs">
        <button id="btn-datagouv" class="btn text-red btn-directory-type" data-type="datagouv">
<!--             <i class="fa fa-database"></i>
 -->            <img width=30 src='<?php echo $this->module->assetsUrl; ?>/images/logos/data-gouv-logo.png'> 
            <span class="hidden-xs">DataGouv</span>
        </button><br class="hidden-xs">
        <button id="btn-osm" class="btn text-green btn-directory-type" data-type="osm">
<!--             <i class="fa fa-map"></i>
 -->            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/OSM-logo.png'> 
            <span class="hidden-xs">Open Stret Map</span>
        </button><br class="hidden-xs">
        <button id="btn-ods" class="btn text-blue btn-directory-type" data-type="ods">
<!--             <i class="fa fa-folder-open-o"></i> 
 -->            <img width=50 src='<?php echo $this->module->assetsUrl; ?>/images/logos/opendata-soft-logo.png'> 
            <span class="hidden-xs">ODS : Base Sirene</span>
        </button><br class="hidden-xs">
        <button id="btn-ods" class="btn text-yellow btn-directory-type" data-type="datanova">
<!--             <i class="fa fa-folder-open-o"></i> 
 -->            <img width=70 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo-laposte.png'> 
            <span class="hidden-xs">Datanova : La poste</span>
        </button><br class="hidden-xs">
<!--         <hr class="hidden-sm hidden-md hidden-lg">
 -->    </div> 
    <div id="dropdown_search" class="col-md-8 col-sm-8 col-xs-10 padding-10"></div>
    <!-- <div class="col-sm-2 col-md-2 hidden-xs hidden-sm text-left"><select style="margin-bottom: 10px;" class="form-control hidden" id="select_activity"></select></div>
    <select class="form-control hidden" id="tags_select"></select> -->
    <!-- <div class="col-sm-2 col-md-2 hidden-xs hidden-sm text-left"><select style="margin-bottom: 10px;" class="form-control hidden" id="tags_value"></select></div> -->
    <div id="listTags" class="col-sm-2 col-md-2 hidden-xs hidden-sm text-left"></div>
</div>  

<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding shadow" id="content-social" style="min-height:700px;">

    <div class="col-md-12 col-sm-12 col-xs-12 padding-5" id="page"></div>

</div>

<!-- <div id="param_search" class="col-md-8 col-sm-8 col-xs-10 padding-10"><strong><center>Ici vous pourrez intéropérez avec la donnée venus d'ailleurs.
En cliquant sur l'un des boutons dans le menu à gauche vous pourez détaillez paramètres de la recherche que vous souhaitez spécifié</center></strong></div> -->

<?php

    $this->renderPartial($layoutPath.'footer', array("subdomain"=>"interoperability"));

?>

<script type="text/javascript">	

    var filliaireCategories = <?php echo json_encode($filliaireCategories); ?>;
    searchTags = $("#searchTags").val();
    geoShape = getGeoShape();
    geofilter = getGeofilterPolygon();
    activity_array = getActivityArray();


    var headerParams = {
        "persons"       : { color: "yellow",  icon: "user",         name: "citoyens" },
        "organizations" : { color: "green",   icon: "group",        name: "organisations" },
        "NGO"           : { color: "green",   icon: "group",        name: "associations" },
        "LocalBusiness" : { color: "azure",   icon: "industry",     name: "entreprises" },
        "Group"         : { color: "black",   icon: "circle-o",     name: "Groupes" },
        "projects"      : { color: "purple",  icon: "lightbulb-o",  name: "projets" },
        "events"        : { color: "orange",  icon: "calendar",     name: "événements" },
        "vote"          : { color: "azure",   icon: "gavel",        name: "Propositions, Questions, Votes" },
        "actions"       : { color: "lightblue2",    icon: "cogs",   name: "actions" },
        "cities"        : { color: "red",     icon: "university",   name: "communes" },
        "poi"           : { color: "black",   icon: "map-marker",   name: "points d'intérêts" },
        "wikidata"    : { color: "grey",   icon: "bullhorn",   name: "Wikidata" },
        "datagouv"    : { color: "red",   icon: "bullhorn",   name: "DataGouv" },
        "osm"    : { color: "green",   icon: "bullhorn",   name: "Open Street Map" },
        "ods"    : { color: "azure",   icon: "bullhorn",   name: "OpenDatasoft" },
        "datanova"    : { color: "yellow",   icon: "bullhorn",   name: "Datanova" }
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

        $(".btn-decommunecter").click(function(){
            activateGlobalCommunexion(false);
        });

        // $("#to_be_continued").click(function() {
        //     startSearchInterop(currentIndexMin+indexStep, currentIndexMax+indexStep);
        // });

        $(".btn-directory-type").click(function(){
            typeD = $(this).data("type");
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
            console.log("myMultiTags", myMultiTags);

            // $("#select_activity").val("-1");

            initTypeSearchInterop(type);

            startSearchInterop(0, indexStepInit);
            KScrollTo("#container-result-interop_search");

            if (typeD == "ods") {
            changeValueSelectByThemeForActivityAndTheme();
            } else if (typeD == "osm") {
            changeValueSelectByThemeOSM();
            }
        });  

        // if (searchTags !== "") {
        //     $("#tags_select").html('<option value="amenity">amenity</option>');
        //     changeValueSelectByTheme();
        // }

        $(window).bind("scroll",function(){  mylog.log("test scroll", scrollEnd);
            if(!loadingData && !scrollEnd && !isMapEnd){
    		    var heightWindow = $("html").height() - $("body").height();
    		    if( $(this).scrollTop() >= heightWindow - 400){
                    if (part_data.length == 30) 
    		        startSearchInterop(currentIndexMin+indexStep, currentIndexMax+indexStep);
    		    }
            }
        });

        type = "all";
        indexMin = 0;
        indexMax = 30;

        startNow = 0;
        endNow= 30;

        loadingData = false; 
        // initTypeSearch(type);

        var indexStepInit = 100;
    	var indexStep = indexStepInit;
    	var currentIndexMin = 0;
    	var currentIndexMax = indexStep;
    	var totalData = 0;
    });

    function searchCallback() { 
        directory.elemClass = '.searchEntityContainer ';
        directory.filterTags(true);
        $(".btn-tag").off().on("click",function(){ directory.toggleEmptyParentSection(null,"."+$(this).data("tag-value"), directory.elemClass, 1)});
        $("#searchBarTextJS").off().on("keyup",function() { 
        directory.search ( null, $(this).val() );
        });
    }

    function initTypeSearchInterop(typeInit){

        contextTestMap = [];

        totalData = 0;

        startNow = 0;
        endNow = 30;
    }

    function getUrlForInteropResearch(indexMin, indexMax) {

        if ( (searchTags == "") && (typeof typeD !== "undefined") ){
                if (typeD == "wikidata") {
                    url = "http://127.0.0.1/ph/api/convert/wikipedia?url=https://www.wikidata.org/wiki/Special:EntityData/"+communexion.values.wikidataID+".json";
                } else if (typeD == "datagouv") {
                    url = "http://127.0.0.1/ph/api/convert/datagouv?url=https://www.data.gouv.fr/api/1/spatial/zone/fr/town/"+communexion.values.insee+"/datasets";
                } else if (typeD == "osm") {
                    url = 'http://127.0.0.1/ph/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["name"](poly:"'+geoShape+'");out%20'+endNow+';';
                } else if (typeD == "ods") {
                    url = "http://127.0.0.1/ph/api/convert/ods?url=https://data.opendatasoft.com/api/records/1.0/search/?dataset=sirene%40public&facet=categorie&facet=proden&facet=libapen&facet=siege&facet=libreg_new&facet=saisonat&facet=libtefen&facet=depet&facet=libnj&facet=libtca&facet=liborigine&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
                    
                } else if (typeD == "datanova") {
                    url = "http://127.0.0.1/ph/api/convert/datanova?url=https://datanova.laposte.fr/api/records/1.0/search/?dataset=laposte_poincont&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
                } 

                else {
                    url = "http://127.0.0.1/ph/api/convert/wikipedia?url=https://www.wikidata.org/wiki/Special:EntityData/"+communexion.values.wikidataID+".json";
                }
        } 
        else if (typeof typeD !== "undefined") {

            if (typeD == "ods") {

                // activity_selected = $("#select_activity").val();

                // if ( (activity_selected == null) ){
                //     activity_selected = "-1";
                // }
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

                url = "http://127.0.0.1/ph/api/convert/ods?url=https://data.opendatasoft.com/api/records/1.0/search/?dataset=sirene%40public&facet=libapen&rows=30&start="+startNow+"&geofilter.polygon="+geofilter+libelle_activity;
            }  
            else if (typeD == "osm") {

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

                if (amenity_filter !== "") {
                    amenity_filter = amenity_filter.substring(1);
                    url = 'http://127.0.0.1/ph/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node[%27amenity%27~%27^('+amenity_filter+')%27](poly:"'+geoShape+'");out%20'+endNow+';';
                } else {
                    url = 'http://127.0.0.1/ph/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["amenity"="NIMPORTEQUOI"](poly:"'+geoShape+'");out%20'+endNow+';';
                }
            } 
            else {
                url = "http://127.0.0.1/ph/api/convert/wikipedia?url=https://www.wikidata.org/wiki/Special:EntityData/"+communexion.values.wikidataID+".json";
            }  
        }
        return url;
    }

    // function changeValueSelectByThemeOSM() {

    //     theme_array = getThemeArray();
    //     $("#all_activity").html(' ');

    //     $.each(theme_array, function(index, value) {
    //         if (searchTags == index) {
    //             $.each(value, function(index2, value2) {
    //                 $("#tags_value").append(
    //                     '<option value="'+value2+'">'+value2+'</option>'
    //                 );
    //                 icon = getIcon(value2);
    //                 $("#all_activity").append(
    //                     "<div id='btn_"+value2+"' class='col-md-4 padding-5 sectionBtnC forrent'>"+
    //                         "<a class='btn tagListEl btn-select-type-anc sectionBtn forrentBtn' data-tag='"+value2+"' data-key='forrent'><i class='fa fa-"+icon+" fa-2x'></i><br/>"+value2+
    //                         "</a>"+
    //                     "</div>"
    //                 );
    //                 putEventOnResultButtonOSM(value2); 
    //             });
    //         }
    //     });
    // }

    // function changeValueSelectByThemeForActivityAndTheme() {

    //     $("#all_activity").html(' ');

    //     $("#all_activity").append(
    //         "<div id='btn_all_activity' class='col-xs-offset-4 col-md-4 padding-5 sectionBtnC forrent'>"+
    //             "<a class='btn tagListEl btn-select-type-anc sectionBtn forrentBtn' data-tag='all_activity' data-key='forrent'><i class='fa fa-exclamation-circle    fa-2x'></i><br/>Afficher tout le secteur d'activité"+
    //             "</a>"+
    //         "</div>"
    //     );

    //     $("#btn_all_activity").off().on('click', function(e){
    //         $("#select_activity").val("-1");
    //         $("#activity_selected_div").html("TOUT LE SECTEUR D'ACTIVITE<br/>");
    //         KScrollTo("#dropdown_search");
    //         startSearchInterop(0, indexMax);
    //     });

    //     $.each(activity_array, function(index, value) {
    //         if (searchTags == index) {
    //             $.each(value, function(index2, value2) {
    //                 icon = getIcon(value2);

    //                 value_sans_spec = value2;
    //                 value_sans_spec = value_sans_spec.replace(/\'/g, "_SQUOTE_");
    //                 value_sans_spec = value_sans_spec.replace(/ /g, "_SPACE_");
    //                 value_sans_spec = value_sans_spec.replace(/\./g, "_DOT_");
    //                 value_sans_spec = value_sans_spec.replace(/\&/g, "_AND_");
    //                 value_sans_spec = value_sans_spec.replace(/\(/g, "_PAR-OUVRANT_");
    //                 value_sans_spec = value_sans_spec.replace(/\)/g, "_PAR-FERMANT_");
    //                 value_sans_spec = value_sans_spec.replace(/\,/g, "_VIRGULE_");

    //                 $("#select_activity").append("<option value='"+value_sans_spec+"'>"+value2+"</option>");

    //                 $("#all_activity").append(
    //                     "<div id='btn_"+value_sans_spec+"' class='col-md-6 padding-5 sectionBtnC forrent'>"+
    //                         "<a class='btn tagListEl btn-select-type-anc sectionBtn forrentBtn' data-tag='"+value_sans_spec+"' data-key='forrent'><i class='fa fa-"+icon+" fa-2x'></i><br/>"+value2+
    //                         "</a>"+
    //                     "</div>"
    //                 );
    //                 putEventOnResultButtonForActivityAndTheme(value_sans_spec); 
    //             });
    //         }
    //     });
    // }

    // function putEventOnResultButtonOSM(value) {

    //     $("#btn_"+value+"").off().on('click', function(e){
    //         $("#tags_value").val(value);
    //         $('#tag_value_selected').html("Tag choisi : "+value+"<br/>");
    //         startSearchInterop(0,indexMax);
    //         KScrollTo("#dropdown_search");
    //     });
    // }


    // function putEventOnResultButtonForActivityAndTheme(activity) {

    //     $("#btn_"+activity+"").off().on('click', function(e){
    //         value_with_spec = activity.replace(/_SPACE_/g, " ");
    //         value_with_spec = activity.replace(/_DOT_/g, ".");
    //         value_with_spec = activity.replace(/_AND_/g, "&");
    //         value_with_spec = activity.replace(/_PAR-OUVRANT_/g, "(");
    //         value_with_spec = activity.replace(/_PAR-FERMANT_/g, ")");
    //         value_with_spec = activity.replace(/_SQUOTE_/g, "'");
    //         value_with_spec = activity.replace(/_VIRGULE_/g, ",");
    //         $("#select_activity").val(activity);
    //         $("#activity_selected_div").html("<h2>Activité selectionné : "+value_with_spec+"<br/></h3>");
    //         startSearchInterop(0,indexMax);
    //         KScrollTo("#dropdown_search");
    //     });
    // }

    function startSearchInterop(indexMin, indexMax) {

        mylog.log("StartSearch INTEROPERABILITY");

        if (typeof(typeD) == "undefined") {
            // toastr.error("Pas de type de directory selectionné");
            return;
        }

	    indexStep = indexStepInit;

		var name = ($('#main-search-bar').length>0) ? $('#main-search-bar').val() : "";
	    
	    // if(name == "" && searchType.indexOf("cities") > -1) return;  

	    if(typeof indexMin == "undefined") indexMin = 0;
	    if(typeof indexMax == "undefined") indexMax = indexStep;

	    currentIndexMin = indexMin;
	    currentIndexMax = indexMax;

	    if(indexMin == 0 && indexMax == indexStep) {
	      totalData = 0;
	      mapElements = new Array(); 
	    }
	    else{ if(scrollEnd) return; }
	    
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
	   	getInteropResults(name, locality, indexMin, indexMax, url)
    }

    function getInteropResults(name, locality, indexMin, indexMax, url) {

        url = getUrlForInteropResearch(indexMin, indexMax);

    	mylog.log("nouvelle url à passer dans l'auro complete : ", url);

    	if(typeof(cityInseeCommunexion) != "undefined"){
	    var levelCommunexionName = { 1 : "CODE_POSTAL_INSEE",
	                             2 : "INSEE",
	                             3 : "DEPARTEMENT",
	                             4 : "REGION"
	                           };
		}else{
			var levelCommunexionName = { 1 : "INSEE",
		                             2 : "CODE_POSTAL_INSEE",
		                             3 : "DEPARTEMENT",
		                             4 : "REGION"
		                           };
		}
	      var data = {
            "name" : name, 
            "locality" : "",//locality, 
            "searchType" : searchType, 
            "searchTag" : ($('#searchTags').length ) ? $('#searchTags').val().split(',') : [] , //is an array
            "searchLocalityCITYKEY" : ($('#searchLocalityCITYKEY').length ) ? $('#searchLocalityCITYKEY').val().split(',') : [],
            "searchLocalityCODE_POSTAL" : ($('#searchLocalityCODE_POSTAL').length ) ? $('#searchLocalityCODE_POSTAL').val().split(',') : [], 
            "searchLocalityDEPARTEMENT" : ($('#searchLocalityDEPARTEMENT').length ) ?  $('#searchLocalityDEPARTEMENT').val().split(',') : [],
            "searchLocalityREGION" : ($('#searchLocalityREGION').length ) ? $('#searchLocalityREGION').val().split(',') : [],
            "searchBy" : levelCommunexionName[levelCommunexion], 
            "indexMin" : indexMin, 
            "indexMax" : indexMax
        };

	    loadingData = true;
	    
	    str = "<i class='fa fa-circle-o-notch fa-spin'></i>";
	    $(".btn-start-search").html(str);
	    $(".btn-start-search").addClass("bg-azure");
	    $(".btn-start-search").removeClass("bg-dark");
	    
	    if(indexMin > 0)
	    $("#btnShowMoreResult").html("<i class='fa fa-spin fa-circle-o-notch'></i> Recherche en cours ...");
	    else
	    $("#dropdown_search").html("<center><span class='search-loaderr text-dark' style='font-size:20px;'><i class='fa fa-spin fa-circle-o-notch'></i> Recherche en cours ...</span></center>");
	      
	    if(isMapEnd) {
	      $.blockUI({message : "<h1 class='homestead text-red'><i class='fa fa-spin fa-circle-o-notch'></i> Commune<span class='text-dark'>xion en cours ...</span></h1>"});
	    }

    	$.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "json",
        error: function (data){
            mylog.log("error autocomplete search"); mylog.dir(data);     
             //signal que le chargement est terminé
            loadingData = false;     
        },
        success: function(data){ mylog.log("success autocomplete search", data); //mylog.dir(data);

            if ((typeD == "ods") || (typeD == "datanova")) {
                part_data = data;
            } else {
                part_data = data.slice(startNow, endNow);
            }

            startNow = startNow + 30;
            endNow = endNow + 30;

            if(!part_data){ toastr.error(part_data.content); }
            else
            {
                var countData = 0;

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
                    searchType.push(typeD);
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

                str += directory.showResultsDirectoryHtml(part_data);
              
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
                    //remet l'icon "loupe" du bouton search
                    $(".btn-start-search").html("<i class='fa fa-refresh'></i>");
                    //active les link lbh
                    bindLBHLinks();

                    $(".start-new-communexion").click(function(){  
                        setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"),
                        $(this).data("insee-communexion"), $(this).data("name-communexion"), $(this).data("cp-communexion"),
                        $(this).data("region-communexion"), $(this).data("country-communexion") ) ;
                        activateGlobalCommunexion(true);
                    });

                    $.unblockUI();
                    $("#map-loading-data").html("");

                    //initialise les boutons pour garder une entité dans Mon répertoire (boutons links)
                    initBtnLink();
                } //end else (str=="")

                //signal que le chargement est terminé
                loadingData = false;

                //quand la recherche est terminé, on remet la couleur normal du bouton search
                $(".btn-start-search").removeClass("bg-azure");
        	}

            //si le nombre de résultat obtenu est inférieur au indexStep => tous les éléments ont été chargé et affiché
            //mylog.log("SHOW MORE ?", countData, indexStep);

            // if(countData < indexStep){
            //     $("#btnShowMoreResult").remove(); 
            //     scrollEnd = true;
            // }else{
            //     scrollEnd = false;
            // }

            if(typeof searchCallback == "function") {
                searchCallback();
            }

            // if( typeof page != "undefined" && page == "agenda" && typeof showResultInCalendar != "undefined")
            //   showResultInCalendar(data);

            $.each(part_data, function(index,value) {
                value.id = value.name;
            });

            if(mapElements.length==0) mapElements = part_data;
            else $.extend(mapElements, part_data);

            $.each(part_data, function(index, value) {
                // new_item_id = parseFloat(value.geo.latitude) + parseFloat(value.geo.longitude);
                new_item_id = Math.random(); 
                new_item_id = new_item_id.toString(); 
                new_item_id = new_item_id.replace('\.', '');
                new_item_id = parseInt(new_item_id);
                item = {
                    "_id": {
                        "$id" : new_item_id,
                    },
                    "geo": {
                        "@type": "GeoCoordinates",
                        "latitude": value.geo.latitude,
                        "longitude": value.geo.longitude,
                    },
                    "name" : value.name,
                    "typeSig" : "poi",
                }
                contextTestMap.push(item);
            });

            if (typeD == "datagouv") {
                contextTestMap = [];
            }

            Sig.showMapElements(Sig.map, contextTestMap);

            if (part_data.length < 30) {
                $("#btnShowMoreResult").addClass("hidden");
                return;
            }

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
</script>