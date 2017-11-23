<div class="headerList col-md-12 col-sm-12 no-padding margin-bottom-20 margin-top-20">
	<div class="col-md-12 col-sm-12 text-center">
		<h4 class="col-md-12 letter-orange">Add products and services you want to offered</h2>
		<p>
			These products and services will be validated by the team of terla
		</p>
		<button data-form-type="product"  
                    data-dismiss="modal"
                    class="btn btn-link btn-open-form col-xs-6 col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2 col-lg-4 text-orange">
                <h5><i class="fa fa-shopping-basket fa-2x"></i><br> <?php echo Yii::t("common", "Product") ?></h5>
                <small><?php echo Yii::t("form","Food, hand-made, jewelery...<br>Sell your product here") ?></small>
            </button>
            <button data-form-type="service" data-form-subtype=""  
                    data-dismiss="modal"
                    class="btn btn-link btn-open-form col-xs-6 col-sm-4 col-md-4 col-lg-4 text-green">
                <h5><i class="fa fa-sun-o fa-2x"></i><br> <?php echo Yii::t("common", "Services") ?></h5>
                <small><?php echo Yii::t("form","Hostel, funny activity, food, guide...<br>Purpose your services here !") ?></small>
            </button>
	</div>
</div>