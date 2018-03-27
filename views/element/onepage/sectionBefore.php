<?php if(@$element["onepageEdition"])
        foreach (@$element["onepageEdition"] as $sectionK => $val) {
            if(@$val["beforeSection"] == "#".$sectionKey){
                $desc = @$val["items"];   
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
                                            "isGallery" => @$val["isGallery"],
                                            "useBorderElement"=>$useBorderElement,

                                            "styleParams" => array( "bgColor"=>"#FFF",
                                                                    "textBright"=>"dark",
                                                                    "fontScale"=>3),
                                            ));
            }
      } 
?>