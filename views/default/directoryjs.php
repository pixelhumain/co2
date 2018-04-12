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
#col-btn-type-directory hr{
  border-top: 1px solid #f5f1f1;
  width: 70%;
  float: right;
}
#col-btn-type-directory .btn-directory-type,
#sub-menu-left .btn-select-type-anc{
  /*margin-bottom:5px;*/
  width:100%;
  text-align: right;
  line-height: 20px;
  vertical-align: text-bottom;
  /*font-weight: 700;*/
  color: grey;
  text-transform: uppercase;
  background-color: transparent;
}
.btn-directory-type{
  padding-right: 15px !important;
  border-radius: 0px;
  border: 0px;
}
.btn-directory-type:focus{
  outline: inherit !important;
}
.btn-directory-type:hover, .btn-directory-type.active{
  /*padding-right: 10px !important;*/
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
}
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


#sub-menu-left.subsub .btn{
  width:95%;    
  text-align: right;
  background-color: white;
    border-color: white;
  color:#4285f4;
}
#sub-menu-left.subsub{
 /* min-width: 180px;*/
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
.count-badge-filter{
    /*position: absolute;
    right: 10px;*/
    line-height: 15px;
    padding-left: 10px;
    font-size: 10px;
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
.headerSearchContainer{
  min-height: 30px;
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
        
        <?php 
//echo "<h1>".$typeSelected."</h1>" ;
//echo "<h1>".$_GET["app"]."</h1>" ;
        if($typeSelected == "place"){ ?>
        <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  text-center subsub" id="menu-section-place">
          <!-- <button class="btn margin-bottom-5 margin-left-5 btn-select-type-anc letter-<?php echo @$section["color"]; ?>" 
                  data-type="classified" data-type-anc=""  data-key="all">
            <i class="fa fa-circle-o"></i>
            <span class="hidden-xs hidden-sm"> Tous </span>
          </button>
          <?php 
              $place = CO2::getModuleContextList("places","categories");
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
        </div>-->
        <?php } ?>

        <?php if($typeSelected == "all" ){ ?>   
          
          <?php if(Yii::app()->params["CO2DomainName"] != "terla"){ ?>  
          <div class="no-padding col-md-10 col-sm-9 col-xs-12 text-left pull-right headerSearchContainer"></div>
          <div id="col-btn-type-directory" class="col-sm-3 col-md-2 col-xs-12 text-right no-padding margin-top-20">
            <button class="open-type-filter tooltips" data-toggle="tooltip" data-placement="right" data-title="<?php echo Yii::t("common","Open filtering by type") ?>"><i class="fa fa-chevron-right"></i></button>
            <!--<button class="btn text-white bg-dark btn-open-filliaire">
                <i class="fa fa-th"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","Themes") ?></span>
            </button><hr class="hidden-xs">-->
            <button class="btn text-black btn-directory-type btn-all active" data-type="all">
                <i class="fa fa-search"></i> 
                <span class=""><?php echo Yii::t("common","All") ?></span>
            </button>
            <!--<button class="btn border-dark btn-directory-type active padding-10" data-type="all">
                <i class="fa fa-asterisk"></i> 
                <span class="elipsis label-filter">
                  <?php echo Yii::t("common", "All") ?>
                </span>
                <span class="count-badge-filter" id="countall"></span>
            </button><hr class="hidden-xs no-margin" style="margin-top:0px;">
            
            <!-- <hr class="hidden-xs no-margin"> -->
            <button class="btn border-yellow-k btn-directory-type padding-10" data-type="persons">
                <i class="fa fa-user"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","People") ?></span>
                <span class="count-badge-filter" id="countcitoyens"></span>
            </button><hr class="hidden-xs no-margin">

            <!--<button class="btn border-dark btn-directory-type padding-10" data-type="organizations">
                <i class="fa fa-chevron-down"></i> 
                <span class="elipsis label-filter">
                  <?php echo Yii::t("common", "organizations") ?>
                </span>
                <span class="count-badge-filter" id="countorganizations"></span>
            </button><hr class="hidden-xs no-margin" style="margin-top:0px;">-->
            
            <button class="btn border-green btn-directory-type padding-10" data-type="NGO">
                <i class="fa fa-group"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common", "NGOs") ?></span>
                <span class="count-badge-filter" id="countNGO"></span>
            </button><br class="hidden-xs">
            <button class="btn border-azure btn-directory-type padding-10" data-type="LocalBusiness">
                <i class="fa fa-industry"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Compagnies") ?></span>
                <span class="count-badge-filter" id="countLocalBusiness"></span>
            </button><br class="hidden-xs">
            <button class="btn border-turq btn-directory-type padding-10" data-type="Group">
                <i class="fa fa-circle-o"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Groups") ?></span>
                <span class="count-badge-filter" id="countGroup"></span>
            </button><br class="hidden-xs">

            <button class="btn border-red btn-directory-type padding-10" data-type="GovernmentOrganization">
                <i class="fa fa-university"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Public structures") ?></span>
                <span class="count-badge-filter" id="countGovernmentOrganization"></span>
            </button>
            <hr class="hidden-xs no-margin">
            <button class="btn border-purple btn-directory-type padding-10" data-type="projects">
                <i class="fa fa-lightbulb-o"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Projects") ?></span>
                <span class="count-badge-filter" id="countprojects"></span>
            </button>
            <!--<hr class="hidden-xs no-margin" data-type="projects">
            <button class="btn border-brown btn-directory-type padding-10" data-type="places">
                <i class="fa fa-home"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Places") ?></span>
                <span class="count-badge-filter" id="countplaces"></span>
            </button>-->
            <hr class="hidden-xs no-margin" data-type="place">
            <button class="btn border-green-poi btn-directory-type padding-10" data-type="poi">
                <i class="fa fa-map-marker"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Point of interest") ?></span>
                <span class="count-badge-filter" id="countpoi"></span>
            </button>
            <hr class="hidden-xs no-margin" data-type="place">
            <button class="btn border-orange btn-directory-type padding-10" data-type="events">
                <i class="fa fa-calendar"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Events") ?></span>
                <span class="count-badge-filter" id="countevents"></span>
            </button>
           <!--  <hr class="hidden-xs no-margin">
            
            <button class="btn letter-blue border-blue btn-directory-type padding-5" data-type="url">
                <i class="fa fa-screen"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Url") ?></span>
                <span class="badge count-badge-filter bg-purple" id="counturl"></span>
            </button><br class="hidden-xs"> -->

            <hr class="hidden-xs no-margin">
            
            <!--<button class="btn border-blue btn-directory-type padding-10" data-type="news">
                <i class="fa fa-newspaper-o"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","News") ?></span>
                <span class="count-badge-filter" id="countnews"></span>
            </button><br class="hidden-xs">

            <hr class="hidden-xs no-margin">-->
            
            <button class="btn border-blue btn-directory-type padding-10" data-type="classified">
                <i class="fa fa-bullhorn"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Classified") ?></span>
                <span class="count-badge-filter" id="countclassified"></span>
            </button><br class="hidden-xs">
            
            <button class="btn border-blue btn-directory-type padding-10" data-type="ressources">
                <i class="fa fa-cubes"></i> 
                <span class="elipsis label-filter"><?php echo Yii::t("common","Ressources") ?></span>
                <span class="count-badge-filter" id="countressources"></span>
            </button>

            <hr class="hidden-sm hidden-md hidden-lg no-margin" data-type="ressources">
          </div>
        <?php } ?>
        <?php } else if ( $typeSelected == "vote" ){?>

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

        <?php } else if ( $typeSelected == "events" ){?>
          <style type="text/css">
            header{
              padding-bottom:15px;
            }
          </style>
          <div class="no-padding col-md-10 col-sm-9 col-xs-12 text-left pull-right headerSearchContainer"></div>
          <div id="col-btn-type-directory" class="col-md-2 col-sm-3 col-xs-12 text-right margin-top-20 no-padding">
            <!--<button class="btn text-black bg-white btn-directory-type btn-all" data-type-event="" data-type="events">
                <i class="fa fa-search"></i> 
                <span class="hidden-xs"><?php echo Yii::t("common","All") ?></span>
            </button><hr class="hidden-xs">-->
            <button class="open-type-filter tooltips" data-toggle="tooltip" data-placement="right" data-title="<?php echo Yii::t("common","Open filtering by type") ?>"><i class="fa fa-chevron-right"></i></button>
            
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

        <?php } else if ($typeSelected == "classified" || $typeSelected == "ressources" ){ 
          if(Yii::app()->params["CO2DomainName"] != "terla"){

            $dmod = ($typeSelected == "classified") ? "classifieds" : "ressources";
            $categories = CO2::getModuleContextList($dmod,"categories");
            $this->renderPartial($dmod.".views.co.categories", array( "typeSelected" => $typeSelected,"categories" => $categories ));
          } else { 

          $service = CO2::getContextList("service");
          ?> 
          <!-- TEEEEEEERLAAAAAAA MENUUUUUUU -------------------------------
          <div class="col-lg-2 col-md-3 col-sm-3 col-md-offset-1 col-sm-offset-1 col-xs-12 margin-top-25 text-left subsub no-padding shadow2" id="sub-menu-left">
              <h4 class="bg-orange text-white no-margin padding-10">FILTRE</h4>      
              <div class="col-md-12 no-padding padding-top-10 padding-bottom-10 label-category" id="title-sub-menu-category">
                <h4 class="col-md-10">Toute destination</h4> <span class="col-md-2 bg-orange"><i class="fa fa-angle-right"></i><span>
              </div>
              <hr>
              <?php 
                  foreach ($service["categories"] as $key => $cat) {
              ?>
                  <div class="col-md-12 text-dark margin-bottom-5">
                      <input type="checkbox" class="btn-select-category-1" data-keycat="<?php echo $key; ?>"> <?php echo Yii::t("category",$cat); ?> 
                    </div><br>
              <?php } ?>
              <div class="col-md-12 no-padding padding-top-10 padding-bottom-10 label-category" id="title-sub-menu-category">
                <h4 class="col-md-10">Vous voyagez</h4> <span class="col-md-2 bg-orange"><i class="fa fa-angle-right"></i><span>
              </div>
              <input type="text" id="filterNumber" value="" placeholder="Number of travellers">
              <label>Date of travel</label>
              <span>From</span>
              <input type="date" name=""><br/>
              <span>To</span>
              <input type="date" name="">
              <label>Price for search</label>
              <input type="price" name="">
              
              <label>Adapted time</label>
             <div class="col-md-12 text-dark margin-bottom-5">
                <input type="checkbox" class="btn-select-category-1" data-keycat="senior"> <?php echo Yii::t("category","Senior"); ?> 
              </div>
              <div class="col-md-12 text-dark margin-bottom-5">
                <input type="checkbox" class="btn-select-category-1" data-keycat="pmr"> <?php echo Yii::t("category","PMR"); ?> 
              </div>
              <div class="col-md-12 text-dark margin-bottom-5">
                <input type="checkbox" class="btn-select-category-1" data-keycat="famillychild"> <?php echo Yii::t("category","Familly with children"); ?> 
              </div>
              <div class="col-md-12 text-dark margin-bottom-5">
                <input type="checkbox" class="btn-select-category-1" data-keycat="healthfood"> <?php echo Yii::t("category","Food care"); ?>
              </div>
            </div>-->
        <?php } 
        }
        else if($typeSelected == "place"){ ?>

          <!--<div id="sub-menu-left" class="col-lg-2 col-md-2 col-sm-3 col-xs-8 margin-top-15 text-left subsub">
            <!-- <h4 class="text-dark padding-bottom-5"><i class="fa fa-angle-down"></i> Catégories</h4>
            <hr> 
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
          </div>-->

        <?php } ?>

        <?php  
          if($typeSelected != "classified" && Yii::app()->params["CO2DomainName"] == "terla"){ 
            $this->renderPartial("../default/panels/filterMenu", 
                  array("typeSelected"=>$typeSelected,
                        ));
          } 
        ?>
        <?php $col = ( !in_array($typeSelected, 
                       array("classified","ressources","products","services","circuits","events","vote","all","places") )) ? 9 : 9; ?>
        
        <?php if(Yii::app()->params["CO2DomainName"] == "terla"){ $col = 8; } ?>

		<div class="col-md-10 col-sm-9 col-xs-12 pull-right">
			<div class="no-padding col-xs-12" id="dropdown_search"></div>
			<div class="no-padding col-xs-12 text-left footerSearchContainer"></div>
			<?php if(Yii::app()->params["CO2DomainName"] != "terla"){ ?> 
				<!--<div id="listTags" class="col-sm-2 col-md-2 hidden-xs hidden-sm text-left"></div>-->
			<?php } ?>
			<?php } ?>
		</div>
  </div>







<?php //$this->renderPartial(@$path."first_step_directory"); ?> 
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
var allSearchType = [ "persons", "organizations", "projects", "events", "vote", "cities","places","ressources" ];

var personCOLLECTION = "<?php echo Person::COLLECTION ?>";
var userId = '<?php echo isset( Yii::app()->session["userId"] ) ? Yii::app() -> session["userId"] : null; ?>';
var lockCityKey = <?php echo (@$_GET['lockCityKey']) ? "'".$_GET['lockCityKey']."'" : "null" ?>;
var cityNameLocked = "<?php echo $cityName; ?>";
var typeSelected = <?php echo (@$_GET['type']) ? "'".$_GET['type']."'" : "null" ?>;

var filliaireCategories = <?php echo json_encode($filliaireCategories); ?>;

var classified = <?php echo json_encode(CO2::getModuleContextList("classifieds","categories")); ?>;

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
  //allSearchType = [ "persons", "organizations", "projects", "events", "events", "vote", "cities","poi","places","ressources" ];
	topMenuActivated = true;
	hideScrollTop = true; 
  loadingData = false;

	checkScroll();
  var timeoutSearch = setTimeout(function(){ }, 100);
  
  setTimeout(function(){ $("#input-communexion").hide(300); }, 300);

	//setTitle("<span id='main-title-menu'>Moteur de recherche</span>","search","Moteur de recherche");
	
  $('.tooltips').tooltip();

  //setHeaderDirectory(typeSelected);  

  //showTagsScopesMin("#scopeListContainer");

  // if(lockCityKey != null){
  //   lockScopeOnCityKey(lockCityKey, cityNameLocked);
  // }else{
  //   rebuildSearchScopeInput();
  // }


  <?php if(Yii::app()->params["CO2DomainName"] == "terla"){ ?>
      $("#sub-menu-filliaire").addClass("hidden");
  <?php } ?>

  // $(".btn-open-filliaire").click(function(){
  //     if($("#sub-menu-filliaire").hasClass("hidden"))
  //       $("#sub-menu-filliaire").removeClass("hidden");
  //     else{
  //       $("#sub-menu-filliaire").addClass("hidden");
  //       resetMyTags();
  //     }
  // });

  /*$(".btn-select-filliaire").click(function(){
      mylog.log(".btn-select-filliaire");
      var fKey = $(this).data("fkey");
      //myMultiTags = {};
      $.each(filliaireCategories[fKey]["tags"], function(key, tag){
        search.value="#"+tag;
         $("#main-search-bar, #second-search-bar").val(search.value);
     //   addTagToMultitag(tag);
      });
      search
      mylog.log("myMultiTags", myMultiTags);
      
      startSearch(0, indexStepInit, searchCallback);
      KScrollTo("#content-social");
      //bindCommunexionScopeEvents();
      //KScrollTo("#before-section-result");
  });*/
  
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







