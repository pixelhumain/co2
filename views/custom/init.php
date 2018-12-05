<?php  

//init will always be exeecuted in a JS document ready

if( @$_GET["el"] || @$custom )
{ 
    $stum = (@$custom) ?  explode(".",  $custom ) : explode(".",  $_GET["el"] );
    $el = null;
    $c = null;
    if($stum[0]=="city") {
        $el = City::getByInsee($stum[1]);
        $c = array( "id"   => (string) $el["_id"],
                                               "type" => City::COLLECTION,
                                               "url" => "/custom?el=".$_GET["el"],
                                               "title"=> "Le port"
                                        );
        if(@$el["custom"])
            $c = array_merge( $c , $el["custom"] );

        if(@$el["custom"]["logo"]) {
            $el["custom"]["logo"]= Yii::app()->getModule("eco")->getAssetsUrl(true).$el["custom"]["logo"];
        
            $c["logo"] = substr($el["custom"]["logo"], strpos($el["custom"]["logo"], '/assets'), strlen($el["custom"]["logo"]));
        }
    }
    else if( @$stum[1] == "cte" ){
        $el = PHDB::findOne( $stum[0], array("id"=>$stum[1]) );
        $c = array( 
            "id"   => (string) $el["_id"],
            "type" => Form::COLLECTION,
            "url" => "/survey/co/index/id/cte",
            "title"=> $el["title"] );
        if(@$el["custom"])
            $c = array_merge( $c , $el["custom"] );

        if(@$el["custom"]["logo"])
            $c["logo"]=Yii::app()->getModule("survey")->getAssetsUrl(true).$el["custom"]["logo"];
    }
    else if( @$stum[0] == "costum" ){
        $c = $el;
    }
    else {
        if($stum[0] == "o")
            $stum[0] = Organization::COLLECTION;
        if($stum[0] == "p")
            $stum[0] = Project::COLLECTION;
        
        if( empty($stum[0]) && empty($stum[1])){
            throw new CTKException("Cannot get Ellement : check type, ID or Slug");
        }
        
        //soit on a un ID soit un slug
        if (is_string($stum[1]) && strlen($stum[1]) == 24 && ctype_xdigit($stum[1]) )
            $el = Element::getByTypeAndId( $stum[0] , $stum[1] );
        else 
            $el = Slug::getElementBySlug( $stum[1] )["el"];
        
        $c = array( "id"   => (string) $el["_id"],
                   "type" => $stum[0],
                   "title"=> $el["name"],
                   "assetsUrl"=> (@$el["custom"]["module"]) ? Yii::app()->getModule($el["custom"]["module"])->getAssetsUrl(true) : Yii::app()->getModule($this->module->id)->getAssetsUrl(true),
                   "url"=> "/custom?el=".@$_GET["el"] );
        
        if(@$el["custom"])
            $c = array_merge( $c , $el["custom"] );
        else 
            $c = array_merge( $c , array( "custom" => array( "welcomeTpl" => "../custom/".$stum[1]."/index")) );

        if (@$el["custom"]["logo"]) 
            $c["logo"] = Yii::app()->getModule($el["custom"]["module"])->getAssetsUrl(true).$el["custom"]["logo"];
        else if( @$el["profilImageUrl"] ) {
            $c["logo"] = Yii::app()->createUrl($el["profilImageUrl"]);
            $el["custom"]["logo"]=Yii::app()->createUrl($el["profilImageUrl"]);
        }
        $c["request"]["sourceKey"]=[$el["slug"]];
    }

    Yii::app()->session['custom'] = $c;
    CO2::filterThemeInCustom(Yii::app()->session["paramsConfig"]);      
} else {
    Yii::app()->session["custom"] = null; 
    //delete custom; 
}

if( @Yii::app()->session['custom'] ){  ?>

<script type="text/javascript">
    var custom = <?php echo json_encode(Yii::app()->session['custom']) ?>;
    //if(typeof custom.appRendering != "undefined")
    themeParams=<?php echo json_encode(Yii::app()->session['paramsConfig']) ?>;
    custom.init = function(where){
        if(custom.logo){
            $(".topLogoAnim").remove();
            $(".logo-menutop, .logoLoginRegister").attr({'src':custom.logo});
        }
        if( typeof custom != "undefined" && custom.type == "cities" )
            setOpenBreadCrum({'cities': custom.id });
        if(typeof custom.filters != "undefined"){
            if(typeof custom.filters.sourceKey != "undefined")
                searchObject.sourceKey=custom.request.sourceKey;
        }

    };
    custom.initMenu = function(where){
        /*if(typeof custom.menu != "undefined"){
            $.each(custom.menu, function(e,v){
                if(e=="all" && typeof v.label != "undefined")
                    $(".searchModSpan").text(v.label);
                if(e=="events" && typeof v.label != "undefined")
                    $(".agendaModSpan").text(v.label);
                if(e=="news" && typeof v.label != "undefined")
                    $(".liveModSpan").text(v.label);
                if(e=="classifieds" && typeof v.label != "undefined")
                    $(".annoncesModSpan").text(v.label);
            });
        }*/
        if(typeof custom.menuTop != "undefined"){
            $.each(custom.menuTop, function(e,v){
                if(e=="DDA" && !v)
                    $(".btn-dashboard-dda").remove();
                if(e=="donate" && !v)
                    $(".donation-btn").remove();
                if(e=="communexion" && !v){
                    $(".communexion-btn").remove();
                    //$(".communecter-btn").parent().remove();
                }
                if(e=="location" && !v)
                    $(".menu-btn-scope-filter").remove();
                if(e=="documentation" && !v)
                    $(".documentation-btn").remove();
                if(e=="statistics" && !v)
                    $(".statistics-btn").remove();
                if(e=="search" && !v)
                    $("#second-search-bar").remove();
                if(e=="app" && !v)
                    $("#dropdownApps").remove();
                if(e=="map" && !v)
                    $("#btn-show-map").remove();
                if(e=="home" && !v)
                    $(".btn-menu-home").remove();

            });
        }
    ;}
   
    <?php if( @Yii::app()->session['custom']["logo"]){ ?>
        color1=(typeof custom.color1 != "undefined") ? custom.color1 : "#ff9205";
        color2=(typeof custom.color1 != "undefined") ? custom.color2 : "#3dd4ed";
        themeObj.blockUi = {
            processingMsg :'<div class="lds-css ng-scope">'+
                    '<div style="width:100%;height:100%" class="lds-dual-ring">'+
                        '<img src="'+custom.logo+'" class="loadingPageImg" height=80>'+
                        '<div style="border-color: transparent '+color1+' transparent '+color1+';"></div>'+
                        '<div style="border-color: transparent '+color2+' transparent '+color2+';"></div>'+
                    '</div>'+
                '</div>', 
            errorMsg : '<img src="'+custom.logo+'" class="logo-menutop" height=80>'+
              '<i class="fa fa-times"></i><br>'+
               '<span class="col-md-12 text-center font-blackoutM text-left">'+
                '<span class="letter letter-red font-blackoutT" style="font-size:40px;">404</span>'+
               '</span>'+

              '<h4 style="font-weight:300" class=" text-dark padding-10">'+
                'Oups ! Une erreur s\'est produite'+
              '</h4>'+
              '<span style="font-weight:300" class=" text-dark">'+
                'Vous allez être redirigé vers la page d\'accueil'+
              '</span>'
        };
    <?php } ?>
</script>
<?php
    }
?>
