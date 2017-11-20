//Retrieve the countries in ajax and return an array of value
//The selectType change the value key : 
//for select input : {"value":"FR", "text":"France"}
//for select2 input : {"id":"FR", "text":"France"}
function getCountries(selectType) {
	var result = new Array();
	$.ajax({
		url: baseUrl+'/'+moduleId+"/opendata/getcountries",
		type: 'post',
		global: false,
		async: false,
		dataType: 'json',
		success: function(data) {
			$.each(data, function(i,value) {
				if (selectType == "select2") {
					result.push({"id" : value.value, "text" :value.text});
				} else {
					result.push({"value" : value.value, "text" :value.text});
				}
			}) 
		}
	});
	return result;
}

function formatDataForSelect(data, selectType) {
	var result = new Array();
	$.each(data, function(key,value) {
		if (selectType == "select2") {
			result.push({"id" : key, "text" :value});
		} else {
			result.push({"value" : key, "text" :value});
		}
	});
	return result;
}

function getCitiesByPostalCode(postalCode, selectType) {
	var result =new Array();
	$.ajax({
		url: baseUrl+'/'+moduleId+"/opendata/getcitiesbypostalcode/",
		data: {postalCode: postalCode},
		type: 'post',
		global: false,
		async: false,
		dataType: 'json',
		success: function(data) {
			$.each(data, function(key,value) {
				if (selectType == "select2") {
					result.push({"id" : value.insee, "text" :value.name});
				} else {
					result.push({"value" : value.insee, "text" :value.name});
				}
			});
		}
	});
	return result;
}

/** added by tristan **/
function getCitiesGeoPosByPostalCode(postalCode, selectType) {
	var result =new Array();
	$.ajax({
		url: baseUrl+'/'+moduleId+"/opendata/getcitiesgeoposbypostalcode/",
		data: {postalCode: postalCode},
		type: 'post',
		global: false,
		async: false,
		dataType: 'json',
		success: function(data) { //mylog.dir(data);
			result.push(data);
		}
	});
	return result;
}
function isUniqueUsername(username) {
	var response;
	$.ajax({
		url: baseUrl+'/'+moduleId+"/person/checkusername/",
		data: {username: username},
		type: 'post',
		global: false,
		async: false,
		dataType: 'json',
		success: function(data) {
		    response = data;
		}
	});
	mylog.log("isUniqueUsername=", response);
	return response;
}
function slugUnique(searchValue){
	
	//searchType = (types) ? types : ["organizations", "projects", "events", "needs", "citoyens"];
	var response;
	var data = {
		"id":contextData.id,
		"type": contextData.type,
		"slug" : searchValue
	};
	//$("#listSameSlug").html("<i class='fa fa-spin fa-circle-o-notch'></i> Vérification d'existence");
	//$("#similarLink").show();
	//$("#btn-submit-form").html('<i class="fa  fa-spinner fa-spin"></i>').prop("disabled",true);
	$.ajax({
      type: "POST",
          url: baseUrl+"/" + moduleId + "/slug/check",
          data: data,
          dataType: "json",
          error: function (data){
             mylog.log("error"); mylog.dir(data);
             //$("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false);
          },
          success: function(data){
 			//var msg = "Ce pseudo est déjà utilisé";
 			//$("#btn-submit-form").html('Valider <i class="fa fa-arrow-circle-right"></i>').prop("disabled",false);
			if (!data.result) {
				//response=false;
				if(!$("#ajaxFormModal #slug").parent().hasClass("has-error"))
					$("#ajaxFormModal #slug").parent().removeClass('has-success').addClass('has-error');//.find("span").text("cucu");
				//.addClass("has-error").parent().find("span").text("cretin");
				msgSlug="This slug is already used.";
				//bindLBHLinks();
			} else {
				//response=true;
				if(!$("#ajaxFormModal #slug").parent().hasClass("has-success"))
					$("#ajaxFormModal #slug").parent().removeClass('has-error').addClass('has-success');
				//.addClass("has-success").parent().find("span").text("good peydé");
				msgSlug="This slug is not used.";
				//$("#slug").html("<span class='txt-green'><i class='fa fa-thumbs-up text-green'></i> Aucun pseudo avec ce nom.</span>");

			}
			$("#ajaxFormModal #slug").next().text(msgSlug);
          }
 	});
 	//return response;
}
function addCustomValidators() {
	mylog.log("addCustomValidators");
	//Validate a postalCode
	jQuery.validator.addMethod("validPostalCode", function(value, element) {
	    var response;
	    $.ajax({
			url: baseUrl+'/'+moduleId+"/opendata/getcitiesbypostalcode/",
			data: {postalCode: value},
			type: 'post',
			global: false,
			async: false,
			dataType: 'json',
			success: function(data) {
			    response = data;
			}
		});

	    if (Object.keys(response).length > 0) {
	    	return true;
	    } else {
	    	return false;
	    }
	}, "Code postal inconnu");
	/*jQuery.validator.addMethod("uniqueSlug", function(value, element) {
	    //Check unique username
	   	return slugUnique(value);
	}, "This slug already exists. Please choose an other one.");*/
	jQuery.validator.addMethod("validUserName", function(value, element) {
	    //Check authorized caracters
		var usernameRegex = /^[a-zA-Z0-9\-]+$/;
    	var validUsername = value.match(usernameRegex);
    	if (validUsername == null) {
        	return false;
    	} else {
    		return true;
    	}
    }, tradDynForm.invalidUsername);

	jQuery.validator.addMethod("uniqueUserName", function(value, element) {
	    //Check unique username
	   	return isUniqueUsername(value);
	}, "A user with the same username already exists. Please choose an other one.");

	jQuery.validator.addMethod("inArray", function(value, element) {
	    //Check authorized caracters
		test = $.inArray( element, value );
    	if (test >= 0) 
    		return true;
    	else
    		return false;
    }, "Invalid : please stick to given values.");

    jQuery.validator.addMethod("greaterThan", function(value, element, params) {
    	mylog.log("greaterThan", value, params);
    	mylog.log(moment(value, "DD/MM/YYYY HH:mm").format());
    	mylog.log(!/Invalid|NaN/.test(new Date(moment(value, "DD/MM/YYYY HH:mm").format()))); 
	    //if (!/Invalid|NaN/.test(new Date(value))) {
	    if (!/Invalid|NaN/.test(new Date(moment(value, "DD/MM/YYYY HH:mm").format()))) {
	    	mylog.log(!/Invalid|NaN/.test(new Date(moment(value, "DD/MM/YYYY HH:mm").format()))); 

	        return moment(value, "DD/MM/YYYY HH:mm").isAfter(moment($(params[0]).val(), "DD/MM/YYYY HH:mm"));
	    }    
	    return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val())); 
	},'Doit ètre aprés {1}.');


	// jQuery.validator.addMethod("greaterThanOrSame", function(value, element, params) {
 //    	mylog.log("greaterThan", value, params);
 //    	mylog.log(moment(value, "DD/MM/YYYY HH:mm").format());
 //    	mylog.log(!/Invalid|NaN/.test(new Date(moment(value, "DD/MM/YYYY HH:mm").format()))); 
	//     //if (!/Invalid|NaN/.test(new Date(value))) {
	//     if (!/Invalid|NaN/.test(new Date(moment(value, "DD/MM/YYYY HH:mm").format()))) {
	//     	mylog.log(!/Invalid|NaN/.test(new Date(moment(value, "DD/MM/YYYY HH:mm").format()))); 
	    	
	//         return moment(value, "DD/MM/YYYY HH:mm").isSameOrAfter(moment($(params[0]).val(), "DD/MM/YYYY HH:mm"));
	//     }    
	//     return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val())); 
	// },'Doit ètre aprés {1}.');

	jQuery.validator.addMethod("greaterThanNow", function(value, element, params) {   
		mylog.log("greaterThanNow", value,  params[0]);
		mylog.log(moment(value, params[0])," < ",moment());
	    return moment(value, params[0]).isAfter(moment()); 
	},"Doit être après la date d'aujourd'hui.");

	jQuery.validator.addMethod("duringDates", function(value, element, params) {  
		if( $(params[0]).val() && $(params[1]).val() ){
			//console.warn(moment(value, "DD/MM/YYYY HH:mm"),moment($(params[0]).val()),moment($(params[1]).val()));
	    	return (moment(value, "DD/MM/YYYY HH:mm").isSameOrAfter(moment($(params[0]).val())) 
	    		&& moment(value, "DD/MM/YYYY HH:mm").isSameOrBefore(moment($(params[1]).val())));
	    	//return  ( new Date(value) >= new Date( $(params[0]).val() ) && new Date(value) <= new Date($(params[1]).val()) );
		} 
		return true;
	},"Cette date est exterieure à l'évènement parent.");
}



function showLoadingMsg(msg){
	$("#main-title-public1").html("<i class='fa fa-refresh fa-spin'></i> "+msg+" ...");
	$("#main-title-public1").show(300);
}
function hideLoadingMsg(){
	$("#main-title-public1").html("");
	$("#main-title-public1").hide(300);
}
function dateSecToString(date){
	var yyyy = date.getFullYear().toString();
	var mm = (date.getMonth()+1).toString(); // getMonth() is zero-based
    var dd  = date.getDate().toString();
    var min  = date.getMinutes().toString();
    var ss  = date.getSeconds().toString();
    date = yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]) + " " +
    					(min[1]?min:"0"+min[0]) + ":" + (ss[1]?ss:"0"+ss[0]) + ":00"; // padding
    return date;
}
function dateToStr(date, lang, inline, fullMonth){ //work with date formated : yyyy-mm-dd hh:mm:ss ou millisecond

	if(typeof date == "undefined") return;
	if(fullMonth != true) fullMonth = false;

	//mylog.log("convert format date 1", date);
	if(typeof date.sec != "undefined"){
		date = new Date(date.sec);
		date = dateSecToString(date);
	}
	else if(typeof date == "number"){
		date = new Date(date);
		date = dateSecToString(date);
	}
	//mylog.log(date);
	if(lang == "fr"){
		//(year, month, day, hours, minutes, seconds, milliseconds) 
		//mylog.log("convert format date", date);
		var year 	= date.substr(0, 4);
		var month 	= date.substr(5, 2);//getMonthStr(date.substr(5, 2), lang);
		var day 	= date.substr(8, 2);
		var hours 	= date.substr(11, 2);
		var minutes = date.substr(14, 2);
		

		var str = day + "/" + month + "/" + year;

		if(fullMonth) str = day + " " + getMonthStr(month, "fr") + " " + year;


		if(!inline) str += "</br>";
		else str += " - ";
		str += hours + "h" + minutes;
		
		return str;
	}

	function getMonthStr(monthInt, lang){
		if(lang == "fr"){
			if(monthInt == "01") return "Janvier";
			if(monthInt == "02") return "Février";
			if(monthInt == "03") return "Mars";
			if(monthInt == "04") return "Avril";
			if(monthInt == "05") return "Mai";
			if(monthInt == "06") return "Juin";
			if(monthInt == "07") return "Juillet";
			if(monthInt == "08") return "Août";
			if(monthInt == "09") return "Septembre";
			if(monthInt == "10") return "Octobre";
			if(monthInt == "11") return "Novembre";
			if(monthInt == "12") return "Décembre";
		}
	}
}

function getObjectId(object){
	if(object === null) return null;
	if("undefined" != typeof object._id && "undefined" != typeof object._id.$id) 	return object._id.$id.toString();
	if("undefined" != typeof object.id) 	return object.id;
	if("undefined" != typeof object.$id) 	return object.$id;
	return null;
};


function getFullTextCountry(codeCountry){
	var countries = {
		"FR" : "France",
		"RE" : "Réunion",
		"NC" : "Nouvelle-Calédonie",
		"GP" : "Gouadeloupe",
		"GF" : "Guyanne-Française",
		"MQ" : "MartiniqueMQ",
		"PM" : "Saint-Pierre-Et-Miquelon"
	};
	if(typeof countries[codeCountry] != "undefined")
	return countries[codeCountry];
	else return "";
}





var dataHelper = {

	csvToArray : function (csv, separateur, separateurText){
		var lines = csv.split("\n");			
		var result = [];
		$.each(lines, function(key, value){
			if(value.length > 0){
				var colonnes = value.split(separateur);
				var newColonnes = [];
				$.each(colonnes, function(keyCol, valueCol){
					
					if(typeof separateurText == "undefined" || separateurText =="")
						newColonnes.push(valueCol);
					else{
						if(valueCol.charAt(0) == separateurText && valueCol.charAt(valueCol.length-1) == separateurText){
							var elt = valueCol.substr(1,valueCol.length-2);
							newColonnes.push(elt);
						}else{
							newColonnes.push(valueCol);
						}
					}
					
					
				});
				result.push(newColonnes);
			}
			
		});
		return result;
	},

	markdownToHtml : function (str) { 
		var converter = new showdown.Converter();
		var res = converter.makeHtml(str);
		return res;
	},

	convertMardownToHtml : function (text) { 
		var converter = new showdown.Converter();
		return converter.makeHtml(text);
	},


	activateMarkdown : function (elem) { 
		mylog.log("activateMarkdown", elem);

		markdownParams = {
			savable:false,
			iconlibrary:'fa',
			language:'fr',
			onPreview: function(e) {
				var previewContent = "";
				if (e.isDirty()) {
					previewContent = dataHelper.convertMardownToHtml(e.getContent());
				} else {
					previewContent = dataHelper.convertMardownToHtml($(elem).val());
				}
				return previewContent;
			},
			onSave: function(e) {
				mylog.log(e);
			}
		}

		if( !$('script[src="'+baseUrl+'/plugins/bootstrap-markdown/js/bootstrap-markdown.js"]').length ){
			mylog.log("activateMarkdown if");

			$("<link/>", {
			   rel: "stylesheet",
			   type: "text/css",
			   href: baseUrl+"/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css"
			}).appendTo("head");
			$.getScript( baseUrl+"/plugins/showdown/showdown.min.js", function( data, textStatus, jqxhr ) {

				$.getScript( baseUrl+"/plugins/bootstrap-markdown/js/bootstrap-markdown.js", function( data, textStatus, jqxhr ) {
					mylog.log("HERE", elem);

					$.fn.markdown.messages['fr'] = {
						'Bold': trad.Bold,
						'Italic': trad.Italic,
						'Heading': trad.Heading,
						'URL/Link': trad['URL/Link'],
						'Image': trad.Image,
						'List': trad.List,
						'Preview': trad.Preview,
						'strong text': trad['strong text'],
						'emphasized text': trad['strong text'],
						'heading text': trad[''],
						'enter link description here': trad['enter link description here'],
						'Insert Hyperlink': trad['Insert Hyperlink'],
						'enter image description here': trad['enter image description here'],
						'Insert Image Hyperlink': trad['Insert Image Hyperlink'],
						'enter image title here': trad['enter image title here'],
						'list text here': trad['list text here']
					};
					$(elem).markdown(markdownParams);
				});


			});
		} else {
			mylog.log("activateMarkdown else");
			$(elem).markdown(markdownParams);
		}

		$(elem).before(tradDynForm["syntaxmarkdownused"]);
	}

}
