<?php 
    HtmlHelper::registerCssAndScriptsFiles( 
        array(  //'/css/onepage.css',
                '/vendor/colorpicker/js/colorpicker.js',
                '/vendor/colorpicker/css/colorpicker.css',
                '/css/news/index.css',  
                '/css/timeline2.css',
                //'/css/circle.css',    
                '/css/default/directory.css',   
                //'/js/comments.js',
                '/css/profilSocial.css',
                '/css/calendar.css',
        ) , 
    Yii::app()->theme->baseUrl. '/assets');

 $cssAnsScriptFilesModule = array(
    '/js/default/calendar.js',
    '/js/news/index.js',
    '/js/dataHelpers.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $cssAnsScriptFilesTheme = array(
        "/plugins/jquery-cropbox/jquery.cropbox.css",
        "/plugins/jquery-cropbox/jquery.cropbox.js",
        // SHOWDOWN
        '/plugins/showdown/showdown.min.js',
        //MARKDOWN
        '/plugins/to-markdown/to-markdown.js',
        '/plugins/jquery.qrcode/jquery-qrcode.min.js',
        '/plugins/fullcalendar/fullcalendar/fullcalendar.min.js',
        '/plugins/fullcalendar/fullcalendar/fullcalendar.css', 
        '/plugins/fullcalendar/fullcalendar/locale/'.Yii::app()->language.'.js',
        
        
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
    $this->renderPartial("../news/newsAssets");

	HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css') , Yii::app()->theme->baseUrl. '/assets');
	//$cssAnsScriptFilesModule = array('');
	//HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
    
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu

    //le param USEHEADER de params.json sert à afficher ou non le header, 
    //donc normalement pas besoin de faire de IF ici
        $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "page",
                                "dontShowMenu"=>true,
                                "useFilter"=>false) ); 
?>

<div class="col-md-12 col-sm-12 col-xs-12 no-padding social-main-container">
	<div class="" id="onepage">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="central-container">
        </div>
        <div class="col-md-3 col-lg-3 hidden-sm hidden-xs" 
             id="notif-column">
            <?php if(@$element["custom"] && @$element["custom"]["pubTpl"])
                echo $this->renderPartial($element["custom"]["pubTpl"]); ?>
    
        </div>
	</div>
</div>


<script type="text/javascript" >

var type = "<?php echo Person::COLLECTION; ?>";
var id = "<?php echo Yii::app()->session["userId"]; ?>";
var view = "<?php echo @$view; ?>";
var indexStepGS = 20;
var dateLimit = 0;
var isLiveBool=true;
jQuery(document).ready(function() {
    
	initKInterface({"affixTop":0});
	$("#mainNav").addClass("affix");
	initPageInterface();
    loadNewsStream(isLiveBool);
    // var tpl = '<?php //echo @$_GET["tpl"] ? $_GET["tpl"] : "profilSocial"; ?>';
	// getAjax('#onepage' ,baseUrl+'/'+moduleId+"/element/detail/type/"+type+"/id/"+id+"/view/"+view+"?tpl="+tpl,function(){ 
	// 	initPageInterface();
	// },"html");
});
function loadLiveNow () {
    //mylog.log("loadLiveNow1", contextData.address);

    var level = {} ;
    if( notNull(userConnected.address)) {
        mylog.log("loadLiveNow2", userConnected.address);
        if(notNull(userConnected.address.level4)){
            mylog.log("loadLiveNow3", userConnected.address.level4);
            level[userConnected.address.level4] = {id : userConnected.address.level4, type : "level4", name : userConnected.address.level4Name } ;
        } else if(notNull(userConnected.address.level3)){
            level[userConnected.address.level3] = {id : userConnected.address.level3, type : "level3", name : userConnected.address.level3Name } ;
        } else if(notNull(userConnected.address.level2)){
            level[userConnected.address.level2] = {id : userConnected.address.level2, type : "level2", name : userConnected.address.level2Name } ;
        } else if(notNull(userConnected.address.level1)){
            level[userConnected.address.level1] = {id : userConnected.address.level1, type : "level1", name : userConnected.address.level1Name } ;
        }
    }
    mylog.log("loadLiveNow4", level);
    if( jQuery.isEmptyObject(level) ) {
        //alert("Vous n'êtes pas communecté ?");
    } //else{
        var searchParams = {
          "tpl":"/pod/nowList",
          "searchLocality" : level,
          "indexMin" : 0, 
          "indexMax" : 30 
        };

        ajaxPost( "#notif-column", baseUrl+'/'+moduleId+'/element/getdatadetail/type/citoyens/id/'+userId+'/dataName/liveNow?tpl=nowList',
                        searchParams, function() { 
                        bindLBHLinks();
         } , "html" );
    //}
}
function loadNewsStream(isLiveBool){

    KScrollTo("#profil_imgPreview");
    //isLiveNews=isLiveBool;
    isLiveNews = isLiveBool==true ? "/isLive/true" : ""; 
    dateLimit = 0;
    scrollEnd = false;
    loadingData = true;
    toogleNotif(true);

    var url = "news/index/type/citoyens/id/"+userId+isLiveNews+"/date/"+dateLimit+
              "?isFirst=1&tpl=co2&renderPartial=true";
    
    setTimeout(function(){ //attend que le scroll retourn en haut (kscrollto)
        showLoader('#central-container');
        ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
            null,
            function(){ 
                loadLiveNow();
                $(window).bind("scroll",function(){ 
                    if(!loadingData && !scrollEnd && colNotifOpen){
                          var heightWindow = $("html").height() - $("body").height();
                          if( $(this).scrollTop() >= heightWindow - 1000){
                            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep, isLiveBool);
                          }
                    }
                });
                loadingData = false;
        },"html");
    }, 700);
}
var colNotifOpen = true;
function toogleNotif(open){
    if(typeof open == "undefined") open = false;
    
    if(open==false){
        $('#notif-column').removeClass("col-md-3 col-sm-3 col-lg-3").addClass("hidden");
        $('#central-container').removeClass("col-md-9 col-lg-9").addClass("col-md-12 col-lg-12");
    }else{
        $('#notif-column').addClass("col-md-3 col-sm-3 col-lg-3").removeClass("hidden");
        $('#central-container').addClass("col-sm-12 col-md-9 col-lg-9").removeClass("col-md-12 col-lg-12");
    }

    colNotifOpen = open;
}
function initPageInterface(){

	$("#second-search-bar").addClass("input-global-search");

    $("#main-btn-start-search, .menu-btn-start-search").click(function(){
        startGlobalSearch(0, indexStepGS);
    });

    $("#second-search-bar").keyup(function(e){ console.log("keyup #second-search-bar");
        $("#input-search-map").val($("#second-search-bar").val());
        if(e.keyCode == 13){
            searchObject.text=$(this).val();
            myScopes.type="open";
            myScopes.open={};
            urlCtrl.loadByHash("#search");
            //startGlobalSearch(0, indexStepGS);
         }
    });
    
    $("#input-search-map").keyup(function(e){ console.log("keyup #input-search-map");
        $("#second-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            startGlobalSearch(0, indexStepGS);
         }
    });

    $("#menu-map-btn-start-search").click(function(){
        $("#second-search-bar").val($("#input-search-map").val());
        startGlobalSearch(0, indexStepGS);
    });

    $(".social-main-container").mouseenter(function(){
    	$(".dropdown-result-global-search").hide();
    });

    $(".tooltips").tooltip();
   
    $('.sub-menu-social').affix({
      offset: {
          top: 320
      }
    });
    //$(".dropdown-result-global-search").hide();
    

}

</script>