dynForm = {
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
	    	if( $("#ajaxFormModal request[searchTag]").val() != "" && formData["request[searchTag]"] )
				formData["request[searchTag]"] = formData["request[searchTag]"].split(",");
	    	
			return formData;
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-"+typeObj.network.color+"'>"+
                		tradDynForm.infoFormNetwork+
                		"<hr>"+
					 "</p>",
            },
            breadcrumb : {
                inputType : "custom",
                html:"<h4><a href='javascript:;'' class='btn btn-xs btn-danger'  onclick='dyFObj.openForm(\"config\")'><i class='fa fa-times'></i></a> NETWORK </h4>",
            },
       
            "type" : dyFInputs.inputHidden(),
	        "name" : dyFInputs.name("network"),

	        skin : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>Skin Section<hr></p>",
            },
            "skin[title]" : dyFInputs.name(),
	        "skin[logo]" : dyFInputs.image(),
		    "skin[paramsLogo][origin]" : dyFInputs.checkboxSimple("true", "skinparamsLogoorigin", 
            										{ "onText" : "Oui",
            										  "offText": "Non",
            										  "onLabel" : "on",
            										  "offLabel": "off",
            										  "inputId" : ".skinparamsLogoorigin",
            										  "labelText": "skin params Logo origin ?",
            										  "labelInInput": "Activer les amendements",
            										  "labelInformation": "<i class='fa fa-info-circle'></i> Les votes sont désactivés pendant la période d'amendement"

            }),
            
            request : {
                inputType : "custom",
                html:"<p class='item-comment bg-green-comment'>Request Section<hr></p>",
            },
            "request[searchTag]" : dyFInputs.tags(),
	    }
	}
};