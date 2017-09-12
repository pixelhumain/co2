<?php 
	$author = Person::getById(@$proposal["creator"]);
	$profilThumbImageUrl = Element::getImgProfil($author, "profilThumbImageUrl", $this->module->assetsUrl);

	$myId = Yii::app()->session["userId"];
	$hasVote = @$proposal["votes"] ? Cooperation::userHasVoted($myId, $proposal["votes"]) : false; 
	$auth = Authorisation::canParticipate(Yii::app()->session['userId'], $proposal["parentType"], $proposal["parentId"]);
	
	$parentRoom = Room::getById($proposal["idParentRoom"]);
?>

<div class="col-lg-7 col-md-6 col-sm-6 pull-left margin-top-15">
	<?php if(@$post["status"]) {
  		$parentRoom = Room::getById($proposal["idParentRoom"]);
  	?>
  	<h4 class="letter-turq">
  		<i class="fa fa-connectdevelop"></i> <?php echo @$parentRoom["name"]; ?>
	</h4>
	<br>
  	<?php  } ?>

	<label class=""><i class="fa fa-bell"></i> Status : 
		<small class="letter-<?php echo Cooperation::getColorCoop($proposal["status"]); ?>">
			<?php echo Yii::t("cooperation", $proposal["status"]); ?>
		</small>
	</label>

</div>


<div class="col-lg-5 col-md-6 col-sm-6 no-padding">
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 tooltips" 
				data-original-title="Fermer cette fenêtre" data-placement="bottom"
				id="btn-close-proposal">
		<i class="fa fa-times"></i>
	</button>
	<?php if($auth && @$proposal["creator"] == Yii::app()->session['userId']){ ?>
		 <div class="pull-right dropdown">
		  <button class="btn btn-default margin-left-5 margin-top-10" data-toggle="dropdown">
			<i class="fa fa-cog"></i> options
		  </button>
		  <ul class="dropdown-menu">
		  	<?php if(!@$proposal["amendements"] && !$hasVote){ ?>
		    <li><a href="javascript:" id="btn-edit-proposal" 
		    		data-id-proposal="<?php echo $proposal["_id"]; ?>"
		    		data-status="archived">
		    	<i class="fa fa-pencil"></i> Modifier ma proposition
		    	</a>
		    </li>
			<?php }else{ ?>
			<li><button class="btn btn-link tooltips" disabled="true" style="width: 100%;"
				data-original-title="Modifications désactivées : <?php if(@$proposal["amendements"]) echo 'les amendements ont commencé'; else if($hasVote) echo 'les votes ont commencé'; ?>" data-placement="left">
		    	<i class="fa fa-pencil"></i> Modifier ma proposition
		    	</button>
		    </li>
			<?php } ?>
		    <li><a href="javascript:" class="btn-option-status-proposal" 
		    		data-id-proposal="<?php echo $proposal["_id"]; ?>"
		    		data-status="archived">
		    	<i class="fa fa-trash"></i> Archiver ma proposition
		    	</a>
		    </li>
		    <!-- <li><hr class="margin-5"></li> -->
		    <li><a href="javascript:" class="btn-option-status-proposal" 
		    		data-id-proposal="<?php echo $proposal["_id"]; ?>"
		    		data-status="closed">
		    		<i class="fa fa-times"></i> Fermer ma proposition
		    	</a>
		    </li>
		  </ul>
		</div> 
	<?php } ?>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 tooltips" 
				data-original-title="Actualiser les données" data-placement="bottom"
				data-id-proposal="<?php echo $proposal["_id"]; ?>"
				id="btn-refresh-proposal"><i class="fa fa-refresh"></i></button>

	<button class="btn btn-default pull-right margin-left-5 margin-top-10 btn-extend-proposal tooltips" 
				data-original-title="Agrandir l'espace de lecture" data-placement="bottom">
		<i class="fa fa-long-arrow-left"></i>
	</button>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 hidden btn-minimize-proposal tooltips" 
				data-original-title="Réduire l'espace de lecture" data-placement="bottom">
		<i class="fa fa-long-arrow-right"></i>
	</button>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 pull-left margin-top-10" style="padding-left: 8px;">

	<label>
		<img class="img-circle" id="menu-thumb-profil" 
         width="30" height="30" src="<?php echo $profilThumbImageUrl; ?>" alt="image" >
		<a href="#page.type.citoyens.id.<?php echo $proposal["creator"]; ?>" class="lbh">
			<?php echo $author["username"]; ?></a><?php if($myId == $proposal["creator"]){ ?><small>, vous êtes l'auteur de cette proposition </small>
		<?php }else{ ?>
		<small> est l'auteur de cette proposition</small>
		<?php } ?>
	</label>

	<?php if(@$proposal["status"] == "tovote"){ ?>
		<button class="btn btn-link text-purple radius-5 btn-show-amendement pull-right">
			Afficher les amendements (<?php echo count(@$proposal["amendements"]); ?>) <i class="fa fa-chevron-right"></i>
		</button>
		<hr>
		<h6 class="pull-left">
			<?php echo @$proposal["voteDateEnd"] ? 
					"<i class='fa fa-clock-o'></i> Vote ouvert jusqu'au <span class='letter-green'>".
					date('d/m/Y H:i e', strtotime($proposal["voteDateEnd"])).
					"</span> · ".
					Yii::t("cooperation", "end") ." ". 
		  				Translate::pastTime($proposal["voteDateEnd"], "date")
					: "Vote ouvert jusqu'à une date non-définie"; ?>
		</h6>
		<?php if($hasVote!=false){ ?>
			<h5 class="pull-right">Vous avez voté 
				<span class="letter-<?php echo Cooperation::getColorVoted($hasVote); ?>">
					<?php echo Yii::t("cooperation", $hasVote); ?>
				</span>
			</h5>
		<?php }else{ ?>
			<h5 class="letter-red pull-right">Vous n'avez pas voté</h5>
		<?php } ?>
	<?php }else if(@$proposal["status"] == "amendable"){ ?>
		<hr>
		<h4 class="text-purple no-margin">
			<i class="fa fa-pencil"></i> Proposition soumise aux amendements 
			<small class="text-purple">jusqu'au 
				<?php echo date('d/m/Y H:i e', strtotime($proposal["amendementDateEnd"])); ?>
				<br><i class="fa fa-angle-right"></i> Fin des amendements et ouverture des votes <?php echo Translate::pastTime($proposal["amendementDateEnd"], "date"); ?>
			</small>
		</h4>
		<small>Vous pouvez proposer des amendements et voter les amendements proposés par les autres utilisateurs</small>
		<hr>
		
		<?php if($auth){ ?>
			<button class="btn btn-link text-purple radius-5 btn-create-amendement">
				<i class="fa fa-pencil"></i> Proposer un amendement
			</button>
		<?php } ?>
		<button class="btn btn-link text-purple radius-5 btn-show-amendement">
			Afficher les amendements (<?php echo count(@$proposal["amendements"]); ?>) <i class="fa fa-chevron-right"></i>
		</button>
		<hr>
	<?php }else if(@$proposal["status"] == "closed" || @$proposal["status"] == "archived"){ ?>
		<button class="btn btn-link text-purple radius-5 btn-show-amendement pull-right">
			Afficher les amendements (<?php echo count(@$proposal["amendements"]); ?>) <i class="fa fa-chevron-right"></i>
		</button>
		<hr>
		<h5 class="no-margin"><span class="text-red">La session de vote est terminée</span> 
			<?php //echo " · ".Yii::t("cooperation", "end")." ".Translate::pastTime($proposal["voteDateEnd"], "date"); ?>
		</h5>
		<br>
	<?php } ?>

</div>

<?php 
	if(@$proposal["status"] != "amendable") 
		$this->renderPartial('../cooperation/pod/vote', array("proposal"=>$proposal, "auth" => $auth));
?>

<div class="col-lg-12 col-md-12 col-sm-12 margin-top-5">
	
	<div class="padding-25 bg-lightblue radius-5" id="container-text-proposal" 
		 style="padding-top:5px !important; color:#2C3E50 !important">
			
			<?php if(@$proposal["title"]){ ?>
				<h3><i class="fa fa-hashtag"></i> <?php echo @$proposal["title"]; ?></h3>
			<?php }else{ ?>
				<h3><i class="fa fa-angle-down"></i> Proposition</h3>
			<?php } ?>
		
			<?php echo nl2br(@$proposal["description"]); ?>
	</div>

	<?php //if(@$proposal["status"] != "tovote"){ ?>
		<div class="col-lg-12 col-md-12 col-sm-12 margin-top-15 no-padding">
			<!-- <hr>	 -->
			<h4 class="pull-left">
				<i class="fa fa-angle-down"></i> Liste des amendements validés · 
				<small>
					<i class="fa fa-balance-scale"></i> Majorité : <b><?php echo @$proposal["majority"]; ?>%</b> 
				</small>
			</h4>
			<button class="btn btn-default pull-right btn-extend-proposal">
				<i class="fa fa-long-arrow-left"></i>
			</button>
			<button class="btn btn-default pull-right btn-minimize-proposal hidden">
				<i class="fa fa-long-arrow-right"></i>
			</button>
			<div class="col-lg-12 col-md-12 col-sm-12 no-padding">
				<?php 
					$i=0;
					if(@$proposal["amendements"]){
						foreach($proposal["amendements"] as $key => $am){ $i++;
							//var_dump($am); //exit;
							$author = Person::getSimpleUserById(@$am["idUserAuthor"]);
							$allVotes = @$am["votes"] ? $am["votes"] : array();
							$myId = Yii::app()->session["userId"];
							$hasVoted = Cooperation::userHasVoted($myId, $allVotes);
					 		$voteRes = Proposal::getAllVoteRes($am);
					 		unset($voteRes["uncomplet"]);
					 		$allVotesRes[$key] = $voteRes;
					 		$validate = @$voteRes["up"] && @$voteRes["up"]["percent"] && $voteRes["up"]["percent"] > @$proposal["majority"];
				?>
				<?php if($validate == true){ ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow2 margin-top-15 padding-15 podVoteAmendement">
				
						<label class="pull-left"><span class="badge bg-purple">n°<?php echo $key; ?></span> <span class="letter-green">
							<i class="fa fa-angle-right"></i> Ajout</span>
						</label>
						
						<!-- <span class="pull-right badge bg-green-k padding-5">Amendement <span class="bold">Validée</span></span> -->
								

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 margin-top-5 no-padding textAmdt">
							<hr>
							<?php echo @$am["textAdd"]; ?>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding progress <?php if($proposal["status"] != "tovote") echo "hidden-min"; ?>">
				  	  		<?php 
				  	  			$voteRes = Proposal::getAllVoteRes($am);
				  	  			$totalVotant = Proposal::getTotalVoters($am);
					  	  		foreach($voteRes as $key => $value){ 
					  	  	?>
								  <div class="progress-bar bg-<?php echo $value["bg-color"]; ?>" role="progressbar" 
								  		style="width:<?php echo $value["percent"]; ?>%">
								    <?php echo $value["percent"]; ?>%
								  </div>
							<?php } ?>

						</div> 

					</div>
				<?php } //if ?>

				<?php } //foreach ?>
				<?php } if($i == 0){ echo "<i class='fa fa-ban'></i> Aucun amendement validé"; } ?>
			</div>
		</div>
		<?php //} ?>

	<?php if(@$proposal["arguments"]){ ?>
		<hr>
		<h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-50 no-padding"><i class="fa fa-angle-down"></i> Compléments d'informations, argumentations, exemples, démonstrations, etc</h4>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<?php echo nl2br(@$proposal["arguments"]); ?>
		</div>
	<?php } ?>

	<?php if(@$proposal["tags"]){ ?>
		<hr>
		<?php foreach($proposal["tags"] as $key => $tag){ ?>
			<span class="badge bg-red"><?php echo $tag; ?></span>
		<?php } ?>	
	<?php } ?>

	<?php if(@$proposal["urls"]){ ?>
		<hr>	
		<h4 class=""><i class="fa fa-angle-down"></i> Liens externes</h4>
		<?php foreach($proposal["urls"] as $key => $url){ ?>
			<a href="<?php echo $url; ?>" class="btn btn-link"><?php echo $url; ?></a>
		<?php } ?>
	<?php } ?>
</div>



<div class="col-lg-12 col-md-12 col-sm-12"><hr></div>


<div class="col-lg-12 col-md-12 col-sm-12 margin-top-50 padding-bottom-15">

	<h4 class="text-center"><i class="fa fa-balance-scale fa-2x margin-bottom-10"></i><br>Débat</h4><hr>

	<?php if($auth){ ?>
	<h4 class="text-center">Ajouter un argument<br><i class="fa fa-angle-down"></i></h4>

	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link bg-green-comment col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="up"><i class="fa fa-thumbs-up"></i> Pour</button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="">Neutre</button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link bg-red-comment col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="down"><i class="fa fa-thumbs-down"></i> Contre</button>
	</div>
	<?php }else{ ?>
	<h5 class="text-center">Devenez membre ou contributeur pour participer au débat<br><i class="fa fa-angle-down"></i></h5>
	<?php } ?>
</div>



<div class="col-lg-12 col-md-12 col-sm-12 margin-bottom-50" id="comments-container">
<hr>
</div>

<?php $this->renderPartial('../cooperation/amendements', 
							array("amendements"=>@$proposal["amendements"], 
								  "proposal"=>@$proposal,
								  "auth"=>$auth)); ?>

<script type="text/javascript">
	var parentTypeElement = "<?php echo $proposal['parentType']; ?>";
	var parentIdElement = "<?php echo $proposal['parentId']; ?>";
	var idParentProposal = "<?php echo $proposal['_id']; ?>";
	var idParentRoom = "<?php echo $proposal['idParentRoom']; ?>";
	var msgController = "<?php echo @$msgController ? $msgController : ''; ?>";
	jQuery(document).ready(function() { 
		
		uiCoop.initUIProposal();
	});

</script>