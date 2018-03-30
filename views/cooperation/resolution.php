
<?php 
	$author = Person::getById(@$resolution["creator"]);
	$profilThumbImageUrl = Element::getImgProfil($author, "profilThumbImageUrl", $this->module->assetsUrl);

	$myId = Yii::app()->session["userId"];
	$hasVote = @$resolution["votes"] ? Cooperation::userHasVoted($myId, $resolution["votes"]) : false; 

	$auth = Authorisation::canParticipate(Yii::app()->session['userId'], 
			$resolution["parentType"], $resolution["parentId"]);

	$parentRoom = Room::getById($resolution["idParentRoom"]);

	if(isset(Yii::app()->session['userId'])){
		$me = Element::getByTypeAndId("citoyens", Yii::app()->session['userId']);
		$myRoles = @$me["links"]["memberOf"][@$resolution["parentId"]]["roles"] ? 
				   @$me["links"]["memberOf"][@$resolution["parentId"]]["roles"] : array();
	}else{
		$myRoles = array();
	}	
	
	//lock access if the user doesnt have the good role
	$accessRoom = @$parentRoom ? Room::getAccessByRole($parentRoom, $myRoles) : ""; 
	if($accessRoom == "lock") exit;


	
	$totalVotant = Proposal::getTotalVoters($resolution);
	$voteRes = Proposal::getAllVoteRes($resolution);
?>


<div class="col-lg-8 col-md-7 col-sm-7 pull-left margin-top-15">
	<?php $parentRoom = Room::getById($resolution["idParentRoom"]); ?>
  	<h4 class="letter-turq load-coop-data title-room" 
  		data-type="room" data-dataid="<?php echo @$resolution["idParentRoom"]; ?>">
  		<i class="fa fa-connectdevelop"></i> <i class="fa fa-hashtag"></i> <?php echo @$parentRoom["name"]; ?>
	</h4>
</div>



<div class="col-lg-4 col-md-5 col-sm-5">
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 tooltips" 
				data-original-title="Fermer cette fenêtre" data-placement="bottom"
				id="btn-close-resolution">
		<i class="fa fa-times"></i>
	</button>
	
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 tooltips" 
				data-original-title="<?php echo Yii::t("cooperation","Update datas"); ?>" data-placement="bottom"
				data-id-resolution="<?php echo $resolution["_id"]; ?>"
				id="btn-refresh-resolution"><i class="fa fa-refresh"></i></button>

	<button class="btn btn-default pull-right margin-left-5 margin-top-10 btn-extend-resolution tooltips" 
				data-original-title="<?php echo Yii::t("cooperation","Enlarge reading space"); ?>" data-placement="bottom">
		<i class="fa fa-long-arrow-left"></i>
	</button>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 hidden btn-minimize-resolution tooltips" 
				data-original-title="<?php echo Yii::t("cooperation","Reduce reading space"); ?>" data-placement="bottom">
		<i class="fa fa-long-arrow-right"></i>
	</button>
</div>



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
	<?php if(!@$resolution["answers"]){ ?>
	<h3 class="radius-5 col-xs-12 bg-dark text-white text-bold padding-10 margin-bottom-10"  >	
		<?php if(@$resolution["title"]){ ?>
			<i class="fa fa-hashtag"></i> <?php echo @$resolution["title"]; ?>
		<?php } ?>
	</h3>
	<label class="pull-right">
		<small> <?php echo Yii::t("cooperation","Author"); ?> : </small>
		<img class="img-circle" id="menu-thumb-profil" 
         width="30" height="30" src="<?php echo $profilThumbImageUrl; ?>" alt="image" >
		<a href="#page.type.citoyens.id.<?php echo $resolution["creator"]; ?>" class="lbh">
			<?php echo $author["username"]; ?></a><?php if($myId == $resolution["creator"]){ ?>
		<?php } ?>
	</label>
	<hr>
		<h4 class="">
			<i class="fa fa-bell"></i> 
			<?php echo Yii::t("cooperation", "The <b>resolution</b> is done : "); ?>
			<br class="visible-md">
			<small><?php echo Yii::t("cooperation", "The proposal is"); ?> 
			 	<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && 
			 			$voteRes["up"]["percent"] > @$resolution["majority"] ){ ?>
					<span class="letter-green"><?php echo Yii::t("cooperation", "validated"); ?></span>
				 <?php }else{ ?>
			 	<span class="letter-red"><?php echo Yii::t("cooperation", "refused"); ?></span>
				<?php } ?>
			</small>
		</h4>

		<div class="progress col-lg-7 col-md-10 col-sm-12 col-xs-12 no-padding">
			<?php 
				foreach($voteRes as $key => $value){ 
					if($totalVotant > 0 && $value["percent"] > 0){ 
			?>
					  <div class="progress-bar bg-<?php echo $value["bg-color"]; ?>" role="progressbar" 
					  		style="width:<?php echo $value["percent"]; ?>%">
					    <?php echo $value["percent"]; ?>%
					  </div>
				<?php } ?>
			<?php } ?>

			<?php if($totalVotant == 0){ ?>
					<div class="progress-bar bg-turq" role="progressbar" style="width:100%">
					    <?php echo Yii::t("cooperation", "No vote"); ?>
					  </div>
			<?php } ?>
		</div> 

		<h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<i class="fa fa-balance-scale"></i> <?php echo Yii::t("cooperation", "Rule of majority"); ?> : 
			<b><?php echo @$resolution["majority"]; ?>%</b>
			<hr>
			<button class="btn btn-default btn-sm" id="btn-show-voteres">
				<i class="fa fa-pie-chart"></i> <?php echo Yii::t("cooperation", "Show vote details"); ?>
			</button>
		</h4>

	<?php }else{ ?>
	<?php
		//var_dump($voteRes); exit;
		$winer = 0; $maxV = ""; $nbWiner = 0;
		foreach ($voteRes as $kv => $vote) {
		 	if($vote["percent"] > $maxV){
		 	 	$maxV = $vote["percent"];
		 	 	$winer = "<span class='letter-vote-".$kv."'>#".($kv+1)."</span> ";
		 	 	$nbWiner=1;
		 	}else if($vote["percent"] == $maxV){
		 		$winer .= "<span class='letter-vote-".$kv."'>#".($kv+1)."</span> ";
		 	 	$nbWiner++;
		 	}
		 } 
	?>
		<hr>
		<h4 class="">
			<?php echo Yii::t("cooperation", "Answer"); echo $nbWiner>1?"s":""; ?> 
			<b><?php echo Yii::t("cooperation", "adopted".($nbWiner>1?"s":"")); ?></b> : 
			<b><?php echo $winer; ?></b> 
		</h4>
	<?php } ?>
	<hr>

	<h5>
		<?php if(@$resolution["voteDateEnd"]){ ?>
			<i class='fa fa-clock-o'></i> <?php echo Yii::t("cooperation", "End of vote session"); ?> 
			<?php echo Translate::pastTime($resolution["voteDateEnd"], "date"); ?> · 
			<small class='letter-green'> 
				<?php echo date('d/m/Y H:i e', strtotime($resolution["voteDateEnd"])); ?>
			</small>
		<?php } ?>
		
	</h5>
	
	<div class="hidden podvote">

		<?php 			
			if(@$resolution["answers"]){
				$this->renderPartial('../cooperation/pod/voteMultiple', array("proposal"=>$resolution, 
																		  "hasVote" => $hasVote, 
																		  "auth" => $auth));
			}else{
				$this->renderPartial('../cooperation/pod/vote', array("proposal"=>$resolution, 
																  "hasVote" => $hasVote, 
																  "auth" => $auth));
			}
		?>
	</div>
	<br>		
</div>



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-5">
	
	<div class="padding-25 radius-5 col-xs-12" style="background-color: #eee" >
	
		<div class=" col-xs-12" id="container-text-resolution" style="padding:15px 0px 0px 40px;background-color: #eee" ><?php echo @$resolution["description"]; ?></div>
		
			
		<?php echo nl2br(@$resolution["description"]); ?>


		<?php 
			$i=0;
			if(@$resolution["amendements"]){
				foreach($resolution["amendements"] as $key => $am){
					$allVotes = @$am["votes"] ? $am["votes"] : array();
					$voteRes = Proposal::getAllVoteRes($am);
			 		unset($voteRes["uncomplet"]);
			 		$allVotesRes[$key] = $voteRes;
			 		$validate = @$voteRes["up"] && @$voteRes["up"]["percent"] && $voteRes["up"]["percent"] > @$resolution["majority"];
		?>
		<?php if($validate == true){ $i++; ?>
				<hr>
				<small><b>Amendement n°<?php echo $i; ?></b></small><br>
				<?php echo @$am["textAdd"]; ?>

		<?php } //if ?>

		<?php } //foreach ?>
		<?php } //if($i == 0){ echo "<hr><i class='fa fa-ban'></i> Aucun amendement validé"; } ?>
		
		
	</div>


	<?php if(@$resolution["tags"]){ ?>
		<div class="col-xs-12"  ><br> <b>Tags : </b>
		<?php foreach($resolution["tags"] as $key => $tag){ ?>
			<span class="label label-danger margin-right-15">#<?php echo $tag; ?></span>
		<?php } ?>	
		</div>
	<?php } ?>
		



	<?php if(@$resolution["answers"]){ ?>
		<div class="podvote">
			<?php $this->renderPartial('../cooperation/pod/voteMultiple', array("proposal"=>$resolution, 
																			  "hasVote" => $hasVote, 
																			  "auth" => $auth));
			?>
		</div>
		<br>
	<?php } ?>	


	<?php if(false && @$resolution["arguments"]){ ?>
		<h4 class="margin-top-50"><i class="fa fa-angle-down"></i> 
		<?php echo Yii::t("cooperation", "More informations, arguments, exemples, demonstrations, etc"); ?></h4>
		<div class="col-xs-12" id="container-text-complem" style="background-color: #eee" ><?php echo @$resolution["arguments"]; ?></div>
	<?php } ?>

	
	<?php if(@$resolution["urls"]){ ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		<h4 class="margin-top-25"><i class="fa fa-angle-down"></i> <?php echo Yii::t("cooperation", "External links"); ?></h4>
		<?php foreach($resolution["urls"] as $key => $url){ ?>
			<a href="<?php echo $url; ?>" target="_blank" class="btn btn-default bg-white shadow2 margin-bottom-5">
				<i class="fa fa-external-link"></i> <?php echo $url; ?>
			</a>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if(@$resolution["status"] == "adopted"){ ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		<hr>
		<h4 class="margin-top-25 pull-left">
			<?php if(@$resolution["actions"]){ ?>
				<i class="fa fa-angle-down"></i> <?php echo Yii::t("cooperation", "List of actions linked with this resolution"); ?>
			<?php }else{ ?>
				<i class="fa fa-ban"></i> <?php echo Yii::t("cooperation", "No action for this resolution"); ?>
			<?php } ?>
		</h4>
		<button class="btn btn-default letter-green pull-right margin-top-15 margin-bottom-15 bold" id="btn-create-action">
			<i class="fa fa-plus-circle"></i> <i class="fa fa-ticket"></i> <?php echo Yii::t("cooperation", "Add an action"); ?>
		</button>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<?php if(@$resolution["actions"]){ //echo "<hr>";
				foreach(@$resolution["actions"] as $key => $action){ 
			?>
			<button class="btn btn-default bg-white shadow2 margin-bottom-5 load-coop-data" 
  					data-type="action" data-dataid="<?php echo @$action["_id"]; ?>">
				<i class="fa fa-ticket"></i> <?php echo $action["name"]; ?>
			</button>
		<?php }} ?>
		</div>
	</div>
	<?php } ?>


</div>



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><hr></div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-50 padding-bottom-15">

	<h4 class="text-center">
		<i class="fa fa-balance-scale fa-2x margin-bottom-10"></i>
		<br><?php echo Yii::t("cooperation", "Debat"); ?>
	</h4>
	<hr>

	<?php if($auth){ ?>
	<h4 class="text-center"><?php echo Yii::t("cooperation", "Add an argument"); ?><br><i class="fa fa-angle-down"></i></h4>

	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link bg-green-comment col-md-12 col-sm-12 col-xs-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="up"><i class="fa fa-thumbs-up"></i> <?php echo Yii::t("cooperation", "For"); ?></button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link col-md-12 col-sm-12 col-xs-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval=""><?php echo Yii::t("cooperation", "Neutral"); ?></button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link bg-red-comment col-md-12 col-sm-12 col-xs-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="down"><i class="fa fa-thumbs-down"></i> <?php echo Yii::t("cooperation", "I disagree"); ?></button>
	</div>
	<?php }else{ ?>
	<h5 class="text-center"><?php echo Yii::t("cooperation", "You must be member or contributor to participate"); ?><br><i class="fa fa-angle-down"></i></h5>
	<?php } ?>
</div>




<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-bottom-50" id="comments-container">
	<hr>
</div>

<?php $this->renderPartial('../cooperation/amendements', 
							array("amendements" => @$resolution["amendements"], 
								  "proposal"    => @$resolution,
								  "auth"        => $auth)); ?>

<script type="text/javascript">
	var parentTypeElement = "<?php echo $resolution['parentType']; ?>";
	var parentIdElement = "<?php echo $resolution['parentId']; ?>";
	var idParentResolution = "<?php echo $resolution['_id']; ?>";
	var idParentRoom = "<?php echo $resolution['idParentRoom']; ?>";
	var msgController = "<?php echo @$msgController ? $msgController : ''; ?>";
	var useIdParentResolution = false;

	jQuery(document).ready(function() { 
		$("#container-text-resolution").html(dataHelper.markdownToHtml($("#container-text-resolution").html()) );
		$("#container-text-complem").html(dataHelper.markdownToHtml($("#container-text-complem").html()) );
		uiCoop.initUIResolution();
	});

</script>