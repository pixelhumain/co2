<?php 

	HtmlHelper::registerCssAndScriptsFiles( array(	'/css/timeline2.css',
													'/js/comments.js',
											) , Yii::app()->theme->baseUrl. '/assets');

	    
	$cssAnsScriptFilesModule = array(
		'/js/news/autosize.js',
		'/js/news/newsHtml.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "media") ); 
?>

<style>
	#timeline-live{
		min-height:600px;
	}
	.btn-select-media-src img{
		height:40px;
	}

	.btn-show-map{ 
		display: none;
	}

@media screen and (max-width: 767px) {
	.btn-select-media-src img{
		height:30px;
	}
	
	.timeline::before,
	.timeline-badge{
		display: none;
	}
	ul.timeline > li > .timeline-panel{
		width: 90%;
	}
	.page-header.text-center,
	.show-sources-xs{
		text-align: right;
	}
	.timeline-body > p, 
	.timeline-body > ul, 
	.timeline-body > h4{
		font-size:12px;
	}
	
}

</style>
<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding">

	<!-- <div class="col-md-12 col-sm-12 col-xs-12 no-padding row-radio" style="background-color: #f8f8f8;">
		<?php //$this->renderPartial($layoutPath.'radioplayer', array( "layoutPath"=>$layoutPath ) ); ?>  
	</div> -->

	
	<div class="col-md-12 col-sm-12 inline show-sources-xs text-center margin-top-20 visible-xs">
		<button class="btn btn-default" id="btn-show-sources-xs"><i class="fa fa-rss"></i></button>
	</div>
	<div class="col-md-12 col-sm-12 inline page-header text-center medias-sources margin-top-20 hidden-xs">
		<div class="col-md-1 hidden-sm hidden-xs bg-white"></div>
		<div class="col-md-2 col-sm-2 col-xs-12 bg-white">
		<button class="btn btn-link tooltips btn-select-media-src srcNC1" data-srcactive="true" data-srcid="NC1" data-placement="top" data-toggle="tooltip" title="Cliquer pour activer/désactiver">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/medias/NC1.png">
			<br class="hidden-xs"><i class="fa fa-check-circle letter-green srcActive"></i>
			<i class="fa fa-minus-circle letter-red srcDisable hidden"></i>
		</button>
		</div>

		<div class="col-md-2 col-sm-2 col-xs-12 bg-white">
		<button class="btn btn-link tooltips btn-select-media-src srcNCTV" data-srcactive="true" data-srcid="NCTV" data-placement="top" data-toggle="tooltip" title="Cliquer pour activer/désactiver">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/medias/NCTV.png">
			<br class="hidden-xs"><i class="fa fa-check-circle letter-green srcActive"></i>
			<i class="fa fa-minus-circle letter-red srcDisable hidden"></i>
		</button>
		</div>

		<div class="col-md-2 col-sm-2 col-xs-12 bg-white">
		<button class="btn btn-link tooltips btn-select-media-src srcNCI" data-srcactive="true" data-srcid="NCI" data-placement="top" data-toggle="tooltip" title="Cliquer pour activer/désactiver">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/medias/NCI.png">
			<br class="hidden-xs"><i class="fa fa-check-circle letter-green srcActive"></i>
			<i class="fa fa-minus-circle letter-red srcDisable hidden"></i>
		</button>
		</div>

		<div class="col-md-2 col-sm-2 col-xs-12 bg-white">
		<button class="btn btn-link tooltips btn-select-media-src srcTAZAR" data-srcactive="true" data-srcid="TAZAR" data-placement="top" data-toggle="tooltip" title="Cliquer pour activer/désactiver">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/medias/TAZAR.png">
			<br class="hidden-xs"><i class="fa fa-check-circle letter-green srcActive"></i>
			<i class="fa fa-minus-circle letter-red srcDisable hidden"></i>
		</button>
		</div>

		<div class="col-md-2 col-sm-2 col-xs-12 bg-white">
		<button class="btn btn-link tooltips btn-select-media-src srcOUTREMERS360" data-srcactive="true" data-srcid="OUTREMERS360" data-placement="top" data-toggle="tooltip" title="Cliquer pour activer/désactiver">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/medias/OUTREMERS360.png">
			<br class="hidden-xs"><i class="fa fa-check-circle letter-green srcActive"></i>
			<i class="fa fa-minus-circle letter-red srcDisable hidden"></i>
		</button>
		</div>

	</div>

	<div class="col-md-2 col-sm-1 hidden-xs no-padding" id="content-media" style="min-height: 500px;">
	</div>

	<div class="col-md-8 col-sm-10 inline-block no-padding">
		<div class="col-md-12 no-padding text-center" id="timeline-reload"></div>
		<ul class="timeline inline-block" id="timeline-live">
			<?php  
				if(@$medias && sizeOf($medias) > 0)
				$this->renderPartial('liveStream', array("medias"=>$medias)); 
			?>
		</ul>
	</div>


</div>



<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"media")); ?>

<script type="text/javascript" >
var loadingData = false;
var scrollEnd = false;

var currentIndexMin = 0;
var currentIndexMax = 10;

var indexStep = currentIndexMax;

//var medias = <?php //echo json_encode($medias); ?>;

var idSession = "<?php echo @Yii::app()->session["userId"] ?>";

//permet d'ajouter des commentaires sur n'importe quel data (collection)
var parentTypeComment = "media";

jQuery(document).ready(function() {

    initKInterface();
    initMediaInterface();
    
	//initCommentsTools(medias);

});


function initMediaInterface(){
	//init loading in scroll
    $(window).bind("scroll",function(){ 
	    if(!loadingData && !scrollEnd){
	          var heightWindow = $("html").height() - $("body").height();
	          if( $(this).scrollTop() >= heightWindow - 400){
	            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep);
	          }
	    }
	});

	$(".btn-select-media-src").click(function(){
		var src = $(this).data("srcid");
		var srcActive = $(this).data("srcactive");
		console.log("srcactive", srcActive, sources);
		if(srcActive==true){
			if(sources.length == 1){
				//toastr.error("Looooongin ! Impossible de désactiver toutes les sources en même temps !");
				/*setTimeout(function(){
					toastr.error("Nan mé... t'as cru koi ?");
					setTimeout(function(){
						toastr.error("Fou la flème !..");
					}, 1000);
				}, 1500);*/
				return;
			}
			for(var i = sources.length; i--;){
				if (sources[i] === src) sources.splice(i, 1);
				$(this).data("srcactive", false);
				$(".src"+src+" .srcActive").addClass("hidden");
				$(".src"+src+" .srcDisable").removeClass("hidden");
			}
		}else{
			sources.push(src);
			$(this).data("srcactive", true);
			$(".src"+src+" .srcActive").removeClass("hidden");
			$(".src"+src+" .srcDisable").addClass("hidden");
		}
		startReloadTimeout();
		console.log("srcactive", srcActive, sources);
		
	});

    //btn to load media data for first time (if no media found)
	$("#main-btn-start-search, #main-search-bar-addon, .menu-btn-start-search").click(function(){
		$("#timeline-live").html("");
		loadStream(0, indexStep);
	});

    $("#second-search-bar").keyup(function(e){
        $("#main-search-bar").val($("#second-search-bar").val());
        $("#input-search-map").val($("#second-search-bar").val());
        if(e.keyCode == 13){
            $("#timeline-live").html("");
			loadStream(0, indexStep);
         }
    });
    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($("#main-search-bar").val());
        $("#input-search-map").val($("#main-search-bar").val());
        if(e.keyCode == 13){
            $("#timeline-live").html("");
			loadStream(0, indexStep);
         }
    });
    $("#input-search-map").keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        $("#main-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            $("#timeline-live").html("");
			loadStream(0, indexStep);
         }
    });

    $("#menu-map-btn-start-search, #main-search-bar-addon").click(function(){
        $("#timeline-live").html("");
			loadStream(0, indexStep);
    });

   	$('#main-search-bar, #second-search-bar, #input-search-map').filter_input({regex:'[^@#\"\`/\(|\)/\\\\]'}); //[a-zA-Z0-9_] 
    

    $("#btn-show-sources-xs").click(function(){
    	if($(".medias-sources").hasClass("hidden-xs")){
    		$(".medias-sources").removeClass("hidden-xs");
    	}else{
    		$(".medias-sources").addClass("hidden-xs");
    	}
    });
}


var interval;
function startReloadTimeout(){
	$("#timeline-live").html("");
	$("#timeline-reload").html("<i class='fa fa-circle'></i> "+
								"<i class='fa fa-circle'></i> "+
								"<i class='fa fa-circle'></i>"+
								"<hr style='margin-top: 34px;'>");
        var sec = 3;
        if(typeof interval != "undefined") clearInterval(interval);
        interval = setInterval(function(){ 
        	if(sec == 1){
        		loadStream(0, indexStep);
        		$("#timeline-reload").html("");
				$("#timeline-live").html("");
        		clearInterval(interval);
        	}
        	else{
        		sec--;
        		var str = "";
        		for(n=0;n<sec;n++) str += "<i class='fa fa-circle'></i> ";
        		str += "<hr style='margin-top: 34px;'>";
        		$("#timeline-reload").html(str);
        	}
        }, 800);
}


var sources = new Array("NC1", "NCI", "NCTV", "TAZAR", "OUTREMERS360");

function loadStream(indexMin, indexMax){ console.log("load stream media");
	if(indexMin == 0) scrollEnd = false;

	loadingData = true;
	currentIndexMin = indexMin;
	currentIndexMax = indexMax;
	var search = $("#main-search-bar").val();


    if(indexMin == 0){
    	$("#timeline-live").html("");
       	KScrollTo("#content-media");
    }

	$.ajax({ 
        type: "POST",
        url: baseUrl+"/"+moduleId+"/app/media",
        data: { indexMin: indexMin, 
        		indexMax:indexMax,
        		sources: sources,
        		search: search, 
        		renderPartial:true
        	},
        success:
            function(html) {
                $("#timeline-live").append(html);
                $(".medias-sources").hasClass("hidden-xs");
                loadingData = false;
            },
        error:function(xhr, status, error){
            loadingData = false;
            $("#timeline-live").html("erreur");
        },
        statusCode:{
                404: function(){
                	loadingData = false;
                    $("#timeline-live").html("not found");
            }
        }
    });
}


//lance le chargement des commentaires pour une publication
function showMediaComments(id){
		if(!$("#commentContent"+id).hasClass("hidden")){
			$(".commentContent").html("");
			$(".commentContent").removeClass("hidden");		
			
			$('#commentContent'+id).html('<div class="text-dark margin-bottom-10"><i class="fa fa-spin fa-refresh"></i> Chargement des commentaires ...</div>');
			getAjax('#commentContent'+id ,baseUrl+'/'+moduleId+"/comment/index/type/media/id/"+id,function(){ 
				
			},"html");
		}else{
			$("#commentContent"+id).removeClass("hidden");		
			mylog.log("scroll TO : ", $('#newsFeed'+id).position().top);
			
		}
}

/* COMMENTS vvv */


function initCommentsTools(thisMedias){
  //ajoute la barre de commentaire & vote up down signalement sur tous les medias
  $.each(thisMedias, function(key, media){
    media.target = "media";
    
    var commentCount = 0;
    idMedia=media._id['$id'];
    if ("undefined" != typeof media.commentCount) 
      commentCount = media.commentCount;
    
    idSession = typeof idSession != "undefined" ? idSession : false;

    var lblCommentCount = '';
    if(commentCount == 0 && idSession) lblCommentCount = "<i class='fa fa-comment'></i>  Commenter";
    if(commentCount == 1) lblCommentCount = "<i class='fa fa-comment'></i> <span class='nbNewsComment'>" + commentCount + "</span> commentaire";
    if(commentCount > 1) lblCommentCount = "<i class='fa fa-comment'></i> <span class='nbNewsComment'>" + commentCount + "</span> commentaires";
    if(commentCount == 0 && !idSession) lblCommentCount = "0 <i class='fa fa-comment'></i> ";

    lblCommentCount = '<a href="javascript:" class="newsAddComment letter-blue" data-media-id="'+idMedia+'">' + lblCommentCount + '</a>';

    var voteTools = voteCheckAction(media._id['$id'], media);

    voteTools = lblCommentCount + voteTools;

    $("#footer-media-"+media._id['$id']).html(voteTools);
  });

  $(".newsAddComment").click(function(){
    var id = $(this).data("media-id");
    showMediaComments(id);
  });
}

/* COMMENTS ^^^ */
</script>