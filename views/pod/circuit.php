<?php 

  HtmlHelper::registerCssAndScriptsFiles( 
    array(
        '/css/calendar.css',
    ) , 
  Yii::app()->theme->baseUrl. '/assets');
 $cssAnsScriptFilesModule = array(
    '/js/default/calendar.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

  $cssAnsScriptFilesTheme = array(
    '/plugins/fullcalendar/fullcalendar/fullcalendar.min.js',
    '/plugins/fullcalendar/fullcalendar/fullcalendar.css', 
    '/plugins/fullcalendar/fullcalendar/locale/'.Yii::app()->language.'.js',
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>
<style type="text/css">
	#circuit .headerTitleStanalone{
		left:-25px;
		right:-25px;
        top:0px !important;
	}
	#circuit .contentOnePage{
		/*min-height:700px;*/
		margin-top: 80px !important;
	}
	.contentOnePage .title > h2{
		    padding: 15px 0px;
    text-transform: inherit;
    font-size: 20px;
	}
	.contentCircuit{
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
        /*display:none;*/
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

   #circuit .description{
    max-height: 60px;
    overflow: hidden;
    color:grey;
   }

   #openModal .container,
   #openModal .modal-content{
     padding:0px!important;
   }

   .modal-open-footer{
    display: none;
   }

   footer{
    margin-top:50px;
   }

   .associated{
      margin-top: 100px;
   }

</style>
<div id="circuit">
    <?php if(!@$viewRender){ ?> 
    <div class="headerTitleStanalone">
        <div class='col-md-6 no-padding'>
            <span id="circuitNameHeader" name="circuitNameHeader"></span>
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 contentOnePage">
    <?php } ?>
      <div class="circuitsInfo shadow2 col-md-12 col-sm-12 col-xs-12 no-padding text-center">
        <h2 id="name"></h2>
        <span id="description" class="text-dark"></span><br/>
        <span id="capacity">Capacity : <span class="capacityValue"></span></span><br/>
        <span id="frequency">Frequency : <span class="frequencyValue"></span></span>
        <h3 id="total">Total of circuit per person : <span class="totalValue"></span> €</h3>
        <div class='col-md-12 col-sm-12 col-xs-12 btn-cart margin-top-20 margin-bottom-20 no-padding text-center'>
          <?php if(!@$manage){ ?>
            <a href='#activities' class='letter-blue lbh'>
                <?php echo Yii::t("common","Continue cart") ?>
              </a>
              <a href='javascript:;' onclick='circuit.backup();' class='btn bg-orange col-md-4 col-sm-4 col-md-offset-2 col-sm-offset-2 col-xs-10 col-xs-offset-1'>
                <i class='fa fa-floppy-o'></i> <?php echo Yii::t("common","Backup") ?>
              </a>
              <a href='javascript:;' onclick='circuit.save();' class='btn btn-success col-md-4 col-sm-4 col-xs-10 col-xs-offset-1'>
                <i class='fa fa-check'></i><?php echo Yii::t("common","Save")?>
              </a>
          <?php }else if($manage=="backup"){ ?>
            <a href="javascript:;" id="goBackToThisCart" class="btn btn-success col-md-4 col-sm-4 col-md-offset-2 col-sm-offset-2 col-xs-10 col-xs-offset-1" data-id="<?php echo @$backup ?>">
              <i class="fa fa-ravelry"></i> <?php echo Yii::t("common","Continue this cart") ?>
            </a>
            <a href="javascript:;" id="deleteBackup" class="btn btn-danger col-md-4 col-sm-4 col-xs-10 col-xs-offset-1" data-id="<?php echo @$backup ?>">
              <i class="fa fa-trash"></i> <?php echo Yii::t("common","Delete") ?>
            </a>
          <?php }else if($manage=="admin"){ ?>
            <a href="javascript:alert('pourtoi rapha, edit information circuits')" class="btn btn-default" data-id="<?php echo @$backup ?>"><i class="fa fa-pencil"></i> <?php echo Yii::t("common","Edit infos") ?></a>
            <a href="javascript:alert('go to circuit.obj to continue building cart si pas de résa')" class="btn btn-default" data-id="<?php echo @$backup ?>">
              <i class="fa fa-ravelry"></i> <?php echo Yii::t("common","Update circuit") ?>
            </a>
            <a href="javascript:alert('delete this circuit if no résa');" class="btn btn-danger">
              <i class="fa fa-trash"></i> <?php echo Yii::t("common","Delete") ?>
            </a>
          <?php }else if($manage=="buy"){ ?>
              <span class="text-dark">Choose the quantity</span><br/>
              <div class="col-md-6 col-sm-6 col-md-offset-4 col-sm-offset-4 col-xs-10 col-xs-offset-1 margin-bottom-20">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $object["capacity"] ?>" id='bookingFor' class="form-control"/>
              </div>
              <a href='javascript:;' class='btn bg-orange col-md-6 col-sm-6 col-md-offset-4 col-sm-offset-4 col-xs-10 col-xs-offset-1 convertToShoppingCart'>
                <i class='fa fa-shopping-cart'></i> <?php echo Yii::t("terla","Buy this circuit") ?>
              </a>
          <?php } ?>
        </div>
      </div>
    	<div class="contentCalendarCircuit shadow2 col-md-12 col-sm-12 col-xs-12 no-padding text-center">
      </div>
      <div class="contentCircuit shadow2 col-md-12 col-sm-12 col-xs-12 no-padding text-center">
    	</div>
    <?php if(!@$viewRender){ ?>
    </div>
    <?php } ?>
</div>

<?php 
  if(!@$viewRender){
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.'; 
    $this->renderPartial($layoutPath.'footer', array("subdomain"=>"page"));
  } 
?>
<script type="text/javascript">
    var totalCircuit=0;
    <?php if(@$object){ ?>
      var circuitObj=<?php echo json_encode($object) ?>;
    <?php }else{ ?>
      var circuitObj=circuit.obj;
    <?php } ?>
    var openDetails=[];
    var eventsCircuit=[];
	jQuery(document).ready(function() {	
        //if(typeof params.name != "undefined" && params.name != "")
      initBtnLink();
      //circuit.obj.total=0;
      $(".convertToShoppingCart").click(function(){
        bookingFor=$("#bookingFor").val();
        circuit.goToShoppingCart(circuitObj,bookingFor);
      });
      htmlCart = "";
      if(circuitObj.countQuantity > 0 ){
      	circuitView = circuit.generateCircuitView(circuitObj);
        htmlCircuit = circuitView.circuit;
      } else {
      	htmlCircuit=circuit.generateEmptyCircuitView();
      }
      circuit.initHeaderCircuit(circuitObj);
      $(".contentCircuit").html(htmlCircuit);
      if(notEmpty(eventsCircuit)){
        startCal=null;
        //if(typeof circuit.obj.start != "undefined")
          //startCal=circuit.obj.start;
        calendar.showCalendar(".contentCalendarCircuit", eventsCircuit, "agendaWeek",startCal);
        if(typeof circuitObj.start != "undefined"){
          $(".contentCalendarCircuit").fullCalendar("gotoDate", moment(circuitObj.start));
        }
        $(window).on('resize', function(){
          $(".contentCalendarCircuit").fullCalendar('destroy');
          calendar.showCalendar(".contentCalendarCircuit", eventsCircuit, "agendaWeek",startCal);
          if(typeof circuitObj.start != "undefined")
            $(".contentCalendarCircuit").fullCalendar("gotoDate", moment(circuitObj.start));
        });
      }
//      bindCartEvent();
    });
    
    function bindCartEvent(){
        /*$(".showDetail").off().on("click",function(){
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
        });*/
    }
</script>