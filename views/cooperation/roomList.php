

<?php foreach($roomList as $key => $room){ ?>
	<li class="submenucoop sub-rooms">
		<a href="javascript:" class="load-coop-data letter-turq" data-type="room" data-dataid="<?php echo (string)@$room["_id"]; ?>">
	  		<i class="fa fa-hashtag"></i> <?php echo @$room["name"]; ?>
	  	</a>
	</li>
<?php } ?>

<li class="submenucoop sub-rooms"><hr></li>
		
<li class="submenucoop sub-rooms">
	<a href="javascript:" class="text-dark padding-left-15" id="btn-update-coop">
  		<i class="fa fa-refresh"></i> <?php echo Yii::t("cooperation", "Refresh data") ?>
  	</a>
</li>



<script type="text/javascript">
	jQuery(document).ready(function() { 
		$("#btn-update-coop").click(function(){
			toastr.info(trad["processing"]);
			uiCoop.getCoopData(contextData.type, contextData.id, "room");
			uiCoop.startUI();
		});
	});
</script>