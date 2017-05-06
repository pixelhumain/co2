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
$sensors= array();

$country=null;  $regionName=null; $depName=null;  $cityName = null;

if($communexion["state"] == false){

  $country='RE';
}else {
  $depName  = (!empty($communexion['values']['depName']))   ?   $communexion['values']['depName']: null;
  $cityName = (!empty($communexion['values']['cityName']))  ?   $communexion['values']['cityName']: null;
  $regionName=(!empty($communexion['values']['regionName']))?   $communexion['values']['regionName']: null;
}

$devices = Thing::getSCKDevicesByLocality($country, $regionName, $depName, $cityName, null, null);
// Le type doit etre unique pour getSCKDeviceMdata findOne prend la première ocurrence :
$sckMdataSensors = (array) (Thing::getSCKDeviceMdata(Thing::COLLECTION_METADATA,array("type"=>"sckSensors")));
//var_dump($devices);
//$sckInfo['sckSensors']=settype($sckMdataSensors,'array' );
//echo '<br>';
$sckSensors=$sckMdataSensors['sckSensors'];
$deviceByLocality = array();

foreach ($devices as $id => $device) {
  
  if($device['boardId']=='[FILTERED]'){
    $sckInfo['boardIdFiltered']++;
  }else{
    //TODO ou Amelioration : Envoyé un message resultat pour signaler les boardId (device) qui ne sont pas dans la base communecter (pas double push)
    /* TODO : mettre des description de sensor pour différente version de kit 1.1 1.2 ...etc... 
    * Utiliser device['kit'] pour la version sckSensors et measurement
    */
    if(isset($device['sensors']) && !empty($device['sensors']) && $sckInfo['sensorsCheck']==false){
        $sckInfo['sensorsCheck']=true;
        $sensors = $device['sensors'];
        //$array
//var_dump($sckSensors);
        foreach ($sensors as $key => $sensor) {
          foreach ($sckSensors as $sckSensor) {
            //var_dump($sckSensor);
            if($sckSensor['id'] == $sensor['id']){
              if(!empty($sckSensor['measurement']))
                $sensors[$key]['measurement']=$sckSensor['measurement']; 
              break;
            } 
          }
        }
        //echo '<br>';
        //var_dump($sensors);
    }

    if(isset($device['address'])){

      $newDevice= array("deviceId"=>$device['deviceId'],"name"=>$device['name'],"boardId"=>$device['boardId'],
          "sensors"=>array(),"timestamp"=>$device['timestamp'],"geo"=>$device['geo'],"latestCODB"=>array() ); // TODO ? : ajouter kit ? 
      $newSensor=array();

      $lastesRecordsCODB[$device['deviceId']] = Thing::getLastestRecordsInDB($device['boardId']);
      if(empty($lastesRecordsCODB[$device['deviceId']])){
        $sckInfo['notInCODB'][$device['deviceId']]=true;
        //unset($lastesRecordsCODB[$device['deviceId']]);
        //unset($devices[$id]);
      }else{
        $newDevice['latestCODB']=$lastesRecordsCODB[$device['deviceId']];
      }
//Voir l'utilité :
      foreach ($device['sensors'] as $key => $nsensor) {
        $newSensor[$nsensor['id']] = $device['sensors'][$key];
        unset($newSensor[$nsensor['id']]['id'],$newSensor[$nsensor['id']]['ancestry'],$newSensor[$nsensor['id']]['created_at']);
        unset($newSensor[$nsensor['id']]['updated_at'], $newSensor[$nsensor['id']]['uuid']);  
      }
      $newDevice['sensors']=$newSensor;
//

      if(isset($device['address']['addressLocality'])){
        $deviceByLocality[$device['address']['addressLocality']][$id]=$newDevice;

      }else if(isset($device['address']['postalCode'])){
        $deviceByLocality[$device['address']['postalCode']][$id]=$newDevice;
      }
    }

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
//$sensors= $lastReadDevice["data"]["sensors"];


?>


<style type="text/css">
  .row-codb{
    background-color: #edfeed;

  }

</style>

<div class="col-sm-12 col-md-12 container">

<?php 
if(!empty($sensors)){
  foreach ($sensors as $sensor) {
    $itemSckSensor=array();

?>
  <div class="col-sm-12 no-padding no-margin"  id="sensor-<?php echo $sensor['id']?>">
  <div class="row col-sm-12">
   <h4 class="text-blue col-md-4 col-sm-4 col-xs-12" id='h-title-<?php echo $sensor['id']?>'>
   <i class='fa ' id='h-title-icon-<?php echo $sensor['id']?>' ></i> <span class='' id='h-title-text-<?php echo $sensor['id']?>'> <?php echo $sensor['measurement']['name'] ?> </span> </h4>
   
   <div class="col-md-8 col-sm-8 hidden-xs" class="h-desc-<?php echo $sensor['id']?>">

   <?php echo $sensor['measurement']['description'] ?>

   </div>
  </div>

  <?php 
  foreach ($deviceByLocality as $locality => $listdevices) {
  ?>
  <div class="row col-sm-12 no-padding no-margin">
  <h5 class="text-green no-padding no-margin">
    <span class="col-md-3 col-sm-3 col-xs-12">Ville</span>
    <span class="col-md-4 col-sm-4 col-xs-12">Nom du SCK <span class="hidden-xs"> | Capteur</span></span>
    <span class="col-md-3 col-sm-3 col-xs-12">Timestamp</span>
    <span class="col-md-2 col-sm-2 col-xs-12">Valeur (<?php echo $sensor['unit'] ?>)</span>
    
  </h5>
  
  </div>
  <div class="row col-sm-12 no-padding no-margin">
    
    <h5 class="col-md-3 col-sm-3 col-xs-12 title-<?php echo $locality ?>"> <?php echo $locality ?> </h5>

    <div class="row col-md-9 col-sm-9 col-xs-12 no-padding no-margin " >
    <?php 
    foreach ($listdevices as $ndevice) {
      ?>
      <div class="row col-sm-12 col-md-12 no-padding no-margin">
        <div class="col-sm-5 col-md-5 no-padding no-margin">
          <h6 class="col-sm-12 col-md-12"><?php echo $ndevice['name'] ?> <span class="hidden-xs">| <?php echo $ndevice['sensors'][$sensor['id']]['name'] ?></span>
          </h6>
        </div>
        <div class="col-sm-7 col-md-7 no-padding no-margin">

          <div class="row col-md-12 col-sm-12 row-codb no-padding no-margin">
          <?php 
            $fromCOdb=(empty($ndevice['latestCODB']))? false : true;
            $latestInfo=($fromCOdb)? "latestCODB" : "lastUpdatePOI" ;
           ?>

            <div class="col-md-7 col-sm-7 no-padding no-margin text-center" title="<?php echo $latestInfo?>">
           
            <?php 
            if($fromCOdb){
              echo $ndevice['latestCODB']['timestamp'];
            }else{
              echo $ndevice['timestamp'];
            }
            ?>
        
            </div>

            <div  class="col-md-5 col-sm-5 no-padding no-margin text-center" title="<?php echo $latestInfo?>">
         
            <?php 
            if($fromCOdb){
              echo $ndevice['latestCODB'][$sensor['measurement']['name']];
            }else{
              echo $ndevice['sensors'][$sensor['id']]['value'] ;
            }
            ?>
   
            </div>
          
          </div>
        


        
        
        <div  class="row col-sm-12 col-md-12 row-api no-padding no-margin " id="row-api-sensor<?php echo $sensor['id']."-device".$ndevice['deviceId'] ?>" ></div>
       </div>
      </div>
    <?php
    } ?>
    </div>

  </div>
  <?php 
  }
  ?>

  </div>

<?php
  }

} ?>
  

<section class="col-sm-12 row" id="sectiontable">
  <div class="col-md-10 table-responsive">
	<table id="tableau" class="table table-bordered table-striped table-condensed">
 		<caption><h4 id="tablecaption"></h4></caption>
   		<thead>
   		 <tr id="trh">
   			<!--th>id</th><th>name</th><th>value API</th><th>value CO</th><th>unit</th><th class="hide description">description</th-->
   		 </tr>
   		</thead>
   		<tbody id="tbody"> 

      </tbody>
   	</table>
  </div>
</section>

	<div id="resphp">
<!-- pour Test fonction php -->

	</div>

	<div id="resjs"> 
			<!-- pour Test fonction js -->

	</div>
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
