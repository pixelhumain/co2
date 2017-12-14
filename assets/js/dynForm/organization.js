dynForm = {
    jsonSchema : {
	    title : trad.addOrganization,
	    icon : "group",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	sub : function(){
				
				if(typeof currentKFormType == "undefined" || currentKFormType == "" || 
				  currentKFormType == "null" || currentKFormType == null){
					currentKFormType = "organization";
				}else{
					$("#ajaxFormModal .typeselect").addClass("hidden");
				}
	    		//console.log("onLoads Sub currentKFormType", currentKFormType, contextData, contextData.id);
                var typeName = (typeof currentKFormType != "undefined" && currentKFormType!=null) ? trad["add"+currentKFormType] : elementObj.dynForm.jsonSchema.title;
                var typeIcon = (typeof currentKFormType != "undefined" && currentKFormType!=null) ? typeObj[currentKFormType].icon : elementObj.dynForm.jsonSchema.icon;
	            

                $("#ajax-modal-modal-title").html(
                        "<i class='fa fa-"+typeIcon+"'></i> "+typeName);
                
                $("#ajax-modal .modal-header").removeClass("bg-dark bg-red bg-purple bg-green bg-green-poi bg-orange bg-turq bg-yellow bg-url");
				$("#ajax-modal .infocustom p").removeClass("text-dark text-red text-purple text-green text-green-poi text-orange text-turq text-yellow text-url");

                if(typeof currentKFormType != "undefined" && typeObj[currentKFormType] && typeObj[currentKFormType].color){
                	//alert("dyn" + typeObj[currentKFormType].color);
                    $("#ajax-modal .modal-header").addClass("bg-"+typeObj[currentKFormType].color);
                    $("#ajax-modal .infocustom p").addClass("text-"+typeObj[currentKFormType].color);
                }else{
                	$("#ajax-modal .modal-header").addClass("bg-dark");
                    $("#ajax-modal .infocustom p").addClass("text-dark");
                }

	    		if(contextData && contextData.type && contextData.id ){
	    			//console.log("HERE WE ARE");
    				$('#ajaxFormModal #parentId').val(contextData.id);
	    			$("#ajaxFormModal #parentType").val( contextData.type ); 

	    		 	$("#ajax-modal-modal-title").append(
	    		 		" <br><small class='text-white'>"+tradDynForm["speakingas"]+" : <span class='text-dark'>"+
	    		 														contextData.name+
	    		 														"</span></small>" );
	    		}
	    	},
	    },
	    beforeBuild : function(){
	    	dyFObj.setMongoId('organizations', function(){
	    		uploadObj.gotoUrl = '#page.type.organizations.id.'+uploadObj.id;
	    	});
	    	
	    },
	    beforeSave : function(){
	    	if (typeof $("#ajaxFormModal #description").code === 'function' ) 
	    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
	    },
	    afterSave : function(){
			if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
		    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		    else { 
	          dyFObj.closeForm(); 
	          urlCtrl.loadByHash( uploadObj.gotoUrl );
	        }
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p class='text-"+typeObj["organization"].color+"'>"+
                		//"Faire connaître votre Organisation n'a jamais été aussi simple !<br>" +
					    tradDynForm["infocreateorganization"]+" ...<hr>" +
					 "</p>",
            },
	        name : dyFInputs.name("organization"),
	        similarLink : dyFInputs.similarLink,
	        type : dyFInputs.inputSelect(tradDynForm["organizationType"], tradDynForm["organizationType"], organizationTypes, { required : true }),
            role : dyFInputs.inputSelect(	tradDynForm["yourrole"],
            								tradDynForm["whichrole"]+" ?", 
            								{ admin : trad.administrator, member : trad.Member, creator : trad.justCitizen }, 
            								{ required : true } ),
            tags : dyFInputs.tags(),
            location : dyFInputs.location,
	        image : dyFInputs.image(),
            email : dyFInputs.text(),
	        shortDescription : dyFInputs.textarea(tradDynForm["shortDescription"], "...",{ maxlength: 140 }),
	        url : dyFInputs.inputUrl(),
            "preferences[publicFields]" : dyFInputs.inputHidden([]),
            "preferences[privateFields]" : dyFInputs.inputHidden([]),
            "preferences[isOpenData]" : dyFInputs.inputHidden(true),
            "preferences[isOpenEdition]" : dyFInputs.inputHidden(true)
	    }
	}
};