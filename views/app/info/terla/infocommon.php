<?php 
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "info",
                            )
                        );
?>

<style type="text/css">
	.main-apropos{
		min-height:600px;
	}
</style>
        	
<header>
<div class="container">
    <div class="headerTitle"> <?php echo Yii::t("terla", $title); ?></div>
</div>
</header>