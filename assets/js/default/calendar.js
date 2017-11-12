var calendar = {
    init : function(domCal){
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
    templateColor : {
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

    //creates fullCalendar
    buildCalObj: function(eventObj) {
        //entries for the calendar
        console.log("eventcaleanr",eventObj);
        var taskCal = null;
        if(eventObj.startDate && eventObj.startDate != "") {
            if(typeof eventObj.startDateDB != "undefined")
              var startDate = moment(eventObj.startDateDB).local();
            else
              var startDate = moment(eventObj.startDate).local();
            var endDate = null;
            if(eventObj.endDate && eventObj.endDate != "" ){
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
            taskCal = {
                "title" : eventObj.name,
                "id" : eventObj['_id']['$id'],
                "content" : (eventObj.description && eventObj.description != "" ) ? eventObj.description : "",
                "start" : startDate.format(),
                "end" : ( endDate ) ? endDate.format() : startDate.format(),
                "startDate" : eventObj.startDate,
                "endDate" : eventObj.endDate,
                "className": organiser,
                "category": organiser,
                "type": eventObj.typeEvent,
                "description":eventObj.description,
                "shortDescription": eventObj.shortDescription,
                "adresse": eventObj.cityName,
                //"adresse": eventObj.cityName,
                "links":eventObj.links,
            }
            if(eventObj.allDay )
                taskCal.allDay = eventObj.allDay;
            mylog.log(taskCal);
        }
        return taskCal;
    },
    showCalendar : function (domElement, events) {
        calendarObject = [];
        console.log("showEvent",events);
        if(events){
            $.each(events,function(eventId,eventObj){
                eventCal = calendar.buildCalObj(eventObj);
                if(eventCal)
                    calendarObject.push( eventCal );
            });
        }
        mylog.log(calendar);
        dateToShow = new Date();
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
            editable : false,
            events : calendarObject,
            eventLimit: true,
            timezone : 'local',
            eventRender:function(event, element, view) {
              console.log("event",event,"element",element);
              element.find(".fc-content").css("background-color", calendar.templateColor[event.type]);
            },
            eventClick : function(calEvent, jsEvent, view) {
                //show event in subview
                dateToShow = calEvent.start;
                urlCtrl.loadByHash("#page.type.events.id."+calEvent._id);
            }
        });
        calendar.setCategoryColor(calendar.tabOrganiser);
        dateToShow = new Date();
    },
    setCategoryColor : function(tab){
  		  $(".fc-content").css("color", "white");
  	  	for(var i =0; i<tab.length; i++){
  	  	  	$("."+tab[i]+" .fc-content").css("color", "white");
            $("."+tab[i]+" .fc-content").css("background-color", calendar.templateColor[i]);
  	  	}
  	},
  	getRandomColor : function() {
  	    var letters = '0123456789ABCDEF'.split('');
  	    var color = '#';
  	    for (var i = 0; i < 6; i++ ) {
  	        color += letters[Math.floor(Math.random() * 16)];
  	    }
  	    return color;
  	}
}