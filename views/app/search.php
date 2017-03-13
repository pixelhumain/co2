<?php 
	//HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , Yii::app()->theme->baseUrl. '/assets');
	//$cssAnsScriptFilesModule = array('');
	//HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

    $params = CO2::getThemeParams();

    $page = "search";

    if(!@$type){  $type = "all"; }

    if(@$type=="events")    { $page = "agenda"; }
    if(@$type=="classified"){ $page = "annonces"; }
    if(@$type=="vote")      { $page = "power"; }

    if(@$type=="cities")    { $lblCreate = ""; }

    if($params["title"] == "kgougle") $page = "social";
    
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                            array(  "layoutPath"=>$layoutPath ,
                                    "page" => $page,
                                    "type" => @$type) ); 
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
</style>


<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding shadow" id="content-social" style="min-height:700px;">

    <?php if(@$type!="cities"){ ?>
        <div class="col-md-2 col-sm-2 col-xs-12 no-padding">
            <?php if(@$type=="all"){ ?>
            <button class="btn btn-default letter-<?php echo @$params["pages"]["#".$page]["colorBtnCreate"]; ?> hidden-xs btn-menu-left-add pull-right margin-top-25 main-btn-create tooltips"
                    data-target="#dash-create-modal" data-toggle="modal"
                    data-toggle="tooltip" data-placement="top" 
                    title="<?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>">
                <i class="fa fa-plus-circle"></i> <?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>
            </button>
            <?php }else{ ?>
            <button class="btn btn-default letter-<?php echo @$params["pages"]["#".$page]["colorBtnCreate"]; ?> hidden-xs btn-menu-left-add pull-right margin-top-25 main-btn-create tooltips" data-type="<?php echo @$type; ?>"
                    data-toggle="tooltip" data-placement="top" 
                    title="<?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>">
                <i class="fa fa-plus-circle"></i> <?php echo @$params["pages"]["#".$page]["lblBtnCreate"]; ?>
            </button>
            <?php } ?>

        </div>

        <div class="col-md-10 col-sm-10 col-xs-12 padding-5">
        <?php
            $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); 
        ?>
        </div>
    <?php } ?>

	<div class="col-md-12 col-sm-12 col-xs-12 padding-5" id="page"></div>

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
            </small>
        </h5><br>
    </div>

</div>


<div class="portfolio-modal modal fade" id="dash-create-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content padding-top-15">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/CO2r.png" height="50" class="inline margin-top-25 margin-bottom-5"><br>
                    
                    <h3 class="letter-red no-margin hidden-xs">
                        <small class="text-dark">Un réseau social <span class="letter-red">citoyen</span>, au service du <span class="letter-red">bien commun</span></small>
                    </h3><br>
                    <h3 class="letter-red no-margin hidden-xs">
                        <i class="fa fa-plus-circle"></i> Créer une page<br>
                    </h3>
                   <!-- <hr> -->
                </div>               
            </div>
            <div class="row links-create-element">
                <div class="col-lg-12">
                    <div class="modal-header text-dark">
                       <label class="label label-lg bg-green-k padding-5"><i class="fa fa-check"></i> Partage de messages</label> 
                       <label class="label label-lg bg-green-k padding-5"><i class="fa fa-check"></i> Partage d'événements</label> 
                       <label class="label label-lg bg-green-k padding-5"><i class="fa fa-check"></i> Gestion de contacts</label>  
                       <label class="label label-lg bg-green-k padding-5"><i class="fa fa-check"></i> Messagerie privées</label>  
                       <label class="label label-lg bg-green-k padding-5"><i class="fa fa-check"></i> Notifications</label> 
                    </div>
                    
                    <div id="" class="modal-body">
                        <div class="col-md-12 hidden">
                            
                        </div>
                         <h4 class="modal-title text-center hidden">
                            Choisissez le type de page qui vous correspond le mieux
                            <hr>
                        </h4>
                        <a href="javascript:" class="btn-create-elem col-lg-6 col-sm-6 col-xs-6" data-ktype="NGO" data-type="organization"
                            date-target="#modalMainMenu" data-dismiss="modal">
                            <div class="modal-body text-left">
                                <h2 class="text-green"><i class="fa fa-group padding-bottom-10"></i><br>
                                    <span class="font-light"> Association</span>
                                </h2>
                                
                                <div class="col-md-12 no-padding text-center hidden-xs">
                                    <h5>Resserrer les liens du tissu associatif
                                        <small class="hidden-xs" style="text-transform: none;"><br>
                                            Le monde associatif est basé sur l'entraide et la solidarité.<br>
                                            Plus que jamais, les associations ont besoin de se relier entre-elles,<br> 
                                            pour faire plus et mieux, ensemble.
                                        </small>
                                    </h5>
                                    <button class="btn btn-default text-green margin-bottom-15"><i class="fa fa-plus-circle"></i> Créer ma page</button>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:" class="btn-create-elem col-lg-6 col-sm-6 col-xs-6" data-ktype="LocalBusiness" data-type="organization"
                            date-target="#modalMainMenu" data-dismiss="modal">
                            <div class="modal-body text-left">
                                <h2 class="text-azure"><i class="fa fa-industry padding-bottom-10"></i><br>
                                    <span class="font-light"> Entreprise</span>
                                </h2>
                                
                                <div class="col-md-12 no-padding text-center hidden-xs">
                                    <h5>Dynamiser le monde de l'entreprise
                                        <small class="hidden-xs" style="text-transform: none;"><br>
                                            Rester connecté à vos contacts, vos clients, vos employés, vos fournisseurs...<br>
                                            Le réseau vous apportera une visibilité incomparable<br>
                                            auprès de ceux qui vivent près de vous.
                                        </small>
                                    </h5>
                                    <button class="btn btn-default text-azure margin-bottom-15"><i class="fa fa-plus-circle"></i> Créer ma page</button>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:" class="btn-create-elem col-lg-6 col-sm-6 col-xs-6" data-ktype="Group" data-type="organization"
                            date-target="#modalMainMenu" data-dismiss="modal">
                            <div class="modal-body text-left">
                                <h2 class="text-turq"><i class="fa fa-circle-o padding-bottom-10"></i><br>
                                    <span class="font-light"> Groupe</span>
                                </h2>
                                
                                <div class="col-md-12 no-padding text-center hidden-xs">
                                    <h5>Mettre en valeur les liens humains
                                        <small class="hidden-xs" style="text-transform: none;"><br>
                                            La vie c'est des rencontres, des amitiés, des liens qui nous unissent<br>
                                            à travers nos activités, nos centres d'intérêts, nos plaisirs.<br>
                                            Les vivres c'est bien, les partager c'est encore mieux !
                                        </small>
                                    </h5>
                                    <button class="btn btn-default text-turq margin-bottom-15"><i class="fa fa-plus-circle"></i> Créer ma page</button>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:" class="btn-create-elem col-lg-6 col-sm-6 col-xs-6" data-ktype="project" data-type="project"
                            date-target="#modalMainMenu" data-dismiss="modal">
                            <div class="modal-body text-left">
                                <h2 class="text-purple"><i class="fa fa-lightbulb-o padding-bottom-10"></i><br>
                                    <span class="font-light"> Projet</span>
                                </h2>
                                
                                <div class="col-md-12 no-padding text-center hidden-xs">
                                    <h5>Ce sont les petites initiatives<br>qui donnent naissance aux projets hors du commun
                                        <small class="hidden-xs" style="text-transform: none;"><br>
                                            N'hésitez jamais à faire connaître vos envies, vos projets, vos rêves.<br>
                                            C'est comme ça qu'ils grandissent !
                                        </small>
                                    </h5>
                                    <button class="btn btn-default text-purple margin-bottom-15"><i class="fa fa-plus-circle"></i> Créer ma page</button>
                                </div>
                            </div>
                        </a>

                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <hr>
                            <a href="javascript:" style="font-size: 13px;" type="button" class="" data-dismiss="modal"><i class="fa fa-times"></i> Retour</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>$page)); ?>



<script type="text/javascript" >

var type = "<?php echo @$type ? $type : 'all'; ?>";
var typeInit = "<?php echo @$type ? $type : 'all'; ?>";
var page = "<?php echo @$page; ?>";

//var TPL = "kgougle";

//allSearchType = ["persons", "NGO", "LocalBusiness", "projects", "Group"];

var currentKFormType = "";

jQuery(document).ready(function() {

	initKInterface({"affixTop":350});
    
    var typeUrl = "?nopreload=true";
    if(type!='') typeUrl = "?type="+type+"&nopreload=true";
	getAjax('#page' ,baseUrl+'/'+moduleId+"/default/directoryjs"+typeUrl,function(){ 

        
        $(".btn-directory-type").click(function(){
            var typeD = $(this).data("type");

            initTypeSearch(typeD);

            setHeaderDirectory(typeD);
            loadingData = false;
            startSearch(0, indexStepInit, searchCallback);
            KScrollTo("#content-social");
        });

        $(".btn-open-filliaire").click(function(){
            KScrollTo("#content-social");
        });
         
        <?php if(@$type == "classified"){ ?>
            initFreedomInterface();
        <?php } ?>

        loadingData = false; 
        initTypeSearch(type);
        startSearch(0, indexStepInit, searchCallback);

    },"html");

    /*$("#main-btn-start-search, .menu-btn-start-search").off().click(function(){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            KScrollTo("#content-social");
    });*/

    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            KScrollTo("#content-social");
        }
    });
    $("#main-search-bar").change(function(){
        $("#second-search-bar").val($(this).val());
    });

    $("#second-search-bar").keyup(function(e){
        $("#main-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
            KScrollTo("#content-social");
         }
    });

    $("#input-search-map").keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        $("#main-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            initTypeSearch(typeInit);
            startSearch(0, indexStepInit, searchCallback);
         }
    });

    $("#menu-map-btn-start-search").click(function(){
        initTypeSearch(typeInit);
        startSearch(0, indexStepInit, searchCallback);
    });



    $(".btn-create-elem").click(function(){
        currentKFormType = $(this).data("ktype");
        var type = $(this).data("type");
        setTimeout(function(){
                    elementLib.openForm(type);
                 },500);
        
    });

    $(".main-btn-create").click(function(){
        currentKFormType = $(this).data("ktype");
        var type = $(this).data("type");
        if(type=="events") type="event";
        if(type=="vote") type="entry";
        elementLib.openForm(type);
    });

    $(".btn-decommunecter").click(function(){
        activateGlobalCommunexion(false);
    });


      $(window).bind("scroll",function(){ mylog("test scroll");
        if(!loadingData && !scrollEnd){
              var heightWindow = $("html").height() - $("body").height();
              if( $(this).scrollTop() >= heightWindow - 400){
                startSearch(currentIndexMin+indexStep, currentIndexMax+indexStep, searchCallback);
              }
        }
    });


    $(".tooltips").tooltip();

    //currentKFormType = "Group";
    //elementLib.openForm ("organization");
});


function initTypeSearch(typeInit){
    //var defaultType = $("#main-btn-start-search").data("type");

    if(typeInit == "all") {
        searchType = ["persons", "organizations", "projects"];
        if($('#main-search-bar').val() != "") searchType.push("cities");

        indexStepInit = 30;
    }
    else{
        searchType = [ typeInit ];
        indexStepInit = 100;
    }
}

<?php 
    if(@$type == "classified"){
    $freedomSections = CO2::getContextList("freedomSections");
?>
var freedomCategories = <?php echo json_encode($freedomSections); ?>
<?php } ?>

function initFreedomInterface(){
    $(".btn-select-type-anc").click(function(){

      $(".btn-select-type-anc").removeClass("active");
      $(this).addClass("active");

      var typeAnc = $(this).data("type-anc");
      if(typeAnc == "forsale" || typeAnc == "location" || typeAnc == "donation" || 
        typeAnc == "sharing" || typeAnc == "lookingfor"){
        $(".subsub").show(300);
      }else{
        $(".subsub").hide(300);
      }

      if(typeof freedomCategories[typeAnc] != "undefined")
            $(".label-category").html("<i class='fa fa-"+ freedomCategories[typeAnc]["icon"] + "'></i> " + freedomCategories[typeAnc]["label"]);
            $(".label-category").removeClass("letter-blue letter-red letter-green letter-yellow").addClass("letter-"+freedomCategories[typeAnc]["color"])
            $(".fa-title-list").removeClass("hidden");
            KScrollTo(".top-page");
    });

    $(".btn-select-category-1").click(function(){
        $(".btn-select-category-1").removeClass("active");
        $(this).addClass("active");

        var keycat = $(this).data("keycat");
        $(".keycat").addClass("hidden");
        $(".keycat-"+keycat).removeClass("hidden");     
    });

    $(".keycat").click(function(){
        $(".keycat").removeClass("active");
        $(this).addClass("active");
    });

    $("#btn-create-classified").click(function(){
         elementLib.openForm('classified');
    });

    initFormImages();

    //loadLiveNow();
}

</script>