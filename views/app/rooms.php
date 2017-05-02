<?php 
	//HtmlHelper::registerCssAndScriptsFiles( array('', ) , Yii::app()->theme->baseUrl. '/assets');
	//$cssAnsScriptFilesModule = array('');
	//HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "page") ); 
?>


<div class="col-md-12 col-sm-12 col-xs-12 no-padding social-main-container">
	<div class="padding-top-15" id="onepage"></div>
</div>


<script type="text/javascript" >

var type = "<?php echo $type; ?>";
var id = "<?php echo $id; ?>";
var view = "<?php echo @$view; ?>";
var indexStepGS = 20;

jQuery(document).ready(function() {
	
	initKInterface({"affixTop":0});
	$("#mainNav").addClass("affix");
	
	var tpl = '<?php echo @$_GET["tpl"] ? $_GET["tpl"] : "profilSocial"; ?>';
	getAjax('#onepage' ,baseUrl+'/'+moduleId+"/rooms/index/type/"+type+"/id/"+id,function(){ 
		initPageInterface();
	},"html");
});


function initPageInterface(){

	$("#second-search-bar").addClass("input-global-search");

    $("#main-btn-start-search, .menu-btn-start-search").click(function(){
        startGlobalSearch(0, indexStepGS);
    });

    $("#second-search-bar").keyup(function(e){
        $("#input-search-map").val($("#second-search-bar").val());
        if(e.keyCode == 13){
            startGlobalSearch(0, indexStepGS);
         }
    });
    
    $("#input-search-map").keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            startGlobalSearch(0, indexStepGS);
         }
    });

    $("#menu-map-btn-start-search").click(function(){
        startGlobalSearch(0, indexStepGS);
    });

    $(".social-main-container").mouseenter(function(){
    	$(".dropdown-result-global-search").hide();
    });

    //$(".dropdown-result-global-search").hide();
    

}

</script>