<div class="col-lg-4 col-md-5 col-sm-6 padding-top-15 hidden pull-right bg-white shadow2" id="amendement-container">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<h5 class="pull-left"><i class="fa fa-angle-down"></i> Amendements</h5>
		<button class="btn btn-default pull-right tooltips" 
				data-original-title="Fermer cette fenêtre" data-placement="bottom"
				id="btn-hide-amendement"><i class="fa fa-times"></i></button>
		<button class="btn btn-default pull-right margin-right-5 tooltips" 
				data-original-title="Actualiser les données" data-placement="bottom"
				data-id-proposal="<?php echo $proposal["_id"]; ?>"
				id="btn-refresh-amendement"><i class="fa fa-refresh"></i></button>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12">
		<hr>
		<?php if($auth && @$proposal["status"] == "amendable"){ ?>
			<button class="btn btn-link radius-5 text-purple col-lg-12 col-md-12 col-sm-12 btn-create-amendement">
				<i class="fa fa-pencil"></i> <?php echo Yii::t("cooperation", "Submit an amendement"); ?>
			</button>
		<?php } else if(@$proposal["status"] != "amendable"){ ?>
			<label class="bg-white letter-purple">
				<i class="fa fa-clock-o"></i> <?php echo Yii::t("cooperation", "Amendement session is closed"); ?>
			</label>
			<hr>
		<?php } else if(!$auth){ ?>
			<label class="badge bg-purple col-lg-12 col-md-12 col-sm-12">
				<i class="fa fa-lock"></i> <?php echo Yii::t("cooperation", "You must be member or contributor"); ?><br><?php echo Yii::t("cooperation", "to submit amendements"); ?>
			</label>
		<?php } ?>
	</div>

	 <div class="form-group col-lg-12 col-md-12 col-sm-12 hidden" id="form-amendement">
	  <hr>
	  <label><i class="fa fa-pencil"></i> <?php echo Yii::t("cooperation", "Write your amendement"); ?> :</label><br>
	  <small><i><?php echo Yii::t("cooperation", "If your amendement is adopted, it will be added to the principale proposal, <br>and will incorporated the final proposal, submited to vote."); ?></i></small><br><br>
	  <textarea class="form-control" rows="8" id="txtAmdt" placeholder="<?php echo Yii::t("cooperation", "your amendement"); ?>"></textarea>
	  <br>
	  <small class="pull-left"><i><?php echo Yii::t("cooperation", "Size max : 1000 caracters"); ?></i></small>
	  
	  <small class="pull-right" id="charsLeft"></small><br>
	  <small class="pull-left"><i>(<?php echo Yii::t("cooperation", "Size min : 10 caracters"); ?>)</i></small>
	  <div class="ol-lg-12 col-md-12 col-sm-12 margin-top-10 no-padding">
		  <button class="btn btn-sm btn-link radius-5 bg-green-k pull-right" id="btn-save-amendement">
				<i class="fa fa-save"></i> <?php echo Yii::t("cooperation", "Save my amendement"); ?>
		  </button>
		  <button class="btn btn-sm btn-link radius-5 bg-red pull-right margin-right-10 btn-create-amendement">
				<i class="fa fa-times"></i> <?php echo Yii::t("common", "Cancel"); ?>
		  </button>
	  </div>
	  <hr class="col-lg-12 col-md-12 col-sm-12 no-padding">
	</div> 

	<?php 
		$allVotesRes = array();

		if(@$amendements){
			foreach($amendements as $key => $am){
				//var_dump($am); //exit;
				$author = Person::getSimpleUserById(@$am["idUserAuthor"]);
				$allVotes = @$am["votes"] ? $am["votes"] : array();
				$myId = Yii::app()->session["userId"];
				$hasVoted = Cooperation::userHasVoted($myId, $allVotes);
		 		$voteRes = Proposal::getAllVoteRes($am);
		 		unset($voteRes["uncomplet"]);
		 		$allVotesRes[$key] = $voteRes;

		 		$this->renderPartial('../cooperation/pod/amendement', 
		 								array(	"key"=>$key, "am"=>$am, 
		  										"proposal"=>@$proposal,
												"author" => $author,
												"voteRes" => $voteRes,
												"allVotes" => $allVotes,
												"myId" => $myId,
												"auth" => $auth,
												"hasVoted" => $hasVoted));
			}
		}else{ 
	?>
	<div class="col-lg-12 col-md-12 col-sm-12 margin-top-">
		<h5 class="text-left"><i class="fa fa-ban"></i> <?php echo Yii::t("cooperation", "No amendement"); ?></h5>
	</div>
	<?php } ?>
		
</div>

<script type="text/javascript">
	var myPieChart;
	var amendements = <?php echo json_encode(@$amendements); ?> ;
	var allVotesRes = <?php echo json_encode($allVotesRes); ?>;
	jQuery(document).ready(function() { //alert("start loadchart");
		
		var i=0;
		if(allVotesRes != null){
			$.each(allVotesRes, function(key, voteRes){
				var voteValues = new Array();
				var totalVotant = 0;

				if(voteRes.up != "undefined") 		{ voteValues.push(voteRes.up.percent); totalVotant+=voteRes.up.votant; }
				if(voteRes.down != "undefined") 	{ voteValues.push(voteRes.down.percent); totalVotant+=voteRes.down.votant; }
				if(voteRes.white != "undefined") 	{ voteValues.push(voteRes.white.percent); totalVotant+=voteRes.white.votant; }
				
				if(totalVotant > 0)
				chartInitAm(key, voteValues);
			});
		}

		$("#btn-save-amendement").click(function(){
			uiCoop.saveAmendement(idParentProposal, "add");
		});

		$(".btn-send-vote-amendement").click(function(){
			var voteValue = $(this).data('vote-value');
			var idAmdt = $(this).data('vote-id-amdt');
			console.log("send vote", voteValue),
			uiCoop.sendVote("amendement", idParentProposal, voteValue, idParentRoom, idAmdt);
		});

		$("#btn-save-amendement").attr("disabled", "disabled");

		$("#txtAmdt").keyup(function(){
			var txt = $(this).val();
			if(txt.length > 1000){ console.log('len1', txt.length);
				txt = txt.substr(0, 1000); console.log('len2', txt.length);
				$(this).val(txt);
			}
			if(txt.length >= 10){ 
				$("#charsLeft").addClass("letter-green");
				$("#btn-save-amendement").removeAttr("disabled");
			}else { 
				$("#charsLeft").removeClass("letter-green"); 
				$("#btn-save-amendement").attr("disabled", "disabled");
			}

			$("#charsLeft").html(txt.length+" / 1000");
		});

		//$('#txtAmdt').limit('140','#charsLeft');
	});

	function chartInitAm(key, data){ 
		console.log("chartInitAm", key, data);
		var data = {
		    datasets: [{
		    	data: data,
			    // These labels appear in the legend and in the tooltips when hovering different arcs
			    backgroundColor: [
	                '#34a853',
	                '#E33551',
	                '#FFF',
	            ],
	            borderColor: [
	                '#34a853',
	                '#E33551',
	                '#aba9a9',
	            ],
	            borderWidth: 1
            }],
            labels: [
			        'Pour',
			        'Contre',
			        'Blanc',
			    ],
			    
		};
		var ctx = $("#res-vote-chart-"+key).get(0).getContext("2d");
		var options;
		myPieChart = new Chart(ctx,{
		    type: 'pie',
		    data: data,
			options: {
				responsive: true,
				//maintainAspectRatio:false,
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