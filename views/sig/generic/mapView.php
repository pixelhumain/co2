<?php
	//securise tous les paramètres utilisés dans mapView.php
	$elements = array('usePanel', 		'useRightList',  'useResearchTools', 	'useZoomButton',
					  'useHomeButton', 	'useFullScreen', 'useHelpCoordinates', 	'useChartsMarkers');

	foreach($elements as $element){
		$sigParams[$element] = isset($sigParams[$element]) ? $sigParams[$element] : false;
	}
	
?>
<div class="sigModule<?php echo $sigParams['sigKey']; ?>">
	<div class="mapCanvas" id="mapCanvas<?php echo $sigParams['sigKey']; ?>">
		<!-- <center><img class="world_pix" style="margin-top:50px;" src="<?php echo $this->module->assetsUrl; ?>/images/shattered.png"></center> -->
    </div>

	<!-- <div id="form-in-map">
		<div id="form-in-map-title">
		
		</div>
		<div id="form-in-map-content">
		
		</div>
	</div>	 -->
	
	<?php if(isset($sigParams['useHorizontalAroundMe']) && 
				@$sigParams['useHorizontalAroundMe'] == true ){ ?>
			<div class="btn-group btn-groupe-around-me-km  btn-groupe-around-me-km-hz" 
				 role="group" aria-label="...">
			  <button class="btn btn-map" data-km="2000">2 km</button>
			  <button class="btn btn-map" data-km="5000">5 km</button>
			  <button class="btn btn-map" data-km="10000">10 km</button>
			  <button class="btn btn-map" data-km="25000">25 km</button>
			  <button class="btn btn-map" data-km="50000">50 km</button>
			  <button class="btn btn-map" id="loader-aroundme"></button>

			</div>
	<?php } ?>

	<div class="bg-main-menu bgpixeltree_sig"></div>

	<?php if($sigParams['useRightList']){ ?>
		<div id="right_tool_map" class="hidden-xs hidden-sm">
			<div id="right_tool_map_search">
			<!-- 	HEADER -->
				<div class="right_tool_map_header">
					<?php if($sigParams['usePanel']){ ?>
					<div class="btn-group btn-group-lg dropdown  pull-right" id="btn-tags">
						<button type="button" class="btn btn-map dropdown-toggle" id="btn-panel" data-toggle="dropdown">
							<i class="fa fa-tags"></i>
						</button>
						<ul class="dropdown-menu panel_map pull-right" id="panel_map" role="menu" aria-labelledby="panel_map">
						    <h3 class="title_panel_map"><i class="fa fa-angle-down"></i> <?php echo Yii::t("common", "Filter results by tags"); ?></h3>
							<button class='item_panel_map' id='item_panel_map_all'>
								<i class='fa fa-star'></i> <?php echo Yii::t("common", "All"); ?>
							</button>
						</ul>
					</div>	
				<?php } ?>
				<?php if($sigParams['useFilterType']){ ?>
					<div class="btn-group btn-group-lg dropdown  pull-right" id="btn-filter">
						<button type="button" class="btn btn-map dropdown-toggle" id="btn-filters" data-toggle="dropdown">
							<i class="fa fa-filter"></i>
						</button>
						<ul class="dropdown-menu panel_map" id="panel_filter" role="menu" aria-labelledby="panel_filter">
						    <h3 class="title_panel_map"><i class="fa fa-angle-down"></i> <?php echo Yii::t("common", "Filter results by types"); ?></h3>
							<button class='item_panel_map' id='item_panel_filter_all'>
								<i class='fa fa-star'></i> <?php echo Yii::t("common", "All"); ?>
							</button>
						</ul>
					</div>
				<?php } ?>	
				<span class="right_tool_map_header_title"><?php echo Yii::t("common", "Results"); ?></span>
					<span class="right_tool_map_header_info"> / </span>
					
				</div>
				
				<!-- 	PSEUDO SEARCH -->
				<div id="map_pseudo_filters">
					<input class="form-control date-range active" type="text" id="input_name_filter" placeholder="<?php echo Yii::t("common", "Filter by names"); ?> ...">
				</div>
				<!-- 	PSEUDO SEARCH -->

				<!-- 	LIST ELEMENT -->
				<div id="liste_map_element"></div>

				<label id="lbl-chk-scope">
					<nav>
					  <ul class="pagination pagination-sm" id="pagination"></ul>
					</nav>
				</label>

				<!-- <label id="lbl-chk-scope" class="hidden">
					<input style="" value="" style="margin-left:0px;" type="checkbox" id="chk-scope"> Filtrer dans la zone visible
				</label> -->
			</div>

			<div id="right_tool_map_locality" class="hidden">
			<!-- 	HEADER -->
				<div class="right_tool_map_header">	
					<!-- <span class="right_tool_map_header_title">Ajouter une adresse</span> -->
					<h3 class='margin-top-5 padding-10'>
						<i class='fa fa-home'></i><span id="title-formInMap"><?php echo Yii::t("common", "Address") ; ?></span>
					</h3>
				</div>
				<!-- 	LIST ELEMENT -->
				<div class='form-group inline-block padding-15 form-in-map'>
					<div class='text-dark margin-top-5 hidden-xs'>
						<i class='fa fa-circle'></i> <?php echo Yii::t("common", "Enter an address for automatic placement") ; ?>
					</div>
					<div class='text-dark margin-top-5 hidden-xs'>
						<i class='fa fa-circle'></i> <?php echo Yii::t("common", "Move the icon with the mouse for a more precise placement") ; ?>
					</div>
					<hr class='col-md-12'>
					<select class='form-group col-xs-12' name='newElement_country' id='newElement_country'>
						<?php
							echo "<option value=''>".Yii::t("common", "Choose a country")."</option>";
							// $asort = OpenData::$phCountries;
       //  					asort($asort);
        					$asort = Zone::getListCountry();
							foreach ( $asort as $key => $value) {
								echo "<option value='".$value["countryCode"]."'>".$value["name"]."</option>";
							}
						?>
					</select>
					<div id='divCity' class='hidden dropdown pull-left col-md-12 col-xs-12 no-padding'> 
				  		<input class='form-group col-md-12 col-xs-12' type='text' name='newElement_city' placeholder='<?php echo Yii::t("common", "Search a city, a town or a postal code") ; ?>'>
						<ul class='dropdown-menu col-md-12 col-xs-12' id='dropdown-newElement_locality-found' style="margin-top: -15px; background-color : #ea9d13; max-height : 300px ; overflow-y: auto">
							<li><a href='javascript:' class='disabled'><?php echo Yii::t("common", "Search a city, a town or a postal code") ; ?></a></li>
						</ul>
			  		</div>
			  		<div id='divCP' class='hidden dropdown pull-left col-md-12 col-xs-12 no-padding'> 
				  		<input class='form-group col-md-12 col-xs-12' type='text' name='newElement_cp' placeholder='<?php echo Yii::t("common", "Add a postal code") ; ?>'>
			  		</div>
					<div id='divStreetAddress' class='hidden dropdown pull-left col-md-12 col-xs-12 no-padding'> 
						<input class='form-group col-md-9 col-xs-9' type='text' style='margin-right:-3px;' name='newElement_street' placeholder='<?php echo Yii::t("common", "streetFormInMap"); ?>'>
						<button class='col-md-3 col-xs-3 btn btn-default' style='padding:3px;border-radius:0 4px 4px 0;' type='text' id='newElement_btnSearchAddress'><i class='fa fa-search'></i></button>
					</div>
					<div class='dropdown pull-left col-xs-12 no-padding'> 
				  		<ul class='dropdown-menu' id='dropdown-newElement_streetAddress-found' style="margin-top: -15px; background-color : #ea9d13; max-height : 300px ; overflow-y: auto">
				  			<li><a href='javascript:' class='disabled'><?php echo Yii::t("common", "Currently researching") ; ?></a></li>
				  		</ul>
					</div>
					<div id="alertGeo" class="alert alert-warning col-xs-12 hidden" style='margin-bottom: 0px;'>
					  <strong><?php echo Yii::t("common", "Warning"); ?>!</strong> <?php echo Yii::t("common", "Do not forget to geolocate your address.") ; ?>
					</div>
					<div id='sumery' class='text-dark col-xs-12 no-padding'>
						<h4><?php echo Yii::t("common", "Address Summary"); ?> : </h4>
						<div id='street_sumery' class='col-xs-12'>
							<span><?php echo Yii::t("common", "streetFormInMap"); ?> :</span>
							<span id='street_sumery_value'></span>
						</div>
						<div id='cp_sumery' class='col-xs-12'>
							<span><?php echo Yii::t("common", "Postal code"); ?> :</span>
							<span id='cp_sumery_value'></span>
						</div>
						<div id='city_sumery' class='col-xs-12'>
							<span><?php echo Yii::t("common", "City"); ?> :</span>
							<span id='city_sumery_value'></span>
						</div>
						<div id='country_sumery' class='col-xs-12'>
							<span><?php echo Yii::t("common", "Country"); ?> :</span>
							<span id='country_sumery_value'></span>
						</div>
						<!--
						<div id='insee_sumery' class='col-md-6'>
							<span>Insee :</span>
							<span id='insee_sumery_value'></span>
						</div>
						<div id='dep_sumery' class='col-md-6'>
							<span>Departement :</span>
							<span id='dep_sumery_value'></span>
						</div>
						<div id='region_sumery' class='col-md-6'>
							<span>Région :</span>
							<span id='region_sumery_value'></span>
						</div>
						<div id='lat_sumery' class='col-md-6'>
							<span>Latitude :</span>
							<span id='lat_sumery_value'></span>
						</div>
						<div id='lng_sumery' class='col-md-6'>
							<span>Longitude :</span>
							<span id='lng_sumery_value'></span>
						</div> -->
						<input type='hidden' name='newElement_insee'>
						<input type='hidden' name='newElement_lat'>
						<input type='hidden' name='newElement_lng'>
						<input type='hidden' name='newElement_dep'>
						<input type='hidden' name='newElement_region'>
						<hr class='col-md-12'>
						<button class='col-md-8 btn btn-success pull-right' type='text' id='newElement_btnValidateAddress' disabled='disabled'><i class='fa fa-check'></i> <?php echo Yii::t("common", "ValideFormInMap"); ?></button>
						<button class='col-md-3 btn btn-danger pull-right' type='text' id='newElement_btnCancelAddress' style='margin-right:5px;'><i class='fa fa-times'></i> <?php echo Yii::t("common", "Cancel"); ?></button>
					</div>
				</div>
				<!-- <label id="lbl-chk-scope"> -->
					
				<!-- </label> -->
			</div>

		</div>
		
		<div id="modalItemNotLocated" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title text-dark"><i class="fa fa-map-marker"></i></i> <?php echo Yii::t("common", "This data is not geolocated"); ?></h4>
			      </div>
			      <div class="modal-body"></div>
			      <div class="modal-footer">
			        <button type="button" id="btn-open-details" class="btn btn-default btn-sm btn-success" data-dismiss="modal"><i class="fa fa-plus"></i> <?php echo Yii::t("common", "Show the details"); ?></button>
			      	<button type="button" class="btn btn-default btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo Yii::t("common", "Close"); ?></button>
			      </div>
			    </div>

			  </div>
			</div>
	<?php } ?>


		<div class="btn-group btn-group-lg btn-group-map input-search-place">
		<?php if(false /*désactivé*/ && $sigParams['useResearchTools']){ ?>
			<input type="text" class="pull-left input-search-place-in-map txt-find-place" id="txt-find-place" 
					placeholder="rechercher un lieu, une addresse" style="margin-top:2px;">
			<!-- <button type="button" class="btn btn-map pull-right" id="btn-find-more"><i class="fa fa-ellipsis-h"></i></button> -->
			<button type="button" class="btn btn-map pull-right hidden" id="btn-search"><i class="fa fa-map-marker"></i></button>
				
			<div class="" class="pull-right">
			  	<div class="hidden" id="full-research">
					<input type="text" class="input-search-place-in-map input-2s" 				 id="txt-num-place" 	placeholder="n°" 		style="margin-top:2px;">
					<input type="text" class="input-search-place-in-map input-2s" 				 id="txt-street-place" 	placeholder="rue" 		style="margin-top:2px;"><br/>
					<input type="text" class="input-search-place-in-map input-3s txt-find-place" id="txt-city-place" 	placeholder="ville">
					<input type="text" class="input-search-place-in-map input-3s txt-find-place" id="txt-cp-place" 		placeholder="code postal"><br/>
					<input type="text" class="input-search-place-in-map input-4s txt-find-place" id="txt-state-place" 	placeholder="pays"><br/>
	            </div>
	            <div class="dropdown pull-left" id="dropdown-find-place">
	                 <a href="#" id="btn-dropdown-find-place" data-toggle="dropdown" class="dropdown-toggle"></a>
	                 <ul id="list-dropdown-find-place" class="dropdown-menu" style=" width:100%;" role="menu" aria-labelledby="dropdown-find-place">
	                 	<li style="width:100%;"><a href="#" class="btn-find-place"><i class="fa fa-magic"></i> <?php echo Yii::t("common", "Launch search"); ?> ...</a></li>
	                 </ul>
	            </div>
	        </div>
		<?php } ?>
			<i class="fa fa-refresh fa-spin fa-2x" id="ico_reload"></i>
		</div>
	
		<?php if($sigParams['useChartsMarkers']){ ?>
			<div class="btn-group-vertical btn-group-lg btn-group-charts" id="btn-group-charts-map">
			
			</div>
		<?php } ?>

		<div class="btn-group-map tools-btn">
		
			<?php if(!isset($sigParams['useBtnCloseMap']) || @$sigParams['useBtnCloseMap'] == true ){ ?>
			<div class="btn-group btn-group-lg tooltips"
				 data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common", "Change the map"); ?>">
				<button type="button" class="btn btn-map " id="btn-back" >
				<i class="fa fa-chevron-up"></i></button>
			</div>

			<?php } ?>	
			<?php if(@$sigParams['useSatelliteTiles']){ ?>
				<div class="btn-group btn-group-lg hidden-xs tooltips"
					 data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common", "Change the map"); ?>">
					<button type="button" class="btn btn-map " id="btn-satellite" >
						<i class="fa fa-magic"></i></button>
				</div>
			<?php } ?>	
			<?php if($sigParams['useZoomButton']){ ?>
				<div class="btn-group btn-group-lg">		
					<button type="button" class="btn btn-map tooltips" id="btn-zoom-out" 
							data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common", "Zoom"); ?> -">
					<i class="fa fa-search-minus"></i></button>
					<button type="button" class="btn btn-map tooltips" id="btn-zoom-in" 
							data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common", "Zoom"); ?> +">
					<i class="fa fa-search-plus"></i></button>
				</div>
			<?php } ?>
			<?php if($sigParams['useHomeButton']){ ?>
				<div class="btn-group btn-group-lg tooltips" 
							data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common", "Around me"); ?>">
					<button type="button" class="btn btn-map " id="btn-home">
					<i class="fa fa-bullseye"></i></button>
				</div>
			<?php } ?>			
			
		</div>

		<?php if(!isset($sigParams['useHorizontalAroundMe']) || 
				@$sigParams['useHorizontalAroundMe'] != true ){ ?>
		<div class="btn-group-vertical btn-groupe-around-me-km" role="group" aria-label="...">
		  <button class="btn btn-map" data-km="2000">2 km</button>
		  <button class="btn btn-map" data-km="5000">5 km</button>
		  <button class="btn btn-map" data-km="10000">10 km</button>
		  <button class="btn btn-map" data-km="25000">25 km</button>
		  <button class="btn btn-map" data-km="50000">50 km</button>
		  <button class="btn btn-map bg-azure tooltips" id="btn-share-aroundme" onclick="javascript:Sig.showIframeSig()"
				  data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common", "Around me"); ?>">
		  	<i class="fa fa-share-square-o"></i>
		  </button>
		  <button class="btn btn-map" id="loader-aroundme">
		  </button>
		</div> 
		<?php } ?>

		<div id="mapLegende" class="text-azure hidden-xs">Legende</div>

	<?php if($sigParams['useFullScreen']){ ?>
		<!--<div class="btn-group btn-group-lg btn-group-map btn-full-screen">
			<button type="button" class="btn btn-map " id="btn-full-screen"><i class="fa fa-expand"></i></button>
		</div>-->
	<?php } ?>

    <?php if($sigParams['useHelpCoordinates']){ ?>
		<div id="help-coordinates">0,000</div>
	<?php } ?>
</div>
