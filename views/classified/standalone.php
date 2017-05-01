
<div class="row bg-white">
	<div class="margin-top-70 margin-bottom-50">
		<div class="col-xs-12">
			<h3 class="text-center"><i class="fa fa-bullhorn"></i> Annonce</h3><hr>
		</div>
		<div id="classified"></div>
	</div>
</div>

<script type="text/javascript">

	var classified=<?php echo json_encode($element); ?>;

	jQuery(document).ready(function() {	
		setTitle("", "", classified.name);
		classified["id"] = classified['_id']['$id'];
		var html = directory.preview(classified);
	  	$("#classified").html(html);
	});

</script>