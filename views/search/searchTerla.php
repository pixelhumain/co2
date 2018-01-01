<?php 

    $cssAnsScriptFilesModule = array(
    '/assets/css/default/search.css',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

    $cssAnsScriptFilesModule = array(
    '/js/default/search.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

    $params = CO2::getThemeParams();

    $maxImg = 5;

    $page = "search";
    $type = "services";

    //header + menu
    $this->renderPartial($layoutPath.'header', 
                            array(  "layoutPath"=>$layoutPath ,
                                    "page" => $page,
                                    "type" => @$type) ); 
?>

<style>
	
	.pageContent{
		position: absolute;
		top: 180px;
		padding: 20px;
	}

	.menuSearchTerla{
		border-right: 1px solid #e4e4e4;
	}
	
	.menuSearchTerla button.btn-filter{
			width:100%;
			text-align: left;
			border-bottom: 1px solid #e4e4e4;
	}

	
	.menuSearchTerla button.btn-filter:hover{
		text-decoration: none;
		border-right: 3px solid #EF5B34;
	}

	input#new-search-bar{
		border-radius: 0px;
		border: 1px solid lightgray;
		height: 34px;
	}

	button#btn-start-new-search{
		border-radius: 0px;
		border: 0px;
		height: 34px;
	}

	.name-res-search,
	.desc-res-search{
		color:grey;
	}
	.desc-res-search{
		font-size:13px;
	}
</style>

<div class="col-md-12 col-sm-12 col-xs-12 pageContent bg-white" id="content-social">

	<div class="col-md-3 col-sm-3 col-xs-3 no-padding menuSearchTerla">

		<input class="col-md-10 col-sm-10 col-xs-10" id="new-search-bar" placeholder="nouvelle recherche" />
		
		<button class="col-md-2 col-sm-2 col-xs-2 btn btn-link bg-orange pull-right" id="btn-start-new-search">
			<i class="fa fa-search"></i>
		</button>

		<br><br>

		<h5 class="bg-orange text-white padding-15"><?php echo Yii::t("common", "Filters"); ?></h5>


		<?php $filters = array("man", "woman", "fashion"); ?>
		<?php foreach($filters as $filter){ ?>
		<button class="btn btn-link btn-filter text-dark" data-value="<?php echo $filter; ?>"> 
			<i class="fa fa-caret-right letter-yellow"></i> <?php echo $filter; ?>
		</button>
		<?php } ?>
	
	</div>

	<div class="col-md-9 col-sm-9 col-xs-9" style="padding: 25px 100px;">
		<?php echo count($result); ?> résultats<br><hr><br>
		<?php foreach ($result as $key => $value) { ?>
			<a href="#page.type.<?php echo @$value["type"]; ?>.<?php echo @$value["_id"]; ?>" class="lbh">
			   <h4 class="name-res-search"><?php echo $value["name"]; ?></h4>
			</a>

			<?php if(@$value["description"]){ ?>
				<span class="desc-res-search"><?php echo @$value["description"]; ?></span><br><br>
			<?php } ?>

			<a href="#page.type.<?php echo @$value["type"]; ?>.<?php echo @$value["_id"]; ?>" 
				class="btn btn-link bg-orange pull-left lbh"><i class="fa fa-link"></i>
			</a> 

			<h5 class="name-res-search pull-left margin-left-15">
				<small>www.bch.org#page.type.<?php echo @$value["type"]; ?>.<?php echo @$value["_id"]; ?></small>
			</h5>

			<a href="#page.type.<?php echo @$value["type"]; ?>.<?php echo @$value["_id"]; ?>" 
			   class="lbh btn btn-link bg-orange pull-right">
			   <?php echo Yii::t("common", "VIEW DETAILS"); ?>
			</a>

			<br><br><hr>
			
			<?php //var_dump($value); ?>
		<?php } ?>
	</div>

</div>

<script type="text/javascript" >

var type = "<?php echo @$type ? $type : 'all'; ?>";
var typeInit = "<?php echo @$type ? $type : 'all'; ?>";
var page = "<?php echo @$page; ?>";
var titlePage = "<?php echo Yii::t("common",@$params["pages"]["#".$page]["subdomainName"]); ?>";

//var TPL = "kgougle";

//allSearchType = ["persons", "NGO", "LocalBusiness", "projects", "Group"];

var currentKFormType = "";

jQuery(document).ready(function() { 

    setTitle("", "", titlePage);

    $(".headerTitle").html(tradTerla.resultFor" <b>\"" + memorySearch + "\"</b>");

    initKInterface({"affixTop":320});

    initSearchInterface(); //themes/co2/assets/js/default/search.js

    $("#new-search-bar").keyup(function(e){ 
    	if(e.keyCode == 13){ console.log("new-search-bar keyup");
            initTypeSearch("services");
            startSearchTerla(0, indexStepInit);
            //$(".btn-directory-type").removeClass("active");
            //KScrollTo("#content-social");
        }
    });

    $("#btn-start-new-search").click(function(){
    	initTypeSearch("services");
        startSearchTerla(0, indexStepInit);
    });

    $(".btn-filter").click(function(){
    	var search = $(this).data("value");
    	$("#new-search-bar").val(search);
    	startSearchTerla(0, indexStepInit);
    });
    
});

</script>