
<!-- ************ MAIN MODAL CO-SPACE ********************** -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalCoop">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close margin-5 padding-10" data-dismiss="modal" id="btn-close-coop"
        		aria-label="Close"><i class="fa fa-times"></i>
        </button>

        <?php 
            if( isset( Yii::app()->session['userId']) ){
              $me = Element::getByTypeAndId("citoyens", Yii::app()->session['userId']);
              $profilThumbImageUrl = Element::getImgProfil($me, "profilThumbImageUrl", $this->module->assetsUrl);
              //$countNotifElement = ActivityStream::countUnseenNotifications(Yii::app()->session["userId"], Person::COLLECTION, Yii::app()->session["userId"]);
        ?> 
         <!-- #page.type.citoyens.id.<?php echo Yii::app()->session['userId']; ?> -->
        <a  href="#page.type.citoyens.id.<?php echo Yii::app()->session['userId']; ?>"
            class="menu-name-profil lbh text-dark pull-right shadow2" 
            data-toggle="dropdown">
                <small class="hidden-xs hidden-sm margin-left-10 bold" id="menu-name-profil">
                    <?php echo @$me["name"] ? $me["name"] : @$me["username"]; ?>
                </small> 
                <img class="img-circle" id="menu-thumb-profil" 
                     width="40" height="40" src="<?php echo $profilThumbImageUrl; ?>" alt="image" >
        </a>
        <?php } ?>

        <button href="javascript:" class="btn btn-default btn-sm text-dark pull-right tooltips"
				id="btn-update-coop" style="margin: 10px 10px 0 0;" data-original-title="<?php echo Yii::t("cooperation", "Reload window") ?>" data-placement="left">
	  			<i class="fa fa-refresh"></i> <?php echo Yii::t("cooperation", "Refresh data") ?>
	  	</button> 	
        	
        <div class="modal-title" id="modalText">
        	<img class="pull-left margin-right-15" src="<?php echo $thumbAuthor; ?>" height=52 width=52 style="">
			<!-- <h4 class="pull-left margin-top-15"><i class="fa fa-connectdevelop"></i> Espace coopératif</h4> -->
        	 <div class="pastille-type-element bg-<?php echo $iconColor; ?> pull-left" style="margin-top:14px;"></div>
			     <h4 class="pull-left margin-top-15">
        	  <?php echo @$element["name"]; ?>
        	</h4>        	
        </div>
      </div>
      
       <div class="modal-body col-lg-12 col-md-12 col-sm-12 padding-15">
			  <ul id="menuCoop" class="menuCoop col-lg-2 col-md-3 col-sm-3">
    		</ul>
    		<div id="main-coop-container" class="col-lg-10 col-md-9 col-sm-9"></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- ************ MODAL HELP COOP ********************** -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalHelpCOOP">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title" id="modalText">
        	<h4><i class="fa fa-info-circle"></i> Aide</h4>
        </div>
      </div>
       -->
       <div class="modal-body padding-25">
		<?php $this->renderPartial('../cooperation/pod/home', array("type"=>$type)); ?>
      </div>
      <div class="modal-footer">
      	<div id="modalAction" style="display:inline"></div>
        <button class="btn btn-default pull-right btn-sm margin-top-10 margin-right-10" data-dismiss="modal"> J'ai compris</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- ************ MODAL DELETE ROOM ********************** -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteRoom">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-title" id="modalText">
        	<h4><i class="fa fa-times"></i> Supprimer un espace coopératif</h4>
        </div>
      </div>
      <div class="modal-body">
      	<h3 style="text-transform: none!important; font-weight: 200;" class="letter-turq">
      		<i class="fa fa-hashtag"></i> <span id="space-name"><?php echo @$room["name"]; ?></span>
      	</h3>
      	<label>Etes-vous sur de vouloir supprimer cet espace coopératif ?</label><br>
      	<small class="text-red">Toutes les propositions, résolutions, et actions de cet espace seront supprimées définitivement.</small>
      </div>
      <div class="modal-footer">
      	<div id="modalAction" style="display:inline"></div>
        <button class="btn btn-danger pull-right btn-sm margin-top-10" 
				id="btn-delete-room" data-placement="bottom" 
				data-dismiss="modal"
				data-original-title="supprimer l'espace : <?php echo @$room["name"]; ?>"
				data-id-room="">
			<i class="fa fa-trash"></i> Oui, supprimer cet espace
		</button>
		<button class="btn btn-default pull-right btn-sm margin-top-10 margin-right-10" data-dismiss="modal"> Annuler</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
