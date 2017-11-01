<?php 
	HtmlHelper::registerCssAndScriptsFiles( 
		array(  '/css/onepage.css',
				'/vendor/colorpicker/js/colorpicker.js',
				'/vendor/colorpicker/css/colorpicker.css',
				'/css/news/index.css',	
				'/css/timeline2.css',
				//'/css/circle.css',	
				'/css/default/directory.css',	
				'/js/comments.js',
				'/css/profilSocial.css',
		) , 
	Yii::app()->theme->baseUrl. '/assets');



	$cssAnsScriptFilesTheme = array(
		"/plugins/jquery-cropbox/jquery.cropbox.css",
		"/plugins/jquery-cropbox/jquery.cropbox.js",
		// SHOWDOWN
		'/plugins/showdown/showdown.min.js',
		//MARKDOWN
		'/plugins/to-markdown/to-markdown.js',
		'/plugins/jquery.qrcode/jquery-qrcode.min.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
	
	$id = $_GET['id'];
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
    if(@Yii::app()->params["front"]) $front = Yii::app()->params["front"];
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


#ajax-modal .modal-content,
#formContact .modal-content{
	background-color: rgba(0,0,0,0.6);
}
#ajax-modal .container,
#formContact .container{
	background-color: white;
	border-radius: 4px;
}
#ajax-modal.portfolio-modal,
#formContact.portfolio-modal {
	background-color: transparent;
}
#ajax-modal .close-modal .lr,
#ajax-modal .close-modal .rl,
#formContact .close-modal .lr,
#formContact .close-modal .rl{
	background-color: white;
}

#btn-show-activity-onmap{
    width:100%;
}
</style>

<?php 
	$auth = Authorisation::canParticipate(Yii::app()->session['userId'], $type, (string)$element["_id"]);

	if (Authorisation::canDeleteElement((String)$element["_id"], $type, Yii::app()->session["userId"]) && !@$deletePending) 
		$this->renderPartial('../element/confirmDeleteModal'); ?>
<?php 
	if (@$element["status"] == "deletePending" && Authorisation::isElementAdmin((String)$element["_id"], $type, Yii::app()->session["userId"])) $this->renderPartial('../element/confirmDeletePendingModal', array(	"element"=>$element)); ?>

    <!-- <section class="col-md-12 col-sm-12 col-xs-12 header" id="header"></section> -->
<div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12 no-padding">	
    <!-- Header -->
    <section class="col-md-12 col-sm-12 col-xs-12" id="social-header" 
    	<?php if (!@$element["profilBannereUrl"] || (@$element["profilBannereUrl"] && empty($element["profilBannereUrl"]))){ ?> 
    		style="background-color: rgba(0,0,0,0.5);"
    	<?php } ?>>
        <div id="topPosKScroll"></div>
    	<?php if(@$edit==true && false) { ?>
    	<button class="btn btn-default btn-sm pull-right margin-right-15 margin-top-70 hidden-xs btn-edit-section" 
    			data-id="#header">
	        <i class="fa fa-cog"></i>
	    </button>
	    <?php } ?>
        
        <?php 
	    	$this->renderPartial('../element/banner', 
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
				
				$this->renderPartial('../pod/fileupload', 
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

			<?php if(@Yii::app()->session["userId"]){ ?>
			<div class="blockUsername">
                	<?php $this->renderPartial('../element/linksMenu', 
            			array("linksBtn"=>$linksBtn,
            					"elementId"=>(string)$element["_id"],
            					"elementType"=>$type,
            					"elementName"=> $element["name"],
            					"openEdition" => $openEdition) 
            			); 
            		?>
			</div>
			<?php } ?>
		</div>
    </section>
    
    <div class="col-md-9 col-sm-9 col-lg-10 col-xs-12 pull-right sub-menu-social no-padding">

    	<div class="btn-group inline">

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
			  <div class="col-lg-1 col-md-2 col-sm-2 pull-left no-padding">
	    	  	<div class="text-left padding-left-15" id="second-name-element">
					<span id="nameHeader">
						<h5 class="elipsis"><?php echo @$element["name"]; ?></h5>
					</span>	
				</div>
	    	  </div>
    	  </div>
    	  <?php if(@Yii::app()->session["userId"] && 
    			 $type==Person::COLLECTION && 
    			 (string)$element["_id"]==Yii::app()->session["userId"]){ 

    			$iconNewsPaper="user-circle"; 
    	  ?>
		  <button type="button" class="btn btn-default bold hidden-xs btn-start-newsstream">
		  		<i class="fa fa-rss"></i> <?php echo Yii::t("common","News stream<span class='hidden-sm'></span>") ?>
		  </button>

		  <?php } else {
		  		  $iconNewsPaper="rss"; 
		  		}
		  ?>

		  <button type="button" class="btn btn-default bold hidden-xs btn-start-mystream">
		  		<i class="fa fa-<?php echo $iconNewsPaper ?>"></i> <?php echo Yii::t("common","Newspaper"); ?>
		  </button>

		  <?php if((@Yii::app()->session["userId"] && $isLinked==true) || @Yii::app()->session["userId"] == $element["_id"]){ ?>
		  <button type="button" class="btn btn-default bold hidden-xs btn-start-notifications hidden">
		  	<i class="fa fa-bell"></i> 
		  	<span class="hidden-xs hidden-sm">
		  		<?php if (@Yii::app()->session["userId"] == $element["_id"]) echo Yii::t("common","My notif<span class='hidden-md'>ication</span>s"); else echo Yii::t("common","Notif<span class='hidden-md'>ication</span>s"); ?>
		  	</span>
		  	<span class="badge notifications-countElement <?php if(!@$countNotifElement || (@$countNotifElement && $countNotifElement=="0")) echo 'badge-transparent hide'; else echo 'badge-success'; ?>">
		  		<?php echo @$countNotifElement ?>
		  	</span>
		  </button>
		  <?php } ?>

		  <script type="text/javascript">
	  	  	
			   /*alert( "x<?php echo (@$edit && $edit) || (@$openEdition && $openEdition) ?>"+
			           "x<?php echo Authorisation::canEditItem(Yii::app()->session['userId'], $type, $id);  ?>"+
			           "x<?php echo Link::isLinked((string)$element["_id"], $type, Yii::app()->session["userId"]);   ?>");
    			*/
	  	  </script>

		  <?php if(@Yii::app()->session["userId"] && Yii::app()->params['rocketchatEnabled'] )
	  		if( ($type!=Person::COLLECTION && ((@$edit && $edit) || (@$openEdition && $openEdition)) ) || 
	  			($type==Person::COLLECTION) ||
	  			//admins can create rooms
	  			( Authorisation::canEditItem(Yii::app()->session['userId'], $type, $id) ) ||
	  			//simple members can join only when admins had created
	  			( @$element["hasRC"] && Link::isLinked((string)$element["_id"],$type,Yii::app()->session["userId"]))  )
	  			{
	  				if(@$element["slug"])
						//todo : elements members of
	  					$loadChat = $element["slug"];
	  				else
	  					$createSlugBeforeChat=true;
	  				//todo : elements members of
	  				$loadChat = $element["name"];
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
	  	  ?>
	  	  
	  	  <?php /*if(@$createSlugBeforeChat){ ?>
	  	  	<button type="button" onclick="javascript:createSlugBeforeChat('<?php echo $type?>',<?php echo $canEdit;?>,<?php echo $hasRC;?> )" class="btn btn-default bold hidden-xs <?php echo $chatColor;?>" 
		  		  id="open-rocketChat" style="border-right:0px!important;">
		  		<i class="fa fa-comments elChatNotifs"></i> Messagerie 
		  	</button>
	  	  <?php } else{ */?>
			  <button type="button" onclick="javascript:rcObj.loadChat('<?php echo $loadChat;?>','<?php echo $type?>',<?php echo $canEdit;?>,<?php echo $hasRC;?> )" class="btn btn-default bold hidden-xs <?php echo $chatColor;?>" 
			  		  id="open-rocketChat" style="border-right:0px!important;">
			  		<i class="fa fa-comments elChatNotifs"></i> Messagerie 
			  </button>
		  <?php //} ?>
		  
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

		  <?php /* Links in new TAB
		  if(@Yii::app()->session["userId"])
  		if( ($type!=Person::COLLECTION && ((@$edit && $edit) || (@$openEdition && $openEdition))) || 
  			($type==Person::COLLECTION) ||
  			(Link::isLinked((string)$element["_id"],$type,Yii::app()->session["userId"])))
  			{ 
  				//todo : elements members of
  				$loadChat = '/'.$this->module->id.'/rocketchat/chat/name/'.$element["name"].'/type/'.$type;
  				if($type == Person::COLLECTION)
  				{
  				 	$loadChat = '/'.$this->module->id.'/rocketchat/chat/name/'.$element["username"].'/type/'.$type;
  					if( (string)$element["_id"]==@Yii::app()->session["userId"] )
  						$loadChat = '/'.$this->module->id.'/rocketchat';
  				}
  				?> 
			  	<a href="<?php echo $loadChat;?>" target="_blanck" class="btn btn-default bold letter-red hidden-xs" style="border-right:0px!important;">
			  		<i class="fa fa-comments fa-2x"></i> 
			  	</a>
			<?php } */?>
		</div>
		
		<div class="btn-group pull-right">
	  	
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

		</div>

		<div class="btn-group pull-right" id="paramsMenu">
			<ul class="nav navbar-nav">
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
	                	<?php $this->renderPartial('../element/linksMenu', 
	            			array("linksBtn"=>$linksBtn,
	            					"elementId"=>(string)$element["_id"],
	            					"elementType"=>$type,
	            					"elementName"=> $element["name"],
	            					"openEdition" => $openEdition,
	            					"xsView"=>true) 
	            			); 
	            		?>
	            		<?php if(@Yii::app()->session["userId"] && $edit==true){ ?>
			  				<li class="text-left">
				               	<a href="javascript:;" id="editConfidentialityBtn" class="bg-white">
				                    <i class="fa fa-cogs"></i> <?php echo Yii::t("common", "Confidentiality params"); ?>
				                </a>
				            </li>
			            <?php } ?>
						<?php if(@Yii::app()->session["userId"] && $edit==true){ ?>
			  				<li class="text-left">
				               	<a href="javascript:;" onclick="updateSlug();" id="" class="bg-white">
				                    <i class="fa fa-id-badge"></i> <?php echo Yii::t("common", "Edit slug"); ?>
				                </a>
				            </li>
			            <?php } ?>
						
						<li>
							<a href="javascript:;" onclick="showDefinition('qrCodeContainerCl',true)">
								<i class="fa fa-qrcode"></i> <?php echo Yii::t("common","QR Code") ?>
							</a>
						</li>

			  			<?php if($type !=Person::COLLECTION){ ?>

			  				<?php if($openEdition==true){ ?>
				  				<li class="text-left">
									<a href="javascript:;" class="btn-show-activity">
										<i class="fa fa-history"></i> <?php echo Yii::t("common","History")?> 
									</a>
								</li>
							<?php } ?>

							<?php if (Authorisation::canDeleteElement((String)$element["_id"], $type, Yii::app()->session["userId"]) && !@$deletePending) { ?>
				  			<li class="text-left">
				               	<a href="javascript:;" id="btn-delete-element" class="bg-white text-red" data-toggle="modal">
				                    <i class="fa fa-trash"></i> 
				                    <?php echo Yii::t("common", "Delete {what}", 
				                    					array("{what}"=> 
				                    						Yii::t("common","this ".Element::getControlerByCollection($type)))); 
				                    ?>
				                </a>
				            </li>
				            <?php } ?>
			            <?php } else { ?>
			            	<?php if(@Yii::app()->session["userId"] && $edit==true){ ?>

			            	<li class="text-left">
				               	<a href='javascript:;' onclick='rcObj.settings();' >
									<i class='fa fa-comments'></i> <?php echo Yii::t("common","Chat Settings"); ?>
								</a>
				            </li>

							<li class="text-left">
								<a href='javascript:' id="downloadProfil">
									<i class='fa fa-download'></i> <?php echo Yii::t("common", "Download your profil") ?>
								</a>
							</li>
							
							<li class="text-left">
				               	<a href='javascript:;' id="btn-update-password" class='text-red'>
									<i class='fa fa-key'></i> <?php echo Yii::t("common","Change password"); ?>
								</a>
				            </li>

				            <?php } ?>
			            <?php } ?>
			  		</ul>
		  		</li>
		  	</ul>
		</div>

	  	<?php if(isset(Yii::app()->session["userId"]) && $typeItem!=Person::COLLECTION){ ?>
			<div class="btn-group pull-right">
			  	<button 	class='btn btn-default bold btn-share pull-right  letter-green' style="border:0px!important;"
	                    	data-ownerlink='share' data-id='<?php echo $element["_id"]; ?>' data-type='<?php echo $typeItem; ?>' 
	                    	data-isShared='false'>
	                    	<i class='fa fa-share'></i> <span class="hidden-xs"><?php echo Yii::t("common","Share") ?></span>
	          	</button>
	        </div>
	    <?php } ?>
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

    	$this->renderPartial('../cooperation/pod/modals', $params ); 
    ?>

	<div id="menu-left-container" class="col-xs-12 col-sm-3 col-md-3 col-lg-2 profilSocial hidden-xs" 
			style="margin-top:40px;">  		
	    <?php $params = array(  "element" => @$element, 
                                "type" => @$type, 
                                "edit" => @$edit,
                                "isLinked" => @$isLinked,
                                "countNotifElement"=>@$countNotifElement,
                                "invitedMe" => @$invitedMe,
                                "openEdition" => $openEdition,
                                );

	    	$this->renderPartial('../pod/menuLeftElement', $params ); 
	    ?>
	</div>

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

	        <button data-form-type="event"  data-dismiss="modal"
	                class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-orange">
	            <h6><i class="fa fa-calendar fa-2x bg-orange"></i><br> <?php echo Yii::t("common", "Event") ?></h6>
	            <small><?php echo Yii::t("form", "Diffuse an event<br>Invite attendees<br>Communicate to your network") ?></small>
	        </button>
	        <button data-form-type="classified"  data-dismiss="modal"
	                class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-azure hide-event">
	            <h6><i class="fa fa-bullhorn fa-2x bg-azure"></i><br> <?php echo Yii::t("common", "Classified") ?></h6>
	            <small><?php echo Yii::t("form","Create a classified ad<br>To share To give To sell To rent<br>Material Property Job") ?></small>
	        </button>

	        <button data-form-type="poi"  data-dismiss="modal"
	                class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-green-poi">
	            <h6><i class="fa fa-map-marker fa-2x bg-green-poi"></i><br> <?php echo Yii::t("common", "Point of interest") ?></h6>
	            <small><?php echo Yii::t("form","Make visible an interesting place<br>Contribute to the collaborative map<br>Highlight your territory") ?></small>
	        </button>

	        
	        <!--<button data-form-type="url" data-dismiss="modal"
	                class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-url">
	            <h6><i class="fa fa-link fa-2x bg-url"></i><br> <?php echo Yii::t("common", "URL") ?></h6>
	            <small><?php echo Yii::t("form","Share a link<br>Your favorites websites<br>Important news...") ?></small>
	        </button>-->


	        <button data-form-type="project"  data-dismiss="modal"
	                class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-purple hide-event">
	            <h6><i class="fa fa-lightbulb-o fa-2x bg-purple"></i><br> <?php echo Yii::t("common", "Project") ?></h6>
	            <small><?php echo Yii::t("form", "Make visible a project<br>Find support<br>Build a community") ?></small>
	        </button>

			<button data-form-type="contactPoint"  data-dismiss="modal"
	                class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-blue hide-citoyens">
	            <h6><i class="fa fa-envelope fa-2x bg-blue"></i><br> <?php echo Yii::t("common","Contact") ?></h6>
	            <small><?php echo Yii::t("form", "Define roles of everyone<br>Communicate easily<br>Internal and external") ?></small>
	        </button>

			<div class="section-create-page">
	        
	            <button data-form-type="organization" data-form-subtype="<?php echo Organization::TYPE_GROUP; ?>"  data-dismiss="modal"
	                    class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 letter-turq">
	                <h6><i class="fa fa-circle-o fa-2x bg-turq"></i><br> <?php echo Yii::t("common", "Group") ?></h6>
	                <small><?php echo Yii::t("form","Create a group<br>Share your interest<br>Speak Diffuse Have fun") ?></small>
	            </button>

	            <button data-form-type="organization" data-form-subtype="<?php echo Organization::TYPE_NGO; ?>"  data-dismiss="modal"
	                    class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-green">
	                <h6><i class="fa fa-group fa-2x bg-green"></i><br> <?php echo Yii::t("common", "NGO") ?></h6>
	                <small><?php echo Yii::t("form","Make visible your NGO<br>Manage the community<br>Share your news") ?></small>
	            </button>
	            
	            
	            <button data-form-type="organization" data-form-subtype="<?php echo Organization::TYPE_BUSINESS; ?>"  data-dismiss="modal"
	                    class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-azure">
	                <h6><i class="fa fa-industry fa-2x bg-azure"></i><br> <?php echo Yii::t("common", "Local Business") ?></h6>
	                <small><?php echo Yii::t("form","Make visible your company<br>Find new customer<br>Manage your contacts") ?></small>
	            </button>

	            <button data-form-type="organization" data-form-subtype="<?php echo Organization::TYPE_GOV; ?>"  
	                    data-dismiss="modal"
	                    class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-red">
	                <h6><i class="fa fa-university fa-2x bg-red"></i><br> <?php echo Yii::t("common", "Government Organization") ?></h6>
	                <small><?php echo Yii::t("form","Town hall, schools, etc...<br>Share your news<br>Share events") ?></small>
	            </button>

	        </div>
	    </div>
    </div>


	<section class="col-xs-12 col-md-9 col-sm-9 col-lg-10 no-padding central-section pull-right">
		
		<?php    
			$marginCentral="";
			$classDescH="hidden"; 
			$classBtnDescH="<i class='fa fa-angle-down'></i> ".Yii::t("common","show description"); 
				

		if($typeItem != Person::COLLECTION){ 
		?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-xs" style="margin-top:20px;">
				<span id="desc-event" class="margin-top-10 <?php echo $classDescH; ?>">
					<b><i class="fa fa-angle-down"></i> 
					<i class="fa fa-info-circle"></i> <?php echo Yii::t("common","Main description") ?></b>
					<hr>
					<span id="descProfilsocial">
						<?php echo 	@$element["description"] && @$element["description"]!="" ? 
									@$element["description"] : 
									"<span class='label label-info'> ".Yii::t("common","No description registred")."</span>"; ?>
					</span>
				</span>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-xs">
				<button class="btn btn-link btn-xs pull-right" id="btn-hide-desc">
					<?php echo $classBtnDescH; ?>
				</button>
				<br>
				<hr>
			</div>
		<?php }else{ $marginCentral="50"; } ?>
		<!-- Permet de faire le convertion en HTML -->
		<span id="descriptionMarkdown" name="descriptionMarkdown"  class="hidden" ><?php echo (!empty($element["description"])) ? $element["description"] : ""; ?></span>

	    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 margin-top-<?php echo $marginCentral; ?>" id="central-container">
		</div>

		<?php $this->renderPartial('../pod/qrcode',array(		"type" => @$type,
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
	$this->renderPartial('../pod/confidentiality',
			array(  "element" => @$element, 
					"type" => @$type, 
					"edit" => @$edit,
					"controller" => $controller,
					"openEdition" => $openEdition,
				) );

	//if( $type != Person::COLLECTION)
		$this->renderPartial('../element/addMembersFromMyContacts',
				array(	"type"=>$type, 
						"parentId" => (string)$element['_id'], 
						"members" => @$members));

		$this->renderPartial('../element/invite',
				array(	"type"=>$type, 
						"parentId" => (string)$element['_id'], 
						"members" => @$members));

?>

<?php	$cssAnsScriptFilesModule = array(
		'/js/default/profilSocial.js',
		'/js/cooperation/uiCoop.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
?>

<script type="text/javascript">
	var contextData = <?php echo json_encode( Element::getElementForJS(@$element, @$type) ); ?>; 
	initMetaPage(contextData.name,contextData.shortDescription,contextData.profilImageUrl);
	mylog.log("init contextData", contextData);
    var params = <?php echo json_encode(@$params); ?>; 
    var edit =  ( ( '<?php echo (@$edit == true); ?>' == "1") ? true : false );
	var openEdition = ( ( '<?php echo (@$openEdition == true); ?>' == "1") ? true : false );
    var dateLimit = 0;
    var typeItem = "<?php echo $typeItem; ?>";
    var liveScopeType = "";
    var subView="<?php echo @$_GET['view']; ?>";
    var navInSlug=false;
   
    if(typeof contextData.slug != "undefined")
     	navInSlug=true;
   
    var hashUrlPage= ( (typeof networkParams != "undefined") ? "?src="+networkParams : "" )+
    				 ( (typeof contextData.slug != "undefined") ? "#"+contextData.slug : "#page.type."+contextData.type+".id."+contextData.id);
    
    if(location.hash.indexOf("#page")>=0){
    	strHash="";
    	if(location.hash.indexOf(".view")>0){
    		hashPage=location.hash.split(".view");
    		strHash=".view"+hashPage[1];
    	}
    	replaceSlug=true;
    	history.replaceState("#page.type."+contextData.type+".id."+contextData.id, "", "#"+contextData.slug+strHash);
    	//location.hash=;
    }
    
    var cropResult;
    var idObjectShared = new Array();

    var personCOLLECTION = "<?php echo Person::COLLECTION; ?>";
	var dirHash="<?php echo @$_GET['dir']; ?>";
	var roomId = "<?php echo @$_GET['room']; ?>";
	var proposalId = "<?php echo @$_GET['proposal']; ?>";
	var resolutionId = "<?php echo @$_GET['resolution']; ?>";
	var actionId = "<?php echo @$_GET['action']; ?>";


	jQuery(document).ready(function() {
		bindButtonMenu();
		inintDescs();
		if(typeof contextData.name !="undefined")
			setTitle("", "", contextData.name);

		if( contextData.type == "events")
			$(".createProjectBtn").hide()
		else 
			$(".createProjectBtn").show()

		$(".hide-"+contextData.type).hide();
		getProfilSubview(subView,dirHash);
		
		//loadActionRoom();

		KScrollTo("#topPosKScroll");
		initDateHeaderPage(contextData);
		getContextDataLinks();
		if(typeof contextData.links != "undefined" && rolesList != "undefined")
			pushListRoles(contextData.links);
		
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
	function getProfilSubview(sub, dir){ console.log("getProfilSubview", sub, dir);
		if(sub!=""){
			if(sub=="gallery")
				loadGallery();
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
			else if(sub=="settings")
				loadSettings();
			else if(sub=="coop"){
				loadCoop(roomId, proposalId, resolutionId, actionId);
			}
		} else
			loadNewsStream(true);
	}



function loadCoop(roomId, proposalId, resolutionId, actionId){
	/*console.log("loadCoop", userId);
	if(userId == "") {
		toastr.info("Vous devez êtres connecté pour accéder à cet espace coopératif");
		loadNewsStream();
		return;
	}*/

	roomId 		= (roomId != "") 	 ? roomId 		: null;
	proposalId  = (proposalId != "") ? proposalId 	: null;
	resolutionId  = (resolutionId != "") ? resolutionId 	: null;
	actionId 	= (actionId != "") 	 ? actionId 	: null;

	toastr.info(trad["processing"]);
	
	uiCoop.startUI(false);
	
	setTimeout(function(){	
		uiCoop.getCoopData(contextData.type, contextData.id, "room", null, roomId, function(){ 
			toastr.success(trad["processing ok"]);
			$("#modalCoop").modal("show");

			var type = null;
			var id = null;

			if(proposalId != null){
				type = "proposal"; id = proposalId;
			}

			if(actionId != null){
				type = "action"; id = actionId;
			}

			if(resolutionId != null){
				type = "resolution"; id = resolutionId;
			}

			console.log("getCoopData??", contextData.type, contextData.id, type, null, id);

			if(type != null) 
			uiCoop.getCoopData(contextData.type, contextData.id, type, null, id);

			setTimeout(function(){
				loadNewsStream(true);
			}, 5000);
		});
	}, 1500);
}

</script>
