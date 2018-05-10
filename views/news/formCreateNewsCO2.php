
<style>
  .tools_bar{
        border-bottom: 1px solid #E6E8E8;
  }
  .tools_bar .btn{
        border-right: 1px solid #E6E8E8;
  }
  .mosaicflow__column {
    float:left;
    }
.mosaicflow__item img {
    display:block;
    width:100%;
    height:auto;
}
.grayscale{
  filter: grayscale(0.7) blur(1px);
  -webkit-filter: grayscale(0.7) blur(1px);
  -moz-filter: grayscale(0.7) blur(1px);
  -o-filter: grayscale(0.7) blur(1px);
  -ms-filter: grayscale(0.7) blur(1px);
}
.newImageAlbum, .updateImageNews{
  width: 75px;
    height: 75px;
    margin: 5px;
    text-align: -webkit-center;
    position: relative;
    background-color: white;
    display: inline-block;
}
.updateImageNews > img {
  position: absolute;
  top:0px;
  left:0px;
}
.deleteDoc {
  position: absolute;
  top:0px;
  right: 0px;
}
.deleteDoc:hover > i {
    text-shadow: 0px 0px 2px rgba(0,0,0,0.5);
    font-size: 16px;
}
.spinner-add-image{
  position: absolute;
    z-index: 10;
    left: 20px;
    top: 20px;
}
.removeImage{
  position: absolute;
    z-index: 10;
    right: 0px;
  top: 0px;
  text-shadow: 0px 0px 2px black;
}
.thumb_sel .prev_thumb {
  background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -50px 0px;
  background-color: rgba(250,250,250,0.5);
  float: left;
  width: 26px;
  height: 22px;
  cursor: hand;
  cursor: pointer;
}
.thumb_sel .prev_thumb:hover {
  background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat 0px 0px;
}
.thumb_sel .next_thumb {
  background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -76px 0px;
  background-color: rgba(250,250,250,0.5);
  float: left;
  width: 24px;
  height: 22px;
  cursor: hand; 
  cursor: pointer;
}
.thumb_sel .next_thumb:hover {
  background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -26px 0px;
}
#form-news #dropdown_search{
  display:none;
  border: 1px solid #eee;
  max-height: 160px;
  overflow-y: auto;
  position: relative;
}
#form-news #dropdown_search .li-dropdown-scope{
  text-align: left;
  width:100%;
}
#form-news #dropdown_search .li-dropdown-scope a{
  font-size:12px;
      line-height: 25px;
}
/*.results{
  margin-top: 10px;
}*/

.timeline_element .timeline_text{
  font-size:14px !important;
}
.timeline_element .img-responsive{
  max-height:300px !important;
}

##form-news{
  display: inline-block;
    width: 100%;
    padding-bottom: 10px;
}
#btn-submit-form {
    /*right: 30px;
    position: absolute;
    bottom: 10px;*/
    position:relative;
    float: right;
}
.timeline_shared_picture{
  margin-top:5px;
}
.timeline_element .tag_item_map_list {
    color: #F00;
    font-weight: 200 !important;
    font-size: 12px !important;
    cursor: pointer;
}
.main-col-search{
  min-height:1100px !important;
}
.timeline_element .label-danger {
    margin-bottom: 3px;
    display: inline-block;
}
#footerDropdown{
  position:relative;
  background-color: transparent !important;
}
.tag.bold{
  font-weight:600 !important;
}
.timeline_element{
  padding-bottom: 0px;
}
.bar_tools_post {
    font-size: 15px;
}

#form-news hr , .list-select-scopes hr{
    border-top: 1px solid #d8d8d8;
}
#form-news hr.submit {
    margin: 0 0 10px 0 !important;
    display: block;
}

.extract_url textarea#get_url{
  box-shadow: none!important;
}
#form-news input#falseInput{
  border: none!important;
}
.mentions-input-box .mentions{
  font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
  /*left: 5px !important;
  top: 1px !important;*/
  padding:0 !important;
}
.updateMention .mentions-input-box .mentions{ 
  padding:10px !important;
}

</style>
<?php 
  $contextScopeNews=array(
    Organization::COLLECTION => array(
      "public"=>array(
        "icon"=>"globe",
        "label"=>ucfirst(Yii::t("common", "public")),
        "explain"=>Yii::t("news","Write a public message visible in live on selected places")
      ),
      "restricted"=>array(
        "icon"=>"rss",
        "label"=>ucfirst(Yii::t("common", "followers")),
        "explain"=>Yii::t("news", "Posted on followers and members wall and visible to all on this wall")//Visible to all on this wall and published on community's network",
      ),
      "private"=>array(
        "icon"=>"users",
        "label"=>ucfirst(Yii::t("common", "members")),
        "explain"=>Yii::t("news", "Posted on members wall and visible only for them")
      ),
      "init"=>array(
        "admin"=>"restricted",
        "noadmin"=>"private"
      )
    ),
    Project::COLLECTION => array(
      "public"=>array(
        "icon"=>"globe",
        "label"=>ucfirst(Yii::t("common", "public")),
        "explain"=>Yii::t("news","Write a public message visible in live on selected places")
      ),
      "restricted"=>array(
        "icon"=>"rss",
        "label"=>ucfirst(Yii::t("common", "followers")),
        "explain"=>Yii::t("news", "Posted on followers and contributors wall and visible to all on this wall")
      ),
      "private"=>array(
        "icon"=>"users",
        "label"=>ucfirst(Yii::t("common", "contributors")),
        "explain"=>Yii::t("news", "Posted on contributors wall and visible only for them")
      ),
      "init"=>array(
        "admin"=>"restricted",
        "noadmin"=>"private"
      )
    ),
    Event::COLLECTION => array(
      "public"=>array(
        "icon"=>"globe",
        "label"=>ucfirst(Yii::t("common", "public")),
        "explain"=>Yii::t("news","Write a public message visible in live on selected places")
      ),
      "restricted"=>array(
        "icon"=>"rss",
        "label"=>ucfirst(Yii::t("common", "attendees")),
        "explain"=>Yii::t("news", "Posted on attendees wall and visible to all on this wall"),
      ),
      "private"=>array(
        "icon"=>"users",
        "label"=>ucfirst(Yii::t("common", "admins")),
        "explain"=>Yii::t("news","Posted on administrators wall and visible only for them"),
      ),
      "init"=>array(
        "admin"=>"restricted",
        "noadmin"=>"private"
      )
    ),
    Person::COLLECTION => array(
      "public"=>array(
        "icon"=>"globe",
        "label"=>ucfirst(Yii::t("common", "public")),
        "explain"=>Yii::t("news","Write a public message visible in live on selected places")
      ),
      "restricted"=>array(
        "icon"=>"rss",
        "label"=>ucfirst(Yii::t("common", "followers")),
        "explain"=>Yii::t("news", "Posted on followers wall and visible to all on this wall"),
      ),
      "private"=>array(
        "icon"=>"lock",
        "label"=>ucfirst(Yii::t("common", "private")),
        "explain"=>Yii::t("news","Visible only to me"),
      ),
      "init"=>array(
        "admin"=>"restricted",
        "noadmin"=>"private"
      )
    ),
    "city" => array(
      "public"=>array(
        "icon"=>"globe",
        "label"=>ucfirst(Yii::t("common", "public")),
        "explain"=>Yii::t("news","Write a public message visible in live on selected places"),
      )
    )
  );
  $isLive = isset($_GET["isLive"]) ? true : false;
  $contextName = "";
  $contextIcon = "bookmark fa-rotate-270";
  $contextTitle = "";
  $imgProfil = $this->module->assetsUrl . "/images/news/profile_default_l.png"; 
  $textForm = Yii::t("common","Write a public message visible on the wall of selected places");
  if( isset($type) && $type == Organization::COLLECTION && isset($parent) ){
    $contextName = $parent["name"];
    $contextIcon = "users";
    $contextTitle = Yii::t("common","Participants");
    //$restricted = Yii::t("common","Visible to all on this wall and published on community's network");
    //$titleRestricted = "Restreint";
    //$private = Yii::t("common","Visible only to the members"); 
    //$titlePrivate = "Privé";
    //$scopeBegin= ucfirst(Yii::t("common", "followers"));  
    //$public = true;
    //$iconBegin= "connectdevelop";
    $headerName= "Journal de l'organisation";//.$contextName;
    $topTitle= "Journal de l'organisation";//.$contextName;
    if(@$canManageNews && $canManageNews==true)
      $textForm = Yii::t("common","Post a message in the wall of").
                  " <b>".$contextName."</b>";
    else
      $textForm = Yii::t("common","Write a private message to")." <b>".$contextName."</b>";
  }
  else if((isset($type) && $type == Person::COLLECTION) || (isset($parent) && !@$type)){
    if((@$isLive && $isLive==true) || !@Yii::app()->session["userId"] || (Yii::app()->session["userId"] !=$contextParentId)){
      //Visible de tous sur
      //Menu::person($parent);
    
      $contextName =$parent["name"];
      $contextIcon = "<i class='fa fa-circle text-yellow'></i> <i class='fa fa-user text-dark'></i> ";
      $contextTitle =  Yii::t("common", "DIRECTORY of")." ".$contextName;
      if(@Yii::app()->session["userId"] && $contextParentId==Yii::app()->session["userId"]){
      //  $restricted = Yii::t("common","Visible to all on my wall and published on my network");
       // $private = Yii::t("common","Visible only to me");
        $textForm = Yii::t("common","Published a message in your wall for your network");
       // $public = true;
      } 
      if(Yii::app()->session["userId"] ==$contextParentId){
        $headerName= "Mon journal";
        $topTitle = $headerName;
      }else{
        $headerName= "Journal de : ".$contextName;
        $topTitle = $headerName;
        $textForm = Yii::t("common","Write a private message to")." <b>".$contextName."</b>";
      }
    }
    else{
      $shortName=explode(" ", $parent["name"]);
      //$headerName= "Bonjour <span class='text-red'>".addslashes($shortName[0])."</span>, l'actu de votre réseau";
      $headerName= "L'actu de votre réseau";
      //$restricted = Yii::t("common","Visible to all on my wall and published on my network");
      //$private = Yii::t("common","Visible only to me");
      $textForm = Yii::t("common","Published a message in your wall for your network");
    }
    //$scopeBegin= ucfirst(Yii::t("common", "followers")); 
    //$iconBegin= "connectdevelop";
  }
  else if( isset($type) && $type == Project::COLLECTION && isset($parent) ){
    $contextName = $parent["name"];
    $contextIcon = "lightbulb-o";
    $contextTitle = Yii::t("common", "Contributors of project");
    //$restricted = Yii::t("common","Visible to all on this wall and published on community's network");
    //$private = Yii::t("common","Visible only to the project's contributors"); 
    //$scopeBegin= ucfirst(Yii::t("common", "followers"));  
    //$iconBegin= "connectdevelop";
    //$public = true;
    $headerName= "Journal du projet";//.$contextName;
    $topTitle = "Journal du projet";//.$contextName;
    if(@$canManageNews && $canManageNews==true)
     $textForm = Yii::t("common","Post a message in the wall of").
                  " <b>".$contextName."</b>";
    else
      $textForm = Yii::t("common","Write a private message to")." <b>".$contextName."</b>";
  }else if( isset($type) && $type == Event::COLLECTION && isset($parent) ){
    $contextName = $parent["name"];
    $contextIcon = "calendar";
    $contextTitle = Yii::t("common", "Contributors of event");
    //$restricted = Yii::t("common","Visible to all on this wall and published on community's network");
    //$scopeBegin= ucfirst(Yii::t("common", "followers")); 
    //$iconBegin= "connectdevelop";
    $headerName= "Journal de l'événement";//.$contextName;
    $topTitle = "Journal de l'événement";//.$contextName;
    //$public = true;
    //if(@$canManageNews && $canManageNews==true)
      $textForm = Yii::t("common","Post a message in the wall of").
                  " <b>".$contextName."</b>";
    //else
      //$textForm = Yii::t("common","Write a private message to")." ".$contextName;

  }

  else if( isset($type) && $type == City::CONTROLLER && isset($city) ){
    $contextName = Yii::t("common","City")." : ".$city["name"];
    $contextIcon = "university";
    $contextTitle = Yii::t("common", "DIRECTORY Local network of")." ".$city["name"];
    //$scopeBegin= "Public";  
    //$iconBegin= "globe";
    $headerName= "Actualités de ".$city["name"];
    $topTitle = ""; //$headerName;
    $textForm = Yii::t("common","Write a idea, a message in the city wall of")." <b>".$contextName."</b>";

  }
  /*else if( isset($type) && $type == "pixels"){
    //$contextName = "<i class='fa fa-rss'></i> Signaler un bug";
    //$contextTitle = Yii::t("common", "Contributors of project");
    $headerName= " La foire aux bugs";
    $topTitle = " La foire aux bugs";
    $textForm = Yii::t("common","Write a bug or an idea to improve the development of communecter");
  }*/

  $imgProfil = "";
  if($contextParentType != "city"){
    Menu::news($type);
    //$this->renderPartial('../default/panels/toolbar'); 
    $sizeForm="col-sm-12"; 
  }else
    $sizeForm="col-sm-10 col-sm-offset-1";

?>
<!-- <div id="newLiveFeedForm" class="col-xs-12 no-padding margin-bottom-10"></div> -->

<?php if(isset(Yii::app()->session['userId'])){ ?>
  <div id="formCreateNewsTemp" style="float: none;" class="center-block hidden">
    <div class='no-padding form-create-news-container <?php echo $sizeForm ?>'>

      <div class='padding-10 partition-light no-margin text-left header-form-create-news' style="margin-bottom:-40px !important;">
        <i class='fa fa-angle-down'></i> <i class="fa fa-file-text-o"></i> <span id="info-write-msg"><?php echo $textForm; ?></span>
        <a class="btn btn-xs pull-right" style="margin-top: -4px;" onclick="javasctipt:showFormBlock(false);">
          <i class="fa fa-times"></i>
        </a>

        <?php  //if($type != City::CONTROLLER){ //si on est pas sur le live, on met le bouton "creer sondage" ?>
        <button onclick="dyFObj.openForm('survey')" class="btn btn-link btn-xs bold letter-light hidden-xs pull-right margin-right-5"
                style="margin-top: -3px;">
                <i class="fa fa-plus-circle"></i> <?php echo Yii::t("cooperation", "create a survey") ?>
        </button>
        <?php //} ?>

      </div>

      <div class="tools_bar bg-white">
        <?php if((@$canManageNews && $canManageNews==true) || (@$isLive && $isLive == true)){ ?>
        <div class="user-image-buttons">
          <form method="post" id="photoAddNews" enctype="multipart/form-data">
            <span class="btn btn-white btn-file fileupload-new btn-sm uploadImageNews"  <?php //if (!$authorizedToStock){ echo 'onclick="addMoreSpace();"'; } ?>>
            <span class="fileupload-new"><i class="fa fa-picture-o fa-x"></i> </span>
              <?php //if ($authorizedToStock){ ?>
                <input type="file" accept=".gif, .jpg, .png" name="newsImage" id="addImage" onchange="showMyImage(this);">
              <?php //} ?>
            </span>
          </form>
        </div>
        <?php } ?>
      </div>

      <div id='form-news' class="col-sm-12 no-padding">
        
        <input type="hidden" id="parentId" name="parentId" 
               value="<?php if($contextParentType != "city") echo $contextParentId; else echo Yii::app()->session["userId"]; ?>"/>
        <input type="hidden" id="parentType" name="parentType" 
               value="<?php if($contextParentType != "city") echo $contextParentType; else echo Person::COLLECTION; ?>"/> 
        
        <input type="hidden" id="typeNews" name="type" value="news"/>

        <input  type="text" id="falseInput" onclick="javascript:showFormBlock(true);" 
            class="col-xs-12 col-md-12" placeholder="<?php echo Yii::t("common","Express yourself ...") ?>" style="padding:15px;"/>

        <div class="extract_url" style="display:none;">
          <div class="padding-10 bg-white">
            <img class="loading_indicator" src="<?php echo $this->module->assetsUrl ?>/images/news/ajax-loader.gif">
            <textarea id="get_url" placeholder="<?php echo Yii::t("common","Express yourself ...") ?>" class="get_url_input form-control textarea mention" style="border:none;background:transparent !important" name="getUrl" spellcheck="false" ></textarea>
            <ul class="dropdown-menu" id="dropdown_search" style="">
            </ul>

            <div id="results" class="bg-white results col-sm-12 padding-10"></div>
          </div>
        </div>
        <div class="form-group tagstags col-md-12 col-sm-12 col-xs-12 no-padding">
            <input id="tags" type="" data-type="select2" name="tags" placeholder="#Tags" value="" style="width:100%;">
        </div>
        <div id="scopeListContainerForm" class="form-group col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom-10"></div>
        <div class="form-actions col-md-12 col-sm-12 col-xs-12 no-padding" style="display: block;">
          
          

          <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
            <hr class="submit">
            
            <button id="btn-submit-form" onclick="saveNews();" class="btn btn-success pull-right">
              <?php echo Yii::t("common","Submit") ?> <i class="fa fa-arrow-circle-right"></i>
            </button>


          <?php if((@$canManageNews && $canManageNews==true) 
                || (@Yii::app()->session["userId"] 
                && $contextParentType==Person::COLLECTION 
                && Yii::app()->session["userId"]==$contextParentId)){ ?>
          
          <!--<div id="tagScopeListContainer" class="list_tags_scopes col-xs-12 no-padding"></div>
          <input type="hidden" name="scope" value="public"/>-->
          
          <div class="dropdown col-md-6 no-padding">
            <a data-toggle="dropdown" class="btn btn-default" id="btn-toogle-dropdown-scope" href="#"><i class="fa fa-<?php echo @$contextScopeNews[$contextParentType][$contextScopeNews[$contextParentType]["init"]["admin"]]["icon"] ?>"></i> <?php echo @$contextScopeNews[$contextParentType][$contextScopeNews[$contextParentType]["init"]["admin"]]["label"] ?> <i class="fa fa-caret-down" style="font-size:inherit;"></i></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
              <?php if(@$contextScopeNews && @$contextScopeNews[$contextParentType]){
                  foreach($contextScopeNews[$contextParentType] as $key => $v){
                    if($key != "init"){ ?>
                      <li>
                        <a href="javascript:;" class="scopeShare" data-value="<?php echo $key ?>"><h4 class="list-group-item-heading"><i class="fa fa-<?php echo $v["icon"] ?>"></i> <?php echo $v["label"] ?></h4>
                          <p class="list-group-item-text small"><?php echo $v["explain"] ?></p>
                        </a>
                      </li>
                    <?php } 
                  }
                } ?>
              <?php /*if (@$private && ($contextParentType==Project::COLLECTION || $contextParentType==Organization::COLLECTION)){ ?>
              <li>
                <a href="javascript:;" id="scope-my-network" class="scopeShare" data-value="private"><h4 class="list-group-item-heading"><i class="fa fa-lock"></i> <?php echo ucfirst(Yii::t("common", "private")) ?></h4>
                  <p class="list-group-item-text small"><?php echo $private ?></p>
                </a>
              </li>
              <?php } ?>
              <?php if(@$restricted){ ?>
                <li>
                <a href="javascript:;" id="scope-my-network" class="scopeShare" data-value="restricted"><h4 class="list-group-item-heading"><i class="fa fa-connectdevelop"></i> <?php echo ucfirst(Yii::t("common", "followers")) ?></h4>
                  <p class="list-group-item-text small"><?php echo $restricted ?></p>
                </a>
              </li>
              <?php } ?>
              <?php if(@$public){ ?>
              <li>
                <a href="javascript:;" id="scope-my-wall" class="scopeShare" data-value="public"><h4 class="list-group-item-heading"><i class="fa fa-globe"></i> <?php echo ucfirst(Yii::t("common", "public")) ?></h4>
                  <!--<div class="small" style="padding-left:12px;">-->
                <p class="list-group-item-text small"><?php echo Yii::t("common","Visible to all and posted on cities' live")?></p>
                </a>
              </li>
              <?php } ?>
              <?php if (@$private && $contextParentType==Person::COLLECTION){ ?>
              <li>
                <a href="javascript:;" id="scope-my-network" class="scopeShare" data-value="private"><h4 class="list-group-item-heading"><i class="fa fa-lock"></i> <?php echo ucfirst(Yii::t("common", "private")) ?></h4>
                  <p class="list-group-item-text small"><?php echo $private ?></p>
                </a>
              </li>
              <?php } */ ?>
              <!--<li>
                <a href="#" id="scope-select" data-toggle="modal" data-target="#modal-scope"><i class="fa fa-plus"></i> Selectionner</a>
              </li>-->
            </ul>
          </div>  

          
          <?php if($contextParentType == Organization::COLLECTION || $contextParentType == Project::COLLECTION || $contextParentType == Event::COLLECTION){ ?>
          <div class="dropdown no-padding pull-right">
            <a data-toggle="dropdown" class="btn btn-default" id="btn-toogle-dropdown-targetIsAuthor" href="#">
            <?php if(@$parent["profilThumbImageUrl"]){ ?>
              <img height=20 width=20 src='<?php echo Yii::app()->getRequest()->getBaseUrl(true).$parent["profilThumbImageUrl"] ?>'>
            <?php } else{ ?>
              <img height=20 width=20 src='<?php echo $this->module->assetsUrl.'/images/thumb/default_'.$contextParentType.'.png' ?>'>  
            <?php } ?>
              <i class="fa fa-caret-down" style="font-size:inherit;"></i>
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
              <li>
                <a href="javascript:;" class="targetIsAuthor" data-value="1">
                  <h4 class="list-group-item-heading">
                  <?php if(@$parent["profilThumbImageUrl"]){ ?>
                    <img height=20 width=20 src='<?php echo Yii::app()->getRequest()->getBaseUrl(true).$parent["profilThumbImageUrl"] ?>'>
                  <?php } else { ?>
                    <img height=20 width=20 src='<?php echo $this->module->assetsUrl.'/images/thumb/default_'.$contextParentType.'.png' ?>'>  
                  <?php } ?>
                  <?php echo $contextName ?></h4>
                  <p class="list-group-item-text small"><?php echo Yii::t("form", "Show {who} as author",array("{who}"=>$contextName)) ?></p>
                </a>
              </li>
              <li>
                <a href="javascript:;" class="targetIsAuthor" data-value="0"><h4 class="list-group-item-heading">
                  <?php if(@Yii::app()->session["user"]["profilThumbImageUrl"]){ ?>
                  <img height=20 width=20 src='<?php echo Yii::app()->getRequest()->getBaseUrl(true).Yii::app()->session["user"]["profilThumbImageUrl"]; ?>'>
                  <?php } else {  ?>
                    <img height=20 width=20 src='<?php echo $this->module->assetsUrl.'/images/thumb/default_citoyens.png' ?>'>  
                  <?php } ?>
                  <?php echo ucfirst(Yii::t("common", "Me")) ?></h4>
                  <p class="list-group-item-text small"><?php echo Yii::t("form","I am the author") ?></p>
                </a>
              </li>
            </ul>
            <input type="hidden" id="authorIsTarget" value="1"/>
          </div>  
            <?php } ?>    
          <?php } ?>



          <?php if($type=="city"){ ?>
            <input type="hidden" name="scope" value="public"/>
          <?php } else if((@$canManageNews && $canManageNews=="true") || (
              @Yii::app()->session["userId"] && 
              $contextParentType==Person::COLLECTION && Yii::app()->session["userId"]==$contextParentId)){
                if(in_array($contextParentType,array(Event::COLLECTION,Person::COLLECTION,Project::COLLECTION,Organization::COLLECTION))){ ?>
                  <input type="hidden" name="scope" value="restricted"/>
               <?php } else { ?>
                  <input type="hidden" name="scope" value="public"/>
              <?php } 

            }else if($contextParentType==Event::COLLECTION){?>
            
            <input type="hidden" name="scope" value="restricted"/>

          <?php } else { ?>

            <input type="hidden" name="scope" value="private"/>

          <?php } ?>
          </div>
        </div>
      </div>
     </div>
  </div>
<?php }else{ ?>
  <div class="col-xs-12 text-center font-montserrat">
    <hr>
    <h5 class="letter-red">
      <i class="fa fa-ban"></i> <?php echo Yii::t("cooperation","You are not logged"); ?><br>
      <small><?php echo Yii::t("cooperation","Please login to post a message"); ?></small>
      <br><br>

      <button class="btn btn-link bg-green-k" data-toggle="modal" data-target="#modalLogin">
        <i class="fa fa-sign-in"></i> <?php echo Yii::t("cooperation","I'm logging in"); ?>
      </button>
      <button class="btn btn-link bg-blue-k margin-left-10" data-toggle="modal" data-target="#modalRegister">
        <i class="fa fa-plus-circle"></i> <?php echo Yii::t("cooperation","I create my account"); ?>
      </button> 
      <br><br>
      <small class="letter-blue"><i class="fa fa-check"></i> <?php echo Yii::t("cooperation","free registration"); ?></small>
    </h5>
    <hr>
  </div>
<?php } ?>
<script type="text/javascript">
  var contextScopeNews = <?php echo json_encode($contextScopeNews) ?>;
</script>