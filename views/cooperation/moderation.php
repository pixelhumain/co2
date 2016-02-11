<?php 

	
   	$cssAnsScriptFilesTheme = array(
   		"/plugins/Chart-2.6.0/Chart.min.js"
   	);
   	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

	HtmlHelper::registerCssAndScriptsFiles( array('/css/cooperation.css'), Yii::app()->theme->baseUrl. '/assets');

	$author = Person::getById(@$proposal["creator"]);
	$profilThumbImageUrl = Element::getImgProfil($author, "profilThumbImageUrl", $this->module->assetsUrl);

	$myId = Yii::app()->session["userId"];
	$hasVote = @$proposal["votes"] ? Cooperation::userHasVoted($myId, $proposal["votes"]) : false; 
	$auth = Authorisation::canParticipate(Yii::app()->session['userId'], $proposal["parentType"], $proposal["parentId"]);
	
	if(@$proposal["idParentRoom"])
	$parentRoom = Room::getById($proposal["idParentRoom"]);

	$totalVotant = Proposal::getTotalVoters($proposal);
	$voteRes = Proposal::getAllVoteRes($proposal);
	

	if(isset(Yii::app()->session['userId'])){
		$me = Element::getByTypeAndId("citoyens", Yii::app()->session['userId']);
		$myRoles = @$me["links"]["memberOf"][@$proposal["parentId"]]["roles"] ? 
				   @$me["links"]["memberOf"][@$proposal["parentId"]]["roles"] : array();
	}else{
		$myRoles = array();
	}	
	
	//lock access if the user doesnt have the good role
	$accessRoom = @$parentRoom ? Room::getAccessByRole($parentRoom, $myRoles) : ""; 
	if($accessRoom == "lock") exit;
?>

<?php if(@$access=="deny"){ ?>
	<div class="col-lg-12 col-md-12 col-sm-12">
		<h5 class="padding-left-10 letter-red">
			<i class="fa fa-ban"></i> <?php echo Yii::t("cooperation","You are not allowed to access this content"); ?>		  	
		</h5>
		<h5 class="padding-left-10 letter-red">
			<small><?php echo Yii::t("cooperation","You must be member or contributor"); ?></small>  	
		</h5>
	</div>
<?php exit; } ?>


<div class="col-lg-9 col-md-12 col-sm-12 pull-left margin-bottom-15">
	
	<?php if(@$proposal["status"] == "tovote"){ ?>
		<h5>
			<?php if(@$proposal["voteDateEnd"]){ ?>
				<i class='fa fa-clock-o'></i> <?php echo Yii::t("cooperation", "End of vote session"); ?> 
				<?php echo Translate::pastTime($proposal["voteDateEnd"], "date"); ?> · 
				<small class='letter-green'> 
					<?php echo date('d/m/Y H:i e', strtotime($proposal["voteDateEnd"])); ?>
				</small>
			<?php }else{ ?>
				<?php echo Yii::t("cooperation", "Vote open until undefined date"); ?>
			<?php } ?>
			
		</h5>
	<?php } ?>

	<?php if(@$proposal["status"] == "tovote" && $hasVote!=false){ ?>
		<h5 class="pull-left no-margin"><i class="fa fa-user-circle"></i> <?php echo Yii::t("cooperation", "You did vote"); ?> 
			<span class="letter-<?php echo Cooperation::getColorVoted($hasVote); ?>">
				<?php echo Yii::t("cooperation", $hasVote); ?>
			</span>
		</h5>
	<?php }elseif(@$proposal["status"] == "tovote"){ ?>
		<h5 class="letter-red pull-left no-margin">
			<i class="fa fa-user-circle"></i> <?php echo Yii::t("cooperation", "You did not vote"); ?>
		</h5>
	<?php } ?>
</div>


<?php if(@$proposal["status"] == "resolved"){ ?>
	<div class="col-lg-9 col-md-12 col-sm-12 margin-bottom-15">
		<h4 class="">
			<i class="fa fa-bell"></i> 
			<?php echo Yii::t("cooperation", "The <b>resolution</b> has been taken : "); ?>
			<br class="visible-md">
			<small><?php echo Yii::t("moderation", "This message has been"); ?> 
			 	<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && 
			 			$voteRes["up"]["percent"] > @$proposal["majority"] ){ ?>
					<span class="letter-green"><?php echo Yii::t("moderation", "deleted"); ?></span>
				 <?php }else{ ?>
			 	<span class="letter-red"><?php echo Yii::t("moderation", "rehabilitated"); ?></span>
				<?php } ?>
			</small>
		</h4>
		<?php if(@$proposal["voteDateEnd"]){ ?>
			<i class='fa fa-clock-o'></i> <?php echo Yii::t("cooperation", "End of vote session"); ?> 
			<?php echo Translate::pastTime($proposal["voteDateEnd"], "date"); ?> · 
			<small class='letter-green'>le 
				<?php echo date('d/m/Y H:i e', strtotime($proposal["voteDateEnd"])); ?>
			</small>
		<?php } ?>

	</div>
<?php } ?>

<div class="col-lg-3 col-md-12 col-sm-12 pull-left margin-bottom-15 no-padding">
	<button class="btn btn-link letter-blue pull-right btn-howitworkmoderation">
		<i class="fa fa-info-circle"></i> Comment ça marche ?
	</button>
</div>

<style>
	#howitworkmoderation {
    	background: #dbe4f3 !important;
	    border-radius: 5px;
	}

	.btn-howitworkmoderation{
		border:none;
		background-color: transparent !important;
	}

	#modal-moderation .btn-start-moderation,
	#modal-moderation .timeline-panel small.letter-orange{
		display: none;
	}

	#modal-moderation .timeline > li{
		width:100%!important;
	}

	#modal-moderation .timeline::before {
		left:0px;
	}

</style>
<div class="col-xs-12 letter-blue padding-15 hidden" id="howitworkmoderation">
		<button class="btn btn-link pull-right btn-howitworkmoderation"><i class="fa fa-times"></i></button>
		<h5><i class="fa fa-info-circle"></i> Comment ça marche ?</h5>
		<hr>
		<p>
			L'objectif de la modération collective est de donner l'entière responsabilité du contenu diffusé sur KGOUGLE aux utilisateurs du réseau, de sorte qu'aucune équipe de modérateurs n'ait la possibilité de "censurer" certains contenus plus que d'autres.
			<br><br>
			La participation active des utilisateurs au processus de modération est donc indispensable. C'est à ce prix que nous garantissons la liberté d'expression sur le réseau.
		</p>
		<hr>
		<p class="bold">
			<i class="fa fa-chevron-right"></i> 
			Toute personne ayant accès en lecture à un message a le droit d'émettre un signalement s'il considère que ce contenu est innaproprié.
			<br>
			<br>
			<i class="fa fa-chevron-right"></i> 
			À partir de 3 signalements, une procedure de modération collective est automatiquement activée, afin de déterminer si les signalements ont été fait de manière abusive ou non.
			<br>
			<br>
			<i class="fa fa-chevron-right"></i> 
			La période de vote est d'une semaine à partir du 3ème signalement.
			<br>
			<br>
			<i class="fa fa-chevron-right"></i> 
			Lorsque la période de vote est terminée, le message est automatiquement supprimé ou réabilité, en fonction du résultat du vote.
			<br>
			<br>
			<i class="fa fa-chevron-right"></i> 
			Le seuil de la majorité est automatiquement fixée à 75%
			<br>
			<br>
			<i class="fa fa-chevron-right"></i> 
			Une publication est supprimée dans le cas où plus de 75% des votants ont voté POUR sa suppression.
			<br>
			<br>
			<i class="fa fa-chevron-right"></i> 
			Dans tous les cas contraire, la publication est réabilité, et toutes traces du signalement sont également effacées.
		</p>
		<button class="btn btn-link pull-right btn-howitworkmoderation margin-right-25">
			<i class="fa fa-check"></i> OK
		</button>
</div>

<ul class="col-lg-8 col-md-8 col-sm-10 col-xs-12 margin-top-15 timeline" id="news-to-moderate">
	
    <?php 
    	unset($news["reportAbuseCount"]);
    	$this->renderPartial('../news/newsPartialCO2', 
                          array( "news"=>array($news),
                                 "pair"=>false,
                                 "nbCol"=>1,
                                 "timezone"=>"",
                                 "canManageNews" => false,
                                 "isLive" => false,
                                 "isFirst"=>false,
                                 "notClearDouble"=>true)); ?>
</ul>


<h3 class="letter-blue col-xs-12 margin-top-15 text-center">
	<i class="fa fa-question-circle-o"></i> <i class="fa fa-chevron-right"></i> 
	Selon vous, ce message doit-il être effacé ?
</h3>

<?php 
	if(@$proposal["status"] != "amendable") 
		$this->renderPartial('../cooperation/pod/voteModeration', 
				array("proposal"=>$proposal, "auth" => $auth, "hasVote" => $hasVote));
?>





<?php if(@$proposal["status"] == "resolved"){ ?>
	<!-- <div class="col-lg-12 col-md-12 col-sm-12 margin-bottom-15">
		<hr>
		<h4 class="">
			<i class="fa fa-bell"></i> 
			<?php echo Yii::t("cooperation", "The <b>resolution</b> has been taken : "); ?>
			<br class="visible-md">
			<small><?php echo Yii::t("cooperation", "The proposal is"); ?> 
			 	<?php if(@$voteRes["up"] && @$voteRes["up"]["percent"] && 
			 			$voteRes["up"]["percent"] > @$proposal["majority"] ){ ?>
					<span class="letter-green"><?php echo Yii::t("cooperation", "validated"); ?></span>
				 <?php }else{ ?>
			 	<span class="letter-red"><?php echo Yii::t("cooperation", "refused"); ?></span>
				<?php } ?>
			</small>
		</h4>
		<?php if(@$proposal["voteDateEnd"]){ ?>
			<i class='fa fa-clock-o'></i> <?php echo Yii::t("cooperation", "End of vote session"); ?> 
			<?php echo Translate::pastTime($proposal["voteDateEnd"], "date"); ?> · 
			<small class='letter-green'>le 
				<?php echo date('d/m/Y H:i e', strtotime($proposal["voteDateEnd"])); ?>
			</small>
		<?php } ?><br>
		<button class="btn btn-default load-coop-data"
				data-type="resolution" data-dataid="<?php echo @$proposal["idResolution"]; ?>">
				<i class="fa fa-chevron-right"></i> <?php echo Yii::t("cooperation", "Show the resolution"); ?>
		</button>

	</div> -->
<?php } ?>

<div class="col-lg-12 col-md-12 col-sm-12 margin-top-5">
	
	<?php if(@$proposal["arguments"]){ ?>
		<hr>
		<h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-50 no-padding"><i class="fa fa-angle-down"></i> <?php echo Yii::t("cooperation", "More informations, arguments, exemples, demonstrations, etc"); ?></h4>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<?php echo nl2br(@$proposal["arguments"]); ?>
		</div>
	<?php } ?>

</div>



<!-- <div class="col-lg-12 col-md-12 col-sm-12"><hr></div> -->


<div class="col-lg-12 col-md-12 col-sm-12 margin-top-50 padding-bottom-15">

	<h4 class="text-center">
		<i class="fa fa-balance-scale fa-2x margin-bottom-10"></i>
		<br><?php echo Yii::t("cooperation", "Debat"); ?>
	</h4>
	<hr>

	<?php if($auth){ ?>
	<h4 class="text-center"><?php echo Yii::t("cooperation", "Add an argument"); ?><br><i class="fa fa-angle-down"></i></h4>

	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link bg-green-comment col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="up"><i class="fa fa-thumbs-up"></i> <?php echo Yii::t("cooperation", "For"); ?></button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval=""><?php echo Yii::t("cooperation", "Neutral"); ?></button>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-4">
		<button class="bold btn btn-link bg-red-comment col-md-12 col-sm-12 text-dark radius-5 btn-select-arg-comment" 
		data-argval="down"><i class="fa fa-thumbs-down"></i> <?php echo Yii::t("cooperation", "Against"); ?></button>
	</div>
	<?php }else{ ?>
	<h5 class="text-center"><?php echo Yii::t("cooperation", "You must be member or contributor to participate"); ?><br><i class="fa fa-angle-down"></i></h5>
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
	var idParentRoom = "<?php echo @$proposal['idParentRoom']; ?>";
	var msgController = "<?php echo @$msgController ? $msgController : ''; ?>";

	currentRoomId = idParentRoom;

	jQuery(document).ready(function() { 
		
		uiModeration.initUIModeration();

	});

</script>