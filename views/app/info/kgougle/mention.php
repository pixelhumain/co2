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
.main-col-search{	padding:0px !important; }
.fa-caret-down{font-size:56px;line-height: 10px;}
.social-list{	padding: 0;}
.social-list li{	list-style-type: none;	display:inline;margin-right:10px;}
.social-list li a{ font-size:20px;}
.social-list .btn{	margin-top: 15px;}
a.btn.btn-social{	color: #FFF;	background-color: #2a3945; }
a.btn.btn-social:hover{	background: none;}
a.btn.btn-facebook:hover{	color: #3b5998;}
a.btn.btn-twitter:hover{	color: #00a0d1;	border-color: #00a0d1;}
a.btn.btn-google:hover{	color: #dd4b39;	border-color: #dd4b39;}
a.btn.btn-github:hover{	color: #4078C0;	border-color: #4078C0;}
.yellowph{color:#F6E201;}
.information{font-size:15px;color:#8b91a0;}
.explainTitle{
	cursor: pointer;
	background-color: #fff;
	padding: 10px;
	text-align: left;
	color: #1a67e7;
	/*margin: 0px;
	margin-top: 15px;*/
	border-bottom: 1px solid #666;
}
.explainDesc{ padding: 10px; background-color: white; }
.caretExplain{display: none; position: relative;top: 0px;background-color: white;color:#606060;}
</style>


<section class="padding-top-70">
    <div class="row padding-20 main-apropos padding-top-15 padding-bottom-50">
	    
        <div class="col-lg-2 col-md-2 col-sm-2 text-right hidden-xs" id=""> 
        	
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">


        	<h4 class="pull-left"><i class="fa fa-angle-down"></i> Mentions légales
        	</h4>

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
			
        	<div class="explainDesc"><i>	
				Merci de lire avec attentions les différentes modalités d’utilisation du présent site avant d’y parcourir ses pages. En vous connectant sur ce site, vous acceptez sans réserves les présentes modalités. Aussi, conformément de l’Article n°6 de la Loi n°2004-575 du 21 Juin 2004 pour la confiance dans l’économie numérique, les responsables du présent site internet <a href="http://www.kgougle.nc">www.kgougle.nc</a> sont :</i>
			</div>

			<h3 class=" explainTitle"> Editeur du Site </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				<b>Association Open Atlas</b><br>
				Numéro de SIRET :  513381830<br>
				102a rue pierre payet, 97421, La Réunion<br>
				Email : contact@communecter.org<br>
				Site Web : <a href="http://www.kgougle.nc">www.kgougle.nc</a><br><br>
				
				Responsable editorial : Tristan Goguet<br>
				11 rue Joachim du Bellay, Dumbea, Koutio, Nouvelle-Calédonie<br>
				RIDET : 1 225 812.001<br>
				Téléphone : 96.53.57<br>
				Email : tango@communecter.org<br>
				

			</div>

			<h3 class=" explainTitle"> Hébergement </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				Hébergeur : Amazon, California, Usa
				Site Web :  <a href="http://www.amazon.com">www.amazon.com</a>
			</div>

			<h3 class=" explainTitle"> Développement </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				<a href="https://www.communecter.org/#organization.detail.id.555eba56c655675cdd65bf19" target="_blank">Collectif d'indépendant O.R.D</a><br>
				Adresse : 102a rue pierre payet, 97421, La Réunion<br>
				<!-- Site Web : <a href="http://www.oceatoon.com">www.oceatoon.com</a> -->
			</div>

			<h3 class=" explainTitle"> Conditions d’utilisation </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				Ce site (<a href="http://www.kgougle.nc">www.kgougle.nc</a>) est proposé en différents langages web (HTML, HTML5, Javascript, CSS, etc…) pour un meilleur confort d'utilisation et un graphisme plus agréable, nous vous recommandons de recourir à des navigateurs modernes comme Internet explorer, Safari, Firefox, Google Chrome, etc…

				<span style="color: #323333;">Association Open Atlas<b> </b></span>met en œuvre tous les moyens dont elle dispose, pour assurer une information fiable et une mise à jour fiable de ses sites internet. Toutefois, des erreurs ou omissions peuvent survenir. L'internaute devra donc s'assurer de l'exactitude des informations auprès de , et signaler toutes modifications du site qu'il jugerait utile. n'est en aucun cas responsable de l'utilisation faite de ces informations, et de tout préjudice direct ou indirect pouvant en découler.

				<b>Cookies</b> : Le site <a href="http://www.kgougle.nc">www.kgougle.nc</a> peut-être amené à vous demander l’acceptation des cookies pour des besoins de statistiques et d'affichage. Un cookies est une information déposée sur votre disque dure par le serveur du site que vous visitez. Il contient plusieurs données qui sont stockées sur votre ordinateur dans un simple fichier texte auquel un serveur accède pour lire et enregistrer des informations . Certaines parties de ce site ne peuvent être fonctionnelle sans l’acceptation de cookies.

				<b>Liens hypertextes :</b> Le site internet peut offrir des liens vers d’autres sites internet ou d’autres ressources disponibles sur Internet. L'Association Open Atlas ne dispose d'aucun moyen pour contrôler les sites en connexion avec le site internet, ne répond pas de la disponibilité de tels sites et sources externes, ni ne la garantit. Elle ne peut être tenue pour responsable de tout dommage, de quelque nature que ce soit, résultant du contenu de ces sites ou sources externes, et notamment des informations, produits ou services qu’ils proposent, ou de tout usage qui peut être fait de ces éléments. Les risques liés à cette utilisation incombent pleinement à l'internaute, qui doit se conformer à leurs conditions d'utilisation.
				<br/><br/>
				Les utilisateurs, les abonnés et les visiteurs des sites internet ne peuvent mettre en place un hyperlien en direction de ce site sans l'autorisation expresse et préalable de Association Open Atlas.
				<br/><br/>
				Dans l'hypothèse où un utilisateur ou visiteur souhaiterait mettre en place un hyperlien en direction d’un des sites internet de Association Open Atlas, il lui appartiendra d'adresser un email accessible sur le site afin de formuler sa demande de mise en place d'un hyperlien. Association Open Atlas se réserve le droit d’accepter ou de refuser un hyperlien sans avoir à en justifier sa décision.
			</div>

			<h3 class=" explainTitle"> Services fournis </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				L'ensemble des activités de la société ainsi que ses informations sont présentés sur notre site <a href="http://www.kgougle.nc">www.kgougle.nc</a>.<br>
				Association Open Atlas s’efforce de fournir sur le site www.kgougle.nc des informations aussi précises que possible. les renseignements figurant sur le site <a href="http://www.kgougle.nc">www.kgougle.nc</a> ne sont pas exhaustifs et les photos non contractuelles. Ils sont donnés sous réserve de modifications ayant été apportées depuis leur mise en ligne. Par ailleurs, tous les informations indiquées sur le site www.kgougle.nc<span style="color: #000000;"><b> </b></span>sont données à titre indicatif, et sont susceptibles de changer ou d’évoluer sans préavis.
			</div>
			<h3 class=" explainTitle"> Hébergement </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				<p style="color: #b51a00;"><span style="color: rgb(0, 0, 0);"><b>Limitation contractuelles sur les données : </b></span></p>
				Les informations contenues sur ce site sont aussi précises que possibles et le site remis à jour à différentes périodes de l’année, mais peut toutefois contenir des inexactitudes ou des omissions. Si vous constatez une lacune, erreur ou ce qui parait être un dysfonctionnement, merci de bien vouloir le signaler par email, à l’adresse tango@communecter.org, en décrivant le problème de la manière la plus précise possible (page posant problème, type d’ordinateur et de navigateur utilisé, …).
				<br/><br/>
				Tout contenu téléchargé se fait aux risques et périls de l'utilisateur et sous sa seule responsabilité. En conséquence, ne saurait être tenu responsable d'un quelconque dommage subi par l'ordinateur de l'utilisateur ou d'une quelconque perte de données consécutives au téléchargement. <span style="color: #323333;">De plus, l’utilisateur du site s’engage à accéder au site en utilisant un matériel récent, ne contenant pas de virus et avec un navigateur de dernière génération mis-à-jour</span>
				<br/><br/>
				Les liens hypertextes mis en place dans le cadre du présent site internet en direction d'autres ressources présentes sur le réseau Internet ne sauraient engager la responsabilité de Association Open Atlas.
			</div>

			<h3 class=" explainTitle"> Propriété intellectuelle </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				Tout le contenu du présent sur le site <a href="http://www.kgougle.nc">www.kgougle.nc</a>, incluant, de façon non limitative, les graphismes, images, textes, vidéos, animations, sons, logos, gifs et icônes ainsi que leur mise en forme sont la propriété exclusive de la société à l'exception des marques, logos ou contenus appartenant à d'autres sociétés partenaires ou auteurs.
				<br/><br/>
				Toute reproduction, distribution, modification, adaptation, retransmission ou publication, même partielle, de ces différents éléments est strictement interdite sans l'accord exprès par écrit de Association Open Atlas. Cette représentation ou reproduction, par quelque procédé que ce soit, constitue une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle. Le non-respect de cette interdiction constitue une contrefaçon pouvant engager la responsabilité civile et pénale du contrefacteur. En outre, les propriétaires des Contenus copiés pourraient intenter une action en justice à votre encontre.
			</div>

			<h3 class=" explainTitle"> Déclaration à la CNIL </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				Conformément à la loi 78-17 du 6 janvier 1978 (modifiée par la loi 2004-801 du 6 août 2004 relative à la protection des personnes physiques à l'égard des traitements de données à caractère personnel) relative à l'informatique, aux fichiers et aux libertés, ce site a fait l'objet d'une déclaration  auprès de la Commission nationale de l'informatique et des libertés (<a href="http://www.cnil.fr/">www.cnil.fr</a>).
			</div>

			<h3 class=" explainTitle"> Litiges </h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				Les présentes conditions du site <a href="http://www.kgougle.nc">www.kgougle.nc</a> sont régies par les lois françaises et toute contestation ou litiges qui pourraient naître de l'interprétation ou de l'exécution de celles-ci seront de la compétence exclusive des tribunaux dont dépend le siège social de la société. La langue de référence, pour le règlement de contentieux éventuels, est le français.
			</div>

			<h3 class=" explainTitle"> Données personnelles</h3>
			<center class="caretExplain"><i class="fa fa-caret-down"></i><br/></center>
			<div class="explainDesc">
				De manière générale, vous n’êtes pas tenu de nous communiquer vos données personnelles lorsque vous visitez notre site Internet <a href="http://www.kgougle.nc">www.kgougle.nc</a>.
				<br/><br/>
				Cependant, <!-- ce principe comporte certaines exceptions. En effet, pour certains services proposés par notre site, vous pouvez être amenés à nous communiquer certaines données telles que : votre nom, votre fonction, le nom de votre société, votre adresse électronique, et votre numéro de téléphone. Tel est le cas lorsque vous remplissez le formulaire qui vous est proposé en ligne, dans la rubrique « contact ». Dans tous les cas, vous pouvez refuser de fournir vos données personnelles. Dans ce cas, vous ne pourrez pas utiliser les services du site, notamment celui de solliciter des renseignements sur notre société, ou de recevoir les lettres d’information.
				<br/><br/>
				Enfin,  -->nous pouvons collecter de manière automatique certaines informations vous concernant lors d’une simple navigation sur notre site Internet, notamment : des informations concernant l’utilisation de notre site, comme les zones que vous visitez et les services auxquels vous accédez, votre adresse IP, le type de votre navigateur, vos temps d'accès. De telles informations sont utilisées exclusivement à des fins de statistiques internes, de manière à améliorer la qualité des services qui vous sont proposés. Les bases de données sont protégées par les dispositions de la loi du 1er juillet 1998 transposant la directive 96/9 du 11 mars 1996 relative à la protection juridique des bases de données.
			</div>
		</div>
    </div>
</section>



<?php $this->renderPartial($layoutPath.'footer',  array( "subdomain"=>"info" ) ); ?>

<script>

jQuery(document).ready(function() {
    initKInterface();
    location.hash = "#info.p.mention";
});

</script>