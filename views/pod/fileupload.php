<?php 

	HtmlHelper::registerCssAndScriptsFiles( 
		array(  '/css/default/upload_img.css',
				) , 
	Yii::app()->theme->baseUrl. '/assets');
?>

	<div class="center" id="fileuploadContainer">
		<form  method="post" id="<?php if(isset($podId)) echo $podId.'_'.$contentId; else echo $contentId ?>_photoAdd" enctype="multipart/form-data">
		<div class="fileupload fileupload-new" data-provides="fileupload" id="<?php if(isset($podId)) echo $podId.'_'.$contentId; else echo $contentId ?>_fileUpload">
			<div class="user-image">
				<div class="fileupload-new thumbnail container-fluid" id="<?php if(isset($podId)) echo $podId.'_'.$contentId; else echo $contentId ?>_imgPreview">
				</div>
				<div class="fileupload-preview fileupload-exists thumbnail container-fluid" id="<?php if(isset($podId)) echo $podId.'_'.$contentId; else echo $contentId ?>_imgNewPreview"></div>
				<?php
				if(@Yii::app()->session["userId"] && ((@$editMode && $editMode) || 
					(@$openEdition && $openEdition))){ 

					if($image!="") $editBtn=true; else $editBtn=false;
				?>
				<div class="user-image-buttons">
					<a class="btn btn-blue btn-file btn-upload fileupload-new btn-sm" id="profil_photoAddBtn" ><span class="fileupload-new">
						<i class="fa fa-<?php if($editBtn) echo "pencil"; else echo "plus"?>"></i> <span class="hidden-xs"><?php if($editBtn) echo Yii::t("common","Edit photo"); else echo Yii::t("common","Add a photo") ?></span></span>
						<input type="file" accept=".gif, .jpg, .png" name="avatar" id="<?php if(isset($podId)) echo $podId.'_'.$contentId; else echo $contentId ?>_avatar" class="hide">
						<input class="<?php if(isset($podId)) echo $podId.'_'.$contentId; else echo $contentId ?>_isSubmit hidden" value="true"/>
					</a>
					<a href="#" class="btn btn-upload fileupload-exists btn-red btn-sm" id="<?php if(isset($podId)) echo $podId.'_'.$contentId; else echo $contentId ?>_photoRemove" data-dismiss="fileupload">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="photoUploading" id="<?php if(isset($podId)) echo $podId.'_'.$contentId; else echo $contentId ?>_photoUploading">
					<div class="center" style="text-align: center;">
						<i class="fa fa-spinner fa-spin fa-5x"></i>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		</form>
	</div>


<script type="text/javascript">
	
	jQuery(document).ready(function() {
		
		var id = "<?php echo $itemId ?>";
		var editFile = <?php echo ($editMode) ? 'true':'false'; ?>;
		var type = "<?php echo $type ?>";
		var contentId = "<?php echo Document::IMG_PROFIL ?>";
		var contentIdtoSend = "<?php echo $contentId ?>";
		var resize = <?php echo (@$resize) ? 'true':'false'; ?>;
		var imageName= "";
		var imageId= "";
		var imagesPath = [];
		var image = "<?php echo $image; ?>";
		//alert(image);
		if("undefined" != typeof(contentKeyBase))
			var contentKey = contentKeyBase/*+"."+contentIdtoSend*/;
		else
			contentKey = contentIdtoSend;
		

		//if("undefined" != typeof(image[contentId])){
		//setTimeout(function(){
		initProfilImageUpload();
		//}, 1000);
		//}else{
		//	setTimeout(function(){
			    //initFileUpload();
		//	}, 1000);
		//}
		mylog.log(baseUrl+"/imageTableu:");
		mylog.log(image[contentId.toLowerCase()]);
		$("#"+contentId+"_photoAddBtn").click(function(event){
  			if (!$(event.target).is('input')) {
  					$(this).find("input[name='avatar']").trigger('click');
  			}
			//$('#'+contentId+'_avatar').trigger("click");		
		});
		$('#'+contentId+'_avatar').off().on('change.bs.fileinput', function () {
			if($("."+contentId+"_isSubmit").val()== "true" ){
				setTimeout(function(){
					if(resize){
						$(".fileupload-preview img").css("height", parseInt($("#"+contentId+"_fileUpload").css("width"))*45/100+"px");
						$(".fileupload-preview img").css("width", "auto");
					}
					var file = document.getElementById(contentId+'_avatar').files[0];
					if(file && file.size < 2097152){
						$("#"+contentId+"_photoAdd").submit();
					}else{
						if(file && file.size > 2097152){
							toastr.error("<?php echo Yii::t('fileUpload','Size maximum 2Mo',null,Yii::app()->controller->module->id) ?>");
						}
						/*$("#"+contentId+"_fileUpload").css("opacity", "1");
						$("#"+contentId+"_photoUploading").css("display", "none");
						$(".btn-upload").removeClass("disabled");*/
						updateBtnUpload(false);
						$("#"+contentId+"_fileUpload").fileupload("clear");
					}
				}, 200);


			}else{
				setTimeout(function(){
					if(resize){
						$(".fileupload-preview img").css("height", parseInt($("#"+contentId+"_fileUpload").css("width"))*45/100+"px");
						$(".fileupload-preview img").css("width", "auto");
					}
				}, 200);

				$("."+contentId+"_isSubmit").val("true");
			}
		   
		});


		$("#"+contentId+"_photoAdd").off().on('submit',(function(e) {
			if(debug)mylog.log("id2", id);
			$("."+contentId+"_isSubmit").val("true");
			e.preventDefault();
			/*$("#"+contentId+"_fileUpload").css("opacity", "0.4");
			$("#"+contentId+"_photoUploading").css("display", "block");
			$(".btn-upload").addClass("disabled");*/
			updateBtnUpload(true);
			$("#"+contentId+"_imgPreview").addClass("hidden");
			$.ajax({
				//url: baseUrl+"/"+moduleId+"/api/saveUserImages/type/"+type+"/id/"+id+"/contentKey/"+contentKey+"/user/<?php echo Yii::app()->session["userId"]?>",
				url : baseUrl+"/"+moduleId+"/document/<?php echo Yii::app()->params['uploadUrl'] ?>dir/communecter/folder/"+type+"/ownerId/"+id+"/input/avatar",
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false, 
				processData: false,
				dataType: "json",
				success: function(data){
					if(debug)mylog.log(data);
			  		if(data.success){
			  			imageName = data.name;
			  			var doc = { 
						  		"id":id,
						  		"type":type,
						  		"folder":type+"/"+id,
						  		"moduleId":"communecter",
						  		"author" : "<?php echo (isset(Yii::app()->session['userId'])) ? Yii::app()->session['userId'] : 'unknown'?>"  , 
						  		"name" : data.name , 
						  		"date" : new Date() , 
						  		"size" : data.size ,
						  		"doctype" : "<?php echo Document::DOC_TYPE_IMAGE; ?>",
						  		"contentKey" : contentKey
						  	};

						if(typeof contextData != "undefined" && contextData != null && typeof contextData.parentType != "undefined" && contextData.parentType != null){
							doc["parentType"] = contextData.parentType ;
							doc["parentId"] = contextData.parentId ;
						}

			  			saveImage(doc, "/"+data.dir+data.name);
			  		}
			  		else
			  			toastr.error(data.msg);
			  },
			});
		}));
		
	


		$("#"+contentId+"_photoRemove").off().on("click", function(e){	
			
			$("."+contentId+"_isSubmit").val("false");
			e.preventDefault();

			/*$("#"+contentId+"_fileUpload").css("opacity", "0.4");
			$("#"+contentId+"_photoUploading").css("display", "block");
			$(".btn-upload").addClass("disabled");*/
			updateBtnUpload(true);
			$("#"+contentId+"_imgPreview").removeClass("hidden");
			$.ajax({
				url: baseUrl+"/"+moduleId+"/document/delete/dir/"+moduleId+"/type/"+type+"/parentId/"+id,
				type: "POST",
				dataType : "json",
				data: {"name": imageName, "parentId": id, "parentType": type, "path" : "", "docId" : imageId},
				success: function(data){
					if(data.result){
						
						setTimeout(function(){
							
							/*$("#"+contentId+"_fileUpload").css("opacity", "1");
							$("#"+contentId+"_photoUploading").css("display", "none");
							$(".btn-upload").removeClass("disabled");*/
							updateBtnUpload(false);
							toastr.success(data.msg);
							/*if("undefined" != typeof updateShiftSlider && "function" == typeof updateShiftSlider && (contentId.indexOf(sliderKey) > -1)){
								updateShiftSlider();
							}*/
						}, 2000);

					}else{
						updateBtnUpload(false);
						toastr.error(data.error)
					}
				}
			});
		});


		function initProfilImageUpload(){
			var j = 0;
			//console.log("profilImage",image);
			if(image!=""){
				//imageUrl = baseUrl+image[contentId.toLowerCase()][0];
				j++;
				$("#profil_imgPreview").html('<img class="img-responsive" src="'+baseUrl+image+'" />');	
			}else{
				imageUrl = '<img class="img-responsive thumbnail" src="<?php echo $this->module->assetsUrl ?>/images/thumbnail-default.jpg"/>';
				j++;
				$("#profil_imgPreview").html(imageUrl);

			}
			//if(debug)mylog.log("initFileUpload", images, imagesPath);
			if(j == 0 || resize ){
				if(editFile){
					var textBlock = "<br><?php echo Yii::t('fileUpload','Click on',null,Yii::app()->controller->module->id) ?> <i class='fa fa-plus text-green'></i> <?php echo Yii::t('fileUpload','for share your pictures',null,Yii::app()->controller->module->id) ?>";
					
					var defautText = "<li>" +
										"<div class='center'>"+
											"<i class='fa fa-picture-o fa-5x text-green'></i>"+
											textBlock+
										"</div>"+
									"</li>";
					$("#"+contentId+"_imgPreview").html(defautText);
				}else{
					$("#"+contentId+"_fileUpload").css("visibility", "hidden");
				}
			}
		}
		function saveImage(doc, path){
			mylog.log("----------------saveImage------------------");
			$.ajax({
			  	type: "POST",
			  	url: baseUrl+"/"+moduleId+"/document/save",
			  	data: doc,
		      	dataType: "json"
			}).done( function(data){
		        if(data.result){
		        	imagesPath.push(baseUrl+path);
					//$(".fileupload-preview img").css("max-height", "190px");
					imageId = data.id["$id"];
					setTimeout(function(){
						/*$("#"+contentId+"_fileUpload").css("opacity", "1");
						$("#"+contentId+"_photoUploading").css("display", "none");
						$(".btn").removeClass("disabled");*/
						updateBtnUpload(false);
						mylog.log(typeof(updateSlider));
				  		if(typeof(updateSlider) != "undefined" && typeof (updateSlider) == "function"){
							updateSlider(path, data.id["$id"]);
				  		}
				  		if(typeof(updateSliderImage) !="undefined" && typeof(updateSliderImage) == "function" && "undefined" != typeof events[id]){
				  			updateSliderImage(id, path);
				  		}
					}, 2000) 
				    toastr.success(data.msg);
				    //met à jour l'image de myMarker (marker sur MA position)
				    Sig.initHomeBtn();
				    //met à jour l'image de profil dans le menu principal
				    updateMenuThumbProfil();

				} else{
					updateBtnUpload(false);
					toastr.error(data.msg);
				}

			});
		}
		//met à jour l'image de profil dans le menu principal
		function updateMenuThumbProfil(){ 
			mylog.log("loading new profil");
			$.ajax({
			  	type: "POST",
			  	url: baseUrl+"/"+moduleId+"/element/getthumbpath/type/"+type+"/id/"+id,
			  	dataType: "json"
			}).done( function(data){
				console.log(data);
		        if(typeof data.profilThumbImageUrl != "undefined"){
		        	
		        	profilThumbImageUrl = baseUrl + data.profilThumbImageUrl;
		        	//alert(profilThumbImageUrl);
		        	if(type=="citoyens")
		        		$(".menu-name-profil img").attr("src", profilThumbImageUrl);
		        	//$("#menu-left-thumb-profil").attr("src", profilThumbImageUrl);
		        	//$("#menu-small-thumb-profil").attr("src", profilThumbImageUrl);
		        	$(".identity-min img").attr("src", profilThumbImageUrl);
		        	$("#floopItem-"+type+"-"+id+" a img").attr("src", profilThumbImageUrl);
		        	$("#popup"+id+" img").attr("src", profilThumbImageUrl);
		        	$(".item_map_list_"+id+" .left-col .thumbnail-profil img").attr("src", profilThumbImageUrl);
		        }
		        
		    });
		}

		function updateBtnUpload(addDisable){ 
			if(addDisable == true){
				$("#"+contentId+"_fileUpload").css("opacity", "0.4");
				$("#"+contentId+"_photoUploading").css("display", "block");
				$(".btn-upload").addClass("disabled");
			}else if(addDisable == false){
				$("#"+contentId+"_fileUpload").css("opacity", "1");
				$("#"+contentId+"_photoUploading").css("display", "none");
				$(".btn").removeClass("disabled");
			}
		}
		
	});
	
</script>