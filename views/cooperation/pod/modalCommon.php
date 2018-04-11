
<!-- ************ MODAL ASSIGN ACTION ********************** -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalAssignMe">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close margin-5 padding-10" data-dismiss="modal" aria-label="Close">
        	<i class="fa fa-times"></i>
        </button>
        
        <div class="modal-title" id="modalText">
        	<h5 class="pull-left margin-top-15">
        	 <i class="fa fa-handshake-o"></i> Participer à une action
        	</h5>
        </div>
      </div>
      
       <div class="modal-body padding-15">
			<strong>Êtes-vous sûr de vouloir participer à cette action ?</strong><br>
	    	Vous serez inscrit dans la liste des participants.
      </div>

      <div class="modal-footer">
      	<button class="btn btn-success pull-right margin-left-10" data-dismiss="modal" id="btn-validate-assign-me">
      		<i class="fa fa-check"></i> Oui
      	</button>
      	<button class="btn btn-default pull-right" data-dismiss="modal">
      		<i class="fa fa-times"></i> Non
      	</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- ************ MODAL DELETE AMENDEMENT ********************** -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteAm">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close margin-5 padding-10" data-dismiss="modal" aria-label="Close">
        	<i class="fa fa-times"></i>
        </button>
        
        <div class="modal-title" id="modalText">
        	<h5 class="pull-left margin-top-15">
        	 <i class="fa fa-trash"></i> Supprimer un amendement
        	</h5>
        </div>
      </div>
      
       <div class="modal-body padding-15">
			<strong>Êtes-vous sûr de vouloir supprimer votre amendement ?</strong><br>
	    	Toute suppression est définitive.
      </div>

      <div class="modal-footer">
      	<button class="btn btn-danger pull-right margin-left-10" 
      		data-id-am="" data-dismiss="modal" id="btn-delete-am">
      		<i class="fa fa-check"></i> Oui, supprimer
      	</button>
      	<button class="btn btn-default pull-right" data-dismiss="modal">
      		<i class="fa fa-times"></i> Non
      	</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
