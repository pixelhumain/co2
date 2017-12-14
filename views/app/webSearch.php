


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
	<?php echo @$search ? " <small class='letter-blue'> <i class='fa fa-search'></i> ".$search."</small><br>" : "<br>"; ?>
</h3>	
<h3 style="margin:0 0 20px 0;">
	<div class="margin-top-5">
		<i class="fa fa-angle-down"></i> 
		<?php echo sizeof($siteurls) > 0 ? sizeof($siteurls) : "aucun"; ?> 
		résultat<?php echo sizeof($siteurls) > 1 ? "s" : ""; ?> 
	</div>
</h3>



<div class="col-md-10 margin-bottom-15" style="">
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
				<?php echo $siteurl["title"]; ?>
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

		<span class="siteurl_desc letter-grey hidden">
			<?php if(Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ) { ?>
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
			<?php } ?>
		</span>
		<br>
	</div>
<?php } ?>
</div>

<?php //if(sizeof($siteurls) < 3){ 

	$searchG = str_replace(" ", "+", $search);
?>
<div class="col-md-12 margin-bottom-50" style="margin-top:0px;">
	<hr>
	<h5 class="text-right">
		<a href="https://www.ecosia.org/search?q=<?php echo $searchG; ?>" target="_blank">
			<i class="fa fa-fw fa-angle-right"></i> continuer la recherche sur <span class="visible-xs"><br></span>
	    	<img style="margin-top:-10px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ecosia_logo.png" height=60>
    	</a>
	</h5>
	<hr>
	<h5 class="text-right">
		<a href="https://www.google.com/search?q=<?php echo $searchG; ?>" target="_blank">
			<i class="fa fa-fw fa-angle-right"></i> continuer la recherche sur  <span class="visible-xs"><br></span>
	    	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/google.png" height=25>
    	</a>
	</h5>
</div>
<?php //} ?>



<?php if(sizeof($siteurls) >= 0){ ?>
<div class="col-md-12 margin-bottom-50 text-right" style="">
	<hr class="margin-top-5">
	<span>
		<small><b>
		Vous connaissez un site qui n'est pas référencé ici ?<br> 
		Ajoutez le <span class="letter-green">gratuitement</span> dans la base de données, et faites-en profiter tout le monde !
		</b></small>
	</span><br><br>
	<b>Référencer un site <i class="fa fa-angle-right"></i></b> 
	<a class="btn btn-default btn-success margin-bottom-5 lbh" href="#referencement">
		<i class="fa fa-plus-circle"></i> Ajouter une URL
	</a> 
</div>
<?php } ?>
<script type="text/javascript" >
  
var siteurls = <?php echo json_encode($siteurls) ? json_encode($siteurls) : "{}"; ?>;
var search = "<?php echo $search; ?>";

jQuery(document).ready(function() { 

    Sig.showMapElements(Sig.map, siteurls);
	
   		
   $(".siteurl_title").click(function(){
   		var url = $(this).attr("href");
   		incNbClick(url);
   });

   $(".btn-edit-url").click(function(){ console.log("siteurls", siteurls);
   		var id = $(this).data("idurl");
   		var site = siteurls[id];
   		$("#form-idurl").val(site["_id"]['$id']);
	    $("#form-url").val(site.url);
	    $("#form-title").val(site.title);
	    $("#form-description").val(site.description);

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
	    }else{
	    	$("#form-street, #btn-find-position").hide();
    		$("#name-city-selected").html("");
	    }

	    $("#form-status").val(site.status);

	    $(".portfolio-item").removeClass("selected");
	    categoriesSelected = new Array();
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


   $(".tooltips").tooltip();

   bindLBHLinks();

   initKeywords();

});

</script>