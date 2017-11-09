<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "info",
                            )
                        );
      
      $urlKgou = Yii::app()->theme->baseUrl . "/assets/img/KGOUGLE-logo.png";
?>
<style>
	p{
		font-size:15px;
	}

	.logoKgou{
		margin-top: -0px;
		height:35px;
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
    .row.main-apropos{
    	padding:25px;
    }

    h1, h3, h4, p{
    	font-size:1em;
    }

	.logoKgou{
		height:25px;
	}

	h1{
		padding-top:0px;
	}
}

</style>


<section class="padding-top-70">
    <div class="row main-apropos padding-top-15 padding-bottom-50">
	    
        <div class="col-lg-3 col-md-3 col-sm-4 text-right hidden-xs" id="sub-menu-left">
        	<div class="dropdown">
				<button class="btn bg-red text-white btn font-blackoutM dropdown-toggle" data-toggle="dropdown" id="btn-onepage-main-menu">
					<i class="fa fa-bars"></i> MENU
				</button>
				<div class="dropdown-onepage-main-menu font-montserrat" aria-labelledby="btn-onepage-main-menu">
					<ul class="dropdown-menu arrow_box font-blackoutM letter-red">
					    <li><a href="javascript:" data-target="#koica" class="letter-red"><i class="fa fa-angle-right"></i> C koissa ?!?</a></li>
					    <li><a href="javascript:" data-target="#aussi" class="letter-red"><i class="fa fa-angle-right"></i> C'est aussi</a></li>
					    <li><a href="javascript:" data-target="#philo" class="letter-red"><i class="fa fa-angle-right"></i> Notre philosophie</a></li>
					    <li><a href="javascript:" data-target="#dev" class="letter-red"><i class="fa fa-angle-right"></i> En developpement</a></li>
					    <li><a href="javascript:" data-target="#motivation" class="letter-red"><i class="fa fa-angle-right"></i> Nos motivations</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#info.p.ph" class="lbh letter-yellow"><i class="fa fa-angle-right"></i> Pixel Humain</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#info.p.communecter" class="lbh letter-red"><i class="fa fa-angle-right"></i> Communecter</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#info.p.alphatango" class="lbh text-azure"><i class="fa fa-angle-right"></i> Alpha Tango</a></li>
					  </ul>
				</div>
			</div>
        </div>
        <div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">

        	<h5 class="pull-left">
        		<i class="fa fa-angle-down"></i> A propos
        	</h5>
        	
        	<a href="#web" class="lbh btn btn-default pull-right margin-left-5 btn-submenu tooltips"
        		data-toggle="tooltip" data-placement="top" title="Retourner vers le moteur de recherche">
        		<b>Quitter cette page <i class="fa fa-arrow-right"></i></b>
        	</a> 

        	<br>
        	<hr>
        	<!-- --------------------------------------------------------------------------------- -->
        	<h1 class="letter-red font-blackoutM" id="koica">
        		<img src="<?php echo $urlKgou; ?>" class="logoKgou"> C koissa ?!?
        	</h1>

        	<h3 class="letter-blue"><i class="fa fa-angle-right"></i> Un moteur de recherche simplifié</h3>
        	<p>
				Kgougle vous permet de retrouver rapidement et facilement, <b> les principaux sites calédoniens</b>.<br>
				Nous avons répertorié pour vous <b>près de 300 sites web</b>, pour vous permettre de gagner un temps fou lors de vos recherches !<br>
				Vous trouverez tout ce que vous cherchez <b>sans taper plus d’un mot sur votre clavier...</b>
        	</p>

        	<hr>
        	<h3 class="letter-blue"><i class="fa fa-angle-right"></i> Un moteur de recherche pour tous !</h3>
        	<p>
				Internet reste un outil nouveau sur le caillou, et si les personnes les plus connectées ont appri à s’y retrouver, d’autres se sentent parfois un peu perdus…<br><br>
				<span class="letter-green"><b>Les internautes les plus habitués</b></span> retrouveront tous les sites qu’ils utilisent fréquemment, tout en profitant de la puissance de recherche dans notre base de données locales. 
				Ils pourront également continuer à explorer le web international grâce à la fonction <b><i>continuer ma recherche</i></b>.<br><br>
				
				<span class="letter-green"><b>Quant aux plus novices</b></span>, ils pourront enfin explorer l’ensemble du web local facilement, grâce au système de recherches par catégories, sans même taper sur le clavier !

        	</p>

        	<!-- --------------------------------------------------------------------------------- -->
        	<br><br><br>
        	<h1 class="letter-red font-blackoutM" id="aussi">
        		<img src="<?php echo $urlKgou; ?>" height="35" class="logoKgou"> c'est ossi ...
        	</h1>

        	<h3 class="letter-blue"><i class="fa fa-database fa-2x"></i> <i class="fa fa-angle-righ"></i> Une base de données co-construite</h3>
        	<h4>En amélioration continue...</h4>
			<p>
				Avec près de <b class="letter-green">300 sites répertoriés</b>, vous retrouverez à coup sûr tous les sites les plus utilisés en Nouvelle-Calédonie. <br>
				<b>Mais il reste encore beaucoup de sites à ajouter</b> pour compléter le résultats de vos recherches, et rendre ce moteur encore plus puissant…<br><br>

				C’est pourquoi <b class="letter-green">vous pouvez TOUS référencer de nouvelles URL</b> via <a href="#referencement" class="letter-blue" target="_blank"><b>un formulaire de référencement</b></a>, lui aussi simplifié au maximum…<br>
				<i>N’hésitez pas à ajouter les sites manquant et ainsi participer à la construction de cette base de données.</i>

        	</p>

        	<h1 class="letter-red font-blackoutM" id="aussi">
        		<img src="<?php echo $urlKgou; ?>" height="35" class="logoKgou"> c'est ossi ...
        	</h1>
        	<hr>
            <h3 class="letter-blue">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/radios/radio-ico.png" 
                     height="50" style="margin-top: -15px;"> 
                Un poste de radio 
            </h3>
            <h4>Pour rester en contact permanent avec le reste du pays...</h4>
            <p>
                Retrouvez à tout moment les radios locales, pour suivre l’actualité, se divertir, ou simplement écouter de la musique.
            </p>
            <button class="btn btn-link letter-blue" data-target="#modalRadioTool" data-toggle="modal">
                <i class="fa fa-arrow-circle-right"></i> Afficher la radio
            </button>

            <hr>
        	<h3 class="letter-blue"><i class="fa fa-star-o fa-2x"></i> <i class="fa fa-angle-righ"></i> La gestion de vos sites favoris</h3>
        	<h4>Cherchez une fois, trouvez pour toujours...</h4>
			<p>
				Grâce à la section <b class="letter-blue">Mes favoris</b>, gardez à portée de main les sites que vous fréquentez le plus, et ne les cherchez plus !<!-- <br><small>* en attendant l'ouverture des inscriptions, cette fonctionnalité utilise vos cookies</small> -->
        	</p>

        	<hr>
        	

        	<h3 class="letter-blue">
        		<i class="fa fa-map fa-2x"></i> Un outil de cartographie 
        	</h3>
        	<h4>Pour se repérer facilement sur le Caillou...</h4>
			
            <button class="btn btn-link letter-blue btn-show-map">
                <i class="fa fa-arrow-circle-right"></i> Afficher la carte
            </button>

            <hr>
            <h3 class="letter-blue">
                <i class="fa fa-newspaper-o fa-2x"></i> Un fil d'actualités
            </h3>
            <h4>Une revue de presse des grands médias calédoniens et d’outre-mers</h4>
            <p>
                Pour suivre en direct l'actualité locale et garder un oeil sur le reste du monde.<br>
            </p>


            <hr>
            <h3 class="letter-blue">
                <i class="fa fa-user-circle fa-2x"></i> Un réseau social
            </h3>
            <h4>Créez votre page en quelques secondes, trouvez des followers et communiquez avec eux.</h4>
            <p>partagez votre actu, vos photos, vos événements, vos points d'intérêts, etc </p>
           

            <hr>
            <h3 class="letter-blue">
                <i class="fa fa-calendar fa-2x"></i> Un agenda collaboratif
            </h3>
            <h4>pour faire connaître tous vos événements et ne rien rater de l’activité locale</b></h4>
            <p>(concert, exposition, sport, festival, sorties, animation culturelle, etc)</p>
           


        	

        	<!-- --------------------------------------------------------------------------------- -->
        	<br><br><br>
        	<h1 class="letter-red font-blackoutM" id="dev">
        		<img src="<?php echo $urlKgou; ?>" height="35" class="logoKgou"> En developpement
        	</h1>

        	<h3 class="letter-blue"><i class="fa fa-cubes fa-2x"></i> <i class="fa fa-angle-righ"></i> Plusieurs nouveautés déjà en préparation</h3>
        	<!-- <h4>Notre imagination est sans limite...</h4> -->
			<p>
                <i class="fa fa-comments letter-red"></i> <span class="letter-red font-blackoutT">ANNONCES</span> <b><span class="letter-green">Un outil de partage d’annonces en direct</span>, pour diffuser toutes vos annonces directement sur Kgougle.</b> 
                (à vendre, à donner, à partager, à louer, offre d’emplois, etc)
            </p>

            <p>
                <i class="fa fa-comments letter-red"></i> <span class="letter-red font-blackoutT">LIVE</span> <b><span class="letter-green">Un espace de discussion public et géolocalisé</span>, pour passer vos coups de coeur, vos coups de gueule, parler de l'actu, lancer des débats sur des sujets de société, etc</b> 
            </p>

            <!-- --------------------------------------------------------------------------------- -->
            <br><br><br>
            <h1 class="letter-red font-blackoutM" id="philo">
                <img src="<?php echo $urlKgou; ?>" height="35" class="logoKgou"> Notre philosophie
            </h1>

            <h3 class="letter-blue"><i class="fa fa-line-chart fa-2x"></i> En amélioration continue, pour le bien commun...</h3>
            <!-- <h4></h4> -->
            <p>
                Kgougle a été mis en place par <a href="" class="letter-yellow"><b>une équipe de développeurs indépendants</b></a>, dans le but de faciliter l’usage d’internet en Nouvelle-Calédonie. Ce moteur de recherche est un premier pas vers une évolution majeure de l'utilisation du web sur le territoire. En offrant un guide d'accès vers l'ensemble des sites web locaux, nous permettons à tous les Calédoniens de naviguer <i>sans se perdre</i>, et donc de prendre en main plus facilement cet outil sur-puissant...
                <br><br>
                Sur le caillou, internet est un outil encore nouveau, que l’on découvre petit à petit, et que nous tentons d’apprivoiser.<br>
                Mais internet nous arrive avec une complexité et une immensité, dont nous n’avons pas toujours besoin. 
                <br><br>
                Au sein de notre équipe, nous pensons qu’une recherche sur le web <b>ne devrait être un casse-tête pour personne</b>, car internet est un outil formidable, <b>pour toutes les générations</b>, qui ouvre un grand nombres de nouvelles possibilités <b>pour tout le territoire</b>.
                <br><br>
                A moyen terme, nous souhaitons également proposer d'autres outils numériques innovants, qui participeront à l'amélioration globale des services web disponibles en Nouvelle-Calédonie.
                <br><br>
                
                <a href="#info.p.ph" class="letter-yellow">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGO_PIXEL_HUMAIN.png" height=100> 
                    <b><i class="fa fa-plus-circle"></i> En savoir plus sur notre équipe</b>
                </a>
            </p>


            
			<!-- --------------------------------------------------------------------------------- -->
        	<br><br><br>
        	<h1 class="letter-red font-blackoutM" id="motivation">
        		<img src="<?php echo $urlKgou; ?>" height="35" class="logoKgou"> Nos motivations
        	</h1>

        	<!-- <h3 class="letter-blue"><i class="fa fa-cubes fa-2x"></i> <i class="fa fa-angle-righ"></i> Plusieurs nouvelles applications sont déjà en cours de développement</h3> -->
        	<h4></h4>
			<p>
				Le collectif <b class="letter-yellow"><b>PixelHumain</b></b> est réuni depuis ses origines autour d'un objectif commun : créer des outils numériques collaboratifs afin de <b>(re)dynamiser les territoires</b>, en facilitant la <b>communication entre les différents acteurs locaux</b>.<br><br>
				
				Dans cet objectif, nous <b>co-construisons</b> depuis plus de 3 ans, une plateforme sociétale dénommée <a href="www.communecter.org" class="letter-red"><b>Communecter.org</b></a>, qui propose un ensemble de fonctionnalités cohérentes aux internautes souhaitant participer plus activement à la <b>vie de leur territoire</b>.<br><br>

				En Nouvelle-Calédonie, certaines particularités propres à ce territoire isolé d'océanie nous ont poussé à adopter une approche légèrement différente de celle que nous suivons depuis nos débuts. Pour répondre au mieux aux <b>besoins réels du pays</b> dans le domaine de l'internet.<br><br>
				C'est ainsi que KGOUGLE est né : c'est une application issue de la plateforme <a href="www.communecter.org" class="letter-red"><b>Communecter.org</b></a>, adaptée au territoire Calédonien, pour en simplifier l'utilisation et proposer des applications spécifiques.
				<br><br>
				Motivé et conseillé par notre développeur calédonien <a href="#info.p.alphatango" class="letter-green"><b>AlphaTango</b></a>, nous espérons faire avancer internet sur le Caillou et en multiplier les usages : d'abord via ce moteur de recherche, pour faciliter votre navigation sur le web d'aujourd'hui, puis par la mise en place d'autres fonctionnalités innovantes déjà inclues dans la plateforme <a href="www.communecter.org" class="letter-red"><b>Communecter.org</b></a>.
        	</p>

			
        </div>
    </div>
</section>


<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"],   array( "subdomain"=>"info" ) ); ?>



<script type="text/javascript" >

jQuery(document).ready(function() {
    initKInterface();
    location.hash = "#info.p.apropos";

    $(".dropdown-onepage-main-menu li a").click(function(e){
		e.stopPropagation();
		var target = $(this).data("target");
		console.log(target);
		KScrollTo(target);
	});

	$("#btn-onepage-main-menu").trigger("click");

});

</script>