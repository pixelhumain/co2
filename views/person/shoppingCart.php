
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
      	html=generateCartView();
      else
      	html=generateEmptyCartView();
      $(".contentCart").html(html);
      bindCartEvent();
    });
    function generateEmptyCartView(){
    	str="<span>Va vite faire tes courses</span><br/>"+
    			"<a href='#store' class='btn bg-orange lbh'>Acheter Acheter Acheter</a>";
    	return str;
    }
    function generateCartView(){
    	str="<div class='col-md-12 bg-orange padding-10'>"+
    			"<div class='pull-right'>"+
    				"<a href='javascript:alert(\"Rapha pour toi\")' class='text-white padding-5' onclick=''><i class='fa fa-print'></i> Print</a>"+
    				"<a href='javascript:alert(\"On sauvegarde le panier en attente\")' class='text-white padding-5' onclick=''><i class='fa fa-floppy-o'></i> Save</a>"+
    				"<a href='javascript:alert(\"Partager quoi sur quoi???\")' class='text-white padding-5' onclick=''><i class='fa fa-link'></i> Share</a>"+
    				"<a href='javascript:alert(\"Kill all mother fuck\")' class='text-white padding-5' onclick=''><i class='fa fa-trash'></i> Empty</a>"+
    			"</div>"+
    		"</div>"+
    		"<div class='col-md-11' style='margin-left:4.133333333%'>";
    		str+=getComponentsHtml(shoppingCart,true);
    		str+="<div class='col-md-12 bg-orange-1 padding-5 margin-top-20'>"+
    				"<div class='pull-right'>"+
    					"<h3 class='letter-orange no-margin totalPrice'>Total of your order: "+totalCart+" euros</h3>"+
    				"</div>"+
    			"</div>";
    		str+="<div class='col-md-12 pull-right btn-cart margin-top-20'>"+
    					"<a href='javascript:;' onclick='buyCart();' class='btn bg-orange text-white pull-right col-md-3' onclick=''>Checkout</a>"+
    					"<a href='javascript:;' class='btn bg-orange pull-right col-md-3 text-white close-modal' >Continue</a>"+
    			"</div>";
    		str+="<div class='col-md-12 margin-top-10 text-left'>"+
    				"<span>* folder fee included and delivery tax not included</span>"+
    			"</div></div>";
    	return str;
    }
    function getComponentsHtml(data,firstLevel){
        itemHtml="";
        $.each(data,function(i,v){
            console.log(v);
            if(i!="countQuantity"){
                if(i=="services"){
                    $.each(v,function(e, service){
                        console.log(service);
                        itemHtml+=getItemByCategory(e,service,"services");
                    });
                }
                else{
                    itemHtml+=getItemByCategory(i,v, "products");
                }
            }
        });
        return itemHtml;
    }
    function getItemByCategory(label,item, type){
        itemHtml="<div class='col-md-12 headerCategory margin-top-20'>"+
            "<div class='col-md-12'>"+
                "<h2 class='letter-orange mainTitle text-left'>"+label+"</h2>"+
            "</div>"+
            "<div class='col-md-1'></div>"+
            "<div class='col-md-5'><h3 class='subTitleCart letter-orange'>Label<h3></div>"+
            "<div class='col-md-2'><h3 class='subTitleCart letter-orange'>Price ht<h3></div>"+
            "<div class='col-md-1'><h3 class='subTitleCart letter-orange'>Detail<h3></div>"+
            "<div class='col-md-2'><h3 class='subTitleCart letter-orange'>Price ttc<h3></div>"+
            "<div class='col-md-1'></div>"+
        "</div>";
        $.each(item,function(e,data){
            itemHtml+=getViewItem(e, data, type);
            totalCart=totalCart+(data.price*data.countQuantity);
        });
        shoppingCart.total = totalCart;
        return itemHtml;
    }
    function getViewItem(key, data, type){
        itemId=key;
        itemType=type;
        subType=null;
        if(data.type != "undefined")
            subType=data.type;
        if(typeof data.reservations =="undefined"){
            classRemove="";
            classAdd="";
            if(data.countQuantity==1)
                classRemove="hide";
            if(typeof data.capacity != "undefined" && data.countQuantity>=data.capacity)
                classAdd="hide";
            incQtt="<a href='javascript:;' class='letter-orange remove-session "+classRemove+"' onclick='removeInCart(\""+itemId+"\", \""+itemType+"\",null);'>"
                    +"<i class='fa fa-minus'></i></a>"
                +'<span class="eventCountItem margin-left-5 margin-right-5">'
                    +'<i class="fa fa-shopping-cart"></i>'
                    +'<span class="inc-session topbar-badge badge animated bounceIn badge-transparent badge-success">'+data.countQuantity+'</span>'
                +'</span>'
                +"<a href='javascript:;' class='letter-orange add-session "+classAdd+"' onclick='addInCart(\""+itemId+"\", \""+itemType+"\", null);'><i class='fa fa-plus'></i></a>";
        }else
            incQtt="<span class='showDetail showDetail"+key+"' data-value='"+key+"''><i class='fa fa-2x fa-angle-down'></i></span>";
        itemHtml="<div class='col-md-12 contentProduct contentProduct"+itemId+" text-left'>"+
                "<div class='col-md-1'>"+data.imgProfil+"</div>"+
                "<div class='col-md-5'>"+
                    "<h4 class='text-dark'>"+data.name+"</h4><br>"+
                    "<span>Quantity booked:"+data.countQuantity+"</span><br>";
                if(typeof data.description != "undefined" && data.description != "")
            itemHtml += "<span>"+data.description+"</span><br>";
            itemHtml += "<a href='javascript:;' class='letter-blue' onclick='alert(\"What's the quoi???\")'> Save / Update</a>"+
                "</div>"+
                "<div class='col-md-2 text-center'><span>"+(data.price*data.countQuantity)+"</span></div>"+
                "<div class='col-md-1 text-center no-padding'>"+incQtt+"</div>"+
                "<div class='col-md-2 text-center'><span>"+(data.price*data.countQuantity)+"</span></div>"+
                "<div class='col-md-1 text-center'><span> <a href='javascript:;' class='text-red' onclick='removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\");'><i class='fa fa-trash'></i></a></span></div>";
                if(typeof data.reservations != "undefined"){
            itemHtml += "<div class='col-md-12 col-sm-12 col-xs-12 dateHoursDetail'>"; 
               //     countDate=Object.keys(data.reservations).length;
             //       s=(countDate > 1) ? "s" : "";
            //itemHtml += "<span>"+countDate+" date"+s+" booked</span><br/>";
                    $.each(data.reservations, function(date, value){
                        s=(value.countQuantity > 1) ? "s" : "";
                        dateStr=directory.getDateFormated({startDate:date}, true);
            itemHtml += "<div class='col-md-12 col-sm-12 col-xs-12 bookDate"+date+" shadow2 margin-bottom-10'>"+
                            "<div class='col-md-12 col-sm-12 col-xs-12 dateHeader'>"+
                                "<h4 class='pull-left margin-bottom-5 no-margin col-md-5 col-sm-5 col-xs-5 no-padding'><i class='fa fa-calendar'></i> "+dateStr+"</h4>";
                                if(typeof value.hours =="undefined"){
                                    classRemove="";
                                    classAdd="";
                                    if(value.countQuantity==1)
                                        classRemove="hide";
                                    if(value.countQuantity>=data.capacity)
                                        classAdd="hide";
                                    incQtt="<a href='javascript:;' class='letter-orange remove-session "+classRemove+"' onclick='removeInCart(\""+itemId+"\", \""+itemType+"\",null,\""+subType+"\",\""+date+"\");'>"
                                            +"<i class='fa fa-minus'></i></a>"
                                        +'<span class="eventCountItem margin-left-5 margin-right-5">'
                                            +'<i class="fa fa-shopping-cart"></i>'
                                            +'<span class="inc-session topbar-badge badge animated bounceIn badge-transparent badge-success">'+value.countQuantity+'</span>'
                                        +'</span>'
                                        +"<a href='javascript:;' class='letter-orange add-session "+classAdd+"' onclick='addInCart(\""+itemId+"\", \""+itemType+"\",\""+subType+"\",\""+date+"\");'><i class='fa fa-plus'></i></a>";
                                }else
                                    incQtt=value.countQuantity+" reservation"+s;
            itemHtml +=         "<span class='pull-left text-center col-md-3 col-sm-3 col-xs-3'>"+incQtt+"</span>"+
                                "<div class='pull-right'>"+
                                    "<a href='javascript:;' class='text-red' onclick='removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\",\""+date+"\");'>"+
                                        "<i class='fa fa-trash'></i> Remove this date</a>"+
                                "</div>"+
                            "</div>";
                            
                        if(typeof value.hours != "undefined"){
                            //countSession=Object.keys(value.hours).length;
                            //s=(countSession > 1) ? "s" : "";
                            //itemHtml += "<span>"+countSession+" session"+s+"</span><br/>";
                            $.each(value.hours, function(key, hours){
                                s=(hours.countQuantity > 1) ? "s" : "";
                                classRemove="";
                                classAdd="";
                                if(hours.countQuantity==1)
                                    classRemove="hide";
                                if(hours.countQuantity>=data.capacity)
                                    classAdd="hide";
                                incQtt="<a href='javascript:;' class='letter-orange "+classRemove+"' onclick='removeInCart(\""+itemId+"\", \""+itemType+"\",null,\""+subType+"\",\""+date+"\",\""+hours.start+"\",\""+hours.end+"\");'>"
                                        +"<i class='fa fa-minus'></i></a>"
                                    +'<span class="eventCountItem margin-left-5 margin-right-5">'
                                        +'<i class="fa fa-shopping-cart"></i>'
                                        +'<span class="inc-session topbar-badge badge animated bounceIn badge-transparent badge-success">'+hours.countQuantity+'</span>'
                                    +'</span>'
                                    +"<a href='javascript:;' class='letter-orange "+classAdd+"' onclick='addInCart(\""+itemId+"\", \""+itemType+"\",\""+subType+"\",\""+date+"\",\""+hours.start+"\",\""+hours.end+"\");'><i class='fa fa-plus'></i></a>";

            itemHtml +=         "<div class='col-md-12 col-sm-12 col-xs-12 margin-bottom-5 padding-5 contentHoursSession'>"+
                                    "<h4 class='col-md-4 col-sm-4 col-xs-3 no-padding no-margin'><i class='fa fa-clock-o'></i> "+hours.start+" - "+hours.end+"</h4>"+
                                    "<span class='col-md-5 col-sm-5 col-xs-6 text-center'>"+incQtt+"</span>"+
                                    "<div class='pull-right'>"+
                                        "<a href='javascript:;' class='text-red' onclick='removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\",\""+date+"\",\""+hours.start+"\",\""+hours.end+"\");'>"+
                                            "<i class='fa fa-times'></i>"+
                                        "</a>"+
                                    "</div>"+
                                "</div>";
                            });
                        }
            itemHtml += "</div>"; 
                    }); 
            itemHtml += "</div>";
                }
        itemHtml += "</div>";
        return itemHtml;

    }
    function removeInCart(id, type, deleteAll, subType, date, start, end){
        ranges=null;
        if(notNull(date)){
            ranges=new Object;
            ranges.date=date;
            if(notNull(start))
                ranges.hours={start: start , end: end};
        }
        removeFromShoppingCart(id, type, deleteAll, subType, ranges);
        reloadViewCart();
    }
    function addInCart(id, type, subType, date, start, end){
        ranges=null;
        if(notNull(date)){
            ranges=new Object;
            ranges.date=date;
            if(notNull(start))
                ranges.hours={start: start , end: end};
        }
        addToShoppingCart(id, type, subType, ranges);
        reloadViewCart();
    }
    function reloadViewCart(){
        totalCart=0;
        if(shoppingCart.countQuantity > 0 )
            html=generateCartView();
        else
            html=generateEmptyCartView();
        $(".contentCart").html(html);
        bindCartEvent();
        initBtnLink();
        if(openDetails.length > 0){
            $.each(openDetails,function(i,v){
                $(".showDetail"+v).trigger("click");
            });   
        }
        
    }
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
    function buyCart(){
        order = {
            totalPrice : totalCart,
            currency : "EUR"
        };
        orderItem = new Object;
        checkoutObj = {};
        $.each(shoppingCart,function(e,v){
            if(e=="countQuantity")
                order.countOrderItem=v;
            else if(e=="services"){
                $.each(v, function(cat, listByCat){
                    $.each(listByCat, function(key, data){
                        orderItem[key]={
                            orderedItemType : e,
                            quantity : data.countQuantity,
                            price : (data.price * data.countQuantity),
                            reservations : data.reservation
                        }
                        if( typeof checkoutObj[data.providerId] == "undefined" )
                            checkoutObj[data.providerId] = {
                                total : orderItem[key].price,
                                providerType : data.providerType
                            };
                        else
                            checkoutObj[data.providerId].total  += orderItem[key].price;
                    });
                });
            }else if(e=="products"){
                $.each(v, function(key, data){
                    orderItem[key] = {
                        orderedItemType : e,
                        quantity : data.countQuantity,
                        price : (data.price*data.countQuantity)
                    }
                    if( typeof checkoutObj[data.providerId] == "undefined" )
                        checkoutObj[data.providerId] = {
                            total : orderItem[key].price,
                            providerType : data.providerType
                        };
                    else
                        checkoutObj[data.providerId].total  += orderItem[key].price;
                });
            }
        });
        order.orderItems=orderItem;
        console.log("checkoutObj",checkoutObj);
        bootbox.prompt({
            title: "Give a name to your command:", 
            value : "Cart of "+moment(new Date()).format('DD-MM-YYYY HH:MM'), 
            callback : function(result){ 
                order.name=result;
                $.ajax({
                  type: "POST",
                  url: baseUrl+"/"+moduleId+"/order/save", 
                  data: order,
                  success: function(data){
                    if(data.result) {
                        toastr.success(data.msg);
                        console.log("checkoutObj",checkoutObj);
                        //shoppingCart={countQuantity:0};
                        //if(reload)
                        alert("goto checkout");
                        //urlCtrl.loadByHash("#checkout");
                    }
                    else
                        toastr.error(data.msg);  
                  },
                  dataType: "json"
                });
                console.log(order);
            }
        })
    }
</script>