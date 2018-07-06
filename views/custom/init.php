<?php  

//init will always be exeecuted in a JS document ready

if( @$_GET["el"])
{ 

    Yii::app()->session['custom']=null;
    if( !@Yii::app()->session['custom'])
    {
        $stum = explode(".",  $_GET["el"] );
        //if( Element::getModelByType( $stum[0] ) ){
            $el = ($stum[0]=="city") ? City::getByInsee($stum[1]) 
                                     : Element::getByTypeAndId( $stum[0] , $stum[1] );
            if(@$el["custom"]){
                Yii::app()->session['custom'] = array( "id"   => (string) $el["_id"],
                                                       "type" => City::COLLECTION,
                                                       "url" => "/custom?el=".$_GET["el"]."#welcome"
                                                    );
                Yii::app()->session['custom'] = array_merge(Yii::app()->session['custom'],$el["custom"]);
            }
        //}
    }
} else {
    Yii::app()->session["custom"] = null; 
    //delete custom; ?>
<?php }

if( @Yii::app()->session['custom'] ){ ?>
    custom.id = "<?php echo Yii::app()->session['custom']['id'] ?>";
    custom.type = "<?php echo Yii::app()->session['custom']['type'] ?>";

    <?php if(@Yii::app()->session['custom']['menu']){ ?>
        custom.menu=<?php echo json_encode(Yii::app()->session['custom']['menu']) ?>;
    <?php } ?>
    setOpenBreadCrum({'cities': custom.id });
    <?php if(Yii::app()->session['custom']["logo"]){ ?>
        custom.logo = modules.eco.url+"<?php echo Yii::app()->session['custom']['logo'] ?>";
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
    <?php } 
}
?>
