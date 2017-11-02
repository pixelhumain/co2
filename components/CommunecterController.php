<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CommunecterController extends Controller
{
  public $version = "v0.2.1.02";
  public $versionDate = "29/07/2016 19:12";
  public $title = "Communectez";
  public $subTitle = "se connecter à sa commune";
  public $pageTitle = "Communecter, se connecter à sa commune";
  public static $moduleKey = "communecter";
  public $keywords = "communecter,connecter, commun,commune, réseau, sociétal, citoyen, société, territoire, participatif, social, smarterre,tiers lieux, ";
  public $description = "Communecter : Connecter à sa commune, inter connecter les communs, un réseau sociétal pour un citoyen connecté et acteur au centre de sa société.";
  public $projectName = "";
  public $projectImage = "/images/CTK.png";
  public $projectImageL = "/images/logo.png";
  /*public $footerImages = array(
      array("img"=>"/images/logoORD.PNG","url"=>"http://openrd.io"),
      array("img"=>"/images/logo_region_reunion.png","url"=>"http://www.regionreunion.com"),
      array("img"=>"/images/technopole.jpg","url"=>"http://technopole-reunion.com"),
      array("img"=>"/images/Logo_Licence_Ouverte_noir_avec_texte.gif","url"=>"https://data.gouv.fr"),
      array("img"=>'/images/blog-github.png',"url"=>"https://github.com/orgs/pixelhumain/dashboard"),
      array("img"=>'/images/opensource.gif',"url"=>"http://opensource.org/"));*/
  const theme = "ph-dori";
  public $person = null;
  public $themeStyle = "theme-style11";//3,4,5,7,9
  public $notifications = array();
  //TODO - Faire le tri des liens
  //TODO - Les children ne s'affichent pas dans le menu
  public $toolbarMenuAdd = array(
     array('label' => "My Network", "key"=>"myNetwork",
            "children"=> array(
              //"myaccount" => array( "label"=>"My Account","key"=>"newContributor", "class"=>"new-contributor", "href" => "#newContributor", "iconStack"=> array("fa fa-user fa-stack-1x fa-lg","fa fa-pencil fa-stack-1x stack-right-bottom text-danger")),
              "showContributors" => array( "label"=>"Find People","class"=>"show-contributor","key"=>"showContributors", "href" => "#showContributors", "iconStack"=> array("fa fa-user fa-stack-1x fa-lg","fa fa-search fa-stack-1x stack-right-bottom text-danger")),
              "newInvite" => array( "label"=>"Invite Someone","key"=>"invitePerson", "class"=>"ajaxSV", "onclick" => "", "iconStack"=> array("fa fa-user fa-stack-1x fa-lg","fa fa-plus fa-stack-1x stack-right-bottom text-danger")),
            )
          ),
    array('label' => "Organisation", "key"=>"organization",
            "children"=> array(
              "addOrganization" => array( "label"=>"Add an Organisation","key"=>"addOrganization", "class"=>"ajaxSV", "onclick"=>"", "iconStack"=> array("fa fa-group fa-stack-1x fa-lg","fa fa-plus fa-stack-1x stack-right-bottom text-danger"))
            )
          ),
    array('label' => "News", "key"=>"note",
                "children"=> array(
                  "createNews"  => array( "label"=>"Create news", "key"=>"new-news",   "class"=>"new-news", "iconStack"=> array("fa fa-bullhorn fa-stack-1x fa-lg","fa fa-plus fa-stack-1x stack-right-bottom text-danger")),
                  //"newsStream"  => array( "label"=>"News stream", "key"=>"newsstream", "class"=>"ajaxSV", "onclick"=>"openSubView('News stream', '/communecter/news/newsstream', null)", "iconStack"=> array("fa fa-list fa-stack-1x fa-lg","fa fa-search fa-stack-1x stack-right-bottom text-danger")),
                  //"newNote"   => array( "label"=>"Add new note",  "class"=>"new-note",    "key"=>"newNote",  "href" => "#newNote",  "iconStack"=> array("fa fa-list fa-stack-1x fa-lg","fa fa-plus fa-stack-1x stack-right-bottom text-danger")),
                 // "readNote"  => array( "label"=>"Read All notes","class"=>"read-all-notes","key"=>"readNote", "href" => "#readNote", "iconStack"=> array("fa fa-list fa-stack-1x fa-lg","fa fa-share fa-stack-1x stack-right-bottom text-danger")),
                )
          ),
     array('label' => "Event", "key"=>"event",
                "children"=> array(
                  "newEvent" => array( "label"=>"Add new event","key"=>"newEvent",  "class"=>"init-event", "href" => "#newEvent", "iconStack"=> array("fa fa-calendar-o fa-stack-1x fa-lg","fa fa-plus fa-stack-1x stack-right-bottom text-danger")),
                  "showCalendar" => array( "label"=>"Show calendar","class"=>"show-calendar","key"=>"showCalendar", "href" => "/ph/communecter/event/calendarview", "iconStack"=> array("fa fa-calendar-o fa-stack-1x fa-lg","fa fa-share fa-stack-1x stack-right-bottom text-danger")),
                )
          ),
     array('label' => "Projects", "key"=>"projects",
                "children"=> array(
                  "newProject" => array( "label"=>"Add new Project","key"=>"newProject", "class"=>"new-project", "href" => "#newProject", "iconStack"=> array("fa fa-cogs fa-stack-1x fa-lg","fa fa-plus fa-stack-1x stack-right-bottom text-danger")),
                  )
          ),
     array('label' => "Rooms", "key"=>"rooms",
                "children"=> array(
                  "newRoom" => array( "label"=>"Add new Room","key"=>"newRoom", "class"=>"ajaxSV", "onclick"=>"", "iconStack"=> array("fa fa-comments fa-stack-1x fa-lg","fa fa-plus fa-stack-1x stack-right-bottom text-danger")),
                  )
          )
  );
  public $subviews = array(
    //"news.newsSV",
    //"person.invite",
    //"event.addAttendeesSV"
  );
  public $pages = array(
    "admin" => array(
      "index"     => array("href" => "/ph/co2/admin"),
      "accueil"     => array("href" => "/ph/co2/accueil"),
      "directory" => array("href" => "/ph/co2/admin/directory"),
      "switchto"  => array("href" => "/ph/co2/admin/switchto"),
      "delete"    => array("href" => "/ph/co2/admin/delete"),
      "activateuser"  => array("href" => "/ph/co2/admin/activateuser"),
      "importdata"    => array("href" => "/ph/co2/admin/importdata"),
      "previewdata"    => array("href" => "/ph/co2/admin/previewdata"),
      "importinmongo"    => array("href" => "/ph/co2/admin/importinmongo"),
      "assigndata"    => array("href" => "/ph/co2/admin/assigndata"),
      "checkdataimport"    => array("href" => "/ph/co2/admin/checkdataimport"),
      "openagenda"    => array("href" => "/ph/co2/admin/openagenda"),
      "checkventsopenagendaindb"    => array("href" => "/ph/co2/admin/checkventsopenagendaindb"),
      "importeventsopenagendaindb"    => array("href" => "/ph/co2/admin/importeventsopenagendaindb"),
      "checkgeocodage"   => array("href" => "/ph/co2/admin/checkgeocodage"),
      "getentitybadlygeolocalited"   => array("href" => "/ph/co2/admin/getentitybadlygeolocalited"),
      "getdatabyurl"   => array("href" => "/ph/co2/admin/getdatabyurl"),
      "adddata"    => array("href" => "/ph/co2/admin/adddata"),
      "adddataindb"    => array("href" => "/ph/co2/admin/adddataindb"),
      "createfileforimport"    => array("href" => "/ph/co2/admin/createfileforimport"),
      "sourceadmin"    => array("href" => "/ph/co2/admin/sourceadmin"),
      "moderate"    => array("href" => "/ph/co2/admin/moderate"),
      "statistics"    => array("href" => "/ph/co2/stat/chart"),
      "checkcities"    => array("href" => "/ph/co2/admin/checkcities"),
      "checkcedex"    => array("href" => "/ph/co2/admin/checkcedex"),
      "downloadfile" => array("href" => "/ph/co2/admin/downloadfile"),
      "createfile" => array("href" => "/ph/co2/admin/createfile"),
      "mailerrordashboard" => array("href" => "/ph/co2/admin/mailerrordashboard"),
      "cities" => array("href" => "/ph/co2/admin/cities"),
    ),
    
    "adminpublic" => array(
      "index"    => array("href" => "/ph/co2/adminpublic/index"),
      "adddata"    => array("href" => "/ph/co2/adminpublic/adddata"),
      "adddataindb"    => array("href" => "/ph/co2/adminpublic/adddataindb"),
      "createfile" => array("href" => "/ph/co2/adminpublic/createfile"),
      "sourceadmin" => array("href" => "/ph/co2/adminpublic/sourceadmin"),
      "assigndata"    => array("href" => "/ph/co2/adminpublic/assigndata"),
      "getdatabyurl"   => array("href" => "/ph/co2/adminpublic/getdatabyurl"),
      "previewdata"    => array("href" => "/ph/co2/adminpublic/previewdata"),
      "interopproposed" => array("href" => "/ph/co2/adminpublic/interopproposed"),
      "cleantags" => array("href" => "ph/co2/adminpublic/cleantags"),
    ),
    "collections" => array(
      "add"    => array("href" => "/ph/co2/collections/add"),
      "list"    => array("href" => "/ph/co2/collections/list"),
      "crud"    => array("href" => "/ph/co2/collections/crud"),
    ),
    "tool" => array(
      "get"    => array("href" => "/ph/co2/tool/get")
    ),
    "rocketchat" => array(
      "index"    => array("href" => "/ph/co2/rocketchat/index"),
      "cors"    => array("href" => "/ph/co2/rocketchat/cors"),
      "login"    => array("href" => "/ph/co2/rocketchat/login"),
      "logint"    => array("href" => "/ph/co2/rocketchat/logint"),
      "test"    => array("href" => "/ph/co2/rocketchat/test"),
      "testt"    => array("href" => "/ph/co2/rocketchat/testt"),
      "chat"    => array("href" => "/ph/co2/rocketchat/chat"),
      "list"    => array("href" => "/ph/co2/rocketchat/list"),
      "invite"    => array("href" => "/ph/co2/rocketchat/invite"),
    ),
    "default" => array(
      "index"                => array("href" => "/ph/co2/default/index", "public" => true),
      "directory"            => array("href" => "/ph/co2/default/directory", "public" => true),
      "directoryjs"            => array("href" => "/ph/co2/default/directoryjs", "public" => true),
      "agenda"               => array("href" => "/ph/co2/default/agenda", "public" => true),
      "news"                 => array("href" => "/ph/co2/default/news", "public" => true),
      "home"                 => array("href" => "/ph/co2/default/home", "public" => true),
      "apropos"              => array("href" => "/ph/co2/default/apropos", "public" => true),
      "add"                  => array("href" => "/ph/co2/default/add"),
      "view"                 => array("href" => "/ph/co2/default/view", "public" => true),
      "dir"                  => array("href" => "/ph/co2/default/dir", "public" => true),
      "twostepregister"      => array("href" => "/ph/co2/default/twostepregister"),
      "switch"               => array("href" => "/ph/co2/default/switch"),
      "live"                 => array("href" => "/ph/co2/default/live"),
    ),
    "city"=> array(
      "index"               => array("href" => "/ph/co2/city/index", "public" => true),
      "detail"              => array("href" => "/ph/co2/city/detail", "public" => true),
      "detailforminmap"     => array("href" => "/ph/co2/city/detailforminmap", "public" => true),
      "dashboard"           => array("href" => "/ph/co2/city/dashboard", "public" => true), 
      "directory"           => array("href" => "/ph/co2/city/directory", "public" => true, 
                                     "title"=>"City Directory", "subTitle"=>"Find Local Actors and Actions : People, Organizations, Events"),
      'statisticpopulation' => array("href" => "/ph/co2/city/statisticpopulation", "public" => true),
      'getcitydata'         => array("href" => "/ph/co2/city/getcitydata", "public" => true),
      'getcityjsondata'     => array("href" => "/ph/co2/city/getcityjsondata", "public" => true),
      'statisticcity'       => array("href" => "/ph/co2/city/statisticcity", "public" => true),
      'statisticPopulation' => array("href" => "/ph/co2/city/statisticPopulation", "public" => true),
      'getcitiesdata'       => array("href" => "/ph/co2/city/getcitiesdata"),
      'opendata'            => array("href" => "/ph/co2/city/opendata","public" => true),
      'getoptiondata'       => array("href" => "/ph/co2/city/getoptiondata"),
      'getlistoption'       => array("href" => "/ph/co2/city/getlistoption"),
      'getpodopendata'      => array("href" => "/ph/co2/city/getpodopendata"),
      'addpodopendata'      => array("href" => "/ph/co2/city/addpodopendata"),
      'getlistcities'       => array("href" => "/ph/co2/city/getlistcities"),
      'creategraph'         => array("href" => "/ph/co2/city/creategraph"),
      'graphcity'           => array("href" => "/ph/co2/city/graphcity"),
      'updatecitiesgeoformat' => array("href" => "/ph/co2/city/updatecitiesgeoformat","public" => true),
      'getinfoadressbyinsee'  => array("href" => "/ph/co2/city/getinfoadressbyinsee"),
      'cityexists'          => array("href" => "/ph/co2/city/cityexists"),
      'autocompletemultiscope'          => array("href" => "/ph/co2/city/autocompletemultiscope"),
      "save"               => array("href" => "/ph/co2/city/save", "public" => true),
      'getlevel'          => array("href" => "/ph/co2/city/getlevel"),
    ),
    "news"=> array(
      "index"   => array( "href" => "/ph/co2/news/index", "public" => true,'title' => "Fil d'actualités - N.E.W.S", "subTitle"=>"Nord.Est.West.Sud","pageTitle"=>"Fil d'actualités - N.E.W.S"),
      "latest"  => array( "href" => "/ph/co2/news/latest"),
      "save"    => array( "href" => "/ph/co2/news/save"),
      "detail"    => array( "href" => "/ph/co2/news/detail"),
      "delete"    => array( "href" => "/ph/co2/news/delete"),
      "updatefield"    => array( "href" => "/ph/co2/news/updatefield"),
      "update"    => array( "href" => "/ph/co2/news/update"),
      "extractprocess" => array( "href" => "/ph/co2/news/extractprocess"),
      "moderate" => array( "href" => "/ph/co2/news/moderate"),
      "share"          => array("href" => "/ph/co2/news/share"),
    ),
    "search"=> array(
      "getmemberautocomplete" => array("href" => "/ph/co2/search/getmemberautocomplete"),
      "getshortdetailsentity" => array("href" => "/ph/co2/search/getshortdetailsentity"),
      "index"                 => array("href" => "/ph/co2/search/index"),
      "mainmap"               => array("href" => "/ph/co2/default/mainmap", "public" => true)
    ),
    "network" => array(
      "simplydirectory"    => array("href" => "/ph/co2/network/simplydirectory")
    ),
    "rooms"=> array(
      "index"    => array("href" => "/ph/co2/rooms/index"),
      "saveroom" => array("href" => "/ph/co2/rooms/saveroom"),
      "editroom" => array("href" => "/ph/co2/rooms/editroom"),
      "external" => array("href" => "/ph/co2/rooms/external"),
      "actions"  => array("href" => "/ph/co2/rooms/actions"),
      "action"   => array("href" => "/ph/co2/rooms/action"),
      "editaction" => array("href" => "/ph/co2/rooms/editaction"),
      'saveaction' => array("href" => "/ph/co2/rooms/saveaction"),
      'closeaction' => array("href" => "/ph/co2/rooms/closeaction"),
      'assignme' => array("href" => "/ph/co2/rooms/assignme"),
      'fastaddaction' => array("href" => "/ph/co2/rooms/fastaddaction"),
      'move' => array("href" => "/ph/co2/rooms/move"),
    ),
    "gantt"=> array(
      "index"            => array("href" => "/ph/co2/gantt/index", "public" => true),
      "savetask"         => array("href" => "/ph/co2/gantt/savetask"),
      "removetask"       => array("href" => "/ph/co2/gantt/removetask"),
      "generatetimeline" => array("href" => "/ph/co2/gantt/generatetimeline"),
      "addtimesheetsv"   => array("href" => "/ph/co2/gantt/addtimesheetsv"),
    ),
    "need"=> array(
        "index" => array("href" => "/ph/co2/need/index", "public" => true),
        "description" => array("href" => "/ph/co2/need/dashboard/description"),
        "dashboard" => array("href" => "/ph/co2/need/dashboard"),
        "detail" => array("href" => "/ph/co2/need/detail", "public" => true),
        "saveneed" => array("href" => "/ph/co2/need/saveneed"),
        "updatefield" => array("href" => "/ph/co2/need/updatefield"),
        "addhelpervalidation" => array("href" => "/ph/co2/need/addhelpervalidation"),
        "addneedsv" => array("href" => "/ph/co2/need/addneedsv"),
      ),
    "person"=> array(
        "login"           => array("href" => "/ph/co2/person/login",'title' => "Log me In"),
        "logged"           => array("href" => "/ph/co2/person/logged"),
        "sendemail"       => array("href" => "/ph/co2/person/sendemail"),
        "index"           => array("href" => "/ph/co2/person/dashboard",'title' => "My Dashboard"),
        "authenticate"    => array("href" => "/ph/co2/person/authenticate",'title' => "Authentication"),
        "dashboard"       => array("href" => "/ph/co2/person/dashboard"),
        "detail"          => array("href" => "/ph/co2/person/detail", "public" => true),
        "follows"         => array("href" => "/ph/co2/person/follows"),
        "disconnect"      => array("href" => "/ph/co2/person/disconnect"),
        "register"        => array("href" => "/ph/co2/person/register"),
        "activate"        => array('href' => "/ph/co2/person/activate"),
        "updatesettings"        => array('href' => "/ph/co2/person/updatesettings"),
        "validateinvitation" => array('href' => "/ph/co2/person/validateinvitation", "public" => true),
        "logout"          => array("href" => "/ph/co2/person/logout"),
        'getthumbpath'    => array("href" => "/ph/co2/person/getThumbPath"),
        'getnotification' => array("href" => "/person/getNotification"),
        'changepassword'  => array("href" => "/person/changepassword"),
        'changerole'      => array("href" => "/person/changerole"),
        'checkusername'   => array("href" => "/person/checkusername"),
        "invite"          => array("href" => "/ph/co2/person/invite"),
        "invitation"      => array("href" => "/ph/co2/person/invitation"),
        "updatefield"     => array("href" => "/person/updatefield"),
        "update"          => array("href" => "/person/update"),
        "getuserautocomplete" => array('href' => "/person/getUserAutoComplete"),
        'checklinkmailwithuser'   => array("href" => "/ph/co2/checklinkmailwithuser"),
        'getuseridbymail'   => array("href" => "/ph/co2/getuseridbymail"),
        "getbyid"         => array("href" => "/ph/co2/person/getbyid"),
        "getorganization" => array("href" => "/ph/co2/person/getorganization"),
        "updatename"      => array("href" => "/ph/co2/person/updatename"),
        "updateprofil"      => array("href" => "/ph/co2/person/updateprofil"),
        "updatewithjson"      => array("href" => "/ph/co2/person/updatewithjson"),
        "updatemultitag"      => array("href" => "/ph/co2/person/updatemultitag"),
        "updatemultiscope"      => array("href" => "/ph/co2/person/updatemultiscope"),
        "sendinvitationagain"      => array("href" => "/ph/co2/person/sendinvitationagain"),
        "removehelpblock"      => array("href" => "/ph/co2/person/removehelpblock"),

        
        "chooseinvitecontact"=> array('href'    => "/ph/co2/person/chooseinvitecontact"),
        "sendmail"=> array('href'   => "/ph/co2/person/sendmail"),
        
        "telegram"               => array("href" => "/ph/co2/person/telegram", "public" => true),
        
        //Init Data
        "clearinitdatapeopleall"  => array("href" =>"'/ph/co2/person/clearinitdatapeopleall'"),
        "initdatapeopleall"       => array("href" =>"'/ph/co2/person/initdatapeopleall'"),
        "importmydata"            => array("href" =>"'/ph/co2/person/importmydata'"),
        "about"                   => array("href" => "/person/about"),
        "data"                    => array("href" => "/person/scopes"),
        "directory"               => array("href" => "/ph/co2/city/directory", "public" => true, "title"=>"My Directory", "subTitle"=>"My Network : People, Organizations, Events"),
        

        "get"      => array("href" => "/ph/co2/person/get"),
        "getcontactsbymails"      => array("href" => "/ph/co2/person/getcontactsbymails"),
        "updatescopeinter" => array("href" => "/ph/co2/person/updatescopeinter"),
    ),
    "organization"=> array(
      "addorganizationform" => array("href" => "/ph/co2/organization/addorganizationform",
                                     'title' => "Organization", 
                                     "subTitle"=>"Découvrez les organization locales",
                                     "pageTitle"=>"Organization : Association, Entreprises, Groupes locales"),
      "save"             => array("href" => "/ph/co2/organization/save",
                                     'title' => "Organization", 
                                     "subTitle"=>"Découvrez les organization locales",
                                     "pageTitle"=>"Organization : Association, Entreprises, Groupes locales"),
      "update"              => array("href" => "/ph/co2/organization/update",
                                     'title' => "Organization", 
                                     "subTitle"=>"Découvrez les organization locales",
                                     "pageTitle"=>"Organization : Association, Entreprises, Groupes locales"),
      "getbyid"             => array("href" => "/ph/co2/organization/getbyid"),
      "updatefield"         => array("href" => "/ph/co2/organization/updatefield"),
      "join"                => array("href" => "/ph/co2/organization/join"),
      "sig"                 => array("href" => "/ph/co2/organization/sig"),
      //Links // create a Link controller ?
      "addneworganizationasmember"  => array("href" => "/ph/co2/organization/AddNewOrganizationAsMember"),
      //Dashboards
      "dashboard"           => array("href"=>"/ph/co2/organization/dashboard"),
      "dashboardmember"     => array("href"=>"/ph/co2/organization/dashboardMember"),
      "dashboard1"          => array("href"=>"/ph/co2/organization/dashboard1"),
      "directory"           => array("href"=>"/ph/co2/organization/directory", "public" => true),
      "disabled"            => array("href"=>"/ph/co2/organization/disabled"),
      "detail"              => array("href"=>"/ph/co2/organization/detail", "public" => true),
      "addmember"           => array("href"=>"/ph/co2/organization/addmember"),
      "updatesettings"      => array('href'=>"/ph/co2/organization/updatesettings"),
      "get"                 => array("href" => "/ph/co2/organization/get"),
    ),
    "event"=> array(
      "save"            => array("href" => "/ph/co2/event/save"),
      "update"          => array("href" => "/ph/co2/event/update"),
      "saveattendees"   => array("href" => "/ph/co2/event/saveattendees"),
      "removeattendee"  => array("href" => "/ph/co2/event/removeattendee"),
      "detail"          => array("href" => "/ph/co2/event/detail", "public" => true),
      "delete"          => array("href" => "ph/co2/event/delete"),
      "updatefield"     => array("href" => "ph/co2/event/updatefield"),
      "calendarview"    => array("href" => "ph/co2/event/calendarview"),
      "eventsv"         => array("href" => "ph/co2/event/eventsv" , "public" => true),
      "directory"       => array("href"=>"/ph/co2/event/directory", "public" => true),
      "addattendeesv"   => array("href"=>"/ph/co2/event/addattendeesv"),
      "updatesettings"      => array('href'=>"/ph/co2/event/updatesettings")
    ),
    "project"=> array(
      "edit"            => array("href" => "/ph/co2/project/edit"),
      "get"          => array("href" => "/ph/co2/project/get"),
      "save"            => array("href" => "/ph/co2/project/save"),
      "update"            => array("href" => "/ph/co2/project/update"),
      "savecontributor" => array("href" => "/ph/co2/project/savecontributor"),
      "dashboard"       => array("href" => "/ph/co2/project/dashboard"),
      "detail"          => array("href" => "/ph/co2/project/detail", "public" => true),
      "removeproject"   => array("href" => "/ph/co2/project/removeproject"),
      "editchart"       => array("href" => "/ph/co2/project/editchart"),
      "updatefield"     => array("href" => "/ph/co2/project/updatefield"),
      "projectsv"       => array("href" => "/ph/co2/project/projectsv"),
      "addcontributorsv" => array("href" => "/ph/co2/project/addcontributorsv"),
      "addchartsv"      => array("href" => "/ph/co2/project/addchartsv"),
      "directory"       => array("href"=>"/ph/co2/project/directory", "public" => true),
      "updatesettings"  => array('href'=>"/ph/co2/project/updatesettings"),
    ),
    "chart" => array(
	    "addchartsv"      => array("href" => "/ph/co2/chart/addchartsv"),
		  "index"      => array("href" => "/ph/co2/chart/index"),
      "header"      => array("href" => "/ph/co2/chart/header"),
		  "editchart"       => array("href" => "/ph/co2/chart/editchart"),
		  "get"       => array("href" => "/ph/co2/chart/get"),
    ),
    "job"=> array(
      "edit"    => array("href" => "/ph/co2/job/edit"),
      "public"  => array("href" => "/ph/co2/job/public"),
      "save"    => array("href" => "/ph/co2/job/save"),
      "delete"  => array("href" => "/ph/co2/job/delete"),
      "list"    => array("href" => "/ph/co2/job/list"),
    ),
    "pod" => array(
      "slideragenda" => array("href" => "/ph/co2/pod/slideragenda", "public" => true),
      "photovideo"   => array("href" => "ph/co2/pod/photovideo"),
      "fileupload"   => array("href" => "ph/co2/pod/fileupload"),
      "activitylist"   => array("href" => "ph/co2/pod/activitylist"),
    ),
    "bookmark" => array(
      "delete"        => array("href" => "ph/communecter/bookmark/delete"),
    ),
    "slug" => array(
      "check"        => array("href" => "ph/communecter/slug/check"),
      "getinfo"        => array("href" => "ph/communecter/slug/getinfo"),
    ),
    "gallery" => array(
      "index"        => array("href" => "ph/communecter/gallery/index"),
      "gallery"        => array("href" => "ph/communecter/gallery/gallery"),
      "crudcollection"        => array("href" => "ph/communecter/gallery/crudcollection"),
      "crudfile"        => array("href" => "ph/communecter/gallery/crudfile"),
      "removebyid"   => array("href" => "ph/communecter/gallery/removebyid"),
      "filter"   => array("href" => "ph/communecter/gallery/filter"),
    ),
    "link" => array(
      "removemember"        => array("href" => "/ph/co2/link/removemember"),
      "removerole"        => array("href" => "/ph/co2/link/removerole"),
      "removecontributor"   => array("href" => "/ph/co2/link/removecontributor"),
      "disconnect"        => array("href" => "/ph/co2/link/disconnect"),
      "connect"           => array("href" => "/ph/co2/link/connect"),
      "multiconnect"           => array("href" => "/ph/co2/link/multiconnect"),
      "follow"           => array("href" => "/ph/co2/link/follow"),
      "validate"          => array("href" => "/ph/co2/link/validate"),
    ),
    "document" => array(
      "resized"             => array("href"=> "/ph/communecter/document/resized", "public" => true),
      "list"                => array("href"=> "/ph/communecter/document/list"),
      "save"                => array("href"=> "/ph/communecter/document/save"),
      "deleteDocumentById"  => array("href"=> "/ph/communecter/document/deleteDocumentById"),
      "removeAndBacktract"  => array("href"=> "/ph/communecter/document/removeAndBacktract"),
      "getlistbyid"         => array("href"=> "ph/communecter/document/getlistbyid"),
      "upload"              => array("href"=> "ph/communecter/document/upload"),
      "update"              => array("href"=> "ph/communecter/document/update"),
      "uploadsave"          => array("href"=> "ph/communecter/document/uploadsave"),
      "delete"              => array("href"=> "ph/communecter/document/delete")
    ),
    "survey" => array(
      "index"       => array("href" => "/ph/co2/survey/index", "public" => true),
      "entries"     => array("href" => "/ph/co2/survey/entries", "public" => true),
      "savesession" => array("href" => "/ph/co2/survey/savesession"),
      "savesurvey"  => array("href" => "/ph/co2/survey/savesurvey"),
      "delete"      => array("href" => "/ph/co2/survey/delete"),
      "addaction"   => array("href" => "/ph/co2/survey/addaction"),
      "moderate"    => array("href" => "/ph/co2/survey/moderate"),
      "entry"       => array("href" => "/ph/co2/survey/entry", "public" => true ),
      "graph"       => array("href" => "/ph/co2/survey/graph"),
      "textarea"    => array("href" => "/ph/co2/survey/textarea"),
      "editlist"    => array("href" => "/ph/co2/survey/editList"),
      "multiadd"    => array("href" => "/ph/co2/survey/multiadd"),
      "close"       => array("href" => "/ph/co2/survey/close"),
      "editentry"   => array("href" => "/ph/co2/survey/editentry"),
      "fastaddentry"=> array("href" => "/ph/co2/survey/fastaddentry"),
    ),
    "discuss"=> array(
      "index" => array( "href" => "/ph/co2/discuss/index", "public" => true),
    ),
    "comment"=> array(
      "index"        => array( "href" => "/ph/co2/comment/index", "public" => true),
      "save"         => array( "href" => "/ph/co2/comment/save"),
      'abuseprocess' => array( "href" => "/ph/co2/comment/abuseprocess"),
      "testpod"      => array("href"  => "/ph/co2/comment/testpod"),
      "moderate"     => array( "href" => "/ph/co2/comment/moderate"),
      "delete"       => array( "href" => "/ph/co2/comment/delete"),
      "updatefield"  => array( "href" => "/ph/co2/comment/updatefield"),
      "countcommentsfrom" => array( "href" => "/ph/co2/comment/countcommentsfrom"),
    ),
    "action"=> array(
       "addaction"   => array("href" => "/ph/co2/action/addaction"),
    ),
    "notification"=> array(
      "getnotifications"          => array("href" => "/ph/co2/notification/get","json" => true),
      "marknotificationasread"    => array("href" => "/ph/co2/notification/remove"),
      "markallnotificationasread" => array("href" => "/ph/co2/notification/removeall"),
      "update"                    => array("href" => "/ph/co2/notification/update"),
    ),
    "gamification"=> array(
      "index" => array("href" => "/ph/co2/gamification/index"),
    ),
    "graph"=> array(
      "viewer" => array("href" => "/ph/co2/graph/viewer"),
    ),
    "log"=> array(
      "monitoring" => array("href" => "/ph/co2/log/monitoring"),
      "dbaccess"  => array("href" => "/ph/co2/log/dbaccess"),
      "clear"  => array("href" => "/ph/co2/log/clear"),
    ),
    "stat"=> array(
      "createglobalstat" => array("href" => "/ph/co2/stat/createglobalstat"),
    ),
    "mailmanagement"=> array(
      "droppedmail" => array("href" => "/co2/mailmanagement/droppedmail"),
    ),
    "element"=> array(
      "updatesettings"      => array('href' => "/ph/co2/element/updatesettings"),
      "updatefield"         => array("href" => "/ph/co2/element/updatefield"),
      "updatefields"        => array("href" => "/ph/co2/element/updatefields"),
      "updateblock"         => array("href" => "/ph/co2/element/updateblock"),
      "detail"              => array("href" => "/ph/co2/element/detail", "public" => true),
      "getalllinks"         => array("href" => "/ph/co2/element/getalllinks"),
      "geturls"             => array("href" => "/ph/co2/element/geturls"),
      "getcontacts"         => array("href" => "/ph/co2/element/getcontacts"),
      "simply"              => array("href" => "/ph/co2/element/simply", "public" => true),
      "directory"           => array("href" => "/ph/co2/element/directory", "public" => true),
      "directory2"          => array("href" => "/ph/co2/element/directory2", "public" => true),
      "addmembers"          => array("href" => "/ph/co2/element/addmembers", "public" => true),
      "aroundme"            => array("href" => "/ph/co2/element/aroundme"),
      "save"                => array("href" => "/ph/co2/element/save"),
      "savecontact"         => array("href" => "/ph/co2/element/savecontact"),
      "saveurl"             => array("href" => "/ph/co2/element/saveurl"),
      "get"                 => array("href" => "/ph/co2/element/get"),
      "delete"              => array("href" => "/ph/co2/element/delete"),
      "notifications"       => array("href" => "/ph/co2/element/notifications"),
      "about"               => array("href" => "/ph/co2/element/about"),
      "getdatadetail"       => array("href" => "/ph/co2/element/getdatadetail"),
      "stopdelete"          => array("href" => "/ph/co2/element/stopdelete"),
      'getthumbpath'    => array("href" => "/ph/co2/element/getThumbPath"),
      'getcommunexion'    => array("href" => "/ph/co2/element/getcommunexion"),
    ),
    "app" => array(
      "welcome"             => array('href' => "/ph/co2/app/welcome",         "public" => true),
      "index"             => array('href' => "/ph/co2/app/index",             "public" => true),
      "web"               => array('href' => "/ph/co2/app/web",               "public" => true),
      "websearch"         => array('href' => "/ph/co2/app/websearch",         "public" => true),
      "live"              => array('href' => "/ph/co2/app/live",              "public" => true),
      "media"             => array('href' => "/ph/co2/app/media",             "public" => true),
      "referencement"     => array('href' => "/ph/co2/app/referencement",     "public" => true),
      "savereferencement" => array('href' => "/ph/co2/app/savereferencement", "public" => true),
      "annonces"          => array('href' => "/ph/co2/app/annonces",          "public" => true),
      "live"              => array('href' => "/ph/co2/app/live",              "public" => true),
      "agenda"            => array('href' => "/ph/co2/app/agenda",            "public" => true),
      "mediacrawler"      => array('href' => "/ph/co2/app/mediacrawler",      "public" => false),
      "page"              => array('href' => "/ph/co2/app/page",              "public" => true),
      "search"            => array('href' => "/ph/co2/app/search",            "public" => true),
      "agenda"            => array('href' => "/ph/co2/app/agenda",            "public" => true),
      "power"             => array('href' => "/ph/co2/app/power",             "public" => true),
      "superadmin"        => array('href' => "/ph/co2/app/superadmin",        "public" => false),
      "admin"             => array('href' => "/ph/co2/app/admin",      "public" => false),
      "info"              => array('href' => "/ph/co2/app/info",              "public" => true),
      "city"              => array('href' => "/ph/co2/app/city",              "public" => false),
      "chat"              => array('href' => "/ph/co2/app/chat",              "public" => true),
      "sendmailformcontact" => array('href' => "/ph/co2/app/sendmailformcontact", "public" => true),
      "sendmailformcontactprivate" => array('href' => "/ph/co2/app/sendmailformcontactprivate", "public" => true),
      "checkurlexists" => array('href' => "/ph/co2/app/checkurlexists", "public" => true),
      "rooms" => array('href' => "/ph/co2/app/rooms", "public" => true),
      "survey" => array('href' => "/ph/co2/app/survey", "public" => true),
      "interoperability" => array(
        "index"              => array('href' => 'ph/co2/interoperability/index',  "public" => true),
        "get"              => array('href' => 'ph/co2/interoperability/get',  "public" => true),
        "copedia"              => array('href' => 'ph/co2/interoperability/copedia',  "public" => true),
        "co-osm"              => array('href' => 'ph/co2/interoperability/co-osm',  "public" => true),
        "co-osm-getode"      => array('href' => 'ph/co2/interoperability/co-osm-getnode',  "public" => true),
        "wikitoco"              => array('href' => 'ph/co2/interoperability/wikitoco',  "public" => true),
        "pushtypewikidata"    => array('href' => 'ph/co2/interoperability/pushtypewikidata',  "public" => true),
        "wikidata-put-description"    => array('href' => 'ph/co2/interoperability/wikidata-put-description',  "public" => true),
      ),
    ),
    "siteurl" => array(
      "incnbclick"        => array('href' => "ph/co2/siteurl/incnbclick")
    ),
    "cooperation" => array(
      "getcoopdata"        => array('href' => "ph/co2/cooperation/getcoopdata"),
      "savevote"           => array('href' => "ph/co2/cooperation/savevote"),
      "deleteamendement"  => array('href' => "ph/co2/cooperation/deleteamendement")
    ),
    "pdf" => array(
      "create"        => array('href' => "ph/co2/pdf/create")
    ),
  );

  function initPage(){
    
    //review the value of the userId to check loosing session
    //creates an issue with Json requests : to clear add josn:true on the page definition here 
    //if( Yii::app()->request->isAjaxRequest && (!isset( $page["json"] )) )
      //echo "<script type='text/javascript'> userId = '".Yii::app()->session['userId']."'; var blackfly = 'sosos';</script>";
    Yii::app()->params["version"] = $this->version ;
    if( @$_GET["theme"] ){
      Yii::app()->theme = $_GET["theme"];
      Yii::app()->session["theme"] = $_GET["theme"];
    }
    else if(@Yii::app()->session["theme"])
      Yii::app()->theme = Yii::app()->session["theme"];
    /*else
      Yii::app()->theme = "ph-dori";*/

    //managed public and private sections through a url manager
    if( Yii::app()->controller->id == "admin" && !Yii::app()->session[ "userIsAdmin" ] )
      throw new CHttpException(403,Yii::t('error','Unauthorized Access.'));

    if( Yii::app()->controller->id == "adminpublic" && ( !Yii::app()->session[ "userIsAdmin" ] && !Yii::app()->session[ "userIsAdminPublic" ] ) )
      throw new CHttpException(403,Yii::t('error','Unauthorized Access.'));

    if( Yii::app()->controller->id != "test")
      $page = $this->pages[Yii::app()->controller->id][Yii::app()->controller->action->id];
    $pagesWithoutLogin = array(
                            //Login Page
                            "person/login", 
                            "person/register", 
                            "person/authenticate", 
                            "person/activate", 
                            "person/sendemail",
                            "person/checkusername",
                            //Document Resizer
                            "document/resized");
    
    $prepareData = true;
    //if (true)//(isset($_SERVER["HTTP_ORIGIN"]) )//&& $_SERVER["REMOTE_ADDR"] == "52.30.32.155" ) //this is an outside call 
    //{ 
      //$host = "meteor.communecter.org";
      //if (strpos("http://".$host, $_SERVER["HTTP_ORIGIN"]) >= 0 || strpos("https://".$host, $_SERVER["HTTP_ORIGIN"]) >= 0 ){
    if( isset( $_POST["X-Auth-Token"]) && Authorisation::isMeteorConnected( $_POST["X-Auth-Token"] ) ){
      $prepareData = false;
      //once the token is check => remove the token from the post
      unset($_POST["X-Auth-Token"]);
    } 
    //Api access through REST 
    //no need to prepare interface data
    else if (!Yii::app()->session[ "userId" ] &&  isset($_SERVER['PHP_AUTH_USER']) && Authorisation::isValidUser($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])) {
      $prepareData = false;
    }
    //}
    else if( (!isset( $page["public"] ) ) && (!isset( $page["json"] ))
      && !in_array(Yii::app()->controller->id."/".Yii::app()->controller->action->id, $pagesWithoutLogin)
      && !Yii::app()->session[ "userId" ] )
    {
        Yii::app()->session["requestedUrl"] = Yii::app()->request->url;
        //if( Yii::app()->request->isAjaxRequest)
          //echo "<script type='text/javascript'> checkIsLoggued('".Yii::app()->session['userId']."'); </script>";
         
    }
    
    if( isset( $_GET["backUrl"] ) )
      Yii::app()->session["requestedUrl"] = $_GET["backUrl"];
    /*if( !isset(Yii::app()->session['logguedIntoApp']) || Yii::app()->session['logguedIntoApp'] != $this->module->id)
      $this->redirect(Yii::app()->createUrl("/".$this->module->id."/person/logout"));*/
    if( $prepareData )
    {
      $this->sidebar1 = array_merge( Menu::menuItems(), $this->sidebar1 );
      $this->person = Person::getPersonMap(Yii::app() ->session["userId"]);
      $this->title = (isset($page["title"])) ? $page["title"] : $this->title;
      $this->subTitle = (isset($page["subTitle"])) ? $page["subTitle"] : $this->subTitle;
      $this->pageTitle = (isset($page["pageTitle"])) ? $page["pageTitle"] : $this->pageTitle;
      $this->notifications = ActivityStream::getNotifications( array( "notify.id" => Yii::app()->session["userId"] ) );
      CornerDev::addWorkLog("communecter",Yii::app()->session["userId"],Yii::app()->controller->id,Yii::app()->controller->action->id);
    }

    //load any DB config Params
    Application::loadDBAppConfig();    
  }
  
  protected function beforeAction($action){
    if( $_SERVER['SERVER_NAME'] == "127.0.0.1" || $_SERVER['SERVER_NAME'] == "localhost" ){
      Yii::app()->assetManager->forceCopy = true;
      //if(Yii::app()->controller->id."/".Yii::app()->controller->action->id != "log/dbaccess")
        //Yii::app()->session["dbAccess"] = 0;
    }

    $this->manageLog();

    return parent::beforeAction($action);
  }


  protected function afterAction($action){
    return parent::afterAction($action);
  }

  /**
   * Start the log process
   * Bring back log parameters, then set object before action and save it if there is no return
   * If there is return, the method save in session the log object which will be finished and save in db during the method afteraction
   */
  protected function manageLog(){
    //Bring back logs needed
    $actionsToLog = Log::getActionsToLog();
    $actionInProcess = Yii::app()->controller->id.'/'.Yii::app()->controller->action->id;

    //Start logs if necessary
    if(isset($actionsToLog[$actionInProcess])) {

      //To let several actions log in the same time
      if(!$actionsToLog[$actionInProcess]['waitForResult']){
        Log::save(Log::setLogBeforeAction($actionInProcess));
      }else if(isset(Yii::app()->session["logsInProcess"]) && is_array(Yii::app()->session["logsInProcess"])){
        Yii::app()->session["logsInProcess"] = array_merge(
          Yii::app()->session["logsInProcess"],
          array($actionInProcess => Log::setLogBeforeAction($actionInProcess))
        );
      } else{
         Yii::app()->session["logsInProcess"] = array($actionInProcess => Log::setLogBeforeAction($actionInProcess));
      }
    }
  }
}

