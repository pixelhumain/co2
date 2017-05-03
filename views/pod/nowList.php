<style>
    
    .elemt_name, .elemt_date {
        font-size: 13px;
        height: 25px;
        padding: 5px 10px;
        width: 67%;
        float: left;
        text-overflow: ellipsis;
        overflow: hidden;
        max-width: 100%;
        font-weight: 600;
    }
    .no-img .elemt_name, 
    .no-img .elemt_date {
        width: 100%;
    }
    .no-img .cnt-img{
        display: none;
    }
    .elemt_date {
        font-weight: 200;
        padding-top: 2px;
        font-size: 11px;
    }
    .elemt_name a{
        color:#3C5665;

    }
    .elemt_name a:hover{
       text-decoration: underline !important;
    }
    .elemt_name i.fa{
        /*font-size: 19px;*/
    }
    .col-updated .border-dark {
        border: 0;
        box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.3);
    }
    
    .elemt_img{
        max-height:150px;
        overflow: hidden;
        width:100%;
        text-align:center;
        float:left;
        background: #cfcfcf;

    }
    .elemt_img img{
        min-height: 50px;
    }

    .elemt_img .img-responsive{
        display:inline-block;
    }

    .el-nowList{
        background-color: white;
    }

    .el-nowList:hover{
        width: 300px;
        float: right;
    }
    .el-nowList .address{
        display: inline;
    }
    .el-nowList:hover .address{
        display: inline;
    }

    .el-nowList:hover .elemt_name, 
    .el-nowList:hover .elemt_date {
        width: 80%;
    }
</style>
<div class="col-xs-12 no-padding col-nowList"  data-tpl="pod.nowList">
    <h6 class="no-margin">
        <i class="fa fa-cog letter-red"></i> <i class="fa fa-bell"></i> Mon activité locale<br>
        <small class="text-red"><i class="fa fa-map-marker"></i> <?php echo $scope; ?></small>
    </h6>
    <hr class="margin-5 margin-bottom-10">

    <?php foreach ($result as $key => $v) { 
        $specs = Element::getElementSpecsByType(@$v["type"]);

        $type = null;
        if(@$specs) $type = @$v["type"];
        else if(@$v["typeSig"]) $type = $v["typeSig"];

        $class = "";
        $img = Element::getImgProfil($v, "profilThumbImageUrl", $this->module->assetsUrl);
        if(!@$v["profilMediumImageUrl"] || $v["profilThumbImageUrl"] == "") 
            $class = "no-img";
        //echo "class:".$class;
    ?>
    <a href="#page.type.<?php echo @$v["type"] ?>.id.<?php echo (@$v["_id"]?$v["_id"]:@$v["id"]); ?>"  
        class="lbh shadow2 border-left-<?php echo @$specs["text-color"]?> margin-bottom-5 col-xs-12 no-padding el-nowList <?php echo $type?> <?php echo $class; ?>">
        <div class="pull-left no-padding cnt-img">
            <div class="add2fav elemt_img">
                <img src="<?php echo $img ?>" class="pull-left">
            </div>
        </div>
        <div class="pull-left elemt_name elipsis">
            <i class="fa fa-<?php echo $specs["icon"]?> text-<?php echo @$specs["text-color"]?>"></i> 
            <span class="hidden-xs hidden-sm"><?php echo $v["name"]; ?></span>
            <?php 
            $id = null;
            if(@$v["_id"])
                $id = (string)@$v["_id"];
            else if(@$v["id"])
                $id = $v["id"];
            //echo ($type) ? Element::getLink(@$type."s",$id) : "no type"; //echo @$type;?>
        </div><br>
        <div class="hidden-xs hidden-sm elemt_date pull-left text-left elipsis">
            <span class="dateTZ">
                <?php echo @$v["updatedLbl"];?>
                <?php if(@$v["price"]) echo " | <span class='text-azure'>" .@$v["price"].' '.@$v["devise"].'</span>';?> 
            </span> 
            <?php if(@$v["address"]["addressLocality"]) { ?>        
            <span class="address text-red">
                <i class="fa fa-map-marker margin-left-5"></i> <?php echo @$v["address"]["addressLocality"]; ?> 
            </span>
            <?php } ?> 

            <?php //DDA : if( @$v["organizerType"] && @$v["organizerId"] ) echo "-".Element::getLink( @$v["organizerType"],@$v["organizerId"] )?>
            <?php //DDA : if( @$v["parentType"] && @$v["parentId"] ) echo ">".Element::getLink( @$v["parentType"],@$v["parentId"] )?>

            <?php //if( @$v["creator"] ) echo ">".Element::getLink( Person::COLLECTION,@$v["creator"] )?>
        </div>
    </a>
    <?php } ?>
</div>

<script type="text/javascript" >

jQuery(document).ready(function() {
    // $(".elemt_date").each(function() {
    //     var elementTime = $(this).children(".dateTZ").attr("data-time");
    //     var elementDate = new Date(elementTime * 1000);
    //     $(this).children(".dateTZ").text(elementDate.toLocaleDateString() + " " + elementDate.toLocaleTimeString());
    // });
});

function enlargeNow() { 
    if(!$(".col-feed.closed").length){
        $(".titleNowEvents .btnhidden").show();
        $("#enlargeNow").attr("class","fa fa-caret-right");
        $(".col-feed").attr("class","hidden col-feed closed");
        $(".col-updated").attr("class","col-xs-12 col-updated");
        $("#nowList").attr("class","col-xs-12 no-padding");
        $(".el-nowList").removeClass("col-xs-12").addClass('col-xs-3');
        
    } else {
        $(".titleNowEvents .btnhidden").hide();
        $("#enlargeNow").attr("class","fa fa-caret-left");
        $(".col-feed").attr("class","col-xs-12 col-md-9 col-feed");
        $(".col-updated").attr("class","col-xs-12 col-md-3 col-updated");
        $("#nowList").attr("class","col-xs-12 no-padding");
        $(".el-nowList").removeClass('col-xs-3').addClass("col-xs-12");
    }
}

</script>