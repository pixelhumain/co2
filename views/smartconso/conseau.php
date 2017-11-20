<?php 

    $cssAnsScriptFilesModule = array(
    //'/assets/css/default/search.css',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

    $cssAnsScriptFilesModule = array(
    '/js/smartconso/smartconso.js',
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

        <?php $this->renderPartial('../smartconso/smartheader', 
                            array(  "title"=>"Cons'eau'" ,
                                    "subtitle"=>"Consommation d'eau provenant quotidiennement de la télérelève") );  
        ?>
		
        <div class="col-xs-12 col-sm-6 col-md-3" id="">
            <canvas id="smartPie1"/>
        </div>
        
        <div class="col-xs-12 col-sm-6 col-md-3" id="">
            <canvas id="smartPie2"/>
        </div>
        
        <div class="col-xs-12 col-sm-6 col-md-3" id="">
            <canvas id="smartPie3"/>
        </div>
        
        <div class="col-xs-12 col-sm-6 col-md-3" id="">
            <canvas id="smartPie4"/>
        </div>

	</div>
</div>




<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array()); ?>

<script type="text/javascript" >

var titlePage = "<?php echo Yii::t("common",@$params["pages"]["#".$page]["subdomainName"]); ?>";

jQuery(document).ready(function() {

    setTitle("", "", titlePage);
    initKInterface({"affixTop":320});

    smartChartInit("smartPie1", chartValues, "pie");
    smartChartInit("smartPie2", chartValues, "line");
    smartChartInit("smartPie3", chartValues, "bar");
    smartChartInit("smartPie4", chartValues, "radar");
});

</script>