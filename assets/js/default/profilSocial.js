function initDateHeaderPage(params){
	var str = directory.getDateFormated(params);
	//$(".section-date").prepend(str);
	$(".header-banner").html(str);
}

function pushListRoles(links){
	//Members
	if(typeof links.members != "undefined"){
		$.each(links.members, function(e,v){
			if(typeof v.roles != "undefined"){
				$.each(v.roles, function(i,data){
					if(data != "" && !rolesList.includes(data)){
						rolesList.push(data);
					}
				});
			}
		});
	}
	//Contributors
	if(typeof links.contributors != "undefined"){
		$.each(links.contributors, function(e,v){
			if(typeof v.roles != "undefined"){
				$.each(v.roles, function(i,data){
					if(data != "" && !rolesList.includes(data)){
						rolesList.push(data);
					}
				});
			}
		});
	}
	//Attendees
	if(typeof links.attendees != "undefined"){
		$.each(links.attendees, function(e,v){
			if(typeof v.roles != "undefined"){
				$.each(v.roles, function(i,data){
					if(data != "" && !rolesList.includes(data)){
						rolesList.push(data);
					}
				});
			}
		});
	}
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
		location.hash=hashUrlPage
		//history.pushState(null, "New Title", hashUrlPage);
		loadNewsStream(true);
	});
	$(".btn-start-mystream").click(function(){
		//$(".ssmla").removeClass('active');
		responsiveMenuLeft(true);
		if(contextData.type=="citoyens" && userId==contextData.id){
			location.hash=hashUrlPage+".view.mystream";
			//history.pushState(null, "New Title", hashUrlPage+".view.mystream");
		}
		else{
			location.hash=hashUrlPage;
			//history.pushState(null, "New Title", hashUrlPage);
		}
		loadNewsStream(false);
		uiCoop.closeUI(false);
	});
	$("#btn-start-gallery").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.gallery";
		//history.pushState(null, "New Title", hashUrlPage+".view.gallery");
		//location.search="?view=gallery";
		loadGallery();
	});
	$("#btn-start-library").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.library";
		//history.pushState(null, "New Title", hashUrlPage+".view.gallery");
		//location.search="?view=gallery";
		loadLibrary();
	});
	$(".btn-start-notifications").click(function(){
		//$(".ssmla").removeClass('active');
		responsiveMenuLeft(true);
		reloadWindow=false;
		location.hash=hashUrlPage+".view.notifications";
		loadNotifications();
	});
	$(".btn-start-chart").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.chart";
		//history.pushState(null, "New Title", hashUrlPage+".view.chart");
		loadChart();
	});

	$(".btn-start-actionrooms").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.actionRooms";
		//history.pushState(null, "New Title", hashUrlPage+".view.chart");
		loadActionRoom();
	});

	
	$(".btn-show-activity").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.history";
		//history.pushState(null, "New Title", hashUrlPage+".view.history");
		loadHistoryActivity();
	});
	
	$(".open-confidentiality").click(function(){
		responsiveMenuLeft();
		mylog.log("open-confidentiality");
		toogleNotif(false);
		smallMenu.open( dataHelper.markdownToHtml($("#descriptionMarkdown").html()));
		bindLBHLinks();
	});

	$(".open-directory").click(function(){
		responsiveMenuLeft();
		history.pushState(null, "New Title", hashUrlPage+".view.directory");
		loadDirectory();
	});
	$(".edit-chart").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.editChart";
		//history.pushState(null, "New Title", hashUrlPage+".view.editChart");
		loadEditChart();
	});
	$(".btn-open-collection").click(function(){
		responsiveMenuLeft();
		toogleNotif(false);
	});

	$("#btn-start-detail").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.detail";
		//history.pushState(null, "New Title", hashUrlPage+".view.detail");
		loadDetail();
	});

	$(".load-data-directory").click(function(){ 
		responsiveMenuLeft();
		var dataName = $(this).data("type-dir");
		location.hash=hashUrlPage+".view.directory.dir."+dataName;
		loadDataDirectory(dataName, "", edit);
	});
		
	$("#subsubMenuLeft a").click(function(){
		onchangeClick=false;
		$("#subsubMenuLeft a").removeClass("active");
		$(this).addClass("active");
	});

	$("#btn-start-urls").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.urls";
		//history.pushState(null, "New Title", hashUrlPage+".view.urls");
		loadUrls();
	});

	$("#btn-start-contacts").click(function(){
		responsiveMenuLeft();
		location.hash=hashUrlPage+".view.contacts";
		//history.pushState(null, "New Title", hashUrlPage+".view.contacts");
		loadContacts();
	});

	$("#btn-hide-desc").click(function(){
		if($("#desc-event").hasClass("hidden")){
			$("#desc-event").removeClass("hidden");
			$("#btn-hide-desc").html("<i class='fa fa-angle-up'></i> "+trad.hide);
		}else{
			$("#desc-event").addClass("hidden");
			$("#btn-hide-desc").html("<i class='fa fa-angle-down'></i> "+trad.showdescr);
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

	
	$("#btn-update-coop").click(function(){
		toastr.info(trad["processing"]);
		uiCoop.getCoopData(contextData.type, contextData.id, "room");
		uiCoop.startUI();
	});

	bindButtonOpenForm();

    /*$("#div-select-create").mouseleave(function(){
    	$("#div-select-create").stop(true, true).delay(200).fadeOut(500);
    	//$(".central-section").show();    	
    });*/

    $("#btn-close-select-create").click(function(){
    	$("#div-select-create").hide(200);
    	//$(".central-section").show();    	
    });

    $("#open-select-create, .open-create-form-modal").click(function(){
    	responsiveMenuLeft(true);
		//$(".central-section").hide();
    	$("#div-select-create").show(200);
    	setTimeout(function(){
    		//KScrollTo("#div-select-create");
    		$('html, body').stop().animate({
		        scrollTop: $("#div-select-create").offset().top - 300
		    }, 300, '');
    	}, 500);
    });
    
    $("#div-select-create").hide();
    $("#div-select-create").removeClass("hidden");


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
			    	if(data.result){
						$("#divSeePreferencesHeader").addClass("hidden");
						$('#editConfidentialityBtn').removeClass("btn-red");
			    	}
			    }
			});
    	}
    });

    $("#inviteBtn").on("click", function(){
    	mylog.log("invite");
    	$("#modal-invite").modal("show");
    });

    $("#btn-delete-element").on("click", function(){
    	mylog.log("Delete Element");
    	$("#modal-delete-element").modal("show");
    });

	$(".panel-btn-confidentiality .btn").click(function(){
		var type = $(this).attr("type");
		var value = $(this).attr("value");
		$(".btn-group-"+type + " .btn").removeClass("active");
		$(this).addClass("active");
	});

	$("#open-co-space").click(function(){
		uiCoop.startUI();
	});

	$("#reopen-menu-left-container").click(function(){
		uiCoop.closeUI();
	});

	initBtnShare();

}

function bindButtonOpenForm(){
	//window select open form type (selectCreate)
	$(".btn-open-form").off().on("click",function(){
        var typeForm = $(this).data("form-type");
        mylog.log("test", $(this).data("form-subtype")),
        currentKFormType = ($(this).data("form-subtype")) ? $(this).data("form-subtype") : null;

        //alert(contextData.type+" && "+contextData.id+" : "+typeForm);
        if(contextData && contextData.type && contextData.id )
            dyFObj.openForm(typeForm,"sub");
        else
            dyFObj.openForm(typeForm);
    });
}

function loadDataDirectory(dataName, dataIcon, edit){ console.log("loadDataDirectory");
	showLoader('#central-container');

	var dataIcon = $(".load-data-directory[data-type-dir="+dataName+"]").data("icon");
	//history.pushState(null, "New Title", hashUrlPage+".view.directory.dir."+dataName);
	// $('#central-container').html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");return;
	getAjax('', baseUrl+'/'+moduleId+'/element/getdatadetail/type/'+contextData.type+
				'/id/'+contextData.id+'/dataName/'+dataName+'?tpl=json',
				function(data){ 
					var type = ($.inArray(dataName, ["poi","ressource","vote","actions","discuss"]) >=0) ? dataName : null;
					if(typeof edit != "undefined" && edit)
						edit=dataName;
					displayInTheContainer(data, dataName, dataIcon, type, edit);
					bindButtonOpenForm();
				}
	,"html");
}

function getLabelTitleDir(dataName, dataIcon, countData, n){
	//mylog.log("bgetLabelTitleDir", dataName, dataIcon, countData, n, trad);
	var elementName = "<span class='Montserrat' id='name-lbl-title'>"+$("#nameHeader .name-header").html()+"</span>";
	
	var s = (n>1) ? "s" : "";

	//if(countData=='Aucun')
	//	countData=tradException.no;
	var html = "<i class='fa fa-"+dataIcon+" fa-2x margin-right-10'></i> <i class='fa fa-angle-down'></i> ";
	if(dataName == "follows")	{ html += elementName + " "+trad.isfollowing+" " + countData + " "+trad["page"+s]+""; }
	else if(dataName == "followers")	{ html += countData + " <b>"+trad["follower"+s]+"</b> "+trad.to+" "+ elementName; }
	else if(dataName == "members")	{ html += elementName + " "+trad.iscomposedof+" " + countData + " <b>"+trad["member"+s]+"</b>"; }
	else if(dataName == "attendees")	{ html += countData + " <b>"+trad["attendee"+s]+"</b> "+trad.toevent+" " + elementName; }
	else if(dataName == "guests")	{ html += countData + " <b>"+trad["guest"+s]+"</b> "+trad.on+" " + elementName; }
	else if(dataName == "contributors")	{ html += countData + " <b>"+trad["contributor"+s]+"</b> "+trad.toproject+" " + elementName; }
	
	else if(dataName == "events"){ 
		if(type == "events"){
			html += elementName + " "+trad.iscomposedof+" " + countData+" <b> "+trad["subevent"+s]; 
		}else{
			html += elementName + " "+trad.takepart+" " + countData+" <b> "+trad["event"+s]; 
		}
	}
	else if(dataName == "organizations")	{ html += elementName + " "+trad.ismemberof+" "+ countData+" <b>"+trad["organization"+s]; }
	else if(dataName == "projects")		{ html += elementName + " "+trad.contributeto+" " + countData+" <b>"+trad["project"+s] }

	else if(dataName == "collections"){ html += elementName+" "+trad.hasgot+" "+countData+" <b>"+trad["collection"+s]+"</b>"; }
	else if(dataName == "poi"){ html += countData+" <b>"+trad["point"+s+"interest"+s]+"</b> "+trad['createdby'+s]+" " + elementName; }
	else if(dataName == "classified"){ html += countData+" <b>"+trad[classified+s]+"</b> "+trad['createdby'+s]+" " + elementName; }

	else if(dataName == "needs"){ html += countData+" <b>"+trad[need+s]+"</b> "+trad.of+" " + elementName; }

	else if(dataName == "vote"){ html += countData+" <b>"+trad[proposal+s]+"</b> "+trad.of+" " + elementName; }
	else if(dataName == "discuss"){ html += countData+" <b>"+trad.discussion+s+"</b> "+trad.of+" " + elementName; }
	else if(dataName == "actions"){ html += countData+" <b>"+trad.actions+s+"</b> "+trad.of+" " + elementName; }

	else if(dataName == "actionRooms"){ html += countData+" <b>espace de décision"+s+"</b> de " + elementName; }

	else if(dataName == "urls"){ 
		var str = " a " + countData;
		if(countData == "Aucun")
			str = " n'a aucun";
		html += elementName + str+" <b> lien"+s;
		if( (typeof openEdition != "undefined" && openEdition == true) || (typeof edit != "undefined" && edit == true) ){
			html += '<a class="btn btn-sm btn-link bg-green-k pull-right " href="javascript:;" onclick="dyFObj.openForm ( \'url\',\'sub\')">';
    		html +=	'<i class="fa fa-plus"></i> '+trad["Add link"]+'</a>' ;
		}
		  
	}

	else if(dataName == "contacts"){
		var str = " a " + countData;
		if(countData == "Aucun")
			str = " n'a aucun";
		html += elementName + " a " + countData+" <b> point de contact"+s;
		if( (typeof openEdition != "undefined" && openEdition == true) || (typeof edit != "undefined" && edit == true) ){
			html += '<a class="btn btn-sm btn-link bg-green-k pull-right " href="javascript:;" onclick="dyFObj.openForm ( \'contactPoint\',\'contact\')">';
	    	html +=	'<i class="fa fa-plus"></i> '+trad["Add contact"]+'</a>' ;
	    }


	}

	if( openEdition || edit ){
		if( $.inArray( dataName, ["events","projects","organizations","poi","classified","collections","actionRooms"] ) >= 0 ){
			if(dataName == "collections"){
				html += '<a class="btn btn-sm btn-link bg-green-k pull-right " href="javascript:;" onclick="collection.crud()">';
		    	html +=	'<i class="fa fa-plus"></i> '+trad.createcollection+'</a>' ; 
			}
			else {
				var elemSpec = dyFInputs.get(dataName);
				html += '<button class="btn btn-sm btn-link bg-green-k pull-right btn-open-form" data-form-type="'+elemSpec.ctrl+'" data-dismiss="modal">';
		    	html +=	'<i class="fa fa-plus"></i> '+trad["create"+elemSpec.ctrl]+'</button>' ;  
		    }
		}
	}

	return html;
}

function loadAdminDashboard(week){
	showLoader('#central-container');
	ajaxPost('#central-container' ,baseUrl+'/'+moduleId+"/app/superadmin/action/main/week/"+week,
			 { "week" : week },
			 function(){ 
			
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
function loadSettings(){
	mylog.log("confidentiality", seePreferences);
	loadNewsStream(true);
	history.pushState(null, "New Title", hashUrlPage);
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
		    	if(data.result){
					$("#divSeePreferencesHeader").addClass("hidden");
					$('#editConfidentialityBtn').removeClass("btn-red");
		    	}
		    }
		});
	}
}
function loadGallery(){
	toogleNotif(false);
	var url = "gallery/index/type/"+typeItem+"/id/"+contextData.id+"/docType/image";
	
	showLoader('#central-container');
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
		null,
		function(){},"html");
}
function loadLibrary(){
	toogleNotif(false);
	var url = "gallery/index/type/"+typeItem+"/id/"+contextData.id+"/docType/file";
	
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

function loadActionRoom(){
	//toogleNotif(false);
	showLoader('#fast-rooms');
	var params = { };
	ajaxPost('#fast-rooms', baseUrl+'/'+moduleId+'/rooms/index/type/'+contextData.type+
									'/id/'+contextData.id, params, function(){},"html");
}

function loadContacts(){
	showLoader('#central-container');
	getAjax('', baseUrl+'/'+moduleId+'/element/getcontacts/type/'+contextData.type+
				'/id/'+contextData.id,
				function(data){ 
					displayInTheContainer(data, "contacts", "envelope", "contacts");
					$(".openFormContact").click(function(){
			    		var idReceiver = $(this).data("id-receiver");
			    		var idReceiverParent = contextData.id;
			    		var typeReceiverParent = contextData.type;
			    		
			    		var contactMail = $(this).data("email");
			    		var contactName = $(this).data("name");
			    		//console.log('contactMail', contactMail);
			    		$("#formContact .contact-email").html(contactMail);
			    		$("#formContact #contact-name").html(contactName);

			    		$("#formContact #emailSender").val(userConnected.email);
			    		$("#formContact #name").val(userConnected.name);
			    		
			    		$("#formContact #form-control").val("");
			    		
			    		$("#formContact #idReceiver").val(idReceiver);
			    		$("#formContact #idReceiverParent").val(idReceiverParent);
			    		$("#formContact #typeReceiverParent").val(typeReceiverParent);
			    		
			    		$("#conf-fail-mail, #conf-send-mail, #form-fail").addClass("hidden");
        				$("#form-group-contact").removeClass("hidden");
			    		$("#formContact").modal("show");
			    	});
				}
	,"html");
}



//todo add count on each tag
    function getfilterRoles(roles) { 
    	console.log("getfilterRoles roles",roles);
    	if(typeof roles == "undefined") {
    		$("#listRoles").hide();
    		return;
		}

		var nRole = 0;
    	$.each( roles,function(k,o){ nRole++; } );
    	if(nRole == 0){
    		$("#listRoles").hide();
    		return;
		}
		$("#listRoles").show(300);
        $("#listRoles").html("<i class='fa fa-filter'></i> "+trad.sortbyrole+": ");
        $("#listRoles").append("<a class='btn btn-link btn-sm letter-blue favElBtn favAllBtn' "+
            "href='javascript:directory.toggleEmptyParentSection(\".favSection\",null,\".searchEntityContainer\",1)'>"+
            " <i class='fa fa-refresh'></i> <b>"+trad["seeall"]+"</b></a>");
        	$.each( roles,function(k,o){
                $("#listRoles").append("<a class='btn btn-link btn-sm favElBtn letter-blue "+slugify(k)+"Btn' "+
                                "data-tag='"+slugify(k)+"' "+
                                "href='javascript:directory.toggleEmptyParentSection(\".favSection\",\"."+slugify(k)+"\",\".searchEntityContainer\",1)'>"+
                                  k+" <span class='badge'>"+o.count+"</span>"+
                            "</a>");
        	});
    }
function displayInTheContainer(data, dataName, dataIcon, contextType, edit){ 
	mylog.log("displayInTheContainer",data, dataName, dataIcon, contextType, edit)
	var n=0;
	listRoles={};
	$.each(data, function(key, val){ 
		console.log("rolesShox",val);
		if(typeof key != "undefined") n++; 
		if(typeof val.rolesLink != "undefined"){
			console.log(val.rolesLink);
			$.each(val.rolesLink, function(i,v){
				//Push new roles in rolesList
				if(v != "" && !rolesList.includes(v))
					rolesList.push(v);
				//Incrément and push roles in filter array
				if(typeof listRoles[v] != "undefined")
					listRoles[v].count++;
				else
					listRoles[v]={"count": 1}
			});
		}
	});
	if(n>0){
		var thisTitle = getLabelTitleDir(dataName, dataIcon, parseInt(n), n);

		var html = "";

		var btnMap = '<button class="btn btn-default btn-sm btn-show-onmap inline" id="btn-show-links-onmap">'+
				            '<i class="fa fa-map-marker"></i>'+
				        '</button>';

		html += "<div class='col-md-12 margin-bottom-15 labelTitleDir'>";
		
		if(dataName != "urls")
			html += btnMap;

		html +=	thisTitle;
		html += "<div id='listRoles' class='shadow2'></div>"+
			 "<hr>";
		html +=	"</div>";
		
		
		var mapElements = new Array();
		
		console.log("listRoles",listRoles);
		if(dataName != "collections"){
			if(mapElements.length==0) mapElements = data;
        	else $.extend(mapElements, data);
			html += directory.showResultsDirectoryHtml(data, contextType, null, edit);
		}else{
			$.each(data, function(col, val){
				colName=col;
				if(col=="favorites")
					colName="favoris";
				html += "<a class='btn btn-default col-xs-12 shadow2 padding-10 margin-bottom-20' onclick='$(\"."+colName+"\").toggleClass(\"hide\")' ><h2><i class='fa fa-star'></i> "+colName+" ("+Object.keys(val.list).length+")</h2></a>"+
						"<div class='"+colName+" hide'>";
				console.log("list", val);
				if(val.count==0)
					html +="<span class='col-xs-12 text-dark margin-bottom-20'>"+trad.noelementinthiscollection+"</span>";
				else{
					$.each(val.list, function(key, elements){ 
						if(mapElements.length==0) mapElements = elements;
        				else $.extend(mapElements, elements);
						html += directory.showResultsDirectoryHtml(elements, key);
					});
				}
				html += "</div>";
			});
		}
		toogleNotif(false);
		$("#central-container").html(html);
		initBtnLink();
		initBtnAdmin();
		bindButtonOpenForm();

		getfilterRoles(listRoles);
	
		var dataToMap = data;
		if(dataName == "collections"){
			dataToMap = new Array();
			$.each(data, function(key, val){
				$.each(val.list, function(type, list){
					mylog.log("collection", type, list);
					$.each(list, function(id, el){
						dataToMap.push(el);
					});
				});
			});
		}

					mylog.log("dataToMap", dataToMap);
		$("#btn-show-links-onmap").off().click(function(){
			Sig.showMapElements(Sig.map, dataToMap, "", thisTitle);
			showMap(true);
		});
    
	}else{
		//var nothing = tradException.no;
		//if(dataName == "organizations" || dataName == "collections" || dataName == "follows")
		//	nothing = tradException.nofem;

		var html =  "<div class='col-md-12 margin-bottom-15'>"+
						getLabelTitleDir(dataName, dataIcon, parseInt(n), n)+
					"</div>";
		$("#central-container").html(html + "<span class='col-md-12 alert bold bg-white'>"+
												"<i class='fa fa-ban'></i> "+trad.nodata+
											"</span>");
		toogleNotif(false);
	}

}
var loading = "<div class='loader text-dark text-center'>"+
		"<span style='font-size:25px;'>"+
			"<i class='fa fa-spin fa-circle-o-notch'></i> "+
			"<span class='text-dark'>"+trad.currentlyloading+" ...</span>" + 
		"</div>";

function loadStream(indexMin, indexMax, isLiveBool){ mylog.log("LOAD STREAM PROFILSOCIAL"); //loadLiveNow
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
	mylog.log("loadLiveNow1", contextData.address);

	var level = {} ;
	if( notNull(contextData.address)) {
		mylog.log("loadLiveNow2", contextData.address);
		if(notNull(contextData.address.level4)){
			mylog.log("loadLiveNow3", contextData.address.level4);
			level[contextData.address.level4] = { type : "level4", name : contextData.address.level4Name } ;
		} else if(notNull(contextData.address.level3)){
			level[contextData.address.level3] = { type : "level3", name : contextData.address.level3Name } ;
		} else if(notNull(contextData.address.level2)){
			level[contextData.address.level2] = { type : "level2", name : contextData.address.level2Name } ;
		} else if(notNull(contextData.address.level1)){
			level[contextData.address.level1] = { type : "level1", name : contextData.address.level1Name } ;
		}
	}

	if(CO2DomainName == "kgougle")
		level[contextData.address.level3] = { type : "level3", name : contextData.address.level3Name } ;

	mylog.log("loadLiveNow4", level);
	if( jQuery.isEmptyObject(level) ) {
		//alert("Vous n'êtes pas communecté ?");
	} //else{
	    var searchParams = {
	      "tpl":"/pod/nowList",
	      "searchLocality" : level,
	      "indexMin" : 0, 
	      "indexMax" : 30 
	    };

	    ajaxPost( "#notif-column", baseUrl+'/'+moduleId+'/element/getdatadetail/type/'+contextData.type+
						'/id/'+contextData.id+'/dataName/liveNow?tpl=nowList',
						searchParams, function() { 
				        bindLBHLinks();
	     } , "html" );
	//}
}

function showLoader(id){
	$(id).html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");
}

function descHtmlToMarkdown() {
	mylog.log("htmlToMarkdown");
	if(typeof contextData.descriptionHTML != "undefined" && contextData.descriptionHTML == true) {
		mylog.log("htmlToMarkdown");
		if( $("#descriptionAbout").html() != "" ){
			var paramSpan = {
			  filter: ['span'],
			  replacement: function(innerHTML, node) {
			    return innerHTML;
			  }
			}
			var paramDiv = {
			  filter: ['div'],
			  replacement: function(innerHTML, node) {
			    return innerHTML;
			  }
			}
			mylog.log("htmlToMarkdown2");
			var converters = { converters: [paramSpan, paramDiv] };
			var descToMarkdown = toMarkdown( $("#descriptionMarkdown").html(), converters ) ;
			mylog.log("descToMarkdown", descToMarkdown);
			$("descriptionMarkdown").html(descToMarkdown);
			var param = new Object;
			param.name = "description";
			param.value = descToMarkdown;
			param.id = contextData.id;
			param.typeElement = contextData.type;
			param.block = "toMarkdown";
			$.ajax({
		        type: "POST",
		       	url : baseUrl+"/"+moduleId+"/element/updateblock/",
		        data: param,
		       	dataType: "json",
		    	success: function(data){
			    	//toastr.success(data.msg);
			    }
			});
			mylog.log("param", param);
		}
	}
}

function inintDescs() {
	mylog.log("inintDescs");
	if(edit == true || openEdition== true)
		descHtmlToMarkdown();
	mylog.log("after");
	mylog.log("inintDescs", $("#descriptionMarkdown").html());
	var descHtml = "<i>"+trad.notSpecified+"</i>";
	if($("#descriptionMarkdown").html().length > 0){
		descHtml = dataHelper.markdownToHtml($("#descriptionMarkdown").html()) ;
	}
	
	$("#descriptionAbout").html(descHtml);
	$("#descProfilsocial").html(descHtml);
	mylog.log("descHtml", descHtml);
}

function removeAddress(form){
	var msg = trad.suredeletelocality ;
		if(!form && contextData.type == personCOLLECTION)
			msg = trad.suredeletepersonlocality ;

		bootbox.confirm({
			message: msg + "<span class='text-red'></span>",
			buttons: {
				confirm: {
					label: trad.yes,
					className: 'btn-success'
				},
				cancel: {
					label: trad.no,
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				if (!result) {
					return;
				} else {
					param = new Object;
			    	param.name = "locality";
			    	param.value = "";
			    	param.pk = contextData.id;
					$.ajax({
				        type: "POST",
				        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+contextData.type,
				        data: param,
				       	dataType: "json",
				    	success: function(data){
					    	//
					    	if(data.result && !form){
								if(contextData.type == personCOLLECTION) {
									//Menu Left
									$("#btn-geoloc-auto-menu").attr("href", "javascript:");
									$('#btn-geoloc-auto-menu > span.lbl-btn-menu').html("Communectez-vous");
									$("#btn-geoloc-auto-menu").attr("onclick", "communecterUser()");
									$("#btn-geoloc-auto-menu").off().removeClass("lbh");
									//Dashbord
									$("#btn-menuSmall-mycity").attr("href", "javascript:");
									$("#btn-menuSmall-citizenCouncil").attr("href", "javascript:");
									//Multiscope
									$(".msg-scope-co").html("<i class='fa fa-cogs'></i> Paramétrer mon code postal</a>");
									//MenuSmall
									$(".hide-communected").show();
									$(".visible-communected").hide();

									$(".communecter-btn").removeClass("hidden");
								}
								communexion.currentLevel = null;
								communexion.currentName = null;
								communexion.currentValue = null;
								communexion.values = null;
								toastr.success(data.msg);
								urlCtrl.loadByHash("#page.type."+contextData.type+".id."+contextData.id+".view.detail");
					    	}
					    }
					});
				}
			}
		});
}


var mapUrl = { 	"discuss": 
					{ "url"  : "comment/index/type/actionRooms", 
					  "hash" : "comment.index.type.actionRooms"
					} ,
				"vote": 
					{ "url"  : "survey/entries", 
					  "hash" : "survey.entries"
					} ,
				"entry" :
					{ "url"  : "survey/entry",
					  "hash" : "survey.entry",
					},
				"actions": 
					{ "url"  : "rooms/actions", 
					  "hash" : "rooms.actions"
					} ,
				"action":
					{ "url" : "rooms/action",
					  "hash" : "rooms.action",
					}
			}

function loadRoom(type, id){
	location.hash=hashUrlPage+".view.dda.dir."+type+".idda."+id;			
}

function startLoadRoom(type, id){	
	ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+mapUrl[type]["url"]+ '/id/'+id+"?renderPartial=true", 
			null, function(){
			},"html");

	toogleNotif(false);
	KScrollTo("#shortDescriptionHeader");
}
/*function createSlugBeforeChat(type,canEdit,hasRc){
	dynForm.openForm("slug","sub");
	rcObj.loadChat(loadChat,type,canEdit,hasRC);
}*/
