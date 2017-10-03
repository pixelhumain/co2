dynForm = {
    jsonSchema : {
	    title : typeObj.filter.title,
	    icon : typeObj.filter.title,
	    debug:true,
      save : function () { 
        //alert("filter save "+dyFObj.activeModal);
        if( typeof typeObj.network.filters == "undefined" )
          typeObj.network.filters = [];
        typeObj.network.filters.push( $("#openModal #ajaxFormModal").serializeFormJSON() );
        //mylog.log(typeObj.network.filters);
        $(".filterList").html("");
        $.each(typeObj.network.filters,function(k,v) { 
          delete typeObj.network.filters[k].key;
          delete typeObj.network.filters[k].collection;
          delete typeObj.network.filters[k].id;
          typeObj.network.filters[k].tags = typeObj.network.filters[k].tags.split(",");
          $(".filterList").append(v.name+" <a href='javascript:;' onclick='typeObj.network.dynForm.removeFilter("+k+")'><i class='fa fa-times text-red'></i> </a><br/>");
        })
        $("#openModal").modal("hide");
        dyFObj.activeModal = "#ajax-modal";
        dyFObj.activeElem = "elementObj";
        delete typeObj.filter.dynForm;
      },
	    properties : {
            info : {
                inputType : "custom",
                html:"<p class='text-red'>Les Filtres controle le menu de gauche et les tags que vous voulez présenter aux utilisateurs<hr></p>",
            },
            name : dyFInputs.name(),
            tags : dyFInputs.tags()
	    }
	}
};