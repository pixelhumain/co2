
<?php $totalVotant = Proposal::getTotalVoters($proposal); ?>
<?php $isAuthor = Yii::app()->session['userId'] == @$proposal["creator"]; ?>


	<?php if(@$proposal["status"] == $thisStatus){ ?>
		<li class="submenucoop focus sub-proposals no-padding col-lg-4 col-md-6 col-sm-6" 
			data-name-search="<?php echo str_replace('"', '', @$proposal["title"]); ?>">
		<a href="javascript:;" class="load-coop-data" data-type="proposal" 
			data-status="<?php echo @$proposal["status"]; ?>" 
		   	data-dataid="<?php echo (string)@$proposal["_id"]; ?>">
	  		
	  			<?php if((@$proposal["status"] == "amendable" || 
		  				  @$proposal["status"] == "tovote") && 
		  				  ($isAdmin || $isAuthor)){ ?>
		  			<span class="elipsis draggable" 
		  					data-dataid="<?php echo (string)@$proposal["_id"]; ?>"
			  				data-type="proposals" >
			  			<i class="fa fa-arrows-alt letter-light tooltips"  
		   					data-original-title="<?php echo Yii::t("cooperation", "Drag / drop to an other space") ?>" 
			  				data-placement="right"></i> 
			  			<i class="fa fa-hashtag"></i> 
			  			<?php if(@$proposal["title"]) 
			  					   echo @$proposal["title"]; 
			  				  else echo "<small><b>".
			  				  		substr(@$proposal["description"], 0, 150).
			  				  		   "</b></small>";
			  			?>
		  			</span>
		  			
	  		<?php }else{ ?> 
		  		<small class="elipsis"><b>
		  			<i class="fa fa-hashtag"></i> 
		  			<?php if(@$proposal["title"]) 
		  					   echo @$proposal["title"]; 
		  				  else echo "<small><b>".
		  				  		substr(@$proposal["description"], 0, 150).
		  				  		   "</b></small>";
		  			?>
		  		</small>
	  		<?php } ?>
	  		
		  	<?php if(@$post["status"]) { 
		  		$parentRoom = Room::getById(@$proposal["idParentRoom"]); ?>
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
		  	  			if($totalVotant > 0 && $value["percent"] > 0){ 
	  	  		?>
						  <div class="progress-bar bg-vote bg-<?php echo $value["bg-color"]; ?>" role="progressbar" 
						  		style="width:<?php echo $value["percent"]; ?>%">
						    <?php echo $value["percent"]; ?>%
						  </div>
			  			<?php } ?>
				<?php } ?>

			  <?php if($totalVotant == 0 && @$proposal["status"] == "tovote"){ ?>
			  			<div class="progress-bar bg-turq" 
			  				 role="progressbar" style="width:100%">
					    	 <?php echo Yii::t("cooperation", "Be the first to vote"); ?>
					  </div>
			  <?php } ?>

			  <?php if($totalVotant == 0 && @$proposal["status"] == "amendable"){ ?>
			  			<div class="progress-bar bg-lightpurple text-dark" 
			  				 role="progressbar" style="width:100%">
					    	 <?php echo Yii::t("cooperation", "Processing amendements"); ?>
					  </div>
			  <?php } ?>

			  <?php if($totalVotant == 0 && @$proposal["status"] == "closed"){ ?>
			  			<div class="progress-bar bg-white text-dark" 
			  				 role="progressbar" style="width:100%">
					    	 <?php echo Yii::t("cooperation", "No vote"); ?>
					  </div>
			  <?php } ?>

			</div> 
	  	</a>
	</li>
	<?php } //end if ?>