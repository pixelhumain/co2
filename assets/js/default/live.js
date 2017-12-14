
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


/*function loadStream(indexMin, indexMax){ console.log("LOAD STREAM FREEDOM");
	loadingData = true;
	currentIndexMin = indexMin;
	currentIndexMax = indexMax;

	//isLive = isLiveBool==true ? "/isLive/true" : "";
	//var url = "news/index/type/citoyens/id/<?php echo @Yii::app()->session["userId"]; ?>"+isLive+"/date/"+dateLimit+"?isFirst=1&tpl=co2&renderPartial=true";
		
	var url = "news/index/type/city/isLive/true/date/"+dateLimit+"?tpl=co2&renderPartial=true&nbCol=2";
	$.ajax({ 
        type: "POST",
        url: baseUrl+"/"+moduleId+'/'+url,
        data: { indexMin: indexMin, 
        		indexMax:indexMax, 
        		renderPartial:true 
        	},
        success:
            function(data) {
                if(data){ //alert(data);
                	$("#news-list").append(data);
                	//bindTags();
					
				}
				loadingData = false;
				$(".stream-processing").hide();
            },
        error:function(xhr, status, error){
            loadingData = false;
            $("#newsstream").html("erreur");
        },
        statusCode:{
                404: function(){
                	loadingData = false;
                    $("#newsstream").html("not found");
            }
        }
    });
}

function loadLiveNow () { 

    var searchParams = {
      "name":"",
      "tpl":"/pod/nowList",
      "latest" : true,
      "searchType" : ["<?php echo Event::COLLECTION?>","<?php echo Project::COLLECTION?>",
      				  "<?php echo Organization::COLLECTION?>","<?php echo ActionRoom::COLLECTION?>"], 
      "searchTag" : $('#searchTags').val().split(','), //is an array
      "searchLocalityCITYKEY" : $('#searchLocalityCITYKEY').val().split(','),
      "searchLocalityCODE_POSTAL" : $('#searchLocalityCODE_POSTAL').val().split(','), 
      "searchLocalityDEPARTEMENT" : $('#searchLocalityDEPARTEMENT').val().split(','),
      "searchLocalityREGION" : $('#searchLocalityREGION').val().split(','),
      "indexMin" : 0, 
      "indexMax" : 10 
    };

    
    /*ajaxPost( "#nowList", baseUrl+"/"+moduleId+'/search/globalautocomplete' , searchParams, function() { 
        bindLBHLinks();
        if($('.el-nowList').length==0)
        	$('.titleNowEvents').addClass("hidden");
        else
        	$('.titleNowEvents').removeClass("hidden");
     } , "html" );
}*/

function showNewsStream(isFirst){ mylog.log("showNewsStream freedom");
	var isFirstParam = isFirst ? "?isFirst=1&tpl=co2" : "?tpl=co2";
	isFirstParam += "&nbCol=2";
	
	var thisType="ko";
	var urlCtrl = ""
	if(liveScopeType == "global") {
		thisType = "city";
		urlCtrl = "/news/index/type/city/isLive/true";
	}

	var searchLocality = getLocalityForSearch();
	mylog.log("searchLocality", searchLocality);
	var dataSearch = {
      //"name" : name, 
      "localities" : searchLocality,
      "searchType" : searchType, 
      "textSearch" : $('#main-search-bar').val(),
      "searchTag" : ($('#searchTags').length ) ? $('#searchTags').val().split(',') : [] ,
      //"indexMin" : indexMin, 
      //"indexMax" : indexMax
    };
	/*<?php if(@Yii::app()->session["userId"]){ ?>
	else if(liveScopeType == "community"){
		thisType = "citoyens";
		urlCtrl = "/news/index/type/citoyens/id/<?php echo @Yii::app()->session["userId"]; ?>/isLive/true";
	}
	<?php } ?>*/
       
    //dataNewsSearch.type = thisType;
    //var myParent = <?php echo json_encode(@$parent)?>;
    //dataNewsSearch.parent = { }

  var loading = "<div class='loader text-dark text-center'>"+
		"<span style='font-size:25px;'>"+
			"<i class='fa fa-spin fa-circle-o-notch'></i> "+
			"<span class='text-dark'>"+trad.currentlyloading+" ...</span>" + 
		"</div>";

	//loading = "";

	if(isFirst){ //render HTML for 1st load
		//if($("#newsstream .loader").length<0){
		//	$("#newsstream").html(loading);
		//}
		ajaxPost("#newsstream",baseUrl+"/"+moduleId+urlCtrl+"/date/0"+isFirstParam,dataSearch, function(news){
			//showTagsScopesMin(".list_tags_scopes");
			 $(window).bind("scroll",function(){ 
	    		if(!loadingData && !scrollEnd){
	         		var heightWindow = $("html").height() - $("body").height();
	         		if( $(this).scrollTop() >= heightWindow - 400){
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
