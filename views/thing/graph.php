<?php
	$cs = Yii::app()->getClientScript();
	// if(!Yii::app()->request->isAjaxRequest)
	// {
	  	$cssAnsScriptFilesModule = array(
	  		'/plugins/d3/d3.v3.min.js',
        '/plugins/d3/c3.min.js',
        '/plugins/d3/c3.min.css',
        '/plugins/d3/d3.v4.min.js',
        //DatePicker
        '/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js' ,
        '/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js' ,
        '/plugins/bootstrap-datepicker/css/datepicker.css',
  
        //DateTime Picker
        '/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
        '/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js' , 
        '/plugins/bootstrap-datetimepicker/css/datetimepicker.css',

	  	);
	  	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->request->baseUrl);
  	// }
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
if(empty($postalCode) || !isset($postalCode)){$postalCode='97490';} 
else if (is_int($postalCode)){$postalCode=strval($postalCode);}

$devicesMongoRes = Thing::getSCKDevicesByCountryAndCP($country,$postalCode);
//$devices=array();
//print_r($devicesMongoRes);

$sigDevicesForContextMap = array();
$infoSensors=array();

$infoSensorsDeviceOk=false;
//todo : mutiliser les pois en objet sig, au lieu de construire des objets 
foreach ($devicesMongoRes as $mdataDevice) {
  $devices[]=$mdataDevice;
  
  $sigDevicesForContextMap[]=array('geo' => $mdataDevice['geo'],'typeSig'=>'poi',
    'name'=> "sck".$mdataDevice['deviceId'],"_id"=>$mdataDevice["_id"], 'type'=>Thing::SCK_TYPE, 
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

};




//print_r($devices);
?>
<style type="text/css">
  /*#graphs{
    overflow: scroll;

  }*/
  /*container*/
  .graphs{ 
    margin : 5px;
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
    height: 60px;
    width: 180px;
    z-index: 1;
  }
  .grid .tick {
    stroke: lightgrey;
    opacity: 0.7;
  }
  .grid path {
      stroke-width: 0;
  }

</style>


<div class="panel panel-white col-sm-12 col-md-12">
  <section class="panel-title col-sm-12">
    <form class="form-inline col-sm-12"> 
      <span class="form-group col-sm-12">
        <label for="btngraphs" class="hide col-xs-12 col-sm-3 control-label">Graphe(s)</label>
        <span class="btn-toolbar col-sm-12" role="toolbar" aria-label="choixgraph" id="btngraphs" name="btngraphs">
          <div class="btn-group " role="group" aria-label="choixmesuressensors">
            <button type="button" class="btn btn-default" id="btn1" title="Température et humidité" value="1"> 
              <i class="fa fa-thermometer-half"></i> </button>
            <button type="button" class="btn btn-default" title="Énergies : Batterie et PV" value="2"> 
              <i class="fa fa-battery-full" ></i> </button>
            <button type="button" class="btn btn-default" title="Luminosité" value="3"> 
              <i class="fa fa-sun-o" ></i> </button>
            <button type="button" class="btn btn-default" title="Gaz : CO et NO2" value="4"> 
              <i class="fa fa-cloud"> </i> </button>
            <button type="button" class="btn btn-default" title="Bruit" value="5"> 
              <i class="fa fa-volume-up" ></i> </button>
            <button type="button" class="btn btn-default" title="Tous les graphes" value="6"> 
              <i class="fa fa-check-square"></i> </button>
          </div>
        </span>
      
  <!--div class="btn-group" role="group" aria-label="choix"></div>
  <div class="btn-group" role="group" aria-label="gaz"></div>
  <div class="btn-group" role="group" aria-label="noise"></div>
  <div class="btn-group" role="group" aria-label="light"></div>
  <div class="btn-group" role="group" aria-label="nets"></div -->

      </span>
      <span class="btn-toolbar pull-right" role="group" aria-label="autreaction">
        <button class="pull-right btn btn-default" type='button' onclick="showSCKDeviceOnMap('<?php echo $country; echo "','"; echo $postalCode; ?>')" title="Voir les devices sur la carte"><i class="fa fa-globe"></i> </button>
      </span>

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
  <section class="panel-body center col-sm-12" > 
    <div class="col-xs-12" id="graphs"> </div>
  </section>
  <section class="panel-footer center col-sm-12">
    <div class="col-sm-12"> 
      <label class="col-xs-12 col-sm-3">Légende</label> 
        <div class="col-xs-12" id="legend">   </div>
    </div>
  </section>

</div>

<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?>




<script>

//variable globale :
nbDays=<?php echo $nbDays ?>;

if(nbDays>0 && nbDays<=2){
  tRollup = "rollup=10m";
}else if (nbDays>2 && nbDays<=7 ){
  tRollup = "rollup=20m";
}else if (nbDays>7 && nbDays<=14) {
  tRollup = "rollup=40m";
} else {
  tRollup = "rollup=1h";
}

$("#period").text("Graphe sur "+nbDays+" jours, "+tRollup);
//console.log();

svglegend={lwidth: 200, lheight: 100, }


  //Variable pour d3 et svg
 multiGraphe = [], strockeColorArray={};
 
 svgwidth = 800, svgheight = 300;
 gmargin = {top: 20, right: 20, bottom: 25, left: 35};
 gwidth = +svgwidth - gmargin.left - gmargin.right;
 gheight = +svgheight - gmargin.top - gmargin.bottom;

x = d3.scaleTime()
    .rangeRound([0, gwidth]);

y = d3.scaleLinear()
    .range([gheight, 0]);

line = d3.line()
 .x(function(d) { return x(d.timestamps); })
 .y(function(d) { return y(d.values); });

 var vXm = new Date();
 var dXmISO = vXm.toISOString();
 var vXn = new Date();

 vXn.setDate((vXn.getDate()-nbDays));
 var dXnISO = vXn.toISOString();
 vYn = 0; //min
 vYm = 1;

//Variable SCK 
//var listDevice = ["2531","4162","4151"];//,"4139","3151", "3188", "3422", "4122", "1693", "3208", "4164"];// 
var devices = <?php echo json_encode($devices,true) ?>;
console.log(devices);

var listDevice = [];

devices.forEach(function(device){
  listDevice.push(device.deviceId);


} );
//var listDevice = <?php //echo json_encode($deviceIds) ?>;
//console.log(listDevice);

// TODO : recuperer les sensor id pour chaque device par lastest readings API SC
var sckSensorIds = [{bat : 17}, {hum : 13},{temp : 12},{no2 : 15}, { co: 16}, {noise : 7}, {solarPV : 18},{ambLight : 14 }];


var infoSensors = <?php echo json_encode($infoSensors); ?>;
//console.log(infoSensors);
//functions 

$(".btn").click(function(){
  value = $(this).val();
  $(".btn").removeClass("active");
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
    case "5": //bruit : noise
      list.push(7);
      break;
    case "6":
      showAllGraph();
      break;
    //default:
     // list.push(12,13);
     // break;
  } 
  for(var s=0;s<list.length; s++){
    var figGraph = "graphe_"+list[s];
    showGraph(figGraph);
  }
}
);


// Fonctions pour cacher et montrer les graphe
 function showAllGraph(){ $(".graphs").show(); }

 function showGraph(figGraph){ $("#"+figGraph).show(); }

 function hideAllGraph(){ $(".graphs").hide(); }

 function hideGraph(figGraph){ $("#"+figGraph).hide(); }

//
function setSVGForSensor(sensor) {

  var svgId = "sensor"+sensor;
  var figGraph = "graphe_"+sensor;
  var gId = svgId+"_g";
  //console.log(svgId);

  var svgObj = d3.select("#"+figGraph)
      .append("svg").attr("width",svgwidth).attr("height",svgheight)
      .attr("viewBox","0 0 "+svgwidth+" "+svgheight)
      .attr("preserveAspectRatio","xMidYMid meet")
      .attr("class","col-sm-12 svggraph")
      .attr("id", svgId);   //.style("visibility","hidden");
  var g = svgObj.append("g").attr("transform", "translate(" + gmargin.left + "," + gmargin.top + ")").attr("id", gId);

  var captionSensor =  d3.select("#"+figGraph).append("figcaption").text("Graph of sensor "+infoSensors[svgId].name+" ("+infoSensors[svgId].description+")");

  var objGraph = {svgid : svgId, 
        svg : svgObj,
        mesure : {description :  "", unit : "" }, 
        dimension : { width : +gwidth, 
              height : +gheight, 
              margin : gmargin },
      gid : gId , 
      domain : {Yn : vYn, Ym : vYm, Xn : vXn, Xm : vXm , domainInitialized : false},
      devices : [],
      divgraphid : figGraph,
      urlReqApi : "",
  };

  //console.dir(objGraph);
   //Voir si on peu ce passer de la mise en tableau
   var indexObjGraphe = (multiGraphe.push(objGraph)) - 1 ;
   //console.log(indexObjGraphe);
  return indexObjGraphe; 
}

function setLegend(deviceId,strkCol){

console.log(strockeColorArray);

  var idIM='icnmin_'+deviceId; 
  var idTL= 'textdevice_'+deviceId;
 // var stId = "sCol_"+deviceId;
  console.log(deviceId);
  console.log(idIM);
  //console.log(stId);
  var legendILSC="<a href='https://smartcitizen.me/kits/"+deviceId+"' target='_blank'><i class='fa fa-minus' id='"+idIM+"' style='color:"+strkCol+";'></i> SCK device "+deviceId+"</a>";

 // var iconMinus = "<i class='fa fa-minus' id='"+idIM+"' style='color:"+strkCol+";'></i>";

  var dLegend = d3.select("#legend").append("div").attr("id","legend_"+deviceId).attr("class","col-sm-12 col-xs-12");
  dLegend.append("span").html(legendILSC);


}

function showLegendGraph( ){


}


function updateTheDomain(xArray,yArray,indexGraphe){
  var yChanged = false;
  var xChanged = false;
  var Yn = multiGraphe[indexGraphe].domain.Yn;
  var Ym = multiGraphe[indexGraphe].domain.Ym;
  var Xn = multiGraphe[indexGraphe].domain.Xn;
  var Xm = multiGraphe[indexGraphe].domain.Xm;
 
  if( yArray[0] < Yn || Yn == 0) {
      multiGraphe[indexGraphe].domain.Yn = yArray[0]; yChanged = true; } //min
  if( yArray[1] > Ym || Yn == 0) { 
      multiGraphe[indexGraphe].domain.Ym = yArray[1]; yChanged = true; } //max
  if( yChanged == true || multiGraphe[indexGraphe].domain.domainInitialized == false ) { 
    y.domain([multiGraphe[indexGraphe].domain.Yn,multiGraphe[indexGraphe].domain.Ym]); }

  if(xArray[0].valueOf() < Xn.valueOf() ){ 
    multiGraphe[indexGraphe].domain.Xn = xArray[0]; xChanged = true;}
  if(xArray[1].valueOf() > Xm.valueOf() ){ 
    multiGraphe[indexGraphe].domain.Xm = xArray[1]; xChanged = true;}

  if( xChanged == true || multiGraphe[indexGraphe].domain.domainInitialized == false ) {
    x.domain([multiGraphe[indexGraphe].domain.Xn,multiGraphe[indexGraphe].domain.Xm]);
    multiGraphe[indexGraphe].domain.domainInitialized=true;
    }

}

function setAxisXY(indexGraphe,sensorkey){
  //console.log(indexGraphe);

  var gId = multiGraphe[indexGraphe].gid;
  var g = d3.select("#"+gId);
  var xAxisId="xAxis"+ multiGraphe[indexGraphe].svgid; 
  var yAxisId="yAxis"+ multiGraphe[indexGraphe].svgid; 
  var height = multiGraphe[indexGraphe].dimension.height;

  d3.select("#"+xAxisId).remove();    // TODO refaire la selection sur le graphe sensor
  d3.select("#"+yAxisId).remove();
    
    g.append("g")
      .attr("id", xAxisId)
      .attr("class", "theAxis")
      .attr("transform", "translate(0," + gheight + ")")
      .call(d3.axisBottom(x))
      /*
      .append("text")
      .attr("fill","#000")
      .attr("x", gwidth)
      .attr("text-anchor","end")
      .text("time")*/
      ;

    var sensorkunit = sensorkey+" "+infoSensors[multiGraphe[indexGraphe].svgid].unit ;
    //console.log(sensorkunit);
    g.append("g")
      .attr("id", yAxisId)
      .attr("class", "theAxis")
      .call(d3.axisLeft(y))
      .append("text")
      .attr("fill","#000")
      .attr("transform", "rotate(-90)")
      .attr("y", 8)
      .attr("dy", "0.71em")
      .attr("text-anchor","end")
      .text(sensorkunit)
      ;

  
}
//TODO : réglé le pb de color utiliser find dans array 
function setStrokeColorForDevice(device) {

  var stId = "sCol_"+device;
  if (strockeColorArray[stId] != null )
  {
    strockeColor = strockeColorArray[stId];
    //console.log("strockeColor alreadySet: "+strockeColor);
  } else
  {   // || strockeColorArray["sCol_"+device] ) {
      strockeColor = "rgb("+Math.floor((Math.random()*220)+1)+","+
      Math.floor((Math.random()*220)+1)+","+
      Math.floor((Math.random()*220)+1)+")";
      //console.log("new strockeColor :"+strockeColor);
      //stId = "sCol_"+device ;

      strockeColorArray[stId]=strockeColor;
    //console.log(strockeColorArray);
    setLegend(device,strockeColor);

  }
  
  return strockeColor;
}

function fillArrayWithObjectTimestampsAndValues(readings){
  var d=[];
  readings.forEach(
    function(item){
      var ts = new Date();
      ts.setTime(Date.parse(item[0]));
      ts.setSeconds(0)
      item[1] = +item[1];
      d.push({timestamps : ts, values : item[1]});
    }
  );
  return d;
}
/**
@function tracer
@strockeColor 
*/
function tracer(da,device,sensor,strokeColor="blue", indexGraphe,strokeWidth=1.5){
  
  var g = d3.select("#"+multiGraphe[indexGraphe].gid);

  var gpathId = "gpId_"+device+multiGraphe[indexGraphe].svgid; //ex : gpId_4162sensor17
  var graphClassSensor = "gcs_"+sensor;
      g.append("path")
        .datum(da)
        .attr("fill", "none")
        .attr("class", graphClassSensor)
        .attr("id", gpathId)
        .attr("stroke", strokeColor)
        .attr("stroke-linejoin", "round")
        .attr("stroke-linecap", "round")
        .attr("stroke-width", strokeWidth)
        .attr("d", line);
/*
      g.append("text")
      .datum(function(d){ return {id: d.id, value: d.values[d.values.length - 1]}; })
      .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
      .attr("x", 3)
      .attr("dy", "0.35em")
      .style("font", "10px sans-serif")
      .text(function(d) { return d.id; });*/
}

function graphe(device,sensors,readings,svgG){

  var de = fillArrayWithObjectTimestampsAndValues(readings);
  
    var xMinMax = d3.extent(de, function(d){return d.timestamps;});
    var yMinMax = d3.extent(de, function(d){return d.values;});

    updateTheDomain(xMinMax,yMinMax,svgG);
    strkCol = setStrokeColorForDevice(device);

  tracer(de,device,sensors,strkCol,svgG);
  
}



function showSCKDeviceOnMap(country,cp){
  console.log("montrer sur la carte");
  //console.log(country+" "+cp);

  var contextDeviceMap= <?php echo json_encode($sigDevicesForContextMap,true)?>;
  //console.log(contextDeviceMap);

  Sig.showMapElements(Sig.map, contextDeviceMap); 
  showMap(true);
  $('#ajax-modal').modal("hide");

}
/*
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
*/



jQuery(document).ready(function() {

  setTitle("Mesures","line-chart");
  
  if(devices.length>0){

 sckSensorIds.forEach(function (item){ 

    for( var e in item) {

      sensorId = item[e];
      var nametitle= "graphe_"+sensorId;
    
      var grapheTitle = d3.select("#graphs")
        .append("figure").attr("id",nametitle)
        .attr("class","col-xs-12 graphs");

      $("#"+nametitle).hide();
      
      var svgG = setSVGForSensor(sensorId); 


      //TODO : Adapter la largeur des graphe à l'écran de l'utilisateur

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

      }).done(function() {setAxisXY(svgG,sensorkey); });    
      
    }

  }
 });

 }

 $("#btn1").click().attr("clicked");

 //showSensor(); 


   
});

</script>