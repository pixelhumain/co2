<?php 
	$cssAnsScriptFilesModule = array(
		//Data helper
		'/js/dataHelpers.js',
		'/js/activityHistory.js',
		'/js/news/index.js',
		'/js/default/editInPlace.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->getParentAssetsUrl());

	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';
	$thumbAuthor =  @$element['profilThumbImageUrl'] ? 
                      Yii::app()->createUrl('/'.@$element['profilThumbImageUrl']) 
                      : "";

	if(@$invitedMe && !empty($invitedMe)){
		$inviteRefuse="Refuse";
		$inviteAccept="Accept";
		$verb="Join";
		$labelAdmin="";
		$option=null;
		$linkValid=Link::IS_INVITING;
		$msgRefuse=Yii::t("common","Are you sure to refuse this invitation");
		if(@$invitedMe["isAdminInviting"]){
			$verb="Administrate";
			$option="isAdminInviting";
			$labelAdmin=" to administrate";
			$linkValid=Link::IS_ADMIN_INVITING;
			$msgRefuse=Yii::t("common","Are you sure to refuse to administrate {what}", array("{what}"=>Yii::t("common"," this ".Element::getControlerByCollection($type))));
		}
		$labelInvitation=Yii::t("common", "{who} invited you".$labelAdmin, array("{who}"=>"<a href='#page.type.".Person::COLLECTION.".id.".$invitedMe["invitorId"]."' class='lbh'>".$invitedMe["invitorName"]."</a>"));
		$tooltipAccept=$verb." this ".Element::getControlerByCollection($type);
		if ($type == Event::COLLECTION){
			$inviteRefuse="Not interested";
			$inviteAccept="I go";
		}
		echo "<div class='no-padding containInvitation' style='border-bottom: 1px solid lightgray;margin-bottom:10px !important;'>".
			"<div class='padding-5'>".
				$labelInvitation.": <br/>".
				'<a class="btn btn-xs tooltips btn-accept" href="javascript:;" onclick="validateConnection(\''.$type.'\',\''.(string)$element["_id"].'\', \''.Yii::app()->session["userId"].'\',\''.Person::COLLECTION.'\',\''.$linkValid.'\')" data-placement="bottom" data-original-title="'.Yii::t("common",$tooltipAccept).'">'.
					'<i class="fa fa-check "></i> '.Yii::t("common",$inviteAccept).
				'</a>'.
				'<a class="btn btn-xs tooltips btn-refuse margin-left-5" href="javascript:;" onclick="disconnectTo(\''.$type.'\',\''.(string)$element["_id"].'\',\''.Yii::app()->session["userId"].'\',\''.Person::COLLECTION.'\',\''.Element::$connectTypes[$type].'\',null,\''.$option.'\',\''.$msgRefuse.'\')" data-placement="bottom" data-original-title="'.Yii::t("common","Not interested by the invitation").'">'.
					'<i class="fa fa-remove"></i> '.Yii::t("common",$inviteRefuse).
				'</a>'.
			"</div>".
		"</div>";
	}
?>


<?php if(@Yii::app()->session["userId"] && @Yii::app()->session["userId"] != (string)$element["_id"]){ ?>
	<style>
		.boxBtnLink{
			background-color: #454444;
			border-radius: 5px;
			margin-top:7px;
		}
		.boxBtnLink a.menu-linksBtn,
		.boxBtnLink .nav.navbar-nav,
		.boxBtnLink .dropdown {
			width: 100%;
		}
		.boxBtnLink a.menu-linksBtn {
			padding:10px;
		}
	</style>
	<div class="pull-left col-xs-12 no-padding margin-bottom-15 shadow2 boxBtnLink">
        	<?php $this->renderPartial('co2.views.element.linksMenu', 
    			array(  "linksBtn"      => $linksBtn,
    					"elementId"   => (string)$element["_id"],
    					"elementType" => $type,
    					"elementName" => $element["name"],
    					"openEdition" => $openEdition ) 
    			); 
    		?>
	</div>
<?php } ?>

<ul id="subsubMenuLeft" class="pull-left">
	
<?php if (($edit==true || $openEdition==true) && @Yii::app()->session["userId"]){ ?>
		<li class="visible-xs">
			<a href="javascript:" class="letter-green ssmla open-create-form-modal">
		  		<i class="fa fa-plus-circle fa-2x"></i> <?php echo Yii::t("common", "Create") ?>
		  	</a>
		</li>
	<?php //if($type != Person::COLLECTION){
		$modalTarget = "#modal-scope";

				if ($type == Event::COLLECTION ){ 
					$inviteLink = "people";
					$inviteText =  Yii::t("common","Invite people") ;
					$urlLink = "#element.invite.type.".Event::COLLECTION.".id.".(string)$element["_id"];		
				}else if ($type == Organization::COLLECTION) { 
					$inviteLink = "members";
					$inviteText =  Yii::t("common",'Invite members') ;
					$urlLink = "#element.invite.type.".Organization::COLLECTION.".id.".(string)$element["_id"];
				}else if ($type == Project::COLLECTION ){ 
					$inviteLink = "contributors";
					$inviteText =  Yii::t("common",'Invite contributors') ;
					$urlLink = "#element.invite.type.".Project::COLLECTION.".id.".(string)$element["_id"];
				}else if ($type == Person::COLLECTION) { 
					$inviteLink = "people";
					$inviteText =  Yii::t("common",'Invite people') ;
					$modalTarget = "#invite-modal-element";
					$urlLink = "#element.invite.type.".Person::COLLECTION.".id.".(string)$element["_id"];
				}

				//$urlLink = "#element.invite.type.".$type.".id.".(string)$element["_id"] ;
				
				$modalTarget = "#modal-invite";
				$whereConnect="";
				if($type!=Person::COLLECTION)
					$whereConnect='to the '.Element::getControlerByCollection($type);
				
				if( @$inviteLink && @$inviteText ){ ?>
					<li class="">
						<a 	href="<?php echo $urlLink ; ?>" 
							class="tooltips ssmla lbhp text-red"
							data-placement="bottom" 
							data-original-title="<?php echo Yii::t("common","Invite {what} {where}",array("{what}"=> Yii::t("common",$inviteLink),"{where}"=>Yii::t("common", $whereConnect))); ?>" > 
					        <i class="fa fa-user-plus "></i><?php echo $inviteText ?>
					    </a>
						<!-- <a href="javascript:;" class="tooltips ssmla text-red" 
						data-placement="bottom" 
						data-original-title="<?php //echo Yii::t("common","Invite {what} {where}",array("{what}"=> Yii::t("common",$inviteLink),"{where}"=>Yii::t("common", $whereConnect))); ?>" 
						data-toggle="modal" 
						data-target="<?php //echo $modalTarget ?>">
							<i class="fa fa-user-plus "></i> <?php // echo $inviteText ?>
						</a> -->
					</li>
					<li><hr></li>
		<?php 	}
	}	?>
	<?php if(@Yii::app()->session["userId"] && 
		 $type==Person::COLLECTION && 
		 (string)$element["_id"]==Yii::app()->session["userId"]){ 

		$iconNewsPaper="user-circle"; 
	?>
	<li class="visible-xs">
		<a href="javascript:" class="ssmla btn-start-newsstream">	
			<i class="fa fa-rss"></i> Fil d'actualités
		</a>
	</li>

	<?php } else {
			$iconNewsPaper="rss"; 
		}
	?>
	<li class="visible-xs">
		<a href="javascript:" class="ssmla btn-start-mystream">		
		  	<i class="fa fa-<?php echo $iconNewsPaper ?>"></i> <?php echo Yii::t("common","Newspaper"); ?>
		</a>
	</li>
	<?php if((@Yii::app()->session["userId"] && $isLinked==true) || @Yii::app()->session["userId"] == $element["_id"]){ ?>
		<li class="visible-xs">
			<a href="javascript:" class="ssmla btn-start-notifications">
		  	<i class="fa fa-bell"></i><?php if (@Yii::app()->session["userId"] == $element["_id"]) echo "Mes n"; else echo "N"; ?>otifications
		  	<span class="badge notifications-countElement <?php if(!@$countNotifElement || (@$countNotifElement && $countNotifElement=="0")) echo 'badge-transparent hide'; else echo 'badge-success'; ?>">
		  		<?php echo @$countNotifElement ?>
		  	</span>
		  	</a>
		</li>
	<?php } ?>
	<li class="">
		<a href="javascript:" class="ssmla" id="btn-start-detail">
			<i class="fa fa-info-circle"></i> <?php echo Yii::t("common","About"); ?>
		</a>
	</li>	

	<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Place::COLLECTION){ 
		if(@$element["properties"] && @$element["properties"]["chart"]) 
			$countChart=count($element["properties"]["chart"]); 
		if(@$countChart || $edit || $openEdition){ ?>
			<li class="">
				<a href="javascript:" class="ssmla <?php if(@$countChart) echo "btn-start-chart"; else echo "edit-chart"; ?>">
					<i class="fa fa-heartbeat"></i> <?php echo Yii::t("chart", "Our values"); if(@$countChart) echo " (".$countChart.")" ?>
				</a>
			</li>
	<?php } } ?>

	<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION || $type==Place::COLLECTION){ ?>
	<li class="">
		<a href="javascript:" data-toggle="modal" data-target="#selectCreate" 
			id="btn-start-contacts" class="ssmla">
			<i class="fa fa-envelope"></i> <?php echo Yii::t("common","Contact us"); ?>
		</a>
	</li>
	<?php } ?>
	             

	<li class="">
		<a href="javascript:" class="ssmla" id="btn-start-gallery">
			<i class="fa fa-cloud"></i> <?php echo Yii::t("common","Gallery"); ?>
		</a>
	</li>

	
	<!--<li class="">
		<a href="javascript:" class="ssmla" id="btn-start-urls">
			<i class="fa fa-external-link"></i> <?php echo Yii::t("common","Urls"); ?>
		</a>
	</li>
	-->
	<li><hr></li>
	<?php if(	$type != Poi::COLLECTION 
				&& ( 	$type != Person::COLLECTION || 
			 			Preference::showPreference( $element, $type, "directory", Yii::app()->session["userId"]) ) ) { ?>

		
		<?php if($type == Person::COLLECTION ) 
			$connectCommunity=@Element::$connectAs[$type];
		 else 
		 	$connectCommunity=@Element::$connectTypes[$type];
		?>
		<li class="">
			<a href="javascript:" class="ssmla capitalize load-data-directory load-data-community" 
				data-type-dir="<?php echo @$connectCommunity; ?>" data-icon="users">
				<i class="fa fa-users"></i> <?php echo Yii::t("common","Community"); ?>
			</a>
		</li>
		

		<?php if ($type==Person::COLLECTION){ ?>
			<li class="">
				<a href="javascript:" class="ssmla load-data-directory" data-type-dir="collections" data-icon="star">
					<i class="fa fa-star"></i> <?php echo Yii::t("common","Collections"); ?>
				</a>
			</li>

			<li><hr></li>
		<?php } ?>
		
		<?php if(!@$front || (@$front && $front["event"]==true)){ 
			if($type==Event::COLLECTION)
				$label=Yii::t("common","Program");
			else
				$label=Yii::t("common","Agenda");
			?>
			<li class="">
				<a href="javascript:" class="ssmla load-data-directory" data-type-dir="events" data-icon="calendar">
					<i class="fa fa-calendar"></i> <?php echo $label; ?>
				</a>
			</li>
			<?php if ($type==Person::COLLECTION || $type==Place::COLLECTION ){ ?>
			<!--<li class="">
				<a href="javascript:" class="ssmla load-data-directory" data-type-dir="organizations" data-icon="group">
					<i class="fa fa-group"></i>  <?php echo Yii::t("common","Organizations"); ?>
				</a>
			</li>-->
			<?php }  ?>
			<?php if ($type==Person::COLLECTION || $type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Place::COLLECTION){ ?>
			<li class="">
				<a href="javascript:" class="ssmla load-data-directory" data-type-dir="projects" data-icon="lightbulb-o">
					<i class="fa fa-lightbulb-o"></i>  <?php echo Yii::t("common","Projects"); ?>
				</a>
			</li>
			<li><hr></li>
			<?php }  ?>
		<?php }  ?>
		<?php $paramsApp = CO2::getThemeParams(); 
				if( $type!=Event::COLLECTION && ( !@$front || (@$front && $front["need"]==true)) &&
				    $paramsApp["pages"]["#annonces"]["open"] == true){ ?>
			<li class="">
				<a href="javascript:" class="ssmla load-data-directory" data-type-dir="classifieds" data-icon="bullhorn">
					<i class="fa fa-bullhorn"></i> <?php echo Yii::t("common","Classifieds"); ?>
				</a>
			</li>
		<?php } ?>	
		<?php if (in_array($type, [Project::COLLECTION, Organization::COLLECTION, Event::COLLECTION, Person::COLLECTION, Place::COLLECTION])){  
					if(!@$front || (@$front && $front["poi"])){ 
		?>
			<li>
				<a href="javascript:"  class="ssmla load-data-directory" data-type-dir="ressources" data-icon="cubes">
					<i class="fa fa-cubes"></i> <?php echo Yii::t("common","Ressources"); ?>
				</a>
			</li>			
		<?php }  
		} ?>
		<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION){  
					if(!@$front || (@$front && $front["poi"])){ 
		?>
			<li>
				<a href="javascript:"  class="ssmla load-data-directory" data-type-dir="jobs" data-icon="briefcase">
					<i class="fa fa-briefcase"></i> <?php echo Yii::t("common","Jobs"); ?>
				</a>
			</li>			
		<?php }  
		} ?>
		<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION || 
				  $type==Event::COLLECTION || $type==Person::COLLECTION || $type==Place::COLLECTION ){  
					if(!@$front || (@$front && $front["poi"])){ 
		?>
			<li>
				<a href="javascript:"  class="ssmla load-data-directory" data-type-dir="poi" data-icon="map-marker">
					<i class="fa fa-map-marker"></i> <?php echo Yii::t("common","Points of interest"); ?>
				</a>
			</li>			
		<?php }  
		} ?>

		

		<?php if( $type!=Event::COLLECTION && ( !@$front || (@$front && $front["need"]==true)) &&
				    $paramsApp["pages"]["#annonces"]["open"] == true){ ?>
			<li><hr></li>
			<li class="">
				<a href="javascript:" class="ssmla load-data-directory" data-type-dir="surveys" data-icon="gavel">
					<i class="fa fa-gavel"></i> <?php echo Yii::t("common","Surveys"); ?>
				</a>
			</li>
		<?php } ?>

		<?php if( $type==Person::COLLECTION ){ ?>
			<li><hr></li>
			<li class="">
				<a href="javascript:" class="ssmla" id="btn-start-curiculum">
					<i class="fa fa-clipboard"></i> <?php echo Yii::t("common","My experiences"); ?>
				</a>
			</li>
			<!--  <li><hr></li>
			<li class="">
				<a href="javascript:" data-toggle="modal" data-target="#selectCreate" 
					id="btn-start-networks" class="ssmla">
					<i class="fa fa-map-o"></i> <?php //echo Yii::t("common","My maps"); ?>
				</a>
			</li>  -->
		<?php } ?>
		<li><hr></li>

	<?php } ?>

	<?php if (in_array($type,[Project::COLLECTION,Organization::COLLECTION,Event::COLLECTION,Person::COLLECTION])){  
			$hash = @$element["slug"] ? 
					"#".$element["slug"] :
					"#page.type.".$type.".id.".$element["_id"];
	?>
		<!--<li>
			<a href="<?php echo $hash; ?>.net"  class="lbh letter-blue">
				<i class="fa fa-desktop"></i> <?php echo Yii::t("common","My web page"); ?>
			</a>
		</li>-->			
	<?php } ?>
</ul>


