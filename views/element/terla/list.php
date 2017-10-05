<?php

HtmlHelper::registerCssAndScriptsFiles( 
	array(  	
		'/js/comments.js',
	) , 
	Yii::app()->theme->baseUrl. '/assets');
$cssAnsScriptFilesTheme = array(
	'/plugins/jquery-bar-rating/jquery.barrating.js',
	'/plugins/font-awesome/css/font-awesome.min.css',
	'/plugins/jquery-bar-rating/fontawesome-stars.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>
<style type="text/css">
	.contentListItem:nth-child(2n+1){
		background-color: white;
	}
	.contentListItem:nth-child(2n){
		background-color: lightgray;
	}
	.contentListItem:nth-child(2n) .contentImg{
		background-color: white;
		color:lightgray;
	}
	.contentListItem:nth-child(2n+1) .contentImg{
		background-color: lightgray;
		color:white;
	}
	.contentListItem .contentImg{
		min-height: 100px;
		line-height: 100px;
	}
	.contentListItem .contentImg > i {
		vertical-align: middle;
	}
	.contentListItem .contentImg > img {
		height:100px;
	}
	.contentListItem .linkBtnList{
		position: absolute;
	    right: 30px;
	    bottom: 10px;
	    min-width: 170px;
	    border-radius: 2px;
	    padding: 5px;
	}
	.headerList h4{
		font-size: 20px;
	}

	.headerList p{
		font-size: 18px;
	}
	.contentRatingComment textarea{
		min-height: 100px;
	}
</style>
<?php if($actionType=="manage"){ ?>
<div class="headerList col-md-12 col-sm-12 no-padding margin-bottom-20 margin-top-20">
	<div class="col-md-12 col-sm-12 text-center">
		<h4 class="col-md-12 letter-orange">Add products and services you want to offered</h2>
		<p>
			These products and services will be validated by the team of terla
		</p>
		<button data-form-type="product"  
                    data-dismiss="modal"
                    class="btn btn-link btn-open-form col-xs-6 col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2 col-lg-4 text-orange">
                <h6><i class="fa fa-shopping-basket fa-2x"></i><br> <?php echo Yii::t("common", "Product") ?></h6>
                <small><?php echo Yii::t("form","Food, hand-made, jewelery...<br>Sell your product here") ?></small>
            </button>
            <button data-form-type="organization" data-form-subtype=""  
                    data-dismiss="modal"
                    class="btn btn-link btn-open-form col-xs-6 col-sm-4 col-md-4 col-lg-4 text-green">
                <h6><i class="fa fa-sun-o fa-2x"></i><br> <?php echo Yii::t("common", "Services") ?></h6>
                <small><?php echo Yii::t("form","Hostel, funny activity, food, guide...<br>Purpose your services here !") ?></small>
            </button>
	</div>
</div>
<?php } ?>
<div id="listList" class="col-md-12 col-sm-12">
</div>
	<script type="text/javascript">
	var type = "<?php echo $type; ?>";
	var id = "<?php echo $id; ?>";
	var view = "<?php echo @$view; ?>";
	var indexStepGS = 20;
	var listElement = <?php echo json_encode( $list ); ?>;
	var actionType="<?php echo $actionType ?>";
	jQuery(document).ready(function() {
		list.initList(listElement, actionType);
		$(".btn-open-form").click(function(){
			dyFObj.openForm("product","sub");
		});
		bindLBHLinks();
	})
	/*function initList(){
		var viewList="";
		$.each(list, function(e,v){
			viewList+="<h4 class='listSubtitle col-md-12 col-sm-12 col-xs-12 letter-orange'>"+Object.keys(v).length+" "+e+"</h4>";
			$.each(v, function(i, data){
				viewList+=getListOf(e,data);	
			});
			$("#listList").append(viewList)
			
		});
	}
	function getListOf(type,data){
		data.imgProfil = ""; 
    	if(!data.useMinSize)
        	data.imgProfil = "<i class='fa fa-image fa-3x'></i>";
   		if("undefined" != typeof data.profilMediumImageUrl && data.profilMediumImageUrl != "")
        	data.imgProfil= "<img class='img-responsive' src='"+baseUrl+data.profilMediumImageUrl+"'/>";
		str="<div class='col-md-12 col-sm-12 contentListItem padding-5'>"+
				"<div class='col-md-2 col-sm-2 contentImg text-center no-padding'>"+
					data.imgProfil+
				"</div>"+
				"<div class='col-md-10 col-sm-10 listItemInfo'>"+
					"<div class='col-md-10 col-sm-10'>"+
						"<h4>"+data.name+"</h4>"+
						"<span>Price: "+data.price+"</span><br/>";
						if(typeof data.toBeValidated != "undefined")
						str+="<i class='text-azul'>Waiting for validation</i>";
		str+=		"</div>"+
					"<div class='col-md-2 col-sm-2'>"+
						
					"</div>"+
				"</div>"+
				"<a href='#page.type."+type+".id."+data._id.$id+"' class='lbh btn bg-orange linkBtnList'>Manage it</a>"+
			"</div>";
		return str;
	}*/
</script>