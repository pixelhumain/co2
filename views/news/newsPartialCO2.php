<?php 
  $timezone = "";// @$timezone ? $timezone : 'Pacific/Noumea';
  $pair = @$pair ? $pair : false;
  $nbCol = @$nbCol ? $nbCol : 2;
 //echo $nbCol;
  if(sizeof($news)==0){
      echo "<div class='padding-15'><i class='fa fa-ban'></i>";
  }

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

  
  <li class="<?php echo $class; ?>" id="news<?php echo $key ?>">
    <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip"></i></a></div>
    <div class="timeline-panel">
      <div class="timeline-heading text-center">
        

           	<h5 class="text-left srcMedia">
          		<small class="ilyaL">

                <img class="pull-right img-circle" src="<?php echo @$thumbAuthor; ?>" height=40>
                <div class="pull-right padding-5">
                  <a href="#page.type.<?php echo $authorType ?>.id.<?php echo $authorId ?>" class="lbh"><?php echo $nameAuthor ?></a><br>
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
                    else if (@$media["scope"]["type"]=="restricted"){
                      $scopeIcon="connectdevelop";
                      $scopeTooltip= Yii::t("common","Visible to all on this wall and published on this network");
                    }else{
                      $scopeIcon="lock";
                      $scopeTooltip= Yii::t("common","Private view");
                    } ?>
                     <strong> • </strong>  <i class='fa fa-<?php echo $scopeIcon ?> tooltips' data-toggle='tooltip' data-placement='bottom' data-original-title='<?php echo $scopeTooltip ?>'></i>
                  <?php } ?>
                  </span>
                </div>

              </small>

          	  <small class="ilyaR">

                <img class="pull-left img-circle" src="<?php echo @$thumbAuthor; ?>" height=40>
                <div class="pull-left padding-5">
                  <a href="#page.type.<?php echo $authorType ?>.id.<?php echo $authorId ?>" class="lbh"><?php echo @$nameAuthor; ?></a><br>
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
                     <strong> • </strong>  <i class='fa fa-<?php echo $scopeIcon ?> tooltips' data-toggle='tooltip' data-placement='bottom' data-original-title='<?php echo $scopeTooltip ?>'></i>
                  <?php } ?>
                  </span>
                </div>
                
              </small>  
              <a href="javascript:;" target="_blank" class="link-read-media margin-top-10 hidden-xs img-circle">
                <small>
                  <i class="fa fa-clock-o"></i> 
                  <?php echo Translate::pastTime(date($media["created"]->sec), "timestamp", $timezone); ?>
                </small>
                <?php if (@Yii::app()->session["userId"]){ ?>
                  <strong> • </strong> 
                  <div class="btn dropdown no-padding">
                    <a class="dropdown-toggle" type="button" data-toggle="dropdown" style="color:#8b91a0;">
                      <i class="fa fa-cog"></i>  <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                    <?php if (@$media["author"]["id"]==Yii::app()->session["userId"] || (@$canManageNews && $canManageNews)){ ?>
                      <li>
                        <a href="javascript:;" class="deleteNews" onclick="deleteNews('<?php echo $key ?>', $(this))" data-id="'<?php echo $key ?>"><small><i class="fa fa-times"></i> <?php echo Yii::t("common", "Delete")?></small></a></li>
                        <?php if ($media["type"] != "activityStream" && $media["author"]["id"]==Yii::app()->session["userId"]){ ?>
                          <li><a href="javascript:" class="modifyNews" onclick="modifyNews('<?php echo $key ?>')" data-id="<?php echo $key ?>"><small><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Update publication")?></small></a></li>
                        <?php }
                    } ?> 
                    <?php if (!@$media["reportAbuse"] || (@$media["reportAbuse"] && !@$media["reportAbuse"][@Yii::app()->session["userId"]])) { ?>
                        <li><a href="javascript:;" class="newsReport" onclick="newsReportAbuse(this,'<?php echo $key ?>')" data-id="<?php echo $key ?>"><small><i class="fa fa-flag"></i> <?php echo Yii::t("common", "Report an abuse")?></small></a></li>
                    <?php } ?>
                    </ul>
                  </div>
                  <?php } ?>
              </a>
            </h5>
          
          <div class="timeline-body padding-10 col-md-12 text-left">
            <!-- <h4><a target="_blank" href="<?php echo @$media["href"]; ?>"><?php echo @$media["title"]; ?></a></h4> -->
            <?php if(@$media["type"]=="activityStream") { ?>
              <?php $faIcon = Element::getFaIcon($media["object"]["type"]) ? 
                              Element::getFaIcon($media["object"]["type"]) : ""; ?>
              <h4 class="no-padding">
                <a target="_blank" 
                   href="#app.page.type.<?php echo @$media["object"]["type"]; ?>.id.<?php echo @$media["object"]["id"]; ?>">
                   <i class="fa fa-<?php echo $faIcon; ?>"></i> <?php echo @$media["name"]; ?>
                </a>
              </h4>
              <?php if(@$media["startDate"]) { ?>
                <?php echo date(@$media["startDate"]->sec); ?>
              <?php } ?>
            <?php } ?>
            <div id="newsContent<?php echo $key ?>" data-pk="<?php echo $key ?>" class="newsContent" ></div>
          </div>

          <?php if(@$srcMainImg != ""){ ?>
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


        
      </div>
      
      
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

  <script type="text/javascript">
    var news=<?php echo json_encode($news) ?>;
    var canPostNews = <?php echo json_encode(@$canPostNews) ?>;
    var canManageNews = <?php echo json_encode(@$canManageNews) ?>;
    var actionController = <?php echo json_encode(@$actionController) ?>;
    var idSession = "<?php echo Yii::app()->session["userId"] ?>";
    var uploadUrl = "<?php echo Yii::app()->params['uploadUrl'] ?>";
    var docType="<?php echo Document::DOC_TYPE_IMAGE; ?>";
    var contentKey = "<?php echo Document::IMG_SLIDER; ?>";
    jQuery(document).ready(function() {
      $.each(news, function(e,v){
        if(actionController=="save"){
          if($("#news-list").children().eq(0).hasClass("timeline-inverted")){
            alert("has");
            $("#news"+e).removeClass("timeline-inverted");
          }else{
            alert("hasnt");
            $("#news"+e).addClass("timeline-inverted");
          }
        }
        if("undefined" != typeof v.text){
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
