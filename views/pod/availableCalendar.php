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
		<div class="modal-content col-md-12 col-sm-12 col-xs-12" style="margin-top: 75px;">
			<div class="modal-body no-padding">
				<div class="row no-padding bg-light">
					<div id="showCalendar" class="col-md-12 col-sm-12 col-xs-12">
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
  var itemType="<?php echo $type; ?>";
  var itemId=element._id.$id;
  var subType=null;
  if(typeof element.type !="undefined")
  	subType=element.type;
  var templateColor = ["#93be3d", "#eb4124", "#0073b0", "#ed553b", "#df01a5", "#b45f04", "#2e2e2e"];
  var dateToShow, $eventDetail, eventClass, eventCategory;
  var widgetNotes = $('#notes .e-slider'), sliderNotes = $('#readNote .e-slider'), $note;
  var oTable, contributors;
  var subViewElement, subViewContent, subViewIndex;
  var tabOrganiser = [];
  var openingHours=element.openingHours;
  var monthLoad=[];
  var allBookings=[];
  var availableCal = [];
  jQuery(document).ready(function() {
      showCalendar();

      $(window).on('resize', function(){
  			$('#calendar').fullCalendar('destroy');
  			showCalendar();
  		});
      $(".fc-button").on("click", function(e){
      	setCategoryColor(tabOrganiser);
     	});
      //if(!inArray(month,monthLoad)){
    			//alert("getAjaxMonth");
    			//monthLoad.push(month);
    			//data={"id":itemId,"type":itemType,"start":start,"end":end}
    			$.ajax({
					type: "POST",
					url: baseUrl+"/"+moduleId+"/orderitem/get", 
					data:{"id":itemId,"type":itemType,"start": new Date()},
				  success: function(data){
					if(data.result) {
						if(Object.keys(data.items).length > 0){
							$.each(data.items,function(e,v){
								$.each(v.reservations,function(i,resa){
									allBookings.push(resa);
								});
							});
						}
						console.log(data.items);
					}
			        else
			        	toastr.error(data.msg);  
				  },
				  dataType: "json"
				});
    		//}
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
	
	//$.ajax({});
	$.each(openingHours, function(e,v){
		if(v!=""){
			if(typeof v.hours !="undefined"){
				$.each(v.hours,function(i,value){
					startTime=value.opens;
					endTime=value.closes;
					if(value.closes=="00:00")
						value.closes="24:00";
					availableCal.push({
    					//title:"My repeating event",
    					capacity:element.capacity,
    					start: value.opens, // a start time (10am in this example)
    					end: value.closes,
    					startTime:startTime,
    					endTime:endTime,
    					quantity:0,
    					 // an end time (2pm in this example)
    					dow: [ e ] // Repeat monday and thursday
					});
				});
			}else{
				availableCal.push({
    					//title:"My repeating event",
    					allDay:true,
    					capacity:element.capacity,
    					quantity:0,
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
	mylog.log(availableCal);
	if(typeof specificDays != "undefined"){}
	else
		dateToShow = new Date();
	console.log(dateToShow);
	//alert(dateToShow.getFullYear());
	//alert(dateToShow.getMonth());
	//alert(dateToShow.getDate());
	$('#calendar').fullCalendar({
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
		events : availableCal,
		eventColor: '#EF5B34',
		eventBackgroundColor: '#EF5B34',
		textColor: '#fff',
		//eventOrder:["start","end"],
		hiddenDays:hiddenDays,
		eventLimit: true,
		timezone : 'local',
		//allDaySlot : false,
		defaultDate:dateToShow,
		eventLimitText:"sessions",
		dayRender: function(date, cell){
	        if (date > dateToShow){
	            $(cell).addClass('disabled');
	        }
	    },
		//defaultView: 'month',
		viewRender: function(view, element) {
    		console.log(view.start,view.end, view.intervalStart, view.intervalEnd);
    		/*month=view.start.format('MM');
    		start=view.start.format('YYYY-MM-DD');
    		end=view.end.format('YYYY-MM-DD');
    		
    		alert($('#calendar').fullCalendar('getDate'));*/
		},
		eventRender: function(event, element) {
			if(event.start < Date.now()) { return false; }
		    element.find(".fc-event-title").remove();
		    element.find(".fc-event-time").remove();
		    hoursRender="All day<br/>";
		    if(typeof event.start !="undefined" && !event.allDay){
		    	hoursRender=moment(event.start).format("HH:mm") + ' - '
		        + moment(event.end).format("HH:mm") + '<br/>';
		    }

		    
		    if(circuit.obj.show){
		    	currentInCircuit=circuit.getDayFilter(event);
		    	hideRemove="";
		    	hideAdd="";
		    	if(currentInCircuit)
		    		hideAdd="hide";
		    	else
		    		hideRemove="hide";
		    		var new_description=hoursRender+'<a href="javascript:;" class="btn bg-red remove-session '+hideRemove+'"><i class="fa fa-minus"></i></a>';
		    		 	new_description+='<a href="javascript:;" class="btn btn-success add-session '+hideAdd+'"><i class="fa fa-plus"></i></a>';
		    }else{
		    	currentCartFilter=shopping.getDayFilter(event);
			   	if(typeof event.filtered == "undefined"){
				    event.capacity=event.capacity-currentCartFilter.quantity-currentCartFilter.myQuantity;
				    event.filtered=true;
				}
			    event.quantity=currentCartFilter.myQuantity;
			    classQuantity="";
			    if(event.quantity==0)
			    	classQuantity="hide";
		    	var new_description =   
			        hoursRender
			        + 'Disponible: <span class="inc-capacity">' + event.capacity + '</span><br/>'
			        +'<a href="javascript:;" class="letter-orange remove-session hide"><i class="fa fa-minus"></i></a>'
			        +'<span class="eventCountItem margin-left-5 margin-right-5">'
	                    +'<i class="fa fa-shopping-cart"></i>'
	                    +'<span class="inc-session '+classQuantity+' topbar-badge badge animated bounceIn badge-transparent badge-success">'+event.quantity+'</span>'
	                +'</span>'
			        +'<a href="javascript:;" class="letter-orange add-session"><i class="fa fa-plus"></i></a>';
			}
		    element.find(".fc-content").html(new_description); 

		    element.find(".remove-session").on('click', function (e) {
		    	if(circuit.obj.show){
		    		circuit.removeEvent(element, event);
		    	}else{
		    		shopping.removeEvent(element, event);
		    	}
        		
    		});
    		element.find(".add-session").on('click', function (e) {
    			if(circuit.obj.show){
		    		circuit.addEvent(element, event);
		    	}else{
		    		shopping.addEvent(element, event);
		    	}
        		
    		});
		}
	});
	
	setCategoryColor();
};
function setCategoryColor(tab){
	$(".fc-content").css("color", "white");
	$(".fc-content").addClass("text-center");
	$(".fc-more").addClass("spec-available-fc");
	$(".fc-more").find(".fc-content").addClass("text-center");
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