<?php 
    $cssAnsScriptFilesModule = array(
        '/js/default/search.js',
        //'/js/default/live.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $page = "live";
    
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath ,
                                "type" => @$type,
                                "page" => $page,
                                "dontShowMenu"=>true,
                                //"explain"=> "Live public : retrouvez tous les messages publics selon vos lieux favoris") 
                                ));
    $page = "live";
  
?>

<style>
     
	
   /* #formCreateNewsTemp .form-create-news-container{
    max-width: inherit !important;
	}
	.item-globalscope-checker.inactive{
        color:#DBBCC1 !important;
        border-bottom:0px;
        margin(top:-6px;)
    }
    .item-globalscope-checker:hover,
    .item-globalscope-checker:active,
    .item-globalscope-checker:focus{
        color:#e6344d !important;
        border-bottom:1px solid #e6344d;
        text-decoration: none !important;
    }
   


@media (min-width: 991px) {
    .subModuleTitle{
        width: 100% !important;
        margin-left: 11% !important;
    }
}*/
 #noMoreNews {
        position: relative;
        padding: 0px 40px;
        bottom: 0px;
        width: 100%;
        text-align: center;
        background: white;
    }
    #newsstream .loader,
    #noMoreNews{
       border-radius: 50px;
        margin-left: auto;
        margin-right: auto;
        display: table;
        padding: 15px;
        margin-top: 15px;
    }
</style>
<div class="row padding-10 bg-white live-container">
<?php 
        //$CO2DomainName = Yii::app()->params["CO2DomainName"];
       // if($CO2DomainName == "kgougle"){ 
           //$this->renderPartial($layoutPath.'headers/pod/'.$CO2DomainName.'/dayQuestion', array());
        //} 
    ?>

    <div class="col-md-12 col-sm-12 col-xs-12 bg-white top-page" id="" style="padding-top:0px!important;">
    	<div class="col-lg-1 col-md-1 hidden-sm hidden-xs text-right hidden-xs" id="sub-menu-left"></div>

    	<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 margin-top-10">
    		<div id="newsstream"></div>
    	</div>	
    </div>
</div>


<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array("subdomain"=>$page)); ?>


<script type="text/javascript" >

searchObject.initType="news";
var titlePage = "<?php echo @Yii::app()->session['paramsConfig']["pages"]["#".$page]["subdomainName"]; ?>";
//var loadContent = '<?php echo @$_GET["content"]; ?>';

jQuery(document).ready(function() {
	$(".subsub").hide();

	//initFilterLive();
	//showTagsScopesMin("#list_tags_scopes");
	//$("#btn-slidup-scopetags").click(function(){
     // slidupScopetagsMin();
    //});
	$('#btn-start-search').click(function(e){
		startNewsSearch(true);
    });
		
	
    
    //searchPage = true;
    initSearchObject();
	startNewsSearch(true);

    initKInterface({"affixTop":200});
    
    Sig.restartMap(Sig.map);

    $(".theme-header-filter").off().on("click",function(){
            if(!$("#filter-thematic-menu").is(":visible") || $(this).hasClass("toogle-filter"))
                $("#filter-thematic-menu").toggle();
    });
    $(".btn-news-type-filters").off().on("click", function(){
        keyType=$(this).data("key");
        searchObject.types= (keyType!="all") ? [keyType] : [];
        $(".btn-news-type-filters").removeClass("active"); 
        if(keyType!="all");
            $(this).addClass("active");
        if(keyType=="all")
            $(".dropdown-types .dropdown-toggle").removeClass("active").html(trad.type+" <i class='fa fa-angle-down'></i>");
        else    
            $(".dropdown-types .dropdown-toggle").addClass("active").html(tradCategory[$(this).data("label")]+" <i class='fa fa-angle-down'></i>");       
        startNewsSearch(true);
        KScrollTo("#content-social");
    });
    $(".btn-select-filliaire").off().on("click",function(){
        mylog.log(".btn-select-filliaire");
        var fKey = $(this).data("fkey");
        myMultiTags = {};
        tagsArray=[];
        $.each(filliaireCategories[fKey]["tags"], function(key, tag){
            tag=(typeof tradTags[tag] != "undefined") ? tradTags[tag] : tag;
            tagsArray.push(tag);
        });
        $('#tagsFilterInput').val(tagsArray).trigger("change");
    });
    $(".btn-tags-start-search").off().on("click", function(){
        searchObject.tags=($('#tagsFilterInput').val()!="") ? $('#tagsFilterInput').val().split(",") : [];
        searchObject.page=0;
        pageCount=true;
        searchObject.count=true;
        if(typeof searchObject.ranges != "undefined") searchAllEngine.initSearch();
        $(".dropdown-tags").removeClass("open");
        activeTagsFilter();
        startNewsSearch(true);
    });

    if(searchObject.text != "") $(".main-search-bar, #second-search-bar").val(searchObject.text);

    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#main-search-xs-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        
        searchObject.text=$(this).val();
        if(e.keyCode == 13 || $(this).val() == ""){
            spinSearchAddon(true);
            startNewsSearch(true); 
            KScrollTo("#content-social");
        }
    });
    $("#main-search-xs-bar").keyup(function(e){
        $("#second-search-bar").val($(this).val());
        $("#main-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        searchObject.text=$(this).val();
        if(e.keyCode == 13 || $(this).val() == ""){
            spinSearchAddon(true);
            startNewsSearch(true); 
            KScrollTo("#content-social");
        }
    })
    $("#second-search-bar").keyup(function(e){
        $(".main-search-bar").val($(this).val());
        $("#input-search-map").val($(this).val());
        searchObject.text=$(this).val();
        if(e.keyCode == 13 || $(this).val() == ""){            
            startNewsSearch(true);
            KScrollTo("#content-social");
         }
    });

    $("#input-search-map").keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        $(".main-search-bar").val($("#input-search-map").val());
        searchObject.text=$(this).val();
        if(e.keyCode == 13){
            startNewsSearch(true);
         }
    });
    /*, .menu-btn-start-search*/
    $("#main-btn-start-search, #main-search-bar-addon, #main-search-xs-bar-addon").click(function(){
        spinSearchAddon(true);
        if($(this).hasClass("menu-btn-start-search"))
            searchObject.text=$("#second-search-bar").val();
        else if ($(this).hasClass("input-group-addon-xs"))   
            searchObject.text=$("#main-search-xs-bar").val();
        else if ($(this).hasClass("input-group-addon"))   
            searchObject.text=$("#main-search-bar").val();
        else
            searchObject.text=$("#input-search-map").val();
        $("#second-search-bar, .main-search-bar, #input-search-map").val(searchObject.text);
        startNewsSearch(true);
    });
    $(".subModuleTitle .btn-refresh").click(function(){
        $(".main-search-bar").val("");
        $("#second-search-bar").val("");
        startNewsSearch(true);
    });
    $('.dropdown-menu[aria-labelledby="dropdownTags"]').on('click', function(event){
        // The event won't be propagated up to the document NODE and 
        // therefore delegated events won't be fired
        event.stopPropagation();
    });
    
    setTitle(titlePage, "stack-exchange", titlePage);
    //KScrollTo(".main-btn-scopes");
});
function startNewsSearch(isFirst){
    var urlCtrl = "/news/co/index/type/city/isLive/true";
    var loading = "<div class='loader bold letter-blue shadow2 text-center'>"+
                    "<i class='fa fa-spin fa-circle-o-notch'></i> "+
                    "<span>"+trad.currentlyloading+" ...</span>" + 
                "</div>";
    $("#newsstream").html(loading);
    simpleScroll(0, 500);
    ajaxPost("#newsstream",baseUrl+"/"+urlCtrl,{search:true}, function(news){ spinSearchAddon();}, "html");
}

</script>