dynForm = {
    jsonSchema : {
	    title : typeObj.addAny.title,
	    icon : typeObj.addAny.icon,
	    noSubmitBtns : true,
	    properties : {
            sectionBtn :{
                label : tradDynForm.what+" ? ",
	            inputType : "tagList",
                placeholder : "Choisir un type",
                list : typeObj.addAny.sections,
                trad : tradCategory,
                init : function(){
                	$(".sectionBtn").off().on("click",function()
	            	{
	            		dyFObj.openForm($(this).data('key'));
	            	});
	            	//manage update bulding here 
	            }
            },
	        
	    }
	}
};