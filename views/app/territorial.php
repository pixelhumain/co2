<?php
//echo CHtml::scriptFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/js/jquery.dataTables.min.1.10.4.js');
//echo CHtml::cssFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/css/DT_bootstrap.css');
//echo CHtml::scriptFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/js/DT_bootstrap.js');
$cssAnsScriptFilesModule = array(
    '/plugins/jquery-simplePagination/jquery.simplePagination.js',
	'/plugins/jquery-simplePagination/simplePagination.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));
$cssAnsScriptFilesModule = array(
    '/assets/css/default/responsive-calendar.css',
    '/assets/css/default/search.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);
$cssAnsScriptFilesModule = array(
    '/js/default/responsive-calendar.js',
    '/js/default/search.js',
    '/js/news/index.js',
);
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
//header + menu
  HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                          Yii::app()->theme->baseUrl. '/assets');

?>  

<style type="text/css">
.favElBtn, .favAllBtn{
  padding: 5px 8px;
  font-weight: 300;
  margin-bottom:5px;
}
#searchBarTextJS{
  margin-bottom: 15px;
}
.btn-open-filliaire{
  font-weight: 700;
  text-transform: uppercase;
}

#col-btn-type-directory .btn-directory-type,
#sub-menu-left .btn-select-type-anc{
  margin-bottom:5px;
  /*font-weight: 700;*/
  text-transform: uppercase;
  background-color: transparent;
}


@media (max-width: 768px) {
  #col-btn-type-directory{
    text-align: center!important;
  }
}


/* ANNONCES MENU*/
<?php 
  $btnAnc = array("blue"    =>array("color1"=>"#4285f4", 
                      "color2"=>"#1c6df5"),

          "green"   =>array("color1"=>"#34a853", 
                      "color2"=>"#2b8f45"),

          "red"   =>array("color1"=>"#ea4335", 
                      "color2"=>"#cc392d"),

          "yellow"  =>array("color1"=>"#fbbc05", 
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

.btn-select-category-1:hover,
.btn-select-category-1.active{
    background-color: #2C3E50!important;
    color: #fff!important;
    border-color:transparent!important;
}
.keycat:hover,
.keycat.active{
    background-color: #2BB0C6!important;
    color: #fff!important;
    border-color:transparent!important;
}


#sub-menu-left.subsub .btn{
  width:95%;    
  text-align: right;
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

.simple-pagination li a, .simple-pagination li span {
    border: none;
    box-shadow: none !important;
    background: none !important;
    color: #2C3E50 !important;
    font-size: 16px !important;
    font-weight: 500;
}
.simple-pagination li.active span{
	color: #d9534f !important;
    font-size: 24px !important;	
}
</style>

<?php $this->renderPartial($layoutPath.'header', 
                    array(  "layoutPath"=>$layoutPath , 
                            "page" => "territorial") );
?>                          
<!--<div class="panel-heading border-light text-center col-md-12 col-sm-12 col-xs-12 margin-top-10">
        <a href="javascript:;" onclick="applyStateFilter('<?php echo Organization::COLLECTION ?>')" class="filter<?php echo Organization::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Acteurs <span class="badge badge-warning countOrganizations" id="countorganizations"></span></a>
        <a href="javascript:;" onclick="applyStateFilter('<?php echo Project::COLLECTION ?>')" class="filter<?php echo Project::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Initiatives <span class="badge badge-warning countProjects" id="countprojects"></span></a> 
        <a href="javascript:;" onclick="applyStateFilter('<?php echo Person::COLLECTION ?>')" class="filter<?php echo Person::COLLECTION ?> btn btn-xs btn-default active btncountsearch"> Communecteurs <span class="badge badge-warning countPeople" id="countcitoyens"></span></a>
        <a href="javascript:;" onclick="applyStateFilter('<?php echo Event::COLLECTION ?>')" class="filter<?php echo Event::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Evénements <span class="badge badge-warning countEvents" id="countevents"></span></a> 
        <a href="javascript:;" onclick="applyStateFilter('<?php echo Place::COLLECTION ?>')" class="filter<?php echo Place::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Lieux <span class="badge badge-warning countPlaces" id="countplace"></span></a>
        <a href="javascript:;" onclick="applyStateFilter('<?php echo Poi::COLLECTION ?>')" class="filter<?php echo Poi::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Points d'intêréts <span class="badge badge-warning countPoi" id="countpoi"></span></a>
        <a href="javascript:;" onclick="applyStateFilter('<?php echo Classified::COLLECTION ?>')" class="filter<?php echo Classified::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Annonces <span class="badge badge-warning countClassified" id="countclassified"></span></a>
        <a href="javascript:;" onclick="applyStateFilter('<?php echo News::COLLECTION ?>')" class="filter<?php echo News::COLLECTION ?> btn btn-xs btn-default btncountsearch"> Posts <span class="badge badge-warning countNews" id="countnews"></span></a>
        <!--<a href="javascript:;" onclick="clearAllFilters('')" class="btn btn-xs btn-default"> All</a></h4>
</div>-->
<div class="panel panel-white col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
	<!--<div class="panel-tools padding-20">
		<?php if( Yii::app()->session["userId"] ) { ?>
		<a href="javascript:;" onclick="dyFObj.openForm('organization')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Add an Organization"><i class="fa fa-plus"></i> <i class="fa fa-group"></i> </a>

		<a href="javascript:;" onclick="dyFObj.openForm('event')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Add an Event"><i class="fa fa-plus"></i> <i class="fa fa-calendar"></i></a>

		<a href="javascript:;" onclick="dyFObj.openForm('person')" class="btn btn-xs btn-light-blue tooltips" data-placement="top" data-original-title="Invite Someone "><i class="fa fa-plus"></i> <i class="fa fa-user"></i></a>
		<?php } ?>
	</div>-->
	<!--<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>-->
	<div class="panel-body" id="dropdown_search"></div>
	<!--<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>-->
</div>
<script type="text/javascript">
var openingFilter = "<?php echo ( isset($_GET['type']) ) ? $_GET['type'] : '' ?>";
var directoryTable = null;
var contextMap = {
	"tags" : <?php echo json_encode(@$tags) ?>,
	"scopes" : <?php echo json_encode(@$scopes) ?>,
};
var results = <?php echo json_encode(@$results) ?>;
var betaTest= "<?php echo @Yii::app()->params['betaTest'] ?>";
var icons = {
	organizations : "fa-group",
	projects : "fa-lightbulb-o",
	events : "fa-calendar",
	citoyens : "fa-user",
	classified : "fa-bullhorn",
	poi : "fa-map-marker",
	news : "fa-newspaper-o"
};
//var searchPage=0;
//var pageCount=true;
/*var allRanges={
  organizations : { indexMin : 0, indexMax : 30, waiting : 30 },
  projects : { indexMin : 0, indexMax : 30, waiting : 30 },
  events : { indexMin : 0, indexMax : 30, waiting : 30 },
  citoyens : { indexMin : 0, indexMax : 30, waiting : 30 },
  classified : { indexMin : 0, indexMax : 30, waiting : 30 },
  poi : { indexMin : 0, indexMax : 30, waiting : 30 },
  news : { indexMin : 0, indexMax : 30, waiting : 30 },
  place : { indexMin : 0, indexMax : 30, waiting : 30 },
  ressource : { indexMin : 0, indexMax : 30, waiting : 30 },
};*/
var injectData = {};
var allResults={};
var searchCount={};
jQuery(document).ready(function() {
	//setTitle("Espace administrateur : Répertoire","cog");
	initTypeSearch("all");
  initInjectData();
  initTerritorialSearch();
   // startSearch(0, indexStepInit, searchCallback);
  startSearch(0, 30, null);   
	initKInterface();
	initSearchInterface();
	//initViewTable(results);
	if(openingFilter != "")
		$('.filter'+openingFilter).trigger("click");
	$(window).bind("scroll",function(){  
      mylog.log("test scroll", scrollEnd, loadingData);
      if(!loadingData && !scrollEnd && !isMapEnd){
        var heightWindow = $("html").height() - $("body").height();
        if( $(this).scrollTop() >= heightWindow - 800){
          startSearch(10, 30, null);
      }
    }
  });
  loadingData = false; 
        
   // initPageTable(results.count.citoyens);

});	
function initInjectData(){
  injectData={organizations : 0,
    projects : 0,
    events : 0,
    citoyens : 0,
    classified : 0,
    poi : 0,
    news : 0,
    place : 0,
    ressource : 0
  };
}
function initTerritorialSearch(){
  search.ranges={
    organizations : { indexMin : 0, indexMax : 30, waiting : 30 },
    projects : { indexMin : 0, indexMax : 30, waiting : 30 },
    events : { indexMin : 0, indexMax : 30, waiting : 30 },
    citoyens : { indexMin : 0, indexMax : 30, waiting : 30 },
    classified : { indexMin : 0, indexMax : 30, waiting : 30 },
    poi : { indexMin : 0, indexMax : 30, waiting : 30 },
    news : { indexMin : 0, indexMax : 30, waiting : 30 },
    places : { indexMin : 0, indexMax : 30, waiting : 30 },
    ressources : { indexMin : 0, indexMax : 30, waiting : 30 },
  };
  allResults={};
  //check search.value Or locality filtering to add persons in the research
  initTypeSearch("all");
}
function applyStateFilter(str)
{
	//mylog.log("applyStateFilter",str);
	pageCount=true;
	searchType=[str];
	searchPage=0;
	$(".btncountsearch").removeClass("active");
	$(".filter"+str).addClass("active");
	//if(search.value=="")
	//	search.value=true;
	 autoCompleteSearch(search.value, null, null, null, null);
	//directoryTable.DataTable().column( 0 ).search( str , true , false ).draw();
}
function prepareAllSearch(data){
  var sorting=[];
  searchType=[];
  initInjectData();
  $.each(data, function(e,v){
    //if (searchType.indexOf(v.type) == -1)
      //searchType.push(v.type);
    //if(typeof searchType[v.type] == "undefined" )
      //searchType.push(v.type);
    allResults[e]=v;
  });
  $.each(allResults, function(e,v ){
    if (searchType.indexOf(v.type) == -1)
      searchType.push(v.type);
    sorting.push(v.sorting);
  });
  //allResults.push(data);
  sorting.sort().reverse();
  //console.log("sorting",sorting);
  //orderResults={};
  $i=0;
  var resToShow={};
  sorting=sorting.splice(0,30);
  $.each(sorting, function(e, v){
    $.each(allResults, function(key, value){
      if(v==value.sorting){
        resToShow[key]=value;
        injectData[value.type]++;
        delete allResults[key];
        $i++;
      }
    });
  });
  $.each(injectData, function (type, v){
    console.log(v);
    if(v==0)
      removeSearchType(type);
    else{
      search.ranges[type].indexMin=search.ranges[type].indexMax;
      search.ranges[type].indexMax=search.ranges[type].indexMin+v;
    }
  });
  return resToShow;
}
/*function initPageTable(number){
	numberPage=(number/100);
	$('.pageTable').pagination({
        items: numberPage,
        itemOnPage: 15,
        currentPage: 1,
        hrefTextPrefix:"?page=",
        cssStyle: 'light-theme',
        //prevText: '<span aria-hidden="true">&laquo;</span>',
        //nextText: '<span aria-hidden="true">&raquo;</span>',
        onInit: function () {
            // fire first page loading
        },
        onPageClick: function (page, evt) {
            // some code
            //alert(page);
            search.page=(page-1);
            startAdminSearch();
        }
    });
}*/
/*function initViewTable(data){
	$('#panelAdmin .directoryLines').html("");
	//showLoader('#panelAdmin .directoryLines');
	console.log("valuesInit",data);
	$.each(data,function(type,list){
		$.each(list, function(key, values){
			entry=buildDirectoryLine( values, type, type, icons[type]);
			$("#panelAdmin .directoryLines").append(entry);
		});
	});
	bindAdminBtnEvents();
	//resetDirectoryTable() ;
}*/
/*function refreshCountBadge(count){
	$.each(count, function(e,v){
		$("#count"+e).text(v);
	});
}*/
/*function startSearch(initPage){

    //$("#second-search-bar").val(search);
    $('#panelAdmin .directoryLines').html("Recherche en cours. Merci de patienter quelques instants...");

    /*var params = {
        search:search,
        status:status,
        orderBy:"url"
    };*/

   /* $.ajax({ 
        type: "POST",
        url: baseUrl+"/"+moduleId+"/admin/directory/tpl/json",
        data: search,
        dataType: "json",
        success:function(data) { 
	          initViewTable(data.results);
	          bindAdminBtnEvents();
	          if(typeof data.results.count !="undefined")
	          	refreshCountBadge(data.results.count);
	          console.log(data.results);
	          if(initPage)
	          	initPageTable(data.results.count[search.type]);
        },
        error:function(xhr, status, error){
            $("#searchResults").html("erreur");
        },
        statusCode:{
                404: function(){
                    $("#searchResults").html("not found");
            }
        }
    });
}*/


</script>