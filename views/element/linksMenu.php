<style>
.menu-linksBtn{
	text-shadow: 1px 1px 1px rgb(0,0,0);
	padding: 5px 10px !important;
	font-size: 14px !important;
	text-transform: none !important;
	border:none !important;
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
.no-border-right{
	border-right: inherit;
}
.blockUsername{
	position: absolute;
	bottom: 3px;
	left: 3px;
	right: 3px;
	background-color: rgba(0, 0, 0, 0.5);
}
</style>
<?php
	$visibleXsLinks="";
	if(@$linksBtn["followBtn"]){
 		if(@$linksBtn["isFollowing"]){ 
 			$statusXsMenu=Yii::t("common","You are following {which}",array("{which}"=>Yii::t("common","this ".Element::getControlerByCollection($elementType))));
 			$visibleXsLinks.='<li class="text-left visible-xs">'.
				               	'<a href="javascript:;" class="bg-white text-red" '.
				               		'onclick="disconnectTo(\''.$elementType.'\',\''.$elementId.'\',\''.Yii::app()->session["userId"].'\',\''.Person  ::COLLECTION.'\',\'followers\')">'.
				                    '<i class="fa fa-sign-out"></i> '.Yii::t("common", "Don't follow this page").
				                '</a>'.
			            	'</li>';
 ?>
 		<?php if(!@$xsView){ ?>
		<ul class="nav navbar-nav hidden-xs">
				<li class="dropdown">
					<a href="javascript:;" class="btn-o menu-btn-follow menu-linksBtn hidden-xs" data-toggle="dropdown">
						<i class="fa fa-rss"></i> <?php echo Yii::t("common","Following") ?> <i class="fa fa-chevron-down"></i>
					</a>
			        <ul class="dropdown-menu">
		                <li class="text-left">
		                    <a href="javascript:;" class="bg-white text-red" onclick="disconnectTo('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>','followers')">
		                        <i class="fa fa-sign-out"></i><?php echo Yii::t("common", "Don't follow this page"); ?>
		                    </a>
		                </li>
		            </ul>
          	</li>
        </ul>
        <?php } ?>
<?php 
		}else{ 
			$visibleXsLinks.='<li class="text-left visible-xs">'.
				               	'<a href="javascript:;" class="bg-white" '.
				               		'onclick="follow(\''.$elementType.'\',\''.$elementId.'\',\''.Yii::app()->session["userId"].'\',\''.Person  ::COLLECTION.'\')">'.
				                    '<i class="fa fa-rss"></i> '.Yii::t("common", "Follow this page").
				                '</a>'.
			            	'</li>';
			?>
			<?php if(!@$xsView){ ?>
			<a href="javascript:;" class="btn-o menu-linksBtn hidden-xs" onclick="follow('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>')"> <i class="fa fa-rss"></i> <?php echo Yii::t("common","Follow") ?> </a>
			<?php } ?>
<?php 
		}
	}
	if (@$linksBtn["communityBn"]){
		if($linksBtn["isMember"]==false){ 
			$visibleXsLinks.='<li class="text-left visible-xs">'.
				               	'<a href="javascript:;" class="bg-white" '.
				               		'onclick="connectTo(\''.$elementType.'\',\''.$elementId.'\',\''.Yii::app()->session["userId"].'\',\''.Person  ::COLLECTION.'\',\''.$linksBtn["connectAs"].'\')">'.
				                    '<i class="fa fa-link"></i> '.Yii::t("common","Be {what}", array("{what}"=> Yii::t("common",$linksBtn["connectAs"]))).
				                '</a>'.
			            	'</li>';
?>
		<?php if(!@$xsView){ ?>
			<a href="javascript:;" class="btn-o menu-linksBtn hidden-xs" onclick="connectTo('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>','<?php echo $linksBtn["connectAs"] ?>','<?php echo addslashes($elementName)?>')"> 
				<i class="fa fa-link"></i> <?php echo Yii::t("common","Be {what}", array("{what}"=> Yii::t("common",$linksBtn["connectAs"]))); ?> 
			</a>
		<?php } ?>
<?php 
		} else if(@$linksBtn[Link::IS_INVITING]){ 
			$statusXsMenu=Yii::t("common","Your are inviting to join {what}", array("{what}"=>Yii::t("common","the ".Element::getControlerByCollection($elementType))));
		?>
			<?php if(!@$xsView){ ?>
			<a href="javascript:;" class="btn-o menu-linksBtn hidden-xs"> 
				<i class="fa fa-send"></i> <?php echo Yii::t("common","Inviting")."..."; ?> 
			</a>
			<?php } ?>
		<?php } else {
			$labelBtn=Yii::t("common","Already {what}", array("{what}"=>Yii::t("common",$linksBtn["connectAs"])));
			$statusXsMenu=Yii::t("common","You are {what} of {which}", array("{what}"=>Yii::t("common",$linksBtn["connectAs"]),"{which}"=>Yii::t("common","this ".Element::getControlerByCollection($elementType))));
			if(@$linksBtn[Link::TO_BE_VALIDATED]){
				$labelBtn=Yii::t("common","Waiting");
				$indicateStatus=Yii::t("common","Waiting an answer to become {what}", array("{what}"=>Yii::t("common",$linksBtn["connectAs"])));
				if(@$linksBtn[Link::IS_ADMIN_PENDING])
					$indicateStatus=Yii::t("common","Waiting an answer to become administrator");
				$statusXsMenu=$indicateStatus;
			}
			else if(@$linksBtn["isAdmin"] && $linksBtn["isAdmin"] && !@$linksBtn[Link::IS_ADMIN_PENDING]){
				$labelBtn=Yii::t("common","Already admin");
				$statusXsMenu=Yii::t("common","You are {what} of {which}", array("{what}"=>Yii::t("common","admin"),"{which}"=>Yii::t("common","this ".Element::getControlerByCollection($elementType))));
			}
			if(@$linksBtn[Link::IS_ADMIN_PENDING]){
					$indicateStatus=Yii::t("common","Waiting an answer to administrate");
					$statusXsMenu=$indicateStatus;
			}
?>
			<ul class="nav navbar-nav <?php if(@$xsView) echo "hidden"; ?>">
				<li class="dropdown">
					<a href="javascript:;" class="btn-o menu-btn-link menu-linksBtn hidden-xs" data-toggle="dropdown">
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
			            <?php if (!@$linksBtn["isAdmin"]){ 
			            	$visibleXsLinks.='<li class="text-left visible-xs">'.
				               	'<a href="javascript:;" class="bg-white" '.
				               		'onclick="connectTo(\''.$elementType.'\',\''.$elementId.'\',\''.Yii::app()->session["userId"].'\',\''.Person  ::COLLECTION.'\',\'admin\',\''.addslashes($elementName).'\')">'.
				                    '<i class="fa fa-user-plus"></i> '.Yii::t("common", "Become administrator").
				                '</a>'.
			            	'</li>';
			            ?>
			            	<?php if(!@$xsView){ ?>
				            <li class="text-left hidden-xs">
				               	<a href="javascript:;" class="bg-white" onclick="connectTo('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>','admin','<?php echo addslashes($elementName)?>')">
				                    <i class="fa fa-user-plus"></i><?php echo Yii::t("common", "Become administrator"); ?>
				                </a>
				            </li>
				            <?php } ?>
				        <?php } 
			            	$visibleXsLinks.='<li class="text-left visible-xs">'.
				               	'<a href="javascript:;" class="bg-white text-red" '.
				               		'onclick="disconnectTo(\''.$elementType.'\',\''.$elementId.'\',\''.Yii::app()->session["userId"].'\',\''.Person  ::COLLECTION.'\',\''.$linksBtn["connectType"].'\')">'.
				                    '<i class="fa fa-sign-out"></i> '.Yii::t("common", "Leave this page").
				                '</a>'.
			            	'</li>';
			            ?>
			            <?php if(!@$xsView){ ?>
			            <li class="text-left hidden-xs">
			               	<a href="javascript:;" class="bg-white text-red hidden-xs" onclick="disconnectTo('<?php echo $elementType ?>','<?php echo $elementId ?>','<?php echo Yii::app()->session["userId"] ?>','<?php echo Person  ::COLLECTION ?>','<?php echo $linksBtn["connectType"] ?>')">
			                    <i class="fa fa-sign-out"></i><?php echo Yii::t("common", "Leave this page"); ?>
			                </a>
			            </li>
			            <?php } ?>
			        </ul>
			    </li>
			</ul>
<?php
		}
	}
?>

<?php if ($elementType!= Person::COLLECTION && $elementId!=Yii::app()->session["userId"]){ ?>
	<a href="javascript:collection.add2fav('<?php echo $elementType ?>','<?php echo $elementId ?>')"  
	class="btn-o menu-linksBtn no-border-right <?php if(@$xsView) echo "hidden"; ?> star_<?php echo $elementType.'_'.$elementId; ?>"><i class="fa fa-star-o"></i> <?php echo Yii::t("common","Favorites"); ?></a>
<?php } ?>
<!-- View in menu params // visible only on xs -->
<?php if(@$xsView){ ?>
	<li role="separator" class="divider visible-xs"></li>
	<?php if(@$statusXsMenu){ ?>
	    <li class="text-left noHover visible-xs">
	        <span style="font-size: 10px; font-style: italic; padding:3px 20px;"><?php echo $statusXsMenu; ?></span>
	    </li>
	<?php } ?>
	<?php echo $visibleXsLinks;?>
	<li role="separator" class="divider visible-xs"></li>
<?php } ?>
<!-- End of xs generated -->
<script type="text/javascript">
	var elementType='<?php echo $elementType ?>';
	var elementId='<?php echo $elementId ?>';
	jQuery(document).ready(function() {
		$('ul.nav li.dropdown').hover(function() {
 			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		}, function() {
  			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
		});
		if(typeof userConnected !="undefined" && userConnected!=null
			&& typeof userConnected.collections !="undefined" 
			&& typeof userConnected.collections.favorites !="undefined"
			&& typeof userConnected.collections.favorites[elementType] !="undefined"
			&& typeof userConnected.collections.favorites[elementType][elementId] !="undefined"
			&& $(".star_"+elementType+"_"+elementId).length){
			$(".star_"+elementType+"_"+elementId ).addClass("text-yellow");
			$(".star_"+elementType+"_"+elementId ).children("i").removeClass("fa-star-o").addClass("fa-star");
		}

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