<style>
	.majority-space{
		display: none;
	}
</style>

<?php 
	$author = Person::getById(@$resolution["creator"]);
	$profilThumbImageUrl = Element::getImgProfil($author, "profilThumbImageUrl", $this->module->assetsUrl);

	$myId = Yii::app()->session["userId"];
	$hasVote = @$resolution["votes"] ? Cooperation::userHasVoted($myId, $resolution["votes"]) : false; 
	$auth = Authorisation::canEditItem(Yii::app()->session['userId'], $resolution["parentType"], $resolution["parentId"]);

	$parentRoom = Room::getById($resolution["idParentRoom"]);

	$voteRes = Proposal::getAllVoteRes($resolution);
?>

<div class="col-lg-7 col-md-6 col-sm-6 pull-left margin-top-15">
	<?php if(@$post["status"]) {
  		$parentRoom = Room::getById($resolution["idParentRoom"]);
  	?>
  	<h4 class="letter-turq">
  		<i class="fa fa-connectdevelop"></i> <?php echo @$parentRoom["name"]; ?>
	</h4>
	<br>
  	<?php  } ?>

  	<label>
		<img class="img-circle" id="menu-thumb-profil" 
         width="30" height="30" src="<?php echo $profilThumbImageUrl; ?>" alt="image" >
		<a href="#page.type.citoyens.id.<?php echo $resolution["creator"]; ?>" class="lbh">
			<?php echo $author["username"]; ?></a><?php if($myId == $resolution["creator"]){ ?><small>, vous êtes l'auteur de cette proposition </small>
		<?php }else{ ?>
		<small> est l'auteur de cette proposition</small>
		<?php } ?>
	</label>

	<hr>
	<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && $voteRes["up"]["percent"] > @$proposal["majority"] ){ ?>
		 <h5 class="no-margin">La résolution suivante a été 
		 	<span class="letter-green">validée</span>
		 </h5>
	<?php }else{ ?>
		 <h5 class="no-margin">La résolution suivante a été 
		 	<span class="letter-red">refusée</span>
		 </h5>
	<?php } ?>

	<!-- <h5 class="no-margin">La résolution suivante a été <span class="letter-green">adoptée</span> 
		<?php //echo " · ".Yii::t("cooperation", "end")." ".Translate::pastTime($resolution["voteDateEnd"], "date"); ?>
	</h5> -->
	<br>
</div>


<div class="col-lg-5 col-md-6 col-sm-6 no-padding">
	<button class="btn btn-default pull-right margin-left-5 margin-top-10 tooltips" 
				data-original-title="Fermer cette fenêtre" data-placement="bottom"
				id="btn-close-resolution">
		<i class="fa fa-times"></i>
	</button>
	<?php if($auth && @$resolution["creator"] == Yii::app()->session['userId']){ ?>
		 <div class="pull-right dropdown">
		  <button class="btn btn-default margin-left-5 margin-top-10" data-toggle="dropdown">
			<i class="fa fa-cog"></i> options
		  </button>
		  <ul class="dropdown-menu">
		    <li><a href="javascript:" class="" 
		    		data-id-resolution="<?php echo $resolution["_id"]; ?>"
		    		data-status="archived">
		    	<i class="fa fa-pencil"></i> Modifier ma proposition
		    	</a>
		    </li>
		    <li><a href="javascript:" class="btn-option-status-resolution" 
		    		data-id-resolution="<?php echo $resolution["_id"]; ?>"
		    		data-status="archived">
		    	<i class="fa fa-trash"></i> Archiver ma proposition
		    	</a>
		    </li>
		    <!-- <li><hr class="margin-5"></li> -->
		    <li><a href="javascript:" class="btn-option-status-resolution" 
		    		data-id-resolution="<?php echo $resolution["_id"]; ?>"
		    		data-status="closed">
		    		<i class="fa fa-times"></i> Fermer ma proposition
		    	</a>
		    </li>
		  </ul>
		</div> 
	<?php } ?>
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


<?php 
	$this->renderPartial('../cooperation/pod/vote', array("proposal"=>$resolution));
?>

<div class="col-lg-12 col-md-12 col-sm-12 margin-top-5">
	
	<div class="padding-25 bg-lightblue radius-5" id="container-text-resolution" 
		 style="padding-top:5px !important; color:#2C3E50 !important">
		<?php if(@$resolution["title"]){ ?>
			<div class="col-lg-12 col-md-12 col-sm-12 no-padding">
				<h3><i class="fa fa-hashtag"></i> <?php echo @$resolution["title"]; ?></h3>
			</div>
		<?php }else{ ?>
			<div class="col-lg-12 col-md-12 col-sm-12 no-padding">
				<h3><i class="fa fa-angle-down"></i> Proposition</h3>
			</div>
		<?php } ?>

		<?php echo nl2br($resolution["description"]); ?>

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

	<?php if(false && @$resolution["arguments"]){ ?>
		<h4 class="margin-top-50"><i class="fa fa-angle-down"></i> Compléments d'informations, argumentations, exemples, démonstrations, etc</h4>
		<?php echo nl2br(@$resolution["arguments"]); ?>
	<?php } ?>

	<?php if(@$resolution["tags"]){ ?>
		<hr>
		<?php foreach($resolution["tags"] as $key => $tag){ ?>
			<span class="badge bg-red"><?php echo $tag; ?></span>
		<?php } ?>	
	<?php } ?>

	<?php if(@$resolution["urls"]){ ?>
		<hr>	
		<h4 class=""><i class="fa fa-angle-down"></i> Liens externes</h4>
		<?php foreach($resolution["urls"] as $key => $url){ ?>
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
	var idParentresolution = "<?php echo $resolution['_id']; ?>";
	var idParentRoom = "<?php echo $resolution['idParentRoom']; ?>";
	var msgController = "<?php echo @$msgController ? $msgController : ''; ?>";
	jQuery(document).ready(function() { 
		
		$("#comments-container").html("<i class='fa fa-spin fa-refresh'></i> Chargement des commentaires");
		
		getAjax("#comments-container",baseUrl+"/"+moduleId+"/comment/index/type/proposals/id/"+idParentresolution,
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
			uiCoop.sendVote("resolution", idParentresolution, voteValue, idParentRoom);
		});
		$("#btn-activate-vote").click(function(){
			uiCoop.activateVote(idParentresolution);
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

		if(msgController != ""){
			toastr.error(msgController);
		}
	});

</script>