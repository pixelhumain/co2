<style type="text/css">
	#menu-left{
		position: fixed;
    	z-index: 100000;
	    bottom: 0;
	    top: 60px;
	    left: 0;
	    padding: 0;
	    overflow-y: scroll;
	}
	#header-doc{
		position: fixed;
		z-index: 100000;
		top: 0px;
		left: 0px;
		height: 60px;
		right: 0px;
		padding-top: 10px;
		background-color: white;
	}
	#header-doc h2{
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
	#menu-left ul li a{
		width: 100%;
	    float: left;
	    padding: 5px 20px;
	    text-align: left;
	    font-size: 16px;
	    border-bottom: 1px solid #ccc;
	    color: #354C57;
	}
	#menu-left ul li a.active, #menu-left ul li a:hover{
		text-decoration: none;
		background-color:#E5344D;
		color: white;
		font-size: 18px;
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
</style>
<div id="header-doc" class="shadow2">
	<button id="show-menu-xs" class="visible-xs tooltips" data-placement="bottom" data-title="Menu"><i class="fa fa-menu"></i></button>
	<h2><i class="fa fa-book"></i><?php echo Yii::t("docs", "All you need to know about") ?></h2>
	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-head-search.png" 
                     class="logo-menutop main pull-left hidden-xs hidden-sm" height=30>
</div>
<div id="menu-left" class="col-md-3 col-sm-2 hidden-xs shadow2">
	<ul class="col-md-12 col-sm-12 col-xs-12 no-padding">
		<li class="">
			<a href="javascript:" class="link-docs-menu active" data-type="welcome" data-dir="<?php echo Yii::app()->language ?>">
				<i class="fa fa-angle-down"></i> <?php echo Yii::t("common","Welcome"); ?>
			</a>
		</li>
		<li class="">
			<a href="javascript:" class="link-docs-menu" data-type="about" data-dir="<?php echo Yii::app()->language ?>">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","<span class='text-red'>CO</span>NNAITRE"); ?>
			</a>
			<ul class="subMenu">
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="philosophy" data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Open Atlas"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="philosophy" data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Philosophy"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="philosophy" data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Projects"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="keywords" data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Keywords"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="partners" data-dir="panels">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Community"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="history" data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","History"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="commandement" data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","The 10 Commands"); ?>
					</a>
				</li>
				<li class="">
					<a href="https://github.com/pixelhumain/buildingCommons/blob/master/codeSocialOpenSystem.md" target="_blank" class="">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Social code"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="financement" data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Model economic"); ?>
					</a>
				</li>
			</ul>
		</li>
		<li role="separator" class="divider"></li>
		<li class="">
			<a href="javascript:" class="link-docs-menu" data-type="modules">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","<span class='text-red'>CO</span>MPRENDRE"); ?>
			</a>
			<ul class="subMenu">
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="elements">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Elements"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="modules">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Modules"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="import" data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Data play"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="faq">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","FAQ"); ?>
					</a>
				</li>
			</ul>
		</li>
		<li class="">
			<a href="javascript:" class="link-docs-menu" data-type="help" data-dir="<?php echo Yii::app()->language ?>">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","<span class='text-red'>CO</span>NSTRUIRE"); ?>
			</a>
		</li>
		<li class="">
			<a href="javascript:" class="link-docs-menu" data-type="code" data-lang="true">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","<span class='text-red'>CO</span>GEEK"); ?>
			</a>
			<ul class="subMenu">
				<li class="">
					<a href="api" target="_blank" >
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Play API"); ?>
					</a>
				</li>
				
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="openSourceWeUse"  data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Open Source We use"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="ocdb"  data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","OCDB"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="rd">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","R&D"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="roadmap"  data-dir="<?php echo Yii::app()->language ?>">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","RoadMap"); ?>
					</a>
				</li>
			</ul>
		</li>
		
		<li class="">
			<a href="javascript:" class="link-docs-menu" data-type="contact" data-lang="true">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","<span class='text-red'>CO</span>MMUNIQUER"); ?>
			</a>
			<ul class="subMenu">
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="contact" data-dir="panels">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Contact"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="philosophy">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Share"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="affiches" data-dir="communication">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Drawings"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="video" data-dir="">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Videos"); ?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="media">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("common","Ils en parlent"); ?>
					</a>
				</li>
			</ul>
		</li>
	</ul>
</div>
<div id="container-docs" class="col-sm-offset-2 col-md-offset-3 col-md-9 col-sm-10 col-xs-12 no-padding">
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	navInDocs("welcome", mainLanguage);
	$(".link-docs-menu").click(function(){
		navInDocs($(this).data("type"), $(this).data("dir"), $(this).data("get"));
		$(".link-docs-menu").removeClass("active").find("i").removeClass("fa-angle-down").addClass("fa-angle-right");
		$(this).addClass("active").find("i").removeClass("fa-angle-right").addClass("fa-angle-down");
	});
});
function navInDocs(page, dir, get){
	showLoader('#container-docs');
	add="";
	if(notNull(dir) && dir !="")
		add="|"+dir;
	//if(notNull(lang))
	//	add=mainLanguage;
	//else
	//	add="panels";
	ajaxPost('#container-docs' ,baseUrl+'/'+moduleId+"/default/view/page/"+page+"/dir/docs"+add,
			 null,function(){},"html");
}
</script>