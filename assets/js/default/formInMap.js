var formInMap = {
	timeoutAddCity : null,
	NE_insee : "",
	NE_lat : "",
	NE_lng : "",
	NE_city : "",
	NE_cp : "",
	NE_street : "",

	NE_country : "",
	NE_dep : "",
	NE_region : "",

	PC_postalCode : "",
	PC_name : "",
	PC_latitude : "",
	PC_longitude : "",

	typeSearchInternational : "",
	formType : "",
	updateLocality : false,
	addressesIndex : false,
	saveCities : new Array(),
	uncomplete : false,

	modePostalCode : false,


	showMarkerNewElement : function(modePC){
		mylog.log("showMarkerNewElement");
		Sig.clearMap();

		if(typeof Sig.myMarker != "undefined") 
			Sig.map.removeLayer(Sig.myMarker);

		mylog.log("formType", formInMap.formType);
		var options = {  id : 0,
						 icon : Sig.getIcoMarkerMap({'type' : formInMap.formType}),
						 content : Sig.getPopupInfoAddress()
					  };
		mylog.log(options);

		if( notNull(currentUser) && notNull(currentUser.addressCountry) && formInMap.NE_country== "" ){
			formInMap.NE_country = currentUser.addressCountry;
			mylog.log("NE_country", formInMap.NE_country);
		}


		var coordinates = new Array(0, 0);
		if( notNull(contextData) && notNull(contextData.geo) && formInMap.updateLocality == true)
			coordinates = new Array(contextData.geo.latitude, contextData.geo.longitude);
		
		mylog.log("coordinates", coordinates);

		//efface le marker s'il existe
		if(Sig.markerFindPlace != null) 
			Sig.map.removeLayer(Sig.markerFindPlace);
		Sig.markerFindPlace = Sig.getMarkerSingle(Sig.map, options, coordinates);
		Sig.markerFindPlace.openPopup(); 
		Sig.markerFindPlace.dragging.enable();
		Sig.centerPopupMarker(coordinates, 12);

		$('[name="newElement_country"]').val(formInMap.NE_country);

		if(formInMap.NE_country != ""){
			$("#divPostalCode").removeClass("hidden");
			$("#divCity").removeClass("hidden");
		}

		if(formInMap.updateLocality == true){
			/*$('[name="newElement_insee"]').val(formInMap.NE_insee);
			$('[name="newElement_lat"]').val(formInMap.NE_lat);
			$('[name="newElement_lng"]').val(formInMap.NE_lng);
			$('[name="newElement_city"]').val(formInMap.NE_city);
			$('[name="newElement_cp"]').val(formInMap.NE_cp);
			$('[name="newElement_streetAddress"]').val(formInMap.NE_street.trim());
			$('[name="newElement_dep"]').val(formInMap.NE_dep);
			$('[name="newElement_region"]').val(formInMap.NE_region);*/
			formInMap.initHtml();
			$("#newElement_btnValidateAddress").prop('disabled', (formInMap.NE_insee==""?true:false));
			if(formInMap.NE_insee != ""){
				$("#divStreetAddress").removeClass("hidden");
			}
		}

		Sig.markerFindPlace.on('dragend', function(){
			NE_lat = Sig.markerFindPlace.getLatLng().lat;
			NE_lng = Sig.markerFindPlace.getLatLng().lng;
			Sig.markerFindPlace.openPopup();
		});

		formInMap.bindFormInMap();

		$("#right_tool_map_locality").removeClass("hidden");
		$("#right_tool_map_search").addClass("hidden");


	},

	initUpdateLocality : function(address, geo, type, index){
		mylog.log("initUpdateLocality", address, geo, type, index);
		if(address != null && geo != null ){
			formInMap.NE_insee = address.codeInsee;
			formInMap.NE_lat = geo.latitude;
			formInMap.NE_lng = geo.longitude;
			formInMap.NE_city = address.addressLocality;
			formInMap.NE_cp = address.postalCode;
			formInMap.NE_street = address.streetAddress.trim();
			formInMap.NE_country = address.addressCountry;
			formInMap.NE_dep = address.depName;
			formInMap.NE_region = address.regionName;
			if(index)
				formInMap.addressesIndex = index ;
			formInMap.initDropdown();
			formInMap.getDepAndRegion();
		}else{
			formInMap.initVarNE();
			if(index)
				formInMap.addressesIndex = index ;
		}
		formInMap.formType = type ;
		formInMap.updateLocality = true;
		if(typeof contextMap == "undefined")
			contextMap = [];
		formInMap.showMarkerNewElement();
	},

	bindFormInMap : function(){
		// ---------------- newElement_country
		$('[name="newElement_country"]').change(function(){
			mylog.log("change country");
			formInMap.NE_country = $('[name="newElement_country"]').val() ;
			formInMap.NE_insee = "";
			formInMap.NE_lat = "";
			formInMap.NE_lng = "";
			formInMap.NE_city = "";
			formInMap.NE_cp = "";
			formInMap.NE_street = "";
			/*$('[name="newElement_insee"]').val(formInMap.NE_insee);
			$('[name="newElement_city"]').val(formInMap.NE_city);
			$('[name="newElement_cp"]').val(formInMap.NE_cp);
			$('[name="newElement_streetAddress"]').val(formInMap.NE_street);
			$('[name="newElement_dep"]').val(formInMap.NE_dep);
			$('[name="newElement_region"]').val(formInMap.NE_region);*/

			formInMap.initHtml();

			$("#newElement_btnValidateAddress").prop('disabled', true);
			$("#divStreetAddress").addClass("hidden");
			formInMap.initDropdown();
			mylog.log("formInMap.NE_country", formInMap.NE_country, typeof formInMap.NE_country, formInMap.NE_country.length);
			if(formInMap.NE_country != ""){
				$("#divPostalCode").removeClass("hidden");
				$("#divCity").removeClass("hidden");
			}else{
				$("#divPostalCode").addClass("hidden");
				$("#divCity").addClass("hidden");
			}
				
		});

		// ---------------- newElement_city
		$('[name="newElement_city"]').keyup(function(){ 
			$("#dropdown-city-found").show();
			if($('[name="newElement_city"]').val().length > 0){
				formInMap.NE_city = $('[name="newElement_city"]').val();
				formInMap.changeSelectCountrytim();
				if(notNull(formInMap.timeoutAddCity)) 
					clearTimeout(formInMap.timeoutAddCity);
				formInMap.timeoutAddCity = setTimeout(function(){ 
					formInMap.autocompleteFormAddress("locality", $('[name="newElement_city"]').val()); 
				}, 500);
			}
		});

		$('[name="newElement_city"]').focusout(function(){
			if(notNull(formInMap.timeoutAddCity)) 
				clearTimeout(formInMap.timeoutAddCity);
			if( $('[name="dropdown-newElement_city-found"]').length )
				formInMap.timeoutAddCity = setTimeout(function(){ $("#dropdown-newElement_city-found").hide(); }, 200);
			if( $('[name="dropdown-newElement_locality-found"]').length )
				formInMap.timeoutAddCity = setTimeout(function(){ $("#dropdown-newElement_locality-found").hide(); }, 200);
		});

		$('[name="newElement_city"]').focus(function(){
			$(".dropdown-menu").hide();
			
			
			if( $('[name="newElement_city"]').length ){
				$("#dropdown-newElement_city-found").show();
				if($('[name="newElement_city"]').val().length > 0){
					formInMap.autocompleteFormAddress("locality", $('[name="newElement_city"]').val());
				}
			}

			if( $('[name="dropdown-newElement_locality-found"]').length ){
				$("#dropdown-newElement_locality-found").show();
				if($('[name="newElement_city"]').val().length > 0){
					formInMap.autocompleteFormAddress("locality", $('[name="newElement_city"]').val());
				}
			}
		});

		// ---------------- newElement_streetAddress
		$('[name="newElement_streetAddress"]').focus(function(){
			$("#dropdown-newElement_streetAddress-found").show();
		});

		$("#newElement_btnSearchAddress").click(function(){
			$(".dropdown-menu").hide();
			searchAdressNewElement();
		});

		$('[name="newElement_streetAddress"]').keyup(function(){ 
			$("#dropdown-newElement_streetAddress-found").show();
			if(notNull(formInMap.timeoutAddCity)) 
					clearTimeout(formInMap.timeoutAddCity);
			formInMap.timeoutAddCity = setTimeout(function(){ 
				formInMap.searchAdressNewElement(); 
			}, 2000);
			
		});


		$("#newElement_btnValidateAddress").click(function(){
			/*if(notEmpty(formInMap.saveCities[formInMap.NE_insee])){
				var obj = { city : formInMap.saveCities[formInMap.NE_insee] }
				obj.city.geoShape = 1;
				if(uncomplete == true){
					var postalCode = {};
					
					postalCode.name = obj.city.name;
					postalCode.postalCode = formInMap.NE_cp;
					postalCode.geo = obj.city.geo;
					postalCode.geoPosition = obj.city.geoPosition;

					mylog.log("saveCities", typeof obj.city.postalCodes, obj.city.postalCodes);

					obj.city.postalCodes.push(postalCode);
				}
				
				$.ajax({
			        type: "POST",
			        url: baseUrl+"/"+moduleId+"/city/save",
			        data: obj,
			       	dataType: "json",
			    	success: function(data){
			    		console.dir(obj.city);
			    		mylog.log("data", data);
			    		if(data.result)
			    			formInMap.backToForm();
			    	},
					error: function(error){
						mylog.log("error", error);
			    		$("#dropdown-newElement_"+currentScopeType+"-found").html("error");
						mylog.log("Une erreur est survenue pendant l'enregistrement de la commune");
					}
				});
			}else*/
				formInMap.backToForm();
		});

		$("#newElement_btnCancelAddress").click(function(){
			/*$('[name="newElement_insee"]').val("");
			$('[name="newElement_lat"]').val("");
			$('[name="newElement_lng"]').val("");
			$('[name="newElement_city"]').val("");
			$('[name="newElement_cp"]').val("");
			$('[name="newElement_dep"]').val("");
			$('[name="newElement_region"]').val("");
			formInMap.NE_insee = ""; 
			formInMap.NE_lat =  ""; 
			formInMap.NE_lng =""; 
			formInMap.NE_city = ""; formInMap.NE_cp = "";*/
			formInMap.initVarNE();
			formInMap.initHtml();
			formInMap.backToForm(true);
		});

		/*$('[name="newElement_cp"]').keyup(function(){
			mylog.log("uncomplete",uncomplete);
			if(uncomplete == false){
				$("#dropdown-cp-found").show();
				mylog.log("newElement_cp",$('[name="newElement_cp"]').val().length);
				if($('[name="newElement_cp"]').val().length > 0){
					mylog.log("newElement_cp",$('[name="newElement_cp"]').val().length);
					formInMap.NE_cp = $('[name="newElement_cp"]').val();
					changeSelectCountrytim();
					if(notNull(formInMap.timeoutAddCity)) clearTimeout(formInMap.timeoutAddCity);
					formInMap.timeoutAddCity = setTimeout(function(){ autocompleteFormAddress("cp", $('[name="newElement_cp"]').val()); }, 500);
				}
			}else{
				if($('[name="newElement_cp"]').val().length > 3){
					formInMap.NE_cp = $('[name="newElement_cp"]').val();
					$("#newElement_btnValidateAddress").prop('disabled', false);
					$('#divPostalCode').addClass("has-success");
					$('#divPostalCode').removeClass("has-error");
				}else{
					$("#newElement_btnValidateAddress").prop('disabled', true);
					$('#divPostalCode').addClass("has-error");
					$('#divPostalCode').removeClass("has-success");
				}
			}
			
		});*/

		/*$('[name="newElement_streetAddress"]').keyup(function(){ 
			$("#dropdown-cp-found").show();
			formInMap.NE_street = $('[name="newElement_streetAddress"]').val().trim();
		});

		$('[name="newElement_cp"]').focusout(function(){
			if(notNull(formInMap.timeoutAddCity)) clearTimeout(formInMap.timeoutAddCity);
			formInMap.timeoutAddCity = setTimeout(function(){ $("#dropdown-newElement_cp-found").hide(); }, 200);
		});*/


		/*$('[name="newElement_cp"]').focus(function(){
			if(uncomplete == false){
				$(".dropdown-menu").hide();
				$("#dropdown-newElement_cp-found").show();
				if($('[name="newElement_cp"]').val().length > 0){
					autocompleteFormAddress("cp", $('[name="newElement_cp"]').val());
				}
			}
		});*/
		

		
		
		/*var allCountries = getCountries("select2");
		$.each(allCountries, function(key, country){
			mylog.log(country.id, country.text);
		 	$('[name="newElement_country"]').append("<option value='"+country.id+"'>"+country.text+"</option>");
		});*/

		

		/*$("#info_insee_latlng").html(
			"<span class='pull-left'><b>Insee : </b>" + formInMap.NE_insee + "</span> " +
			"<span class='pull-right'><b>lat : </b>" + formInMap.NE_lat + " <b>lng : </b>" + formInMap.NE_lng + "</span> "
		);*/
		//formInMap.updateSummeryLocality();

		/**/

		/* TODO TIB */
		/*


		$('[name="newPC_postalCode"]').keyup(function(){
			if($('[name="newPC_postalCode"]').val().length > 3){
				PC_postalCode = $('[name="newElement_cp"]').val();
				checkDataPostalCode();
				$('#divPostalCode').addClass("has-success");
				$('#divPostalCode').removeClass("has-error");
			}else{
				PC_postalCode = "";
				checkDataPostalCode();
				$('#divPostalCode').addClass("has-error");
				$('#divPostalCode').removeClass("has-success");
			}
		});

		$('[name="newPC_name"]').keyup(function(){
			mylog.log("uncomplete",uncomplete);
			if($('[name="newPC_name"]').val().length > 2){
				PC_name = $('[name="newPC_name"]').val();
				checkDataPostalCode();
				$('#divCity').addClass("has-success");
				$('#divCity').removeClass("has-error");
			}else{
				PC_name = "";
				checkDataPostalCode();
				$('#divCity').addClass("has-error");
				$('#divCity').removeClass("has-success");
			}
		});

		$('[name="newPC_lat"]').keyup(function(){
			if(parseFloat($('[name="newPC_lat"]').val()) > -90 && parseFloat($('[name="newPC_lat"]').val()) < 90){
				// -180 and +180 
				PC_latitude = $('[name="newPC_lat"]').val();
				checkDataPostalCode();
				$('#divCity').addClass("has-success");
				$('#divCity').removeClass("has-error");
			}else{
				PC_latitude = "";
				checkDataPostalCode();
				$('#divCity').addClass("has-error");
				$('#divCity').removeClass("has-success");
			}
		});

		$('[name="newPC_lon"]').keyup(function(){
			if(parseFloat($('[name="newPC_lon"]').val()) > -180 && parseFloat($('[name="newPC_lon"]').val()) < 180){
				PC_longitude = $('[name="newPC_lon"]').val();
				checkDataPostalCode();
				$('#divCity').addClass("has-success");
				$('#divCity').removeClass("has-error");
			}else{
				PC_longitude = "";
				checkDataPostalCode();
				$('#divCity').addClass("has-error");
				$('#divCity').removeClass("has-success");
			}
		});

		$("#newPC_btnValidatePC").click(function(){
			PC_postalCode : $("[name='newPC_postalCode']").val();
			PC_name = $("[name='newPC_name']").val();
			PC_latitude = $("[name='newPC_lat']").val();
			PC_longitude = $("[name='newPC_lng']").val();
			formInMap.backToForm();
			$('#divCity').append("<a href=");
		});*/
	},


	autocompleteFormAddress : function(currentScopeType, scopeValue){
		mylog.log("autocompleteFormAddress", currentScopeType, scopeValue);
		$("#dropdown-newElement_"+currentScopeType+"-found").html("<li><a href='javascript:'><i class='fa fa-refresh fa-spin'></i></a></li>");
		$("#dropdown-newElement_"+currentScopeType+"-found").show();
		$.ajax({
	        type: "POST",
	        url: baseUrl+"/"+moduleId+"/city/autocompletemultiscope",
	        data: {
	        		type: currentScopeType, 
	        		scopeValue: scopeValue,
	        		geoShape: true,
	        		countryCode : $('[name="newElement_country"]').val()
	        },
	       	dataType: "json",
	    	success: function(data){

	    		mylog.log("autocompleteFormAddress success", data);
	    		html="";
	    		var allCP = new Array();
	    		var allCities = new Array();
	    		var inseeGeoSHapes = new Array();
	    		formInMap.saveCities = new Array();
	    		$.each(data.cities, function(key, value){
	    			var insee = value.insee;
	    			var country = value.country;
	    			var dep = value.depName;
	    			var region = value.regionName;
	    			if(notEmpty(value.save))
	    				formInMap.saveCities[insee] = value;

	    			if(notEmpty(value.geoShape))
				    	inseeGeoSHapes[insee] = value.geoShape.coordinates[0];

	    			if(currentScopeType == "city" || currentScopeType == "locality") { mylog.log("in scope city"); mylog.dir(value);
	    				if(value.postalCodes.length > 0){
	    					$.each(value.postalCodes, function(key, valueCP){
			    				var val = valueCP.name; 
			    				var lbl = valueCP.postalCode ;
			    				var lat = valueCP.geo.latitude;
			    				var lng = valueCP.geo.longitude;
			    				var lblList = value.name + ", " + valueCP.name + ", " + valueCP.postalCode ;
			    				html += "<li><a href='javascript:' data-type='"+currentScopeType+"' data-dep='"+dep+"' data-region='"+region+"' data-country='"+country+"' data-city='"+val+"' data-cp='"+lbl+"' data-lat='"+lat+"' data-lng='"+lng+"' data-insee='"+insee+"' class='item-city-found'>"+lblList+"</a></li>";
			    			});
	    				}else{
	    					var val = value.name; 
		    				var lat = value.geo.latitude;
		    				var lng = value.geo.longitude;
			    				var lblList = value.name ;
	    					html += "<li><a href='javascript:' data-type='"+currentScopeType+"' data-dep='"+dep+"' data-region='"+region+"' data-country='"+country+"' data-city='"+val+"' data-lat='"+lat+"' data-lng='"+lng+"' data-insee='"+insee+"' class='item-city-found-uncomplete'>"+lblList+"</a></li>";
						}
	    				
	    			}; 
	    			/*if(currentScopeType == "cp") { 
	    				$.each(value.postalCodes, function(key, valueCP){ mylog.log(allCities);
	    					if($.inArray(valueCP.name, allCities)<0){ 
		    					allCities.push(valueCP.name);
			    				var val = valueCP.postalCode; 
			    				var lbl = valueCP.name ;
			    				var lblList = valueCP.name + ", " +valueCP.postalCode ;
			    				var lat = valueCP.geo.latitude;
			    				var lng = valueCP.geo.longitude;
			    				//mylog.log("valueCPvalueCPvalueCPvalueCP", valueCP);
			    				html += "<li><a href='javascript:' data-type='"+currentScopeType+"' data-dep='"+dep+"' data-region='"+region+"' data-country='"+country+"' data-city='"+lbl+"' data-cp='"+val+"' data-lat='"+lat+"' data-lng='"+lng+"' data-insee='"+insee+"' class='item-cp-found'>"+lblList+"</a></li>";
	    				}});
	    			};*/
	    		});

	    		if(html == "") html = "<i class='fa fa-ban'></i> Aucun résultat";
	    		$("#dropdown-newElement_"+currentScopeType+"-found").html(html);
	    		$("#dropdown-newElement_"+currentScopeType+"-found").show();

	    		$(".item-city-found, .item-cp-found").click(function(){
	    			formInMap.add(true, $(this), inseeGeoSHapes);
	    		});

	    		$(".item-city-found-uncomplete").click(function(){

	    			formInMap.add(false, $(this), inseeGeoSHapes);
	    		});
		    },
			error: function(error){
	    		$("#dropdown-newElement_"+currentScopeType+"-found").html("error");
				mylog.log("Une erreur est survenue pendant autocompleteMultiScope");
			}
		});
	},


	add : function(complete, data, inseeGeoSHapes){
		mylog.log("add", complete, data, inseeGeoSHapes);
		/*$('[name="newElement_insee"]').val(data.data("insee"));
		$('[name="newElement_lat"]').val(data.data("lat"));
		$('[name="newElement_lng"]').val(data.data("lng"));
		$('[name="newElement_city"]').val(data.data("city"));
		$('[name="newElement_dep"]').val(data.data("dep"));
		$('[name="newElement_region"]').val(data.data("region"));*/

		formInMap.NE_insee = data.data("insee");
		formInMap.NE_lat = data.data("lat");
		formInMap.NE_lng = data.data("lng");
		formInMap.NE_city = data.data("city");
		formInMap.NE_country = data.data("country");
		formInMap.NE_dep = data.data("dep");
		formInMap.NE_region = data.data("region");

		if(complete == true){
			//$('[name="newElement_cp"]').val(data.data("cp"));
			//$('#postalcode_sumery_value').html(data.data("cp"));
			formInMap.NE_cp = data.data("cp");
		}else{
			uncomplete = true;
			$('[name="newElement_cp"]').attr( "placeholder", "Vous devez ajouter un code postal" );
			$('#divPostalCode').addClass("has-error");
		}

		formInMap.initHtml();
		
		Sig.markerFindPlace.setLatLng([data.data("lat"), data.data("lng")]);
		mylog.log("geoShape", inseeGeoSHapes);
		if(notEmpty(inseeGeoSHapes[formInMap.NE_insee])){
			var shape = inseeGeoSHapes[formInMap.NE_insee];
			shape = Sig.inversePolygon(shape);
			Sig.showPolygon(shape);
			setTimeout(function(){
				Sig.map.fitBounds(shape);
				Sig.map.invalidateSize();
			}, 1500);
		}else{
			setTimeout(function(){
				Sig.centerPopupMarker([formInMap.NE_lat, formInMap.NE_lng], 12);
			}, 2500);
		}
		$("#dropdown-newElement_cp-found, #dropdown-newElement_city-found, #dropdown-newElement_streetAddress-found, #dropdown-newElement_locality-found").hide();


		//formInMap.updateSummeryLocality(data);
		$("#newElement_btnValidateAddress").prop('disabled', (complete == true ? false : true));
		$("#divStreetAddress").removeClass("hidden");
	},

	/*updateSummeryLocality : function (data){
		mylog.log("updateSummeryLocality",data);
		$('#insee_sumery_value').html(data.data("insee"));
		$('#lat_sumery_value').html(data.data("lat"));
		$('#lng_sumery_value').html(data.data("lng"));
		$('#city_sumery_value').html(data.data("city"));
		$('#dep_sumery_value').html(data.data("dep"));
		$('#region_sumery_value').html(data.data("region"));
		$('#country_sumery_value').html(data.data("country"));
		$('#postalcode_sumery_value').html(data.data("cp"));
	}, */


	searchAdressNewElement : function(){ 
		mylog.log("searchAdressNewElement");
		var providerName = "";
		var requestPart = "";

		var street 	= ($('[name="newElement_streetAddress"]').val()  != "") ? $('[name="newElement_streetAddress"]').val() : "";
		/*var city 	= ($('#city_sumery_value').html() 	   	  	 != "") ? $('#city_sumery_value').html() : "";
		var cp 		= ($('#postalcode_sumery_value').html() 			 != "") ? $('#postalcode_sumery_value').html() : "";
		var countryCode = ($('#country_sumery_value').html() 	 != "") ? $('#country_sumery_value').html() : "";*/

		var city 	= formInMap.NE_city;
		var cp 		= formInMap.NE_cp;
		var countryCode = formInMap.NE_country;


		if($('[name="newElement_streetAddress"]').val() != ""){
			providerName = "nominatim";
			formInMap.typeSearchInternational = "address";
			//construction de la requete
			requestPart = addToRequest(requestPart, street);
			requestPart = addToRequest(requestPart, city);
			requestPart = addToRequest(requestPart, cp);
		}else{
			providerName = "communecter"
			formInMap.typeSearchInternational = "city";
			//construction de la requete
			if(cp != ""){
				requestPart = addToRequest(requestPart, cp);
			}
		}

		formInMap.NE_street = $('[name="newElement_streetAddress"]').val();

		$("#dropdown-newElement_streetAddress-found").html("<li><a href='javascript:'><i class='fa fa-spin fa-refresh'></i> recherche en cours</a></li>");
		$("#dropdown-newElement_streetAddress-found").show();

		if(countryCode == "NC"){
			mylog.log("countryCode", countryCode);
			countryCode = formInMap.changeCountryForNominatim(countryCode);
			mylog.log("countryCode", countryCode);
			callNominatim(requestPart, countryCode);
		}else{
			mylog.log("countryCode", countryCode);
			countryCode = formInMap.changeCountryForNominatim(countryCode);
			mylog.log("countryCode", countryCode);
			callDataGouv(requestPart, countryCode);
		}
	},

	// Pour effectuer une recherche a la Réunion avec Nominatim, il faut choisir le code de la France, pas celui de la Réunion
	changeCountryForNominatim : function(country){
		var codeCountry = {
			"FR" : ["RE", "GP", "GF", "MQ", "YT", "NC", "PM"]
		};
		$.each(codeCountry, function(key, countries){
			if(countries.indexOf(country) != -1)
		 		country = key;
		});
		return country ;
	},

	backToForm : function(cancel){
		mylog.log("backToForm");
		if(formInMap.modePostalCode == false ){
			if(formInMap.updateLocality == false ){
				if(notEmpty($("[name='newElement_lat']").val())){
					/*locationObj = {
						address : {
							"@type" : "PostalAddress",
							addressCountry : $('#country_sumery_value').html(),
							streetAddress : $('#street_sumery_value').html(),
							addressLocality : $('#city_sumery_value').html(),
							postalCode : $('#postalcode_sumery_value').html(),
							codeInsee : $('#insee_sumery_value').html(),
							depName : $('#dep_sumery_value').html(),
							regionName : $('#region_sumery_value').html()
						},
						geo : {
							"@type" : "GeoCoordinates",
							latitude : $('#lat_sumery_value').html(),
							longitude : $('#lng_sumery_value').html()
						},
						geoPosition : {
							"type" : "Point",
							"coordinates" : [ parseFloat($('#lng_sumery_value').html()), parseFloat($('#lat_sumery_value').html()) ]
						}
					};*/
					locationObj = formInMap.createLocalityObj();
					copyMapForm2Dynform(locationObj);
					addLocationToForm(locationObj);
				}
				$("#form-street").val($('#street_sumery_value').html());
				showMap(false);
				Sig.clearMap();
				if(location.hash != "#referencement" && location.hash != "#web")
					$('#ajax-modal').modal("show");
			}else{
				if(typeof cancel == "undefined" || cancel == false)
					formInMap.updateLocalityElement();
				showMap(false);
				if(typeof contextMap != "undefined")
					Sig.showMapElements(Sig.map, contextMap);
			}	
		}else{
			if(notEmpty($("[name='newPC_lat']").val())){
				postalCodeObj = {
					postalCode : $("[name='newPC_postalCode']").val(),
					name : $("[name='newPC_name']").val(),
					latitude : $("[name='newPC_lat']").val(),
					longitude : $("[name='newPC_lon']").val()
				};
				copyPCForm2Dynform(postalCodeObj);
				addPostalCodeToForm(postalCodeObj);
			}
			showMap(false);
			Sig.clearMap();
			if(location.hash != "#referencement" && location.hash != "#web")
				$('#ajax-modal').modal("show");
		}
	},

	updateLocalityElement : function(){
		mylog.log("updateLocalityElement");
		/*var unikey = formInMap.NE_country + "_" + formInMap.NE_insee + "-" + formInMap.NE_cp; 
		var locality = {
			address : {
				"@type" : "PostalAddress",
				codeInsee : formInMap.NE_insee,
				streetAddress : formInMap.NE_street.trim(),
				postalCode : formInMap.NE_cp,
				addressLocality : formInMap.NE_city,
				depName : formInMap.NE_dep,
				regionName : formInMap.NE_region,
				addressCountry : formInMap.NE_country
			},
			geo : {
				"@type" : "GeoCoordinates",
				latitude : formInMap.NE_lat,
				longitude : formInMap.NE_lng
			},
			geoPosition : {
				"type" : "Point",
				"coordinates" : [ parseFloat($("[name='newElement_lng']").val()), parseFloat($("[name='newElement_lat']").val()) ]
			},
			unikey : unikey
		};*/

		locality = formInMap.createLocalityObj(true);

		if(formInMap.addressesIndex)
			locality["addressesIndex"] = formInMap.addressesIndex ;
		
		if(typeof globalTheme == "undefined" || globalTheme != "network"){
			currentScopeType = "city";
			addScopeToMultiscope(locality.unikey, locality.address.addressLocality);
			
			currentScopeType = "cp";
			addScopeToMultiscope(locality.address.postalCode, locality.address.postalCode);
			
			currentScopeType = "dep";
			addScopeToMultiscope(locality.address.depName, locality.address.depName);
			
			currentScopeType = "region";
			addScopeToMultiscope(locality.address.regionName, locality.address.regionName);
		}
		var params = new Object;
		params.name = ((formInMap.addressesIndex)?"addresses":"locality");
		params.value = locality;
		params.pk = contextData.id;
		params.type = contextData.type;
		if(userId != ""){
			$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+params.type,
		        data: params,
		       	dataType: "json",
		    	success: function(data){
		    		mylog.log("data", data);
			    	
			    	if(data.result){
			    		var inMap = true ;
			    		//if(data.firstCitizen == true)
			    		//	getAjax(null, baseUrl+'/'+moduleId+'/rooms/index/type/cities/id/'+locality.unikey, null,"norender");

			    		if(contextData != null){
			    			if(contextData.address == null){
			    				inMap =false ;
				    		}
				    		contextData.address = locality.address;
							contextData.geo = locality.geo;
				    		contextData.geoPosition = locality.geoPosition;
			    		}
						
						if(!formInMap.addressesIndex){
							//Header && ficheInfoElement
							mylog.log("locality.address.streetAddress", locality.address.streetAddress);
							
							// CO2 
							$("#detailAddress").html(formInMap.seenAddress(locality.address.streetAddress, locality.address.postalCode, locality.address.addressLocality, locality.address.addressCountry, locality.address.codeInsee));
							$(".cobtn,.whycobtn").hide();

							toastr.success(data.msg);
							formInMap.initData();
							toastr.success(data.msg);
							if(contextData.id != userId){
								var typeMap = ((typeof contextData == "undefined" || contextData == null)?"citoyens":contextData.type) ;
								if(typeMap == "citoyens")
									typeMap = "people";
								if(inMap == false)
									contextMap = Sig.addContextMap(contextMap, contextData, typeMap);
								else{
									contextMap = Sig.modifLocalityContextMap(contextMap, contextData, typeMap);
								}
								Sig.restartMap();
								Sig.showMapElements(Sig.map, contextMap);
								urlCtrl.loadByHash("#page.type."+contextData.type+".id."+contextData.id+".view.detail");
							}else{
								formInMap.changeMenuCommunextion(locality);
								currentUser.addressCountry = locality.address.addressCountry;
								currentUser.postalCode = locality.address.postalCode;
								currentUser.codeInsee = locality.address.codeInsee;
								Sig.myPosition.position.latitude = locality.geo.latitude;
								Sig.myPosition.position.longitude = locality.geo.longitude;
								var urlPage = window.location.href ;
								$('.showIfCommucted').removeClass("hidden");
								if(urlPage.indexOf("#page.type.citoyens.id."+userId) == -1) {
									urlCtrl.loadByHash("#page.type.citoyens.id."+userId+".view.detail");
								}else{
									Sig.restartMap();
									Sig.showMapElements(Sig.map, contextMap);
									urlCtrl.loadByHash("#page.type."+contextData.type+".id."+contextData.id+".view.detail");
								}

							}
						}else{
							formInMap.initData();
							toastr.success(data.msg);
							urlCtrl.loadByHash("#page.type."+contextData.type+".id."+contextData.id+".view.detail");
						}
						
			    	}else{
			    		toastr.error(data.msg);
			    	}
			    }
			});
		}else{
			formInMap.changeMenuCommunextion(locality);
			inseeCommunexion = locality.address.codeInsee ;
			cityNameCommunexion = locality.address.addressLocality ;
			cpCommunexion = locality.address.postalCode ;
			countryCommunexion = locality.address.addressCountry ;
			setCookies("/");
			formInMap.initData();
		}
		
	},

	changeMenuCommunextion : function(locality){
		//Menu Left
		$("#btn-geoloc-auto-menu").attr("href", "#city.detail.insee."+locality.address.codeInsee+".postalCode."+locality.address.postalCode);
		$('#btn-geoloc-auto-menu > span.lbl-btn-menu').html(locality.address.addressLocality);
		$("#btn-geoloc-auto-menu").attr("onclick", "");
		$("#btn-geoloc-auto-menu").addClass("lbh");
		bindLBHLinks();

		//Dashbord
		$("#btn-menuSmall-mycity").attr("href", "#city.detail.insee."+locality.address.codeInsee+".postalCode."+locality.address.postalCode);
		$("#btn-menuSmall-citizenCouncil").attr("href", "#rooms.index.type.cities.id."+locality.unikey);
		//Multiscope
		$(".msg-scope-co").html("<i class='fa fa-home'></i> Vous êtes communecté à " + locality.address.addressLocality);
		//MenuSmall
		$(".hide-communected").hide();
		$(".visible-communected").show();
	},

	initDropdown : function(){
		$("#dropdown-newElement_cp-found").html("<li><a href='javascript:' class='disabled'>Rechercher un code postal</a></li>");
		$("#dropdown-newElement_city-found").html("<li><a href='javascript:' class='disabled'>Rechercher une ville, un village, une commune</a></li>");
	},

	initData : function(){
		mylog.log("initData");
		formInMap.timeoutAddCity;
		formInMap.initVarNE();
		formInMap.typeSearchInternational = "";
		formInMap.formType = "";
		formInMap.updateLocality = false;
		formInMap.addressesIndex = false;
		formInMap.initDropdown();
		$("#divStreetAddress").addClass("hidden");
		$("#divPostalCode").addClass("hidden");
		$("#divCity").addClass("hidden");
		formInMap.initHtml();
	},

	initHtml : function(){
		$('[name="newElement_insee"]').val(formInMap.NE_insee);
		$('[name="newElement_city"]').val(formInMap.NE_city);
		$('[name="newElement_cp"]').val(formInMap.NE_cp);
		$('[name="newElement_streetAddress"]').val(formInMap.NE_street.trim());
		$('[name="newElement_dep"]').val(formInMap.NE_dep);
		$('[name="newElement_region"]').val(formInMap.NE_region);
		$('[name="newElement_lat"]').val(formInMap.NE_lat);
		$('[name="newElement_lng"]').val(formInMap.NE_lng);

		$('#insee_sumery_value').html(formInMap.NE_insee);
		$('#lat_sumery_value').html(formInMap.NE_lat);
		$('#lng_sumery_value').html(formInMap.NE_lng);
		$('#city_sumery_value').html(formInMap.NE_city);
		$('#dep_sumery_value').html(formInMap.NE_dep);
		$('#region_sumery_value').html(formInMap.NE_region);
		$('#country_sumery_value').html(formInMap.NE_country);
		$('#postalcode_sumery_value').html(formInMap.NE_cp);
		$('#street_sumery_value').html(formInMap.NE_street.trim());
	},

	initVarNE : function(){
		formInMap.NE_insee = "";
		formInMap.NE_lat = "";
		formInMap.NE_lng = "";
		formInMap.NE_city = "";
		formInMap.NE_cp = "";
		formInMap.NE_street = "";
		formInMap.NE_country = "";
		formInMap.NE_dep = "";
		formInMap.NE_region = "";
	},

	createLocalityObj : function(withUnikey){
		mylog.log("createLocalityObj");
		
		var locality = {
			address : {
				"@type" : "PostalAddress",
				codeInsee : formInMap.NE_insee,
				streetAddress : formInMap.NE_street.trim(),
				postalCode : formInMap.NE_cp,
				addressLocality : formInMap.NE_city,
				depName : formInMap.NE_dep,
				regionName : formInMap.NE_region,
				addressCountry : formInMap.NE_country
			},
			geo : {
				"@type" : "GeoCoordinates",
				latitude : formInMap.NE_lat,
				longitude : formInMap.NE_lng
			},
			geoPosition : {
				"type" : "Point",
				"coordinates" : [ parseFloat(formInMap.NE_lng), parseFloat(formInMap.NE_lat) ]
			},
		};

		if(typeof withUnikey != "undefined" && withUnikey == true){
			var unikey = formInMap.NE_country + "_" + formInMap.NE_insee + "-" + formInMap.NE_cp;
			locality.unikey = unikey;
		}

		return locality;
	},

	seenAddress : function(street, cp, city, country, insee){
		var val = "" ;
		val += ( ( notEmpty(street)  ) ? street+"<br/>": ( (notEmpty(insee) ) ? "": trad.UnknownLocality ) );
		val += ( ( notEmpty(cp)  ) ?  cp + ", " : "") + " " + ( ( notEmpty(city) ) ?  city : "")  ;	
		val += ( ( notEmpty(country) && notEmpty(tradCountry[ country ]) ) ? ", " + tradCountry[ country ] : "" ) ;
		return val ;
	},


	getDepAndRegion : function(){
		if(typeof NE_dep == "undefined" || NE_dep == "" || typeof NE_region == "undefined" || NE_region == ""){
			$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/city/getDepAndRegion/",
		        data: {insee : NE_insee},
		       	dataType: "json",
		    	success: function(data){
		    		mylog.log("getDepAndRegion", data);
			    	
			    	if(data.depName){
			    		NE_dep = data.depName;
			    	}else{
			    		NE_dep = "";
			    	}

			    	if(data.regionName){
			    		NE_region = data.regionName;
					}else{
			    		NE_region = "";
			    	}
			    }
			});
		}
	},


	changeSelectCountrytim : function(){
		mylog.log("NE_cp.substring(0, 3)",NE_cp.substring(0, 3));
		countryFR = ["FR","GP","MQ","GF","RE","PM","YT"];

		if(countryFR.indexOf($('[name="newElement_country"]').val()) != -1){
			if(NE_cp.substring(0, 3) == "971")
				$('[name="newElement_country"]').val("GP");
			else if(NE_cp.substring(0, 3) == "972")
				$('[name="newElement_country"]').val("MQ");
			else if(NE_cp.substring(0, 3) == "973")
				$('[name="newElement_country"]').val("GF");
			else if(NE_cp.substring(0, 3) == "974")
				$('[name="newElement_country"]').val("RE");
			else if(NE_cp.substring(0, 3) == "975")
				$('[name="newElement_country"]').val("PM");
			else if(NE_cp.substring(0, 3) == "976")
				$('[name="newElement_country"]').val("YT");
			else
				$('[name="newElement_country"]').val("FR");
		}
	},

};