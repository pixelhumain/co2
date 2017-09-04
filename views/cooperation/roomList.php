
		
<li class="submenucoop sub-rooms">
	<?php if($auth){ ?>
		<a href="javascript:dyFObj.openForm('room')" class="btn btn-link letter-green bold">
	  		<i class="fa fa-plus-circle"></i> <?php echo Yii::t("cooperation", "Create room") ?>
	  	</a>
	<?php } ?>
	<!-- <a href="javascript:" class="text-dark padding-left-15" id="btn-update-coop">
  		<i class="fa fa-refresh"></i> <?php echo Yii::t("cooperation", "Refresh data") ?>
  	</a> -->
</li>
<li class="submenucoop sub-rooms"><hr></li>

<?php foreach($roomList as $key => $room){ ?>
	<li class="submenucoop sub-rooms">
		<a href="javascript:" class="load-coop-data droppable letter-turq" 
			data-type="room" data-dataid="<?php echo (string)@$room["_id"]; ?>">
	  		<i class="fa fa-hashtag"></i> <?php echo @$room["name"]; ?>
	  	</a>
	</li>
<?php } ?>




<script type="text/javascript">
	jQuery(document).ready(function() { 
		$("#btn-update-coop").click(function(){
			toastr.info(trad["processing"]);
			uiCoop.getCoopData(contextData.type, contextData.id, "room");
			uiCoop.startUI();
		});
	});
</script>