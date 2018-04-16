
<div class="row bg-white">
	<div class="margin-top-70 margin-bottom-50 col-md-12">
		<div class="col-xs-12">
			<h3 class="text-center"><i class="fa fa-map-marker"></i> Point d'intéret</h3><hr>
		</div>
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
		mylog.log("standalone poiAlone", poiAlone);
		poiAlone["id"] = poiAlone['_id']['$id'];
		var html = directory.preview(poiAlone);
	  	$("#poi").html(html);

	  	//poi["sections"] = <?php echo json_encode(CO2::getContextList("poi")); ?>

	  	Sig.showMapElements(Sig.map, new Array(poiAlone));
	});

</script>