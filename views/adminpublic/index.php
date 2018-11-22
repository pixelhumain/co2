<?php
	$cs = Yii::app()->getClientScript();
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "adminpublic") ); 
?>
<!-- start: PAGE CONTENT -->


<div class="col-lg-offset-1 col-lg-10 col-xs-12 padding-15" id="content-social" style="min-height:700px;">
	<h2>Admin Public</h2>
	<div class="">
		<ul class="list-group text-left no-margin">
		<?php 
			$roles = Role::getRolesUserId(Yii::app()->session["userId"]) ;
			if( Role::isSourceAdmin( $roles) ||  Role::isSuperAdmin($roles ) ) { ?>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-purple" style="cursor:pointer;" href="#adminpublic.createfile">
					<i class="fa fa-upload fa-2x"></i>
					<?php echo Yii::t("common", "Converter"); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#adminpublic.adddata">
					<i class="fa fa-plus fa-2x"></i>
					<?php echo Yii::t("common", "IMPORT DATA"); ?>
				</a>
			</li>
			
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="lbh text-red" style="cursor:pointer;" href="#adminpublic.mailslist">
					<i class="fa fa-plus fa-2x"></i>
					<?php echo Yii::t("common", "Mails"); ?>
				</a>
			</li>
			<!--<li class="list-group-item text-red col-md-4 col-sm-6 ">
				<a class="lbh" style="cursor:pointer;" href="#adminpublic.chart">
					<i class="fa fa-plus fa-2x"></i>
					<?php //echo Yii::t("common", "SOURCE ADMIN"); ?>
				</a>
			</li> -->
<?php	} ?>
		</ul>
	</div>
</div>
<!-- end: PAGE CONTENT-->

<script type="text/javascript">

jQuery(document).ready(function() {
	//setTitle("Espace administrateur","cog");
	//Index.init();
	initKInterface();
});

</script>