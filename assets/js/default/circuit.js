var circuit = {
	obj:{
			show:false,
			name:"",
			description:"",
			capacity:12,
			frequency:"",
			countQuantity:0,
			total : 0,
			services:{}
		},
	init:function(){
		return {
			show:false,
			name:"",
			description:"",
			capacity:12,
			frequency:"",
			countQuantity:0,
			total : 0,
			services:{}
		};
	},
	addToCircuit: function(id, type, ranges){
		incCart=true;
		if(typeof userId != "undefined" && userId != ""){
			//if(typeof circuit.obj[type] == "undefined")
			//	shopping.cart[type]=new Object;
			//if(type=="services" ){
			if(typeof circuit.obj.services[type]=="undefined")
				circuit.obj.services[type]=new Object;

			if(typeof circuit.obj.services[type][id]=="undefined"){
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
				if(notNull(type))
					params.type=type;
				circuit.obj.services[type][id]=params;
			}
			else{
				circuit.obj.services[type][id]["countQuantity"]++;
				incCart=false;
			}
			if(typeof ranges != "undefined" && notNull(ranges)){
				if(circuit.obj.frequency=="unique"){
					if(typeof circuit.obj.start == "undefined" || circuit.obj.start==""){
						circuit.obj.start=ranges.date;
						circuit.obj.end=ranges.date;
					}
					else if(moment(ranges.date).unix() < moment(circuit.obj.start).unix())
						circuit.obj.start=ranges.date;
					else if(moment(ranges.date).unix() > moment(circuit.obj.end).unix())
						circuit.obj.end=ranges.date;
				}
				if(typeof circuit.obj.services[type][id]["reservations"] == "undefined")
				 	circuit.obj.services[type][id]["reservations"]=new Object;

				if(typeof circuit.obj.services[type][id]["reservations"][ranges.date] == "undefined"){
					circuit.obj.services[type][id]["reservations"][ranges.date] = {"countQuantity":1};
				}else{
					circuit.obj.services[type][id]["reservations"][ranges.date]["countQuantity"]++;
					incCart=false;
				}
				if(typeof ranges.hours != "undefined"){
					ranges.hours.countQuantity=1;
					if(typeof circuit.obj.services[type][id]["reservations"][ranges.date]["hours"] == "undefined")
						circuit.obj.services[type][id]["reservations"][ranges.date]["hours"]=[];

					if(jQuery.isEmptyObject(circuit.obj.services[type][id]["reservations"][ranges.date]["hours"])){
						circuit.obj.services[type][id]["reservations"][ranges.date]["hours"].push(ranges.hours);
					}else{
						hoursInArray=false;
						$.each(circuit.obj.services[type][id]["reservations"][ranges.date]["hours"], function(e,v){
							if(v.start==ranges.hours.start && v.end==ranges.hours.end){
								circuit.obj.services[type][id]["reservations"][ranges.date]["hours"][e]["countQuantity"]++;
								hoursInArray=true;
							}
						});
						if(!hoursInArray)
							circuit.obj.services[type][id]["reservations"][ranges.date]["hours"].push(ranges.hours);
					}
				}
			}
			if(incCart)
				circuit.countCircuit(true);
			localStorage.setItem("circuit",JSON.stringify(circuit.obj));
		}else{
			$('#modalLogin').modal("show");
		}
	},
	removeFromCircuit:function(id, type, deleteAll, ranges){
		incCart=false;
		if(typeof userId != "undefined" && userId != ""){
			//if(type=="services" ){
				if(circuit.obj.services[type][id]["countQuantity"]==1 || (deleteAll && ranges==null)){
					delete circuit.obj.services[type][id];
					incCart=true;
				}else{
					if(!deleteAll)
						circuit.obj.services[type][id]["countQuantity"]--;
					if(typeof ranges != "undefined" && notNull(ranges)){
						console.log(ranges);
						if(deleteAll && typeof ranges.hours == "undefined"){
							removeQuantityDate=circuit.obj.services[type][id]["reservations"][ranges.date]["countQuantity"];
							delete circuit.obj.services[type][id]["reservations"][ranges.date];
						}else{
							if(circuit.obj.services[type][id]["reservations"][ranges.date]["countQuantity"]==1){
								delete circuit.obj.services[type][id]["reservations"][ranges.date];
							}else{
								if(!deleteAll)
									circuit.obj.services[type][id]["reservations"][ranges.date]["countQuantity"]--;
								if(typeof ranges.hours != "undefined"){
									$.each(circuit.obj.services[type][id]["reservations"][ranges.date]["hours"], function(e,v){
										if(typeof v != "undefined"){
											if(v.start==ranges.hours.start && v.end==ranges.hours.end){
												if(deleteAll){
													removeQuantityHours=circuit.obj.services[type][id]["reservations"][ranges.date]["hours"][e]["countQuantity"];
													circuit.obj.services[type][id]["reservations"][ranges.date]["hours"].splice(e,1);
												}else{
													if(v.countQuantity==1)
														circuit.obj.services[type][id]["reservations"][ranges.date]["hours"].splic(e,1);
													else
														circuit.obj.services[type][id]["reservations"][ranges.date]["hours"][e]["countQuantity"]--;
												}
											}
										}
									});
									if(typeof removeQuantityHours != "undefined"){
										circuit.obj.services[type][id]["reservations"][ranges.date]["countQuantity"]=circuit.obj.services[type][subType][id]["reservations"][ranges.date]["countQuantity"]-removeQuantityHours;
										circuit.obj.services[type][id]["countQuantity"]=circuit.obj.services[type][id]["countQuantity"]-removeQuantityHours;
										if(circuit.obj.services[type][id]["reservations"][ranges.date]["countQuantity"]==0){
											delete circuit.obj.services[type][id]["reservations"][ranges.date];
										}
										if(circuit.obj.services[type][id]["countQuantity"]==0){
											delete circuit.obj.services[type][id];
											incCart=true;
										}
									}
								}
							}
						}
						if(typeof removeQuantityDate != "undefined"){
							circuit.obj.services[type][id]["countQuantity"]=circuit.obj.services[type][id]["countQuantity"]-removeQuantityDate;
							if(circuit.obj.services[type][id]["countQuantity"]==0){
								delete circuit.obj.services[type][id];
								incCart=true;
							}
						}
					}
				}
			/*}else{
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
			}*/
			if(incCart)
				circuit.countCircuit(false);
			localStorage.setItem("circuit",JSON.stringify(circuit.obj));
		}else{
			$('#modalLogin').modal("show");
		}
	},
	addEvent : function($this,data){
		bookDate=data.start.format('YYYY-MM-DD');
		var ranges = new Object;
		ranges.date=bookDate;
		$this.find(".add-session").addClass("hide");
		$this.find(".remove-session").removeClass("hide");
		if(typeof data.allDay == "undefined" || !data.allDay)
			ranges.hours={start: data.startTime , end: data.endTime};		
        circuit.addToCircuit(itemId, subType, ranges);
        //availableCal.push(data);
	},
	removeEvent: function($this,data){
		bookDate=data.start.format('YYYY-MM-DD');
		//if(data.capacity > 0)
		$this.find(".remove-session").addClass("hide");
		$this.find(".add-session").removeClass("hide");
		/*$this.find(".add-session").off().on("click", function(){

		});*/
		var ranges = new Object;
		ranges.date=bookDate;
		if(typeof data.allDay == "undefined" || !data.allDay)
			ranges.hours={start: data.startTime , end: data.endTime};	
		//availableCal.push(data);	
        circuit.removeFromCircuit(itemId, subType, false, ranges);
	},
	getDayFilter : function(event){
		currentCartFilter=false;
		// GET QUANTITY OF CURRENT CART
		if(typeof circuit.obj.services != "undefined" 
			&& typeof circuit.obj.services[subType] != "undefined"
			&& typeof circuit.obj.services[subType][itemId] != "undefined"
			&& typeof circuit.obj.services[subType][id]["reservations"][event.start.format('YYYY-MM-DD')] != "undefined"){
			if(event.allDay==true){
				currentCartFilter=true;
			}else{
				if(typeof circuit.obj.services[subType][id]["reservations"][event.start.format('YYYY-MM-DD')]["hours"] != "undefined"){
					$.each(circuit.obj.services[subType][id]["reservations"][event.start.format('YYYY-MM-DD')]["hours"],function(e,v){
						if(v.start==event.startTime && v.end==event.endTime)
							currentCartFilter=true;			
					});
				}	
			}
		}
		return currentCartFilter;
	},
	countCircuit:function(pos){
		if(pos != "init"){
			if(pos)
				circuit.obj.countQuantity++;
			else
				circuit.obj.countQuantity--;
		}
		if(circuit.obj.show)
			$('.btn-circuit').removeClass('hide');
		else
			$('.btn-circuit').addClass('hide');
		if(circuit.obj.countQuantity > 0){
			$(".circuit-count").html(circuit.obj.countQuantity);
			$('.circuit-count').removeClass('hide');
			$('.circuit-count').addClass('animated bounceIn');
			$('.circuit-count').addClass('badge-success');
			$('.circuit-count').removeClass('badge-tranparent');
		}else{
			$('.circuit-count').addClass('hide');
			$('.circuit-count').removeClass('badge-success');
			$('.circuit-count').addClass('badge-tranparent');
		}
	},
	initHeaderCircuit : function(){ 
		$(".circuitsInfo #name").text(circuit.obj.name);
		$(".circuitsInfo #description").text(circuit.obj.description);
		$(".circuitsInfo #capacity .capacityValue").text(circuit.obj.capacity);
		$(".circuitsInfo #frequency .frequencyValue").text(circuit.obj.frequency);
		$(".circuitsInfo #total .totalValue").text(circuit.obj.total);
	},
	generateEmptyCircuitView:function(){
    	str="<span>Le circuit est vide</span><br/>"+
    			"<a href='#activities' class='btn bg-orange lbh'>Continue circuit</a>";
    	return str;
    },
    generateCircuitView:function(){
    	var htmls = circuit.getComponentsHtml(true);
    	//******************************************
		// CART
		//******************************************
    	str="<div class='col-md-12'>";
    		str+=htmls.strHtml;
    		str+="</div>";
    	return { circuit : str };
    },
    getComponentsHtml:function(firstLevel){
        var strHtml = "";
        $.each(circuit.obj.services,function(i,v){
            strHtml += circuit.getItemByCategory(i,v,"services");
        });
        return { "strHtml" : strHtml };
    },
    getItemByCategory:function(label,listItem, type){
    	typeHtml="";
    	if(Object.keys(listItem).length){
	        typeHtml="<div class='col-md-12 col-sm-12 col-xs-12 headerCategory margin-top-20 margin-bottom-10'>"+
	                "<h2 class='letter-orange mainTitle text-left' style='text-transform:uppercase;'>"+label+"</h2>"+
	        "</div>";
    	}
        $.each(listItem,function(e,data){
            typeHtml+=circuit.getViewItem(e, data, type);
            circuit.obj.total=circuit.obj.total+(data.price*data.countQuantity);
        });
        return typeHtml;
    },
    
    getViewItem:function(key, data, type){
        itemId=key;
        itemType=type;
        s=(data.countQuantity > 1) ? "s" : "";
        itemHtml="<div class='col-md-12 col-sm-12 col-xs-12 contentProduct contentProduct"+itemId+" text-left'>"+
                "<div class='col-md-3 col-sm-3 col-xs-3 no-padding text-center' style='line-height:120px;'>"+data.imgProfil+"</div>"+
                "<div class='col-md-7 col-sm-7 col-xs-7'>"+
                    "<h4 class='text-dark'>"+data.name+"</h4>"+
                    "<span>"+data.price+" € (for a session per person)</span><br>"+
                    "<span>"+data.countQuantity+" session"+s+" booked for this circuit</span><br>"+
                    "<span>"+(data.price*data.countQuantity)+" € (for all session per person)</span><br>";
                if(typeof data.description != "undefined" && data.description != "")
            itemHtml += "<div class='description'>"+data.description+"</div><br>";
                itemHtml +="</div>"+
                "<div class='col-md-2 col-sm-2 col-xs-2 text-center pull-right'><span> <a href='javascript:;' class='letter-lightgray' onclick='circuit.removeInCircuit(\""+itemId+"\", \""+itemType+"\",true,\""+data.type+"\");' style='line-height:120px;'><i class='fa fa-trash fa-2x'></i></a></span></div>";
                if(typeof data.reservations != "undefined"){
            itemHtml += "<div class='col-md-12 col-sm-12 col-xs-12 dateHoursDetail no-padding'>"; 
                    $.each(data.reservations, function(date, value){
                        dateStr=directory.getDateFormated({startDate:date}, true);
                        arrayDate=date.split("-");
            itemHtml += "<div class='col-md-12 col-sm-12 col-xs-12 bookDate"+date+" shadow2 margin-bottom-10'>"+
                            "<div class='col-md-12 col-sm-12 col-xs-12 dateHeader'>"+
                                "<h4 class='pull-left margin-bottom-5 no-margin col-md-5 col-sm-5 col-xs-5 no-padding'><i class='fa fa-calendar'></i> "+dateStr+"</h4>"+
                                "<div class='pull-right'>"+
                                    "<a href='javascript:;' class='text-red' onclick='circuit.removeInCircuit(\""+itemId+"\", \""+itemType+"\",true,\""+data.type+"\",\""+date+"\");'>"+
                                        "<i class='fa fa-trash'></i> Remove this date</a>"+
                                "</div>"+
                            "</div>";
                            
                        if(typeof value.hours != "undefined"){
                            $.each(value.hours, function(key, hours){
                                s=(hours.countQuantity > 1) ? "s" : "";
                                startHours=hours.start.split(":");
                        		endHours=hours.end.split(":");
                                newObject=new Object;
                        		newObject={
					        		"name":data.name,
					        		"typeEvent":"others",
					                "id" : key,
					                "description" : (data.description && data.description != "" ) ? data.description : "",
					               	"allDay" : false,
					                "type": "others",
					                "shortDescription": (data.description && data.description != "" ) ? checkAndCutLongString(data.description,120) : "",
					                "profilMediumImageUrl": "",
					                "imgProfil":data.imgProfil,
					                "adresse": "",  
					                "startDate":new Date(arrayDate[0],arrayDate[1]-1,arrayDate[2],startHours[0],startHours[1]),
					                "endDate":new Date(arrayDate[0],arrayDate[1]-1,arrayDate[2],endHours[0],endHours[1]),    
					        	};
                        		eventsCircuit.push(newObject);
            itemHtml +=         "<div class='col-md-12 col-sm-12 col-xs-12 margin-bottom-5 padding-5 contentHoursSession'>"+
                                    "<h4 class='col-md-4 col-sm-4 col-xs-3 no-padding no-margin'><i class='fa fa-clock-o'></i> "+hours.start+" - "+hours.end+"</h4>"+
                                    "<div class='pull-right'>"+
                                        "<a href='javascript:;' class='text-red' onclick='circuit.removeInCircuit(\""+itemId+"\", \""+itemType+"\",true,\""+data.type+"\",\""+date+"\",\""+hours.start+"\",\""+hours.end+"\");'>"+
                                            "<i class='fa fa-times'></i>"+
                                        "</a>"+
                                    "</div>"+
                                "</div>";
                            });
                        }else{
                        	newObject=new Object;
                        	newObject=new Object;
                        	newObject={
				        		"name":data.name,
				        		"typeEvent":"others",
				                "id" : key,
				                "description" : (data.description && data.description != "" ) ? data.description : "",
				               	"allDay" : true,
				                "type": "others",
				                "shortDescription": (data.description && data.description != "" ) ? checkAndCutLongString(data.description,120) : "",
				                "profilMediumImageUrl": "",
				                "imgProfil":data.imgProfil,
				                "adresse": "",  
				                "startDate":new Date(arrayDate[0],arrayDate[1]-1,arrayDate[2]),
				                "endDate":new Date(arrayDate[0],arrayDate[1]-1,arrayDate[2]),    
					        };
                        	eventsCircuit.push(newObject);
                        }
            itemHtml += "</div>"; 
                    }); 
            itemHtml += "</div>";
                }
        itemHtml += "</div>";
        return itemHtml;
    },
    removeInCircuit:function(id, type, deleteAll, subType, date, start, end){
        ranges=null;
        if(notNull(date)){
            ranges=new Object;
            ranges.date=date;
            if(notNull(start))
                ranges.hours={start: start , end: end};
        }
        circuit.removeFromCircuit(id, subType, deleteAll, ranges);
        circuit.reloadViewCircuit();
    },
    addInCart:function(id, type, subType, date, start, end){
        ranges=null;
        if(notNull(date)){
            ranges=new Object;
            ranges.date=date;
            if(notNull(start))
                ranges.hours={start: start , end: end};
        }
        circuit.addToCircuit(id, subType, ranges);
        circuit.reloadViewCircuit();
    },
    reloadViewCircuit:function(){
        circuit.obj.total=0;
        htmlCart = "";
        if(circuit.obj.countQuantity > 0 )
            html = circuit.generateCircuitView();
        else {
            html= circuit.generateEmptyCircuitView();
        }

        $(".contentCircuit").html(html.circuit);
        circuit.initHeaderCircuit();
        //bindCartEvent();
        initBtnLink();
        
        /*if(openDetails.length > 0){
            $.each(openDetails,function(i,v){
                $(".showDetail"+v).trigger("click");
            });   
        }*/
    },
    save:function(){
        delete circuit.obj.show;
        circuitParams = circuit.obj;
        $.ajax({
          type: "POST",
          url: baseUrl+"/"+moduleId+"/circuit/save", 
          data: circuitParams,
          success: function(data){
            if(data.result) {
                toastr.success(data.msg);
                circuit.obj=circuit.init();
       			localStorage.removeItem("circuit");
        		circuit.countCircuit("init");    
        
                urlCtrl.loadByHash("#admin.view.circuits");
            }
            else
                toastr.error(data.msg);  
          },
          dataType: "json"
        });
    
    },
    backup:function(){
    	var params = {
    		object: circuit.obj,
			type:"circuits"
    	};
    	if(typeof circuit.obj.backup !="undefined"){
    		params.id = circuit.obj.backup;
    		$.ajax({
              type : "POST",
              url : baseUrl+"/"+moduleId+"/backup/update", 
              data : params,
              success: function(data){
                if(data.result) {
                    toastr.success(data.msg);
                    circuit.obj=circuit.init();
                    localStorage.removeItem("circuit");
                    circuit.countCircuit("init");
                    urlCtrl.loadByHash("#admin.view.circuits");
                }
                else
                    toastr.error(data.msg);  
              },
              dataType: "json"
	        });
    	}else{
	        
            $.ajax({
              type: "POST",
              url: baseUrl+"/"+moduleId+"/backup/save", 
              data: params,
              success: function(data){
                if(data.result) {
                    toastr.success(data.msg);
            		circuit.obj=circuit.init();
            		localStorage.removeItem("circuit");
            		circuit.countCircuit("init");
            		urlCtrl.loadByHash("#admin.view.circuits");
                }
                else
                    toastr.error(data.msg);  
              },
              dataType: "json"
            });
	    }
    }
}
