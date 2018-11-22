<?php 
 $cssAnsScriptFilesModule = array(
    //'/js/default/directory.js',
  );
  //HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

  HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                          Yii::app()->theme->baseUrl. '/assets');

?>  
  <style>


.grayscale{
  filter: grayscale(100%);
  -webkit-filter: grayscale(100%);
  -moz-filter: grayscale(100%);
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
}
#col-btn-type-directory hr{
  border-top: 1px solid #f5f1f1;
  width: 95%;
  float: right;
}
#col-btn-type-directory .btn-directory-type,
#sub-menu-left .btn-select-type-anc{
  /*margin-bottom:5px;*/
  /*width:100%;*/
  text-align: right;
  line-height: 20px;
  vertical-align: text-bottom;
  /*font-weight: 700;*/
  color: grey;
  text-transform: uppercase;
  background-color: transparent;
}
/*.btn-directory-type{
  padding-right: 15px !important;
  border-radius: 0px;
  border: 0px;
}*/
.btn-directory-type:focus{
  outline: inherit !important;
}
/*.btn-directory-type:hover, .btn-directory-type.active{
  /*padding-right: 10px !important;
  margin-right:-3px!important;
  box-shadow: none !important;
  font-weight: bold !important;
}
.btn-directory-type.active{
  border-right: 3px solid;
}
.btn-directory-type .label-filter{
  max-width: 50%;
  font-size: 13px;
  vertical-align: middle;
  font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
}*/
.open-type-filter{
  display:none;
}
@media (max-width: 768px) {
  .open-type-filter{
    display: block;
    position: absolute;
    right: -33px;
    height: 50px;
    width: 50px;
    border: 1px solid #dadada;
    border-radius: 100%;
    text-align: right;
    padding-right: 8px;
    z-index: -1;
    font-size: 20px;
  }
  #col-btn-type-directory .btn-directory-type, #sub-menu-left .btn-select-type-anc{
    background-color: white;
  }
  #col-btn-type-directory, #sub-menu-left{
    position: fixed;
    width: 56%;
    left: -56%;
    background-color: white;
    /*top: 0px;*/
    top: 214px; 
    z-index: 300;
    padding: 0px;
    -webkit-box-shadow: 0px 2px 6px -1px rgba(0,0,0,.2);
    box-shadow: 0px 2px 6px -1px rgba(0,0,0,.2);
  }

  #sub-menu-left.subsub .btn {
    width: 100% !important;
    /*background-color: white !important;*/
    margin: 0px !important;
    border-radius: 0px;
  }

  #col-btn-type-directory.affix, #sub-menu-left.affix{
    top: 130px;
  }
}

  @media (min-width: 769px) {
  #col-btn-type-directory, #sub-menu-left {
    left:inherit !important;
  }

  #col-btn-type-directory.affix, #sub-menu-left.affix{
    top: 130px;
    left: 5% !important;
  }
}

/* ANNONCES MENU*/
<?php 
  $btnAnc = array("blue"    =>array("color1"=>"#4285f4", 
                      "color2"=>"#1c6df5"),

          "green"   =>array("color1"=>"#34a853", 
                      "color2"=>"#2b8f45"),

          "red"   =>array("color1"=>"#ea4335", 
                      "color2"=>"#cc392d"),

          "yellow"  =>array("color1"=>"#fbbc05", 
                      "color2"=>"#e3a800"),
          );
?>

<?php foreach($btnAnc as $color => $params){ ?>
.btn-anc-color-<?php echo $color; ?>{
    background-color: <?php echo $params["color1"]; ?>;
    border-color: <?php echo $params["color1"]; ?>!important;
    color: #fff!important;
}

.btn-anc-color-<?php echo $color; ?>:hover{
    background-color: <?php echo $params["color2"]; ?>!important;
    border-color: <?php echo $params["color1"]; ?>!important;
}
.btn-anc-color-<?php echo $color; ?>.active{ 
  background-color:#fff!important;
  color:<?php echo $params["color1"]; ?>!important;
}
.btn-anc-color-<?php echo $color; ?>.active:hover{
    background-color: #fff;
    color: <?php echo $params["color1"]; ?>;
}
<?php } ?>

.btn-select-category-1:hover,
.btn-select-category-1.active{
    background-color: #2C3E50!important;
    color: #fff!important;
    border-color:transparent!important;
}
.keycat:hover,
.keycat.active{
    background-color: #2BB0C6!important;
    color: #fff!important;
    border-color:transparent!important;
}


</style>
 
<div class="container-result-search col-md-12 col-sm-12 col-xs-12 no-padding">
      <?php if(@$_GET['type']!="") { ?>
        <?php $typeSelected = $_GET['type']; ?>
        <?php if($typeSelected == "persons") $typeSelected = "citoyens" ; ?>
        <?php $spec = Element::getElementSpecsByType($typeSelected); ?>
        <?php if(Yii::app()->params["CO2DomainName"] != "terla"){ ?>  
        <h4 class="text-left pull-left subtitle-search" style="margin-left:10px; margin-top:15px; width:100%;">
          <span class="subtitle-search text-<?php echo $spec["text-color"]; ?> homestead">
            <?php 
              $typeName = Yii::t("common",$_GET['type']); 
              if($_GET['type'] == "vote") $typeName = "propositions";
              if($_GET['type'] == "cities") $typeName = "communes";
            ?>
            <i class="fa fa-<?php echo $spec["icon"]; ?>"></i> <?php echo $typeName; ?><br>
            <i class="fa fa-angle-down"></i> 
            
          </span>
        </h4>
        <?php } ?>

        <?php if($typeSelected == "cities"){ ?>   
          <p class="text-center bold"> Recherchez une commune à laquelle vous communecter.<br>
              Une fois communecté, toutes vos recherches seront automatiquement filtrées en fonction de la commune choisie.
          </p>
        <?php } ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden text-center subsub" id="sub-menu-filliaire">
        <!-- <h5>Recherche thématique<br><i class='fa fa-chevron-down'></i></h5> -->
        <?php $filliaireCategories = CO2::getContextList("filliaireCategories"); 
              $col = "";
              if(sizeof($filliaireCategories) == 3) $col = "col-md-4 col-sm-4 col-sm-4";
              if(sizeof($filliaireCategories) == 4) $col = "col-md-3 col-sm-3 col-sm-3";
              if(sizeof($filliaireCategories) == 5) $col = "col-md-3 col-sm-3 col-sm-3";
              if(sizeof($filliaireCategories) >= 6) $col = "col-md-2 col-sm-3 col-sm-6";
              
              //var_dump($categories); exit;
              foreach ($filliaireCategories as $key => $cat) { 
                 if(is_array($cat)) { ?>
              <div class="<?php echo $col; ?> no-padding">
                <button class="btn btn-default col-md-12 col-sm-12 padding-10 bold text-dark elipsis btn-select-filliaire" 
                        data-fkey="<?php echo $key; ?>"
                        data-keycat="<?php echo $cat["name"]; ?>">
                  <i class="fa <?php echo $cat["icon"]; ?> fa-2x hidden-xs"></i><br><?php echo Yii::t("category", $cat["name"]); ?>
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
          <!-- <hr class="col-md-12 col-sm-12 col-xs-12 no-padding" id="before-section-result"> -->
        </div>    
        
        <?php if ( $typeSelected == "vote" ){ ?>

          <div class="col-sm-2 col-md-2 col-xs-12 text-right margin-top-15 no-padding" id="col-btn-type-directory">
            <button class="btn text-white bg-dark btn-open-filliaire">
                <i class="fa fa-th"></i> 
                <span class="hidden-xs">Thématiques</span>
            </button><hr class="hidden-xs">
            <button class="btn text-azure btn-link btn-directory-type" data-type="vote">
              <i class="fa fa-clock-o"></i> 
              <span class="hidden-xs">En ce moment</span>
            </button><hr>
            <button class="btn letter-green btn-link btn-directory-type" data-type="actions">
              <i class="fa fa-thumbs-o-up"></i> 
              <span class="hidden-xs">J'ai voté pour</span>
            </button><br>
            <button class="btn text-red btn-link btn-directory-type" data-type="actions">
              <i class="fa fa-thumbs-o-down"></i> 
              <span class="hidden-xs">J'ai voté contre</span>
            </button><hr>
            <button class="btn letter-green btn-link btn-directory-type" data-type="actions">
              <i class="fa fa-check"></i> 
              <span class="hidden-xs">Adoptées</span>
            </button><br>
            <button class="btn text-red btn-link btn-directory-type" data-type="actions">
              <i class="fa fa-times"></i> 
              <span class="hidden-xs">Refusées</span>
            </button>
          </div>

        <?php } else if (($typeSelected == "classifieds" || $typeSelected == "ressources") && Yii::app()->params["CO2DomainName"] != "terla" ){ 

           // $dmod = ($typeSelected == "classified") ? "classifieds" : "ressources";
            //$categories = CO2::getModuleContextList($typeSelected,"categories");
            if ($typeSelected == "classifieds")
              $categories = CO2::getModuleContextList(Classified::MODULE, "categories", $typeSelected);
            else
              $categories = CO2::getModuleContextList($typeSelected,"categories");
            
            $this->renderPartial("eco.views.co.categories", array( "typeSelected" => $typeSelected,"categories" => $categories ));
          }
          if($typeSelected != "classifieds" && Yii::app()->params["CO2DomainName"] == "terla"){ 
            $this->renderPartial("../default/panels/filterMenu", 
                  array("typeSelected"=>$typeSelected,
                        ));
          } 
        ?>
        <?php $col = ( !in_array($typeSelected, 
                       array("classifieds","ressources","products","services","circuits","events","vote","all","places") )) ? 9 : 9; ?>
        
        <?php if(Yii::app()->params["CO2DomainName"] == "terla"){ $col = 8; } ?>
          <?php if($typeSelected != "classifieds" && $typeSelected != "events"){ ?>
          <div class="no-padding col-md-10 col-sm-10 col-xs-12 text-left col-sm-offset-1 col-md-offset-1 headerSearchContainer"></div>
          <?php } ?>
          <div class="col-md-10 col-sm-10 col-sm-offset-1 col-md-offset-1 col-xs-12 bodySearchContainer">
            <div class="no-padding col-xs-12" id="dropdown_search">
              <div class='col-md-12 col-sm-12 text-center search-loader text-dark'>
                  <i class='fa fa-spin fa-circle-o-notch'></i> <?php echo Yii::t("common","Currently researching") ?> ...
              </div>
            </div>
          <div class="no-padding col-xs-12 text-left footerSearchContainer"></div>
        <?php } ?>
        </div>
  </div>

<?php $city = (@$_GET['lockCityKey'] ? City::getByUnikey($_GET['lockCityKey']) : null);

      if($city == null && @$_GET['insee'])
        $city = City::getCityByInsee($_GET['insee']);
      
      $cityName = (($city!=null) ? $city["name"]. (@$city["cp"]? ", ".$city["cp"] : "") : "");
?>

<script type="text/javascript">

if( typeof themeObj != "undefined" && typeof themeObj.headerParams != "undefined" )
{
  $.each(themeObj.headerParams,function(k,v) 
  { 
    headerParams[k] = v;
  });
}
var categoriesFilters ={};
if(searchObject.initType=="events") categoriesFilters=<?php echo json_encode(Event::$types) ?>;
if(searchObject.initType=="all"){
  categoriesFilters={
    "all":{"key":"all", "label":"All", "icon":"refresh", "color":"dark"},
    "persons" : { "key": "persons", "icon":"user", "label":"people","color":"yellow"}, 
    "NGO" : { "key": "NGO", "icon":"group", "label":"NGOs","color":"green-k"}, 
    "LocalBusiness" : { "key": "LocalBusiness", "icon":"industry", "label":"LocalBusiness","color":"azure"}, 
    "Group" : { "key": "Group", "icon":"circle-o", "label":"Groups","color":"turq"}, 
    "GovernmentOrganization" : { "key": "GovernmentOrganization", "icon":"university", "label":"services publics","color":"red"},
    "projects" : { "key": "projects", "icon":"lightbulb-o", "label":"projects","color":"purple"}, 
    "events" : { "key": "events", "icon":"calendar", "label":"events","color":"orange"}, 
    "poi" : { "key": "poi", "icon":"map-marker", "label":"points of interest","color":"green-poi"}, 
    //"place" : { "key": "place", "icon":"map-marker", "label":"points of interest","color":"brown"},
    //"places" : { "key": "places", "icon":"map-marker", "label":"Places","color":"brown"}, 
    "classifieds" : { "key": "classified", "icon":"bullhorn", "label":"classifieds","color":"azure"}, 
     
    //"ressources" : { "key": "ressources", "icon":"cubes", "label":"Ressource","color":"vine"} 
    //"services" : { "key": "services", "icon":"sun-o", "label":"services","color":"orange"}, "circuits" : { "key": "circuits", "icon":"ravelry", "label":"circuits","color":"orange"},
  };
}
function setHeaderDirectory(type){
 
  var params = new Array();

  if(typeof headerParams[type] == "undefined") return;
  params = headerParams[type];
  $(".subtitle-search").html( '<span class="text-'+params.color+'">'+
                                '<i class="fa fa-angle-down"></i> <i class="fa fa-'+params.icon+'"></i> '+
                                params.name+
                              '</span>' );

  $(".lbl-info-search .lbl-info").addClass("hidden");
  $(".lbl-info-search .lbl-info.lbl-info-"+type).removeClass("hidden");

  $("#dropdown_search").html("");

  if(type == "cities") { 
    $("#searchBarText").attr("placeholder", "rechercher une ville, un code postal..."); 
    $("#scopeListContainer, #btn-slidup-scopetags").hide(200);
  }else{ 
    $("#searchBarText").attr("placeholder", "rechercher par #tag ou mots clés..."); 
    $("#scopeListContainer, #btn-slidup-scopetags").show(200);
  }

  $(".menu-left-container #menu-extend .menu-button-left").removeClass("selected");
  $(".menu-left-container #menu-extend #menu-btn-"+type).addClass("selected");

  $(".my-main-container").scrollTop(0);

  if(typeof globalTheme != "undefined" && globalTheme=="CO2"){
    $('html, body').stop().animate({
          scrollTop: 0
      }, 800, '');
  }

  Sig.clearMap();

}

var searchType = [ "persons" ];
var allSearchType = [ "persons", "organizations", "projects", "events", "vote", "cities","places","ressources" ];

var personCOLLECTION = "<?php echo Person::COLLECTION ?>";
var userId = '<?php echo isset( Yii::app()->session["userId"] ) ? Yii::app() -> session["userId"] : null; ?>';
var lockCityKey = <?php echo (@$_GET['lockCityKey']) ? "'".$_GET['lockCityKey']."'" : "null" ?>;
var cityNameLocked = "<?php echo $cityName; ?>";
var typeSelected = <?php echo (@$_GET['type']) ? "'".$_GET['type']."'" : "null" ?>;

var filliaireCategories = <?php echo json_encode($filliaireCategories); ?>;

//var classifieds = modules.classifieds; //<?php //echo json_encode(CO2::getModuleContextList("classifieds","categories")); ?>;

jQuery(document).ready(function() {

  initKInterface({"affixTop":200});
	currentTypeSearchSend = "search";
  $("#col-btn-type-directory .btn-directory-type").each(function(){
    if($(this).data("type") != "all")
      $(this).addClass('text-'+headerParams[$(this).data("type")].color);
  });
  /*$(".btn-directory-type").hover(function(){
    $.each(headerParams, function(e,v){
      $(".btn-directory-type:not(.active)").removeClass("text-"+v.color);
    });
    $(this).addClass('text-'+headerParams[$(this).data("type")].color);
  });*/
  $("#btn-slidup-scopetags").click(function(){
    slidupScopetagsMin();
  });

  $(".open-type-filter").click(function(){
    if(!$(this).hasClass("show-dir")){
      $(this).addClass("show-dir").data("title", "<?php echo Yii::t("common","Close") ?>").find("i").removeClass("fa-chevron-right").addClass("fa-times");
      $("#col-btn-type-directory, #sub-menu-left").animate({ left : "0%" }, 400 );
    }else{
      $(this).removeClass("show-dir").data("title", "<?php echo Yii::t("common","Open filtering by type") ?>").find("i").removeClass("fa-times").addClass("fa-chevron-right");
      $("#col-btn-type-directory, #sub-menu-left").animate({ left : "-56%" }, 400 );
    
    }
  });
  searchType = (typeSelected == null) ? [ "persons" ] : [ typeSelected ];
	topMenuActivated = true;
	hideScrollTop = true; 
  loadingData = false;

	checkScroll();
  var timeoutSearch = setTimeout(function(){ }, 100);
  
  setTimeout(function(){ $("#input-communexion").hide(300); }, 300);
	
  $('.tooltips').tooltip();

  // if(lockCityKey != null){
  //   lockScopeOnCityKey(lockCityKey, cityNameLocked);
  // }else{
  //   rebuildSearchScopeInput();
  // }


  <?php if(Yii::app()->params["CO2DomainName"] == "terla"){ ?>
      $("#sub-menu-filliaire").addClass("hidden");
  <?php } ?>
  $('.tooltips').tooltip();
  searchPage = true;

  <?php if(!@$_GET["nopreload"]){ ?>
    //initBtnScopeList();
    indexStepInit = 100;
    
    startSearch(0, indexStepInit, searchCallback);
  <?php } ?>
});




</script>







