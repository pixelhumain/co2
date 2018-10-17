var calendar = {
    init : function(domCal){
    	console.log(" calendar2 init ", domCal);
      $("#showHideCalendar").click(function(){
        if($(this).data("hidden")){
          $(this).html("<i class='fa fa-caret-up'></i> "+trad.showcalendar+"</a>");
          $(this).data("hidden",0);  
          $(domCal).show(700);
        }else{
          $(this).html("<i class='fa fa-caret-down'></i> "+trad.showcalendar+"</a>");
          $(this).data("hidden",1);
          $(domCal).hide(700);
        }
        
      });
      
        /*lazyLoad('/plugins/fullcalendar/fullcalendar/fullcalendar.min.js',
              '/plugins/fullcalendar/fullcalendar/fullcalendar.css', 
            null,false);
        lazyLoad( baseUrl+'/plugins/fullcalendar/fullcalendar/locale/'+mainLanguage+'.js',null,null,false);*/
    },
    bindEventCalendar : function(){
    	console.log(" calendar2 bindEventCalendar ");
      //var popoverElement;

      $('.popover').mouseenter(function(){
       // alert();
        $(this).hide();
     //   calendar.showPopup=false;
      });
      $('body').off().on('click', function (e) {
      // close the popover if: click outside of the popover || click on the close button of the popover
        //alert(e.target);
        if (typeof popoverElement != "undefined" && popoverElement 
          && ((!popoverElement.is(e.target) && popoverElement.has(e.target).length === 0 && $('.popover').has(e.target).length === 0) 
            || (popoverElement.has(e.target) && e.target.id === 'closepopover'))) {  
          
            // $('.popover').popover('hide'); --> works
           // if(calendar.showPopup)
           //alert("ici");
              calendar.closePopovers();
        }
      });
    },
    closePopovers : function() {
    	console.log(" calendar2 closePopovers ");
      calendar.showPopup=false;
      $('.popover').not(this).popover('hide');
    },
    templateRef : {
      "competition":"#ed553b",
      "concert" :"#b45f04",
      "contest":"#ed553b",
      "exhibition":"#b45f04",
      "festival":"#b45f04",
      "getTogether":"#eb4124",
      "market":"#df01a5",
      "meeting":"#eb4124",
      "course":"#df01a5",
      "workshop":"#eb4124",
      "conference":"#0073b0",
      "debate":"#0073b0",
      "film":"#2e2e2e",
      "crowdfunding":"#93be3d",
      "others":"#93be3d", 
    },
    events : [],
    //dateToShow, calendar, $eventDetail, eventClass, eventCategory,
    widgetNotes : $('#notes .e-slider'), 
    sliderNotes : $('#readNote .e-slider'), 
    //oTable, 
    //contributors,
    //subViewElement, subViewContent, subViewIndex,
    tabOrganiser : [],
    showPopup : false,
    //creates fullCalendar
    buildCalObj: function(eventObj) {
    	console.log(" calendar2 buildCalObj ", eventObj);
        //entries for the calendar
        //console.log(" calendar2 eventcaleanr",eventObj);
        var taskCal = null;
        if(eventObj.startDate && eventObj.startDate != "") {
            if(typeof eventObj.startDateCal != "undefined")
              var startDate = moment(eventObj.startDateCal).local();
            else if(typeof eventObj.startDateDB != "undefined")
              var startDate = moment(eventObj.startDateDB).local();
            else
              var startDate = moment(eventObj.startDate).local();
            var endDate = null;
            if(eventObj.endDate && eventObj.endDate != "" ){
                if(typeof eventObj.endDateCal != "undefined")
                  endDate = moment(eventObj.endDateCal).local();
                if(typeof eventObj.endDateDB != "undefined")
                    endDate = moment(eventObj.endDateDB).local();
                else
                    endDate = moment(eventObj.endDate).local();
            

                
            }
            mylog.log("Start Date = "+startDate+" // End Date = "+endDate);
            
            var organiser = "";
            if("undefined" != typeof eventObj["links"] && "undefined" != typeof eventObj.links["organizer"]){
                $.each(eventObj.links["organizer"], function(k, v){
                  	if($.inArray(k, calendar.tabOrganiser)==-1)
                        calendar.tabOrganiser.push(k);
                    organiser = k;
                })
            }
            var organizerName = eventObj.name;
            if(eventObj.organizer != "")
                organizerName = eventObj.organizer +" : "+ eventObj.name;
            console.log(" calendar2 eventObj", eventObj);
            taskCal = {
                "title" : eventObj.name + " : " + tradCategory[eventObj.typeEvent],
                "content" : (eventObj.description && eventObj.description != "" ) ? eventObj.description : "",
                "start" : startDate.format(),
                "end" : ( endDate ) ? endDate.format() : startDate.format(),
                "startDate" : eventObj.startDate,
                "endDate" : eventObj.endDate,
                "startDateDB" : eventObj.startDateDB,
                "endDateDB" : eventObj.endDateDB,
                 "allDay" : eventObj.allDay,
                "className": organiser,
                "category": organiser,
                "type": eventObj.typeEvent,
                "description":eventObj.description,
                "shortDescription": eventObj.shortDescription,
                "profilMediumImageUrl": eventObj.profilMediumImageUrl,
                "adresse": eventObj.cityName,
                //"adresse": eventObj.cityName,
                //"backgroundColor":calendar.templateColor[eventObj.typeEvent],
                "links":eventObj.links,
            }
            if(typeof eventObj.imgProfil != "undefined")
              taskCal.imgProfil=eventObj.imgProfil;
            if(typeof eventObj.id != "undefined")
              taskCal.id = eventObj.id;
            else
              taskCal.id = eventObj._id.$id;
            if(eventObj.allDay )
                taskCal.allDay = eventObj.allDay;
            //mylog.log(taskCal);
        }
        return taskCal;
    },
    showCalendar : function (domElement, events, initMode, initDate) {
    	console.log(" calendar2 showCalendar ", domElement, events, initMode, initDate);
        calendarObject = [];
        if(events){
            $.each(events,function(eventId,eventObj){
                eventCal = calendar.buildCalObj(eventObj);
                if(eventCal)
                    calendarObject.push( eventCal );
            });
        }

        if(typeof initDate != "undefined" && notNull(initDate) ){
          splitInit=initDate.split("-");
          dateToShow = new Date(splitInit[0], splitInit[1]-1, splitInit[2]);
        }
        else{
          initDate=null;
          dateToShow = new Date();
        }
        $(domElement).fullCalendar({
            header : {
            		left : 'prev,next',
            		center : 'title',
            		right : 'today, month, agendaWeek, agendaDay'
            },
            lang : mainLanguage,
            year : dateToShow.getFullYear(),
            month : dateToShow.getMonth(),
            date : dateToShow.getDate(),
            //gotoDate:moment(initDate),
            editable : false,
            eventBackgroundColor: '#FFA200',
            textColor: '#fff',
            defaultView: initMode,
            events : calendarObject,
            eventLimit: true,
            timezone : 'local',
            /*select: function (start, end, jsEvent) {
                closePopovers();
                popoverElement = $(jsEvent.target);
                $(jsEvent.target).popover({
                    title: 'the title',
                    content: function () {
                        return $("#popoverContent").html();
                    },
                    template: popTemplate,
                    placement: 'left',
                    html: 'true',
                    trigger: 'click',
                    animation: 'true',
                    container: 'body'
                }).popover('show');
            },*/
            eventClick: function (calEvent, jsEvent, view) {
            	console.log(" calendar2 eventClick ", calEvent, jsEvent, view);
              //closePopovers();
             // calendar.showPopup=true;
             popoverElement = $(jsEvent.currentTarget);
              
              
            },
            eventRender:function(event, element, view) {
                console.log(" calendar2 eventRender event",event,"element",element, "element", view);
                if(networkJson == "undefined"){
                    popupHtml=calendar.popupHtml(event);
                    element.popover({
                        html:true,
                        animation: true,
                        container:'body',
                        title: event.name,
                        template:calendar.popupTemplate(),
                        placement: 'top',
                        trigger: 'focus',
                        content: popupHtml,
                    });
                    element.attr('tabindex', -1);
                }
             


             // $("#popup"+event.id).mouseout(function(){
               // $(this).remove();
              //});
              //element.find(".fc-content").css("background-color", calendar.templateColor[event.type]);
            },
            /*eventClick : function(calEvent, jsEvent, view) {
                //show event in subview
                dateToShow = calEvent.start;
                urlCtrl.loadByHash("#page.type.events.id."+calEvent._id);
            }*/
        });
        calendar.setCategoryColor(calendar.tabOrganiser);
        calendar.bindEventCalendar();
        dateToShow = new Date();
    },
    setCategoryColor : function(tab){
      console.log(" calendar2 setCategoryColor ", tab);
  		  $(".fc-content").css("color", "white");
  	  	for(var i =0; i<tab.length; i++){
  	  	  	$("."+tab[i]+" .fc-content").css("color", "white");
            //$("."+tab[i]+" .fc-content").css("background-color", calendar.templateColor[i]);
  	  	}
  	},
  	getRandomColor : function() {
		console.log(" calendar2 getRandomColor ");
  	    var letters = '0123456789ABCDEF'.split('');
  	    var color = '#';
  	    for (var i = 0; i < 6; i++ ) {
  	        color += letters[Math.floor(Math.random() * 16)];
  	    }
  	    return color;
  	},
    popupTemplate : function(){
		console.log(" calendar2 popupTemplate ");
		template='<div class="popover" style="max-width:300px; no-padding" >'+
					'<div class="arrow"></div>'+
					'<div class="popover-header" style="background-color:red;">'+
					'<button id="closepopover" type="button" class="close margin-right-5" aria-hidden="true">&times;</button>'+
					'<h3 class="popover-title"></h3>'+
					'</div>'+
					'<div class="popover-content no-padding"></div>'+
					'</div>';
		return template;
    },
    popupHtml : function(data){
		console.log(" calendar2 popupHtml ", data);
      var popupContent = "<div class='popup-calendar'>";
  
      var color = "orange";
      var ico = 'calendar';
      var imgProfilPath =  assetPath + "/images/thumb/default_events.png";
      if(typeof data.profilMediumImageUrl !== "undefined" && data.profilMediumImageUrl != "") 
        imgProfilPath =  baseUrl + data.profilMediumImageUrl;
      var icons = '<i class="fa fa-'+ ico + ' text-'+ color +'"></i>!!!';
      
      var typeElement = "events";
      var icon = 'fa-calendar';

      var onclick = "";
      var url = '#page.type.'+typeElement+'.id.'+data.id;
      onclick = 'calendar.closePopovers();urlCtrl.loadByHash("'+url+'");';

      popupContent += "<div class='' id='popup"+data.id+"'>";
      popupContent += "<div class='main-panel'>"
                    +   "<div class='col-md-12 col-sm-12 col-xs-12 no-padding'>"
                    +      "<div class='thumbnail-profil' style='max-height: 200px;text-align: -webkit-center; overflow-y: hidden;background-color: #cccccc;'><img src='" + imgProfilPath + "' class='popup-info-profil-thumb img-responsive'></div>"      
                    +   "</div>"
                    +   "<div class='col-md-12 col-sm-12 col-xs-12 padding-5'>";
          
      if("undefined" != typeof data.title)
        popupContent  +=  "<div class='' style='text-transform:uppercase;'>" + data.title + "</div>";
      
      if(data.start != null){
        popupContent +="<div style='color:#777'>";
        startLbl="<i class='fa fa-calendar-o'></i> ";
        startDate=moment(data.start).format("DD MMMM YYYY"); 
        endDate="";
        hoursStr="<br/>";
        if(data.allDay)
          hoursStr+=tradDynForm.allday;
        else
          hoursStr+="<i class='fa fa-clock-o'></i> "+moment(data.start).format("H:mm");
        if(data.end != null){
          if(startDate != moment(data.end).format("DD MMMM YYYY")){
            startLbl+=trad.fromdate+" ";
            endDate=" "+trad.todatemin+" "+moment(data.end).format("DD MMMM YYYY");
          }
          if(!data.allDay)
            hoursStr+= " - "+moment(data.end).format("H:mm");
        }
        popupContent += startLbl+startDate+endDate+hoursStr;
        popupContent +="</div>";
      }
      popupContent += "</div>";
      //Short description
      if ("undefined" != typeof data['shortDescription'] && data['shortDescription'] != "" && data['shortDescription'] != null) {
        popupContent += "<div id='pop-description' class='popup-section'>"
                + "<div class='popup-info-profil'>" + data['shortDescription'] + "</div>"
              + "</div>";
      }
      //Contacts information
  //    popupContent += this.getPopupContactsInformation(data);
      //address
//      popupContent += this.getPopupAddressInformation(data);
     // popupContent += directory.getDateFormated(data,true);
   
      popupContent += '</div>';

        
        
                popupContent += "<a href='"+url+"' onclick='"+onclick+"' class='lbh'>";
      popupContent += '<div class="btn btn-sm btn-more col-md-12 col-sm-12 col-xs-12"><i class="fa fa-hand-pointer-o"></i> en savoir +</div>';
      popupContent += '</a>';

      return popupContent;
    }
}