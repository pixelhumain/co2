<?php
	$cs = Yii::app()->getClientScript();
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "admin") ); 
?>
<!-- start: PAGE CONTENT -->

<?php
	$cs = Yii::app()->getClientScript();
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "admin") ); 
?>
<!-- start: PAGE CONTENT -->
<style type="text/css">
	#content-view-admin, #goBackToHome{
		display: none;
	}
	#content-social{
		min-height:700px;
		background-color: white;
	}
	.addServices, .show-form-new-circuit{
		display:none;
	}
</style>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding" id="content-social">

	<?php if(@Yii::app()->session["userIsAdmin"]){ ?>
	<div class="col-md-12 col-sm-12 col-xs-12" id="navigationAdmin">
		<div class="col-md-12 col-sm-12 col-xs-12 text-center">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-min.png" 
	                     class="" height="100"><br/>
	         <h3><?php echo Yii::t("common","Administration portal") ?></h3>
   		</div> 
		<ul class="list-group text-left no-margin">
		<?php if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a href="javascript:;" class=" text-yellow" id="btn-directory" style="cursor:pointer;">
					<i class="fa fa-user fa-2x"></i>
					<?php echo Yii::t("admin", "Directory"); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-green" id="btn-importdata" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-upload fa-2x"></i>
					<?php echo Yii::t("admin", "IMPORT DATA"); ?>
				</a>
			</li>
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="letter-blue" id="btn-adddata" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-plus fa-2x"></i>
					<?php echo Yii::t("admin", "ADD DATA"); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-dark" id="btn-log" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-list fa-2x"></i>
					<?php echo Yii::t("admin", "LOG"); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-red" id="btn-moderate" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-check fa-2x"></i>
					<?php echo Yii::t("admin", "MODERATION"); ?>
				</a>
			</li>
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-orange" id="btn-statistic" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-bar-chart fa-2x"></i>
					<?php echo Yii::t("admin", "STATISTICS"); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-yellow" id="btn-mailerror" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-envelope fa-2x"></i>
					<?php echo Yii::t("admin", "MAILERROR"); ?>
				</a>
			</li>

			<!-- <li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#admin.view.openagenda">
					<i class="fa fa-calendar fa-2x"></i>
					<?php echo Yii::t("admin", "OPEN AGENDA", null, Yii::app()->controller->module->id); ?>
				</a>
			</li> -->

			<!-- <li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#admin.view.checkgeocodage">
					<i class="fa fa-map fa-2x"></i>
					<?php echo Yii::t("admin", "CHECK GEOCODAGE", null, Yii::app()->controller->module->id); ?>
				</a>
			</li> -->
			<!-- <li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-green" style="cursor:pointer;" href="#admin.view.checkcities">
					<i class="fa fa-list fa-2x"></i>
					<?php echo Yii::t("admin", "CHECK CITIES", null, Yii::app()->controller->module->id); ?>
				</a>
			</li> -->
			<!-- <li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.view.cities">
					<i class="fa fa-university fa-2x"></i>               
					<?php echo Yii::t("admin", "CITIES", null, Yii::app()->controller->module->id); ?>              
				</a>
			</li> -->
		<?php 	} ?>
			<?php if( Role::isSourceAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ){ ?>
			<li class="list-group-item text-red col-md-4 col-sm-6 ">
				<a class="lbh" style="cursor:pointer;" href="#stat.chart">
					<i class="fa fa-plus fa-2x"></i>
					<?php echo Yii::t("admin", "SOURCE ADMIN", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>
			<?php	} ?>
		</ul>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="goBackToHome">
		<a href="javascript:;" class="col-md-12 col-sm-12 col-xs-12 padding-20 text-center bg-orange" id="btn-home" style="font-size:20px;"><i class="fa fa-home"></i> Back to administrator home</a>
	</div>
	<div id="content-view-admin" class="col-md-12 col-sm-12 col-xs-12 no-padding"></div>
	<?php }else{ ?>
	<div class="col-md-12 col-sm-12 col-xs-12 text-center margin-top-50">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-min.png" 
	                     class="" height="100"><br/>
	         <h3><?php echo Yii::t("common","Administration portal") ?></h3>
   		</div>
		<div class="col-md-10 col-sm-10 col-xs-10 alert-danger text-center margin-top-20"><strong><?php echo Yii::t("common","You are not authorized to acces adminastrator panel ! <br/>Connect you or contact us in order to become admin system") ?></strong></div>
	<?php } ?>
</div>
<!-- end: PAGE CONTENT-->
<script type="text/javascript">
	//	initKInterface(); 
	var superAdmin="<?php echo @Yii::app()->session["userIsAdmin"] ?>";
	var edit=true;
	var hashUrlPage = "#admin";
	var subView="<?php echo @$_GET['view']; ?>";
	var dir="<?php echo @$_GET['dir']; ?>";
	jQuery(document).ready(function() {
		//loadDetail(true);
		if(superAdmin == ""){
			urlCtrl.loadByHash("");
			bootbox.dialog({message:'<div class="alert-danger text-center"><strong><?php echo Yii::t("common","You are not authorized to acces adminastrator panel ! <br/>Connect you or contact us in order to become admin system") ?></strong></div>'});
		}
		bindAdminButtonMenu();
		initKInterface();
		getAdminSubview(subView, dir);
		//KScrollTo("#topPosKScroll");
	});
	//function goProAccount(){
	//	urlCtrl.loadByHash("#page.type.citoyens.id."+contextData.id+".view.pro");
	//}
	function getAdminSubview(sub, dir){ console.log("getProfilSubview", sub, dir);
		if(sub!=""){
			if(sub=="directory")
				loadDirectory();
			else if(sub=="log")
				loadLog();
			else if(sub=="importdata")
				loadImport();
			else if(sub=="moderate")
				loadModerate();
			else if(sub=="statistic")
				loadStatistic();
			else if(sub=="mailerror")
				loadMailerror();
			else if(sub=="adddata")
				loadAdddata();
			/*else if(sub=="backups")
				loadBackup();
			else if(sub=="bookings"){
				loadListPro();
			}*/
		} else
			loadIndex();
	}
	function bindAdminButtonMenu(){
		/*$(".nav-link").click(function(){
			$(".podDash .nav .nav-item").removeClass("active");
			$(this).parent().addClass("active");
		});*/

		$("#btn-home").click(function(){
			location.hash=hashUrlPage;
			loadIndex();
		});
		$("#btn-directory").click(function(){
			location.hash=hashUrlPage+".view.directory";
			loadDirectory();
		});
		$("#btn-log").click(function(){
			location.hash=hashUrlPage+".view.log";
			loadLog();
		});
		$("#btn-importdata").click(function(){
			location.hash=hashUrlPage+".view.importdata";
			loadImport();
		});
		$("#btn-moderate").click(function(){
			location.hash=hashUrlPage+".view.moderate";
			loadModerate();
		});
		$("#btn-statistic").click(function(){
			location.hash=hashUrlPage+".view.statistic";
			loadStatistic();
		});
		$("#btn-mailerror").click(function(){
			location.hash=hashUrlPage+".view.mailerror";
			loadMailerror();
		});
		$("#btn-adddata").click(function(){
			location.hash=hashUrlPage+".view.adddata";
			loadAdddata();
		});
		$(".btn-open-form").click(function(){
			dyFObj.openForm($(this).data("form-type"),"sub");
		});
	}
	function loadIndex(){
		initDashboard(true);
		//var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
		//ajaxPost('.content-view-dashboard', baseUrl+'/'+moduleId+'/'+url, null, function(){},"html");
	}
	function loadDirectory(){
		initDashboard();
		initType=["citoyens"];
		data={initType:initType};
		var url = "admin/directory";
		$("#goBackToHome").show(700);
		//showLoader('.content-view-dashboard');
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, data, function(){},"html");
	}
	function loadLog(){
		initDashboard();
		var url = "log/monitoring";
		//showLoader('.content-view-dashboard');
		$("#goBackToHome").show(700);
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, null, function(){},"html");

	}
	function loadModerate(){
		initDashboard();
		var url = "admin/moderate/one";
		//showLoader('.content-view-dashboard');
		$("#goBackToHome").show(700);
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, null, function(){},"html");

	}
	function loadAdddata(){
		initDashboard();
		var url = "adminpublic/adddata";
		//showLoader('.content-view-dashboard');
		$("#goBackToHome").show(700);
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, null, function(){},"html");

	}
	function loadImport(){
		initDashboard();
		var url = "adminpublic/createfile";
		//showLoader('.content-view-dashboard');
		$("#goBackToHome").show(700);
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, null, function(){},"html");

	}
	function loadMailerror(){
		initDashboard();
		var url = "admin/mailerrordashboard";
		//showLoader('.content-view-dashboard');
		$("#goBackToHome").show(700);
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, null, function(){},"html");

	}
	function loadStatistic(){
		initDashboard();
		var url = "stat/chartglobal";
		//showLoader('.content-view-dashboard');
		$("#goBackToHome").show(700);
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, null, function(){},"html");

	}
	
	function showLoader(id){
		$(id).html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");
	}
	function inintDescs() {
		return true;
	}
	function initDashboard(home){
		if(home){
			$("#goBackToHome, #content-view-admin").hide(700);
			$("#navigationAdmin").show(700);
			//$("#goBackToHome .addServices, #goBackToHome .show-form-new-circuit").hide(700);
		} else {
			$("#navigationAdmin").hide(700);
			$("#goBackToHome, #content-view-admin").show(700);
			showLoader('#content-view-admin');
		}
	}
	function descHtmlToMarkdown() {
		mylog.log("htmlToMarkdown");
	}
</script>
<!--<div class="col-lg-offset-1 col-lg-10 col-xs-12 no-padding" id="content-social" style="min-height:700px;">
	<div class="">
		<ul class="list-group text-left no-margin">
		<?php if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.view.directory">
					<i class="fa fa-user fa-2x"></i>
					<?php echo Yii::t("admin", "DIRECTORY", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>
			
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-purple" style="cursor:pointer;" href="#adminpublic.view.createfile">
					<i class="fa fa-upload fa-2x"></i>
					<?php echo Yii::t("admin", "IMPORT DATA", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			 <li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#admin.view.openagenda">
					<i class="fa fa-calendar fa-2x"></i>
					<?php echo Yii::t("admin", "OPEN AGENDA", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#admin.view.checkgeocodage">
					<i class="fa fa-map fa-2x"></i>
					<?php echo Yii::t("admin", "CHECK GEOCODAGE", null, Yii::app()->controller->module->id); ?>
				</a>
			</li> 

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#adminpublic.view.adddata">
					<i class="fa fa-plus fa-2x"></i>
					<?php echo Yii::t("admin", "ADD DATA", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-green" style="cursor:pointer;" href="#log.monitoring">
					<i class="fa fa-list fa-2x"></i>
					<?php echo Yii::t("admin", "LOG", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-green" style="cursor:pointer;" href="#admin.view.checkcities">
					<i class="fa fa-list fa-2x"></i>
					<?php echo Yii::t("admin", "CHECK CITIES", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 link-to-moderate">
				<a class="lbh text-orange" style="cursor:pointer;" href="#admin.view.moderate.one">
					<i class="fa fa-check fa-2x"></i>                 
					<?php echo Yii::t("admin", "MODERATION", null, Yii::app()->controller->module->id); ?>               
				</a>

			<li class="list-group-item col-md-4 col-sm-6 link-to-moderate">
				<a class="lbh text-orange" style="cursor:pointer;" href="#stat.chartglobal">
					<i class="fa fa-bar-chart fa-2x"></i>              
					<?php echo Yii::t("admin", "STATISTICS", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.view.mailerrordashboard">
					<i class="fa fa-envelope fa-2x"></i>                
					<?php echo Yii::t("admin", "MAILERROR", null, Yii::app()->controller->module->id); ?>              
				</a>
			</li>
			 <li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.view.cities">
					<i class="fa fa-university fa-2x"></i>               
					<?php echo Yii::t("admin", "CITIES", null, Yii::app()->controller->module->id); ?>              
				</a>
			</li>
         
<?php 	}
		
		if( Role::isSourceAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ){ ?>
			<li class="list-group-item text-red col-md-4 col-sm-6 ">
				<a class="lbh" style="cursor:pointer;" href="#stat.chart">
					<i class="fa fa-plus fa-2x"></i>
					<?php echo Yii::t("admin", "SOURCE ADMIN", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>
<?php	} ?>
		</ul>
	</div>
</div>-->
<!-- end: PAGE CONTENT-->

<script type="text/javascript">

/*jQuery(document).ready(function() {
	//setTitle("Espace administrateur","cog");
	//Index.init();
	initKInterface();
});*/

</script>