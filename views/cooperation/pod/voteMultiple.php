<style>

</style>

<div class="col-lg-12 col-md-12 col-sm-12 padding-top-15 padding-bottom-5" id="podVote">
	
	<div class="col-lg-2 col-md-2 col-sm-2 text-center padding-15 pull-right">
		<canvas id="pieVote"/>
	</div>

		<div class="col-lg-4 col-md-4 col-sm-5 text-left no-padding pull-left">
			<h5 class="no-margin">
				<?php if(@$proposal["status"] == "tovote" && $auth){ ?>
					<!-- <i class="fa fa-hand-o-up"></i> <?php echo Yii::t("cooperation", "VOTE NOW"); ?> -->
				<?php }else if(@$proposal["status"] != "tovote"){ ?>
					<i class="fa fa-balance-scale"></i> <?php echo Yii::t("cooperation", "RESULTS"); ?>
				<?php }else if(!$auth){ ?>
					<i class="fa fa-lock"></i> <?php echo Yii::t("cooperation", "You must be member or contributor to vote"); ?>
				<?php } ?>
			</h5>

		</div>

		
 	<?php 
 		$voteRes = Proposal::getAllVoteRes($proposal);
 		$totalVotant = Proposal::getTotalVoters($proposal); 
 		foreach ($voteRes as $key => $value) {
 			$identities = ""; 
 			if(@$proposal["voteAnonymous"] && @$proposal["voteAnonymous"] == "false"){
	 			$nbVotant=0;
	 			if(@$proposal["votes"][$key])
	 			foreach ($proposal["votes"][$key] as $idVotant) { $nbVotant++;
		 			if($nbVotant<50){ 
			 			$votant = Element::getByTypeAndId("citoyens", $idVotant);
			 			$identities .= $identities!="" ? ", " : "";
			 			$identities .= $votant["username"];
			 		}else if($nbVotant==50){
			 			$identities .= "...";
			 		}
		 		}
		 	}else{ $identities = Yii::t("cooperation", "votes are anonymous"); }

		 	$tooltipsVoteCantChange = "";
		 	if($hasVote && @$proposal["voteCanChange"] == "false") 
		 		$tooltipsVoteCantChange = Yii::t("cooperation", "You can not change your vote");
 	?>
		<div class="col-lg-10 col-md-10 col-sm-10 text-center no-padding pull-left margin-top-5">
			
			<!-- <div class="col-lg-1 col-md-1 col-sm-1 text-center padding-5 pull-left margin-top-15">
				
			</div> -->
			<!-- <div class="col-lg-1 hidden-md hidden-sm hidden-xs text-center pull-left margin-top-15" style="padding:10px 0 0 0;">
				<i class="fa fa-hashtag"></i><b><?php echo ($key+1); ?></b>
			</div>		
 -->

			<?php if(@$proposal["status"] == "tovote" && $auth && (!$hasVote || @$proposal["voteCanChange"] == "true")){ ?>
				<div class="col-lg-1 col-md-2 col-sm-2 no-padding text-center pull-left margin-left-15 margin-top-20">
					<button class="btn btn-send-vote btn-link btn-sm bg-vote bg-<?php echo $value["bg-color"]; ?> tooltips"
							data-original-title="<?php echo Yii::t("cooperation", "click to vote"); ?>" data-placement="bottom"
							data-vote-value="<?php echo $key; ?>"><i class="fa fa-gavel"></i>
					</button>
					<?php if($key === (int)$hasVote && $hasVote !== false){ ?>
					<br>
					<i class="fa fa-chevron-right pull-right margin-top-10"></i> 
					<i class="fa fa-user-circle pull-right tooltips margin-top-10"
						data-original-title="<?php echo Yii::t("cooperation", "You did vote"); ?> 
											 <?php echo !@$proposal["answers"] ? Yii::t("cooperation", $hasVote) : "#".($hasVote+1) ; ?>" 
						data-placement="right"></i>
				<?php } ?>
				</div>
			<?php } ?>


			<div class="col-lg-10 col-md-9 col-sm-9 text-left pull-left margin-top-15">
				<div class="padding-10 border-vote border-vote-<?php echo $key; ?>">
					<i class="fa fa-hashtag"></i><b><?php echo ($key+1); ?></b> 
					<?php echo $value["voteValue"]; ?>
				</div>
				<?php if($value["percent"]!=0){ ?>		
				<div class="progress progress-res-vote <?php if($proposal["status"] != "tovote") echo "hidden-min"; ?>">
	  	  			<div class="progress-bar bg-vote bg-<?php echo $value["bg-color"]; ?> tooltips"
							data-original-title="<?php echo $value["votant"]; ?> <?php echo Yii::t("cooperation", "voters"); ?>" data-placement="bottom" role="progressbar" 
				  		style="width:<?php echo $value["percent"]; ?>%">
				    	<?php echo $value["percent"]; ?>%
				  	</div>
				  	<div class="progress-bar bg-transparent" 
					 role="progressbar" 
				  		style="width:<?php echo 100-$value["percent"]; ?>%">
				    	<span class=" tooltips" data-original-title="<?php echo $identities; ?>" data-placement="bottom">
					 		<?php echo $value["votant"]; ?> <i class="fa fa-gavel"></i>
					 	</span>
				  	</div>
				</div>
				<?php } ?>

				<?php if($value["percent"]==0){ ?>
				<div class="col-lg-1 col-md-2 col-sm-2 no-padding text-left pull-left margin-top-5 tooltips"
							data-original-title="<?php echo $value["votant"]; ?> <?php echo Yii::t("cooperation", "voters"); ?>" data-placement="bottom">
					<label><?php echo $value["percent"]; ?>%</label>
				</div>
				<?php } ?>
				<!-- <div class="col-lg-6 col-md-6 col-sm-6 text-right pull-right margin-top-5 hidden-sm hidden-xs tooltips"
					 data-original-title="<?php echo $identities; ?>" data-placement="top">
					<small><?php echo $value["votant"]; ?> <?php echo Yii::t("cooperation", "voter"); ?>(s)</small><br>
				</div> -->

			</div>
		</div>

	<?php } ?>

	<div class="col-lg-12 col-md-12 col-sm-12 pull-left padding-15 majority-space">

		<?php if(@$proposal["status"] != "amendable" && $auth){ ?>
			<?php if($hasVote!==false){ ?>
				<h4 class="no-margin col-lg-8 col-md-8 col-sm-8 text-left pull-left" 
					style="padding-left: 0px !important;"><?php echo Yii::t("cooperation", "You did vote"); ?> 
					<span class="letter-<?php echo Cooperation::getColorVoted($hasVote); ?>">
						<i class="fa fa-hashtag"></i><?php echo ($hasVote+1); ?>
					</span>
				</h4>
			<?php }else{ ?>
				<h4 class="no-margin col-lg-8 col-md-8 col-sm-8 text-left pull-left" 
					style="padding-left: 0px !important;"><?php echo Yii::t("cooperation", "You did not vote"); ?></h4>
			<?php } ?>
			<br>
		<?php } ?>

		<hr style="border-color:lightgrey;">

		<h4 class="pull-left">
			<small>
				<i class="fa fa-gavel"></i> <?php echo Yii::t("cooperation", "Changing vote"); ?> : 
				<?php if(@$proposal["voteCanChange"] == "true"){ ?> 
					<span class="letter-green"><?php echo Yii::t("cooperation", "Allowed"); ?></span>
				<?php }else{ ?> 
					<span class="letter-red"><?php echo Yii::t("cooperation", "Not allowed"); ?></span>
				<?php } ?> 
				<br>
				<i class="fa fa-user-secret"></i> Vote anonyme : 
				<?php if(!isset($proposal["voteAnonymous"]) || @$proposal["voteAnonymous"] == "true"){ ?> 
					<span class="letter-green"><?php echo Yii::t("common", "Yes"); ?></span>
				<?php }else{ ?> 
					<span class="letter-red"><?php echo Yii::t("common", "No"); ?></span>
				<?php } ?> 
				
				
			</small>
		</h4>

	</div>

</div>

<script type="text/javascript">
	var myPieChart;
	var voteRes = <?php echo json_encode($voteRes); ?>;
	var totalVotant = <?php echo $totalVotant; ?>;
	jQuery(document).ready(function() { //alert("start loadchart");
		//setTimeout(function(){chartInit();},200);
		if(totalVotant > 0)
			chartInit();
	});

	function chartInit(){ //alert("start loadchart");
		var voteValues = new Array();
		console.log("voteRes", voteRes, "voteValues", voteValues);
		$.each(voteRes, function(key, val){
			console.log("val.percent", val);
			voteValues.push(val.percent);
		});

		/*var data = {
		    datasets: [{
		    	data: voteValues,
		    
			    // These labels appear in the legend and in the tooltips when hovering different arcs
			    backgroundColor: [
	                '#34a853',
	                '#E33551',
	                '#FFF',
	                '#FFA200',
	            ],
	            borderColor: [
	                '#34a853',
	                '#E33551',
	                '#aba9a9',
	                '#FFA200',
	            ],
	            borderWidth: 1
            }],
            labels: [
			        trad.Agree,
			        trad.Disagree,
			        trad.Abstain,
			        trad.Uncomplet
			    ],
			    
		};*/

		var backgroundColor = new Array();
		var borderColor = new Array();
		var labels = new Array();
		$.each(voteRes, function(key, value){
			console.log("voteValues", value);
			backgroundColor.push(value["bg-color-val"]);
			borderColor.push(value["bg-color-val"]);
			labels.push("#" + key);
		});

		var data = {
		    datasets: [{
		    	data: voteValues,
		    
			    // These labels appear in the legend and in the tooltips when hovering different arcs
			    backgroundColor: backgroundColor,
	            borderColor: borderColor,
	            borderWidth: 1
            }],
            labels: labels,
			    
		};
		console.log("data", data);

		var ctx = $("#pieVote").get(0).getContext("2d");
		var options;
		myPieChart = new Chart(ctx,{
		    type: 'pie',
		    data: data,
			options: {
				legend: {
					display: false
				},
				animation: {
					duration: 300
				}
			},
		    //options: options
		});
	}
</script>