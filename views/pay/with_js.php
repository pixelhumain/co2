<?php

// build the return URL to capture token response if browser does not support cross-domain Ajax requests
$returnUrl = 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'];
$returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], '/') + 1);
$returnUrl .= 'pay/done';

?>

<script>
    var cardRegistrationURL = "<?php echo $createdCardRegister->CardRegistrationURL; ?>";
    var preregistrationData = "<?php echo $createdCardRegister->PreregistrationData; ?>";
    var cardRegistrationId = "<?php echo $createdCardRegister->Id; ?>";
    var cardType = "<?php echo $createdCardRegister->CardType; ?>";
    var accessKey = "<?php echo $createdCardRegister->AccessKey; ?>";
    var ajaxUrl = "<?php echo $returnUrl; ?>";
    var redirectUrl = "<?php echo $returnUrl; ?>";

    console.log({
        cardRegistrationURL : "<?php echo $createdCardRegister->CardRegistrationURL; ?>",
        preregistrationData : "<?php echo $createdCardRegister->PreregistrationData; ?>",
        cardRegistrationId : "<?php echo $createdCardRegister->Id; ?>",
        cardType : "<?php echo $createdCardRegister->CardType; ?>",
        accessKey : "<?php echo $createdCardRegister->AccessKey; ?>",
        ajaxUrl : "<?php echo $returnUrl; ?>",
        redirectUrl : "<?php echo $returnUrl; ?>"
    });
    
    mangoPay.cardRegistration.baseURL = "<?php echo $api->Config->BaseUrl; ?>";
    mangoPay.cardRegistration.clientId = "<?php echo $api->Config->ClientId; ?>";
</script>


<div id ="divForm">
    
    <div class="hide">
        <label>Full Name</label>
        <label><?php print $createdUser->FirstName . ' ' . $createdUser->LastName; ?></label>
        <br />createdCardRegister->Id : <?php print $createdCardRegister->Id; ?>
        <br />createdUser->Id : <?php 
        print $createdUser->Id; 
        $cbImgs = array(
            "CB_VISA_MASTERCARD" => "visaMaster.png",
            "MAESTRO" => "maestro.png",
            "DINERS" => "diners.jpg"
        );
        ?>
    </div>
    <div class="clear"></div>

    <label>Amount</label>
    <label><?php print $amount . ' ' . $currency; ?></label>
    <div class="clear"></div>
    
    <div class="col-md-6">
    <img src="<?php echo Yii::app()->controller->module->assetsUrl?>/images/pay/<?php echo $cbImgs[$createdCardRegister->CardType]?>" width=150/>
    </div>
    <div class="col-md-6">
        <form id="paymentForm">
            <label for="cardNumber">Card Number</label>
            <input type="text" name="cardNumber" value="4706750000000009" />
            <div class="clear"></div>

            <label for="cardExpirationDate">Expiration Date</label>
            <input type="text" name="cardExpirationDate" value="0118" />
            <div class="clear"></div>

            <label for="cardCvx">CVV</label>
            <input type="text" name="cardCvx" value="123" />
            <div class="clear"></div>
            <br>

            <input type="button" value="Register with Ajax (will fail for non supporting CORS browsers)" id="payAjax" />
            <div class="clear"></div>
            <br>
            <?php /*
            <input type="button" value="Register with Ajax or redirect if no CORS support" id="payAjaxOrRedirect" />
            <div class="clear"></div>
    		<br>
    		
            <input type="button" value="Register with redirect and then pay" id="payRedirect" />
            <div class="clear"></div>
            */?>
        </form>
    </div>

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
            message += 'Card is now ready to use e.g. in a «Direct PayIn» Object.<br/>';
            message += '<a  class="btn btn-success" href="javascript:payin(' + res.CardId + ')">«PayIn» Object</a>.';
            ;
            $("#divForm").html(message);
        },
        function(res){ 
            alert("Error occured while registering the card: " + "ResultCode: " + res.ResultCode + ", ResultMessage: " + res.ResultMessage);
        }
    );
}
function payin (cardId) { 
    var params = {
        cardId : cardId,
        obj : shopping.checkoutObj,
        currency : "EUR"
    };
    ajaxPost( "#checkoutCart", baseUrl+"/"+moduleId+'/pay/in' , params, function() { 
        //alert("return from payin");
     } , "html" );

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
