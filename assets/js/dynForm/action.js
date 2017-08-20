dynForm = {
    jsonSchema : {
	    title : "Ajouter une action",
	    icon : "cogs",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	"sub" : function(){
	    		dataHelper.activateMarkdown("#ajaxFormModal #message");
	    		$("#ajaxFormModal #room").val( contextDataDDA.id );
    		 	$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" dans :<br><small class='text-white'>"+contextDataDDA.name+"</small>" );
	    	}
	    },
        beforeBuild : function(){
            dyFObj.setMongoId('actions',function(){});
        },
	    afterSave : function(data){
            if( $('.fine-uploader-manual-trigger').length &&  $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
                $('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            else 
            { 
                dyFObj.closeForm();
                uiCoop.getCoopData(null, null, "room", null, data.map.idParentRoom);
                setTimeout(function(){
                    uiCoop.getCoopData(null, null, "action", null, data.id);
                }, 1000); 
                //urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
            }
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Une Action permet de faire avancer votre projet ou le fonctionnement de votre association</p>",
            },
	        id : dyFInputs.inputHidden(""),
            /*room :{
            	inputType : "select",
            	placeholder : "Choisir un espace",
            	init : function(){
            		if( userId )
            		{
            			/*filling the seclect* /
	            		if(notNull(window.myActionsList)){
	            			html = buildSelectGroupOptions( window.myActionsList);
	            			$("#room").append(html); 
	            		} else {
	            			getAjax( null , baseUrl+"/" + moduleId + "/rooms/index/type/citoyens/id/"+userId+"/view/data/fields/actions" , function(data){
	            			    window.myActionsList = {};
	            			    $.each( data.actions , function( k,v ) 
	            			    { mylog.log(v.parentType,v.parentId);
	            			    	if(v.parentType){
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
								if(contextDataDDA && contextDataDDA.id)
									$("#ajaxFormModal #room").val( contextDataDDA.id );
						    } );
	            		}
            		}
            	},
            	custom : "<br/><span class='text-small'>Choisir l'espace où s'ajoutera votre action parmi vos organisations et projets<br/>Vous pouvez créer des espaces coopératifs sur votre commune, organisation et projet  </span>"
            },*/
            idParentRoom : dyFInputs.inputHidden(currentRoomId),
            name : dyFInputs.name("action"),
            description : dyFInputs.textarea(tradDynForm.longDescription, "..."),
            startDate :{
              inputType : "datetime",
              label : "Date de début",
              placeholder : "Date de début"
            },
            endDate :{
              inputType : "datetime",
              label : "Date de fin",
              placeholder : "Date de fin"
            },
         	status: dyFInputs.inputHidden( "todo" ),
            tags : dyFInputs.tags(),
            urls : dyFInputs.urls,
            email : dyFInputs.inputHidden( ( (userId!=null && userConnected != null) ? userConnected.email : "" ) ),
            idUserAuthor: dyFInputs.inputHidden(userId),
            //type : dyFInputs.inputHidden( "action" ),
            parentId : dyFInputs.inputHidden(contextData.id),
            parentType : dyFInputs.inputHidden(contextData.type),
            // image : dyFInputs.image()
	    }
	}
};