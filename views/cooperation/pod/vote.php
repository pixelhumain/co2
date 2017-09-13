<style>
#podVote{
	/*border: 1px dashed grey;*/
	border-radius: 20px;
	margin-top:35px;
	margin-bottom:30px;
	background: #f3f3f3;
	/*color: white;*/
}
</style>

<div class="col-lg-12 col-md-12 col-sm-12 padding-top-15 padding-bottom-5" id="podVote">
	
	<div class="col-lg-3 col-md-4 col-sm-4 text-center padding-15 pull-right">
		<canvas id="pieVote"/>
	</div>

		<div class="col-lg-4 col-md-4 col-sm-5 text-center no-padding pull-left">
			<h5 class="no-margin">
				<?php if(@$proposal["status"] == "tovote" && $auth){ ?>
					<i class="fa fa-hand-o-up"></i> VOTER
				<?php }else if(@$proposal["status"] != "tovote"){ ?>
					<i class="fa fa-balance-scale"></i> RÉSULTATS
				<?php }else if(!$auth){ ?>
					<i class="fa fa-lock"></i> Devenez membre ou contributeur pour voter
				<?php } ?>
			</h5>

		</div>

		
 	<?php 
 		$voteRes = Proposal::getAllVoteRes($proposal);
 		$totalVotant = Proposal::getTotalVoters($proposal); 
 		foreach ($voteRes as $key => $value) {
 	?>
		<div class="col-lg-8 col-md-8 col-sm-8 text-center no-padding pull-left margin-top-5">
			<div class="col-lg-1 col-md-1 col-sm-1 text-center no-padding pull-left margin-top-5">
				<?php if($key == $hasVote){ ?>
					<i class="fa fa-chevron-right pull-right" style="margin-top:8px;"></i> 
					<i class="fa fa-user-circle pull-right tooltips" style="margin-top:8px;"
						data-original-title="vous avez voté <?php echo Yii::t("cooperation", $hasVote); ?>" 
						data-placement="right"></i>
				<?php } ?>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-6 text-center pull-left margin-top-5">
				<?php if(@$proposal["status"] == "tovote" && $auth){ ?>
					<button class="btn btn-send-vote btn-link btn-sm bg-<?php echo $value["bg-color"]; ?> tooltips"
							data-original-title="cliquer pour voter" data-placement="right"
							data-vote-value="<?php echo $value["voteValue"]; ?>"><?php echo Yii::t("cooperation", $key); ?>
					</button>
				<?php }else{ ?>
					<label class="col-lg-12 col-md-12 col-sm-12 badge padding-10 bg-<?php echo $value["bg-color"]; ?>">
						<?php echo Yii::t("cooperation", $key); ?>
					</label>
				<?php } ?>

			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 text-center pull-left margin-top-5 tooltips"
						data-original-title="<?php echo $value["votant"]; ?> votants" data-placement="right">
				<label><?php echo $value["percent"]; ?>%</label>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 text-center pull-left margin-top-5 hidden-sm hidden-xs">
				<small><?php echo $value["votant"]; ?> votant(s)</small><br>
			</div>
		</div>

	<?php } ?>

	<div class="col-lg-12 col-md-12 col-sm-12 pull-left padding-15 majority-space">

			<?php if(@$proposal["status"] == "tovote" && $auth){ ?>
				<?php if($hasVote!=false){ ?>
					<h5 class="no-margin col-lg-4 col-md-4 col-sm-5 text-center pull-left" 
						style="padding-left: 0px !important;">Vous avez voté 
						<span class="letter-<?php echo Cooperation::getColorVoted($hasVote); ?>">
							<?php echo Yii::t("cooperation", $hasVote); ?>
						</span>
					</h5>
				<?php }else{ ?>
					<h5 class="no-margin col-lg-4 col-md-4 col-sm-5 text-center pull-left" 
						style="padding-left: 0px !important;">Vous n'avez pas voté</h5>
				<?php } ?>
				<br>
			<?php } ?>
		<small>
			<i class="fa fa-2x fa-balance-scale"></i> Majorité : <b><?php echo @$proposal["majority"]; ?>%</b> 
			<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && $voteRes["up"]["percent"] > @$proposal["majority"] ){ ?>
				 Proposition <?php if($proposal["status"] != "closed"){ ?>temporairement <?php } ?>
				 <span class="bold letter-green">Validée</span>
			<?php }else{ ?>
				 Proposition <?php if($proposal["status"] != "closed"){ ?>temporairement <?php } ?> 
				 <span class="bold letter-red">Refusée</span>
			<?php } ?>
		</small>
		
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
		console.log("voteRes", voteRes);
		$.each(voteRes, function(key, val){
			console.log("val.percent", val);
			voteValues.push(val.percent);
		});

		var data = {
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
			        'Pour',
			        'Contre',
			        'Blanc',
			        'Incomplet'
			    ],
			    
		};
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