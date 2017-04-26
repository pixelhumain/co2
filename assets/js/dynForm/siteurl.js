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
            urls : typeObjLib.urls,
            type : typeObjLib.inputSelect("Type du point d'intérêt", null, poiTypes),
	        name :  typeObjLib.name,
            description : typeObjLib.descriptionOptionnel ,
            location : typeObjLib.location,
            tags : typeObjLib.tags(),
            parentId :typeObjLib.inputHidden(),
            parentType : typeObjLib.inputHidden(),
	    }
	}
};