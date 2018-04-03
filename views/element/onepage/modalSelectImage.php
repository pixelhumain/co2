<style type="text/css">
    #modalSelectImgNewSection .modal-body {
        display: inline-block;
        width: 100%;
    }
    
    #modalSelectImgNewSection{
        top:100px;
        z-index: 2;
    }
    #modalSelectImgNewSection .select-photo img.img-responsive{
        height:115px;
        width:100%;
        border:2px solid transparent;
    }
    #modalSelectImgNewSection .select-photo .btn-select-img-new-section:hover img.img-responsive,
    #modalSelectImgNewSection .select-photo .ctn-img.selected img.img-responsive{
        border:4px solid #4285f4;
    }


    #modalSelectImgNewSection .select-photo .fa-check{
        position: absolute;
        top:38%;
        left:38%;
        border-radius: 40px;
        padding:10px;
        display: none;
    }

    #modalSelectImgNewSection .select-photo .ctn-img.selected .fa-check{
        display: inline;
    }


    #modalSelectImgNewSection .select-photo{
        max-height:353px;
        overflow-y: auto;
    }
</style>

<div class="modal fade" tabindex="-1" role="dialog" id="modalSelectImgNewSection">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-title" id="modalText">
            <h4 class="pull-left"><i class="fa fa-picture-o"></i> Sélectionner une image</h4>
            <button class="btn btn-link bg-blue-k pull-right margin-right-15" onclick="dyFObj.openForm('addPhoto')">
                <i class="fa fa-upload"></i> Télécharger une image
            </button>
        </div>
      </div>
      <div class="modal-body">
        <?php 
            $folder = @$element["type"]."/".@$element["_id"]; 
            $myPhotos = Document::getWhere(array("folder"=>new MongoRegex("/.*{$folder}.*/i")));
            
            $myPhotos = PHDB::findAndSort( Document::COLLECTION,
                                            array("folder"=>new MongoRegex("/.*{$folder}.*/i"),
                                                  "doctype" => "image"), array("created"=>-1));
            $myAlbums = @$element["documents"]["image"];

           // var_dump($myAlbums); echo "<br><br>";
           // var_dump($myPhotos);
        ?>
        <div class="col-xs-12 select-gallery hidden">
            <?php //foreach ($myAlbums as $name => $album) { ?>
                <!-- <button class="btn btn-link"><i class="fa fa-folder"></i> <?php //echo $name; ?></button><br> -->
            <?php //} ?>
        </div>
        <div class="col-xs-12 select-photo">
            <?php foreach ($myPhotos as $key => $photo) { ?>
                <?php $imagePath = Yii::app()->baseUrl."/".Yii::app()->params['uploadUrl'].
                                   $photo["moduleId"]."/".$photo["folder"]; 

                    $imageSavePath = $imagePath."/".$photo["name"];
                    if($photo["contentKey"]=="profil")
                         $imagePath .= "/".Document::GENERATED_MEDIUM_FOLDER;
                    else $imagePath .= "/".Document::GENERATED_IMAGES_FOLDER;

                    $imagePath .= "/".$photo["name"];
                ?>
                <button class="btn btn-link btn-select-img-new-section col-xs-4 col-sm-2 col-md-2 col-lg-2 
                        no-padding ctn-img"
                        data-img-path="<?php echo $imageSavePath; ?>"
                        data-section-before="">                     
                    <img src="<?php echo $imagePath; ?>" class="img-responsive">
                    <i class="fa fa-check bg-blue-k"></i>
                </button>
            <?php } ?>
        </div>
      </div>
      <div class="modal-footer">
        <div id="modalAction" style="display:inline"></div>
        <button class="btn btn-link bg-green-k pull-right btn-sm margin-top-10" 
                id="btn-delete-room" data-placement="bottom" 
                data-dismiss="modal"
                data-id-room="">
            <i class="fa fa-check"></i> Valider
        </button>
        <button class="btn btn-link letter-red pull-right btn-sm margin-top-10 margin-right-10" id="btn-cancel" data-dismiss="modal"> Annuler</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->