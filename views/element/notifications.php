<?php 
	$cssAnsScriptFilesModule = array(
		'/js/default/notifications.js'
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	$cssAnsScriptFiles = array(
	    '/assets/css/notifications.css'
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl); 
?>

<style type="text/css">
	
</style>

<div id="notificationsPad" class="">
		<?php if(@$confirmations){ ?>
		<div class="notificationsElement">
			<div class="pageslide-title pull-left">
				<i class="fa fa-angle-down"></i> <span class="hidden-xs"><?php echo Yii::t("notification","Waiting for answer"); ?></span> 
			</div>
			<ul class="pageslide-list col-md-12 col-sm-12 col-xs-12 padding-10">
			<?php if(@$confirmations["asAdmin"]){
				foreach($confirmations["asAdmin"] as $key => $data){ ?>
					<li class='notifLi'>
						<a href='#page.type.<?php echo Person::COLLECTION ?>.id.<?php echo $key ?>' class='notif lbh pull-left' style="line-height: 30px;">
							<span class='label bg-dark'>
								<i class="fa fa-cog"></i>
							</span> 
								
							<span class="message">
								<?php echo $data["name"]." ".Yii::t("notification", "asks to become admin of")." ".Yii::t("common", "the ".	Element::GetControlerByCollection($elementType)) ?>
							</span> 
						</a>
						<a href='javascript:;' class='label refuseBtn pull-right' 
							onclick='var $this=$(this); disconnectTo("<?php echo $elementType ?>", 
								"<?php echo (string)$parent["_id"] ?>", 
								"<?php echo $key ?>", 
								"<?php echo Person::COLLECTION ?>", 
								"<?php echo $confirmations["connectType"] ?>", 
								function() {
									toastr.success("<?php echo Yii::t("common", "Answer well registered") ?>!!");
									$this.parent().remove();
								},
								"<?php echo Link::IS_ADMIN_PENDING ?>");' 
								style='margin-right: 5px;'>
							<i class="fa fa-remove"></i> <?php echo Yii::t("common","Refuse"); ?>
						</a>
						<a href='javascript:;' 
							class='label acceptBtn pull-right'
							onclick='var $this=$(this); validateConnection("<?php echo $elementType ?>", 
								"<?php echo (string)$parent["_id"] ?>", 
								"<?php echo $key ?>", 
								"<?php echo Person::COLLECTION ?>", 
								"<?php echo Link::IS_ADMIN_PENDING; ?>", 
								function() {
									toastr.success("<?php echo Yii::t("common", "New admin well register") ?>!!");
									$this.parent().remove();
								});' 
							style='margin-right: 5px;'>
								<i class="fa fa-check"></i> <?php echo Yii::t("common", "Accept") ?>
						</a> 
					</li>
			<?php }
			} ?>
			<?php if(@$confirmations["asMember"]){
				foreach($confirmations["asMember"] as $key => $data){ ?>
					<li class='notifLi'>
						<a href='#page.type.<?php echo Person::COLLECTION ?>.id.<?php echo $key ?>' class='notif lbh pull-left' style="line-height: 30px;">
						<span class='label bg-dark'>
							<i class="fa fa-group"></i>
						</span> 
						<span class="message">
							<?php echo $data["name"]." ".Yii::t("notification","asks to become ".substr($confirmations["connectType"],0,-1)." of")." ".Yii::t("common", "the ".Element::GetControlerByCollection($elementType)) ?>
						</span> 
						</a>
						<a href='javascript:;' class='label refuseBtn pull-right' 
							onclick='var $this=$(this); disconnectTo("<?php echo $elementType ?>", 
								"<?php echo (string)$parent["_id"] ?>", 
								"<?php echo $key ?>", 
								"<?php echo Person::COLLECTION ?>", 
								"<?php echo $confirmations["connectType"] ?>", 
								function() {
									$this.parent().remove();
								});'
							style='margin-right: 5px;'>
							<i class="fa fa-remove"></i>
						</a> 
						<a href='javascript:;' 
							class='label acceptBtn pull-right'
							onclick='var $this=$(this); validateConnection("<?php echo $elementType ?>", 
								"<?php echo (string)$parent["_id"] ?>", 
								"<?php echo $key ?>", 
								"<?php echo Person::COLLECTION ?>", 
								"<?php echo Link::TO_BE_VALIDATED; ?>", 
								function() {
									toastr.success("<?php echo Yii::t("notification", "New ".$confirmations["connectType"]." well registered") ?>!!");
									$this.parent().remove();
								});'
								style='margin-right: 5px;'>
								<i class="fa fa-check"></i>
						</a>
					</li>
			<?php }
			} ?>
			</ul>
		</div>
		<?php } ?>
		<div class="notificationsElement">
			<div class="pageslide-title pull-left">
				<i class="fa fa-angle-down"></i> <i class="fa fa-bell"></i> <span class="hidden-xs">Notifications</span> 
			</div> 
			<a href="javascript:;" onclick='markAllAsRead()' class="btn-notification-action pull-right" style="font-size:12px;">
				<?php echo Yii::t("common","All marked all as read") ?> <i class="fa fa-check-square-o"></i>
			</a>	
			<ul class="pageslide-list notifListElement col-md-12 col-sm-12 col-xs-12 padding-10">
			</ul>
		</div>
</div>
<!-- end: PAGESLIDE RIGHT -->
<script type="text/javascript">

//var notifications = null;
//var maxNotifTimstamp = 0;
elementId="<?php echo $elementId ?>";
elementType="<?php echo $elementType ?>";
jQuery(document).ready(function() 
{
	//initNotifications();
	//bindLBHLinks();
	bindNotifEvents("Element");
	refreshNotifications(elementId,elementType,"Element");
});

</script>