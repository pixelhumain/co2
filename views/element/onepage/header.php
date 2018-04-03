<!-- Header -->
<section class="header" id="header">
	<?php if(@$edit==true){ ?>
    	<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section margin-top-70" 
    	data-id="#header">
	        <i class="fa fa-cog"></i>
	    </button>
    <?php } ?>
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
                </div>

                <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12 btn-tools margin-top-10 margin-bottom-10">

                    <?php if(@$edit == true){ ?>
                    		<button class="btn btn-default btn-update-info">
                    				 <i class="fa fa-pencil hidden-xs"></i>
                    				 Editer les informations 
                    		</button>
                    <?php } ?>


                    <a href="<?php echo $hash; ?>" class="btn btn-default lbh"> 
                    	<i class="fa fa-user-circle"></i> Page de profil
                    </a>

                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 intro-text">
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

                    <span class="name"><?php echo @$element["name"]; ?></span>
                    <br>

                    <span class="skills"><?php echo nl2br(@$element["shortDescription"]); ?></span>
                    <br>

                    <?php if((@$element["preferences"]["publicFields"] && 
                             in_array("locality", @$element["preferences"]["publicFields"])) ||
                             @$element["type"] != Person::COLLECTION){ ?>
                        <div class="commune text-red homestead margin-top-10">
                            <?php if(@$element["address"] && @$element["address"]["addressLocality"]) {
                                    echo "<i class='fa fa-map-marker'></i> ".$element["address"]["addressLocality"];
                                    if(@$element["address"]["streetAddress"]) echo ", ";
                                    else echo " ";
                                  }
                                  if(@$element["address"] && @$element["address"]["streetAddress"]) {
                                    echo "<small>".$element["address"]["streetAddress"]."</small>";
                                    if(@$element["address"]["postalCode"]) echo ", ";
                                  }
                                  if(@$element["address"] && @$element["address"]["postalCode"]) 
                                    echo $element["address"]["postalCode"];
                            ?>
                        </div>
                    <?php } ?>

                    <?php if(@$element["preferences"]["publicFields"] && 
                    		 in_array("email", @$element["preferences"]["publicFields"])){ ?>
                    	<span class="email"><?php echo @$element["email"]; ?></span>
                    <?php } ?>

                    <?php if(@$element["counts"]){ ?>
                    	<br>
                    	<?php foreach(@$element["counts"] as $k => $v){ ?>
                    	<button class="btn btn-default btn-show-community" data-type-community="<?php echo $k; ?>">
                    		<i class="fa fa-link"></i> 
                    		<span class="hidden-xs"><?php echo $v." ".Yii::t("common", $k); ?></span>
                    	</button> 
                    	<?php } ?>
                	<?php } ?>


                    
                    <?php if((@$element["preferences"]["publicFields"] && 
                    		 in_array("phone", @$element["preferences"]["publicFields"])) ||
                    		 @$element["type"] != Person::COLLECTION){ ?>
                    	
                    	<?php if(@$element["telephone"]["fixe"] || @$element["telephone"]["mobile"]){ ?>
                    		<hr class="bold-hr">
                    	<?php } ?>

                    	<?php if(@$element["telephone"]["fixe"]){ ?>
                    		<i class="fa fa-phone"></i>
                    		<span class="phone"><?php echo @$element["telephone"]["fixe"][0]; ?></span>
                    	<?php } ?>
                    	<?php if(@$element["telephone"]["mobile"]){ ?>
                    		<i class="fa fa-phone <?php echo @$element["telephone"]["fixe"] ? "margin-left-15" : ""; ?>"></i>
                    		<span class="phone"><?php echo @$element["telephone"]["mobile"][0]; ?></span>
                    	<?php } ?>

                        <?php if(@$element["telephone"]["fixe"] || @$element["telephone"]["mobile"]){ ?>
                    		<hr class="bold-hr">
                    	<?php } ?>

                    <?php } ?>

                </div>
                
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">		                
                <div class="tags margin-top-15">
                	<?php if(@$element["tags"])
                			foreach ($element["tags"]  as $key => $tag) { ?>
                		<span class="badge bg-red"><?php echo $tag; ?></span>
                	<?php } ?>
                </div>
            </div>

        </div>
    </div>
</section>