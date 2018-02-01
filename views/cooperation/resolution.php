
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
	<br>

	<label>
		<img class="img-circle" id="menu-thumb-profil" 
         width="30" height="30" src="<?php echo $profilThumbImageUrl; ?>" alt="image" >
		<a href="#page.type.citoyens.id.<?php echo $resolution["creator"]; ?>" class="lbh">
			<?php echo $author["username"]; ?></a><?php if($myId == $resolution["creator"]){ ?><small>, 
			<?php echo Yii::t("cooperation","your are the author of this proposal"); ?> </small>
		<?php }else{ ?>
		<small> <?php echo Yii::t("cooperation","is the author of this proposal"); ?></small>
		<?php } ?>
	</label>
  	
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

		<br>
		
		<div class="hidden podvote">
			<?php 
				$this->renderPartial('../cooperation/pod/vote', array("proposal"=>$resolution, 
																	  "hasVote" => $hasVote, 
																	  "auth" => $auth));
			?>
		</div>
		<br>		
</div>



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-5">
	
	<div class="padding-25 bg-lightblue radius-5 col-xs-12" id="container-text-resolution">
		<?php if(@$resolution["title"]){ ?>
				<h3><i class="fa fa-hashtag"></i> <?php echo @$resolution["title"]; ?></h3>
		<?php }else{ ?>
				<br>
		<?php } ?>

		<?php if(@$resolution["description"]){
				$resolution["description"] = Translate::strToClickable($resolution["description"]);
		} ?>
			
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

		<?php if(@$resolution["tags"]){ ?>
			<br><br> <b>Tags : </b>
			<?php foreach($resolution["tags"] as $key => $tag){ ?>
				<span class="letter-red margin-right-15">#<?php echo $tag; ?></span>
			<?php } ?>	
			
		<?php } ?>
	</div>

	<?php if(false && @$resolution["arguments"]){ ?>
		<h4 class="margin-top-50"><i class="fa fa-angle-down"></i> 
		<?php echo Yii::t("cooperation", "More informations, arguments, exemples, demonstrations, etc"); ?></h4>
		<?php echo nl2br(@$resolution["arguments"]); ?>
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
							array("amendements"=>@$resolution["amendements"], 
								  "proposal"=>@$resolution,
								  "auth"=>$auth)); ?>

<script type="text/javascript">
	var parentTypeElement = "<?php echo $resolution['parentType']; ?>";
	var parentIdElement = "<?php echo $resolution['parentId']; ?>";
	var idParentResolution = "<?php echo $resolution['_id']; ?>";
	var idParentRoom = "<?php echo $resolution['idParentRoom']; ?>";
	var msgController = "<?php echo @$msgController ? $msgController : ''; ?>";
	var useIdParentResolution = false;

	jQuery(document).ready(function() { 
		uiCoop.initUIResolution();
	});

</script>