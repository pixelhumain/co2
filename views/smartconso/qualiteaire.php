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

    $chartList = array( "SO2 Montravel"     => array("color"=>"green"),
                        "SO2 Logicoop"      => array("color"=>"green"),
                        "SO2 Paul Boyer"    => array("color"=>"green"),
                        "SO2 Les Lys"       => array("color"=>"green"),
                        "PM10 Montravel"    => array("color"=>"red"),
                        "PM10 Logicoop"     => array("color"=>"red"),
                        "PM10 Paul Boyer"   => array("color"=>"red"),
                        "PM10 Les Lys"      => array("color"=>"red"),
                        "NO2 Montravel"     => array("color"=>"purple"),
                        "NO2 Logicoop"      => array("color"=>"purple"),
                        "NO2 Paul Boyer"    => array("color"=>"purple"),
                        "NO2 Les Lys"       => array("color"=>"purple"),
                        "O3 Paul Boyer"     => array("color"=>"blue"),
                        "03 Les Lys"        => array("color"=>"blue"));

     $datas = SmartData::getScalairData(250); 
?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-white pageContent margin-top-50 padding-bottom-50">
	<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10 col-sm-12 col-xs-12 no-padding">

        <?php $this->renderPartial('../smartconso/smartheader', 
                            array(  "title"=>"SCALAIR - Qualité de l'air" ,
                                    "subtitle"=>"Donnée à propos de la qualité de l'air") );  
        ?>
		<button class="btn btn-default" id="btnReloadData">Reload data</button>
        <hr>

        <?php $i=0; foreach($chartList as $dataKey => $val){ $i++; ?>
            <div class="col-xs-12 col-sm-12 col-md-6" id="">
                <h4 class="text-right letter-<?php echo $val["color"]; ?>"><?php echo $dataKey; ?></h4>
                <canvas id="smartPie<?php echo $i;?>"/>
            </div>
        <?php } ?>

	</div>
</div>




<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array()); ?>



<script type="text/javascript" >

var titlePage = "<?php echo Yii::t("common",@$params["pages"]["#".$page]["subdomainName"]); ?>";
var datas = <?php echo json_encode($datas); ?>;
var chartList = <?php echo json_encode($chartList); ?>;

jQuery(document).ready(function() {

    setTitle("", "", titlePage);
    initKInterface({"affixTop":320});

    $("#btnReloadData").click(function(){
        loadData();
    });

    console.log("smartTest scalair datas", datas);
    
    loadData();

});

function loadData(){
    var i = 0;
    $.each(chartList, function(dataKey, val){ i++;
        var color = typeof val["color"] != "undefined" ? val["color"] : "green";
        scalairChartInit("smartPie"+i, datas, dataKey, "line", color);
    });
}


function scalairChartInit(idCanvas, datas, dataKey, chartType, color){ //alert("start loadchart");
        var dataChart = new Array();
        var labelsDates = new Array();
        
        console.log("smartTest datas chart", datas);
        $.each(datas, function(key, val){
            console.log("smartTest valchart", dataKey, val[dataKey]);
            dataChart.push(val[dataKey]);
            labelsDates.push(val["date"]);
        });

        console.log("smartTest ready dataChart ?", dataChart);

        var data = {
            datasets: [{
                label: dataKey,
                data : dataChart,
                backgroundColor: color,
                borderColor: color,
                borderWidth: 1
            }],
            labels: labelsDates 
        };

        var ctx = $("#"+idCanvas).get(0).getContext("2d");
        var options;
        myPieChart = new Chart(ctx,{
            type: chartType,
            data: data,
            options: {
                legend: {
                    display: false
                },
                animation: {
                    duration: 300
                }
            },
            //options: options
        });
    }

</script>