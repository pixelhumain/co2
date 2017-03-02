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
			    		 	$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" sur "+contextData.name );
			    	}
			    },
			    beforeBuild : function(){
			    	elementLib.setMongoId('projects');
			    },
			    afterSave : function(){
					if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
				    	$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
				    else {
				    	elementLib.closeForm();
				    	url.loadByHash( location.hash );	
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
			        name : typeObjLib.name("project"),
		            parentType : typeObjLib.hidden,
		            image : typeObjLib.image("#project.detail.id."+uploadObj.id),
		            location : typeObjLib.location,
		            tags :typeObjLib.tags,
		            formshowers : {
		            	label : "En détails",
		                inputType : "custom",
		                html:"<a class='btn btn-default  text-dark w100p' href='javascript:;' onclick='$(\".descriptionwysiwyg,.urltext\").slideToggle();activateSummernote(\"#ajaxFormModal #description\");'><i class='fa fa-plus'></i> options (desc, urls)</a>",
		            },
			        description : typeObjLib.descriptionOptionnel,
		            url : typeObjLib.urlOptionnel,
		            "preferences[publicFields]" : typeObjLib.hiddenArray,
		            "preferences[privateFields]" :typeObjLib.hiddenArray,
		            "preferences[isOpenData]" : typeObjLib.hiddenTrue,
		            "preferences[isOpenEdition]" : typeObjLib.hiddenTrue
			    }
			}
		};