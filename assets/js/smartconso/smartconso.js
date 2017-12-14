var chartValues = {
	"down" : {
		"bg-color":"red",
		"percent":"30",
		"votant":"3",
		"voteValue":"down",
	},
	"up" : {
		"bg-color":"green",
		"percent":"50",
		"votant":"5",
		"voteValue":"up",
	},
	"uncomplet" : {
		"bg-color":"orange",
		"percent":"10",
		"votant":"1",
		"voteValue":"uncomplet",
	},
	"white" : {
		"bg-color":"white",
		"percent":"20",
		"votant":"2",
		"voteValue":"white",
	}
};

function smartChartInit(idCanvas, datas, chartType){ //alert("start loadchart");
		var voteValues = new Array();
		console.log("smart datas chart", datas);
		$.each(datas, function(key, val){
			console.log("val.percent", val);
			voteValues.push(val.percent);
		});

		var data = {
		    datasets: [{
		    	data: voteValues,
		    
			    // These labels appear in the legend and in the tooltips when hovering different arcs
			    backgroundColor: [
	                '#34a853',
	                '#E33551',
	                '#FFF',
	                '#FFA200',
	            ],
	            borderColor: [
	                '#34a853',
	                '#E33551',
	                '#aba9a9',
	                '#FFA200',
	            ],
	            borderWidth: 1
            }],
            labels: [
			        trad.Agree,
			        trad.Disagree,
			        trad.Abstain,
			        trad.Uncomplet
			    ],
			    
		};
		var ctx = $("#"+idCanvas).get(0).getContext("2d");
		var options;
		myPieChart = new Chart(ctx,{
		    type: chartType,
		    data: data,
			options: {
				legend: {
					display: false
				},
				animation: {
					duration: 300
				}
			},
		    //options: options
		});
	}