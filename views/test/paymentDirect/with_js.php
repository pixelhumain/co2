<?php

// include MangoPay SDK
//require_once '../../vendor/autoload.php';
require_once 'config.php';

// sample data to demo
$_SESSION['amount'] = 50;
$_SESSION['currency'] = 'EUR';
$_SESSION['cardType'] = 'CB_VISA_MASTERCARD';//or alternatively MAESTRO or DINERS etc

// create instance of MangoPayApi SDK
$mangoPayApi = new \MangoPay\MangoPayApi();
$mangoPayApi->Config->ClientId = Yii::app()->params["mangoPay"]["ClientId"];//MangoPayDemo_ClientId;
$mangoPayApi->Config->ClientPassword = Yii::app()->params["mangoPay"]["ClientPassword"];//MangoPayDemo_ClientPassword;
$mangoPayApi->Config->TemporaryFolder = Yii::app()->params["mangoPay"]["TemporaryFolder"];

// create user for payment
$user = new MangoPay\UserNatural();
$user->FirstName = 'COCO';
$user->LastName = 'Jojo';
$user->Email = 'email@domain.com';
$user->Birthday = time();
$user->Nationality = 'FR';
$user->CountryOfResidence = 'FR';
$user->Occupation = "programmer";
$user->IncomeRange = 3;
$createdUser = $mangoPayApi->Users->Create($user);

// register card
$cardRegister = new \MangoPay\CardRegistration();
$cardRegister->UserId = $createdUser->Id;
$cardRegister->Currency = $_SESSION['currency'];
$cardRegister->CardType = $_SESSION['cardType'];
$createdCardRegister = $mangoPayApi->CardRegistrations->Create($cardRegister);
$_SESSION['cardRegisterId'] = $createdCardRegister->Id;

// build the return URL to capture token response if browser does not support cross-domain Ajax requests
$returnUrl = 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'];
$returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], '/') + 1);
$returnUrl .= 'pay';

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://rawgit.com/Mangopay/cardregistration-js-kit/master/kit/mangopay-kit.min.js"></script><!-- Or add the repo https://github.com/Mangopay/cardregistration-js-kit to your project 
<script src="js/script.js"></script>-->


<script>
    var cardRegistrationURL = "<?php print $createdCardRegister->CardRegistrationURL; ?>";
    var preregistrationData = "<?php print $createdCardRegister->PreregistrationData; ?>";
    var cardRegistrationId = "<?php print $createdCardRegister->Id; ?>";
    var cardType = "<?php print $createdCardRegister->CardType; ?>";
    var accessKey = "<?php print $createdCardRegister->AccessKey; ?>";
    var ajaxUrl = "<?php print $returnUrl; ?>";
    var redirectUrl = "<?php print $returnUrl; ?>";

    console.log({
        cardRegistrationURL : "<?php print $createdCardRegister->CardRegistrationURL; ?>",
        preregistrationData : "<?php print $createdCardRegister->PreregistrationData; ?>",
        cardRegistrationId : "<?php print $createdCardRegister->Id; ?>",
        cardType : "<?php print $createdCardRegister->CardType; ?>",
        accessKey : "<?php print $createdCardRegister->AccessKey; ?>",
        ajaxUrl : "<?php print $returnUrl; ?>",
        redirectUrl : "<?php print $returnUrl; ?>"
    });
    
    mangoPay.cardRegistration.baseURL = "<?php print $mangoPayApi->Config->BaseUrl; ?>";
    mangoPay.cardRegistration.clientId = "<?php print $mangoPayApi->Config->ClientId; ?>";
</script>

<p>
  <i>
    Shows how to register the card using JavaScript Kit <br />
    and process payments asynchronously or with page reload.
  </i>
</p>

<div id ="divForm">
    <label>Full Name</label>
    <label><?php print $createdUser->FirstName . ' ' . $createdUser->LastName; ?></label>
    <br />createdCardRegister->Id : <?php print $createdCardRegister->Id; ?>
    <br />createdUser->Id : <?php print $createdUser->Id; ?>
    <div class="clear"></div>

    <label>Amount</label>
    <label><?php print $_SESSION['amount'] . ' ' . $_SESSION['currency']; ?></label>
    <div class="clear"></div>

    <form id="paymentForm">
        <label for="cardNumber">Card Number</label>
        <input type="text" name="cardNumber" value="" />
        <div class="clear"></div>

        <label for="cardExpirationDate">Expiration Date</label>
        <input type="text" name="cardExpirationDate" value="" />
        <div class="clear"></div>

        <label for="cardCvx">CVV</label>
        <input type="text" name="cardCvx" value="" />
        <div class="clear"></div>
        <br>

        <input type="button" value="Register with Ajax (will fail for non supporting CORS browsers)" id="payAjax" />
        <div class="clear"></div>
        <br>
        
        <input type="button" value="Register with Ajax or redirect if no CORS support" id="payAjaxOrRedirect" />
        <div class="clear"></div>
		<br>
		
        <input type="button" value="Register with redirect and then pay" id="payRedirect" />
        <div class="clear"></div>

    </form>

</div>

<script type="text/javascript">
    
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
</script>
