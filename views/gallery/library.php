<?php
$cssAnsScriptFilesModule = array(
'/plugins/mixitup/src/jquery.mixitup.js',
);
HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->request->baseUrl);

$cssAnsScriptFilesModule = array(
'/js/pages-gallery.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->theme->baseUrl."/assets");

$contextIcon = "photo";

if( isset($parent) ){
	$contextName = $parent["name"];
	$parentName=$parent["name"];
}
?>
<!-- start: PAGE CONTENT -->
<style type="text/css">
	.gallery-img img{
		width: 200px;
		height: 200px;
	}

	.panel-tools{
		filter: alpha(opacity=1);
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=1)";
		-moz-opacity: 1;
		-khtml-opacity: 1;
		opacity: 1;
	}
	#Grid .mix, #GridAlbums .mix{
		margin: 2px !important;
	}
	.content_image_album{
		float:left;
		width:200px;
		height:200px;
		position: relative;
	}
	.content_folder_file{
		float:left;
		position: relative;
		border-bottom: 1px solid rgba(0,0,0,0.1);
    	padding: 5px 0px;
	}
	.filter-folder-gallery, .filter-albums-gallery{
	    top: 0px;
	    left: 0;
	    right: 0;
	    width: auto;
	    text-align:center;
	    text-align: -webkit-center;
	    position:absolute;
	}
	.filter-folder-gallery{
		bottom:0px;
		background-color: rgba(0,0,0,0.5);
	}
	.filter-albums-gallery{
		height: 200px;
	    line-height: 200px;
	    background-color: rgba(0,0,0,0.3);
	}
	.filter-folder-gallery:hover, .filter-albums-gallery:hover{
		text-decoration: none;
		text-shadow: 1px 1px 1px rgb(0,0,0);
	}
	.filter-folder-gallery:hover{
		background-color: rgba(0,0,0,0.2);
	}
	.filter-albums-gallery:hover{
		background-color: rgba(0,0,0,0);
	}
	.portfolio-item > .tools.tools-bottom {
	    background-color: rgba(0,0,0,0.3);
	    bottom: 0px;
	    height: 40px;
	    line-height: 40px;
	    left: 0;
	    right: 0;
	    width: auto;
	    display: none;
	    position:absolute;
	}
	.portfolio-item > .tools.tools-top.active {
		display:block !important;
	}
	.portfolio-item > .tools.tools-top {
	    top: 0px;
	    right: 0px;
	    width: auto;
	    position:absolute;
	    display: none;
	}
	.portfolio-item:hover > .tools.tools-top {
	    display: block;
	 }
	
	.portfolio-item:hover > .tools.tools-bottom {
	    display: block;
	 }
	.filter-folder-gallery .center, .filter-albums-gallery .center{
	    margin: auto;
	    margin-top: 70px;
	    width: 100%;
	    line-height: 20px;
	 }
	.filter-folder-gallery .titleAlbum,.filter-albums-gallery .titleAlbum{
		color: white !important;
		text-align: center;
		font-size: 20px;
		text-transform: uppercase;
	} 
	.filter-folder-gallery span, .filter-albums-gallery span{
		color: white !important;
		text-align: center;
	}
	.filter-albums-gallery span{
		font-size: 12px;
	}
	.filter-folder-gallery span{
		font-size: 16px;
	}
	.portfolio-item .tools.tools-bottom > a, .portfolio-item .tools.tools-top > a {
	    position: absolute;
	    right: 15px;
    	padding:inherit;
		color: white !important;
	}
	.portfolio-item .tools.tools-bottom > span, .portfolio-item .tools.tools-top > span {
	    position: absolute;
	    left: 15px;
    	padding:inherit;
		color: white !important;
	}
	.titlePhoto{
		font-size: 19px;
		font-variant: small-caps;
	}

.portfolio-item-album > img
{
    -webkit-transition: all 200ms ease-in;
    -webkit-transform: scale(1); 
    -ms-transition: all 200ms ease-in;
    -ms-transform: scale(1); 
    -moz-transition: all 200ms ease-in;
    -moz-transform: scale(1);
    transition: all 200ms ease-in;
    transform: scale(1);   

}
.portfolio-item-album{
	overflow:hidden;
}
.portfolio-item-album:hover{
    box-shadow: 0px 0px 5px rgba(0,0,0,0.6);
}
.portfolio-item-album:hover > img
{
    /*z-index: 2;*/
    -webkit-transition: all 200ms ease-in;
    -webkit-transform: scale(1.2);
    -ms-transition: all 200ms ease-in;
    -ms-transform: scale(1.2);   
    -moz-transition: all 200ms ease-in;
    -moz-transform: scale(1.2);
    transition: all 200ms ease-in;
    transform: scale(1.2);
}
.initLibrary{
	filter:grayscale(75%);
}
.portfolio-item-album:hover > .initLibrary{
	filter:grayscale(50%);
}
.checkbox-info{
	font-size:20px;
}
/* END ZOOM HOVER*/
.checkbox-content {
	padding:5px;
}
.checkbox-content label {
    margin-bottom: 0px;
    vertical-align: bottom;
   	font-size: 10px;
}
.checkbox-content .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    width: 1.3em;
    height: 1.3em;
    background-color: white;
}


.checkbox-content .cr .cr-icon
{
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.checkbox-content label input[type="checkbox"]
 {
    display: none;
}

.checkbox-content label input[type="checkbox"] + .cr > .cr-icon
 {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox-content label input[type="checkbox"]:checked + .cr > .cr-icon
 {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}
.checkbox-content label input[type="checkbox"]:checked + .cr{
	background-color: #2BB0C6;
	color:white;
	box-shadow: 0px 0px 16px rgba(250,250,250,0.9);
	border: 1px solid white;
}
.checkbox-content label input[type="checkbox"]:disabled + .cr
 {
    opacity: .5;
}
@media screen and (min-width: 768px) {
.content_folder_file, .content_folder_file{
	width:48%;
}
}
@media screen and (max-width: 768px) {
	.content_folder_file{
		width:100%;
	}
}
#GridAlbums .folder:hover{
	background-color: rgba(0,0,0,0.1);
}
#listTags > a {
	width: 100%;
	padding: 5px 5px;
	text-align: right;
}
.tagsElipsis{
	max-width: 75%;
	margin-right: 2px;
	vertical-align: bottom;
}
.filterBookmarks .badge{
    background-color: #337ab7;
    color: white;
    font-size: 11px;
    padding: 3px 6px;
}
.filterBookmarks.active{
	border-right: 0px solid #337ab7;
    background-color: #337ab7;
    color: white;
    text-decoration: none;
}
.filterBookmarks:hover{
	width:initial !important;
	float: right !important;
    background-color: #337ab7;
    color:white;
    text-decoration: none;
}
.filterBookmarks:hover > .tagsElipsis{
	max-width: inherit; 
}
.filterBookmarks:hover > .badge, .filterBookmarks.active > .badge{
	background-color: white;
	color: #337ab7; 
}
</style>
<!-- GRID -->
<?php if(@$folders && count($folders)>0){ //print_r($albums); ?>
<hr class="margin-top-5"/>
<ul id="GridAlbums" class="list-unstyled">
	<!-- "gap" elements fill in the gaps in justified grid -->
</ul>
<?php } ?>

<ul id="Grid" class="list-unstyled <?php if($contentKey=="bookmarks") echo "col-md-10 col-sm-10" ?>">
	<!-- "gap" elements fill in the gaps in justified grid -->
</ul>
<?php if($contentKey=="bookmarks"){ ?>
 <div id="listTags" class="col-sm-2 col-md-2 text-left no-padding"></div>
<?php } ?>
<script type="text/javascript">
var fies;
var tabButton = [];
var mapButton = {"files":"Files","bookmarks":"Bookmarks"};
var mapContentKey= {"album": "slider", "profil" : "profil", "banner" : "banner"};
var itemId = "<?php echo $itemId; ?>";
var itemType = "<?php echo $itemType; ?>";
var contentKey = "<?php echo $contentKey; ?>";
var authorizationToEdit = <?php echo (isset($editAlbum) && $editAlbum) ? 'true': 'false'; ?>; 
var files = <?php echo json_encode($files); ?>;
var folders = <?php echo json_encode($folders); ?>;
if(contentKey=="bookmarks")
	var tagsListFilter = <?php echo json_encode(@$tagsFilter); ?>;
var contextName = "<?php echo addslashes(@$contextName); ?>";	
var contextIcon = "<?php echo $contextIcon; ?>";
var selectedIds=[];
<?php if(@$breadcrumLevel){ ?>
	var breadcrumLevel=0;
<?php } ?>
jQuery(document).ready(function() {
 	activeMenuElement("library");
	initPanelLibrary();
	$(".portfolio-item").mouseenter(function(){
		$(this).find(".tools.tools-bottom").show();
	}).mouseleave(function(){
		$(this).find(".tools.tools-bottom").hide();
	});
	if(contentKey=="bookmarks")
		$(".btn-add-folder").hide();
	else
		$(".btn-add-folder").show();
});

function initPanelLibrary(){
	mylog.log(files);
	j = 0;
	if(breadcrumLevel==0){
		htmlLibInit=initMenuLibrary();
		$("#GridAlbums").append(htmlLibInit);
	}
	else{
		$.each(folders, function(k, v){
			nameCol=k;
			contentTitle=k;
			htmlFolders = '<li class="content_folder '+k+' col-sm-12 col-md-12 col-xs-12" data-cat="1">'+
				' <div class="portfolio-item">'+
					' <a href="javascript:;" class="openFolder" data-name="'+nameCol+'" data-key="files">'+
					'<div class="content-info col-md-8 col-sm-8 col-sx-8 padding-5">'+
								'<span><i class="fa fa-folder"></i> '+nameCol+'</span>'+
							'</div>'+
				' </a></div>' +
			'</li>' ;
			$("#GridAlbums").append(htmlFolders);
		});
		$.each(files, function(k, v){
			j++;
			if(contentKey=="files"){	
					var k=v.contentKey;
					titleDoc="";
					if(notNull(v.name))
						titleDoc=v.name;
					var htmlThumbail = '<li class="content_file '+k+' col-sm-12 col-md-12 col-xs-12" data-cat="1" id="'+v.id+'">'+
						' <div class="portfolio-item">';
						if(authorizationToEdit){
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
						if(authorizationToEdit){
							htmlThumbail+= ' <a href="javascript:;" onclick="updateDocument(\''+v.id+'\', \''+titleDoc+'\')">' +
								' <i class="fa fa-pencil"></i>'+
							' </a>';
						}
						htmlThumbail+='</div>'+
					' </div>' +
				'</li>' ;
			}else
				htmlThumbail=getViewUrl(k,v);
			$("#Grid").append(htmlThumbail);

				//}
		});
		if(contentKey=="bookmarks"){
			tagsFilter(tagsListFilter);
		}
		if(j>0){
			
		}else{
			var htmlDefault = "<div class='center col-md-12 col-sm-12 col-xs-12 padding-5'>"+
								"<i class='fa fa-files-o fa-5x text-blue'></i>"+
								"<br>"+trad.nofile+
							"</div>";
			$('#Grid').append(htmlDefault);
		}
	}

}
function getViewUrl(id,data){
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
			if(authorizationToEdit){
				html += '<div class="checkbox-content pull-left">'+
    				'<label>'+
        				'<input type="checkbox" class="checkPhoto checkbox-info" data-value="'+id+'">'+
        				'<span class="cr"><i class="cr-icon fa fa-check"></i></span>'+
    				'</label>'+
    				'</div>';
			}
			html+='<div class="content-info col-md-10 col-sm-10 col-sx-10 padding-5">'+
					'<a href="'+data.url+'" target="_blank">'+
						'<span>'+data.name+' </span>'+
					'</a>'+
				'</div>'+
				'<div class="tools tools-right pull-right padding-5">';
			if(authorizationToEdit){
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
function initMenuLibrary(){
	htmlBtn = ' <a href="javascript:;" class="openFolder filter-folder-gallery" data-name="" data-key="bookmarks">'+
						'<div class="center">' +
							'<span class="titleAlbum"><i class="fa fa-bookmark"></i> '+trad.bookmarks+'</span><br/><br/>'+
							'<span>'+trad.explainbookmark+'</span>'+
						'</div>'+
					' </a>';

	html = '<li class="content_folder_file mix library-img no-padding" data-cat="1">'+
				' <div class="portfolio-item portfolio-item-album">'+
					//' <a class="thumb-info" href="'+v.imagePath+'" data-lightbox="all">'+
						' <img src="'+moduleUrl+'/images/bookmarks.jpg" class="initLibrary img-responsive" alt="">'+
					//' </a>' +
					//' <div class="chkbox"></div>' +
					htmlBtn +
				' </div>' +
			'</li>';
	htmlBtn = ' <a href="javascript:;" class="openFolder filter-folder-gallery" data-name="" data-key="files">'+
						'<div class="center">' +
							'<span class="titleAlbum"><i class="fa fa-file-text-o"></i> '+trad.files+'</span><br/><br/>'+
							'<span>'+trad.explainfile+'</span>'+
						'</div>'+
					' </a>';

	html += '<li class="content_folder_file mix library-img no-padding" data-cat="1">'+
				' <div class="portfolio-item portfolio-item-album">'+
					//' <a class="thumb-info" href="'+v.imagePath+'" data-lightbox="all">'+
						' <img src="'+moduleUrl+'/images/files.jpg" class="initLibrary img-responsive" alt="">'+
					//' </a>' +
					//' <div class="chkbox"></div>' +
					htmlBtn +
				' </div>' +
			'</li>';
	return html;
}
function tagsFilter(tags){
	$.each(tags,function(oTag,oT){
        if( notEmpty( oTag ) ){
          //directory.multiTagsT.push(oTag);
          //mylog.log(oTag);
          showTag=oTag;
          /*if(oTag.length > 10)
          	showTag=oTag.substring(0,10)+"...";*/
          filterHtml='<a class="btn btn-xs btn-link filterBookmarks '+slugify(oTag)+'Btn pull-right" data-tag="'+slugify(oTag)+'" '+
          				'href="javascript:;" onclick="filterBookmark(\''+addslashes(oTag)+'\',this)">'+
          					"<span class='elipsis tagsElipsis'>#"+showTag+"</span> "+
          					"<span class='badge'>"+oT.count+"</span>"+
          			"</a><br/>";
          $("#listTags").append(filterHtml);
        }
     });
}
function filterBookmark(tag,$this){
		$(".filterBookmarks").removeClass("active");
		$($this).addClass("active");
		showLoader('#Grid');
		$.ajax({
		  type: "POST",
		  url: baseUrl+"/"+moduleId+"/gallery/filter/type/"+itemType+"/id/"+itemId, 
		  data: {tag:tag},
		  success: function(data){
			//if(data.result) {
				$("#Grid").html("");
	        	$.each(data, function(i, v){
	        		url=getViewUrl(i,v);
	        		$("#Grid").append(url);
	        	});
	        	bindButtonGalleryEvent();
			/*}
	        else
	        	toastr.error(data.msg);*/  
		  },
		  dataType: "json"
		});
}
</script>