<?php 

    $cssAnsScriptFilesModule = array(
    //'/assets/css/default/responsive-calendar.css',
    '/assets/css/default/search.css',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

    $cssAnsScriptFilesModule = array(
    //'/js/default/responsive-calendar.js',
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
</style>

<div class="col-md-12 col-sm-12 col-xs-12 pageContent" id="content-social">

	<div class="col-md-3 col-sm-3 col-xs-3 no-padding menuSearchTerla">

		<input class="col-md-8 col-sm-8 col-xs-8" placeholder="nouvelle recherche" />
		<button class="col-md-3 col-sm-3 col-xs-3 btn btn-link bg-orange pull-right"><i class="fa fa-search"></i></button>

		<br><br>
		<h5 class="bg-orange text-white padding-15">FILTRE</h5>
		<button class="btn btn-link btn-filter text-dark"> <i class="fa fa-caret-right letter-yellow"></i> Man</button>
		<button class="btn btn-link btn-filter text-dark"> <i class="fa fa-caret-right letter-yellow"></i> Women</button>
		<button class="btn btn-link btn-filter text-dark"> <i class="fa fa-caret-right letter-yellow"></i> Fashion 2013</button>
	</div>

	<div class="col-md-9 col-sm-9 col-xs-9" style="padding: 25px 100px;">
		<?php echo count($result); ?> résultats<br><hr><br>
		<?php foreach ($result as $key => $value) { ?>
			<h4><?php echo $value["name"]; ?></h4>
			<?php echo @$value["description"]; ?><br><br>
			<button class="btn btn-link bg-orange pull-left"><i class="fa fa-link"></i></button>
			<button class="btn btn-link bg-orange pull-right">VIEW DETAILS</button><br><br><hr>
			
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

    initKInterface({"affixTop":320});

    initSearchInterface(); //themes/co2/assets/js/default/search.js
    
});

</script>