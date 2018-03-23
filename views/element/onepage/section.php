<?php foreach (@$element["onepageEdition"] as $sectionK => $val) {
            if(@$val["beforeSection"] == "#".$sectionKey){
                //echo "need to show free section : " . $sectionK;
                $desc = @$val["items"];   // array( array("shortDescription"=>@$val["description"],
                                                //"useMarkdown"=>@$val["useMarkdown"]), );

                $this->renderPartial('../element/onepage/section', 
                                    array(  "element" => $element,
                                            "items" => @$desc,
                                            "sectionKey" => substr($sectionK, 1, strlen($sectionK)),
                                            "sectionTitle" => @$val["title"],
                                            "sectionShadow" => true,
                                            "msgNoItem" => "",
                                            "imgShape" => "square",
                                            "edit" => $edit,
                                            "useImg" => false,
                                            //"fullWidth" => true, //only for 1 element
                                            "useBorderElement"=>$useBorderElement,

                                            "styleParams" => array( "bgColor"=>"#FFF",
                                                                    "textBright"=>"dark",
                                                                    "fontScale"=>3),
                                            ));
            }
      } 
?>

<?php 
    //echo $sectionKey." "; var_dump(@$element["onepageEdition"]["#".@$sectionKey]); exit;
    if(@$element["onepageEdition"]["#".@$sectionKey]["hidden"] == "true" && @$edit == false) return;

    $nbMax = @$nbMax ? $nbMax : 12;

    $imgDefault = $this->module->assetsUrl.'/images/news/profile_default_l.png';

    $nbItem = sizeof($items);
    $col = "col-sm-2 col-xs-4";

    if($nbItem == 1) $col = "col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12";
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

        .popup-conf-delete-section{
            display: none;
        }

        input.title-new-sec{
            text-transform: uppercase;
            font-weight: bold;
            font-size:16px;
        }
</style>

<?php if(@$edit==true && @$sectionKey != "description"){ ?>
    <div class="col-xs-12 text-center no-padding ctn-new-sec">
        <button class="btn btn-link bg-white text-dark btn-create-section shadow2"
                data-section-before="<?php echo @$sectionKey; ?>">
            <i class="fa fa-plus"></i> Ajouter section ici
        </button>
        <section class="portfolio new-section margin-top-15 bg-white <?php if(@$sectionShadow==true) echo 'shadow'; ?> 
                        new-section-before-<?php echo @$sectionKey; ?>"
                        data-section-before="<?php echo @$sectionKey; ?>">
            <div class="row">
            <div class="col-xs-12 col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6 padding-15">
                <h5><i class="fa fa-plus"></i> Nouvelle section</h5>

                <hr>
                <input type="text" class="form-input col-xs-12 title-new-sec font-montserrat margin-bottom-15" 
                        placeholder="Titre de la section">

                <div class="md-ctn font-montserrat">
                    <textarea class="markdown-desc-new-sec" id="MD-desc-new-sec-<?php echo @$sectionKey; ?>"></textarea>
                </div>

                <div class="col-xs-12 padding-15">
                    <button class="btn btn-link btn-save-new-section bg-green-k pull-right"
                            id="btn-save-new-section-<?php echo @$sectionKey; ?>"
                            data-section-before="<?php echo @$sectionKey; ?>"
                            data-new-section-key="free-section">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                    <button class="btn btn-link btn-cancel-new-section pull-right letter-red"
                            data-section-before="<?php echo @$sectionKey; ?>">
                        Annuler
                    </button>
                </div>
            </div>
            </div>
        </section>
    </div>
<?php } ?>

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
                                    array(  "element" => $element,
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

        <?php if(@$sectionTitle != ""){ ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">
                    <span class="sec-title"><?php echo $sectionTitle; ?></span> 
                    <?php if(@count($items) >= 2) echo "<small>(".@count($items).")</small>"; ?>

                </h2>
                <?php if($freeSec == "free-section" && @$edit==true){ ?> <br>
                    <button class="btn btn-link text-dark bg-white btn-xs btn-tool-free-sec">
                        <i class="fa fa-plus-circle"></i> Ajouter un paragraphe
                    </button>
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
    		foreach ($items as $key => $item) { $cnt++; 
    		  	if($cnt<=$nbMax){
                    
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
                        <button class="btn btn-link text-dark bg-white btn-xs btn-tool-free-sec">
                            <i class="fa fa-pencil"></i> Editer
                        </button>
                        <hr>
                    <?php } ?> 

                    <?php if($nbItem <= 4 && (!isset($useDesc) || @$useDesc == true)){ ?>
                        <?php if(@$item["useMarkdown"]==true){ ?>
                            <span id="descMarkdown<?php echo $sectionKey; ?>" 
                                  data-item="<?php echo $key; ?>"
                                  data-key="<?php echo $sectionKey; ?>" 
                                  name="descriptionMarkdown" 
                                  class="descriptionMarkdown hidden"
                                  ><?php echo (!empty(@$item['shortDescription'])) ? @$item['shortDescription'] : ""; ?></span>
                        <?php } ?>
                        <div class="col-md-12 col-sm-12 no-padding item-desc  <?php if(@$fullWidth && @$fullWidth == true) echo "text-left"; ?>">
                            <?php echo @$item['shortDescription'] ? @$item['shortDescription'] :
                                        "<span class='padding-10'><center><i>- Pas de présentation -</center></i></span>"; ?>
                            
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