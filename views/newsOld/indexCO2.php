<?php 

    $timezone = "";
		$pair = false;
    $nbCol = @$nbCol ? $nbCol : 2;

    $imgDefault = $this->module->assetsUrl.'/images/news/profile_default_l.png';
    if(count($news) < 5) { 
      if(@Yii::app()->session["userId"] && $contextParentId==Yii::app()->session["userId"] && $isLive){
        $jsonFirstStep=CO2::getContextList("userFirstStep");
        $news=array_merge($news, $jsonFirstStep);
      }
    }
?>


<style>
  .timeline-heading h5{
    height: 55px;
  }
  .timeline-panel{
    background-color: white;
  }

  <?php if($nbCol == 1){ ?>
    .timeline > li{
      width:100%;
    }
    .timeline::before {
      left:0;
    }
  <?php } ?>

  .btn-green{
    background-color: #5CB85C;
  }

  #get_url{
    min-height:100px!important;
    padding:0px;
  }
  .get_url_input {
    font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  }
  
  input#addImage{
    display: none;
  }

#formCreateNewsTemp .form-create-news-container, #formActivity{
    /*max-width: 700px;*/
}
.newsContent{ 
  white-space: pre-line; 
  word-wrap: break-word;
}

.select2-container-multi .select2-choices .select2-search-choice{
  background-color: white !important;
  box-shadow: none;
  background-image: none;
  padding: 8px 8px 8px 22px;
  margin: 8px 0px 0px 8px;
  color: #ea4335 !important;
  border: 1px #ea4335 solid;
}

.select2-container-multi .select2-search-choice-close{
  left: 2px;
  margin: 4px;
}
.select2-search-choice-close::before {
  color: #ea4335 !important;
}


</style>
<script type="text/javascript" >
var updateNews= new Object;
</script>
<div class="col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom-15" 
     style="<?php if(!@$isLive){ ?>padding-left:25px!important;<?php } ?>">

  <?php //var_dump($params); 
        $params = array(
                  "type" => $type,
                  "contextParentId" => $contextParentId,
                  "parent" => $parent,
                  "contextParentType" => $contextParentType,
                  "canManageNews" => @$canManageNews,
                  "isLive" => @$isLive,
                  "authorizedToStock" => @$authorizedToStock
          );
        $this->renderPartial('formCreateNewsCO2', $params);
  ?>
</div>

<ul class="timeline inline-block" id="news-list">
  
    <?php $this->renderPartial('newsPartialCO2', 
                          array( "news"=>$news,
                                 "pair"=>$pair,
                                 "nbCol"=>$nbCol,
                                 "timezone"=>$timezone,
                                 "imgDefault" => $imgDefault,
                                 "contextParentId" => $contextParentId,
                                 "contextParentType" => $contextParentType,
                                 "canManageNews" => @$canManageNews,
                                 "isLive" => @$isLive,
                                 "isFirst"=>true)); ?>
</ul>


<?php $this->renderPartial('modalModeration', array()); ?>


<script type="text/javascript" >
  var news = <?php echo json_encode($news); ?>;
  var newsScopes={};
  var loadingData = false;
  //var scrollEnd = false;
  var currentIndexMin = 0;
  var currentIndexMax = 10;
  var isLive = <?php echo json_encode(@$isLive) ?>;

  var indexStep = currentIndexMax;
  var dateLimit = 0;  

  var initLimitDate = <?php echo json_encode(@$limitDate) ?>;

  var contextParentType = <?php echo json_encode(@$contextParentType) ?>;
  var contextParentId = <?php echo json_encode(@$contextParentId) ?>;

  var totalEntries = 0;

  var canPostNews = <?php echo json_encode(@$canPostNews) ?>;
  var canManageNews = <?php echo json_encode(@$canManageNews) ?>;
  var idSession = "<?php echo Yii::app()->session["userId"] ?>";

  var uploadUrl = "<?php echo Yii::app()->params['uploadUrl'] ?>";
  var docType="<?php echo Document::DOC_TYPE_IMAGE; ?>";
  var contentKey = "<?php echo Document::IMG_SLIDER; ?>";
  var tagsNews = <?php echo json_encode($tags); ?>;

console.log("NEWS", news);
jQuery(document).ready(function() {
  $(".uploadImageNews").click(function(event){
       if (!$(event.target).is('input')) {
        $(this).find("input").trigger('click');
    }
    //$("#addImage").click();
  });

  showFormBlock(false);
  $("#formCreateNewsTemp").removeClass('hidden');
  
  initForm();
  bindEventNews();
  if(typeof(initLimitDate.created) == "object")
      dateLimit=initLimitDate.created.sec;
  else
      dateLimit=initLimitDate.created;  
});

function initForm(){ console.log("initForm initForm");
  processUrl.getMediaFromUrlContent(".get_url_input",".results",1);
  
 // setTimeout(function(){
   // $("#btn-submit-form").on("click",function(e){
     // e.preventDefault();
     // saveNews();
    //});
  //},500);

  initTags();
  initFormImages();
  mentionsInit.get("textarea.mention");

  if(typeof tagQDJ != "undefined" && tagQDJ != null) //tag question du jour
    $("#form-news #tags").select2("val",new Array(tagQDJ));
}

function initTags(){
  /*if(contextParentType=="pixels"){
    tagsNews=["bug","idea"];
  }
  else {
    tagsNews = <?php echo json_encode($tags); ?>;
  }*/
  /////// A réintégrer pour la version last
  //var $scrollElement = $(".my-main-container");

  
  $('#tags').select2({tags:tagsNews});
  $("#tags").select2('val', "");
}
/* COMMENTS vvv */
</script>