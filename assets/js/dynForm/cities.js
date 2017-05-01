dynForm = {
	jsonSchema : {
		title : "Modifier une ville",
		icon : "university",
		properties : {
			info : {
				"inputType" : "custom",
				"html":"<p><i class='fa fa-info-circle'></i> Modifier une ville</p>",
			},
			id :dyFoInputs.inputHidden(),
			insee : dyFoInputs.inputHidden(null, { required : true }),
			name : dyFoInputs.name,
			country : dyFoInputs.inputHidden(null, { required : true }),
			dep : dyFoInputs.inputText("Numéro du département", "Numéro du département"),
			depName : dyFoInputs.inputText("Nom du département", "Nom du département"),
			region : dyFoInputs.inputText("Numéro de la région", "Numéro de la région"),
			regionName : dyFoInputs.inputText("Nom de la région", "Nom de la région", rules),
			latitude : dyFoInputs.inputText("Latitude", "Latitude"),
			longitude : dyFoInputs.inputText("Longitude", "Longitude"),
			postalcode : dyFoInputs.inputText("postalcode", "postalcode"),
			osmid : dyFoInputs.inputText("OSM id", "OSM id"),
			wikidata : dyFoInputs.inputText("wikidata", "wikidata")
		}
	}
}