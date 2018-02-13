dynForm = {
    jsonSchema : {
	    title : tradDynForm["addbookmark"],
	    icon : "bookmark",
	    type : "object",
	    onLoads : {
	    	sub : function(){
    		 	dyFInputs.setSub("bg-url");
    		},
	    },
	    afterSave : function(){
			dyFObj.closeForm();
            if(location.hash.indexOf("view.library")>0){
                    buildNewBreadcrum("bookmarks");
                    getViewGallery(1,"","bookmarks");
            }else
		      urlCtrl.loadByHash( location.hash );
	    },
	    properties : {
           // url : dyFInputs.bookmarkUrl(tradDynForm["linkUrl"], tradDynForm["linkUrl"], { required : true, url : true }),
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> "+tradDynForm["infocreatebookmark"]+".</p>",
            },
            url : dyFInputs.bookmarkUrl(tradDynForm["linkUrl"], tradDynForm["linkUrl"], { required : true, url : true }),
            name : dyFInputs.inputText(tradDynForm["titleurl"], tradDynForm["titleurl"], { required : true }),
            tags :dyFInputs.tags(),
            description : dyFInputs.textarea(tradDynForm["description"], "..."),
            index : dyFInputs.inputHidden(),
            parentId : dyFInputs.inputHidden(null, { required : true }),
            parentType : dyFInputs.inputHidden(null, { required : true })
	    }
	}
};