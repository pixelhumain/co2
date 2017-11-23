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
	#columnList{
		bottom: 0px;
		list-style: none;
		border-right: 1px solid rgba(0,0,0,0.1);
		min-height: 300px
	}
	#columnList li:hover{
		cursor:pointer;
		background-color:rgba(0,0,0,0.1);
		border-left: 4px solid #FF9E85;
	}
	#columnList li{
		border-left: 4px solid white;
	}
	/*#orderList li.active:hover{
		background-color: yellow;
	}*/
	.columnSection .title{
		font-size: 18px;
		font-weight: 100;
		text-transform: inherit;
	}
	#columnList li.active{
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
                <h5><i class="fa fa-shopping-basket fa-2x"></i><br> <?php echo Yii::t("common", "Product") ?></h5>
                <small><?php echo Yii::t("form","Food, hand-made, jewelery...<br>Sell your product here") ?></small>
            </button>
            <button data-form-type="service" data-form-subtype=""  
                    data-dismiss="modal"
                    class="btn btn-link btn-open-form col-xs-6 col-sm-4 col-md-4 col-lg-4 text-green">
                <h5><i class="fa fa-sun-o fa-2x"></i><br> <?php echo Yii::t("common", "Services") ?></h5>
                <small><?php echo Yii::t("form","Hostel, funny activity, food, guide...<br>Purpose your services here !") ?></small>
            </button>
	</div>
</div>
<?php } ?>
<?php if(($actionType=="history" || $actionType=="backup") && !empty($parentList)){ ?>
	<ul id="columnList" class="col-md-3 col-sm-3 col-xs-3 no-padding">
		
		<?php $i=0;
			foreach ($parentList as $key => $value){ 
				if($i==0){
					$nameHeader=$value["name"];
					$priceHeader=@$value["totalPrice"];
					$currencyHeader=@$value["currency"];
					if(@$value["countOrderItem"])
						$countHeader=$value["countOrderItem"];
					else{
						$firstId=$key;
						$countHeader=$value["object"]["countQuantity"];
					}
				}
				if(@$value["countOrderItem"])
					$count=$value["countOrderItem"];
				else
					$count=$value["object"]["countQuantity"];
				//$idOrder=(string)$value["_id"];
				?>
				<li class="columnSection <?php if($i==0) echo "active" ?> columnSection<?php echo $key ?> padding-10" data-id="<?php echo $key ?>">
					<h4 class="title no-margin"><?php echo $value["name"] ?></h4>
					<span><i><?php echo $count; ?> purchase<?php if ($count >1) echo "s" ?></i></span>
				</li>
		<?php $i++; 
		} ?>
	</ul>
	<div id="headerList" class="col-md-9 col-sm-9 col-xs-9 margin-bottom-20">
		<h4 class="col-md-12 col-sm-12 title no-padding letter-orange"><?php echo $nameHeader ?></h4>
		<span>Price of this command: <span class="price"><?php echo $priceHeader ?> <?php echo $currencyHeader ?></span></span> 
		<a href="<?php echo Yii::app()->createUrl('/co2/pdf/create/id/'.$key) ;?>" target="_blank">
			<i class='fa fa-file-pdf-o'></i>
		</a><br/>
		<span class="purchases"><i><?php echo $countHeader; ?> purchase<?php if ($countHeader >1) echo "s" ?></i></span>
		
		<?php if($actionType=="backup") { ?>
			<div class="pull-right">
				<a href="javascript:;" id="goBackToThisCart" class="btn btn-success" data-id="<?php echo $key ?>">Continue this cart</a>
				<a href="javascript:;" id="deleteBackup" class="btn btn-danger" data-id="<?php echo $key ?>">Delete</a>
			</div>
		<?php } ?>
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
	var actionType="<?php echo $actionType ?>";
	var parentList= <?php echo json_encode( @$parentList ); ?>;
	if(actionType=="backup")
		var listElement = parentList["<?php echo @$firstId ?>"].object;
	else
		var listElement = <?php echo json_encode( $list ); ?>;
	jQuery(document).ready(function() {
		list.initList(listElement, actionType);
		$(".btn-open-form").click(function(){
			dyFObj.openForm($(this).data("form-type"),"sub");
		});
		bindLBHLinks();
		if(actionType=="history" || actionType=="backup")
			initOrderEvent();
		if(actionType=="backup")
			initBackupEvent();
	})
	function initOrderEvent(){
		$(".columnSection").click(function(){
			showLoader('#listList');
			$(".columnSection").removeClass("active");
			$(this).addClass("active");
			parentId=$(this).data("id");
			$("#headerList .title").text(parentList[parentId].name);
			$("#headerList .price").text(parentList[parentId].totalPrice+" "+parentList[parentId].currency);
			s=(parentList[parentId].countOrderItem > 1) ? "s": "";
			$("#headerList .purchases").text(parentList[parentId].countOrderItem+" purchase"+s);
			if(actionType=="history"){
				$.ajax({
					type: "POST",
					url: baseUrl+"/"+moduleId+"/order/get/id/"+parentId, 
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
			}else{
				$("#headerList #goBackToThisCart").data("id",parentId);
				$("#headerList #deleteBackup").data("id",parentId);
				list.initList(parentList[parentId].object, actionType);
			}
		});
	}
	function initBackupEvent(){
		$("#deleteBackup").click(function(){
			var idBackup=$(this).data("id");
			bootbox.dialog({
		        onEscape: function() {
		            //$(".disconnectBtnIcon").removeClass("fa-spinner fa-spin").addClass("fa-unlink");
		        },
		        message: '<div class="row">  ' +
		            '<div class="col-md-12"> ' +
		            '<span>Are you sure to delete this backup ?</span> ' +
		            '</div></div>',
		        buttons: {
		            success: {
		                label: "Ok",
		                className: "btn-primary",
		                callback: function () {
		                    $.ajax({
								type: "POST",
								url: baseUrl+"/"+moduleId+"/backup/delete/id/"+idBackup,
								//data : formData,
								dataType: "json",
								success: function(data){
									if ( data && data.result ) {
										loadBackup();
										toastr.error("The backup has been deleted with success");
									} else {
									   toastr.error("Something went wrong");
									}
								}
							});
		                }
		            },
		            cancel: {
		            	label: trad.cancel,
		            	className: "btn-secondary",
		            	callback: function() {
		            		//$(".disconnectBtnIcon").removeClass("fa-spinner fa-spin").addClass("fa-unlink");
		            	}
		            }
		        }
		    });      
		});
		$("#goBackToThisCart").click(function(){
			var idBackup=$(this).data("id");
			bootbox.dialog({
		        onEscape: function() {
		            //$(".disconnectBtnIcon").removeClass("fa-spinner fa-spin").addClass("fa-unlink");
		        },
		        message: '<div class="row">  ' +
		            '<div class="col-md-12"> ' +
		            '<span>If you have a current cart, it will be destroyed... Are you sure to continue ?</span> ' +
		            '</div></div>',
		        buttons: {
		            success: {
		                label: "Ok",
		                className: "btn-primary",
		                callback: function () {
		                    shopping.cart=parentList[idBackup].object;
		                    shopping.cart.backup=idBackup;
		                    shopping.countShoppingCart("init");
							localStorage.setItem("shoppingCart",JSON.stringify(shopping.cart));
							smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/person/shoppingcart");
							//urlCtrl.loadByHash("#person.shoppingcart");
		                }
		            },
		            cancel: {
		            	label: trad.cancel,
		            	className: "btn-secondary",
		            	callback: function() {
		            		//$(".disconnectBtnIcon").removeClass("fa-spinner fa-spin").addClass("fa-unlink");
		            	}
		            }
		        }
		    });      
		});
	}
</script>