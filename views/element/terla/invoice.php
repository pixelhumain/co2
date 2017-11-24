<?php
$cs = Yii::app()->getClientScript();
$cssAnsScriptFilesModule = array(
		//'/plugins/JSzip/jszip.min.js',
		'/plugins/FileSaver.js/FileSaver.min.js',
		//'/assets/js/sig/geoloc.js',
		/*'/assets/js/dataHelpers.js',
		'/assets/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
		'/assets/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js'*/
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->request->baseUrl);
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
<div class="headerList col-md-12 col-sm-12 no-padding margin-bottom-20 margin-top-20">
	<div class="col-md-12 col-sm-12 text-center">
		<h4 class="col-md-12 letter-orange">List of invoices</h2>
	</div>
    <ul id="columnList" class="col-md-3 col-sm-3 col-xs-3 no-padding">
        <?php
            foreach ($orders as $key => $value){  ?>
                <li class="columnSection padding-10" data-id="<?php echo $key ?>">
                    <h4 class="title no-margin">
                        <a href="javascript:;" onclick="pdf('<?php echo $key ?>');" >
                            <i class='fa fa-file-pdf-o'></i> <?php echo $value["name"] ?>
                        </a>
                    </h4>
                </li>
        <?php
        } ?>
    </ul>
    <div id="pdfInvoice" class="col-md-9 col-sm-9 col-xs-9 pull-right">

	</div>
</div>

<script type="text/javascript">

var orders = <?php echo json_encode(@$orders); ?>; 

jQuery(document).ready(function() {
   
});


function pdf(id){
	var params = {
		order : orders[id],
		person : contextData
	};

	$.ajax({
		type: 'POST',
		data: params,
		url: baseUrl+'/'+moduleId+'/pdf/create',
		dataType : 'json',
		async : false,
		success: function(data){
			mylog.log("stepTwo data",data);
			saveAs(data, "StandardForCommunecter.pdf");
		}
	});

	//ajaxPost('#pdfInvoice', baseUrl+'/'+moduleId+'/pdf/create', params, function(){},"html");
}

</script>