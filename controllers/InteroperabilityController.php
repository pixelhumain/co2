<?php

class InteroperabilityController extends CommunecterController {

  protected function beforeAction($action) {
      return parent::beforeAction($action);
  }

  public function actions()
  {
    return array(
      'index'       => 'citizenToolKit.controllers.interoperability.IndexAction',
      'wiki'      	=> 'citizenToolKit.controllers.interoperability.WikiAction',
      'datagouv'        => 'citizenToolKit.controllers.interoperability.DatagouvAction',
      'osm'  => 'citizenToolKit.controllers.interoperability.OsmAction',
      'ods'     => 'citizenToolKit.controllers.interoperability.OdsAction',
    );
  }
}