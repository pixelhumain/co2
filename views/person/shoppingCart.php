
<style type="text/css">
	#shoppingCart .headerTitleStanalone{
		left:-25px;
		right:-25px;
        top:0px !important;
	}
	#shoppingCart .contentOnePage{
		min-height:700px;
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
</style>
<div id="shoppingCart">
    <div class="headerTitleStanalone"></div>
    <div class="col-md-10 col-md-offset-1 contentOnePage">
    	<div class="contentCart shadow2 col-md-12 no-padding text-center">
    	</div>
    </div>
</div>
<script type="text/javascript">
    var totalCart=0;
    var openDetails=[];
	jQuery(document).ready(function() {	
        //if(typeof params.name != "undefined" && params.name != "")
        str =  "<div class='col-md-6 no-padding'>"+ 
        "<span>Shopping cart</span>"+
      "</div>";
      $(".headerTitleStanalone").html(str);
      initBtnLink();
      if(shoppingCart.countQuantity > 0 )
      	html=shopping.generateCartView();
      else
      	html=shopping.generateEmptyCartView();
      $(".contentCart").html(html);
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