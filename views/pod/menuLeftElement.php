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

<ul id="subsubMenuLeft" class="pull-left col-xs-12 no-padding">
	
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
					</li>
					<li><hr></li>
		<?php 	}
	}	?>
	<?php 
		// MENU LEFT OF THE ELEMENT 
		// - List of this menu is define on the document CO2/config/CO2/params.json at @element.menuLeft
		// - $variable stocked in session variable {paramsConfig} during the initialization in mainSearch.php with @CO2::getThemeParams()  
		// - customized if necessary with @CO2::filterThemeInCustom() during the process in co2/views/custom/init.php 
		foreach($themeParams["element"]["menuLeft"] as $key => $v){ 
			if(!@$v["typeAllow"] || in_array($type, $v["typeAllow"])){ 
				$labelButon=($key=="events" && $type=="events")? Yii::t("common","Program"): Yii::t("common", $v["label"]);
				$showBtn=true;
				$attrHtml="";
				// Case special for values menu 
				// 1-- If no chart already fulfill, redirection on chart forms
				// 2-- If no chart already fulfill & user can't edit, the button is hide
				if($key=="chart"){	
					$countChart=(@$element["properties"] && @$element["properties"]["chart"]) ? count($element["properties"]["chart"]): 0; 
					$v["class"].=($countChart > 0) ? " btn-start-chart": " edit-chart";
					$labelButon.=($countChart > 0) ? " (".$countChart.")": "";
					if($countChart < 1 && !$edit && !$openEdition && !@Yii::app()->session["userId"])
						$showBtn=false;
				}
				// Case in directory or other button who used data attribute
				// @data-dir of community depends on context type (ex: citoyens=>memberOf || organizations=>members...) 
				if(@$v["dataAttr"]){
					foreach($v["dataAttr"] as $attr => $value){
						if($key=="community" && empty($value))
							$dataValue=($type == Person::COLLECTION) ? @Element::$connectAs[$type] : @Element::$connectTypes[$type];
						else
							$dataValue=$value;
						$attrHtml.=" data-".$attr."='".$dataValue."' ";
					}
				}	
				if(in_array($key, ["community", "projects", "events", "collections", "classifieds", "ressources", "jobs"])
					&& $type == Person::COLLECTION 
					&& !Preference::showPreference( $element, $type, "directory", Yii::app()->session["userId"]) )
					$showBtn=false;
				if($showBtn){
				?>
				<li class="<?php if(@$v["visibleXs"]) echo "visible-xs" ?>">
					<a href="javascript:;" id="<?php echo @$v["id"] ?>" class="<?php echo $v["class"] ?>" <?php echo $attrHtml ?>>
						<i class="fa <?php echo $v["icon"] ?>"></i> <?php echo $labelButon; ?>
					</a>
				</li>
				<?php if(@$v["separator"]) { ?> 
					<li><hr></li>
				<?php } } ?>
		<?php  } }
	?>
	<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////
	///// Button not integrated for the moment :: NOTIFICATIONS XS-VIEW / MAP CREATOR / ONE PAGE VIEW ////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////// 
	<li class="visible-xs">
			<a href="javascript:" class="ssmla btn-start-notifications">
		  	<i class="fa fa-bell"></i><?php if (@Yii::app()->session["userId"] == $element["_id"]) echo "Mes n"; else echo "N"; ?>otifications
		  	<span class="badge notifications-countElement <?php if(!@$countNotifElement || (@$countNotifElement && $countNotifElement=="0")) echo 'badge-transparent hide'; else echo 'badge-success'; ?>">
		  		<?php echo @$countNotifElement ?>
		  	</span>
		  	</a>
		</li> 
		<li class="">
			<a href="javascript:" data-toggle="modal" data-target="#selectCreate" 
				id="btn-start-networks" class="ssmla">
				<i class="fa fa-map-o"></i> <?php //echo Yii::t("common","My maps"); ?>
			</a>
		</li>  
		<?php if (in_array($type,[Project::COLLECTION,Organization::COLLECTION,Event::COLLECTION,Person::COLLECTION])){  
			$hash = @$element["slug"] ? "#".$element["slug"] : "#page.type.".$type.".id.".$element["_id"]; ?>
			<li>
				<a href="<?php echo $hash; ?>.net"  class="lbh letter-blue">
					<i class="fa fa-desktop"></i> <?php echo Yii::t("common","My web page"); ?>
				</a>
			</li>			
		<?php } ?>
	//////////////// END LIST OF BUTTON NOT INTEGRATED //////////////////////////////////////////////// -->
</ul>


