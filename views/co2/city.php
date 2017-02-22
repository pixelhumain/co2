
<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "city",
                            )
                        );
    $cssAnsScriptFiles = array(
        '/css/news/index.css',  
        '/css/timeline2.css',
        '/js/comments.js',        
    
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl. '/assets'); 

?>

<style>
   #city-main-container{
    padding-top:80px;
    display: inline-block;
   }
   .cityHeadSection {
        position: absolute;
        min-height: 500px !important;
        width: 100%;
    }
    .btn-discover{
        color:white;
    }

</style>

<div class="bg-white" id="city-main-container"></div>

<?php $this->renderPartial($layoutPath.'footer',  array( "subdomain"=>"web" ) ); ?>

<script type="text/javascript" >

var insee = "<?php echo @$insee; ?>";
var postalCode = "<?php echo @$postalCode; ?>";

jQuery(document).ready(function() {
    initKInterface();
    
    getAjax("#city-main-container" ,baseUrl+'/'+moduleId+"/city/detail/insee/"+insee+"/postalCode/"+postalCode,function(data){ 
        //alert("yeh");
        //$(idres).html(data);
    },"html");

    //location.hash = "#co2.web";
});

</script>