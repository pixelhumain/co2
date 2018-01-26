<li class="submenucoop focus sub-actions no-padding col-lg-4 col-md-6 col-sm-6"
	data-name-search="<?php echo str_replace('"', '', @$action["name"]); ?>">
	<a href="javascript:;" 
		class="load-coop-data" data-type="action"
		data-status="<?php echo @$action["status"]; ?>" 
   		data-dataid="<?php echo (string)@$action["_id"]; ?>">
  		<?php if(@$action["status"] == "todo" && $auth){ ?>
  			<span class="elipsis draggable" 
  					data-dataid="<?php echo (string)@$action["_id"]; ?>"
	  				data-type="actions" >
	  			<i class="fa fa-arrows-alt letter-light tooltips"  
   					data-original-title="<?php echo Yii::t("cooperation", "Drag / drop to an other space") ?>" 
	  				data-placement="right"></i> 
	  			<i class="fa fa-hashtag"></i> 
	  			<?php echo @$action["name"]; ?>
  			</span>
  		<?php }else{ ?>
  			<span class="elipsis">
	  			<i class="fa fa-hashtag"></i> 
	  			<?php echo @$action["name"]; ?>
  			</span>
  		<?php } ?>


  		<?php if(@$post["status"]) { $parentRoom = Room::getById($action["idParentRoom"]); ?>
	  	<br>
	  	<small class="elipsis">
  			<i class="fa fa-connectdevelop"></i> <?php echo @$parentRoom["name"]; ?>
  		</small>
	  	<?php  } ?>
	  	<br>


	  	<?php
	  		$participate = @$action["links"] ? isset($action["links"]["contributors"][Yii::app()->session['userId']]) : false;
	  		if($participate){
	  			$me = Element::getByTypeAndId("citoyens", Yii::app()->session['userId']);
              	$profilThumbImageUrl = Element::getImgProfil($me, "profilThumbImageUrl", $this->module->assetsUrl);
	  	?>
		        <img class="img-circle" id="menu-thumb-profil" 
                 width="15" height="15" src="<?php echo $profilThumbImageUrl; ?>" alt="image" >
		        
	  	<?php } ?>

	  	<small class="letter-light lbl-status">
	  		<i class="fa fa-pencil"></i> <b><?php echo Yii::t("cooperation", @$action["status"]); ?></b>
	  	</small>
	  	<small class="letter-light margin-left-10">
	  		<i class="fa fa-clock-o"></i> 
	  		<?php 
	  			if(@$action["endDate"])
	  				echo Yii::t("cooperation", "end") ." ". 
	  				Translate::pastTime($action["endDate"], "date"); 

	  		?>
	  	</small>

  	</a>
</li>