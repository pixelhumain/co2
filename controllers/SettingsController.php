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
	        //'confidentiality'     	=> 'citizenToolKit.controllers.settings.ConfidentialityAction',
	        //'preferences'     	=> 'citizenToolKit.controllers.pod.preferencesAction',
	    );
	}
	public function actionNotificationsAccount(){
    	echo $this->renderPartial("notificationsAccount", array(), true);
 	}
 	public function actionConfidentiality($type=null,$id=null){
 		$element=Element::getByTypeAndId($type, $id);
 		$params=array(  "element" => @$element, 
			"type" => Person::COLLECTION, 
			"edit" => true,
			"controller" => Person::CONTROLLER,
			"openEdition" => false,
			"modal"=>true
		);
    	echo $this->renderPartial("confidentiality", $params, true);
 	}
 	public function actionNotificationsCommunity(){
    	echo $this->renderPartial("notificationsCommunity", array(), true);
 	}
 	public function actionIndex($page=null){
 		$params=array(
 			"page"=>@$page
 			);
     	echo $this->renderPartial("index", $params,true);
	}
}
?>