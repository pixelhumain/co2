<!-- Modal -->
<div id="modal-delete-element" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-dark"><?php echo Yii::t("common","Delete")?></h4>
      </div>
      <div class="modal-body text-dark">
        <p>

        	<?php 

        		if($id == Yii::app()->session["userId"] && $type == Person::COLLECTION){
        			echo "Si vous supprimer votre comptes, toutes vos informations personnelles et vos messages seront supprimer";
        		} else {
        			echo Yii::t('common',"Are you sure you want to delete this element ? </br> The element will be deleted : it will not be referenced in all their projects or events. But these last ones will not be deleted. <span class=\"text-red\">Warning:</span> this action can be cancelled only by an administrator") ;
        		}

        	?>	
        </p>
        <br>
        	<?php echo Yii::t('common','You can add bellow the reason why you want to delete this element :') ;?>
        <textarea id="reason" class="" rows="2" style="width: 100%" placeholder="Laisser une raison... ou pas (optionnel)"></textarea>
      </div>
      <div class="modal-footer">
				<!-- Utilisation du bouton confirmDeleteElement -->
       <button id="confirmDeleteElement" type="button" class="btn btn-warning"><?php echo Yii::t('common','I confim the delete !');?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo Yii::t('common','No');?></button>
      </div>
    </div>

  </div>
</div>

<script>
	$("#confirmDeleteElement").off().on("click", function(){
	    var url = baseUrl+"/"+moduleId+"/element/delete/id/"+contextData.id+"/type/"+contextData.type;
	    mylog.log("deleteElement", url);
		var param = new Object;
		param.reason = $("#reason").val();
		$.ajax({
	        type: "POST",
	        url: url,
	        data: param,
	       	dataType: "json",
	    	success: function(data){
		    	if(data.result){
						toastr.success(data.msg);
						console.log("Retour de delete : "+data.status);
						if (data.status == "deleted") 
							urlCtrl.loadByHash("#search"); //envoie l'utilisateur la barre de recherche
						else 
							urlCtrl.loadByHash("#page.type."+contextData.type+".id."+contextData.id); //Une autre page
						}
					else{
		    		toastr.error(data.msg); 
		    	}
		    },
		    error: function(data){
		    	toastr.error("Something went really bad ! Please contact the administrator.");
		    }
		});
	});
</script>