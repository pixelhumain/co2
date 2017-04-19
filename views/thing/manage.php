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

<style>
#managesck{
  margin-top: 40px;
  padding-top: 40px;

}
  
</style>

<div class="col-xs-12 container" id="managesck">
	<div class="col-xs-12">
		<h3>Pour mettre à jour la base communecter avec un compte smartcitizen.me</h3>
		<p>Si vous avez un compte <a href="https://smartcitizen.me" target='_blank'>smartcitizen.me</a> vous pourrez mettre à jours les adresse mac de vos kit qui sont communectés (double push).</p>
		<p>Pour avoir votre acces_token smartcitizen copier le 
		<form name="formwithauth" class="form-inline col-sm-12" id="formupdatewithauth" action="javascript:updateSCKBoardId()">
		<div class='form-group col-sm-12' role='group'></div></form>

	</div>

	
	<div class="col-xs-12">
		<h3>Pour mettre à jour l'adresse mac avec le deviceId du Smart-Citizen-kit</h3>
	</div>
	<div class="col-xs-12">
		<form name="formboardid" class="form-inline col-sm-12" id="formboardid" action="javascript:updateSCKBoardId()"> 
		  <?php foreach ($devicesMongoRes as $mdataDevice) {
			if($mdataDevice["boardId"]=="[FILTERED]"){
  				$devices[]=$mdataDevice; ?>
  			<div class='form-group col-sm-12' role='group'>
  				<span id='<?php echo $mdataDevice['_id'] ?>'> 
  					<label class="col-sm-4 col-xs-12">Le kit <a href='https://smartcitizen.me/kits/<?php echo $mdataDevice["deviceId"];?>' target='_blank'> <?php echo $mdataDevice["name"];?> (deviceId : <?php echo $mdataDevice["deviceId"];?>)</a></label>
  					<span class="col-sm-8 col-xs-12"><input type='text' name='macsck<?php echo $mdataDevice['deviceId']?>' id='macsck<?php echo $mdataDevice['deviceId']?>'>  
  					<input class='idMdataDevice hide' name='idmeta<?php echo $mdataDevice['deviceId']?>' value='<?php echo $mdataDevice['_id'] ?>' readonly>
  					</span>
  				</span>
  			</div>
  			<?php } 
		  }?>
		 <input id="btnudpateboardid" type="submit" value="Mettre à jour">
		</form>
	</div>

</div>
<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?>






<script>

function setRowForm(){
	$("#formboardid")
}

function validatorMacId(boardId){

}

function updateSCKBoardId(){
	console.log("submit post");
}



jQuery(document).ready(function() {

  setTitle("Manage","fa-database");

  });

</script>