<?php $cssAnsScriptFilesModule = array(
    '/js/default/settings.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

$cssAnsScriptFiles = array(
     '/assets/css/default/settings.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl); 
?>
<style type="text/css">
	#menu-left{
		position: fixed;
    	z-index: 100000;
	    bottom: 0;
	    top: 60px;
	    left: 0;
	    padding: 0;
	    overflow-y: scroll;
	    	background-color: white;
	}
	#header-settings{
		position: fixed;
		z-index: 100000;
		top: 0px;
		left: 0px;
		height: 60px;
		right: 0px;
		padding-top: 10px;
		background-color: white;
	}
	#header-settings h2{
		float: left;
	    color: #354C57;
	    font-size: 20px;
	    font-variant: small-caps;
	    line-height: 41px;
	    padding: 0px 10px;
	}
	#menu-left ul li{
		list-style: none;
	}
	#menu-left > ul > li > a{
		font-size: 20px;
	}
	ul.subMenu > li > a{
		font-size:16px;
	}
	#menu-left > ul > li > a, ul.subMenu > li > a{
		color: #354C57;
		width: 100%;
	    float: left;
	    padding: 5px 20px;
	    text-align: left;
	}
	#menu-left ul li .subMenu, #menu-left > ul > li > a{
		border-bottom: 1px solid #ccc;
	}
	#menu-left > ul > li > a.active, #menu-left > ul > li > a:hover{
		text-decoration: none;
		background-color:#E5344D;
		color: white;
		font-size: 22px;
	}
	ul.subMenu > li > a.active, ul.subMenu > li > a:hover{
		border-left: 4px solid #E5344D;
		color: #E5344D;
		font-size:18px;
		text-decoration: none;
	}
	#menu-left ul li a.active span.text-red, #menu-left ul li a:hover span.text-red{
		color:#354C57 !important;
	}
	.close-modal{
		top: 10px !important;
    	right: 10px !important;
     	z-index: 100000000000000 !important;
    	position: fixed !important;
	}
	.close-modal .lr, .close-modal .rl{
		height: 40px !important;
	}
	ul.subMenu{
		/*display:none;*/

	}
	ul.subMenu{
		padding-left: 30px
	}
#show-menu-xs, #close-settings{
	    padding: 7px 15px;
    font-size: 20px;
}
.keypan .panel-heading{
	margin-top: 20px;
    min-height: 70px;
}
.keypan{
	border: none;
    margin-bottom: 10px;
    box-shadow: none;
}
.keypan, .keypanList{
	box-shadow: none;	
}
.keypanList .panel-title i{
	margin-right: 10px;
}
.keypanList .panel-body ul{
	padding-left: 0px;
}
.keypanList .panel-title span{
	font-size: 24px !important;
}
.keypan .panel-body{
	min-height: 200px;
}
.keypan hr {
	width: 75%;
    margin: auto;
}
#header-settings .panel-title, .subtitleDocs .panel-title {
	font-size: 40px;
}
#header-settings .panel-title .sub-title, .subtitleDocs .panel-title .sub-title{
	font-size: 20px !important;
	font-style: italic;	
}
#container-settings-view{
	background-color: white;
	top:55px;
	overflow-y: scroll;
    bottom: 0px;
    position: fixed;
}
@media (max-width: 991px) {
 /* .open-type-filter{
        display: block;
    position: absolute;
    right: -33px;
    height: 50px;
    width: 50px;
    border: 1px solid #dadada;
    border-radius: 100%;
    text-align: right;
    padding-right: 8px;
    z-index: -1;
    font-size: 20px;
  }*/
  #menu-left{
    width: 56%;
    left: -56%;
	bottom: 0px;
	}
  
}

@media (min-width: 991px) {
  #menu-left {
    left:0 !important;
  }
}
</style>
<div id="header-settings" class="shadow2">
	<a href='javascript:;' id="show-menu-xs" class="visible-xs visible-sm pull-left" data-placement="bottom" data-title="Menu"><i class="fa fa-bars"></i></a>
	<h2 class="elipsis no-margin"><i class="fa fa-cogs hidden-xs"></i> <?php echo Yii::t("settings", "Settings of my accont") ?></h2>
	<a href='javascript:;' class="lbh pull-right" id="close-settings"><span><i class="fa fa-close"></i></span></a>
</div>
<div id="menu-left" class="col-md-3 col-sm-2 col-xs-12 shadow2">
  	<ul class="col-md-12 col-sm-12 col-xs-12 no-padding">
		<li class="col-xs-12 no-padding">
			<a href="javascript:" class="link-docs-menu down-menu" data-page="notificationsAccount">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","Notifications"); ?>
			</a>
			<ul class="subMenu col-xs-12 no-padding">
				<li class="col-xs-12 no-padding">
					<a href="javascript:;" class="link-docs-menu" data-page="notificationsAccount">
						<?php echo Yii::t("common","My account"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:;" class="link-docs-menu" data-page="notificationsCommunity">
						<?php echo Yii::t("docs","My community"); ?>
					</a>
				</li>
			</ul>
		</li>
		<!--<li class="col-xs-12 no-padding">
			<a href="javascript:;" class="link-docs-menu down-menu" data-type="contribute">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","Chat settings"); ?>
			</a>
		</li>-->
		<li class="col-xs-12 no-padding">
			<a href="javascript:" class="link-docs-menu down-menu" data-page="confidentiality">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","Confidentiality"); ?>
			</a>
			<ul class="subMenu col-xs-12 no-padding">
				<li class="col-xs-12 no-padding">
					<a href="javascript:;" class="link-docs-menu" data-page="confidentiality">
						<?php echo Yii::t("common","My account"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:;" class="link-docs-menu" data-page="confidentialityCommunity">
						<?php echo Yii::t("docs","My community"); ?>
					</a>
				</li>
			</ul>
		</li>
	</ul>
</div>
<div id="container-settings-view" class="col-md-offset-3 col-md-9 col-sm-12 col-xs-12 no-padding">
</div>
<script type="text/javascript">
var page="<?php echo @$page ?>";
var initUrlSettings=urlBackHistory;
jQuery(document).ready(function() {
	//hide basic loader on searching view 
	$.unblockUI();
	if(page != "")
		initSettings(page);
	else
		initSettings("notificationsAccount");
	$("#close-settings").off().on("click",function(){
		$("#modal-settings").hide(300);
		if(initUrlSettings.indexOf("#settings") >= 0)
			urlCtrl.loadByHash("#search");
		else{
			onchangeClick=false;
			location.hash=initUrlSettings;
		}
	});
	$(".link-docs-menu").off().on("click",function(){
		if($(this).hasClass("down-menu")){
			$("#menu-left > ul > li > a").removeClass("active").find("i").removeClass("fa-angle-down").addClass("fa-angle-right");
			$(".subMenu .link-docs-menu").removeClass("active");
			$(this).addClass("active").find("i").removeClass("fa-angle-right").addClass("fa-angle-down");
		}else{
			$(".subMenu .link-docs-menu").removeClass("active");
			$(this).addClass("active");
			if(!$(this).parents().eq(2).find(".link-docs-menu:first").hasClass("active")){
				$("#menu-left > ul > li > a").removeClass("active").find("i").removeClass("fa-angle-down").addClass("fa-angle-right");
				$(this).parents().eq(2).find(".link-docs-menu:first").addClass("active").find("i").removeClass("fa-angle-right").addClass("fa-angle-down");
			}
			
		}
		if($("#show-menu-xs").is(":visible")){
			$("#show-menu-xs").removeClass("show-dir");
			$("#menu-left").animate({ left : "-56%" }, 400 );
		}
		onchangeClick=false;
		hashDocs="#settings.page."+$(this).data("page");
		location.hash=hashDocs;
		navInSettings($(this).data("page"));
	});
	$("#show-menu-xs").click(function(){
    if(!$(this).hasClass("show-dir")){
      $(this).addClass("show-dir").data("title", "<?php echo Yii::t("common","Close") ?>").find("i").removeClass("fa-chevron-right").addClass("fa-times");
      $("#menu-left").animate({ left : "0%" }, 400 );
    }else{
      $(this).removeClass("show-dir").data("title", "<?php echo Yii::t("common","Open filtering by type") ?>").find("i").removeClass("fa-times").addClass("fa-chevron-right");
      $("#menu-left").animate({ left : "-56%" }, 400 );
    
    }
  });
});
function initSettings(page){
	navInSettings(page);
	$(".link-docs-menu[data-page='"+page+"']").addClass("active");
	if(!$(".link-docs-menu[data-page='"+page+"']").hasClass("down-menu"))
		$(".link-docs-menu[data-page='"+page+"']").parents().eq(2).find(".down-menu").addClass("active").find("i").removeClass("fa-angle-right").addClass("fa-angle-down");
	else
		$(".link-docs-menu[data-page='"+page+"']").find("i").removeClass("fa-angle-right").addClass("fa-angle-down");
}
function navInSettings(page){
	simpleScroll(0);
	showLoader('#container-settings-view');
	urlToSend="settings/"+page;
	if(page=="confidentiality")
		urlToSend+="/type/citoyens/id/"+userId;
	//if(notNull(dir) && dir !="")
	//	urlToSend+="dir/"+dir+"/";
	ajaxPost('#container-settings-view' ,baseUrl+'/'+moduleId+"/"+urlToSend,
			 null,function(){},"html");
}

</script>