<style>

.timeline-panel .searchEntityContainer{
    width: 100% !important;
    margin-top:20px;
    max-height: 450px !important;
    margin-bottom: 15px !important;
    min-height: unset !important;
}
.timeline-body .btn-share{
  display: none;
}
.timeline-panel .container-img-profil{
  max-height: 250px;
}
</style>

<?php 
  $timezone = "";// @$timezone ? $timezone : 'Pacific/Noumea';
  $pair = @$pair ? $pair : false;
  $nbCol = @$nbCol ? $nbCol : 2;
  
	foreach($news as $key => $media){ 
			$class = $pair || ($nbCol == 1) ? "timeline-inverted" : "";
			$pair = !$pair;
      // Author name and thumb
      //print_r($media);
      if(@$media["targetIsAuthor"] || $media["type"]=="activityStream"){   
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
                      : $this->module->assetsUrl."/images/news/profile_default_l.png";
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

  
  <li class="<?php echo $class; ?> list-news" 
      id="<?php echo @$media["type"]; ?><?php echo $key; ?>">
    <div class="timeline-badge primary">
      <a><i class="glyphicon glyphicon-record" rel="tooltip"></i></a>
    </div>
    <div class="timeline-panel">
      <?php 
          $this->renderPartial('../news/timeline-panel', 
                      array(  "key"=>$key,
                              "media"=>$media,
                              "authorType"=>$authorType,
                              "nameAuthor"=>@$nameAuthor,
                              "authorId"=>$authorId,
                              "contextId"=>@$contextParentId,
                              "timezone"=>$timezone,
                              "thumbAuthor"=>@$thumbAuthor,
                              "canManageNews"=> @$canManageNews
                          ) 
                      ); 
      ?>
      <?php if(isset(Yii::app()->session["userId"])) { ?>
      <div class="timeline-footer pull-left col-md-12 col-sm-12 col-xs-12 padding-top-5">
          <!-- <a class="btn-comment-media" data-media-id="<?php //echo $media["_id"]; ?>"><i class="fa fa-comment"></i> Commenter</a> -->
          <!-- <a><i class="glyphicon glyphicon-thumbs-up"></i></a>
          <a><i class="glyphicon glyphicon-share"></i></a> -->
          <div class="col-md-12 pull-left padding-5" id="footer-media-<?php echo @$media["_id"]; ?>"></div>
          <div class="col-md-12 col-sm-12 col-xs-12 no-padding pull-left margin-top-10" id="commentContent<?php echo @$media["_id"]; ?>"></div>
      </div>     
      <?php } ?>
    </div>
  </li>
  <!--<div class='loader text-dark'>
    <span style='font-size:25px;'>
      <i class='fa fa-spin fa-circle-o-notch'></i> 
      <span class='text-dark'>Chargement en cours ...</span> 
    </div>-->
  <?php } ?>

  <?php if(@$isFirst == true && sizeof($news)==0){ ?>
      <li id='noMoreNews' class='text-left padding-15'>
        <i class='fa fa-ban'></i>
        Aucune actualité
      </li>
  <?php }else if(sizeof($news)==0 && @$actionController != "save"){
      echo "<li id='noMoreNews' class='text-left'><i class='fa fa-ban'></i> ".Yii::t("common", "No more news")."</li>";
  } ?>
  <script type="text/javascript">

    var news=<?php echo json_encode($news) ?>;
   // updateNews=updateNews.concat(array(1,2,3));
    var canPostNews = <?php echo json_encode(@$canPostNews) ?>;
    var canManageNews = <?php echo json_encode(@$canManageNews) ?>;
    var actionController = <?php echo json_encode(@$actionController) ?>;
    var idSession = "<?php echo Yii::app()->session["userId"] ?>";
    var uploadUrl = "<?php echo Yii::app()->params['uploadUrl'] ?>";
    var docType="<?php echo Document::DOC_TYPE_IMAGE; ?>";
    var months = ["<?php echo Yii::t('common','january') ?>", "<?php echo Yii::t('common','febuary') ?>", "<?php echo Yii::t('common','march') ?>", "<?php echo Yii::t('common','april') ?>", "<?php echo Yii::t('common','may') ?>", "<?php echo Yii::t('common','june') ?>", "<?php echo Yii::t('common','july') ?>", "<?php echo Yii::t('common','august') ?>", "<?php echo Yii::t('common','september') ?>", "<?php echo Yii::t('common','october') ?>", "<?php echo Yii::t('common','november') ?>", "<?php echo Yii::t('common','december') ?>"];
    var contentKey = "<?php echo Document::IMG_SLIDER; ?>";
    var scrollEnd=false;
    var nbCol = "<?php echo $nbCol; ?>";

    jQuery(document).ready(function() {
      if($("#noMoreNews").length)
        scrollEnd=true;
      
      <?php if(isset(Yii::app()->session["userId"])) { ?>
        initCommentsTools(news);
      <?php } ?>

      $.each(news, function(e,v){
        updateNews[e]= v;
       // updateNews.e=v;
        console.log(v);
        if(typeof v._id.$id != "undefined")
        if($(".newsActivityStream"+v._id.$id).length>0){
           $("#news"+v._id.$id).remove();
           //$("#news"+v._id.$id).append("CLEAN2");//console.log("xxzz", v);
        }

        if(typeof v.object != "undefined"){ 
          if($(".newsActivityStream"+v.object.id).length>0){
           // console.log("CLEAN2", "#news-list li#news"+v.object.id, "len", 
           // $(".newsActivityStream"+v.object.id).length, $("#news"+v.object.id).length);

            $("#news"+v.object.id).remove();
            //$("#news"+v.object.id).append("CLEAN2");//console.log("xxzz", v);
          }

          $(".newsActivityStream"+v.object.id).each(function(b, ob){
            if(b>0) {
              var parent = $(ob).parent().parent().parent();
              parent.remove();
              //parent.append("CLEAN1");
              //console.log("CLEAN1", ".newsActivityStream"+v.object.id);
            }
          });


          if(v.object.type != "news"){
            var html = directory.showResultsDirectoryHtml(new Array(v.object), v.object.type);
            $(".newsActivityStream"+v.object.id).html(html);
          }
        }

      });

      $.each(news, function(e,v){
        tags = "", 
        scopes = "",
        tagsClass = "",
        scopeClass = "";

/*
        if( "object" == typeof v.tags && v.tags )
        {
          var countTag = 0;
          var maxTag = 5;
          $.each( v.tags , function(i,tag){ if(countTag < maxTag){
            if(tag != ""){
              countTag++;
              tagsClass += tag+" ";
                tags += ' <a href="javascript:;" class="filter btn no-padding" data-filter=".'+tag+'"><span class="text-red text-xss">#'+tag+'</span></a>';
             }
          } });

          if(tags!=""){
            tags = '<div class="pull-left margin-top-5">'+tags+'</div>';
            $("#newsTagsScope"+e).append(tags);
          }
        }
        //var author = typeof v.author != "undefined" ? v.author : null;
        if(typeof v.scope != "undefined" && v.scope.type == "public"){
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
              if(typeof v.scope != "undefined" && typeof v.scope.address != "undefined")
              objectLocality=v.scope.address.addressLocality;
            activityHtml = '<a href="#page.type.'+v.object.type+'.id.'+v.object.id+'" '+
                            'class="lbh col-md-12 col-sm-12 col-xs-12 no-padding">';

            if (typeof(startDay)!="undefined"){
              activityHtml += 
                  '<div class="col-md-3 col-sm-3 col-xs-3 no-padding text-center">'+
                    '<span class="text-large text-red text-bold light-text no-margin">'+startDay+'</span><br/><span class="text-dark light-text no-margin" style="font-variant:small-caps;">'+startMonth+'</span>'+
                  '</div>';
            }
            if(typeof v.name != "undefined" && v.name != null && v.name != "")
            activityHtml +=  '<div class="col-md-9  col-sm-9 col-xs-9 no-padding">'+
                                '<span class="text-dark light-text activity-title no-margin">'+v.name+'</span><br/>';

            if (typeof(startDay)!= "undefined" && typeof(endDay) != "undefined"){ 
            activityHtml +=    '<span style="color: #8b91a0 !important;"><i class="fa fa-calendar"></i> '+
                                  startDay+' '+startMonth+' • '+endDay+' '+endMonth+' • ';
            }
            if(objectLocality != "")
            activityHtml +=    '<i class="fa fa-map-marker"></i> '+objectLocality+'</span>'+
                              '</div>'+
                          '</a>';

          $("#newsActivityStream"+e).html(activityHtml);
        }*/

        // CSS DESIGN NEWS ORGANIZATION
        var currentOffset=$("#"+v.type+e).offset();
        var prevOffset=$("#"+v.type+e).prevAll(".list-news").offset();
        if(typeof prevOffset != "undefined"){
          if(currentOffset.top>=(prevOffset.top-20) && currentOffset.top<=(prevOffset.top+20))
             $("#"+v.type+e).addClass("addMargin");
        }
        if(actionController=="save"){
          //$("#news"+e).nextAll(".list-news").first().addClass("addMargin");
          // if(nbCol == 2){
          //   if($("#news"+e).nextAll(".list-news").first().hasClass("timeline-inverted"))
          //     $("#news"+e).removeClass("timeline-inverted");
          //   else
          //     $("#news"+e).addClass("timeline-inverted");
          // }
          initCommentsTools(new Array(v));
        }
        if("undefined" != typeof v.text){
          textHtml="";
          textNews=v.text;
           if(v.text.length > 0)
              textNews=checkAndCutLongString(v.text,500,v._id.$id);
            //Check if @mentions return text with link
            if(typeof(v.mentions) != "undefined")
              textNews = addMentionInText(textNews,v.mentions);
          textHtml='<span class="timeline_text no-padding text-black" >'+textNews+'</span>';
          $("#newsContent"+e).html(textHtml);

          $(".btn-showmorenews").off().click(function(){
            var newsid = $(this).data("newsid");
             console.log("hasClass ?", $("#newsContent"+newsid+" .timeline_text span.endtext").hasClass("hidden"));
            if($("#newsContent"+newsid+" .timeline_text span.endtext").hasClass("hidden")){
                $("#newsContent"+newsid+" .timeline_text span.endtext").removeClass("hidden");
                $("#newsContent"+newsid+" .timeline_text span.ppp").addClass("hidden");
                $(this).html("réduire le texte");
            }else{
                $("#newsContent"+newsid+" .timeline_text span.endtext").addClass("hidden");
                $("#newsContent"+newsid+" .timeline_text span.ppp").removeClass("hidden");
                $(this).html("Lire la suite");
            }
          });
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
          $("#result"+e).html(media);
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

        initBtnLink();
    });

  </script>
