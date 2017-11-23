<div id="create-new-circuit" class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 margin-top-20">
	<div class="form-group">
		<label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding">Name of the circuit:</label>
		<input type="text" name="name" class="form-control">
	</div>
	<div class="form-group">
		<label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding">Type of the circuit:</label>
		<select class="" name="recurrence" id="reccurence" style="width: 100%;height:30px;" class="form-control">
			<option class="text-red" style="font-weight:bold" value="unique" selected>Unique</option>
			<option value="weekly">Every week</option>
			<option value="dayly">Every day</option>
		</select>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding">Description of the circuit:</label>
		<textarea id="description" name="description" class="form-control"></textarea>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding">Capacity for the circuit:</label>
		<input type="number" id="number" name="capacity" value="12" class="form-control"></input>
	</div>
	<div class="form-group text-center">
		<button id="validateCircuit" class="btn btn-success"><?php echo Yii::t("common", "Save") ?></button>
	</div>
</div>
<script type="text/javascript">
	
</script>