
<?php if(!isset($auth))
		$auth = Authorisation::canParticipate(Yii::app()->session['userId'], @$parentType, @$parentId);

		if(isset(Yii::app()->session['userId'])){
			$me = Element::getByTypeAndId("citoyens", Yii::app()->session['userId']);
			$myRoles = @$me["links"]["memberOf"][@$parentId]["roles"] ? 
					   @$me["links"]["memberOf"][@$parentId]["roles"] : array();
		}else{
			$myRoles = array();
		}	
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
	<?php 

		$accessRoom = Room::getAccessByRole($room, $myRoles);

		//var_dump( @$roomRoles);
		if(!isset($room["roles"])  || $accessRoom != "lock"){ ?>
		<li class="submenucoop sub-rooms "
				data-type="room" data-dataid="<?php echo (string)@$room["_id"]; ?>">
			<a href="javascript:" class="load-coop-data droppable letter-turq" 
				data-type="room" data-dataid="<?php echo (string)@$room["_id"]; ?>">
					<?php if($accessRoom == "unlock"){ ?> <i class="fa fa-unlock-alt"></i>
					<?php }else if($accessRoom == "lock"){ ?> <i class="fa fa-lock"></i>
					<?php }else if($accessRoom == "open"){ ?> <i class="fa fa-hashtag"></i>
					<?php } ?>
					<?php echo @$room["name"]; ?>

			 	<i class="fa fa-inbox pull-right"></i>
		  	</a>
		</li>
	<?php }else{ ?>
		<?php 
			$rolesTooltip = "";
			if(!is_array(@$room["roles"])) $rolesTooltip = @$room["roles"]; 
			else foreach (@$room["roles"] as $r) $rolesTooltip .= $rolesTooltip == "" ? $r : ", ".$r; 
		?>
		<li class="submenucoop sub-rooms ">
			<a href="javascript:" class="load-coop-data droppable letter-turq-light" 
				data-type="locked" data-dataid="locked">
			 	<i class="fa fa-lock tooltips" 
			 		data-original-title="réservé au(x) rôle(s) : <?php echo $rolesTooltip; ?>" 
			 		data-placement="right"></i> <?php echo @$room["name"]; ?>
			 	<i class="fa fa-inbox pull-right"></i>
		  	</a>
		</li>
	<?php } ?>
<?php } ?>


<script type="text/javascript">
	jQuery(document).ready(function() { 
	});
</script>