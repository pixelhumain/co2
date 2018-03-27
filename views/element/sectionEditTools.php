

    <style>
    	#onepage-edition-tools input{
    		/*display: none;*/
    	}
    	#onepage-edition-tools hr{
    		float: left;
			width: 100%;
    	}

    	#onepage-edition-tools #static-head-tools{
    		position: fixed;
    		top:0px;
    		margin-left:-15px;
    		margin-right: -15px;
    		margin-bottom: 10px;
    		padding:80px 15px 10px 15px !important;
    		width:39%;
    		z-index:5;
    		background-color: white;
    		-webkit-box-shadow: -2px 0px 5px -1px rgba(0,0,0,0.5);
			-moz-box-shadow: -2px 0px 5px -1px rgba(0,0,0,0.5);
			box-shadow: -2px 0px 5px -1px rgba(0,0,0,0.5);
    	}
    	.edit-section-title{
    		font-size: 20px;
    		text-transform: uppercase;
    		margin-top: 55px !important;
    		font-weight: 800;
    		border: none;
    	}

    	.btn-edit-section,
    	.btn-show-section,
    	.btn-hide-section,
    	.btn-delete-free-section{
    		margin-top:-25px;
    	}
    	#onepage-edition-tools{
    		width:40%;
    		position: fixed;
    		top:0px;
    		right: 0px;
    		height:100%;
    		max-height: 100%;
			overflow-y: auto;
    		background-color:white;
    		z-index:3;
    		padding:85px 15px 10px 15px;
    		display:none;
    	}

    	#btn-bgcolor-section,
    	#btn-bgcolor-section,
    	#btn-txtcolor-section{
    		width:50px;
    		height:50px;
    		border: 1px solid lightgrey!important;
    	}
    	.btn-bgcolor-section.bg-white,
    	.btn-bgimg-section.bg-white,
    	.btn-txtcolor-section.bg-white{
    		border: 3px solid lightgrey;
    	}
    	.btn-bgcolor-section,
    	.btn-bgimg-section,
    	.btn-txtcolor-section{
    		height:40px;
    		border-radius:0px; 
    		border: 3px solid transparent;
    	}
    	.btn-bgimg-section{
    		height:100px;
    		overflow: hidden;
    		border:3px solid white;
    	}
    	.btn-bgcolor-section.active,
    	.btn-bgimg-section.active,
    	.btn-txtcolor-section.active{
    		border: 3px solid black;
    	}
    </style>

    <?php 
    	$colors = array(
    				"ed5564", "d9434e", 
    				"ed5f55", "d94c43", 
    				"f87f52", "e7663f", 
    				"fab153", "f49a42",

    				"fcce54", "f5ba42", 
    				"c2d468", "b0c151", 
    				"98d367", "82c250", 
    				"42cb6f", "3bb85d",

    				"47cec0", "3bbeb0",
    				"4ec2e7", "3bb1d9",
    				"5c9ded", "4a8bdb",
    				"9398ec", "7277d5",
    				
    				"cb93ec", "b377d9",
    				"ec87bf", "d870ad",
    				"f1f2f6", "e2e3e7",
    				"c7cbd4", "a5adb8",
    			);

    ?>

    <div class="hidden-xs shadow-left" id="onepage-edition-tools">

    	<div class="col-md-12 col-sm-12 no-padding" id="static-head-tools">
	    	<h5 class="pull-left"><i class="fa fa-angle-down"></i> <i class="fa fa-cogs"></i> Editer la section</h5>
	    	<button class="btn btn-danger pull-right margin-left-5 btn-close-edition-tools"><i class="fa fa-times"></i></button>
	    	<button class="btn btn-success pull-right btn-save-edition-tools"><i class="fa fa-save"></i> Enregistrer</button>
	    </div>

    	<div class="col-md-12 col-sm-12 no-padding margin-bottom-10">
    		<i class="fa fa-pencil letter-blue"></i> <input type="text" class="margin-top-5 edit-section-title font-montserrat">
			<hr class="margin-bottom-5 margin-top-5">
		</div>

	    <div class="col-md-12 col-sm-12 no-padding">
	    	<div class="col-md-12 col-sm-12 no-padding">
		    	<button class="btn btn-default padding-20 pull-left" id="btn-txtcolor-section"></button> 
		    	<h4 class="pull-left margin-left-10"><i class="fa fa-angle-down"></i> Couleur du text</h4>
		    	<div class="col-md-12 col-sm-12 no-padding margin-top-15">
		   			<button class="btn btn-default padding-20 btn-txtcolor-section bg-white col-md-6 col-sm-6 bg-white" data-type="light"></button>
		    		<button class="btn btn-default padding-20 btn-txtcolor-section bg-dark col-md-6 col-sm-6" data-type="dark"></button>

	    			<input type="text" id="text-color" class="pull-right margin-top-10">
		    	</div>
		    </div>
		    <br><hr>
	    </div>	

	    <div class="col-md-12 col-sm-12 no-padding margin-top-15">
		    <div class="col-md-12 col-sm-12 no-padding">
		    	<button class="btn btn-default padding-20 pull-left" id="btn-bgcolor-section"></button> 
		    	<h4 class="pull-left margin-left-10"><i class="fa fa-angle-down"></i> Couleur de fond</h4>
		    	<button class="btn btn-default padding-20 btn-bgcolor-section bg-white pull-right bg-white" data-hex="FFF"></button>
		    	<button class="btn btn-default padding-20 btn-bgcolor-section bg-dark  pull-right" data-hex="333"></button>
		    </div>	
		    <div class="col-md-12 col-sm-12 no-padding margin-top-10">
		   		<?php $class="left";
		    		  foreach ($colors as $i => $hex) {
		    	?>
		    		<?php if($i%2!=1 && $i>0) echo "</div>"; ?>
		    		<?php if($i%2!=1) echo "<div class='col-md-3 col-sm-3 no-padding'>"; ?>
		    			<button class="btn btn-default padding-20 btn-bgcolor-section col-md-6 col-sm-6 no-padding" 
		    					data-hex="<?php echo $hex; ?>" 
		    					style="background-color:#<?php echo $hex; ?>;">
		    			</button>
		    		
		    	<?php } ?>

	    		<input type="text" id="background-color" class="pull-right margin-top-10">
	    	</div>

	    	<br><hr>
	    </div>

	    <?php 
	    	$imgSections = array(array("title"=>"Minimal",
	    							   "folder"=>"white",
	    							   "repeat"=>false),

	    						array("title"=>"Abstraits",
	    							   "folder"=>"abstract",
	    							   "repeat"=>false),

	    						array("title"=>"Texture",
	    							   "folder"=>"pattern",
	    							   "repeat"=>true),
	    						);
	    ?>
	    
	    <div class="col-md-12 col-sm-12 no-padding margin-top-15">
		    <div class="col-md-12 col-sm-12 no-padding">
		    	<h4 class="pull-left margin-left-10"><i class="fa fa-angle-down"></i> Image de fond</h4>
		    </div>	
		    <?php foreach ($imgSections as $i => $sec) { ?>	    
			    <div class="col-md-12 col-sm-12 no-padding margin-top-10">
			    	<h5><?php echo $sec["title"]; ?></h5>
				   	<?php 
				   		$path = $sec["folder"]."/";
				   		$path = ".".substr(Yii::app()->theme->baseUrl.'/assets/img/background-onepage/'.$path, 3);
				   		if(file_exists ( $path )){
				          $files = glob($path.'*.{jpg,jpeg,png}', GLOB_BRACE);
				        }
				    ?>
			    	<?php
			    		 if(isset($files))
			    		 foreach ($files as $i => $img) { 
			    		 $dataUrl = explode( "/", $img); //var_dump($dataUrl);
			    		 $dataUrl = $dataUrl[6] . "/" . $dataUrl[7];
			    		 //var_dump($dataUrl);
			    	?>
			    			<button class="btn btn-default col-md-4 col-sm-4 btn-bgimg-section padding-5"
			    			data-repeat="<?php echo $sec["repeat"] ? "true" : "false"; ?>"
			    			data-url="<?php echo $dataUrl; ?>"
	    					style="background-image:url('<?php echo $img; ?>'); 
	    					 <?php if($sec["repeat"]) echo "background-repeat:repeat;"; 
	    					 	   else echo "background-size: cover;"; 
	    					 ?>"
			    					>
			    			</button>
			    	<?php } ?>
		    	</div>
			<?php } ?>
	    	<input type="text" id="background-img" class="pull-right margin-top-10">
	    	<br><hr>
	    </div>

	    
    </div>

<div class="scroll-top page-scroll">
    <a class="btn btn-primary" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>
</div>

    <script type="text/javascript" >
    var typeEl = "<?php echo $type; ?>";
    var idEl = "<?php echo $id; ?>";
    var currentIdSection = "";
    var onepageEdition = <?php echo @$element["onepageEdition"] ? json_encode(@$element["onepageEdition"]) : "{}" ?>;
    var urlImgBg = "<?php echo substr(Yii::app()->theme->baseUrl.'/assets/img/background-onepage/', 3); ?>";

	jQuery(document).ready(function() { 

		initOnepage(onepageEdition);

		$(".btn-save-edition-tools").click(function(){
			
			onepageEdition[currentIdSection]["text-color"] = $("#text-color").val();
			onepageEdition[currentIdSection]["background-color"] = $("#background-color").val();
			onepageEdition[currentIdSection]["background-img"] = $("#background-img").val();
			onepageEdition[currentIdSection]["title"] = $(".edit-section-title").val();

			//console.log("on save onepageEdition", onepageEdition);
			var idSection = currentIdSection.substr(1, currentIdSection.length);
			//console.log("idSection", idSection);
			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);

			hideEditionTools(false);
		});

		$(".btn-close-edition-tools").click(function(){
			hideEditionTools(true);
		});

		$(".btn-edit-section").click(function(){ 
			var key = $(this).data("id");
			showEditionTools(key);
		});

		$(".btn-hide-section").click(function(){ 
			var key = $(this).data("id");
			onepageEdition[key]["hidden"] = true;

			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
			
			$("section"+key+" .btn-hide-section").addClass("active");
			$("section"+key+" .btn-show-section").removeClass("active");

			$("section"+key+" .badge-info-section").html(
				'<small class="badge letter-blue bg-white margin-right-15">'+
        			'<i class="fa fa-ban"></i> '+
        			'Cette section n\'est pas visible pour les visiteurs de votre page'+
   				'</small>');
		});

		$(".btn-show-section").click(function(){ 
			var key = $(this).data("id");
			onepageEdition[key]["hidden"] = false;

			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
			
			$("section"+key+" .btn-show-section").addClass("active");
			$("section"+key+" .btn-hide-section").removeClass("active");

			$("section"+key+" .badge-info-section").html("");
		});



		$(".edit-section-title").keyup(function(){
			var newTitle = $(".edit-section-title").val();
			console.log("onchange title section", newTitle, "changing value", "section"+currentIdSection+" .sec-title");
			$("section"+currentIdSection+" .sec-title").html(newTitle);
		})


		/* COLOR PICKER */

		/* BGCOLOR PICKER */
		$('#onepage-edition-tools .btn-bgcolor-section').click(function(){
			$('#onepage-edition-tools .btn-bgcolor-section').removeClass("active");
			$(this).addClass("active");
				var hex = $(this).data("hex");
				$("input#background-color").val("#"+hex);
				$("input#background-img").val("");
				$("#onepage-edition-tools #btn-bgcolor-section").css("backgroundColor", "#"+hex);

				$("section"+currentIdSection).css("backgroundImage", 'url()');
				$("section"+currentIdSection).css("backgroundColor", "#"+hex);
		});

		$('#onepage-edition-tools #btn-bgcolor-section').off().ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).ColorPickerHide();
				console.log("onSubmit colorpicker");
			},
			onChange: function(hsb, hex, rgb, el) {
				$("input#background-img").val("");
				$("input#background-color").val("#"+hex);
				$("#onepage-edition-tools #btn-bgcolor-section").css("backgroundColor", "#"+hex);
				$("section"+currentIdSection).css("backgroundColor", "#"+hex);
				$('#onepage-edition-tools .btn-bgcolor-section').removeClass("active");
			},
			onBeforeShow: function () {
				var rgb = $(this).css("backgroundColor");
				var color = rgbToHex(rgb)
				$(this).ColorPickerSetColor(color);
				$("section"+currentIdSection).css("background", 'url("")!important');
				
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
				console.log("keyup colorpicker");
		});
		/* BGCOLOR PICKER */


		/* TXTCOLOR PICKER */
		$('#onepage-edition-tools .btn-txtcolor-section').click(function(){
			$('#onepage-edition-tools .btn-txtcolor-section').removeClass("active");
			$(this).addClass("active");
			var type = $(this).data("type");
			$("input#text-color").val(type);
			$("section"+currentIdSection).removeClass('dark').removeClass('light').addClass(type);
			unsetTxtColorSection();

			$("#onepage-edition-tools #btn-txtcolor-section").css("backgroundColor", $(this).css("backgroundColor"));
		});

		$('#onepage-edition-tools #btn-txtcolor-section').off().ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				//$(el).val(hex);
				//$(el).ColorPickerHide();
				//console.log("onSubmit colorpicker");
			},
			onChange: function(hsb, hex, rgb, el) {
				$("input#text-color").val("#"+hex);
				$("#onepage-edition-tools #btn-txtcolor-section").css("backgroundColor", "#"+hex);

				setTxtColorSection(hex);

				$('#onepage-edition-tools .btn-txtcolor-section').removeClass("active");
			},
			onBeforeShow: function () {
				var rgb = $(this).css("backgroundColor");
				var color = rgbToHex(rgb);
				$(this).ColorPickerSetColor(color);
				console.log("onBeforeShow colorpicker", color);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
				console.log("keyup colorpicker");
		});
		/* TXTCOLOR PICKER */

		/* BGIMG PICKER */
		$('#onepage-edition-tools .btn-bgimg-section').click(function(){
			$('#onepage-edition-tools .btn-bgimg-section').removeClass("active");
			$(this).addClass("active");
			//var type = $(this).data("type");
			//$("input#text-color").val(type);
			
			var url = urlImgBg+$(this).data("url");
			var repeat = $(this).data("repeat");

			console.log("repeat", repeat);

			$("section"+currentIdSection).css('backgroundImage', "url('"+url+"')");

			if(repeat==true){
				$("section"+currentIdSection).css('backgroundRepeat', "repeat");
				$("section"+currentIdSection).css('backgroundSize', "unset");	
			} 
			else {
			 	$("section"+currentIdSection).css('backgroundRepeat', "no-repeat");
				$("section"+currentIdSection).css('backgroundSize', "cover");	
			}

			$("#background-color").val("");
			$("#background-img").val($(this).data("url"));
		});
		/* BGIMG PICKER */
		
		$('.edit-section-title').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'}); //[a-zA-Z0-9_] 
		

		/*FREE SECTION*/
		$(".btn-create-section").click(function(){
			var section = $(this).data("section-before");

			var num = 1; var tmpNum = 1;
			$.each($(".free-section"), function(){ 
				var tmpNum = $(this).attr("id");
				tmpNum = parseInt(tmpNum.substr(tmpNum.length-1, 1));
				if(tmpNum > num) num = tmpNum +1;
			});
			$("#btn-save-new-section-"+section).data("new-section-key", "free-section-"+num); 
			$("#btn-save-new-section-"+section).attr("data-new-section-key", "free-section-"+num); 
			
			$(".new-section-before-"+section).show(200);
		});
		$(".btn-cancel-new-section").click(function(){
			var section = $(this).data("section-before");
			$(".new-section-before-"+section).hide(200);
		});
		$(".btn-save-new-section").click(function(){
			var beforeSection = $(this).data("section-before");
			var newSectionKey = $(this).data("new-section-key");
			saveNewsSection(beforeSection, newSectionKey);
			$(".new-section-before-"+beforeSection).hide(200);
		});
		$(".btn-delete-free-section").click(function(){
			var sectionKey = $(this).data("section-key");
			$("#popup-conf-delete-section-"+sectionKey).show(200);
		});
		$(".btn-conf-delete-free-section").click(function(){
			var sectionKey = $(this).data("section-key");
			deleteFreeSection(sectionKey);
			$("section#"+sectionKey).hide(200);
		});
		$(".btn-cancel-delete-free-section").click(function(){
			var sectionKey = $(this).data("section-key");
			console.log(".btn-cancel-delete-free-section", sectionKey, "#popup-conf-delete-section-"+sectionKey);
			$("#popup-conf-delete-section-"+sectionKey).hide(200);
		});
		$(".btn-edit-item").click(function(){
			var sectionKey = $(this).data("section-key");
			var itemKey = $(this).data("item-key");
			startUpdateFreeItem(sectionKey, itemKey);
		});
		$(".btn-delete-item").click(function(){
			var sectionKey = $(this).data("section-key");
			var itemKey = $(this).data("item-key");
			console.log("start delete item", "#popup-conf-delete-item-"+sectionKey+"-"+itemKey);
			$("#popup-conf-delete-item-"+sectionKey+"-"+itemKey).show(200);
		});
		$(".btn-cancel-delete-item").click(function(){
			var sectionKey = $(this).data("section-key");
			var itemKey = $(this).data("item-key");
			$("#popup-conf-delete-item-"+sectionKey+"-"+itemKey).hide(200);
		});
		$(".btn-conf-delete-item").click(function(){
			var sectionKey = "#"+$(this).data("section-key");
			var itemKey = $(this).data("item-key");
			var newOnepageEdition = new Array();
			$.each(onepageEdition[sectionKey]["items"], function(key, val){
				if(key != itemKey) newOnepageEdition.push(val);
			});
			onepageEdition[sectionKey]["items"] = newOnepageEdition;
			console.log("save delete item ?", onepageEdition);
			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
			urlCtrl.loadByHash(location.hash);
		});
		$(".btn-create-item").click(function(){
			var sectionKey = $(this).data("section-key");
			startCreateFreeItem(sectionKey)
		});
		$(".btn-save-item").click(function(){
			var sectionKey = "#"+$(this).data("section-key");
			var itemKey = $(this).data("item-key");
			var newOnepageEdition = new Array();
			$.each(onepageEdition[sectionKey]["items"], function(key, val){
				if(key != itemKey) newOnepageEdition.push(val);
			});
			onepageEdition[sectionKey]["items"] = newOnepageEdition;
			console.log("save delete item ?", onepageEdition);
			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
			urlCtrl.loadByHash(location.hash);
		});


		/* SELECT IMAGE */

		$(".btn-open-modal-select-img").click(function(){
			var beforeSection = $(this).data("section-before");
			$(".btn-select-img-new-section").removeClass("selected");
			$(".modal .btn-select-img-new-section").data("section-before", beforeSection);
			$(".modal .btn-select-img-new-section").data("edit-mode", "createSection");
		});

		//in modalSelectImage
		$(".btn-select-img-new-section").click(function(){
			$(".btn-select-img-new-section").removeClass("selected");
			$(this).addClass("selected");
			var imgPath = $(this).data("img-path");
			var beforeSection = $(this).data("section-before");
			var itemKey = $(this).data("item-key");
			console.log("select img", beforeSection, "edit-mode", $(this).data("edit-mode"));
			
			if($(this).data("edit-mode") == "update"){
				$("section#"+beforeSection + " .portfolio-item.item-"+itemKey+" input.img-path-new-sec").val(imgPath);
				$("section#"+beforeSection + " .portfolio-item.item-"+itemKey+" .img-section").attr("src", imgPath);
			}else if($(this).data("edit-mode") == "createItem"){
				$("section#"+beforeSection + " .ctn-tool-create-item input.img-path-new-sec").val(imgPath);
				$("section#"+beforeSection + " .ctn-tool-create-item .preview-img").html(
					"<img height=100 src='"+imgPath+"'>");
			}else if($(this).data("edit-mode") == "createSection"){
				$(".new-section-before-"+beforeSection + " input.img-path-new-sec").val(imgPath);
				$(".new-section-before-"+beforeSection + " .preview-img").html(
					"<img height=100 src='"+imgPath+"'>");
			}

			$(".new-section-before-"+beforeSection + " .btn-open-modal-select-gallery").hide(200);
			$(".new-section-before-"+beforeSection + " .btn-cancel-image").show(200);
		});

		$("#modalSelectImgNewSection #btn-cancel, .btn-cancel-image").click(function(){
			$("#modalSelectImgNewSection .btn-select-img-new-section").removeClass("selected");
			$("input.img-path-new-sec").val("");
			$(".preview-img").html("");
			$(".btn-open-modal-select-gallery").show(200);
			$(".btn-cancel-image").hide(200);
		});

		/* SELECT GALLERY */
		$(".btn-open-modal-select-gallery").click(function(){
			var beforeSection = $(this).data("section-before");
			$("#modalSelectGalleryNewSection .btn-select-gallery").data("section-before", beforeSection);
		});
		$("#modalSelectGalleryNewSection #btn-cancel, .btn-cancel-gallery").click(function(){
			$("#modalSelectGalleryNewSection .ctn-gallery").removeClass("selected");
			$("input.gallery-new-sec").val("");
			$(".preview-img").html("");
			$(".btn-open-modal-select-img").show(200);
			$(".btn-cancel-gallery").hide(200);
		});

		$("#modalSelectGalleryNewSection .btn-select-gallery").click(function(){
			var id = $(this).data("id-ctn");
			var beforeSection = $(this).data("section-before");
			var name = $(this).data("gallery-name");
			$(".new-section-before-"+beforeSection + " input.gallery-new-sec").val(name);
			$("#modalSelectGalleryNewSection .ctn-gallery").removeClass("selected");
			$("#modalSelectGalleryNewSection .ctn-gallery#"+id).addClass("selected");

			var galleryContent = "<div class='gallery-selected'>" + 
									$("#modalSelectGalleryNewSection .ctn-gallery#"+id).html() + 
								 "</div>";

			$(".new-section-before-"+beforeSection + " .preview-img").html(galleryContent);
			

			$(".new-section-before-"+beforeSection + " .btn-cancel-gallery").show(200);
			$(".new-section-before-"+beforeSection + " .btn-open-modal-select-img").hide(200);
			$(".new-section-before-"+beforeSection + " input.img-path-new-sec").val("");
		});


		/*CREATE NEW SECTION*/
		
	});

	function saveNewsSection(beforeSection, newSectionKey){
		var title = $(".new-section-before-"+beforeSection + " .title-new-sec").val();
		var descMD = $(".new-section-before-"+beforeSection + " #MD-desc-new-sec-"+beforeSection).val();
		var imgPath = $(".new-section-before-"+beforeSection + " .img-path-new-sec").val();
		var galleryName = $(".new-section-before-"+beforeSection + " .gallery-new-sec").val();
		console.log("saveNewsSection", beforeSection, newSectionKey, title, descMD);

		onepageEdition["#"+newSectionKey] = {	"title" : title,
												"beforeSection" : "#"+beforeSection,
												"items" : [
												 	{ "imgPath" : imgPath,
												 	  "galleryName" : galleryName,
													  "shortDescription" : descMD,
												 	  "useMarkdown" : true }
												 ] };

		if(galleryName != ""){
			onepageEdition["#"+newSectionKey]["isGallery"] = true; 
		} 
		console.log("on save new section" ,"onepageEdition :", onepageEdition);
		updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
		urlCtrl.loadByHash(location.hash);
	}

	function startCreateFreeItem(sectionKey){ console.log("startCreateFreeItem(",sectionKey,")");
		$("#"+sectionKey + " .ctn-tool-create-item").html(
			'<br><button class="btn btn-link bg-blue-k btn-open-modal-select-img" data-section-before="'+sectionKey+'" '+
                'data-target="#modalSelectImgNewSection" data-toggle="modal">'+
                '<i class="fa fa-picture-o"></i> Joindre une photo'+
            '</button><br><br>'+
            '<input type="hidden" class="img-path-new-sec">' +
            '<span class="preview-img"></span><hr>' +

			"<textarea class='text-dark' id='create-"+sectionKey+"' row='5'></textarea>"+
			"<br>" +
			"<button class='btn btn-link pull-right bg-green-k btn-save-create-MD-item' "+
					 "data-section-key='"+sectionKey+"' >"+
				"<i class='fa fa-save'></i> Enregistrer"+
			"</button> "+
			"<button class='btn btn-link pull-right margin-right-10 bg-red btn-cancel-create-MD-item' "+
					 "data-section-key='"+sectionKey+"' >"+
				"<i class='fa fa-times'></i> Annuler"+
			"</button><br><hr>"
			);

		$("#"+sectionKey + " .ctn-tool-create-item .btn-open-modal-select-img").click(function(){
			var beforeSection = $(this).data("section-before");
			console.log("init beforeSection", beforeSection);
			$(".modal .btn-select-img-new-section").data("section-before", beforeSection);
			$(".modal .btn-select-img-new-section").data("edit-mode", "createItem");
		});

		dataHelper.activateMarkdown("#create-"+sectionKey);
		

		$(".btn-cancel-create-MD-item").click(function(){
			var sectionKey = $(this).data("section-key");
			$("#"+sectionKey + " .ctn-tool-create-item").html("");
		});

		$(".btn-save-create-MD-item").click(function(){
			console.log(".btn-save-create-MD-item click");
			var sectionKey = $(this).data("section-key");
			var descMD = $("textarea#create-"+sectionKey).val();
			var imgPath = $("section#"+sectionKey + " input.img-path-new-sec").val();

			onepageEdition["#"+sectionKey]["items"].push({"shortDescription" : descMD, 
														  "useMarkdown" : true,
														  "imgPath" : imgPath });

			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
			urlCtrl.loadByHash(location.hash);
		});
	}

	function startUpdateFreeItem(sectionKey, itemKey){ console.log("startUpdateFreeItem(",sectionKey,",", itemKey,")");
		var MDdesc = $("#descriptionMarkdown"+sectionKey+"-"+itemKey).html();
		var sectionData = onepageEdition["#"+sectionKey]["items"][itemKey];
		var isGallery = (typeof sectionData["galleryName"] != "undefined" && sectionData["galleryName"] != "");

		var html = "";
		if(!isGallery)
		html += 
			'<br><button class="btn btn-link bg-blue-k btn-open-modal-select-img" data-section-before="'+sectionKey+'" '+
                'data-target="#modalSelectImgNewSection" data-toggle="modal">'+
                '<i class="fa fa-picture-o"></i> Modifier la photo'+
            '</button> '+
            '<button class="btn btn-link bg-red btn-delete-img-item" data-section-before="'+sectionKey+'"  data-item-key="'+itemKey+'">'+
                '<i class="fa fa-trash"></i> Supprimer la photo'+
            '</button><br><br>'+
            '<input type="hidden" class="img-path-new-sec"><hr>';

         html += 
			"<textarea class='text-dark' id='update-"+sectionKey+"-"+itemKey+"' row='5'>"+MDdesc+"</textarea>"+
			"<br>" +
			"<button class='btn btn-link pull-right bg-green-k btn-save-edit-MD-item' "+
					 "data-section-key='"+sectionKey+"' "+
					 "data-item-key='"+itemKey+"'>"+
				"<i class='fa fa-save'></i> Enregistrer"+
			"</button> "+
			"<button class='btn btn-link pull-right margin-right-10 bg-red btn-cancel-edit-MD-item' "+
					 "data-section-key='"+sectionKey+"' "+
					 "data-item-key='"+itemKey+"'>"+
				"<i class='fa fa-times'></i> Annuler"+
			"</button>";

		$("#"+sectionKey + " .portfolio-item.item-"+itemKey+" .item-desc").html(html);

		$("#"+sectionKey + " .portfolio-item.item-"+itemKey+" .item-desc .btn-open-modal-select-img").click(function(){
			var beforeSection = $(this).data("section-before");
			$(".modal .btn-select-img-new-section").data("section-before", beforeSection);
			$(".modal .btn-select-img-new-section").data("item-key", itemKey);
			$(".modal .btn-select-img-new-section").data("edit-mode", "update");
		});

		$("#"+sectionKey + " .portfolio-item.item-"+itemKey+" .item-desc .btn-delete-img-item").click(function(){
			var beforeSection = $(this).data("section-before");
			var itemKey = $(this).data("item-key");
			onepageEdition["#"+sectionKey]["items"][itemKey]["imgPath"] = "";
			$("#"+sectionKey + " .portfolio-item.item-"+itemKey+" img.img-section").attr("src", "");
		});

		dataHelper.activateMarkdown("#update-"+sectionKey+"-"+itemKey);
		

		$(".btn-cancel-edit-MD-item").click(function(){
			console.log(".btn-cancel-edit-MD-item click");
			var sectionKey = $(this).data("section-key");
			var itemKey = $(this).data("item-key");
			
			initMarkdownDescription();
			
			console.log(".btn-cancel-edit-MD-item", sectionKey, itemKey, 
						"#descriptionMarkdown"+sectionKey+"-"+itemKey, 
						"#"+sectionKey + " .portfolio-item.item-"+itemKey+" .item-desc");
		});

		$(".btn-save-edit-MD-item").click(function(){
			console.log(".btn-cancel-edit-MD-item click");
			var sectionKey = $(this).data("section-key");
			var itemKey = $(this).data("item-key");
			var descMD = $("textarea#update-"+sectionKey+"-"+itemKey).val();
			var imgPath = $("section#"+sectionKey + " input.img-path-new-sec").val();
		
			if(descMD == "") descMD = " ";
			$("#descriptionMarkdown"+sectionKey+"-"+itemKey).html(descMD);
			initMarkdownDescription();
			
			onepageEdition["#"+sectionKey]["items"][itemKey]["shortDescription"] = descMD;

			if(imgPath!="")
			onepageEdition["#"+sectionKey]["items"][itemKey]["imgPath"] = imgPath;

			updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
		});
	}

	function updateFreeItem(sectionKey, itemKey){
		var title = $(".new-section-before-"+sectionKey + " .title-new-sec").val();
		var descMD = $(".new-section-before-"+sectionKey + " #MD-desc-new-sec-"+sectionKey).val();
		console.log("saveNewsSection", sectionKey, newSectionKey, title, descMD);

		onepageEdition["#"+newSectionKey] = {	"title" : title,
												"beforeSection" : "#"+sectionKey,
												"items" : [
												 	{ "shortDescription" : descMD,
												 	  "useMarkdown" : true }
												 ] };

		console.log("on save new section" ,"onepageEdition :", onepageEdition);
		updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
		urlCtrl.loadByHash(location.hash);
	}

	function deleteFreeSection(sectionKey){
		var removeSection = {};
		console.log("try to remove before", onepageEdition);
		//search section with sectionBefore == sectionKey
		//to move theme 
		$.each(onepageEdition, function(key, val){
			if(val["beforeSection"] == sectionKey)
				onepageEdition[key]["beforeSection"] = onepageEdition[sectionKey]["beforeSection"];
		});
		$.each(onepageEdition, function(key, val){
			console.log("key != "+sectionKey, key != sectionKey);
			if(key != sectionKey)
				removeSection[key] = val ;

		});
		onepageEdition = removeSection;
		console.log("try to remove after", removeSection);
		console.log("on save new section" ,"onepageEdition :", onepageEdition);
		updateField(typeEl, idEl, "onepageEdition", onepageEdition, false);
		
		$("section"+sectionKey).remove();
		$(".ctn-new-sec#before-"+sectionKey.substr(1, sectionKey.length)).remove();
	}

	function initOnepage(onepageEdition){


		$.each($(".new-section"), function(){
			var section = $(this).data("section-before");
			dataHelper.activateMarkdown(".new-section #MD-desc-new-sec-"+section);
			console.log("activateMarkdown('.new-section #MD-desc-new-sec'+section);", ".new-section #MD-desc-new-sec"+section);
		});
		//initialise les sections dans la variable
		$.each($("section"), function(){
			var section = "#"+$(this).attr("id");
			console.log("onepageEdition", onepageEdition, section, typeof onepageEdition[section]);
			if(typeof onepageEdition[section] == "undefined")
				onepageEdition[section] = {};
		});

		$.each(onepageEdition, function(section, options){
			console.log("initOnePage", section, options);
			if(typeof options["background-img"] != "undefined" && options["background-img"] != ""){
				$("section"+section).css('backgroundImage', "url('"+urlImgBg+options["background-img"]+"')");
				if(options["background-img"].indexOf("pattern") >= 0){
					console.log("repeat", true),
					$("section"+section).css('backgroundRepeat', "repeat");
					$("section"+section).css('backgroundSize', "unset");	
				} 
				else {
					console.log("repeat", false),
				 	$("section"+section).css('backgroundRepeat', "no-repeat");
					$("section"+section).css('backgroundSize', "cover");	
				}
			}

			if(typeof options["background-color"] != "undefined" && options["background-color"] != "")
				$("section"+section).css("backgroundColor", "#"+options["background-color"]);

			if(typeof options["text-color"] != "undefined" && options["text-color"] != ""){
				if(options["text-color"] == "light" || options["text-color"] == "dark"){
					$("section"+section).removeClass('dark').removeClass('light').addClass(options["text-color"]);
				}else{
					currentIdSection = section;
					setTxtColorSection(options["text-color"]);
				}
			}

			if(typeof options["title"] != "undefined" && options["title"] != ""){
				$("section"+section+" .sec-title").html(options["title"]);
			}

		});
    
	}

	function setTxtColorSection(hex){
		$(	"section"+currentIdSection+ " .item-name, "+
			"section"+currentIdSection+ " .item-date, "+
			"section"+currentIdSection+ " .item-desc, "+
			"section"+currentIdSection+ " .section-title, "+
			"section"+currentIdSection
			).css("color", "#"+hex);
	}
	function unsetTxtColorSection(){
		$(	"section"+currentIdSection+ " .item-name, "+
			"section"+currentIdSection+ " .item-date, "+
			"section"+currentIdSection+ " .item-desc, "+
			"section"+currentIdSection+ " .section-title, "+
			"section"+currentIdSection
			).css("color", "");
	}



	var initBgColor = "";
	var initTxtColor = "";
	var initType = "";
	function showEditionTools(idSection){
		currentIdSection = idSection;
		$("#onepage-edition-tools").show(300);
		var title = $(idSection+" .section-title .sec-title").html();
		if(currentIdSection == "#header") title = "EN-TÊTE";
		$("#onepage-edition-tools .edit-section-title").val(title);
		KScrollTo("section"+idSection);

		var rgb = $("section"+currentIdSection).css("backgroundColor");
		initBgColor = rgbToHex(rgb);
		$("#onepage-edition-tools #btn-bgcolor-section").css("backgroundColor", "#"+initBgColor);
		
		var rgb = $("section"+currentIdSection+ " .item-name").css("color");
		initTxtColor = rgbToHex(rgb);
		$("#onepage-edition-tools #btn-txtcolor-section").css("backgroundColor", "#"+initTxtColor);
				console.log("showEditionTools colorpicker", initTxtColor);

		initType = $("section"+currentIdSection).hasClass("light") ? "light" : "";
		if(initType == "") initType = $("section"+currentIdSection).hasClass("dark") ? "dark" : "";
		//$('#onepage-edition-tools input#background-color').val("#000");
		
		$("#text-color").val(onepageEdition[currentIdSection]["text-color"]);
		$("#background-color").val(onepageEdition[currentIdSection]["background-color"]);
		$("#background-img").val(onepageEdition[currentIdSection]["background-img"]);

		console.log("show section edit ", idSection);
	}

	function  hideEditionTools(cancel){
		$("#onepage-edition-tools").hide(300);

		if(cancel){
			$(	"section"+currentIdSection+ " .item-name, "+
					"section"+currentIdSection+ " .item-desc, "+
					"section"+currentIdSection+ " .section-title"
					).css("color", "#"+initTxtColor);

			$("section"+currentIdSection).css("backgroundColor", "#"+initBgColor);

			$("section"+currentIdSection).removeClass('dark').removeClass('light').addClass(initType);
		}
	}


	function componentFromStr(numStr, percent) {
	    var num = Math.max(0, parseInt(numStr, 10));
	    return percent ?
	        Math.floor(255 * Math.min(100, num) / 100) : Math.min(255, num);
	}

	function rgbToHex(rgb) {
	    var rgbRegex = /^rgb\(\s*(-?\d+)(%?)\s*,\s*(-?\d+)(%?)\s*,\s*(-?\d+)(%?)\s*\)$/;
	    var result, r, g, b, hex = "";
	    if ( (result = rgbRegex.exec(rgb)) ) {
	        r = componentFromStr(result[1], result[2]);
	        g = componentFromStr(result[3], result[4]);
	        b = componentFromStr(result[5], result[6]);

	        hex = (0x1000000 + (r << 16) + (g << 8) + b).toString(16).slice(1);
	    }
	    return hex;
	}

    </script>