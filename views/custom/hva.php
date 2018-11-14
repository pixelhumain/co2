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

.niv1 {
    margin-left: 50px;
}
.niv1 .niv2 {
    margin-left: 50px;
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
            <li id="menuAnnonce" class="lihva"><a id="btnAnnonce" href="javascript:;" class="">Annonces</a></li>
            <li id="menuRejoindre" class="lihva "><a id="btnRejoindre" href="javascript:;" class="">Rejoindre le réseau</a></li>
            <li id="menuEvent" class="lihva"><a id="btnQui" href="javascript:;" class="">Qui-sommes nous ?</a></li>
		</ul>
        <div id="accueil" class="col-xs-12" style ="padding: 15px; text-align: justify; margin-left: 20px">

<!--                 <img src="http://www.catalunyaexperience.fr/wp-content/uploads/2015/03/001-ES1308N-0740-1024x683.jpg" style="width : 500px" class="col-md-6 col-xs-12"> -->
Nous sommes un collectif d'acteurs de la <b>Haute Vallée de l'Aude (HVA)</b> fortement impliqués dans l'économie sociale, solidaire et écologique de ce territoire.<br/><br/>
            Nous vous proposons ce site internet novateur et collaboratif qui a pour objectifs de :
            <br/><br/>
            <ul class="niv1">
            <li><b>Promouvoir les activités des acteurs locaux par une vitrine qui : </b><br/><br/>
                <ul  class="niv2">
            <li>Augmente leur visibilité et leur mutualisation.</li>
            <li>Allège leurs efforts de communication en réduisant leurs coûts de conception, de publication et de distribution de leurs informations.</li>
            <li>Consolide leur ancrage au sein du territoire en accroissant leur panel d'utilisateurs, de consommateurs.</li></ul>
        </li><br/>
        <li>
            <b>Offrir aux habitants et aux visiteurs un espace dédié qui :</b><br/><br/>
            <ul  class="niv2">
             <li> Concentre, classe et filtre les informations pour faciliter la recherche, le choix et l'identification </li>
             <li> Encourage la rencontre, l'échange intergénérationnel, la participation, l'implication.</li>
             <li> Aide à la découverte des nombreuses et dynamiques ressources locales.</li>
            </ul>
        </li>
            </ul>
            Ce portail numérique interactif et convivial présente :<br/><br/>
            <ul  class="niv1">
            <li><b>Un agenda des événements locaux</b> avec son calendrier, sa carte et des filtres par thèmes
             (ex: stage, concert, conférence,...).</li>
            <li><b>Un répertoire des acteurs et des structures</b> avec sa carte et des filtres par domaines d'activités (ex : culture, environnement, alimentation,...).</li>
            <li><b>Une page ''annonces''</b> avec sa carte et des filtres par thèmes
             (ex : échange, don, emploi,...).</li>

            </ul>
        </div>
        <hr>
        <div class="col-xs-12" style ="padding: 15px; text-align: justify;">
		  <iframe id="orga" src="<?php echo Yii::app()->createUrl('/network/default/index/?src=HVAorga') ; ?>" class="col-xs-12" style="height:650px;"></iframe>
        </div>
        <br/><hr>
        <div class="col-xs-12" style ="padding: 15px; text-align: justify;">
            <iframe id="event" src="<?php echo Yii::app()->createUrl('/network/default/index/?src=HVAevent') ; ?>" class="col-xs-12" style="height:650px;"></iframe>
        </div>
        <br/><hr>
        <div id="annonce" class="col-xs-12" style ="padding: 15px; text-align: justify;">
            <iframe  src="<?php echo Yii::app()->createUrl('/network/default/index/?src=HVAannonce') ; ?>" class="col-xs-12" style="height:650px;"></iframe>
        </div>
        <hr>
        <div id="rejoindre" class="col-xs-12" style ="padding: 15px; text-align: justify; margin-left: 20px">

            <h3> Comment nous rejoindre ? </h3>

            <span>
                C'est simple il suffit de remplir 
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSc8yce4HQQJHflDViNR_NDdlK9t7n3qoD2EjTQKWqNQLzcx8A/viewform?c=0&w=1&usp=mail_form_link">ce questionnaire</a>  <br/> <br/>
                Et de faire l'adhésion sur portailhva@gmail.com
            </span>
        </div>
        <hr>
        <div id="qui" class="col-xs-12" style="padding: 15px; text-align: justify; margin-left: 20px">
            <h3> Qui nous sommes ? </h3>
            En  2016 à Greffeil ont eu lieu les rencontres annuelles des amis de François De Ravignan ayant pour thème <b>''Relier les Initiatives de la Haute Vallée de l'Aude''. </b>
            Les échanges sur ce sujet ont permis de mettre en exergue un ensemble de constats assez particuliers:<br/><br/>
            <ul class="niv1">
            <li><b>Un foisonnement d'acteurs et de structures collectives</b>, pour la plupart nouvellement arrivés sur ce territoire, œuvrant principalement dans des domaines sociaux, environnementaux et culturels et portés par une vision commune d'un vivre ensemble bienveillant, épanouissant et réjouissant.</li>

            <li>Mais ce tissu, quoique dynamique, souffre d'un manque de réelles synergies entre les initiateurs et de carence de visibilité de leurs actions, les deux étant souvent liées à des problématiques rurales et organisationnelles.</li>
            <li><b>Un besoin apparaissait donc en faveur de la valorisation et du renforcement de ces ressources et de ces potentialités locales inscrites dans une démarche de développement social et économique local.</b></li>
            </ul><br/><br/>
            Les rencontres suivantes des ami-es de François de Ravignan à Serres, Luc/Aude, Festes, Rouvenac, ...ainsi que plusieurs ateliers organisés par des acteurs-initiateurs locaux intéressés à creuser ce sujet, ont montré une convergence d'idées et des pistes de propositions qui exprimaient :

            <ul class="niv1">
                <li><b>Une perception commune</b> que la co-construction d’événements ainsi que leurs efforts de publication pour promouvoir leurs activités était sacrément chronophages et énergivores avec parfois au final des ressentis de faible efficacité et de gaspillage, tous deux créateurs de frustration.</li>

                <li><b>Le souhait de renforcer</b> les liens entre les nouveaux ''arrivants''  sur ce territoire cosmopolite et les habitants autochtones aux structures plus institutionnelles.</li>

                <li>S'est aussi <b>affichée une volonté</b> d'orientation ''éthique'' respectant les valeurs d'une démarche solidaire et écologique dans un cadre d'un développement local de transition.</li>
            </ul>

            <br/>

            Pour donner une autre dimension à leurs actions, il s'avérait ainsi nécessaire de faciliter leur mise en réseau par la mutualisation de leurs différents canaux d'informations et donc de <b>créer un outil de communication collaboratif dans la contribution et la diffusion.</b>
            
            <br/>  <br/>
            En se réunissant plus fréquemment depuis le début d'année 2018, un collectif composé d'une quinzaine d'acteurs locaux s'est alors attelé à élaborer <b>un portail numérique</b> convivial, facile, rapide et actualisé.
            <br/>  <br/>

            Il voit ainsi le jour en cette fin d'année 2018 !
            
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

        $("#btnOrga").click(function(){
            $('html,body').animate({scrollTop: $("#orga").offset().top}, 'slow');
        });

        $("#btnEvent").click(function(){
            $('html,body').animate({scrollTop: $("#event").offset().top}, 'slow');
        });

        $("#btnAccueil").click(function(){
            $('html,body').animate({scrollTop: $("#accueil").offset().top}, 'slow');
        });

        $("#btnQui").click(function(){
            $('html,body').animate({scrollTop: $("#qui").offset().top}, 'slow');
        });

        $("#btnAnnonce").click(function(){
            //changeMenu("annonce");
            $('html,body').animate({scrollTop: $("#annonce").offset().top}, 'slow');
        });

        $("#btnRejoindre").click(function(){
            $('html,body').animate({scrollTop: $("#rejoindre").offset().top}, 'slow');
        });
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