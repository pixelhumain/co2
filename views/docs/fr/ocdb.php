<div id="header-docs"  class="panel-heading border-light center text-dark partition-white radius-10 ">
	<span class="panel-title"> 
		<i class='fa fa-database text-red faa-pulse animated'></i> Open Common DataBase<br>
		<!--<span class="sub-title text-red">"Art is the heart of our culture"</span>-->
	</span>
	<span class="panel-body">Un système d'information fait pour le partage, l'opendata, contributif et représentatif des actions et des activités de la société.</span>
</div>
<!--<div class="panel-heading border-light center text-dark partition-white radius-10">
    <span class=" text-red tpl_title"> Open Common DataBase</span>
    <br/>
    <span class="tpl_shortDesc">Un système d'information fait pour le partage, l'opendata, contributif et représentatif des actions et des activités de la société.</span>
</div>-->

<style type="text/css">
    ul li {list-style: none}
    .tpl_title{font-size: 48px;}
     .panel-title {font-size:25px;}
    .points{padding-left:10px;}
</style>
<div class="col-sm-12 ">
    <div class="panel panel-white ">
        <div class="panel-body tpl_content">
          	<div class="keywordList"></div>
        	<img src="<?php echo $this->module->assetsUrl; ?>/images/docs/ocdb.png"" class="col-sm-12 img-responsive ">
	    </div>
    </div>
</div>
<script type="text/javascript">
	var keywords = [
		{
			"icon" : "fa-share-alt",
			"title":"Partager",
			"body":"<i class='fa fa-check'></i> Un cluster d'instances libres<br>"+
					"<i class='fa fa-check'></i> Un système d'interopérabilité ouvert<br>"+
					"<i class='fa fa-check'></i> Des aggrégateurs pour réunir les sources<br>"+
					"<i class='fa fa-check'></i> Produire de l'opendata, c'est pouvoir l'utiliser"
		},
		{
			"icon" : "fa-book",
			"title":"Des standards",
			"body":"<i class='fa fa-check'></i> Restfull Api standard pour utiliser le contenu<br>"+
					"<i class='fa fa-check'></i> Un moteur de traduction multi ontologies<br>"+
					"<i class='fa fa-check'></i> Des ontologies standards"
		},
		{
			"icon" : "fa-cogs",
			"title":"Outils",
			"body":"<i class='fa fa-check'></i> Recherche une ou toutes les instances OCDB<br>"+
					"<i class='fa fa-check'></i> Couplage OCDB, Wikipedia, OSM<br>"+
					"<li><i class='fa fa-check'></i> Paysan Numérique : Curation, Récolte, Croisement"
		}
	];
	jQuery(document).ready(function(){
		getConceptList(keywords, ".keywordList");
	});

</script>