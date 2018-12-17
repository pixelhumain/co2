<?php 
	HtmlHelper::registerCssAndScriptsFiles( 
		array(  //'/css/onepage.css',
				'/vendor/colorpicker/js/colorpicker.js',
				'/vendor/colorpicker/css/colorpicker.css',
				'/css/news/index.css',	
				'/css/timeline2.css',
				//'/css/circle.css',	
				'/css/default/directory.css',	
				//'/js/comments.js',
				'/css/profilSocial.css',
				'/css/calendar.css',
		) , 
	Yii::app()->theme->baseUrl. '/assets');

 $cssAnsScriptFilesModule = array(
    '/js/default/calendar.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	$cssAnsScriptFilesTheme = array(
		"/plugins/jquery-cropbox/jquery.cropbox.css",
		"/plugins/jquery-cropbox/jquery.cropbox.js",
		// SHOWDOWN
		'/plugins/showdown/showdown.min.js',
		//MARKDOWN
		'/plugins/to-markdown/to-markdown.js',
		'/plugins/jquery.qrcode/jquery-qrcode.min.js',
		'/plugins/fullcalendar/fullcalendar/fullcalendar.min.js',
        '/plugins/fullcalendar/fullcalendar/fullcalendar.css', 
        '/plugins/fullcalendar/fullcalendar/locale/'.Yii::app()->language.'.js',
        "/plugins/d3/d3.js",
        "/plugins/d3/d3-flextree.js",
        "/plugins/d3/view.mindmap.js",
        "/plugins/d3/view.mindmap.css",
        
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
	
	//$id = $_GET['id'];
	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';

	
	//récupération du type de l'element
    $typeItem = (@$element["typeSig"] && $element["typeSig"] != "") ? $element["typeSig"] : "";
    if($typeItem == "") $typeItem = @$element["type"] ? $element["type"] : "item";
    if($typeItem == "people") $typeItem = "citoyens";
    
    $typeItemHead = $typeItem;
    if($typeItem == "organizations" && @$element["type"]) $typeItemHead = $element["type"];
    
    if(strpos($typeItem, "place.")!==false){
    	$typeItem = "place";
    }
    
    //icon et couleur de l'element
    $icon = Element::getFaIcon($typeItemHead) ? Element::getFaIcon($typeItemHead) : "";
    $iconColor = Element::getColorIcon($typeItemHead) ? Element::getColorIcon($typeItemHead) : "";

    $useBorderElement = false;
    $pageConfig=(@Yii::app()->session['paramsConfig']["element"]) ? Yii::app()->session['paramsConfig']["element"] : null;
    $addConfig=(@Yii::app()->session['paramsConfig']["add"]) ? Yii::app()->session['paramsConfig']["add"] : null; 
    if(@Yii::app()->params["front"]) $front = Yii::app()->params["front"];

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
$me = isset(Yii::app()->session['userId']) ? Person::getById(Yii::app()->session['userId']) : null;
$this->renderPartial( $layoutPath.'modals.'.Yii::app()->params["CO2DomainName"].'.mainMenu', array("me"=>$me) );
?>
<style>
	
 	hr.angle-down::after {
        display: none;
    }
    hr.angle-down{
        border-top: 0px solid #ccc;
        margin-bottom:10px!important;
    }

<?php if($typeItem != "citoyens"){ ?>
	.section-create-page{
		display: none;
	}
<?php } ?>

<?php if($typeItem == "events"){ ?>
	.hide-event{
		display: none;
	}
<?php } ?>

<?php if($typeItem == "place"){ ?>
	.hide-place{
		display: none;
	}
<?php } ?>

.grayscale{
  filter: grayscale(100%);
  -webkit-filter: grayscale(100%);
  -moz-filter: grayscale(100%);
}

#ajax-modal .modal-content,
#formContact .modal-content{
	/*background-color: rgba(0,0,0,0.6);*/
}
#ajax-modal .container,
#formContact .container{
	background-color: white;
	border-radius: 4px;
}
#ajax-modal.portfolio-modal,
#formContact.portfolio-modal {
	background-color: transparent;
}/*
#ajax-modal .close-modal .lr,
#ajax-modal .close-modal .rl,
#formContact .close-modal .lr,
#formContact .close-modal .rl{
	background-color: #fff;
}*/

#btn-show-activity-onmap{
    width:100%;
}

#central-container #content-results-profil .coop-wraper{
	width:31%!important;
	margin: 0 1% 15px 0 !important;
	border:1px solid #229296!important;
	padding:0px;
}

#central-container #content-results-profil .coop-wraper .searchEntity.coopPanelHtml{
	border:0px !important;
}

#central-container #content-results-profil .coop-wraper .searchEntity.coopPanelHtml .all-coop-detail{
	display:none;
}

#central-container #content-results-profil .coop-wraper .searchEntity.coopPanelHtml .panel-title{
	text-overflow: ellipsis;
	white-space: nowrap;
	overflow: hidden;
	max-width: 75%;
	display: inline-block;
	margin-top:7px;
	font-size: 13px;
}
/*
#central-container #content-results-profil button.openCoopPanelHtml .hidden-xs,
#central-container button.switchDirectoryView{
	display: none;
}*/



@media screen and (max-width: 992px) {
	#central-container #content-results-profil .coop-wraper.col-sm-12{
		width:48%!important;
	}
}
</style>

<?php 
	$auth = Authorisation::canParticipate(Yii::app()->session['userId'], $type, (string)$element["_id"]);

	// if (Authorisation::canDeleteElement((String)$element["_id"], $type, Yii::app()->session["userId"]) && !@$deletePending) 
	// 	$this->renderPartial('../element/confirmDeleteModal', array("id" =>(String)$element["_id"], "type"=>$type)); 
	?>
<?php 
	if (@$element["status"] == "deletePending" && Authorisation::isElementAdmin((String)$element["_id"], $type, Yii::app()->session["userId"])) $this->renderPartial('co2.views.element.confirmDeletePendingModal', array(	"element"=>$element)); ?>

    <!-- <section class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12 header" id="header"></section> -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">	
    <!-- Header -->
    <section class="col-md-12 col-sm-12 col-xs-12" id="social-header" 
    	<?php if (!@$element["profilBannereUrl"] || (@$element["profilBannereUrl"] && empty($element["profilBannereUrl"]))){ ?> 
    		style=" background: url('<?php echo Yii::app()->theme->baseUrl. '/assets/img/background-onepage/connexion-lines.jpg';?>') center bottom;"
    	<?php } ?>>
        <div id="topPosKScroll"></div>
    	<?php if(@$edit==true && false) { ?>
    	<button class="btn btn-default btn-sm pull-right margin-right-15 margin-top-70 hidden-xs btn-edit-section" 
    			data-id="#header">
	        <i class="fa fa-cog"></i>
	    </button>
	    <?php } ?>
        
        <?php 
	    	$this->renderPartial('co2.views.element.banner', 
			        			array(	"iconColor"=>$iconColor,
			        					"icon"=>$icon,
			        					"type"=>$type,
			        					"element"=>$element,
			        					"linksBtn"=>$linksBtn,
			        					"elementId"=>(string)$element["_id"],
			        					"elementType"=>$type,
			        					"elementName"=> $element["name"],
			        					"edit" => @$edit,
			        					"openEdition" => @$openEdition) 
			        			); 
		?>
		



	    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs no-padding" style="bottom:-31px; position: absolute;">
		<?php 	if(@$element["profilMediumImageUrl"] && !empty($element["profilMediumImageUrl"]))
					 $images=array(
					 	"medium"=>$element["profilMediumImageUrl"],
					 	"large"=>$element["profilImageUrl"]
					 );
				else $images="";	
				
				$this->renderPartial('co2.views.pod.fileupload', 
								array("itemId" => (string) $element["_id"],
									  "itemName" => $element["name"],
									  "type" => $type,
									  "resize" => false,
									  "contentId" => Document::IMG_PROFIL,
									  "show" => true,
									  "editMode" => $edit,
									  "image" => $images,
									  "openEdition" => $openEdition) ); 
		?>

		</div>
    </section>
    
    <div class="col-md-9 col-sm-9 col-lg-10 col-xs-12 pull-right sub-menu-social no-padding">

    	<div class="btn-group btn-left inline">

    	  <?php 
    	  	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';
			$thumbAuthor =  @$element['profilThumbImageUrl'] ? 
		                      Yii::app()->createUrl('/'.@$element['profilThumbImageUrl']) 
		                      : $this->module->assetsUrl.'/images/thumbnail-default.jpg';
    	  ?>
    	  <button type="button" class="btn btn-default bold menu-left-min visible-xs" onclick="menuLeftShow();">
		  		<i class="fa fa-bars"></i>
		  </button>
		  <img class="pull-left visible-xs" src="<?php echo $thumbAuthor; ?>" height=45>
    	  <div class="identity-min">
	    	  <img class="pull-left hidden-xs" src="<?php echo $thumbAuthor; ?>" height=45>
	    	  <div class="pastille-type-element bg-<?php echo $iconColor; ?> pull-left"></div>
			  <div class="col-lg-1 col-md-2 col-sm-2 col-xs-5 pull-left no-padding">
	    	  	<div class="text-left padding-left-15" id="second-name-element">
					<span id="nameHeader">
						<h5 class="elipsis"><?php echo @$element["name"]; ?></h5>
					</span>	
				</div>
	    	  </div>
    	  </div>
		  <button type="button" class="btn btn-default bold hidden-xs btn-start-mystream">
		  		<i class="fa fa-rss"></i> <?php echo Yii::t("common","Newspaper"); ?>
		  </button>

		  <?php if((@Yii::app()->session["userId"] && $isLinked==true) || @Yii::app()->session["userId"] == $element["_id"]){ ?>
		  <button type="button" class="btn btn-default bold hidden-xs btn-start-notifications hidden">
		  	<i class="fa fa-bell"></i> 
		  	<span class="hidden-xs hidden-sm">
		  		<?php if (@Yii::app()->session["userId"] == $element["_id"]) 
		  					echo Yii::t("common","My notif<span class='hidden-md'>ication</span>s"); 
		  			  else  echo Yii::t("common","Notif<span class='hidden-md'>ication</span>s"); ?>
		  	</span>
		  	<span class="badge notifications-countElement <?php if(!@$countNotifElement || (@$countNotifElement && $countNotifElement=="0")) echo 'badge-transparent hide'; else echo 'badge-success'; ?>">
		  		<?php echo @$countNotifElement ?>
		  	</span>
		  </button>
		  <?php } ?>

		  
		  <?php if(@Yii::app()->session["userId"] && Yii::app()->params['rocketchatEnabled'] )
			if( 
	  			($type==Person::COLLECTION) ||
	  			//admins can create rooms
	  			( Authorisation::canEditItem(Yii::app()->session['userId'], $type, $id) ) ||
	  			//simple members can join only when admins had created
	  			( Link::isLinked((string)$element["_id"],$type,Yii::app()->session["userId"]))  )
	  			{
	  				if(@$element["slug"])
						//todo : elements members of
	  					$loadChat = $element["slug"];
	  				else
	  					$createSlugBeforeChat=true;
	  				//todo : elements members of
	  				$loadChat = StringHelper::strip_quotes($element["name"]);
	  				//people have pregenerated rooms so allways available 
	  				$hasRC = (@$element["hasRC"] || $type == Person::COLLECTION ) ? "true" : "false";
	  				$canEdit = ( @$openEdition && $openEdition ) ? "true" : "false";
	  				//Authorisation::canEditItem(Yii::app()->session['userId'], $type, $id) );
	  				if($type == Person::COLLECTION)
	  				{
	  				 	$loadChat = (string)$element["username"];
	  					if( (string)$element["_id"]==@Yii::app()->session["userId"] )
	  						$loadChat = "";
		  			}
		  			$chatColor = (@$element["hasRC"] || $type == Person::COLLECTION ) ? "text-red" : "";

		  			if( Yii::app()->params['rocketchatMultiEnabled'] && $type != Person::COLLECTION )
	  				{
			  		?>
			  			<div class="btn-group " id="paramsMenu">
							<ul class="nav navbar-nav">
								<li class="dropdown">
									<button type="button" class="btn btn-default bold">
										<?php if(@Yii::app()->session["userId"] && $edit==true){ ?>
							  			<i class="fa fa-comments"></i> <span class="hidden-xs hidden-sm"><?php echo Yii::t("cooperation", "Chat"); ?>
							  			<?php }else{ ?>
							  			<i class="fa fa-chevron-down"></i>
							  			<?php } ?>
							  			</span>
							  		</button> 
							  		<ul class="dropdown-menu arrow_box menu-params">

						  			<?php
						  			if( $hasRC && @$element["tools"]["chat"] )
						  			{ 
							  			if( @$element["tools"]["chat"]["int"] )
			  							{
			  								?>
								  				<li class="text-left bold padding-5">
									               	Interne
									            </li>
								  			<?php
								  			foreach (@$element["tools"]["chat"]["int"] as $key => $chat) 
								  			{ ?>
								  				<li class="text-left">
									               	<a href="" class="btn-open-chatEl bg-white" data-name-el="<?php echo $element["name"]; ?>" data-username="<?php echo Yii::app()->session['user']['name']; ?>" data-slug="<?php echo $chat["name"]; ?>" data-type-el="<?php echo $type; ?>"  data-open="<?php echo ( strpos ( $chat["url"] , "/channel/") === false ) ? "false" : "true"; ?>"  data-hasRC="true" data-id="<?php echo (string)$element["_id"]; ?>">
									                    <i class="fa fa-comments"></i> <?php echo $chat["name"]; ?> 
									                    <?php if( strpos ( $chat["url"] , "/channel/") === false ) 
									                    		echo "<i class='fa fa-lock'></i>"; ?>
									                </a>
									            </li>
								  			<?php
								  			} 
								  			?>
								  			<script type="text/javascript">
								  				$(".btn-open-chatEl").click( function(){
											    	var nameElo = $(this).data("name-el");
											    	var idEl = $(this).data("id");
											    	var usernameEl = $(this).data("username");
											    	var slugEl = $(this).data("slug");
											    	var typeEl = dyFInputs.get($(this).data("type-el")).col;
											    	var openEl = $(this).data("open");
											    	var hasRCEl = ( $(this).data("hasRC") ) ? true : false;
											    	alert(nameElo +" | "+typeEl +" | "+openEl +" | "+hasRCEl);
											    	var ctxData = {
											    		name : nameElo,
											    		type : typeEl,
											    		id : idEl
											    	}
											    	if(typeEl == "citoyens")
											    		ctxData.username = usernameEl;
											    	else if(slugEl)
											    		ctxData.slug = slugEl;
											    	rcObj.loadChat(nameElo ,typeEl ,openEl ,hasRCEl, ctxData );
											    } );
								  			</script>
								  			<?php
								  		} 

								  		if( @$element["tools"]["chat"]["ext"] )
			  							{
			  								?>
								  				<li class="text-left bold padding-5">
									               	Externe
									            </li>
								  			<?php
								  			foreach ($element["tools"]["chat"]["ext"] as $key => $chat) 
								  			{ ?>
								  				<li class="text-left">
									               	<a href="<?php echo $chat["url"]; ?>" target="_blank" class="bg-white">
									                    <i class="fa fa-comments"></i> <?php echo $chat["name"]; ?> <i class="fa fa-external-link"></i>
									                </a>
									            </li>
								  			<?php
								  			}
							  			} ?>

							  			<li class="text-left text-red">
							  			<br>
							               	<a href="javascript:dyFObj.openForm('chat','sub')" class="">
							                    <i class="fa fa-plus-circle text-red"></i> <?php echo Yii::t("common","New Channel") ?>
							                </a>
							            </li>

			  			<?php
			  			} else {
		  	    		?>
					  	  	<li class="text-left text-red">
								  <a href="javascript:;" onclick="javascript:rcObj.loadChat('<?php echo $loadChat;?>','<?php echo $type?>',<?php echo $canEdit;?>,<?php echo $hasRC;?>, contextData )" class=" <?php echo $chatColor;?>" id="open-rocketChat">
								  		<i class="fa fa-plus-circle text-red"></i> <?php echo Yii::t("common","New Channel") ?>
								  </a>
							</li>

			  			<?php } ?>
			  			
						        </ul>
						    </li>
						</ul>
					</div>    

				<?php } else { ?>

				<button type="button" onclick="javascript:rcObj.loadChat('<?php echo $loadChat;?>','<?php echo $type?>',<?php echo $canEdit;?>,<?php echo $hasRC;?>, contextData )" class="btn btn-default bold hidden-xs <?php echo $chatColor;?>" 
			  		  id="open-rocketChat" style="border-right:0px!important;">
			  		<i class="fa fa-comments elChatNotifs"></i> <?php echo Yii::t("cooperation", "Chat"); 
			  		?>
				</button>

				<?php } ?>
		  <?php } ?>

		  <?php if(@Yii::app()->session["userId"])
		  		if( $type == Organization::COLLECTION || $type == Project::COLLECTION ){ ?>
		  <button type="button" class="btn btn-default bold hidden-xs letter-turq" data-toggle="modal" data-target="#modalCoop" 
		  		  id="open-co-space" style="border-right:0px!important;">
		  		<i class="fa fa-connectdevelop"></i> <?php echo Yii::t("cooperation", "CO-space"); ?>
		  </button>
		  <?php } ?>


		  <?php if(@Yii::app()->session["userId"])
		  		if( ($type!=Person::COLLECTION && ((@$edit && $edit) || (@$openEdition && $openEdition))) || 
		  			($type==Person::COLLECTION && (string)$element["_id"]==@Yii::app()->session["userId"])){ ?>

			
		  
		  <button type="button" class="btn btn-default bold letter-green hidden-xs" 
		  		  id="open-select-create" style="border-right:0px!important;">
		  		<i class="fa fa-plus-circle fa-2x"></i> <?php //echo Yii::t("common", "Créer") ?>
		  </button>
		  <?php } ?>
		</div>
		
		
		<div class="btn-group pull-right">
			<?php if(isset(Yii::app()->session["userId"]) && $typeItem!=Person::COLLECTION){ ?>
		  		<button 	class='btn btn-default bold btn-share letter-green' style="border:0px!important;"
							data-ownerlink='share' data-id='<?php echo $element["_id"]; ?>' data-type='<?php echo $typeItem; ?>' 
	                    	data-isShared='false'>
	                    	<i class='fa fa-share'></i> <span class="hidden-xs"><?php echo Yii::t("common","Share") ?></span>
	          	</button>
	         <?php } ?>
			<?php 
			$role = Role::getRolesUserId(@Yii::app()->session["userId"]) ; 
			if($element["_id"] == Yii::app()->session["userId"] && 
			   (Role::isSuperAdmin($role) || Role::isSourceAdmin($role) )) { ?>
			  <!--<button type="button" class="btn btn-default bold lbh" data-hash="#admin">
			  	<i class="fa fa-user-secret"></i> <span class="hidden-xs hidden-sm hidden-md">Admin</span>
			  </button>-->
			
			  <button type="button" class="btn btn-default bold tooltips" data-placement="left" 
						data-original-title="super admin" id="btn-superadmin">
			  	<i class="fa fa-grav letter-red"></i> <span class="hidden-xs hidden-sm hidden-md"></span>
			  </button>
			  <?php } ?>
			<ul class="nav navbar-nav" id="paramsMenu">
				<li class="dropdown">
					<button type="button" class="btn btn-default bold">
						<?php if(@Yii::app()->session["userId"] && $edit==true){ ?>
			  			<i class="fa fa-cogs"></i> <span class="hidden-xs hidden-sm"><?php echo Yii::t("common", "Settings"); ?>
			  			<?php }else{ ?>
			  			<i class="fa fa-chevron-down"></i>
			  			<?php } ?>
			  			</span>
			  		</button> 
			  		<!--<button type="button" class="btn btn-default bold">
						<i class="fa fa-chevron-down"></i>
			  		</button>-->
			  		<ul class="dropdown-menu arrow_box menu-params">
	                	<?php  
	            		if(@Yii::app()->session["userId"] && $edit==true){ 

	            			if($type ==Person::COLLECTION){ ?>

		            			<li class="text-left">
									<a href="#settings.page.myAccount" class="lbh bg-white">
										<i class="fa fa-cogs"></i> <?php echo Yii::t("common", "My parameters") ; ?>
									</a>
								</li>

					<?php 	} else {  ?>
		            			<li class="text-left">
									<a href="#settings.page.confidentialityCommunity?slug=<?php echo $element['slug'] ; ?>" id="" class="lbh bg-white ">
										<i class="fa fa-cogs"></i> <?php echo Yii::t("common", "Confidentiality params"); ?>
										</a>
								</li>

								<li class="text-left">
									<a href="#settings.page.notificationsCommunity?slug=<?php echo $element['slug'] ; ?>" class="lbh bg-white">
										<i class="fa fa-bell"></i> <?php echo Yii::t("common", "Notifications preferences"); ?>
									</a>
								</li>

								<li class="text-left">
									<a href="javascript:;" onclick="updateSlug();" id="" class="bg-white">
										<i class="fa fa-id-badge"></i> <?php echo Yii::t("common", "Edit slug"); ?>
										</a>
					            </li>

					            <li class="text-left">
									<a href='javascript:' id="downloadProfil">
										<i class='fa fa-download'></i> <?php echo Yii::t("common", "Download your profil") ?>
									</a>
								</li>

					<?php 	}

						} ?>
						
						<li>
							<a href="javascript:;" onclick="showDefinition('qrCodeContainerCl',true)">
								<i class="fa fa-qrcode"></i> <?php echo Yii::t("common","QR Code") ?>
							</a>
						</li>

			  			<?php 

			  			if($type !=Person::COLLECTION){ 

			  				if($openEdition==true){ ?>
				  				
				  				<li class="text-left">
									<a href="javascript:;" class="btn-show-activity">
										<i class="fa fa-history"></i> <?php echo Yii::t("common","History")?> 
									</a>
								</li>
				<?php 		} 
						} else { 

							if(@Yii::app()->session["userId"] && $edit==true){ ?>

				            	<li class="text-left">
									<a href='javascript:;' onclick='rcObj.settings();' >
										<i class='fa fa-comments'></i> <?php echo Yii::t("common","Chat Settings"); ?>
									</a>
					            </li>

								<li class="text-left">
					               	<a href='javascript:;' onclick='loadMD()' >
										<i class='fa fa-file-text-o'></i> <?php echo Yii::t("common","Markdown Version"); ?>
									</a>
					            </li>
								
								<li class="text-left">
									<a href='javascript:;' onclick='loadMindMap()' >
										<i class='fa fa-sitemap'></i> <?php echo Yii::t("common","Mindmap View"); ?>
									</a>
					            </li>
					<?php 	}

				            if(	Preference::showPreference($element, $type, "directory", Yii::app()->session["userId"])) {
		               			// $urlNetwork = Element::getUrlMyNetwork((string)$element["_id"], $type); ?>

		               			<!-- <li class="text-left">
					               	<a href='<?php //echo $urlNetwork; ?>' target='_blanck'>
										<i class='fa fa-map'></i> <?php //echo Yii::t("common","My network"); ?>
									</a>
					            </li> -->
					<?php 	} 
			        	} ?>
						<li class="text-left">
							<a href='javascript:;' onclick='co.graph()' >
								<i class='fa fa-share-alt'></i> <?php echo Yii::t("common","Graph View"); ?>
							</a>
						</li>
						<li class="text-left">
							<a href='javascript:;' onclick="javascript:window.print();" >
								<i class='fa fa-print'></i> <?php echo Yii::t("home","Print out") ?>
							</a>
						</li>

						<?php 
						if ( Authorisation::canDeleteElement( (String)$element["_id"], $type, Yii::app()->session["userId"]) && 
							!@$deletePending && 
							!empty(Yii::app()->session["userId"]) && 
							$type != Person::COLLECTION	) { ?>

				  			<li class="text-left">
								<a href="javascript:;" id="btn-delete-element" class="bg-white text-red" data-toggle="modal">
									<i class="fa fa-trash"></i> 
									<?php echo Yii::t("common", "Delete {what}", array("{what}"=> Yii::t("common","this ".Element::getControlerByCollection($type)))); ?>
								</a>
				            </li>

			            <?php } ?>
			  		</ul>
		  		</li>
		  	</ul>
		</div>
	</div>

	
	<!-- <div id="div-reopen-menu-left-container" class="col-xs-12 col-sm-3 col-md-3 col-lg-2 hidden"> -->
		<!-- <button id="reopen-menu-left-container" class="btn btn-default">
			<i class="fa fa-arrow-left"></i> <span class="hidden-sm hidden-xs"> Retour au </span>menu principal
		</button> -->
		<!-- <button id="refresh-coop-rooms" class="btn btn-default pull-right">
			<i class="fa fa-refresh"></i>
		</button> -->
		<!-- <hr>
		<h4 class="letter-turq"><i class="fa fa-connectdevelop"></i> Espaces co<span class="hidden-sm">opératifs</span></h4>
 -->
		
	    

	<?php //render of modal for coop spaces 
		$params = array(  "element" => @$element, 
                            "type" => @$type, 
                            "edit" => @$edit,
                            "thumbAuthor"=>@$thumbAuthor,
                            "openEdition" => $openEdition,
                            "iconColor" => $iconColor
                        );

    	$this->renderPartial('dda.views.co.pod.modals', $params ); 
    ?>

	<div id="menu-left-container" class="col-xs-12 col-sm-3 col-md-3 col-lg-2 profilSocial hidden-xs" 
			style="margin-top:40px;padding: 5px;">  		
	    <?php $params = array(  "element" => @$element, 
                                "type" => @$type, 
                                "edit" => @$edit,
                                "isLinked" => @$isLinked,
                                "countNotifElement"=>@$countNotifElement,
                                "invitedMe" => @$invitedMe,
                                "openEdition" => $openEdition,
                                "linksBtn" => $linksBtn,
                                "themeParams"=>@Yii::app()->session['paramsConfig']
                                );

	    	$this->renderPartial('co2.views.pod.menuLeftElement', $params ); 
	    ?>
	</div>
	<?php $addElement=array(
        Organization::TYPE_GROUP => array(
            "label"=>Yii::t("common","Group"),
            "icon"=>"fa-circle-o",
            "formType"=>"organization",
            "type"=>Organization::COLLECTION,
            "formSubType"=>Organization::TYPE_GROUP,
            "color"=> "turq",
            "description"=>Yii::t("form","Create a group<br>Share your interest<br>Speak Diffuse Have fun"),           
            "typeAllow"=>array(Person::COLLECTION)        
        ),
        Organization::TYPE_NGO => array(
            "label"=>Yii::t("common","NGO"),
            "icon"=>"fa-group",
            "formType"=>"organization",
            "type"=>Organization::COLLECTION,
            "formSubType"=>Organization::TYPE_NGO,
            "color"=>"green",
            "description"=>Yii::t("form", "Make visible your NGO<br>Manage the community<br>Share your news"),           
            "typeAllow"=>array(Person::COLLECTION)
        ),
        Organization::TYPE_BUSINESS => array(
            "label"=>Yii::t("common","Local business"),
            "icon"=>"fa-industry",
            "formType"=>"organization",
            "type"=>Organization::COLLECTION,
            "formSubType"=>Organization::TYPE_BUSINESS,
            "color"=>"azure",
            "description"=>Yii::t("form", "Make visible your company<br>Find new customer<br>Manage your contacts"),           
            "typeAllow"=>array(Person::COLLECTION)
        ),
        Organization::TYPE_GOV => array(
            "label"=>Yii::t("common","Government Organization"),
            "icon"=>"fa-university",
            "formType"=>"organization",
            "formSubType"=>Organization::TYPE_GOV,
            "color"=> "red",
            "description"=>Yii::t("form", "Town hall, schools, etc...<br>Share your news<br>Share events"),           
            "typeAllow"=>array(Person::COLLECTION)
        ),
        "contacts" => array(
            "label"=>Yii::t("common","Contact"),
            "icon"=>"fa-envelope",
            "formType"=>"contactPoint",
            "color"=> "blue",
            "description"=>Yii::t("form", "Define roles of everyone<br>Communicate easily<br>Internal and external"),
            "typeAllow"=>array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION)
        ),
        Project::COLLECTION => array(
            "label"=>Yii::t("common","Project"),
            "icon"=>Project::ICON,
            "formType"=>"project",
            "color"=> "purple",
            "description"=>Yii::t("form", "Make visible a project<br>Find support<br>Build a community"),
            "typeAllow"=>array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION)
        ),
        Event::COLLECTION => array(
            "label"=>Yii::t("common","Event"),
            "icon"=>Event::ICON,
            "formType"=>"event",
            "description"=> Yii::t("form", "Diffuse an event<br>Invite attendees<br>Communicate to your network"),
            "color"=> "orange",
            "typeAllow"=>array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION)
        ),
        Classified::COLLECTION => array(
            "label"=>Yii::t("common","Classified"),
            "icon"=>Classified::ICON,
            "formType"=>"classifieds",
            "color"=> "azure",
            "description"=>Yii::t("form","Create a classified ad<br>To share To give To sell To rent<br>Material Property Job"),
            "typeAllow"=>array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION)
        ),
        Classified::TYPE_RESSOURCES => array(
            "label"=>Yii::t("common","Ressource"),
            "icon"=>Classified::ICON_RESSOURCES,
            "formType"=>"ressources",
            "color"=> "vine",
            "description"=>"Partager des ressources<br>des outils, des documents<br> des compétences et des besoins"
        ),
        Classified::TYPE_JOBS => array(
            "label"=>Yii::t("common","Jobs"),
            "icon"=>Classified::ICON_JOBS,
            "formType"=>"jobs",
            "color"=> "yellow-k",
            "description"=>"Ajouter les stages, les formations ou les offres d'emploi que vous proposez"
        
        ),
        Poi::COLLECTION => array(
            "label"=>Yii::t("common","Point of interest"),
            "icon"=>Poi::ICON,
            "formType"=>"poi",
            "color"=> "green-k",
            "description"=> Yii::t("form","Make visible an interesting place<br>Contribute to the collaborative map<br>Highlight your territory")
        )
    );
    //Filtering button add element if custom
    if(@$addConfig){
        foreach($addElement as $key=>$v)
            if(!@$addConfig[$key] && (!@$v["type"] || !@$addConfig[$v["type"]])) unset($addElement[$key]);
    } ?>
	<div class="col-xs-12 col-md-9 col-sm-9 col-lg-9 padding-50 margin-top-50 links-main-menu hidden" 
		 id="div-select-create">
		<div class="col-md-12 col-sm-12 col-xs-12 padding-15 shadow2 bg-white ">
	       
	       <h4 class="text-center margin-top-15" style="">
	       	<img class="img-circle" src="<?php echo $thumbAuthor; ?>" height=30 width=30 style="margin-top:-10px;">
	       	<a class="btn btn-link pull-right text-dark" id="btn-close-select-create" style="margin-top:-10px;">
	       		<i class="fa fa-times-circle fa-2x"></i>
	       	</a>
	       	<span class="name-header"><?php echo @$element["name"]; ?></span>
	       	<br>
	       	<i class="fa fa-plus-circle"></i> <?php echo Yii::t("form","Create content link to this page") ?>
	       	<br>
	       	<small><?php echo Yii::t("form","What kind of content will you create ?") ?></small>
	       </h4>

	        <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
	        <?php foreach($addElement as $key => $v){
	        	if(!@$v["typeAllow"] || in_array($type, $v["typeAllow"])){ ?>
	        		<button data-form-type="<?php echo $v["formType"] ?>" 
	        			<?php if(@$v["formSubType"]){ ?>
	        			data-form-subtype="<?php echo $v["formSubType"] ?>" 
	        			<?php } ?>
	        			data-dismiss="modal"
		                class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-<?php echo $v["color"] ?>">
		            	<h6><i class="fa <?php echo @$v["icon"] ?> fa-2x bg-<?php echo @$v["color"] ?>"></i><br> <?php echo $v["label"] ?></h6>
		            	<small><?php echo $v["description"] ?></small>
		        	</button>
	        	<?php }
	        }
	        ?>
	    </div>
    </div>


	<section class="col-xs-12 col-md-9 col-sm-9 col-lg-10 no-padding central-section pull-right">
		<?php    
			$marginCentral="";
			$classDescH="hidden"; 
			$classBtnDescH="<i class='fa fa-angle-down'></i> ".Yii::t("common","show description"); 
				
			if(!isset($linksBtn["isFollowing"]) && !isset($linksBtn["isAdmin"]) )
				$classDescH = "";
			
			if(@$element["custom"] && @$element["custom"]["pubTpl"])
				echo $this->renderPartial($element["custom"]["pubTpl"], array("central"=>true));
	
			if($typeItem != Person::COLLECTION){ 
		?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-xs" style="margin-top:30px;">
				<!-- <span id="desc-event" class="margin-top-10 <?php echo $classDescH; ?>">
					<b><i class="fa fa-angle-down"></i> 
					<i class="fa fa-info-circle"></i> <?php echo Yii::t("common","Main description") ?></b>
					<hr>
					<span id="descProfilsocial">
						<?php echo 	@$element["description"] && @$element["description"]!="" ? 
									@$element["description"] : 
									"<span class='label label-info'> ".Yii::t("common","No description registred")."</span>"; ?>
					</span>
				</span> -->
			</div>
			<!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-xs">
				
	    		<button class="btn btn-link btn-xs pull-right" id="btn-hide-desc">
					<?php echo $classBtnDescH; ?>
				</button>
				
				<br>
				<hr>
			</div> -->
		<?php }else{ $marginCentral="50"; } ?>

		<!-- Permet de faire le convertion en HTML -->
		<span id="descriptionMarkdown" name="descriptionMarkdown"  class="hidden" ><?php echo (!empty($element["description"])) ? $element["description"] : ""; ?></span>

	    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 margin-top-<?php echo $marginCentral; ?>" id="central-container">
		</div>

		<?php $this->renderPartial('co2.views.pod.qrcode',array(		"type" => @$type,
																"name" => @$element['name'],
																"address" => @$address,
																"address2" => @$address2,
																"email" => @$element['email'],
																"url" => @$element["url"],
																"tel" => @$tel,
																"img"=>@$element['profilThumbImageUrl']));
																?>

		<div class="col-md-3 col-lg-3 hidden-sm hidden-xs margin-top-<?php echo $marginCentral; ?>" 
			 id="notif-column">
			<?php if(@$element["custom"] && @$element["custom"]["pubTpl"])
				echo $this->renderPartial($element["custom"]["pubTpl"]); ?>
	
		</div>
	</section>

	<!-- <section class="col-xs-12 col-md-9 col-sm-9 col-lg-9 no-padding form-contact-mail pull-right"> -->
		<?php 
			if(Yii::app()->params["CO2DomainName"] != "kgougle"){ 
				$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
				$this->renderPartial($layoutPath.'forms.'.Yii::app()->params["CO2DomainName"].'.formContact', 
									array("element"=>@$element));
			} 
		?>
	<!-- </section> -->
</div>	

<?php 
	$this->renderPartial('co2.views.pod.confidentiality',
			array(  "element" => @$element, 
					"type" => @$type, 
					"edit" => @$edit,
					"controller" => $controller,
					"openEdition" => $openEdition,
				) );
?>

<?php	$cssAnsScriptFilesModule = array(
		'/js/default/profilSocial.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
?>

<script type="text/javascript">
	var contextData = <?php echo json_encode( Element::getElementForJS(@$element, @$type) ); ?>; 
	mylog.log("init contextData", contextData);
    var params = <?php echo json_encode(@$params); ?>; 
    var edit =  ( ( '<?php echo (@$edit == true); ?>' == "1") ? true : false );
	var openEdition = ( ( '<?php echo (@$openEdition == true); ?>' == "1") ? true : false );
    var dateLimit = 0;
    var typeItem = "<?php echo $typeItem; ?>";
    var liveScopeType = "";
    var subView="<?php echo @$_GET['view']; ?>";
    var navInSlug=false;
   	var pageConfig=<?php echo json_encode($pageConfig) ?>;
   	if(notNull(pageConfig) && typeof pageConfig.initView != "undefined" && subView=="") subView=pageConfig.initView;
    if(typeof contextData.slug != "undefined")
     	navInSlug=true;
   
	var hashUrlPage= ( (typeof contextData.slug != "undefined") ? 
						"#@"+contextData.slug : 
						"#page.type."+contextData.type+".id."+contextData.id);
    
    if(location.hash.indexOf("#page")>=0){
    	strHash="";
    	if(location.hash.indexOf(".view")>0){
    		hashPage=location.hash.split(".view");
    		strHash=".view"+hashPage[1];
    	}
    	replaceSlug=true;
    	history.replaceState("#page.type."+contextData.type+".id."+contextData.id, "", hashUrlPage+strHash);
    	//location.hash=;
    }
    
    var cropResult;
    var idObjectShared = new Array();

    var personCOLLECTION = "<?php echo Person::COLLECTION; ?>";
	var dirHash="<?php echo @$_GET['dir']; ?>";
	var key="<?php echo @$_GET['key']; ?>";
	var folderKey="<?php echo @$_GET['folder']; ?>";
	var roomId = "<?php echo @$_GET['room']; ?>";
	var proposalId = "<?php echo @$_GET['proposal']; ?>";
	var resolutionId = "<?php echo @$_GET['resolution']; ?>";
	var actionId = "<?php echo @$_GET['action']; ?>";
	var isLiveNews = "";
	var connectTypeElement="<?php echo Element::$connectTypes[$type] ?>";
	
	if(contextData.type == "citoyens") var currentRoomId = "";

	jQuery(document).ready(function() {
		bindButtonMenu();
		if(typeof contextData.name !="undefined")
			setTitle("", "", contextData.name);
		inintDescs();
		if( contextData.type == "events")
			$(".createProjectBtn").hide()
		else 
			$(".createProjectBtn").show()

		$(".hide-"+contextData.type).hide();
		getProfilSubview(subView,dirHash, key, folderKey);
		
		//loadActionRoom();

		KScrollTo("#topPosKScroll");
		initDateHeaderPage(contextData);
		getContextDataLinks();
		if(typeof contextData.links != "undefined" && typeof rolesList != "undefined")
			pushListRoles(contextData.links);
		initMetaPage(contextData.name,contextData.shortDescription,contextData.profilImageUrl);
		//Sig.showMapElements(Sig.map, mapElements);
		var elemSpec = dyFInputs.get("<?php echo $type?>");
		buildQRCode( elemSpec.ctrl ,"<?php echo (string)$element["_id"]?>");
		
	});

	function initMetaPage(title, description, image){
		if(title != ""){
			$("meta[name='title']").attr("content",title);
			$("meta[property='og:title']").attr("content",title);
		}
		if(description != ""){
			$("meta[name='description']").attr("content",description);
			$("meta[property='og:description']").attr("content",description);
		}
		if(image != ""){
			$("meta[name='image']").attr("content",baseUrl+image);
			$("meta[property='og:image']").attr("content",baseUrl+image);
		}
	}
	function getProfilSubview(sub, dir,key, folderId){ console.log("getProfilSubview", sub, dir);
		if(sub!=""){
			if(sub=="gallery")
				loadGallery(dir, key, folderKey);
			if(sub=="library")
				loadLibrary();
			else if(sub=="notifications")
				loadNotifications();
			else if(sub.indexOf("chart") >= 0){
				loadChart();
			}
			else if(sub=="mystream")
				loadNewsStream(false);
			else if(sub=="history")
				loadHistoryActivity();
			else if(sub=="directory")
				loadDataDirectory(dir,null,edit);
			else if(sub=="editChart")
				loadEditChart();
			else if(sub=="detail")
				loadDetail();
			else if(sub=="urls")
				loadUrls();
			else if(sub=="chat" && userId)
				rcObj.loadChat("","citoyens", true, true);
			else if(sub=="contacts")
				loadContacts();
			else if(sub=="md")
				loadMD();
			else if(sub=="settings")
				loadSettings();
			else if(sub=="coop"){
				onchangeClick=false;
				uiCoop.loadCoop(roomId, proposalId, resolutionId, actionId);
			}
			else if(sub=="networks"){
				loadNetworks();
			}
			else if(sub=="curiculum"){
				loadCuriculum();
			}
			
		} else
			loadNewsStream(false);
	}

</script>
