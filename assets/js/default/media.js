
function initMediaInterface(){
	//init loading in scroll
    $(window).bind("scroll",function(){ 
	    if(!loadingData && !scrollEnd){
	          var heightWindow = $("html").height() - $("body").height();
	          if( $(this).scrollTop() >= heightWindow - 400){
	            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep);
	          }
	    }
	});

	$(".btn-select-media-src").click(function(){
		var src = $(this).data("srcid");
		var srcActive = $(this).data("srcactive");
		console.log("srcactive", srcActive, sources);
		if(srcActive==true){
			if(sources.length == 1){
				//toastr.error("Looooongin ! Impossible de désactiver toutes les sources en même temps !");
				/*setTimeout(function(){
					toastr.error("Nan mé... t'as cru koi ?");
					setTimeout(function(){
						toastr.error("Fou la flème !..");
					}, 1000);
				}, 1500);*/
				return;
			}
			for(var i = sources.length; i--;){
				if (sources[i] === src) sources.splice(i, 1);
				$(this).data("srcactive", false);
				$(".src"+src+" .srcActive").addClass("hidden");
				$(".src"+src+" .srcDisable").removeClass("hidden");
			}
		}else{
			sources.push(src);
			$(this).data("srcactive", true);
			$(".src"+src+" .srcActive").removeClass("hidden");
			$(".src"+src+" .srcDisable").addClass("hidden");
		}
		startReloadTimeout();
		console.log("srcactive", srcActive, sources);
		
	});

    //btn to load media data for first time (if no media found)
	$("#main-btn-start-search, #main-search-bar-addon, .menu-btn-start-search").click(function(){
		$("#timeline-live").html("");
		loadStream(0, indexStep);
	});

    $("#second-search-bar").keyup(function(e){
        $("#main-search-bar").val($("#second-search-bar").val());
        $("#input-search-map").val($("#second-search-bar").val());
        if(e.keyCode == 13){
            $("#timeline-live").html("");
			loadStream(0, indexStep);
         }
    });
    $("#main-search-bar").keyup(function(e){
        $("#second-search-bar").val($("#main-search-bar").val());
        $("#input-search-map").val($("#main-search-bar").val());
        if(e.keyCode == 13){
            $("#timeline-live").html("");
			loadStream(0, indexStep);
         }
    });
    $("#input-search-map").keyup(function(e){
        $("#second-search-bar").val($("#input-search-map").val());
        $("#main-search-bar").val($("#input-search-map").val());
        if(e.keyCode == 13){
            $("#timeline-live").html("");
			loadStream(0, indexStep);
         }
    });

    $("#menu-map-btn-start-search, #main-search-bar-addon").click(function(){
        $("#timeline-live").html("");
			loadStream(0, indexStep);
    });

   	$('#main-search-bar, #second-search-bar, #input-search-map').filter_input({regex:'[^@#\"\`/\(|\)/\\\\]'}); //[a-zA-Z0-9_] 
    

    $("#btn-show-sources-xs").click(function(){
    	if($(".medias-sources").hasClass("hidden-xs")){
    		$(".medias-sources").removeClass("hidden-xs");
    	}else{
    		$(".medias-sources").addClass("hidden-xs");
    	}
    });
}



function startReloadTimeout(){
	$("#timeline-live").html("");
	$("#timeline-reload").html("<i class='fa fa-circle'></i> "+
								"<i class='fa fa-circle'></i> "+
								"<i class='fa fa-circle'></i>"+
								"<hr style='margin-top: 34px;'>");
        var sec = 3;
        if(typeof interval != "undefined") clearInterval(interval);
        interval = setInterval(function(){ 
        	if(sec == 1){
        		loadStream(0, indexStep);
        		$("#timeline-reload").html("");
				$("#timeline-live").html("");
        		clearInterval(interval);
        	}
        	else{
        		sec--;
        		var str = "";
        		for(n=0;n<sec;n++) str += "<i class='fa fa-circle'></i> ";
        		str += "<hr style='margin-top: 34px;'>";
        		$("#timeline-reload").html(str);
        	}
        }, 800);
}


var sources = new Array("NC1", "NCI", "NCTV", "TAZAR", "OUTREMERS360");

function loadStream(indexMin, indexMax){ console.log("load stream media");
	if(indexMin == 0) scrollEnd = false;

	loadingData = true;
	currentIndexMin = indexMin;
	currentIndexMax = indexMax;
	var search = $("#main-search-bar").val();


    if(indexMin == 0){
    	$("#timeline-live").html("");
       	KScrollTo("#content-media");
    }

	$.ajax({ 
        type: "POST",
        url: baseUrl+"/"+moduleId+"/app/media",
        data: { indexMin: indexMin, 
        		indexMax:indexMax,
        		sources: sources,
        		search: search, 
        		renderPartial:true
        	},
        success:
            function(html) {
                $("#timeline-live").append(html);
                $(".medias-sources").hasClass("hidden-xs");
                loadingData = false;
            },
        error:function(xhr, status, error){
            loadingData = false;
            $("#timeline-live").html("erreur");
        },
        statusCode:{
                404: function(){
                	loadingData = false;
                    $("#timeline-live").html("not found");
            }
        }
    });
}


//lance le chargement des commentaires pour une publication
function showMediaComments(id){
		if(!$("#commentContent"+id).hasClass("hidden")){
			$(".commentContent").html("");
			$(".commentContent").removeClass("hidden");		
			
			$('#commentContent'+id).html('<div class="text-dark margin-bottom-10"><i class="fa fa-spin fa-refresh"></i> Chargement des commentaires ...</div>');
			getAjax('#commentContent'+id ,baseUrl+'/'+moduleId+"/comment/index/type/media/id/"+id,function(){ 
				
			},"html");
		}else{
			$("#commentContent"+id).removeClass("hidden");		
			mylog.log("scroll TO : ", $('#newsFeed'+id).position().top);
			
		}
}

/* COMMENTS vvv */


/*function initCommentsTools(thisMedias){
  //ajoute la barre de commentaire & vote up down signalement sur tous les medias
  $.each(thisMedias, function(key, media){
    if(typeof media._id != "undefined"){
		media.target = "media";
	    
	    var commentCount = 0;
	    idMedia=media._id['$id'];
	    if ("undefined" != typeof media.commentCount) 
	      commentCount = media.commentCount;
	    
	    idSession = typeof idSession != "undefined" ? idSession : false;

	    var lblCommentCount = '';
	    if(commentCount == 0 && idSession) lblCommentCount = "<i class='fa fa-comment'></i>  Commenter";
	    if(commentCount == 1) lblCommentCount = "<i class='fa fa-comment'></i> <span class='nbNewsComment'>" + commentCount + "</span> commentaire";
	    if(commentCount > 1) lblCommentCount = "<i class='fa fa-comment'></i> <span class='nbNewsComment'>" + commentCount + "</span> commentaires";
	    if(commentCount == 0 && !idSession) lblCommentCount = "0 <i class='fa fa-comment'></i> ";

	    lblCommentCount = '<a href="javascript:" class="newsAddComment letter-blue" data-media-id="'+idMedia+'">' + 
	    					lblCommentCount + 
	    				  '</a>';

        var voteTools = voteCheckAction(media._id['$id'], media);

	    voteTools = lblCommentCount + voteTools;

	    $("#footer-media-"+media._id['$id']).html(voteTools);
	}
  });

  $(".newsAddComment").click(function(){
    var id = $(this).data("media-id");
    showMediaComments(id);
  });
}*/

/* COMMENTS ^^^ */