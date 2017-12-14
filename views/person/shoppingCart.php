
<style type="text/css">
	#shoppingCart .headerTitleStanalone{
		left:-25px;
		right:-25px;
        top:0px !important;
	}
	#shoppingCart .contentOnePage{
		/*min-height:700px;*/
		margin-top: 45px !important;
	}
	.contentOnePage .title > h2{
		    padding: 15px 0px;
    text-transform: inherit;
    font-size: 20px;
	}
	.contentCart{
		margin-top: 40px;
		background-color: white;
	}
	.headerCategory .mainTitle, .headerCategory .subTitleCart{
		text-transform: inherit;
	}
	.headerCategory .mainTitle{
		font-size: 22px !important;
		font-weight: 800;
	}
	.headerCategory .subTitleCart{
		font-size: 14px;
		font-weight: 600;
	}
	.btn-cart .close-modal{
		height:inherit !important;
		width:25% !important;
		position: inherit;
		top:inherit !important;
	}
	.contentProduct{
		border-bottom: 2px solid rgba(0,0,0,0.1);
    	margin-bottom: 10px;
    	padding-bottom: 10px;
    }
    .contentProduct h4, .totalPrice{
    	text-transform: inherit;
    }
    .contentProduct .dateHoursDetail{
        display:none;
    }
    .contentProduct .showDetail{
        cursor: pointer;
    }
    .contentProduct .showDetail > i.rotate{
        transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -webkit-transform: rotate(180deg);
   }
   .dateHeader{
        /*border-bottom: 1px solid rgba(0,0,0,0.1);*/
        padding: 15px 0px;
   }
   .contentHoursSession{
    border-top: 1px solid rgba(0,0,0,0.1);
   }
   .contentHoursSession h4{
        line-height: 21px;
        font-size: 16px;
   }

   #shoppingCart .description{
    max-height: 60px;
    overflow: hidden;
    color:grey;
   }

   #openModal .container,
   #openModal .modal-content{
     padding:0px!important;
   }

   .modal-open-footer{
    display: none;
   }

   footer{
    margin-top:50px;
   }

   .associated{
      margin-top: 100px;
   }

</style>
<div id="shoppingCart">
    <div class="headerTitleStanalone">
        <div class='col-md-6 no-padding'>
            <span><?php echo Yii::t("common","Shopping cart") ?></span>
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1 contentOnePage">
    	<div class="contentCart shadow2 col-md-12 padding-15 text-center">
    	</div>
    </div>
</div>

<script src="https://rawgit.com/Mangopay/cardregistration-js-kit/master/kit/mangopay-kit.min.js"></script>
<div id="checkoutCart" class="hide" >

    <div class="headerTitleStanalone">
        <div class='col-md-6 no-padding'>
            <span><?php echo Yii::t("common","Checkout") ?></span>
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1 contentOnePage" style="margin-top:100px">
        <div class="contentCheckout shadow2 col-xs-12 no-padding text-center"></div>
        <div class="contentCB shadow2 col-xs-12 padding-15 text-left margin-top-25"></div>
        <div class='col-md-12 pull-right btn-cart margin-top-20 no-padding'>
            <button onclick='shopping.buyCart();' 
               class='btn btn-link bg-orange text-white pull-right'>
               Validate
            </a>
            <button class='btn btn-link letter-orange pull-right text-white margin-right-5' data-toggle="modal">Continue</a>
        </div>
    </div>

</div>
<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    $this->renderPartial('../element/terla/associated', array()); 
    //$this->renderPartial($layoutPath.'footer', array("subdomain"=>"page")); 
?>
<script type="text/javascript">
    var totalCart=0;
    var openDetails=[];
	jQuery(document).ready(function() {	
        //if(typeof params.name != "undefined" && params.name != "")
      
      initBtnLink();
      htmlCart = "", htmlCheckout = '';
      if(shopping.cart.countQuantity > 0 ){
      	cartview = shopping.generateCartView();
            htmlCart = cartview.cart;
            htmlCheckout = cartview.checkout;
      } else {
      	htmlCart=shopping.generateEmptyCartView();
        htmlCheckout = "";
      }

      $(".contentCart").html(htmlCart);
      $(".contentCheckout").html(htmlCheckout);

      bindCartEvent();
    });
    
    function bindCartEvent(){
        $(".showDetail").off().on("click",function(){
            if($(this).find("i").hasClass("rotate")){
                i = openDetails.indexOf($(this).data("value"));
                openDetails.splice(i, 1);
                $(this).find("i").removeClass("rotate");
                $(this).parents().eq(1).find(".dateHoursDetail").fadeOut("slow");
            }else{
                if(openDetails.indexOf($(this).data("value")) < 0)
                    openDetails.push($(this).data("value"));
                $(this).find("i").addClass("rotate");
                $(this).parents().eq(1).find(".dateHoursDetail").fadeIn("slow");
            }
        });
    }
</script>