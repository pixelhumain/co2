<?php 

	HtmlHelper::registerCssAndScriptsFiles( 
		array(  '/css/onepage.css',
				'/vendor/colorpicker/js/colorpicker.js',
				'/vendor/colorpicker/css/colorpicker.css',
				'/css/news/index.css',	
				'/css/timeline2.css',
				'/css/circle.css',	
				'/css/default/directory.css',	
				'/js/comments.js',
				'/css/profilSocial.css',
				) , 
	Yii::app()->theme->baseUrl. '/assets');

	$cssAnsScriptFilesTheme = array(
		"/plugins/jquery-cropbox/jquery.cropbox.css",
		"/plugins/jquery-cropbox/jquery.cropbox.js",
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
	


<?php if($typeItem != "citoyens"){ ?>
	.section-create-page{
		display: none;
	}
<?php } ?>
</style>	
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
		



	    <div class="col-md-3 col-sm-3 hidden-xs no-padding" style="bottom:-31px; position: absolute;">
		<?php 	if(@$element["profilMediumImageUrl"] && !empty($element["profilMediumImageUrl"]))
					 $images=$element["profilMediumImageUrl"];
				else $images="";	
				
				$this->renderPartial('../pod/fileupload', 
								array("itemId" => (string) $element["_id"],
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
    
    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12 pull-right sub-menu-social no-padding">

    	<div class="btn-group inline">

    	  <?php 
    	  	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';
			$thumbAuthor =  @$element['profilThumbImageUrl'] ? 
		                      Yii::app()->createUrl('/'.@$element['profilThumbImageUrl']) 
		                      : "";
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
		  		<i class="fa fa-rss"></i> Fil d'actu<span class="hidden-sm">alité</span>s
		  </button>

		  <?php } else {
		  		  $iconNewsPaper="rss"; 
		  		}
		  ?>

		  <button type="button" class="btn btn-default bold hidden-xs btn-start-mystream">
		  		<i class="fa fa-<?php echo $iconNewsPaper ?>"></i> <?php echo Yii::t("common","Newspaper"); ?>
		  </button>

		  <?php if((@Yii::app()->session["userId"] && $isLinked==true) || @Yii::app()->session["userId"] == $element["_id"]){ ?>
		  <button type="button" class="btn btn-default bold hidden-xs btn-start-notifications">
		  	<i class="fa fa-bell"></i> 
		  	<span class="hidden-xs hidden-sm">
		  		<?php if (@Yii::app()->session["userId"] == $element["_id"]) echo "Mes n"; else echo "N"; ?>otif<span class="hidden-md">ications</span>
		  	</span>
		  	<span class="badge notifications-countElement <?php if(!@$countNotifElement || (@$countNotifElement && $countNotifElement=="0")) echo 'badge-transparent hide'; else echo 'badge-success'; ?>">
		  		<?php echo @$countNotifElement ?>
		  	</span>
		  </button>
		  <?php } ?>


		  <?php if((@$edit && $edit) || (@$openEdition && $openEdition)){ ?>
		  <button type="button" class="btn btn-default bold letter-green hidden-xs" data-target="#selectCreate" data-toggle="modal">
		  		<i class="fa fa-plus-circle fa-2x"></i> <?php //echo Yii::t("common", "Créer") ?>
		  </button>
		  <?php } ?>
		</div>
		
		<!--<div class="btn-group pull-right">

		  	
			<?php if($element["_id"] == Yii::app()->session["userId"] && 
			  			Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>
			    <button type="button" class="btn btn-default bold lbh" data-hash="#admin">
			  	<i class="fa fa-user-secret"></i> <span class="hidden-xs hidden-sm hidden-md">Admin</span>
			  </button>
			
			  <button type="button" class="btn btn-default bold" id="btn-superadmin">
			  	<i class="fa fa-grav letter-red"></i> <span class="hidden-xs hidden-sm hidden-md"></span>
			  </button>
			  <?php } ?>


		</div>-->


		<?php if(@Yii::app()->session["userId"] && $edit==true){ ?>
		<div class="btn-group pull-right" id="paramsMenu">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<button type="button" class="btn btn-default bold">
			  			<i class="fa fa-cogs"></i> <span class="hidden-xs hidden-sm hidden-md">
			  			<?php echo Yii::t("common", "Settings"); ?></span>
			  		</button>
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
		  				<li class="text-left">
			               	<a href="javascript:;" id="editConfidentialityBtn" class="bg-white">
			                    <i class="fa fa-cogs"></i> <?php echo Yii::t("common", "Confidentiality params"); ?>
			                </a>
			            </li>
						<li>
							<a href="javascript:;" onclick="showDefinition('qrCodeContainerCl',true)">
								<i class="fa fa-qrcode"></i> <?php echo Yii::t("common","QR Code") ?>
							</a>
						</li>

			  			<?php if($type !=Person::COLLECTION){ ?>
			  				<li class="text-left">
								<a href="javascript:;" id="btn-show-activity">
									<i class="fa fa-history"></i> <?php echo Yii::t("common","History")?> 
								</a>
							</li>
				  			<li class="text-left">
				               	<a href="javascript:;" class="bg-white text-red">
				                    <i class="fa fa-trash"></i> 
				                    <?php echo Yii::t("common", "Delete {what}", 
				                    					array("{what}"=> 
				                    						Yii::t("common","this ".Element::getControlerByCollection($type)))); 
				                    ?>
				                </a>
				            </li>
			            <?php } else { ?>
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
			            
			  		</ul>
		  		</li>
		  	</ul>
		</div>
		<?php } ?>

	  	<?php if(isset(Yii::app()->session["userId"]) && $typeItem!=Person::COLLECTION){ ?>
			<div class="btn-group pull-right">
			  	<button 	class='btn btn-default bold btn-share pull-right'
	                    	data-ownerlink='share' data-id='<?php echo $element["_id"]; ?>' data-type='<?php echo $typeItem; ?>' 
	                    	data-isShared='false'>
	                    	<i class='fa fa-share'></i> <span class="hidden-xs">Partager</span>
	          	</button>
	        </div>
	    <?php } ?>
	</div>

	
	<div id="menu-left-container" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 profilSocial hidden-xs" style="margin-top:40px;">  
		
	    <?php 
	    	$params = array(    "element" => @$element, 
                                "type" => @$type, 
                                "edit" => @$edit,
                                "isLinked" => @$isLinked,
                                "countNotifElement"=>@$countNotifElement,
                                //"countries" => @$countries,
                                //"controller" => $controller,
                                "invitedMe" => @$invitedMe,
                                "openEdition" => $openEdition,
                                //"countStrongLinks" => $countStrongLinks,
                                //"countLowLinks" => @$countLowLinks,
                                //"countInvitations"=> $countInvitations,
                                //"linksBtn"=> @$linksBtn
                                );

	    	/*if(@$members) $params["members"] = $members;
	    	if(@$events) $params["events"] = $events;
	    	if(@$needs) $params["needs"] = $needs;
	    	if(@$projects) $params["projects"] = $projects;*/

	    	$this->renderPartial('../pod/menuLeftElement', $params ); 
	    ?>
	</div>
	<section class="col-xs-12 col-md-9 col-sm-9 col-lg-9 no-padding central-section"">
		
		<?php   $classDescH=""; 
				$classBtnDescH="<i class='fa fa-angle-up'></i> masquer"; 
				$marginCentral="";
				if(!@$element["description"] || @$linksBtn["isFollowing"]==true || @$linksBtn["isMember"]==true){
					$classDescH="hidden"; 
					$classBtnDescH="<i class='fa fa-angle-down'></i> afficher la description"; 
				}

				if($typeItem != Person::COLLECTION){ 
		?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-xs" style="margin-top:45px;">
			<span id="desc-event" class="margin-top-10 <?php echo $classDescH; ?>">
				<b><i class="fa fa-angle-down"></i> <i class="fa fa-info-circle"></i> Description principale</b>
				<hr><?php echo 	@$element["description"] && @$element["description"]!="" ? 
								@$element["description"] : 
								"<span class='label label-info'>Aucune description enregistrée</span>"; ?>
			</span>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-xs">
			<button class="btn btn-default btn-xs pull-right margin-right-15" id="btn-hide-desc">
				<?php echo $classBtnDescH; ?>
			</button>
			<br>
			<hr>
		</div>
		<?php }else{ $marginCentral="50"; } ?>

	    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 margin-top-<?php echo $marginCentral; ?>" id="central-container">
		</div>

		<?php $this->renderPartial('../pod/qrcode',array(
																"type" => @$type,
																"name" => @$element['name'],
																"address" => @$address,
																"address2" => @$address2,
																"email" => @$element['email'],
																"url" => @$element["url"],
																"tel" => @$tel,
																"img"=>@$element['profilThumbImageUrl']));
																?>

		<div class="col-md-3 col-lg-3 hidden-sm hidden-xs margin-top-<?php echo $marginCentral; ?>" id="notif-column">
		</div>
	</section>
</div>	

<?php 
	$this->renderPartial('../pod/confidentiality',
			array(  "element" => @$element, 
					"type" => @$type, 
					"edit" => @$edit,
					"controller" => $controller,
					"openEdition" => $openEdition,
				) );


	if( $type != Person::COLLECTION)
		$this->renderPartial('../element/addMembersFromMyContacts',
				array(	"type"=>$type, 
						"parentId" => (string)$element['_id'], 
						"members" => @$members));


	$cssAnsScriptFilesModule = array(
		'/js/default/profilSocial.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

?>

<script type="text/javascript">
	var contextData = <?php echo json_encode( Element::getElementForJS(@$element, @$type) ); ?>; 

    var params = <?php echo json_encode(@$params); ?>;
    var edit =  ( ( '<?php echo (@$edit == true); ?>' == "1") ? true : false ); 
	var openEdition = ( ( '<?php echo (@$openEdition == true); ?>' == "1") ? true : false );
    var dateLimit = 0;
    var typeItem = "<?php echo $typeItem; ?>";
    var liveScopeType = "";
    var subView="<?php echo @$_GET['view']; ?>";
    var hashUrlPage="#page.type."+contextData.type+".id."+contextData.id;
    var cropResult;
    var idObjectShared = new Array();

    var personCOLLECTION = "<?php echo Person::COLLECTION; ?>";
	
	jQuery(document).ready(function() {
		bindButtonMenu();

		if(typeof contextData.name !="undefined")
		setTitle("", "", contextData.name);

		if(subView!=""){
			if(subView=="gallery")
				loadGallery()
			else if(subView=="notifications")
				loadNotifications();
			else if(subView.indexOf("chart") >= 0){
				loadChart();
			}
			else if(subView=="mystream")
				loadNewsStream(false);
			else if(subView=="history")
				loadHistoryActivity();
			else if(subView=="directory")
				loadDataDirectory("<?php echo @$_GET['dir']; ?>");
			else if(subView=="editChart")
				loadEditChart();
			else if(subView=="detail")
				loadDetail();
			else if(subView=="urls")
				loadUrls();
			else if(subView=="contacts")
				loadContacts();
		} else
			loadNewsStream(true);

		KScrollTo("#topPosKScroll");
		initDateHeaderPage(contextData);
		//Sig.showMapElements(Sig.map, mapElements);
	});


</script>
