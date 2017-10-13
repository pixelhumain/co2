<?php 
	$cssAnsScriptFilesTheme = array(
	    //Full calendar
	    '/plugins/fullcalendar/fullcalendar/fullcalendar.css',
	    '/plugins/fullcalendar/fullcalendar/fullcalendar.min.js',
	    '/plugins/fullcalendar/fullcalendar/locale/fr.js'
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>

<style>
	#showCalendar { display: block; float: none; }
	#calendar{width:100%;  }
	#lastEvent{ width:100%;    padding: 0px;    clear: none;  }
	.lastEventPadding{    width: 100%;  }
	.imgEvent{    width: 100%;    height: 200px;  }
	.imgEvent img{  	width: 100%;  	height: 100%;  }
	.imgEvent i{ 	margin-bottom: auto; 	margin-top: auto; }
	#dropBtn{    display: none;  }
	#orgaDrop a, #orgaDrop ul{    width: 100%;  }
	.panel-transparent {    background: none;  }
	.fc-event-inner{  	padding-left: 5px;  	border-radius : 5px;  }
	.fc-event .fc-event-title::before, .event-category::before{  	color: white;  }
	.fc-grid th{  	text-align: center;  	color: black;  }
	#sectionNextEvent{  	clear:none;  }
	.fc-popover .fc-content{  	color:white;   }
	.fc-content{  	cursor: pointer;  }
	.fc button{	height: 3em;}
	.fc-event, #event-categories .event-category {
	    background: #ccc none repeat scroll 0 0 !important;
	    border: 1px solid #e8e9ec !important;
	    color: #000 !important;
	    }
	#modal-available{
	   	background-color: rgba(0,0,0,0.5);
	}
	#modal-available .modal-dialog{
		width: 80%;
		margin-left: 10%;
	}
	.spec-available-fc{
		    background-color: #EF5B34;
	    width: 87%;
	    float: left;
	    margin: 10px 2% !important;
	    border-radius: 5px;
	    text-align: center;
	    color: white;
	    font-size: 15px !important;
	    text-transform: uppercase;
	    padding: 0px 5px;
	}
	.fc-past {
  		background: #d0d0d0;
	}
	.fc-event{
		background-color: transparent !important;
		border-color: transparent !important;
		color:#2C3E50 !important;
	}
	.fc-content{
		background-color: transparent !important;
		border-color: transparent !important;
		color:#2C3E50 !important;
	}
	.fc-content > button{
		width: 90%;
		height: inherit;
	}
</style>
<!-- *** SHOW CALENDAR *** -->
<div class="modal fade" id="modal-available" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content col-md-12">
			<div class="modal-header">
			</div>
			<div class="modal-body">
				<div class="row no-padding bg-light">
					<div id="showCalendar" class="col-md-12">
					  	<div class="row">
							<div class="panel panel-white">
						    	<div class="panel-body boder-light">
						    		<div id="calendar"></div>
						    	</div>
					    	</div>
					  	</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  var element=<?php echo json_encode($element); ?>;
  var templateColor = ["#93be3d", "#eb4124", "#0073b0", "#ed553b", "#df01a5", "#b45f04", "#2e2e2e"];
  var dateToShow, calendar, $eventDetail, eventClass, eventCategory;
  var widgetNotes = $('#notes .e-slider'), sliderNotes = $('#readNote .e-slider'), $note;
  var oTable, contributors;
  var subViewElement, subViewContent, subViewIndex;
  var tabOrganiser = [];
  var openingHours=element.openingHours;
  jQuery(document).ready(function() {
      showCalendar();

      $(window).on('resize', function(){
  			$('#calendar').fullCalendar('destroy');
  			showCalendar();
  		});
      $(".fc-button").on("click", function(e){
      	setCategoryColor(tabOrganiser);
     	})
      
  });

//creates fullCalendar
function buildCalObj(eventObj) {
  //entries for the calendar
  /*var taskCal = null;

  if(eventObj.startDate && eventObj.startDate != "") {
    var startDate = moment(eventObj.startDate).local();
    var endDate = null;
    if(eventObj.endDate && eventObj.endDate != "" ) {
      endDate = moment(eventObj.endDate).local();
    }
    mylog.log("Start Date = "+startDate+" // End Date = "+endDate);
    
    var organiser = "";
    if("undefined" != typeof eventObj["links"] && "undefined" != typeof eventObj.links["organizer"]){
      $.each(eventObj.links["organizer"], function(k, v){
      	if($.inArray(k, tabOrganiser)==-1){
      		tabOrganiser.push(k);
      	}
        organiser = k;
      })
    }

    var organizerName = eventObj.name;
    if(eventObj.organizer != ""){
    	organizerName = eventObj.organizer +" : "+ eventObj.name;
    }

    mylog.log(organiser);
    taskCal = {
      "title" : organizerName,
      "id" : eventObj['_id']['$id'],
      "content" : (eventObj.description && eventObj.description != "" ) ? eventObj.description : "",
      "start" : startDate.format(),
      "end" : ( endDate ) ? endDate.format() : startDate.format(),
      "startDate" : eventObj.startDate,
      "endDate" : eventObj.endDate,
      "className": organiser,
      "category": organiser
    }
    if(eventObj.allDay )
      taskCal.allDay = eventObj.allDay;
    mylog.log(taskCal);
  }
  return taskCal;*/
}

function showCalendar() {
	//mylog.info("addTasks2Calendar",events);//,taskCalendar);
	hiddenDays=[];
	calendar = [];
	$.each(openingHours, function(e,v){
		if(v!=""){
			if(typeof v.hours !="undefined"){
				$.each(v.hours,function(i,value){
					startTime=value.opens;
					endTime=value.closes;
					if(value.closes=="00:00")
						value.closes="24:00";
					calendar.push({
    					//title:"My repeating event",
    					quantity:element.quantity,
    					start: value.opens, // a start time (10am in this example)
    					end: value.closes,
    					startTime:startTime,
    					endTime:endTime,
    					 // an end time (2pm in this example)
    					dow: [ e ] // Repeat monday and thursday
					});
				});
			}else{
				calendar.push({
    					//title:"My repeating event",
    					allDay:true,
    					quantity:element.quantity,
    					dow: [ e ] // Repeat monday and thursday
				});
			}
		}
	});
	
	/*if(events){
	$.each(events,function(eventId,eventObj)
	{
	  eventCal = buildCalObj(eventObj);
	  if(eventCal)
	    calendar.push( eventCal );
	});
	}*/
	mylog.log(calendar);
	dateToShow = new Date();
	$('#calendar').fullCalendar({
	header : {
			left : 'prev,next',
			center : 'title',
			right : 'today, month, agendaWeek, agendaDay'
	},
	lang : 'fr',
	year : dateToShow.getFullYear(),
	month : dateToShow.getMonth(),
	date : dateToShow.getDate(),
	editable : false,
	events : calendar,
	eventColor: '#EF5B34',
	eventBackgroundColor: '#EF5B34',
	textColor: '#fff',
	//eventOrder:["start","end"],
	hiddenDays:hiddenDays,
	eventLimit: true,
	timezone : 'local',
	//allDaySlot : false,
	//defaultDate:momment(),
	eventLimitText:"sessions",
	dayRender: function(date, cell){
        if (date > dateToShow){
            $(cell).addClass('disabled');
        }
    },
	<?php 
	if(@$defaultView){?>
	  defaultView: '<?php echo $defaultView?>',
	<?php } ?>
	eventRender: function(event, element) {
		if(event.start < Date.now()) { return false; }
	    element.find(".fc-event-title").remove();
	    element.find(".fc-event-time").remove();
	    hoursRender="All day<br/>";
	    if(typeof event.start !="undefined" && !event.allDay){
	    	hoursRender=moment(event.start).format("HH:mm") + ' - '
	        + moment(event.end).format("HH:mm") + '<br/>';
	    }
	    var new_description =   
	        //+ event.quantity + '<br/>'
	        hoursRender
	        + 'Disponible: ' + event.quantity + '<br/>'
	        +'<button class="btn bg-orange">Book</button>'
	    ;
	    element.find(".fc-content").html(new_description);
	},
	eventClick : function(calEvent, jsEvent, view) {
	  //show event in subview
	  console.log(calEvent);
	  	alert('Event: ' + calEvent.start);
        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        alert('View: ' + view.name);
        //data={}
        //addTo
        // change the border color just for fun
        //$(this).css('border-color', 'red');
	  //dateToShow = calEvent.start;
	  //urlCtrl.loadByHash("#event.detail.id."+calEvent._id);
	}
	});

	setCategoryColor(tabOrganiser);
	dateToShow = new Date();
};

function setCategoryColor(tab){
	$(".fc-content").css("color", "white");
	$(".fc-content").addClass("text-center");
	$(".fc-more").addClass("spec-available-fc");
  	//$(".fc-content").css("background-color", "#EF5B34");
  	//for(var i =0; i<tab.length; i++){
  	//	$("."+tab[i]+" .fc-content").css("color", "white");
  	//	$("."+tab[i]+" .fc-content").css("background-color", templateColor[i]);
  	//}
}

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
</script>