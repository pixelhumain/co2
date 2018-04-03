<div class="col-xs-12 text-center no-padding ctn-new-sec" id="before-<?php echo @$sectionKey; ?>">
    <?php if(@$edit==true && @$sectionKey != "description"){ ?>
        <button class="btn btn-link bg-white text-dark btn-create-section shadow2"
                data-section-before="<?php echo @$sectionKey; ?>">
            <i class="fa fa-plus"></i> Ajouter section ici
        </button>
        <section class="portfolio new-section margin-top-15 bg-white <?php if(@$sectionShadow==true) echo 'shadow'; ?> 
                        new-section-before-<?php echo @$sectionKey; ?>"
                        data-section-before="<?php echo @$sectionKey; ?>">
            <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6 padding-15">
                <h5><i class="fa fa-plus"></i> Nouvelle section</h5>

                <hr>
                <input type="text" class="form-input col-xs-12 title-new-sec font-montserrat margin-bottom-15" 
                        placeholder="Titre de la section">

                <div class="col-xs-12 text-left no-padding">
                    <button class="btn btn-link bg-blue-k btn-open-modal-select-gallery" 
                            data-section-before="<?php echo @$sectionKey; ?>" 
                            data-target="#modalSelectGalleryNewSection" data-toggle="modal">
                        <i class="fa fa-th"></i> Joindre un album photo
                    </button> 
                    <button class="btn btn-link letter-red btn-cancel-gallery">
                        <i class="fa fa-th"></i> Annuler
                    </button>

                    <button class="btn btn-link bg-blue-k btn-open-modal-select-img" 
                            data-section-before="<?php echo @$sectionKey; ?>" 
                            data-target="#modalSelectImgNewSection" data-toggle="modal">
                        <i class="fa fa-picture-o"></i> Joindre une photo
                    </button>
                    <button class="btn btn-link letter-red btn-cancel-image">
                        <i class="fa fa-picture-o"></i> Annuler
                    </button><br><br>

                    <span class="preview-img"></span>
                    <input type="hidden" class="img-path-new-sec">
                    <input type="hidden" class="gallery-new-sec">
                    <hr>
                    
                </div>

                <div class="md-ctn font-montserrat text-left">
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
    <?php } ?>
    </div>