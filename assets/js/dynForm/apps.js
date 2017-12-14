dynForm = {
    jsonSchema : {
	    title : typeObj.apps.title,
	    icon : typeObj.apps.icon,
	    noSubmitBtns : true,
	    properties : {
            sectionBtn :{
                inputType : "tagList",
                list : typeObj.apps.sections,
                trad : tradCategory,
                init : function(){
                	$(".sectionBtn").off().on("click",function()
	            	{
	            		urlCtrl.loadByHash($(this).data('key'));
	            	});
	            }
            },
	        
	    }
	}
};