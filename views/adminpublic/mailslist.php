
<?php

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

if(@Yii::app()->session["userId"])
	$this->renderPartial($layoutPath.'.rocketchat'); 


$cssAnsScriptFilesModule = array(
	'/plugins/jquery-simplePagination/jquery.simplePagination.js',
	'/plugins/jquery-simplePagination/simplePagination.css',
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css',
	'/plugins/underscore-master/underscore.js',
	'/plugins/jquery-mentions-input-master/jquery.mentionsInput.js',
	'/plugins/jquery-mentions-input-master/jquery.mentionsInput.css',
	'/plugins/jquery.dynForm.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));

$cssAnsScriptFilesModule = array( 
	'/js/eligible.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( "survey" )->getAssetsUrl() );


$cssJS = array(
	'/js/dataHelpers.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

$cssAnsScriptFilesModule = array(
	'/assets/js/comments.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);
$states = array();
?>

<style type="text/css">
	.clickOpen{
		cursor: pointer;
	}
	.round{
		border-radius: 100%;
		width: 250px;
		height: 250px;
		padding-top: 70px;
		border-color: #333;
	}
</style>
<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding">
	
	<div class="col-md-12 col-sm-12 col-xs-12 ">
		<h1 class="text-center">Mails List </h1>
		<br/>
		<h5 class="">
			Filtres : 
			<a href="javascript:;" onclick="showType('line')" class="btn btn-xs btn-default">Tous</a>
			<a href="javascript:;" onclick="showType('pending')" class="btn btn-xs btn-default">Pending</a> 
			<a href="javascript:;" onclick="showType('update')" class="btn btn-xs btn-default">Update</a>
			
			
		</h5>	

		<div style="width:80%;  display: -webkit-inline-box;">
			<input type="text" class="form-control" id="search" placeholder="Rechercher une information dans le tableau">
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
</div>
<div class="panel panel-white col-lg-12 col-xs-12 no-padding">
	<div class="panel-body">
		<div>
			<!-- <a href="<?php //echo '#element.invite.type.'.Form::COLLECTION.'.id.'.(string)$form['_id'] ; ?>" class="btn btn-primary btn-xs pull-right margin-10 lbhp">Invite Admins & Participants</a> -->
			

			<span><b>Il y a <span id="nbLine"><?php echo count(@$results); ?></span> réponses</b></span>
			<br/><br/>

			<table class="table table-striped table-bordered table-hover directoryTable" id="panelAdmin" style="table-layout: fixed; width:100%; word-wrap:break-word;">
				<thead>
					<tr>
						<th class="">#</th>
						<th class="">To</th>
						<th class="">Status</th>
						<th class="">Template</th>
						<th class="">Subject</th>
					</tr>
				</thead>
				<tbody class="directoryLines">
					<?php
						$nb = 0;
						foreach ($results as $k => $v) {
							$nb++;
						?>
						<tr data-id="<?php echo $k ?>" class="<?php echo @$v["status"]." ".@$v["tpl"]." " ?> line">
							<td class=" clickOpen "><?php echo @$nb ?></td>
							<td class=" clickOpen" ><?php echo @$v["to"] ?></td>
							<td class=" clickOpen" ><?php echo @$v["status"] ?></td>
							<td class=" clickOpen" ><?php echo @$v["tpl"] ?></td>
							<td class=" clickOpen" ><?php echo @$v['subject'] ?></td>
							
						<?php
					} ?>
				</tbody>
			</table>
			
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
</div>

<script type="text/javascript">

var results  = <?php echo json_encode($results); ?>;

function showType (type) { 
	$(".line").hide();
	$("."+type).show();
	countLine();
}

jQuery(document).ready(function() {
	
	$("#search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#panelAdmin tr.line").filter( function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
			countLine();
		});
	});

	$(".clickOpen").off().on('click',function(){
		window.open("<?php echo Yii::app()->getRequest()->getBaseUrl(true)."/co2/test/displayMail/id/" ; ?>"+$(this).parent().data('id')) ;
	});
});

function countLine(){
	$("#nbLine").html($('#panelAdmin tr.line:visible').length);
}




</script> 

