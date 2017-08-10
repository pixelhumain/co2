<?php 
	
	$cssAnsScriptFilesTheme = array(
		"/plugins/Chart-2.6.0/dist/Chart.min.js"
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>

<style>
#podVote{
	border: 1px solid grey;
}
#podVote .btn-link.bg-white{
	color:black;
	border-color: black;
}
#podVote .btn-link{
	width:100%;
	border-radius:4px;
	text-decoration: none;
}
</style>

<div class="col-lg-12 col-md-12 col-sm-12 padding-top-15" id="podVote">
	
	<div class="col-lg-4 col-md-4 col-sm-4 text-center padding-15 pull-right">
		<canvas id="pieVote"/>
	</div>

	

 	<?php 
 		$voteRes = array("Pour"=> array("bg-color"=> "green-k",
 										"votant"=>55,
 										"percent"=>55),
 						"Contre"=> array("bg-color"=> "red",
 										"votant"=>25,
 										"percent"=>25),
 						"Blanc"=> array("bg-color"=> "white",
 										"votant"=>5,
 										"percent"=>5),
 						"Incomplet"=> array("bg-color"=> "orange",
 										"votant"=>15,
 										"percent"=>15),

 		);

 		foreach ($voteRes as $key => $value) {
 	?>

	<div class="col-lg-8 col-md-8 col-sm-8 text-center no-padding pull-left margin-top-5">
		<div class="col-lg-5 col-md-5 col-sm-7 text-center pull-left margin-top-5">
			<button class="btn btn-link btn-sm bg-<?php echo $value["bg-color"]; ?> tooltips"
					data-original-title="cliquer pour voter" data-placement="left"><?php echo $key; ?></button>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 text-center pull-left margin-top-5 tooltips"
					data-original-title="<?php echo $value["votant"]; ?> votants" data-placement="right">
			<label><?php echo $value["percent"]; ?>%</label>
		</div>
		<div class="col-lg-5 col-md-5 col-sm-5 text-center pull-left margin-top-5 hidden-sm hidden-xs">
			<small><?php echo $value["votant"]; ?> votants</small><br>
		</div>
	</div>

	<?php } ?>

	<div class="col-lg-12 col-md-12 col-sm-12 pull-left">
		<label>
			Majorité : <b>50%</b> 
			Proposition temporairement <span class="bold letter-green">Validée</span>
		</label>
	</div>

</div>

<script type="text/javascript">
	var myPieChart;
	jQuery(document).ready(function() { //alert("start loadchart");
		//setTimeout(function(){chartInit();},200);
		chartInit();
	});

	function chartInit(){ //alert("start loadchart");
		var data = {
		    datasets: [{
		    	data: [10, 20, 30, 40],
		    

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