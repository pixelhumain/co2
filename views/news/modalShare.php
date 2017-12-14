<style>
    #modal-share  .close-modal{
        float: right;
        margin-right: 0px;
        width: 60px;
        height: 30px;
    }
    #modal-share  .close-modal .lr .rl {
        height: 30px;
        width: 1px;
        background-color: #2C3E50;
        transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
        z-index: 1052;
    }
    #modal-share  .close-modal .lr {
        height: 30px;
        width: 1px;
        margin-left: 35px;
        background-color: #2C3E50;
        transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        z-index: 1051;
    }

    #modal-share .modal-content{
        top: 150px;
        padding-bottom:10px!important;
    }
    #modal-share{
        background-color: rgba(0,0,0,0.6);
    }
    #modal-share #htmlElementToShare .timeline-footer{
        display: none;
    }
    #modal-share #htmlElementToShare .btn.settingsNews{
        display: none;
    }
    #modal-share #htmlElementToShare .btn-share,
    #modal-share #htmlElementToShare .btn-add-to-directory{
        display: none;
    }

    #modal-share #htmlElementToShare .entityDescription{
        max-height: 38px;
        overflow: hidden; 
    }

    #modal-share #htmlElementToShare .searchEntityContainer{
        width:100%!important;
        padding: 0px;
        margin: 0px !important;
        /*min-height: 370px !important;*/
        max-height: 420px !important;
    }

    #modal-share #htmlElementToShare .container-img-profil{
        /*min-height: 250px !important;*/
        max-height: 250px !important;
    }
</style>

<div class="modal fade portfolio-modal" id="modal-share" 
     tabindex="-1" role="dialog" aria-hidden="true">
    <div class="col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
        <div class="modal-content row shadow2">
            <a class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </a>
            <div class="col-sm-12 container text-left">
                <?php
                    $me = Element::getByTypeAndId(Person::COLLECTION, Yii::app()->session['userId']); 
                    $profilThumbImageUrl = Element::getImgProfil($me, "profilThumbImageUrl", $this->module->assetsUrl); 
                ?>
                <img src="<?php echo $profilThumbImageUrl; ?>" class="img-circle margin-right-10 pull-left" width="40" height="40">
                
                <h4 class="pull-left">
                    <small>
                        <i class="fa fa-share"></i> <?php echo Yii::t("common","Share content <small class='text-dark'>with your network<br><small>This content will be shared to your followers</small></small>") ?>
                    </small>
                </h4>
                 <div class="form-group">
                    <textarea class="form-control" rows="2" id="msg-share" placeholder="<?php echo Yii::t("common","Express yourself ...") ?>"></textarea>
                </div>
                <div class="col-md-12 shadow2 no-padding" id="htmlElementToShare"></div>
            </div>
            <div class="col-xs-12">
                <hr>
                <button class="btn btn-success pull-right margin-left-5" id="btn-share-it" data-dismiss="modal"
                        data-ownerlink='share' data-id='' data-type=''>
                <i class="fa fa-share"></i> <?php echo Yii::t("common","Share") ?>
                </button>
                <button class="btn btn-default pull-right" data-dismiss="modal">
                <i class="fa fa-times"></i> <?php echo Yii::t("common","Cancel") ?>
                </button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    

</script>