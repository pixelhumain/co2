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
	        'activitylist'     	=> 'citizenToolKit.controllers.pod.ActivityListAction'
	    );
	}
	public function actionCircuit(){
    	echo $this->renderPartial("circuit", array(), true);
 	}
 	public function actionSliderMedia(){
    	echo $this->renderPartial("sliderMedia", array("images"=>@$_POST["images"], "medias"=>@$_POST["medias"]), true);
 	}
}
?>