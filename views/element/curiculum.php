
<?php if(empty($curiculum)){ ?>
<h5>Vous n'avez pas encore rempli votre CV</h5>
Détaillez votre parcours personnel et professionnel pour faciliter votre recherche d'emploi.
<hr><br><br>

<?php } ?>

<h4>
	Informations générales
	<button class="btn btn-primary" id="btn-update-cv-skills">
		<i class="fa fa-pencil"></i> Modifier
	</button>
</h4>
<hr>

<?php $values = array("bac"=>"Niveau bac",
					  "mainQualification"=>"Diplôme principal",
					  "competences" => "Compétences",
					  "computerSkills" => "Maîtrise des outils informatiques",
					  "driverLicense" => "Permis de conduire",
					  "vehicle" => "Véhicule",
					  "languages" => "Langues",
					  "motivation" => "Motivation",
					  "url" => "url"
					); ?>

<?php foreach ($values as $key => $lbl) { ?>
	<div class="col-xs-12 col-sm-6 col-md-6">
		<h5 class="label text-azure"><?php echo $lbl; ?></h5>
		<div class="label text-dark">
			<?php echo isset($curiculum["skills"][$key]) ? $curiculum["skills"][$key] : "Non renseigné"; ?>
		</div>
	</div>
<?php } //var_dump($curiculum); ?>

<div class="col-xs-12 margin-top-50">
	<hr>
	<h4>
		Parcours personnel et professionnel
		<button class="btn btn-primary" id="btn-add-lifepath">
			<i class="fa fa-plus-circle"></i> Ajouter
		</button>
	</h4>
	<br>
<?php if(@$curiculum["lifepath"]){ ?>
	<?php foreach ($curiculum["lifepath"] as $keyPath => $experiences) { ?>
		<div class="panel panel-white padding-15">
			<h5 class="">
				Expérience n°<?php echo $keyPath+1; ?>
				<button class="btn btn-sm pull-right margin-left-10">
					<i class="fa fa-trash"></i>
				</button> 
				<button class="btn btn-sm pull-right">
					<i class="fa fa-pencil"></i>
				</button> 
			</h5>
			<hr>
			<?php foreach ($experiences as $key => $lbl) { ?>
				<?php //if(@$curiculum["lifepath"][$keyPath][$key]){ ?>
					<h5 class="label text-azure"><?php echo $key; ?></h5>
				<?php //} ?>
				<p class="text-dark">
					<?php echo isset($curiculum["lifepath"][$keyPath][$key]) ? 
							   $curiculum["lifepath"][$keyPath][$key] : "Non renseigné"; ?>
				</p>
				<br>
			<?php } //var_dump($curiculum); ?>
		</div>
	<?php } //var_dump($curiculum); ?>
<?php } ?>

</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		/*var dataUpdate = {
			block: "curiculum",
	        id : contextData.id,
	        typeElement : contextData.type,
	        name : contextData.name,
		};
		if(notNull(contextData.curiculum) && contextData.curiculum.length > 0)
			if(notNull(contextData.curiculum.skills) && contextData.curiculum.skills.length > 0)
				dataUpdate.curiculum.skills = contextData.curiculum.skills;
*/
		$("#btn-update-cv-skills").click(function(){
			//dyFObj.openForm("curiculum", dataUpdate);
			updateCVSkills();
		});
		$("#btn-add-lifepath").click(function(){
			//dyFObj.openForm("curiculum", dataUpdate);
			addLifePath();
		});
	});

	function updateCVSkills() {
		var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				timer : false,
				dynForm : {
					jsonSchema : {
						title : trad.addCuriculum,// trad["Update network"],
						icon : "fa-key",
						onLoads : {
							sub : function(data){
								$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url").addClass("bg-dark");
								console.log("DATA XXX", data);
								if(typeof data.driverLicense != "undefined"){ 
									if(data.driverLicense == "false"){
										$("#ajaxFormModal #driverLicense").val("false");
										$("#ajaxFormModal .driverLicensecheckboxSimple .btn-dyn-checkbox[data-checkval='false']").trigger( "click" );
									}
								}
								if(typeof data.hasVehicle != "undefined"){ 
									if(data.hasVehicle == "false"){
										$("#ajaxFormModal #hasVehicle").val("false");
										$("#ajaxFormModal .hasVehiclecheckboxSimple .btn-dyn-checkbox[data-checkval='false']").trigger( "click" );
									}
								}
								//bindDesc("#ajaxFormModal");
							}
						},
						beforeSave : function(){
							mylog.log("beforeSave");
					    	//removeFieldUpdateDynForm(contextData.type);
					    },
						afterSave : function(data){
							dyFObj.closeForm();
							toastr.success("Enregistrement des données de votre CV");
							strHash="";
    						if(location.hash.indexOf(".view")>0){
    							hashPage=location.hash.split(".view");
    							strHash=".view"+hashPage[1];
    						}	
    						//location.hash = data.resultGoods.values.slug+strHash;
    						///hashUrlPage="#"+data.resultGoods.values.slug;
    						if(typeof data.resultGoods.values.curiculum.skills != "undefined")
	    						$.each(data.resultGoods.values.curiculum.skills, function(key,value){
	    							console.log("afterSave --*", key, value);
									contextData.curiculum.skills[key]=value;
		    					});
							//rcObj.loadChat(data.resultGoods.values.slug,type,canEdit,hasRc);
							//loadDataDirectory(connectType, "user", true);
							//changeHiddenFields();
						},
						properties : {
					    	info : {
				                inputType : "custom",
				                html:"<p class='text-"+typeObj["organization"].color+"'>"+
				                		//"Faire connaître votre Organisation n'a jamais été aussi simple !<br>" +
									    //tradDynForm["infocreateorganization"]+" ...<hr>" +
									 "</p>",
				            },
					        block : dyFInputs.inputHidden(),
							typeElement : dyFInputs.inputHidden(), 

							mainQualification : dyFInputs.inputText("Votre diplôme principal"),

							competences : dyFInputs.tags(new Array("test"), "",
														"Vos compétences principales"),

							languages : dyFInputs.tags(new Array("Français", "Anglais", "Espagnol", "Allemand", "Italien", "Russe", "Chinois", "Japonais"), "",
														"Langues maîtrisées"),

							driverLicense : dyFInputs.checkboxSimple("true", "driverLicense", 
            										{ "onText" : trad.yes,
            										  "offText": trad.no,
            										  "onLabel" : "Oui, j'ai le permis",
            										  "offLabel" : "Non, je n'ai pas le permis",
            										  "labelText": "Permis de conduire ?"
            										}),
            				hasVehicle : dyFInputs.checkboxSimple("true", "hasVehicle", 
            										{ "onText" : trad.yes,
            										  "offText": trad.no,
            										  "offLabel" : "Non, je n'ai pas de véhicule pour me déplacer",
            										  "onLabel" : "Oui, j'ai un véhicule pour me déplacer",
            										  "labelText": "Véhicule ?"
            										}),	

				            motivation : dyFInputs.textarea(tradDynForm["explainMotivation"], 
				            								"...", { maxlength: 500 }),
					        url : dyFInputs.inputUrl("Lien vers votre site web personnel ou professionnel")
					    }
					}
				}
			};
		var dataUpdate = {
			block : "curiculum.skills",
	        id : contextData.id,
	        typeElement : contextData.type
		};

		if(typeof contextData.curiculum != "undefined"){
			if(typeof contextData.curiculum.skills != "undefined"){
				var CVattrs = ["competences", "url", "mainQualification", "languages", "driverLicense", "hasVehicle", "motivation"];
				$.each(CVattrs, function(key, value){ 
					console.log("in detail", value, contextData.curiculum,  contextData.curiculum.skills[value])
					if(typeof contextData.curiculum.skills[value] != "undefined"){
						dataUpdate[value] = contextData.curiculum.skills[value];
					}
				});
			}
		}
		console.log("openFormCV", dataUpdate);
		dyFObj.openForm(form, "sub", dataUpdate);		
	}


	function addLifePath() {
		var form = {
				saveUrl : baseUrl+"/"+moduleId+"/element/updateblock/",
				timer : false,
				dynForm : {
					jsonSchema : {
						title : "Ajouter une expérience",//trad.addCuriculum,// trad["Update network"],
						icon : "fa-key",
						onLoads : {
							sub : function(data){
								$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url").addClass("bg-dark");
								console.log("DATA XXX", data);

								// if(data.startDateDB && data.endDateDB){
				    // 				$("#ajaxFormModal").after("<input type='hidden' id='startDateParent' value='"+data.startDateDB+"'/>"+
				    // 										  "<input type='hidden' id='endDateParent' value='"+data.endDateDB+"'/>");
				    // 				$("#ajaxFormModal #startDate").after("<span id='parentstartDate'><i class='fa fa-warning'></i> "+tradDynForm["parentStartDate"]+" : "+ moment( data.startDateDB /*,"YYYY-MM-DD HH:mm"*/).format('DD/MM/YYYY HH:mm')+"</span>");
				    // 				$("#ajaxFormModal #endDate").after("<span id='parentendDate'><i class='fa fa-warning'></i> "+tradDynForm["parentEndDate"]+" : "+ moment( data.endDateDB /*,"YYYY-MM-DD HH:mm"*/).format('DD/MM/YYYY HH:mm')+"</span>");
				    // 			}
								//bindDesc("#ajaxFormModal");
							}
						},
						beforeSave : function(){
							mylog.log("beforeSave");
					    	//removeFieldUpdateDynForm(contextData.type);
					    },
						afterSave : function(data){
							dyFObj.closeForm();
							toastr.success("Enregistrement des données de votre CV");
							strHash="";
    						if(location.hash.indexOf(".view")>0){
    							hashPage=location.hash.split(".view");
    							strHash=".view"+hashPage[1];
    						}	
    						//location.hash = data.resultGoods.values.slug+strHash;
    						///hashUrlPage="#"+data.resultGoods.values.slug;
    						/*if(typeof data.resultGoods.values.curiculum.lifepath != "undefined")
	    						$.each(data.resultGoods.values.curiculum.lifepath, function(key,value){
	    							console.log("afterSave --*", key, value);
									contextData.curiculum.lifepath[key]=value;
		    					});*/
							//rcObj.loadChat(data.resultGoods.values.slug,type,canEdit,hasRc);
							//loadDataDirectory(connectType, "user", true);
							//changeHiddenFields();
						},
						properties : {
					    	info : {
				                inputType : "custom",
				                html:"<p class='text-"+typeObj["organization"].color+"'>"+
				                		//"Faire connaître votre Organisation n'a jamais été aussi simple !<br>" +
									    //tradDynForm["infocreateorganization"]+" ...<hr>" +
									 "</p>",
				            },
					        block : dyFInputs.inputHidden(),
							typeElement : dyFInputs.inputHidden(), 

							title : dyFInputs.inputText("Titre"),

							
				            description : dyFInputs.textarea("Description", 
				            								"...", { maxlength: 500 }),
				            //startDate : dyFInputs.startDateInput("datetime"),
            				//endDate : dyFInputs.endDateInput("datetime"),
            				//location : dyFInputs.location,
					    }
					}
				}
			};
		var dataUpdate = {
			block : "curiculum.lifepath",
	        id : contextData.id,
	        typeElement : contextData.type
		};

		if(typeof contextData.curiculum != "undefined"){
			if(typeof contextData.curiculum.lifepath != "undefined"){
				var CVattrs = ["title", "description", "startDate", "endDate", "location"];
				$.each(CVattrs, function(key, value){ 
					console.log("in detail", value, contextData.curiculum,  contextData.curiculum.lifepath[value])
					if(typeof contextData.curiculum.lifepath[value] != "undefined"){
						dataUpdate[value] = contextData.curiculum.lifepath[value];
					}
				});
			}
		}
		console.log("openFormCV", dataUpdate);
		dyFObj.openForm(form, "sub", dataUpdate);		
	}
</script>