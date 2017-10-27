<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Payment Direct - demo</title>
        <style>
            label {
                    display: block;
                    width: 130px;
                    float: left;
            }
            div.clear {
                    clear: both;
                    height: 10px;
            }
            input[type=submit], input[type=button] {
                    /*width: 200px;
                    margin-left: 85px;*/
            }
        </style>
        
    </head>
    <body style="margin: 10px;">
        <a href="?mode=JS">Using JavaScript Kit</a> &nbsp;&nbsp;&nbsp;
        <a href="?mode=nonJS">Without JavaScript</a>
        <br />
        
        <?php
        if (isset($_GET['mode'])){
            if ($_GET['mode'] == 'nonJS') {
                print '<h1>Without JavaSctipt</h1>';
                include "non_js.php";
            } elseif($_GET['mode'] == 'JS') {
                print '<h1>Using JavaSctipt Kit</h1>';
                include "with_js.php";
            }
        }
        ?>
    </body>
</html>
