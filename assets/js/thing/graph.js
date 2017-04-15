
// Fonctions pour cacher et montrer les graphe
 function showAllGraph(){ $(".graphs").show(); }

 function showGraph(figGraph){ $("#"+figGraph).show(); }

 function hideAllGraph(){ $(".graphs").hide(); }

 function hideGraph(figGraph){ $("#"+figGraph).hide(); }



//


function setSVGForSensor(sensor) {

  var svgId = "sensor"+sensor;
  var figGraph = "graphe_"+sensor;
  var gId = svgId+"_g";
  //console.log(svgId);

  var svgObj = d3.select("#"+figGraph)
      .append("svg").attr("width",svgwidth).attr("height",svgheight)
      .attr("viewBox","0 0 "+svgwidth+" "+svgheight)
      .attr("preserveAspectRatio","xMidYMid meet")
      .attr("class","col-sm-12 svggraph")
      .attr("id", svgId);   //.style("visibility","hidden");
  var g = svgObj.append("g").attr("transform", "translate(" + gmargin.left + "," + gmargin.top + ")").attr("id", gId);

  var captionSensor =  d3.select("#"+figGraph).append("figcaption").text("Graph of sensor "+infoSensors[svgId].name+" ("+infoSensors[svgId].description+")");

  var objGraph = {svgid : svgId, 
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

  //console.dir(objGraph);
   //Voir si on peu ce passer de la mise en tableau
   var indexObjGraphe = (multiGraphe.push(objGraph)) - 1 ;
   //console.log(indexObjGraphe);
  return indexObjGraphe; 
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
function updateTheDomain(xArray,yArray,indexGraphe){
  var yChanged = false;
  var xChanged = false;
  var Yn = multiGraphe[indexGraphe].domain.Yn;
  var Ym = multiGraphe[indexGraphe].domain.Ym;
  var Xn = multiGraphe[indexGraphe].domain.Xn;
  var Xm = multiGraphe[indexGraphe].domain.Xm;
 
  if( yArray[0] < Yn || Yn == 0) {
      multiGraphe[indexGraphe].domain.Yn = yArray[0]; yChanged = true; } //min
  if( yArray[1] > Ym || Yn == 0) { 
      multiGraphe[indexGraphe].domain.Ym = yArray[1]; yChanged = true; } //max
  if( yChanged == true || multiGraphe[indexGraphe].domain.domainInitialized == false ) { 
    y.domain([multiGraphe[indexGraphe].domain.Yn,multiGraphe[indexGraphe].domain.Ym]); }

  if(xArray[0].valueOf() < Xn.valueOf() ){ 
    multiGraphe[indexGraphe].domain.Xn = xArray[0]; xChanged = true;}
  if(xArray[1].valueOf() > Xm.valueOf() ){ 
    multiGraphe[indexGraphe].domain.Xm = xArray[1]; xChanged = true;}

  if( xChanged == true || multiGraphe[indexGraphe].domain.domainInitialized == false ) {
    x.domain([multiGraphe[indexGraphe].domain.Xn,multiGraphe[indexGraphe].domain.Xm]);
    multiGraphe[indexGraphe].domain.domainInitialized=true;
    }

}

function setAxisXY(indexGraphe,sensorkey){
  //console.log(indexGraphe);

  var gId = multiGraphe[indexGraphe].gid;
  var g = d3.select("#"+gId);
  var xAxisId="xAxis"+ multiGraphe[indexGraphe].svgid; 
  var yAxisId="yAxis"+ multiGraphe[indexGraphe].svgid; 
  var height = multiGraphe[indexGraphe].dimension.height;

  d3.select("#"+xAxisId).remove();    // TODO refaire la selection sur le graphe sensor
  d3.select("#"+yAxisId).remove();
    
    g.append("g")
      .attr("id", xAxisId)
      .attr("class", "theAxis")
      .attr("transform", "translate(0," + gheight + ")")
      .call(d3.axisBottom(x))
      /*
      .append("text")
      .attr("fill","#000")
      .attr("x", gwidth)
      .attr("text-anchor","end")
      .text("time")*/
      ;

    var sensorkunit = sensorkey+" "+infoSensors[multiGraphe[indexGraphe].svgid].unit ;
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
  if (strockeColorArray[stId] != null )
  {
    strockeColor = strockeColorArray[stId];
  } else
  {
      strockeColor = "rgb("+Math.floor((Math.random()*220)+1)+","+Math.floor((Math.random()*220)+1)+","+
      Math.floor((Math.random()*220)+1)+")";
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
/**
@function tracer
@strockeColor 
*/
function tracer(da,device,sensor,strokeColor="blue", indexGraphe,strokeWidth=1.5){
  
  var g = d3.select("#"+multiGraphe[indexGraphe].gid);

  var gpathId = "gpId_"+device+multiGraphe[indexGraphe].svgid; //ex : gpId_4162sensor17
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
/*
      g.append("text")
      .datum(function(d){ return {id: d.id, value: d.values[d.values.length - 1]}; })
      .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
      .attr("x", 3)
      .attr("dy", "0.35em")
      .style("font", "10px sans-serif")
      .text(function(d) { return d.id; });*/
}

function graphe(device,sensors,readings,svgG){

  var de = fillArrayWithObjectTimestampsAndValues(readings);
  
    var xMinMax = d3.extent(de, function(d){return d.timestamps;});
    var yMinMax = d3.extent(de, function(d){return d.values;});

    updateTheDomain(xMinMax,yMinMax,svgG);
    strkCol = setStrokeColorForDevice(device);

  tracer(de,device,sensors,strkCol,svgG);
  
}

function grapheCoDB(data,sensorkey,svgG){
  var dCOdb = dataSensorAdaptorTimestampsAndValues(data);
  //prendre le key pour la donné
  //multiGraphe[svgG].

for (var key in dCOdb){
 //var de = 
  tracer(de,device,sensors)
}
}

function dataSensorAdaptorTimestampsAndValues(convertedDataRecord){

  var dataCOdb={};
  dataCOdb.temp=[]; dataCOdb.hum=[]; dataCOdb.bat=[]; dataCOdb.panel=[]; dataCOdb.no2=[]; dataCOdb.co=[]; dataCOdb.noise=[]; dataCOdb.nets=[]; dataCOdb.light=[];
  
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
  return dataCOdb;
}



/*
function showSCKDeviceOnMap(country,cp){
  console.log("montrer sur la carte");
  //console.log(country+" "+cp);


  
  //console.log(contextDeviceMap);
  //mapThing = Sig.loadMap('mapCanvas');
  //Sig.showMapElements(Sig.map, contextDeviceMap); 
  showMap(true);
  //$('#ajax-modal').modal("hide");

}

  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
*/
