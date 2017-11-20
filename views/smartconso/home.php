<?php 

    $cssAnsScriptFilesModule = array(
    '/assets/css/default/search.css',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

    $cssAnsScriptFilesModule = array(
    //'/js/default/search.js',
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

    $page = "smartconso";

    //header + menu
    $this->renderPartial($layoutPath.'header', 
                            array(  "layoutPath"=>$layoutPath ,
                                    "page" => $page,
                                    "type" => @$type) ); 
?>

<style>
   .smartcat .description{
   		max-height: 150px;
   		min-height: 150px;
   		display: inline-block;
   		overflow:hidden;
   }

   .smartcat .bg-light{
   		background: #ece9e9;
   }
</style>

<?php 
	$ecocat = array(array("title"=>"Cons' Eau",
						  "defit"=>"Energie - défit n°2",
						  "hash" => "#smartconso.p.conseau",
						  "icon" => "tint",
						  "description" => "Proposer une application mobile ou web permettant de présenter 
						  					les données de consommation d'eau provenant quotidiennement de la télérelève."),
					
					array("title"=>"Alerte CDE",
						  "defit"=>"Energie - défit n°3",
						  "hash" => "#smartconso.p.alertecde",
						  "icon" => "tint",
						  "description" => "Proposer une application smartphone permettant d’alerter la CDE : 
						  					en cas de constat de fuite sur le réseau d’eau potable ou d’assainissement, 
						  					qui se rependrait dans l’environnement (sur la chaussée, sur le bas côté…) ; 
						  					en cas de constat d’une sécheresse sur une ressource en eau ;  a
						  					vec géolocalisation précise et prise de photos."),
					
					array("title"=>"Pollution de l'eau",
						  "defit"=>"Environnement - défit n°1",
						  "hash" => "#smartconso.p.pollutioneau",
						  "icon" => "tint",
						  "description" => "Créer une solution numérique qui permette de déclencher 
						  					des plans d’action en cas de pollution de l’eau. / 
						  					Croiser les données de pluviométrie (de Meteo France + CDE à l’Anse Vata) 
						  					avec les données de débordement d'ouvrage d'assainissement de la CDE et si possible 
						  					les données bactériologiques des plages de Nouméa 
						  					(à fournir par la DRS de la ville de Nouméa). 
						  					L’analyse de ces données en temps réel peut déclencher différents plans d’actions."),

					array("title"=>"Conso électrique",
						  "defit"=>"Energie - défit n°4",
						  "hash" => "#smartconso.p.consoelec",
						  "icon" => "plug",
						  "description" => "Proposer une application permettant de connaître sa consommation électrique en temps réel."),
					
					
					array("title"=>"Conso internet",
						  "defit"=>"Energie - défit n°5",
						  "hash" => "#smartconso.p.consointernet",
						  "icon" => "podcast",
						  "description" => "Nautile propose plusieurs défis liés à la consommation internet : 
						  					Alertes de consommation selon une limite définie par l’utilisateur / Profils de consommation 
						  					(selon l’heure, le jour, le type de trafic, résidentiel, entreprises, etc.) 
						  					à corréler avec d’autres sources de données. / 
						  					Statistiques globales d’utilisations par type de trafic / 
						  					Corréler les données de consommation avec la météo (ex : cyclone). "),
					
					
					array("title"=>"Qualité de l'air",
						  "defit"=>"Environnement - défit n°3",
						  "hash" => "#smartconso.p.qualiteaire",
						  "icon" => "flag",
						  "description" => "Développer une application smartphone pour connaître la qualité de l'air"),
					
					
					
					
					
					);
?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-white pageContent margin-top-50 padding-bottom-50">
	<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10 col-sm-12 col-xs-12 no-padding">
		<?php foreach ($ecocat as $key => $category) { ?>
		<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 padding-15 smartcat">
			<div class="col-xs-12 padding-15 shadow2 bg-light">
				<h4>
					<a href="<?php echo $category["hash"]; ?>" class="lbh letter-blue">
						<i class="fa fa-hashtag"></i> <?php echo $category["title"]; ?>
					</a>
					<br>
					<small>
						<i class="fa fa-<?php echo $category["icon"]; ?>"></i> 
						<?php echo $category["defit"]; ?>
					</small>
				</h4>
				<small class="description"><?php echo $category["description"]; ?></small>
				<br>
				<a href="<?php echo $category["hash"]; ?>" 
				   class="btn btn-link bg-green-k lbh pull-right">
				   <i class="fa fa-rocket"></i> Accéder à l'application <i class="fa fa-angle-right"></i>
				</a>
			</div>
		</div>
		<?php } ?>
	</div>
</div>




<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array()); ?>

<script type="text/javascript" >

var titlePage = "<?php echo Yii::t("common",@$params["pages"]["#".$page]["subdomainName"]); ?>";

jQuery(document).ready(function() {

    setTitle("", "", titlePage);
    initKInterface({"affixTop":320});

});

</script>