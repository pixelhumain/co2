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
	//toastr.success(trad.changelanguageprocessing);
	//window.reloadurlCtrl.loadByHash(location.hash);
	if(userId != ""){
		param={
			name : "language",
			value : lang,
			pk : userId
		};
		$.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/element/updatefields/type/citoyens",
	        data: param,
	       	dataType: "json",
	    	success: function(data){
		    	if(data.result){
					toastr.success(data.msg);
					location.reload();
					/*if(formInMap == true){
						$(".locationEl"+ index).remove();
						dyFInputs.locationObj.elementLocation = null;
						dyFInputs.locationObj.elementLocations.splice(ix,1);
						//TODO check if this center then apply on first
						//$(".locationEl"+dyFInputs.locationObj.countLocation).remove();
					}
					else
						urlCtrl.loadByHash(location.hash);*/
		    	}
		    }
		});
	}else{
		location.reload();
	}
	
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

function updateField(type,id,name,value,reload, useToastr){ 
    	
	$.ajax({
	  type: "POST",
	  url: baseUrl+"/"+moduleId+"/"+type+"/updatefield", 
	  data: { "pk" : id ,"name" : name, "value" : value },
	  success: function(data){
		if(data.result) {
			if(useToastr==null)
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
								typeConnect=(formData.parentType==  "citoyens") ? "people" : formData.parentType;
								idConnect=formData.parentId;
								if(formData.parentId==userId){
									typeConnect=(formData.childType==  "citoyens") ? "people" : formData.childType;
									idConnect=formData.childId;
								
								}
								removeFloopEntity(idConnect, typeConnect);
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
					addFloopEntity(formData.parentId, formData.parentType, data.parent);
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
	    "#graph.viewer" : {title:'GRAPE VIEW', icon : 'share-alt', useHeader: true },
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
	    "#person.invite" : {title:'DETAIL ENTITY', icon : 'legal'},
		"#element" : {title:'DETAIL ENTITY', icon : 'legal'},
	    "#gallery" : {title:'ACTION ROOMS ', icon : 'photo'},
	    "#comment." : {title:'DISCUSSION ROOMS ', icon : 'comments'},
	    //"#admin" : {title:'CHECKGEOCODAGE ', icon : 'download', useHeader: true},
	    //"#admin.checkgeocodage" : {title:'CHECKGEOCODAGE ', icon : 'download', useHeader: true},
	    //"#admin.openagenda" : {title:'OPENAGENDA ', icon : 'download', useHeader: true},
	    //"#admin.adddata" : {title:'ADDDATA ', icon : 'download', useHeader: true},
	    //"#admin.importdata" : {title:'IMPORT DATA ', icon : 'download', useHeader: true},
	    //"#admin.index" : {title:'IMPORT DATA ', icon : 'download', useHeader: true},
	    //"#admin.cities" : {title:'CITIES ', icon : 'university', useHeader: true},
	    //"#admin.sourceadmin" : {title:'SOURCE ADMIN', icon : 'download', useHeader: true},
	    //"#admin.checkcities" : {title:'SOURCE ADMIN', icon : 'download', useHeader: true},
	    //"#admin.directory" : {title:'IMPORT DATA ', icon : 'download', useHeader: true},
	    //"#admin.mailerrordashboard" : {title:'MAIL ERROR ', icon : 'download', useHeader: true},
	    //"#admin.moderate" : {title:'MODERATE ', icon : 'download', useHeader: true},
	    //"#admin.createfile" : {title:'IMPORT DATA', icon : 'download', useHeader: true},
		//"#log.monitoring" : {title:'LOG MONITORING ', icon : 'plus', useHeader: true},
	    //"#adminpublic.view.index" : {title:'SOURCE ADMIN', icon : 'download', useHeader: true},
	    //"#adminpublic.view.createfile" : {title:'IMPORT DATA', icon : 'download', useHeader : true},
	    //"#adminpublic.view.adddata" : {title:'ADDDATA ', icon : 'download', useHeader : true},
	   	//"#adminpublic.view.interopproposed" : {title : 'INTEROP PROPOSED', icon : 'download', useHeader : true},
	   // "#person.settings" : {title:'COMMUNECTED DIRECTORY', icon : 'connectdevelop', menuId:"menu-btn-directory"},
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
		"#interoperability.copedia" : {title:'COPEDIA', icon : 'fa-folder-open-o',useHeader : true},
		"#interoperability.co-osm" : {title:'COSM', icon : 'fa-folder-open-o',useHeader : true},
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
						} else {
							//console.log(">>>>>>>>>>>>>>>>>>> endPoint:",endPoint);
							mod = moduleId+ '/';
							if(moduleId != activeModuleId || endPoint.module){
								mod = '';
								//go get the path , module is given in the hash
								//console.log(">>>>>>>>>>>>>>>>>>> module path",path);
							}

							showAjaxPanel( baseUrl+'/'+ mod +path+urlExtra+extraParams, endPoint.title,endPoint.icon, res,endPoint );
						}
						
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
			if( /*hash.indexOf("#network") < 0 &&
				location.hash.indexOf("#network") >= 0 &&*/ hash!="#" && hash!=""){ 
				mylog.log("network");
			//}
			//else{
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
	        showAjaxPanel( baseUrl+'/'+ moduleId + '/'+hash.replace( "#","" ).replace( /\./g,"/" ), 'ACTIONS in this '+typesLabels[hashT[3]],'rss' );
	    }

	    else if( hash.indexOf("#city.directory") >= 0 ){
	        hashT = hash.split(".");
	        showAjaxPanel( baseUrl+'/'+ moduleId + '/'+hash.replace( "#","" ).replace( /\./g,"/" ), 'KESS KISS PASS in this '+typesLabels[hashT[3]],'rss' );
	    } 

		else if(hash.length>2  || hash.indexOf("#@") >= 0){
			hashT = (hash.indexOf("#@") >= 0) ? hash.replace( "#@","" ) : hash.replace( "#","" );
			hashT=hashT.split(".");
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
			  			console.log("HASH ?", hashT[0], CO2params["onepageKey"], ($.inArray(hashT[0], CO2params["onepageKey"])));
			  			if($.inArray(hashT[0], CO2params["onepageKey"])>-1) viewPage = "/view/"+hashT[0];
			  			showAjaxPanel(baseUrl+'/'+ moduleId + '/app/page/type/'+data.contextType+'/id/'+data.contextId+viewPage);
			  		}else
			  			showAjaxPanel( baseUrl+'/'+ moduleId + '/app/index', 'Home','home' );
	 			},
			});
		}
	    else if ( moduleId != activeModuleId) {
	    	//alert( ctrlId +"/"+ actionId );
	    	showAjaxPanel( baseUrl+'/'+ activeModuleId + '/'+ctrlId +"/"+ actionId, 'Home','home' );
	    } 
	    else
	        showAjaxPanel( baseUrl+'/'+ moduleId + '/app/index', 'Home','home' );
	    mylog.log("END loadByHash hash:", hash);
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
function showPanel(box,callback)
{ 
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
	mylog.log("processingBlockUi");
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
			
	$(".hover-info,.hover-info2").hide();
	showMap(false);

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
			getAjax(dest, url, function(data){ 
				
				if( dest != themeObj.mainContainer )
					$(".subModuleTitle").html("");

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

				if( url.indexOf("app/page/type") >= 0 )
					addBtnSwitch();
				else 
					$(".addBtnFoot").removeClass("hidden");

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
	}, 100);
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
				callback(data);
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
	ajaxHTML : function (url,title,type,nextPrev) { 
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
	//openSmallMenuAjaxBuild("",baseUrl+"/"+moduleId+"/favorites/list/tpl/directory2","FAvoris")
	//opens any html without post processing
	openAjaxHTML : function  (url,title,type,nextPrev) { 
		smallMenu.open("",type );
		smallMenu.ajaxHTML(url,title,type,nextPrev);
	},
	//content Loader can go into a block
	//smallMenu.open("Recherche","blockUI")
	//smallMenu.open("Recherche","bootbox")
	open : function (content,type,color,callback) { 
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
					smallMenu.content(content);
				else 
					smallMenu.content("<i class='fa fa-spin fa-refresh fa-4x'></i>");
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
			if (typeof callback == "function") 
				callback();
		}
	},
	content : function(content) { 
		el = $("#openModal div.modal-content div.container");
		if(content == null)
			return el;
		else
			el.html(content);
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
	$(".lbh").unbind("click").on("click",function(e) {  	
		e.preventDefault();
		$("#openModal").modal("hide");
		mylog.warn("***************************************");
		mylog.warn("bindLBHLinks",$(this).attr("href"));
		mylog.warn("***************************************");
		var h = ($(this).data("hash")) ? $(this).data("hash") : $(this).attr("href");
	    urlCtrl.loadByHash( h );
	});
	//open any url in a modal window
	$(".lbhp").unbind("click").on("click",function(e) {
		e.preventDefault();
		$("#openModal").modal("hide");
		mylog.warn("***************************************");
		mylog.warn("bindLBHLinks Preview", $(this).attr("href"),$(this).data("modalshow"));
		//alert("bindLBHLinks Preview"+$(this).data("modalshow"));
		mylog.warn("***************************************");
		var h = ($(this).data("hash")) ? $(this).data("hash") : $(this).attr("href");
		if( $(this).data("modalshow") ){
			url = (h.indexOf("#") == 0 ) ? urlCtrl.convertToPath(h) : h;
			if(h.indexOf("#page") >= 0)
				url="app/"+url
	    	smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/"+url);
			//smallMenu.open ( getAjax(directory.preview( mapElements[ $(this).data("modalshow") ],h ) );
			
		}
		else {
			url = (h.indexOf("#") == 0 ) ? urlCtrl.convertToPath(h) : h;
	    	smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/"+url);
	    	//smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/"+url ,"","blockUI",h);
		}
	});


	//open any url in a preview window
	$(".lbh-preview-element").unbind("click").on("click",function(e) {
		e.preventDefault();
		$("#openModal").modal("hide");
		mylog.warn("***************************************");
		mylog.warn("bindLBHLinks Preview ELEMENT", $(this).attr("href"),$(this).data("modalshow"));
		mylog.warn("***************************************");
		var h = ($(this).data("hash")) ? $(this).data("hash") : $(this).attr("href");
		var url = (h.indexOf("#") == 0 ) ? "app/"+ urlCtrl.convertToPath(h) : "app/"+ h;
		openPreviewElement( baseUrl+'/'+moduleId+"/"+url);
			//smallMenu.open ( getAjax(directory.preview( mapElements[ $(this).data("modalshow") ],h ) );
	});
}


function openPreviewElement(url){
	$("#modal-preview-coop").html("<i class='fa fa-spin fa-circle-o-notch padding-25 fa-2x letter-azure'></i>").show(200);
	$.ajax({
		type: "POST",
        url: url,
        data: {"preview" : true},
        success: function(html){
        	$("#modal-preview-coop").html(html);
        	$("#modal-preview-coop").removeClass("hidden").show();
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
	
	searchType = (types) ? types : ["organizations", "projects", "events"/*, "needs"*/, "citoyens"];

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
          	mylog.log("globalSearch", data);
            var str = "";
 			var compt = 0;
 			var msg = "Verifiez si cet élément n'existe pas déjà";
 			$("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false);
 			cotmp = {};
 			$.each(data.results, function(id, elem) {
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
					htmlIco= "<img width='25' height='25' alt='image' class='img-circle' src='"+baseUrl+elem.profilThumbImageUrl+"'/>";
				}
				
				if(contact == true){
					cotmp[id] = {id:id, name : elem.name};
					str += 	"<div class='col-xs-12 padding-10'>"+
								"<a href='javascript:;' onclick='fillContactFields( \""+id+"\" );' class='btn btn-xs btn-default w50p' >"+
									htmlIco + " " + elem.name + "</br>" + where +
								"</a>" +
							"</div>";
					msg = "Verifiez si le contact est dans Communecter";
				}else{
					str += 	"<a target='_blank' href='#page.type."+ elem.type +".id."+ id +"' class='btn btn-xs btn-danger col-xs-12 w50p text-left padding-5 margin-5' style='height:42px' >"+
							"<span>"+ htmlIco +"</span> <span> " + elem.name+"</br>"+where+ "</span>"
						"</a>";
				}
				//str += directory.lightPanelHtml(elem);  
				
				compt++;


  			});
			
			if (compt > 0) {
				$("#listSameName").html("<div class='col-sm-12 light-border text-red'> <i class='fa fa-eye'></i> "+msg+" : </div>"+str);
				$("#listSameName").show();
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
function getMediaFromUrlContent(className, appendClassName,nbParent, typeExtract){
    //user clicks previous thumbail
    lastUrl = "";
    if(typeof typeExtract != "undefined")
    	var typeExtract=typeExtract;
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
			                }else{
			                	if(typeof typeExtract != "undefined" && typeExtract=="video"){
			                		if(typeof data.content !="undefined" && typeof data.content.videoLink != "undefined")
			                			content= processUrl.getMediaVideo(data,"save");
			                		else 
			                			content="<span class='text-red'><i>This url is not associate to a video</i></span>";
			                	}else
		                    		content = processUrl.getMediaCommonHtml(data,"save");
			                }
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
	var type= (type=="citoyens") ? "people" : type;
	if(typeof myContacts != "undefined" && myContacts != null && myContacts[type]){
		$.each( myContacts[type], function( key,val ){
			//mylog.log("val", val);
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
	},
	getMediaCommonHtml: function(data,action,id){
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
	            }
	            else{
	                extractClass="extracted_thumb";
	                width="100";
	                height="100";
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
			contentMedia='<div class="extracted_content col-xs-8 padding-20">'+
				'<a href="'+mediaUrl+'" target="_blank" class="lastUrl text-dark">';
				if(typeof(data.name) != "undefined" && data.name!=""){
					contentMedia+='<h4>'+data.name+'</h4></a>';
					inputToSave+="<input type='hidden' class='name' value='"+data.name+"'/>";
				}
				if(typeof(data.description) != "undefined" && data.description!=""){
					contentMedia+='<p>'+data.description+'</p>'+countThumbail+'>';
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
	    content += '<div class="extracted_url padding-10">'+ inc_image +contentMedia+'</div>'+inputToSave;
	    return content;
	},
	getMediaVideo:function(data,action){
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

	            aVideo='<a href="javascript:;" class="videoSignal text-white center" style="position:absolute;top:20%;left:40%;"><i class="fa fa-4x fa-play-circle-o"></i><input type="hidden" class="videoLink" value="'+data.content.videoLink+'"/></a>';
	            inputToSave+="<input type='hidden' class='video_link_value' value='"+data.content.videoLink+"'/>"+
	            "<input type='hidden' class='media_type' value='video_link' />";   
			}
	       	inputToSave+="<input type='hidden' class='size_img' value='"+data.content.imageSize+"'/>";
	    }
	    if (typeof(data.content) !="undefined" && typeof(data.content.image)!="undefined"){
	        inc_image = '<div class="'+extractClass+'  col-xs-12 col-md-12 col-sm-12 no-padding" id="extracted_thumb">'+aVideo;
	        /*if(data.content.type=="img_link"){
		        if(typeof(data.content.imageId) != "undefined"){
			       inc_image += "<input type='hidden' id='deleteImageCommunevent"+id+"' value='"+data.content.imageId+"'/>";
			       titleImg = "De l&apos;application communevent"; 
			    }else
			    	titleImg = "Image partagée"; 
		        inc_image += "<a class='thumb-info' href='"+data.content.image+"' data-title='"+titleImg+"'  data-lightbox='allimgcontent'>";
		    }*/
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
	            inc_image = '<div class="'+extractClass+'  col-xs-12 col-sm-12 col-md-12" id="extracted_thumb">'+aVideo+'<img src="'+data.images[0]+'" width="'+width+'" height="'+height+'">'+selectThumb+'</div>';
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
		/*if((typeof(data.description) !="undefined" || typeof(data.name) != "undefined") && (data.description !="" || data.name != "")){
			contentMedia='<div class="extracted_content col-xs-8 padding-20">'+
				'<a href="'+mediaUrl+'" target="_blank" class="lastUrl text-dark">';
				if(typeof(data.name) != "undefined" && data.name!=""){
					contentMedia+='<h4>'+data.name+'</h4></a>';
					inputToSave+="<input type='hidden' class='name' value='"+data.name+"'/>";
				}
				if(typeof(data.description) != "undefined" && data.description!=""){
					contentMedia+='<p>'+data.description+'</p>'+countThumbail+'>';
					if(typeof(data.name) == "undefined" || data.name=="")
						contentMedia+='</a>';
					inputToSave+="<input type='hidden' class='description' value='"+data.description+"'/>"; 
				}
			contentMedia+='</div>';
		}
		else{
			contentMedia="";
		}*/
		inputToSave+="<input type='hidden' class='url' value='"+mediaUrl+"'/>";
		inputToSave+="<input type='hidden' class='type' value='url_content'/>"; 
		content="";
		content += '<div class="extracted_url padding-10">'+ inc_image +'</div>'+inputToSave;
	    return content;
	}
}
var list = {
	initList : function(dataList, action, subType){
		var viewList="";
		$.each(dataList, function(e,v){
			if(action == "backup"){
				if(e=="services"){
					$.each(v, function(i, data){
						$.each(data,function(key, service){
							viewList+=list.getListOf(key,service,action);
						});
						console.log(data);	
					});
				}else if(e=="products"){
					$.each(v, function(i, data){
						console.log(data);
						viewList+=list.getListOf(e,data,action);	
					});
				}
			}
			else{
				if(action != "history")
					viewList+="<h4 class='listSubtitle col-md-12 col-sm-12 col-xs-12 letter-orange'>"+Object.keys(v).length+" "+e+"</h4>";
				$.each(v, function(i, data){
					console.log(data);
					viewList+=list.getListOf(e,data,action);	
				});
			}
			$("#listList").html(viewList);
		});
		if(action=="history"){
			$(".orderItemComment").click(function(){
				orderItem=listComponents["orderItems"][$(this).data("id")];
				commentRating(orderItem, $(this).data("action"));
			});
		}
	},
	getListOf : function(type,data, action){
		data.imgProfil = ""; 
		btnAction="";
		if(action=="manage")
			btnAction="<a href='#page.type."+type+".id."+data._id.$id+"' class='lbh btn bg-orange linkBtnList'>Manage it</a>";
		else if(action=="history"){
			btnAction="save";
			labelAction=trad["Leave your comment"];
			if(typeof data.comment != "undefined"){
				btnAction="show";
				labelAction="Show your comment";
			}
			btnAction="<button class='btn btn-link bg-green-k orderItemComment linkBtnList' data-id='"+data._id.$id+"' data-action='"+btnAction+"'>"+
						labelAction+
					  "</button>";
		}
    	if(!data.useMinSize)
        	data.imgProfil = "<i class='fa fa-image fa-3x'></i>";
   		if("undefined" != typeof data.profilMediumImageUrl && data.profilMediumImageUrl != "")
        	data.imgProfil= "<img class='img-responsive' src='"+baseUrl+data.profilMediumImageUrl+"'/>";
		str="<div class='col-md-12 col-sm-12 contentListItem padding-5'>"+
				"<div class='col-md-2 col-sm-2 contentImg text-center no-padding'>"+
					data.imgProfil+
				"</div>"+
				"<div class='col-md-10 col-sm-10 listItemInfo'>"+
					"<div class='col-md-10 col-sm-10'>"+
						"<h4>"+data.name+"</h4>"+
						"<span>Price: "+data.price+"</span><br/>";
						if(action=="backup"){
							str+="<span>Quantity: "+data.countQuantity+"</span>";
						}
						if(action=="manage" && typeof data.toBeValidated != "undefined")
							str+="<i class='text-azul'>Waiting for validation</i>";
		str+=		"</div>"+
					"<div class='col-md-2 col-sm-2'>"+
						
					"</div>"+
				"</div>"+
				btnAction+
			"</div>";
		if(action=="history"){
			str+= "<div id='content-comment-"+data._id.$id+"' class='col-xs-12 no-padding contentRatingComment'></div>";
		}
		if(action=="backup"){
			if(typeof data.reservations != "undefined"){
           				 		str += "<div class='col-md-12 col-sm-12 col-xs-12'>"; 
			                    $.each(data.reservations, function(date, value){
			                        s=(value.countQuantity > 1) ? "s" : "";
			                        dateStr=directory.getDateFormated({startDate:date}, true);
			            str += "<div class='col-md-12 col-sm-12 col-xs-12 bookDate margin-bottom-10'>"+
			                            "<div class='col-md-12 col-sm-12 col-xs-12 dateHeader'>"+
			                                "<h4 class='pull-left margin-bottom-5 no-margin col-md-5 col-sm-5 col-xs-5 no-padding'><i class='fa fa-calendar'></i> "+dateStr+"</h4>";
			                               	incQtt="";
			                                if(typeof value.hours =="undefined")
			                                    incQtt=value.countQuantity+" reservation"+s;
			            str +=         "<span class='pull-left text-center col-md-3 col-sm-3 col-xs-3'>"+incQtt+"</span>"+
			                            "</div>";
			                            
			                        if(typeof value.hours != "undefined"){
			                            $.each(value.hours, function(key, hours){
			                                s=(hours.countQuantity > 1) ? "s" : "";
			                                incQtt=hours.countQuantity+" reservation"+s;
			            str +=         "<div class='col-md-12 col-sm-12 col-xs-12 margin-bottom-5 padding-5 contentHoursSession'>"+
			                                    "<h4 class='col-md-4 col-sm-4 col-xs-3 no-padding no-margin'><i class='fa fa-clock-o'></i> "+hours.start+" - "+hours.end+"</h4>"+
			                                    "<span class='col-md-5 col-sm-5 col-xs-6 text-center'>"+incQtt+"</span>"+
			                                "</div>";
			                            });
			                        }
			            str += "</div>"; 
			                    }); 
			            str += "</div>";
			                }
		}
		return str;
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
		//console.log("applyColor",what,id)
		if(userConnected && userConnected.collections && userConnected.collections[collection] && userConnected.collections[collection][what] && userConnected.collections[collection][what][id] ){
			$(".star_"+what+"_"+id).children("i").removeClass("fa-star-o").addClass('fa-star text-red');
			//console.warn("applying Color",what,id)
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
		   		var search = {"searchType" : ["citoyens","organizations","projects"], "name": query};
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
					        $.each(retdata.results, function (e, value){
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
									if(typeof(findInLocal) == "undefined"){
										mentionsContact.push(object);
									}
						 	//		}
				        	//}
				        	});
				        	data=mentionsContact;
				    		data = _.filter(data, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });
							callback.call(this, data);
							mylog.log("callback",callback);
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
	
	
	siteurl:{ col:"siteurl",ctrl:"siteurl"},
	organization : { col:"organizations", ctrl:"organization", icon : "group",titleClass : "bg-green",color:"green",bgClass : "bgOrga"},
	organizations : {sameAs:"organization"},
	LocalBusiness : {col:"organizations",color: "azure",icon: "industry"},
	NGO : {sameAs:"organization", color:"green", icon:"users"},
	Association : {sameAs:"organization", color:"green", icon: "group"},
	GovernmentOrganization : {col:"organization", color: "red",icon: "university"},
	Group : {	col:"organizations",color: "turq",icon: "circle-o"},
	event : {col:"events",ctrl:"event",icon : "calendar",titleClass : "bg-orange", color:"orange",bgClass : "bgEvent"},
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
	resolutions : { col:"resolutions", ctrl:"resolution", titleClass : "bg-turq", bgClass : "bgDDA", icon : "certificate", color : "turq" },
	action : {col:"actions", ctrl:"action", titleClass : "bg-turq", bgClass : "bgDDA", icon : "cogs", color : "dark" },
	actions : { sameAs : "action" },
	actionRooms : {sameAs:"room"},
	rooms : {sameAs:"room"},
	room : {col:"rooms",ctrl:"room",color:"azure",icon:"connectdevelop",titleClass : "bg-turq"},
	discuss : {col:"actionRooms",ctrl:"room"},

	contactPoint : {col : "contact" , ctrl : "person",titleClass : "bg-blue",bgClass : "bgPerson",color:"blue",icon:"user", 
		saveUrl : baseUrl+"/" + moduleId + "/element/saveContact"},
	product:{ col:"products",ctrl:"product", titleClass : "bg-orange", color:"orange",	icon:"shopping-basket"},
	products : {sameAs:"product"},
	service:{ col:"services",ctrl:"service", titleClass : "bg-green", color:"green",	icon:"sun-o"},
	services : {sameAs:"service"},
	circuit:{ col:"circuits",ctrl:"circuit", titleClass : "bg-orange", color:"green",	icon:"ravelry"},
	circuits : {sameAs:"circuit"},
	
	url : {col : "url" , ctrl : "url",titleClass : "bg-blue",bgClass : "bgPerson",color:"blue",icon:"user",saveUrl : baseUrl+"/" + moduleId + "/element/saveurl",	},
	bookmark : {col : "bookmarks" , ctrl : "bookmark",titleClass : "bg-dark",bgClass : "bgPerson",color:"blue",icon:"bookmark"},
	document : {col : "document" , ctrl : "document",titleClass : "bg-dark",bgClass : "bgPerson",color:"dark",icon:"upload",saveUrl : baseUrl+"/" + moduleId + "/element/savedocument",	},
	default : {icon:"arrow-circle-right",color:"dark"},
	//"video" : {icon:"video-camera",color:"dark"},
	formContact : { titleClass : "bg-yellow",bgClass : "bgPerson",color:"yellow",icon:"user", saveUrl : baseUrl+"/"+moduleId+"/app/sendmailformcontact"},
	news : { col : "news", ctrl:"news", titleClass : "bg-dark", color:"dark",	icon:"newspaper-o"},
	//news : { col : "news" }, 
	config : { col:"config",color:"azure",icon:"cogs",titleClass : "bg-azure", title : tradDynForm.addconfig,
				sections : {
			        network : { label: "Network Config",key:"network",icon:"map-marker"}
			    }},
	network : { col:"network",color:"azure",icon:"map-o",titleClass : "bg-turq"},
	networks : {sameAs:"network"},
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
		"71" : function(){ co.graph() },//g : graph
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
		var heightTopBar = $("#mainNav").height();
		if($("#territorial-menu").length >= 1) heightTopBar = $("#mainNav").height() + $("#territorial-menu").height() + 20;
		$('html, body').stop().animate({
	        scrollTop: $(target).offset().top - 60 - heightTopBar
	    }, 500, '');
	}
}
function simpleScroll(height, speed){
    var scrollToPos = (notNull(height)) ? height : 71;
    var speedScroll = (notNull(speed)) ? speed : 100;
    $('html,body').animate({scrollTop: scrollToPos}, speedScroll, '');
}

function showLoader(id){
	$(id).html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");
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

var timerCloseDropdownUser = false;
function initKInterface(params){ console.log("initKInterface");

	$(window).off();
	$(window).click(function() {
		if( $("#modal-preview-coop").css("display") == "block" )
			$("#modal-preview-coop").css("display","none");
	});

	$('#modal-preview-coop').click(function(event){
		event.stopPropagation();
	});

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

    bindButtonOpenForm();

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
        $("#dropdown-dda").removeClass("open");
        //clearTimeout(timerCloseDropdownUser);
    });
    
    $(".btn-dashboard-dda").click(function(){
        showFloopDrawer(false);
        showNotif(false);
        dashboard.loadDashboardDDA();
        $("#dropdown-user").removeClass("open");
        $("#dropdown-dda").addClass("open");
        //clearTimeout(timerCloseDropdownUser);
    });
    
    $("#dropdown-user").mouseleave(function(){ //alert("dropdown-user mouseleave");
    	setTimeout(function(){ 
    		if(!$("#dropdown-user").is(":hover"))
    			$("#dropdown-user").removeClass("open");
    	}, 200);
        
    });

    /*$("header .container").mouseenter(function(){ 
    	$("#dropdown-user").removeClass("open");
    });*/


    $(".logout").click(function(){ 
    	$.cookie("lyame", "null", { expires: 180, path : "/" });
	  	$.cookie("drowsp", "null", { expires: 180, path : "/" });
	  	$.cookie("remember", false, { expires: 180, path : "/" });
    	window.location.href=baseUrl+"/co2/person/logout";
    });

    $("#btn-sethome").click(function(){
    	urlCtrl.loadByHash("#info.p.sethome")
    });
    $("#btn-apropos").click(function(){
    	urlCtrl.loadByHash("#info.p.apropos")
    });

    $(".btn-create-elem").click(function(){
        currentKFormType = $(this).data("ktype");
        var type = $(this).data("type");
        setTimeout(function(){
                    dyFObj.openForm(type, "sub");
                 },300);
        
    });

    var affixTop = 100;
    if(notEmpty(params)){
    	if(typeof params["affixTop"] != "undefined") affixTop = params["affixTop"];
    }
    console.log("affixTop", affixTop);
    if(affixTop > 0){
      // Offset for Main Navigation
      $("#affix-sub-menu").affix({
          offset: {
              top: affixTop
          }
      });
      /*$("#col-btn-type-directory, #sub-menu-left").affix({
          offset: {
              top: affixTop
          }
      });*/
      /*$("#affix-filters-menu").affix({
          offset: {
              top: affixTop
          }
      });*/
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

var dashboard = {
	ddaView : null,
	loadDashboardDDA : function(){
		mylog.log("loadDashboardDDA");
		$("#list-dashboard-dda").html("<span class='text-center col-xs-12 padding-25'><i class='fa fa-circle-o-notch fa-spin'></i></span>");
		lazyLoad( baseUrl+'/plugins/showdown/showdown.min.js',null, function() { } );
		if( dashboard.ddaView != null ){
			$("#list-dashboard-dda").html(dashboard.ddaView);
		} else {
			$.ajax({
				type: "POST",
				url: baseUrl+'/'+moduleId+"/cooperation/getmydashboardcoop/",
				//dataType: "json",
				success: function(view){
					mylog.log("loadDashboardDDA ok");
					dashboard.ddaView = view;
					$("#list-dashboard-dda").html(view);
				},
				error: function (error) {
					mylog.log("loadDashboardDDA error", error);
					
				}
					
			});
		}
		
	}
};


function getContextDataLinks(){
	mylog.log("getContextDataLinks");
	$.ajax({
		type: "POST",
		url: baseUrl+'/'+moduleId+"/element/getalllinks/type/"+contextData.type+"/id/"+contextData.id,
		dataType: "json",
		success: function(data){
			mylog.log("getContextDataLinks data", data);
			Sig.restartMap();
			if(notNull(contextData)){
				contextData.map = {
					data : data,
					icon : "link",
					title : trad.thecommunityof+" <b>"+contextData.name+"</b>"
				} ;
				Sig.showMapElements(Sig.map, data, "link", trad.thecommunityof+" <b>"+contextData.name+"</b>");
			}
			
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


var co = {
	ctrl : {
		lbh : function (url) { 
			if(userId)
				urlCtrl.loadByHash(url);
			else co.nect();},
		open : function (url,type) { 
			title = null;
			callback = null;

			if(type == "md"){
				title = "Markdown";
				callback = function() {
					getAjax('', url, function(data){ 
							descHtml = dataHelper.markdownToHtml(data) ; 
							smallMenu.content(descHtml);
						}
					,"html");
				}
			} 
			
			else if(type == "youtube") {
				title = "Youtube";
				callback = function() { smallMenu.content('<iframe width="560" height="315" src="'+url+'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>');}
			}

			else if(type == "json") {
				title = "Json";
				callback = function() {
					$("#openModal div.modal-content").css("text-align","left");
					lazyLoad( baseUrl+"/plugins/jsonview/jquery.jsonview.js", 
							  baseUrl+"/plugins/jsonview/jquery.jsonview.css", function() { 
							  	alert();
						getAjax('', url, function(data){ 
							urlT = url.split('/');
							title = url+"<br/>"+urlT[8];
							smallMenu.content().JSONView(data); 
						}
					,"html");
					} );

				}
			}

			if(title){
				smallMenu.open(title,null,null,callback);
			} else
				toastr.error("Type not found!!");},
	},
	help : function () { 
		url = urlCtrl.convertToPath("#default.view.page.links");
	    smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/"+url);	},
	lang : function () { 
		str = "";
		$.each(co,function (k,v) { 
			str += "<a class='btn' href='javascript:;' onclick='co."+k+"()'>co."+k+"</a><br/>";
		})
		smallMenu.open("<h1>Talk to CO</h1>"+str);	},
	//co.rss : function () {  },
	tools : function () { 
		smallMenu.ajaxHTML( baseUrl+'/cotools');
	},
	nect : function () { 
		if(!userId)
			$('#modalLogin').modal("show");
		else 
			toastr.success("allready Loggued in!!");	},
	tribute : function () { 
		window.open('https://www.helloasso.com/associations/open-atlas/collectes/communecter/don', '_blank');	},
	graph : function () { 
		lazyLoad( "https://d3js.org/d3.v4.min.js", null, function() { 
			var what = "id/"+userId+"/type/citoyens";
			if(contextData && contextData.id && contextData.type ) {
				contextDataType = dyFInputs.get(contextData.type).ctrl;
				what = "id/"+contextData.id+"/type/"+contextDataType;
			}
			smallMenu.openAjaxHTML( baseUrl+'/graph/co/d3/'+what);
		} );},
	badge : function () { 
		var what = "id/"+userId+"/type/citoyens";
			if(contextData && contextData.id && contextData.type ) {
				contextDataType = dyFInputs.get(contextData.type).ctrl;
				what = "id/"+contextData.id+"/type/"+contextDataType;
			}
			smallMenu.openAjaxHTML( baseUrl+'/connect/co/badge/'+what);
	},
	gmenu : function () {  },
	mind : function () { 
		if( contextData && contextData.type == "citoyens")
			smallMenu.open("Mindmap",null,null,function() {
				mm = null;
				d3.json(baseUrl+'/api/person/get/id/'+contextData.id+"/format/tree", function(error, data) {
				  if (error) throw error;
				  
				  smallMenu.content("<svg id='mindmap' style='width:100%;height:800px'></svg>");
				  mylog.log( data );
				  markmap('svg#mindmap', data, {
				    preset: 'default', // or colorful
				    linkShape: 'diagonal' // or bracket
				  });
				});
			});
		else co.nect();	},
	md : function (str) { 
		if( contextData)
			co.ctrl.open(baseUrl+'/api/'+dyFInputs.get(contextData.type).ctrl+'/get/id/'+contextData.id+"/format/md","md");
		else 
			toastr.error("No context to build a markdown!!");	},
	agenda : function () { urlCtrl.loadByHash("#agenda");},
	search : function () { urlCtrl.loadByHash("#search");},
	live : function () { urlCtrl.loadByHash("#live");	},
	web : function () { urlCtrl.loadByHash("#web");	},
	annonces : function () { urlCtrl.loadByHash("#annonces");	},
	chat : function () { 
		if(userId)
			rcObj.loadChat("","citoyens", true, true) 
		else co.nect();	},
	add : function (str) { 
		strT = str.split(".");
		type = {
			"org":"organization",
			"o":"organization",
			"pr" : "project",
			"ev" : "event",
			"e" : "event",
			"p" : "person",
			"poi" : "poi"
		}
		if( type[ strT[2] ] )
			dyFObj.openForm(strT[2]);
		//else todo
		// free add form 
		// set a type 

			},
	json : function (str) { 
		if( contextData )
			co.ctrl.open(baseUrl+'/api/'+dyFInputs.get(contextData.type).ctrl+'/get/id/'+contextData.id,"json");
		else 
			toastr.error("No context available!!");	},
	
	// *****************************************
	// Connected person stuff
	// ****************************************
	o : function () { co.ctrl.lbh("#"+userConnected.username+".view.directory.dir.organizations");},
	e : function () { co.ctrl.lbh("#"+userConnected.username+".view.directory.dir.evens");},
	pr : function () { co.ctrl.lbh("#"+userConnected.username+".view.directory.dir.projects");},
	p : function () { co.ctrl.lbh("#"+userConnected.username+".view.directory.dir.follows");},
	poi : function () { co.ctrl.lbh("#"+userConnected.username+".view.directory.dir.poi");},
	info : function () { co.ctrl.lbh("#"+userConnected.username+".view.detail");},
	// *****************************************
	// TODO
	// ****************************************
	
	/*
	ntre : function () { smallMenu.open("<h1>Toutes les propositions de lois et décisions sociétal pour lesquels on est contre</h1>"); } ,
	rd : function () { smallMenu.open("<h1> Visualisation de notre R&D</h1>"); } ,
	roadmap : function () { smallMenu.open("<h1> Visualisation de notre Roadmap</h1>"); } ,
	timeline : function () { smallMenu.open("<h1> Visualisation de notre Timeline</h1>"); } ,
	team : function () { smallMenu.open("<h1>Visualisation de notre Team</h1>"); } ,
	dda : function () { smallMenu.open("<h1> DashBoard Discuss, Decide, Act </h1>"); } ,
	social : function () { smallMenu.open("<h1> connecting to other social plateforms </h1>"); } ,
	city : function () { smallMenu.open("<h1> DashBoard City </h1>"); } ,
	*/
}	

$(document).ready(function() { 
	setTimeout( function () { checkPoll() }, 10000);
	document.onkeyup = keyboardNav.checkKeycode;
	if(notNull(userId) && userId!="") 
		bindRightClicks();
});