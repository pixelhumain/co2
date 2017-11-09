<style>
	#uploadScropResizeAndSaveImage i{
		position: inherit !important;
	}
	#uploadScropResizeAndSaveImage .close-modal .lr,
	#uploadScropResizeAndSaveImage .close-modal .lr .rl{
		z-index: 1051;
	height: 75px;
	width: 1px;
	background-color: #2C3E50;
	}
	#uploadScropResizeAndSaveImage .close-modal .lr{
	margin-left: 35px;
	transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	-webkit-transform: rotate(45deg);
	}
	#uploadScropResizeAndSaveImage .close-modal .rl{
	transform: rotate(90deg);
	-ms-transform: rotate(90deg);
	-webkit-transform: rotate(90deg);
	}
	#uploadScropResizeAndSaveImage .close-modal {
		position: absolute;
		width: 75px;
		height: 75px;
		background-color: transparent;
		top: 25px;
		right: 25px;
		cursor: pointer;
	}
	.blockUI, .blockPage, .blockMsg{
		padding-top: 0px !important;
	} 

	#banner_element:hover{
	    color: #0095FF;
	    background-color: white;
	    border:1px solid #0095FF;
	    border-radius: 3px;
	    margin-right: 2px;
	}
	#banner_element{
	    background-color: #0095FF;
	    color: white;
	    border-radius: 3px;
	    margin-right: 2px;
	    display:none;
	}
	.header-address{
		font-size: 14px;
		padding-left: 5px;
	}
	#contentBanner img{
		min-height:280px;
	}
</style>

<?php 
	$thumbAuthor =  @$element['profilImageUrl'] ? 
    Yii::app()->createUrl('/'.@$element['profilImageUrl']) : "";
?>

<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 text-left no-padding" id="col-banner">
    

	<form  method="post" id="banner_photoAdd" enctype="multipart/form-data">
		<?php
		if(@Yii::app()->session["userId"] && ((@$edit && $edit) || (@$openEdition && $openEdition))){ 
			if (@$element["profilBannereUrl"] && !empty($element["profilBannereUrl"])) $editBtn=true;
			else $editBtn=false;
		?>
		<div class="user-image-buttons padding-10" style="position: absolute;z-index: 100;">
			<a class="btn btn-blue btn-file btn-upload fileupload-new btn-sm" id="banner_element" >
				<span class="fileupload-new">
					<i class="fa fa-<?php if($editBtn) echo "pencil"; else echo "plus"?>"></i> 
					<span class="hidden-xs"> 
					<?php if($editBtn) echo Yii::t("common","Edit banner"); else echo Yii::t("common","Add a banner") ?>
					</span>
				</span>
				<input type="file" accept=".gif, .jpg, .png" name="banner" id="banner_change" class="hide">
				<input class="banner_isSubmit hidden" value="true"/>
			</a>
		</div>
		<?php }; ?>
	</form>

	<div id="contentBanner" class="col-md-12 col-sm-12 col-xs-12 no-padding">
		<?php if (@$element["profilBannerUrl"] && !empty($element["profilBannerUrl"])){	
			$imgHtml='<img class="col-md-12 col-sm-12 col-xs-12 no-padding img-responsive" 
				src="'.Yii::app()->createUrl('/'.$element["profilBannerUrl"]).'">';
			if (@$element["profilRealBannerUrl"] && !empty($element["profilRealBannerUrl"])){
				$imgHtml='<a href="'.Yii::app()->createUrl('/'.$element["profilRealBannerUrl"]).'"
							class="thumb-info"  
							data-title="'.Yii::t("common","Cover image of")." ".$element["name"].'"
							data-lightbox="all">'.
							$imgHtml.
						'</a>';
			}
			echo $imgHtml;
		} ?>
	</div>
	
	<?php if(!empty($element["preferences"]["isOpenEdition"]) || !empty($element["preferences"]["isOpenData"]) ){ ?>
    <div class="section-badges pull-right">
		<div class="no-padding">
			<?php if(!empty($element["preferences"]["isOpenData"])){?>
				<?php //if( Badge::checkBadgeInListBadges("opendata", $element["badges"]) ){?>
					<div class="badgePH pull-left" data-title="OPENDATA">
						<span class="pull-left tooltips" data-toggle="tooltip" data-placement="left" 
							  title="<?php echo Yii::t("common","Keep data open and usable by all") ?>" style="font-size: 13px; line-height: 30px;">
							<span class="fa-stack opendata" style="width:17px">
								<i class="fa fa-database main fa-stack-1x" style="font-size: 20px;"></i>
								<i class="fa fa-share-alt  mainTop fa-stack-1x text-white" 
									style="text-shadow: 0px 0px 2px rgb(15,15,15);"></i>
							</span> 
							<?php echo Yii::t("common","Open data") ?>
						</span>
					</div>
			<?php //} 
			} ?>

			<?php if (!empty($element["preferences"]["isOpenEdition"])) { ?>
				<div class="badgePH pull-left margin-left-15" data-title="OPENEDITION">
					<a href="javascript:;" class="btn-show-activity">
					<span class="pull-right tooltips" data-toggle="tooltip" data-placement="left" 
							title="<?php echo Yii::t("common","All users can participate and modify informations") ?>" 
							style="font-size: 13px; line-height: 30px;">
						<i class="fa fa-creative-commons" style="font-size: 17px;"></i> 
						<?php echo Yii::t("common","Open edition") ?>
					</span>
					</a>
				</div>
			<?php } ?>
		</div>
    </div>
	<?php } ?>


	<div class="col-xs-12 col-sm-12 col-md-12 contentHeaderInformation <?php if(@$element["profilBannerUrl"] && !empty($element["profilBannerUrl"])) echo "backgroundHeaderInformation" ?>">	
    	
    	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 text-white pull-right">
			<?php if (@$element["status"] == "deletePending") { ?> 
				<h4 class="text-left padding-left-15 pull-left no-margin letter-red"><?php echo Yii::t("common","Being suppressed") ?></h4><br>
			<?php } ?>
			<h4 class="text-left padding-left-15 pull-left no-margin">
				<span id="nameHeader">
					<div class="pastille-type-element bg-<?php echo $iconColor; ?> pull-left">
						
					</div>
					<i class="fa fa-<?php echo $icon; ?> pull-left margin-top-5"></i> 
					<div class="name-header pull-left"><?php echo @$element["name"]; ?></div>
				</span>
				<?php if(($type==Organization::COLLECTION || $type==Event::COLLECTION) && @$element["type"]){ 
					if($type==Organization::COLLECTION)
						$typesList=Organization::$types;
					else
						$typesList=Event::$types;
				?>
					<span id="typeHeader" class="margin-left-10 pull-left">
						<i class="fa fa-x fa-angle-right pull-left"></i>
						<div class="type-header pull-left">
					 		<?php echo Yii::t("category", $typesList[$element["type"]]) ?>
					 	</div>
					</span>
				<?php } ?>
			</h4>					
		</div>

		<?php 
			$classAddress = ( (@$element["address"]["postalCode"] || @$element["address"]["addressLocality"] || @$element["tags"]) ? "" : "hidden" );
		//if(@$element["address"]["postalCode"] || @$element["address"]["addressLocality"] || @$element["tags"]){ ?>
			<div class="header-address-tags col-xs-12 col-sm-9 col-md-9 col-lg-10 pull-right margin-bottom-5 <?php echo $classAddress ; ?>">
				<?php if(!empty($element["address"]["addressLocality"])){ ?>
					<div class="header-address badge letter-white bg-red margin-left-5 pull-left">
						<?php
							echo !empty($element["address"]["streetAddress"]) ? "<i class='fa fa-map-marker'></i> ".$element["address"]["streetAddress"].", " : "";
							echo !empty($element["address"]["postalCode"]) ? 
									$element["address"]["postalCode"].", " : "";
							echo $element["address"]["addressLocality"];
						?>
					</div>
					<?php $classCircleO = (!empty($element["tags"]) ? "" : "hidden" ); ?>
						<span id="separateurTag" class="margin-right-10 margin-left-10 text-white pull-left <?php echo $classCircleO ; ?>" style="font-size: 10px;line-height: 20px;">
							<i class="fa fa-circle-o"></i>
						</span>
					
				<?php } ?>
				<div class="header-tags pull-left">
				<?php 
				if(@$element["tags"]){ 
					foreach ($element["tags"] as $key => $tag) { ?>
						<span class="badge letter-red bg-white" style="vertical-align: top;">#<?php echo $tag; ?></span>
					<?php } 
				} ?>
				</div>
			</div>
		
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-10 pull-right">
			<span class="pull-left text-white" id="shortDescriptionHeader"><?php echo ucfirst(substr(trim(@$element["shortDescription"]), 0, 180)); ?>
			</span>	
		</div>

		<?php if($type==Event::COLLECTION && false){ ?>
			<div class="section-date pull-right">
				
				<div style="font-size: 14px;font-weight: none;">
					<?php if(@$element['parent']){ ?>
						<?php echo Yii::t("common","Planned on") ?> : 
						<a href="#page.type.<?php  echo $element['parentType']; ?>.id.<?php  echo $element['parentId']; ?>" 
							class="lbh"> 
							<i class="fa fa-calendar"></i> <?php  echo $element['parent']['name']; ?>
						</a><br/>
					<?php } ?>
					<?php if(@$element['organizerType'] && @$element['organizerId']){ ?>
						<?php echo Yii::t("common","Organized by"); ?> : 
						<a href="#page.type.<?php  echo $element['organizerType']; ?>.id.<?php  echo $element['organizerId']; ?>" 
							class="lbh"> 
							<i class="fa text-<?php  echo Element::getColorIcon($element['organizerType']); ?> fa-<?php  echo Element::getFaIcon($element['organizerType']); ?>"></i> 
								<?php  echo $element['organizer']['name']; ?>
						</a>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	<?php if($type==Event::COLLECTION || $type==Poi::COLLECTION || $type==Project::COLLECTION){ ?>
		<div class="section-date pull-right">
			<?php if($type==Event::COLLECTION){ ?>
				<div class="header-banner"  style="font-size: 14px;font-weight: none;"></div>
			<?php } ?>
			<div style="font-size: 14px;font-weight: none;">

				<div id="parentHeader" >
					<?php if(@$element['parent']){ 

							if($type==Event::COLLECTION){
								$msg = Yii::t("common","Planned on") ;
							}else{
								$msg = Yii::t("common","Parenthood") ;
							}

						$icon = Element::getFaIcon($element['parentType']);

						echo $msg ?> : <a href="#page.type.<?php  echo $element['parentType']; ?>.id.<?php  echo $element['parentId']; ?>" class="lbh"> <i class="fa fa-<?php echo $icon ; ?>"></i> <?php  echo $element['parent']['name']; ?></a><br/> 
					<?php } ?>
				</div>
				<div id="organizerHeader" >
					<?php if(	@$element['organizerType'] && @$element['organizerId'] && 
								$element["organizerId"] != "dontKnow" && $element["organizerType"] != "dontKnow"){ ?>
						<?php echo Yii::t("common","Organized by"); ?> : 
						<a href="#page.type.<?php  echo $element['organizerType']; ?>.id.<?php  echo $element['organizerId']; ?>" 
							class="lbh"> 
							<i class="fa text-<?php  echo Element::getColorIcon($element['organizerType']); ?> fa-<?php  echo Element::getFaIcon($element['organizerType']); ?>"></i> 
								<?php  echo $element['organizer']['name']; ?>
						</a>
					<?php } ?>
				</div>
			</div>
	    </div>
	<?php } ?>
	</div>

	<div class="pull-right col-sm-3 col-md-3" style=""></div>
</div>

<div id="uploadScropResizeAndSaveImage" style="display:none;padding:0px 60px;">
	<div class="close-modal" data-dismiss="modal"><div class="lr"><div class="rl"></div></div></div>
	<div class="col-lg-12">
		<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/CO2r.png" 
			 class="inline margin-top-25 margin-bottom-5" height="50">
        <br>
	</div>
	<div class="modal-header text-dark">
		<h3 class="modal-title text-center" id="ajax-modal-modal-title">
			<i class="fa fa-crop"></i> <?php echo Yii::t("common","Resize and crop your image to render a beautiful banner") ?>
		</h3>
	</div>
	<div class="panel-body">
		<div class='col-md-offset-1' id='cropContainer'>
			<img src='' id='cropImage' class='' style=''/>
			<div class='col-md-12'>
				<button class='btn btn-success text-white imageCrop saveBanner'><i class="fa fa-send"></i> <?php echo Yii::t("common","Save") ?></button>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(document).ready(function() {
	$("#col-banner").mouseenter(function(){
		$("#banner_element").show();
	}).mouseleave(function(){
		$("#banner_element").hide();
	});
	//IMAGE CHANGE//
	$("#uploadScropResizeAndSaveImage .close-modal").click(function(){
		$.unblockUI();
	});


	$("#banner_element").click(function(event){
			if (!$(event.target).is('input')) {
					$(this).find("input[name='banner']").trigger('click');
			}
		//$('#'+contentId+'_avatar').trigger("click");		
	});
	
	$('#banner_change').off().on('change.bs.fileinput', function () {
		setTimeout(function(){
			var files = document.getElementById("banner_change").files;
			if (files[0].size > 2097152)
				toastr.warning("Please reduce your image before to 2Mo");
			else {
				for (var i = 0; i < files.length; i++) {           
			        var file = files[i];
			       	var imageType = /image.*/;     
			        if (!file.type.match(imageType)) {
			            continue;
			        }           
			        var img=document.getElementById("cropImage");            
			        img.file = file;    
			        var reader = new FileReader();
			        reader.onload = (function(aImg) { 
			        	var image = new Image();
							image.src = reader.result;
							img.src = reader.result;
							image.onload = function() {
   							// access image size here 
   						 	var imgWidth=this.width;
   						 	var imgHeight=this.height;
   							if(imgWidth>=400 && imgHeight>=150){
               					$.blockUI({ 
               						message: $('div#uploadScropResizeAndSaveImage'), 
               						css: {cursor:null,padding: '0px !important'}
               					}); 
               					$("#uploadScropResizeAndSaveImage").parent().css("padding-top", "0px !important");
								//$("#uploadScropResizeAndSaveImage").html(html);
							    
								setTimeout(function(){
									var setImage={"width":1600,"height":400};
									var parentWidth=$("#cropContainer").width();
									//var parentHeight=setImage.height*(parentWidth/setImage.width);
									var crop = $('#cropImage').cropbox({
										width: parentWidth,
										height: 300,
										zoomIn:true,
										zoomOut:true}, function() {
											cropResult=this.result;
											console.log(cropResult);
									}).on('cropbox', function(e, crop) {
										cropResult=crop;
						        		console.log('crop window: ', crop);
						        
									});
									$(".saveBanner").click(function(){
								        //console.log(cropResult);
								        //var cropResult=cropResult;
								        $(this).prop("disabled",true);
								        $(this).find("i").removeClass("fa-send").addClass("fa-spin fa-spinner");
								        $("#banner_photoAdd").submit();
									});
									$("#banner_photoAdd").off().on('submit',(function(e) {
										//alert(moduleId);
										if(debug)mylog.log("id2", contextData.id);
										$(".banner_isSubmit").val("true");
										e.preventDefault();
										console.log(cropResult);
										var fd = new FormData(document.getElementById("banner_photoAdd"));
										fd.append("parentId", contextData.id);
										fd.append("parentType", contextData.type);
										fd.append("formOrigin", "banner");
										fd.append("contentKey", "banner");
										fd.append("cropW", cropResult.cropW);
										fd.append("cropH", cropResult.cropH);
										fd.append("cropX", cropResult.cropX);
										fd.append("cropY", cropResult.cropY);
										//var formData = new FormData(this);
													//console.log("formdata",formData);
										/*formData.files= document.getElementById("banniere_change").files;
										formData.crop= cropResult;
										formData.parentId= contextData.id;
										formData.parentType= contextData.type;
										formData.formOrigin= "banniere";*/
										//console.log(formData);
										// Attach file
										//formData.append('image', $('input[type=banniere]')[0].files[0]); 
										$.ajax({
											url : baseUrl+"/"+moduleId+"/document/uploadSave/dir/communecter/folder/"+contextData.type+"/ownerId/"+contextData.id+"/input/banner",
											type: "POST",
											data: fd,
											contentType: false,
											cache: false, 
											processData: false,
											dataType: "json",
											success: function(data){
										        if(data.result){
										        	$(".saveBanner").prop("disabled",false);
								        			$(".saveBanner").find("i").removeClass("fa-spin fa-spinner").addClass("fa-send");
										        	newBanner='<img class="col-md-12 col-sm-12 col-xs-12 no-padding img-responsive" src="'+baseUrl+data.src.profilBannerUrl+'" style="">';
										        	$("#contentBanner").html(newBanner);
										        	$(".contentHeaderInformation").addClass("backgroundHeaderInformation");
										        	$.unblockUI();
										        	//$("#uploadScropResizeAndSaveImage").hide();
										    	}
										    }
										});
									}));
								}, 300);
							}
   						 	else
   						 		toastr.warning(trad["minsizebanner"]);
						};
			        });
			        reader.readAsDataURL(file);
			    }  
			}
		}, 400);
	});
});
</script>