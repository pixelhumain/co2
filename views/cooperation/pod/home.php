<style>
	
</style>
<div class="help-coop font-montserrat">
	<h2 class="letter-turq">Bienvenue dans votre espace coopératif</h2>
	<hr>
	<h3>A quoi ça sert ?</h3>
	<hr>
	<p style="font-size: 13px;">
		L'espace coopératif peut être considéré comme un outil de gestion de projet collaboratif, permettant de mettre en place une forme de <b>gouvernance transparente et horizontale</b>.
		<br>
		<br>
		
		C'est un outil d'aide à la décision, qui vous permettra de prendre des <b>décisions collectives</b>, 
		en concertation avec l'ensemble des 
		<?php if($type == Organization::COLLECTION){ ?> membres de votre organisation.<?php } ?>
		<?php if($type == Project::COLLECTION){ ?> contributeurs de votre projet.<?php } ?>
		<br>
		Il vous permettra également de gérer les différentes <b>actions</b> (tâches) à réaliser dans le cadre de votre activité,
		et d'attribuer ces actions à vos 
		<?php if($type == Organization::COLLECTION){ ?> membres.<?php } ?>
		<?php if($type == Project::COLLECTION){ ?> contributeurs.<?php } ?>
		</p>
	<hr>
	<h3>Comment ça marche ?</h3>
	<hr>
	<p style="font-size: 13px;">
		Parce que chaque 
		<?php if($type == Organization::COLLECTION){ ?> organisation est différente, <?php } ?>
		<?php if($type == Project::COLLECTION){ ?> projet est différent, <?php } ?>
		vous commencerez par créer des espaces thématiques en fonction de vos besoins.
		<br>
		Par exemple, si vous gérez un club sportif, vous pourrez créer un espace nommé "Utilisation du bugdet du club", dans lequel vos adhérents pourront faire leurs propositions en lien avec ce thème.
		<br><br>
		Chaque espace ainsi créé peut recevoir des propositions et des actions, en lien avec le thème de l'espace.
		<br><br>
	</p>

	<hr>
	<h3>C'est parti !</h3>
	<hr>
	
	<p style="font-size: 13px;">
		Créez votre premier espace coopératif, en cliquant sur le bouton 
		<a href="javascript:dyFObj.openForm('room')" class="letter-green bold">
	  		<i class="fa fa-plus-circle"></i> <?php echo Yii::t("cooperation", "Create room") ?>
	  	</a><br>
	  	(Vous retrouverez ce bouton dans le menu situé à gauche de votre écran)
	  	<br><br>
	  	Votre nouvel espace s'affichera dans le menu de gauche, et vous pourrez immédiatement faire votre première <b>proposition</b> en cliquant sur le bouton <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/dda_help/addproposal.png" height=30> 
	</p>

	<br>
	<hr>
	<h3>Proposer, amender, voter...</h3>
	<hr>
	
	<p style="font-size: 13px;">
		<h5>Ce sont les 3 étapes incontournables du processus de décision collective que nous vous proposons :</h5>
		<ul class="padding-25">
			<li>
				<b>1 - Proposer :</b> Une proposition est un texte écrit par un
				<?php if($type == Organization::COLLECTION){ ?> membre de votre organisation<?php } ?>
				<?php if($type == Project::COLLECTION){ ?> contributeur de votre projet<?php } ?>.
				<br>
				L'auteur d'une proposition peut activer ou désactiver la <i>procédure d'amendement</i>, selon la nécessité ou non de celle-ci. Il en définit également la durée.
				<br>
				L'auteur définit également la durée de la <i>procédure de vote</i>, plus ou moins longue en fonction du besoin de reflexion collective autour du sujet proposé.
				<br><br>
			</li>
			<li>
				<b>2 - Amender :</b> Un amendement est une modification, soumise au vote, dont le but est de corriger, compléter ou annuler tout ou une partie de la proposition en cours de délibération.<br>
				<i>(actuellement, il est seulement possible de compléter la proposition par ajout d'information. La modification, et suppression, ne sont pas encore disponibles)</i>
				<br><br>
				Tous les 
				<?php if($type == Organization::COLLECTION){ ?> membre de votre organisation<?php } ?>
				<?php if($type == Project::COLLECTION){ ?> contributeur de votre projet<?php } ?>
				peuvent proposer des amendements aux propositions.
				<br>
				Chaque amendement est soumi au vote.
				<br>
				Lorsque la période d'amendement est achevée, les amendements validés par le vote sont automatiquement ajouté à la proposition originale, et la période de vote commence.
				<br><br>
				<i>Rappel : la période d'amendement peut être désactivée par l'auteur de la proposition, afin de lancer directement la procédure de vote.</i>
				<br><br>
			</li>
			<li>				
				<b>3 - Voter :</b> Lorsque la période d'amendement est terminée (ou désactivée), la période de vote commence.
				<br>
				Chaque
				<?php if($type == Organization::COLLECTION){ ?> membre<?php } ?>
				<?php if($type == Project::COLLECTION){ ?> contributeur<?php } ?>
				peut alors donner son avis en votant :<br><br>
			
				<img class="img-responsive" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/dda_help/vote.png"> 				
			</li>
		</ul>
	</p>

	<hr>
	<h3>Et après ?</h3>
	<hr>

	<p style="font-size: 13px;">
		Lorsque la période de vote est terminée, la proposition est automatiquement fermée, puis transformée en <i>résolution</i>.
		<br>
		Vous pouvez retrouver l'ensemble des résolutions <b class="letter-green">adoptées</b> ou <b class="letter-red">refusées</b> de chaque espace dans la section suivante :
		<br><br>
		<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/dda_help/resolution.png">
	</p>

	<br>
	<hr>
	<h3>Et les actions dans tout ça ?</h3>
	<hr>

	<p style="font-size: 13px;">
		Les actions peuvent être créées librement dans chaque espace, en fonction de vos besoins.
		<br>
		<i>(amélioration : il serait intéressant de pouvoir lier des <b>résolutions</b> avec des <b>actions</b>)</i>
	</p>
</div>