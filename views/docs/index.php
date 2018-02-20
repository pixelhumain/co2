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
#show-menu-xs{
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
.keypan .panel-body{
	min-height: 200px;
}
.keypan hr {
	width: 75%;
    margin: auto;
}
#header-docs .panel-title{
	font-size: 40px;
}
#header-docs .panel-title .sub-title{
	font-size: 20px !important;
	font-style: italic;	
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
	background-color: white;
	}
  
}

@media (min-width: 991px) {
  #menu-left {
    left:0 !important;
  }
}
</style>
<div id="header-doc" class="shadow2">
	<a href='javascript:;' id="show-menu-xs" class="visible-xs visible-sm pull-left" data-placement="bottom" data-title="Menu"><i class="fa fa-bars"></i></a>
	<h2 class="elipsis"><i class="fa fa-book hidden-xs"></i> <?php echo Yii::t("docs", "All <span class='hidden-xs'>you need to know</span> about") ?></h2>
	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-head-search.png" 
                     class="logo-menutop main pull-left" height=30>
    <!--<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-min.png" 
                     class="logo-menutop main pull-left visible-xs visible-sm" height=30>-->
</div>
<div id="menu-left" class="col-md-3 col-sm-2 col-xs-12 shadow2">
  	<ul class="col-md-12 col-sm-12 col-xs-12 no-padding">
		<li class="col-xs-12 no-padding">
			<a href="javascript:" class="link-docs-menu active down-menu" data-type="welcome" data-dir="<?php echo Yii::app()->language ?>">
				<i class="fa fa-angle-down"></i> <?php echo Yii::t("docs","WEL<span class='text-red'>CO</span>ME"); ?>
			</a>
		</li>
		<li class="col-xs-12 no-padding">
			<a href="javascript:" class="link-docs-menu down-menu" data-type="about" data-dir="<?php echo Yii::app()->language ?>">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","A<span class='text-red'>BO</span>UT"); ?>
			</a>
			<ul class="subMenu col-xs-12 no-padding">
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="openatlas" data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("common","Open Atlas"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="philosophy" data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","Philosophy"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="projects" data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","Projects"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="keywords" data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","Keywords"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="partners" data-dir="panels">
						<?php echo Yii::t("docs","Community"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="history" data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","History"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="commandement" data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","10 Commands"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="https://github.com/pixelhumain/buildingCommons/blob/master/codeSocialOpenSystem.md" target="_blank" class="">
						<?php echo Yii::t("docs","Social code"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="financement" data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","Funding"); ?>
					</a>
				</li>
			</ul>
		</li>
		<li class="col-xs-12 no-padding">
			<a href="javascript:" class="link-docs-menu down-menu" data-type="modules">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","HOW <span class='text-red'>TO</span> USE"); ?>
			</a>
			<ul class="subMenu col-xs-12 no-padding">
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="elements">
						 <?php echo Yii::t("docs","The elements"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="modules">
						<?php echo Yii::t("docs","Applications"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="import" data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","Game of data"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="faq">
						<?php echo Yii::t("docs","FAQ"); ?>
					</a>
				</li>
			</ul>
		</li>
		<li class="col-xs-12 no-padding">
			<a href="javascript:" class="link-docs-menu down-menu" data-type="help" data-dir="<?php echo Yii::app()->language ?>">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","<span class='text-red'>CO</span>NTRIBUTE"); ?>
			</a>
		</li>
		<li class="col-xs-12 no-padding">
			<a href="javascript:" class="link-docs-menu down-menu" data-type="5w" data-dir="<?php echo Yii::app()->language ?>">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","<span class='text-red'>CO</span>DING"); ?>
			</a>
			<ul class="subMenu col-xs-12 no-padding">
				<li class="col-xs-12 no-padding">
					<a href="api" target="_blank" >
						<?php echo Yii::t("docs","Play with API"); ?>
					</a>
				</li>
				
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="openSourceWeUse"  data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","Open Source We use"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="ocdb"  data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("common","OCDB"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="rd">
					 <?php echo Yii::t("docs","Research&Dev"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="roadmap"  data-dir="<?php echo Yii::app()->language ?>">
						<?php echo Yii::t("docs","RoadMap"); ?>
					</a>
				</li>
			</ul>
		</li>
		
		<li class="col-xs-12 no-padding">
			<a href="javascript:" class="link-docs-menu down-menu"  data-type="contact" data-dir="panels">
				<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","<span class='text-red'>CO</span>MMUNICATE"); ?>
			</a>
			<ul class="subMenu no-padding">
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="contact" data-dir="panels">
						<?php echo Yii::t("docs","Contact"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="affiches" data-dir="communication">
						<?php echo Yii::t("docs","Drawings"); ?>
					</a>
				</li>
				<li class="col-xs-12 no-padding">
					<a href="javascript:" class="link-docs-menu" data-type="video" data-dir="">
					 <?php echo Yii::t("docs","Videos"); ?>
					</a>
				</li>
				<!--<li class="">
					<a href="javascript:" class="link-docs-menu" data-type="media">
						<i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","Medias"); ?>
					</a>
				</li>-->
			</ul>
		</li>
	</ul>
</div>
<div id="container-docs" class="col-md-offset-3 col-md-9 col-sm-12 col-xs-12 no-padding">
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	navInDocs("welcome", mainLanguage);
	$(".link-docs-menu").click(function(){
		if($(this).hasClass("down-menu")){
			//$(".subMenu").hide(700);
			//$(this).parent().find(".subMenu").show(700);
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
		navInDocs($(this).data("type"), $(this).data("dir"), $(this).data("get"));
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
function getConceptList(list, dom){
	str="";
	$.each(list,function(i,obj) { 
		icon = (obj.icon) ? obj.icon : "fa-tag" ;
		color = (obj.color) ? obj.color : "#E33551" ;
		size = (obj.size) ? obj.size : "20" ;
		str+=
		'<div class="col-md-4 col-sm-6 col-xs-12"><div class="keypan panel panel-white">'+
			'<div class="panel-heading border-light ">'+
				'<span class="panel-title">'+ 
					'<i class="fa '+icon+' faa-pulse animated-hover fa-2x"></i>'+
					' <span style="font-size: '+size+'px; color:'+color+';"> <br/>'+obj.title.toUpperCase()+'</span></span>'+
			'</div>'+
			'<hr/>'+
			'<div class="panel-body">'+obj.body+"</div>"+
		"</div></div>";
	 });
	$(dom).html(str);
}
</script>