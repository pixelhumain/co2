dynForm = {
    jsonSchema : {
	    title : "Ajouter une action",
	    icon : "cogs",
	    type : "object",
	    onLoads : {
	    	//pour creer un subevnt depuis un event existant
	    	/*"onload" : function(){	    		
	    		$("#ajaxFormModal #room").val( contextDataDDA.room );
    		 	$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" dans :<br><small class='text-white'>"+contextDataDDA.name+"</small>" );
	    	},*/
            sub : function(){ //alert("yo");
                $("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
                                              .addClass("bg-dark");
            },
            onload : function(data){
                console.log("onload action data", data, "currentRoomId", typeof currentRoomId);
                if(typeof currentRoomId != "undefined" && currentRoomId != "")
                $("#ajaxFormModal #idParentRoom").val(currentRoomId);
                else if(typeof data.idParentRoom != "undefined")
                $("#ajaxFormModal #idParentRoom").val(data.idParentRoom);

                if(typeof data.startDate != "undefined"){
                    var d = new Date(data.startDate);
                    var startDate = moment(d).format("DD/MM/YYYY HH:mm");
                    console.log("startDate", d, startDate);
                    $("#ajaxFormModal #startDate").val(startDate);
                }

                if(typeof data.endDate != "undefined"){
                    d = new Date(data.endDate);
                    var endDate = moment(d).format("DD/MM/YYYY HH:mm");
                    $("#ajaxFormModal #endDate").val(endDate);
                }else{
                    $("#ajaxFormModal #endDate").val("");
                }

                if(typeof useIdParentResolution != "undefined" && useIdParentResolution == true){
                    $("#idParentResolution").val(idParentResolution);
                    useIdParentResolution = false;
                }
            }
	    },
        beforeBuild : function(){
            //dyFObj.setMongoId('actions',function(){});
        },
        beforeSave : function(){
            var dateformat = "DD/MM/YYYY HH:mm";
            var outputFormat="YYYY-MM-DD HH::mm";
            
            console.log("TEST DATE TIMEZONE");
            console.log($("#ajaxFormModal #amendementDateEnd").val());
            
            $("#ajaxFormModal #startDate").val( moment( $("#ajaxFormModal #startDate").val(), dateformat).format() ); 
            $("#ajaxFormModal #endDate").val( moment(   $("#ajaxFormModal #endDate").val(), dateformat).format() );
        },
	    afterSave : function(data){
            if( $('.fine-uploader-manual-trigger').length &&  $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
                $('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            else 
            { 
                console.log("afterSave action data", data);
                dyFObj.closeForm();
                uiCoop.getCoopData(contextData.type, contextData.id, "room", null, data.map.idParentRoom);
                setTimeout(function(){
                    uiCoop.getCoopData(contextData.type, contextData.id, "action", null, data.id);
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
            idParentResolution: dyFInputs.inputHidden( "" ),
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