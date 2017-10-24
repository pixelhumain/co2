<?php 

$cssAnsScriptFilesModule = array(
    '/js/default/directory.js',
    '/js/interoperability/interoperability.js',
    '/js/interoperability/timeline-chart.js',
);

HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

$d3jsscript = array(
	'/plugins/d3/d3.v3.min.js',
);

HtmlHelper::registerCssAndScriptsFiles($d3jsscript, Yii::app()->request->baseUrl); 

HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                      Yii::app()->theme->baseUrl. '/assets');

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
$this->renderPartial($layoutPath.'header',
      array( "layoutPath"=>$layoutPath, 
        "page" => "interoperability") );
?>

<div id="container-scope-filter"  class="col-md-10 col-sm-10 col-xs-12 padding-5">
  <?php $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); ?>
</div>

<style>

#all_wikilinks {
	text-align: center;
}

.wikipedia_elt {
	text-align: center;
	/*border: 2px solid black;*/
	margin: 10px;
}

.wikipedia_elt {
	position: relative;
	height: 350px;
	border-radius: 50px;
	/*display: inline-block;*/
	/*vertical-align: top;*/
	/*margin: 35px 26px;*/
	padding: 25px;
/*	width: 220px;
	height: 110px;*/
	background: #F6F6F6;
	/*font-size: 1.6em;*/
	/*line-height: 5em;*/
	/*font-family: Georgia, Times, Serif;*/
	/*text-align: center;*/
	background-image: linear-gradient(to bottom, rgb(218, 218, 218) 11%, #F6F6F6 56%);
	box-shadow: 0 0 65px #aba9a6 inset, 0 0 20px #969696 inset;
}

.div-wikipage {
    padding: 10px;
    /*margin-bottom: 10px;*/
}

.searchWikiEntityContainer {
	min-height: 150px;
	/*margin: bottom: 10px;*/
}

.btn-wiki-wikitoco, .btn-wiki-cotowiki, .btn-wiki-copedia  {
	margin-top: 10px;
	margin-right: 5px;	
}



#cityDetail .col-sm-4,#cityDetail .col-sm-8{
  padding:5px !important;
}
#cityDetail .panel{
  margin-bottom:10px !important;
}

.panel-title{
  font-family: "Homestead";
}
.link-to-directory{
  cursor:pointer;
}
.link-to-directory:hover{
  text-decoration: underline;
}
.btn-to-directory{
  width:100%;
  margin-top: 10px;
  font-weight: 500;
}

#btn-communecter{
  width: auto;
  font-size: 20px;
  border-radius: 10px;
  border: none;
  position: absolute;
  top: 10px;
  right: 5%;
  z-index:1;
  background-color: rgba(255, 255, 255, 0.63);
  padding-bottom: 5px;
  box-shadow: 0px 0px 3px 3px RGBA(114, 114, 114, 0.31);
}
#btn-communecter small{
  font-size:16px;
  word-break: normal;
}
#btn-communecter:hover{
  background-color: #E33551;
  color:white !important;
}
h1.cityName-header{
  background-color: rgba(255, 255, 255, 0.63);
  padding: 30px 10px;
  margin-bottom: -3px;
  font-size: 32px;
  border-radius: 5px;
  display: inline-block;
  width: 100%;
}

h1.you-live{
  font-size: 18px !important;
  padding: 10px;
  border-radius: 0px;
  margin: -5px -5px 5px;
  font-weight: 300 !important;
  margin-bottom: 0px;
}
.why-communect{
  font-size:17px;
  font-weight: 300;
  margin-top:7px;
}
.margin-top-20{
  margin-top:20px !important;
}
.btn-discover-more {
  font-size:17px;
  white-space: unset;
}
.info-why{
  font-weight: 300;
  height: 80px;
}
@media screen and (max-width: 1024px) {
  #btn-communecter{
    font-size:17px;
  }
  h1.you-live{
    font-size:26px !important;
  }
  
}

.picture_element {

	max-width: 350px;
	max-height: 350px;
}

#pod-local-actors .list-group-item {
  position: relative;
  padding: 10px 5px;
  margin-bottom: -1px;
  background-color: #FFF;
  border: 1px solid #DDD;
  display: inline-block;
  height: 125px;
  text-align: center;
  font-family: "homestead";
  font-size: 17px;
  border-radius: 0px;
  border-right: 0px;
  border-top: 0px;
  margin-top: 1px;
}

#pod-local-actors .list-group-item:hover {
  z-index: 1;
  text-decoration: none !important;
  -moz-box-shadow: 0px 0px 5px -1px #656565;
  -webkit-box-shadow: 0px 0px 5px -1px #656565;
  -o-box-shadow: 0px 0px 5px -1px #656565;
  box-shadow: 0px 0px 5px -1px #656565;
  filter:progid:DXImageTransform.Microsoft.Shadow(color=#656565, Direction=NaN, Strength=5);
}
#pod-local-actors .list-group-item .badge {
  font-size: 14px;
  font-family: Helvetica;
  width: 50px;
  height: 20px;
  border-radius: 20px;
  padding-top: 5px;
  top: 11px;
  right: 20px;
  text-align: center;
}


.pod-local-actors .list-group-item .badge {
  font-size: 14px;
  font-family: Helvetica;
  width: 50px;
  height: 20px;
  border-radius: 20px;
  padding-top: 5px;
  top: 11px;
  right: 20px;
  text-align: center;
}

.leaflet-popup-content .pod-local-actors .list-group-item {
  position: relative;
  display: block;
  padding: 10px 5px;
  margin-bottom: -1px;
  background-color: #FFF;
  width: 50%;
  text-align: center;
  height: 60px;
  border: 1px solid #DDD;
  font-weight: 500;
}
/*view randomOrga*/

#div-discover .btn-discover{
  border-radius: 60px;
  font-size: 28px;
  font-weight: 200;
  border: 1px solid transparent;
  width: 65px;
  height: 65px;
  margin-bottom: 5px;
  padding-top: 12px;
}
#div-discover .btn-discover.bg-red{
  /*font-size: 43px;*/
  /*padding-top: 12px;*/
}
#div-discover .btn-discover.bg-orange:hover{
  background-color: white !important;
  border-color: #FFA200 !important;
  color: #FFA200 !important;
}
#div-discover .btn-discover.bg-yellow:hover{
  background-color: white !important;
  border-color: #FFC600 !important;
  color: #FFC600 !important;
}
#div-discover .btn-discover.bg-purple:hover{
  background-color: white !important;
  border-color: #8C5AA1 !important;
  color: #8C5AA1 !important;
}
#div-discover .btn-discover.bg-green:hover{
  background-color: white !important;
  border-color: #93C020 !important;
  color: #93C020 !important;
}
#div-discover .btn-discover.bg-red:hover{
  background-color: white !important;
  border-color: #E33551 !important;
  color: #E33551 !important;
}

#div-participate .btn-participate{
  border-radius: 60px;
  font-size: 50px;
  font-weight: 200;
  border: 1px solid transparent;
  width: 120px;
  height: 120px;
  padding-top:20px;
}
#div-participate .btn-participate:hover{
  background-color: white !important;
  border-color: #E33551 !important;
  color: #E33551 !important;
}

.badge.nb-localactors{
    margin-left: -20px;
    margin-top: -15px;
    font-size: 18px;
    margin-right: -10px;
    border: #fff solid 3px;
    border-radius: 50%;
    font-weight: 300;
}

@media screen and (max-width: 768px) {
  
  h1.cityName-header{
    margin-top:0px;
    font-size:20px;
  }
  #pod-local-actors .list-group-item{
    height:90px;
    font-size:13px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 300;
    text-transform: capitalize;
  }
  #btn-communecter{
    top:10px;
  }

  #div-discover .btn-discover{
    border-radius: 30px;
    font-size: 24px;
    font-weight: 200;
    border: 1px solid transparent;
    width: 60px;
    height: 60px;
    margin-bottom: 5px;
    padding-top: 12px;
  }
}

.homestead {
    font-family: "Homestead";
}

@media screen and (max-width: 1024px) {

  #div-discover .discover-subtitle{
    display:none;

  }

}

#chart {
    width: 90%;
    height: 150px;
    background: rgb(218, 218, 218);
    opacity: 0.9;
    border-radius: 5px;
    border: 1px solid #2b2b2b;
    margin-bottom: 30px;
    margin-top: 30px;
}

#chart line {
    stroke: #2b2b2b;
}

#chart line.vertical-marker.now {
    stroke: #c00;
}

rect.interval.red-interval {
    fill: red;
    stroke: red;
}

circle.red-dot {
    fill: red;
}

circle.orange-dot {
    fill: orange;
}

circle.green-dot {
    fill: green;
}

circle.yellow-dot {
    fill: yellow;
}

/* Override d3tip */

.d3-tip {
    background: white;
    color: black;
}

/* Tiny Flex Grid */

[flex] {
    display: flex;
}
[flex-fill] {
    flex: 1;
}
[flex-full-center] {
    align-items: center;
    justify-content: center;
}
[flex-direction=column] {
    flex-direction: column;
}
[flex-direction=row] {
    flex-direction: row;
}
[flex-size="40"] {
    flex: 40;
}
[flex-size="60"] {
    flex: 60;
}

/*TIMELINE CHART CSS */

.timeline-chart .axis path {
  fill: none;
  stroke: none; }

.timeline-chart line {
  stroke: black; }

.timeline-chart .vertical-marker {
  stroke-width: 1; }

.timeline-chart rect, .timeline-chart rect.chart-bounds {
  fill: transparent; }

.timeline-chart rect.chart-bounds:hover, .timeline-chart rect.interval:hover {
  cursor: -webkit-grab;
  cursor: grab; }

.timeline-chart rect.chart-bounds:active, .timeline-chart rect.interval:active {
  cursor: -webkit-grabbing;
  cursor: grabbing; }

.timeline-chart .dot:hover {
  cursor: pointer; }

.timeline-chart .interval-text {
  pointer-events: none; }

.timeline-chart rect.interval {
  ry: 5;
  rx: 5;
  fill: black;
  stroke: #2b2b2b; }

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/0.0.1/prism.min.css" />
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" /> -->
<link rel="stylesheet" href="https://rawgithub.com/Caged/d3-tip/master/examples/example-styles.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/0.0.1/prism.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3-tip/0.6.7/d3-tip.min.js"></script>

<!-- <center><h3>Copédia : vue d'essemble de la page Wiki de : <a id="wiki_title" target="_blank"></a></h3></center> -->
<br/>

<div id="main-container-copedia" class="col-xs-12 bg-white">

	<div id="all_wikilinks" class="col-xs-12"></div>
	<h4><p id="type_element"></p></h4>
	<div id="btn_add_type"></div>

	<div id="all_properties" class="col-xs-12">
	<!-- 	<h4>Liste de toutes les propriétés de l'élément Wikidata</h4>
	 -->	
	</div>

	 <div id="div-discover" class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
	    <div class="col-md-12 no-padding" style="margin:10px">
	        <div class="col-xs-2 center no-padding hidden-xs" style="margin-bottom:10px; font-size:17px; font-weight: 300;">
	            <a class="btn btn-discover btn-discover-event bg-orange">
	              <i class="fa fa-calendar"></i>
	            </a>
	            <span class="badge nb-localactors nb-event bg-orange homestead">0</span>
	            <br>
	            <span class="text-orange discover-subtitle homestead">Evénement
	            </span>
	        </div>

	        <div class="col-xs-2 center no-padding hidden-xs" style="margin-bottom:10px; font-size:17px; font-weight: 300;">
	            <a class="btn btn-discover btn-discover-orga bg-green">
	              <i class="fa fa-group"></i>
	            </a>
	            <span class="badge nb-localactors nb-orga bg-green homestead">0</span>
	            <br>
	            <span class="text-green discover-subtitle homestead">Organisation
	            </span>
	        </div>

	        <div class="col-xs-2 center no-padding hidden-xs" style="margin-bottom:10px; font-size:17px; font-weight: 300;">
	            <a class="btn btn-discover btn-discover-location bg-purple">
	              <i class="fa fa-lightbulb-o"></i>
	            </a>
	            <span class="badge nb-localactors nb-location bg-purple homestead">0</span>
	            <br>
	            <span class="text-purple discover-subtitle homestead">Lieu
	            </span>
	        </div>

	        <div class="col-xs-2 center no-padding hidden-xs" style="margin-bottom:10px; font-size:17px; font-weight: 300;">
	            <a class="btn btn-discover btn-discover-human bg-yellow">
	              <i class="fa fa-user"></i>
	            </a>
	            <span class="badge nb-localactors nb-human bg-yellow homestead">0</span>
	            <br>
	            <span class="text-yellow discover-subtitle homestead">Personne
	            </span>
	        </div>

	        <div class="col-xs-2 center no-padding hidden-xs" style="margin-bottom:10px; font-size:17px; font-weight: 300;">
	            <a class="btn btn-discover btn-discover-other bg-green">
	              <i class="fa fa-question"></i>
	            </a>
	            <span class="badge nb-localactors nb-other bg-green homestead">0</span>
	            <br>
	            <span class="text-green discover-subtitle homestead">Autres
	            </span>
	        </div>
	        <div class="col-xs-2 center no-padding hidden-xs" style="margin-bottom:10px; font-size:17px; font-weight: 300;">
	            <a class="btn btn-discover btn-discover-undefined bg-red">
	              <i class="fa fa-close"></i>
	            </a>
	            <span class="badge nb-localactors nb-not-defined bg-red homestead">0</span>
	            <br>
	            <span class="text-red discover-subtitle homestead">Indéfini
	            </span>
	        </div>
	    </div>

		<center>

		<button class="btn btn-default list_all_wikidata_item" style="margin: 20px;">
			List all Wikidata elements of the city
		</button>

		<button class="btn btn-default list_all_wikipedia_article" style="margin: 20px;">
			All wikipédia links in the Wiki page of the city
		</button>

		<br>

		<h4 id="wiki_title"></h4>
		<div id="chart"></div>
		</center>
	</div>

	<div style="margin-top: 20px;" id="all_wikidata_item"></div>
	<div class="col-xs-offset-1" style="margin-top: 20px;" id="all_wikipedia_item"></div>

</div>

<?php 

	$curl = curl_init();

	$wikidataID_pos = strrpos($url_wiki, 'Q', -1);
	$wikidataID = substr($url_wiki, $wikidataID_pos);
	 
	curl_setopt($curl, CURLOPT_URL, "https://test.wikidata.org/w/api.php?action=wbgetclaims&format=json&entity=".$wikidataID);

	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$list_properties = curl_exec($curl);
	 
	curl_close($curl);
?>

<script type="text/javascript">

	// initVarAndFunction();

	$("#chart").hide();

    $(".list_all_wikidata_item").click(function(){
    	wikidataID = getWikidataID();
    	initVarAndFunction();
    	listAllWikidataItems(wikidataID);    	
	});

	$(".list_all_wikipedia_article").click(function() {
		wikidataID = getWikidataID();
		initVarAndFunction();
		listAllWikipediaArticle(wikidataID);
	});

	function initVarAndFunction() {
		nb_person = 0;
		nb_event = 0;
		nb_location = 0;
		nb_other = 0;
		nb_undefined = 0;
		nb_orga = 0;
		final_all_wikilinks = {}
		chronoline = [
		{
			label: 'Evénement',
			data: [{
			}]
		}, 
		{
			label: 'Organisations',
			data: [{
			}]
		},
		{
			label: 'Personnes',
			data: [{
			}]
		}];

		$("#wiki_title").html("Vue d'enssemble de la page Wikipédia : ");

	}

	function listAllWikidataItems(wikidataID) {

		$.ajax({
      url:"https://query.wikidata.org/sparql?format=json&query=SELECT%20DISTINCT%20%3Fitem%20%3FitemLabel%20%3FitemDescription%20%3Fcoor%20%3Frange%20%3Ftype%20%3FtypeLabel%20WHERE%20{%0A%20%3Fitem%20wdt%3AP131%20wd%3A"+wikidataID+".%0A%20%3Fitem%20%3Frange%20wd%3A"+wikidataID+".%0A%20%3Fitem%20wdt%3AP625%20%3Fcoor.%0A%20OPTIONAL{%3Fitem%20wdt%3AP31%20%3Ftype%20.}%0A%20SERVICE%20wikibase%3Alabel%20{%20bd%3AserviceParam%20wikibase%3Alanguage%20%22fr%22.%20}%0A}",
      type:"GET",
      dataType: "json",
      success:function(data) {
      	mylog.log('ALL WIKIDATA ITEMS OF THIS CITY : ', data);
      	all_wikidata_item = data;
		    displayAllWikidataItem(all_wikidata_item.results.bindings);
      }
    });
	}

	function displayAllWikidataItem(all_wikidata_item) {

		$("#all_wikipedia_item").html("");
		$("#all_wikidata_item").html(
			"<table class='table table-striped'>"+
				"<thead>"+
					"<true>"+
						"<th>NOM</th>"+
						"<th>TYPE</th>"+
						"<th>DESCRIPTION</th>"+
						"<th>Lien vers la page Wikidata</th>"+
					"</tr>"+
				"</thead>"+
				"<tbody class='col-xs-10' id='body_table_wikidata'>"+
				"</tbody>"+
			"</table>"
		);

		$.each(all_wikidata_item, function(index, value) {

			var wikiID = value.item.value.substr(value.item.value.lastIndexOf("/")+1); 

			if (typeof value.itemDescription !== "undefined") {
				if (typeof value.typeLabel !== "undefined") {
					$("#body_table_wikidata").append(
					"<tr class='info col-xs-12'>"+
		    			"<td>"+value.itemLabel.value+"</td>"+
		    			"<td>"+value.typeLabel.value+"</td>"+
		    			"<td>"+value.itemDescription.value+"</td>"+
		    			"<td><a target='_blank' class='btn btn-default' href='"+value.item.value+"'>Link to WIKIDATA</a></td>"+
					"</tr>"
					);
				} else {
					$("#body_table_wikidata").append(
					"<tr class='info'>"+
		    			"<td>"+value.itemLabel.value+"</td>"+
		    			"<td class='danger'>Type non défini ! <button class='put_claim' data-name='"+value.itemLabel.value+"' data-id='"+wikiID+"'>Ajouter un type</button></td>"+
		    			"<td>"+value.itemDescription.value+"</td>"+	
		    			"<td><a target='_blank' class='btn btn-default' href='"+value.item.value+"'>Link to WIKIDATA</a></td>"+
					"</tr>"
					);
				}
			} else {
				if (typeof value.typeLabel !== "undefined") {
					$("#body_table_wikidata").append(
					"<tr class='info'>"+
		    			"<td>"+value.itemLabel.value+"</td>"+
		    			"<td>"+value.typeLabel.value+"</td>"+
		    			"<td class='danger'>No description <button data-name='"+value.itemLabel.value+"' data-id='"+wikiID+"' class='put_description'> Put a description </button></td>"+
		    			"<td><a target='_blank' class='btn btn-default' href='"+value.item.value+"'>Link to WIKIDATA</a></td>"+
					"</tr>"
					);
				} else {
					$("#body_table_wikidata").append(
					"<tr class='info'>"+
		    			"<td>"+value.itemLabel.value+"</td>"+
		    			"<td class='danger'>Type non défini ! <button class='put_claim' data-name='"+value.itemLabel.value+"' data-name='"+value.itemLabel.value+"' data-id='"+wikiID+"'>Ajouter un type</button></td>"+
		    			"<td class='danger'>No description <button data-id='"+wikiID+"' class='put_description'> Put a description</button></td>"+
		    			"<td><a target='_blank' class='btn btn-default' href='"+value.item.value+"'>Link to WIKIDATA</a></td>"+
					"</tr>"
					);
				}
			}
		});

		$(".put_description").click(function(){
			OpenDynFormForPutDescriptionOnWikidataElt($(this).data('id'), $(this).data('name'));
		});

		$(".put_claim").click(function() {
			OpenDynFormForPutClaimOnWikidataElt($(this).data('id'), $(this).data('name'));
		});
	}

	function getWikidataID() {

    city_id = getCityId();
    city_data = getCityDataById(city_id, "city");
    var city_wikidataID = city_data.wikidataID;

    return city_wikidataID;
	}
		
 //  function getCityDataByInsee(insee) {

 //    $.ajax({
 //      type: "GET",
 //      url: baseUrl + "/co2/interoperability/get/insee/"+insee,
 //      async: false,
 //      success: function(data){ 
 //        mylog.log("succes get CityDataByInsee", data); //mylog.dir(data);
 //        if ((Object.keys(data).length) <= 1) {
 //          $.each(data, function(index, value) {
 //            city_data = value;
 //          });
 //        }
 //        else {
 //          city_data = data;
 //        }
 //      }
 //    });
 //    return city_data;
	// }

	function OpenDynFormForPutDescriptionOnWikidataElt(wikidataID, itemLabel) {

		var dynFormMapping = {
			wikidataID : wikidataID,
		};

		var form = {
			saveUrl : baseUrl+"/"+moduleId+"/interoperability/wikidata-put-description",
			icon : "group",
	    	type : "object",
			dynForm : {
				jsonSchema : {
					title : "Ajouter une description pour l'élément Wikidata : "+itemLabel,
					icon : "fa-group",
					afterSave : function(data){
						mylog.log("ON LANCE L'AFTER SAVE", data);
						location.reload();
						dyFObj.closeForm();		   
					},
					properties : {
						wikidataID : dyFInputs.inputHidden(),
						description : dyFInputs.inputText("Description de l'élément","Entrez ici une description pour l'élément"),
					}
				}
			}
		};

		dyFObj.openForm(form, null, dynFormMapping);
		$(".modal-header").addClass("bg-dark");
	}

	function OpenDynFormForPutClaimOnWikidataElt(wikidataID, itemLabel) {

		var dynFormMapping = {
			wikidataID : wikidataID,
		};

		var list_type_value = {};
		list_type_value["Type de l'élément"] = {};
		list_type_value["Type de l'élément"].label = "Type de l'élément";
		list_type_value["Type de l'élément"].options = {};
		list_type_value["Type de l'élément"].options.human = "Personne";
		list_type_value["Type de l'élément"].options.location = "Lieu";
		list_type_value["Type de l'élément"].options.organization = "Organisation";
		list_type_value["Type de l'élément"].options.event = "Evènement";

		var form = {
			saveUrl : baseUrl+"/"+moduleId+"/interoperability/wikidata-put-claim",
			// saveUrl : "workspace/workspace/travail/WIKIDATA/test/oauthclient-php/test_2.php",
			icon : "group",
	    	type : "object",
			dynForm : {
				jsonSchema : {
					title : "Ajouter une description pour l'élément Wikidata : "+ itemLabel,
					icon : "fa-group",
					afterSave : function(data){
						// location.reload();
						dyFObj.closeForm();		   
					},
					properties : {
						wikidataID : dyFInputs.inputHidden(),
						// claimID : dyFInputs.inputHidden(),
						claim_value : {
							label : "Type à ajouter",
			            	inputType : "select",
			            	class : "",
			            	groupOptions : list_type_value,	
						},
					}
				}
			}
		};

		dyFObj.openForm(form, null, dynFormMapping);
		$(".modal-header").addClass("bg-dark");
	}

	function listAllWikipediaArticle(wikidataID) {

		mylog.log('LE WIKIDATA ID DE LA VILLE : ', wikidataID);

		$.ajax({
      url: "https://www.wikidata.org/wiki/Special:EntityData/"+wikidataID+".json",
      type:"GET",
      dataType: "json",
      success:function(data) {
    	// all_wikidatapage_data = data;
    	var label_dbpedia = data.entities[wikidataID].sitelinks.frwiki.title;
    	getAllWikipediaArticleForCopedia(label_dbpedia);

    	$("#wiki_title").append("<a target='_blank' href='https://fr.wikipedia.org/wiki/"+label_dbpedia+"'>"+label_dbpedia+"</a>");
      },
	  });
	}

	function getWikidataIDForOneElement(label_dbpedia, description, all_data) {

		$.ajax({
      url:"https://fr.wikipedia.org/w/api.php?action=query&prop=pageprops&ppprop=wikibase_item&redirects=1&format=json&titles="+label_dbpedia,
      type:"GET",
      dataType: "jsonp",
      complete:function(data) {
      	mylog.log('WIKIDATA ID OF ONE ELEMENT ', data.responseJSON.query.pages);
      	wikidata_elt = data.responseJSON.query.pages;

      	$.each(wikidata_elt, function(index, value) {
  				getTypeOneWikidataElt(value.pageprops.wikibase_item, label_dbpedia, description, all_data);	    
  			});
      },
    });
	}

	function getTypeOneWikidataElt(wikidataID, label_dbpedia, description, all_data) {

		mylog.log('LE WIKIDATA ID DE LELEMENT EST : ', wikidataID);

		var elt_label_dbpedia_sans_spec = label_dbpedia;
		elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/"'"/g, "_QUOTE_"); 
		elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\'/g, "_SQUOTE_");
    elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/ /g, "_SPACE_");
    elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\./g, "_DOT_");
    elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\&/g, "_AND_");
    elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\(/g, "_PAR-OUVRANT_");
   	elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\)/g, "_PAR-FERMANT_");
    elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\,/g, "_VIRGULE_");

		$.ajax({
      url:"https://query.wikidata.org/sparql?format=json&query=SELECT%20DISTINCT%20%3Ftype%20%3FtypeLabel%20%3Flieu%20%3Flocation%20%3Ftime%20%3Fstarttime%20%3Fendtime%20%3Finception%20%3Fbirthdate%20WHERE%20{%20%0A%20OPTIONAL{wd%3A"+wikidataID+"%20wdt%3AP31%20%3Ftype}.%0A%20OPTIONAL{wd%3A"+wikidataID+"%20wdt%3AP131%20%3Flieu}.%0A%20OPTIONAL{wd%3A"+wikidataID+"%20wdt%3AP625%20%3Flocation}.%0A%20OPTIONAL{wd%3A"+wikidataID+"%20wdt%3AP585%20%3Ftime}.%0A%20OPTIONAL{wd%3A"+wikidataID+"%20wdt%3AP580%20%3Fstarttime}.%0A%20OPTIONAL{wd%3A"+wikidataID+"%20wdt%3AP582%20%3Fendtime}.%0A%20OPTIONAL{wd%3A"+wikidataID+"%20wdt%3AP571%20%3Finception}.%0A%20OPTIONAL{wd%3A"+wikidataID+"%20wdt%3AP569%20%3Fbirthdate}.%0A%20SERVICE%20wikibase%3Alabel%20{%20bd%3AserviceParam%20wikibase%3Alanguage%20%27fr%27.%20}%0A%0A}",
      type:"GET",
      dataType: "json",
      success:function(data) {

      	if (typeof data.results.bindings[0] !== "undefined") {

      		final_all_wikilinks[label_dbpedia] = {};
      		final_all_wikilinks[label_dbpedia].typeLabel = data.results.bindings;
      		final_all_wikilinks[label_dbpedia].description = description;
      		final_all_wikilinks[label_dbpedia].wikidataID = wikidataID;

      		if (typeof data.results.bindings[0].typeLabel !== "undefined") {

  	    		if (data.results.bindings[0].typeLabel.value == "être humain") {
  	    			nb_person++;
  	    			$('.nb-human').html(nb_person);

    					if (typeof data.results.bindings[0].birthdate !== "undefined") {

    						mylog.log('HUMAIN TROUVE AVEC UNE BIRTHDATE , ', data);

    						var new_date = {};
    						var date_array = data.results.bindings[0].birthdate.value.split("-");
    						date_array[2] = date_array[2].substr(0,2);

    						new_date.type = TimelineChart.TYPE.POINT;
    						new_date.at =  new Date([date_array[0], date_array[1], date_array[2]]);
    						new_date.customClass = "yellow-dot";
    						new_date.label_dbpedia = label_dbpedia;

    						chronoline[2].data.push(new_date);
    					}
      			} 

      			if (typeof data.results.bindings[0].time !== "undefined" || typeof data.results.bindings[0].starttime !== "undefined") {
  	    			nb_event++;
  	    			$('.nb-event').html(nb_event);

  	    			if (typeof data.results.bindings[0].time !== "undefined") {

  	    				mylog.log('VOICI L EVENT EN DETAIL AVEC TIME', data);
  	    				var new_date = {};
    						var date_array = data.results.bindings[0].time.value.split("-");
    						date_array[2] = date_array[2].substr(0,2);

    						new_date.type = TimelineChart.TYPE.POINT;
    						new_date.label = "TEST LABEL";
    						new_date.at =  new Date([date_array[0], date_array[1], date_array[2]]);
    						new_date.customClass = "orange-dot";
    						new_date.label_dbpedia = label_dbpedia;

  						  chronoline[0].data.push(new_date);
  	    			} else if (typeof data.results.bindings[0].starttime !== "undefined") {

  	    				if (typeof data.results.bindings[0].endtime !== "undefined") {
  	    					mylog.log('VOICI L EVENT EN DETAIL AVEC STARTIME ET UN ENDTIME', data);

  		    				var new_date = {};
    							var date_array_start = data.results.bindings[0].starttime.value.split("-");
    							var date_array_end = data.results.bindings[0].endtime.value.split("-");
    							date_array_start[2] = date_array_start[2].substr(0,2);
    							date_array_end[2] = date_array_end[2].substr(0,2);

    							new_date.type = TimelineChart.TYPE.INTERVAL;
    							new_date.label = label_dbpedia;
    							new_date.from =  new Date([date_array_start[0], date_array_start[1], date_array_start[2]]);
    							new_date.to = new Date([date_array_end[0], date_array_end[1], date_array_end[2]]);
    							new_date.customClass = "red-interval";
    							new_date.label_dbpedia = label_dbpedia;

  					  		chronoline[0].data.push(new_date);
  	    				} else {
  	    					mylog.log('VOICI L EVENT EN DETAIL AVEC UNIQUEMENT UN STARTIME', data);

  		    				var new_date = {};
    							var date_array_start = data.results.bindings[0].starttime.value.split("-");
    							date_array_start[2] = date_array_start[2].substr(0,2);

    							new_date.type = TimelineChart.TYPE.POINT;
    							new_date.at =  new Date([date_array_start[0], date_array_start[1], date_array_start[2]]);
    							new_date.customClass = "orange-dot";
    							new_date.label_dbpedia = label_dbpedia;

  					  		chronoline[0].data.push(new_date);
  	    				}
  	    			}
  	    		} 

  	    		if (typeof data.results.bindings[0].location !== "undefined" || typeof data.results.bindings[0].lieu !== "undefined") {
  	    			nb_location++;
  	    			$('.nb-location').html(nb_location);
  	    		} 

  	    		if (typeof data.results.bindings[0].inception !== "undefined") {
  	    			nb_orga++;
  	    			$('.nb-orga').html(nb_orga);

  	    			if (typeof data.results.bindings[0].inception !== "undefined") {

    						mylog.log('ORGA TROUVEE AVEC UNE DATE DE CREATION , ', data);

    						var new_date = {};
    						var date_array = data.results.bindings[0].inception.value.split("-");
    						date_array[2] = date_array[2].substr(0,2);

    						new_date.type = TimelineChart.TYPE.POINT;
    						new_date.at =  new Date([date_array[0], date_array[1], date_array[2]]);
    						new_date.customClass = "green-dot";
    						new_date.label_dbpedia = label_dbpedia;

    						chronoline[1].data.push(new_date);
    					}
  	    		} 

  	    		if (data.results.bindings[0].typeLabel.value !== "être humain" && typeof data.results.bindings[0].time == "undefined" && typeof data.results.bindings[0].starttime == "undefined" && typeof data.results.bindings[0].location == "undefined" && typeof data.results.bindings[0].lieu == "undefined" && typeof data.results.bindings[0].inception == "undefined") {
  	    			nb_other++;
  	    			$('.nb-other').html(nb_other);
  	    		}	 
      			$('#'+elt_label_dbpedia_sans_spec).html('<p style=text-align:center;>'+data.results.bindings[0].typeLabel.value+'</p>');
      		} else {
  	    		$('#'+elt_label_dbpedia_sans_spec).html('<button id="put_type_'+wikidataID+'" class="put_type_wikipedia_btn" data-id="'+wikidataID+'">Ajouter un type (Wikidata)</button>');
  	    		$('#'+elt_label_dbpedia_sans_spec).addClass('danger');
  	    		nb_undefined++;
  	    		$('.nb-not-defined').html(nb_undefined);
  	    	}
  	    }

  	    $('#link_'+elt_label_dbpedia_sans_spec).append(
    			'<a style="margin:10px;" class="btn btn-default" target="_blank" href="https://www.wikidata.org/wiki/'+wikidataID+'"><img style="max-height:50px;" src="'+moduleUrl+'/images/logos/logo-wikidata.png"/></a>'
    		);
      },
      error:function(data) {
      	mylog.log("IL Y A EU UNE ERREUR DANS LA RECUPERATION DU WIKIDATAID DE LELEMENT", data);
      	$('#'+elt_label_dbpedia_sans_spec).html('<b>Erreur requête API</b>');
      },
      complete:function(data) {
  	    putEventForPushTypeWikidata(wikidataID, label_dbpedia);
  	   	displayChronoLine(label_dbpedia);
      }
		});
	}

	function putEventForPushTypeWikidata(wikidataID, label_dbpedia) {

		var elt_label_dbpedia_clean = label_dbpedia.replace(/_/g, " ");

		$("#put_type_"+wikidataID).click(function(){ 
			mylog.log('ON OUVRE LE DYNFORM POUR AJOUTER UNE PROPRIETE A L\'ELEMENT');
			OpenDynFormForPutClaimOnWikidataElt($(this).data('id'), elt_label_dbpedia_clean);
		});	
	}

	function putEventOnDiscoverButton() {

    // TODO One and only one function to clean the code

		// BTN DISCOVER HUMAN 

		$(".btn-discover-human").off('click').click(function() {
			$('#all_wikipedia_item').html('');
			$.each(final_all_wikilinks, function(index, value) {
				mylog.log('LELEMENT EST : ', index);
				if (typeof value.typeLabel[0].typeLabel !== "undefined" && value.typeLabel[0].typeLabel.value == "être humain") {
					mylog.log('HUMAIN TROUVE !!!!!!!!', value);
			  	var elt_label_dbpedia_clean = index.replace(/_/g, " ");

					$("#all_wikipedia_item").append(
          	"<div id='div_"+index+"' class='col-xs-5 wikipedia_elt'>"+

            	"<a style='cursor:pointer; font-size:30px;' class='detail_elt' data-id="+index+">"+elt_label_dbpedia_clean+"</a><br>"+
            	"<p id='"+index+"'>"+value.typeLabel[0].typeLabel.value+"</p><br>"+
            	"<p id='link_"+index+"'>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.dbpedia.org/ressource/"+index+"'><img style='max-height:50px;' src='"+moduleUrl+"/images/logos/logo-dbpedia.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.wikipedia.org/wiki/"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/Wikipedia-logo-en-big.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://www.wikidata.org/wiki/"+value.wikidataID+"'><img style='max-height:50px;' src='"+moduleUrl+"/images/logos/logo-wikidata.png'/></a>"+
            	"</p>"+
            	"<button class='copedia_link' data-id='"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-copedia.png'/></button>"+
            "</div>"
          );
				}
			});
			putEventForCopediaLink();	
			putEventForDetailElt();

		});

		// BTN DISCOVER EVENT 

		$(".btn-discover-event").off('click').click(function() {
			mylog.log(final_all_wikilinks);
			$('#all_wikipedia_item').html('');
			$.each(final_all_wikilinks, function(index, value) {
				mylog.log('LELEMENT EST : ', index);
				if (typeof value.typeLabel[0].time !== "undefined" || typeof value.typeLabel[0].starttime !== "undefined") {
					mylog.log('EVENT TROUVE !!!!!!!!');
					elt_find = true;
					if (value.typeLabel[0].typeLabel !== "undefined") {
						var elt_label_dbpedia_clean = index.replace(/_/g, " ");

						$("#all_wikipedia_item").append(
            	"<div id='div_"+index+"' class='col-xs-5 wikipedia_elt'>"+

	            	"<a style='cursor:pointer; font-size:30px;' class='detail_elt' data-id="+index+">"+elt_label_dbpedia_clean+"</a><br>"+
	            	"<p id='"+index+"'>"+value.typeLabel[0].typeLabel.value+"</p><br>"+
	            	"<p id='link_"+index+"'>"+
	            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.dbpedia.org/ressource/"+index+"'><img style='max-height:50px;' src='"+moduleUrl+"/images/logos/logo-dbpedia.png'/></a>"+
	            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.wikipedia.org/wiki/"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/Wikipedia-logo-en-big.png'/></a>"+
	            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://www.wikidata.org/wiki/"+value.wikidataID+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-wikidata.png'/></a>"+
	            	"</p>"+
	            	"<button class='copedia_link' data-id='"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-copedia.png'/></button>"+
	            "</div>"
            );
					}
				}
			});
			putEventForCopediaLink();
			putEventForDetailElt();

			if (elt_find == false) {
				mylog.log('AUCUN ELEMENT TROUVEE');
				$("#all_wikilinks").html('<h3>Aucune page Wikipédia trouvée</h3>')
			}

		});

		//BTN DISCOVER ORGA

		$(".btn-discover-orga").off('click').click(function() {
			mylog.log(final_all_wikilinks);
			$('#all_wikipedia_item').html('');
			$.each(final_all_wikilinks, function(index, value) {
				mylog.log('LELEMENT EST : ', index);
				if (typeof value.typeLabel[0].inception !== "undefined") {
					mylog.log('ORGA TROUVE !!!!!!!!');
					var elt_label_dbpedia_clean = index.replace(/_/g, " ");

					$("#all_wikipedia_item").append(
          	"<div id='div_"+index+"' class='col-xs-5 wikipedia_elt'>"+
            	"<a style='cursor:pointer; font-size:30px;' class='detail_elt' data-id="+index+">"+elt_label_dbpedia_clean+"</a><br>"+
            	"<p id='"+index+"'>"+value.typeLabel[0].typeLabel.value+"</p><br>"+
            	"<p id='link_"+index+"'>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.dbpedia.org/ressource/"+index+"'><img style='max-height:50px;' src='"+moduleUrl+"/images/logos/logo-dbpedia.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.wikipedia.org/wiki/"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/Wikipedia-logo-en-big.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://www.wikidata.org/wiki/"+value.wikidataID+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-wikidata.png'/></a>"+
            	"</p>"+
            	"<button class='copedia_link' data-id='"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-copedia.png'/></button>"+
            "</div>"
          );
				}
			});
			putEventForCopediaLink();
			putEventForDetailElt();

		});

		// BTN DISCOVER LIEU 

		$(".btn-discover-location").off('click').click(function() {
			mylog.log(final_all_wikilinks);
			$('#all_wikipedia_item').html('');
			$.each(final_all_wikilinks, function(index, value) {
				mylog.log('LELEMENT EST : ', index);
				if (typeof value.typeLabel[0].location !== "undefined" || typeof value.typeLabel[0].lieu !== "undefined") {
					mylog.log('LIEU TROUVE !!!!!!!!');
					elt_find = true;
					var elt_label_dbpedia_clean = index.replace(/_/g, " ");

					$("#all_wikipedia_item").append(
          	"<div id='div_"+index+"' class='col-xs-5 wikipedia_elt'>"+

            	"<a style='cursor:pointer; font-size:30px;' class='detail_elt' data-id="+index+">"+elt_label_dbpedia_clean+"</a><br>"+
            	"<p id='"+index+"'>"+value.typeLabel[0].typeLabel.value+"</p><br>"+
            	"<p id='link_"+index+"'>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.dbpedia.org/ressource/"+index+"'><img style='max-height:50px;' src='"+moduleUrl+"/images/logos/logo-dbpedia.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.wikipedia.org/wiki/"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/Wikipedia-logo-en-big.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://www.wikidata.org/wiki/"+value.wikidataID+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-wikidata.png'/></a>"+
            	"</p>"+
            	"<button class='copedia_link' data-id='"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-copedia.png'/></button>"+
            "</div>"
          );
				}
			});
			putEventForCopediaLink();
			putEventForDetailElt();

		});

		// BTN DISCOVER OTHER

		$(".btn-discover-other").off('click').click(function() {
			mylog.log(final_all_wikilinks);
			$('#all_wikipedia_item').html('');
			$.each(final_all_wikilinks, function(index, value) {
				mylog.log('LELEMENT EST : ', index);
				if (typeof value.typeLabel[0].typeLabel !== "undefined" && typeof value.typeLabel[0].location == "undefined" && typeof value.typeLabel[0].lieu == "undefined" && typeof value.typeLabel[0].time == "undefined" && typeof value.typeLabel[0].starttime == "undefined" && value.typeLabel[0].typeLabel.value !== "être humain" && typeof value.typeLabel[0].inception == "undefined") {
					mylog.log('AUTRE TROUVE !!!!!!!!');
					elt_find = true;
					var elt_label_dbpedia_clean = index.replace(/_/g, " ");

					$("#all_wikipedia_item").append(
          	"<div id='div_"+index+"' class='col-xs-5 wikipedia_elt'>"+
            	"<a style='cursor:pointer; font-size:30px;' class='detail_elt' data-id="+index+">"+elt_label_dbpedia_clean+"</a><br>"+
            	"<p id='"+index+"'>"+value.typeLabel[0].typeLabel.value+"</p><br>"+
            	"<p id='link_"+index+"'>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.dbpedia.org/ressource/"+index+"'><img style='max-height:50px;' src='"+moduleUrl+"/images/logos/logo-dbpedia.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.wikipedia.org/wiki/"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/Wikipedia-logo-en-big.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://www.wikidata.org/wiki/"+value.wikidataID+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-wikidata.png'/></a>"+
            	"</p>"+
            	"<button class='copedia_link' data-id='"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-copedia.png'/></button>"+
            "</div>"
          );
				}
			});

			putEventForCopediaLink();
			putEventForDetailElt();


		});

		// BTN DISCOVER UNDEFINED

		$(".btn-discover-undefined").off('click').click(function() {
			mylog.log(final_all_wikilinks);
			$('#all_wikipedia_item').html('');
			$.each(final_all_wikilinks, function(index, value) {
				mylog.log('LELEMENT EST : ', index);
				if (typeof value.typeLabel[0].typeLabel == "undefined") {
					mylog.log('UNDEFINED TROUVE !!!!!!!!');
					elt_find = true;
					var elt_label_dbpedia_clean = index.replace(/_/g, " ");

					$("#all_wikipedia_item").append(
          	"<div id='div_"+index+"' class='col-xs-5 wikipedia_elt'>"+

            	"<a style='cursor:pointer; font-size:30px;' class='detail_elt' data-id="+index+">"+elt_label_dbpedia_clean+"</a><br>"+
            	"<p id='"+index+"'><button id='put_type_"+value.wikidataID+"' class='put_type_wikipedia_btn' data-id='"+value.wikidataID+"'>Ajouter un type (Wikidata)</button></p><br>"+
            	"<p id='link_"+index+"'>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.dbpedia.org/ressource/"+index+"'><img style='max-height:50px;' src='"+moduleUrl+"/images/logos/logo-dbpedia.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://fr.wikipedia.org/wiki/"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/Wikipedia-logo-en-big.png'/></a>"+
            		"<a style='margin:10px;' target='_blank' class='btn btn-default' href='https://www.wikidata.org/wiki/"+value.wikidataID+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-wikidata.png'/></a>"+
            	"</p>"+
            	"<button class='copedia_link' data-id='"+index+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-copedia.png'/></button>"+
            "</div>"
          );

          putEventForPushTypeWikidata(value.wikidataID, elt_label_dbpedia_clean);
				}

				putEventForCopediaLink();
				putEventForDetailElt();

			});
		});
	}

	function putEventForCopediaLink() {

		elt_find = true;

		$(".copedia_link").off('click').click(function(){ 
			mylog.log('On appuie sur le lien COPEDIA');
			initVarAndFunction();
			getAllWikipediaArticleForCopedia($(this).data('id'));
			$("#wiki_title").append(
				"<a target='_blank' href='https://fr.wikipedia.org/wiki/"+$(this).data('id')+"'>"+$(this).data('id')+
				"</a>"
			);
		});
	}

	function putEventForDetailElt() {

		$(".detail_elt").off('click').click(function(){ 
			mylog.log('On appuie sur le bouton détail element');
			displayDetailModal($(this).data('id'));
		});
	}

	function getAllWikipediaArticleForCopedia(label_dbpedia) {

		if (typeof label_dbpedia == "number") {
			mylog.log('CECI EST UNE DATE');
			label_dbpedia = label_dbpedia.toString();
		}

		mylog.log("LE LABEL DBPEDIA EST : ", label_dbpedia);

		label_dbpedia = label_dbpedia.replace(/_/g, " "); 

		$("#all_wikidata_item").html("");

		query_url = 'http://fr.dbpedia.org/sparql?default-graph-uri=&query=+++prefix+dbo%3A+%3Chttp%3A%2F%2Fdbpedia.org%2Fontology%2F%3E%0D%0Aprefix+dbr%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+wikidb%3A+%3Chttp%3A%2F%2Fwikidata.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+dbp%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fproperty%2F%3E%0D%0Aprefix+wiki-fr%3A+%3Chttp%3A%2F%2Ffr.wikipedia.org%2Fwiki%2F%3E%0D%0A%0D%0A+SELECT+DISTINCT+*+where+%7B%0D%0A%0D%0A++%3Fitem+rdfs%3Alabel+%22'+label_dbpedia+'%22%40fr+.%0D%0A++%3Fitem+dbo%3AwikiPageWikiLink+%3Fwikipage.%0D%0A++%3Fwikipage+dbo%3Aabstract+%3Fdescription.%0D%0A++%3Fwikipage+foaf%3AisPrimaryTopicOf+%3Fpagewiki.%0D%0A++%3Fwikipage+rdfs%3Alabel+%3FpagewikiLabel+.%0D%0A++OPTIONAL+%7B%3Fwikipage+rdfs%3Acomment+%3FshortDescription%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Alatitude+%3Flatitude%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Alongitude+%3Flongitude%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbo%3AbirthDate+%3FbirthDate%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbo%3AfoundedBy+%3FfoundedBy%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbo%3AcreationYear+%3FcreationYear%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3AsiteWeb+%3FsiteWeb%7D+.%0D%0A%0D%0A++FILTER%28lang%28%3Fdescription%29%3D%22fr%22%29.+%0D%0A++FILTER%28lang%28%3FpagewikiLabel%29%3D%22fr%22%29.%0D%0A++FILTER%28lang%28%3FshortDescription%29%3D%22fr%22%29.%0D%0A%0D%0A%7D&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on';

		mylog.log("QUERY URL : ", query_url);

		$.ajax({
      url:query_url,
      type:"GET",
      dataType: "json",
      success:function(data) {
      	mylog.log('ALL HYPERTEXT LINKS IN PAGE : ', data);
      	all_wikilinks = data;
      	displayAllWikipediaArticle(all_wikilinks.results.bindings);
      },
      error:function(data) {
      	mylog.log('ERREUR DANS L\'OPTENTION DES HYPERTEXT');
      	$("#all_wikipedia_item").html('<h2>Erreur dans la récupération des liens de la page Wikipédia</h2>');
      }
  });	
	}

	function displayAllWikipediaArticle(all_wikilinks) {

		$("#all_wikipedia_item").html('');

		$.each(all_wikilinks, function(index, value) {	

			var elt_label_dbpedia = value.pagewiki.value.substr(value.pagewiki.value.lastIndexOf("/")+1);
			var elt_label_dbpedia_clean = elt_label_dbpedia.replace(/_/g, " ");
			
			elt_label_dbpedia_sans_spec = elt_label_dbpedia;
			elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/"'"/g, "_QUOTE_"); 
			elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\'/g, "_SQUOTE_");
      elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/ /g, "_SPACE_");
      elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\./g, "_DOT_");
      elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\&/g, "_AND_");
      elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\(/g, "_PAR-OUVRANT_");
     	elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\)/g, "_PAR-FERMANT_");
      elt_label_dbpedia_sans_spec = elt_label_dbpedia_sans_spec.replace(/\,/g, "_VIRGULE_");

      $("#all_wikipedia_item").append(

      	"<div id='div_"+elt_label_dbpedia_sans_spec+"' class='col-xs-5 wikipedia_elt'>"+

        	"<a style='cursor:pointer; font-size:30px;' class='detail_elt' data-id="+elt_label_dbpedia+">"+elt_label_dbpedia_clean+"</a><br>"+
        	"<p id='"+elt_label_dbpedia_sans_spec+"'>chargement ...</p><br>"+
        	"<p id='link_"+elt_label_dbpedia_sans_spec+"'>"+
        		"<a style='margin:10px;' class='btn btn-default' target='_blank' href='"+value.wikipage.value+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-dbpedia.png'/></a>"+
        		"<a style='margin:10px;' class='btn btn-default' target='_blank' href='"+value.pagewiki.value+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/Wikipedia-logo-en-big.png'/></a>"+
        	"</p>"+
        	"<button class='copedia_link' data-id='"+elt_label_dbpedia+"'><img style='max-height:50px;'' src='"+moduleUrl+"/images/logos/logo-copedia.png'/></button>"+
        "</div>"
      );

			getWikidataIDForOneElement(elt_label_dbpedia, value.description.value, value);

			$(".wikitoco_"+elt_label_dbpedia_sans_spec).click(function() {
				OpenDynFormForWikiToCo();
			});

		});

		putEventForCopediaLink();
		putEventOnDiscoverButton();
		putEventForDetailElt();
	}

	function displayChronoLine(label_dbpedia) {

		$(".n").remove();

		mylog.log('ON ENTRE DANS LA FONCTION CHRONOLINE' , label_dbpedia);

		$("#chart").show();

		$("#chart").html('');
		
		'use strict';
    const element = document.getElementById('chart');

    const timeline = new TimelineChart(element, chronoline, {
        enableLiveTimer: true,
        tip: function(d) {
            return d.label_dbpedia || `${d.from}<br>${d.to}`;
        }
    }, label_dbpedia).onVizChange(e => console.log(e));
	}

	function displayDetailModal(label_dbpedia, wikidataID=null) {

		var clean_label_dbpedia = label_dbpedia.replace(/\_/g, " ");

		mylog.log('LE LABEL PAS CLEAN EST ', label_dbpedia);
		mylog.log('LE LABEL CLEAN EST : ', clean_label_dbpedia);

		$("#ajax-modal-modal-title").html(clean_label_dbpedia);

		$.ajax({
      url:"https://fr.wikipedia.org/w/api.php?action=query&prop=pageprops&ppprop=wikibase_item&redirects=1&format=json&titles="+label_dbpedia,
      type:"GET",
      dataType: "jsonp",
      complete:function(data) {
      	mylog.log('WIKIDATA ID OF ONE ELEMENT ', data.responseJSON.query.pages);
      	wikidata_elt = data.responseJSON.query.pages;

      	$.each(wikidata_elt, function(index, value) {
    			wikidataID = value.pageprops.wikibase_item;	    
    		});

	    	$.ajax({
	        url:"http://fr.dbpedia.org/sparql/?default-graph-uri=&query=prefix+dbo%3A+%3Chttp%3A%2F%2Fdbpedia.org%2Fontology%2F%3E%0D%0Aprefix+dbr%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+wikidb%3A+%3Chttp%3A%2F%2Fwikidata.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+dbp%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fproperty%2F%3E%0D%0Aprefix+wiki-fr%3A+%3Chttp%3A%2F%2Ffr.wikipedia.org%2Fwiki%2F%3E%0D%0A%0D%0A+SELECT+DISTINCT+*+where+%7B%0D%0A%0D%0A++%3Fitem+rdfs%3Alabel+%22"+clean_label_dbpedia+"%22%40fr+.%0D%0A++OPTIONAL%7B%3Fitem+dbo%3Aabstract+%3Fabstract%7D.%0D%0A++OPTIONAL+%7B%3Fitem+foaf%3Adepiction+%3Fdepiction+%7D.%0D%0A++FILTER%28LANG%28%3Fabstract%29+%3D+%22fr%22%29+%0D%0A%7D&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on",
	        type:"GET",
	        dataType: "json",
	        success:function(data) {
  		    	mylog.log("Détail d'un élément DBPédia", data);

  		    	$("#ajax-modal-modal-body").html('');

  		    	if (typeof data.results.bindings[0].depiction !== "undefined") {

  		    		$("#ajax-modal-modal-body").append(
  		    			"<img class='picture_element' src="+data.results.bindings[0].depiction.value+" alt='Element picture' title='Cliquez pour agrandir'/></br></br>"
  		    		);
  		    	}

  		    	$("#ajax-modal-modal-body").append("<h3>Résumé</h3>");
  		    	$("#ajax-modal-modal-body").append("<p>"+data.results.bindings[0].abstract.value+"</p>");
  		    	$("#ajax-modal-modal-body").append(

  					"<h3>Liens de l'élément</h3><br>"+
  					"<p>"+
  						"<a style='font-size:25px; margin:30px;' target='_blank' href='https://fr.wikipedia.org/wiki/"+label_dbpedia+"'><img style='max-height:100px;'' src='"+moduleUrl+"/images/logos/Wikipedia-logo-en-big.png'/></a>"+
  						"<a style='font-size:25px; margin:30px;' target='_blank' href='http://fr.dbpedia.org/page/"+label_dbpedia+"'><img style='max-height:100px;'' src='"+moduleUrl+"/images/logos/logo-dbpedia.png'/></a>"+
  						"<a style='font-size:25px; margin:30px;' target='_blank' href='https://www.wikidata.org/wiki/"+wikidataID+"'><img style='max-height:100px;'' src='"+moduleUrl+"/images/logos/logo-wikidata.png'/></a>"+
  					"</p>"
  				  );
		      }
		    });

  			$('.modal-header').addClass("bg-dark");
		    $('#ajax-modal').modal("show");
		    $('#ajax-modal').show();
		  }
		});
	}

	function getCopediaLink(url_copedia) {
		
		var copedia_link = "<a target='_blank' href='"+url_copedia+"' class='btn btn-default btn-wiki-copedia'>COPEDIA</a><br/>";

		return copedia_link;
	}

	function putWikiToCoButtonAndEvent(type=null, value, label) {
		$("#link_"+label+"").append( 
			"<button class='btn btn-default btn-wiki-wikitoco wikitoco_"+label+"'>WIKI TO CO</button>"+
			"<button class='btn btn-default btn-wiki-cotowiki'>CO TO WIKI</button>"
		);
		putEventOnCotoWikiButton(type, value, label);
	}

	function putEventOnCotoWikiButton(type=null, data=null, label=null) {

		$(".wikitoco_"+label+"").click(function(){

			mylog.log("ON OUVRE LE DYNFORM POUR CES DONNEES : ", data);

			var dynFormMapping = {
				name : data.pagewikiLabel.value,
			};

			if (typeof data.description !== "undefined")
				dynFormMapping.description = data.description.value;

			if(typeof data.shortDescription !== "undefined")
				dynFormMapping.shortDescription = data.shortDescription.value;

			if (typeof data.siteWeb !== "undefined") {
				dynFormMapping.url = data.siteWeb.value;
			}

			if (typeof data.latitude !== "undefined") {
				dynFormMapping.latitude  = data.latitude.value;
				dynFormMapping.longitude = data.longitude.value;
			}

			OpenDynForm(dynFormMapping);
		});
	}

	function OpenDynForm(mapping) {

		var form = {
			saveUrl : "ph/co2/interoperability/wikitoco",
			dynForm : {
				jsonSchema : {
					title : trad["Change password"],
					icon : "fa-group",
					properties : {
						type : dyFInputs.inputSelect("Type d'élément", "Type d'élément", elementTypes, { required : true }),
						name : "Nom de l'élément Wikipédia",
						description : "Description longue",
						url : dyFInputs.inputText("Site Web de l'élément Wikipédia", "Site Web"),
						shortDescription : 	dyFInputs.textarea("Description courte", "...",{ maxlength: 300 }),
						block : dyFInputs.inputHidden(),
						typeElement : dyFInputs.inputHidden(),
						isUpdate : dyFInputs.inputHidden(true)
					}
				}
			}
		};

		dyFObj.openForm(form, null, mapping);
	}

</script>