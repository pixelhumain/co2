<?php
/**
 * 
 *
 * @author: Raphael RIVIERE
 * Date:
 */
class AdminpublicController extends CommunecterController {

  protected function beforeAction($action)
  {
	parent::initPage();
	return parent::beforeAction($action);
  }

	public function actions()
	{
		return array(
		// captcha action renders the CAPTCHA image displayed on the contact page
		//'index'   				=> 'citizenToolKit.controllers.adminpublic.IndexAction',
		'createfile' => 'citizenToolKit.controllers.adminpublic.CreateFileAction',
		'adddata' => 'citizenToolKit.controllers.adminpublic.AddDataAction',
	    'adddataindb' => 'citizenToolKit.controllers.adminpublic.AddDataInDbAction',
	    'sourceadmin' => 'citizenToolKit.controllers.adminpublic.SourceadminAction',
	    'getdatabyurl' => 'citizenToolKit.controllers.adminpublic.GetDataByUrlAction',
	    'assigndata'  => 'citizenToolKit.controllers.adminpublic.AssignDataAction',
	    'previewdata'  => 'citizenToolKit.controllers.adminpublic.PreviewDataAction',
  	    'interopproposed'  => 'citizenToolKit.controllers.adminpublic.InteropProposedAction',
  	    'cleantags' => 'citizenToolKit.controllers.adminpublic.CleanTagsAction',
		);
	}

	public function actionIndex(){
		CO2Stat::incNbLoad("co2-admin");   
        $params = array();
        echo $this->renderPartial("index", $params, true);
	}
}