
<div class="row bg-white">
	<div class="margin-top-70 margin-bottom-50 col-md-12">
		<div class="col-xs-12">
			<h3 class="text-center"><i class="fa fa-map-marker"></i> Point d'intéret</h3><hr>
		</div>
		<div id="poi"></div>
	</div>
</div>

<script type="text/javascript">

	var poi=<?php echo json_encode($element); ?>;

	jQuery(document).ready(function() {	
		setTitle("", "", poi.name);
			
		poi["typePoi"] = poi.type;
		poi["type"] = "poi";
		poi["typeSig"] = "poi";
		
		poi["id"] = poi['_id']['$id'];
		var html = directory.preview(poi);
	  	$("#poi").html(html);

	  	Sig.showMapElements(Sig.map, new Array(poi));
	});

</script>