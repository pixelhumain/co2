<?php $this->renderPartial('../docs/panels/menuLink',array("url"=>"default/view/page/links")); ?>
<div class="panel-heading border-light center text-dark partition-white radius-10">
	<span class="panel-title homestead"> <i class='fa fa-heart text-red faa-pulse animated fa-3x  '></i> <span style="font-size: 48px">PHILOSOPHY</span></span>
</div>
<div class="space20"></div>
<div class="keywordList"></div>

<script type="text/javascript">

var keywords = [
	
	{
		"icon" : "fa-lightbulb-o",
		"title":"Reseau societal",
		"body":"Un reseau societal pour retrouver nos biens communs"+
			"<br>Voir la société par les communs"+
			"<br>Experimentons un autre vision du système"+
			"<br>Le système peut il fonctionner autrement ?"+
			"<br>Une expérience collective"
	},
	{
		"icon" : "fa-code",
		"title":"Open source",
		"body":'<span class="bold">'+
			'<br>1. We believe in an open exchange. '+
			'<br>2. We believe in the power of participation. '+
			'<br>3. We believe in rapid prototyping.'+
			'<br>4. We believe in meritocracy. '+
			'<br>5. We believe in community'+
			'</span><br><br>'+
			'<br><a class="btn btn-danger" href="http://www.framablog.org/index.php/post/2011/09/28/the-open-source-way" target="_blanck">the-open-source-way</a>'
	},
	{
		"icon" : "fa-code",
		"title":"Open Système",
		"body":"Notre réseau se veut être un des acteurs qui transforment la société en l'impactant pour qu'elle s’oriente naturellement vers un fonctionnement plus collaboratif et participatif par la mise en pratique concrète de notre intelligence collective. L'écosystème incarne ainsi un élan collectif de mise en commun et de création de communs comme nouveau modèle sociétal.<br>"+
			'<br><a class="btn btn-danger" href="https://github.com/pixelhumain/buildingCommons/blob/master/codeSocialOpenSystem.md" target="_blanck">En Savoir Plus</a>'
	},
	{
		"icon" : "fa-lightbulb-o",
		"title":"C'est pas un parti politique",
		"body":"C'est pas un parti, c'est un projet"+
			"<br>qui veut 'juste' unir tous le monde."
	},
	{
		"icon" : "fa-lightbulb-o",
		"title":"Rien ne l'arrete",
		"body":"Quand l'objectif est le chagnement "+
			"<br>et que c'est pas juste un slogan "+
			"<br>rien ne l'arretera tant qu'on ne le vivra pas "+
			"<br>on continuera à chercher"
	},
	{
		"icon" : "fa-heart text-red",
		"title":"Art is the heart of our culture",
		"body":""
	},
];
	
jQuery(document).ready(function() 
{
	$(".keywordList").html('');
	$.each(keywords,function(i,obj) { 
		icon = (obj.icon) ? obj.icon : "fa-tag" ;
		color = (obj.color) ? obj.color : "#E33551" ;
		$(".keywordList").append(
		'<div class="col-xs-4 panel-white">'+
			'<div class="panel-heading border-light ">'+
				'<span class="panel-title homestead"> <i class="fa '+icon+'  fa-2x"></i> <span style="font-size: 35px; color:'+color+';"> '+obj.title.toUpperCase()+'</span></span>'+
			'</div>'+
			'<div class="panel-body">'+
				'<blockquote class="space20">'+
					obj.body+
				 "</blockquote>"+
			"</div>"+
		"</div>");
	 });
});

</script>

