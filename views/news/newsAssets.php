<?php 
  
$cssAnsScriptFilesModule = array(
  '/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css',
  '/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysiwyg-color.css',
  '/plugins/bootstrap-datetimepicker/css/datetimepicker.css',
  //'/plugins/x-editable/css/bootstrap-editable.css',
  '/plugins/select2/select2.css',
  //X-editable...
  '/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
//  '/plugins/x-editable/js/bootstrap-editable.js' , 
  //'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js' , 
  //'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5.js' , 
  //'/plugins/wysihtml5/wysihtml5.js',
  '/plugins/jquery.scrollTo/jquery.scrollTo.min.js',
  '/plugins/ScrollToFixed/jquery-scrolltofixed-min.js',
  '/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
  '/plugins/jquery.appear/jquery.appear.js',
  '/plugins/jquery.elastic/elastic.js',
  '/plugins/underscore-master/underscore.js',
  '/plugins/jquery-mentions-input-master/jquery.mentionsInput.js',
  '/plugins/jquery-mentions-input-master/jquery.mentionsInput.css',
  '/plugins/jquery-mentions-input-master/lib/jquery.events.input.js',
  '/plugins/facemotion/faceMocion.css',
  '/plugins/facemotion/faceMocion.js',
  
);
//error_log("BasURL : ".Yii::app()->request->baseUrl);
HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->request->baseUrl);


$cssAnsScriptFilesModule = array(
  '/js/news/autosize.js',
  '/js/news/newsHtml.js',
  '/js/menus/multi_tags_scopes.js',
  '/js/cooperation/uiModeration.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);


$cssAnsScriptFilesModule = array(
  '/css/news/newsSV.css',
//  '/js/comments.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule,Yii::app()->theme->baseUrl."/assets");

?>