dynForm = {
		    jsonSchema : {
			    title : trad.addProject,
			    icon : "lightbulb-o",
			    type : "object",
			    onLoads : {
			    	//pour creer un subevnt depuis un event existant
			    	onload : function(){
			    		dyFInputs.setHeader("bg-purple");
		    	   	},
			    	"sub" : function(){
			    		dyFInputs.setSub("bg-purple");
			    	}
			    },
			    beforeBuild : function(){
			    	//alert("before Build project");
			    	dyFObj.setMongoId('projects', function(){
			    		uploadObj.gotoUrl = '#page.type.projects.id.'+uploadObj.id;
			    	});
			    },
			    afterSave : function(data,callB){
					if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 ){
				    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
				    	//principalement pour les surveys
				    	if(typeof callB == "function")
	    					callB();
					} else { 
			          	dyFObj.closeForm(); 
			          	urlCtrl.loadByHash( uploadObj.gotoUrl );
			        }
			    },
			    beforeSave : function(){
			    	if( typeof $("#ajaxFormModal #description").code === 'function' ) 
			    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
			    },
			    properties : {
			    	info : {
		                inputType : "custom",
		                html:"<p class='text-purple'>"+tradDynForm["infocreateproject"]+"<hr>" +
							  "</p>",
		            },
			        name : dyFInputs.name("project"),
		            parentType : dyFInputs.inputHidden(),
		            parentId : dyFInputs.inputHidden(),
		            image : dyFInputs.image(),
		            location : dyFInputs.location,
		            email : dyFInputs.text(),
		            tags :dyFInputs.tags(),
		            shortDescription : dyFInputs.textarea(tradDynForm["shortDescription"], "...",{ maxlength: 140 }),
		            /*formshowers : {
		            	label : tradDynForm["indetails"],
		                inputType : "custom",
		                html:"<a class='btn btn-default  text-dark w100p' href='javascript:;' onclick='$(\".descriptionwysiwyg,.urltext\").slideToggle();activateSummernote(\"#ajaxFormModal #description\");'><i class='fa fa-plus'></i> "+tradDynForm["optiondescrurl"]+"</a>",
		            },*/
		            url : dyFInputs.inputUrl(),
		            "preferences[publicFields]" : dyFInputs.inputHidden([]),
		            "preferences[privateFields]" : dyFInputs.inputHidden([]),
		            "preferences[isOpenData]" : dyFInputs.inputHidden(true),
		            "preferences[isOpenEdition]" : dyFInputs.inputHidden(true)
			    }
			}
		};