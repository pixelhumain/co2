<?php 
 $cssAnsScriptFilesModule = array(
    //'/js/default/directory.js',
  );
  //HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

  HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                          Yii::app()->theme->baseUrl. '/assets');

?>  
  <style>


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

#col-btn-type-directory .btn-directory-type,
#sub-menu-left .btn-select-type-anc{
  margin-bottom:5px;
  /*font-weight: 700;*/
  text-transform: uppercase;
  background-color: transparent;
}


@media (max-width: 768px) {
  #col-btn-type-directory{
    text-align: center!important;
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


#sub-menu-left.subsub .btn{
  width:95%;    
  text-align: right;
  background-color: white;
    border-color: white;
  color:#4285f4;
}
#sub-menu-left.subsub{
  min-width: 180px;
}

.btn-menu-left-add{
  background-color: transparent !important;
    border-color: transparent !important;
}

#photoAddNews{
  text-align: left;
}

.tagstags, .form-actions{
  /*display: none!important;*/
}


@media (max-width: 768px) {
  .btn-select-type-anc.col-xs-5{
    width:48%!important;
  }
}

  @media screen and (min-width: 768px) and (max-width: 1024px) {
    .btn-select-type-anc.col-xs-5{
    font-size:0.8em;
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
        
        
        <?php if($typeSelected == "place"){ ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  text-center subsub" id="menu-section-place">
          <!-- <button class="btn margin-bottom-5 margin-left-5 btn-select-type-anc letter-<?php echo @$section["color"]; ?>" 
                  data-type="classified" data-type-anc=""  data-key="all">
            <i class="fa fa-circle-o"></i>
            <span class="hidden-xs hidden-sm"> Tous </span>
          </button> -->
          <?php 
              $place = CO2::getContextList("place");
              $currentSection = 1;
              foreach ($place["sections"] as $key => $section) { ?>
                <div class="col-md-2 col-sm-3 col-sm-6 no-padding">
                  <button class="btn btn-default col-md-12 col-sm-12 padding-10 bold text-dark elipsis btn-select-type-anc" 
                          data-type-anc="<?php echo @$section["label"]; ?>" data-key="<?php echo @$section["key"]; ?>" 
                          data-type="place"
                          style="border-radius:0px; border-color: transparent; text-transform: uppercase;">
                    <i class="fa fa-<?php echo $section["icon"]; ?> fa-2x hidden-xs"></i><br><?php echo $section["label"]; ?>
                  </button>
                </div>
          <?php } ?>  
          <hr class="col-md-12 col-sm-12 col-xs-12 no-padding" id="before-section-result"> 
        </div>
        <?php } ?>


        <?php if($typeSelected == "all"){ ?>   
          
          <?php if(Yii::app()->params["CO2DomainName"] != "BCH"){ ?>  

          <div class="col-sm-2 col-md-2 col-xs-12 text-right margin-top-5 no-padding" id="col-btn-type-directory">
            <button class="btn text-white bg-dark btn-open-filliaire">
                <i class="fa fa-th"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","Themes") ?></span>
            </button><hr class="hidden-xs">
            <button class="btn text-black bg-white btn-directory-type btn-all" data-type="all">
                <i class="fa fa-search"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","All") ?></span>
            </button><hr class="hidden-xs">
            <button class="btn text-yellow btn-directory-type" data-type="persons">
                <i class="fa fa-user"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","People") ?></span>
            </button><hr class="hidden-xs">
            <button class="btn text-green  btn-directory-type" data-type="NGO">
                <i class="fa fa-group"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common", "NGOs") ?></span>
            </button><br class="hidden-xs">
            <button class="btn text-azure  btn-directory-type" data-type="LocalBusiness">
                <i class="fa fa-industry"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","Compagnies") ?></span>
            </button><br class="hidden-xs">
            <button class="btn text-turq btn-directory-type" data-type="Group">
                <i class="fa fa-circle-o"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","Groups") ?></span>
            </button><br class="hidden-xs">
            <button class="btn text-purple btn-directory-type" data-type="projects">
                <i class="fa fa-lightbulb-o"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","Projects") ?></span>
            </button><hr class="hidden-xs">
            <button class="btn text-red btn-directory-type" data-type="cities">
                <i class="fa fa-university"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","Cities") ?></span>
            </button><br class="hidden-xs">
            <button class="btn text-red btn-directory-type" data-type="GovernmentOrganization">
                <i class="fa fa-university"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","Public structures") ?></span>
            </button><hr class="hidden-xs">
            <button class="btn text-green-poi btn-directory-type" data-type="poi">
                <i class="fa fa-map-marker"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","Point of interest") ?></span>
            </button>
            <hr class="hidden-sm hidden-md hidden-lg">
          </div>
        <?php } ?>
        <?php } else if( $typeSelected == "vote" ){?>

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

        <?php } else if( $typeSelected == "events" ){?>

          <div class="col-sm-2 col-md-2 col-xs-12 text-right margin-top-5 no-padding" id="col-btn-type-directory">
            <button class="btn text-black bg-white btn-directory-type btn-all" data-type-event="" data-type="events">
                <i class="fa fa-search"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","All") ?></span>
            </button><hr class="hidden-xs">
            
            <?php $categories = Event::$types; 
                  foreach ($categories as $key => $cat) {
              ?>
                  <?php //if(is_array($cat)) { ?>
                    <button class="btn text-orange btn-directory-type" 
                            style="margin-left:-5px;" data-type-event="<?php echo $key; ?>" data-type="events">
                      <?php echo Yii::t("category",$cat); ?>
                    </button><br class="hidden-xs">
                  <?php //} ?>
              <?php } ?>
          </div>

        <?php }else if($typeSelected == "classified"){ ?>

        <?php 
          $params = CO2::getThemeParams();
          $devises = @$params["devises"];
        ?>
          <div class="col-lg-2 col-md-2 col-sm-3 col-xs-8 margin-top-15 text-right subsub classifiedFilters" id="sub-menu-left">
            <!-- <h4 class="text-dark padding-bottom-5"><i class="fa fa-angle-down"></i> Catégories</h4>
            <hr> -->
            <h4 class="margin-top-25 padding-bottom-10 letter-azure label-category" id="title-sub-menu-category">
              <i class="fa fa-search"></i>
            </h4>
            <hr>
            <?php 
                $classified = CO2::getContextList("classified");
                foreach ($classified['filters'] as $key => $cat) {
            ?>
                <?php if(is_array($cat)) { ?>
                  <button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
                    <i class="fa fa-<?php echo @$cat["icon"]; ?> hidden-xs"></i> <?php echo Yii::t("category",$key); ?>
                  </button><br>
                  <?php foreach ($cat["subcat"] as $key2 => $cat2) { ?>
                    <button class="btn btn-default text-azure margin-bottom-5 margin-left-15 hidden keycat keycat-<?php echo $key; ?>" data-categ="<?php echo $key; ?>" data-keycat="<?php echo $cat2; ?>">
                      <i class="fa fa-angle-right"></i> <?php echo Yii::t("category",$cat2); ?>
                    </button><br class="hidden">
                  <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php if( @Yii::app()->session["userId"] ) { ?> 
            <hr>
            <button class="btn btn-default margin-bottom-5 btn-select-category-1" style="margin-left:-5px;" data-keycat="favorites">
              <span class="text-red"><i class="fa fa-star hidden-xs"></i> <?php echo Yii::t("common","MY FAVORITES") ?></span>
            </button>
            <?php } ?>
          </div>
         
          <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12 text-center subsub" id="menu-section-classified">
            <!-- <button class="btn margin-bottom-5 margin-left-5 btn-select-type-anc letter-<?php echo @$section["color"]; ?>" 
                    data-type="classified" data-type-anc=""  data-key="all">
              <i class="fa fa-circle-o"></i>
              <span class="hidden-xs hidden-sm"> Tous </span>
            </button> -->
            <?php 
                $currentSection = 1;
                foreach ($classified["sections"] as $key => $section) { ?>
                  <div class="col-md-2 col-sm-4 col-xs-6 no-padding">
                    <button class="btn btn-default col-md-12 col-sm-12 padding-10 bold text-dark elipsis btn-select-type-anc" 
                            data-type-anc="<?php echo @$section["label"]; ?>" data-key="<?php echo @$section["key"]; ?>" 
                            data-type="classified"
                            style="border-radius:0px; border-color: transparent; text-transform: uppercase;">
                      <i class="fa fa-<?php echo $section["icon"]; ?> fa-2x hidden-xs"></i><br><?php echo Yii::t("category",$section["labelFront"]); ?>
                    </button>
                  </div>
            <?php } ?>  
             <hr class="col-md-12 col-sm-12 col-xs-12 no-padding" id="before-section-result">
          </div>

          <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12 padding-top-10" id="section-price">
          
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
              <label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding" for="sectionBtn">
                <i class="fa fa-chevron-down"></i> <?php echo Yii::t("common","Min price") ?>
              </label>
              <input type="text" id="priceMin" name="priceMin" class="form-control" 
                     placeholder="<?php echo Yii::t("common","Max Min") ?>"/>
            </div>

            <div class="form-group col-md-4 col-sm-4 col-xs-6">
              <label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding" for="sectionBtn">
                <i class="fa fa-chevron-down"></i> <?php echo Yii::t("common","Max price") ?>
              </label>
              <input type="text" id="priceMax" name="priceMax" class="form-control col-md-5" 
                     placeholder="<?php echo Yii::t("common","Max price") ?>"/>
            </div>
            
            <div class="form-group col-md-2 col-sm-2 col-xs-12">
              <label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding" for="sectionBtn">
                <i class="fa fa-money"></i> <?php echo Yii::t("common","Money") ?>
              </label>
              <select class="form-control" name="devise" id="devise" style="">
                <?php foreach($devises as $key => $devise){ ?>
                  <option class="bold" value="<?php echo $key; ?>"><?php echo $devise; ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group col-md-2 col-sm-2 col-xs-12 margin-top-10">
              <button class="btn btn-default col-md-12 margin-top-15 btn-directory-type" data-type="classified">
                <i class="fa fa-search"></i> <span class="hidden-xs hidden-ms"><?php echo Yii::t("common","Search") ?></span>
              </button>
            </div>

            <hr class="col-md-12 col-sm-12 col-xs-12 margin-top-10 no-padding" id="before-section-result"> 
          
          </div>
          <!-- </div> -->

        <?php } 
        else if($typeSelected == "place"){ ?>

          <div class="col-lg-2 col-md-2 col-sm-3 col-xs-8 margin-top-15 text-left subsub" id="sub-menu-left">
            <!-- <h4 class="text-dark padding-bottom-5"><i class="fa fa-angle-down"></i> Catégories</h4>
            <hr> -->
            <h4 class="margin-top-5 padding-bottom-10 letter-azure label-category" id="title-sub-menu-category">
              <i class="fa fa-money"></i> Lieux
            </h4>
            <hr>
            <?php 
                foreach ($place["filters"] as $key => $cat) {
            ?>
                <?php if(is_array($cat)) { ?>
                  <button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1 elipsis" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
                    <i class="fa fa-<?php echo @$cat["icon"]; ?> hidden-xs"></i> <?php echo $key; ?>
                  </button><br>
                  <?php foreach ($cat["subcat"] as $key2 => $cat2) { ?>
                    <button class="btn btn-default text-azure margin-bottom-5 margin-left-15 hidden keycat keycat-<?php echo $key; ?>" data-categ="<?php echo $key; ?>" data-keycat="<?php echo $cat2; ?>">
                      <i class="fa fa-angle-right"></i> <?php echo $cat2; ?>
                    </button><br class="hidden">
                  <?php } ?>
                <?php } ?>
              </button>
            <?php } ?>
          </div>

        <?php } ?>

        <?php $col = ( !in_array($typeSelected, array("classified","events","vote","all","place") )) ? 10 : 8; ?>
        <?php if(Yii::app()->params["CO2DomainName"] == "BCH"){ $col = 10; } ?>
        
        <div class="col-sm-<?php echo $col ?> col-md-<?php echo $col ?> col-xs-12" id="dropdown_search"></div>

        <div id="listTags" class="col-sm-2 col-md-2 hidden-xs hidden-sm text-left"></div>
      <?php } ?>
  </div>







<?php //$this->renderPartial(@$path."first_step_directory"); ?> 
<?php $city = (@$_GET['lockCityKey'] ? City::getByUnikey($_GET['lockCityKey']) : null);

      if($city == null && @$_GET['insee'])
        $city = City::getCityByInsee($_GET['insee']);
      
      $cityName = (($city!=null) ? $city["name"]. (@$city["cp"]? ", ".$city["cp"] : "") : "");
?>

<script type="text/javascript">

var headerParams = {
  "persons"       : { color: "yellow",  icon: "user",         name: trad.people },
  "organizations" : { color: "green",   icon: "group",        name: trad.organizations },
  "NGO"           : { color: "green",   icon: "group",        name: trad.NGOs },
  "LocalBusiness" : { color: "azure",   icon: "industry",     name: trad.LocalBusiness },
  "Group"         : { color: "black",   icon: "circle-o",     name: trad.groups },
  "projects"      : { color: "purple",  icon: "lightbulb-o",  name: trad.projects },
  "events"        : { color: "orange",  icon: "calendar",     name: trad.events },
  "vote"          : { color: "azure",   icon: "gavel",        name: "Propositions, Questions, Votes" },
  "actions"       : { color: "lightblue2",    icon: "cogs",   name: "actions" },
  "cities"        : { color: "red",     icon: "university",   name: trad.municipalities },
  "poi"       	  :	{ color: "black",   icon: "map-marker",   name: trad.pointsinterests },
  "wikidata"    : { color: "lightblue2",   icon: "group",   name: "Wikidata" },
  "datagouv"    : { color: "lightblue2",   icon: "bullhorn",   name: "DataGouv" },
  "osm"    : { color: "lightblue2",   icon: "bullhorn",   name: "Open Street Map" },
  "ods"    : { color: "lightblue2",   icon: "bullhorn",   name: "OpenDatasoft" },
  "place"         : { color: "green",   icon: "map-marker",   name: trad.places },
  "classified"    : { color: "lightblue2",   icon: "bullhorn",   name: trad.classifieds },
  "GovernmentOrganization" : { color: "red",   icon: "university",        name: "services publics" },

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
var allSearchType = [ "persons", "organizations", "projects", "events", "vote", "cities","place" ];

var personCOLLECTION = "<?php echo Person::COLLECTION ?>";
var userId = '<?php echo isset( Yii::app()->session["userId"] ) ? Yii::app() -> session["userId"] : null; ?>';
var lockCityKey = <?php echo (@$_GET['lockCityKey']) ? "'".$_GET['lockCityKey']."'" : "null" ?>;
var cityNameLocked = "<?php echo $cityName; ?>";
var typeSelected = <?php echo (@$_GET['type']) ? "'".$_GET['type']."'" : "null" ?>;

var filliaireCategories = <?php echo json_encode($filliaireCategories); ?>;
jQuery(document).ready(function() {

	
	currentTypeSearchSend = "search";


  $("#btn-slidup-scopetags").click(function(){
    slidupScopetagsMin();
  });


  searchType = (typeSelected == null) ? [ "persons" ] : [ typeSelected ];
  allSearchType = [ "persons", "organizations", "projects", "events", "events", "vote", "cities","poi","place" ];
	topMenuActivated = true;
	hideScrollTop = true; 
  loadingData = false;

	checkScroll();
  var timeoutSearch = setTimeout(function(){ }, 100);
  
  setTimeout(function(){ $("#input-communexion").hide(300); }, 300);

	//setTitle("<span id='main-title-menu'>Moteur de recherche</span>","search","Moteur de recherche");
	
  $('.tooltips').tooltip();

  setHeaderDirectory(typeSelected);  

  //showTagsScopesMin("#scopeListContainer");

  // if(lockCityKey != null){
  //   lockScopeOnCityKey(lockCityKey, cityNameLocked);
  // }else{
  //   rebuildSearchScopeInput();
  // }


  <?php if(Yii::app()->params["CO2DomainName"] == "BCH"){ ?>
      $("#sub-menu-filliaire").removeClass("hidden");
  <?php } ?>

  $(".btn-open-filliaire").click(function(){
      if($("#sub-menu-filliaire").hasClass("hidden"))
        $("#sub-menu-filliaire").removeClass("hidden");
      else{
        $("#sub-menu-filliaire").addClass("hidden");
        resetMyTags();
      }
  });

  $(".btn-select-filliaire").click(function(){
      mylog.log(".btn-select-filliaire");
      var fKey = $(this).data("fkey");
      myMultiTags = {};
      $.each(filliaireCategories[fKey]["tags"], function(key, tag){
        addTagToMultitag(tag);
      });
      mylog.log("myMultiTags", myMultiTags);
      
      startSearch(0, indexStepInit, searchCallback);
      KScrollTo("#content-social");
      bindCommunexionScopeEvents();
      //KScrollTo("#before-section-result");
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







