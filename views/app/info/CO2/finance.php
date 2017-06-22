<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "info",
                            )
                        );
      
?>
<style>
	p{
		font-size:15px;
	}

	h1{
		padding-top:20px;
	}

	.arrow_box:after, .arrow_box:before {
		left: 19px;
	}


@media screen and (max-width: 1024px) {
    
}

@media (max-width: 768px) {


</style>


<section class="padding-top-70">
    <div class="row main-apropos padding-top-15 padding-bottom-50">
	    
        <div class="col-lg-3 col-md-3 col-sm-4 text-right hidden-xs" id="sub-menu-left">
        </div>
        <div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">

        	<h5 class="pull-left">
        		<i class="fa fa-angle-down"></i> Situation financière
        	</h5>
        	
        	<a href="#" class="lbh btn btn-default pull-right margin-left-5 btn-submenu tooltips"
        		data-toggle="tooltip" data-placement="top" title="Retourner vers l'accueil">
        		<b>Quitter cette page <i class="fa fa-arrow-right"></i></b>
        	</a> 

        	<br>
        	<hr>

        	<h1 class="letter-red font-blackoutM" id="koica">
        		ON N'A PLUS DE SOUS !!!
        	</h1>

        	<h3 class="letter-blue"><i class="fa fa-angle-right"></i> Please help us !</h3>
        	<p>
				Le collectif de développeurs qui s'occupe actuellement de la plateforme a besoin de pouvoir continuer à travailler à plein temps sur ce projet pharaonique.
				<br><br>
				Impossible pour eux de travailler à mi-temps, et de partager leur travail avec d'autres prestations.<br>
				La maintenance, l'amélioration, et le suivi de l'application nécessite une équipe de techniciens compétent qui s'en occupe quotidiennement.
				<br><br>
				Pour que nos développeurs puissent se consacrer entièrement au projet Communecter, ils ont besoin de votre soutient financier.
				<br><br>
				Le compte de l'association sont aujourd'hui au plus bas, ce qui laisse entrevoir la possibilité de l'abandon de la plateforme, faute de moyen financier suffisant pour permettre aux développeurs de vivre sans travailler "à côté".
				<br><br>
				Nous nous en remettons donc à vos dons.
				<br><br>
				Si vous souhaitez que le réseau Communecter continue à grandir, il ne tient qu'à vous d'apporter votre soutien. Si chacun d'entre vous donne quelques euros, c'est possible !

				<h3 class="letter-blue">Un projet à long terme</h3>
				L'équipe actuelle de développeurs est sur-motivée et souhaite plus que tout continuer son travail.<br>
				Elle souhaite également s'agrandir si possible, en intégrant de nouveau développeurs, ou en collaborant avec d'autres équipes afin de développer des applications interropérables.<br><br>
				Nous souhaitons également continuer à améliorer l'application Communecter, en rajoutant de nouvelles fonctionnalités.

				<h3 class="letter-blue">Budget annuel : (exemple)</h3>
				6 développeurs à 2000€/mois, pendant 1 an : Pour développer l'application<br>
				6 * 2000 * 12 = <?php $c1 = 6 * 2000 * 12; echo $c1; ?>€
				<br><br>
				6 communecteur à 1000€/mois, pendant 1 an : Pour faire connaitre et comprendre l'application<br>
				6 * 2000 * 12 = <?php $c2 = 6 * 1000 * 12; echo $c2; ?>€
				<br><br>
				ETC ...
				<br><br><br>
				Total : <?php echo $c1 + $c2; ?>€
        	</p>
        </div>
    </div>
</section>


<?php $this->renderPartial($layoutPath.'footer',  array( "subdomain"=>"info" ) ); ?>

<script type="text/javascript" >

jQuery(document).ready(function() {
    initKInterface();
    location.hash = "#info.p.finance";
});

</script>