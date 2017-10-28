<!-- <div class="space20"></div> -->

<div class="<?php echo (@$class) ? $class : 'row' ?> hidden margin-5 qrCodeContainerCl center" id="qrCodeContainer"> 
	
	<h1 class="homestead text-red"><?php echo Yii::t("common","Printable content") ?></h1>

	<div class="col-xs-12 col-sm-5 col-sm-offset-1" >
		<h3 class="pull-left homestead text-red"><?php echo Yii::t("common", "Calling card") ?></h3>
		<div class="col-xs-12 center">
			<div  style="border:1px dashed #666; width:400px;min-height:160px;padding:5px;margin:5px;">
				
				<img class=" col-xs-5 img-responsive" src="<?php echo $img ?>">

				<ul class="col-xs-7" style="list-style: none;margin-top:10px;">
					<?php echo (@$type && @OpenData::$elementTypes[$type]) ? 
						"<li class='btn btn-sm'>".OpenData::$elementTypes[$type]."</li>" : '' ?>
					<?php echo (@$name) ? "<li class='bold'>".$name."</li>" : '' ?>
					<?php echo (@$address) ? "<li>".$address."</li>" : '' ?>
					<?php echo (@$address2) ? "<li>".$address2."</li>" : '' ?>
					<?php echo (@$email) ? "<li>".$email."</li>" : '' ?>
					<?php echo (@$url) ? "<li>".$url."</li>" : '' ?>
					<?php echo (@$tel) ? "<li>".$tel."</li>" : '' ?>m
				</ul>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-5 " >
		<h3 class="pull-left homestead text-red"><?php echo Yii::t("common", "Connected calling card") ?></h3>
		<div class="col-xs-12 center">
			<div style="border:1px dashed #666; width:400px;min-height:160px;padding:5px;margin:5px;">
				
				<div  class="col-xs-5 qrCode"> </div>
					
				<ul class="col-xs-7" style="list-style: none;margin-top:10px;">
					<?php echo (@$type && @OpenData::$elementTypes[$type]) ? 
						"<li class='btn btn-sm'>".OpenData::$elementTypes[$type]."</li>" : '' ?>
					<?php echo (@$name) ? "<li class='bold'>".$name."</li>" : '' ?>
					<?php echo (@$address) ? "<li>".$address."</li>" : '' ?>
					<?php echo (@$address2) ? "<li>".$address2."</li>" : '' ?>
					<?php echo (@$email) ? "<li>".$email."</li>" : '' ?>
					<?php echo (@$url) ? "<li>".$url."</li>" : '' ?>
					<?php echo (@$tel) ? "<li>".$tel."</li>" : '' ?>m
				</ul>
			</div>
		</div> 

		<div class="col-xs-12">
			<span class="text-red"><i class="fa fa-warning "></i> <?php echo Yii::t("common","This QR Code becomes iteractive with the app") ?> <a href="https://play.google.com/store/apps/details?id=org.communevent.meteor.pixelhumain&ah=lVN3mXqHKQjIOg3qHn0YzhiUebc&hl=fr" target="_blank">COMOBI</a></span>
		</div>
		<br/>
		<a class="explainLink btn btn-default btn-sm" data-id="qrCodeExplain" href=""><?php echo Yii::t("common","Know more") ?> <i class="fa fa-question-circle"></i></a>
	</div>

	


</div>