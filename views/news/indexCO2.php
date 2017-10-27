<?php 
$cssAnsScriptFilesModule = array(
  '/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css',
  '/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysiwyg-color.css',
  '/plugins/bootstrap-datetimepicker/css/datetimepicker.css',
  //'/plugins/x-editable/css/bootstrap-editable.css',
  '/plugins/select2/select2.css',
  //X-editable...
  '/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
//  '/plugins/x-editable/js/bootstrap-editable.js' , 
  //'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js' , 
  //'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5.js' , 
  //'/plugins/wysihtml5/wysihtml5.js',
  '/plugins/jquery.scrollTo/jquery.scrollTo.min.js',
  '/plugins/ScrollToFixed/jquery-scrolltofixed-min.js',
  '/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
  '/plugins/jquery.appear/jquery.appear.js',
  '/plugins/jquery.elastic/elastic.js',
  '/plugins/underscore-master/underscore.js',
  '/plugins/jquery-mentions-input-master/jquery.mentionsInput.js',
  '/plugins/jquery-mentions-input-master/jquery.mentionsInput.css',
  '/plugins/jquery-mentions-input-master/lib/jquery.events.input.js',
  
);
//error_log("BasURL : ".Yii::app()->request->baseUrl);
HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->request->baseUrl);


    $cssAnsScriptFilesModule = array(
      '/js/news/autosize.js',
      '/js/news/newsHtml.js',
      '/js/menus/multi_tags_scopes.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


    $cssAnsScriptFilesModule = array(
      '/css/news/newsSV.css',
      '/js/comments.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->theme->baseUrl."/assets");

    $timezone = 'Pacific/Noumea';
		$pair = false;
    $nbCol = @$nbCol ? $nbCol : 2;

    $imgDefault = $this->module->assetsUrl.'/images/news/profile_default_l.png';

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
</style>
<script type="text/javascript" >
var updateNews= new Object;
</script>
<div class="col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom-15" style="<?php if(!@isLive){ ?>padding-left:25px!important;<?php } ?>">
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
  
    <?php $this->renderPartial('newsPartialCO2', array("news"=>$news,
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

<script type="text/javascript" >
  var news = <?php echo json_encode($news); ?>;
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
  getMediaFromUrlContent(".get_url_input",".results",1);
  
  setTimeout(function(){
    $("#btn-submit-form").on("click",function(){
      saveNews();
    });
  },500);

  initTags();
  initFormImages();
  mentionsInit.get("textarea.mention");
}

function initTags(){
  /*if(contextParentType=="pixels"){
    tagsNews=["bug","idea"];
  }
  else {
    tagsNews = <?php echo json_encode($tags); ?>;
  }*/
  /////// A réintégrer pour la version last
  var $scrollElement = $(".my-main-container");

  
  $('#tags').select2({tags:tagsNews});
  $("#tags").select2('val', "");
}
/* COMMENTS vvv */
</script>