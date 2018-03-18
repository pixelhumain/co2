<div id="contentBanner" class="col-md-12 col-sm-12 col-xs-12 no-padding">
	<?php if (@$element["profilBannerUrl"] && !empty($element["profilBannerUrl"])){	
		$imgHtml='<img class="col-md-12 col-sm-12 col-xs-12 no-padding img-responsive" 
					src="'.Yii::app()->createUrl('/'.$element["profilBannerUrl"]).'">';
		if (@$element["profilRealBannerUrl"] && !empty($element["profilRealBannerUrl"])){ ?>
			<style>
				#content-header{
					margin-top: -150px;
				}
			</style>
			<a  href="<?php echo Yii::app()->createUrl('/'.$element["profilRealBannerUrl"]); ?>"
				class="thumb-info"  
				data-title="<?php echo Yii::t("common","Cover image of")." ".$element["name"]; ?>"
				data-lightbox="all">
				<?php echo $imgHtml; ?>
			</a>
		<?php } ?>
	<?php } ?>
</div>