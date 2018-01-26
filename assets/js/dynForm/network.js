dynForm = {
	removeFilter : function (ix) { 
		//alert(ix);
		typeObj.network.filter.splice( ix, 1 );
		$(".filterList").html("");
		$.each(typeObj.network.filter,function( k,v ) { 
          $(".filterList").append(v.name+" <a href='javascript:;' onclick='typeObj.network.dynForm.removeFilter("+k+")'><i class='fa fa-times text-red'></i> </a><br/>");
        })
	},
    jsonSchema : {
	    title : tradDynForm.configNetwork,
	    icon : "connectdevelop",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
				$("#ajaxFormModal .displayCommunexioncheckboxSimple .btn-dyn-checkbox").click(function(){
		    		mylog.log("displayCommunexion 2", $("#ajaxFormModal #displayCommunexion").val())
		    		if($("#ajaxFormModal #displayCommunexion").val() == "true")
		    			$("#ajaxFormModal .addcheckboxSimple").show();
		    		else
		    			$("#ajaxFormModal .addcheckboxSimple").hide();
		    	});
	    	},
	    },
	    //debug : true,
	    beforeBuild : function(){
	    	dyFObj.setMongoId('network',function(){
	    		uploadObj.gotoUrl = location.hash;
	    	});
	    },
	    beforeSave : function(){
	    	if ($("#ajaxFormModal [name='request[searchTag]']").val() == '' && $("#ajaxFormModal [name='request[sourceKey]']").val() == '') {
				//alert("break");
	   //  		break;
	   
	    	}
	    },
	    afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else 
		    { 
		        dyFObj.closeForm(); 
		        urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
	        }
	    },
	    canSubmitIf : function () { 
	    	 return ( $("#ajaxFormModal #type").val() ) ? true : false ;
	    },
	    formatData : function(formData){
	    	//$params["skin"]["displayCommunexion"]
	    	//---------------Skin
	    	
	    	if( formData.displayCommunexion )
	    		formData["skin[displayCommunexion]"] = dataHelper.stringToBool(formData.displayCommunexion);
	    	delete formData.displayCommunexion
	    	
	    	//---------------request
			if( $(dyFObj.activeModal+" #ajaxFormModal request[searchType]").val() != "" && formData["request[searchType]"] )
				formData["request[searchType]"] = formData["request[searchType]"].split(",");

			if( formData.add && dataHelper.stringToBool(formData.displayCommunexion) ){
				formData.add = formData["request[searchType]"];
	    	}else{
	    		delete formData.add ;
	    	}

	    	if( $(dyFObj.activeModal+" #ajaxFormModal request[searchTag]").val() != "" && formData["request[searchTag]"] )
				formData["request[searchTag]"] = formData["request[searchTag]"].split(",");
			if( $(dyFObj.activeModal+" #ajaxFormModal request[sourceKey]").val() != "" && formData["request[sourceKey]"] )
				formData["request[sourceKey]"] = formData["request[sourceKey]"].split(",");

			if( notNull(formData.scope) )
				formData["request[scope]"] = formData.scope;

			if( typeObj.network.filter){
				//formData.filter = typeObj.network.filter;
				var newFilters = {
					linksTag : {}
				} ;

				mylog.log("newFilters", newFilters);
				$.each(typeObj.network.filter,function (k, v) { 
    				var i = 0 ;
    				var tags = {};
    				while(notNull(v["keyVal"+i]) && notNull(v["tagskeyVal"+i])){
    					tags[v["keyVal"+i]] = v["tagskeyVal"+i].split(",");
    					i++;
    				}
    				newFilters.linksTag[v["name"]] = {	"tagParent" : "Type",
														"image" : "Travail.png",
														"tags" : tags };
					mylog.log("newFilters", newFilters);
    			});
    			formData.filter = newFilters;
			}
			return formData;
	    },
	    properties : {
	    	breadcrumb : {
                inputType : "custom",
                html:"<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.openForm(\"filr\")'><i class='fa fa-times'></i></a> NETWORK </h4>",
            },
       
            "type" : dyFInputs.inputHidden(),
	        //"name" : dyFInputs.name(),
	        visible : dyFInputs.inputSelect(	"Visibilité du network",
	            								"Choisir la visibilité du network", 
	            								{ public : tradDynForm.public, network : tradDynForm.network, private : tradDynForm.private }, 
	            								{ required : true } ),

			/************************* Skin *****************************/
	        skinInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>"+tradDynForm["Skin"]+"</p>",
            },
            "skin[title]" : dyFInputs.inputText(tradDynForm["Title of your map"], tradDynForm["Title of your map"], { required : true }),
            "skin[shortDescription]" : dyFInputs.textarea(tradDynForm["shortDescription"], "...",{ maxlength: 140 }),
	        "skin[logo]" : dyFInputs.image("Logo"),

		    "displayCommunexion" : dyFInputs.checkboxSimple("true", "displayCommunexion", {
			        							labelText: tradDynForm["Allow users to identify themselves"], 
			        							onText:tradDynForm.yes, 
			        							offText:tradDynForm.no, 
			        							onLabel : tradDynForm.yes,
            									offLabel: tradDynForm.no,
            									inputId: "#displayCommunexion"
			        					}),

		    add : dyFInputs.checkboxSimple("true", "add", {
			        							labelText: tradDynForm["Allow to add elements"], 
			        							onText:tradDynForm.yes, 
			        							offText:tradDynForm.no, 
			        							onLabel : tradDynForm.yes,
            									offLabel: tradDynForm.no,
            									inputId: "#add"
			        					}),

		    //add : dyFInputs.tags( ["organization","project","event"], tradDynForm["Allow to add elements"], tradDynForm["Allow to add elements"] ),

			/************************* Result *****************************/

            requestInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>"+tradDynForm["Request Section"]+"</p>",
            },
            "request[scope]" : dyFInputs.scope,
            "request[searchType]" : dyFInputs.tags( ["organizations","projects","events"], tradDynForm["Elements types will be displayed"], tradDynForm["Elements types will be displayed"] ),
            "request[searchTag]" : dyFInputs.tags(tagsList, tradDynForm["Show items that will have the following tags"], tradDynForm["Show items that will have the following tags"] ),
            "request[sourceKey]" : dyFInputs.tags([], null, tradDynForm["Key used for data import"]) ,

			/************************* Filter *****************************/

            filterInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>"+tradDynForm["Filter Section"]+"</p>",
            },
            // "filters[types]" : dyFInputs.radio( "Types ?", { "true" : { icon:"check-circle-o", lbl:trad.yes },
											 // 			"false" : { icon:"circle-o", lbl:trad.no} } ),
            filterTagsInfo : {
                inputType : "custom",
                html:"<a href='javascript:;' class='btn btn-dark' onclick='dyFObj.openForm(\"filter\",null,null,true)'><i class='fa fa-plus'></i> Ajouter un Filtre</a>"+
                	"<div class='filterList'></div>",
            },

            // resultInfo : {
            //     inputType : "custom",
            //     html:"<p class='item-comment bg-green-comment'>RESULT Section</p>",
            // },
            //"result[displayImage]" : dyFInputs.radio( "Display Images ?", { "true" : { icon:"check-circle-o", lbl:trad.yes },
											 			//"false" : { icon:"circle-o", lbl:trad.no} } ),
	    },
	    tooltips : {
	    	filterInfo : "<a href='www.communecter.org' >CLALALALAL LFGSGSDF\n GFDSG FDSGSD</a>",
	    	"filters[types]" : "CLALALALAL LFGSGSDF\n GFDSG FDSGSD",
	    	add : "XXXX SXKXKKXXOKOXSPOKXSKXSXSXS \n  XS XS \n XS XS XS XS"
	    }
	}
};