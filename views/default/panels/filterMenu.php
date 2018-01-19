<?php  if($typeSelected == "services" && Yii::app()->params["CO2DomainName"] == "terla"){ 
          $service = CO2::getContextList("service");
?> 
          <div class="col-lg-2 col-md-3 col-sm-3 col-md-offset-1 col-sm-offset-1 col-xs-12 margin-top-25 text-left subsub no-padding shadow2" id="sub-menu-left">
              <h4 class="bg-orange text-white no-margin padding-10"><?php echo Yii::t("common", "Filters"); ?></h4>      
              <div class="col-md-12 no-padding padding-top-10 padding-bottom-10 label-category" id="title-sub-menu-category">
                <h4 class="col-md-10"><?php echo Yii::t("terla", "Any destination"); ?></h4> <span class="col-md-2 bg-orange"><i class="fa fa-angle-right"></i><span>
              </div>
              <hr>
              <?php 
                  foreach ($service["categories"] as $key => $cat) {
              ?>
                  <div class="col-md-12 text-dark margin-bottom-5">
                      <input type="checkbox" class="btn-select-category-services" data-keycat="<?php echo $key; ?>"> <?php echo Yii::t("category",$cat); ?> 
                    </div><br>
              <?php } ?>
              <div class="col-md-12 no-padding padding-top-10 padding-bottom-10 label-category" id="title-sub-menu-category">
                <h4 class="col-md-10"><?php echo Yii::t("terla", "You travel"); ?></h4> <span class="col-md-2 bg-orange"><i class="fa fa-angle-right"></i><span>
              </div>
              <input type="text" id="filterNumber" value="" placeholder='<?php echo Yii::t("terla", "Number of travellers"); ?>'>
              <label><?php echo Yii::t("terla", "Date of travel"); ?></label>
              <span><?php echo Yii::t("common", "From"); ?></span>
              <input type="date" name=""><br/>
              <span><?php echo Yii::t("common", "To"); ?></span>
              <input type="date" name="">
              <label>Price for search</label>
              <input type="price" name="">
              
              <label><?php echo Yii::t("terla", "Adapted time"); ?></label>
             <div class="col-md-12 text-dark margin-bottom-5">
                <input type="checkbox" class="btn-select-category-services" data-keycat="senior"> <?php echo Yii::t("category","Senior"); ?> 
              </div>
              <div class="col-md-12 text-dark margin-bottom-5">
                <input type="checkbox" class="btn-select-category-services" data-keycat="pmr"> <?php echo Yii::t("category","PMR"); ?> 
              </div>
              <div class="col-md-12 text-dark margin-bottom-5">
                <input type="checkbox" class="btn-select-category-services" data-keycat="famillychild"> <?php echo Yii::t("category","Familly with children"); ?> 
              </div>
              <div class="col-md-12 text-dark margin-bottom-5">
                <input type="checkbox" class="btn-select-category-services" data-keycat="healthfood"> <?php echo Yii::t("category","Food care"); ?>
              </div>
            </div>
        <?php } ?>