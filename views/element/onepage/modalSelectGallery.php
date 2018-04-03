<style type="text/css">

    #modalSelectGalleryNewSection .modal-body {
        display: inline-block;
        width: 100%;
    }

    #modalSelectGalleryNewSection{
        top:100px;
        z-index: 2;
    }
    #modalSelectGalleryNewSection .select-photo img.img-responsive{
        height:115px;
        width:100%;
        border:2px solid transparent;
    }


    #modalSelectGalleryNewSection .select-photo .fa-check{
        position: absolute;
        top:38%;
        left:38%;
        border-radius: 40px;
        padding:10px;
        display: none;
    }

    #modalSelectGalleryNewSection .select-photo{
        max-height:353px;
        overflow-y: auto;
    }

    #modalSelectGalleryNewSection .folder-name{
        font-size: 17px;
        font-weight: bold;
    }

    #modalSelectGalleryNewSection .ctn-gallery{
        border:3px solid transparent;
    }  
    #modalSelectGalleryNewSection .ctn-gallery.selected,
    #modalSelectGalleryNewSection .ctn-gallery:hover,
    .preview-img .gallery-selected{
        border:3px solid #4285f4;
    }  

    #modalSelectGalleryNewSection .ctn-gallery.selected .badge-conf{
        display: inline;
    }
    #modalSelectGalleryNewSection .ctn-gallery .badge-conf{
        display: none;
    }

    .preview-img .tooltips,
    .preview-img .tooltip.fade.in{
        display: none !important;
    }

    .preview-img .gallery-selected{
        display: inline-block;
        padding: 10px;
        width: 100%;
    }  
    

</style>

<div class="modal fade" tabindex="-1" role="dialog" id="modalSelectGalleryNewSection">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-title" id="modalText">
            <h4 class="pull-left"><i class="fa fa-th"></i> Sélectionner un album</h4>
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

            $i=0;
        ?>
             <?php if(!empty($myAlbums)) foreach ($myAlbums as $name => $album) { $i++ ?>
             <div class="ctn-gallery col-xs-12 padding-15 margin-bottom-10" id="ctn-gallery-<?php echo $i; ?>">
                <span class="folder-name letter-blue">
                    <button class="btn btn-sm btn-link bg-blue-k btn-select-gallery tooltips" 
                            data-gallery-name="<?php echo $name; ?>"
                            data-section-before=""
                            data-id-ctn="ctn-gallery-<?php echo $i; ?>"
                            data-original-title="sélectionner cet album">
                            <i class="fa fa-plus-circle"></i>
                    </button>
                    <i class="fa fa-folder"></i> <?php echo $name; ?>
                    <span class="pull-right badge bg-blue-k badge-conf">
                        <i class="fa fa-check-circle"></i> album sélectionné
                    </span>
                </span>
                <hr class="margin-top-5">
                <div class="col-xs-12 margin-bottom-25">
                    <?php foreach ($myPhotos as $key => $photo) { 
                            if(@$photo["collection"]==$name){ ?>
                                <?php 
                                    $imagePath = Yii::app()->baseUrl."/".Yii::app()->params['uploadUrl'].
                                    $photo["moduleId"]."/".$photo["folder"]; 

                                    if($photo["contentKey"]=="profil")
                                         $imagePath .= "/".Document::GENERATED_MEDIUM_FOLDER;
                                    else $imagePath .= "/".Document::GENERATED_IMAGES_FOLDER;

                                    $imagePath .= "/".$photo["name"];
                                ?>
                                <div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 padding-5 ctn-img">                     
                                    <img src="<?php echo $imagePath; ?>" class="img-responsive">
                                </div>
                    <?php }} ?>
                </div>
            </div>
            <?php } ?>
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