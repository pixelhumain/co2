<style>
	#modal-preview-coop{
		overflow: auto;
	}
</style>

<div class="margin-top-25 margin-bottom-50 col-xs-12">
	<div class="col-xs-12 no-padding">
		<button class="btn btn-default pull-right btn-close-preview" style="margin-top:-15px;">
			<i class="fa fa-times"></i>
		</button>
		<?php if( $element["creator"] == Yii::app()->session["userId"] || 
				  Authorisation::canEditItem( Yii::app()->session["userId"], "poi", $id, $element["parentType"], $element["parentId"] ) ){ ?>
			
			<button class="btn btn-default pull-right margin-right-10 text-red deleteThisBtn" 
					data-type="poi" data-id="<?php echo $id ?>" style="margin-top:-15px;">
				<i class=" fa fa-trash"></i>
			</button>
			<button class="btn btn-default pull-right margin-right-10 btn-edit-preview" style="margin-top:-15px;">
				<i class="fa fa-pencil"></i>
			</button>
			
		<?php } ?>
		<!-- <h3 class="text-center letter-green"><i class="fa fa-map-marker"></i> Point d'intéret</h3> -->
		<div id="poi"></div>
	</div>
</div>

<script type="text/javascript">

	var poiAlone=<?php echo json_encode($element); ?>;

	jQuery(document).ready(function() {	
		setTitle("", "", poiAlone.name);
			
		poiAlone["typePoi"] = poiAlone.type;
		poiAlone["type"] = "poi";
		poiAlone["typeSig"] = "poi";
		
		poiAlone["id"] = poiAlone['_id']['$id'];
		var html = directory.preview(poiAlone);
	  	$("#poi").html(html);

	  	initBtnLink();

	  	$("#modal-preview-coop .btn-close-preview, .deleteThisBtn").click(function(){
			console.log("close preview");
			$("#modal-preview-coop").hide(300);
			$("#modal-preview-coop").html("");
		});

		$(".btn-edit-preview").click(function(){
			$("#modal-preview-coop").hide(300);
			$("#modal-preview-coop").html("");
			dyFObj.editElement('poi', '<?php echo $id ?>' );
		});
		
	  	//poi["sections"] = <?php echo json_encode(CO2::getContextList("poi")); ?>

	  	Sig.showMapElements(Sig.map, new Array(poiAlone));
	});
</script>