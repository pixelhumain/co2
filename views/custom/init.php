<?php  

//init will always be exeecuted in a JS document ready

if( @$_GET["city"] || Yii::app()->session['custom'] ){ 
    
    if(!@Yii::app()->session['custom']){
        $city = City::getById( $_GET["city"] );
        Yii::app()->session['custom'] = array("id"   => (string) $city["_id"],
                                              "type" => City::COLLECTION );
        Yii::app()->session['custom'] = array_merge(Yii::app()->session['custom'],$city["custom"]);
    }
?>

custom.id = "<?php echo Yii::app()->session['custom']['id'] ?>";
custom.type = "<?php echo Yii::app()->session['custom']['type'] ?>";
custom.logo = modules.eco.url+"<?php echo Yii::app()->session['custom']['logo'] ?>";

<?php if(Yii::app()->session['custom']["bannerTpl"]){ ?>
    $(".logo-menutop").attr({'src':custom.logo});
<?php } 

} ?>

