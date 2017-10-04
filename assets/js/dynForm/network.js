dynForm = {
	removeFilter : function (ix) { 
		//alert(ix);
		typeObj.network.filters.splice( ix, 1 );
		$(".filterList").html("");
		$.each(typeObj.network.filters,function( k,v ) { 
          $(".filterList").append(v.name+" <a href='javascript:;' onclick='typeObj.network.dynForm.removeFilter("+k+")'><i class='fa fa-times text-red'></i> </a><br/>");
        })
	},
    jsonSchema : {
	    title : tradDynForm.configNetwork,
	    icon : "connectdevelop",
	    type : "object",
	    //debug : true,
	    beforeBuild : function(){
	    	dyFObj.setMongoId('network',function(){
	    		uploadObj.gotoUrl = location.hash;
	    	});
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
	    	//alert("formatData");
	    	if( $(dyFObj.activeModal+" #ajaxFormModal request[searchTag]").val() != "" && formData["request[searchTag]"] )
				formData["request[searchTag]"] = formData["request[searchTag]"].split(",");
	    	if( $(dyFObj.activeModal+" #ajaxFormModal add").val() != "" && formData.add )
				formData.add = formData.add.split(",");
			if( typeObj.network.filters )
				formData.filters = typeObj.network.filters;
			return formData;
	    },
	    properties : {
	    	breadcrumb : {
                inputType : "custom",
                html:"<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.openForm(\"filr\")'><i class='fa fa-times'></i></a> NETWORK </h4>",
            },
       
            "type" : dyFInputs.inputHidden(),
	        "name" : dyFInputs.name(),

	        skinInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>SKIN Section<hr></p>",
            },
            "skin[title]" : dyFInputs.name(),
	        	"skin[logo]" : dyFInputs.image(),
		    "skin[paramsLogo][origin]" : dyFInputs.radio( "Logo Origin ?", { "true" : { icon:"check-circle-o", lbl:trad.yes },
											 			"false" : { icon:"circle-o", lbl:trad.no} } ),
											 			/*dyFInputs.checkboxSimple("true", "skinparamsLogoorigin", 
            										{ "onText" : "Oui",
            										  "offText": "Non",
            										  "onLabel" : "on",
            										  "offLabel": "off",
            										  "inputId" : ".skinparamsLogoorigin",
            										  "labelText": "skin params Logo origin ?",
            										  "labelInInput": "Activer les amendements",
            										  "labelInformation": "<i class='fa fa-info-circle'></i> Les votes sont désactivés pendant la période d'amendement"

            }),*/

            filterInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>FILTER Section "+
                	"</p>",
            },
            "filters[types]" : dyFInputs.radio( "Types ?", { "true" : { icon:"check-circle-o", lbl:trad.yes },
											 			"false" : { icon:"circle-o", lbl:trad.no} } ),
            filterTagsInfo : {
                inputType : "custom",
                html:"<a href='javascript:;' class='btn btn-dark' onclick='dyFObj.openForm(\"filter\",null,null,true)'><i class='fa fa-plus'></i> Ajouter un Filtre</a>"+
                	"<div class='filterList'></div>",
            },
            
            addInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>ADD Section</p>",
            },
            add : dyFInputs.tags( ["organization","project","event"] ),

            resultInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>RESULT Section</p>",
            },
            "result[displayImage]" : dyFInputs.radio( "Display Images ?", { "true" : { icon:"check-circle-o", lbl:trad.yes },
											 			"false" : { icon:"circle-o", lbl:trad.no} } ),
            requestInfo : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>REQUEST Section</p>",
            },
            "request[searchTag]" : dyFInputs.tags(),
	    },
	    tooltips : {
	    	"filters[types]" : "CLALALALAL LFGSGSDF\n GFDSG FDSGSD",
	    	add : "XXXX SXKXKKXXOKOXSPOKXSKXSXSXS \X  XS XS \n XS XS XS XS"
	    }
	}
};