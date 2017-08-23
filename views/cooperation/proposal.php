<?php 
	$author = Person::getById(@$proposal["creator"]);
	$profilThumbImageUrl = Element::getImgProfil($author, "profilThumbImageUrl", $this->module->assetsUrl);

	$myId = Yii::app()->session["userId"];
	$hasVote = @$proposal["votes"] ? Cooperation::userHasVoted($myId, $proposal["votes"]) : false; 
	$auth = Authorisation::canEditItem(Yii::app()->session['userId'], $proposal["parentType"], $proposal["parentId"]);

	$parentRoom = Room::getById($proposal["idParentRoom"]);
	//echo $parentRoom['name'];
?>

<div class="col-lg-5 col-md-5 col-sm-5 pull-left margin-top-15">
	<?php if(@$post["status"]) {
  		$parentRoom = Room::getById($proposal["idParentRoom"]);
  	?>
  	<h4 class="elipsis letter-turq">
		<i class="fa fa-connectdevelop"></i> <?php echo @$parentRoom["name"]; ?>
	</h4>
	<br>
  	<?php  } ?>

	<label class=""><i class="fa fa-bell"></i> Status : 
		<small class="text-light">
			<?php echo Yii::t("cooperation", $proposal["status"]); ?>
		</small>
	</label>
</div>


<div class="col-lg-7 col-md-7 col-sm-7 no-padding">
	<button class="btn btn-default pull-right margin-left-5 margin-top-10" id="btn-close-proposal">
		<i class="fa fa-times"></i>
	</button>
	<?php if($auth){ ?>
		<button class="btn btn-default pull-right margin-left-5 margin-top-10">
			<i class="fa fa-cog"></i> options
		</button>
	<?php } ?>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 btn-extend-proposal">
		<i class="fa fa-long-arrow-left"></i>
	</button>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 hidden" id="btn-minimize-proposal">
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
		<hr>
		<h6 class="pull-left">
			<?php echo @$proposal["voteDateEnd"] ? 
					"<i class='fa fa-clock-o'></i> Vote ouvert jusqu'au <span class='letter-green'>".$proposal["voteDateEnd"]."</span> · ".
					Yii::t("cooperation", "end") ." ". 
		  				Translate::pastTime($proposal["voteDateEnd"], "datefr")
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
		<!-- <h6>
			<?php echo @$proposal["amendementDateEnd"] ? "Fin des amendements : ".$proposal["amendementDateEnd"] : ""; ?>
		</h6> -->
		<hr>
		<h5 class="text-purple no-margin">
			<i class="fa fa-pencil"></i> Proposition soumise aux amendements 
			<small class="text-purple">jusqu'au <?php echo @$proposal["amendementDateEnd"]; ?></small>
		</h5>
		<small>Vous pouvez proposer des amendements et voter les amendements proposés par les autres utilisateurs</small>
		<hr>
		<?php //if($proposal["creator"] == $myId){ ?>
			<!-- <button class="btn btn-link letter-green letter-white radius-5" id="btn-activate-vote">
				<i class="fa fa-check-circle"></i> Activer les votes
			</button> -->
		<?php //} ?>
		<?php if($auth){ ?>
			<button class="btn btn-link text-purple radius-5 btn-create-amendement">
				<i class="fa fa-pencil"></i> Proposer un amendement
			</button>
		<?php } ?>
			<button class="btn btn-link text-purple radius-5 btn-show-amendement">
				Afficher les amendements <i class="fa fa-chevron-right"></i>
			</button>
			
	<?php } ?>

</div>

<?php 
	if(@$proposal["voteActivated"] == "true" && @$proposal["status"] == "tovote") 
		$this->renderPartial('../cooperation/pod/vote', array("proposal"=>$proposal));
?>

<div class="col-lg-12 col-md-12 col-sm-12">
	<hr>
</div>
<div class="col-lg-10 col-md-12 col-sm-12">
	<h3><i class="fa fa-hashtag"></i> <?php echo $proposal["title"]; ?></h3>
</div>

<div class="col-lg-10 col-md-12 col-sm-12 margin-top-25">
	<?php echo nl2br($proposal["description"]); ?>
	
	<?php if(@$proposal["arguments"]){ ?>
		<hr>
		<h6 class=""><i class="fa fa-angle-down"></i> Compléments d'informations, argumentations, exemples, démonstrations, etc</h6>
		<?php echo nl2br(@$proposal["arguments"]); ?>
	<?php } ?>

	<?php if(@$proposal["tags"]){ ?>
		<hr>
		<?php foreach($proposal["tags"] as $key => $tag){ ?>
			<span class="badge bg-red"><?php echo $tag; ?></span>
		<?php } ?>	
	<?php } ?>

	<?php if(@$proposal["urls"]){ ?>
		<hr>	
		<h6 class=""><i class="fa fa-angle-down"></i> Liens externes</h6>
		<?php foreach($proposal["urls"] as $key => $url){ ?>
			<a href="<?php echo $url; ?>" class="btn btn-link"><?php echo $url; ?></a>
		<?php } ?>
	<?php } ?>
	<hr>	
</div>


<?php if(@$proposal["status"] == "tovote"){ ?>
<div class="col-lg-12 col-md-12 col-sm-12 margin-top-15">
	<h4 class="pull-left"><i class="fa fa-angle-down"></i> Liste des amendements validés</h4>
	<button class="btn btn-default pull-right btn-extend-proposal"><i class="fa fa-long-arrow-left"></i></button>
	<button class="btn btn-default pull-right btn-minimize-proposal hidden"><i class="fa fa-long-arrow-right"></i></button>
	<div class="col-lg-12 col-md-12 col-sm-12"><i class="fa fa-ban"></i> Aucun amendement validé</div>
</div>
<?php } ?>

<div class="col-lg-12 col-md-12 col-sm-12 margin-top-25">
	<h4 class="pull-left"><i class="fa fa-angle-down"></i> Débat</h4>
	<button class="btn btn-default pull-right btn-extend-proposal"><i class="fa fa-long-arrow-left"></i></button>
	<button class="btn btn-default pull-right btn-minimize-proposal hidden"><i class="fa fa-long-arrow-right"></i></button>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 margin-top-25" id="comments-container">
	
</div>

<?php $this->renderPartial('../cooperation/amendements', array("amendements"=>@$proposal["amendements"])); ?>

<script type="text/javascript">
	var idParentProposal = "<?php echo $proposal['_id'] ?>";
	var idParentRoom = "<?php echo $proposal['idParentRoom'] ?>";
	jQuery(document).ready(function() { 
		$("#comments-container").html("<i class='fa fa-spin fa-refresh'></i> Chargement des commentaires");
		getAjax("#comments-container",baseUrl+"/"+moduleId+"/comment/index/type/proposals/id/"+idParentProposal,
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
		},"html");

		$("#btn-close-proposal").click(function(){
			uiCoop.minimizeMenuRoom(false);
		});
		$(".btn-extend-proposal").click(function(){
			uiCoop.maximizeReader(true);
			$(".btn-minimize-proposal").removeClass("hidden");
			$(".btn-extend-proposal").addClass("hidden");
		});
		$(".btn-minimize-proposal").click(function(){
			uiCoop.maximizeReader(false);
			$(".btn-minimize-proposal").addClass("hidden");
			$(".btn-extend-proposal").removeClass("hidden");
		});
		$(".btn-show-amendement").click(function(){
			uiCoop.showAmendement(true);
		});
		$("#btn-hide-amendement").click(function(){
			uiCoop.showAmendement(false);
		});
		$(".btn-create-amendement").click(function(){
			uiCoop.showAmendement(true);
			if($("#form-amendement").hasClass("hidden"))
				$("#form-amendement").removeClass("hidden");
			else 
				$("#form-amendement").addClass("hidden");
		});

		$(".btn-send-vote").click(function(){
			var voteValue = $(this).data('vote-value');
			console.log("send vote", voteValue),
			uiCoop.sendVote("proposal", idParentProposal, voteValue, idParentRoom);
		});
		$("#btn-activate-vote").click(function(){
			uiCoop.activateVote(idParentProposal);
		});
	});

</script>