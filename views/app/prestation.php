<?php 

	HtmlHelper::registerCssAndScriptsFiles( array('/css/timeline2.css','/css/news/index.css',
		
											) , Yii::app()->theme->baseUrl. '/assets');


	$cssAnsScriptFilesModule = array(
		'/js/news/index.js',
		'/js/news/autosize.js',
		'/js/news/newsHtml.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

    $page = "annonces";
    if($params["title"] == "Kgougle") $page = "freedom";

    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath ,
                                "type" => @$type,
                                "page" => page) ); 
?>
<style>
	
.btn-create-news{
    margin-top:0px;
    z-index: 10;
    border-radius: 0 50%;
    -ms-transform: rotate(7deg);
    -webkit-transform: rotate(7deg);
    transform: rotate(-45deg);
}
.btn-create-news:hover{
    background-color: white!important;
    color:#34a853!important;
    border: 2px solid #34a853!important;

}

.main-btn-scopes {
    margin-top: -57px;
}

#formCreateNewsTemp{
	display: none!important;
}
#modal-create-anc #formCreateNewsTemp{
	display: block!important;
}
#formCreateNewsTemp .form-create-news-container, #formActivity{
    max-width: 60%;
    /*margin-left:20%;*/
}
#sub-menu-left{
    margin-top:1px;
    /*text-align: left;*/
}
#sub-menu-left .btn{
    /*background-color: #4285f4;
    border-color: #4285f4;*/
	/*color:white;*/
    /*border-radius:80px;*/
    font-weight: 700;
}
#sub-menu-left .btn.active{
    /*background-color: #fff;
    color: #4285f4;*/
}
/*#sub-menu-left .btn:hover{
    background-color: #1c6df5;
    border-color: #4285f4;
}*/
/*#sub-menu-left .btn.active:hover{
    background-color: #fff;
    color: #4285f4;
}
#sub-menu-left .btn.bg-yellow{
	border-color: transparent;
}*/
<?php 
	$btnAnc = array("blue"		=>array("color1"=>"#4285f4", 
								  		"color2"=>"#1c6df5"),

					"green"		=>array("color1"=>"#34a853", 
								  		"color2"=>"#2b8f45"),

					"red"		=>array("color1"=>"#ea4335", 
								  		"color2"=>"#cc392d"),

					"yellow"	=>array("color1"=>"#fbbc05", 
								  		"color2"=>"#e3a800"),
					);
?>

<?php foreach($btnAnc as $color => $params){ ?>
.btn-anc-color-<?php echo $color; ?>{
    background-color: <?php echo $params["color1"]; ?>;
    border-color: <?php echo $params["color1"]; ?>!important;
    color: #fff!important;
}

.btn-anc-color-<?php echo $color; ?>:hover{
    background-color: <?php echo $params["color2"]; ?>!important;
    border-color: <?php echo $params["color1"]; ?>!important;
}
.btn-anc-color-<?php echo $color; ?>.active{ 
	background-color:#fff!important;
	color:<?php echo $params["color1"]; ?>!important;
}
.btn-anc-color-<?php echo $color; ?>.active:hover{
    background-color: #fff;
    color: <?php echo $params["color1"]; ?>;
}
<?php } ?>

.keycat:hover,
.keycat.active,
.btn-select-category-1:hover,
.btn-select-category-1.active{
	background-color: #2C3E50!important;
    color: #fff!important;
    border-color:transparent!important;
}


#sub-menu-left.subsub .btn{
	width:95%;    
	text-align: left;
	background-color: white;
    border-color: white;
	color:#4285f4;
}
#sub-menu-left.subsub{
	min-width: 180px;
}

.btn-menu-left-add{
	background-color: transparent !important;
    border-color: transparent !important;
}

#photoAddNews{
	text-align: left;
}

.tagstags, .form-actions{
	/*display: none!important;*/
}


@media (max-width: 768px) {
	.btn-select-type-anc.col-xs-5{
		width:48%!important;
	}
}

  @media screen and (min-width: 768px) and (max-width: 1024px) {
    .btn-select-type-anc.col-xs-5{
		font-size:0.8em;
	}
  }

/*
.elemt_name, .elemt_date{
	display: none;
}*/
</style>

<div class="col-md-12 col-sm-12 col-xs-12 bg-white top-page no-padding" id="" style="padding-top:0px!important;">

	<div class="col-lg-1  hidden-md col-sm-1 hidden-xs"></div>
		<?php 
				$prestation = CO2::getContextList("prestation");
				$currentSection = 1;
		?>
		

	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 margin-top-25 text-left subsub" id="sub-menu-left">
		<h2 class="bg-orange text-white">FILTRE</h2>			
		<hr>
		<div class="col-md-12 no-padding padding-top-10 padding-bottom-10 label-category" id="title-sub-menu-category">
			<h4 class="col-md-10">Toute destination</h4> <span class="col-md-12 bg-orange"><i class="fa fa-caret-right"></i><span>
		</div>
		<hr>
		<?php 
			  foreach ($prestation["categories"] as $key => $cat) {
		?>
				<button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
						<i class="fa fa-chevron-circle-down hidden-xs"></i> <?php echo Yii::t("category",$cat); ?> 
					</button><br>
		<?php } ?>
		<div class="col-md-12 no-padding padding-top-10 padding-bottom-10 label-category" id="title-sub-menu-category">
			<h4 class="col-md-10">Vous voyagez</h4> <span class="col-md-12 bg-orange"><i class="fa fa-caret-right"></i><span>
		</div>
		<hr>
		<input type="text" id="filterNumber" value="" placeholder="Number of travellers">
		<label>Date of travel</label>
		<span>From</span>
		<input type="date" name="">
		<span>To</span>
		<input type="date" name="">
		<label>Price for search</label>
		<input type="price" name="">
		
		<label>Adapted time</label>
		<button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
						<i class="fa fa-chevron-circle-down hidden-xs"></i> <?php echo Yii::t("category","Senior"); ?> 
					</button><br>
		<button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
						<i class="fa fa-chevron-circle-down hidden-xs"></i> <?php echo Yii::t("category","PMR"); ?> 
					</button><br>
		<button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
						<i class="fa fa-chevron-circle-down hidden-xs"></i> <?php echo Yii::t("category","Famille avec enfants"); ?> 
					</button><br>
		<button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>">
						<i class="fa fa-chevron-circle-down hidden-xs"></i> <?php echo Yii::t("category","Régime alimentaires"); ?> 
					</button><br>
	</div>

	<div class="col-lg-6 col-md-6 col-sm-6 no-padding margin-top-10">
		<h4 class="text-dark padding-bottom-5 margin-top-25 text-center">
			<i class="fa fa-angle-down"></i> Les annonces
			<i class="fa fa-angle-right hidden fa-title-list"></i> <span class="letter-blue label-category"><i class="fa fa-"></i> </span>
		</h4>
		<hr>

		<h5 class="text-center letter-red">
	        <button class="btn btn-default main-btn-scopes text-white tooltips margin-bottom-5 margin-top-5" 
	            data-target="#modalScopes" data-toggle="modal"
	            data-toggle="tooltip" data-placement="top" 
	                                title="Sélectionner des lieux de recherche">
	            <!-- <i class="fa fa-bullseye" style="font-size:18px;"></i> -->
	            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/cible3.png" height=42>
	        </button><br>
	        recherche ciblée
	    </h5>
	    <!-- <h5 class="text-center letter-red">choisir des sources</h5> -->

	    <br>
	    <div class="scope-min-header list_tags_scopes hidden-xs hidden-sm text-center"></div>
	    

		<div id="newsstream"></div>
	</div>	

	<div class="pull-right col-lg-3 col-md-3 col-sm-4 hidden-xs padding-20 margin-top-50" id="nowList">
	
	</div>
</div>



<?php $this->renderPartial('../news/modalCreateAnc'); ?>

<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"annonces")); ?>

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
    
    var typeUrl = "?nopreload=true";
    if(type!='') typeUrl = "?type="+type+"&nopreload=true";
	getAjax('#page' ,baseUrl+'/'+moduleId+"/default/directoryjs"+typeUrl,function(){ 

        $(".btn-directory-type").click(function(){
            var typeD = $(this).data("type");

            if(typeD == "events"){
                var typeEvent = $(this).data("type-event");
                searchSType = typeEvent;
            }

            initTypeSearch(typeD);
            mylog.log("search.php",searchType);
            setHeaderDirectory(typeD);
            loadingData = false;
            startSearch(0, indexStepInit, searchCallback);
            KScrollTo("#content-social");

            $(".btn-directory-type").removeClass("active");
            $(this).addClass("active");
        });

        $(".btn-open-filliaire").click(function(){
            KScrollTo("#content-social");
        });
         
         //anny double section filter directory
        <?php if(@$type == "classified" || @$type == "place"  ){ ?>
            initClassifiedInterface();
        <?php } ?>

        bindLeftMenuFilters();

        //console.log("init Scroll");
        $(window).bind("scroll",function(){  
            mylog.log("test scroll", scrollEnd);
            if(!loadingData && !scrollEnd && !isMapEnd){
                  var heightWindow = $("html").height() - $("body").height();
                  if( $(this).scrollTop() >= heightWindow - 400){
                    startSearch(currentIndexMin+indexStep, currentIndexMax+indexStep, searchCallback);
                  }
            }
        });


        loadingData = false; 
        initTypeSearch(type);
        startSearch(0, indexStepInit, searchCallback);

    },"html");

    initSearchInterface(); //themes/co2/assets/js/default/search.js

    
    if(page == "annonces" || page == "agenda" || page == "power"){
        setTimeout(function(){
            //KScrollTo("#content-social");  
        }, 1000);
    }
    $(".tooltips").tooltip();
});


/* -------------------------
AGENDA
----------------------------- */

<?php if(@$type == "events"){ ?>

var calendarInit = false;
function showResultInCalendar(mapElements){
    //mylog.dir(mapElements);

    var events = new Array();
    $.each(mapElements, function(key, thisEvent){
    
        var startDate = exists(thisEvent["startDateTime"]) ? thisEvent["startDateTime"].substr(0, 10) : "";
        var endDate = exists(thisEvent["endDateTime"]) ? thisEvent["endDateTime"].substr(0, 10) : "";
        var cp = "";
        var loc = "";
        if(thisEvent["address"] != null){
            var cp = exists(thisEvent["address"]["postalCode"]) ? thisEvent["address"]["postalCode"] : "" ;
            var loc = exists(thisEvent["address"]["addressLocality"]) ? thisEvent["address"]["addressLocality"] : "";
        }
        var position = cp + " " + loc;

        var name = exists(thisEvent["name"]) ? thisEvent["name"] : "";
        var thumb_url = notEmpty(thisEvent["profilThumbImageUrl"]) ? baseUrl+thisEvent["profilThumbImageUrl"] : "";
        
        if(typeof events[startDate] == "undefined") events[startDate] = new Array();
        events[startDate].push({  "id" : thisEvent["_id"]["$id"],
                                  "thumb_url" : thumb_url, 
                                  "startDate": startDate,
                                  "endDate": endDate,
                                  "name" : name,
                                  "position" : position });
    });

    if(calendarInit == true) {
        $(".calendar").html("");
    }

    $(".calendar").html($(".responsive-calendar-init").html());

    var aujourdhui = new Date();
    var  month = (aujourdhui.getMonth()+1).toString();
    if(aujourdhui.getMonth() < 10) month = "0" + month;
    var date = aujourdhui.getFullYear().toString() + "-" + month;

    $(".responsive-calendar").responsiveCalendar({
          time: date,
          events: events
        });

    $(".responsive-calendar").show();

    calendarInit = true;
}

<?php } ?>

/* -------------------------
END AGENDA
----------------------------- */

</script>