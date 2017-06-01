<?php
$cs = Yii::app()->getClientScript();
//HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->request->baseUrl);

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header',
          array( "layoutPath"=>$layoutPath, 
            "page" => "thing") ); 

//tu auras "states":true si ta communexion est activée
//pour récupérer les valeurs de communexion tu a juste à faire ça : CO2::getCommunexionCookies();
//    $boardIds = Thing::getDistinctSCK("boardId");
//    $deviceIds= Thing::getDistinctSCK("deviceId");

$communexion = CO2::getCommunexionCookies();
//TODO : utiliser pour eviter l'utilisation à chaque page 
 /*       if($communexion["state"] == false){
          //$postalCode= " " ;
        }else{
          //$postalCode=$cpCommunexion;
        }
*/
$this->renderPartial($layoutPath.'breadcrum_communexion', array("type"=>@$type));
?>
<style>

.main-container{
  margin-top: 40px;
  padding-top: 40px;

}
#sub-menu-left{
    margin-top:1px;
    /*text-align: left;*/
}
#sub-menu-left .btn{
    /*background-color: #4285f4;
    border-color: #4285f4;*/
  /*color:white;*/
    /*border-radius:80px;*/
    font-weight: 700;
}
#sub-menu-left.subsub .btn{
  width:95%;    
  text-align: left;
  background-color: white;
  border-color: white;
  color:#4285f4;
}
#sub-menu-left.subsub{
  min-width: 180px;
}
#page #dropdown_thing{
  min-height:500px;
        /*margin-top:30px;*/
}
#page .row.headerDirectory{
  margin-top: 20px;
  display: none;
}
#page p {
  font-size: 13px;
}
.breadcrum-communexion{ 
    margin-top:25px;
}

.breadcrum-communexion .item-globalscope-checker{
    border-bottom:1px solid #e6344d;
}
.item-globalscope-checker.inactive{
    color:#DBBCC1 !important;
    border-bottom:0px;
    margin(top:-6px;)
}
.item-globalscope-checker:hover,
.item-globalscope-checker:active,
.item-globalscope-checker:focus{
    color:#e6344d !important;
    border-bottom:1px solid #e6344d;
    text-decoration: none !important;
}

.keycat:hover,
.keycat.active,
.btn-select-category-1:hover,
.btn-select-category-1.active{
  background-color: #2C3E50!important;
  color: #fff!important;
  border-color:transparent!important;
}


</style>

<div class="col-md-12 col-sm-12 col-xs-12 container bg-white no-padding shadow" id="content-thing" style="min-height:700px;">

	<div class="padding-5" id="page">
	<?php $thing = CO2::getContextList("thing"); ?>

		<div id="menu-section-thing" class="row col-xs-12 col-md-12 col-sm-12 text-center subsub">
			<h4 class="padding-10 letter-azure label-category col-md-3 col-sm-3 hidden-xs" id="title-menu-section">
				<i class="fa fa-object-group"></i> <span id="title-sub-thing">Objets CO2 </span> 
			</h4>
			<?php 
			$currentSection = 1;
			foreach ($thing["sections"] as $key => $section) { 
			    if(isset($section['active']) && $section['active']==true){
			    ?>
				    <div class="col-md-3 col-sm-4 col-xs-6 no-padding">
					    <button class="btn btn-default col-md-12 col-sm-12 padding-10 bold text-dark elipsis btn-select-type-anc" id="btn-thing-section-<?php echo @$section["key"]; ?>" 
					      data-type-anc="<?php echo @$section["label"]; ?>" data-key="<?php echo @$section["key"]; ?>" data-type="thing"
					      style="border-radius:0px; border-color: transparent; text-transform: uppercase;">
					      <i class="fa fa-<?php echo @$section["icon"]; ?> fa-2x"></i> <span class=""><?php echo @$section["label"]; ?></span>
					    </button>
				    </div>
			<?php }
			} ?>
			<hr class="col-md-12 col-sm-12 col-xs-12 no-padding" id="before-section-result">
		</div>
		<div class="row ">
			<div class="col-md-3 col-sm-3 col-xs-12 margin-top-15 text-right subsub thingFilters" id="sub-menu-left">
			<?php 
			//$thing = CO2::getContextList("thing");
			foreach ($thing as $key1 => $filters) {
				if(strpos($key1,"Filters")!=false){
					if (is_array($filters)) {
						foreach ($filters as $key => $action) { 
							if( ( empty($action["forAdmin"]) || $action["forAdmin"] != true || ( $action["forAdmin"]==true &&  Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ) ) && is_array($action) ) { ?>
								<button class="btn btn-default text-dark margin-bottom-5 btn-select-category-1 hidden btn-select-<?php echo @$action["key"]; ?>" style="margin-left:-5px;" data-keycat="<?php echo $key; ?>" data-section="<?php echo @$action["key"]; ?>" data-page="<?php echo @$action["page"]; ?>">
									<i class="fa fa-<?php echo @$action["icon"]; ?>"></i> <?php echo $action['label']; ?>
								</button>
								<div id="menu-keycat-<?php echo @$action["page"]; ?>" >
								<?php foreach ($action["subcat"] as $key2 => $action2) { ?>
									<button class="btn btn-default text-dark margin-bottom-5 margin-left-15 hidden keycat keycat-<?php echo $key; ?> btn-<?php echo @$action["key"]; ?>" data-categ="<?php echo $key; ?>" data-key="<?php echo @$action["key"]; ?>" data-key2="<?php echo $key2; ?>">
										<i class="fa fa-angle-right"></i> <?php echo $action2; ?>
									</button><br class="hidden">
								<?php } ?>
								</div>
							<?php 
							} 
						}
					} 
				}
			} ?>
			</div>
		<div class="col-sm-9 col-md-9 col-xs-12 " id="dropdown_thing"></div>
		</div>
	</div>    
</div>

<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?>

<script>
/*----------------------------- */
var alReady=false;
var section = "";
var classType = "";
var classSubType = "";
var pageReady=false;
var section="";
var sectionKey="";

var smartCitizenSelector = { 
  "Dernieres-Mesures" : [ "lastreading", [ "all" , "temp" , "hum" , "light" , "co" , "no2" , "noise" , "nets", "bat" , "pv" ]],  
  "Graphes" : [".chart_graph",[ ".dCOdb", ".dAPIsc" ]], 
  "Gestion-SCK" :[ "sck-maj",[ "sck-maj-principal", "sck-maj-secondaire" ]] 
};

jQuery(document).ready(function() {
    initKInterface({"affixTop":0});
    bindLeftMenuFilters();
    //active premiere section :
    activeFirst("menu-section-thing","btn-select-type-anc");
    //active premiere page 
    //activeFirst( "sub-menu-left", "btn-select-category-1");
    //communexion=<?php //echo json_encode($communexion); ?>;
  /*var postalCode=<?php //echo $postalCode ?>;
    mylog.log("communexion postalCode : ");
    mylog.log(postalCode);*/
    setTitle("Objets communectés","fa-database");

  });

function getpageSCK(viewsThing){ 

	$.ajax({
		type: "GET",
		url: baseUrl+'/'+moduleId+"/thing/"+viewsThing,
		success:function(data){
			alReady=true;
			setTimeout(function(){ alReady=false; }, 2000 );
			$("#dropdown_thing").html(data);
		},
		error:function(data){ mylog.log("Error : ajax not success");
			mylog.log(data); }
		}).done(function(){ 
			pageReady=true;
			activeFirst("menu-keycat-"+viewsThing,"keycat" );
		});
}

function getpageCOPI(viewsCopi){
	//todo pour les CO-PI ;
	$("#dropdown_thing").html("<h3> COPI (Vide actuellement) <h3> <p> Ici vous avez accès aux pages concernant les COPIs <p> ");
}

function bindLeftMenuFilters () { 

	$(".btn-select-type-anc").off().on("click", function(){   
		section = $(this).data("type-anc");
		sectionKey = $(this).data("key");

		$(".btn-select-type-anc, .btn-select-category-1, .keycat").removeClass("active");
		$(".keycat").addClass("hidden");
		$(".btn-select-category-1").addClass("hidden");
		$(".btn-select-"+sectionKey).removeClass("hidden");
		$(this).addClass("active");

		KScrollTo("#dropdown_thing");

		if( sectionKey == "smartCitizen"){
			$("#dropdown_thing").html("<h3> Smart-Citizen-Kit<h3> <p>Ici vous avez accès aux pages concernant les kits déclarés dans Communecter<p> ");   
		}else{
			$("#dropdown_thing").html("<h3> COPI (Vide actuellement) <h3> <p> Ici vous avez accès au pages concernant les COPIs <p> ");
		}
	//active le premier bouton de la page
	});

	$(".btn-select-category-1").off().on("click", function(){
		if (alReady==false) {
			$(".btn-select-category-1").removeClass("active");
			$(this).addClass("active");

			classType = $(this).data("keycat");
			var page = $(this).data("page");
			sectionKey = $(this).data("section");
			$("#title-menu-section").text(classType);

			$(".keycat").addClass("hidden");
			$(".keycat").removeClass("active");
			$(".keycat-"+classType).removeClass("hidden");   

			if(sectionKey=="smartCitizen") {
				getpageSCK(page); 
			}else{
				getpageCOPI(page);
			}
		}
	});

	$(".keycat").off().on("click", function(){

		$(".keycat").removeClass("active");
		$(this).addClass("active");
		var classSubType = $(this).data("keycat");

		classType = $(this).data("categ");
		var key2 = $(this).data("key2");
		mylog.log('classType : '+classType+' classSubType : '+classSubType+' key2 :'+key2);

		var toShow = smartCitizenSelector[classType][1][key2];
		var toHide = smartCitizenSelector[classType][0];

		if(classType=="Gestion-SCK"){
			$("."+toHide).addClass('hidden');
			$("#"+toShow).removeClass('hidden');
		}else if (classType=="Dernieres-Mesures") {
			keycatButton(classType, key2); // pour la page dernière mesure
		} else if(classType=="Graphes"){
			showHideChart(key2);
		}
	});
}

function activeFirst(inDivID,classToActivate ){
	var divWithBtn=document.getElementById(inDivID);
	divWithBtn.querySelector("."+classToActivate).click();
}

// Fonctions pour cacher et montrer 
function showAllReading(){ $(".reading").removeClass("hidden"); }

function showReading(divReading){ $("#"+divReading).removeClass("hidden"); }

function hideAllReading(){ $(".reading").addClass("hidden"); }

function hideReading(divReading){ $("#"+divReading).addClass("hidden"); }

function keycatButton (classType, value){
    hideAllReading();
    //$(".reading").addClass("hidden");
    //$(".reading").hide();
    var list=[];
    switch(value) {
		case 0: //temp et hum
			list.push(12,13);
			break;
		case 1: //co no2
			list.push(15,16);
			break;
		case 2: //lum
			list.push(14);
			break; 
		case 3: //bruit
			list.push(7);
			break;
		case 4: // nets
			list.push(21);
			break;
		case 5: //energie : batt et solarPV
			list.push(17,18);
			break;
		case 6:
			showAllReading();
			break;
    } 
	for(var s=0;s<list.length; s++){
		var divReading = "sensor-"+list[s];
		showReading(divReading);
		//$("#"+divReading).removeClass("hidden");
		//$("#"+divReading).show();
	}
}

</script>