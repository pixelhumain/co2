
<?php if(@$modal && $modal!==false){ ?>
<div class="modal fade" role="dialog" id="modal-confidentiality">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php } ?>
			<div class="modal-header">
			<?php if(@$modal && $modal!==false){ ?>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php } ?>	
				<?php if($type==Person::COLLECTION)
					$titleParams=Yii::t("common","Confidentiality of your personal informations");
				else
					$titleParams=Yii::t("common","Settings {what}", array("{what}"=>Yii::t("common","of the ".Element::getControlerByCollection($type))." ".$element["name"]));
				?>
				<h4 class="modal-title"><i class="fa fa-cog"></i> <?php echo $titleParams ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="pull-left text-left padding-10" 
						 style="border: 1px solid rgba(128, 128, 128, 0.3); margin: 10px;">
						<?php if ($type==Person::COLLECTION){ ?>
							<strong><i class="fa fa-group"></i> <?php echo Yii::t("common","Public"); ?></strong> : 
							<?php echo Yii::t("common","Visible for everyone."); ?><br/><br/>

							<strong><i class="fa fa-user-secret"></i> <?php echo Yii::t("common","Private"); ?></strong> : 
							<?php echo Yii::t("common","Visible for my contacts."); ?><br/><br/>

							<strong><i class="fa fa-ban"></i> <?php echo Yii::t("common","Mask"); ?></strong> : 
							<?php echo Yii::t("common","Not visible."); ?><br/>	<br/>					
						<?php } ?>

						<strong><i class="fa fa-group"></i> <?php echo Yii::t("common","Open Data"); ?></strong> : 
						<?php echo Yii::t("common","You propose your data in free access, to contribut for commons."); ?>
						<br/><br/>
						
						<?php if ($type!=Person::COLLECTION){ ?>
							<strong><i class="fa fa-group"></i> <?php echo Yii::t("common","Open Edition") ;?></strong> : 
							<?php echo Yii::t("common","All users can participed / modified the informations."); ?><br/><br/>
						<?php } ?>
					</div>
				</div>
				<div class="row text-dark panel-btn-confidentiality">
					<?php if ($type==Person::COLLECTION){ ?>
						<div class="col-sm-4 col-xs-4 text-right padding-10 margin-top-10">
							<i class="fa fa-message"></i> <strong><?php echo Yii::t("person","Birth date"); ?> :</strong>
						</div>
						<div class="col-sm-8 col-xs-8 text-left padding-10">
							<div class="btn-group btn-group-birthDate inline-block">
								<button class="btn btn-default confidentialitySettings" type="birthDate" value="public"><i class="fa fa-group"></i> <?php echo Yii::t("common","Public"); ?></button>
								<button class="btn btn-default confidentialitySettings" type="birthDate" value="private"><i class="fa fa-user-secret"></i> <?php echo Yii::t("common","Private"); ?></button>
								<button class="btn btn-default confidentialitySettings" type="birthDate" value="hide"><i class="fa fa-ban"></i> <?php echo Yii::t("common","Mask"); ?></button>
							</div>
						</div>
						<div class="col-sm-4 col-xs-4 text-right padding-10 margin-top-10">
							<i class="fa fa-message"></i> <strong><?php echo Yii::t("common","My mail"); ?> :</strong>
						</div>
						<div class="col-sm-8 col-xs-8 text-left padding-10">
							<div class="btn-group btn-group-email inline-block">
							<button class="btn btn-default confidentialitySettings" type="email" value="public"><i class="fa fa-group"></i> <?php echo Yii::t("common","Public"); ?></button>
							<button class="btn btn-default confidentialitySettings" type="email" value="private"><i class="fa fa-user-secret"></i> <?php echo Yii::t("common","Private"); ?></button>
							<button class="btn btn-default confidentialitySettings" type="email" value="hide"><i class="fa fa-ban"></i> <?php echo Yii::t("common","Mask"); ?></button>
							</div>
						</div>
						<div class="col-sm-4 col-xs-4 text-right padding-10 margin-top-10">
							<i class="fa fa-message"></i> <strong><?php echo Yii::t("common","Locality") ;?> :</strong>
						</div>
						<div class="col-sm-8 col-xs-8 text-left padding-10">
							<div class="btn-group btn-group-locality inline-block">
								<button class="btn btn-default confidentialitySettings" type="locality" value="public" selected><i class="fa fa-group"></i> <?php echo Yii::t("common","Public") ;?></button>
								<button class="btn btn-default confidentialitySettings" type="locality" value="private"><i class="fa fa-user-secret"></i> <?php echo Yii::t("common","Private"); ?></button>
								<button class="btn btn-default confidentialitySettings" type="locality" value="hide"><i class="fa fa-ban"></i> <?php echo Yii::t("common","Mask"); ?></button>
							</div>
						</div>
						<div class="col-sm-4 col-xs-4 text-right padding-10 margin-top-10">
							<i class="fa fa-message"></i> <strong><?php echo Yii::t("common","My phone"); ?>  :</strong>
						</div>
						<div class="col-sm-8 col-xs-8 text-left padding-10">
							<div class="btn-group btn-group-phone inline-block">
								<button class="btn btn-default confidentialitySettings" type="phone" value="public"><i class="fa fa-group"></i> <?php echo Yii::t("common","Public") ;?></button>
								<button class="btn btn-default confidentialitySettings" type="phone" value="private"><i class="fa fa-user-secret"></i> <?php echo Yii::t("common","Private") ;?></button>
								<button class="btn btn-default confidentialitySettings" type="phone" value="hide"><i class="fa fa-ban"></i> <?php echo Yii::t("common","Mask"); ?></button>
							</div>
						</div>
						<div class="col-sm-4 col-xs-4 text-right padding-10 margin-top-10">
							<i class="fa fa-message"></i> <strong><?php echo Yii::t("common","My directory"); ?>  :</strong>
						</div>
						<div class="col-sm-8 col-xs-8 text-left padding-10">
							<div class="btn-group btn-group-directory inline-block">
								<button class="btn btn-default confidentialitySettings" type="directory" value="public"><i class="fa fa-group"></i> <?php echo Yii::t("common","Public") ;?></button>
								<button class="btn btn-default confidentialitySettings" type="directory" value="private"><i class="fa fa-user-secret"></i> <?php echo Yii::t("common","Private") ;?></button>
								<button class="btn btn-default confidentialitySettings" type="directory" value="hide"><i class="fa fa-ban"></i> <?php echo Yii::t("common","Mask"); ?></button>
							</div>
						</div>
					<?php } ?>

					<div class="col-sm-4 col-xs-4 text-right padding-10 margin-top-10">
						<i class="fa fa-message"></i> <strong><?php echo Yii::t("common","Open Data") ;?> :</strong>
					</div>
					<div class="col-sm-8 col-xs-8 text-left padding-10">
						<div class="btn-group btn-group-isOpenData inline-block">
							<button class="btn btn-default confidentialitySettings" type="isOpenData" value="true">
								<i class="fa fa-group"></i> <?php echo Yii::t("common","Yes"); ?>
							</button>
							<button class="btn btn-default confidentialitySettings" type="isOpenData" value="false">
								<i class="fa fa-user-secret"></i> <?php echo Yii::t("common","No"); ?>
							</button>
							<?php
								$url = Yii::app()->baseUrl.'/api/';
								if($type == Person::COLLECTION)
									$url .= Person::CONTROLLER;
								else if($type == Organization::COLLECTION)
									$url .= Organization::CONTROLLER;
								else if($type == Event::COLLECTION)
									$url .= Event::CONTROLLER;
								else if($type == Project::COLLECTION)
									$url .= Project::CONTROLLER;
								?>
							<a href="<?php echo $url.'/get/id/'.$element['_id'] ;?>" data-toggle="tooltip" 
								title='Visualiser la données' id="urlOpenData" 
								class="urlOpenData padding-5 margin-left-10 pull-left" target="_blank">
								<i class="fa fa-eye"></i> visualiser
							</a>
						</div>
					</div>
					<?php if($type != Person::COLLECTION){ ?>
						<div class="col-sm-4 col-xs-4 text-right padding-10 margin-top-10">
							<i class="fa fa-message"></i> <strong><?php echo Yii::t("common","Open Edition") ;?> :</strong>
						</div>
						<div class="col-sm-8 col-xs-8 text-left padding-10">
							<div class="btn-group btn-group-isOpenEdition inline-block">
								<button class="btn btn-default confidentialitySettings" type="isOpenEdition" value="true">
									<i class="fa fa-group"></i> <?php echo Yii::t("common","Yes"); ?></button>
								<button class="btn btn-default confidentialitySettings" type="isOpenEdition" value="false">
									<i class="fa fa-user-secret"></i> <?php echo Yii::t("common","No"); ?></button>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="lbh btn btn-success btn-confidentialitySettings" data-dismiss="modal" aria-label="Close" data-hash="#page.type.<?php echo $type ?>.id.<?php echo $element['_id'] ;?>">
				<i class="fa fa-times"></i> <?php echo Yii::t("common","Close") ;?>
				</button>
			</div>
		<?php if(@$modal && $modal!==false){ ?>
		</div>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
var seePreferences = '<?php echo (@$element["seePreferences"] == true) ? "true" : "false"; ?>';		
var preferences = <?php echo json_encode(@$element["preferences"]) ?>;
var contextId='<?php echo @$id ?>';
var contextType='<?php echo @$type ?>';
var typePreferences=["privateFields", "publicFields"];
var nameFields=["email", "locality", "phone", "directory", "birthDate"];
var typePreferencesBool = ["isOpenData", "isOpenEdition"];
console.log("preferences",preferences);
jQuery(document).ready(function() {
	settings.bindButtonConfidentiality(preferences);
	settings.bindEventsConfidentiality(contextId, contextType);
});
</script>