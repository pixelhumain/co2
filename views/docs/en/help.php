<div class="panel-heading border-light center text-dark partition-white radius-10 ">
	<span class="panel-title"> <i class='fa fa-support  fa-2x  '></i> <span style="font-size: 48px">Help we need, help is welcome</span></span>
</div>
<div class="space20"></div>
<div class="keywordList"></div>
<style type="text/css">
	.list {
		list-style: none;
	}
	.list li{
		float:left;
		padding-left: 15px;
		font-weight: bold;
		padding: 7px;
		border: 1px solid white;
	}
</style>
<script type="text/javascript">
var keywords = [
	{
		"icon" : "fa-support",
		"title":"I NEED SOME HELP",
		"body":"<a class='btn btn-default text-dark bold' href='' >CONTACT US ANY TIME</a>"
	},
	{
		"icon" : "fa-smile-o",
		"title":"I WANNA HELP YOU",
		"body":"<a class='btn btn-default text-dark bold' href='' >HELP US BUILD A BETTER PLACE</a>"
	},
	{
		"icon" : "fa-hand-o-up",
		"title":"GET INVOLVED",
		"body":"All sorts of tasks : <br/>"+
				"<ul class='list'><li> DEVS </li>"+
				"<li> ARTISTS : design, write a song, write for change</li>"+
				"<li> COMMUNICATION </li>"+
				"<li> COMMONERS</li>"+
				"<li> JURISTS</li>"+
				"<li> BUILDERS</li>"+
				"<li> THINKERS</li>"+
				"<li> FINANCERS</li>"+
				"<li> BUILDERS</li>"+
				"<li> ARCHITECTS</li>"+
				"<li> CONNECTORS</li>"+
				"<li> INVENTORS</li>"+
				"<li> TRAVELLERS</li>"+
				"<li> MAKERS</li>"+
				"</ul>"
	},
	{
		"icon" : "fa-users",
		"title":"MEETUP SESSIONS",
		"body":"Different sessions for different things : <br/>"+
				"We meet up on skype or Hangout <br/>"+
				"<ul><li>Scrum dev sessions : daylee</li>"+
				"<li>Sessions for all : every 15j to talk globally about the project</li>"+
				"<li>Demo session : specific sub milestones</li>"+
				"</ul>"
	},
];
	
jQuery(document).ready(function() 
{
	$(".keywordList").html('');
	$.each(keywords,function(i,obj) { 
		var icon = (obj.icon) ? obj.icon : "fa-tag" ;
		var color = (obj.color) ? obj.color : "#E33551" ;
		var body = (obj.body) ? obj.body : null ;
		var str = '<div class="col-md-6 col-sm-12 "><div class="panel bg-dark text-white ">'+
			'<div class="panel-heading border-light ">'+
				'<span class="panel-title homestead"> <i class="fa '+icon+'  fa-2x"></i> <span style="font-size: 35px; "><br/>'+obj.title+'</span></span>'+
			'</div>';
		if(body)
			str += '<div class="panel-body ">'+body+"</div>"+
		"</div></div>";
		$(".keywordList").append(str);
	 });
});

</script>

