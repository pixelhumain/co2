<!DOCTYPE html>
<meta charset="utf-8">
<style>

.links line {
  stroke: #999;
  stroke-opacity: 0.6;
}

.nodes circle {
  stroke: black	;
  stroke-width: 1px;
}

.graph{
    float: right;
}
#graphtags{
    padding-top: 20px;
    background-color: #fff;
    width:20%;
    float: left;
    height:600px;
}
#graphtags a{
    color: #333;
    text-decoration: none;
}
#sectionList a{
    color: red;
    text-decoration: none;
}
#search{
    float:right;
    margin-right: 100px;
}
#title{
    background-color: #eee;
    height:80px;
    font-size: 2em;
    padding:5px;
}
</style>
<div  id="graphtags"  class="hide">
    <div id="sectionList"></div>
</div>

<svg id="graph" width="600" height="600"></svg>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script>

function runScript(e) {
    if (e.keyCode == 13) {
        s = document.getElementById("search").value;
        if (s.indexOf("#") == 0 )
            open("graph/search/tag/"+s.substring(1) );
        else if (s.indexOf(">") == 0 )
            open("graph/search/type/"+s.substring(1) ) ;
        else
            open("graph/search/q/"+s );
    }
}
function open (url) { 
    if(typeof $ != "undefined")
        smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/"+url);
    else 
        window.location.href = "/ph/co2/"+url;   
}
//create somewhere to put the force directed graph
var svg = d3.select("svg"),
    width = +svg.attr("width"),
    height = +svg.attr("height");
    
var radius = 15; 

console.log(<?php echo json_encode($data); ?>);
console.log(<?php echo json_encode(@$list); ?>);
var tags = <?php echo json_encode($tags); ?>;
var nodes_data = <?php echo json_encode($data); ?>;
var links_data = <?php echo json_encode($links); ?>;

//set up the simulation and add forces  
var simulation = d3.forceSimulation()
					.nodes(nodes_data);
                              
var link_force =  d3.forceLink(links_data)
                        .id( function(d) { return d.id; } )
                        .strength( function (d) { return d.strength; } );             
         
var charge_force = d3.forceManyBody()
    .strength(-120); 
    
var center_force = d3.forceCenter(width / 2, height / 2);  
                      
simulation
    .force("charge_force", charge_force)
    .force("center_force", center_force)
    .force("links",link_force)
 ;

//add tick instructions: 
simulation.on("tick", tickActions );

//add encompassing group for the zoom 
var g = svg.append("g")
    .attr("class", "everything");

//draw lines for the links 
var link = g.append("g")
      .attr("class", "links")
    .selectAll("line")
    .data(links_data)
    .enter().append("line")
      .attr("stroke-width", 1)
      .style("stroke", linkColour);        

//draw circles for the nodes 
var node = g.append("g")
        .attr("class", "nodes") 
        .selectAll("circle")
        .data(nodes_data)
        .enter()
        
        .append("circle")
        .attr("r", circleSize)
        //.attr("fill", "url(#img)")
        .attr("fill", circleColour )
        .on('click', selectNode);
/*
https://bl.ocks.org/mbostock/950642

var defs = g.append("g:defs");

defs.append("g:pattern")
.attr("id", "img")
.attr("patternUnits", "userSpaceOnUse")
.attr("width", "50")
.attr("height", "50")
.append("g:image")
.attr("xlink:href", "https://github.com/favicon.ico")
.attr("x", 0)
.attr("y", 0)
.attr("width", 50)
.attr("height", 50);
*/


var text = g.append("g")
        .attr("class", "texts")
        .selectAll("text")
        .data(nodes_data)
        .enter()
        .append('text')
        .text(function (node) { return node.label })
        .attr('font-size', 25)
        .attr('dx', 15)
        .attr('dy', 4)


//add drag capabilities  
var drag_handler = d3.drag()
	.on("start", drag_start)
	.on("drag", drag_drag)
	.on("end", drag_end);	
	
drag_handler(node);


//add zoom capabilities 
var zoom_handler = d3.zoom()
    .on("zoom", zoom_actions);

zoom_handler(svg);     

/** Functions **/

//Function to choose what color circle we have
//Let's return blue for males and red for females
function circleColour(d){
	
    if(d.type == "tag")
        return "steelblue";
    else if(d.type == "event" || d.type == "event")
        return "#FFA200";
    else if(d.type == "project" || d.type == "projects")
        return "purple";
    else if( d.type == "organization" || d.type == "organizations" )
        return "#93C020";
    else if(d.type == "citoyens" || d.type == "citoyen" )
        return "#FFC600";
    
    if(d.level ==0){
        return "black";
    }else if(d.level ==1){
		return "#c62f80";
	} else {
		return "#cccccc";
	}
}

function circleSize(d){
    r = 10; 
    if(d.level ==1 || d.level == 0)
        return 20;
    if(d.linkSize > 0)
        r += d.linkSize;
    if(r>30)
        r = 30;
    //console.log("radius", r, d.linkSize);
    return r;
}

//Function to choose the line colour and thickness 
//If the link type is "A" return green 
//If the link type is "E" return red 
function linkColour(d){
	if(d.type == "A"){
		return "green";
	} else {
		return "#333333";
	}
}

//Drag functions 
//d is the node 
function drag_start(d) {
 if (!d3.event.active) simulation.alphaTarget(0.3).restart();
    d.fx = d.x;
    d.fy = d.y;
}

//make sure you can't drag the circle outside the box
function drag_drag(d) {
  d.fx = d3.event.x;
  d.fy = d3.event.y;
}

function drag_end(d) {
  if (!d3.event.active) simulation.alphaTarget(0);
  d.fx = null;
  d.fy = null;
}

//Zoom functions 
function zoom_actions(){
    g.attr("transform", d3.event.transform)
}

function tickActions() {
    //update circle positions each tick of the simulation 
       node
        .attr("cx", function(d) { return d.x; })
        .attr("cy", function(d) { return d.y; });
        text
      .attr('x', function (d) { return d.x })
      .attr('y', function (d) { return d.y })
    //update link positions 
    link
        .attr("x1", function(d) { return d.source.x; })
        .attr("y1", function(d) { return d.source.y; })
        .attr("x2", function(d) { return d.target.x; })
        .attr("y2", function(d) { return d.target.y; });
} 

function selectNode(selectedNode) {
    console.log(selectedNode);
    types = ["citoyen", "organization", "project", "event"];
    if(selectedNode.level == 0)
        return;
    else if(selectedNode.id == "tags" )
        $("#graphtags").toggleClass("hide");
    else if(selectedNode.level == 1  ){
        $("#graphtags").toggleClass("hide");
        document.getElementById("sectionList").innerHTML = "<b>"+selectedNode.label+"</b><br/>";

        links_data.forEach(function (t) {
        if (t.source.id == selectedNode.id) 
            document.getElementById("sectionList").innerHTML += "<a href='/ph/co2/graph/d3/id/"+t.target.id+"/type/"+t.target.type+"'> "+t.target.label+"</a><br/>";
        })
        document.getElementById("sectionList").innerHTML += "<br/><br/>"
    }
    else if(selectedNode.id.length > 20 )
        open( "graph/d3/id/"+selectedNode.id+"/type/"+types[selectedNode.group-1] );
    else if (selectedNode.type == "tag")
        open( "graph/search/tag/"+selectedNode.label );
}

if(typeof $ != "undefined")
    $("#graph").css("width","80%")
else 
    document.getElementById("graph").style.width = "80%";

tags.forEach(function (t) {
    if (t != "") {
            document.getElementById("graphtags").innerHTML = document.getElementById("graphtags").innerHTML+ "<a href=\"javascript:open('graph/search/tag/"+t+"')\">#"+t+"</a><br/>";
    }
  })

//if(urlCtrl && location.hash != "<?php echo @$colink ?>")
  //  urlCtrl.loadByHash("<?php echo  @$colink ?>");
</script>