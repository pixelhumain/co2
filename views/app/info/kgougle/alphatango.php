<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "info",
                            )
                        );
      
      $urlKgou = Yii::app()->theme->baseUrl . "/assets/img/KGOUGLE-logo.png";
      $urlTango = Yii::app()->theme->baseUrl . "/assets/img/alphatango.png";
?>


<style type="text/css">
	.txt-mail{
		min-height: 300px;
		max-height: 700px;
		max-width: 100%;
		min-width: 60%;
	}
</style>
        	


<section class="padding-top-70">
    <div class="row main-apropos padding-top-15 padding-bottom-50">
	    
        <div class="col-lg-2 col-md-2 col-sm-2 text-right hidden-xs" id="">
        	<img src="<?php echo $urlTango; ?>" class="img-responsive col-md-12">
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

        	<h5 class="pull-left text-azure">
        		<i class="fa fa-angle-down"></i> Alpha Tango
        	</h5>
        	
			<a href="#web" class="lbh btn btn-default pull-right margin-left-5 btn-submenu tooltips"
        		data-toggle="tooltip" data-placement="top" title="Retourner vers le moteur de recherche">
        		<b>Quitter cette page <i class="fa fa-arrow-right"></i></b>
        	</a> 
        	<a href="#info.p.apropos" class="lbh btn btn-danger pull-right btn-submenu tooltips"
        		data-toggle="tooltip" data-placement="top" title='Retourner vers la page de présentation "A propos"'>
				<b><i class="fa fa-arrow-left"></i> À propos</b>
			</a>
        	
        	<br>
        	<hr>
        	<!-- --------------------------------------------------------------------------------- -->
        	


			<!-- <div class="col-md-12 text-center">
				<img src="<?php echo $urlTango; ?>" width="450" style="margin-top:-20px;">
			</div> -->
			<div class="col-md-12 text-left padding-top-60">
				<h1 class="letter-red font-blackoutM" id="koica">
	        		 <span class="letter-azure">Aplha Tango</span>, C ki lui ?!?
	        	</h1>
	        	<h3 class="letter-blue"><i class="fa fa-angle-right"></i> Votre contact Calédonien</h3>
				<b>KGOUGLE</b> a été mis en place par une équipe de développeurs indépendants : <a class="letter-yellow lbh" href="#info.p.ph"><b>les PixelHumains</b></a><br>
				Ce collectif est composée de 5 développeurs répartis sur 3 fuseaux horaires : <b>Nouvelle-Calédonie, île de la Réunion, et métropole.</b><br><br>
				
				<b><span class="letter-azure font-blackoutM">Alpha Tango</span> est notre développeur Calédonien</b>, à l'origine de la création de <b>KGOUGLE</b>, et à votre disposition pour répondre à toutes vos questions.<br>C'est le lien entre les Calédoniens et notre collectif <b>PixelHumain</b>.
				<br><br>
				<hr>
				<br>				
			</div>

			<?php $this->renderPartial($layoutPath.'forms.'.Yii::app()->params["CO2DomainName"].'.formContact'); ?>
    </div>
</section>


<?php $this->renderPartial($layoutPath.'footer',  array( "subdomain"=>"info" ) ); ?>

<script>

var currentCategory = "";

jQuery(document).ready(function() {
    initKInterface();
    location.hash = "#info.p.alphatango";
    $(".tooltips").tooltip();
    
    $(".dropdown-onepage-main-menu li a").click(function(e){
		e.stopPropagation();
		var target = $(this).data("target");
		console.log(target);
		KScrollTo(target);
	});

	$("#btn-onepage-main-menu").trigger("click");
	
});

</script>