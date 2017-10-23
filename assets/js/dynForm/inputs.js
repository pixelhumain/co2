dynForm = {
    jsonSchema : {
	    title : typeObj.config.title,
	    icon : "cogs",
	    debug:true,
	    properties : {
            info : {
                inputType : "custom",
                html:"<p class='text-red'>All DYNFORM existing inputs are all here <hr></p>",
            },
            type : dyFInputs.inputHidden(),
            name : dyFInputs.name("network"),
            "skin[title]" : dyFInputs.name(),
            image : dyFInputs.image(),
            "request[searchTag]" : dyFInputs.tags(),
            tags : dyFInputs.tags(),
    		    description : dyFInputs.textarea(tradDynForm.longDescription, "..."),
            startDate :{
              inputType : "datetime",
              label : "Date de début",
              placeholder : "Date de début"
            },
            endDate :{
              inputType : "datetime",
              label : "Date de fin",
              placeholder : "Date de fin"
            },
            urls : dyFInputs.urls,
            "result[displayImage]" : dyFInputs.radio( "Display Images ?", { "true" : { icon:"check-circle-o", lbl:trad.yes },
                                                        "false" : { icon:"circle-o", lbl:trad.no} } ),
            //keyVal : dyFInputs.keyVal,
            /*"linksTag[]" : dyFInputs.subDynform({
               key : dyFInputs.name(),
               tagParent : "Type",
               "background-color" : "#f5f5f5",
               "image" : "Travail.png",
                "tags" : dyFInputs.tags(),
            }, "multi"),*/
	    }
	}
};