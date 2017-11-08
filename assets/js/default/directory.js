
var indexStepInit = 30;
var indexStep = indexStepInit;
var currentIndexMin = 0;
var currentIndexMax = indexStep;
var scrollEnd = false;
var totalData = 0;

var timeout = null;
var searchType = '';
var searchSType = '';
//alert("d.js");

var translate = {"organizations":"Organisations",
                 "projects":"Projets",
                 "events":"Événements",
                 "people":"Citoyens",
                 "followers":"Ils nous suivent"};

function startSearch(indexMin, indexMax, callBack){
    console.log("startSearch directory.js", typeof callBack, callBack, loadingData);
    if(loadingData) return;
    loadingData = true;
    showIsLoading(true);
    
    //mylog.log("loadingData true");
    indexStep = indexStepInit;

    mylog.log("startSearch", indexMin, indexMax, indexStep, searchType);

	  var name = ($('#main-search-bar').length>0) ? $('#main-search-bar').val() : "";
    
    //if(name == "" && searchType.indexOf("cities") > -1) return;  

    if(typeof indexMin == "undefined") indexMin = 0;
    if(typeof indexMax == "undefined") indexMax = indexStep;

    currentIndexMin = indexMin;
    currentIndexMax = indexMax;

    if(indexMin == 0 && indexMax == indexStep) {
      totalData = 0;
      mapElements = new Array(); 
    }
    else{ if(scrollEnd) return; }
    
    if(name.length>=3 || name.length == 0)
    {
      var locality = "";
      if( communexionActivated ){
  	    if(typeof(cityInseeCommunexion) != "undefined")
        {
    			if(levelCommunexion == 1) locality = cpCommunexion;
    			if(levelCommunexion == 2) locality = inseeCommunexion;
    		}else{
    			if(levelCommunexion == 1) locality = inseeCommunexion;
    			if(levelCommunexion == 2) locality = cpCommunexion;
    		}
        //if(levelCommunexion == 3) locality = cpCommunexion.substr(0, 2);
        if(levelCommunexion == 3) locality = inseeCommunexion;
        if(levelCommunexion == 4) locality = inseeCommunexion;
        if(levelCommunexion == 5) locality = "";

        mylog.log("Locality : ", locality);
      } 
      console.log("locality",locality);
      autoCompleteSearch(name, locality, indexMin, indexMax, callBack);
    }  
}


function addSearchType(type){
  $.each(allSearchType, function(key, val){
    removeSearchType(val);
  });

  var index = searchType.indexOf(type);
  if (index == -1) {
    searchType.push(type);
    //$(".search_"+type).removeClass("active"); //fa-circle-o");
    $(".search_"+type).addClass("active"); //fa-check-circle-o");
  }
}
function initTypeSearch(typeInit){
    //var defaultType = $("#main-btn-start-search").data("type");

    if(typeInit == "all") {
        searchType = ["persons", "organizations", "projects", "poi", "cities"];
        //if( $('#main-search-bar').val() != "" ) searchType.push("cities");

        indexStepInit = 30;
    }else if(typeInit == "allSig"){
      searchType = ["persons", "organizations", "projects", "poi", "cities"];
      indexStepInit = 50;
    }
    else{
        searchType = [ typeInit ];
        indexStepInit = 100;
    }
}


function removeSearchType(type){
  var index = searchType.indexOf(type);
  if (index > -1 && searchType.length > 1) {
    searchType.splice(index, 1);
    $(".search_"+type).removeClass("active"); //fa-check-circle-o");
    //$(".search_"+type).addClass("fa-circle-o");
  }
}

var loadingData = false;
var mapElements = new Array(); 


function autoCompleteSearch(name, locality, indexMin, indexMax, callBack){
  console.log("START -------- autoCompleteSearch! ", typeof callBack, callBack);
	var searchLocality = getLocalityForSearch();
    
    var data = {
      "name" : name, 
      "locality" : searchLocality,//locality, 
      "searchType" : searchType, 
      "searchTag" : ($('#searchTags').length ) ? $('#searchTags').val().split(',') : [] ,
      "indexMin" : indexMin, 
      "indexMax" : indexMax
    };

    console.log("DATE ***", searchType[0], STARTDATE, ENDDATE)
    if(searchType[0] == "events"){
      if(typeof STARTDATE != "undefined" && typeof ENDDATE != "undefined"){
        console.log("integrate AGENDA_WINDOW");
        data.startDate = STARTDATE;
        data.endDate = ENDDATE;
        console.log("DATE **", "data", data) ;
      }
    }
    
    if($("#priceMin").val()!="") data.priceMin = $("#priceMin").val();
    if($("#priceMax").val()!="") data.priceMax = $("#priceMax").val();
    if($("#devise").val()!="") data.devise = $("#devise").val();

    if(searchSType != "")
      data.searchSType = searchSType;

    searchSType = "";

    loadingData = true;
    
    str = "<i class='fa fa-circle-o-notch fa-spin'></i>";
    $(".btn-start-search").html(str);
    $(".btn-start-search").addClass("bg-azure");
    $(".btn-start-search").removeClass("bg-dark");
    
    if(indexMin > 0)
      $("#btnShowMoreResult").html("<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ...");
    else
      $("#dropdown_search").html("<div class='col-md-12 col-sm-12 text-center search-loader text-dark'>"+
                                    "<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyresearching+" ..."+
                                  "</div>");
    
    if(isMapEnd)
      $("#map-loading-data").html("<i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyloading);
         
    mylog.dir(data);
    //alert();
    $.ajax({
        type: "POST",
        url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
        data: data,
        dataType: "json",
        error: function (data){
             mylog.log(">>> error autocomplete search"); 
             mylog.dir(data);   
             $("#dropdown_search").html(data.responseText);  
             //signal que le chargement est terminé
            loadingData = false;     
        },
        success: function(data){ 
            mylog.log(">>> success autocomplete search", data); //mylog.dir(data);
            if(!data){ 
              toastr.error(data.content); 
            } 
            else 
            {
              var countData = 0;
            	$.each(data, function(i, v) { 
                if(v.length!=0){ 
                  countData++; 
                } 
              });
              
              totalData += countData;
            
              str = "";
              var city, postalCode = "";

              //parcours la liste des résultats de la recherche
              //mylog.dir(data);
              resultsStr=trad.result;
              if(totalData > 1)
                resultsStr=trad.results;
              str += '<div class="col-md-12 text-left" id="">';
              str += "<h4 style='margin-bottom:10px; margin-left:15px;' class='text-dark pull-left'>"+
                        "<i class='fa fa-angle-down'></i> " + totalData + " "+resultsStr+" ";
              str += "<small class='resultTypes'>";
              if(typeof headerParams != "undefined"){
                $.each( searchType, function(key, val){
                  mylog.log(">>> each autocomplete search",val);
                  var params = headerParams[val];
                  str += "<span class='text-"+params.color+"'>"+
                            "<i class='fa fa-"+params.icon+" hidden-sm hidden-md hidden-lg padding-5'></i> <span class='hidden-xs'>"+params.name+"</span>"+
                          "</span> ";
                });//console.log("myMultiTags", myMultiTags);
                
                $.each(myMultiTags, function(key, val){
                  var params = headerParams[val];
                  str += "<span class='text-dark hidden-xs pull-right'>"+
                            "#"+key+
                          "</span> ";
                });

                if( Object.keys(myMultiTags).length > 0 )
                  str += "<a href='javascript:;' class='pull-right' onClick='resetMyTags()'><i class='fa fa-times-circle text-red '></i></a> ";
                
              }
              str += "</small>";
              str += "</h4>";
              str += "<hr style='float:left; width:100%;'/>";
              str += "</div>";
              
              str += directory.showResultsDirectoryHtml(data);
              
              if(str == "") { 
	              $.unblockUI();
                showMap(false);
                  $(".btn-start-search").html("<i class='fa fa-refresh'></i>"); 
                  if(indexMin == 0){
                    //ajout du footer   
                    var msg = "<i class='fa fa-ban'></i> "+trad.noresult;    
                    if(name == "" && locality == "") msg = "<h3 class='text-dark padding-20'><i class='fa fa-keyboard-o'></i> Préciser votre recherche pour plus de résultats ...</h3>"; 
                    str += '<div class="pull-left col-md-12 text-left" id="footerDropdown" style="width:100%;">';
                    str += "<hr style='float:left; width:100%;'/><h3 style='margin-bottom:10px; margin-left:15px;' class='text-dark'>"+msg+"</h3><br/>";
                    str += "</div>";
                    $("#dropdown_search").html(str);
                    $("#searchBarText").focus();
                  }
                     
              }
              else
              {       
                //ajout du footer      	
                str += '<div class="pull-left col-md-12 text-center" id="footerDropdown" style="width:100%;">';
                str += "<hr style='float:left; width:100%;'/><h3 style='margin-bottom:10px; margin-left:15px;' class='text-dark'>" + totalData + " "+resultsStr+"</h3>";
                //str += '<span class="" id="">Complétez votre recherche pour un résultat plus précis</span></center><br/>';
                //str += '<button class="btn btn-default" id="btnShowMoreResult"><i class="fa fa-angle-down"></i> Afficher plus de résultat</div></center>';
                str += "</div>";

                //si on n'est pas sur une première recherche (chargement de la suite des résultat)
                if(indexMin > 0){
                    //on supprime l'ancien bouton "afficher plus de résultat"
                    $("#btnShowMoreResult").remove();
                    //on supprimer le footer (avec nb résultats)
                    $("#footerDropdown").remove();

                    //on calcul la valeur du nouveau scrollTop
                    var heightContainer = $(".main-container")[0].scrollHeight - 180;
                    //on affiche le résultat à l'écran
                    $("#dropdown_search").append(str);
                    //on scroll pour afficher le premier résultat de la dernière recherche
                    $(".my-main-container").animate({"scrollTop" : heightContainer}, 1700);
                    //$(".my-main-container").scrollTop(heightContainer);

                //si on est sur une première recherche
                }else{
                    //on affiche le résultat à l'écran
                    $("#dropdown_search").html(str);

                    if(typeof myMultiTags != "undefined"){
                    $.each(myMultiTags, function(key, value){ //mylog.log("binding bold "+key);
                      $("[data-tag-value='"+key+"'].btn-tag").addClass("bold");
                    });
                    }
                  
                }
                //remet l'icon "loupe" du bouton search
                $(".btn-start-search").html("<i class='fa fa-refresh'></i>");
                //active les link lbh
                bindLBHLinks();
                bindCommunexionScopeEvents()

                // $(".start-new-communexion").click(function(){
                //     mylog.log("start-new-communexion directory.js");
                //     $("#main-search-bar, #second-search-bar, #input-search-map").val("");
                //     setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"), "city",
                //                      $(this).data("insee-communexion"), $(this).data("name-communexion"), $(this).data("cp-communexion"),
                //                       $(this).data("region-communexion"), $(this).data("dep-communexion"), $(this).data("country-communexion") ) ;
                    
                //     //only on homepage
                //     if($("#communexionNameHome").length){
                //     	$("#communexionNameHome").html('Vous êtes <span class="text-dark">communecté à <span class="text-red">'+$(this).data("name-communexion")+'</span></span>');
                //     	$("#liveNowCoName").html("<span class='text-red'> à "+$(this).data("name-communexion")+"</span>");
                //       $("#main-search-bar").val("");
                //     	$(".info_co, .input_co").addClass("hidden");
                //       $("#change_co").removeClass("hidden");
						          // $("#dropdown_search").html("");
                //     }else{
                //       startSearch(0, indexStepInit, searchCallback);
                //     }
                // });


                $.unblockUI();
                $("#map-loading-data").html("");
                
                //initialise les boutons pour garder une entité dans Mon répertoire (boutons links)
                initBtnLink();

    	        } //end else (str=="")

              //signal que le chargement est terminé
              loadingData = false;

              //quand la recherche est terminé, on remet la couleur normal du bouton search
    	        $(".btn-start-search").removeClass("bg-azure");
              $("#btn-my-co").removeClass("hidden");
        	  }

            //si le nombre de résultat obtenu est inférieur au indexStep => tous les éléments ont été chargé et affiché
            //mylog.log("SHOW MORE ?", countData, indexStep);
            if(countData < indexStep){
              $("#btnShowMoreResult").remove(); 
              scrollEnd = true;
            }else{
              scrollEnd = false;
            }

            if( typeof page != "undefined" && page == "agenda" && typeof showResultInCalendar != "undefined")
              showResultInCalendar(data);


            if(mapElements.length==0) mapElements = data;
            else $.extend(mapElements, data);
            
            //affiche les éléments sur la carte
            Sig.showMapElements(Sig.map, mapElements, "search", "Résultats de votre recherche");
                        
            if(typeof callBack == "function")
              callBack();
        }
    });


  }

  function calculateAgendaWindow(nbMonth){

      //console.log("calculateAgendaWindow", nbMonth);
      if(typeof STARTDATE == "undefined") return;
      //console.log("calculateAgendaWindow ok");

      var today = new Date();

      if(nbMonth != 0)
          today.setMonth(today.getMonth() + nbMonth);

      startWinDATE = today;   
      //console.log("DATE **", "today", today) ;
      STARTDATE = today.setDate(1);

      //console.log("DATE **", "STARTDATE", STARTDATE) ;
      ENDDATE = today.setMonth(today.getMonth() + 1);

      STARTDATE = Math.floor(STARTDATE / 1000);
      ENDDATE = Math.floor(ENDDATE / 1000);

     // console.log("DATE **", "startWinDATE", startWinDATE, "STARTDATE", STARTDATE, "ENDDATE", ENDDATE) ;

  }

  function initBtnAdmin(){ 
    $(".adminToolBar").each(function(){
      if($(this).children('button').length == 0){
        $(this).parent().find(".adminIconDirectory").remove();
        $(this).remove();
      }
    });
    $(".adminIconDirectory, .container-img-profil").mouseenter(function(){
      $(this).parent().find(".adminToolBar").show();
    });
    $(".adminToolBar").mouseleave(function(){
      $(this).hide();
    });
    mylog.log("initBtnAdmin")
    $(".disconnectConnection").click(function(){
      var $this=$(this); 
      disconnectTo(contextData.type,
        contextData.id, 
        $this.data("id"), $this.data("type"), $this.data("connection"),function() {
          $this.parents().eq($this.data("parent-hide")).fadeOut();   
        });
    });
    $(".acceptAsBtn").off().on("click",function () {
      validateConnection(contextData.type, contextData.id, $(this).data("id"), $(this).data("type"), $(this).data("connect-validation"), 
        function() {
          toastr.success(trad["validationwellregistred"]);
          urlCtrl.loadByHash(location.hash);
        }
      );
    });
  }

  function initBtnLink(){ mylog.log("initBtnLink");
      
    $('.tooltips').tooltip();
    $(".dirStar").each(function(i,el){
      collection.applyColor($(el).data('type'),$(el).data('id'));
    });
    bindLBHLinks();
  	//parcours tous les boutons link pour vérifier si l'entité est déjà dans mon répertoire
  	$.each( $(".followBtn"), function(index, value){
    	var id = $(value).attr("data-id");
   		var type = $(value).attr("data-type");
      //mylog.log("error type :", type);

   		type = (type == "person") ? "people" : dyFInputs.get(type).col;
      //mylog.log("#floopItem-"+type+"-"+id);
   		if($("#floopItem-"+type+"-"+id).length){
   			//mylog.log("I FOLLOW THIS");
   			if(type=="people"){
	   			$(value).html("<i class='fa fa-unlink text-green'></i>");
	   			$(value).attr("data-original-title", "Ne plus suivre cette personne");
	   			$(value).attr("data-ownerlink","unfollow");
   			}
   			else{
	   			$(value).html("<i class='fa fa-user-plus text-green'></i>");
	   			
          if(type == "organizations")
	   				$(value).attr("data-original-title", "Vous êtes membre de cette organization");
	   			else if(type == "projects")
	   				$(value).attr("data-original-title", "Vous êtes contributeur de ce projet");
	   			
          //(value).attr("onclick", "");
	   			$(value).removeClass("followBtn");
	   		}
   		}
   		if($(value).attr("data-isFollowed")=="true"){

	   		$(value).html("<i class='fa fa-unlink text-green'></i>");
	   		$(value).attr("data-original-title", (type == "events") ? "Ne plus participer" : "Ne plus suivre" );
			  $(value).attr("data-ownerlink","unfollow");
        $(value).addClass("followBtn");
   		}
   	});

  	//on click sur les boutons link
	$(".followBtn").click(function(){
		formData = new Object();
		formData.parentId = $(this).attr("data-id");
		formData.childId = userId;
		formData.childType = personCOLLECTION;
		var type = $(this).attr("data-type");
		var name = $(this).attr("data-name");
		var id = $(this).attr("data-id");
		//traduction du type pour le floopDrawer
		var typeOrigine = dyFInputs.get(type).col;
		if(typeOrigine == "persons"){ typeOrigine = personCOLLECTION;}
   		formData.parentType = typeOrigine;
   		mylog.log("followBtn",type);
   		type = (type == "person") ? "people" : dyFInputs.get(type).col;

		var thiselement = this;
		$(this).html("<i class='fa fa-spin fa-circle-o-notch text-azure'></i>");
		//mylog.log(formData);
		var linkType = (type == "events") ? "connect" : "follow";
		if ($(this).attr("data-ownerlink")=="follow"){
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/link/"+linkType,
				data: formData,
				dataType: "json",
				success: function(data) {
					if(data.result){
						toastr.success(data.msg);	
						$(thiselement).html("<i class='fa fa-unlink text-green'></i>");
						$(thiselement).attr("data-ownerlink","unfollow");
						$(thiselement).attr("data-original-title", (type == "events") ? "Ne plus participer" : "Ne plus suivre");
						addFloopEntity(id, type, data.parentEntity);
					}
					else
						toastr.error(data.msg);
				},
			});
		} else if ($(this).attr("data-ownerlink")=="unfollow"){
			formData.connectType =  "followers";
			//mylog.log(formData);
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/link/disconnect",
				data : formData,
				dataType: "json",
				success: function(data){
					mylog.log("YOYOY", data);
					if ( data && data.result ) {
						$(thiselement).html("<i class='fa fa-chain'></i>");
						$(thiselement).attr("data-ownerlink","follow");
						$(thiselement).attr("data-original-title", (type == "events") ? "Participer" : "Suivre");
						removeFloopEntity(data.parentId, type);
						toastr.success(trad["You are not following"]+data.parentEntity.name);
					} else {
					   toastr.error("You leave succesfully");
					}
				}
			});
		}
   	});


    $(".btn-update-contact").click(function(){ console.log("editContact");
      updateContact($(this).data("contact-key"),$(this).data("contact-name"), $(this).data("contact-email"), 
                   $(this).data("contact-role"),$(this).data("contact-telephone"));
    });

    $(".deleteThisBtn").off().on("click",function (){
      mylog.log("deleteThisBtn click");
          $(this).empty().html('<i class="fa fa-spinner fa-spin"></i>');
          var btnClick = $(this);
          var id = $(this).data("id");
          var type = $(this).data("type");
          var urlToSend = baseUrl+"/"+moduleId+"/element/delete/type/"+type+"/id/"+id;
          
          bootbox.confirm(trad.areyousuretodelete,
          function(result) 
          {
        if (!result) {
          btnClick.empty().html('<i class="fa fa-trash"></i>');
          return;
        } else {
          $.ajax({
                type: "POST",
                url: urlToSend,
                dataType : "json"
            })
            .done(function (data) {
                if ( data && data.result ) {
                  toastr.info("élément effacé");
                  $("#"+type+id).remove();
                  if( $(".contain_"+type+"_"+id).length > 0 )
                    $(".contain_"+type+"_"+id).remove();
                  else
                    urlCtrl.loadByHash( location.hash );
                  if($("#openModal").hasClass("in"))
                    $("#openModal").modal("hide");
                } else {
                   toastr.error("something went wrong!! please try again.");
                }
            });
        }
      });

    });


    $(".coopPanelHtml").off().click(function(){
      var coopType = $(this).data("coop-type");
      var coopId = $(this).data("coop-id");
      var idParentRoom = $(this).data("coop-idparentroom");
      var parentId = $(this).data("coop-parentid");
      var parentType = $(this).data("coop-parenttype");

      coopType = coopType == "actions" ? "action" : coopType;
      coopType = coopType == "proposals" ? "proposal" : coopType;
      coopType = coopType == "resolutions" ? "resolution" : coopType;

      console.log("onclick coopPanelHtml", coopType, coopId, idParentRoom, parentId, parentType);
      
      if(contextData.id == parentId && contextData.type == parentType){
          toastr.info(trad["processing"]);
          uiCoop.startUI();
          $("#modalCoop").modal("show");
          if(coopType == "rooms"){
            uiCoop.getCoopData(contextData.type, contextData.id, "room", null, coopId);
          }else{
            setTimeout(function(){
              uiCoop.getCoopData(contextData.type, contextData.id, "room", null, idParentRoom, 
              function(){
                toastr.info(trad["processing"]);
                uiCoop.getCoopData(contextData.type, contextData.id, coopType, null, coopId);
              }, false);
            }, 1000);
          }
      }else{
        var hash = "#page.type." + parentType + ".id." + parentId + 
                ".view.coop.room." + idParentRoom + "."+coopType+"." + coopId;
        urlCtrl.loadByHash(hash);
      }

    });

    initBtnShare();
  }


  function initBtnShare(){
    mylog.log("init btn-share ");
    $(".btn-share").off().click(function(){
      var thiselement = this;

      var type = $(thiselement).attr("data-type");
      var id = $(thiselement).attr("data-id");
      
      $("#modal-share").modal("show");
      
      //$("#modal-share #htmlElementToShare").html("test");
      mylog.log("initBtnShare "+type+" - "+id);
      //$("#news-list li#"+type+id).html("bébé");
      var html = "";
      
      if($("#news-list li#"+type+id + " .timeline-panel").length > 0)
        html = $("#news-list li#"+type+id + " .timeline-panel").html();
      //console.log("TO #modal-share : "+html+" "+typeof html);
      
      if($(".timeline-body .newsActivityStream"+id).length > 0)
        html = $(".timeline-body .newsActivityStream"+id).html();
      
      if(html == "" && $(".searchEntity#entity"+id).length > 0) 
        html = "<div class='searchEntity'>"+$(".searchEntity#entity"+id).html()+"</div>";

      if(html == "" && type !="news" && type!="activityStream" && typeof contextData != "undefined"){
        mylog.log("HERE", contextData);
        html = directory.showResultsDirectoryHtml(new Array(contextData), type);
      } 
      
      $("#modal-share #htmlElementToShare").html(html);
      $("#modal-share #btn-share-it").attr("data-id", id);
      $("#modal-share #btn-share-it").attr("data-type", type);
      $("#modal-share #btn-share-it").off().click(function(){
        shareIt("#modal-share #btn-share-it");
      });
    
      //smallMenu.openAjaxHTML(baseUrl+"/"+moduleId+"/page/type/news/id/"+id, "title");

      //shareIt(thiselement);
    });
  }

  function shareIt(thiselement){
      formData = new Object();
      formData.parentId = $(thiselement).attr("data-id");
      formData.childId = userId;
      formData.childType = personCOLLECTION;
      formData.connectType =  "share";
      var type = $(thiselement).attr("data-type");
      var id = $(thiselement).attr("data-id");
      
      var comment = $("#msg-share").val();
      formData.comment = comment;
      $("#msg-share").val("");
      
      //traduction du type pour le floopDrawer
      var typeOrigine = dyFInputs.get(type).col;
      if(typeOrigine == "persons"){ typeOrigine = personCOLLECTION;}
      formData.parentType = typeOrigine;
      if(type == "person") type = "people";
      else type = dyFInputs.get(type).col;

      $.ajax({
        type: "POST",
        url: baseUrl+"/"+moduleId+"/news/share",
        data : formData,
        dataType: "json",
        success: function(data){
          if(data.result){
            console.log(data);
            $("#modal-share #htmlElementToShare").html("");
            $(thiselement).attr("data-original-title", "Vous avez partagé ça avec votre réseau");
            toastr.success(data.msg);
          }  
        }
      });
  }

  function setSearchValue(value){
    $("#searchBarText").val(value);
    startSearch(0, indexStepInit);
  }

  
  
function searchCallback() { 
  directory.elemClass = '.searchEntityContainer ';
  directory.filterTags(true);
  //$(".btn-tag").off().on("click",function(){ directory.toggleEmptyParentSection(null,"."+$(this).data("tag-value"), directory.elemClass, 1)});
  $("#searchBarTextJS").off().on("keyup",function() { 
    directory.search ( null, $(this).val() );
  });
}

var directory = {

    elemClass : smallMenu.destination+' .searchEntityContainer ',
    path : 'div'+smallMenu.destination+' div.favSection',
    tagsT : [],
    scopesT :[],
    multiTagsT : [],
    multiScopesT :[],

    colPos: "left",
    dirLog : false,
    defaultPanelHtml : function(params){
      mylog.log("----------- defaultPanelHtml",params, params.type,params.name, params.url);
      str = "";  
      str += "<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12 searchEntityContainer "+params.type+" "+params.elTagsList+" "+params.elRolesList+" '>";
      str +=    "<div class='searchEntity' id='entity"+params.id+"'>";

      if(params.itemType!="city" && (params.useMinSize))
          str += "<div class='imgHover'>" + params.imgProfil + "</div>"+
                  "<div class='contentMin'>";

        if(userId != null && userId != "" && params.id != userId){
          isFollowed=false;
          if(typeof params.isFollowed != "undefined" ) isFollowed=true;
          if(params.type!="cities" && params.type!="poi" && params.type!="surveys" && params.type!="actions" ){
            tip = (params.type == "events") ? "Participer" : 'Suivre';
            str += "<a href='javascript:;' class='btn btn-default btn-sm btn-add-to-directory bg-white tooltips followBtn'" + 
                  'data-toggle="tooltip" data-placement="left" data-original-title="'+tip+'"'+
                  " data-ownerlink='follow' data-id='"+params.id+"' data-type='"+params.type+"' data-name='"+params.name+"' data-isFollowed='"+isFollowed+"'>"+
                      "<i class='fa fa-chain'></i>"+ //fa-bookmark fa-rotate-270
                    "</a>";
          }
        }

        if(params.updated != null && !params.useMinSize)
          str += "<div class='dateUpdated'><i class='fa fa-flash'></i> <span class='hidden-xs'>"+trad["actif"]+" </span>" + params.updated + "</div>";

        if(params.itemType!="city" && (typeof params.size == "undefined" || params.size == "max"))
          str += "<a href='"+params.hash+"' class='container-img-profil lbhp add2fav'  data-modalshow='"+params.id+"'>" + params.imgProfil + "</a>";

        str += "<div class='padding-10 informations'>";


          if(!params.useMinSize){
            if(params.startDate != null)
            str += "<div class='entityDate dateFrom bg-"+params.color+" transparent badge'>" + params.startDate + "</div>";
            if(params.endDate != null)
            str += "<div  class='entityDate dateTo  bg-"+params.color+" transparent badge'>" + params.endDate + "</div>";
            
            if(typeof params.size == "undefined" || params.size == "max"){
              str += "<div class='entityCenter no-padding'>";
              str +=    "<a href='"+params.hash+"' class='lbhp add2fav'  data-modalshow='"+params.id+"'>" + params.htmlIco + "</a>";
              str += "</div>";
            }
          }  
              
            str += "<div class='entityRight no-padding'>";
                             
              
            if(notEmpty(params.parent) && notEmpty(params.parent.name))
              str += "<a href='"+urlParent+"' class='entityName text-"+params.parentColor+" lbhp add2fav   data-modalshow='"+params.id+"'text-light-weight margin-bottom-5'>" +
                        "<i class='fa "+params.parentIcon+"'></i> "
                        + params.parent.name + 
                      "</a>";

            var iconFaReply = notEmpty(params.parent) ? "<i class='fa fa-reply fa-rotate-180'></i> " : "";
            str += "<a  href='"+params.hash+"' class='"+params.size+" entityName text-dark lbhp add2fav'  data-modalshow='"+params.id+"'>"+
                      iconFaReply + params.name + 
                   "</a>";
            
            var thisLocality = "";
            if(params.fullLocality != "" && params.fullLocality != " ")
                 thisLocality = "<a href='"+params.hash+"' data-id='" + params.dataId + "' class='entityLocality lbhp add2fav'  data-modalshow='"+params.id+"'>"+
                                  "<i class='fa fa-home'></i> " + params.fullLocality + 
                                "</a>";
            else thisLocality = "<br>";
            
            if(itemType=="city"){
              var citykey = params.country + "_" + params.insee + "-" + params.cp;
              //$city["country"]."_".$city["insee"]."-".$city["cp"];
              if(directory.dirLog) mylog.log(o);
              thisLocality += "<button class='btn btn-sm btn-default item-globalscope-checker start-new-communexion' "+
                                      "data-scope-value='" + citykey + "' " + 
                                      "data-scope-name='" + params.name + "' " + 
                                      "data-scope-type='city' " + 
                                      "data-insee-communexion='" + params.insee + "' "+ 
                                      "data-name-communexion='" + params.name + "' "+ 
                                      "data-cp-communexion='" + params.cp + "' "+ 
                                      "data-region-communexion='" + params.regionName + "' "+ 
                                      "data-country-communexion='" + params.country + "' "+ 
                              ">"+
                                  "Communecter" + 
                              "</button>";

                              
            }

            //debat / actions
            if(notEmpty(params.parentRoom)){
              params.parentUrl = "";
              params.parentIco = "";
              if(type == "surveys"){ params.parentUrl = "#survey.entries.id."+params.survey; params.parentIco = "archive"; }
              else if(type == "actions") {params.parentUrl = "#rooms.actions.id."+params.room;params.parentIco = "cogs";}
              str += "<div class='entityDescription text-dark'><i class='fa fa-" + params.parentIco + "'></i><a href='" + params.parentUrl + "' class='lbhp add2fav'  data-modalshow='"+params.id+"'> " + params.parentRoom.name + "</a></div>";
              if(notEmpty(params.parentRoom.parentObj)){
                var typeIcoParent = params.parentRoom.parentObj.typeSig;
                //mylog.log("typeIcoParent", params.parentRoom);

                var p = dyFInputs.get(typeIcoParent);
                params.icoParent = p.icon;
                params.colorParent = p.color;

                var thisLocality = notEmpty(params.parentRoom) && notEmpty(params.parentRoom.parentObj) && 
                              notEmpty(params.parentRoom.parentObj.address) ? 
                              params.parentRoom.parentObj.address : null;

                var postalCode = notEmpty(thisLocality) && notEmpty(thisLocality.postalCode) ? thisLocality.postalCode : "";
                var cityName = notEmpty(thisLocality) && notEmpty(thisLocality.addressLocality) ? thisLocality.addressLocality : "";

                thisLocality = postalCode + " " + cityName;
                if(thisLocality != " ") thisLocality = ", <small> " + thisLocality + "</small>";
                else thisLocality = "";

                var ctzCouncil = typeIcoParent=="city" ? "Conseil citoyen de " : "";
                str += "<div class='entityDescription text-"+params.colorParent+"'> <i class='fa "+params.icoParent+"'></i> <b>" + ctzCouncil + params.parentRoom.parentObj.name + "</b>" + thisLocality+ "</div>";
              

              }
            }else{
              str += thisLocality;
            }
            
            if(itemType == "entry"){
              var vUp   = notEmpty(params.voteUpCount)       ? params.voteUpCount.toString()        : "0";
              var vMore = notEmpty(params.voteMoreInfoCount) ? params.voteMoreInfoCount.toString()  : "0";
              var vAbs  = notEmpty(params.voteAbstainCount)  ? params.voteAbstainCount.toString()   : "0";
              var vUn   = notEmpty(params.voteUnclearCount)  ? params.voteUnclearCount.toString()   : "0";
              var vDown = notEmpty(params.voteDownCount)     ? params.voteDownCount.toString()      : "0";
              str += "<div class='pull-left margin-bottom-10 no-padding'>";
                str += "<span class='bg-green lbl-res-vote'><i class='fa fa-thumbs-up'></i> " + vUp + "</span>";
                str += " <span class='bg-blue lbl-res-vote'><i class='fa fa-pencil'></i> " + vMore + "</span>";
                str += " <span class='bg-dark lbl-res-vote'><i class='fa fa-circle'></i> " + vAbs + "</span>";
                str += " <span class='bg-purple lbl-res-vote'><i class='fa fa-question-circle'></i> " + vUn + "</span>";
                str += " <span class='bg-red lbl-res-vote'><i class='fa fa-thumbs-down'></i> " + vDown + "</span>";
              str += "</div>";
            }

            str += "<div class='entityDescription'>" + params.description + "</div>";
            str += "<div class='tagsContainer text-red'>"+params.tagsLbl+"</div>";

            if(params.useMinSize){
              if(params.startDate != null)
              str += "<div class='entityDate dateFrom bg-"+params.color+" transparent badge'>" + params.startDate + "</div>";
              if(params.endDate != null)
              str += "<div  class='entityDate dateTo  bg-"+params.color+" transparent badge'>" + params.endDate + "</div>";
              
              if(typeof params.size == "undefined" || params.size == "max"){
                str += "<div class='entityCenter no-padding'>";
                str +=    "<a href='"+params.hash+"' class='lbhp add2fav'  data-modalshow='"+params.id+"'>" + params.htmlIco + "</a>";
                str += "</div>";
              }
            }  

        if(params.type!="city" && (params.useMinSize))
          str += "</div>";
          str += "</div>";
        str += "</div>";
      str += "</div>";

      str += "</div>";
      return str;
    },
    // ********************************
    //  ELEMENT DIRECTORY PANEL
    // ********************************
	  elementPanelHtml : function(params){
    		if(directory.dirLog) mylog.log("----------- elementPanelHtml",params.type,params.name,params.elTagsList);
    		
        mylog.log("----------- elementPanelHtml log", params.elTagsList);
    		str = "";
    		var grayscale = ( ( notNull(params.isInviting) && params.isInviting == true) ? "grayscale" : "" ) ;
    		var tipIsInviting = ( ( notNull(params.isInviting) && params.isInviting == true) ? trad["Wait for confirmation"] : "" ) ;
    		str += "<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12 searchEntityContainer "+grayscale+" "+params.type+" "+params.elTagsList+" "+params.elRolesList+" contain_"+params.type+"_"+params.id+"'>";
    		str +=    '<div class="searchEntity" id="entity'+params.id+'">';
    		
        var addFollowBtn = ( $.inArray(params.type, ["poi"])>=0 )  ? false : true;
        if(typeof params.edit  != "undefined")
              str += this.getAdminToolBar(params);
            
    		if(userId != null && userId != "" && params.id != userId && !inMyContacts(params.typeSig, params.id) && addFollowBtn && location.hash.indexOf("#page") < 0){
    			isFollowed=false;

    			if(typeof params.isFollowed != "undefined" ) 
    				isFollowed=true;
    			tip = (params.type == "events") ? trad["participate"] : trad['Follow'];
    			str += "<a href='javascript:;' class='btn btn-default btn-sm btn-add-to-directory bg-white tooltips followBtn'" + 
    			' data-toggle="tooltip" data-placement="left" data-original-title="'+tip+'"'+
    			" data-ownerlink='follow' data-id='"+params.id+"' data-type='"+params.type+"' data-name='"+params.name+"' data-isFollowed='"+isFollowed+"'>"+
    			"<i class='fa fa-chain'></i>"+ //fa-bookmark fa-rotate-270
    			"</a>";          
    		}

        if(params.updated != null )
          str += "<div class='dateUpdated'><i class='fa fa-flash'></i> <span class='hidden-xs'>"+trad["actif"]+" </span>" + params.updated + "</div>";
        
        var linkAction = ( $.inArray(params.type, ["poi","classified"])>=0 ) ? " lbhp' data-modalshow='"+params.id+"' data-modalshow='"+params.id+"' " : " lbh'";
        if(params.type == "citoyens") 
            params.hash += '.viewer.' + userId;
       // if(typeof params.size == "undefined" || params.size == "max")
          str += "<a href='"+params.hash+"' class='container-img-profil add2fav "+linkAction+">" + params.imgProfil + "</a>";

        str += "<div class='padding-10 informations tooltips'  data-toggle='tooltip' data-placement='top' data-original-title='"+tipIsInviting+"'>";

        str += "<div class='entityRight no-padding'>"; 

            if(typeof params.size == "undefined" || params.size == undefined || params.size == "max"){
              str += "<div class='entityCenter no-padding'>";
              str +=    "<a href='"+params.hash+"' class='add2fav "+linkAction+">" + params.htmlIco + "</a>";
              str += "</div>";
            }

            if(notEmpty(params.typePoi)){
              str += "<span class='typePoiDir'><i class='fa fa-chevron-right'></i> " + tradCategory[params.typePoi] + "<hr></span>";  
            }

            var iconFaReply = notEmpty(params.parent) ? "<i class='fa fa-reply fa-rotate-180'></i> " : "";
            str += "<a  href='"+params.hash+"' class='"+params.size+" entityName bold text-dark add2fav "+linkAction+">"+
                      iconFaReply + params.name + 
                   "</a>";  
                    
                    
            if(typeof(params.statusLink)!="undefined"){
              if(typeof(params.statusLink.isAdmin)!="undefined" && typeof(params.statusLink.isAdminPending)=="undefined" && typeof(params.statusLink.isAdminInviting)=="undefined")
                str+="<span class='text-red'>"+trad.administrator+"</span>";
              if(typeof(params.statusLink.isAdminInviting)!="undefined"){
                str+="<span class='text-red'>"+trad.invitingToAdmin+"</span>";
              }
              if(typeof(params.statusLink.toBeValidated)!="undefined" || typeof(params.statusLink.isAdminPending)!="undefined")
                str+="<span class='text-red'>"+trad.waitingValidation+"</span>";
            }

            if(params.rolesLbl != "")
            str += "<div class='rolesContainer'>"+params.rolesLbl+"</div>";
            
            if( params.section ){
              str += "<div class='entityType'>" + params.section+" > "+params.type+"<br/>"+params.elTagsList;
                if(typeof params.subtype != "undefined") str += " > " + params.subtype;
              str += "</div>";
            }
                                 
            var thisLocality = "";
            if(params.fullLocality != "" && params.fullLocality != " ")
                 thisLocality = "<a href='"+params.hash+"' data-id='" + params.dataId + "'  class='entityLocality add2fav "+linkAction+">"+
                                  "<i class='fa fa-home'></i> " + params.fullLocality + 
                                "</a>";
            else thisLocality = "<br>";
            
            str += thisLocality;
            
            str += "<div class='entityDescription'>" + params.description + "</div>";
            str += "<div class='tagsContainer text-red'>"+params.tagsLbl+"</div>";
            /*
              if(params.startDate != null)
              str += "<div class='entityDate dateFrom bg-"+params.color+" transparent badge'>" + params.startDate + "</div>";
              if(params.endDate != null)
              str += "<div  class='entityDate dateTo  bg-"+params.color+" transparent badge'>" + params.endDate + "</div>";
              */
              
          str += "</div>";
        str += "</div>";
      str += "</div>";

      str += "</div>";
      return str;
    },

    interopPanelHtml : function(params){
      mylog.log("----------- interopPanelHtml",params, params.type,params.name, params.url);

      var interop_type = getTypeInteropData(params.source.key);
      params.hash = getUrlForInteropDirectoryElements(interop_type, params.shortDescription, params.url);
      params.url = params.hash;
      params.color = getIconColorForInteropElements(interop_type);
      params.htmlIco = getImageIcoForInteropElements(interop_type);
      params.type = "poi.interop."+interop_type;

      if (typeof params.tags == "undefined") 
        params.tags = [];
        params.tags.push(interop_type);

      str = "";  
      str += "<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12 searchEntityContainer "+params.type+" "+params.elTagsList+" "+params.elRolesList+" '>";
      str +=    "<div class='searchEntity' id='entity"+params.id+"'>";

      if(params.itemType!="city" && (params.useMinSize))
        str += "<div class='imgHover'>" + params.imgProfil + "</div>"+
                "<div class='contentMin'>";

      if(params.itemType!="city" && (typeof params.size == "undefined" || params.size == "max"))
        str += "<a href='"+params.hash+"' class='container-img-profil lbhp add2fav'  data-modalshow='"+params.id+"'>" + params.imgProfil + "</a>";

      str += "<div class='padding-10 informations'>";

      if(!params.useMinSize){
        if(typeof params.size == "undefined" || params.size == "max"){
          str += "<div class='entityCenter no-padding'>";
          str +=    "<a href='"+params.hash+"' class='lbhp add2fav'  data-modalshow='"+params.id+"'>" + params.htmlIco + "</a>";
          str += "</div>";
        }
      }  
              
      str += "<div class='entityRight no-padding'>";

      var iconFaReply = notEmpty(params.parent) ? "<i class='fa fa-reply fa-rotate-180'></i> " : "";
      str += "<a  href='"+params.hash+"' class='"+params.size+" entityName text-dark lbhp add2fav'  data-modalshow='"+params.id+"'>"+
                iconFaReply + params.name + 
             "</a>";
      
      var thisLocality = "";
      if(params.fullLocality != "" && params.fullLocality != " ")
        thisLocality = "<a href='"+params.hash+"' data-id='" + params.dataId + "' class='entityLocality lbhp add2fav'  data-modalshow='"+params.id+"'>"+
                          "<i class='fa fa-home'></i> " + params.fullLocality + 
                        "</a>";
      else thisLocality = "<br>";
      
      str += "<div class='entityDescription'>" + params.description + "</div>";
      str += "<div class='tagsContainer text-red'>"+params.tagsLbl+"</div>";

      if(params.useMinSize){
        // if(params.startDate != null)
        // str += "<div class='entityDate dateFrom bg-"+params.color+" transparent badge'>" + params.startDate + "</div>";
        // if(params.endDate != null)
        // str += "<div  class='entityDate dateTo  bg-"+params.color+" transparent badge'>" + params.endDate + "</div>";
        
        if(typeof params.size == "undefined" || params.size == "max"){
          str += "<div class='entityCenter no-padding'>";
          str +=    "<a href='"+params.hash+"' class='lbhp add2fav'  data-modalshow='"+params.id+"'>" + params.htmlIco + "</a>";
          str += "</div>";
        }
      }  

      if(params.type!="city" && (params.useMinSize))
        str += "</div>";
        str += "</div>";
      str += "</div>";
      str += "</div>";

      str += "</div>";
      return str;
    },


    // ********************************
    // CALCULATE NEXT PREVIOUS 
    // ********************************
    findNextPrev : function  (hash) { 
        mylog.log("----------- findNextPrev", hash);
        var p = 0;
        var n = 0;
        var nid = 0;
        var pid = 0;
        var  found = false;
        var l = $( '.searchEntityContainer .container-img-profil' ).length;
        $.each( $( '.searchEntityContainer .container-img-profil' ), function(i,val){
            console.log("found ??",$(val).attr('href'), hash);
            if( $(val).attr('href') == hash ){
                found = i;
                console.log("found",found);
                return false;
            }
        });
        
        prevIx = (found == 0) ? l-1 : found-1;
        p =  $( $('.searchEntityContainer .container-img-profil' )[ prevIx ] ).attr('href');
        pid = urlCtrl.map(p).id;
        
        nextIx = (found == l-1) ? 0 : found+1;
        n = $( $('.searchEntityContainer .container-img-profil' )[nextIx] ).attr('href');
        nid =  urlCtrl.map(n).id;
        
        console.log("next",n,nid);
        console.log("prev",p,pid);

        return {
            prev : "<a href='"+p+"' data-modalshow='"+pid+"' class='lbhp text-dark pull-right margin-right-10 margin-left-10'><i class='fa fa-2x fa-arrow-circle-left'></i> </a> ",
            next : "<a href='"+n+"' data-modalshow='"+nid+"' class='lbhp text-dark pull-right'> <i class='fa fa-2x fa-arrow-circle-right'></i></a>"
        }
    },
    // ********************************
    //  DIRECTORY PREVIEW PANEL
    // ********************************
    //TODO : ADD link to seller contact page
    previewedObj : null,
    preview : function(params,hash){

      mylog.log("----------- preview",params,params.name, hash);
      directory.previewedObj = {
          hash : hash,
          params : params
      };
      

      str = '';
      // '<div class="row">'+
      //         '<div class="col-lg-12 text-center" onclick="$(\'#\')">'+
      //             '<h2 class="text-'+typeObj[params.type].color+'"><i class="fa fa-'+typeObj[params.type].icon+' fa-2x padding-bottom-10"></i><br>'+
      //                 '<span class="font-blackoutT"> '+trad[params.type]+'</span>'+
      //             '</h2>'+
      //             '<hr>'+
      //         '</div>'+
      //     '</div><br/><br/>';
      
      // ********************************
      // NEXT PREVIOUS 
      // ********************************
      str += "<div class='col-xs-6 col-sm-2 col-md-3 pull-left text-right'></div>";
      //str += "<div class='col-xs-6 col-sm-2 col-md-3 pull-right text-left visible-xs'>"+nav.next+"</div>";
      // ********************************
      // RIGHT SECTION
      // ********************************
      str += "<div class='col-xs-12 col-sm-8 col-md-6 margin-top-15'>";

        // ********************************
        // LEFT SECTION
        // ********************************
        str +=  "<div class='col-xs-12 text-left'>";
        
          var devise = typeof params.devise != "undefined" ? params.devise : "";
          var price = (typeof params.price != "undefined" && params.price != "") ? 
                        "<br/><i class='fa fa-money'></i> " + params.price + " " + devise : "";
          
          str += "<h4 class='text-azure'>"+price+"</h4>";

          if(typeof params.category != "undefined"){
              str += "<div class='entityType text-dark'><span class='bold uppercase'>" + params.section + "</span> > "+params.category;
                if(typeof params.subtype != "undefined") str += " > " + params.subtype;
              str += "</div><hr>";
            }

         //if(typeof hash != "undefined"){
            var nav = directory.findNextPrev(hash);
            if(typeof params.name != "undefined" && params.name != "")
              str += "<div class='bold text-black' style='font-size:20px;'>"+ 
                        "<div class='col-md-8 col-sm-8 col-xs-7 no-padding margin-top-10'>"+params.name + "</div>";
                        if( typeof hash != "undefined" ){ 
                          str +=  "<div class='col-md-4 col-sm-4 col-xs-5 no-padding'>"+ 
                                    nav.next+
                                    nav.prev+
                                  "</div>";
                        }
              str +=    "<br>"+
                     "</div>";
         // }

          if(typeof params.description != "undefined" && params.description != "")
              str += "<div class='col-xs-12 no-padding pull-left'><hr>" + params.description + "<hr></div>";

          if( typeof params.medias != "undefined" && typeof params.medias[0].content.url ){
            str += "<div class='col-xs-12 bold text-black' style='font-size:15px;'>Média (urls, informations)</div>";
            $.each(params.medias, function (ix, mo) {  
              str += "<div class='col-xs-12'><a href='" + mo.content.url + "' target='_blank'>" + mo.content.url + "</a></div>";
            });
            str += "<hr class='col-xs-12'>";
          }


          if(typeof params.contactInfo != "undefined" && params.contactInfo != ""){
            str += "<div class='entityType letter-green bold' style='font-size:17px;'><i class='fa fa-address-card'></i> Contact : " + params.contactInfo + "</div>";
            str += "<hr class='col-xs-12'>";
          }

          var thisLocality = "";
          if(typeof params.fullLocality != "undefined" && params.fullLocality != "" && params.fullLocality != " ")
          {
            str += "<div class='col-xs-12 bold text-black' style='font-size:15px;'>Addresse : ";
            str += "<a href='"+params.hash+"' data-id='" + params.dataId + "' class='entityLocality  lbhp add2fav letter-red' data-modalshow='"+params.id+"'>"+
                              "<i class='fa fa-home'></i> " + params.fullLocality + 
                            "</a>";
           str += "</div>";
           str += "<hr class='col-xs-12'>";
           //str += thisLocality;
          }
          //else thisLocality = "<br>";
          

       
          if(notEmpty(params.tagsLbl)){
            str += "<div class='col-xs-12 bold text-black' style='font-size:15px;'>Mots clés : "+params.tagsLbl+"</div>";
            str += "<hr class='col-xs-12'>";
          }


        str += "</div>";

        getAjax( null , baseUrl+'/'+moduleId+"/document/list/id/"+params.id+"/type/"+params.type+"/tpl/json" , function( data ) { 
          var c = 1;
          $.each(data.list,function(k,v) { 
            mylog.log("data list",k,v);
            if( $('.carousel-first img').attr('src') && $('.carousel-first img').attr('src').indexOf(v.name) < 0 ){
              $(".carousel-inner").append('  <div class="item">'+
              "   <img class='img-responsive' src='"+v.path+"/"+v.name+"'/>"+
              ' </div>');
              $(".carousel-indicators").append('<li data-target="#myCarousel" data-slide-to="'+c+'"></li>');
              c++;
            }
          });

        });

        if("undefined" != typeof params.profilImageUrl && params.profilImageUrl != "")
          str += '<div class="col-xs-12 text-center">'+
            '<div id="myCarousel" class="carousel slide" data-ride="carousel">'+
              //<!-- Indicators -->
              '<ol class="carousel-indicators">'+
              '  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>'+
              '</ol>'+

              //<!-- Wrapper for slides -->'+
              '<div class="carousel-inner" role="listbox">'+
              '  <div class="item active carousel-first ">'+
              "   <img class='img-responsive' src='"+baseUrl+params.profilImageUrl+"'/>"+
              '  </div>'+
              '</div>'+

              //<!-- Left and right controls -->'+
              '<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">'+
              '  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>'+
              '  <span class="sr-only">Previous</span>'+
              '</a>'+
              '<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">'+
              '  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'+
              '  <span class="sr-only">Next</span>'+
              '</a>'+
            '</div>'+
            // '<a class="thumb-info" href="'+baseUrl+params.profilImageUrl+'" data-title="" data-lightbox="all">'+
            //   "<img class='img-responsive' src='"+baseUrl+params.profilImageUrl+"'/>"+
            // '</a>'+
        '</div>';

        if( params.creator == userId || params.author == userId || params.parentId == userId || dyFObj.canUserEdit() ){
          str += '<hr>'+
              '<div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12 shadow2 padding-15 margin-top-25">'+
              '<a href="javascript:;" class="btn btn-default text-red deleteThisBtn bold pull-left" data-type="'+params.type+'" data-id="'+params.id+'" ><i class="fa fa-trash"></i></a> '+
              '<a href="javascript:dyFObj.editElement(\''+params.type+'\', \''+params.id+'\' );" class="btn btn-default pull-right letter-green bold">'+
                  '<i class="fa fa-pencil"></i> '+trad["modifyelement"]+
              '</a></div>';
            }



      str += "</div>";


      //str += "<div class='col-xs-1 col-sm-2 col-md-3 pull-right text-left margin-top-15 hidden-xs'></div>";

      return str;
    },

    // ********************************
    // CLASSIFIED DIRECTORY PANEL
    // ********************************    
    classifiedPanelHtml : function(params){
      if(directory.dirLog) mylog.log("----------- classifiedPanelHtml",params,params.name);

      str = "";  
      str += "<div class='col-lg-6 col-md-12 pull- col-sm-12 col-xs-12 searchEntityContainer "+params.type+params.id+" "+params.type+" "+params.elTagsList+" '>";
      str +=    "<div class='searchEntity' id='entity"+params.id+"'>";
      
     // directory.colPos = directory.colPos == "left" ? "right" : "left";
       
      if(userId != null && userId != "" && params.id != userId){
          isFollowed=false;
          if(typeof params.isFollowed != "undefined" ) isFollowed=true;
           var tip = 'Garder en favoris';
            str += "<a href='javascript:collection.add2fav(\"classified\",\""+params.id+"\")' class='dirStar star_classified_"+params.id+" btn btn-default btn-sm btn-add-to-directory bg-white tooltips'" + 
                  'data-toggle="tooltip" data-placement="left" data-original-title="'+tip+'"'+
                  " data-ownerlink='follow' data-id='"+params.id+"' data-type='"+params.type+"'>"+
                    "<i class='fa fa star fa-star-o'></i>"+ //fa-bookmark fa-rotate-270
                  "</a>";
          
        }

        if(params.updated != null )
          str += "<div class='dateUpdated'><i class='fa fa-flash'></i> <span class='hidden-xs'>publié </span>" + 
                    params.updated + 
                  "</div>";
        
        if(params.type == "citoyens") 
            params.hash += '.viewer.' + userId;
        if(typeof params.size == "undefined" || params.size == "max")
          str += "<a href='"+params.hash+"' class='container-img-profil lbhp add2fav'  data-modalshow='"+params.id+"'>" + 
                    params.imgProfil + 
                  "</a>";

        str += "<div class='padding-10 informations'>";

        str += "<div class='entityRight no-padding'>";

            if(typeof params.size == "undefined" || params.size == "max"){
              str += "<div class='entityCenter no-padding'>";
              str +=    "<a href='"+params.hash+"' class='lbhp add2fav' data-modalshow='"+params.id+"'>" + params.htmlIco + "</a>";
              str += "</div>";
            }

            str += "<button id='btn-share-event' class='text-dark btn btn-link no-padding margin-left-10 btn-share pull-right'"+
                              " data-ownerlink='share' data-id='"+params.id+"' data-type='"+params.type+"'>"+
                              "<i class='fa fa-share'></i> Partager</button>";


            var devise = typeof params.devise != "undefined" ? params.devise : "";
            if(typeof params.price != "undefined" && params.price != "")
            str += "<div class='entityPrice text-azure'><i class='fa fa-money'></i> " + params.price + " " + devise + "</div>";
         
            if(typeof params.category != "undefined"){
              str += "<div class='entityType'><span class='uppercase bold'>" + tradCategory[params.section] + "</span> > " + tradCategory[params.category];
              if(typeof params.subtype != "undefined") str += " > " + tradCategory[params.subtype];
              str += "</div>";
            }

            var iconFaReply = notEmpty(params.parent) ? "<i class='fa fa-reply fa-rotate-180'></i> " : "";
            str += "<a  href='"+params.hash+"' class='"+params.size+" entityName text-dark lbhp add2fav'  data-modalshow='"+params.id+"'>"+
                      iconFaReply + params.name + 
                   "</a>";  
       
            
            
            if(typeof params.description != "undefined" && params.description != "")
            str += "<div class='entityDescription'>" + params.description + "</div>";
            

            var thisLocality = "";
            if(params.fullLocality != "" && params.fullLocality != " ")
                 thisLocality = "<a href='"+params.hash+"' data-id='" + params.dataId + "' class='entityLocality pull-right lbhp add2fav letter-red' data-modalshow='"+params.id+"'>"+
                                  "<i class='fa fa-home'></i> " + params.fullLocality + 
                                "</a>";
            //else thisLocality = "<br>";
            
            str += thisLocality;


            if(typeof params.contactInfo != "undefined" && params.contactInfo != "")
            str += "<div class='entityType letter-green'><i class='fa fa-address-card'></i> " + params.contactInfo + "</div>";
         
            str += "<div class='tagsContainer text-red'>"+params.tagsLbl+"</div>";

            
            if(params.startDate != null)
            str += "<div class='entityDate dateFrom bg-"+params.color+" transparent badge'>" + params.startDate + "</div>";
            if(params.endDate != null)
            str += "<div  class='entityDate dateTo  bg-"+params.color+" transparent badge'>" + params.endDate + "</div>";
      
          str += "</div>";
        str += "</div>";
      str += "</div>";

      str += "</div>";
      return str;
    },
    // ********************************
    // EVENT DIRECTORY PANEL
    // ********************************
    eventPanelHtml : function(params){
      if(directory.dirLog) mylog.log("-----------eventPanelHtml", params);
      str = "";  
      str += "<div class='col-xs-12 searchEntityContainer "+params.type+" "+params.elTagsList+" '>";
      str +=    "<div class='searchEntity' id='entity"+params.id+"'>";

        if(params.updated != null && params.updated.indexOf(trad.ago)>=0 && location.hash == "#agenda")
            params.updated = trad.rightnow;

        if(params.updated != null && !params.useMinSize)
          str += "<div class='dateUpdated'><i class='fa fa-flash'></i> " + params.updated + "</div>";

        var dateFormated = directory.getDateFormated(params);

        params.attendees = "";
        var cntP = 0;
        var cntIv = 0;
        var cntIt = 0;
        if(typeof params.links != "undefined")
          if(typeof params.links.attendees != "undefined"){
            $.each(params.links.attendees, function(key, val){ 
              if(typeof val.isInviting != "undefined" && val.isInviting == true)
                cntIv++; 
              else
                cntP++; 
            });
          }

        params.attendees = "<hr class='margin-top-10 margin-bottom-10'>";
        
        isFollowed=false;
        if(typeof params.isFollowed != "undefined" ) isFollowed=true;
          
        if(userId != null && userId != "" && params.id != userId){
          // params.attendees += "<button id='btn-participate' class='text-dark btn btn-link followBtn no-padding'"+
          //                     " data-ownerlink='follow' data-id='"+params.id+"' data-type='"+params.type+"' data-name='"+params.name+"'"+
          //                     " data-isFollowed='"+isFollowed+"'>"+
          //                     "<i class='fa fa-street-view'></i> Je participe</button>";
          isShared = false;
          // params.attendees += "<button id='btn-interested' class='text-dark btn btn-link no-padding margin-left-10'><i class='fa fa-thumbs-up'></i> Ça m'intéresse</button>";
          params.attendees += "<button id='btn-share-event' class='text-dark btn btn-link no-padding margin-left-10 btn-share'"+
                              " data-ownerlink='share' data-id='"+params.id+"' data-type='"+params.type+"' "+//data-name='"+params.name+"'"+
                              " data-isShared='"+isShared+"'>"+
                              "<i class='fa fa-share'></i> "+trad["share"]+"</button>";
        }
        if(typeof params.edit  != "undefined"){
          params.attendees += "<button class='text-dark btn btn-link no-padding margin-left-10 disconnectConnection'"+
                              " data-id='"+params.id+"' data-type='"+params.type+"' data-connection='"+params.edit+"' data-parent-hide='4'>"+
                              "<i class='fa fa-unlink'></i> "+trad["notparticipateanymore"]+"</button>";
        }
        params.attendees += "<small class='light margin-left-10 tooltips pull-right'  "+
                                    "data-toggle='tooltip' data-placement='bottom' data-original-title='"+trad["attendee-s"]+"'>" + 
                              cntP + " <i class='fa fa-street-view'></i>"+
                            "</small>";

        params.attendees += "<small class='light margin-left-10 tooltips pull-right'  "+
                                    "data-toggle='tooltip' data-placement='bottom' data-original-title='"+trad["concerned"]+"'>" +
                               cntIt + " <i class='fa fa-thumbs-up'></i>"+
                            "</small>";

        params.attendees += "<small class='light margin-left-10 tooltips pull-right'  "+
                                    "data-toggle='tooltip' data-placement='bottom' data-original-title='"+trad["guest-s"]+"'>" +
                               cntIv + " <i class='fa fa-envelope'></i>"+
                            "</small>";

           
        //if(params.imgProfil.indexOf("fa-2x")<0)
        var countSubEvents = ( params.links && params.links.subEvents ) ? "<br/><i class='fa fa-calendar'></i> "+Object.keys(params.links.subEvents).length+" "+trad["subevent-s"]  : "" ; 
        str += '<div class="col-xs-12 col-sm-4 col-md-4 no-padding">'+
                  '<a href="'+params.hash+'" class="container-img-profil lbh add2fav">'+params.imgProfil+'</a>'+  
                '</div>';
        
        if(userId != null && userId != "" && params.id != userId && !inMyContacts(params.typeSig, params.id)){
          var tip = trad["interested"];
            str += "<a href='javascript:;' class='btn btn-default btn-sm btn-add-to-directory bg-white tooltips followBtn'" + 
                      'data-toggle="tooltip" data-placement="left" data-original-title="'+tip+'"'+
                      " data-ownerlink='follow' data-id='"+params.id+"' data-type='"+params.type+"' data-name='"+params.name+"'"+
                      " data-isFollowed='"+isFollowed+"'>"+
                      "<i class='fa fa-chain'></i>"+ //fa-bookmark fa-rotate-270
                    "</a>";
        }

        str += "<div class='col-md-8 col-sm-8 col-xs-12 margin-top-25'>";
        str += dateFormated+countSubEvents;
        str += "</div>";

       
        if("undefined" != typeof params.organizerObj && params.organizerObj != null){ 

          str += "<div class='col-md-8 col-sm-8 col-xs-12 entityOrganizer margin-top-10'>";
            if("undefined" != typeof params.organizerObj.profilThumbImageUrl &&
              params.organizerObj.profilThumbImageUrl != ""){
              
                str += "<img class='pull-left img-responsive' src='"+baseUrl+params.organizerObj.profilThumbImageUrl+"' height='50'/>";
                
            }            
            console.log("typeDYN",params.organizerObj.type, params.organizerObj);
            elem = dyFInputs.get(params.organizerObj.type);
            str += "<h5 class='no-margin padding-top-5'><small>"+tradDynForm.organizedby+"</small></h5>";
            str += "<a href='#page.type."+elem.col+".id."+params.organizerObj["_id"]["$id"]+"' class='lbh' > <small class='entityOrganizerName'>"+params.organizerObj.name+"</small></a>";
          str += "</div>";

        }
        

        str += "<div class='col-md-8 col-sm-8 col-xs-12 entityRight padding-top-10 margin-top-10 pull-right' style='border-top: 1px solid rgba(0,0,0,0.2);'>";

        var thisLocality = "";
        if(params.fullLocality != "" && params.fullLocality != " ")
             thisLocality = //"<h4 class='pull-right no-padding no-margin lbh add2fav'>" +
                              "<small class='margin-left-5 letter-red'><i class='fa fa-map-marker'></i> " + params.fullLocality + "</small>" ;
                            //"</h4>";
        else thisLocality = "";
                
       // str += thisLocality;

        var typeEvent = notEmpty(params.typeEvent) ? 
                        (notEmpty(eventTypes[params.typeEvent]) ? 
                        eventTypes[params.typeEvent] : 
                        trad["event"]) : 
                        trad["event"];
        //console.log("??????????????????",Object.keys(params));
        str += "<h5 class='text-dark lbh add2fav no-margin'>"+
                  "<i class='fa fa-reply fa-rotate-180'></i> " + tradCategory[typeEvent] + thisLocality +
               "</h5>";

        str += "<a href='"+params.hash+"' class='entityName text-dark lbh add2fav'>"+
                  params.name + 
               "</a>";
        
          
        str +=    "<div class='entityDescription margin-bottom-10'>" + 
                    params.description + 
                  "</div>";
        str +=    "<div class='margin-bottom-10 col-md-12 no-padding'>" + 
                    params.attendees + 
                    //"<button class='btn btn-link no-padding margin-right-10 pull-right'><i class='fa fa-link'></i> Je participe</button>";
          
                  "</div>";
        str +=    "<div class='tagsContainer text-red'>"+params.tagsLbl+"</div>";
        str += "</div>";
            
        str += "</div>";
      str += "</div>";

      str += "</div>";
      return str;
    },
    // ********************************
    // CITY DIRECTORY PANEL
    // ********************************
    cityPanelHtml : function(params){
        if(directory.dirLog) mylog.log("-----------cityPanelHtml");
        mylog.log("-----------cityPanelHtml", params);
        str = "";  
        str += "<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom-10 searchEntityContainer "+params.type+" "+params.elTagsList+" '>";
        str +=    "<div class='searchEntity'>";

                if(params.updated != null)
                  str += "<div class='dateUpdated'><i class='fa fa-flash'></i> <span class='hidden-xs'>"+trad["actif"]+" </span>" + params.updated + "</div>";

                str += "<div class='padding-10 informations'>";
                      
                    str += "<div class='entityRight no-padding'>";
                    
                    //params.hash = "#city.detail.insee."+params.insee+".postalCode."+params.cp;           
                    params.hash = ""; //#main-col-search";
                    params.onclick = 'setScopeValue($(this))'; //"'+params.name.replace("'", "\'")+'");';
                    params.onclickCp = 'setScopeValue($(this));';
                    params.target = "";
                    params.dataId = params.name; 
                    //params.fullLocality =  "<b>" +params.name + "</b> - " +  params.cp+ "<br>" +  params.regionName;

                    params.fullLocality =  "<b>" + params.name + "</b> " + (notEmpty(params.cp) ? " - " +  params.cp : "") + " ( " + params.country + " ) " ;
                    if( notEmpty( params.level4Name ) )
                      params.fullLocality += "<br/>" +  params.level4Name ;
                    else if( notEmpty( params.level3Name ) )
                      params.fullLocality += "<br/>" +  params.level3Name ;
                    else if( notEmpty( params.level2Name ) )
                      params.fullLocality += "<br/>" +  params.level2Name ;


                    var thisLocality = "";
                    if(params.fullLocality != "" && params.fullLocality != " ")
                         thisLocality = '<span data-id="' + params.dataId + '"' + "  class='margin-bottom-5 entityName letter-red lbh add2fav'>"+
                                          "<i class='fa fa-university'></i> " + params.fullLocality + 
                                        "</span>";
                    else thisLocality = "<br>";
                    
                    str += thisLocality;

                    
                    str += "</div>";
                  str += "</div>";
      
                mylog.log("-----------cityPanelHtml params", params); 

                var valuesScopes = {
                  city : params.id,
                  cityName : params.name,
                  cp : params.cp,
                  level1 : params.level1,
                  level1Name : params.level1Name
                }

                if( notEmpty( params.level4 ) ){
                  valuesScopes.level4 = params.level4 ;
                  valuesScopes.level4Name = params.level4Name ;
                }
                if( notEmpty( params.level3 ) ){
                  valuesScopes.level3 = params.level3 ;
                  valuesScopes.level3Name = params.level3Name ;
                }
                if( notEmpty( params.level2 ) ){
                  valuesScopes.level2 = params.level2 ;
                  valuesScopes.level2Name = params.level2Name ;
                }

                str += "<button class='btn btn-sm btn-danger item-globalscope-checker' "+
                                "data-scope-value='" + params.id  + "' " + 
                                "data-scope-name='" + params.name + "' " +
                                "data-scope-level='city' " +
                                "data-scope-type='city' " +
                                "data-scope-values='"+JSON.stringify(valuesScopes)+"' " +
                                "data-scope-notsearch='"+true+"' " +
                                ">"+
                                    "<i class='fa fa-angle-right'></i> Communecter" + 
                                "</button>";
                

                str += "</div>";                
              str += "</div>";
              return str;
    },
    // ********************************
    // URL DIRECTORY PANEL
    // ********************************
    urlPanelHtml : function(params, key){
      //if(directory.dirLog) 
      mylog.log("-----------urlPanelHtml", params, key);
      params.title = escapeHtml(params.title);
      if(directory.dirLog) mylog.log("-----------contactPanelHtml", params);
        str = "";  
        str += "<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom-10 ' style='word-wrap: break-word; overflow:hidden;''>";
        str += "<div class='searchEntity contactPanelHtml'>";
          str += "<div class='panel-heading border-light col-lg-12 col-xs-12'>";
          if(params.title.length > 20){
            str += '<h4 class="panel-title text-dark pull-left tooltips"' + 
                        'data-toggle="tooltip" data-placement="bottom" data-original-title="'+params.title+'">'+
                        params.title.substring(0,20)+'...</h4>';
          }else{
            str += '<h4 class="panel-title text-dark pull-left">'+ params.title+'</h4>';
          }
              str += '<br/><a href="'+params.url+'" target="_blank" class="text-dark">'
              str += ((params.url.length > 65) ? params.url.substring(0,65)+'...' : params.url)+'</a>';             
              
              str += '<br/><span class="" style="font-size: 11px !important;">'+urlTypes[params.type]+'</span>';
          str += "</div>";
        if( (typeof openEdition != "undefined" && openEdition == true) || (typeof edit != "undefined" && edit == true) ) {
        str += '<ul class="nav navbar-nav margin-5 col-md-12">';

            str += '<li class="text-red pull-right">';
              str += '<a href="javascript:;"  onclick="removeUrl(\''+key+'\');" class="margin-left-5 bg-white tooltips btn btn-link btn-sm" '+
              'data-toggle="tooltip" data-placement="top" data-original-title="'+trad["delete"]+'" >';
                str += '<i class="fa fa-trash"></i>';
              str += '</a>';
            str += '</li>';

            str += '<li class="text-red pull-right">';
              str += '<a href="javascript:;" onclick="updateUrl(\''+key+'\', \''+params.title+'\',  \''+params.url+'\', \''+params.type+'\');" ' +
              'class="bg-white tooltips btn btn-link btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="'+trad["update"]+'" >';
                str += '<i class="fa fa-pencil"></i>';
              str += '</a>';
            str += '</li>';
            
          str += '</ul>';
        }
        str += "</div>";  
      str += "</div>";
      return str;
    
    },
    // ********************************
    // PROPOSAL DIRECTORY PANEL
    // ********************************
    coopPanelHtml : function(params, key){
      //if(directory.dirLog) 
      mylog.log("-----------proposalPanelHtml", params, key);
      var idParentRoom = typeof params.idParentRoom != "undefined" ? params.idParentRoom : "";
      if(idParentRoom == "" && params.type == "rooms") idParentRoom = params.id;
      mylog.log("-----------idParentRoom", idParentRoom);
      
      var name = (typeof params.title != "undefined" && params.title != "undefined") ? params.title : params.name;
      var description = params.description.length > 200 ? params.description.substr(0, 200) + "..." : params.description;
      name = escapeHtml(name);
      if(directory.dirLog) mylog.log("-----------coopPanelHtml", params);
        str = "";  
        str += "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10 ' style='word-wrap: break-word; overflow:hidden;''>";
        str += "<div class='searchEntity coopPanelHtml' data-coop-type='"+ params.type + "'  data-coop-id='"+ params.id + "' "+
                    "data-coop-idparentroom='"+ idParentRoom + "' "+
                    "data-coop-parentid='"+ params.parentId + "' "+"data-coop-parenttype='"+ params.parentType + "' "+
                    ">";
          str += "<div class='panel-heading border-light col-lg-12 col-xs-12'>";

          if(name != "")
          str += '<h4 class="panel-title letter-turq"><i class="fa '+ params.ico + '"></i> '+ name + '</h4>';

          if(params.type != "rooms")
          str += '<h5 class=""><small><i class="fa fa-certificate"></i> '+ trad[params.status] + '</small></h5>';

          str += '<span class="text-dark">'+description+'</span>';
          str += "</div>";
        str += "</div>";  
      str += "</div>";
      return str;
    
    },
    // ********************************
    // Contact DIRECTORY PANEL
    // ********************************
    contactPanelHtml : function(params, key){
    	if(directory.dirLog) mylog.log("-----------contactPanelHtml", params, openEdition);
      mylog.log("-----------contactPanelHtml", params, openEdition);
	    str = "";  
	    str += "<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12 margin-bottom-10 '>";
			str += "<div class='searchEntity contactPanelHtml'>";
				str += "<div class='panel-heading border-light col-lg-12 col-xs-12'>";
					if(notEmpty(params.idContact)){
						str += '<a href="#page.type.citoyens.id.'+params.idContact+'" class="lbh" >';
						str += (notEmpty(params.name) ? '<h4 class="panel-title text-dark pull-left">'+params.name+'</h4><br/>' : '')+'</a>';
					}
					else
						str += (notEmpty(params.name) ? '<h4 class="panel-title text-dark pull-left">'+params.name+'</h4><br/>' : '');
					str += (notEmpty(params.role) ? '<span class="" style="font-size: 13px !important;">'+params.role+'</span><br/>' : '');
					//str += (notEmpty(params.email) ? '<a href="javascript:;" onclick="dyFObj.openForm(\'formContact\', \'init\')" style="font-size: 11px !important;">'+params.email+'</a><br/>' : '');
          str += (notEmpty(params.email) ? '<span class="" style="font-size: 12px !important;">'+params.email+'</span><br/>' : '');
					str += (notEmpty(params.telephone) ? '<span class="" style="font-size: 12px !important;">'+params.telephone+'</span>' : '');
				str += "</div>";
      if(typeof userId != "undefined" && userId != ""){
  			str += '<ul class="nav navbar-nav margin-5 col-md-12">';
            if(notEmpty(params.email)){
              str += '<li class="text-left pull-left">';
                str += '<a href="javascript:;" class="tooltips btn btn-default btn-sm openFormContact" '+
                               'data-id-receiver="'+key +'" '+
                               'data-email="'+(notEmpty(params.email) ? params.email : "") +'" '+
                               'data-name="'+(notEmpty(params.name) ? params.name : "") +'">';
                  str += '<i class="fa fa-envelope"></i> Envoyer un e-mail';
                str += '</a>';
              str += '</li>';
            }
            if( (typeof openEdition != "undefined" && openEdition == true) || (typeof edit != "undefined" && edit == true) ) {
              str += '<li class="text-red pull-right">';
                str += '<a href="javascript:;" onclick="removeContact(\''+key+'\');" '+
                          'class="margin-left-5 bg-white tooltips btn btn-link btn-sm" '+
                          'data-toggle="tooltip" data-placement="top" data-original-title="'+trad["delete"]+'" >';
                  str += '<i class="fa fa-trash"></i>';
                str += '</a>';
              str += '</li>';
              str += '<li class="text-left pull-right">';
            
              str += '<a href="javascript:" ' +
                          'class="bg-white tooltips btn btn-link btn-sm btn-update-contact" '+
                          
                          'data-contact-key="'+key+'" data-contact-name="'+params.name+'" '+
                          'data-contact-email="'+params.email+'" data-contact-role="'+params.role+'" '+
                          'data-contact-telephone="'+params.telephone+'"'+
                          
                          'data-toggle="tooltip" data-placement="top" '+
                          'data-original-title="'+trad["update"]+'" >';
                  str += '<i class="fa fa-pencil"></i>';
                str += '</a>';
              str += '</li>';
            }
            
        str += '</ul>';
      }
      str += "</div>";  
		str += "</div>";
		return str;
    },
    // ********************************
    // ROOMS DIRECTORY PANEL
    // ********************************
    roomsPanelHtml : function(params, itemType){
      if(directory.dirLog) mylog.log("-----------roomsPanelHtml");
      mylog.log("-----------roomsPanelHtml :"+itemType);
      if(itemType == "surveys") params.hash = "#page.type.surveys.id."+params.id;
      else if(itemType == "vote") params.hash = "#page.type."+params.parentType+".id."+params.parentId+".view.dda.dir.vote.idda."+ params.id;
      else if(itemType == "discuss") params.hash = "#page.type."+params.parentType+".id."+params.parentId+".view.dda.dir.discuss.idda."+ params.id;
      else if(itemType == "actions") params.hash = "#page.type."+params.parentType+".id."+params.parentId+".view.dda.dir.actions.idda."+ params.id;
      //else if(params.type == "actions") params.hash = "#rooms.action.id."+params.id;
   
      str = "";  
      str += "<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4 searchEntityContainer "+itemType+" "+params.type+" "+params.elTagsList+" '>";
      str +=    "<div class='searchEntity'>";

      str += "<a href='"+params.hash+"' class='container-img-profil add2fav'>" + params.imgProfil + "</a>";
       /* if(userId != null && userId != "" && params.id != userId){
          isFollowed=false;
          if(typeof params.isFollowed != "undefined" ) isFollowed=true;
          tip = (type == "events") ? "Participer" : 'Suivre';
            str += "<a href='javascript:;' class='btn btn-default btn-sm btn-add-to-directory bg-white tooltips followBtn'" + 
                  'data-toggle="tooltip" data-placement="left" data-original-title="'+tip+'"'+
                  " data-ownerlink='follow' data-id='"+params.id+"' data-type='"+params.type+"' data-name='"+params.name+"' data-isFollowed='"+isFollowed+"'>"+
                      "<i class='fa fa-chain'></i>"+ //fa-bookmark fa-rotate-270
                    "</a>";
        }
        */
        if(params.updated != null && !params.useMinSize)
          str += "<div class='dateUpdated'><i class='fa fa-flash'></i> <span class='hidden-xs'>"+trad["actif"]+" </span>" + params.updated + "</div>";

        params.startDay = notEmpty(params.startDate) ? moment(params.startDate).local().locale("fr").format("DD/MM") : "";
        params.startTime = notEmpty(params.startDate) ? moment(params.startDate).local().locale("fr").format("HH:mm") : "";
        params.startDate = notEmpty(params.startDate) ? moment(params.startDate).local().locale("fr").format("DD MMMM YYYY - HH:mm") : null;
        params.endDay = notEmpty(params.endDate) ? moment(params.endDate).local().locale("fr").format("DD/MM") : "";
        params.endTime = notEmpty(params.endDate) ? moment(params.endDate).local().locale("fr").format("HH:mm") : "";
        params.endDate   = notEmpty(params.endDate) ? moment(params.endDate).local().locale("fr").format("DD MMMM YYYY - HH:mm") : null;
        
        str += '<div class="col-xs-5">';
        if(params.startDate != null){
            str += '<div class="col-xs-4">';
            if(params.startDate != null)
                str += '<div class="bg-'+params.color+' text-white padding-5 text-bold" style="border: 2px solid #328a00; font-size:27px;margin-top:5px;">'+params.startDay+'</div>'+ params.startTime;
            if(params.endDate != null)
                str += '<div class="bg-'+params.color+' text-white padding-5 text-bold" style="border: 2px solid #328a00; font-size:27px;margin-top:5px;">'+params.endDay+'</div>'+ params.endTime;
            str += '</div>';
        }
        var w = (params.startDate != null) ? "8" : "12"
            
       
       str +=  '</div>';
        
        str += "<div class='padding-10 informations'>";

        str += "<div class='entityRight no-padding'>";
               
            if(notEmpty(params.parent) && notEmpty(params.parent.name))
              str += "<a href='"+urlParent+"' class='entityName text-"+params.parentColor+" lbh add2fav text-light-weight margin-bottom-5'>" +
                        "<i class='fa "+params.parentIcon+"'></i> "
                        + params.parent.name + 
                      "</a>";

            var iconFaReply = notEmpty(params.parent) ? "<i class='fa fa-reply fa-rotate-180'></i> " : "<i class='fa fa-inbox'></i> ";
            str += "<a  href='"+params.hash+"' class='"+params.size+" entityName text-dark lbh add2fav margin-top-25'>"+
                      iconFaReply + params.name + 
                   "</a>";
            
            var thisLocality = "";
            if(params.fullLocality != "" && params.fullLocality != " ")
                 thisLocality = "<a href='"+params.hash+'\' data-id="' + params.dataId + '"' + "  class='entityLocality lbh add2fav'>"+
                                  "<i class='fa fa-home'></i> " + params.fullLocality + 
                                "</a>";
            else thisLocality = "<br>";
            
            
            if(notEmpty(params.parentRoom)){
              params.parentUrl = params.hash;
              params.parentIco = "";
              if(itemType == "surveys")
                params.parentIco = "archive"; 
              else if(itemType == "actions") 
                params.parentIco = "cogs";
              else if(itemType == "vote") 
                params.parentIco = "gavel";

              str += "<div class='text-dark'>"+

                        "<i class='fa fa-" + params.parentIco + "'></i><a href='" + params.parentUrl + "' class='lbh add2fav'> " + params.parentRoom.name + "</a>"+
                    "</div>";
              if(notEmpty(params.parentRoom.parentObj)){
                var typeIcoParent = params.parentRoom.parentObj.typeSig;
                //mylog.log("typeIcoParent", params.parentRoom);

                var p = dyFInputs.get(typeIcoParent);
                params.icoParent = p.icon;
                params.colorParent = p.color;

                var thisLocality = notEmpty(params.parentRoom) && notEmpty(params.parentRoom.parentObj) && 
                              notEmpty(params.parentRoom.parentObj.address) ? 
                              params.parentRoom.parentObj.address : null;

                var postalCode = notEmpty(thisLocality) && notEmpty(thisLocality.postalCode) ? thisLocality.postalCode : "";
                var cityName = notEmpty(thisLocality) && notEmpty(thisLocality.addressLocality) ? thisLocality.addressLocality : "";

                thisLocality = postalCode + " " + cityName;
                if(thisLocality != " ") thisLocality = ", <small> " + thisLocality + "</small>";
                else thisLocality = "";

                var ctzCouncil = typeIcoParent=="city" ? "Conseil citoyen de " : "";
                str += "<div class=' text-"+params.colorParent+"'> <i class='fa "+params.icoParent+"'></i> <b>" + ctzCouncil + params.parentRoom.parentObj.name + "</b>" + thisLocality+ "</div>";
              

              }
            }else{
              str += thisLocality;
            }
            
            if(itemType == "entry"){
              var vUp   = notEmpty(params.voteUpCount)       ? params.voteUpCount.toString()        : "0";
              var vMore = notEmpty(params.voteMoreInfoCount) ? params.voteMoreInfoCount.toString()  : "0";
              var vAbs  = notEmpty(params.voteAbstainCount)  ? params.voteAbstainCount.toString()   : "0";
              var vUn   = notEmpty(params.voteUnclearCount)  ? params.voteUnclearCount.toString()   : "0";
              var vDown = notEmpty(params.voteDownCount)     ? params.voteDownCount.toString()      : "0";
              str += "<div class='margin-bottom-10 no-padding'>";
                str += "<span class='bg-green lbl-res-vote'><i class='fa fa-thumbs-up'></i> " + vUp + "</span>";
                str += " <span class='bg-blue lbl-res-vote'><i class='fa fa-pencil'></i> " + vMore + "</span>";
                str += " <span class='bg-dark lbl-res-vote'><i class='fa fa-circle'></i> " + vAbs + "</span>";
                str += " <span class='bg-purple lbl-res-vote'><i class='fa fa-question-circle'></i> " + vUn + "</span>";
                str += " <span class='bg-red lbl-res-vote'><i class='fa fa-thumbs-down'></i> " + vDown + "</span>";
              str += "</div>";
            }

            str += "<div>" + params.description + "</div>";
         
            str += "<div class='tagsContainer text-red'>"+params.tagsLbl+"</div>";


          str += "</div>";
        str += "</div>";
      str += "</div>";

      str += "</div>";
      return str;
    },
    showResultsDirectoryHtml : function ( data, contentType, size, edit){ //size == null || min || max
        mylog.log("START -----------showResultsDirectoryHtml :",Object.keys(data).length +' elements to render');
        mylog.log("showResultsDirectoryHtml data", data,"size",  size, "contentType", contentType)
        //mylog.log(" dirLog",directory.dirLog);
        var str = "";

        directory.colPos = "left";

        if(typeof data == "object" && data!=null)
        $.each(data, function(i, params) {
          if(directory.dirLog) mylog.log("params", params, typeof params);

          mylog.log("params", params, typeof params);

          if ((typeof(params.id) == "undefined") && (typeof(params["_id"]) !== "undefined")) {
            params['id'] = params['_id'];
          } else if (typeof(params.id) == "undefined") {
            params['id'] = Math.random();
            params['type'] = "poi";
          }

          mylog.log("params", params["name"] , params.name, params.id, params["id"], typeof params["id"]);

          if(notNull(params["_id"]) || notNull(params["id"])){

            itemType=(contentType) ? contentType : params.type;
            mylog.log("params itemType", itemType);
            if( itemType ){ 
                if(directory.dirLog) mylog.warn("TYPE -----------"+contentType);
                //mylog.dir(params);
                if(directory.dirLog) mylog.log("itemType",itemType,"name",params.name,"dyFInputs.get( itemType )",dyFInputs.get( itemType ));
                
                var typeIco = i;
                params.size = size;
                params.id = getObjectId(params);
                mylog.log(params.id);
                params.name = notEmpty(params.name) ? params.name : "";
                params.description = notEmpty(params.shortDescription) ? params.shortDescription : 
                                    (notEmpty(params.message)) ? params.message : 
                                    (notEmpty(params.description)) ? params.description : 
                                    "";

                //mapElements.push(params);
                //alert("TYPE ----------- "+contentType+":"+params.name);
                if(typeof edit != "undefined" && edit != false)
                  params.edit = edit;
                
                if(typeof( typeObj[itemType] ) == "undefined") {
                  itemType="poi";
                }

                if( dyFInputs.get( itemType ) == null)
                  itemType="poi";

                typeIco = itemType;
                if(directory.dirLog) mylog.warn("itemType",itemType,"typeIco",typeIco);

                if(typeof params.typeOrga != "undefined")
                  typeIco = params.typeOrga;

                var obj = (dyFInputs.get(typeIco)) ? dyFInputs.get(typeIco) : typeObj["default"] ;
                params.ico =  "fa-"+obj.icon;
                params.color = obj.color;
                if(params.parentType){
                    if(directory.dirLog) mylog.log("params.parentType",params.parentType);
                    var parentObj = (dyFInputs.get(params.parentType)) ? dyFInputs.get(params.parentType) : typeObj["default"] ;
                    params.parentIcon = "fa-"+parentObj.icon;
                    params.parentColor = parentObj.color;
                }
                if(params.type == "classified" && typeof params.category != "undefined"){
                  params.ico = typeof classified.filters[params.category] != "undefined" ?
                               "fa-" + classified.filters[params.category]["icon"] : "";
                }

                params.htmlIco ="<i class='fa "+ params.ico +" fa-2x bg-"+params.color+"'></i>";

                // var urlImg = "/upload/communecter/color.jpg";
                // params.profilImageUrl = urlImg;
                params.useMinSize = typeof size != "undefined" && size == "min";
                params.imgProfil = ""; 
                if(!params.useMinSize)
                    params.imgProfil = "<i class='fa fa-image fa-2x'></i>";

                if("undefined" != typeof params.profilMediumImageUrl && params.profilMediumImageUrl != "")
                    params.imgProfil= "<img class='img-responsive' src='"+baseUrl+params.profilMediumImageUrl+"'/>";

                /*if(dyFInputs.get(itemType) && 
                    dyFInputs.get(itemType).col == "poi" && 
                    typeof params.medias != "undefined" && typeof params.medias[0].content.image != "undefined")
                params.imgProfil= "<img class='img-responsive' src='"+params.medias[0].content.image+"'/>";
                */
                params.insee = params.insee ? params.insee : "";
                params.postalCode = "", params.city="",params.cityName="";
                if (params.address != null) {
                    params.city = params.address.addressLocality;
                    params.postalCode = params.cp ? params.cp : params.address.postalCode ? params.address.postalCode : "";
                    params.cityName = params.address.addressLocality ? params.address.addressLocality : "";
                }
                params.fullLocality = params.postalCode + " " + params.cityName;

                if (false && typeof params.addresses != "undefined" && params.addresses != null) {
                $.each(params.addresses, function(key, val){
                  //console.log("second address", val);
                    var postalCode = val.address.postalCode ? val.address.postalCode : "";
                    var cityName = val.address.addressLocality ? val.address.addressLocality : "";
                    
                    params.fullLocality += "<br>"+ postalCode + " " + cityName;
                  });
                }
                params.type = dyFInputs.get(itemType).col;
                params.urlParent = (notEmpty(params.parentType) && notEmpty(params.parentId)) ? 
                              '#page.type.'+params.parentType+'.id.' + params.parentId : "";

                if( params.type == "poi" && params.source  && params.source.key.substring(0,7) == "convert") {
                  var interop_type = getTypeInteropData(params.source.key);
                  params.type = "poi.interop."+interop_type;
                }

                params.hash = '#page.type.'+params.type+'.id.' + params.id;

                params.onclick = 'urlCtrl.loadByHash("' + params.url + '");';

                // params.tags = "";
                params.elTagsList = "";
                var thisTags = "";
                if(typeof params.tags != "undefined" && params.tags != null){
                  $.each(params.tags, function(key, value){
                    if(typeof value != "undefined" && value != "" && value != "undefined"){
                      var tagTrad = typeof tradCategory[value] != "undefined" ? tradCategory[value] : value;
                      thisTags += "<span class='badge bg-transparent text-red btn-tag tag' data-tag-value='"+slugify(value, true)+"' data-tag-label='"+tagTrad+"'>#" + tagTrad + "</span> ";
                      console.log("sluggify", value, slugify(value, true));
                      params.elTagsList += slugify(value, true)+" ";
                    }
                  });
                  params.tagsLbl = thisTags;
                }else{
                  params.tagsLbl = "";
                }
                params.elRolesList = "";
                var thisRoles = "";
                params.rolesLbl = "";
                if(typeof params.rolesLink != "undefined" && params.rolesLink != null){
                  thisRoles += "<small class='letter-blue'><b>"+trad.roleroles+" :</b> ";
                  thisRoles += params.rolesLink.join(", ");
                  $.each(params.rolesLink, function(key, value){
                    if(typeof value != "undefined" && value != "" && value != "undefined")
                      params.elRolesList += slugify(value)+" ";
                  });
                  thisRoles += "</small>";
                  params.rolesLbl = thisRoles;
                }

                params.updated   = notEmpty(params.updatedLbl) ? params.updatedLbl : null; 
                
                if(directory.dirLog) mylog.log("template principal",params,params.type, itemType);                
                  //template principal
                mylog.log("template principal",params,params.type, itemType);

                if(params.type == "cities")
                  str += directory.cityPanelHtml(params);  
                
                else if( $.inArray(params.type, ["citoyens","organizations","projects","poi","place"])>=0) 
                  str += directory.elementPanelHtml(params);  
                
                else if(params.type == "events")
                  str += directory.eventPanelHtml(params);  
                
                //else if($.inArray(params.type, ["surveys","actionRooms","vote","actions","discuss"])>=0 ) 
                //    str += directory.roomsPanelHtml(params,itemType);  
                
                else if(params.type == "classified"){
                  if(contextData != null)
                    str += directory.elementPanelHtml(params);  
                  else
                    str += directory.classifiedPanelHtml(params);
                }
                else if(params.type == "proposals" || params.type == "actions" || params.type == "rooms")
                  str += directory.coopPanelHtml(params);  
                else if(params.type.substring(0,11) == "poi.interop")
                  str += directory.interopPanelHtml(params);
                else
                  str += directory.defaultPanelHtml(params);
                
            }

          }else{
            if(contentType == "urls")
                str += directory.urlPanelHtml(params, i);
            if(contentType == "contacts")
                str += directory.contactPanelHtml(params, i);
          }
        }); //end each
        mylog.log("END -----------showResultsDirectoryHtml ("+str.length+" html caracters generated)")
        return str;
    },
    getAdminToolBar : function(data){
      countBtn=0;
      var html = "<a href='javascript:;' class='btn btn-default btn-sm btn-add-to-directory bg-white tooltips adminIconDirectory'>"+
       "<i class='fa fa-cog'></i>"+ //fa-bookmark fa-rotate-270
       "</a>";
      html+="<div class='adminToolBar'>";
      if(data.edit=="follows"){
          html +="<button class='btn btn-default btn-xs disconnectConnection'"+ 
            " data-type='"+data.type+"' data-id='"+data.id+"' data-connection='"+data.edit+"' data-parent-hide='2'"+
            " style='bottom:"+(30*countBtn)+"px'>"+
            "<i class='fa fa-unlink'></i> "+trad["unfollow"]+
          "</button> ";
          countBtn++;
      }
      if(data.edit=="organizations" || data.edit=="projects"){
          html +="<button class='btn btn-default btn-xs disconnectConnection'"+ 
            " data-type='"+data.type+"' data-id='"+data.id+"' data-connection='"+data.edit+"' data-parent-hide='3'"+
            " style='bottom:"+(30*countBtn)+"px'>"+
            "<i class='fa fa-unlink'></i> "+trad["cancellink"]+
          "</button> ";
          countBtn++;
      }
     
      if(data.edit=="members" || data.edit=="contributors" || data.edit=="attendees"){
        if(data.type=="organizations" || (typeof data.statusLink["isAdmin"] == "undefined" || typeof data.statusLink["isAdminPending"] != "undefined")){
          html +="<button class='btn btn-default btn-xs disconnectConnection'"+ 
            " data-type='"+data.type+"' data-id='"+data.id+"' data-connection='"+data.edit+"' data-parent-hide='2'"+
            " style='bottom:"+(30*countBtn)+"px'>"+
            "<i class='fa fa-unlink'></i> "+trad["delete"+data.edit]+
          "</button> ";
          countBtn++;
        }
        if(data.type!="organizations" && typeof data.statusLink["isAdmin"] == "undefined"){
          html +='<button class="btn btn-default btn-xs" '+
                   'onclick="connectTo(\''+contextData.type+'\',\''+contextData.id+'\', \''+data.id+'\', \''+data.type+'\', \'admin\',\'\',\'true\')"'+
                   " style='bottom:"+(30*countBtn)+"px'>"+
                            '<i class="fa fa-user-plus"></i> '+trad["addasadmin"]+
                          '</button>';
          countBtn++;
        }
        if(data.type!="organizations" && typeof data.statusLink["toBeValidated"] != "undefined" && typeof data.statusLink["isAdminPending"] == "undefined"){
          html +="<button class='btn btn-default btn-xs acceptAsBtn'"+ 
            " data-type='"+data.type+"' data-id='"+data.id+"' data-connect-validation='toBeValidated' data-parent-hide='2'"+
            " style='bottom:"+(30*countBtn)+"px'>"+
            "<i class='fa fa-user'></i> "+trad["acceptas"+data.edit]+
          "</button> ";
          countBtn++;
        }else if(data.type!="organizations" && typeof data.statusLink["isAdminPending"] != "undefined"){
          html +="<button class='btn btn-default btn-xs acceptAsBtn'"+ 
            " data-type='"+data.type+"' data-id='"+data.id+"' data-connect-validation='isAdminPending' data-parent-hide='2'"+
            " style='bottom:"+(30*countBtn)+"px'>"+
            "<i class='fa fa-user-plus'></i> "+trad["acceptasadmin"]+
          "</button> ";
          countBtn++;
        }
        if(data.edit=="members" || data.edit=="contributors" || data.edit=="attendees"){
          roles="";
          if(typeof data.rolesLink != "undefined")
              roles+=data.rolesLink.join(", ");
          html +="<button class='btn btn-default btn-xs'"+ 
            ' onclick="updateRoles(\''+data.id+'\', \''+data.type+'\', \''+addslashes(data.name)+'\', \''+data.edit+'\',\''+roles+'\')"'+
            " style='bottom:"+(30*countBtn)+"px'>"+
            "<i class='fa fa-pencil'></i> "+trad.addmodifyroles
          "</button> ";
          countBtn++;
        }
      }
     /* if(data.edit=="members" || data.edit=="contributors" || data.edit=="attendees"){ 
          roles=""; 
           if(typeof data.rolesLink != "undefined") 
              roles+=data.rolesLink.join(", "); 
          html +="<button class='btn btn-default btn-xs'"+  
            ' onclick="updateRoles(\''+data.id+'\', \''+data.type+'\', \''+addslashes(data.name)+'\', \''+data.edit+'\',\''+roles+'\')"'+ 
            " style='bottom:"+(30*countBtn)+"px'>"+ 
            "<i class='fa fa-pencil'></i> "+trad.addmodifyroles 
          "</button> "; 
          countBtn++; 
      }*/
    
      html+="</div>";
      return html;
    },
    //builds a small sized list
    buildList : function(list) {
      $(".favSectionBtnNew,.favSection").remove();
      console.warn("START >>>>>> buildList",smallMenu.destination + " #listDirectory");
      
      $.each( list, function(key,slist)
      {
        var subContent = directory.showResultsDirectoryHtml ( slist, key /*,"min"*/); //min == dark template 
        if( notEmpty(subContent) ){
          favTypes.push(typeObj[key].col);
          
          var color = (typeObj[key] && typeObj[key].color) ? typeObj[key].color : "dark";
          var icon = (typeObj[key] && typeObj[key].icon) ? typeObj[key].icon : "circle";
          $(smallMenu.destination + " #listDirectory").append("<div class='"+typeObj[key].col+"fav favSection '>"+
                                            "<div class=' col-xs-12 col-sm-12'>"+
                                            "<h4 class='text-left text-"+color+"'><i class='fa fa-angle-down'></i> "+trad[key]+"</h4><hr>"+
                                            subContent+
                                            "</div>");
          $(".sectionFilters").append(" <a class='text-black btn btn-default favSectionBtn favSectionBtnNew  bg-"+color+"'"+
                                      " href='javascript:directory.showAll(\".favSection\",directory.elemClass);toggle(\"."+typeObj[key].col+"fav\",\".favSection\",1)'> "+
                                          "<i class='fa fa-"+icon+" fa-2x'></i><br>"+trad[key]+
                                        "</a>");
        }
      });

      initBtnLink();
      directory.filterList();
      $(directory.elemClass).show();
      //bindTags();
      console.warn("END >>>>>> buildList");
    },

    getWeekDayName : function(numWeek){
      var wdays = new Array(trad["sunday"],trad["monday"],trad["tuesday"],trad["wednesday"],trad["thursday"],trad["friday"],trad["saturday"],trad["sunday"]);
      if(typeof wdays[numWeek] != "undefined") return wdays[numWeek];
      else return "";
    },
    getMonthName : function(numMonth){
      numMonth = parseInt(numMonth);
      var wdays = new Array("", trad["january"],trad["february"],trad["march"],trad["april"],trad["may"],trad["june"],trad["july"],trad["august"],trad["september"],trad["october"],trad["november"],trad["december"]);
      if(typeof wdays[numMonth] != "undefined") return wdays[numMonth];
      else return "";
    },

    //build list of unique tags based on a directory structure
    //on click hides empty parent sections
    filterList : function  (elClass,dest) { 
        directory.tagsT = [];
        directory.scopesT = [];
        $("#listTags").html("");
        $("#listScopes").html("<h4><i class='fa fa-angle-down'></i> Où</h4>");
        mylog.log("tagg", directory.elemClass);
        $.each($(directory.elemClass),function(k,o){
          
          var oScope = $(o).find(".entityLocality").text();
          //mylog.log("tags count",$(o).find(".btn-tag").length);
          $.each($(o).find(".btn-tag"),function(i,oT){
            var oTag = $(oT).data('tag-value');
            if( notEmpty( oTag ) && !inArray( oTag,directory.tagsT ) ){
              directory.tagsT.push(oTag);
              $("#listTags").append("<a class='btn btn-xs btn-link text-red text-left w100p favElBtn "+slugify(oTag)+"Btn' data-tag='"+slugify(oTag)+"' href='javascript:directory.toggleEmptyParentSection(\".favSection\",\"."+slugify(oTag)+"\",directory.elemClass,1)'><i class='fa fa-tag'></i> "+oTag+"</a><br/>");
            }
          });
          if( notEmpty( oScope ) && !inArray( oScope,directory.scopesT ) ){
            directory.scopesT.push(oScope);
            $("#listScopes").append("<a class='btn btn-xs btn-link text-red text-left w100p favElBtn "+slugify(oScope)+"Btn' href='javascript:directory.searchFor(\""+oScope+"\")'><i class='fa fa-map-marker'></i> "+oScope+"</a><br/>");
          }
        })
        //mylog.log("tags count", directory.tagsT.length, directory.scopesT.length);
    },

    //todo add count on each tag
    filterTags : function (withSearch,open) { 
        directory.tagsT = [];
        $("#listTags").html('');
        if(withSearch){
            $("#listTags").append("<h5 class=''><i class='fa fa-search'></i> "+trad["filtertags"]+"</h5>");
            $("#listTags").append('<input id="searchBarTextJS" data-searchPage="true" type="text" class="input-search form-control">');
        }
        // alert(directory.elemClass);
        // $("#listTags").append("<h4 class=''> <i class='fa fa-tags'></i> trier </h4>");
        $("#listTags").append("<a class='btn btn-link text-red favElBtn favAllBtn' "+
            "href='javascript:directory.toggleEmptyParentSection(\".favSection\",null,directory.elemClass,1)'>"+
            " <i class='fa fa-refresh'></i> <b>"+trad["seeall"]+"</b></a><br/>");
        
        $.each( $(directory.elemClass),function(k,o){
            $.each($(o).find(".btn-tag"),function(i,oT){
                var realTag = $(oT).data('tag-label');
                console.log("realTag", realTag);

                var oTag = $(oT).data('tag-value').toLowerCase();
                if( notEmpty( oTag ) && !inArray( oTag,directory.tagsT ) ){
                  directory.tagsT.push(oTag);
                  //mylog.log(oTag);
                  $("#listTags").append("<a class='btn btn-link favElBtn text-red elipsis "+slugify(oTag)+"Btn' "+
                                            "data-tag='"+slugify(oTag)+"' "+
                                            "href='javascript:directory.toggleEmptyParentSection(\".favSection\",\"."+slugify(oTag)+"\",directory.elemClass,1)'>"+
                                              "#"+realTag+
                                        "</a><br> ");
                }
            });
        });
        if( directory.tagsT.length && open ){
            directory.showFilters();
        }
        //$("#btn-open-tags").append("("+$(".favElBtn").length+")");
    },
    
    sectionFilter : function (list, dest, what, type ) { 
      mylog.log("sectionFilter",list,what,dest);

        if( type == "btn" )
          str = '<label class="col-xs-12 text-left control-label no-padding" for="typeBtn"><i class="fa fa-chevron-down"></i> '+what.title+' </label>'
        else
          str = '<h4 class="margin-top-5 padding-bottom-10 letter-azure label-category" id="title-sub-menu-category">'+
                '<i class="fa fa-'+what.icon+'"></i> </h4><hr>';
        
        $(dest).html(str);
        $.each( list,function(k,o){
            if( type == "btn" ){
              str = '<div class="col-md-4 padding-5 typeBtnC '+k+'"><a class="btn tagListEl btn-select-type-anc elipsis typeBtn '+k+'Btn " data-tag="'+k+'" data-key="'+k+'" href="javascript:;"><i class="fa fa-'+o.icon+'"></i> <br>'+tradCategory[k]+'</a></div>'
            }
            else 
              str = '<button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1 elipsis" style="margin-left:-5px;" data-keycat="'+k+'">'+
                    '<i class="fa fa-'+o.icon+' hidden-xs"></i> '+tradCategory[k]+'</button><br>';
            if( o.subcat && type != "btn" )
            {
              $.each( o.subcat ,function(i,oT){
                  str += '<button class="btn btn-default text-dark margin-bottom-5 margin-left-15 hidden keycat keycat-'+k+'" data-categ="'+k+'" data-keycat="'+oT+'">'+
                          '<i class="fa fa-angle-right"></i> '+tradCategory[oT]+'</button><br class="hidden">';
              });
            }
            $(dest).append(str);
        });
    },
    showFilters : function () { 
      if($("#listTags").hasClass("hide")){
        $("#listTags").removeClass("hide");
        $("#dropdown_search").removeClass("col-md-offset-1");
      }else{
        $("#listTags").addClass("hide");
        $("#dropdown_search").addClass("col-md-offset-1");
      }
      $("#listTags").removeClass("hide");
      $("#dropdown_search").removeClass("col-md-offset-1");
    },

    addMultiTagsAndScope : function() { 
      directory.multiTagsT = [];
      directory.multiScopesT = [];
      $.each(myMultiTags,function(oTag,oT){
        if( notEmpty( oTag ) && !inArray( oTag,directory.multiTagsT ) ){
          directory.multiTagsT.push(oTag);
          //mylog.log(oTag);
          $("#listTags").append("<a class='btn btn-xs btn-link btn-anc-color-blue  text-left w100p favElBtn "+slugify(oTag)+"Btn' data-tag='"+slugify(oTag)+"' href='javascript:directory.searchFor(\"#"+oTag+"\")'><i class='fa fa-tag'></i> "+oTag+"</a><br/>");
        }
      });
      $.each(myMultiScopes,function(oScope,oT){
        var oScope = oT.name;
        if( notEmpty( oScope ) && !inArray( oScope,directory.multiScopesT ) ){
          directory.multiScopesT.push(oScope);
          $("#listScopes").append("<a class='btn btn-xs btn-link text-white text-left w100p favElBtn "+slugify(oScope)+"Btn' data-tag='"+slugify(oScope)+"' href='javascript:directory.searchFor(\""+oScope+"\")'><i class='fa fa-tag'></i> "+oScope+"</a><br/>");
        }
      });
    },

    //show hide parents when empty
    toggleEmptyParentSection : function ( parents ,tag ,children ) { 
        mylog.log("toggleEmptyParentSection('"+parents+"','"+tag+"','"+children+"')");
        var showAll = true;
        if(tag){
          $(".favAllBtn").removeClass("active");
          //apply tag filtering
          $(tag+"Btn").toggleClass("btn-link text-white").toggleClass("active text-white");

          if( $( ".favElBtn.active" ).length > 0 ) 
          {
            showAll = false;
            tags = "";
            $.each( $( ".favElBtn.active" ) ,function( i,o ) { 
              tags += "."+$(o).data("tag")+",";
            });
            tags = tags.replace(/,\s*$/, "");
            mylog.log(tags)
            toggle(tags,children,1);
            
            directory.toggleParents(directory.elemClass);
          }
        }
        
        if( showAll )
          directory.showAll(parents,children);

        $(".my-main-container").scrollTop(0);
    },

    showAll: function(parents,children,path,color) {
      //show all
      if(!color)
        color = "text-white";
      $(".favElBtn").removeClass("active btn-dark-blue").addClass("btn-link ");//+color+" ");
      $(".favAllBtn").addClass("active");
      $(parents).removeClass('hide');
      $(children).removeClass('hide');
    },
    //be carefull with trailing spaces on elemClass
    //they break togglePArents and breaks everything
    toggleParents : function (path) { 
        //mylog.log("toggleParents",parents,children);
        $.each( favTypes, function(i,k)
        {
          if( $(path.trim()+'.'+k).length == $(path.trim()+'.'+k+'.hide ').length )
            $('.'+k+'fav').addClass('hide');
          else
            $('.'+k+'fav').removeClass('hide');
        });
    },

    //fait de la recherche client dans les champs demandé
    search : function(parentClass, searchVal) { 
        mylog.log("searchDir searchVal",searchVal);           
        if(searchVal.length>2 ){
            $.each( $(directory.elemClass) ,function (i,k) { 
                      var found = null;
              if( $(this).find(".entityName").text().search( new RegExp( searchVal, "i" ) ) >= 0 || 
                  $(this).find(".entityLocality").text().search( new RegExp( searchVal, "i" ) ) >= 0 || 
                  $(this).find(".tagsContainer").text().search( new RegExp( searchVal, "i" ) ) >= 0 )
                {
                  //mylog.log("found");
                  found = 1;
                }
                
                if(found)
                    $(this).removeClass('hide');
                else
                    $(this).addClass('hide');
            });

            directory.toggleParents(directory.elemClass);
        } else
            directory.toggleEmptyParentSection(parentClass,null, directory.elemClass ,1);
    },

    searchFor : function (str) { 
      $(".searchSmallMenu").val(str).trigger("keyup");
     },
     //ex : #search:bretagneTelecom:all
  //#search:#fablab
  //#search:#fablab:all:map
   searchByHash :function(hash) 
  { 
    mylog.log("searchByHash *******************", hash);
    if($("#modalMainMenu").hasClass('in'))
      $("#modalMainMenu").modal("hide");

    var mapEnd = false;
    var searchT = hash.split(':');
    // 1 : is the search term
    var search = searchT[1]; 
    scopeBtn = null;
    // 2 : is the scope
    if( searchT.length > 2 )
    {
      if( searchT[2] == "all" )
        scopeBtn = ".btn-scope-niv-5" ;
      else if( searchT[2] == "region" )
        scopeBtn = ".btn-scope-niv-4" ;
      else if( searchT[2] == "dep" )
        scopeBtn = ".btn-scope-niv-3" ;
      else if( searchT[2] == "quartier" )
        scopeBtn = ".btn-scope-niv-2" ;
    }
    mylog.log("search : "+search,searchT, scopeBtn);
    search.replace( "#","" );
    //alert(search.substring(1)); 
    $('#searchTags').val(search);
    startSearch();

    /*if( scopeBtn )
      $(scopeBtn).trigger("click"); */

    /*if( searchT.length > 3 && searchT[3] == "map" )
      mapEnd = true;
    return mapEnd;*/
  },  
  get_time_zone_offset : function( ) {
    var current_date = new Date();
    return -current_date.getTimezoneOffset() / 60;
 },
 getDateFormated: function(params){
    console.log("getDateFormated", params.startDate);
    var timezone = directory.get_time_zone_offset();
    
    params.startDateDB = notEmpty(params.startDate) ? params.startDate : null;
    params.startDay = notEmpty(params.startDate) ? moment(params.startDate/*,"YYYY-MM-DD HH:mm"*/).local().format("DD") : "";
    params.startMonth = notEmpty(params.startDate) ? moment(params.startDate/*,"YYYY-MM-DD HH:mm"*/).local().format("MM") : "";
    params.startYear = notEmpty(params.startDate) ? moment(params.startDate/*,"YYYY-MM-DD HH:mm"*/).local().format("YYYY") : "";
    params.startDayNum = notEmpty(params.startDate) ? moment(params.startDate/*,"YYYY-MM-DD HH:mm"*/).local().format("d") : "";
    params.startTime = notEmpty(params.startDate) ? moment(params.startDate/*,"YYYY-MM-DD HH:mm"*/).local().format("HH:mm") : "";
    params.startDate = notEmpty(params.startDate) ? moment(params.startDate/*,"YYYY-MM-DD HH:mm"*/).local().format("DD MMMM YYYY - HH:mm") : null;
    
    params.endDateDB = notEmpty(params.endDate) ? params.endDate: null;
    params.endDay = notEmpty(params.endDate) ? moment(params.endDate/*,"YYYY-MM-DD HH:mm"*/).local().format("DD") : "";
    params.endMonth = notEmpty(params.endDate) ? moment(params.endDate/*,"YYYY-MM-DD HH:mm"*/).local().format("MM") : "";
    params.endYear = notEmpty(params.startDate) ? moment(params.endDate/*,"YYYY-MM-DD HH:mm"*/).local().format("YYYY") : "";
    params.endDayNum = notEmpty(params.startDate) ? moment(params.endDate/*,"YYYY-MM-DD HH:mm"*/).local().format("d") : "";
    params.endTime = notEmpty(params.endDate) ? moment(params.endDate/*,"YYYY-MM-DD HH:mm"*/).local().format("HH:mm") : "";
    params.endDate   = notEmpty(params.endDate) ? moment(params.endDate/*,"YYYY-MM-DD HH:mm"*/).local().format("DD MMMM YYYY - HH:mm") : null;
    params.startDayNum = directory.getWeekDayName(params.startDayNum);
    params.endDayNum = directory.getWeekDayName(params.endDayNum);

    params.startMonth = directory.getMonthName(params.startMonth);
    params.endMonth = directory.getMonthName(params.endMonth);
    params.color="orange";
    

    var startLbl = (params.endDay != params.startDay) ? trad["fromdate"] : "";
    var endTime = ( params.endDay == params.startDay && params.endTime != params.startTime) ? " - " + params.endTime : "";
    mylog.log("params.allDay", !notEmpty(params.allDay), params.allDay);
   
    
    var str = "";
    if(params.startDate != null){
      str += '<h3 class="letter-'+params.color+' text-bold no-margin" style="font-size:20px;">'+
                  '<small>'+startLbl+' </small>'+
                  '<small class="letter-'+params.color+'">'+params.startDayNum+"</small> "+
                  params.startDay + ' ' + params.startMonth + 
                  ' <small class="letter-'+params.color+'">' + params.startYear + '</small>';
                  if(!notNull(params.allDay) || params.allDay != true){
                    str +=  ' <small class="pull-right margin-top-5"><b><i class="fa fa-clock-o margin-left-10"></i> '+
                              params.startTime+endTime+"</b></small>";
                  }
                  
        str +=  '</h3>';
    }
      
    var dStart = params.startDay + params.startMonth + params.startYear;
    var dEnd = params.endDay + params.endMonth + params.endYear;
    mylog.log("DATEE", dStart, dEnd);

    if(params.endDate != null && dStart != dEnd){
      str += '<h3 class="letter-'+params.color+' text-bold no-margin" style="font-size:20px;">'+
                  "<small>"+trad["todate"]+" </small>"+
                  '<small class="letter-'+params.color+'">'+params.endDayNum+"</small> "+
                  params.endDay + ' ' + params.endMonth + 
                  ' <small class="letter-'+params.color+'">' + params.endYear + '</small>';
                  if(!notNull(params.allDay) || params.allDay != true){
                    str += ' <small class="pull-right margin-top-5"><b><i class="fa fa-clock-o margin-left-10"></i> ' + 
                            params.endTime+"</b></small>";
                  }
        str +=  '</h3>';
    }
        
        
    return str;
  },
}
