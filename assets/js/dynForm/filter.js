dynForm = {
	jsonSchema : {
		title : typeObj.filter.title,
		icon : typeObj.filter.title,
		debug:true,
		save : function () { 
			mylog.log("formData success", formData);
			//alert("filter save "+dyFObj.activeModal);
			if( typeof typeObj.network.filter == "undefined" )
				typeObj.network.filter = [];
			var formData = $("#openModal #ajaxFormModal").serializeFormJSON();
			if(formData.key){
				delete formData.key;
				delete formData.collection;
				delete formData.id;
			}
			// formData.tags = formData.tags.split(",");
			// formData.tags = formData.tags.split(",");
			typeObj.network.filter.push( formData );
			mylog.log("typeObj.network.filter", typeObj.network.filter);
			$(".filterList").html("");
			$.each(typeObj.network.filter,function(k,v) { 

				$(".filterList").append(v.name+" <a href='javascript:;' onclick='typeObj.network.dynForm.removeFilter("+k+")'><i class='fa fa-times text-red'></i> </a><br/>");
			});

			$("#openModal").modal("hide");
			dyFObj.activeModal = "#ajax-modal";
			dyFObj.activeElem = "elementObj";
		},
		properties : {
			info : {
				inputType : "custom",
				html:"<p class='text-red'>Les filtres controlent le menu de gauche et les tags que vous voulez présenter aux utilisateurs (voir documentation) <hr></p>",
			},
			name : dyFInputs.inputText("Catégorie de filtres", "Exemple : ", { required : true }),
			keyVal : dyFInputs.keyVal,
		}
	}
};