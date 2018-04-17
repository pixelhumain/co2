<?php
	/**
 * PodController.php
 *
 */

class SettingsController extends CommunecterController {

	protected function beforeAction($action) {
		parent::initPage();
		return parent::beforeAction($action);
	}

	public function actions()
	{
	    return array(
	        'slideragenda'      => 'citizenToolKit.controllers.pod.SliderAgendaAction',
	        'photovideo'     	=> 'citizenToolKit.controllers.pod.PhotoVideoAction',
	        'fileupload'     	=> 'citizenToolKit.controllers.pod.FileUploadAction',
	        'activitylist'     	=> 'citizenToolKit.controllers.pod.ActivityListAction',
	        //'preferences'     	=> 'citizenToolKit.controllers.pod.preferencesAction',
	    );
	}
	public function actionNotificationsAccount(){
    	echo $this->renderPartial("notificationsAccount", array(), true);
 	}
 	public function actionNotificationsCommunity(){
    	echo $this->renderPartial("notificationsCommunity", array(), true);
 	}
 	public function actionIndex(){
     	echo $this->renderPartial("index", null,true);
	}
}
?>