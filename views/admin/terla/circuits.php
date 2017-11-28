<style type="text/css">
	.podDash .nav{
		display: inline-block;
		display: -webkit-inline-box; 
		    height: 50px;
    display: inline-block;
    display: -webkit-inline-box;
    /*position: absolute;*/
	}
	.podDash .nav-item{
		text-transform: uppercase;
		font-size: 18px;
		font-weight: 600;
		border-top: 5px solid lightgray;
		margin-right: 5px;
		position: relative;
	}
	.podDash .nav-item.active{
		border-top: 5px solid #EF5B34;
		box-shadow: 0 9px 0px 0px white, 
			0 9px 0px 0px white, 
			0px 0px 10px -1px rgba(0,0,0,0.5), 
			0px 0px 10px -1px rgba(0,0,0,0.5);
		z-index: 1;
    	height: 55px;
    	margin-top: -5px;
    	padding-top: 5px;
    	background-color: white;
	}
	.podDash .content-view-circuits{
		margin-bottom:150px !important;
		min-height: 300px;
		-webkit-box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.5);
        -moz-box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.5);
    	box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.5);
    	/*position: absolute;
    	top: 50px;*/

	}
</style>
<!-- A transformer en dyn form -->
<div id="create-new-circuit" class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 margin-top-20" style="display:none;">
	<div class="form-group">
		<label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding">Name of the circuit:</label>
		<input type="text" id="name" name="name" class="form-control" placeholder="Enter name of circuit">
	</div>
	<div class="form-group">
		<label class="col-md-12 col-sm-12 col-xs-12 text-left control-label no-padding">Type of the circuit:</label>
		<select class="" name="frequency" id="frequency" style="width: 100%;height:30px;" class="form-control">
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
		<input type="number" id="capacity" name="capacity" value="12" class="form-control"></input>
	</div>
	<div class="form-group text-center">
		<button id="validateCircuit" class="btn btn-success"><?php echo Yii::t("common", "Start the circuit") ?></button>
	</div>
</div>
<div class="podDash col-md-12 margin-top-20">
		<ul class="nav pull-left">
		  <li class="nav-item active">
		    <a class="nav-link letter-lightgray" href="javascript:;" id="btn-circuits">
		    	<?php echo Yii::t("common","Circuits") ?>
		    </a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link letter-lightgray" href="javascript:;" id="btn-backups">
		    	<?php echo Yii::t("common","Backups") ?>
		    </a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link letter-lightgray" href="javascript:;" id="btn-reservations">
		    	<?php echo Yii::t("common","Reservations") ?>
		    </a>
		  </li>
		</ul>
		<div class="content-view-circuits col-md-12 col-sm-12 col-xs-12 margin-bottom-20 padding-10 bg-white">
		</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#validateCircuit").click(function(){
			startCircuit($(this));
		});
	});
	function startCircuit($this){
		if($("#create-new-circuit #name").val()==""
			|| $("#create-new-circuit #description").val()==""
			){
			$this.parent().append("<div class='alert-danger col-md-12 col-sm-12 col-xs-12'>Please enter something for name and description</div>");
			return false;
		}else
			$this.parent().find(".alert-danger").remove();
		circuit.obj.show=true;
		circuit.obj.name=$("#create-new-circuit #name").val();
		circuit.obj.description=$("#create-new-circuit #description").val();
		circuit.obj.capacity=$("#create-new-circuit #capacity").val();
		circuit.obj.frequency=$("#create-new-circuit #frequency").val();
		$("#create-new-circuit #name").val("");
		$("#create-new-circuit #description").val("");
		$("#create-new-circuit #capacity").val(12);
		$("#create-new-circuit #frequency").val("unique");
		localStorage.setItem("circuit",JSON.stringify(circuit.obj));
		circuit.countCircuit("init");
		toastr.success("You can began to create the circuit");
		urlCtrl.loadByHash("#activities");

	};
</script>