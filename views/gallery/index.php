<style type="text/css">
#breadcrumGallery{
	font-size: 20px;
	/*font-variant: small-caps;*/
}
.dropdown-menu-collection, .dropdown-menu-file{
	position: absolute !important;
	left:10px;
	border: 1px solid rgba(0,0,0,.15);
    border-radius: 2px;
    -webkit-box-shadow: 1px 6px 10px rgba(0,0,0,.6);
    box-shadow: 1px 6px 10px rgba(0,0,0,0.6);
}
.dropdown-menu-collection{
	min-width: 220px;
    min-height: 200px;
}
.dropdown-menu-collection:before, .dropdown-menu-file:before{
	left:13%;
	margin-left: -11px;
}
.dropdown-menu-collection:before{
	left:13%;
}
.dropdown-menu-file:before{
	left:16%;
}
.dropdown-menu-file > li > a{
	text-align: left;
}
.dropdown-menu-collection:after, .dropdown-menu-file:after{
	left: -5%;
    margin-left: 30px;
}
ul.dropdown-menu-collection > li .btn-success{
	color:white !important;
}
ul.dropdown-menu-collection > li .btn-success:hover{
	color: white !important;
    background-color: #128f76 !important;
    border-color: #11866f !important;
}
ul.dropdown-menu-collection > li.noHover:hover{
	background-color: white !important;
}
ul.dropdown-menu-collection > li.noHover > span{
	padding: 0px 20px;
	font-size: 16px;
    font-variant: small-caps;
    font-weight: bolder;
}
ul.dropdown-menu-collection > li.noHover > span > i{
	vertical-align: middle;
}
ul.dropdown-menu-collection > li.noHover > span > a{
	float: initial;
}
ul.dropdown-menu-collection > li:hover{
	background-color: #2C3E50;
}
ul.dropdown-menu-collection > li:hover > a{
	color:white !important;
}
ul.dropdown-menu-collection > li:hover > a{
    padding-top: 5px;
    padding-bottom: 5px;
}
ul.dropdown-menu-collection > li > a:hover{
	background-color: inherit !important;
}
.btn-delete-doc, .btn-move-collection{
	display: none;
}
#header-gallery.affix{
    top:113px;
    margin-left: -15px;
    padding-top: 5px;
    -webkit-box-shadow: 0px 0px 5px -1px rgba(0,0,0,0.5);
    -moz-box-shadow: 0px 0px 5px -1px rgba(0,0,0,0.5);
    box-shadow: 0px 0px 2px -1px rgba(0,0,0,0.5);
    z-index: 1000;
    background-color: white;
}
</style>
<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="galleryPad">
	<div class="panel panel-white">
		<div class="panel-body">
			<div id="header-gallery">
			<div id="breadcrumGallery" class="col-md-12 col-sm-12 col-xs-12 no-padding">
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 no-padding"><hr style="margin-bottom:0px;">
			</div>
			<?php if(@$editAlbum && $editAlbum==true){ ?>
			<div class="controls col-md-12 col-sm-12 col-xs-12 margin-top-5 no-padding">
				<ul class="nav nav-pills">
					<?php if($docType=="image"){ ?>
					<li>
						<a class="btn" href="javascript:dyFObj.openForm('addPhoto')">
							<i class="fa fa-upload"></i> <?php echo Yii::t("common","Add Photos"); ?>
						</a>
					</li>
					<li>
						<a class="btn" href="javascript:;" onclick="crudCollectionGallery('new')">
							<i class="fa fa-plus"></i> <?php echo Yii::t("common","Create an album"); ?>
						</a>
					</li>
					<?php } else { ?>
						<li class="dropdown-add-file">
							<a class="btn show-nav-add" href="javascript:;">
								<i class="fa fa-plus-circle"></i> <?php echo Yii::t("common","Add"); ?>
							</a>
							<ul class="dropdown-menu dropdown-menu-file arrow_box">
		                        <li class="text-left">
		                        	<a class="btn show-nav-add text-left" href="javascript:dyFObj.openForm('addFile')">
		                        		<i class="fa fa-file-text-o"></i> <?php echo Yii::t("common","Uploaod files"); ?> 
		                        	</a>
		                        </li>
		                        <li class="text-left">
		                        	<a class="btn show-nav-add text-left" href="javascript:dyFObj.openForm('bookmark','sub')">
		                        		<i class="fa fa-bookmark"></i> <?php echo Yii::t("common","Add bookmark") ?>
		                        	</a>
		                        </li>
	                        </ul>
						</li>
						<li class="btn-add-folder">
							<a class="btn" href="javascript:;" onclick="crudCollectionGallery('new')">
								<i class="fa fa-plus"></i> <?php echo Yii::t("common","Create a folder"); ?>
							</a>
						</li>
					<?php } ?>
					<li class="dropdown-collection btn-move-collection hidden">
						<a class="btn show-nav-col" href="javascript:;">
							<i class="fa fa-reply fa-rotate-180"></i> <?php echo Yii::t("common","Move to"); ?>
						</a>
						<ul class="dropdown-menu dropdown-menu-collection arrow_box">
	                        <li class="loadingCollection text-center">
	                        	<i class="fa fa-spin fa-refresh"></i> 
	                        </li>
                        </ul>
					</li>
					<li class="btn-move-collection btn-delete-doc hidden">
						<a class="btn text-red" href="javascript:;" id="deleteDocuments">
							<i class="fa fa-trash"></i> <?php echo Yii::t("common","Delete"); ?>
						</a>
					</li>
					<!--<li class="filter active" data-filter="all">
						<a href="javascript:;" class="btn btn-default"><?php echo Yii::t("common","Show All"); ?></a>
					</li>-->
				</ul>
			</div>
			<?php } ?>
			</div>
			<div id="gallery-container" class="col-md-12 col-sm-12 col-xs-12 no-padding">
			<?php
				if($docType=="image"){
					$params = array(
						"images"=>@$images,
						"albums"=>@$albums,
						"itemId"=>$itemId,
						"itemType"=>$itemType,
						"contentKey"=>"",
						"editAlbum"=>@$editAlbum,
						"breadcrumLevel"=>true
					);
			 		echo $this->renderPartial("gallery", $params, true);
				}else if($docType=="file"){
					$params = array(
						"files"=>@$files,
						"folders"=>@$folders,
						"itemId"=>$itemId,
						"itemType"=>$itemType,
						"contentKey"=>"",
						"editAlbum"=>@$editAlbum,
						"breadcrumLevel"=>true
					);
			 		echo $this->renderPartial("library", $params, true);
				}
				//print_r($results);
				//echo $docType;
			?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var collectionsGallery=<?php echo json_encode($collections) ?>;
	var navCollections=[];
	var historyNav=[];
	var docType="<?php echo @$docType; ?>";
	var itemId = "<?php echo $itemId; ?>";
	var itemType = "<?php echo $itemType; ?>";
	var selectedIds=[];
	var breadcrumLevel=0;
	var actionCrud=false;
	jQuery(document).ready(function() {
		appendLevel(0, "");
		bindButtonGalleryEvent();
		$('.show-nav-col').click(function() {
 			$(this).parent().find('.dropdown-menu-collection').stop(true, true).delay(200).fadeIn(500);
 			htmlMenuCol="";
 			$.each(navCollections,function(i,v){
 				historyNav.push(v);
 			});
 			openDirectory();
		});
		$('.dropdown-menu-collection').mouseleave(function() {
			if(actionCrud==false){
				navCollections=[];
				$.each(historyNav,function(i,v){
					navCollections.push(v);
				});
				console.log("navHistory",navCollections);
			}
  			$(this).stop(true, true).delay(200).fadeOut(500);
		});
		$('.show-nav-add').click(function() {
 			$(this).parent().find('.dropdown-menu-file').stop(true, true).delay(200).fadeIn(500);
		});
		$('.dropdown-menu-file').mouseleave(function() {
  			$(this).stop(true, true).delay(200).fadeOut(500);
		});
		$('#header-gallery').affix({
 			offset: {
      			top: 500
		    }
		 }).on('affix.bs.affix', function(){
        	$(this).width($(this).parents().eq(1).width());//css('margin-top', $('#headerNavWrapper').outerHeight(true)+'px');
    	});
	});
	function appendLevel(breadcrumLevel, name, contentKey, buildNew){
		if(breadcrumLevel==0){
			if(docType=="image")
				nameFirst=trad.gallery;
			else
				nameFirst=trad.library;
			$html='<i class="fa fa-home fa-1x text-black" style="padding: 0px 10px 0px 10px;" data-value="'+breadcrumLevel+'"></i><a href="javascript:;" onclick="galleryGuide('+breadcrumLevel+')" class="breadcrumAnchor bold text-dark" data-value="'+breadcrumLevel+'" data-name="'+name+'">'+nameFirst+'</a>';
		} else {
			nameBread=name;
			if(nameBread=="")
				nameBread=trad[contentKey];
			$html= '<i class="text-red breadcrumChevron" style="padding: 0px 10px 0px 10px;" data-value="'+breadcrumLevel+'">/</i>'+'<a href="javascript:;" onclick="galleryGuide('+breadcrumLevel+',\''+name+'\',\''+contentKey+'\')" class="breadcrumAnchor bold text-dark" data-value="'+breadcrumLevel+'" data-name="'+nameBread+'">'+nameBread+'</a>';
		}
		$("#breadcrumGallery").append($html);
		if(breadcrumLevel!=0 && buildNew != true)
			getViewGallery(breadcrumLevel,name, contentKey);
	}
	function openDirectory(name,back){
		collectionsDir=collectionsGallery;
		nameDir="";
		htmlMenuCol="";
		noIncrement=false;
		if(back)
			navCollections.splice(navCollections.length-1,1);
		if(navCollections.length>=1 && typeof(name)=="undefined"){
			name=navCollections[navCollections.length-1];
			noIncrement=true;
		}
		if(notNull(name) && name!="undefined"){
			nameDir=name;
			if(back != true && noIncrement!=true)
				navCollections.push(name);
			backHtml="";
			if(navCollections.length>0)
				backHtml="<a href='javascript:;' onclick='openDirectory(\""+addslashes(navCollections[navCollections.length-2])+"\",true)' class='margin-right-5'>"+
							"<i class='fa fa-arrow-circle-left'></i>"+
						"</a>";
			htmlMenuCol="<li class='no-padding col-md-12 col-sm-12 col-xs-12 noHover'>"+
							"<span class='text-center col-md-12 col-sm-12 col-xs-12'>"+backHtml+nameDir+"</span>"+
							"<span class='text-center col-md-12 col-sm-12 col-xs-12 margin-top-5'>"+
								'<a href="javascript:;" onclick="addToCollection(\''+addslashes(name)+'\')" class="btn btn-success">'+trad.movehere+'</a>'+
							"</span>"+
						"</li><hr class=' col-md-12 col-sm-12 no-padding'>";

		}
		if(navCollections.length>0){
			$.each(navCollections,function(i,v){
				console.log(collectionsDir);
				collectionsDir=collectionsDir[v];
			});
		}	
		if(typeof(collectionsDir) != "undefined" && Object.keys(collectionsDir).length>0){
			inc=0;
			$.each(collectionsDir,function(i,v){
				if(i !="updated"){
					inc++;
					console.log(i);
					console.log("slashes",addslashes(i));
 					htmlMenuCol+="<li class='text-left col-md-12 col-sm-12 col-xs-12 no-padding'>"+
 						'<a href="javascript:;" onclick="openDirectory(\''+addslashes(i)+'\')" class="col-md-12 col-sm-12 col-xs-12">'+i+'</a>'+
 					"</li>";
	 			}
	 		});
		} 
		if(typeof(collectionsDir) == "undefined" || Object.keys(collectionsDir).length==0 || inc==0)
			htmlMenuCol+="<span class='col-md-12 col-sm-12 col-xs-12'> "+trad.noalbumregister+"</span>";
		$(".dropdown-menu-collection").html(htmlMenuCol);
	}
	function bindButtonGalleryEvent(){
		$(".openFolder").off().on("click",function(){
			if($(this).data("name")!=""){
				newCollection=$(this).data("name");
			}else{
				newCollection="";
			}
			contentKey=$(this).data("key");
			breadcrumLevel++;
			appendLevel(breadcrumLevel,newCollection,contentKey);
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
			if(docType=="image" || contentKey=="files")
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
								console.log(selectedIds);
								$.each(selectedIds, function(i,v){
									$("#"+v).remove();
									selectedIds=[];//.splice($.inArray(v,selectedIds),1);;
								});
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
             console.log("hasClass ?", $("#"+id+" .contentDescription span.endtext").hasClass("hidden"));
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
	function addToCollection(name){
		action="move";
		params={};
		params.name=name;
		params.ids=selectedIds;
		if(selectedIds.length>0){
			ajaxPost(null,baseUrl+"/"+moduleId+"/gallery/crudfile/action/"+action ,params,function(data) { 
					if(data.result){
						actionCrud=true;
						keyMov="slider";
						docKey=docType;
						if(docType=="file"){
							keyMov="files";
							docKey=keyMov;
						}
						buildNewBreadcrum(docKey);
						getViewGallery(breadcrumLevel,data.movedIn, keyMov,true);
						toastr.success(data.msg);
					}
					else
						toastr.error(data.msg);
			}, "none");
		}else{
			toastr.error("Please select documents before added to a collection");
		}
	}
	function crudCollectionGallery(action){			
		var params = {};
		var sure = true;
		params.targetType = itemType;
		params.targetId = itemId;
		params.colType = "<?php echo Document::COLLECTION ?>";
		params.docType = docType;
		params.subDir = navCollections;
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
			ajaxPost(null,baseUrl+"/"+moduleId+"/gallery/crudcollection/action/"+action ,params,function(data) { 
				if(data.result){
					toastr.success(data.msg);
					if(action == "new"){
						console.log("new",data);
						collectionsGallery=data.collections;
					}else if(action == "update"){
						if(!collectionsGallery[params.name])
							collectionsGallery[params.name] = collectionsGallery[ params.oldname ];
						delete collectionsGallery[ params.oldname ];
					}else if(action == "del"){
						delete collectionsGallery[params.name];
					}
					if(docType=="image")
							keyCreate="slider";
						else
							keyCreate="file";
					if(notNull(data.createdIn))
						getViewGallery(breadcrumLevel,data.createdIn, keyCreate,true);
					else{
						breadcrumLevel=1;
						appendLevel(breadcrumLevel,"",keyCreate);
					}

				}
				else
					toastr.error(data.msg);
			}, "none");
		}
	}
	function buildNewBreadcrum(docType){
		breadcrumLevel=0;
		$("#breadcrumGallery").html("");
		appendLevel(0, "","",true);
		if(docType=="image"){
			breadcrumLevel++;
			appendLevel(breadcrumLevel,"","slider",true);
		}else if(docType=="files" || docType=="bookmarks"){
			breadcrumLevel++;
			appendLevel(breadcrumLevel,"",docType,true);
		}
		$.each(navCollections, function(i,v){
			breadcrumLevel++;
			appendLevel(breadcrumLevel,v,"slider",true);
		});
	}
	function getViewGallery(breadcrumLevel,name,contentKey,action){
		if(docType=="image")
			view="gallery";
		else
			view="library";
		var url = "gallery/index/type/"+itemType+"/id/"+itemId+"/docType/"+docType;
		var data = {};
		if(breadcrumLevel>1 && action!=true )
			navCollections.push(name);
		data.subDir=navCollections;
		data.colName=name;
		data.contentKey=contentKey;
		data.view=view;
		if(typeof timeLimit != "undefined")
			data.timeLimit=timeLimit;
		showLoader('#gallery-container');
		ajaxPost('#gallery-container', baseUrl+'/'+moduleId+'/'+url, 
			data,
			function(){bindButtonGalleryEvent();},"html");
	}
	function galleryGuide(level, name,contentKey){
		breadcrumLevel=level;
		$(".breadcrumChevron").each(function(){
			if($(this).data("value")>level)
				$(this).remove();
		});
		$(".breadcrumAnchor").each(function(){
			if($(this).data("value")>level){
				navCollections.splice($.inArray($(this).data("name"),navCollections), 1);
				$(this).remove();
			}
		});
		if(level==0){
			getViewGallery(level,"","");
		}
		else{
			getViewGallery(level,name,contentKey,true);
		}
	}
</script>