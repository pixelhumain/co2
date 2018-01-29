
<?php 
	HtmlHelper::registerCssAndScriptsFiles( 
	array(  '/css/onepage.css',
			'/vendor/colorpicker/js/colorpicker.js',
			'/vendor/colorpicker/css/colorpicker.css',
			'/css/news/index.css',	
			'/css/timeline2.css',	
		  ) , 
	Yii::app()->theme->baseUrl. '/assets');

	$cssAnsScriptFilesModule = array(
    '/js/news/index.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	$imgDefault = $this->module->assetsUrl.'/images/news/profile_default_l.png';

	//récupération du type de l'element
    $typeItem = (@$element["typeSig"] && $element["typeSig"] != "") ? $element["typeSig"] : "";
    if($typeItem == "") $typeItem = @$element["typeSig"] ? $element["type"] : "item";
    if($typeItem == "people") $typeItem = "citoyens";
    
    $params = Element::getParamsOnepage($typeItem, $element["_id"]);
	
	$edit = @$params["edit"];
    $events = @$params["events"];
    $linksBtn = @$params["linksBtn"];
    $members = @$params["members"];
    $memberOf = @$params["memberOf"];
    $needs = @$params["needs"];
    $projects = @$params["projects"];
 	$tags = @$params["tags"];
 	$countStrongLinks = @$params["countStrongLinks"];

 	$hash = @$element["slug"] ? "#".$element["slug"] :
								"#page.type.".$type.".id.".$element["_id"];
    $typeItemHead = $typeItem;
    if($typeItem == "organizations" && @$element["type"]) $typeItemHead = $element["type"];

    //icon et couleur de l'element
    $icon = Element::getFaIcon($typeItemHead) ? Element::getFaIcon($typeItemHead) : "";
    $iconColor = Element::getColorIcon($typeItemHead) ? Element::getColorIcon($typeItemHead) : "";

    $useBorderElement = false;
?>
<style>
	#btn-onepage-main-menu{
		position: fixed;
		top:85px;
		left:20px;
		border-radius: 1px;
		letter-spacing: 2px;
		z-index: 50;
	}

	.dropdown .dropdown-onepage-main-menu{
		display:none;
	}
	.dropdown.open .dropdown-onepage-main-menu{
		display:block;
	}

	.dropdown-onepage-main-menu{
		position: fixed;
		top: 90px;
		left: 10px;
		max-height:400px;
		/*width:200px;*/
		background-color:transparent;
		z-index:5;
	}

	.dropdown-onepage-main-menu .dropdown-menu{
		margin:0px;
		border:none;
		display: inline;
		-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.3) ;
	    -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.3) ;
	    box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.3);
	}

	.dropdown-onepage-main-menu .dropdown-menu li a {
		text-transform: uppercase;
	}

	.arrow_box:after, .arrow_box:before {
		left: 19px;
	}
	header, .header{
		margin-top: 48px;
	}

	#contentBanner{
		margin-top:20px;
	}
	#contentBanner img{
		border-bottom: 2px solid white;
	}

	#profil_imgPreview{
		border:0px !important;
	}


	.fileupload-preview.thumbnail img.img-responsive, 
	.fileupload-new.thumbnail img.img-responsive{
		border:3px solid white;
		width: auto;
	}


	.btn-o {
	    border: 1px solid rgba(255, 255, 255, 0.5);
	    border-radius: 2px;
	    color: #ffffff !important;
	    display: inline-block;
	    /*font-family: open sans;*/
	    font-size: 15px !important;
	    font-weight: normal !important;
	    margin: 0 0 10px;
	    padding: 5px 11px;
	    text-decoration: none !important;
	    text-transform: uppercase;
	    -webkit-transition: all 0.4s ease;
	    -o-transition: all 0.4s ease;
	    transition: all 0.4s ease;
	}
	.btn-o:hover {
	  background-color: rgba(255, 255, 255, 0.4) !important;
	    color: #fff !important;
	  }
	.btn-o:hover {
	  background-color: rgba(255, 255, 255, 0.4) !important;
	    color: #fff !important;
	  }
	.blockUsername .navbar-nav:hover .btn-o{
	    background-color: rgba(255, 255, 255, 0.4) !important;
	    color: #fff !important;
	}

	.fileupload, .fileupload-preview.thumbnail, 
	.fileupload-new .thumbnail, 
	.fileupload-new .thumbnail img, 
	.fileupload-preview.thumbnail img{
		width:auto;
		max-width: 100%;
	}
	.blockUsername{
		background-color: transparent!important;
		position: relative !important;
		display:inline-block;
		margin-bottom:10px;
	}
	.menu-linksBtn{
		border-radius: 20px !important;
		margin-left: 5px !important;
		margin-right: 5px !important;
		padding: 10px 10px !important;
		margin-bottom:0px;
		background-color: rgba(0, 0, 0, 0.6);
		text-transform: none !important;
		border:none !important;
		line-height: 22px !important;
	}

	.btn-o.menu-linksBtn:hover{
		background-color: rgba(173, 173, 173, 0.58) !important;
		color: #363636 !important;
	}

</style>
<div  id="onepage">
	<div class="dropdown">
		<button class="btn bg-red text-white btn font-blackoutM dropdown-toggle" 
				data-toggle="dropdown" id="btn-onepage-main-menu">
				<i class="fa fa-bars"></i> Menu
		</button>
		<div class="dropdown-onepage-main-menu font-montserrat" aria-labelledby="btn-onepage-main-menu">
			<ul class="dropdown-menu arrow_box">
			    <li><a href="javascript:" data-target="#description"><i class="fa fa-angle-right"></i> Présentation</a></li>
			    <li><a href="javascript:" data-target="#events"><i class="fa fa-angle-right"></i> Événements</a></li>
			    <li><a href="javascript:" data-target="#projects"><i class="fa fa-angle-right"></i> Nos projets</a></li>
			    <li><a href="javascript:" data-target="#directory"><i class="fa fa-angle-right"></i> Communauté</a></li>
			    <li><a href="javascript:" data-target="#projects-values"><i class="fa fa-angle-right"></i> Nos valeurs</a></li>
			    <li><a href="javascript:" data-target="#freep"><i class="fa fa-angle-right"></i> Free</a></li>
			    <li role="separator" class="divider"></li>
			    <li><a href="javascript:" data-target="#footer"><i class="fa fa-angle-right"></i> Infos</a></li>
			  </ul>
		</div>
	</div>
	<div id="onepage">
		<div id="contentBanner" class="col-md-12 col-sm-12 col-xs-12 no-padding">
			<?php if (@$element["profilBannerUrl"] && !empty($element["profilBannerUrl"])){	
				$imgHtml='<img class="col-md-12 col-sm-12 col-xs-12 no-padding img-responsive" 
							src="'.Yii::app()->createUrl('/'.$element["profilBannerUrl"]).'">';
				if (@$element["profilRealBannerUrl"] && !empty($element["profilRealBannerUrl"])){ ?>
					<style>
						#content-header{
							margin-top: -150px;
						}
					</style>
					<a  href="<?php echo Yii::app()->createUrl('/'.$element["profilRealBannerUrl"]); ?>"
						class="thumb-info"  
						data-title="<?php echo Yii::t("common","Cover image of")." ".$element["name"]; ?>"
						data-lightbox="all">
						<?php echo $imgHtml; ?>
					</a>
				<?php } ?>
			<?php } ?>
		</div>
	    <!-- Header -->
	    <section class="header" id="header">
	    	<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section margin-top-70" data-id="#header">
		        <i class="fa fa-cog"></i>
		    </button>
	        <div class="container">
	            <div class="row">
	                
	                    <div class="col-md-12 col-sm-12 col-xs-12" id="content-header">
		                    <div class="col-md-3 col-sm-4 col-xs-10 text-right btn-tools no-padding">
		                    	

		                    </div>

		                    <div class="col-md-6 col-sm-4 col-xs-12 text-center no-padding" style="margin-top:-20px;">
		                    	

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

		                    </div>

		                    <div class="col-md-3 col-sm-4 col-xs-12 text-left btn-tools pull-right no-padding">

		                    	

		                    	<!-- <button class="btn btn-default"><i class="fa fa-star"></i> <span class="hidden-xs">Favoris</span></button> -->
		                    </div>

		                    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12 btn-tools margin-top-10 margin-bottom-10">

			                    <?php if(@$edit == true){ ?>
		                    		<a href="<?php echo $hash; ?>.view.detail"
		                    				class="btn btn-default lbh">
		                    				 <i class="fa fa-pencil hidden-xs"></i>
		                    				 Editer les informations 
		                    		</a>
		                    		<!-- <button class="btn btn-default"> Paramétrer la page <i class="fa fa-cog"></i></button> -->
			                    <?php } ?>


			                    <a href="<?php echo $hash; ?>" class="btn btn-default lbh"> 
			                    	<i class="fa fa-user-circle"></i> Page de profil
			                    </a>

		                    </div>

		                    <div class="col-md-12 col-sm-12 col-xs-12 intro-text">
		                    	<?php if(!@$element['profilMediumImageUrl'] || @$element['profilMediumImageUrl'] == "") { ?>
		                        	<?php if(@$typeItem){ ?>
			                    		<span class="col-md-12 col-sm-12 col-xs-12 bold letter-<?php echo Element::getColorIcon($element["type"]); ?>">
			                    			<i class="fa fa-<?php echo Element::getFaIcon($element["type"]); ?>"></i>
			                    			<?php if (@$element["typeSig"]!="people" && @$element["typeSig"]!="organizations") {
			                    					echo ucfirst(Yii::t("common", @$typeItem)); 
			                    				  }
			                    				  if (@$element["typeSig"]=="organizations") 
			                    				  	echo Yii::t("common", $element["type"]);  
			                    			?>
			                    		</span><br>
			                    	<?php } ?>
			                    <?php } ?>

		                        <span class="name"><?php echo @$element["name"]; ?></span><br>
		                        <?php if(@$element["preferences"]["publicFields"] && 
		                        		 in_array("email", @$element["preferences"]["publicFields"])){ ?>
		                        	<span class="email"><?php echo @$element["email"]; ?></span>
		                        	<hr class="bold-hr">
		                        <?php } ?>
		                        <?php if(@$element["preferences"]["publicFields"] && 
		                        		 in_array("phone", @$element["preferences"]["publicFields"])){ ?>
		                        	<?php if(@$element["telephone"]["fixe"]){ ?>
		                        		<i class="fa fa-phone"></i>
		                        		<span class="phone"><?php echo @$element["telephone"]["fixe"][0]; ?></span>
		                        	<?php } ?>
		                        	<?php if(@$element["telephone"]["mobile"]){ ?>
		                        		<i class="fa fa-phone <?php echo @$element["telephone"]["fixe"] ? "margin-left-15" : ""; ?>"></i>
		                        		<span class="phone"><?php echo @$element["telephone"]["mobile"][0]; ?></span>
		                        	<?php } ?>
		                        <?php } ?>
		                        <hr class="bold-hr">
		                        <span class="skills"><?php echo @$element["shortDescription"]; ?></span>
		                    </div>
		                    
	                    </div>

	                    <div class="col-md-12 col-sm-12 col-xs-12">		                
		                    <div class="tags">
		                    	<?php if(@$element["tags"])
		                    			foreach ($element["tags"]  as $key => $tag) { ?>
		                    		<span class="badge bg-red"><?php echo $tag; ?></span>
		                    	<?php } ?>
		                    </div>

		                    <?php if(@$element["preferences"]["publicFields"] && 
		                        	 in_array("locality", @$element["preferences"]["publicFields"])){ ?>
			                    <div class="commune text-red homestead margin-top-10">
			                		<?php if(@$element["address"] && @$element["address"]["addressLocality"]) {
			                				echo "<i class='fa fa-university'></i> ".$element["address"]["addressLocality"];
			                				if(@$element["address"]["postalCode"]) echo ", ";
			                			  }
			                			  if(@$element["address"] && @$element["address"]["postalCode"]) 
			                			  	echo $element["address"]["postalCode"];
			                		?>
			                    </div>
		                    <?php } ?>
		                </div>

	                </div>
	            </div>
	        </div>
	    </section>
    </div>
    
    <!-- DESCRIPTION Section -->

    <?php   
    		$desc = array( array("shortDescription"=>@$element["description"]),
    					);

    		if(@$desc && sizeOf(@$desc)>0)
    		$this->renderPartial('../pod/sectionElements', 
    								array(  "items" => $desc,
											"sectionKey" => "description",
											"sectionTitle" => "PRÉSENTATION",
											"sectionShadow" => true,
											"msgNoItem" => "Aucune description",
											"imgShape" => "square",
											"useImg" => false,
											"fullWidth" => true, //only for 1 element
											"useBorderElement"=>$useBorderElement,

											"styleParams" => array(	"bgColor"=>"#FFF",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    ?>

    <!-- EVENTS Section -->

    <?php   if(@$events && sizeOf(@$events)>0)
    		$this->renderPartial('../pod/sectionElements', 
    								array(  "items" => $events,
											"sectionKey" => "events",
											"sectionTitle" => "ÉVÉNEMENTS À VENIR",
											"sectionShadow" => true,
											"msgNoItem" => "Aucun événement à afficher",
											"imgShape" => "square",
											"useDesc" => true,
											"useBorderElement"=>$useBorderElement,

											"styleParams" => array(	"bgColor"=>"#f1f2f6",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    ?>

    <!-- PROJETS Section -->

    <?php   if(@$projects && sizeOf(@$projects)>0){

	    		$sectionTitle = "MES PROJETS";
	    	    if(@$typeItem != "citoyens") $sectionTitle = "NOS PROJETS";
	    	    
	    		$this->renderPartial('../pod/sectionElements', 
	    								array(  "items" => $projects,
												"sectionKey" => "projects",
												"sectionTitle" => "NOS PROJETS",
												"sectionShadow" => true,
												"msgNoItem" => "Aucun projet à afficher",
												"imgShape" => "square",
												"useDesc" => false,
												"useBorderElement"=>$useBorderElement,

												"styleParams" => array(	"bgColor"=>"#FFF",
																  		"textBright"=>"dark",
																  		"fontScale"=>3),
												));
    		}
	?>

	
	<!-- COMMUNAUTE Section -->

    <?php
    		$sectionTitle = "COMMUNAUTÉ";
    	    if(@$typeItem == "organizations") $sectionTitle = "NOS MEMBRES";
    	    if(@$typeItem == "projects") $sectionTitle = "ILS CONTRIBUENT AU PROJET";
    	    if(@$typeItem == "events") $sectionTitle = "LES PARTICIPANTS";
    	    
    	    if(@$members && sizeOf(@$members)>0)
    		$this->renderPartial('../pod/sectionElements', 
    								array(  "items" => $members,
											"sectionKey" => "directory",
											"sectionTitle" => $sectionTitle,
											"sectionShadow" => true,
											"msgNoItem" => "Aucun contact à afficher",
											"imgShape" => "square",
											"useDesc" => false,
											"useBorderElement"=>$useBorderElement,
											"countStrongLinks"=>$countStrongLinks,

											"styleParams" => array(	"bgColor"=>"#FFF",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    ?>

    

	<!-- COMMUNAUTE Section -->

    <?php
    		$sectionTitle = "COMMUNAUTÉ";
    	    if(@$typeItem == "organizations") $sectionTitle = "NOS MEMBRES";
    	    if(@$typeItem == "projects") $sectionTitle = "ILS CONTRIBUENT AU PROJET";
    	    if(@$typeItem == "events") $sectionTitle = "LES PARTICIPANTS";
    	    
    	    if(@$members && sizeOf(@$memberOf)>0)
    		$this->renderPartial('../pod/sectionElements', 
    								array(  "items" => $memberOf,
											"sectionKey" => "directory",
											"sectionTitle" => $sectionTitle,
											"sectionShadow" => true,
											"msgNoItem" => "Aucun contact à afficher",
											"imgShape" => "square",
											"useDesc" => false,
											"useBorderElement"=>$useBorderElement,
											"countStrongLinks"=>$countStrongLinks,

											"styleParams" => array(	"bgColor"=>"#FFF",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    ?>

    

	<?php if (($type==Project::COLLECTION) && !empty($element["properties"]["chart"])){ ?>
	<section id="projects-values" class="portfolio shadow">
		<div class="container">
			<div class="row">
	            <div class="col-lg-12 text-center">
	                <h2>Les valeurs du projet<br><i class="fa fa-angle-down"></i></h2>
	            </div>
	        </div>
            <div class="row">
        		<div class="no-padding col-md-8 col-md-offset-2">
					<?php

						if(empty($element["properties"]["chart"])) $element["properties"]["chart"] = array();
						$this->renderPartial('../project/pod/projectChart',array(
												"itemId" => (string)$element["_id"], 
												"itemName" => $element["name"], 
												"properties" => $element["properties"]["chart"],
												"admin" =>$edit,
												"isDetailView" => 1,
												"openEdition" => $openEdition,
												"chartAlone" => true));
					?>						  
				</div>
			</div>
		</div>
	</section>
	<?php } ?>

    <!-- FREE Section -->

    <?php  
    	/*$items = array( array("name"=>"", "shortDescription"=>" Le 8 septembre dernier, LA MAISON DES CITOYENS est née pour permettre à tous les Français qui ne comptent pas de compter tous ensemble, et être en capacité de défendre trois valeurs essentielles : nos territoires et ceux qui agissent, la démocratie citoyenne, la diversité et la fraternité."),
    						// array("name"=>"Utiliser les POI ?", "shortDescription"=>"Pour construire les block libres ?<br>Textes<br>Images<br>Video<br>GeoPos<br>Url<br>etc"),
    						// array("name"=>"Lorem ratione", "shortDescription"=>"Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet"),
    					);

    		$this->renderPartial('../pod/sectionElements', 
    								array(  "items" => $items,
											"sectionKey" => "freep",
											"sectionTitle" => "Le manifeste",
											"sectionShadow" => true,
											"msgNoItem" => "Aucun projet à afficher",
											"imgShape" => "circle",
											"useImg" => false,
											"fullWidth" => true, //only for 1 element

											"styleParams" => array(	"bgColor"=>"#f1f2f6",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
	*/
	?>

	<section id="timeline" class="bg-white inline-block col-md-12 shadow">
		<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section" 
			    data-id="#timeline">
	        	<i class="fa fa-cog"></i>
	    </button>


        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">
                    <span class="sec-title">Actualité récente</span><br>
                    <i class="fa fa-angle-down"></i>
                </h2>
            </div>
        </div>

		<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
			<ul class="timeline inline-block" id="timeline-page">
		</ul>


	</section>

    <!-- Contact Section -->
    <section id="contact" class="hidden">
        <div class="container ">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Contact Me</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" id="name" required data-validation-required-message="Please enter your name.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" placeholder="Phone Number" id="phone" required data-validation-required-message="Please enter your phone number.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Message</label>
                                <textarea rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <br>
                        <div id="success"></div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-success btn-lg">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <section class="text-center footer bg-section-dark2 light" id="footer">
    	<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section margin-top-10" data-id="#footer">
	        <i class="fa fa-cog"></i>
	    </button>
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Addresse</h3>
                        <p>
                        	<?php if(@$element["address"] && @$element["address"]["streetAddress"]) 
	                			  	echo $element["address"]["streetAddress"]."<br>";

	                			  if(@$element["address"] && @$element["address"]["addressLocality"]) {
	                				echo "<i class='fa fa-map-marker'></i> ".$element["address"]["addressLocality"];
	                				if(@$element["address"]["postalCode"]) echo ", ";
	                			  }
	                			  if(@$element["address"] && @$element["address"]["postalCode"]) 
	                			  	echo $element["address"]["postalCode"];

	                			  if(@$element["address"] && @$element["address"]["addressCountry"]) 
	                			  	echo "<br>".$element["address"]["addressCountry"];

	                			  if(!@$element["address"]){ echo "Addresse non renseignée"; }
	                		?>
                        </p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Sur le web</h3>
                        <ul class="list-inline">
                        	<?php if(@$element["socialNetwork"]){ ?>
	                            <?php if(@$element["socialNetwork"]["facebook"] && @$element["socialNetwork"]["facebook"] != ""){ ?>
		                            <li>
		                                <a href="<?php echo @$element["socialNetwork"]["facebook"]; ?>" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
		                            </li>
		                        <?php } ?>
	                            <?php if(@$element["socialNetwork"]["googleplus"] && @$element["socialNetwork"]["googleplus"] != ""){ ?>
	                            <li>
	                                <a href="<?php echo @$element["socialNetwork"]["googleplus"]; ?>" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
	                            </li>
		                        <?php } ?>
	                            <?php if(@$element["socialNetwork"]["twitter"] && @$element["socialNetwork"]["twitter"] != ""){ ?>
	                            <li>
	                                <a href="<?php echo @$element["socialNetwork"]["twitter"]; ?>" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
	                            </li>
		                        <?php } ?>
	                            <?php if(@$element["socialNetwork"]["github"] && @$element["socialNetwork"]["github"] != ""){ ?>
	                            <li>
	                                <a href="<?php echo @$element["socialNetwork"]["github"]; ?>" class="btn-social btn-outline"><i class="fa fa-fw fa-github"></i></a>
	                            </li>
		                        <?php } ?>
	                        <?php }else{ ?>
	                        	<li>
	                                <i class="fa fa-ban"></i> Aucune information
	                            </li>
	                        <?php } ?>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>A propos de nous</h3>
                        <?php echo @$element["shortDescription"] ? @$element["shortDescription"] 
                        											: "<i class='fa fa-ban'></i> Aucune description"; ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="footer-below">
            <div class="container padding-15">
                <div class="row">
                    <div class="col-md-12">
	                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/kgougle_social.png" height=50><br><br>
	                    <span class="font-blackoutT text-yellow-PH" style="font-size:20px;">by</span> 
	                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGO_PIXEL_HUMAIN.png" height=70>
	                </div>
                </div>
            </div>
        </div> -->
    </section>
    <?php 
    	$mapData = array();
    	$mapData = @$members ? array_merge($members, $mapData) : array();
    	$mapData = @$projects ? array_merge($projects, $mapData) : array();
    	$mapData = @$events ? array_merge($events, $mapData) : array();

    	$controler = Element::getControlerByCollection($typeItem) ;
    ?>
</div>

    <script type="text/javascript" >
    
    var elementName = "<?php echo @$element["name"]; ?>";
    var mapData = <?php echo json_encode(@$mapData) ?>;
    var params = <?php echo json_encode(@$params) ?>;
    var contextData = <?php echo json_encode( Element::getElementForJS(@$element, @$type) ); ?>; 
	
    //console.dir("allparams", params);
    var currentIdSection = "";
	jQuery(document).ready(function() {
		
		//initKInterface({"affixTop":0});
	
		//$(".dropdown-onepage-main-menu").hide();
		$("#main-page-name, title").html(elementName);

		$(".dropdown-onepage-main-menu li a").click(function(e){
			e.stopPropagation();
			var target = $(this).data("target");
			//console.log(target);
			KScrollTo(target);
		});

		console.log("body width", $("body").width());
		if($("body").width()>767)
		$("#btn-onepage-main-menu").trigger("click");

        $(".btn-full-desc").click(function(){
            var sectionKey = $(this).data("sectionkey");
            if($("section#"+sectionKey+" .item-desc").hasClass("fullheight")){
                $("section#"+sectionKey+" .item-desc").removeClass("fullheight");
                $(this).html("<i class='fa fa-plus-circle'></i>");
            }else{
                $("section#"+sectionKey+" .item-desc").addClass("fullheight");
                $(this).html("<i class='fa fa-minus-circle'></i>");
            }
        });

		Sig.showMapElements(Sig.map, mapData);

		//showElementPad('news');
		var url = "news/index/type/<?php echo (string)$element["type"] ?>/id/<?php echo (string)$element["_id"] ?>?isFirst=1&";
		//console.log("URL", url);
		ajaxPost('#timeline-page', baseUrl+'/'+moduleId+'/'+url+"renderPartial=true&tpl=co2&nbCol=2", 
			null,
			function(){ 
				
		},"html");
	});
	



	</script>

    <?php $this->renderPartial('../element/sectionEditTools', 
			array("type"=>Element::getControlerByCollection($typeItem),
				  "id"=>$element["_id"],
				  "element"=>$element)); 
    ?>
