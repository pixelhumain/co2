dynForm = {
    jsonSchema : {
	    title : "Ajouter une proposition",
	    icon : "gavel",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	"sub" : function(){
	    		dataHelper.activateMarkdown("#ajaxFormModal #message");
    			$("#ajaxFormModal #survey").val( contextDataDDA.id );
    			if (typeof contextDataDDA.name != "undefined" && contextDataDDA.name != "")
    		 	$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" dans :<br><small class='text-white'>"+contextDataDDA.name+"</small>" );
	    	}
	    },
	    /*beforeBuild : function(){
            dyFObj.setMongoId('survey',function(){
                uploadObj.gotoUrl = (contextData != null && contextData.type && contextData.id ) ? "#page.type."+contextData.type+".id."+contextData.id+".view.directory.dir.poi" : location.hash;
            });
        },*/
	    afterSave : function(){
            if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
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
                html:"<br><p><i class='fa fa-info-circle'></i> Une proposition sert à discuter et demander l'avis d'une communauté sur une idée ou une question donnée</p>",
            },
	        id : dyFInputs.inputHidden(),
            survey :{
            	inputType : "select",
            	label : "Choisir un espace",
            	init : function(){
            		if( userId )
            		{
            			/*filling the seclect*/
	            		if(notNull(window.myVotesList)){
	            			html = buildSelectGroupOptions( window.myVotesList);
	            			$("#survey").append(html); 
	            		} else {
	            			getAjax( null , baseUrl+"/" + moduleId + "/rooms/index/type/citoyens/id/"+userId+"/view/data/fields/votes" , function(data){
	            			    window.myVotesList = {};
	            			    $.each( data.votes , function( k,v ) 
	            			    { 
	            			    	parentName = "";
		            			    if(!window.myVotesList[ v.parentType]){
		            			    	var label = ( v.parentType == "cities" && cpCommunexion && v.parentId.indexOf(cpCommunexion) ) ? cityNameCommunexion : v.parentType;
		            			    	window.myVotesList[ v.parentType] = {"label":label};
		            			    	window.myVotesList[ v.parentType].options = {}
		            			    } /*else{
		            			    	//if(notNull(myContactsById[v.parentType]) && notNull(myContactsById[v.parentType][v['_id']['$id']]))
		            			    	//parentName = myContactsById[v.parentType][v['_id']['$id']].name;
		            			    }*/
	            			    	window.myVotesList[ v.parentType].options[v['_id']['$id'] ] = v.name+parentName; 
	            			    }); 
	            			    //run through myContacts to fill parent names 
	            			    mylog.dir(window.myVotesList);
	            			    
	            			    html = buildSelectGroupOptions(window.myVotesList);
								$("#survey").append(html);
								if(contextDataDDA && contextDataDDA.id)
									$("#ajaxFormModal #survey").val( contextDataDDA.id );
						    } );
	            		}
	            		/*$("#survey").change(function() { 
	            			mylog.dir( $(this).val().split("_"));
	            		});*/

            		}
            	},
            	//custom : "<br/><span class='text-small'>Une thématique est un espace de décision lié à une ville, une organisation ou un projet <br/>Vous pouvez créer des espaces coopératifs sur votre commune, organisation et projet</span>"
            },
            name : dyFInputs.name("vote"),
            message : dyFInputs.textarea(tradDynForm.longDescription, "..."),
            dateEnd : dyFInputs.dateEnd,
            tags : dyFInputs.tags(),
            //image : dyFInputs.image(),
            urls : dyFInputs.urls,
            email: dyFInputs.inputHidden( ( (userId!=null && userConnected!=null) ? userConnected.email : "") ),
            organizer : dyFInputs.inputHidden("currentUser"),
            type : dyFInputs.inputHidden("entry")
                        
	    }
	}
};