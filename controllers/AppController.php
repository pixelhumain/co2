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
	        'superadmin' 		=> 'citizenToolKit.controllers.app.SuperAdminAction',
            
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



	public function actionWeb(){ //kgougle
		CO2Stat::incNbLoad("co2-web");

        //get my favorites web sites in my cookies
        $cookiesFav = isset( Yii::app()->request->cookies['webFavorites'] ) && Yii::app()->request->cookies['webFavorites'] != "" ? 
		   			  explode(",", Yii::app()->request->cookies['webFavorites']->value) : array();
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
    	$cities = CO2::getCitiesNewCaledonia();
        
    	$params = array("subdomain" => "referencement",
                        "mainTitle" => "Référencer votre site Calédonien",
                        "placeholderMainSearch" => "",
                        "cities" => $cities);

    	echo $this->renderPartial("referencement", $params, true);
    }


	
	public function actionMedia(){ //kgougle
		$indexMin = isset($_POST['indexMin']) ? $_POST['indexMin'] : 0;
        $indexMax = isset($_POST['indexMax']) ? $_POST['indexMax'] : 10;

        $indexStep = $indexMax - $indexMin;
       
        $query = array('srcMedia' => array('$in' => array("NCI", "NC1", "CALEDOSPHERE", "NCTV")));
    	$medias = PHDB::findAndSortAndLimitAndIndex("media", $query, array("date"=>-1) , $indexStep, $indexMin);
    	
        $params = array("medias" => $medias );

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



	public function actionAnnonces(){
		CO2Stat::incNbLoad("co2-annonces");	
        $params = array();//"type" => @$type );
    	echo $this->renderPartial("annonces", $params, true);
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


	public function actionPage($type, $id){
        CO2Stat::incNbLoad("co2-page");
        $params = array("id" => @$id,
                        "type" => @$type,
                        "subdomain" => "page",
                        "mainTitle" => "Page perso",
                        "placeholderMainSearch" => "");

    	echo $this->renderPartial("page", $params, true);
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
}