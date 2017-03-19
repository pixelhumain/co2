<?php 

    $timezone = ''; //'Pacific/Noumea';
		$pair = false;
		foreach($medias as $key => $media){ 
			$class = $pair ? "timeline-inverted" : "";
			$pair = !$pair;

   
	?>

      <li class="<?php echo $class; ?>">
        <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip"></i></a></div>
        <div class="timeline-panel">
          <div class="timeline-heading text-center">
            
             	<h5 class="text-left srcMedia">
            		<small class="ilyaL"><i class="fa fa-clock-o"></i> <?php echo Translate::pastTime($media["date"], "date", $timezone); ?></small>
                <img src="<?php echo Yii::app()->theme->baseUrl."/assets/img/medias/".$media["srcMedia"]; ?>.png" height=40>
            	  <small class="ilyaR"><i class="fa fa-clock-o"></i> <?php echo Translate::pastTime($media["date"], "date", $timezone); ?></small>
                <a href="<?php echo $media["href"]; ?>" target="_blank" class="link-read-media margin-top-10 hidden-xs"><i class="fa fa-angle-right"></i> Lire</a>
              </h5>
              
          	  <?php if(@$media["img"]){ ?>
              	<a class="block bg-black" target="_blank" href="<?php echo $media["href"]; ?>">
          			<img class="img-responsive" src="<?php echo $media["img"]; ?>" />
              	</a>
              <?php } ?>

              <?php if(@$media["contentType"] == "youtube"){ ?>
              	<iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $media["idYoutube"]; ?>" frameborder="0" allowfullscreen></iframe>
              <?php } ?>
            
          </div>
          <div class="timeline-body padding-10">
            <h4><a target="_blank" href="<?php echo $media["href"]; ?>"><?php echo $media["title"]; ?></a></h4>
            <p><?php echo $media["content"]; ?></p>   
          </div>
          <?php if(isset(Yii::app()->session["userId"])) { ?>
            <div class="timeline-footer pull-left col-md-12 padding-top-5">
                <div class="col-md-12 pull-left padding-5" id="footer-media-<?php echo $media["_id"]; ?>"></div>
                <div class="col-md-12 no-padding pull-left margin-top-10" id="commentContent<?php echo $media["_id"]; ?>"></div>
            </div>
          <?php } ?>
        </div>
      </li>

<?php } ?>

<script type="text/javascript" >
var medias = <?php echo json_encode($medias); ?>;

jQuery(document).ready(function() {
  if(medias.length == 0) scrollEnd = true;

  <?php if(isset(Yii::app()->session["userId"])) { ?>
    initCommentsTools(medias);
  <?php } ?>
});
</script>