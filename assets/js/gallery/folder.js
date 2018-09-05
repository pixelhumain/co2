folder={
	panelFolder : { 
		"move":{
			"title":trad.moveinfolder,
			"btnSuccessLabel": trad.move
		},
		"get":{
			"title": trad.selectafolder,
			"btnSuccessLabel": trad.choose
		}
	},
	showPanel: function(action, typeMoved, idSelected, callbackPanel, initDoc){
		var dialog = bootbox.dialog({
		    title: folder.panelFolder[action].title,
		    message: '<div id="folderTreeHtml">'+
		    			'<div id="breadcrumFolder"></div>'+
		    			'<a class="btn btn-default addFolder" href="javascript:;">'+
							'<i class="fa fa-plus"></i> '+trad.folder+
						'</a>'+
		    			'<hr/><div id="list-folder"><p><i class="fa fa-spin fa-spinner"></i> '+trad.currentlyloading+'...</p></div>'+
		    		'</div>',
		    closeButton:false,
		    buttons: {
			    cancel: {
			        label: trad.cancel,
			        className: 'btn-default',
			        callback: function(){
			        	breadcrumLevel=$("#breadcrumGallery .breadcrumAnchor").length;
			            dialog.modal('hide');
			        }
			    },
			    ok: {
			        label: folder.panelFolder[action].btnSuccessLabel,
			        className: 'btn-success',
			        callback: function(e){
			        	e.preventDefault();
			        	var selectedFolder=$("#breadcrumFolder .breadcrumAnchor").last().data("folder-key");
			        	if(action=="move"){
			        		listIds=(typeMoved=="documents") ? selectedIds : [idSelected];
			        		folder.addToFolder(selectedFolder, typeMoved,  listIds);
			        	} else if (action=="get")
			        		callbackPanel(selectedFolder);
			        }
			    }
			}
		});
		dialog.init(function(){
		    //setTimeout(function(){
		    folderKey = (folderId != "") ? folderId : null;
		    breadcrumLevel=0;
		    if(notNull(initDoc)){
		    	folderKey= (notNull(initDoc.folderId)) ? initDoc.folderId : null;
		    	initDoc=initDoc.docType;
		    }
		    folder.openDirectory(folderKey, true, initDoc);
		    $(".addFolder").click(function(){
		    	folder.crudFolder("new", $("#breadcrumFolder .breadcrumAnchor").last().data("folder-key"),  true, initDoc);
		    });
		        //dialog.find('.bootbox-body').html('I was loaded after the dialog was shown!');
		    //}, 1000);
		});
	},
	appendLevel: function(domTarget, inFolder, name, idFolder, contKey, docT){
		className=(inFolder)? "btn btn-default": "bold text-dark";
		foldKey=(notNull(idFolder)) ? idFolder : folderId; 
		contKey=(notNull(contKey)) ? contKey : contentKey;
		labelName=name;
		docT=(notNull(docT)) ? docT: docType;
		if(!inFolder && breadcrumLevel==0){
			labelName= "<i class='fa fa-home'></i>";
			docT="";
		}
		$html="";
		if(breadcrumLevel!=0 && !inFolder)
			$html+= '<i class="text-red breadcrumChevron" style="padding: 0px 10px;" data-value="'+breadcrumLevel+'">/</i>';
		$html+='<a href="javascript:;" class="'+className+' breadcrumAnchor" '+
				'onclick="folder.galleryGuide(\''+domTarget+'\', '+inFolder+','+breadcrumLevel+', \''+name+'\',\''+docT+'\', \''+contKey+'\', \''+foldKey+'\')" '+//'onclick="folder.galleryGuide('+breadcrumLevel+',\''+name+'\',\''+docType+'\', \''+contKey+'\', \''+foldKey+'\')" '+
				'data-value="'+breadcrumLevel+'" '+
				'data-folder-key="'+foldKey+'" '+
				'data-name="'+name+'">'+
					labelName+
			'</a>';
		$(domTarget).append($html);
		breadcrumLevel++;
	},
	openDirectory: function(id, buildLevel, init){
		nameDir="";
		nameDir="";
		htmlMenuCol="";
		docT=(notNull(init)) ? init : docType;
		if(notNull(buildLevel)){
			if(breadcrumLevel==0)
				folder.buildNewBreadcrum("#breadcrumFolder", true, id, docT);
			else{
				folder.appendLevel("#breadcrumFolder", true, navInFolders[id].name, id);
			}
		}
		
		folder.getChildrenFolders(id, docT);
	
	},
	addToFolder : function(id, type, ids){
		action="move";
		params={};
		params.folderId=id;
		params.ids=ids;
		params.idsType=type;
		if(ids.length>0){
			ajaxPost(null,baseUrl+"/"+moduleId+"/folder/crud/action/"+action ,params,function(data) { 
					if(data.result){
						actionCrud=true;
						keyMov="slider";
						if(docType=="image")
							contentKey="slider";
						folderId=(data.movedIn!="")?data.movedIn:null ;
						if(type=="folders")
							navInFolders[data.movedEl._id.$id] = data.movedEl;
						folder.buildNewBreadcrum("#breadcrumGallery", false, folderId);
						getViewGallery();
						selectedIds=[];
						toastr.success(data.msg);
					}
					else
						toastr.error(data.msg);
			}, "none");
		}else{
			toastr.error(trad.pleaseselectdocuments);
		}
	},
	menuFoldersHtml : function(children){
		str="";
		if(Object.keys(children).length>0){
			$.each(children,function(i,v){
				str+='<a href="javascript:;" onclick="folder.openDirectory(\''+i+'\', true)"><i class="fa fa-2x fa-folder-o"></i> '+v.name+'</a>';
	 		});
	 		return str;
		}else{
			return "<span class=''> "+trad.noalbumregister+"</span>";
		}
	},
	crudFolder: function(action, idFolder, inFolder, docT){	
		var params = {};
		params.targetType = itemType;
		params.targetId = itemId;
		params.colType = "documents";
		params.docType = (notNull(docT)) ? docT : docType;
		nameFolder=(action!="new") ? navInFolders[idFolder].name : "";
		if(typeof folderId != "undefined" || notNull(idFolder)){
			params.folderId=(notNull(idFolder)) ? idFolder : folderId;
		}
		if(action == "delete"){
			message= "<div class='danger text-color'>"+
				"<span class='padding-10'>"+trad.allfilesandfolderswillbedeleted+"</span>"+
			"</div>";
			title= trad.areyousurtodeletefolder+" : "+nameFolder;
			onBtnLabel=trad.delete;
			className="btn-danger";
		}
		else if(action == "new" || action == "update"){
			title = (action == "new") ? trad.addnewfolder : trad.renamethefolder;
			onBtnLabel=trad.save;
			className="btn-success";
			message= "<div id='folderAction' class='form-name text-color'><input type='text' placeholder='"+trad.nameoffolder+"' value='"+nameFolder+"' class='form-control'/></div>";
		}
		
		var boxFolder = bootbox.dialog({
		  message: message,
		  title: title,
		  buttons: {
		  	annuler: {
		      label: trad.cancel,
		      className: "btn-default",
		      callback: function() {
		        mylog.log("Annuler");
		      }
		    },
		    enregistrer: {
		      label: onBtnLabel,
		      className: className,
		      callback: function() {
		      	params.name = $("#folderAction input").val();	
				$.ajax({
			        type: "POST",
			        url: baseUrl+"/"+moduleId+"/folder/crud/action/"+action,
			        data: params,
					type: "POST",
			    }).done(function (data) {
		    		if(data)
		    		{
		    			if(action=="delete"){
		    				delete navInFolders[data.folder.id];
		    				$("#folder"+data.folder.id).remove();
		    				toastr.success(data.msg);
		    			}else if(action == "update"){
							navInFolders[data.folder.id].name = data.folder.name;
							$("#folder"+data.folder.id+" .openFolder").data("folder-name", data.folder.name);
							$("#folder"+data.folder.id+" .titleFolder").text(data.folder.name);
						}else if(action == "new"){
							folder.addFolderInNav(data.folder._id.$id, data.folder);//(navInFolders[data.folder._id.$id]=data.folder;
							domTarget=(notNull(inFolder))? "#breadcrumFolder" : "#breadcrumGallery"; 
							folder.appendLevel(domTarget, inFolder, data.folder.name, data.folder._id.$id);
							if(notNull(inFolder))
								$('#list-folder').html(folder.menuFoldersHtml([]));
							else{
								folderId=data.folder._id.$id;
								getViewGallery();
							}
						}
		    		}else{
						toastr.error(data.msg);
		    		}
		    	}).fail(function(){
				   toastr.error(trad.somethingwentwrong); 
				});
		      }
		    },
		  }
		});	
	},
	addFolderInNav : function(k, fold){
		if(typeof navInFolders[k] == "undefined" && $.inArray(k, ["profil","banner", "album"]) < 0 ){
			if(typeof fold.parentId == "undefined")
				fold.parentId=(docType=="image") ? "album" : docType;	
			navInFolders[k]=fold;
		}
	},
	buildNewBreadcrum : function (domTarget, inFolder, idFolder, docT){
		breadcrumLevel=0;
		$(domTarget).html("");
		docT=(notNull(docT))? docT : docType;
		if(!inFolder){
			folder.appendLevel(domTarget, inFolder, 0);
			if(docType!="")
				folder.appendLevel(domTarget, inFolder, docTypeNameFolder[docType], "", "");
		}
		if(notNull(idFolder)){
			parents=folder.getParentsFolders(idFolder, 0, inFolder);
			console.log(parents);
			countParent=Object.keys(parents).length;
			if(countParent > 0){
				for (var i = countParent; i != 0; i--) {
				  	$.each(parents, function(key,v){
						if(v.level==i){
							parentName=v.name;
							folderK=($.inArray(key, ["album", "file"]) <= 0)  ? key:"";
							folder.appendLevel(domTarget, inFolder, parentName, folderK);
							return false;
						}
					});
				}
				
			}
			// Append current level
			folder.appendLevel(domTarget, inFolder, navInFolders[idFolder].name, idFolder);
		}else if(docT=="image" && !inFolder && contentKey!=""){
			//contK=(contentKey=="") ? "slider" : contentKey;
			folder.appendLevel(domTarget, inFolder, mapButton[contentKey], "", contentKey, docT);
			//folder.appendLevel(domTarget, inFolder, mapButton[contentKey]["album"].name, "", contK, docT);
		}else if(inFolder){
			contK=(docT=="image" && contentKey=="") ? "slider" : null;
			nameLabel= (docT=="image") ? navInFolders["album"].name : navInFolders["file"].name;
			folder.appendLevel(domTarget, inFolder, nameLabel, "", contK, docT);
		}
	},
	galleryGuide : function (domTarget, inFolder, level, name, docT, contentK, foldId){
		docType=(typeof docT != "undefined" ) ? docT : "";
		contentKey=(typeof contentK != "undefined" ) ? contentK : ""; 
		folderId=(typeof foldId != "undefined" ) ? foldId : "";
		$(domTarget+" .breadcrumChevron").each(function(){
			if($(this).data("value")>level)
				$(this).remove();
		});
		$(domTarget+" .breadcrumAnchor").each(function(){
			if($(this).data("value")>level)
				$(this).remove();
		});
		breadcrumLevel=level+1;
		if(inFolder)
			folder.openDirectory(folderId);
		else{
			getViewGallery();
		}
	},
	getParentsFolders: function(id, level, inFolder){
		arrayParents={};
		if(typeof navInFolders[id].parentId != "undefined" && (navInFolders[id].parentId != "file" || inFolder)){
			addParent=navInFolders[navInFolders[id].parentId];
			addParent.level=level+1;
			arrayParents[navInFolders[id].parentId]=addParent;
			arrayParents=Object.assign(arrayParents, folder.getParentsFolders(navInFolders[id].parentId, addParent.level));
		}
		return arrayParents;
	},
	getChildrenFolders: function (id, docT){
		arrayChildren={};
		docT=(notNull(docT)) ? docT : docType;
		if(!notNull(id) || id==""){
			var id = (docT == "image") ? "album" : "file";
		}
		if(Object.keys(navInFolders).length > 0){
			$.each(navInFolders,function(i,v){
				if(v.parentId==id){
					arrayChildren[i]=v;
				}
			});
		}	
		if(typeof navInFolders[id].searchedChildren == "undefined"){
			navInFolders[id].searchedChildren=true;
			var params={
				"contextType": itemType,
				"contextId": itemId,
				"docType": docT,
				"children" : true
			};	
			if($.inArray(id, ["album", "file"]) <= 0)
				params.parentId= id;
			$.ajax({
				url: baseUrl+"/"+moduleId+"/folder/list",
				type: "POST",
				dataType : "json",
				data: params,
				success: function(data){
					if(data.result){
						if(Object.keys(data.folders).length > 0){
							$.each(data.folders, function(i,v){
								arrayChildren[i]=v;
								if(typeof v.parentId == "undefined")
									v.parentId=id;
								if(typeof navInFolders[i] == "undefined")
									navInFolders[i]=v;
							});
						}
						$('#list-folder').html(folder.menuFoldersHtml(arrayChildren));
					}else{
						toastr.error(data.error);
					}
				}
			});
		}else{
			$('#list-folder').html(folder.menuFoldersHtml(arrayChildren));
		}
	}

}