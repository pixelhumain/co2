<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "info",
                            )
                        );
      
?>
<style>
	p{
		font-size:15px;
	}

	h1{
		padding-top:20px;
	}

	.arrow_box:after, .arrow_box:before {
		left: 19px;
	}


@media screen and (max-width: 1024px) {
    
}

@media (max-width: 768px) {


</style>


<section class="padding-top-70">
    <div class="row main-apropos padding-top-15 padding-bottom-50">
	    
        <div class="col-lg-3 col-md-3 col-sm-4 text-right hidden-xs" id="sub-menu-left">
        </div>
        <div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">

        	<h5 class="pull-left">
        		<i class="fa fa-angle-down"></i> <?php echo Yii::t("docs","Financial situation") ?>
        	</h5>
        	
        	<a href="#" class="lbh btn btn-default pull-right margin-left-5 btn-submenu tooltips"
        		data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t("common","Back to home") ?>">
        		<b><?php echo Yii::t("common","Leave this page") ?> <i class="fa fa-arrow-right"></i></b>
        	</a> 

        	<br>
        	<hr>

        	<h1 class="letter-red font-blackoutM" id="koica">
        		<?php echo Yii::t("docs","ALERT : SOON OUT OF MONEY") ?> !!!
        	</h1>

        	<h3 class="letter-blue"><i class="fa fa-angle-right"></i> <?php echo Yii::t("docs","1 euro to save us") ?> !</h3>
        	<p>
				<?php echo Yii::t("docs","The developers who work on the platform need to earn some good money to work full time on this huge project") ?>.
				<br><br>
				<?php echo Yii::t("docs","It just can’t be done as a part-time job.<br>The maintenance and the upgrading of the application need a competent team of technicians available on a daylee basis") ?>.
				<br><br>
				<?php echo Yii::t("docs", "In order to have full-time developpers on communecter, they need your financial support") ?>.
				<br><br>
				<?php echo Yii::t("docs","The current account of NGO is too low to assume a short-term vision for the platform and for its team") ?>.
				<br><br>
				<?php echo Yii::t("docs","To make this happen, we need your help") ?>.
				<br><br>
				<?php echo Yii::t("docs", "If you want to see the project keep on going and growing, you can now be part of it, even with 1 euro on a monthly basis, it will make things possible") ?> !

				<h3 class="letter-blue"><?php echo Yii::t("docs","A long-term project") ?></h3>
				<?php echo Yii::t("docs","The actual team of developpers are very motivated to follow the work.<br>She needs also to grow up with new developpers and to work with other team to build interoperable applications") ?>.<br><br>
				<?php echo Yii::t("docs","Finally, we want to keep improving Communecter, adding new functions") ?>.<br><br>

				<h3 class="letter-blue"><?php echo Yii::t("docs","Annual budget") ?> :</h3>
				<?php echo Yii::t("docs","6 developpers at 2000€/month for a year : To develop the app") ?><br>
				6 * 2000 * 12 = <?php $c1 = 6 * 2000 * 12; echo $c1; ?>€
				<br><br>
				<?php echo Yii::t("docs","6 commonecters at 1000€/month for a year : To help people connect via the platform")?><br>
				6 * 2000 * 12 = <?php $c2 = 6 * 1000 * 12; echo $c2; ?>€
				<br><br>
				ETC ...
				<br><br><br>
				<?php echo Yii::t("docs","Total") ?> : <?php echo $c1 + $c2; ?>€
				<br><br>
				<?php echo Yii::t("docs","We are currently running on an annuel budget of 80K€ and only the developpers are payed 1000€ / monthly") ?>.
        	</p>
        </div>
    </div>
</section>


<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array()); ?>
<?php //$this->renderPartial($layoutPath.'footer',  array( "subdomain"=>"info" ) ); ?>

<script type="text/javascript" >

jQuery(document).ready(function() {
    initKInterface();
    location.hash = "#info.p.finance";
});

</script>