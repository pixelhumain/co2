dynForm = {
    jsonSchema : {
	    title : "Faire une proposition",
	    icon : "gavel",
	    type : "object",
	    onLoads : {
	    	
	    	sub : function(){
	    		$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-dark");
    		 	
    		 	dataHelper.activateMarkdown("#ajaxFormModal #message");
    			//$("#ajaxFormModal #survey").val( contextDataDDA.id );
    			if (typeof contextDataDDA.name != "undefined" && contextDataDDA.name != "")
    		 	$("#ajax-modal-modal-title").html($("#ajax-modal-modal-title").html()+" dans :<br><small class='text-white'>"+contextDataDDA.name+"</small>" );
	    	},
	    	onload : function(data){
				$("#ajaxFormModal #idParentRoom").val(currentRoomId);
				console.log("checkcheck0", data, typeof data);

				if(typeof data.amendementActivated != "undefined"){
					data.amendementActivated = (data.amendementActivated == "true" || data.amendementActivated == true) ? true : false;
					data.voteActivated 		 = (data.voteActivated == "true" || data.voteActivated == true) 			? true : false;
					
					console.log("checkcheck1", data);

					if(data.amendementActivated == false){
						var idTrue = "#ajaxFormModal .amendementActivatedcheckboxSimple .btn-dyn-checkbox[data-checkval='true']";
	    				var idFalse = "#ajaxFormModal .amendementActivatedcheckboxSimple .btn-dyn-checkbox[data-checkval='false']";
	    				
	    				$("#ajaxFormModal #amendementActivated").val("false");
						$("#ajaxFormModal .amendementActivatedcheckboxSimple .btn-dyn-checkbox[data-checkval='false']").trigger( "click" );
						
						$(idFalse).addClass("bg-red").removeClass("letter-red");
	    				$(idTrue).removeClass("bg-green-k").addClass("letter-green");

	    				$("#ajaxFormModal .amendementActivatedcheckboxSimple .lbl-status-check").html(
	    					'<span class="letter-red"><i class="fa fa-minus-circle"></i> désactivés</span>');

	    				if(typeof params["inputId"] != "undefined") $(params["inputId"]).hide(400);
					}
				}

				if(typeof data.voteDateEnd != "undefined"){
					var d = new Date(data.voteDateEnd);
					var voteDateEnd = moment(d).format("DD/MM/YYYY HH:mm");
					console.log("voteDateEnd", d, voteDateEnd);
					$("#ajaxFormModal #voteDateEnd").val(voteDateEnd);
				}

				if(typeof data.amendementDateEnd != "undefined"){
					d = new Date(data.amendementDateEnd);
					var amendementDateEnd = moment(d).format("DD/MM/YYYY HH:mm");
					$("#ajaxFormModal #amendementDateEnd").val(amendementDateEnd);
				}else{
					$("#ajaxFormModal #amendementDateEnd").val("");
				}

			}
	    },
        beforeSave : function(){
        	if($("#ajaxFormModal #amendementActivated").val() == "true"){
				$("#ajaxFormModal #status").val("amendable");
			}
			else if($("#ajaxFormModal #voteActivated").val() == "true"){
				$("#ajaxFormModal #status").val("tovote");
			}
			console.log("beforeSave", $("#ajaxFormModal #voteActivated").val(), $("#ajaxFormModal #status").val());

			var dateformat = "DD/MM/YYYY HH:mm";
	    	var outputFormat="YYYY-MM-DD HH::mm";
	    	
	    	//console.log("TEST DATE TIMEZONE");
	    	//console.log($("#ajaxFormModal #amendementDateEnd").val());
			$("#ajaxFormModal #amendementDateEnd").val( moment( $("#ajaxFormModal #amendementDateEnd").val(), dateformat).format() );
	    	//console.log($("#ajaxFormModal #amendementDateEnd").val());
	    	
			$("#ajaxFormModal #voteDateEnd").val( moment(   $("#ajaxFormModal #voteDateEnd").val(), dateformat).format() );
        },
	    afterSave : function(data){
            if( $('.fine-uploader-manual-trigger').length &&  $('.fine-uploader-manual-trigger').fineUploader('getUploads').length > 0 )
                $('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            else 
            { 
                dyFObj.closeForm(); 
               	var oldCount = $("li.sub-proposals a.load-coop-data[data-status='"+data.map.status+"'] .badge").html();
               	console.log("data success save proposal", data);
               	$("li.sub-proposals a.load-coop-data[data-status='"+data.map.status+"'] .badge").html(parseInt(oldCount)+1);
               	
               	if(typeof data.map.idParentRoom != "undefined"){
	               	uiCoop.getCoopData(null, null, "room", null, data.map.idParentRoom);
	                setTimeout(function(){
	                	uiCoop.getCoopData(null, null, "proposal", null, data.id);
	                }, 1000);
	            }else{
	            	uiCoop.getCoopData(null, null, "room", null, currentRoomId);
	                setTimeout(function(){
	                	uiCoop.getCoopData(null, null, "proposal", null, idParentProposal);
	                }, 1000);
	            }
            }
	    },
	    properties : {
	    	info : {
                inputType : "custom",
                html:"<br><p><i class='fa fa-info-circle'></i> Une proposition sert à discuter et demander l'avis d'une communauté sur une idée ou une question donnée</p>",
            },
	        id : dyFInputs.inputHidden(),
	        idParentRoom : dyFInputs.inputHidden(currentRoomId),
            /*idParentRoom :{
            	inputType : "select",
            	label : "Choisir un espace",
            	init : function(){
            		if( userId )
            		{
            			/*filling the seclect* /
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
		            			    }* /
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
	            		});* /

            		}
            	},
            	//custom : "<br/><span class='text-small'>Une thématique est un espace de décision lié à une ville, une organisation ou un projet <br/>Vous pouvez créer des espaces coopératifs sur votre commune, organisation et projet</span>"
            },*/
            title : dyFInputs.name("proposal", { required : false }),
            description : dyFInputs.textarea(tradDynForm.textproposal, "..."),
            infoargs : {
                inputType : "custom",
                html:"<div class='text-left'><b><i class='fa fa-info-circle'></i> <i>Le vote final portera sur le contenu de votre proposition.</b>"+
                	 "<br>Pour plus de clareté, détaillez toute information complémentaire, relative à votre proposition, dans la section suivante.</i></div>",
            },
	        arguments : dyFInputs.textarea(tradDynForm.textargumentsandmore, "..."),
            amendementActivated : dyFInputs.checkboxSimple("true", "amendementActivated", 
            										{ "onText" : "Oui",
            										  "offText": "Non",
            										  "onLabel" : "activés",
            										  "offLabel": "désactivés",
            										  "inputId" : ".amendementDateEnddatetime",
            										  "labelText": "Activer les amendements ?",
            										  "labelInInput": "Activer les amendements",
            										  "labelInformation": "<i class='fa fa-info-circle'></i> Les votes sont désactivés pendant la période d'amendement"

            }),
            amendementDateEnd : dyFInputs.amendementDateEnd,
            voteActivated : dyFInputs.inputHidden( true ),
            /*dyFInputs.checkbox(false, "voteActivated", 
            										{ "onText" : "Non",
            										  "offText": "Oui",
            										  "onLabel" : "activés",
            										  "offLabel": "désactivés",
            										  "inputId" : ".voteDateEnddatetime",
            										  "labelText": "Votes",
            										  "labelInInput": "Activer les votes",
            										  "labelInformation": "Vous pourrez activer les votes plus tard",

            }),*/
            voteDateEnd : dyFInputs.voteDateEnd,
            tags : dyFInputs.tags(),
            //image : dyFInputs.image(),
            urls : dyFInputs.urls,
            //email: dyFInputs.inputHidden( ( (userId!=null && userConnected!=null) ? userConnected.email : "") ),
            //idUserAuthor : dyFInputs.inputHidden( ( (userId!=null && userConnected!=null) ? userId : "") ),
            status: dyFInputs.inputHidden( "amendable" ),
            majority: dyFInputs.inputHidden( 50 ),
            //canModify: dyFInputs.inputHidden( true ),
            parentId : dyFInputs.inputHidden(contextData.id),
            parentType : dyFInputs.inputHidden(contextData.type),
            //organizer : dyFInputs.inputHidden("currentUser"),
            //type : dyFInputs.inputHidden("entry")
                        
	    }
	}
};