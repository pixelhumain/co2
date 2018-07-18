<div class="col-xs-12" >
	<div class="col-xs-12" >
		<img src="<?php echo Yii::app()->getModule("co2")->assetsUrl."/images/custom/hva/banniere.jpg" ;?>" class="img-responsive" style="display: block; margin: 0 auto;">
	</div>
	<div class="container col-xs-12" >
		<ul>
			<li><a id="btnOrga" href="javascript:;" class="">Orga</a></li>
			<li><a id="btnEvent" href="javascript:;" class="">Event</a></li>
		</ul>
		<iframe id="networkIframe" src="http://127.0.0.1/ph/network/default/index/?src=HVAOrga" class="col-md-10 col-md-offset-2 col-xs-12" style="height:650px;"></iframe>
	</div>

</div>

<script type="text/javascript">
	

	jQuery(document).ready(function() {
        $("#btnOrga").click(function(){
        	alert("btnOrga");
             $("#networkIframe").attr("src", "http://127.0.0.1/ph/network/default/index/?src=HVAOrga");
        });

        $("#btnEvent").click(function(){
        	alert("btnEvent");
             $("#networkIframe").attr("src", "http://127.0.0.1/ph/network/default/index/?src=HVAEvent");
        });

    });
</script>