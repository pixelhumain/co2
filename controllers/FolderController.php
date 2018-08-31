<?php
/**
 * FolderController.php
 *
 * @author: Bouboule <clement.damiens@gmail.com>
 * Date: 7/29/15
 * Time: 12:25 AM
 */
class FolderController extends CommunecterController {
  

	protected function beforeAction($action) {
	    parent::initPage();
	    return parent::beforeAction($action);
	}

	public function actions()
	{
	    return array(
	        'list'    => 'citizenToolKit.controllers.folder.ListAction',
	        'crud'    => 'citizenToolKit.controllers.folder.CrudAction',
	    );
	}
}