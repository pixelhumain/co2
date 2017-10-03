
<style type="text/css">
	.headerTitleStanalone{
		left:-25px;
		right:-25px;
		top:88px;
	}
	.contentOnePage{
		margin-top: 135px;
	}
	.contentOnePage .title > h2{
		padding: 15px 0px;
    	text-transform: inherit;
    	font-size: 20px;
	}
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
	.podDash .content-view-dashboard{
		min-height: 300px;
		-webkit-box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.5);
        -moz-box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.5);
    	box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.5);
    	/*position: absolute;
    	top: 50px;*/

	}
</style>
<div class="headerTitleStanalone">
	<span>Professional dashboard</span> 
	<a href="#page.type.<?php echo Person::COLLECTION ?>.id.<?php echo Yii::app()->session["userId"] ?>" class="lbh btn bg-orange margin-left-10">
		Back to my traveller account</a>
</div>
<div class="col-md-10 col-md-offset-1 contentOnePage">
	<div class="podDash col-md-12 margin-top-20">
		<ul class="nav pull-left">
		  <li class="nav-item active">
		    <a class="nav-link" href="javascript:;" id="btn-detail"><?php echo Yii::t("common","Infos") ?></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="javascript:;" id="btn-message"><?php echo Yii::t("common","Manage buy") ?></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="javascript:;" id="btn-history"><?php echo Yii::t("common","Historic") ?></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="javascript:;" id="btn-backup"><?php echo Yii::t("common","Record") ?></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="javascript:;" id="btn-invoice"><?php echo Yii::t("common","Guestbook") ?></a>
		  </li>
		</ul>
		<div class="content-view-dashboard col-md-12  col-sm-12 col-xs-12 margin-bottom-20  padding-10 bg-white">
		</div>
		
	</div>

</div>
<script type="text/javascript">
	var contextData = <?php echo json_encode( Element::getElementForJS(@$element, @$type) ); ?>; 
	var edit=true;
	var subView="<?php echo @$_GET['view']; ?>";
	jQuery(document).ready(function() {
		loadDetail(true);
		bindButtonMenu();
		getProfilSubview(subView);
		KScrollTo("#topPosKScroll");
	});
	function getProfilSubview(sub, dir){ console.log("getProfilSubview", sub, dir);
		if(sub!=""){
			if(sub=="message")
				loadMessage();
			else if(sub=="history")
				loadHistory();
			else if(sub=="backup")
				loadBackup();
			else if(sub=="invoice")
				loadInvoice();
		} else
			loadDetail(true);
	}
	function bindButtonMenu(){
		$(".nav-link").click(function(){
			$(".podDash .nav .nav-item").removeClass("active");
			$(this).parent().addClass("active");
		});

		$("#btn-detail").click(function(){
			loadDetail();
		});
		$(".btn-start-newsstream").click(function(){
			//$(".ssmla").removeClass('active');
			responsiveMenuLeft(true);
			location.hash=hashUrlPage
			//history.pushState(null, "New Title", hashUrlPage);
			loadNewsStream(true);
		});
		$(".btn-start-mystream").click(function(){
			//$(".ssmla").removeClass('active');
			responsiveMenuLeft(true);
			if(contextData.type=="citoyens" && userId==contextData.id){
				location.hash=hashUrlPage+".view.mystream";
				//history.pushState(null, "New Title", hashUrlPage+".view.mystream");
			}
			else{
				location.hash=hashUrlPage;
				//history.pushState(null, "New Title", hashUrlPage);
			}
			loadNewsStream(false);
			uiCoop.closeUI(false);
		});
	}
	function loadDetail(){
		var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
		showLoader('.content-view-dashboard');
		ajaxPost('.content-view-dashboard', baseUrl+'/'+moduleId+'/'+url+'?tpl=ficheInfoElement', null, function(){},"html");
	}
	function showLoader(id){
		$(id).html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");
	}
	function inintDescs() {
		return true;
	}

	function descHtmlToMarkdown() {
		mylog.log("htmlToMarkdown");
	}
</script>