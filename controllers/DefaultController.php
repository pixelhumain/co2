<?php
/**
 * DefaultController.php
 *
 * OneScreenApp for Communecting people
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 14/03/2014
 */
class DefaultController extends CController {

    
    protected function beforeAction($action)
  	{
      return parent::beforeAction($action);
  	}

    /**
     * Home page
     */

	public function actionIndex($src=null) 
	{
    	echo Yii::getPathOfAlias('application.modules.terla.assets');
      echo "</br>";
      echo Yii::getPathOfAlias('webroot');
      echo "</br>";
      echo Yii::app()->getModule('terla')->getAssetsUrl();
  }
}