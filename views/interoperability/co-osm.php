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

<div style='text-align:center;'>
    <button style="margin-top: 15px;" class="btn btn-default" id="start-search-osm">
        <i class="fa fa-search"></i> Lancer la recherche
    </button>
</div>

<div style="text-align: center; margin-top: 20px; margin-bottom: 20px;" id="detail_one_element" class="col-xs-12">

</div>

<!-- <div id="form_identification_osm" style="text-align: center;">
	<form method="post" action="http://127.0.0.1/workspace/workspace/travail/OSM/Services_Openstreetmap/examples/test_user_info.php">
	  OSM email : <br>
	  <input id="osm_email" type="text" name="user"><br>
	  OSM password :<br>
	  <input id="osm_pwd" type="password" name="pwd"><br>
	  Node ID : <br>
	  <input id="osm_nodeid" type="text" name="nodeID"><br>
	  Nom du tag : <br>
	  <input id="tagname" type="text" name="tagname"><br>
	  Valeur du tag :<br>
	  <input id="tagvalue" type="text" name="tagvalue"><br>
	  <input id="button_submit" type="submit" value="Add">
	</form>
</div> -->

<div id="all_osm_elements">
	<table class="table table-striped" id="all_osm_elements_table">
    	<thead>
      		<tr>
        		<th>Noeuds</th>
        		<th>Tags associés</th>
      		</tr>
    		</thead>
    	<tbody id="body_table_osm">
    	</tbody>
  	</table>
</div>

<script type="text/javascript">	

$("#start-search-osm").click(function(){
    initSearchOSM();
});

$("#testDynForm").click(function(){
    OpenDynForm();
});

// $("#form_identification_osm").hide();

// this is the id of the form
// $("#form_identification_osm").submit(function(e) {

//     var url_add_tag = "http://127.0.0.1/workspace/workspace/travail/OSM/Services_Openstreetmap/examples/test_user_info.php"; // the script where you handle the form input.

//     $.ajax({
//        type: "POST",
//        url: url_add_tag,
//        data: $(this).serialize(), // serializes the form's elements.
//        success: function(data)
//        {
//            mylog.log("SUCCESS ADD Tags"); // show response from the php script.
//        }
//     });
//     e.preventDefault(); // avoid to execute the actual submit of the form.
// });

function displayOSMdetail(eltID, typedef) {

	$('#detail_one_element').html(
		"Détails de l'élémént "+eltID+"<br/>"
		// "<button class='btn-default btn'> Ajouter un tag</button>"
	);

	$.ajax({
        type: "GET",
        url : "http://api.openstreetmap.org/api/0.6/node/"+eltID,
        dataType: "xml",
        error: function (data){
            mylog.log("ERROR  NODE DETAIL", data);      
            //signal que le chargement est terminé
        },
        success: function(data){ 

        	mylog.log("SUCCES NODE DETAIL", data); //mylog.dir(data);
        	data_node = xmlToJson(data);

       		if (Array.isArray(data_node.osm.node.tag)) {

	        	$.each(data_node.osm.node.tag, function(index, value) {
	        		$("#detail_one_element").append(
	        			"<br>" + value.attributes.k + " : " + value.attributes.v + "<br/>"
	        		);
	        	});
	        } else if (typeof data_node.osm.node.tag == "object") {
        		$("#detail_one_element").append(
        			"<br>" + data_node.osm.node.tag.attributes.k + " : " + data_node.osm.node.tag.attributes.v + "<br/>"
        		);        			
    		}

    		if (typedef == false) {

				$("#detail_one_element").append("<h4>Choisissez un type puis sa valeur<h4>");

				$("#detail_one_element").append(
					'<form id="form_type_elt">'+
						'<input type="radio" name="type" value="amenity" id="radio_amenity"> Point d\'intérêt<br>'+
						'<input type="radio" name="type" value="place" id="radio_place"> Lieu<br>'+
						'<input type="radio" name="type" value="office" id="radio_office">Office<br>'+
						'<input type="radio" name="type" value="leisure id="radio_leasure">Loisir<br>'+
					'</form>'
				);

    			$("#detail_one_element").append("<br/><button style='margin-top20px;' class='btn btn-default' id='add_tag_btn' data-id="+data_node.osm.node.attributes.id+">Définissez vous même la valeur du type de cet élémént</button>");
    		}

			$("#add_tag_btn").click(function(){
				$("#form_identification_osm").show();
				KScrollTo("#detail_one_element");

				mylog.log("ON OUVRE LE DYNFORM POUR AJOUTER UN TAG OSM : ");

				var dynFormMapping = {
					nodeID : $(this).data("id"),
					tagname : $( "input:checked" ).val(),
				};

				OpenDynForm(dynFormMapping, $( "input:checked" ).val());
			});
    	}
    });
}

function OpenDynForm(mapping = null, tagname = null) {

	list_options = {};

	if (tagname == "amenity") {
		var theme_array = getThemeArray();
		amenity_list = {};

		$.each(theme_array, function(index, value) {
			amenity_list[index] = {};
			amenity_list[index].label = index;
			amenity_list[index].options = {};
			$.each(value, function(indextags, tagsvalue) {
				amenity_list[index].options[tagsvalue] = tagsvalue;
			})
		});

		list_options = amenity_list;
	} else if (tagname == "place") {
		list_tags_place = getAllValueForTagPlaceOSM();
		$.each(list_tags_place, function(index, value) {
			list_options[index] = {};
			list_options[index].label = index;
			list_options[index].options = {};
			$.each(value, function(indextags, tagsvalue) {
				list_options[index].options[tagsvalue] = tagsvalue;
			})
		});
	} else if (tagname == "office") {
		list_tags_office = getAllValueForTagOfficeOSM();
		$.each(list_tags_office, function(index, value) {
			list_options[index] = {};
			list_options[index].label = index;
			list_options[index].options = {};
			$.each(value, function(indextags, tagsvalue) {
				list_options[index].options[tagsvalue] = tagsvalue;
			})
		});
	} else if (tagname == "leisure") {
		list_tags_leisure = getAllValueForTagLeisureOSM();
		$.each(list_tags_leisure, function(index, value) {
			list_options[index] = {};
			list_options[index].label = index;
			list_options[index].options = {};
			$.each(value, function(indextags, tagsvalue) {
				list_options[index].options[tagsvalue] = tagsvalue;
			})
		});
	}

	// var tagname_list = {};
	// tagname_list.amenity = "amenity";

	// test_array = {};
	// test_array.events = {};
	// test_array.events.label = "events";
	// test_array.events.options = {};
	// test_array.events.options.toto = "TEST CONTENU";

	var form = {
		saveUrl : "http://127.0.0.1/workspace/workspace/travail/OSM/Services_Openstreetmap/examples/test_user_info.php",
		dynForm : {
			jsonSchema : {
				title : "Ajouter un tag dans l'élément OSM : N° ",
				icon : "fa-group",
				properties : {
					// type : dyFInputs.inputSelect("Type d'élément", "Type d'élément", elementTypes, { required : true }),
					// name : "Nom de l'élément Wikipédia",
					user : dyFInputs.email("Votre email OSM"),
					pwd : dyFInputs.password("Votre mot de passe OSM"),
					nodeID : dyFInputs.inputHidden(),
					// tagvalue : dyFInputs.tags(amenity_list),
					// tagsvalue : dyFInputs.inputSelect("Type d'élément", "Type de l'élément", test_array, { required : true }),
					// tagname : dyFInputs.inputSelect("Nom du tag", "Nom du tag", tagname_list, { required : true }),
					tagname : dyFInputs.inputHidden(),
					tagvalue  :{
						label : "Type de l'élément",
		            	inputType : "select",
		            	class : "",
		               	rules : { required : true },
		            	groupOptions : list_options,	
					},
					// organizerId :{
			  //       	label : "Qui organise cet événement ?",
			  //       	rules : { required : true },
		   //          	inputType : "select",
		   //          	placeholder : "Qui organise ?",
		   //          	rules : { required : true },
		   //          	options : firstOptions(),
		   //          	groupOptions : myAdminList( ["organizations","projects"] ),
		   //          },
					// tagname : dyFInputs.inputText("Nom du tag", "Exemple : amenity"),
					// tagvalue : dyFInputs.inputText("Value du tag", "Exemple : hospital"),
					// tagvalue : dyFInputs.tags(amenity_list),
					// url : dyFInputs.inputText("Site Web de l'élément Wikipédia", "Site Web"),
					// description : "Description longue",
					// url : dyFInputs.inputText("Site Web de l'élément Wikipédia", "Site Web"),
					// shortDescription : 	dyFInputs.textarea("Description courte", "...",{ maxlength: 300 }),
					// block : dyFInputs.inputHidden(),
					// typeElement : dyFInputs.inputHidden(),
					// isUpdate : dyFInputs.inputHidden(true)
				}
			}
		}
	};

	dyFObj.openForm(form, null, mapping);
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


	scope_value = getScopeValue();
	// url_interop = getUrlInteropForOsm(geoShape, amenity_filter);

    var url_osm = 'http://overpass-api.de/api/interpreter?data=[out:json];node["name"](poly:"'+geoShape+'");out 100;';

 	//$pos = strpos($url, "=");
  	var pos = url_osm.indexOf("="); 

	// $url_head = substr($url_osm, 0, ($pos+1));
	var url_head = url_osm.substr(0, pos+1);

	// $url_param = substr($url_osm, ($pos+1));
	var url_param = url_osm.substr(pos +1);

	// var res = encodeURI(uri); 

	var url_osm_final = url_head + encodeURI(url_param);

	mylog.log("URL OSM" , url_osm_final);

	$.ajax({
        type: "GET",
        url : url_osm_final,
        dataType: "json",
        error: function (data){
            mylog.log("ERROR  OSM SEARCH"); mylog.dir(data);     
            //signal que le chargement est terminé
        },
        success: function(data){ mylog.log("SUCCES OSM SEARCH", data); //mylog.dir(data);

        	all_elements = data;

        	var typedef = "";

        	$.each(data.elements, function(index,value) {

        		if (typeof value.tags.amenity !== 'undefined' || typeof value.tags.shop !== "undefined" || typeof value.tags.place !== "undefined" || typeof value.tags.office != "undefined" || typeof value.tags.leisure !== "undefined") {

        			type_def = true;
        			mylog.log('AMENITY OU SHOP EST DEFINED');
					$("#body_table_osm").append(
        			"<tr>"+
	        			"<td>"+value.tags.name+"<td>"+
	        			"<td>Type défini. "+Object.keys(value.tags).length+" tag(s) en tout <button class='btn btn-default btn_elt_detail' data-id="+value.id+" data-typedef="+type_def+">Détails</button><td>"+
        			"<tr>"
        			);
				} else {

					type_def = false;

					mylog.log('AMENITY OU SHOP EST UNDEFINED');

					$("#body_table_osm").append(
        			"<tr>"+
	        			"<td>"+value.tags.name+"<td>"+
	        			"<td>Type non défini ... mais "+Object.keys(value.tags).length+" autre(s) tag(s) défini(s)" + 
	        			"<button class='btn btn-default btn_elt_detail' data-id="+value.id+" data-typedef="+type_def+">Détails</button><td>"+
        			"<tr>"
        			);
				}
        	});

        	$(".btn_elt_detail").click(function(){
			    displayOSMdetail($(this).data("id"), $(this).data("typedef"));
			    KScrollTo("#detail_one_element");
			});
		}
	});
}

</script>