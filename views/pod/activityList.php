<?php
/* Author @Bouboule (CDA)
* ActivityList is a view to show each activity realized on an entity by someone
* Modification in x-editable, or creation of the entity, added an image
* Improvement: permits a versioning of each modification
*/
$arrayLabel=array(
	"name" => Yii::t("common","the name"),
	"description" => Yii::t("common","the description"),
	"tags" => Yii::t("common","the tags"),
	"slug" => Yii::t("common","the slug"),
	"type" => Yii::t("common","the type"),
	"address" => Yii::t("common","the main locality"),
	"addresses" => Yii::t("common","a second locality"),
	"address.streetAddress" => Yii::t("common","the street"),
	"address.addressCountry" => Yii::t("common","the country"),
	"geo" => Yii::t("common","the position"),
	"geoPosition" => Yii::t("common","the position"),
	"allDay" => Yii::t("common", "the duration of the event to all day"),
	"startDate" => Yii::t("common", "the start"),
	"endDate" => Yii::t("common", "the end"),
	"event" => Yii::t("common", "the event"),
	"organization" => Yii::t("common", "the organization"),
	"project" => Yii::t("common", "the project"),
	"shortDescription" => Yii::t("common", "the short description"),
	"telephone.fax" => Yii::t("common", "the fax"),
	"telephone.mobile" => Yii::t("common", "the mobile"),
	"telephone.fixe" => Yii::t("common", "the fixe"),
	"email" => Yii::t("common", "the email"),
	"url" => Yii::t("common", "the website"),
	"licence" => Yii::t("common", "the licence"),
	"properties.avancement" => Yii::t("common", "the maturity"),
	"isOpenData" => Yii::t("common", "open data"),
	"isOpenEdition" => Yii::t("common", "open edition"),
	"state" => Yii::t("common", "state"),
	"organizer" => Yii::t("common", "organizer"),
	"contacts" => Yii::t("common", "un contact"),
	"descriptionHTML" => Yii::t("common", "the descripton"),
);
if ($contextType == Organization::COLLECTION)
	$contextTypeLabel=Yii::t("common","of the organization");
else if ($contextType == Event::COLLECTION)
	$contextTypeLabel=Yii::t("common","of the event");
else	
	$contextTypeLabel=Yii::t("common","of the project");
$countries= OpenData::getCountriesList();
?>
<div class="col-xs-12">
	<?php 
		if(count($activities)==0){ ?>
			<div id="infoPodOrga" class="padding-10 info-no-need">
					<blockquote> 
						<?php echo Yii::t("activityList","There is no activity for the moment.<br/>Edit...<br/>To improve the commons informations<br/>To give a better overview of territories' actors and activities<br/>And to liberate your knowledge"); ?>
					</blockquote>
				</div>
	<?php } else{
			foreach($activities as $key => $value){ 
				if(@$value["object"]["displayName"] && $value["object"]["displayName"] != "descriptionHTML"){
					if($value["verb"]==ActStr::VERB_UPDATE)
						$action = Yii::t("common", "has updated");
					else if($value["verb"]==ActStr::VERB_ADD )
						$action = Yii::t("common", "has added");
					else if($value["verb"]==ActStr::VERB_CREATE){
						$action = Yii::t("common", "has created");
						$contextTypeLabel="";
					}
					else if($value["verb"]==ActStr::VERB_DELETE)
						$action = Yii::t("common", "has deleted");
						
			?>
				<div class='col-xs-12 padding-10' style="border-bottom: 1px solid lightgrey;">
					<?php echo "<i class='fa fa-clock-o'></i> ".date("d/m/y H:i",$value["created"]->sec)."<br/>";
						echo Yii::t("common","{who} ".$action." {what} {where}",
							array("{who}"=>"<a href='#page.type.".Person::COLLECTION.".id.".$value["author"]["id"]."' class='lbh'>".$value["author"]["name"]."</a>",
								"{what}"=>"<span style='font-weight:bold;'>".$arrayLabel[$value["object"]["displayName"]]."</span>",
								"{where}"=>$contextTypeLabel));
						echo ": <span style='color: #21b384;'>";
						if($value["object"]["displayName"]=="address" || $value["object"]["displayName"]=="addresses"){
							if(@$value["object"]["displayValue"]){
								if (@$value["object"]["displayValue"]["address"]){
									$address = $value["object"]["displayValue"]["address"];
									$geo = @$value["object"]["displayValue"]["geo"];
									if(!empty($address["streetAddress"]))
										echo $address["streetAddress"].", " ;
									if(!empty($address["postalCode"]))
										echo $address["postalCode"].", " ;
									echo $address["addressLocality"] ;
									echo ", ".OpenData::$phCountries[$address["addressCountry"]] ;
									echo " <i class='fa fa-globe fa_addressCountry'></i> ( ".@$geo["latitude"]."/".@$geo["longitude"].") ";
								} 
							}
						}
							//echo $value["object"]["displayValue"];
							//echo $value["object"]["displayValue"]["postalCode"]." ".$value["object"]["displayValue"]["addressLocality"];
						else if($value["object"]["displayName"]=="address.addressCountry"){
							foreach($countries as $country){
								if($country["value"]==$value["object"]["displayValue"])
									echo $country["text"];
							}
						}else if($value["object"]["displayName"]=="telephone.fax" 
									|| $value["object"]["displayName"]=="telephone.mobile" 
										|| $value["object"]["displayName"]=="telephone.fixe"
											|| $value["object"]["displayName"]=="tags"){
							if(@$value["object"]["displayValue"]){
								foreach ($value["object"]["displayValue"] as $key => $tel) {
									if($key > 0)
										echo ", ";
									echo $tel;
								}
							} else 
								echo "champs vidés";
						} else if (@$value["object"]["displayName"] == "organizer") {
							$organizer = "";
							if (@$value["object"]["displayValue"] && $value["object"]["displayValue"]["organizerType"] != "dontKnow")
								$organizer = Element::getInfos(@$value["object"]["displayValue"]["organizerType"], @$value["object"]["displayValue"]["organizerId"]);	
							echo empty($organizer["name"]) ? "Inconnu" : @$value["object"]["displayValue"]["organizerType"]." / ".$organizer["name"];
						} else if (@$value["object"]["displayName"] == "contacts") {
							if (empty($value["object"]["displayValue"]) || $value["object"]["displayValue"] == "dontKnow") {
								$contacts = "";
							} else {
								$contacts = $value["object"]["displayValue"];
							}
							if(isset($contacts["name"]))
								echo " ".Yii::t("common", "Name")." : ".$contacts["name"];

							if(isset($contacts["role"]))
								echo " ".Yii::t("common", "Role")." : ".$contacts["role"];
							if(isset($contacts["url"]))
								echo " ".Yii::t("common", "Url")." : ".$contacts["url"];
							if(isset($contacts["tel"]))
								echo " ".Yii::t("common", "Phone")." : ".$contacts["tel"];
						
						} else if(@$value["object"]["displayValue"] && !empty($value["object"]["displayValue"]) )
							echo Yii::t("common",$value["object"]["displayValue"]);
						else if($value["object"]["displayName"] == "descriptionHTML")
							echo Yii::t("common","change description in markdown format");
						else
							echo Yii::t("common","deleted");
						
							
						echo "</span>";
					?>
				</div>
			<?php	
			} }

		}
	?>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		bindLBHLinks();
	});
</script>
