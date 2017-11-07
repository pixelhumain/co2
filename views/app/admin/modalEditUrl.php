<?php 
    HtmlHelper::registerCssAndScriptsFiles( 
        array(  '/css/referencement.css',) , 
        Yii::app()->theme->baseUrl. '/assets');
?>

<div class="portfolio-modal modal fade" id="modalEditUrl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content padding-top-15">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">

            <div class="row">
                <h3 class="letter-red text-left">
                    <i class="fa fa-cog"></i> Modifier les informations
                    <button class="btn btn-success pull-right margin-bottom-5 btn-save-maj-metadata" ><i class="fa fa-check-circle"></i> Valider mes modifications</button> 
                </h3>
                    
                    <hr>
                <div class="col-md-6 text-left">
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="lbl-url">
                                <i class="fa fa-circle"></i> URL
                            </label>
                            <?php
                                $idhidden="hidden";
                                if(Role::isSuperAdmin(Role::getRolesUserId(@Yii::app()->session["userId"]) ) )
                                    $idhidden="";
                            ?>
                            <input type="hidden" class="form-control <?php echo $idhidden; ?>" placeholder="id" id="form-idurl"><br>
                            <input type="text" class="form-control" 
                                    placeholder="exemple : http://kgougle.nc" id="form-url"><br>
                            <h5 class="letter-green pull-left" id="status-ref"></h5>                    
                            <!-- <button class="btn btn-success pull-right btn-scroll" data-targetid="#formRef" id="btn-start-ref-url">
                                <i class="fa fa-binoculars"></i> Lancer la recherche d'information
                            </button> -->
                        </div>
                    </div>
                    <div class="col-md-12" id="refResult">
                        <label id="lbl-title">
                            <i class="fa fa-circle"></i> Nom de la page
                            <small class="pull-right text-light">
                                <code>&lttitle&gt&lt/title&gt</code>
                            </small>
                        </label>
                        <input type="text" class="form-control" placeholder="Nom de la page" id="form-title"><br>
                        <input type="hidden" id="form-favicon">

                        <label id="lbl-description">
                            <i class="fa fa-circle"></i> Description
                            <small class="pull-right text-light">
                                <code>&ltmeta name="description"&gt</code>
                            </small>
                        </label>
                        <textarea class="form-control" placeholder="Description" id="form-description"></textarea><br>

                        <div class="col-md-12 no-padding">
                            <label id="lbl-keywords">
                                <i class="fa fa-circle"></i> Mots clés                      
                                <small class="pull-right text-light">
                                    <code>&ltmeta name="keywords"&gt</code>
                                </small><br>
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

                        <?php $isAdmin = Role::isSuperAdmin(Role::getRolesUserId(@Yii::app()->session["userId"]) ); ?>
                        <div class="col-md-12 padding-5 <?php if(!$isAdmin) echo "hidden"; ?>">                           
                            <label id="lbl-description">
                                <i class="fa fa-circle"></i> Status
                            </label>
                            <select class="form-control" id="form-status">
                                <?php if($isAdmin){ ?>
                                <option name="status" value="locked">locked</option>
                                <option name="status" value="uncomplet">uncomplet</option>
                                <?php } ?>  
                                <option name="status" value="validated" <?php if($isAdmin) echo "selected"; ?> >validated</option>
                            </select>                                        
                            <hr>
                        </div>

                        <div class="col-md-12 padding-5">           
                            <label id="lbl-description">
                                <i class="fa fa-map-marker"></i> Addresse
                            </label>

                            <h4 class='pull-left text-red' id="name-city-selected"></h4>

                            <button class="btn btn-default text-red pull-right" id="btn-select-city" 
                                    data-target="#portfolioModalCities" data-toggle="modal">
                                <i class="fa fa-university"></i> Sélectionner une commune
                            </button>
                            <br>

                            <input type="text" class="form-control" placeholder="addresse, rue" id="form-street"><br>

                            <button class="btn btn-default text-azure pull-right" id="btn-find-position">
                                <i class="fa fa-map-marker"></i> Définir la position sur la carte
                            </button>
                        </div>                

                        <div class="col-md-12 padding-5">  
                            <hr>
                            <small>
                                <span class="letter-red"><i class="fa fa-info-circle"></i> Afin d'éviter tout abus,</span> vos modification seront envoyées aux administrateurs du site, et soumises à leur validation (sous 7 jours).<br>
                                <i class="fa fa-info-circle"></i> Si les informations fournies semblent farfellues, ou inexactes, nous nous réservons le droit de ne pas donner suite à votre demande.<br>
                                <i class="fa fa-info-circle"></i> Si elles semblent correctes, votre demande sera validée en quelques jours et vous pourrez retrouver vos modifications lors de vos futures recherches.<br>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pull-right" id="mainCategoriesEdit">
                </div>
                <div class="col-md-12">  
                    <?php if(Role::isSuperAdmin(Role::getRolesUserId(@Yii::app()->session["userId"]) ) ) { ?>
                    <button class="btn btn-danger pull-left margin-bottom-5" id="btn-conf-delete" 
                            data-target="#modalDeleteUrl" data-toggle="modal" >
                        <i class="fa fa-trash"></i> Supprimer
                    </button> 
                    <?php } ?>
                    
                    <button class="btn btn-success pull-right margin-bottom-5 btn-save-maj-metadata" >
                        <i class="fa fa-check-circle"></i> Valider mes modifications
                    </button> 
                    <button class="btn btn-default pull-right margin-right-5 margin-bottom-5" data-dismiss="modal">
                        <i class="fa fa-times"></i> Annuler
                    </button> 


                </div>
            </div>
        </div>
    </div>
</div>

<div class="portfolio-modal modal fade" id="modalDeleteUrl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content padding-top-15">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">

            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-left margin-top-70">
                    <h3 class="letter-red"><i class="fa fa-cog"></i> Souhaitez-vous vraiment supprimer cette URL ?</h3>
                    <h4 id="urlDeleteName"></h4>

                    <div class="row margin-top-70">  
                        <button class="btn btn-danger pull-left" id="btn-delete-url" data-dismiss="modal">
                            <i class="fa fa-trash"></i> Oui, supprimer
                        </button>
                        <button class="btn btn-default pull-right margin-right-5" data-dismiss="modal">
                            <i class="fa fa-times"></i> Non, annuler
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
    $cities = CO2::getCitiesNewCaledonia();
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    $this->renderPartial($layoutPath.'modals.kgougle.citiesReferencement', array("cities"=>$cities)); 
?>

<script type="text/javascript">
var contextData;
var formType = "poi";
var coordinatesPreLoadedFormMap = [0, 0];

jQuery(document).ready(function() {

    mapBg = Sig.loadMap("mapCanvas", initSigParams);
    Sig.showIcoLoading(false);

    $(".btn-save-maj-metadata").click(function(){
        sendReferencement();
    });

    $("#btn-conf-delete").click(function(){
        var url = $("#form-url").val();
        $("#urlDeleteName").html(url);
    });

    $("#btn-delete-url").click(function(){
        var url = $("#form-url").val();
        $.ajax({
            type: "POST",
            url: baseUrl+"/"+moduleId+"/app/superadmin/action/deleteUrl",
            data: { "url" : url },
            dataType: "json",
            success: function(data){
                toastr.success("L'url a bien été supprimé");
                //else toastr.error("Une erreur est survenue pendant le référencement");
                console.log("delete url success");
            },
            error: function(data){
                toastr.error("Une erreur est survenue pendant l'envoi de votre demande", data);
                console.log("save referencement error");
            }
        });


    });

    $("#form-street, #btn-find-position").hide();
    $(".btn-scope").click(function(){
        //h4-name-city btn-select-city name-city-selected
        var cityName = $(this).data("name");
        var cityCp = $(this).data("cp");
        var cityInsee = $(this).data("insee");
        var cityLat = $(this).data("lat");
        var cityLng = $(this).data("lng");

        var id = $(this).data("locid");
        var l1 = $(this).data("level1");
        var l1n = $(this).data("level1name");
        var l3 = $(this).data("level3");
        var l3n = $(this).data("level3name");
        var l4 = $(this).data("level4");
        var l4n = $(this).data("level4name");
        

        $("#h4-name-city, #form-street, #btn-find-position, #name-city-selected").show();
        $("#name-city-selected").html(cityName + ", " + cityCp);

        coordinatesPreLoadedFormMap = [cityLat, cityLng];
        formInMap.formType = "url";
        formInMap.bindFormInMap();
        formInMap.showMarkerNewElement(false, coordinatesPreLoadedFormMap);
        preLoadAddress(true, "NC", cityInsee, cityName, cityCp, cityLat, cityLng, "", 
                        id, l1, l1n, l3, l3n, l4, l4n);

        formInMap.add(true, $(this));
       // formInMap.add(true, data);

        $("#btn-find-position").off().click(function(){
            showMap(true);
            $("#newElement_country").val("NC");
            //$("#divCity").removeClass("hidden");
            if(Sig.markerFindPlace == null)
                formInMap.showMarkerNewElement();
    
            var street = $("#form-street").val();
            preLoadAddress(true, "NC", cityInsee, cityName, cityCp, cityLat, cityLng, street, 
                            id, l1, l1n, l3, l3n, l4, l4n);
            
            //if(street != "")
                //searchAdressNewElement();         
        });
    });

    

    buildListCategoriesForm();
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
function sendReferencement(){
    console.log("start referencement");

    var id = $("#form-idurl").val();
    
    var url = $("#form-url").val();
    var title = $("#form-title").val();
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
    
    var status = $("#form-status").val();

    var address = contextData;//getAddressObj(); //formInMap.js

    var urlObj = {
            url : url,
            title: title, 
            description: description,
            tags: keywords,
            categories : categoriesSelected,
            status: status
    };

    if(address != false) {
        urlObj["address"] = address.address;
        urlObj["geo"] = address.geo;
        urlObj["geoPosition"] = address.geoPosition;
    }
    console.log("address", address);

    console.log("UPDATE THIS URL DATA ?", urlObj, id);
   
    $.ajax({
        type: "POST",
        url: baseUrl+"/"+moduleId+"/app/superadmin/action/updateurlmetadata",
        data: { "id" : id,
                "values" : urlObj },
        dataType: "json",
        success: function(data){
            //if(data.valid == true) 
            toastr.success("Votre demande a bien été enregistrée");

            $("#form-idurl").val("");
            $("#form-url").val("");
            $("#form-title").val("");
            $("#form-description").val("");

            $("#form-keywords1").val("");
            $("#form-keywords2").val("");
            $("#form-keywords3").val("");
            $("#form-keywords4").val("");
            //else toastr.error("Une erreur est survenue pendant le référencement");
            console.log("save referencement success");

            $("#modalEditUrl").modal("hide");
        },
        error: function(data){
            toastr.error("Une erreur est survenue pendant l'envoi de votre demande", data);
            console.log("save referencement error");
        }
    });
}


var categoriesSelected = new Array();
function buildListCategoriesForm(){
    console.log("mainCategoriesEdit", mainCategories);

    var html = "<h4 class='text-dark'>"+
                    "sélectionner la / les catégorie(s)"+
                "</h4>";

    $.each(mainCategories, function(name, params){
        var classe="";
        if(params.color == "green") classe="search-eco";

        html    += '<section id="portfolio" class="'+classe+'">'+
                        '<div class="">'+
                            '<div class="row">'+
                                '<div class="col-lg-12 text-center">'+
                                    '<hr>'+
                                    //'<h4 class="letter-'+params.color+'">'+
                                    //    name+
                                    //'</h4>'+
                                    //'<hr>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row text-'+params.color+'">';

        $.each(params.items, function(keyC, val){
            //console.log(keyC, val);
            html +=             '<div class="col-md-3 col-sm-4 col-xs-6 portfolio-item cat-'+val.name+'">'+
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

    $("#modalEditUrl #mainCategoriesEdit").html(html);

    $("#modalEditUrl .btn-select-category").click(function(){ console.log("click cat");
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
        //  $("#send-ref, #refLocalisation").removeClass("hidden");
        //  $("#info-select-cat").addClass("hidden");
        // }else{
        //  $("#send-ref, #refLocalisation").addClass("hidden");
        //  $("#info-select-cat").removeClass("hidden");
        // }
        //console.log("categoriesSelected");
        //console.dir(categoriesSelected);
    });

   
}


</script>