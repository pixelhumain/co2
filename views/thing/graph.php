<?php

 	  $cssAnsScriptFilesModule = array(
	  	//'/plugins/d3/d3.v3.min.js',
      //'/plugins/d3/c3.min.js',
      //'/plugins/d3/c3.min.css',
      '/plugins/d3/d3.v4.min.js',
      /*/DatePicker
      '/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js' ,
      '/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js' ,
      '/plugins/bootstrap-datepicker/css/datepicker.css',
  
      //DateTime Picker
      '/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
      '/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js' , 
      '/plugins/bootstrap-datetimepicker/css/datetimepicker.css',*/

	  );
	  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->request->baseUrl);

    HtmlHelper::registerCssAndScriptsFiles( array('/js/thing/graph.js', ) , $this->module->assetsUrl);
    
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
if(empty($nbDays) || !isset($nbDays) || $nbDays==0 ){$nbDays=1;}
else if ($nbDays>31) { $nbDays=31; }
if(empty($country) || !isset($country)){$country='RE';}
if(empty($postalCode) || !isset($postalCode)){$postalCode='0';} 
else if (is_int($postalCode)){$postalCode=strval($postalCode);}

$devicesMongoRes = Thing::getSCKDevicesByCountryAndCP($country,$postalCode);
$devices=array();
//print_r($devicesMongoRes);

$sigDevicesForContextMap = array();
$infoSensors=array();

$infoSensorsDeviceOk=false;
//todo : mutiliser les pois en objet sig, au lieu de construire des objets 
foreach ($devicesMongoRes as $mdataDevice) {

  $devices[]=$mdataDevice;
  
  $sigDevicesForContextMap[]= array('geo' => $mdataDevice['geo'], 'typeSig'=>'poi.'.Thing::SCK_TYPE,
    'name'=> "sck".$mdataDevice['deviceId'], '_id'=>$mdataDevice['_id'], 'type'=>Thing::SCK_TYPE, 
    'address'=>$mdataDevice['address']);

  if(!$infoSensorsDeviceOk){

    $sensors=$mdataDevice['sensors'];
    if(count($sensors)>=9){
    foreach ($sensors as $sensor) {
      $infoSensors['sensor'.$sensor['id']] = array('id'=>$sensor['id'],'name' => $sensor['name'],
        'description'=>$sensor['description'],'unit'=>$sensor['unit'] );
    }
    $infoSensors['timestamp']=$mdataDevice['timestamp'];
    $infoSensors['kit']=$mdataDevice['kit'];

    $infoSensorsDeviceOk=true;
    }
  }

}

//print_r($sigDevicesForContextMap);


//$this->renderPartial("./thingMap");

//print_r($devices);


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

  

</style>
    
  <div class="padding-top-15 col-md-12 col-sm-12 col-xs-12 container" id="graph-container">
  <section class="header col-sm-12">
    <form class="form-inline col-sm-12"> 
      <span class="form-group col-sm-12">
        <span class="btn-toolbar col-sm-12 col-xs-12" role="toolbar" aria-label="choixgraph" id="btngraphs" name="btngraphs">
          <div class="btn-group " role="group" aria-label="choixmesuressensors">
            <button type="button" class="btn btn-default btnchoixgraph" id="btn1" title="Température et humidité" value="1"> 
              <i class="fa fa-thermometer-half"></i> <span class="hidden-sm hidden-xs"> Température et humidité </span> </button>
            <button type="button" class="btn btn-default btnchoixgraph" title="Énergies : Batterie et PV" value="2"> 
              <i class="fa fa-battery-full" ></i> <span class="hidden-sm hidden-xs"> Énergies</span> </button>
            <button type="button" class="btn btn-default btnchoixgraph" title="Luminosité" value="3"> 
              <i class="fa fa-sun-o" ></i> <span class="hidden-sm hidden-xs"> Luminosité</span> </button>
            <button type="button" class="btn btn-default btnchoixgraph" title="Gaz : CO et NO2" value="4"> 
              <i class="fa fa-cloud"> </i> <span class="hidden-sm hidden-xs">CO et NO2 </span> </button>
            <button type="button" class="btn btn-default btnchoixgraph" title="Bruit" value="5"> 
              <i class="fa fa-volume-up" ></i> <span class="hidden-sm hidden-xs">Bruit et nets</span> </button>
            <button type="button" class="btn btn-default btnchoixgraph" title="Tous les graphes" value="6"> 
              <i class="fa fa-check-square"></i> <span class="hidden-sm hidden-xs" >Tous les graphes</span> </button>
          </div>
        </span>
      </span>

      <span class="btn-toolbar pull-right" role="group" aria-label="choixtimeoffset" name="btnchoix">
        <button class="btn btn-default" id="btnchoixtimeoffset" type="button" title="timeoffset" value="0">
        <i class="fa fa-clock-o" id="ibtntimeoffset"></i><span class="hidden-sm hidden-xs"> Heure locale </span> </button>
        <button class="btn btn-default" id="btntest" type="button" title="test" value="1">
        <i class="fa fa-clock-o" id="ibtntest"></i><span class="hidden-sm hidden-xs"> Test </span> </button>

      </span>
      <!--span class="btn-toolbar pull-right" role="group" aria-label="autreaction">
        <button class="pull-right btn btn-default" type='button' onclick="showSCKDeviceOnMap('<?php //echo $country; echo "','"; echo $postalCode; ?>')" title="Voir les devices sur la carte"><i class="fa fa-globe"></i> </button>
      </span-->

        <!-- <select class="hide control-select col-xs-11 col-sm-8 form-control" name="">
          <option class="form-control" value="1">Température et humidité</option> 
          <option class="form-control" value="2">Énergies</option>
          <option class="form-control" value="3">Luminosité</option>
          <option class="form-control" value="4">CO2 et NO2</option>
          <option class="form-control" value="5">Bruit</option>
          <option class="form-control" value="6">Tous les graphes</option>
        </select>-->

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
  <section class="body center col-sm-12" > 
    <div class="col-xs-12" id="graphs"> </div>
  </section>
  <section class="footer center col-sm-12" id="legend-graph">
    <div class="col-sm-12 col-md-8"> 
      <label class="col-xs-12 col-sm-3">Légende</label> 
        <div class="col-xs-12 col-sm-5" id="legend"></div>
    </div>
  </section>

</div>


<!--?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?-->

<script>

//variable globale :


//var timeOffset=<?php //echo timezone_offset_get(DATE_ISO8601) ?>

nbDays=<?php echo $nbDays ?>;
if(nbDays>0 && nbDays<=2){
  tRollup = "rollup=30m"; //10
}else if (nbDays>2 && nbDays<=7 ){
  tRollup = "rollup=40m";
}else if (nbDays>7 && nbDays<=14) {
  tRollup = "rollup=60m";
} else {
  tRollup = "rollup=2h";
}

$("#period").text("Graphe sur "+nbDays+" jours, "+tRollup);
//console.log();

//svglegend={lwidth: 200, lheight: 100, };


  //Variable pour d3 et svg
 multiGraphe = [], strockeColorArray={};
 
 svgwidth = 800, svgheight = 450; //16:9
 gmargin = {top: 20, right: 30, bottom: 30, left: 40};
 gwidth = +svgwidth - gmargin.left - gmargin.right;
 gheight = +svgheight - gmargin.top - gmargin.bottom;

x = d3.scaleTime()
    .rangeRound([0, gwidth]);

y = d3.scaleLinear()
    .range([gheight, 0]);

line = d3.line()
 .x(function(d) { return x(d.timestamps); })
 .y(function(d) { return y(d.values); });

 var vXn = new Date();
 var vXm = new Date();
 vXn.setDate((vXn.getDate()-nbDays));
 var dXmISO = vXm.toISOString();
 var dXnISO = vXn.toISOString();
 var timeOffset = vXn.getTimezoneOffset(); // RE : -240
 vYn = 0; //min
 vYm = 1;

//Variable SCK 
//var listDevice = ["2531","4162","4151"];//,"4139","3151", "3188", "3422", "4122", "1693", "3208", "4164"];// 
var devices = <?php echo json_encode($devices,true) ?>;
//console.log(devices);

var listDevice = [];

devices.forEach(function(device){
  listDevice.push(device.deviceId);


} );
//var listDevice = <?php //echo json_encode($deviceIds) ?>;
//console.log(listDevice);

// TODO : recuperer les sensor id pour chaque device par lastest readings API SC
var sckSensorIds = [{bat : 17}, {hum : 13},{temp : 12},{no2 : 15}, { co: 16}, {noise : 7}, {solarPV : 18},{ambLight : 14 }, {nets : 21}]; 


var infoSensors = <?php echo json_encode($infoSensors); ?>;
//console.log(infoSensors);
//functions 

$(".btnchoixgraph").click(function(){
  value = $(this).val();
  $(".btnchoixgraph").removeClass("active");
  $(this).addClass("active");
  //console.log(value);

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
}
);

$("#btntest").click(function(){
  console.log("*** bouton test function ****");

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

    //$(".dropdown-result-global-search").hide();
    
}



jQuery(document).ready(function() {

  initKInterface({"affixTop":0});
  $("#mainNav").addClass("affix");

  initPageInterface();

  contextDevicesMap = <?php echo json_encode($sigDevicesForContextMap,true);?>;

  //chargement la carte
  if(CoSigAllReadyLoad)
    Sig.showMapElements(Sig.map, contextDevicesMap);
  else{
    setTimeout(function(){
    Sig.showMapElements(Sig.map, contextDevicesMap);
    }, 3000);
  }


  setTitle("<span id='main-title-menu'>Graphes</span>","line-chart","Graphes");
  
  if(devices.length>0){


var sensorsProcessed = 0;

// fait un graphe par sensor et trace tous les devices sur le même graphe sensor
 sckSensorIds.forEach(function (item,index,array){ 
    sensorsProcessed++;

    for( var e in item) {

      sensorId = item[e];
      var nametitle= "graphe_"+sensorId;
    
      var grapheTitle = d3.select("#graphs")
        .append("figure").attr("id",nametitle)
        .attr("class","col-xs-12 graphs");

      $("#"+nametitle).hide();
      
      var svgG = setSVGForSensor(sensorId); //index pour les params du graphe sensor

    for ( var i = 0; i< listDevice.length ; i++) {
      var urlReq="<?php echo Thing::URL_API_SC ?>/devices/"+listDevice[i]+"/readings?sensor_id="+sensorId+"&"+tRollup+"&from="+dXnISO+"&to="+dXmISO;
      var sensorkey = "";

      //console.log(urlReq);

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
        //  console.log(device);
          graphe(device,sensor,readings,svgG);
        }
      },
      error: function (data) { console.log("Error : ajax not success"); 
      //console.log(data); 
      }

      }).done(function() { setAxisXY(svgG,sensorkey); });

    }

  }

  if(sensorsProcessed===array.length){
          console.log('all sensorIds done');
        }
 
 }); //call

 }

 $("#btn1").click().attr("clicked");


 //showSensor(); 

   
});

</script>