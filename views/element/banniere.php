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

	#banniere_element:hover{
	    color: #0095FF;
	    background-color: white;
	    border:1px solid #0095FF;
	    border-radius: 3px;
	    margin-right: 2px;
	}
	#banniere_element{
	    background-color: #0095FF;
	    color: white;
	    border-radius: 3px;
	    margin-right: 2px;
	}

</style>




<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 text-left no-padding" id="col-banniere">
        	
	<?php if($type==Event::COLLECTION){ ?>
	<div class="col-xs-9 col-sm-6 col-md-5 col-lg-5 margin-right-15 margin-top-25 section-date pull-right"></div>
	<?php } ?>
	<div class="margin-right-15 margin-top-25 section-address pull-right">
		<?php 
			echo @$element["address"]["postalCode"] ? "<i class='fa fa-map-marker'></i> ".$element["address"]["postalCode"] : "";
			echo @$element["address"]["postalCode"] && @$element["address"]["addressLocality"] ? ", ".$element["address"]["addressLocality"] : "";
		?>
	</div>
	

	<?php 
		$thumbAuthor =  @$element['profilImageUrl'] ? 
          Yii::app()->createUrl('/'.@$element['profilImageUrl']) 
          : "";
	?>
	<form  method="post" id="banniere_photoAdd" enctype="multipart/form-data">
		<?php
		if(@Yii::app()->session["userId"] && ((@$edit && $edit) || (@$openEdition && $openEdition))){ ?>
		<div class="user-image-buttons padding-10">
			<a class="btn btn-blue btn-file btn-upload fileupload-new btn-sm" id="banniere_element" >
				<span class="fileupload-new"><i class="fa fa-plus"></i> <span class="hidden-xs"> Banniere</span></span>
				<input type="file" accept=".gif, .jpg, .png" name="banniere" id="banniere_change" class="hide">
				<input class="banniere_isSubmit hidden" value="true"/>
			</a>
		</div>
		<?php }; ?>

	</form>
	<div id="contentBanniere" class="col-md-12 col-sm-12 col-xs-12 no-padding">
		<?php if (@$element["profilBanniereUrl"] && !empty($element["profilBanniereUrl"])){ ?> 
			<img class="col-md-12 col-sm-12 col-xs-12 no-padding img-responsive" src="<?php echo Yii::app()->createUrl('/'.$element["profilBanniereUrl"]) ?>">
		<?php } ?>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 contentHeaderInformation">	
    	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-white pull-right">
    		
    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding margin-bottom-10">
				<?php if(@Yii::app()->session["userId"]){ ?>
				<div class="btn-group pull-left padding-top-5">
				    <?php $this->renderPartial('../element/linksMenu', 
		        			array("linksBtn"=>$linksBtn,
		        					"elementId"=>(string)$element["_id"],
		        					"elementType"=>$type,
		        					"elementName"=> $element["name"],
		        					"openEdition" => $openEdition) 
		        			); 
		        	?>
				</div>
				<?php } ?>
			</div>

			<h4 class="text-left padding-left-15 pull-left no-margin" id="main-name-element">
				<span id="nameHeader">
					<div class="pastille-type-element bg-<?php echo $iconColor; ?> pull-left">
						<!--<i class="fa fa-<?php echo $icon; ?>"></i>--> 
					</div>
					<div class="name-header pull-left"><?php echo @$element["name"]; ?></div>
				</span>	
			</h4>					
		</div>

		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 pull-right">
			<span class="pull-left text-white" id="shortDescriptionHeader">
				<?php echo ucfirst(substr(trim(@$element["shortDescription"]), 0, 180)); ?>
			</span>	
		</div>
		<div class="pull-right col-sm-3 col-md-3" style=""></div>		
	</div>
</div>



<div id="uploadScropResizeAndSaveImage" style="display:none;padding:0px 60px;">
	<!--<img src='' id="previewBanniere"/>-->
	<div class="close-modal" data-dismiss="modal"><div class="lr"><div class="rl"></div></div></div>
		<div class="col-lg-12">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/CO2r.png" class="inline margin-top-25 margin-bottom-5" height="50">
	        <br>
		</div>
		<div class="modal-header text-dark">
			<h3 class="modal-title text-center" id="ajax-modal-modal-title"><i class="fa fa-crop"></i> <?php echo Yii::t("common","Resize and crop your image to render a beautiful banniere") ?></h3>
		</div>
		<div class="panel-body">
			<div class='col-md-offset-1' id='cropContainer'>
				<img src='' id='cropImage' class='' style=''/>
				<div class='col-md-12'>
					<input type='submit' class='btn btn-success text-white imageCrop saveBanniere'/>
				</div>
			</div>
		</div>
	</div>


<script>
jQuery(document).ready(function() {

	//IMAGE CHANGE//
	$("#uploadScropResizeAndSaveImage .close-modal").click(function(){
		$.unblockUI();
	});


	$("#banniere_element").click(function(event){
			if (!$(event.target).is('input')) {
					$(this).find("input[name='banniere']").trigger('click');
			}
		//$('#'+contentId+'_avatar').trigger("click");		
	});
	
	$('#banniere_change').off().on('change.bs.fileinput', function () {
		setTimeout(function(){
			var files = document.getElementById("banniere_change").files;
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
   							if(imgWidth>=1000 && imgHeight>=500){
               					$.blockUI({ 
               						message: $('div#uploadScropResizeAndSaveImage'), 
               						css: {cursor:null,padding: '0px !important'}
               					}); 
               					$("#uploadScropResizeAndSaveImage").parent().css("padding-top", "0px !important");
								//$("#uploadScropResizeAndSaveImage").html(html);
								setTimeout(function(){
									var crop = $('#cropImage').cropbox({width: 1300,
										height: 400,
										zoomIn:true,
										zoomOut:true}, function() {
											cropResult=this.result;
											console.log(cropResult);
									}).on('cropbox', function(e, crop) {
										cropResult=crop;
						        		console.log('crop window: ', crop);
						        
									});
									$(".saveBanniere").click(function(){
								        //console.log(cropResult);
								        //var cropResult=cropResult;
								        $("#banniere_photoAdd").submit();
									});
									$("#banniere_photoAdd").off().on('submit',(function(e) {
										//alert(moduleId);
										if(debug)mylog.log("id2", contextData.id);
										$(".banniere_isSubmit").val("true");
										e.preventDefault();
										console.log(cropResult);
										var fd = new FormData(document.getElementById("banniere_photoAdd"));
										fd.append("parentId", contextData.id);
										fd.append("parentType", contextData.type);
										fd.append("formOrigin", "banniere");
										fd.append("contentKey", "banniere");
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
											url : baseUrl+"/"+moduleId+"/document/uploadSave/dir/"+moduleId+"/folder/"+contextData.type+"/ownerId/"+contextData.id+"/input/banniere",
											type: "POST",
											data: fd,
											contentType: false,
											cache: false, 
											processData: false,
											dataType: "json",
											success: function(data){
										        if(data.result){
										        	newBanniere='<img class="col-md-12 col-sm-12 col-xs-12 no-padding img-responsive" src="'+baseUrl+data.src+'" style="">';
										        	$("#contentBanniere").html(newBanniere);
										        	$.unblockUI();
										        	//$("#uploadScropResizeAndSaveImage").hide();
										    	}
										    }
										});
									}));
								}, 300);
							}
   						 	else
   						 		toastr.warning("Please choose an image with a minimun of size: 1000x450 (widthxheight)");
							};
			        });
			        reader.readAsDataURL(file);
			    }  
			}
		}, 400);
	});
});
</script>