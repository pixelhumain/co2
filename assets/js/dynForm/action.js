dynForm = {
    jsonSchema : {
	    title : "Ajouter une action",
	    icon : "cogs",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	"sub" : function(){
	    		$("#ajaxFormModal #room").val( contextDataDDA.id );
    		 	$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" dans :<br><small class='text-white'>"+contextDataDDA.name+"</small>" );
	    	}
	    },
	    beforeSave : function(){
	    	if( typeof $("#ajaxFormModal #message").code === 'function' ) 
	    		$("#ajaxFormModal #message").val( $("#ajaxFormModal #message").code() );
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
            },
            name : dyFInputs.name,
            message : dyFInputs.textarea("Description", "..."),
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
            formshowers : {
                label : "En détails",
                inputType : "custom",
                html:"<a class='btn btn-default  text-dark w100p' href='javascript:;' onclick='$(\".urlsarray\").slideToggle()'><i class='fa fa-plus'></i> options (urls)</a>",
            },
            urls : dyFInputs.urls,
            email : dyFInputs.inputHidden( ( (userId!=null && userConnected != null) ? userConnected.email : "" ) ),
            organizer: dyFInputs.inputHidden( "currentUser" ),
            type : dyFInputs.inputHidden( "action" ),
            parentId : dyFInputs.inputHidden( userId ),
            parentType :  dyFInputs.inputHidden( "citoyens" ),
	    }
	}
};