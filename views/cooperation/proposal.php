<?php //var_dump($proposal); ?>

<div class="col-lg-5 col-md-5 col-sm-5 pull-left margin-top-10">
	<h5 class="">Status : 
		<small class="text-light">
			<i class="fa fa-pencil"></i> <?php echo $proposal["status"]; ?>
		</small>
	</h5>
</div>


<div class="col-lg-7 col-md-7 col-sm-7 no-padding">
	<button class="btn btn-default pull-right margin-left-5 margin-top-10" id="btn-close-proposal">
		<i class="fa fa-times"></i>
	</button>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10">
		<i class="fa fa-cog"></i> options
	</button>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10" id="btn-extend-proposal">
		<i class="fa fa-long-arrow-left "></i>
	</button>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 hidden" id="btn-minimize-proposal">
		<i class="fa fa-long-arrow-right"></i>
	</button>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 pull-left margin-top-10">

	<h6>
		<?php echo @$proposal["voteDateEnd"] ? "Fin du vote : ".$proposal["voteDateEnd"] : ""; ?>
	</h6>
	<h6>
		<?php echo @$proposal["amendementDateEnd"] ? "Fin des amendements : ".$proposal["amendementDateEnd"] : ""; ?>
	</h6>
	<hr>
	<h5 class="">Vous avez voté <span class="letter-green">pour</span> cette proposition</h5>
	
</div>

<?php 
	if(@$proposal["voteActivated"] == "true") 
		$this->renderPartial('../cooperation/pod/vote', array("proposal"=>$proposal));
?>

<div class="col-lg-12 col-md-12 col-sm-12">
	<hr>
	<h2><i class="fa fa-hashtag"></i> <?php echo $proposal["title"]; ?></h2>

	<h5><?php echo @$proposal["shortDescription"]; ?></h5>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 margin-top-25">
	<?php echo $proposal["description"]; ?>
	<hr>
	<button class="btn btn-default col-lg-12 col-md-12 col-sm-12">Afficher les amendements</button>

</div>


<div class="col-lg-12 col-md-12 col-sm-12 margin-top-25">
	<h4 class="text-center"><i class="fa fa-angle-down"></i><br>Débat</h4>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 margin-top-25" id="comments-container">
	
</div>



<script type="text/javascript">
	
	jQuery(document).ready(function() { 
		$("#comments-container").html("<i class='fa fa-spin fa-refresh'></i> Chargement des commentaires");
		getAjax("#comments-container",baseUrl+"/"+moduleId+"/comment/index/type/proposals/id/<?php echo $proposal['_id'] ?>",
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
		},"html");

		$("#btn-close-proposal").click(function(){
			uiCoop.minimizeMenuRoom(false);
		});
		$("#btn-extend-proposal").click(function(){
			uiCoop.maximizeReader(true);
			$("#btn-minimize-proposal").removeClass("hidden");
			$("#btn-extend-proposal").addClass("hidden");
		});
		$("#btn-minimize-proposal").click(function(){
			uiCoop.maximizeReader(false);
			$("#btn-minimize-proposal").addClass("hidden");
			$("#btn-extend-proposal").removeClass("hidden");
		});
	});

</script>