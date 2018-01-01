<?php 

/* *************************************
on garde les librairies specifique au module dans le module
*******************************************/

	$cssAnsScriptFilesModule = array(
		'/js/co.js',
		'/js/default/directory.js',
		'/js/default/index.js',
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
		'/js/scopes/breadcrum_co.js',
		'/js/scopes/multiscopes.js',
		

	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
	
		
	if(isset( Yii::app()->request->cookies['remember'] ) && Yii::app()->request->cookies['remember']->value == "true" &&
	   isset( Yii::app()->request->cookies['lyame'] ) && 
	   isset( Yii::app()->request->cookies['drowsp'] ) && @Yii::app()->request->cookies['drowsp']->value != "null"){
	   	$pwdDecrypt = pwdDecrypt(Yii::app()->request->cookies['drowsp']->value);
	   	$emailDecrypt = pwdDecrypt(Yii::app()->request->cookies['lyame']->value);
	   	$res = Person::login($emailDecrypt, $pwdDecrypt, false);
	}

	function random_pic()
    {
        if(file_exists ( "../../modules/communecter/assets/images/proverb" )){
          $files = glob('../../modules/communecter/assets/images/proverb/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
          $res = array();
          for ($i=0; $i < 8; $i++) { 
            array_push( $res , str_replace("../../modules/communecter/assets", Yii::app()->controller->module->assetsUrl, $files[array_rand($files)]) );
          }
          return $res;
        } else
          return array();
    }


 
	function pwdDecrypt($jsonString){  //return $jsonString;
		$passphrase = 'JbQmfH"h^W7q86JU1V(<64aEv';
	    $jsondata = json_decode($jsonString, true);
	    try {
	        $salt = hex2bin($jsondata["s"]);
	        $iv  = hex2bin($jsondata["iv"]);
	    } catch(Exception $e) { return null; }
	    $ct = base64_decode($jsondata["ct"]);
	    $concatedPassphrase = $passphrase.$salt;
	    $md5 = array();
	    $md5[0] = md5($concatedPassphrase, true);
	    $result = $md5[0];
	    for ($i = 1; $i < 3; $i++) {
	        $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
	        $result .= $md5[$i];
	    }
	    $key = substr($result, 0, 32);

	    //var_dump($iv); exit;

	    $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
	    return json_decode($data, true);
	}

	
?>



