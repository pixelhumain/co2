<?php 
    
    $this->renderPartial("../news/newsAssets");

	HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css') , Yii::app()->theme->baseUrl. '/assets');
	//$cssAnsScriptFilesModule = array('');
	//HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
    
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu

    if($this->module->id != "network" && 
        ($type!=Product::COLLECTION || 
        ($element["creator"]==Yii::app()->session["userId"] && $view != "show")))
    //le param USEHEADER de params.json sert à afficher ou non le header, 
    //donc normalement pas besoin de faire de IF ici
        $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "page",
                                "dontShowMenu"=>true,
                                "useFilter"=>false) ); 
?>

<div class="col-md-12 col-sm-12 col-xs-12 no-padding social-main-container">
	<div class="" id="onepage">
		<?php 
            $params = CO2::getThemeParams();
            $onepageKey = $params["onepageKey"];
        
            if($type == Person::COLLECTION  || $type == Event::COLLECTION || 
               $type == Project::COLLECTION || $type == Organization::COLLECTION || 
               $type == Place::COLLECTION){
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
                if(Yii::app()->params["CO2DomainName"] == "terla")
                    $this->renderPartial('../element/terla/index', $params );
                else if(in_array($view, $onepageKey)) 
                    $this->renderPartial("../element/onepage", $params);
                else 
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

            if($type == Product::COLLECTION){
                $params = array("element"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                if(@$members) $params["members"] = $members;
                if(@$invitedMe) $params["invitedMe"] = $invitedMe;
                if(($element["creator"]==Yii::app()->session["userId"] || @Yii::app()->session["superAdmin"]) && $view != "show")
                    $this->renderPartial('../element/terla/dashboard', $params );
                else
                    $this->renderPartial('../element/standalone', $params ); 
            }
            if($type == Service::COLLECTION){
                $params = array("element"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                if(@$members) $params["members"] = $members;
                if(@$invitedMe) $params["invitedMe"] = $invitedMe;
                if($element["creator"]==Yii::app()->session["userId"] && $view != "show")
                    $this->renderPartial('../element/terla/dashboard', $params );
                else
                    $this->renderPartial('../element/standalone', $params ); 
            }
            if($type == Survey::COLLECTION){
                $params = array("survey"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                $this->renderPartial('../survey/entryStandalone', $params ); 
            }

            if($type == Classified::COLLECTION){
                $params = array("element"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                if(@$members) $params["members"] = $members;
                if(@$invitedMe) $params["invitedMe"] = $invitedMe;

                $this->renderPartial('eco.views.co.standalone', $params ); 
                
            }

            if($type == Ressource::COLLECTION){
                $params = array("element"=>$element , 
                                "page" => "page",
                                "type" => $type,
                                "controller" => $controller,
                                );

                if(@$members) $params["members"] = $members;
                if(@$invitedMe) $params["invitedMe"] = $invitedMe;

                $this->renderPartial('ressources.views.co.standalone', $params ); 
                
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
            searchObject.text=$(this).val();
            myScopes.type="open";
            myScopes.open={};
            //urlCtrl.loadByHash("#search");
            startGlobalSearch(0, indexStepGS);
         }
    });
     $("#second-search-bar-addon").off().on("click", function(){
        $("#input-search-map").val($("#second-search-bar").val());
        searchObject.text=$("#second-search-bar").val();
        myScopes.type="open";
        myScopes.open={};
            //urlCtrl.loadByHash("#search");
            startGlobalSearch(0, indexStepGS);
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