
<style type="text/css">
	.headerTitleStanalone{
		left:-25px;
		right:-25px;
	}
	.contentOnePage{
		margin-top: 45px;
	}
	.contentOnePage .title > h2{
		    padding: 15px 0px;
    text-transform: inherit;
    font-size: 20px;
	}
	.carousel-media > ol > li.active{
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
	}
	.informations .btn-social{
		padding: 0px;
	    height: inherit;
	    width: 50px;
	}
	.informations .btn-social > span{
		position: absolute;
    	font-size: 20px;
	}
</style>
<div class="headerTitleStanalone"></div>
<div class="col-md-10 col-md-offset-1 contentOnePage">
	<div class="col-md-12 title text-left"><h2><?php echo ucfirst($element["name"]) ?></h2></div>
	<div id="myCarousel" class="col-md-12 no-padding carousel carousel-media slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">

		    <li data-target="#myCarousel" data-slide-to="0" class="active"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/reunion/reunion4.jpg" alt="Reunion 1"></li>
		    <li data-target="#myCarousel" data-slide-to="1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/reunion/reunion5.jpg" alt="Reunion 1"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">

		    <div class="item active">
		      <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/reunion/reunion4.jpg" alt="Reunion 1">
		      <div class="carousel-caption">
		        <h3>Bienvenu chez l'habitant</h3>
		        <p>L’objectif de ce projet est de promouvoir la culture réunionnaise en passant par des habitant, ou des prestataire à taille humaine, qui ont une légitimité pour la représenter. Des acteurs qui vont garantir la véracité et l’authenticité de notre culture et favoriser son développement. 
				</p>
		      </div>
		    </div>

		    <div class="item">
		      <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/reunion/reunion5.jpg" alt="Reunion 1">
		      <div class="carousel-caption">
		        <h3>Bienvenu chez l'habitant</h3>
		        <p>L’objectif de ce projet est de promouvoir la culture réunionnaise en passant par des habitant, ou des prestataire à taille humaine, qui ont une légitimité pour la représenter. Des acteurs qui vont garantir la véracité et l’authenticité de notre culture et favoriser son développement. 
				</p>
		      </div>
		    </div>

		  </div>
	</div>

	<div class="informations col-md-12 margin-bottom-20">
	<div class="header-info col-md-12 no-padding text-left">
		<h4 class="text-dark col-md-4 no-margin text-left">Project information</h4>
		<div class="evalutation col-md-3">
			<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half"></i>
		</div>
		<div class="col-md-5">
			<h3 class="pull-left no-margin" style="font-size: 20px;">Share</h3>
			<a target="_blank" href="" class="btn btn-facebook btn-social pull-left"><span class="fa fa-facebook"></span></a>
			<a target="_blank" href="" class="btn btn-facebook btn-social pull-left"><span class="fa fa-twitter"></span></a>
			<a target="_blank" href="" class="btn btn-facebook btn-social pull-left"><span class="fa fa-google-plus"></span></a>
			<a target="_blank" href="" class="btn btn-facebook btn-social pull-left"><span class="fa fa-linkedin"></span></a>
		</div>
		<div class="col-md-8 description text-left margin-top-20">
			<span class="">
				jiezjfiz ijezjfzeif ezoijfjiez fjiezfj ezof<br>
				jiezjfiz ijezjfzeif ezoijfjiez fjiezfj ezof hdhuiezu ezhidihueza diuadhezaiud ezaudehzadiuezahd<br>
				jiezjfiz ijezjfzeif ezoijfjiez fjiezfj ezof
			</span>
		</div>
		<div class="col-md-4 padding-20 margin-top-20">
			<a href="javascript:;" class="btn bg-orange" onclick="addToShoppingCart('<?php echo (string)$element["_id"] ?>','<?php echo $element["type"] ?>');">I book</a>
		</div>
	</div>
	<div id="commentElement" class="col-md-12 margin-top-20">
	</div>
</div>
<script type="text/javascript">

	var element=<?php echo json_encode($element); ?>;

	jQuery(document).ready(function() {	
		var nav = directory.findNextPrev("#page.type.classified.id."+element['_id']['$id']);
        //if(typeof params.name != "undefined" && params.name != "")
        str =  "<div class='col-md-6 no-padding'>"+ 
        nav.prev+
        "<span>"+element.name+"</span>"+
        nav.next+
      "</div>";
      $(".headerTitleStanalone").html(str);
      initBtnLink();
      getAjax("#commentElement",baseUrl+"/"+moduleId+"/comment/index/type/"+type+"/id/"+element['_id']['$id'],
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
				$(".container-txtarea").hide();

				$(".btn-select-arg-comment").click(function(){
					var argval = $(this).data("argval");
					$(".container-txtarea").hide();
				});

		},"html");
//setTitle("", "", classified.name);
		element["id"] = element['_id']['$id'];
		//var html = directory.preview(classified);
	  	//$("#classified").html(html);
	});
	/*function addToShoppingCart(id,type){
		if(typeof userId != "undefined" && userId != ""){
			if(typeof shoppingCart[type] == "undefined")
				shoppingCart[type]=[];
			shoppingCart[type].push(mapElements[id]);
			shopping.countShoppingCart(true);
			console.log("element",mapElements[id]);
		}else{
			$('#modalLogin').modal("show");
		}
	}
	function countShoppingCart(){
		total=0;
		$.each(shoppingCart, function(k, v){
			total+=v.length;
		});
		if(total > 0){
			$(".shoppingCart-count").html(total);
			$('.shoppingCart-count').removeClass('hide');
			$('.shoppingCart-count').addClass('animated bounceIn');
			$('.shoppingCart-count').addClass('badge-success');
			$('.shoppingCart-count').removeClass('badge-tranparent');
		}else{
			$('.shoppingCart-count').addClass('hide');
			$('.shoppingCart-count').removeClass('badge-success');
			$('.shoppingCart-count').addClass('badge-tranparent');
		}
	}*/
</script>