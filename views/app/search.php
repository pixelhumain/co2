<?php 

    $cssAnsScriptFilesModule = array(
    '/assets/css/default/responsive-calendar.css',
    '/assets/css/default/search.css',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

    $cssAnsScriptFilesModule = array(
    '/js/default/responsive-calendar.js',
    '/js/default/search.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

    $params = CO2::getThemeParams();

    $page = "search";
    if(!@$type){  $type = "all"; }

    if(@$type=="events")    { $page = "agenda"; }
    if(@$type=="classified"){ $page = "annonces"; }
    if(@$type=="vote")      { $page = "power"; }
    if(@$type=="place")     { $page = "place"; }

    if(@$type=="cities")    { $lblCreate = ""; }

    if($params["title"] == "Kgougle") {
        $page = "social";
        if(@$type=="classified"){ $page = "freedom"; }
        if(@$type=="events"){ $page = "agenda"; }
    }

    //header + menu
    $this->renderPartial($layoutPath.'header', 
                            array(  "layoutPath"=>$layoutPath ,
                                    "page" => $page,
                                    "type" => @$type) ); 
?>

<style>
    
</style>


<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding shadow pageContent" id="content-social" style="min-height:700px;">

    <?php if(@$type=="events"){ ?>
    <div class="col-md-12 no-padding calendar"></div>
    <div class="responsive-calendar-init hidden"> 
      <div class="responsive-calendar light col-md-12 no-padding">   
          <div class="day-headers">
            <div class="day header">Lun</div>
            <div class="day header">Mar</div>
            <div class="day header">Mer</div>
            <div class="day header">Jeu</div>
            <div class="day header">Ven</div>
            <div class="day header">Sam</div>
            <div class="day header">Dim</div>
          </div>
          <div class="days" data-group="days"></div>   
          <div class="controls">
              <a id="btn-month-before" class="text-white" data-go="prev"><div class="btn"><i class="fa fa-arrow-left"></i></div></a>
              <h4 class="text-white"><span data-head-month></span> <span data-head-year></span></h4>
              <a id="btn-month-next" class="text-white" data-go="next"><div class="btn"><i class="fa fa-arrow-right"></i></div></a>
          </div>
      </div>
    </div>
    <?php } ?>

    <?php if(@$type!="cities"){ ?>
        <div class="col-md-2 col-sm-2 col-xs-12 no-padding">
            <?php if(@$type=="all"){ ?>
            <button class="btn btn-default letter-<?php echo @$params["pages"]["#".$page]["colorBtnCreate"]; ?> hidden-xs btn-menu-left-add pull-right margin-top-25 main-btn-create tooltips"
                    data-target="#dash-create-modal" data-toggle="modal"
                    data-toggle="tooltip" data-placement="top" 
                    title="<?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>">
                <i class="fa fa-plus-circle"></i> <?php echo Yii::t("common",@$params["pages"]["#".$page]["lblBtnCreate"]); ?>
            </button>
            <?php }else{ ?>
            <button class="btn btn-default letter-<?php echo @$params["pages"]["#".$page]["colorBtnCreate"]; ?> hidden-xs btn-menu-left-add pull-right margin-top-25 main-btn-create tooltips" data-type="<?php echo @$type; ?>"
                    data-toggle="tooltip" data-placement="top" 
                    title="<?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>">
                <i class="fa fa-plus-circle"></i> <?php echo Yii::t("common",@$params["pages"]["#".$page]["lblBtnCreate"]); ?>
            </button>
            <?php } ?>

        </div>

        <?php //var_dump(Yii::app()->request->cookies['communexionActivated']);
              //var_dump(CO2::getCommunexionCookies()); 
        ?>

        <div id="container-scope-filter"  class="col-md-10 col-sm-10 col-xs-12 padding-5">
            <?php $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); ?>
        </div>
    <?php } ?>


	<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="page"></div>

    <?php if(@$type=="all" && !empty(Yii::app()->session["userId"]) ){ ?>
    <div class="col-md-12 col-sm-12 col-xs-12 padding-5 text-center">
        <!-- <hr style="margin-bottom:-20px;"> -->
        <button class="btn btn-default btn-circle-1 btn-create-page bg-green-k text-white tooltips" 
            data-target="#dash-create-modal" data-toggle="modal"
            data-toggle="tooltip" data-placement="top" 
            title="Créer une nouvelle page">
                <i class="fa fa-times" style="font-size:18px;"></i>
        </button>
        <h5 class="text-center letter-green margin-top-25">Créer une page</h5>
        <h5 class="text-center">
            <small>             
                <span class="text-green">associations</span> 
                <span class="text-azure">entreprises</span> 
                <span class="text-purple">projets</span> 
                <span class="text-turq">groupes</span>
                <span class="text-red">service public</span>
            </small>
        </h5><br>
    </div>
    <?php } ?>

</div>


<?php $this->renderPartial($layoutPath.'modals.'.Yii::app()->params["CO2DomainName"].'.pageCreate', array()); ?>
<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array()); ?>

<?php //$this->renderPartial($layoutPath.'footer', array("subdomain"=>$page)); ?>



<script type="text/javascript" >

var type = "<?php echo @$type ? $type : 'all'; ?>";
var typeInit = "<?php echo @$type ? $type : 'all'; ?>";
var page = "<?php echo @$page; ?>";
var titlePage = "<?php echo Yii::t("common",@$params["pages"]["#".$page]["subdomainName"]); ?>";

//var TPL = "kgougle";

//allSearchType = ["persons", "NGO", "LocalBusiness", "projects", "Group"];

var currentKFormType = "";

jQuery(document).ready(function() {

    setTitle("", "", titlePage);

    initKInterface({"affixTop":320});
    
    var typeUrl = "?nopreload=true";
    if(type!='') typeUrl = "?type="+type+"&nopreload=true";
	getAjax('#page' ,baseUrl+'/'+moduleId+"/default/directoryjs"+typeUrl,function(){ 

        $(".btn-directory-type").click(function(){
            var typeD = $(this).data("type");

            if(typeD == "events"){
                var typeEvent = $(this).data("type-event");
                searchSType = typeEvent;
            }

            initTypeSearch(typeD);
            mylog.log("search.php",searchType);
            setHeaderDirectory(typeD);
            loadingData = false;
            startSearch(0, indexStepInit, searchCallback);
            KScrollTo("#content-social");

            $(".btn-directory-type").removeClass("active");
            $(this).addClass("active");
        });

        $(".btn-open-filliaire").click(function(){
            KScrollTo("#content-social");
        });
         
         //anny double section filter directory
        <?php if(@$type == "classified" || @$type == "place"  ){ ?>
            initClassifiedInterface();
        <?php } ?>

        bindLeftMenuFilters();

        //console.log("init Scroll");
        $(window).bind("scroll",function(){  
            mylog.log("test scroll", scrollEnd);
            if(!loadingData && !scrollEnd && !isMapEnd){
                  var heightWindow = $("html").height() - $("body").height();
                  if( $(this).scrollTop() >= heightWindow - 400){
                    startSearch(currentIndexMin+indexStep, currentIndexMax+indexStep, searchCallback);
                  }
            }
        });


        loadingData = false; 
        initTypeSearch(type);
        startSearch(0, indexStepInit, searchCallback);

    },"html");

    initSearchInterface(); //themes/co2/assets/js/default/search.js

    
    if(page == "annonces" || page == "agenda" || page == "power"){
        setTimeout(function(){
            KScrollTo("#content-social");  
        }, 1000);
    }
    $(".tooltips").tooltip();
});


/* -------------------------
AGENDA
----------------------------- */

<?php if(@$type == "events"){ ?>

var calendarInit = false;
function showResultInCalendar(mapElements){
    //mylog.dir(mapElements);

    var events = new Array();
    $.each(mapElements, function(key, thisEvent){
    
        var startDate = exists(thisEvent["startDateTime"]) ? thisEvent["startDateTime"].substr(0, 10) : "";
        var endDate = exists(thisEvent["endDateTime"]) ? thisEvent["endDateTime"].substr(0, 10) : "";
        var cp = "";
        var loc = "";
        if(thisEvent["address"] != null){
            var cp = exists(thisEvent["address"]["postalCode"]) ? thisEvent["address"]["postalCode"] : "" ;
            var loc = exists(thisEvent["address"]["addressLocality"]) ? thisEvent["address"]["addressLocality"] : "";
        }
        var position = cp + " " + loc;

        var name = exists(thisEvent["name"]) ? thisEvent["name"] : "";
        var thumb_url = notEmpty(thisEvent["profilThumbImageUrl"]) ? baseUrl+thisEvent["profilThumbImageUrl"] : "";
        
        if(typeof events[startDate] == "undefined") events[startDate] = new Array();
        events[startDate].push({  "id" : thisEvent["_id"]["$id"],
                                  "thumb_url" : thumb_url, 
                                  "startDate": startDate,
                                  "endDate": endDate,
                                  "name" : name,
                                  "position" : position });
    });

    if(calendarInit == true) {
        $(".calendar").html("");
    }

    $(".calendar").html($(".responsive-calendar-init").html());

    var aujourdhui = new Date();
    var  month = (aujourdhui.getMonth()+1).toString();
    if(aujourdhui.getMonth() < 10) month = "0" + month;
    var date = aujourdhui.getFullYear().toString() + "-" + month;

    $(".responsive-calendar").responsiveCalendar({
          time: date,
          events: events
        });

    $(".responsive-calendar").show();

    calendarInit = true;
}

<?php } ?>

/* -------------------------
END AGENDA
----------------------------- */

</script>