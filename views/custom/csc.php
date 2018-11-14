
<div class="pageContent">


<style type="text/css">
  #customHeader{
    margin-top: 0px;
  }
  #costumBanner{
   /* max-height: 375px; */
  }
  #costumBanner h1{
    position: absolute;
    color: white;
    background-color: rgba(0,0,0,0.4);
    font-size: 29px;
    bottom: 0px;
    padding: 20px;
  }
  #costumBanner h1 span{
    color: #eeeeee;
    font-style: italic;
  }
  #costumBanner img{
    min-width: 100%;
  }
  @media screen and (min-width: 450px) and (max-width: 1024px) {
    .logoDescription{
      width: 60%;
      margin:auto;
    }
  }

  @media (max-width: 1024px){
    #customHeader{
      margin-top: -1px;
    }
  }
  @media (max-width: 768px){

  }
</style>

<div class="col-xs-12 no-padding" id="customHeader" style="background-color: white">
  <div id="costumBanner" class="col-xs-12 col-sm-12 col-md-12 no-padding">
 <!--  <h1>L'entraide<br/><span class="small">Une interface numérique pour échanger</span></h1>-->
    <img class="img-responsive" src='<?php echo Yii::app()->getModule("co2")->assetsUrl ?>/images/custom/csc/logo-banniere.png'> 
  </div>
 <!-- <div class="col-xs-12 col-sm-12 col-md-3 text-center padding-10" >
    <img class="img-responsive logoDescription" src='<?php echo Yii::app()->getModule("eco")->assetsUrl; ?>/images/custom/leport/LOGO.jpg'> 
    <h2>Une ville Dynamique</h2>
    <span style="overflow-y: hidden;max-height: 375px;">
        <span class="col-xs-12 margin-bottom-5">
        <b>Mutualiser</b> les moyens
      </span>
      <span class="col-xs-12 margin-bottom-5">
        <b>Dynamiser le parcours demandeur d'emploi</b> tout en le sécurisant</span><br/>
      <span class="col-xs-12 margin-bottom-5">
        <b>Préparer</b> à l'emploi et <b>réduire</b> la durée
      </span> <br/> 
      <span class="col-xs-12 margin-bottom-5">
        <b>Lever les obstacles à l'emploi</b> : mobilité, garde d'enfant, freins socio économiques
      </span> <br/> 
      <span class="col-xs-12 margin-bottom-5">
        Partir des <b>besoins des entreprises</b> et des <b>compétences attendues</b>
      </span><br/>
      <span class="col-xs-12 margin-bottom-5"><b>
        Développer les compétences</b> transversales et transférables des participants <br/> 
      </span>
    </span>
  </div>
</div>-->
<!--Dynamiser le parcours du participant demandeur d'emploi tout en le sécurisant, pour le préparer à l'emploi (et réduire la durée) <br/> Lever les obstacles à l'emploi : travail sur les freins périphériques (mobilité, garde d'enfant, freins socio économiques). <br/> Une clé d’entrée : partir des besoins des entreprises et des compétences attendues en situation de travail <br/> Une approche : développer les compétences transversales et transférables des participants <br/> Mutualiser les moyens.-->


  <div class="col-md-12 col-lg-12 col-sm-12 imageSection no-padding" 
     style=" position:relative;">

    

    
    <div class="col-sm-12 col-md-12 col-xs-12 no-padding" style="background-color:#fff; max-width:100%; float:left;">
      <div class="col-xs-12 margin-top-50 margin-bottom-25 text-center hidden" >
        <h2 class="text-red text-center">Filiere Numerique</h2>
        <h5 class=" col-xs-12 text-center" style="font-style:italic;">
          <?php echo Yii::t("home","Collective intelligence at service for citizens") ?>
        </h5>
        <br/>
        <h2 class="text-red text-center homestead">1 + 1 = 3</h2>
        <h5 class=" col-xs-12 text-center" style="font-style:italic;">
          Wikipedia <i class="fa fa-plus text-red"></i> Open Street Maps 
          <i class="fa fa-plus  text-red"></i> Open source Society
        </h5>
        <br/>
        <div class="center"  >
          <div  style="position:absolute; transform: rotate(60deg);margin:0 47%;" >
            <img class="img-responsive" width=50 src="<?php echo $this->module->assetsUrl; ?>/images/home/triangle.png" />
          </div>
        </div>
      </div>

      <style>
        .btn-main-menu{
           background: #e6344d !important;
    border-radius: 20px;
    padding: 20px !important;
    color: white !important;
          border:2px solid transparent;
          min-height:100px;
        }
        .btn-main-menu:hover{
          border:2px solid #ccc;
        }
        .ourvalues img{
          height:70px;
        }

        .box-register label.letter-black{
          margin-bottom:3px;
          font-size: 13px;
        }
      </style>

      <div class="col-xs-12 no-padding" style="text-align:center;margin-bottom:24px;margin-top:100px;"> 
        <div class="col-xs-12 no-padding">
          <div class="col-md-12 col-sm-12 col-xs-12 padding-20" style="padding-left:100px;background-color: #f6f6f6; min-height:400px;">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 pull-left padding-20 shadow2" style="margin-top:-100px;margin-bottom:50px;background-color: #fff;font-size: 14px;">
              <div class="col-xs-12 font-montserrat ourvalues" style="text-align:center;">
                        <h3 class="col-xs-12 text-center">
              <i class="fa fa-th"></i> <?php echo Yii::t("home", "Un outil pour s'entraider") ?><br>
              <small>
                <b>Centres sociaux connectés :</b> <?php echo Yii::t("home", "L'innovation au service de la collaboration") ?><br>
                <?php //echo Yii::t("home", "created for citizens actors of change") ?>
              </small>
              <hr style="width:40%; margin:20px auto; border: 4px solid #cecece;">
            </h3>
            <div class="col-xs-12">
                    <a href="javascript:;" data-hash="#annonces?section=offer" class=" btn-main-menu lbh-menu-app col-xs-12 col-sm-6 col-md-4 col-md-offset-2 padding-20 margin-top-5 margin-right-5" data-type="classifieds" >
                        <div class="text-center">
                            <div class="col-md-12 no-padding text-center">
                                <h4 class="no-margin text-white">
                                  <i class="fa fa-search"></i>
                                  <?php echo Yii::t("home","Les offres") ?>
                                    <br><small class="text-white">
                                        <?php echo Yii::t("home","Retrouver toutes les annonces à disposition")?>
                                    </small>
                                </h4>
                            </div>
                        </div>
                    </a>
            <a href="javascript:;" data-hash="#annonces?section=need" class="btn-main-menu lbh-menu-app col-xs-12 col-sm-6 col-md-4 padding-20 margin-top-5" data-type="search" >    
                        <div class="text-center">
                            <!-- <h4 class="text-red no-margin "><i class="fa fa-search"></i>
                                <span class="homestead"> <?php //echo Yii::t("home","SEARCH") ?></span>
                            </h4><br/> -->
                            <div class="col-md-12 no-padding text-center">
                                <h4 class="no-margin text-white">
                                  <i class="fa fa-bullhorn"></i>
                                  <?php echo Yii::t("home","Les besoins") ?>
                                    <br>
                                    <small class="text-white">
                                        <?php echo Yii::t("home","Aider, soutenir, venir en aide") ?>
                                    </small>
                                </h4>
                            </div>
                        </div>
                    </a>
                    </div>
                        <!-- <div class="col-md-1 col-sm-1 hidden-xs"></div> -->
                        <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6" style="text-align:center;">
                          <img class="img-responsive" style="margin:0 auto;" 
                             src="<?php echo Yii::app()->getModule("co2")->assetsUrl ?>/images/custom/csc/logo-arbrisseau.jpg"/>
                             Centre social et culturel de l'Arbrisseau
                        </div>
                        <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                          <a href="#annonces?searchSType=jobs&source=poleEmploi"><img class="img-responsive" style="margin:0 auto;" 
                             src="<?php echo Yii::app()->getModule("co2")->assetsUrl ?>/images/custom/csc/Logo-header-CSCLG.png"/>
                             Centre social et culturel Lazar Garreau</a>
                        </div>
                        <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                          <img class="img-responsive" style="margin:0 auto;" 
                             src="<?php echo Yii::app()->getModule("co2")->assetsUrl ?>/images/custom/csc/lsi.png"/>
                             Lille-Sud Insertion 
                        </div>
                        <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                          <img class="img-responsive" style="margin:0 auto;" 
                             src="<?php echo Yii::app()->getModule("co2")->assetsUrl ?>/images/custom/csc/logo-fabrique-du-sud.png"/>
                             La fabrique du Sud
                        </div> 
                    </div>
                  </div>
            
           
                    
                    



           <!-- <h3 class="text-center col-xs-12">
              <hr style="width:40%; margin:20px auto; border: 4px solid #cecece;">
              <small>
                <?php echo Yii::t("home","Because the need to <b>communicate</b> locally has never been so important"); ?>,<br> 
                <?php echo Yii::t("home","we've made <b>communexion</b> the <b><i>keystone</i></b> of all our applications"); ?>.
                <br><br>
                <a href="#search" target="_blank">
                  <img class="img-responsive shadow2" style="margin:0 auto;margin-top: 0px;border-radius: 5px;" 
                  src="<?php echo $this->module->assetsUrl; ?>/images/home/searchengine.png"/>
                </a>
                <br>
                <?php echo Yii::t("home","The specialty of <b>Communecter</b> is to give you access to the data you are interested in"); ?>,<br>
                <?php echo Yii::t("home","according to the <b>geographical area(s)</b> you selected"); ?>.
                <br>
              </small>

            </h3>




          </div>-->
          <!-- <div class="col-md-6 col-sm-6 col-xs-12 padding-20" style="background-color: #f6f6f6;text-align:center;min-height:400px;">
            <img class="img-responsive" style="margin:0 auto;margin-top: 50px;" src="<?php echo $this->module->assetsUrl; ?>/images/home/modules_screen.png"/>
          </div> -->
        </div>

       <!-- <div class="col-xs-12 no-padding">
                <div class="col-md-12 col-sm-12 col-xs-12" style="background-color: #fff; text-align:center;min-height:400px;">
            <h4 class="margin-top-50"><i class="fa fa-map-marker"></i> <?php echo Yii::t("home","Map") ?></h4>
              <div class="col-md-12 text-center">
                            <h3 class="no-margin">
                              <small>
                                  <?php echo Yii::t("home","Wherever you are on Communecter<br>you can consult informations on the map") ?>.
                    <hr style="width:40%; margin:10px auto; border: 4px solid #cecece;">    
                                    <?php echo Yii::t("home", "Searching results, upcoming events,<br>local initiaves, community members") ?>, etc...
                                </small>
                            </h3>
                        </div>
                        <button class="btn btn-link letter-blue bold margin-top-25 btn-show-map-home">
                          <i class="fa fa-map-marker"></i> <?php echo Yii::t("home","Show map") ?> 
                      </button>

                      <img class="img-responsive shadow2" style="margin:auto; margin-top: 10px;" src="<?php echo $this->module->assetsUrl; ?>/images/home/map2.png"/>

                      <h3>
                            <small>
                              <?php echo Yii::t("home","Our territories are rich with thousands of citizen initiatives, associations, projects, events! <br>It is by weaving close links between these initiatives that we will transform our society sustainably.") ?>
                              <br>
                                <hr style="width:40%; margin:10px auto; border: 4px solid #cecece;">  
                          <?php echo Yii::t("home","That's why <b>Communecter</b> invites you to geo-locate your data as much as possible, <br>to give <b>local visibility</b> to your actions") ?>.
                                <hr style="width:40%; margin:10px auto;">    
                                <?php echo Yii::t("home","This is also <i>geo-communication !</i>") ?><br><br>
                              </small>
                          </h3>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 hidden" style="text-align:center; min-height:400px;">
            <img class="img-responsive" style="margin:auto; margin-top: 10px; max-height:380px;" src="<?php echo $this->module->assetsUrl; ?>/images/home/carto_home.png"/>
          </div>
        </div> -->


        <!--<div class="col-xs-12 no-padding">
          <div class="col-md-12 col-sm-12 col-xs-12 padding-20" style="background-color: #f6f6f6; text-align:center;min-height:400px;">
            <h4 class="margin-top-50"><i class="fa fa-map-marker"></i> <i class="fa fa-newspaper-o"></i> 
              <?php echo Yii::t("home","Are you ready for geo-communication") ?> ?
              <hr style="width:40%; margin:10px auto; border: 4px solid #cecece;">
            </h4>

            <h3 class="text-center col-xs-12 no-margin">-->
              <!-- <hr style="width:40%; margin:10px auto; border: 4px solid #cecece;"> -->
              <!--<small>
                <?php echo Yii::t("home","Imagine a world where your messages can be broadcast") ?><br>
                <b><?php echo Yii::t("home","in a public and geographical way") ?></b>
                <br>...
              </small>

            </h3>

            <img class="img-responsive" style="margin:0 auto;margin-top: 20px;" 
              src="<?php echo $this->module->assetsUrl; ?>/images/home/scopingnews_<?php echo Yii::app()->language; ?>.png"/>

            <h3 class="text-center col-xs-12">
              <small> 
                <?php echo Yii::t("home","Create debates, share information, ask for help,<br> share an idea, propose a project, ask a question") ?>
                <hr style="width:40%; margin:10px auto; border: 4px solid #cecece;">
                <?php echo Yii::t("home","You will find a thousand reasons to use") ?>
                 
                <a href="#live" class="letter-red" target="_blank"><?php echo Yii::t("home","IN LIVE") ?> !</a>
              </small>

            </h3>
                 </div>
        </div>



        <di
      </div>-->
      
    </div>

  

  



<div class="portfolio-modal modal fade" id="modalForgot" tabindex="-1" role="dialog" aria-hidden="true">
    <form class="modal-content form-email box-email padding-top-15"  >
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="name hidden" >
                        <?php if(Yii::app()->params["CO2DomainName"] == "kgougle"){ ?>
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/KGOUGLE-logo.png" height="60" class="inline margin-bottom-15">
                       <?php } else { ?>
                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/CO2r.png" height="100" class="inline margin-bottom-15">
                        <?php } ?>
                    </span>
                    <h4 class="letter-red no-margin" style="margin-top:-5px!important;">Mot de passe oublié ?</h4><br>
                    <hr>
                    <p><small>Indiquez votre addresse e-mail, vous recevrez un e-mail contenant votre mot de passe.</small></p>
                    <hr>
                    
                </div>
            </div>
            <div class="col-md-4 col-md-offset-4 text-left">
                
                <label class="letter-black"><i class="fa fa-envelope"></i> E-mail</label><br>
                <input class="form-control" id="email2" name="email2" type="text" placeholder="E-mail"><br/>
                
                <hr>

                <div class="pull-left form-actions no-margin" style="width:100%; padding:10px;">
                    <div class="errorHandler alert alert-danger no-display registerResult pull-left " style="width:100%;">
                        <i class="fa fa-remove-sign"></i> <?php echo Yii::t("login","You have some form errors. Please check below.") ?>
                    </div>
                </div>

                <!-- <div class="form-actions">
                     <button type="submit"  data-size="s" data-style="expand-right" style="background-color:#E33551" class="forgotBtn ladda-button center center-block">
                        <span class="ladda-label">XXXXXXXX</span><span class="ladda-spinner"></span><span class="ladda-spinner"></span>
                    </button>
                </div> -->

                <a href="javascript:" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo Yii::t("common","Back") ?></a>
                <button class="btn btn-success text-white pull-right forgotBtn"><i class="fa fa-sign-in"></i> Envoyer</button>
                
                
                <div class="col-md-12 margin-top-50 margin-bottom-50"></div>
            </div>      
        </div>
    </form>
</div>


<script type="text/javascript">

<?php $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    $this->renderPartial($layoutPath.'home.peopleTalk'); ?>
var peopleTalkCt = 0;

jQuery(document).ready(function() {
  setTimeout(function(){
    //$("#videoDocsImg img").css({"max-height":$("#form-home-subscribe").outerHeight()});
  },300);
  topMenuActivated = false;
  hideScrollTop = true;
  checkScroll();
  loadLiveNow();
  $(".videoSignal").click(function(){
    openVideo();
  });

  peopleTalkCt = getRandomInt(0,peopleTalk.length);
  showPeopleTalk();


    $("#map-loading-data").hide();
  $(".mainmenu").html($("#modalMainMenu .links-main-menu").html());
  //$("#modalMainMenu .links-main-menu").html("");

  //setTimeout(function(){ $("#input-communexion").hide(300); }, 300);

  var timerCo = false;
      
  $("#main-search-bar").keyup(function(){
    if($("#main-search-bar").val().length > 2){
      if(timerCo != false) clearTimeout(timerCo);
      timerCo = setTimeout(function(){ 
        //$("#info_co").html("");
        $(".info_co").addClass("hidden");
        $("#change_co").addClass("hidden");
        searchType = ["cities"];
        loadingData=false;
        scrollEnd=false;
        totalData = 0;
        communexion.state = false ; 
        startSearch(0, 20);
      }, 500);
    }else{
      $(".info_co").removeClass("hidden");
      $("#dropdown_search").html("");
    }
  });


    $("#change_co").click(function(){
      $(".info_co, .input_co").removeClass("hidden");
    $("#change_co").addClass("hidden");

    });


  setTitle("<?php echo Yii::t("home","Welcome on") ?> <span class='text-red'>commune</span>cter","home","<?php echo Yii::t("home","Welcome on Communecter") ?>");
  $('.tooltips').tooltip();

  $("#btn-param-postal-code").click(function(){
    $("#div-param-postal-code").show(400);
  });

  $(".btn-show-map-home").click(function(){
    search.app="search";
    initCountType();
      initTypeSearch("all");
      $(this).html("<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyloading);
    startSearch(0, 30, function(){
      if(typeof formInMap != "undefined" && formInMap.actived == true)
        formInMap.cancel(true);
        //else if(isMapEnd == false && notEmpty(contextData) && location.hash.indexOf("#page.type."+contextData.type+"."+contextData.id))
      //  getContextDataLinks();
      else{
        if(isMapEnd == false && contextData && contextData.map && location.hash.indexOf("#page.type."+contextData.type+"."+contextData.id) )
          Sig.showMapElements(Sig.map, contextData.map.data, contextData.map.icon, contextData.map.title);
          showMap();
      }
      $(".btn-show-map-home").html("<i class='fa fa-map-marker'></i> "+trad.showmap);
    });
  })
  // $('#searchBarPostalCode').keyup(function(e){
 //        clearTimeout(timeoutSearchHome);
 //        timeoutSearchHome = setTimeout(function(){ startSearch(); }, 800);
 //    });


    $(".explainLink").click(function() {
    showDefinition( $(this).data("id") );
    return false;
  });
    $(".keyword").click(function() {
      $(".keysUsages").hide();
      link = "<br/><a href='javascript:;' class='showUsage homestead yellow'><i class='fa fa-toggle-up' style='color:#fff'></i> Usages</a>";
      $(".keywordExplain").html( $("."+$(this).data("id")).html()+link ).fadeIn(400);
       $(".showUsage").off().on("click",function() { $(".keywordExplain").slideUp(); $(".keysUsages").slideDown();});
    });

    $(".keyword1").click(function() {
      $(".keysKeyWords").hide();
      link = "<br/><a href='javascript:;' class='showKeywords homestead yellow'><i class='fa fa-toggle-up' style='color:#fff'></i> Mots Clefs</a>";
      $(".usageExplain").html( $("."+$(this).data("id")).html()+link ).slideDown();
       $(".showKeywords").off().on("click",function() { $(".usageExplain").slideUp(); $(".keysKeyWords").slideDown();});
    });


    $(".btn-main-menu").mouseenter(function(){ 
        $(".menuSection2").addClass("hidden"); 
        if( $(this).data("type") ) 
            $("."+$(this).data("type")+"Section2").removeClass("hidden");
    }).click(function(e) {  
        e.preventDefault(); 
        $('#modalMainMenu').modal("hide"); 
        mylog.warn("***************************************"); 
        mylog.warn("bindLBHLinks",$(this).attr("href")); 
        mylog.warn("***************************************"); 
        var h = ($(this).data("hash")) ? $(this).data("hash") : $(this).attr("href"); 
        urlCtrl.loadByHash( h ); 
    }); 

    $(".tagSearchBtn").click(function(e) {  
        e.preventDefault(); 
        $('#modalMainMenu').modal("hide"); 
        mylog.warn( ".tagSearchBtn",$(this).data("type"),$(this).data("stype"),$(this).data("tags") ); 

        searchObj.types = $(this).data("type").split(",");
        
        if( $(this).data("stype") )
            searchObj.stype = $(this).data("stype");
        else
            searchObj.tags = $(this).data("tags");
        
        urlCtrl.loadByHash($(this).data("app"));
        urlCtrl.afterLoad = function () {     
            //we have to pass by a variable to set the values         
            searchType = searchObj.types;
        
            if( $(this).data("stype") )
                $('#searchSType').val(searchObj.stype);
            else
                $('#searchTags').val(searchObj.tags);
            startSearch();
            searchObj = {};
        }
    }); 

});
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function showPeopleTalk(step)
{
  // if(!step)
  //  step = 1;
  // peopleTalkCt = peopleTalkCt+step;
  // if( undefined == peopleTalk[ peopleTalkCt ]  )
  //  peopleTalkCt = 0;
  // person = peopleTalk[ peopleTalkCt ];

  var html = "";
  $.each(peopleTalk, function(key, person){
  html += '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 padding-5" style="min-height:430px;max-height:430px;">' +
        '<div class="" style="max-height:240px; overflow:hidden; max-width:100%;">' +
        '<img class="img-responsive img-thumbnail peopleTalkImg" src="'+person.image+'"><br>' +
        '</div>' +
        '<span class="peopleTalkName">'+person.name+'</span><br>' +
        '<span class="peopleTalkProject">'+person.project+'</span><br>' +
        '<span class="peopleTalkComment inline-block">'+person.comment+'</span>' +
      '</div>';
  });

  $("#co-friends").html( html );
  // $(".peopleTalkName").html( person.name );
  // $(".peopleTalkImg").attr("src",person.image);
  // $(".peopleTalkComment").html("<i class='fa fa-quote-left'></i> "+person.comment+"<i class='fa fa-quote-right'></i> ");
  // $(".peopleTalkProject").html( "<a target='_blank' href='"+person.url+"'>"+person.project+"</a>" );

}

function openVideo(){
  $("#videoDocsImg").fadeOut("slow",function() {
    heightCont=$("#form-home-subscribe").outerHeight();
    $(".videoWrapper").height(heightCont);
    $(".videoWrapper").fadeIn('slow');
     var symbol = $("#autoPlayVideo")[0].src.indexOf("?") > -1 ? "&" : "?";
      //modify source to autoplay and start video
      $("#autoPlayVideo")[0].src += symbol + "autoplay=1";
      if($("#form-home-subscribe").length)
        $(".videoWrapper .h_iframe").css({"margin-top": ((heightCont-$(".videoWrapper .h_iframe").height())/2)+"px"});
  });
}

var timeoutSearchHome = null;

function showTagOnMap (tag) {

  mylog.log("showTagOnMap",tag);

  var data = {   "name" : tag,
           "locality" : "",
           "searchType" : [ "persons" ],
           //"searchBy" : "INSEE",
                 "indexMin" : 0,
                 "indexMax" : 500
                };

        //setTitle("","");$(".moduleLabel").html("<i class='fa fa-spin fa-circle-o-notch'></i> Les acteurs locaux : <span class='text-red'>" + cityNameCommunexion + ", " + cpCommunexion + "</span>");

    $.blockUI({
      message : "<h1 class='homestead text-red'><i class='fa fa-spin fa-circle-o-notch'></i> Recherches des collaborateurs ...</h1>"
    });

    showMap(true);

    $.ajax({
        type: "POST",
            url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
            data: data,
            dataType: "json",
            error: function (data){
               mylog.log("error"); mylog.dir(data);
            },
            success: function(data){
              if(!data){ toastr.error(data.content); }
              else{
                mylog.dir(data);
                Sig.showMapElements(Sig.map, data);
                $.unblockUI();
              }
            }
    });

  //loadByHash('#project.detail.id.56c1a474f6ca47a8378b45ef',null,true);
  //Sig.showFilterOnMap(tag);
}



function loadLiveNow () {
  mylog.log("loadLiveNow CO2.php");
  var searchParams = {
    "tpl":"/pod/nowList",
    "searchLocalityCITYKEY" : new Array(""),
    "indexMin" : 0, 
    "indexMax" : 30 
  };

    //console.log("communexion : ", communexion);
  if($("#searchLocalityCITYKEY").val() != ""){
    searchParams.searchLocalityCITYKEY = new Array($("#searchLocalityCITYKEY").val());
  }else if(myScopes.communexion.values != null){
    if(typeof myScopes.communexion.values.cityKey != "undefined"){
      searchParams.searchLocalityCITYKEY = new Array(myScopes.communexion.values.cityKey);
    }
  }

  var searchParams = {
    "tpl":"/pod/nowList",
    "searchLocality" : getSearchLocalityObject(true),
    "indexMin" : 0, 
    "indexMax" : 30 
  };
    
    //console.log("communexion ?", communexion);

    ajaxPost( "#nowList", baseUrl+'/'+moduleId+'/element/getdatadetail/type/0/id/0/dataName/liveNow?tpl=nowList',
          searchParams, function(data) {
          bindLBHLinks();
  } , "html" );
}


</script>





