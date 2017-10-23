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
	#orderList{
		bottom: 0px;
		list-style: none;
		border-right: 1px solid rgba(0,0,0,0.1);
		min-height: 300px
	}
	#orderList li:hover{
		cursor:pointer;
		background-color:rgba(0,0,0,0.1);
		border-left: 4px solid #FF9E85;
	}
	#orderList li{
		border-left: 4px solid white;
	}
	/*#orderList li.active:hover{
		background-color: yellow;
	}*/
	.orderSection .title{
		font-size: 18px;
		font-weight: 100;
		text-transform: inherit;
	}
	#orderList li.active{
		border-left: 4px solid #EF5B34;
		/*font-weight: bold;
		font-size: 20px;*/
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
            <button data-form-type="service" data-form-subtype=""  
                    data-dismiss="modal"
                    class="btn btn-link btn-open-form col-xs-6 col-sm-4 col-md-4 col-lg-4 text-green">
                <h6><i class="fa fa-sun-o fa-2x"></i><br> <?php echo Yii::t("common", "Services") ?></h6>
                <small><?php echo Yii::t("form","Hostel, funny activity, food, guide...<br>Purpose your services here !") ?></small>
            </button>
	</div>
</div>
<?php } ?>
<?php if($actionType=="history"){ ?>
	<ul id="orderList" class="col-md-3 col-sm-3 col-xs-3 no-padding">
		
		<?php $i=0;
			foreach ($orderList as $key => $value){ 
				if($i==0){
					$initHeader=$value;
				}
				$idOrder=(string)$value["_id"];
				?>
				<li class="orderSection <?php if($i==0) echo "active" ?> orderSection<?php echo $key ?> padding-10" data-id="<?php echo $key ?>">
					<h4 class="title no-margin"><?php echo $value["name"] ?></h4>
					<span><i><?php echo $value["countOrderItem"]; ?> purchase<?php if ($value["countOrderItem"] >1) echo "s" ?></i></span>
				</li>
		<?php $i++; 
		} ?>
	</ul>
	<div id="headerOrder" class="col-md-9 col-sm-9 col-xs-9 margin-bottom-20">
		<h4 class="col-md-12 col-sm-12 orderTitle no-padding letter-orange"><?php echo $initHeader["name"] ?></h4>
		<span>Price of this command: <span class="orderPrice"><?php echo $initHeader["totalPrice"] ?> <?php echo $initHeader["currency"] ?></span></span><br/>
		<span class="orderPurchases"><i><?php echo $value["countOrderItem"]; ?> purchase<?php if ($value["countOrderItem"] >1) echo "s" ?></i></span>
	</div>
	<div id="listList" class="col-md-9 col-sm-9 col-xs-9 pull-right">

	</div>
<?php } else { ?>
	<div id="listList" class="col-md-12 col-sm-12">

	</div>
<?php } ?>
	<script type="text/javascript">
	var type = "<?php echo $type; ?>";
	var id = "<?php echo $id; ?>";
	var view = "<?php echo @$view; ?>";
	var indexStepGS = 20;
	var listElement = <?php echo json_encode( $list ); ?>;
	var orderList= <?php echo json_encode( @$orderList ); ?>;
	var actionType="<?php echo $actionType ?>";
	jQuery(document).ready(function() {
		list.initList(listElement, actionType);
		$(".btn-open-form").click(function(){
			dyFObj.openForm($(this).data("form-type"),"sub");
		});
		bindLBHLinks();
		if(actionType=="history")
			initOrderEvent();
	})
	function initOrderEvent(){
		$(".orderSection").click(function(){
			showLoader('#listList');
			$(".orderSection").removeClass("active");
			$(this).addClass("active");
			orderId=$(this).data("id");
			$("#headerOrder .orderTitle").text(orderList[orderId].name);
			$("#headerOrder .orderPrice").text(orderList[orderId].totalPrice+" "+orderList[orderId].currency);
			s=(orderList[orderId].countOrderItem > 1) ? "s": "";
			$("#headerOrder .orderPurchases").text(orderList[orderId].countOrderItem+" purchase"+s);
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/order/get/id/"+orderId, 
				  success: function(data){
					if(data.result) {
						listElement = data.list;
			        	list.initList(data.list, actionType);
					}
			        else
			        	toastr.error(data.msg);  
				  },
				  dataType: "json"
			});
		});
	}
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