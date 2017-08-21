dynForm = {
    jsonSchema : {
	    title : "Ajouter une action",
	    icon : "cogs",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	"onload" : function(){
	    		
	    		$("#ajaxFormModal #room").val( contextDataDDA.room );
    		 	$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" dans :<br><small class='text-white'>"+contextDataDDA.name+"</small>" );
	    	}
	    },
        beforeBuild : function(){
            dyFObj.setMongoId('actions',function(){});
        },
	    afterSave : function(){
            if( $('.fine-uploader-manual-trigger').length &&  $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
                $('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            else 
            { 
                dyFObj.closeForm(); 
                urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
            }
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Une Action permet de faire avancer votre projet ou le fonctionnement de votre association</p>",
            },
	        id : dyFInputs.inputHidden(""),
            room :{
            	inputType : "select",
            	placeholder : "Choisir un espace",
            	init : function(){
            		if( userId )
            		{
            			/*filling the seclect*/
	            		if(notNull(window.myActionsList)){
	            			html = buildSelectGroupOptions( window.myActionsList);
	            			$("#room").append(html); 
	            		} else {
	            			getAjax( null , baseUrl+"/" + moduleId + "/rooms/index/type/citoyens/id/"+userId+"/view/data/fields/actions" , function(data){
	            			    window.myActionsList = {};
	            			    $.each( data.actions , function( k,v ) { 
                                    mylog.log(v.parentType,v.parentId);
	            			    	if(v.parentType && v.parentType != "cities"){
			            			    if( !window.myActionsList[ v.parentType] ){
											var label = ( v.parentType == "cities" && cpCommunexion && v.parentId.indexOf(cpCommunexion) ) ? cityNameCommunexion : "Thématique des " + trad[v.parentType];
			            			    	window.myActionsList[ v.parentType] = {"label":label};
			            			    	window.myActionsList[ v.parentType].options = {};
			            			    }
		            			    	window.myActionsList[v.parentType].options[v['_id']['$id'] ] = v.name; 
		            			    }
	            			    }); 
	            			    mylog.dir(window.myActionsList);
	            			    html = buildSelectGroupOptions(window.myActionsList);
								$("#room").append(html);
								if(contextDataDDA && contextDataDDA.room)
									$("#ajaxFormModal #room").val( contextDataDDA.room );
						    } );
	            		}
            		}
            	},
            	custom : "<br/><span class='text-small'>Choisir l'espace où s'ajoutera votre action parmi vos organisations et projets<br/>Vous pouvez créer des espaces coopératifs sur votre commune, organisation et projet  </span>"
            },
            name : dyFInputs.name,
            message : dyFInputs.textarea(tradDynForm.longDescription, "..."),
            startDate :{
              inputType : "date",
              label : "Date de début",
              placeholder : "Date de début"
            },
            dateEnd :{
              inputType : "date",
              label : "Date de fin",
              placeholder : "Date de fin"
            },
         	tags : dyFInputs.tags(),
            urls : dyFInputs.urls,
            email : dyFInputs.inputHidden( ( (userId!=null && userConnected != null) ? userConnected.email : "" ) ),
            organizer: dyFInputs.inputHidden( "currentUser" ),
            type : dyFInputs.inputHidden( "action" ),
            parentId : dyFInputs.inputHidden( userId ),
            parentType :  dyFInputs.inputHidden( "citoyens" ),
            image : dyFInputs.image()
	    }
	}
};