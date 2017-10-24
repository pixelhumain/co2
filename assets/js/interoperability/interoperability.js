
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

    if (geoShape.type == "Polygon") {

        $.each(geoShape.coordinates, function(index, value) {
            $.each(value, function(index2, value2) {
                city_geoShape.push("("+value2[1], value2[0]+")");
            });
        });
        res = city_geoShape.join(",");
    } else if (geoShape.type == "MultiPolygon") {

        $.each(geoShape.coordinates, function(index, value) {
            $.each(value, function(index2, value2) {
                $.each(value, function(index3, value3) {
                    city_geoShape.push("("+value2[1], value2[0]+")");
                });
            });
        });
        res = city_geoShape.join(",");
    }

    mylog.log('LE NOUVEAU GEOSHAPE', res);
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

function getAllValueForTagAmenityOSM(){

    var list_tags_amenity = {};

    list_tags_amenity["Sustenance"] = [];
    list_tags_amenity["Sustenance"].push("restaurant", "pub", "fast_food", "food_court", "ice_cream", "bar", "bbq", "biergarten", "cafe", "food_court", "ice_cream", "marketplace","drinking_water");


    list_tags_amenity["Education"] = [];
    list_tags_amenity["Education"].push("school", "university", "college", "kindergarten", "childcare", "music_school", "driving_school", "language_school");


    list_tags_amenity["Transport"] = [];
    list_tags_amenity["Transport"].push("bicycle_parking", "bicycle_repair_station", "bicycle_rental", "boat_sharing", "bus_station", "car_rental", "car_sharing", "car_wash", "charging_station", "fuel", "ferry_terminal", "grit_bin", "motorcycle_parking", "parking", "parking_entrance", "parking_space", "taxi");

    list_tags_amenity["Financier"] = [];
    list_tags_amenity["Financier"].push("atm", "bank", "bureau_de_change");


    list_tags_amenity["Santé"] = [];
    list_tags_amenity["Santé"].push("doctors", "pharmacy", "veterinary", "hospital", "baby_hatch", "clinic", "nursing_home", "social_facility");


    list_tags_amenity["Divertissement, Art et Culture"] = [];
    list_tags_amenity["Divertissement, Art et Culture"].push("theatre", "cinema", "library", "arts_centre", "brothel", "stripclub", "swingerclub", "casino", "community_centre", "fountain", "gambling", "nightclub", "planetarium", "studio");

    list_tags_amenity["Autres"] = [];
    list_tags_amenity["Autres"].push("animal_boarding", "animal_shelter", "baking_oven", "bench", "clock", "courthouse", "coworking_space", "crematorium", "crypt", "dive_centre", "dojo", "embassy", "fire_station", "game_feeding", "grave_yard", "hunting_stand", "internet_cafe", "marketplace", "photo_booth", "place_of_worship", "police", "post_box", "post_office", "prison", "ranger_station", "recycling", "rescue_station", "sanitary_dump_station", "shelter", "shower", "table", "telephone", "toilets", "townhall", "vending_machine", "waste_basket", "waste_disposal", "waste_transfert_station", "watering_place", "water_point");

    return list_tags_amenity;
}

function getAllValueForTagPlaceOSM() {

    var list_tags_place = {};

    list_tags_place["Lieu administrativement déclarer"] = [];
    list_tags_place["Lieu administrativement déclarer"].push("country", "state", "region", "province", "district", "country", "municipality");

    list_tags_place["Lieu peuplé, milieu urbain"] = [];
    list_tags_place["Lieu peuplé, milieu urbain"].push("city", "quarter", "city_block", "borough")

    list_tags_place["Lieu peuplé, milieu urbain et rural"] = [];
    list_tags_place["Lieu peuplé, milieu urbain et rural"].push("town", "village", "hamlet", "farm", "allotments");

    list_tags_place["Autres"] = [];
    list_tags_place["Autres"].push("continent","archipelago", "island", "islet", "square", "locality");

    return list_tags_place;
    
}

function getAllValueForTagOfficeOSM() {

    var list_tags_office = {};

    list_tags_office["Office"] = [];
    list_tags_office["Office"].push("accountant", "adoption agency", "advertising agency", "architect", "association", "charity", "company", "educational institution", "employement agency", "energy supplier", "estate agent", "foresty", "fondation", "guide", "insurance", "it", "lawyer", "logistics", "moving company", "newspaper", "ngo", "notary", "political party", "private investigator", "quango", "religion", "research", "tax", "tax_advisor", "telecommunication", "therapist", "travel_agent", "water_utility");

    return list_tags_office;
}

function getAllValueForTagLeisureOSM() {

    var list_tags_leisure = {};

    list_tags_leisure["Loisirs"] = [];
    list_tags_leisure["Loisirs"].push("adult_gaming_centre", "amusement_arcade", "beach_resort", "bandstant", "bird_hide", "common", "dance", "disc_golf_tour", "dog_park", "escape_game", "firepit", "fishing", "fitness_centre", "garden", "golfcourt", "hackerspace", "horse_riding", "ice_rink", "marina", "miniature_golf", "nature_reserve", "park", "picnic_table", "pitch","playground", "slipway", "sports_centre", "stadium", "summer_camp", "swimming_area" , "swimming_pool", "track", "water_park", "wildhide_life");

    return list_tags_leisure;
}

function getAllValueForTagShopOSM() {

    var list_tags_shop = {};

    list_tags_shop["Nouriture, Boissons"] = [];
    list_tags_shop["Nouriture, Boissons"].push("alcohol" , "bakery", "beverages", "brewing_supplies", "butcher", "cheese", "chocolate", "coffee", "confectionery", "convenience", "deli", "dairy", "farm", "greengrocer", "ice_cream", "pasta", "pastry", "seafood", "spices", "tea");

    list_tags_shop["Magasin général, super et hyper marché"] = [];
    list_tags_shop["Magasin général, super et hyper marché"].push("department_store", "general", "kiosk", "mall", "supermarket");

    list_tags_shop["Vêtement, Chaussure, Accessoires"] = [];
    list_tags_shop["Vêtement, Chaussure, Accessoires"].push("baby_goods", "bag", "boutique", "clothes", "fabric", "fashion", "jewelry", "leather", "sewing", "shoes", "tailor", "watches");

    list_tags_shop["Magasin Discount, de charité"] = [];
    list_tags_shop["Magasin Discount, de charité"].push("charity", "second_hand", "variety_store");

    list_tags_shop["Santé et beauté"] = [];
    list_tags_shop["Santé et beauté"].push("beauty", "chemist", "cosmetics", "erotic", "hairdresser", "hairdresser_supply", "hearing_aids", "herbalist", "massage", "medical_supply", "nutrition_supplements", "optician", "perfumery", "tatoo");

    list_tags_shop["Do-it-yourself, household, building materials, gardening"] = [];
    list_tags_shop["Do-it-yourself, household, building materials, gardening"].push("agrarian", "bathroom_furnishing", "doityourself", "electrical", "energy", "fireplace" , "florist", " garden_centre", " garden_furniture" , "gas", " glaziery", "hardware", " houseware" , "locksmith", "paint", "security", "trade");

    list_tags_shop["Furniture and interior"] = [];
    list_tags_shop["Furniture and interior"].push("antiques", "bed", "candles", "carpet", "curtain" , "furniture", " interior_decoration" , "kitchen", "lamps", "tiles", " window_blind");

    list_tags_shop["Electronics"] = [];
    list_tags_shop["Electronics"].push(" computer" , "electronics", "hifi", "mobile_phone", "radiotechnics" , "vacuum_cleaner");

    list_tags_shop["Outdoors and sport, vehicles"] = [];
    list_tags_shop["Outdoors and sport, vehicles"].push("atv", "bicycle", "car", "car_repair", "car_parts", "fuel", "fishing", "free_flying", "hunting", "motorcycle", "outdoor", "scuba_diving", "sports", "swimming_pool" , "tyres");

    list_tags_shop["Art, music, hobbies"] = [];
    list_tags_shop["Art, music, hobbies"].push("art", "collector", "craft", "frame", "games", "model", "music", "musical_instrument", "photo", "camera", "trophy", "video", "video_games");

    list_tags_shop["Stationery, gifts, books, newspapers"] = [];
    list_tags_shop["Stationery, gifts, books, newspapers"].push("anime", "book", "gift", "lottery", "newsagent", "stationery", "ticket");

    list_tags_shop["Autres"] = [];
    list_tags_shop["Autres"].push("bookmaker", "copyshop", "dry_cleaning", "e-cigarette", "funeral_directors", "laundry", "money_lender", "party", "pawnbroker", "pet", "pyrotechnics", "religion", "tobacco", "toys", "travel_agency", "vacant", "weapons");

    return list_tags_shop;
}

function getRomeActivityCodeFromThematic(thematic) {

    if (thematic == "commun") {
        rome_activity_letter = null;
    } else if (thematic == "déchets") {
        rome_activity_letter = null;        
    } else if (thematic == "agriculture,alimentation") {
        rome_activity_letter = "A";
    } else if (thematic == "santé") {
        rome_activity_letter = "J";      
    } else if (thematic == "aménagement,transport,construction") {
        rome_activity_letter = "F,G,I,N"; 
    } else if (thematic == "éducation,petite Enfance") {
        rome_activity_letter = null;        
    } else if (thematic == "citoyenneté") {
        rome_activity_letter = "K";       
    } else if (thematic == "ess,economie social solidaire") {
        rome_activity_letter = "M,C,D";     
    } else if (thematic == "energie,climat") {
        rome_activity_letter = "H";     
    } else if (thematic == "culture,animation") {
        rome_activity_letter = "B,L";
    } else if (thematic == "biodiversité") {
        rome_activity_letter = null;       
    } else if (thematic == "numérique,tic,internet") {
        rome_activity_letter = "E";      
    } else if (thematic == "autres") {
        rome_activity_letter = null;     
    }

    return rome_activity_letter;
}

function getScopeValue() {

    $.each(myMultiScopes, function(index, value) {
        if (value.active == true) {
            if (index.indexOf("_") > 0) {
                scope_value = index;
            } else {
                scope_value = value.name;
            }
        }
    });

    return scope_value;
}

function getCityId() { 

    if ($.cookie().communexionActivated == true) {
        city_id = communexion.currentValue;
    } else { 
        $.each(myMultiScopes, function(index, value) { 
            if (value.active == true) {
                if (value.type == "city") {
                    city_id = index;
                } else if (value.type == "cp") {
                    city_data = getCityDataByInsee(value.name);
                    city_id = city_data._id.$id
                } else {
                    city_id = index;
                } 
            }
        });
    }

    return city_id;
}

function getTypeZone() {

    if ($.cookie().communexionActivated == true) {
        type_zone = "city";
    } else { 
        $.each(myMultiScopes, function(index, value) { 
            if (value.active == true) {
                if (value.type == "city") {
                    type_zone = "city";
                } else if (value.type == "cp") {
                    type_zone = "city";
                } else {
                    type_zone = "zone";
                } 
            }
        });
    }

    return type_zone;
}

function getCityDataByInsee(insee) {

    $.ajax({
        type: "GET",
        url: baseUrl + "/co2/interoperability/get/insee/"+insee,
        async: false,
        success: function(data){ mylog.log("succes get CityDataByInsee", data); //mylog.dir(data);
            if ((Object.keys(data).length) <= 1) {
                $.each(data, function(index, value) {
                    city_data = value;
                });
            }
            else {
                city_data = data;
            }
        }
    });
    return city_data;
}

function getCityDataById(id, type=null) {

    $.ajax({
        type: "GET",
        url: baseUrl + "/co2/interoperability/get/type/"+type+"/id/"+id,
        async: false,
        success: function(data){ mylog.log("succes get CityDataById", data); //mylog.dir(data);
            if ((Object.keys(data).length) <= 1) {
                $.each(data, function(index, value) {
                    city_data = value;
                });
            }
            else {
                city_data = data;
            }
        }
    });

    return city_data;
}

function getUrlInteropForWiki(wikidataID) {

    var url_wiki = baseUrl + "/api/convert/wikipedia?url=https://www.wikidata.org/wiki/Special:EntityData/"+wikidataID+".json";

    if (text_search_name !== "") {
        url_wiki += "&text_filter="+text_search_name;
    } 

    return url_wiki;
}

function getUrlInteropForDatagouv(insee) {

    var url_datagouv = baseUrl + "/api/convert/datagouv?url=https://www.data.gouv.fr/api/1/spatial/zone/fr/town/"+insee+"/datasets";

    return url_datagouv;
}

function getUrlInteropForOsm(geoShape, amenity_filter = null) {

    var url_osm = baseUrl + '/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["name"](poly:"'+geoShape+'");out%20'+endNow+';';

    if (amenity_filter == null) {
        if (text_search_name !== "") {
            url_osm = baseUrl + '/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["name"~"'+text_search_name+'",i](poly:"'+geoShape+'");out%20'+endNow+';';
        } 
    } else {
        if (amenity_filter == "") {
            url_osm = baseUrl + '/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["amenity"="NIMPORTEQUOI"](poly:"'+geoShape+'");out%20'+endNow+';';
        } else {
            if (text_search_name == "") {
                url_osm = baseUrl + '/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["amenity"~"^('+amenity_filter+')"](poly:"'+geoShape+'");out%20'+endNow+';';
            } else {
                url_osm = baseUrl + '/api/convert/osm?url=http://overpass-api.de/api/interpreter?data=[out:json];node["name"~"'+text_search_name+'"]["amenity"~"^('+amenity_filter+')"](poly:"'+geoShape+'");out%20'+endNow+';';
            }
        }
    }                         

    return url_osm;
}

function getUrlInteropForOds(geofilter, filter = null) {

    var url_ods = baseUrl + "/api/convert/ods?url=https://data.opendatasoft.com/api/records/1.0/search/?dataset=sirene%40public&facet=categorie&facet=proden&facet=libapen&facet=siege&facet=libreg_new&facet=saisonat&facet=libtefen&facet=depet&facet=libnj&facet=libtca&facet=liborigine&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;

    if (text_search_name !== "") {
        url_ods += "&q="+text_search_name;
    }

    if (filter !== null) {
        url_ods = url_ods + filter;
    }

    return url_ods;
}

function getUrlInteropForDatanova(geofilter) {

    var url_datanova = baseUrl + "/api/convert/datanova?url=https://datanova.laposte.fr/api/records/1.0/search/?dataset=laposte_poincont&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;

    if (text_search_name !== "") {
        url_datanova = baseUrl + "/api/convert/datanova?url=https://datanova.laposte.fr/api/records/1.0/search/?dataset=laposte_poincont&q="+text_search_name+"&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
    }

    return url_datanova;
}

function getUrlInteropForPoleEmploi(insee, filter = null) {

    var url_pole_emploi = baseUrl + "/api/convert/poleemploi?url=https://api.emploi-store.fr/partenaire/infotravail/v1/datastore_search_sql?sql=SELECT%20%2A%20FROM%20%22421692f5%2Df342%2D4223%2D9c51%2D72a27dcaf51e%22%20WHERE%20%22CITY_CODE%22=%27"+insee+"%27%20LIMIT%20"+endNow;

    if (filter !== null) {
       url_pole_emploi = baseUrl + "/api/convert/poleemploi?rome_activity="+filter+"&url=https://api.emploi-store.fr/partenaire/infotravail/v1/datastore_search_sql?sql=SELECT%20%2A%20FROM%20%22421692f5%2Df342%2D4223%2D9c51%2D72a27dcaf51e%22%20WHERE%20%22CITY_CODE%22=%27"+insee+"%27%20LIMIT%20"+endNow;
    } 

    return url_pole_emploi;
}

function getUrlInteropForEducMembre(geofilter) {


    var url_educ_membre = baseUrl + "/api/convert/educmembre?url=https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-iuf-les-membres&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;

    if (text_search_name !== "") {
        url_educ_membre = baseUrl + "/api/convert/educmembre?url=https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-iuf-les-membres&q="+text_search_name+"&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
    }

    return url_educ_membre;
}

function getUrlInteropForEducEtab(geofilter) {

    var url_educ_etab = baseUrl + "/api/convert/educetab?url=https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-etablissements-publics-prives-impliques-recherche-developpement&facet=siren&facet=libelle&facet=date_de_creation&facet=categorie&facet=libelle_ape&facet=tranche_etp&facet=categorie_juridique&facet=wikidata&facet=commune&facet=unite_urbaine&facet=departement&facet=region&facet=pays&facet=badge&facet=region_avant_2016&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;

    if (text_search_name !== "") {
        url_educ_etab = baseUrl + "/api/convert/educetab?url=https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-etablissements-publics-prives-impliques-recherche-developpement&facet=siren&facet=libelle&facet=date_de_creation&facet=categorie&facet=libelle_ape&facet=tranche_etp&facet=categorie_juridique&facet=wikidata&facet=commune&facet=unite_urbaine&facet=departement&facet=region&facet=pays&facet=badge&facet=region_avant_2016&q="+text_search_name+"&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;
    }

    return url_educ_etab;
}

function getUrlInteropForEducStruct(geofilter) {

    var url_educ_struct = baseUrl + "/api/convert/educstruct?url=https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-structures-recherche-publiques-actives&facet=numero_national_de_structure&facet=annee_de_creation&facet=tutelles&facet=type_de_tutelle&facet=nature_de_tutelle&facet=nature_de_structure&facet=type_de_structure&facet=niveau_de_structure&facet=domaine_scientifique&facet=panel_erc&facet=theme_de_recherche&facet=commune&facet=unite_urbaine&facet=departement&facet=region&facet=pays&facet=comue&facet=region_avant_2016&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;

    if (text_search_name !== "") {
        url_educ_struct = baseUrl + "/api/convert/educstruct?url=https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-structures-recherche-publiques-actives&facet=numero_national_de_structure&facet=annee_de_creation&facet=tutelles&facet=type_de_tutelle&facet=nature_de_tutelle&facet=nature_de_structure&facet=type_de_structure&facet=niveau_de_structure&facet=domaine_scientifique&facet=panel_erc&facet=theme_de_recherche&facet=commune&facet=unite_urbaine&facet=departement&facet=region&facet=pays&facet=comue&facet=region_avant_2016&rows=30&start="+startNow+"&q="+text_search_name+"&geofilter.polygon="+geofilter;
    }

    return url_educ_struct;
}

function getUrlInteropForEducEcole(geofilter) {

    var url_educ_ecole = baseUrl + "/api/convert/educecole?url=https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-ecoles_doctorales_annuaire&facet=numero&facet=groupe_disciplinaire&facet=toutes_les_disciplines&facet=discipline_principale&facet=localisation&facet=liste_tous_etablissements&facet=laboratoires_rattaches&facet=annee_de_creation&facet=annee_accreditation&facet=etablissement_support&facet=liste_codes_tous_etablissements&facet=identifiants_des_laboratoires&facet=libelle_unite_urbaine&facet=libelle_departement&facet=libelle_academie&facet=libelle_region&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;

    if (text_search_name !== "") {
        url_educ_ecole = baseUrl + "/api/convert/educ?dataset=ecole&url=https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-ecoles_doctorales_annuaire&facet=numero&facet=groupe_disciplinaire&facet=toutes_les_disciplines&facet=discipline_principale&facet=localisation&facet=liste_tous_etablissements&facet=laboratoires_rattaches&facet=annee_de_creation&facet=annee_accreditation&facet=etablissement_support&facet=liste_codes_tous_etablissements&facet=identifiants_des_laboratoires&facet=libelle_unite_urbaine&facet=libelle_departement&facet=libelle_academie&facet=libelle_region&q="+text_search_name+"&rows=30&start="+startNow+"&geofilter.polygon="+geofilter;

    }

    return url_educ_ecole;
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
        icon_image = "<img width=100 style='margin-top:20px;' src='"+moduleUrl+"/images/logos/logo-laposte.png'>";
    } else if (type_elt == "ods") {
        icon_image = "<img width=100 style='margin-top:20px;' src='"+moduleUrl+"/images/logos/opendata-soft-logo.png'>";
    } else if (type_elt == "osm") {
        icon_image = "<img width=100 style='margin-top:20px;' src='"+moduleUrl+"/images/logos/OSM-logo.png'>";
    } else if (type_elt == "wiki") {
        icon_image = "<img width=100 style='margin-top:20px;' src='"+moduleUrl+"/images/logos/logo-wikidata.png'>";
    } else if (type_elt == "datagouv") {
        icon_image = "<img width=100 style='margin-top:20px;' src='"+moduleUrl+"/images/logos/data-gouv-logo.png'>";
    } else if (type_elt == "poleemploi") {
        icon_image = "<img width=100 style='margin-top:20px;' src='"+moduleUrl+"/images/logos/logo_pole_emploi.png'>";
    } else if (type_elt == "educ_etab" || type_elt == "educ_membre" || type_elt == "educ_ecole" || type_elt == "educ_struct") {
        icon_image = "<img width=100 style='margin-top:20px;' src='"+moduleUrl+"/images/logos/logo_open_data_educ.jpg'>";
    } 

    else {
        icon_image = "<img width=100 style='margin-top:20px;' src='"+moduleUrl+"'>";
    }

    return icon_image;

}

function getimgProfilPathForInteropDataOnMap(type_elt) {

    // var imgProfilPath;
    // var baseUrlJustForThis = baseUrl.substring(0,baseUrl.length-2);

    if (type_elt == "poi.interop.datanova") {
        var imgProfilPath = moduleUrl+"/images/logos/logo-laposte.png";
    } else if (type_elt == "poi.interop.wiki") {
        var imgProfilPath = moduleUrl+"/images/logos/logo-wikidata.png";
    } else if (type_elt == "poi.interop.datagouv") {
        var imgProfilPath = moduleUrl+"/images/logos/data-gouv-logo.png";
    } else if (type_elt == "poi.interop.poleemploi") {
        var imgProfilPath = moduleUrl+"/images/logos/logo_pole_emploi.png";
    } else if (type_elt == "poi.interop.osm") {
        var imgProfilPath = moduleUrl+"/images/logos/OSM-logo.png";
    } else if (type_elt == "poi.interop.ods") {
        var imgProfilPath = moduleUrl+"/images/logos/opendata-soft-logo.png";
    } else if (type_elt == "poi.interop.educ_etab" || type_elt == "poi.interop.educ_membre" || type_elt == "poi.interop.educ_ecole" || type_elt == "poi.interop.educ_struct") {
        var imgProfilPath = moduleUrl+"/images/logos/logo_open_data_educ.jpg";
    }
    return imgProfilPath;
}



