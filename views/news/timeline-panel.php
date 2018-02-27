<?php $shareLabel=array(
  "verb-create" => "created",
  "verb-share" => "shared",
  "verb-share-pluriel" => "have shared",
  "displayShared-news"      => "a news",
  "displayShared-projects"    => "a project",
  "displayShared-organizations"   => "an organization",
  "displayShared-events"      => "an event",
  "displayShared-classified"    => "an announce",
  "displayShared-proposals"    => "a proposal",
  "displayShared-actions"    => "an action",
  "displayShared-resolutions"    => "a resolution",
  "displayShared-rooms"    => "a cooperative space",
  "displayShared-ressources"    => "a need or a ressource",
  "displayShared-places"    => "a place",
); ?>
  
  <div id="newsTagsScope<?php echo $key ?>" class="col-md-12 col-sm-12 col-xs-12">
    
    <?php $count = 0; $allScope = "";
      if(@$media["scope"]) {
        $scopeSpan="";
        if($media["type"]=="news"){
          foreach (array(/*"cities", "departements", "regions"*/ "localities") as $s) {
            if(@$media["scope"][$s])
            foreach ($media["scope"][$s] as $keyy => $scopes) {
              foreach ($scopes as $k => $v) {
                foreach (array("postalCode", "addressLocality", "name") as $kk => $s) {


                  if(@$k == $s && $v != "" && !is_array($v) ) {
                    if($count<3){
                     $scopeSpan.="<span class='label label-danger pull-right margin-left-5 margin-top-10'>
                      <i class='fa fa-bullseye'></i> ".$v."</span>";
                    }else{ $allScope .= " ".$v; }  $count++; 
                  }
                }
              }
            }
          }
        }else{
          if (@$media["scope"]["address"] && @$media["scope"]["type"] && $media["scope"]["type"]==News::TYPE_PUBLIC) {
              $postalCode=(@$media["scope"]["address"]["postalCode"])?$media["scope"]["address"]["postalCode"].", " : "";
              $city=$media["scope"]["address"]["addressLocality"]; 
              $scopeSpan="<span class='label label-danger pull-right margin-left-5 margin-top-10'><i class='fa fa-bullseye'></i> ".$postalCode.$city."</span>"; 
          }
        }
        if($count >3){ ?>
          <span class='label text-red pull-right margin-left-5 margin-top-10 tooltips' 
            data-title="<?php echo $allScope; ?>" data-toogle="tooltip">
            <i class='fa fa-plus'></i> <?php echo $count-3;?> autres
          </span>
        <?php } 
        echo $scopeSpan;
      }
    ?>
    </div>
  
  <?php $classHeading="";
  if(@$srcMainImg != "" && $media["type"] == "activityStream"){ $classHeading="activity-heading"; ?>
    <a class="inline-block bg-black activity-image" target="_blank" href="<?php echo @$media["href"]; ?>">
      <img class="img-responsive" src="<?php echo $srcMainImg; ?>" />
    </a>
  <?php } ?>

  <div class="timeline-heading text-center <?php echo $classHeading; ?>">
    <h5 class="text-left srcMedia">
      <small>
        <?php 
          if(@$media["verb"]!="share"){
            $pluriel = ""; 
         

         /* if(empty(@$media["sharedBy"]) || !@$media["lastAuthorShare"] ||
           (($media["sharedBy"][0]["id"] == @$media["lastAuthorShare"]["id"] && 
            count(@$media["sharedBy"])<=1) &&
            ($media["sharedBy"][0]["id"] == @$authorId)) 
           ){ 
              $pluriel = ""; 
          }else{ $pluriel = "-pluriel"; }*/ ?>

            <img class="pull-left img-circle" 
               src="<?php echo @$thumbAuthor; ?>" 
               height=40>

          <div class="pull-left padding-5 col-md-7 col-sm-7 text-left" style="line-height: 15px;"> 
            <?php  //if(@$media["lastAuthorShare"]["name"]!=@$nameAuthor){ ?>
            <a href="#page.type.<?php echo $authorType ?>.id.<?php echo $authorId ?>" class="lbh">
              <?php echo @$nameAuthor; ?>
            </a>
            <?php /*}*/ }?>

            <?php //var_dump(@$media["sharedBy"]); 
            if(@$media["sharedBy"] && @$media["verb"]=="share"){ 
              $countSharedBy=count($media["sharedBy"]);

              if($countSharedBy==1){
                if(@$media["lastAuthorShare"] && @$media["lastAuthorShare"]["profilThumbImageUrl"]=="") 
                  $media["lastAuthorShare"]["profilThumbImageUrl"] = 
                  $this->module->assetsUrl."/images/thumb/default_".$media["lastAuthorShare"]["type"].".png";
                else if(@$media["lastAuthorShare"]["profilThumbImageUrl"]!="")
                  $media["lastAuthorShare"]["profilThumbImageUrl"] = 
                    Yii::app()->createUrl($media["lastAuthorShare"]["profilThumbImageUrl"]) ;
                $pluriel = ""; ?>
                <img class="pull-left img-circle" 
                  src="<?php echo @$media["lastAuthorShare"]["profilThumbImageUrl"]; ?>" 
                height="40"/> 
              <?php } ?>
              <div class="pull-left padding-5 col-md-7 col-sm-7" style="line-height: 15px;"> 
              <?php if(@$media["lastAuthorShare"] ){ ?>
                <a href="#page.type.<?php echo $media["lastAuthorShare"]["type"] ?>.id.<?php echo $media["lastAuthorShare"]["id"] ?>" class="lbh">
                  <?php echo @$media["lastAuthorShare"]["name"]; ?>
                </a>
              <?php } 
              if($countSharedBy >1){
                $pluriel = "-pluriel";
                $i=0;
                foreach ($media["sharedBy"] as $keyS => $share) { 
                  if($countSharedBy == 1){ $pluriel = ""; } 
                  if($media["lastAuthorShare"]["name"]!=@$share["name"]){
                    if($i < 2){
                      if($i==0 && $countSharedBy > 2) echo ","; 
                      else if($countSharedBy > 1) echo Yii::t("common", "and");  ?>
                      <a href="#page.type.<?php echo @$share["type"]; ?>.id.<?php echo @$share["id"] ?>" 
                          class="lbh">
                        <?php echo @$share["name"]; ?>
                      </a> 
                    <?php }else if($i == 2){ ?>
                      <?php echo Yii::t("common", "and"); ?> 
                      <?php echo $countSharedBy - 2; ?> 
                      <?php $s = $countSharedBy - 2 > 1 ? "s" : ""; ?> 
                      autre<?php echo $s; ?> personne<?php echo $s; ?>
                    <?php } 
                    $i++;
                  } 
                } 
              } 
          }?>
        <br>

        <span class="margin-top-5">
          <?php if(@$media["type"]=="news") { 
            $where="";
              if(@$media["target"]["id"] != @$authorId && @$media["verb"] != "create") { 
                if(@$media["target"]["id"] != @$contextId){ 
                     $where=Yii::t("news","in the newspaper of {who}",
                        array("{who}"=>'<a href="#page.type.'.@$media["target"]["type"].'.id.'.@$media["target"]["id"].'" class="lbh">'.@$media["target"]["name"].' </a>')); 
                 }else if(@$media["target"]["id"] == @$contextId && @$contextId == Yii::app()->session["userId"] ){ 
                    $where=Yii::t("news","in your newspaper");
                }else if(@$media["target"]["id"] == @$contextId && @$contextId != Yii::app()->session["userId"] ){ 
                    $where=Yii::t("news","in this newspaper");
                } 
               } ?>

            <i class="fa fa-pencil-square"></i> <?php echo Yii::t("news", "published {what} {where}", array("{what}"=>'<a href="#page.type.'.@$media["type"].'.id.'.@$media["_id"].'" class="lbh">'.Yii::t("news","a message").'</a>',"{where}"=>$where)) ?>
          <?php } ?>
        
         
          <?php if(@$media["type"]=="activityStream") { ?>
            <?php $iconColor = @Element::getColorIcon($media["object"]["type"]); ?>
            <i class="fa fa-plus-circle"></i> <?php echo Yii::t("news",@$shareLabel["verb-".$media["verb"].$pluriel]); ?> 
            <span class="text-<?php echo @$iconColor; ?>">
              <a href="#page.type.<?php echo @$media["object"]["type"]; ?>.id.<?php echo @$media["object"]["id"]; ?>" 
                 class="lbh">
                <?php echo Yii::t("common", @$shareLabel["displayShared-".@$media["object"]["type"]]); ?>
              </a>
            </span> 
            <?php if(@$media["object"]["type"] == "news"){ ?>
            de <a href="#page.type.<?php echo @$media["object"]["authorType"]; ?>.id.<?php echo @$media["object"]["authorId"]; ?>" 
                  class="lbh text-<?php echo @$iconColor; ?>">
              <?php echo @$media["object"]["authorName"]; ?>
              </a>
            <?php } ?>
             <?php if(@$media["target"]["id"] != @$authorId && 
                   @$media["verb"] != "create") { ?>
            <?php if(@$media["target"]["id"] != @$contextId){ ?>
                  dans le journal de 
                  <a href="#page.type.<?php echo @$media["target"]["type"]; ?>.id.<?php echo @$media["target"]["id"]; ?>" 
                          class="lbh">
                          <?php echo @$media["target"]["name"]; ?>
                  </a>
            <?php }else if(@$media["target"]["id"] == @$contextId && @$contextId == Yii::app()->session["userId"] ){ ?>
                dans votre journal
            <?php }else if(@$media["target"]["id"] == @$contextId && @$contextId != Yii::app()->session["userId"] ){ ?>
                dans ce journal
            <?php } ?>
          <?php } ?>

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
                <?php if ((@$media["author"]["id"]==Yii::app()->session["userId"] && @$media["verb"] != "share") 
                            || (@$media["sharedBy"] && in_array(Yii::app()->session["userId"],array_column($media["sharedBy"],"id")))
                           || (@$canManageNews && $canManageNews)){ ?>
                  <li>
                    <a href="javascript:;" class="deleteNews" onclick="deleteNews('<?php echo $key ?>', '<?php echo $media["type"] ?>', $(this))" data-id="'<?php echo $key ?>"><small><i class="fa fa-times"></i> <?php echo Yii::t("common", "Delete")?></small></a></li>
                    <?php if (@$media["type"] != "activityStream" 
                              && ( (@$media["targetIsAuthor"] && $media["targetIsAuthor"]) 
                                  || @$media["author"]["id"]==Yii::app()->session["userId"])){ ?>
                      <li><a href="javascript:" class="modifyNews" onclick="modifyNews('<?php echo $key ?>','<?php echo $media["type"] ?>')" data-id="<?php echo $key ?>"><small><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Update publication")?></small></a></li>
                    <?php }
                } ?> 
                <?php if (!@$media["reportAbuse"] || (@$media["reportAbuse"] && !@$media["reportAbuse"][@Yii::app()->session["userId"]])) { ?>
                    <li><a href="javascript:;" class="newsReport" onclick="newsReportAbuse(this,'<?php echo $key ?>')" data-id="<?php echo $key ?>"><small><i class="fa fa-flag"></i> <?php echo Yii::t("common", "Report an abuse")?></small></a></li>
                <?php } ?>
                </ul>
              </div>
              <?php } ?>
          <span class="margin-top-10 margin-bottom-10 hidden-xs pull-right">
            <small>
              <i class="fa fa-clock-o"></i> 
              <?php //var_dump(@$media["updated"]);
                   // if(@$media["type"] == "activityStream" && @$media["verb"] == ActStr::TYPE_ACTIVITY_SHARE) 
                    echo Translate::pastTime(date(@$media["updated"]->sec), "timestamp", $timezone); 
                    //else
                    //echo Translate::pastTime(date(@$media["created"]->sec), "timestamp", $timezone); 
              ?>
            </small>

          </span>
        </h5>
  </div>

  <div class="timeline-body  col-md-12 text-left margin-bottom-10">
    <?php if(!empty(@$media["comment"])){ ?>
      <span class=""><?php echo $media["comment"]; ?>
      </span>
    <?php } ?>
    
    <?php if(!empty(@$media["text"]) && (!@$media["reportAbuseCount"] || @$media["reportAbuseCount"] < 4)){ ?>
      <div id="newsContent<?php echo $key ?>" data-pk="<?php echo $key ?>" 
           class="newsContent no-padding"><?php echo $media["text"]; ?>
      </div>
      <?php }else if(@$media["reportAbuseCount"] >= 4){ ?>
      <div class="newsContent no-padding letter-red">Contenu masqué
      </div>
    <?php } ?>

    <?php if(@$media["tags"] && @$media["type"] != "activityStream") 
          foreach ($media["tags"] as $keyy => $tag) { 
            if($tag != "") { ?>
            <a href="javascript:;" class="btn-tag-news btn no-padding" 
               data-filter="<?php echo strpos($tag, "#")===false ? "#" : ""; echo $tag; ?>">
              <span class="text-red"><?php echo strpos($tag, "#")===false ? "#" : ""; echo $tag; ?></span>
            </a>
    <?php }} ?>

    <?php
        if(@$media["type"]=="activityStream" && 
           //@$media["verb"]==ActStr::TYPE_ACTIVITY_SHARE && 
           @$media["object"]["type"]){
     ?>
        
      <!-- <h4><a target="_blank" href="<?php echo @$media["href"]; ?>"><?php echo @$media["title"]; ?></a></h4> -->
    
      <?php if(!empty(@$media["object"])){ ?>
      <div id="" data-pk="<?php echo $key ?>"  data-type="<?php echo @$media["object"]["type"]; ?>" 
           class="col-md-12 no-padding margin-bottom-10 newsActivityStream<?php echo $media["object"]["id"]; ?>" 
                <?php if(@$media["object"]["type"] == "news"){ ?>style="border:1px solid #E3E3E3;"<?php } ?>>
        <?php 
             if(@$media["object"]["type"] == "news")
             $this->renderPartial('../news/timeline-panel', 
                        array(  "key"=>$media["object"]["id"],
                                "media"=>$media["object"],
                                "nameAuthor"=>@$media["object"]["authorName"] ? $media["object"]["authorName"] : "",
                                "authorType"=>@$media["object"]["authorType"] ? $media["object"]["authorType"] : "citoyens",
                                "authorId"=>@$media["object"]["authorId"],
                                "timezone"=>$timezone,
                                "thumbAuthor"=>@$media["object"]["author"]["profilThumbImageUrl"] ? 
                                                Yii::app()->createUrl($media["object"]["author"]["profilThumbImageUrl"]) : "",
                            ) 
                        ); 
        ?>  
      </div>

      <?php } ?>
    <?php } ?>
  </div>

  <?php if(@$srcMainImg != "" && $media["type"] != "activityStream"){ ?>
    <a class="inline-block bg-black" target="_blank" href="<?php echo @$media["href"]; ?>">
    <img class="img-responsive" src="<?php echo $srcMainImg; ?>" />
    </a>
  <?php } ?>


  <?php if(@$media["contentType"] == "youtube"){ ?>
  	<iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $media["idYoutube"]; ?>" 
            frameborder="0" allowfullscreen></iframe>
  <?php } ?>
  <?php if(@$media["media"]){ ?>
    <div id="result<?php echo $key ?>" class="bg-white results padding-15 col-md-12 col-sm-12 col-xs-12"></div>
  <?php } ?>


