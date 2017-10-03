<?php
$cs = Yii::app()->getClientScript();
$cssAnsScriptFilesModule = array(
		'/plugins/jsonview/jquery.jsonview.js',
		'/plugins/jsonview/jquery.jsonview.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->request->baseUrl);


$userId = Yii::app()->session["userId"] ;

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
//header + menu
$this->renderPartial($layoutPath.'header', 
                    array(  "layoutPath"=>$layoutPath , 
                            "page" => "admin") ); 
?>

<div id="main-container-proposition" class="container-all-proposition col-xs-12 bg-white">

	<table class='table table-bordered col-xs-12'>
		<thead>
			<tr>
			<th>URL de la source de données</th>
			<th>User ID</th>
			<th>Description</th>
			<th>Status</th>
			</tr>
		</thead>
		<tbody id='one_element_table'>
		</tbody>
	</table>

</div>

<?php

	$collection = "proposeOpenDataSource";
	$all_proposition = PHDB::find($collection);

?>

<script type="text/javascript">
	
	var all_proposition = <?php echo json_encode($all_proposition); ?>;
	all_data_proposition = {};

	$.each(all_proposition, function(index, value) {

		var new_index = index.toString();

		all_data_proposition[new_index] = [];
		all_data_proposition[new_index].push(value.url);
		all_data_proposition[new_index].push(value.userID);
		all_data_proposition[new_index].push(value.description);

		var class_tr = "";

		if (value.status == 'accepted') {
			class_tr = "class='success'";
		} else if (value.status == "rejected") {
			class_tr = "class='danger'";
		} 

		$("#one_element_table").append(

	    	"<tr "+class_tr+">"+
	    		"<td data-value='"+value.url+"'>" + value.url + " </td>"+
	    		"<td data-value='"+value.userID+"'> " + value.userID + "</td>"+
	    		"<td data-value='"+value.description+"'>"+ value.description +
	    		"<td>"+
		    		"<button id='"+index.toString()+"'  style='margin-bottom:5px; text-align='center'; class='btn btn-success btn_validate_status' data-status ='accepted' data-id='"+index.toString()+"'>Valider</button><br>"+
		    		"<button id='"+index.toString()+"'  style='text-align:center;' class='btn btn-danger btn_validate_status' data-status='rejected' data-id='"+index.toString()+"'>Rejeter</button>"+
	    		"</td>" +
			"</tr>"
		)
	});

  	$(".btn_validate_status").click(function(){
        ValidateStatus($(this).data('id'), $(this).data('status'));
    });

function ValidateStatus(id_propose, status) {

	if (confirm("Etes vous sur ?")) {

		$.each(all_data_proposition, function(index, value) {

			if (status == "accepted") {
				if (index == id_propose) {

					$.ajax({
				        type: "POST",
				        url: baseUrl+"/"+moduleId+"/interoperability/validateproposeinterop?status="+status+"&idpropose="+id_propose,
				        dataType: "json",
				        success: function (data){
				            
				        	alert('Vous avez accepté la proposition !');
				        }
				    });
				}
			} else if (status == "rejected") {
				if (index == id_propose) {

					$.ajax({
				        type: "POST",
				        url: baseUrl+"/"+moduleId+"/interoperability/rejectproposeinterop?status="+status+"&idpropose="+id_propose,
				        dataType: "json",
				        success: function (data){
				            
				        	alert('Vous avez refusé la proposition !');
				        }
				    });
				}
			}
		});
	} else {
		alert('Vous avec avorté la validation ou le rejet de la proposition');
	}
}
	
</script>


