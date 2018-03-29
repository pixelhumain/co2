<?php
/**
 * DefaultController.php
 *
 * OneScreenApp for Communecting people
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 14/03/2014
 */
class DocsController extends CommunecterController {

    
    protected function beforeAction($action)
  	{

      parent::initPage();

      
		  return parent::beforeAction($action);
  	}

    /**
     * Home page
     */

	public function actionIndex($page=null, $dir=null) 
	{
    	//Yii::app()->theme = $theme;   
      //Yii::app()->session["theme"] = $theme; 
      //Yii::app()->theme = "notragora";
      //Yii::app()->theme = "CO2";

      // http://127.0.0.1/ph/network?network=tierslieuxlille
      // http://127.0.0.1/ph/network/default/index/src/tierslieuxlille

	    //if(@$_GET["network"] ){
	      //$this->redirect(Yii::app()->createUrl("/network/default/index?src=".$_GET["network"]));
      //}
      $url=(!empty($dir)) ? $dir."/".$page : $page;
     echo $this->renderPartial($url, null,true);
  }
}
  ?>