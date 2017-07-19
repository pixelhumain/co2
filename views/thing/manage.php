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


	if(empty($country)){$country='RE';}
?>

<?php 
	$devicesMongoRes = Thing::getSCKDevicesByLocality($country);

	$isAjaxR=(Yii::app()->request->isAjaxRequest);

?>

<style>

<?php if(!$isAjaxR ){ ?>
#managesck{
	margin-top: 40px;
	padding-top: 40px;
}
<?php }?>

  
</style>

<?php if(!$isAjaxR ){ ?>
	<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?>
<?php } ?>



<div class="col-xs-12 container" id="managesck">
	<div class="col-xs-12 <?php if($isAjaxR){echo 'hidden';}?> sck-maj" id="sck-maj-principal">
		<h4>Mettre à jour les métadatas de la base communecter</h4>
		<p>Si vous avez un compte <a href="https://smartcitizen.me" target='_blank'>smartcitizen.me</a> vous pourrez mettre à jours les adresse mac de vos kit qui sont communectés (double push). Utiliser le token smarticitizen, pour plus d'information sur l'authentification et le token voir la page <a href="http://developer.smartcitizen.me/#authentication" target='_blank'>developper.smartcitizen.me</a>.
		</p>

		<form name="formwithauth" class="form-inline col-sm-12" id="formupdatewithauth" action="javascript:updateSCKMetadata()">
			<span class='form-group col-sm-12' role='group'>
				<label class="col-xs-12 col-sm-3 col-md-3" for="tokenSC"> Token d'accès SC </label>
				<input class="col-xs-12 col-sm-4 col-md-4" type="text" id="tokenSC" name="tokenSC" value="">
				<button class="btn btn-default col-sm-4 col-md-3 " id="btn-updatesck" type="submit" > MAJ métadatas </button>
			</span>
		</form>
		<div class="hidden col-xs-12" id="resultat-update"></div>
	</div>

	<div class="col-xs-12 <?php if($isAjaxR){echo 'hidden';}?> sck-maj" id="sck-maj-secondaire">
		<h4>Ajouter les adresses mac des Smart-Citizen-kit</h4>
		<p> </p>
		<form name="formboardid" class="form-inline col-sm-12" id="formboardid" action="javascript:updateSCKBoardId()"> 
		<?php 
		foreach ($devicesMongoRes as $mdataDevice) {
	    	if($mdataDevice["boardId"]=="[FILTERED]"){
	          //$devices[]=$mdataDevice; 
	    ?>
	        <div class='form-group col-sm-12' role='group'>
	        	<span id='<?php echo $mdataDevice['_id'] ?>'> 
	            	<label class="col-sm-6 col-xs-12">Le kit 
	            		<a href='https://smartcitizen.me/kits/<?php echo $mdataDevice["deviceId"];?>' target='_blank'> <?php echo $mdataDevice["name"];?> (deviceId : <?php echo $mdataDevice["deviceId"];?>)
	            		</a>
	            	</label>
	            	<span class="col-sm-6 col-xs-12" id=" ">
	            		<input type='text' class="deviceids form-control" name='mac-sck-<?php echo $mdataDevice['deviceId']?>' id='mac-sck-<?php echo $mdataDevice['deviceId']?>' value="">  
	            		<input class='idMdataDevice hide' name='idmeta<?php echo $mdataDevice['deviceId']?>' value='<?php echo $mdataDevice['_id'] ?>' readonly>
	            		<i class="fa fa-check hidden "> </i>
	            	</span>
	        	</span>
	        </div>
	    <?php } 
	    }?>
     		<input id="btnudpateboardid" type="submit" value="Mettre à jour">
		</form>
	</div>
</div>

<?php if(!$isAjaxR ){ 
	 $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); 
} ?>

<script>

patternMacId = /([0-9a-f]{2}[:-]){5}([0-9a-f]{2})/;

function updateSCKBoardId(){

	sckDeviceIdBoardId=[];
	$.each(devicesMongoRes, function(id,mdata){ 
		deviceId= mdata.deviceId;
		boardId = $("#mac-sck-"+deviceId).val();
		//mylog.log("board : "+boardId);

		if(patternMacId.test(boardId)){
			$("#mac-sck-"+deviceId).addClass("has-success");
			sckDeviceIdBoardId.push({deviceId,boardId});

		} /*else if (boardId==""){
			mylog.log("warning");
			$("#mac-sck-"+deviceId).addClass("has-warning");
		}else{
			mylog.log("error");
			$("#mac-sck-"+deviceId).addClass("has-error");
		} */
	} );

	//mylog.log(sckDeviceIdBoardId);
	//JSON.stringify(sckDeviceIdBoardId);
	urlrequest = baseUrl+'/'+moduleId+'/thing/updatesckdevices';
	$.ajax({ 
	  type: 'POST',
      url: urlrequest,
      data: {listbd : sckDeviceIdBoardId},
      dataType: "json",
      crossDomain: true,
      success: function(data){

      	mylog.log("success");
      },
      error : function (data) {mylog.log("Error : ajax not success"); }
      }).done(function() {
       //mylog.log('post done');
      });


}

function updateSCKMetadata(){
	//$.blockUI({ message: "<div> update en cours</div>" });
	mylog.log("updateSCKMetadata *** ");
	atSC = $("#tokenSC").val();
	if(atSC==""){ 
		urlrequest = baseUrl+'/'+moduleId+'/thing/updatesckdevices';
	}else{ 
		urlrequest = baseUrl+'/'+moduleId+'/thing/updatesckdevices?atSC='+atSC; 
	}

	$("#btn-updatesck").removeClass("btn-default");
	$("#btn-updatesck").addClass("btn-warning");
	
	mylog.log('urlrequest : ' +urlrequest);

	$.ajax({ 
		type: 'GET',
    	url: urlrequest,
    	dataType: "json",
		crossDomain: true,
		success: function (data) {
		$("#btn-updatesck").removeClass("btn-warning");
		$("#btn-updatesck").addClass("btn-success");
		},
		error : function (data) {mylog.log("Error : ajax not success"); }
	}).done(function(data) {
		textres="";
		if(notNull(data.devicesmetadata.elementsAlreadyUpdate) && data.devicesmetadata.elementsAlreadyUpdate>0 ){
			textres+='<p> Nombres d\'élements déjà MAJ : '+ data.devicesmetadata.elementsAlreadyUpdate+ '</p>';
		}
		if(notNull(data.devicesmetadata.elementsUpdated) && data.devicesmetadata.elementsUpdated>0){
			textres+= '<p> Nombres d\'élements mis à jour : '+ data.devicesmetadata.elementsUpdated+ '</p>';
		}
		if(notNull(data.devicesmetadata.elementsBad) && data.devicesmetadata.elementsBad>0 ){
			textres+= '<p> Nombres d\'élements non mis à jour : '+ data.devicesmetadata.elementsBad+ '</p>';
		}
		if( notNull(data.APIMetadata) && data.APIMetadata.length>0){ 
			data.APIMetadata.forEach(
				function(item,index){
				mylog.log("méta API maj : ");
				textres+= '<p> Metadata API mis à jour : '+item+' .</p>' ;
			});
		}

		$("#resultat-update").html(textres);

		$("#resultat-update").removeClass("hidden"); 
		$("#btn-updatesck").addClass("btn-success");
	});
}

jQuery(document).ready(function() {
	initKInterface({"affixTop":0});

	devicesMongoRes = <?php echo json_encode($devicesMongoRes); ?> ;

	//mylog.log(devicesMongoRes);

	/*
	$("#btn-updatesck").off().on("click",function(){ 
		mylog.log("*** #btn-updatesck * ");
		updateSCKMetadata(); });
	*/
	
	setTitle("Gestion SCK","fa-database");
});

</script>