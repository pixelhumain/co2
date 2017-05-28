//Author Danzal
function showAllGraph(){ $(".graphs").show(); }
function showGraph(figGraph){ $("#"+figGraph).show(); }
function hideAllGraph(){ $(".graphs").hide(); }
function hideGraph(figGraph){ $("#"+figGraph).hide(); }

function mytester(data){
	mylog.log("mytester");
	mylog.log("data in mytester : ");
	mylog.log(data);
	return "return From mytester";
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
		.attr("id", svgId);   //.style("visibility","hidden");
	var g = svgObj.append("g").attr("transform", "translate(" + gmargin.left + "," + gmargin.top + ")").attr("id", gId);

	var captionSensor =  d3.select("#"+figGraph).append("figcaption").text("Graph of sensor "+infoSensors[svgId].name+" ("+infoSensors[svgId].description+")");

	multiGraphe[sensorKey] = {svgid : svgId, 
			svg : svgObj,
			mesure : {description :  "", unit : "" }, 
			dimension : { width : +gwidth, 
				    height : +gheight, 
				    margin : gmargin },
			gid : gId , 
			domain : {Yn : vYn, Ym : vYm, Xn : vXn, Xm : vXm , domainInitialized : false},
			devices : [],
			divgraphid : figGraph,
			urlReqApi : ""
	};

	mylog.log('multiGraphe['+sensorKey+'] : ');
	mylog.log(multiGraphe[sensorKey]);
/* ancien code 
	var objGraph =  {svgid : svgId, 
			svg : svgObj,
			mesure : {description :  "", unit : "" }, 
			dimension : { width : +gwidth, 
				    height : +gheight, 
				    margin : gmargin },
			gid : gId , 
			domain : {Yn : vYn, Ym : vYm, Xn : vXn, Xm : vXm , domainInitialized : false},
			devices : [],
			divgraphid : figGraph,
			urlReqApi : ""
	};
*/	
//console.dir(objGraph);
}

function setLegend(deviceId,strkCol){

//console.log(strockeColorArray);

  var idIM='icnmin_'+deviceId; 
  var idTL= 'textdevice_'+deviceId;
 // var stId = "sCol_"+deviceId;
  //console.log(deviceId);
  //console.log(idIM);
  //console.log(stId);
  var legendILSC="<a href='https://smartcitizen.me/kits/"+deviceId+"' target='_blank'><i class='fa fa-minus' id='"+idIM+"' style='color:"+strkCol+";'></i> SCK device "+deviceId+"</a>";

 // var iconMinus = "<i class='fa fa-minus' id='"+idIM+"' style='color:"+strkCol+";'></i>";

  var dLegend = d3.select("#legend").append("div").attr("id","legend_"+deviceId).attr("class","col-sm-12 col-xs-12");
  dLegend.append("span").html(legendILSC);


}

/*function showLegendGraph( ){


}*/

//TODO Prendre un domaine 10% plus grand que les data en Y 5%top et 5 bottom
function updateTheDomain(xArray,yArray,sensorKey){
  var yChanged = false;
  var xChanged = false;
  var Yn = multiGraphe[sensorKey].domain.Yn;
  var Ym = multiGraphe[sensorKey].domain.Ym;
  var Xn = multiGraphe[sensorKey].domain.Xn;
  var Xm = multiGraphe[sensorKey].domain.Xm;
 
  if( yArray[0] < Yn || Yn == 0) {
      multiGraphe[sensorKey].domain.Yn = yArray[0]; yChanged = true; } //min
  if( yArray[1] > Ym || Yn == 0) { 
      multiGraphe[sensorKey].domain.Ym = yArray[1]; yChanged = true; } //max
  if( yChanged == true || multiGraphe[sensorKey].domain.domainInitialized == false ) { 
    y.domain([multiGraphe[sensorKey].domain.Yn,multiGraphe[sensorKey].domain.Ym]); }

  if(xArray[0].valueOf() < Xn.valueOf() ){ 
    multiGraphe[sensorKey].domain.Xn = xArray[0]; xChanged = true;}
  if(xArray[1].valueOf() > Xm.valueOf() ){ 
    multiGraphe[sensorKey].domain.Xm = xArray[1]; xChanged = true;}

  if( xChanged == true || multiGraphe[sensorKey].domain.domainInitialized == false ) {
    x.domain([multiGraphe[sensorKey].domain.Xn,multiGraphe[sensorKey].domain.Xm]);
    multiGraphe[sensorKey].domain.domainInitialized=true;
  }

}

function setAxisXY(sensorKey,sensorkey){
  //console.log(sensorKey);

  var gId = multiGraphe[sensorKey].gid;
  var g = d3.select("#"+gId);
  var xAxisId="xAxis"+ multiGraphe[sensorKey].svgid; 
  var yAxisId="yAxis"+ multiGraphe[sensorKey].svgid; 
  var height = multiGraphe[sensorKey].dimension.height;

  d3.select("#"+xAxisId).remove();    // TODO refaire la selection sur le graphe sensor
  d3.select("#"+yAxisId).remove();
    
    g.append("g")
      .attr("id", xAxisId)
      .attr("class", "theAxis")
      .attr("transform", "translate(0," + gheight + ")")
      .call(d3.axisBottom(x))
      /// *
//      .append("text")
//      .attr("fill","#000")
//      .attr("x", gwidth)
//      .attr("text-anchor","end")
//      .text("time")
      ;

    var sensorkunit = sensorkey+" "+infoSensors[multiGraphe[sensorKey].svgid].unit ;
    //console.log(sensorkunit);
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
//TODO : réglé le pb de color utiliser find dans array 
function setStrokeColorForDevice(device) {

	var stId = "sCol_"+device;
	if (strockeColorArray[stId] != null ) {
		var strockeColor = strockeColorArray[stId];
	}else{
		var strockeColor = "rgb("+Math.floor((Math.random()*220)+1)+","+Math.floor((Math.random()*220)+1)+","+Math.floor((Math.random()*220)+1)+")";
		strockeColorArray[stId]=strockeColor;
		setLegend(device,strockeColor);
	}
	return strockeColor;
}

function fillArrayWithObjectTimestampsAndValues(readings){
	var d=[];
	readings.forEach(
	function(item){
		var ts = new Date();
		ts.setTime(Date.parse(item[0]));
		//console.log("ts : ");
		//console.log(ts);
		ts.setSeconds(0);
		item[1] = +item[1];
		d.push({timestamps : ts, values : item[1]});
	}
	);
	return d;
}
///**
//@function tracer
//@strockeColor 
//* /
function tracer(da,device,sensor,strokeColor="blue", sensorKey,strokeWidth=1.5){
  
  var g = d3.select("#"+multiGraphe[sensorKey].gid);

  var gpathId = "gpId_"+device+multiGraphe[sensorKey].svgid; //ex : gpId_4162sensor17
  var graphClassSensor = "gcs_"+sensor;
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
//
//      g.append("text")
  //    .datum(function(d){ return {id: d.id, value: d.values[d.values.length - 1]}; })
    //  .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
      //.attr("x", 3)
//      .attr("dy", "0.35em")
  //    .style("font", "10px sans-serif")
    //  .text(function(d) { return d.id; });
}

function graphe(device,sensors,readings,svgG){

	var de = fillArrayWithObjectTimestampsAndValues(readings);

	var xMinMax = d3.extent(de, function(d){return d.timestamps;});
	var yMinMax = d3.extent(de, function(d){return d.values;});

	updateTheDomain(xMinMax,yMinMax,svgG);
	var strkCol = setStrokeColorForDevice(device);

	tracer(de,device,sensors,strkCol,svgG);
  
}

function grapheCoDB(data,device,boardId) {
	mylog.log(" ---------- grapheCoDB ------------");
	var dCOdb = dataSensorAdaptorTimestampsAndValues(data);
	//var dCOdbF = dataSensorAdaptorTimestampsAndValuesWithForLoop(data);

	for(keyS in dCOdb){
		dataSensors[keyS][device]=dCOdb[keyS];
			//dataSensors[keyS].id;


	} 
		
	//y.domain([ 
	//	d3.min(dataSensors, function()


	//mylog.log(dCOdb);
	var strkCol = setStrokeColorForDevice(device);
	/*
	for (var key in dCOdb){
	/*
		tracer(dCOdb[key],device,sckSensorIds[0][key],strkCol,i);
	*/	
	/*
		var i=0;
		for (var key2 in multiGraphe ) {
			i++;
			if(multiGraphe[key2].svgid=="sensor"+sckSensorIds[key] ){
				var xMinMax = d3.extent(dCOdb[key], function(d){return d.timestamps;});
				var yMinMax = d3.extent(dCOdb[key], function(d){return d.values;});
				mylog.log("xMinMax : " +xMinMax + "; yMinMax :"+ yMinMax);
				updateTheDomain(xMinMax,yMinMax,key2);

				tracer(dCOdb[key], device, sckSensorIds[key].id, strkCol,key2);
				break;
			}
			
		}
	}*/
}

function dataSensorAdaptorTimestampsAndValuesWithForLoop(convertedDataRecord){
console.time("dataSensorAdaptWithForLoop");
	var dataCOdb={temp : [], hum : [], bat: [], panel : [], no2 : [], panel : [], co : [], noise : [], nets : [], light : []};

	for(var dataC in convertedDataRecord){
		var ts = new Date();
		ts.setTime(Date.parse(convertedDataRecord[dataC].timestamp));
		ts.setSeconds(0);

		convertedDataRecord[dataC].temp =+convertedDataRecord[dataC].temp;
		convertedDataRecord[dataC].hum  =+convertedDataRecord[dataC].hum;
		convertedDataRecord[dataC].bat  =+convertedDataRecord[dataC].bat;
		convertedDataRecord[dataC].panel=+convertedDataRecord[dataC].panel;
		convertedDataRecord[dataC].co   =+convertedDataRecord[dataC].co;
		convertedDataRecord[dataC].no2  =+convertedDataRecord[dataC].no2;
		convertedDataRecord[dataC].light=+convertedDataRecord[dataC].light;
		convertedDataRecord[dataC].nets =+convertedDataRecord[dataC].nets;
		convertedDataRecord[dataC].noise=+convertedDataRecord[dataC].noise;

		dataCOdb.temp.push({timestamps : ts, values : convertedDataRecord[dataC].temp});
		dataCOdb.hum.push({timestamps : ts, values : convertedDataRecord[dataC].hum});
		dataCOdb.bat.push({timestamps : ts, values : convertedDataRecord[dataC].bat}); 
		dataCOdb.panel.push({timestamps : ts, values : convertedDataRecord[dataC].panel});
		dataCOdb.no2.push({timestamps : ts, values : convertedDataRecord[dataC].no2});
		dataCOdb.co.push({timestamps : ts, values : convertedDataRecord[dataC].co});
		dataCOdb.noise.push({timestamps : ts, values : convertedDataRecord[dataC].noise});
		dataCOdb.nets.push({timestamps : ts, values : convertedDataRecord[dataC].nets});
		dataCOdb.light.push({timestamps : ts, values : convertedDataRecord[dataC].light});
	}
	console.timeEnd("dataSensorAdaptWithForLoop");
	return dataCOdb;
}

function dataSensorAdaptorTimestampsAndValues(convertedDataRecord){
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
	return dataCOdb;
}

