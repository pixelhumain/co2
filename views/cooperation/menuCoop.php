<?php 
	
	$cssAnsScriptFilesTheme = array(
		"/plugins/Chart-2.6.0/Chart.min.js",
		"/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css"
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

	HtmlHelper::registerCssAndScriptsFiles( array('/css/cooperation.css'), Yii::app()->theme->baseUrl. '/assets');
?>

<style>
	body.modal-open{
		overflow: hidden !important;
	}
	/* MODAL */
</style>

	<?php 
		$menuCoopData = Cooperation::getCoopData($type, (string)$element["_id"], "room");
		$auth = Authorisation::canParticipate(Yii::app()->session['userId'], $type, (string)$element["_id"]);
	?>
		<li class="padding-10 submenucoop sub-rooms">
			<h4 class="padding-left-10 letter-turq">
				<i class="fa fa-connectdevelop"></i> <?php echo Yii::t("cooperation", "CO-space"); ?>		  	
			</h4>
			
		</li>

	<li class="submenucoop sub-rooms"><hr></li>
	
	<?php if(@$access=="deny"){ ?>
		<li class="padding-10 submenucoop sub-rooms">
			<h5 class="padding-left-10 letter-red">
				<i class="fa fa-ban"></i> Vous n'êtes pas autorisé à accéder à ce contenu		  	
			</h5>
			<?php if(!isset(Yii::app()->session['userId'])){ ?>
				<h5 class="padding-left-10">
					<small class="letter-orange"><i class="fa fa-user-circle"></i> Vous n'êtes pas connecté</small>  	
				</h5>
			<?php } ?>
			<h5 class="padding-left-10 letter-red">
				<small>Devenez membre ou contributeur</small>  	
			</h5>
		</li>
	<?php exit; } ?>
	
	<div id="coop-room-list" class="margin-bottom-50">
		<?php $this->renderPartial('../cooperation/roomList', array("roomList"=>$menuCoopData["roomList"], 
																	"auth"=>$auth,
																	"parentType" => @$parentType,
																	"parentId" => @$parentId)); ?>
	</div>

	<?php if(!@$menuCoopData["roomList"]) return; ?>

	
	<!----------------- PROPOSALS ------------ -->
	<li>
		<a href="javascript:" class="title-section elipsis open" data-key="proposals">
	  		<i class="fa fa-caret-down"></i>  
	  		<i class="fa fa-inbox"></i> <?php echo Yii::t("cooperation", "Proposals") ?>
	  	</a>
	</li>

	<li class="submenucoop hidden sub-proposals"><hr></li>
	
	<?php $allStatus = array("amendable"=>"Amendable", 
							 "tovote"=>"To vote",
							 "disabled"=> "Disabled",
							 "resolved"=> "Resolved",
							 "closed" => "Closed");
		
		if(Yii::app()->session['userId'])
		$allStatus["mine"] = "My proposals";

	 	foreach($allStatus as $status=>$tradStatus){ ?>

		<li class="submenucoop sub-proposals">
			<a href="javascript:" class="load-coop-data" data-type="proposal" data-status="<?php echo $status ?>">
		  		<i class="fa fa-<?php echo Cooperation::getIconCoop($status); ?>"></i> <?php echo Yii::t("cooperation", $tradStatus) ?>
		  		<span class="badge pull-right bg-<?php echo Cooperation::getColorCoop($status); ?> margin-right-10">
		  			<?php echo @$menuCoopData["allCount"]["proposals"][$status]; ?>
		  		</span>
		  	</a>
		</li>
	<?php } ?>

	
	
	<!-- ------------ ACTIONS -------------- -->
	<li>
		<a href="javascript:" class="title-section elipsis open" data-key="actions">
	  		<i class="fa fa-caret-down"></i>  
	  		<i class="fa fa-inbox"></i> <?php echo Yii::t("cooperation", "Actions") ?>
	  	</a>
	</li>

		<li class="submenucoop hidden sub-actions"><hr></li>

		<?php $allStatus = array("todo"=>"To do", 
								 "disabled"=> "Disabled", 
								 "done" => "Done");
		
			if(Yii::app()->session['userId'])
			$allStatus["mine"] = "My actions";

		 	foreach($allStatus as $status=>$tradStatus){ ?>

			<li class="submenucoop sub-actions">
				<a href="javascript:" class="load-coop-data" data-type="action" data-status="<?php echo $status ?>">
			  		<i class="fa fa-<?php echo Cooperation::getIconCoop($status); ?>"></i> 
			  		<?php echo Yii::t("cooperation", $tradStatus) ?>
			  		<span class="badge pull-right bg-<?php echo Cooperation::getColorCoop($status); ?> margin-right-10">
			  			<?php echo @$menuCoopData["allCount"]["actions"][$status]; ?>
			  		</span>
			  	</a>
			</li>
		<?php } ?>

	
<li class="submenucoop sub-rooms margin-top-50"></li>
	
	<!-- ----------- RESOLUTION --------------- -->
	<li class="hidden">
		<a href="javascript:" class="title-section" data-key="resolutions">
	  		<!-- <i class="fa fa-caret-right"></i>   -->
	  		<i class="fa fa-inbox margin-left-25"></i> <?php echo Yii::t("cooperation", "Resolutions") ?>
	  	</a>
	</li>

