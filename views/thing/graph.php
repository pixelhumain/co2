<?php

$cssAnsScriptFiles = array(
	//'/plugins/d3/d3.v3.min.js',
	//'/plugins/d3/c3.min.js',
	//'/plugins/d3/c3.min.css',
	'/plugins/d3/d3.v4.min.js'
	);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->request->baseUrl);

$cssAnsScriptFilesModule = array('/js/thing/graph.js', );

HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule , $this->module->assetsUrl);

$params = CO2::getThemeParams();

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
//header + menu
$this->renderPartial($layoutPath.'header',
	array(  "layoutPath"=>$layoutPath ,
		"page" => "thing") ); 
?>

<!--link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
<script type="text/javascript">
    $('head').append('<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/jquery-editable/css/jquery-editable.css" rel="stylesheet" />');
    $.fn.poshytip={defaults:null};
</script-->

<?php
if(empty($nbDays) || !isset($nbDays) || $nbDays==0 ){$nbDays=10;}
else if ($nbDays>31) { $nbDays=31; }
if(empty($country) || !isset($country)){$country='RE';}
if(empty($postalCode) || !isset($postalCode)){$postalCode='0';} 
else if (is_int($postalCode)){$postalCode=strval($postalCode);}

//TODO remplacer par la function bylocality
$devicesMongoRes = Thing::getSCKDevicesByLocality($country,null,null,null,$postalCode);
//$devices=array();
//print_r($devicesMongoRes);

$sigDevicesForContextMap = array();
$infoSensors=array();

$infoSensorsDeviceOk=false;

//todo : utiliser les pois en objet sig, au lieu de construire des objets 
foreach ($devicesMongoRes as $mdataDevice) {
	//$devices[]=$mdataDevice;
	$sigDevicesForContextMap[]= array('geo' => $mdataDevice['geo'], 'typeSig'=>'poi.'.Thing::SCK_TYPE,
		'name'=> "sck".$mdataDevice['deviceId'], '_id'=>$mdataDevice['_id'], 'type'=>Thing::SCK_TYPE, 
		'address'=>$mdataDevice['address']);

	if(!$infoSensorsDeviceOk){
		$sensors=$mdataDevice['sensors'];
		if(count($sensors)>=9){
			foreach ($sensors as $sensor) {
			 	$infoSensors['sensor'.$sensor['id']] = array('id'=>$sensor['id'],'name' => $sensor['name'],
			    	'description'=>$sensor['description'],'unit'=>$sensor['unit']);
			}
			$infoSensors['timestamp']=$mdataDevice['timestamp'];
			$infoSensors['kit']=$mdataDevice['kit'];
			$infoSensorsDeviceOk=true;
		}
	}
}

/*
if( Yii::app()->request->isAjaxRequest ){
  echo "<br/>"."Ajax";
}*/

?>

<style type="text/css">
/*#graphs{
overflow: scroll;

}*/
/*container*/
.graphs{ 
	padding: 10px;
	margin : 10px;
	width: 100% ;
	height: 100% ;
}
.svggraph{
	width: 100% ;
	height: 100% ;
	background-color: #fdfefd;
	/*font-family: ;*/

}
#legend {
	overflow: auto;
	height: 80px;
	width: 200px;
	z-index: 1;
}

#legend-graph {
	color : black;
	padding: 20px;
	margin: 20px
}
#header-graph{

}

.grid .tick {
	stroke: lightgrey;
	opacity: 0.7;
}
.grid path {
	stroke-width: 0;
}

#graph-container {
	background-color: #fefefe;

}
<?php if(!(Yii::app()->request->isAjaxRequest) ){ ?>
#graph-container{
	margin-top: 40px;
	padding-top: 40px;
}
<?php }?>
</style>
    
<div class="col-md-12 col-sm-12 col-xs-12 container" id="graph-container">
	<section class="header col-sm-12 col-xs-12 no-padding no-margin" id="header-graph">
		<form class="form-inline col-sm-12 col-xs-12"> 
			<div class="form-group col-sm-12 col-xs-12">
				<span class="btn-toolbar col-sm-12 col-xs-12 no-padding no-margin" role="toolbar" aria-label="choixgraph" id="btngraphs" name="btngraphs">
					<div class="btn-group no-padding no-margin" role="group" aria-label="choixmesuressensors">
						<button type="button" class="btn btn-default btnchoixgraph " id="btn1" title="Température et humidité" value="1"> 
						 	<i class="fa fa-thermometer-half"></i> <span class="hidden-sm hidden-xs">Température | humidité</span> </button>
						<button type="button" class="btn btn-default btnchoixgraph" title="Énergies : Batterie et PV" value="2"> 
						 	<i class="fa fa-battery-full" ></i> <span class="hidden-sm hidden-xs">Énergies</span> </button>
						<button type="button" class="btn btn-default btnchoixgraph" title="Luminosité" value="3"> 
						 	<i class="fa fa-sun-o" ></i> <span class="hidden-sm hidden-xs">Luminosité</span> </button>
						<button type="button" class="btn btn-default btnchoixgraph" title="Gaz : CO et NO2" value="4"> 
						 	<i class="fa fa-cloud"> </i> <span class="hidden-sm hidden-xs">CO | NO2 </span> </button>
						<button type="button" class="btn btn-default btnchoixgraph" title="Bruit" value="5"> 
						 	<i class="fa fa-volume-up" ></i> <span class="hidden-sm hidden-xs">Bruit | nets</span> </button>
						<button type="button" class="btn btn-default btnchoixgraph" title="Tous les graphes" value="6"> 
						 	<i class="fa fa-check-square"></i> <span class="hidden-sm hidden-xs" >Tous</span> </button>
					</div>
				</span>
			</div>
			<div class="btn-toolbar form-group " role="group" aria-label="choixtimeoffset" name="btnchoix">
				<button class="btn btn-default" id="btnchoixtimeoffset" type="button" title="timeoffset" value="0">
					<i class="fa fa-clock-o" id="ibtntimeoffset"></i><span class="hidden-sm hidden-xs"> Heure locale </span> </button>
				<button class="btn btn-default" id="btntest" type="button" title="test" value="1">
					<i class="fa fa-clock-o" id="ibtntest"></i><span class="hidden-sm hidden-xs"> Test </span> </button>
			</div>
			<p><?php echo $this->module->assetsUrl ; ?></p>

			<div class="form-group col-sm-12">
		      
			    <!--<div class="hide no-all-day-range">
			        <span class="input-icon">
			          <input type="text" class="event-range-date form-control" name="eventRangeDate" placeholder="Range date"/>
			          <i class="fa fa-clock-o"></i> 
			        </span>
			    </div>
			    <div class="hide all-day-range">
			        <span class="input-icon">
			          <input type="text" class="event-range-date form-control" name="ad_eventRangeDate" placeholder="Range date"/>
			          <i class="fa fa-calendar"></i> 
			        </span>
			    </div>-->
			    <!-- TODO faire un selecteur de nombre de jours qui fait un get avec graph?nbDay=x -->
				<label class="col-sm-12" id="period"> </label>
				<label class="hide col-xs-12 col-sm-3 control-label" for="from">Période</label>
				<span class="hide input-group col-xs-12 col-sm-8">
					<input class="form-group" type="text" id="from" name="from"> 
					<input class="form-group" type="text" id="to" name="to">
				</span>
			</div>
		</form>
	</section>
	<section class="body center col-sm-12 col-xs-12 no-padding" > 
		<div class="col-xs-12" id="graphs"> 
		</div>
	</section>
	<section class="footer center col-sm-12 no-padding" id="legend-graph">
		<div class="col-sm-12 col-md-8"> 
			<label class="col-xs-12 col-sm-3">Légende</label> 
			<div class="col-xs-12 col-sm-5" id="legend"></div>
		</div>
	</section>
</div>

<!--?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?-->

<script>

//variable globale :
var tRollup = "rollup=2h";
var coRollup = 120;
var svgG;

//var timeOffset=<?php //echo timezone_offset_get(DATE_ISO8601) ?>

//var nbDays=<?php //echo $nbDays ?>;
var nbDays=20;
if(nbDays>0 && nbDays<=2){
 	tRollup = "rollup=30m"; //10
 	coRollup = 30;
}else if (nbDays>2 && nbDays<=7 ){
	tRollup = "rollup=40m";
	coRollup = 40;
}else if (nbDays>7 && nbDays<=14) {
	tRollup = "rollup=60m";
	coRollup = 60;
}

$("#period").text("Graphe sur "+nbDays+" jours, "+tRollup);
//mylog.log();

//svglegend={lwidth: 200, lheight: 100, };


//Variable pour d3 et svg
var multiGraphe = [];
var strockeColorArray={};

var svgwidth = 530, svgheight = 300; //16:9
var gmargin = {top: 20, right: 30, bottom: 30, left: 40};
var gwidth = +svgwidth - gmargin.left - gmargin.right;
var gheight = +svgheight - gmargin.top - gmargin.bottom;

var x = d3.scaleTime()
    .rangeRound([0, gwidth]);

var y = d3.scaleLinear()
    .range([gheight, 0]);

var line = d3.line()
	.x(function(d) { return x(d.timestamps); })
	.y(function(d) { return y(d.values); });

var vXn = new Date();
var vXm = new Date();
vXn.setDate((vXn.getDate()-nbDays));
var dXmISO = vXm.toISOString();
var dXnISO = vXn.toISOString();
var timeOffset = vXn.getTimezoneOffset(); // RE : -240
var vYn = 0; //min
var vYm = 1;

//Variable SCK 
//var listDevice = ["2531","4162","4151"];//,"4139","3151", "3188", "3422", "4122", "1693", "3208", "4164"];// 
/* var devices = <?php //echo json_encode($devices,true) ?>; */

var devicemongoGraph=<?php echo json_encode($devicesMongoRes); ?>;
//mylog.log(devices);

var listDevice = [];

var lengthOfdevicemongoGraph=0;
for ( device in devicemongoGraph ){
	lengthOfdevicemongoGraph++;
	listDevice.push(devicemongoGraph[device].deviceId);
};

//var listDevice = <?php //echo json_encode($deviceIds) ?>;
//mylog.log(listDevice);

// TODO : recuperer les sensor id pour chaque device par lastest readings API SC cad les donné de la base COmmunecter POI
var sckSensorIds = [{bat : 17},{hum : 13},{temp : 12},{no2 : 15},{ co: 16},{noise : 7},{panel : 18},{light : 14 },{nets : 21}]; 

var infoSensors = <?php echo json_encode($infoSensors); ?>;

jQuery(document).ready( function() {

	initKInterface({"affixTop":0});
	//initPageInterface();
	setTitle("<span id='main-title-menu'>Graphes</span>","line-chart","Graphes");
	$("#mainNav").addClass("affix");
/* TODO remplacer par les poi pour sig
	var contextDevicesMap = <?php //echo json_encode($sigDevicesForContextMap,true);?>;
	//chargement la carte
	if(CoSigAllReadyLoad){
		Sig.showMapElements(Sig.map, contextDevicesMap);
	}else{
		setTimeout(function(){ Sig.showMapElements(Sig.map, contextDevicesMap); }, 3000);
	}
*/
	var sensorsProcessed = 0;  

	sckSensorIds.forEach( function(item,index,array){
		sensorsProcessed++;
		mylog.log(" -- sckSensorIds.forEach(function(item,index,array){ } ); -");
		
		for( var it in item) {
			var sensorId = item[it];
			mylog.log(sensorId);
			var nametitle= "graphe_"+sensorId;
			var grapheTitle = d3.select("#graphs")
				.append("figure").attr("id",nametitle)
				.attr("class","col-xs-12 graphs");

			$("#"+nametitle).hide();
			svgG = setSVGForSensor(sensorId); //index pour les params du graphe sensor
		} 

		if(sensorsProcessed===array.length){
			mylog.log('sensorsProcessed : all sensorIds done');
		}
	});

	var deviceProcessed=0;

	for (idMgoSCK in devicemongoGraph) {
	
		
		//devicemongoGraph[idMgoSCK].boardId;
		//devicemongoGraph[idMgoSCK].deviceId;

		urlReqCODB = baseUrl+'/'+moduleId+"/thing/getsckdataincodb?boardId="+devicemongoGraph[idMgoSCK].boardId+"&start="+dXnISO+"&end="+dXmISO+"&rollupMin="+coRollup;
		
		$.ajax({
			type: 'GET',
			url: urlReqCODB,
			dataType: "json",
			crossDomain: true,
			success: function (data) {
				mylog.log("ajax GET : success -------  urlReqCODB :" + urlReqCODB );
				if(data.length>0){
					grapheCoDB(data, devicemongoGraph[idMgoSCK].deviceId);
				}
			 },
			error: function (data) { mylog.log("Error : ajax not success"); 
			//mylog.log(data); 
			}

		}).done(function() { 
			deviceProcessed++; 
			if (lengthOfdevicemongoGraph== deviceProcessed){
				sckSensorIds.forEach( function(item,index){
					mylog.log(' sckSensorIds forEach2 item : '+item+" index : "+index );
					mylog.log("infoSensors[multiGraphe[index].svgid] : "+infoSensors[multiGraphe[index].svgid]);
					setAxisXY(index,infoSensors[multiGraphe[index].svgid]); 
				});
			}
		 });

	}

	
	mylog.log('all device done');
	/*
	sckSensorIds.forEach( function(item,index){
		mylog.log(' sckSensorIds forEach2 item : '+item+" index : "+index );
		mylog.log("infoSensors[multiGraphe[index].svgid] : "+infoSensors[multiGraphe[index].svgid]);
		setAxisXY(index,infoSensors[multiGraphe[index].svgid]); 
	});
	*/

	 // if(devicemongoGraph.length>0){
	if(true==false) { // desactivé ppour test

		// fait un graphe par sensor et trace tous les devices sur le même graphe sensor
		sckSensorIds.forEach(function (item,index,array){ 
			
			mylog.log(item);

			for( var e in item) {

				var sensorId = item[e];
/*
				var nametitle= "graphe_"+sensorId;
				var grapheTitle = d3.select("#graphs")
					.append("figure").attr("id",nametitle)
					.attr("class","col-xs-12 graphs");
				$("#"+nametitle).hide();
*/
				//var svgG = setSVGForSensor(sensorId); //index pour les params du graphe sensor

				for ( var i = 0; i< listDevice.length ; i++) {
					var urlReq="<?php //echo Thing::URL_API_SC ?>/devices/"+listDevice[i]+"/readings?sensor_id="+sensorId+"&"+tRollup+"&from="+dXnISO+"&to="+dXmISO;
					var sensorkey = "";

					//mylog.log(urlReq);

					$.ajax({

						//exemple api GET https://api.smartcitizen.me/v0/devices/1616/readings?sensor_id=7&rollup=4h&from=2015-07-28&to=2015-07-30
						type: 'GET',
						url: urlReq,
						dataType: "json",
						crossDomain: true,
						success: function (data) {
							//console.dir(data);
							var dRead = data;
							var readings = dRead.readings;
							var device = dRead.device_id;
							var sensor = dRead.sensor_id;
							sensorkey= dRead.sensor_key;

							if (readings.length>=1){
								//mylog.log(device);
								graphe(device,sensor,readings,svgG);
							}
						},
						error: function (data) { mylog.log("Error : ajax not success"); //mylog.log(data); 
						}
						}).done(function() { setAxisXY(svgG,sensorkey); });
				}

			}
			
		}); //call
	}

	$("#btn1").click().attr("clicked");
	//showSensor();   

	$("#btntest").click(function(){
		mylog.log("*** bouton test function ****");
	});

});

$(".btnchoixgraph").click(function(){
	var value = $(this).val();
	$(".btnchoixgraph").removeClass("active");
	$(this).addClass("active");
	//mylog.log(value);

	hideAllGraph();
	var list=[];
	switch(value) {
	case "1": //temp et hum
		list.push(12,13);
		break;
	case "2": //energie : batt et solarPV
		list.push(17,18);
		break;
	case "3": //lum
		list.push(14);
		break;
	case "4": //co no2
		list.push(15,16);
		break; 
	case "5": //bruit : noise et nets
		list.push(7,21);
		break;
	case "6":
		showAllGraph();
		break;
	//default:
	//  list.push(12,13);
	//  break;
	} 
	for(var s=0;s<list.length; s++){
		var figGraph = "graphe_"+list[s];
		showGraph(figGraph);
	}
});

function initPageInterface(){

	$("#second-search-bar").addClass("input-global-search");

	$("#main-btn-start-search, .menu-btn-start-search").click(function(){
		startGlobalSearch(0, indexStepGS);
	});

	$("#second-search-bar").keyup(function(e){
		$("#input-search-map").val($("#second-search-bar").val());
		if(e.keyCode == 13){
			startGlobalSearch(0, indexStepGS);
		}
	});

	$("#input-search-map").keyup(function(e){
		$("#second-search-bar").val($("#input-search-map").val());
		if(e.keyCode == 13){
			startGlobalSearch(0, indexStepGS);
		}
	});

    $("#menu-map-btn-start-search").click(function(){
    	startGlobalSearch(0, indexStepGS);
    });

    $(".social-main-container").mouseenter(function(){
    	$(".dropdown-result-global-search").hide();
    });
}

</script>