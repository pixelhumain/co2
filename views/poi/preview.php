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

	  	$("#modal-preview-coop .btn-close-preview").click(function(){
			console.log("close preview");
			$("#modal-preview-coop").hide(300);
			$("#modal-preview-coop").html("");
		});
		
	  	//poi["sections"] = <?php echo json_encode(CO2::getContextList("poi")); ?>

	  	Sig.showMapElements(Sig.map, new Array(poiAlone));
	});

</script>