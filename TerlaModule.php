<?php
/**
 * Communect Module
 *
 * @author Tibor Katelbach <oceatoon@mail.com>
 * @version 0.0.3
 *
*/

class TerlaModule extends CWebModule {

	public function init(){}

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

	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null)
	        $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
	            Yii::getPathOfAlias($this->id.'.assets') );
	    return $this->_assetsUrl;
	}
}
