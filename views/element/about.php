<?php 
	$cssAnsScriptFilesModule = array(
		//Data helper
		'/js/dataHelpers.js',
		'/js/postalCode.js',
		'/js/default/editInPlace.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

?>
<style type="text/css">
	.labelAbout{
		border-right: 1px solid #dbdbdb;
	}
	.contentInformation{
		border-bottom: 1px solid #dbdbdb;
	}
	#ficheInfo{
		border:inherit !important;
	}
	.labelAbout span{
		width: 20px;
		padding-right: 5px;
		text-align: -moz-center;
		text-align: center;
		text-align: -webkit-center;
		float: left;
	}
	.labelAbout span i{
		font-size: 14px;
	}
	.panel-title{
		line-height:35px;
	}
</style>
<div id="ficheInfo" class="panel panel-white col-md-8 no-padding shadow2">
	<div class="panel-heading border-light col-md-12" style="background-color: #dee2e680;">
		<h4 class="panel-title text-dark pull-left"> 
			<i class="fa fa-info-circle"></i> <?php echo Yii::t("common","General information") ?>
		</h4>
		<?php if($edit==true || $openEdition==true ){?>
			<button class="btn-update-info btn btn-default letter-blue pull-right tooltips" 
				data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Edit properties") ?>">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
			</button>
		<?php } ?>
	</div>
	<div class="panel-body no-padding">
		<div class="col-md-12 contentInformation no-padding">
			<div class="col-md-4 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-pencil"></i></span> <?php echo Yii::t("common", "Name") ?>
			</div>
			<div class="col-md-8 col-xs-12 valueAbout padding-10">
				<?php echo $element["name"]; ?>
			</div>
		</div>
		<?php if($type==Project::COLLECTION && @$avancement){ ?>
			<div class="col-md-12 contentInformation no-padding">
				<div class="col-md-4 col-xs-12 labelAbout padding-10">
					<span><i class="fa fa-cycle"></i></span> <?php echo Yii::t("project","Project maturity"); ?>
				</div>
				<div class="col-md-8 col-xs-12 valueAbout padding-10">
					<?php echo (@$avancement) ? Yii::t("project",$avancement) : Yii::t("common","Not avaible") ?>
				</div>
			</div>
		<?php } ?>

		<?php if($type==Person::COLLECTION){ ?>
			<div class="col-md-12 contentInformation no-padding">
				<div class="col-md-4 col-xs-12 labelAbout padding-10">
					<span><i class="fa fa-user-secret"></i></span> <?php echo Yii::t("common","Username"); ?>
				</div>
				<div class="col-md-8 col-xs-12 valueAbout padding-10">
					<?php echo (@$element["username"]) ? $element["username"] : Yii::t("common","Not avaible") ?>
				</div>
			</div>
		<?php if(Preference::showPreference($element, $type, "birthDate", Yii::app()->session["userId"])){ ?>
			<div class="col-md-12 contentInformation no-padding">
				<div class="col-md-4 col-xs-12 labelAbout padding-10">
					<span><i class="fa fa-birthday-cake"></i></span> <?php echo Yii::t("person","Birth date"); ?>
				</div>
				<div class="col-md-8 col-xs-12 valueAbout padding-10">
					<?php echo (@$element["birthDate"]) ? date("d/m/Y", strtotime($element["birthDate"]))  : Yii::t("common","Not avaible"); ?>
				</div>
			</div>
		<?php }
		} ?>
		<?php if(($type==Person::COLLECTION && Preference::showPreference($element, $type, "email", Yii::app()->session["userId"])) || 
		  			($type!=Person::COLLECTION && $type!=Event::COLLECTION)){ ?>
		  	<div class="col-md-12 contentInformation no-padding">
				<div class="col-md-4 col-xs-12 labelAbout padding-10">
					<span><i class="fa fa-envelope"></i></span> <?php echo Yii::t("common","E-mail"); ?>
				</div>
				<div class="col-md-8 col-xs-12 valueAbout padding-10">
					<?php echo (@$element["email"]) ? $element["email"]  : Yii::t("common","Not avaible"); ?>
				</div>
			</div>
		<?php } ?>
		<?php //If there is no http:// in the url
			$scheme = "";
			if(@$element["url"]){
				if (!preg_match("~^(?:f|ht)tps?://~i", $element["url"])) $scheme = 'http://';
		}?>
			<div class="col-md-12 contentInformation no-padding">
				<div class="col-md-4 col-xs-12 labelAbout padding-10">
					<span><i class="fa fa-desktop"></i></span> <?php echo Yii::t("common","Website URL"); ?>
				</div>
				<div class="col-md-8 col-xs-12 valueAbout padding-10">
					<?php echo (@$element["url"]) ? 
							'<a href="'.$scheme.$element['url'].'" target="_blank" id="urlMenuLeft" style="cursor:pointer;">'.
								$element["url"].
							'</a>'
							 : Yii::t("common","Not avaible"); ?>
				</div>
			</div>
		<?php  if($type==Organization::COLLECTION || $type==Person::COLLECTION){ ?>
			<div class="col-md-12 contentInformation no-padding">
				<div class="col-md-4 col-xs-12 labelAbout padding-10">
					<span><i class="fa fa-phone"></i></span> <?php echo Yii::t("common","Phone"); ?>
				</div>
				<div class="col-md-8 col-xs-12 valueAbout padding-10">
					<?php
						$fixe = Yii::t("common","Not avaible");;
						if( !empty($element["telephone"]["fixe"])){
							$fixe = "";
							foreach ($element["telephone"]["fixe"] as $key => $num) {
								$fixe .= ($fixe != "") ? ", ".trim($num) : trim($num);
							}
							
						}	
						echo $fixe;
					?>	
				</div>
			</div>
			<div class="col-md-12 contentInformation no-padding">
				<div class="col-md-4 col-xs-12 labelAbout padding-10">
					<span><i class="fa fa-mobile"></i></span> <?php echo Yii::t("common","Mobile"); ?>
				</div>
				<div class="col-md-8 col-xs-12 valueAbout padding-10">
					<?php
						$mobile = Yii::t("common","Not avaible");;
						if( !empty($element["telephone"]["mobile"])){
							$mobile = "";
							foreach ($element["telephone"]["mobile"] as $key => $num) {
								$mobile .= ($mobile != "") ? ", ".trim($num) : trim($num);
							}
							
						}	
						echo $mobile;
					?>	
				</div>
			</div>
			<div class="col-md-12 contentInformation no-padding">
				<div class="col-md-4 col-xs-12 labelAbout padding-10">
					<span><i class="fa fa-fax"></i></span> <?php echo Yii::t("common","Fax"); ?>
				</div>
				<div class="col-md-8 col-xs-12 valueAbout padding-10">
					<?php
						$fax = Yii::t("common","Not avaible");;
						if( !empty($element["telephone"]["fax"])){
							$fax = "";
							foreach ($element["telephone"]["fax"] as $key => $num) {
								$fax .= ($fax != "") ? ", ".trim($num) : trim($num);
							}
							
						}	
						echo $fax;
					?>	
				</div>
			</div>
		<?php } ?>		
	</div>
	<div class="panel-heading border-light col-md-12" style="background-color: #dee2e680;">
		<h4 class="panel-title text-dark pull-left"> 
			<i class="fa fa-pencil"></i> <?php echo Yii::t("common","Descriptions") ?>
		</h4>
		<?php if($edit==true || $openEdition==true ){?>
		  	<button class="btn-update-desc btn btn-default letter-blue pull-right tooltips" 
				data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Edit properties") ?>">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
			</button>
		 <?php } ?>
	</div>
	<div class="panel-body no-padding">
		<div class="col-md-12 contentInformation no-padding">
			<div class="col-md-4 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-pencil"></i></span> <?php echo Yii::t("common", "Short description") ?>
			</div>
			<div class="col-md-8 col-xs-12 valueAbout padding-10">
				<?php echo (@$element["shortDescription"]) ? $element["shortDescription"] : Yii::t("common","Not avaible"); ?>
			</div>
		</div>
		<div class="col-md-12 contentInformation no-padding">
			<div class="col-md-4 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-pencil"></i></span> <?php echo Yii::t("common", "Description") ?>
			</div>
			<div class="col-md-8 col-xs-12 valueAbout padding-10">
				<?php  echo (@$element["description"]) ? $element["description"] : Yii::t("common","Not avaible"); ?>
			</div>
		</div>
	</div>
</div>
<div class="col-md-4">
	<div id="adressesAbout" class="panel panel-white col-md-12 no-padding shadow2">
		<div class="panel-heading border-light padding-15" style="background-color: #dee2e680;">
			<h4 class="panel-title text-dark"> 
				<i class="fa fa-map-marker"></i> <?php echo Yii::t("common","Localitie(s)"); ?>
			</h4>
		</div>
		<div class="panel-body no-padding">
			<div class="col-md-12 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-home"></i></span> <?php echo Yii::t("common", "Main locality") ?>
				<?php if (@$element["address"]["codeInsee"] && !empty($element["address"]["codeInsee"]) && $edit==true || $openEdition==true ){ 
					echo '<a href="javascript:;" id="btn-remove-geopos" class="pull-right tooltips" data-toggle="tooltip" data-placement="bottom" title="'.Yii::t("common","Remove Locality").'">
								<i class="fa text-red fa-trash-o"></i>
							</a> 
							<a href="javascript:;" id="btn-update-geopos" class="pull-right tooltips margin-right-15" data-toggle="tooltip" data-placement="bottom" title="'.Yii::t("common","Update Locality").'" >
								<i class="fa text-red fa-map-marker"></i>
							</a> ';	
				} ?>
			</div>
			<div class="col-md-8 col-xs-12 valueAbout no-padding" style="padding-left: 25px !important">
			<?php 
				if( ($type == Person::COLLECTION && Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"])) ||  $type!=Person::COLLECTION) {
					$address = "";
					$address .= '<span id="detailStreetAddress"> '.
									((@$element["address"]["streetAddress"]) ? 
										$element["address"]["streetAddress"] : "").
								'</span>';
					$address .= '<span id="detailCity">'.
									(( @$element["address"]["postalCode"]) ?
									 $element["address"]["postalCode"].", " :
									 "")
									." ".(( @$element["address"]["addressLocality"] && !empty($element["address"]["codeInsee"]) ? 
											 $element["address"]["addressLocality"] : "<i>".Yii::t("common","Unknown Locality")."</i>"))
								.'</span>';
					$address .= '<span id="detailCountry">'.
									(( @$element["address"]["addressCountry"]) ?
									 ", ".OpenData::$phCountries[ $element["address"]["addressCountry"] ] 
					 				: "").
					 			'</span>';
					echo $address;
					if(empty($element["address"]["codeInsee"]) && $type==Person::COLLECTION && $edit==true) {
						echo '<a href="javascript:;" class="cobtn btn btn-danger btn-sm" style="margin: 10px 0px;">'.Yii::t("common", "Connect to your city").'</a> <a href="javascript:;" class="whycobtn btn btn-default btn-sm explainLink" style="margin: 10px 0px;" data-id="explainCommunectMe" >'. Yii::t("common", "Why ?").'</a>';
					}
			} ?>
			</div>
		</div>
		<?php if( !empty($element["addresses"]) ){ ?>
			<div class="col-md-12 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-map"></i></span> <?php echo Yii::t("common", "Others localities") ?>
			</div>
			<div class="col-md-8 col-xs-12 valueAbout padding-10">
			<?php	foreach ($element["addresses"] as $ix => $p) { ?>			
				<span id="addresses_<?php echo $ix ; ?>">
					<span>
					<?php 
					$address = '<i class="fa fa-circle"></i> <span id="detailStreetAddress_'.$ix.'">'.(( @$p["address"]["streetAddress"]) ? $p["address"]["streetAddress"]."<br/>" : "").'</span>';
					$address .= '<span id="detailCity">'.(( @$p["address"]["postalCode"]) ? $p["address"]["postalCode"] : "")." ".(( @$p["address"]["addressLocality"]) ? $p["address"]["addressLocality"] : "").'</span>';
					$address .= '<span id="detailCountry_'.$ix.'">'.(( @$p["address"]["addressCountry"]) ? " ".OpenData::$phCountries[ $p["address"]["addressCountry"] ] : "").'</span>';
					echo $address;
					?>

					<a href='javascript:removeAddresses("<?php echo $ix ; ?>");'  class="addresses pull-right hidden tooltips" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Remove Locality");?>"><i class="fa text-red fa-trash-o"></i></a>
					<a href='javascript:updateLocalityEntities("<?php echo $ix ; ?>", <?php echo json_encode($p);?>);' class=" pull-right tooltips" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Update Locality");?>"><i class="fa text-red fa-map-marker hidden addresses"></i></a></span>
				</span>
			<?php 	} ?>
			</div>
		<?php } ?>
		<div class="text-right padding-10">
			<?php if(empty($element["address"]) && $type!=Person::COLLECTION && ($edit==true || $openEdition==true )){ ?>
				<b><a href="javascript:;" class="btn btn-default letter-blue margin-top-5 addresses" id="btn-update-geopos">
					<i class="fa fa-map-marker"></i>
					<span class="hidden-sm"><?php echo Yii::t("common","Add a primary address") ; ?></span>
				</a></b>
			<?php	}
			if($type!=Person::COLLECTION && !empty($element["address"]) && ($edit==true || $openEdition==true )) { ?>
				<b><a href='javascript:updateLocalityEntities("<?php echo count(@$element["addresses"]) ; ?>");' id="btn-add-geopos" class="btn btn-default letter-blue margin-top-5 addresses" style="margin: 10px 0px;">
					<i class="fa fa-plus" style="margin:0px !important;"></i> 
					<span class="hidden-sm"><?php echo Yii::t("common","Add a secondary address"); ?></span>
				</a></b>
			<?php } ?>						
		</div>
	</div>
	<?php 
		$skype = (!empty($element["socialNetwork"]["skype"])? $element["socialNetwork"]["skype"]:"javascript:;") ;
		$telegram =  (!empty($element["socialNetwork"]["telegram"])? "https://web.telegram.org/#/im?p=@".$element["socialNetwork"]["telegram"]:"javascript:;") ;
		$facebook = (!empty($element["socialNetwork"]["facebook"])? $element["socialNetwork"]["facebook"]:"javascript:;") ;
		$twitter =  (!empty($element["socialNetwork"]["twitter"])? $element["socialNetwork"]["twitter"]:"javascript:;") ;
		$googleplus =  (!empty($element["socialNetwork"]["googleplus"])? $element["socialNetwork"]["googleplus"]:"javascript:;") ;
		$gitHub =  (!empty($element["socialNetwork"]["github"])? $element["socialNetwork"]["github"]:"javascript:;") ;
		$instagram =  (!empty($element["socialNetwork"]["instagram"])? $element["socialNetwork"]["instagram"]:"javascript:;") ;
	?>
	<div id="socialAbout" class="panel panel-white col-md-12 no-padding shadow2">
		<div class="panel-heading border-light col-md-12" style="background-color: #dee2e680;">
			<h4 class="panel-title text-dark pull-left"> 
				<i class="fa fa-connectdevelop"></i> <?php echo Yii::t("common","Social networks"); ?>
			</h4>
			<?php if($edit==true || $openEdition==true ){?>
			<button class="btn-update-network btn btn-default letter-blue pull-right tooltips" 
				data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Edit properties") ?>">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
			</button>
		<?php } ?>
		</div>
		<div class="panel-body no-padding">
			<div class="col-md-12 contentInformation social padding-10">
				<span><i class="fa fa-facebook"></i></span> 
				<a href="<?php echo $facebook ; ?>" id="telegramMenuLeft" class="socialIcon tooltips" data-toggle="tooltip" data-placement="left" title="Facebook"><?php echo ($facebook != "javascript:;") ? $facebook : Yii::t("common","Not available") ; ?></a>
			</div>
			<div class="col-md-12 contentInformation social padding-10">
				<span><i class="fa fa-twitter"></i></span> 
				<a href="<?php echo $twitter ; ?>" id="telegramMenuLeft" class="socialIcon tooltips" data-toggle="tooltip" data-placement="left" title="Twitter"><?php echo ($twitter != "javascript:;") ? $twitter : Yii::t("common","Not available") ; ?></a>
			</div>
			<div class="col-md-12 contentInformation social padding-10">
				<span><i class="fa fa-instagram"></i></span> 
				<a href="<?php echo $instagram ; ?>" id="telegramMenuLeft" class="socialIcon tooltips" data-toggle="tooltip" data-placement="left" title="Instagram"><?php echo ($instagram != "javascript:;") ? $instagram : Yii::t("common","Not available") ; ?></a>
			</div>
			<div class="col-md-12 contentInformation social padding-10">
				<span><i class="fa fa-skype"></i></span> 
				<a href="<?php echo $skype ; ?>" id="telegramMenuLeft" class="socialIcon tooltips" data-toggle="tooltip" data-placement="left" title="Skype"><?php echo ($skype != "javascript:;") ? $skype : Yii::t("common","Not available") ; ?></a>
			</div>
			<div class="col-md-12 contentInformation social padding-10">
				<span><i class="fa fa-google-plus"></i></span> 
				<a href="<?php echo $googleplus ; ?>" id="telegramMenuLeft" class="socialIcon tooltips" data-toggle="tooltip" data-placement="left" title="Google Plus"><?php echo ($googleplus != "javascript:;") ? $googleplus : Yii::t("common","Not available") ; ?></a>
			</div>
			<div class="col-md-12 contentInformation social padding-10">
				<span><i class="fa fa-github"></i></span> 
				<a href="<?php echo $gitHub ; ?>" id="telegramMenuLeft" class="socialIcon tooltips" data-toggle="tooltip" data-placement="left" title="GitHub"><?php echo ($gitHub != "javascript:;") ? $gitHub : Yii::t("common","Not available") ; ?></a>
			</div>
			<?php if($type==Person::COLLECTION){ ?> 
			<div class="col-md-12 contentInformation social padding-10">
				<span><i class="fa fa-telegram"></i></span> 
				<a href="<?php echo $telegram ; ?>" id="telegramMenuLeft" class="socialIcon tooltips" data-toggle="tooltip" data-placement="left" title="Telegram"><?php echo ($telegram != "javascript:;") ? $telegram : Yii::t("common","Not available") ; ?></a>
			</div>
			<?php } ?>
		</div>	
    </div>  
</div>
<script type="text/javascript">

	//var elementName = "<?php //echo @$element["name"]; ?>";
    var contextType = "<?php //echo @$type; ?>";
    var contextId = "<?php //echo @$element["id"]; ?>";
    //var contextData = <?php //echo json_encode($element)?>;
    var edit = '<?php echo (@$edit == true) ? "true" : "false"; ?>';
	var openEdition = '<?php echo (@$openEdition == true) ? "true" : "false"; ?>';

	var showLocality = (( "<?php echo @$showLocality; ?>" == "<?php echo false; ?>")?false:true);
	var contextData = {
			name : "<?php echo addslashes($element["name"]) ?>",
			id : "<?php echo (string)$element["id"] ?>",
			type : "<?php echo $type ?>",
			controller : <?php echo json_encode(Element::getControlerByCollection($type))?>,
			<?php 
			if( @$element["startDate"] )
				echo "'startDate':'".$element["startDate"]."',";
			if( @$element["endDate"] )
				echo "'endDate':'".$element["endDate"]."'"; ?>
	};

	if(	( showLocality == true && "<?php echo Person::COLLECTION; ?>" == contextData.type ) 
		|| "<?php echo Person::COLLECTION; ?>" != contextData.type) {
		contextData.geo = <?php echo json_encode(@$element["geo"]) ?>;
		contextData.geoPosition = <?php echo json_encode(@$element["geoPosition"]) ?>;
		contextData.address = <?php echo json_encode(@$element["address"]) ?>;
		contextData.addresses = <?php echo json_encode(@$element["addresses"]) ?>;
	}

	if(	edit == "true" || openEdition == "true") {
		contextData.email = '<?php if(isset($element["email"])) echo $element["email"]; else echo ""; ?>';
		contextData.url = '<?php if(isset($element["url"])) echo $element["url"]; else echo ""; ?>';
		contextData.fixe =parsePhone(<?php echo json_encode((isset($element["telephone"]["fixe"]) ? $element["telephone"]["fixe"] : array())); ?>);
		contextData.mobile = parsePhone(<?php echo json_encode((isset($element["telephone"]["mobile"]) ? $element["telephone"]["mobile"] : array())); ?>);
		contextData.fax = parsePhone(<?php echo json_encode((isset($element["telephone"]["fax"]) ? $element["telephone"]["fax"] : array())); ?>);
		contextData.tags = <?php echo json_encode((isset($element["tags"]) ? $element["tags"] : array())); ?>;

		if(contextData.type == "<?php echo Person::COLLECTION; ?>" ){
			contextData.username = '<?php if(isset($element["username"])) echo $element["username"]; else echo ""; ?>';
			contextData.birthDate = '<?php if(isset($element["birthDate"])) echo $element["birthDate"]; else echo ""; ?>';
			contextData.twitter = '<?php if(isset($element["socialNetwork"]["twitter"])) echo $element["socialNetwork"]["twitter"]; else echo ""; ?>';
			contextData.gpplus = '<?php if(isset($element["socialNetwork"]["googleplus"])) echo $element["socialNetwork"]["googleplus"]; else echo ""; ?>';
			contextData.gitHub = '<?php if(isset($element["socialNetwork"]["github"])) echo $element["socialNetwork"]["github"]; else echo ""; ?>';
			contextData.skype = '<?php if(isset($element["socialNetwork"]["skype"])) echo $element["socialNetwork"]["skype"]; else echo ""; ?>';
			contextData.telegram = '<?php if(isset($element["socialNetwork"]["telegram"])) echo $element["socialNetwork"]["telegram"]; else echo ""; ?>';
			contextData.facebook = '<?php if(isset($element["socialNetwork"]["facebook"])) echo $element["socialNetwork"]["facebook"]; else echo ""; ?>';
		}
	}


	if(contextData.type == "<?php echo Organization::COLLECTION; ?>" ){
		contextData.typeOrga = '<?php if(isset($element["type"])) echo $element["type"]; else echo ""; ?>';
	}
	contextData.descriptionHTML = '<?php if(isset($element["descriptionHTML"])) echo $element["descriptionHTML"]; else echo ""; ?>';
	

	if(contextData.type == "<?php echo Event::COLLECTION; ?>"){
		contextData.allDay = '<?php echo (@$element["allDay"] == true) ? "true" : "false"; ?>';
	}

	if(contextData.type == "<?php echo Event::COLLECTION; ?>" || contextData.type == "<?php echo Project::COLLECTION; ?>" ){
		contextData.startDate = '<?php if(isset($element["startDate"])) echo $element["startDate"]; else echo ""; ?>';
		contextData.endDate = '<?php if(isset($element["endDate"])) echo $element["endDate"]; else echo "" ?>';
	}

	if(contextData.type == "<?php echo Project::COLLECTION; ?>" )
		contextData.avancement = '<?php if(isset($element["properties"]["avancement"])) echo $element["properties"]["avancement"]; else echo "" ?>' ;

	var formatDateView = "DD MMMM YYYY à HH:mm" ;
	var formatDatedynForm = "DD/MM/YYYY HH:mm" ;
	if(typeof contextData.allDay != "undefined" && contextData.allDay == "true"){
		formatDateView = "DD MMMM YYYY" ;
		formatDatedynForm = "DD/MM/YYYY" ;
	}

	var emptyAddress = (( "<?php echo @$emptyAddress; ?>" == "<?php echo false; ?>")?false:true);

	var mode = "view";
	var types = <?php echo json_encode(@$elementTypes) ?>;
	var countries = <?php echo json_encode(@$countries) ?>;
	//var startDate = '<?php //if(isset($element["startDate"])) echo $element["startDate"]; else echo ""; ?>';
	//var endDate = '<?php //if(isset($element["endDate"])) echo $element["endDate"]; else echo "" ?>';
	//var allDay = '<?php //echo (@$element["allDay"] == true) ? "true" : "false"; ?>';
	//var edit = '<?php //echo (@$edit == true) ? "true" : "false"; ?>';
	var modeEdit = '<?php echo (@$modeEdit == true) ? "true" : "false"; ?>';
	//var birthDate = '<?php echo (isset($person["birthDate"])) ? $person["birthDate"] : null; ?>';
	var NGOCategoriesList = <?php echo json_encode(@$NGOCategories) ?>;
	var localBusinessCategoriesList = <?php echo json_encode(@$localBusinessCategories) ?>;
	//var seePreferences = '<?php echo (@$element["seePreferences"] == true) ? "true" : "false"; ?>';
	var color = '<?php echo Element::getColorIcon($type); ?>';
	var icon = '<?php echo Element::getFaIcon($type); ?>';
	//var speudoTelegram = '<?php echo @$element["socialNetwork"]["telegram"]; ?>';
	var organizer = <?php echo json_encode(@$organizer) ?>;
	var tags = <?php echo json_encode($tags)?>;

	//var tags2 = <?php //echo (isset($element["tags"])) ? json_encode(implode(",", $element["tags"])) : "''"; ?>;
		
	//var mobile 	 = <?php //echo (isset($element["telephone"]["mobile"])) 	? json_encode(implode(",", $element["telephone"]["mobile"])) : "''"; ?>;
	//var fax 	 = <?php //echo (isset($element["telephone"]["fax"])) 	? json_encode(implode(",", $element["telephone"]["fax"])) : "''"; ?>;
	//var fixe 	 = <?php //echo (isset($element["telephone"]["fixe"])) 	? json_encode(implode(",", $element["telephone"]["fixe"])) : "''"; ?>;
	var category = <?php echo (isset($element["category"])) 			? json_encode(implode(",", $element["category"])) : "''"; ?>;
	var description = <?php echo (isset($element["description"])) ? json_encode($element["description"]) : "''"; ?>;

	var TYPE_NGO = "<?php echo Organization::TYPE_NGO ?>";
	var TYPE_BUSINESS = "<?php echo Organization::TYPE_BUSINESS ?>";
	var EVENT_COLLECTION = "<?php echo Event::COLLECTION ?>";

	

	//var contentKeyBase = "<?php //echo isset($contentKeyBase) ? $contentKeyBase : ""; ?>";
	//By default : view mode
	//var images = <?php //echo json_encode(@$images) ?>;
	
	//var publics = <?php //echo json_encode(@$publics) ?>;
	var isEditing = false;
	
	jQuery(document).ready(function() {
		bindDynFormEditable();
		initDate();
		inintDescs();
		changeHiddenFields();
		bindAboutPodElement();
		bindLBHLinks();

		$("#small_profil").html($("#menu-name").html());
		$("#menu-name").html("");


		$("#btn-update-geopos").off().on( "click", function(){
			updateLocalityEntities();
		});

		$("#btn-add-geopos").off().on( "click", function(){
			updateLocalityEntities();
		});

		$("#btn-update-organizer").off().on( "click", function(){
			updateOrganizer();
		});
		$("#btn-add-organizer").off().on( "click", function(){
			updateOrganizer();
		});

		$("#btn-remove-geopos").off().on( "click", function(){
			var msg = "<?php echo Yii::t('common','Are you sure you want to delete the locality') ;?>" ;
			if(contextData.type == "<?php echo Person::COLLECTION; ?>")
				msg = "<?php echo Yii::t('common',"Are you sure you want to delete the locality ? You can't vote anymore in the citizen council of your city."); ?> ";

			bootbox.confirm({
				message: msg + "<span class='text-red'></span>",
				buttons: {
					confirm: {
						label: "<?php echo Yii::t('common','Yes');?>",
						className: 'btn-success'
					},
					cancel: {
						label: "<?php echo Yii::t('common','No');?>",
						className: 'btn-danger'
					}
				},
				callback: function (result) {
					if (!result) {
						return;
					} else {
						param = new Object;
				    	param.name = "locality";
				    	param.value = "";
				    	param.pk = contextData.id;
						$.ajax({
					        type: "POST",
					        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextDate.type,
					        data: param,
					       	dataType: "json",
					    	success: function(data){
						    	//
						    	if(data.result){
									if(contextData.type == "<?php echo Person::COLLECTION ;?>"){
										//Menu Left
										$("#btn-geoloc-auto-menu").attr("href", "javascript:");
										$('#btn-geoloc-auto-menu > span.lbl-btn-menu').html("Communectez-vous");
										$("#btn-geoloc-auto-menu").attr("onclick", "communecterUser()");
										$("#btn-geoloc-auto-menu").off().removeClass("lbh");
										//Dashbord
										$("#btn-menuSmall-mycity").attr("href", "javascript:");
										$("#btn-menuSmall-citizenCouncil").attr("href", "javascript:");
										//Multiscope
										$(".msg-scope-co").html("<i class='fa fa-cogs'></i> Paramétrer mon code postal</a>");
										//MenuSmall
										$(".hide-communected").show();
										$(".visible-communected").hide();
									}
									toastr.success(data.msg);
									url.loadByHash("#"+contextData.controller+".detail.id."+contextData.id);
						    	}
						    }
						});
					}
				}
			});	

		});

		$("#btn-update-geopos-admin").click(function(){
			findGeoPosByAddress();
		});

		//console.log("contextDatacontextData", contextData, contextData.type,contextData.id);
		buildQRCode(contextData.type,contextData.id.$id);

		$(".toggle-tag-dropdown").click(function(){ mylog.log("toogle");
			if(!$("#dropdown-content-multi-tag").hasClass('open'))
			setTimeout(function(){ $("#dropdown-content-multi-tag").addClass('open'); }, 300);
			$("#dropdown-content-multi-tag").addClass('open');
		});
		$(".toggle-scope-dropdown").click(function(){ mylog.log("toogle");
			if(!$("#dropdown-content-multi-scope").hasClass('open'))
			setTimeout(function(){ $("#dropdown-content-multi-scope").addClass('open'); }, 300);
		});

		smallMenu.inBlockUI = false; 
		smallMenu.destination = "#central-container"; 
		directory.elemClass = smallMenu.destination+' .searchEntityContainer ';

		mylog.log("tagg1 smallMenu.destination", smallMenu.destination);
		
		
		
	});

	function parsePhone(arrayPhones){
		var str = "";
		$.each(arrayPhones, function(i,num) {
			if(str != "")
				str += ", ";
			str += num.trim();
		});
		return str ;
	}

	function initDate() {//DD/mm/YYYY hh:mm
		if($("#contentGeneralInfos #startDate").html() != "")
	    	$("#contentGeneralInfos #startDate").html(moment($("#contentGeneralInfos #startDate").html()).local().format(formatDateView));
	    if($("#contentGeneralInfos #endDate").html() != "")
	    	$("#contentGeneralInfos #endDate").html(moment($("#contentGeneralInfos #endDate").html()).local().format(formatDateView));
	    $('#dateTimezone').attr('data-original-title', "Fuseau horaire : GMT " + moment().local().format("Z"));
	}

	function descHtmlToMarkdown() {
		mylog.log("htmlToMarkdown");
		if(typeof contextData.descriptionHTML != "undefined" && contextData.descriptionHTML == "1"){
			if($("#contentGeneralInfos #description").html() != ""){
				var descToMarkdown = toMarkdown($("#contentGeneralInfos #descriptionMarkdown").val()) ;
				mylog.log("descToMarkdown", descToMarkdown);
	    		$("#contentGeneralInfos #descriptionMarkdown").html(descToMarkdown);
				var param = new Object;
				param.name = "description";
				param.value = descToMarkdown;
				param.id = contextData.id;
				param.typeElement = contextType;
				param.block = "toMarkdown";
	    		$.ajax({
			        type: "POST",
			       	url : baseUrl+"/"+moduleId+"/element/updateblock/type/"+contextType,
			        data: param,
			       	dataType: "json",
			    	success: function(data){
			    		mylog.log("here");
				    	toastr.success(data.msg);
				    }
				});
				mylog.log("param", param);
			}
		}
	}

	function inintDescs() {
		mylog.log("inintDescs");
		descHtmlToMarkdown();
		mylog.log("after");
		$("#description").html(markdownToHtml($("#descriptionMarkdown").val()));
		//$("#shortDescriptionHeader").html(markdownToHtml($("#shortDescriptionMarkdown").val()));
	}

</script>