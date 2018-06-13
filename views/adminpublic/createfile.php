<?php
$cs = Yii::app()->getClientScript();
$cssAnsScriptFilesModule = array(
		'/plugins/jsonview/jquery.jsonview.js',
		'/plugins/jsonview/jquery.jsonview.css',
		'/plugins/JSzip/jszip.min.js',
		'/plugins/FileSaver.js/FileSaver.min.js',
		//'/assets/js/sig/geoloc.js',
		/*'/assets/js/dataHelpers.js',
		'/assets/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
		'/assets/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js'*/
		'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
		'/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->request->baseUrl);


$userId = Yii::app()->session["userId"] ;

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
//header + menu
$this->renderPartial($layoutPath.'header', 
		    array(  "layoutPath"=>$layoutPath , 
						    "page" => "admin") ); 
?>

<style>
	.bg-azure-light-1{
		background-color: rgba(43, 176, 198, 0.3) !important;
	}
	.bg-azure-light-2{
		background-color: rgba(43, 176, 198, 0.7) !important;
	}
	.bg-azure-light-3{
		background-color: rgba(42, 135, 155, 0.8) !important;
	}

	.menu-step-tsr div{
		margin-left: 20px;
	    font-size: 18px;
	    width: 15%;
	    text-align: center;
	    display: inline-block;
	    margin-top:15px;
	    margin-bottom:5px;
	}
	.menu-step-tsr div.homestead{
		font-size:12px;
	}
	.menu-step-tsr div.selected {
	    border-bottom: 7px solid white;
	}

	.block-step-tsr div{
		font-size: 18px;
	    text-align: center;
	    display: inline-block;
	    margin-top:15px;
	    margin-bottom:15px;
	}

	.mapping-step-tsr{
	    display: inline-block;
	    margin-top:15px;
	    margin-bottom:15px;
	}

	.nbFile{
	    font-size: 18px;
	}

	.divJsonClass{
		height: 300px;
	}
	.modal-title-delete{
		color : red;
	}
</style>


<div class="col-xs-12 no-padding bg-white">
	<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding">

		<!-- HEADER -->
		<center>
			<div class="col-md-12 center bg-azure-light-3 menu-step-tsr section-tsr center">
				<div class="homestead text-white selected" id="menu-step-1">
					<i class="fa fa-2x fa-circle"></i><br/><?php echo Yii::t("common", "Source"); ?>
				</div>
				<div class="homestead text-white" id="menu-step-2">
					<i class="fa fa-2x fa-circle-o"></i><br/><?php echo Yii::t("common", "Link"); ?>
					
				</div>
				<div class="homestead text-white" id="menu-step-3">
					<i class="fa fa-2x fa-circle-o"></i><br/><?php echo Yii::t("common", "Visualisation"); ?>
				</div>
				<div class="homestead text-black"><i class="fa fa-2x fa-info-circle"></i><br/><a href="https://wiki.communecter.org/fr/importer-des-donn%C3%A9es.html"  target="_blank" class="homestead text-black"><?php echo Yii::t("import", "Documentation"); ?></a></div>
			</div>
		</center>
		<!-- SOURCE STEP1 -->
		<div class="col-sm-12 block-step-tsr section-tsr" id="menu-step-source">
			<div class="col-sm-4 col-xs-12">
				<label for="chooseElement"><?php echo Yii::t("common", "Element"); ?> : </label>
				<select id="chooseElement" name="chooseElement" class="">
					<option value="-1"><?php echo Yii::t("common", "Choose"); ?></option>
					<option value="<?php echo Organization::COLLECTION; ?>"><?php echo Yii::t("common", "Organization"); ?></option>
					<option value="<?php echo Project::COLLECTION; ?>"><?php echo Yii::t("common", "Project"); ?></option>
					<option value="<?php echo Event::COLLECTION; ?>"><?php echo Yii::t("common", "Event"); ?></option>
					<option value="<?php echo Person::COLLECTION; ?>"><?php echo Yii::t("common", "Person"); ?></option>
					<option value="<?php echo Poi::COLLECTION; ?>"><?php echo Yii::t("common", "Poi"); ?></option>
				</select>
			</div>
			<div class="col-sm-4 col-xs-12">
				<label for="selectTypeSource"><?php echo Yii::t("common", "Source"); ?> : </label>
				<select id="selectTypeSource" name="selectTypeSource" class="">
					<option value="-1"><?php echo Yii::t("common", "Choose"); ?></option>
					<option value="url"><?php echo Yii::t("common", "URL"); ?></option>
					<option value="file"><?php echo Yii::t("common", "File"); ?></option>
				</select>
			</div>
			<div id="divMapping" class="col-sm-4 col-xs-12">
				<label for="selectTypeSource"><?php echo Yii::t("common", "Link"); ?> : </label>
				<select id="chooseMapping" name="chooseMapping" class="">
					<option value="-1"><?php echo Yii::t("common", "Not link"); ?></option>
				<?php
					if(!empty($allMappings)){
						foreach ($allMappings as $key => $value){
							if($userId == $value["userId"] || $value["userId"] == "0"){
								echo '<option value="'.$key .'">'.$value["name"].'</option>';
							}
						}
					}
				?>
				</select>
			
			</div>
			
			<div id="divFile" class="col-sm-8 col-xs-12">
				<div class="col-sm-2 col-xs-12">
					<label for="fileImport"><?php echo Yii::t("common", "File (CSV, JSON)"); ?> : </label>
				</div>
				<div class="col-sm-4 col-xs-12" id="divInputFile">
					<input type="file" id="fileImport" name="fileImport" accept=".csv,.json,.js,.geojson">
				</div>
			</div>
			<div id="divUrl" class="col-sm-6 col-xs-12">
				<label for="textUrl"><?php echo Yii::t("common", "URL (JSON)"); ?> :</label>
				<input type="text" id="textUrl" name="textUrl" value="">
			</div>
			<div id="divPathElement" class="col-sm-4 col-xs-12">
				<label for="pathElement"><?php echo Yii::t("common", "Path Elements"); ?> :</label>
				<input type="text" id="pathElement" name="pathElement" value="">
			</div>
			<div id="divCsv" class="col-sm-12 col-xs-12">
				<div class="col-sm-4 col-xs-12">
					<label for="selectSeparateur"><?php echo Yii::t("common", "Séparateur"); ?> : </label>
					<select id="selectSeparateur" name="selectSeparateur" class="">
						<option value=";"><?php echo Yii::t("common", "Semicolon"); ?></option>
						<option value=","><?php echo Yii::t("common", "Comma"); ?></option>
						<option value=" "><?php echo Yii::t("common", "Space"); ?></option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-12">
					<label for="selectSeparateurText"><?php echo Yii::t("common", "Separateur de Text"); ?> : </label>
					<select id="selectSeparateurText" name="selectSeparateur" class="">
						<option value=""><?php echo Yii::t("common", "Nothing"); ?></option>
						<option value='"'><?php echo Yii::t("common", "Quotation marks"); ?></option>
						<option value="'"><?php echo Yii::t("common", "Quotes"); ?></option>
					</select>
				</div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<a href="javascript:;" id="btnNextStep" class="btn btn-success margin-top-15"><?php echo Yii::t("common", "Next step"); ?></a>
			</div>
		</div>

		<!-- MAPPING STEP2 -->

<!-- Modal AJOUT MAPPING -->
<div id="modal-ajout-element" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-dark"><?php echo Yii::t("import","add my mapping."); ?></h4>
      </div>
      <div class="modal-body text-dark">
        <p><h2></h2>
			<i><?php echo Yii::t("import","Add the mapping, this allow you to reuse"); ?> </i>
        </p>
			<strong><?php echo Yii::t("import","Grab the name your mapping"); ?> : </strong>
			<input type="text" id="nameMapping" name="nameMapping">
      </div>
      <div class="modal-footer">
				<!-- Utilisation du bouton confirmDeleteElement -->
       <a href="javascript:;" id="btnconfirmInsertMapping" type="button" class="btn btn-success margin-top-15"><?php echo Yii::t("import","Add my mapping"); ?></a>
        <button type="button" class="btn btn-danger margin-top-15" data-dismiss="modal"><?php echo Yii::t('common','No');?></button>
      </div>
    </div>

  </div>
</div>

<!-- Modal UPDATE MAPPING -->
<div id="modal-update-element" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-dark"><?php echo Yii::t("import", "update my mapping"); ?></h4>
      </div>
      <div class="modal-body text-dark">
        <p>
		<h2></h2><!--Résous un problème de maj-->
			<i><?php echo Yii::t("import", "Do you want to change name of your mapping ?"); ?></i>
        </p>
			<strong><?php echo Yii::t("import", "Name your mapping : "); ?> </strong><div id="divSaisirNameUpdate"></div>
      </div>
      <div class="modal-footer">
				<!-- Utilisation du bouton confirmDeleteElement -->
       <a href="javascript:;" id="btnconfirmUpdateMapping" type="button" class="btn btn-success margin-top-15"><?php echo Yii::t("import", "Update my mapping"); ?></a>
        <button type="button" class="btn btn-danger margin-top-15" data-dismiss="modal"><?php echo Yii::t('common','No');?></button>
      </div>
    </div>

  </div>
</div>

<!-- Modal SUPPRIME MAPPING -->
<div id="modal-delete-element" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title-delete text-dark" ><?php echo Yii::t("import", "delete my mapping"); ?></h4>
      </div>
      <div class="modal-body text-dark">
        <p>
		<center><h4 class="modal-title-delete"><?php echo Yii::t("import","Are you sure of delete your mapping ?"); ?></h4> </center>
			<i><?php echo Yii::t("import","You will not be able to use this mapping"); ?></i>
        </p>
      </div>
      <div class="modal-footer">
				<!-- Utilisation du bouton confirmDeleteElement -->
       <a href="javascript:;" id="btnconfirmDeleteMapping" type="button" class="btn btn-warning"><?php echo Yii::t("import","Yes, I confirm the delete my mapping"); ?></a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo Yii::t('common','No');?></button>
      </div>
    </div>

  </div>
</div>

<!-- VIEW MAPPING -->

		<div class="col-md-12 mapping-step-tsr section-tsr" id="menu-step-mapping">
			<input type="hidden" id="nbLigneMapping" value="0"/>
			<div class="col-md-12 nbFile text-dark" >
				<?php echo Yii::t("import","There is "); ?><span id="nbFileMapping" class="text-red"> <span> 
			</div>
			<div id="divInputHidden"></div>
			<table id="tabcreatemapping" class="table table-striped table-bordered table-hover">
	    		<thead>
		    		<tr>
		    			<th class="col-sm-5"><?php echo Yii::t("common", "Source"); ?></th>
		    			<th class="col-sm-5"><?php echo Yii::t("common", "Communecter"); ?> <a href="https://hackmd.co.tools/KwUwTAbADMDMDGBaA7BCBDRAWAZuqi6EYAnIgCblgBGAjBABzIMli1A"  target="_blank" title="<?php echo Yii::t("import", "Data sheet referenced"); ?>" class="homestead text-red"><i class="fa fa-info-circle"></i></a></th>
		    			<th class="col-sm-2"><?php echo Yii::t("common", "Add")." / ".Yii::t("common", "Remove"); ?></th>
		    		</tr>
	    		</thead>
		    	<tbody class="directoryLines" id="bodyCreateMapping">
			    	<tr id="LineAddMapping">
		    			<td>
		    				<!--<input type="text" placeholder="Saisir une source mapping" list="listSource" class="col-sm-12">
		    					<datalist id="selectSource"></datalist>-->
							<select id="selectSource" class="col-sm-12">
							</select>
					
		    			</td>
		    			<td>
		    				<select id="selectAttributesElt" class="col-sm-12"></select>
		    			</td>
		    			<td>
		    				<input type="submit" id="addMapping" class="btn btn-primary col-sm-12" value="<?php echo Yii::t("import","Add"); ?>"/>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="col-sm-12 col-xs-12">
				<div class="col-sm-6 col-xs-12">
				<!--<i>(*) Champ obligatoire</i><br>-->
				<i><?php echo Yii::t("import","Fields mandatory"); ?> (*)</i><br />
					<label for="inputKey"><?php echo Yii::t("import","Key : "); ?></label>
					<input class="" placeholder="<?php echo Yii::t("import","Key assigned to all data import"); ?>" id="inputKey" name="inputKey" value="">
				</div>
				<!--<div class="col-sm-6 col-xs-12" id="divCheckboxWarnings">
					<label>
						Warnings : <input type="checkbox" value="" id="checkboxWarnings" name="checkboxWarnings">
					</label>
				</div>-->
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="col-sm-6 col-xs-12">
					<label>

					Test : <!--<input class="hide" id="isTest" name="isTest" ></input>
					<input id="checkboxTest" name="checkboxTest" type="checkbox" data-on-text="<?php echo Yii::t("common","Yes") ?>" data-off-text="<?php echo Yii::t("common","No") ?>" name="my-checkbox"  onclick="isCheckTest()"  checked></input>-->
							<input type="hidden" id="isTest" name="isTest"/>
			<input id="checkboxTest" name="checkboxTest" type="checkbox" data-on-text="<?php echo Yii::t("common","Yes") ?>" data-off-text="<?php echo Yii::t("common","No") ?>" checked/></input></label>
				</div>
				<div class="col-sm-6 col-xs-12" id="divNbTest">
					<div id="divNbTestAff"><label for="inputNbTest"><?php echo Yii::t("import","Number of entites to test (max 900) : "); ?> </label>
					<input class="" placeholder="" id="inputNbTest" name="inputNbTest" value="5"></div>
					<center>
					<div id="divAjout">
						<a id="btnAjoutMapping" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#modal-ajout-element"><?php echo Yii::t("import", "Add my mapping") ?></a>
					</div>
					<div id="divUpdate">
						<a id="btnUpdateMapping" class="btn btn-warning" data-toggle="modal" data-target="#modal-update-element"><strong><?php echo Yii::t("import", "Update my mapping"); ?></strong></a>
						<a id="btnDeleteMapping" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-element"><strong><?php echo Yii::t("import", "Delete my mapping"); ?></strong></a>
					</div>
					</center>
				</div>
			</div>
			<div class="col-sm-2 col-xs-12"  id="divInvite">
				<div class="col-sm-12 col-xs-12" id="divAuthor">
					<label for="nameInvitor"><?php echo Yii::t("import", "Author Invite: "); ?></label>
					<input class="" placeholder="" id="nameInvitor" name="nameInvitor" value="">
				</div>
				<div class="col-sm-12 col-xs-12" id="divMessage">
					<textarea id="msgInvite" class="" rows="3"><?php echo Yii::t("import", "Message Invite"); ?></textarea>
				</div>
			</div>
			<div class="col-sm-12 col-xs-12">
				<a href="javascript:;" id="btnPreviousStep" class="btn btn-danger margin-top-15"><?php echo Yii::t("common", "Previous step"); ?></a>
				<a href="javascript:;" id="btnNextStep2" class="btn btn-success margin-top-15"><?php echo Yii::t("common", "Next step"); ?></a>
			</div>
		</div>

		<!-- VISUALISATION STEP3 -->
		<div class="col-md-12 mapping-step-tsr section-tsr" id="menu-step-visualisation">
			<div class="panel-scroll row-fluid height-300">
				<label class="nbFile text-dark"><?php echo Yii::t("import", "List of elements :"); ?></label>
				<table id="representation" class="table table-striped table-hover"></table>
			</div>
			<br/>
			<div class="panel-scroll row-fluid height-300">
				<label class="nbFile text-dark"><?php echo Yii::t("import","List of cities has add :"); ?></label>
				<table id="saveCitiesTab" class="table table-striped table-hover"></table>
				<input type="hidden" id="jsonCities" value="">
			</div>
			<br/>	
			<div class="col-xs-12 col-sm-6">
				<label class="nbFile text-dark">
					<?php echo Yii::t("import","Imported data : "); ?><span id="nbFileImport" class="text-red"> <span> 
				</label>
				<div class="panel panel-default">
					<div class="panel-body">
							<input type="hidden" id="jsonImport" value="">
						    <div class="col-sm-12" style="max-height : 300px ;overflow-y: auto" id="divJsonImportView"></div>
					</div>
				</div>
				<div class="col-sm-12 center">
			    	<!-- <a href="javascript:;" class="btn btn-primary col-sm-2 col-md-offset-2" type="submit" id="btnImport">Save</a> -->
			    </div>

			</div>
			<div class="col-xs-12 col-xs-12 col-sm-6">
				<label class="nbFile text-dark">
					<?php echo Yii::t("import", "Data rejected : "); ?><span id="nbFileError" class="text-red"> <span> 
				</label>
				<div class="panel panel-default">
					<div class="panel-body">
						<input type="hidden" id="jsonError" value="">
						   <div class="col-sm-12" id="divJsonErrorView" style="max-height : 300px ;overflow-y: auto"></div>
						
					</div>
				</div>
				<div class="col-sm-12 col-xs-12 center">
			    <!--	<a href="javascript:;" class="btn btn-primary col-sm-2" type="submit" id="btnError">Save</a> -->
			    </div>
			</div>
			<div class="col-xs-12 col-sm-12 margin-top-15">
				<button class="btn btn-danger col-sm-2 col-md-offset-4 " onclick="returnStep2()"><?php echo Yii::t("import", "Return"); ?> 
					<i class="fa fa-reply"></i>

				</button>
				<a href="javascript:;" class="btn btn-success col-sm-3 col-md-offset-2 lbh" onclick="location.hash='#admin.view.adddata';loadAdddata();" type="submit" id="btnBDD"><?php echo Yii::t("import", "Page add of datas"); ?></a>
				<a href="javascript:;" class="btn btn-primary col-sm-3 col-md-offset-2" type="submit" id="btnImport"><?php echo Yii::t("import","Save"); ?></a>
				<a href="javascript:;" class="btn btn-primary col-sm-3 col-md-offset-2" type="submit" id="btnError"><?php echo Yii::t("import","Save"); ?></a>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
var file = [] ;
var csvFile = "" ;
var extensions = ["csv", "json", "js", "geojson"];
var nameFile = "";
var typeFile = "";
var typeElement = "";
var nbFinal = 0 ;
var listSource = [];
var ligneList = [];
var mappingPrevious = $("#chooseMapping").html();
var ifMappingDelete = false;
// var listeObligatoire = ["name","email","type","address.postalCode","address.addressLocality","address.codeInsee","address.streetAddress","address.addressCountry"];
var listeObligatoire = {
	name : "name",
	type : "type",
	postalCode : "postalCode",
	addressLocality : "addressLocality",
	streetAddress : "streetAddress",
	addressCountry : "addressCountry"
}


jQuery(document).ready(function() {

	setTitle("CreateFile","circle");
	$("#divFile").hide();
	$("#divCsv").hide();
	$("#divUrl").hide();
	$("#divPathElement").hide();
	$("#menu-step-mapping").hide();
	$("#menu-step-visualisation").hide();
	$("#btnBDD").hide();
	$("#btnImport").hide();
	$("#btnError").hide();
	bindCreateFile();
	bindUpdate();
	
});



function bindCreateFile(){
	$("#selectTypeSource").change( function (){
		var typeSource = $("#selectTypeSource").val();
		//Cache les elements de l'url
		if(typeSource == "url"){
			$("#divUrl").show();
			$("#divPathElement").show();
			$("#divCsv").hide();
			$("#divFile").hide();
		}	
		//Cache du file
		else if(typeSource == "file"){
			$("#divUrl").hide();
			$("#divFile").show();
			$("#divPathElement").hide();
		}else{
		//CACHE TOUT
			$("#divUrl").hide();
			$("#divFile").hide();
			$("#divPathElement").hide();
		}	
	});

	$("#btnPreviousStep").off().on('click', function(e){
		returnStep1();
  	});

  	$("#btnconfirmInsertMapping").off().on('click', function(e){
  		var params = {
  			names : $("#nameMapping").val(),
  			idMapping : $("#chooseMapping").val(),
  			typeElement : $("#chooseElement").val()
  		}

  		if(params.names != "")
		{
			if(ifMappingDelete == true)
			{
				params.idMapping = "-1";
				ifMappingDelete = false;
			}
  			setMappings(params);
  		}
  		else
  			toastr.error("<?php echo Yii::t("import","You will need to enter the name for your mapping"); ?>");
  	});

  	$("#btnconfirmUpdateMapping").off().on('click',function(e)
  	{
  		  	var params = {
  			names : $("#nameMappingUpdate").val(),
  			idMapping : $("#chooseMapping").val(),
  			typeElement : $("#chooseElement").val()
  		}

  		if(params.names != "")
  			setMappings(params);
  		else
  			toastr.error("<?php echo Yii::t("import","You will need to enter the name for your mapping"); ?>");
  	})

/*
$("#checkboxTest").bootstrapSwitch({
	isCheckTest();
});*/
	$("#checkboxTest").bootstrapSwitch();
	$("#checkboxTest").on("switchChange.bootstrapSwitch", function (event, state) {
		mylog.log("isTest Check");
		$("#isTest").val(state);
		if(state == true){
			$("#divNbTestAff").removeClass("hide");
		}else{
			$("#divNbTestAff").addClass("hide");
		}
	});

//	BOUTON DELETE
	$("#btnconfirmDeleteMapping").off().on('click', function(e)
	{
		mylog.log("deleteMapping");
		var params ={
			idMapping : $("#chooseMapping").val() //Les liens 
		}

		$.ajax({
			type: 'POST',
			data: params,
			dataType: 'json',
			url: baseUrl+'/'+moduleId+'/adminpublic/deletemapping/',
			async: false,
			success: function(data){
				mylog.log("success");
				toastr.success("<?php echo Yii::t("import", "Your mapping has been delete"); ?>");
				$("#modal-delete-element").modal('toggle');
				$("#divUpdate").hide();
				$("#divAjout").show();
				ifMappingDelete = true;
				//idMapping = "-1";
			},
			error:function(data){
				mylog.log("error");
				toastr.error("<?php echo Yii::t("import","An error occurred"); ?>");
			}
		});
	});
//BOUTON NEXT/PREVIOUS
	$("#btnNextStep").off().on('click', function(e){
		mylog.log($("#selectTypeSource").val(), file.length);
  		if($("#chooseElement").val() == "-1"){
  			toastr.error("<?php echo Yii::t("import","You will need to select an element type"); ?>");
  			return false ;
  		}
  		else if($("#selectTypeSource").val() == "-1"){
  			toastr.error("<?php echo Yii::t("import", "You will need to select an source"); ?>");
  			return false ;
  		}else if($("#selectTypeSource").val() == "file"){
  			if(file.length == 0 && csvFile.length == 0){
	  			toastr.error("<?php echo Yii::t("import","You will need to select an file"); ?>");
	  			return false ;
	  		}
  		}
  		var typeSource = $("#selectTypeSource").val();
  		typeElement = $("#chooseElement").val();

		//Si on choisir de transmettre un lien
  		if(typeSource == "url"){
			nameFile = "JSON_URL";
  			typeFile = "json";			
			$.ajax({
				url: baseUrl+'/'+moduleId+'/adminpublic/getdatabyurl/',
				type: 'POST',
				dataType: 'json', 
				data:{ url : $("#textUrl").val() },
				async : false,
				success: function (obj){
					mylog.log('success' , obj);
					file.push(obj.data) ;
					stepTwo();
				},
				error: function (error) {
					mylog.log('error', error);
				}
			});
		}	
		//Si on choisi d'uplod un fichier
		else if(typeSource == "file"){
			stepTwo();
		}	
		
		return false;
  		
  	});


	$("#addMapping").off().on('click', function(){

  		var nbLigneMapping = parseInt($("#nbLigneMapping").val()) + 1;
  		var error = false ;
  		var msgError = "" ;

  		//var selectValueHeadCSV = $("#selectHeadCSV option:selected").text() ;
  		var selectSource = $("#selectSource option:selected").val() ;
  		//var selectSource = $("#selectSource").val() ;
  		var selectAttributesElt = $("#selectAttributesElt option:selected").val() ;



  		var inc = 1;
  		while(error == false && inc <= nbLigneMapping){
  			if($("#valueSource"+inc).text() == selectSource ){
  				error = true;
  				msgError += "<?php echo Yii::t("import","You have already added this elements in the CSV column"); ?>"
  			}

  			if($("#valueAttributeElt"+inc).text() == selectAttributesElt){
  				error = true;
  				msgError += "<?php echo Yii::t("import","You have already add this elements in the mapping column"); ?>"
  			}
  			inc++;
  		}

  		if(error == false){

  			var params = {
  			cdt : "insert",
  			valueSource : selectSource,
  			valueElt : selectAttributesElt
  			}

  			var attributeEltSplit = selectAttributesElt.split(".");
  			if(verifNameSelected(attributeEltSplit)){
  				var newOptionSelect = addNewMappingForSelecte(attributeEltSplit, false);
	  			var arrayOption = [];
	  			getOptionHTML(arrayOption, newOptionSelect, "");
	  			verifBeforeAddSelect(arrayOption);
	  			chaine = "" ;
	  			$.each(arrayOption, function(key, value){
	  				chaine = chaine + '<option name="optionAttributesElt" values="'+value+'">'+value+'</option>'
	  			});

	  			$("#selectAttributesElt").append(chaine);
  			}  			
	  		ligne = '<tr id="lineMapping'+nbLigneMapping+'" class="lineMapping"> ';
	  		ligne =	 ligne + '<td id="valueSource'+nbLigneMapping+'">' + selectSource + '</td>';
	  		ligne =	 ligne + '<td id="valueAttributeElt'+nbLigneMapping+'">' + selectAttributesElt + '</td>';
	  		ligne =	 ligne + '<td><input type="hidden" id="idHeadCSV'+nbLigneMapping+'" value="'+ selectSource +'"/><a href="javascript:;" class="deleteLineMapping btn btn-danger">X</a></td></tr>';
	  		$("#nbLigneMapping").val(nbLigneMapping);
	  		$("#LineAddMapping").before(ligne);

	  	//	listMapping(params);
	  		
	  	}
	  	else
	  	{
	  		toastr.error(msgError);
	  	}

	  	bindUpdate();
  		return false;
  	});

	$(".deleteLineMapping").off().on('click', function(){
  		$(this).parent().parent().remove();
  	});

  	$("#btnNextStep2").off().on('click', function(){
  		processingBlockUi();
		setTimeout(function(){ preStep2(); }, 2000);
  		return false;
  	});


	$("#btnImport").off().on('click', function(){
		$("#btnImport").show();
		verifImport(btnImport);	
		if(notEmpty($('#jsonCities').val())){
			var zip = new JSZip();
			zip.file(nameFile+"_StandardForCommunecter.json", $('#jsonImport').val());
			zip.file("SaveCities.json", $('#jsonCities').val());
			zip.generateAsync({type:"blob"})
				.then(function(content) {
				    // see FileSaver.js
				    saveAs(content, nameFile+"_Import.zip");
				});
		}else{
			saveAs($('#jsonImport').val(), nameFile+"_StandardForCommunecter.json");
		}
  		// $("<a />", {
		  //   "download": nameFile+"_StandardForCommunecter.json",
		  //   "href" : "data:application/json," + encodeURIComponent($('#jsonImport').val())
		  // }).appendTo("body")
		  // .click(function() {
		  //    $(this).remove()
		  // })[0].click() ;
  	});

  	$("#btnError").off().on('click', function(){
  		$("#btnError").hide();
  		$("<a />", {
		    "download": nameFile+"_NotStandardForCommunecter.json",
		    "href" : "data:application/json," + encodeURIComponent($('#jsonError').val())
		  }).appendTo("body")
		  .click(function() {
		     $(this).remove()
		  })[0].click() ;
  	});
}

function preStep2(){
	cleanVisualisation();
		var nbLigneMapping = $("#nbLigneMapping").val();
		var inputKey = $("#inputKey").val().trim();
		var infoCreateData = [] ;

		//Je sais pas à quoi sa cela correspond
		if(nbLigneMapping == 0){
			toastr.error("<?php echo Yii::t("import","You must make at least one data assignment"); ?>"); 
			$.unblockUI();
  			return false ;
		}else if(inputKey.length == 0){ //Il est n'a pas de clé
			toastr.error("<?php echo Yii::t("import","You will need to add the Key"); ?>");
			$.unblockUI();
  			return false ;
		}
		else{
			//Pour i allant de 0 à nbLigneMapping
			for (i = 0; i <= nbLigneMapping; i++){
				//si lineMapping.lenght+i
	  			if($('#lineMapping'+i).length){
					  // création d'un tableau vide
	  				var valuesCreateData = {};
					valuesCreateData['valueAttributeElt'] = $("#valueAttributeElt"+i).text(); //Récupère les informations du tableau Etape "Lien" côté communecter
					//mylog.log("valyesCreateData ",valuesCreateData['valueAttributeElt']); mon test pour savoir ce que sa fait
					//mylog.log(typeof $("#idHeadCSV"+i).val());
					valuesCreateData['idHeadCSV'] = $("#idHeadCSV"+i).val(); //Récupère les informations du tableau Etape "Lien" partie "Source"
					//mylog.log("valuesCreateData['idHeadCSV']",valuesCreateData['idHeadCSV']);
					infoCreateData.push(valuesCreateData);
	  			}	
	  		}
	  		if(infoCreateData != []){	
	  			
				  //Renseigne les informations importants.
	  			var params = {
	        		infoCreateData : infoCreateData, 
	        		typeElement : typeElement,
	        		nameFile : nameFile,
	        		typeFile : typeFile,
	        		pathObject : $('#pathObject').val(),
			        key : inputKey,
			        warnings : $("#checkboxWarnings").is(':checked')
			    }

				//Si le typeElement concerne les personnes
			    if(typeElement == "<?php echo Person::COLLECTION;?>"){
			    	params["msgInvite"] = $("#msgInvite").val();
					params["nameInvitor"] = $("#nameInvitor").val();
				}

				//Si on a coché la partie "test"
	  			if($("#checkboxTest").is(':checked')){
					//Si c'est un fichier de type "csv"
	  				if(typeFile == "csv"){
	  					//mylog.log("inputNbTest", $("#inputNbTest").val());
	  					var subFile = file.slice(0,parseInt($("#inputNbTest").val())+1);  // Je sais pas à quoi sert cette ligne.
	  					params["file"] = subFile;
	  				}
					// Si c'est un fichier de type JSON
			  		else if(typeFile == "json" || typeFile == "js" || typeFile == "geojson"){
			  			params["file"] = file;
			  			params["nbTest"] = $("#inputNbTest").val();
			  		}
	  				//mylog.log("params ",params);
		  			stepThree(params);
		  			showStep3();

	  			}else{
	  				//mylog.log("Here");
					  //Si c'est un fichier csv
	  				if(typeFile == "csv"){
	  					var fin = false ;
				  		var indexStart = 1 ;
				  		var limit = 30 ; //On ne charge pas le fichier d'un block, mais peu par peu
				  		var indexEnd = limit;
				  		var head = file.slice(0,1);


				  		while(fin == false){
				  			subFile = head.concat(file.slice(indexStart,indexEnd));
				  			mylog.log("subFile", subFile.length);
				  			params["file"] = subFile;

				  			stepThree(params);

							indexStart = indexEnd ;
				  			indexEnd = indexEnd + limit;
				  			if(indexStart > file.length)
				  				fin = true ;
				  		}
				  		showStep3();
	  				}
					//Si c'est un fichier JSON
			  		else if(typeFile == "json" || typeFile == "js" || typeFile== "geojson"){
			  			params["file"] = file;
				  		stepThree(params);
				  		showStep3();
			  		}
	  			}
	  		}
			  //S'il n'y a rien dans le lien
	  		else{
				$.unblockUI();
				toastr.error("<?php echo Yii::t("import","You will need to add the elements in the mapping"); ?>");
			}
		}
}

function stepTwo(){
	//Renvoi dans la console
	mylog.log("stepTwo", typeFile, typeElement);
	var params = {
		typeElement : typeElement, // Organisation, personne...
		typeFile : typeFile, //Si JSON or CSV
		idMapping : $("#chooseMapping").val(), //Les liens 
		path : $("#pathElement").val()
	};

	mylog.log("params", params);

	if(typeFile == "json" || typeFile == "js" || typeFile == "geojson")
		params["file"] = file ;
	else
		file = dataHelper.csvToArray(csvFile, $("#selectSeparateur").val(), $("#selectSeparateurText").val())

	$.ajax({
        type: 'POST',
        data: params,
        url: baseUrl+'/'+moduleId+'/adminpublic/assigndata/',
        dataType : 'json',
        async : false,
        success: function(data)
        {
        	mylog.log("stepTwo data",data);
        	if(data.result){
        		createStepTwo(data);
        	}
        	else{

        	}

        }
	});
}
function bindUpdate(data){
	//Supprime la ligne sur le tableau "Lien"
	$(".deleteLineMapping").off().on('click', function(){
  		$(this).parent().parent().remove();
  	});

//On prend en charge le fichier de l'utilisateurs
  	$("#fileImport").change(function(e) {
    	var fileSplit = $("#fileImport").val().split("."); 
		/*if(file.length == 0 && csvFile.length == 0){
	  		toastr.error("Vous devez sélectionner un fichier.");
	  		return false ;
		}*/
		//Si l'extension n'est pas un CSV n'y JSON fait apparait un msg dans les notifications
		if(extensions.indexOf(fileSplit[fileSplit.length-1]) == -1){
  			toastr.error("<?php echo Yii::t("import", "You will need to select a file CSV or JSON"); ?>");
  			return false ;
  		}
		
		//Affiche les fichiers qu'on compte upload sur le serveur
  		nameFileSplit = fileSplit[0].split('\\');
  		mylog.log("nameFileSplit", nameFileSplit);
  		nameFile = nameFileSplit[nameFileSplit.length-1];
		typeFile = fileSplit[fileSplit.length-1];

		//Si le format ne correspond pas
		if(extensions.indexOf(typeFile) == -1) {
			alert('Upload CSV or JSON');
			return false;
		}
		file = [];		//Tableau vide
		if (e.target.files != undefined) {
			var reader = new FileReader();
			reader.onload = function(e) {
				//SI CSV
				if(typeFile == "csv"){
					//var csvval=e.target.result.split("\n");
					csvFile = e.target.result;
					//mylog.log("csv : ", csvval );
					/*$.each(csvval, function(key, value){
						var ligne = value.split(";");
						var newLigne = [];
						$.each(ligne, function(keyLigne, valueLigne){
							//mylog.log("valueLigne", valueLigne);
							if(valueLigne.charAt(0) == '"' && valueLigne.charAt(valueLigne.length-1) == '"'){
								var elt = valueLigne.substr(1,valueLigne.length-2);
								newLigne.push(elt);
							}else{
								newLigne.push(valueLigne);
							}
						});
		  				file.push(newLigne);
		  			});*/
		  			$("#divCsv").show();
				}
				//Si JSON
				else if(typeFile == "json" || typeFile == "js" || typeFile == "geojson") {
					$("#divCsv").hide();
					$("#divPathElement").show();
					file.push(e.target.result);
	  			}
			};
			reader.readAsText(e.target.files.item(0));
		}
		return false;
	});
}

function createStepTwo(data){

//Gestion du select côté source
	var chaineSelectCSVHidden = "" ;
	if(data.typeFile == "csv"){ //Cas CSV
		$("#nbFileMapping").html(file.length - 1 + "<?php echo Yii::t("import"," element(s)"); ?>"); //Compte le nb d'élèment
		$.each(file[0], function(key, value){
			chaineSelectCSVHidden += '<option value="'+value+'">'+value+'</option>'; //Pour l'utilisateur puisse rajouté un élèment en cas s'il lui manque
			listSource[value] += value;
		});
	}else if(data.typeFile == "json" || data.typeFile == "geojson" || data.typeFile == "js"){ //Cas JSON
		$("#nbFileMapping").html(data.nbElement  + "<?php echo Yii::t("import"," element(s)"); ?>"); //Compte le nb d'élèment
		$.each(data.arbre, function(key, value){
			chaineSelectCSVHidden += '<option value="'+value+'">'+value+'</option>'; //Pour l'utilisateur puisse rajouté un élèment en cas s'il lui manque
			listSource[value] += value;
		});
	}

	$("#selectSource").html(chaineSelectCSVHidden); //Le select de la partie "Lien" côté Source

//On fait de même pour le select côté communecter
	chaineAttributesElt = "" ;
	$.each(data.attributesElt, function(key, value){
		var valueadd = value.replace("address.","");
		if(value == listeObligatoire[value] || valueadd == listeObligatoire[valueadd]){
			chaineAttributesElt += '<option name="optionAttributesElt" value="'+value+'">'+value+' (*) </option>';
		}
		else{
			chaineAttributesElt += '<option name="optionAttributesElt" value="'+value+'">'+value+'</option>';
		}
	});

	$("#selectAttributesElt").html(chaineAttributesElt); //Le select de la partie "Lien" côté Communecter

//Affiche information de data
	mylog.log("createStepTwo", data);

//Partie HTML a était mise en commentaire
	if(typeElement != "<?php echo Organization::COLLECTION;?>")
		$("#divCheckboxWarnings").hide();

	if(typeElement != "<?php echo Person::COLLECTION;?>")
		$("#divInvite").hide();
	
	//Si la chaîne renvoyé est différent de "undefined"
	if(typeof data.arrayMapping != "undefined"){
		var nbLigneMapping = $("#nbLigneMapping").val();
		var i = 0 ;
		$.each(data.arrayMapping, function(key, value){
			ligne = '<tr id="lineMapping'+nbLigneMapping+'" class="lineMapping"> ';
	  		ligne =	 ligne + '<td id="valueSource'+nbLigneMapping+'">' + key + '</td>';

			ligne =	 ligne + '<td id="valueAttributeElt'+nbLigneMapping+'">' + value + '</td>';
			ligne =	 ligne + '<td><input type="hidden" id="idHeadCSV'+nbLigneMapping+'" value="'+ key +'"/><a href="javascript:;" class="deleteLineMapping btn btn-danger">X</a></td></tr>';
	  		nbLigneMapping++;

	  		ligneList[key] += value;

	  		$("#LineAddMapping").before(ligne);
	  		i++;
		});
		$("#nbLigneMapping").val(nbLigneMapping);
	}


	if(data.idMapping == "-1" || data.idMapping == "5b0d1b379eaf44ea598b4580" || data.idMapping == "5b0d1b379eaf44ea598b4581" || data.idMapping == "5b0d1b379eaf44ea598b4582" || data.idMapping == "5b0d1b379eaf44ea598b4583" || data.idMapping == "5b1654d39eaf4427171cd718")
	{
		$("#divAjout").show();
		$("#divUpdate").hide();
	}
	else if(data.idMapping != "")
	{
		$("#divAjout").hide();
		$("#divUpdate").show();
	}
	else
	{
		$("#divAjout").hide();
		$("#divUpdate").hide();
	}

	nameUpdate = '<input type="text" name="nameMappingUpdate" id="nameMappingUpdate" value='+data.nameUpdate+'>';
	$("#divSaisirNameUpdate").html(nameUpdate);
	
	mylog.log("ligneList", ligneList);
	mylog.log("listSource",listSource);
	//mylog.log("listElt",listElt);

	bindUpdate();
	displayStepTwo();
}

function verifNameSelected(arrayName){
	var find = false ; 
	$.each(arrayName, function(key, value){
		var beInt = parseInt(value);
		if(!isNaN(beInt)){
			find = true ;
		}
	});
	return find ;
}

//Désactive les élèments de la partie 2
function displayStepTwo(){
	mylog.log("showStep2")
	$('#menu-step-2 i.fa').removeClass("fa-circle-o").addClass("fa-circle");
	$('#menu-step-1 i.fa').removeClass("fa-circle").addClass("fa-check-circle");
	$('#menu-step-1').removeClass("selected");
	$('#menu-step-2').addClass("selected");
	$("#menu-step-mapping").show(400);
	$("#menu-step-source").hide(400);
	$("#menu-step-visualisation").hide(400);
}

//Préparation de la partie 3
function showStep3(){
	mylog.log("showStep3");
	$('#menu-step-3 i.fa').removeClass("fa-circle-o").addClass("fa-circle");
	$('#menu-step-2 i.fa').removeClass("fa-circle").addClass("fa-check-circle");
	$('#menu-step-2').removeClass("selected");
	$('#menu-step-3').addClass("selected");
	$("#menu-step-mapping").hide(400);
	$("#menu-step-source").hide(400);
	$("#menu-step-visualisation").show(400);
	//alert("hello");
	$.unblockUI();
}

//Retourne dans l'étape 2 (l'interface)
function returnStep2(){
	mylog.log("returnStep2");
	$('#menu-step-3 i.fa').removeClass("fa-circle").addClass("fa-circle-o");
	$('#menu-step-2 i.fa').removeClass("fa-check-circle").addClass("fa-circle");
	$('#menu-step-3').removeClass("selected");
	$('#menu-step-2').addClass("selected");
	$("#menu-step-mapping").show(400);
	$("#menu-step-source").hide(400);
	$("#menu-step-visualisation").hide(400);
	nbFinal=0;
}

//Retourne dans l'étape 1 (l'interface & init des fichiers).
function returnStep1(){
	mylog.log("returnStep1");
	file = [] ;
	nameFile = "";
	typeFile = "";
	typeElement = "";
	nbFinal=0;
	$('#divInputFile').html('<input type="file" id="fileImport" name="fileImport" accept=".csv,.json,.js,.geojson">')
	$('#menu-step-1 i.fa').removeClass("fa-circle-o").addClass("fa-circle");
	$('#menu-step-2 i.fa').removeClass("fa-circle").addClass("fa-circle-o");
	$('#menu-step-2').removeClass("selected");
	$('#menu-step-1').addClass("selected");
	$("#menu-step-mapping").hide(400);
	$("#menu-step-source").show(400);
	$("#menu-step-visualisation").hide(400);
	$(".lineMapping").remove();
	bindUpdate();
}


function addNewMappingForSelecte(arrayMap, subArray){
	var firstElt = arrayMap[0] ;
	arrayMap.shift(); //Supprime le premier élèment du tableau.
	var beInt = parseInt(firstElt);
	var newSelect = {} ;

	if(!isNaN(beInt)){
		beInt++;
		if(subArray){	
			if(arrayMap.length >= 1){
				var newArrayMap = jQuery.extend([], arrayMap);
				newSelect[firstElt] = addNewMappingForSelecte(arrayMap, subArray);
				newSelect[beInt.toString()] = addNewMappingForSelecte(newArrayMap, subArray);
			}
			else{
				newSelect[firstElt] = "";
				newSelect[beInt.toString()] = "";
			}
		}
		else{
			if(arrayMap.length >= 1){
				subArray = true ;
				newSelect[beInt.toString()] = addNewMappingForSelecte(arrayMap, subArray);
			}
			else{
				newSelect[beInt.toString()] = "";
			}
		}
	}
	else{
		if(arrayMap.length >=1){
			newSelect[firstElt] = addNewMappingForSelecte(arrayMap, true);
		}
		else{
			newSelect[firstElt] = "";
		}
	}
	return newSelect ;
}

function getOptionHTML(arrayOption, objectOption, father)
{
	if(!jQuery.isPlainObject(objectOption)){
		arrayOption.push(father);
	}
	else{
		$.each(objectOption, function(key, values){
			if(father != "")
				var newfather = father +"."+ key
			else
				var newfather = key
			getOptionHTML(arrayOption, values, newfather);
		});
	}
}

function verifBeforeAddSelect(arrayMap)
{
	$('[name=optionAttributesElt]').each(function() {
	  	var option = $(this).val() ;
	  	var position = jQuery.inArray( option, arrayMap);
	  	if(position != -1)
	  		arrayMap.splice(position, 1);
		//mylog.log("option", option);
	});
}
//Reset les informations contenant dans l'étape 3
function cleanVisualisation(){
	$("#representation").html("");
	$("#jsonImport").val("");
    $("#jsonError").val("");
    $("#jsonCities").val("");
}

function createInpu(nameFile, typeFile, typeElement){
	var chaineInputHidden = '<input type="hidden" id="typeElement" value="' + typeElement + '"/>';
	chaineInputHidden += '<input type="hidden" id="nameFile" value="'+nameFile+'"/>';
	chaineInputHidden += '<input type="hidden" id="typeFile" value="'+typeFile+'"/>';
	$("#divInputHidden").html(chaineInputHidden);
}

//Troisième étape
function stepThree(params){
	$.ajax({
        type: 'POST',
        data: params,
        url: baseUrl+'/'+moduleId+'/adminpublic/previewData/',
        dataType : 'json',
        async : false,
        success: function(data)
        {
			//Affiche dans le console
        	mylog.log("stepThree data",data);
        	if(data.result){
        		
        		var importD = "" ;
        		var errorD = "" ;
        		var saveCities = "" ;

				if($("#jsonImport").val() == "") //Si le tableau d'import est vide
					importD = data.elements; //Import les données elements
				else{
					if(data.elements == "[]") //S'il n'y a pu rien a importé
						importD = $("#jsonImport").val(); //Import dans le tableau affichage "Donnée importés"
					else{
						var elt1 = jQuery.parseJSON($("#jsonImport").val()); //Transforme un String en Objet
						var elt2 = jQuery.parseJSON(data.elements); //Transforme un String en Objet
						$.each(elt2, function(key, val){ //Boucle
							elt1.push(val); //Ajout dans l'element 1 les informations que continent elt2
						});
						importD = JSON.stringify(elt1); //Convertis un Objet en String
					}

				}
        		
        		if($("#jsonError").val() == "") //Si le tableau d'erreur est vide
        			errorD = data.elementsWarnings; //Récupère les donnees d'élèments Warnings.
        		else{
        			if(data.elementsWarnings == "[]") //S'il n'y a pu rien à importé
        				errorD = $("#jsonError").val(); //Import dans le tableau affichage "Donnée rejetées"
        			else{
        				var elt1E = jQuery.parseJSON($("#jsonError").val()); //Transforme un String en Objet
        				var elt2E = jQuery.parseJSON(data.elementsWarnings); //Transforme un String en Objet
        				$.each(elt2E, function(key, val){
		        			elt1E.push(val); //Ajout dans un élèment 1 E les informations que contient elt2E
		        		});
        				errorD = JSON.stringify(elt1E); //Convertis un objet en string
        			}
        		}

				//Même étape pour les villes (voir les commentaires en haut)
        		if($("#jsonCities").val() == "")
					saveCities = data.saveCities;
				else{
					if(data.elements == "[]")
						saveCities = $("#jsonCities").val();
					else{
						var elt1 = jQuery.parseJSON($("#jsonCities").val());
						var elt2 = jQuery.parseJSON(data.saveCities);
						$.each(elt2, function(key, val){
							elt1.push(val);
						});
						saveCities = JSON.stringify(elt1);
					}

				}

				
				mylog.log("importD",typeof importD); //Affiche un string		
				mylog.log("errorD",typeof errorD); //Affiche un string

				$("#jsonImport").val(importD);
				$("#jsonCities").val(saveCities);
				$("#jsonError").val(errorD);
				$("#divJsonImportView").JSONView(importD); //Affiche le contenu de importD
				$("#divJsonErrorView").JSONView(errorD); //Affiche le contenu de errorD

				//Affichage au niveau de "Liste d'élèment"
				var chaine = "" ;
				$.each(data.listEntite, function(keyListEntite, valueListEntite){
					nbFinal++;
					chaine += "<tr>" ;
					if(keyListEntite == 0)
					{
						chaine += "<th>N°</th>";
						$.each(valueListEntite, function(key, value){
							chaine += "<th>"+value+"</th>";
						});
					}else{
						chaine += "<td>"+keyListEntite+"</td>";
						$.each(valueListEntite, function(key, value){
							chaine += "<td>"+value+"</td>";
						});
					}
					chaine += "</tr>" ;
				});
				$("#representation").append(chaine); //Affiche les infos


				$("#nbFileImport").html(jQuery.parseJSON(importD).length); //Convertis un String en Objet (chiffre)
				$("#nbFileError").html(jQuery.parseJSON(errorD).length); //Convertis un String en Objet (chiffre)
				
				if(data.elements != "[]" && data.elementsWarnings == "[]")
				{
					$("#btnImport").show();
				}
				else if (data.elementsWarnings != "[]")
				{
					$("#btnError").show();
				}

				//$("#verifBeforeImport").show();
			}
		}
    });
}

function setMappings(params)
{
		var nbLigneMappings = $("#nbLigneMapping").val();
		var mappingCommunecter = [];
		var mappingSource = [];
		//Parcours les liens que l'user a mise et on les stock dans un tableau
		for(j = 0; j <= nbLigneMappings; j++){
			if($('#lineMapping'+j).length){
				//Mapping côté communecter
				var mappingCommunecterInsert = {};
				mappingCommunecterInsert = $("#valueAttributeElt"+j).text();
				mappingCommunecter.push(mappingCommunecterInsert);
				//Mapping côté source
				var mappingSourceInsert = {};
				mappingSourceInsert = $("#valueSource"+j).text();
				mappingSource.push(mappingSourceInsert);
			}
		}

		var param = {
			name : params.names,
			attributeSource : mappingSource,
			attributeElt: mappingCommunecter,
			idMapping : params.idMapping,
			typeElement : params.typeElement
		}

		mylog.log("setMapping", param);
		if(param.attributeElt != "" && param.attributeSource != "")
		{
			if(param.idMapping == "-1" ||  param.idMapping  == "5b0d1b379eaf44ea598b4580" || param.idMapping == "5b0d1b379eaf44ea598b4581" || param.idMapping ==  "5b0d1b379eaf44ea598b4582" || param.idMapping ==  "5b0d1b379eaf44ea598b4583"|| param.idMapping == "5b1654d39eaf4427171cd718")
			{
					$.ajax({
					type: 'POST',
					data: param,
					dataType : 'json',
					url: baseUrl+'/'+moduleId+'/adminpublic/setmapping/',
					async: false,
					success: function(data){
						mylog.log("sucess", data);
						toastr.success("<?php echo Yii::t("import","Your mapping have been added"); ?>");
						$("#modal-ajout-element").modal('toggle');
						$("#divAjout").hide();
						mappingPrevious += '<option value="'+data._id+'">'+data.name+'</option>';
						mylog.log("mappingPrevious", mappingPrevious);
					},
					error: function(data)
					{
						mylog.log("errors",data);
					}
				});	
			}
			else
			{
					$.ajax({
					type: 'POST',
					data: param,
					dataType : 'json',
					url: baseUrl+'/'+moduleId+'/adminpublic/setmapping/',
					async: false,
					success: function(data){
						mylog.log("sucess", data);
						toastr.success("<?php echo Yii::t("import","Your mapping have been updated"); ?>");
						$("#modal-update-element").modal('toggle');
						//mylog.log("chooseMapping", mappingPrevious.substring(0,64));
						//Aucune idée comment je peux faire pour l'update, je verrai demain pour Raphaël.
					},
					error: function(data)
					{
						mylog.log("errors",data);
					}
				});	
			}
			mylog.log(mappingPrevious);
			$("#chooseMapping").html(mappingPrevious);	
		}
		else 
		{	
			toastr.error("<?php echo Yii::t("import","You will need to complete at least one field"); ?>");
		}

}
/*
function listMapping(params)
{
	mylog.log("listMapping",params);
	var chaineAttributesElt = "";
	var chaineAttributesSource = "";

	if(params.cdt == "insert"){
		$.each(ligneList, function(key, value){
			if(ligneList[params.valueSource] == listSource[key])
				listSource[key] -=  ligneList[params.valueSource];

			chaineAttributesSource +='<option value="'+key+'">'+key+'</option>';
			chaineAttributesElt +='<option name="optionAttributesElt" value="'+value+'">'+value+'</option>';
		});
	}/*
	else if(params.cdt == "delete"){
		$.each(ligneList, function(key,value){
			if(ligneList[params.valueSource] == listSource[key])
			ligneList += listSource[params.valueSource] 
		});

		chaineAttributesSource += '<option value="'+key+'">'+key+'</option>';
		chaineAttributesElt += '<option value="'+value+'">'+value+'</option>';
	}

	$("#selectAttributesElt").html(chaineAttributesElt);
	$("#selectSource").html(chaineAttributesSource);
	mylog.log("ligneList",ligneList);
	mylog.log("listSource",listSource);
}
*/
function verifImport(btnImport)
{
	if($("#btnImport").hide())
		$("#btnBDD").show();
	else
		$("#btnBDD").hide();
}
function isCheckTest()
{
	if($("#checkboxTest").is(':checked'))
		{
		mylog.log("Test is check");
		$("#divNbTestAff").show();
		}
	else
		$("#divNbTestAff").hide();
}
</script>