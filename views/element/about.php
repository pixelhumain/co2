<?php
	$cssAnsScriptFilesModule = array(
		//Data helper
		'/js/dataHelpers.js',
		'/js/default/editInPlace.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

?>
<style type="text/css">
	.valueAbout{
		border-left: 1px solid #dbdbdb;
	}
	#shortDescriptionAbout{
		white-space: pre-line;
	}

	/*#descriptionAbout{
		padding-left : 10px;
	}*/

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

	.md-preview{
		text-align:left;
		padding: 0px 10px;
	}

	.md-editor > textarea {
		padding: 10px;
	}

	.descriptiontextarea label{
		margin-left:10px;
	}


	@media (min-width: 1200px) {
		.no-ing{
			padding-left: 15px !important;
		}
	}
</style>

<div class='col-md-12 margin-bottom-15'>
	<i class="fa fa-info-circle fa-2x"></i><span class='Montserrat' id='name-lbl-title'> <?php echo Yii::t("common","About") ?></span>
</div>

<div id="ficheInfo" class="panel panel-white col-lg-12 col-md-12 col-sm-12 no-padding shadow2">
	
	<div class="panel-heading border-light col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #dee2e680;">
		<h4 class="panel-title text-dark pull-left">
			<i class="fa fa-file-text-o"></i> <?php echo Yii::t("common","Descriptions") ?>
		</h4>
		<?php if($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ){?>
		  	<button class="btn-update-descriptions btn btn-default letter-blue pull-right tooltips" 
				data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Update description") ?>">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
			</button>
		 <?php } ?>
	</div>
	<div class="panel-body no-padding">
		<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
			<div class="col-md-3 col-sm-3 col-xs-3 hidden-xs labelAbout padding-10">
				<span><i class="fa fa-quote-left"></i></span> <?php echo Yii::t("common", "Short description") ?>
			</div>
			<div id="shortDescriptionAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
				<span class="visible-xs col-xs-12 no-padding"><i class="fa fa-quote-left"></i> <?php echo Yii::t("common", "Short description") ?>: </span><?php echo (@$element["shortDescription"]) ? $element["shortDescription"] : '<i>'.Yii::t("common","Not specified").'</i>'; ?>
			</div>
			<span id="shortDescriptionAboutEdit" name="shortDescriptionAboutEdit"  class="hidden" ><?php echo (!empty($element["shortDescription"])) ? $element["shortDescription"] : ""; ?></span>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
			<div class="col-md-3 col-sm-3 col-xs-3 hidden-xs labelAbout padding-10">
				<span><i class="fa fa-paragraph"></i></span> <?php echo Yii::t("common", "Description") ?>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10" 
					style="word-wrap: break-word; overflow:hidden;">
				<span class="visible-xs col-xs-12 no-padding">
					<i class="fa fa-paragraph"></i> <?php echo Yii::t("common", "Description") ?>:
				</span>
				<div id="descriptionAbout"><?php echo (@$element["description"]) ? $element["description"] : '<i>'.Yii::t("common","Not specified").'</i>'; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="ficheInfo" class="panel panel-white col-lg-8 col-md-12 col-sm-12 no-padding shadow2">

	<div class="panel-heading border-light col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #dee2e680;">
		<h4 class="panel-title text-dark pull-left"> 
			<i class="fa fa-address-card-o"></i> <?php echo Yii::t("common","General information") ?>
		</h4>
		<?php if($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ){?>
			<button class="btn-update-info btn btn-default letter-blue pull-right tooltips" 
				data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Update general information") ?>">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
			</button>
		<?php } ?>
	</div>
	<div class="panel-body no-padding">
		<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
			<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
				<span><i class="fa fa-pencil"></i></span> <?php echo Yii::t("common", "Name") ?>
			</div>
			<div id="nameAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
				<span class="visible-xs pull-left margin-right-5"><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Name") ?> :</span> <?php echo $element["name"]; ?>
			</div>
		</div>
		<?php if($type==Project::COLLECTION){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-line-chart"></i></span> <?php echo Yii::t("project","Project maturity"); ?>
				</div>
				<div  id="avancementAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-line-chart"></i> <?php echo Yii::t("project","Project maturity"); ?> :</span><?php echo (@$element["properties"]["avancement"]) ? Yii::t("project",$element["properties"]["avancement"]) : '<i>'.Yii::t("common","Not specified").'</i>' ?>
				</div>
			</div>
		<?php } ?>

		<?php if($type==Person::COLLECTION){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-user-secret"></i></span> <?php echo Yii::t("common","Username"); ?>
				</div>
				<div id="usernameAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-user-secret"></i><?php echo Yii::t("common","Username"); ?> :</span><?php echo (@$element["username"]) ? $element["username"] : '<i>'.Yii::t("common","Not specified").'</i>' ?>
				</div>
			</div>
		<?php if(Preference::showPreference($element, $type, "birthDate", Yii::app()->session["userId"])){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-birthday-cake"></i></span> <?php echo Yii::t("person","Birth date"); ?>
				</div>
				<div id="birthDateAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-birthday-cake"></i> <?php echo Yii::t("person","Birth date"); ?> :</span><?php echo (@$element["birthDate"]) ? date("d/m/Y", strtotime($element["birthDate"]))  : '<i>'.Yii::t("common","Not specified").'</i>'; ?>
				</div>
			</div>
		<?php }
		} 


 		if($type==Organization::COLLECTION || $type==Event::COLLECTION){ ?>
 				<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
					<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
						<span><i class="fa fa-angle-right"></i></span><?php echo Yii::t("common", "Type"); ?> 
					</div>
					<div id="typeAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
						<span class="visible-xs pull-left margin-right-5"><i class="fa fa-angle-right"></i> <?php echo Yii::t("common", "Type"); ?> :</span>

						<?php 
						if(@$typesList && @$element["type"])
							$showType=Yii::t( "category",$typesList[$element["type"]]);
						else if (@$element["type"])
							$showType=Yii::t( "category",$element["type"]);
						else
							$showType='<i>'.Yii::t("common","Not specified").'</i>';
						echo $showType; ?>
					</div>
				</div>
		<?php }

		if( (	$type==Person::COLLECTION && 
				Preference::showPreference($element, $type, "email", Yii::app()->session["userId"]) ) || 
		  	$type == Organization::COLLECTION ) { ?>
		  	<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-envelope"></i></span> <?php echo Yii::t("common","E-mail"); ?>
				</div>
				<div id="emailAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-envelope"></i> <?php echo Yii::t("common","E-mail"); ?> :</span><?php echo (@$element["email"]) ? $element["email"]  : '<i>'.Yii::t("common","Not specified").'</i>'; ?>
				</div>
			</div>
		<?php } ?>



		<?php if($type != Person::COLLECTION){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-link"></i></span> <?php echo Yii::t("common","Parenthood"); ?>
				</div>
				<div id="parentAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-desktop"></i> <?php echo Yii::t("common","Parenthood"); ?> :</span>
				<?php 
					if(!empty($element["parent"])){ ?>
						<a href="#page.type.<?php  echo $element['parentType']; ?>.id.<?php  echo $element['parentId']; ?>" class="lbh"> 
						<i class="fa fa-<?php echo Element::getFaIcon($element['parentType']); ; ?>"></i> 
						<?php echo $element['parent']['name']; ?></a><br/> 
				<?php }else
						echo '<i>'.Yii::t("common","Not specified").'</i>';?>
				</div>
			</div>
		<?php } ?>

		<?php if($type == Event::COLLECTION){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-link"></i></span> <?php echo Yii::t("common","Organized by"); ?>
				</div>
				<div id="organizerAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-desktop"></i> <?php echo Yii::t("common","Organized by"); ?> :</span>
				<?php 
					if(!empty($element["organizer"])){ ?>
						<a href="#page.type.<?php  echo $element['organizerType']; ?>.id.<?php  echo $element['organizerId']; ?>" class="lbh"> 
						<i class="fa fa-<?php echo Element::getFaIcon($element['organizerType']); ; ?>"></i> 
						<?php echo $element['organizer']['name']; ?></a><br/> 
				<?php }else
						echo '<i>'.Yii::t("common","Not specified").'</i>';?>
				</div>
			</div>
		<?php } ?>





		<?php if($type!=Poi::COLLECTION){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-desktop"></i></span> <?php echo Yii::t("common","Website URL"); ?>
				</div>
				<div id="webAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-desktop"></i> <?php echo Yii::t("common","Website URL"); ?> :</span>
				<?php 
					if(@$element["url"]){
						//If there is no http:// in the url
						$scheme = ( (!preg_match("~^(?:f|ht)tps?://~i", $element["url"]) ) ? 'http://' : "" ) ;
					 	echo '<a href="'.$scheme.$element['url'].'" target="_blank" id="urlWebAbout" style="cursor:pointer;">'.$element["url"].'</a>';
					}else
						echo '<i>'.Yii::t("common","Not specified").'</i>'; ?>
				</div>
			</div>
		<?php } ?>
		<?php  if($type==Organization::COLLECTION || $type==Person::COLLECTION){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-phone"></i></span> <?php echo Yii::t("common","Phone"); ?>
				</div>
				<div id="fixeAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-phone"></i> <?php echo Yii::t("common","Phone"); ?> :</span><?php
						$fixe = '<i>'.Yii::t("common","Not specified").'</i>';
						if( !empty($element["telephone"]["fixe"]))
							$fixe = ArrayHelper::arrayToString($element["telephone"]["fixe"]);
						
						echo $fixe;
					?>	
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-mobile"></i></span> <?php echo Yii::t("common","Mobile"); ?>
				</div>
				<div id="mobileAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5">
						<i class="fa fa-mobile"></i> <?php echo Yii::t("common","Mobile"); ?> :
					</span>
					<?php
						$mobile = '<i>'.Yii::t("common","Not specified").'</i>';
						if( !empty($element["telephone"]["mobile"]))
							$mobile = ArrayHelper::arrayToString($element["telephone"]["mobile"]);	
						echo $mobile;
					?>	
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-fax"></i></span> <?php echo Yii::t("common","Fax"); ?>
				</div>
				<div id="faxAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5">
						<i class="fa fa-fax"></i> <?php echo Yii::t("common","Fax"); ?> :
					</span>
					<?php
						$fax = '<i>'.Yii::t("common","Not specified").'</i>';
						if( !empty($element["telephone"]["fax"]) )
							$fax = ArrayHelper::arrayToString($element["telephone"]["fax"]);		
						echo $fax;
					?>
				</div>
			</div>
		<?php } ?>

			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-hashtag"></i></span> <?php echo Yii::t("common","Tags"); ?>
				</div>
				<div id="tagsAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5">
						<i class="fa fa-hashtag"></i> <?php echo Yii::t("common","Tags"); ?> :
					</span>
					<?php 	if(!empty($element["tags"])){
								foreach ($element["tags"]  as $key => $tag) { 
		        					echo '<span class="badge letter-red bg-white">'.$tag.'</span>';
		   						}
							}else{
								echo '<i>'.Yii::t("common","Not specified").'</i>';
							} ?>	
				</div>
			</div>
	</div>
	
</div>

<div class="no-ing col-lg-4 col-md-12 col-sm-12 col-xs-12 no-padding">
<?php if($type==Event::COLLECTION || $type==Project::COLLECTION){ ?>
		<div id="socialAbout" class="panel panel-white col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding shadow2">
			<div class="panel-heading border-light col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #dee2e680;">
				<a id="dateTimezone" href="javascript:;" class="tooltips text-dark" data-original-title="" data-toggle="tooltip" data-placement="right">
					<h4 class="panel-title text-dark pull-left"> 
						<i class="fa fa-clock-o"></i> <?php echo Yii::t("common","When"); ?>
					</h4>
				</a>
				<?php if($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ){?>
					<button class="btn-update-when btn btn-default letter-blue pull-right tooltips" 
						data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Update date") ?>">
						<b><i class="fa fa-pencil"></i></b>
					</button>
				<?php } ?>
			</div>
			<div class="panel-body no-padding">
				<?php if($type==Event::COLLECTION){ ?> 
				<div class="col-md-12 col-sm-12 col-xs-12 contentInformation padding-10">
					<span><?php echo Yii::t("common","All day")?> : </span> 
					<span id="allDayAbout" class="" >
						<?php echo (isset($element["allDay"]) ? Yii::t("common","Yes") : Yii::t("common","No") ); ?>
					</span>
				</div>
				<?php } ?>

					<div id="divStartDate" class="col-md-12 col-sm-12 col-xs-12 contentInformation padding-10">
						<span><?php echo Yii::t("event","From") ?> </span><span id="startDateAbout" class="" ><?php echo (isset($element["startDate"]) ? $element["startDate"] : "" ); ?></span>
					</div>
					<div id="divEndDate"  class="col-md-12 col-sm-12 col-xs-12 contentInformation padding-10">
						<span><?php echo Yii::t("common","To") ?></span> <span id="endDateAbout" class=""><?php echo (isset($element["endDate"]) ? $element["endDate"] : "" ); ?></span> 
					</div>
					<div id="divNoDate" class="col-md-12 col-sm-12 col-xs-12 contentInformation padding-10">
						<span>Pas de date</span>
					</div>
				
			</div>	
	    </div>  
	<?php } ?>

	<div id="adressesAbout" class="panel panel-white col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding shadow2">
		<div class="panel-heading border-light padding-15" style="background-color: #dee2e680;">
			<h4 class="panel-title text-dark"> 
				<i class="fa fa-map-marker"></i> <?php echo Yii::t("common","Localitie(s)"); ?>
			</h4>
		</div>
		<div class="panel-body no-padding">		

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-home"></i></span> <?php echo Yii::t("common", "Main locality") ?>
				<?php if (!empty($element["address"]["codeInsee"]) && ( $edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ) ) { 
					echo '<a href="javascript:;" id="btn-remove-geopos" class="pull-right tooltips" data-toggle="tooltip" data-placement="bottom" title="'.Yii::t("common","Remove Locality").'">
								<i class="fa text-red fa-trash-o"></i>
							</a> 
							<a href="javascript:;" class="btn-update-geopos pull-right tooltips margin-right-15" data-toggle="tooltip" data-placement="bottom" title="'.Yii::t("common","Update Locality").'" >
								<i class="fa text-red fa-map-marker"></i>
							</a> ';	
				} ?>
			</div>
			<div class="col-md-12 col-xs-12 valueAbout no-padding" style="padding-left: 25px !important">
			<?php 
				if( ($type == Person::COLLECTION && Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"])) ||  $type!=Person::COLLECTION) {
					$address = "";
					$address .= '<span id="detailAddress"> '.
									(( @$element["address"]["streetAddress"]) ? 
										$element["address"]["streetAddress"]."<br/>": 
										((@$element["address"]["codeInsee"])?"":Yii::t("common","Unknown Locality")));
					$address .= (( @$element["address"]["postalCode"]) ?
									 $element["address"]["postalCode"].", " :
									 "")
									." ".(( @$element["address"]["addressLocality"]) ? 
											 $element["address"]["addressLocality"] : "") ;
					$address .= (( @$element["address"]["addressCountry"]) ?
									 ", ".OpenData::$phCountries[ $element["address"]["addressCountry"] ] 
					 				: "").
					 			'</span>';
					echo $address;
					if( empty($element["address"]["codeInsee"]) && Yii::app()->session["userId"] == (String) $element["_id"]) { ?>
						<br><a href="javascript:;" class="cobtn btn btn-danger btn-sm" style="margin: 10px 0px;">
								<?php echo Yii::t("common", "Connect to your city") ?></a> 
							<a href="javascript:;" class="whycobtn btn btn-default btn-sm explainLink" style="margin: 10px 0px;" onclick="showDefinition('explainCommunectMe',true)">
								<?php echo  Yii::t("common", "Why ?") ?></a>
					<?php }
			}else
				echo '<i>'.Yii::t("common","Not specified").'</i>';
			?>
			</div>
		</div>
		<?php if( !empty($element["addresses"]) ){ ?>
			<div class="col-md-12 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-map"></i></span> <?php echo Yii::t("common", "Others localities") ?>
			</div>
			<div class="col-md-12 col-xs-12 valueAbout no-padding" style="padding-left: 25px !important">
			<?php	foreach ($element["addresses"] as $ix => $p) { ?>			
				<span id="addresses_<?php echo $ix ; ?>">
					<span>
					<?php 
					$address = '<span id="detailAddress_'.$ix.'"> '.
									(( @$p["address"]["streetAddress"]) ? 
										$p["address"]["streetAddress"]."<br/>": 
										((@$p["address"]["codeInsee"])?"":Yii::t("common","Unknown Locality")));
					$address .= (( @$p["address"]["postalCode"]) ?
									 $p["address"]["postalCode"].", " :
									 "")
									." ".(( @$p["address"]["addressLocality"]) ? 
											 $p["address"]["addressLocality"] : "") ;
					$address .= (( @$p["address"]["addressCountry"]) ?
									 ", ".OpenData::$phCountries[ $p["address"]["addressCountry"] ] 
					 				: "").
					 			'</span>';
					echo $address;
					?>

					<?php if( $edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ) { ?>
						<a href='javascript:removeAddresses("<?php echo $ix ; ?>");'  class="addresses pull-right tooltips margin-right-15" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Remove Locality");?>"><i class="fa text-red fa-trash-o"></i></a>
						<a href='javascript:updateLocalityEntities("<?php echo $ix ; ?>", <?php echo json_encode($p);?>);' class=" pull-right pull-right tooltips margin-right-15" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Update Locality");?>"><i class="fa text-red fa-map-marker addresses"></i></a></span>
					<?php } ?>
				</span>
				<hr/>
			<?php 	} ?>
			</div>
		<?php } ?>
		<div class="text-right padding-10">
			<?php if(empty($element["address"]) && $type!=Person::COLLECTION && ($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) )){ ?>
				<b><a href="javascript:;" class="btn btn-default letter-blue margin-top-5 addresses btn-update-geopos">
					<i class="fa fa-map-marker"></i>
					<span class="hidden-sm"><?php echo Yii::t("common","Add a primary address") ; ?></span>
				</a></b>
			<?php	}
			if($type!=Person::COLLECTION && !empty($element["address"]) && ($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) )) { ?>
				<b><a href='javascript:updateLocalityEntities("<?php echo count(@$element["addresses"]) ; ?>");' id="btn-add-geopos" class="btn btn-default letter-blue margin-top-5 addresses" style="margin: 10px 0px;">
					<i class="fa fa-plus" style="margin:0px !important;"></i> 
					<span class="hidden-sm"><?php echo Yii::t("common","Add an address"); ?></span>
				</a></b>
			<?php } ?>						
		</div>
	</div>

	<?php

	if($type!=Poi::COLLECTION){ 
		$skype = (!empty($element["socialNetwork"]["skype"])? $element["socialNetwork"]["skype"]:"javascript:;") ;
		$telegram =  (!empty($element["socialNetwork"]["telegram"])? "https://web.telegram.org/#/im?p=@".$element["socialNetwork"]["telegram"]:"javascript:;") ;
		$facebook = (!empty($element["socialNetwork"]["facebook"])? $element["socialNetwork"]["facebook"]:"javascript:;") ;
		$twitter =  (!empty($element["socialNetwork"]["twitter"])? $element["socialNetwork"]["twitter"]:"javascript:;") ;
		$googleplus =  (!empty($element["socialNetwork"]["googleplus"])? $element["socialNetwork"]["googleplus"]:"javascript:;") ;
		$github =  (!empty($element["socialNetwork"]["github"])? $element["socialNetwork"]["github"]:"javascript:;") ;
		$instagram =  (!empty($element["socialNetwork"]["instagram"])? $element["socialNetwork"]["instagram"]:"javascript:;") ;
	?>
	<div id="socialAbout" class="panel panel-white col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding shadow2">
		<div class="panel-heading border-light col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #dee2e680;">
			<h4 class="panel-title text-dark pull-left"> 
				<i class="fa fa-connectdevelop"></i> <?php echo Yii::t("common","Socials"); ?>
			</h4>
			<?php if($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ) {?>
				<button class="btn-update-network btn btn-default letter-blue pull-right tooltips" 
					data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Update network") ?>">
					<b><i class="fa fa-pencil"></i></b>
				</button>
			<?php } ?>
		</div>
		<div class="panel-body no-padding">
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation social padding-10 tooltips" data-toggle="tooltip" data-placement="left" title="Facebook">
				<span><i class="fa fa-facebook"></i></span> 
				<?php if ($facebook != "javascript:;"){ ?>
					<a href="<?php echo $facebook ; ?>" target="_blank" id="facebookAbout" class="socialIcon "><?php echo  $facebook ; ?></a>
				<?php } else { 
					echo '<i>'.Yii::t("common","Not specified").'</i>' ; 
				} ?>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation social padding-10 tooltips" data-toggle="tooltip" data-placement="left" title="Twitter">
				<span><i class="fa fa-twitter"></i></span> 
				<?php if ($twitter != "javascript:;"){ ?>
					<a href="<?php echo $twitter ; ?>" target="_blank" id="twitterAbout" class="socialIcon" ><?php echo $twitter ; ?></a>
				<?php } else { 
					echo '<i>'.Yii::t("common","Not specified").'</i>' ; 
				} ?>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation social padding-10 tooltips" data-toggle="tooltip" data-placement="left" title="Instagram">
				<span><i class="fa fa-instagram"></i></span> 
				<?php if ($instagram != "javascript:;"){ ?>
					<a href="<?php echo $instagram ; ?>" target="_blank" id="instagramAbout" class="socialIcon" ><?php echo $instagram ; ?></a>
				<?php } else { 
					echo '<i>'.Yii::t("common","Not specified").'</i>' ; 
				} ?>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation social padding-10 tooltips" data-toggle="tooltip" data-placement="left" title="Skype" >
				<span><i class="fa fa-skype"></i></span> 
				<?php if ($skype != "javascript:;"){ ?>
					<a href="<?php echo $skype ; ?>" target="_blank" id="skypeAbout" class="socialIcon" ><?php echo $skype ; ?></a>
				<?php } else { 
					echo '<i>'.Yii::t("common","Not specified").'</i>' ; 
				} ?>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation social padding-10 tooltips" data-toggle="tooltip" data-placement="left" title="Google Plus">
				<span><i class="fa fa-google-plus"></i></span> 
				<?php if ($googleplus != "javascript:;"){ ?>
					<a href="<?php echo $googleplus ; ?>" target="_blank" id="gpplusAbout" class="socialIcon" ><?php echo $googleplus ; ?></a>
				<?php } else { 
					echo '<i>'.Yii::t("common","Not specified").'</i>' ; 
				} ?>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation social padding-10 tooltips" data-toggle="tooltip" data-placement="left" title="GitHub">
				<span><i class="fa fa-github"></i></span> 
				<?php if ($github != "javascript:;"){ ?>
					<a href="<?php echo $github ; ?>" target="_blank" id="githubAbout" class="socialIcon" ><?php echo $github  ; ?></a>
				<?php } else { 
					echo '<i>'.Yii::t("common","Not specified").'</i>' ; 
				} ?>
			</div>
			<?php if($type==Person::COLLECTION){ ?> 
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation social padding-10 tooltips" data-toggle="tooltip" data-placement="left" title="Telegram">
				<span><i class="fa fa-telegram"></i></span> 
				<?php if ($telegram != "javascript:;"){ ?>
					<a href="<?php echo $telegram ; ?>" target="_blank" id="telegramAbout" class="socialIcon" ><?php echo $telegram ; ?></a>
				<?php } else { 
					echo '<i>'.Yii::t("common","Not specified").'</i>' ; 
				} ?>
			</div>
			<?php } ?>
		</div>	
    </div> 
    <?php } ?> 
</div>

<?php $this->renderPartial('../pod/whycommunexion',array()); ?>

<script type="text/javascript">

	var formatDateView = "DD MMMM YYYY à HH:mm" ;
	var formatDatedynForm = "DD/MM/YYYY HH:mm" ;
	/*if( (typeof contextData.allDay != "undefined" && contextData.allDay == true) || contextData.type == "<?php //echo Project::COLLECTION; ?>" ) {
		formatDateView = "DD MMMM YYYY" ;
		formatDatedynForm = "DD/MM/YYYY" ;
	}*/

	jQuery(document).ready(function() {
		bindDynFormEditable();
		initDate();
		inintDescs();
		//changeHiddenFields();
		bindAboutPodElement();
		bindExplainLinks();

		$("#small_profil").html($("#menu-name").html());
		$("#menu-name").html("");

		$(".cobtn").click(function () {
			communecterUser();				
		});

		$(".btn-update-geopos").click(function(){
			updateLocalityEntities();
		});

		$("#btn-add-geopos").click(function(){
			updateLocalityEntities();
		});

		$("#btn-update-organizer").click(function(){
			updateOrganizer();
		});
		$("#btn-add-organizer").click(function(){
			updateOrganizer();
		});

		$("#btn-remove-geopos").click(function(){
			removeAddress();	
		});

		$("#btn-update-geopos-admin").click(function(){
			findGeoPosByAddress();
		});

		//console.log("contextDatacontextData", contextData, contextData.type,contextData.id);
		//buildQRCode(contextData.type,contextData.id.$id);		
		
	});

	function initDate() {//DD/mm/YYYY hh:mm
		//moment.locale('fr');
		if( (typeof contextData.allDay != "undefined" && contextData.allDay == true) || contextData.type == "<?php echo Project::COLLECTION; ?>" ) {
			formatDateView = "DD MMMM YYYY" ;
			formatDatedynForm = "DD/MM/YYYY" ;
		}else{
			formatDateView = "DD MMMM YYYY à HH:mm" ;
			formatDatedynForm = "DD/MM/YYYY HH:mm" ;
		}

		if( typeof contextData.startDate != "undefined" && contextData.startDate != "" ){
			$("#divStartDate").removeClass("hidden");
			$("#divNoDate").addClass("hidden");
		}
		else{
			$("#divStartDate").addClass("hidden");
			$("#divNoDate").removeClass("hidden");
		}

		if( typeof contextData.endDate != "undefined" && contextData.endDate != "" )
			$("#divEndDate").removeClass("hidden");
		else
			$("#divEndDate").addClass("hidden");
		mylog.log("formatDateView", formatDateView);
		if($("#startDateAbout").html() != "")
	    	$("#startDateAbout").html(moment(contextData.startDateDB).local().locale(mainLanguage).format(formatDateView));
	    if($("#endDateAbout").html() != "")
	    	$("#endDateAbout").html(moment( contextData.endDateDB).local().locale(mainLanguage).format(formatDateView));

	    if($("#birthDate").html() != "")
	    	$("#birthDate").html(moment($("#birthDate").html()).local().locale(mainLanguage).format("DD/MM/YYYY"));
	    $('#dateTimezone').attr('data-original-title', "Fuseau horaire : GMT " + moment().local().format("Z"));
	}

	

	

</script>