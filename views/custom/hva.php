<?php $cssJS = array(
    
    '/plugins/jquery.dynForm.js',
	'/plugins/jquery-validation/dist/jquery.validate.min.js',
);

HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->request->baseUrl);

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
$me = isset(Yii::app()->session['userId']) ? Person::getById(Yii::app()->session['userId']) : null;
$this->renderPartial( $layoutPath.'modals.'.Yii::app()->params["CO2DomainName"].'.mainMenu', array("me"=>$me) );
?>

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
            <li id="menuAccueil" class="active lihva"><a id="btnAccueil" href="#accueil" class="">Accueil</a></li>
            <li id="menuOrga" class="lihva "><a id="btnOrga" href="#orga" class="">Acteurs</a></li>
			<li id="menuEvent" class="lihva"><a id="btnEvent" href="#event" class="">Evénements</a></li>
            <li id="menuAnnonce" class="lihva"><a id="btnAnnonce" href="#annonce" class="">Annonces</a></li>
            <li id="menuRejoindre" class="lihva "><a id="btnRejoindre" href="#rejoindre" class="">Rejoindre le réseau</a></li>
            <li id="menuEvent" class="lihva"><a id="btnQui" href="#qui" class="">Qui-sommes nous ?</a></li>
		</ul>
        <div id="accueil" class="col-xs-12" style ="padding: 15px; text-align: justify;">

                <img src="http://www.catalunyaexperience.fr/wp-content/uploads/2015/03/001-ES1308N-0740-1024x683.jpg" style="width : 500px" class="col-md-6 col-xs-12">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam id laoreet nulla. Suspendisse purus sapien, molestie a feugiat ut, varius vitae sapien. Suspendisse et mauris vitae turpis gravida placerat sagittis id lectus. Etiam a molestie erat. Fusce euismod faucibus quam, in sodales odio bibendum non. Cras eu nisi elit. Donec tempus malesuada massa, quis gravida massa mollis eu.

In sem metus, aliquam in viverra at, tincidunt at ipsum. Fusce viverra sollicitudin quam in eleifend. Phasellus aliquam at erat at dictum. Vivamus non massa vel justo tempor pharetra eu suscipit nibh. Mauris ante eros, finibus eu suscipit ultricies, gravida ac augue. Integer tortor nisl, egestas eu condimentum eget, commodo eget augue. In non dolor bibendum, placerat purus quis, fermentum tellus. Aenean at lorem non elit condimentum molestie ac vitae odio. Sed facilisis dui ac nisi consectetur placerat. Aliquam maximus elit et urna efficitur, non suscipit leo iaculis. Ut a diam sit amet mi semper vestibulum. Etiam a velit aliquam, varius metus sit amet, accumsan justo.

Nullam nec facilisis lectus, sit amet tempor ipsum. Proin tempor nisi a odio imperdiet, ac imperdiet nisi tincidunt. Maecenas a turpis eget dolor semper congue non ut nisl. Mauris blandit nibh sit amet lorem finibus egestas. Curabitur varius massa vitae justo porta luctus sed sit amet est. Sed lacus libero, volutpat ut metus nec, blandit suscipit risus. Suspendisse eget porta ligula. Integer sed orci vel libero porta rutrum. Morbi ante eros, hendrerit placerat ornare ac, ultricies interdum odio. Donec eu finibus quam. Aliquam id quam non mi accumsan vulputate. Nullam elementum eros sed vulputate pharetra. Nunc consequat diam eu venenatis sodales. Quisque elementum turpis lorem, eget commodo ante maximus sit amet. Sed ac massa scelerisque, dapibus libero et, tristique orci.

Sed ut odio augue. Integer rhoncus mauris nec accumsan gravida. Nullam finibus urna metus, sit amet viverra sem volutpat a. Duis bibendum nisl ac ipsum egestas commodo. Fusce rhoncus magna ac ornare viverra. Quisque ac nisi nec nulla condimentum venenatis eu sit amet nisi. Sed fermentum eros mi, eu rutrum nisl maximus sit amet. Maecenas eu tortor non magna accumsan fermentum sit amet ut elit. Sed a odio sapien. Nam at ex ut sapien blandit accumsan. Quisque quis hendrerit mi, sit amet congue nisl.

Pellentesque tristique facilisis massa, vel blandit lacus pellentesque sed. Vestibulum dignissim ultrices lacus. Ut auctor lobortis turpis ut ornare. Nulla facilisi. Etiam auctor erat sed imperdiet hendrerit. Morbi eu tincidunt ante. Pellentesque viverra quam purus, et tempor dolor rhoncus eget. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam ac ornare quam. Donec sollicitudin felis mi, eu aliquam lectus interdum eget. Maecenas facilisis maximus quam, et pretium tellus placerat id. 
        </div>
        <hr>
        <div class="col-xs-12" style ="padding: 15px; text-align: justify;">
		  <iframe id="orga" src="<?php echo Yii::app()->createUrl('/network/default/index/?src=HVAorga') ; ?>" class="col-md-10 col-md-offset-1 col-xs-12" style="height:650px;"></iframe>
        </div>
        <br/><hr>
        <div class="col-xs-12" style ="padding: 15px; text-align: justify;">
            <iframe id="event" src="<?php echo Yii::app()->createUrl('/network/default/index/?src=HVAevent') ; ?>" class="col-md-10 col-md-offset-1 col-xs-12" style="height:650px;"></iframe>
        </div>
        <br/><hr>
        <div class="col-xs-12" style ="padding: 15px; text-align: justify;">
            <iframe id="annonce" src="<?php echo Yii::app()->createUrl('/network/default/index/?src=HVAannonce') ; ?>" class="col-md-10 col-md-offset-1 col-xs-12" style="height:650px;"></iframe>
        </div>
        <hr>
        <div id="rejoindre" class="col-xs-12" style ="padding: 15px; text-align: justify;">

            <h3> Comment nous rejoindre ? </h3>

            <span>
                C'est simple il suffit de remplir 
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSc8yce4HQQJHflDViNR_NDdlK9t7n3qoD2EjTQKWqNQLzcx8A/viewform?c=0&w=1&usp=mail_form_link">ce questionnaire</a>  <br/> <br/>
                Et de faire l'adhésion sur <a href="https://www.helloasso.com/associations/le-chaudron/adhesions/adhesion-portail-hva
">Hello Asso</a> 
            </span>
        </div>
        <hr>
        <div id="qui" class="col-xs-12">
            Portail HVA qu'est que c'est ? ....
        </div>
	</div>

</div>

<script type="text/javascript">
	

	jQuery(document).ready(function() {
        //$("#qui").hide();
   //      $('#orga').load(function(){
   //          $("#orga").hide();
   //      });

   //      $('#event').load(function(){
   //          $("#event").hide();
   //      });

   //      $('#annonce').load(function(){
   //          $("#annonce").hide();
   //      });

   //      $("#btnOrga").click(function(){
   //          changeMenu("orga");
   //      });

   //      $("#btnEvent").click(function(){
   //      	changeMenu("event");
   //      });

   //      $("#btnAccueil").click(function(){
   //          changeMenu("accueil");
   //      });

   //      $("#btnQui").click(function(){
   //          changeMenu("qui");
   //      });

   //      $("#btnAnnonce").click(function(){
   //          changeMenu("annonce");
   //      });

   //      $("#btnRejoindre").click(function(){
   //          changeMenu("rejoindre");
   // //      	var form = {
			// // 	saveUrl : baseUrl+"/"+moduleId+"/mailmanagement/createandsend/",
			// // 	dynForm : {
			// // 		jsonSchema : {
			// // 			title : "Rejoindre",// trad["Update network"],
			// // 			icon : "fa-key",
			// // 			onLoads : {
			// // 				sub : function(){
			// // 					$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
			// // 								  				  .addClass("bg-dark");
			// // 					//bindDesc("#ajaxFormModal");
			// // 				}
			// // 			},
			// // 			beforeSave : function(){
			// // 				mylog.log("beforeSave");
   // //                          alert("Il manque votre adresse mail pour recevoir ce mail ;)");
   // //                          dyFObj.closeForm();
			// // 		    	//removeFieldUpdateDynForm(contextData.type);
			// // 		    },
			// // 			afterSave : function(data){
			// // 				mylog.dir(data);
			// // 				dyFObj.closeForm();
			// // 			},
			// // 			properties : {
			// // 				name : dyFInputs.text("Nom et Prénom","Nom et Prénom",{ required : true }),
			// // 				orga : dyFInputs.text("Entreprise / Association","Entreprise / Association",{ required : true }),
			// // 				email : dyFInputs.text(),
			// // 				tel : dyFInputs.text("Téléphone", "Téléphone",{ required : true }),
			// // 				ville : dyFInputs.text("Ville", "Ville",{ required : true }),
			// // 				tplMail : dyFInputs.inputHidden("coco@gmail.com"),
			// // 				tplObject : dyFInputs.inputHidden("Inscription sur Portail HVA"),
			// // 				tpl : dyFInputs.inputHidden("hvaRejoindre"),
			// // 			}
			// // 		}
			// // 	}
			// // };

			// // dyFObj.openForm(form, "sub");		
			
   //      });

        

    });

    function changeMenu(menu){
        $(".lihva").removeClass("active");
        if(menu == "event"){
            $("#orga").hide();
            $("#accueil").hide();
            $("#annonce").hide();
            $("#qui").hide();
            $("#rejoindre").hide();
            $("#accueil").hide();
            $("#event").show();
            $("#menuEvent").addClass("active");

        }else if(menu == "orga"){
            $("#event").hide();
            $("#accueil").hide();
            $("#annonce").hide();
            $("#qui").hide();
            $("#rejoindre").hide();
            $("#orga").show();
            $("#menuOrga").addClass("active");

        }else if(menu == "annonce"){
            $("#event").hide();
            $("#accueil").hide();
            $("#orga").hide();
            $("#qui").hide();
            $("#rejoindre").hide();
            $("#annonce").show();
            $("#menuAnnonce").addClass("active");

        }else if(menu == "qui"){
            $("#event").hide();
            $("#accueil").hide();
            $("#annonce").hide();
            $("#orga").hide();
            $("#rejoindre").hide();
            $("#qui").show();
            $("#menuQui").addClass("active");

        }else if(menu == "rejoindre"){
            $("#event").hide();
            $("#accueil").hide();
            $("#annonce").hide();
            $("#orga").hide();
            $("#qui").hide();
            $("#rejoindre").show();
            $("#menuRejoindre").addClass("active");

        }else{
            $("#orga").hide();
            $("#event").hide();
            $("#annonce").hide();
            $("#qui").hide();
            $("#rejoindre").hide();
            $("#accueil").show();
            $("#menuAccueil").addClass("active");
        }
    }
</script>