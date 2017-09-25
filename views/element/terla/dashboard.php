
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
<div class="headerTitleStanalone"><span>Mon tableau de bord</span> <button class="backTravel">Back to my traveller account<button></div>
<div class="col-md-10 col-md-offset-1 contentOnePage">
	<div class="col-md-12 no-padding margin-bottom-20 margin-top-20">
		<div class="col-md-12 bg-lightgray">
			<h2 class="col-md-12 letter-blue-2">Ajouter vos produits et services</h2>
			<div class="row col-md-10">	
				<p>Ces produits et services sont soumis à une validation du site pour authentifier vos propositions avant publications
				</p>
			</div>
			<button data-form-type="product"  
	                    data-dismiss="modal"
	                    class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-red">
	                <h6><i class="fa fa-university fa-2x bg-red"></i><br> <?php echo Yii::t("common", "Product") ?></h6>
	                <small><?php echo Yii::t("form","Town hall, schools, etc...<br>Share your news<br>Share events") ?></small>
	            </button><button data-form-type="organization" data-form-subtype="<?php echo Organization::TYPE_GOV; ?>"  
	                    data-dismiss="modal"
	                    class="btn btn-link btn-open-form col-xs-6 col-sm-6 col-md-4 col-lg-4 text-red">
	                <h6><i class="fa fa-university fa-2x bg-red"></i><br> <?php echo Yii::t("common", "Prestation") ?></h6>
	                <small><?php echo Yii::t("form","Town hall, schools, etc...<br>Share your news<br>Share events") ?></small>
	            </button>
		</div>
	</div>
	<div class="podDash col-md-12 margin-top-20">
		<ul class="nav pull-left">
		  <li class="nav-item active">
		    <a class="nav-link" href="javascript:;" id="btn-detail"><?php echo Yii::t("common","My infos") ?></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="javascript:;" id="btn-message"><?php echo Yii::t("common","My messages") ?></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="javascript:;" id="btn-history"><?php echo Yii::t("common","Historic") ?></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="javascript:;" id="btn-backup"><?php echo Yii::t("common","Backup") ?></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="javascript:;" id="btn-invoice"><?php echo Yii::t("common","Invoice") ?></a>
		  </li>
		</ul>
		<div class="content-view-dashboard col-md-12 padding-10 bg-white">
		</div>
		
	</div>

</div>
<script type="text/javascript">
	var contextData = <?php echo json_encode( Element::getElementForJS(@$element, @$type) ); ?>; 
	var edit=true;
	jQuery(document).ready(function() {
		loadDetail(true);
		bindButtonMenu();
		$(".btn-open-form").click(function(){
			dyFObj.openForm("product");
		});
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