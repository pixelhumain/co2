/* uiCoop is use for all function relative to UI for Cooperation Spaces (DDA) */
var uiCoop = {
	"startUI" : function(){
		//$("#menu-left-container").hide();
		//$("#div-reopen-menu-left-container").removeClass("hidden");
		$("#main-coop-container").html("");

		//KScrollTo("#div-reopen-menu-left-container");

		toogleNotif(false);

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
		uiCoop.getCoopData(contextData.type, contextData.id, "proposal");
	},

	"closeUI" : function(reloadStream){
		//$("#menu-left-container").show();
		//$("#div-reopen-menu-left-container").addClass("hidden");
		//KScrollTo("#topPosKScroll");

		//if(reloadStream != false) loadNewsStream(false);
	},

	"initBtnLoadData" : function(){
		//alert('initBtnLoadData');
		$(".load-coop-data").off().click(function(){
			$(".load-coop-data").removeClass("active");
			$(this).addClass("active");

			var type = $(this).data("type");
			var status = $(this).data("status");
			var dataId = $(this).data("dataid");
			//console.log("LOAD COOP DATA", contextData.type, contextData.id, type, status, dataId);
			uiCoop.getCoopData(contextData.type, contextData.id, type, status, dataId);
		});
		//uiCoop.initDragAndDrop();
	},
	"initDragAndDrop" : function(){ console.log('initDragAndDrop');
		$('.draggable').draggable({
		    revert : true, // sera renvoyé à sa place s'il n'est pas déposé dans #drop
		    appendTo: 'body',
		    helper: 'clone',
		    zIndex: 10000,
    		scroll: false,
    		start : function(){
    			uiCoop.dragId = $(this).data("dataid");
    			uiCoop.dragType = $(this).data("type");
    			console.log("start drag", $(this).data("dataid"), "coopId", uiCoop.dragId, "coopType", uiCoop.dragType);
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
		    	//console.log("activate", roomid);
		    	$(this).parent().addClass("bg-lightblue draggin");
		    },
		    deactivate : function( event, ui ){
		    	var roomid = $(this).data("dataid");
		    	//console.log("deactivate", roomid);
		    	$(this).removeClass("text-white").parent().removeClass("bg-lightblue draggin bg-turq");
		    },
		    over : function( event, ui ){
		    	var roomid = $(this).data("dataid");
		    	console.log("over", roomid);
		    	$(this).addClass("text-white").parent().addClass("bg-turq");
		    	$(this).parent().removeClass("bg-lightblue");
		    },
		    out : function( event, ui ){
		    	var roomid = $(this).data("dataid");
		    	console.log("out", roomid);
		    	$(this).removeClass("text-white").parent().removeClass("bg-turq");
		    	$(this).parent().addClass("bg-lightblue");
		    }
		});
	},

	"minimizeMenuRoom" : function(min){ console.log("minimizeMenuRoom", min);
		if(min)	{
			$("#menu-room").addClass("min col-lg-4 col-md-4 col-sm-4").removeClass("col-lg-12 col-md-12 col-sm-12");
			$("#coop-data-container").addClass("col-lg-8 col-md-8 col-sm-8").removeClass("hidden");
		}
		else{
			uiCoop.maximizeReader(false);
			$("#menu-room").removeClass("min col-lg-4 col-md-4 col-sm-4").addClass("col-lg-12 col-md-12 col-sm-12");
			$("#coop-data-container").removeClass("min col-lg-8 col-md-8 col-sm-8").addClass("hidden");
		}
	},

	"maximizeReader" : function(max){ console.log("maximizeReader", max);
		if(max)	{
			$("#menu-room").addClass("hidden");
			$("#coop-data-container").removeClass("col-lg-8 col-md-8 col-sm-8").addClass("col-lg-12 col-md-12 col-sm-12");
		}
		else{
			$("#menu-room").removeClass("hidden");
			$("#coop-data-container").removeClass("col-lg-12 col-md-12 col-sm-12").addClass("col-lg-8 col-md-8 col-sm-8");
		}
	},

	"showAmendement" : function(show){
		if(show){
			$("#menu-room").addClass("hidden");
			$("#coop-data-container").addClass("col-lg-12 col-md-12 col-sm-12").removeClass("col-lg-8 col-md-8 col-sm-8");
			$("#amendement-container").removeClass("hidden");

		}else{
			$("#menu-room").removeClass("hidden");
			$("#coop-data-container").removeClass("col-lg-12 col-md-12 col-sm-12").addClass("col-lg-8 col-md-8 col-sm-8");
			$("#amendement-container").addClass("hidden");
		
		}
	},

	"getCoopData" : function(parentType, parentId, type, status, dataId, onSuccess, showLoading){
		console.log("getCoopData", parentType, parentId, type, status, dataId, onSuccess, showLoading)
		var url = moduleId+'/cooperation/getcoopdata';
		var params = {
			"parentType" : parentType,
			"parentId" : parentId,
			"type" : type,
			"status" : status,
			"dataId" : dataId
		};
		console.log("showLoading ?", typeof showLoading, showLoading);
		
		//KScrollTo("#div-reopen-menu-left-container");

		if(typeof showLoading == "undefined" || showLoading == true){
			if(typeof dataId == "undefined" || dataId == null || type == "room"){
				$("#main-coop-container").html("<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
			}
			else{
				$("#coop-data-container").html("<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
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
					$("#coop-data-container").html(data);
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

	"initSearchInMenuRoom" : function(){
		$(".inputSearchInMenuRoom").keyup(function(){
			var type = $(this).data('type-search');
			var searchVal = $(this).val();
			if(searchVal == "") {
				$(".submenucoop.sub-"+type).show();
				return;
			}

			$("#coop-container .submenucoop.sub-"+type).hide();
			console.log("searchVal", searchVal, "type", type);
			$.each($("#coop-container .submenucoop.sub-"+type), function(){
				console.log("this", this);
				
				var content = $(this).data("name-search");

				if(typeof content != "undefined"){
					var found = content.search(new RegExp(searchVal, "i"));
					console.log("content", content);
					if(found >= 0){
						var id = $(this).show();
					}
				}
			});
			
		});
	},

	"sendVote" : function(parentType, parentId, voteValue, idParentRoom, idAmdt){
		console.log("sendVote", parentType, parentId, voteValue, idParentRoom, idAmdt);
		
		var params = {
			"parentType" : parentType,
			"parentId" : parentId,
			"voteValue" : voteValue
		};
		if(typeof idAmdt != "undefined")
			params["idAmdt"] = idAmdt;

		var url = moduleId+'/cooperation/savevote';
		//$("#coop-data-container").html("<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
		
		
		toastr.info(trad["processing save"]);
		ajaxPost("", url, params,
			function (proposalView){
				console.log("success save vote");
				uiCoop.getCoopData(null, null, "room", null, idParentRoom, 
					function(){
						toastr.success(trad["Your vote has been save with success"]);
						
						uiCoop.minimizeMenuRoom(true);
						$("#coop-data-container").html(proposalView);
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
		    		uiCoop.getCoopData(null, null, "proposal", null, proposalId);
		    	}
		});

	},

	"saveAmendement" : function(proposalId, typeAmdt){
		var txtAmdt = $("#txtAmdt").val();
		if(txtAmdt.length < 10){
			toastr.error("Votre amendement est trop court ! Minimum : 10 caractères");
			return;
		}

		var param = {
			block: "amendement",
			typeElement: "proposals",
			id: proposalId,			
			txtAmdt: txtAmdt,
			typeAmdt: typeAmdt
		};
		console.log("saveAmendement", param);
		toastr.info(trad["processing save"]);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updateblock/",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
					console.log("success updateblock", data);
		    		uiCoop.getCoopData(null, null, "proposal", null, proposalId, function(){
		    			//uiCoop.minimizeMenuRoom(true);
		    			uiCoop.showAmendement(true);
		    			toastr.success(trad["Your amendement has been save with success"]);
						//$("#coop-data-container").html(proposalView);
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
					uiCoop.getCoopData(null, null, "room", null, idParentRoom, function(){
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
		console.log("changeRoom", param);
		toastr.info(trad["processing save"]);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updatefield/",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
		    		uiCoop.getCoopData(null, null, "room", null, idNewRoom);
		    	}
		});
	},

	"deleteByTypeAndId" : function(type, id){
		var param = {
			type: type,
			id: id
		};
		toastr.info(trad["processing save"]);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/delete/type/"+type+"/id/"+id,
		        //data: param,
		       	//dataType: "json",
		    	success: function(data){
		    		uiCoop.getCoopData(contextData.type, contextData.id, "room");
					uiCoop.startUI();
		    	}
		});	
	}

}