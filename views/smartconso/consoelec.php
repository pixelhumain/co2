<?php 

    $cssAnsScriptFilesModule = array(
    '/assets/css/default/search.css',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

    $cssAnsScriptFilesModule = array(
    //'/js/default/search.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

    $page = "smartconso";

    //header + menu
    $this->renderPartial($layoutPath.'header', 
                            array(  "layoutPath"=>$layoutPath ,
                                    "page" => $page,
                                    "type" => @$type) ); 
?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-white pageContent margin-top-50 padding-bottom-50">
	<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10 col-sm-12 col-xs-12 no-padding">
		Hello Conso Elec
	</div>
</div>




<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array()); ?>

<script type="text/javascript" >

var titlePage = "<?php echo Yii::t("common",@$params["pages"]["#".$page]["subdomainName"]); ?>";

jQuery(document).ready(function() {

    setTitle("", "", titlePage);
    initKInterface({"affixTop":320});

});

</script>