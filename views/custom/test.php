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
		<ul id="ulhva">
            <li id="menuAccueil" class="active lihva"><a id="btnAccueil" href="javascript:;" class="">Accueil</a></li>
            <li id="menuOrga" class="lihva "><a id="btnOrga" href="javascript:;" class="">Acteurs</a></li>
			<li id="menuEvent" class="lihva"><a id="btnEvent" href="javascript:;" class="">Evénements</a></li>
		</ul>
        <div id="accueil">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam id laoreet nulla. Suspendisse purus sapien, molestie a feugiat ut, varius vitae sapien. Suspendisse et mauris vitae turpis gravida placerat sagittis id lectus. Etiam a molestie erat. Fusce euismod faucibus quam, in sodales odio bibendum non. Cras eu nisi elit. Donec tempus malesuada massa, quis gravida massa mollis eu.

In sem metus, aliquam in viverra at, tincidunt at ipsum. Fusce viverra sollicitudin quam in eleifend. Phasellus aliquam at erat at dictum. Vivamus non massa vel justo tempor pharetra eu suscipit nibh. Mauris ante eros, finibus eu suscipit ultricies, gravida ac augue. Integer tortor nisl, egestas eu condimentum eget, commodo eget augue. In non dolor bibendum, placerat purus quis, fermentum tellus. Aenean at lorem non elit condimentum molestie ac vitae odio. Sed facilisis dui ac nisi consectetur placerat. Aliquam maximus elit et urna efficitur, non suscipit leo iaculis. Ut a diam sit amet mi semper vestibulum. Etiam a velit aliquam, varius metus sit amet, accumsan justo.

Nullam nec facilisis lectus, sit amet tempor ipsum. Proin tempor nisi a odio imperdiet, ac imperdiet nisi tincidunt. Maecenas a turpis eget dolor semper congue non ut nisl. Mauris blandit nibh sit amet lorem finibus egestas. Curabitur varius massa vitae justo porta luctus sed sit amet est. Sed lacus libero, volutpat ut metus nec, blandit suscipit risus. Suspendisse eget porta ligula. Integer sed orci vel libero porta rutrum. Morbi ante eros, hendrerit placerat ornare ac, ultricies interdum odio. Donec eu finibus quam. Aliquam id quam non mi accumsan vulputate. Nullam elementum eros sed vulputate pharetra. Nunc consequat diam eu venenatis sodales. Quisque elementum turpis lorem, eget commodo ante maximus sit amet. Sed ac massa scelerisque, dapibus libero et, tristique orci.

Sed ut odio augue. Integer rhoncus mauris nec accumsan gravida. Nullam finibus urna metus, sit amet viverra sem volutpat a. Duis bibendum nisl ac ipsum egestas commodo. Fusce rhoncus magna ac ornare viverra. Quisque ac nisi nec nulla condimentum venenatis eu sit amet nisi. Sed fermentum eros mi, eu rutrum nisl maximus sit amet. Maecenas eu tortor non magna accumsan fermentum sit amet ut elit. Sed a odio sapien. Nam at ex ut sapien blandit accumsan. Quisque quis hendrerit mi, sit amet congue nisl.

Pellentesque tristique facilisis massa, vel blandit lacus pellentesque sed. Vestibulum dignissim ultrices lacus. Ut auctor lobortis turpis ut ornare. Nulla facilisi. Etiam auctor erat sed imperdiet hendrerit. Morbi eu tincidunt ante. Pellentesque viverra quam purus, et tempor dolor rhoncus eget. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam ac ornare quam. Donec sollicitudin felis mi, eu aliquam lectus interdum eget. Maecenas facilisis maximus quam, et pretium tellus placerat id. 
        </div>
		<iframe id="orga" src="<?php echo Yii::app()->createUrl('/network/default/index/?src=HVAorga') ; ?>" class="col-md-10 col-md-offset-1 col-xs-12" style="height:650px;"></iframe>
        <iframe id="event" src="<?php echo Yii::app()->createUrl('/network/default/index/?src=HVAevent') ; ?>" class="col-md-10 col-md-offset-1 col-xs-12" style="height:650px;"></iframe>
	</div>

</div>

<script type="text/javascript">
	

	jQuery(document).ready(function() {
        $('#orga').load(function(){
            $("#orga").hide();
        });

        $('#event').load(function(){
            $("#event").hide();
        });

        $("#btnOrga").click(function(){
            changeMenu("orga");
        });

        $("#btnEvent").click(function(){
        	changeMenu("event");
        });

        $("#btnAccueil").click(function(){
            changeMenu("accueil");
        });

    });

    function changeMenu(menu){
        $(".lihva").removeClass("active");
        if(menu == "event"){
            $("#orga").hide();
            $("#accueil").hide();
            $("#event").show();

            $("#menuEvent").addClass("active");
        }else if(menu == "orga"){
            $("#event").hide();
            $("#accueil").hide();
            $("#orga").show();

            $("#menuOrga").addClass("active");
        }else{
            $("#orga").hide();
            $("#event").hide();
            $("#accueil").show();

            $("#menuAccueil").addClass("active");
        }
    }
</script>