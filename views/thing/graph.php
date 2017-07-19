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
$isAjax=null;

if(!(Yii::app()->request->isAjaxRequest) ){
	$isAjax=false;
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
	//header + menu
	$this->renderPartial($layoutPath.'header',
		array(  "layoutPath"=>$layoutPath ,
			"page" => "thing") ); 


}else $isAjax=true;

?>

<!--link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
<script type="text/javascript">
    $('head').append('<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/jquery-editable/css/jquery-editable.css" rel="stylesheet" />');
    $.fn.poshytip={defaults:null};
</script-->

<?php
if(empty($nbDays) || !isset($nbDays) || $nbDays==0 ){$nbDays=7;}
else if ($nbDays>90) { $nbDays=90; }
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
	$mdataDevice["typeSig"]='poi.'.Thing::SCK_TYPE;
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
<?php if(!$isAjax ){ ?>
#graph-container{
	margin-top: 60px;
	padding-top: 60px;
}
<?php }?>
</style>
    
<div class="col-md-12 col-sm-12 col-xs-12 container" id="graph-container">
	<section class="header col-sm-12 col-xs-12 no-padding no-margin" id="header-graph">
		<form class="form-inline col-sm-12 col-xs-12"> 
			<div class="center form-group col-sm-12 col-xs-12">
				<div class="btn-toolbar col-sm-12 col-xs-12 no-padding no-margin" role="toolbar" aria-label="choixgraph" id="btngraphs" name="btngraphs">
					<span class="btn-group no-padding no-margin col-sm-12" role="group" aria-label="choixmesuressensors">
						<button type="button" class="btn btn-default btnchoixgraph " id="btnTempAndHum" title="Température et humidité" value="1"> 
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
					</span>
				</div>
			</div>
			<div class="center btn-toolbar col-sm-12 form-group <?php echo 'hidden'; ?> " role="group" aria-label="choixtimeoffset" name="btnchoix">
				<button class="btn btn-default" id="btnchoixtimeoffset" type="button" title="timeoffset" value="0">
					<i class="fa fa-clock-o" id="ibtntimeoffset"></i><span class="hidden-sm hidden-xs"> Heure locale </span> </button>
				<button class="btn btn-default" id="btntest" type="button" title="test" value="1">
					<i class="fa fa-clock-o" id="ibtntest"></i><span class="hidden-sm hidden-xs"> Test </span> </button>
			</div>

			<div class="center btn-toolbar col-sm-12 form-group <?php if($isAjax){ echo 'hidden';} ?>" role="group" aria-label="choixsource" name="btnchoixsource"><span class="col-xs-12 col-md-3"> Source des données : </span>
				<span class="btn-group no-padding no-margin col-xs-12 col-md-9" role="group">
				<button class="btn btn-default btngraphsource" id="btndcodb" type="button" title="timeoffset" value="0">
					<i class="fa fa-database" id="ibtndcodb"></i><span class="hidden-sm hidden-xs"> Communecter DB </span> </button>
				<button class="btn btn-default btngraphsource" id="btndapisc" type="button" title="test" value="1">
					<i class="fa fa-cloud-download" id="ibtndapisc"></i><span class="hidden-sm hidden-xs"> Depuis API smartcitizen </span> </button>
				<button class="btn btn-default btngraphsource" id="btnbothsource" type="button" title="test" value="2">
					<i class="fa fa-clone" id="ibtnbothsource"></i><span class="hidden-sm hidden-xs"> Comparaison des graphes </span> </button>
				</span>
			</div>

			<div class="form-group col-sm-12">
		      
			    <!--<div class="no-all-day-range">
			        <span class="input-icon">
			          <input type="text" class="event-range-date form-control" name="eventRangeDate" placeholder="Range date"/>
			          <i class="fa fa-clock-o"></i> 
			        </span>
			    </div>
			    <div class="all-day-range">
			        <span class="input-icon">
			          <input type="text" class="event-range-date form-control" name="ad_eventRangeDate" placeholder="Range date"/>
			          <i class="fa fa-calendar"></i> 
			        </span>
			    </div>-->
			    <!-- TODO faire un selecteur de nombre de jours qui fait un get avec graph?nbDay=x -->
				<label class="hide col-sm-12" id="period"> </label>
				<label class="col-xs-12 col-sm-3 control-label" for="from">Période</label>
				<span class="input-group col-xs-12 col-sm-8">
					<input class="form-group" type="text" id="datePickerFrom" name="datefrom"> 
					<input class="form-group" type="text" id="datePickerTo" name="dateto">
				</span>
			</div>
		</form>
	</section>
	<section class="body center col-sm-12 col-xs-12 no-padding" > 
		<div class="col-xs-12 no-padding" id="graphs"> 
		</div>
	</section>
	<section class="footer center col-sm-12 col-md-10 no-padding hidden" id="legend-graph">
		<div class="col-sm-12 col-md-10"> 
			<label class="col-xs-12 col-sm-3">Légende</label> 
			<div class="col-xs-12 col-sm-7" id="legend"></div>
		</div>
	</section>
</div>

<!--?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?-->

<script>

//variable globale :
var tRollup = "24h";
var coRollup = 1440;
var svgG;

//var timeOffset=<?php //echo timezone_offset_get(DATE_ISO8601) ?>

var nbDays=<?php echo $nbDays ?>;
//var nbDays=10;
if(nbDays>0 && nbDays<=2){
 	tRollup = "10m"; //10
 	coRollup = 10;
}else if (nbDays>2 && nbDays<=7 ){
	tRollup = "60m";
	coRollup = 60;
}else if (nbDays>7 && nbDays<=14) {
	tRollup = "120m";
	coRollup = 120;
}else if(nbDays>14 && nbDays<= 30) {
	tRollup = "12h";
	coRollup = 720;
}

$("#period").text("Graphe sur "+nbDays+" jours, rollup : "+tRollup);
//
//mylog.log();

//svglegend={lwidth: 200, lheight: 100, };

//Variable pour d3 et svg
var multiGraphe = {};
var strockeColorArray={};

var svgwidth = 500, svgheight = 285; //16:9
var gmargin = {top: 20, right: 30, bottom: 30, left: 50};
var gwidth = +svgwidth - gmargin.left - gmargin.right;
var gheight = +svgheight - gmargin.top - gmargin.bottom;

var x = d3.scaleTime()
    .rangeRound([0, gwidth]);

var y = d3.scaleLinear()
    .range([gheight, 0]);

var line = d3.line()
	.x(function(d) { return x(d.timestamps); })
	.y(function(d) { return y(d.values); });

var vXn = new Date("2017-03-20"); // 2017-05-03
var vXm = new Date("2017-03-20");
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
var dCOdb = {};
var dAPIsc = {};
var graphReady= {dCOdb: false, dAPIsc : false};
var min={} ; //null;
var max={} ; //null;


for (var device in devicemongoGraph ){
	lengthOflistDevice++; // pour avoir la taille rapidement
	listDevice.push({deviceId : devicemongoGraph[device].deviceId, boardId : devicemongoGraph[device].boardId });
};
var lengthOflistDevice=listDevice.length;

var deviceForBoardId={};
//var listDevice = <?php //echo json_encode($deviceIds) ?>;
//mylog.log(listDevice);

// TODO : recuperer les sensor id pour chaque device par lastest readings API SC cad les donné de la base COmmunecter POI
//var sckSensorIds = {bat : 17, hum : 13, temp : 12,no2 : 15,  co: 16, noise : 7, panel : 18, light : 14 , nets : 21}; 

var dataSensors = { bat : { id : 17}, hum :{ id : 13}, temp :{ id : 12} ,no2 : { id :15},
	co:{ id : 16}, noise :{ id : 7}, panel :{ id : 18}, light :{ id : 14} , nets : { id :21} }; 

var infoSensors = <?php echo json_encode($infoSensors); ?>;
var compteurAjaxAPIsc=0;
var compteurDevices={};
var lengthOfdataSensors=0;

var boardIds = [];
var urlReqCODB = baseUrl+'/'+moduleId+"/thing/getsckdataincodb"; //?start="+dXnISO+"&end="+dXmISO+"&rollupMin="+coRollup;
var urlReqAPIsc="<?php echo Thing::URL_API_SC ?>/devices/";//+item.deviceId+"/readings";
var contextDevicesMap = <?php echo json_encode($sigDevicesForContextMap,true);?>;
//var contextDevicesMap = <?php// echo json_encode( $devicesMongoRes ,true);?>

jQuery(document).ready( function() {

	initKInterface({"affixTop":0});
	//initPageInterface();
	setTitle("<span id='main-title-menu'>Graphes</span>","line-chart","Graphes");
	$("#mainNav").addClass("affix");


/* TODO remplacer par les poi pour sig ( mettre dans la page thing )*/
	
	//chargement la carte
	if(CoSigAllReadyLoad){
		Sig.showMapElements(Sig.map, contextDevicesMap);
	}else{
		setTimeout(function(){ Sig.showMapElements(Sig.map, contextDevicesMap); }, 3000);
	}
	
	//$("#legend-graph").hide();

	for (var keySens in dataSensors ) {	//forEach( function(item,index,array){
		lengthOfdataSensors++;
		min[keySens]=null;
		max[keySens]=null;
		
		var sensorId = dataSensors[keySens].id;  // item[it];
		var nametitle= "graphe_"+sensorId;
		var grapheTitle = d3.select("#graphs")
			.append("figure").attr("id",nametitle)
			.attr("class","col-xs-12 no-padding graphs");

		$("#"+nametitle).hide();
		setSVGForSensor(sensorId, keySens); 
	} 

	//$(".svggraph").hide();
	mylog.log('set SVG All Sensor done');

	//	var boardIdTest = "00:06:66:2a:02:a0"; 

	listDevice.forEach( function(item) { 
		dAPIsc[item.deviceId]={temp : [], hum : [], bat: [], panel : [], no2 : [], panel : [], co : [], noise : [], nets : [], light : []};
		deviceForBoardId[item.boardId]=item.deviceId;
		setStrokeColorAndLegendForDevice(item.deviceId);
		if(item.boardId!="[FILTERED]"){ boardIds.push(item.boardId); }
	});

	mylog.log("listDevice : ");
	mylog.log(listDevice);


	$("#datePickerFrom").datepicker({ gotoCurrent: true,
		maxDate: -1, dateFormat: "yy-mm-dd",
		onSelect: function(date){ vXn.setDate(date); graphReady.dCOdb=false; graphReady.dAPIsc=false; } });
	$("#datePickerTo").datepicker({ gotoCurrent: true,
		maxDate: 0, dateFormat: "yy-mm-dd",
		onSelect: function(date){ vXm.setDate(date); graphReady.dCOdb=false; graphReady.dAPIsc=false; } });
	$("#datePickerFrom").datepicker("option", "dateFormat", "yy-mm-dd");
	$("#datePickerTo").datepicker("option", "dateFormat", "yy-mm-dd");
	$("#datePickerFrom").datepicker("setDate", vXn);
	$("#datePickerTo").datepicker("setDate",  vXm);



	$(".btngraphsource").click( function(){
		var value = $(this).val();
		$(".btngraphsource").removeClass("active");
		$(this).addClass("active");
		mylog.log(" value btn :"+value);
		//$.datepicker.parseDate( "yy-mm-dd",  );
		
		showHideChart( value);
	}
	);

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


}); //fin jQuery ( document)


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


function setGraphFromAPIsmartcitizen() {
	//$.blockUI({ message : '<span class="homestead"><i class="fa fa-spinner fa-circle-o-noch"></i> Chargement des données en cours ...</span>' });
	// fait un graphe par sensor et trace tous les devices sur le même graphe sensor
	mylog.log("--- processGraphAPI ---");

	for(var keySens in dataSensors){
		var sensorId = dataSensors[keySens].id;
		compteurDevices[keySens]=0;

		listDevice.forEach( function (item) {
			///?sensor_id="+sensorId+"&"+tRollup+"&from="+dXnISO+"&to="+dXmISO;
			//exemple api GET https://api.smartcitizen.me/v0/devices/1616/readings?sensor_id=7&rollup=4h&from=2015-07-28&to=2015-07-30
			var deviceId = item.deviceId;
			var urlReqSC=urlReqAPIsc+deviceId+"/readings";

			$.ajax({
				type: 'GET',
				url: urlReqSC,
				dataType: "json",
				data : {sensor_id : sensorId, rollup: tRollup, from: dXnISO, to: dXmISO},
				crossDomain: true,
				context : { keySens: keySens, deviceId: deviceId , lengthOflistDevice : lengthOflistDevice },
				success: function (data) {

					var ks = $(this)[0].keySens;
					var dvice=$(this)[0].deviceId;
					mylog.log(data);

					if (data.readings.length>=1){
						fillArrayWithObjectTimestampsAndValues(data.readings, dvice, ks);
					}
				},
				error: function (dErr) {
				 	mylog.log("Error : ajax not success"); 
					//mylog.log(dErr); 
					mylog.log( "error sensor : "+$(this)[0].keySens+" device :"+$(this)[0].deviceId);
				},
				complete : function( ) {
					mylog.log("Complete ajax ");
					var ks = $(this)[0].keySens;
					var dvice=$(this)[0].deviceId;
					if(++compteurDevices[ks] >= (lengthOflistDevice)){
						mylog.log( "--compteurDevices - "+ks+" : "+dvice);
						grapheOneSensor(ks, "dAPIsc",false);
					}
				}	
			});
		}); //forEach
	} // for
} 

function setGraphFromCoDB () {
	console.time("ajaxRequestToCODB");
	//$.blockUI({ message : '<span class="homestead"><i class="fa fa-spinner fa-circle-o-noch"></i> Chargement des données en cours ...</span>' });

	$.ajax({
		type: 'GET',
		url: urlReqCODB,
		dataType: "json",
		data: { start : dXnISO, end : dXmISO, rollupMin: coRollup,
			listBoardIds : JSON.stringify(boardIds) }, 
		context : { listDevice: listDevice},
		success: function (dCO) {
			mylog.log(" -- ajax success-- " );
			if(notNull(dCO) ){
				mylog.log("--deviceForBoardId in ajax- ");
				mylog.log(deviceForBoardId);

				for( var bId in dCO){
					mylog.log("---- boardIds ---- "+ bId);
					if(dCO[bId].length>0 ){
						
						var deviceId = deviceForBoardId[bId];
						dataSensorAdaptorTimestampsAndValues(dCO[bId],deviceId );
					}
				}
			}
		},
		error: function (data) { mylog.log("Error : ajax not success -- "); 
			mylog.log(data); 
		}

	}).done(function() { 
		mylog.log(" -- ajax Done-- " );
		console.timeEnd("ajaxRequestToCODB");

		for(var ks in multiGraphe ){
			grapheOneSensor(ks,"dCOdb",false);
		}
	});
}







mylog.log("------------ jusqu'ici tous va bien pour graph !! ----------------");
</script>