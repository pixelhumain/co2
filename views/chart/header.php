<div class="noteWrap col-md-12 col-sm-12 col-xs-12 bg-white">
<div class="col-md-6">
	<a id="btncommons" href="javascript:;" onclick="switchTypeChartView('commons')" class="btn <?php if (isset($properties["commons"]) && !empty($properties["commons"])) echo "text-orange" ?>">
		<i class="fa fa-circle"></i> <?php echo Yii::t("chart","Commons") ?>
	</a>
	<p>Explication de ce qu'on entend par "bien commun" pour qu'on soit bien tous d'accord  sur la définition de ce terme + explication sur l'action de "choisir un type de formulaire"</p>

</div>
<div class="col-md-6">
	<a id="btnopen" href="javascript:;" onclick="switchTypeChartView('open')" class="btn <?php if (isset($properties["open"]) && !empty($properties["open"])) echo "text-orange" ?>">
		<i class="fa fa-circle"></i> <?php echo Yii::t("chart","Open") ?>
	</a>
	<p>Explication de ce qu'on entend par "libre" pour qu'on soit bien tous d'accord  sur la définition de ce terme + explication sur l'action de "choisir un type de formulaire"</p>
</div>
<div class="row" id="chartPad"></div>
</div>
<script type="text/javascript">
var contextType="<?php echo $parentType ?>";
var contextId="<?php echo $parentId ?>";
jQuery(document).ready(function() {
	ajaxPost('#chartPad', baseUrl+'/'+moduleId+'/chart/index/type/'+contextType+'/id/'+contextId+'/chart/commons', 
	null,
	function(){},"html");
});
function switchTypeChartView(str){
	//$(".btn-group i").removeClass("fa-check-circle-o");
	//$(".btn-group i").addClass("fa-circle-thin");
	$(".chooseTypeForm .btn").removeClass("text-green");
	$(".chooseTypeForm #btn"+str).addClass("text-green");
	var url = "chart/index/type/"+contextType+"/id/"+contextId+"/chart/"+str;
	showLoader('#chartPad');
	ajaxPost('#chartPad', baseUrl+'/'+moduleId+'/'+url, 
	null,
	function(){},"html");
}
</script>