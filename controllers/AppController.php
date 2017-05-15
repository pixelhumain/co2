<?php
/**
 * Co2Controller.php
 *
 * @author: Alpha Tango
 * Date: 12/2016
 */
class AppController extends CommunecterController {
  

	protected function beforeAction($action) {
	    parent::initPage();
	    return parent::beforeAction($action);
	}

	public function actions()
	{
	    return array(
	        'index'     		=> 'citizenToolKit.controllers.app.IndexAction',
	        'websearch'     	=> 'citizenToolKit.controllers.app.WebSearchAction',
	        'live'    			=> 'citizenToolKit.controllers.app.LiveAction',
	        'savereferencement' => 'citizenToolKit.controllers.app.SaveReferencementAction',
	        'mediacrawler'  	=> 'citizenToolKit.controllers.app.MediaCrawlerAction',
            'superadmin'        => 'citizenToolKit.controllers.app.SuperAdminAction',
            //'sendmailformcontact' => 'citizenToolKit.controllers.app.SendMailFormContactAction',
            'checkurlexists' => 'citizenToolKit.controllers.app.CheckUrlExistsAction',
	    );
	}


    public function actionIndex(){
        $CO2DomainName = isset( Yii::app()->params["CO2DomainName"]) ? 
                                Yii::app()->params["CO2DomainName"] : "CO2";

        Yii::app()->theme = "CO2";
        Yii::app()->session["theme"] = "CO2";
        $params = CO2::getThemeParams();
        
        $hash = $params["pages"]["#app.index"]["redirect"];
        
        $params = array("type" => @$type );

        if(!@$hash || @$hash=="") $hash="search";
        //echo @$hash; exit;
        if(@$hash == "web"){
            self::actionWeb();
        }else{
           echo $this->renderPartial($hash, $params, true);
        }
    }


    public function actionWelcome(){
        //CO2Stat::incNbLoad("co2-welcome");

        $params = array();
        echo $this->renderPartial("welcome", $params, true);
    }



	public function actionWeb(){ //kgougle
		CO2Stat::incNbLoad("co2-web");

        //get my favorites web sites in my cookies
        $cookiesFav = isset( Yii::app()->request->cookies['webFavorites'] ) 
                      && Yii::app()->request->cookies['webFavorites'] != "" ? 
		   			  explode(",", Yii::app()->request->cookies['webFavorites']->value) : 
                      array();

    	//var_dump($cookiesFav);exit;
    	//get information about each website
    	$myWebFavorites = array();//
    	foreach ($cookiesFav as $key => $urlId) { //var_dump($web); exit;
    		$url = PHDB::findOne(Url::COLLECTION,array("_id"=>new MongoId($urlId)));
    		$myWebFavorites[] = $url;
    	}
		
    	$params = array("myWebFavorites"=>$myWebFavorites);
    	echo $this->renderPartial("web", $params, true);
    }

    public function actionReferencement(){ //kgougle
    	CO2Stat::incNbLoad("co2-referencement");
    	        
    	$params = array("subdomain" => "referencement",
                        "mainTitle" => "Référencer votre site Calédonien",
                        "placeholderMainSearch" => "");

    	echo $this->renderPartial("referencement", $params, true);
    }


	
	public function actionMedia(){ //kgougle
		$indexMin = isset($_POST['indexMin']) ? $_POST['indexMin'] : 0;
        $indexMax = isset($_POST['indexMax']) ? $_POST['indexMax'] : 10;
        $sources = isset($_POST['sources']) ? $_POST['sources'] : array("NCI", "NC1", "CALEDOSPHERE", "NCTV");
        $search = isset($_POST['search']) ? $_POST['search'] : "";

        $indexStep = $indexMax - $indexMin;
       
        $query = array('srcMedia' => array('$in' => $sources));

        if($search != ""){

            $searchStr = Search::removeEmptyWords($search);

            $searchRegExp1 = Search::accentToRegex($searchStr);
            $arraySearch = explode(" ", $searchRegExp1);
            
            foreach ($arraySearch as $key => $searchRegExp) {
                $plain['$or'][]["title"] = new MongoRegex("/.*{$searchRegExp}.*/i");
                $plain['$or'][]["content"] = new MongoRegex("/.*{$searchRegExp}.*/i");
                $plain['$or'][]["srcMedia"] = new MongoRegex("/.*{$searchRegExp}.*/i");                
            }

            $query['$and'][] = $plain;
        }

        //var_dump($query);// exit;
    	$medias = PHDB::findAndSortAndLimitAndIndex("media", $query, array("date"=>-1) , $indexStep, $indexMin);
    	
        $params = array("medias" => $medias, "indexMin" => @$indexMin, "indexMax" => @$indexMax );

        CO2Stat::incNbLoad("co2-live");

    	if(@$_POST['renderPartial'] == true)
    	echo $this->renderPartial("liveStream", $params, true);
    	else
    	echo $this->renderPartial("media", $params, true);
	}


    public function actionSearch($type=null){
        CO2Stat::incNbLoad("co2-search");   
        $params = array("type" => @$type );
        echo $this->renderPartial("search", $params, true);
    }
    public function actionSocial($type=null){
        CO2Stat::incNbLoad("co2-search");   
        $params = array("type" => @$type );
        echo $this->renderPartial("search", $params, true);
    }



    public function actionAnnonces(){
        CO2Stat::incNbLoad("co2-annonces"); 
        $params = array("type" => "classified");
        echo $this->renderPartial("search", $params, true);
    }



    public function actionFreedom(){
        CO2Stat::incNbLoad("co2-annonces"); 
        $params = array("type" => "classified");
        echo $this->renderPartial("search", $params, true);
    }


    public function actionLive(){
        CO2Stat::incNbLoad("co2-live"); 
        $params = array();//"type" => "classified");
        echo $this->renderPartial("live", $params, true);
    }

	public function actionAgenda(){
		CO2Stat::incNbLoad("co2-agenda");	
        $params = array("type" => "events");
    	echo $this->renderPartial("search", $params, true);
	}

	public function actionPower(){
		CO2Stat::incNbLoad("co2-power");	
        $params = array("type" => "vote");
    	echo $this->renderPartial("search", $params, true);
	}

    public function actionAdmin(){
        CO2Stat::incNbLoad("co2-admin");   
        $params = array();
        echo $this->renderPartial("admin", $params, true);
    }

    public function actionRooms($type,$id){
        CO2Stat::incNbLoad("co2-rooms");    
        $params = array("id" => @$id,
                        "type" => @$type
                        );
        print_r($params);
        echo $this->renderPartial("rooms", $params, true);
    }


	public function actionPage($type, $id, $view=null, $dir=null){
        CO2Stat::incNbLoad("co2-page");
        
        if( $type == Person::COLLECTION  || $type == Event::COLLECTION || 
            $type == Project::COLLECTION || $type == Organization::COLLECTION )    
            $element = Element::getByTypeAndId($type, $id);

        if($type == News::COLLECTION){
            $element = News::getById($id);
        }

        if($type == Classified::COLLECTION){
            $element = Classified::getById($id);
        }

        if(@$element["parentId"] && @$element["parentType"])
            $element['parent'] = Element::getByTypeAndId( $element["parentType"], $element["parentId"]);
        if(@$element["organizerId"] && @$element["organizerType"])
            $element['organizer'] = Element::getByTypeAndId( $element["organizerType"], $element["organizerId"]);

        $params = array("id" => @$id,
                        "type" => @$type,
                        "view" => @$view,
                        "dir" => @$dir,
                        "subdomain" => "page",
                        "mainTitle" => "Page perso",
                        "placeholderMainSearch" => "",
                        "element" => $element);

        $params = Element::getInfoDetail($params, $element, $type, $id);
        
    	echo $this->renderPartial("page", $params, true);
	}

    public function actionInteroperability(){
        $params=array();
        CO2Stat::incNbLoad("co2-interoberability");
        echo $this->renderPartial("interoperability", $params, true);
    } 

    public function actionInfo($p){
        $CO2DomainName = isset(Yii::app()->params["CO2DomainName"]) ? 
                               Yii::app()->params["CO2DomainName"] : "CO2";

        $page = @$p ? $p : "apropos";
        echo $this->renderPartial("info/" . $CO2DomainName . "/" . $page, array(), true);
    }

    public function actionCity($insee, $postalCode){
        
        echo $this->renderPartial("city", array("insee"=> $insee, "postalCode" => $postalCode), true);
    }


    public function actionSendMailFormContact(){
        function rpHash($value) { 
            $hash = 5381; 
            $value = strtoupper($value); 
            for($i = 0; $i < strlen($value); $i++) { 
                $hash = (leftShift32($hash, 5) + $hash) + ord(substr($value, $i)); 
            } 
            return $hash; 
        } 
         
        // Perform a 32bit left shift 
        function leftShift32($number, $steps) { 
            // convert to binary (string) 
            $binary = decbin($number); 
            // left-pad with 0's if necessary 
            $binary = str_pad($binary, 32, "0", STR_PAD_LEFT); 
            // left shift manually 
            $binary = $binary.str_repeat("0", $steps); 
            // get the last 32 bits 
            $binary = substr($binary, strlen($binary) - 32); 
            // if it's a positive number return it 
            // otherwise return the 2's complement 
            return ($binary{0} == "0" ? bindec($binary) : 
                -(pow(2, 31) - bindec(substr($binary, 1)))); 
        } 

       
        if (rpHash($_POST['captchaUserVal']) == $_POST['captchaHash']){
            Mail::sendMailFormContact($_POST["emailSender"], $_POST["names"], $_POST["subject"], $_POST["contentMsg"]);
            
            $res = array("res"=>true, "captcha"=>true);  
            Rest::json($res); exit;
        }else{
            $res = array("res"=>false, "captcha"=>false, "msg"=>"Code de sécurité incorrecte");  
            Rest::json($res); exit;
        }

        $res = array("res"=>false, "msg"=>"Une erreur inconnue est survenue. Sorry", "telalpha"=>"96.53.57");  
        Rest::json($res);
        exit;
    }

    
}