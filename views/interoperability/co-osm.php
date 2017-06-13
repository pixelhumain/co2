<?php
$cssAnsScriptFilesModule = array(
    '/js/default/directory.js',
    '/js/interoperability/interoperability.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

  HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                          Yii::app()->theme->baseUrl. '/assets');

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
$this->renderPartial($layoutPath.'header',
          array( "layoutPath"=>$layoutPath, 
            "page" => "interoperability") ); 
?>

<?php $this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type)); ?>

<style type="text/css">
	
.detail_one_element {

	text-align: center; 
	margin-top: 20px;
	margin-bottom: 20px; 
	border: 2px solid black; 
	border-radius: 20px; 
	/*padding: 10px;*/
	padding-top: 20px;
	padding-bottom: 20px;

}

</style>

<div style='text-align:center;'>
    <button style="margin-top: 15px;" class="btn btn-default" id="start-search-osm">
        <i class="fa fa-search"></i> Lancer la recherche
    </button>
</div>

<div style="" id="detail_one_element" class="col-xs-offset-3 col-xs-6">

</div>

<div id="all_osm_elements" class="bg-white col-xs-12">
		
</div>

<script type="text/javascript">	

$("#start-search-osm").click(function(){
	$('#detail_one_element').html("");
    initSearchOSM();
});

$("#testDynForm").click(function(){
    OpenDynForm();
});

jQuery(document).ready(function() {
    initKInterface({"affixTop":320}); 
});

function displayOSMdetail(eltID, typedef) {

	$('#detail_one_element').html(
		"<h3>Détails de l'élémént OSM N° "+eltID+"</h3><br/>"
	);

	$.ajax({
        type: "GET",
        url : "http://api.openstreetmap.org/api/0.6/node/"+eltID,
        dataType: "xml",
        error: function (data){
            mylog.log("ERROR  NODE DETAIL", data);      
        },
        success: function(data){ 

        	data_node = xmlToJson(data);
        	mylog.log('LE DETAIL DU NOEUD', data_node);

        	$("#detail_one_element").append(
				"<table class='table table-striped col-xs-12'>"+
					"<thead>"+
						"<tr>"+
						"<th>Nom du tag</th>"+
						"<th>Valeur du tag</th>"+
						"</tr>"+
					"</thead>"+
					"<tbody id='one_element_table'>"+
					"</tbody>"+
				"</table>"
			);

			list_tags_osm = [];

       		if (Array.isArray(data_node.osm.node.tag)) {

	        	$.each(data_node.osm.node.tag, function(index, value) {
	        		$("#one_element_table").append(
	        			"<tr><td>" + value.attributes.k + " </td><td> " + value.attributes.v + "</td></tr>"
	        		);
					list_tags_osm.push(value.attributes.k);
	        	});
	        } else if (typeof data_node.osm.node.tag == "object") {
        		$("#detail_one_element").append(
        			"<br>" + data_node.osm.node.tag.attributes.k + " : " + data_node.osm.node.tag.attributes.v + "<br/>"
        		);        			
    		}

			$("#detail_one_element").append("<br/><button style='margin-top20px;' class='btn btn-default' id='modif_tag_btn' data-id="+data_node.osm.node.attributes.id+">Ajouter/Modifier un tag</button>");

			$("#add_tag_btn").click(function(){
				KScrollTo("#detail_one_element");

				mylog.log("ON OUVRE LE DYNFORM POUR AJOUTER UN TAG OSM : ");

				var dynFormMapping = {
					nodeID : $(this).data("id"),
					tagname : $( "input:checked" ).val(),
				};

				OpenDynForm(dynFormMapping, $( "input:checked" ).val(), eltID, null);
			});

			$("#modif_tag_btn").click(function(){
				KScrollTo("#detail_one_element");

				var type_action_modif = true; 

				mylog.log("ON OUVRE LE DYNFORM POUR MODIFIER UN TAG OSM : ");

				var dynFormMapping = {
					nodeID : $(this).data("id"),
					// tagname : $( "input:checked" ).val(),
				};

				OpenDynForm(dynFormMapping, null, eltID, list_tags_osm);
			});
    	}
    });
}

function OpenDynForm(mapping = null, tagname = null, eltID = null, list_tags_osm = null) {

	list_options = {};
	list_all_tag_osm = [];

	// if (tagname != null) {

	var list_tags_amenity = getAllValueForTagAmenityOSM();
	var list_tags_place = getAllValueForTagPlaceOSM();
	var list_tags_office = getAllValueForTagOfficeOSM();
	var list_tags_leisure = getAllValueForTagLeisureOSM();
	var list_tags_shop = getAllValueForTagShopOSM();

	$.each(list_tags_amenity, function(index, value) {
		$.each(value, function(index, value) {
			list_all_tag_osm.push(value);
		})
	});

	$.each(list_tags_place, function(index, value) {
		$.each(value, function(index, value) {
			list_all_tag_osm.push(value);
		})
	});

	$.each(list_tags_office, function(index, value) {
		$.each(value, function(index, value) {
			list_all_tag_osm.push(value);
		})
	});

	$.each(list_tags_leisure, function(index, value) {
		$.each(value, function(index, value) {
			list_all_tag_osm.push(value);
		})
	});

	$.each(list_tags_shop, function(index, value) {
		$.each(value, function(index, value) {
			list_all_tag_osm.push(value);
		})
	});

	// if (tagname == "amenity") {
	// 	// var theme_array = getThemeArray();
	// 	list_tags_amenity = getAllValueForTagAmenityOSM();
	// 	$.each(list_tags_amenity, function(index, value) {
	// 		list_options[index] = {};
	// 		list_options[index].label = index;
	// 		list_options[index].options = {};
	// 		$.each(value, function(indextags, tagsvalue) {
	// 			list_options[index].options[tagsvalue] = tagsvalue;
	// 		})
	// 	});
	
	// }

	 // else {
	list_options["Tag à modifier"] = {};
	list_options["Tag à modifier"].label = "Tag à modifier";
	list_options["Tag à modifier"].options = {};
	$.each(list_tags_osm, function(index, value) {
		list_options["Tag à modifier"].options[value] = value;
	});

	list_type_element = {};
	list_type_element["Type de l'élément"] = {};
	list_type_element["Type de l'élément"].label = "Type de l'élément";
	list_type_element["Type de l'élément"].options = {};
	list_type_element["Type de l'élément"].options.amenity = "Amenity";
	list_type_element["Type de l'élément"].options.place = "Lieu";
	list_type_element["Type de l'élément"].options.office = "Bâtiment administratif",
	list_type_element["Type de l'élément"].options.leisure = "Loisir",
	list_type_element["Type de l'élément"].options.shop = "Boutique",

	// }

	mylog.log('LA LISTE DE TOUTES LES OPTIONS DU SELECT EST : ' , list_options);
	mylog.log('LISTE TAG OSM', list_tags_osm);

	var form = {
		saveUrl : baseUrl+"/"+moduleId+"/interoperability/co-osm-push-tag",
		icon : "group",
    	type : "object",
		dynForm : {
			jsonSchema : {
				title : "Ajouter un tag dans l'élément OSM : N° "+eltID,
				icon : "fa-group",
				afterSave : function(data){
					mylog.log("ON LANCE L'AFTER SAVE", data);
					dyFObj.closeForm();		   
				},
				properties : {
					// type : dyFInputs.inputSelect("Type d'élément", "Type d'élément", elementTypes, { required : true }),
					// name : "Nom de l'élément Wikipédia",
					user : dyFInputs.email("Votre email OSM"),
					pwd : dyFInputs.password("Votre mot de passe OSM"),
					nodeID : dyFInputs.inputHidden(),
					// tagsvalue : dyFInputs.inputSelect("Type d'élément", "Type de l'élément", test_array, { required : true }),
					// tagname : dyFInputs.inputSelect("Nom du tag", "Nom du tag", tagname_list, { required : true }),
					tagname : {
						label : "Tag à modifier",
		            	inputType : "select",
		            	class : "",
		            	groupOptions : list_options,	
					},
					tagvalue : dyFInputs.inputText("Nouvelle valeur du tag","Nouvelle valeur du tag"),
					tagnewname : {
						label : "Type à ajouter (modifier si déjà présent)",
		            	inputType : "select",
		            	class : "",
		            	groupOptions : list_type_element,	
					},
					tagnewvalue : {
						inputType : "tags",
						placeholder : "Ex : coffee",
						values : list_all_tag_osm,
						label : "Valeur du type de l'élément",
					},

				}
			}
		}
	};
	// }

	dyFObj.openForm(form, null, mapping);

	$(".modal-header").addClass("bg-dark");
}

// Changes XML to JSON
function xmlToJson(xml) {
	
	// Create the return object
	var obj = {};

	if (xml.nodeType == 1) { // element
		// do attributes
		if (xml.attributes.length > 0) {
		obj["attributes"] = {};
			for (var j = 0; j < xml.attributes.length; j++) {
				var attribute = xml.attributes.item(j);
				obj["attributes"][attribute.nodeName] = attribute.nodeValue;
			}
		}
	} else if (xml.nodeType == 3) { // text
		obj = xml.nodeValue;
	}

	// do children
	if (xml.hasChildNodes()) {
		for(var i = 0; i < xml.childNodes.length; i++) {
			var item = xml.childNodes.item(i);
			var nodeName = item.nodeName;
			if (typeof(obj[nodeName]) == "undefined") {
				obj[nodeName] = xmlToJson(item);
			} else {
				if (typeof(obj[nodeName].push) == "undefined") {
					var old = obj[nodeName];
					obj[nodeName] = [];
					obj[nodeName].push(old);
				}
				obj[nodeName].push(xmlToJson(item));
			}
		}
	}
	return obj;
};

function initSearchOSM() {

	var amenity_filter = "";

 	if (communexion.state == true) {
    	var geoShape = getGeoShapeForOsm(communexion.values.geoShape);
        var geofilter = getGeofilterPolygon(communexion.values.geoShape);
        var city_wikidataID = communexion.values.wikidataID;
        var city_insee = communexion.values.inseeCode;
    } else {
    	scope_value = getScopeValue();
        getCityDataByInsee(scope_value);

        var geoShape = getGeoShapeForOsm(city_data.geoShape);
        var geofilter = getGeofilterPolygon(city_data.geoShape);
        var city_wikidataID = city_data.wikidataID;
        var city_insee = city_data.insee;
    }

    var url_osm = 'http://overpass-api.de/api/interpreter?data=[out:json];node["name"](poly:"'+geoShape+'");out 100;';

  	var pos = url_osm.indexOf("="); 
	var url_head = url_osm.substr(0, pos+1);
	var url_param = url_osm.substr(pos +1);
	var url_osm_final = url_head + encodeURI(url_param);

	mylog.log("URL OSM" , url_osm_final);

	$.ajax({
        type: "GET",
        url : url_osm_final,
        dataType: "json",
        error: function (data){
            mylog.log("ERROR  OSM SEARCH"); mylog.dir(data);     
        },
        success: function(data){ mylog.log("SUCCES OSM SEARCH", data); //mylog.dir(data);

        	all_elements = data;

        	var typedef = "";

        	$("#all_osm_elements").html(' ');

			$("#all_osm_elements").append(
				"<table class='table table-striped'>"+
					"<thead>"+
						"<true>"+
							"<th>Noeuds</th>"+
							"<th>Tags associés</th>"+
							"<th>Lien vers la page OSM</th>"+
						"</tr>"+
					"</thead>"+
					"<tbody id='body_table_osm'>"+
					"</tbody>"+
				"</table>"
			);

		  	var icon_type = "";
		  	var tr_class = "";

        	$.each(data.elements, function(index,value) {

        		if (typeof value.tags.amenity !== "undefined") {
        			icon_type = '<i class="fa fa-exclamation"></i>';
        		} else if (typeof value.tags.shop !== "undefined") {
        			icon_type = '<i class="fa fa-shopping-cart"></i>';
        		} else if (typeof value.tags.place !== "undefined") {
        			icon_type = '<i class="fa fa-map-marker"></i>';
        		} else if (typeof value.tags.office !== "undefined") {
        			icon_type = '<i class="fa fa-industry"></i>';
        		} else if (typeof value.tags.leisure !== "undefined") {
        			icon_type = '<i class="fa fa-thumb-o-up"></i>';
        		} else {
        			icon_type = '<i class="fa fa-warning"></i>';
        		}
        		
        		if (typeof value.tags.amenity !== 'undefined' || typeof value.tags.shop !== "undefined" || typeof value.tags.place !== "undefined" || typeof value.tags.office != "undefined" || typeof value.tags.leisure !== "undefined") {

        			type_def = true;
					$("#body_table_osm").append(
        			"<tr class='info'>"+
	        			"<td>"+value.tags.name+"</td>"+
	        			"<td>"+icon_type+" Type défini. "+Object.keys(value.tags).length+" tag(s) en tout <button class='btn btn-default btn_elt_detail' data-id="+value.id+" data-typedef="+type_def+">Voir tous les tags</button></td>"+
	        			"<td><a target='_blank' class='btn btn-default' href='http://www.openstreetmap.org/node/"+value.id+"'>Lien vers la page OSM de l'élément</a></td>"+
        			"</tr>"
        			);
				} else {

					type_def = false;

					$("#body_table_osm").append(
        			"<tr class='warning'>"+
	        			"<td>"+value.tags.name+"</td>"+
	        			"<td>"+icon_type+"Type non défini ... mais "+Object.keys(value.tags).length+" autre(s) tag(s) défini(s)" + 
	        			"<button class='btn btn-default btn_elt_detail' data-id="+value.id+" data-typedef="+type_def+">Voir tous les tags</button></td>"+
	        			"<td><a target='_blank' class='btn btn-default' href='http://www.openstreetmap.org/node/"+value.id+"'>Lien vers la page OSM de l'élément<a/></td>"+
        			"</tr>"
        			);
				}
        	});

        	$(".btn_elt_detail").click(function(){
        		KScrollTo("#detail_one_element");
			    displayOSMdetail($(this).data("id"));
			    $("#detail_one_element").addClass("detail_one_element");
			});
		}
	});
}

</script>