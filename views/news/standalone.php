<?php 
	$cssAnsScriptFilesModule = array(
      '/js/news/index.js',
      '/js/news/newsHtml.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

    $cssAnsScriptFilesModule = array(
      // '/css/news/newsSV.css',
      '/js/comments.js',
      '/css/news/index.css',
      '/css/default/directory.css',	
	  '/css/timeline2.css',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->theme->baseUrl."/assets");

?>
<style>
    .timeline > li{
      width:100%;
    }
    .timeline::before {
      left:0;
    }
    #noMoreNews{
    	display: none;
    }
</style>

<div class="row bg-white">

  <div class="col-xs-12 margin-top-70">
    <h3 class="text-center"><i class="fa fa-newspaper-o"></i> Message</h3><hr>
  </div>

<div class="container">
	<ul class="timeline inline-block" id="news-list">
	<?php if(!empty($element)){
      $this->renderPartial('../news/newsPartialCO2', 
								array("news"=>array($element), 
									  "nbCol"=> 1) );  
    }else{ ?>
    <p class="col-md-12 col-sm-12 col-xs-12">
      <?php echo Yii::t("news","This link points to a dead news")?>.<br>
      <?php echo Yii::t("news","The author has probably deleted the news") ?> !!<br>
      <?php if (@Yii::app()->session["userId"]){ ?>
        <a href="#page.type.<?php echo Person::COLLECTION ?>.id.<?php echo Yii::app()->session["userId"] ?>" class="btn btn-warning lbh"><i class="fa fa-sign-in"></i> <?php echo Yii::t("news","Back to my page") ?></a>
      <?php } else { ?> 
        <a href="#" class="btn btn-warning lbh"><i class="fa fa-sign-in"></i> <?php echo Yii::t("news","Back to home") ?></a>
      <?php } ?>
    </p>
    <?php }
	?>
	</ul>
</div>
</div>
<script type="text/javascript">

	var news=<?php echo json_encode($element); ?>;
	jQuery(document).ready(function() {	
    if(news){
      if(typeof news.text != "undefined"){
        var text = news.text.substr(0,30);
        if(news.text.length>30) text+="...";
        setTitle("", "", text);

        if(typeof news.mentions != "undefined")
          text = mentionsInit.addMentionInText(news.text,news.mentions);
        else text = news.text;
      }

  	  <?php if(isset(Yii::app()->session["userId"])) { ?>
        initCommentsTools(new Array(news));
      <?php } ?>
      
      $(".timeline_text").html(text);
    	//showCommentsTools(news["_id"]['$id']);
    }
	});

</script>