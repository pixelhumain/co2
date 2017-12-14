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
	    right: 0px;
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
		<h4 class="col-md-12 letter-orange">Add products and services you want to offered</h4>
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
<?php if(($actionType=="history" || $actionType=="backup" || $actionType=="admin")){ 
	if(empty($parentList)){ ?>
		<div id="headerList" class="col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
			<?php echo Yii::t("common","You have nothing in this section") ?> 
		</div>
	<?php }else{ ?>
	<ul id="columnList" class="col-md-3 col-sm-3 col-xs-3 no-padding">
		
		<?php $i=0;
			foreach ($parentList as $key => $value){ 
				if($i==0){
					$nameHeader=@$value["name"];
					$priceHeader=@$value["totalPrice"];
					$currencyHeader=@$value["currency"];
					if(@$value["countOrderItem"]){
						$countHeader=$value["countOrderItem"];
						$circuitId=$value["circuit"];
					}else{
						$firstId=$key;
						if(@$subType && $subType==Circuit::COLLECTION && $actionType!="backup")
							$countHeader=$value["countQuantity"];
						else
							$countHeader=$value["object"]["countQuantity"];
					}
				}

				if(@$value["countOrderItem"])
					$count=$value["countOrderItem"];
				else if(@$subType && $subType==Circuit::COLLECTION && $actionType!="backup")
					$count=$value["countQuantity"];
				else
					$count=$value["object"]["countQuantity"];
				?>
				<li class="columnSection <?php if($i==0) echo "active" ?> columnSection<?php echo $key ?> padding-10" data-id="<?php echo $key ?>">
					<h4 class="title no-margin"><?php if($actionType == "backup" && $subType == Circuit::COLLECTION) echo $value["object"]["name"]; else echo $value["name"]; ?></h4>
					<span><i><?php echo $count; ?> purchase<?php if ($count >1) echo "s" ?></i></span>
				</li>
		<?php $i++; 
		} ?>
	</ul>
	<?php if(!@$subType || $subType!=Circuit::COLLECTION){ ?>
	<div id="headerList" class="col-md-9 col-sm-9 col-xs-9 margin-bottom-20">
		<h4 class="col-md-12 col-sm-12 title no-padding letter-orange"><?php echo $nameHeader ?></h4>
		<?php if($actionType=="history"){ ?>
			<br/>
			<a href='#circuit.index.id.<?php echo $circuitId ?>.tpl.show' data-modalshow="$circuitId" 
				class="lbhp btn bg-orange pull-right" id="programView">
				<?php echo Yii::t("common", "Show programmation") ?>
			</a>
		<?php } ?>
		
		<span>
			<?php echo Yii::t("common", "Price of this command") ?> : 
			<span class="price"><?php echo $priceHeader ?> <?php echo $currencyHeader ?></span>
		</span> 

		<a href="<?php echo Yii::app()->createUrl('/co2/pdf/create/id/'.$key) ;?>" target="_blank">
			<i class='fa fa-file-pdf-o'></i>
		</a><br/>

		<span class="purchases">
			<i><?php echo $countHeader; ?> <?php echo Yii::t("common", "purchase") ?>
				<?php if ($countHeader >1) echo "s" ?>
			</i>
		</span>

		<?php if($actionType=="backup") { ?>
			<div class="pull-right">
				<a href="javascript:;" id="goBackToThisCart" class="btn btn-success" data-id="<?php echo $key ?>">
					<?php echo Yii::t("common", "Continue this cart") ?>
				</a>
				<a href="javascript:;" id="deleteBackup" class="btn btn-danger" data-id="<?php echo $key ?>">
					<?php echo Yii::t("common", "Delete") ?>
				</a>
			</div>
		<?php } ?>
	</div>
	<?php } ?>
	<div id="listList" class="col-md-9 col-sm-9 col-xs-9 pull-right">

	</div>
<?php } 
	} else { ?>
	<div id="listList" class="col-md-12 col-sm-12">

	</div>
<?php }?>
	<script type="text/javascript">
	var type = "<?php echo $type; ?>";
	var id = "<?php echo $id; ?>";
	var view = "<?php echo @$view; ?>";
	var indexStepGS = 20;
	var actionType="<?php echo $actionType ?>";
	var subType="<?php echo @$subType ?>";
	var parentList= <?php echo json_encode( @$parentList ); ?>;
	console.log("parentlist",parentList);
	if(notEmpty(parentList) && (actionType=="backup" || subType=="circuits")){
		if(actionType=="backup")
			var listComponents = parentList["<?php echo @$firstId ?>"].object;
		else if (subType=="circuits")
			var listComponents = parentList["<?php echo @$firstId ?>"];
	}else
		var listComponents = <?php echo json_encode( $list ); ?>;
	jQuery(document).ready(function() {
		if(notEmpty(listComponents)){
		if(subType=="circuits")
			getViewCircuit(listComponents, "<?php echo @$firstId ?>");
		else
			list.initList(listComponents, actionType);
		}
		bindListEvent();

	});
	function bindListEvent(){
		$(".btn-open-form").click(function(){
			dyFObj.openForm($(this).data("form-type"),"sub");
		});
		bindLBHLinks();
		if(actionType=="history" || actionType=="backup" || subType=="circuits")
			initOrderEvent();
		if(actionType=="backup")
			initBackupEvent();
	}
	function initOrderEvent(){
		$(".columnSection").off().on("click",function(){
			showLoader('#listList');
			$(".columnSection").removeClass("active");
			$(this).addClass("active");
			parentId=$(this).data("id");
			if(subType!="circuits"){
				$("#headerList .title").text(parentList[parentId].name);
				$("#headerList .price").text(parentList[parentId].totalPrice+" "+parentList[parentId].currency);
				s=(parentList[parentId].countOrderItem > 1) ? "s": "";
				$("#headerList .purchases").text(parentList[parentId].countOrderItem+" purchase"+s);
				if(actionType=="history")
					$("#headerList #programView").attr("href", "#circuit.index.id."+parentList[parentId].circuit);
			}
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
				if(subType=="circuits"){
					if(actionType=="backup")
						obj=parentList[parentId].object;
					else
						obj=parentList[parentId];
					getViewCircuit(obj, parentId);
				}
				else
					list.initList(parentList[parentId].object, actionType);
				$("#goBackToThisCart").data("id",parentId);
				$("#deleteBackup").data("id",parentId);
			}
		});
	}
	function getViewCircuit(object, id){
		data={object:object, viewRender:true, manage: actionType};
		if(actionType=="backup");
			data.backup=id;
		ajaxPost('#listList', baseUrl+'/'+moduleId+'/circuit/index', data, function(){
			bindListEvent();
		},"html");
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
										urlCtrl.loadByHash(location.hash);
										toastr.success("The backup has been deleted with success");
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
		                	setObject=parentList[idBackup].object;
		                	if(parentList[idBackup].type=="shoppingCart")
		                		shopping.restartBackup(setObject, idBackup);
		                	else if(parentList[idBackup].type=="circuits")
		                		circuit.restartBackup(setObject, idBackup);
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