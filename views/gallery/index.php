<style type="text/css">
#breadcrumGallery{
	font-size: 20px;
	font-variant: small-caps;
}
.dropdown-menu-collection{
	position: absolute !important;
	left:10px;
	border: 1px solid rgba(0,0,0,.15);
    border-radius: 2px;
    -webkit-box-shadow: 1px 6px 10px rgba(0,0,0,.6);
    box-shadow: 1px 6px 10px rgba(0,0,0,0.6);
    min-width: 220px;
}
.dropdown-menu-collection:before{
	left:13%;
	margin-left: -11px;
}
.dropdown-menu-collection:after{
	left: -5%;
    margin-left: 30px;
}
ul.dropdown-menu-collection > li{
	display: inline-block;
	display: -webkit-inline-box;
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
</style>
<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="galleryPad">
	<div class="panel panel-white">
		<div class="panel-body">
			<div id="breadcrumGallery" class="col-md-12 col-sm-12 col-xs-12 no-padding">

			</div>
			<?php if($editAlbum=true){ ?>
			<div class="controls col-md-12 col-sm-12 col-xs-12 margin-top-5 no-padding">
				<ul class="nav nav-pills">
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
					<li class="dropdown-collection">
						<a class="btn" href="javascript:;">
							<i class="fa fa-reply fa-rotate-180"></i> <?php echo Yii::t("common","Move to"); ?>
						</a>
						<ul class="dropdown-menu dropdown-menu-collection arrow_box">
	                        <li class="loadingCollection text-center">
	                        	<i class="fa fa-spin fa-refresh"></i> 
	                        </li>
                        </ul>
					</li>
					<li>
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
			<div id="gallery-container" class="col-md-12 col-sm-12 col-xs-12 no-padding">
			<?php
				if($docType=="image"){
					$params = array(
						"images"=>@$images,
						"albums"=>@$albums,
						"itemId"=>$itemId,
						"itemType"=>$itemType,
						"contentKey"=>$contentKey,
						"editAlbum"=>$editAlbum
					);
			 		echo $this->renderPartial("gallery", $params, true);
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
	var docType="<?php echo @$docType; ?>";
	var itemId = "<?php echo $itemId; ?>";
	var itemType = "<?php echo $itemType; ?>";
	var selectedIds=[];
	var breadcrumLevel=0;
	jQuery(document).ready(function() {
		appendLevel(0, "");
		bindButtonGalleryEvent();
		$('ul.nav li.dropdown-collection').hover(function() {
 			$(this).find('.dropdown-menu-collection').stop(true, true).delay(200).fadeIn(500);
 			htmlMenuCol="";
 			if(Object.keys(collectionsGallery).length>0){
 				$.each(collectionsGallery,function(i,v){
 					htmlMenuCol+="<li class='text-left col-md-12 col-sm-12 col-xs-12 no-padding'>"+
 						"<a href='javascript:;' onclick='addToCollection(\""+i+"\")' class='col-md-10 col-sm-10 col-xs-10'>"+i+"</a>"+
 						"<a href='javascript:;' onclick='openDirectoryCollection()' class='col-md-2 col-sm-2 col-xs-2'><i class='fa fa-sign-in'></i></a>"+
 					"</li>";
 				});
 			} else{
 				htmlMenuCol+="<span> Aucun album enregistré</span>";
 			}
 			$(".dropdown-menu-collection").html(htmlMenuCol);
		}, function() {
  			$(this).find('.dropdown-menu-collection').stop(true, true).delay(200).fadeOut(500);
		});
	});
	function appendLevel(breadcrumLevel, name, contentKey){
		if(breadcrumLevel==0){
			$html='<i class="fa fa-home fa-1x text-black" style="padding: 0px 10px 0px 10px;" data-value="'+breadcrumLevel+'"></i><a href="javascript:;" onclick="galleryGuide('+breadcrumLevel+')" class="breadcrumAnchor text-dark" data-value="'+breadcrumLevel+'" data-name="'+name+'">Galerie</a>';
		} else {
			nameBread=name;
			if(nameBread=="")
				nameBread=contentKey;
			$html= '<i class="text-red breadcrumChevron" style="padding: 0px 10px 0px 10px;" data-value="'+breadcrumLevel+'">/</i>'+'<a href="javascript:;" onclick="galleryGuide('+breadcrumLevel+',\''+name+'\',\''+contentKey+'\')" class="breadcrumAnchor text-dark" data-value="'+breadcrumLevel+'">'+nameBread+'</a>';
		}
		$("#breadcrumGallery").append($html);
		if(breadcrumLevel!=0)
			getViewGallery(breadcrumLevel,name, contentKey);
	}
	function bindButtonGalleryEvent(){
		$(".openFolder").off().on("click",function(){
			if($(this).data("name")!=""){
				//collection.push($newColletion);
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
				selectedIds.push(idSelect);
			}else{
				selectedIds.splice(idSelect,1);
			}
		});
		$("#deleteDocuments").off().on("click",function(e){
			//if(key == "slider")
			var path="communecter";
			/*if(key=="communevent")
				var path=key;*/
//			var path = $(this).data("path");
			e.preventDefault();
			bootbox.confirm("<?php echo Yii::t('common','Are you sure you want to delete') ?> <span class='text-red'>"+
						$(this).data("name")+"</span> ?", 
			function(result) {
				if(result){
					$.ajax({
						url: baseUrl+"/"+moduleId+"/document/delete/dir/"+moduleId+"/type/"+itemType+"/id/"+itemId,
						type: "POST",
						dataType : "json",
						data: {/*"name": imageName,*/ "parentId": itemId, "ids":selectedIds, 
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

	}
	function addToCollection(name){
		action="move";
		params={};
		params.name=name;
		params.ids=selectedIds;
		if(selectedIds.length>0){
			ajaxPost(null,baseUrl+"/"+moduleId+"/gallery/crudfile/action/"+action ,params,function(data) { 
					if(data.result){
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
		if(typeof action == "undefined")
			action = "new";
		if(action == "del"){
			params.name = name;
			sure = confirm("Vous êtes sûr ?");
		}
		else if(action == "new" || action == "update")
			params.name = prompt('Nom de la collection ?',name);
		if(action == "update")
			params.oldname = name;
		if(sure)
		{
			ajaxPost(null,baseUrl+"/"+moduleId+"/gallery/crudcollection/action/"+action ,params,function(data) { 
				console.warn(params.action);
				if(data.result){
					toastr.success(data.msg);
					if( typeof type == "undefined" && action == "new"){
						if(!collectionsGallery)
							collectionsGallery = {};
						if(!collectionsGallery[params.name])
							collectionsGallery[params.name] = {};
					}else if(action == "update"){
						if(!collectionsGallery[params.name])
							collectionsGallery[params.name] = collectionsGallery[ params.oldname ];
						delete collectionsGallery[ params.oldname ];
					}else if(action == "del"){
						delete collectionsGallery[params.name];
					}

				}
				else
					toastr.error(data.msg);
			}, "none");
		}
	}

	function getViewGallery(breadcrumLevel,name,contentKey){
		if(docType=="image")
			view="gallery";
		var url = "gallery/index/type/"+itemType+"/id/"+itemId+"/docType/"+docType;
		var data = {};
		if(breadcrumLevel>1)
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
				navCollections.splice($(this).data("name"), 1);
				$(this).remove();
			}
		});
		//mylog.log("breadcrumGuide", newLevel, level, url);

		if(level==0){
			getViewGallery(level,"","");
		}
		else{
			getViewGallery(level,name,contentKey);
			/*if(level < newLevel){
				newLevel=false;
				$(".breadcrumAnchor").each(function(){
					value=$(this).data("value");
					if(value > level){
						$(this).remove();
						$(".breadcrumChevron[data-value='"+value+"']").remove();
					}
				});
			}

			if(newLevel == 5){
				$(".breadcrumChevron[data-value='4']").remove();
				$(".breadcrumAnchor[data-value='4']").remove();
				newLevel=4*;*/
		}
		//getAjaxFiche(url, newLevel); 
	}
</script>