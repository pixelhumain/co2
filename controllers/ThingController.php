<?php
/**
* Created on examples of other controllers 
*  
* @author: Jean Daniel CAZAL <danzalkay551@gmail.com>
* Date: 26/01/2017 rapatrié dans CO2 le 22/03/17
*/

class ThingController extends CommunecterController {
	
  const moduleTitle = "Thing";
	protected function beforeAction($action) {
    	parent::initPage();
    	return parent::beforeAction($action);
  	}

  	public function actions(){
	    return array(
          //'index'                     => 'citizenToolKit.controllers.thing.IndexAction',
          'graph'                   	=> 'citizenToolKit.controllers.thing.GetGraphAction',
          'scklastestreadings'        => 'citizenToolKit.controllers.thing.GetLastestReadingAction',
          'updatesckdevices'          => 'citizenToolKit.controllers.thing.UpdateSckDevicesAction',
          'manage'                    => 'citizenToolKit.controllers.thing.ManageAction',
          'getsckdataincodb'          => 'citizenToolKit.controllers.thing.GetSCKDataInCODBAction',
          'synthetizesckdata'         => 'citizenToolKit.controllers.thing.SynthetizeSCKDataInCODBAction',
          
        );
	}

}
