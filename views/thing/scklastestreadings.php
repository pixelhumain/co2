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
    if($isAjaxR){


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
//var_dump($communexion);
        if($communexion["state"] == false){
          //$postalCode= " " ;
        }else{
         $depName = (!empty($communexion['values.depName'])) ? $communexion['values.depName']: null;
         //$cityName = (!empty($communexion['values.cityName']))? $communexion['values.cityName']: null;
         $regionName = (!empty($communexion['values.regionName'])) ? $communexion['values.regionName'] : null;
         //$cp = (!empty($communexion['values.cityCp.value']))? $cp = $communexion['values.cityCp.value']: null;

         $devices = Thing::getSCKDevicesByLocality(null, $regionName, $depName); // $cityName, $cp, null);
        }
/*
if(!empty($devices)){$deviceId = reset($devices)['deviceId'];

  }
  */
if(empty($device) || !isset($device)){$device=0; }


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

?>

<div class="col-sm-12 col-md-10 container">
  <section class="col-sm-12 row">
	 <h3 class="text-blue">Dernières mesures Smart-Citizen-Kits</h3>
	 <form class="form-inline"> 
        <div class="form-group col-sm-12">
          <!--label for="select" class="col-xs-12 col-sm-3 control-label">Choix des device</label>
          <select class="control-select col-xs-11 col-sm-8" name="device" id="deviceSelector" multiple="multiple">
          	<option value="0" id="opemptydevice">Aucun Smartcitizen ici</option>

            <option value="4162">4162 (boardId)</option>
            <option value="4151">4151 (boardId)</option>
          </select-->
          <!--button class="pull-right btn btn-default" type='button' id="btn-refresh"><i class="fa fa-refresh"></i></button-->
        </div>
     </form>

   </div>
  </section>
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
    devices =  <?php echo json_encode($devices); ?>;
    



    setTitle("Dernières mesures","cog");
   //Index.init();
  });



</script>

