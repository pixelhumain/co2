
<?php $this->renderPartial('../element/onepage/sectionBefore', 
                                    array(  "element" => @$element,
                                            "edit" => @$edit,
                                            "sectionKey" => @$sectionKey,
                                            "useBorderElement" => @$useBorderElement));
?>

<?php 
    //echo $sectionKey." "; var_dump(@$element["onepageEdition"]["#".@$sectionKey]); exit;
    if(@$element["onepageEdition"]["#".@$sectionKey]["hidden"] == "true" && @$edit == false) return;

    $nbMax = @$nbMax ? $nbMax : 12;

    $imgDefault = $this->module->assetsUrl.'/images/thumbnail-default.jpg';

    $nbItem = sizeof($items);
    $col = "col-sm-2 col-xs-4";

    if($nbItem == 1) $col = "col-lg-offset-2 col-lg-8 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12";
    if(@$fullWidth && @$fullWidth == true) $col = "col-md-12";

    if($nbItem == 2) $col = "col-sm-6";
    if($nbItem == 3) $col = "col-sm-4 col-xs-4";
    if($nbItem == 4) $col = "col-sm-3 col-xs-3";
    if($nbItem == 5) $col = "col-sm-2 col-xs-4";
    if($nbItem == 6) $col = "col-sm-2 col-xs-4";
    if($nbItem >  6) $col = "col-sm-1 col-xs-4";

    $align = $nbItem > 2 && $imgShape == "square" ? "left" : "center";
    $align = "center";
    //$textBright = @$styleParams["textBright"] ? @$styleParams["textBright"] : "light";

?>

<style>

        <?php if($nbItem >=  8){ ?>
        #onepage section#<?php echo @$sectionKey; ?> .portfolio-item .item-name,
        #onepage section#<?php echo @$sectionKey; ?> .portfolio-item .item-desc,
        #onepage section#<?php echo @$sectionKey; ?> .portfolio-item .item-address{
            font-size:0.9em;
        }
        <?php } ?>
        .portfolio.new-section{
            display: none;
            margin-top: -20px !important;
        }
        .ctn-new-sec{
            margin-bottom: 40px;
        }
        .portfolio.new-section .md-ctn{
            font-size: 12px;
        }
        .portfolio.new-section .md-editor{
            margin-top:10px;
        }

        .popup-conf-delete-section,
        .popup-conf-delete-item,
        .btn-cancel-gallery,
        .btn-cancel-image{
            display: none;
        }

        .item-desc img{
            max-width: 100%!important;
        }

        .img-section{
            max-height: 300px;
        }

        input.title-new-sec{
            text-transform: uppercase;
            font-weight: bold;
            font-size:16px;
        }

</style>

<?php $this->renderPartial('../element/onepage/createFreeSection', 
                                    array(  "sectionShadow" => @$sectionShadow,
                                            "edit" => @$edit,
                                            "element" => $element,
                                            "sectionKey" => @$sectionKey));
?>

<?php 
    //var_dump(strpos( @$sectionKey, "free-section-"));
    $freeSec = (strpos(@$sectionKey, "free-section-") !== false) ? "free-section" : ""; ?>

<section id="<?php echo @$sectionKey; ?>" 
         class="portfolio <?php if(@$sectionShadow==true) echo 'shadow'; ?> <?php echo @$freeSec; ?>">
    
    <?php if(@$edit==true){ ?>
        <button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-edit-section" 
                data-id="#<?php echo @$sectionKey; ?>">
                <i class="fa fa-cog"></i>
        </button>

        <?php $this->renderPartial('../element/onepage/btnShowHide', 
                                    array(  "sectionShadow" => @$sectionShadow,
                                            "sectionKey" => @$sectionKey));
        ?>

        <?php if(@$freeSec=="free-section"){ ?>
            <button class="btn btn-default btn-sm pull-right margin-right-15 hidden-xs btn-delete-free-section" 
                    data-section-key="<?php echo @$sectionKey; ?>">
                    <i class="fa fa-trash"></i>
            </button><br>
            <div class="pull-right popup-conf-delete-section text-right bg-white letter-orange padding-15 shadow2 bold radius-15 margin-right-15" id="popup-conf-delete-section-<?php echo @$sectionKey; ?>">
                <span class=" pull-right">Voulez-vous vraiment supprimer cette section ?</span>
                <br><hr class="margin-5">
                <button class="btn btn-link margin-top-5 bg-red btn-cancel-delete-free-section"                     
                        data-section-key="<?php echo @$sectionKey; ?>">Non</button>
                <button class="btn btn-link margin-top-5 bg-green-k btn-conf-delete-free-section"                      
                        data-section-key="#<?php echo @$sectionKey; ?>">Oui</button>
            </div>
        <?php } ?>
    <?php } ?>

    <div class="container">

        <?php if(@$sectionTitle != "" || @$edit==true){ ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">
                    <span class="sec-title"><?php echo $sectionTitle; ?></span> 
                    <?php if(@count($items) >= 2 && @$sectionTitle != "") echo "<small>(".@count($items).")</small>"; ?>

                </h2>
                <?php if($freeSec == "free-section" && @$edit==true && @$isGallery != "true"){ ?> <br>
                    <button class="btn btn-link btn-create-item text-dark bg-white btn-xs btn-tool-free-sec"
                            data-section-key="<?php echo @$sectionKey; ?>">
                        <i class="fa fa-plus-circle"></i> Ajouter un paragraphe
                    </button>
                    <div class="ctn-tool-create-item"></div>
                    <br>
                <?php } ?> 
                <h2>
                    <i class="fa fa-angle-down"></i>
                </h2>
            </div>
        </div>
        <?php } ?>

        <div class="row">
    	<?php $cnt=0; 
            if(!empty($items))
    		foreach ($items as $key => $item) { $cnt++; 
    		  	if($cnt<=$nbMax){
                    
                    if(@$item["galleryName"]!="" && sizeof($items)==1) $col="col-xs-12";
                    //récupération du type de l'element
                    $typeItem = (@$item["typeSig"] && $item["typeSig"] != "") ? $item["typeSig"] : "";
                    if($typeItem == "") $typeItem = @$item["type"] ? $item["type"] : "item";
                    if($typeItem == "people") $typeItem = "citoyens";

                    //icon et couleur de l'element
                    $icon = Element::getFaIcon($typeItem) ? Element::getFaIcon($typeItem) : "";
                    $iconColor = Element::getColorIcon($typeItem) ? Element::getColorIcon($typeItem) : "";
    	?>
    		<div class="<?php echo $col; ?> portfolio-item item-<?php echo $key; ?> text-<?php echo $align; ?>">

                <?php if($typeItem != "item"){ ?>
                <?php $lbh = @$item["type"] == Ressource::COLLECTION || 
                             @$item["type"] == Classified::COLLECTION ? 
                             "lbh-preview-element" : "lbh"; ?>
                <a href="<?php echo Element::getHash($item); ?>" 
                   class="portfolio-link <?php echo $lbh; ?>" data-toggle="modal">
                <?php }else{ ?><div class=""><?php } ?>
                    
                    <?php if(!isset($useImg) || @$useImg == true){ 
                        $img =  @$item['profilThumbImageUrl'] ? 
                                Yii::app()->createUrl('/'.@$item['profilThumbImageUrl']) : 
                                $imgDefault;
                    ?>
                        <img src="<?php echo $img; ?>" 
                        	 class="img-responsive thumbnail img-<?php echo $imgShape; ?> 
                                    <?php if(@$useBorderElement==true){ ?>
                                            thumb-type-color-<?php echo $iconColor; ?><?php } ?> inline"
                             width=80 height=80 alt=""><br>
                    <?php } ?>

                    <?php if(@$useBorderElement==true && $icon != "" && $iconColor != ""){ ?>
                        <div class="col-md-12 col-sm-12 no-padding text-center i-item">
                            <i class="fa fa-<?php echo $icon; ?> i-type-color-<?php echo $iconColor; ?>"></i>
                        </div>
                    <?php } ?>

                    <?php if(@$item['startDate']){ ?>
                        <div class="col-md-12 col-sm-12 no-padding text-center bold item-date">
                            <h5><?php echo Translate::pastTime(@$item['startDate'], "date"); ?></h5>
                        </div>
                    <?php } ?>

                    <div class="col-md-12 col-sm-12 no-padding item-name"><?php echo @$item['name']; ?></div>


                    <?php if(@$item['price']){ ?>
                        <div class="col-md-12 col-sm-12 no-padding text-center">
                            <?php if(@$item["description"]){ ?>
                                <span class="item-desc">
                                    <?php echo $item["description"]; ?>
                                </span><br><br>
                            <?php } ?>
                            <span class="badge padding-10 bold bg-white shadow2 letter-green">
                                <h5 class="no-margin"><?php echo $item["price"]; ?> <?php echo $item["devise"]; ?></h5 class="no-margin">
                            </span>
                        </div>
                    <?php } ?>

                    <?php if($nbItem <= $nbMax){ ?>
                        <div class="col-md-12 col-sm-12 no-padding item-address text-red">
                            <?php  echo @$item['address']['addressLocality'] ?  
                                        '<i class="fa fa-map-marker"></i> '.$item['address']['addressLocality'] : ""; 
                                  echo @$item['address']['streetAddress'] ?  
                                        ' '.$item['address']['streetAddress'] : ""; 

                            ?>
                        </div>
                        </a>
                    <?php } ?>

                    <?php if($freeSec == "free-section" && @$edit==true){ ?> 
                        <button class="btn btn-link text-dark bg-white btn-xs btn-edit-item btn-tool-free-sec"
                                data-item-key="<?php echo $key; ?>"
                                data-section-key="<?php echo $sectionKey; ?>" >
                            <i class="fa fa-pencil"></i> Editer
                        </button>
                        <button class="btn btn-link text-dark bg-white btn-xs btn-delete-item btn-tool-free-sec"
                                data-item-key="<?php echo $key; ?>"
                                data-section-key="<?php echo $sectionKey; ?>" >
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="popup-conf-delete-item text-center margin-top-15 margin-bottom-15 bg-white letter-orange padding-15 shadow2 bold radius-15 margin-right-15" id="popup-conf-delete-item-<?php echo @$sectionKey; ?>-<?php echo @$key; ?>">
                            <span class="">Voulez-vous vraiment supprimer ce paragraphe ?</span>
                            <br><hr class="margin-5">
                            <button class="btn btn-link margin-top-5 bg-red btn-cancel-delete-item"  
                                    data-item-key="<?php echo $key; ?>"
                                    data-section-key="<?php echo $sectionKey; ?>" >Non
                            </button>
                            <button class="btn btn-link margin-top-5 bg-green-k btn-conf-delete-item"    
                                    data-item-key="<?php echo $key; ?>"
                                    data-section-key="<?php echo $sectionKey; ?>" >Oui
                            </button>
                        </div>
                        <hr>
                    <?php } ?> 

                    <div class="col-xs-12 margin-top-15 no-padding text-center">

                        <a class="thumb-info" href="<?php echo @$item['imgPath']; ?>" data-lightbox="all">
                         <img class="img-responsive img-section" src="<?php echo @$item['imgPath']; ?>">
                        </a>
                         <?php if(@$item['imgPath'] && @$item['imgPath']!=""){ ?><br><br><?php } ?>

                         <?php if(@$item['galleryName'] && @$item['galleryName']!=""){ 
                                $folder = @$element["type"]."/".@$element["_id"]; 
                                $photoGallery = PHDB::findAndSort( Document::COLLECTION,
                                                                array("folder"=>new MongoRegex("/.*{$folder}.*/i"),
                                                                      "collection"=>$item['galleryName'],
                                                                      "doctype" => "image"), array("created"=>-1));
                        ?>
                            <div class="col-xs-12 margin-bottom-25">
                                <?php foreach ($photoGallery as $kk => $photo) { 
                                        $imagePath = Yii::app()->baseUrl."/".Yii::app()->params['uploadUrl'].
                                        $photo["moduleId"]."/".$photo["folder"]; 

                                        $imageSavePath = $imagePath."/".$photo["name"];
                                        if($photo["contentKey"]=="profil")
                                             $imagePath .= "/".Document::GENERATED_MEDIUM_FOLDER;
                                        else $imagePath .= "/".Document::GENERATED_IMAGES_FOLDER;

                                        $imagePath .= "/".$photo["name"];
                                ?>
                                    <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 padding-5 ctn-img">    
                                        <a class="thumb-info" href="<?php echo $imageSavePath; ?>" data-lightbox="all">          
                                            <img src="<?php echo $imagePath; ?>" class="img-responsive">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>

                         <?php } ?>
                    </div>

                    <?php if($nbItem <= 4 && (!isset($useDesc) || @$useDesc == true)){ ?>
                        <?php if(@$item["useMarkdown"]==true){ ?>
                            <span id="descriptionMarkdown<?php if($sectionKey != "description") echo $sectionKey."-".$key; ?>" 
                                  data-item="<?php echo $key; ?>"
                                  data-key="<?php echo $sectionKey; ?>" 
                                  name="descriptionMarkdown" 
                                  class="descriptionMarkdown hidden"
                                  ><?php echo (!empty(@$item['shortDescription'])) ? @$item['shortDescription'] : ""; ?></span>
                        <?php } ?>
                        <div class="col-md-12 col-sm-12 no-padding item-desc  <?php if(@$fullWidth && @$fullWidth == true) echo "text-left"; ?>">
                            <?php echo @$item['shortDescription'] ? @$item['shortDescription'] : ""; ?>
                            
                        </div>
                        <?php if($sectionKey == "description" && @$item['shortDescription']){ ?>
                            <div class="col-xs-12 margin-top-15 no-padding text-center">
                                 <button class="btn btn-default btn-full-desc" data-sectionkey="<?php echo @$sectionKey; ?>">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        <?php } ?>
                    <?php } ?>

                <?php if($typeItem != "item"){ ?>
                </a> <?php }else{ ?> </div> <?php } ?>

            </div>
    	<?php }} ?>

    	<?php if($cnt == 0){ ?>
    		<h5 class="text-light text-center"><?php echo $msgNoItem; ?></h5>
    	<?php } ?>

        </div>
        
    </div>
</section>

<script type="text/javascript" >
    
    jQuery(document).ready(function() {

    });
    
</script>