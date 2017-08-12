<?php
/**
 * EventController.php
 * 
 * contient tous ce qui concerne les utilisateurs / clietns TEEO
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 18/07/2014
 */
class GalleryController extends CommunecterController {

		protected function beforeAction($action) {
			parent::initPage();
			return parent::beforeAction($action);
		}

	public function actions()
	{
	    return array(
	    	'index'       	=> 'citizenToolKit.controllers.gallery.IndexAction',
	        'getlistbyid'     	=> 'citizenToolKit.controllers.gallery.GetListByIdAction',
	    	'crudcollection'     	=> 'citizenToolKit.controllers.gallery.CrudCollectionAction',
	    	'crudfile'     	=> 'citizenToolKit.controllers.gallery.CrudFileAction',
	    );
	}
}