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
	.filter-albums-gallery{
		background-color: rgba(0,0,0,0.3);
	    top: 0px;
	    height: 200px;
	    line-height: 200px;
	    left: 0;
	    right: 0;
	    width: auto;
	    text-align:center;
	    text-align: -webkit-center;
	    position:absolute;
	}
	.filter-albums-gallery:hover{
		background-color: rgba(0,0,0,0);
		text-decoration: none;
		text-shadow: 1px 1px 1px rgb(0,0,0);
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
	.filter-albums-gallery .center{
	    margin: auto;
	    margin-top: 70px;
	    width: 100%;
	    line-height: 20px;
	 }
	.filter-albums-gallery .titleAlbum{
		color: white !important;
		text-align: center;
		font-size: 20px;
		text-transform: uppercase;
	} 
	.filter-albums-gallery span{
		color: white !important;
		text-align: center;
		font-size: 12px;
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
.checkbox-info{
	font-size:20px;
}
/* END ZOOM HOVER*/
.checkbox-content {
	padding:5px;
}
.checkbox-content label:after {
    content: '';
    display: table;
    clear: both;
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
/*<div class="checkbox">
            <label style="font-size: 2em">
                <input type="checkbox" value="" checked>
                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                Big
            </label>*/
/*checkbox font-size in (label) + class .checkbox-info*/ 
</style>
<!-- GRID -->
<?php if(@$albums && count($albums)>0){ //print_r($albums); ?>
<hr class="margin-top-5"/>
<ul id="GridAlbums" class="list-unstyled">
	<!-- "gap" elements fill in the gaps in justified grid -->
</ul>
<?php } ?>
<?php if(@$contentKey!=Document::IMG_SLIDER || !empty($colName)){ 
	if(!empty($colName))
		$titleGal=Yii::t("common","Photos of")." '".$colName."'";
	else if(@$contentKey){
		if($contentKey=="profil")
			$titleGal=Yii::t("common","Profile's photos");
		else if($contentKey=="banner")
			$titleGal=Yii::t("common","Cover's photos");
	}
	else
		$titleGal=Yii::t("common","Photos of gallery");
	?>
<span class="col-md-12 col-sm-12 col-xs-12 no-padding margin-top-20 titlePhoto"><?php echo $titleGal ?></span>
<hr class="col-md-12 col-sm-12 col-xs-12no-padding margin-top-5">
<ul id="Grid" class="list-unstyled">
	<!-- "gap" elements fill in the gaps in justified grid -->
</ul>
<?php } ?>
<script type="text/javascript">
var images;
var tabButton = [];
var mapButton = {"media": "Media", "slider": "Album", "profil" : "Profil", "banner" : "Banner", "logo" : "Logo"};
var mapContentKey= {"album": "slider", "profil" : "profil", "banner" : "banner"};
var itemId = "<?php echo $itemId; ?>";
var itemType = "<?php echo $itemType; ?>";
var contentKey = "<?php echo $contentKey; ?>";
var authorizationToEdit = <?php echo (isset($editAlbum) && $editAlbum) ? 'true': 'false'; ?>; 
var images = <?php echo json_encode($images); ?>;
var albums = <?php echo json_encode($albums); ?>;
var contextName = "<?php echo addslashes(@$contextName); ?>";	
var contextIcon = "<?php echo $contextIcon; ?>";
var selectedIds=[];
<?php if(@$breadcrumLevel){ ?>
	var breadcrumLevel=0;
<?php } ?>
jQuery(document).ready(function() {
 	activeMenuElement("gallery");
	initGrid();
	$(".portfolio-item").mouseenter(function(){
		$(this).find(".tools.tools-bottom").show();
	}).mouseleave(function(){
		$(this).find(".tools.tools-bottom").hide();
	});
});

function initGrid(){
	mylog.log(images);
	j = 0;
	$.each(albums, function(k, v){
		nameCol=k;
		contentKey="slider";
		contentTitle=k;
		var s = (v.count>1) ? "s" : "";
		countLabel=v.count+' '+trad["image"+s];
		if(typeof v.countAlbums!="undefined"){
			var s = (v.countAlbums>1) ? "s" : "";
			if(v.countAlbums > 0)
				countLabel=v.countAlbums+" "+trad["album"+s]+" "+trad.and+" "+countLabel;
		}
		if(breadcrumLevel==0){
			contentKey=mapContentKey[k];
			contentTitle=trad[k];
			nameCol="";
			if(contentKey=="slider"){
				countLabel=v.countAlbums+" "+trad["album"+s];
			}
		}
		//text-shadow: 1px 1px 1px rgb(0,0,0);
		var	htmlBtn = ' <a href="javascript:;" class="openFolder filter-albums-gallery" data-name="'+nameCol+'" data-key="'+contentKey+'">'+
							'<div class="center">' +
								'<span class="titleAlbum">'+contentTitle+'</span><br/>'+
								'<span>'+countLabel+'</span>'+
							'</div>'+
						' </a>';

		var htmlAlbums = '<li class="content_image_album mix '+k+' gallery-img no-padding" data-cat="1">'+
					' <div class="portfolio-item portfolio-item-album">'+
						//' <a class="thumb-info" href="'+v.imagePath+'" data-lightbox="all">'+
							' <img src="'+v.imageThumb+'" class="img-responsive" alt="">'+
						//' </a>' +
						//' <div class="chkbox"></div>' +
						htmlBtn +
					' </div>' +
				'</li>' ;
		$("#GridAlbums").append(htmlAlbums);
	});
	$.each(images, function(k, v){
		j++;
		var k=contentKey;
		//if(k=="profil" || k=="slider"){
			/*if($.inArray(k, tabButton)==-1){
				tabButton.push(k);
				var liHtml = '<li class="filter" data-filter=".'+k+'">'+
								'<a href="javascript:;">' + mapButton[k] + '</a>'+
							 '</li>';
				$(".nav-pills").append(liHtml);
			}*/
			//$.each(v, function(docId, document) {
			//for(var i = 0; i<v.length; i++){
				htmlBtn="";
				if(authorizationToEdit){
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
					if(authorizationToEdit)
						htmlBtn	+= '<small> '+v.size+'</small>';
					htmlBtn+= '</span>';
					if(authorizationToEdit){
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
				$("#Grid").append(htmlThumbail);

			//}
	})
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
		$('#Grid').append(htmlDefault);
	}
}

/*function bindBtnGallery(){
	$(".portfolio-item .btnRemove").on("click", function(e){
		var imageId= $(this).data("id");
		var imageName= $(this).data("name");
		var key = $(this).data("key");
		var path="";
		if(key == "slider")
			var path="album";
		else if(key=="communevent")
			var path=key;
//		var path = $(this).data("path");
		e.preventDefault();
		bootbox.confirm("<?php echo Yii::t('common','Are you sure you want to delete') ?> <span class='text-red'>"+
						$(this).data("name")+"</span> ?", 
			function(result) {
				if(result){
					$.ajax({
						url: baseUrl+"/"+moduleId+"/document/delete/dir/"+moduleId+"/type/"+itemType+"/parentId/"+itemId,
						type: "POST",
						dataType : "json",
						data: {"name": imageName, "parentId": itemId, "docId":imageId, 
							  "parentType": itemType, "path" : path, "source":"gallery"},
						success: function(data){
							if(data.result){
								$("#"+imageId).remove();
								toastr.success(data.msg);
							}else{
								toastr.error(data.error)
							}
						}
					});
				}
			});
	});
}*/
</script>