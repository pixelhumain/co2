<?php
$cs = Yii::app()->getClientScript();
//HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->request->baseUrl);

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    //header + menu
    $this->renderPartial($layoutPath.'header', 
                        array(  "layoutPath"=>$layoutPath ,
                                "page" => "thing") ); 
?>

<div class="col-xs-12" id="">
  <div class="panel panel-white">
      <div class="panel-heading text-center border-light">
        <h3 class="panel-title text-blue"> Smart-Citizen-Kit </h3>

      </div>

      <div class="panel-body no-padding center">
        <ul class="list-group text-left no-margin">
           
          <li class="list-group-item text-yellow col-md-4 col-sm-6 link-to-directory">
            <div class="" style="cursor:pointer;" onclick="url.loadByHash('#thing.graph')">
              <i class="fa fa-line-chart fa-2x"></i>
                
              <?php echo Yii::t("thing", "GRAPHES", null, Yii::app()->controller->module->id); ?>
              
            </div>
          </li>
          
          <li class="list-group-item text-yellow col-md-4 col-sm-6 link-to-directory">
            <div class="" style="cursor:pointer;" onclick="url.loadByHash('#thing.scklastestreadings')">
              <i class="fa fa-newspaper-o fa-2x"></i>
                
              <?php echo Yii::t("thing", "DERNIERES MESURES", null, Yii::app()->controller->module->id); ?>
              
            </div>
          </li>
          <?php if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>
          <li class="list-group-item text-yellow col-md-4 col-sm-6 link-to-directory">
            <div class="" style="cursor:pointer;" onclick="url.loadByHash('#thing.manage')">
              <i class="fa fa-database fa-2x"></i>
                
              <?php echo Yii::t("thing", "GERER LES DEVICES", null, Yii::app()->controller->module->id); ?>
              
            </div>
          </li>

            <?php } ?>

        </ul>
      </div>
  </div>

</div>

<?php $this->renderPartial($layoutPath.'footer', array("subdomain"=>"thing")); ?>

<script>

  jQuery(document).ready(function() {
    console.log("Thing : page index");
   // setTitle("Thing Reading","cog");
   //Index.init();
  });

</script>