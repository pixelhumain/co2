<?php 

$cssAnsScriptFilesModule = array(
    '/js/default/directory.js',
    '/js/interoperability/osmauth.js',
    // '/js/interoperability/interoperability.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

  HtmlHelper::registerCssAndScriptsFiles( array('/css/default/directory.css', ) , 
                                          Yii::app()->theme->baseUrl. '/assets');

// $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
//     //header + menu
// $this->renderPartial($layoutPath.'header',
//       array( "layoutPath"=>$layoutPath, 
//         "page" => "interoperability") );
?>


<style>

#all_wikilinks {
	text-align: center;
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

</style>

<center><h3>Copédia : vue d'essemble de la page Wiki de : <a id="wiki_title" target="_blank"></a></h3></center>
<br/>
<div id="all_wikilinks" class="col-xs-12"></div>
<h4><p id="type_element"></p></h4>
<div id="btn_add_type"></div>

<div id="all_properties" class="col-xs-12">
<!-- 	<h4>Liste de toutes les propriétés de l'élément Wikidata</h4>
 -->	
</div>

<center><button class="btn btn-default push_wikidata">
	Push d'une nouvelle propriété dans Wikidata
</button></center>

<?php 

	$curl = curl_init();

	$wikidataID_pos = strrpos($url_wiki, 'Q', -1);
	$wikidataID = substr($url_wiki, $wikidataID_pos);
	 
	// curl_setopt($curl, CURLOPT_URL, "https://test.wikidata.org/w/api.php?action=wbgetclaims&format=json&entity=".$wikidataID);

	curl_setopt($curl, CURLOPT_URL, "https://test.wikidata.org/w/api.php?action=wbgetclaims&format=json&entity=".$wikidataID);

	curl_setopt($curl, CURLOPT_POST, true);
	// curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id=PAR_communecter_9cfae83c352184eff02df647f08661355f3be7028c7ea4eda731bf8718efbfff&client_secret=62a4a6aa2d82fa201eca1ebb3df639882d2ed7cd75284486aaed3a436df67e55&scope=application_PAR_communecter_9cfae83c352184eff02df647f08661355f3be7028c7ea4eda731bf8718efbfff api_infotravailv1"); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$list_properties = curl_exec($curl);
	 
	curl_close($curl);
?>



<script type="text/javascript">

	// CODE AFIN D'OBTENIR TOUTES LES PROPRIETE D'UNE PAGE WIKIDATA DONNE EN PARAM GET

	// var url_wikidata = '<?php echo $url_wiki; ?>';
	// var list_properties = '<?php echo $list_properties; ?>'; 
	// var type_defined = false;
	// list_properties = JSON.parse(list_properties);

	// mylog.log("LA LISTE DES PROPERTIES D'UNE ENTITE", list_properties);

	// $.each(list_properties.claims, function(index, value) {
	// 	if (index == "P82") {
	// 		type_defined = true;
	// 		if (typeof value[0].mainsnak.datavalue.value !== "object")
	// 			$("#type_element").append("<h4>Le type de l'élément est : " + value[0].mainsnak.datavalue.value +"</h4>");
	// 		else {
	// 			wikidataID_type_elt = value[0].mainsnak.datavalue.value.id
	// 			$("#type_element").append("<h4>Le type de l'élément est : " + value[0].mainsnak.datavalue.value.id+"</h4>");
	// 		}

	// 		url_type_elt = "https://www.wikidata.org/w/api.php/?action=wbgetentities&ids="+wikidataID_type_elt+"&format=json&languages=fr";
	// 		$.ajax({
	// 	        url:url_type_elt,
	// 	        type:"GET",
	// 	        dataType: "jsonp",
	// 	        success:function(data) {
	// 		    	mylog.log('TYPE DE L\'ELEMENT : ', data);
	// 		    	type_element = data.entities[wikidataID_type_elt].labels.fr.value;
	// 		    	// type_element = data.entities[wikidataID_type_elt].id;
	// 		    	$("#type_element").append(" => " + type_element);
	// 	        },
	// 	    });
	// 	}
	// 	$("#all_properties").append("Nom de la propriété : " + index + " ==> ");
	// 	if (typeof value[0].mainsnak.datavalue.value !== "object")
	// 		$("#all_properties").append("Valeur de la propriété : " + value[0].mainsnak.datavalue.value + "<br/>");
	// 	else {
	// 		$("#all_properties").append("Valeur de la propriété : [ ");
	// 		$.each(value[0].mainsnak.datavalue.value, function(index2, value2) {
	// 			$("#all_properties").append(index2 + " : '" + value2 + "' ; ");
	// 		});
	// 		$("#all_properties").append(" ] <br/>");
	// 	}
	// });

	// // if (type_defined == false) {
	// $("#btn_add_type").append("<h4>Le type de cet élément n'est pas définit dans Wikidata !</h4>" + 
	// 	'<h4>Mettez vous aussi votre pierre à l\'édifice et contribuez</h4>'+
	// 	'<button id="push_type_element_wikidata" class="btn btn-default">' +
	// 		'Ajouter un type à l\'élément' +
	// 	'</button>'
	// );
	// // }

	// var last_slash = url_wikidata.lastIndexOf("/") + 1;
	// var wikidataID = url_wikidata.substr(last_slash);

	// $("#wiki_title").attr("href", "https://test.wikidata.org/wiki/"+wikidataID);

	// var wikidataID = wikidataID.replace(/_/g, ' ');

	// mylog.log("LABEL DBPEDIA : ", wikidataID); 

	// $("#wiki_title").html(wikidataID);

	// list_properties_url = "https://test.wikidata.org/w/api.php?action=wbgetclaims&format=json&entity=Q64477";

	// $.ajax({
 //        url:list_properties_url,
 //        type:"GET",
 //        dataType: "jsonp",
 //        success:function(data) {
	//     	mylog.log('ALL PROPERTIES FOR THIS ENTITY : ', data);
	//     	all_properties = data;
 //        },
 //        error:function(data) {
 //        	mylog.log('ERREUR DANS L\'OPTENTION DES HYPERTEXT');
 //        }
 //        // complete:function(data) {
 //    });

 //    $("#push_type_element_wikidata").click(function(){
 //    	mylog.log("ON OUVRE LE DYNFORM POUR PUSH DANS WIKIDATA : ");
	// 	// var dynFormMapping = {
	// 	// 	name : data.pagewikiLabel.value,
	// 	// };

	// 	// if (typeof data.description !== "undefined")
	// 	// 	dynFormMapping.description = data.description.value;

	// 	// if(typeof data.shortDescription !== "undefined")
	// 	// 	dynFormMapping.shortDescription = data.shortDescription.value;

	// 	// if (typeof data.siteWeb !== "undefined") {
	// 	// 	dynFormMapping.url = data.siteWeb.value;
	// 	// }

	// 	// if (typeof data.latitude !== "undefined") {
	// 	// 	dynFormMapping.latitude  = data.latitude.value;
	// 	// 	dynFormMapping.longitude = data.longitude.value;
	// 	// }
	// 	// OpenDynForm(dynFormMapping);
	// 	OpenDynFormForPushWikidata();
	// });
    
 //    $.ajax({
 //        url:"https://test.wikidata.org/w/api.php?action=query&meta=tokens&format=json&origin=*",
 //        dataType: "jsonp",
 //        success:function(data) {
	//     	mylog.log('TOKEN OBTENU: ', data);
	//     	all_properties = data;
 //        },
 //        error:function(data) {
 //        	mylog.log('ERREUR DANS L\'OPTENTION DU TOKEN');
 //        }
 //    });


    // AJAX EXEMPLE ON WIKI/MANUAL/CORS 

 //    $.ajax( {
	//     url: 'https://en.wikipedia.org/w/api.php',
	//     type : "POST",
	//     data: {
	//         action: 'query',
	//         meta: 'userinfo',
	//         format: 'json',
	//         // origin: 'https://www.mediawiki.org'
 //   	        // origin: '*'

	//     },
	//     xhrFields: {
	//         withCredentials: true
	//     },
	//     dataType: 'jsonp'
	// } ).done( function ( data ) {
	// 	mylog.log('LA DATA DE L\'AJAX EXEMPLE DE LA DOC WIKI : ', data);
	// } );

	function OpenDynFormForPushWikidata() {

		var elementTypes = {};
		elementTypes.person = "Personne";
		elementTypes.event = "Evenement";
		elementTypes.organization = "Organisation";
		elementTypes.place = "Lieu";

		var form = {
			saveUrl : "http://127.0.0.1/ph/co2/interoperability/pushtypewikidata",
			dynForm : {
				jsonSchema : {
					title : trad["Push Wikidata"],
					icon : "fa-group",
					properties : {
						type : dyFInputs.inputSelect("Type de l'élément que vous souhaitez pusher dans Wikidata", "Type de l'élément", elementTypes, { required : true }),
						// value : "Valeur de la propriété",
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
		dyFObj.openForm(form, null, {});
	}


	// CODE POUR OBTENIR TOUS LES LIENS D'UNE PAGE WIKIPEDIA DONNE EN PARAM GET

	var url_wiki = '<?php echo $url_wiki; ?>'; 

	var last_slash = url_wiki.lastIndexOf("/") + 1;
	var label_dbpedia = url_wiki.substr(last_slash);

	$("#wiki_title").attr("href", "https://fr.wikipedia.org/wiki/"+label_dbpedia);

	var label_dbpedia = label_dbpedia.replace(/_/g, ' ');

	mylog.log("LABEL DBPEDIA : ", label_dbpedia); 

	$("#wiki_title").html(label_dbpedia);

	query_url = 'http://fr.dbpedia.org/sparql?default-graph-uri=&query=+++prefix+dbo%3A+%3Chttp%3A%2F%2Fdbpedia.org%2Fontology%2F%3E%0D%0Aprefix+dbr%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+wikidb%3A+%3Chttp%3A%2F%2Fwikidata.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+dbp%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fproperty%2F%3E%0D%0Aprefix+wiki-fr%3A+%3Chttp%3A%2F%2Ffr.wikipedia.org%2Fwiki%2F%3E%0D%0A%0D%0A+SELECT+DISTINCT+*+where+%7B%0D%0A%0D%0A++%3Fitem+rdfs%3Alabel+%22'+label_dbpedia+'%22%40fr+.%0D%0A++%3Fitem+dbo%3AwikiPageWikiLink+%3Fwikipage.%0D%0A++%3Fwikipage+dbo%3Aabstract+%3Fdescription.%0D%0A++%3Fwikipage+foaf%3AisPrimaryTopicOf+%3Fpagewiki.%0D%0A++%3Fwikipage+rdfs%3Alabel+%3FpagewikiLabel+.%0D%0A++OPTIONAL+%7B%3Fwikipage+rdfs%3Acomment+%3FshortDescription%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Alatitude+%3Flatitude%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Alongitude+%3Flongitude%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbo%3AbirthDate+%3FbirthDate%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbo%3AfoundedBy+%3FfoundedBy%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbo%3AcreationYear+%3FcreationYear%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3AsiteWeb+%3FsiteWeb%7D+.%0D%0A%0D%0A++FILTER%28lang%28%3Fdescription%29%3D%22fr%22%29.+%0D%0A++FILTER%28lang%28%3FpagewikiLabel%29%3D%22fr%22%29.%0D%0A++FILTER%28lang%28%3FshortDescription%29%3D%22fr%22%29.%0D%0A%0D%0A%7D&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on';

	mylog.log("QUERY URL : ", query_url);

	$.ajax({
        url:query_url,
        type:"GET",
        dataType: "json",
        success:function(data) {
	    	mylog.log('ALL HYPERTEXT LINKS IN PAGE : ', data);
	    	all_wikilinks = data;
        },
        error:function(data) {
        	mylog.log('ERREUR DANS L\'OPTENTION DES HYPERTEXT');
        },
        complete:function(data) {

        	list_item_dbpedia = [];

		    $.each(all_wikilinks.results.bindings, function(index, value) {

		    	if (typeof(value.pagewiki) !== "undefined") {

			    	var last_slash = value.wikipage.value.lastIndexOf("/") + 1;
					var label_dbpedia = value.wikipage.value.substr(last_slash);
					var label_dbpedia = label_dbpedia.replace(/ /g, '_');

					if (list_item_dbpedia.indexOf(label_dbpedia) == -1) {
						list_item_dbpedia.push(label_dbpedia);
					
						var new_wiki_url = "http://127.0.0.1/ph/co2#interoperability.copedia?url_wiki="+value.pagewiki.value;

						var label_sans_spec = label_dbpedia;
						label_sans_spec = label_sans_spec.replace(/\'/g, "_SQUOTE_");
		                label_sans_spec = label_sans_spec.replace(/ /g, "_SPACE_");
		                label_sans_spec = label_sans_spec.replace(/\./g, "_DOT_");
		                label_sans_spec = label_sans_spec.replace(/\&/g, "_AND_");
		                label_sans_spec = label_sans_spec.replace(/\(/g, "_PAR-OUVRANT_");
		                label_sans_spec = label_sans_spec.replace(/\)/g, "_PAR-FERMANT_");
		                label_sans_spec = label_sans_spec.replace(/\,/g, "_VIRGULE_");
		                label_sans_spec = label_sans_spec.replace(/\:/g, "_DEUXPOINT_");
		                label_sans_spec = label_sans_spec.replace(/\!/g, "_EXCLAMATION_");
		                label_sans_spec = label_sans_spec.replace(/\?/g, "_INTERROGATION_");

						$("#all_wikilinks").append(
							"<div id=link_"+label_sans_spec+" class='col-xs-offset-1 col-xs-3 div-wikipage searchWikiEntityContainer'><a href='"+value.wikipage.value+"'>"+label_dbpedia+"</a></div>"
						);

						var type = "";

						if (typeof(value.birthDate) !== "undefined") {

							$("#link_"+label_sans_spec+"").append( " => Type : PERSON<br/>"+ getCopediaLink(new_wiki_url) );

							type = "contactPoint";
							
						} else if (typeof(value.latitude) !== "undefined") {

							$("#link_"+label_sans_spec+"").append( " => Type : LIEU OU RESSOURCE SITUABLE<br/>"+ getCopediaLink(new_wiki_url) );

							type = "organization";	

						} else if ((typeof(value.creationYear) !== "undefined") || (typeof(value.foundedBy) !== "undefined"))  {

							$("#link_"+label_sans_spec+"").append( " => Type : ORGANISATION / ASSOCIATION<br/>"+ getCopediaLink(new_wiki_url) );

							type = "organization";

						} else if (value.description.value.includes(" né à ") || (value.description.value.includes(" née à ")) || (value.description.value.includes(" né le")) || (value.description.value.includes(" née le")) || (value.description.value.includes(" né vers")) || (value.description.value.includes(" née vers")) || (value.description.value.substr(0, 3) == "Né ") || (value.description.value.substr(0, 4) == "Née ") || value.description.value.includes("est un personnage") ) {

							$("#link_"+label_sans_spec+"").append( " => Type : PERSON<br/>"+ getCopediaLink(new_wiki_url) );

							// type = "contactPoint";
							type = "organization";

				    	} else if (value.description.value.includes("est un quartier") || value.description.value.includes("est une ville") || value.description.value.includes("est un lieu") || value.description.value.includes("est un canton") || (value.description.value.includes("est une commune")) || value.description.value.includes("est un division administrative")) {

			    			$("#link_"+label_sans_spec+"").append( " => Type : LIEU<br/>"+ getCopediaLink(new_wiki_url) );

			    			type = "organization";

				    	} else if (value.description.value.includes("concerne l'année") || (value.description.value.includes("est également l'année")) || value.description.value.includes("e jour de l'année du calendrier") || value.description.value.includes("e année de notre ère")) {

				    		$("#link_"+label_sans_spec+"").append( " => Type : TEMPOREL<br/>"+ getCopediaLink(new_wiki_url) );

				    	} else if (value.description.value.includes("à eu lieu") || value.description.value.includes("ont eu lieu") ) {

				    		$("#link_"+label_sans_spec+"").append( " => Type : EVENEMENT<br/>"+ getCopediaLink(new_wiki_url) );

				    		type = "event";

				    	}
				    	else {

			    			$("#link_"+label_sans_spec+"").append( " => Type : AUTRE<br/>"+ getCopediaLink(new_wiki_url) );

			    			type = "wikiElt";
				    	}
				    	putWikiToCoButtonAndEvent(type, value, label_sans_spec);
				    }
			    }
		    });
        }
    });	

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
			saveUrl : "http://127.0.0.1/ph/co2/interoperability/wikitoco",
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
	
// TEMPS / PERSON / LIEUX / EVENEMENT / ORGANISATION / OBJET OU RESSOURCE

// PERSON : Q5 
// LIEU : Q17334923
// ORGANISATION : Q43229
// EVENEMENT : Q1656682


</script>