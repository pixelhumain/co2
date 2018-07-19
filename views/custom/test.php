<style>
#ulhva {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

#ulhva li {
    float: left;
}

#ulhva li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

#ulhva li a:hover:not(.active) {
    background-color: #f5863f;
}

#ulhva .active {
    background-color: #de2147;
}
</style>

<div class="col-xs-12" >
	<div class="col-xs-12" >
		<img src="<?php echo Yii::app()->getModule("co2")->assetsUrl."/images/custom/hva/banniere.jpg" ;?>" class="img-responsive" style="display: block; margin: 0 auto;">
	</div>
	<div class="container col-xs-12" >
		<center><ul id="ulhva">
			
				<li class="active"><a id="btnOrga" href="javascript:;" class="">Acteurs</a></li>
				<li><a id="btnEvent" href="javascript:;" class="">Evénements</a></li>
			
			
		</ul></center>
		<iframe id="networkIframe" src="http://127.0.0.1/ph/network/default/index/?src=HVAorga" class="col-md-10 col-md-offset-1 col-xs-12" style="height:650px;"></iframe>
	</div>

</div>

<script type="text/javascript">
	

	jQuery(document).ready(function() {
        $("#btnOrga").click(function(){
        	alert("btnOrga");
             $("#networkIframe").attr("src", "http://127.0.0.1/ph/network/default/index/?src=HVAorga");
        });

        $("#btnEvent").click(function(){
        	alert("btnEvent");
             $("#networkIframe").attr("src", "http://127.0.0.1/ph/network/default/index/?src=HVAevent");
        });

    });
</script>