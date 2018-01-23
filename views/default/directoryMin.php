<style>

</style>

<?php if(sizeof($result) > 0 && @$title){ ?>
    <h5 class="titleDirMin"><i class="fa fa-angle-down"></i> <?php echo $title; ?></h5>
<?php } ?>

<?php

    if(false)
    foreach ($result as $key => $v) { 
        $specs = Element::getElementSpecsByType(@$v["type"]);

        $type = null;
        if(@$specs) $type = @$v["type"];
        else if(@$v["typeSig"]) $type = $v["typeSig"];

        $class = "";
        $img = Element::getImgProfil($v, "profilThumbImageUrl", $this->module->assetsUrl);
        if(!@$v["profilMediumImageUrl"] || $v["profilThumbImageUrl"] == "") 
            $class = "no-img";

        $elUrl = Element::getHash($v);
        $v["updatedLbl"] = Translate::pastTime(@$v["updated"], "timestamp");
    ?>

    <a href="<?php echo $elUrl; ?>" class="<?php if(!@$target){ ?>lbh<?php } ?> shadow2 margin-bottom-5 col-xs-12 no-padding el-dirMin <?php echo $type." ". $class; ?>" <?php if(@$target=="blank") { ?> target="_blank"<?php } ?>>
        <div class="pull-left no-padding cnt-img">
            <div class="add2fav elemt_img">
                <img src="<?php echo $img ?>" class="pull-left hidden-xs">
            </div>
        </div>
        <div class="pull-left elemt_name elipsis">
            <i class="fa fa-<?php echo $specs["icon"]?> text-<?php echo @$specs["text-color"]?>"></i> 
            <span class=""><?php echo $v["name"]; ?></span>
            <?php 
                $id = null;
                if(@$v["_id"]) $id = (string)@$v["_id"];
                else if(@$v["id"])  $id = $v["id"];
            ?>
        </div><br>
        <div class="elemt_date pull-left text-left elipsis">
            <span class="dateTZ">
                <?php echo @$v["updatedLbl"]; ?>
                <?php if(@$v["price"]) echo " | <span class='text-azure'>" .@$v["price"].' '.@$v["devise"].'</span>';?> 
            </span> 
            <?php if(@$v["address"]["addressLocality"]) { ?>        
            <span class="address text-red">
                <i class="fa fa-map-marker margin-left-5"></i> <?php echo @$v["address"]["addressLocality"]; ?> 
            </span>
            <?php } ?> 
        </div>

        <?php if(@$v["tags"]) { ?>
        <div class="pull-left elipsis el-tags">
            <?php foreach($v["tags"] as $tag) { ?>        
            <small class="letter-red bold">
                #<?php echo $tag; ?> 
            </small>
            <?php } ?> 
        </div>
        <?php } ?> 
    </a>
<?php } ?>



<script type="text/javascript" >
  
var result = <?php echo json_encode($result) ; ?>;

jQuery(document).ready(function() { 
    var res = directory.showResultsDirectoryHtml(result);
    $("#resUrl").append(res);
});

</script> 