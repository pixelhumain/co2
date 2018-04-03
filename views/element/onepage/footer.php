
    <!-- Footer -->
    <section class="text-center footer bg-section-dark2 light" id="footer">
    	<?php if(@$edit==true){ ?>
	    	<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section margin-top-10" 
	    		data-id="#footer">
		        <i class="fa fa-cog"></i>
		    </button>
	    <?php } ?>
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
    </section>