<div class="panel-heading border-light center text-dark partition-white radius-10">
	<span class="panel-title homestead"> <i class='fa fa-envelope-o faa-pulse animated fa-3x  '></i> <span style="font-size: 48px">CONTACT</span></span>
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
		"icon" : "fa-envelope-o",
		"title":"BY MAIL : <br/>contact @ communecter.org",
		"class" : "keypan"
	},
	{
		"icon" : "fa-phone",
		"title":"BY PHONE : <br/>00262-262343686",
		"class" : "keypan"
	},
	{
		"icon" : "fa-paper-plane-o",
		"title":"BY PAPER AIRPLANE<br/>good luck !!",
		"class" : "keypan"
	},
	{
		"icon" : "fa-github",
		"title":" <a href='https://github.com/pixelhumain' target='_blank'>ON GITHUB</a>"
	},
	{
		"icon" : "fa-bookmark-o",
		"title":" <a href='https://groups.diigo.com/group/pixelhumain' target='_blank'>BY DIIGO</a> "
	},
	{
		"icon" : "fa-google-plus",
		"title":" <a href='https://plus.google.com/u/0/communities/111483652487023091469' target='_blank'>BY GOOGLE+ </a> "
	},
	{
		"icon" : "fa-facebook-square",
		"title":"<a href='https://www.facebook.com/groups/pixelhumain/' target='_blank'>BY FACEBOOK </a> "
	},
	{
		"icon" : "fa-twitter",
		"title":"<a href='https://www.twitter.com/pixelhumain/' target='_blank'>BY TWITTER</a> "
	},
	{
		"icon" : "fa-twitter",
		"title":"<a href='https://mamot.fr' target='_blank'>BY MASTODON</a> "
	}
];
	
jQuery(document).ready(function() 
{
	$(".keywordList").html('');
	$.each(keywords,function(i,obj) { 
		var icon = (obj.icon) ? obj.icon : "fa-tag" ;
		var color = (obj.color) ? obj.color : "#E33551" ;
		var body = (obj.body) ? obj.body : null ;
		var classo = (obj.class) ? obj.class : "" ;
		var str = '<div class="col-sm-4"><div class="'+classo+' panel panel-white ">'+
			'<div class="panel-heading border-light ">'+
				'<span class="panel-title homestead"> <i class="fa '+icon+'  fa-2x"></i> <span style="font-size: 35px; color:'+color+';"> <br/>'+obj.title+'</span></span>'+
			'</div>';
		if(body)
			str += '<div class="panel-body">'+
					body+
			"</div></div></div>";
		$(".keywordList").append(str);
	 });
});

</script>

