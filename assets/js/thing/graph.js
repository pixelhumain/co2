/**
*@author: Danzal
*
*/
function showAllGraph(){ $(".graphs").show(); }
function showGraph(figGraph){ $("#"+figGraph).show(); }
function hideAllGraph(){ $(".graphs").hide(); }
function hideGraph(figGraph){ $("#"+figGraph).hide(); }

function hideAllChart(sourcedb){ $(".chart_"+sourcedb).hide(); }
function showAllChart(sourcedb){ $(".chart_"+sourcedb).show(); }

function showHideChart(valuebtn){ 
	//var sourcedb = $(this).data("sourcedb") ; // amélioration pour un eselection direct 
	var sourceText="";
	var toShow="";
	switch (valuebtn) {
		case 0 : 
			if(!graphReady.dCOdb){
				sourceText="la base de données de Communecter";
				setGraphFromCoDB();
			}
			hideAllChart("dAPIsc");
			toShow="dCOdb";
			break;
		case 1:
			if(!graphReady.dAPIsc){
				sourceText="l'API de smartcitizen";
				setGraphFromAPIsmartcitizen();
			}
			hideAllChart("dCOdb");
			toShow="dAPIsc";
			break;
		/*case 2:
			//TODO : redrawBothChartGraph();
			showAllChart("dCOdb");
			showAllChart("dAPIsc");
			break;*/
	}
	if((!graphReady.dCOdb && valuebtn==0) || ( !graphReady.dAPIsc && valuebtn==1) ){
		$.blockUI({ message : '<span class="homestead"><i class="fa fa-spinner fa-circle-o-noch"></i> Chargement des données depuis '+sourceText+' en cours ... </span>' });
	}else{
		graphesRedraw(toShow);
	}
	showAllChart(toShow);
	$("#btnTempAndHum").click();
	$("#legend-graph").removeClass("hidden");

}

function setSVGForSensor(sensor,sensorKey) {

	var svgId = "sensor"+sensor;
	var figGraph = "graphe_"+sensor;
	var gId = svgId+"_g";

	var svgObj = d3.select("#"+figGraph)
			.append("svg").attr("width",svgwidth).attr("height",svgheight)
			.attr("viewBox","0 0 "+svgwidth+" "+svgheight)
			.attr("preserveAspectRatio","xMidYMid meet")
			.attr("class","col-sm-12 svggraph")
			.attr("id", svgId);

	var g = svgObj
			.append("g")
			.attr("transform", "translate(" + gmargin.left + "," + gmargin.top + ")")
			.attr("id", gId);

	var captionSensor =  d3.select("#"+figGraph)
			.append("figcaption")
			.text("Graph of sensor "+infoSensors[svgId].name+" ("+infoSensors[svgId].description+")");
	
	multiGraphe[sensorKey] = {svgid : svgId, 
			svg : svgObj,
			mesure : {description :  "", unit : "" }, 
			dimension : { width : +gwidth, 
				    height : +gheight, 
				    margin : gmargin },
			gid : gId , 
			domain : {Yn : null, Ym : null, Xn : vXn, Xm : vXm , xDomainInitialized : false},
			data : {},
			divgraphid : figGraph,
			urlReqApi : ""
	};
	
	mylog.log('multiGraphe['+sensorKey+'] : ');
	mylog.log(multiGraphe[sensorKey]);
}

function setLegend(deviceId,strkCol){

  var idIM = 'icnmin_'+deviceId; 
  var idTL = 'textdevice_'+deviceId;

  var legendILSC="<a href='https://smartcitizen.me/kits/"+deviceId+"' target='_blank'><i class='fa fa-minus' id='"+idIM+"' style='color:"+strkCol+";'></i> SCK device "+deviceId+"</a>";
 // var iconMinus = "<i class='fa fa-minus' id='"+idIM+"' style='color:"+strkCol+";'></i>";
  var dLegend = d3.select("#legend").append("div").attr("id","legend_"+deviceId).attr("class","col-sm-12 col-xs-12");
  dLegend.append("span").html(legendILSC);
}

function setStrokeColorAndLegendForDevice(device) {
	//var stId = "sCol_"+device;
	if(strockeColorArray[device] == null ){
		var strockeColor = "rgb("+Math.floor((Math.random()*220)+1)+","+Math.floor((Math.random()*220)+1)+","+Math.floor((Math.random()*220)+1)+")";
		strockeColorArray[device]=strockeColor;
		setLegend(device,strockeColor);
	}
	//return strockeColor;
}

function setGraphDomain(data, sensorkey,redraw){ 
	mylog.log("setGraphDomain");
if(redraw==true){
	multiGraphe[sensorkey].domain.Yn == null;
	multiGraphe[sensorkey].domain.Ym == null;
	min[sensorkey]=null;
	max[sensorkey]=null;
}

	for(id in data){
		var dDS =  data[id][sensorkey];
		//mylog.log("dDS : " );
		//mylog.log(dDS);
		if(dDS.length>=1){ 
			min[sensorkey]=d3.min( dDS, function(d){ return d.values;});	
			max[sensorkey]=d3.max( dDS, function(d){ return d.values;}); 	
			//mylog.log("- sensorkey :"+ sensorkey+ ": min : "+ min +" -- max: "+max);
			if (multiGraphe[sensorkey].domain.Yn == null || multiGraphe[sensorkey].domain.Yn > min[sensorkey]) {
				multiGraphe[sensorkey].domain.Yn = min[sensorkey];
				//mylog.log("multiGraphe["+sensorkey+"].domain.Yn : " + multiGraphe[sensorkey].domain.Yn);
			}
			if (multiGraphe[sensorkey].domain.Ym == null || multiGraphe[sensorkey].domain.Ym < max[sensorkey]) {
				multiGraphe[sensorkey].domain.Ym = max[sensorkey];
				//mylog.log("multiGraphe["+sensorkey+"].domain.Ym : "+multiGraphe[sensorkey].domain.Ym);
			}
		}
	}	
}


function setAxisXY(sensorKey){
	setAxisX(sensorKey);
	setAxisY(sensorKey);
}


function setAxisX(sensorKey){
	mylog.log(" --- setAxisX --- ");
	var gId = multiGraphe[sensorKey].gid;
	var g = d3.select("#"+gId);
	var xAxisId="xAxis"+multiGraphe[sensorKey].svgid; 
	//var height = multiGraphe[sensorKey].dimension.height;

	d3.select("#"+xAxisId).remove();    // TODO refaire la selection sur le graphe sensor

	g.append("g")
		.attr("id", xAxisId)
		.attr("class", "theAxis")
		.attr("transform", "translate(0," + gheight	 + ")")
		.call(d3.axisBottom(x))
		/// *
		//.append("text")
		//.attr("fill","#000")
		//.attr("x", gwidth)
		//.attr("text-anchor","end")
		//.text("time")
		;
}

function setAxisY(sensorKey){
	mylog.log(" --- setAxisY --- ");

	var gId = multiGraphe[sensorKey].gid;
	var g = d3.select("#"+gId);
	var yAxisId="yAxis"+ multiGraphe[sensorKey].svgid; 

	d3.select("#"+yAxisId).remove(); // TODO refaire la selection sur le graphe sensor

	var sensorkunit = sensorKey+" "+infoSensors[multiGraphe[sensorKey].svgid].unit ; // mettre dans le text

	g.append("g")
		.attr("id", yAxisId)
		.attr("class", "theAxis")
		.call(d3.axisLeft(y))
		.append("text")
		.attr("fill","#000")
		.attr("transform", "rotate(-90)")
		.attr("y", 8)
		.attr("dy", "0.71em")
		.attr("text-anchor","end")
		.text(sensorkunit)
		;

}

function tracer(da,device,sensorKey,strokeColor="blue",source, strokeWidth=1.5){
	mylog.log("da in tracer");
	mylog.log(da);
	if (da.length>0){
		mylog.log("----------- da.length > 0 : tracer ! -------- ");
		mylog.log("-- tracer - device : "+device+" sensor "+sensorKey);
		var g = d3.select("#"+multiGraphe[sensorKey].gid);

		var gpathId = source+"_gpId_"+device+multiGraphe[sensorKey].svgid; //ex : [source]_gpId_4162sensor17
		var graphClassSensor = "gcs_"+dataSensors[sensorKey].id+" "+source+" chart_"+source+" "+device +" chart_graph" ;
		g.append("path")
			.datum(da)
			.attr("fill", "none")
			.attr("class", graphClassSensor)
			.attr("id", gpathId)
			.attr("stroke", strokeColor)
			.attr("stroke-linejoin", "round")
			.attr("stroke-linecap", "round")
			.attr("stroke-width", strokeWidth)
			.attr("d", line);
		/*	TODO afficher text du device lors d'un survol avec la souris
		g.append("text")
			.datum(function(d){ return {value: d.values[d.values.length - 1]}; })
			.attr("transform", function(d) { return "translate(" + x(d.values) + "," + y(d.timestamps) + ")"; })
			.attr("x", 3)
			.attr("dy", "0.35em")
			.style("font", "10px sans-serif")
			.text(function(d) { return d.values; });*/
	}
	$.unblockUI();

}

function graphesRedraw(source){
	for(keySens in multiGraphe){
		grapheOneSensor(keySens,source, true);
	}
}

function grapheOneSensor(keySens,source, redraw) {
	$.unblockUI();
	var data = (source=="dCOdb")? dCOdb : dAPIsc;

	setGraphDomain(data, keySens, redraw);
//TODO Prendre un domaine 10% plus grand que les data en Y 5%top et 5 bottom
	y.domain([(multiGraphe[keySens].domain.Yn-1), (multiGraphe[keySens].domain.Ym+1)]); 
	setAxisY(keySens);

	if(multiGraphe[keySens].domain.xDomainInitialized==false || redraw==true){
		x.domain([multiGraphe[keySens].domain.Xn, multiGraphe[keySens].domain.Xm]);
		setAxisX(keySens);
		multiGraphe[keySens].domain.xDomainInitialized=true;
	}
	
	if(redraw==false){
		for (dId in data){
			tracer(data[dId][keySens], dId, keySens, strockeColorArray[dId],source);
		}
	}
	if(graphReady[source]==false){ 
		$(".svggraph").show();
		$("#legend-graph").show();
		graphReady[source]=true;
	}
}

function fillArrayWithObjectTimestampsAndValues(readings, deviceid, sensorkey){
	mylog.log("- fillArrayWithObjectTimestampsAndValues(readings, device, sensorkey) ");

	dAPIsc[deviceid][sensorkey] = readings.map(
		function(item){
			var ts = new Date();
			ts.setTime(Date.parse(item[0]));
			ts.setSeconds(0);
			item[1] = +item[1];
			return {timestamps : ts, values : item[1]};
		}
	);
	//multiGraphe[sensorkey].data[deviceid] = dAPIsc[deviceid][sensorkey];
}

function dataSensorAdaptorTimestampsAndValues(convertedDataRecord,device){
	mylog.log("--dataSensorAdaptorTimestampsAndValues--");
	console.time("dataSensorAdaptWithForEach");
	var dataCOdb={temp : [], hum : [], bat: [], panel : [], no2 : [], panel : [], co : [], noise : [], nets : [], light : []};
	convertedDataRecord.forEach( function(item){
		var ts = new Date();
		ts.setTime(Date.parse(item.timestamp));
		ts.setSeconds(0);

		item.temp =+item.temp;
		item.hum  =+item.hum;
		item.bat  =+item.bat;
		item.panel=+item.panel;
		item.co   =+item.co;
		item.no2  =+item.no2;
		item.light=+item.light;
		item.nets =+item.nets;
		item.noise=+item.noise;

		dataCOdb.temp.push({timestamps : ts, values : item.temp});
		dataCOdb.hum.push({timestamps : ts, values : item.hum});
		dataCOdb.bat.push({timestamps : ts, values : item.bat}); 
		dataCOdb.panel.push({timestamps : ts, values : item.panel});
		dataCOdb.no2.push({timestamps : ts, values : item.no2});
		dataCOdb.co.push({timestamps : ts, values : item.co});
		dataCOdb.noise.push({timestamps : ts, values : item.noise});
		dataCOdb.nets.push({timestamps : ts, values : item.nets});
		dataCOdb.light.push({timestamps : ts, values : item.light});

	}
	);
	console.timeEnd("dataSensorAdaptWithForEach");
	dCOdb[device]=dataCOdb;

	for (ks in multiGraphe){
		multiGraphe[ks].data[device]=dataCOdb[ks];
	}
	//return dataCOdb;
}
