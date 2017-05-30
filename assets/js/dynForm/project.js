dynForm = {
		    jsonSchema : {
			    title : trad.addProject,
			    icon : "lightbulb-o",
			    type : "object",
			    onLoads : {
			    	//pour creer un subevnt depuis un event existant
			    	"sub" : function(){
			    			$("#ajaxFormModal #parentId").val( contextData.id );
			    		 	$("#ajaxFormModal #parentType").val( contextData.type ); 
			    		 	$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
									  					  .addClass("bg-purple");
			    		 	
			    		 	$("#ajax-modal-modal-title").html(
			    		 		$("#ajax-modal-modal-title").html()+
			    		 		" <br><small class='text-white'>en tant que : <span class='text-dark'>"+contextData.name+"</span></small>" );
			    	}
			    },
			    beforeBuild : function(){
			    	dyFObj.setMongoId('projects');
			    },
			    afterSave : function(urlReload){
					if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 ){
				    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
					} else { 
			          	dyFObj.closeForm(); 
			          	urlCtrl.loadByHash( '#page.type.projects.id.'+uploadObj.id );
			        }
			    },
			    beforeSave : function(){
			    	if( typeof $("#ajaxFormModal #description").code === 'function' ) 
			    		$("#ajaxFormModal #description").val( $("#ajaxFormModal #description").code() );
			    },
			    properties : {
			    	info : {
		                inputType : "custom",
		                html:"<p class='text-purple'>Faire connaître vos projets n'a jamais été aussi simple !<br>" +
							  "Créez votre page en quelques secondes,<br>et complétez les informations plus tard, selon vos besoins<hr>" +
							  "</p>",
		            },
			        name : dyFInputs.name("project"),
		            parentType : dyFInputs.inputHidden(),
		            parentId : dyFInputs.inputHidden(),
		            image : dyFInputs.image("#page.type.projects.id."+uploadObj.id),
		            location : dyFInputs.location,
		            tags :dyFInputs.tags(),
		            shortDescription : dyFInputs.textarea("Description courte", "...",{ maxlength: 140 }),
		            formshowers : {
		            	label : "En détails",
		                inputType : "custom",
		                html:"<a class='btn btn-default  text-dark w100p' href='javascript:;' onclick='$(\".descriptionwysiwyg,.urltext\").slideToggle();activateSummernote(\"#ajaxFormModal #description\");'><i class='fa fa-plus'></i> options (desc, urls)</a>",
		            },
		            url : dyFInputs.inputUrlOptionnel(),
		            "preferences[publicFields]" : dyFInputs.inputHidden([]),
		            "preferences[privateFields]" : dyFInputs.inputHidden([]),
		            "preferences[isOpenData]" : dyFInputs.inputHidden(true),
		            "preferences[isOpenEdition]" : dyFInputs.inputHidden(true)
			    }
			}
		};