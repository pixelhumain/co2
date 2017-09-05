
<?php if(!isset($auth))
		$auth = Authorisation::canParticipate(Yii::app()->session['userId'], @$post["parentType"], @$post["parentId"]);
?>
<?php if($auth){ ?>
	
<li class="submenucoop sub-rooms">
	<a href="javascript:dyFObj.openForm('room')" class="btn btn-link letter-green bold">
  		<i class="fa fa-plus-circle"></i> <?php echo Yii::t("cooperation", "Create room") ?>
  	</a>
</li>
<li class="submenucoop sub-rooms"><hr></li>
<?php } ?>


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
		
	});
</script>