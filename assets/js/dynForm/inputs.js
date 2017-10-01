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
            //keyVal : dyFInputs.keyVal,
            linksTag : dyFInputs.subDynform({
               title : dyFInputs.name(),
               tagParent : "Type",
               "background-color" : "#f5f5f5",
               "image" : "Travail.png",
                "tags" : dyFInputs.tags(),
            }, "multi","json"),
	    }
	}
};