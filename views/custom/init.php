<?php  

//init will always be exeecuted in a JS document ready

if( @$_GET["city"]){ 
    Yii::app()->session['custom']=null;
    if( !@Yii::app()->session['custom'])
    {
        $city = City::getById( $_GET["city"] );
        if(@$city["custom"]){
            Yii::app()->session['custom'] = array("id"   => (string) $city["_id"],
                                                  "type" => City::COLLECTION );
            Yii::app()->session['custom'] = array_merge(Yii::app()->session['custom'],$city["custom"]);
        }
    }

    if( @Yii::app()->session['custom'] )
    {
?>

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
}else{
    Yii::app()->session["custom"] = null; ?>
    delete custom;
<?php } ?>


