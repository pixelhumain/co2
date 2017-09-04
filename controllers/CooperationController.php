<?php
/**
 * CommentController.php
 *
 * @author: Tango
 * Date: 9/8/17
 * Time: 12:25 AM
 */
class CooperationController extends CommunecterController {
  

	protected function beforeAction($action) {
	    parent::initPage();
	    return parent::beforeAction($action);
	}

	public function actions()
	{
	    return array(
	        'getcoopdata'       	=> 'citizenToolKit.controllers.cooperation.GetCoopDataAction',
	        'savevote'       		=> 'citizenToolKit.controllers.cooperation.SaveVoteAction',
	    );
	}

}