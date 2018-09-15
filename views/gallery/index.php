<?php
$cssAnsScriptFilesModule = array(
'/plugins/mixitup/src/jquery.mixitup.js',
);
HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->request->baseUrl);

$cssAnsScriptFilesModule = array(
'/js/pages-gallery.js',
'/css/gallery.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->theme->baseUrl."/assets");
$cssAnsScriptFilesModule = array(
	'/js/gallery/index.js',
	'/js/gallery/folder.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
?>
<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="galleryPad">
	<div class="panel panel-white">
		<div class="panel-body">
			<div id="header-gallery">
			<div id="breadcrumGallery" class="col-xs-12 no-padding breadcrum-divs">
			</div>
			<hr style="margin-top:5px !important;" class="col-xs-12 no-padding no-margin breadcrum-divs">
			<?php if(@$editAlbum && $editAlbum==true){ ?>
			<div class="controls col-xs-12 no-padding">
				<ul class="nav nav-pills">
					<li class="dropdown-add-file">
						<a class="btn show-nav-add" href="javascript:;">
							<i class="fa fa-plus-circle"></i> <?php echo Yii::t("common","Upload"); ?>
						</a>
						<ul class="dropdown-menu dropdown-menu-file arrow_box">
							<li>
								<a class="text-left" href="javascript:dyFObj.openForm('addPhoto')">
									<i class="fa fa-upload"></i> <?php echo Yii::t("common","Add images"); ?>
								</a>
							</li>
	                        <li>
	                        	<a class="show-nav-add text-left" href="javascript:dyFObj.openForm('addFile')">
	                        		<i class="fa fa-file-text-o"></i> <?php echo Yii::t("common","Upload files"); ?> 
	                        	</a>
	                        </li>
	                        <li class="text-left">
	                        	<a class="show-nav-add text-left" href="javascript:dyFObj.openForm('bookmark','sub')">
	                        		<i class="fa fa-bookmark"></i> <?php echo Yii::t("common","Add bookmark") ?>
	                        	</a>
	                        </li>
                        </ul>
					</li>
					<li class="btn-add-folder">
						<a class="btn" href="javascript:;" onclick="folder.crudFolder('new')">
							<i class="fa fa-plus"></i> <?php echo Yii::t("common","Create a folder"); ?>
						</a>
					</li>
					<li class="dropdown-collection btn-move-collection hidden">
						<a class="btn show-nav-col" href="javascript:;">
							<i class="fa fa-reply fa-rotate-180"></i> <?php echo Yii::t("common","Move to"); ?>
						</a>
					</li>
					<li class="btn-move-collection btn-delete-doc hidden">
						<a class="btn text-red" href="javascript:;" id="deleteDocuments">
							<i class="fa fa-trash"></i> <?php echo Yii::t("common","Delete"); ?>
						</a>
					</li>
				</ul>
			</div>
			<hr style="margin-bottom:5px !important;" class="col-xs-12 no-padding no-margin breadcrum-divs">
			<?php } ?>
			</div>
			<div id="gallery-container" class="col-md-12 col-sm-12 col-xs-12 no-padding">
				<ul id="GridAlbums" class="list-unstyled">
					<!-- "gap" elements fill in the gaps in justified grid -->
				</ul>				
				<span class="col-md-12 col-sm-12 col-xs-12 no-padding margin-top-20 title-gallery-photo"></span>
				<hr class="col-md-12 col-sm-12 col-xs-12no-padding margin-top-5 separator-image-folder">
				<ul id="Grid" class="list-unstyled col-xs-12">
					<!-- "gap" elements fill in the gaps in justified grid -->
				</ul>
				<div id="listTags" class="col-xs-2 text-left no-padding" style="display:none;"></div>
				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var navInFolders={"file":{"name": trad.documents}, "album":{"name": trad.Album}};
	var docsList={};
	var historyNav=[];
	var docType="<?php echo @$docType; ?>";
	var folderId="<?php echo @$folderId; ?>";
	var edit="<?php echo @$edit; ?>";
	var itemId = "<?php echo $itemId; ?>";
	var itemType = "<?php echo $itemType; ?>";
	var contentKey= "<?php echo @$contentKey; ?>";
	<?php if(@$initGallery){ ?>
		var initGallery={
			"folders":<?php echo json_encode(@$folders); ?>,
			"docs":<?php echo json_encode(@$docs); ?>, 
			"currentFolders":<?php echo json_encode(@$currentFolders); ?>,
			init:function(){
				if(notNull(initGallery.currentFolders)){
					$.each(initGallery.currentFolders, function(e, v){
						if(typeof v.parentId == "undefined")
							v.parentId=(docType=="image") ? "album":"file";
							navInFolders[v._id.$id]= v;
					});
				}
				initGrid(initGallery.folders, initGallery.docs, edit);
				
			}
		};
	<?php } ?>
	var baseUrlGallery=hashUrlPage+".view.gallery";
	var selectedIds=[];
	var breadcrumLevel=0;
	var actionCrud=false;
	var tagsListFilter = <?php echo json_encode(@$tagsFilter); ?>;
	var mapButton = {"media": "Media", "slider": "Album", "profil" : "Profil", "banner" : "Banner", "logo" : "Logo"};
	var mapContentKey= {"album": "slider", "profil" : "profil", "banner" : "banner"};
	var docTypeNameFolder= {"image": trad.photos, "file" : trad.documents, "bookmarks" : trad.bookmarks};
	var rootsGallery={
		"image":{
			"title":trad.photos,
			"explain":"Partager des photos<br/>Organiser et trier par albums",
			"icon": "image",
			"img" : moduleUrl+'/images/photos.jpg',
			"emptyMsg": trad.nopicture
		},
		"file":{
			"title":trad.documents,
			"explain":trad.explainfile,
			"icon": "file-text-o",
			"img" : moduleUrl+'/images/file3.jpg',
			"emptyMsg" :trad.nofile
		},
		"bookmarks":{
			"title":trad.bookmarks,
			"explain":trad.explainbookmark,
			"icon": "bookmark",
			"img" : moduleUrl+'/images/bookmark2.jpeg',
			"emptyMsg":trad.nobookmark
		}
	};
	jQuery(document).ready(function() {
		if(typeof initGallery != "undefined"){
			initGallery.init();
			delete initGallery;	
		}else//{
			getViewGallery();
			//folder.appendLevel("#breadcrumGallery", false, 0);
		//}
		foldKey=(folderId!="")?folderId:null;
		folder.buildNewBreadcrum("#breadcrumGallery", false, foldKey);
		$('.show-nav-col').click(function() {
 			//$(this).parent().find('.dropdown-menu-collection').stop(true, true).delay(200).fadeIn(500);
 			folder.showPanel("move", "<?php echo Document::COLLECTION ?>");
		});
		$('.show-nav-add').click(function() {
 			$(this).parent().find('.dropdown-menu-file').stop(true, true).delay(200).fadeIn(500);
		});
		$('.dropdown-menu-file').mouseleave(function() {
  			$(this).stop(true, true).delay(200).fadeOut(500);
		});
		$('#header-gallery').affix({
 			offset: {
      			top: 350
		    }
		 }).on('affix.bs.affix', function(){
        	$(this).width($(this).parents().eq(1).width());//css('margin-top', $('#headerNavWrapper').outerHeight(true)+'px');
    	});
	});
	
	function changeGalleryUrl(){
	 	onchangeClick=false;
		newUrlGal=baseUrlGallery;
		if(typeof docType != "undefined" && docType != "")
			newUrlGal+=".dir."+docType;
		if(typeof contentKey != "undefined" && contentKey != "")
			newUrlGal+=".key."+contentKey;
		if(typeof folderId != "undefined" && folderId != "")
			newUrlGal+=".folder."+folderId;
		location.hash=newUrlGal;	
	}	
	function bindButtonGalleryEvent(){
		$(".openFolder").off().on("click",function(e){
			if (!$(e.target).hasClass("toolsFolder") && !$(e.target).hasClass("toolsFolderOptions")){
				newCollection="";
				if($(this).data("folder-name")!="")
					newCollection=$(this).data("folder-name");
				contentKey=$(this).data("key");
				docType=$(this).data("doctype");
				folderId=$(this).data("folder");
				folder.appendLevel("#breadcrumGallery", false, newCollection);
				getViewGallery();
			}
		});
		$(".checkPhoto").click(function(){
			idSelect=$(this).data("value");
			if($(this).is(':checked')){
				$(this).parents().eq(2).addClass("active");
				selectedIds.push(idSelect);
			}else{
				$(this).parents().eq(2).removeClass("active");
				selectedIds.splice(idSelect,1);
			}
			class2=".btn-delete-doc, .btn-move-collection";
			if(inArray(contentKey,["profil","banner","bookmarks"]))
				class2=".btn-delete-doc";
			if(selectedIds.length>0)
				$(class2).removeClass("hidden");
			else
				$(class2).addClass();
		});
		$("#deleteDocuments").off().on("click",function(e){
			var path="communecter";
			e.preventDefault();
			if(docType=="image" || docType=="file")
				url="/document/delete/dir/"+moduleId+"/type/"+itemType+"/id/"+itemId;
			else
				url="/bookmark/delete/type/"+itemType+"/id/"+itemId;
			bootbox.confirm("<?php echo Yii::t('common','Are you sure you want to delete this selection') ?>?", 
			function(result) {
				if(result){
					$.ajax({
						url: baseUrl+"/"+moduleId+url,
						type: "POST",
						dataType : "json",
						data: {"parentId": itemId, "ids":selectedIds, 
							  "parentType": itemType, "path" : path, "source":"gallery"},
						success: function(data){
							if(data.result){
								$.each(selectedIds, function(i,v){
									$("#"+v).remove();
								});
								selectedIds=[];
								toastr.success(data.msg);
							}else{
								toastr.error(data.error)
							}
						}
					});
				}
			});
		});
		$(".btn-showmoredesc").off().click(function(){
            var id = $(this).data("id");
            if($("#"+id+" .contentDescription span.endtext").hasClass("hidden")){
                $("#"+id+" .contentDescription span.endtext").removeClass("hidden");
                $("#"+id+" .contentDescription span.ppp").addClass("hidden");
                $(this).html("Réduire le texte").parent().prepend("<br>");
            }else{
                $("#"+id+" .contentDescription span.endtext").addClass("hidden");
                $("#"+id+" .contentDescription span.ppp").removeClass("hidden");
                $(this).html("Lire la suite").parent().find("br").remove();
            }
         });

	}
	
</script>