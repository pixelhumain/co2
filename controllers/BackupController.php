<?php
/**
 * SiteController.php
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 7/23/12
 * Time: 12:25 AM
 */
class BackupController extends CommunecterController {
  
	protected function beforeAction($action) {
		parent::initPage();
		return parent::beforeAction($action);
  	}

	public function actions()
	{
	    return array(
	        //CTK actions
	        'save'                => 'citizenToolKit.controllers.backup.SaveAction',
	        'delete'                => 'citizenToolKit.controllers.backup.DeleteAction',
	        'update'                => 'citizenToolKit.controllers.backup.UpdateAction',
	    );
	}
    

}