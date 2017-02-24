<?php 
 $cssAnsScriptFilesModule = array(
    '/js/default/directory.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

  HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                          Yii::app()->theme->baseUrl. '/assets');

?>  
  <style>

<?php 
    $btnAnc = array("blue"      =>array("color1"=>"#ea4335", 
                                        "color2"=>"#ea4335"),
                    );
?>

<?php foreach($btnAnc as $color => $params){ ?>
.btn-anc-color-<?php echo $color; ?>{
    background-color: transparent;
    border-color: transparent;
    color: <?php echo $params["color1"]; ?>!important;
}

.btn-anc-color-<?php echo $color; ?>:hover{
    background-color:transparent!important;
    color:<?php echo $params["color1"]; ?>!important;
}
.btn-anc-color-<?php echo $color; ?>.active{ 
    border-color: <?php echo $params["color1"]; ?>!important;
    background-color:#fff!important;
    color:<?php echo $params["color1"]; ?>!important;
}
.btn-anc-color-<?php echo $color; ?>.active:hover{
    background-color: #fff;
    color: <?php echo $params["color1"]; ?>;
}
<?php } ?>

.favElBtn, .favAllBtn{
  padding: 5px 8px;
  font-weight: 300;
  margin-bottom:5px;
}
#searchBarTextJS{
  margin-bottom: 15px;
}

.btn-directory-type{
  margin-bottom:5px;
}

@media (max-width: 768px) {
  #col-btn-type-directory{
    text-align: center!important;
  }
}
  </style>
 

  <div class="container-result-search">

      <?php if(@$_GET['type']!="") { ?>
      <?php $typeSelected = $_GET['type']; ?>
      <?php if($typeSelected == "persons") $typeSelected = "citoyens" ; ?>
      <?php $spec = Element::getElementSpecsByType($typeSelected); ?>
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

	  	<div class="col-md-12 padding-10 margin-bottom-5 lbl-info-search">
		    <div class="lbl-info lbl-info-vote lbl-info-actions pull-left hidden col-xs-9 no-padding margin-bottom-10">
		      <i class="fa fa-info-circle"></i> 
		      <b>Seuls les résultats auxquels vous avez accès sont affichés</b> <br>
		      (issus de vos <span class="text-green"><b>organisations</b></span>, 
		      vos <span class="text-purple"><b>projets</b></span> ou votre <span class="text-red"><b>conseil citoyen</b></span>)
		    </div>

		    <div class="lbl-info lbl-info-organizations lbl-info-projects lbl-info-poi lbl-info-persons pull-left hidden col-xs-9 no-padding margin-bottom-10">
		      <i class="fa fa-info-circle"></i> 
		      <b>Résultats triés en fonction de l'activité la plus récente des éléments recherchés</b> 
		    </div>

		    <div class="lbl-info lbl-info-cities pull-left hidden col-xs-9 no-padding margin-bottom-10">
		      <i class="fa fa-info-circle"></i> Indiquez le nom d'une commune, ou un code postal, pour lancer la recherche
		    </div> 

		    <button class="btn btn-default pull-right text-dark" onclick="showMap(true)" style="margin-bottom: -15px;margin-top: -10px;">
		      <i class="fa fa-map"></i>
		      <span class="hidden-xs"> Afficher <span class="hidden-sm hidden-xs">sur</span> la carte</span>
		    </button>
	  	</div>

  		<div class="col-md-12">
          <hr class="margin-bottom-10">
      </div>

        <div class="col-sm-2 col-md-2 col-xs-12 text-right margin-top-10 no-padding" id="col-btn-type-directory">

          <?php if($typeSelected != "events" && $typeSelected != "vote"){ ?>   
          <button class="btn text-black bg-dark btn-directory-type" data-type="all">
              <i class="fa fa-th"></i> 
              <span class="hidden-xs">Rechercher par filliaire</span>
          </button><hr class="hidden-xs">
          <button class="btn text-black bg-white btn-directory-type" data-type="all">
              <i class="fa fa-search"></i> 
              <span class="hidden-xs">Tous</span>
          </button><hr class="hidden-xs">
          <button class="btn text-white bg-yellow btn-directory-type" data-type="persons">
              <i class="fa fa-user"></i> 
              <span class="hidden-xs">Citoyens</span>
          </button><hr class="hidden-xs">
          <button class="btn text-white bg-green  btn-directory-type" data-type="NGO">
              <i class="fa fa-group"></i> 
              <span class="hidden-xs">Associations</span>
          </button><br class="hidden-xs">
          <button class="btn text-white bg-azure  btn-directory-type" data-type="LocalBusiness">
              <i class="fa fa-industry"></i> 
              <span class="hidden-xs">Entreprises</span>
          </button><br class="hidden-xs">
          <button class="btn text-white bg-turq btn-directory-type" data-type="Group">
              <i class="fa fa-circle-o"></i> 
              <span class="hidden-xs">Groupes</span>
          </button><br class="hidden-xs">
          <button class="btn text-white bg-purple btn-directory-type" data-type="projects">
              <i class="fa fa-lightbulb-o"></i> 
              <span class="hidden-xs">Projets</span>
          </button><hr class="hidden-xs">
          <button class="btn text-white bg-red  btn-directory-type" data-type="cities">
              <i class="fa fa-university"></i> 
              <span class="hidden-xs">Communes</span>
          </button>
          <?php }?>
          <hr class="hidden-sm hidden-md hidden-lg">
        </div>

        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 margin-top-25 text-left subsub" id="sub-menu-left">
        <?php $categories = CO2::getContextList("classifiedCategories"); 
              foreach ($categories as $key => $cat) {
          ?>
              <?php if(is_array($cat)) { ?>
                <button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
                  <i class="fa fa-chevron-circle-down hidden-xs"></i> <?php echo $key; ?>
                </button><br>
                <?php foreach ($cat as $key2 => $cat2) { ?>
                  <button class="btn btn-default text-dark margin-bottom-5 margin-left-15 hidden keycat keycat-<?php echo $key; ?>">
                    <i class="fa fa-angle-right"></i> <?php echo $cat2; ?>
                  </button><br class="hidden">
                <?php } ?>
              <?php } ?>
            </button>
          <?php } ?>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-10 padding-10" id="dropdown_search"></div>
      
      <div id="listTags" class="col-sm-2 col-md-2 hidden-xs text-left"></div>
      
  </div>

<?php //$this->renderPartial(@$path."first_step_directory"); ?> 
<?php $city = (@$_GET['lockCityKey'] ? City::getByUnikey($_GET['lockCityKey']) : null);

      if($city == null && @$_GET['insee'])
        $city = City::getCityByInsee($_GET['insee']);
      
      $cityName = (($city!=null) ? $city["name"]. (@$city["cp"]? ", ".$city["cp"] : "") : "");
?>

<script type="text/javascript">

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
  "poi"       	  :	{ color: "black",   icon: "map-marker",   name: "points d'intérêts" },
  "classified"    : { color: "lightblue2",   icon: "bullhorn",   name: "Annonces" }
}

if( typeof themeObj != "undefined" && typeof themeObj.headerParams != "undefined" )
{
  $.each(themeObj.headerParams,function(k,v) 
  { 
    headerParams[k] = v;
  });
}

function setHeaderDirectory(type){
 
  var params = new Array();
  if(typeof headerParams[type] == "undefined") return;
  params = headerParams[type];
  $(".subtitle-search").html( '<span class="text-'+params.color+'">'+
                                '<i class="fa fa-angle-down"></i> <i class="fa fa-'+params.icon+'"></i> '+
                                params.name+
                              //  " <i class='fa fa-angle-right'></i> "+
                              // "<a href='javascript:directory.showFilters()' class='btn btn-default btn-sm'> "+
                              //  "<i class='fa fa-search'></i> Recherche avancée</a>"+
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
var allSearchType = [ "persons", "organizations", "projects", "events", "vote", "cities" ];

var personCOLLECTION = "<?php echo Person::COLLECTION ?>";
var userId = '<?php echo isset( Yii::app()->session["userId"] ) ? Yii::app() -> session["userId"] : null; ?>';
var lockCityKey = <?php echo (@$_GET['lockCityKey']) ? "'".$_GET['lockCityKey']."'" : "null" ?>;
var cityNameLocked = "<?php echo $cityName; ?>";
var typeSelected = <?php echo (@$_GET['type']) ? "'".$_GET['type']."'" : "null" ?>;

jQuery(document).ready(function() {

	
	currentTypeSearchSend = "search";


  $("#btn-slidup-scopetags").click(function(){
    slidupScopetagsMin();
  });


  searchType = (typeSelected == null) ? [ "persons" ] : [ typeSelected ];
  allSearchType = [ "persons", "organizations", "projects", "events", "events", "vote", "cities","poi" ];
	topMenuActivated = true;
	hideScrollTop = true; 
  loadingData = false;

	checkScroll();
  var timeoutSearch = setTimeout(function(){ }, 100);
  
  setTimeout(function(){ $("#input-communexion").hide(300); }, 300);

	setTitle("<span id='main-title-menu'>Moteur de recherche</span>","search","Moteur de recherche");
	
  $('.tooltips').tooltip();

  setHeaderDirectory(typeSelected);  

  showTagsScopesMin("#scopeListContainer");

  if(lockCityKey != null){
    lockScopeOnCityKey(lockCityKey, cityNameLocked);
  }else{
    rebuildSearchScopeInput();
  }


  $(".my-main-container").bind('scroll', function(){
    if(!loadingData && !scrollEnd){
        var heightContainer = $(".my-main-container")[0].scrollHeight;
        var heightWindow = $(window).height();
        
        if(scrollEnd == false){
          var heightContainer = $(".my-main-container")[0].scrollHeight;
          var heightWindow = $(window).height();
          if( ($(this).scrollTop() + heightWindow) >= heightContainer-150){
            mylog.log("scroll MAX");
            startSearch(currentIndexMin+indexStep, currentIndexMax+indexStep,searchCallback);
          }
        } 
    }
  });

  
  /*  $(".searchIcon").removeClass("fa-search").addClass("fa-file-text-o");
  $(".searchIcon").attr("title","Mode Recherche ciblé (ne concerne que cette page)");*/
  $('.tooltips').tooltip();
  searchPage = true;

  <?php if(!@$_GET["nopreload"]){ ?>
    //initBtnScopeList();
    indexStepInit = 100;
    startSearch(0, indexStepInit, searchCallback);
  <?php } ?>
});


</script>







