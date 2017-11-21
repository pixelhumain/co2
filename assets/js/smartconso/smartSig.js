var smartSig = {

	initSmartInterface : function(){
		$(".btn-smart").click(function(){
			var dataKey = $(this).data("key");
			smartSig.loadData(dataKey);
		});
	},

	showData : function(dataKey){

	},

	loadData : function(dataKey){

		var data = {
			"name" : "", 
			"sourceKey" : dataKey,
			"searchType" : ["poi"], 
			"searchBy" : "ALL",
			"indexMin" : 0, 
			"indexMax" : 200,
			//"locality" : "",   
		};

		console.log("smartSig.loadData", data);

		$.ajax({
	      type: "POST",
	          url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
	          data: data,
	          dataType: "json",
	          error: function (data){
	             mylog.log("error"); mylog.dir(data);          
	          },
	          success: function(data){
	          	console.log("success", data);
	          	Sig.showMapElements(Sig.map, data, "recycle", "SmartData");
	          },
	    });
	}

};

