 <?php 
class CO2 {

    public static function getThemeParams($domainName=null){
    	$domainName = @$domainName ? $domainName : Yii::app()->params["CO2DomainName"];
    	
    	$layoutPath ="../../modules/co2/config/".$domainName."/params.json";
        // $layoutPath ="../../modules/co2/config/CO2/params.json";

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

        if(@Yii::app()->request->cookies['cpCommunexion'] && !empty(Yii::app()->request->cookies['cpCommunexion']->value)){
            $cp = (string)Yii::app()->request->cookies['cpCommunexion'];
            $insee = (string)Yii::app()->request->cookies['inseeCommunexion'];

            $where = array("postalCodes.postalCode" =>new MongoRegex("/^".$cp."/i"));
            $citiesResult = PHDB::find( City::COLLECTION , $where );
            $cities=array();
            $levelMin="inseeCommunexion";
            foreach($citiesResult as $v){
                if($v["insee"]==$insee){
                    $city=$v;
                    $alternateName=$v["alternateName"];
                    $inseeName=$v["alternateName"];
                    if(count($city["postalCodes"])>1){
                        $cities=[];
                        $levelMin="cpCommunexion";
                        foreach($city["postalCodes"] as $value){
                            if($value["postalCode"]==$cp){
                                $currentName=$cp;
                                $alternateName=$value["name"];
                                $cities[]=$value["postalCode"].", ".$value["name"];
                            }else
                                $cities[]=$value["postalCode"].", ".$value["name"];
                        }
                    }
                }
                else if($levelMin=="inseeCommunexion")
                    $cities[]=$v["alternateName"];
            }
            $cityKey=$city["country"]."_".$insee."-".$cp;
            $currentName=(string)Yii::app()->request->cookies['communexionName'];
            $communexion["values"] = array( "cityName"  =>$alternateName,
                                            "cityKey"   => $cityKey,
                                            "inseeName" => $inseeName,
                                            "inseeCode" => @$city["insee"],
                                            "cityCp"    => $cp,
                                            "wikidataID" =>@$city["wikidataID"],
                                            "geoShape" => @$city["geoShape"],
                                            "depName"   =>@$city["depName"],
                                            "regionName"=>@$city["regionName"],
                                            "cities"=>$cities);
            $communexion["levelMinCommunexion"] =  $levelMin;
            if($currentName!=""){
                $communexion["currentLevel"] =  (string)Yii::app()->request->cookies['communexionType'];
                $communexion["currentName"] = $currentName;
                $communexion["currentValue"] =  (string)Yii::app()->request->cookies['communexionValue'];
            }else{
                $communexion["currentValue"] =  $cityKey;
                $communexion["currentName"] = $alternateName;
                if($levelMin=="cpCommunexion")
                    $communexion["currentLevel"] =  "cp";
                else
                    $communexion["currentLevel"] =  "city";
                //return $communexion;           
            }
        }

        
       // var_dump($communexion);
        return $communexion;

    }


}
?>
