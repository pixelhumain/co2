<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow2 margin-top-15 padding-15 podVoteAmendement">
	
	<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 pull-left no-padding">
		<!-- <img src="<?php echo $this->module->assetsUrl.'/images/thumbnail-default.jpg'; ?>" 
			 class="img-circle pull-left margin-right-10" height="30" width="30">
		<label class="pull-left margin-top-5"><?php echo @$author["username"]; ?></label> -->
		
		<label class="pull-left"><span class="badge bg-purple">n°<?php echo $key; ?></span> <span class="letter-green">
			<i class="fa fa-angle-right"></i> Ajout</span>
		</label>

		<?php if($hasVoted!=false){ ?>
			<h6 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-10 no-padding">
				Vous avez voté 
				<span class="letter-<?php echo Cooperation::getColorVoted($hasVoted); ?>">
					<?php echo Yii::t("cooperation", $hasVoted); ?>
				</span>
			</h6>
		<?php }else{ ?>
			<h6 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-10 no-padding">
				Vous n'avez pas voté
			</h6>
		<?php } ?>

	</div>

	<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2 pull-right">
		<canvas class="" id="res-vote-chart-<?php echo $key; ?>" width="100%" height="100px"/>
	</div>
	
	<div class="col-lg-10 col-md-9 col-sm-9 col-xs-10 no-padding textAmdt">
		<hr>
		<?php echo @$am["textAdd"]; ?>
	</div>
	<?php 
 		foreach ($voteRes as $keyV => $value) { 
 	?>

	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center pull-left margin-top-5 padding-5">
			<button class="btn btn-link btn-sm bg-<?php echo $value["bg-color"]; ?> btn-send-vote-amendement 
							tooltips col-lg-12 col-md-12 col-sm-12 col-xs-12"
					data-vote-id-amdt="<?php echo @$key; ?>" 
					data-vote-value="<?php echo $value["voteValue"]; ?>" 
					data-original-title="cliquer pour voter" data-placement="bottom">
					<?php echo Yii::t("cooperation", $keyV); ?> (<?php echo $value["percent"]; ?>%)
			</button>			
	</div>

	<?php } ?>

	
</div>