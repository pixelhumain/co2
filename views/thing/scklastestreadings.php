<?php 
$cssAnsScriptFilesModule = array(
     
	);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->request->baseUrl);    
//$cs = Yii::app()->getClientScript();

$params = CO2::getThemeParams();
 
$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
  
$isAjaxR=(Yii::app()->request->isAjaxRequest);

if(!$isAjaxR){

//header + menu
	$this->renderPartial($layoutPath.'header', 
                    array(  "layoutPath"=>$layoutPath ,
                            "page" => "thing") );
}

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

?>

<style type="text/css">

.row-codb{
	background-color: #ddfeee;

}

</style>

<div class="col-sm-12 col-md-12 container">

<?php 
if(!empty($sensors)){
	foreach ($sensors as $sensor) {
    	$itemSckSensor=array();
// TODO : faire une div avec les boutons selection pour la page standalone
// remplir une variable avec tous les boutons et l'utilisé en js pour l'afficher si standalone class des bouton mm que ce dans thing
?>
	<div class="col-sm-12 no-padding no-margin reading hidden" id="sensor-<?php echo $sensor['id']?>">
		<div class="row col-sm-12">
			<h4 class="text-blue col-md-4 col-sm-4 col-xs-12" id='h-title-<?php echo $sensor['id']?>'>
				<i class='fa ' id='h-title-icon-<?php echo $sensor['id']?>' ></i> 
				<span class='' id='h-title-text-<?php echo $sensor['id']?>'> <?php echo $sensor['measurement']['name'] ?> </span> 
			</h4>
			<div class="col-md-8 col-sm-8 hidden-xs" class="h-desc-<?php echo $sensor['id']?>">
				<?php echo $sensor['measurement']['description'] ?>
			</div>
		</div>

		<div class="row col-sm-12 no-padding no-margin">
			<h5 class="text-green no-padding no-margin">
			<span class="col-md-2 col-sm-2 col-xs-12">Ville</span>
			<span class="col-md-4 col-sm-4 col-xs-12">Nom du SCK <span class="hidden-xs"> | Capteur</span></span>
			<span class="col-md-4 col-sm-4 col-xs-12 text-center">Timestamp</span>
			<span class="col-md-2 col-sm-2 col-xs-12 no-padding no-margin">Val<span class="hidden-xs no-padding no-margin">eur</span>(<?php echo $sensor['unit'] ?>)</span>
			</h5>
		</div>

		<?php 
		foreach ($deviceByLocality as $locality => $listdevices) {
		?>

		<div class="row col-sm-12 no-padding no-margin">

			<h5 class="col-md-2 col-sm-2 col-xs-12 title-<?php echo $locality ?>"> <?php echo $locality ?> </h5>

			<div class="row col-md-10 col-sm-10 col-xs-12 no-padding no-margin " >
			<?php 
			foreach ($listdevices as $ndevice) {
			  //$bcolor=
			?>
			<div class="row col-sm-12 col-md-12 no-padding div-device" style=" ">
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
								if(!empty($ndevice['latestCODB']['timestamp']))
									echo $ndevice['latestCODB']['timestamp'];
							}else{
								if(!empty($ndevice['timestamp']))
									echo $ndevice['timestamp'];
							}
						?>
						</div>

						<div  class="col-md-5 col-sm-5 no-padding no-margin text-center" title="<?php echo $latestInfo?>">
						<?php 
						if($fromCOdb){
							if(!empty($ndevice['latestCODB'][$sensor['measurement']['name']]))
								echo round($ndevice['latestCODB'][$sensor['measurement']['name']],3);
						}else{
							if (!empty($ndevice['sensors'][$sensor['id']]['value']))
								echo round($ndevice['sensors'][$sensor['id']]['value'],3) ;
						}
						?>
						</div>
					</div>

					<div  class="row col-sm-12 col-md-12 row-api no-padding no-margin hidden" id="row-api-sensor<?php echo $sensor['id']."-device".$ndevice['deviceId'] ?>" >
						<div class="col-md-7 col-sm-7 no-padding no-margin text-center" id="api-timestamp-sensor<?php echo $sensor['id']."-device".$ndevice['deviceId'] ?>" title="obtenue par api.smartcitizen.me" >

						</div>
						<div class="col-md-5 col-sm-5 no-padding no-margin text-center" id="api-value-sensor<?php echo $sensor['id']."-device".$ndevice['deviceId'] ?>"  title="obtenue par api.smartcitizen.me" >

						</div>

					</div>
				</div>
			</div>
			<?php
			} //fin foreach listdevice
			?>
			</div>
		</div>
		<?php 
		} // fin foreach devicebylocality
		?>
		<hr class="col-md-12 col-sm-12 col-xs-12 no-padding ">
	</div>

<?php
  	} // fin foreach sensor
} // fin if
?>
  
</div>

<?php if(!$isAjaxR ){ 
$this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); 
} ?>

<script>
//en correspondance avec subcat dans le fichier thing.json
var subcatscktoshow = [{"Temperature et humidité" : ["temp", "hum" ] }, {"Gaz":["co", "no2"]}, {"Lumière":["lum"]} , {"Bruit":["noise"]} , {"Nets" :["nets"]}, {"Énergie":["bat","pv"]}, {"Tous": ["all"]}];

var deviceByLocality=<?php echo json_encode($deviceByLocality) ; ?>; 

var urlReq="<?php echo Thing::URL_API_SC ?>/devices/";

var devicelastreads = <?php echo json_encode($devices); ?>;

jQuery(document).ready(function() {
	initKInterface({"affixTop":0});

	mylog.log(deviceByLocality);
	for(var v in deviceByLocality){
	// for chaque ville (si plusieur ville)
		for(var id in deviceByLocality[v]){
			mylog.log(deviceByLocality[v][id].deviceId);
			getDeviceReadings(deviceByLocality[v][id].deviceId);
		}
	}
	setTitle("Dernières mesures","cog");
});


function getDeviceReadings(deviceId) {
	if(notNull(deviceId)){
		$.ajax({
			type: 'GET',
			url: urlReq+deviceId,
			dataType: "json",
			crossDomain: true,
			success: function (data) {
				//mylog.log(data); //resultat de la requete à l'api
				if(data.id==deviceId){
					sensors = data.data.sensors;
					thetimestamp = data.data.recorded_at;
					sensors.forEach(function(item, index){
						sensorId = item.id;
						//value = Math.round(item.value*1000)/1000;
						value = +(Math.round(item.value + "e+3")  + "e-3");
						$("#api-timestamp-sensor"+sensorId+"-device"+deviceId).text(thetimestamp);
						$("#api-value-sensor"+sensorId+"-device"+deviceId).text(value);
						$("#row-api-sensor"+sensorId+"-device"+deviceId).removeClass("hidden");
					});
				}
			},
			error: function (data) { 
				mylog.log("Error : ajax not success"); 
			}
		}).done(function() { mylog.log("ajax api.smartcitizen.me done");  });
	} 
} 

/* Première version en tableau (tous étaient créé coté client)
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
  }); */ 

</script>
