var countPoll = 0;
var prevStep = 0;
var steps = ["explain1","live","explain2","event","explain3","orga","explain4","project","explain5","person"];
var slides = {
	explain1 : function() { showDefinition("explainCommunectMe")},
	live : function() { urlCtrl.loadByHash("#default.live")},
	explain2 : function() { showDefinition("explainCartographiedeReseau")},
	event : function() { urlCtrl.loadByHash("#event.detail.id.57bb4078f6ca47cb6c8b457d")}, 
	explain3 : function() { showDefinition("explainDemoPart")},
	orga : function() { urlCtrl.loadByHash("#organization.detail.id.57553776f6ca47b37da93c2d")}, 
	explain4 : function() { showDefinition("explainCommunecter")},
	project : function() { urlCtrl.loadByHash("#project.detail.id.56c1a474f6ca47a8378b45ef")},
	explain5 : function() { showDefinition("explainProxicity")},
	person : function() { urlCtrl.loadByHash("#person.detail.id.54eda798f6b95cb404000903")} 
};

function runslide(cmd)
{
	if(cmd == 0){
		prevStep = null;
		urlCtrl.loadByHash("#default.live");
	}

	if( prevStep != null ){
		slides[ steps[prevStep] ]();
		prevStep = ( prevStep < steps.length - 1 ) ? prevStep+1  : 0;
		setTimeout( function () { 
			runslide();
		 }, 8000);
	}
}

function checkPoll(){
	countPoll++;
	mylog.log("countPoll",countPoll,"currentUrl",currentUrl);
	//refactor check Log to use only one call with pollParams 
	//returning multple server checks in a unique ajax call
	if(userId){
		_checkLoggued();
		if(typeof refreshNotifications != "undefined")
		refreshNotifications(userId,"citoyens","");
	}
	
	//according to the loaded page 
	//certain checks can be made  
	if(currentUrl.indexOf( "#comment.index.type.actionRooms.id" ) >= 0 )
		checkCommentCount();

	if(countPoll < 100){
		setTimeout( function () { checkPoll() }, 300000); //every5min
		countPoll++;
	}
}
function setLanguage(lang){
	$.cookie('lang', lang, { expires: 365, path: "/" });
	toastr.success(trad.changelanguageprocessing);
	//window.reloadurlCtrl.loadByHash(location.hash);
	location.reload();
}
var watchThis = null;
function bindRightClicks() { 
	$.contextMenu({
	    selector: ".add2fav",
        build: function($trigger, e) {
        	if(userId){
        		var validElems = ["#element", "#page","#organization","#project","#event","#person","#element","#survey","#rooms"];
        		href = $trigger[0].hash.split(".");
        		if($.inArray(href[0],validElems) >=0 ){
        			if(href[0] == "#element"){
		        		var what = href[3]; 
						var	id = href[5];
					}else if (href[0] == "#page"){
						var what = href[2]; 
						var	id = href[4];
					}else{
						var what = typeObj[ href[0].substring(1) ].col; 
						var	id =  href[3];
					}
				}
				/*console.log( $(this)[0].class );
				watchThis = {
					t : $(this),
					tr : $trigger
				};*/
				var btns = {
					/*
					todo : how remove if can't edit 
					would like to use a class but can't find how to get the content of the class attribute
					ask TKA
					editThis : {
						name: trad.edit,
			        	icon: "fa-pencil", 
			        	callback: function(key, opt){ 
					        dyFObj.editElement( what , id );
			        	}
					},*/
					openInNewTab : {
						name: "Ouvrir dans un nouvel onglet",
			        	icon: "fa-arrow-circle-right", 
			        	callback: function(key, opt){ 
					        window.open($trigger[0].hash, '_blank');
			        	}
					}
				};
	        	$.each( userConnected.collections, function (col,list) { 
	        		btns[col] = { 
			        	name: function($element, key, item){ 
			        		nameCol=col;
			        		if(col=="favorites")
			        			nameCol="mes favoris";
		        			var str = "Ajouter à "+nameCol;
		        			//console.log(col,what,id);
		        			if( notNull( userConnected.collections[col]) && notNull( userConnected.collections[col][what] ) && notNull( userConnected.collections[col][what][id]) ) 
		        				str = "Retirer de "+nameCol;
		        			return str; 
		        		},
			        	icon: "fa-folder-open", 
			        	callback: function(key, opt){
				        	if( notNull( what )&& notNull( id ) ){
					        	collection.add2fav( what,id,col );
							}
			        	}
			    	}
	        	});
	        	btns.newCollection =  { 
		        	name: "Créer une nouvelle Collection",
		        	icon: "fa-folder-open-o", 
		        	callback: function(key, opt){ 
			        	if(userId ){
				        	collection.crud();
						}
		        	}
		    	};
	            return { items: btns }
	        }
        }
	});
	$.contextMenu({
	    selector: ".tag",
        build: function($trigger, e) {
        	var tag = $trigger[0].dataset.tagValue;
        	var btns = {};
	        btns.filterTag =  { 
	        	name: "Filtrer",
	        	icon: "fa-filter", 
	        	callback: function(key, opt){ 
		        	directory.toggleEmptyParentSection(".favSection","."+slugify(tag),directory.elemClass,1);
	        	}
	    	};
	    	btns.addToMultiTags =  { 
	        	name: "Ajouter au tags préférés",
	        	icon: "fa-tag", 
	        	callback: function(key, opt){ 
			        addTagToMultitag( tag );
	        	}
	    	};
            return { items: btns }
	    }
	});
}
function linkify(inputText) {
    var replacedText, replacePattern1, replacePattern2, replacePattern3;

    //URLs starting with http://, https://, or ftp://
    replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');

    //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');

    //Change email addresses to mailto:: links.
    replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
    replacedText = replacedText.replace(replacePattern3, '<a href="mailto:$1">$1</a>');

    return replacedText;
}
function addslashes(str) {
	  //  discuss at: http://phpjs.org/functions/addslashes/
	  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // improved by: Ates Goral (http://magnetiq.com)
	  // improved by: marrtins
	  // improved by: Nate
	  // improved by: Onno Marsman
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Oskar Larsson Högfeldt (http://oskar-lh.name/)
	  //    input by: Denny Wardhana
	  //   example 1: addslashes("kevin's birthday");
	  //   returns 1: "kevin\\'s birthday"

	  return (str + '')
		.replace(/[\\"']/g, '\\$&')
		.replace(/\u0000/g, '\\0');
	}
/* *************************** */
/* instance du menu questionnaire*/
/* *************************** */
function DropDown(el) {
	this.dd = el;
	this.placeholder = this.dd.children('span');
	this.opts = this.dd.find('ul.dropdown > li');
	this.val = '';
	this.index = -1;
	this.initEvents();
}
DropDown.prototype = {
	initEvents : function() {
		var obj = this;

		obj.dd.on('click', function(event){
			$(this).toggleClass('active');
			return false;
		});

		obj.opts.on('click',function(){
			var opt = $(this);
			obj.val = opt.text();
			obj.index = opt.index();
			obj.placeholder.text(obj.val);
			window.open($(this).find('a').slice(0,1).attr('href'));
		});
	},
	getValue : function() {
		return this.val;
	},
	getIndex : function() {
		return this.index;
	}
}

function openModal(key,collection,id,tpl,savePath,isSub){
	$.ajax({
	  type: "POST",
	  url: baseUrl+"/common/GetMicroformat/key/"+key,
	  data: { "key" : key, 
	  		  "template" : tpl, 
	  		  "collection" : collection, 
	  		  "id" : id,
	  		  "savePath" : savePath,
	  		  "isSub" : isSub },
	  success: function(data){
			  $("#flashInfoLabel").html(data.title);
			  $("#flashInfoContent").html(data.content);
			  $("#flashInfoSaveBtn").html('<a class="btn btn-warning " href="javascript:;" onclick="$(\'#flashForm\').submit(); return false;"  >Enregistrer</a>');
		
	  },
	  dataType: "json"
	});
}

function updateField(type,id,name,value,reload, toastr){ 
    	
	$.ajax({
	  type: "POST",
	  url: baseUrl+"/"+moduleId+"/"+type+"/updatefield", 
	  data: { "pk" : id ,"name" : name, value : value },
	  success: function(data){
		if(data.result) {
			if(toastr==null)
        		toastr.success(data.msg);
        	if(reload)
        		urlCtrl.loadByHash(location.hash);
		}
        else
        	toastr.error(data.msg);  
	  },
	  dataType: "json"
	});
}
function addslashes(str) {
	  //  discuss at: http://phpjs.org/functions/addslashes/
	  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // improved by: Ates Goral (http://magnetiq.com)
	  // improved by: marrtins
	  // improved by: Nate
	  // improved by: Onno Marsman
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Oskar Larsson Högfeldt (http://oskar-lh.name/)
	  //    input by: Denny Wardhana
	  //   example 1: addslashes("kevin's birthday");
	  //   returns 1: "kevin\\'s birthday"

	  return (str + '')
		.replace(/[\\"']/g, '\\$&')
		.replace(/\u0000/g, '\\0');
	}
/* *************************** */
/* global JS tools */
/* *************************** */
var mylog = (function () {
    
    return {
        log: function() {
          if(debug){
          	var args = Array.prototype.slice.call(arguments);
            console.log.apply(console, args);
        	}
        },
        warn: function() {
            if( debug){
	          	var args = Array.prototype.slice.call(arguments);
	            console.warn.apply(console, args);
	        }
        },
        debug: function() {
            if(debug){
	          	var args = Array.prototype.slice.call(arguments);
	            console.debug.apply(console, args);
	        }
        },
        info: function() {
            if(debug){
	          	var args = Array.prototype.slice.call(arguments);
	            console.info.apply(console, args);
	        }
        },
        dir: function() {
            if(debug){
	          	var args = Array.prototype.slice.call(arguments);
	            console.warn.apply(console, args);
	        }
        },
        error: function() {
            if(debug){
		      	var args = Array.prototype.slice.call(arguments);
		        console.error.apply(console, args);
		    }
        }
    }
}());
/* ------------------------------- */

function initSequence(){
    $.each(initT, function(k,v){
        log(k,'info');
        v();
    });
    initT = null;
}

function showEvent(id){
	$("#"+id).click(function(){
    	if($("#"+id).prop("checked"))
    		$("#"+id+"What").removeClass("hidden");
    	else
    		$("#"+id+"What").addClass("hidden");
    });
}

//In this javascript file you can find a bunk of functional functions
//Calling Actions in ajax. Can be used easily on views
function connectPerson(connectUserId, callback) 
{
	mylog.log("connect Person");
	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+'/person/follows',
		dataType : "json",
		data : {
			connectUserId : connectUserId,
		}
	})
	.done(function (data) {
		$.unblockUI();
		if (data &&  data.result) {
			var name = $("#newInvite #ficheName").text();
			toastr.success('You are now following '+name);
			if (typeof callback == "function") callback(data.invitedUser);
		} else {
			$.unblockUI();
			toastr.error('Something Went Wrong !');
		}
		
	});
	
}



function disconnectTo(parentType,parentId,childId,childType,connectType, callback, linkOption) {
	var messageBox = trad["removeconnection"+connectType];
	$(".disconnectBtnIcon").removeClass("fa-unlink").addClass("fa-spinner fa-spin");
	var formData = {
		"childId" : childId,
		"childType" : childType, 
		"parentType" : parentType,
		"parentId" : parentId,
		"connectType" : connectType,
	};
	if(typeof linkOption != "undefined" && linkOption)
		formData.linkOption=linkOption;
	bootbox.dialog({
        onEscape: function() {
            $(".disconnectBtnIcon").removeClass("fa-spinner fa-spin").addClass("fa-unlink");
        },
        message: '<div class="row">  ' +
            '<div class="col-md-12"> ' +
            '<span>'+messageBox+' ?</span> ' +
            '</div></div>',
        buttons: {
            success: {
                label: "Ok",
                className: "btn-primary",
                callback: function () {
                    $.ajax({
						type: "POST",
						url: baseUrl+"/"+moduleId+"/link/disconnect",
						data : formData,
						dataType: "json",
						success: function(data){
							if ( data && data.result ) {
								type=formData.parentType;
								if(formData.parentType==  "citoyens")
									type="people";
								removeFloopEntity(data.parentId, type);
								toastr.success("Le lien a été supprimé avec succès");
								if (typeof callback == "function") 
									callback();
								else
									urlCtrl.loadByHash(location.hash);
							} else {
							   toastr.error("You leave succesfully");
							}
						}
					});
                }
            },
            cancel: {
            	label: trad["cancel"],
            	className: "btn-secondary",
            	callback: function() {
            		$(".disconnectBtnIcon").removeClass("fa-spinner fa-spin").addClass("fa-unlink");
            	}
            }
        }
    });      
};

// Javascript function used to validate a link between parent and child (ex : member, admin...)
function validateConnection(parentType, parentId, childId, childType, linkOption, callback) {
	var formData = {
		"childId" : childId,
		"childType" : childType, 
		"parentType" : parentType,
		"parentId" : parentId,
		"linkOption" : linkOption,
	};

	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+"/link/validate",
		data: formData,
		dataType: "json",
		success: function(data) {
			if (data.result) {
				if (typeof callback == "function") 
					callback(parentType, parentId, childId, childType, linkOption);
				else{
					toastr.success(data.msg);
					urlCtrl.loadByHash(location.hash);
				}

			} else {
				toastr.error(data.msg);
			}
		},
	});  
}

function follow(parentType, parentId, childId, childType, callback){
	mylog.log("follow",parentType, parentId, childId, childType, callback);
	$(".followBtn").removeClass("fa-link").addClass("fa-spinner fa-spin");
	var formData = {
		"childId" : childId,
		"childType" : childType, 
		"parentType" : parentType,
		"parentId" : parentId,
	};
	$.ajax({
		type: "POST",
		url: baseUrl+"/"+moduleId+"/link/follow",
		data: formData,
		dataType: "json",
		success: function(data) {
			if(data.result){
				if (formData.parentType)
					addFloopEntity(formData.parentId, formData.parentType, data.parentEntity);
				toastr.success(data.msg);	
				if (typeof callback == "function") 
					callback();
				else
					urlCtrl.loadByHash(location.hash);
			}
			else
				toastr.error(data.msg);
		},
	});
}

function connectTo(parentType, parentId, childId, childType, connectType, parentName, actionAdmin) {
	if(parentType=="events" && connectType=="attendee")
		$(".connectBtn").removeClass("fa-link").addClass("fa-spinner fa-spin");
	else
		$(".becomeAdminBtn").removeClass("fa-user-plus").addClass("fa-spinner fa-spin");
	var formData = {
		"childId" : childId,
		"childType" : childType, 
		"parentType" : parentType,
		"parentId" : parentId,
		"connectType" : connectType,
	};
	mylog.log(formData);
	
	if(connectType!="admin" && connectType !="attendee"){
		bootbox.dialog({
                title: trad["suretojoin"+parentType]+" "+trad["as"+connectType]+" ?",
                onEscape: function() {
	                $(".becomeAdminBtn").removeClass("fa-spinner fa-spin").addClass("fa-user-plus");
                },
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form class="form-horizontal"> ' +
                    '<label class="col-md-4 control-label" for="awesomeness">'+tradDynForm.wouldbecomeadmin+'?</label> ' +
                    '<div class="col-md-4"> <div class="radio"> <label for="awesomeness-0"> ' +
                    '<input type="radio" name="awesomeness" id="awesomeness-0" value="admin"> ' +
                    tradDynForm.yes+' </label> ' +
                    '</div><div class="radio"> <label for="awesomeness-1"> ' +
                    '<input type="radio" name="awesomeness" id="awesomeness-1" value="'+connectType+'" checked="checked"> '+tradDynForm.no+' </label> ' +
                    '</div> ' +
                    '</div> </div>' +
                    '</form></div></div>',
                buttons: {
                    success: {
                        label: "Ok",
                        className: "btn-primary",
                        callback: function () {
                            var role = $('#role').val();
                            var answer = $("input[name='awesomeness']:checked").val();
                            if(role!=""){
	                            formData.roles=role;
                            }
                            formData.connectType=answer;
                            mylog.log(formData);
                            $.ajax({
								type: "POST",
								url: baseUrl+"/"+moduleId+"/link/connect",
								data: formData,
								dataType: "json",
								success: function(data) {
									if(data.result){
										addFloopEntity(data.parent["_id"]["$id"], data.parentType, data.parent);
										toastr.success(data.msg);	
										urlCtrl.loadByHash(location.hash);
									}
									else{
										if(typeof(data.type)!="undefined" && data.type=="info")
											toastr.info(data.msg);
										else
											toastr.error(data.msg);
									}
								},
							});  
                        }
                    },
                    cancel: {
                    	label: trad["cancel"],
                    	className: "btn-secondary",
                    	callback: function() {
                    		$(".becomeAdminBtn").removeClass("fa-spinner fa-spin").addClass("fa-user-plus");
                    	}
                    }
                }
            }
        );
    }
	else{
		messageBox=trad["suretojoin"+parentType];;
		if (connectType=="admin")
			messageBox += " " + trad["as"+connectType];
		bootbox.dialog({
                onEscape: function() {
	                $(".becomeAdminBtn").removeClass("fa-spinner fa-spin").addClass("fa-user-plus");
                },
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<span>'+messageBox+' ?</span> ' +
                    '</div></div>',
                buttons: {
                    success: {
                        label: "Ok",
                        className: "btn-primary",
                        callback: function () {
                            $.ajax({
								type: "POST",
								url: baseUrl+"/"+moduleId+"/link/connect",
								data: formData,	
								dataType: "json",
								success: function(data) {
									if(data.result){
										addFloopEntity(data.parent["_id"]["$id"], data.parentType, data.parent);
										toastr.success(data.msg);	
										urlCtrl.loadByHash(location.hash);
									}
									else{
										if(typeof(data.type)!="undefined" && data.type=="info")
											toastr.info(data.msg);
										else
											toastr.error(data.msg);
									}
								},
							});   
                        }
                    },
                    cancel: {
                    	label: trad["cancel"],
                    	className: "btn-secondary",
                    	callback: function() {
                    		$(".becomeAdminBtn").removeClass("fa-spinner fa-spin").addClass("fa-user-plus");
                    	}
                    }
                }
            }
        );      
	}
}		

var CoAllReadyLoad = false;
var urlCtrl = {
	afterLoad : null,
	loadableUrls : {
		"#modal." : {title:'OPEN in Modal'},
		"#event.calendarview" : {title:"EVENT CALENDAR ", icon : "calendar"},
		"#city.opendata" : {title:'STATISTICS ', icon : 'line-chart' },
	    "#person.telegram" : {title:'CONTACT PERSON VIA TELEGRAM ', icon : 'send' },
	    "#event.detail" : {aliasParam: "#page.type.events.id.$id", params: ["id"],title:'EVENT DETAIL ', icon : 'calendar' },
	    "#poi.detail" : {aliasParam: "#page.type.poi.id.$id", params: ["id"],title:'POI DETAIL ', icon : 'calendar' },
	    "#organization.detail" : {aliasParam: "#page.type.organizations.id.$id", params: ["id"],title:'ORGANIZATION DETAIL ', icon : 'users' },
	    "#project.detail" : {aliasParam: "#page.type.projects.id.$id", params: ["id"], title:'PROJECT DETAIL ', icon : 'lightbulb-o' },
	    "#project.addchartsv" : {title:'EDIT CHART ', icon : 'puzzle-piece' },
	    "#event.directory" : {aliasParam: "#page.type.events.id.$id.view.directory.dir.attendees", params: ["id"],title:'EVENT DETAIL ', icon : 'calendar' },
	    "#organization.directory" : {aliasParam: "#page.type.organizations.id.$id.view.directory.dir.members", params: ["id"],title:'ORGANIZATION DETAIL ', icon : 'users' },
	    "#project.directory" : {aliasParam: "#page.type.projects.id.$id.view.directory.dir.contributors", params: ["id"], title:'PROJECT DETAIL ', icon : 'lightbulb-o' },
	    "#news.detail" : {aliasParam: "#page.type.news.id.$id", params: ["id"], title:'NEWS', icon : 'rss' },
	    "#news.index" : {aliasParam: "#page.type.$type.id.$id", params: ["type","id"], title:'NEWS', icon : 'rss' },
	    "#project.addchartsv" : {title:'EDIT CHART ', icon : 'puzzle-piece' },
	    "#chart.addchartsv" : {title:'EDIT CHART ', icon : 'puzzle-piece' },
	    "#gantt.addtimesheetsv" : {title:'EDIT TIMELINE ', icon : 'tasks' },
	    //"#news.detail" : {title:'NEWS DETAIL ', icon : 'rss' },
	    //"#news.index.type" : {title:'NEWS INDEX ', icon : 'rss', menuId:"menu-btn-news-network","urlExtraParam":"isFirst=1" },
	    "#need.detail" : {title:'NEED DETAIL ', icon : 'cubes' },
	    "#need.addneedsv" : {title:'NEED DETAIL ', icon : 'cubes' },
	    "#city.creategraph" : {title:'CITY ', icon : 'university', menuId:"btn-geoloc-auto-menu" },
	    "#city.graphcity" : {title:'CITY ', icon : 'university', menuId:"btn-geoloc-auto-menu" },
	    "#city.statisticPopulation" : {title:'CITY ', icon : 'university' },
	    "#rooms.index.type.cities" : {title:'ACTION ROOMS ', icon : 'cubes', menuId:"btn-citizen-council-commun"},
	    "#rooms.editroom" : {title:'ADD A ROOM ', icon : 'plus', action:function(){ editRoomSV ();	}},
		"#element.aroundme" : {title:"Around me" , icon : 'crosshairs', menuId:"menu-btn-around-me"},
	    "#element.notifications" : {title:'DETAIL ENTITY', icon : 'legal'},
	    "#person.settings" : {title:'DETAIL ENTITY', icon : 'legal'},
	    "#person.invite" : {title:'DETAIL ENTITY', icon : 'legal'},
		"#element" : {title:'DETAIL ENTITY', icon : 'legal'},
	    "#gallery" : {title:'ACTION ROOMS ', icon : 'photo'},
	    "#comment" : {title:'DISCUSSION ROOMS ', icon : 'comments'},

	    "#admin.checkgeocodage" : {title:'CHECKGEOCODAGE ', icon : 'download', useHeader: true},
	    "#admin.openagenda" : {title:'OPENAGENDA ', icon : 'download', useHeader: true},
	    "#admin.adddata" : {title:'ADDDATA ', icon : 'download', useHeader: true},
	    "#admin.importdata" : {title:'IMPORT DATA ', icon : 'download', useHeader: true},
	    "#admin.index" : {title:'IMPORT DATA ', icon : 'download', useHeader: true},
	    "#admin.cities" : {title:'CITIES ', icon : 'university', useHeader: true},
	    "#admin.sourceadmin" : {title:'SOURCE ADMIN', icon : 'download', useHeader: true},
	    "#admin.checkcities" : {title:'SOURCE ADMIN', icon : 'download', useHeader: true},
	    "#admin.directory" : {title:'IMPORT DATA ', icon : 'download', useHeader: true},
	    "#admin.mailerrordashboard" : {title:'MAIL ERROR ', icon : 'download', useHeader: true},
	    "#admin.moderate" : {title:'MODERATE ', icon : 'download', useHeader: true},
	    "#admin.createfile" : {title:'IMPORT DATA', icon : 'download', useHeader: true},
		"#log.monitoring" : {title:'LOG MONITORING ', icon : 'plus', useHeader: true},
	    "#adminpublic.index" : {title:'SOURCE ADMIN', icon : 'download', useHeader: true},
	    "#adminpublic.createfile" : {title:'IMPORT DATA', icon : 'download', useHeader : true},
	    "#adminpublic.adddata" : {title:'ADDDATA ', icon : 'download', useHeader : true},
	   	"#adminpublic.interopproposed" : {title : 'INTEROP PROPOSED', icon : 'download', useHeader : true},
	    "#admin.cleantags" : {title : 'CLEAN TAGS', icon : 'download'},
	    "#default.directory" : {title:'COMMUNECTED DIRECTORY', icon : 'connectdevelop', menuId:"menu-btn-directory"},
	    "#default.news" : {title:'COMMUNECTED NEWS ', icon : 'rss', menuId:"menu-btn-news" },
	    "#default.agenda" : {title:'COMMUNECTED AGENDA ', icon : 'calendar', menuId:"menu-btn-agenda"},
		"#default.home" : {title:'COMMUNECTED HOME ', icon : 'home',"menu":"homeShortcuts"},
		"#default.apropos" : {title:'COMMUNECTED HOME ', icon : 'star',"menu":"homeShortcuts"},
		"#default.twostepregister" : {title:'TWO STEP REGISTER', icon : 'home', "menu":"homeShortcuts"},
		"#default.view.page" : {title:'Découvrir', icon : 'file-o'},
		"#home" : {"alias":"#default.home"},
	    "#stat.chartglobal" : {title:'STATISTICS ', icon : 'bar-chart'},
	    "#stat.chartlogs" : {title:'STATISTICS ', icon : 'bar-chart'},
	    "#default.live" : {title:"FLUX'Direct" , icon : 'heartbeat', menuId:"menu-btn-live"},
		"#default.login" : {title:'COMMUNECTED AGENDA ', icon : 'calendar'},
		"#showTagOnMap.tag" : {title:'TAG MAP ', icon : 'map-marker', action:function( hash ){ showTagOnMap(hash.split('.')[2])	} },
		"#define." : {title:'TAG MAP ', icon : 'map-marker', action:function( hash ){ showDefinition("explain"+hash.split('.')[1])	} },
		"#data.index" : {title:'OPEN DATA FOR ALL', icon : 'fa-folder-open-o'},
		"#opendata" : {"alias":"#data.index"},
		"#interoperability.copedia" : {title:'COPEDIA', icon : 'fa-folder-open-o','useHeader' : true},
		"#interoperability.co-osm" : {title:'COSM', icon : 'fa-folder-open-o','useHeader' : true},


		"#chatAction" : {title:'CHAT', icon : 'comments', action:function(){ rcObj.loadChat("","citoyens", true, true) }, removeAfterLoad : true },
	},
	shortVal : ["p","poi","s","o","e","pr","c","cl"/* "s","v","a", "r",*/],
	shortKey : [ "citoyens","poi" ,"siteurl","organizations","events","projects" ,"cities" ,"classified"/*"entry","vote" ,"action" ,"rooms" */],
	map : function (hash) {
		if(typeof hash == "undefined") return { hash : "#",
												type : "",
												id : ""
											};
		hashT = hash.split('.');
		return {
			hash : hash,
			type : hashT[2],
			id : hashT[4]
		};
	},
	convertToPath : function(hash) { 
		return hash.substring(1).replace( "#","" ).replace( /\./g,"/" );
	},
	//manages url short cuts like eve_xxxxx
	//warning : works with only 1 underscore 
	//can contain more variables eve_xxxxx.viewer.dsdsd
	checkAndConvert : function (hash) {
		hashT = hash.split('_');
		mylog.log("-------checkAndConvert : ",hash,hashT);
		pos = $.inArray( hashT[0].substring(1) , urlCtrl.shortVal );
		if( pos >= 0 ){
			type = urlCtrl.shortKey[pos];
			hash =  "#page.type."+type+".id."+hashT[1];
			mylog.log("converted hash : ",hash);
		} 
		return hash;
	},
	jsController : function (hash){
		mylog.log("jsController", hash);
		hash = urlCtrl.checkAndConvert(hash);
		//alert("jsController"+hash);
		mylog.log("jsController",hash);
		res = false;
		$(".menuShortcuts").addClass("hide");
		//mylog.log("urlCtrl.loadableUrls", urlCtrl.loadableUrls);
		$.each( urlCtrl.loadableUrls, function(urlIndex,urlObj)
		{
			//mylog.log("replaceAndShow2",urlIndex);
			if( hash.indexOf(urlIndex) >= 0 )
			{
				if(urlObj.goto){
					window.location.href = urlObj.goto;
					return false;
				}
				checkMenu(urlObj, hash);
			
				endPoint = urlCtrl.loadableUrls[urlIndex];
				mylog.log("jsController 2",endPoint,"login",endPoint.login,endPoint.hash );
				if( typeof endPoint.login == undefined || !endPoint.login || ( endPoint.login && userId ) )
				{
					//alises are renaming of urls example default.home could be #home
					if( endPoint.alias ){
						endPoint = urlCtrl.jsController(endPoint.alias);
						return false;
					} 
					if( endPoint.aliasParam ){
						hashT=hash.split(".");
						alias=endPoint.aliasParam;
						$.each(endPoint.params, function(i, v){
							$.each(hashT, function(ui, e){
								if (v == e){
									paramId=hashT[ui+1];
									alias = alias.replace("$"+v, paramId);
								}
							});
						});
						endPoint = urlCtrl.jsController(alias);	
						return false;
					} 
					// an action can be connected to a url, and executed
					if( endPoint.action && typeof endPoint.action == "function"){
						endPoint.action(hash);
					} else {
						//classic url management : converts urls by replacing dots to slashes and ajax retreiving and showing the content 
						extraParams = (endPoint.urlExtraParam) ? "?"+endPoint.urlExtraParam : "";
						urlExtra = (endPoint.urlExtra) ? endPoint.urlExtra : "";
						//execute actions before teh ajax request
						res = false;
						if( endPoint.preaction && typeof endPoint.preaction == "function")
							res = endPoint.preaction(hash);
						//hash can be iliased
						if (endPoint.hash) 
							hash = hash.replace(urlIndex, endPoint.hash);
						if(hash.indexOf("?") >= 0){
							hashT=hash.split("?");
							mylog.log(hashT);
							hash=hashT[0];
							extraParams = "?"+hashT[1];
						}
						if(extraParams.indexOf("#") >= 0){
							extraParams=extraParams.replace( "#","%hash%" );
						}
						path = urlCtrl.convertToPath(hash);
						pathT = path.split('/');
						//open path in a modal (#openModal)
						if(pathT[0] == "modal"){
							path = path.substring(5);
							alert(baseUrl+'/'+moduleId+path);
							smallMenu.openAjaxHTML(baseUrl+'/'+moduleId+path);
						} else
							showAjaxPanel( '/'+path+urlExtra+extraParams, endPoint.title,endPoint.icon, res,endPoint );
						
						if(endPoint.menu)
							$("."+endPoint.menu).removeClass("hide");

						if(endPoint.removeAfterLoad){
							//alert("removeAfterLoad 1");
							history.pushState('', document.title, window.location.pathname);
						}
					} 
					res = true;
					return false;
				} else {
					mylog.warn("PRIVATE SECTION LOGIN FIRST",hash);
					showPanel( "box-login" );
					resetUnlogguedTopBar();
					res = true;
				}
			} /*else 
				alert("hash not found");*/
		});
		return res;
	},

	//back sert juste a differencier un load avec le back btn
	//ne sert plus, juste a savoir d'ou vient drait l'appel
	loadByHash : function ( hash , back ) {
		// mylog.log("IS DIRECTORY ? ", 
		// 			hash.indexOf("#default.directory"), 
		// 			location.hash.indexOf("#default.directory"), CoAllReadyLoad);
		onchangeClick=false;
		navInSlug=false;
		mylog.log("loadByHash", hash, back );
		if(typeof globalTheme != "undefined" && globalTheme=="network"){
			mylog.log("globalTheme", globalTheme);
			if( hash.indexOf("#network") >= 0 &&
				location.hash.indexOf("#network") >= 0 || hash=="#" || hash==""){ 
				mylog.log("network");
			}
			else{
				mylog.log("network2");
				count=$(".breadcrumAnchor").length;
				//case on reload view
				if(count==0)
					count=1;
				breadcrumGuide(count, hash);
			}
			
			return ;
		}

		if( hash.indexOf("#default.directory") >= 0 &&
			location.hash.indexOf("#default.directory") >= 0 && CoAllReadyLoad==true){ 
			var n = hash.indexOf("type=")+5;
			var type = hash.substr(n);
			mylog.log("CHANGE directory", type);
			searchType = [type];
			setHeaderDirectory(type);
			loadingData = false;
			startSearch(0, indexStepInit, ( notNull(searchCallback) ) ? searchCallback : null );
			mylog.log("testnetwork hash 2", hash);
			location.hash = hash;
			return;
		}
		currentUrl = hash;
		allReadyLoad = true;
		CoAllReadyLoad = true;
		if( typeof urlCtrl.loadableUrls[hash] == "undefined" || 
			typeof urlCtrl.loadableUrls[hash].emptyContextData == "undefined" || 
			urlCtrl.loadableUrls[hash].emptyContextData == true )
			contextData = null;

		$(".my-main-container").off()
							   .bind("scroll", function () {shadowOnHeader()})
							   .scrollTop(0);

		$(".searchIcon").removeClass("fa-file-text-o").addClass("fa-search");
		searchPage = false;
		
		//alert("urlCtrl.loadByHash"+hash);

	    mylog.warn("urlCtrl.loadByHash",hash,back);
	    if( urlCtrl.jsController(hash) ){
	    	mylog.log("urlCtrl.loadByHash >>> hash found",hash);
	    }
	    else if( hash.indexOf("#panel") >= 0 ){

	    	panelName = hash.substr(7);
	    	mylog.log("panelName",panelName);
	    	if( (panelName == "box-login" || panelName == "box-register") && userId != "" && userId != null ){
	    		urlCtrl.loadByHash("#default.home");
	    		return false;
	    	} else if(panelName == "box-add")
	            title = 'ADD SOMETHING TO MY NETWORK';
	        else
	            title = "WELCOM MUNECT HEY !!!";
	        if(panelName == "box-login"){
				$('#modalLogin').modal("show");
				$.unblockUI();
	        }
			else if(panelName == "box-register"){
				$('#modalRegister').modal("show");
				$.unblockUI();
			}
			else
	       		showPanel(panelName,null,title);
	    }  else if( hash.indexOf("#gallery.index.id") >= 0 ){
	        hashT = hash.split(".");
	        showAjaxPanel( '/'+hash.replace( "#","" ).replace( /\./g,"/" ), 'ACTIONS in this '+typesLabels[hashT[3]],'rss' );
	    }

	    /*else if( hash.indexOf("#news.index.type") >= 0 ){
	        hashT = hash.split(".");
	        showAjaxPanel( '/'+hash.replace( "#","" ).replace( /\./g,"/" )+'?isFirst=1', 'KESS KISS PASS in this '+typesLabels[hashT[3]],'rss' );

	    } */
	    else if( hash.indexOf("#city.directory") >= 0 ){
	        hashT = hash.split(".");
	        showAjaxPanel( '/'+hash.replace( "#","" ).replace( /\./g,"/" ), 'KESS KISS PASS in this '+typesLabels[hashT[3]],'rss' );
	    } 
		/*else if( hash.indexOf("#need.addneedsv") >= 0 ){
		        hashT = hash.split(".");
		        showAjaxPanel( '/'+hash.replace( "#","" ).replace( /\./g,"/" ), 'ADD NEED '+typesLabels[hashT[3]],'cubes' );
		} 
		else if( hash.indexOf("#need.addneedsv") >= 0 ){
		        hashT = hash.split(".");
		        showAjaxPanel( '/'+hash.replace( "#","" ).replace( /\./g,"/" ), 'ADD NEED '+typesLabels[hashT[3]],'cubes' );
		} */
		else if(hash.length>2){
			hash = hash.replace( "#","" );
			hashT=hash.split(".");
			if(typeof hashT == "string")
				slug=hashT;
			else
				slug=hashT[0];
			$.ajax({
	  			type: "POST",
	  			url: baseUrl+"/"+moduleId+"/slug/getinfo/key/"+slug,
	  			dataType: "json",
	  			success: function(data){
			  		if(data.result){
			  			viewPage="";			  			
			  			if(hashT.length > 1){
			  				hashT.shift();
			  				viewPage="/"+hashT.join("/");
			  			}
			  			showAjaxPanel('/app/page/type/'+data.contextType+'/id/'+data.contextId+viewPage);
			  		}else
			  			showAjaxPanel( '/app/index', 'Home','home' );
	 			},
			});
		}
	    else 
	        showAjaxPanel( '/app/index', 'Home','home' );
	    mylog.log("testnetwork hash", hash);
	    location.hash = hash;
	    /*if(typeof back == "function"){
	    	alert("back");
	    	back();
		}*/
	}
}

/* ****************
Generic non-ajax panel loading process 
**************/
function showPanel(box,callback){ 
	$(".my-main-container").scrollTop(0);

  	$(".box").hide(200);
  	showNotif(false);
  	
  	if(isMapEnd) showMap(false);
			
	mylog.log("showPanel",box);
	//showTopMenu(false);
	$(themeObj.mainContainer).animate({ top: -1500, opacity:0 }, 500 );

	$("."+box).show(500);
	if (typeof callback == "function") {
		callback();
	}
}

/* ****************
Generic ajax panel loading process 
loads any REST Url endpoint returning HTML into the content section
also switches the global Title and Icon
**************/

function  processingBlockUi() { 
	msg = '<h4 style="font-weight:300" class=" text-dark padding-10">'+
			'<i class="fa fa-spin fa-circle-o-notch"></i><br>'+trad.currentlyloading+'...'+
		  '</h4>';

	if( jsonHelper.notNull( "themeObj.blockUi.processingMsg" ) )
		msg = themeObj.blockUi.processingMsg;
	$.blockUI({ message :  msg });
	bindLBHLinks();
}
function showAjaxPanel (url,title,icon, mapEnd , urlObj) { 
	//alert("showAjaxPanel"+url);
	$(".progressTop").show().val(20);
	var dest = ( typeof urlObj == "undefined" || typeof urlObj.useHeader != "undefined" ) ? themeObj.mainContainer : ".pageContent" ;
	mylog.log("showAjaxPanel", url, urlObj,dest,urlCtrl.afterLoad );	
	//var dest = themeObj.mainContainer;
	hideScrollTop = false;
	//alert("showAjaxPanel"+dest);
	showNotif(false);
			
	//setTimeout(function(){
		//$(".main-container > header").html("");
		//$(".pageContent").html("");
	$(".hover-info,.hover-info2").hide();
		//processingBlockUi();
	showMap(false);
	//}, 200);

	$(".box").hide(200);
	//showPanel('box-ajax');
	icon = (icon) ? " <i class='fa fa-"+icon+"'></i> " : "";
	$(".panelTitle").html(icon+title).fadeIn();
	mylog.log("GETAJAX",icon+title);
	//showTopMenu(true);
	userIdBefore = userId;
	setTimeout(function(){
		if( $(dest).length )
		{
		setTimeout(function(){ $('.progressTop').val(40)}, 1000);
		setTimeout(function(){ $('.progressTop').val(60)}, 3000);
		getAjax(dest, baseUrl+'/'+moduleId+url, function(data){ 
			
			if( dest != themeObj.mainContainer )
				$(".subModuleTitle").html("");

			//initNotifications(); 
			
			$(".modal-backdrop").hide();
			bindExplainLinks();
			bindTags();
			bindLBHLinks();
			$(".progressTop").val(90);
			setTimeout(function(){ $(".progressTop").val(100)}, 10);
			$(".progressTop").fadeOut(200);
			$.unblockUI();

			if(mapEnd)
				showMap(true);

    		if(typeof contextData != "undefined" && contextData != null && contextData.type && contextData.id ){
        		uploadObj.set(contextData.type,contextData.id);
        	}
        	
        	if( typeof urlCtrl.afterLoad == "function") {
        		urlCtrl.afterLoad();
        		urlCtrl.afterLoad = null;
        	}
        	/*if(debug){
        		getAjax(null, baseUrl+'/'+moduleId+"/log/dbaccess", function(data){ 
        			if(prevDbAccessCount == 0){
        				dbAccessCount = parseInt(data);
        				prevDbAccessCount = dbAccessCount;
        			} else {
        				dbAccessCount = parseInt(data)-prevDbAccessCount;
        				prevDbAccessCount = parseInt(data);
        			}
        			//console.error('dbaccess:'+prevDbAccessCount);
        			
        			//$(".dbAccessBtn").remove();
        			//$(".menu-info-profil").prepend('<span class="text-red dbAccessBtn" ><i class="fa fa-database text-red text-bold fa-2x"></i> '+dbAccessCount+' <a href="javascript:clearDbAccess();"><i class="fa fa-times text-red text-bold"></i></a></span>');
        		},null);
        	}*/
         },"html");
		} else 
			console.error( 'showAjaxPanel', dest, "doesn't exist" );
	}, 400);
}
/*prevDbAccessCount = 0; 
function clearDbAccess() { 
	getAjax(null, baseUrl+'/'+moduleId+"/log/clear", function(data){ 
		$(".dbAccessBtn").remove();
		prevDbAccessCount = 0; 
	});
}*/

function decodeHtml(str) {
	mylog.log("decodeHtml", str);
    var txt = document.createElement("textarea");
    txt.innerHTML = str;
    mylog.log("decodeHtml",  txt.value);
    return txt.value;
}

function setTitle(str, icon, topTitle,keywords,shortDesc) { mylog.log("setTitle", str);
	if(typeof icon != "undefined" && icon != "")
		icon = ( icon.indexOf("<i") >= 0 ) ? icon : "<i class='fa fa-"+icon+"'></i> ";

	//$(".moduleLabel").html( icon +" "+ str);

	if(topTitle)
		str = topTitle;
	
	$(document).prop('title', ( str != "" ) ? str : "Communecter, se connecter à sa commune" );
	
	if(notNull(keywords))
		$('meta[name="keywords"]').attr("content",keywords);
	else
		$('meta[name="keywords"]').attr("content","communecter,connecter, commun,commune, réseau, sociétal, citoyen, société, territoire, participatif, social, smarterre");
	
	if(notNull(shortDesc))
		$('meta[name="description"]').attr("content",shortDesc);
	else
		$('meta[name="description"]').attr("content","Communecter : Connecter à sa commune, inter connecter les communs, un réseau sociétal pour un citoyen connecté et acteur au centre de sa société.");
}


function checkMenu(urlObj, hash){
	mylog.log("checkMenu *******************", hash);
	//mylog.dir(urlObj);
	$(".menu-button-left").removeClass("selected");
	if(typeof urlObj.menuId != "undefined"){ mylog.log($("#"+urlObj.menuId).data("hash"));
		if($("#"+urlObj.menuId).attr("href") == hash)
			$("#"+urlObj.menuId).addClass("selected");
	}
}

var backUrl = null;
function checkIsLoggued(uId){
	if( uId == "" ||  typeof uId == "undefined" ){
		mylog.warn("");
		toastr.error("<h1>Section Sécuriser, Merci de vous connecter!</h1>");
		
		setTitle("Section Sécuriser", "user-secret");

		backUrl = location.hash;
		showPanel( "box-login" );
    	
    	resetUnlogguedTopBar();
	}else 
		return true;
}
function resetUnlogguedTopBar() { 
	//put anything that needs to be reset 
	//replace the loggued toolBar nav by log buttons
	$('.topMenuButtons').html('<button class="btn-top btn btn-success  hidden-xs" onclick="showPanel(\'box-register\');"><i class="fa fa-plus-circle"></i> <span class="hidden-sm hidden-md hidden-xs">Sinscrire</span></button>'+
							  ' <button class="btn-top btn bg-red  hidden-xs" style="margin-right:10px;" onclick="showPanel(\'box-login\');"><i class="fa fa-sign-in"></i> <span class="hidden-sm hidden-md hidden-xs">Se connecter</span></button>');
}

function _checkLoggued() { 
	$.ajax({
	  type: "POST",
	  url: baseUrl+"/"+moduleId+"/person/logged",
	  success: function(data){
		if( !data.userId || data.userId == "" ||  typeof data.userId == "undefined" ){
			/*userId = data.userId;
			resetUnlogguedTopBar();*/
			window.location.reload();
		}
	  },
	  dataType: "json"
	});
}


/* ****************
visualize all tagged elements on a map
**************/
function showTagOnMap (tag) { 

	mylog.log("showTagOnMap",tag);

	var data = { 	 "name" : tag, 
		 			 "locality" : "",
		 			 "searchType" : [ "persons" ], 
		 			 //"searchBy" : "INSEE",
            		 "indexMin" : 0, 
            		 "indexMax" : 500  
            		};

        //setTitle("", "");$(".moduleLabel").html("<i class='fa fa-spin fa-circle-o-notch'></i> Les acteurs locaux : <span class='text-red'>" + cityNameCommunexion + ", " + cpCommunexion + "</span>");
		
		$.blockUI({
			message : "<h1 class='homestead text-red'><i class='fa fa-spin fa-circle-o-notch'></i> Recherches des collaborateurs ...</h1>"
		});

		showMap(true);
		
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
	            else{
	            	mylog.dir(data);
	            	Sig.showMapElements(Sig.map, data);
	            	//setTitle("", "");$(".moduleLabel").html("<i class='fa fa-connect-develop'></i> Les acteurs locaux : <span class='text-red'>" + cityNameCommunexion + ", " + cpCommunexion + "</span>");
					//$(".search-loader").html("<i class='fa fa-check'></i> Vous êtes communecté : " + cityNameCommunexion + ', ' + cpCommunexion);
					//toastr.success('Vous êtes communecté !<br/>' + cityNameCommunexion + ', ' + cpCommunexion);
					$.unblockUI();
	            }
	          }
	 	});

	//urlCtrl.loadByHash('#project.detail.id.56c1a474f6ca47a8378b45ef',null,true);
	//Sig.showFilterOnMap(tag);
}

/* ****************
show a definition in the focus menu panel
**************/
function showDefinition( id,copySection ){ 

	setTimeout(function(){
		mylog.log("showDefinition",id,copySection);
		
		//$( themeObj.mainContainer ).animate({ opacity:0.3 }, 400 );
		
		if(copySection){
			contentHTML = $("."+id).html();
			if(copySection != true)
				contentHTML = copySection;
			smallMenu.open(contentHTML);
			bindExplainLinks()	
		}
		else {
			$(".hover-info").css("display" , "inline");
			toggle( "."+id , ".explain" );
			$("."+id+" .explainDesc").removeClass("hide");
		}
		return false;
	}, 500);
}

var timeoutHover = setTimeout(function(){}, 0);
var hoverPersist = false;
var positionMouseMenu = "out";

function activateHoverMenu () { 
	//mylog.log("enter all");
	positionMouseMenu = "in";
	$(themeObj.mainContainer).animate({ opacity:0.3 }, 400 );
	$(".lbl-btn-menu-name").show(200);
	$(".lbl-btn-menu-name").css("display", "inline");
	$(".menu-button-title").addClass("large");

	showInputCommunexion();

	hoverPersist = false;
	clearTimeout(timeoutHover);
	timeoutHover = setTimeout(function(){
		hoverPersist = true;
	}, 1000);
}

var favTypes = [];
var smallMenu = {
	destination : ".menuSmallBlockUI",
	inBlockUI : true,
	//smallMenu.openAjax(\''+baseUrl+'/'+moduleId+'/collections/list/col/'+obj.label+'\',\''+obj.label+'\',\'fa-folder-open\',\'yellow\')
	//the url must return a list like userConnected.list
	openAjax : function  (url,title,icon,color,title1,params,callback) 
	{ 
		/*if( typeof directory == "undefined" )
		    lazyLoad( moduleUrl+'/js/default/directory.js', null, null );
	    */
	    //processingBlockUi();
	    //$(smallMenu.destination).html("<i class='fa fa-spin fa-refresh fa-4x'></i>");

		ajaxPost( null , url, params , function(data)
		{
			if(!title1 && notNull(title1) && data.context && data.context.name)
				title1 = data.context.name;
			var content = smallMenu.buildHeader( title,icon,color,title1 );
			smallMenu.open( content );
			if( data.count == 0 )
				$(".titleSmallMenu").html("<a class='text-white' href='javascript:smallMenu.open();'> <i class='fa fa-th'></i></a> "+	
						' <i class="fa fa-angle-right"></i> '+
						title+" vide <i class='fa "+icon+" text-"+color+"'></i>");
			else 
				directory.buildList(data.list);
			
		   	$('.searchSmallMenu').off().on("keyup",function() { 
				directory.search ( ".favSection", $(this).val() );
		   	});
		   	//else collection.buildCollectionList( "linkList" ,"#listCollections",function(){ $("#listCollections").html("<h4 class=''>Collections</h4>"); });

		   	if (typeof callback == "function") 
				callback();
	    } );
	},
	build : function  (params,build_func,callback) { 
		//processingBlockUi();
	   	if (typeof build_func == "function") 
			content = build_func(params);
		smallMenu.open( content );
		if (typeof callback == "function") 
			callback();
	},
	//ex : smallMenu.openSmall("Recherche","fa-search","green",function(){
	openSmall : function  (title,icon,color,callback,title1) { 
		if( typeof directory == "undefined" )
		    lazyLoad( moduleUrl+'/js/default/directory.js', null, null );
	    	
		var content = smallMenu.buildHeader(title,icon,color,title1);
		smallMenu.open( content );

		if (typeof callback == "function") 
			callback();
	},
	buildHeader : function (title,icon,color,title1) { 
		title1 = (typeof title1 != "undefined" && notNull(title1)) ? title1 : "<a class='text-white' href='javascript:smallMenu.open();'> <i class='fa fa-th'></i></a> ";
		content = 
				"<div class='col-xs-12 padding-5'>"+

					"<h3 class='titleSmallMenu'> "+
						title1+"<i class='fa "+icon+" text-"+color+"'></i> "+title+
					"</h3><hr>"+
					"<div class='col-md-12 bold sectionFilters'>"+
						"<a class='text-black bg-white btn btn-link favSectionBtn btn-default' "+
							"href='javascript:directory.toggleEmptyParentSection(\".favSection\",null,\".searchEntityContainer\",1)'>"+
							"<i class='fa fa-asterisk fa-2x'></i><br>Tout voir</a></span> </span>"+
					"</div>"+

					"<div class='col-md-12'><hr></div>"+

				"</div>"+

				"<div id='listDirectory' class='col-md-10 no-padding'></div>"+
				"<div class='hidden-xs col-sm-2 text-left'>"+
					"<input name='searchSmallMenu' style='border:1px solid red' class='form-control searchSmallMenu text-black' placeholder='rechercher' style=''><br/>"+
					"<h4 class=''><i class='fa fa-angle-down'></i> Filtres</h4>"+
					"<a class='btn btn-dark-blue btn-anc-color-blue btn-xs favElBtn favAllBtn text-left' href='javascript:directory.toggleEmptyParentSection(\".favSection\",null,\".searchEntityContainer\",1)'> <i class='fa fa-tags'></i> Tout voir </a><br/>"+

					"<div id='listTags'></div>"+
					"<div id='listScopes'><h4><i class='fa fa-angle-down'></i> Où</h4></div>"+
					"<div id='listCollections'></div>"+
				"</div> "+
				"<div class='col-xs-12 col-sm-10 center no-padding'>"+
					//"<a class='pull-right btn btn-xs btn-default' href='javascript:collection.newChild(\""+title+"\");'> <i class='fa fa-sitemap'></i></a> "+
					"<a class='pull-right btn btn-xs menuSmallTools hide text-red' href='javascript:collection.crud(\"del\",\""+title+"\");'> <i class='fa fa-times'></i></a> "+
					"<a class='pull-right btn btn-xs menuSmallTools hide'  href='javascript:collection.crud(\"update\",\""+title+"\");'> <i class='fa fa-pencil'></i></a> "+
					
					// "<h3 class='titleSmallMenu'> "+
					// 	title1+' <i class="fa fa-angle-right"></i> '+title+" <i class='fa "+icon+" text-"+color+"'></i>"+
					// "</h3>"+
					// "<input name='searchSmallMenu' class='searchSmallMenu text-black' placeholder='rechercher' style='margin-bottom:8px;width: 300px;font-size: x-large;'><br/>"+
					
				"</div>";
		return content;
	},
	//openSmallMenuAjaxBuild("",baseUrl+"/"+moduleId+"/favorites/list/tpl/directory2","FAvoris")
	//opens any html without post processing
	openAjaxHTML : function  (url,title,type,nextPrev) { 
		smallMenu.open("",type );
		var dest = (type == "blockUI") ? ".blockContent" : "#openModal .modal-content .container" ;
		getAjax( dest , url , function () { 
			
			//next and previous btn to nav from preview to preview
			if(nextPrev){
				var p = 0;
				var n = 0;
				var found = false;
				var l = $( '.searchEntityContainer .container-img-profil' ).length;
				$.each( $( '.searchEntityContainer .container-img-profil' ), function(i,val){
					if(found){
						n = (i == l-1 ) ? $( $('.searchEntityContainer .container-img-profil' )[0] ).attr('href') : $(this).attr('href');
						return false;
					}
					if( $(this).attr('href') == nextPrev )
						found = true;
					else 
						p = (i == 0 ) ? $( $('.searchEntityContainer .container-img-profil' )[ $('.searchEntityContainer .container-img-profil' ).length ] ).attr('href') : $(this).attr('href');
				});
				html = "<div style='margin-bottom:50px'><a href='"+p+"' class='lbhp text-dark'><i class='fa fa-2x fa-arrow-circle-left'></i> PREV </a> "+
						" <a href='"+n+"' class='lbhp text-dark'> NEXT <i class='fa fa-2x fa-arrow-circle-right'></i></a></div>";
				$(dest).prepend(html);
				
			}
			bindLBHLinks();
		 },"html" );
	},
	//content Loader can go into a block
	//smallMenu.open("Recherche","blockUI")
	//smallMenu.open("Recherche","bootbox")
	open : function (content,type,color) { 
		//alert("small menu open");
		//add somewhere in page
		if(!smallMenu.inBlockUI){
			$(smallMenu.destination).html( content );
			$.unblockUI();
		}
		else {
			//this uses blockUI
			if(type == "blockUI"){
				colorCSS = (color == "black") ? 'rgba(0,0,0,0.70)' : 'rgba(256,256,256,0.85)';
				colorCSS = (color == "black") ? '#fff' : '#000';
				$.blockUI({ 
					//title : 'Welcome to your page', 
					message : (content) ? content : "<div class='blockContent'></div>",
					onOverlayClick: $.unblockUI(),
			        css: { 
			         //border: '10px solid black', 
			         //margin : "50px",
			         //width:"80%",
			         //    padding: '15px', 
			         backgroundColor: colorCSS,  
			         //    '-webkit-border-radius': '10px', 
			         //    '-moz-border-radius': '10px', 
			             color: colorText ,
			        	// "cursor": "pointer"
			        }//,overlayCSS: { backgroundColor: '#fff'}
				});
			}else if(type == "bootbox"){
				bootbox.dialog({
				  message: content
				});
			} else{//open inside a boostrap modal 
				if(!$("#openModal").hasClass('in'))
					$("#openModal").modal("show");
				if(content)
					$("#openModal div.modal-content div.container").html(content);
				else 
					$("#openModal div.modal-content div.container").html("<i class='fa fa-spin fa-refresh fa-4x'></i>");
			}

			$(".blockPage").addClass(smallMenu.destination.slice(1));
			// If network, check width of menu small
			if( typeof globalTheme != "undefined" && globalTheme == "network" ) {
				if($("#ficheInfoDetail").is(":visible"))
					$(smallMenu.destination).css("cssText", "width: 100% !important;left: 0% !important;");
				else
					$(smallMenu.destination).css("cssText", "width: 83.5% !important;left: 16.5% !important;");
			}
			bindLBHLinks();
		}
	}
}

function searchFinder(name)
{
  mylog.log("Finder",name);
  	$(".titleSmallMenu .fa-search").addClass("fa-spin");
    $.ajax({
		type: "POST",
        url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
        data: {"name" : name},
        dataType: "json",
        success: function(data){
        	$(".titleSmallMenu .fa-search").removeClass("fa-spin");
        	if(!data){
        		toastr.error(data.content);
        	}else{
				var list = {};
		        $.each(data, function(i, v) {
					mylog.log(v, v.length, v.size);
              if(inArray(v.type,["organization","citoyen","event","project","city"]) || v.insee){
                type = (v.insee) ? "cities" : v.type+"s";
                if( typeof list[type] == "undefined")
		              list[type] = [];
		            list[type].push(v);
              
              }
			  	});
				mylog.dir(list);
            directory.buildList(list);
		    }
   		}
	})
}

var selection;
function  bindHighlighter() { 
	//mylog.clear();  
	mylog.log("bindHighlighter");
  	mylog.dir(window.getSelection());
	$(".my-main-container").bind('mouseup', function(e){
		if (window.getSelection) {
	      selection = window.getSelection();
	    } else if (document.selection) {
	      selection = document.selection.createRange();
	    }
	    selTxt = selection.toString();
	    if( selTxt){
	    	//alert(selTxt);
	    	/*
	    	if($(".selBtn").length)
	    		$(".selBtn").remove();
	    	links = "<a href='javascript:;' onclick='fastAdd(\"/rooms/fastaddaction\")' class='selBtn text-bold btn btn-purple btn-xs'><i class='fa fa-cogs'></i> créer en action <i class='fa fa-plus'></i></a>"+
	    			" <a href='javascript:;'  onclick='fastAdd(\"/survey/fastaddentry\")' class='selBtn text-bold btn btn-purple btn-xs'><i class='fa fa-archive'></i> créer en proposition <i class='fa fa-plus'></i></a>";

	    	$(this).parent().find("div.bar_tools_post").append(links);
	    	*/
	    }
	});
}

function  bindTags() { 
	mylog.log("bindTags");
	//var tagClasses = ".tag,.label tag_item_map_list"
	$(".tag,.label tag_item_map_list").off().on('click', function(e){
		//if(userId){
			var tag = ($(this).data("val")) ? $(this).data("val") : $(this).html();
			//alert(tag);
			//showTagInMultitag(tag);
			//$('#btn-modal-multi-tag').trigger("click");
			//$('.tags-count').html( $(".item-tag-name").length );
			if(addTagToMultitag(tag))
				toastr.success("Le tag \""+tag+"\" ajouté à vos tags préférés");
			else
				toastr.info("Le tag \""+tag+"\" est déjà dans vos tags");
			
		//} else {
		//	toastr.error("must be loggued");
		//}
	});
}

function  bindExplainLinks() { 
	mylog.log("bindExplainLinks");
	$(".explainLink").click(function() { 
		mylog.log("explainLink");
	    showDefinition( $(this).data("id") );
	    return false;
	 });
}

function  bindLBHLinks() { 
	$(".lbh").off().on("click",function(e) {  		
		e.preventDefault();
		mylog.warn("***************************************");
		mylog.warn("bindLBHLinks",$(this).attr("href"));
		mylog.warn("***************************************");
		var h = ($(this).data("hash")) ? $(this).data("hash") : $(this).attr("href");
	    urlCtrl.loadByHash( h );
	});
	//open any url in a modal window
	$(".lbhp").unbind("click").on("click",function(e) {
		e.preventDefault();
		mylog.warn("***************************************");
		mylog.warn("bindLBHLinks Preview", $(this).attr("href"),$(this).data("modalshow"));
		//alert("bindLBHLinks Preview"+$(this).data("modalshow"));
		mylog.warn("***************************************");
		var h = ($(this).data("hash")) ? $(this).data("hash") : $(this).attr("href");
		if( $(this).data("modalshow") ){
			smallMenu.open ( directory.preview( mapElements[ $(this).data("modalshow") ],h ) );
			initBtnLink();
		}
		else {
			url = (h.indexOf("#") == 0 ) ? urlCtrl.convertToPath(h) : h;
	    	smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/"+url);
	    	//smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/"+url ,"","blockUI",h);
		}
	})
}


function mouseX(evt) {
    if (evt.pageX) {
        return evt.pageX;
    } else if (evt.clientX) {
       return evt.clientX + (document.documentElement.scrollLeft ?
           document.documentElement.scrollLeft :
           document.body.scrollLeft);
    } else {
        return null;
    }
}

function mouseY(evt) {
    if (evt.pageY) {
        return evt.pageY;
    } else if (evt.clientY) {
       return evt.clientY + (document.documentElement.scrollTop ?
       document.documentElement.scrollTop :
       document.body.scrollTop);
    } else {
        return null;
    }
}

function bindRefreshBtns() { mylog.log("bindRefreshBtns");
	if( $("#dropdown_search").length || $(".newsTL").length)
	{
		var searchFeed = "#dropdown_search";
		var method = "startSearch(0, indexStepInit);"
		if( $(".newsTL").length){
			searchFeed = ".newsTL";
			method = "reloadNewsSearch();"
		}
	    $('#scopeListContainer .item-scope-checker, #scopeListContainer .item-tag-checker, .btn-filter-type').click(function(e){
	          //mylog.warn( ">>>>>>>",$(this).data("scope-value"), $(this).data("tag-value"), $(this).attr("type"));
	          var str = getFooterScopeChanged(method);
	          if(location.hash.indexOf("#news.index")==0 || location.hash.indexOf("#city.detail")==0){  mylog.log("vide news stream perso");
		          $(".newsFeedNews, #backToTop, #footerDropdown").remove();
		          $(searchFeed).append( str );
		      }else { mylog.log("vide autre news stream perso", searchFeed);
		          $(searchFeed).html( str );
		      }
		      $(".search-loader").html("<i class='fa fa-ban'></i>");
	    });
	}
}

function hideSearchResults(){
	var searchFeed = "#dropdown_search";
		var method = "startSearch(0, indexStepInit);"
		if( $(".newsTL").length){
			searchFeed = ".newsTL";
			method = "reloadNewsSearch();"
		}
      //mylog.warn( ">>>>>>>",$(this).data("scope-value"), $(this).data("tag-value"), $(this).attr("type"));
      str = getFooterScopeChanged(method);
      if(location.hash.indexOf("#news.index")==0 || location.hash.indexOf("#city.detail")==0){  mylog.log("vide news stream perso");
          $(".newsFeedNews, #backToTop, #footerDropdown").remove();
          $(searchFeed).append( str );
      }else { mylog.log("vide autre news stream perso", searchFeed);
          $(searchFeed).html( str );
      }
      $(".search-loader").html("<i class='fa fa-ban'></i>");
	    
}
function getFooterScopeChanged(method){
	var str = 	'<div class="padding-5 text-center" id="footerDropdown">';
	    //str += 		"<hr style='float:left; width:100%;'/>"
	    str += 		'<button class="btn btn-default" onclick="'+method+'"><i class="fa fa-refresh"></i> Relancer la recherche</button>'+
	    	   		"<span style='' class='text-dark padding-10'><i class='fa fa-angle-right'></i> Les critères ont changés</span><br/>";
	    str +=  "</div>";
	return str;  
}

function reloadNewsSearch(){
	if(location.hash.indexOf("#default.live")==0)
    	startSearch(false);
	else{
		dateLimit = 0;
		loadStream(0, 5);
	}
}
/* **************************************
maybe movebale into Element.js
***************************************** */

function  buildQRCode(type,id) { 
		
	$(".qrCode").qrcode({
	    text: baseUrl+"/#"+dyFInputs.get(type).ctrl+".detail.id."+id,//'{type:"'+type+'",_id:"'+id+'"}',
	    render: 'image',
		minVersion: 8,
	    maxVersion: 40,
	    ecLevel: 'L',
	    size: 150,
	    radius: 0,
	    quiet: 2,
	    /*mode: 2,
	    mSize: 0.1,
	    mPosX: 0.5,
	    mPosY: 0.5,

	    label: name,
	    fontname: 'Ubuntu',
	    fontcolor: '#E33551',*/
	});
}

function activateSummernote(elem) { 
		
	if( !$('script[src="'+baseUrl+'/plugins/summernote/dist/summernote.min.js"]').length )
	{
		$("<link/>", {
		   rel: "stylesheet",
		   type: "text/css",
		   href: baseUrl+"/plugins/summernote/dist/summernote.css"
		}).appendTo("head");
		$.getScript( baseUrl+"/plugins/summernote/dist/summernote.min.js", function( data, textStatus, jqxhr ) {
		  //mylog.log( data ); // Data returned
		  //mylog.log( textStatus ); // Success
		  //mylog.log( jqxhr.status ); // 200
		  //mylog.log( "Load was performed." );
		  
		  $(".btnEditAdv").hide();
		  $(elem).summernote({
				toolbar: [
					['style', ['bold', 'italic', 'underline', 'clear']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
				]
			});
		});
	} else {
		$(".btnEditAdv").hide();
		$(elem).summernote({
				toolbar: [
					['style', ['bold', 'italic', 'underline', 'clear']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
				]
		});
	}
}


function  firstOptions() { 
	var res = {
		"dontKnow":tradDynForm["dontknow"],
	};
	res[userId] = tradDynForm["me"];
	return res;
 }

function myAdminList (ctypes) {
	mylog.log("myAdminList", ctypes);
	var myList = {};
	if(userId){
		//types in MyContacts
		var connectionTypes = {
			organizations : "members",
			projects : "contributors",
			events : "attendees"
		};
		$.each( ctypes, function(i,ctype) {
			var connectionType = connectionTypes[ctype];
			myList[ ctype ] = { label: trad[ctype], options:{} };
			if( notNull(myContacts) ){
				mylog.log("myAdminList",ctype, connectionType, myContacts, myContacts[ ctype ]);
				$.each( myContacts[ ctype ],function(id,elemObj){
					mylog.log("myAdminList",ctype,id,elemObj.name);
					if( elemObj.links && elemObj.links[connectionType] && elemObj.links[connectionType][userId] && elemObj.links[connectionType][userId].isAdmin) {
						mylog.warn("myAdminList2",ctype+"-"+id+"-"+elemObj.name, elemObj["_id"]["$id"]);
						myList[ ctype ]["options"][ elemObj["_id"]["$id"] ] = elemObj.name;
						mylog.log(myList);
					}
				});
			}
		});
		mylog.log("myAdminList return", myList);
	}
	return myList;
}

function parentList (ctypes, parentId, parentType) { 
	mylog.log("parentList", ctypes, parentId, parentType);
	var myList = myAdminList( ctypes ) ;

	mylog.log("parentList myList", myList);
	if(	notEmpty(parentId) && notEmpty(parentType) && 
		notEmpty(myList) && 
		(	!notEmpty(myList[parentType]) ||
			( notEmpty(myList[parentType]) && !notEmpty(myList[parentType]["options"][parentId]) ) ) ) {

		if(!notEmpty(myList[parentType]))
			myList[ parentType ] = { label: parentType, options:{} };
    	myList[ parentType ]["options"][ parentId ] = contextData.parent.name;  
    }
    return myList; 
}


function escapeHtml(string) {
	var entityMap = {
	    '"': '&quot;',
    	"'": '&#39;',
	};
    return String(string).replace(/["']/g, function (s) {
        return entityMap[s];
    });
} 

function fillContactFields(id){
	name = cotmp[id].name;
	mylog.log("fillContactFields", id, name );
	$("#idContact").val(id);
	$("#listSameName").html("<i class='fa fa-check text-success'></i> Vous avez sélectionner : "+  escapeHtml(name));
	$("#name").val(name);
}
var cotmp = {};
function globalSearch(searchValue,types,contact){
	
	searchType = (types) ? types : ["organizations", "projects", "events", "needs", "citoyens"];

	var data = { 	 
		"name" : searchValue,
		// "locality" : "", a otpimiser en utilisant la localité 
		"searchType" : searchType,
		"indexMin" : 0,
		"indexMax" : 50
	};
	$("#listSameName").html("<i class='fa fa-spin fa-circle-o-notch'></i> Vérification d'existence");
	$("#similarLink").show();
	$("#btn-submit-form").html('<i class="fa  fa-spinner fa-spin"></i>').prop("disabled",true);
	$.ajax({
      type: "POST",
          url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
          data: data,
          dataType: "json",
          error: function (data){
             mylog.log("error"); mylog.dir(data);
             $("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false);
          },
          success: function(data){
            var str = "";
 			var compt = 0;
 			var msg = "Verifiez si cet élément n'existe pas déjà";
 			$("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false);
 			cotmp = {};
 			$.each(data, function(id, elem) {
  				mylog.log("similarlink globalautocomplete", elem);
  				city = "";
				postalCode = "";
				var htmlIco ="<i class='fa fa-users'></i>";
				if(elem.type){
					typeIco = elem.type;
					htmlIco ="<i class='fa fa-"+dyFInputs.get(elem.type).icon +"'></i>";
				}
				where = "";
				if (elem.address != null) {
					city = (elem.address.addressLocality) ? elem.address.addressLocality : "";
					postalCode = (elem.address.postalCode) ? elem.address.postalCode : "";
					if( notEmpty( city ) && notEmpty( postalCode ) )
					where = ' ('+postalCode+" "+city+")";
				}
				//var htmlIco="<i class='fa fa-calendar fa-2x'></i>";
				if("undefined" != typeof elem.profilImageUrl && elem.profilImageUrl != ""){
					htmlIco= "<img width='30' height='30' alt='image' class='img-circle' src='"+baseUrl+elem.profilThumbImageUrl+"'/>";
				}
				
				if(contact == true){
					cotmp[id] = {id:id, name : elem.name};
					str += 	"<a href='javascript:;' onclick='fillContactFields( \""+id+"\" );' class='col-sm-12 col-sm-3 btn btn-xs btn-default w50p text-left padding-5' >"+
								"<span>"+ htmlIco +"</span> <span> " + elem.name+"</br>"+where+ "</span>"
							"</a>";
					msg = "Verifiez si le contact est dans Communecter";
				}else{
					str += 	"<a target='_blank' href='#page.type."+ elem.type +".id."+ id +"' class='btn btn-xs btn-danger w50p text-left padding-5 margin-5' style='height:42px' >"+
							"<span>"+ htmlIco +"</span> <span> " + elem.name+"</br>"+where+ "</span>"
						"</a>";
				}
				
				compt++;

  			});
			
			if (compt > 0) {
				$("#listSameName").html("<div class='col-sm-12 light-border text-red'> <i class='fa fa-eye'></i> "+msg+" : </div>"+str);
				//bindLBHLinks();
			} else {
				$("#listSameName").html("<span class='txt-green'><i class='fa fa-thumbs-up text-green'></i> Aucun élément avec ce nom.</span>");

			}

			
          }
 	});
}

/*function checkUsername(username){
	
	$("#listSameName").html("<i class='fa fa-spin fa-circle-o-notch'></i> Vérification d'existence");
	$("#similarLink").show();
	$("#btn-submit-form").html('<i class="fa  fa-spinner fa-spin"></i>').prop("disabled",true);

	$.ajax({
      type: "POST",
          url: baseUrl+"/" + moduleId + "/person/checkusername",
          data: { "username" : username },
          dataType: "json",
          error: function (data){
             mylog.log("error"); mylog.dir(data);
             $("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false);
          },
          success: function(data){
            var str = "";
 			var compt = 0;
 			var msg = "Verifiez si cet élément n'existe pas déjà";
 			$("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false);
 			$("#listSameName").html("<div class='col-sm-12 light-border text-red'> <i class='fa fa-eye'></i> "+msg+" : </div>"+str);
 		}
 	});
}*/


function notEmpty(val){
	return typeof val != "undefined"
			&& val != null
			&& val != "";
}

function activeMenuElement(page) {
	mylog.log("-----------------activeMenuElement----------------------");
	listBtnMenu = [	'detail', 'news', 'directory', 'gallery', 'addmembers', 'calendar'];
	$.each(listBtnMenu, function(i,value) {
		$(".btn-menu-element-"+value).removeClass("active");
	});
	$(".btn-menu-element-"+page).addClass("active");
}

function shadowOnHeader() {
	var y = $(".my-main-container").scrollTop(); 
    if (y > 0) {  $('.main-top-menu').addClass('shadow'); }////NOTIFICATIONS}
    else { $('.main-top-menu').removeClass('shadow'); }
}
function getMediaFromUrlContent(className, appendClassName,nbParent){
    //user clicks previous thumbail
    lastUrl = "";
    $("body").on("click","#thumb_prev", function(e){        
        if(img_arr_pos>0) 
        {
            img_arr_pos--; //thmubnail array position decrement
            
            //replace with new thumbnail
            $("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="100" height="100">'+selectThumb);
            
            //replace thmubnail position text
            $("#total_imgs").html((img_arr_pos) +' of '+ total_images);
        }
    });
    
    //user clicks next thumbail
    $("body").on("click","#thumb_next", function(e){        
        if(img_arr_pos<total_images)
        {
            img_arr_pos++; //thmubnail array position increment
            
            //replace with new thumbnail
            $("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="100" height="100">'+selectThumb);
            
            //replace thmubnail position text
            $("#total_imgs").html((img_arr_pos) +' of '+ total_images);
        }
    });
    var getUrl  = $(className); //url to extract from text field
    var appendClassName = appendClassName;
    getUrl.bind("input keyup",function(e) { //user types url in text field        
        //url to match in the text field
        var $this = $(this);
        if($(appendClassName).html()==""){
        if($this.parents().eq(nbParent).find(appendClassName).html()=="" || (e.which==32 || e.which==13)){
        	//var match_url=new RegExp("(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?")
        	//var match_url=new RegExp("(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})");
        	//var match_url=/\b(https?):\/\/([\-A-Z0-9. \-]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;\-]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;\-]*)?/i
	       // var match_url = /\b(https?|ftp):\/\/([\-A-Z0-9. \-]+?|www\\.)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;\-]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;\-]*)?/i;
	       // var match_url=new RegExp("(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
	        //var match_url=/[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
	        var match_url=/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;

	        if (match_url.test(getUrl.val())) 
	        {
	        	extract_url=getUrl.val().match(match_url)[0];
	        	extract_url=extract_url.replace(/[\n]/gi," ");
	        	extract_url=extract_url.split(" ");
	        	extract_url=extract_url[0];
		        if(lastUrl != extract_url && processUrl.isLoading==false){
		        	processUrl.isLoading=true;
		        	var extracted_url = extract_url;
	                $this.parents().eq(nbParent).find(".loading_indicator").show(); //show loading indicator image
	                //ajax request to be sent to extract-process.php
	                lastUrl=extracted_url;
	                extracted_url_send=extracted_url;
	                if(extracted_url_send.indexOf("http")<0)
	                	extracted_url_send = "http://"+extracted_url;
	                $.ajax({
						url: baseUrl+'/'+moduleId+"/news/extractprocess",
						data: {'url': extracted_url_send},
						type: 'post',
						dataType: 'json',
						success: function(data){        
			                mylog.log(data); 
			                processUrl.isLoading=false;
			                if(data.type=="activityStream"){
			                  	content = '<a href="javascript:;" class="removeMediaUrl"><i class="fa fa-times"></i></a>'+
			                			 directory.showResultsDirectoryHtml(new Array(data.object), data.object.type)+
			                			"<input type='hidden' class='type' value='activityStream'>"+
										"<input type='hidden' class='objectId' value='"+data.object.id+"'>"+
										"<input type='hidden' class='objectType' value='"+data.object.type+"'>";
			                }else
		                    	content = getMediaCommonHtml(data,"save");
		                    //load results in the element
		                    //return content;
		                   //$("#results").html(content); 
		                    $this.parents().eq(nbParent).find(appendClassName).html(content).slideDown();
		                    //$this.parents().eq(nbParent).slideDown();
		                    if($this.parent().find(".dynFormUrlsWarning").length > 0)
			                   $this.parent().find(".dynFormUrlsWarning").remove(); 
		                    
		                    $(".removeMediaUrl").click(function(){
			                    $trigger=$(this).parents().eq(1).find(className);
							    $this.parents().eq(nbParent).find(appendClassName).empty().hide();
							    $trigger.trigger("input");
							});
							//append received data into the element
		                    //$("#results").slideDown(); //show results with slide down effect
		                    $this.parents().eq(nbParent).find(".loading_indicator").hide(); //hide loading indicator image
	                	},
						error : function(){
							$.unblockUI();
							//toastr.error(trad["wrongwithurl"] + " !");
							 processUrl.isLoading=false;
							//content to be loaded in #results element
							var content = '<a href="javascript:;" class="removeMediaUrl"><i class="fa fa-refresh"></i></a><h4><a href="'+extracted_url+'" target="_blank" class="lastUrl wrongUrl">'+extracted_url+'</a></h4>';
		                    //load results in the element
		                    $this.parents().eq(nbParent).find(appendClassName).hide();
		                    $this.parents().eq(nbParent).find(appendClassName).html(content);
		                    $this.parents().eq(nbParent).find(appendClassName).slideDown();
		                    toastr.warning("L'url "+extracted_url+" ne pointe vers aucun site ou un problème est survenu à son extraction");
		                    if ($("#ajaxFormModal").is(":visible") && $this.parent().find(".dynFormUrlsWarning").length <= 0)
								$this.parent().append( "<span class='text-red dynFormUrlsWarning'>* Ceci n'est pas un url valide.</span>" );         	
		                    $(".removeMediaUrl").click(function(){
			                    $trigger=$(this).parents().eq(1).find(className);
							    $this.parents().eq(nbParent).find(appendClassName).empty().hide();
							    $trigger.trigger("input");
							});

		                    //$("#results").html(content); //append received data into the element
		                    //$("#results").slideDown(); //show results with slide down effect
		                    $this.parents().eq(nbParent).find(".loading_indicator").hide(); //hide loading indicator image
						}	
	                });
				}
        	} else if ($("#ajaxFormModal").is(":visible") && $this.parent().find(".dynFormUrlsWarning").length <= 0){
				//$this.parent().append( "<span class='text-red dynFormUrlsWarning'>* Ceci n'est pas un url valide.</span>" );         	
        	}
        }
    }
    }); 
}

function getMediaCommonHtml(data,action,id){
	if(typeof(data.images)!="undefined"){
		extracted_images = data.images;
		total_images = parseInt(data.images.length);
		img_arr_pos=1;
    }
    inputToSave="";
    if(typeof(data.content) !="undefined" && typeof(data.content.imageSize) != "undefined"){
        if (data.content.videoLink){
            extractClass="extracted_thumb";
            width="100%";
            height="100%";
            thumbImg=true;
            aVideo='<a href="javascript:;" class="videoSignal text-white center"><i class="fa fa-3x fa-play-circle-o"></i><input type="hidden" class="videoLink" value="'+data.content.videoLink+'"/></a>';
            inputToSave+="<input type='hidden' class='video_link_value' value='"+data.content.videoLink+"'/>"+
            "<input type='hidden' class='media_type' value='video_link' />";   
		}
        else{
            aVideo="";
            endAVideo="";
            if(data.content.imageSize =="large"){
                extractClass="extracted_thumb_large";
                width="100%";
                height="";
                thumbImg=false;
            }
            else{
                extractClass="extracted_thumb";
                width="100";
                height="100";
            	thumbImg=true;
            }
            inputToSave+="<input type='hidden' class='media_type' value='img_link' />";
		}
		inputToSave+="<input type='hidden' class='size_img' value='"+data.content.imageSize+"'/>"
    }
    if (typeof(data.content) !="undefined" && typeof(data.content.image)!="undefined"){
        inc_image = '<div class="'+extractClass+'  col-xs-4 no-padding" id="extracted_thumb">'+aVideo;
        if(data.content.type=="img_link"){
	        if(typeof(data.content.imageId) != "undefined"){
		       inc_image += "<input type='hidden' id='deleteImageCommunevent"+id+"' value='"+data.content.imageId+"'/>";
		       titleImg = "De l&apos;application communevent"; 
		    }else
		    	titleImg = "Image partagée"; 
	        inc_image += "<a class='thumb-info' href='"+data.content.image+"' data-title='"+titleImg+"'  data-lightbox='allimgcontent'>";
	    }
        inc_image +='<img src="'+data.content.image+'" width="'+width+'" height="'+height+'">';
        if(data.content.type=="img_link")
        	inc_image += '</a>';
        inc_image += '</div>';
        countThumbail="";
        inputToSave+="<input type='hidden' class='img_link' value='"+data.content.image+"'/>";
    }
    else {
        if(typeof(total_images)!="undefined" && total_images > 0){
            if(total_images > 1){
                selectThumb='<div class="thumb_sel"><span class="prev_thumb" id="thumb_prev">&nbsp;</span><span class="next_thumb" id="thumb_next">&nbsp;</span> </div>';
                countThumbail='<span class="small_text" id="total_imgs">'+img_arr_pos+' of '+total_images+'</span><span class="small_text">&nbsp;&nbsp;Choose a Thumbnail</span>';
            }
            else{
                selectThumb="";
                countThumbail="";
            }
            inc_image = '<div class="'+extractClass+'  col-xs-4" id="extracted_thumb">'+aVideo+'<img src="'+data.images[0]+'" width="'+width+'" height="'+height+'">'+selectThumb+'</div>';
      		inputToSave+="<input type='hidden' class='img_link' value='"+data.images[0]+"'/>";      
        }else{
            inc_image ='';
            countThumbail='';
        }
    }
    
    //content to be loaded in #results element
	if(data.content==null)
		data.content="";
	if(typeof(data.url)!="undefined")
		mediaUrl=data.url;
	else if (typeof(data.content.url) !="undefined")
		mediaUrl=data.content.url;
	else
		mediaUrl="";
	if((typeof(data.description) !="undefined" || typeof(data.name) != "undefined") && (data.description !="" || data.name != "")){
		classContentDescr="col-xs-12 padding-10";
		if(thumbImg)
			classContentDescr="col-xs-8";
		contentMedia='<div class="extracted_content '+classContentDescr+'">'+
			'<a href="'+mediaUrl+'" target="_blank" class="lastUrl text-dark">';
			if(typeof(data.name) != "undefined" && data.name!=""){
				contentMedia+='<h4>'+data.name+'</h4></a>';
				inputToSave+="<input type='hidden' class='name' value='"+data.name+"'/>";
			}
			if(typeof(data.description) != "undefined" && data.description!=""){
				contentMedia+='<span>'+data.description+'</span>';
				if(typeof(data.name) == "undefined" || data.name=="")
					contentMedia+='</a>';
				inputToSave+="<input type='hidden' class='description' value='"+data.description+"'/>"; 
			}
		contentMedia+='</div>';
	}
	else{
		contentMedia="";
	}
	inputToSave+="<input type='hidden' class='url' value='"+mediaUrl+"'/>";
	inputToSave+="<input type='hidden' class='type' value='url_content'/>"; 
	content="";
	if(action == "save")
		content += '<a href="javascript:;" class="removeMediaUrl"><i class="fa fa-times"></i></a>';
    content += '<div class="extracted_url">'+ inc_image +contentMedia+'</div>'+inputToSave;
    return content;
}

function myContactLabel (type,id) { 
	if(typeof myContacts != "undefined" && myContacts[type]){
		$.each( myContacts[type], function( key,val ){
			if( id == val["_id"]["$id"] ){
				return val;
			}
		});
	}
	return null;
}

function inMyContacts (type,id) { 
	var res = false ;
	if(typeof myContacts != "undefined" && myContacts != null && myContacts[type]){
		$.each( myContacts[type], function( key,val ){
			mylog.log("val", val);
			if( ( typeof val["_id"] != "undefined" && id == val["_id"]["$id"] ) || 
				(typeof val["id"] != "undefined" && id == val["id"] ) ) {
				res = true;
				return ;
			}
		});
	}
	return res;
}

function autoCompleteInviteSearch(search){
	mylog.log("autoCompleteInviteSearch2", search);
	if (search.length < 3) { return }
	tabObject = [];

	var data = { 
		"search" : search,
		"searchMode" : "personOnly"
	};
	
	ajaxPost("", moduleId+'/search/searchmemberautocomplete', data,
		function (data){
			mylog.log(data);
			var str = "<li class='li-dropdown-scope'><a href='javascript:newInvitation()'>Pas trouvé ? Lancer une invitation à rejoindre votre réseau !</li>";
			var compt = 0;
			var city, postalCode = "";
			if(data["citoyens"].length > 0){
				$.each(data["citoyens"], function(k, v) { 
					city = "";
					mylog.log(v);
					postalCode = "";
					var htmlIco ="<i class='fa fa-user fa-2x'></i>"
					if(v.id != userId) {
						tabObject.push(v);
		 				if(v.profilImageUrl != ""){
		 					var htmlIco= "<img width='50' height='50' alt='image' class='img-circle' src='"+baseUrl+v.profilImageUrl+"'/>"
		 				}
		 				if (v.address != null) {
		 					city = v.address.addressLocality;
		 					postalCode = v.address.postalCode;
		 				}
		  				str += 	"<li class='li-dropdown-scope'>" +
		  						"<a href='javascript:setInviteInput("+compt+")'>"+htmlIco+" "+v.name ;
	
		  				if(typeof postalCode != "undefined")
		  					str += "<br/>"+postalCode+" "+city;
		  					//str += "<span class='city-search'> "+postalCode+" "+city+"</span>" ;
		  				str += "</a></li>";
	
		  				compt++;
	  				}
				});
			}
			
			$("#ajaxFormModal #dropdown_searchInvite").html(str);
			$("#ajaxFormModal #dropdown_searchInvite").css({"display" : "inline" });
		}
	);	
}

function newInvitation(){
	$("#ajaxFormModal #step1").css({"display" : "none"});
	$("#ajaxFormModal #step3").css({"display" : "block"});
	
	$('#ajaxFormModal #inviteId').val("");
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if(emailReg.test( $("#ajaxFormModal #inviteSearch").val() )){
		$('#ajaxFormModal #inviteEmail').val( $("#ajaxFormModal #inviteSearch").val());
		$("#ajaxFormModal #inviteName").val("");
	}else{
		$("#ajaxFormModal #inviteName").val($("#ajaxFormModal #inviteSearch").val());
		$("#ajaxFormModal #inviteEmail").val("");
	}
	$("#inviteText").val('');
}

function communecterUser(){
	mylog.warn("communecterUser");
	if(typeof contextData == "undefined" || contextData == null || contextData.id != userId){
		contextData = {
			id : userId,
			type : "citoyens"
		};
	}
	$.unblockUI();
	updateLocalityEntities();
}

function updateLocalityEntities(addressesIndex, addressesLocality){
	mylog.log("updateLocalityEntities", addressesIndex, addressesLocality);
	$("#ajax-modal").modal("hide");
	mylog.log("typeof formInMap.initUpdateLocality", typeof formInMap.initUpdateLocality);
	if(typeof formInMap.initUpdateLocality != "undefined"){
		var address = contextData.address ;
		var geo = contextData.geo ;
		if(addressesLocality && addressesIndex){
			address = addressesLocality.address ;
			geo = addressesLocality.geo ;
		}else if(addressesIndex) {
			address = null ;
			geo = null ;
		}
		mylog.log(address, geo, contextData.type, addressesIndex);
		formInMap.initUpdateLocality(address, geo, contextData.type, addressesIndex); 
	}

}

function cityKeyPart(unikey, part){
	var s = unikey.indexOf("_");
	var e = unikey.indexOf("-");
	var len = unikey.length;
	if(e < 0) e = len;
	if(part == "insee") return unikey.substr(s+1, e - s-1);
	if(part == "cp" && unikey.indexOf("-") < 0) return "";
	if(part == "cp") return unikey.substr(e+1, len);
	if(part == "country") return unikey.substr(e+1, len);
}
/* ***********************************
			EXTRACTPROCCESS
********************************** */
var processUrl = {
	isLoading:false,
	checkUrlExists: function(url){
	    url = url.trim();
	    if(url.lastIndexOf("/") == url.lenght){
	        url = url.substr(0, url.lenght-1);
	        $("#form-url").val(url); 
	    }

	    $.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/app/checkurlexists",
	        data: { url: url },
	        dataType: "json",
	        success: function(data){ console.log("checkUrlExists", data);
	            if(data.status == "URL_EXISTS")
	            urlExists = true;
	            else
	            urlExists = false;
	            console.log("checkUrlExists", data);
	            refUrl(url);
	        },
	        error: function(data){
	            console.log("check url exists error");
	        }
	    });
	},
	refUrl: function(url){
	    if(!processUrl.isValidURL(url)){
	        $("#status-ref").html("<span class='letter-red'><i class='fa fa-times'></i> cette url n'est pas valide.</span>");
	        return;
	    }
		$("#status-ref").html("<span class='letter-blue'><i class='fa fa-spin fa-refresh'></i> "+trad.currentlyresearching+"</span>");
		$("#refResult").addClass("hidden");
		$("#send-ref").addClass("hidden");

		urlValidated = "";

	    $.ajax({ 
	    	url: "//cors-anywhere.herokuapp.com/" + url, // 'http://google.fr', 
	    	//crossOrigin: true,
	    	timeout:10000,
	        success:
				function(data) {
					
				    var jq = $.parseHTML(data);
				    
				    var tempDom = $('<output>').append($.parseHTML(data));
				    var title = $('title', tempDom).html();
				    var stitle = "";

				    if(stitle=="" || stitle=="undefined")
				   		stitle = $('blockquote', tempDom).html();

				   	//console.log("STITLE", stitle);

					if(stitle=="" || stitle=="undefined")
				   		stitle = $('h2', tempDom).html();

					if(stitle=="" || stitle=="undefined")
				   		stitle = $('h3', tempDom).html();

					if(stitle=="" || stitle=="undefined")
				   		stitle = $('blockquote', tempDom).html();

					if(title=="" || title=="undefined")
				   		title = stitle;

	                var favicon = $("link[rel*='icon']", tempDom).attr("href");
	                var hostname = (new URL(url)).origin;
	                var faviconSrc = "";
	                if(typeof favicon != "undefined"){
	                    var faviconSrc = hostname+favicon;
	                    if(favicon.indexOf("http")>=0) faviconSrc = favicon;
	                }

					var description = $(tempDom).find('meta[name=description]').attr("content");

					var keywords = $(tempDom).find('meta[name=keywords]').attr("content");
					//console.log("keywords", keywords);

					var arrayKeywords = new Array();
					if(typeof keywords != "undefined")
						arrayKeywords = keywords.split(",");

					//console.log("arrayKeywords", arrayKeywords);

					//if(typeof arrayKeywords[0] != "undefined") $("#form-keywords1").val(arrayKeywords[0]); else $("#form-keywords1").val("");
					//if(typeof arrayKeywords[1] != "undefined") $("#form-keywords2").val(arrayKeywords[1]); else $("#form-keywords2").val("");
					//if(typeof arrayKeywords[2] != "undefined") $("#form-keywords3").val(arrayKeywords[2]); else $("#form-keywords3").val("");
					//if(typeof arrayKeywords[3] != "undefined") $("#form-keywords4").val(arrayKeywords[3]); else $("#form-keywords4").val("");

					if(description=="" || description=="undefined")
				   		if(stitle=="" || stitle=="undefined")
				   			description = stitle;
				   	params = new Object;
				   	params.title=title,
				   	params.favicon=faviconSrc,
				   	params.hostname=hostname,
				   	params.description=description,
				   	params.tags=arrayKeywords;
					console.log(params);
					/*$("#form-title").val(title);
	                $("#form-favicon").val(faviconSrc);
	                $("#form-description").val(description);*/
					

					//color
					$("#ajaxFormModal #name").val(title);   	
				   	//color	
					$("#ajaxFormModal #description").val(description); 
				   	//color
				   	if(notEmpty(arrayKeywords))		
						$("#ajaxFormModal #tags").select2("val",arrayKeywords);
					/*if($("#form-keywords1").val() != "")   $("#lbl-keywords").removeClass("text-orange").addClass("letter-green");
					else 								   $("#lbl-keywords").removeClass("letter-green").addClass("text-orange");
				   		
				   	$("#form-title").off().keyup(function(){
				   		if($(this).val()!="")$("#lbl-title").removeClass("letter-red").addClass("letter-green");
						else 				 $("#lbl-title").removeClass("letter-green").addClass("letter-red");
						checkAllInfo();
				   	});
				   	$("#form-description").off().keyup(function(){
				   		if($(this).val()!="")$("#lbl-description").removeClass("text-orange").addClass("letter-green");
						else 				 $("#lbl-description").removeClass("letter-green").addClass("text-orange");
						checkAllInfo();
				   	});
				   	$("#form-keywords1").off().keyup(function(){
				   		if($(this).val()!="")$("#lbl-keywords").removeClass("text-orange").addClass("letter-green");
						else 				 $("#lbl-keywords").removeClass("letter-green").addClass("text-orange");
						checkAllInfo();
				   	});

				   	$("#status-ref").html("<span class='letter-green'><img src='"+faviconSrc+"' height=30 alt='x'> <i class='fa fa-check'></i> Nous avons trouvé votre page</span>");
	    			$("#refResult").removeClass("hidden");
				   
				   	$("#lbl-url").removeClass("letter-red").addClass("letter-green");
				   	urlValidated = url;

				    $('<output>').remove();
				    tempDom = "";

				    checkAllInfo();*/	
				    return params;		   
				},
			error:function(xhr, status, error){
				$("#lbl-url").removeClass("letter-green").addClass("letter-red");
				$("#status-ref").html("<span class='letter-red'><i class='fa fa-ban'></i> URL INNACCESSIBLE</span>");
			},
			statusCode:{
				404: function(){
					$("#lbl-url").removeClass("letter-green").addClass("letter-red");
					$("#status-ref").html("<span class='letter-red'><i class='fa fa-ban'></i> 404 : URL INTROUVABLE OU INACCESSIBLE</span>");
				}
			}
		});
	},
	isValidURL:function(url) {
  		var match_url = new RegExp("(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
  		return match_url.test(url);
	}
}
/* *********************************
			COLLECTIONS
********************************** */

var collection = {
	crud : function (action, name,type,id) { 
		if(userId){
			var params = {};
			var sure = true;
			if(typeof type != "undefined")
				params.type = type;
			if(typeof id != "undefined")
				params.id = id;
			if(typeof action == "undefined")
				action = "new";
			if(action == "del"){
				params.name = name;
				sure = confirm("Vous êtes sûr ?");
			}
			else if(action == "new" || action == "update")
				params.name = prompt(tradDynForm.collectionname+' ?',name);
			if(action == "update")
				params.oldname = name;
			
			if(sure)
			{
				ajaxPost(null,baseUrl+"/"+moduleId+"/collections/crud/action/"+action ,params,function(data) { 
					console.warn(params.action);
					if(data.result){
						toastr.success(data.msg);
						if(location.hash.indexOf("#page") >=0){
							loadDataDirectory("collections", "star");
						}
						//if no type defined we are on user
						//TODO : else add on the contextMap
						if( typeof type == "undefined" && action == "new"){
							if(!userConnected.collections)
								userConnected.collections = {};
							if(!userConnected.collections[params.name])
								userConnected.collections[params.name] = {};
						}else if(action == "update"){
							smallMenu.openAjax(baseUrl+'/'+moduleId+'/collections/list/col/'+params.name,params.name,'fa-folder-open','yellow');
							if(!userConnected.collections[params.name])
								userConnected.collections[params.name] = userConnected.collections[ params.oldname ];
							delete userConnected.collections[ params.oldname ];
						}else if(action == "del"){
							delete userConnected.collections[params.name];
							smallMenu.open();
						}
						collection.buildCollectionList("col_Link_Label_Count",".menuSmallBtns", function() { $(".collection").remove() })
					}
					else
						toastr.error(data.msg);
				}, "none");
			}
		} else
			toastr.error(trad.LoginFirst);
	},
	applyColor : function (what,id,col) {
		var collection = (typeof col == "undefined") ? "favorites" : col;
		console.log("applyColor",what,id)
		if(userConnected && userConnected.collections && userConnected.collections[collection] && userConnected.collections[collection][what] && userConnected.collections[collection][what][id] ){
			$(".star_"+what+"_"+id).children("i").removeClass("fa-star-o").addClass('fa-star text-red');
			console.warn("applying Color",what,id)
		}
	},
	add2fav : function (what,id,col){
		var collection = (typeof col == "undefined") ? "favorites" : col;
		if(userId){
			var params = { id : id, type : what, collection : collection };
			var el = ".star_"+what+"_"+id;
			
			ajaxPost(null,baseUrl+"/"+moduleId+"/collections/add",params,function(data) { 
				console.warn(params.action,collection,what,id);
				if(data.result){
					if(data.list == '$unset'){
						/*if(location.hash.indexOf("#page") >=0){
							if(location.hash.indexOf("view.directory.dir.collections") >=0 && contextData.id==userId){ 
                				loadDataDirectory("collections", "star"); 
              				}else{ 
                				$(".favorisMenu").removeClass("text-yellow"); 
                				$(".favorisMenu").children("i").removeClass("fa-star").addClass('fa-star-o'); 
              				} 
						}else{*/
							$(el).removeClass("text-yellow"); 
							$(el).children("i").removeClass("fa-star text-yellow").addClass('fa-star-o');
							delete userConnected.collections[collection][what][id];
						//}
					}
					else{
						/*if(location.hash.indexOf("#page") >=0){
							if(location.hash.indexOf("view.directory.dir.collections") >=0 && contextData.id==userId){ 
                				loadDataDirectory("collections", "star"); 
              				}else{ 
                				$(".favorisMenu").addClass("text-yellow"); 
                				$(".favorisMenu").children("i").removeClass("fa-star-o").addClass('fa-star'); 
              				}
              			}
						else*/
							$(el).addClass("text-yellow"); 
							$(el).children("i").removeClass("fa-star-o").addClass('fa-star text-yellow');

						if(!userConnected.collections)
							userConnected.collections = {};
						if(!userConnected.collections[collection])
							userConnected.collections[collection] = {};
						if(!userConnected.collections[collection][what])
							userConnected.collections[collection][what] = {};
						userConnected.collections[collection][what][id] = new Date();	
					}
					toastr.success(data.msg);
				}
				else
					toastr.error(data.msg);
			},"none");
		} else
			toastr.error(trad.LoginFirst);
	},
	buildCollectionList : function ( tpl, appendTo, reset ) {
		if(typeof reset == "function")
			reset();
		str = "";
		$.each(userConnected.collections, function(col,list){ 
			var colcount = 0;
			$.each(list, function(type,entries){
				colcount += Object.keys(entries).length;
			}); 
			str += js_templates[ tpl ]({
				label : col,
				labelCount : colcount
			}) ;
		});
		$(appendTo).append(str);
	}
};

/* *********************************
			DYNFORM SPEC TYPE OBJ
********************************** */
var contextData = null;
var dynForm = null;
var mentionsInput=[];
var mentionsInit = {
	stopMention : false,
	isSearching : false,
	get : function(domElement){
		mentionsInput=[];
		$(domElement).mentionsInput({
		  onDataRequest:function (mode, query, callback) {
			  	if(mentionsInit.stopMention)
			  		return false;
			  	var data = mentionsContact;
			  	data = _.filter(data, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });
				callback.call(this, data);
				mentionsInit.isSearching=true;
		   		var search = {"searchType" : ["citoyens","organizations","projects"]};
		  		$.ajax({
					type: "POST",
			        url: baseUrl+"/"+moduleId+"/search/globalautocomplete",
			        data: search,
			        dataType: "json",
			        success: function(retdata){
			        	if(!retdata){
			        		toastr.error(retdata.content);
			        	}else{
				        	mylog.log(retdata);
				        	data = [];
				        	//for(var key in retdata){
					        //	for (var id in retdata[key]){
					        $.each(retdata, function (e, value){
						        	avatar="";
						        	//console.log(retdata[key]);
						        	//aert(retdata[key][id].type);
						        	if(typeof value.profilThumbImageUrl != "undefined" && value.profilThumbImageUrl!="")
						        		avatar = baseUrl+value.profilThumbImageUrl;
						        	object = new Object;
						        	object.id = e;
						        	object.name = value.name;
						        	object.slug = value.slug;
						        	object.avatar = avatar;
						        	object.type = value.type;
						        	var findInLocal = _.findWhere(mentionsContact, {
										name: value.name, 
										type: value.type
									}); 
									if(typeof(findInLocal) == "undefined")
										mentionsContact.push(object);
						 	//		}
				        	//}
				        	});
				        	data=mentionsContact;
				        	mylog.log(data);
				    		data = _.filter(data, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });
							callback.call(this, data);
							mylog.log(callback);
			  			}
					}	
				})
		  	}
	  	});
	},
	beforeSave : function(object, domElement){
		$(domElement).mentionsInput('getMentions', function(data) {
			mentionsInput=data;
		});
		if (typeof mentionsInput != "undefined" && mentionsInput.length != 0){
			var textMention="";
			$(domElement).mentionsInput('val', function(text) {
				textMention=text;
				$.each(mentionsInput, function(e,v){
					strRep=v.name;
					if(typeof v.slug != "undefined")
						strRep="@"+v.slug;
					textMention = textMention.replace("@["+v.name+"]("+v.type+":"+v.id+")", strRep);
				});
			});			
			object.mentions=mentionsInput;
			object.text=textMention;
		}
		return object;		      		
	},
	addMentionInText: function(text,mentions){
		$.each(mentions, function( index, value ){
			if(typeof value.slug != "undefined"){
				str="<span class='lbh' onclick='urlCtrl.loadByHash(\"#page.type."+value.type+".id."+value.id+"\")' onmouseover='$(this).addClass(\"text-blue\");this.style.cursor=\"pointer\";' onmouseout='$(this).removeClass(\"text-blue\");' style='color: #719FAB;'>"+
		   						value.name+
		   					"</span>";
				text = text.replace("@"+value.slug, str);
			}else{
				//Working on old news
		   		array = text.split(value.value);
		   		text=array[0]+
		   					"<span class='lbh' onclick='urlCtrl.loadByHash(\"#page.type."+value.type+".id."+value.id+"\")' onmouseover='$(this).addClass(\"text-blue\");this.style.cursor=\"pointer\";' onmouseout='$(this).removeClass(\"text-blue\");' style='color: #719FAB;'>"+
		   						value.name+
		   					"</span>"+
		   				array[1];
		   	}   					
		});
		return text;
	},
	reset: function(domElement){
		$(domElement).mentionsInput('reset');
	}
}
var uploadObj = {
	type : null,
	id : null,
	gotoUrl : null,
	isSub : false,
	update  : false,
	folder : "communecter", //on force pour pas casser toutes les vielles images
	contentKey : "profil",
	path : null,
	extra : null,
	set : function(type,id, file){
		if(notNull(file) && file){
			mylog.log("set uploadObj", id,type,uploadObj.folder,uploadObj.contentKey);
			uploadObj.type = type;
			uploadObj.id = id;
			uploadObj.path = baseUrl+"/"+moduleId+"/document/uploadSave/dir/"+uploadObj.folder+"/folder/"+type+"/ownerId/"+id+"/input/qqfile/docType/file";
		}
		else if(typeof type != "undefined"){
			mylog.log("set uploadObj", id,type,uploadObj.folder,uploadObj.contentKey);
			uploadObj.type = type;
			uploadObj.id = id;
			uploadObj.path = baseUrl+"/"+moduleId+"/document/uploadSave/dir/"+uploadObj.folder+"/folder/"+type+"/ownerId/"+id+"/input/qqfile/contentKey/"+uploadObj.contentKey;
		} else {
			uploadObj.type = null;
			uploadObj.id = null;
			uploadObj.path = null;
		}
	}
};

var dyFObj = {
	elementObj : null,
	elementData : null,
	subElementObj : null,
	subElementData : null,
	activeElem : null,
	activeModal : null,
	//rules to show hide submit btn, used anwhere on blur and can be 
	//completed by specific rules on dynForm Obj
	//ex : dyFObj.elementObj.dynForm.jsonSchema.canSubmitIf
	canSubmitIf : function () { 
    	var valid = true;
    	//on peut ajouter des regles dans la map definition 
    	if(	jsonHelper.notNull("dyFObj.elementObj.dynForm.jsonSchema.canSubmitIf", "function") )
    		valid = dyFObj.elementObj.dynForm.jsonSchema.canSubmitIf();
    	if( $('#ajaxFormModal #name').length == 0 || $('#ajaxFormModal #name').val() != "" && valid )
    		$('#btn-submit-form').show();
    	else 
    		$('#btn-submit-form').hide();
		//tmp
		$('#btn-submit-form').show();
    },
	formatData : function (formData, collection,ctrl) { 
		mylog.warn("----------- formatData",formData, collection,ctrl);
		formData.collection = collection;
		formData.key = ctrl;
		if( $.isArray(formData.id) )
			formData.id = formData.id[0]; //this shouldn't happen, occurs in survey

		if(dyFInputs.locationObj.centerLocation){
			//formData.multiscopes = elementLocation;
			formData.address = dyFInputs.locationObj.centerLocation.address;
			formData.geo = dyFInputs.locationObj.centerLocation.geo;
			formData.geoPosition = dyFInputs.locationObj.centerLocation.geoPosition;
			if( dyFInputs.locationObj.elementLocations.length ){
				$.each( dyFInputs.locationObj.elementLocations,function (i,v) { 
					mylog.log("elementLocations v", v);
					if(typeof v != "undefined" && typeof v.center != "undefined" ){
						dyFInputs.locationObj.elementLocations.splice(i, 1);
					}
				});
				formData.addresses = dyFInputs.locationObj.elementLocations;
			}
		}
		
		formData.medias = [];
		$(".resultGetUrl").each(function(){
			if($(this).html() != ""){
				mediaObject=new Object;	
				if($(this).find(".type").val()=="url_content"){
					mediaObject.type=$(this).find(".type").val();
					if($(this).find(".name").length)
						mediaObject.name=$(this).find(".name").val();
					if($(this).find(".description").length)
						mediaObject.description=$(this).find(".description").val();
					mediaObject.content=new Object;
					mediaObject.content.type=$(this).find(".media_type").val(),
					mediaObject.content.url=$(this).find(".url").val(),
					mediaObject.content.image=$(this).find(".img_link").val();
					if($(this).find(".size_img").length)
						mediaObject.content.imageSize=$(this).find(".size_img").val();
					if($("#form-news #results .video_link_value").length)
						mediaObject.content.videoLink=$(this).find(".video_link_value").val();
				}
				else{
					mediaObject.type=$(this).find(".type").val(),
					mediaObject.countImages=$(this).find(".count_images").val(),
					mediaObject.images=[];
					$(".imagesNews").each(function(){
						mediaObject.images.push($(this).val());	
					});
				}
				formData.medias.push(mediaObject);
			}
		});
		if( typeof formData.source != "undefined" && formData.source != "" ){
			formData.source = { insertOrign : "network",
								keys : [ 
									formData.source
								],
								key : formData.source
							}
		}
		
		if( typeof formData.tags != "undefined" && formData.tags != "" )
			formData.tags = formData.tags.split(",");
		
		
		// Add collections and genres of notragora in tags
		if( typeof formData.collections != "undefined" && formData.collections != "" ){
			collectionsTagsSave=formData.collections.split(",");
			if(!formData.tags)formData.tags = [];
			$.each(collectionsTagsSave, function(i, e) {
				formData.tags.push(e);
			});
			delete formData['collections'];
		}

		if( typeof formData.genres != "undefined" && formData.genres != "" ){
			genresTagsSave=formData.genres.split(",");
			if(!formData.tags)formData.tags = [];
			$.each(genresTagsSave, function(i, e) {
				formData.tags.push(e);
			});
			delete formData['genres'];
		}

		if(typeof formData.isUpdate == "undefined" || !formData.isUpdate)
			removeEmptyAttr(formData);
		else
			delete formData["isUpdate"];

		mylog.dir(formData);
		return formData;
	},

	saveElement : function  ( formId,collection,ctrl,saveUrl,afterSave ) { 
		//alert("saveElement");
		mylog.warn("---------------- saveElement",formId,collection,ctrl,saveUrl,afterSave );
		formData = $(formId).serializeFormJSON();
		mylog.log("before",formData);

		if( jsonHelper.notNull( "dyFObj.elementObj.dynForm.jsonSchema.formatData","function") )
			formData = dyFObj.elementObj.dynForm.jsonSchema.formatData(formData);

		formData = dyFObj.formatData(formData,collection,ctrl);
		mylog.log("saveElement", formData);
		formData.medias = [];
		$(".resultGetUrl").each(function(){
			if($(this).html() != ""){
				mediaObject=new Object;	
				if($(this).find(".type").val()=="url_content"){
					mediaObject.type=$(this).find(".type").val();
					if($(this).find(".name").length)
						mediaObject.name=$(this).find(".name").val();
					if($(this).find(".description").length)
						mediaObject.description=$(this).find(".description").val();
					mediaObject.content=new Object;
					mediaObject.content.type=$(this).find(".media_type").val(),
					mediaObject.content.url=$(this).find(".url").val(),
					mediaObject.content.image=$(this).find(".img_link").val();
					if($(this).find(".size_img").length)
						mediaObject.content.imageSize=$(this).find(".size_img").val();
					if($(this).find(".video_link_value").length)
						mediaObject.content.videoLink=$(this).find(".video_link_value").val();
				}
				else{
					mediaObject.type=$(this).find(".type").val(),
					mediaObject.countImages=$(this).find(".count_images").val(),
					mediaObject.images=[];
					$(".imagesNews").each(function(){
						mediaObject.images.push($(this).val());	
					});
				}
				formData.medias.push(mediaObject);
			}
		});
		if(formData.medias.length == 0)
			delete formData.medias;
		mylog.log("beforeAjax",formData);

		if( dyFObj.elementObj.dynForm.jsonSchema.debug ){
			mylog.log("debug dyn Form xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
			mylog.dir(formData);
			dyFObj.closeForm();
			mylog.log("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
		} else {
			$.ajax( {
		    	type: "POST",
		    	url: (saveUrl) ? saveUrl : baseUrl+"/"+moduleId+"/element/save",
		    	data: formData,
		    	dataType: "json",
		    	success: function(data){
		    		mylog.warn("saveElement ajax result");
		    		mylog.dir(data);
					if(data.result == false){
		                toastr.error(data.msg);
		                //reset save btn 
		                $("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false).one(function() { 
							$( settings.formId ).submit();	        	
				        });
		           	}
		            else {
		            	if(typeof data.msg != "undefined") 
		            		toastr.success(data.msg);
		            	else{
		            		if(typeof data.resultGoods != "undefined" && typeof data.resultGoods.msg != "undefined")
		            			toastr.success(data.resultGoods.msg);
		            		if(typeof data.resultErrors != "undefined" && typeof data.resultErrors.msg != "undefined")
		            			toastr.error(data.resultErrors.msg);
		            	}
		            	// mylog.log("data.id", data.id, data.url);
		            	/*if(data.map && $.inArray(collection, ["events","organizations","projects","citoyens"] ) !== -1)
				        	addLocationToFormloopEntity(data.id, collection, data.map);*/
				        	
				        if (typeof afterSave == "function"){
		            		afterSave(data);
		            		//urlCtrl.loadByHash( '#'+ctrl+'.detail.id.'+data.id );
		            	} else {
							dyFObj.closeForm();
			                if(data.url){
			                	mylog.log("urlReload data.url", data.url);
			                	urlCtrl.loadByHash( data.url );
			                }
			                else if(data.id){
			                	mylog.log("urlReload", '#'+ctrl+'.detail.id.'+data.id);
				        		urlCtrl.loadByHash( '#'+ctrl+'.detail.id.'+data.id );
			                }
						}
		            }
		            uploadObj.set()
		    	}
		    });
		}
	},
	closeForm : function() {
		$('#ajax-modal').modal("hide");
	    //clear the unecessary DOM 
	    $("#ajaxFormModal").html(''); 
	   	uploadObj.set();
	    uploadObj.update = false;
	},
	editElement : function (type,id){
		mylog.warn("--------------- editElement ",type,id);
		//get ajax of the elemetn content
		uploadObj.set(type,id);
		uploadObj.update = true;

		$.ajax({
	        type: "GET",
	        url: baseUrl+"/"+moduleId+"/element/get/type/"+type+"/id/"+id,
	        dataType : "json"
	    })
	    .done(function (data) {
	        if ( data && data.result ) {
	        	//toastr.info(type+" found");
	        	
				//onLoad fill inputs
				//will be sued in the dynform  as update 
				data.map.id = data.map["_id"]["$id"];
				if(typeof typeObj[type].formatData == "function")
					data = typeObj[type].formatData();

				delete data.map["_id"];
				mylog.dir(data);
				console.log("editElement", data);
				dyFObj.elementData = data;
				dyFObj.openForm( dyFInputs.get(type).ctrl ,null, data.map);
	        } else {
	           toastr.error("something went wrong!! please try again.");
	        }
	    });
	},
	
	//entry point function for opening dynForms
	openForm : function  (type, afterLoad,data,isSub) { 
	    //mylog.clear();
	    $.unblockUI();
	    $("#openModal").modal("hide");
	    mylog.warn("--------------- Open Form ",type, afterLoad,data);
	    mylog.dir(data);
	    uploadObj.contentKey="profil"; 
	    dyFObj.activeElem = (isSub) ? "subElementObj" : "elementObj";
	    dyFObj.activeModal = (isSub) ? "#openModal" : "#ajax-modal";
      	/*if(type=="addPhoto") 
        	uploadObj.contentKey="slider";*/ 
	    //BOUBOULE ICI ACTIVER LEVENEMENT
	    //initKSpec();
	    if(userId)
		{
			formInMap.formType = type;
			dyFObj.getDynFormObj(type, function() { 
				dyFObj.starBuild(afterLoad,data);
			},afterLoad, data);
		} else {
			dyFObj.openFormAfterLogin = {
				type : type, 
				afterLoad : afterLoad,
				data : data
			};
			toastr.error(tradDynForm["mustbeconnectforcreateform"]);
			$('#modalLogin').modal("show");
		}
	},
	//get the specification of a given dynform
	//can be of 3 types 
	//(string) :: will get the definition if exist in typeObj[key].dybnForm
	//if doesn't exist tries to lazyload it from assets/js/dynForm
	//(object) :: is dynformp definition
	getDynFormObj : function(type, callback,afterLoad, data ){
		//alert(type+'.js');
		mylog.warn("------------ getDynFormObj",type, callback,afterLoad, data );
		if(typeof type == "object"){
			mylog.log(" object directly Loaded : ", type);
			dyFObj[dyFObj.activeElem] = type;
			if( notNull(type.col) ) uploadObj.type = type.col;
    		callback(type, afterLoad, data);
		}else if( jsonHelper.notNull( "typeObj."+type+".dynForm" , "object") ){
			mylog.log(" typeObj Loaded : ", type);
			dyFObj[dyFObj.activeElem] = dyFInputs.get(type);
			if( notNull(dyFInputs.get(type).col) ) uploadObj.type = dyFInputs.get(type).col;
    		callback( dyFObj[dyFObj.activeElem], afterLoad, data );
		}else {
			//TODO : pouvoir surchargé le dossier dynform dans le theme
			//via themeObj.dynForm.folder overload
			var dfPath = (jsonHelper.notNull( "themeObj.dynForm.folder") ) ? themeObj.dynForm.folder : moduleUrl+'/js/dynForm/';
			lazyLoad( dfPath+type+'.js', 
				null,
				function() { 
					//alert(dfPath+type+'.js');
					mylog.log("lazyLoaded",moduleUrl+'/js/dynForm/'+type+'.js');
					mylog.dir(dynForm);
					//typeObj[type].dynForm = dynForm;
				  	dyFInputs.get(type).dynForm = dynForm;
					dyFObj[dyFObj.activeElem] = dyFInputs.get(type);
					if( notNull(dyFInputs.get(type).col) ) uploadObj.type = dyFInputs.get(type).col;
    				callback( afterLoad, data );
			});
		}
	},
	//prepare information for the modal panel 
	//and launches the build process
	starBuild : function  (afterLoad, data) { 
		mylog.warn("------------ starBuild",dyFObj[dyFObj.activeElem], afterLoad, data,dyFObj.activeModal );
		mylog.dir(dyFObj[dyFObj.activeElem]);
		$(dyFObj.activeModal+" .modal-header").removeClass("bgEvent bgOrga bgProject bgPerson bgDDA");//.addClass(dyFObj[elem].bgClass);
		$(dyFObj.activeModal+" #ajax-modal-modal-title").html("<i class='fa fa-refresh fa-spin'></i> Chargement en cours. Merci de patienter.");
		$(dyFObj.activeModal+" #ajax-modal-modal-title").removeClass("text-dark text-green text-azure text-purple text-orange text-blue text-turq");
		
	  	$(dyFObj.activeModal+" #ajax-modal-modal-body").html( "<div class='row bg-white'>"+
	  										"<div class='col-sm-10 col-sm-offset-1'>"+
							              	"<div class='space20'></div>"+
							              	//"<h1 id='proposerloiFormLabel' >Faire une proposition</h1>"+
							              	"<form id='ajaxFormModal' enctype='multipart/form-data'></form>"+
							              	"</div>"+
							              "</div>");
	  	$(dyFObj.activeModal+' .modal-footer').hide();
	  	$(dyFObj.activeModal).modal("show");

	  	dyFInputs.init();
	  	afterLoad = ( notNull(afterLoad) ) ? afterLoad : null;
	  	data = ( notNull(data) ) ? data : {}; 
	  	dyFObj.buildDynForm(afterLoad, data,dyFObj[dyFObj.activeElem],dyFObj.activeModal+" #ajaxFormModal");
	  	//if(typeof dyFObj[dyFObj.currentKFormType].color != "undefined")
	  		//$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
									  	  //.addClass(dyFObj[dyFObj.currentKFormType].color);
		//alert("CO "+typeObj[currentKFormType].color);
                    
	  	//$(dyFObj.activeModal+" #ajax-modal-modal-title").html((typeof dyFObj[dyFObj.activeElem].title != "undefined") ? dyFObj[dyFObj.activeElem].title : "");
	},
	/*subDynForm : function(type, afterLoad,data) {
		smallMenu.open();
		$("#openModal div.modal-content div.container")..html( "<div class='row bg-white'>"+
	  										"<div class='col-sm-10 col-sm-offset-1'>"+
							              	"<div class='space20'></div>"+
							              	//"<h1 id='proposerloiFormLabel' >Faire une proposition</h1>"+
							              	"<form id='subFormModal' enctype='multipart/form-data'></form>"+
							              	"</div>"+
							              "</div>");
		dyFObj.buildDynForm(afterLoad, data,dyFObj.subElementObj,"#openModal #subFormModal");

	},*/
	buildDynForm : function (afterLoad,data,obj,formId) { 
		mylog.warn("--------------- buildDynForm", dyFObj[dyFObj.activeElem], afterLoad,data);
		if(userId)
		{ 
			var form = $.dynForm({
			      formId : formId,
			      formObj : dyFObj[dyFObj.activeElem].dynForm,
			      formValues : data,
			      beforeBuild : function  () {

			      	if( jsonHelper.notNull( "dyFObj."+dyFObj.activeElem+".dynForm.jsonSchema.beforeBuild","function") )
				        	dyFObj[dyFObj.activeElem].dynForm.jsonSchema.beforeBuild();
			      },
			      onLoad : function  () {

			      	if( jsonHelper.notNull("themeObj.dynForm.onLoadPanel","function") ){
			      		themeObj.dynForm.onLoadPanel(dyFObj[dyFObj.activeElem]);
			      	} else {
				        $("#ajax-modal-modal-title").html("<i class='fa fa-"+dyFObj[dyFObj.activeElem].dynForm.jsonSchema.icon+"'></i> "+dyFObj[dyFObj.activeElem].dynForm.jsonSchema.title);
				        //alert(afterLoad+"|"+typeof dyFObj[dyFObj.activeElem].dynForm.jsonSchema.onLoads[afterLoad]);
			    	}
			        
			        if( jsonHelper.notNull( "dyFObj."+dyFObj.activeElem+".dynForm.jsonSchema.onLoads."+afterLoad, "function") )
			        	dyFObj[dyFObj.activeElem].dynForm.jsonSchema.onLoads[afterLoad](data);
			        //incase we need a second global post process
			        if( jsonHelper.notNull( "dyFObj."+dyFObj.activeElem+".dynForm.jsonSchema.onLoads.onload", "function") )
			        	dyFObj[dyFObj.activeElem].dynForm.jsonSchema.onLoads.onload(data);
				    
			        bindLBHLinks();
			      },
			      onSave : function(){

			      	if( typeof dyFObj[dyFObj.activeElem].dynForm.jsonSchema.beforeSave == "function")
			        	dyFObj[dyFObj.activeElem].dynForm.jsonSchema.beforeSave();

			        var afterSave = ( typeof dyFObj[dyFObj.activeElem].dynForm.jsonSchema.afterSave == "function") ? dyFObj[dyFObj.activeElem].dynForm.jsonSchema.afterSave : null;
			        mylog.log("onSave ", dyFObj.activeElem, dyFObj[dyFObj.activeElem].saveUrl, dyFObj[dyFObj.activeElem].save);
			        if( dyFObj[dyFObj.activeElem].save )
			        	dyFObj[dyFObj.activeElem].save(dyFObj.activeModal+" #ajaxFormModal");
			        if( dyFObj[dyFObj.activeElem].dynForm.jsonSchema.save )
			        	dyFObj[dyFObj.activeElem].dynForm.jsonSchema.save(); //use this for subDynForms
			        else if(dyFObj[dyFObj.activeElem].saveUrl)
			        	dyFObj.saveElement( "#ajaxFormModal", dyFObj[dyFObj.activeElem].col, dyFObj[dyFObj.activeElem].ctrl, dyFObj[dyFObj.activeElem].saveUrl, afterSave );
			        else
			        	dyFObj.saveElement( "#ajaxFormModal", dyFObj[dyFObj.activeElem].col, dyFObj[dyFObj.activeElem].ctrl, null, afterSave );
			        return false;
			    }
			});
			mylog.dir(form);
		} else {
			toastr.error("Vous devez être connecté pour afficher les formulaires de création");
			$('#modalLogin').modal("show");
		}
	},

	//generate Id for upload feature of this element 
	setMongoId : function(type,callback) { 
		uploadObj.type = type;
		mylog.warn("uploadObj ",uploadObj);
		if( !$("#ajaxFormModal #id").val() && !uploadObj.update )
		{
			getAjax( null , baseUrl+"/api/tool/get/what/mongoId" , function(data){
				mylog.log("setMongoId uploadObj.id", data.id);
				uploadObj.set(type,data.id);
				$("#ajaxFormModal #id").val(data.id);
				if( typeof callback === "function" )
                	callback();
			});
		}
	},
	editDynForm : function(title, icon, properties, fct, data, saveUrl, onLoads, beforeSave, afterSave) {
		mylog.warn("---------------------- editDynForm ------------------");
		var form = {
			dynForm:{
				jsonSchema : {
					title : title,
					icon : icon,
					properties : properties
				}
			}
		};

		if(typeof saveUrl != "undefined" )
			form.saveUrl = saveUrl;

		if(typeof onLoads != "undefined" )
			form.dynForm.jsonSchema.onLoads = onLoads;

		if(typeof beforeSave != "undefined" )
			form.dynForm.jsonSchema.beforeSave = beforeSave;

		if(typeof afterSave != "undefined" )
			form.dynForm.jsonSchema.afterSave = afterSave;

		mylog.dir(form);

		dyFObj.openForm(form, fct, data);
	},
	canUserEdit : function ( ) {
		var res = false;
		if( userId && userConnected && userConnected.links && contextData ){
			if(contextData.type == "organizations" && userConnected.links.memberOf[contextData.id].isAdmin )
				res = true;
			if(contextData.type == "events" && userConnected.links.events[contextData.id].isAdmin )
				res = true;
			if(contextData.type == "projects" && userConnected.links.projects[contextData.id].isAdmin )
				res = true;
		}
		return res;
	}
}
//TODO : refactor into dyfObj.inputs
var dyFInputs = {

	init : function() {
		 //global variables clean up
		dyFInputs.locationObj.elementLocation = null;
	    dyFInputs.locationObj.elementLocations = [];
	    dyFInputs.locationObj.centerLocation = null;
	    dyFInputs.locationObj.countLocation = 0 ;
	    dyFInputs.locationObj.addresses = (typeof dyFObj.elementData != "undefined" && dyFObj.elementData != null && typeof dyFObj.elementData.map.addresses != "undefined") ? dyFObj.elementData.map.addresses  :  [] ;
	    updateLocality = false;

	    // Initialize tags list for network in form of element
		if(typeof networkJson != 'undefined' && typeof networkJson.add != "undefined"  && typeof typeObj != "undefined" ){
			$.each(networkJson.add, function(key, v) {
				if(typeof networkJson.request.sourceKey != "undefined"){
					sourceObject = {inputType:"hidden", value : networkJson.request.sourceKey[0]};
					typeObj[key].dynForm.jsonSchema.properties.source = sourceObject;
				}

				if(v){
					if(typeof networkJson.request.searchTag != "undefined"){
						typeObj[key].dynForm.jsonSchema.properties.tags.data = networkJson.request.searchTag;
					}


					if(notNull(networkJson.dynForm)){
						mylog.log("tags", typeof typeObj[key].dynForm.jsonSchema.properties.tags, typeObj[key].dynForm.jsonSchema.properties.tags);
						mylog.log("networkTags", networkTags);
						if(typeof typeObj[key].dynForm.jsonSchema.properties.tags != "undefined"){
							typeObj[key].dynForm.jsonSchema.properties.tags.values=networkTags;
							if(typeof networkJson.request.mainTag != "undefined")
								typeObj[key].dynForm.jsonSchema.properties.tags.mainTag = networkJson.request.mainTag[0];
						}
						mylog.log("networkJson.dynForm");
						mylog.log("networkJson.dynForm", "networkJson.dynForm");
						if(notNull(networkJson.dynForm.extra)){
							var nbListTags = 1 ;
							mylog.log("networkJson.dynForm.extra.tags", "networkJson.dynForm.extra.tags"+nbListTags);
							mylog.log(jsonHelper.notNull("networkJson.dynForm.extra.tags"+nbListTags));
							while(jsonHelper.notNull("networkJson.dynForm.extra.tags"+nbListTags)){
								typeObj[key].dynForm.jsonSchema.properties["tags"+nbListTags] = {
									"inputType" : "tags",
									"placeholder" : networkJson.dynForm.extra["tags"+nbListTags].placeholder,
									"values" : networkTagsCategory[ networkJson.dynForm.extra["tags"+nbListTags].list ],
									"data" : networkTagsCategory[ networkJson.dynForm.extra["tags"+nbListTags].list ],
									"label" : networkJson.dynForm.extra["tags"+nbListTags].list
								};
								nbListTags++;
								mylog.log("networkJson.dynForm.extra.tags", "networkJson.dynForm.extra.tags"+nbListTags);
								mylog.log(jsonHelper.notNull("networkJson.dynForm.extra.tags"+nbListTags));
							}
							delete typeObj[key].dynForm.jsonSchema.properties.tags;
						}
					}
				}
			});
		}
		
	},

	inputText :function(label, placeholder, rules, custom) { 
		var inputObj = {
			label : label,
	    	placeholder : ( notEmpty(placeholder) ? placeholder : "... " ),
	        inputType : "text",
	        rules : ( notEmpty(rules) ? rules : {} ),
	        custom : ( notEmpty(custom) ? custom : "" )
	    };
	    mylog.log("inputText ", inputObj);
    	return inputObj;
    },
    slug :function(label, placeholder, rules) { 
    	console.log("rooooles",rules);
		var inputObj = {
			label : label,
	    	placeholder : ( notEmpty(placeholder) ? placeholder : "... " ),
	        inputType : "text",
	        rules : ( notEmpty(rules) ? rules : "")
	    };
    	inputObj.init = function(){
        	$("#ajaxFormModal #slug").bind("input keyup",function(e) {
        		$(this).val(slugify($(this).val(), true));
        		if($("#ajaxFormModal #slug").val().length >= 3 )
            		slugUnique($(this).val());
            	else
            		$("#ajaxFormModal #slug").parent().removeClass("has-success").addClass("has-error").find("span").text("Please enter at least 3 characters.");
            	//dyFObj.canSubmitIf();
        	});
	    }
	    mylog.log("dyFInputs ", inputObj);
    	return inputObj;
    },
	name :function(type, rules, addElement, extraOnBlur) { 
		var inputObj = {
	    	placeholder : "... ",
	        inputType : "text",
	        rules : ( notEmpty(rules) ? rules : { required : true } )
	    };
	    if(type){
	    	console.log("NAMEOFYOUR", dyFInputs.get(type).ctrl, trad[dyFInputs.get(type).ctrl]);
	    	inputObj.label = tradDynForm["nameofyour"]+" " + trad[dyFInputs.get(type).ctrl]+" ";
	    	if(type=="classified") 
	    		inputObj.label = tradDynForm["titleofyour"]+" "+ trad[type]+" ";

	    	inputObj.placeholder = inputObj.label + " ...";

	    	inputObj.init = function(){
	        	$("#ajaxFormModal #name ").off().on("blur",function(){
	        		if($("#ajaxFormModal #name ").val().length > 3 )
	            		globalSearch($(this).val(),[ dyFInputs.get(type).col, "organizations" ], addElement );
	            	
	            	dyFObj.canSubmitIf();
	        	});
	        }
	    }else{
	    	inputObj.label = "Nom ";
	    }
	    mylog.log("dyFInputs ", inputObj);
    	return inputObj;
    },
    username : {
    	placeholder : "username",
        inputType : "text",
        label : "Username",
        rules : { required : true },
        init : function(){
        	$("#ajaxFormModal #username ").off().on("blur",function(){
        		if($("#ajaxFormModal #username ").val().length > 2 ){
            		var res = isUniqueUsername($(this).val());
            		$("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false);
            		var msg = "Username existe déjà";
            		var color = " text-red"
            		if(res){
            			msg = "Username est bon";
            			color = " text-green"
            		}
            		
            		$("#listSameName").html("<div class='col-sm-12 light-border"+color+"'> <i class='fa fa-eye'></i> "+msg+" : </div>");
            	}
            });
        }
    },
    similarLink : {
        inputType : "custom",
        html:"<div id='similarLink'><div id='listSameName'></div></div>",
    },
    inputSelect :function(label, placeholder, list, rules) { 
		var inputObj = {
			inputType : "select",
			label : ( notEmpty(label) ? label : "" ),
			placeholder : ( notEmpty(placeholder) ? placeholder : "Choisir" ),
			options : ( notEmpty(list) ? list : [] ),
			rules : ( notEmpty(rules) ? rules : {} )
		};
		return inputObj;
	},
	inputSelectGroup :function(label, placeholder, list, group, rules, init) { 
		var inputObj = {
			inputType : "select",
			label : ( notEmpty(label) ? label : "" ),
			placeholder : ( notEmpty(placeholder) ? placeholder : "Choisir" ),
			options : ( notEmpty(list) ? list : [] ),
			groupOptions : ( notEmpty(group) ? group : [] ),
			rules : ( notEmpty(rules) ? rules : {} ),
			init : ( notEmpty(init) ? init : function(){} )
		};
		return inputObj;
	},
	organizerId : function( organizerId, organizerType ){
		return dyFInputs.inputSelectGroup( 	tradDynForm["whoorganizedevent"]+" ?", 
											tradDynForm["whoorganize"]+" ?", 
											firstOptions(), 
											parentList( ["organizations","projects"], organizerId, organizerType ), 
											{ required : true },
											function(){
												$("#ajaxFormModal #organizerId").off().on("change",function(){
													
													var organizerId = $(this).val();
													var organizerType = "notfound";
													if(organizerId == "dontKnow" )
														organizerType = "dontKnow";
													else if( $('#organizerId').find(':selected').data('type') && typeObj[$('#organizerId').find(':selected').data('type')] )
														organizerType = $('#organizerId').find(':selected').data('type');
													else
														organizerType = typeObj["person"].col;

													mylog.warn( "organizer",organizerId,organizerType, $('#organizerId').find(':selected').data('type') );
													$("#ajaxFormModal #organizerType").val( organizerType );
												});
											});
	},
	tags : function(list, placeholder, label) { 
    	tagsL = (list) ? list : tagsList;
    	return {
			inputType : "tags",
			placeholder : placeholder != null ? placeholder : tradDynForm["tags"],
			values : tagsL,
			label : (label != null) ? label : tradDynForm["addtags"]
		}
	},
	radio : function(label,keyValues) { 
    	return {
    		label : (label != null) ? label : "",
			inputType : "radio",
			options : keyValues
		}
	},
    imageAddPhoto : {
    	inputType : "uploader",
    	showUploadBtn : true,
    	init : function() { 
    		setTimeout( function()
    		{
    			
        		$('#trigger-upload').click(function(e) {
        			alert("initImageTrigger");
        			$('.fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
		        	urlCtrl.loadByHash(location.hash);
        			$('#ajax-modal').modal("hide");
		        });
				//$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
				//	  					  	  .addClass("bg-dark");
    		 	
    		 	//$("#ajax-modal-modal-title").html("<i class='fa fa-camera'></i> Publier une photo");

        	},1500);
    	}
    },
    image :function() { 
    	
    	if( !jsonHelper.notNull("uploadObj.gotoUrl") ) 
    		uploadObj.gotoUrl = location.hash ;
    	mylog.log("image upload then gotoUrl", uploadObj.gotoUrl) ;

    	return {
	    	inputType : "uploader",
	    	docType : "image",
	    	label : tradDynForm["imageshere"]+" :", 
	    	showUploadBtn : false,
	    	template:'qq-template-gallery',
	    	filetypes:['jpeg', 'jpg', 'gif', 'png'],
	    	afterUploadComplete : function(){
	    		//alert("afterUploadComplete :: "+uploadObj.gotoUrl);
		    	dyFObj.closeForm();
				//alert( "image upload then goto : "+uploadObj.gotoUrl );
	            urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
		    }
    	}
    },
    file :function() { 
    	
    	if( !jsonHelper.notNull("uploadObj.gotoUrl") ) 
    		uploadObj.gotoUrl = location.hash ;
    	mylog.log("image upload then gotoUrl", uploadObj.gotoUrl) ;

    	return {
	    	inputType : "uploader",
	    	label : tradDynForm.fileshere+" :", 
	    	showUploadBtn : false,
	    	docType : "file",
	    	template:'qq-template-manual-trigger',
	    	filetypes:["pdf","xls","xlsx","doc","docx","ppt","pptx","odt","ods","odp"],
	    	afterUploadComplete : function(){
	    		//alert("afterUploadComplete :: "+uploadObj.gotoUrl);
		    	dyFObj.closeForm();
				//alert( "image upload then goto : "+uploadObj.gotoUrl );
				if(location.hash.indexOf("view.library")>0){
					navCollections=[];
					buildNewBreadcrum("files");
					getViewGallery(1,"","files");
				}		
				else
	            	urlCtrl.loadByHash( (uploadObj.gotoUrl) ? uploadObj.gotoUrl : location.hash );
		    }
    	}
    },
    textarea :function (label,placeholder,rules) {  
    	var inputObj = {
    		inputType : "textarea",
	    	label : ( notEmpty(label) ? label : "Votre message ..." ),
	    	placeholder : ( notEmpty(placeholder) ? placeholder : "Votre message ..." ),
	    	rules : ( notEmpty(rules) ? rules : { } ),
	    	init : function(){
	    		mylog.log("textarea init");
	    		if($(".maxlengthTextarea").length){
	    			mylog.log("textarea init2");
	    			$(".maxlengthTextarea").off().keyup(function(){
						var name = "#" + $(this).attr("id") ;
						mylog.log(".maxlengthTextarea", "#ajaxFormModal "+name, $(this).attr("id"), $("#ajaxFormModal "+name).val().length, $(this).val().length);
						$("#ajaxFormModal #maxlength"+$(this).attr("id")).html($("#ajaxFormModal "+name).val().length);
					});
	    		}
	    		dataHelper.activateMarkdown("#ajaxFormModal #message");
	        }
	    };
	    return inputObj;
	},

	password : function  (title, rules) {  
    	var title = (title) ? title : trad["New password"];
    	var ph = "";
    	var rules = (rules) ? rules : { required : true } ;
	    var res = {
	    	label : title,
	    	inputType : "password",
	    	placeholder : ph,
	    	rules : rules
	    }
	    return res;
	},
    price :function(label, placeholder, rules, custom) { 
		var inputObj = dyFInputs.inputText(tradDynForm["pricesymbole"], tradDynForm["pricesymbole"]+" ...") ;
	    inputObj.init = function(){
    		$('input#price').filter_input({regex:'[0-9]'});
      	};
    	return inputObj;
    },

    text :function (label,placeholder,rules) {  
    	var inputObj = {
    		inputType : "text",
	    	label : ( notEmpty(label) ? label : tradDynForm["mainemail"] ),
	    	placeholder : ( notEmpty(placeholder) ? placeholder : "exemple@mail.com" ),
	    	rules : ( notEmpty(rules) ? rules : { email: true } )
	    }
	    console.log("create form input email", inputObj);
	    return inputObj;
	},
	
	emailOptionnel :function (label,placeholder,rules) {  
    	var inputObj = dyFInputs.text(label, placeholder, rules);
    	inputObj.init = function(){
			$(".emailtext").css("display","none");
		};
	    return inputObj;
	},
	createNews: function (){
		var inputObj = {
			inputType : "createNews",
			label : "ta mere",
       		placeholder:"",
       		rules: "",
       		params : {"targetId":contextData.id, "targetType":contextData.type, 
     					"targetImg":contextData.profilThumbImageUrl, "targetName":contextData.name, 
     					"authorId":userId,"authorImg":userConnected.profilThumbImageUrl, "authorName":userConnected.name}
   		}
		inputObj.init = function(){
			$("#createNews").css("display","none");
			$("#createNews #tags").select2({tags:tagsList});
			$("#createNews > textarea").elastic();
			mentionsInit.get("#createNews > #mentionsText > textarea");
			$("#createNews .scopeShare").click(function() {
				mylog.log(this);
				replaceText=$(this).find("h4").html();
				$("#createNews #btn-toogle-dropdown-scope").html(replaceText+' <i class="fa fa-caret-down" style="font-size:inherit;"></i>');
				scopeChange=$(this).data("value");
				$("#createNews > input[name='scope']").val(scopeChange);
				
			});
			$("#createNews .targetIsAuthor").click(function() {
				mylog.log(this);
				srcImg=$(this).find("img").attr("src");
				name=$(this).data("name");
				$("#createNews #btn-toogle-dropdown-targetIsAuthor").html('<img height=20 width=20 src="'+srcImg+'"/> '+name+' <i class="fa fa-caret-down" style="font-size:inherit;"></i>');
				authorTargetChange=$(this).data("value");
				$("#createNews #authorIsTarget").val(authorTargetChange);
			});
		};
		return inputObj;  
	},
	location : {
		label : tradDynForm["localization"],
       inputType : "location"
    },
    locationObj : {
    	/* *********************************
					LOCATION
		********************************** */
		//TODO move to elementForm
		elementLocation : null,
		centerLocation : null,
		elementLocations : [],
		addresses : [],
		elementPostalCode : null,
		elementPostalCodes : [],
		countLocation : 0,
		countPostalCode : 0,
		initVar :function(){
			dyFInputs.locationObj.elementLocation = null;
		    dyFInputs.locationObj.elementLocations = [];
		    dyFInputs.locationObj.centerLocation = null;
		    dyFInputs.locationObj.addresses = [];
		    dyFInputs.locationObj.countLocation = 0 ;
		},
		init : function () {
			mylog.log("init loc");
			$(".deleteLocDynForm").click(function(){
				mylog.log("deleteLocDynForm", $(this).data("index"));
				var index = $(this).data("index");
				var indexLoc = $(this).data("indexLoc");
				if(index == -1 && dyFInputs.locationObj.elementLocations.length > 1){
					toastr.error("Vous ne pouvez pas supprimer l'adresse principal si vous avez des adresses secondaires");
				}else{
					bootbox.confirm({
						message: trad["suredeletelocality"]+"<span class='text-red'></span>",
						buttons: {
							confirm: {
								label: trad["yes"],
								className: 'btn-success'
							},
							cancel: {
								label: trad["no"],
								className: 'btn-danger'
							}
						},
						callback: function (result) {
							if (!result) {
								return;
							} else {
								mylog.log("Index Delete", $(this).data("index"));
								var param = new Object;
								param.name = (index == -1 ) ? "locality" : "addresses";
								param.value = (index == -1 ) ? "" : { addressesIndex : index };
								param.pk = uploadObj.id;

								$.ajax({
							        type: "POST",
							        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+uploadObj.type,
							        data: param,
							       	dataType: "json",
							    	success: function(data){
								    	if(data.result){
											toastr.success(data.msg);
											
											var formValues = dyFObj.elementData.map;
											mylog.log("FormValues", formValues);

											dyFInputs.locationObj.elementLocation = null;
											dyFInputs.locationObj.elementLocations.splice(indexLoc,1);
											if(index != -1 ){
												dyFInputs.locationObj.initVar();
												$(".locationlocation").html("");
												   
												if( dyFInputs.locationObj.addresses ){
													dyFInputs.locationObj.addresses.splice(index,1);
													var test = [];
													$.each(dyFInputs.locationObj.elementLocations, function(i,locelt){
														$.each(dyFInputs.locationObj.addresses, function(i,addLoc){

															if(addLoc.postalCode == locelt.locelt && 
																addLoc.streetAddress == locelt.streetAddress &&
																addLoc.insee == locelt.insee &&
																addLoc.addressCountry == locelt.addressCountry &&
																addLoc.addressLocality == locelt.addressLocality){
																test.push(locelt);
															}
														});
													});
													
												}

												if( formValues.address && formValues.geo && formValues.geoPosition ){
													mylog.warn("init Adress location",formValues.address.addressLocality,formValues.address.postalCode);
													dyFInputs.locationObj.copyMapForm2Dynform({address:formValues.address,geo:formValues.geo,geo:formValues.geoPosition});
													dyFInputs.locationObj.addLocationToForm({address:formValues.address,geo:formValues.geo,geo:formValues.geoPosition}, -1);
												}
												if( dyFInputs.locationObj.addresses ){
													$.each(dyFInputs.locationObj.addresses, function(i,addLoc){
														mylog.warn("init extra addresses location ",locationObj.address.addressLocality,locationObj.address.postalCode);
														dyFInputs.locationObj.copyMapForm2Dynform(locationObj);
														dyFInputs.locationObj.addLocationToForm(locationObj, i);	
													});
												}
												
											}else{
												$(".locationEl"+ indexLoc).remove();
											}
								    	}
								    }
								});
							}
						}
					});
				}
			});
		},
		copyMapForm2Dynform : function (locObj) {
			mylog.warn("---------------copyMapForm2Dynform----------------");
			//if(!elementLocation)
			//	elementLocation = [];
			mylog.log("locationObj", locObj);
			dyFInputs.locationObj.elementLocation = locObj;
			mylog.log("elementLocation", dyFInputs.locationObj.elementLocation);
			dyFInputs.locationObj.elementLocations.push(dyFInputs.locationObj.elementLocation);
			mylog.log("dyFInputs.locationObj.elementLocations", dyFInputs.locationObj.elementLocations);
			mylog.log("dyFInputs.locationObj.centerLocation", dyFInputs.locationObj.centerLocation);
			if(!dyFInputs.locationObj.centerLocation /*|| dyFInputs.locationObj.elementLocation.center == true*/){
				dyFInputs.locationObj.centerLocation = dyFInputs.locationObj.elementLocation;
				dyFInputs.locationObj.elementLocation.center = true;
			}
			mylog.dir(dyFInputs.locationObj.elementLocations);
			//elementLocation.push(positionObj);
		},
		addLocationToForm : function (locObj, index){
			mylog.warn("---------------addLocationToForm----------------");
			mylog.dir(locObj);
			var strHTML = "";
			if( locObj.address.addressCountry)
				strHTML += locObj.address.addressCountry;
			if( locObj.address.postalCode)
				strHTML += ", "+locObj.address.postalCode;
			if( locObj.address.addressLocality)
				strHTML += ", "+locObj.address.addressLocality;
			if( locObj.address.streetAddress)
				strHTML += ", "+locObj.address.streetAddress;
			var btnSuccess = "";
			var locCenter = "";
			var boolCenter=false;
			if( dyFInputs.locationObj.countLocation == 0){
				btnSuccess = "btn-success";
				//locCenter = "<span class='lblcentre'>(localité centrale)</span>";
				locCenter = "<span class='lblcentre'> "+tradDynForm["mainLocality"]+"</span>"; 
				boolCenter=true;
			}

			/*if(typeof index != "undefined"){
				strHTML = "<a href='javascript:;' class='deleteLocDynForm locationEl"+dyFInputs.locationObj.countLocation+" btn' data-index='"+index+"' data-indexLoc='"+dyFInputs.locationObj.countLocation+"'>"+
								"<i class='text-red fa fa-times'></i></a>"+
					  		"<span class='locationEl"+dyFInputs.locationObj.countLocation+" locel text-azure'>"+strHTML+"</span> "+
					  "<a href='javascript:dyFInputs.locationObj.setAsCenter("+dyFInputs.locationObj.countLocation+")' data-index='"+index+"' class='centers center"+dyFInputs.locationObj.countLocation+" locationEl"+dyFInputs.locationObj.countLocation+" btn btn-xs "+btnSuccess+"'>"+
					  	"<i class='fa fa-map-marker'></i>"+locCenter+"</a> <br/>";
			}
			else{
				strHTML = "<a href='javascript:dyFInputs.locationObj.removeLocation("+dyFInputs.locationObj.countLocation+")' class=' locationEl"+dyFInputs.locationObj.countLocation+" btn'> <i class='text-red fa fa-times'></i></a>"+
					  "<span class='locationEl"+dyFInputs.locationObj.countLocation+" locel text-azure'>"+strHTML+"</span> "+
					  "<a href='javascript:dyFInputs.locationObj.setAsCenter("+dyFInputs.locationObj.countLocation+")' class='centers center"+dyFInputs.locationObj.countLocation+" locationEl"+dyFInputs.locationObj.countLocation+" btn btn-xs "+btnSuccess+"'> <i class='fa fa-map-marker'></i>"+locCenter+"</a> <br/>";
			}*/
			if(typeof index != "undefined"){
				strHTML =  
			        "<div class='col-md-12 col-sm-12 col-xs-12 text-left shadow2 padding-15 margin-top-15 margin-bottom-15'>" + 
			          "<span class='pull-left locationEl"+dyFInputs.locationObj.countLocation+" locel text-red bold'>"+ 
			            "<i class='fa fa-home fa-2x'></i> "+ 
			            strHTML+ 
			          "</span> "+ 
			 
			          "<a href='javascript:;' data-index='"+index+"' data-indexLoc='"+dyFInputs.locationObj.countLocation+"' "+ 
			            "class='deleteLocDynForm locationEl"+dyFInputs.locationObj.countLocation+" btn btn-sm btn-danger pull-right'> "+ 
			            "<i class='fa fa-times'></i> "+tradDynForm.clear+ 
			          "</a>"+ 
			 
			          "<a href='javascript:dyFInputs.locationObj.setAsCenter("+dyFInputs.locationObj.countLocation+")' data-index='"+index+"'"+ 
			            "class='margin-right-5 centers pull-right center"+dyFInputs.locationObj.countLocation+" locationEl"+dyFInputs.locationObj.countLocation+" btn btn-sm "+btnSuccess+"'> "+ 
			            "<i class='fa fa-map-marker'></i> "+locCenter+ 
			          "</a>" + 
			           
			        "</div>"; 
			} else {
				strHTML =  
			        "<div class='col-md-12 col-sm-12 col-xs-12 text-left shadow2 padding-15 margin-top-15 margin-bottom-15'>" + 
			          "<span class='pull-left locationEl"+dyFInputs.locationObj.countLocation+" locel text-red bold'>"+ 
			            "<i class='fa fa-home fa-2x'></i> "+ 
			            strHTML+ 
			          "</span> "+ 
			 
			          "<a href='javascript:dyFInputs.locationObj.removeLocation("+dyFInputs.locationObj.countLocation+", "+boolCenter+")' "+ 
			            "class='removeLocalityBtn locationEl"+dyFInputs.locationObj.countLocation+" btn btn-sm btn-danger pull-right'> "+ 
			            "<i class='fa fa-times'></i> "+tradDynForm.clear+ 
			          "</a>"+ 
			 
			          "<a href='javascript:dyFInputs.locationObj.setAsCenter("+dyFInputs.locationObj.countLocation+")' "+ 
			            "class='setAsCenterLocalityBtn margin-right-5 centers pull-right center"+dyFInputs.locationObj.countLocation+" locationEl"+dyFInputs.locationObj.countLocation+" btn btn-sm "+btnSuccess+"'> "+ 
			            "<i class='fa fa-map-marker'></i> "+locCenter+ 
			          "</a>" + 
			           
			        "</div>"; 
			}
      		$(".locationlocation").append(strHTML); 
			
			
			// strHTML = "<a href='javascript:removeLocation("+dyFInputs.locationObj.countLocation+", "+true+")'' class=' locationEl"+dyFInputs.locationObj.countLocation+" btn'> <i class='text-red fa fa-times'></i></a>"+
			// 		  "<span class='locationEl"+dyFInputs.locationObj.countLocation+" locel text-azure'>"+strHTML+"</span> "+
			// 		  "<a href='javascript:dyFInputs.locationObj.setAsCenter("+dyFInputs.locationObj.countLocation+")' class='centers center"+dyFInputs.locationObj.countLocation+" locationEl"+dyFInputs.locationObj.countLocation+" btn btn-xs "+btnSuccess+"'> <i class='fa fa-map-marker'></i>"+locCenter+"</a> <br/>";

			$(".postalcodepostalcode").prepend(strHTML);

			mylog.log("strAddres", strHTML);
			//$(".locationlocation").prepend(strHTML);
			dyFInputs.locationObj.countLocation++;
		},
		copyPCForm2Dynform : function (postalCodeObj) { 
			mylog.warn("---------------copyPCForm2Dynform----------------");
			mylog.log("postalCodeObj", postalCodeObj);
			dyFInputs.locationObj.elementPostalCode = postalCodeObj;
			mylog.log("elementPostalCode", dyFInputs.locationObj.elementPostalCode);
			dyFInputs.locationObj.elementPostalCodes.push(dyFInputs.locationObj.elementPostalCode);
			mylog.log("elementPostalCodes", dyFInputs.locationObj.elementPostalCodes);
			mylog.dir(dyFInputs.locationObj.elementPostalCodes);
			//elementPostalCode.push(positionObj);
		},
		addPostalCodeToForm : function (postalCodeObj){
			mylog.warn("---------------addPostalCodeToForm----------------");
			mylog.dir(postalCodeObj);
			var strHTML = "";
			if( postalCodeObj.postalCode)
				strHTML += postalCodeObj.postalCode;
			if( postalCodeObj.name)
				strHTML += " ,"+postalCodeObj.name;
			if( postalCodeObj.latitude)
				strHTML += " ,("+postalCodeObj.latitude;
			if( postalCodeObj.longitude)
				strHTML += " / "+postalCodeObj.longitude+")";
			
			strHTML = "<a href='javascript:dyFInputs.locationObj.removeLocation("+dyFInputs.locationObj.countPostalCode+")' class=' locationEl"+dyFInputs.locationObj.countPostalCode+" btn'> <i class='text-red fa fa-times'></i></a>"+
					  "<span class='locationEl"+dyFInputs.locationObj.countPostalCode+" locel text-azure'>"+strHTML+"</span> <br/>";
			$(".postalcodepostalcode").prepend(strHTML);
			dyFInputs.locationObj.countPostalCode++;
		},
		removeLocation : function (ix,center){
			mylog.log("dyFInputs.locationObj.removeLocation", ix, dyFInputs.locationObj.elementLocations);
			dyFInputs.locationObj.elementLocation = null;
			dyFInputs.locationObj.elementLocations.splice(ix,1);
			$(".locationEl"+ix).parent().remove();
			//delete dyFInputs.locationObj.elementLocations[ix];
			dyFInputs.locationObj.countLocation--;
			if(dyFInputs.locationObj.countLocation > 0){
				for(var prop in dyFInputs.locationObj.elementLocations){
					if(prop >= ix){
						domNumber=parseInt(prop)+1;
						domParent=$(".locationEl"+domNumber).parent();
						var btnSuccess = "";
						var locCenter = "";
						var boolCenter=false;
						if( typeof center != "undefined" && center && prop==0){
							btnSuccess = "btn-success";
							//locCenter = "<span class='lblcentre'>(localité centrale)</span>";
							locCenter = "<span class='lblcentre'> "+tradDynForm["mainLocality"]+"</span>"; 
							boolCenter=true;
						}
						domParent.find(".removeLocalityBtn").attr("href","javascript:dyFInputs.locationObj.removeLocation("+prop+","+boolCenter+")");
						domParent.find(".setAsCenterLocalityBtn").attr("href","javascript:dyFInputs.locationObj.setAsCenter("+prop+")");
						$(".locationEl"+domNumber).each(function(){
							$(this).removeClass("locationEl"+domNumber).addClass("locationEl"+prop);
						});
						$(".center"+domNumber).removeClass("center"+domNumber).addClass("center"+prop)/*.append(locCenter)*/;
					}
				}
				if(typeof center != "undefined" && center)
					dyFInputs.locationObj.setAsCenter(0);
			} else{
				$(".locationBtn").html("<i class='fa fa-home'></i> "+tradDynForm["mainLocality"]);
				//dyFInputs.locationObj.centerLocation = null;
			}
			
			//$.each(function())
			//TODO check if this center then apply on first
			//$(".locationEl"+dyFInputs.locationObj.countLocation).remove();

			/*if(ix != 0){
				removeAddresses(ix-1, true);
			}
			else
				removeAddress(true);*/

		},
		setAsCenter : function (ix){

			$(".centers").removeClass('btn-success');
			$(".lblcentre").remove();
			$.each(dyFInputs.locationObj.elementLocations,function(i, v) {
				console.log(v); 
				if(typeof v.center != "undefined" && v.center)
					delete v.center;
			})
			$(".centers").removeClass('btn-success');
			$(".center"+ix).addClass('btn-success').append(" <span class='lblcentre'>addresse principale</span>");
			$(".center"+ix).parent().find(".removeLocalityBtn").attr("href","javascript:dyFInputs.locationObj.removeLocation("+ix+",true)");
			dyFInputs.locationObj.centerLocation = dyFInputs.locationObj.elementLocations[ix];
			dyFInputs.locationObj.elementLocations[ix].center = true;
		}
    },
    //produces 
    subDynForm : function(form, multi){

    },
    inputUrl :function (label,placeholder,rules, custom) {  
    	label = ( notEmpty(label) ? label : tradDynForm["mainurl"] );
    	placeholder = ( notEmpty(placeholder) ? placeholder : "http://www.exemple.org" );
    	rules = ( notEmpty(rules) ? rules : { url: true } );
    	custom = ( notEmpty(custom) ? custom : "<div class='resultGetUrl resultGetUrl0 col-sm-12'></div>" );
	    var inputObj = dyFInputs.inputText(label, placeholder, rules, custom);
	    return inputObj;
	},
	inputUrlOptionnel :function (label, placeholder,rules, custom) {  
    	var inputObj = dyFInputs.inputUrl(label, placeholder, rules, custom);
    	inputObj.init = function(){
            getMediaFromUrlContent("#url", ".resultGetUrl0",0);
            $(".urltext").css("display","none");
        };
	    return inputObj;
	},
    urls : {
    	label : tradDynForm["freeinfourl"],
    	placeholder : tradDynForm["freeinfourl"]+" ...",
        inputType : "array",
        value : [],
        init:function(){
            getMediaFromUrlContent(".addmultifield0", ".resultGetUrl0",0);	
        }
    },
    urlsOptionnel : {
        inputType : "array",
        placeholder : tradDynForm["urlandaddinfoandaction"],
        value : [],
        init:function(){
            getMediaFromUrlContent(".addmultifield0", ".resultGetUrl0",0);
        	$(".urlsarray").css("display","none");	
        }
    },
    keyVal : {
    	label : "Key Value Pairs",
    	inputType : "properties",
    },
    bookmarkUrl: function(label, placeholder,rules, custom){
    	var inputObj = dyFInputs.inputUrl(label, placeholder, rules, custom);
    	inputObj.init = function(){
    		$("#ajaxFormModal #url").bind("input keyup",function(e) {
            	processUrl.refUrl($(this).val());
            	/*if(result){
            		console.log(result);
            	}*/
        	});
            //$(".urltext").css("display","none");
        };
	    return inputObj;
    },
    checkboxSimple : function(checked, id, params){
    
    	var inputObj = {
    		label: params["labelText"],
    		params : params,
	    	inputType : "checkboxSimple",
	    	checked : checked, //$("#ajaxFormModal #"+id).val(),
	    	init : function(){
	    		//var checked = $("#ajaxFormModal #"+id).val();
	    		console.log("checkcheck2", checked, "#ajaxFormModal #"+id);
	    		var idTrue = "#ajaxFormModal ."+id+"checkboxSimple .btn-dyn-checkbox[data-checkval='true']";
	    		var idFalse = "#ajaxFormModal ."+id+"checkboxSimple .btn-dyn-checkbox[data-checkval='false']";
	    		console.log("checkcheck2", checked, "#ajaxFormModal #"+id);
	    		$("#ajaxFormModal #"+id).val(checked);

	    		if(typeof params["labelInformation"] != "undefined")
	        		$("#ajaxFormModal ."+id+"checkboxSimple label").append(
	        				"<small class='col-md-12 col-xs-12 text-left no-padding' "+
									"style='font-weight: 200;'>"+
									params["labelInformation"]+
							"</small>");

	        	if(checked == "true"){
	    			$(idTrue).addClass("bg-green-k").removeClass("letter-green");
	    			$("#ajaxFormModal ."+id+"checkboxSimple label").append(
	    					"<span class='lbl-status-check margin-left-10'>"+
	    						'<span class="letter-green"><i class="fa fa-check-circle"></i> '+params["onLabel"]+'</span>'+
	    					"</span>");
	        	}

	    		if(checked == "false"){ 
	    			$(idFalse).addClass("bg-red").removeClass("letter-red");
	    			$("#ajaxFormModal ."+id+"checkboxSimple label").append(
	    					"<span class='lbl-status-check margin-left-10'>"+
	    						'<span class="letter-red"><i class="fa fa-minus-circle"></i> '+params["offLabel"]+'</span>'+
	    					"</span>");

	    			setTimeout(function(){
    			  		if(typeof params["inputId"] != "undefined") $(params["inputId"]).hide(400);
    			  	}, 1000);
	    		}
	    		

	    		$("#ajaxFormModal ."+id+"checkboxSimple .btn-dyn-checkbox").click(function(){
	    			var checkval = $(this).data('checkval');
	    			$("#ajaxFormModal #"+id).val(checkval);
	    			console.log("EVENT CLICK ON CHECKSIMPLE", checkval);
	    			
	    			if(checkval) {
	    				$(idTrue).addClass("bg-green-k").removeClass("letter-green");
	    			  	$(idFalse).removeClass("bg-red").addClass("letter-red");
	    			  	$("#ajaxFormModal ."+id+"checkboxSimple .lbl-status-check").html(
	    					'<span class="letter-green"><i class="fa fa-check-circle"></i> '+params["onLabel"]+'</span>');
	    			  	
	    			  	if(typeof params["inputId"] != "undefined") $(params["inputId"]).show(400);
	    			}
	    			else{
	    			  	$(idFalse).addClass("bg-red").removeClass("letter-red");
	    				$(idTrue).removeClass("bg-green-k").addClass("letter-green");
	    				$("#ajaxFormModal ."+id+"checkboxSimple .lbl-status-check").html(
	    					'<span class="letter-red"><i class="fa fa-minus-circle"></i> '+params["offLabel"]+'</span>');

	    				if(typeof params["inputId"] != "undefined") $(params["inputId"]).hide(400);
	    			}
	    		});

	    	}
	    };

	    return inputObj;
	},
	
	checkbox : function(checked, id, params){
    
    	var inputObj = {
    		label: params["labelText"],
    		inputType : "checkbox",
	    	checked : ( notEmpty(checked) ? checked : "" ),
	    	init : function(){
	        	
	        	$("#ajaxFormModal #"+id).val(checked);
	        	$("#ajaxFormModal ."+id+"checkbox label").append("<span class='lbl-status-check margin-left-10'></span>");
	        	if(typeof params["labelInformation"] != "undefined")
	        		$("#ajaxFormModal ."+id+"checkbox").append("<small class='col-md-12 col-xs-12 text-left no-padding' style='margin-top:-10px;'>"+params["labelInformation"]+"</small>");

	        	setTimeout(function(){
	        		$(".bootstrap-switch-label").off().click(function(){
	        			$(".bootstrap-switch-off").click();
	        		});
	        		
		        	if (checked) {
	    				$("#ajaxFormModal ."+id+"checkbox .lbl-status-check").html(
	    					'<span class="letter-green"><i class="fa fa-check-circle"></i> '+params["onLabel"]+'</span>');
	    				$(params["inputId"]).show(400);
	    			} else {
	    				
	    				$("#ajaxFormModal ."+id+"checkbox .lbl-status-check").html(
	    					'<span class="letter-red"><i class="fa fa-minus-circle"></i> '+params["offLabel"]+'</span>');
	    				$(params["inputId"]).hide(400);
	    			}
    			}, 1000);
	        },
	    	"switch" : {
	    		"onText" : params["onText"],
	    		"offText" : params["offText"],
	    		"labelText":params["labelInInput"],
	    		"onChange" : function(){
	    			var checkbox = $("#ajaxFormModal #"+id).is(':checked');
	    			$("#ajaxFormModal #"+id).val($("#ajaxFormModal #"+id).is(':checked'));
	    			console.log("on change checkbox",$("#ajaxFormModal #"+id).val());
	        		//$("#ajaxFormModal #"+id+"checkbox").append("<span class='lbl-status-check'></span>");
	    			if (checkbox) {
	    				$("#ajaxFormModal ."+id+"checkbox .lbl-status-check").html(
	    					'<span class="letter-green"><i class="fa fa-check-circle"></i> '+params["onLabel"]+'</span>');
	    				$(params["inputId"]).show(400);
	    				/*if(id=="amendementActivated"){
	    					var am = $("#ajaxFormModal #voteActivated").val();
	    					console.log("am", am);
	    					if(am == "true")
	    						$("#ajaxFormModal .voteActivatedcheckbox .bootstrap-switch-handle-on").click();
	    				}
	    				if(id=="voteActivated"){
	    					var am = $("#ajaxFormModal #amendementActivated").val();
	    					console.log("vote", am);
	    					if(am == "true")
	    						$("#ajaxFormModal .amendementActivatedcheckbox .bootstrap-switch-handle-on").click();
	    				}*/
	    			} else {
	    				
	    				$("#ajaxFormModal ."+id+"checkbox .lbl-status-check").html(
	    					'<span class="letter-red"><i class="fa fa-minus-circle"></i> '+params["offLabel"]+'</span>');
	    				$(params["inputId"]).hide(400);
	    			}
	    		}
		    }
    	};
	    return inputObj;
	},
	allDay : function(checked){

    	var inputObj = {
    		inputType : "checkbox",
	    	checked : ( notEmpty(checked) ? checked : "" ),
	    	init : function(){
	        	$("#ajaxFormModal #allDay").off().on("switchChange.bootstrapSwitch",function (e, data) {
	        		mylog.log("allDay dateLimit",$("#ajaxFormModal #allDay").val());
	        	})
	        },
	    	"switch" : {
	    		"onText" : tradDynForm["yes"],
	    		"offText" : tradDynForm["no"],
	    		"labelText":tradDynForm["allday"],
	    		"onChange" : function(){
	    			var allDay = $("#ajaxFormModal #allDay").is(':checked');
	    			var startDate = "";
	    			var endDate = "";
	    			$("#ajaxFormModal #allDay").val($("#ajaxFormModal #allDay").is(':checked'));
	    			
	    			if (allDay) {
	    				$(".dateTimeInput").addClass("dateInput");
	    				$(".dateTimeInput").removeClass("dateTimeInput");
	    				$('.dateInput').datetimepicker('destroy');
	    				$(".dateInput").datetimepicker({ 
					        autoclose: true,
					        lang: "fr",
					        format: "d/m/Y",
					        timepicker:false
					    });
					    startDate = moment($('#ajaxFormModal #startDate').val(), "DD/MM/YYYY HH:mm").format("DD/MM/YYYY");
					    endDate = moment($('#ajaxFormModal #endDate').val(), "DD/MM/YYYY HH:mm").format("DD/MM/YYYY");
	    			} else {
	    				$(".dateInput").addClass("dateTimeInput");
	    				$(".dateInput").removeClass("dateInput");
	    				$('.dateTimeInput').datetimepicker('destroy');
	    				$(".dateTimeInput").datetimepicker({ 
		       				weekStart: 1,
							step: 15,
							lang: 'fr',
							format: 'd/m/Y H:i'
					    });
					    
	    				startDate = moment($('#ajaxFormModal #startDate').val(), "DD/MM/YYYY").format("DD/MM/YYYY HH:mm");
						endDate = moment($('#ajaxFormModal #endDate').val(), "DD/MM/YYYY").format("DD/MM/YYYY HH:mm");
	    			}
				    if (startDate != "Invalid date") $('#ajaxFormModal #startDate').val(startDate);
					if (endDate != "Invalid date") $('#ajaxFormModal #endDate').val(endDate);
	    		}
		    }
    	};
    	return inputObj;
    },
    startDateInput : function(typeDate){
    	mylog.log('startDateInput', typeDate);
    	var inputObj = {
	        inputType : ( notEmpty(typeDate) ? typeDate : "datetime" ),
	        placeholder: tradDynForm.startDate,
	        label : tradDynForm.startDate,
	        rules : { 
	        	required : true,
	        	duringDates: ["#startDateParent","#endDateParent",tradDynForm.thestartDate]
	    	}
	    }
    	return inputObj;
    },
    endDateInput : function(typeDate){
    	var inputObj = {
	        inputType : ( notEmpty(typeDate) ? typeDate : "datetime" ),
	        placeholder: tradDynForm.endDate,
	        label : tradDynForm.endDate,
	        rules : { 
	        	required : true,
	        	greaterThan: ["#ajaxFormModal #startDate",tradDynForm.thestartDate],
	        	duringDates: ["#startDateParent","#endDateParent",tradDynForm.theendDate]
		    }
	    }
    	return inputObj;
    },
    birthDate : {
        inputType : "date",
        label : tradDynForm.birthdate,
        placeholder: tradDynForm.birthdate
    },
    dateEnd :{
    	inputType : "date",
    	label : tradDynForm.endDate,
    	placeholder : "Fin de la période de vote",
    	rules : { 
    		required : true,
    		greaterThanNow : ["DD/MM/YYYY"]
    	}
    },
    voteDateEnd :{
    	inputType : "datetime",
    	label : tradDynForm.dateEndVoteSession,
    	placeholder : tradDynForm.dateEndVoteSession,
    	rules : { 
    		required : true,
    		greaterThanNow : ["DD/MM/YYYY H:m"]
    	}
    },
    amendementDateEnd :{
    	inputType : "datetime",
    	label : tradDynForm.dateEndAmendementSessionStartVote,
    	placeholder : tradDynForm.dateEndAmendementSession,
    	rules : { 
    		required : true,
    		greaterThanNow : ["DD/MM/YYYY H:m"]
    	}
    },
    inviteSearch : {
    	inputType : "searchInvite",
       	init : function(){
        	$("#ajaxFormModal #inviteSearch ").keyup(function(e){
			    var search = $('#inviteSearch').val();
			    if(search.length>2){
			    	clearTimeout(timeout);
					timeout = setTimeout('autoCompleteInviteSearch("'+encodeURI(search)+'")', 500); 
				}else{
				 	$("#newInvite #dropdown_searchInvite").css({"display" : "none" });	
				}	
			});
        }
    },
    invitedUserEmail : {
    	placeholder : "Email",
        inputType : "text",
        rules : {
            required : true
        },
        init:function(){
        	$(".invitedUserEmailtext").css("display","none");	 
        }
    },
    inputHidden :function(value, rules) { 
		var inputObj = { inputType : "hidden"};
		if( notNull(value) ) inputObj.value = value ;
		if( notNull(rules) ) inputObj.rules = rules ;
    	return inputObj;
    },
    get:function(type){
    	//mylog.log("dyFInputs.get", type);
    	if( type == "undefined" ){
    		toastr.error("type can't be undefined");
    		return null;
    	}
    	var obj = null;
    	if( jsonHelper.notNull("typeObj."+type)){
    		if (jsonHelper.notNull("typeObj."+type+".sameAs") ){
    			obj = typeObj[ typeObj[type].sameAs ];
    		} else
    			obj = typeObj[type];
    		obj.name = (trad[type]) ? trad[type] : type;
    	}
    	if( obj === null ){
    		obj = dyFInputs.deepGet(type);
    		if( obj )
    			obj = dyFInputs.get( obj.col )
    	}
    	return obj;
    },
    deepGet:function(type){
    	//mylog.log("get", type);
    	var obj = null;
    	$.each( typeObj,function(k,o) { 
    		if( o.subTypes && ( $.inArray( type,  o.subTypes )>=0 ) ){
    			obj = o;
    			return false;
    		}
    	});
    	return obj;
    }
};

var typeObj = {
	themes:{ 
		dynForm : {
		    jsonSchema : {
			    title : "Theme Switcher ?",
			    icon : "question-cirecle-o",
			    noSubmitBtns : true,
			    properties : {
			    	custom :{
		            	inputType : "custom",
		            	html : function() { 
		            		return "<div class='menuSmallMenu'>"+js_templates.loop( [ 
			            		{ label : "ph dori", classes:"bg-dark", icon:"fa-bullseye", action : "javascript:window.location.href = moduleId+'?theme=ph-dori'"},
			            		{ label : "notragora", classes:"bg-grey", icon:"fa-video-camera ", action : "javascript:window.location.href = moduleId+'?theme=notragora'"},
			            		{ label : "C02", classes:"bg-red", icon:"fa-search", action : "javascript:window.location.href = moduleId+'?theme=CO2'"},
			            		{ label : "network", classes:"bg-orange", icon:"fa-bars", action : "javascript:window.location.href = moduleId+'?theme=network'"},
			            		
		            		], "col_Link_Label_Count", { classes : "bg-red kickerBtn", parentClass : "col-xs-12 col-sm-4 "} )+"</div>";
		            	}
		            }
			    }
			}
		}	},
	addElement:{ 
		dynForm : {
		    jsonSchema : {
			    title : "Ajouter un élément ?",
			    icon : "question-cirecle-o",
			    noSubmitBtns : true,
			    properties : {
			    	custom :{
		            	inputType : "custom",
		            	html : function() { 
		            		return "<div class='menuSmallMenu'>"+js_templates.loop( [ 
			            		{ label : "event", classes:"col-xs-12 text-bold bg-"+typeObj["event"].color, icon:"fa-"+typeObj["event"].icon, action : "javascript:dyFObj.openForm('event')"},
			            		{ label : "organization", classes:"col-xs-12 text-bold bg-"+typeObj["organization"].color, icon:"fa-"+typeObj["organization"].icon, action : "javascript:dyFObj.openForm('organization')"},
			            		{ label : "project", classes:"col-xs-12 text-bold bg-"+typeObj["project"].color, icon:"fa-"+typeObj["project"].icon, action : "javascript:dyFObj.openForm('project')"},
			            		{ label : "poi", classes:"col-xs-12 text-bold bg-"+typeObj["poi"].color, icon:"fa-"+typeObj["poi"].icon, action : "javascript:dyFObj.openForm('poi')"},
			            		{ label : "entry", classes:"col-xs-12 text-bold bg-"+typeObj["entry"].color, icon:"fa-"+typeObj["entry"].icon, action : "javascript:dyFObj.openForm('entry')"},
			            		{ label : "action", classes:"col-xs-12 text-bold bg-"+typeObj["actions"].color, icon:"fa-"+typeObj["actions"].icon, action : "javascript:dyFObj.openForm('action')"},
			            		{ label : "classified", classes:"col-xs-12 text-bold bg-"+typeObj["classified"].color, icon:"fa-"+typeObj["classified"].icon, action : "javascript:dyFObj.openForm('classified')"},
			            		{ label : "Documentation", classes:"col-xs-12 text-white text-bold bg-red lbh", icon:"fa-book", action : "#default.view.page.index.dir.docs"},
			            		{ label : "Signaler un bug", classes:"col-xs-12 text-white text-bold bg-red lbh", icon:"fa-bug", action : "#news.index.type.pixels"},
		            		], "col_Link_Label_Count", { classes : "bg-red kickerBtn", parentClass : "col-xs-12 col-sm-6 "} )+"</div>";
		            	}
		            }
			    }
			}
		}	},
	addPhoto:{ titleClass : "bg-dark", color : "bg-dark" },
	addFile:{ titleClass : "bg-dark", color : "bg-dark" },
	person : { col : "citoyens" ,ctrl : "person",titleClass : "bg-yellow",bgClass : "bgPerson",color:"yellow",icon:"user",lbh : "#person.invite",	},
	persons : { sameAs:"person" },
	people : { sameAs:"person" },
	citoyen : { sameAs:"person" },
	citoyens : { sameAs:"person" },
	
	poi:{  col:"poi",ctrl:"poi",color:"green-poi", titleClass : "bg-green-poi", icon:"map-marker",
		subTypes:["link" ,"tool","machine","software","rh","RessourceMaterielle","RessourceFinanciere",
			   "ficheBlanche","geoJson","compostPickup","video","sharedLibrary","artPiece","recoveryCenter",
			   "trash","history","something2See","funPlace","place","streetArts","openScene","stand","parking","other" ] },
	place:{  col:"place",ctrl:"place",color:"green",icon:"map-marker"},
	TiersLieux : {sameAs:"place",color: "azure",icon: "home"},
	Maison : {sameAs:"place", color: "azure",icon: "home"},
	ressource:{  col:"ressource",ctrl:"ressource",color:"purple",icon:"cube" },

	siteurl:{ col:"siteurl",ctrl:"siteurl"},
	organization : { col:"organizations", ctrl:"organization", icon : "group",titleClass : "bg-green",color:"green",bgClass : "bgOrga"},
	organizations : {sameAs:"organization"},
	LocalBusiness : {col:"organizations",color: "azure",icon: "industry"},
	NGO : {sameAs:"organization", color:"green", icon:"users"},
	Association : {sameAs:"organization", color:"green", icon: "group"},
	GovernmentOrganization : {col:"organization", color: "red",icon: "university"},
	Group : {	col:"organizations",color: "turq",icon: "circle-o"},
	event : {col:"events",ctrl:"event",icon : "calendar",titleClass : "bg-orange",color:"orange",bgClass : "bgEvent"},
	events : {sameAs:"event"},
	project : {col:"projects",ctrl:"project",	icon : "lightbulb-o",color : "purple",titleClass : "bg-purple",	bgClass : "bgProject"},
	projects : {sameAs:"project"},
	city : {sameAs:"cities"},
	cities : {col:"cities",ctrl:"city", titleClass : "bg-red", icon : "university",color:"red"},
	
	entry : {	col:"surveys",	ctrl:"survey",	titleClass : "bg-dark",bgClass : "bgDDA",	icon : "gavel",	color : "azure", 
		saveUrl : baseUrl+"/" + moduleId + "/survey/saveSession"},
	vote : {col:"actionRooms",ctrl:"survey"},
	survey : {col:"actionRooms",ctrl:"entry",color:"lightblue2",icon:"cog"},
	surveys : {sameAs:"survey"},
	proposal : { col:"proposals", ctrl:"proposal",color:"dark",icon:"hashtag", titleClass : "bg-turq" }, 
	proposals : { sameAs : "proposal" },
	action : {col:"actions", ctrl:"action", titleClass : "bg-turq", bgClass : "bgDDA", icon : "cogs", color : "dark" },
	actions : { sameAs : "action" },
	actionRooms : {sameAs:"room"},
	rooms : {sameAs:"room"},
	room : {col:"rooms",ctrl:"room",color:"azure",icon:"connectdevelop",titleClass : "bg-turq"},
	discuss : {col:"actionRooms",ctrl:"room"},

	contactPoint : {col : "contact" , ctrl : "person",titleClass : "bg-blue",bgClass : "bgPerson",color:"blue",icon:"user", 
		saveUrl : baseUrl+"/" + moduleId + "/element/saveContact"},
	classified:{ col:"classified",ctrl:"classified", titleClass : "bg-azure", color:"azure",	icon:"bullhorn",
				   subTypes : [
				   //FR
				   "Technologie","Immobilier","Véhicules","Maison","Loisirs","Mode",
				   //EN
				   "Technology","Property","Vehicles","Home","Leisure","Fashion"
				   ]	},
	url : {col : "url" , ctrl : "url",titleClass : "bg-blue",bgClass : "bgPerson",color:"blue",icon:"user",saveUrl : baseUrl+"/" + moduleId + "/element/saveurl",	},
	bookmark : {col : "bookmarks" , ctrl : "bookmark",titleClass : "bg-dark",bgClass : "bgPerson",color:"blue",icon:"bookmark"},
	document : {col : "document" , ctrl : "document",titleClass : "bg-dark",bgClass : "bgPerson",color:"dark",icon:"upload",saveUrl : baseUrl+"/" + moduleId + "/element/savedocument",	},
	default : {icon:"arrow-circle-right",color:"dark"},
	//"video" : {icon:"video-camera",color:"dark"},
	formContact : { titleClass : "bg-yellow",bgClass : "bgPerson",color:"yellow",icon:"user", saveUrl : baseUrl+"/"+moduleId+"/app/sendmailformcontact"},
	news : { col : "news" }, 
	config : { col:"config",color:"azure",icon:"cogs",titleClass : "bg-azure", title : tradDynForm.addconfig,
				sections : {
			        network : { label: "Network Config",key:"network",icon:"map-marker"}
			    }},
	network : { col:"network",color:"azure",icon:"connectdevelop",titleClass : "bg-turq"},
	inputs : { color:"red",icon:"address-card-o",titleClass : "bg-phink", title : "All inputs"},
	addAny : { color:"pink",icon:"plus",titleClass : "bg-phink",title : tradDynForm.wantToAddSomething,
				sections : {
			        person : { label: trad["Invite your contacts"],key:"person",icon:"user"},
			        organization : { label: trad.organization,key:"organization",icon:"group"},
			        event : { label: trad.event,key:"event",icon:"calendar"},
			        project : { label: trad.project ,key:"project",icon:"lightbulb-o"},
			    }},
	apps : { color:"pink",icon:"cubes",titleClass : "bg-phink",title : tradDynForm.appList,
				sections : {
			        search : { label: "SEARCH",key:"#search",icon:"search fa-2x text-red"},
			        agenda : { label: "AGENDA",key:"#agenda",icon:"group fa-2x text-red"},
			        news : { label: "NEWS",key:"#news",icon:"newspaper-o fa-2x text-red"},
			        classifieds : { label: "ANNONCEs",key:"#classifieds",icon:"bullhorn fa-2x text-red"},
			        dda : { label: "DISCUSS DECIDE ACT" ,key:"#dda",icon:"gavel fa-2x text-red"},
			        chat : { label: "CHAT" ,key:"#chat",icon:"comments fa-2x text-red"},
			    }},
	filter : { color:"azure",icon:"list",titleClass : "bg-turq",title : "Nouveau Filtre"}
};

var documents = {
	objFile:{
		"pdf":{icon:"file-pdf-o",class:"text-red"},
		"text":{icon:"file-text-o",class:"text-blue"},
		"presentation":{icon:"file-powerpoint-o",class:"text-orange"},
		"spreadsheet":{icon:"file-excel-o",class:"text-green"}
	},
	getIcon : function(contentKey){
		return '<i class="fa fa-'+documents.objFile[contentKey].icon+' '+documents.objFile[contentKey].class+'"></i>';
	},
	saveImages : function (contextType, contextId,contentKey){
		//alert("saveImages"+contextType+contextId);
		$.ajax({
			url : baseUrl+"/"+moduleId+"/document/"+uploadUrl+"dir/"+moduleId+"/folder/"+contextType+"/ownerId/"+contextId+"/input/dynform",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false, 
			processData: false,
			dataType: "json",
			success: function(data){
				if(debug)mylog.log(data);
		  		if( data.success ){
			  		mylog.log("success");
		  			imageName = data.name;
					var doc = { 
						"id":contextId,
						"type":contextType,
						"folder":contextType+"/"+contextId,
						"moduleId":moduleId,
						"author" : userId  , 
						"name" : data.name , 
						"date" : new Date() , 
						"size" : data.size ,
						"doctype" : docType,
						"contentKey" : contentKey
					};
					mylog.log(doc);
					path = "/"+data.dir+data.name;
					$.ajax({
					  	type: "POST",
					  	url: baseUrl+"/"+moduleId+"/document/save",
					  	data: doc,
				      	dataType: "json"
					}).done( function(data){
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
							if($("#resultsImage img").length>1)
						  		$(".newImageAlbum").last().remove();
						  	else{
						  		$("#resultsImage").empty();
						  		$("#resultsImage").hide();
						  	}
						}
						$("#addImage").off();
					});
		  		}
		  		else{
			  		if($("#resultsImage img").length>1)
				  		$(".newImageAlbum").last().remove();
				  	else{
				  		$("#resultsImage").empty();
				  		$("#resultsImage").hide();
				  	}
				  	$("#addImage").off();
		  			toastr.error(data.msg);
		  		}
			},
		});
	}
}
/* ************************************
Keyboard Shortcuts
*************************************** */
var keyboardNav = {
	keycodeObj : {"backspace":8,"tab":9,"enter":13,"shift":16,"ctrl":17,"alt":18,"pause/break":19,"capslock":20,"escape":27,"pageup":33,"pagedown":34,"end":35,
	"home":36,"left":37,"up":38,"right":39,"down":40,"insert":45,"delete":46,"0":48,"1":49,"2":50,"3":51,"4":52,"5":53,"6":54,"7":55,"8":56,"9":57,
	"a":65,"b":66,"c":67,"d":68,"e":69,"f":70,"g":71,"h":72,"i":73,"j":74,"k":75,"l":76,"m":77,"n":78,"o":79,"p":80,"q":81,"r":82,"s":83,"t":84,"u":85,"v":86,"w":87,
	"x":88,"y":89,"z":90,"left window key":91,"right window key":92,"select key":93,"numpad 0":96,"numpad 1":97,"numpad 2":98,"numpad 3":99,"numpad 4":100,"numpad 5":101,
	"numpad 6":102,"numpad 7":103,"numpad 8":104,"numpad 9":105,"multiply":106,"add":107,"subtract":109,"decimal point":110,"divide":111,"f1":112,"f2":113,"f3":114,
	"f4":115,"f5":116,"f6":117,"f7":118,"f8":119,"f9":120,"f10":121,"f11":122,"f12":123,"num lock":144,"scroll lock":145,"semi-colon":186,"equal sign":187,
	"comma":188,"dash":189,"period":190,"forward slash":191,"grave accent":192,"open bracket":219,"back slash":220,"close braket":221,"single quote":222},

	keyMap : {
		//"112" : function(){ $('#modalMainMenu').modal("show"); },//f1
		"113" : function(){ if(userId)urlCtrl.loadByHash('#person.detail.id.'+userId); else alert("login first"); },//f2
		"114" : function(){ $('#openModal').modal('hide'); showMap(true); },//f3
		//"115" : function(){ dyFObj.openForm('themes') },//f4
		"117" : function(){ console.clear();urlCtrl.loadByHash(location.hash) },//f6
	},
	keyMapCombo : {
		"13" : function(){$('#openModal').modal('hide');$('#selectCreate').modal('show');//dyFObj.openForm('addElement')
						  },//enter : add elements
		"61" : function(){$('#openModal').modal('hide');$('#selectCreate').modal('show')},//= : add elements
		"65" : function(){$('#openModal').modal('hide');dyFObj.openForm('action')},//a : actions
		"66" : function(){$('#openModal').modal('hide'); smallMenu.destination = "#openModal"; smallMenu.openAjax(baseUrl+'/'+moduleId+'/collections/list','Mes Favoris','fa-star','yellow') },//b best : favoris
		"67" : function(){$('#openModal').modal('hide');dyFObj.openForm('classified')},//c : classified
		"69" : function(){$('#openModal').modal('hide');dyFObj.openForm('event')}, //e : event
		"70" : function(){$('#openModal').modal('hide'); $(".searchIcon").trigger("click") },//f : find
		"72" : function(){ smallMenu.openAjaxHTML(baseUrl+'/'+moduleId+'/default/view/page/help') },//h : help
		"73" : function(){$('#openModal').modal('hide');dyFObj.openForm('person')},//i : invite
		"76" : function(){ smallMenu.openAjaxHTML(baseUrl+'/'+moduleId+'/default/view/page/links')},//l : links and infos
		"79" : function(){$('#openModal').modal('hide');dyFObj.openForm('organization')},//o : orga
		"80" : function(){$('#openModal').modal('hide');dyFObj.openForm('project')},//p : project
		"82" : function(){$('#openModal').modal('hide');smallMenu.openAjax(baseUrl+'/'+moduleId+'/person/directory?tpl=json','Mon répertoire','fa-book','red')},//r : annuaire
		"86" : function(){$('#openModal').modal('hide');dyFObj.openForm('entry')},//v : votes
	},
	checkKeycode : function(e) {
		e.preventDefault();
		var keycode;
		if (window.event) {keycode = window.event.keyCode;e=event;}
		else if (e){ keycode = e.which;}
		//console.log("keycode: ",keycode);

		if(e.ctrlKey && e.altKey && keyboardNav.keyMapCombo[keycode] ){
			console.warn("keyMapCombo",keycode);//shiftKey ctrlKey altKey
			keyboardNav.keyMapCombo[keycode]();
		}
		else if( keyboardNav.keyMap[keycode] ){
			console.warn("keyMap",keycode);
			keyboardNav.keyMap[keycode]();
		}
	}
}

//*********************************************************************************
// Utility for events date
//*********************************************************************************
function manageTimestampOnDate() {
	$.each($(".date2format"), function(k, v) { 
		var dates = "";
		var dateFormat = "DD-MM-YYYY HH:mm";
		if ($(this).data("allday") == true) {
			dateFormat = "DD-MM-YYYY";
		}
		dates = moment($(this).data("startdate")).local().format(dateFormat);
		dates += "</br>"+moment($(this).data("enddate")).local().format(dateFormat);
		$(this).html(dates);
	})
}

//Display event start and end date depending on allDay params
//Used on popup and right list on map
function displayStartAndEndDate(event) {
	var content = "";
	//si on a bien les dates
	mylog.log("event map", event);
	if("undefined" != typeof event['startDateDB'] && "undefined" != typeof event['endDateDB']){
		//var start = dateToStr(data['startDate'], "fr", true);
		//var end = dateToStr(data['endDate'], "fr", true);
		
		var startDateMoment = moment(event['startDateDB']).local();
		var endDateMoment = moment(event['endDateDB']).local();

		var startDate = startDateMoment.format("DD-MM-YYYY");
		var endDate = endDateMoment.format("DD-MM-YYYY");

		var hour1 = "Toute la journée";
		var hour2 = "Toute la journée";
		if(event["allDay"] == false || event["allDay"] == null) { 	
			hour1 = startDateMoment.format("HH:mm");
			hour2 = endDateMoment.format("HH:mm");
		}
		//si la date de debut == la date de fin
		if( startDate == endDate) {
			content += "<div class='info_item startDate_item_map_list double'><i class='fa fa-caret-right'></i> Le " + startDate;
			
			if(event["allDay"] == true) { 		
				content += "</br><i class='fa fa-caret-right'></i> " + hour1;
			} else {
				content += "</br><i class='fa fa-caret-right'></i> " + hour1 + " - " + hour2;
			}
			content += "</div>";
		} else {
			content += "<div class='info_item startDate_item_map_list double'><i class='fa fa-caret-right'></i> Du " + 
								startDate + " - " + hour1 +
							"</div>" +
				   		  	"<div class='info_item startDate_item_map_list double'><i class='fa fa-caret-right'></i> Au " + 
				   		  		endDate +  " - " + hour2 +
				   		  	"</div></br>";
		}
	}
	return content;
}

//*********************************************************************************
// JS Template
//*********************************************************************************
var js_templates = {
		objectify : function(obj)
		{
			var tplObj = { label : obj.label };
			tplObj.lblCount = (notNull(obj.labelCount)) ? ' <span class="labelCount">('+obj.labelCount+')</span>' : '';
			tplObj.action = (notNull(obj.action)) ? obj.action : 'javascript:smallMenu.openAjax(\''+baseUrl+'/'+moduleId+'/collections/list/col/'+obj.label+'\',\''+obj.label+'\',\'fa-folder-open\',\'yellow\'})';
			tplObj.icon = (notNull(obj.icon)) ? obj.icon : "fa-question-circle-o";
			tplObj.classes = (notNull(obj.classes)) ? obj.classes : ""; 
      		tplObj.parentClass = (notNull(obj.parentClass)) ? obj.parentClass : ""; 
      		tplObj.key = (notNull(obj.key)) ? ' data-key="'+obj.key+'"' : ""; 
			tplObj.color = (notNull(obj.color)) ? obj.color : "white"; 
			tplObj.tooltip = (notNull(obj.tooltip)) ? 'data-toggle="tooltip" data-placement="left" title="'+tooltip+'"' : ""; 
			return tplObj;
		},

		//params :
		//obj : 
		//classes :: applies a class on each rendered element
		//open / close :: is a globale container
		//el_open/el_close :: is a container for each element of the list rendering
		loop : function(obj,tpl,tplparams)
		{
      		var str = (notNull(tplparams) && notNull(tplparams.open)) ? tplparams.open : "";
      		var cleanup = false;
      		$.each(obj ,function(k,v){
          		if( !notNull( v.classes ) && notNull(tplparams) && notNull( tplparams.classes )){
          			v.classes = tplparams.classes;
          			cleanup = true;
          		}
        		if( !notNull( v.parentClass ) && notNull(tplparams) && notNull( tplparams.parentClass ))
           			v.parentClass = tplparams.parentClass;
         		var opener = (notNull(tplparams) && notNull(tplparams.el_open)) ? tplparams.el_open : "";
		     	str += opener+js_templates[tpl]( v );
         		if(notNull(tplparams) && notNull(tplparams.el_close)) str += tplparams.el_close;
         		if(cleanup)
         			delete v.classes;
		   	});
        	if(notNull(tplparams) && notNull(tplparams.close)) str += tplparams.close;
		   	return str;
		},

		col_Link_Label_Count : function(obj)
		{
			var tplObj = js_templates.objectify(obj);
			return ' <div class="'+tplObj.parentClass+' center padding-5 ">'+
						'<a href="'+tplObj.action+'" '+
							'class="'+tplObj.classes+' btn tooltips text-'+tplObj.color+'" '+tplObj.tooltip+' '+tplObj.key+'>'+
							'<i class="fa '+tplObj.icon+' text-'+tplObj.color+'"></i> '+
							'<br/>'+tplObj.label+tplObj.lblCount+
						'</a>'+
				    '</div>'
		},

		linkList : function (obj) 
		{ 
			var tplObj = js_templates.objectify(obj);
			mylog.log("classes",tplObj.classes);
			return '<a href="'+tplObj.action+'" class="'+tplObj.classes+' btn btn-xs btn-link text-white text-left w100p" '+tplObj.key+'><i class="fa '+tplObj.icon+'  text-'+tplObj.color+'"></i> '+tplObj.label+tplObj.lblCount+'</a><br/>';
		},

		leftMenu_content : function(params)
		{
		     //left menu section 
		     var str = '<div class="menuSmallMenu"><div class="menuSmallLeftMenu col-sm-3 col-xs-12 center margin-top-15 margin-bottom-5">';
		     str += js_templates.loop( params.menu,"linkList",{ classes : "padding-5 bg-dark center  col-xs-12 ", el_open:'<div class="col-xs-12 center no-padding">', el_close:'</div>'} );
		     str += '</div>'+
		     //right content section 
		    	'<div class="col-sm-9 col-xs-12 no-padding">';

		    str += "<div class='homestead titleSmallMenu' style='font-size:45px'> "+
		       params.title1+' <i class="fa fa-angle-right"></i> '+params.title2+"</div>";

		    str += js_templates.loop( params.list,"col_Link_Label_Count", { classes : "bg-red kickerBtn", parentClass : "col-xs-12 col-sm-4 "} );
		     str += '</div></div>';
		     return str;
		},

		album : function (obj) 
		{ 
			isDoc = (obj.name.toLowerCase().indexOf(".pdf")>0) ? true : false;
			target = (isDoc) ? " target='_blanck'" : "";
			str = ' <div class="col-xs-3 portfolio-item" id="'+obj.id+'">'+
				' <a class="thumb-info pull-left '+obj.classes+'" '+target+' href="'+obj.path+'/'+obj.name+'" data-lightbox="all">';
			
			if( isDoc )
				str += '<i class="fa fa-file-text-o fa-x5"></i>';
			else
				str += ' <img src="'+obj.path+'/medium/'+obj.name+'" class="img-responsive" alt="'+obj.name+'">';

			str += ' </a>'+
					( ( notNull(userId) && obj.author == userId) ? ' <br/><a class="btnRemove" href="javascript:;" data-id="'+obj.id+'" data-key="" data-name="'+obj.name+'" ><i class="fa text-red fa-trash"></i> </a>' : '')+
					'</div>' ;
			return str;
				
		}

	};

//*********************************************************************************
// smallMenu Photo Albums
//*********************************************************************************
var album = {
	show : function (id,type){
		uploadObj.set(type,id);
		getAjax( null , baseUrl+'/'+moduleId+"/document/list/id/"+id+"/type/"+type+"/tpl/json" , function( data ) { 
			
			console.dir(data);
			smallMenu.build( 
				data.list , 
			    function( params ){ 
			    	str = '<style>.thumb-info{height:200px; overflow: hidden; position: relative; } .thumb-info img{}</style><a class="pull-left btn bg-red addPhotoBtn" data-type="'+type+'" data-id="'+id+'" href="javascript:;"> Ajouter des Photos <i class="fa fa-plus"></i></a>'+
							"<div class='homestead titleSmallMenu' style='font-size:35px'> Album <i class='fa fa-angle-right'></i> "+data.element.name+" </div><br/>"+
							js_templates.loop( params, "album" );
					return str;
				},
			    function(){
			    	$(".addPhotoBtn").click(function() { 
			    		uploadObj.set(type,id);
						dyFObj.openForm("addPhoto");
			    	});
			    	album.delete();
			    });
		});
	},
	delete : function(){
		$(".portfolio-item .btnRemove").off().on("click", function(e){
			e.preventDefault();
			var imageId = $(this).data("id");
			var params =  { 
				"parentId": uploadObj.id, 
				"parentType": uploadObj.type, 
				"docId" : imageId};
			console.dir(params);
			bootbox.confirm( trad.areyousuretodelete+"<span class='text-red'> "+$(this).data("name")+"</span> ?", 
				function(result) {
					if(result){
						$.ajax({
							url: baseUrl+"/"+moduleId+"/document/delete/dir/"+moduleId+"/type/"+uploadObj.type+"/parentId/"+uploadObj.id,
							type: "POST",
							dataType : "json",
							data: params,
							success: function(data){
								if(data.result){
									toastr.success(data.msg);
									$("#"+imageId).remove();
								}else{
									toastr.error(data.error)
								}
							}
						})
					}
				})
		})
	}
}

var CoAllReadyLoad = false;
var CoSigAllReadyLoad = false;
//back sert juste a differencier un load avec le back btn
//ne sert plus, juste a savoir d'ou vient drait l'appel

function KScrollTo(target){ 
	mylog.log("KScrollTo target", target);
	if($(target).length>=1){
		$('html, body').stop().animate({
	        scrollTop: $(target).offset().top - 60
	    }, 500, '');
	}
}

var timerCloseDropdownUser = false;
function initKInterface(params){ console.log("initKInterface");

	$(window).off();

	$(window).resize(function(){
      resizeInterface();
    });
	resizeInterface();
	
    //jQuery for page scrolling feature - requires jQuery Easing plugin
    $('.page-scroll a').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeInOutExpo');
        event.preventDefault();
    });

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $('.btn-scroll').bind('click', function(event) {
        var target = $(this).data('targetid');
        KScrollTo(target);
        event.preventDefault();
    });

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function(){ 
            $('.navbar-toggle:visible').click();
    });

    $(".openModalSelectCreate").click(function(){
        $("#selectCreate").modal("show");
        showFloopDrawer(false);
        showNotif(false);
    });

    $(".btn-open-floopdrawer").click(function(){ 
        showNotif(false);
        $("#dropdown-user").removeClass("open");
        showFloopDrawer(true);
    });
    $("#floopDrawerDirectory").mouseleave(function(){ 
        showFloopDrawer(false);
    });


    $(".btn-show-mainmenu").click(function(){
        showFloopDrawer(false);
        showNotif(false);
        $("#dropdown-user").addClass("open");
        //clearTimeout(timerCloseDropdownUser);
    });
    
    $("#dropdown-user").mouseleave(function(){ //alert("dropdown-user mouseleave");
        $("#dropdown-user").removeClass("open");
    });

    $("header .container").mouseenter(function(){ 
    	$("#dropdown-user").removeClass("open");
    });


    $(".logout").click(function(){
    	window.location.href=baseUrl+"/co2/person/logout";
    });

    $("#btn-sethome").click(function(){
    	urlCtrl.loadByHash("#info.p.sethome")
    });
    $("#btn-apropos").click(function(){
    	urlCtrl.loadByHash("#info.p.apropos")
    });

    var affixTop = 300;
    if(notEmpty(params)){
    	if(typeof params["affixTop"] != "undefined") affixTop = params["affixTop"];
    }
    console.log("affixTop", affixTop);
    if(affixTop > 0){
      // Offset for Main Navigation
      $('#mainNav').affix({
          offset: {
              top: affixTop
          }
      });
    }

    // Floating label headings for the contact form
    $(function() {
        $("body").on("input propertychange", ".floating-label-form-group", function(e) {
            $(this).toggleClass("floating-label-form-group-with-value", !!$(e.target).val());
        }).on("focus", ".floating-label-form-group", function() {
            $(this).addClass("floating-label-form-group-with-focus");
        }).on("blur", ".floating-label-form-group", function() {
            $(this).removeClass("floating-label-form-group-with-focus");
        });
    });


    $(".btn-show-map").off().click(function(){
    	if(typeof formInMap != "undefined" && formInMap.actived == true)
			formInMap.cancel(true);
    	//else if(isMapEnd == false && notEmpty(contextData) && location.hash.indexOf("#page.type."+contextData.type+"."+contextData.id))
		//	getContextDataLinks();
		else{

			if(isMapEnd == false && contextData && contextData.map && location.hash.indexOf("#page.type."+contextData.type+"."+contextData.id) )
				Sig.showMapElements(Sig.map, contextData.map.data, contextData.map.icon, contextData.map.title);
			
				showMap();
		}
    });

    bindLBHLinks();

    $(".tooltips").tooltip();
    
    //sur mobile la carto est désactivée car non fonctionnelle pour le moment
    //(pb pour manipuler la carte open/close etc)
 //    if($("#mainNav .btn-show-map").css("display") != "none"){
	//     setTimeout(function(){ 
	//       mapBg = Sig.loadMap("mapCanvas", initSigParams);
	//       Sig.showIcoLoading(false);
	//       CoSigAllReadyLoad = true;
	//     }, 3000);
	// }

    KScrollTo(".main-container");

}

function getContextDataLinks(){
	mylog.log("getContextDataLinks");
	$.ajax({
		type: "POST",
		url: baseUrl+'/'+moduleId+"/element/getalllinks/type/"+contextData.type+"/id/"+contextData.id,
		dataType: "json",
		success: function(data){
			mylog.log("getContextDataLinks data", data);
			Sig.restartMap();
			contextData.map = {
				data : data,
				icon : "link",
				title : trad.thecommunityof+" <b>"+contextData.name+"</b>"
			} ;
			Sig.showMapElements(Sig.map, data, "link", trad.thecommunityof+" <b>"+contextData.name+"</b>");
			//showMap();
		},
		error: function (error) {
			mylog.log("getContextDataLinks error findGeoposByInsee", error);
			Sig.restartMap();
			callbackFindByInseeError(error);
			//showMap();	
		}
			
	});
}

function test(params, itemType){
	var typeIco = i;
    params.size = size;
    params.id = getObjectId(params);
    params.name = notEmpty(params.name) ? params.name : "";
    params.description = notEmpty(params.shortDescription) ? params.shortDescription : 
                        (notEmpty(params.message)) ? params.message : 
                        (notEmpty(params.description)) ? params.description : 
                        "";

    //mapElements.push(params);
    //alert("TYPE ----------- "+contentType+":"+params.name);
    
    if(typeof( typeObj[itemType] ) == "undefined")
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

    if(dyFInputs.get(itemType) && 
        dyFInputs.get(itemType).col == "poi" && 
        typeof params.medias != "undefined" && typeof params.medias[0].content.image != "undefined")
    params.imgProfil= "<img class='img-responsive' src='"+params.medias[0].content.image+"'/>";

    params.insee = params.insee ? params.insee : "";
    params.postalCode = "", params.city="",params.cityName="";
    if (params.address != null) {
        params.city = params.address.addressLocality;
        params.postalCode = params.cp ? params.cp : params.address.postalCode ? params.address.postalCode : "";
        params.cityName = params.address.addressLocality ? params.address.addressLocality : "";
    }
    params.fullLocality = params.postalCode + " " + params.cityName;

    params.type = dyFInputs.get(itemType).col;
    params.urlParent = (notEmpty(params.parentType) && notEmpty(params.parentId)) ? 
                  '#page.type.'+params.parentType+'.id.' + params.parentId : "";

    //params.url = '#page.type.'+params.type+'.id.' + params.id;
    params.hash = '#page.type.'+params.type+'.id.' + params.id;
   /* if(params.type == "poi")    
        params.hash = '#element.detail.type.poi.id.' + id;

    params.onclick = 'urlCtrl.loadByHash("' + params.hash + '");';*/

    params.elTagsList = "";
    var thisTags = "";
    if(typeof params.tags != "undefined" && params.tags != null){
      $.each(params.tags, function(key, value){
        if(typeof value != "undefined" && value != "" && value != "undefined"){
          thisTags += "<span class='badge bg-transparent text-red btn-tag tag' data-tag-value='"+slugify(value)+"'>#" + value + "</span> ";
          params.elTagsList += slugify(value)+" ";
        }
      });
      params.tagsLbl = thisTags;
    }else{
      params.tagsLbl = "";
    }

    params.updated   = notEmpty(params.updatedLbl) ? params.updatedLbl : null; 
}

$(document).ready(function() { 
	setTimeout( function () { checkPoll() }, 10000);
	document.onkeyup = keyboardNav.checkKeycode;
	if(notNull(userId) && userId!="") 
		bindRightClicks();
});