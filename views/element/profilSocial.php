

<?php 

	$cssAnsScriptFilesModule = array(
		'/js/news/newsHtml.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	HtmlHelper::registerCssAndScriptsFiles( 
		array(  '/css/onepage.css',
				'/css/profilSocial.css',
				'/vendor/colorpicker/js/colorpicker.js',
				'/vendor/colorpicker/css/colorpicker.css',
				'/css/news/index.css',	
				'/css/timeline2.css',
				'/css/circle.css',	
				'/css/default/directory.css',	
				'/js/comments.js',
			  ) , 
		Yii::app()->theme->baseUrl. '/assets');
		$cssAnsScriptFilesTheme = array(
		
"/plugins/jquery-cropbox/jquery.cropbox.css",
"/plugins/jquery-cropbox/jquery.cropbox.js",

	);
	//if ($type == Project::COLLECTION)
	//	array_push($cssAnsScriptFilesTheme, "/assets/plugins/Chart.js/Chart.min.js");
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
	$id = $_GET['id'];
	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';

	
	//récupération du type de l'element
    $typeItem = (@$element["typeSig"] && $element["typeSig"] != "") ? $element["typeSig"] : "";
    if($typeItem == "") $typeItem = @$element["type"] ? $element["type"] : "item";
    if($typeItem == "people") $typeItem = "citoyens";
    
    $typeItemHead = $typeItem;
    if($typeItem == "organizations" && @$element["type"]) $typeItemHead = $element["type"];

    if(strpos($typeItem, "place.")>=0){
    	$typeItem = "place";
    }

    //icon et couleur de l'element
    $icon = Element::getFaIcon($typeItemHead) ? Element::getFaIcon($typeItemHead) : "";
    $iconColor = Element::getColorIcon($typeItemHead) ? Element::getColorIcon($typeItemHead) : "";

    $useBorderElement = false;

    if(@Yii::app()->params["front"]) $front = Yii::app()->params["front"];
?>
<style>
	.header{
		position: absolute;
		width:100%;
		height:300px;
	}
	.social-main-container, #central-container{
		background-color: #f8f8f8;
		min-height:1200px;
	}

	#shortDescription *{
		font-size:0px !important;
	}

	iframe.wysihtml5-sandbox{
		border:1px solid lightgrey!important;
		padding:10px!important;
	}

	section#timeline-social{
		/*position: absolute;*/
		/*top:300px;*/
	}

	.profilSocial{
		/*position: absolute;
		top:0px;*/
	}
	.sub-menu-social{
		margin-top:-15px;
		background-color: white;
		border-top: 1px solid #ccc !important;
		border-bottom: 1px solid #ccc !important;
	}
	.sub-menu-social button{
		background-color: #fff;
		border: 1px solid #ccc !important;
		border-top: 0px !important;
		border-bottom: 0px !important;
		height:45px;
		margin-top: 0px;
		border-radius: 0px !important;
	}
	footer{
        /*position: absolute!important;*/
        bottom: 0px;
    }

    #small_profil{
    	font-weight: 300;
    	text-transform: none;
    	font-size:13px;
    	margin-top:4px;
    }


#central-container .bg-dark {
    color: white !important;
    background-color: #3C5665 !important;
}
#central-container .bg-red{
    background-color:#E33551 !important;
    color:white!important;
}
#central-container .bg-blue{
    background-color: #5f8295 !important;
    color:white!important;
}
#central-container .bg-green{
    background-color:#93C020 !important;
    color:white!important;
}
#central-container .bg-orange{
    background-color:#FFA200 !important;
    color:white!important;
}
#central-container .bg-yellow{
    background-color:#FFC600 !important;
    color:white!important;
}
#central-container .bg-purple{
    background-color:#8C5AA1 !important;
    color:white!important;
}
#central-container #dropdown_search{
	min-height:500px;
    margin-top:30px;
}
#central-container .row.headerDirectory{
    margin-top: 20px;
    display: none;
}
#central-container p {
    font-size: 13px;
}

#listCollections .text-white{
  color:black!important;
}

.notif-column .alert{
	font-size:12px;
	border:none!important;
	border-radius: 0px;
}
.notif-column a .fa-times{
	margin-left:-5px;
}

<?php 
    $btnAnc = array("blue"      =>array("color1"=>"#ea4335", 
                                        "color2"=>"#ea4335"),
                    );
?>

<?php foreach($btnAnc as $color => $params){ ?>
.btn-anc-color-<?php echo $color; ?>{
    background-color: transparent;
    border-color: transparent;
    color: <?php echo $params["color1"]; ?>!important;
}

.btn-anc-color-<?php echo $color; ?>:hover{
    background-color:transparent!important;
    color:<?php echo $params["color1"]; ?>!important;
}
.btn-anc-color-<?php echo $color; ?>.active{ 
    background-color:#fff!important;
    color:<?php echo $params["color1"]; ?>!important;
    border-color: <?php echo $params["color1"]; ?>!important;
}
.btn-anc-color-<?php echo $color; ?>.active:hover{
    background-color: #fff;
    color: <?php echo $params["color1"]; ?>;
}

.favElBtn, .favAllBtn{
  padding: 5px 8px;
  font-weight: 800;
  margin-bottom:5px;
}
.menu-params{
	position: absolute;
	top: 60px;
	left: -25px;
}

#main-name-element{
	/*background-color: white;
	border-radius:50px;
	padding:10px;
	padding-right: 22px;*/
}
#uploadScropResizeAndSaveImage{
	/*position:absolute;
	top:0px;
	bottom: 0px;
	left:0px;
	right: 0px;
	background-color: rgba(1,1,1,0.8);
	padding-top: 150px;
	padding-left: 50px;*/
}
#banniere_photoAdd{
	position:absolute;
	z-index: 1000;
}

<?php } ?>


.pastille-type-element{
    border-radius: 50px;
    height: 20px;
    width: 20px;
    color: white;
    text-align: center;
    padding-top: 10px;
    margin-right: 10px;
    margin: 5px;
}
.name-header{
	line-height: 30px;
	font-size: 20px;
}
#shortDescriptionHeader{
	white-space: pre-line;
	font-size: 16px;
	line-height: 19px;
}
.contentHeaderInformation{
	background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.4) 25%);
    padding: 35px 0px;
    position: absolute;
    bottom: 0px;
}
#col-banniere{
	min-height:280px;
}
#fileuploadContainer{
	box-shadow: 0px 0px 5px 0px grey;
}

.sub-menu-social.affix {
    top: 81px !important;
    position: fixed;
    right: 0;
    z-index: 10;
    width:100%!important;
    -webkit-box-shadow: 0px 0px 5px -1px rgba(0,0,0,0.5);
	-moz-box-shadow: 0px 0px 5px -1px rgba(0,0,0,0.5);
	box-shadow: 0px 0px 5px -1px rgba(0,0,0,0.5);
}

@media (max-width: 768px) {

	#shortDescriptionHeader{
		font-size: 13px;
		line-height: 17px;
	}
}
</style>
	
    <!-- <section class="col-md-12 col-sm-12 col-xs-12 header" id="header"></section> -->
<div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12 no-padding">	
    <!-- Header -->
    <section class="col-md-12 col-sm-12 col-xs-12" id="social-header">
        <div id="topPosKScroll"></div>
    	<?php if(@$edit==true && false) { ?>
    	<button class="btn btn-default btn-sm pull-right margin-right-15 margin-top-70 hidden-xs btn-edit-section" 
    			data-id="#header">
	        <i class="fa fa-cog"></i>
	    </button>
	    <?php } ?>
        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 text-left no-padding" id="col-banniere">
        	<?php 
				$thumbAuthor =  @$element['profilImageUrl'] ? 
                  Yii::app()->createUrl('/'.@$element['profilImageUrl']) 
                  : "";
			?>
			<form  method="post" id="banniere_photoAdd" enctype="multipart/form-data">
				<?php
				if(@Yii::app()->session["userId"] && ((@$edit && $edit) || (@$openEdition && $openEdition))){ ?>
				<div class="user-image-buttons padding-10">
					<a class="btn btn-blue btn-file btn-upload fileupload-new btn-sm" id="banniere_element" ><span class="fileupload-new"><i class="fa fa-plus"></i> <span class="hidden-xs"> Banniere</span></span>
						<input type="file" accept=".gif, .jpg, .png" name="banniere" id="banniere_change" class="hide">
						<input class="banniere_isSubmit hidden" value="true"/>
					</a>
				</div>
				<?php }; ?>

			</form>
			<div id="contentBanniere" class="col-md-12 col-sm-12 col-xs-12 no-padding">
				<?php if (@$element["profilBanniereUrl"] && !empty($element["profilBanniereUrl"])){ ?> 
					<img class="col-md-12 col-sm-12 col-xs-12 no-padding img-responsive" src="<?php echo Yii::app()->createUrl('/'.$element["profilBanniereUrl"]) ?>">
				<?php } ?>
			</div>
			<!--<img class="col-xs-11 col-sm-12 col-md-12 no-padding img-responsive" src="<?php echo $thumbAuthor; ?>" 
				 style="border-bottom:45px solid white;">
			-->
			<div class="col-xs-12 col-sm-12 col-md-12 contentHeaderInformation">	
	        	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-white pull-right">
					<h4 class="text-left margin-bottom-10 padding-left-15 pull-left no-margin" id="main-name-element">
						<?php if($edit==true || $openEdition==true ){?>
							<!-- <a href="javascript:;" class="tooltips btn-update-info" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Update Contact information");?>"><i class="fa text-red fa-pencil"></i></a> -->
						<?php } ?>

						<span id="nameHeader">
							<div class="pastille-type-element bg-<?php echo $iconColor; ?> pull-left">
								<!--<i class="fa fa-<?php echo $icon; ?>"></i>--> 
							</div>
							<div class="name-header pull-left"><?php echo @$element["name"]; ?></div>
						</span>	
					</h4>
				</div>

				<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 pull-right">
					<span class="pull-left text-white" id="shortDescriptionHeader"><?php echo ucfirst(substr(trim(@$element["shortDescription"]), 0, 180)); ?>
						<?php if(@$edit==true) { ?>
					<?php } ?>
					</span>	
				</div>
				<div class="pull-right col-sm-3 col-md-3" style="">
					
				</div>
				<!-- <a href="#app.page.type.citoyens.id.580827a8da5a3bca128b456b?tpl=onepage" target="_blank" class="font-blackoutM letter-red bold">
					  <i class="fa fa-external-link"></i> <span class="hidden-xs hidden-sm">Page</span> web
				</a>
				<br> -->

				<!-- <?php //if(@$element["shortDescription"]!="") { ?><i class="fa fa-quote-left pull-left "></i><?php //} ?> -->
				

				
				
			</div>
	    </div>

	    <div class="col-md-3 col-sm-3 col-xs-3 no-padding" style="bottom:-31px; position: absolute;">
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
								
								<?php if(false && @Yii::app()->session["userId"]){ ?>
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
				                					"elementName"=> $element["name"],
				                					"openEdition" => $openEdition) 
				                			); 
				                	?>
								    <!-- <p><i class="fa fa-briefcase"></i> Web Design and Development.</p> -->
								</div>
								<?php } ?>
		</div>
    </section>
    
    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12 pull-right sub-menu-social no-padding">

    	<?php if(@Yii::app()->session["userId"]){ ?>
		<div class="btn-group pull-right padding-top-5">
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

    	<div class="btn-group">

    	  <?php if(@Yii::app()->session["userId"] && 
    			 $type==Person::COLLECTION && 
    			 (string)$element["_id"]==Yii::app()->session["userId"]){ 

    			$iconNewsPaper="user-circle"; 
    	  ?>
		  <button type="button" class="btn btn-default bold" id="btn-start-newsstream">
		  		<i class="fa fa-rss"></i> Fil d'actu<span class="hidden-sm">alité</span>s
		  </button>

		  <?php } else $iconNewsPaper="rss"; ?>
		  <button type="button" class="btn btn-default bold" id="btn-start-mystream">
		  		<i class="fa fa-<?php echo $iconNewsPaper ?>"></i> <?php echo Yii::t("common","Newspaper") ?>
		  </button>

		  <button type="button" class="btn btn-default bold" id="btn-start-gallery">
		  		<i class="fa fa-camera"></i> <?php echo Yii::t("common", "Gallery") ?>
		  </button>
		</div>

		<?php if(@Yii::app()->session["userId"] && $isLinked==true){ ?>
		<div class="btn-group">
		  <button type="button" class="btn btn-default bold" id="btn-start-notifications">
		  	<i class="fa fa-bell"></i> 
		  	<span class="hidden-xs hidden-sm">
		  		Mes notif<span class="hidden-md">ications</span>
		  	</span>
		  	<span class="badge notifications-countElement <?php if(!@$countNotifElement || (@$countNotifElement && $countNotifElement=="0")) echo 'badge-transparent hide'; else echo 'badge-success'; ?>">
		  		<?php echo @$countNotifElement ?>
		  	</span>
		  </button>
		  <!--<button type="button" class="btn btn-default bold">
		  	<i class="fa fa-envelope"></i> 
		  	<span class="hidden-xs hidden-sm hidden-md">
		  		Messagerie
		  	</span><span class="badge bg-azure">3</span>-->
		  </button>
		</div>
		<?php } ?>
		
		<div class="btn-group pull-right">
		  <button type="button" class="btn btn-default bold">
		  	<i class="fa fa-user-secret"></i> <span class="hidden-xs hidden-sm hidden-md">Admin</span>
		  </button>
		  <?php if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>
		  <button type="button" class="btn btn-default bold" id="btn-superadmin">
		  	<i class="fa fa-grav letter-red"></i> <span class="hidden-xs hidden-sm hidden-md"></span>
		  </button>
		  <?php } ?>
		</div>

		<?php if(@Yii::app()->session["userId"] && $edit==true){ ?>
		<div class="btn-group pull-right">
			<ul class="nav navbar-nav">
				<li class="dropdown">
				<button type="button" class="btn btn-default bold">
		  			<i class="fa fa-cogs"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo Yii::t("common", "Settings"); ?></span>
		  		</button>
		  		<ul class="dropdown-menu arrow_box menu-params">			
	  				<li class="text-left">
		               	<a href="javascript:;" id="editConfidentialityBtn" class="bg-white">
		                    <i class="fa fa-cogs"></i> <?php echo Yii::t("common", "Confidentiality params"); ?>
		                </a>
		            </li>
		  			<?php if($type !=Person::COLLECTION){ ?>
		  			<li class="text-left">
		               	<a href="javascript:;" class="bg-white text-red">
		                    <i class="fa fa-trash"></i><?php echo Yii::t("common", "Delete {what}",array("{what}"=> Yii::t("common","this ".Element::getControlerByCollection($type)))); ?>
		                </a>
		            </li>
		            <?php } else { ?>
					<li class="text-left">
						<a href='javascript:' id="downloadProfil">
							<i class='fa fa-download'></i> <?php echo Yii::t("common", "Download your profil") ?>
						</a>
					</li>
		            <li class="text-left">
		               	<a href='javascript:' id="changePasswordBtn" class='text-red'>
							<i class='fa fa-key'></i> <?php echo Yii::t("common","Change assword"); ?>
						</a>
		            </li>
		            <?php } ?>
		  		</ul>
		  		</li>
		  	</ul>
		</div>
		<?php } ?>

		
		  		
	</div>

	  
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 profilSocial" style="margin-top:50px;">  
		
	    <?php 
	    	$params = array(    "element" => @$element, 
                                "type" => @$type, 
                                "edit" => @$edit,
                                "countries" => @$countries,
                                "tags" => @$tags,
                                "controller" => $controller,
                                "openEdition" => $openEdition,
                                "countStrongLinks" => $countStrongLinks,
                                "countLowLinks" => @$countLowLinks,
                                "countInvitations"=> $countInvitations,
                                "linksBtn"=> @$linksBtn
                                );

	    	if(@$members) $params["members"] = $members;
	    	if(@$events) $params["events"] = $events;
	    	if(@$needs) $params["needs"] = $needs;
	    	if(@$projects) $params["projects"] = $projects;

	    	$this->renderPartial('../pod/ficheInfoElementCO2', $params ); 
	    ?>

	   <!--  <div id="divTagsHeader" class="col-md-12 padding-5 text-right margin-bottom-10">
			<?php if(@$element["tags"])
        			foreach ($element["tags"]  as $key => $tag) { ?>
        		<span class="badge letter-red bg-white"><?php echo $tag; ?></span>
        	<?php } ?>
		</div>
		-->
	</div>

	<section class="col-xs-12 col-md-8 col-sm-8 col-lg-9 no-padding" style="margin-top: -10px;">
	    	
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-9 margin-top-50" id="central-container">
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
		<!--<div class="col-md-2 col-lg-3 hidden-sm hidden-xs margin-top-50" id="notif-column">
			<div class="alert alert-info">
				<a href="#..."><i class="fa fa-times text-dark padding-5"></i></a> 
				<span>
					<i class="fa fa-comment"></i> <b>Quelqu'un</b> a commenté votre message<br>
					<small class="margin-left-15">il y a 2 minutes</small><br>
				</span>
	    	</div>
			<div class="alert alert-info">
				<a href="#..."><i class="fa fa-times text-dark padding-5"></i></a> 
				<span>
					<i class="fa fa-comment"></i> <b>Quelqu'un</b> a commenté <b>votre message</b><br>
					<small class="margin-left-15">il y a 3h</small>
				</span>
	    	</div>
			<div class="alert alert-success">
				<a href="#..."><i class="fa fa-times text-dark padding-5"></i></a> 
				<a href="#...">
					<i class="fa fa-calendar"></i> <b>Quelqu'un</b> a vous invite à <b>un événement</b><br>
					<small class="margin-left-15">il y a 5h</small>
				</a>
	    	</div>
			<div class="alert alert-success">
				<a href="#..."><i class="fa fa-times text-dark padding-5"></i></a> 
				<a href="#...">
					<i class="fa fa-hand-rock-o"></i> <b>Conseil citoyen de votre ville :</b> une nouvelle <b>proposition</b> vient d'être publiée par <b>quelqu'un</b>.<br>
					<small class="margin-left-15">il y a 2 jours</small><br>
				</a>
	    	</div>
			<div class="alert alert-danger">
				<a href="#..."><i class="fa fa-times text-dark padding-5"></i></a> 
				<span>
					<i class="fa fa-flag"></i> <b>Quelqu'un</b> a signalé l'un de vos commentaires<br>
					<small class="margin-left-15">il y a 10 jours</small><br>
				</span>
	    	</div>
	    </div>-->
	</section>
</div>	
<style>
#uploadScropResizeAndSaveImage i{
	position: inherit !important;
}
#uploadScropResizeAndSaveImage .close-modal .lr,
#uploadScropResizeAndSaveImage .close-modal .lr .rl{
	z-index: 1051;
height: 75px;
width: 1px;
background-color: #2C3E50;
}
#uploadScropResizeAndSaveImage .close-modal .lr{
margin-left: 35px;
transform: rotate(45deg);
-ms-transform: rotate(45deg);
-webkit-transform: rotate(45deg);
}
#uploadScropResizeAndSaveImage .close-modal .rl{
transform: rotate(90deg);
-ms-transform: rotate(90deg);
-webkit-transform: rotate(90deg);
}
#uploadScropResizeAndSaveImage .close-modal {
	position: absolute;
	width: 75px;
	height: 75px;
	background-color: transparent;
	top: 25px;
	right: 25px;
	cursor: pointer;
}
.blockUI, .blockPage, .blockMsg{
	padding-top: 0px !important;
} 
#banniere_element:hover{
    color: #0095FF;
    background-color: white;
    border:1px solid #0095FF;
    border-radius: 3px;
    margin-right: 2px;
}
#banniere_element{
    background-color: #0095FF;
    color: white;
    border-radius: 3px;
    margin-right: 2px;
}

</style>
<div id="uploadScropResizeAndSaveImage" style="display:none;padding:0px 60px;">
	<!--<img src='' id="previewBanniere"/>-->
	<div class="close-modal" data-dismiss="modal"><div class="lr"><div class="rl"></div></div></div>
		<div class="col-lg-12">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/CO2r.png" class="inline margin-top-25 margin-bottom-5" height="50">
	        <br>
		</div>
		<div class="modal-header text-dark">
			<h3 class="modal-title text-center" id="ajax-modal-modal-title"><i class="fa fa-crop"></i> <?php echo Yii::t("common","Resize and crop your image to render a beautiful banniere") ?></h3>
		</div>
		<div class="panel-body">
			<div class='col-md-offset-1' id='cropContainer'>
				<img src='' id='cropImage' class='' style=''/>
				<div class='col-md-12'>
					<input type='submit' class='btn btn-success text-white imageCrop saveBanniere'/>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php 
	    	$paramsConfidentiality = array( "element" => @$element, 
                                "type" => @$type, 
                                "edit" => @$edit,
                                "controller" => $controller,
                                "openEdition" => $openEdition,
                                );

	    	$this->renderPartial('../pod/confidentiality', $params ); 
	    ?>

<script type="text/javascript">

	var elementName = "<?php echo @$element["name"]; ?>";
    var contextType = "<?php echo @$type; ?>";
    var contextId = "<?php echo @(string)$element['_id'] ?>";
    var members = <?php echo json_encode(@$members); ?>;
    var params = <?php echo json_encode(@$params); ?>;
    var dateLimit = 0;
    var typeItem = "<?php echo $typeItem; ?>";
    
    console.log("params", params);
    var subView="<?php echo @$subview; ?>";
    var hashUrlPage="#page.type."+contextType+".id."+contextId;
    var cropResult;
	jQuery(document).ready(function() {
		initSocial();
		bindButtonMenu();
		if(subView!=""){
			if(subView=="gallery")
				loadGallery()
			else if(subView=="notifications")
				loadNotifications();
			else if(subView.indexOf("chart") >= 0){
				id=subView.split("chart");
				loadChart(id[1]);
			}
			else if(subView=="mystream")
				loadNewsStream(false);
			else if(subView=="history")
				loadHistoryActivity();
			else if(subView=="directory")
				loadDirectory();
			else if(subView=="editChart")
				loadEditChart();
			else if(subView=="detail")
				loadDetail();
		} else
			loadNewsStream(true);

		KScrollTo("#topPosKScroll");
		//IMAGE CHANGE//
		$("#uploadScropResizeAndSaveImage .close-modal").click(function(){
			$.unblockUI();
		});
		$("#banniere_element").click(function(event){
  			if (!$(event.target).is('input')) {
  					$(this).find("input[name='banniere']").trigger('click');
  			}
			//$('#'+contentId+'_avatar').trigger("click");		
		});
		/*$('#banniere_change').off().on('change.bs.fileinput', function () {
			setTimeout(function(){
				var files=document.getElementById("banniere_change").files;
				if (files[0].size > 2097152)
					toastr.warning("Please reduce your image before to 2Mo");
				else {
					for (var i = 0; i < files.length; i++) {           
				        var file = files[i];
				       	var imageType = /image.*//*;     
				        if (!file.type.match(imageType)) {
				            continue;
				        }           
				        var img=document.getElementById("previewBanniere");            
				        img.file = file;    
				        var reader = new FileReader();
				        reader.onload = (function(aImg) { 
				        	var image = new Image();
   							image.src = reader.result;
   							image.onload = function() {
       							// access image size here 
       						 	var imgWidth=this.width;
       						 	var imgHeight=this.height;
       							if(imgWidth>=1000 && imgHeight>=500)
       						 		$("#banniere_photoAdd").submit();
       						 	else
       						 		toastr.warning("Please choose an image with a minimun of size: 1000x450 (widthxheight)");
  							};
				        });
				        reader.readAsDataURL(file);
				    }  
				}
			}, 400);
		});
		$("#banniere_photoAdd").off().on('submit',(function(e) {
			//alert(moduleId);
			if(debug)mylog.log("id2", contextId);
			$(".banniere_isSubmit").val("true");
			e.preventDefault();
			$.ajax({
						//url: baseUrl+"/"+moduleId+"/api/saveUserImages/type/"+type+"/id/"+id+"/contentKey/"+contentKey+"/user/<?php echo Yii::app()->session["userId"]?>",
						url : baseUrl+"/"+moduleId+"/document/<?php echo Yii::app()->params['uploadUrl'] ?>dir/"+moduleId+"/folder/"+contextType+"/ownerId/"+contextId+"/input/banniere",
						type: "POST",
						data: new FormData(this),
						contentType: false,
						cache: false, 
						processData: false,
						dataType: "json",
						success: function(data){
							html="<div class='col-md-offset-1' id='cropContainer'>"+
									"<h1 class='text-white'>Resize and crop your image to render a beautiful banniere</h1>"+
									"<img src='"+baseUrl+"/<?php echo Yii::app()->params['uploadUrl'] ?>"+moduleId+"/"+contextType+"/"+contextId+"/banniere/"+data.name+"' id='cropImage' class='' style=''/>"+
									"<div class='col-md-12'><input type='submit' class='btn-blue text-white imageCrop saveBanniere'/></div>"+
									"</div>";
							$("#uploadScropResizeAndSaveImage").show();
							$("#uploadScropResizeAndSaveImage").html(html);
							setTimeout(function(){
								var crop = $('#cropImage').cropbox({width: 1300,
									height: 400,
									zoomIn:true,
									zoomOut:true}, function() {
									cropResult=this.result;
								});
	        					/*$('#cropImage').cropbox({
								    width: 1300,
									height: 400,
									zoomIn:true,
									zoomOut:true
								}, function() {*/
									//on load
									//this.getBlob();
  									// this.getDataURL(); 
  									/*$(".saveBanniere").click(function(){
							        	//$("#uploadScropResizeAndSaveImage").hide();
							        	console.log(cropResult);
							        	imageName = data.name;
							       		var doc = { 
									  		"id":id,
									  		"type":contextType,
									  		"folder":contextType+"/"+contextId+"/banniere",
									  		"moduleId":moduleId,
									  		"author" : "<?php echo (isset(Yii::app()->session['userId'])) ? Yii::app()->session['userId'] : 'unknown'?>"  , 
									  		"name" : data.name , 
									  		"date" : new Date() , 
									  		"size" : data.size ,
									  		"doctype" : "<?php echo Document::DOC_TYPE_IMAGE; ?>",
									  		"contentKey" : "banniere",
									  		"formOrigin" : "banniere",
									  		"parentType":contextType,
									  		"parentId" : contextId,
									  		"crop":cropResult
									  	};
									  	$.ajax({
										  	type: "POST",
										  	url: baseUrl+"/"+moduleId+"/document/save",
										  	data: doc,
									      	dataType: "json"
										}).done( function(data){
									        if(data.result){
									        	newBanniere='<img class="img-responsive" src="'+baseUrl+data.src+'" style="border-bottom:45px solid white;">';
									        	$("#contentBanniere").html(newBanniere);
									        	$("#uploadScropResizeAndSaveImage").hide();
									    	}
									    });
									});
									//console.log('Url: ' + this.getDataURL());
								/*}).on('cropbox', function(e, crop) {
									var crop=crop;
							        console.log('crop window: ', crop);
							        
								});*/
							/*}, 300);
						}
					});
		}));*/
		$('#banniere_change').off().on('change.bs.fileinput', function () {
			setTimeout(function(){
				var files=document.getElementById("banniere_change").files;
				if (files[0].size > 2097152)
					toastr.warning("Please reduce your image before to 2Mo");
				else {
					for (var i = 0; i < files.length; i++) {           
				        var file = files[i];
				       	var imageType = /image.*/;     
				        if (!file.type.match(imageType)) {
				            continue;
				        }           
				        var img=document.getElementById("cropImage");            
				        img.file = file;    
				        var reader = new FileReader();
				        reader.onload = (function(aImg) { 
				        	var image = new Image();
   							image.src = reader.result;
   							img.src = reader.result;
   							image.onload = function() {
       							// access image size here 
       						 	var imgWidth=this.width;
       						 	var imgHeight=this.height;
       							if(imgWidth>=1000 && imgHeight>=500){
	               					$.blockUI({ 
	               						message: $('div#uploadScropResizeAndSaveImage'), 
	               						css: {cursor:null,padding: '0px !important'}
	               					}); 
	               					$("#uploadScropResizeAndSaveImage").parent().css("padding-top", "0px !important");
									//$("#uploadScropResizeAndSaveImage").html(html);
									setTimeout(function(){
										var crop = $('#cropImage').cropbox({width: 1300,
											height: 400,
											zoomIn:true,
											zoomOut:true}, function() {
												cropResult=this.result;
												console.log(cropResult);
										}).on('cropbox', function(e, crop) {
											cropResult=crop;
							        		console.log('crop window: ', crop);
							        
										});
										$(".saveBanniere").click(function(){
									        //console.log(cropResult);
									        //var cropResult=cropResult;
									        $("#banniere_photoAdd").submit();
										});
										$("#banniere_photoAdd").off().on('submit',(function(e) {
			//alert(moduleId);
			if(debug)mylog.log("id2", contextId);
			$(".banniere_isSubmit").val("true");
			e.preventDefault();
			console.log(cropResult);
			var fd = new FormData(document.getElementById("banniere_photoAdd"));
			fd.append("parentId", contextId);
			fd.append("parentType", contextType);
			fd.append("formOrigin", "banniere");
			fd.append("contentKey", "banniere");
			fd.append("cropW", cropResult.cropW);
			fd.append("cropH", cropResult.cropH);
			fd.append("cropX", cropResult.cropX);
			fd.append("cropY", cropResult.cropY);
			//var formData = new FormData(this);
						//console.log("formdata",formData);
			/*formData.files= document.getElementById("banniere_change").files;
			formData.crop= cropResult;
			formData.parentId= contextId;
			formData.parentType= contextType;
			formData.formOrigin= "banniere";*/
			//console.log(formData);
			// Attach file
			//formData.append('image', $('input[type=banniere]')[0].files[0]); 
			$.ajax({
				url : baseUrl+"/"+moduleId+"/document/uploadSave/dir/"+moduleId+"/folder/"+contextType+"/ownerId/"+contextId+"/input/banniere",
				type: "POST",
				data: fd,
				contentType: false,
				cache: false, 
				processData: false,
				dataType: "json",
				success: function(data){
			        if(data.result){
			        	newBanniere='<img class="col-md-12 col-sm-12 col-xs-12 no-padding img-responsive" src="'+baseUrl+data.src+'" style="">';
			        	$("#contentBanniere").html(newBanniere);
			        	$.unblockUI();
			        	//$("#uploadScropResizeAndSaveImage").hide();
			    	}
			    }
			});
		}));
									}, 300);
								}
       						 	else
       						 		toastr.warning("Please choose an image with a minimun of size: 1000x450 (widthxheight)");
  							};
				        });
				        reader.readAsDataURL(file);
				    }  
				}
			}, 400);
		});
		
		//END MAGE CHNGE
	});

	function getCroppingModal(){
		
	}

	function bindButtonMenu(){
		$("#btn-superadmin").click(function(){
			loadAdminDashboard();
		});
		$("#btn-start-newsstream").click(function(){
			history.pushState(null, "New Title", hashUrlPage);
			loadNewsStream(true);
		});
		$("#btn-start-mystream").click(function(){
			if(contextType=="citoyens" && userId==contextId)
				history.pushState(null, "New Title", hashUrlPage+".view.mystream");
			else
				history.pushState(null, "New Title", hashUrlPage);
			loadNewsStream(false);
		});
		$("#btn-start-gallery").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.gallery");
			//location.search="?view=gallery";
			loadGallery();
		});
		$("#btn-start-notifications").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.notifications");
			//location.search="?view=notifications";
			loadNotifications();
		});
		$(".btn-start-chart").click(function(){
			id=$(this).data("value");
			history.pushState(null, "New Title", hashUrlPage+".view.chart"+id);
			//location.search="?view=chart&id="+id;
			loadChart(id);
		});
		$("#btn-show-activity").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.history");
			loadHistoryActivity();
		});
		
		$(".open-confidentiality").click(function(){
			mylog.log("open-confidentiality");
			toogleNotif(false);
			smallMenu.open( markdownToHtml($("#descriptionMarkdown").val()));
			bindLBHLinks();
		});
	
		$(".open-directory").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.directory");
			loadDirectory();
		});
		$(".edit-chart").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.editChart");
			loadEditChart();
		});
		$(".btn-open-collection").click(function(){
			toogleNotif(false);
		});

		$("#btn-start-detail").click(function(){
			history.pushState(null, "New Title", hashUrlPage+".view.detail");
			loadDetail();
		});
	}

	function initSocial(){
		var Accordion = function(el, multiple) {
			this.el = el || {};
			this.multiple = multiple || false;

			// Variables privadas
			var links = this.el.find('.link');
			// Evento
			links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown);
		}

		Accordion.prototype.dropdown = function(e) {
			var $el = e.data.el;
				$this = $(this),
				$next = $this.next();

			$next.slideToggle();
			$this.parent().toggleClass('open');

			if (!e.data.multiple) {
				$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
			};
		}	

		var accordion = new Accordion($('#accordion'), false);
		var accordion2 = new Accordion($('#accordion2'), false);
		var accordion3 = new Accordion($('#accordion3'), false);
		var accordion4 = new Accordion($('#accordion4'), false);
		var accordion5 = new Accordion($('#accordion5'), false);

		//ouvre le pod communauté
		//$('#accordion4 .link').trigger("click");
   		$(".tooltips").tooltip();

   		$('.sub-menu-social').affix({
          offset: {
              top: 350
          }
      });
   		
	}

	function loadAdminDashboard(){
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		getAjax('#central-container' ,baseUrl+'/'+moduleId+"/app/superadmin/action/main",function(){ 
				
		},"html");
	}

	function loadNewsStream(isLiveBool){
		isLive = isLiveBool==true ? "/isLive/true" : ""; 
		dateLimit = 0;
		scrollEnd = false;

		toogleNotif(true);

		var url = "news/index/type/"+typeItem+"/id/<?php echo (string)$element["_id"] ?>"+isLive+"/date/"+dateLimit+
				  "?isFirst=1&tpl=co2&renderPartial=true";
		
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){ 
				$(window).bind("scroll",function(){ 
				    if(!loadingData && !scrollEnd && colNotifOpen){
				          var heightWindow = $("html").height() - $("body").height();
				          if( $(this).scrollTop() >= heightWindow - 400){
				            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep, isLiveBool);
				          }
				    }
				});
		},"html");
	}
	function loadGallery(){
		toogleNotif(false);
		var url = "gallery/index/type/"+typeItem+"/id/<?php echo (string)$element["_id"] ?>";
		
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
	}
	function loadChart(id){
		toogleNotif(false);
		var url = "chart/index/type/"+typeItem+"/id/<?php echo (string)$element["_id"] ?>/chart/"+id;
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
	}
	function loadNotifications(){
		toogleNotif(false);
		var url = "element/notifications/type/"+typeItem+"/id/<?php echo (string)$element["_id"] ?>";
		
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
	}
	function loadHistoryActivity(){
		toogleNotif(false);
		var url = "pod/activitylist/type/"+typeItem+"/id/<?php echo (string)$element["_id"] ?>";
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
	}
	function loadDirectory(){
		toogleNotif(false);
		smallMenu.openAjax(baseUrl+'/'+moduleId+'/element/directory/type/'+contextData.type+'/id/'+contextData.id+
								'?tpl=json','Communauté','fa-connectdevelop','dark');
		bindLBHLinks();
	}
	function loadEditChart(){
		toogleNotif(false);
		var url = "chart/addchartsv/type/"+contextType+"/id/"+contextId;
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
		function(){},"html");
	}

	function loadDetail(){
		toogleNotif(false);
		var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
		$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url+'?tpl=ficheInfoElement', null, function(){},"html");
	}

	
	function loadStream(indexMin, indexMax, isLiveBool){ console.log("LOAD STREAM PROFILSOCIAL");
		loadingData = true;
		currentIndexMin = indexMin;
		currentIndexMax = indexMax;
		

		if(typeof dateLimit == "undefined") dateLimit = 0;

		isLive = isLiveBool==true ? "/isLive/true" : "";
		var url = "news/index/type/"+typeItem+"/id/<?php echo (string)$element["_id"] ?>"+isLive+"/date/"+dateLimit+"?tpl=co2&renderPartial=true";
		$.ajax({ 
	        type: "POST",
	        url: baseUrl+"/"+moduleId+'/'+url,
	        data: { indexMin: indexMin, 
	        		indexMax:indexMax, 
	        		renderPartial:true 
	        	},
	        success:
	            function(data) {
	                if(data){ //alert(data);
	                	$("#news-list").append(data);
	                	//bindTags();
						
					}
					loadingData = false;
					$(".stream-processing").hide();
	            },
	        error:function(xhr, status, error){
	            loadingData = false;
	            $("#news-list").html("erreur");
	        },
	        statusCode:{
	                404: function(){
	                	loadingData = false;
	                    $("#news-list").html("not found");
	            }
	        }
	    });
	}

var colNotifOpen = true;
function toogleNotif(open){
		if(typeof open == "undefined") open = false;
		
		if(open==false){
			$('#notif-column').removeClass("col-md-2 col-sm-3 col-lg-3").addClass("hidden");
			$('#central-container').removeClass("col-md-10 col-lg-9").addClass("col-md-12 col-lg-12");
		}else{
			$('#notif-column').addClass("col-md-2 col-sm-3 col-lg-3").removeClass("hidden");
			$('#central-container').addClass("col-sm-12 col-md-10 col-lg-9").removeClass("col-md-12 col-lg-12");
		}

		colNotifOpen = open;
	}
</script>


<?php //$this->renderPartial('sectionEditTools');?>
