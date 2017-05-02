
  
  <div id="newsTagsScope<?php echo $key ?>" class="col-md-12 col-sm-12 col-xs-12">
    
    <?php $count = 0; $allScope = "";
          if(@$media["scope"]) 
          foreach (array("cities", "departements", "regions") as $s) {
            if(@$media["scope"][$s])
            foreach ($media["scope"][$s] as $keyy => $scopes) {
              foreach ($scopes as $k => $v) {
                foreach (array("postalCode", "addressLocality", "name") as $kk => $s) {
                  if(@$k == $s && $v != ""){ 
                    if($count<3){ ?>
                    <span class='label label-danger pull-right margin-left-5 margin-top-10'>
                      <i class='fa fa-bullseye'></i> <?php echo $v; ?>
                    </span>
    <?php           }else{ $allScope .= " ".$v; }  $count++; 
                  }
                }
              }
            }
          } 
    ?>
    <?php if($count >=3){ ?>
      <span class='label text-red pull-right margin-left-5 margin-top-10 tooltips' 
            data-title="<?php echo $allScope; ?>" data-toogle="tooltip">
        <i class='fa fa-plus'></i> <?php echo $count-3;?>
      </span>
    <?php } ?>
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
            <?php $pluriel = ""; //var_dump($media); ?>
            <?php if(!@$media["sharedBy"]){ ?>
              <img class="pull-left img-circle" src="<?php echo @$thumbAuthor; ?>" height=40>
            <?php }else{ $pluriel = " pluriel"; } ?>

            <div class="pull-left padding-5 col-md-6 col-sm-6" style="line-height: 15px;">
              <a href="#page.type.<?php echo $authorType ?>.id.<?php echo $authorId ?>" class="lbh pull-left">
                <?php echo @$nameAuthor; ?>
              </a>
              <?php if(@$media["sharedBy"]){ ?>
                <?php foreach ($media["sharedBy"] as $keyS => $share) { ?>
                    <?php if($keyS < 2){ ?>
                      <?php if($keyS < sizeof($media["sharedBy"])-1){ ?>, 
                      <?php }else if(sizeof($media["sharedBy"]) > 0){ ?> et <?php } ?>

                      <a href="#page.type.<?php echo @$share["type"]; ?>.id.<?php echo @$share["id"] ?>" class="lbh">
                        <?php echo @$share["name"]; ?>
                      </a>
                    <?php }else if($keyS == 2){ ?>
                      et <?php echo sizeof($media["sharedBy"]) - 2; ?> autres personnes
                    <?php } ?>
                <?php } ?>
              <?php } ?>
              <br>

              <span class="margin-top-5">
              <?php if(@$media["type"]=="news") { ?>
                <i class="fa fa-pencil-square"></i> a publié 
                <a href="#page.type.<?php echo @$media["type"]; ?>.id.<?php echo @$media["_id"]; ?>" class="lbh">
                  un message
                </a>
              <?php } ?>
              
               
              <?php if(@$media["type"]=="activityStream") { ?>
                <?php $iconColor = @Element::getColorIcon($media["object"]["type"]); ?>
                <i class="fa fa-plus-circle"></i> <?php echo Yii::t("news","verb ".$media["verb"].$pluriel); ?> 
                <span class="text-<?php echo @$iconColor; ?>">
                  <a href="#page.type.<?php echo @$media["object"]["type"]; ?>.id.<?php echo @$media["object"]["id"]; ?>" 
                     class="lbh">
                    <?php echo Yii::t("news", "displayShared-".@$media["object"]["type"]); ?>
                  </a>
                </span> 
                <?php if(@$media["object"]["type"] == "news"){ ?>
                de <a href="#page.type.<?php echo @$media["object"]["authorType"]; ?>.id.<?php echo @$media["object"]["authorId"]; ?>" 
                      class="lbh text-<?php echo @$iconColor; ?>">
                  <?php echo @$media["object"]["authorName"]; ?>
                  </a>
                <?php } ?>
              <?php } ?>

              <?php if(@$media["target"]["id"] != @$authorId && @$media["target"]["id"] != @$contextId) { ?>
                sur le mur de 
                <a href="#page.type.<?php echo @$media["target"]["type"]; ?>.id.<?php echo @$media["target"]["id"]; ?>" 
                        class="lbh">
                        <?php echo @$media["target"]["name"]; ?>
                </a>
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
          <span class="margin-top-10 margin-bottom-10 hidden-xs pull-right">
            <small>
              <i class="fa fa-clock-o"></i> 
              <?php if(@$media["type"] == "activityStream" && @$media["verb"] == ActStr::TYPE_ACTIVITY_SHARE) 
                    echo Translate::pastTime(date(@$media["updated"]->sec), "timestamp", $timezone); 
                    else
                    echo Translate::pastTime(date(@$media["created"]->sec), "timestamp", $timezone); 
              ?>
            </small>

          </span>
        </h5>
  </div>

  <div class="timeline-body  col-md-12 text-left margin-bottom-10">
    <?php if(!empty(@$media["text"])){ ?>
    <div id="newsContent<?php echo $key ?>" data-pk="<?php echo $key ?>" class="newsContent no-padding"><?php echo $media["text"]; ?>
    </div>
    <?php } ?>
    <?php if(@$media["tags"]) 
          foreach ($media["tags"] as $keyy => $tag) { 
            if($tag != "") { ?>
            <a href="javascript:;" class="filter btn no-padding" data-filter=".'+tag+'">
              <span class="text-red">#<?php echo $tag; ?></span>
            </a>
    <?php }} ?>

    <?php
        if(@$media["type"]=="activityStream" && 
           //@$media["verb"]==ActStr::TYPE_ACTIVITY_SHARE && 
           @$media["object"]["type"]){
     ?>
        
      <!-- <h4><a target="_blank" href="<?php echo @$media["href"]; ?>"><?php echo @$media["title"]; ?></a></h4> -->
    
      <?php if(!empty(@$media["object"])){ ?>
      <div id="newsActivityStream<?php echo $media["object"]["id"]; ?>" data-pk="<?php echo $key ?>" 
           class="col-md-12 no-padding margin-bottom-10" 
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
                                                $media["object"]["author"]["profilThumbImageUrl"] : "",
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
    <div id="result<?php echo $key ?>" class="bg-white results col-sm-12"></div>
  <?php } ?>


