var formInMap = {
	actived : false,
	timeoutAddCity : null,
	NE_insee : "",
	NE_lat : "",
	NE_lng : "",
	NE_city : "",
	NE_cp : "",
	NE_street : "",
	NE_country : "",
	NE_level4 : "",
	NE_level4Name : "",
	NE_level3 : "",
	NE_level3Name : "",
	NE_level2 : "",
	NE_level2Name : "",
	NE_level1 : "",
	NE_level1Name : "",

	NE_localityId : "",
	NE_betweenCP : false,
	geoShape : "",

	typeSearchInternational : "",
	formType : "",
	updateLocality : false,
	addressesIndex : false,
	saveCities : {},
	bindActived : false,


	showMarkerNewElement : function(modePC){
		mylog.log("forminmap showMarkerNewElement");
		Sig.clearMap();
		formInMap.actived = true ;
		formInMap.hiddenHtmlMap(true);

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
		if( notNull(contextData) && notNull(contextData.geo) && formInMap.updateLocality == true 
			&& formInMap.NE_lat != "" && formInMap.NE_lng != "")
			coordinates = new Array(formInMap.NE_lat, formInMap.NE_lng);
		
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
			formInMap.initHtml();
			$("#newElement_btnValidateAddress").prop('disabled', (formInMap.NE_insee==""?true:false));
			if(formInMap.NE_insee != ""){
				if(userId == "")
					$("#divStreetAddress").addClass("hidden");
				else
					$("#divStreetAddress").removeClass("hidden");
			}
		}

		Sig.markerFindPlace.on('dragend', function(){
			formInMap.NE_lat = Sig.markerFindPlace.getLatLng().lat;
			formInMap.NE_lng = Sig.markerFindPlace.getLatLng().lng;
			Sig.markerFindPlace.openPopup();
		});

		if(formInMap.bindActived == false)
			formInMap.bindFormInMap();

		if(userId == "" || formInMap.NE_insee == "")
			$("#divStreetAddress").addClass("hidden");
		else
			$("#divStreetAddress").removeClass("hidden");

		$("#right_tool_map_locality").removeClass("hidden");
		$("#right_tool_map_search").addClass("hidden");
		if(typeof networkJson == "undefined" || networkJson == null)
			$("#mapLegende").addClass("hidden");
	},

	initUpdateLocality : function(address, geo, type, index){
		mylog.log("initUpdateLocality", address, geo, type, index);
		showMap(true);
		if(address != null && geo != null ){
			formInMap.NE_insee = address.codeInsee;
			formInMap.NE_lat = geo.latitude;
			formInMap.NE_lng = geo.longitude;
			formInMap.NE_city = address.addressLocality;
			formInMap.NE_cp = address.postalCode;
			formInMap.NE_street = address.streetAddress.trim();
			formInMap.NE_country = address.addressCountry;

			formInMap.NE_level4 = address.level4;
			formInMap.NE_level4Name = address.level4Name;
			formInMap.NE_level3 = address.level3;
			formInMap.NE_level3Name = address.level3Name;
			formInMap.NE_level2 = address.level2;
			formInMap.NE_level2Name = address.level2Name;
			formInMap.NE_level1 = address.level1;
			formInMap.NE_level1Name = address.level1Name;
			formInMap.NE_localityId = address.localityId;

			if(index)
				formInMap.addressesIndex = index ;
			formInMap.initDropdown();
			formInMap.getLevel();
			formInMap.getDetailCity();
		}else{
			formInMap.initVarNE();
			formInMap.geoShape = "";
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

			formInMap.initVarNE()
			formInMap.NE_country = $('[name="newElement_country"]').val() ;
			formInMap.initHtml();
			$("#country_sumery_value").html($('[name="newElement_country"]').val());
			$("#newElement_btnValidateAddress").prop('disabled', true);
			$("#divStreetAddress").addClass("hidden");

			formInMap.initDropdown();
			mylog.log("formInMap.NE_country", formInMap.NE_country, typeof formInMap.NE_country, formInMap.NE_country.length);
			if(formInMap.NE_country != ""){
				$("#divCP").addClass("hidden");
				$("#divCity").removeClass("hidden");
			}else{
				$("#divCity").addClass("hidden");
			}
				
		});

		// ---------------- newElement_city
		$('[name="newElement_city"]').keyup(function(){ 
			$("#dropdown-city-found").show();
			mylog.log("newElement_city", $('[name="newElement_city"]').val().trim().length);
			if($('[name="newElement_city"]').val().trim().length > 1){
				formInMap.NE_city = $('[name="newElement_city"]').val();
				formInMap.changeSelectCountrytim();

				if(notNull(formInMap.timeoutAddCity)) 
					clearTimeout(formInMap.timeoutAddCity);

				formInMap.timeoutAddCity = setTimeout(function(){ 
					formInMap.autocompleteFormAddress("locality", $('[name="newElement_city"]').val()); 
				}, 500);

			}
		});


		// ---------------- newElement_city
		$('[name="newElement_cp"]').keyup(function(){ 
			mylog.log("newElement_cp", $('[name="newElement_cp"]').val().trim());
			formInMap.NE_cp = $('[name="newElement_cp"]').val().trim();
			formInMap.btnValideDisable( ($('[name="newElement_cp"]').val().trim().length == 0 ? true : false) );

		});

		$('[name="newElement_city"]').focusout(function(){
			if(notNull(formInMap.timeoutAddCity)) 
				clearTimeout(formInMap.timeoutAddCity);
			if( $('[name="dropdown-newElement_city-found"]').length )
				formInMap.timeoutAddCity = setTimeout(function(){ $("#dropdown-newElement_city-found").hide(); }, 200);
			/*if( $('[name="dropdown-newElement_locality-found"]').length )
				formInMap.timeoutAddCity = setTimeout(function(){ $("#dropdown-newElement_locality-found").hide(); }, 200);*/
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
		$("#newElement_btnSearchAddress").click(function(){
			$(".dropdown-menu").hide();
			formInMap.searchAdressNewElement();
		});

		$('[name="newElement_street"]').keyup(function(){ 
			formInMap.showWarningGeo( ( ( $('[name="newElement_street"]').val().length > 0 ) ? true : false ) );
		});


		$("#newElement_btnValidateAddress").click(function(){
			processingBlockUi();
			mylog.log("#newElement_btnValidateAddress");
			if(notEmpty(formInMap.saveCities[formInMap.NE_insee])){
				var obj = { city : formInMap.saveCities[formInMap.NE_insee] }
				obj.city.geoShape = 1;
				if(formInMap.NE_betweenCP != false){
					var postalCode = {};
					
					postalCode.name = obj.city.name;
					postalCode.postalCode = formInMap.NE_cp;
					postalCode.geo = obj.city.geo;
					postalCode.geoPosition = obj.city.geoPosition;

					mylog.log("saveCities", typeof obj.city.postalCodes, obj.city.postalCodes);

					obj.city.postalCodes.push(postalCode);
				}

				mylog.log("city/save", obj);
				
				$.ajax({
					type: "POST",
					url: baseUrl+"/"+moduleId+"/city/save",
					data: obj,
					dataType: "json",
					success: function(data){
						mylog.log("city/save obj.city", obj.city);
						mylog.log("city/save data", data);
						if(data.result){
							toastr.success(data.msg);
						}

						formInMap.NE_localityId = data.id
						if(data.city.level1){
							formInMap.NE_level1 = data.city.level1;
							formInMap.NE_level1Name = data.city.level1Name;
							mylog.log("city/save data.city.level1", data.city.level1);
						}

						if(data.city.level2){
							formInMap.NE_level2 = data.city.level2;
							formInMap.NE_level2Name = data.city.level2Name;
						}

						if(data.city.level3){
							formInMap.NE_level3 = data.city.level3;
							formInMap.NE_level3Name = data.city.level3Name;
						}

						if(data.city.level4){
							formInMap.NE_level4 = data.city.level4;
							formInMap.NE_level4Name = data.city.level4Name;
						}
						formInMap.backToForm();
					},
					error: function(error){
						mylog.log("error", error);
						$("#dropdown-newElement_"+currentScopeType+"-found").html("error");
						mylog.log("Une erreur est survenue pendant l'enregistrement de la commune");
					}
				});
			}else
				formInMap.backToForm();
		});

		$("#newElement_btnCancelAddress").click(function(){
			formInMap.cancel();
		});

		formInMap.bindActived = true ;
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
					formInMap: true,
					countryCode : $('[name="newElement_country"]').val()
			},
			dataType: "json",
			success: function(data){

				mylog.log("autocompleteFormAddress success", data);
				html="";
				var inseeGeoSHapes = {};
				formInMap.saveCities = {};
				$.each(data.cities, function(key, value){
					mylog.log("HERE", value);
					var insee = value.insee;
					var country = value.country;
					mylog.log("HERE formInMap.saveCities", notEmpty(value.save), value.save);
					if(notEmpty(value.save) &&  value.save == true){
						formInMap.saveCities[insee] = value;
						mylog.log("HERE good save", insee, value, formInMap.saveCities);
					}
					mylog.log("HERE formInMap.saveCities", formInMap.saveCities);
					if(notEmpty(value.geoShape))
						inseeGeoSHapes[insee] = value.geoShape.coordinates[0];

					if(currentScopeType == "city" || currentScopeType == "locality") { 
						mylog.log("in scope city"); 
						mylog.dir(value);
						mylog.log("locId", key, value);
						if(value.postalCodes.length > 0){
							$.each(value.postalCodes, function(keyCP, valueCP){
								var val = valueCP.name; 
								var lbl = valueCP.postalCode ;
								var lat = valueCP.geo.latitude;
								var lng = valueCP.geo.longitude;

								var lblList = value.name + ", " + valueCP.name + ", " + valueCP.postalCode ;
								html += "<li><a href='javascript:;' data-type='"+currentScopeType+"' "+
												"data-locId='"+key+"' "+
												"data-level4='"+value.level4+"' data-level4Name='"+value.level4Name+"'"+
												"data-level3='"+value.level3+"' data-level3Name='"+value.level3Name+"'"+
												"data-level2='"+value.level2+"' data-level2Name='"+value.level2Name+"'"+ 
												"data-level1='"+value.level1+"' data-level1Name='"+value.level1Name+"'"+ 
												"data-country='"+country+"' "+
												"data-city='"+val+"' data-cp='"+lbl+"' "+
												"data-lat='"+lat+"' data-lng='"+lng+"' "+
												"data-insee='"+insee+"' class='item-city-found'>"+lblList+"</a></li>";
							});
						}else{
							var val = value.name; 
							var lat = value.geo.latitude;
							var lng = value.geo.longitude;
							var lblList = value.name ;
							html += "<li><a href='javascript:;' data-type='"+currentScopeType+"' "+
												"data-locid='"+key+"' ";

							html +=	"data-level4='"+value.level4+"' data-level4Name='"+value.level4Name+"'"+
									"data-level3='"+value.level3+"' data-level3Name='"+value.level3Name+"'"+
									"data-level2='"+value.level2+"' data-level2Name='"+value.level2Name+"'"+ 
									"data-level1='"+value.level1+"' data-level1Name='"+value.level1Name+"'";
							// if(notEmpty(level4))
							// 	html +=	"data-level4='"+level4+"' dta-level4name='"+level4Name+"'";
							// if(notEmpty(level3))
							// 	html +=	"data-level3='"+level3+"' data-level3name='"+level3Name+"'";
							// if(notEmpty(level2))
							// 	html +=	"data-level2='"+level2+"' data-level2name='"+level2Name+"'";
							// if(notEmpty(level1))
							// 	html +=	"data-level1='"+level1+"' data-level1name='"+level1Name+"'";
							html += "data-country='"+country+"' "+
									"data-city='"+val+"' data-lat='"+lat+"' "+
									"data-lng='"+lng+"' data-insee='"+insee+"' "+
									"class='item-city-found-uncomplete'>"+lblList+"</a></li>";
						}
					};
				});

				if(html == "") html = "<i class='fa fa-ban'></i> "+trad.noresult;
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
				mylog.log("Une erreur est survenue pendant autocompleteMultiScope", error);
			}
		});
	},

	add : function(complete, data, inseeGeoSHapes){
		mylog.log("add2", complete, data, inseeGeoSHapes);
		
		formInMap.NE_insee = data.data("insee");
		formInMap.NE_lat = data.data("lat");
		formInMap.NE_lng = data.data("lng");
		formInMap.NE_city = data.data("city");
		formInMap.NE_country = data.data("country");
		formInMap.NE_level4 = (notEmpty(data.data("level4")) ? data.data("level4") : null) ;
		formInMap.NE_level4Name = (notEmpty(data.data("level4Name")) ? data.data("level4Name") : null) ;
		formInMap.NE_level3 = (notEmpty(data.data("level3")) ? data.data("level3") : null) ;
		formInMap.NE_level3Name = (notEmpty(data.data("level3Name")) ? data.data("level3Name") : null) ;
		formInMap.NE_level2 = (notEmpty(data.data("level2")) ? data.data("level2") : null) ;
		formInMap.NE_level2Name = (notEmpty(data.data("level2Name")) ? data.data("level2Name") : null);
		formInMap.NE_level1 = (notEmpty(data.data("level1")) ? data.data("level1") : null) ;
		formInMap.NE_level1Name = (notEmpty(data.data("level1Name")) ? data.data("level1Name") : null) ;
		mylog.log("NE_localityId", data.data("locid"));
		formInMap.NE_localityId = data.data("locid");

		if(complete == true){
			formInMap.NE_cp = data.data("cp");
		}else if ( 	notEmpty(formInMap.saveCities) && 
					notEmpty(formInMap.saveCities[formInMap.NE_insee]) &&
					notEmpty(formInMap.saveCities[formInMap.NE_insee].betweenCP)
					)
			formInMap.NE_betweenCP = formInMap.saveCities[formInMap.NE_insee].betweenCP ;

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
		mylog.log("formInMap.NE_betweenCP ", formInMap.NE_betweenCP );
		formInMap.btnValideDisable( (formInMap.NE_betweenCP == false ? false : true) );
		//formInMap.btnValideDisable( false );

		if(userId == "")
			$("#divStreetAddress").addClass("hidden");
		else
			$("#divStreetAddress").removeClass("hidden");
	},

	searchAdressNewElement : function(){ 
		mylog.log("searchAdressNewElement");
		var providerName = "";
		var requestPart = "";

		var street 	= ($('[name="newElement_street"]').val()  != "") ? $('[name="newElement_street"]').val() : "";
		var city 	= formInMap.NE_city;
		var cp 		= formInMap.NE_cp;
		var countryCode = formInMap.NE_country;


		if($('[name="newElement_street"]').val() != ""){
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

		formInMap.NE_street = $('[name="newElement_street"]').val();

		$("#dropdown-newElement_streetAddress-found").html("<li><a href='javascript:'><i class='fa fa-spin fa-refresh'></i> "+trad.currentlyresearching+"</a></li>");
		$("#dropdown-newElement_streetAddress-found").show();
		mylog.log("countryCode", countryCode);
		
		var countryDataGouv = ["FR","GP","MQ","GF","RE","PM","YT"];
		if(countryDataGouv.indexOf(countryCode) != -1){
			countryCode = formInMap.changeCountryForNominatim(countryCode);
			mylog.log("countryCodeHere", countryCode);
			callDataGouv(requestPart, countryCode);
			
		}else{
			countryCode = formInMap.changeCountryForNominatim(countryCode);
			mylog.log("countryCode", countryCode);
			callNominatim(requestPart, countryCode);
		}
		
		formInMap.btnValideDisable(false);
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
		$("#right_tool_map_locality").addClass("hidden");
		$("#right_tool_map_search").removeClass("hidden");
		if(typeof networkJson == "undefined" || networkJson == null)
			$("#mapLegende").removeClass("hidden");
		mylog.log("backToForm 2");
		formInMap.actived = false ;

		mylog.log("backToForm 3");
		if(formInMap.updateLocality == false ){
			mylog.log("backToForm 6");
			if(notEmpty($("[name='newElement_lat']").val())){
				locObj = formInMap.createLocalityObj();
				mylog.log("forminmap copyMapForm2Dynform");
				dyFInputs.locationObj.copyMapForm2Dynform(locObj);
				dyFInputs.locationObj.addLocationToForm(locObj);
			}
			$("#form-street").val($('#street_sumery_value').html());
			$(".locationBtn").html("<i class='fa fa-home'></i> Adresse secondaire");
			formInMap.initData();
			$.unblockUI();
			showMap(false);
			Sig.clearMap();
			if(location.hash != "#referencement" && location.hash != "#web")
				$('#ajax-modal').modal("show");
		}else{

			mylog.log("backToForm 5");
			formInMap.updateLocality = false;
			if(typeof cancel == "undefined" || cancel == false)
				formInMap.updateLocalityElement();

			$.unblockUI();
			showMap(false);
			if(typeof contextData.map != "undefined" && contextData.map != null)
				Sig.showMapElements(Sig.map, contextData.map.data, contextData.map.icon, contextData.map.title);
		}
		
	},

	updateLocalityElement : function(){
		mylog.log("updateLocalityElement");
		var locality = formInMap.createLocalityObj(true);

		if(formInMap.addressesIndex)
			locality["addressesIndex"] = formInMap.addressesIndex ;
		
		var params = {
			name : ((formInMap.addressesIndex)?"addresses":"locality"),
			value : locality,
			pk : contextData.id,
			type : contextData.type
		};
		
		if(userId != ""){
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/element/updatefields/type/"+params.type,
				data: params,
				dataType: "json",
				success: function(data){
					mylog.log("updateLocalityElement data", data);
					
					if(data.result){
						var inMap = true ;						
						
						if(typeof contextData.address == "undefined" || contextData.address == null){
							inMap =false ;
						}

						if(notEmpty(data.locality)){
							contextData.address = data.locality.address;
							contextData.geo = data.locality.geo;
							contextData.geoPosition = data.locality.geoPosition;
						}
						
						
						formInMap.hiddenHtmlMap(false);
						formInMap.initData();

						if(!formInMap.addressesIndex){
							if(contextData.id != userId){
								var typeMap = ((typeof contextData == "undefined" || contextData == null) ? "citoyens" : contextData.type) ;
								if(typeMap == "citoyens")
									typeMap = "people";
								if(inMap == false)
									contextMap = Sig.addContextMap(contextMap, contextData, typeMap);
								else
									contextMap = Sig.modifLocalityContextMap(contextMap, contextData, typeMap);
							}else{
								currentUser.addressCountry = locality.address.addressCountry;
								currentUser.postalCode = locality.address.postalCode;
								currentUser.codeInsee = locality.address.codeInsee;
								currentUser.keyLocality = locality.address.key;
								setCookies();
								if(typeof Sig.myPosition != "undefined"){
									Sig.myPosition.position.latitude = locality.geo.latitude;
									Sig.myPosition.position.longitude = locality.geo.longitude;
								}
							}
						}

						Sig.restartMap();
						mylog.log("right_tool_map_locality");
						$("#right_tool_map_locality").addClass("hidden");
						$("#right_tool_map_search").removeClass("hidden");
						if(typeof networkJson == "undefined" || networkJson == null)
							$("#mapLegende").removeClass("hidden");
						mylog.log("contextData", contextData.type, contextData.id);
						urlCtrl.loadByHash("#page.type."+contextData.type+".id."+contextData.id+".view.detail");
						toastr.success(data.msg);
					}else{
						toastr.error(data.msg);
					}
				}
			});
		} else {
			mylog.log("locality communexion", locality);
			$.removeCookie('communexionType', { path: '/' }); $.removeCookie('communexionValue', { path: '/' }); 
			$.removeCookie('communexionName', { path: '/' }); $.removeCookie('communexionLevel', { path: '/' }); 
			$.removeCookie('inseeCommunexion', { path: '/' }); $.removeCookie('cityNameCommunexion', { path: '/' }); 
			$.removeCookie('cpCommunexion', { path: '/' }); $.removeCookie('communexionActivated', { path: '/' }); 

			$.cookie("inseeCommunexion", locality.address.codeInsee, { expires: 365, path : "/" });
			$.cookie("cpCommunexion", locality.address.postalCode, { expires: 365, path : "/" });
			$.cookie("cityNameCommunexion", locality.address.addressLocality , { expires: 365, path : "/" });
			$.cookie("communexionActivated", false, { expires: 365, path : "/" });
			$.cookie("communexionValue", locality.address.key, { expires: 365, path : "/" });
			//$.cookie("communexionValue", locality.address.addressCountry+"_"+locality.address.codeInsee+"-"+locality.address.postalCode, { expires: 365, path : "/" });
			$.cookie("communexionName", locality.address.addressLocality, { expires: 365, path : "/" });
			$.cookie("communexionType", "cp", { expires: 365, path : "/" });
			$.cookie("communexionLevel", "cpCommunexion", { expires: 365, path : "/" });
			urlCtrl.loadByHash(location.hash);
		}
	},

	// setCommunexion : function(address){
	// 	var coFIM = {
	// 		city : address.localityId,
	// 		cityName : address.addressLocality,
	// 		cp : address.postalCodes,
	// 		level1 : address.level1,
	// 		level1Name : address.level1Name,
	// 		level2 : address.level2,
	// 		level2Name : address.level2Name,
	// 		level3 : address.level3,
	// 		level3Name : address.level3Name,
	// 		level4 : address.level4,
	// 		level4Name : address.level4Name,
	// 	}
	// 	setGlobalScope(address.localityId, address.addressLocality, "cp", "city", coFIM);
	// },

	initDropdown : function(){
		mylog.log("initDropdown");
		$("#dropdown-newElement_cp-found").html("<li><a href='javascript:' class='disabled'>"+trad['Currently researching']+"</a></li>");
		$("#dropdown-newElement_city-found").html("<li><a href='javascript:' class='disabled'>"+trad['Search a city, a town or a postal code'] +"</a></li>");
	},

	initHtml : function(){
		var fieldsLocality = [	"insee", "lat", "lng", "city", "country", "cp", "street",
								"level4", "level4Name", "level3", "level3Name", 
								"level2", "level2Name", "level1", "level1Name" ]


		$.each(fieldsLocality, function(key, value){
			$('[name="newElement_'+value+'"]').val(formInMap["NE_"+value]);
			if(value == "country")
				$('#'+value+'_sumery_value').html(tradCountry[ formInMap["NE_"+value] ]);
			else
				$('#'+value+'_sumery_value').html(formInMap["NE_"+value]);

			if(formInMap["NE_"+value] != ""){
				$('#'+value+'_sumery').removeClass("hidden");
			}
			else
				$('#'+value+'_sumery').addClass("hidden");
		});

		if(formInMap.NE_betweenCP != false)
			$("#divCP").removeClass("hidden");


	},

	initVarNE : function(){
		formInMap.NE_insee = "";
		formInMap.NE_lat = "";
		formInMap.NE_lng = "";
		formInMap.NE_city = "";
		formInMap.NE_cp = "";
		formInMap.NE_street = "";
		formInMap.NE_country = "";
		formInMap.NE_level4 = "";
		formInMap.NE_level4Name = "";
		formInMap.NE_level3 = "";
		formInMap.NE_level3Name = "";
		formInMap.NE_level2 = "";
		formInMap.NE_level2Name = "";
		formInMap.NE_level1 = "";
		formInMap.NE_level1Name = "";
		formInMap.NE_localityId = "";
		formInMap.NE_betweenCP = false;
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
				level1 : formInMap.NE_level1,
				level1Name : formInMap.NE_level1Name,
				addressCountry : formInMap.NE_country,
				localityId : formInMap.NE_localityId
				
			},
			geo : {
				"@type" : "GeoCoordinates",
				latitude : formInMap.NE_lat,
				longitude : formInMap.NE_lng
			},
			geoPosition : {
				"type" : "Point",
				"coordinates" : [ parseFloat(formInMap.NE_lng), parseFloat(formInMap.NE_lat) ]
			}
		};

		mylog.log("createLocalityObj", formInMap.NE_level2, notEmpty(formInMap.NE_level2))
		if( notEmpty(formInMap.NE_level2) && formInMap.NE_level2 != "undefined" ){
			locality.address.level2 = formInMap.NE_level2;
			locality.address.level2Name = formInMap.NE_level2Name;
		}
		if(notEmpty(formInMap.NE_level3 != "" && formInMap.NE_level3 != "undefined")){
			locality.address.level3 = formInMap.NE_level3;
			locality.address.level3Name = formInMap.NE_level3Name;
		}
		if(notEmpty(formInMap.NE_level4 != "" && formInMap.NE_level4 != "undefined")){
			locality.address.level4 = formInMap.NE_level4;
			locality.address.level4Name = formInMap.NE_level4Name;
		}

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

	getLevel : function(){
		mylog.log("getLevel");
		if(notEmpty(formInMap.NE_localityId) && 
			(	typeof formInMap.NE_level1 == "undefined" || formInMap.NE_level1 == "" || 
				typeof formInMap.NE_level2 == "undefined" || formInMap.NE_level2 == ""|| 
				typeof formInMap.NE_level3 == "undefined" || formInMap.NE_level3 == ""|| 
				typeof formInMap.NE_level4 == "undefined" || formInMap.NE_level4 == "") ){
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/city/getLevel/",
				data: { cityId : formInMap.NE_localityId },
				dataType: "json",
				success: function(data){
					mylog.log("getLevel", data);
					if(data){
						formInMap.NE_level1 = ((data.level1) ? data.level1 : "");
						formInMap.NE_level1Name = ((data.level1Name) ? data.level1Name : "");
						formInMap.NE_level2 = ((data.level2) ? data.level2 : "");
						formInMap.NE_level2Name = ((data.level2Name) ? data.level2Name : "");
						formInMap.NE_level3 = ((data.level3) ? data.level3 : "");
						formInMap.NE_level3Name = ((data.level3Name) ? data.level3Name : "");
						formInMap.NE_level4 = ((data.level4) ? data.level4 : "");
						formInMap.NE_level4Name = ((data.level4Name) ? data.level4Name : "");
					}
				}
			});
		}
	},

	changeSelectCountrytim : function(){
		mylog.log("changeSelectCountrytim", formInMap.NE_country);
		mylog.log("formInMap.NE_cp.substring(0, 3)");
		var countryFR = ["FR","GP","MQ","GF","RE","PM","YT"];
		var regexNumber = new RegExp("[1-9]+") ;
		if(countryFR.indexOf(formInMap.NE_country) != -1 && regexNumber.test(formInMap.NE_country) ) {
			var name = $('[name="newElement_city"]').val();
			if(name.substring(0, 3) == "971")
				$('[name="newElement_country"]').val("GP");
			else if(name.substring(0, 3) == "972")
				$('[name="newElement_country"]').val("MQ");
			else if(name.substring(0, 3) == "973")
				$('[name="newElement_country"]').val("GF");
			else if(name.substring(0, 3) == "974")
				$('[name="newElement_country"]').val("RE");
			else if(name.substring(0, 3) == "975")
				$('[name="newElement_country"]').val("PM");
			else if(name.substring(0, 3) == "976")
				$('[name="newElement_country"]').val("YT");
			else
				$('[name="newElement_country"]').val("FR");
		}
	},

	btnValideDisable : function(bool){
		mylog.log("btnValideDisable");
		$("#newElement_btnValidateAddress").prop('disabled', bool);
	},

	showWarningGeo : function(bool){
		mylog.log("showWarningGeo");
		if(bool == true){
			$("#alertGeo").removeClass("hidden");
			$("#newElement_btnSearchAddress").removeClass("btn-default");
			$("#newElement_btnSearchAddress").addClass("btn-warning");
		}else{
			$("#alertGeo").addClass("hidden");
			$("#newElement_btnSearchAddress").removeClass("btn-warning");
			$("#newElement_btnSearchAddress").addClass("btn-default");
		}
	},

	hiddenHtmlMap : function(bool){
		mylog.log("formInMap hiddenHtmlMap()", bool);
		if(bool == true){
			$("#txt-find-place").addClass("hidden");
			$("#input-search-map").addClass("hidden");
			$("#menu-map-btn-start-search").addClass("hidden");
			$("#mainMap .tools-btn").addClass("hidden");
			$("#map-loading-data").addClass("hidden");
		}else{
			$("#txt-find-place").removeClass("hidden");
			$("#input-search-map").removeClass("hidden");
			$("#menu-map-btn-start-search").removeClass("hidden");
			$("#mainMap .tools-btn").removeClass("hidden");
			//$("#map-loading-data").removeClass("hidden");
		}
	},

	getDetailCity : function(){
		mylog.log("getDetailCity");
		if(notEmpty(formInMap.NE_localityId)){
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/city/detailforminmap/",
				data: {id : formInMap.NE_localityId},
				dataType: "json",
				success: function(data){
					formInMap.geoShape = data.geoShape;

					if(notEmpty(data.betweenCP)){
						formInMap.NE_betweenCP = data.betweenCP;
						$("#divCP").removeClass("hidden");
					}
					
					formInMap.displayGeoShape();
				}
			});
		}
	},

	displayGeoShape : function(){
		mylog.log("displayGeoShape");
		if(typeof formInMap.geoShape == "undefined") return;
		var geoShape = Sig.inversePolygon(formInMap.geoShape.coordinates[0]);
		Sig.showPolygon(geoShape);
		setTimeout(function(){
			Sig.map.fitBounds(geoShape);
			Sig.map.invalidateSize();
		}, 1500);
	},

	initData : function(keepType){
		mylog.log("initData");
		formInMap.timeoutAddCity;
		formInMap.initVarNE();
		formInMap.typeSearchInternational = "";
		formInMap.geoShape = "";
		if(typeof keepType =="undefined" || keepType==false){
			formInMap.formType = "";
		}
		//formInMap.updateLocality = false;
		formInMap.addressesIndex = false;
		formInMap.initDropdown();
		formInMap.saveCities = {} ;
		formInMap.bindActived = false;
		
		$("#divStreetAddress").addClass("hidden");
		$("#divCity").addClass("hidden");
		$("#divCP").addClass("hidden");
		formInMap.initHtml();
	},

	cancel : function(){
		mylog.log("formInMap cancel()");
		formInMap.typeSearchInternational = "";
		formInMap.geoShape = "";
		//formInMap.formType = "";
		formInMap.addressesIndex = false;
		formInMap.initVarNE();
		formInMap.initHtml();
		formInMap.hiddenHtmlMap(false);
		formInMap.backToForm(true);
	}

};