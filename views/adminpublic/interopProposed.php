<?php
$cs = Yii::app()->getClientScript();
$cssAnsScriptFilesModule = array(
		'/plugins/jsonview/jquery.jsonview.js',
		'/plugins/jsonview/jquery.jsonview.css',
		//'/assets/js/sig/geoloc.js',
		/*'/assets/js/dataHelpers.js',
		'/assets/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
		'/assets/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js'*/
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->request->baseUrl);


$userId = Yii::app()->session["userId"] ;

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
//header + menu
$this->renderPartial($layoutPath.'header', 
                    array(  "layoutPath"=>$layoutPath , 
                            "page" => "admin") ); 

?>

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

<?php

$collection = "proposeOpenDataSource";
// $proposed = array('status' => "proposed");

$all_proposition = PHDB::find($collection);

?>

<script type="text/javascript">
	
	var all_proposition = <?php echo json_encode($all_proposition); ?>;

	$.each(all_proposition, function(index, value) {

		var class_tr = "";

		if (value.status == 'approved') {
			class_tr = "class='success'";
		} else if (value.status == "rejected") {
			class_tr = "class='danger'";
		} 

		$("#one_element_table").append(

	    	"<tr "+class_tr+">"+
	    		"<td>" + value.url + " </td>"+
	    		"<td> " + value.userID + "</td>"+
	    		"<td>"+ value.description +
	    		"<td><form class='status_form'><input type='radio' name='status' value='rejected'> Rejeter </input><br>" +
	    		"<input type='radio' name='status' value='accepted'> Accepter </input>"+
	    		"<input class='btn-validate_status' type='submit' name='status' value='Valider'</input>"+
	    		"</form></td>" +
			"</tr>"
		)
	});

	$( ".status_form" ).submit(function( event ) {
		
		mylog.log($(this).val());

  		alert($('input[name=status]:checked', $(this)).val(), message); 
		
		var message = "";

		if ($('input[name=status]:checked', $(this)).val() == "accepted") {
			message = "Etes vous sûr de vouloir autoriser cette source";

		} else {
			message = "Etes vous sûr de ne pas vouloir autoriser cette source";
		}

		ValidateStatus($('input[name=status]:checked', $(this)).val(), message);
	});

	$(".validate_status").click(function(){
        ValidateStatus();
    });

function ValidateStatus(status, message) {

	if (confirm(message)) {
	    mylog.log("OUIIIIIIIIIIII");
	} else {
		mylog.log("NOOOOOOOOOOOON");
	}
}
	
</script>


