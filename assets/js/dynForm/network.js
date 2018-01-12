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
		    		mylog.log("displayCommunexion", $("#ajaxFormModal #displayCommunexion").val())
		    		if($("#ajaxFormModal #displayCommunexion").val() == "true")
		    			$("#ajaxFormModal .addtags").show();
		    		else
		    			$("#ajaxFormModal .addtags").hide();
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

	    	if( $(dyFObj.activeModal+" #ajaxFormModal add").val() != "" && formData.add ){
				formData.add = formData.add.split(",");
				var newAdd = {} ;
				$.each(formData.add,function (k, v) { 
    				newAdd[v] = true;
    			});
    			formData.add = newAdd;
	    	}
	    	//---------------request
			if( $(dyFObj.activeModal+" #ajaxFormModal request[searchType]").val() != "" && formData["request[searchType]"] )
				formData["request[searchType]"] = formData["request[searchType]"].split(",");
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
	      

/************************* Skin *****************************/
	        skinInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>SKIN Section<hr></p>",
            },
            "skin[title]" : dyFInputs.inputText("Titre du network", "Titre du network", { required : true }),
            "skin[shortDescription]" : dyFInputs.textarea(tradDynForm["shortDescription"], "...",{ maxlength: 140 }),
	        "skin[logo]" : dyFInputs.image("Logo"),
		    // "skin[displayCommunexion]" : dyFInputs.radio(	"Permettre aux utilisateurs de s'identifier", 
		    // 												{ "true" : { icon:"check-circle-o", lbl:trad.yes },
						// 					 				"false" : { icon:"circle-o", lbl:trad.no} },
						// 					 				{ required : true } ),

		    "displayCommunexion" : dyFInputs.checkboxSimple("true", "displayCommunexion", {
			        							labelText: "Permettre aux utilisateurs de s'identifier", 
			        							onText:tradDynForm.yes, 
			        							offText:tradDynForm.no, 
			        							onLabel : tradDynForm.yes,
            									offLabel: tradDynForm.no,
            									inputId: "#displayCommunexion"
			        					}),

		    add : dyFInputs.tags( ["organization","project","event"], "Type d'élement pour l'ajout", "Type d'élement pour l'ajout" ),

/************************* Result *****************************/
            requestInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>REQUEST Section</p>",
            },
            "request[scope]" : dyFInputs.scope,
            "request[searchType]" : dyFInputs.tags( ["organizations","projects","events"], "Type élement qui seront affichés", "Type élement qui seront affichés" ),
            "request[searchTag]" : dyFInputs.tags(tagsList, "Afficher les éléments qui auront les tags suivant :", "Afficher les éléments qui auront les tags suivant :" ),
            "request[sourceKey]" : dyFInputs.tags([], null, "Key using for import") ,
            
            

/************************* Filter *****************************/

            filterInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>FILTER Section </p>",
            },
            // "filters[types]" : dyFInputs.radio( "Types ?", { "true" : { icon:"check-circle-o", lbl:trad.yes },
											 // 			"false" : { icon:"circle-o", lbl:trad.no} } ),
            filterTagsInfo : {
                inputType : "custom",
                html:"<a href='javascript:;' class='btn btn-dark' onclick='dyFObj.openForm(\"filter\",null,null,true)'><i class='fa fa-plus'></i> Ajouter un Filtre</a>"+
                	"<div class='filterList'></div>",
            },

            resultInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>RESULT Section</p>",
            },
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