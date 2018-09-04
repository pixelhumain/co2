function getViewGallery(){
		showLoader('#Grid');
		$('#GridAlbums').empty();
		if(docType != ""){
			$(".breadcrum-divs").fadeIn();
			getFileImageContainer();
		}else{
			$(".breadcrum-divs").fadeOut();
			initMenuGallery();
			bindButtonGalleryEvent();
		}	
		changeGalleryUrl();
}
function getFileImageContainer(){
	var url = "gallery/index/type/"+itemType+"/id/"+itemId+"/docType/"+docType+"/tpl/json";
	var data = {};
	if(folderId!="")
		data.folderId=folderId;
	if(notNull(contentKey))
		data.contentKey=contentKey;
	if(typeof timeLimit != "undefined")
		data.timeLimit=timeLimit;
	$.ajax({
		type:"POST",
		url : baseUrl+'/'+moduleId+'/'+url, 
		data:data,
		dataType: "json",
		success: function(data){
			if(typeof data.tagsFilter != "undefined")
				tagsListFilter=data.tagsFilter;
			initGrid(data.folders, data.docs, data.edit);
		}
	});
}
function initGrid(albums, docs, edit){
	j = 0;
	folderHtml="";
	$.each(albums, function(k, v){
		folder.addFolderInNav(k,v);
		
		if(docType == "image"){
			folderHtml+=getImageFolderView(k, v);
		}else{
			folderHtml+=getfilesFolderView(k, v);
		}
	});
	$("#GridAlbums").html(folderHtml);
	$(".title-gallery-photo").hide();
	if(docType=="image" && $("#GridAlbums").html() != "") $(".separator-image-folder").show(); else $(".separator-image-folder, .title-gallery-photo").hide(); 
	htmlItems="";
	$.each(docs, function(k, v){
		j++;
		docsList[k]=v;
		if(docType == "image")
			htmlItems+=getImageItem(k, v, edit);
		else if(docType == "file")
			htmlItems+=getFileItem(k, v, edit);
		else
			htmlItems+=getViewUrl(k,v, edit);
	})
	$("#Grid").html(htmlItems);
	if(j>0){
		$('#Grid').mixItUp();
		$('.portfolio-item .chkbox').bind('click', function () {
	        if ($(this).parent().hasClass('selected')) {
	            $(this).parent().removeClass('selected').children('a').children('img').removeClass('selected');
	        } else {
	            $(this).parent().addClass('selected').children('a').children('img').addClass('selected');
	        }
	    });
	}else{
		var htmlDefault = "<div class='center col-md-12 col-sm-12 col-xs-12 padding-5'>"+
							"<i class='fa fa-ban fa-4x text-dark'></i> <i class='fa fa-picture-o fa-4x text-dark'></i>"+
							" "+trad.nopicture+
						"</div>";
		$('#Grid').html(htmlDefault);
	}
	if(docType=="bookmarks"){
		tagsFilter(edit);
		$("#listTags").show();
		$("#Grid").removeClass("col-xs-12").addClass("col-xs-10");
	}else{
		$("#listTags").hide();
		$("#Grid").removeClass("col-xs-10").addClass("col-xs-12");
	}
	bindButtonGalleryEvent();
}
function getFileItem(k,v, edit){
	var k=v.contentKey;
	titleDoc="";
	if(notNull(v.name))
		titleDoc=v.name;
	var htmlThumbail = '<li class="content_file '+k+' col-sm-12 col-md-12 col-xs-12 no-padding" data-cat="1" id="'+v.id+'">'+
		' <div class="portfolio-item">';
		if(edit){
			htmlThumbail += '<div class="checkbox-content pull-left">'+
				'<label>'+
    				'<input type="checkbox" class="checkPhoto checkbox-info" data-value="'+v.id+'">'+
    				'<span class="cr"><i class="cr-icon fa fa-check"></i></span>'+
				'</label>'+
				'</div>';
		}
		htmlThumbail+='<div class="content-info col-md-8 col-sm-8 col-sx-8 padding-5">'+
						'<span>'+documents.getIcon(k)+' '+titleDoc+' - <i>'+v.size+'</i></span>'+
					'</div>'+
			'<div class="tools tools-right pull-right padding-5">'+
				' <a href="'+v.imagePath+'" target="_blank" class="margin-right-10">' +
					' <i class="fa fa-upload"></i>'+
				' </a>';
		if(edit){
			htmlThumbail+= ' <a href="javascript:;" onclick="updateDocument(\''+v.id+'\', \''+titleDoc+'\')">' +
				' <i class="fa fa-pencil"></i>'+
			' </a>';
		}
		htmlThumbail+='</div>'+
		' </div>' +
	'</li>' ;
	return htmlThumbail;
}
function getImageItem(k, v, edit){
	var k=contentKey;
	htmlBtn="";
	if(edit){
		var	htmlBtn = ' <div class="tools tools-top">' +
			'<div class="checkbox-content">'+
				'<label style="font-size: 1.3em">'+
    				'<input type="checkbox" class="checkPhoto checkbox-info" data-value="'+v.id+'">'+
    				'<span class="cr"><i class="cr-icon fa fa-check"></i></span>'+
				'</label>'+
				'</div>'+
				//'<input type="checkbox" class="checkPhoto checkbox-info" data-value="'+v.id+'"/>'+
			'</div>';
	}
	titleDoc="";
	if(notNull(v.title))
		titleDoc=v.title;
	htmlBtn += ' <div class="tools tools-bottom">';
					htmlBtn +='<span>'+titleDoc;
		if(edit)
			htmlBtn	+= '<small> '+v.size+'</small>';
		htmlBtn+= '</span>';
		if(edit){
			htmlBtn	+= 	' <a href="javascript:;" onclick="updateDocument(\''+v.id+'\', \''+titleDoc+'\')">' +
					' <i class="fa fa-pencil"></i>'+
				' </a>';
		}
	htmlBtn+= 	' </div>';
	var htmlThumbail = '<li class="content_image_album mix '+k+' gallery-img no-padding" data-cat="1" id="'+v.id+'">'+
				' <div class="portfolio-item">'+
					' <a class="thumb-info" href="'+v.imagePath+'" data-lightbox="all">'+
						' <img src="'+v.imageThumbPath+'" class="img-responsive" alt="">'+
					' </a>' +
					//' <div class="chkbox"></div>' +
					htmlBtn +
				' </div>' +
				'</li>' ;
	return htmlThumbail;
}
function getToolBarFolder(k, classes){
	str='<div class="toolsFolder dropdown '+classes+'"> '+
		'<span class="toolsFolder dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="dropdown-menu-folder'+k+'"><i class="fa fa-cogs"></i> '+trad.options+' </i></span>'+
		'<ul class="dropdown-menu arrow_box" aria-labelledby="dropdown-menu-folder'+k+'">'+      	
			'<span onclick="folder.crudFolder(\'update\', \''+k+'\')" class="text-dark col-xs-12 toolsFolderOptions"><i class="fa fa-pencil"></i> '+trad.rename+'</span>'+
			'<span onclick="folder.showPanel(\'move\', \'folders\',\''+k+'\')" class="text-dark col-xs-12 toolsFolderOptions"><i class="fa fa-arrow-right"></i> '+trad.move+'</span>'+
			'<span onclick="folder.crudFolder(\'delete\', \''+k+'\')" class="text-red col-xs-12 toolsFolderOptions"><i class="fa fa-trash"></i> '+trad.delete+'</span>'+
		"</ul>"+
	"</div>";
	return str;
						
}
function getfilesFolderView(k, v, edit){
	nameCol=v.name;
	contentTitle=k;
	htmlFolders = '<li id="folder'+k+'" class="content_folder '+k+' col-xs-12 vertical-folder" data-cat="1">'+
		' <div class="portfolio-item">'+
			' <a href="javascript:;" class="openFolder" data-folder="'+k+'" data-folder-name="'+nameCol+'" data-docType="file">'+
			'<div class="content-info col-sx-12 padding-5">'+
						'<span class="content-info-span"><i class="fa fa-2x fa-folder-o"></i> <span class="titleFolder">'+nameCol+'</span></span>'+
							getToolBarFolder(k,"pull-right text-dark")+
					'</div>'+
		' </a></div>' +
	'</li>' ;
	return htmlFolders;
}
function getImageFolderView(key, v, edit){
	edit=(typeof v.edit != "undefined" && !v.edit) ? v.edit : edit;
	contentFolderKey="slider";
	contentTitle=v.name;
	countLabel="";
	if(typeof v.count != "undefined" && v.count > 0){
		var s = (v.count>1) ? "s" : "";
		countLabel=v.count+' '+trad["image"+s];
	}
	if(typeof v.countFolders!="undefined" && v.countFolders > 0){
		var s = (v.countFolders>1) ? "s" : "";
		countLabel= (countLabel != "") ? "\u2022 "+countLabel : "";
		countLabel=v.countFolders+" "+trad["album"+s]+" "+countLabel;
	}

	keyFolder=key;
	if(typeof v.contentKey != "undefined"){
		contentFolderKey=mapContentKey[key];
		keyFolder="";
	}
	
	var	htmlBtn = ' <a href="javascript:;" class="openFolder filter-albums-gallery" data-folder="'+keyFolder+'" data-folder-name="'+contentTitle+'" data-doctype="image" data-key="'+contentFolderKey+'">'+
						'<div class="center">' +
							'<span class="titleAlbum titleFolder">'+contentTitle+'</span><br/>'+
							'<span>'+countLabel+'</span><br/>';
							if(edit)
								htmlBtn+=getToolBarFolder(key,"text-white");
						htmlBtn+='</div>'+
					' </a>';

	var htmlAlbums = '<li id="folder'+key+'" class="content_image_album mix '+key+' gallery-img no-padding" data-cat="1">'+
				' <div class="portfolio-item portfolio-item-album">'+
					' <img src="'+v.imageThumb+'" class="img-responsive" alt="">'+
					htmlBtn +
				' </div>' +
			'</li>' ;
	return htmlAlbums;
}
function getViewUrl(id,data, edit){
	htmlTags="";
	elTagsList="";
	description="";
	if(typeof data.tags != "undefined"){
		$.each(data.tags,function(i,v){ 
			htmlTags+='<span class="badge letter-red bg-white no-padding">#'+v+'</span> ';
			elTagsList += slugify(v)+" ";
		});
	}
	if(typeof data.description != "undefined"){
		description=checkAndCutLongString(data.description,200,id,"showmoredesc",true);;

	}
	var html = '<li class="content_file '+id+' col-sm-12 col-md-12 col-xs-12 no-padding '+elTagsList+'" data-cat="1" id="'+id+'">'+
			' <div class="portfolio-item">';
			if(edit){
				html += '<div class="checkbox-content pull-left">'+
    				'<label>'+
        				'<input type="checkbox" class="checkPhoto checkbox-info" data-value="'+id+'">'+
        				'<span class="cr"><i class="cr-icon fa fa-check"></i></span>'+
    				'</label>'+
    				'</div>';
			}

			html+='<div class="content-info col-md-10 col-sm-10 col-sx-10 padding-5">'+
					buildLink(data)+
				'</div>'+
				'<div class="tools tools-right pull-right padding-5">';
			if(edit){
				html+= ' <a href="javascript:;" onclick="updateBookmark(\''+id+'\')">' +
					' <i class="fa fa-pencil"></i>'+
				' </a>';
			}
			html+='</div>';
				html+='<div class="contentDescription col-md-12 col-sm-12 col-xs-12">'+
						'<span>'+description+'</span>'+
					'</div>'+
					'<div class="contentTags col-md-12 col-sm-12 col-xs-12">'+
						htmlTags+
					'</div>'+
				'</div>'+
		' </div>' +
	'</li>' ;
	return html;
}
function buildLink(data) { 
	link = '<a href="'+data.url+'" target="_blank">'+data.name+'</a>';
	if( navigator.onLine ){
		if( data.url.indexOf(".md")>= 0  )
			link =  '<a href="javascript:;" onclick="co.ctrl.open(\''+data.url+'\',\'md\')"><span>'+data.name+' </span></a>';
		/*else if(getVidId(data.url) != null ){
			data.url = YouTubeUrlNormalize(data.url);
			link =  '<a href="javascript:;" onclick="co.ctrl.open(\''+data.url+'\',\'youtube\')"><span>'+data.name+' </span></a>';
		}*/
	}
	return link;
 }
 function initMenuGallery(){
 		rootsGallery={
 			"image":{
	 			"title":trad.photos,
	 			"explain":"Partager des photos<br/>Organiser et trier par albums",
	 			"icon": "image",
	 			"img" : moduleUrl+'/images/photos.jpg'
 			},
 			"file":{
	 			"title":trad.documents,
	 			"explain":trad.explainfile,
	 			"icon": "file-text-o",
	 			"img" : moduleUrl+'/images/file3.jpg'
 			},
 			"bookmarks":{
	 			"title":trad.bookmarks,
	 			"explain":trad.explainbookmark,
	 			"icon": "bookmark",
	 			"img" : moduleUrl+'/images/bookmark2.jpeg'
 			}
 		};
 		html="";
 		$.each(rootsGallery, function(docT, value){
 			htmlBtn= ' <a href="javascript:;" class="filter-folder-gallery col-xs-12">'+
							'<div class="">' +
								'<span class="titleAlbum"><i class="fa fa-'+value.icon+'"></i> '+value.title+'</span>'+/*<br/><br/>'+
								'<span>'+value.explain+'</span>'+*/
							'</div>'+
						' </a>';

			html += '<li class="content_folder_file mix library-img col-xs-6" style="margin:0px !important; padding:5px;" data-cat="1">'+
					' <div class="portfolio-item portfolio-item-album openFolder" data-folder="" data-folder-name="'+value.title+'" data-doctype="'+docT+'" data-key="">'+
						'<div class="container-img col-xs-4 no-padding img circle" style="width:100%; height:auto">'+
							' <img src="'+value.img+'" class="initLibrary img-responsive"alt="">'+
						'</div>'+
						htmlBtn +
					' </div>' +
				'</li>';

 		});
 		$("#GridAlbums").html(html);
 		$("#Grid").html("");
}
function tagsFilter(edit){
	$.each(tagsListFilter,function(oTag,oT){
        if( notEmpty( oTag ) ){
          showTag=oTag;
          filterHtml='<a class="btn btn-xs btn-link filterBookmarks '+slugify(oTag)+'Btn pull-right" data-tag="'+slugify(oTag)+'" '+
          				'href="javascript:;" onclick="filterBookmark(\''+addslashes(oTag)+'\',this, '+edit+')">'+
          					"<span class='elipsis tagsElipsis'>#"+showTag+"</span> "+
          					"<span class='badge'>"+oT.count+"</span>"+
          			"</a><br/>";
          $("#listTags").append(filterHtml);
        }
     });
}
function filterBookmark(tag,$this, edit){
	$(".filterBookmarks").removeClass("active");
	$($this).addClass("active");
	showLoader('#Grid');
	$.ajax({
	  type: "POST",
	  url: baseUrl+"/"+moduleId+"/gallery/filter/type/"+itemType+"/id/"+itemId, 
	  data: {tag:tag},
	  success: function(data){
			$("#Grid").html("");
        	$.each(data, function(i, v){
        		url=getViewUrl(i,v, edit);
        		$("#Grid").append(url);
        	});
        	bindButtonGalleryEvent();
	  },
	  dataType: "json"
	});
}