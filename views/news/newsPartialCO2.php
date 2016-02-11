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

.timeline-panel#nbAbuse3,
.timeline-panel#nbAbuse4 {
  background-color: #ffe4e4 !important;
  border: 2px solid #ffacac;
}

.timeline-panel#nbAbuse3 .timeline_text{
  color: #c29898 !important;
}

.timeline-panel#nbAbuse4 .timeline_text{
  color: #dacbcb !important;
}
.timeline-panel#nbAbuse3::before,
.timeline-panel#nbAbuse4::before{
  border-left: 15px solid #ffacac;
  border-left-width: 15px;
}

li.timeline-inverted .timeline-panel#nbAbuse3::before,
li.timeline-inverted .timeline-panel#nbAbuse4::before{
  border-right-color: #ffacac !important;
  border-right: 15 solid #ffacac!important;
  border-left:0px!important;
}


</style>

<?php 
$timezone = "";
$pair = @$pair ? $pair : false;
$nbCol = @$nbCol ? $nbCol : 2;

foreach($news as $key => $media){ 
  $class = $pair || ($nbCol == 1) ? "timeline-inverted" : "";
	$pair = !$pair;
  // Author name and thumb
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
    <div class="timeline-panel"
         id="nbAbuse<?php echo @$media["reportAbuseCount"]; ?>">
         <?php if( @$media["reportAbuseCount"] >= 1){ ?>
           <h6 class="pull-left">
              <small class="pull-left margin-left-10 letter-orange">
                <i class="fa fa-flag"></i> Ce contenu a été signalé <?php echo @$media["reportAbuseCount"]; ?> fois !
                <?php if(@$media["reportAbuseCount"] < 4){ ?>
                  <br><b>participez à la modération en signalant le contenu qui vous semble innaproprié</b>
                <?php }else{ ?>
                  <br><b>participez à la modération en votant</b>
                <?php } ?>
              </small>
           </h6>
           <?php if(@$media["reportAbuseCount"] >= 1 && isset(Yii::app()->session["userId"])){ ?>
           <button class="btn btn-link bg-orange pull-right margin-right-10 margin-top-10 btn-start-moderation"
                   data-newsid="<?php echo @$media["_id"]; ?>" 
                   data-toggle="modal" data-target="#modal-moderation">
              <i class="fa fa-balance-scale"></i> Modération
          </button>
          <?php } ?>
         <?php } ?>
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
          <div class="col-md-12 pull-left padding-5" id="footer-media-<?php echo @$media["_id"]; ?>"></div>
          <div class="col-md-12 col-sm-12 col-xs-12 no-padding pull-left margin-top-10" id="commentContent<?php echo @$media["_id"]; ?>"></div>
      </div>     
      <?php } ?>
    </div>
  </li>
<?php } ?>

<?php if(@$isFirst == true && sizeof($news)==0){ ?>
    <li id='noMoreNews' class='text-left padding-15 letter-blue shadow2'>
      <i class='fa fa-ban'></i>
      <?php echo Yii::t("common", "No news in this timeline") ?>
    </li>
<?php }else if(sizeof($news)==0 && @$actionController != "save"){
    echo "<li id='noMoreNews' class='text-left letter-blue shadow2'><i class='fa fa-ban'></i> ".Yii::t("common", "No more news")."</li>";
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
  var nbCol = "<?php echo $nbCol; ?>";

  jQuery(document).ready(function() {
    if($("#noMoreNews").length)
      scrollEnd=true;
    
    <?php if(isset(Yii::app()->session["userId"])) { ?>
      initCommentsTools(news);
    <?php } ?>
    
    $.each(news, function(e,v){
      updateNews[e]= v;
        if(typeof v._id.$id != "undefined")
        if($("#news-list .newsActivityStream"+v._id.$id).length>0)
           $("#news-list #news"+v._id.$id).remove();

        if(typeof v.object != "undefined"){ 
          if($("#news-list .newsActivityStream"+v.object.id).length>0)
            $("#news-list #news"+v.object.id).remove();

          $("#news-list .newsActivityStream"+v.object.id).each(function(b, ob){
            if(b>0) {
              var parent = $(ob).parent().parent().parent();
              parent.remove();
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

      // CSS DESIGN NEWS ORGANIZATION
      var currentOffset=$("#"+v.type+e).offset();
      var prevOffset=$("#"+v.type+e).prevAll(".list-news").offset();
      if(typeof prevOffset != "undefined"){
        if(currentOffset.top>=(prevOffset.top-20) && currentOffset.top<=(prevOffset.top+20))
           $("#"+v.type+e).addClass("addMargin");
      }
      if(actionController=="save")
        initCommentsTools(new Array(v));
      if("undefined" != typeof v.text){
        textHtml="";
        textNews=v.text;
        if(v.text.length > 0)
          textNews=checkAndCutLongString(v.text,500,v._id.$id,"showmorenews",true);
          //Check if @mentions return text with link
        if(typeof(v.mentions) != "undefined")
          textNews = mentionsInit.addMentionInText(textNews,v.mentions);
        textHtml='<span class="timeline_text no-padding text-black" >'+linkify(textNews)+'</span>';
        $("#newsContent"+e).html(textHtml);

        $(".btn-showmorenews").off().click(function(){
          var newsid = $(this).data("id");
          if($("#newsContent"+newsid+" .timeline_text span.endtext").hasClass("hidden")){
              $("#newsContent"+newsid+" .timeline_text span.endtext").removeClass("hidden");
              $("#newsContent"+newsid+" .timeline_text span.ppp").addClass("hidden");
              $(this).html("Réduire le texte").parent().prepend("<br>");
          }else{
              $("#newsContent"+newsid+" .timeline_text span.endtext").addClass("hidden");
              $("#newsContent"+newsid+" .timeline_text span.ppp").removeClass("hidden");
              $(this).html("Lire la suite").parent().find("br").remove();
          }
        });
      }
      if("undefined" != typeof v.media){
        if(typeof(v.media.type)=="undefined" || v.media.type=="url_content")
          media=getMediaCommonHtml(v.media,"show",e);
        else if (v.media.type=="gallery_images")
          media=getMediaImages(v.media,e,v.author.id,v.target.name);
        else if (v.media.type=="gallery_files")
          media=getMediaFiles(v.media,e);
        else if (v.media.type=="activityStream")
          media=directory.showResultsDirectoryHtml(new Array(v.media.object),v.media.object.type);
        $("#result"+e).html(media);
         $(".videoSignal").off().on("click",function(){
          videoLink = $(this).find(".videoLink").val();
          iframe='<div class="embed-responsive embed-responsive-16by9 margin-bottom-5" style="background-color:black;">'+
            '<iframe src="'+videoLink+'" width="100%" height="" class="embed-responsive-item"></iframe></div>';
          $(this).parent().next().removeClass("col-xs-8").addClass("col-xs-12").before(iframe);
          //$(this).parent().next();
          $(this).parent().remove();

        });
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

      $(".btn-start-moderation").off().click(function(){
        var newsid = $(this).data("newsid");
        uiModeration.getNewsToModerate(newsid);
      });

      initBtnLink();
  });
</script>
