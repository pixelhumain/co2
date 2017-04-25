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
            //print_r(Yii::app()->request->cookies);
            $cp = Yii::app()->request->cookies['cpCommunexion'];
            $insee = (string)Yii::app()->request->cookies['inseeCommunexion'];
            $where = array("postalCodes.postalCode" =>new MongoRegex("/^".$cp."/i"));
            $citiesResult = PHDB::find( City::COLLECTION , $where );
            //print_r($citiesResult);
            $cities=array();
           //if(count($citiesResult)>1){
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
                    $cities[]=$v["postalCodes"][0]["postalCode"].", ".$v["alternateName"];
            }
            //} else
            //$city=$citiesResult;
            //print_r(Yii::app()->request->cookies);
            $cityKey=$city["country"]."_".$insee."-".$cp;
            $currentName=(string)Yii::app()->request->cookies['communexionName'];
            $communexion["values"] = array( "cityName"  =>$alternateName,
                                            "cityKey"   => $cityKey,
                                            "inseeName" => $inseeName,
                                            "cityCp"    =>Yii::app()->request->cookies['cpCommunexion'],
                                            "depName"   =>@$city["depName"],
                                            "regionName"=>@$city["regionName"],
                                            "cities"=>$cities);
            $communexion["currentLevel"] =  (string)Yii::app()->request->cookies['communexionType'];
            $communexion["levelMinCommunexion"] =  $levelMin;
            $communexion["currentName"] = $currentName ;
            $communexion["currentValue"] =  (string)Yii::app()->request->cookies['communexionValue'];
            //return $communexion;           
        }

        
       // var_dump($communexion);
        return $communexion;

    }


}
?>
