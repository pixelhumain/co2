
<style>
	#resUrl .el-nowList,
	#resUrl .el-nowList:hover{
		width:48%;
		margin-right:2%;
		float:left;
	}

	#resUrl .el-nowList:hover{
		background-color: #f6f6f6;
	}

	#resUrl .titleDirMin{
		display: none;
	}
</style>

<hr>
<button class="btn btn-default menu-btn-back-category btn-second margin-bottom-5 margin-top-5" id="btn-new-search">
	<i class="fa fa-undo"></i> Nouvelle recherche
</button>

<hr>
<?php if($category == "Météo"){ ?>
	<iframe class="col-sm-12 col-md-12 col-xs-12 margin-bottom-20" style="padding:0 15px 0 0;border-radius: 5px;" height="450" 
			src="https://embed.windytv.com/embed2.html?lat=-20.180&lon=165.630&zoom=6&level=surface&overlay=rain&menu=&message=&marker=&forecast=12&calendar=now&location=coordinates&type=map&actualGrid=&metricWind=kt&metricTemp=%C2%B0C"
			frameborder="0">
	</iframe> 

	<div class="col-sm-12 col-md-12 col-xs-12 no-padding">
		<hr>
	</div>
<?php } ?>

<h3 id="titleWebSearch"  style="margin:20px 0 0 4px;">
	<?php echo @$category ? " <small class='letter-blue'><i class='fa' id='fa-category'></i> ".$category."</small>" : ""; ?>
	<?php echo @$search ? " <small class='letter-blue mysearch'> <i class='fa fa-search'></i> ".$search."</small><br>" : "<br>"; ?>
</h3>	
<h4 style="margin:0 0 20px 0;">
	<div class="margin-top-5">
		<i class="fa fa-angle-down"></i> 
		<?php echo sizeof($siteurls) > 0 ? sizeof($siteurls) : ""; ?> 
		<?php if(sizeof($siteurls) == 0) echo sizeof($elements) > 0 ? sizeof($elements) : "aucun"; ?> 
		résultat<?php echo sizeof($siteurls) > 1 ? "s" : ""; ?> 
		<?php if(sizeof($siteurls) == 0){ ?> 
			<small>sur kgougle</small>
		<?php } ?>
	</div>
</h4>



<div class="col-xs-12 margin-bottom-15" id="resUrl">
<?php  foreach ($siteurls as $key => $siteurl) { ?>

	<?php 
		//bold keywords found
		$siteurl["urlDisplay"] = $siteurl["url"];
		
		if(isset($siteurl["wordsFound"]))
		foreach ($siteurl["wordsFound"] as $key2 => $regexWF) { 
			if($regexWF!=""){
				$regexWFR = Search::accentToRegex($regexWF);
				$siteurl["urlDisplay"] = 	preg_replace("/(*UTF8)".$regexWFR."/" , "<b>$0</b>", @$siteurl["urlDisplay"]);
				$siteurl["title"] = 		preg_replace("/(*UTF8)".$regexWFR."/i", "<b>$0</b>", @$siteurl["title"]);
				$siteurl["description"] = 	preg_replace("/(*UTF8)".$regexWFR."/i", "<b>$0</b>", @$siteurl["description"]);
			}
		}


		if(isset($arraySearch))
		foreach ($arraySearch as $key2 => $regexWF) {  
			if($regexWF!=""){
				$regexWFR = Search::accentToRegex($regexWF);
				$siteurl["urlDisplay"] = 	preg_replace("/(*UTF8)".$regexWFR."/" , "<b>$0</b>", @$siteurl["urlDisplay"]);
				$siteurl["title"] = 		preg_replace("/(*UTF8)".$regexWFR."/i", "<b>$0</b>", @$siteurl["title"]);
				$siteurl["description"] = 	preg_replace("/(*UTF8)".$regexWFR."/i", "<b>$0</b>", @$siteurl["description"]);
			}
		}
	?>

	<div class="col-md-12 margin-bottom-15 url-<?php echo $siteurl['_id']; ?> url-div">

		<div class="addToFavInfo">
			<a href="#web" class="btn-favory tooltips" data-idFav="<?php echo $siteurl['_id']; ?>" 
					data-placement="top" data-toggle="tooltip" title="Garder en favoris">
				<i class="fa fa-star-o"></i><i class="fa fa-star letter-yellow"></i>
			</a>

			<a class="siteurl_title letter-blue" target="_blank" href="<?php echo $siteurl["url"]; ?>">
				<?php if(@$siteurl["favicon"]){ ?>
					<img src='<?php echo $siteurl["favicon"]; ?>' height=17 class="margin-right-5" style="margin-top:-3px;" alt="">
				<?php } ?> 
				<?php echo @$siteurl["title"]; ?>
			</a>
			<button class="btn btn-xs bg-white btn-edit-url tooltips hidden-xs" title="modifier"
					data-target="#modalEditUrl" data-toggle="modal" data-placement="right"
					data-idurl="<?php echo $key; ?>">
				<i class="fa fa-cog"></i>
			</button>
			<br>
			<a href="<?php echo $siteurl["url"]; ?>" target="_blank" class="siteurl_hostname letter-green">
				<?php echo @$siteurl["urlDisplay"]; ?>
			</a><br>
		</div>

		<?php if(@$siteurl["description"]){ ?>
		<span class="siteurl_desc letter-grey"><?php echo @$siteurl["description"]; ?></span><br>
		<?php } ?>

		
		<?php if(Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ) { ?>
		<span class="siteurl_desc letter-grey">
				<b>
					<?php if(!empty($siteurl["categories"])) foreach ($siteurl["categories"] as $key2 => $category) { ?>
					$<?php echo $category; ?>  
					<?php } ?>
				</b> 
				<b>
					<?php if(!empty($siteurl["tags"])) foreach ($siteurl["tags"] as $key2 => $tag) { ?>
						#<?php echo $tag; ?> 
					<?php } ?>
				</b>
		</span>
		<?php if(!empty($siteurl["categories"]) || !empty($siteurl["tags"])){ echo "<br>"; } ?>
		<?php } ?>

		<?php if(@$siteurl["status"]=="locked" && Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ){ ?>
			<button class="btn btn-success btn-xs btn-change-status" 
					data-status="validated" data-idurl="<?php echo $siteurl["_id"]; ?>">
				Valider
			</button><br><br>
		<?php } ?>
	</div>
<?php } ?>

</div>


<div class="hidden" id="directoryMin">	
	<?php $this->renderPartial('../default/directoryMin', 
			array("result"=>$elements, 
				  "title"=>"Pages <span class='letter-blue'>K</span>".
				  				 "<span class='letter-yellow'>GOU</span>".
				  				 "<span class='letter-green'>GLE</span>",
				  //"target"=>"blank"
				  )); ?>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 moreResult">	
	<hr>
	<h6 style="margin-top: 32px; margin-bottom: 32px;">
		<i class="fa fa-angle-down"></i> Résultats <span class="hidden-xs">complémentaires</span>
	</h6>


	<ul class="nav nav-tabs">
	  <li class="active">
	  	<a data-toggle="tab" href="#resLilo">
	  		<img style="margin-bottom:5px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/lilo-logo.svg" height=25>
	  	</a>
	  </li>
	  <li>
		  <a data-toggle="tab" href="#resEcosia">
		  	<img style="margin-top:-10px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ecosia_logo.png" height=40>
		  </a>
	  </li>
	</ul>

	<div class="tab-content">
	  <div id="resLilo" class="tab-pane fade in active">
	  	<?php if(sizeof($siteurls) >= 4){ ?>
	  		<button class="btn btn-success" id="btn-start-lilo"><i class="fa fa-search"></i> Lancer une recherche complémentaire</button>
	  	<?php } ?>
	  </div>
	  <div id="resEcosia" class="tab-pane fade">
	  	<?php if(sizeof($siteurls) >= 4){ ?>
	  		<button class="btn btn-success" id="btn-start-ecosia"><i class="fa fa-search"></i> Lancer une recherche complémentaire</button>
	  	<?php } ?>
	  	
	  </div>
	</div>
</div>


<?php if(sizeof($siteurls) >= 0){ ?>
<div class="col-xs-12 margin-bottom-50 text-right footerWebSearch" style="margin-top:30px;">
	<hr class="margin-top-5">
	<span>
		<small><b>
		Vous connaissez un site qui n'est pas référencé sur kgougle ?<br> 
		Ajoutez le <span class="letter-green">gratuitement</span> dans la base de données, et faites-en profiter tout le monde !
		</b></small>
	</span><br><br>
	<b>Référencer un site <i class="fa fa-angle-right"></i></b> 
	<a class="btn btn-default btn-success margin-bottom-5 lbh" href="#referencement">
		<i class="fa fa-plus-circle"></i> Ajouter une URL
	</a> 
</div>
<?php } ?>

<?php  foreach ($siteurls as $key => $siteurl) { $siteurls[$key]["wordsFound"] = ""; } ?>

<script type="text/javascript" >
  
var siteurls = <?php echo json_encode($siteurls) ; ?>;
var nbUrl = <?php echo sizeof($siteurls); ?>;

var elements = <?php echo json_encode($elements) ; ?>;
var nbElement = <?php echo sizeof($elements); ?>;

console.log("elements found", elements);

var search = "<?php echo $search; ?>";
var siteEditing = false;

jQuery(document).ready(function() { 
	console.log("website on map", siteurls);
    Sig.showMapElements(Sig.map, siteurls);
	
	var elementDir = directory.showResultsDirectoryHtml(elements);


    $("#sub-menu-right").html("");
	if(nbElement > 0 && nbUrl > 0){
   		$("#sub-menu-right").html($("#directoryMin").html());
	}
    else if(nbElement > 0 && nbUrl == 0){
    	$("#resUrl").html($("#directoryMin").html());
    }
    
    $("#directoryMin").html("");

    $(".siteurl_title").click(function(){
   		var url = $(this).attr("href");
   		incNbClick(url);
    });

    $(".btn-edit-url").click(function(){ console.log("siteurls", siteurls);
   		var id = $(this).data("idurl");
   		var site = siteurls[id];
   		siteEditing = site;
   		$("#form-idurl").val(site["_id"]['$id']);
	    $("#form-url").val(site.url);
	    $("#form-title").val(site.title);
	    $("#form-description").val(site.description);
		$("#form-street").val(site.address.streetAddress);
    
	    if(typeof site.geo != "undefined"){
	    	$("#form-lat").val(site.geo.latitude);
		    $("#form-lng").val(site.geo.longitude);
		}
	    if(typeof site.tags != "undefined"){
		    $("#form-keywords1").val(site.tags[0]);
		    $("#form-keywords2").val(site.tags[1]);
		    $("#form-keywords3").val(site.tags[2]);
		    $("#form-keywords4").val(site.tags[3]);
		}

		if(typeof site.address != "undefined"){
		    $("#btn-geoloc").data("city-name", site.address.addressLocality);
	        $("#btn-geoloc").data("city-cp", site.address.postalCode);
	        $("#btn-geoloc").data("city-insee", site.address.codeInsee);
	        $("#btn-geoloc").data("city-lat", site.geo.latitude);
	        $("#btn-geoloc").data("city-lng", site.geo.longitude);
	        NE_localityId = site.address.localityId;
	        NE_insee = site.address.codeInsee;
			NE_lat = site.geo.latitude;
			NE_lng = site.geo.longitude;
			NE_city = site.address.addressLocality;
			NE_cp = site.address.postalCode;
			NE_street = site.address.streetAddress.trim();
			NE_country = site.address.addressCountry;
			NE_level1 = site.address.level1;
			NE_region = site.address.regionName;
	        $("#name-city-selected").html(site.address.addressLocality + ", " + site.address.postalCode);

	        coordinatesPreLoadedFormMap = [NE_lat, NE_lng];
	        formInMap.formType = "url";

	        if(site.address.streetAddress != "")
	        	$("#form-street, #btn-find-position").show();         
	        
	        $("#btn-find-position").off().click(function(){ noShowAjaxModal = true;
	            showMap(true);
	    		
	            var street = $("#form-street").val();
	            formInMap.showMarkerNewElement();
	        	preLoadAddress(true, NE_localityId, "NC", NE_insee, NE_city, NE_cp, NE_lat, NE_lng, street);
	            
	            if(street != ""){
	                formInMap.searchAdressNewElement();
	            }
	        });

	    }else{
	    	$("#form-street, #btn-find-position").hide();
    		$("#name-city-selected").html("");
	    }

	    $("#form-status").val(site.status);

	    $(".portfolio-item").removeClass("selected");
	    categoriesSelected = new Array();

	    if(typeof site.categories != "undefined")
	    $.each(site.categories, function(key, val){
	    	$(".portfolio-item.cat-"+val).addClass("selected");
	    	console.log("cat", val);
	    	categoriesSelected.push(val);
	    });
	    //categoriesSelected = site.categories;

	    $("#sectionSearchResults").show();
   });

   $(".menu-btn-back-category").off().click(function(){
        $("#mainCategories").show();
        $("#searchResults").html("");
        $("#sectionSearchResults").addClass("hidden");
        $("#main-search-bar").val("");
        $("#second-search-bar").val("");
        $("#input-search-map").val("");
        KScrollTo("#mainCategories");
        currentCategory = ""
    });
   
   $("#searchResults .btn-favory").click(function(){
   		var id = $(this).data("idfav");
   		addToFavorites(id);
   });

   $(".btn-change-status").click(function(){
   		var status = $(this).data("status");
   		var urlId = $(this).data("idurl");
   		if(typeof changeStatus != "undefined")
   			changeStatus(urlId, status)
   });

   if(nbUrl <= 3 && typeof isWebAdmin == "undefined") {
   	if(search == "") search = currentCategory;
   	console.log("web search", search);
   	searchLilo(search);
   	searchEcosia(search);
   }

   $("#btn-start-lilo, #btn-start-ecosia").click(function(){
   	if(search == "") search = currentCategory;
   	console.log("web search", search);
   	searchLilo(search);
   	searchEcosia(search);
   });


   $(".tooltips").tooltip();

   bindLBHLinks();

   initKeywords();

});

</script>