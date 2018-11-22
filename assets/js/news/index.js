function isLiveGlobal(){
	return (location.hash.indexOf("#live") == 0 || location.hash.indexOf("#freedom") >= 0 || location.hash.indexOf("#city.detail") == 0);
	return typeof liveScopeType != "undefined";// && liveScopeType == "global";
}
/*
* function loadStream() loads news for timeline: 5 news are download foreach call
* @param string contextParentType indicates type of wall news
* @param string contextParentId indicates the precise parent id 
* @param strotime dateLimite indicates the date to load news
*/
var loading = 	"<div class='loader shadow2 letter-blue text-center margin-bottom-50'>"+
					"<span style=''>"+
						"<i class='fa fa-spin fa-circle-o-notch'></i> "+
						"<span>"+trad.currentlyloading+" ...</span>" + 
				"</div>";

var loadStream = function(indexMin, indexMax, type, id){ mylog.log("loadStream");
	loadingData = true;
	currentIndexMin = indexMin;
	currentIndexMax = indexMax;
	if(typeof dateLimit == "undefined") dateLimit = 0;

	//isLive = isLiveBool==true ? "/isLive/true" : "";
	var url = "news/index/type/"+type+"/id/"+id+isLiveNews+"/date/"+dateLimit+"?tpl=co2&renderPartial=true";
	$.ajax({ 
        type: "POST",
        url: baseUrl+"/"+moduleId+'/'+url,
        data: { indexMin: indexMin, 
        		indexMax:indexMax, 
        		renderPartial:true 
        	},
        success:
            function(data) {
                if(data){ 
                	$("#news-list").find(".loader").remove();
                	$("#news-list").append(data);
                	if($("#noMoreNews").length<=0)
						$("#news-list").append(loading);
                	//bindTags();
					
				}
				loadingData = false;
				$(".stream-processing").hide();
            },
        error:function(xhr, status, error){
            loadingData = false;
            $("#news-list").html("erreur");
        },
        statusCode:{
                404: function(){
                	loadingData = false;
                    $("#news-list").html("not found");
            }
        }
    });
	/*loadingData = true;
    indexStep = 5;
    if(typeof indexMin == "undefined") indexMin = 0;
    if(typeof indexMax == "undefined") indexMax = indexStep;

    currentIndexMin = indexMin;
    currentIndexMax = indexMax;
    if(indexMin == 0 && indexMax == indexStep) {
      totalData = 0;
      mapElements = new Array(); 
      $(".newsFeedNews, #backToTop, #footerDropdown").remove();
      scrollEnd = false;
    }
    else{ if(scrollEnd) return; }
    if(isLive != "")
    	simpleUserData="/isLive/true";
    else
    	simpleUserData="";

    
    filter = new Object;
	//filter.parent=parent;
   // if (typeof(locality) != "undefined")   filter.locality=locality;
   // if (typeof(searchBy) != "undefined")   filter.searchBy=searchBy;

	if (typeof(searchType) != "undefined") filter.searchType=searchType;
	//if (typeof(tagSearch) != "undefined") 
	if(isLiveGlobal())
		filter.tagSearch=$('#searchTags').val().split(',');

	//mylog.log("index.js liveScopeType", liveScopeType);
    if(isLiveGlobal() && liveScopeType == "global"){ 
    	 //getMultiTagList(); //$('#searchBarText').val();
		filter = {
			"locality" : getLocalityForSearch(),
			"searchType" : searchType
	    };
	    //contextParentType = "city";
    }	
	//var tagSearch = $('#searchTags').val().split(',');
	if($('#searchTags').length >= 1)
		filter.tagSearch = $('#searchTags').val().split(',');
    filter.textSearch=$('#main-search-bar').length >= 1 ? $('#main-search-bar').val() : "";

    var thisParentId = "";
    if(contextParentType != "city") thisParentId = "/id/"+contextParentId;

	mylog.log("loadStream", dateLimit);
	mylog.dir(filter);
	$(".stream-processing").show();
	$(".search-loader-news").html('<i class="fa fa-spin fa-circle-o-notch"></i>');

    if(typeof(dateLimit)!="undefined"){
		$.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/news/index/type/"+contextParentType+thisParentId+"/date/"+dateLimit+simpleUserData,
	       	dataType: "json",
	       	data: filter,
	    	success: function(data){
		    	mylog.log("LOAD NEWS BY AJAX", data);
		    	//mylog.log(data.news);
		    	if(data){
					buildTimeLine (data.news, indexMin, indexMax);
					bindTags();
					if(typeof(data.limitDate.created) == "object")
						dateLimit=data.limitDate.created.sec;
					else
						dateLimit=data.limitDate.created;

					mylog.log(dateLimit);
				}
				loadingData = false;
				$(".stream-processing").hide();
			},
			error: function(){
				loadingData = false;
				$(".stream-processing").hide();
			}
		});
	}*/
}

var tagsFilterListHTML = "";
var scopesFilterListHTML = "";
/*function buildTimeLine (news, indexMin, indexMax)
{
	mylog.log("-----------------buildTimeLine Editable Test----------------------");
	if (dateLimit==0){
		//$(".newsTL").html('<div class="spine"></div>');
		$(".newsFeedNews, #backToTop, #footerDropdown").remove();
	}
	//insertion du formulaire CreateNews dans le stream
	var formCreateNews = $("#formCreateNewsTemp");
	//currentMonth = null;
	var countEntries = 0;
	$.each(news, function(i, v) { if(v.length!=0){ countEntries++; } });
	
	totalEntries += countEntries;
	
	str = "";
	//mylog.log(news);
	$.each( news , function(key,newsObj)
	{
		//console.log(newsObj);
		if(newsObj.created)
		{
			if(typeof(newsObj.created) == "object")
				var date = new Date( parseInt(newsObj.created.sec)*1000 );
			else
				var date = new Date( parseInt(newsObj.created)*1000 );
			var d = new Date();
			if(typeof(newsObj.target)!="undefined" && typeof(newsObj.target.type)!="undefined")
				buildLineHTML(newsObj, idSession);
			
				
		}
	});
	
	//if(canPostNews==true){
	//	$("#newFeedForm").append(formCreateNews);
	//	$("#formCreateNewsTemp").css("display", "inline");
	//}
	//offsetLastNews="";
	//$i=0;
	//$( ".newsFeed:gt(-6)" ).each(function(){
	//	if($i!=0){
	//		if(typeof(offsetLastNews)!="undefined" && typeof(offsetLastNews.top)!="undefined")
	//		mylog.log(offsetLastNews.top+" // VS // "+$(this).offset().top);
	//		if($(this).offset().top == offsetLastNews.top){
	//			$(this).css("margin-top","20px");
	//		}
	//	}
	//	offsetLastNews=$(this).offset();
		//alert();
	//})
	$.each( news , function(key,o){
		initXEditable();
		manageModeContext(key);
	});
	//offset=$('.newsTL'+' .newsFeed:last').offset(); 
	if( tagsFilterListHTML != "" )
		$("#tagFilters").html(tagsFilterListHTML);
	if( scopesFilterListHTML != "" )
		$("#scopeFilters").html(scopesFilterListHTML);

	if(!countEntries || countEntries < indexStep){
		if( dateLimit == 0 && countEntries == 0){
			var date = new Date(); 
			form ="";

			if(canPostNews==true){ //alert($("#month"+date.getMonth()+date.getFullYear()).length );
				if(!isLiveGlobal() && $("#month"+date.getMonth()+date.getFullYear()).length < 1){
					form ='<div class="date_separator" id="'+'month'+date.getMonth()+date.getFullYear()+'" data-appear-top-offset="-400">'+
				 			'<span>'+months[date.getMonth()]+' '+date.getFullYear()+'</span>'+
				 		 '</div>'+
				 		 "<div class='newsFeed'>"+
							"<div id='newFeedForm"+"' class='timeline_element partition-white no-padding newsFeedForm' style='min-width:85%;'></div>"+
						"</div>";
				}
				msg = "<li class='newsFeed newsFeedNews'><i class='fa fa-ban'></i> Aucun message ne correspond à vos critères de recherche.</li>";
			}
			else{
				msg = "<li class='newsFeed newsFeedNews'><i class='fa fa-ban'></i> Aucun message sur ce journal.</li>";
			}
			scrollEnd = true;
			 // newsTLLine = '<div class="date_separator" id="'+'month'+date.getMonth()+date.getFullYear()+'" data-appear-top-offset="-400">'+
			 // 			'<span>'+months[date.getMonth()]+' '+date.getFullYear()+'</span>'+
			 // 		'</div>';
			newsTLLine = form+"<div class='col-md-5 col-sm-5 col-xs-12 text-extra-large emptyNews newsFeedNews"+"'>"+msg+"</div>";
		
			$(".spine").css("bottom","0px");
			$(".tagFilter, .scopeFilter").hide();
			//$(".date_separator").remove();
			$(".newsTL").append(newsTLLine);

			titleHTML = '<div class="date_separator" id="backToTop" data-appear-top-offset="-400" style="height:150px;">'+
						'<a href="javascript:;" onclick="smoothScroll(\'0px\');" title="retour en haut de page">'+
							'<span style="height:inherit;" class=""><i class="fa fa-ban"></i> ' + trad["nomorenews"] + '<br/><i class="fa fa-arrow-circle-o-up fa-2x"></i> </span>'+
						'</a>'+
					'</div>';//
			$(".newsTL").append(titleHTML);

			if(canPostNews==true){ //alert(isLiveGlobal());
				if(isLiveGlobal()){ 
					$("#newLiveFeedForm").append($("#formCreateNewsTemp"));
					$("#formCreateNewsTemp").css("display", "inline");
					$(".newsFeedForm").css("display", "none");

				}else{ mylog.log("newFeedForm");
					//$("#newLiveFeedForm").append($("#formCreateNewsTemp"));
					$("#newFeedForm").append($("#formCreateNewsTemp"));
					$("#formCreateNewsTemp").css("display", "inline");
				}
			}
		}
		else {
			if($("#backToTop").length <= 0){
				//$('.first')
				titleHTML = '<div class="date_separator" id="backToTop" data-appear-top-offset="-400" style="height:150px;">'+
						'<a href="javascript:;" onclick="smoothScroll(\'0px\');" title="retour en haut de page">'+
							'<span style="height:inherit;" class="homestead"><i class="fa fa-ban"></i> ' + trad["nomorenews"] + '<br/><i class="fa fa-arrow-circle-o-up fa-2x"></i> </span>'+
						'</a>'+
					'</div>';
					$(".newsTL").append(titleHTML);
					$(".spine").css('bottom',"0px");
					scrollEnd = true;
			}else{
				scrollEnd = false;
			}
		}
		
	}
	$(".stream-processing").hide();
	bindEventNews();
	//Unblock message when click to change type stream
	if (dateLimit==0)
		setTimeout(function(){$.unblockUI()},1);
}*/


function bindEventNews(){
	var separator, anchor;
	$("#get_url").elastic();
	$("#get_url").change(function(){
		if($(this).val()!="") $(".form-create-news-container .form-actions .writesomethingplease").remove();
	});
	$(".scopeShare").click(function() {
		mylog.log(this);
		replaceText=$(this).find("h4").html();
		$("#btn-toogle-dropdown-scope").html(replaceText+' <i class="fa fa-caret-down" style="font-size:inherit;"></i>');
		scopeChange=$(this).data("value");
		$("input[name='scope']").val(scopeChange);
		if(scopeChange == "public"){
			if($("#scopeListContainerForm").html()=="") getScopeNewsHtml();
			$("#scopeListContainerForm").show(700);
	  	}else
	  		$("#scopeListContainerForm").hide(700);
	});
	$(".targetIsAuthor").click(function() {
		mylog.log(this);
		srcImg=$(this).find("img").attr("src");
		$("#btn-toogle-dropdown-targetIsAuthor").html('<img height=20 width=20 src="'+srcImg+'"/> <i class="fa fa-caret-down" style="font-size:inherit;"></i>');
		authorTargetChange=$(this).data("value");
		$("#authorIsTarget").val(authorTargetChange);
	});

	$(".date_separator").appear().on('appear', function(event, $all_appeared_elements) {
		separator = '#' + $(this).attr("id");
		$('.timeline-scrubber').find("li").removeClass("selected").find("a[href = '" + separator + "']").parent().addClass("selected");
	}).on('disappear', function(event, $all_disappeared_elements) {   				
		separator = $(this).attr("id");
		$('.timeline-scrubber').find("a").find("a[href = '" + separator + "']").parent().removeClass("selected");
	});
	$('.newsShare').off().on("click",function(){
		toastr.info('TODO : SHARE this news Entry');
		mylog.log("newsShare",$(this).data("id"));
		count = parseInt($(this).data("count"));
		$(this).data( "count" , count+1 );
		$(this).children(".label").html($(this).data("count")+" <i class='fa fa-retweet'></i>");
	});

	$('.filter').off().on("click",function(){
	 	if($(this).data("filter") == ".news" || $(this).data("filter")==".activityStream"){
		 	htmlMessage = '<div class="title-processing homestead"><i class="fa fa-circle-o-notch fa-spin"></i></div>';
		 	htmlMessage +=	'<a class="thumb-info" href="'+proverbs[rand]+'" data-title="Proverbs, Culture, Art, Thoughts"  data-lightbox="all">'+
			 		'<img src="'+proverbs[rand]+'" style="border:0px solid #666; border-radius:3px;"/></a><br/><br/>';
			
			mylog.log(newsReferror);
			if(dateLimit==0){
				$.blockUI({message : htmlMessage});
				loadStream();
			}
			
			if ($("#backToTop"+streamType).length > 0 || $(".emptyNews"+streamType).length > 0){
				if($("#backToTop"+streamType).length > 0){
					$(".tagFilter, .scopeFilter").show();
				}
				else{
					$(".tagFilter, .scopeFilter").hide();
				}
				$(".stream-processing").hide();	
			}
			else{
				$(".stream-processing").show();	
			}
		}
		else{
			mylog.warn("filter",$(this).data("filter"));
			filter = $(this).data("filter");
			$(".newsFeed").hide();
			$(filter).show();
		}
	});

	$(".videoSignal").click(function(){
		videoLink = $(this).find(".videoLink").val();
		iframe='<div class="embed-responsive embed-responsive-16by9">'+
			'<iframe src="'+videoLink+'" width="100%" height="" class="embed-responsive-item"></iframe></div>';
		$(this).parent().next().before(iframe);
		$(this).parent().remove();
	});
}

function smoothScroll(scroolTo){
	$(".my-main-container").scrollTo(scroolTo,500,{over:-0.6});
}

function modifyNews(idNews,typeNews){
	var idNewsUpdate=idNews;
	var typeNewsUpdate=typeNews;
	var commentContent = ($('.newsContent[data-pk="'+idNews+'"] .allText').length) ? $('.newsContent[data-pk="'+idNews+'"] .allText').html() :  $('.newsContent[data-pk="'+idNews+'"] .timeline_text').html();
	var commentTitle = $('.newsTitle[data-pk="'+idNews+'"] .timeline_title').html();
	var message = "<div id='form-news-update'>";
	var scopeTarget=updateNews[idNews].scope.type;
	var newsScope={};
	var newsTargetType=updateNews[idNews].target.type;
	var scopeLabel=contextScopeNews[newsTargetType][scopeTarget].label;
	var scopeIcon=contextScopeNews[newsTargetType][scopeTarget].icon;
	if(notEmpty(commentTitle))
		message += "<input type='text' id='textarea-edit-title"+idNews+"' class='form-control margin-bottom-5' style='text-align:left;' placeholder='Titre du message' value='"+commentTitle+"'>";
	 	
	message += "<div id='container-txtarea-news-"+idNews+"' class='updateMention'>";
		message += 	"<textarea id='textarea-edit-news"+idNews+"' class='form-control newsContentEdit newsTextUpdate get_url_input' placeholder='modifier votre message'>"+commentContent+"</textarea>"+
				   	"<div id='results' class='bg-white results col-sm-12 col-xs-12 margin-top-20'>";
				   	if(typeof updateNews[idNews]["media"] != "undefined"){
				   		if(updateNews[idNews]["media"]["type"]=="url_content")
				   			message += processUrl.getMediaCommonHtml(updateNews[idNews]["media"],"save");
				   		else if(updateNews[idNews]["media"]["type"]=="gallery_files"){
				   			message += getMediaFiles(updateNews[idNews]["media"],idNews, "update")+
				   			"<input type='hidden' class='type' value='gallery_files'>";
				   		}else if (updateNews[idNews]["media"]["type"]=="gallery_images"){
				   			message += getMediaImages(updateNews[idNews]["media"], idNews,null,null, "update")+
				   			"<input type='hidden' class='type' value='gallery_images'>";
				   		}else{
				   			message +='<a href="javascript:;" class="removeMediaUrl"><i class="fa fa-times"></i></a>'+
			                directory.showResultsDirectoryHtml(new Array(updateNews[idNews]["media"]["object"]), updateNews[idNews]["media"]["object"]["type"])+
                			"<input type='hidden' class='type' value='activityStream'>"+
							"<input type='hidden' class='objectId' value='"+updateNews[idNews]["media"]["object"]["id"]+"'>"+
							"<input type='hidden' class='objectType' value='"+updateNews[idNews]["media"]["object"]["type"]+"'>";
				   		}
				   	}
		message +="</div>"+
					'<div class="form-group tagstags col-md-12 col-sm-12 col-xs-12 margin-top-20 no-padding">'+
          				'<input id="tags" type="" data-type="select2" name="tags" placeholder="#Tags" value="" style="width:100%;">'+       
      				"</div>"+
      				'<div class="dropdown no-padding col-md-12 col-sm-12 col-xs-12 margin-bottom-20">'+
          				'<a data-toggle="dropdown" class="btn btn-default col-md-12 col-sm-12 col-xs-12" id="btn-toogle-dropdown-scope-update" href="javascript:;">'+
          					'<i class="fa fa-'+scopeIcon+'"></i> '+scopeLabel+' <i class="fa fa-caret-down" style="font-size:inherit;"></i>'+
          				'</a>'+
          				'<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
          					$.each(contextScopeNews[newsTargetType], function(e, v){
          						if(e != "init"){
          	message+=				'<li>'+
              							'<a href="javascript:;" id="scope-my-network" class="scopeShare" data-value="'+e+'">'+
              								'<h4 class="list-group-item-heading"><i class="fa fa-'+v.icon+'"></i> '+v.label+'</h4>'+
               								'<p class="list-group-item-text small">'+v.explain+'</p>'+
              							'</a>'+
            						'</li>';
          						}
          					});
			message+=   '</ul>'+
			            '<input type="hidden" name="scope" id="scope" value="'+scopeTarget+'"/>'+
	        		'</div>'+
	        		'<div id="scopeListContainerFormUpdate" class="form-group col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom-10"></div>'+
					'<div id="error-update" class="form-group col-xs-12 no-padding margin-bottom-10"></div>'+
				"</div>";
	
	message+="</div>";

	var boxComment = bootbox.dialog({
	  message: message,
	  title: trad.updatethepost,
	  backdrop:true,
	  buttons: {
	  	annuler: {
	      label: trad.cancel,
	      className: "btn-default",
	      callback: function() {
	        mylog.log("Annuler");
	      }
	    },
	    enregistrer: {
	      label: trad.save,
	      className: "btn-success",
	      callback: function() {
	      	$("#btn-submit-form").prop('disabled', true);
			$("#btn-submit-form i").removeClass("fa-arrow-circle-right").addClass("fa-circle-o-notch fa-spin");
			$("#error-update").empty();
			error=[];
			if($("#form-news-update .noGoSaveNews").length)
				error.push("waitendofloading");
			if($("#form-news-update #results").html() == "" && $("#form-news-update .get_url_input").val()== "")
				error.push("writesomethingplease");
			if($("#form-news-update input[name='scope']").val()=="public" && Object.keys(newsScopes).length==0)
				error.push("addplacesplease");
			if(error.length > 0){
				$.each(error, function(e, v){
					$("#error-update").before("<span class='help-block "+v+" italic'>* "+trad[v]+"</span>");
				});
				$("#btn-submit-form i").removeClass("fa-circle-o-notch fa-spin").addClass("fa-arrow-circle-right");
				$("#btn-submit-form").prop('disabled', false);		
				return false;
			}else{
				heightCurrent=$("#"+typeNewsUpdate+idNewsUpdate).find(".timeline-panel").height();
	      		$("#"+typeNewsUpdate+idNewsUpdate).find(".timeline-panel").append("<div class='updateLoading' style='line-height:"+heightCurrent+"px'><i class='fa fa-spin fa-spinner'></i> En cours de modification</div>");
	    		newNews = getNewsObject("#form-news-update", "update");// new Object;
	    		newNews.idNews = idNews;	
				newNews=mentionsInit.beforeSave(newNews, '.newsTextUpdate');	
				$.ajax({
			        type: "POST",
			        url: baseUrl+"/"+moduleId+"/news/update?tpl=co2",
			        data: newNews,
					type: "POST",
			    }).done(function (data) {
		    		if(data)
		    		{
		    			$("#"+typeNewsUpdate+idNewsUpdate).replaceWith(data);
		    			bindEventNews();
		    			toastr.success("Votre publication a bien été modifié");
						return true;
		    		}
		    		else 
		    		{
						toastr.error(data.msg);
		    		}
		    		$("#btn-submit-form i").removeClass("fa-circle-o-notch fa-spin").addClass("fa-arrow-circle-right");
					$("#btn-submit-form").prop('disabled', false);
					return false;
			    }).fail(function(){
				   toastr.error("Something went wrong, contact your admin"); 
				   $("#btn-submit-form i").removeClass("fa-circle-o-notch fa-spin").addClass("fa-arrow-circle-right");
				   $("#btn-submit-form").prop('disabled', false);
			    });
			}
	      }
	    },
	  }
	});

	boxComment.on("shown.bs.modal", function() {
	  $.unblockUI();
	  bindEventTextAreaNews('#textarea-edit-news'+idNews, idNews, updateNews[idNews]);
	});

	/*boxComment.on("hide.bs.modal", function() {
	  $.unblockUI();
	});*/
}
function updateNews(idNews, newText, type){
	var classe1=""; var classe2="";
	if(type == "newsContent") { classe1="text"; classe2=".newsContent"; }else{ classe1="title";classe2=".newsTitle"; }
	updateField("News",idNews,type,newText,false);
	$(classe2+'[data-pk="'+idNews+'"] .timeline_'+classe1).html(newText);
}

function bindEventTextAreaNews(idTextArea, idNews,data/*, isAnswer, parentCommentId*/){
	processUrl.getMediaFromUrlContent(idTextArea,"#results",1);
	if($("#form-news-update #results").html() !="") $("#form-news-update #results").show();
	mentionsInit.get(idTextArea);
	$(".removeMediaUrl").click(function(){
        $trigger=$(this).parents().eq(1).find(idTextArea);
	    $(idTextArea).parents().eq(1).find("#results").empty().hide();
	});
	$(".deleteDoc").click(function(){
		$(this).parent().remove();
		if($(".deleteDoc").length == 0)
			$("#form-news-update  #results").empty().hide();
	});
	autosize($(idTextArea));
	textNews=data.text;
	$(idTextArea).val(textNews);
	if(typeof data.mentions != "undefined" && data.mentions.length != 0)
		$(idTextArea).mentionsInput("update", data.mentions);
	$(idTextArea).on('keyup ', function(e){
		var heightTxtArea = $(idTextArea).css("height");
    	$("#container-txtarea-news-"+idNews).css('height', heightTxtArea);
	});
	$(idTextArea).bind ("input propertychange", function(e){
		var heightTxtArea = $(idTextArea).css("height");
    	$("#container-txtarea-news-"+idNews).css('height', heightTxtArea);
	});
  	$('#form-news-update #tags').select2({tags:tagsNews});
  	$("#form-news-update #tags").select2('val', data.tags);
  	if(data.scope.type == "public"){
  		convertScopeForUpdate(data.scope.localities);
		getScopeNewsHtml("#scopeListContainerFormUpdate");
		$("#scopeListContainerFormUpdate").show(700);
	}
  	$("#form-news-update .scopeShare").click(function() {
		replaceText=$(this).find("h4").html();
		$("#btn-toogle-dropdown-scope-update").html(replaceText+' <i class="fa fa-caret-down" style="font-size:inherit;"></i>');
		scopeChange=$(this).data("value");
		$("#form-news-update input[name='scope']").val(scopeChange);
		if(scopeChange == "public"){
			if($("#scopeListContainerFormUpdate").html()=="") getScopeNewsHtml("#scopeListContainerFormUpdate");
			$("#scopeListContainerFormUpdate").show(700);
	  	}else
	  		$("#scopeListContainerFormUpdate").hide(700);
	});
}

function convertScopeForUpdate(loc){
	newsScopes={};
	$.each(loc, function(e, v){
		if(typeof v.postalCode != "undefined"){
			newsScopes[v.postalCode+"cp"]={
				"type":"cp",
				"name":v.postalCode
			}
		}else if(typeof v.name != "undefined"){
			newsScopes[v.parentId+v.parentType]={
				"type":v.parentType,
				"id":v.parentId,
				"name":v.name
			};
			if(typeof v.cp != "undefined")
				newsScopes[v.parentId+v.parentType]["cp"]=v.cp;
		}
	});
}

function deleteNews(id, type, $this){
	//var $this=$(this);
	bootbox.confirm(trad["suretodeletenews"], 
		function(result) {
			if (result) {
				if ($(".deleteImageIdName"+id).length){
					$(".deleteImageIdName"+id).each(function(){
						deleteInfo=$(this).val().split("|");
						deleteImage(deleteInfo[0],deleteInfo[1],true);
						
					});
				}
				if ($("#deleteImageCommunevent"+id).length){
						imageId=$("#deleteImageCommunevent"+id).val();
						deleteImage(imageId,"",true,true);
				}

				$.ajax({
			        type: "POST",
			        url: baseUrl+"/"+moduleId+"/news/delete/id/"+id,
					//dataType: "json",
					data: {"isLive": isLive},
		        	success: function(data){
			        	if (data) {  
			        		if(typeof data.result != "undefined"){    
			        			if(typeof data.share != "undefined")
			        				toastr.success("Votre partage a été supprimé avec succès!!");
			        			else         
									toastr.success(trad["successdeletenews"] + "!!");
								$("#"+type+id).fadeOut();
							} else {
								toastr.success("Votre partage a été supprimé avec succès!!");
								$("#"+type+id).replaceWith(data);
							}	
						} else {
				            toastr.error(trad["somethingwrong"] + " " + trad["tryagain"]);
				        }
				    }
				});
			}
		}
	)
}

/*function switchModeEdit(idNews){
	if(mode == "view"){
		mode = "update";
		manageModeContext(idNews);
	} else {
		mode ="view";
		manageModeContext(idNews);
	}
}

function manageModeContext(id) {
	listXeditables = [
		//'#newsContent'+id,
		'#newsTitle'+id];
	if (mode == "view") {
		//$('.editable-project').editable('toggleDisabled');
		$.each(listXeditables, function(i,value) {
			$(value).editable('toggleDisabled');
		});
		//$("#btn-update-geopos").removeClass("hidden");
	} else if (mode == "update") {
		// Add a pk to make the update process available on X-Editable
		$('.editable-news').editable('option', 'pk', id);
		$.each(listXeditables, function(i,value) {
			$(value).editable('option', 'pk', id);
			$(value).editable('toggleDisabled');
		});
	}
}
function initXEditable() {
	$.fn.editable.defaults.mode = 'inline';
	$('.editable-news').editable({
    	url: baseUrl+"/"+moduleId+"/news/updatefield", //this url will not be used for creating new job, it is only for update
    	emptytext: 'Empty',
    	textarea: {
			html: true,
			video: true,
			image: true
		},
    	showbuttons: 'bottom',
    	success : function(data) {
	        if(data.result) {
	        	toastr.success(data.msg);

	        	//$('.editable-news').editable('toggleDisabled');
				switchModeEdit(data.id);
				mylog.log(data);
				mylog.log("ici");
				//$("a[data-id='"+data.id+"']").trigger('click');
	        }
	        else{
	        	toastr.error(data.msg);  
	        }
	    }
	});
}*/

 function insertNews(newsObj)
 {
 	var date = new Date( parseInt(newsObj.created.sec)*1000 );
 	if(newsObj.date.sec && newsObj.date.sec != newsObj.created.sec) {
 		date = new Date( parseInt(newsObj.date.sec)*1000 );
 	}
 	var newsTLLine = buildLineHTML(newsObj,idSession,true);
 	$(".emptyNews").remove();
 	$("#newFeedForm").parent().after(newsTLLine).fadeIn();
 	$("#newFeedForm").parent().next().css("margin-top","20px");
 	manageModeContext(newsObj._id.$id);
 	$("#form-news #get_url").val("");
 	$('textarea.mention').mentionsInput('reset');
 	$("#form-news #results").html("").hide();
 	$("#form-news #tags").select2('val', "");
 	showFormBlock(false);
 	$('.tooltips').tooltip();
 	bindEventNews();
 }


function applyTagFilter(str)
{
	$(".newsFeed").fadeOut();
	if(!str){
		if($(".btn-tag.active").length){
			str = "";
			sep = "";
			$.each( $(".btn-tag.active") , function() { 
				str += sep+"."+$(this).data("id");
				sep = ",";
			});
		} else
			str = ".newsFeed";
	} 
	mylog.log("applyTagFilter",str);
	$(str).fadeIn();
	return $(".newsFeed").length;
}

function applyScopeFilter(str)
{
	$(".newsFeed").fadeOut();
	if(!str){
		if($(".btn-context-scope.active").length){
			str = "";
			sep = "";
			$.each( $(".btn-context-scope.active") , function() { 
				str += sep+"."+$(this).data("val");
				sep = ",";
			});
		} else
			str = ".newsFeed";
	} 
	mylog.log("applyScopeFilter",str);
	$(str).fadeIn();
	return $(".newsFeed").length;
}

function toggleFilters(what){
 	if( !$(what).is(":visible") )
 		$('.optionFilter').hide();
 	$(what).slideToggle();
 }
 function getScopeNewsHtml(target){
 	scopeHtml ='<div id="scopes-news-form" class="no-padding">'+
 			'<div id="news-scope-search" class="col-md-12 col-sm-12 col-xs-12 no-padding">'+
	 			'<label class="margin-left-5"><i class="fa fa-angle-down"></i> '+trad.addplacestyournews+'</label><br>'+
	 			'<div class="bg-white padding-10">'+
	            '<div id="input-sec-search" class="hidden-xs col-xs-12 col-md-4 col-sm-4 col-lg-4">'+
	                '<div class="input-group shadow-input-header">'+
	                      '<span class="input-group-addon bg-white addon-form-news"><i class="fa fa-search fa-fw" aria-hidden="true"></i></span>'+
	                      '<input type="text" class="form-control input-global-search" id="searchOnCityNews" autocomplete="off" placeholder="'+trad.searchcity+' ...">'+
	                '</div>'+
	                '<div class="dropdown-result-global-search col-xs-12 col-sm-5 col-md-5 col-lg-5 no-padding" style="max-height: 70%; display: none;"><div class="text-center" id="footerDropdownGS"><label class="text-dark"><i class="fa fa-ban"></i> Aucun résultat</label><br></div>'+
	                '</div>'+
	            '</div>'+
            	'<a href="javascript:;" id="multiscopes-news-btn" class="scopes-btn-news margin-left-20" data-type="multiscopes"><i class="fa fa-star"></i> '+trad.facoritesplaces+'</a>'+
            	'<a href="javascript:;" id="communexion-news-btn" class="scopes-btn-news  margin-left-20" data-type="communexion"><i class="fa fa-home"></i> <span class="communexion-btn-label"></span></a>'+
            	'</div>'+
            '</div>'+
            '<div id="news-scopes-container" class="scopes-container col-md-12 col-sm-12 col-xs-12">'+
            '<hr class="submit">'+
            '</div>'+
            '<div class="col-md-12 col-sm-12 col-xs-12 margin-top-10 no-padding">'+
            	'<label class="margin-left-5"><i class="fa fa-angle-down"></i> '+trad.selectedzones+'</label><br>'+
            '</div>'+
            '<div id="content-added-scopes-container" class="col-md-12 col-sm-12 col-xs-12">';
            if(Object.keys(newsScopes).length > 0){
            	$.each(newsScopes, function(key,value){
            		btnScopeAction="<span class='manageMultiscopes tooltips margin-right-5 margin-left-10' "+
						"data-add='false' data-scope-value='"+value.id+"' "+
						'data-scope-key="'+key+'" '+
						"data-toggle='tooltip' data-placement='top' "+
						"data-original-title='Remove'>"+
							"<i class='fa fa-times-circle'></i>"+
						"</span>";
			    	scopeHtml += "<div class='scope-order text-red' data-level='"+value.level+"'>"+
			    				btnScopeAction+
			    				"<span data-toggle='dropdown' data-target='dropdown-multi-scope' "+
									"class='item-scope-checker item-scope-input' "+
									'data-scope-key="'+key+'" '+
									'data-scope-value="'+value.id+'" '+
									'data-scope-name="'+value.name+'" '+
									'data-scope-type="'+value.type+'" '+
									'data-scope-level="'+value.type+'" ';
									if(notNull(value.level))
										scopeHtml += 'data-level="'+value.level+'"';
									scopeHtml += '>' + 
									value.name + 
								"</span>"+
							"</div>";
			    });
            }

    scopeHtml+='</div>';
        '</div>';
	//actionOnSetGlobalScope="save";
	domForm=(notNull(target))?target:"#scopeListContainerForm";
	$(domForm).html(scopeHtml);
	bindSearchOnNews();
	bindScopesNewsEvent();
	$("#multiscopes-news-btn").trigger("click");
	getCommunexionLabel();
	//countFavoriteScope();
}
function bindSearchOnNews(){
    $("#searchOnCityNews").off().on("keyup", function(e){
    	e.preventDefault();
        if(e.keyCode == 13){
            searchTypeGS = ["cities"];
            startGlobalSearch(0, 30, "#scopes-news-form");
         }
    });
}
function bindScopesNewsEvent(news){

	mylog.log("bindScopesNewsEvent", news);

	$(".manageMultiscopes, #news-scopes-container .item-scope-checker").off().on("click", function(){
		mylog.log("manageMultiscopes");
		addScope=$(this).data("add");
		scopeValue=$(this).data("scope-value");
		key=$(this).data("scope-key");
		mylog.log("manageMultiscopes key scopeValue addScope", key, scopeValue, addScope);
		if(addScope){
			newScope=myScopes[myScopes.typeNews][key];
			newScope.active=true;
			newsScopes[key] = newScope;
			//$(this).attr("data-add",false).attr("data-original-title","Remove");
			$("span[data-scope-key='"+key+"']").attr("data-add",false).attr("data-original-title","Remove");
			//$(this).find("i").removeClass("fa-plus-circle").addClass("fa-times-circle");
			$(this).parent().find(".manageMultiscopes i").removeClass("fa-plus-circle").addClass("fa-times-circle");
			pushHtml=$(this).parent().get();
			$(this).parent().remove();
			mylog.log("manageMultiscopes pushHtml", pushHtml);
			$("#content-added-scopes-container").append(pushHtml);
			$(".addplacesplease").remove();
			bindScopesNewsEvent();
		}else{
			mylog.log("manageMultiscopes remove", key, newsScopes);
			delete newsScopes[key];
			$(this).parent().remove();
		}
	});
	
	$("#multiscopes-news-btn, #communexion-news-btn").off().on("click", function(){
		mylog.log("#multiscopes-news-btn, #communexion-news-btn");
		$(".scopes-btn-news").removeClass("active");
		$(this).addClass("active");
		myScopes.typeNews=$(this).data("type");
		//$(this).find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
		$("#scopes-news-form .scopes-container").html(constructScopesHtml(true));
		if(myScopes.typeNews=="communexion")
				$("#scopes-news-form .scopes-container .scope-order").sort(sortSpan) // sort elements
                  .appendTo("#scopes-news-form .scopes-container");
        bindScopesNewsEvent();
	});
}
/*
* Save news and url generate
*
*/
function showFormBlock(bool){
	if(bool){
		$(".form-create-news-container #text").show("fast");
		$(".form-create-news-container .tagstags").show("fast");
		$(".form-create-news-container .datedate").show("fast");
		$(".form-create-news-container .form-actions").show("fast");
		$(".form-create-news-container .publiccheckbox").show("fast");
		$(".form-create-news-container .tools_bar").show("fast");
		$(".form-create-news-container .scopescope").show("fast");
		/////multiTagScopeLbl("send");
		if(isLiveGlobal() || $(".form-create-news-container input[name='scope']").val()=="public")
			scopeHtml=getScopeNewsHtml();
		
		$('.extract_url').show();
		$(".form-create-news-container #falseInput").hide();
		$('#get_url').focus();
		
		$("#toogle_filters").hide();	
		$(".form-create-news-container #btn-slidup-scopetags").hide("fast");
		//if(typeof slidupScopetagsMin != "undefined") slidupScopetagsMin(false);
		
	}else{
		$(".form-create-news-container #text").hide();
		$(".form-create-news-container .tagstags").hide();
		$(".form-create-news-container .datedate").hide();
		$(".form-create-news-container .form-actions").hide();
		$(".form-create-news-container .publiccheckbox").hide();
		$(".form-create-news-container .tools_bar").hide();
		$(".form-create-news-container .scopescope").hide();
		$("#scopeListContainerForm").html("");
		$("#container-scope-filter").show();
		$(".item-globalscope-checker").prop('disabled', false);
		//SCOPE DIV//
		$('.extract_url').hide();
		$(".form-create-news-container #falseInput").show();
		
		$("#toogle_filters").show();	
		$(".form-create-news-container #btn-slidup-scopetags").show("fast");
		//if(typeof slidupScopetagsMin != "undefined") slidupScopetagsMin(true);
		
	}
}

function saveNews(){
	var formNews = $('#form-news');
	var errorHandler2 = $('.errorHandler', formNews);
	var successHandler2 = $('.successHandler', formNews);

	var validation = {
		submitHandler : function(form) {
			$('#modalLogin').modal("show");
		}
	};
	if(userId != null && userId != ""){
		$("#btn-submit-form").prop('disabled', true);
		$("#btn-submit-form i").removeClass("fa-arrow-circle-right").addClass("fa-circle-o-notch fa-spin");
		$(".form-create-news-container .form-actions .help-block").remove();
		error=[];
		if($(".noGoSaveNews").length)
			error.push("waitendofloading");
		if($("#form-news #results").html() == "" && $("#form-news #get_url").val()== "")
			error.push("writesomethingplease");
		if($("input[name='scope']").val()=="public" && Object.keys(newsScopes).length==0)
			error.push("addplacesplease");
		if(error.length > 0){
			$.each(error, function(e, v){
				$("#btn-submit-form").before("<span class='help-block "+v+" italic'>* "+trad[v]+"</span>");
			});
			$("#btn-submit-form i").removeClass("fa-circle-o-notch fa-spin").addClass("fa-arrow-circle-right");
			$("#btn-submit-form").prop('disabled', false);		
		}else{
			newNews=getNewsObject("#form-news");
			newNews=mentionsInit.beforeSave(newNews, 'textarea.mention');
			$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/news/save?tpl=co2",
		        //dataType: "json",
		        data: newNews,
				type: "POST",
		    })
		    .done(function (data) {
	    		if(data)
	    		{
	    			$("#form-news #get_url").val("");
	    			mentionsInit.reset('textarea.mention');
					newsScopes={};
					$("#form-news #results").html("").hide();
					$("#form-news #tags").select2('val', "");
					showFormBlock(false);
	    			$("#news-list").prepend(data);
	    			bindEventNews();
		    		toastr.success(trad["successsavenews"]);
		    	}
		    	else 
		    		toastr.error(data.msg);
	    		
	    		$("#btn-submit-form i").removeClass("fa-circle-o-notch fa-spin").addClass("fa-arrow-circle-right");
				$("#btn-submit-form").prop('disabled', false);
				return false;
		    }).fail(function(){
			   toastr.error("Something went wrong, contact your admin"); 
			   $("#btn-submit-form i").removeClass("fa-circle-o-notch fa-spin").addClass("fa-arrow-circle-right");
			   $("#btn-submit-form").prop('disabled', false);
		    });
		}
	}
}

function getNewsObject(formId, actionType){
	newNews = {
		text : $(formId+" .get_url_input").val(),
		scope : $(formId+" input[name='scope']").val(),
	};
	
	var actionType=(notNull(actionType))? actionType : "save";
	
	if($(formId+" #results").html() != ""){
		newNews.media=new Object;	
		newNews.media.type=$(formId+" #results .type").val();
		if(newNews.media.type=="url_content"){
			if($(formId+" #results .name").length)
				newNews.media.name=$(formId+" #results .name").val();
			if($(formId+" #results .description").length)
				newNews.media.description=$(formId+" #results .description").val();
			newNews.media.content=new Object;
			newNews.media.content.type=$(formId+" #results .media_type").val(),
			newNews.media.content.url=$(formId+" #results .url").val(),
			newNews.media.content.image=$(formId+" #results .img_link").val();
			if($(formId+" #results .size_img").length)
				newNews.media.content.imageSize=$(formId+" #results .size_img").val();
			if($(formId+" #results .video_link_value").length)
				newNews.media.content.videoLink=$(formId+" #results .video_link_value").val();
		}else if(newNews.media.type=="activityStream"){
			newNews.media.object={
				"id":$(formId+" #results .objectId").val(),
				"type":$(formId+" #results .objectType").val()
			}
		}
		else if(newNews.media.type=="gallery_images"){
			newNews.media.type=$(formId+" #results .type").val(),
			newNews.media.countImages=$(formId+" #results .docsId").length;
			if(newNews.media.countImages>0){
				newNews.media.images=[];
				$(formId+" #results .docsId").each(function(){
					newNews.media.images.push($(this).val());	
				});	
			}else if(actionType=="update")
				newNews.media="unset";
		}
		else if($(formId+" #results .type").val()=="gallery_files"){
			newNews.media.countFiles=$(formId+" #results .docsId").length;
			if(newNews.media.countFiles>0){
				newNews.media.files=[];
				$(".docsId").each(function(){
					newNews.media.files.push($(this).val());	
				});
			}else if(actionType=="update")
				newNews.media="unset";		
		}
	}else if(actionType=="update")
		newNews.media="unset";
	
	if ($(formId+" #tags").val() != "")
		newNews.tags = $(formId+" #tags").val().split(",");

	if(actionType=="save"){		
		newNews.parentId = $(formId+" #parentId").val(),
		newNews.parentType = $(formId+" #parentType").val(),
		newNews.type = $(formId+" input[name='type']").val();
	}
	
	if(newNews.scope=="public")
		newNews.localities = newsScopes;

	if($(formId+' #authorIsTarget').length && $(formId+' #authorIsTarget').val()==1)
		newNews.targetIsAuthor = true;
	
	return newNews;
}

function showAllNews(){
	$(".newsFeed").show();
	$('.optionFilter').hide();
}

function initFormImages(){
	$("#photoAddNews").on('submit',(function(e) {
		e.preventDefault();
		if(contextParentType=="city" || contextParentType=="pixels"){
			contextParentType = "citoyens";
			contextParentId = idSession;
		}
		$.ajax({
			url : baseUrl+"/"+moduleId+"/document/uploadSave/dir/communecter/folder/"+contextParentType+"/ownerId/"+contextParentId+"/input/newsImage/docType/image/contentKey/slider",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false, 
			processData: false,
			dataType: "json",
			success: function(data){
				if(debug)mylog.log(data);
	  		    if(data.result){
				    toastr.success(data.msg);
				    //setTimeout(function(){
				    $(".imagesNews").last().val(data.id.$id);
				    $(".imagesNews").last().attr("name","");
				    $(".newImageAlbum").last().find("img").removeClass("grayscale");
				    $(".newImageAlbum").last().find("i").remove();
				    $(".newImageAlbum").last().append("<a href='javascript:;' onclick='deleteImage(\""+data.id.$id+"\",\""+data.name+"\")'><i class='fa fa-times fa-x padding-5 text-white removeImage' id='deleteImg"+data.id.$id+"'></i></a>");
				    //},200);
		
				} else{
					toastr.error(data.msg);
					if($("#results img").length>1)
				  		$(".newImageAlbum").last().remove();
				  	else{
				  		$("#results").empty();
				  		$("#results").hide();
				  	}
				}
				$("#addImage").off();
				$(".form-create-news-container .form-actions .waitendofloading").remove();
			}
		});
	}));
}

function addMoreSpace(){
	bootbox.dialog({
	message: "You have attempt the limit of 20Mo of images for this "+contextParentType+"<br/>Please choose one of those  two solutions beyond:<br/>Delete images in the <a href='javascript:;' onclick='bootbox.hideAll();urlCtrl.loadByHash(\"#gallery.index.id."+contextParentId+".type."+contextParentType+"\")'>photo gallery</a> <br/><br/>OR<br/><br/> Subscribe 12€ to the NGO Open Atlas which takes in charge communecter.org on <a href='https://www.helloasso.com/associations/open-atlas' target='_blank'>helloAsso</a> for 20Mo more. <br/><br/>Effectively, stocking images represents a cost for us and donate to the NGO will demonstrate your contribution the project and to the common we built together",
  title: "Limit of <color class='red'>20 Mo</color> overhead"
  });
}

function showMyImage(fileInput) {
	if($(".noGoSaveNews").length){
		toastr.info(trad.waitendofloading);
	}
	else if (fileInput.files[0].size > 2097152){
		toastr.info("Please reduce your image before to 2Mo");
	}
	else {
		countImg=$("#results img").length;
		idImg=countImg+1;
		htmlImg="";
		var files = fileInput.files;
		if(countImg==0){
			htmlImg = "<input type='hidden' class='type' value='gallery_images'/>";
			htmlImg += "<input type='hidden' class='count_images' value='"+idImg+"'/>";
			htmlImg += "<input type='hidden' class='algoNbImg' value='"+idImg+"'/>";
			nbId=idImg;
			$("#results").show();
		}
		else{
			nbId=$(".algoNbImg").val();
			nbId++;
			$(".count_images").val(idImg);
			$(".algoNbImg").val(nbId);
		}
		htmlImg+="<div class='newImageAlbum'><i class='fa fa-spin fa-circle-o-notch fa-3x text-green spinner-add-image noGoSaveNews'></i><img src='' id='thumbail"+nbId+"' class='grayscale' style='width:75px; height:75px;'/>"+
		       	"<input type='hidden' class='imagesNews docsId' name='goSaveNews' value=''/></div>";
		$("#results").append(htmlImg);
	    for (var i = 0; i < files.length; i++) {           
	        var file = files[i];
	        var imageType = /image.*/;     
	        if (!file.type.match(imageType)) {
	            continue;
	        }           
	        var img=document.getElementById("thumbail"+nbId);            
	        img.file = file;    
	        var reader = new FileReader();
	        reader.onload = (function(aImg) { 
	            return function(e) { 
	                aImg.src = e.target.result; 
	            }; 
	        })(img);
	        reader.readAsDataURL(file);
	    }  
		$("#photoAddNews").submit();	  
	}
}

function getMediaImages(o,newsId,authorId,targetName, actionType){
	countImages=o.images.length;
	html="";
			console.log("image",o.images);
	if(typeof actionType != "undefined" && actionType=="update"){
		for(var i in o.images){
	
			html+="<div class='updateImageNews'><img src='"+o.images[i].imageThumbPath+"' style='width:75px; height:75px;'/>"+
		       	"<a href='javascript:;' class='btn-red text-white deleteDoc'><i class='fa fa-times text-dark'></i></a>"+
					"<input type='hidden' class='docsId' value='"+o.images[i]._id.$id+"'></div>";
		}
		return html;
	}
	else if(typeof actionType != "undefined" && actionType=="directory"){
		//path=baseUrl+"/"+uploadUrl+"communecter/"+o.images[0].folder+"/"+o.images[0].name;
		html+="<img src='"+o.images[0].imagePath+"' class='img-responsive'>";
	}else{
		if(countImages==1){
			path=o.images[0].imagePath;
			html+="<div class='col-md-12 no-padding margin-top-10'><a class='thumb-info' href='"+path+"' data-title='album de "+targetName+"'  data-lightbox='all"+newsId+"'><img src='"+path+"' class='img-responsive' style='max-height:200px;'></a></div>";
		}
		else if(countImages==2){
			for(var i in o.images){
				path=o.images[i].imagePath;
				html+="<div class='col-md-6 padding-5'><a class='thumb-info' href='"+path+"' data-title='abum de "+targetName+"'  data-lightbox='all"+newsId+"'><img src='"+path+"' class='img-responsive' style='max-height:200px;'></a></div>";
			}
		}
		else if(countImages==3){
			col0="6";
			height0="400";
			absoluteImg="position:absolute;";
			if (typeof liveScopeType != "undefined" && liveScopeType == "global"){
				col0="12";
				height0="260";
				absoluteImg="";
			}
			for(var i in o.images){
				path=o.images[i].imagePath;
				if(i==0){
				html+="<div class='col-md-"+col0+" padding-5' style='position:relative;height:"+height0+"px;overflow:hidden;'><a class='thumb-info' href='"+path+"' data-title='abum de "+targetName+"'  data-lightbox='all"+newsId+"'><img src='"+path+"' class='img-responsive' style='"+absoluteImg+"min-height:100%;min-width:100%;'></a></div>";
				}else{
				html+="<div class='col-md-6 padding-5' style='position:relative; height:200px;overflow:hidden;'><a class='thumb-info' href='"+path+"' data-title='abum de "+targetName+"'  data-lightbox='all"+newsId+"'><img src='"+path+"' class='img-responsive' style='"+absoluteImg+"min-height:100%;min-width:100%;'></a></div>";	
				}
			}
		}
		else if(countImages==4){
			absoluteImg="position:absolute;";
			if (typeof liveScopeType != "undefined" && liveScopeType == "global")
				absoluteImg="";
			for(var i in o.images){
				path=o.images[i].imagePath;
				html+="<div class='col-md-6 padding-5' style='position:relative;height:250px;overflow:hidden;'><a class='thumb-info' href='"+path+"' data-title='abum de "+targetName+"'  data-lightbox='all"+newsId+"'><img src='"+path+"' class='img-responsive' style='"+absoluteImg+"min-height:100%;min-width:100%;height:auto;'></a></div>";
			}
		}
		else if(countImages>=5){
			absoluteImg="position:absolute;";
			if (typeof liveScopeType != "undefined" && liveScopeType == "global")
				absoluteImg="";
			for(var i in o.images){
				path=o.images[i].imagePath;
				if(i==0)
					html+="<div class='col-md-12 no-padding'><div class='col-md-6 padding-5' style='position:relative;height:260px;overflow:hidden;'><a class='thumb-info' href='"+path+"' data-title='abum de "+targetName+"'  data-lightbox='all"+newsId+"'><img src='"+path+"' class='img-responsive' style='"+absoluteImg+"min-height:100%;min-width:100%;'></a></div>";
				else if(i==1){
					html+="<div class='col-md-6 padding-5' style='position:relative;height:260px;overflow:hidden;'><a class='thumb-info' href='"+path+"' data-title='abum de "+targetName+"'  data-lightbox='all"+newsId+"'><img src='"+path+"' class='img-responsive' style='"+absoluteImg+"height:100%;width:100%;'></a></div></div>";
				}
				else if(i<5){
					html+="<div class='col-md-4 padding-5' style='position:relative;height:160px;overflow:hidden;'><a class='thumb-info' href='"+path+"' data-title='abum de "+targetName+"'  data-lightbox='all"+newsId+"'><img src='"+path+"' class='img-responsive' style='"+absoluteImg+"height:100%;width:100%;'>";
					if(i==4 && countImages > 5){
						diff=countImages-5;
						html+="<div style='position: absolute;top:5px;left:5px;right:5px;bottom:5px;background-color: rgba(0,0,0,0.4);color: white;text-align: center;line-height: 150px;font-size: 50px;'><span>+ "+diff+"</span></div>";
					}
					html+="</a></div>";
				} else{
					html+="<a class='thumb-info' href='"+path+"' data-title='abum de "+targetName+"'  data-lightbox='all"+newsId+"'></a>";	
				}
			}
		}
	}
	return html;
}

function getMediaFiles(o,newsId, edit){
	html="";
	for(var i in o.files){
		path=o.files[i].docPath;
		html+="<div class='col-md-12 padding-5 shadow2 margin-top-5'>"+
			"<a href='"+path+"' target='_blank'>"+documents.getIcon(o.files[i].contentKey)+" "+o.files[i].name+"</a>";
			if(typeof edit != "undefined" && edit=="update"){
				html+="<a href='javascript:;' class='btn-red text-white deleteDoc'><i class='fa fa-times text-dark'></i></a>"+
					"<input type='hidden' class='docsId' value='"+o.files[i]._id.$id+"'>";
			}
		html +="</div>";
	}
	return html;
}
	
function deleteImage(id,name,hideMsg,communevent){
	var imgToDelete=id;
	if(communevent==true)
		path="communevent";
	else
		path="commuencter";
	$.ajax({
			url : baseUrl+"/"+moduleId+"/document/delete/dir/"+moduleId+"/type/"+contextParentType+"/id/"+contextParentId,			
			type: "POST",
			data: {"name": name, "parentId": contextParentId, "parentType": contextParentType, "path" : path, "ids" : [id]},
			dataType: "json",
			success: function(data){
				if(data.result){
					if(hideMsg!=true){
						countImg=$("#results img").length;
						$("#deleteImg"+imgToDelete).parents().eq(1).remove();
						idImg=countImg-1;
						if(idImg==0){
							$("#results").empty().hide();
						}
						else{
							$(".count_images").val(idImg);
						}
							toastr.success(data.msg);
					}
				}
				else{
					toastr.error(data.msg);
				}
			}
	});
}


