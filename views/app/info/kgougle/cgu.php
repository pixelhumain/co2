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
        	

<section class="padding-top-70" style="min-height:800px;">
	<div class="col-md-10 col-md-offset-1">
		<h3>Les Condition Générales d'Utilisation ne sont pas encore publiées (en cours de rédaction).<br>
		<small>Merci de patienter encore quelques jours</small></h3>
		<a href="#web" class="lbh btn btn-default pull-left margin-left-5 btn-submenu tooltips"
			data-toggle="tooltip" data-placement="top" title="Retourner vers le moteur de recherche">
			<b><i class="fa fa-arrow-left"></i> Retour</b>
		</a> 
	</div>
</section>


<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"],  array( "subdomain"=>"info" ) ); ?>

<script>

var currentCategory = "";

jQuery(document).ready(function() {
    initKInterface();
    location.hash = "#info.p.cgu";
});

</script>