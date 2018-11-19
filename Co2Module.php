<?php
/**
 * Communect Module
 *
 * @author Tibor Katelbach <oceatoon@mail.com>
 * @version 0.0.3
 *
*/

class Co2Module extends CWebModule {

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		Yii::app()->setComponents(array(
		    'errorHandler'=>array(
		        'errorAction'=>'/'.$this->id.'/error'
		    )
		));
		
		Yii::app()->homeUrl = Yii::app()->createUrl($this->id);
		
		//Apply theme
		$themeName = $this->getTheme();
		Yii::app()->theme = $themeName;
		
		//Retrieve network params in the url
		if(@$_GET["network"]) {
            Yii::app()->params['networkParams'] = $_GET["network"];
        }
       if(@Yii::app()->request->cookies['lang'] && !empty(Yii::app()->request->cookies['lang']->value))
        	Yii::app()->language = (string)Yii::app()->request->cookies['lang'];
        else 
			Yii::app()->language = (isset(Yii::app()->session["lang"])) ? Yii::app()->session["lang"] : 'fr';
		
		// import the module-level models and components
		$this->setImport(array(
			'citizenToolKit.models.*',
			'eco.models.*',
			'places.models.*',
			'chat.models.*',
			'interop.models.*',
			'survey.models.*',
			$this->id.'.models.*',
			$this->id.'.components.*',
			$this->id.'.messages.*',
		));
		/*$this->components =  array(
            'class'=>'CPhpMessageSource',
            'basePath'=>'/messages'
        );*/
	}

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	private $_assetsUrl;

	public function getAssetsUrl($noBase=null)
	{
		$baseAssets= ($noBase) ? "assets" : $this->id.'.assets';
		if ($this->_assetsUrl === null)
	        $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
	            Yii::getPathOfAlias($baseAssets) );
	    return $this->_assetsUrl;
	}

	public function getParentAssetsUrl()
	{
		return ( @Yii::app()->params["module"]["parent"] ) ?  Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl()  : self::getAssetsUrl();
	}

	/**
	 * Retourne le theme d'affichage de communecter.
	 * Si option "theme" dans paramsConfig.php : 
	 * Si aucune option n'est précisée, le thème par défaut est "ph-dori"
	 * Si option 'tpl' fixée dans l'URL avec la valeur "iframesig" => le theme devient iframesig
	 * Si option "network" fixée dans l'URL : theme est à network et la valeur du parametres fixe les filtres d'affichage
	 * @return type
	 */
	public function getTheme() {
		//$theme = "CO2";
		$theme = (@Yii::app()->session["theme"]) ? Yii::app()->session["theme"] : "CO2";
		//$theme = "notragora";
		if (!empty(Yii::app()->params['theme'])) {
			$theme = Yii::app()->params['theme'];
		} else if (empty(Yii::app()->theme)) {
			$theme = (@Yii::app()->session["theme"]) ? Yii::app()->session["theme"] : "CO2";
			//$theme = "CO2";
			//$theme = "notragora";
		}

		if(@$_GET["tpl"] == "iframesig"){ $theme = $_GET["tpl"]; }

		if(@$_GET["network"]) {
            $theme = "network";
            //Yii::app()->params['networkParams'] = $_GET["network"];
        }
        Yii::app()->session["theme"] = $theme;
		return $theme;
	}
}
