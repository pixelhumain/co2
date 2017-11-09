$(document).ready(function(){

    // Initialize mangoPay.cardRegistration object
    mangoPay.cardRegistration.init({
        cardRegistrationURL : cardRegistrationURL,
        preregistrationData : preregistrationData,
        accessKey : accessKey,
        Id : cardRegistrationId
    });

    // Action for button "Pay with Ajax"
    $("#payAjax").click(function() {

        // Disable button to prevent double click while waiting
        $("#payAjax").attr("disabled", true).val("Please wait...");

        runCardRegAjax();

    });

    // Action for button "Pay with Ajax or Redirect"
    $("#payAjaxOrRedirect").click(function(){

        // Disable button to prevent double click while waiting
        $("#payAjaxOrRedirect").attr("disabled", true).val("Please wait...");
		
		if(mangoPay.browser.corsSupport()) {
             runCardRegAjax();
             return;
        }
 
        runCardRegReturnUrl();
        
    });

    // Action for button "Pay with Redirect"
    $("#payRedirect").click(function() {
        
       runCardRegReturnUrl();
       
    });
});


function runCardRegAjax() {
	// Collect sensitive card data from the form
    var cardData = getCardData();

    // Process data        
    mangoPay.cardRegistration.registerCard(cardData, 
	    function(res) {
	    	var message = 'Card has been succesfully registered under the Card Id ' + res.CardId + '.<br />';
    	  	message += 'Card is now ready to use e.g. in a «Direct PayIn» Object.';
            $("#divForm").html(message);
        },
	    function(res){ 
        	alert("Error occured while registering the card: " + "ResultCode: " + res.ResultCode + ", ResultMessage: " + res.ResultMessage);
        }
	);
}

function runCardRegReturnUrl() {
	
	var cardData = getCardData();
	
	// Build the form and append to the document
    var form = document.createElement('form');
	form.setAttribute('action', cardRegistrationURL);
	form.setAttribute('method', 'post');
	form.setAttribute('style', 'display: none');
	document.getElementsByTagName('body')[0].appendChild(form);
	
	// Add card registration data to the form
 	form.appendChild(getInputElement('data', preregistrationData));
	form.appendChild(getInputElement('accessKeyRef', accessKey));
	form.appendChild(getInputElement('cardNumber', cardData.cardNumber));
	form.appendChild(getInputElement('cardExpirationDate', cardData.cardExpirationDate));
	form.appendChild(getInputElement('cardCvx', cardData.cardCvx));
	form.appendChild(getInputElement('returnURL', redirectUrl));

    // Submit the form
	form.submit();
}

function getCardData() {
	return {
       cardNumber : $("#paymentForm").find("input[name$='cardNumber']").val(),
       cardExpirationDate : $("#paymentForm").find("input[name$='cardExpirationDate']").val(),
       cardCvx : $("#paymentForm").find("input[name$='cardCvx']").val(),
       cardType : cardType
    };
}

function getInputElement(name, value) {
	var input = document.createElement('input');
	input.setAttribute('type', 'hidden');
	input.setAttribute('name', name);
	input.setAttribute('value', value);
	return input;
}