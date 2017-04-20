<?php
$cs = Yii::app()->getClientScript();
//HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->request->baseUrl);

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header',
          array( "layoutPath"=>$layoutPath, 
            "page" => "thing") ); 

//tu auras "states":true si ta communexion est activée
//pour récupérer les valeurs de communexion tu a juste à faire ça : CO2::getCommunexionCookies();
$boardIds = Thing::getDistinctBoardId();
$deviceIds= Thing::getDistinctDeviceId();

$communexion = CO2::getCommunexionCookies();
        if($communexion["state"] == false){

        }else{

        }

?>
<style>

.main-container{
  margin-top: 40px;
  padding-top: 40px;

}
#sub-menu-left{
    margin-top:1px;
    /*text-align: left;*/
}
#sub-menu-left .btn{
    /*background-color: #4285f4;
    border-color: #4285f4;*/
  /*color:white;*/
    /*border-radius:80px;*/
    font-weight: 700;
}
#sub-menu-left.subsub .btn{
  width:95%;    
  text-align: left;
  background-color: white;
    border-color: white;
  color:#4285f4;
}
#sub-menu-left.subsub{
  min-width: 180px;
}
#page #dropdown_thing{
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
.keycat:hover,
.keycat.active,
.btn-select-category-1:hover,
.btn-select-category-1.active{
  background-color: #2C3E50!important;
    color: #fff!important;
    border-color:transparent!important;
}


</style>

<div class="col-md-12 col-sm-12 col-xs-12 container bg-white no-padding shadow" id="content-thing" style="min-height:700px;">


 <div class="col-md-12 col-sm-12 col-xs-12 padding-5" id="page">
  <div class="col-lg-2 col-sm-3 col-xs-8 margin-top-15 text-right subsub thingFilters" id="sub-menu-left">
    <h4 class="margin-top-5 padding-bottom-10 letter-azure label-category" id="title-sub-menu-category">
              <i class="fa fa-object-group"></i> Objets CO2
    </h4>
    <hr>
    <?php 
     $thing = CO2::getContextList("thing");
     foreach ($thing as $key1 => $filters) {
      if(strpos($key1,"Filters")!=false){
        if (is_array($filters)) {
        foreach ($filters as $key => $action) { 
        //$setbutton=false;
        if(!isset($action["forAdmin"]) || (isset($action["forAdmin"])&& $action["forAdmin"]=="true" &&  Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ) ){ 
          $setbutton=true;
        } 
        else {$setbutton=false;}
        if (is_array($action) && $setbutton==true){ ?>
         <button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1 " style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
          <i class="fa fa-<?php echo @$action["icon"]; ?> hidden-xs"></i> <?php echo $key; ?>
         </button><br>
         <?php foreach ($action["subcat"] as $key2 => $action2) { ?>
          <button class="btn btn-default text-dark margin-bottom-5 margin-left-15 hidden keycat keycat-<?php echo $key; ?>" data-categ="<?php echo $key; ?>" data-keycat="<?php echo $action2; ?>">
           <i class="fa fa-angle-right"></i> <?php echo $action2; ?>
          </button><br class="hidden">
         <?php } 
        } 
        }
       } 
       }
       }
    ?>
  </div>
  <div id="menu-section-thing" class="col-lg-10 col-md-9 col-sm-9 col-xs-12 text-center subsub">
    <?php 
      $currentSection = 1;
      foreach ($thing["sections"] as $key => $section) { ?>
        <div class="col-md-3 col-sm-4 col-xs-6 no-padding">
        <button class="btn btn-default col-md-12 col-sm-12 padding-10 bold text-dark elipsis btn-select-type-anc" 
          data-type-anc="<?php echo @$section["label"]; ?>" data-key="<?php echo @$section["key"]; ?>"       data-type="thing"
          style="border-radius:0px; border-color: transparent; text-transform: uppercase;">
          <i class="fa fa-<?php echo @$section["icon"]; ?> fa-2x hidden-xs"></i> <?php echo @$section["label"]; ?>
        </button>
        </div>
    <?php } ?>
    <hr class="col-md-12 col-sm-12 col-xs-12 no-padding" id="before-section-result">
  </div>
  <div class="col-sm-10" id="dropdown_thing"></div>
 
 </div>    
</div>


<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?>

<script>

  jQuery(document).ready(function() {
    initKInterface({"affixTop":0});


    /*----------------------------- */
var section = "";
var classType = "";
var classSubType = "";
/*function initClassifiedInterface(){ return;
    classified.currentLeftFilters = null;
    $('#menu-section-'+typeInit).removeClass("hidden");
    $("#btn-create-classified").click(function(){
         elementLib.openForm('classified');
    });    
}*/

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

        if( sectionKey == "smartCitizen"){
          //$(".btn-select-category-1[data-categ= ]");
            
            KScrollTo("#dropdown_thing");
        }
        else {
            $("#section-price").hide();
            $("#priceMin").val("");
            $("#priceMax").val("");
            KScrollTo("#dropdown_thing");
        }

        /*
        if( sectionKey == "forsale" || sectionKey == "forrent" || sectionKey == "location" || sectionKey == "donation" || 
            sectionKey == "sharing" || sectionKey == "lookingfor" || sectionKey == "job" || sectionKey == "all" ){
            //$(".subsub").show(300);
            $('#searchTags').val(section);
            //KScrollTo("#section-price");
            startSearch(0, indexStepInit, searchCallback); 
        } */
        /*if( jsonHelper.notNull("classified.sections."+sectionKey+".filters") ){
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
        }*/
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
         elementLib.openForm('classified');
    });

    $("#priceMin").filter_input({regex:'[0-9]'}); //[a-zA-Z0-9_] 
    $("#priceMax").filter_input({regex:'[0-9]'}); //[a-zA-Z0-9_] 

    $('#main-search-bar, #second-search-bar, #input-search-map').filter_input({regex:'[^@\"\`/\(|\)/\\\\]'}); //[a-zA-Z0-9_] 

 }


/* -------------------------*/
  
    setTitle("Objets communectés","fa-database");
    //console.log("Thing : page index");
  
   //Index.init();

   //getAjax('#central-container' ,baseUrl+'/'+moduleId+"/app/superadmin/action/main",function(){//todo des trucs },"html"); 
  });

</script>