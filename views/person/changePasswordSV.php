<?php 
$cssAnsScriptFilesTheme = array(
	//autosize
	'/plugins/autosize/jquery.autosize.min.js',
);

HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme,Yii::app()->request->baseUrl);
?>
<style>
#changePassword i{
	position: inherit !important;
}
#changePassword .close-modal .lr,
#changePassword .close-modal .lr .rl{
	z-index: 1051;
height: 75px;
width: 1px;
background-color: #2C3E50;
}
#changePassword .close-modal .lr{
margin-left: 35px;
transform: rotate(45deg);
-ms-transform: rotate(45deg);
-webkit-transform: rotate(45deg);
}
#changePassword .close-modal .rl{
transform: rotate(90deg);
-ms-transform: rotate(90deg);
-webkit-transform: rotate(90deg);
}
#changePassword .close-modal {
	position: absolute;
	width: 75px;
	height: 75px;
	background-color: transparent;
	top: 25px;
	right: 25px;
	cursor: pointer;
}
</style>
<div id="changePassword" >
	<!-- start: PAGE CONTENT -->
	<div class="close-modal" data-dismiss="modal"><div class="lr"><div class="rl"></div></div></div>
	<div class="noteWrap col-md-6 col-md-offset-3">
	    <!-- <div class="panel panel-white"> -->
        	<!-- <div class="panel-heading border-light"> -->
				<h1 class="text-red" style="font-size:20px;"><i class="fa fa-key"></i> Changer votre mot de passe</h1>
			<!-- </div> -->
		<!-- </div> -->
		<div class="panel-body">
			<form id="passwordForm" role="form">
				<div class="row">
					<div class="col-md-12">
						<div class="errorHandler alert alert-danger no-display">
							<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
						</div>
						<div class="successHandler alert alert-success no-display">
							<i class="fa fa-ok"></i> Your form validation is successful!
						</div>
					</div>
					<div>
						<div class="col-md-12 col-xs-12">
							<div class="form-group">
								<label class="control-label">
									Ancien mot de passe <span class="symbol required"></span>
								</label>
								<input id="oldPassword" class="form-control" name="oldPassword" type="password"/>
							</div>

							<div class="form-group">
								<label class="control-label">
									Nouveau mot de passe <span class="symbol required"></span>
								</label>
								<input id="newPassword" class="form-control" name="newPassword" type="password" />
							</div>

							<div class="form-group">
								<label class="control-label">
									Répétez le nouveau mot de passe <span class="symbol required"></span>
								</label>
								<input id="newPassword2" class="form-control" name="newPassword2" type="password" />
							</div>
						<div>
						<div class="row">
							<div class="col-md-12">
								<div>
									<span class="symbol required"></span><?php echo Yii::t("common","Required Fields",null,Yii::app()->controller->module->id) ?>
									<hr>
								</div>
							</div>
						</div>
						<button class="btn btn-success" id="btnChangePassword"><i class="fa fa-save"></i> <?php echo Yii::t("common","Change password",null,Yii::app()->controller->module->id) ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">

var formValidator = function() {
	addCustomValidators();
	var form = $('#passwordForm');
	var errorHandler = $('.errorHandler');
	form.validate({
		rules : {
			oldPassword : {
				required : true
			},
			newPassword : {
				required : true,
				minlength : 8
			},
			newPassword2 : {
				required : true,
				minlength : 8,
  				equalTo : "#newPassword"
			}
		},
		submitHandler : function(form) {
			$.blockUI({
				message : '<i class="fa fa-spinner fa-spin"></i> Processing... <br/> '+
	            '<blockquote>'+
	              "<p>C'est le devoir de chaque homme de rendre au monde au moins autant qu'il en a reçu..</p>"+
	              '<cite title="Einstein">Einstein</cite>'+
	            '</blockquote> '
			});

	        $.ajax({
		    	  type: "POST",
		    	  dataType: "json",
		    	  url: baseUrl+"/<?php echo $this->module->id?>/person/changepassword",
		    	  data: {
					"mode" : "changePassword",
	            	"id" : userId, 
		    	  	"oldPassword" : $('#oldPassword').val(),
		    	  	"newPassword" : $('#newPassword').val()
		    	  },
		    	  success: function(data){
		    			if(!data.result){
	                        toastr.error(data.msg);
	                        $.unblockUI();
	                   	}
	                    else { 
	                        toastr.success(data.msg);
							$.unblockUI();
	                    }
		    	  },
		    	  error: function(data) {
						toastr.error("Something went really bad : contact your admin." + data.msg);
		    	  },
		    	  
		    });
	       	return false; // required to block normal submit since you used ajax
		},
		invalidHandler : function(event, validator) {//display error alert on form submit
			errorHandler.show();
		}
	});
}

jQuery(document).ready(function() {
	$("#changePassword").show();
	formValidator();
	$("#changePassword .close-modal").click(function(){
		$.unblockUI();
	});
});

function changePassword() {
	mylog.log("change Password !");
	$('#passwordForm').submit();
}





</script>	

