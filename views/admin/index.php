<?php
	$cs = Yii::app()->getClientScript();
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "admin") ); 
?>
<!-- start: PAGE CONTENT -->


<div class="col-md-12 col-sm-12 col-xs-12 bg-white no-padding shadow" id="content-social" style="min-height:700px;">
	<h3 class="panel-title text-blue"><i class="fa fa-connectdevelop"></i> Admin </h3>
	<div class="">
		<ul class="list-group text-left no-margin">
		<?php if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.directory">
					<i class="fa fa-user fa-2x"></i>
					<?php echo Yii::t("admin", "DIRECTORY", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-purple" style="cursor:pointer;" href="#adminpublic.createfile">
					<i class="fa fa-upload fa-2x"></i>
					<?php echo Yii::t("admin", "IMPORT DATA", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#admin.openagenda">
					<i class="fa fa-calendar fa-2x"></i>
					<?php echo Yii::t("admin", "OPEN AGENDA", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#admin.checkgeocodage">
					<i class="fa fa-map fa-2x"></i>
					<?php echo Yii::t("admin", "CHECK GEOCODAGE", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#adminpublic.adddata">
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
				<a class="lbh text-green" style="cursor:pointer;" href="#admin.checkcities">
					<i class="fa fa-list fa-2x"></i>
					<?php echo Yii::t("admin", "CHECK CITIES", null, Yii::app()->controller->module->id); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 link-to-moderate">
				<a class="lbh text-orange" style="cursor:pointer;" href="#admin.moderate.one">
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
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.mailerrordashboard">
					<i class="fa fa-envelope fa-2x"></i>                
					<?php echo Yii::t("admin", "MAILERROR", null, Yii::app()->controller->module->id); ?>              
				</a>
			</li>
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-yellow" style="cursor:pointer;" href="#admin.cities">
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
</div>
<!-- end: PAGE CONTENT-->

<script type="text/javascript">

jQuery(document).ready(function() {
	//setTitle("Espace administrateur","cog");
	//Index.init();
});

</script>