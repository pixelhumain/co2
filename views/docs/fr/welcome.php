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
    .videoWrapper iframe{
    	width: 100%;
    	height: auto;
    }
.wrapper         {width:100%;height:100%;margin-top: 20px;}
.h_iframe        {position:relative;}
.h_iframe .ratio {display:block;width:100%;height:auto;}
.h_iframe iframe {position:absolute;top:0;left:0;width:100%; height:100%;background-color: white;}
</style>
<div id="header-docs"  class="panel-heading border-light center text-dark partition-white radius-10 ">
	<span class="panel-title"> 
		Moteur de Recherche Territorial<br>
		<span class="sub-title text-red">Piloté par Open Atlas et développé par des contributeurs du monde entier.</span>
	</span>
</div>

<div class="pageContent margin-top-50">
	<div class="keywordActors"></div>
	<div class="wrapper col-md-12 col-sm-12 col-xs-12 no-padding">
    	<div class="h_iframe">
        <!-- a transparent image is preferable -->
        <img class="ratio" src="http://placehold.it/16x9"/>
        <iframe src="https://player.vimeo.com/video/133636468?api=1&title=0&amp;byline=0&amp;portrait=0&amp;color=57c0d4" frameborder="0" allowfullscreen></iframe>
    	</div>
    	
	</div>
	<div class="content-section-for section-3 col-md-12 col-sm-12 col-xs-12 no-padding margin-top-50">
		<img src="<?php echo $this->module->assetsUrl; ?>/images/docs/<?php echo Yii::app()->language ?>/notebooks-1-1.png" width="100%"/>
	</div>	
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
jQuery(document).ready(function() {
	getConceptList(keyActors, ".keywordActors");
	openVideo();

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
	//$("#homeImg").fadeOut("slow",function() {
		$(".videoWrapper").fadeIn('slow');
	//});
}



</script>
