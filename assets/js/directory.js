directory.storePanelHtml = function(params){
	if(directory.dirLog) 
		mylog.log("----------- storePanelHtml",params,params.name);

	str = "";  
	str += "<div class='col-lg-3 col-md-4 col-sm-4 col-xs-12 searchEntityContainer "+params.type+params.id+" "+params.type+" "+params.elTagsList+" '>";
	str +=    "<div class='searchEntity' id='entity"+params.id+"'>";

	if(typeof userId != "undefined" && params.creator == userId)
		params.hash=params.hash+'.view.show';
	str += "<a href='"+params.hash+"' class='container-img-profil lbhp add2fav'  data-modalshow='"+params.id+"'>" + 
	params.imgProfil + 
	"</a>";

	str += "<div class='padding-10 informations'>";

	str += "<div class='entityRight no-padding'>";

	if(typeof params.name != "undefined" && params.name != "")
		str += "<div class='entityName'>" + params.name + "</div>";

	if(typeof params.description != "undefined" && params.description != "")
		str += "<div class='entityDescription'>" + params.description + "</div>";
	str += "</div>";
	str += "<div class='entityRight no-padding price'>";
	str += "<hr class='margin-bottom-10 margin-top-10'>";
	var devise = typeof params.devise != "undefined" ? params.devise : "€";
	if(typeof params.price != "undefined" && params.price != "")
		str += "<div class='entityPrice col-md-6'><span class='price-trunc'>"+ Math.trunc(params.price) + "</span> " + devise + "</div>";

	str += "<a  href='"+params.hash+"' class='showMore btn bg-orange text-white lbhp'  data-modalshow='"+params.id+"'>"+
	tradTerla.show+" +"+ 
	"</a>";  

	str += "</div>";
	str += "</div>";
	str += "</div>";

	str += "</div>";
	return str;
};