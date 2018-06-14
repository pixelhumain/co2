
<?php if(empty($curiculum)){ ?>
<h5>Vous n'avez pas encore rempli votre CV</h5>
Détaillez votre parcours personnel et professionnel pour faciliter votre recherche d'emploi.
<hr><br><br>

<?php } ?>

<h4>
	Informations générales
	<button class="btn btn-default btn-sm bg-blue-k" id="btn-update-cv-skills">
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
	<div class="label text-dark"><?php echo $lbl; ?></div>
	<div class="label text-dark">
		<?php echo isset($curiculum["skills"][$key]) ? $curiculum["skills"][$key] : "Non renseigné"; ?>
	</div>
	<br>
<?php } var_dump($curiculum); ?>

<br><br>
<h4>Parcours personnel et professionnel</h4>
<hr>

<button class="btn btn-default">
	<i class="fa fa-plus-circle"></i> Ajouter
</button>
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
								$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url").addClass("bg-red");
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
</script>