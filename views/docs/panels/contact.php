<?php 
	$cssAnsScriptFiles = array(
    '/assets/vendor/jquery_realperson_captcha/jquery.realperson.css',
    '/assets/vendor/jquery_realperson_captcha/jquery.plugin.js',
    '/assets/vendor/jquery_realperson_captcha/jquery.realperson.min.js'
  //  '/assets/css/referencement.css'
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl); 
?>

<style>
	.titleContact{
		color:grey;
		text-transform: none;
	}
	#form-group-contact label{
		color:grey;
		margin-top:8px;
	}

	#form-group-contact .form-control{
		background-color: #f0eded;
		color: #6c6c6c;
		border: 0px;
	}

	.realperson-text{
		text-align: right;
	}

	.colAddress{
		color:grey;
		font-weight: bold;
	}
	.btn-social{
		width: 80px;
		font-size:35px;
	}
</style>

<div class="col-xs-12 col-sm-12 col-md-12 colAddress">

	<h3 class="titleContact">Retrouvez-nous</h3>
	<hr style="width:75%;">
	<i class="fa fa-globe fa-x"></i><br> Partout dans le monde 
	<br><br>
	<i class="fa fa-home fa-x"></i><br> Ou physiquement au KiltirLab à la Réunion
	<br><br>
	<i class="fa fa-map-marker fa-2x"></i><br> 56 rue Andy, 97422 La Saline
	<br><br>
	<i class="fa fa-mobile"></i><br> +33 (0)6 93 91 85 32
	<br><br>
	<i class="fa fa-phone"></i><br> +00262-262343686
	<br><br>
	<i class="fa fa-envelope"></i><br> <span class="">contact@communecter.org</span>
	<br>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 colAddress" style="margin-top: 70px;">

	<h3 class="titleContact">Partagez-nous</h3>
	<hr style="width:75%;">
	<ul class="list-inline">
    <li>
        <a href="https://github.com/pixelhumain/co2" target="_blank" class="btn-social btn-outline text-dark">
            <i class="fa fa-fw fa-github"></i>
        </a>
    </li>
    <!--	<li>
        <a href="https://plus.google.com/communities/111483652487023091469" target="_blank" class="btn-social btn-outline text-dark">
            <i class="fa fa-fw fa-mastodon"></i>
        </a>
    </li>-->
    <li>
        <a href="https://www.facebook.com/communecter" target="_blank" class="btn-social btn-outline text-dark">
            <i class="fa fa-fw fa-facebook"></i>
        </a>
    </li>
    <li>
        <a href="https://www.twitter.com/communecter" target="_blank" class="btn-social btn-outline text-dark">
            <i class="fa fa-fw fa-twitter"></i>
        </a>
    </li>
   		<li>
        <a href="https://mamot.fr" target="_blank" class="btn-social btn-outline text-dark">
            <i class="fa fa-fw fa-google-plus"></i>
        </a>
    </li>
                        <!-- <li>
                            <a href="#" class="btn-social btn-outline text-dark">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li> -->
                    </ul>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
	<div id="form-group-contact" class="text-center">
		<div class="col-md-12 text-center padding-top-60 form-group">
			<h3 class="titleContact" style="margin-top: 70px;">
				<?php echo Yii::t("terla", "Contact us"); ?>
			</h3>
			<hr style="width:75%;">
			<br><br>
			<div class="col-xs-12 no-padding">
				<label for="name"><?php echo Yii::t("terla", "Name"); ?></label>
			</div>
			<div class="col-xs-12">
				<input class="form-control" placeholder="<?php echo Yii::t("terla", "what's your name ?"); ?>" id="name">
				<br>
			</div>

			<div class="col-xs-12 no-padding">
				<label for="email"><?php echo Yii::t("terla", "E-mail *"); ?></label>
			</div>
			<div class="col-xs-12">
				<input class="form-control" placeholder="<?php echo Yii::t("terla", "your mail address : exemple@mail.com"); ?>"
						id="emailSender">
				<br>
			</div>
			<div class="col-xs-12 no-padding">
				<label for="objet"><?php echo Yii::t("terla", "Object"); ?></label>
			</div>

			<div class="col-xs-12">
				<input class="form-control" placeholder="<?php echo Yii::t("terla", "what's about ?"); ?>" id="subject">
				<br>
			</div>


		</div>


		<div class="col-xs-12 text-center form-group">
			<div class="col-md-12">
				<label for="message">
					<i class="fa fa-angle-down"></i> <?php echo Yii::t("terla", "Your message"); ?>
				</label>

				<textarea placeholder="<?php echo Yii::t("terla", "Your message"); ?>..." 
						  class="form-control txt-mail" id="message">
				</textarea>
				
				<div class="col-md-12 margin-top-10 text-right">
					<small for="message" class="margin-bottom-25">
						<span class="letter-red"><i class="fa fa-lock fa-2x"></i> 
							<?php echo Yii::t("terla", "security"); ?>
						</span> 
						<?php echo Yii::t("terla", "thanks to copy the code below to be able to send your message"); ?> 
						<!-- merci de recopier le code suivant afin de valider votre message -->
					</small>
				</div>

				<div class="col-md-6 pull-right">
					<input placeholder="<?php echo Yii::t("terla", "copy the code here"); ?>" class="col-md-8 txt-captcha text-right pull-right" id="captcha">
				</div>

				<div class="col-md-12 margin-top-15 pull-left">
					<hr>
					<h4 class="letter-red hidden" id="conf-code-fail">
						<i class="fa fa-lock"></i> <?php echo Yii::t("terla", "Security code is not correct"); ?> 
						<i class="fa fa-thumbs-down"></i>
					</h4>
					<h4 class="letter-red hidden" id="form-fail">
						<i class="fa fa-thumbs-down"></i>
					</h4>
					<button type="submit" class="btn btn-link pull-right" id="btn-send-mail">
						<b><?php echo Yii::t("terla", "SEND"); ?></b>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-9 pull-right text-center hidden margin-top-50" id="conf-send-mail">
	<h2 class="letter-green">
		<i class="fa fa-thumbs-up"></i> <?php echo Yii::t("terla", "Your message has been sent."); ?>
	</h2>
	<h4 class="text-center">
		<span class=""><?php echo Yii::t("terla", "We answer as soon as possible"); ?>
	</h4>
	<h5 class="text-center">
		<?php echo Yii::t("terla", "Thanks for your message"); ?>
	</h5><br>
	<hr style="margin-bottom: 350px;">
</div>

<div class="col-xs-12 margin-top-50 hidden" id="conf-fail-mail">
	<h4 class="text-center letter-red">
		<i class="fa fa-thumbs-down"></i><br>
		<?php echo Yii::t("terla", "Error, your message has not been sent"); ?>
	</h4>
	<h5 class="text-center">
		<?php echo Yii::t("terla", "We are sorry"); ?>
	</h5>
	<hr style="margin-bottom: 350px;">
</div>

<script>

var currentCategory = "";

jQuery(document).ready(function() {
    
	$("#btn-send-mail").click(function(){
		sendEmail();
	});

	$('#emailSender').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
	$('#name').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
	$('#message').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});
	$('#subject').filter_input({regex:'[^<>#\"\`/\(|\)/\\\\]'});

	$("#captcha").realperson({length: 4});
});


function sendEmail(){
	var emailSender = $("#emailSender").val();
	var subject = $("#subject").val();
	var name = $("#name").val();
	var message = $("#message").val();
	var situation = $("#situation").val();

	 $("#form-fail").html("");

	if(emailSender == "") 	$("#form-fail").append("<br>Merci d'indiquer votre addresse e-mail <i class='fa fa-thumbs-down'></i>");
	if(name == "") 			$("#form-fail").append("<br>Merci d'indiquer votre nom <i class='fa fa-thumbs-down'></i>");
	if(message == "") 		$("#form-fail").append("<br>Votre message est vide ! <i class='fa fa-thumbs-down'></i>");

	if($("#form-fail").html()!="") { $("#form-fail").removeClass("hidden"); return }
	else $("#form-fail").addClass("hidden");

	var params = { 	emailSender: emailSender, 
	        		subject:subject, 
	        		names:name,
	        		situation:situation,
	        		contentMsg	: message,
	        		captchaUserVal: $("#captcha").val(),
	        		captchaHash: $("#captcha").realperson('getHash')
	        	};

	console.log("sendMail", params);
	//toastr.error("L'envoie d'email est désactivé pour l'instant, retentez votre chance dans quelques jours !");
	//return;

	$.ajax({ 
        type: "POST",
        url: baseUrl+"/"+moduleId+"/app/sendmailformcontact",
        data: params,
        success:
            function(data) {
                if(data.res == true){
                	toastr.success("Votre message a bien été envoyé");
                	$("#conf-send-mail").removeClass("hidden");
                	$("#conf-code-fail, #conf-fail-mail, #form-group-contact").addClass("hidden");
                	KScrollTo(".main-apropos");
                }else{
                	if(typeof data.captcha != "undefined" && data.captcha == false){
                		toastr.error("Code de sécurité invalide");   	
	                	$("#conf-code-fail").removeClass("hidden");
	                	$("#conf-fail-mail, #conf-send-mail").addClass("hidden");
                	}else{
	                	toastr.error("Une erreur est survenue pendant l'envoie de votre message");   	
	                	$("#conf-fail-mail").removeClass("hidden");
	                	$("#conf-send-mail, #form-group-contact").addClass("hidden");

	                	if(typeof data.telalpha!="undefined")
	                		$("#telalpha").html(data.telalpha);

	                	KScrollTo("#conf-fail-mail");
	                }
                } 				 
            },
        error:function(xhr, status, error){
            toastr.error("Une erreur est survenue pendant l'envoie de votre message - error");
            $("#conf-fail-mail").removeClass("hidden");
        	$("#conf-send-mail, #form-group-contact").addClass("hidden");
        	KScrollTo("#conf-fail-mail");
        },
        statusCode:{
                404: function(){
                	toastr.error("Une erreur est survenue pendant l'envoie de votre message - 404");
                	$("#conf-fail-mail").removeClass("hidden");
	            	$("#conf-send-mail, #form-group-contact").addClass("hidden");
	            	KScrollTo("#conf-fail-mail");
            }
        }
    });
}

</script>
<!--<div class="panel-heading border-light center text-dark partition-white radius-10">
	<span class="panel-title homestead"> <i class='fa fa-envelope-o faa-pulse animated fa-3x  '></i> <span style="font-size: 48px">CONTACT</span></span>
</div>
<div class="space20"></div>
<div class="keywordList"></div>

<style type="text/css">
	.keypan{
		height: 235px;
		border: 1px solid #ddd
	}
</style>
<script type="text/javascript">

var keywords = [
	
	{
		"icon" : "fa-envelope-o",
		"title":"BY MAIL : <br/>contact @ communecter.org",
		"class" : "keypan"
	},
	{
		"icon" : "fa-phone",
		"title":"BY PHONE : <br/>00262-262343686",
		"class" : "keypan"
	},
	{
		"icon" : "fa-paper-plane-o",
		"title":"BY PAPER AIRPLANE<br/>good luck !!",
		"class" : "keypan"
	},
	{
		"icon" : "fa-github",
		"title":" <a href='https://github.com/pixelhumain' target='_blank'>ON GITHUB</a>"
	},
	{
		"icon" : "fa-bookmark-o",
		"title":" <a href='https://groups.diigo.com/group/pixelhumain' target='_blank'>BY DIIGO</a> "
	},
	{
		"icon" : "fa-google-plus",
		"title":" <a href='https://plus.google.com/u/0/communities/111483652487023091469' target='_blank'>BY GOOGLE+ </a> "
	},
	{
		"icon" : "fa-facebook-square",
		"title":"<a href='https://www.facebook.com/groups/pixelhumain/' target='_blank'>BY FACEBOOK </a> "
	},
	{
		"icon" : "fa-twitter",
		"title":"<a href='https://www.twitter.com/pixelhumain/' target='_blank'>BY TWITTER</a> "
	},
	{
		"icon" : "fa-twitter",
		"title":"<a href='https://mamot.fr' target='_blank'>BY MASTODON</a> "
	}
];
	
jQuery(document).ready(function() 
{
	$(".keywordList").html('');
	$.each(keywords,function(i,obj) { 
		var icon = (obj.icon) ? obj.icon : "fa-tag" ;
		var color = (obj.color) ? obj.color : "#E33551" ;
		var body = (obj.body) ? obj.body : null ;
		var classo = (obj.class) ? obj.class : "" ;
		var str = '<div class="col-sm-4"><div class="'+classo+' panel panel-white ">'+
			'<div class="panel-heading border-light ">'+
				'<span class="panel-title homestead"> <i class="fa '+icon+'  fa-2x"></i> <span style="font-size: 35px; color:'+color+';"> <br/>'+obj.title+'</span></span>'+
			'</div>';
		if(body)
			str += '<div class="panel-body">'+
					body+
			"</div></div></div>";
		$(".keywordList").append(str);
	 });
});

</script>-->

