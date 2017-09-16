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
		if ( @Yii::app()->session["userId"]  && Yii::app()->params['rocketchatEnabled'] )
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

	//test 
	// http://127.0.0.1/ph/co2/rocketchat/logint
	// existing user with good pwd > genertes token 
	// existing user with bad pwd > msg > Unauthorised
	// inexistant user > msg > Unauthorised
	public function actionLogint($email=null,$pwd=null) {
		header('Content-Type: application/json');
		if(Yii::app()->session["userId"])
		{
			
			Yii::app()->session["adminLoginToken"]   = null;
			Yii::app()->session["adminRocketUserId"] = null;
			Yii::app()->session["loginToken"]        = null;
			Yii::app()->session["rocketUserId"]      = null;
			

		    Yii::app()->session["adminLoginToken"] = Yii::app()->params["adminLoginToken"];
		    Yii::app()->session["adminRocketUserId"] = Yii::app()->params["adminRocketUserId"];

		    

		    if(!@Yii::app()->session["loginToken"]){
				$rocket = RocketChat::getToken( $email, $pwd );
				Yii::app()->session["loginToken"] = $rocket["loginToken"];
			  	Yii::app()->session["rocketUserId"] = $rocket["rocketUserId"];
			  }
		  	$rocket["loginToken"] = Yii::app()->session["loginToken"];
		    $rocket["rocketUserId"] = Yii::app()->session["rocketUserId"];
		    $rocket["adminLoginToken"] = Yii::app()->params["adminLoginToken"];
		    $rocket["adminRocketUserId"] = Yii::app()->params["adminRocketUserId"];
		    $rocket['username'] = Yii::app()->session['user']['username'];
		    $rocket['email'] = $email;

	 		echo json_encode($rocket);
	 	} else 
	 		Rest::json( array("result"=>false,"error"=>"Must be Loggued in."));
		  
	}

	//tested 
	// All actions are driven by the coAdmin user 
	// creations and invites
	// accessing Element > creates 
		// channels : http://127.0.0.1/ph/co2/rocketchat/chat/name/openatlas/type/test/roomType/channel/test/true
		// groups : http://127.0.0.1/ph/co2/rocketchat/chat/name/openatlas/type/test/roomType/group/test/true
	public function actionChat($name,$type="",$id=null,$roomType=null) {
		$group = null;
		if(Yii::app()->session["userId"])
		{
			/*if( $type == Person::COLLECTION ){
				//id will contain the username
				/*$roomType == "direct";
				$path = "/direct/".$name;
				$group = RocketChat::createDirect($id);*/
				//$group = array("msg" => "all users are created on first login");
			//} else*/
			if($roomType == "channel"){
				$path = "/channel/".$name;
		 		$group = RocketChat::createGroup ($name,$roomType, Yii::app()->session['user']['username']); 
			}
			else{
				$path = "/group/".$name;
				$group = null;
				if(Authorisation::canEditItem(Yii::app()->session['userId'], $type, $id) || 
					Link::isLinked($id,$type,Yii::app()->session["userId"]) ){
		 			$group = RocketChat::createGroup ($name,null, Yii::app()->session['user']['username']);
		 		} else 
		 			Rest::json(array("result"=>false,
		 							 "error"=>"Unauthorized Access.",
		 							 "canEdit" => Authorisation::canEditItem(Yii::app()->session['userId'], $type, $id),
		 							 "userId"=>Yii::app()->session['userId'], 
		 							 "userEmail"=>Yii::app()->session['userEmail'], 
		 							 "type"=>$type, "id"=>$id));

		 		
			}

			if($group != null && @$group->create->channel->_id ) {
		 		$result = PHDB::update( $type,  array("_id" => new MongoId($id)), 
		 										array('$set' => array("hasRC"=>true) ));
		 		// TODO : notification or news
				Notification::constructNotification(ActStr::VERB_ADD, 
					array("id" => Yii::app()->session["userId"],"name"=> Yii::app()->session["user"]["name"]), 
					array( "type"=>$type,"id"=> $id), 
					null, 
					"chat"
				);

				/*array( "text"=>"Oyé Oyé , ".Yii::app()->session["user"]["name"]." a créé la fusée pour Dailoguer en direct : Click pour découvrir le Rocket Chat de la Communauté.", 
					   "parentType"=>$type,
					   "parentId"=>$id,
					   "scope"=>"private",
					   "media"=>array(
					   			"type"=>"url_content", 
					   			"content"=> array(
					   				"url"=>Yii::app()->getRequest()->getBaseUrl(true)."/themes/CO2//assets/img/bg_pixeltree2.jpg",
					   				"image"=>Yii::app()->getRequest()->getBaseUrl(true)."/themes/CO2//assets/img/bg_pixeltree2.jpg", 
					   				"imageSize":"large")), 
					   "type"=>"news");
				News::save($array);*/
		 	}

		 	//echo json_encode($group);
		 	//$embed = true;
		 	/*if(Yii::app()->request->isAjaxRequest && !$noRender){
		 		$this->renderPartial( "iframe", array( 'path'=>$path, "embed"=>$embed) );
		 	} else {*/
	 		
	 		Rest::json($group);
	 	} else 
	 		Rest::json( array("result"=>false,"error"=>"Must be Loggued in."));
	 	
	}

	public function actionInvite($name,$type="",$id=null,$roomType=null,$test=null) {
		$group = null;
		$group = RocketChat::invite ($type."_".$name,$roomType, Yii::app()->session['user']['username']);

	}

	public function actionList() {
		if(@Yii::app()->session['userId'] && @Yii::app()->session["loginToken"] )
 			Rest::json( RocketChat::listUserChannels() );
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
		$admin = new \RocketChat\User(Yii::app()->params['rocketAdmin'], Yii::app()->params['rocketAdminPwd'],null,true);
		//$admin = new \RocketChat\User("openatlas974@gmail.com", "2210open");
		//$admin = new \RocketChat\User("clement.damiens@gmail.com", "blaiross");

		//5715348040bb4e873d1d650b
		if( $admin->login() ) {
			echo "user logged in<br/>";
		};
		$admin->info();
		echo "username {$admin->username}<br/>id ({$admin->id})<br/>authToken ({$admin->authToken}) <br/>";

		/*echo ">>>> list channels <br/>";
		$list = $admin->listJoined();
        foreach ($list as $key => $value) {
        	echo $key." channel : ".$value." <br/>";
        }*/

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


		//$channel = new \RocketChat\Group( 'test8priv',array("openatlas"));
		$channel = new \RocketChat\Group( 'projects_booom-closed');

		//creates if doesn't exist
		/*
		echo ">>>> channel create<br/>";
		$res = $channel->create();
        var_dump($res);*/

        echo "<br/>>>>> channel info :  ({$channel->name})<br/>";
		$res = $channel->info();
		var_dump($res);
		if($channel->id == null)
			echo "<br/><b style='color:red'>you dont have access to this room</b><br/>";
		else 
			echo "<br/>channel  id ({$channel->id}) <br/>name ({$channel->name})<br/>";
         


		//if( !$res->success && $res->errorType == "error-duplicate-channel-name" ){
			//set as private 
			//$channel->setType("crocket","p");


        	//echo "<br/>>>>> invite new user<br/>";
        	//$res = $channel->invite("openatlas");
			$res = $channel->invite("Bouboule");
			var_dump($res);
        //}

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