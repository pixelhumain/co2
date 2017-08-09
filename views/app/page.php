<?php 
	HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css') , Yii::app()->theme->baseUrl. '/assets');
	//$cssAnsScriptFilesModule = array('');
	//HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
    
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu

    if($this->module->id != "network")
        $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "page") ); 
?>


<div class="col-md-12 col-sm-12 col-xs-12 no-padding social-main-container">
	<div class="padding-top-15" id="onepage">
		<?php 
        
            if($type == Person::COLLECTION  || $type == Event::COLLECTION || 
               $type == Project::COLLECTION || $type == Organization::COLLECTION){
    			$params = array("element"=>$element , 
    							"page" => "page",
    							"edit"=>$edit,
    							"openEdition" => $openEdition,
    							"linksBtn" => $linksBtn,
    							"type" => $type,
    							"isLinked" => $isLinked,
    							"controller" => $controller,
    							"countStrongLinks" => $countStrongLinks,
    							"countInvitations" => $countInvitations,
    							"countries" => $countries );

                if(@$members) $params["members"] = $members;
                if(@$invitedMe) $params["invitedMe"] = $invitedMe;

                $this->renderPartial('../element/profilSocial', $params ); 
            }


            if($type == News::COLLECTION){
                $params = array("element"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                if(@$members) $params["members"] = $members;
                if(@$invitedMe) $params["invitedMe"] = $invitedMe;

                $this->renderPartial('../news/standalone', $params ); 
            }

            if($type == Classified::COLLECTION){
                $params = array("element"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                if(@$members) $params["members"] = $members;
                if(@$invitedMe) $params["invitedMe"] = $invitedMe;

                $this->renderPartial('../classified/standalone', $params ); 
            }

            if($type == Survey::COLLECTION){
                $params = array("survey"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                $this->renderPartial('../survey/entryStandalone', $params ); 
            }

            if($type == Poi::COLLECTION){
                $params = array("element"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                $this->renderPartial('../poi/standalone', $params ); 
            }
		?>
	</div>
</div>


<script type="text/javascript" >

var type = "<?php echo $type; ?>";
var id = "<?php echo $id; ?>";
var view = "<?php echo @$view; ?>";
var indexStepGS = 20;

jQuery(document).ready(function() {
	
	initKInterface({"affixTop":0});
	$("#mainNav").addClass("affix");
	initPageInterface();
    // var tpl = '<?php //echo @$_GET["tpl"] ? $_GET["tpl"] : "profilSocial"; ?>';
	// getAjax('#onepage' ,baseUrl+'/'+moduleId+"/element/detail/type/"+type+"/id/"+id+"/view/"+view+"?tpl="+tpl,function(){ 
	// 	initPageInterface();
	// },"html");
});


function initPageInterface(){

	$("#second-search-bar").addClass("input-global-search");

    $("#main-btn-start-search, .menu-btn-start-search").click(function(){
        startGlobalSearch(0, indexStepGS);
    });

    $("#second-search-bar").keyup(function(e){ console.log("keyup #second-search-bar");
        $("#input-search-map").val($("#second-search-bar").val());
        if(e.keyCode == 13){
            startGlobalSearch(0, indexStepGS);
         }
    });
    
    $("#input-search-map").keyup(function(e){ console.log("keyup #input-search-map");
        $("#second-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            startGlobalSearch(0, indexStepGS);
         }
    });

    $("#menu-map-btn-start-search").click(function(){
        $("#second-search-bar").val($("#input-search-map").val());
        startGlobalSearch(0, indexStepGS);
    });

    $(".social-main-container").mouseenter(function(){
    	$(".dropdown-result-global-search").hide();
    });

    $(".tooltips").tooltip();
   
    $('.sub-menu-social').affix({
      offset: {
          top: 320
      }
    });
    //$(".dropdown-result-global-search").hide();
    

}

</script>