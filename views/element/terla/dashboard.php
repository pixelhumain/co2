<?php
HtmlHelper::registerCssAndScriptsFiles( 
	array(  	
		'/js/comments.js',
	) , 
	Yii::app()->theme->baseUrl. '/assets');
$cssAnsScriptFilesTheme = array(
	'/plugins/jquery-bar-rating/jquery.barrating.js',
	'/plugins/font-awesome/css/font-awesome.min.css',
	'/plugins/jquery-bar-rating/fontawesome-stars.css',
	'/plugins/jquery-bar-rating/fontawesome-stars-o.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>
<style type="text/css">
	.headerTitleStanalone{
		padding-top: 20px;
		padding-right: 50px;
		left:-25px;
		right:-25px;
		top:88px;
	}
	.headerTitleStanalone span{
		padding-top: 5px;
	} 
	.contentOnePage{
		margin-top: 135px;
	}
	.contentOnePage .title > h2{
		padding: 15px 0px;
    	text-transform: inherit;
    	font-size: 20px;
	}
	.podDash{
		margin-top: 40px;
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
	.emptySpan{
		height:400px;
	}
	.emptySpan span{
		font-size: 32px;
	    color: lightgrey;
	    font-weight: bolder;
	    font-family: monospace;
	    padding-top: 100px;
	    font-style: italic;
	    font-variant: small-caps;
	}
	.br-theme-fontawesome-stars-o .br-widget a{
		font-size: 35px;
	}
	#guestBookComment .footer-comments{
		background-color: inherit;
	}
	#guestBookComment .footer-comments .item-comment{
		width: 50%;
	}

	#guestBookComment .footer-comments .item-comment img{
		height: 50px !important;
	}
</style>
<div class="headerTitleStanalone">
	<span class="pull-left">Dashboard of your <?php echo $type ?> : <?php echo $element["name"] ?></span> 
	<!-- BUTTON FOR PROFESSIONAL USER USING
	<a href="#page.type.<?php echo Person::COLLECTION ?>.id.<?php echo Yii::app()->session["userId"] ?>.view.prolist" class="lbh btn bg-white margin-left-10 pull-right">
		<i class="fa fa-sign-out"></i> Back to my account</a>-->

	<!-- BUTTON FOR ADMIN MANAGAGE -->
	<?php if(@Yii::app()->session["userIsAdmin"]){ ?>
	<a href="#admin.view.services" class="lbh btn bg-white margin-left-10 pull-right">
		<i class="fa fa-sign-out"></i> Back to service list</a>
	<?php } ?>
	<a href="#page.type.<?php echo $type ?>.id.<?php echo (string)$element["_id"] ?>.view.show" class="lbhp btn bg-dark margin-left-10 pull-right" data-modalshow="<?php echo (string)$element["_id"] ?>">
		<i class="fa fa-eye"></i> Preview</a>
</div>

<div class="col-md-10 col-md-offset-1 contentOnePage">
	<?php if(@$element["toBeValidated"]){ ?>
	<div class="col-md-12 no-padding margin-bottom-10 margin-top-10">
		<div class="col-md-12 alert alert-warning text-center">
			<p class="no-margin">
				This product is waiting for validation of our team !
			</p>
		</div>
	</div>
	<?php } ?>
	<div class="podDash col-md-12 col-sm-12 col-xs-12">
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
		    <a class="nav-link" href="javascript:;" id="btn-guestbook"><?php echo Yii::t("common","Guestbook") ?></a>
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
	var hashUrlPage = "#page.type."+contextData.type+".id."+contextData.id;
	jQuery(document).ready(function() {
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
			else if(sub=="record")
				loadBackup();
			else if(sub=="guestbook")
				loadGuestbook();
		} else
			loadDetail(true);
	}
	function bindButtonMenu(){
		$("#btn-detail").click(function(){
			location.hash=hashUrlPage;
			loadDetail();
		});
		$("#btn-guestbook").click(function(){
			location.hash=hashUrlPage+".view.guestbook";
			loadGuestbook();
		});
	}
	function loadDetail(){
		initBtnDash("#btn-detail");
		var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
		showLoader('.content-view-dashboard');
		ajaxPost('.content-view-dashboard', baseUrl+'/'+moduleId+'/'+url+'?tpl=ficheInfoElement', null, function(){},"html");
	}
	function loadGuestbook(){
		initBtnDash("#btn-guestbook");
		showLoader('.content-view-dashboard');
		str=getPanelGuestbook();
		$(".content-view-dashboard").html(str);
		if(typeof contextData.averageRating != "undefined"){
			ajaxPost("#guestBookComment",baseUrl+"/"+moduleId+"/comment/index/type/"+contextData.type+"/id/"+contextData.id,
				{"filters": ["rating"]},
				function(){  
					$(".container-txtarea").hide();
			},"html");
		
			$("#ratingElement").barrating({
				theme: 'fontawesome-stars-o',
				'readonly': true,
				initialRating: contextData.averageRating
			});
		}
	}
	function showLoader(id){
		$(id).html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");
	}
	function inintDescs() {
		return true;
	}
	function initBtnDash(dom){
		$(".podDash .nav .nav-item").removeClass("active");
		$(dom).parent().addClass("active");
	}
	function descHtmlToMarkdown() {
		mylog.log("htmlToMarkdown");
	}
	function getPanelGuestbook() {
		html="<div class='col-md-12 col-sm-12 text-center'>";
			if(typeof contextData.averageRating != "undefined"){
		html+=	"<div class='col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 text-center margin-bottom-20'>"+
					"<h4 class='letter-blue-1'>Average rating of your product</h4>"+
					"<div class='br-wrapper br-theme-fontawesome-stars-o'>"+
						"<select id='ratingElement' class='ratingComments'>"+
						   	'<option value="1">1</option>'+
	                    	'<option value="2">2</option>'+
	                    	'<option value="3">3</option>'+
	                    	'<option value="4">4</option>'+
	                    	'<option value="5">5</option>'+
                  		"</select>"+
                	"</div>"+
                	"<span class='letter-orange' style='font-size:30px;'>"+contextData.averageRating+"</span>"+
                "</div>"+
                "<div id='guestBookComment' class='col-md-12 col-sm-12'></div>";
			}else
				html+=getEmptyView("rating");
		html+= "</div>"
		return html;
	}
	function getEmptyView(type) {
		html="<div class='col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 emptySpan'>"+
				"<span class='pull-left'>";
				if(type=="rating")
		html+=		"There is <br/>No comment and rating <br/>for this product";
		html+=	"</span>"+
			"</div>";
		return html;
	}
</script>