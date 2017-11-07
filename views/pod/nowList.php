<?php 
    /*if(Yii::app()->session["userId"] != $element["_id"] &&
      !Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"]))
        echo "pouetttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt";
       // return;  

    echo Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"]) ? "yes" : "no";*/
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    $CO2DomainName = isset(Yii::app()->params["CO2DomainName"]) ? Yii::app()->params["CO2DomainName"] : "CO2";
?>

<style> 
    hr.angle-down::after {
        background-color: #e6344d;
    }
    hr.angle-down{
        border-color: #e6344d;
    }
    .el-nowList{
        cursor: pointer;
    }
</style>

<?php if(empty($result) && !@Yii::app()->session["userId"]){ ?>
    <h4 class="text-dark text-center">
        Aucune donnée relative à votre communexion n'a été trouvée
    </h4>
<?php } ?>

<div class="col-xs-12 no-padding col-nowList"  data-tpl="pod.nowList">
	<?php if((!@$scope || @$scope=="")){ 
			if($type=="citoyens" && $id==@Yii::app()->session["userId"]){ 
			 $this->renderPartial($layoutPath.'pod.'.Yii::app()->params["CO2DomainName"].".notCommunected");
            } 
    ?>
    <?php } else { ?>
        <h6 class="no-margin header-nowList" style="font-size:13px">
            <i class="fa fa-cog letter-red hidden"></i> <i class="fa fa-bell"></i> 
            <?php echo Yii::t("common","Territorial activity") ?>

            <br>

             <?php
                if($CO2DomainName == "kgougle"){ ?>
                    <button class="btn btn-link letter-red btn-xs pull-left no-padding btn-change-loc" 
                            data-toggle="modal" data-target="#modalLocalization">
                        <i class="fa fa-map-marker"></i> <?php echo $scope; ?>
                    </button>
                    <br>
            <?php }else{ ?>
                <small class="text-red"><i class="fa fa-map-marker"></i> <?php echo $scope; ?></small>
            <?php } ?>
        </h6>

        

        <hr class="angle-down">
        <center>
            <button class="btn btn-default btn-sm btn-show-onmap block" id="btn-show-activity-onmap">
                <i class="fa fa-map-marker"></i> <?php echo Yii::t("common","Show on the map") ?>
            </button>
        </center>
        <br>
        <!-- <hr class="margin-5 margin-bottom-10"> -->

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
        <!-- <a href="#page.type.<?php echo @$v["type"] ?>.id.<?php echo (@$v["_id"]?$v["_id"]:@$v["id"]); ?>"  -->

        <div class="shadow2 border-left-<?php echo @$specs["text-color"]?> margin-bottom-5 col-xs-12 no-padding el-nowList <?php echo $type?> <?php echo $class; ?>" data-type="<?php echo @$v["type"] ?>" data-id="<?php echo (@$v["_id"]?$v["_id"]:@$v["id"]); ?>">
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
                if(@$v["_id"])
                    $id = (string)@$v["_id"];
                else if(@$v["id"])
                    $id = $v["id"];
                //echo ($type) ? Element::getLink(@$type."s",$id) : "no type"; //echo @$type;?>
            </div><br>
            <div class="elemt_date pull-left text-left elipsis">
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
        </div>
        <div class="previewLocalActivity hidden" id='localActivity<?php echo @$v["type"] ?><?php echo (@$v["_id"]?$v["_id"]:@$v["id"]); ?>'>
        </div>
        <?php } ?>

    <?php } ?>
</div>

<?php if($CO2DomainName == "kgougle"){ 
        $this->renderPartial($layoutPath.'modals/'.Yii::app()->params["CO2DomainName"]."/citiesNC");
      } 
?>

<script type="text/javascript" >

var localActivity = <?php echo json_encode($result); ?>;

jQuery(document).ready(function() {
    console.log("LIVENOW", localActivity);
    $.each(localActivity, function(key, data){
        if(typeof data.geo != "undefined" && data.geo.latitude == "")
        console.log("LIVENOW geo", data.geo, data);
    });
    // $(".elemt_date").each(function() {
    //     var elementTime = $(this).children(".dateTZ").attr("data-time");
    //     var elementDate = new Date(elementTime * 1000);
    //     $(this).children(".dateTZ").text(elementDate.toLocaleDateString() + " " + elementDate.toLocaleTimeString());
    // });
    
    $("#btn-show-activity-onmap").click(function(){
        Sig.showMapElements(Sig.map, localActivity, "clock-o", "Activité territoriale");
        showMap(true);
    });
    //$('#mapLegende').html("<i class='fa fa-clock-o'></i> Activité territoriale");
    //$('#mapLegende').show();

    $(".el-nowList").click(function(){
        var id = $(this).data("id");
        var type = $(this).data("type");
        console.log("try open", id, type);
        var data = "";
        $.each(localActivity, function(key, value){
            if(key==id) data = Object.assign({}, value);
        });
        console.log("try open data", data);

        $(".el-nowList").removeClass("hidden");
        $(this).addClass("hidden");
        $(".previewLocalActivity").addClass("hidden");
        $(".previewLocalActivity").html("");
        
        if(data!=""){
            var html = directory.showResultsDirectoryHtml(new Array(data), type);
            console.log("try open html", html);
            $("#localActivity"+type+id).html(html);
            $("#localActivity"+type+id).removeClass("hidden");
            $("#localActivity"+type+id).off().mouseleave(function(){
                $(this).addClass("hidden").html("");
                $(".el-nowList").removeClass("hidden");
            });
            bindLBHLinks();
            initBtnShare();
        }

    });

    $(".btn-communecter").click(function(){
        communecterUser();
    });

    if(typeof contextData.address.addressLocality != "undefined")
    $(".btn-change-loc").append(" - " + contextData.address.addressLocality);
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