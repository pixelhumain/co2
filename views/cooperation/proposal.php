<?php //var_dump($proposal); ?>
<h5><?php echo $proposal["status"]; ?></h5>
<?php echo @$proposal["startDate"]; ?><br>
<?php echo @$proposal["endDate"]; ?><br>
<h2><?php echo $proposal["title"]; ?></h2>
<h5><?php echo $proposal["shortDescription"]; ?></h5>
<p><?php echo $proposal["description"]; ?></p>