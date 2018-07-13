<?php  

//init will always be exeecuted in a JS document ready

if( @$_GET["el"] || @$custom )
{ 

    //Yii::app()->session['custom']=null;
    //if( !@Yii::app()->session['custom'])
    //{
        $stum = (@$custom) ?  explode(".",  $custom ) : explode(".",  $_GET["el"] );
        //if( Element::getModelByType( $stum[0] ) ){
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

                if(@$el["custom"]["urlLogo"]) 
                    $c["logo"]=$el["custom"]["urlLogo"];
            }
            else {
                if($stum[0] == "o")
                    $stum[0] = Organization::COLLECTION;
                $el = Element::getByTypeAndId( $stum[0] , $stum[1] );
                
                $c = array( "id"   => (string) $el["_id"],
                           "type" => $stum[0],
                           "title"=> $el["name"],
                           "url"=> "/custom?el=".$_GET["el"] );
                
                if(@$el["custom"])
                    $c = array_merge( $c , $el["custom"] );

                if (@$el["custom"]["logo"]) 
                    $c["logo"] = Yii::app()->getModule( $el["custom"]["module"])->getAssetsUrl(true).$el["custom"]["logo"];
                else if( @$el["profilImageUrl"] ) {
                    $c["logo"] = $el["profilImageUrl"];
                    $el["custom"]["logo"]=$el["profilImageUrl"];
                }
            }

            Yii::app()->session['custom'] = $c;
            
    //}
} else {
    Yii::app()->session["custom"] = null; 
    //delete custom; ?>
<?php }

if( @Yii::app()->session['custom'] ){  ?>

<script type="text/javascript">
    var custom = <?php echo json_encode(Yii::app()->session['custom']) ?>;
     <?php if(@Yii::app()->session['custom']['menu']){ ?>
       // custom.menu=<?php echo json_encode(Yii::app()->session['custom']['menu']) ?>;
    <?php } ?>
    <?php if(@Yii::app()->session['custom']['menuTop']){ ?>
        //custom.menuTop=<?php echo json_encode(Yii::app()->session['custom']['menuTop']) ?>;
    <?php } ?>
   
    custom.init = function(where){
        if(custom.logo){
            $(".topLogoAnim").remove();
            $(".logo-menutop, .logoLoginRegister").attr({'src':custom.logo});
        }
    };
    custom.initMenu = function(where){
        if(typeof custom.menu != "undefined"){
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
        }
        if(typeof custom.menuTop != "undefined"){
            $.each(custom.menuTop, function(e,v){
                if(e=="DDA")
                    $(".btn-dashboard-dda").remove();
                if(e=="donate")
                    $(".donation-btn").remove();
                if(e=="communexion"){
                    $(".communexion-btn").remove();
                    //$(".communecter-btn").parent().remove();
                }
                if(e=="location")
                    $(".menu-btn-scope-filter").remove();
                if(e=="documentation")
                    $(".documentation-btn").remove();
                if(e=="statistics")
                    $(".statistics-btn").remove();
            });
        }
    ;}
   
    <?php if( @Yii::app()->session['custom']["logo"]){ ?>
        
        
        themeObj.blockUi = {
            processingMsg :'<div class="lds-css ng-scope">'+
                    '<div style="width:100%;height:100%" class="lds-dual-ring">'+
                        '<img src="'+custom.logo+'" class="loadingPageImg" height=80>'+
                        '<div style="border-color: transparent #ff9205 transparent #ff9205;"></div>'+
                        '<div style="border-color: transparent #3dd4ed transparent #3dd4ed;"></div>'+
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
</script>
    <?php } 
    }
?>