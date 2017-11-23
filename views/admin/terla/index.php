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
		margin-top: 100px;
		min-height:700px;
	}
</style>

<div class="col-lg-offset-1 col-lg-10 col-xs-12 no-padding" id="content-social">
	<div class="col-md-10 col-sm-12 col-xs-12" id="navigationAdmin">
		<ul class="list-group text-left no-margin">
		<?php if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a href="javascript:;" class=" text-yellow" id="btn-community" style="cursor:pointer;">
					<i class="fa fa-user fa-2x"></i>
					<?php echo Yii::t("admin", "Community", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-red" id="btn-services" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-plus fa-2x"></i>
					<?php echo Yii::t("admin", "Services", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-red" id="btn-circuits" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-plus fa-2x"></i>
					<?php echo Yii::t("admin", "Circuits", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-green" style="cursor:pointer;" href="#log.monitoring">
					<i class="fa fa-list fa-2x"></i>
					<?php echo Yii::t("admin", "LOG", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.mailerrordashboard">
					<i class="fa fa-envelope fa-2x"></i>                
					<?php echo Yii::t("admin", "MAILERROR", null, Yii::app()->controller->module->id); ?>              
				</a>
			</li>
			<!-- <li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.cities">
					<i class="fa fa-university fa-2x"></i>               
					<?php echo Yii::t("admin", "CITIES", null, Yii::app()->controller->module->id); ?>              
				</a>
			</li> -->
         
<?php 	} ?>
		
		</ul>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12" id="goBackToHome"><button class="primary" id="btn-home">Retour à l'accueil admin</button></div>
	<div id="content-view-admin"></div>
</div>
<!-- end: PAGE CONTENT-->
<script type="text/javascript">
	//	initKInterface(); 
	var edit=true;
	var hashUrlPage = "#admin";
	var subView="<?php echo @$_GET['view']; ?>";
	jQuery(document).ready(function() {
		//loadDetail(true);
		$(".createPro").click(function(){
			$.ajax({
	    		type: "POST",
	    		url: baseUrl+"/"+moduleId+'/person/updatefield',
	    		data:{pk:userId,name:"professional", value:true},
	            success: function(data){
	            	goProAccount();
	            }
	         });
		});
		bindAdminButtonMenu();
		initKInterface();
		getAdminSubview(subView);
		KScrollTo("#topPosKScroll");
	});
	//function goProAccount(){
	//	urlCtrl.loadByHash("#page.type.citoyens.id."+contextData.id+".view.pro");
	//}
	function getAdminSubview(sub, dir){ console.log("getProfilSubview", sub, dir);
		if(sub!=""){
			if(sub=="community")
				loadCommunity();
			else if(sub=="services")
				loadServices();
			else if(sub=="circuits")
				loadCircuits();
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
		$("#btn-community").click(function(){
			location.hash=hashUrlPage+".view.community";
			loadCommunity();
		});
		$("#btn-circuits").click(function(){
			location.hash=hashUrlPage+".view.circuits";
			loadCircuits();
		});
		$("#btn-services").click(function(){
			location.hash=hashUrlPage+".view.services";
			loadServices();
		});
		$("#btn-backup").click(function(){
			location.hash=hashUrlPage+".view.backup";
			loadBackup();
		});
	}
	function loadIndex(){
		initDashboard(true);
		//var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
		//ajaxPost('.content-view-dashboard', baseUrl+'/'+moduleId+'/'+url, null, function(){},"html");
	}
	function loadCommunity(){
		initDashboard();
		initType=["citoyens"];
		data=initType;
		var url = "admin/directory";
		//showLoader('.content-view-dashboard');
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, data, function(){},"html");
	}
	function loadServices(){
		initDashboard();
		initType=["services"];
		data={initType:initType};
		var url = "admin/directory";
		//showLoader('.content-view-dashboard');
		ajaxPost('#content-view-admin', baseUrl+'/'+moduleId+'/'+url, data, function(){},"html");
	}
	function loadCircuits(){
		initDashboard();
		data={category:["circuits"],actionType:"history"};
		var url = "element/list";
		ajaxPost('.content-view-dashboard', baseUrl+'/'+moduleId+'/'+url, data, function(){},"html");
	}
	function loadBackup(){
		initBtnDash("#btn-backup");
		data={category:["backups"],actionType:"backup"};
		var url = "element/list/type/"+contextData.type+"/id/"+contextData.id;
		showLoader('.content-view-dashboard');
		ajaxPost('.content-view-dashboard', baseUrl+'/'+moduleId+'/'+url, data, function(){},"html");
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
		} else {
			$("#navigationAdmin").hide(700);
			$("#goBackToHome, #content-view-admin").show(700);
			showLoader('.content-view-dashboard');
		}
	}
	function descHtmlToMarkdown() {
		mylog.log("htmlToMarkdown");
	}
</script>