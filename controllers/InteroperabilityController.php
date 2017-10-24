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
      'get' => 'citizenToolKit.controllers.interoperability.GetAction',
      'copedia' => 'citizenToolKit.controllers.interoperability.CopediaAction',
      'co-osm' => 'citizenToolKit.controllers.interoperability.COSMAction',
      'co-osm-getnode' => 'citizenToolKit.controllers.interoperability.OSMGetNodeAction',
      'co-osm-push-tag' => 'citizenToolKit.controllers.interoperability.OSMPushTagAction',
      'wikitoco' => 'citizenToolKit.controllers.interoperability.WikiToCoAction',
      'pushtypewikidata' => 'citizenToolKit.controllers.interoperability.PushTypeWikidataAction',
      'wikidata-put-description' => 'citizenToolKit.controllers.interoperability.WikidataPutDescriptionAction',
      'wikidata-put-claim' => 'citizenToolKit.controllers.interoperability.WikidataPutClaimAction',
      'proposeopendatasource' => 'citizenToolKit.controllers.interoperability.ProposeOpenDataSourceAction',
      'validateproposeinterop' => 'citizenToolKit.controllers.interoperability.ValidateProposeInteropAction',
      'rejectproposeinterop' => 'citizenToolKit.controllers.interoperability.RejectProposeInteropAction',
    );
  }
}