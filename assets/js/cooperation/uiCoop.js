/* uiCoop is use for all function relative to UI for Cooperation Spaces (DDA) */
var uiCoop = {
	"startUI" : function(){
		$("#menu-left-container").hide();
		$("#div-reopen-menu-left-container").removeClass("hidden");
		$("#central-container").html("");

		KScrollTo("#div-reopen-menu-left-container");

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
		uiCoop.getCoopData(contextData.type, contextData.id, "proposal", "tovote");
	},

	"closeUI" : function(reloadStream){
		$("#menu-left-container").show();
		$("#div-reopen-menu-left-container").addClass("hidden");
		KScrollTo("#topPosKScroll");

		if(reloadStream != false) loadNewsStream(false);
	},

	"initBtnLoadData" : function(){
		$(".load-coop-data").off().click(function(){
			$(".load-coop-data").removeClass("active");
			$(this).addClass("active");
			
			var type = $(this).data("type");
			var status = $(this).data("status");
			var dataId = $(this).data("dataid");
			//console.log("LOAD COOP DATA", contextData.type, contextData.id, type, status, dataId);
			uiCoop.getCoopData(contextData.type, contextData.id, type, status, dataId);
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
			$("#amendement-container").removeClass("hidden");

		}else{
			$("#menu-room").removeClass("hidden");
			$("#coop-data-container").removeClass("col-lg-12 col-md-12 col-sm-12").addClass("col-lg-8 col-md-8 col-sm-8");
			$("#amendement-container").addClass("hidden");
		
		}
	},

	"getCoopData" : function(parentType, parentId, type, status, dataId, onSuccess, showLoading){
		var url = moduleId+'/cooperation/getcoopdata';
		var params = {
			"parentType" : parentType,
			"parentId" : parentId,
			"type" : type,
			"status" : status,
			"dataId" : dataId
		};

		if(typeof showLoading == "undefined" || showLoading == true){
			if(typeof dataId == "undefined" || dataId == null || type == "room")
					$("#central-container").html("<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
			else	$("#coop-data-container").html("<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
		}

		ajaxPost("", url, params,
			function (data){
				if(typeof dataId == "undefined" || dataId == null || type == "room") {
					if(dataId == null && type == "room")
						$("#coop-room-list").html(data);
					else
						$("#central-container").html(data);
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
						$(this).find(".fa-caret-down").removeClass("fa-caret-down").addClass("fa-caret-right");
					}else{
						$("#menu-room .sub-"+$(this).data("key")).removeClass("hidden");
						$(this).addClass("open");
						$(this).find(".fa-caret-right").removeClass("fa-caret-right").addClass("fa-caret-down");
					}
				});

				KScrollTo("#div-reopen-menu-left-container");
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

			$(".submenucoop.sub-"+type).hide();
			console.log("searchVal", searchVal, "type", type);
			$.each($(".submenucoop.sub-"+type), function(){
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

	"sendVote" : function(parentType, parentId, voteValue, idParentRoom){

		var params = {
			"parentType" : parentType,
			"parentId" : parentId,
			"voteValue" : voteValue
		};

		var url = moduleId+'/cooperation/savevote';
		console.log("uiCoop.sendVote", url, params);
		$("#coop-data-container").html("<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
		
		
		ajaxPost("", url, params,
			function (proposalView){
				console.log("success save vote");
				uiCoop.getCoopData(null, null, "room", null, idParentRoom, 
					function(){
						uiCoop.minimizeMenuRoom(true);
						$("#coop-data-container").html(proposalView);
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

	}

}