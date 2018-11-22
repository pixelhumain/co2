<?php
	/**
 * PodController.php
 *
 */

class PodController extends CommunecterController {

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
	public function actionCircuit(){
    	echo $this->renderPartial("circuit", array(), true);
 	}
 	public function actionSliderMedia(){
    	echo $this->renderPartial("sliderMedia", array("images"=>@$_POST["images"], "medias"=>@$_POST["medias"]), true);
 	}
 	public function actionPreferences(){
    	$this->renderPartial("../pod/preferences" , array() );
	}
}
?>