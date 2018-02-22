<?php
//$communexion = CO2::getCommunexionCookies(); 
?>
<style>
	.contact-map {	
		background:url(<?php echo $this->module->assetsUrl; ?>/images/people.jpg) bottom center repeat-x; 
		background-size: 60%;
		background-color:#DFE7E9;  
	}
	.headSection {	
		background:url(<?php echo $this->module->assetsUrl; ?>/images/1+1=3.jpg?c=c) bottom center no-repeat; 
		background-size: 80%;
		background-color:#fff;  
	}
	/*#mainNav .dropdown-result-global-search{
        top:56px !important;
        left:83px !important;
    }*/
    @media (min-width: 767px) and (max-width: 992px) {
        #mainNav .dropdown-result-global-search{
            width:40% !important;
        }
    } 
    
    /*.punch-line-container{
    	color:#28262b
    	text-align:center;	
    }
    .punch-line-container h1{
    	font-size: 35px;
    	font-weight: 600;
    	font-variant: small-caps;
	    text-transform: initial;
    }
    .punch-line-container span{
    	font-size: 16px;
    	font-style: italic;
    	color: #777;
    }*/
    /*.videoWrapper iframe{
    	width: 100%;
    	height: auto;
    }*/
   .videoWrapper{
   	display: none;
   }
.videoWrapper         {width:100%;height:100%;margin-top: 20px;}
.h_iframe        {position:relative;}
.h_iframe .ratio {display:block;width:100%;height:auto;}
.h_iframe iframe {position:absolute;top:0;left:0;width:100%; height:100%;background-color: white;}
.videoSignal{
	position: absolute;
    width: 100%;
    line-height: 100px;
    height: 100%;
    top: 0px;
    background-color: rgba(0,0,0,0.2);
    left: 0px;
}
.videoSignal:hover{
	background-color: rgba(0,0,0,0.0);
}
/*.videoSignal a {
	
}*/
.videoSignal:hover span{
background-color: #09adef;
}

.videoSignal:hover span > i{
	color: white;
}
.videoSignal span{
 	width: 130px;
    margin: auto;
    height: 75px;
    background-color: rgba(0,0,0,0.6);
    bottom: 0;
    padding: 20px 40px;
    left: 0;
    text-align: center;
    position: absolute;
    right: 0;
    font-size: 100px;
    top: 0%;
    border-radius: 13px;
}
.videoSignal span > i  { 
	color: white;
    font-size: 50%;
    position: relative;
    margin: auto;
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    font-size: 37px;
    padding: 20px 40px;
    top: 0px;
}
.keywordActors .panel-body{
	min-height: inherit;
}
</style>
<div id="header-docs"  class="panel-heading border-light center text-dark partition-white radius-10 ">
	<span class="panel-title"> 
		Moteur de Recherche Territorial<br>
		<span class="sub-title text-red">Piloté par Open Atlas et développé par des contributeurs du monde entier.</span>
	</span>
</div>

<div class="pageContent margin-top-20">
	<div id="videoDocsImg" class="col-md-12 col-sm-12 col-xs-12 no-padding">
    	<img class="img-responsive" src="<?php echo $this->module->assetsUrl; ?>/images/docs/image_video.png"/>
    	<a href="javascript:;" class="videoSignal text-white center"><span><i class="fa fa-3x fa-play"></i></span></a>
	</div>
	<div class="videoWrapper col-md-12 col-sm-12 col-xs-12 no-padding">
    	<div class="h_iframe">
        <!-- a transparent image is preferable -->
        <img class="ratio" src="http://placehold.it/16x9"/>
        <iframe id="autoPlayVideo" src="https://player.vimeo.com/video/133636468?api=1&title=0&amp;byline=0&amp;portrait=0&amp;color=57c0d4" frameborder="0" allowfullscreen></iframe>
    	</div>
    	
	</div>
	
	<div class="keywordActors col-md-12 col-sm-12 col-xs-12 margin-top-50"></div>
	
	<div class="content-section-for section-3 col-md-12 col-sm-12 col-xs-12 no-padding margin-top-50">
		<img src="<?php echo $this->module->assetsUrl; ?>/images/docs/<?php echo Yii::app()->language ?>/notebooks-1-1.png" width="100%"/>
	</div>	
	<div class="keywordValues col-md-12 col-sm-12 col-xs-12 margin-top-50"></div>
	<div class="subtitleDocs panel-heading border-light center text-dark partition-white radius-10 ">
	<span class="panel-title"> 
		Les atouts de Communecter<br>
		<span class="sub-title text-red">Un réseau pas comme les autres</span>
	</span>
</div>
	<div class="keywordApps col-md-12 col-sm-12 col-xs-12 margin-top-50"></div>
</div>


<script type="text/javascript">
var keyActors = [
	{
		"icon" : "fa-street-view",
		"title":"Pour moi",
		"subtitle":"Je connais mon territoire",
		"body":"Je sais ce qu’il se passe autour de moi."
	},
	{
		"icon" : "fa-users",
		"title":"Pour ma communauté",
		"subtitle":"Je gère mon organisation",
		"body":"Je sais ce qu’il se passe autour de moi."
	},
	{
		"icon" : "fa-globe",
		"title":"Pour le bien commun",
		"subtitle":"Une intelligence collective en action",
		"body":"Je participe à la construction d’une base de connaissance territoriale."
	}
];
var keyValues = [
	{
		"icon" : "fa-code",
		"title":"Open source",
		"subtitle":"Communecter c'est un peu comme un gâteau",
		"body":"Tout comme une recette de cuisine que l’on s’échange, le code source de Communecter est consultable, partageable, ré-utilisable et améliorable."
	},
	{
		"icon" : "fa-share-alt",
		"title":"Bases de données partagées",
		"subtitle":"On est pas des vampires",
		"body":"Nous ne nous approprions pas vos données : nous les mettons en commun."
	},
	{
		"icon" : "fa-heart",
		"title":"Libre",
		"subtitle":"C'est comme un chapeau d'artiste",
		"body":"Vous pouvez consommer ce bien-commun librement. Nous vous invitons tout de même le soutenir pour qu'il garde son indépendance"
	},
	{
		"icon" : "fa-image",
		"title":"Pas de publicité",
		"subtitle":"Vie privée et tranquillité",
		"body":"Naviguer l’esprit tranquille : vous ne trouverez pas de publicités commerciales sur Communecter."
	},
	{
		"icon" : "fa-university",
		"title":"Un commun",
		"subtitle":"Une ressource gérée collectivement",
		"body":"La gouvernance du projet se fait de manière stimergique et transparente : vous avez une idée ? Présentez la et lancez vous ! Si l’idée est pertinente attendez vous à ce que d’autres contributeurs vous viennent en aide."
	},
	{
		"icon" : "fa-user-secret",
		"title":"Données protégées",
		"subtitle":"Le choix du partage",
		"body":"On vous laisse le choix de partager ou non vos données. C'est vous qui décidez"
	}
];
var keyApps = [
{
		"image" : moduleUrl+"/images/docs/comobi1.png",
		"title":"Application mobile",
		"url": "https://play.google.com/store/apps/details?id=org.communecter.mobile",
		"body":"Grâce à nos crowdfunders nous avons pu développer une application Android que vous pouvez télécharger ici."
	},
	{
		"image" : moduleUrl+"/images/docs/network_img.jpg",
		"url":"https://wiki.communecter.org/fr/network---cr%C3%A9er-une-carte.html",
		"title":"Cartographie personnalisée",
		"body":"Grâce au module Network vous pouvez créer vos propres cartes. Retrouvez toute la documentation en cliquant sur le bouton ci-dessous."
	},
	{
		"image" : moduleUrl+"/images/docs/copi.png",
		"url":"https://wiki.communecter.org/fr/installer-communecter-sur-un-raspberry-pi.html",
		"title":"Instance locale",
		"body":"Avec CoPi vous pouvez installer votre propre Communecter. Vos donnés sont stockés à portée de main et potentiellement partageable avec le reste de la communauté."
	},
	{
		"image" : moduleUrl+"/images/docs/Copedia.png",
		"url":"https://wiki.communecter.org/fr/interop%C3%A9rabilit%C3%A9.html",
		"title":"Interopérabilité",
		"body":"Communecter communique avec des bases de données ouvertes (ex : Wikipédia, Openstreetmap, …) pour utiliser leurs données en échange de notre contribution à leur bien commun."
	}
];
jQuery(document).ready(function() {
	getConceptList(keyActors, ".keywordActors");
	getConceptList(keyValues, ".keywordValues");
	getConceptList(keyApps, ".keywordApps");
	$(".videoSignal").click(function(){
		openVideo();
	});

});
function showPeopleTalk(step)
{
	// if(!step)
	// 	step = 1;
	// peopleTalkCt = peopleTalkCt+step;
	// if( undefined == peopleTalk[ peopleTalkCt ]  )
	// 	peopleTalkCt = 0;
	// person = peopleTalk[ peopleTalkCt ];

	var html = "";
	$.each(peopleTalk, function(key, person){
	html += '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 padding-5" style="min-height:430px;max-height:430px;">' +
				'<div class="" style="max-height:240px; overflow:hidden; max-width:100%;">' +
				'<img class="img-responsive img-thumbnail peopleTalkImg" src="'+person.image+'"><br>' +
				'</div>' +
				'<span class="peopleTalkName">'+person.name+'</span><br>' +
				'<span class="peopleTalkProject">'+person.project+'</span><br>' +
				'<span class="peopleTalkComment inline-block">'+person.comment+'</span>' +
			'</div>';
	});

	$("#co-friends").html( html );
	// $(".peopleTalkName").html( person.name );
	// $(".peopleTalkImg").attr("src",person.image);
	// $(".peopleTalkComment").html("<i class='fa fa-quote-left'></i> "+person.comment+"<i class='fa fa-quote-right'></i> ");
	// $(".peopleTalkProject").html( "<a target='_blank' href='"+person.url+"'>"+person.project+"</a>" );

}

function openVideo(){
	$("#videoDocsImg").fadeOut("slow",function() {
		$(".videoWrapper").fadeIn('slow');
		 var symbol = $("#autoPlayVideo")[0].src.indexOf("?") > -1 ? "&" : "?";
  		//modify source to autoplay and start video
  		$("#autoPlayVideo")[0].src += symbol + "autoplay=1";
	});
}



</script>
