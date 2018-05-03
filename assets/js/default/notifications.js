var notifications = null;
var maxNotifTimestamp = 0;
var indexMinNotif=0;
var endLoadingNotifs=false;
function showNotif(show){
	if(typeof show == "undefined"){
		if($("#notificationPanelSearch").css("display") == "none") show = true; 
    	else show = false;
    }

    if(show){
    	endLoadingNotifs=false;
    	$('#notificationPanelSearch').show("fast");
    	markAllAsSeen(false,"");
    	refreshNotifications(userId,"citoyens","");
    }
	else 	 $('#notificationPanelSearch').hide("fast");

	
	$("#dropdown-user").removeClass("open");
    $("#dropdown-dda").removeClass("open");
    
    showFloopDrawer(false);
}

function bindNotifEvents(element, event, elementType, elementId ){ console.log("bindNotifEvents");
	$(".notifList"+element+" a.notif").off().on("click",function (e) 
	{
		markAsRead( $(this).data("id") );
		hash = $(this).data("href");
		elem = $(this).parent();
		//elem.removeClass('animated bounceInRight').addClass("animated bounceOutRight");
		//elem.removeClass("enable");
		var thisJQ = this;
		setTimeout(function(){
          //  elem.addClass("read");
            //elem.removeClass('animated bounceOutRight');
            if(e.which==2)
				window.open(baseUrl+hash, '_blank');
			else{
				console.log("objtype", $(thisJQ).data("objtype"));
				if($(thisJQ).data("objtype") == "proposals" || 
					$(thisJQ).data("objtype") == "actions" || $(thisJQ).data("objtype") == "resolutions"){
					var objType = $(thisJQ).data("objtype");
					 uiCoop.getCoopDataPreview(objType.substr(0, objType.length-1), $(thisJQ).data("objid"));
				}else{
	            	urlCtrl.loadByHash(hash);
	            }
			}
            //notifCount();
        }, 200);
	});

	$('.tooltips').tooltip();

	$(".notifList"+element+" li").mouseenter(function(){
		$(this).find(".removeBtn").show();
	}).mouseleave(function(){
		$(this).find(".removeBtn").hide();
	});

	$('.pageslide-list').off().on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight && !endLoadingNotifs) {
            indexMinNotif=indexMinNotif+15;
            getAjaxNotification(element, "scroll", elementType, elementId);
    	}
    });
    $(".btn-reload-notif").off().on("click", function(){
    	$(this).find("i").addClass("fa-spin");
    	$(".notifList"+$(this).data("element")).html("<li class='col-xs-12 loadingProcessIndicators text-center'><i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyloading+"</li>");
    	indexMinNotif=0;
    	maxNotifTimestamp=0;
        getAjaxNotification($(this).data("element"), null, $(this).data("type"), $(this).data("id"));
        $(this).find("i").removeClass("fa-spin");
    });
	
}
function updateNotification(action, element, id)
{ 
	var action = action;
	var all = true;
	data = new Object;
	if(id != null){
		var notifId=id;
		all=false;
		data.id=id
	} else {
		data.action=action;
		data.all=all;
	}
	//ajax remove Notifications by AS Id
	$.ajax({
        type: "POST",
        url: baseUrl+"/"+moduleId+"/notification/update",
        data: data,
        dataType : 'json'
    })
    .done( function (data) {
    	mylog.dir(data);
        if ( data && data.result ) {
        	if(action=="seen"){  
        		$(".notifList"+element+" li.notifLi").addClass("seen");
        		notifCount(0);
        	}else{           
        		if(all)
        			$(".notifList"+element+" li.notifLi").addClass("read");
        		else
        			$(".notifList"+element+" li.notif_"+notifId).addClass("read");
        	}
        	mylog.log("notification cleared ",data);
        } else {
            toastr.error("no notifications found ");
        }

    });
}
function markAllAsSeen(){
	updateNotification("seen","");
}
function markAsRead(id){
	updateNotification("read","", id);
}
function markAllAsRead(element)
{ 
	updateNotification("read",element);
}
function removeNotification(id)
{ // Ancienne markAsRead
	mylog.log("markAsRead",id);
	//ajax remove Notifications by AS Id
	$.ajax({
        type: "POST",
        url: baseUrl+"/"+moduleId+"/notification/marknotificationasread",
        data: { "id" : id },
        dataType : 'json'
    })
    .done( function (data) {
    	//mylog.dir(data);
        if ( data && data.result ) {               
        	$("li.notif_"+id).remove();
        	mylog.log("notification cleared ",data);
        } else {
            toastr.error("no notifications found ");
        }
        //notifCount();
    });
}

function removeAllNotifications()
{ 
	//Ancienne markAllAsRead
	$.ajax({
        type: "POST",
        url: baseUrl+"/"+moduleId+"/notification/removeall",
        dataType : 'json'
    })
    .done( function (data) {
    	mylog.dir(data);
        if ( data && data.result ) {  
        	$(".notifList"+element).html("<li class='col-md-12 col-sm-12 col-xs-12'><i class='fa fa-ban'></i> "+trad.noNotifs+"</li>");  
        } else {
            toastr.error("no notifications found ");
        }
        //notifCount();
    });
	
}

function refreshNotifications(elementId,elementType,element)
{
	//ajax get Notifications
	//$(".pageslide-list.header .btn-primary i.fa-refresh").addClass("fa-spin");
	//mylog.log("refreshNotifications", maxNotifTimestamp);
	//var element = element;
	/*if(typeof event != "undefined" && event)
		var event=event;
	else
		var event=null;*/
	//indexMinNotif=0;
	event=(maxNotifTimestamp!=0) ? "refresh" : null;
	getAjaxNotification(element, event, elementType, elementId);
}
function getAjaxNotification(element, event, elementType, elementId){

	if(notNull(event) && event=="refresh"){
		param={refreshTimestamp: maxNotifTimestamp};
	}else{
		param={indexMin: indexMinNotif};
	}
	$.ajax({
        type: "POST",
        url: baseUrl+"/"+moduleId+"/notification/getnotifications/type/"+elementType+"/id/"+elementId,
        data: param
    })
    .done(function (data) { mylog.log("REFRESH NOTIF : "); mylog.dir(data);
        if (data) {
        	buildNotifications(data.notif, element, event, elementType, elementId);
        	if(typeof data.countNotif != "undefined")
        		notifCount(data.countNotif, element);
        	if(data.coop > 0){
        		$(".btn-dashboard-dda").show();
        		$(".coopNotifs").html(data.coop).show(100);
        	}
        	else{
        		//$(".btn-dashboard-dda").hide();
        		//$(".coopNotifs").html("");
        	}
        } else {
            toastr.error("no notifications found ");
        }
        $(".pageslide-list.header .btn-primary i.fa-refresh").removeClass("fa-spin");
    }).fail(function(){
    	toastr.error("error notifications");
        $(".pageslide-list.header .btn-primary i.fa-refresh").removeClass("fa-spin");
    });
}
function buildNotifications(list, element, event, elementType, elementId)
{	
	notifHtml="";
	var countCurrentNotif= Object.keys(list).length;
	if(event!="refresh")
		$(".loadingProcessIndicators").remove();
	if(typeof list != "undefined" && typeof list == "object"){
		$.each( list , function( notifKey , notifObj )
		{
			//console.log("build notif", notifObj);
			var url = (typeof notifObj.notify != "undefined") ? notifObj.notify.url : "#";
			//convert url to hash for loadByHash
			if(url.indexOf("communecter/")>0){
				url=url.split("communecter/");
				url=url[1];	
			}
			url = "#"+url.replace(/\//g, ".");
			momentNotif=notifObj.timeAgo;
			var icon = (typeof notifObj.notify != "undefined") ? notifObj.notify.icon : "fa-bell";
			var displayName = (typeof notifObj.notify != "undefined") ? notifObj.notify.displayName : "Undefined notification";
			var isSeen = (typeof notifObj.notify.id[userId] != "undefined" && typeof notifObj.notify.id[userId].isUnseen != "undefined") ? "" : "seen";
			var isRead = (typeof notifObj.notify.id[userId] != "undefined" && typeof notifObj.notify.id[userId].isUnread != "undefined") ? "" : "read";

			var notifObjType = (typeof notifObj.object != "undefined" && typeof notifObj.object.type != "undefined") ? 
								notifObj.object.type : "";

			var notifObjId = (typeof notifObj.object != "undefined" && typeof notifObj.object.id != "undefined") ? 
								notifObj.object.id : "";

			str = "<li class='notifLi notif_"+notifKey+" "+isSeen+" "+isRead+" hide'>"+
					/*if(event==null)
						str+="hide";
					else
						str+="enable";
				str+="'>"+*/
					"<a href='javascript:;' class='notif col-xs-12 no-padding' "+
						"data-objtype='"+notifObjType+"' data-objid='"+notifObjId+"' data-id='"+notifKey+"' data-href='"+ url +"'>"+
						"<div class='content-icon col-md-1 col-sm-1 col-xs-1 no-padding'>"+
							"<span class='label bg-dark pull-left'>"+
								'<i class="fa '+icon+'"></i>'+
							"</span>" +
						"</div>"+ 
						"<div class='col-md-10 col-sm-10 col-xs-10 no-padding'>"+
							'<span class="message pull-left">'+
								displayName+
							"</span>" + 
							
							"<span class='time pull-left'>"+momentNotif+"</span>"+
						"</div>"+
					"</a>"+
					"<a href='javascript:;' class='label removeBtn tooltips' onclick='removeNotification(\""+notifKey+"\")' data-toggle='tooltip' data-placement='left' title='Delete' style='display:none;'>"+
							'<i class="fa fa-remove"></i>'+
						"</a>" + 
				  "</li>";
			//if(event==null){
			//	$(".notifList"+element).append(str);
			
			//}else{
				notifHtml+=str;
			//}
			if( notifObj.timestamp > maxNotifTimestamp )
				maxNotifTimestamp = notifObj.timestamp;
		});
		setTimeout( function(){
	    	//notifCount(false, element);
	    	bindNotifEvents(element, event, elementType, elementId);
	    	//bindLBHLinks();
	    }, 800);
	    //Usecase of the first load of notification
	    /*if(event == null){
			$(".notifList"+element).html(notifHtml);
			$(".notifLi").addClass("col-md-12 col-sm-12 col-xs-12");
		}*/
		// Initialization of notifications
		if(event==null){
			$(".notifList"+element).html(notifHtml);
		}else if(event=="refresh"){
			$(".notifList"+element).prepend(notifHtml);
	    	indexMinNotif=indexMinNotif+countCurrentNotif;
		}else if(event=="scroll"){
			$(".notifList"+element).append(notifHtml);
		}
		$(".notifList"+element+" li.notifLi").not(".enable").removeClass('hide').addClass("animated bounceInRight enable col-md-12 col-sm-12 col-xs-12");
		// Add loader or indication if event is different then refresh notifications
	    if(event!="refresh"){
		    if(countCurrentNotif< 15){
		    	$(".notifList"+element).append("<li class='col-xs-12 text-center'><i class='fa fa-ban'></i> "+trad.noMoreNotifs+"</li>");
		    	endLoadingNotifs=true;	
		    }else{
		    	if(countCurrentNotif==0 && indexMinNotif==0)
					$(".notifList"+element).html("<li class='col-md-12 col-sm-12 col-xs-12'><i class='fa fa-ban'></i> "+trad.noNotifs+"</li>");
		    	else
		    		$(".notifList"+element).append("<li class='col-xs-12 loadingProcessIndicators text-center'><i class='fa fa-spin fa-circle-o-notch'></i> "+trad.currentlyloading+"</li>");
		    }
		}
	}
}

function notifCount(upNotifUnseen, element)
{ 	var countNotif = $(".notifList"+element+" li.enable").length;
	var countNotifSeen = $(".notifList"+element+" li.seen").length;
	var countNotifUnseen = countNotif-countNotifSeen;
	//if(upNotifUnseen)
	//	countNotifUnseen=0;
	//$(".notifCount").html( countNotif );
	//	mylog.log("if( countNotifUnseen", countNotifUnseen, " > 0");
		if( upNotifUnseen > 0)
		{
		    $(".notifications-count"+element).html(upNotifUnseen);
			$('.notifications-count'+element).removeClass('hide');
			$('.notifications-count'+element).addClass('animated bounceIn');
			$('.notifications-count'+element).addClass('badge-success');
			$('.notifications-count'+element).removeClass('badge-tranparent');
			$(".markAllAsRead").show();
		} else {
			//$('.notifications-count').addClass('hide');
			$(".notifications-count"+element).html("");
			$('.notifications-count'+element).addClass('hide');
			$('.notifications-count'+element).removeClass('badge-success');
			$('.notifications-count'+element).addClass('badge-tranparent');
			$(".markAllAsRead").hide();
		}
	//}
}