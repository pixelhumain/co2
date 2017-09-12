<?php 
	
	$cssAnsScriptFilesTheme = array(
		"/plugins/Chart-2.6.0/Chart.min.js"
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
			<h3 class="padding-left-10 letter-turq">
				<i class="fa fa-connectdevelop"></i> Espace co		  	
			</h3>
			
		</li>

	<li class="submenucoop sub-rooms"><hr></li>
	
	<div id="coop-room-list" class="margin-bottom-50">
		<?php $this->renderPartial('../cooperation/roomList', array("roomList"=>$menuCoopData["roomList"], "auth"=>$auth)); ?>
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
	
	<?php foreach(array("mine" => "My proposals", 
						"amendable"=>"Amendable", 
						"tovote"=>"To vote",
						"closed" => "Closed", 
						"archived"=> "Archived") as $status=>$tradStatus){ ?>

		<li class="submenucoop sub-proposals">
			<a href="javascript:" class="load-coop-data" data-type="proposal" data-status="<?php echo $status ?>">
		  		<i class="fa fa-<?php echo Cooperation::getIconCoop($status); ?>"></i> <?php echo Yii::t("cooperation", $tradStatus) ?>
		  		<span class="badge pull-right bg-<?php echo Cooperation::getColorCoop($status); ?>">
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

		<?php foreach(array("mine" => "My actions", "todo"=>"To do", 
							"done" => "Done", "archived"=> "Archived") as $status=>$tradStatus){ ?>

			<li class="submenucoop sub-actions">
				<a href="javascript:" class="load-coop-data" data-type="action" data-status="<?php echo $status ?>">
			  		<i class="fa fa-<?php echo Cooperation::getIconCoop($status); ?>"></i> <?php echo Yii::t("cooperation", $tradStatus) ?>
			  		<span class="badge pull-right bg-<?php echo Cooperation::getColorCoop($status); ?>">
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

