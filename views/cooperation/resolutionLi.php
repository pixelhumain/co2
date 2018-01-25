<li class="submenucoop focus sub-resolutions no-padding col-lg-4 col-md-6 col-sm-6"
	data-name-search="<?php echo str_replace('"', '', @$resolution["title"]); ?>">
	<a href="javascript:;" class="load-coop-data" data-type="resolution" 
	   data-status="<?php echo @$resolution["status"]; ?>" 
	   data-dataid="<?php echo (string)@$resolution["_id"]; ?>">

  		<span class="elipsis">
  			<i class="fa fa-hashtag"></i> 
  			<?php if(@$resolution["title"]) 
  					   echo @$resolution["title"]; 
  				  else echo "<small><b>".
  				  		substr(@$resolution["description"], 0, 150).
  				  		   "</b></small>";

  				 //echo " * ".Translate::dayDifference($resolution["created"], "timestamp");
  			?>
  		</span>
  	</a>
</li>