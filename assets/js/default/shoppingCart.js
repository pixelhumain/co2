var shopping = {
	cart:{
		countQuantity:0,
		totalCart : 0
	},
	checkoutObj : {
		total : 0,
		sellers : {}
	},
	totalCart:0,
	init : function(){
		shopping.cart={
			countQuantity:0,
			totalCart : 0
		};
		shopping.checkoutObj = {
			total : 0,
			sellers : {}
		};
		shopping.totalCart=0;
	},
	addToShoppingCart: function(id, type, subType, ranges){
		incCart=true;
		if(typeof userId != "undefined" && userId != ""){
			if(typeof shopping.cart[type] == "undefined")
				shopping.cart[type]=new Object;
			if(type=="services" ){
				if(typeof shopping.cart[type][subType]=="undefined")
					shopping.cart[type][subType]=new Object;

				if(typeof shopping.cart[type][subType][id]=="undefined"){
					params={
						name : element.name,
						providerId : element.parentId,
						providerName : element.name,
						providerType : element.parentType,
						price : element.price,
						countQuantity:1
					};
					if(typeof element.imgProfil != "undefined")
						params.imgProfil=element.imgProfil;	
					if(typeof element.description != "undefined")
						params.description=element.description;
					if(typeof element.capacity != "undefined")
						params.capacity=element.capacity;
					if(notNull(subType))
						params.type=subType;
					shopping.cart[type][subType][id]=params;
				}
				else{
					shopping.cart[type][subType][id]["countQuantity"]++;
					incCart=false;
				}
				if(typeof ranges != "undefined" && notNull(ranges)){
					if(typeof shopping.cart[type][subType][id]["reservations"] == "undefined")
					 	shopping.cart[type][subType][id]["reservations"]=new Object;

					if(typeof shopping.cart[type][subType][id]["reservations"][ranges.date] == "undefined"){
						shopping.cart[type][subType][id]["reservations"][ranges.date] = {"countQuantity":1};
					}else{
						shopping.cart[type][subType][id]["reservations"][ranges.date]["countQuantity"]++;
						incCart=false;
					}
					if(typeof ranges.hours != "undefined"){
						ranges.hours.countQuantity=1;
						if(typeof shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"] == "undefined")
							shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"]=[];

						if(jQuery.isEmptyObject(shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"])){
							shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"].push(ranges.hours);
						}else{
							hoursInArray=false;
							$.each(shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"], function(e,v){
								if(v.start==ranges.hours.start && v.end==ranges.hours.end){
									shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"][e]["countQuantity"]++;
									hoursInArray=true;
								}
							});
							if(!hoursInArray)
								shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"].push(ranges.hours);
						}
					}
				}
			}else{
				if(typeof shopping.cart[type][id] == "undefined"){
					params={
						name : element.name,
						providerId : element.parentId,
						providerType : element.parentType,
						providerName : element.name,
						price : element.price,
						countQuantity:1
					};
					if(typeof element.imgProfil != "undefined")
						params.imgProfil=element.imgProfil;	
					if(typeof element.description != "undefined")
						params.description=element.description;
					if(typeof element.capacity != "undefined")
						params.capacity=element.capacity;
					if(notNull(subType))
						params.type=subType;
					shopping.cart[type][id]={};
					shopping.cart[type][id]=params;
				}else{
					shopping.cart[type][id].countQuantity++;
					incCart=false;
				}
			}
			if(incCart)
				shopping.countShoppingCart(true);
			localStorage.setItem("shoppingCart",JSON.stringify(shopping.cart));
		}else{
			$('#modalLogin').modal("show");
		}
	},
	removeFromShoppingCart:function(id, type, deleteAll, subType, ranges){
		incCart=false;
		if(typeof userId != "undefined" && userId != ""){
			if(type=="services" ){
				if(shopping.cart[type][subType][id]["countQuantity"]==1 || (deleteAll && ranges==null)){
					delete shopping.cart[type][subType][id];
					incCart=true;
				}else{
					if(!deleteAll)
						shopping.cart[type][subType][id]["countQuantity"]--;
					if(typeof ranges != "undefined" && notNull(ranges)){
						console.log(ranges);
						if(deleteAll && typeof ranges.hours == "undefined"){
							removeQuantityDate=shopping.cart[type][subType][id]["reservations"][ranges.date]["countQuantity"];
							delete shopping.cart[type][subType][id]["reservations"][ranges.date];
						}else{
							if(shopping.cart[type][subType][id]["reservations"][ranges.date]["countQuantity"]==1){
								delete shopping.cart[type][subType][id]["reservations"][ranges.date];
							}else{
								if(!deleteAll)
									shopping.cart[type][subType][id]["reservations"][ranges.date]["countQuantity"]--;
								if(typeof ranges.hours != "undefined"){
									$.each(shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"], function(e,v){
										if(typeof v != "undefined"){
											if(v.start==ranges.hours.start && v.end==ranges.hours.end){
												if(deleteAll){
													removeQuantityHours=shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"][e]["countQuantity"];
													shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"].splice(e,1);
												}else{
													if(v.countQuantity==1){
														shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"].splic(e,1);
													}
													else{
														shopping.cart[type][subType][id]["reservations"][ranges.date]["hours"][e]["countQuantity"]--;
													}
												}
											}
										}
									});
									if(typeof removeQuantityHours != "undefined"){
										shopping.cart[type][subType][id]["reservations"][ranges.date]["countQuantity"]=shopping.cart[type][subType][id]["reservations"][ranges.date]["countQuantity"]-removeQuantityHours;
										shopping.cart[type][subType][id]["countQuantity"]=shopping.cart[type][subType][id]["countQuantity"]-removeQuantityHours;
										if(shopping.cart[type][subType][id]["reservations"][ranges.date]["countQuantity"]==0){
											delete shopping.cart[type][subType][id]["reservations"][ranges.date];
										}
										if(shopping.cart[type][subType][id]["countQuantity"]==0){
											delete shopping.cart[type][subType][id];
											incCart=true;
										}
									}
								}
							}
						}
						if(typeof removeQuantityDate != "undefined"){
							shopping.cart[type][subType][id]["countQuantity"]=shopping.cart[type][subType][id]["countQuantity"]-removeQuantityDate;
							if(shopping.cart[type][subType][id]["countQuantity"]==0){
								delete shopping.cart[type][subType][id];
								incCart=true;
							}
						}
					}
				}
			}else{
				if(deleteAll){
					delete shopping.cart[type][id];
					incCart=true;
				}else{	
					if(shopping.cart[type][id].countQuantity==1){
						incCart=true;
						delete shopping.cart[type][id];
					}else{
						shopping.cart[type][id].countQuantity--;
					}
				}
			}
			if(incCart)
				shopping.countShoppingCart(false);
			localStorage.setItem("shoppingCart",JSON.stringify(shopping.cart));
		}else{
			$('#modalLogin').modal("show");
		}
	},
	addEvent : function($this,data){
		bookDate=data.start.format('YYYY-MM-DD');
		var ranges = new Object;
		ranges.date=bookDate;
		data.capacity--;
		data.quantity++;
		if(data.quantity > 0){
			$this.find(".remove-session").removeClass("hide");
			$this.find(".inc-session").html(data.quantity);
			$this.find('.inc-session').removeClass('hide');
			$this.find('.inc-session').addClass('animated bounceIn');
			$this.find('.inc-session').addClass('badge-success');
			$this.find('.inc-session').removeClass('badge-tranparent');
		}else{
			$this.find('.inc-session').addClass('hide');
			$this.find('.inc-session').removeClass('badge-success');
			$this.find('.inc-session').addClass('badge-tranparent');
			$this.find(".inc-session").addClass("hide");
		}
		if(data.capacity === 0){
			$this.find(".add-session").addClass("hide");
		}
		//element.find(".inc-session").data("value",event.quantity).text(event.quantity);
		$this.find(".inc-capacity").data("value",data.capacity).text(data.capacity);
		if(typeof data.allDay == "undefined" || !data.allDay)
			ranges.hours={start: data.startTime , end: data.endTime};		
        shopping.addToShoppingCart(itemId, itemType, subType, ranges);
        availableCal.push(data);
	},
	removeEvent: function($this,data){
		bookDate=data.start.format('YYYY-MM-DD');
		data.capacity++;
		data.quantity--;
		if(data.capacity > 0)
			$this.find(".add-session").removeClass("hide");
		if(data.quantity === 0){
			$this.find('.remove-session').addClass('hide');
			$this.find('.inc-session').removeClass('badge-success');
			$this.find('.inc-session').addClass('badge-tranparent');
			$this.find(".inc-session").addClass("hide");
		}else{
			$this.find(".inc-session").html(data.quantity);
			$this.find('.inc-session').removeClass('hide');
			$this.find('.inc-session').addClass('animated bounceIn');
			$this.find('.inc-session').addClass('badge-success');
			$this.find('.inc-session').removeClass('badge-tranparent');
		}
		//element.find(".inc-session").text(event.quantity);
		$this.find(".inc-capacity").text(data.capacity);
		var ranges = new Object;
		ranges.date=bookDate;
		if(typeof data.allDay == "undefined" || !data.allDay)
			ranges.hours={start: data.startTime , end: data.endTime};	
		availableCal.push(data);	
        shopping.removeFromShoppingCart(itemId, itemType, false, subType, ranges);
	},
	getDayFilter : function(event){
		currentCartFilter={"quantity":0,"myQuantity":0};
		// GET QUANTITY OF CURRENT CART
		if(typeof shopping.cart.services != "undefined" 
			&& typeof shopping.cart.services[subType] != "undefined"
			&& typeof shopping.cart.services[subType][itemId] != "undefined"
			&& typeof shopping.cart[type][subType][id]["reservations"][event.start.format('YYYY-MM-DD')] != "undefined"){
			if(event.allDay==true){
				currentCartFilter.myQuantity=currentCartFilter.myQuantity+shopping.cart[type][subType][id]["reservations"][event.start.format('YYYY-MM-DD')]["countQuantity"];
			}else{
				if(typeof shopping.cart[type][subType][id]["reservations"][event.start.format('YYYY-MM-DD')]["hours"] != "undefined"){
					$.each(shopping.cart[type][subType][id]["reservations"][event.start.format('YYYY-MM-DD')]["hours"],function(e,v){
						if(v.start==event.startTime && v.end==event.endTime)
							currentCartFilter.myQuantity=currentCartFilter.myQuantity+v.countQuantity;			
					});
				}	
			}
		}
		// GET QUANTITY ALREADY BOOKED
		//console.log("allBook",allBookings);
		if(allBookings.length && typeof event.filtered == "undefined"){
			//console.log("allBookings",allBookings);
			$.each(allBookings,function(e,v){
				date=new Date( parseInt(v.date.sec)*1000 );
				if(moment(date).format('YYYY-MM-DD')==event.start.format('YYYY-MM-DD')){
					if(event.allDay){
							currentCartFilter.quantity=currentCartFilter.quantity+parseInt(v.countQuantity);
					}else{
						if(typeof v.hours != "undefined"){
							$.each(v.hours,function(i, hours){
								if(hours.start==event.startTime && hours.end==event.endTime)
									currentCartFilter.quantity=currentCartFilter.quantity+parseInt(hours.countQuantity);
							});
						}
					}
				}
				//alert(currentCartFilter.quantity);
			});
		}
		return currentCartFilter;
	},
	countShoppingCart:function(pos){
		if(pos != "init"){
			if(pos)
				shopping.cart.countQuantity++;
			else
				shopping.cart.countQuantity--;
		}
		if(shopping.cart.countQuantity > 0){
			$(".shoppingCart-count").html(shopping.cart.countQuantity);
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
    	var htmls = shopping.getComponentsHtml(true);
    	//******************************************
		// CART
		//******************************************
    	str="<div class='col-md-12 bg-orange padding-10'>"+
    			"<div class='pull-right'>"+
    				"<a href='javascript:alert(\"Rapha pour toi\")' class='text-white padding-5' onclick=''><i class='fa fa-print'></i> Print</a>"+
    				"<a href='javascript:;' onclick='shopping.saveCart();' class='text-white padding-5' onclick=''><i class='fa fa-floppy-o'></i> Save</a>"+
    				"<a href='javascript:alert(\"Partager quoi sur quoi???\")' class='text-white padding-5' onclick=''><i class='fa fa-link'></i> Share</a>"+
    				"<a href='javascript:alert(\"Kill all mother fuck\")' class='text-white padding-5' onclick=''><i class='fa fa-trash'></i> Empty</a>"+
    			"</div>"+
    		"</div>"+
    		"<div class='col-xs-12'>";
    		str+=htmls.itemHtml;
    		str+="<div class='col-xs-12 bg-orange padding-10 margin-top-20 radius-5 text-right'>"+
    				"<h4 class='text-white no-margin totalPrice'>"+
    					"<small class='text-white'>"+trad["Total of your order"] + " : </small>"+shopping.totalCart+
    					"<small class='text-white'> euros</small>"+
    				"</h4>"+
    			"</div>";
    		str+="<div class='col-xs-12 pull-right btn-cart margin-top-20 no-padding'>"+
					"<button onclick='shopping.checkout();' class='btn btn-link bg-orange text-white pull-right'>"+trad["Checkout"] +"</button>"+
					"<button class='btn btn-link letter-orange pull-right margin-right-10 text-white' data-toggle='modal'>"+trad["Continue"] +"</button>"+
    				"<div class='margin-top-10 pull-left'>"+
    					"* folder fee included and delivery tax not included"+
    				"</div>"+
    			"</div>" +
    		"</div>";

		//******************************************
		// CHECKOUT 
		//******************************************
		cStr = "<div class='col-xs-12 bg-orange padding-10'>"+
    			"<div class='pull-left'>"+
    				"<span class='text-white'> " + trad["Checkout"] + " </span>"+
    			"</div>"+
    		"</div>"+
    		"<div class='col-xs-12'>";
    		cStr += htmls.sellerHtml;
    		cStr += "<div class='pull-right bg-orange text-right padding-5 margin-top-20 radius-5'>"+
    					"<h4 class='text-white no-margin totalPrice'>Passer à la caisse : "+shopping.totalCart+" euros</h4>"+
    				"</div>";
    		cStr += "<div class='col-xs-12 padding-15 text-right'>"+
    				"<span>* folder fee included and delivery tax not included</span>"+
    			"</div></div>";
    	return { cart : str , checkout : cStr };
    },
    checkout : function(typeCB) { 
    	$(".contentCB").html("<i class='fa fa-spin fa-circle-o-notch'></i>");
    	$(".cbType").removeClass("activePay");
    	typeCB = (typeCB) ? typeCB : "CB_VISA_MASTERCARD";
    	$("."+typeCB).addClass("activePay");

    	params = "?amount="+shopping.checkoutObj.total+"&cur=EUR&card="+typeCB;
    	
    	getAjax(".contentCB", baseUrl+'/'+moduleId+"/pay"+params, null,"html");
    	$("#shoppingCart").addClass("hide");
    	$("#checkoutCart").removeClass("hide");
    },
    pay : function() { 
    	getAjax(".contentCB", baseUrl+'/'+moduleId+"/done?amount="+shopping.checkoutObj.total+"&cur=EUR&card=CB_VISA_MASTERCARD", null,"html");
    	$("#shoppingCart").addClass("hide");
    	$("#checkoutCart").addClass("hide");
    	$("#checkoutResult").addClass("hide");
    },
    getComponentsHtml:function(firstLevel){
        var itemHtml = "";
        shopping.checkoutObj = {
        						total:0,
        						sellers : {}
        					};
        $.each(shopping.cart,function(i,v){
            console.log(v);
            if(i=="services" || i=="products"){
                if(i=="services"){
                    $.each(v,function(e, service){
                        console.log(service);
                        itemHtml += shopping.getItemByCategory(e,service,"services");
                    });
                }
                else{
                    itemHtml += shopping.getItemByCategory(i,v, "products");
                }
            }
        });

        var sellerHtml = "";
        $.each(shopping.checkoutObj.sellers,function(id,seller){
            console.log(seller);
            sellerHtml += 	"<div class='col-md-12 headerCategory margin-top-20'>"+
					            "<div class='col-md-12'>"+
					                "<h5 class='letter-orange text-left'>"+id+
					                	"<span class='pull-right subTitleCart'>"+seller.total+" ttc</span>"+
					                "<h5>"+
					            "</div>"+            
        					"</div>";
        });

        return { "itemHtml" : itemHtml , "sellerHtml" : sellerHtml };
    },
    getItemByCategory:function(label,item, type){
        itemHtml="<div class='col-md-12 headerCategory margin-top-20'>"+
            "<div class='col-md-12'>"+
                "<h2 class='letter-orange mainTitle text-left'>"+label+"</h2>"+
            "</div>"+
            "<div class='col-md-2'></div>"+
            "<div class='col-md-4'><h3 class='subTitleCart letter-orange'>Label<h3></div>"+
            "<div class='col-md-2'><h3 class='subTitleCart letter-orange'>Price ht<h3></div>"+
            "<div class='col-md-1'><h3 class='subTitleCart letter-orange'>Detail<h3></div>"+
            "<div class='col-md-2'><h3 class='subTitleCart letter-orange'>Price ttc<h3></div>"+
            "<div class='col-md-1'></div>"+
        "</div>";
        $.each(item,function(e,data){
            itemHtml+=shopping.getViewItem(e, data, type);
            if(shopping.cart.idCircuit=="undefined")
            	shopping.totalCart+=data.price*data.countQuantity;
            else
            	shopping.totalCart+=data.price*data.countQuantity*shopping.cart.bookingFor;
            if(shopping.cart.idCircuit=="undefined"){
            		totalCheck=data.price*data.countQuantity;
            		qtyCheck=data.countQuantity;
            	}
            	else{
            		totalCheck=data.price*data.countQuantity*shopping.cart.bookingFor;
            		qtyCheck=data.countQuantity*shopping.cart.bookingFor;
           	}
            if( typeof shopping.checkoutObj.sellers[data.providerId] == "undefined" ){
            
                shopping.checkoutObj.sellers[data.providerId] = {
                    total : totalCheck,
                    qty : qtyCheck,
                    type : data.providerType,
                    name : data.providerName,
                };
            }else {
                shopping.checkoutObj.sellers[data.providerId].total  += totalCheck;
                shopping.checkoutObj.sellers[data.providerId].qty  += qtyCheck;
            }
            if(shopping.cart.idCircuit=="undefined")
            	shopping.checkoutObj.total+=data.price*data.countQuantity;
            else
            	shopping.checkoutObj.total+=data.price*data.countQuantity*shopping.cart.bookingFor;
        });
        return itemHtml;
    },
    
    getViewItem:function(key, data, type){
        itemId=key;
        itemType=type;
        subType=null;
        if(data.type != "undefined")
            subType=data.type;
        // View for products without reservations
        if(typeof data.reservations =="undefined"){
        	if(typeof shopping.cart.idCircuit == "undefined"){
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
	        } else
	        	incQtt="<span class='showDetail showDetail"+key+"' data-value='"+key+"''><i class='fa fa-2x fa-angle-down'></i></span>";
        }else
            incQtt="<span class='showDetail showDetail"+key+"' data-value='"+key+"''><i class='fa fa-2x fa-angle-down'></i></span>";
        // View detail reservations
        // Quantity systeme for circuit and specific user travel (desactivated)
        if(typeof shopping.cart.idCircuit == "undefined"){
        	quantityShop=data.countQuantity;
        	priceHT=data.price*data.countQuantity
        	priceTTC=data.price*data.countQuantity;
        }
        else{
        	quantityShop=data.countQuantity*shopping.cart.bookingFor;
        	priceHT=data.price*data.countQuantity*shopping.cart.bookingFor;
        	priceTTC=data.price*data.countQuantity*shopping.cart.bookingFor;
        }
        itemHtml="<div class='col-md-12 contentProduct contentProduct"+itemId+" text-left'>"+
                "<div class='col-md-2 no-padding'>"+data.imgProfil+"</div>"+
                "<div class='col-md-4'>"+
                    "<h4 class='text-dark'>"+data.name+"</h4>"+
                    "<span>Quantity booked : "+quantityShop+"</span><br>";
                if(typeof data.description != "undefined" && data.description != "")
            itemHtml += "<div class='description'>"+data.description+"</div><br>";
            //itemHtml += "<a href='javascript:;' class='letter-blue-5' onclick='alert(\"What's the quoi???\")'> Save / Update</a>"+
            itemHtml +=   "</div>"+
                "<div class='col-md-2 text-center'><span>"+priceHT+" €</span></div>"+
                "<div class='col-md-1 text-center no-padding'>"+incQtt+"</div>"+
                "<div class='col-md-2 text-center'><span>"+priceTTC+" €</span></div>"+
                "<div class='col-md-1 text-center'><span>";
                if(typeof shopping.cart.idCircuit == "undefined")
            itemHtml += "<a href='javascript:;' class='letter-lightgray' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\");'><i class='fa fa-trash fa-2x'></i></a></span>";
        	itemHtml += "</span></div>";
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
                                if(typeof shopping.cart.idCircuit == "undefined"){
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
	                            }else
	                            	 incQtt=value.countQuantity+" sessions"+s+" at this date";
            itemHtml +=         "<span class='pull-left text-center col-md-3 col-sm-3 col-xs-3'>"+incQtt+"</span>";
            					if(typeof shopping.cart.idCircuit == "undefined"){
            itemHtml +=            	"<div class='pull-right'>"+
                                    	"<a href='javascript:;' class='text-red' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\",\""+date+"\");'>"+
                                        "<i class='fa fa-trash'></i> Remove this date</a>"+
                                	"</div>";
                                }
            itemHtml +=     "</div>";
                            
                        if(typeof value.hours != "undefined"){
                            //countSession=Object.keys(value.hours).length;
                            //s=(countSession > 1) ? "s" : "";
                            //itemHtml += "<span>"+countSession+" session"+s+"</span><br/>";
                            $.each(value.hours, function(key, hours){
                                s=(hours.countQuantity > 1) ? "s" : "";
                                if(typeof shopping.cart.idCircuit == "undefined"){
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
	                            }else{
	                            	 s=(shopping.cart.bookingFor > 1) ? "s" : "";
	                            	incQtt = "session booked for "+shopping.cart.bookingFor+" person"+s;
	                            }
            itemHtml +=         "<div class='col-md-12 col-sm-12 col-xs-12 margin-bottom-5 padding-5 contentHoursSession'>"+
                                    "<h4 class='col-md-4 col-sm-4 col-xs-3 no-padding no-margin'><i class='fa fa-clock-o'></i> "+hours.start+" - "+hours.end+"</h4>"+
                                    "<span class='col-md-5 col-sm-5 col-xs-6 text-center'>"+incQtt+"</span>";
                                    if(typeof shopping.cart.idCircuit == "undefined"){
            itemHtml +=                 "<div class='pull-right'>"+
                                        	"<a href='javascript:;' class='text-red' onclick='shopping.removeInCart(\""+itemId+"\", \""+itemType+"\",true,\""+subType+"\",\""+date+"\",\""+hours.start+"\",\""+hours.end+"\");'>"+
                                            	"<i class='fa fa-times'></i>"+
                                        	"</a>"+
                                    	"</div>";
                                    }
            itemHtml +=         "</div>";
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
        shopping.totalCart=0;
        htmlCart = "", htmlCheckout = '';
        if(shopping.cart.countQuantity > 0 ){
            cartview = shopping.generateCartView();
            htmlCart = cartview.cart;
            htmlCheckout = cartview.checkout;
        }
        else {
            htmlCart = shopping.generateEmptyCartView();
            htmlCheckout = "";
        }

        $(".contentCart").html(htmlCart);
        $(".contentCheckout").html(htmlCheckout);

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
        	totalPrice : shopping.totalCart,
	        currency : "EUR"
        };
        orderItem=new Object;

        if(typeof shopping.cart.idCircuit != "undefined"){
        	order.circuit=shopping.cart.idCircuit;
        }
        if(typeof shopping.cart.idCircuit != "undefined"){
        	order.bookingFor=shopping.cart.bookingFor;
        }
        if(typeof shopping.cart.name != "undefined"){
        	order.name=shopping.cart.name;
        }
        if(typeof shopping.cart.backup != "undefined"){
        	order.backup=shopping.cart.backup;
        }
        
        $.each(shopping.cart,function(e,v){
            if(e=="countQuantity")
                order.countOrderItem=v;
            else if(e=="services"){
                $.each(v, function(cat, listByCat){
                    $.each(listByCat, function(key, data){
                    	if(typeof shopping.cart.idCircuit == "undefined"){
                    		quantityByItem=data.countQuantity;
                    		priceByItem=data.price * data.countQuantity;
                    		reservationsByItem=data.reservations;
                    	}
                    	else{
                    		quantityByItem=data.countQuantity*shopping.cart.bookingFor;
                    		priceByItem=data.price * data.countQuantity*shopping.cart.bookingFor;
                    		reservationsByItem=data.reservations;
                    		$.each(reservationsByItem, function(i,v){
                    			reservationsByItem[i].countQuantity=v.countQuantity*shopping.cart.bookingFor;
                    			if(typeof v.hours != "undefined"){
                    				$.each(v.hours, function(key,hour){
                    					reservationsByItem[i].hours[key].countQuantity=hour.countQuantity*shopping.cart.bookingFor;
                    				});
                    			}
                    		});

                    	}
                        orderItem[key]={
                            orderedItemType : e,
                            quantity : quantityByItem,
                            price : priceByItem,
                            reservations : reservationsByItem
                        };
                    });
                });
            }else if(e=="products"){
                $.each(v, function(key, data){
                    orderItem[key]={
                        orderedItemType : e,
                        quantity : data.countQuantity,
                        price : (data.price*data.countQuantity)
                    };
                });
            }
        });
        order.orderItems=orderItem;
        
        if(typeof order.name == "undefined"){
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
	                        shopping.init();
                    		localStorage.removeItem("shoppingCart");
	                        urlCtrl.loadByHash("#page.type.citoyens.id."+userId+".view.history");
	                    }
	                    else
	                        toastr.error(data.msg);  
	                  },
	                  dataType: "json"
	                });
	                console.log(order);
	            }
	        });
	    }else{
	    	$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/order/save", 
				data: order,
				success: function(data){
				if(data.result) {
				    toastr.success(data.msg);
				    shopping.init();
                    localStorage.removeItem("shoppingCart");
				    urlCtrl.loadByHash("#page.type.citoyens.id."+userId+".view.history");
				    //urlCtrl.loadByHash("#checkout");
				}
				else
				    toastr.error(data.msg);  
				},
				dataType: "json"
            });
	    }
    },
    saveCart:function(){
    	if(typeof shopping.cart.backup !="undefined"){
    		params={
    			id : shopping.cart.backup,
    			totalPrice : shopping.totalCart,
	            object : shopping.cart
	        };
    		$.ajax({
              type : "POST",
              url : baseUrl+"/"+moduleId+"/backup/update", 
              data : params,
              success: function(data){
                if(data.result) {
                    toastr.success(data.msg);
                    shopping.cart={countQuantity:0};
                    localStorage.removeItem("shoppingCart");
                    urlCtrl.loadByHash("#page.type.citoyens.id."+userId+".view.backup");
                }
                else
                    toastr.error(data.msg);  
              },
              dataType: "json"
	        });
    	}else{
	        bootbox.prompt({
	            title: "Give a name to the saving cart:", 
	            value : "Backup of "+moment(new Date()).format('DD-MM-YYYY HH:MM'), 
	            callback : function(result){ 
	                params={
	                	name:result,
	                	type:"shoppingCart",
	                	totalPrice:shopping.totalCart,
	                	currency:"EUR",
	                	object:shopping.cart
	                };
	                $.ajax({
	                  type: "POST",
	                  url: baseUrl+"/"+moduleId+"/backup/save", 
	                  data: params,
	                  success: function(data){
	                    if(data.result) {
	                        toastr.success(data.msg);
	                        shopping.cart={countQuantity:0};
	                        localStorage.removeItem("shoppingCart");
	                        //if(reload)
	                        urlCtrl.loadByHash("#page.type.citoyens.id."+userId+".view.backup");
	                    }
	                    else
	                        toastr.error(data.msg);  
	                  },
	                  dataType: "json"
	                });
	            }
	        })
	    }
    },
    restartBackup : function(obj,idBackup){
    	shopping.cart=obj;
		shopping.cart.backup=idBackup;
		shopping.countShoppingCart("init");
		localStorage.setItem("shoppingCart",JSON.stringify(shopping.cart));
		smallMenu.openAjaxHTML( baseUrl+'/'+moduleId+"/person/shoppingcart");
	}
}
