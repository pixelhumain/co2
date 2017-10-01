dynForm = {
    jsonSchema : {
	    title : typeObj.config.title,
	    icon : "cogs",
	    noSubmitBtns : true,
	    properties : {
            sectionBtn :{
                label : tradDynForm.whichkindofconfig+" ? ",
	            inputType : "tagList",
                placeholder : "Choisir un type",
                list : typeObj.config.sections,
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