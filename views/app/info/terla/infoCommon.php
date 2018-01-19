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
    <div class="headerTitle"> <?php echo Yii::t("terla", $title); ?></div>
</div>
</header>