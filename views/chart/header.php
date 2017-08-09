<style type="text/css">
	.headerChart .btnChart{
		font-variant: small-caps;
		font-size: 20px;
	}
</style>
<?php 
	if (@$properties["commons"] && !empty($properties["commons"])) $commonsView=true;
	if (@$properties["open"] && !empty($properties["open"])) $openView=true;
?>

<div class="col-xs-12 margin-bottom-15">
		<i class="fa fa-heartbeat fa-2x"></i><span class="Montserrat" id="name-lbl-title"> <?php echo Yii::t("chart","Values {what}",array("{what}"=>Yii::t("common", "of the ".Element::getControlerByCollection($parentType)))) ?></span> 
		<?php if(@$commonsView && @$openView) { ?>
			<button class="btn-update-descriptions btn btn-default letter-blue pull-right edit-chart">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("chart", "Edit values") ?></b>
			</button>
		<?php } ?> 
</div>
<div class="noteWrap col-md-12 col-sm-12 col-xs-12 bg-white">
<div class="headerChart col-md-12 col-sm-12 col-xs-12 no-padding">
	<?php if(@$commonsView){ ?>
	<div class="col-md-6">
		<a id="btncommons" href="javascript:;" onclick="switchTypeChartView('commons')" class="btnChart <?php if (@$commonsView) echo "text-green" ?>">
			<i class="fa fa-circle"></i> <?php echo Yii::t("chart","Commons") ?>
		</a>
		<p><?php echo Yii::t("chart","{what} that manages one or several resources openly and transparently whitout appropriating it",array("{what}"=>ucfirst(Yii::t("common",Element::getControlerByCollection($parentType))))) ?></p>
	</div>
	<?php } ?>
	<?php if(@$openView){ ?>
	<div class="col-md-6">
		<a id="btnopen" href="javascript:;" onclick="switchTypeChartView('open')" class="btnChart <?php if (!@$commonsView) echo "text-green" ?>">
			<i class="fa fa-circle"></i> <?php echo Yii::t("chart","Open") ?>
		</a>
		<p><?php echo Yii::t("chart","{what} that shows its values openly adding few properties and describing them",array("{what}"=>ucfirst(Yii::t("common",Element::getControlerByCollection($parentType))))) ?></p>
	</div>
	<?php } ?>
	<?php if(!@$openView || !@$commonsView){ ?>
		<div class="col-md-6">
			<a href="javascript:;" class="edit-chart btn btn-default letter-blue text-center col-md-12 margin-20" style="font-size:16px;">
				<span><i class="fa fa-pencil"></i> <?php echo Yii::t("chart","Edit chart") ?> "<?php if(@$commonsView) echo Yii::t("chart","Commons"); else echo Yii::t("chart","Open") ?>"	
				</span><br/>
				<span><i class="fa fa-plus"></i> <?php echo Yii::t("chart","Add chart") ?> "<?php if(!@$commonsView) echo Yii::t("chart","Commons"); else echo Yii::t("chart","Open") ?>"
				</span>
			</a>
		</div>
	<?php } ?>
	<hr class="col-md-12 no-padding">
</div>
<div class="row col-md-12 col-sm-12 col-xs-12" id="chartPad"></div>
</div>
<script type="text/javascript">
var contextType="<?php echo $parentType ?>";
var contextId="<?php echo $parentId ?>";
var commonsView="<?php echo @$commonsView ?>";
var openView="<?php echo @$openView ?>";
if(commonsView==true)
	chartLoader="commons";
else if (openView==true)
	chartLoader="open";
jQuery(document).ready(function() {
	ajaxPost('#chartPad', baseUrl+'/'+moduleId+'/chart/index/type/'+contextType+'/id/'+contextId+'/chart/'+chartLoader, 
	null,
	function(){},"html");
	$(".edit-chart").click(function(){
		history.pushState(null, "New Title", hashUrlPage+".view.editChart");
		loadEditChart();
	});
		
});
function switchTypeChartView(str){
	//$(".btn-group i").removeClass("fa-check-circle-o");
	//$(".btn-group i").addClass("fa-circle-thin");
	$(".headerChart .btnChart").removeClass("text-green");
	$(".headerChart #btn"+str).addClass("text-green");
	var url = "chart/index/type/"+contextType+"/id/"+contextId+"/chart/"+str;
	showLoader('#chartPad');
	ajaxPost('#chartPad', baseUrl+'/'+moduleId+'/'+url, 
	null,
	function(){},"html");
}
</script>