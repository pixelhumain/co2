<?php 

	//HtmlHelper::registerCssAndScriptsFiles( array('/js/default/formInMap.js') , $this->module->assetsUrl);

    HtmlHelper::registerCssAndScriptsFiles( 
        array(  '/css/referencement.css',
                '/js/referencement.js') , 
        Yii::app()->theme->baseUrl. '/assets');

    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "referencement" )); 
?>

<style>
	
	
</style>

<div id="mainFormReferencement">
	<section id="portfolio">
        <div class="container">
            
            <div class="row" style="min-height:800px;" id="refStart">
            	<div class="col-lg-12 text-center">
                    <h2 class="text-blue" id="formRef">
                        <!-- <i class="fa fa-search"></i><br> -->
                        Référencer une page web
                    </h2>
                    <hr class="angle-down">
                </div>
                <div class="col-md-8 col-md-offset-2">
                	<div class="col-md-12">
                		<div class="form-group">
                			<label id="lbl-url">
                				<i class="fa fa-circle"></i> Indiquez l'URL de la page
                			</label>
						    <input type="text" class="form-control" placeholder="exemple : http://www.kgougle.nc" id="form-url"><br>
						    <h5 class="letter-green pull-left" id="status-ref"></h5>             		
						    <button class="btn btn-success pull-right btn-scroll" data-targetid="#formRef" id="btn-start-ref-url">
						    	<i class="fa fa-binoculars"></i> Lancer la recherche d'information
						    </button>
						</div>
                	</div>
                	<div class="col-md-12 hidden" id="refResult">
						<label id="lbl-title">
            				<i class="fa fa-circle"></i> Nom de la page <small>(complétez si besoin) *</small>
            				<small class="pull-right text-light">
            					<code>&lttitle&gt&lt/title&gt</code>
            				</small>
            			</label>
            			<input type="text" class="form-control" placeholder="Nom de la page" id="form-title"><br>
                        <input type="hidden" id="form-favicon">

                		<label id="lbl-description">
            				<i class="fa fa-circle"></i> Description de la page <small>(complétez si besoin)</small>
            				<small class="pull-right text-light">
            					<code>&ltmeta name="description"&gt</code>
            				</small>
            			</label>
            			<textarea class="form-control" placeholder="Description" id="form-description"></textarea><br>

            			<div class="col-md-12 no-padding">
	            			<label id="lbl-keywords">
	            				<i class="fa fa-circle"></i> Mots clés <small>(conseil : 3 mots max par expression)</small>	      				
	            				<small class="pull-right text-light">
	            					<code>&ltmeta name="keywords"&gt</code>
	            				</small><br>
	            				<small class="text-light">
	            					<i class="fa fa-info-circle"></i> Les mots clés servent à optimiser les résultats de recherche, choisissez les avec soins<br><br>
	            			</label>
            			</div>
            			<div class="col-md-3 padding-5">
            				<input type="text" class="form-control" placeholder="expression 1" id="form-keywords1"><br>
            			</div>
            			<div class="col-md-3 padding-5">
            				<input type="text" class="form-control" placeholder="expression 2" id="form-keywords2"><br>
            			</div>
            			<div class="col-md-3 padding-5">
            				<input type="text" class="form-control" placeholder="expression 3" id="form-keywords3"><br>
            			</div>
            			<div class="col-md-3 padding-5">
            				<input type="text" class="form-control" placeholder="expression 4" id="form-keywords4"><br>
            			</div>
                		
            			<div class="col-md-12 no-padding">
	            			<button class="btn btn-success text-white pull-right" id="btn-validate-information">
						    	<i class="fa fa-check"></i> Valider ces informations
						    </button>
                		</div>

                		<div class="col-md-12 no-padding hidden margin-top-50" id="refMainCategories">
	            			<label id="lbl-keywords" class="margin-top-15">
	            				<i class="fa fa-circle"></i> Choix des catégories
		       				</label>
	       					<div class="col-md-12" id="mainCategoriesEdit"></div>

		                	<div class="col-md-12 text-center margin-bottom-50 hidden" id="info-select-cat">
		                		<h4 class='col-md-12 text-center'>
									<i class='fa fa-hand-o-up fa-2x'></i>
								</h4>
								<span>
									Merci de sélectionner <b>au moins une catégorie</b> avant de continuer
								</span>
		                	</div>
       					</div>
                	</div>


                	<div class="col-md-8 col-md-offset-2 hidden text-center" id="refLocalisation">
						<h4 class='col-md-12 text-center'>
							<i class='fa fa-angle-down'></i><br>Géolocalisation
						<br>
                        <small>(facultatif)</small></h4><br>
						<span>
							Ajoutez une addresse si vous souhaitez que cette page apparaîsse aussi dans les résultats sur la carte.
						</span><br><br>
						<!-- <input type="text" class="form-control" placeholder="commune / ville / village" id="form-url"><br>
						<input type="text" class="form-control" placeholder="code postal" id="form-url"><br> -->
						<button class="btn btn-default bg-red text-white" id="btn-select-city" data-target="#portfolioModalCities" data-toggle="modal">
							<i class="fa fa-university"></i> Sélectionner une commune
						</button><br>

						<h4 class='col-md-12 text-center text-red' id="name-city-selected">
						</h4><br>

						<input type="text" class="form-control" placeholder="addresse, rue" id="form-street"><br>

						<button class="btn btn-default bg-green-k text-white" id="btn-find-position">
							<i class="fa fa-map-marker"></i> Définir la position sur la carte
						</button><br><br>
						   
					</div>

       			</div>
       		</div>
		</div>
	</section>
	<section class="bg-green-k hidden" id="send-ref">
		<div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 text-center" style="margin-bottom:50px;">
                	<button class="btn bg-white letter-green btn-lg" id="btn-send-ref">
                        <i class="fa fa-send"></i> Envoyer ma demande de référencement
                    </button><br><br>
                	<label class="text-white">(soumis à l'approbation des administrateurs sous 7 jours)</label>
                    <hr>
                    <label class="text-white">
                    Les informations fournies à propos de cette URL seront examinées par les administrateurs du réseau avant d'être publiées, afin d'éviter tout abus et de garantir la pertinence des résultats de recherches.
                    </label>
                    <hr>
                    <label class="text-white">
                    Les sites internationaux sont tolérés à condition d'être pertinent pour une large majorité des internautes Calédoniens.
                    </label><hr>
                    <label class="text-white">Seront automatiquement refusés :<br>les sites web à caractère violent, ou pornographique.</label>
                </div>
            </div>
        </div>
	</section>
</div>

<section class="letter-green hidden" id="section-thanks">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center" style="margin-bottom:50px;">
                <h3 class=""><i class="fa fa-thumbs-up"></i><br>Merci pour votre participation</h3>
                <label>
                    <a href="" class="letter-green bold" id="url-validated"></a><br>
                    <i class="fa fa-check"></i> L'url a bien été enregistrée
                </label>
                <hr>
                <label>Les informations fournies à propos de cette URL seront examinées par les administrateurs du site avant d'être publiées, afin d'éviter tout abus et de garantir la pertinence des résultats de recherches.</label>
                <br><br>
                <button class="btn bg-green-k text-white btn-lg lbh" data-hash="#web" id="btn-send-ref">
                    <i class="fa fa-arrow-left"></i> retour
                </button>
                    
                
            </div>
        </div>
    </div>
</section>


<?php $cities = CO2::getCitiesNewCaledonia(); ?>
<?php $this->renderPartial($layoutPath.'modals.kgougle.citiesReferencement', array("cities"=>$cities)); ?>

<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array("subdomain"=>"referencement")); ?>


<script type="text/javascript" >

var categoriesSelected = new Array();
var urlValidated = "";
var formType = "poi";
var cities = <?php echo json_encode($cities); ?>;
var coordinatesPreLoadedFormMap = [0, 0];

var urlExists = "DONTKNOW";

var contextData = {};

console.log("CITIES", cities);

jQuery(document).ready(function() {
    initKInterface();
    buildListCategoriesForm();
    
    mapBg = Sig.loadMap("mapCanvas", initSigParams);
    Sig.showIcoLoading(false);

    
    $('#form-url').val("");//"https://www.bci.nc/");//" http://groupe-vocal-nc.net/");

    $("#btn-start-ref-url").click(function(){
    	refUrl($('#form-url').val());
    });

    $("#btn-start-subscribe").click(function(){
    	$(".show-subscribe").removeClass("hidden");
    	$(".hidden-subscribe").addClass("hidden");
    });

    $("#btn-cancel-subscribe").click(function(){
    	$(".hidden-subscribe").removeClass("hidden");
    	$(".show-subscribe").addClass("hidden");
    });

    $("#name-city-selected, #form-street, #btn-find-position").hide();

    $("#btn-start-anonymous").click(function(){
    	$("#refStart").removeClass("hidden");
    	KScrollTo("#formRef");
    });

    $("#btn-validate-information").click(function(){
    	$("#refMainCategories").removeClass("hidden");
    	buildListCategoriesForm();
	    $("#btn-send-ref").off().click(function(){
	    	sendReferencement();
	    });
    	KScrollTo("#refMainCategories");

        $("#send-ref, #refLocalisation").removeClass("hidden");
        $("#info-select-cat").addClass("hidden");
    });

    $(".btn-scope").click(function(){ console.log(".btn-scope");
    	//h4-name-city btn-select-city name-city-selected
    	var cityId = $(this).data("city-id");
        var cityName = $(this).data("city-name");
        var cityCp = $(this).data("city-cp");
    	var cityInsee = $(this).data("city-insee");
    	var cityLat = $(this).data("city-lat");
    	var cityLng = $(this).data("city-lng");

        var id = $(this).data("locid");
        var l1 = $(this).data("level1");
        var l1n = $(this).data("level1name");
        var l3 = $(this).data("level3");
        var l3n = $(this).data("level3name");
        var l4 = $(this).data("level4");
        var l4n = $(this).data("level4name");
        

    	$("#h4-name-city, #form-street, #btn-find-position, #name-city-selected").show();
    	$("#name-city-selected").html(cityName + ", " + cityCp);

        console.log(".btn-scope", cityId, "NC", cityInsee, cityName, cityCp, cityLat, cityLng);

    	formInMap.formType = "url";
        coordinatesPreLoadedFormMap = [cityLat, cityLng];
	    formInMap.showMarkerNewElement();
	    preLoadAddress(true, cityId, "NC", cityInsee, cityName, cityCp, cityLat, cityLng, "");

        formInMap.add(true, $(this));
       // formInMap.add(true, data);

	    $("#btn-find-position").off().click(function(){
	    	showMap(true);

	    	if(Sig.markerFindPlace == null){
                formInMap.showMarkerNewElement();
            }
   	
	    	var street = $("#form-street").val();
    		preLoadAddress(true, cityId, "NC", cityInsee, cityName, cityCp, cityLat, cityLng, street);
    		
    		if(street != "")
    			formInMap.searchAdressNewElement();	    	
	    });
    });

});

function preLoadAddress(bool, addressCountry, cityInsee, cityName, cityCp, cityLat, cityLng, street, 
                        id, l1, l1n, l3, l3n, l4, l4n){
    contextData = {
        "address": {
             "@type" : "PostalAddress",
            "codeInsee" : "98818",
            "streetAddress" : street,
            "postalCode" : cityCp,
            "addressLocality" : cityName,
            "level1" : l1,
            "level1Name" : l1n,
            "addressCountry" : addressCountry,
            "localityId" : id,
            "level3" : l3,
            "level3Name" : l3n,
            "level4" : l4,
            "level4Name" : l4n
        },
        "geo" : {
            "@type" : "GeoCoordinates",
            "latitude" : cityLat,
            "longitude" : cityLng
        },
        "geoPosition": {
            "type" : "Point",
            "coordinates" : [ 
                cityLng, 
                cityLat
            ]
        }
    };

    /*
    "address" : {
        "@type" : "PostalAddress",
        "codeInsee" : "98818",
        "streetAddress" : "",
        "postalCode" : "98800",
        "addressLocality" : "NOUMEA",
        "level1" : "58be4bd194ef47e31d0ddbcb",
        "level1Name" : "Nouvelle-Calédonie",
        "addressCountry" : "NC",
        "localityId" : "54c0965cf6b95c141800a58a",
        "level3" : "59e9947176a1678016ee7ced",
        "level3Name" : "Province Sud",
        "level4" : "59e996fb76a1678016ee7cf0",
        "level4Name" : "Drubea-Kapumè"
    },
    "geo" : {
        "@type" : "GeoCoordinates",
        "latitude" : "-22.286872708692744",
        "longitude" : "166.4531707763672"
    },
    "geoPosition" : {
        "type" : "Point",
        "coordinates" : [ 
            166.453170776367, 
            -22.2868727086927
        ]
    },
    */
}

function buildListCategoriesForm(){
    //console.log(mainCategories);

    var html = "<h4 class='col-md-12 text-center'><i class='fa fa-angle-down'></i><br>"
                    +"Sélectionner la ou les catégories<br>qui correspondent le mieux à cette page</h4><hr>"+
    			//"<center><label></label></center><br>"+
    			"<center><label>(cliquez pour sélectionner)</label></center>";

    $.each(mainCategories, function(name, params){
        var classe="";
        if(params.color == "green") classe="search-eco";

        html    += '<section id="portfolio" class="'+classe+'">'+
                        '<div class="">'+
                            '<div class="row">'+
                                '<div class="col-lg-12 text-center">'+
                                    '<h4 class="letter-'+params.color+'">'+
                                        name+
                                    '</h4>'+
                                    '<hr class="angle-down">'+
                                '</div>'+
                            '</div>'+
                            '<div class="row text-'+params.color+'">';

        $.each(params.items, function(keyC, val){
            //console.log(keyC, val);
            html +=             '<div class="col-md-3 col-sm-4 col-xs-6 portfolio-item">'+
                                    '<button class="portfolio-link btn-select-category" data-value="'+val.name+'">'+
                                        '<div class="caption">'+
                                            '<div class="caption-content">'+
                                            '</div>'+
                                        '</div>'+
                                        '<i class="fa fa-'+val.faIcon+' fa-2x"></i>'+
                                        '<h3>'+val.name+'</h3>'+
                                    '</button>'+
                                '</div>'
        });

        html +=             '</div>' + 
                        '</div>' + 
                    '</section>';

    });

    $("#mainCategoriesEdit").html(html);

    $(".btn-select-category").click(function(){
    	var val = $(this).data("value");
    	
    	if(categoriesSelected.indexOf(val) < 0){
    		categoriesSelected.push(val);
    		$(this).parent().addClass("selected");
    	}
    	else{
    		categoriesSelected.splice(categoriesSelected.indexOf(val), 1);
    		$(this).parent().removeClass("selected");
    	}

    	// if(categoriesSelected.length > 0){
    	// 	$("#send-ref, #refLocalisation").removeClass("hidden");
    	// 	$("#info-select-cat").addClass("hidden");
    	// }else{
    	// 	$("#send-ref, #refLocalisation").addClass("hidden");
    	// 	$("#info-select-cat").removeClass("hidden");
    	// }
    	//console.log("categoriesSelected");
    	//console.dir(categoriesSelected);
    });
}

function checkUrlExists(url){
    url = url.trim();
    if(url.lastIndexOf("/") == url.lenght){
        url = url.substr(0, url.lenght-1);
        $("#form-url").val(url); 
    }

    $.ajax({
        type: "POST",
        url: baseUrl+"/"+moduleId+"/app/checkurlexists",
        data: { url: url },
        dataType: "json",
        success: function(data){ console.log("checkUrlExists", data);
            if(data.status == "URL_EXISTS")
            urlExists = true;
            else
            urlExists = false;
            console.log("checkUrlExists", data);
            refUrl(url);
        },
        error: function(data){
            console.log("check url exists error");
        }
    });
}
//http://www.evaneos.com/nouvelle-caledonie/voyage/
function refUrl(url){

    if(!isValidURL(url)){
        $("#status-ref").html("<span class='letter-red'><i class='fa fa-times'></i> cette url n'est pas valide.</span>");
        return;
    }

    if(urlExists == "DONTKNOW"){
        checkUrlExists(url);
        return;
    }

    if(urlExists == true){
        $("#form-url").val(); 
        $("#send-ref, #refLocalisation, #refMainCategories, #refResult").addClass("hidden");
        $("#status-ref").html("<span class='letter-green'><i class='fa fa-thumbs-up'></i> Cette url est déjà référencée dans notre base de données.</span>");
        urlExists = "DONTKNOW";
        return; 
    }

    urlExists = "DONTKNOW";

	$("#status-ref").html("<span class='letter-blue'><i class='fa fa-spin fa-refresh'></i> recherche en cours</span>");
	$("#refResult").addClass("hidden");
	$("#send-ref").addClass("hidden");

	urlValidated = "";

    $.ajax({ 
    	url: "//cors-anywhere.herokuapp.com/" + url, // 'http://google.fr', 
    	//crossOrigin: true,
    	timeout:20000,
        success:
			function(data) {
				
			    var jq = $.parseHTML(data);
			    
			    var tempDom = $('<output>').append($.parseHTML(data));
			    var title = $('title', tempDom).html();
			    var stitle = "";

			    if(stitle=="" || stitle=="undefined")
			   		stitle = $('blockquote', tempDom).html();

			   	//console.log("STITLE", stitle);

				if(stitle=="" || stitle=="undefined")
			   		stitle = $('h2', tempDom).html();

				if(stitle=="" || stitle=="undefined")
			   		stitle = $('h3', tempDom).html();

				if(stitle=="" || stitle=="undefined")
			   		stitle = $('blockquote', tempDom).html();

				if(title=="" || title=="undefined")
			   		title = stitle;

                var favicon = $("link[rel*='icon']", tempDom).attr("href");
                var hostname = (new URL(url)).origin;
                var faviconSrc = "";
                if(typeof favicon != "undefined"){
                    var faviconSrc = hostname+favicon;
                    if(favicon.indexOf("http")>=0) faviconSrc = favicon;
                }

				var description = $(tempDom).find('meta[name=description]').attr("content");

				var keywords = $(tempDom).find('meta[name=keywords]').attr("content");
				//console.log("keywords", keywords);

				var arrayKeywords = new Array();
				if(typeof keywords != "undefined")
					arrayKeywords = keywords.split(",");

				//console.log("arrayKeywords", arrayKeywords);

				if(typeof arrayKeywords[0] != "undefined") $("#form-keywords1").val(arrayKeywords[0]); else $("#form-keywords1").val("");
				if(typeof arrayKeywords[1] != "undefined") $("#form-keywords2").val(arrayKeywords[1]); else $("#form-keywords2").val("");
				if(typeof arrayKeywords[2] != "undefined") $("#form-keywords3").val(arrayKeywords[2]); else $("#form-keywords3").val("");
				if(typeof arrayKeywords[3] != "undefined") $("#form-keywords4").val(arrayKeywords[3]); else $("#form-keywords4").val("");


				if(description=="" || description=="undefined")
			   		if(stitle=="" || stitle=="undefined")
			   			description = stitle;

				
				$("#form-title").val(title);
                $("#form-favicon").val(faviconSrc);
                $("#form-description").val(description);
				

				//color
				if($("#form-title").val() != "") $("#lbl-title").removeClass("letter-red").addClass("letter-green");
				else 							$("#lbl-title").removeClass("letter-green").addClass("letter-red");
			   	
			   	//color	
				if($("#form-description").val() != "") $("#lbl-description").removeClass("text-orange").addClass("letter-green");
				else 								   $("#lbl-description").removeClass("letter-green").addClass("text-orange");
			   		
			   	//color	
				if($("#form-keywords1").val() != "")   $("#lbl-keywords").removeClass("text-orange").addClass("letter-green");
				else 								   $("#lbl-keywords").removeClass("letter-green").addClass("text-orange");
			   		
			   	$("#form-title").off().keyup(function(){
			   		if($(this).val()!="")$("#lbl-title").removeClass("letter-red").addClass("letter-green");
					else 				 $("#lbl-title").removeClass("letter-green").addClass("letter-red");
					checkAllInfo();
			   	});
			   	$("#form-description").off().keyup(function(){
			   		if($(this).val()!="")$("#lbl-description").removeClass("text-orange").addClass("letter-green");
					else 				 $("#lbl-description").removeClass("letter-green").addClass("text-orange");
					checkAllInfo();
			   	});
			   	$("#form-keywords1").off().keyup(function(){
			   		if($(this).val()!="")$("#lbl-keywords").removeClass("text-orange").addClass("letter-green");
					else 				 $("#lbl-keywords").removeClass("letter-green").addClass("text-orange");
					checkAllInfo();
			   	});

			   	$("#status-ref").html("<span class='letter-green'><img src='"+faviconSrc+"' height=30 alt='x'> <i class='fa fa-check'></i> Nous avons trouvé votre page</span>");
    			$("#refResult").removeClass("hidden");
			   
			   	$("#lbl-url").removeClass("letter-red").addClass("letter-green");
			   	urlValidated = url;

			    $('<output>').remove();
			    tempDom = "";

			    checkAllInfo();			   
			},
		error:function(xhr, status, error){
			$("#lbl-url").removeClass("letter-green").addClass("letter-red");
			$("#status-ref").html("<span class='letter-red'><i class='fa fa-ban'></i> URL INNACCESSIBLE</span>");
        },
		statusCode:{
				404: function(){
				$("#lbl-url").removeClass("letter-green").addClass("letter-red");
				$("#status-ref").html("<span class='letter-red'><i class='fa fa-ban'></i> 404 : URL INTROUVABLE OU INACCESSIBLE</span>");
			}
		}
	});
}

function isValidURL(url) {
  var match_url = new RegExp("(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
  return match_url.test(url);
}

function checkAllInfo(){
	if(	urlValidated != "" &&
		//$("#form-keywords1").val() != "" && 
		//$("#form-description").val() != "" && 
		$("#form-title").val() != "") 
   			$("#btn-validate-information").removeClass("hidden");
   	else 	$("#btn-validate-information").addClass("hidden");
}


function sendReferencement(){
	console.log("start referencement");

	var hostname = (new URL(urlValidated)).hostname;

	var title = $("#form-title").val();
    var favicon = $("#form-favicon").val();
    var description = $("#form-description").val();

	var keywords1 = $("#form-keywords1").val();
	var keywords2 = $("#form-keywords2").val();
	var keywords3 = $("#form-keywords3").val();
	var keywords4 = $("#form-keywords4").val();

	var keywords = new Array();

	if(notEmpty(keywords1)) keywords.push(keywords1);
	if(notEmpty(keywords2)) keywords.push(keywords2);
	if(notEmpty(keywords3)) keywords.push(keywords3);
	if(notEmpty(keywords4)) keywords.push(keywords4);
	
	//authorId *facultatif
	//categoriesSelected

	if(urlValidated != "" && title != "" /*&& description != "" && keywords.length > 0 && categoriesSelected.length > 0*/){

        var address = typeof locObj != "undefined" ? locObj : {}; 
        //formInMap.createLocalityObj(true); //formInMap.js


		var urlObj = {
                collection: "url",
                key: "url",
        		url: urlValidated, 
        		hostname: hostname, 
        		title: title, 
                favicon: favicon,
        		description: description,
        		tags: keywords,
        		categories : categoriesSelected,
                status: "locked"
        };

        if(address != false) {
        	urlObj["address"] = address.address;
        	urlObj["geo"] = address.geo;
        	urlObj["geoPosition"] = address.geoPosition;
        }
        console.log("address", address);

		$.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/element/save",
	        data: urlObj,
	       	dataType: "json",
	    	success: function(data){
	    		if(typeof data.result != "undefined" && data.result == false) 
                    toastr.error("Une erreur est survenue, ou cette URL existe déjà dans notre base de données");
                else{
                    console.log("save referencement success");
                    toastr.success("Votre demande a bien été enregistrée");
                    $("#mainFormReferencement").hide();
                    $("#url-validated").html(urlValidated)
                    $("#section-thanks").removeClass("hidden");
                    //urlCtrl.loadByHash("#web");
	    		}
                //else toastr.error("Une erreur est survenue pendant le référencement");
	    		
	    	},
	    	error: function(data){
                if(data.status == "URL_EXISTS")
                toastr.error("Une erreur est survenue pendant l'envoi de votre demande'");

                if(data.status == "URL_EXISTS")
                toastr.error("Une erreur est survenue pendant l'envoi de votre demande'");
	    		console.log("save referencement error");
	    	}
	    });
	}else{
		toastr.error("Merci de remplir toutes les options");
	}



}