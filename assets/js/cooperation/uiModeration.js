/* uiCoop is use for all function relative to UI for Cooperation Spaces (DDA) */
var uiModeration = {

	"getNewsToModerate" : function(idNews, showLoading){
		console.log("getNewsToModerate", idNews)
		var url = moduleId+'/cooperation/getcoopdata';
		var params = {
			"parentType" : "news",
			"parentId" : idNews,
			"type" : "proposal",
			//"status" : status,
			//"dataId" : dataId,
			"json" : false
		};
		//console.log("showLoading ?", typeof showLoading, showLoading);
		
		if(typeof showLoading == "undefined" || showLoading == true){
				$("#coop-data-container").html(
					"<h2 class='margin-top-50 text-center'><i class='fa fa-refresh fa-spin'></i></h2>");
		}

		ajaxPost("", url, params,
			function (data){
				
				$("#coop-data-container").html(data);
				$(".tooltips").tooltip();

				//if(typeof onSuccess == "function") onSuccess();
			}
		);
	},

	initUIModeration : function(){
		
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


		$(".btn-send-vote").click(function(){
			var voteValue = $(this).data('vote-value');
			console.log("send vote", voteValue),
			uiModeration.sendVote("proposal", idParentProposal, voteValue, idParentRoom);
		});
	  
		$(".btn-howitworkmoderation").click(function(){
			if($("#howitworkmoderation").hasClass("hidden"))
				$("#howitworkmoderation").removeClass("hidden");
			else
				$("#howitworkmoderation").addClass("hidden");
		});

		if(msgController != ""){
			toastr.error(msgController);
		}
	},


	"sendVote" : function(parentType, parentId, voteValue, idParentRoom, idAmdt){
		console.log("uiModeration.sendVote", parentType, parentId, voteValue, idParentRoom, idAmdt);
		
		var params = {
			"parentType" : parentType,
			"parentId" : parentId,
			"voteValue" : voteValue,
			"json" : false,
			"moderation" : true
		};
		if(typeof idAmdt != "undefined")
			params["idAmdt"] = idAmdt;

		var url = moduleId+'/cooperation/savevote';
		
		toastr.info(trad["processing save"]);
		ajaxPost("", url, params,
			function (proposalView){
				console.log("success save vote");
				toastr.success(trad["Your vote has been save with success"]);
				$("#coop-data-container").html(proposalView);
				/*uiCoop.getCoopData(null, null, "room", null, idParentRoom, 
					function(){
						toastr.success(trad["Your vote has been save with success"]);
						
						uiCoop.minimizeMenuRoom(true);
						$("#coop-data-container").html(proposalView);
						if(parentType == "amendement")
							uiCoop.showAmendement(true);
					}, false);*/
			}
		);
	},
};