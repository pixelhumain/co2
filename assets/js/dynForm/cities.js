dynForm = {
	jsonSchema : {
		title : "Modifier une ville",
		icon : "university",
		properties : {
			info : {
				"inputType" : "custom",
				"html":"<p><i class='fa fa-info-circle'></i> Modifier une ville</p>",
			},
			id :dyFInputs.inputHidden(),
			insee : dyFInputs.inputHidden(null, { required : true }),
			name : dyFInputs.name,
			country : dyFInputs.inputHidden(null, { required : true }),
			dep : dyFInputs.inputText("Numéro du département", "Numéro du département"),
			depName : dyFInputs.inputText("Nom du département", "Nom du département"),
			region : dyFInputs.inputText("Numéro de la région", "Numéro de la région"),
			regionName : dyFInputs.inputText("Nom de la région", "Nom de la région", rules),
			latitude : dyFInputs.inputText("Latitude", "Latitude"),
			longitude : dyFInputs.inputText("Longitude", "Longitude"),
			postalcode : dyFInputs.inputText("postalcode", "postalcode"),
			osmid : dyFInputs.inputText("OSM id", "OSM id"),
			wikidata : dyFInputs.inputText("wikidata", "wikidata")
		}
	}
}