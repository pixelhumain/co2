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
	.portfolio-item > .tools.tools-top {
	    top: 0px;
	    right: 3px;
	    width: auto;
	    position:absolute;
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
	.filter-albums-gallery a{
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
</style>

<hr class="margin-top-5"/>
<!-- GRID -->
<?php if(@$albums && count($albums)>0){ //print_r($albums); ?>
<ul id="GridAlbums" class="list-unstyled">
	<!-- "gap" elements fill in the gaps in justified grid -->
</ul>
<?php } ?>
<?php if(@$contentKey!=Document::IMG_SLIDER || !empty($colName)){ ?>
<span class="col-md-12 no-padding margin-top-20 titlePhoto">Photo <?php echo (!empty($colName))? $colName : @$contentKey ?></span>
<hr class="col-md-12 no-padding margin-top-5">
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
if(typeof breadcrumLevel == "undefined"){
	var breadcrumLevel=0;
}
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
		countLabel=v.count+' images';
		if(typeof v.countAlbums!="undefined" && v.countAlbums > 0)
			countLabel=v.countAlbums+" albums and "+countLabel;
		if(breadcrumLevel==0){
			contentKey=mapContentKey[k];
			nameCol="";
			if(contentKey=="slider")
				countLabel=v.countAlbums+" albums";
		}
		var	htmlBtn = ' <div class="filter-albums-gallery"><div class="center">' +
							'<a href="javascript:;" class="openFolder" data-name="'+nameCol+'" data-key="'+contentKey+'">'+k+'</a><br/>'+
							'<span>'+countLabel+'</span>'+
						'</div> </div>';

		var htmlAlbums = '<li class="content_image_album mix '+k+' gallery-img no-padding" data-cat="1">'+
					' <div class="portfolio-item">'+
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
							'<input type="checkbox" class="checkPhoto" data-value="'+v.id+'"/>'+
						'</div>';
				}
				/*var	htmlBtn = ' <div class="tools tools-bottom">' +
								'<span>'+mapButton[k];
					if(authorizationToEdit)
						htmlBtn	+= '<small> - '+v.size+'</small>';
					htmlBtn+= '</span>';
					if(authorizationToEdit){
						htmlBtn	+= 	' <a href="#" class="btnRemove" data-id="'+v.id+'" data-name="'+v.name+'" data-key="';
						if(v.moduleId=="communevent")
							htmlBtn += v.moduleId;
						else
							htmlBtn += v.contentKey;
						htmlBtn += '" >' +
								' <i class="fa fa-trash-o"></i>'+
							' </a>';
					}
				htmlBtn+= 	' </div>';*/

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
		bindBtnGallery();
		$('#Grid').mixItUp();
		$('.portfolio-item .chkbox').bind('click', function () {
	        if ($(this).parent().hasClass('selected')) {
	            $(this).parent().removeClass('selected').children('a').children('img').removeClass('selected');
	        } else {
	            $(this).parent().addClass('selected').children('a').children('img').addClass('selected');
	        }
	    });
	}else{
		var htmlDefault = "<div class='center'>"+
							"<i class='fa fa-picture-o fa-5x text-blue'></i>"+
							"<br>No picture to show"+
						"</div>";
		$('#Grid').append(htmlDefault);
	}
}

function bindBtnGallery(){
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
}
</script>