<?php
/**
 * PdfController.php
 *
 * @author: Raphael R
 * Date: 09/2017
 */
class PdfController extends CommunecterController {
  

	protected function beforeAction($action) {
	    parent::initPage();
	    return parent::beforeAction($action);
	}

	public function actions()
	{
	    return array(
	        'create'     		=> 'citizenToolKit.controllers.pdf.CreateAction',
	    );
	}    
}