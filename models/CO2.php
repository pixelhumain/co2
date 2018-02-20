 <?php 
class CO2 {

    public static function getCategories(){
        return array(
            "food"=> array(
                "name" => "Food",
                "icon" => "fa-cutlery",
                "tags" => [ Yii::t("tags","agriculture"),Yii::t("tags","food"),Yii::t("tags","nutrition"),Yii::t("tags","AMAP") ]
            ),  
            "health"=> array(
                "name" => "Health",
                "icon" => "fa-heart-o",
                "tags" => [ Yii::t("tags","health") ]
            ),  
            "waste"=> array(
                "name" => "Waste",
                "icon" => "fa-trash-o ",
                "tags" => [ Yii::t("tags","waste") ]
            ),  
            "transport"=> array(
                "name" => "Transport",
                "icon" => "fa-bus",
                "tags" => [ Yii::t("tags","urbanism"),Yii::t("tags","transport"),Yii::t("tags","construction") ]
            ),  
            "education"=> array(
                "name" => "Education",
                "icon" => "fa-book",
                "tags" => [ Yii::t("tags","education"),Yii::t("tags","childhood") ]
            ),  
            "citizen"=> array(
                "name" => "Citizenship",
                "icon" => "fa-user-circle-o",
                "tags" => [ Yii::t("tags","citizen"),Yii::t("tags","society") ]
            ),  
            "economy"=> array(
                "name" => "Economy",
                "icon" => "fa-money",
                "tags" => [ Yii::t("tags","ess") ,Yii::t("tags","social solidarity economy") ]
            ),  
            "energy"=> array(
                "name" => "Energy",
                "icon" => "fa-sun-o",
                "tags" => [ Yii::t("tags","energy"),Yii::t("tags","climat") ]
            ),  
            "culture"=> array(
            "name" => "Culture",
            "icon" => "fa-universal-access",
            "tags" => [ Yii::t("tags","culture"),Yii::t("tags","animation") ]
            ),  
            "environnement"=> array(
            "name" => "Environnement",
            "icon" => "fa-tree",
            "tags" => [ Yii::t("tags","environment"),Yii::t("tags","biodiversity"),Yii::t("tags","ecology") ]
            ),  
            "numeric"=> array(
            "name" => "Numeric",
            "icon" => "fa-laptop",
            "tags" => [ Yii::t("tags","computer"),Yii::t("tags","ict"),Yii::t("tags","internet"),Yii::t("tags","web") ]
            ),
            "sport" => array( 
            "name" => "Sport",
            "icon" => "fa-futbol-o",
            "tags" => [ Yii::t("tags","sport") ]
            )
        );
    }
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

    public static function getModuleContextList($mod, $contextName){
        $domainName = @$domainName ? $domainName : Yii::app()->params["CO2DomainName"];
        
        $layoutPath ="../../modules/".$mod."/assets/js/".$contextName.".json";
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
    public static function getCommunexionUser(){
        if(@Yii::app()->session["userId"]){
            $personLoc=Element::getElementSimpleById(Yii::app()->session["userId"], Person::COLLECTION, null, array("address"));
            if(!empty($personLoc["address"]))
                return City::detailsLocality($personLoc["address"]);
            else
                return false;
        }
        else
            return false;
    }
	public static function getCommunexionCookies(){
		$communexion = array("state"=>false, "values"=>array());
		if(CookieHelper::hasCookie("communexion") && CookieHelper::hasCookie("communexionType")) {
			if(isset( Yii::app()->request->cookies['communexionActivated'] ) && (string)Yii::app()->request->cookies['communexionActivated'] == "true"){
                $communexion["state"] = true;
            }
            $communexion["values"] = json_decode(CookieHelper::getCookie("communexion"), true);

            if(!empty($communexion["values"])){
                $communexion["values"] = json_decode(CookieHelper::getCookie("communexion"), true);
            }
            $communexion["currentLevel"] = "city";
            
            if(!empty($communexion["values"]["postalCode"])){
                $where = array("postalCodes.postalCode" =>new MongoRegex("/^".$communexion["values"]["postalCode"]."/i"));

                if(!empty($communexion["values"]["country"]))
                    $where = array_merge($where, array("country" => $communexion["values"]["country"]));

                $citiesResult = PHDB::find( City::COLLECTION , $where );
                $cities=array();
                foreach ($citiesResult as $key => $v) {
                    $cities[] = City::getNameCity($key);
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
            $communexion["state"] = false;
        }
        return $communexion;
    }


}
?>
