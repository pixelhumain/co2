
<style type="text/css">
	.headerTitleStanalone{
		left:-25px;
		right:-25px;
	}
	.contentOnePage{
		min-height:700px;
		margin-top: 45px;
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

</style>
<div class="headerTitleStanalone"></div>
<div class="col-md-10 col-md-offset-1 contentOnePage">
	<div class="contentCart shadow2 col-md-12 no-padding text-center">
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {	
        //if(typeof params.name != "undefined" && params.name != "")
        str =  "<div class='col-md-6 no-padding'>"+ 
        "<span>Shopping cart</span>"+
      "</div>";
      $(".headerTitleStanalone").html(str);
      initBtnLink();
      if(!jQuery.isEmptyObject(shoppingCart))
      	html=generateCartView();
      else
      	html=generateEmptyCartView();
      $(".contentCart").html(html);
    });
    function generateEmptyCartView(){
    	str="<span>Va vite faire tes courses</span><br/>"+
    			"<a href='#store' class='btn bg-orange lbh'>Acheter Acheter Acheter</a>";
    	return str;
    }
    function generateCartView(){
    	total=0;
    	str="<div class='col-md-12 bg-orange padding-10'>"+
    			"<div class='pull-right'>"+
    				"<a href='javascript:alert(\"Rapha pour toi\")' class='text-white padding-5' onclick=''><i class='fa fa-print'></i> Print</a>"+
    				"<a href='javascript:alert(\"On sauvegarde le panier en attente\")' class='text-white padding-5' onclick=''><i class='fa fa-floppy-o'></i> Save</a>"+
    				"<a href='javascript:alert(\"Partager quoi sur quoi???\")' class='text-white padding-5' onclick=''><i class='fa fa-link'></i> Share</a>"+
    				"<a href='javascript:alert(\"Kill all mother fuck\")' class='text-white padding-5' onclick=''><i class='fa fa-trash'></i> Empty</a>"+
    			"</div>"+
    		"</div>"+
    		"<div class='col-md-11' style='margin-left:4.133333333%'>";
    		$.each(shoppingCart,function(i,v){
    			str+="<div class='col-md-12 headerCategory margin-top-20'>"+
    					"<div class='col-md-12'>"+
    						"<h2 class='letter-orange mainTitle text-left'>"+i+"</h2>"+
    					"</div>"+
    					"<div class='col-md-1'></div>"+
    					"<div class='col-md-5'><h3 class='subTitleCart letter-orange'>Label<h3></div>"+
    					"<div class='col-md-2'><h3 class='subTitleCart letter-orange'>Price ht<h3></div>"+
    					"<div class='col-md-1'><h3 class='subTitleCart letter-orange'>Detail<h3></div>"+
    					"<div class='col-md-2'><h3 class='subTitleCart letter-orange'>Price ttc<h3></div>"+
    					"<div class='col-md-1'></div>"+
					"</div>";
				$.each(v,function(e,data){
					str+="<div class='col-md-12 contentProduct text-left'>"+
    					"<div class='col-md-1'>"+data.imgProfil+"</div>"+
    					"<div class='col-md-5'>"+
    						"<h4 class='text-dark'>"+data.name+"</h4><br>"+
    						"<span>"+data.description+"</span><br>"+
    						"<a href='javascript:;' class='letter-blue' onclick='alert(\"What's the quoi???\")'> Save / Update</a>"+
    					"</div>"+
    					"<div class='col-md-2'><span>"+data.price+"</span></div>"+
    					"<div class='col-md-1'><span><i class='fa fa-angle-down'></i></span></div>"+
    					"<div class='col-md-2'><span>"+data.price+"</span></div>"+
    					"<div class='col-md-1'><span><i class='fa fa-trash'></i></span></div>"+
					"</div>";
					total=total+data.price;
				})
    		});
    		str+="<div class='col-md-12 bg-orange-1 padding-5 margin-top-20'>"+
    				"<div class='pull-right'>"+
    					"<h3 class='letter-orange no-margin totalPrice'>Total of your order: "+total+" euros</h3>"+
    				"</div>"+
    			"</div>";
    		str+="<div class='col-md-12 pull-right btn-cart margin-top-20'>"+
    					"<a href='javascript:alert(\"Mangolitooooo Oceatoon\")' class='btn bg-orange text-white pull-right col-md-3' onclick=''>Validate</a>"+
    					"<a href='javascript:;' class='btn bg-orange pull-right col-md-3 text-white close-modal' >Continue</a>"+
    			"</div>";
    		str+="<div class='col-md-12 margin-top-10 text-left'>"+
    				"<span>* folder fee included and delivery tax not included</span>"+
    			"</div></div>";
    	return str;
    }
</script>