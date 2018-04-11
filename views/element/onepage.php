
<?php 
	HtmlHelper::registerCssAndScriptsFiles( 
		array(  '/css/onepage.css',
				'/vendor/colorpicker/js/colorpicker.js',
				'/vendor/colorpicker/css/colorpicker.css',
				'/css/news/index.css',	
				'/css/timeline2.css',	
			  ) , Yii::app()->theme->baseUrl. '/assets');

	HtmlHelper::registerCssAndScriptsFiles(
		array('/js/news/index.js', 
			  '/js/default/editInPlace.js'), 
			$this->module->assetsUrl);


	HtmlHelper::registerCssAndScriptsFiles(
		array('/plugins/showdown/showdown.min.js',
			  '/plugins/to-markdown/to-markdown.js',
			  ), Yii::app()->request->baseUrl);

	$themeParams = CO2::getThemeParams();

	$imgDefault = $this->module->assetsUrl.'/images/news/profile_default_l.png';

	//récupération du type de l'element
    $typeItem = (@$element["typeSig"] && $element["typeSig"] != "") ? $element["typeSig"] : "";
    if($typeItem == "") $typeItem = @$element["typeSig"] ? $element["type"] : "item";
    if($typeItem == "people") $typeItem = "citoyens";
    
    $allLinks = array();
    if(@$element["links"])
    foreach ($element["links"] as $key => $elementsLink) {
	    foreach ($elementsLink as $id => $el) {
	    	$allLinks[$key][] = Element::getByTypeAndId($el["type"], $id);
	    }
	}	
	
	$events = @$allLinks["events"];
    $members = @$allLinks["members"];
    $memberOf = @$allLinks["memberOf"];
    $followers = @$allLinks["followers"];

    $projects = @$allLinks["projects"];
 	$tags = @$element["tags"];
 	
 	$hash = @$element["slug"] ? "#".$element["slug"] :
								"#page.type.".$type.".id.".$element["_id"];
   
	//$hashOnepage = $hash.".".$themeParams["onepageKey"][0];
	$hashOnepage = "#page.type.".$type.".id.".$element["_id"].".view.".$themeParams["onepageKey"][0];

    $typeItemHead = $typeItem;
    if($typeItem == "organizations" && @$element["type"]) $typeItemHead = $element["type"];

    //icon et couleur de l'element
    $icon = Element::getFaIcon($typeItemHead) ? Element::getFaIcon($typeItemHead) : "";
    $iconColor = Element::getColorIcon($typeItemHead) ? Element::getColorIcon($typeItemHead) : "";

    $useBorderElement = false;
?>
<style>
	#description .item-desc{
		width:50%!important;
		margin-left: 25%!important;
	}

	.btn-onepage-quickview{
		position: fixed;
		left: 120px;
		top: 85px;
		z-index: 2;
	}

	.btn-link.btn-central-tool,
	.btn-link.btn-create-section{
		border-radius: 50px;
		padding:10px 15px;
		margin-top:-22px;
		border:none!important;
	}
	
	.btn-link.btn-central-tool:hover,
	.btn-link.btn-create-section:hover,
	.btn-link.btn-central-tool:focus,
	.btn-link.btn-create-section:focus{
		background-color: rgba(255, 255, 255, 0.8);
		text-decoration:none;
		border:none!important;
	}

	.btn.btn-tool-free-sec{
		background-color: rgba(255, 255, 255, 0.6);
		border-radius: 15px;
		padding:5px 10px;
		border:none!important;
	}
	.btn.btn-tool-free-sec:hover,
	.btn.btn-tool-free-sec:focus{
		background-color: rgba(255, 255, 255, 0.8) !important;
		text-decoration:none;
		border:none!important;
	}

	.ctn-tool-create-item{
		padding-top:15px;
	}
</style>

<div>
	<div class="dropdown">
		<button class="btn bg-red text-white btn font-blackoutM dropdown-toggle" 
				data-toggle="dropdown" id="btn-onepage-main-menu">
				<i class="fa fa-bars"></i> Menu
		</button>
		<div class="dropdown-onepage-main-menu font-montserrat" aria-labelledby="btn-onepage-main-menu">
			<ul class="dropdown-menu arrow_box" id="menu-onepage"></ul>
		</div>
	</div>

	<?php if($edit==true){ ?>
		<a href="<?php echo $hashOnepage.".mode.noedit"; ?>" target=_blank
			class="btn btn-link bg-red letter-white font-blackoutM btn-onepage-quickview">
			<i class="fa fa-user-circle"></i> Visualiser comme un visiteur
		</a>
	<?php }else if(@$_GET["mode"]=="noedit"){ ?>
		<a href="<?php echo $hash.".".$themeParams["onepageKey"][0]; ?>" 
			class="btn btn-link bg-red letter-white font-blackoutM btn-onepage-quickview lbh">
			<i class="fa fa-cogs"></i> Activer l'edition de la page
		</a>
	<?php } ?>

	<!-- BANNER Section -->
    
    <?php $this->renderPartial('../element/onepage/banner', 
    							array( "element" => $element )); 
	?>

	<!-- HEADER Section -->
    
    <?php $this->renderPartial('../element/onepage/header', 
    							array( "element" => $element,
    								   "edit" => @$edit,
    								   "linksBtn" => @$linksBtn,
    								   "hash" => @$hash,
    								   "type" => @$type,
    								   "openEdition" => @$openEdition)); 
	?>

	<?php if($edit==true){ ?>
		<div class="col-xs-12 text-center">
			<button class="btn btn-link bg-white text-dark tooltips btn-central-tool btn-update-descriptions shadow2"
					data-original-title="Modifier les descriptions" data-toogle="tooltips">
				<i class="fa fa-pencil"></i> Modifier la description
			</button>
		</div>	
	    <span class="contentInformation hidden">
	    	<span  id="shortDescriptionAboutEdit"><?php echo (!empty(@$element["shortDescription"])) ? @$element["shortDescription"] : ""; ?></span>
	  	</span>
    <?php } ?>
    <!-- DESCRIPTION Section -->


    <?php   
    		$desc = array( array("shortDescription"=>@$element["description"],
    							 "useMarkdown" => true), );

    		if(@$desc && sizeOf(@$desc)>0)
    		$this->renderPartial('../element/onepage/section', 
    								array(  "element" => $element,
    								   		"items" => $desc,
											"sectionKey" => "description",
											"sectionTitle" => "PRÉSENTATION",
											"sectionShadow" => true,
											"msgNoItem" => "Aucune description",
											"imgShape" => "square",
											"edit" => $edit,
											"useImg" => false,
											"fullWidth" => true, //only for 1 element
											"useBorderElement"=>$useBorderElement,

											"styleParams" => array(	"bgColor"=>"#FFF",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    ?>


	<!-- GALLERY Section -->


<?php $this->renderPartial('../element/onepage/sectionBefore', 
                                    array(  "element" => @$element,
                                            "edit" => @$edit,
                                            "sectionKey" => "gallery",
                                            "useBorderElement" => @$useBorderElement));
?>

<?php $this->renderPartial('../element/onepage/createFreeSection', 
                                    array(  "sectionShadow" => @$sectionShadow,
                                            "element" => $element,
                                            "edit" => @$edit,
                                            "sectionKey" => "gallery"));
?>

	<?php if(@$element["onepageEdition"]["#gallery"]["hidden"] != "true" || @$edit == true){ ?>
	<section id="gallery" class="bg-white row shadow">
		<?php if(@$edit==true){ ?>
			<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section" 
				    data-id="#gallery">
		        	<i class="fa fa-cog"></i>
		    </button>
		    <?php $this->renderPartial('../element/onepage/btnShowHide', 
	                                    array(  "element" => $element,
	                                            "sectionKey" => "gallery"));
	        ?>
	    <?php } ?>

        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">
                    <span class="sec-title">Galleries photos</span><br>
                    <i class="fa fa-angle-down"></i>
                </h2>
            </div>
        </div>

		<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
			<ul class="timeline inline-block" id="gallery-page">
		</ul>

	</section>
	<?php } ?>

    <!-- EVENTS Section -->

    <?php   if(@$events && sizeOf(@$events)>0){
    			foreach ($events as $key => $value)
    				if(Event::isPast($value)) unset($events[$key]);
    			
    			if(sizeOf(@$events)>0)
    			$this->renderPartial('../element/onepage/section', 
    								array(  "element" => $element,
    								   		"items" => $events,
											"sectionKey" => "events",
											"sectionTitle" => "ÉVÉNEMENTS À VENIR",
											"sectionShadow" => true,
											"msgNoItem" => "Aucun événement à afficher",
											"imgShape" => "square",
											"edit" => $edit,
											"useDesc" => true,
											"useBorderElement"=>$useBorderElement,

											"styleParams" => array(	"bgColor"=>"#f1f2f6",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    		} 
    ?>

    <!-- PROJETS Section -->

    <?php   if(@$projects && sizeOf(@$projects)>0){

	    		$sectionTitle = "MES PROJETS";
	    	    if(@$typeItem != "citoyens") $sectionTitle = "NOS PROJETS";
	    	    
	    		$this->renderPartial('../element/onepage/section', 
	    								array(  "element" => $element,
    								   			"items" => $projects,
												"sectionKey" => "projects",
												"sectionTitle" => "NOS PROJETS",
												"sectionShadow" => true,
												"msgNoItem" => "Aucun projet à afficher",
												"edit" => $edit,
												"imgShape" => "square",
												"useDesc" => false,
												"useBorderElement"=>$useBorderElement,

												"styleParams" => array(	"bgColor"=>"#FFF",
																  		"textBright"=>"dark",
																  		"fontScale"=>3),
												));
    		}
	?>

	
	<!-- COMMUNAUTE Section -->

    <?php
    		$sectionTitle = "COMMUNAUTÉ";
    	    if(@$typeItem == "organizations") $sectionTitle = "NOS MEMBRES";
    	    if(@$typeItem == "projects") $sectionTitle = "ILS CONTRIBUENT AU PROJET";
    	    if(@$typeItem == "events") $sectionTitle = "LES PARTICIPANTS";
    	    
    	    if(@$members && sizeOf(@$members)>0)
    		$this->renderPartial('../element/onepage/section', 
    								array(  "element" => $element,
    								   		"items" => $members,
											"sectionKey" => "participant",
											"sectionTitle" => $sectionTitle,
											"sectionShadow" => true,
											"msgNoItem" => "Aucun contact à afficher",
											"edit" => $edit,
											"imgShape" => "square",
											"useDesc" => false,
											"useBorderElement"=>$useBorderElement,
											"countStrongLinks"=>$countStrongLinks,

											"styleParams" => array(	"bgColor"=>"#FFF",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    ?>

    

	<!-- COMMUNAUTE Section -->

    <?php
    		$sectionTitle = "COMMUNAUTÉ";
    	    if(@$typeItem == "organizations") $sectionTitle = "NOUS SOMMES MEMBRES";
    	    if(@$typeItem == "projects") $sectionTitle = "NOUS SOMMES MEMBRES";
    	    if(@$typeItem == "events") $sectionTitle = "NOUS SOMMES MEMBRES";
    	    
    	    if(@$members && sizeOf(@$memberOf)>0)
    		$this->renderPartial('../element/onepage/section', 
    								array(  "element" => $element,
    								   		"items" => $memberOf,
											"sectionKey" => "directory",
											"sectionTitle" => $sectionTitle,
											"sectionShadow" => true,
											"msgNoItem" => "Aucun contact à afficher",
											"edit" => $edit,
											"imgShape" => "square",
											"useDesc" => false,
											"useBorderElement"=>$useBorderElement,
											"countStrongLinks"=>$countStrongLinks,

											"styleParams" => array(	"bgColor"=>"#FFF",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    ?>

    <!-- RESSOURCES Section -->

    <?php	$sectionTitle = "RESSOURCES";
    	    if(@$typeItem == "citoyens") $sectionTitle = "MES RESSOURCES";
    	    else 						 $sectionTitle = "NOS RESSOURCES";
    	    
    	    $ressources = Element::getByIdAndTypeOfParent( 
									Ressource::COLLECTION, (string)$element["_id"], 
									$typeItem, array("updated"=>-1));
    	    

    	    if(@$ressources && sizeOf(@$ressources)>0){
    	    	foreach ($ressources as $key => $value) {
	    	    	$ressources[$key]["type"] = Ressource::COLLECTION;
	    	    }

	    	    $this->renderPartial('../element/onepage/section', 
	    								array(  "element" => $element,
    								   			"items" => @$ressources,
												"sectionKey" => "ressources",
												"sectionTitle" => $sectionTitle,
												"sectionShadow" => true,
												"msgNoItem" => "Aucune ressource à afficher",
												"edit" => $edit,
												"imgShape" => "square",
												"useDesc" => false,
												"useBorderElement"=>$useBorderElement,

												"styleParams" => array(	"bgColor"=>"#FFF",
																  		"textBright"=>"dark",
																  		"fontScale"=>3),
												));
    	    }
    		
    ?>
    
    <!-- CLASSIFIED Section -->

    <?php 	$classified = Element::getByIdAndTypeOfParent( 
									Classified::COLLECTION, (string)$element["_id"], 
									$typeItem, array("updated"=>-1));
    	    

    	    if(@$classified && sizeOf(@$classified)>0){
    	    	foreach ($classified as $key => $value) {
	    	    	$classified[$key]["type"] = Classified::COLLECTION;
	    	    }

	    	    $this->renderPartial('../element/onepage/section', 
	    								array(  "element" => $element,
    								   			"items" => @$classified,
												"sectionKey" => "classified",
												"sectionTitle" => "Petites annonces",
												"sectionShadow" => true,
												"msgNoItem" => "Aucune annonce à afficher",
												"edit" => $edit,
												"imgShape" => "square",
												"useDesc" => false,
												"useBorderElement"=>$useBorderElement,

												"styleParams" => array(	"bgColor"=>"#FFF",
																  		"textBright"=>"dark",
																  		"fontScale"=>3),
												));
    	    }
    		
    ?>
    
    <!-- POI Section -->

    <?php 	$poi = Element::getByIdAndTypeOfParent( 
									Poi::COLLECTION, (string)$element["_id"], 
									$typeItem, array("updated"=>-1));
    	    

    	    if(@$poi && sizeOf(@$poi)>0){
    	    	foreach ($poi as $key => $value) {
	    	    	$poi[$key]["type"] = Poi::COLLECTION;
	    	    }

	    	    $this->renderPartial('../element/onepage/section', 
	    								array(  "element" => $element,
    								   			"items" => @$poi,
												"sectionKey" => "poi",
												"sectionTitle" => "Points d'intérets",
												"sectionShadow" => true,
												"msgNoItem" => "Aucun point d'intéret à afficher",
												"edit" => $edit,
												"imgShape" => "square",
												"useDesc" => false,
												"useBorderElement"=>$useBorderElement,

												"styleParams" => array(	"bgColor"=>"#FFF",
																  		"textBright"=>"dark",
																  		"fontScale"=>3),
												));
    	    }
    		
    ?>

    
    <!-- FOLLOWERS Section -->

    <?php
    		$sectionTitle = "FOLLOWERS";
    	    if(@$typeItem == "citoyens") $sectionTitle = "MES ABONNÉS";
    	    else 						 $sectionTitle = "NOS ABONNÉS";
    	    
    	    if(@$followers && sizeOf(@$followers)>0)
    		$this->renderPartial('../element/onepage/section', 
    								array(  "element" => $element,
    								   		"items" => $followers,
											"sectionKey" => "followers",
											"sectionTitle" => $sectionTitle,
											"sectionShadow" => true,
											"msgNoItem" => "Aucun contact à afficher",
											"edit" => $edit,
											"imgShape" => "square",
											"useDesc" => false,
											"useBorderElement"=>$useBorderElement,
											"countStrongLinks"=>$countStrongLinks,

											"styleParams" => array(	"bgColor"=>"#FFF",
															  		"textBright"=>"dark",
															  		"fontScale"=>3),
											));
    ?>


    <!-- NOS VALEURS Section -->

	<?php if (false && ($type==Project::COLLECTION) && !empty($element["properties"]["chart"])){ ?>
	<section id="projects-values" class="portfolio shadow">
		<div class="container">
			<div class="row">
	            <div class="col-lg-12 text-center">
	                <h2>Les valeurs du projet<br><i class="fa fa-angle-down"></i></h2>
	            </div>
	        </div>
            <div class="row">
        		<div class="no-padding col-md-8 col-md-offset-2">
					<?php

						if(empty($element["properties"]["chart"])) $element["properties"]["chart"] = array();
						$this->renderPartial('../project/pod/projectChart',array(
												"itemId" => (string)$element["_id"], 
												"itemName" => $element["name"], 
												"properties" => $element["properties"]["chart"],
												"admin" =>$edit,
												"isDetailView" => 1,
												"openEdition" => @$openEdition,
												"chartAlone" => true));
					?>						  
				</div>
			</div>
		</div>
	</section>
	<?php } ?>




	<!-- TIMELINE Section -->


	<?php $this->renderPartial('../element/onepage/sectionBefore', 
	                                    array(  "element" => @$element,
	                                            "edit" => @$edit,
	                                            "sectionKey" => "timeline",
	                                            "useBorderElement" => @$useBorderElement));
	?>

	<?php $this->renderPartial('../element/onepage/createFreeSection', 
	                                    array(  "sectionShadow" => @$sectionShadow,
	                                            "element" => $element,
                                            	"edit" => @$edit,
	                                            "sectionKey" => "timeline"));
	?>

	<?php if(@$element["onepageEdition"]["#timeline"]["hidden"] != "true" || @$edit == true){ ?>
	<section id="timeline" class="bg-white row shadow padding-15">
		<?php if(@$edit==true){ ?>
			<button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section" 
				    data-id="#timeline">
		        	<i class="fa fa-cog"></i>
		    </button>

	        <?php $this->renderPartial('../element/onepage/btnShowHide', 
	                                    array(  "element" => $element,
	                                            "sectionKey" => "timeline"));
	        ?>
	    <?php } ?>

        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">
                    <span class="sec-title">Actualité récente</span><br>
                    <i class="fa fa-angle-down"></i>
                </h2>
            </div>
        </div>

		<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
			<ul class="timeline inline-block" id="timeline-page">
			</ul>
		</div>
	</section>
	<?php } ?>


	<?php $this->renderPartial('../element/onepage/footer', 
    							array( "element" => $element,
    								   "edit" => @$edit)); 
	?>


	<?php $this->renderPartial('../element/onepage/modalSelectImage', 
	                          array( "element" => @$element ));
	?>


	<?php $this->renderPartial('../element/onepage/modalSelectGallery', 
	                          array( "element" => @$element ));
	?>

	<?php //render of modal for coop spaces 
		$paramsCoop = array(  "element" => @$element, 
                            "type" => @$type, 
                            "edit" => @$edit,
                            "thumbAuthor"=>@$thumbAuthor,
                            "openEdition" => $openEdition,
                            "iconColor" => $iconColor
                        );

    	$this->renderPartial('../cooperation/pod/modals', $paramsCoop ); 
    ?>


    <?php 
    	$mapData = array();
    	$mapData = @$members ? array_merge($members, $mapData) : array();
    	$mapData = @$projects ? array_merge($projects, $mapData) : array();
    	$mapData = @$events ? array_merge($events, $mapData) : array();

    	$controler = Element::getControlerByCollection($typeItem) ;
    ?>
</div>


<?php $this->renderPartial('../element/sectionEditTools', 
		array("type"=>Element::getControlerByCollection($typeItem),
			  "id"=>$element["_id"],
			  "element"=>$element)); 
?>

<script type="text/javascript" >
    
var isOnepage = true;
var typeItem = "<?php echo @$typeItem; ?>";;
var edit = "<?php echo @$edit; ?>";
var elementName = "<?php echo @$element["name"]; ?>";
var mapData = <?php echo json_encode(@$mapData) ?>;
var params = <?php echo json_encode(@$params) ?>;
var contextData = <?php echo json_encode( Element::getElementForJS(@$element, @$type) ); ?>; 

//initMetaPage(contextData.name,contextData.shortDescription,contextData.profilImageUrl);

var openEdition = "<?php echo (string)@$element["openEdition"]; ?>";
//console.dir("allparams", params);
var currentIdSection = "";
jQuery(document).ready(function() {
	
	//create <li> in onepage main menu
	initMenuOnepage();

	//init markdown display
	initMarkdownDescription();
	
	//change title in browser
	$("#main-page-name, title").html(elementName);

	if(edit==true)
		bindDynFormEditable();

	//console.log("body width", $("body").width());
	if($("body").width()>767)
		$("#btn-onepage-main-menu").trigger("click");

	//activate btn to show all text of Description (max hide by default)
    $(".btn-full-desc").click(function(){
        var sectionKey = $(this).data("sectionkey");
        if($("section#"+sectionKey+" .item-desc").hasClass("fullheight")){
            $("section#"+sectionKey+" .item-desc").removeClass("fullheight");
            $(this).html("<i class='fa fa-plus-circle'></i>");
        }else{
            $("section#"+sectionKey+" .item-desc").addClass("fullheight");
            $(this).html("<i class='fa fa-minus-circle'></i>");
        }
    });

	Sig.showMapElements(Sig.map, mapData);

	//load section GALLERY
	var url = "gallery/index/type/<?php echo (string)$element["type"] ?>/id/<?php echo (string)$element["_id"] ?>";
	ajaxPost('#gallery-page', baseUrl+'/'+moduleId+'/'+url, null, 
		function(){},"html");

	//load section TIMELINE
	initSectionNews();
});

function initSectionNews(){ console.log("initSectionNews");
	//load section TIMELINE
	var url = "news/index/type/<?php echo $typeItem; ?>/id/<?php echo (string)$element["_id"] ?>/isLive/true?isFirst=1&";
	ajaxPost('#timeline-page', baseUrl+'/'+moduleId+'/'+url+"renderPartial=true&tpl=co2&nbCol=2", null, 
		function(){
			$(window).bind("scroll",function(){ 
			    if(!loadingData && !scrollEnd){
			          var heightWindow = $("#onepage").height() - $("#mapCanvasBg").height();// - $("body").height();
			          //console.log("scrolling", $(this).scrollTop(), ">=", heightWindow - 300);
			          if( $(this).scrollTop() >= heightWindow - 300){
			            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep);
			          }
			    }
			});
		},"html");
}

//create <li> in onepage main menu
function initMenuOnepage(){
	$.each($("#onepage section"), function(){
		var id = $(this).attr("id");
		var title = $(this).find("h2.section-title span.sec-title").html();
		if(typeof title != "undefined"){
			$("ul#menu-onepage").append(
			'<li><a  class="elipsis" href="javascript:" data-target="#'+id+'"><i class="fa fa-angle-right"></i> '+title+'</a></li>');
		}
	});

	//activate clicking
	$(".dropdown-onepage-main-menu li a").click(function(e){
		e.stopPropagation();
		var target = $(this).data("target");
		KScrollTo(target);
	});
}

function initMarkdownDescription() {
	
	var descHtml = "<center><i>"+trad.notSpecified+"</i></center>";

	$.each($(".descriptionMarkdown"), function(){
		var sectionK = $(this).data("key");
		var item = $(this).data("item");
		descHtml = "<center><i>"+trad.notSpecified+"</i></center>";
		
		if($(this).html().length > 0){
			descHtml = dataHelper.markdownToHtml($(this).html()) ;
			console.log("initMarkdown", descHtml, 
						"section#"+sectionK+" .portfolio-item.item-"+item+" .item-desc");
			$("section#"+sectionK+" .portfolio-item.item-"+item+" .item-desc").html(descHtml);
		}
	});
	
}


var loading = 	"<li class='loader shadow2 letter-blue text-center margin-bottom-50' style='width: 60%;margin-left: 20%;'>"+
					"<span style=''>"+
						"<i class='fa fa-spin fa-circle-o-notch'></i> "+
						"<span>"+trad.currentlyloading+" ...</span>" + 
				"</li>";

function loadStream(indexMin, indexMax){ mylog.log("LOAD STREAM ONEPAGE"); //loadLiveNow
	loadingData = true;
	currentIndexMin = indexMin;
	currentIndexMax = indexMax;
	
	if(typeof dateLimit == "undefined") dateLimit = 0;

	$("#news-list").append(loading);

	//isLive = isLiveBool==true ? "/isLive/true" : "";
	var url = "news/index/type/"+typeItem+"/id/"+contextData.id+"/date/"+dateLimit+"/isLive/true?tpl=co2&nbCol=2&renderPartial=true";
	$.ajax({ 
        type: "POST",
        url: baseUrl+"/"+moduleId+'/'+url,
        data: { indexMin: indexMin, 
        		indexMax:indexMax, 
        		renderPartial:true 
        	},
        success:
            function(data) {
                if(data){ 
                	$("#news-list").find(".loader").remove();
                	$("#news-list").append(data);
                	//if($("#noMoreNews").length<=0)
						//$("#news-list").append(loading);
                	//bindTags();
					
				}
				loadingData = false;
				$(".stream-processing").hide();
            },
        error:function(xhr, status, error){
            loadingData = false;
            $("#news-list").html("erreur");
        },
        statusCode:{
                404: function(){
                	loadingData = false;
                    $("#news-list").html("not found");
            }
        }
    });
}

/*
function descHtmlToMarkdown() {
	mylog.log("htmlToMarkdown");
	if(typeof contextData.descriptionHTML != "undefined" && contextData.descriptionHTML == true) {
		mylog.log("htmlToMarkdown");
		if( $("#descriptionAbout").html() != "" ){
			var paramSpan = {
			  filter: ['span'],
			  replacement: function(innerHTML, node) {
			    return innerHTML;
			  }
			}
			var paramDiv = {
			  filter: ['div'],
			  replacement: function(innerHTML, node) {
			    return innerHTML;
			  }
			}
			//mylog.log("htmlToMarkdown2");
			var converters = { converters: [paramSpan, paramDiv] };
			var descToMarkdown = toMarkdown( $("#descriptionMarkdown").html(), converters ) ;
			//mylog.log("descToMarkdown", descToMarkdown);
			$("descriptionMarkdown").html(descToMarkdown);
			var param = new Object;
			param.name = "description";
			param.value = descToMarkdown;
			param.id = contextData.id;
			param.typeElement = contextData.type;
			param.block = "toMarkdown";
			$.ajax({
		        type: "POST",
		       	url : baseUrl+"/"+moduleId+"/element/updateblock/",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
			    	//toastr.success(data.msg);
			    }
			});
			//mylog.log("param", param);
		}
	}
}
*/
</script>
