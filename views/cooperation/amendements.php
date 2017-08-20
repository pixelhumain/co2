<div class="col-lg-4 col-md-5 col-sm-6 padding-top-15 hidden pull-right bg-white shadow2" id="amendement-container">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<h5 class="pull-left"><i class="fa fa-angle-down"></i> Amendements</h5>
		<button class="btn btn-default pull-right" id="btn-hide-amendement"><i class="fa fa-times"></i></button>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12">
		<hr>
		<button class="btn btn-link radius-5 text-purple col-lg-12 col-md-12 col-sm-12" id="btn-create-amendement">
			<i class="fa fa-pencil"></i> Proposer un amendement
		</button>
	</div>

	<?php $amendements = array( array("pseudo"=>"pseudo1",
									  "type"=>"Ajout", 
									  "color"=>"green"), 

								array("pseudo"=>"pseudo2",
									  "type"=>"Suppression",
									  "color"=>"red"), 

								array("pseudo"=>"pseudo3",
									  "type"=>"Modification",
									  "color"=>"orange") 
							);
	?>

	<?php $i=0;
		foreach($amendements as $key => $am){ $i++;
	?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow2 margin-top-15 padding-15 podVoteAmendement">
			
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 pull-left no-padding">
				<img src="<?php echo $this->module->assetsUrl.'/images/thumbnail-default.jpg'; ?>" 
					 class="img-circle pull-left margin-right-10" height="30" width="30">
				<label class="pull-left margin-top-5">Pseudo</label>
				
				<h6 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-10 no-padding">Vous n'avez pas voté</h6>
				<label class="pull-left">n°<?php echo $i; ?> <span class="letter-green">
					<i class="fa fa-angle-right"></i> Ajout</span>
				</label>
			</div>

			<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2 pull-right">
				<canvas class="" id="res-vote-chart-<?php echo $i; ?>" width="100%" height="100px"/>
			</div>
			
			<p class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
				Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit
			</p>
			<?php 
		 		$voteRes = array("Pour"=> array("bg-color"=> "green-k",
		 										"votant"=>55, "percent"=>55),
		 						"Contre"=> array("bg-color"=> "red",
		 										"votant"=>25, "percent"=>25),
		 						"Blanc"=> array("bg-color"=> "white",
		 										"votant"=>5, "percent"=>5),
		 		);
		 		foreach ($voteRes as $key => $value) {
		 	?>

			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center pull-left margin-top-5 padding-5">
					<button class="btn btn-link btn-sm bg-<?php echo $value["bg-color"]; ?> 
									tooltips col-lg-12 col-md-12 col-sm-12 col-xs-12"
							data-original-title="cliquer pour voter" data-placement="bottom">
							<?php echo $key; ?> (<?php echo $value["percent"]; ?>%)
					</button>			
			</div>

			<?php } ?>

			
		</div>

	<?php } ?>
		
</div>

<script type="text/javascript">
	var myPieChart;
	var voteRes = <?php echo json_encode($voteRes); ?> 
	jQuery(document).ready(function() { //alert("start loadchart");
		//setTimeout(function(){chartInit();},200);
		var i=0;
		$.each(voteRes, function(key, val){ i++;
			chartInitAm(i);
		});
	});

	function chartInitAm(key){ //alert("start loadchart");
		var data = {
		    datasets: [{
		    	data: [55, 25, 20],
		    
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
		//myPieChart.canvas.style.height = '50px';
	}
</script>