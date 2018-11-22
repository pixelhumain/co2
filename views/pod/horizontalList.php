<style type="text/css">
	.containerStatus{
		width: 100%;
		display: inline-block;
		background: none;
	}
	.containerStatus .imageProfil{
		margin-top: 10px;
	    width: 13%;
	    line-height: 60px;
	    height: 60px;
	    display: inline-block;
	    position: relative;
	}
	.containerStatus .imageProfil img{
		-webkit-box-shadow: 0 0px 3px rgba(0, 0, 0, 0.75);
    	box-shadow: 0 0px 3px rgba(0, 0, 0, 0.75);
	}
	.containerStatus .userInfo{
		display: inline-block;
		width: 87%;
		height: 60px;
	}	
	.userReactionList{   
	    position: absolute;
	    right:3px;
	    bottom: 3px;
	}
	
</style>
<div class="listView">
	<div class="menuList">		
	</div>
	<div class="contentListView">
	</div>
</div>
<script type="text/javascript">
	var community=<?php echo json_encode(@$vote) ?>;
	var count=<?php echo json_encode(@$voteCount) ?>;
	jQuery(document).ready(function() {
		var sectionHtmlCount = '';
        totalReaction=0;
        $.each(count, function(e, v){
        	sectionHtmlCount+= "<a href='javascript:;' onclick='filteringReaction(\""+e+"\");' class='btn btn-default menuListBtn'><div class='emojiconnews "+e+" pull-left'></div> "+v+"</a>";
            totalReaction=totalReaction+v;
        });
        sectionHtmlCount += "<a href='javascript:;' onclick='filteringReaction(false);' class='btn btn-default menuListBtn pull-left active'>"+trad.all+" "+totalReaction+"</a>";
        $(".listView .menuList").html(sectionHtmlCount);
        communityHtml="";
        $.each(community, function(e,v){
        	communityHtml+="<div class='containerStatus "+v.status+"'>"+
        		"<div class='imageProfil text-center'><img src='"+baseUrl+"/"+v.profilThumbImageUrl+"' class='img-circle'/><div class='userReactionList "+v.status+"'></div></div>"+
        		"<div class='userInfo bold'>"+
        			"<a href='"+baseUrl+"/#@"+v.slug+"' target='_blank'>"+v.name+"</a>"+
        		"</div>"+
        	"</div>";
        });
        $('.listView .contentListView').html(communityHtml);
	});
	function filteringReaction(status){
		if(!status)
			$(".containerStatus").show(700);
		else{
			$(".containerStatus").hide(700);
			$(".containerStatus."+status).show(300);
		}
	}
</script>