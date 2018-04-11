
<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath , 
                                "page" => "web",
                            )
                        );
    $cssAnsScriptFiles = array(
    '/assets/css/circle.css',
    '/assets/js/web.js',
    '/assets/css/profilSocial.css',
    '/assets/css/default/directory.css',
    '/assets/css/web.css'
    );
    HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl); 
    
    $paramsApp = CO2::getThemeParams();
?>

<style>
    <?php 
        $btnAnc = array("blue"      =>array("color1"=>"#4285f4", 
                                            "color2"=>"#1c6df5"));
    ?>

    <?php foreach($btnAnc as $color => $params){ ?>
    .btn-anc-color-<?php echo $color; ?>{
        background-color: <?php echo $params["color1"]; ?>;
        border-color: <?php echo $params["color1"]; ?>!important;
        color: #fff!important;
    }

    .btn-anc-color-<?php echo $color; ?>:hover{
        background-color: <?php echo $params["color2"]; ?>!important;
        border-color: <?php echo $params["color1"]; ?>!important;
    }
    .btn-anc-color-<?php echo $color; ?>.active{ 
        background-color:#fff!important;
        color:<?php echo $params["color1"]; ?>!important;
    }
    .btn-anc-color-<?php echo $color; ?>.active:hover{
        background-color: #fff;
        color: <?php echo $params["color1"]; ?>;
    }
    <?php } ?>

    #filters-container{
        display: none !important;
    }

    /*.subModuleTitle{
        width:50%;
        margin-left:25%;
    }
    #main-input-group,
    #filters-menu-new{
        margin: 0px;
        width:100%;
    }
*/
    #filter-scopes-menu,
    #filter-thematic-menu{
        display: none!important;
    }

    #main-input-group{
        width:76%;
    }

    #resUrl .entityCenter{
        width:85% !important;
    }
    #resUrl .searchEntity{
        margin-left:-48px !important;
    }
    @media (min-width: 1300px) {
        .subModuleTitle{
            width: 56%;
            margin-left: 28%;
        }
    }

    @media screen and (max-width: 767px) {   
            #main-input-group{
                width:100%;
            }
    }
</style>


<?php 
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    $this->renderPartial('admin/modalEditUrl',  array( ) ); 
    //var_dump($myWebFavorites);
    $this->renderPartial($layoutPath.'modals.kgougle.favorites',  array("myWebFavorites"=>@$myWebFavorites ) ); 
?>

<button class="hidden btn letter-red btn-link font-montserrat dropdown-toggle" data-toggle="dropdown" id="btn-onepage-main-menu">
     <i class='fa fa-angle-right'></i> A propos


</button>

<section class="padding-top-10 text-center margin-bottom-10 hidden-xs" id="section-fav">
    <?php if(false){ ?>
    <a href="#media" target="_blank" class="tooltips btn-fast-access" data-placement="bottom" data-toggle="tooltip" 
       title="Aller sur KgougleActu"><i class="fa fa-newspaper-o fa-2 padding-10 text-dark"></i></a> 
    <?php } ?>

    <?php if(!empty($myWebFavorites)){ ?>
    <i class="fa fa-ellipsis-v btn-fast-access padding-10 letter-yellow hidden-xs hidden"></i>
    <?php } ?>   

    <?php if(false){ ?>
    <a href="https://www.youtube.com" target="_blank" class="tooltips btn-fast-access" 
        data-placement="bottom" data-toggle="tooltip" title="Aller sur YouTube">
        <i class="fa fa-youtube-play padding-10 letter-red"></i>
    </a> 
    <a href="https://www.facebook.com/" target="_blank" class="tooltips btn-fast-access"
        data-placement="bottom" data-toggle="tooltip" title="Aller sur Facebook">
        <i class="fa fa-facebook-square padding-10 letter-blue"></i>
    </a>
    <a href="https://fr.wikipedia.org/w/index.php?search=&title=Sp%C3%A9cial%3ARecherche&go=Lire" 
        target="_blank" class="tooltips btn-fast-access" style="font-size: 19px;"
        data-placement="bottom" data-toggle="tooltip" title="Aller sur Wikipedia">
        <i class="fa fa-wikipedia-w padding-10"></i>
    </a>
    <?php } ?>   
   
    <?php if(!empty($myWebFavorites)){ ?>
       <i class="fa fa-ellipsis-v btn-fast-access padding-10 letter-yellow hidden-xs hidden"></i>
        <?php  
            foreach ($myWebFavorites as $key => $siteurl) { 
                if(@$siteurl["favicon"]){ 
                    //$file_headers = @get_headers($siteurl["favicon"]);
                    //echo $siteurl["favicon"]."-".$file_headers[0];
                   // if($file_headers[0] == "HTTP/1.1 200 OK") {
        ?>
            <a class="siteurl_title letter-blue elipsis tooltips" target="_blank" href="<?php echo $siteurl["url"]; ?>"
                data-placement="bottom" data-toggle="tooltip" title="<?php echo $siteurl["title"]; ?>">
                    <img src='<?php echo $siteurl["favicon"]; ?>' alt="o" height=22 class="margin-right-5" style="margin:0 14px;margin-top:4px;" alt="">
            </a>
                
        <?php   }//}
            } 
        ?>

        <i class="fa fa-ellipsis-v btn-fast-access padding-10 letter-yellow pull-right" style='margin-left:-10px;'></i>
        <button class="btn btn-link tooltips pull-right no-padding" data-placement="bottom" title="Afficher vos favoris"
           data-target="#modalFavorites" data-toggle="modal">
            <i class="fa fa-star btn-fast-access padding-10 letter-yellow" style="font-size: 18px;margin-top: 3px;"></i>
        </button>
    
    <?php } ?>
</section>

<section class="no-padding hidden" id="sectionSearchResults">
    <div class="row padding-10">
        <div class="col-md-1 hidden-sm col-lg-1 text-right" id="sub-menu-left"></div>
        <div class="col-md-4 col-sm-4 col-lg-3 col-xs-12 text-left padding-25 pull-right" id="sub-menu-right"></div>
        <div class="col-md-7 col-sm-8 col-lg-7 pull-left" id="searchResults"></div>
    </div>
</section>

<div id="mainCategories" class="padding-bottom-50"></div>

<?php $this->renderPartial($layoutPath.'footer.'.Yii::app()->params["CO2DomainName"], array("subdomain"=>"web")); ?>

<script type="text/javascript" >

var currentCategory = "";
var titlePage = "<?php echo Yii::app()->params["CO2DomainName"]=="kgougle" ? "Kgougle" : @$paramsApp["pages"]["#web"]["subdomainName"]; ?>";

jQuery(document).ready(function() {
    initKInterface({"affixTop":250});
    initWebInterface();
    buildListCategories();
    
    location.hash = "#web";
    setTitle(titlePage, "", titlePage);
});



</script>