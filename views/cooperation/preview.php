<?php 
	HtmlHelper::registerCssAndScriptsFiles( 
		array(  '/js/comments.js') , 
		Yii::app()->theme->baseUrl. '/assets');
 	

	$cssAnsScriptFilesTheme = array(
		"/plugins/Chart-2.6.0/Chart.min.js",
		"/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css"
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

 	//var_dump($data); exit;
 	$element = Element::getByTypeAndId($data[$type]["parentType"], $data[$type]["parentId"]);
 	$iconColor = Element::getColorIcon($data[$type]["parentType"]);
  	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';
	$thumbAuthor =  @$element['profilThumbImageUrl'] ? 
                      Yii::app()->createUrl('/'.@$element['profilThumbImageUrl']) 
                      : $this->module->assetsUrl.'/images/thumbnail-default.jpg';

    $slugParent = @$element["slug"] ? $element["slug"] : "#page.".$type.$data[$type]["parentType"].$element["_id"];
    $urlInCoSpace = "#".$slugParent.".view.coop.room.".$data[$type]["idParentRoom"].".".$type.".".$dataId;
?>

<style>
	#modal-preview-coop #coop-container{
		overflow-y: scroll;
		top:70px;
	}
	#modal-preview-coop #coop-data-container{
		border:0px;
	}
	#modal-preview-coop .btn-extend-proposal,
	#modal-preview-coop .btn-minimize-proposal,
	#modal-preview-coop .btn-extend-action,
	#modal-preview-coop .btn-minimize-action,
	#modal-preview-coop .btn-extend-resolution,
	#modal-preview-coop .btn-minimize-resolution{
		display: none;
	}
	#modalAssignMe,
	#ajax-modal{
		z-index:20000;
	}
</style>

<div class="modal-title shadow2 col-xs-12 no-padding" id="modalText">
	<img class="pull-left margin-right-15" src="<?php echo $thumbAuthor; ?>" height=68 width=68 style="">
	<!-- <h4 class="pull-left margin-top-15"><i class="fa fa-connectdevelop"></i> Espace coopératif</h4> -->
	 <div class="pastille-type-element margin-top-25 bg-<?php echo $iconColor; ?> pull-left"></div>
     <h4 class="pull-left margin-top-25">
	  <?php echo @$element["name"]; ?>
	</h4>  
	<a href="<?php echo $urlInCoSpace; ?>" 
	  class="btn btn-default pull-right hidden-xs lbh margin-top-15 margin-right-25 letter-turq bold">
		<i class="fa fa-chevron-right"></i> <?php echo Yii::t("cooperation", "open in CO space"); ?>
	</a>      	
</div>

<div id="coop-container" class="col-xs-12">
	<div id="coop-data-container" class="col-xs-12 no-padding">
		<div id="main-coop-container" class="col-xs-12 no-padding">
			<?php echo $this->renderPartial($type, $data); ?>
		</div>
	</div>
</div>