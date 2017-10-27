<?php 
	$author = Person::getById(@$proposal["creator"]);
	$profilThumbImageUrl = Element::getImgProfil($author, "profilThumbImageUrl", $this->module->assetsUrl);

	$myId = Yii::app()->session["userId"];
	$hasVote = @$proposal["votes"] ? Cooperation::userHasVoted($myId, $proposal["votes"]) : false; 
	$auth = Authorisation::canParticipate(Yii::app()->session['userId'], $proposal["parentType"], $proposal["parentId"]);
	
	$parentRoom = Room::getById($proposal["idParentRoom"]);

	$totalVotant = Proposal::getTotalVoters($proposal);
	$voteRes = Proposal::getAllVoteRes($proposal);
	

	if(isset(Yii::app()->session['userId'])){
		$me = Element::getByTypeAndId("citoyens", Yii::app()->session['userId']);
		$myRoles = @$me["links"]["memberOf"][@$proposal["parentId"]]["roles"] ? 
				   @$me["links"]["memberOf"][@$proposal["parentId"]]["roles"] : array();
	}else{
		$myRoles = array();
	}	
	
	//lock access if the user doesnt have the good role
	$accessRoom = @$parentRoom ? Room::getAccessByRole($parentRoom, $myRoles) : ""; 
	if($accessRoom == "lock") exit;
?>

<?php if(@$access=="deny"){ ?>
	<div class="col-lg-12 col-md-12 col-sm-12">
		<h5 class="padding-left-10 letter-red">
			<i class="fa fa-ban"></i> <?php echo Yii::t("cooperation","You are not allowed to access this content"); ?>		  	
		</h5>
		<h5 class="padding-left-10 letter-red">
			<small><?php echo Yii::t("cooperation","You must be member or contributor"); ?></small>  	
		</h5>
	</div>
<?php exit; } ?>


<div class="col-lg-7 col-md-6 col-sm-6 pull-left margin-top-15">
  	<h4 class="letter-turq load-coop-data title-room" 
  		data-type="room" data-dataid="<?php echo @$proposal["idParentRoom"]; ?>">
  		<i class="fa fa-connectdevelop"></i> <i class="fa fa-hashtag"></i> <?php echo @$parentRoom["name"]; ?>
	</h4>
</div>


<div class="col-lg-5 col-md-6 col-sm-6">
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 tooltips" 
				data-original-title="<?php echo Yii::t("cooperation","Close this window"); ?>" data-placement="bottom"
				id="btn-close-proposal">
		<i class="fa fa-times"></i>
	</button>
	<?php if($auth && @$proposal["creator"] == Yii::app()->session['userId']){ ?>
		 <div class="pull-right dropdown">
		  <button class="btn btn-default margin-left-5 margin-top-10" data-toggle="dropdown">
			<i class="fa fa-cog"></i> options
		  </button>
		  <ul class="dropdown-menu">
		  	<?php if(!@$proposal["amendements"] && !$hasVote){ ?>
		    <li><a href="javascript:" id="btn-edit-proposal" 
		    		data-id-proposal="<?php echo $proposal["_id"]; ?>">
		    	<i class="fa fa-pencil"></i> <?php echo Yii::t("cooperation","Edit my proposal"); ?>
		    	</a>
		    </li>
			<?php }else{ ?>
			<?php 
				$tradTitle = Yii::t("cooperation","Edition disabled")." : ";
				if(@$proposal["amendements"]) $tradTitle .= Yii::t("cooperation",'amendement session has begun'); 
				else if($hasVote) $tradTitle .= Yii::t("cooperation",'vote session has begun');
			?>
			<li><button class="btn btn-link tooltips" disabled="true" style="width: 100%;"
				data-original-title="<?php echo $tradTitle; ?>" data-placement="left">
		    	<i class="fa fa-pencil"></i> <?php echo Yii::t("cooperation","Edit my proposal"); ?>
		    	</button>
		    </li>
			<?php } ?>

			<?php if(@$proposal["status"] == "disabled"){ ?>
			    <li><a href="javascript:" class="btn-option-status-proposal" 
			    		data-id-proposal="<?php echo $proposal["_id"]; ?>"
			    		data-status="amendable">
			    	<i class="fa fa-pencil"></i> <?php echo Yii::t("cooperation","Back to amendements"); ?>
			    	</a>
			    </li>
			    <li><a href="javascript:" class="btn-option-status-proposal" 
			    		data-id-proposal="<?php echo $proposal["_id"]; ?>"
			    		data-status="tovote">
			    	<i class="fa fa-gavel"></i> <?php echo Yii::t("cooperation","Open votes"); ?>
			    	</a>
			    </li>
		    <?php }else{ ?>
			    <li><a href="javascript:" class="btn-option-status-proposal" 
			    		data-id-proposal="<?php echo $proposal["_id"]; ?>"
			    		data-status="disabled">
			    	<i class="fa fa-times"></i> <?php echo Yii::t("cooperation","Disabled my proposal"); ?>
			    	</a>
			    </li>
		    <?php } ?>
		    <!-- <li><hr class="margin-5"></li> -->
		    <li><a href="javascript:" class="btn-option-status-proposal" 
		    		data-id-proposal="<?php echo $proposal["_id"]; ?>"
		    		data-status="closed">
		    		<i class="fa fa-trash"></i> <?php echo Yii::t("cooperation","Close my proposal"); ?>
		    	</a>
		    </li>
		  </ul>
		</div> 
	<?php } ?>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 tooltips" 
				data-original-title="<?php echo Yii::t("cooperation","Update datas"); ?>" data-placement="bottom"
				data-id-proposal="<?php echo $proposal["_id"]; ?>"
				id="btn-refresh-proposal"><i class="fa fa-refresh"></i></button>

	<button class="btn btn-default pull-right margin-left-5 margin-top-10 btn-extend-proposal tooltips" 
				data-original-title="<?php echo Yii::t("cooperation","Enlarge reading space"); ?>" data-placement="bottom">
		<i class="fa fa-long-arrow-left"></i>
	</button>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 hidden btn-minimize-proposal tooltips" 
				data-original-title="<?php echo Yii::t("cooperation","Reduce reading space"); ?>" data-placement="bottom">
		<i class="fa fa-long-arrow-right"></i>
	</button>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 pull-left margin-top-10" style="padding-left: 8px;">

	<label>
		<img class="img-circle" id="menu-thumb-profil" 
         width="30" height="30" src="<?php echo $profilThumbImageUrl; ?>" alt="image" >
		<a href="#page.type.citoyens.id.<?php echo $proposal["creator"]; ?>" class="lbh">
			<?php echo $author["username"]; ?></a><?php if($myId == $proposal["creator"]){ ?><small>, 
			<?php echo Yii::t("cooperation","your are the author of this proposal"); ?> </small>
		<?php }else{ ?>
		<small> <?php echo Yii::t("cooperation","is the author of this proposal"); ?></small>
		<?php } ?>
	</label>

	<hr style="margin-top:5px;">
	<h4 class="no-margin status-breadcrum">
		
		<small><i class="fa fa-certificate"></i></small>
		<?php if(@$proposal["status"] == "amendable"){ ?>		
			<span class="letter-purple underline"><?php echo Yii::t("cooperation", $proposal["status"]); ?></span>	
		<?php }else{ ?>	
			<small><?php echo Yii::t("cooperation", "amendable"); ?></small>	
		<?php } ?>			
		
		<small><i class="fa fa-chevron-right"></i></small>
		<?php if(@$proposal["status"] == "tovote"){ ?>
			<span class="letter-green underline"><?php echo Yii::t("cooperation", $proposal["status"]); ?></span>	
		<?php }else if(@$proposal["status"] == "disabled"){ ?>
			<span class="letter-orange underline"><?php echo Yii::t("cooperation", $proposal["status"]); ?></span>	
		<?php }else{ ?>
			<small><?php echo Yii::t("cooperation", "tovote"); ?></small>	
		<?php } ?>
		
		<small><i class="fa fa-chevron-right"></i></small>
		<?php if(@$proposal["status"] == "closed"){ ?>
			<span class="letter-red underline"><?php echo Yii::t("cooperation", $proposal["status"]); ?></span>
		<?php }else if(@$proposal["status"] == "resolved"){ ?>
			<span class="letter-red underline"><?php echo Yii::t("cooperation", $proposal["status"]); ?></span>
		<?php }else{ ?>
			<small><?php echo Yii::t("cooperation", "closed"); ?></small>
		<?php } ?>
	</h4>

	<?php if(@$proposal["status"] == "amendable"){ ?>
		<hr>
		<h4 class="text-purple no-margin">
			<i class="fa fa-pencil"></i> <?php echo Yii::t("cooperation", "Proposal submited to amendements"); ?> 
			<small class="text-purple"><?php echo Yii::t("cooperation", "until"); ?> 
				<?php echo date('d/m/Y H:i e', strtotime($proposal["amendementDateEnd"])); ?>
				<br><i class="fa fa-angle-right"></i> <?php echo Yii::t("cooperation", "End of amendement session"); ?> 
				</small><?php echo Translate::pastTime($proposal["amendementDateEnd"], "date"); ?>
			
		</h4>
		<small><?php echo Yii::t("cooperation", "You can submit your amendements and vote amendement proposed by other users"); ?> </small>
		<hr>
	<?php } ?>
</div>



<div class="col-lg-9 col-md-12 col-sm-12 pull-left margin-bottom-15">
	
	<?php if(@$proposal["status"] == "tovote"){ ?>
		<hr>
		<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && $voteRes["up"]["percent"] > @$proposal["majority"] ){ ?>
			 <h4><?php echo Yii::t("cooperation", "Proposal"); ?> <?php if($proposal["status"] != "closed"){ ?>
			 	<?php echo Yii::t("cooperation", "temporaly"); ?> <?php } ?>
				 <span class="bold letter-green"><?php echo Yii::t("cooperation", "Validated"); ?></span> · 
				 <small><?php echo $totalVotant; ?> <?php echo Yii::t("cooperation", "voter"); ?>
				 <?php echo $totalVotant > 1 ? "s" : ""; ?></small>
			 </h4>
		<?php }else{ ?>
			 <h4><?php echo Yii::t("cooperation", "Proposal"); ?> <?php if($proposal["status"] != "closed"){ ?>
			 	<?php echo Yii::t("cooperation", "temporaly"); ?> <?php } ?> 
				 <span class="bold letter-red"><?php echo Yii::t("cooperation", "Refused"); ?></span> · 
				 <small><?php echo $totalVotant; ?> <?php echo Yii::t("cooperation", "voter"); ?>
				 <?php echo $totalVotant > 1 ? "s" : ""; ?></small>
			 </h4>
		<?php } ?>

		
		<div class="progress <?php if($proposal["status"] != "tovote") echo "hidden-min"; ?>">
			<?php 
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
					<div class="progress-bar bg-turq" role="progressbar" style="width:100%">
					    <?php echo Yii::t("cooperation", "Be the first to vote"); ?>
					  </div>
			<?php } ?>
		</div> 

		<h5>
			<?php if(@$proposal["voteDateEnd"]){ ?>
				<i class='fa fa-clock-o'></i> <?php echo Yii::t("cooperation", "End of vote session"); ?> 
				<?php echo Translate::pastTime($proposal["voteDateEnd"], "date"); ?> · 
				<small class='letter-green'> 
					<?php echo date('d/m/Y H:i e', strtotime($proposal["voteDateEnd"])); ?>
				</small>
			<?php }else{ ?>
				<?php echo Yii::t("cooperation", "Vote open until undefined date"); ?>
			<?php } ?>
			
		</h5>
	<?php } ?>

	<?php if(@$proposal["status"] == "tovote" && $hasVote!=false){ ?>
		<h5 class="pull-left no-margin"><i class="fa fa-user-circle"></i> <?php echo Yii::t("cooperation", "You did vote"); ?> 
			<span class="letter-<?php echo Cooperation::getColorVoted($hasVote); ?>">
				<?php echo Yii::t("cooperation", $hasVote); ?>
			</span>
		</h5>
	<?php }elseif(@$proposal["status"] == "tovote"){ ?>
		<h5 class="letter-red pull-left no-margin">
			<i class="fa fa-user-circle"></i> <?php echo Yii::t("cooperation", "You did not vote"); ?>
		</h5>
	<?php } ?>
</div>


<?php if(@$proposal["status"] == "resolved"){ ?>
	<div class="col-lg-12 col-md-12 col-sm-12 margin-bottom-15">
		<hr>
		<h4 class="">
			<i class="fa fa-bell"></i> 
			<?php echo Yii::t("cooperation", "The <b>resolution</b> has been taken : "); ?>
			<br class="visible-md">
			<small><?php echo Yii::t("cooperation", "The proposal is"); ?> 
			 	<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && 
			 			$voteRes["up"]["percent"] > @$proposal["majority"] ){ ?>
					<span class="letter-green"><?php echo Yii::t("cooperation", "validated"); ?></span>
				 <?php }else{ ?>
			 	<span class="letter-red"><?php echo Yii::t("cooperation", "refused"); ?></span>
				<?php } ?>
			</small>
		</h4>
		<?php if(@$proposal["voteDateEnd"]){ ?>
			<i class='fa fa-clock-o'></i> <?php echo Yii::t("cooperation", "End of vote session"); ?> 
			<?php echo Translate::pastTime($proposal["voteDateEnd"], "date"); ?> · 
			<small class='letter-green'>le 
				<?php echo date('d/m/Y H:i e', strtotime($proposal["voteDateEnd"])); ?>
			</small>
		<?php } ?><br>
		<button class="btn btn-default load-coop-data"
				data-type="resolution" data-dataid="<?php echo @$proposal["idResolution"]; ?>">
				<i class="fa fa-chevron-right"></i> <?php echo Yii::t("cooperation", "Show the resolution"); ?>
		</button>

	</div>
<?php } ?>

<div class="col-lg-12 col-md-12 col-sm-12 margin-top-5">
	
	<div class="padding-25 bg-lightblue radius-5" id="container-text-proposal">

			<?php if(@$proposal["title"]){ ?>
				<h3><i class="fa fa-hashtag"></i> <?php echo @$proposal["title"]; ?></h3>
			<?php }else{ ?>
				<h3><i class="fa fa-angle-down"></i> <?php echo Yii::t("cooperation", "Proposal"); ?></h3>
			<?php } ?>
		
			<?php if(@$proposal["description"]){
					$proposal["description"] = Translate::strToClickable($proposal["description"]);
			} ?>
			
			<?php echo nl2br(@$proposal["description"]); ?>
			<?php if(@$proposal["tags"]){ ?>
				<br><br> <b>Tags : </b>
				<?php foreach($proposal["tags"] as $key => $tag){ ?>
					<span class="letter-red margin-right-15">#<?php echo $tag; ?></span>
				<?php } ?>	
				
			<?php } ?>
	</div>


		<div class="col-lg-12 col-md-12 col-sm-12 margin-top-15 no-padding">
			<?php if(@$proposal["status"] == "amendable"){ ?>
				<?php if($auth){ ?>
					<button class="btn btn-link text-purple radius-5 btn-create-amendement">
						<i class="fa fa-pencil"></i> <?php echo Yii::t("cooperation", "Submit an amendement"); ?>
					</button>
				<?php } ?>
				<button class="btn btn-link text-purple radius-5 btn-show-amendement">
					<?php echo Yii::t("cooperation", "Show amendements"); ?> (<?php echo count(@$proposal["amendements"]); ?>) <i class="fa fa-chevron-right"></i>
				</button>
				<hr>
			<?php }else if((@$proposal["status"] == "closed" || @$proposal["status"] == "disabled") 
							&& count(@$proposal["amendements"]) > 0){ ?>
				<button class="btn btn-link text-purple radius-5 btn-show-amendement pull-left">
					<?php echo Yii::t("cooperation", "Show all amendements"); ?> (<?php echo count(@$proposal["amendements"]); ?>) <i class="fa fa-chevron-right"></i>
				</button><br>
				<!-- 
				<h5 class="no-margin"><span class="text-red">La session de vote est terminée</span> 
					<?php //echo " · ".Yii::t("cooperation", "end")." ".Translate::pastTime($proposal["voteDateEnd"], "date"); ?>
				</h5> -->
				<br>
			<?php } ?>
			<!-- <hr>	 -->
			<?php if(@$proposal["amendementActivated"] == "true"){ ?>

			<h4 class="pull-left text-purple">
				
				<i class="fa fa-angle-down"></i> <?php echo Yii::t("cooperation", "List of amendements"); ?> 
				<?php if(@$proposal["status"] == "amendable"){ ?><?php echo Yii::t("cooperation", "temporaly"); ?><?php } ?> 
				<?php echo Yii::t("cooperation", "validated"); ?> · 

				<small>
					<i class="fa fa-balance-scale"></i> <?php echo Yii::t("cooperation", "Majority"); ?> : <b><?php echo @$proposal["majority"]; ?>%</b> 
				</small>
			</h4>
			
			<button class="btn btn-default pull-right btn-extend-proposal">
				<i class="fa fa-long-arrow-left"></i>
			</button>
			<button class="btn btn-default pull-right btn-minimize-proposal hidden">
				<i class="fa fa-long-arrow-right"></i>
			</button>
			<div class="col-lg-12 col-md-12 col-sm-12 no-padding">
				<?php 
					$i=0;
					if(@$proposal["amendements"]){
						foreach($proposal["amendements"] as $key => $am){ 
							//var_dump($am); //exit;
							$author = Person::getSimpleUserById(@$am["idUserAuthor"]);
							$allVotes = @$am["votes"] ? $am["votes"] : array();
							$myId = Yii::app()->session["userId"];
							$hasVoted = Cooperation::userHasVoted($myId, $allVotes);
					 		$voteRes = Proposal::getAllVoteRes($am);
					 		unset($voteRes["uncomplet"]);
					 		$allVotesRes[$key] = $voteRes;
					 		$validate = @$voteRes["up"] && 
					 					@$voteRes["up"]["percent"] && 
					 					$voteRes["up"]["percent"] > @$proposal["majority"];
				?>
				<?php if($validate == true){ $i++; ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow2 margin-top-15 padding-15 podVoteAmendement">
				
						<label class="pull-left"><span class="badge bg-purple">n°<?php echo $key; ?></span> 
						<span class="letter-green">
							<i class="fa fa-angle-right"></i> <?php echo Yii::t("cooperation", "Add"); ?></span>
						</label>
							
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 margin-top-5 no-padding textAmdt">
							<?php echo @$am["textAdd"]; ?>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding progress <?php if($proposal["status"] != "tovote") echo "hidden-min"; ?>">
				  	  		<?php 
				  	  			$voteRes = Proposal::getAllVoteRes($am);
				  	  			$totalVotant = Proposal::getTotalVoters($am);
					  	  		foreach($voteRes as $key => $value){ 
					  	  	?>
								  <div class="progress-bar bg-<?php echo $value["bg-color"]; ?>" role="progressbar" 
								  		style="width:<?php echo $value["percent"]; ?>%">
								    <?php echo $value["percent"]; ?>%
								  </div>
							<?php } ?>

						</div> 

					</div>
				<?php } //if ?>

				<?php } //foreach ?>
				<?php } if($i == 0){ echo "<i class='fa fa-ban'></i> ". Yii::t("cooperation", "No amendement validated"); } ?>
			</div>
		<?php }else{ ?>
			<h5 class="pull-left text-purple">
				<i class="fa fa-ban"></i> <?php echo Yii::t("cooperation", "Amendement disabled"); ?>
			</h5>
		<?php } ?>
	</div>

	<?php if(@$proposal["arguments"]){ ?>
		<hr>
		<h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-50 no-padding"><i class="fa fa-angle-down"></i> <?php echo Yii::t("cooperation", "More informations, arguments, exemples, demonstrations, etc"); ?></h4>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<?php echo nl2br(@$proposal["arguments"]); ?>
		</div>
	<?php } ?>

	

	<?php if(@$proposal["urls"]){ ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		<hr>	
		<h4 class=""><i class="fa fa-angle-down"></i> <?php echo Yii::t("cooperation", "External links"); ?></h4>
		<?php foreach($proposal["urls"] as $key => $url){ ?>
			<a href="<?php echo $url; ?>" target="_blank" class="btn btn-default bg-white shadow2 margin-bottom-5">
				<i class="fa fa-external-link"></i> <?php echo $url; ?>
			</a>
		<?php } ?>
	</div>
	<?php } ?>
</div>



<?php 
	if(@$proposal["status"] != "amendable") 
		$this->renderPartial('../cooperation/pod/vote', 
				array("proposal"=>$proposal, "auth" => $auth, "hasVote" => $hasVote));
?>

<div class="col-lg-12 col-md-12 col-sm-12"><hr></div>


<div class="col-lg-12 col-md-12 col-sm-12 margin-top-50 padding-bottom-15">

	<h4 class="text-center">
		<i class="fa fa-balance-scale fa-2x margin-bottom-10"></i>
		<br><?php echo Yii::t("cooperation", "Debat"); ?>
	</h4>
	<hr>

	<?php if($auth){ ?>
	<h4 class="text-center"><?php echo Yii::t("cooperation", "Add an argument"); ?><br><i class="fa fa-angle-down"></i></h4>

	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link bg-green-comment col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="up"><i class="fa fa-thumbs-up"></i> <?php echo Yii::t("cooperation", "For"); ?></button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval=""><?php echo Yii::t("cooperation", "Neutral"); ?></button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link bg-red-comment col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="down"><i class="fa fa-thumbs-down"></i> <?php echo Yii::t("cooperation", "Against"); ?></button>
	</div>
	<?php }else{ ?>
	<h5 class="text-center"><?php echo Yii::t("cooperation", "You must be member or contributor to participate"); ?><br><i class="fa fa-angle-down"></i></h5>
	<?php } ?>
</div>



<div class="col-lg-12 col-md-12 col-sm-12 margin-bottom-50" id="comments-container">
<hr>
</div>

<?php $this->renderPartial('../cooperation/amendements', 
							array("amendements"=>@$proposal["amendements"], 
								  "proposal"=>@$proposal,
								  "auth"=>$auth)); ?>

<script type="text/javascript">
	var parentTypeElement = "<?php echo $proposal['parentType']; ?>";
	var parentIdElement = "<?php echo $proposal['parentId']; ?>";
	var idParentProposal = "<?php echo $proposal['_id']; ?>";
	var idParentRoom = "<?php echo $proposal['idParentRoom']; ?>";
	var msgController = "<?php echo @$msgController ? $msgController : ''; ?>";

	currentRoomId = idParentRoom;

	jQuery(document).ready(function() { 
		
		uiCoop.initUIProposal();

	});

</script>