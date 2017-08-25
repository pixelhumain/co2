<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow2 margin-top-15 padding-15 podVoteAmendement">
	
	<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 pull-left no-padding">
		<!-- <img src="<?php echo $this->module->assetsUrl.'/images/thumbnail-default.jpg'; ?>" 
			 class="img-circle pull-left margin-right-10" height="30" width="30">
		<label class="pull-left margin-top-5"><?php echo @$author["username"]; ?></label> -->
		
		<label class="pull-left"><span class="badge bg-purple">n°<?php echo $key; ?></span> <span class="letter-green">
			<i class="fa fa-angle-right"></i> Ajout</span>
		</label>

		<?php if($hasVoted!=false){ ?>
			<h5 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-10 no-padding">
				Vous avez voté 
				<span class="letter-<?php echo Cooperation::getColorVoted($hasVoted); ?>">
					<?php echo Yii::t("cooperation", $hasVoted); ?>
				</span><br>
				<small class="text-dark">Vous pouvez changer votre choix à tout moment</small>
			</h5>
		<?php }else{ ?>
			<h5 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-10 no-padding">
				<?php if($auth){ ?>
					Vous n'avez pas voté<br>
					<small class="text-dark">
						Le vote estouvert jusqu'au : 
						<?php echo date('d/m/Y H:i e', strtotime($proposal["amendementDateEnd"])); ?>
					</small>
				<?php }else{ ?>
					<small class="text-dark">
						Vous ne pouvez pas voter
					</small>
				<?php } ?>
			</h5>
		<?php } ?>

	</div>

	<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2 pull-right">
		<canvas class="" id="res-vote-chart-<?php echo $key; ?>" width="50%" height="50px"/>
	</div>
	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 no-padding textAmdt">
		<hr>
		<?php echo @$am["textAdd"]; ?>
	</div>


	<div class="col-lg-12 col-md-12 col-sm-12 pull-left padding-15">
		<hr>
		<small>
			<i class="fa fa-2x fa-balance-scale"></i> Majorité : <b><?php echo @$proposal["majority"]; ?>%</b> 
			<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && $voteRes["up"]["percent"] > @$proposal["majority"] ){ ?>
				 <span class="pull-right badge bg-green-k margin-top-5 padding-5">Amendement temporairement <span class="bold">Validée</span></span>
			<?php }else{ ?>
				 <span class="pull-right badge bg-red margin-top-5 padding-5">Amendement temporairement <span class="bold">refusé</span></span>
			<?php } ?>
		</small>
		
	</div>


	<?php 
 		foreach ($voteRes as $keyV => $value) {  //var_dump($auth);
 	?>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center pull-left margin-top-5 padding-5">
		<?php if(@$proposal["status"] == "amendable" && $auth){ ?>
			<button class="btn btn-link btn-sm bg-<?php echo $value["bg-color"]; ?> btn-send-vote-amendement 
							tooltips col-lg-12 col-md-12 col-sm-12 col-xs-12"
					data-vote-id-amdt="<?php echo @$key; ?>" 
					data-vote-value="<?php echo $value["voteValue"]; ?>" 
					data-original-title="cliquer pour voter" data-placement="bottom">
					<?php echo Yii::t("cooperation", $keyV); ?> (<?php echo $value["percent"]; ?>%)
			</button>
		<?php }else{ ?>
			<label class="badge padding-10 bg-<?php echo $value["bg-color"]; ?> col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php echo Yii::t("cooperation", $keyV); ?> (<?php echo $value["percent"]; ?>%)
			</label>
		<?php } ?>			
	</div>

	<?php } ?>

	
</div>