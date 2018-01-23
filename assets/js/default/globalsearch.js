  

/* GLOBAL SEARCH JS */
function showDropDownGS(show){
  if(typeof show == "undefined") show = true;

  if(show){
    if($(".dropdown-result-global-search").css("display") == "none"){
      $(".dropdown-result-global-search").css("maxHeight", "0px");
      $(".dropdown-result-global-search").show();
      $(".dropdown-result-global-search").animate({"maxHeight" : "70%"}, 300);
    }
  }else{
    if(!loadingDataGS){
      $(".dropdown-result-global-search").animate({"maxHeight" : "0%"}, 300);
      $(".dropdown-result-global-search").hide(300);
    }
  }
}

var searchTypeGS = [ "persons", "organizations", "projects", "events", "poi", "cities" ];
var allSearchTypeGS = [ "persons", "organizations", "projects", "events", "poi", "cities" ];

var loadingDataGS = false;
var indexStepGS = 20;
var currentIndexMinGS = 0;
var currentIndexMaxGS = indexStepGS;
var scrollEndGS = false;
var totalDataGS = 0;
var mapElementsGS = new Array(); 

function startGlobalSearch(indexMin, indexMax, input){
    mylog.log("startGlobalSearch", indexMin, indexMax, indexStepGS, loadingDataGS);

    setTimeout(function(){ loadingDataGS = false; }, 10000);
    if(notNull(input))
      var search = $(input).val();
    else
      var search = $('#second-search-bar').val();
    //if(search == "") search = $('#input-global-search-xs').val();
    if(loadingDataGS || search.length<3) return;
    
    mylog.log("loadingDataGS true");
    loadingDataGS = true;
    
    if(typeof indexMin == "undefined") indexMin = 0;
    if(typeof indexMax == "undefined") indexMax = indexStepGS;

    currentIndexMinGS = indexMin;
    currentIndexMaxGS = indexMax;

    if(indexMin == 0) {
      totalDataGS = 0;
      mapElementsGS = new Array(); 
    }
    else{ mylog.log("scrollEndGS ? ", scrollEndGS); if(scrollEndGS) return; }
    
    autoCompleteSearchGS(search, indexMin, indexMax);
}


function autoCompleteSearchGS(search, indexMin, indexMax){
    mylog.log("autoCompleteSearchGS",search);

    var data = {"name" : search, "locality" : "", "searchType" : searchTypeGS, "searchBy" : "ALL",
                "indexMin" : indexMin, "indexMax" : indexMax  };

    showDropDownGS(true);

    if(indexMin > 0)
    $("#btnShowMoreResultGS").html("<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...");
    else
    $(".dropdown-result-global-search").html(
      "<h5 class='text-dark center padding-15'><i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...</h5>");
      
    showIsLoading(true);

    if(search.indexOf("co.") === 0 )
    {
      searchT = search.split(".");
      if( searchT[1] && typeof co[ searchT[1] ] == "function" )
      {
        co[ searchT[1] ](search);
        return;
      } else {
        co.mands();
      }
    }

    $.ajax({
      type: "POST",
          url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
          data: data,
          dataType: "json",
          error: function (data){
             mylog.log("error"); mylog.dir(data);          
          },
          success: function(data){
            if(!data){ toastr.error(data.content); }
            else
            {
              mylog.log("DATA GS");
              mylog.dir(data);

              var countData = 0;
              $.each(data, function(i, v) { if(v.length!=0){ countData++; } });
              
              totalDataGS += countData;
            
              str = "";
              var city, postalCode = "";
              
              if(totalDataGS == 0)      totalDataGSMSG = "<i class='fa fa-ban'></i> "+trad.noresult;
              else if(totalDataGS == 1) totalDataGSMSG = totalDataGS + " "+trad.result;   
              else if(totalDataGS > 1)  totalDataGSMSG = totalDataGS + " "+trad.results;   

              if(totalDataGS > 0){
                str += '<div class="text-left col-xs-12" id="footerDropdownGS" style="">';
                str += "<label class='text-dark margin-top-5'><i class='fa fa-angle-down'></i> " + totalDataGSMSG + "</label>";
                str += '<a href="#search" class="btn btn-default btn-sm pull-right lbh" id="btnShowMoreResultGS">'+
                          '<i class="fa fa-angle-right"></i> <i class="fa fa-search"></i> '+trad.extendedsearch+
                        '</a>';
                str += '</div>';
                str += "<hr style='margin: 0px; float:left; width:100%;'/>"
              }

              //parcours la liste des résultats de la recherche
              $.each(data, function(i, o) {
                console.log(o);
                mylog.log("globalsearch res : ", o);
                  var typeIco = i;
                  var ico = "fa-"+typeObj["default"].icon;
                  var color = mapColorIconTop["default"];

                  mapElementsGS.push(o);
                  if(typeof( typeObj[o.type] ) == "undefined")
                    itemType="poi";
                    typeIco = o.type;
                  //if(directory.dirLog) mylog.warn("itemType",itemType,"typeIco",typeIco);
                  if(typeof o.typeOrga != "undefined")
                    typeIco = o.typeOrga;

                  var obj = (dyFInputs.get(typeIco)) ? dyFInputs.get(typeIco) : typeObj["default"] ;
                  ico =  "fa-"+obj.icon;
                  color = obj.color;
                  //typeIco = o.type;
                  //ico = ("undefined" != typeof typeObj[typeIco]) ? "fa-"+typeObj[typeIco].icon : "fa-"+typeObj["default"].icon;
                  //color = ("undefined" != typeof mapColorIconTop[typeIco]) ? mapColorIconTop[typeIco] : mapColorIconTop["default"];
                  
                  htmlIco ="<i class='fa "+ ico +" fa-2x bg-"+color+"'></i>";
                  if("undefined" != typeof o.profilThumbImageUrl && o.profilThumbImageUrl != ""){
                    var htmlIco= "<img width='80' height='80' alt='' class='img-circle bg-"+color+"' src='"+baseUrl+o.profilThumbImageUrl+"'/>"
                  }

                  city="";

                  var postalCode = o.cp
                  if (o.address != null) {
                    city = o.address.addressLocality;
                    postalCode = o.cp ? o.cp : o.address.postalCode ? o.address.postalCode : "";
                  }
                  
                  
                  var id = getObjectId(o);
                  var insee = o.insee ? o.insee : "";
                  type = o.type;
                  if(type=="citoyens") type = "person";
                  //var url = "javascript:"; //baseUrl+'/'+moduleId+ "/default/simple#" + o.type + ".detail.id." + id;
                  var url = (notEmpty(o.type) && notEmpty(id)) ? 
                            '#page.type.'+o.type+'.id.' + id : "";

                  //var onclick = 'urlCtrl.loadByHash("#' + type + '.detail.id.' + id + '");';
                  var onclickCp = "";
                  var target = " target='_blank'";
                  var dataId = "";
                  if(type == "city"){
                    dataId = o.name; //.replace("'", "\'");
                  }

                  
                  var tags = "";
                  if(typeof o.tags != "undefined" && o.tags != null){
                    $.each(o.tags, function(key, value){
                      if(value != "")
                      tags +=   "<a href='javascript:' class='badge bg-red btn-tag'>#" + value + "</a>";
                    });
                  }

                  var name = typeof o.name != "undefined" ? o.name : "";
                  var postalCode = (typeof o.address != "undefined" &&
                                    o.address != null &&
                                    typeof o.address.postalCode != "undefined") ? o.address.postalCode : "";
                  
                  if(postalCode == "") postalCode = typeof o.cp != "undefined" ? o.cp : "";
                  var cityName = (typeof o.address != "undefined" &&
                                  o.address != null &&
                                  typeof o.address.addressLocality != "undefined") ? o.address.addressLocality : "";
                  
                  var fullLocality = postalCode + " " + cityName+" ("+o.country+")";
                  if(fullLocality == " Addresse non renseignée" || fullLocality == "" || fullLocality == " ") 
                      fullLocality = "<i class='fa fa-ban'></i>";
                  mylog.log("fullLocality", fullLocality);
                    
                  var description = (typeof o.shortDescription != "undefined" &&
                            o.shortDescription != null) ? o.shortDescription : "";
                  if(description == "") description = (typeof o.description != "undefined" &&
                                     o.description != null) ? o.description : "";
           
                  var startDate = (typeof o.startDate != "undefined") ? "Du "+dateToStr(o.startDate, "fr", true, true) : null;
                  var endDate   = (typeof o.endDate   != "undefined") ? "Au "+dateToStr(o.endDate, "fr", true, true)   : null;

                  var followers = (typeof o.links != "undefined" && o.links != null && typeof o.links.followers != "undefined") ?
                                    o.links.followers : 0;
                  var nbFollower = 0;
                  if(followers !== 0)                 
                  $.each(followers, function(key, value){
                    nbFollower++;
                  });

                    target = "";

                  
                if(type != "city"){ 
                    str += "<a href='"+url+"' class='lbh col-md-12 col-sm-12 col-xs-12 no-padding searchEntity'>";
                      str += "<div class='col-md-2 col-sm-2 col-xs-2 no-padding entityCenter'>";
                      str +=   htmlIco;
                      str += "</div>";
                      str += "<div class='col-md-10 col-sm-10 col-xs-10 entityRight'>";

                      str += "<div class='entityName text-dark'>" + name + "</div>";
                        
                        str += '<div data-id="' + dataId + '"' + "  class='entityLocality'>"+
                                  "<i class='fa fa-home'></i> " + fullLocality;

                        if(nbFollower >= 1)
                        str +=    " <span class='pull-right'><i class='fa fa-chain margin-left-10'></i> " + nbFollower + " follower</span>";
                       
                        str += '</div>';
                        
                      str += "</div>";

                    str += "</a>";

                  }else{
                        var citykey = o.country + "_" + o.insee + "-" + o.cp;

                var valuesScopes = {
                  city : o._id.$id,
                  cityName : o.name,
                  cp : o.cp,
                  level1 : o.level1,
                  level1Name : o.level1Name
                }

                if( notEmpty( o.level4 ) ){
                  valuesScopes.level4 = o.level4 ;
                  valuesScopes.level4Name = o.level4Name ;
                }
                if( notEmpty( o.level3 ) ){
                  valuesScopes.level3 = o.level3 ;
                  valuesScopes.level3Name = o.level3Name ;
                }
                if( notEmpty( o.level2 ) ){
                  valuesScopes.level2 = o.level2 ;
                  valuesScopes.level2Name = o.level2Name ;
                }
                typeSearchCity="city";
                levelSearchCity="city";
                if(typeof o.countCpByInsee != "undefined" && o.countCpByInsee > 0 ){
                  typeSearchCity="cp";
                  levelSearchCity="cp";
                }
                /*str += "<button class='btn btn-sm btn-danger communecterSearch item-globalscope-checker' "+
                                "data-scope-value='" + o._id.$id  + "' " + 
                                "data-scope-name='" + o.name + "' " +
                                "data-scope-level='city' " +
                                "data-scope-type='city' " +
                                "data-scope-values='"+JSON.stringify(valuesScopes)+"' " +
                                "data-scope-notsearch='"+true+"' " +
                                ">"+
                                    "<i class='fa fa-angle-right'></i> " + trad.testAOtherCommunexion + 
                                "</button>";*/
                        str += "<a href='javascript:' class='col-md-12 col-sm-12 col-xs-12 no-padding communecterSearch item-globalscope-checker searchEntity' ";
                        str +=    "data-scope-value='" + o._id.$id  + "' " + 
                                "data-scope-name='" + o.name + "' " +
                                "data-scope-level='"+levelSearchCity+"' " +
                                "data-scope-type='"+typeSearchCity+"' " +
                                "data-scope-values='"+JSON.stringify(valuesScopes)+"' " +
                                "data-scope-notsearch='"+true+"' " ;
                        str += ">";
                       /* str += "<div class='col-md-2 col-sm-2 col-xs-2 no-padding entityCenter'>";
                        str +=   htmlIco;
                        str += "</div>";*/
                        str += "<div class='col-md-12 col-sm-12 col-xs-12 entityRight'>";

                        str += "<div class='entityName text-dark'>" + name + "</div>";
                          
                          str += '<div data-id="' + dataId + '"' + "  class='entityLocality'>"+
                                    "<i class='fa fa-home'></i> " + fullLocality;
                          str += '</div>';
                          
                        str += "</div>";

                      str += "</a>";
                  }
                              
              }); //end each

              //ajout du footer   
              str += '<div class="text-center" id="footerDropdownGS">';
              str += "<label class='text-dark'>" + totalDataGSMSG + "</label><br/>";
              str += '<a href="#search" class="btn btn-default btn-sm lbh" id="btnShowMoreResultGS">'+
                        '<i class="fa fa-angle-right"></i> <i class="fa fa-search"></i> '+trad.extendedsearch+
                      '</a>';
              str += '</div>';
            
              //on ajoute le texte dans le html
              $(".dropdown-result-global-search").html(str);
              //on scroll pour coller le haut de l'arbre au menuTop
              $(".dropdown-result-global-search").scrollTop(0);
              //on affiche la dropdown
              showDropDownGS(true);
              bindCommunexionScopeEvents();
              $(".start-new-communexion").click(function(){
                  $("#main-search-bar, #second-search-bar, #input-search-map").val("");
                  // setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"), "city",
                  //                  $(this).data("insee-communexion"), $(this).data("name-communexion"), $(this).data("cp-communexion"),
                  //                   $(this).data("region-communexion"), $(this).data("dep-communexion"), $(this).data("country-communexion") ) ;
                  itenGlobalScopeChecker($(this));
                  urlCtrl.loadByHash("#search")
              });

              bindLBHLinks();

            //signal que le chargement est terminé
            mylog.log("loadingDataGS false");
            loadingDataGS = false;
          }

          //si le nombre de résultat obtenu est inférieur au indexStep => tous les éléments ont été chargé et affiché
          if(indexMax - countData > indexMin){
            $("#btnShowMoreResultGS").remove(); 
            scrollEndGS = true;
          }else{
            scrollEndGS = false;
          }

          if(isMapEnd){
            //affiche les éléments sur la carte
            showDropDownGS(false);
            Sig.showMapElements(Sig.map, mapElementsGS, "globe", "Recherche globale");
          }

          //$("#footerDropdownGS").append("<br><a class='btn btn-default' href='javascript:' onclick='urlCtrl.loadByHash("+'"#default.directory"'+")'><i class='fa fa-plus'></i></a>");
        }
    });

                    
  }