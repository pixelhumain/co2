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
			mylog.log("formData", formData);
			//formData = dyFObj.formatData(formData,collection,ctrl);
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
			var str = "" ;
			$.each(typeObj.network.filter,function(k,v) { 
				str = "<div class='col-md-12 text-left'>"+
							"<a href='javascript:;' onclick='typeObj.network.dynForm.removeFilter("+k+")'>"+
								"<i class='fa fa-times text-red'></i> "+
							"</a>"+v.name+
							"<br/>";

				str+="<ul class='col-xs-offset-1'>";

				var i = 0 ;
				while(notNull(v["keyVal"+i]) && notNull(v["tagskeyVal"+i])){
					str +="<li >"+v["keyVal"+i]+" : ";
					$.each(v["tagskeyVal"+i].split(","),function(ktag,vtag) { 
						str += "<span class='text-red' >#"+vtag+"</span> ";
					});
					i++;
				}
				str += "</div>";  
				mylog.log("str", str); 			
				$(".filterList").append(str);
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
			name : dyFInputs.inputText(tradDynForm["Filters category"], tradDynForm["Filters category"], { required : true }),
			keyVal : dyFInputs.keyVal(tradDynForm["Filters"]),
		}
	}
};