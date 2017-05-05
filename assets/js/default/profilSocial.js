function initDateHeaderPage(params){
	var str = directory.getDateFormated(params);
	$(".section-date").prepend(str);
}

function getCroppingModal(){
	
}
function menuLeftShow(){
	if($("#menu-left-container").hasClass("hidden-xs"))
		$("#menu-left-container").removeClass("hidden-xs");
	else
		$("#menu-left-container").addClass("hidden-xs");
}
function responsiveMenuLeft(menuTop){
	if($(window).width()<768)
		menuLeftShow();
	if(menuTop){
		if($(window).width()>768)
			$(".ssmla").removeClass('active');
	}
}
function bindButtonMenu(){
	$("#btn-superadmin").click(function(){
		loadAdminDashboard();
	});
	$(".btn-start-newsstream").click(function(){
		//$(".ssmla").removeClass('active');
		responsiveMenuLeft(true);
		history.pushState(null, "New Title", hashUrlPage);
		loadNewsStream(true);
	});
	$(".btn-start-mystream").click(function(){
		//$(".ssmla").removeClass('active');
		responsiveMenuLeft(true);
		if(contextData.type=="citoyens" && userId==contextData.id)
			history.pushState(null, "New Title", hashUrlPage+".view.mystream");
		else
			history.pushState(null, "New Title", hashUrlPage);
		loadNewsStream(false);
	});
	$("#btn-start-gallery").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.gallery");
		//location.search="?view=gallery";
		loadGallery();
	});
	$(".btn-start-notifications").click(function(){
		//$(".ssmla").removeClass('active');
		responsiveMenuLeft(true);
		history.pushState(null, "New Title", hashUrlPage+".view.notifications");
		//location.search="?view=notifications";
		loadNotifications();
	});
	$(".btn-start-chart").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.chart");
		loadChart();
	});
	$("#btn-show-activity").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.history");
		loadHistoryActivity();
	});
	
	$(".open-confidentiality").click(function(){
		responsiveMenuLeft();
		mylog.log("open-confidentiality");
		toogleNotif(false);
		smallMenu.open( dataHelper.markdownToHtml($("#descriptionMarkdown").val()));
		bindLBHLinks();
	});

	$(".open-directory").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.directory");
		loadDirectory();
	});
	$(".edit-chart").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.editChart");
		loadEditChart();
	});
	$(".btn-open-collection").click(function(){
		responsiveMenuLeft();
		toogleNotif(false);
	});

	$("#btn-start-detail").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.detail");
		loadDetail();
	});

	$(".load-data-directory").click(function(){
		responsiveMenuLeft();
		var dataName = $(this).data("type-dir");
		console.log(".load-data-directory", dataName);
		loadDataDirectory(dataName, $(this).data("icon"));
	});
		
	$("#subsubMenuLeft a").click(function(){
		$("#subsubMenuLeft a").removeClass("active");
		$(this).addClass("active");
	});

	$("#btn-start-urls").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.urls");
		loadUrls();
	});

	$("#btn-start-contacts").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.contacts");
		loadContacts();
	});

	$("#btn-hide-desc").click(function(){
		if($("#desc-event").hasClass("hidden")){
			$("#desc-event").removeClass("hidden");
			$("#btn-hide-desc").html("<i class='fa fa-angle-up'></i> masquer");
		}else{
			$("#desc-event").addClass("hidden");
			$("#btn-hide-desc").html("<i class='fa fa-angle-down'></i> afficher la description");
		}
	});

	$("#btn-update-password").off().on( "click", function(){
		var form = {
			saveUrl : baseUrl+"/"+moduleId+"/person/changepassword",
			dynForm : {
				jsonSchema : {
					title : trad["Change password"],
					icon : "fa-key",
					afterSave : function(data){
						dyFObj.closeForm();
					},
					properties : {
						mode : dyFInputs.inputHidden(),
						userId : dyFInputs.inputHidden(),
						oldPassword : dyFInputs.password(trad["Old password"]),
						newPassword : dyFInputs.password("", { required : true, minlength : 8 } ),
						newPassword2 : dyFInputs.password(trad["Repeat your new password"], {required : true, minlength : 8, equalTo : "#ajaxFormModal #newPassword"})	
					}
				}
			}
		};

		var dataUpdate = {
			mode : "changePassword",
	        userId : userId
	    };
		dyFObj.openForm(form, null, dataUpdate);
	});

	$("#downloadProfil").click(function () {
		$.ajax({
			url: baseUrl + "/communecter/data/get/type/citoyens/id/"+contextData.id ,
			type: 'POST',
			dataType: 'json',
			async:false,
			crossDomain:true,
			complete: function () {},
			success: function (obj){
				mylog.log("obj", obj);
				$("<a/>", {
				    "download": "profil.json",
				    "href" : "data:application/json," + encodeURIComponent(JSON.stringify(obj))
				  }).appendTo("body")
				  .click(function() {
				    $(this).remove()
				  })[0].click() ;
			},
			error: function (error) {
				
			}
		});
	});

    $(".confidentialitySettings").click(function(){
    	param = new Object;
    	param.type = $(this).attr("type");
    	param.value = $(this).attr("value");
    	param.typeEntity = contextData.type;
    	param.idEntity = contextData.id;
		$.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/element/updatesettings",
	        data: param,
	       	dataType: "json",
	    	success: function(data){
		    	toastr.success(data.msg);
		    }
		});
	});

	$("#editConfidentialityBtn").on("click", function(){
    	mylog.log("confidentiality", seePreferences);
    	$("#modal-confidentiality").modal("show");
    	if(seePreferences=="true"){
    		param = new Object;
	    	param.name = "seePreferences";
	    	param.value = false;
	    	param.pk = contextData.id;
			$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextData.type,
		        data: param,
		       	dataType: "json",
		    	success: function(data){
			    	//toastr.success(data.msg);
			    	if(data.result){
						$("#divSeePreferencesHeader").addClass("hidden");
						$('#editConfidentialityBtn').removeClass("btn-red");
			    	}
			    }
			});
    	}
    	
    });

	$(".panel-btn-confidentiality .btn").click(function(){
		var type = $(this).attr("type");
		var value = $(this).attr("value");
		$(".btn-group-"+type + " .btn").removeClass("active");
		$(this).addClass("active");
	});

	initBtnShare();

}

function loadDataDirectory(dataName, dataIcon){
	showLoader('#central-container');
	// $('#central-container').html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");return;
	getAjax('', baseUrl+'/'+moduleId+'/element/getdatadetail/type/'+contextData.type+
				'/id/'+contextData.id+'/dataName/'+dataName+'?tpl=json',
				function(data){ 
					displayInTheContainer(data, dataName, dataIcon);
				}
	,"html");
}

function getLabelTitleDir(dataName, dataIcon, countData, n){
	mylog.log("bgetLabelTitleDir", dataName, dataIcon, countData, n)
	var elementName = "<span class='Montserrat' id='name-lbl-title'>"+$("#nameHeader .name-header").html()+"</span>";
	
	var s = (n>1) ? "s" : "";
	var html = "<i class='fa fa-"+dataIcon+" fa-2x margin-right-10'></i> <i class='fa fa-angle-down'></i> ";
	if(dataName == "follows")	{ html += elementName + " est <b>abonné</b> à " + countData + " page"+s+""; }
	else if(dataName == "followers")	{ html += countData + " <b>abonné"+s+"</b> à " + elementName; }
	else if(dataName == "members")	{ html += elementName + " est composé de " + countData + " <b>membre"+s+"</b>"; }
	else if(dataName == "attendees")	{ html += countData + " <b>invité"+s+"</b> à l'événement " + elementName; }
	else if(dataName == "contributors")	{ html += countData + " <b>contributeur"+s+"</b> au projet " + elementName; }
	
	else if(dataName == "events"){ 
		if(type == "events"){
			html += elementName + " est composé de " + countData+" <b> sous-événement"+s; 
		}else{
			html += elementName + " participe à " + countData+" <b> événement"+s; 
		}
	}
	else if(dataName == "organizations")	{ html += elementName + " est membre de " + countData+" <b>organisation"+s; }
	else if(dataName == "projects")		{ html += elementName + " contribue à " + countData+" <b>projet"+s }

	else if(dataName == "collections"){ html += countData+" <b>collection"+s+"</b> de " + elementName; }
	else if(dataName == "poi"){ html += countData+" <b>point"+s+" d'intérêt"+s+"</b> créé"+s+" par " + elementName; }
	else if(dataName == "classified"){ html += countData+" <b>annonce"+s+"</b> créée"+s+" par " + elementName; }

	else if(dataName == "needs"){ html += countData+" <b>besoin"+s+"</b> de " + elementName; }

	else if(dataName == "dda"){ html += countData+" <b>proposition"+s+"</b> de " + elementName; }

	else if(dataName == "urls"){ 
		var str = " a " + countData;
		if(countData == "Aucun")
			str = " n'a aucun";
		html += elementName + str+" <b> lien"+s;
		html += '<a class="tooltips btn btn-xs btn-success pull-right " data-placement="top" data-toggle="tooltip" data-original-title="'+trad["Add Link"]+'" href="javascript:;" onclick="dyFObj.openForm ( \'url\',\'parentUrl\')">';
    	html +=	'<i class="fa fa-plus"></i> '+trad["Add Link"]+'</a>' ;  
	}

	else if(dataName == "contacts"){
		var str = " a " + countData;
		if(countData == "Aucun")
			str = " n'a aucun";
		html += elementName + " a " + countData+" <b> point de contact"+s;
		html += '<a class="tooltips btn btn-xs btn-success pull-right " data-placement="top" data-toggle="tooltip" data-original-title="'+trad["Add Link"]+'" href="javascript:;" onclick="dyFObj.openForm ( \'contactPoint\',\'contact\')">';
    	html +=	'<i class="fa fa-plus"></i> '+trad["Add Link"]+'</a>' ;  
	}

	return html;
}

function loadAdminDashboard(){
	showLoader('#central-container');
	getAjax('#central-container' ,baseUrl+'/'+moduleId+"/app/superadmin/action/main",function(){ 
			
	},"html");
}

function loadNewsStream(isLiveBool){

	KScrollTo("#profil_imgPreview");
	
	isLive = isLiveBool==true ? "/isLive/true" : ""; 
	dateLimit = 0;
	scrollEnd = false;
	loadingData = true;
	toogleNotif(true);

	var url = "news/index/type/"+typeItem+"/id/"+contextData.id+isLive+"/date/"+dateLimit+
			  "?isFirst=1&tpl=co2&renderPartial=true";
	
	setTimeout(function(){ //attend que le scroll retourn en haut (kscrollto)
		showLoader('#central-container');
		ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){ 
				if(typeItem=="citoyens") loadLiveNow();
	            $(window).bind("scroll",function(){ 
				    if(!loadingData && !scrollEnd && colNotifOpen){
				          var heightWindow = $("html").height() - $("body").height();
				          if( $(this).scrollTop() >= heightWindow - 400){
				            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep, isLiveBool);
				          }
				    }
				});
				loadingData = false;
		},"html");
	}, 700);
}

function loadGallery(){
	toogleNotif(false);
	var url = "gallery/index/type/"+typeItem+"/id/"+contextData.id;
	
	showLoader('#central-container');
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
		null,
		function(){},"html");
}

function loadChart(){
	toogleNotif(false);
	var url = "chart/header/type/"+typeItem+"/id/"+contextData.id;
	showLoader('#central-container');
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
		null,
		function(){},"html");
}

function loadNotifications(){
	toogleNotif(false);
	var url = "element/notifications/type/"+typeItem+"/id/"+contextData.id;
	
	showLoader('#central-container');
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
		null,
		function(){},"html");
}

function loadHistoryActivity(){
	toogleNotif(false);
	var url = "pod/activitylist/type/"+typeItem+"/id/"+contextData.id;
	showLoader('#central-container');
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
		null,
		function(){},"html");
}

function loadDirectory(){
	toogleNotif(false);
	smallMenu.openAjax(baseUrl+'/'+moduleId+'/element/directory/type/'+contextData.type+'/id/'+contextData.id+
							'?tpl=json','Communauté','fa-connectdevelop','dark');
	bindLBHLinks();
}

function loadEditChart(){
	toogleNotif(false);
	var url = "chart/addchartsv/type/"+contextData.type+"/id/"+contextData.id;
	showLoader('#central-container');
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
		null,
	function(){},"html");
}

function loadDetail(){
	toogleNotif(false);
	var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
	showLoader('#central-container');
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url+'?tpl=ficheInfoElement', null, function(){},"html");
}

function loadInvite(){
	toogleNotif(false);
	var url = "element/about/type/"+contextData.type+"/id/"+contextData.id;
	showLoader('#central-container');
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url+'?tpl=ficheInfoElement', null, function(){},"html");
}

function loadUrls(){
	showLoader('#central-container');
	getAjax('', baseUrl+'/'+moduleId+'/element/geturls/type/'+contextData.type+
				'/id/'+contextData.id,
				function(data){ 
					displayInTheContainer(data, "urls", "external-link", "urls");
				}
	,"html");
}

function loadContacts(){
	showLoader('#central-container');
	getAjax('', baseUrl+'/'+moduleId+'/element/getcontacts/type/'+contextData.type+
				'/id/'+contextData.id,
				function(data){ 
					displayInTheContainer(data, "contacts", "envelope", "contacts");
				}
	,"html");
}

function displayInTheContainer(data, dataName, dataIcon, contextType){ 
	mylog.log("displayInTheContainer",data, dataName, dataIcon, contextType)
	var n=0;
	$.each(data, function(key, val){ if(typeof key != "undefined") n++; });
	if(n>0){

		var html = "<div class='col-md-12 margin-bottom-15 labelTitleDir'>"+
						getLabelTitleDir(dataName, dataIcon, parseInt(n), n)+
					"<hr></div>";

		if(dataName != "collections"){
			html += directory.showResultsDirectoryHtml(data, contextType);
		}else{
			$.each(data, function(col, val){
				html += "<h4 class='col-md-12'><i class='fa fa-star'></i> "+col+"<hr></h4>";
				$.each(val.list, function(key, elements){ 
					html += directory.showResultsDirectoryHtml(elements, key);
				});
			});
		}
		toogleNotif(false);
		$("#central-container").html(html);
		initBtnLink();
	}else{
		var nothing = "Aucun";
		if(dataName == "organizations" || dataName == "collections" || dataName == "follows")
			nothing = "Aucune";

		var html =  "<div class='col-md-12 margin-bottom-15'>"+
						getLabelTitleDir(dataName, dataIcon, nothing, n)+
					"</div>";
		$("#central-container").html(html + "<span class='col-md-12 alert bold bg-white'>"+
												"<i class='fa fa-ban'></i> Aucune donnée"+
											"</span>");
		toogleNotif(false);
	}
}

function loadStream(indexMin, indexMax, isLiveBool){ console.log("LOAD STREAM PROFILSOCIAL"); //loadLiveNow
	loadingData = true;
	currentIndexMin = indexMin;
	currentIndexMax = indexMax;
	

	if(typeof dateLimit == "undefined") dateLimit = 0;

	isLive = isLiveBool==true ? "/isLive/true" : "";
	var url = "news/index/type/"+typeItem+"/id/"+contextData.id+isLive+"/date/"+dateLimit+"?tpl=co2&renderPartial=true";
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
            $("#news-list").html("erreur");
        },
        statusCode:{
                404: function(){
                	loadingData = false;
                    $("#news-list").html("not found");
            }
        }
    });
}

var colNotifOpen = true;
function toogleNotif(open){
	if(typeof open == "undefined") open = false;
	
	if(open==false){
		$('#notif-column').removeClass("col-md-3 col-sm-3 col-lg-3").addClass("hidden");
		$('#central-container').removeClass("col-md-9 col-lg-9").addClass("col-md-12 col-lg-12");
	}else{
		$('#notif-column').addClass("col-md-3 col-sm-3 col-lg-3").removeClass("hidden");
		$('#central-container').addClass("col-sm-12 col-md-9 col-lg-9").removeClass("col-md-12 col-lg-12");
	}

	colNotifOpen = open;
}



function loadLiveNow () {
	mylog.log("loadLiveNow");
	var dep = ( ( notNull(contextData["address"])  && notNull(contextData["address"]["depName"]) ) ? 
				contextData["address"]["depName"] : "");

    var searchParams = {
      "tpl":"/pod/nowList",
      //"latest" : true,
      //"searchType" : [typeObj["event"]["col"],typeObj["project"]["col"],
      //					typeObj["organization"]["col"],"classified",
      //				 /*typeObj["organization"]["col"]*//*,typeObj["action"]["col"]*/], 
      //"searchTag" : $('#searchTags').val().split(','), //is an array
      //"searchLocalityCITYKEY" : $('#searchLocalityCITYKEY').val().split(','),
      //"searchLocalityCODE_POSTAL" : $('#searchLocalityCODE_POSTAL').val().split(','), 
      "searchLocalityDEPARTEMENT" : new Array(dep), //$('#searchLocalityDEPARTEMENT').val().split(','),
      //"searchLocalityREGION" : $('#searchLocalityREGION').val().split(','),
      "indexMin" : 0, 
      "indexMax" : 30 
    };

    ajaxPost( "#notif-column", baseUrl+'/'+moduleId+'/element/getdatadetail/type/'+contextData.type+
					'/id/'+contextData.id+'/dataName/liveNow?tpl=nowList',
					searchParams, function() { 
			        bindLBHLinks();
     } , "html" );
}


function showLoader(id){
	$(id).html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");
}