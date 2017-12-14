<?php
if (isset($_GET['mode'])){
    if ($_GET['mode'] == 'nonJS') {
        include "non_js.php";
    } elseif($_GET['mode'] == 'JS') {
        include "with_js.php";
    }
}
?>
