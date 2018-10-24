
var liveScopeType = "global";
function initLiveInterface(){
	$("#main-btn-start-search, .menu-btn-start-search").click(function(){
        var search = $("#main-search-bar").val();
        startWebSearch(search, currentCategory);
    });

    $("#second-search-bar").keyup(function(e){
        $("#main-search-bar").val($("#second-search-bar").val());
        $("#input-search-map").val($("#second-search-bar").val());
        if(e.keyCode == 13){
            var search = $(this).val();
            startWebSearch(search, currentCategory);
         }
    });
    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($("#main-search-bar").val());
        $("#input-search-map").val($("#main-search-bar").val());
        if(e.keyCode == 13){
            var search = $(this).val();
            startWebSearch(search, currentCategory);
         }
    });
    $("#input-search-map").keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        $("#main-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            var search = $(this).val();
            startWebSearch(search, currentCategory);
         }
    });

    $("#menu-map-btn-start-search").click(function(){
        var search = $("#input-search-map").val();
        startWebSearch(search, currentCategory);
    });
}


/*function bindCommunexionScopeEvents(){
	$(".btn-decommunecter").off().click(function(){
		activateGlobalCommunexion(false);
		showTagsScopesMin();
        rebuildSearchScopeInput();
        $('.tooltips').tooltip(); 
  	});
  	$(".item-globalscope-checker").off().click(function(){  
            $(".item-globalscope-checker").addClass("inactive");
            $(this).removeClass("inactive");

            mylog.log("globalscope-checker",  $(this).data("scope-name"), $(this).data("scope-type"));
            setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"),
                             $(this).data("insee-communexion"), $(this).data("name-communexion"), $(this).data("cp-communexion"), 
                             $(this).data("region-communexion"), $(this).data("country-communexion"), actionOnSetGlobalScope ) ;
    });

    $(".start-new-communexion").off().click(function(){  
        activateGlobalCommunexion(true);
    });
}*/
/*function initFilterLive(){
	dataNewsSearch = {
	      "searchLocalityCITYKEY" : $('#searchLocalityCITYKEY').val().split(','),
	      "searchLocalityCODE_POSTAL" : $('#searchLocalityCODE_POSTAL').val().split(','), 
	      "searchLocalityDEPARTEMENT" : $('#searchLocalityDEPARTEMENT').val().split(','),
	      "searchLocalityREGION" : $('#searchLocalityREGION').val().split(','),

	};
	console.log(dataNewsSearch);
    dataNewsSearch.tagSearch = $('#searchTags').val().split(',');
    dataNewsSearch.searchType = searchType; 
    dataNewsSearch.textSearch = $('#main-search-bar').val();
 }   */

function initFreedomInterface(){
	
	initFormImages();

	//loadLiveNow();
}

var timeout;
function startNewsSearch(isFirst){
	//Modif SBAR
	//$(".my-main-container").off();
	//if(liveScopeType == "global"){
	dateLimit=0;
	isFirst=true;
	showNewsStream(isFirst);
	/*$(".start-new-communexion").click(function(){  
        setGlobalScope( $(this).data("scope-value"), $(this).data("scope-name"), $(this).data("scope-type"),
                                 $(this).data("insee-communexion"), $(this).data("name-communexion"), $(this).data("cp-communexion"),
                                  $(this).data("region-communexion"), $(this).data("country-communexion"),actionOnSetGlobalScope) ;
        activateGlobalCommunexion(true);
	});*/
	//}else{
	//	showNewsStream(isFirst);//loadStream(0,5);
	//}
	//loadLiveNow();
}



function showNewsStream(isFirst){ mylog.log("showNewsStream freedom");
	var isFirstParam = isFirst ? "?isFirst=1&tpl=co2" : "?tpl=co2";
	isFirstParam += "&nbCol=2";
	
	var thisType="ko";
	var urlCtrl = ""
	if(liveScopeType == "global") {
		thisType = "city";
		urlCtrl = "/news/index/type/city/isLive/true";
	}
	var dataSearch=constructSearchObjectAndGetParams();
	//var searchLocality = getSearchLocalityObject();
	//mylog.log("searchLocality", searchLocality);
	/*var dataSearch = {
      //"name" : name, 
      "localities" : searchLocality,
      "searchType" : searchType, 
      "textSearch" : searchObject.text,
      "searchTag" : ($('#searchTags').length ) ? $('#searchTags').val().split(',') : [] ,
    };*/
  var loading = "<div class='loader bold letter-blue shadow2 text-center'>"+
					"<i class='fa fa-spin fa-circle-o-notch'></i> "+
					"<span>"+trad.currentlyloading+" ...</span>" + 
				"</div>";

	if(isFirst){ //render HTML for 1st load
		$("#newsstream").html(loading);
		simpleScroll(0, 500);
		//KScrollTo("#container-scope-filter");
		ajaxPost("#newsstream",baseUrl+"/"+moduleId+urlCtrl+"/date/0"+isFirstParam,dataSearch, function(news){
			//showTagsScopesMin(".list_tags_scopes");
			 $(window).bind("scroll",function(){ 
	    		if(!loadingData && !scrollEnd){
	         		var heightWindow = $("html").height() - $("body").height();
	         		if( $(this).scrollTop() >= heightWindow - 1000){
	            		//loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep);
	            		showNewsStream(false);
	          		}
	    		}
			});
			if(loadContent != ''){
				if(userId){
					//showFormBlock(true);
					if(loadContent.indexOf("%hash%"))
						loadContent = loadContent.replace("%hash%", "#");
					$("#get_url").val(loadContent);
					$("#get_url").trigger("input");
				}
				else {
					toastr.error('you must be loggued to post on communecter!');
				}
			}
			//else
			//	showFormBlock(false);
			spinSearchAddon();
			bindTags();
			if($("#noMoreNews").length<=0)
				$("#newsstream").append(loading);
			
			//$("#formCreateNewsTemp").appendTo("#modal-create-anc #formCreateNews");
			//$("#info-write-msg").html("<?php echo Yii::t("common","Write a public message visible on the wall of selected places") ?>");
			//$("#info-write-msg").html("Conseil : donnez un maximum de détails");
			//showFormBlock(true);
			//$("#formCreateNewsTemp").html("");

	 	},"html");
	}else{ //data JSON for load next
		//dateLimit=0;currentMonth = null;
		loadingData = true;
		//if($("#newsstream .loader").length<0){
		//	alert();
		//	$("#newsstream").append(loading);
		//}
		console.log("data",dataSearch);
		$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+urlCtrl+"/date/"+dateLimit+"?tpl=co2&renderPartial=true&nbCol=2",
		       	data: dataSearch,
		    	success: function(data){
					if(data){
						$("#newsstream").find(".loader").remove();
						$("#news-list").append(data);
						if($("#noMoreNews").length<=0)
							$("#newsstream").append(loading);
						//buildTimeLine (data.news, 0, 5);
						//bindTags();
						//if(typeof(data.limitDate.created) == "object")
						//	dateLimit=data.limitDate.created.sec;
						//else
						//	dateLimit=data.limitDate.created;
					}
					loadingData = false;
				},
				error: function(){
					loadingData = false;
				}
			});
	}
	$("#dropdown_search").hide(300);

	
}

function addSearchType(type){
  var index = searchType.indexOf(type);
  if (index == -1) {
    searchType.push(type);
    $(".search_"+type).removeClass("fa-circle-o");
    $(".search_"+type).addClass("fa-check-circle-o");
  }
    mylog.log(searchType);
}
function removeSearchType(type){
  var index = searchType.indexOf(type);
  if (index > -1) {
    searchType.splice(index, 1);
    $(".search_"+type).removeClass("fa-check-circle-o");
    $(".search_"+type).addClass("fa-circle-o");
  }
  mylog.log(searchType);
}

function hideNewLiveFeedForm(){
	//$("#newLiveFeedForm").hide(200);
	showFormBlock(false);
}
