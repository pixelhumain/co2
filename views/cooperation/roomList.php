<?php foreach($roomList as $key => $room){ ?>
	<li class="submenucoop sub-rooms">
		<a href="javascript:" class="load-coop-data" data-type="room" data-dataid="<?php echo (string)@$room["_id"]; ?>">
	  		<i class="fa fa-hashtag"></i> <?php echo @$room["name"]; ?>
	  	</a>
	</li>
<?php } ?>