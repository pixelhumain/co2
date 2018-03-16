/* uiCoop is use for all function relative to UI for Cooperation Spaces (DDA) */
var uiCoop = {
	"startUI" : function(loadData=true){
		mylog.log("startUICOOP");
		//$("#menu-left-container").hide();
		//$("#div-reopen-menu-left-container").removeClass("hidden");
		$("#main-coop-container").html("");
		$("#modal-preview-coop").html("");
		$("#modal-preview-coop").hide(300);

		$("#btn-close-coop").click(function(){
			if(contextData.slug != "undefined")
				location.hash="#"+contextData.slug;
			$("#coop-data-container").html("");
		});
		//KScrollTo("#div-reopen-menu-left-container");

		//toogleNotif(false);

		$("a.title-section").off().click(function(){
			if($(this).hasClass("open")){
				$("#menuCoop .sub-"+$(this).data("key")).addClass("hidden");
				$(this).removeClass("open");
				$(this).find(".fa-caret-down").removeClass("fa-caret-down").addClass("fa-caret-right");
			}else{
				$("#menuCoop .sub-"+$(this).data("key")).removeClass("hidden");
				$(this).addClass("open");
				$(this).find(".fa-caret-right").removeClass("fa-caret-right").addClass("fa-caret-down");
			}
		});

		uiCoop.initBtnLoadData();

		uiCoop.getCoopData(contextData.type, contextData.id, "menucoop");
		
		if(loadData){
			uiCoop.getCoopData(contextData.type, contextData.id, "proposal");
		}
	},

	"closeUI" : function(reloadStream){
		
	},

	"initBtnLoadData" : function(){
		//alert('initBtnLoadData');
		$(".load-coop-data").off().click(function(){
			mylog.log("load-coop-data");
			var type = $(this).data("type");
			
			if(type == "locked"){
				toastr.info("Vous n'avez pas accès à cet espace");
				return;
			}

			$("#menu-room .load-coop-data").removeClass("active");
			$(".load-coop-data[data-type='"+type+"']").removeClass("active");

			$(this).addClass("active");

			var type = $(this).data("type");
			var status = $(this).data("status");
			var dataId = $(this).data("dataid");
			//mylog.log("LOAD COOP DATA", contextData.type, contextData.id, type, status, dataId);
			uiCoop.getCoopData(contextData.type, contextData.id, type, status, dataId);
		});
	},
	"initBtnLoadDataPreview" : function(){
		//alert('initBtnLoadData');
		$("#modal-preview-coop .load-coop-data, #list-dashboard-dda .load-coop-data").off().click(function(){
			var type = $(this).data("type");
			
			if(type == "locked"){
				toastr.info("Vous n'avez pas accès à cet espace");
				return;
			}

			var dataId = $(this).data("dataid");
			//mylog.log("LOAD COOP DATA", contextData.type, contextData.id, type, status, dataId);
			uiCoop.getCoopDataPreview(type, dataId);
		});
	},

	"initDragAndDrop" : function(){ mylog.log('initDragAndDrop');
		$('.draggable').draggable({
		    revert : true, // sera renvoyé à sa place s'il n'est pas déposé dans #drop
		    appendTo: 'body',
		    helper: 'clone',
		    zIndex: 10000,
    		scroll: false,
    		start : function(){
    			uiCoop.dragId = $(this).data("dataid");
    			uiCoop.dragType = $(this).data("type");
    			mylog.log("start drag", $(this).data("dataid"), "coopId", uiCoop.dragId, "coopType", uiCoop.dragType);
    		}
		});
		$('.droppable').droppable({
			accept : '.draggable', // je n'accepte que le bloc ayant "draggable" pour class
		    drop : function(event, ui){
		        var idNewRoom = $(this).data("dataid");
		        uiCoop.changeRoom(uiCoop.dragType, uiCoop.dragId, idNewRoom, contextData.type, contextData.id);
		    	toastr.info("L'élément a bien été déplacé");
		    },
		    activate : function( event, ui ){
		    	var roomid = $(this).data("dataid");
		    	//mylog.log("activate", roomid);
		    	$(this).parent().addClass("bg-lightblue draggin");
		    },
		    deactivate : function( event, ui ){
		    	var roomid = $(this).data("dataid");
		    	//mylog.log("deactivate", roomid);
		    	$(this).removeClass("text-white").parent().removeClass("bg-lightblue draggin bg-turq");
		    },
		    over : function( event, ui ){
		    	var roomid = $(this).data("dataid");
		    	mylog.log("over", roomid);
		    	$(this).addClass("text-white").parent().addClass("bg-turq");
		    	$(this).parent().removeClass("bg-lightblue");
		    },
		    out : function( event, ui ){
		    	var roomid = $(this).data("dataid");
		    	mylog.log("out", roomid);
		    	$(this).removeClass("text-white").parent().removeClass("bg-turq");
		    	$(this).parent().addClass("bg-lightblue");
		    }
		});
	},

	"minimizeMenuRoom" : function(min){ mylog.log("minimizeMenuRoom", min);
		if(min)	{
			$("#menu-room").addClass("min col-lg-4 col-md-4 col-sm-4")
							.removeClass("col-lg-12 col-md-12 col-sm-12");
			$("#coop-data-container").addClass("col-lg-8 col-md-8 col-sm-8").removeClass("hidden");
		}
		else{
			uiCoop.maximizeReader(false);
			$("#menu-room").removeClass("min col-lg-4 col-md-4 col-sm-4")
							.addClass("col-lg-12 col-md-12 col-sm-12");
			$("#coop-data-container").removeClass("min col-lg-8 col-md-8 col-sm-8").addClass("hidden");
		}
	},

	"maximizeReader" : function(max){ mylog.log("maximizeReader", max);
		if(max)	{
			$("#menu-room").addClass("hidden");
			$("#coop-data-container").removeClass("col-lg-8 col-md-8 col-sm-8")
									 .addClass("col-lg-12 col-md-12 col-sm-12");
		}
		else{
			$("#menu-room").removeClass("hidden");
			$("#coop-data-container").removeClass("col-lg-12 col-md-12 col-sm-12")
									 .addClass("col-lg-8 col-md-8 col-sm-8");
		}
	},

	"showAmendement" : function(show){
		if(show){
			$("#menu-room").addClass("hidden");
			$("#coop-data-container").addClass("col-lg-12 col-md-12 col-sm-12")
									 .removeClass("col-lg-8 col-md-8 col-sm-8");
			$("#amendement-container").removeClass("hidden");

		}else{
			$("#menu-room").removeClass("hidden");
			$("#coop-data-container").removeClass("col-lg-12 col-md-12 col-sm-12")
									 .addClass("col-lg-8 col-md-8 col-sm-8");
			$("#amendement-container").addClass("hidden");
		
		}
	},

	"getCoopData" : function(parentType, parentId, type, status, dataId, onSuccess, showLoading){
		mylog.log("getCoopData", parentType, parentId, type, status, dataId, onSuccess, showLoading)
		var url = moduleId+'/cooperation/getcoopdata';
		var params = {
			"parentType" : parentType,
			"parentId" : parentId,
			"type" : type,
			"status" : status,
			"dataId" : dataId,
			"json" : false
		};
		//mylog.log("showLoading ?", typeof showLoading, showLoading);
		
		if(typeof showLoading == "undefined" || showLoading == true){
			if(typeof dataId == "undefined" || dataId == null || type == "room"){
				$("#main-coop-container").html(
					"<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
			}
			else{
				$(uiCoop.getParentContainer() + "#coop-data-container").html(
					"<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
			}
		}

		ajaxPost("", url, params,
			function (data){
				if(typeof dataId == "undefined" || dataId == null || type == "room") {
					if(type == "menucoop")
						$("#menuCoop").html(data);
					else if(dataId == null && type == "room")
						$("#coop-room-list").html(data);
					else
						$("#main-coop-container").html(data);
					uiCoop.minimizeMenuRoom(false);
				}
				else{
					$(uiCoop.getParentContainer() + "#coop-data-container").html(data);
					uiCoop.minimizeMenuRoom(true);
				}

				uiCoop.initBtnLoadData();

				$(".btn-hide-data-room").off().click(function(){
					if($(this).hasClass("open")){
						$("#menu-room .sub-"+$(this).data("key")).addClass("hidden");
						$(this).removeClass("open");
						//$(this).find(".fa-caret-down").removeClass("fa-caret-down").addClass("fa-caret-right");
					}else{
						$("#menu-room .sub-"+$(this).data("key")).removeClass("hidden");
						$(this).addClass("open");
						//$(this).find(".fa-caret-right").removeClass("fa-caret-right").addClass("fa-caret-down");
					}
				});

				$(".tooltips").tooltip();

				if(typeof onSuccess == "function") onSuccess();
			}
		);
	},

	"getCoopDataPreview" : function(type, dataId, onSuccess, showLoading){
		mylog.log("getCoopDatagetCoopDataPreview", type, status, dataId, onSuccess, showLoading);
		var url = moduleId+'/cooperation/previewcoopdata';
		var params = {
			"type" : type,
			"dataId" : dataId,
			"json" : false
		};
		//mylog.log("showLoading ?", typeof showLoading, showLoading);
		
		//if(typeof showLoading == "undefined" || showLoading == true){
			
		//}

		$("#modal-preview-coop").removeClass("hidden");
		$("#modal-preview-coop").show(300);
		$("#modal-preview-coop").html("<i class='fa fa-spin fa-circle-o-notch padding-25 fa-2x letter-turq'></i>");

		ajaxPost("", url, params,
			function (data){

				$("#modal-preview-coop").html(data);

				$("#btn-refresh-"+type).off().click(function(){
					toastr.info(trad["processing"]);
					var idData = $(this).data("id-"+type);
					uiCoop.getCoopDataPreview(type, idData);
				});
				//uiCoop.initBtnLoadData();

				$(".tooltips").tooltip();
				$("#modal-preview-coop").modal("show");
				bindLBHLinks();

				if(typeof onSuccess == "function") onSuccess();
			},
			function(data){
				$("#modal-preview-coop").html("error");
			}
		);
	},

	"initSearchInMenuRoom" : function(){
		$(".inputSearchInMenuRoom").keyup(function(){
			var type = $(this).data('type-search');
			var searchVal = $(this).val();
			if(searchVal == "") {
				$(".submenucoop.sub-"+type).show();
				return;
			}

			$("#coop-container .submenucoop.sub-"+type).hide();
			mylog.log("searchVal", searchVal, "type", type);
			$.each($("#coop-container .submenucoop.sub-"+type), function(){
				mylog.log("this", this);
				
				var content = $(this).data("name-search");

				if(typeof content != "undefined"){
					var found = content.search(new RegExp(searchVal, "i"));
					mylog.log("content", content);
					if(found >= 0){
						var id = $(this).show();
					}
				}
			});
			
		});
	},

	"sendVote" : function(parentType, parentId, voteValue, idParentRoom, idAmdt){
		mylog.log("sendVote", parentType, parentId, voteValue, idParentRoom, idAmdt);
		
		var params = {
			"parentType" : parentType,
			"parentId" : parentId,
			"voteValue" : voteValue,
			"json" : false
		};
		if(typeof idAmdt != "undefined")
			params["idAmdt"] = idAmdt;

		var url = moduleId+'/cooperation/savevote';
		
		toastr.info(trad["processing save"]);
		ajaxPost("", url, params,
			function (proposalView){
				mylog.log("success save vote");
				uiCoop.getCoopData(contextData.type, contextData.id, "room", null, idParentRoom, 
					function(){
						toastr.success(trad["Your vote has been save with success"]);
						
						uiCoop.minimizeMenuRoom(true);
						$(uiCoop.getParentContainer() + "#coop-data-container").html(proposalView);
						if(parentType == "amendement")
							uiCoop.showAmendement(true);
					}, false);
			}
		);
	},

	"activateVote" : function(proposalId){
		
		var param = {
			block: "activeCoop",
			typeElement: "proposals",
			id: proposalId,
			
			status: "tovote",
			voteActivated: true,
			amendementActivated: false

		};

		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updateblock/",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
		    		uiCoop.getCoopData(contextData.type, contextData.id, "proposal", null, proposalId);
		    	}
		});

	},

	"saveAmendement" : function(proposalId, typeAmdt){
		var txtAmdt = $("#txtAmdt").val();
		if(txtAmdt.length < 10){
			toastr.error(trad.amendementTooShort);
			return;
		}

		var param = {
			block: "amendement",
			typeElement: "proposals",
			id: proposalId,			
			txtAmdt: txtAmdt,
			typeAmdt: typeAmdt
		};
		mylog.log("saveAmendement", param);
		toastr.info(trad["processing save"]);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updateblock/",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
					mylog.log("success updateblock", data);
		    		uiCoop.getCoopData(contextData.type, contextData.id, "proposal", null, proposalId, function(){
		    			uiCoop.showAmendement(true);
		    			toastr.success(trad["Your amendement has been save with success"]);
		    		}, false);
		    	}
		});

	},

	"changeStatus" : function(type, id, status, parentType, parentId){
		var param = {
			parentType : parentType,
			parentId : parentId,
			type: type,
			id: id,			
			name: "status",
			value: status
		};
		
		toastr.info(trad["processing save"]);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updatefield/",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
		    		type = (type == "proposals") ? "proposal" : type;
		    		type = (type == "actions") ? "action" : type;
		    		toastr.success(trad["processing ok"]);
					uiCoop.getCoopData(contextData.type, contextData.id, "room", null, idParentRoom, function(){
			    		uiCoop.getCoopData(parentType, parentId, type, null, id);
		    		});
		    	}
		});
	},

	"changeRoom" : function(dragType, dragId, idNewRoom, parentType, parentId){
		var param = {
			parentType : parentType,
			parentId : parentId,
			type: dragType,
			id: dragId,			
			name: "idParentRoom",
			value: idNewRoom
		};
		mylog.log("changeRoom", param);
		toastr.info(trad["processing save"]);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updatefield/",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
		    		uiCoop.getCoopData(contextData.type, contextData.id, "room", null, idNewRoom);
		    	}
		});
	},

	deleteByTypeAndId : function(typeDelete, idDelete){
		toastr.info(trad["processing save"]);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/delete/type/"+typeDelete+"/id/"+idDelete,
		        success: function(data){
		    		uiCoop.getCoopData(contextData.type, contextData.id, "room");
					uiCoop.startUI();
		    	}
		});	
	},

	deleteAmendement : function(numAm, idProposal){
		var param = {
			numAm : numAm,
			idProposal : idProposal,
			json : false
		};
		
		toastr.info(trad["processing delete"]);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/cooperation/deleteamendement/",
		        data: param,
		       	//dataType: "json",
		    	success: function(data){
		    		toastr.success(trad["processing delete ok"]);
					toastr.success(trad["processing ok"]);
					$(uiCoop.getParentContainer() + "#coop-data-container").html(data);
					uiCoop.minimizeMenuRoom(true);
					uiCoop.showAmendement(true);
		    	},
		    	error: function(data){
		    		mylog.log("error data ", data);
		    		toastr.error(trad["processing delete KO"]);
		    	}
		});
	},

	assignMe : function(idAction){
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/rooms/assignme",
		        data: { "id" : idAction },
		        success: function(data){
		    		if(data.result){
		    		  toastr.success(trad.thxForParticipation);
		              uiCoop.getCoopData(contextData.type, contextData.id, "action", null, idAction); 
	                  //alert("Tango a l'aide comment je reload stp action.php > function assignMe > l.181");
	                }
	                else 
	                  toastr.error(data.msg);
		    	}
		});	
	},

	getParentContainer : function(){
		var res = ($("#modal-preview-coop #coop-container").length == 0) ? "#modalCoop " : "#modal-preview-coop ";
		mylog.log("getParentContainer", res);
		return ($("#modal-preview-coop #coop-container").length == 0) ? "#modalCoop " : "#modal-preview-coop ";
	},

	initUIProposal : function(){
		
		$("#comments-container").html("<i class='fa fa-spin fa-refresh'></i> " + trad.loadingComments);
		
		$(".footer-comments").html("");
		getAjax("#comments-container",baseUrl+"/"+moduleId+"/comment/index/type/proposals/id/"+idParentProposal,
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
				$(".container-txtarea").hide();

				$(".btn-select-arg-comment").click(function(){
					var argval = $(this).data("argval");
					$(".container-txtarea").show();

					$(".textarea-new-comment").removeClass("bg-green-comment bg-white-comment bg-red-comment");
					var classe="";
					var pholder="Votre commentaire";
					if(argval == "up")   { classe="bg-green-comment"; pholder="Votre argument pour";   }
					if(argval == "down") { classe="bg-red-comment";   pholder="Votre argument contre"; }
					$(".textarea-new-comment").addClass(classe).attr("placeholder", pholder);
					$("#argval").val(argval);
				});

		},"html");

		$("#btn-close-proposal").click(function(){
			uiCoop.minimizeMenuRoom(false);
		});

		$("#modal-preview-coop #btn-close-proposal").off().click(function(){
			$("#modal-preview-coop").hide(300);
		});

		$(".btn-extend-proposal").click(function(){
			uiCoop.maximizeReader(true);
			$(".btn-minimize-proposal").removeClass("hidden");
			$(".btn-extend-proposal").addClass("hidden");
		});

		$(".btn-minimize-proposal").click(function(){
			uiCoop.maximizeReader(false);
			$(".btn-minimize-proposal").addClass("hidden");
			$(".btn-extend-proposal").removeClass("hidden");
		});

		$(".btn-show-amendement").click(function(){
			uiCoop.showAmendement(true);
		});

		$("#btn-hide-amendement").click(function(){
			uiCoop.showAmendement(false);
		});

		$(".btn-create-amendement").click(function(){
			uiCoop.showAmendement(true);
			if($("#form-amendement").hasClass("hidden"))
				$("#form-amendement").removeClass("hidden");
			else 
				$("#form-amendement").addClass("hidden");
		});

		$(".btn-modal-delete-am").click(function(){ //alert(".btn-modal-delete-am " + $(this).data("id-am"));
			var idAm = $(this).data("id-am");
			//$("#btn-delete-am").attr("data-id-am", idAm);


			$("#btn-delete-am").off().click(function(){
				//var idAm = $(this).data("id-am");
				uiCoop.deleteAmendement(idAm, idParentProposal);
			});
		});


		$(".btn-send-vote").click(function(){
			var voteValue = $(this).data('vote-value');
			mylog.log("send vote", voteValue),
			uiCoop.sendVote("proposal", idParentProposal, voteValue, idParentRoom);
		});

		$("#btn-activate-vote").click(function(){
			uiCoop.activateVote(idParentProposal);
		});

		$("#btn-refresh-proposal").click(function(){
			toastr.info(trad["processing"]);
			var idProposal = $(this).data("id-proposal");
			uiCoop.getCoopData(contextData.type, contextData.id, "proposal", null, idProposal, 
				function(){
					uiCoop.minimizeMenuRoom(true);
					uiCoop.showAmendement(false);
					toastr.success(trad["processing ok"]);
				}, false);
		});

		$("#btn-refresh-amendement").click(function(){
			toastr.info(trad["processing"]);
			var idProposal = $(this).data("id-proposal");
			uiCoop.getCoopData(contextData.type, contextData.id, "proposal", null, idProposal, 
				function(){
					uiCoop.minimizeMenuRoom(true);
					uiCoop.showAmendement(true);
					toastr.success(trad["processing ok"]);
				}, false);
		});

		$(".btn-option-status-proposal").click(function(){
			var idProposal = $(this).data("id-proposal");
			var status = $(this).data("status");
			mylog.log("update status proposals", idProposal, status, parentTypeElement, parentIdElement);
			uiCoop.changeStatus("proposals", idProposal, status, parentTypeElement, parentIdElement);
		});

		$("#btn-edit-proposal").click(function(){
			var idProposal = $(this).data("id-proposal");
			mylog.log("edit idProposal", idProposal);
			dyFObj.editElement('proposals', idProposal);
		});

		//$(".descriptionMarkdown").html(dataHelper.convertMardownToHtml($(".descriptionMarkdown").html()));
		if($("#modal-preview-coop #coop-container").length == 0){
			var addCoopHash=".view.coop.room." + idParentRoom + ".proposal." + idParentProposal;
			if(typeof hashUrlPage != "undefined")
				location.hash = hashUrlPage +addCoopHash;
			else if(notNull(contextData) && typeof contextData.slug != "undefined")
				location.hash = "#" + contextData.slug + addCoopHash;
			else
				location.hash = "#page.type." + parentTypeElement + ".id." + parentIdElement +addCoopHash; 
		}

		uiCoop.initBtnLoadDataPreview();

		if(msgController != ""){
			toastr.error(msgController);
		}
	},

	initUIAction : function(){

		$("#comments-container").html("<i class='fa fa-spin fa-refresh'></i> " + trad.loadingComments);
		
		$(".footer-comments").html("");

		getAjax("#comments-container",baseUrl+"/"+moduleId+"/comment/index/type/actions/id/"+idAction,
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
		},"html");


		$("#btn-close-action").click(function(){
			uiCoop.minimizeMenuRoom(false);
		});
		$("#modal-preview-coop #btn-close-action").off().click(function(){
			$("#modal-preview-coop").hide(300);
		});

		$(".btn-extend-action").click(function(){
			uiCoop.maximizeReader(true);
			$(".btn-minimize-action").removeClass("hidden");
			$(".btn-extend-action").addClass("hidden");
		});

		$(".btn-minimize-action").click(function(){
			uiCoop.maximizeReader(false);
			$(".btn-minimize-action").addClass("hidden");
			$(".btn-extend-action").removeClass("hidden");
		});

		$("#btn-refresh-action").click(function(){
			toastr.info(trad["processing"]);
			var idProposal = $(this).data("id-action");
			uiCoop.getCoopData(contextData.type, contextData.id, "action", null, idProposal, 
				function(){
					uiCoop.minimizeMenuRoom(true);
					uiCoop.showAmendement(false);
					toastr.success(trad["processing ok"]);
				}, false);
		});

		$(".btn-option-status-action").click(function(){
			var idAction = $(this).data("id-action");
			var status = $(this).data("status");
			mylog.log("update status actions", idAction, status, parentTypeElement, parentIdElement);
			uiCoop.changeStatus("actions", idAction, status, parentTypeElement, parentIdElement);
		});

		$("#btn-edit-action").click(function(){
			var idaction = $(this).data("id-action");
			mylog.log("edit idAction", idAction);
			dyFObj.editElement('actions', idAction);
		});

		$("#btn-validate-assign-me").off().click(function(){
			uiCoop.assignMe(idAction);
		});

		if($("#modal-preview-coop #coop-container").length == 0){
			var addCoopHash=".view.coop.room." + idParentRoom + ".action." + idAction;
			if(typeof hashUrlPage != "undefined")
				location.hash = hashUrlPage +addCoopHash;
			else if(notNull(contextData) && typeof contextData.slug != "undefined")
				location.hash = "#" + contextData.slug + addCoopHash;
			else
				location.hash = "#page.type." + parentTypeElement + ".id." + parentIdElement +addCoopHash;  
		}					  
	},

	initUIResolution : function(){
		$("#comments-container").html("<i class='fa fa-spin fa-refresh'></i> Chargement des commentaires");
		
		getAjax("#comments-container",baseUrl+"/"+moduleId+"/comment/index/type/resolutions/id/"+idParentResolution,
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
				$(".container-txtarea").hide();

				$(".btn-select-arg-comment").click(function(){
					var argval = $(this).data("argval");
					$(".container-txtarea").show();

					$(".textarea-new-comment").removeClass("bg-green-comment bg-red-comment");
					var classe="";
					var pholder="Votre commentaire";
					if(argval == "up")   { classe="bg-green-comment"; pholder="Votre argument pour";   }
					if(argval == "down") { classe="bg-red-comment";   pholder="Votre argument contre"; }
					$(".textarea-new-comment").addClass(classe).attr("placeholder", pholder);
					$("#argval").val(argval);
				});
		},"html");

		$("#btn-close-resolution").click(function(){
			uiCoop.minimizeMenuRoom(false);
		});
		$("#modal-preview-coop #btn-close-resolution").off().click(function(){
			$("#modal-preview-coop").hide(300);
		});

		$(".btn-extend-resolution").click(function(){
			uiCoop.maximizeReader(true);
			$(".btn-minimize-resolution").removeClass("hidden");
			$(".btn-extend-resolution").addClass("hidden");
		});
		$(".btn-minimize-resolution").click(function(){
			uiCoop.maximizeReader(false);
			$(".btn-minimize-resolution").addClass("hidden");
			$(".btn-extend-resolution").removeClass("hidden");
		});
		$(".btn-show-amendement").click(function(){
			uiCoop.showAmendement(true);
		});
		$("#btn-hide-amendement").click(function(){
			uiCoop.showAmendement(false);
		});
		$(".btn-create-amendement").click(function(){
			uiCoop.showAmendement(true);
			if($("#form-amendement").hasClass("hidden"))
				$("#form-amendement").removeClass("hidden");
			else 
				$("#form-amendement").addClass("hidden");
		});

		$("#btn-activate-vote").click(function(){
			uiCoop.activateVote(idParentResolution);
		});

		$("#btn-refresh-resolution").click(function(){
			toastr.info(trad["processing"]);
			var idresolution = $(this).data("id-resolution");
			uiCoop.getCoopData(null, null, "resolution", null, idresolution, 
				function(){
					uiCoop.minimizeMenuRoom(true);
					uiCoop.showAmendement(false);
					toastr.success(trad["processing ok"]);
				}, false);
		});

		$("#btn-refresh-amendement").click(function(){
			toastr.info(trad["processing"]);
			var idresolution = $(this).data("id-resolution");
			uiCoop.getCoopData(null, null, "resolution", null, idresolution, 
				function(){
					uiCoop.minimizeMenuRoom(true);
					uiCoop.showAmendement(true);
					toastr.success(trad["processing ok"]);
				}, false);
		});

		$(".btn-option-status-resolution").click(function(){
			var idresolution = $(this).data("id-resolution");
			var status = $(this).data("status");
			uiCoop.changeStatus("resolutions", idresolution, status, parentTypeElement, parentIdElement);
		});

		$("#btn-show-voteres").click(function(){
			if($(".podvote").hasClass("hidden")) $(".podvote").removeClass("hidden");
			else $(".podvote").addClass("hidden");
		});

		$("#btn-create-action").click(function(){
			useIdParentResolution = true;
			dyFObj.openForm('action');
		});

		if($("#modal-preview-coop #coop-container").length == 0){
			var addCoopHash=".view.coop.room." + idParentRoom + ".resolution." + idParentResolution;
			if(typeof hashUrlPage != "undefined")
				location.hash = hashUrlPage +addCoopHash;
			else if(notNull(contextData) && typeof contextData.slug != "undefined")
				location.hash = "#" + contextData.slug + addCoopHash;
			else
				location.hash = "#page.type." + parentTypeElement + ".id." + parentIdElement +addCoopHash;
		}


		if(msgController != ""){
			toastr.error(msgController);
		}
	}

}