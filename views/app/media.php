<?php 

	HtmlHelper::registerCssAndScriptsFiles( array(	'/css/timeline2.css',
													'/js/comments.js',
											) , Yii::app()->theme->baseUrl. '/assets');

	    
	$cssAnsScriptFilesModule = array(
		'/js/news/autosize.js',
		'/js/news/newsHtml.js',
		'/js/default/media.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "actu") ); 
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

	<div class="col-md-1 col-sm-1 hidden-xs no-padding" id="content-media" style="min-height: 500px;">
	</div>

	<div class="col-md-10 col-sm-10 inline-block no-padding">
		<div class="col-md-12 no-padding text-center" id="timeline-reload"></div>
		<ul class="timeline inline-block" id="timeline-live">
			<?php  
				if(@$medias && sizeOf($medias) > 0)
				$this->renderPartial('liveStream', array("medias"=>$medias)); 
			?>
		</ul>
	</div>


</div>

<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array("subdomain"=>"media")); ?>

<script type="text/javascript" >
var loadingData = false;
var scrollEnd = false;

var currentIndexMin = 0;
var currentIndexMax = 10;

var indexStep = currentIndexMax;

var idSession = "<?php echo @Yii::app()->session["userId"] ?>";

//permet d'ajouter des commentaires sur n'importe quel data (collection)
var parentTypeComment = "media";
var interval;

jQuery(document).ready(function() {
    initKInterface();
    initMediaInterface(); 
	//initCommentsTools(medias);
});


</script>