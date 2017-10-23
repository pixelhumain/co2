 <?php 
class CO2 {

    public static function getThemeParams($domainName=null){
    	$domainName = @$domainName ? $domainName : Yii::app()->params["CO2DomainName"];
    	
    	$layoutPath ="../../modules/co2/config/".$domainName."/params.json";

    	$str = file_get_contents($layoutPath);

		$params = json_decode($str, true);
    	return $params;
    }


    public static function getContextList($contextName, $domainName=null){
    	$domainName = @$domainName ? $domainName : Yii::app()->params["CO2DomainName"];
    	
    	$layoutPath ="../../modules/co2/config/".$domainName."/".$contextName.".json";
    	$str = file_get_contents($layoutPath);

		$list = json_decode($str, true);
    	return $list;
    }

    public static function getCitiesNewCaledonia(){
    	$query = array("country"=>"NC", "name"=>array('$in'=>array("Noumea", "Dumbea", "Paita", "Mont-Dore")));
    	$citiesGN = PHDB::find(City::COLLECTION, $query);

    	$query = array("country"=>"NC", "level3Name"=>"Province Sud", 
                        "name"=>array('$nin'=>array("Noumea", "Dumbea", "Paita", "Mont-Dore")));
    	$citiesS = PHDB::find(City::COLLECTION, $query);

    	$query = array("country"=>"NC", "level3Name"=>"Province Nord");
    	$citiesN = PHDB::find(City::COLLECTION, $query);

    	$query = array("country"=>"NC", "level3Name"=>"Province des Iles");
    	$citiesI = PHDB::find(City::COLLECTION, $query);

    	$cities = array("GN"=>$citiesGN, 
    					"Sud"=>$citiesS, 
    					"Nord"=>$citiesN, 
    					"Iles"=>$citiesI);
    	return $cities;
    }

	public static function getCommunexionCookies(){
		$communexion = array("state"=>false, "values"=>array());
		//var_dump(Yii::app()->request->cookies['communexionActivated']);
		if(isset( Yii::app()->request->cookies['communexionActivated'] ) && (string)Yii::app()->request->cookies['communexionActivated'] == "true"){
			$communexion["state"] = true;
		}

		if(CookieHelper::hasCookie("communexion") && CookieHelper::hasCookie("communexionType")) {
			$communexion["state"] = true;
            $communexion["values"] = json_decode(CookieHelper::getCookie("communexion"), true);
            $communexion["currentLevel"] = "city";
            
            if($communexion["values"]["cp"]){
                $where = array("postalCodes.postalCode" =>new MongoRegex("/^".$communexion["values"]["cp"]."/i"));
                $citiesResult = PHDB::find( City::COLLECTION , $where );

                $cities=array();
                foreach ($citiesResult as $key => $v) {
                    $trad4 = Zone::getTranslateById($key);
                    $cities[]=(!empty($trad4["translates"]["EN"]) ? $trad4["translates"]["EN"] : $v["name"]);
                }
                $communexion["cities"] = $cities;
            }

            $communexion["communexionType"] = CookieHelper::getCookie("communexionType");
            $communexion["currentName"] = $communexion["values"]["cityName"];
            $communexion["currentValue"] =  $communexion["values"]["city"];
		}else{
            $communexion["levelMinCommunexion"] =  false;
            $communexion["currentLevel"] =  false;
            $communexion["currentName"] = false;
            $communexion["currentValue"] =  false;
        }
        
       // var_dump($communexion);
        return $communexion;

    }


}
?>
