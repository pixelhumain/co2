<?php 
  /*$cssAnsScriptFilesModule = array(
      //'/plugins/d3/d3.v3.min.js',
      //'/plugins/d3/c3.min.js',
      //'/plugins/d3/c3.min.css',
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
    */

$params = CO2::getThemeParams();
 
$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
  
$isAjaxR=(Yii::app()->request->isAjaxRequest);
if(!$isAjaxR){

  //header + menu
  $this->renderPartial($layoutPath.'header', 
                    array(  "layoutPath"=>$layoutPath ,
                            "page" => "thing") );
}
?>

<!--?php
	$cs = Yii::app()->getClientScript();
	// if(!Yii::app()->request->isAjaxRequest)
	// {
	  	/*$cssAnsScriptFilesModule = array(
	  		'/plugins/d3/d3.v3.min.js',
        '/plugins/d3/c3.min.js',
        '/plugins/d3/c3.min.css',
        '/plugins/d3/d3.v4.min.js',

	  	);*/
	  	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->request->baseUrl);
  	// }

?-->
<?php
//(Page en chantier)

$communexion = CO2::getCommunexionCookies();

$sckInfo=array('boardIdFiltered'=>0,'sensorsCheck'=>false, 'sckSensors'=>false, 'notInCODB'=>array());

$devices  = array();
$lastesRecordsCODB=array();

$country=null;  $regionName=null; $depName=null;  $cityName = null;

if($communexion["state"] == false){
  $country='RE';
}else {
  $depName  = (!empty($communexion['values']['depName']))   ?   $communexion['values']['depName']: null;
  $cityName = (!empty($communexion['values']['cityName']))  ?   $communexion['values']['cityName']: null;
  $regionName=(!empty($communexion['values']['regionName']))?   $communexion['values']['regionName']: null;
}

$devices = Thing::getSCKDevicesByLocality($country, $regionName, $depName, $cityName, null, null);

foreach ($devices as $id => $device) {
  
  if($device['boardId']=='[FILTERED]'){
    $sckInfo['boardIdFiltered']++;
  }else{
    //TODO ou Amelioration : Envoyé un message resultat pour signaler les boardId (device) qui ne sont pas dans la base communecter (pas double push)
    $lastesRecordsCODB[$device['deviceId']] = Thing::getLastestRecordsInDB($device['boardId']);
    if(empty($lastesRecordsCODB[$device['deviceId']])){
      $sckInfo['notInCODB'][$device['deviceId']]=true;
    }else{

      # code ...

    }
    if(isset($device['sensor'])&& $sensorsCheck==false){
        $sckInfo['sensorsCheck']=true;
        $sensors = $device['sensors'];
    }

  }
  
}
$sckMdataSensors = (Thing::getSCKDeviceMdata(Thing::COLLECTION_METADATA,array("type"=>'sckSensors')));

$sckInfo['sckSensors']=settype($sckMdataSensors,'array' );

if(!empty($sensors)){
  var_dump($sensors);

  foreach ($sensors as $sensor) {

    # code...
  }

}


/*
if(!empty($devices)){$deviceId = reset($devices)['deviceId'];

  }
  */

//$sckdevicemdata = Thing::getSCKDeviceMdata(Thing::COLLECTION,array("type"=>Thing::SCK_TYPE, "deviceId"=> strval($deviceId)));
//print_r($sckdevicemdata);
/*
echo "</br>\n";
$sckmeasurements = Thing::getSCKDeviceMdata(Thing::COLLECTION,array("type"=>"sckMeasurements"))["sckMeasurements"];
//print_r($sckmeasurements);
//boardId et deviceId namepoi
$boardId=$sckdevicemdata["boardId"];
//echo $boardId;

$record = Thing::getConvertedRercord($sckdevicemdata["boardId"],true,"2017-02-28");
//$json = file_get_contents("https://api.smartcitizen.me/v0/devices/". $deviceId);

//$lastReadDevice = json_decode($json ,true);
/*$lReadingsAPI = Thing::getLastedReadViaAPI($device);
$sensors = $lReadingsAPI["sensors"];//
*/


//print_r($sensors2);
//$sensors= $lastReadDevice["data"]["sensors"];
//print_r($sensors);
// var_dump($devices);
echo '<br>';
var_dump($lastesRecordsCODB);
echo '<br>';
//var_dump($sensors);


?>

<div class="col-sm-12 col-md-12 container">
  <div class="col-sm-12 row">
	 <h4 class="text-blue col-md-3 col-sm-3 col-xs-12" id='h-title'>
   <i class='fa ' id='h-title-icon' ></i> <span class='hidden-xs' id='h-title-text'> </span></h4>
	 <div class="col-md-3 col-sm-4 col-xs-12" id='h-sensorunit'> 
    <span class="col-md-6 col-xs-7" id='h-sensor'> </span> <span class="col-md-4 col-xs-5" id='h-unit'> </span> 
        
   </div>
   <div class="col-md-6 col-sm-7 hidden-xs" class="h-desc">
   </div>
  </div>

  </div>
</div>

<section class="col-sm-12 row" id="sectiontable">
  <div class="col-md-10 table-responsive">
	<table id="tableau" class="table table-bordered table-striped table-condensed">
 		<caption><h4 id="tablecaption"></h4></caption>
   		<thead>
   		 <tr id="trh">
   			<!--th>id</th><th>name</th><th>value API</th><th>value CO</th><th>unit</th><th class="hide description">description</th-->
   		 </tr>
   		</thead>
   		<tbody id="tbody"> 	</tbody>
   	</table>
  </div>
</section>

	<div id="resphp">
<!-- pour Test fonction php -->

	</div>

	<div id="resjs"> 
			<!-- pour Test fonction js -->

	</div>

<?php if(!$isAjaxR ){ ?>
<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?>
<?php } ?>


<script>

var urlReq="<?php echo Thing::URL_API_SC ?>/devices/";

function getDeviceReadings(){
  
  //var device = parseInt($("#deviceSelector").val());
  //console.log(device);
  //hideAllGraph();
  /*
  $.ajax({

      type: 'GET',
      url: urlReq,
      dataType: "json",
      crossDomain: true,
      success: function (data) {
        //console.dir(data);

        },
      error: function (data) { console.log("Error : ajax not success"); 
      //console.log(data); 
      }

      }).done(function() {  });
  */
   
} 

/*
	var sensors = <?php //echo json_encode($sensors); ?>;

	var tbody = document.getElementById("tbody");
	
	sensors.forEach( function(item){ 
    
		var ligne=[item.id,item.name,item.value,item.value,item.unit,item.description];
		var tr = document.createElement("tr");
		tbody.appendChild(tr);

		for (var i=0;i<ligne.length;i++){
		var td = document.createElement("td");
		td.innerHTML=ligne[i].toString();
    if(i==ligne.length-1){
      td.setAttribute("class","hide description"); 
      //td.setAttribute("id","" )
    }
		tr.appendChild(td);
		}
		tbody.appendChild(tr);

	});

*/  

  jQuery(document).ready(function() {
    initKInterface({"affixTop":0});

    //$("#deviceSelector").append("option")
   // devices =  <?php // echo json_encode($devices); ?>;
    



    setTitle("Dernières mesures","cog");
   //Index.init();
  });



</script>

