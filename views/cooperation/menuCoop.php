<style>

	ul.menuCoop {
	    list-style-type: none;
	}

	.menuCoop hr{
	    margin-top: 7px;
    	margin-bottom: 7px;	
    	border-top: 2px solid #ededed;
	}

	.menuCoop .title-section{
		text-decoration: none !important;
		color:#353535;
		background-color:#edecec;
		font-size: 17px;
		padding: 6px;
		padding-left: 10px;
		display: block;
		text-align: left;
		font-weight: bold;
		border: 2px solid #e4e4e4;
		margin-top: 10px;
		margin-bottom: 10px;
		border-radius: 50px;
	}

	.menuCoop a.title-section.open{
		border-color: #a2c8ae;
	}

	.menuCoop a.title-section .fa-caret-down,
	.menuCoop a.title-section .fa-caret-right{
		margin-top:3px;
		width:20px;
	}

	.menuCoop a.title-section:hover {
	    color: #0095FF;
	    background-color: #edecec;
	    border: 2px solid #0095FF;
	}

	.menuCoop a{
		text-decoration: none !important;
		color:#3C545D;
		font-size: 13px;
		padding: 4px;
		padding-left: 20px;
		display: block;
		text-align: left;
		font-weight: bold;
		border-left: 3px solid transparent;
	}


	.menuCoop a:hover{
		color:#0095FF;
		background-color: #edecec;
		border-left: 3px solid #0095FF;
	}
	.menuCoop a.letter-green:hover{
		border-left: 3px solid #34a853;
	}

	.menuCoop a:active,
	.menuCoop a.active{
		background-color: #edecec;
		border-left: 3px solid #0095FF;
		color:#0095FF;
	}
	
	.menuCoop i.fa{
		/*width: 25px;*/
		text-align: center;
	}


	.menuCoop a{
		padding-left:4px; 
	}
	
	
	.menuCoop a.load-coop-data{
		font-size:13px;
		padding-left: 14px;
	}

	.menuCoop .sub-rooms a.load-coop-data{
		font-size:17px;
	}


	#menuCoop a.letter-green{
		padding-left:14px; 
	}

	#div-reopen-menu-left-container{
		margin-top: 35px;
		padding-top: 80px;
	}

</style>

<ul id="menuCoop" class="margin-top-25 menuCoop">
	<!-- ----------- RESOLUTION --------------- -->
	<li>
		<a href="javascript:" class="title-section" data-key="resolutions">
	  		<!-- <i class="fa fa-caret-right"></i>   -->
	  		<i class="fa fa-inbox margin-left-25"></i> <?php echo Yii::t("cooperation", "Resolutions") ?>
	  	</a>
	</li>

	
	<!-- ------------ ACTIONS -------------- -->
	<li>
		<a href="javascript:" class="title-section elipsis" data-key="actions">
	  		<i class="fa fa-caret-right"></i>  
	  		<i class="fa fa-inbox"></i> <?php echo Yii::t("cooperation", "Actions") ?>
	  	</a>
	</li>

		<!-- <li class="submenucoop hidden sub-actions">
			<a href="javascript:" class="letter-green">
		  		<i class="fa fa-plus-circle"></i> <?php echo Yii::t("cooperation", "Create action") ?>
		  	</a>
		</li> -->

		<li class="submenucoop hidden sub-actions"><hr></li>

		<li class="submenucoop hidden sub-actions">
			<a href="javascript:" class="load-coop-data" data-type="action" data-status="mine">
		  		<i class="fa fa-user-circle"></i> <?php echo Yii::t("cooperation", "My actions") ?>
		  	</a>
		</li>
		<li class="submenucoop hidden sub-actions">
			<a href="javascript:" class="load-coop-data" data-type="action" data-status="todo">
		  		<i class="fa fa-ticket"></i> <?php echo Yii::t("cooperation", "To do") ?>
		  	</a>
		</li>
		<li class="submenucoop hidden sub-actions">
			<a href="javascript:" class="load-coop-data" data-type="action" data-status="done">
		  		<i class="fa fa-check"></i> <?php echo Yii::t("cooperation", "Done") ?>
		  	</a>
		</li>
		<li class="submenucoop hidden sub-actions">
			<a href="javascript:" class="load-coop-data" data-type="action" data-status="archived">
		  		<i class="fa fa-trash"></i> <?php echo Yii::t("cooperation", "Archived") ?>
		  	</a>
		</li>
	
	<!----------------- PROPOSALS ------------ -->
	<li>
		<a href="javascript:" class="title-section elipsis" data-key="proposals">
	  		<i class="fa fa-caret-right"></i>  
	  		<i class="fa fa-inbox"></i> <?php echo Yii::t("cooperation", "Proposals") ?>
	  	</a>
	</li>

	<!-- <li class="submenucoop hidden sub-proposals">
		<a href="javascript:" class="letter-green">
	  		<i class="fa fa-plus-circle"></i> <?php echo Yii::t("cooperation", "Create proposal") ?>
	  	</a>
	</li> -->

	<li class="submenucoop hidden sub-proposals"><hr></li>
	
	<li class="submenucoop hidden sub-proposals">
		<a href="javascript:" class="load-coop-data" data-type="proposal" data-status="mine">
	  		<i class="fa fa-user-circle"></i> <?php echo Yii::t("cooperation", "My proposals") ?>
	  	</a>
	</li>
	<li class="submenucoop hidden sub-proposals">
		<a href="javascript:" class="load-coop-data" data-type="proposal" data-status="amendable">
	  		<i class="fa fa-pencil"></i> <?php echo Yii::t("cooperation", "Amendable") ?>
	  	</a>
	</li>
	<li class="submenucoop hidden sub-proposals">
		<a href="javascript:" class="load-coop-data" data-type="proposal" data-status="tovote">
	  		<i class="fa fa-gavel"></i> <?php echo Yii::t("cooperation", "To vote") ?>
	  	</a>
	</li>
	<li class="submenucoop hidden sub-proposals">
		<a href="javascript:" class="load-coop-data" data-type="proposal" data-status="closed">
	  		<i class="fa fa-times"></i> <?php echo Yii::t("cooperation", "Closed") ?>
	  	</a>
	</li>
	<li class="submenucoop hidden sub-proposals">
		<a href="javascript:" class="load-coop-data" data-type="proposal" data-status="archived">
	  		<i class="fa fa-trash"></i> <?php echo Yii::t("cooperation", "Archived") ?>
	  	</a>
	</li>

	
	<!------------------ ROOMS ----------- -->
	<?php $roomList = Cooperation::getCoopData($type, (string)$element["_id"], "room"); ?>

	<li>
		<a href="javascript:" class="title-section elipsis open" data-key="rooms">
			<i class="fa fa-caret-down"></i>  
	  		<i class="fa fa-inbox"></i> <?php echo Yii::t("cooperation", "Rooms") ?>
	  	</a>
	</li>

	<li class="submenucoop sub-rooms">
		<a href="javascript:dyFObj.openForm('room')" class="letter-green">
	  		<i class="fa fa-plus-circle"></i> <?php echo Yii::t("cooperation", "Create room") ?>
	  	</a>
	</li>

	<li class="submenucoop sub-rooms"><hr></li>

	<div id="coop-room-list">
		<?php $this->renderPartial('../cooperation/roomList', array("roomList"=>$roomList["roomList"])); ?>
	</div>

</ul>