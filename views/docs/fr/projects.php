

<style type="text/css">
	.keypane{min-height: 400px;}
</style>
<div id="header-docs" class="panel-heading border-light center text-dark partition-white radius-10">
    <span class="panel-title">  
    	<i class='fa fa-lightbulb-o faa-pulse animated'></i> NOS PROJETS<br>
    	<span class="sub-title">CITATIONS LOREM ISPSUM</span>
    </span>
</div>
<div class="space20"></div>
<div class="keywordList"></div>
<!--<div class="col-xs-4 keypane">
	<h1><i class="text-red fa fa-cube"></i> PIXEL HUMAIN </h1>
	<div>
		Un collectif d'acteurs oeuvrant pour les communs
		<br>l'ancien nom de communecter
		<br>Innovation au service des biens communs
		<br><u><a class="text-white" href="#" onclick="toastr.error('TODO : ajax form load form')"><i class="fa fa-mail"></i> Contact Us </a> </u>
		<br>Respectant un CODE SOCIAL ET LOGICIEL ouvert
		<br>Open Source, Semantique et Interopérable
		<br>Le Lien entre le réél et le virtuel
	</div>
</div>-->

<!--<div class="col-xs-4 keypane">
	<h1><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/CO2r.png" height=50> Communecter </h1>
	<div>
		Un Réseau Sociétale Libre et Open Source 
		<br>un dispositif de réseau sociétal local catalyseur d'une synergie régionale, collective et solidaire reliant tous types d’acteurs (Entreprises, Associations, Collectivités et citoyens), tous domaines et objectifs confondus.
		<br>La plateforme est un service d'aide à la population pour améliorer la valorisation des acteurs locaux pour produire un térritoire connecté.
		<br>Un outil de communication entre citoyens et collectivités.
		<br>Un outil de production et de visualisation d'open data pour mieux analyser et décider sur un térritoire.
		<br>Une boite outil citoyenne pour encourager , faciliter et dynamiser l'implication citoyenne.
		<br>le CTK : Citizen Tool Kit , Un socle technique et modulaire pour construire toutes sorte d'outils citoyens et administratifs spécialisés
	</div>
</div>-->


<script type="text/javascript">
	var keywords = [
	{
		"icon" : "fa-globe",
		"title":"Smarterre",
		"body":"Apporter de la croissance aux organisations locales avec une vision humaine, intégrer un projet de société locale pour les générations futures qui prend en compte l’obsolescence et la finitude des ressources<br><a class='btn btn-danger btn-sm' href='javascript:;' onclick='navInDocs(\"smarterre\", \"<?php echo Yii::app()->language ?>\" );'>En savoir plus </a>"
	},
	{
		"icon" : "fa-cogs",
		"title":"FABLAB.re",
		"body":"Fablab de bidouilleurs réunionais qui auront bientot un bus et un tiers lieux"
	},
	{
		"icon" : "fa-connectdevelop",
		"title":"Open Système",
		"body":"Expérimentation de gouvernance totalement horizontale<br>Opensource<br>Conseil Collégiale<br><a class='btn btn-danger btn-sm' href='https://chat.lescommuns.org/channel/marqueblanche' target='_blank'>En savoir plus </a>"
	},
	{
		"icon" : "fa-bus",
		"title":"CO BUS",
		"body":"Un bus itinérant Communecté<br>sponsorisé par l'AFNIC<br>rempli d'electronique<br>autonome energiquement<br>pour agir dans les zones prioritaires et déconnecté<br><a class='btn btn-danger btn-sm' href='https://chat.lescommuns.org/channel/co_bus' target='_blank'>En savoir plus </a>"
	},
	{
		"icon" : "fa-wifi",
		"title":"CO PI",
		"body":"CO : Communecter + PI : Raperi Pi<br>Un serveur Low Tech Communecter<br>fonctionne offline<br>sur un modèle distribué, interconnection entre COPI<br>servant tout les service de CO<br><a class='btn btn-danger btn-sm' href='https://chat.lescommuns.org/channel/copi' target='_blank'>En savoir plus </a>"
	},
	{
		"icon" : "fa-wifi",
		"title":"FAI Libre Reunion",
		"body":"Installation d'un FAI libre Réunionais<br>sponsorisé par l'AFNIC"
	},
	{
		"icon" : "fa-book",
		"title":"COopedia",
		"body":"R&D : Augmenter Wikipedia avec un référencement et une inteorpérabilité avec CO<br> Terrapedia : wikipedia territorial ouvert et contributif"
	},
	{
		"icon" : "fa fa-map-marker",
		"title":"Catographie en marque blanche",
		"body":"Une Interface et Cartographie<br>Configurable<br>Filtrable<br>R&D : sans base de donnée<br>Contributive<br><a class='btn btn-danger btn-sm' href='https://www.communecter.org/?network=BretagneTelecom' target='_blank'>Exemple : Bretagne Telecom</a>"	
	},
	{
		"icon" : "fa-cubes",
		"title":"Camp TIC",
		"body":"Equipement autonome et connecté pour partager l'activité d'un tiers lieux<br>sponsorisé par l'AFNIC<br>C'est un valise complète<br>Connectique réseau internet<br>Son et Video pour des visios partages<br>des Agenda partagé entre réseau de tiers lieux<br>partage de ressources, de besoins, de service et de compétence"
	},
	
];
jQuery(document).ready(function() 
{
	getConceptList(keywords, ".keywordList");
});

</script>