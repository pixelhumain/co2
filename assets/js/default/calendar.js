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
            eventBackgroundColor: '#FFA200',
            textColor: '#fff',
            events : calendarObject,
            eventLimit: true,
            timezone : 'local',
            eventRender:function(event, element, view) {
              console.log("event",event,"element",element);
              popupHtml=calendar.popupHtml(event);
              element.popover({
                  html:true,
                  animation: true,
                  container:'body',
                  title: event.name,
                  placement: 'top',
                    trigger: 'focus',
                  content: popupHtml,
              });
              element.attr('tabindex', -1);
              //element.find(".fc-content").css("background-color", calendar.templateColor[event.type]);
            },
            /*eventClick : function(calEvent, jsEvent, view) {
                //show event in subview
                dateToShow = calEvent.start;
                urlCtrl.loadByHash("#page.type.events.id."+calEvent._id);
            }*/
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
  	},
    popupHtml : function(data){
      var popupContent = "<div class='popup-calendar'>";
  
      var color = "orange";
      var ico = 'calendar';
      var imgProfilPath =  assetPath + "/images/thumb/default_events.png";
      if(typeof data.profilMediumImageUrl !== "undefined" && data.profilMediumImageUrl != "") 
        imgProfilPath =  baseUrl + data.profilMediumImageUrl;
      var icons = '<i class="fa fa-'+ ico + ' text-'+ color +'"></i>';
      
      var typeElement = "events";
      var icon = 'fa-calendar';

      var onclick = "";
      var url = '#page.type.'+typeElement+'.id.'+data.id;
      onclick = 'urlCtrl.loadByHash("'+url+'");';

        popupContent += "<div class='item_map_list popup-marker' id='popup"+id+"'>";
      popupContent += "<div class='main-panel'>"
                    +   "<div class='col-md-12 col-sm-12 col-xs-12'>"
                    +      "<div class='thumbnail-profil' style='max-height: 150px;text-align: -webkit-center; overflow-y: hidden;background-color: lightgray;'><img src='" + imgProfilPath + "' class='popup-info-profil-thumb img-responsive'></div>"           
                    +      "<div class='ico-type-account'>"+icons+"</div>"          
                    +   "</div>"
                    +   "<div class='col-md-12 col-sm-12 col-xs-12'>";
          
      if("undefined" != typeof data.title)
        popupContent  +=  "<div class='info_item pseudo_item_map_list' style='width:100% !important;'>" + data.title + "</div>";
      
     /* if("undefined" != typeof data['tags'] && data['tags'] != null){
        popupContent  +=  "<div class='info_item items_map_list'>";
        var totalTags = 0;
        if(data['tags'].length > 0){
          $.each(data['tags'], function(index, value){ 
            totalTags++;
            if(totalTags<4)
              popupContent  +=  "<div class='tag_item_map_list'>#" + value + " </div>";
          });
        }
        popupContent  +=  "</div>";
      }*/
      popupContent += "</div>";
      //Short description
      if ("undefined" != typeof data['shortDescription'] && data['shortDescription'] != "" && data['shortDescription'] != null) {
        popupContent += "<div id='pop-description' class='popup-section'>"
                + "<div class='popup-subtitle'>Description</div>"
                + "<div class='popup-info-profil'>" + data['shortDescription'] + "</div>"
              + "</div>";
      }
      //Contacts information
  //    popupContent += this.getPopupContactsInformation(data);
      //address
//      popupContent += this.getPopupAddressInformation(data);

      popupContent += '</div>';

        
        popupContent += displayStartAndEndDate(data);
                popupContent += "<a href='"+url+"' onclick='"+onclick+"' class='lbh'>";
      popupContent += '<div class="btn btn-sm btn-more col-md-12"><i class="fa fa-hand-pointer-o"></i> en savoir +</div>';
      popupContent += '</a>';

      return popupContent;
    }
}