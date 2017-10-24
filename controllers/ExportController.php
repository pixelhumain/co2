<?php 

class ExportController extends CommunecterController {

	protected function beforeAction($action) {
		parent::initPage();
		return parent::beforeAction($action);
	}
	public function actions() {
		return array(
			'index'	=> 'citizenToolKit.controllers.export.IndexAction',
		);
	}
}

?>