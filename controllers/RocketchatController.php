<?php
/**
 * ActionController.php
 *
 * @author: Sylvain Barbot <sylvain.barbot@gmail.com>
 * Date: 7/29/15
 * Time: 12:25 AM
 */
class RocketchatController extends CommunecterController {
  


	protected function beforeAction($action) {
	    parent::initPage();
	    return parent::beforeAction($action);
	}

	public function actions()
	{
	    return array(
	        //'iframe'    => 'citizenToolKit.controllers.action.AddActionAction'
	    );
	}


	public function actionIndex() {
		if ( @Yii::app()->session["userId"] )
			$this->renderPartial("iframe");
		else {
			Yii::app()->session["goto"] = "/rocketchat";
			$this->redirect( Yii::app()->homeUrl );
		}
	}

	public function actionCors() {
		
		if ( @Yii::app()->session["userId"] )
		{ 
		// use $_SESSION of parent window
		$sessionid = $_COOKIE['PHPSESSID']; 
		 
		// set headers for CORS
		header("Access-Control-Allow-Origin: ".Yii::app()->params['rocketchatURL']);
		header("Access-Control-Allow-Credentials: true ");
		header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
		header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
		header('Content-Type: application/json');
		 
		// return token saved by IFRAME URL page to confirm login
		echo '{ "loginToken":"'.Yii::app()->session['loginToken'].'"}'; 
		} 
	}

	public function actionLogin() {
		/*if(!Yii::app()->session["loginToken"])
			$rocket = RocketChat::getToken(Yii::app()->params['userEmail'], Yii::app()->params['rocketAdminPwd']);
		}*/
		$this->renderPartial( "rocket" );
	}

	public function actionLogint() {
		/*$rocket = RocketChat::getToken("oceatoon@gmail.com", "");
		header('Content-Type: application/json');
	 	echo json_encode($rocket);*/
	}

	//http://127.0.0.1/ph/co2/rocketchat/chat/name/openatlas974@gmail.com/type/citoyens
	public function actionChat($name,$type="",$id=null,$roomType=null) {
		if( $type == Person::COLLECTION ){
			//id will contain the username
			$roomType == "direct";
			$path = "/direct/".$name;
			$direct = RocketChat::createDirect($id);
		} elseif($roomType == "channel"){
			$path = "/channel/".$type."_".$name;
	 		$group = RocketChat::createGroup ($type."_".$name,$roomType);
	 		$result = PHDB::update( $type,  array("_id" => new MongoId($id)), 
	 										array('$set' => array("hasRC"=>true) ));
		}
		else{
			$path = "/group/".$type."_".$name;
	 		$group = RocketChat::createGroup ($type."_".$name);
	 		$result = PHDB::update( $type,  array("_id" => new MongoId($id)), 
	 										array('$set' => array("hasRC"=>true) ));
		}
	 	//echo json_encode($group);
	 	$embed = true;
	 	$this->renderPartial( "iframe", array( 'path'=>$path, "embed"=>$embed) );
	}


	public function actionTest() {
  	
	  	/*define('REST_API_ROOT', '/api/v1/');
		define('ROCKET_CHAT_INSTANCE', "https://chat.lescommuns.org");

		Yii::import('rocketchat.RocketChatClient', true);
		Yii::import('rocketchat.RocketChatUser', true);
		Yii::import('rocketchat.RocketChatChannel', true);
		Yii::import('rocketchat.RocketChatGroup', true);
		Yii::import('httpful.Request', true);
		Yii::import('httpful.Bootstrap', true);
		$api = new \RocketChat\Client();
		echo $api->version()." on https://chat.lescommuns.org"; 

		// login as the main admin user
		echo "<br/>***************LOGIN **********************<br/>";
		echo ">>>> login admin<br/>";
		$admin = new \RocketChat\User("oceatoon@gmail.com", "");*/
		

		define('REST_API_ROOT', '/api/v1/');
		define('ROCKET_CHAT_INSTANCE', Yii::app()->params['rocketchatURL']);

		Yii::import('rocketchat.RocketChatClient', true);
		Yii::import('rocketchat.RocketChatUser', true);
		Yii::import('rocketchat.RocketChatChannel', true);
		Yii::import('rocketchat.RocketChatGroup', true);
		Yii::import('httpful.Request', true);
		Yii::import('httpful.Bootstrap', true);
		$api = new \RocketChat\Client();
		echo $api->version()." on ".Yii::app()->params['rocketchatURL']; 


		// login as the main admin user
		echo "<br/>***************LOGIN **********************<br/>";
		$admin = new \RocketChat\User(Yii::app()->params['rocketAdmin'], Yii::app()->params['rocketAdminPwd']);

		//5715348040bb4e873d1d650b
		if( $admin->login() ) {
			echo "admin user logged in<br/>";
		};
		$admin->info();
		echo "username {$admin->nickname}<br/>id ({$admin->id})<br/>authToken ({$admin->authToken}) <br/>";

		

	/*	echo "<br/>***************LIST PRIVATE CHANNELS **********************<br/>";
			$list = $api->list_groups();
			
			foreach ($list as $key => $value) {
					echo $key." :: ".$value->name."<br/>"; 
				}
	*/


	/*	echo "<br/>*********** LIST ALL CHANNELS **************************<br/>";
			$list = $api->list_channels();
			
			foreach ($list as $key => $value) {
					echo $key." :: ".$value->name."<br/>"; 
				}
	*/

$list = array(
//array("Julie","MARTIN","julie.ml.martin@gmail.com"),
//array("Adrien","DISS","adrien@alternatiba.re"),
//array("Marine","MARTINEAU","marine.martineau@gmail.com"),
//array("Simon","CHAUVAT","simon.chauvat@ntymail.com"),
//array("Franck","MONTAUZON","franck@ecomanifestation.re"),
//array("Teddy","JAMOIS","teddy.jamois@gmail.com"),
//array("Quentin","METTLER","quentin.mettler@gmail.com"),
//array("Olivier","FONTAINE","opfontaine@gmail.com"),
//array("Georget","PAUSE","georget.pause@gmail.com"),
//array("PaulHenri","LEBEAU","polenri.lebeau@gmail.com"),
//array("Sylvia","HEYMANN","sylvia_c_h@msn.com"),
//array("MieNicole","BASSONVILLE","ninilakour@hotmail.fr"),
//array("David","GROSLIER","chefgroslier@gmail.com"),
//array("Marion","BASQUIN","basquin.marion@hotmail.fr"),
//array("Philippe","LUCAS","runlucas@gmail.com"),
//array("Sylvain","Brunet","sylvain1brunet@gmail.com"),
//array("Tibor","KATELBACH","oceatoon@gmail.com"),
//array("MehmetGinette","PEKKIP","pekkip@orange.fr"),
//array("Olivier","Cassard","omc.cassard@gmail.com"),
//array("Delphine","CHAUVIERE","delphine.chauviere@medecinsdumonde.net"),
//array("Jessie","LEBON","fnarsoi.chargemissions@gmail.com"),
//array("Florence","CLAIRAMBAULT","f.clairambault@compagnonsbatisseurs.eu"),
//array("Christelle","MOREL","projets.granddir@gmail.com"),
//array("Chloe","EUPHRASIE","granddir974@gmail.com"),
//array("Sand","B","sand.freelance@gmail.com"),
//array("Leo","Robin","leo_pf@yahoo.fr"),
//array("Alexandre","Payet","alexandre_payet@me.com"),
//array("Jahne","Henry","Jahne.anders@gmail.com"),
//array("Stephanie","Ferrere","st.ferrere@gmail.com")
);
		/*  	echo "<br/>*********** TEST NEW USER **************************<br/>";
		  	foreach ($list as $key => $user) 
		  	{
			  	//$user = $list[0];
				  	$newuser = new \RocketChat\User( $user[0].$user[1].'_reunion', 'alternatiba', array(
					'nickname' => $user[0].$user[1],
					'email' => $user[2],
				));
			  	
			  	//$newuser->info();
				//if( !$newuser->login(false) ) {
					// actually create the user if it does not exist yet
					echo ">>>> create user<br/>";
				  $newuser->create();
				//}
				echo "user {$newuser->nickname} created ({$newuser->id})<br/>";
			}*/
		echo "<br/>**************** TEST CREATE/JOIN POST msg to CHANNEL *********************<br/>";
		
		// create a new channel
		//K6YT5zkLBKmKKScWy  'croxxxat'

		$channel = new \RocketChat\Channel( 'alternatiba_pei');
		
		//creates if doesn't exist
		echo ">>>> channel create<br/>";
		$res = $channel->create();
        var_dump($res);
		//set as private 
		//$channel->setType("crocket","p");

		echo ">>>> channel info<br/>";
		$channel->info();
		echo "<br/>channel  id ({$channel->id}) <br/>name ({$channel->name})<br/>";

		/*echo ">>>> invite newuser<br/>";
		$channel->invite($newuser);*/

		// post a message
		//$channel->postMessage('Hello world from PHP RC API code in co2 :smile:');

	 	/* ---------------- Page with ROCKET CHAT in an iframe ----------------------- */
	 }

	 public function actionTestt() {
  	
	  	define('REST_API_ROOT', '/api/v1/');
		define('ROCKET_CHAT_INSTANCE', Yii::app()->params['rocketchatURL']);

		Yii::import('rocketchat.RocketChatClient', true);
		Yii::import('rocketchat.RocketChatUser', true);
		Yii::import('rocketchat.RocketChatChannel', true);
		Yii::import('rocketchat.RocketChatGroup', true);
		Yii::import('httpful.Request', true);
		Yii::import('httpful.Bootstrap', true);
		$api = new \RocketChat\Client();
		echo $api->version()." on ".Yii::app()->params['rocketchatURL']; 


		// login as the main admin user
		echo "<br/>***************LOGIN **********************<br/>";
		$admin = new \RocketChat\User(Yii::app()->params['rocketAdmin'], Yii::app()->params['rocketAdminPwd']);
		if( $admin->login() ) {
			echo "admin user logged in<br/>";
		};
		$admin->info();
		echo "I'm {$admin->nickname} ({$admin->id}) "; echo "<br/>";

	/*	echo "<br/>***************LIST PRIVATE CHANNELS **********************<br/>";
			$list = $api->list_groups();
			
			foreach ($list as $key => $value) {
					echo $key." :: ".$value->name."<br/>"; 
				}
	*/


	/*	echo "<br/>*********** LIST ALL CHANNELS **************************<br/>";
			$list = $api->list_channels();
			
			foreach ($list as $key => $value) {
					echo $key." :: ".$value->name."<br/>"; 
				}
	*/


		  /*	echo "<br/>*********** TEST NEW USER **************************<br/>";

			  	$newuser = new \RocketChat\User('tib_co2', 'alternatiba', array(
				'nickname' => 'tib@co2.org',
				'email' => 'tibor@communecter.org',
			));
		  	
		  	$newuser->info();
			/*if( !$newuser->login(false) ) {
				// actually create the user if it does not exist yet
			  $newuser->create();
			}*/
			//echo "user {$newuser->nickname} created ({$newuser->id})<br/>";

		echo "<br/>**************** TEST CREATE/JOIN POST msg to CHANNEL *********************<br/>";
		
		// create a new channel
		//K6YT5zkLBKmKKScWy  'croxxxat'
		$channel = new \RocketChat\Group( 'croxit');
		
		//creates if doesn't exist
		$channel->create();

		//set as private 
		$channel->setType("crocket","p");

		//invite someone
		$channel->info();
		echo "channel ({$channel->id})<br/>";

		//$channel->invite($newuser);

		// post a message
		//$channel->postMessage('Hello world from PHP RC API code in co2 :smile:');

	 /* ---------------- Page with ROCKET CHAT in an iframe ----------------------- */
	 }
}