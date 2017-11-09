<?php
/* @var $this SiteController */
/* @var $error array */
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<style>
#error{
font-family: "Homestead";
}
#error h1 {
  position:relative;
  top:50px;
  left:100px;
  color: #E6334C;
  font-family: "Homestead";
}
#error h2 {
  position:relative;
  top:70px;
  left:100px;
  color: #324553;
}
</style>

<div class="container" id="accueil">
    <br/>
    <!-- Main hero unit for a primary marketing message or call to action -->
    <div style="text-align: center;">        
    	<img id="logoERror" width=300 src="<?php echo $this->module->assetsUrl."/images/main-logo-home.png"?>" alt="Logo Pixel Humain"/>
    	<div id="error">

    		<div style="margin:30px 0 0 50px;text-align: center;">
				
				<?php if( $error["code"] ){?>
					<span style="font-size:2em; color:red; font-weight: bold;">
			            ERREUR <?php echo $error["code"]?>
			            <br/><?php 
							if( isset($error["message"]) )
								echo $error["message"];
							else
								echo Yii::t("common","Oops! You are stuck at",null,Yii::app()->controller->module->id).$error["code"];
							?>
					</span>
					<span style="font-size:2em">
						<br/><br/>ERROR, PAGE OR DEMOCRACY NOT FOUND
			            <br/>QUI CHERCHE FINIT PAR TROUVER
		            </span>
		        <?php }?>
				
				<div>
					<br/><br/><br/>
					<?php echo Yii::t("common","Unfortunately the page you were looking for could not be found.",null,Yii::app()->controller->module->id);?>
					<br>
					<?php echo Yii::t("common","It may be temporarily unavailable, moved or no longer exist.",null,Yii::app()->controller->module->id);?>
					<br>
					<?php echo Yii::t("common","Check the URL you entered for any mistakes and try again.",null,Yii::app()->controller->module->id);?>
					<br>
					<a href="<?php echo Yii::app()->createUrl('/'.$this->module->id);?>" class="btn btn-red btn-return">
						<?php echo Yii::t("common","Return home",null,Yii::app()->controller->module->id);?>
					</a>
				</div>
				
		        
			</div>

			

			
    		
        </div>
        <div class="clear"></div>
        <div>
        <?php /*if(YII_DEBUG){?>
        	<?php echo CHtml::encode($message); ?>
        	<pre><?php echo print_r(debug_backtrace(),true) ?></pre>
        <?php }*/?>
        </div>
        
        <br/><br/>
    </div>
</div>
