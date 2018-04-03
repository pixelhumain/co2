dynForm = {
    jsonSchema : {
	    title : tradDynForm.createsurvey,
	    icon : "gavel",
	    type : "object",
	    onLoads : {
	    	
	    	sub : function(){
	    	
	    	},
	    	onload : function(data){ 		
	    		if(typeof currentRoomId == "undefined") var currentRoomId = "";

	            console.log("init input hidden parentdata : ", contextData.id, contextData.type, currentRoomId);
	            $("#ajaxFormModal #parentId").val(contextData.id);
	            $("#ajaxFormModal #parentType").val(contextData.type);
	            //$("#ajaxFormModal #idParentRoom").val(currentRoomId);
				
	    		dataHelper.activateMarkdown("#ajaxFormModal #description");
	    		//dataHelper.activateMarkdown("#ajaxFormModal #arguments");

				console.log("checkcheck0", data, typeof data, contextData);

				$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
						  					  .addClass("bg-turq");

    		 	console.log("dynFormProposal", contextData);
    		 	

            	$("#ajax-modal #ajaxFormModal .titletext label").html("<i class='fa fa-chevron-down'></i> "+tradDynForm.surveyname);
            	$("#ajax-modal #ajaxFormModal .titletext input#title").attr("placeholder", tradDynForm.surveyname);
            	

				if(typeof data.voteDateEnd != "undefined"){
					var d = new Date(data.voteDateEnd);
					var voteDateEnd = moment(d).format("DD/MM/YYYY HH:mm");
					console.log("voteDateEnd", d, voteDateEnd);
					$("#ajaxFormModal #voteDateEnd").val(voteDateEnd);
				}

				$("#ajaxFormModal .majoritytext").append(
						"<small class='pull-left margin-top-5' id='info'><i class='fa fa-info-circle'></i> "+
						 tradDynForm.proposalMustHaveMore + "<b>"+
						 "50%</b> "+tradDynForm.ofvotes+" <span class='letter-green'>"+tradDynForm.favorables+"</span> "+tradDynForm.tobevalidated +
						"</small>");

				$("#ajaxFormModal #majority").val("50");
				$('#ajaxFormModal #majority').filter_input({regex:'^(0|[1-9][0-9]*)$'});
				
				$('#ajaxFormModal #majority').keyup (function(){
					var strval = $(this).val();
					var intval = strval != "" ? parseInt(strval) : 0;
					console.log("intval1", intval);
					if(intval > 100) 
						$("#ajaxFormModal .majoritytext small#info").html(
						"<i class='fa fa-info-circle'></i> "+ tradDynForm.nowayover100);

					if(intval < 50) 
						$("#ajaxFormModal .majoritytext small#info").html(
						"<i class='fa fa-info-circle'></i> "+ tradDynForm.nowayunder50);

					if(intval >= 50 && intval <= 100) 
					$("#ajaxFormModal .majoritytext small#info").html(
						"<i class='fa fa-info-circle'></i> "+tradDynForm.proposalMustHaveMore+" <b>"+
						intval + "%</b> "+tradDynForm.ofvotes+" <span class='letter-green'>"+tradDynForm.favorables+"</span> "+tradDynForm.tobevalidated);
				});

				$('#ajaxFormModal #majority').focusout (function(){
					var strval = $(this).val();
					var intval = strval != "" ? parseInt(strval) : 0;
					console.log("intval1", intval);
					if(intval > 100) intval = 100;
					if(intval < 50) intval = 50;
					console.log("intval2", intval);
					$('#ajaxFormModal #majority').val(intval);
					$("#ajaxFormModal .majoritytext small#info").html(
						"<i class='fa fa-info-circle'></i> "+tradDynForm.proposalMustHaveMore+" <b>"+
						intval + "%</b> "+tradDynForm.ofvotes+" <span class='letter-green'>"+tradDynForm.favorables+"</span> "+tradDynForm.tobevalidated);
				});

				$("#ajaxFormModal .form-group.answersarray").hide();

				$("#ajaxFormModal .multiChoicecheckboxSimple .btn-dyn-checkbox").click(function(){
					var checkval = $(this).data("checkval");
					console.log("checkval", checkval);
					if(checkval==true) {
						$("#ajaxFormModal .form-group.answersarray").hide(200);
						//enable amendement when simple answer 
						$("#ajaxFormModal .amendementActivatedcheckboxSimple").show(200); console.log("show");
						$("#ajaxFormModal .amendementActivatedcheckboxSimple .btn-dyn-checkbox[data-checkval='true']").click();
					}else{
						$("#ajaxFormModal .form-group.answersarray").show(200);
						//disable amendement when multi answer
						$("#ajaxFormModal .amendementActivatedcheckboxSimple .btn-dyn-checkbox[data-checkval='false']").click();
						$("#ajaxFormModal .amendementActivatedcheckboxSimple").hide(200); console.log("hide");
					}
				});

				$("#ajaxFormModal .multiChoicecheckboxSimple #multiChoice").remove();

				$("#ajaxFormModal .locationBtn").html("<i class='fa fa-home'></i> Sélectionner une commune");

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
	               	uiCoop.getCoopData(contextData.type, contextData.id, "room", null, data.map.idParentRoom);
	                setTimeout(function(){
	                	uiCoop.getCoopData(contextData.type, contextData.id, "proposal", null, data.id);
	                }, 1000);
	            }else{
	            	uiCoop.getCoopData(contextData.type, contextData.id, "room", null, currentRoomId);
	                setTimeout(function(){
	                	uiCoop.getCoopData(contextData.type, contextData.id, "proposal", null, idParentProposal);
	                }, 1000);
	            }
            }
	    },

	    properties : {
	    	info : {
                inputType : "custom",
                html:"<br><p><i class='fa fa-info-circle'></i> "+tradDynForm.infoSurvey+"</p>",
            },
	        id : dyFInputs.inputHidden(),
	        //idParentRoom : dyFInputs.inputHidden(),
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
								if(contextData && contextData.id)
									$("#ajaxFormModal #survey").val( contextData.id );
						    } );
	            		}
	            		/*$("#survey").change(function() { 
	            			mylog.dir( $(this).val().split("_"));
	            		});* /

            		}
            	},
            	//custom : "<br/><span class='text-small'>Une thématique est un espace de décision lié à une ville, une organisation ou un projet <br/>Vous pouvez créer des espaces coopératifs sur votre commune, organisation et projet</span>"
            },*/
            title : dyFInputs.name("survey", { required : false }),
            description : dyFInputs.textarea(tradDynForm.surveytext, "..."),
            multiChoice : dyFInputs.checkboxSimple("true", "multiChoice", 
            										{ "onText" : "pour / contre",//trad.yes,
            										  "offText": "choix multiple", //trad.no,
            										  "onLabel" : "pour / contre",//tradDynForm.anonymous,
            										  "offLabel": "choix multiple", //tradDynForm.nominative,
            										  //"inputId" : ".amendementDateEnddatetime",
            										  "labelText": "Type de réponse",
            										  //"labelInInput": "Activer les amendements",
            										  "labelInformation": "<i class='fa fa-info-circle'></i> " + "Choisissez <b>choix multiple</b> pour définir une liste de réponses personnalisées" // tradDynForm.keepSecretIdentityVote

            }),
            answers : dyFInputs.multiChoice,
            
	        //arguments : dyFInputs.textarea(tradDynForm.textargumentsandmore, "..."),
            /*amendementActivated : dyFInputs.checkboxSimple("true", "amendementActivated", 
            										{ "onText" : trad.yes,
            										  "offText": trad.no,
            										  "onLabel" : trad.activated,
            										  "offLabel": trad.disabled,
            										  "inputId" : ".amendementDateEnddatetime",
            										  "labelText": tradDynForm.lblAmmendementEnabled + " ?",
            										  "labelInInput": tradDynForm.lblAmmendementEnabled,
            										  "labelInformation": "<i class='fa fa-info-circle'></i> "+
            										  					  tradDynForm.lblAmmendementDisabled
            }),
            amendementDateEnd : dyFInputs.amendementDateEnd,*/
            voteActivated : dyFInputs.inputHidden( true ),
            voteDateEnd : dyFInputs.voteDateEnd,
            majority: dyFInputs.inputText( trad.ruleOfMajority + " (%) <small class='letter-green'>"+trad.giveValueMajority+"</small>", "50%" ),
            
            voteAnonymous : dyFInputs.checkboxSimple("true", "voteAnonymous", 
            										{ "onText" : trad.yes,
            										  "offText": trad.no,
            										  "onLabel" : tradDynForm.anonymous,
            										  "offLabel": tradDynForm.nominative,
            										  //"inputId" : ".amendementDateEnddatetime",
            										  "labelText": tradDynForm.voteAnonymous + " ?",
            										  //"labelInInput": "Activer les amendements",
            										  "labelInformation": "<i class='fa fa-info-circle'></i> " + tradDynForm.keepSecretIdentityVote

            }),
            
            voteCanChange : dyFInputs.checkboxSimple("true", "voteCanChange", 
            										{ "onText" : trad.yes,
            										  "offText": trad.no,
            										  "onLabel" : tradDynForm.changeVoteEnabled,
            										  "offLabel": tradDynForm.changeVoteForbiden,
            										  //"inputId" : ".amendementDateEnddatetime",
            										  "labelText": tradDynForm.authorizeChangeVote,
            										  //"labelInInput": "Activer les amendements",
            										  "labelInformation": "<i class='fa fa-info-circle'></i> " + tradDynForm.allowChangeVote

            }),

            infoScope : {
                inputType : "custom",
                html:"<br><i class='fa fa-angle-down fa-2x letter-red'></i><br>"+
                		"<span style='font-size:13px;' class='bg-red badge'><i class='fa fa-bullseye'></i> "+
                			tradDynForm.selectcitytosharesurvey+
                		"</span>",
            },
	        
            location : {
				label : tradDynForm["Scoping"],
		       	inputType : "location"
		    },
            tags : dyFInputs.tags(),
            //image : dyFInputs.image(),
            urls : dyFInputs.urls,
            //email: dyFInputs.inputHidden( ( (userId!=null && userConnected!=null) ? userConnected.email : "") ),
            //idUserAuthor : dyFInputs.inputHidden( ( (userId!=null && userConnected!=null) ? userId : "") ),
            status: dyFInputs.inputHidden( "amendable" ),
            //canModify: dyFInputs.inputHidden( true ),
            parentId : dyFInputs.inputHidden(contextData.id),
            parentType : dyFInputs.inputHidden(contextData.type),
            //organizer : dyFInputs.inputHidden("currentUser"),
            //type : dyFInputs.inputHidden("entry")
                        
	    }
	}
};