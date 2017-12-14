<?php 
	$cssAnsScriptFilesTheme = array(
		//X-editable
		//'/plugins/x-editable/css/bootstrap-editable.css',
		//'/plugins/x-editable/js/bootstrap-editable.js' , 

		//DatePicker
		'/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js' ,
		'/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js' ,
		'/plugins/bootstrap-datepicker/css/datepicker.css',
		
		//DateTime Picker
		'/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
		'/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js' , 
		'/plugins/bootstrap-datetimepicker/css/datetimepicker.css',
		//Wysihtml5
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5.css',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5-editor.css',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/wysihtml5x-toolbar.min.js',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5.min.js',
		'/plugins/wysihtml5/wysihtml5.js',
		
		//SELECT2
		'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
		'/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js' ,

		// SHOWDOWN
		'/plugins/showdown/showdown.min.js',
		//MARKDOWN
		'/plugins/to-markdown/to-markdown.js',

	);
	//if ($type == Project::COLLECTION)
	//	array_push($cssAnsScriptFilesTheme, "/assets/plugins/Chart.js/Chart.min.js");
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
	$cssAnsScriptFilesModule = array(
		//Data helper
		'/js/dataHelpers.js',
		'/js/postalCode.js',
		'/js/activityHistory.js',
		'/js/news/index.js',
		'/js/default/editInPlace.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';
	$thumbAuthor =  @$element['profilThumbImageUrl'] ? 
                      Yii::app()->createUrl('/'.@$element['profilThumbImageUrl']) 
                      : "";
?>
<style>
	.img-thumb{
		height: 50px;
		width: 50px;
	}

	.podInside .panel-heading,
	.podInside .panel-tools{
		display:none;
	}
	.podInside .panel,
	.podInside .table{
		margin-bottom: 0px;
		border: 0px;
	}

	.podInside.collections a{
		font-size: 15px;
		font-weight: 700;
		padding:10px;
		display: inline-block;
	}

	.podchart .panel-heading{
		background-color: white !important;
	}

	.favElBtn{
		/*color: #FC4D4D !important;*/
		/*padding: 6px;
		margin-bottom: 4px;*/
	}

	.editBtn{
		float: right;
	}
	
</style>
<div id="menu-name" class="hidden">
	<img src="<?php echo $thumbAuthor; ?>" height="45" class="img-circle">
	<span class="font-montserrat hidden-sm hidden-xs"><?php echo @$element["name"]; ?></span>
</div>

<ul id="accordion" class="accordion shadow2">
		    <li>
				<div class="iamgurdeep-pic">
					<?php if(@$element["profilMediumImageUrl"] && !empty($element["profilMediumImageUrl"]))
					$images=$element["profilMediumImageUrl"];
				else 
					$images="";	
					$this->renderPartial('../pod/fileupload', array(  "itemId" => (string) $element["_id"],
																  "type" => $type,
																  "resize" => false,
																  "contentId" => Document::IMG_PROFIL,
																  "show" => true,
																  "editMode" => $edit,
																  "image" => $images,
																  "openEdition" => $openEdition) ); 
																  ?>
					<!--<img class="img-responsive" alt="" 
						 src="<?php echo @$element['profilMediumImageUrl'] ? 
						 		Yii::app()->createUrl('/'.@$element['profilMediumImageUrl']) : $imgDefault; ?>">-->
					<div class="edit-pic">
						<a href="https://web.facebook.com/" target="_blank" class="fa fa-facebook"></a>
						<a href="https://www.instagram.com/gurdeeposahan/" target="_blank" class="fa fa-instagram"></a>
						<a href="https://twitter.com/gurdeeposahan1" target="_blank" class="fa fa-twitter"></a>
						<a href="https://plus.google.com/u/0/105032594920038016998" target="_blank" class="fa fa-google"></a>
					</div>
					<?php if(@Yii::app()->session["userId"]){ ?>
					<div class="blockUsername">
					    <!--<h2 class="text-left">
						    <?php //echo @$element["name"]; ?><!-- <br>
						    <small>
						    	<?php if(@$element["address"] && @$element["address"]["addressLocality"]) {
		                				echo "<i class='fa fa-university'></i> ".$element["address"]["addressLocality"];
		                				if(@$element["address"]["postalCode"]) echo ", ";
		                			  }
		                			  if(@$element["address"] && @$element["address"]["postalCode"]) 
		                			  	echo $element["address"]["postalCode"];
		                		?>
		                	</small>
	                	</h2>-->
	                	<?php $this->renderPartial('../element/linksMenu', 
	                			array("linksBtn"=>$linksBtn,
	                					"elementId"=>(string)$element["_id"],
	                					"elementType"=>$type,
	                					"elementName"=> $element["name"]) 
	                			); 
	                	?>
					    <!-- <p><i class="fa fa-briefcase"></i> Web Design and Development.</p> -->
					</div>
					<?php } ?>
				    
				</div>
		        
		    </li>
			<li>
				<div class="link">
					<i class="fa fa-globe"></i><?php echo Yii::t("common","About"); ?><i class="fa fa-chevron-down"></i>
					<?php if($edit==true || $openEdition==true ){?>
						<a href="javascript:;" class="tooltips btn-update-info" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Update Contact information");?>"><i class="fa text-red fa-pencil"></i></a>
					<?php } ?>
				</div>
				<ul class="submenu">
				<!--
					<?php //if(@$edit==true){ ?>
							<li class="tooltips " data-edit-id="name">
								<i class="fa fa-user-circle-o"></i> <?php //echo Yii::t("common","Name"); ?> : 
								<span id="name" class=""><?php //if(isset($element["name"])) echo $element["name"]; else echo ""; ?></span>
							</li>
					<?php //} ?>
				-->
					<?php if($type==Person::COLLECTION){ ?>
							<li class="tooltips hidden username" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Username"); ?>">
								<i class="fa fa-user-secret"></i>
								<span id="usernameMenuLeft" class=""><?php if(isset($element["username"])) echo $element["username"]; else echo ""; ?></span>
							</li>
					<?php } ?>

					<?php if($type==Person::COLLECTION){
						if(Preference::showPreference($element, $type, "birthDate", Yii::app()->session["userId"])){ ?>
							<li class="hidden birthDate" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("person","Birth date"); ?>">
								<i class="fa fa-birthday-cake"></i><?php echo Yii::t("person","Birth date"); ?> : 
								<span id="birthDateMenuLeft" class=""><?php echo (isset($element["birthDate"])) ? date("d/m/Y", strtotime($element["birthDate"]))  : null; ?></span>
							</li>
						<?php }
					} ?>

					<?php if($type==Project::COLLECTION && isset($element["properties"]["avancement"]) ){ ?>
						<li class="tooltips hidden avancement"  data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("project","Project maturity",null,Yii::app()->controller->module->id); ?>">
							<span id="avancementMenuLeft"> <?php echo Yii::t("project","Project maturity",null,Yii::app()->controller->module->id)." : ".Yii::t("project",$element["properties"]["avancement"],null,Yii::app()->controller->module->id); ?></span>
						</li>
					<?php } ?>

					<?php if( 	( 	$type==Person::COLLECTION && 
									Preference::showPreference($element, $type, "email", Yii::app()->session["userId"]) ) || 
							  	(	$type!=Person::COLLECTION && $type!=Event::COLLECTION ) ){ ?>
								<li class="tooltips hidden email" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","E-mail"); ?>">
									<i class="fa fa-envelope"></i>
									<span id="emailMenuLeft" class=""><?php echo (isset($element["email"])) ? $element["email"] : ""; ?></span>
								</li>
					<?php } ?>
					
					<?php //If there is no http:// in the url
					$scheme = "";
					if(isset($element["url"])){
						if (!preg_match("~^(?:f|ht)tps?://~i", $element["url"])) $scheme = 'http://';

					}?>

					<li class="tooltips url hidden" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Website URL") ?>">
						<i class="fa fa-desktop"></i>
						<span>
							<a href="<?php echo (isset($element["url"])) ? $scheme.$element['url'] : 'javascript:;'; ?>" target="_blank" id="urlMenuLeft" style="cursor:pointer;">
								<?php echo (isset($element["url"])) ? $element["url"] : ""; ?>
							</a>
						</span>
					</li>


					<?php  if($type==Organization::COLLECTION || $type==Person::COLLECTION){ ?>
								<li class="tooltips fixe hidden" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Phone") ?>">
									<i class="fa fa-phone"></i>
									<span id="fixe">
										<?php
											if( !empty($element["telephone"]["fixe"])){
												$fixe = "";
												foreach ($element["telephone"]["fixe"] as $key => $num) {
													$fixe .= ($fixe != "") ? ", ".trim($num) : trim($num);
												}
												echo $fixe;
											}	
										?>
									</span>
								</li>
								<li class="tooltips mobile hidden" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Mobile") ?>">
									<i class="fa fa-mobile"></i>
									<span id="mobile">
										<?php
											if( !empty($element["telephone"]["mobile"])){
												$mobile = "";
												foreach ($element["telephone"]["mobile"] as $key => $num) {
													$mobile .= ($mobile != "") ? ", ".trim($num) : trim($num);
												}
												echo $mobile;
											}	
										?>
									</span>
								</li>
								<li class="tooltips fax hidden" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Fax") ?>">
									<i class="fa fa-fax"></i>
									<span id="fax">
										<?php
											if( !empty($element["telephone"]["fax"])){
												$fax = "";
												foreach ($element["telephone"]["fax"] as $key => $num) {
													$fax .= ($fax != "") ? ", ".trim($num) : trim($num);
												}
												echo $fax;
											}	
										?>
									</span>
								</li>
					<?php } ?>
				</ul>
			</li>

			<?php 
				$skype = (!empty($element["socialNetwork"]["skype"])? $element["socialNetwork"]["skype"]:"javascript:;") ;
				$telegram =  (!empty($element["socialNetwork"]["telegram"])? "https://web.telegram.org/#/im?p=@".$element["socialNetwork"]["telegram"]:"javascript:;") ;
				$facebook = (!empty($element["socialNetwork"]["facebook"])? $element["socialNetwork"]["facebook"]:"javascript:;") ;
				$twitter =  (!empty($element["socialNetwork"]["twitter"])? $element["socialNetwork"]["twitter"]:"javascript:;") ;
				$googleplus =  (!empty($element["socialNetwork"]["googleplus"])? $element["socialNetwork"]["googleplus"]:"javascript:;") ;
				$gitHub =  (!empty($element["socialNetwork"]["github"])? $element["socialNetwork"]["github"]:"javascript:;") ;
			?>

			
			<li class="blockSocial">
				<div class="link">
					<i class="fa fa-map-marker"></i>Social<i class="fa fa-chevron-down"></i>
					<?php if($edit==true || $openEdition==true ){?>
						<a href="javascript:;" class="tooltips btn-update-network" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Update Contact information");?>"><i class="fa text-red fa-pencil"></i></a>
					<?php } ?>
				</div>
				<ul class="submenu">
					<li class="tooltips telegram hidden" data-toggle="tooltip" data-placement="right" title="Telegram">
						<span class="titleField text-dark"><i class="fa fa-telegram fa-lg"></i></i> 
							<a href="<?php echo $telegram ; ?>" id="telegramMenuLeft" class="socialIcon"><?php echo ($telegram != "javascript:;") ? $telegram : "" ; ?></a>
						</span>
					</li>
					<li class="tooltips skype hidden" data-toggle="tooltip" data-placement="right" title="Skype">
						<span class="titleField text-dark"><i class="fa fa-skype fa-lg"></i> 
							<a href="<?php echo $skype ; ?>" id="skypeMenuLeft" class="socialIcon"><?php echo ($skype != "javascript:;") ? $skype : "" ; ?></a>
						</span>
					</li>
					<li class="tooltips facebook hidden" data-toggle="tooltip" data-placement="right" title="Facebook">
						<span class="titleField text-dark"><i class="fa fa-facebook fa-lg"></i> 
							<a href="<?php echo $facebook ; ?>" target="_blank" id="facebookMenuLeft" class="socialIcon"><?php echo ($facebook != "javascript:;") ? $facebook : "" ; ?></a>
						</span>
					</li>
					<li class="tooltips twitter hidden" data-toggle="tooltip" data-placement="right" title="Twitter">
						<span class="titleField text-dark"><i class="fa fa-twitter fa-lg"></i>
							<a href="<?php echo $twitter ;?>" target="_blank" id="twitterMenuLeft" class="socialIcon tooltips" data-toggle="tooltip" data-placement="bottom" title="Twitter"><?php echo ($twitter != "javascript:;") ? $twitter : "" ; ?></a>
						</span>
					</li>
					<li class="tooltips gpplus hidden" data-toggle="tooltip" data-placement="right" title="Google Plus">
						<span class="titleField text-dark"><i class="fa fa-google-plus fa-lg"></i> 
							<a href="<?php echo $googleplus ;?>" target="_blank" id="gpplusMenuLeft" class="socialIcon"><?php echo ($googleplus != "javascript:;") ? $googleplus : "" ; ?></a>
						</span>
					</li>
					<li class="tooltips gitHub hidden" data-toggle="tooltip" data-placement="right" title="Git Hub">
						<span class="titleField text-dark"><i class="fa fa-github fa-lg"></i> 
							<a href="<?php echo $gitHub ;?>" target="_blank" id="gitHubMenuLeft" class="socialIcon"><?php echo ($gitHub != "javascript:;") ? $gitHub : "" ; ?></a>
						</span>
					</li>
				</ul>
			</li>
			<li>
				<div class="link"><i class="fa fa-map-marker"></i>Description<i class="fa fa-chevron-down"></i>
					<?php if($edit==true || $openEdition==true ){?>
		  				<a href='javascript:;' class="tooltips btn-update-desc" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Update Description");?>"><i class="fa text-red fa-pencil"></i></a> <?php } ?>
		  		</div>
				<ul class="submenu">
					<li>
						<span id="description"  class=""><?php  echo (!empty($element["description"])) ? $element["description"] : ""; ?></span>
						<input type="hidden" id="descriptionMarkdown" name="descriptionMarkdown" value="<?php echo (!empty($element['description'])) ? $element['description'] : ''; ?>">	
						<div class="text-right padding-10">
							<button class="btn btn-default letter-blue open-description margin-top-5">
						    	<b><i class="fa fa-connectdevelop"></i> En lire plus <i class="fa fa-chevron-right"></i></b>
							</button>
						</div>	
					</li>
				</ul>
			</li>
			<li>
				<div class="link">
					<i class="fa fa-map-marker"></i><?php echo Yii::t("common","Localitie(s)"); ?><i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<li>	
						<?php 
							if( ($type == Person::COLLECTION && Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"])) ||  $type!=Person::COLLECTION) {
						?>
							<span>
								<?php
									if(! empty($element["address"])) 
										echo '<i class="fa fa-home"></i>' ;
									$address = "";
									$address .= '<span id="detailStreetAddress"> '.
													(( @$element["address"]["streetAddress"]) ? 
														$element["address"]["streetAddress"]."<br/>": 
														((@$element["address"]["codeInsee"])?"":Yii::t("common","Unknown Locality"))).
												'</span>';
									$address .= '<span id="detailCity">'.
													(( @$element["address"]["postalCode"]) ?
													 $element["address"]["postalCode"].", " :
													 "")
													." ".(( @$element["address"]["addressLocality"]) ? 
															 $element["address"]["addressLocality"] : "")
												.'</span>';
									$address .= '<span id="detailCountry">'.
													(( @$element["address"]["addressCountry"]) ?
													 ", ".OpenData::$phCountries[ $element["address"]["addressCountry"] ] 
									 				: "").
									 			'</span>';
									echo $address;
								
						
									if(empty($element["address"]["codeInsee"]) && $type==Person::COLLECTION && 
										($edit==true || $openEdition==true )) {
										echo '<br/><a href="javascript:;" class="cobtn btn btn-danger btn-sm" style="margin: 10px 0px;">'.Yii::t("common", "Connect to your city")./*'</a> <a href="javascript:;" class="whycobtn btn btn-default btn-sm explainLink" style="margin: 10px 0px;" data-id="explainCommunectMe" >'. Yii::t("common", "Why ?").*/'</a>';
									}else{
										echo '<a href="javascript:;" id="btn-remove-geopos" class="pull-right tooltips" data-toggle="tooltip" data-placement="bottom" title="'.Yii::t("common","Remove Locality").'">
													<i class="fa text-red fa-trash-o"></i>
												</a>
												<a href="javascript:;" id="btn-update-geopos" class="pull-right tooltips" data-toggle="tooltip" data-placement="bottom" title="'.Yii::t("common","Update Locality").'" >
													<i class="fa text-red fa-map-marker"></i>
												</a> ';	
									}
								?>
							</span>
						<?php } ?>
					</li>



					<?php
						if( !empty($element["addresses"]) ){ 
							foreach ($element["addresses"] as $ix => $p) { ?>
								
								<li id="addresses_<?php echo $ix ; ?>">
									<span>
									<?php 
									$address = '<i class="fa fa-circle"></i> <span id="detailStreetAddress_'.$ix.'">'.(( @$p["address"]["streetAddress"]) ? $p["address"]["streetAddress"]."<br/>" : "").'</span>';
									$address .= '<span id="detailCity">'.(( @$p["address"]["postalCode"]) ? $p["address"]["postalCode"] : "")." ".(( @$p["address"]["addressLocality"]) ? $p["address"]["addressLocality"] : "").'</span>';
									$address .= '<span id="detailCountry_'.$ix.'">'.(( @$p["address"]["addressCountry"]) ? " ".OpenData::$phCountries[ $p["address"]["addressCountry"] ] : "").'</span>';
									echo $address;
									?>

									<a href='javascript:removeAddresses("<?php echo $ix ; ?>");'  class="addresses pull-right hidden tooltips" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Remove Locality");?>"><i class="fa text-red fa-trash-o"></i></a>
									<a href='javascript:updateLocalityEntities("<?php echo $ix ; ?>", <?php echo json_encode($p);?>);' class=" pull-right tooltips" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Update Locality");?>"><i class="fa text-red fa-map-marker hidden addresses"></i></a></span>
								</li>
					<?php 	} 
					} ?>

					<div class="text-right padding-10">
						<?php if(empty($element["address"]) && $type!=Person::COLLECTION && ($edit==true || $openEdition==true )){ ?>
							<b><a href="javascript:;" class="btn btn-default letter-blue margin-top-5 addresses" id="btn-update-geopos">
										<i class="fa fa-map-marker"></i>
										<span class="hidden-sm"><?php echo Yii::t("common","Add a primary address") ; ?></span>
									</a></b>
						<?php	}  

						if($type!=Person::COLLECTION && !empty($element["address"]) && ($edit==true || $openEdition==true )) { ?>
							<li>
								<b>
								<a href='javascript:updateLocalityEntities("<?php echo count(@$element["addresses"]) ; ?>");' id="btn-add-geopos" class="btn btn-default letter-blue margin-top-5 addresses" style="margin: 10px 0px;">
									<i class="fa fa-plus" style="margin:0px !important;"></i> 
									<span class="hidden-sm"><?php echo Yii::t("common","Add a secondary address"); ?></span>
								</a>
								</b>
							</li>
						<?php } ?>						
					</div>
				</ul>
			</li>
			<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION){ ?>
			<li class="podInside">
				<?php $countCharts=0;
						if(@$element["properties"] && @$element["properties"]["chart"]) 
							$countCharts=count($element["properties"]["chart"]) 
				?>
				<div class="link"><i class="fa fa-puzzle-piece"></i><?php echo Yii::t("chart", "Values and Cultures") ?> 
					<?php if($countCharts > 0) echo "(".$countCharts.")"; ?> 
					<i class="fa fa-chevron-down"></i>
				</div>

				<ul class="submenu">
					<div class="panel panel-white">		
					<?php if($countCharts==0){ ?>				
							<div id="infoPodChart" class="padding-10 <?php if(!empty($properties)) echo "hide" ?>">
								<blockquote> 
									<?php echo Yii::t("chart","Create Chart<br/>Opening<br/>Values<br/>Governance<br/>To explain the aim and draw project conduct") ?>
								</blockquote>
							</div>
					<?php }else{
						foreach($element["properties"]["chart"] as $key => $data){
							if($key=="commons") $title=Yii::t("chart","Chart of commons");
							else $title=Yii::t("chart","Open chart");
						?>
							<li>
								<div class="subLink btn-start-chart" data-value="<?php echo $key ?>">
								<?php echo $title; ?>
								<i class="fa fa-chevron-right pull-right letter-blue"></i>
								</div>
							</li>
						<?php }
					} ?>
					</div>
					<div class="text-right padding-10">
					<?php if (($edit || $openEdition) && @Yii::app()->session["userId"]){	?>
						<button class="edit-chart btn btn-default letter-blue margin-top-5 tooltips" 
							data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("chart","Edit properties") ?>">
							<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
						</button>
					<?php } ?>
					</div>
					</ul>
					<?php
					/*if(empty($element["properties"]["chart"])) $element["properties"]["chart"] = array();
					$this->renderPartial('../chart/index',array(
											"itemId" => (string)$element["_id"], 
											"itemName" => $element["name"], 
											"parentType" => $type, 
											"properties" => $element["properties"]["chart"],
											"admin" =>$edit,
											"isDetailView" => 1,
											"openEdition" => $openEdition));*/
					?>
				</ul>
			</li>
		<?php } ?>
		</ul>

		<ul id="accordion4" class="accordion shadow2 margin-top-20">

			<!-- COMMUNAUTÉ -->
			<?php //if($type != Person::COLLECTION){ ?>
			<li class="podInside community">
				<div class="link">
					<i class="fa fa-connectdevelop"></i> Communauté 
					<small>(<?php echo @$members ? count($members) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
		 			<?php $this->renderPartial('../pod/usersList', array(  $controller => $element,
														"users" => @$members,
														"userCategory" => Yii::t("common","Community"), 
														"contentType" => $type,
														"countStrongLinks" => $countStrongLinks,
														"countLowLinks" => $countLowLinks,
														"countInvitations" => $countInvitations,
														"admin" => $edit, 
														"invitedMe" => @$invitedMe,
														"openEdition" => $openEdition)); ?>
					<div class="text-right padding-10">

						<?php if(@$edit==true && $type!=Person::COLLECTION) { ?>
						<button data-toggle="modal" data-target="#modal-scope"
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Ajouter un membre</b>
						</button> 
						<?php } ?>

						<button class="btn btn-default letter-blue open-directory margin-top-5">
					    	<b><i class="fa fa-connectdevelop"></i> Afficher la communauté <i class="fa fa-chevron-right"></i></b>
						</button>
						
					</div>	
				</ul>			
			</li>
			<?php //} ?>
		</ul>
		
		<button id="exportCSV" class="btn btn-default letter-blue margin-top-5">
		Exporter en format CSV
		</button>

		<ul id="accordion2" class="accordion shadow2 margin-top-20">
		
			<!-- CONTACTS -->
			<?php if (($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION)){ ?>
			<li class="podInside">
				<div class="link">
					<i class="fa fa-user-circle"></i> Nous contacter
					<small>(<?php echo @$element["contacts"] ? count($element["contacts"]) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php 
					$contacts = ( empty($element["contacts"]) ? array() : $element["contacts"] ) ;
					$this->renderPartial('../pod/contactsList',array( 	"contacts" => @$contacts, 
																		"contextId" => (String) $element["_id"],
																		"contextType" => $controller,
																		"authorised" => $edit,
																		"openEdition" => $openEdition
																	  ));
					?>
					<div class="text-right padding-10">
						<?php if(@$edit==true) { ?>
						<button onclick="elementLib.openForm ( 'contactPoint','contact')" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Ajouter un contact </b>
						</button>
						<?php } ?>
					</div>
				</ul>
			</li>
			<?php } ?>

			<!-- COLLECTION -->
			<?php if ($type==Person::COLLECTION){ ?>
			<li class="podInside collections">
				<div class="link">
					<i class="fa fa-star"></i> Collections 
					<small>(<?php echo @$element["collections"] ? count($element["collections"]) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php $this->renderPartial('../pod/collections',array( 	"collections" => @$element["collections"] )); ?>
					<?php if(@$edit==true) { ?>
					<div class="text-right padding-10">
						<button onclick="collection.crud()" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Créer une collection </b>
						</button>
					</div>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>

			<!-- BESOINS -->
			<?php if( $type!=Event::COLLECTION && ( !@$front || (@$front && $front["need"]==true))){ ?>
	    	<li class="podInside needs">
				<div class="link">
					<i class="fa fa-cubes"></i> <?php if( $type!=Person::COLLECTION){ ?>Nos<?php }else{ ?>Mes<?php } ?> besoins 
					<small>(<?php echo @$needs ? count($needs) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php $this->renderPartial('../pod/needsList',array("needs" => @$needs, 
																		"parentId" => (String) $element["_id"],
																		"parentType" => $type,
																		"isAdmin" => @$edit,
																		"parentName" => $element["name"],
																		"openEdition" => $openEdition
																	  )); ?>
					<div class="text-right padding-10">
						<?php if(@$edit==true) { ?>
						<button onclick="" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Créer un besoin </b>
						</button>
						<?php } ?>
					</div>
				</ul>
			</li>
			<?php } ?>

		</ul>


		<ul id="accordion3" class="accordion shadow2 margin-top-20">
				
			<!-- PROJETS -->
			<?php if ($type==Organization::COLLECTION){ 
				if(!@$front || (@$front && $front["project"])){ 
			?>
			<li class="podInside events">
				<div class="link">
					<i class="fa fa-lightbulb-o"></i> Projets 
					<small>(<?php echo @$projects ? count($projects) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
		 			<?php $this->renderPartial('../pod/projectsList',array( "projects" => @$projects, 
															"contextId" => (String) $element["_id"],
															"contextType" => $type,
															"authorised" =>	$edit,
															"openEdition" => $openEdition
					)); ?>
					<div class="text-right padding-10">
						<?php if(@$edit==true || ($openEdition==true && @Yii::app()->session["userId"])) { ?>
						<button onclick="elementLib.openForm('project','sub')" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Nouveau projet</b>
						</button> 
						<?php } ?>
						<button class="btn btn-default letter-blue open-directory margin-top-5">
					    	<i class="fa fa-chevron-right"></i>
						</button>
						
					</div>	
				</ul>			
			</li>
			<?php }} ?>


			<!-- ÉVÉNEMENTS -->
			<?php if (($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION)){ ?>
	    		<?php if(!@$front || (@$front && $front["event"]==true)){ ?>
					<?php 
						$organizerImg=false;
						if($type==Event::COLLECTION){ 
							$organizerImg=true;
							if(empty($subEvents)) $subEvents = array();
							$events=$subEvents;
						}
						if(!isset($eventTypes)) $eventTypes = array();
						if(empty($subEvents)) $subEvents = array();
					?>
					<li class="podInside events">
					
						<div class="link">
							<i class="fa fa-calendar"></i> Événements 
							<small>(<?php echo @$events ? count($events) : "0"; ?>)</small>
							<i class="fa fa-chevron-down"></i>
						</div>
						<ul class="submenu">
							<?php	$this->renderPartial('../pod/eventsList',array( 	"events" => @$events, 
																						"contextId" => (String) $element["_id"],
																						"contextType" => $controller,
																						"list" => $eventTypes,
																						"authorised" => $edit,
																						"organiserImgs"=> $organizerImg,
																						"openEdition" => $openEdition
																					  ));
							?>
							<div class="text-right padding-10">
								<?php if(@$edit==true || ($openEdition==true && @Yii::app()->session["userId"])) { ?>
								<button onclick="elementLib.openForm('event','subEvent')" 
										class="btn btn-default letter-blue margin-top-5">
							    	<b><i class="fa fa-plus"></i> Nouvel événement</b>
								</button> 
								<?php } ?>
								<button class="btn btn-default letter-blue open-directory margin-top-5" 
								data-toggle="tooltip" data-placement="right" title="Afficher tout">
							    	<i class="fa fa-chevron-right"></i>
								</button>
								
							</div>	
						</ul>			  
					</li>
				<?php } ?>
			<?php } ?>


			<?php /*$this->renderPartial('../pod/ficheInfoPodThumb', array("list"=>@$events, 
																		 "title"=>"Événements", 
																		 "icon"=>"calendar",
																		 "thumbOnly"=>true) );*/ ?>


			<?php /*$this->renderPartial('../pod/ficheInfoPodThumb', array("list"=>@$needs, 
																		 "title"=>"Besoins", 
																		 "icon"=>"cubes") ); */?>

		</ul>


<?php 
	//$element["type"] = $type;
	//$element["id"] = (string)$element["_id"];
	$emptyAddress = (empty($element["address"]["codeInsee"])?true:false);
	$showOdesc = true ;
	if(Person::COLLECTION == $type){
		$showLocality = (Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"])?true:false);
		$showOdesc = ((Preference::isOpenData($element["preferences"]) && Preference::isPublic($element, "locality"))?true:false);	
	}
	$odesc = "" ;
	if($showOdesc == true){
		$controller = Element::getControlerByCollection($type) ;
		if($type == Person::COLLECTION)
			$odesc = $controller." : ".addslashes( strip_tags(json_encode(@$element["shortDescription"]))).",".addslashes(json_encode(@$element["address"]["streetAddress"])).",".@$element["address"]["postalCode"].",".@$element["address"]["addressLocality"].",".@$element["address"]["addressCountry"] ;
		else if($type == Organization::COLLECTION)
			$odesc = $controller." : ".@$element["type"].", ".addslashes( strip_tags(json_encode(@$element["shortDescription"]))).",".addslashes(json_encode(@$element["address"]["streetAddress"])).",".@$element["address"]["postalCode"].",".@$element["address"]["addressLocality"].",".@$element["address"]["addressCountry"];
		else if($type == Event::COLLECTION)
			$odesc = $controller." : ".@$element["startDate"].",".@$element["endDate"].",".addslashes(json_encode(@$element["address"]["streetAddress"])).",".@$element["address"]["postalCode"].",". @$element["address"]["addressLocality"].",".@$element["address"]["addressCountry"].",".addslashes(strip_tags(json_encode(@$element["shortDescription"])));
		else if($type == Project::COLLECTION)
			$odesc = $controller." : ".addslashes( strip_tags(json_encode(@$element["shortDescription"]))).",".addslashes(json_encode(@$element["address"]["streetAddress"])).",".@$element["address"]["postalCode"].",".@$element["address"]["addressLocality"].",".@$element["address"]["addressCountry"];
	}
?>
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
			id : "<?php echo (string)$element["_id"] ?>",
			type : "<?php echo $type ?>",
			controller : <?php echo json_encode(Element::getControlerByCollection($type))?>,
			otags : "<?php echo addslashes($element["name"]).",".$type.",communecter,".@$element["type"].",".addslashes(@implode(",", $element["tags"])) ?>",
			odesc : <?php echo json_encode($odesc) ?>,
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
	var countries = <?php echo json_encode($countries) ?>;
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
		//buildQRCode(contextData.type,contextData.id.$id);

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
		
		$(".open-directory").click(function(){
			toogleNotif(false);
			smallMenu.openAjax(baseUrl+'/'+moduleId+'/element/directory/type/'+contextData.type+'/id/'+contextData.id+
								'?tpl=json','Communauté','fa-connectdevelop','dark');
			bindLBHLinks();
		});
		$("#exportCSV").click(function(){
			// alert("Clic sur le bouton d'export CSV");

			var id = contextData.id;
			var type = contextData.type;

			// alert(id);
			// alert(type);

			$.ajax({
		        type: "GET",
		       	url : baseUrl+'/'+moduleId+'/export',
		        data: 'id='+id+'&type='+type,
		    	success: function(data){

		    		res = JSON.parse(data);
		    		head = "";
		    		ligne_type = "";
		    		ligne_isAdmin = "";

		    		$.each(res, function( key, value ) {

		    			head += '";"'+key;
		    			ligne_type += '";"'+value.type;
		    			ligne_isAdmin += '";"'+value.isAdmin;

					});

					// alert(head.length);
					// alert(ligne_type.length);
					// alert(ligne_isAdmin.length);

					head = head.substring(2, (head.length));
					ligne_type = ligne_type.substring(2, (ligne_type.length));
					ligne_isAdmin = ligne_isAdmin.substring(2, (ligne_isAdmin.length));

		    		csv =  head+'"';
		    		csv += "\n";
		    		csv +=ligne_type+'"';
		    		csv += "\n";
		    		csv +=ligne_isAdmin+'"';

		    		// alert(csv);

		    		$("<a />", {
					  "download": "Element.csv",
					  "href" : "data:application/csv," + encodeURIComponent(csv)
					}).appendTo("body")
					.click(function() {
					   $(this).remove()
					})[0].click() ;

					// head = '";"';
					// ligne_type = '";"';
					// ligne_isAdmin = '";"';

					
			    }
			});
		});
		$(".edit-chart").click(function(){
			toogleNotif(false);
			var url = "chart/addchartsv/type/"+contextType+"/id/"+contextId;
			$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
			ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
		});
		$(".btn-open-collection").click(function(){
			toogleNotif(false);
		});

		$("#btn-start-detail").click(function(){
			loadDetail();
		});
		
	});

	function loadDetail(){
		toogleNotif(false);
		var url = "element/detail/type/"+contextData.type+"/id/"+contextData.id;
		
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url+'?tpl=ficheInfoElement', null, function(){},"html");
	}

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

	function toCSV(data){

		console.dir(data);

		alert(data.id);
		alert(data.type);

	}	

</script>
