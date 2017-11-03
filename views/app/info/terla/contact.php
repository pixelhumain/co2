<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "info",
                            )
                        );
?>


<style type="text/css">
	.txt-mail{
		min-height: 300px;
		max-height: 700px;
		max-width: 100%;
		min-width: 60%;
	}

	#mapContactcontact{
		width:100%;
		height:400px;
		/*background:#62adbf;*/
		margin-top:50px;
	}
</style>
        	
<header>
<div class="container">
    <div class="headerTitle"> CONTACT</div>
</div>
</header>

<section class="padding-top-70">
    <div class="container main-apropos padding-top-15 padding-bottom-50">
	    
        <div id="mapContactcontact"></div>
        
        <?php $this->renderPartial($layoutPath.'forms.'.Yii::app()->params["CO2DomainName"].'.formContact'); ?>
    </div>
</section>


<?php $this->renderPartial($layoutPath.'footer',  array( "subdomain"=>"info" ) ); ?>


<?php 
	$mapProvider = "OSM";
	if(PH::notlocalServer()){
		//error_log("NOT LOCAL");
		if(Yii::app()->params["mapboxActive"]==true)
		$mapProvider = "mapbox";
	}else{
		//error_log("LOCAL");
		$mapProvider = "OSM";
		if(Yii::app()->params["forceMapboxActive"]==true)
			$mapProvider = "mapbox";
	}

	$sigParamsContact = array(
        "sigKey" => "contact",

        /* MAP */
        "mapHeight" => 235,
        "mapTop" => 20,
        "mapColor" => 'rgb(69, 96, 116)',  //ex : '#456074', //'#5F8295', //'#955F5F', rgba(69, 116, 88, 0.49)
        "mapOpacity" => 0.4, //ex : 0.4

        /* MAP LAYERS (FOND DE CARTE) */
        "mapTileLayer" 	  => '//stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}.png', //'', //'http://{s}.tile.stamen.com/toner/{z}/{x}/{y}.png'
        "mapAttributions" => '<a href="http://www.opencyclemap.org">OpenCycleMap</a>',	 	//'Map tiles by <a href="http://stamen.com">Stamen Design</a>'

        "mapProvider" => $mapProvider,

        //"mapTileLayer" 	  => '//{s}.tile.stamen.com/toner/{z}/{x}/{y}.png', //'//{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png', //'http://{s}.tile.stamen.com/toner/{z}/{x}/{y}.png'
        //"mapAttributions" => '<a href="http://www.opencyclemap.org">OpenCycleMap</a>',	 	//'Map tiles by <a href="http://stamen.com">Stamen Design</a>'

        /* MAP BUTTONS */
        "mapBtnBgColor" => '#2B3136', //'rgba(76, 114, 126, 0.65)', //'#E6D414',
        //"mapBtnColor" => 'rgba(76, 114, 126, 0.65)', //'#213042',
        "mapBtnBgColor_hover" => '#0095FF', //'#5896AB',

        /* USE */
        "titlePanel" 		 => '',
        "usePanel" 			 => true,
        "useFilterType" 	 => true,
        "useRightList" 		 => true,
        "useZoomButton" 	 => true,
        "useHomeButton" 	 => false,
        "useSatelliteTiles"	 => true,
        "useFullScreen" 	 => true,
        "useFullPage" 	 	 => false,
        "useBtnCloseMap"	 => false,
        "useResearchTools" 	 => true,
        "useChartsMarkers" 	 => false,
        "useHelpCoordinates" => true,
        
        "notClusteredTag" 	 => array(),
        "firstView"		  	 => array(  "coordinates" => array(-21.28329624575406, 55.45623779296875), 
        //array(-21.156238366109417, 166.497802734375),//array(-1.4061088354351594, -26.015625),
									 	"zoom"		  => 14),
    );
?>


<script>

var currentCategory = "";
var initSigParamsContact =  <?php echo json_encode($sigParamsContact); ?>;

jQuery(document).ready(function() {
    initKInterface();
    location.hash = "#info.p.contact";
    $(".tooltips").tooltip();
    
    $(".dropdown-onepage-main-menu li a").click(function(e){
		e.stopPropagation();
		var target = $(this).data("target");
		console.log(target);
		KScrollTo(target);
	});

	$("#btn-onepage-main-menu").trigger("click");

	var SigContact = SigLoader.getSig();
	SigContact.loadIcoParams();

	console.log("loadMap","mapContact", initSigParamsContact);
	var mapContact = SigContact.loadMap("mapContact", initSigParamsContact);

	var data = {"typeSig":"address"};
	var properties = { 	id : "id",
						icon : SigContact.getIcoMarkerMap(data),
						type : data.type,
						typeSig : data.typeSig,
						name : "Contact",
						faIcon : SigContact.getIcoByType(data),
						content: "hello" };

	var marker = SigContact.getMarkerSingle(mapContact, properties, [-21.28329624575406, 55.45623779296875]);
	
});

</script>