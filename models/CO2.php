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

    	$query = array("country"=>"NC", "depName"=>"Province Sud", "name"=>array('$nin'=>array("Noumea", "Dumbea", "Paita", "Mont-Dore")));
    	$citiesS = PHDB::find(City::COLLECTION, $query);

    	$query = array("country"=>"NC", "depName"=>"Province Nord");
    	$citiesN = PHDB::find(City::COLLECTION, $query);

    	$query = array("country"=>"NC", "depName"=>"Province Des Iles");
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
        if(isset( Yii::app()->request->cookies['communexionActivated'] ) && 
                  (string)Yii::app()->request->cookies['communexionActivated'] == "true"){
            $communexion["state"] = true;
        }        

        if(isset( Yii::app()->request->cookies['cpCommunexion'] )){
            $cp = Yii::app()->request->cookies['cpCommunexion'];
            $insee = (string)Yii::app()->request->cookies['inseeCommunexion'];
            $where = array("postalCodes.postalCode" =>new MongoRegex("/^".$cp."/i"), "insee"=>$insee);
            
            $city = PHDB::findOne( City::COLLECTION , $where );
            $communexion["values"] = array( "cityName"  =>$city["alternateName"],
                                            "cityKey"   => City::getUnikey($city),
                                            "cityCp"    =>Yii::app()->request->cookies['cpCommunexion'],
                                            "depName"   =>@$city["depName"],
                                            "regionName"=>@$city["regionName"]);
            
            $communexion["currentLevel"] =  (string)Yii::app()->request->cookies['communexionLevel'];
            $communexion["currentName"] =  (string)Yii::app()->request->cookies['communexionName'];
            $communexion["currentValue"] =  (string)Yii::app()->request->cookies['communexionValue'];

            //return $communexion;           
        }

        
       // var_dump($communexion);
        return $communexion;

    }


}
?>
