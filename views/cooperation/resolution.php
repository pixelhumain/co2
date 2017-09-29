
<?php 
	$author = Person::getById(@$resolution["creator"]);
	$profilThumbImageUrl = Element::getImgProfil($author, "profilThumbImageUrl", $this->module->assetsUrl);

	$myId = Yii::app()->session["userId"];
	$hasVote = @$resolution["votes"] ? Cooperation::userHasVoted($myId, $resolution["votes"]) : false; 

	$auth = Authorisation::canParticipate(Yii::app()->session['userId'], 
			$resolution["parentType"], $resolution["parentId"]);

	$parentRoom = Room::getById($resolution["idParentRoom"]);

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
			<?php echo $author["username"]; ?></a><?php if($myId == $resolution["creator"]){ ?><small>, vous êtes l'auteur de cette proposition </small>
		<?php }else{ ?>
		<small> est l'auteur de cette proposition</small>
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
				data-original-title="Actualiser les données" data-placement="bottom"
				data-id-resolution="<?php echo $resolution["_id"]; ?>"
				id="btn-refresh-resolution"><i class="fa fa-refresh"></i></button>

	<button class="btn btn-default pull-right margin-left-5 margin-top-10 btn-extend-resolution tooltips" 
				data-original-title="Agrandir l'espace de lecture" data-placement="bottom">
		<i class="fa fa-long-arrow-left"></i>
	</button>
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 hidden btn-minimize-resolution tooltips" 
				data-original-title="Réduire l'espace de lecture" data-placement="bottom">
		<i class="fa fa-long-arrow-right"></i>
	</button>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 pull-left">
	<hr>
		<h4 class="no-margin">La <b>résolution</b> suivante a été prise : <br class="visible-md">
			<small>la proposition est 
			 	<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && 
			 			$voteRes["up"]["percent"] > @$resolution["majority"] ){ ?>
					<span class="letter-green">validée</span>
				 <?php }else{ ?>
			 	<span class="letter-red">refusée</span>
				<?php } ?>
			</small>
		</h4>

		<div class="progress col-lg-7 col-md-10 col-sm-12 no-padding">
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
					    Aucun vote
					  </div>
			<?php } ?>
		</div> 

		<h4 class="col-lg-12 col-md-12 col-sm-12 no-padding">
			<i class="fa fa-balance-scale"></i> Règle de majorité : <b><?php echo @$resolution["majority"]; ?>%</b>
			<hr>
			<button class="btn btn-default btn-sm" id="btn-show-voteres">
				<i class="fa fa-pie-chart"></i> Afficher les détails du vote
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



<div class="col-lg-12 col-md-12 col-sm-12 margin-top-5">
	
	<div class="padding-25 bg-lightblue radius-5" id="container-text-resolution">
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
		<h4 class="margin-top-50"><i class="fa fa-angle-down"></i> Compléments d'informations, argumentations, exemples, démonstrations, etc</h4>
		<?php echo nl2br(@$resolution["arguments"]); ?>
	<?php } ?>

	
	<?php if(@$resolution["urls"]){ ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		<h4 class="margin-top-25"><i class="fa fa-angle-down"></i> Liens externes</h4>
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
				<i class="fa fa-angle-down"></i> Liste des actions liées à cette résolution
			<?php }else{ ?>
				<i class="fa fa-ban"></i> Aucune action liée à cette résolution
			<?php } ?>
		</h4>
		<button class="btn btn-default letter-green pull-right margin-top-15 bold" id="btn-create-action">
			<i class="fa fa-plus-circle"></i> <i class="fa fa-ticket"></i> Ajouter une action
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



<div class="col-lg-12 col-md-12 col-sm-12"><hr></div>


<div class="col-lg-12 col-md-12 col-sm-12 margin-top-50 padding-bottom-15">

	<h4 class="text-center"><i class="fa fa-balance-scale fa-2x margin-bottom-10"></i><br>Débat</h4><hr>
	<?php if($auth){ ?>
	<h4 class="text-center">Ajouter un argument<br><i class="fa fa-angle-down"></i></h4>

	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="btn btn-link bg-green-comment col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="up">Pour</button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="btn btn-link col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="">Neutre</button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="btn btn-link bg-red-comment col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="down">Contre</button>
	</div>
	<?php }else{ ?>
	<h5 class="text-center">Devenez membre ou contributeur pour participer au débat<br><i class="fa fa-angle-down"></i></h5>
	<?php } ?>

</div>



<div class="col-lg-12 col-md-12 col-sm-12 padding-bottom-50" id="comments-container">
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
		
		$("#comments-container").html("<i class='fa fa-spin fa-refresh'></i> Chargement des commentaires");
		
		getAjax("#comments-container",baseUrl+"/"+moduleId+"/comment/index/type/resolutions/id/"+idParentResolution,
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
				$(".container-txtarea").hide();

				$(".btn-select-arg-comment").click(function(){
					var argval = $(this).data("argval");
					$(".container-txtarea").show();

					$(".textarea-new-comment").removeClass("bg-green-comment bg-red-comment");
					var classe="";
					var pholder="Votre commentaire";
					if(argval == "up")   { classe="bg-green-comment"; pholder="Votre argument pour";   }
					if(argval == "down") { classe="bg-red-comment";   pholder="Votre argument contre"; }
					$(".textarea-new-comment").addClass(classe).attr("placeholder", pholder);
					$("#argval").val(argval);
				});
		},"html");

		$("#btn-close-resolution").click(function(){
			uiCoop.minimizeMenuRoom(false);
		});
		$(".btn-extend-resolution").click(function(){
			uiCoop.maximizeReader(true);
			$(".btn-minimize-resolution").removeClass("hidden");
			$(".btn-extend-resolution").addClass("hidden");
		});
		$(".btn-minimize-resolution").click(function(){
			uiCoop.maximizeReader(false);
			$(".btn-minimize-resolution").addClass("hidden");
			$(".btn-extend-resolution").removeClass("hidden");
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
			uiCoop.sendVote("resolution", idParentResolution, voteValue, idParentRoom);
		});
		$("#btn-activate-vote").click(function(){
			uiCoop.activateVote(idParentResolution);
		});

		$("#btn-refresh-resolution").click(function(){
			toastr.info(trad["processing"]);
			var idresolution = $(this).data("id-resolution");
			uiCoop.getCoopData(null, null, "resolution", null, idresolution, 
				function(){
					uiCoop.minimizeMenuRoom(true);
					uiCoop.showAmendement(false);
					toastr.success(trad["processing ok"]);
				}, false);
		});

		$("#btn-refresh-amendement").click(function(){
			toastr.info(trad["processing"]);
			var idresolution = $(this).data("id-resolution");
			uiCoop.getCoopData(null, null, "resolution", null, idresolution, 
				function(){
					uiCoop.minimizeMenuRoom(true);
					uiCoop.showAmendement(true);
					toastr.success(trad["processing ok"]);
				}, false);
		});

		$(".btn-option-status-resolution").click(function(){
			var idresolution = $(this).data("id-resolution");
			var status = $(this).data("status");
			uiCoop.changeStatus("resolutions", idresolution, status, parentTypeElement, parentIdElement);
		});

		$("#btn-show-voteres").click(function(){
			if($(".podvote").hasClass("hidden")) $(".podvote").removeClass("hidden");
			else $(".podvote").addClass("hidden");
		});

		$("#btn-create-action").click(function(){
			useIdParentResolution = true;
			dyFObj.openForm('action');
		});

		location.hash = "#page.type." + parentTypeElement + ".id." + parentIdElement + 
							  ".view.coop.room." + idParentRoom + ".resolution." + idParentResolution;
		
		if(msgController != ""){
			toastr.error(msgController);
		}
	});

</script>