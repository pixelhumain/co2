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
	<?php $this->renderPartial('../news/newsPartialCO2', 
								array("news"=>array($element), 
									  "nbCol"=> 1) );  
	?>
	</ul>
</div>
</div>
<script type="text/javascript">

	var news=<?php echo json_encode($element); ?>;

	jQuery(document).ready(function() {	
    if(typeof news.text != "undefined"){
      var text = news.text.substr(0,30);
      if(news.text.length>30) text+="...";
      setTitle("", "", text);

      if(typeof news.mentions != "undefined")
        text = addMentionInText(news.text,news.mentions);
      else text = news.text;
    }

	  <?php if(isset(Yii::app()->session["userId"])) { ?>
      initCommentsTools(new Array(news));
    <?php } ?>
    
    $(".timeline_text").html(text);
  	showCommentsTools(news["_id"]['$id']);
	});

</script>