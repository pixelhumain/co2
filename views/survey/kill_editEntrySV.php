<?php  

  $cssAnsScriptFiles = array(
    '/plugins/bootstrap-datepicker/css/datepicker.css',
    '/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
    '/plugins/summernote/dist/summernote.css',
    '/plugins/summernote/dist/summernote.min.js'
    );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles,Yii::app()->request->baseUrl);
  
  $cssAnsScriptFiles = array(
    '/assets/css/rooms/header.css'
  );
  HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFiles, Yii::app()->theme->baseUrl);

  //$cssAnsScriptFilesTheme = array('js/form-elements.js');
  //HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

  $parent = ActionRoom::getById($roomId);
  $nameList = (strlen($parent["name"])>20) ? substr($parent["name"],0,20)."..." : $parent["name"];

?>
<div id="editEntryContainer"></div>
<style type="text/css">
  .addPropBtn{
    width:100%;
    /*background-color: #BBBB77;*/
  }
  .removePropLineBtn {
      background-color: #E33551;
      line-height: 32px;
      width: 100%;
  }
</style>


