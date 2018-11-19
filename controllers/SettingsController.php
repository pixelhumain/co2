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
		$element=Element::getElementSimpleById(Yii::app()->session["userId"], Person::COLLECTION, null, array("preferences"));
    	echo $this->renderPartial("notificationsAccount", array("preferences"=>$element["preferences"]), true);
 	}
 	public function actionConfidentiality($type=null,$id=null, $modal=false){
 		$element=Element::getElementSimpleById($id, $type, null, array("preferences","name"));
 		$params=array(  "element" => @$element, 
			"type" => $type,
			"id" => $id, 
			"edit" => true,
			"openEdition" => false,
			"modal"=>$modal
		);
    	echo $this->renderPartial("confidentialityPanel", $params, true);
 	}
 	/*public function actionConfidentialityAccount(){
    	echo $this->renderPartial("confidentialityAccount", array(), true);
 	}*/
 	public function actionConfidentialityCommunity(){
    	echo $this->renderPartial("confidentialityCommunity", array(), true);
 	}
 	public function actionNotificationsCommunity(){
    	echo $this->renderPartial("notificationsCommunity", array(), true);
 	}

 	public function actionMyAccount($type=null,$id=null){
 		$element=Element::getElementSimpleById($id, $type, null, array("preferences","name", "slug"));
 		$element["id"] = $id;
 		$element["type"] = $type;
 		$params=array(  "element" => @$element, 
						"type" => $type,
						"id" => $id,
		);
		
    	echo $this->renderPartial("myAccount", $params, true);
 	}

 	public function actionIndex($page=null){
 		$params=array(
 			"page"=>@$page,
 			"to"=>@$_GET["slug"]
 			);
     	echo $this->renderPartial("index", $params,true);
	}
}
?>