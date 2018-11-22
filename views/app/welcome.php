<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "welcome",
                                "themeParams"=>@$params
                            )
                        );
    $cssAnsScriptFiles = array(
     '/assets/css/profilSocial.css',
     '/assets/css/default/directory.css',
        '/assets/css/welcome.css',
    //  '/assets/css/referencement.css'
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl); 

    
  $cssAnsScriptFilesModule = array(
    '/js/default/directory.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
   
?>

<section class="bg-white inline-block pull-left no-padding" id="bg-homepage">

<?php 
    if( @Yii::app()->session['custom']["welcomeTpl"])
        $this->renderPartial( Yii::app()->session["custom"]["welcomeTpl"] );
    else if( @$_GET["city"] || Yii::app()->session['custom']['id'] )
    {
      $city = City::getById( Yii::app()->session['custom']['id'] );
      if(@$city["custom"] && $city["custom"]["bannerTpl"])
        $this->renderPartial( 'eco.views.custom.'.$city["custom"]["bannerTpl"] );
    } 
    else 
        $this->renderPartial( $layoutPath.'home.'.Yii::app()->params["CO2DomainName"], array() );

?>
</section>

<script type="text/javascript" >

var currentCategory = "";

jQuery(document).ready(function() {

    initKInterface({"affixTop":0});
    $("#mainNav").addClass("affix");
    initWelcomeInterface();
    //location.hash = "";
});


function initWelcomeInterface(){

    $("#second-search-bar").addClass("input-global-search");

    $("#main-btn-start-search, .menu-btn-start-search").click(function(){
        startGlobalSearch(0, indexStepGS);
    });

    $("#second-search-bar").keyup(function(e){ console.log("keyup #second-search-bar");
        $("#input-search-map").val($("#second-search-bar").val());
        $("#second-search-xs-bar").val($("#second-search-bar").val());
        if(e.keyCode == 13){
            searchObject.text=$(this).val();
            myScopes.type="open";
            myScopes.open={};
            //urlCtrl.loadByHash("#search");
            startGlobalSearch(0, indexStepGS);
         }
    });
    $("#second-search-xs-bar").keyup(function(e){ console.log("keyup #second-search-bar");
        $("#input-search-map").val($("#second-search-xs-bar").val());
        $("#second-search-bar").val($("#second-search-xs-bar").val());
        if(e.keyCode == 13){
            searchObject.text=$(this).val();
            myScopes.type="open";
            myScopes.open={};
            //urlCtrl.loadByHash("#search");
            startGlobalSearch(0, indexStepGS);
         }
    });
     $("#second-search-bar-addon, #second-search-xs-bar-addon").off().on("click", function(){
        $("#input-search-map").val($("#second-search-bar").val());
        searchObject.text=$("#second-search-bar").val();
        myScopes.type="open";
        myScopes.open={};
            //urlCtrl.loadByHash("#search");
            startGlobalSearch(0, indexStepGS);
    });
    
    $("#input-search-map").off().keyup(function(e){ console.log("keyup #input-search-map");
        $("#second-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            startGlobalSearch(0, indexStepGS);
         }
    });

    $("#menu-map-btn-start-search").off().click(function(){
        startGlobalSearch(0, indexStepGS);
    });

    $("#bg-homepage").mouseenter(function(){
      $(".dropdown-result-global-search").hide();
    });


    $(".tooltips").tooltip();
   
}


</script>