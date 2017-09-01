

<style>
	
	#coop-container, #menu-room, #coop-data-container{
		min-height:700px;
		
	}

	#coop-container{
		border: 1px solid #c6c4c4;
	}

	#menu-room{
		padding-top:10px;
		/*border-left: 1px solid #c6c4c4;
		border-right: 1px solid #c6c4c4;*/
	}


	#menu-room .load-coop-data{
		/*border-left: 3px solid #3C545D;*/
		padding:8px;
		margin-top:5px;
		font-size: 15px;
		line-height: 17px;
	}

	#menu-room  li.ui-draggable-dragging .load-coop-data{
		background-color: rgba(255, 255, 255, 0.3);
	}

	#menu-room .load-coop-data small{
		font-weight: 300 !important;
	}

	#menu-room .menuCoop .title-section{
		padding: 6px 6px 6px 15px;
	}

	#menu-room .menuCoop .title-section a{
		padding: 4px 8px 4px 4px;
		margin-top:-1px;
	}
	#menu-room .menuCoop .title-section a:hover{
		border-color:transparent!important;
		background-color: white;
		border-radius: 15px;

	}

	#menu-room a.btn-hide-data-room{
		width:30px;
		text-align: center;
		margin-right:5px;
	}

	#menu-room.min .submenucoop{
		width:100%;
	}

	#menu-room.min .hidden-min{
		display: none;
	}

	#coop-data-container{
		border-left: 1px solid #c6c4c4;
	}

	#coop-container .ctnr-txtarea{
		left:50px !important;
	}

	#amendement-container{
		position: fixed;
		top: 113px;
		bottom: 0px;
		right: 0px;
		overflow-y: scroll;
	}

	#menu-room .inputSearchInMenuRoom{
		height:25px;
		font-size: 12px;
		padding: 3px 10px;
		border-radius: 40px;
		margin-left:10px;
		width:170px;
		border:none;
	}
	.submenucoop a:hover{
		border-left-width: 3px !important; 
	}
	.submenucoop a[data-status="amendable"]:hover{
		border-left: 3px solid #B082D5;
	}
	.submenucoop a[data-status="tovote"]:hover{
		border-left: 3px solid #34a853;
	}
	.submenucoop a[data-status="todo"]:hover{
		border-left: 3px solid #34a853;
	}
	.submenucoop a[data-status="closed"]:hover{
		border-left: 3px solid #E07171;
	}
	.submenucoop a[data-status="archived"]:hover{
		border-left: 3px solid #E0B471;
	}

	.submenucoop a[data-status="adopted"],
	.submenucoop a[data-status="adopted"]:hover{
		border-left: 3px solid #34a853 !important;
	}

	.submenucoop a[data-status="refused"],
	.submenucoop a[data-status="refused"]:hover{
		border-left: 3px solid #E07171 !important;
	}


	.load-coop-data[data-type="room"]:hover,
	.load-coop-data[data-type="room"]:hover{
		border-left: 3px solid #229296 !important;
	}


	.submenucoop a[data-status="amendable"]:hover,
	.submenucoop a[data-status="amendable"]:hover .lbl-status{
		color: #B082D5 !important;
	}
	.submenucoop a[data-status="tovote"]:hover,
	.submenucoop a[data-status="tovote"]:hover .lbl-status{
		color: #34a853 !important;
	}
	.submenucoop a[data-status="todo"]:hover,
	.submenucoop a[data-status="todo"]:hover .lbl-status{
		color: #34a853 !important;
	}
	.submenucoop a[data-status="closed"]:hover,
	.submenucoop a[data-status="closed"]:hover .lbl-status{
		color: #E07171 !important;
	}
	.submenucoop a[data-status="archived"]:hover,
	.submenucoop a[data-status="archived"]:hover .lbl-status{
		color: #E0B471 !important;
	}

	.submenucoop a[data-status="adopted"]:hover,
	.submenucoop a[data-status="adopted"]:hover .lbl-status{
		color: #34a853 !important;
	}

	.submenucoop a[data-status="refused"]:hover,
	.submenucoop a[data-status="refused"]:hover .lbl-status{
		color: #E07171 !important;
	}


	

	.progress{
		margin:5px 0 0 0;
	}


	#podVote .btn-link.bg-white, 
	.podVoteAmendement .btn-link.bg-white,
	#podVote .badge.bg-white, 
	.podVoteAmendement .badge.bg-white{
		color:black;
		border: 1px solid black;
	}
	#podVote .btn-link, 
	.podVoteAmendement .btn-link{
		width:100%;
		border-radius:4px;
		text-decoration: none;
	}

	.podVoteAmendement {
	    /*background-color: #e7e7e7;*/
	}

	#ajax-modal .bootstrap-switch-wrapper{
		width: 100% !important;
		min-width: 300px !important;
		margin-left: 0% !important;
	}

	#ajax-modal .form-group.amendementActivatedcheckbox,
	#ajax-modal .form-group.amendementDateEnddatetime,
	#ajax-modal .form-group.voteActivatedcheckbox,
	#ajax-modal .form-group.voteDateEnddatetime
	{
		padding: 0 10px 10px 10px;
		background-color: #EDEDED;
	}

	#ajax-modal .form-group.amendementActivatedcheckbox,
	#ajax-modal .form-group.voteActivatedcheckbox{
		margin-bottom:0px;
		margin-top:30px;
	}

	.bootstrap-switch-handle-off{
		background-color: white !important;
		color: #34a853 !important;
		font-weight: 800;
	}
	.bootstrap-switch-handle-on{
		background-color: white !important;
		color: #ea4335  !important;
		font-weight: 800;
	}
	.bootstrap-switch-container{
		background-color: #dadada;
	}
	.bootstrap-switch-label{
		background-color: transparent !important;
	}

	#coop-data-container .btn-link,
	#amendement-container .btn-link{
		background-color: #f3f3f3;
	}
	#coop-data-container .btn-link:hover,
	#amendement-container .btn-link:hover{
		border: 1px solid #D8D5D5;
		text-decoration: none;
	}

	.progress-bar.bg-white{
		color: #3C545D;
		border: 1px solid #B3C9D2;
	}

	.textAmdt{
		font-size:14px;
	}
	.textAmdt hr{
		margin-top: 0px;
	}

	textarea#arguments{
		min-height:150px;
	}

	.extracted_content h4, .extracted_content p{
		font-size:13px;
		text-align: left;
	}

	#container-text-proposal{
		border-radius: 5px;
	}

	#container-text-resolution hr{
		border-top: 1px solid #b4c8cf;
	}

	.container-txtarea{
		margin-bottom:15px;
	}

</style>

<?php 
	$auth = Authorisation::canEditItem(Yii::app()->session['userId'], @$room["parentType"], @$room["parentId"]);
?>

<!-- ************ MODAL ********************** -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteRoom">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title" id="modalText">
        	<h4><i class="fa fa-times"></i> Supprimer un espace coopératif</h4>
        </div>
      </div>
      <div class="modal-body">
      	<h3 style="text-transform: none!important; font-weight: 200;" class="letter-turq">
      		<i class="fa fa-hashtag"></i> <?php echo @$room["name"]; ?>
      	</h3>
      	<label>Etes-vous sur de vouloir supprimer cet espace coopératif ?</label>
      </div>
      <div class="modal-footer">
      	<div id="modalAction" style="display:inline"></div>
        <button class="btn btn-danger pull-right btn-sm margin-top-10" 
				id="btn-delete-room" data-placement="bottom" 
				data-original-title="supprimer l'espace : <?php echo @$room["name"]; ?>"
				data-id-room="<?php echo @$room["_id"]; ?>">
			<i class="fa fa-trash"></i> Oui, supprimer cet espace
		</button>
		<button class="btn btn-default pull-right btn-sm margin-top-10 margin-right-10" data-dismiss="modal"> Annuler</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="col-lg-12 col-md-12 col-sm-12 no-padding margin-top-15 bg-white" id="coop-container">
	
	<div class="col-lg-12 col-md-12 col-sm-12 bg-white margin-top-10" id="menu-room">
		
		<?php if(@$room){ ?>
			
			<?php if(@$auth){ ?>
				<button class="btn btn-default pull-right btn-sm margin-top-10 hidden-min tooltips" 
						data-target="#modalDeleteRoom" data-toggle="modal" >
					<i class="fa fa-trash"></i> Supprimer
				</button>
				<button class="btn btn-default pull-right btn-sm margin-top-10 hidden-min tooltips margin-right-5" 
						id="btn-edit-room" data-placement="bottom" 
						data-original-title="modifier l'espace : <?php echo @$room["name"]; ?>"
						data-id-room="<?php echo @$room["_id"]; ?>">
					<i class="fa fa-pencil"></i> Modifier
				</button>
			<?php } ?>

			<h3 class="margin-top-15 letter-turq">
				<i class="fa fa-connectdevelop"></i> <?php echo @$room["name"]; ?>
			</h3>

			<?php if(@$room["topic"]){ ?>
				<hr>
				<h4>
					<?php echo Yii::t("cooperation", "Topic") ?> : 
					<small><?php echo @$room["topic"]; ?></small>
				</h4>
			<?php } ?>
			
			<h5><small><?php echo @$room["description"]; ?></small></h5>
			<hr>

		<?php }else{ ?>
			<h3 class="margin-top-15 elipsis">
				<i class="fa fa-search"></i> 
				<?php $thisStatus = @$post["status"] ? @$post["status"] : "all status"; ?>
				<?php echo Yii::t("cooperation", @$post["type"])." <small>".
						   Yii::t("cooperation", @$thisStatus)."</small>"; ?>
			</h3>
			<hr>

		<?php } ?>

		<ul class="menuCoop margin-bottom-50 ">
			
			<?php if(@$post["type"] == Proposal::CONTROLLER || @$post["type"] == Room::CONTROLLER){ ?>
				<div class="margin-top-25 title-section">
					<!-- <a href="javascript:" 
						class="pull-left open elipsis btn-hide-data-room visible-sm visible-xs" 
						style="margin-left:-10px;" data-key="proposals">
				  		<i class="fa fa-caret-down"></i>
				  	</a> -->
					<i class="fa fa-inbox"></i> 
			  		<?php echo Yii::t("cooperation", "Proposals") ?>

				  	<input type="text" class="inputSearchInMenuRoom pull-right form-input hidden-min hidden-xs" 
				  			data-type-search="proposals" 
				  			placeholder="<?php echo Yii::t("cooperation", "Search in proposals") ?>..." />

			  		<?php 
			  			if(@$post["type"] == Room::CONTROLLER && $auth){ 
			  		?>
						<a href="javascript:dyFObj.openForm('proposal')" class="letter-green pull-right btn-add">
					  		<i class="fa fa-plus-circle tooltips"  data-placement='top'  data-toogle='tooltips'
					  			data-original-title="<?php echo Yii::t("cooperation", "Add proposal") ?>"></i> 
					  		<span class="hidden-min hidden-sm"><?php echo Yii::t("cooperation", "Add proposal") ?></span>
					  	</a>
				  	<?php }else if(@$post["type"] == Room::CONTROLLER){ ?>
				  		<label class="text-black pull-right tooltips" 
				  			   data-position="top" data-original-title="Devenez membre pour contribuer">
				  			<i class="fa fa-lock"></i>
				  		</label>
				  	<?php } ?>
			  	</div>
				


				<?php if(@$proposalList){
						foreach(array("tovote", "amendable", "closed", "archived") as $thisStatus){ 
							foreach($proposalList as $key => $proposal){ ?>
							<?php $totalVotant = Proposal::getTotalVoters($proposal); ?>
								<?php if(@$proposal["status"] == $thisStatus){ ?>
									<li class="submenucoop sub-proposals no-padding col-lg-4 col-md-6 col-sm-6 draggable" 
									data-name-search="<?php echo str_replace('"', '', @$proposal["title"]); ?>">
									<a href="javascript:" class="load-coop-data " data-type="proposal" 
										data-status="<?php echo @$proposal["status"]; ?>" 
									   	data-dataid="<?php echo (string)@$proposal["_id"]; ?>">
								  		
								  		<?php if(@$proposal["title"]){ ?>
									  		<span class="elipsis">
									  			<i class="fa fa-hashtag"></i> 
									  			<?php echo @$proposal["title"]; ?>
									  		</span>
								  		<?php }else{ ?> 
									  		<small class="elipsis"><b>
									  			<i class="fa fa-hashtag"></i> 
									  			<?php echo substr(@$proposal["description"], 0, 150); ?></b>
									  		</small>
								  		<?php } ?>
								  		
									  	<?php if(@$post["status"]) { $parentRoom = Room::getById($proposal["idParentRoom"]); ?>
									  	<br>
									  	<small class="elipsis">
								  			<i class="fa fa-connectdevelop"></i> <?php echo @$parentRoom["name"]; ?>
								  		</small>
									  	<?php  } ?>

									  	<br>
									  	
									  	<small class="letter-light lbl-status">
									  		<i class="fa fa-<?php echo Cooperation::getIconCoop(@$proposal["status"]); ?>"></i> 
									  		<b><?php echo Yii::t("cooperation", @$proposal["status"]); ?></b>
									  	</small>
										
										<?php if(@$proposal["status"] == "tovote"){ ?>
										  	<small class="letter-light margin-left-10 tooltips" 
										  			data-original-title="<?php echo Yii::t("cooperation", "number of voters") ?>">
										  		<i class="fa fa-group"></i> 
										  		<?php echo $totalVotant; ?>
										  	</small>
										  	
									  	<?php } ?>
									  	<?php if(@$proposal["status"] == "amendable" || @$proposal["status"] == "tovote"){ ?>
										  	<small class="letter-light margin-left-10">
										  		<i class="fa fa-clock-o"></i> 
										  		<?php 	if(@$proposal["amendementDateEnd"] && @$proposal["status"] == "amendable")
											  				echo Yii::t("cooperation", "end") ." ".
											  				//$proposal["amendementDateEnd"];
											  				//date("Y-m-d H:i:s", $proposal["amendementDateEnd"]);
											  				Translate::pastTime($proposal["amendementDateEnd"], "date"); 

											  			else if(@$proposal["voteDateEnd"] && @$proposal["status"] == "tovote" )
											  				echo Yii::t("cooperation", "end") ." ". 
											  				Translate::pastTime($proposal["voteDateEnd"], "date"); 
										  		?>
										  	</small>
									  	<?php } ?>

								  	  	<div class="progress <?php if($proposal["status"] != "tovote") echo "hidden-min"; ?>">
								  	  		<?php 
								  	  			$voteRes = Proposal::getAllVoteRes($proposal);
									  	  		foreach($voteRes as $key => $value){ 
									  	  			if($totalVotant > 0 && @$proposal["status"] == "tovote" && $value["percent"] > 0){ 
								  	  		?>
													  <div class="progress-bar bg-<?php echo $value["bg-color"]; ?>" role="progressbar" 
													  		style="width:<?php echo $value["percent"]; ?>%">
													    <?php echo $value["percent"]; ?>%
													  </div>
										  			<?php } ?>
											<?php } ?>

										  <?php if($totalVotant == 0 && @$proposal["status"] == "tovote"){ ?>
										  			<div class="progress-bar bg-green-k" role="progressbar" 
												  		style="width:100%">
												    À voter !
												  </div>
										  <?php } ?>

										  <?php if($totalVotant == 0 && @$proposal["status"] == "amendable"){ ?>
										  			<div class="progress-bar bg-lightpurple text-dark" role="progressbar" 
												  		style="width:100%">
												    En cours d'amendement
												  </div>
										  <?php } ?>

										</div> 
								  	</a>
								</li>
								<?php } //end if ?>
							<?php } //end foreach ?>
						<?php } //end foreach ?>
				<?php }else{ ?>
						<li class="submenucoop sub-proposals col-lg-12 col-md-12 col-sm-12">
							<i class="fa fa-ban"></i> <?php echo Yii::t("cooperation", "No proposal") ?>
						</li>
				<?php } ?>

				<hr class="col-lg-12 col-md-12 col-sm-12 no-padding margin-bottom-25">

			<?php } ?>


			<?php //var_dump($proposalList); ?>
			<?php if(@$resolutionList || @$room){ ?>
				<div class="margin-top-25 title-section col-lg-12 col-md-12 col-sm-12">
					<i class="fa fa-inbox"></i> 
			  		<?php echo Yii::t("cooperation", "Resolutions") ?>
			  	</div>
				
				<?php  	if(@$resolutionList)
						foreach($resolutionList as $key => $resolution){ ?>
							<li class="submenucoop sub-resolutions no-padding col-lg-4 col-md-6 col-sm-6">
								<a href="javascript:" class="load-coop-data" data-type="resolution" 
								   data-status="<?php echo @$resolution["status"]; ?>" 
								   data-dataid="<?php echo (string)@$resolution["_id"]; ?>">
							  		<span class="elipsis">
							  			<i class="fa fa-hashtag"></i> <?php echo @$resolution["title"]; ?>
							  		</span>
							  	</a>
							</li>
				<?php } ?>

				<hr class="col-md-12 no-padding margin-bottom-25">

			<?php } ?>


			<?php if(@$post["type"] == Action::CONTROLLER || @$post["type"] == Room::CONTROLLER){ ?>
				<div class="margin-top-25 title-section col-lg-12 col-md-12 col-sm-12">
					<!-- <a href="javascript:" class="open elipsis pull-left btn-hide-data-room visible-sm visible-xs" 
						style="margin-left:-10px;" data-key="actions">
				  		<i class="fa fa-caret-down"></i>
				  	</a> -->
					<i class="fa fa-inbox"></i> 
			  		<?php echo Yii::t("cooperation", "Actions") ?>
			  		
			  		<input type="text" class="inputSearchInMenuRoom pull-right form-input hidden-min hidden-xs" 
			  				data-type-search="actions" 
				  			placeholder="<?php echo Yii::t("cooperation", "Search in actions") ?>..." />
				  			
			  		<?php 
			  			if(@$post["type"] == Room::CONTROLLER && $auth){ ?>
						  	<a href="javascript:dyFObj.openForm('action')" class="letter-green pull-right">
						  		<i class="fa fa-plus-circle"></i> 
						  		<span class="hidden-min hidden-sm"><?php echo Yii::t("cooperation", "Add action") ?></span>
						  	</a>
						<?php }elseif(@$post["type"] == Room::CONTROLLER){ ?>
					  		<label class="text-black pull-right tooltips" 
					  			   data-position="top" data-original-title="Devenez membre pour contribuer">
					  			<i class="fa fa-lock"></i>
					  		</label>
						<?php } ?>
			  	</div>
				
				<?php   if(@$actionList)
						foreach($actionList as $key => $action){ ?>
							<li class="submenucoop sub-actions no-padding col-lg-4 col-md-6 col-sm-6"
								data-name-search="<?php echo str_replace('"', '', @$action["name"]); ?>">
								<a href="javascript:" class="load-coop-data" data-type="action"
									data-status="<?php echo @$action["status"]; ?>" 
							   		data-dataid="<?php echo (string)@$action["_id"]; ?>">
							  		<span class="elipsis">
							  			<i class="fa fa-hashtag"></i> <span class="name-search"><?php echo @$action["name"]; ?></span>
							  		</span>
							  		<?php if(@$post["status"]) { $parentRoom = Room::getById($action["idParentRoom"]); ?>
								  	<br>
								  	<small class="elipsis">
							  			<i class="fa fa-connectdevelop"></i> <?php echo @$parentRoom["name"]; ?>
							  		</small>
								  	<?php  } ?>
								  	<br>
								  	<small class="letter-light lbl-status">
								  		<i class="fa fa-pencil"></i> <b><?php echo Yii::t("cooperation", @$action["status"]); ?></b>
								  	</small>
								  	<small class="letter-light margin-left-10">
								  		<i class="fa fa-clock-o"></i> 
								  		<?php 
								  			if(@$action["endDate"])
								  				echo Yii::t("cooperation", "end") ." ". 
								  				Translate::pastTime($action["endDate"], "date"); 

								  		?>
								  	</small>
							  	</a>
							</li>
				<?php }else{ ?>
						<li class="submenucoop sub-proposals col-lg-12 col-md-12 col-sm-12">
							<i class="fa fa-ban"></i> <?php echo Yii::t("cooperation", "No action") ?>
						</li>
				<?php } ?>

				<hr class="col-lg-12 col-md-12 col-sm-12 no-padding margin-bottom-25">

			<?php } ?>

		</ul>

	</div>

	<div class="hidden" id="coop-data-container">
		
	</div>

</div>

<script type="text/javascript">
	var currentRoomId = '<?php echo @$room["_id"] ? $room["_id"] : ""; ?>';
	console.log("currentRoomId", currentRoomId);

	jQuery(document).ready(function() { 
	
		$("#btn-edit-room").click(function(){

		});
		
		$("#btn-delete-room").click(function(){
			idRoom = $(this).data("id-room");
			console.log("idRoom", idRoom);
			uiCoop.deleteByTypeAndId("rooms", idRoom);
		});
		//alert("initDrag");
		//uiCoop.initDragAndDrop();

		uiCoop.initDragAndDrop();
		uiCoop.initSearchInMenuRoom();
	});

</script>