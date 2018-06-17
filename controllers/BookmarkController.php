<?php
/**
 * SiteController.php
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 7/23/12
 * Time: 12:25 AM
 */
class BookmarkController extends CommunecterController {
  
	protected function beforeAction($action) {
		parent::initPage();
		return parent::beforeAction($action);
  	}

	public function actions()
	{
	    return array(
	        //CTK actions
	        'delete'                => 'citizenToolKit.controllers.bookmark.DeleteAction',
	        'save'                => 'citizenToolKit.controllers.bookmark.SaveAction',
	        'sendmailnotif'                => 'citizenToolKit.controllers.bookmark.SendMailNotifAction',
	    );
	}
    

}