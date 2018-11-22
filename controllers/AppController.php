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

        //Yii::app()->theme = "CO2";
        Yii::app()->session["theme"] = "CO2";
       // $params = CO2::getThemeParams();
        
        $hash = (@Yii::app()->session["userId"]) ? Yii::app()->session['paramsConfig']["pages"]["#app.index"]["redirect"]["logged"] : Yii::app()->session['paramsConfig']["pages"]["#app.index"]["redirect"]["unlogged"];
        $params = array("type" => @$type );

        if(!@$hash || @$hash=="") $hash="search";
        //echo @$hash; exit;
        if(@$hash == "web")
            self::actionWeb();
        else if($hash=="annonces")
            self::actionAnnonces();
        else
           echo $this->renderPartial($hash, $params, true);
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
        $params = array("type" => "all" /*Organization::COLLECTION*/, "app"=>"search" );
        echo $this->renderPartial("search", $params, true);
    }
    public function actionSocial($type=null){
        CO2Stat::incNbLoad("co2-search");   
        $params = array("type" => @$type );
        echo $this->renderPartial("search", $params, true);
    }


    public function actionActivities(){
        CO2Stat::incNbLoad("terla-activities"); 
        $params = array("type" => "services");
        echo $this->renderPartial("search", $params, true);
    }

    public function actionStore(){
        CO2Stat::incNbLoad("terla-store"); 
        $params = array("type" => "products");
        echo $this->renderPartial("search", $params, true);
    }

    public function actionCircuits(){
        CO2Stat::incNbLoad("terla-store"); 
        $params = array("type" => "circuits");
        echo $this->renderPartial("search", $params, true);
    }

    /*public function actionFreedom(){
        CO2Stat::incNbLoad("co2-annonces"); 
        $params = array("type" => "classified");
        echo $this->renderPartial("search", $params, true);
    }*/

    public function actionLive(){
        CO2Stat::incNbLoad("co2-live"); 
        $params = array();
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
    public function actionDocs($page=null, $dir=null){
        CO2Stat::incNbLoad("co2-docs");   
        $params = array(
            "page" => @$page,
            "dir"=>@$dir,
        );
        echo $this->renderPartial("../docs/index", $params, true);
    }
    
    public function actionAdmin($view=null, $dir=null){
        CO2Stat::incNbLoad("co2-admin");   
        $params = array(
            "dir" => @$dir,
            "view"=>@$view,
        );
        $view = /*( !empty($view) ? $view :*/ "index";
        $redirect="";

        /*if($view == "directory"){
            $params = Admin::directory();
            $view = "directoryTable";
        }else if($view == "moderate"){
            if(isset($_REQUEST['all'])){
                $view =  "moderateAll";
                $params["news"] = News::getNewsToModerate();
                $params["comments"] =  Comment::getCommentsToModerate();

                //we moderate comments which is part of a news already moderate isAnabuse == true
                if(isset($params["comments"]) && is_array($params["comments"]))foreach($params["comments"] as $key => $val){
                    $tmp = News::getById($val['contextId']);
                    if(isset($tmp)){
                        if(isset($tmp['moderate'])){
                            if(isset($tmp['moderate']['isAnAbuse']) && $tmp['moderate']['isAnAbuse'] == true){
                                unset($params["comments"][$key]);
                            }
                        }
                    }
                }
            }
            elseif(isset($_REQUEST['one'])){
                $view =  "moderateOne"; 
            }
            else{
                $view =  "moderate";
            }
        }else if ($view == "mailerrordashboard"){
            $mailErrors = MailError::getMailErrorSince(time() - 60*60*24*7);
            $params["mailErrors"] = $mailErrors;
            $params["path"] = "../admin/";
            $view = $params["path"]."mailErrorTable";
        }*/


        if(Yii::app()->params["CO2DomainName"] == "terla")
            $redirect="terla/";
        echo $this->renderPartial("../admin/".$redirect.$view, $params, true);
    }


    public function actionAdminpublic($view = null){
        CO2Stat::incNbLoad("co2-adminpublic");   
        $view = ( !empty($view) ? $view : "index");
        $params = array();
        if($view == "createfile"){
            $count = PHDB::count(Import::MAPPINGS, array() ) ;
            if($count == 0){
                Import::initMappings(); 
            }
            $params["allMappings"] = Import::getMappings(); 
        }

        echo $this->renderPartial("../adminpublic/".$view, $params, true);
    }

    public function actionChat(){
        CO2Stat::incNbLoad("co2-chat");   
        $params = array("iframeOnly"=>true);
        echo $this->renderPartial("../rocketchat/iframe", $params, true);
    }

    public function actionRooms($type,$id){ exit;
        CO2Stat::incNbLoad("co2-rooms");    
        $params = array("id" => @$id,
                        "type" => @$type
                        );
        //print_r($params);
        echo $this->renderPartial("rooms", $params, true);
    }

    public function actionAnnonces(){ 
        $this->redirect( Yii::app()->createUrl("/eco") );
    }

    public function actionHelp(){ 
        $this->redirect( Yii::app()->createUrl("/ressources/co/ressources") );
    }

    public function actionInterop(){
        //echo "Hello there "; echo Yii::app()->createUrl("/interop/co/index"); exit; 
        $this->redirect( Yii::app()->createUrl("/interop") );
    }
    public function actionHome(){
        CO2Stat::incNbLoad("co2-home");
        if( !@Yii::app()->session["userId"] )
             $this->redirect( Yii::app()->createUrl($controller->module->id) );
            echo $this->renderPartial("home", array(), true);
    }
    public function actionPage($type, $id, $view=null, $mode=null, $dir=null, $key=null, $folder=null){
        CO2Stat::incNbLoad("co2-page");
            
        if( $type == Person::COLLECTION  || $type == Event::COLLECTION || 
            $type == Project::COLLECTION || $type == Organization::COLLECTION || 
            $type == Poi::COLLECTION || $type == Place::COLLECTION || $type == Ressource::COLLECTION || 
            $type == Classified::COLLECTION){
            $element = Element::getByTypeAndId($type, $id);
        }
        else if($type == News::COLLECTION){
            $element = News::getById($id);
        }

        else if($type == Product::COLLECTION){
            $element = Product::getById($id);
        }
        else if($type == Service::COLLECTION){
            $element = Service::getById($id);
        }
        else if($type == Survey::COLLECTION){
            $element = Survey::getById($id);
        }

        //element deleted 
        if( (!empty($element["status"]) && $element["status"] == "deleted") ||  
            (!empty($element["tobeactivated"]) && $element["tobeactivated"] == true) )
             $this->redirect( Yii::app()->createUrl($controller->module->id) );

        //visibility authoraizations
        if(!Preference::isPublicElement(@$element["preferences"]) &&
             (!@Yii::app()->session["userId"] || !Authorisation::canSeePrivateElement(@$element["links"], $type, $id, $element["creator"], @$element["parentType"], @$element["parentId"])))
            $this->redirect( Yii::app()->createUrl($controller->module->id) );

        if(@$element["parentId"] && @$element["parentType"] && 
            $element["parentId"] != "dontKnow" && $element["parentType"] != "dontKnow")
            $element['parent'] = Element::getSimpleByTypeAndId( $element["parentType"], $element["parentId"]);
        
        if(@$element["organizerId"] && @$element["organizerType"] && 
            $element["organizerId"] != "dontKnow" && $element["organizerType"] != "dontKnow")
            $element['organizer'] = Element::getByTypeAndId( $element["organizerType"], $element["organizerId"]);
        
        $params = array("id" => @$id,
                        "type" => @$type,
                        "view" => @$view,
                        "dir" => @$dir,
                        "key" => @$key,
                        "folder" => @$folder,
                        "subdomain" => "page",
                        "mainTitle" => "Page perso",
                        "placeholderMainSearch" => "",
                        "element" => $element);

        //var_dump($element);exit;
        $params = Element::getInfoDetail($params, $element, $type, $id);
        
        //bloque l'édition de la page (même si on est l'admin)
        //visualisation utilisateur
        if(@$mode=="noedit"){ $params["edit"] = false; }

        //var_dump($params);exit;

        if(@$_POST["preview"] == true){
            //echo "oui";exit;
            $params["preview"]=$_POST["preview"]; 
            if($type == "classifieds") $this->renderPartial('eco.views.co.preview', $params );
           // else if($type == "ressources") $this->renderPartial('ressources.views.co.preview', $params ); 
            else if($type == "poi") $this->renderPartial('../poi/preview', $params ); 
            else $this->renderPartial("../element/onepage", $params);
        }else{
            echo $this->renderPartial("page", $params, true);
	    }
    }

    public function actionInteroperability(){
        CO2Stat::incNbLoad("co2-interoberability");
        echo $this->renderPartial("interoperability", array(), true);
    } 

    public function actionInfo($p){
        $CO2DomainName = isset(Yii::app()->params["CO2DomainName"]) ? 
                               Yii::app()->params["CO2DomainName"] : "CO2";

        $page = @$p ? $p : "apropos";
        echo $this->renderPartial("info/" . $CO2DomainName . "/" . $page, array(), true);
    }

    public function actionSmartconso($p="home"){ //error_log("ecoconso");
        $CO2DomainName = isset(Yii::app()->params["CO2DomainName"]) ? 
                               Yii::app()->params["CO2DomainName"] : "CO2";

        $page = @$p ? $p : "home";
        echo $this->renderPartial("../smartconso/" . $page, array(), true);
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

    public function actionSendMailFormContactPrivate(){
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

            $element = Element::getByTypeAndId($_POST["typeReceiverParent"], $_POST["idReceiverParent"]);
            $idReceiver = $_POST["idReceiver"];

            if( @$element && !empty($element) && 
                !empty($element["contacts"]) && 
                !empty($element["contacts"][$idReceiver]) && 
                !empty($element["contacts"][$idReceiver]["email"]) ){
                
                $emailReceiver = $element["contacts"][$idReceiver]["email"];
                error_log("EMAIL FOUND : ".$emailReceiver);

                if(!empty($emailReceiver))
                    Mail::sendMailFormContactPrivate($_POST["emailSender"], $_POST["names"], $_POST["subject"], 
                                                 $_POST["contentMsg"], $emailReceiver);
                
                $res = array("res"=>true, "captcha"=>true);  
                Rest::json($res); exit;
            }
        }else{
            $res = array("res"=>false, "captcha"=>false, "msg"=>"Code de sécurité incorrecte");  
            Rest::json($res); exit;
        }

        $res = array("res"=>false, "msg"=>"Une erreur inconnue est survenue. Sorry", "telalpha"=>"96.53.57");  
        Rest::json($res);
        exit;
    }

    
}