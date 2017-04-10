<?php 
	$cssAnsScriptFilesTheme = array(
		//X-editable
		//'/plugins/x-editable/css/bootstrap-editable.css',
		//'/plugins/x-editable/js/bootstrap-editable.js' , 

		//DatePicker
		'/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js' ,
		'/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js' ,
		'/plugins/bootstrap-datepicker/css/datepicker.css',
			'/plugins/jquery.qrcode/jquery-qrcode.min.js',
		//DateTime Picker
		'/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
		'/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js' , 
		'/plugins/bootstrap-datetimepicker/css/datetimepicker.css',
		//Wysihtml5
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5.css',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5-editor.css',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/wysihtml5x-toolbar.min.js',
		'/plugins/wysihtml5/bootstrap3-wysihtml5/bootstrap3-wysihtml5.min.js',
		'/plugins/wysihtml5/wysihtml5.js',
		
		//SELECT2
		'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
		'/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js' ,

		// SHOWDOWN
		'/plugins/showdown/showdown.min.js',
		//MARKDOWN
		'/plugins/to-markdown/to-markdown.js',

	);
	//if ($type == Project::COLLECTION)
	//	array_push($cssAnsScriptFilesTheme, "/assets/plugins/Chart.js/Chart.min.js");
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
	$cssAnsScriptFilesModule = array(
		//Data helper
		'/js/dataHelpers.js',
		'/js/postalCode.js',
		'/js/activityHistory.js',
		'/js/news/index.js',
		'/js/default/editInPlace.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);

	$imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';
	$thumbAuthor =  @$element['profilThumbImageUrl'] ? 
                      Yii::app()->createUrl('/'.@$element['profilThumbImageUrl']) 
                      : "";
?>
<style>
	.img-thumb{
		height: 50px;
		width: 50px;
	}

	.podInside .panel-heading,
	.podInside .panel-tools{
		display:none;
	}
	.podInside .panel,
	.podInside .table{
		margin-bottom: 0px;
		border: 0px;
	}

	.podInside.collections a{
		font-size: 15px;
		font-weight: 700;
		padding:10px;
		display: inline-block;
	}

	.podchart .panel-heading{
		background-color: white !important;
	}

	.favElBtn{
		/*color: #FC4D4D !important;*/
		/*padding: 6px;
		margin-bottom: 4px;*/
	}

	.editBtn{
		float: right;
	}


	.btn-update-info, 
	.btn-update-network, 
	.btn-update-desc{

	}

	a.letter-grey{
		color:#425B5F;
	}



	#subsubMenuLeft hr{
	    margin-top: 7px;
    	margin-bottom: 7px;	
    	border-top: 2px solid #ededed;
	}

	#subsubMenuLeft a{
		color:#5B5B5C;
		font-size: 16px;
		padding: 6px;
		padding-left: 10px;
		display: block;
		text-align: left;
		font-weight: bold;
		border-left: 3px solid transparent;
	}

	#subsubMenuLeft a:hover{
		color:#0095FF;
		background-color: #edecec;
		border-left: 3px solid #0095FF;
	}
	
	#subsubMenuLeft a:active,
	#subsubMenuLeft a.active{
		background-color: #edecec;
		border-left: 3px solid #0095FF;
		color:#0095FF;
	}
	
	#subsubMenuLeft i.fa{
		width: 25px;
		text-align: center;
	}
</style>


<ul id="subsubMenuLeft">
	<?php if (($edit || $openEdition) && 
				@Yii::app()->session["userId"] &&
		 		$element["_id"] == Yii::app()->session["userId"]){	?>
	<!-- <li><hr></li>
	<a href="javascript:elementLib.openForm('ressource','sub')" class="letter-green">
		<i class="fa fa-plus-circle"></i> Publier ...
	</a>
	<li><hr></li> -->
	<?php } ?>

	<li class="">
		<a href="javascript:" class="" id="btn-start-detail">
			<i class="fa fa-info-circle"></i> <?php echo Yii::t("common","About"); ?>
		</a>
	</li>	

	<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION){ ?>
	<li class="">
		<a href="javascript:" class="edit-chart">
			<i class="fa fa-heartbeat"></i> <?php echo Yii::t("chart", "Nos valeurs"/*"Values and Cultures"*/) ?>
		</a>
	</li>
	<?php } ?>

	<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION){ ?>
	<li class=""><a href="javascript:" class=""><i class="fa fa-envelope"></i> Nous contacter</a></li>
	<?php } ?>

	<li><hr></li>


	<li class="">
		<a href="javascript:" class="" id="btn-start-gallery">
			<i class="fa fa-camera"></i> <?php echo Yii::t("common","Gallery"); ?>
		</a>
	</li>
	
	<li><hr></li>
	<?php if( 	$type != Person::COLLECTION || 
				Preference::showPreference( $element, $type, "directory", Yii::app()->session["userId"]) ) { ?>
		<li class="">
			<a href="javascript:" class="load-data-directory" data-type-dir="follows">
				<i class="fa fa-link"></i> <?php echo Yii::t("common","Follows"); ?>
			</a>
		</li>
		<li class="">
			<a href="javascript:" class="load-data-directory" data-type-dir="followers">
				<i class="fa fa-link"></i> <?php echo Yii::t("common","Followers"); ?>
			</a>
		</li>
		<li><hr></li>

		<?php if(!@$front || (@$front && $front["event"]==true)){ ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="events">
					<i class="fa fa-calendar"></i> <?php echo Yii::t("common","Events"); ?>
				</a>
			</li>
		<?php } ?>

		<?php if(!@$front || (@$front && $front["organization"]==true)){ ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="organizations">
					<i class="fa fa-group"></i> <?php echo Yii::t("common","Organisations"); ?>
				</a>
			</li>
		<?php }  

		if( ($type==Organization::COLLECTION || $type==Person::COLLECTION) &&
			(!@$front || ( @$front && $front["project"]==true) ) ) { ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="projects">
					<i class="fa fa-lightbulb-o"></i> <?php echo Yii::t("common","Projects"); ?>
				</a>
			</li>
			
		<?php } ?>

		<li><hr></li>

		<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION){ ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="links">
					<i class="fa fa-link"></i> Liste de liens
				</a>
			</li>
		<?php } ?>

		<?php if ($type==Person::COLLECTION){ ?>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="collections">
					<i class="fa fa-star"></i> Collections
				</a>
			</li>
		<?php } ?>

		<?php if( 	( $type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION || $type==Person::COLLECTION ) && 
					(!@$front || ( @$front && $front["poi"] ) ) ) { 
		?>
			<li>
				<a href="javascript:"  class="load-data-directory" data-type-dir="poi">
					<i class="fa fa-map-marker"></i> Points d'intérêts
				</a>
			</li>
		<?php } ?>

		
		<?php if( $type!=Event::COLLECTION && ( !@$front || (@$front && $front["need"]==true))){ ?>
			<li><hr></li>
			<li class="">
				<a href="javascript:" class="load-data-directory" data-type-dir="classified">
					<i class="fa fa-bullhorn"></i> Annonces
				</a>
			</li>
		<?php } ?>
		<li><hr></li>

	<?php } ?>

	
	<li class="">
		<a href="javascript:" class="load-data-directory" data-type-dir="dda">
			<i class="fa fa-gavel"></i> Espace coopératif
		</a>
	</li>

</ul>


<div class="hidden">

		<div id="menu-name" class="hidden">
			<img src="<?php echo $thumbAuthor; ?>" height="45" class="img-circle">
			<span class="font-montserrat hidden-sm hidden-xs"><?php echo @$element["name"]; ?></span>
		</div>

		<ul id="accordion" class="accordion shadow2">
		    <li>
				
		        
		    </li>
			<li>
				<div id="btn-start-detail" class="link">
					<i class="fa fa-info-circle"></i><?php echo Yii::t("common","About"); ?><i class="fa fa-chevron-right"></i>
					<?php if($edit==true || $openEdition==true ){?>
						<!-- <a  href="javascript:;" class="tooltips btn-update-info" data-toggle="tooltip" data-placement="bottom" 
							title="<?php echo Yii::t("common","Update Contact information");?>">
							<i class="fa text-red fa-cog"></i>
						</a> -->
					<?php } ?>
				</div>
				<ul class="submenu">
				<!--
					<?php //if(@$edit==true){ ?>
							<li class="tooltips " data-edit-id="name">
								<i class="fa fa-user-circle-o"></i> <?php //echo Yii::t("common","Name"); ?> : 
								<span id="name" class=""><?php //if(isset($element["name"])) echo $element["name"]; else echo ""; ?></span>
							</li>
					<?php //} ?>
				-->
					<?php if($type==Person::COLLECTION){ ?>
							<li class="tooltips hidden username" data-toggle="tooltip" data-placement="right" 
								title="<?php echo Yii::t("common","Username"); ?>">
								<i class="fa fa-user-secret"></i> 
								<span id="usernameMenuLeft" class="">
									<?php if(isset($element["username"])) echo $element["username"]; else echo ""; ?>
								</span>
							</li>
					<?php } ?>

					<?php if($type==Person::COLLECTION){
						if(Preference::showPreference($element, $type, "birthDate", Yii::app()->session["userId"])){ ?>
							<li class="hidden birthDate" data-toggle="tooltip" data-placement="right" 
								title="<?php echo Yii::t("person","Birth date"); ?>">
								<i class="fa fa-birthday-cake"></i> <?php echo Yii::t("person","Birth date"); ?> : 
								<span id="birthDateMenuLeft" class=""><?php echo (isset($element["birthDate"])) ? date("d/m/Y", strtotime($element["birthDate"]))  : null; ?></span>
							</li>
						<?php }
					} ?>

					<?php if($type==Project::COLLECTION && isset($element["properties"]["avancement"]) ){ ?>
						<li class="tooltips hidden avancement"  data-toggle="tooltip" data-placement="right" 
							title="<?php echo Yii::t("project","Project maturity",null,Yii::app()->controller->module->id); ?>">
							<span id="avancementMenuLeft"> <?php echo Yii::t("project","Project maturity",null,Yii::app()->controller->module->id)." : ".Yii::t("project",$element["properties"]["avancement"],null,Yii::app()->controller->module->id); ?></span>
						</li>
					<?php } ?>

					<?php if( 	( 	$type==Person::COLLECTION && 
									Preference::showPreference($element, $type, "email", Yii::app()->session["userId"]) ) || 
							  	(	$type!=Person::COLLECTION && $type!=Event::COLLECTION ) ){ ?>
								<li class="tooltips hidden email" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","E-mail"); ?>">
									<i class="fa fa-envelope"></i>
									<span id="emailMenuLeft" class=""><?php echo (isset($element["email"])) ? $element["email"] : ""; ?></span>
								</li>
					<?php } ?>
					
					<?php //If there is no http:// in the url
					$scheme = "";
					if(isset($element["url"])){
						if (!preg_match("~^(?:f|ht)tps?://~i", $element["url"])) $scheme = 'http://';

					}?>

					<li class="tooltips url hidden" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Website URL") ?>">
						<i class="fa fa-desktop"></i>
						<span>
							<a href="<?php echo (isset($element["url"])) ? $scheme.$element['url'] : 'javascript:;'; ?>" target="_blank" id="urlMenuLeft" style="cursor:pointer;">
								<?php echo (isset($element["url"])) ? $element["url"] : ""; ?>
							</a>
						</span>
					</li>


					<?php  if($type==Organization::COLLECTION || $type==Person::COLLECTION){ ?>
								<li class="tooltips fixe hidden" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Phone") ?>">
									<i class="fa fa-phone"></i>
									<span id="fixe">
										<?php
											if( !empty($element["telephone"]["fixe"])){
												$fixe = "";
												foreach ($element["telephone"]["fixe"] as $key => $num) {
													$fixe .= ($fixe != "") ? ", ".trim($num) : trim($num);
												}
												echo $fixe;
											}	
										?>
									</span>
								</li>
								<li class="tooltips mobile hidden" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Mobile") ?>">
									<i class="fa fa-mobile"></i>
									<span id="mobile">
										<?php
											if( !empty($element["telephone"]["mobile"])){
												$mobile = "";
												foreach ($element["telephone"]["mobile"] as $key => $num) {
													$mobile .= ($mobile != "") ? ", ".trim($num) : trim($num);
												}
												echo $mobile;
											}	
										?>
									</span>
								</li>
								<li class="tooltips fax hidden" data-toggle="tooltip" data-placement="right" title="<?php echo Yii::t("common","Fax") ?>">
									<i class="fa fa-fax"></i>
									<span id="fax">
										<?php
											if( !empty($element["telephone"]["fax"])){
												$fax = "";
												foreach ($element["telephone"]["fax"] as $key => $num) {
													$fax .= ($fax != "") ? ", ".trim($num) : trim($num);
												}
												echo $fax;
											}	
										?>
									</span>
								</li>
					<?php } ?>
				</ul>
			</li>

			<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION){ ?>
			<li class="podInside">
				<?php $countCharts=0;
						if(@$element["properties"] && @$element["properties"]["chart"]) 
							$countCharts=count($element["properties"]["chart"]) 
				?>
				<div class="link"><i class="fa fa-puzzle-piece"></i><?php echo Yii::t("chart", "Values and Cultures") ?> 
					<?php if($countCharts > 0) echo "(".$countCharts.")"; ?> 
					<i class="fa fa-chevron-down"></i>
				</div>

				<ul class="submenu">
					<div class="panel panel-white">		
					<?php if($countCharts==0){ ?>				
							<div id="infoPodChart" class="padding-10 <?php if(!empty($properties)) echo "hide" ?>">
								<blockquote> 
									<?php echo Yii::t("chart","Create Chart<br/>Opening<br/>Values<br/>Governance<br/>To explain the aim and draw project conduct") ?>
								</blockquote>
							</div>
					<?php }else{
						foreach($element["properties"]["chart"] as $key => $data){
							if($key=="commons") $title=Yii::t("chart","Chart of commons");
							else $title=Yii::t("chart","Open chart");
						?>
							<li>
								<div class="subLink btn-start-chart" data-value="<?php echo $key ?>">
								<?php echo $title; ?>
								<i class="fa fa-chevron-right pull-right letter-blue"></i>
								</div>
							</li>
						<?php }
					} ?>
					</div>
					<div class="text-right padding-10">
					<?php if (($edit || $openEdition) && @Yii::app()->session["userId"]){	?>
						<button class="edit-chart btn btn-default letter-blue margin-top-5 tooltips" 
							data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("chart","Edit properties") ?>">
							<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
						</button>
					<?php } ?>
					</div>					<?php
					/*if(empty($element["properties"]["chart"])) $element["properties"]["chart"] = array();
					$this->renderPartial('../chart/index',array(
											"itemId" => (string)$element["_id"], 
											"itemName" => $element["name"], 
											"parentType" => $type, 
											"properties" => $element["properties"]["chart"],
											"admin" =>$edit,
											"isDetailView" => 1,
											"openEdition" => $openEdition));*/
					?>
				</ul>
			</li>
		<?php } ?>
		</ul>

		<ul id="accordion4" class="accordion shadow2 margin-top-20">

			<!-- COMMUNAUTÉ -->
			<?php //if($type != Person::COLLECTION){ ?>
			<li class="podInside community">
				<div class="link">
					<i class="fa fa-connectdevelop"></i> Communauté 
					<small>(<?php echo @$members ? count($members) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
		 			<?php $this->renderPartial('../pod/usersList', array(  $controller => $element,
														"users" => @$members,
														"userCategory" => Yii::t("common","Community"), 
														"contentType" => $type,
														"countStrongLinks" => $countStrongLinks,
														"countLowLinks" => $countLowLinks,
														"countInvitations" => $countInvitations,
														"admin" => $edit, 
														"invitedMe" => @$invitedMe,
														"openEdition" => $openEdition)); ?>
					<div class="text-right padding-10">

						<?php if(@$edit==true && $type!=Person::COLLECTION) { ?>
						<button data-toggle="modal" data-target="#modal-scope"
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Ajouter un membre</b>
						</button> 
						<?php } ?>

						<button class="btn btn-default letter-blue open-directory margin-top-5">
					    	<b><i class="fa fa-connectdevelop"></i> Afficher la communauté <i class="fa fa-chevron-right"></i></b>
						</button>
						
					</div>	
				</ul>			
			</li>
			<?php //} ?>
		</ul>
		

		<ul id="accordion2" class="accordion shadow2 margin-top-20">
		
			<!-- CONTACTS -->
			<?php if (($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION)){ ?>
			<li class="podInside">
				<div class="link">
					<i class="fa fa-user-circle"></i> Nous contacter
					<small>(<?php echo @$element["contacts"] ? count($element["contacts"]) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php 
					$contacts = ( empty($element["contacts"]) ? array() : $element["contacts"] ) ;
					$this->renderPartial('../pod/contactsList',array( 	"contacts" => @$contacts, 
																		"contextId" => (String) $element["_id"],
																		"contextType" => $controller,
																		"authorised" => $edit,
																		"openEdition" => $openEdition
																	  ));
					?>
					<div class="text-right padding-10">
						<?php if(@$edit==true) { ?>
						<button onclick="elementLib.openForm ( 'contactPoint','contact')" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Ajouter un contact </b>
						</button>
						<?php } ?>
					</div>
				</ul>
			</li>
			<?php } ?>


			<!-- URL -->
			<?php if (($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION)){ ?>
			<li class="podInside">
				<div class="link">
					<i class="fa fa-user-circle"></i> Liste de liens
					<small>(<?php echo @$element["urls"] ? count($element["urls"]) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php 
					$urls = ( empty($element["urls"]) ? array() : $element["urls"] ) ;
					$this->renderPartial('../pod/urlsList',array( 	"urls" => $urls, 
																	"contextId" => (String) $element["_id"],
																	"contextType" => $controller,
																	"authorised" => $edit,
																	"openEdition" => $openEdition));
					?>
					<div class="text-right padding-10">
						<?php if(@$edit==true || @$openEdition==true) { ?>
						<button onclick="elementLib.openForm ( 'url','parentUrl')" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Ajouter une url </b>
						</button>
						<?php } ?>
					</div>
				</ul>
			</li>
			<?php } ?>

			<!-- COLLECTION -->
			<?php if ($type==Person::COLLECTION){ ?>
			<li class="podInside collections">
				<div class="link">
					<i class="fa fa-star"></i> Collections 
					<small>(<?php echo @$element["collections"] ? count($element["collections"]) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php $this->renderPartial('../pod/collections',array( 	"collections" => @$element["collections"] )); ?>
					<?php if(@$edit==true) { ?>
					<div class="text-right padding-10">
						<button onclick="collection.crud()" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Créer une collection </b>
						</button>
					</div>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>

			<!-- BESOINS -->
			<?php if( $type!=Event::COLLECTION && ( !@$front || (@$front && $front["need"]==true))){ ?>
	    	<li class="podInside needs">
				<div class="link">
					<i class="fa fa-cubes"></i> <?php if( $type!=Person::COLLECTION){ ?>Nos<?php }else{ ?>Mes<?php } ?> besoins 
					<small>(<?php echo @$needs ? count($needs) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php $this->renderPartial('../pod/needsList',array("needs" => @$needs, 
																		"parentId" => (String) $element["_id"],
																		"parentType" => $type,
																		"isAdmin" => @$edit,
																		"parentName" => $element["name"],
																		"openEdition" => $openEdition
																	  )); ?>
					<div class="text-right padding-10">
						<?php if(@$edit==true) { ?>
						<button onclick="" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> Créer un besoin </b>
						</button>
						<?php } ?>
					</div>
				</ul>
			</li>
			<?php } ?>
			
		</ul>
		
		<?php if($type==Project::COLLECTION || $type==Organization::COLLECTION){
			if(!@$front || (@$front && $front["dda"]==true)){
				$rooms = ActionRoom::getAllRoomsActivityByTypeId($type, (string)$element["_id"]); ?>
		<ul id="accordion5" class="accordion shadow2 margin-top-20">
			<li class="podInside dda">
				<div class="link">
					<i class="fa fa-comments"></i> <?php echo Yii::t("common","Espace coopératif (activité récente)") ?> 
					<small>(<?php echo @$rooms ? count($rooms) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php	
						$this->renderPartial('../pod/activityList2',array(    
			   					"parent" => $element, 
			                    "parentId" => (string)$element["_id"], 
			                    "parentType" => $type, 
			                    "title" => "Espace coopératif (activité récente)",
		                    	"list" => @$rooms, 
			                    "renderPartial" => true
			                    ));
						}
					?>
					<div class="text-right padding-10">
						<button class="btn btn-default letter-blue margin-top-5" onclick='url.loadByHash("#rooms.type.<?php echo $type; ?>.id.<?php echo (String)$element["_id"]; ?>")'>
					    	<i class="fa fa-sign-in"></i> Entrer dans l'espace coopératif
						</button>
					</div>	
				</ul>			
			</li>
		</ul>
		<?php } ?>

		<button onclick="elementLib.openForm('ressource','sub')" class="btn btn-default letter-blue margin-top-5">
			<b><i class="fa fa-plus"></i> Ajouter une ressource </b>
		</button>

		<ul id="accordion3" class="accordion shadow2 margin-top-20">
				
			<!-- PROJETS -->
			<?php if ($type==Organization::COLLECTION || $type==Project::COLLECTION){ 
				if(!@$front || (@$front && $front["project"])){ 
			?>
			<li class="podInside projects">
				<div class="link">
					<i class="fa fa-lightbulb-o"></i> <?php echo Yii::t("common","Projects") ?> 
					<small>(<?php echo @$projects ? count($projects) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
		 			<?php $this->renderPartial('../pod/projectsList',array( "projects" => @$projects, 
															"contextId" => (String) $element["_id"],
															"contextType" => $type,
															"authorised" =>	$edit,
															"openEdition" => $openEdition
					)); ?>
					<div class="text-right padding-10">
						<?php if(@$edit==true || ($openEdition==true && @Yii::app()->session["userId"])) { ?>
						<button onclick="elementLib.openForm('project','sub')" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> <?php echo Yii::t("common", "New project"); ?></b>
						</button> 
						<?php } ?>
						<button class="btn btn-default letter-blue open-directory margin-top-5">
					    	<i class="fa fa-chevron-right"></i>
						</button>
						
					</div>	
				</ul>			
			</li>
			<?php }} ?>
				
			
			<!-- ÉVÉNEMENTS -->
			<?php if (($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION)){ ?>
	    		<?php if(!@$front || (@$front && $front["event"]==true)){ ?>
					<?php 
						$organizerImg=false;
						if($type==Event::COLLECTION){ 
							$organizerImg=true;
							if(empty($subEvents)) $subEvents = array();
							$events=$subEvents;
						}
						if(!isset($eventTypes)) $eventTypes = array();
						if(empty($subEvents)) $subEvents = array();
					?>
					<li class="podInside events">
					
						<div class="link">
							<i class="fa fa-calendar"></i> <?php echo Yii::t("common","Events") ?> 
							<small>(<?php echo @$events ? count($events) : "0"; ?>)</small>
							<i class="fa fa-chevron-down"></i>
						</div>
						<ul class="submenu">
							<?php	$this->renderPartial('../pod/eventsList',array( 	"events" => @$events, 
																						"contextId" => (String) $element["_id"],
																						"contextType" => $controller,
																						"list" => $eventTypes,
																						"authorised" => $edit,
																						"organiserImgs"=> $organizerImg,
																						"openEdition" => $openEdition
																					  ));
							?>
							<div class="text-right padding-10">
								<?php if(@$edit==true || ($openEdition==true && @Yii::app()->session["userId"])) { ?>
								<button onclick="elementLib.openForm('event','subEvent')" 
										class="btn btn-default letter-blue margin-top-5">
							    	<b><i class="fa fa-plus"></i> <?php echo Yii::t("common","New event") ?></b>
								</button> 
								<?php } ?>
								<button class="btn btn-default letter-blue open-directory margin-top-5" 
								data-toggle="tooltip" data-placement="right" title="Afficher tout">
							    	<i class="fa fa-chevron-right"></i>
								</button>
								
							</div>	
						</ul>			  
					</li>
				<?php } ?>
			<?php } ?>

			<!-- POI -->
			<?php if ($type==Project::COLLECTION || $type==Organization::COLLECTION || $type==Event::COLLECTION || $type==Person::COLLECTION){ 
				if(!@$front || (@$front && $front["poi"])){ 
			?>
			<li class="podInside poi">
				<div class="link">
				<?php   
				$pois = PHDB::find(Poi::COLLECTION,array("parentId"=>(String)$element["_id"],"parentType"=>$type));
				?>
					<i class="fa fa-map-marker"></i> <?php echo Yii::t("common", "Points of interests") ?>
					<small>(<?php echo @$pois ? count($pois) : "0"; ?>)</small>
					<i class="fa fa-chevron-down"></i>
				</div>
				<ul class="submenu">
					<?php $this->renderPartial('../pod/POIList', array( "pois"=>$pois, "parentType"=> $type)); ?>
		 			<?php /* $this->renderPartial('../pod/projectsList',array( "projects" => @$projects, 
															"contextId" => (String) $element["_id"],
															"contextType" => $type,
															"authorised" =>	$edit,
															"openEdition" => $openEdition
					)); */ ?>
					<div class="text-right padding-10">
						<?php if(@$edit==true || ($openEdition==true && @Yii::app()->session["userId"])) { ?>
						<button onclick="elementLib.openForm('poi','subPoi')" 
								class="btn btn-default letter-blue margin-top-5">
					    	<b><i class="fa fa-plus"></i> <?php echo Yii::t("common", "New point of interests") ?></b>
						</button> 
						<?php } ?>
						<!--<button class="btn btn-default letter-blue open-directory margin-top-5">
					    	<i class="fa fa-chevron-right"></i>
						</button>-->
						
					</div>	
				</ul>			
			</li>
			<?php }} ?>

			<?php /*$this->renderPartial('../pod/ficheInfoPodThumb', array("list"=>@$events, 
																		 "title"=>"Événements", 
																		 "icon"=>"calendar",
																		 "thumbOnly"=>true) );*/ ?>


			<?php /*$this->renderPartial('../pod/ficheInfoPodThumb', array("list"=>@$needs, 
																		 "title"=>"Besoins", 
																		 "icon"=>"cubes") ); */?>

		</ul>
</div>

<?php 
	//$element["type"] = $type;
	//$element["id"] = (string)$element["_id"];
	$emptyAddress = (empty($element["address"]["codeInsee"])?true:false);
	$showOdesc = true ;
	if(Person::COLLECTION == $type){
		$showLocality = (Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"])?true:false);
		$showOdesc = ((Preference::isOpenData($element["preferences"]) && Preference::isPublic($element, "locality"))?true:false);	
	}
	$odesc = "" ;
	if($showOdesc == true){
		$controller = Element::getControlerByCollection($type) ;
		if($type == Person::COLLECTION)
			$odesc = $controller." : ".addslashes( strip_tags(json_encode(@$element["shortDescription"]))).",".addslashes(json_encode(@$element["address"]["streetAddress"])).",".@$element["address"]["postalCode"].",".@$element["address"]["addressLocality"].",".@$element["address"]["addressCountry"] ;
		else if($type == Organization::COLLECTION)
			$odesc = $controller." : ".@$element["type"].", ".addslashes( strip_tags(json_encode(@$element["shortDescription"]))).",".addslashes(json_encode(@$element["address"]["streetAddress"])).",".@$element["address"]["postalCode"].",".@$element["address"]["addressLocality"].",".@$element["address"]["addressCountry"];
		else if($type == Event::COLLECTION)
			$odesc = $controller." : ".@$element["startDate"].",".@$element["endDate"].",".addslashes(json_encode(@$element["address"]["streetAddress"])).",".@$element["address"]["postalCode"].",". @$element["address"]["addressLocality"].",".@$element["address"]["addressCountry"].",".addslashes(strip_tags(json_encode(@$element["shortDescription"])));
		else if($type == Project::COLLECTION)
			$odesc = $controller." : ".addslashes( strip_tags(json_encode(@$element["shortDescription"]))).",".addslashes(json_encode(@$element["address"]["streetAddress"])).",".@$element["address"]["postalCode"].",".@$element["address"]["addressLocality"].",".@$element["address"]["addressCountry"];
	}
?>
<script type="text/javascript">

    var contextId = "<?php //echo @$element["id"]; ?>";
    var edit = '<?php echo (@$edit == true) ? "true" : "false"; ?>';
	var openEdition = '<?php echo (@$openEdition == true) ? "true" : "false"; ?>';

	var showLocality = (( "<?php echo @$showLocality; ?>" == "<?php echo false; ?>")?false:true);
	var contextData = {
			name : "<?php echo addslashes($element["name"]) ?>",
			id : "<?php echo (string)$element["_id"] ?>",
			type : "<?php echo $type ?>",
			controller : <?php echo json_encode(Element::getControlerByCollection($type))?>,
			otags : "<?php echo addslashes($element["name"]).",".$type.",communecter,".@$element["type"].",".addslashes(@implode(",", $element["tags"])) ?>",
			odesc : <?php echo json_encode($odesc) ?>,
			<?php 
			if( @$element["startDate"] )
				echo "'startDate':'".$element["startDate"]."',";
			if( @$element["endDate"] )
				echo "'endDate':'".$element["endDate"]."'"; ?>
	};

	if(	( showLocality == true && "<?php echo Person::COLLECTION; ?>" == contextData.type ) 
		|| "<?php echo Person::COLLECTION; ?>" != contextData.type) {
		contextData.geo = <?php echo json_encode(@$element["geo"]) ?>;
		contextData.geoPosition = <?php echo json_encode(@$element["geoPosition"]) ?>;
		contextData.address = <?php echo json_encode(@$element["address"]) ?>;
		contextData.addresses = <?php echo json_encode(@$element["addresses"]) ?>;
	}

	if(	edit == "true" || openEdition == "true") {
		contextData.email = '<?php if(isset($element["email"])) echo $element["email"]; else echo ""; ?>';
		contextData.url = '<?php if(isset($element["url"])) echo $element["url"]; else echo ""; ?>';
		contextData.fixe =parsePhone(<?php echo json_encode((isset($element["telephone"]["fixe"]) ? $element["telephone"]["fixe"] : array())); ?>);
		contextData.mobile = parsePhone(<?php echo json_encode((isset($element["telephone"]["mobile"]) ? $element["telephone"]["mobile"] : array())); ?>);
		contextData.fax = parsePhone(<?php echo json_encode((isset($element["telephone"]["fax"]) ? $element["telephone"]["fax"] : array())); ?>);
		contextData.tags = <?php echo json_encode((isset($element["tags"]) ? $element["tags"] : array())); ?>;

		if(contextData.type == "<?php echo Person::COLLECTION; ?>" ){
			contextData.username = '<?php if(isset($element["username"])) echo $element["username"]; else echo ""; ?>';
			contextData.birthDate = '<?php if(isset($element["birthDate"])) echo $element["birthDate"]; else echo ""; ?>';
			contextData.twitter = '<?php if(isset($element["socialNetwork"]["twitter"])) echo $element["socialNetwork"]["twitter"]; else echo ""; ?>';
			contextData.gpplus = '<?php if(isset($element["socialNetwork"]["googleplus"])) echo $element["socialNetwork"]["googleplus"]; else echo ""; ?>';
			contextData.gitHub = '<?php if(isset($element["socialNetwork"]["github"])) echo $element["socialNetwork"]["github"]; else echo ""; ?>';
			contextData.skype = '<?php if(isset($element["socialNetwork"]["skype"])) echo $element["socialNetwork"]["skype"]; else echo ""; ?>';
			contextData.telegram = '<?php if(isset($element["socialNetwork"]["telegram"])) echo $element["socialNetwork"]["telegram"]; else echo ""; ?>';
			contextData.facebook = '<?php if(isset($element["socialNetwork"]["facebook"])) echo $element["socialNetwork"]["facebook"]; else echo ""; ?>';
		}
	}


	if(contextData.type == "<?php echo Organization::COLLECTION; ?>" ){
		contextData.typeOrga = '<?php if(isset($element["type"])) echo $element["type"]; else echo ""; ?>';
	}
	contextData.descriptionHTML = '<?php if(isset($element["descriptionHTML"])) echo $element["descriptionHTML"]; else echo ""; ?>';
	

	if(contextData.type == "<?php echo Event::COLLECTION; ?>"){
		contextData.allDay = '<?php echo (@$element["allDay"] == true) ? "true" : "false"; ?>';
	}

	if(contextData.type == "<?php echo Event::COLLECTION; ?>" || contextData.type == "<?php echo Project::COLLECTION; ?>" ){
		contextData.startDate = '<?php if(isset($element["startDate"])) echo $element["startDate"]; else echo ""; ?>';
		contextData.endDate = '<?php if(isset($element["endDate"])) echo $element["endDate"]; else echo "" ?>';
	}

	if(contextData.type == "<?php echo Project::COLLECTION; ?>" )
		contextData.avancement = '<?php if(isset($element["properties"]["avancement"])) echo $element["properties"]["avancement"]; else echo "" ?>' ;

	var formatDateView = "DD MMMM YYYY à HH:mm" ;
	var formatDatedynForm = "DD/MM/YYYY HH:mm" ;
	if(typeof contextData.allDay != "undefined" && contextData.allDay == "true"){
		formatDateView = "DD MMMM YYYY" ;
		formatDatedynForm = "DD/MM/YYYY" ;
	}

	var emptyAddress = (( "<?php echo @$emptyAddress; ?>" == "<?php echo false; ?>")?false:true);

	var mode = "view";
	var types = <?php echo json_encode(@$elementTypes) ?>;
	var countries = <?php echo json_encode($countries) ?>;
	var modeEdit = '<?php echo (@$modeEdit == true) ? "true" : "false"; ?>';
	var NGOCategoriesList = <?php echo json_encode(@$NGOCategories) ?>;
	var localBusinessCategoriesList = <?php echo json_encode(@$localBusinessCategories) ?>;
	var color = '<?php echo Element::getColorIcon($type); ?>';
	var icon = '<?php echo Element::getFaIcon($type); ?>';
	var organizer = <?php echo json_encode(@$organizer) ?>;
	var tags = <?php echo json_encode($tags)?>;

	var category = <?php echo (isset($element["category"])) 			? json_encode(implode(",", $element["category"])) : "''"; ?>;
	var description = <?php echo (isset($element["description"])) ? json_encode($element["description"]) : "''"; ?>;

	var TYPE_NGO = "<?php echo Organization::TYPE_NGO ?>";
	var TYPE_BUSINESS = "<?php echo Organization::TYPE_BUSINESS ?>";
	var EVENT_COLLECTION = "<?php echo Event::COLLECTION ?>";

	var isEditing = false;
	
	jQuery(document).ready(function() {
		bindDynFormEditable();
		changeHiddenFields();
		bindAboutPodElement();
		bindLBHLinks();

		$("#small_profil").html($("#menu-name").html());
		$("#menu-name").html("");

		//console.log("contextDatacontextData", contextData, contextData.type,contextData.id);
		buildQRCode(contextData.type,contextData.id.$id);

		$(".toggle-tag-dropdown").click(function(){ mylog.log("toogle");
			if(!$("#dropdown-content-multi-tag").hasClass('open'))
			setTimeout(function(){ $("#dropdown-content-multi-tag").addClass('open'); }, 300);
			$("#dropdown-content-multi-tag").addClass('open');
		});
		$(".toggle-scope-dropdown").click(function(){ mylog.log("toogle");
			if(!$("#dropdown-content-multi-scope").hasClass('open'))
			setTimeout(function(){ $("#dropdown-content-multi-scope").addClass('open'); }, 300);
		});

		smallMenu.inBlockUI = false; 
		smallMenu.destination = "#central-container"; 
		directory.elemClass = smallMenu.destination+' .searchEntityContainer ';

		mylog.log("tagg1 smallMenu.destination", smallMenu.destination);
		
		$(".open-directory").click(function(){
			toogleNotif(false);
			smallMenu.openAjax(baseUrl+'/'+moduleId+'/element/directory/type/'+contextData.type+'/id/'+contextData.id+
								'?tpl=json','Communauté','fa-connectdevelop','dark');
			bindLBHLinks();
		});

		/*$(".open-description").click(function(){
			mylog.log("here", markdownToHtml($("#descriptionMarkdown").val()));
			toogleNotif(false);
			smallMenu.open( markdownToHtml($("#descriptionMarkdown").val()));
			bindLBHLinks();
		});*/


		$(".edit-chart").click(function(){
			toogleNotif(false);
			var url = "chart/addchartsv/type/"+contextData.type+"/id/"+contextData.id;
			$('#central-container').html("<i class='fa fa-spin fa-refresh'></i>");
			ajaxPost('#central-container', baseUrl+'/'+moduleId+'/'+url, 
			null,
			function(){},"html");
		});
		$(".btn-open-collection").click(function(){
			toogleNotif(false);
		});

		$("#btn-start-detail").click(function(){
			loadDetail();
		});		
		
	});

	function parsePhone(arrayPhones){
		var str = "";
		$.each(arrayPhones, function(i,num) {
			if(str != "")
				str += ", ";
			str += num.trim();
		});
		return str ;
	}

</script>
