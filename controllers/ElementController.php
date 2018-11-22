<?php
/**
 * ElementController.php
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 15/08/13
 */
class ElementController extends CommunecterController {
    const moduleTitle = "Element";
    
  protected function beforeAction($action) {
    parent::initPage();
    return parent::beforeAction($action);
  }
  public function actions()
  { 
      return array(
          'updatefield' 				  => 'citizenToolKit.controllers.element.UpdateFieldAction',
          'updatefields' 				  => 'citizenToolKit.controllers.element.UpdateFieldsAction',
          'updateblock'           => 'citizenToolKit.controllers.element.UpdateBlockAction',
          'updatesettings'        => 'citizenToolKit.controllers.element.UpdateSettingsAction',
          'updatestatus'          => 'citizenToolKit.controllers.element.UpdateStatusAction',
          'detail'                => 'citizenToolKit.controllers.element.DetailAction',
          'getalllinks'           => 'citizenToolKit.controllers.element.GetAllLinksAction',
          'geturls'               => 'citizenToolKit.controllers.element.GetUrlsAction',
          'getcuriculum'          => 'citizenToolKit.controllers.element.GetCuriculumAction',
          'getcontacts'           => 'citizenToolKit.controllers.element.GetContactsAction',
          'directory'             => 'citizenToolKit.controllers.element.DirectoryAction',
          'addmembers'            => 'citizenToolKit.controllers.element.AddMembersAction',
          'aroundme'              => 'citizenToolKit.controllers.element.AroundMeAction',
          'save'                  => 'citizenToolKit.controllers.element.SaveAction',
          'savecontact'           => 'citizenToolKit.controllers.element.SaveContactAction',
          'saveurl'               => 'citizenToolKit.controllers.element.SaveUrlAction',
          'delete'                => 'citizenToolKit.controllers.element.DeleteAction',
          'get'                   => 'citizenToolKit.controllers.element.GetAction',
          'notifications'         => 'citizenToolKit.controllers.element.NotificationsAction',
          'about'                 => 'citizenToolKit.controllers.element.AboutAction',
          'getdatadetail'         => 'citizenToolKit.controllers.element.GetDataDetailAction',
          'stopdelete'            => 'citizenToolKit.controllers.element.StopDeleteAction',
          'getthumbpath'          => 'citizenToolKit.controllers.element.GetThumbPathAction',
          'getcommunexion'        => 'citizenToolKit.controllers.element.GetCommunexionAction',
          'getdatabyurl'          => 'citizenToolKit.controllers.element.GetDataByUrlAction',
          'network'               => 'citizenToolKit.controllers.element.NetworkAction',
          'getnetworks'           => 'citizenToolKit.controllers.element.GetNetworksAction',
          'invoice'               => 'citizenToolKit.controllers.element.InvoiceAction',
          'invite'                => 'citizenToolKit.controllers.element.InviteAction',
          'list'                  => 'citizenToolKit.controllers.element.ListAction',
      );
  }
}