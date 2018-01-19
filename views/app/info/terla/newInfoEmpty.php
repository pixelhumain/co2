<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "info",
                            )
                        );
?>


<style type="text/css">
</style>
        	
<header>
<div class="container">
    <div class="headerTitle"> <?php echo Yii::t("terla", "EMPTY"); ?></div>
</div>
</header>

<section class="padding-top-70">
    <div class="container main-apropos padding-top-15 padding-bottom-50">
	    Hello EMPTY
    </div>
</section>


<?php $this->renderPartial($layoutPath.'footer',  array( "subdomain"=>"info" ) ); ?>
