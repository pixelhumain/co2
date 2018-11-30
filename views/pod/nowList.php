<?php 
    $cssAnsScriptFilesTheme = array(
        "/plugins/bootstrap-slider/src/js/bootstrap-slider.js",
        "/plugins/bootstrap-slider/src/css/bootstrap-slider.min.css",
       /* "/plugins/bootstrap-slider/dependencies/js/highlight.min.js",
        "/plugins/bootstrap-slider/dependencies/css/highlightjs-github-theme.css",
        "/plugins/bootstrap-slider/dependencies/js/modernizr.js",*/

    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

    /*if(Yii::app()->session["userId"] != $element["_id"] &&
      !Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"]))
        echo "pouetttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt";
       // return;  

    echo Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"]) ? "yes" : "no";*/
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    $CO2DomainName = isset(Yii::app()->params["CO2DomainName"]) ? Yii::app()->params["CO2DomainName"] : "CO2";
?>

<style> 
    hr.angle-down::after {
        background-color: #e6344d;
    }
    hr.angle-down{
        border-color: #e6344d;
    }
    .el-nowList{
        cursor: pointer;
    }
    .populateAroundMe{
        max-height: 250px;
        overflow-y: scroll;
    }
    .populateAroundMe.text-explain{
        overflow-y: inherit;
        box-shadow: none !important;
    }
    #localActivity{
        position: absolute;
        right: 101%;
        display: none;
        min-width: 400px;
        /* height: auto; */
        top: 1px;
        background: white;
        border: 1px solid rgba(0,0,0,0.2);
        border-radius: 3px;
    }
    #localActivity .searchEntityContainer{
        width: 100% !important;
        padding: 0px;
        min-height: inherit;
        max-height: inherit;
        margin-bottom: 0px !important;
    }
    #ex1Slider{
        width: 90% !important;
        margin-left: 5%;
    }
    #ex1Slider .slider-selection{
        background: #e6344d !important;
    }
    #ex1Slider .slider-handle.round{
        background: linear-gradient(to bottom, #e6344d 13%, #e6344d 97%) repeat scroll 0 0 transparent;
            margin-top: -3px !important;
            height: 20px;
            width: 20px;
    }
     #ex1Slider .slider-tick.in-selection {
        background-image: -webkit-linear-gradient(top,#e6344d 0,#e6344d 100%);
        background-image: -o-linear-gradient(top,#e6344d 0,#e6344d 100%);
        background-image: linear-gradient(to bottom,#e6344d 0,#e6344d 100%);
    }
    .title-pod-now{
        font-size: 15px !important;
        font-weight: 800;
        margin-bottom: 10px !important;
        width: 100%;
        float: left;
    }
</style>

<?php if(empty($result) && !@Yii::app()->session["userId"]){ ?>
    <h4 class="text-dark text-center">
        Aucune donnée relative à votre communexion n'a été trouvée
    </h4>
<?php } ?>

<div class="col-xs-12 no-padding col-nowList"  data-tpl="pod.nowList">
	<?php
     if( (!@$scope || @$scope=="") && $open == true){ 
			if($type=="citoyens" && $id==@Yii::app()->session["userId"]){ 
			 $this->renderPartial($layoutPath.'pod.'.Yii::app()->params["CO2DomainName"].".notCommunected");
            } 
    ?>
    <?php } else { ?>
        <h6 class="no-margin header-nowList" style="font-size:13px">
         <!--   <i class="fa fa-cog letter-red hidden"></i> <i class="fa fa-bell"></i> 
            <?php echo Yii::t("common","Territorial activity") ?>

            <br>-->
            <small class="text-red title-pod-now"><i class="fa fa-home"></i> <span class="city-name-around"></span></small>
        </h6> 
        <div class="results-in-my-city margin-bottom-20">
        </div>
        <h6 class="no-margin header-nowList" style="font-size:13px">
        

            <small class="text-red title-pod-now"><i class="fa fa-street-view"></i> <?php echo Yii::t("common", "Around me") ?></small> <!--<?php echo $scope["name"]; ?>-->
        </h6>   
        <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0,5" data-slider-max="100" data-slider-step="1" data-slider-value="30" data-slider-ticks="[0, 100]" data-slider-ticks-snap-bounds="1" data-slider-ticks-labels='["0km", "100km"]'/>
        <!--<span id="ex6CurrentSliderValLabel">Current Slider Value: <span id="ex6SliderVal">5</span></span>-->
        <!--<hr class="angle-down">-->
        <center>
            <button class="btn btn-default btn-sm btn-show-onmap block" id="btn-show-activity-onmap">
                <i class="fa fa-map-marker"></i> <?php echo Yii::t("common","Show on the map") ?>
            </button>
        </center>
        <br>
        <!-- <hr class="margin-5 margin-bottom-10"> -->
        <div class="podAroundMeNow col-xs-12 no-padding">
            <div class="populateAroundMe shadow2">
            </div>
            <div id="localActivity" class="shadow2">
            </div>
        </div>
        <?php
       /* foreach ($result as $key => $v) { 

            $specs = Element::getElementSpecsByType(@$v["type"]);

            $type = null;
            if(@$specs) $type = @$v["type"];
            else if(@$v["typeSig"]) $type = $v["typeSig"];

            $class = "";
            $img = Element::getImgProfil($v, "profilThumbImageUrl", $this->module->assetsUrl);
            if(!@$v["profilMediumImageUrl"] || $v["profilThumbImageUrl"] == "") 
                $class = "no-img";
            //echo "class:".$class;
        ?>
        <!-- <a href="#page.type.<?php echo @$v["type"] ?>.id.<?php echo (@$v["_id"]?$v["_id"]:@$v["id"]); ?>"  -->

        <div class="shadow2 border-left-<?php echo @$specs["text-color"]?> margin-bottom-5 col-xs-12 no-padding el-nowList <?php echo $type?> <?php echo $class; ?>" data-type="<?php echo @$v["type"] ?>" data-id="<?php echo (@$v["_id"]?$v["_id"]:@$v["id"]); ?>">
            <div class="pull-left no-padding cnt-img">
                <div class="add2fav elemt_img">
                    <img src="<?php echo $img ?>" class="pull-left hidden-xs">
                </div>
            </div>
            <div class="pull-left elemt_name elipsis">
                <i class="fa fa-<?php echo $specs["icon"]?> text-<?php echo @$specs["text-color"]?>"></i> 
                <span class=""><?php echo $v["name"]; ?></span>
                
                <?php 
                $id = null;
                if(@$v["_id"])
                    $id = (string)@$v["_id"];
                else if(@$v["id"])
                    $id = $v["id"];
                //echo ($type) ? Element::getLink(@$type."s",$id) : "no type"; //echo @$type;?>
            </div><br>
            <div class="elemt_date pull-left text-left elipsis">
                <a href="#page.type.citoyens.id.<?php echo @$v["creator"]; ?>" class="lbh">
                    <i class="fa-user fa"></i>
                </a>
                <span class="dateTZ">
                    <?php echo @$v["updatedLbl"];?>
                    <?php if(@$v["price"]) echo " | <span class='text-azure'>" .@$v["price"].' '.@$v["devise"].'</span>';?> 
                </span> 
                <?php if(@$v["address"]["addressLocality"]) { ?>        
                <span class="address text-red">
                    <i class="fa fa-map-marker margin-left-5"></i> <?php echo @$v["address"]["addressLocality"]; ?> 
                </span>
                <?php } ?> 

                <?php //DDA : if( @$v["organizerType"] && @$v["organizerId"] ) echo "-".Element::getLink( @$v["organizerType"],@$v["organizerId"] )?>
                <?php //DDA : if( @$v["parentType"] && @$v["parentId"] ) echo ">".Element::getLink( @$v["parentType"],@$v["parentId"] )?>

                <?php //if( @$v["creator"] ) echo ">".Element::getLink( Person::COLLECTION,@$v["creator"] )?>
            </div>
        </div>
        <div class="previewLocalActivity hidden" id='localActivity<?php echo @$v["type"] ?><?php echo (@$v["_id"]?$v["_id"]:@$v["id"]); ?>'>
        </div>
        <?php }*/ ?>

    <?php } ?>
</div>

<?php if($CO2DomainName == "kgougle"){ 
        $this->renderPartial($layoutPath.'modals/'.Yii::app()->params["CO2DomainName"]."/citiesNC");
      } 
?>

<script type="text/javascript" >

var localActivity = <?php echo json_encode($result); ?>;
var userGeoloc=(typeof userConnected.geoPosition != "undefined" && typeof userConnected.geoPosition.coordinates != "undefined") ? userConnected.geoPosition.coordinates : null; 
jQuery(document).ready(function() {
    // With JQuery

  //  var slider = new Slider("");
    
    //slider.on("slide", function(sliderValue) {
        
        //document.getElementById("ex6SliderVal").textContent = sliderValue;
    //});
    mylog.log("LIVENOW", localActivity);
    mapElements = localActivity;
    $.each(localActivity, function(key, data){
        if(typeof data.geo != "undefined" && data.geo.latitude == "")
            mylog.log("LIVENOW geo", data.geo, data);
        mapElements[key].id = key;
    });
    if(myScopes.communexion != "undefined"){
        initCityView();
    }
    if(notNull(userGeoloc)){
        aroundMe(30);
        var slider = new Slider('#ex1', {
        //tooltip: 'always',
        ticks: [0.1, 100],
        ticks_labels: ['100m', '100km'],
           
        });
        slider.on("slideStop", function(sliderValue) {
            aroundMe(sliderValue);
        });
    }
    //needed to open preview
    
    // $(".elemt_date").each(function() {
    //     var elementTime = $(this).children(".dateTZ").attr("data-time");
    //     var elementDate = new Date(elementTime * 1000);
    //     $(this).children(".dateTZ").text(elementDate.toLocaleDateString() + " " + elementDate.toLocaleTimeString());
    // });
    
    $("#btn-show-activity-onmap").click(function(){
        Sig.showMapElements(Sig.map, localActivity, "clock-o", "Activité territoriale");
        showMap(true);
    });

    $(".btn-communecter").click(function(){
        communecterUser();
    });

    if(typeof contextData != "undefined" && notNull(contextData) && typeof contextData.address != "undefined" && typeof contextData.address.addressLocality != "undefined")
        $(".btn-change-loc").append(" - " + contextData.address.addressLocality);
});
function bindAroundEvent(){
     $(".el-nowList").mouseenter(function(){
        var id = $(this).data("id");
        var type = $(this).data("type");
        mylog.log("try open", id, type);
        var data = "";
        $.each(localActivity, function(key, value){
            if(key==id) data = Object.assign({}, value);
        });
        mylog.log("try open data", data);

        //$(".el-nowList").removeClass("hidden");
        //$(this).addClass("hidden");
        //$(".previewLocalActivity").addClass("hidden");
        //$(".previewLocalActivity").html("");
        
        if(data!=""){
            var html = directory.showResultsDirectoryHtml(new Array(data), type, true);
            mylog.log("try open html", html);
            $("#localActivity").html(html);
            $("#localActivity").show();
            $("#localActivity").removeClass("hidden");
            $("#localActivity, .podAroundMeNow").off().mouseleave(function(){
                $("#localActivity").hide();
            });
            bindLBHLinks();
            initBtnShare();
        }

    });
}
function initCityView(){
    if(typeof myScopes.communexion != "undefined" && Object.keys(myScopes.communexion).length>0){
        var level=0;
        var nameCommunexion="";
        searchQuery={
            "onlyCount":true,
            "countType":["citoyens", "NGO", "Group", "GovernmentOrganization", "LocalBusiness", "projects"],
            "locality": {},
            "count":true 
            //"type" : ["citoyens", "NGO", "projects", "news", "events"]
        };
        $.each(myScopes.communexion, function(e, v){
            if(v.type == "cities"){
                nameCommunexion=v.name;
                searchQuery.locality[e]=v;
                keyCommunexion=v.id;
            }
        });
        
        $.ajax({
            type: "POST",
            url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
            data: searchQuery,
            dataType: "json",
            error: function (data){
                 mylog.log(">>> error autocomplete search"); 
                 mylog.dir(data);   
                 $("#dropdown_search").html(data.responseText);  
                 //signal que le chargement est terminé
                loadingData = false;     
            },
            success: function(data){ 
                mylog.log(">>> success autocomplete search", data); //mylog.dir(data);
                if(!data){ 
                  toastr.error(data.content); 
                } 
                else 
                {
                    if(typeof data.count != "undefined" && Object.keys(data.count).length > 0){
                        $(".city-name-around").html(trad.In+" "+nameCommunexion);
                        html="";
                        total=0;
                        $.each(data.count, function(e, v ){
                            if(v > 0){
                                total+=v;
                                typeSearch= (e=="citoyens") ? "persons" : e;
                                urlSearch="#search?types="+typeSearch+"&scopeType=communexion&cities="+keyCommunexion;
                                colorBtn=(typeof typeObj[e].sameAs != "undefined") ? typeObj[typeObj[e].sameAs].color : typeObj[e].color; 
                                html+="<a href='"+urlSearch+"' class='lbh text-"+colorBtn+"'> <span class='badge bg-"+colorBtn+"'>"+v+"</span> "+trad[e]+"</a><br/>";
                            }
                        });
                        if(total == 0){
                            html='<h4 class="no-margin" style="font-size:13px">'+
                                '<small class="text-red"><i class="fa fa-map-o"></i> <?php echo Yii::t("home","Be the first to reference an element on your territory") ?>.</small>'+
                            '</h4>'+
                            '<br>'+
                            '<span style="font-family: 11px;">'+
                                '<i class="fa fa-creative-commons"></i> <?php echo Yii::t("home","You are the main protagonist to create its free and open map") ?>.'+
                                '<br>'+
                                '<i class="fa fa-magic"></i> <?php echo Yii::t("home","Reference your city hall, a NGO, a local business, a place or an initiative <b>you know around you</b>.")?><br>'+
                            '</span>';
                        
                        }
                        $(".results-in-my-city").html(html);
                        bindLBHLinks();
                    }
                }
            }
        });
    }
}
function aroundMe(dist){
    searchQuery={
            "searchType":["poi", "classifieds", "events"],
            "geoSearch" : getBoundingBox (userGeoloc, dist),
            "startDate": Math.floor((Date.now()) / 1000),
            "indexStep": 10
    };
    $.ajax({
            type: "POST",
            url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
            data: searchQuery,
            dataType: "json",
            error: function (data){
                 mylog.log(">>> error autocomplete search"); 
                 mylog.dir(data);   
                 $("#dropdown_search").html(data.responseText);  
                 //signal que le chargement est terminé
                loadingData = false;     
            },
            success: function(data){ 
                mylog.log(">>> success autocomplete search", data); //mylog.dir(data);
                if(!data){ 
                  toastr.error(data.content); 
                } 
                else 
                {
                    if(typeof data.results != "undefined" && Object.keys(data.results).length > 0){
                        populatePodAroudMe(data.results);
                        $("#btn-show-activity-onmap").show(700);
                        bindAroundEvent();
                    }else{
                        html='<h4 class="no-margin" style="font-size:13px">'+
                                '<small class="text-red"><i class="fa fa-rss"></i> <?php echo Yii::t("home","No activity around you. Be the first to show that your territory is moving") ?>.</small>'+
                            '</h4>'+
                            '<br>'+
                            '<span style="font-family: 11px;">'+
                                '<i class="fa fa-plus-circle"></i> <?php echo Yii::t("home","Add an event, a point of interest, a classified") ?>.'+
                                '<br><br>'+
                                '<i class="fa fa-magic"></i> <?php echo Yii::t("home","If nobody shares what he knows, nothing could be commonly bigger.")?><br>'+
                            '</span>';
                        $("#btn-show-activity-onmap").hide(700);
                        $(".populateAroundMe").html(html).addClass("text-explain");
                    }
                }
            }
        });
    
}
function populatePodAroudMe(results){
    str="";
    $.each(results, function(e,v){
        localActivity[e]=v;
        idEl=(typeof v._id !="undefined") ? v._id.$id : v.id; 
        typeElObj=(typeof typeObj[v.type].sameAs != "undefined") ? typeObj[typeObj[v.type].sameAs] : typeObj[v.type]; 
        $class = "";
        if(typeof v.profilThumbImageUrl == "undefined" || v.profilThumbImageUrl == "") {
            $img= assetPath+'/images/thumbnail-default.jpg';
            $class = "no-img";
        }else
            $img=baseUrl+v.profilThumbImageUrl;
        str+='<div class="shadow2 border-left-'+typeElObj.color+' margin-bottom-5 col-xs-12 no-padding el-nowList '+v.type+' '+$class+'" data-type="'+v["type"]+'" data-id="'+idEl+'">'+
                '<div class="pull-left no-padding cnt-img">'+
                    '<div class="add2fav elemt_img">'+
                        '<img src="'+$img+'" class="pull-left hidden-xs">'+
                    '</div>'+
                '</div>'+
                '<div class="pull-left elemt_name elipsis">'+
                    '<i class="fa fa-'+typeElObj.icon+' text-'+typeElObj.color+'"></i>'+ 
                    '<span class="">'+v.name+'</span>'+
                '</div><br>'+
                '<div class="elemt_date pull-left text-left elipsis">'
                    '<a href="#page.type.citoyens.id.'+v.creator+'" class="lbh">'+
                        '<i class="fa-user fa"></i>'+
                    '</a>'+
                    '<span class="dateTZ">'+
                        v["updatedLbl"];
                        if(typeof v.price != "undefined"){
                            str+= "| <span class='text-azure'>"+v.price;
                            if(typeof v.devise != "undefined")
                                str+=" "+v.devise;
                            str+="</span>";
                        }
                    str+="</span>"; 
                if(typeof v["address"]["addressLocality"] != "undefined")
                    str+='<span class="address text-red"><i class="fa fa-map-marker margin-left-5"></i> '+v.address.addressLocality+'</span>'; 
               str+='</div>';
                if(typeof v.geoPosition !="undefined" && typeof v.geoPosition.coordinates !="undefined" && notNull(userGeoloc)){
                    str+="<div class='elemt_date pull-left text-left elipsis'>"+
                            "<span><i class='fa fa-bullseye margin-left-5'></i> "+getDistance(userConnected.geoPosition.coordinates, v.geoPosition.coordinates)+"</span>"+
                        "</div>";
                    }
                   
                //'</div>'+
                //'<div class="previewLocalActivity hidden" id="localActivity'+v.type+idEl+'">'+
            str+='</div>';
    });
    $(".populateAroundMe").html(str).removeClass("text-explain");
}
function enlargeNow() { 
    if(!$(".col-feed.closed").length){
        $(".titleNowEvents .btnhidden").show();
        $("#enlargeNow").attr("class","fa fa-caret-right");
        $(".col-feed").attr("class","hidden col-feed closed");
        $(".col-updated").attr("class","col-xs-12 col-updated");
        $("#nowList").attr("class","col-xs-12 no-padding");
        $(".el-nowList").removeClass("col-xs-12").addClass('col-xs-3');
        
    } else {
        $(".titleNowEvents .btnhidden").hide();
        $("#enlargeNow").attr("class","fa fa-caret-left");
        $(".col-feed").attr("class","col-xs-12 col-md-9 col-feed");
        $(".col-updated").attr("class","col-xs-12 col-md-3 col-updated");
        $("#nowList").attr("class","col-xs-12 no-padding");
        $(".el-nowList").removeClass('col-xs-3').addClass("col-xs-12");
    }
}
function getDistance(origin, destination) {
    // return distance in meters
    var lon1 = toRadian(origin[1]),
        lat1 = toRadian(origin[0]),
        lon2 = toRadian(destination[1]),
        lat2 = toRadian(destination[0]);

    var deltaLat = lat2 - lat1;
    var deltaLon = lon2 - lon1;

    var a = Math.pow(Math.sin(deltaLat/2), 2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(Math.sin(deltaLon/2), 2);
    var c = 2 * Math.asin(Math.sqrt(a));
    var EARTH_RADIUS = 6371;
    distance=c * EARTH_RADIUS;
    if(distance<1){
        str="À "+(distance*1000)+" mètres";
    }else{
        str= "À "+Math.round(distance*100)/100+" Kms";
    }
    return str;
}
function toRadian(degree) {
    return degree*Math.PI/180;
}
/**
 * @param {number} distance - distance (km) from the point represented by centerPoint
 * @param {array} centerPoint - two-dimensional array containing center coords [latitude, longitude]
 * @description
 *   Computes the bounding coordinates of all points on the surface of a sphere
 *   that has a great circle distance to the point represented by the centerPoint
 *   argument that is less or equal to the distance argument.
 *   Technique from: Jan Matuschek <http://JanMatuschek.de/LatitudeLongitudeBoundingCoordinates>
 * @author Alex Salisbury
*/

function getBoundingBox (centerPoint, distance) {
  var MIN_LAT, MAX_LAT, MIN_LON, MAX_LON, R, radDist, degLat, degLon, radLat, radLon, minLat, maxLat, minLon, maxLon, deltaLon;
  if (distance < 0) {
    return 'Illegal arguments';
  }
  // helper functions (degrees<–>radians)
  Number.prototype.degToRad = function () {
    return this * (Math.PI / 180);
  };
  Number.prototype.radToDeg = function () {
    return (180 * this) / Math.PI;
  };
  // coordinate limits
  MIN_LAT = (-90).degToRad();
  MAX_LAT = (90).degToRad();
  MIN_LON = (-180).degToRad();
  MAX_LON = (180).degToRad();
  // Earth's radius (km)
  R = 6378.1;
  // angular distance in radians on a great circle
  radDist = distance / R;
  // center point coordinates (deg)
  degLat = centerPoint[0];
  degLon = centerPoint[1];
  // center point coordinates (rad)
  radLat = degLat.degToRad();
  radLon = degLon.degToRad();
  // minimum and maximum latitudes for given distance
  minLat = radLat - radDist;
  maxLat = radLat + radDist;
  // minimum and maximum longitudes for given distance
  minLon = void 0;
  maxLon = void 0;
  // define deltaLon to help determine min and max longitudes
  deltaLon = Math.asin(Math.sin(radDist) / Math.cos(radLat));
  if (minLat > MIN_LAT && maxLat < MAX_LAT) {
    minLon = radLon - deltaLon;
    maxLon = radLon + deltaLon;
    if (minLon < MIN_LON) {
      minLon = minLon + 2 * Math.PI;
    }
    if (maxLon > MAX_LON) {
      maxLon = maxLon - 2 * Math.PI;
    }
  }
  // a pole is within the given distance
  else {
    minLat = Math.max(minLat, MIN_LAT);
    maxLat = Math.min(maxLat, MAX_LAT);
    minLon = MIN_LON;
    maxLon = MAX_LON;
  }
  geoBox={
    latMinScope : minLat.radToDeg(),
    latMaxScope : maxLat.radToDeg(),
    lngMinScope : minLon.radToDeg(),
    lngMaxScope : maxLon.radToDeg()
  }
  return geoBox;
}
</script>