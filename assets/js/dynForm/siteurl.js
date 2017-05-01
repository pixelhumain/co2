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
            urls : dyFoInputs.urls,
            type : dyFoInputs.inputSelect("Type du point d'intérêt", null, poiTypes),
	        name :  dyFoInputs.name,
            description : dyFoInputs.descriptionOptionnel ,
            location : dyFoInputs.location,
            tags : dyFoInputs.tags(),
            parentId :dyFoInputs.inputHidden(),
            parentType : dyFoInputs.inputHidden(),
	    }
	}
};