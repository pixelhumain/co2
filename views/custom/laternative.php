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
		<img src="<?php echo Yii::app()->getModule("survey")->assetsUrl."/images/custom/laternative/baniere.jpg" ;?>" class="img-responsive" style="display: block; margin: 0 auto;">
	</div>


	<div class="container col-xs-12" >
		<center><ul id="ulhva">
			
				<li class="active"><a id="btnOrga" href="javascript:;" class="">Acteurs</a></li>
				<li><a id="btnEvent" href="javascript:;" class="">Evénements</a></li>
			
			
		</ul></center>

		
	</div>

</div>

<script type="text/javascript">
	

	jQuery(document).ready(function() {
        $("#btnOrga").click(function(){
        	$("#networkIframe").attr("src", "http://127.0.0.1/ph/network/default/index/?src=HVAorga");
        });

        $("#btnEvent").click(function(){
        	$("#networkIframe").attr("src", "http://127.0.0.1/ph/network/default/index/?src=HVAevent");
        });

    });
</script>