<style>
.menu-linksBtn{
	padding: 5px 10px !important;
	font-size: 14px !important;
	text-transform: none !important;
	border:none !important;
	border-right:1px solid rgba(255, 255, 255, 0.5) !important;
	margin:0px !important;
	border-radius: 0px !important;
	float: left;
}
.menu-linksBtn i{
	margin:0px !important;
}
.menu-linksBtn .fa-chevron-down{
	font-size: 10px !important;
}
.menu-linksBtn li{
	font-size:12px !important;
}
.blockUsername .dropdown-menu li{
	text-shadow: none !important;
	color: #333;
}
.blockUsername .dropdown-menu a{
	padding:0px 5px !important;
}
.blockUsername .dropdown-menu{
	/*position:absolute!important;*/
	border: 1px solid #ccc !important;
	border-radius: 0px !important;
}
.blockUsername .noHover{
	background-color: white !important;
	font-size: 12px !important;
	font-style: italic;
	padding:0px 5px !important;
}
.littleActions{
	padding-top: 10px !important;
	padding-bottom: 20px !important; 
}
</style>
<?php
	if(@$linksBtn["followBtn"]){
 		if(@$linksBtn["isFollowing"]){ 
 ?>
		<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="javascript:;" class="btn-o menu-btn-follow menu-linksBtn" data-toggle="dropdown">
						<i class="fa fa-rss"></i> <?php echo Yii::t("common","Following") ?> <i class="fa fa-chevron-down"></i>
					</a>
			        <ul class="dropdown-menu">
		                <li class="text-left">
		                    <a href="javascript:;" class="bg-white" onclick="disconnectTo('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>','followers')">
		                        <?php echo Yii::t("common", "Don't follow this page"); ?>
		                    </a>
		                </li>
		            </ul>
          	</li>
        </ul>
<?php 
		}else{ ?>
			<a href="javascript:;" class="btn-o menu-linksBtn" onclick="follow('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>')"> <i class="fa fa-rss"></i> <?php echo Yii::t("common","Follow") ?> </a>
<?php 
		}
	}
	if (@$linksBtn["communityBn"]){
		if($linksBtn["isMember"]==false){ 
?>
			<a href="javascript:;" class="btn-o menu-linksBtn" onclick="connectTo('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>','<?php echo $linksBtn["connectAs"] ?>','<?php echo addslashes($elementName)?>')"> 
				<i class="fa fa-link"></i> <?php echo Yii::t("common","Be {what}", array("{what}"=> Yii::t("common",$linksBtn["connectAs"]))); ?> 
			</a>
<?php 
		} else {
			$labelBtn=Yii::t("common","Already {what}", array("{what}"=>Yii::t("common",$linksBtn["connectAs"])));
			if(@$linksBtn[Link::TO_BE_VALIDATED]){
				$labelBtn=Yii::t("common","Waiting");
				$indicateStatus=Yii::t("common","Waiting an answer to become {what}", array("{what}"=>Yii::t("common",$linksBtn["connectAs"])));
				if(@$linksBtn[Link::IS_ADMIN_PENDING])
					$indicateStatus=Yii::t("common","Waiting an answer to become administrator");
			}
			else if(@$linksBtn["isAdmin"] && $linksBtn["isAdmin"] && !@$linksBtn[Link::IS_ADMIN_PENDING])
				$labelBtn=Yii::t("common","Already admin");
			if(@$linksBtn[Link::IS_ADMIN_PENDING])
					$indicateStatus=Yii::t("common","Waiting an answer to administrate");
?>
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="javascript:;" class="btn-o menu-btn-link menu-linksBtn" data-toggle="dropdown">
						<i class="fa fa-link"></i> <?php echo $labelBtn; ?> <i class="fa fa-caret-down"></i>
					</a>
			        <ul class="dropdown-menu">
			            <?php if(@$indicateStatus){ ?>
			                <li class="text-left italic noHover">
			                <?php echo $indicateStatus; ?>
			                   <!-- <a href="jascript:;" 
			                        class="lbh bg-white">
			                    </a>-->
			                </li>
			            <?php } ?>
			            <?php if (!@$linksBtn["isAdmin"]){ ?>
			            <li class="text-left">
			               	<a href="javascript:;" class="bg-white" onclick="connectTo('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>','admin','<?php echo addslashes($elementName)?>')">
			                    <?php echo Yii::t("common", "Become administrator"); ?>
			                </a>
			            </li>
			            <?php } ?>
			            <li class="text-left">
			               	<a href="javascript:;" class="bg-white" onclick="disconnectTo('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>','<?php echo $linksBtn["connectType"] ?>')">
			                    <?php echo Yii::t("common", "Leave this page"); ?>
			                </a>
			            </li>
			        </ul>
			    </li>
			</ul>
<?php
		}
	}
?>
<?php if ($elementType!= Person::COLLECTION && $elementId!=Yii::app()->session["userId"]){ ?>
<a href="javascript:collection.add2fav('<?php echo $elementType ?>','<?php echo $elementId ?>')"  class="btn-o menu-linksBtn"><i class="fa fa-star"></i> <?php echo Yii::t("common","Favorites"); ?></a>
<?php } ?>
<ul class="nav navbar-nav pull-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle littleActions" data-toggle="dropdown"><span class="fa fa-ellipsis-v pull-left"></span></a>
		<ul class="dropdown-menu pull-right">
			<li>
				<a href="javascript:;" id="btn-show-activity">
					<i class="fa fa-history"></i> <?php echo Yii::t("common","History")?> 
				</a>
			</li>
			<li>
				<a href="javascript:;" onclick="showDefinition('qrCodeContainerCl',true)">
					<i class="fa fa-qrcode"></i> <?php echo Yii::t("common","QR Code") ?></a>
			</li>
			<!--<li><a href="#">Video Call <i class="fa fa-video-camera"></i></a></li>
			<li><a href="#">Poke <i class="fa fa-hand-o-right"></i></a></li>
			<li><a href="#">Report <i class="fa fa-bug"></i></a></li>
			<li><a href="#">Block <i class="fa fa-lock"></i></a></li>-->
		</ul>
	</li>
</ul>		    
<script type="text/javascript">
	jQuery(document).ready(function() {
		$('ul.nav li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
});
		/*$(".menu-btn-follow").click(function(){
	          $("#dropdown-followBtn").addClass("open");
	 	});
	 	$(".menu-btn-link").click(function(){
	          $("#dropdown-link").addClass("open");
	 	});
	 	$(".username .arrow_box").mouseleave(function(){ //alert("dropdown-user mouseleave");
        	$(this).prev().trigger("click").blur();
   		});*/
 	});
</script>