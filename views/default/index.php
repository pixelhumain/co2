<?php 

/* *************************************
on garde les librairies specifique au module dans le module
*******************************************/

	$cssAnsScriptFilesModule = array(
		"/js/default/loginRegister.js",
		'/js/co.js',
		'/js/default/directory.js',
		'/js/default/index.js',
		'/js/default/notifications.js',
		//'/js/default/directory.js',
		'/js/dataHelpers.js',
		'/js/sig/localisationHtml5.js',
		'/js/floopDrawerRight.js',
		'/js/sig/geoloc.js',
		//'/js/default/formInMap.js',
		//'/js/default/formInMapOld.js',
		'/js/default/globalsearch.js',
		'/js/sig/findAddressGeoPos.js',
		'/js/jquery.filter_input.js',
		//'/js/breadcrum_co.js',
		'/js/scopes/scopes.js',
		//'/js/scopes/breadcrum_co.js',
		//'/js/scopes/multiscopes.js',
		);

HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->getParentAssetsUrl() );
	
	function random_pic()
    {
        if(file_exists ( "../../modules/communecter/assets/images/proverb" )){
          $files = glob('../../modules/communecter/assets/images/proverb/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
          $res = array();
          for ($i=0; $i < 8; $i++) { 
            array_push( $res , str_replace("../../modules/communecter/assets", 
            			Yii::app()->controller->module->assetsUrl, $files[array_rand($files)]) );
          }
          return $res;
        } else
          return array();
    }


 
?>




