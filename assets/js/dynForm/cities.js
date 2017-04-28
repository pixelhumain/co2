dynForm = {
	jsonSchema : {
		title : "Modifier une ville",
		icon : "university",
		properties : {
			info : {
				"inputType" : "custom",
				"html":"<p><i class='fa fa-info-circle'></i> Modifier une ville</p>",
			},
			id :typeObjLib.inputHidden(),
			insee : typeObjLib.inputHidden(null, { required : true }),
			name : typeObjLib.name,
			country : typeObjLib.inputHidden(null, { required : true }),
			dep : typeObjLib.inputText("Numéro du département", "Numéro du département"),
			depName : typeObjLib.inputText("Nom du département", "Nom du département"),
			region : typeObjLib.inputText("Numéro de la région", "Numéro de la région"),
			regionName : typeObjLib.inputText("Nom de la région", "Nom de la région", rules),
			latitude : typeObjLib.inputText("Latitude", "Latitude"),
			longitude : typeObjLib.inputText("Longitude", "Longitude"),
			postalcode : typeObjLib.inputText("postalcode", "postalcode"),
			osmid : typeObjLib.inputText("OSM id", "OSM id"),
			wikidata : typeObjLib.inputText("wikidata", "wikidata")
		}
	}
}