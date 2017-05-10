var current_page = 0;
var offset = 0;
var limit = 4;
var type_page = '';

var wikipedia = {

    "prefixe" : { 
        "dbpedia" : "http://fr.dbpedia.org/",
        "dbpedia_resource" : "http://fr.dbpedia.org/resource",
        "dbpedia_owl" : "http://fr.dbpedia.org/ontology",
        "dbpedia_property" : "http://fr.dbpedia.org/property"
        },
    "fr" : { 
        "depiction" : { 
            "uri" : "",
            "property" : "dbpedia_property:depiction",  
            "source" : "dbpedia"
        },
        "item" : { 
            "uri" : "",
            "property" : "dbpedia_property:depiction",  
            "source" : "dbpedia"

        },
        "abstract" : { 
            "value" : "",
            "ontology" : "dbpedia_owl:abstract", 
            "source" : "dbpedia"
        },
        "country" : {
            "value" : "",
            "ontology" : "dbpedia_owl:country",
            "uri" : "",
            "property" : "dbpedia_property:country",
            "source" : "dbpedia"
        },
        "countryLabel" : {
            "value" : "",
            "uri" : "",
            "property" : "dbpedia_property:country",
            "source" : "dbpedia"
        },
        "region" :  { 
            "value" : "",
            "ontology" : "dbpedia_owl:region",
            "uri" : "",
            "source" : "dbpedia"
        },
        "regionLabel" :  { 
            "value" : "",
            "uri" : "",
            "source" : "dbpedia"
        },
        "department" : {
            "value ": "",
            "ontology" : "dbpedia_owl:department",
            "uri" : "",
            "source" : "dbpedia"
        },
        "departmentLabel" : {
            "value ": "",
            "uri" : "",
            "source" : "dbpedia"
        },
        "maire" : { 
            "value" : "",
            "uri" : "",
            "property" : "dbpedia_property:maire",
            "source" : "dbpedia"
        },
        "maireLabel" : { 
            "value" : "",
            "property" : "dbpedia_property:maire",
            "source" : "dbpedia"
        },
        "postalCode" : { 
            "value" : 97400,
            "ontology" : "dbpedia_owl:postalCode",
            "source" : "dbpedia"
        },
        "inseeCode" : { 
            "value" : 97411,
            "ontology" : "dbpedia_owl:inseeCode",
            "property" : "dbpedia_property:insee",
            "source" : "dbpedia"
        },
        "gentile": { 
            "value" : "",
            "property" : "dbpedia_property:gentilé",
            "source" : "dbpedia"
        },
        "populationAglomeration" : { 
            "value" : 197464,
            "property" : "dbpedia_property:populationAgglomération",
            "source" : "dbpedia"
        },
        "populationTotal" : { 
            "value" : 145238 ,
            "ontology" : "dbpedia_owl:populationTotal",
            "source" : "dbpedia"
        }, 
        "superficie" : {
            "value" : 142.790000,
            "property" : "dbpedia_property:superficie",
            "source" : "dbpedia"
        },  
        "siteweb" : { 
            "value": "",
            "property" : "dbpedia_resource:siteweb",
            "source" : "dbpedia"
        }
    }
}

function getWiki(q){

    getModalTitle("wiki");   

    url_wiki ="https://www.wikidata.org/wiki/Special:EntityData/"+q+".json" 
    $.ajax({
        url:url_wiki,
        type:"GET",
        dataType: "json",
        success:function(data) {
            if( notNull(data) ){
                mylog.log('First AJAX')
                console.dir(data);
                wikidata = data;

                label_dbpedia = wikidata.entities[q].sitelinks.frwiki.title;
                wikiID = q;
                wikipage_ville = wikidata.entities[q].sitelinks.frwiki.url;

                $.ajax({
                    url: "http://fr.dbpedia.org/sparql?default-graph-uri=&query=prefix+dbo%3A+%3Chttp%3A%2F%2Fdbpedia.org%2Fontology%2F%3E%0D%0Aprefix+dbr%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+wikidb%3A+%3Chttp%3A%2F%2Fwikidata.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+dbp%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fproperty%2F%3E%0D%0A+%0D%0A%0D%0ASELECT+DISTINCT+*+where+%7B%0D%0A%0D%0A%0D%0A%0D%0A++%3Fitem+a+dbo%3ASettlement+.+%0D%0A++%3Fitem+rdfs%3Alabel+%22"+label_dbpedia+"%22%40fr+.%0D%0A%0D%0A++%3Fitem+dbo%3Aabstract+%3Fabstract+.+%0D%0A%0D%0A+%3Fitem+dbo%3Acountry+%3Fcountry+.+%0D%0A++%3Fcountry+rdfs%3Alabel+%3FcountryLabel+.%0D%0A%0D%0A+%3Fitem+dbo%3Aregion+%3Fregion+.+%0D%0A+%3Fregion+rdfs%3Alabel+%3FregionLabel+.++%0D%0A%0D%0A++%3Fitem+dbo%3Adepartment+%3Fdepartment++.+%0D%0A+++%3Fdepartment+rdfs%3Alabel+%3FdepartmentLabel+.+%0D%0A%0D%0A+OPTIONAL+%7B%3Fitem+dbo%3ApostalCode+%3FpostalCode++.%7D%0D%0A+OPTIONAL+%7B%3Fitem+dbo%3AinseeCode+%3FinseeCode++.+%7D%0D%0A%0D%0A%0D%0A+OPTIONAL+%7B%3Fitem+dbp%3Agentil%C3%A9+%3Fgentile+.+%7D%0D%0A+OPTIONAL+%7B%3Fitem+dbo%3ApopulationTotal+%3FpopulationTotal+.%7D%0D%0A%0D%0A+OPTIONAL+%7B%3Fitem+dbp%3Asuperficie+%3Fsuperficie+.+%7D%0D%0A+OPTIONAL+%7B%3Fitem+dbp%3Asiteweb+%3Fsiteweb+.+%7D%0D%0A+OPTIONAL+%7B+%3Fitem+foaf%3Adepiction+%3Fpicture+.+%7D%0D%0A%0D%0A++OPTIONAL+%7B+%3Fitem+dbp%3Amaire+%3Fmaire++.+%7D%0D%0A++OPTIONAL+%7B+%3Fitem+rdfs%3Alabel+%3FmaireLabel+.+%7D%0D%0A%0D%0A%0D%0A%0D%0A%0D%0A%0D%0A%0D%0AFILTER%28LANG%28%3FcountryLabel%29+%3D%22fr%22%29%0D%0AFILTER%28LANG%28%3FregionLabel%29+%3D%22fr%22%29%0D%0AFILTER%28LANG%28%3FdepartmentLabel%29+%3D%22fr%22%29%0D%0AFILTER%28LANG%28%3Fabstract%29+%3D+%22fr%22%29+%0D%0A%0D%0A%0D%0A+%0D%0A++%0D%0A+%7D%0D%0A&format=application%2Fsparql-results%2Bjson&CXML_redir_for_subjs=121&CXML_redir_for_hrefs=&timeout=100000000&debug=on",
                    type:"GET",
                    dataType: "jsonp",
                    success:function(data) {
                        mylog.log('Second AJAX')
                        console.dir(data)
                        data_dbpedia = data;
                        
                        var prefixe = data_dbpedia.results.bindings[0];

                        var test = ["item", "abstract", "country", "countryLabel", "region", "regionLabel", "department", "departmentLabel", "maire", "maireLabel", "postalCode", "inseeCode", "gentile", "populationTotal", "superficie", "siteweb"];

                        $.each(test, function( index, value ) {
                            if (typeof prefixe[value] == "undefined") {
                            wikipedia.fr[value].value = "Il manque cette information" ; 
                            } else { 
                            wikipedia.fr[value].value = prefixe[value].value;
                            }
                        }); 

                        if (data_dbpedia.results.bindings[0].picture !== undefined) {      
                            wikipedia.fr.depiction = data_dbpedia.results.bindings[0].picture.value;
                        } else {
                            wikipedia.fr.depiction = "/ph/assets/7d331fe5/images/thumbnail-default.jpg";
                        }

                        $("#ajax-modal-modal-title").append(
                            // "<br/><br/><a style='margin-right: 50px;' href='"+wikipage_ville+"'><img class='logo_interop' width=100 src='<?php echo $this->module->assetsUrl; ?>/images/logos/Wikipedia-logo-en-big.png'>"+
                            // "</a><br/>"+
                            "<a class='btn btn-primary' onclick='getInfoboxWikipedia(wikipedia)' style='margin-right: 50px;'>Afficher l'infobox de Wikipédia"+
                            "</a>"+
                            "<a class='btn btn-primary' onclick='getWikipediaArticle(5, 0)' style='margin-right: 50px;'>Afficher les artices Wikipédia</a>"+
                            "<a class='btn btn-primary' onclick='getWikidataItem(5, 0)'>Afficher les éléments Wikidata</a>"+
                            "</a>"
                            // "<h1 align='center'>"+
                            // "<a id='title_wiki' target='_blank' href='"+wikipedia.fr.item.value+"'> "+label_dbpedia+"</a></h1>"
                        );
                      
                        getInfoboxWikipedia(wikipedia);

                        $('.modal-footer').show();
                        $('#ajax-modal').modal("show");
                        $('#ajax-modal').show();
                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        alert("error second AJAX");
                    } 
                });               
              }
            },
        error:function (xhr, ajaxOptions, thrownError){
            alert("error first ajax");
        } 
    });
}

function displayMapWikilinks() {
  $( '#ajax-modal' ).hide();
  showMap(true);
}

function getInfoboxWikipedia(wikipedia) {

  $("#ajax-modal-modal-body").html( 

    "<div class='row bg-white'>"+
        "<div class='col-sm-10 col-sm-offset-1'> " +
            "<h2> Infobox Wikipédia </h2>"+
            "<div id='abstract'><h4><u><b>Abstract Wikipédia : </b></u></h4>"+wikipedia.fr.abstract.value+"</div> <br/>"+                                   
            "<div id='country'><u><b> Pays </b></u>: " +wikipedia.fr.countryLabel.value+" ===> URI de la ressource dbpédia : <a target='_blank' href='"+wikipedia.fr.country.value+"'> "+wikipedia.fr.country.value+"</a></div>"+
            "<div id='region'> <u><b>Région </b></u>: "+wikipedia.fr.regionLabel.value+" ===> URI vers la ressource dbpédia : <a target='_blank' href='"+wikipedia.fr.region.value+"'> "+wikipedia.fr.region.value+"</a></div>"+
            "<div id='department'><u><b> Département</b></u> : " +wikipedia.fr.departmentLabel.value+" ===> URI vers la ressource dbpédia : <a target='_blank' href='"+ wikipedia.fr.department.value+"'> "+ wikipedia.fr.department.value+"</a></div>"+ 
            "<div id='maire'> <u><b>Maire de la ville</b></u> : " +wikipedia.fr.maire.value+"</div>"+
            "<div id='postalCode'><u><b> Code postal </b></u>: " +wikipedia.fr.postalCode.value +"</div>"+
            "<div id='inseeCode'> <u><b>Code INSEE</b></u> : " +wikipedia.fr.inseeCode.value +"</div>"+
            "<div id='gentile'> <u><b>Gentilé</b></u> : " +wikipedia.fr.gentile.value +"</div>"+
            "<div id='populationTotal'><u><b> Population municipale </b></u>: " +wikipedia.fr.
populationTotal.value +"</div>"+
            "<div id='superficie'> <u><b>Superficie</b></u> : " +wikipedia.fr.superficie.value +"</div>"+
            "<div id='siteweb'><u><b> Site Web</b></u> : <a href='"+wikipedia.fr.siteweb.value+"'>" +wikipedia.fr.siteweb.value +"</a></div>"+
            "<div id='depiction'> " +
            "<div id='img_ville' align='center'><br/><img id='photo_ville' src="+ wikipedia.fr.depiction+" alt='Photo de la ville' title='Cliquez pour agrandir' width='40%' height='40%' /> </div>" + 
            "</div>"+
        "</div>"+
    "</div>");
}

function getWikipediaArticle(limit, offset) {

    limit = 4;
    type_page = "wikipedia_page";

    $.ajax({
        url:'http://fr.dbpedia.org/sparql?default-graph-uri=&query=prefix+dbo%3A+%3Chttp%3A%2F%2Fdbpedia.org%2Fontology%2F%3E%0D%0Aprefix+dbr%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+wikidb%3A+%3Chttp%3A%2F%2Fwikidata.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+dbp%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fproperty%2F%3E%0D%0Aprefix+wiki-fr%3A+%3Chttp%3A%2F%2Ffr.wikipedia.org%2Fwiki%2F%3E%0D%0A%0D%0A+SELECT+DISTINCT+*+where+%7B%0D%0A%0D%0A++%3Fitem+a+dbo%3ASettlement+.%0D%0A++%3Fitem+rdfs%3Alabel+%22'+label_dbpedia+'%22%40fr+.%0D%0A++%3Fitem+dbp%3Alatitude+%3Flatitude.%0D%0A++%3Fitem+dbp%3Alongitude+%3Flongitude.%0D%0A++%3Fitem+dbo%3AwikiPageWikiLink+%3Fwikipage.%0D%0A++%3Fwikipage+dbo%3AwikiPageID+%3Fwikipedia_id+.%0D%0A++%0D%0A++OPTIONAL+%7B%3Fwikipage+foaf%3Adepiction+%3Fpicture_item+%7D.%0D%0A%0D%0A++OPTIONAL+%7B%3Fwikipage+foaf%3AisPrimaryTopicOf+%3Fpagewiki%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+rdfs%3Alabel+%3Flabel+%7D.%0D%0A%0D%0A++OPTIONAL+%7B%3Fwikipage+dbo%3Atype+%3Ftype_item+%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Ag%C3%A9olocalisation+%3Fgeo%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Alatitude+%3Flatitude_item%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Alongitude+%3Flongitude_item%7D.%0D%0A+%0D%0A++FILTER%28lang%28%3Flabel%29%3D%22fr%22%29.%0D%0A%0D%0A++FILTER+%28%3Flatitude_item+%3C+%28%3Flatitude%2B0.2%29%29.%0D%0A++FILTER+%28%3Flatitude_item+%3E+%28%3Flatitude-0.2%29%29.%0D%0A++FILTER+%28%3Flongitude_item+%3C+%28%3Flongitude%2B0.2%29%29.%0D%0A++FILTER+%28%3Flongitude_item+%3E+%28%3Flongitude-0.2%29%29%0D%0A%0D%0A++%0D%0A+%7D%0D%0ALIMIT+'+limit+'%0D%0AOFFSET+'+offset+'&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on',
        type:"GET",
        dataType: "jsonp",
        async: false,
        success:function(data) {
            mylog.log('Third AJAX');
            mylog.dir(data);
            data_wikilinks = data;
            var contextWikipediaMap = [];
            $("#ajax-modal-modal-body").html(
                '<div>'+
                    '<h2 align="center">Articles Wikipédia en rapport avec la ville ' +
                    '<a onclick="displayMapWikilinks()" class="btn btn-primary" role="button">Sur la Map <i class="fa fa-map-marker"></i> '+ 
                    '</a>' +
                    '<a onclick="getAllWikipediaArticle()" class="btn btn-primary" style="margin-left:20px;" role="button">Afficher les TOUS ! <i class="fa fa-map-marker"></i> '+ 
                    '</a>' +
                    '</h2>' +
                    '<ul id="list_wiki_article" class="col-xs-12">'+
                    '</ul>' +  
                    '<div id="page_navigation_wikipedia"></div>'+
                '</div>'
            );

            data_length = data_wikilinks.results.bindings.length;
            nav = getPaginationStruc(limit, offset, type_page, data_length);

            $('#page_navigation_wikipedia').append(nav);

            if (offset == 0) {
                $('.btn-previous').hide();
            }

            if ((data_length == 0) || (data_length < 4)) {
                $('#ajax-modal-modal-body').append("Il n'y a plus d'élément, veuillez cliquez sur le bouton 'PREVIOUS'")
                $('.btn-next').hide();
            }

            $.each( data_wikilinks.results.bindings, function( index, value ) {

                if (value.picture_item !== undefined) {
                $("#list_wiki_article").append(
                    '<li class="wiki_article_element img-thumbnail col-sm-6 col-xs-12">'+
                        '<a class="wiki_article_links" target="_blank" href="'+value.pagewiki.value+'">'+value.label.value+
                        '<BR>' +
                        '<img class="img_wiki_element" id="photo_ville" src='+ value.picture_item.value+' title="Cliquez pour agrandir" width="100%" height="100%"/>'+
                        '</a>'+ 
                    '</li>'
                );
                } else if (value.pagewiki !== undefined) {      
                  $("#list_wiki_article").append(
                  '<li class="wiki_article_element img-thumbnail col-sm-6 col-xs-12">'+ 
                    '<a class="wiki_article_links" target="_blank" href="'+value.pagewiki.value+'">'+value.label.value+'<BR>' +
                    '<img class="img_wiki_element" src="/ph/assets/7d331fe5/images/thumbnail-default.jpg" title="Cliquez pour agrandir"/>'+
                    '</a>' +
                  '</li>'
                  );
                }
          
                var article_wikipedia_json = {
                    "_id": {
                        "$id" : value.wikipedia_id.value,
                    },
                    "geo": {
                        "@type": "GeoCoordinates",
                        "latitude": value.latitude_item.value,
                        "longitude": value.longitude_item.value,
                    },         
                    "name" :value.label.value,
                    "typeSig" : "poi",
                    //"profilMarkerImageUrl" : value.picture_item.value,
                };
                contextWikipediaMap.push(article_wikipedia_json);
            });

            Sig.showMapElements(Sig.map, contextWikipediaMap);

            if (data_wikilinks.results.bindings.length == 0) {
                $("#ajax-modal-modal-body").append('Aucun article correspondant à cette ville n\'a été trouvée ... <BR><BR>Vous aussi, contribuez à enrichir la page Wikipédia de cette ville en cliquant sur l\'icône de Wikipédia en haut à gauche de cette fenêtre');
            }
        }
  });
}   

function getWikidataItem(limit, offset) {

    limit = 5;
    type_page = "wikidata_page";

    $.ajax({
        url: 'https://query.wikidata.org/sparql?format=json&query=SELECT%20DISTINCT%20%3Fitem%20%3FitemLabel%20%3Fcoor%20%3Frange%20WHERE%20{%0A%20%3Fitem%20wdt%3AP131%20wd%3A'+wikiID+'.%0A%20%3Fitem%20%3Frange%20wd%3A'+wikiID+'.%0A%20%3Fitem%20wdt%3AP625%20%3Fcoor.%0A%20SERVICE%20wikibase%3Alabel%20{%20bd%3AserviceParam%20wikibase%3Alanguage%20%22fr%22.%20}%0A}%0ALIMIT%20'+limit+'%0AOFFSET%20'+offset,
        type:"GET",
        dataType: "json",
        success:function(data) {
            mylog.log('il rentre dans le quatrieme AJAX');
            wikidata_item = data;
            var contextWikidataMap = [];

            $("#ajax-modal-modal-body").html(
                '<div>'+
                    '<h2 style="margin-bottom: 50px;" align="center">Element Wikidata en rapport avec la ville '+
                    '<a onclick="displayMapWikilinks()" class="btn btn-primary" role="button">Sur la Map <i class="fa fa-map-marker"></i>'+
                    '</a>'+
                    '<a onclick="getAllWikidataItem()" class="btn btn-primary" style="margin-left:20px;" role="button">Afficher les TOUS ! <i class="fa fa-map-marker"></i>'+
                    '</a>'+
                    '</h2>'+
                    '<ul id="list_wikidata_item" class="col-xs-12">'+
                    '</ul>' +  
                    '<div id="page_navigation_wikidata"></div>'+
                '</div>'
            );

            data_length_wikidata = wikidata_item.results.bindings.length;         
            nav = getPaginationStruc(limit, offset, type_page, data_length_wikidata);

            $('#page_navigation_wikidata').append(nav);

            if (offset == 0) {
                $('.btn-previous').hide();
            }

            if ((data_length_wikidata == 0) || (data_length_wikidata < 5)) {
                $('#ajax-modal-modal-body').append("Il n'y a plus d'élément, veuillez cliquez sur le bouton PREVIOUS")
                $('.btn-next').hide();
            }

            $.each( wikidata_item.results.bindings, function( index, value ) {

                var coordonnees = getLatLongWikidataItem(value);

                $("#list_wikidata_item").append('<li class="wikidata_item col-xs-6"><a href="'+value.item.value+'">'+value.itemLabel.value+'</a></li>');

                var itemID = getItemWikidataID(value);

                getItemWikidataArticle(itemID);
                
                var item_wikidata_json = {
                    "_id": {
                        "$id" : coordonnees[0] + coordonnees[1],
                    },
                    "geo": {
                        "@type": "GeoCoordinates",
                        "latitude": coordonnees[1],
                        "longitude": coordonnees[0],
                    },
                    "name" :value.itemLabel.value,
                    "typeSig" : "poi",
                };
                contextWikidataMap.push(item_wikidata_json);
            });
          Sig.showMapElements(Sig.map, contextWikidataMap);
        }
    });
}

function getAllWikipediaArticle() {
  
    $.ajax({
        url: 'http://fr.dbpedia.org/sparql?default-graph-uri=&query=prefix+dbo%3A+%3Chttp%3A%2F%2Fdbpedia.org%2Fontology%2F%3E%0D%0Aprefix+dbr%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+wikidb%3A+%3Chttp%3A%2F%2Fwikidata.dbpedia.org%2Fresource%2F%3E%0D%0APREFIX+dbp%3A+%3Chttp%3A%2F%2Ffr.dbpedia.org%2Fproperty%2F%3E%0D%0Aprefix+wiki-fr%3A+%3Chttp%3A%2F%2Ffr.wikipedia.org%2Fwiki%2F%3E%0D%0A%0D%0A+SELECT+DISTINCT+*+where+%7B%0D%0A%0D%0A++%3Fitem+a+dbo%3ASettlement+.%0D%0A++%3Fitem+rdfs%3Alabel+%22'+label_dbpedia+'%22%40fr+.%0D%0A++%3Fitem+dbp%3Alatitude+%3Flatitude.%0D%0A++%3Fitem+dbp%3Alongitude+%3Flongitude.%0D%0A++%3Fitem+dbo%3AwikiPageWikiLink+%3Fwikipage.%0D%0A++%3Fwikipage+dbo%3AwikiPageID+%3Fwikipedia_id+.%0D%0A++%0D%0A++OPTIONAL+%7B%3Fwikipage+foaf%3Adepiction+%3Fpicture_item+%7D.%0D%0A%0D%0A++OPTIONAL+%7B%3Fwikipage+foaf%3AisPrimaryTopicOf+%3Fpagewiki%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+rdfs%3Alabel+%3Flabel+%7D.%0D%0A%0D%0A++OPTIONAL+%7B%3Fwikipage+dbo%3Atype+%3Ftype_item+%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Ag%C3%A9olocalisation+%3Fgeo%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Alatitude+%3Flatitude_item%7D.%0D%0A++OPTIONAL+%7B%3Fwikipage+dbp%3Alongitude+%3Flongitude_item%7D.%0D%0A+%0D%0A++FILTER%28lang%28%3Flabel%29%3D%22fr%22%29.%0D%0A%0D%0A++FILTER+%28%3Flatitude_item+%3C+%28%3Flatitude%2B0.1%29%29.%0D%0A++FILTER+%28%3Flatitude_item+%3E+%28%3Flatitude-0.1%29%29.%0D%0A++FILTER+%28%3Flongitude_item+%3C+%28%3Flongitude%2B0.1%29%29.%0D%0A++FILTER+%28%3Flongitude_item+%3E+%28%3Flongitude-0.1%29%29%0D%0A%0D%0A++%0D%0A+%7D&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on',
        type:"GET",
        dataType: "jsonp",
        async: false,
        success:function(data) {
            all_wikilinks = data;
            var contextAllWikipediaMap = [];

            $.each( all_wikilinks.results.bindings, function( index, value ) {

                var all_article_wikipedia_json = {
                "_id": {
                  "$id" : value.wikipedia_id.value,
                },
              
                "geo": {
                  "@type": "GeoCoordinates",
                  "latitude": value.latitude_item.value,
                  "longitude": value.longitude_item.value,
                },
                "name" :value.label.value,
                "typeSig" : "poi",
            };
            contextAllWikipediaMap.push(all_article_wikipedia_json);
        });

        Sig.showMapElements(Sig.map, contextAllWikipediaMap);
        displayMapWikilinks();

        }
    });
}

function getAllWikidataItem() {

    $.ajax({
        url: 'https://query.wikidata.org/sparql?format=json&query=SELECT%20DISTINCT%20%3Fitem%20%3FitemLabel%20%3Fcoor%20%3Frange%0AWHERE%0A{%0A%0A%20%3Fitem%20wdt%3AP131%20wd%3A'+wikiID+'.%0A%20%3Fitem%20%3Frange%20wd%3A'+wikiID+'.%0A%20%3Fitem%20wdt%3AP625%20%3Fcoor.%0A%20%0A%20SERVICE%20wikibase%3Alabel%20{%0A%20bd%3AserviceParam%20wikibase%3Alanguage%20%22fr%22%20.%20%0A%20}%0A}',
        type:"GET",
        dataType: "json",
        success:function(data) {
            allWikidataItem = data;
            var contextAllWikidataMap = [];

            $.each( allWikidataItem.results.bindings, function( index, value ) {

                var coordonnees = getLatLongWikidataItem(value);
                
                var all_item_wikidata_json = {
                    "_id": {
                        "$id" : coordonnees[0] + coordonnees[1],
                    },
                
                    "geo": {
                        "@type": "GeoCoordinates",
                        "latitude": coordonnees[1],
                        "longitude": coordonnees[0],
                    },
                  
                    "name" :value.itemLabel.value,
                    "typeSig" : "poi",
                };
                contextAllWikidataMap.push(all_item_wikidata_json);
            });

            Sig.showMapElements(Sig.map, contextAllWikidataMap);
            displayMapWikilinks();
        }
    });
}

function getLatLongWikidataItem(wikidata_item) {

    if (wikidata_item.coor !== undefined) {

        var coordonnees = (wikidata_item.coor.value).split(' ')
        coordonnees[0] = coordonnees[0].slice(6);
        indexof = coordonnees[1].indexOf(")");
        coordonnees[1] = coordonnees[1].slice(0, indexof);

        return coordonnees;
    }
}

//Fonctions pour la pagination 

function previous(limit, theOffset, type, data_length){

    if (type == "wikipedia_page") {
        offset = offset - 4;
        theOffset = theOffset - 4;
        getWikipediaArticle(limit, theOffset);
    } else if (type == "wikidata_page") {
        offset = offset - 5;
        theOffset = theOffset - 5;
        getWikidataItem(limit, theOffset);
    } else if (type == "opendatasoft_page") {
        offset = offset - limit;
        theOffset = theOffset - limit;
        getOpendatasoftItem(limit, theOffset);
    }
}

function next(limit, theOffset, type, data_length){

    if (type == "wikipedia_page") {
        if (data_length == 4) {
            offset = offset + 4;
            theOffset = theOffset + 4;
            getWikipediaArticle(limit, theOffset);
        }
    } else if (type == "wikidata_page") {
        if (data_length == 5) {
            offset = offset + 5;
            theOffset = theOffset + 5;
            getWikidataItem(limit, theOffset);
        }
    } else if (type == "opendatasoft_page") {
        if (data_length == limit) {
            offset = offset + limit;
            theOffset = theOffset + limit;
            getOpendatasoftItem(limit, theOffset);
        }
    }
}

function getPaginationStruc(limit, offset, type_page, data_length) {

    wikidata_page = 'wikidata_page';
    wikipedia_page = 'wikipedia_page';   
    opendatasoft_page = 'opendatasoft_page';

    var nav = '<ul class="pagination"><li ><a class="btn-previous" align="center" href="javascript:previous('+limit+','+offset+','+type_page+','+data_length+');">&laquo; PREVIOUS</a></li>';

    nav += '<li ><a  class="btn-next" href="javascript:next('+limit+','+offset+','+type_page+','+data_length+');">NEXT &raquo;</a></li></ul>';

    return nav;
} 

function getItemWikidataID(data) {

    wikidataID = data.item.value;

    indexofQ = wikidataID.indexOf("Q");
    wikidataID = wikidataID.slice(indexofQ);

    return wikidataID;

}

function getItemWikidataArticle(id) {

    $.ajax({
        url: "https://www.wikidata.org/wiki/Special:EntityData/"+id+".json",
        type:"GET",
        dataType: "json",
        async: false,
        success:function(data) {
            data_item = data;

            if (data_item.entities[id].sitelinks.frwiki !== undefined) {
            wikipedia_item_url = data_item.entities[id].sitelinks.frwiki.url;

            $("#list_wikidata_item").append('<li class="wikidata_item col-xs-6"><a href="'+wikipedia_item_url+'">'+wikipedia_item_url+'</a></li>');
            } else {
            $("#list_wikidata_item").append('<li class="wikidata_item col-xs-6">Cet élémént ne possède pas de page Wikipédia</li>');
            }
        }
    });
}

function getDatasets(insee) {

    mylog.log('Click sur le bouton data.gouv');
    mylog.log('On fait passer l\'insee ' + insee);

    getModalTitle("datagouv");

    if (typeof(data_scope_type) !== "undefined") {
        if (data_scope_type == "region") {
            url_datagouv = "";
            search_target = "de la Région : "+communexion.values.regionName;
        } else if (data_scope_type == "dep") {
            url_datagouv = "https://www.data.gouv.fr/api/1/spatial/zone/fr/county/"+communexion.values.dep+"/datasets";
            search_target = "du Département : "+communexion.values.depName;
        } else {
            url_datagouv = "https://www.data.gouv.fr/api/1/spatial/zone/fr/town/"+insee+"/datasets";
            search_target = "de la Ville : "+communexion.values.cityName;
        }
    } else {
        url_datagouv = "https://www.data.gouv.fr/api/1/spatial/zone/fr/town/"+insee+"/datasets";
        search_target = "de la Ville : "+communexion.values.cityName;
    }

    var list_orga_id = [];

    $.ajax({
        url: url_datagouv,
        type:"GET",
        dataType: "json",
        async: false,
        success:function(data) {
            mylog.log(data);
            $.getScript("https://unpkg.com/metaclic/dist/metaclic.js"); 
    
            $("#ajax-modal-modal-title").append(
                "<h1 align='center'>"+
                "<a id='title_data_gouv' href=''>Jeux de données "+search_target+"</h1></a>"
            );

            $.each(data, function( index, value ) {

                $.ajax({
                    url : value.uri,
                    type: "GET",
                    dataType: "json",
                    async : false,
                    success:function(data2) {
                        mylog.log(data2);
                        if (list_orga_id.indexOf(data2.organization.id) == -1) {
                            list_orga_id.push(data2.organization.id);
                        }
                    }
                });
            });
        },
        complete:function(data){
            mylog.log('When the AJAX is completed');

            if (list_orga_id.length > 0) {

                list_orga_id_join = list_orga_id.join();

                $("#ajax-modal-modal-body").html('<h2>Utilisation de udata-js</h2>');

                $("#ajax-modal-modal-body").append(
                    '<div '+
                        'class="Metaclic-data"'+
                        'data-organizations="'+list_orga_id_join+'"'+
                        'data-facets="all"'+
                        'data-page_size="5"/>'+
                    '</div>'
                );
            } else {
                $("#ajax-modal-modal-body").html('<h2>Aucun jeu de données '+search_target+' ... </h2>');
            }  
        }
    });

    $('#ajax-modal').modal("show");
    $('#ajax-modal').show();
}

function getGeoShapeForOsm(geoShape) {

    city_geoShape = [];

    $.each(geoShape.coordinates, function( index, value ) {

        $.each(value, function(index2, value2) {
            city_geoShape.push(value2[1], value2[0]);
        });  
    });

    res = city_geoShape.join(" ");
    return res;
}

function getGeofilterPolygon(geoShape) {

    city_geoShape = [];

    $.each(geoShape.coordinates, function(index, value) {

        $.each(value, function(index2, value2) {
            city_geoShape.push("("+value2[1], value2[0]+")");
        });
    });

    res = city_geoShape.join(",");
    return res;
}

function getListTagsCity(all_data) {

    list_tags = [];

    $.each(all_data,function(index, value) {
        $.each(value.tags, function(index2, value2) {
            if (list_tags.indexOf(index2) == -1) {
                list_tags.push(index2);
            }
        });
    });

    return list_tags;
}

function getAllOsmDataCity() {

    geoShape = getGeoShape();

    url_osm = 'http://overpass-api.de/api/interpreter?data=[out:json];node["name"](poly:"'+geoShape+'");out;';

    $.ajax({
        url : url_osm,
        type: "GET",
        dataType: "json",
        async:false,
        success:function(data) {
            mylog.log('Toute la data OSM de la ville');
            all_data_city = data.elements;
            mylog.log(all_data_city);
        }
    });

    return all_data_city;
}

function buildOsmModal() {

    all_data = getAllOsmDataCity();
    list_tags = getListTagsCity(all_data);
    mylog.log(list_tags);

    searchTags = $("#searchTags").val();
    mylog.log(searchTags);

    getModalTitle("osm");

    if (searchTags !== "") {
        $("#ajax-modal-modal-title").append(
            "<div style='margin-bottom: 20px;' class='col-xs-12'>Thématique actuelle : "+searchTags+"</div>"
        );
    } else {
        $("#ajax-modal-modal-title").append(
            "<div class='col-xs-12'>Aucune thématique choisie</div>"
        );
    }

    $("#ajax-modal-modal-title").append(
        '<select class="form-control" id="tags_select">'+
        '</select>'+
        '<br/>'+
        '<select class="form-control" id="tags_value">'+
        '</select>'+
        '<button onclick="osmResultSearch(list_tags, all_data)" id="search_by_tag" class="btn btn-default btn-directory-type glyphicon glyphicon-search"> Lancer la recherche</button><br/>'+
        '</button>'+
        '<div style="margin-bottom: 10px; margin-top:10px;" id="tag_value_selected"></div>'
    );

    tag_num = 1;

    $("#ajax-modal-modal-body").html(" ");

    $.each(list_tags, function(index, value) {

        $("#tags_select").append(
            '<option value="'+value+'">'+value+'</option>'
        );
        tag_num++;
    });

    assoc_array = getAssocTagsArray(all_data);

    $( "#tags_select" ).change(function() {
        tag_selected = $("#tags_select").val();
        getOptionForTag(assoc_array, tag_selected);

    });

    if (searchTags !== "") {
        $("#tags_select").hide();
        $("#tags_value").hide();
        $("#tags_select").html('<option value="amenity">amenity</option>');
        changeValueSelectByTheme();
    }

    $('#ajax-modal').modal("show");
    $('#ajax-modal').show();   
}

function changeValueSelectByTheme() {

    theme_array = getThemeArray();

    $.each(theme_array, function(index, value) {
        if (searchTags == index) {
            $.each(value, function(index2, value2) {
                $("#tags_value").append(
                    '<option value="'+value2+'">'+value2+'</option>'
                );
                icon = getIcon(value2);
                $("#ajax-modal-modal-title").append(
                    "<div id='btn_"+value2+"' class='col-md-4 padding-5 sectionBtnC forrent'>"+
                        "<a class='btn tagListEl btn-select-type-anc sectionBtn forrentBtn' data-tag='"+value2+"' data-key='forrent'><i class='fa fa-"+icon+" fa-2x'></i><br/>"+value2+
                        "</a>"+
                    "</div>"
                );
                putEventOnResultButton(value2); 
            });
        }
    });
}

function changeValueSelectByThemeForActivity() {

    $("#all_activity").html(' ');

    $("#all_activity").append(
        "<div id='btn_all_activity' class='col-xs-offset-4 col-md-4 padding-5 sectionBtnC forrent'>"+
            "<a class='btn tagListEl btn-select-type-anc sectionBtn forrentBtn' data-tag='all_activity' data-key='forrent'><i class='fa fa-exclamation-circle    fa-2x'></i><br/>Afficher tout le secteur d'activité"+
            "</a>"+
        "</div>"
    );

    $("#btn_all_activity").off().on('click', function(e){
        $("#select_activity").val("-1");
        $("#activity_elected_div").html("TOUT LE SECTEUR D'ACTIVITE<br/>");
        getOpendatasoftItem(limit,0);
    });

    $.each(activity_array, function(index, value) {
        if (searchTags == index) {
            $.each(value, function(index2, value2) {
                icon = getIcon(value2);

                value_sans_spec = value2;
                value_sans_spec = value_sans_spec.replace(/\'/g, "_SQUOTE_");
                value_sans_spec = value_sans_spec.replace(/ /g, "_SPACE_");
                value_sans_spec = value_sans_spec.replace(/\./g, "_DOT_");
                value_sans_spec = value_sans_spec.replace(/\&/g, "_AND_");
                value_sans_spec = value_sans_spec.replace(/\(/g, "_PAR-OUVRANT_");
                value_sans_spec = value_sans_spec.replace(/\)/g, "_PAR-FERMANT_");
                value_sans_spec = value_sans_spec.replace(/\,/g, "_VIRGULE_");

                $("#select_activity").append("<option value='"+value_sans_spec+"'>"+value2+"</option>");

                $("#all_activity").append(
                    "<div id='btn_"+value_sans_spec+"' class='col-md-6 padding-5 sectionBtnC forrent'>"+
                        "<a class='btn tagListEl btn-select-type-anc sectionBtn forrentBtn' data-tag='"+value_sans_spec+"' data-key='forrent'><i class='fa fa-"+icon+" fa-2x'></i><br/>"+value2+
                        "</a>"+
                    "</div>"
                );
                putEventOnResultButtonForActivity(value_sans_spec); 
            });
        }
    });
}

function putEventOnResultButton(value) {

    $("#btn_"+value+"").off().on('click', function(e){
        $("#tags_value").val(value);
        $('#tag_value_selected').html("Tag choisi : "+value+"<br/>");
    });
}

function putEventOnResultButtonForActivity(activity) {

    $("#btn_"+activity+"").off().on('click', function(e){
        value_with_spec = activity.replace(/_SPACE_/g, " ");
        value_with_spec = activity.replace(/_DOT_/g, ".");
        value_with_spec = activity.replace(/_AND_/g, "&");
        value_with_spec = activity.replace(/_PAR-OUVRANT_/g, "(");
        value_with_spec = activity.replace(/_PAR-FERMANT_/g, ")");
        value_with_spec = activity.replace(/_SQUOTE_/g, "'");
        value_with_spec = activity.replace(/_VIRGULE_/g, ",");
        $("#select_activity").val(activity);
        $("#activity_selected_div").html("<h2>Activité selectionné : "+value_with_spec+"<br/></h3>");
        getOpendatasoftItem(limit,0);
    });

}

function getIcon(value) {

    if (value == "clock") {
        icon = "clock-o";
    } else if (value == "recycling") {
        icon = "recycle";
    } else if (value == "cafe") {
        icon = "coffee";
    } else if ((value == "bicycle_parking") || (value == "bicycle_repair_station") || (value == "bicycle_rental")){
        icon = "bicycle";
    } else if ((value == "car_rental") || (value == "parking_entrance") || (value == "parking") || (value == "parking_space") || (value == "taxi")) {
        icon = "car";
    } else if (value == "ferry_terminal") {
        icon = "train";
    } else if (value == "motorcycle_parking") {
        icon = "motorcicycle";
    } else if ((value == "veterinary") || (value == "animal_shelter")) {
        icon = "paw";
    } 

    else {
        icon = getIconStandart();
    }

    return icon;
}

function getIconStandart() {

    if (searchTags == "commun") {
        icon = "thumbs-o-up";
    } else if (searchTags == "agriculture,alimentation") {
        icon = "cutlery";
    } else if (searchTags == "santé") {
        icon = "heartbeat";
    } else if (searchTags == "déchets") {
        icon = "trash";
    } else if (searchTags == "aménagement,transport,construction") {
        icon = "bus";
    } else if (searchTags == "éducation,petite Enfance") {
        icon = "book";
    } else if (searchTags == "citoyenneté" ) {
        icon = "user-circle-o";
    } else if (searchTags == "ess,economie social solidaire") {
        icon = "money";
    } else if (searchTags == "energie,climat") {
        icon = "sun-o";
    } else if (searchTags == "culture,animation") {
        icon = "universal-access";
    } else if (searchTags == "biodiversité") {
        icon = "tree";
    } else if (searchTags == "numérique,tic,internet") {
        icon = "laptop";
    } else {
        icon = "exclamation-circle";
    }

    return icon;
}

function getThemeArray() {

    theme_array = {};

    theme_array["commun"] = [];

    theme_array["déchets"] = [];
    theme_array["déchets"].push("waste_basket");
    theme_array["déchets"].push("recycling");
    theme_array["déchets"].push("waste_disposal");
    theme_array["déchets"].push("waste_transfert_station");

    theme_array["agriculture,alimentation"] = [];
    theme_array["agriculture,alimentation"].push("restaurant");
    theme_array["agriculture,alimentation"].push("pub");
    theme_array["agriculture,alimentation"].push("fast_food");
    theme_array["agriculture,alimentation"].push("bar");
    theme_array["agriculture,alimentation"].push("bbq");
    theme_array["agriculture,alimentation"].push("biergarten");
    theme_array["agriculture,alimentation"].push("cafe");
    theme_array["agriculture,alimentation"].push("food_court");
    theme_array["agriculture,alimentation"].push("ice_cream");
    theme_array["agriculture,alimentation"].push("marketplace");

    theme_array["santé"] = [];
    theme_array["santé"].push("doctors");
    theme_array["santé"].push("pharmacy");
    theme_array["santé"].push("veterinary");
    theme_array["santé"].push("hospital");
    theme_array["santé"].push("baby_hatch");
    theme_array["santé"].push("clinic");
    theme_array["santé"].push("nursing_home");
    theme_array["santé"].push("social_facility");

    theme_array["aménagement,transport,construction"] = [];
    theme_array["aménagement,transport,construction"].push("bicycle_parking");
    theme_array["aménagement,transport,construction"].push("bicycle_repair_station");
    theme_array["aménagement,transport,construction"].push("bicycle_rental");
    theme_array["aménagement,transport,construction"].push("boat_sharing");
    theme_array["aménagement,transport,construction"].push("bus_station");
    theme_array["aménagement,transport,construction"].push("car_rental");
    theme_array["aménagement,transport,construction"].push("car_sharing");
    theme_array["aménagement,transport,construction"].push("car_wash");
    theme_array["aménagement,transport,construction"].push("charging_station");
    theme_array["aménagement,transport,construction"].push("fuel");
    theme_array["aménagement,transport,construction"].push("ferry_terminal");
    theme_array["aménagement,transport,construction"].push("grit_bin");
    theme_array["aménagement,transport,construction"].push("motorcycle_parking");
    theme_array["aménagement,transport,construction"].push("parking");
    theme_array["aménagement,transport,construction"].push("parking_entrance");
    theme_array["aménagement,transport,construction"].push("parking_space");
    theme_array["aménagement,transport,construction"].push("taxi");
    theme_array["aménagement,transport,construction"].push("bench");
    theme_array["aménagement,transport,construction"].push("clock");
    theme_array["aménagement,transport,construction"].push("courthouse");
    theme_array["aménagement,transport,construction"].push("coworking_space");
    theme_array["aménagement,transport,construction"].push("crematorium");
    theme_array["aménagement,transport,construction"].push("crypt");
    theme_array["aménagement,transport,construction"].push("dive_centre");
    theme_array["aménagement,transport,construction"].push("dojo");
    theme_array["aménagement,transport,construction"].push("embassy");
    theme_array["aménagement,transport,construction"].push("fire_station");
    theme_array["aménagement,transport,construction"].push("game_feeding");
    theme_array["aménagement,transport,construction"].push("grave_yard");
    theme_array["aménagement,transport,construction"].push("hunting_stand");
    theme_array["aménagement,transport,construction"].push("photo_booth");
    theme_array["aménagement,transport,construction"].push("place_of_worship");
    theme_array["aménagement,transport,construction"].push("police");
    theme_array["aménagement,transport,construction"].push("post_box");
    theme_array["aménagement,transport,construction"].push("post_office");
    theme_array["aménagement,transport,construction"].push("prison");
    theme_array["aménagement,transport,construction"].push("ranger_station");
    theme_array["aménagement,transport,construction"].push("shelter");
    theme_array["aménagement,transport,construction"].push("shower");
    theme_array["aménagement,transport,construction"].push("table");
    theme_array["aménagement,transport,construction"].push("telephone");
    theme_array["aménagement,transport,construction"].push("toilets");
    theme_array["aménagement,transport,construction"].push("townhall");
    theme_array["aménagement,transport,construction"].push("vending_machine");
    theme_array["aménagement,transport,construction"].push("watering_place");
    theme_array["aménagement,transport,construction"].push("water_point");

    theme_array["éducation,petite Enfance"] = [];
    theme_array["éducation,petite Enfance"].push("school");
    theme_array["éducation,petite Enfance"].push("university");
    theme_array["éducation,petite Enfance"].push("college");
    theme_array["éducation,petite Enfance"].push("kindergarten");
    theme_array["éducation,petite Enfance"].push("childcare");
    theme_array["éducation,petite Enfance"].push("music_school");
    theme_array["éducation,petite Enfance"].push("driving_school");
    theme_array["éducation,petite Enfance"].push("language_school");

    theme_array["citoyenneté"] = [];

    theme_array["ess,economie social solidaire"] = [];
    theme_array["ess,economie social solidaire"].push("atm");
    theme_array["ess,economie social solidaire"].push("bank");
    theme_array["ess,economie social solidaire"].push("bureau_de_change");
    theme_array["ess,economie social solidaire"].push("social_centre");
    theme_array["ess,economie social solidaire"].push("animal_shelter");
    theme_array["ess,economie social solidaire"].push("rescue_station");

    theme_array["energie,climat"] = [];

    theme_array["culture,animation"] = [];
    theme_array["culture,animation"].push("theatre");
    theme_array["culture,animation"].push("cinema");
    theme_array["culture,animation"].push("library");
    theme_array["culture,animation"].push("arts_centre");
    theme_array["culture,animation"].push("brothel");
    theme_array["culture,animation"].push("stripclub");
    theme_array["culture,animation"].push("swingerclub");
    theme_array["culture,animation"].push("casino");
    theme_array["culture,animation"].push("community_centre");
    theme_array["culture,animation"].push("fountain");
    theme_array["culture,animation"].push("gambling");
    theme_array["culture,animation"].push("nightclub");
    theme_array["culture,animation"].push("planetarium");
    theme_array["culture,animation"].push("studio");

    theme_array["biodiversité"] = [];

    theme_array["numérique,tic,internet"] = [];
    theme_array["numérique,tic,internet"].push("internet_cafe");

    return theme_array;
}

function getActivityArray() {

    activity_array = {};

    activity_array["commun"] = [];
    activity_array["commun"].push("Autres organisations fonctionnant par adhésion volontaire");

    activity_array["déchets"] = [];

    activity_array["agriculture,alimentation"] = [];
    activity_array["agriculture,alimentation"].push("Culture de céréales (sf riz) légumineuses, graines oléagineuses");
    activity_array["agriculture,alimentation"].push("Restauration traditionnelle");
    activity_array["agriculture,alimentation"].push("Culture de la vigne");
    activity_array["agriculture,alimentation"].push("Restauration de type rapide");
    activity_array["agriculture,alimentation"].push("Élevage d'autres bovins et de buffles");
    activity_array["agriculture,alimentation"].push("Élevage de vaches laitières");
    activity_array["agriculture,alimentation"].push("Culture et élevage associés");
    activity_array["agriculture,alimentation"].push("Élevage d'autres animaux");
    activity_array["agriculture,alimentation"].push("Débits de boissons");
    activity_array["agriculture,alimentation"].push("Boulangerie et boulangerie-pâtisserie");
    activity_array["agriculture,alimentation"].push("Commerce de détail alimentaire sur éventaires et marchés");
    activity_array["agriculture,alimentation"].push("Commerce d'alimentation générale");
    activity_array["agriculture,alimentation"].push("Élevage d'ovins et de caprins");
    activity_array["agriculture,alimentation"].push("Culture de légumes, de melons, de racines et de tubercules");
    activity_array["agriculture,alimentation"].push("Sylviculture et autres activités forestières");

    activity_array["santé"] = [];
    activity_array["santé"].push("Activité profess. rééducation appareillage & pédicures-podologues");
    activity_array["santé"].push("Activités des infirmiers et des sages-femmes");
    activity_array["santé"].push("Activité des médecins généralistes");
    activity_array["santé"].push("Activités de santé humaine non classées ailleurs");
    activity_array["santé"].push("Autres services personnels n.c.a");
    activity_array["santé"].push("Autres activités des médecins spécialistes");
    activity_array["santé"].push("Pratique dentaire");
    activity_array["santé"].push("Commerce de détail produits pharmaceutiques (magasin spécialisé)");

    activity_array["aménagement,transport,construction"] = [];
    activity_array["aménagement,transport,construction"].push("Location de terrains et d'autres biens immobiliers")
    activity_array["aménagement,transport,construction"].push("Location de logements");
    activity_array["aménagement,transport,construction"].push("Activités combinées de soutien lié aux bâtiments");
    activity_array["aménagement,transport,construction"].push("Travaux de maçonnerie générale et gros oeuvre de bâtiment");
    activity_array["aménagement,transport,construction"].push("Agences immobilières");
    activity_array["aménagement,transport,construction"].push("Transports de voyageurs par taxis");
    activity_array["aménagement,transport,construction"].push("Entretien et réparation de véhicules automobiles légers");
    activity_array["aménagement,transport,construction"].push("Commerce de voitures et de véhicules automobiles légers");
    activity_array["aménagement,transport,construction"].push("Administration d'immeubles et autres biens immobiliers");
    activity_array["aménagement,transport,construction"].push("Activités d'architecture");
    activity_array["aménagement,transport,construction"].push("Services d'aménagement paysager");
    activity_array["aménagement,transport,construction"].push("Hébergement touristique et autre hébergement de courte durée");
    activity_array["aménagement,transport,construction"].push("Hôtels et hébergement similaire");
    activity_array["aménagement,transport,construction"].push("Activités des marchands de biens immobiliers");
    activity_array["aménagement,transport,construction"].push("Construction de maisons individuelles");
    activity_array["aménagement,transport,construction"].push("Transports routiers de fret de proximité");
    activity_array["aménagement,transport,construction"].push("Travaux de terrassement courants et travaux préparatoires");

    activity_array["éducation,petite Enfance"] = [];

    activity_array["citoyenneté"] = [];
    activity_array["citoyenneté"].push("Conseil pour les affaires et autres conseils de gestion");
    activity_array["citoyenneté"].push("Administration publique générale");

    activity_array["ess,economie social solidaire"] = [];
    activity_array["ess,economie social solidaire"].push("Vente à domicile");
    activity_array["ess,economie social solidaire"].push("Autres commerces de détail sur éventaires et marchés");
    activity_array["ess,economie social solidaire"].push("Commerce de détail d'habillement en magasin spécialisé");
    activity_array["ess,economie social solidaire"].push("Action sociale sans hébergement n.c.a.");
    activity_array["ess,economie social solidaire"].push("Autres intermédiaires du commerce en produits divers");
    activity_array["ess,economie social solidaire"].push("Autres commerces de détail spécialisés divers");
    activity_array["ess,economie social solidaire"].push("Autres activités de soutien aux entreprises n.c.a.");
    activity_array["ess,economie social solidaire"].push("Autres intermédiations monétaires");
    activity_array["ess,economie social solidaire"].push("Activités des sièges sociaux");
    activity_array["ess,economie social solidaire"].push("Commerce de gros (commerce interentreprises) non spécialisé");

    activity_array["energie,climat"] = [];
    activity_array["energie,climat"].push("Travaux d'installation électrique dans tous locaux");
    activity_array["energie,climat"].push("Production d'électricité");
    activity_array["energie,climat"].push("Travaux d'installation d'eau et de gaz en tous locaux");

    activity_array["culture,animation"] = [];
    activity_array["culture,animation"].push("Activités de clubs de sports");
    activity_array["culture,animation"].push("Arts du spectacle vivant");
    activity_array["culture,animation"].push("Création artistique relevant des arts plastiques");
    activity_array["culture,animation"].push("Enseignement de disciplines sportives et d'activités de loisirs");
    activity_array["culture,animation"].push("Autres activités récréatives et de loisirs");
    activity_array["culture,animation"].push("Autre création artistique");
    activity_array["culture,animation"].push("Enseignement culturel");
    activity_array["culture,animation"].push("Activités de soutien aux cultures");
    activity_array["culture,animation"].push("Activités de soutien au spectacle vivant");

    activity_array["biodiversité"] = [];

    activity_array["numérique,tic,internet"] = [];
    activity_array["numérique,tic,internet"].push("Programmation informatique");
    activity_array["numérique,tic,internet"].push("Conseil en systèmes et logiciels informatiques");

    activity_array["autres"] = [];
    activity_array["autres"].push("Activités des sociétés holding");
    activity_array["autres"].push("Activités juridiques");
    activity_array["autres"].push("Coiffure");
    activity_array["autres"].push("Travaux de peinture et vitrerie");
    activity_array["autres"].push("Ingénierie, études techniques");
    activity_array["autres"].push("Travaux de menuiserie bois et PVC");
    activity_array["autres"].push("Formation continue d'adultes");
    activity_array["autres"].push("Supports juridiques de programmes");
    activity_array["autres"].push("Nettoyage courant des bâtiments");
    activity_array["autres"].push("Autres enseignements");
    activity_array["autres"].push("Soins de beauté");
    activity_array["autres"].push("Activités spécialisées de design");
    activity_array["autres"].push("Activités des agents et courtiers d'assurances");
    activity_array["autres"].push("Photocopie prépa. documents & aut. activ. spéc. soutien de bureau");
    activity_array["autres"].push("En attente de chiffrement sans activité");
    activity_array["autres"].push("Travaux de plâtrerie");
    activity_array["autres"].push("Conseil en relations publiques et communication");
    activity_array["autres"].push("Activités comptables");
    activity_array["autres"].push("Travaux de revêtement des sols et des murs");
    activity_array["autres"].push("Activités spécialisées, scientifiques et techniques diverses");
    activity_array["autres"].push("Activités photographiques");
    activity_array["autres"].push("Activités des agences de publicité");
    activity_array["autres"].push("Supports juridiques de gestion de patrimoine mobilier");
    activity_array["autres"].push("Travaux d'installation équipements thermiques et climatisation");
    activity_array["autres"].push("Autres activités liées au sport");
    activity_array["autres"].push("Comm. détail textiles habillt & chaussures s/éventaires & marchés");
    activity_array["autres"].push("Autres travaux de finition");
    activity_array["autres"].push("Location et location-bail machines, équipements et biens divers");
    activity_array["autres"].push("Vente à distance sur catalogue spécialisé");
    activity_array["autres"].push("Vente à distance sur catalogue général");
    activity_array["autres"].push("Réparation d'autres biens personnels et domestiques");
    activity_array["autres"].push("Travaux de couverture par éléments");
    activity_array["autres"].push("Traduction et interprétation");

    return activity_array;

}

function osmResultSearch(list_tags, all_data) {

    contextOmsElt = [];

    tag_selected = $("#tags_select").val();
    tag_name_selected = $("#tags_value").val();

    if (tag_name_selected == "no_value") {
        tag_name_selected = null;
    }

    if ( (tag_selected !== null) && (  (tag_name_selected !== null)  /*||  (tag_name_selected !== "no_value" ) */ ) )  {

        $("#ajax-modal-modal-body").html("<h2>Liste des elements qui ont pour tag "+tag_selected+" et pour valeur de tag "+tag_name_selected+"</h2><br/>");

        $("#ajax-modal-modal-body").append(
            '<a id="btn-osm-map" onclick="displayMapWikilinks()" class="btn btn-primary" role="button"> Afficher les éléments ci-dessous sur la Map <i class="fa fa-map-marker"></i>'+ 
            '</a><br/><br/>' 
        );

        $.each(all_data, function(index, value) {
            if ((tag_selected in value.tags) && (value.tags[tag_selected] == tag_name_selected)) {
                $("#ajax-modal-modal-body").append(
                    "<div style='margin-bottom: 10px;margin-top: 10px;' id='"+value.id+"' class='colonne col-md-4 col-xs-6'>"+
                        "<a href='http://www.openstreetmap.org/node/"+value.id+"'>"+value.tags.name+" <i class='fa fa-map-marker'></i></a><br/>"+
                    "</div>"
                    );
                if ("amenity" in value.tags) {
                    $("#"+value.id+"").append("Amenity = "+value.tags.amenity+"");
                }
                if ("shop" in value.tags) {
                    $("#"+value.id+"").append("Shop = "+value.tags.shop+"");
                }
                if ("wikipedia" in value.tags) {
                    $("#"+value.id+"").append(
                        "<a href='https://fr.wikipedia.org/wiki/"+value.tags.wikipedia+"'><img width=30 src='<?php echo $this->module->assetsUrl; ?>/images/logos/Wikipedia-logo-en-big.png'> Lien Wikipédia</a><br/>"
                    );
                }
                if ("wikidata" in value.tags) {
                    $("#"+value.id+"").append("<a href='https://www.wikidata.org/wiki/"+value.tags.wikidata+"'><img width=30 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo-wikidata.png'> https://www.wikidata.org/wiki/"+value.tags.wikidata+"</a><br/>");
                }

                contextOmsElt.push(OneOsmItemOnMap(value));
            }
        });

    } else if ((tag_selected !== null) && ((tag_name_selected == null) || (tag_name_selected == "no_value"))) {
        $("#ajax-modal-modal-body").html("<h2>Liste des elements qui ont pour tag "+tag_selected+"</h2><br/>");

        $("#ajax-modal-modal-body").append(
            '<a id="btn-osm-map" onclick="displayMapWikilinks()" class="btn btn-primary" role="button"> Afficher les éléments ci-dessous sur la Map <i class="fa fa-map-marker"></i>'+ 
            '</a><br/><br/>'+
            '<div id="items_osm" class="disptable col-xs-12"></div>' 
        );
        $.each(all_data, function(index, value) {
            if (tag_selected in value.tags) {
                $("#items_osm").append(
                    "<div style='margin-bottom: 10px;margin-top: 10px;' id='"+value.id+"' class='colonne col-md-4 col-xs-6'>"+
                        "<a href='http://www.openstreetmap.org/node/"+value.id+"'>"+value.tags.name+" <i class='fa fa-map-marker'></i></a><br/>"+
                    "</div>"
                    );
                if ("amenity" in value.tags) {
                    $("#"+value.id+"").append("Amenity = "+value.tags.amenity+"");
                }
                if ("shop" in value.tags) {
                    $("#"+value.id+"").append("Shop = "+value.tags.shop+"");
                }
                if ("wikipedia" in value.tags) {
                    $("#"+value.id+"").append("<a href='https://fr.wikipedia.org/wiki/"+value.tags.wikipedia+"'><img width=30 src='<?php echo $this->module->assetsUrl; ?>/images/logos/Wikipedia-logo-en-big.png'> https://fr.wikipedia.org/wiki/"+value.tags.wikipedia+"</a><br/>");
                }
                if ("wikidata" in value.tags) {
                    $("#"+value.id+"").append("<a href='https://www.wikidata.org/wiki/"+value.tags.wikidata+"'><img width=30 src='<?php echo $this->module->assetsUrl; ?>/images/logos/logo-wikidata.png'> https://www.wikidata.org/wiki/"+value.tags.wikidata+"</a><br/>");
                }

                contextOmsElt.push(OneOsmItemOnMap(value));
            }
        });

        assoc_array = getAssocTagsArray(all_data);
        mylog.log(assoc_array);

        getOptionForTag(assoc_array,tag_selected);
    }

    Sig.showMapElements(Sig.map, contextOmsElt);    
}

function getOptionForTag(assoc_array, tag_selected) {

    $("#tags_value").html("<option value='no_value'>Afficher tous les éléments qui ont le tag "+tag_selected+"</option>");

    $.each(assoc_array, function(index, value) {
        if (index == tag_selected) {
            $.each(value, function(index2, value2) {
                $("#tags_value").append(
                    '<option value="'+value2+'">'+value2+'</option>'
                );
            });
        }
    });
}

function getAssocTagsArray(data) {

    assoc_array = {};

    $.each(data,function(index, value) {
        $.each(value, function(index2, value2) {
            if (index2 == "tags") {
                $.each(value2, function(index3, value3) {
                    assoc_array[index3] = [];
                });                          
            }
        });
    });

    $.each(data,function(index, value) {
        $.each(value, function(index2, value2) {
            if (index2 == "tags") {
                $.each(value2, function(index3, value3) {
                    if ((assoc_array[index3].indexOf(value3)) == -1) {                          
                        assoc_array[index3].push(value3);
                    }
                });                          
            }
        });
    });

    return assoc_array;
}

function getModalTitle(type) {

    $("#ajax-modal-modal-title").html(
        "Nous intéropérons avec les trois bases de données libres suivantes"+
        "<div style='margin-top:15px;' class='col-xs-12 lien_interop'>"+
            "<div id='btn-wiki' style='text-align:center;' class='col-xs-offset-2 col-xs-2 lien_interop_single btn btn-default'>"+
                "<a id='function-link-wiki' href='javascript:getWiki(communexion.values.wikidataID)'><img class='logo_interop' src='<?php echo $this->module->assetsUrl; ?>/images/logos/Wikipedia-logo-en-big.png'>"+
                "</a>"+
            "</div>"+
            "<div id='btn-datagouv' class='col-xs-2 lien_interop_single btn btn-default'>"+
                "<a id='function-link-datagouv' style='text-align:center;' href='javascript:getDatasets(communexion.values.insee)'><img class='logo_interop' src='<?php echo $this->module->assetsUrl; ?>/images/logos/data-gouv-logo.png'>"+
                "</a>"+
            "</div>"+
            "<div id='btn-osm' class='col-xs-2 lien_interop_single btn btn-default'>"+
                "<a id='function-link-osm' href='javascript:buildOsmModal();' style='text-align:center;'><img class='logo_interop' src='<?php echo $this->module->assetsUrl; ?>/images/logos/OSM-logo.png'>"+
                "</a>"+
            "</div>"+
            "<div id='btn-opendatasoft' class='col-xs-2 lien_interop_single btn btn-default'>"+
                "<a id='function-link-opendatasoft' href='javascript:buildOpenDatasoftModal();' style='text-align:center;'>Base Siren<br/><img class='logo_interop' src='<?php echo $this->module->assetsUrl; ?>/images/logos/opendata-soft-logo.png'><br/>"+
                "</a>"+
            "</div>"+
        "</div>"
    );

    if (type == "wiki") {
        $("#btn-wiki").addClass('active');
        $("#function-link-wiki").removeAttr('href');
        $("#btn-datagouv").removeClass('active');
        $("#btn-osm").removeClass('active');
        $("#btn-opendatasoft").removeClass('active');
    } else if (type == "datagouv") {
        $("#btn-wiki").removeClass('active');
        $("#btn-datagouv").addClass('active');
        $("#function-link-datagouv").removeAttr('href');
        $("#btn-osm").removeClass('active');
    } else if (type == "osm") {
        $("#btn-wiki").removeClass('active');
        $("#btn-datagouv").removeClass('active');
        $("#btn-osm").addClass('active');
        $("#function-link-osm").removeAttr('href');
    } else if (type == "opendatasoft") {
        $("#btn-wiki").removeClass('active');
        $("#btn-datagouv").removeClass('active');
        $("#btn-osm").removeClass('active');
        $("#btn-opendatasoft").addClass('active');
        $("#function-link-opendatasoft").removeAttr('href');
    }

}

function OneOsmItemOnMap(value) {

    item = {
        "_id": {
            "$id" : value.id,
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": value.lat,
            "longitude": value.lon,
        },
        "name" :value.tags.name,
        "profilImageUrl" : "/assets/9fffbde3/images/logos/OSM-logo.png",
        "profilMarkerImageUrl": "/assets/9fffbde3/images/logos/OSM-logo.png",
        "profilMediumImageUrl" : "/assets/9fffbde3/images/logos/OSM-logo.png",
        "profilThumbImageUrl" : "/assets/9fffbde3/images/logos/OSM-logo.png",
        "typeSig" : "poi",
    };

    return item;
}

function OneSirenDataOnMap(value) {

    item = {

        "_id": {
            "$id" : value.fields.siret,
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": value.fields.coordonnees[0],
            "longitude": value.fields.coordonnees[1],
        },
        "name" : value.fields.l1_declaree,
        "url" : "https://data.opendatasoft.com/explore/dataset/sirene%40public/table/?sort=datemaj&q="+value.fields.siret,
        "onclick" : 'window.open("https://data.opendatasoft.com/explore/dataset/sirene%40public/table/?sort=datemaj&q="+value.fields.siret);',
    };

    return item;
}

function buildOpenDatasoftModal() {

    getModalTitle("opendatasoft");
    searchTags = $("#searchTags").val();
    contextOpendatasoftItem = [];

    list_enseigne_name = [];

    if (searchTags !== "") {
        $("#ajax-modal-modal-title").append(
            "<div style='margin-bottom: 20px;' class='col-xs-12'>Thématique actuelle : "+searchTags+"</div>"
        );
        $("#ajax-modal-modal-body").html(
            '<select style="margin-bottom: 10px;" class="form-control" id="select_activity">'+
            '</select>'+
            '<div style="margin-bottom: 10px; margin-top:10px;" id="activity_selected_div"></div>'+
            '<div id="all_activity"></div>'
        );

        $("#select_activity").html("<option value='-1'>Afficher tout le secteur d'activité</option>");

        activity_array = getActivityArray();

        changeValueSelectByThemeForActivity();

        $("#select_activity").hide();
    } else {
        $("#ajax-modal-modal-title").append(
            "<div class='col-xs-12'>Aucune thématique choisie</div>"
        );
    }

    $("#ajax-modal-modal-title").append(
        '<a id="btn-osm-map" style="margin-top:15px;" onclick="displayMapWikilinks()" class="btn btn-primary" role="button"> Afficher les éléments ci-dessous sur la Map <i class="fa fa-map-marker"></i>'+ 
        '</a><br/><br/>' 
    );

    $("#ajax-modal-modal-title").append('<div id="nb_activity_element" class="col-xs-12"></div>');
    $("#ajax-modal-modal-title").append(
        'Nombre d\'élements par page : '+ 
        '<select style="margin-top:20px;" id="nb_elt_per_page">'+
            '<option value="10">10</option>'+
            '<option value="20">20</option>'+
            '<option value="30">30</option>'+
            '<option value="40">40</option>'+
            '<option value="50">50</option>'+
            '<option value="60">60</option>'+
            '<option value="70">70</option>'+
            '<option value="80">80</option>'+
            '<option value="90">90</option>'+
            '<option value="100">100</option>'+
        '</select>'
    );

    limit = $("#nb_elt_per_page").val();

    $("#nb_elt_per_page" ).change(function() {
        limit = $("#nb_elt_per_page").val();
        getOpendatasoftItem(limit, 0);
    });

    $("#ajax-modal-modal-body").append(
        "<div style='margin-top:10px; margin-bottom:20px;' class=col-xs-12><h3>Résultats de la recherche</h3></div>"+
        "<div id='opendatasoft_content' class='col-xs-12'></div>"+
        "<div id='page_navigation_opendatasoft' class='col-xs-12'></div>"
    );

    getOpendatasoftItem(limit,0);

    $('#ajax-modal').modal("show");
    $('#ajax-modal').show();
}

function getOpendatasoftItem(limit,offset) {

    type_page = "opendatasoft_page";

    activity_selected = $("#select_activity").val();

    geofilter = getGeofilterPolygon();

    if ( (typeof(activity_selected) !== "undefined") && (activity_selected !== "-1") ) {
        activity_selected = activity_selected.replace(/_SPACE_/g, " ");
        activity_selected = activity_selected.replace(/_DOT_/g, ".");
        activity_selected = activity_selected.replace(/_AND_/g, "%26");
        activity_selected = activity_selected.replace(/_PAR-OUVRANT_/g, "(");
        activity_selected = activity_selected.replace(/_PAR-FERMANT_/g, ")");
        activity_selected = activity_selected.replace(/_SQUOTE_/g, "'");
        activity_selected = activity_selected.replace(/_VIRGULE_/g, ",");

        libelle_activity = "&refine.libapen="+activity_selected;
    } else if (activity_selected == "-1") {
        libelle_activity = "";
        $.each(activity_array, function(index, value) {
            if (searchTags == index) {
                $.each(value, function(index2, value2) {
                    libelle_activity += "&refine.libapen="+value2;
                });
            } 
        });
        libelle_activity += "&disjunctive.libapen=true";
    } else {
        libelle_activity = "";
    }

    url_opendatasoft = "https://data.opendatasoft.com/api/records/1.0/search/?dataset=sirene%40public&facet=categorie&facet=proden&facet=libapen&facet=siege&facet=libreg_new&facet=saisonat&facet=libtefen&facet=depet&facet=libnj&facet=libtca&facet=liborigine&rows="+limit+"&start="+offset+"&geofilter.polygon="+geofilter+libelle_activity;

    $.ajax({
        url: url_opendatasoft,
        type:"GET",
        dataType: "json",
        success:function(data) {

            $("#nb_activity_element").html("Nombre total d'éléments : "+ data.nhits);

            mylog.log('Toute la data pour les éléments affichées : ');
            mylog.log(data);

            $("#opendatasoft_content").html(" ");

            $.each(data.records, function(index, value) {
                if (typeof(value.fields.enseigne) !== "undefined") {
                        mylog.log(value.fields.enseigne);
                        $("#opendatasoft_content").append(
                            "<a target='_blank' href='https://data.opendatasoft.com/explore/dataset/sirene%40public/table/?sort=datemaj&q="+value.fields.siret+"' class='col-xs-offset-1 col-xs-5 btn btn-default one_opendasoft_item'>"+
                                value.fields.enseigne+"<br/>"+
                                "Numéro SIRET : "+value.fields.siret+"<br/>"+
                                "Catégorie : "+value.fields.categorie+"<br/>"+
                                "Adresse : "+value.fields.l4_declaree+"<br/>"+
                            "</a>"
                        );  
                } else if (typeof(value.fields.l2_declaree) !== "undefined") {
                    mylog.log('on rentre la dedans');
                    $("#opendatasoft_content").append(
                        "<a target='_blank' href='https://data.opendatasoft.com/explore/dataset/sirene%40public/table/?sort=datemaj&q="+value.fields.siret+"' class='col-xs-offset-1 col-xs-5 btn btn-default one_opendasoft_item'>"+
                            value.fields.l2_declaree+"<br/>"+
                            "Numéro SIRET : "+value.fields.siret+"<br/>"+
                            "Catégorie : "+value.fields.categorie+"<br/>"+
                            "Adresse : "+value.fields.l4_declaree+"<br/>"+
                        "</a>"
                    );
                } else if (typeof(value.fields.l1_declaree) !== "undefined") {
                    $("#opendatasoft_content").append(
                        "<a target='_blank' href='https://data.opendatasoft.com/explore/dataset/sirene%40public/table/?sort=datemaj&q="+value.fields.siret+"' class='col-xs-offset-1 col-xs-5 btn btn-default one_opendasoft_item'>"+
                            value.fields.l1_declaree+"<br/>"+
                            "Numéro SIRET : "+value.fields.siret+"<br/>"+
                            "Catégorie : "+value.fields.categorie+"<br/>"+
                            "Adresse : "+value.fields.l4_declaree+"<br/>"+
                        "<a>"
                    ); 
                } else {
                    $("#opendatasoft_content").append(
                        "<a class='col-xs-offset-1 col-xs-5 btn btn-default one_opendasoft_item'>"+
                            +"Données corrompues ?"+
                        "</a>"
                    ); 
                }
                contextOpendatasoftItem.push(OneSirenDataOnMap(value));
            });

            data_length = data.records.length;
            nav = getPaginationStruc(limit, offset, type_page, data_length);

            $('#page_navigation_opendatasoft').html(nav);

            if (offset == 0) {
                $('.btn-previous').hide();
            }

            if ((data_length == 0) || (data_length < limit)) {
                $('#page_navigation_opendatasoft').append("<br/>Il n'y a plus d'élément, veuillez cliquez sur le bouton 'PREVIOUS'")
                $('.btn-next').hide();
            }

            Sig.showMapElements(Sig.map, contextOpendatasoftItem);
        }
    });
}

function getUrlForInteropDirectoryElements(type_elt, id, url_elt) {

    if (type_elt == "datanova") {
        url_directory_elt = "https://datanova.laposte.fr/explore/embed/dataset/laposte_poincont/table/?disjunctive.nature_juridique&disjunctive.code_postal&disjunctive.localite&disjunctive.code_insee&q="+id+"&static=false&datasetcard=true";
    } else if (type_elt == "ods") {
        url_directory_elt = "https://data.opendatasoft.com/explore/dataset/sirene%40public/table/?sort=datemaj&q="+id;
    } else if (type_elt == "osm") {
        url_directory_elt = "http://www.openstreetmap.org/node/"+id;
    } else {
        url_directory_elt = url_elt;
    }

    return url_directory_elt;

}

function getTypeInteropData(type_convert) {

    var type_interop = type_convert.substr(type_convert.indexOf("_") + 1);

    return type_interop;
}

function getIconForInteropElements(type_elt) {

    var icon_elt = "";

    mylog.log(type_elt);

    if (type_elt == "datanova") {
        icon_elt = "envelope";
    } else if (type_elt == "ods") {
        icon_elt = "cubes";
    } else if (type_elt == "osm") {
        icon_elt = 'map';
    } else if (type_elt == "wiki") {
        icon_elt = 'wikipedia-w';
    } else if (type_elt == "datagouv") {
        icon_elt = "database";
    } else {
        icon_elt = "group";
    }

    return icon_elt;
}

function getIconColorForInteropElements(type_elt) {

    var icon_color = "";

    if (type_elt == "datanova") {
        icon_color = "yellow";
    } else if (type_elt == "ods") {
        icon_color = "blue";
    } else if (type_elt == "osm") {
        icon_color = 'green';
    } else if (type_elt == "wiki") {
        icon_color = 'purple';
    } else if (type_elt == "datagouv") {
        icon_color = "red";
    } else {
        icon_color = "white";
    }

    return icon_color;

}

function getImageIcoForInteropElements(type_elt) {

    var icon_image = "";

    if (type_elt == "datanova") {
        icon_image = "<img width=100 style='margin-top:20px;' src='http://127.0.0.1/"+moduleUrl+"/images/logos/logo-laposte.png'>";
    } else if (type_elt == "ods") {
        icon_image = "<img width=100 style='margin-top:20px;' src='http://127.0.0.1/"+moduleUrl+"/images/logos/opendata-soft-logo.png'>";
    } else if (type_elt == "osm") {
        icon_image = "<img width=100 style='margin-top:20px;' src='http://127.0.0.1/"+moduleUrl+"/images/logos/OSM-logo.png'>";
    } else if (type_elt == "wiki") {
        icon_image = "<img width=100 style='margin-top:20px;' src='http://127.0.0.1/"+moduleUrl+"/images/logos/logo-wikidata.png'>";
    } else if (type_elt == "datagouv") {
        icon_image = "<img width=100 style='margin-top:20px;' src='http://127.0.0.1/"+moduleUrl+"/images/logos/data-gouv-logo.png'>";
    } else if (type_elt == "poleemploi") {
        icon_image = "<img width=100 style='margin-top:20px;' src='http://127.0.0.1/"+moduleUrl+"/images/logos/logo_pole_emploi.png'>";
    } else {
        icon_image = "<img width=100 style='margin-top:20px;' src='http://127.0.0.1/"+moduleUrl+"'>";
    }

    return icon_image;

}

