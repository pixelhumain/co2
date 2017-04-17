<?php 
	$cssAnsScriptFilesTheme = array(
		//X-editable
		//'/plugins/x-editable/css/bootstrap-editable.css',
		//'/plugins/x-editable/js/bootstrap-editable.js' , 

		//DatePicker
		'/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js' ,
		'/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js' ,
		'/plugins/bootstrap-datepicker/css/datepicker.css',
			'/plugins/jquery.qrcode/jquery-qrcode.min.js',
		//DateTime Picker
		'/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
		'/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js' , 
		'/plugins/bootstrap-datetimepicker/css/datetimepicker.css',
		//Wysihtml5
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5.css',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5-editor.css',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/wysihtml5x-toolbar.min.js',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5.min.js',
		'/plugins/wysihtml5/wysihtml5.js',
		
		//SELECT2
		'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
		'/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js' ,

		// SHOWDOWN
		'/plugins/showdown/showdown.min.js',
		//MARKDOWN
		'/plugins/to-markdown/to-markdown.js',

	);
	//if ($type == Project::COLLECTION)
	//	array_push($cssAnsScriptFilesTheme, "/assets/plugins/Chart.js/Chart.min.js");
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
	$cssAnsScriptFilesModule = array(
		//Data helper
		'/js/dataHelpers.js',
		'/js/postalCode.js',
		'/js/activityHistory.js',
		'/js/news/index.js',
		'/js/default/editInPlace.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';
	$thumbAuthor =  @$element['profilThumbImageUrl'] ? 
                      Yii::app()->createUrl('/'.@$element['profilThumbImageUrl']) 
                      : "";
?>
<style>
	.img-thumb{
		height: 50px;
		width: 50px;
	}

	.podInside .panel-heading,
	.podInside .panel-tools{
		display:none;
	}
	.podInside .panel,
	.podInside .table{
		margin-bottom: 0px;
		border: 0px;
	}

	.podInside.collections a{
		font-size: 15px;
		font-weight: 700;
		padding:10px;
		display: inline-block;
	}

	.podchart .panel-heading{
		background-color: white !important;
	}

	.favElBtn{
		/*color: #FC4D4D !important;*/
		/*padding: 6px;
		margin-bottom: 4px;*/
	}

	.editBtn{
		float: right;
	}


	.btn-update-info, 
	.btn-update-network, 
	.btn-update-desc{

	}

	a.letter-grey{
		color:#425B5F;
	}



	#subsubMenuLeft hr{
	    margin-top: 7px;
    	margin-bottom: 7px;	
    	border-top: 2px solid #ededed;
	}

	#subsubMenuLeft a{
		color:#5B5B5C;
		font-size: 16px;
		padding: 6px;
		padding-left: 10px;
		display: block;
		text-align: left;
		font-weight: bold;
		border-left: 3px solid transparent;
	}

	#subsubMenuLeft a:hover{
		color:#0095FF;
		background-color: #edecec;
		border-left: 3px solid #0095FF;
	}
	
	#subsubMenuLeft a:active,
	#subsubMenuLeft a.active{
		background-color: #edecec;
		border-left: 3px solid #0095FF;
		color:#0095FF;
	}
	
	#subsubMenuLeft i.fa{
		width: 25px;
		text-align: center;
	}
</style>


<ul id="subsubMenuLeft">

    <?php if(@$element["tags"]){  ?>
	<li class="">
		<?php foreach ($element["tags"] as $key => $tag) { ?>
		<span class="badge letter-red bg-white"><?php echo $tag; ?></span>
		<?php } ?>
	</li>
	<li><br><hr></li>
	<?php } ?>

	
	<?php if ( $type != Person::COLLECTION && ($edit==true || $openEdition==true ) ){ 
			if ($type == Event::COLLECTION){ 
				$inviteTooltip = Yii::t("event","Invite attendees to the event");
				$invitetext =  Yii::t("common","Send invitations") ;			
			}else if ($type == Organization::COLLECTION){ 
				$inviteTooltip = Yii::t('common','Add a member to this organization');
				$invitetext =  Yii::t("common",'Add member') ;
			}else if ($type == Project::COLLECTION){ 
				$inviteTooltip = Yii::t('common','Add a contributor to this project');
				$invitetext =  Yii::t("common",'Add contributor') ;
			} if( @$inviteTooltip && @$invitetext ){?>
			<li class="">
				<a href="javascript:" class="tooltips" 
				data-placement="bottom" data-original-title="<?php echo $inviteTooltip; ?>" 
				data-toggle="modal" data-target="#modal-scope">
					<i class="fa fa-plus"></i> <?php echo $invitetext; ?>
				</a>
			</li>
			<li><hr></li>
	<?php }}	?>
				
	
	<li class="">
		<a href="javascript:" class="" id="btn-start-detail">
			<i class="fa fa-info-circle"></i> <?php echo Yii::t("common","About"); ?>
		</a>
	</li>	

	<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION){ ?>
	<li class="">
		<a href="javascript:" class="edit-chart">
			<i class="fa fa-heartbeat"></i> <?php echo Yii::t("chart", "Nos valeurs"/*"Values and Cultures"*/) ?>
		</a>
	</li>
	<?php } ?>

	<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION){ ?>
	<li class=""><a href="javascript:" class=""><i class="fa fa-envelope"></i> Nous contacter</a></li>
	<?php } ?>
	             

	<li class="">
		<a href="javascript:" class="" id="btn-start-gallery">
			<i class="fa fa-camera"></i> <?php echo Yii::t("common","Gallery"); ?>
		</a>
	</li>
	
	<li><hr></li>
	<?php if($type != Person::COLLECTION || 
			 Preference::showPreference( $element, $type, "directory", Yii::app()->session["userId"]) ) { ?>

		<?php if($type == Person::COLLECTION ) { ?>
		<li class="">
			<a href="javascript:" class="capitalize load-data-directory" 
				data-type-dir="<?php echo @Element::$connectAs[$type]; ?>" data-icon="link">
				<i class="fa fa-link"></i> <?php echo Yii::t("common",@Element::$connectAs[$type]); ?>
			</a>
		</li>
		<?php } ?>
		
		<li class="">
			<a href="javascript:" class="capitalize load-data-directory" 
				data-type-dir="<?php echo @Element::$connectTypes[$type]; ?>" data-icon="link">
				<i class="fa fa-link"></i> <?php echo Yii::t("common",@Element::$connectTypes[$type]); ?>
			</a>
		</li>

		<?php if ($type==Person::COLLECTION){ ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="collections" data-icon="star">
					<i class="fa fa-star"></i> <?php echo Yii::t("common","Collections"); ?>
				</a>
			</li>

			<li><hr></li>
		<?php } ?>
		
		<?php if(!@$front || (@$front && $front["event"]==true)){ ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="events" data-icon="calendar">
					<i class="fa fa-calendar"></i> <?php echo Yii::t("common","Events"); ?>
				</a>
			</li>
			<?php if ($type==Person::COLLECTION){ ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="organizations" data-icon="group">
					<i class="fa fa-group"></i>  <?php echo Yii::t("common","Organizations"); ?>
				</a>
			</li>
			<?php }  ?>
			<?php if ($type==Person::COLLECTION || $type==Project::COLLECTION){ ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="projects" data-icon="lightbulb-o">
					<i class="fa fa-lightbulb-o"></i>  <?php echo Yii::t("common","Projects"); ?>
				</a>
			</li>
			<li><hr></li>
			<?php }  ?>
		<?php }  ?>
			
		<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION || 
				  $type==Event::COLLECTION || $type==Person::COLLECTION){  
					if(!@$front || (@$front && $front["poi"])){ 
		?>
			<li>
				<a href="javascript:"  class="load-data-directory" data-type-dir="poi" data-icon="map-marker">
					<i class="fa fa-map-marker"></i> <?php echo Yii::t("common","Points of interests"); ?>
		</a>
				</a>
			</li>			
		<?php }  
		} ?>

		<?php if( $type!=Event::COLLECTION && ( !@$front || (@$front && $front["need"]==true))){ ?>
			<li><hr></li>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="classified" data-icon="bullhorn">
					<i class="fa fa-bullhorn"></i> <?php echo Yii::t("common","Classifieds"); ?>
				</a>
			</li>
		<?php } ?>
		<li><hr></li>

	<?php } ?>

	<li class="">
		<a href="javascript:" class="load-data-directory" data-type-dir="dda" data-icon="gavel">
			<i class="fa fa-gavel"></i> <?php echo Yii::t("common","Cooperative space"); ?>
		</a>
	</li>

	<li><hr></li>
</ul>


