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
                                                       "type" => City::COLLECTION );
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
        $(".logo-menutop").attr({'src':custom.logo});
    <?php } 
}
?>
