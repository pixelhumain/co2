var checkoutObj = {};
function addToShoppingCart(id, type, subType, ranges){
	incCart=true;
	if(typeof userId != "undefined" && userId != ""){
		params = {
			name : element.name,
			price : element.price,
			countQuantity : 1,
			providerId : element.parentId,
			providerType : element.parentType
		};
		if(typeof element.imgProfil != "undefined")
			params.imgProfil = element.imgProfil;	
		if(typeof element.description != "undefined")
			params.description = element.description;
		if(typeof element.capacity != "undefined")
			params.capacity = element.capacity;
		if(notNull(subType))
			params.type = subType;

		if(typeof shoppingCart[type] == "undefined")
			shoppingCart[type] = new Object;
		if(type=="services" ){
			if(typeof shoppingCart[type][subType]=="undefined")
				shoppingCart[type][subType] = new Object;

			if(typeof shoppingCart[type][subType][id]=="undefined")
				shoppingCart[type][subType][id]=params;
			else { 
				shoppingCart[type][subType][id]["countQuantity"]++;
				incCart=false;
			}
			if(typeof ranges != "undefined" && notNull(ranges)){
				if(typeof shoppingCart[type][subType][id]["reservations"] == "undefined")
				 	shoppingCart[type][subType][id]["reservations"] = new Object;

				if(typeof shoppingCart[type][subType][id]["reservations"][ranges.date] == "undefined"){
					shoppingCart[type][subType][id]["reservations"][ranges.date] = {"countQuantity":1};
				} else {
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
			countShoppingCart(true);
		//console.log("element",mapElements[id]);
	}else{
		$('#modalLogin').modal("show");
	}
}
function removeFromShoppingCart(id, type, deleteAll, subType, ranges){
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
			countShoppingCart(false);
	}else{
		$('#modalLogin').modal("show");
	}
}
function countShoppingCart(pos){
	//total=0;
	//$.each(shoppingCart, function(k, v){
	//	total+=v.length;
	//});
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
}