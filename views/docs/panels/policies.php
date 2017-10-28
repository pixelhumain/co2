<?php $this->renderPartial('../docs/panels/menuLink',array("url"=>"default/view/page/links")); ?>

<div class="panel-heading border-light center text-dark partition-white radius-10">
	<span class="panel-title homestead"> <i class='fa fa-heart text-red faa-pulse animated    fa-3x  '></i> <span style="font-size: 48px">éthique  </span></span>
</div>
<div class="space20"></div>
<div class="keywordList"></div>
<style type="text/css">
	.keypan{
		height: 235px;
		border: 1px solid #ddd
	}
</style>
<script type="text/javascript">

var keywords = [
	{
		"title":"PART OF THE COMMON GOOD",
		"body":"Anything we do belongs to the commons, by the people for the people."
	},
	{
		"title":"OPEN AS IN OPEN SOURCE",
		"body":"Anything we do belongs to the commons, by the people for the people."
	},
	{
		"title":"FREE AS IN FREEDOM",
		"body":"You have ."
	},
	{
		"title":"1st RULE is respect...",
		"body":"Respect others"+
			"<br/>No insulting"+
			"<br/>No ..."+
			"<br/>..."+
			"<br/>..."
	},
	{
		"title":"We don't beleive in publicity",
		"body":"It makes fake & capitalistic society"+
				"<br/>why would does who can pay get more than does who can't ?"
	},
	{
		"title":"You're not a PRODUCT",
		"body":"Your data is your and only your property."
	},
	{
		"title":"data protected",
		"body":"We will do our best to protect whatever data is on our plateform."
	},
	{
		"title":"linked & opendata",
		"body":"we build Opendata."+
				"<br/> Data about cities"+
				"<br/>..."
	},
	{
		"title":"interoperable",
		"body":"we build to share."+
				"<br/> so we have APIs to connect"+
				"<br/> to translate into many ontologies"
	},
	{
		"title":"Connected Territories",
		"body":"we build Opendata."+
				"<br/> Data about cities"+
				"<br/>..."
	},
	{
		"title":"Collective Intelligence",
		"body":"..."
	},
	{
		"title":"Collaborative Economy",
		"body":"..."
	},
];
	
jQuery(document).ready(function() 
{
	$(".keywordList").html('');
	$.each(keywords,function(i,obj) { 
		icon = (obj.icon) ? obj.icon : "fa-legal" ;
		color = (obj.color) ? obj.color : "#E33551" ;
		$(".keywordList").append(
		'<div class="col-xs-4"><div class="keypan panel panel-white">'+
			'<div class="panel-heading border-light ">'+
				'<span class="panel-title homestead"> <i class="fa '+icon+'  fa-2x"></i> <span style="font-size: 35px; color:'+color+';"> '+obj.title.toUpperCase()+'</span></span>'+
			'</div>'+
			'<div class="panel-body">'+
					obj.body+
			"</div>"+
		"</div></div>");
	 });
});

</script>