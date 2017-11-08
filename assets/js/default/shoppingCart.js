var shopping = {
	checkoutObj = {},
	addToShoppingCart: function(id, type, subType, ranges){
		incCart=true;
		if(typeof userId != "undefined" && userId != ""){
			params=new Object;
			params.name = element.name,
			params.providerId = element.parentId,
			params.providerType = element.parentType,
			params.price = element.price,
			params.countQuantity=1;
			if(typeof element.imgProfil != "undefined")
				params.imgProfil=element.imgProfil;	
			if(typeof element.description != "undefined")
				params.description=element.description;
			if(typeof element.capacity != "undefined")
				params.capacity=element.capacity;
			if(notNull(subType))
				params.type=subType;
			if(typeof shoppingCart[type] == "undefined")
				shoppingCart[type]=new Object;
			if(type=="services" ){
				if(typeof shoppingCart[type][subType]=="undefined")
					shoppingCart[type][subType]=new Object;

				if(typeof shoppingCart[type][subType][id]=="undefined")
					shoppingCart[type][subType][id]=params;
				else{
					shoppingCart[type][subType][id]["countQuantity"]++;
					incCart=false;
				}
				if(typeof ranges != "undefined" && notNull(ranges)){
					if(typeof shoppingCart[type][subType][id]["reservations"] == "undefined")
					 	shoppingCart[type][subType][id]["reservations"]=new Object;

					if(typeof shoppingCart[type][subType][id]["reservations"][ranges.date] == "undefined"){
						shoppingCart[type][subType][id]["reservations"][ranges.date] = {"countQuantity":1};
					}else{
						shoppingCart[type][subType][id]["reservations"][ranges.date]["countQuantity"]++;
						incCart=false;
					}
					if(typeof ranges.hours != "undefined"){
						ranges.hours.countQuantity=1;
						if(typeof shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"] == "undefined")
							shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"]=[];

						if(jQuery.isEmptyObject(shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"])){
							shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"].push(ranges.hours);
						}else{
							hoursInArray=false;
							$.each(shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"], function(e,v){
								if(v.start==ranges.hours.start && v.end==ranges.hours.end){
									shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"][e]["countQuantity"]++;
									hoursInArray=true;
								}
							});
							if(!hoursInArray)
								shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"].push(ranges.hours);
						}
					}
				}
			}else{
				if(typeof shoppingCart[type][id] == "undefined"){
					shoppingCart[type][id]={};
					shoppingCart[type][id]=params;
				}else{
					shoppingCart[type][id].countQuantity++;
					incCart=false;
				}
			}
			if(incCart)
				shopping.countShoppingCart(true);
			//console.log("element",mapElements[id]);
		}else{
			$('#modalLogin').modal("show");
		}
	},
	removeFromShoppingCart:function(id, type, deleteAll, subType, ranges){
		incCart=false;
		if(typeof userId != "undefined" && userId != ""){
			if(type=="services" ){
				if(shoppingCart[type][subType][id]["countQuantity"]==1 || (deleteAll && ranges==null)){
					delete shoppingCart[type][subType][id];
					incCart=true;
				}else{
					if(!deleteAll)
						shoppingCart[type][subType][id]["countQuantity"]--;
					if(typeof ranges != "undefined" && notNull(ranges)){
						console.log(ranges);
						if(deleteAll && typeof ranges.hours == "undefined"){
							removeQuantityDate=shoppingCart[type][subType][id]["reservations"][ranges.date]["countQuantity"];
							delete shoppingCart[type][subType][id]["reservations"][ranges.date];
						}else{
							if(shoppingCart[type][subType][id]["reservations"][ranges.date]["countQuantity"]==1){
								delete shoppingCart[type][subType][id]["reservations"][ranges.date];
							}else{
								if(!deleteAll)
									shoppingCart[type][subType][id]["reservations"][ranges.date]["countQuantity"]--;
								if(typeof ranges.hours != "undefined"){
									$.each(shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"], function(e,v){
										if(typeof v != "undefined"){
											if(v.start==ranges.hours.start && v.end==ranges.hours.end){
												if(deleteAll){
													removeQuantityHours=shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"][e]["countQuantity"];
													shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"].splice(e,1);
												}else{
													if(v.countQuantity==1){
														shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"].splic(e,1);
													}
													else{
														shoppingCart[type][subType][id]["reservations"][ranges.date]["hours"][e]["countQuantity"]--;
													}
												}
											}
										}
									});
									if(typeof removeQuantityHours != "undefined"){
										shoppingCart[type][subType][id]["reservations"][ranges.date]["countQuantity"]=shoppingCart[type][subType][id]["reservations"][ranges.date]["countQuantity"]-removeQuantityHours;
										shoppingCart[type][subType][id]["countQuantity"]=shoppingCart[type][subType][id]["countQuantity"]-removeQuantityHours;
										if(shoppingCart[type][subType][id]["reservations"][ranges.date]["countQuantity"]==0){
											delete shoppingCart[type][subType][id]["reservations"][ranges.date];
										}
										if(shoppingCart[type][subType][id]["countQuantity"]==0){
											delete shoppingCart[type][subType][id];
											incCart=true;
										}
									}
								}
							}
						}
						if(typeof removeQuantityDate != "undefined"){
							shoppingCart[type][subType][id]["countQuantity"]=shoppingCart[type][subType][id]["countQuantity"]-removeQuantityDate;
							if(shoppingCart[type][subType][id]["countQuantity"]==0){
								delete shoppingCart[type][subType][id];
								incCart=true;
							}
						}
					}
				}
			}else{
				if(!deleteAll){
					delete shoppingCart[type][id];
					incCart=true;
				}else{	
					if(shoppingCart[type][id].countQuantity==1){
						incCart=true;
						delete shoppingCart[type][id];
					}else{
						shoppingCart[type][id].countQuantity--;
					}
				}
			}
			if(incCart)
				shopping.countShoppingCart(false);
		}else{
			$('#modalLogin').modal("show");
		}
	},
	countShoppingCart:function(pos){
		if(pos != "init"){
			if(pos)
				shoppingCart.countQuantity++;
			else
				shoppingCart.countQuantity--;
		}
		if(shoppingCart.countQuantity > 0){
			$(".shoppingCart-count").html(shoppingCart.countQuantity);
			$('.shoppingCart-count').removeClass('hide');
			$('.shoppingCart-count').addClass('animated bounceIn');
			$('.shoppingCart-count').addClass('badge-success');
			$('.shoppingCart-count').removeClass('badge-tranparent');
		}else{
			$('.shoppingCart-count').addClass('hide');
			$('.shoppingCart-count').removeClass('badge-success');
			$('.shoppingCart-count').addClass('badge-tranparent');
		}
	},
	generateEmptyCartView:function(){
    	str="<span>Va vite faire tes courses</span><br/>"+
    			"<a href='#store' class='btn bg-orange lbh'>Acheter Acheter Acheter</a>";
    	return str;
    },
    generateCartView:function(){
    	str="<div class='col-md-12 bg-orange padding-10'>"+
    			"<div class='pull-right'>"+
    				"<a href='javascript:alert(\"Rapha pour toi\")' class='text-white padding-5' onclick=''><i class='fa fa-print'></i> Print</a>"+
    				"<a href='javascript:alert(\"On sauvegarde le panier en attente\")' class='text-white padding-5' onclick=''><i class='fa fa-floppy-o'></i> Save</a>"+
    				"<a href='javascript:alert(\"Partager quoi sur quoi???\")' class='text-white padding-5' onclick=''><i class='fa fa-link'></i> Share</a>"+
    				"<a href='javascript:alert(\"Kill all mother fuck\")' class='text-white padding-5' onclick=''><i class='fa fa-trash'></i> Empty</a>"+
    			"</div>"+
    		"</div>"+
    		"<div class='col-md-11' style='margin-left:4.133333333%'>";
    		str+=shopping.getComponentsHtml(shoppingCart,true);
    		str+="<div class='col-md-12 bg-orange-1 padding-5 margin-top-20'>"+
    				"<div class='pull-right'>"+
    					"<h3 class='letter-orange no-margin totalPrice'>Total of your order: "+totalCart+" euros</h3>"+
    				"</div>"+
    			"</div>";
    		str+="<div class='col-md-12 pull-right btn-cart margin-top-20'>"+
    					"<a href='javascript:;' onclick='shopping.buyCart();' class='btn bg-orange text-white pull-right col-md-3' onclick=''>Validate</a>"+
    					"<a href='javascript:;' class='btn bg-orange pull-right col-md-3 text-white close-modal' >Continue</a>"+
    			"</div>";
    		str+="<div class='col-md-12 margin-top-10 text-left'>"+
    				"<span>* folder fee included and delivery tax not included</span>"+
    			"</div></div>";
    	return str;
    },
    getComponentsHtml:function(data,firstLevel){
        itemHtml="";
        $.each(data,function(i,v){
            console.log(v);
            if(i!="countQuantity"){
                if(i=="services"){
                    $.each(v,function(e, service){
                        console.log(service);
                        itemHtml+=shopping.getItemByCategory(e,service,"services");
                    });
                }
                else{
                    itemHtml+=shopping.getItemByCategory(i,v, "products");
                }
            }
        });
        return itemHtml;
    },
    getItemByCategory:function(label,item, type){
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
            itemHtml+=shopping.getViewItem(e, data, type);
            totalCart=totalCart+(data.price*data.countQuantity);
        });
        return itemHtml;
    },
    getViewItem:function(key, data, type){
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
            incQtt="<a href='javascript:;' class='letter-orange remove-session "+classRemove+"' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",null);'>"
                    +"<i class='fa fa-minus'></i></a>"
                +'<span class="eventCountItem margin-left-5 margin-right-5">'
                    +'<i class="fa fa-shopping-cart"></i>'
                    +'<span class="inc-session topbar-badge badge animated bounceIn badge-transparent badge-success">'+data.countQuantity+'</span>'
                +'</span>'
                +"<a href='javascript:;' class='letter-orange add-session "+classAdd+"' onclick='shopping.addInCart(\""+itemId+"\", \""+itemType+"\", null);'><i class='fa fa-plus'></i></a>";
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
                "<div class='col-md-1 text-center'><span> <a href='javascript:;' class='text-red' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\");'><i class='fa fa-trash'></i></a></span></div>";
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
                                    incQtt="<a href='javascript:;' class='letter-orange remove-session "+classRemove+"' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",null,\""+subType+"\",\""+date+"\");'>"
                                            +"<i class='fa fa-minus'></i></a>"
                                        +'<span class="eventCountItem margin-left-5 margin-right-5">'
                                            +'<i class="fa fa-shopping-cart"></i>'
                                            +'<span class="inc-session topbar-badge badge animated bounceIn badge-transparent badge-success">'+value.countQuantity+'</span>'
                                        +'</span>'
                                        +"<a href='javascript:;' class='letter-orange add-session "+classAdd+"' onclick='shopping.addInCart(\""+itemId+"\", \""+itemType+"\",\""+subType+"\",\""+date+"\");'><i class='fa fa-plus'></i></a>";
                                }else
                                    incQtt=value.countQuantity+" reservation"+s;
            itemHtml +=         "<span class='pull-left text-center col-md-3 col-sm-3 col-xs-3'>"+incQtt+"</span>"+
                                "<div class='pull-right'>"+
                                    "<a href='javascript:;' class='text-red' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\",\""+date+"\");'>"+
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
                                incQtt="<a href='javascript:;' class='letter-orange "+classRemove+"' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",null,\""+subType+"\",\""+date+"\",\""+hours.start+"\",\""+hours.end+"\");'>"
                                        +"<i class='fa fa-minus'></i></a>"
                                    +'<span class="eventCountItem margin-left-5 margin-right-5">'
                                        +'<i class="fa fa-shopping-cart"></i>'
                                        +'<span class="inc-session topbar-badge badge animated bounceIn badge-transparent badge-success">'+hours.countQuantity+'</span>'
                                    +'</span>'
                                    +"<a href='javascript:;' class='letter-orange "+classAdd+"' onclick='shopping.addInCart(\""+itemId+"\", \""+itemType+"\",\""+subType+"\",\""+date+"\",\""+hours.start+"\",\""+hours.end+"\");'><i class='fa fa-plus'></i></a>";

            itemHtml +=         "<div class='col-md-12 col-sm-12 col-xs-12 margin-bottom-5 padding-5 contentHoursSession'>"+
                                    "<h4 class='col-md-4 col-sm-4 col-xs-3 no-padding no-margin'><i class='fa fa-clock-o'></i> "+hours.start+" - "+hours.end+"</h4>"+
                                    "<span class='col-md-5 col-sm-5 col-xs-6 text-center'>"+incQtt+"</span>"+
                                    "<div class='pull-right'>"+
                                        "<a href='javascript:;' class='text-red' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\",\""+date+"\",\""+hours.start+"\",\""+hours.end+"\");'>"+
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

    },
    removeInCart:function(id, type, deleteAll, subType, date, start, end){
        ranges=null;
        if(notNull(date)){
            ranges=new Object;
            ranges.date=date;
            if(notNull(start))
                ranges.hours={start: start , end: end};
        }
        shopping.removeFromShoppingCart(id, type, deleteAll, subType, ranges);
        shopping.reloadViewCart();
    },
    addInCart:function(id, type, subType, date, start, end){
        ranges=null;
        if(notNull(date)){
            ranges=new Object;
            ranges.date=date;
            if(notNull(start))
                ranges.hours={start: start , end: end};
        }
        shopping.addToShoppingCart(id, type, subType, ranges);
        shopping.reloadViewCart();
    },
    reloadViewCart:function(){
        totalCart=0;
        if(shoppingCart.countQuantity > 0 )
            html=shopping.generateCartView();
        else
            html=shopping.generateEmptyCartView();
        $(".contentCart").html(html);
        bindCartEvent();
        initBtnLink();
        if(openDetails.length > 0){
            $.each(openDetails,function(i,v){
                $(".showDetail"+v).trigger("click");
            });   
        }
    },
    buyCart:function(){
        order = {
        	totalPrice : totalCart,
	        currency : "EUR"
        };
        orderItem = new Object;
        shopping.checkoutObj = {};
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
                        };

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
                    orderItem[key]={
                        orderedItemType : e,
                        quantity : data.countQuantity,
                        price : (data.price*data.countQuantity)
                    };

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
        
		console.log("checkout",shopping.checkoutObj);
		alert("checkout");

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
}
