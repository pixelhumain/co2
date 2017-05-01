dynForm = {
    jsonSchema : {
	    title : "Point of interest Form",
	    icon : "map-marker",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	subPoi : function(){
	    		if(contextData.type && contextData.id ){
    				$('#ajaxFormModal #parentId').val(contextData.id);
	    			$("#ajaxFormModal #parentType").val( contextData.type ); 
	    		}
	    	}
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Une url.</p>",
            },
            urls : dyFInputs.urls,
            type : dyFInputs.inputSelect("Type du point d'intérêt", null, poiTypes),
	        name :  dyFInputs.name,
            description : dyFInputs.descriptionOptionnel ,
            location : dyFInputs.location,
            tags : dyFInputs.tags(),
            parentId :dyFInputs.inputHidden(),
            parentType : dyFInputs.inputHidden(),
	    }
	}
};