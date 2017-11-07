<?php
HtmlHelper::registerCssAndScriptsFiles( 
	array(  	
		'/js/comments.js',
	) , 
	Yii::app()->theme->baseUrl. '/assets');
$cssAnsScriptFilesTheme = array(
	'/plugins/jquery-bar-rating/jquery.barrating.js',
	'/plugins/font-awesome/css/font-awesome.min.css',
	'/plugins/jquery-bar-rating/fontawesome-stars.css',
	'/plugins/jquery-bar-rating/fontawesome-stars-o.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

?>
<style type="text/css">
	.modal-content .headerTitleStanalone{
		left:-25px;
		right:-25px;
		top:0px !important;
	}
	.modal-content .contentOnePage{
		margin-top: 55px !important;
		min-height: 500px;
	}
	.contentOnePage .title > h2{
		padding: 15px 0px;
    	text-transform: inherit;
    	font-size: 20px;
    	margin-top:100px;
	}
	/*.carousel-media > ol > li.active{
	   margin:1px;
	   border-top: 5px solid #EF5B34 !important;
	}
	.carousel-media > ol > li{
		    width: 60px !important;
    background-color: inherit;
    border: inherit !important;
    height: 65px !important;
    border-radius: inherit;
    border-top: 5px solid lightgray !important;
	}
	
	.carousel-media > ol > li > img{
	   float:left;
	   width:60px;
	   height:60px;
	}
	.carousel-media > ol{
		bottom: -85px
	}
	.carousel-media{
		margin-bottom: 100px;
	}*/
	.informations .btn-social{
		padding: 0px;
	    height: inherit;
	    width: 45px;
	    height:45px;
	    border-radius: 8px;
	}
	.informations .btn-social > span{
		/*position: absolute;*/
    	font-size: 20px;
	}

	.carousel-media .carousel-inner {
	    max-width: 900px;
	    max-height: 900px;
	    margin-left: auto;
	    margin-right: auto;
	}

	.btn-linkedin{
		background-color: #517dae;
		color:white;
	}
	.btn-facebook{
		background-color: #506eae;
		color:white;
	}
	.btn-twitter{
		background-color: #6fbee9;
		color:white;
	}
	.btn-google{
		background-color: #e24d47;
		color:white;
	}

	.associated{
		padding: 0px 50px 50px 50px;
	}

	.associated .entity{
		margin-bottom:50px;
	}

</style>

<header>
<div class="container">
    <div class="headerTitle"> <?php echo ucfirst($element["parent"]["name"]) ?></div>
</div>
</header>

<div class="col-xs-12 col-md-10 col-md-offset-1 contentOnePage margin-bottom-50">
	<div class="col-md-12 title letter-lightgray text-left"><h2><?php echo ucfirst($element["name"]) ?></h2></div>
	<?php 
	$images=Document::getListDocumentsWhere(array("id"=>(string)$element["_id"],"type"=>$type,"doctype"=>Document::DOC_TYPE_IMAGE),Document::DOC_TYPE_IMAGE);
	$this->renderPartial('../pod/sliderMedia', 
								array(
									  "medias"=>@$element["medias"],
									  "images" => @$images,
									  ) ); 
									  ?>



	<div class="col-md-12 margin-bottom-20">
	<hr>
	</div>

	<div class="informations col-md-12 margin-bottom-20">
		<div class="header-info col-md-12 no-padding text-left">
			<div class="letter-lightgray col-md-6 no-margin text-left"><h5><?php echo Yii::t("terla", "PROJECT DESCRIPTION"); ?>
				<span class="evalutation">
					<?php if(@$element["averageRating"]){ ?>
						<div class="br-wrapper br-theme-fontawesome-stars-o pull-left margin-left-10">
							<select id="ratingElement" class="ratingComments">
							    <option value="1">1</option>
			                    <option value="2">2</option>
			                    <option value="3">3</option>
			                    <option value="4">4</option>
			                    <option value="5">5</option>
		                  	</select>
		                </div>
		                <span><?php echo $element["averageRating"] ?></span>
					<?php }else{ ?>
						<small class="letter-lightgray"><?php echo Yii::t("terla", "No evaluation"); ?></small>
					<?php } ?>
				</span></h5>
			</div>
			
			<div class="col-md-6">
				<a target="_blank" href="" class="btn btn-linkedin btn-social pull-right">
					<span class="fa fa-linkedin"></span>
				</a>
				<a target="_blank" href="" class="btn btn-google btn-social pull-right">
					<span class="fa fa-google-plus"></span>
				</a>
				<a target="_blank" href="" class="btn btn-twitter btn-social pull-right">
					<span class="fa fa-twitter"></span>
				</a>
				<a target="_blank" href="" class="btn btn-facebook btn-social pull-right">
					<span class="fa fa-facebook"></span>
				</a>
				
				<h4 class="pull-right letter-lightgray margin-15" style=""><?php echo Yii::t("terla", "SHARE"); ?></h4>
			</div>
			<div class="col-md-8 description text-left margin-top-20">
				<span class="letter-lightgray">
					<?php echo nl2br(@$element["description"]); ?>
					<!-- Vestibulum eu lobortis orci. Donec aliquet finibus augue, at tempus dui rutrum in. Proin pellentesque felis ligula, ac congue ante hendrerit tempor. Duis lobortis, quam at porta tincidunt, enim felis tincidunt nisi, sed ornare dui neque non nunc. Quisque pellentesque at ex a volutpat.
					<br><br>
					Suspendisse feugiat dui magna, vel molestie mauris porttitor quis. Vivamus et pulvinar mi, vel dictum mauris. Donec sapien sem, gravida eu arcu sit amet, ullamcorper faucibus tellus. Duis non odio non nisi laoreet egestas vel sed tortor. Nullam lectus orci, hendrerit eget malesuada fermentum, blandit quis nunc. Quisque laoreet aliquam nisi eget aliquam. Nulla sapien enim, gravida in ex eu, ultricies commodo ipsum. Donec orci libero, dictum vel enim ut, auctor interdum mauris. -->
				</span>
			</div>
			<div class="col-md-3 pull-right padding-20 margin-top-20">
				<?php if($type==Service::COLLECTION){ ?>
					<a href="javascript:;" class="col-md-12 btn bg-orange ssmla btn-available-calendar pull-right" 
						data-toggle="modal" 
						data-target="#modal-available">
								Book it
					</a>
				<?php } else { ?>
					<a href="javascript:;" class="btn bg-orange" onclick="addToShoppingCart('<?php echo (string)$element["_id"] ?>','<?php echo $type ?>');">Buy it</a>
				<?php } ?>
			</div>
		</div>
		<div id="commentElement" class="col-xs-12 margin-top-20">
		</div>
	</div>

	<?php 
		if($type==Service::COLLECTION)
			$this->renderPartial('../pod/availableCalendar',
					array(	"type"=>$type, 
							"parentId" => (string)$element['_id'], 
							"element" => @$element));
	?>

</div>



<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    $this->renderPartial('../element/terla/associated', array()); 
    $this->renderPartial($layoutPath.'footer', array("subdomain"=>"page")); 
?>

<script type="text/javascript">

	var element=<?php echo json_encode($element); ?>;
	element.imgProfil = "<i class='fa fa-image fa-3x'></i>";
   	if("undefined" != typeof element.profilMediumImageUrl && element.profilMediumImageUrl != "")
        element.imgProfil= "<img class='img-responsive' src='"+baseUrl+element.profilMediumImageUrl+"'/>";
	var type="<?php echo $type; ?>";
	jQuery(document).ready(function() {	
		var nav = directory.findNextPrev("#page.type."+type+".id."+element['_id']['$id']);
        str =  "<div class='col-md-6 no-padding'>"+ 
		        	nav.prev+
		        	"<span>"+element.name+"</span>"+
		       		nav.next+
      			"</div>";
     	$(".modal-content .headerTitleStanalone").html(str);
      	initBtnLink();
      	ajaxPost("#commentElement",baseUrl+"/"+moduleId+"/comment/index/type/"+type+"/id/"+element['_id']['$id'],
			{"filters": ["rating"]},
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
				$(".container-txtarea").hide();

				$(".btn-select-arg-comment").click(function(){
					var argval = $(this).data("argval");
					$(".container-txtarea").hide();
				});

		},"html");
		element["id"] = element['_id']['$id'];
		if(typeof element.averageRating != "undefined"){
			$("#ratingElement").barrating({
				theme: 'fontawesome-stars-o',
				'readonly': true,
				initialRating: element.averageRating
			});
		}
		$(".btn-available-calendar").click(function(){
      		setTimeout(function(){
 		 		$('#calendar').fullCalendar('gotoDate', new Date());
 		 		setCategoryColor();
 			}, 300);
      		//$('#calendar').fullCalendar('gotoDate', new Date());
      	});
	});
	
	
</script>