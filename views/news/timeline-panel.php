
  
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
            <?php //if(@$media["sharedBy"]) $pluriel = " pluriel"; ?>
            <!-- Get Author news / activity -->
            <?php 
              if(!@$media["verb"] || (@$media["verb"] && $media["verb"]!="share")){
                  if(@$media["targetIsAuhtor"] || $media["type"]=="activityStream"){
                    if(@$media["target"]["profilThumbImageUrl"] && $media["target"]["profilThumbImageUrl"] != "")
                      $thumbAuthor = Yii::app()->createUrl('/'.$media["target"]["profilThumbImageUrl"]);
                    else
                      $thumbAuthor = $this->module->assetsUrl."/images/thumb/default_".$media["target"]["type"].".png";
          
                    $authorName=$media["target"]["name"];
                    $authorId=$media["target"]["id"];
                    $authorType=$media["target"]["type"];
                  } else{
                    $thumbAuthor =  @$media['author']['profilThumbImageUrl'] ? 
                      Yii::app()->createUrl('/'.@$media['author']['profilThumbImageUrl']) 
                      : $this->module->assetsUrl."/images/news/profile_default_l.png";
                    $authorName=$media["author"]["name"];
                    $authorId=$media["author"]["id"];
                    $authorType=Person::COLLECTION;
                  }
              ?>
              <img class="pull-left img-circle" src="<?php echo @$thumbAuthor; ?>" height=40>
            
              <div class="pull-left padding-5 col-md-7 col-sm-7" style="line-height: 15px;">
               <a href="#page.type.<?php echo $authorType ?>.id.<?php echo $authorId ?>" class="lbh">
                <?php echo @$authorName; ?>
                </a>
              <?php } ?>
              <?php if(@$media["sharedBy"]){ 
                  $countShareBy=count($media["sharedBy"]); 
                  if($countShareBy>1){ ?>
                    <div class="pull-left padding-5 col-md-12 col-sm-12" style="line-height: 15px;">
                  <?php }
                  $i=0; 
                  foreach ($media["sharedBy"] as $keyS => $share) { ?>
                      <?php if(@$nameAuthor==@$share["name"] && $countShareBy == 1){ $pluriel = ""; } ?>
                      
                      <?php if($i < 3 && @$nameAuthor!=@$share["name"]){ ?>
 
                      <?php if($i > 0 && $i < $countShareBy-1){ ?>, 
                      <?php }else if($i>0 && $countShareBy > 1){ echo Yii::t("common", "and"); }  ?>
                      <?php if($countShareBy==1){ 
                          if(@$share["profilThumbImageUrl"] && $share["profilThumbImageUrl"] != "")
                            $thumbAuthor = Yii::app()->createUrl('/'.$share["profilThumbImageUrl"]);
                          else
                            $thumbAuthor = $this->module->assetsUrl."/images/thumb/default_".$share["type"].".png";
                          ?>
                          <img class="pull-left img-circle" src="<?php echo @$thumbAuthor; ?>" height=40>
                          <div class="pull-left padding-5 col-md-7 col-sm-7" style="line-height: 15px;">
                        <?php } ?>
                       <a href="#page.type.<?php echo @$share["type"]; ?>.id.<?php echo $keyS ?>" class="lbh">
                        <?php if($i==0) echo ucfirst(@$share["name"]); else echo @$share["name"]; ?>
                      </a> 
                    <?php }else if($i == 3){ ?>
                      <?php echo Yii::t("common", "and"); ?> <?php echo sizeof($media["sharedBy"]) - 2; ?> autres personnes
                    <?php } $i++; ?>
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
                <?php $iconColor = @Element::getColorIcon($media["object"]["type"]); 
                    if($media["verb"]=="create")
                      $tradVerb="created";
                    else if($media["verb"]=="share"){
                      if(count($media["sharedBy"])>1)
                        $tradVerb="have shared";
                      else
                        $tradVerb="shared";
                    }
                ?>
                <i class="fa fa-plus-circle"></i> <?php echo Yii::t("news", $tradVerb); ?> 
                <span class="text-<?php echo @$iconColor; ?>">
                  <a href="#page.type.<?php echo @$media["object"]["type"]; ?>.id.<?php echo @$media["object"]["id"]; ?>" 
                     class="lbh">
                    <?php 
                      $pronom="a";
                      if(@$media["object"] && @$media["object"]["activity"])
                        $objectTypeShare=$media["object"]["activity"]["type"]; 
                      else
                        $objectTypeShare=$media["object"]["type"]; 
                      if(in_array($objectTypeShare,[Organization::COLLECTION,Event::COLLECTION]))
                        $pronom="an";
                      echo Yii::t("common", $pronom." ".Element::getControlerByCollection($objectTypeShare));
                    ?>
                            
                  </a>
                </span> 
                <!-- Share object --> 
                <?php   
                  if($media["verb"]=="share"){ 
                    if(@$media["object"]["targetIsAuhtor"] || $media["type"]=="activityStream"){
                        $objectAuthorName=@$media["object"]["target"]["name"];
                        $objectAuthorId=@$media["object"]["target"]["id"];
                        $objectAuthorType=@$media["object"]["target"]["type"];
                      } else {
                        $objectAuthorName=@$media["object"]["author"]["name"];
                        $objectAuthorId=@$media["object"]["auhtor"]["id"];
                        $objectAuthorType=Person::COLLECTION;
                      }
                  ?>
                  de <a href="#page.type.<?php echo @$objectAuthorType ?>.id.<?php echo @$objectAuthorId; ?>" 
                        class="lbh text-<?php echo @$iconColor; ?>">
                    <?php echo @$objectAuthorName ?>
                    </a>
                <?php } } ?>

              <?php if(@$media["target"]["id"] != @$authorId && 
                       @$media["verb"] != "create") { ?>
                <?php if(@$media["target"]["id"] != @$contextId){ ?>
                      sur le mur de 
                      <a href="#page.type.<?php echo @$media["target"]["type"]; ?>.id.<?php echo @$media["target"]["id"]; ?>" 
                              class="lbh">
                              <?php echo @$media["target"]["name"]; ?>
                      </a>
                <?php }else if(@$media["target"]["id"] == @$contextId && @$contextId == Yii::app()->session["userId"] ){ ?>
                    sur votre mur
                <?php }else if(@$media["target"]["id"] == @$contextId && @$contextId != Yii::app()->session["userId"] ){ ?>
                    sur ce mur
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
          <?php if (@Yii::app()->session["userId"] && (!@$media["verb"] || ($media["verb"]=="share" && !@$media["sharedBy"]))){ ?>
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
          <?php if(!@$media["verb"] || ($media["verb"]=="share" && !@$media["sharedBy"])){ ?>
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
          <?php } ?>
        </h5>
  </div>

  <div class="timeline-body  col-md-12 text-left margin-bottom-10">
    <?php if(!empty(@$media["text"]) || (@$media["sharedBy"] && count($media["sharedBy"])==1 && !empty(@$media["sharedBy"][0]["text"]))){ 
        $text=@$media["text"];
        if(@$media["sharedBy"])
          $text=$media["sharedBy"][0]["text"];
      ?>
    <div id="newsContent<?php echo $key ?>" data-pk="<?php echo $key ?>" 
         class="newsContent no-padding newsContent<?php echo $key ?>"><?php echo $text; ?>
    </div>
    <?php } ?>
    <?php if(@$media["tags"] && @$media["type"] != "activityStream") 
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
    
      <?php if(!empty(@$media["object"])){
          $objectId=$media["object"]["id"];
          if(@$media["object"]["activity"])
            $objectId=$media["object"]["activity"]["id"];
       ?>
        <div id="" data-pk="<?php echo $key ?>" 
             class="col-md-12 no-padding margin-bottom-10 newsActivityStream<?php echo $objectId; ?> margin-top-10">
          <?php 
               if(@$media["object"]["type"] == "news" && !@$media["object"]["activity"])
                 $this->renderPartial('../news/timeline-panel', 
                          array(  "key"=>$media["object"]["id"],
                                  "media"=>$media["object"],
                                  "timezone"=>$timezone
                              ) 
                          ); 
          ?>  
        </div>
        <?php if(@$media["sharedBy"] && count($media["sharedBy"])>1){ 
          //IF THERE ARE MORE THAN ONE SHARE
          ?>
        <div class="contentSharedBy col-md-12 col-sm-12 col-xs-12">
          <?php foreach($media["sharedBy"] as $e => $value){
            $share=array("id"=>$key, 
              "type"=> "news", 
              "targetIsAuhtor"=>true,
              "author"=>array(),
              "created"=>$value["date"],
              "target"=>array(
                "id"=>$e,
                "type"=>$value["type"],
                "profilThumbImageUrl"=>$value["profilThumbImageUrl"], 
                "name"=>$value["name"]
              ),
              "text"=>@$value["text"],
              "sharedByDesign"=>true
            );
            if(@$value["author"])
              $authorShared=array("id"=>$e["author"],"type"=> Person::COLLECTION);
            else
              $authorShared=array("id"=>$e,"type"=> Person::COLLECTION);
            array_push($share["author"],$authorShared);
            ?> 
            <div class="shadow2 col-md-12 col-sm-12 col-xs-12">
            <?php $this->renderPartial('../news/timeline-panel',
              array(  "key"=>$key,
                    "media"=>$share,
                    "timezone"=>$timezone,
                    "sharedByDesign"=>true
                ) 
              ); ?>
              </div>
          <?php } ?>
        </div>
        <?php } ?>
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


