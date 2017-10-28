
<?php $moduleId = Yii::app()->controller->module->id; ?>

<script type="text/javascript">
var listRoomTypes = <?php echo json_encode($listRoomTypes)?>;


function getUrls(){
    var urls = [];
    $.each($('.addmultifield'), function() {
        urls.push( $(this).val() );
    });
    return urls;
}

function getRandomInt (min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


</script>
