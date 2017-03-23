<?php
	$cs = Yii::app()->getClientScript();

	// $cssAnsScriptFilesModule = array(
	// 	'/plugins/d3/d3.v3.min.js',
	// );
	// HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->request->baseUrl);
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath ,
                                "page" => "thing") ); 


	if(empty($country) || !isset($country)){$country='RE';}
?>

<?php 
	$devicesMongoRes = Thing::getSCKDevicesByCountryAndCP($country);

?>

<div class="col-xs-12" id="">
	<div>
		<h3>Pour mettre à jour l'adresse mac avec le deviceId du Smart-Citizen-kit</h3>
	</div>
	<div class="col-xs-12">
		<form class="form-inline col-sm-12" id="sckdevicesform" action="javascript:updateSCKBoardId()"> 
			<?php foreach ($devicesMongoRes as $mdataDevice) {
			if($mdataDevice["boardId"]=="[FILTERED]"){
  			$devices[]=$mdataDevice;
  			echo "<div class='form-group col-sm-12' role='group'><span id='".
  				$mdataDevice['_id']."'> <label>Entrer l'adresse mac du sck ".$mdataDevice['deviceId']." : </label>".
  				" <input type='text' name='boardId' id='inputBoardId_sck".$mdataDevice['deviceId'].
  				"'></span> <input class='idMdataDevices' id='idsck".$mdataDevice['deviceId']."' value='".$mdataDevice['_id']."' readonly> </div>";

  			//echo  $mdataDevice['deviceId']." <br> \n";
  			//echo  $mdataDevice['_id']." <br> \n";
  		}

		}?>
		 <input type="submit" value="Mettre à jour">
		</form>
		
	</div>

</div>
<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?>






<script>

function setRowForm(){
	$("#sckdevicesform")
}

function updateSCKBoardId(){

}



jQuery(document).ready(function() {

  setTitle("Manage","fa-database");

  });

</script>