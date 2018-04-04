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
	public function actionCircuit(){
    	echo $this->renderPartial("circuit", array(), true);
 	}
 	public function actionIndex($page=null){

      	//$url=(!empty($dir)) ? $dir."/".$page : $page;
     	$url="index";
     	if(!empty($page))
     		$url=$page;
     	echo $this->renderPartial($url, null,true);
	}
}
?>