<style>
.activity-image{
  width: 100%;
  height: 300px;
  overflow-y: hidden;
}
.activity-image img{
  min-width:100%;
  min-height: 100%;
}
.text-large{
  font-size: 16px;
}
.text-bold{
  font-weight: 700;
}
.activity-title{
  font-size: 20px;
}
.activity-heading{
position: absolute;
top: 255px;
left: 0px;
right: 0px;
background-color: rgba(250,250,250,0.8);
}
.text-xss{
  font-size:12px;
}
.settingsNews{
  margin:7px;
  color: #777;
}
.addMargin{
  margin-top: 50px !important;
}
#noMoreNews{
  position: absolute;
  bottom: -55px;
  font-size: 20px !important;
  left: 0px;
  right: 0px;
}
</style>
<?php 
  $timezone = "";// @$timezone ? $timezone : 'Pacific/Noumea';
  $pair = @$pair ? $pair : false;
  $nbCol = @$nbCol ? $nbCol : 2;
 //echo $nbCol;
  

   // var_dump($news);exit;
		foreach($news as $key => $media){ 
			$class = $pair || ($nbCol == 1) ? "timeline-inverted" : "";
			$pair = !$pair;
      // Author name and thumb
      //print_r($media);
      if(@$media["targetIsAuthor"]){   
          if(@$media["target"]["profilThumbImageUrl"] && $media["target"]["profilThumbImageUrl"] != "")
            $thumbAuthor = Yii::app()->createUrl('/'.$media["target"]["profilThumbImageUrl"]);
          else
            $thumbAuthor = $this->module->assetsUrl."/images/thumb/default_".$media["target"]["type"].".png";
          $nameAuthor=$media["target"]["name"];
          $authorType=$media["target"]["type"];
          $authorId=$media["target"]["id"];
      } else{
         $thumbAuthor =  @$media['author']['profilThumbImageUrl'] ? 
                      Yii::app()->createUrl('/'.@$media['author']['profilThumbImageUrl']) 
                      : @$imgDefault;
          $nameAuthor=@$media["author"]["name"];  
          $authorType=Person::COLLECTION;
          $authorId=@$media["author"]["id"];           
      }
      $srcMainImg = "";              
      if(@$media["media"]["images"] && $media["media"]["type"] != "gallery_images")
        $srcMainImg = Yii::app()->createUrl("upload/".
                                            Yii::app()->controller->module->id."/".
                                            $media["media"]["images"][0]["folder"].'/'.
                                            $media["media"]["images"][0]["name"]);


      if(@$media["imageBackground"])
        $srcMainImg = Yii::app()->createUrl($media["imageBackground"]);
	?>

  
  <li class="<?php echo $class; ?> list-news" id="news<?php echo $key ?>">
    <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip"></i></a></div>
    <div class="timeline-panel">
    <div id="newsTagsScope<?php echo $key ?>" class="col-md-12 col-sm-12 col-xs-12"></div>
      <?php $classHeading="";
      if(@$srcMainImg != "" && $media["type"] == "activityStream"){ $classHeading="activity-heading"; ?>
        <a class="inline-block bg-black activity-image" target="_blank" href="<?php echo @$media["href"]; ?>">
          <img class="img-responsive" src="<?php echo $srcMainImg; ?>" />
        </a>
      <?php } ?>
      <div class="timeline-heading text-center <?php echo $classHeading; ?>">
           	<h5 class="text-left srcMedia">
          	  <small>
                <img class="pull-left img-circle" src="<?php echo @$thumbAuthor; ?>" height=40>
                <div class="pull-left padding-5" style="line-height: 15px;">
                  <a href="#page.type.<?php echo $authorType ?>.id.<?php echo $authorId ?>" class="lbh pull-left"><?php echo @$nameAuthor; ?></a><br>
                  <span class="margin-top-5">
                  <?php if(@$media["type"]=="news") { ?>
                    <i class="fa fa-pencil-square"></i> a publié un message
                  <?php } ?>
                  <?php if(@$media["type"]=="activityStream") { ?>
                    <?php $iconColor = Element::getColorIcon($media["object"]["type"]) ? 
                                       Element::getColorIcon($media["object"]["type"]) : ""; ?>
                    <i class="fa fa-plus-circle"></i> a créé un 
                    <span class="text-<?php echo @$iconColor; ?>">
                      <?php echo Yii::t("common", @$media["object"]["type"]); ?>
                    </span>
                  <?php } ?>
                   <?php if(@$media["scope"] && @$media["scope"]["type"]){
                    if($media["scope"]["type"]=="public"){
                      $scopeIcon="globe";
                      $scopeTooltip =Yii::t("common","Visible to all and posted on the city's wall");
                    } 
                    else if ($media["scope"]["type"]=="restricted"){
                      $scopeIcon="connectdevelop";
                      $scopeTooltip= Yii::t("common","Visible to all on this wall and published on this network");
                    }else{
                      $scopeIcon="lock";
                      $scopeTooltip= Yii::t("common","Private view");
                    } ?>
                     <strong> • </strong>  <i class='fa fa-<?php echo $scopeIcon ?> tooltips margin-right-5' data-toggle='tooltip' data-placement='bottom' data-original-title='<?php echo $scopeTooltip ?>'></i>
                  <?php } ?>
                  </span>
                </div>
                
              </small>  
              <?php if (@Yii::app()->session["userId"]){ ?>
                  <div class="btn dropdown pull-right no-padding settingsNews">
                    <strong> • </strong> 
                    <a class="dropdown-toggle" type="button" data-toggle="dropdown" style="color:#8b91a0;">
                      <i class="fa fa-cog"></i>  <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                    <?php if (@$media["author"]["id"]==Yii::app()->session["userId"] || (@$canManageNews && $canManageNews)){ ?>
                      <li>
                        <a href="javascript:;" class="deleteNews" onclick="deleteNews('<?php echo $key ?>', $(this))" data-id="'<?php echo $key ?>"><small><i class="fa fa-times"></i> <?php echo Yii::t("common", "Delete")?></small></a></li>
                        <?php if (@$media["type"] != "activityStream" && @$media["author"]["id"]==Yii::app()->session["userId"]){ ?>
                          <li><a href="javascript:" class="modifyNews" onclick="modifyNews('<?php echo $key ?>')" data-id="<?php echo $key ?>"><small><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Update publication")?></small></a></li>
                        <?php }
                    } ?> 
                    <?php if (!@$media["reportAbuse"] || (@$media["reportAbuse"] && !@$media["reportAbuse"][@Yii::app()->session["userId"]])) { ?>
                        <li><a href="javascript:;" class="newsReport" onclick="newsReportAbuse(this,'<?php echo $key ?>')" data-id="<?php echo $key ?>"><small><i class="fa fa-flag"></i> <?php echo Yii::t("common", "Report an abuse")?></small></a></li>
                    <?php } ?>
                    </ul>
                  </div>
                  <?php } ?>
              <a href="javascript:;" target="_blank" class="link-read-media margin-top-10 hidden-xs img-circle pull-right">
                <small>
                  <i class="fa fa-clock-o"></i> 
                  <?php echo Translate::pastTime(date($media["created"]->sec), "timestamp", $timezone); ?>
                </small>

              </a>
            </h5>
          </div>
          <div class="timeline-body padding-10 col-md-12 text-left">
            <!-- <h4><a target="_blank" href="<?php echo @$media["href"]; ?>"><?php echo @$media["title"]; ?></a></h4> -->
            <div id="newsActivityStream<?php echo $key ?>" data-pk="<?php echo $key ?>" class="newsContent" ></div>
            <div id="newsContent<?php echo $key ?>" data-pk="<?php echo $key ?>" class="newsContent" ></div>
          </div>

          <?php if(@$srcMainImg != "" && $media["type"] != "activityStream"){ ?>
            <a class="inline-block bg-black" target="_blank" href="<?php echo @$media["href"]; ?>">
            <img class="img-responsive" src="<?php echo $srcMainImg; ?>" />
            </a>
          <?php } ?>


          <?php if(@$media["contentType"] == "youtube"){ ?>
          	<iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $media["idYoutube"]; ?>" frameborder="0" allowfullscreen></iframe>
          <?php } ?>
          <?php if(@$media["media"]){ ?>
            <div id="result<?php echo $key ?>" class="bg-white results col-sm-12"></div>
          <?php } ?>
      
      <div class="timeline-footer pull-left col-md-12 col-sm-12 col-xs-12 padding-top-5">
          <!-- <a class="btn-comment-media" data-media-id="<?php //echo $media["_id"]; ?>"><i class="fa fa-comment"></i> Commenter</a> -->
          <!-- <a><i class="glyphicon glyphicon-thumbs-up"></i></a>
          <a><i class="glyphicon glyphicon-share"></i></a> -->
          <div class="col-md-12 pull-left padding-5" id="footer-media-<?php echo @$media["_id"]; ?>"></div>
          <div class="col-md-12 no-padding pull-left margin-top-10" id="commentContent<?php echo @$media["_id"]; ?>"></div>
      </div>
    </div>
  </li>

  <?php } ?>
  <?php if(sizeof($news)==0 || sizeof($news) < 6){
      echo "<div id='noMoreNews' class='text-center'><i class='fa fa-ban'> ".Yii::t("common", "No more news")."</i></div>";
  } ?>
  <script type="text/javascript">
    var news=<?php echo json_encode($news) ?>;
    var canPostNews = <?php echo json_encode(@$canPostNews) ?>;
    var canManageNews = <?php echo json_encode(@$canManageNews) ?>;
    var actionController = <?php echo json_encode(@$actionController) ?>;
    var idSession = "<?php echo Yii::app()->session["userId"] ?>";
    var uploadUrl = "<?php echo Yii::app()->params['uploadUrl'] ?>";
    var docType="<?php echo Document::DOC_TYPE_IMAGE; ?>";
    var months = ["<?php echo Yii::t('common','january') ?>", "<?php echo Yii::t('common','febuary') ?>", "<?php echo Yii::t('common','march') ?>", "<?php echo Yii::t('common','april') ?>", "<?php echo Yii::t('common','may') ?>", "<?php echo Yii::t('common','june') ?>", "<?php echo Yii::t('common','july') ?>", "<?php echo Yii::t('common','august') ?>", "<?php echo Yii::t('common','september') ?>", "<?php echo Yii::t('common','october') ?>", "<?php echo Yii::t('common','november') ?>", "<?php echo Yii::t('common','december') ?>"];
    var contentKey = "<?php echo Document::IMG_SLIDER; ?>";
    var scrollEnd=false;
    jQuery(document).ready(function() {
      if($("#noMoreNews").length)
        scrollEnd=true;
      $.each(news, function(e,v){
        tags = "", 
        scopes = "",
        tagsClass = "",
        scopeClass = "";
        if( "object" == typeof v.tags && v.tags )
        {
          var countTag = 0;
          var maxTag = 5;
          $.each( v.tags , function(i,tag){ if(countTag < maxTag){
            if(tag != ""){
              countTag++;
              tagsClass += tag+" ";
        
              /*tags += "<span class='label tag_item_map_list tag' data-val='"+tag+"'>#"+tag+"</span> ";
              if( $.inArray(tag, contextScopesTags.tags)  == -1 && tag != undefined && tag != "undefined" && tag != "" ){
                contextScopesTags.tags.push(tag);*/
        
            //  tags += "<span class='label tag_item_map_list tag' data-tag-value='"+tag+"'>#"+tag+"</span> ";
              //if( $.inArray(tag, v.tags)  == -1 && tag != undefined && tag != "undefined" && tag != "" ){
                ///*contextMap.tags*/ v.tags.push(tag);
                tags += ' <a href="javascript:;" class="filter btn no-padding" data-filter=".'+tag+'"><span class="text-red text-xss">#'+tag+'</span></a>';
              //}
             }
          } });
          if(tags!=""){
            tags = '<div class="pull-left margin-top-5">'+tags+'</div>';
            $("#newsTagsScope"+e).append(tags);
          }
        }
      //var author = typeof v.author != "undefined" ? v.author : null;
      if(v.scope.type == "public"){
            postalCode = "";
            city = "";
            if(v.type != "activityStream"){
                var countScope = 0;
                var maxScope = 6;
                if(typeof(v.scope.cities) != "undefined"){
                  $.each(v.scope.cities, function(key, value){ countScope++;
                    var name = "";
                    if (typeof(value.postalCode) != "undefined") {
                      name += value.postalCode;
                    }
                    if(name != "") name += ", " ;
                    name += (value.addressLocality != "" && value.addressLocality != null) ? value.addressLocality : "";
                    if(countScope<maxScope)
                      scopes += "<span class='label label-danger'><i class='fa fa-bullseye'></i> " + name + "</span> ";
                  });
                }
                if(typeof(v.scope.departements) != "undefined"){
                  $.each(v.scope.departements, function(key, value){ countScope++;
                    if(countScope<maxScope)
                      scopes += "<span class='label label-danger'><i class='fa fa-bullseye'></i> "+value.name + "</span> ";
                  });
                }
                if(typeof(v.scope.regions) != "undefined"){
                  $.each(v.scope.regions, function(key, value){ countScope++;
                    if(countScope<maxScope)
                      scopes += "<span class='label label-danger'><i class='fa fa-bullseye'></i> "+value.name + "</span> ";
                  });
                }
            }else  { //activityStream
              if (typeof(v.scope.address) != "undefined" && v.scope != null && v.scope.address != null &&  v.scope.address.addressLocality != "Unknown") {
                postalCode=((v.scope.address.postalCode)?v.scope.address.postalCode+" , " : "");
                city=v.scope.address.addressLocality;
                scopes += "<span class='label label-danger'><i class='fa fa-bullseye'></i> "+postalCode+city+"</span> ";
              }
            }
           if(scopes != ""){
              scopes = '<div class="pull-right" style="margin: 5px 0px;">'+scopes+'</div>';
              $("#newsTagsScope"+e).append(scopes);
           }
        }
        if(v.type == "activityStream"){
          //if(v.object.type=="events" || v.object.type=="needs"){
            console.log(v.object);
            if(v.startDate && v.endDate){
              if(typeof(v.startDate) == "object")
                var startDate = new Date( parseInt(v.startDate.sec)*1000 );
              else if(typeof(v.startDateSec) != "undefined")
                var startDate = new Date( parseInt(v.startDateSec)*1000 );
              else
                var startDate = new Date( parseInt(v.startDate)*1000 );
              var startMonth = months[startDate.getMonth()];
              var startDay = (startDate.getDate() < 10) ?  "0"+startDate.getDate() : startDate.getDate();
              if(typeof(v.endDate) == "object")
                var endDate = new Date( parseInt(v.endDate.sec)*1000 );
              else if(typeof(v.endDateSec) != "undefined")
                var endDate = new Date( parseInt(v.endDateSec)*1000 );
              else
                var endDate = new Date( parseInt(v.endDate)*1000 );
              var endMonth = months[endDate.getMonth()];
              var endDay = (endDate.getDate() < 10) ?  "0"+endDate.getDate() : endDate.getDate();
            }
            var objectLocality = "";
            if (v.object.type=="needs")
              objectLocality=v.target.address.addressLocality;
            else 
              if(typeof v.scope != "undefined")
              objectLocality=v.scope.address.addressLocality;
       
            //var hour = (startDate.getHours() < 10) ?  "0"+startDate.getHours() : startDate.getHours();
            //var min = (startDate.getMinutes() < 10) ?  "0"+startDate.getMinutes() : startDate.getMinutes();
            //var dateStr = day + ' ' + month + ' ' + year + ' ' + hour + ':' + min;
            activityHtml = '<a href="#page.type.'+v.object.type+'.id.'+v.object.id+'" class="lbh col-md-12 col-sm-12 col-xs-12 no-padding">';
            if (typeof(startDay)!="undefined"){
              activityHtml += '<div class="col-md-3 col-sm-3 col-xs-3 no-padding text-center">'+
                    '<span class="text-large text-red text-bold light-text no-margin">'+startDay+'</span><br/><span class="text-dark light-text no-margin" style="font-variant:small-caps;">'+startMonth+'</span>'+
                  '</div>';
            }
            activityHtml +=  '<div class="col-md-9  col-sm-9 col-xs-9 no-padding">'+
                    '<span class="text-dark light-text activity-title no-margin">'+v.name+'</span><br/>';
            if (typeof(startDay)!= "undefined" && typeof(endDay) != "undefined"){ 
            activityHtml +=    '<span style="color: #8b91a0 !important;"><i class="fa fa-calendar"></i> '+startDay+' '+startMonth+' • '+endDay+' '+endMonth+' • ';
            }
            activityHtml +=    '<i class="fa fa-map-marker"></i> '+objectLocality+'</span>'+
                  '</div>'+
                '</a>';
          $("#newsActivityStream"+e).html(activityHtml);
        }
        // CSS DESIGN NEWS ORGANIZATION
        var currentOffset=$("#news"+e).offset();
        var prevOffset=$("#news"+e).prevAll(".list-news").offset();
        if(typeof prevOffset != "undefined"){
          if(currentOffset.top>=(prevOffset.top-20) && currentOffset.top<=(prevOffset.top+20))
             $("#news"+e).addClass("addMargin");
        }
        if(actionController=="save"){
          $("#news"+e).nextAll(".list-news").first().addClass("addMargin");
          if($("#news"+e).nextAll(".list-news").first().hasClass("timeline-inverted"))
            $("#news"+e).removeClass("timeline-inverted");
          else
            $("#news"+e).addClass("timeline-inverted");
          
        }
        if("undefined" != typeof v.text && $){
          textHtml="";
          textNews="";
           if(v.text.length > 0)
              textNews=checkAndCutLongString(v.text,500,v._id.$id);
      //Check if @mentions return text with link
            if(typeof(v.mentions) != "undefined")
              textNews = addMentionInText(textNews,v.mentions);
          textHtml='<span class="timeline_text no-padding text-black" >'+textNews+'</span>';
          $("#newsContent"+e).html(textHtml);
        }
        if("undefined" != typeof v.media){
          if(typeof(v.media.type)=="undefined" || v.media.type=="url_content"){
            if("object" != typeof v.media)
              media=v.media;
            else
              media=getMediaHtml(v.media,"show",e);
              //// Fonction générant l'html
          } else if (v.media.type=="gallery_images")
            media=getMediaImages(v.media,e,v.author.id,v.target.name);
          $("#result"+e).append(media);
        }
        bindLBHLinks();
      });

      <?php if(!(@$isFirst == true) && @$limitDate && @$limitDate["created"]){ ?>
        <?php if(!(@$isFirst == true) && @$limitDate && @$limitDate["created"]){ ?>
        var limitDate = <?php echo json_encode($limitDate["created"]); ?>;
        if(typeof(limitDate) == "object")
          dateLimit=limitDate.sec;
        else
          dateLimit=limitDate;
        <?php } ?>
      <?php } ?>


    <?php if(sizeof($news)==0){ ?>
        scrollEnd = true;
      <?php } ?>
    });

  </script>
