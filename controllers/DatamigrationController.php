<?php
	
/* Author Bouboule (clement.damiens@gmail.com)
* Controller to update data with all bash done on db
* Documentation done before each function and in communecter/docs/devlog.md
*
*
*/
class DatamigrationController extends CommunecterController {
  
  protected function beforeAction($action) {
	return parent::beforeAction($action);
  }

  public function actionKnowsToFollows(){
	if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		 $persons=PHDB::find(Person::COLLECTION);
		foreach($persons as $key => $data){
			if(isset($data["links"]["followers"]) || isset($data["links"]["follows"])){
				$followers=array();
				$follows=array();
				if(isset($data["links"]["followers"]) && !empty($data["links"]["followers"])){
					$followers=$data["links"]["followers"];
				}
				if(isset($data["links"]["follows"]) && !empty($data["links"]["follows"])){
					$follows=$data["links"]["follows"];
				}
				PHDB::update(Person::COLLECTION,
					array("_id" => $data["_id"]) , 
					array('$unset' => array("links.followers" => ""))
				);
				PHDB::update(Person::COLLECTION,
					array("_id" => $data["_id"]) , 
					array('$unset' => array("links.follows" => ""))
				);
				if(!empty($followers)){
					//foreach ($followers as $uid => $e){	
						PHDB::update(Person::COLLECTION,
							array("_id" => $data["_id"]) , 
							array('$set' => array("links.follows" => $followers))
							);
					//}
				}
				if (!empty($follows)){
					foreach ($follows as $uid => $e){	
						if($e["type"]=="citoyens"){
						PHDB::update(Person::COLLECTION,
							array("_id" => $data["_id"]) , 
							array('$set' => array("links.followers.".$uid => $e))
							);
						} else {
							PHDB::update(Person::COLLECTION,
							array("_id" => $data["_id"]) , 
							array('$set' => array("links.follows.".$uid => $e))
							);
						}
					}
				}
				$newLinks=PHDB::findOneById(Person::COLLECTION ,$data["_id"]);
				echo "<br/>/////////////////////////// NEW LINK ////////////////////<br/>";
				print_r($newLinks["links"]);
				}	
			}
	}
  }
	//Refactor permettant de mettre la size des doc en bytes type string 
	// Pas encore Passez en prod et dev
	// A lancer une fois pour que ce soit stocké en int32 ou int64
	public function actionChangeSizeDocumentToBytesNumber(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$document=PHDB::find(Document::COLLECTION);
			$nbDoc=count($document);
			echo "Nombre de documents appelés : ".$nbDoc;
			$i=0;
			foreach($document as $key => $data){
				if(@$data["size"]){
					$size="";
					echo "<br/>".$data["_id"]."//".$data["size"]."///";
					echo gettype($data["size"]);
					if(gettype($data["size"])=="double"){
						$size = (int)$data["size"];
					}
					if (strstr($data["size"], 'M', true)){
						$size=((float)$data["size"])*1048576;
					} 
					else if(strstr($data["size"], 'K', true)){
						$size = (float)($data["size"])*1024;
					}
					$i++;
					if(@$size && !empty($size)){
						echo "new size : ".$size;
						PHDB::update(Document::COLLECTION,
								array("_id" => $data["_id"]) , 
								array('$set' => array("size" => (int)$size))	
			
						);
					}	
				}
			}
			echo "</br>Nombre de documents traités pour la size : ".$i; 
		}
	}
	//Refactor of contentKey
	//@param string contentKey type type.view.contentKey become contentKey
	//!!!!!!!!!!!! CAREFULLY THIS METHOD IS FOR COMMUNECTER AND NOT FOR GRANDDIR !!!!!!!!!!!!!!!!!//////
	// For the moment refactorContentKey change all contentKey to profil 
	// Function need to be change with an explode and $contentKey = $explode[2] for granddir
	public function actionRefactorContentKey(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$document=PHDB::find(Document::COLLECTION);
			$nbDoc=count($document);
			echo "Nombre de documents appelés : ".$nbDoc;
			$i=0;
			foreach($document as $key => $data){
				if(strstr($data["contentKey"],'.')){
					echo $data["contentKey"]."<br/>";
					PHDB::update(Document::COLLECTION,
						array("_id" => $data["_id"]) , 
						array('$set' => array("contentKey" => "profil"))	
					);
					$i++;
				}
			}
			echo "</br>Nombre de documents concerné par le refactor : ".$i;  
		}
	}
	// Washing of docmuent
	// Wash data with array in params @size which could be string
	// Wash data with no type or no id, represent the target of the document
	// Wash data with no contentKey
	public function actionWashIncorrectAndOldDataDocument(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$document=PHDB::find(Document::COLLECTION);
			$nbDoc=count($document);
			echo "Nombre de documents appelés : ".$nbDoc;
			$nbDocSizeIsArray=0;
			$nbDocNoTypeOrNoId=0;
			$nbDocNoContentKey=0;
			foreach($document as $key => $data){
				if(gettype($data["size"])=="array"){
					echo "<br/>//////// This document content an array for size : <br/>";
					print_r($data);
					PHDB::remove(Document::COLLECTION,array("_id" => $data["_id"]));
					$nbDocSizeIsArray++;
				}
				if( !@$data["type"] || !@$data["id"] || empty($data["type"]) || empty($data["id"])){
					echo "<br/>//////// This document doesn't content any type or id : <br/>";
					print_r($data);
					PHDB::remove(Document::COLLECTION,array("_id" => $data["_id"]));
					$nbDocNoTypeOrNoId++;
				}
				if( !@$data["contentKey"] || empty($data["contentKey"])){
					echo "<br/>//////// This document doesn't content any contentKey : <br/>";
					print_r($data);
					PHDB::remove(Document::COLLECTION,array("_id" => $data["_id"]));
					$nbDocNoContentKey++;
				}
			}
			echo "</br>//////// <br/>Nombre de documents sans type ou id: ".$nbDocNoTypeOrNoId; 
			echo "</br>//////// <br/>Nombre de documents sans contentKey: ".$nbDocNoContentKey;
			echo "</br>//////// <br/>Nombre de documents avec size comme array: ".$nbDocSizeIsArray;  
		}
	}
	/* 
	* Upload image from media type url content
	*	Condition: if not from communevent
	*	News uploadNewsImage
	*   Update link @param media.content.image in news collection
	*/
	public function actionUploadImageFromMediaUrlNews(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  $news=PHDB::find(News::COLLECTION);
		  $i=0;
		  foreach($news as $key => $data){
			  if(@$data["media"] && @$data["media"]["content"] && @$data["media"]["content"]["image"] && !@$data["media"]["content"]["imageId"]){
				  	if (strstr($data["media"]["content"]["image"],"upload/communecter/news/")==false){
				  		sleep(1);
				  		echo $data["media"]["content"]["image"]."<br/>";
				  		$returnUrl=News::uploadNewsImage($data["media"]["content"]["image"],$data["media"]["content"]["imageSize"],$data["author"]);
				  		$newUrl= Yii::app()->baseUrl."/".$returnUrl;
				  		echo 'Nouvelle url <br/>'.$newUrl."<br/>/////////////<br/>";
				  		PHDB::update(News::COLLECTION,
							array("_id" => $data["_id"]) , 
							array('$set' => array("media.content.image" => $newUrl))			
						);
				  		$i++;
			 		}
				}
			}
			echo "nombre de news avec images provenant d'un autre site////////////// ".$i;
		}
	}
	/* 
	* Scope public in news not well formated (ancient news)
	*	Condition: if not from communevent
	*	News uploadNewsImage
	*   Update link @param media.content.image in news collection
	*/
	public function actionBashRepareBulshit(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  $news=PHDB::find(News::COLLECTION);
		  $nbNews=count($news);
		  $i=0;
		  $newsWrong=0;
		  $nbNewsGood=0;
		  foreach($news as $key => $data){
			  	if($data["scope"]["type"]=="public"){
				  	if(!@$data["scope"]["cities"][0]){
					  	$newScopeArray=array("type"=>"public","cities"=>array());
					  	if($data["type"]=="activityStream"){
						  	$object=PHDB::findOne($data["object"]["objectType"],array("_id"=>new MongoId($data["object"]["id"])));
								$newScopeArray["cities"][0]["codeInsee"]=$object["address"]["codeInsee"];
								$newScopeArray["cities"][0]["postalCode"]=$object["address"]["postalCode"];
								$newScopeArray["cities"][0]["geo"]=$object["geo"];
								PHDB::update(News::COLLECTION,
											array("_id" => $data["_id"]) , 
											array('$set' => array("scope" => $newScopeArray)	
							));
							$newsWrong++;
					  	}
					  	/*else{
							if($data["target"]["type"]=="pixels"){
								$author=PHDB::findOne(Person::COLLECTION,array("_id"=>new MongoId($data["author"])));
								$newScopeArray["cities"][0]["codeInsee"]=$author["address"]["codeInsee"];
								$newScopeArray["cities"][0]["postalCode"]=$author["address"]["postalCode"];
								$newScopeArray["cities"][0]["geo"]=$author["geo"];
							}else {
								$target=PHDB::findOne($data["target"]["type"],array("_id"=>new MongoId($data["target"]["id"])));
								$newScopeArray["cities"][0]["codeInsee"]=$target["address"]["codeInsee"];
								$newScopeArray["cities"][0]["postalCode"]=$target["address"]["postalCode"];
								$newScopeArray["cities"][0]["geo"]=$target["geo"];
							}
							PHDB::update(News::COLLECTION,
											array("_id" => $data["_id"]) , 
											array('$set' => array("scope" => $newScopeArray)	
							));
						}*/

					}
					else{
						$nbNewsGood++;
					}
				}
			}
			echo "nombre total de news: ".$nbNews."news";
			echo "nombre de news mauvaise: ".$newsWrong."news";
			echo "nombre de news good: ".$nbNewsGood."news";
		}
	}
	/* 
	* Scope public in news not well formated (ancient news)
	*	Condition: if not from communevent
	*	News uploadNewsImage
	*   Update link @param media.content.image in news collection
	*/
	public function actionBashNewsWrongScope(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  $news=PHDB::find(News::COLLECTION);
		  $i=0;
		  $nbCityCodeInsee=0;
		  $nbCityName=0;
		  $nbtodelete=0;
		  $nbCityNotFindName=0;
		  foreach($news as $key => $data){
			  if($data["scope"]["type"]=="public"){
				  if(@$data["scope"]["cities"]){
					  	$newScopeArray=array("type"=>"public","cities"=>array());
					  	if(@$data["scope"]["cities"][0] && gettype($data["scope"]["cities"][0])=="string"){

						  	  	echo "<br/>////////id News: ".$key. "/////////";				  	  						  	print_r($data["scope"]);
						  	foreach($data["scope"]["cities"] as $value){
							  	if(is_numeric($value)){
								  	echo "<br/>ici numérique:".$value;
								  	$city=PHDB::findOne(City::COLLECTION, array("insee" => $value));
								  	$newScopeArray["cities"][0]["codeInsee"]=$value;
								  	$newScopeArray["cities"][0]["postalCode"]=$city["postalCodes"][0]["postalCode"];
								  	if(@$data["geo"]){
									  	$newScopeArray["cities"][0]["geo"]=$data["geo"];
								  	}else{
									  	$newScopeArray["cities"][0]["geo"]=$city["geo"];
								  	}
								  	$nbCityCodeInsee++;
							  	} else {
								  	echo "<br/>ici non numérique mais string: ".$value;
								  	if($value=="LA RIVIERE"){
									  	$newScopeArray["cities"][0]["codeInsee"]="97414";
									  	$newScopeArray["cities"][0]["postalCode"]="97421";
									  	$newScopeArray["cities"][0]["geo"]=array('@type' => 'GeoCoordinates','latitude'=>'-21.25833300','longitude'=>'55.44166700');
									  	$nbCityName++;
								  	}
								  	else{
								  	$city = PHDB::findOne(City::COLLECTION, array("alternateName" =>$value));
								  		if(!empty($city)){
									  		$newScopeArray["cities"][0]["codeInsee"]=$city["insee"];
									  		$newScopeArray["cities"][0]["postalCode"]=$city["postalCodes"][0]["postalCode"];
									  		$newScopeArray["cities"][0]["geo"]=$city["geo"];
								  		$nbCityName++;
								  		}else{
								  			echo "ici";
								  			$newScopeArray["cities"][0]="wrong";
								  			$nbCityNotFindName++;	
								  		}
								  	}
							  	}
							  	echo "<br/>===>News array scope: ///<br/>";
								print_r($newScopeArray);
							  	echo "<br/>";
						  	}
						  	PHDB::update(News::COLLECTION,
								array("_id" => $data["_id"]) , 
								array('$set' => array("scope" => $newScopeArray)			
							));
							$i++;
					  	} else {
						  	if (!@$data["scope"]["cities"][0])
							{
							 	echo "<br/>/////////////////// PAS DE 00000 ////////////////////<br/>";
							 	$insee=false;
							 	foreach($data["scope"]["cities"] as $value){
								 	if(is_numeric($value)){
									 	$insee=$value;
								 	}	
							 	}
							 	if($insee){
							 		echo "<br/>ici numérique:".$value;
									  	$city=PHDB::findOne(City::COLLECTION, array("insee" => $value));
									  	$newScopeArray["cities"][0]["codeInsee"]=$value;
									  	$newScopeArray["cities"][0]["postalCode"]=$city["postalCodes"][0]["postalCode"];
									  	if(@$data["geo"]){
										  	$newScopeArray["cities"][0]["geo"]=$data["geo"];
									  	}else{
										  	$newScopeArray["cities"][0]["geo"]=$city["geo"];
									  	}
									  	$nbCityCodeInsee++;
									  	$i++;
									print_r($newScopeArray);
									echo "<br/>";
									PHDB::update(News::COLLECTION,
										array("_id" => $data["_id"]) , 
										array('$set' => array("scope" => $newScopeArray)			
									));
							 	}
							}
							
					  	}
				  } 
				  else{
					  echo "<br/>////news to delete avec wrong scope/////<br/>";
					  print_r($data["scope"]);
					  $nbtodelete++;
					  echo "<br/>";
					   PHDB::remove(News::COLLECTION, array("_id"=>$data["_id"]));
					   $i++;
				  }
			}
			}
			echo "nombre de news avec insee enregistré: ".$nbCityCodeInsee."news";
			echo "nombre de news avec name enregistré: ".$nbCityName."news";
			echo "nombre de news à supprimer: ".$nbtodelete."news";
			echo "nombre de news avec city non trouvé: ".$nbCityNotFindName."news";
			echo "nombre de news avec data publique not well formated: ".$i."news";
		}
	}
	/* First refactor à faire sur communecter.org 
	* Remove all id and type in and object target.id, target.type
	*	=> Modify target type city to target.id=author, target.type=Person::COLLECTION
	*	=> Add @params type string "news" OR "activityStream"
	*/
	public function actionRefactorNews(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  $news=PHDB::find(News::COLLECTION);
		  $i=0;
		  foreach($news as $key => $data){
			  if(@$data["type"] && $data["type"]!="activityStream"){
				  //print_r($data["_id"]);
				  // add une target au lieu de id et type et type devient news
				  // pour les type city => la target devient l'auteur
				  if($data["type"]!="news"){
					  if(@$data["id"]){
					  	$parentType=$data["type"];
					  	$parentId=$data["id"];
					  	if($parentType=="city"){
						  $parentType=Person::COLLECTION;
						  $parentId=$data["author"];
					  	}
					  PHDB::update(News::COLLECTION,
						array("_id" => $data["_id"]) , 
						array('$set' => array("target.type" => $parentType,"target.id"=>$parentId, "type" => "news"),'$unset' => array("id"=>""))			
						);
					$i++;
					} else if($data["type"]=="pixels"){
						PHDB::update(News::COLLECTION,
							array("_id" => $data["_id"]) , 
							array('$set' => array("target.type" => "pixels","target.id"=>"", "type" => "news"),'$unset' => array("id"=>""))			
						);
						$i++;
					}
				}
				 // print_r($data);
			  }
			  if(@$data["type"] && $data["type"]=="activityStream"){
				  if(@$data["target"]){
				 	 //adapter le vocubulaire de target pour qu'il soit comment au news type "news"
				  	// passe target.objectType à target.type
					 $parentType=$data["target"]["objectType"];
					 // $parentId=$data["id"];
						  PHDB::update(News::COLLECTION,
							array("_id" => $data["_id"]) , 
							array('$set' => array("target.type" => $parentType),'$unset' => array("target.objectType"=>""))			
						);
									$i++;
					}
			  }
			}
			echo "nombre de news ////////////// ".$i;
		}
	}

   // Second refactor à faire sur communecter.org qui permet de netoyer les news sans scope
  public function actionWashingNewsNoScopeType(){
	  if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
	  $news=PHDB::find(News::COLLECTION);
	  foreach($news as $key => $data){
			  if(!@$data["scope"]["type"]){
			  print_r($data);
			  PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key)));
			  	
			}
			}
		}
	}
   // Troisième refactor à faire sur communecter.org qui permet de netoyer les news sans target
   	
   	public function actionWashingNewsNoTarget(){
	  	if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
	  		$news=PHDB::find(News::COLLECTION);
	  		$i=0;
	  		$nbNews=count($news);
			echo "Nombre de documents appelés : ".$nbNews;
	  		foreach($news as $key => $data){
			  if($data["type"]=="news" && !@$data["target"]){
				  $i++;
				  print_r($data);
				  PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key)));
			 // PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key)));
			  	
				}
				else if ($data["type"]=="activityStream" && !@$data["target"]){
				$i++;
				  print_r($data);
				PHDB::update(News::COLLECTION,
							array("_id" => $data["_id"]) , 
							array('$set' => array("target.type" => Person::COLLECTION,"target.id"=>$data["author"])));
				  //PHDB::update(News::COLLECTION, array("_id"=>new MongoId($key)));
			 // PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key)));
			  	
				}
			}
			echo "nombre de news traitées ////////////// ".$i;
		}
	}
	// Delete news with object gantts and needs
	public function actionDeleteNewsGanttsNeeds(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		$newsNeeds=PHDB::find(News::COLLECTION,array("type"=>"activityStream","object.objectType"=>"needs"));
		$newsGantts=PHDB::find(News::COLLECTION,array("type"=>"activityStream","object.objectType"=>"gantts"));  		$i=0;	
	  		foreach($newsNeeds as $key => $data){
			  //if(!@$data["target"]){
				  print_r($data);
				  PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key)));
			 // PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key)));
			 	$i++;
				//}
			}
			foreach($newsGantts as $key => $data){
				//if(!@$data["target"]){
				print_r($data);
				PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key)));
				// PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key)));
				$i++;
				//}
			}
			echo "Nombre de news gantts ou needs suprimées : ".$i." news";
			
		}
	}
	// Quatrième refactor à faire sur communecter.org qui permet de netoyer les news dont la target n'existe pas
	public function actionWashingNewsTargetNotExist(){
	  	if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
	  		$news=PHDB::find(News::COLLECTION);
	  		foreach($news as $key => $data){
			  	if(@$data["target"]){
					if(!@$data["target"]["type"]){
						if(@$data["target"]["objectType"]){
							$parentType=$data["target"]["objectType"];
							PHDB::update(News::COLLECTION,
								array("_id" => $data["_id"]) , 
								array('$set' => array("target.type" => $parentType),
									'$unset' => array("target.objectType"=>""))			
							);
						} else{
							PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key))); 
						}
				  }
				  else if($data["target"]["type"]==Person::COLLECTION){
				  	$target = Person::getById($data["target"]["id"]);
				  	if (empty($target)){
					  	print_r($data);
				  		PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key))); 
				  	}
				  }
				  else if($data["target"]["type"]==Event::COLLECTION){
				  	$target = Event::getById($data["target"]["id"]);
				  	if (empty($target)){
					  	print_r($data);
				  		PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key))); 
				  	}
				  }
				  else if($data["target"]["type"]==Organization::COLLECTION){
				  	$target = Organization::getById($data["target"]["id"]);
				  	if (empty($target)){
					  	print_r($data);
				  		PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key))); 
				  	}

				  }
				  else if($data["target"]["type"]==Project::COLLECTION){
				  	$target = Project::getById($data["target"]["id"]);
				  	if (empty($target)){
				  		print_r($data);
				  		PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key))); 
				  	}
				  }	  
				}
			  	else {
				  	print_r($data);
				  	PHDB::update(News::COLLECTION,
								array("_id" => $data["_id"]) , 
								array('$set' => array("target.type" => Person::COLLECTION,
												"target.id" => $data["author"])
									)
					);
			  	}
			}
		}
	}
// Cinquième refactor à faire sur communecter.org qui permet de netoyer les news type activityStream dont l'object n'existe pas
	public function actionWashingNewsObjectNotExist(){
	  	if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
	  		$news=PHDB::find(News::COLLECTION);
	  		$i=0;
	  		$nbNews=count($news);
			echo "Nombre de documents appelés : ".$nbNews;
	  		foreach($news as $key => $data){
		  		if($data["type"]=="activityStream"){
			  		if(@$data["object"]){
					  if($data["object"]["objectType"]==Event::COLLECTION){
					  	$target = Event::getById($data["target"]["id"]);
					  	if (empty($target)){
						  	print_r($data);
						  	$i++;
					  		//PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key))); 
					  	}
					  }
					  else if($data["object"]["objectType"]==Organization::COLLECTION){
					  	$target = Organization::getById($data["target"]["id"]);
					  	if (empty($target)){
						  	print_r($data);
						  						  	$i++;
					  		//PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key))); 
					  	}
		
					  }
					  else if($data["object"]["objectType"]==Project::COLLECTION){
					  	$target = Project::getById($data["target"]["id"]);
					  	if (empty($target)){
					  		print_r($data);
					  							  	$i++;
					  		//PHDB::remove(News::COLLECTION, array("_id"=>new MongoId($key))); 
					  	}
					  }	  
					 }
			  	}
			}
			echo "Nombre de news sans object traitées : ".$i." news";
		}
	}

	public function actionNewsPixels(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$news=PHDB::find(News::COLLECTION);
	  		$i=0;
	  		$nbNews=count($news);
			echo "Nombre de documents appelés : ".$nbNews;
			foreach($news as $key => $data){
				if($data["type"]=="pixels"){
					PHDB::update(News::COLLECTION,
						array("_id" => $data["_id"]) , 
						array('$set' => array("target.type" => "pixels","target.id"=>"", "type" => "news"),'$unset' => array("id"=>""))			
					);
					$i++;
				}
			}
			echo "Nombre de news pixels traitées : ".$i." news";
		}
	}
	// VoteDown
  	public function actionRefactorModerateVoteDown(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  	echo "actionRefactorModerateVoteDown => ";
			$news=PHDB::find(News::COLLECTION, array('voteDown' => array('$exists' => 1),'refactorAction' => array('$exists' => 0)));
			$i=0;
			echo count($news)." News en base avec voteDown<br/>";
			foreach($news as $key => $data){
				$map = array();
				foreach ($data['voteDown'] as $j => $reason) {
					if(!is_array($reason))$map['voteDown.'.$reason] = array('date' => new MongoDate(time())); 
				}
				if(count($map)){
					$res = PHDB::update('news', array('_id' => $data['_id']), array('$set' => array('refactorNews' => new MongoDate(time()))));

					$res = PHDB::update('news', array('_id' => $data['_id']), array('$unset' => array('voteDown' => 1)));
					$res = PHDB::update('news', array('_id' => $data['_id']), array('$set' => $map, '$unset' => array('voteDownReason' => 1)));
					$i++;
				}
				elseif(isset($news['voteDownReason'])){
					$res = PHDB::update('news', array('_id' => $data['_id']), array('$unset' => array('voteDownReason' => 1)));
					$i++;
				}
			}

			echo "nombre de news modifié => ".$i;
		}
	}

	// VoteUp
  	public function actionRefactorModerateVoteUp(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  	echo "actionRefactorModerateVoteUp => ";
			$news=PHDB::find(News::COLLECTION, array('voteUp' => array('$exists' => 1),'refactorNews' => array('$exists' => 0)));
			$i=0;
			echo count($news)." News en base avec voteUp<br/>";
			foreach($news as $key => $data){
				$map = array();
				foreach ($data['voteUp'] as $j => $reason) {
					if(!is_array($reason))$map['voteUp.'.$reason] = array('date' => new MongoDate(time())); 
				}
				if(count($map)){
					$res = PHDB::update('news', array('_id' => $data['_id']), array('$set' => array('refactorNews' => new MongoDate(time()))));
					$res = PHDB::update('news', array('_id' => $data['_id']), array('$unset' => array('voteUp' => 1)));
					$res = PHDB::update('news', array('_id' => $data['_id']), array('$set' => $map, '$unset' => array('voteUpReason' => 1)));
					$i++;
				}
				elseif(isset($news['voteUpReason'])){
					$res = PHDB::update('news', array('_id' => $data['_id']), array('$unset' => array('voteUpReason' => 1)));
					$i++;
				}
			}

			echo "nombre de news modifié => ".$i;
	  	}
	  }


	  // ReportAbuse
	public function actionRefactorModerateReportAbuse(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  	echo "actionRefactorModerateReportAbuse => ";  	
		  	$i = 0;
			$news=PHDB::find(News::COLLECTION, array('reportAbuseReason' => array('$exists' => 1)));
		  	foreach($news as $key => $data){
				$res = PHDB::update('news', array('_id' => $data['_id']), array('$unset' => array('reportAbuseReason' => 1)));
				$res = PHDB::update('news', array('_id' => $data['_id']), array('$unset' => array('reportAbuseCount' => 1)));
				$res = PHDB::update('news', array('_id' => $data['_id']), array('$unset' => array('reportAbuse' => 1)));
				$i++;
			}

			echo count($news)." News en base avec reportAbuseReason<br/>";
		}
	}



	/*public function actionUpdateRegion(){
if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){

		$newsRegions = array(
						//array("new_code","new_name","former_code","former_name"),
						array("01","Guadeloupe","01","Guadeloupe"),
						array("02","Martinique","02","Martinique"),
						array("03","Guyane","03","Guyane"),
						array("04","La Réunion","04","La Réunion"),
						array("06","Mayotte","06","Mayotte"),
						array("11","Île-de-France","11","Île-de-France"),
						array("24","Centre-Val de Loire","24","Centre"),
						array("27","Bourgogne-Franche-Comté","26","Bourgogne"),
						array("27","Bourgogne-Franche-Comté","43","Franche-Comté"),
						array("28","Normandie","23","Haute-Normandie"),
						array("28","Normandie","25","Basse-Normandie"),
						array("32","Nord-Pas-de-Calais-Picardie","31","Nord-Pas-de-Calais"),
						array("32","Nord-Pas-de-Calais-Picardie","22","Picardie"),
						array("44","Alsace-Champagne-Ardenne-Lorraine","41","Lorraine"),
						array("44","Alsace-Champagne-Ardenne-Lorraine","42","Alsace"),
						array("44","Alsace-Champagne-Ardenne-Lorraine","21","Champagne-Ardenne"),
						array("52","Pays de la Loire","52","Pays de la Loire"),
						array("53","Bretagne","53","Bretagne"),
						array("75","Aquitaine-Limousin-Poitou-Charentes","72","Aquitaine"),
						array("75","Aquitaine-Limousin-Poitou-Charentes","54","Poitou-Charentes"),
						array("75","Aquitaine-Limousin-Poitou-Charentes","74","Limousin"),
						array("76","Languedoc-Roussillon-Midi-Pyrénées","73","Midi-Pyrénées"),
						array("76","Languedoc-Roussillon-Midi-Pyrénées","91","Languedoc-Roussillon"),
						array("84","Auvergne-Rhône-Alpes","82","Rhône-Alpes"),
						array("84","Auvergne-Rhône-Alpes","83","Auvergne"),
						array("93","Provence-Alpes-Côte d'Azur","93","Provence-Alpes-Côte d'Azur"),
						array("94","Corse","94","Corse")
					);

		foreach ($newsRegions as $key => $region){

			echo "News : (".$region[0].") ".$region[1]." ---- Ancien : (".$region[2].") ".$region[3]."</br>" ;

			$cities = PHDB::find(City::COLLECTION,array("region" => $region[2]));
			$res = array("result" => false , "msg" => "La région (".$region[0].") ".$region[1]." n'existe pas");
			
			if(!empty($cities)){

				/*$res = PHDB::updateWithOption( City::COLLECTION, 
									  	array("region"=> $region[2]),
				                        array('$set' => array(	"region" => $region[0],
				                        						"regionName" => $region[1])),
				                        array("multi"=> true)
				                    );
				foreach ($cities as $key => $city) {
					$res = PHDB::update( City::COLLECTION, 
									  	array("_id"=>new MongoId($key)),
				                        array('$set' => array(	"region" => $region[0],
				                        						"regionName" => $region[1]))
				                    );

				}
				
				var_dump($res);
				echo "</br></br></br>";

			}
			else
				echo "Result : ".$res["result"]." | ".$res["msg"]."</br></br></br>";

		}

	}*/

	public function actionUpdateUserName() {
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			//add a suffle username for pending users event if they got one
			$pendingUsers = PHDB::find(Person::COLLECTION, array("pending" => true));
			$nbPendingUser = 0;
			foreach ($pendingUsers as $key => $person) {
				$res = PHDB::update( Person::COLLECTION, 
										  	array("_id"=>new MongoId($key)),
					                        array('$set' => array(	
					                        			"username" => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 32)), 
					                        			'$addToSet' => array("modifiedByBatch" => array("updateUserName" => new MongoDate(time()))))

					                    );
				$nbPendingUser++;
			}
			echo "Number of pending user with username modified : ".$nbPendingUser;
		}
	}



	public function actionUpdatePreferences() {
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$nbUser = 0;
			$preferencesUsers = array(
								"publicFields" => array(),
								"privateFields" => array("email", "streetAddress", "phone", "directory", "birthDate"),
								"isOpenData" => false );
			$users = PHDB::find(Person::COLLECTION, array());
			foreach ($users as $key => $person) {
				$person["modifiedByBatch"][] = array("updatePreferences" => new MongoDate(time()));
				$res = PHDB::update(Person::COLLECTION, 
											  	array("_id"=>new MongoId($key)),
						                        array('$set' => array(	"seePreferences" => true,
						                        						"preferences" => $preferencesUsers,
						                        						"modifiedByBatch" => $person["modifiedByBatch"])
						                        					)
						                    );

				if($res["ok"] == 1){
					$nbUser++;
				}else{
					echo "<br/> Error with user id : ".$key;
				}
			}

			echo "Number of user with preferences modified : ".$nbUser;
		}
	}

	public function actionUpdateCitiesBelgique() {
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			/*$cities = PHDB::find(City::COLLECTION, array("country" => "BEL"));

			foreach ($cities as $key => $city) {
				$res = PHDB::update( City::COLLECTION, 
						  	array("_id"=>new MongoId($key)),
	                        array('$set' => array(	"country" => "BE",
													"insee" => substr($city["insee"], 0, 5)."*BE",
													"dep" => substr($city["dep"], 0, 2)."*BE",
													"region" => substr($city["region"], 0, 2)."*BE"))

	                    );
			}*/

			$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);

			foreach ($types as $keyType => $type) {
				$elts = PHDB::find($type, array("address.addressCountry" => "BEL"));

				foreach ($elts as $key => $elt) {
					if(!empty($elt["address"]["codeInsee"])){
						$newAddress = $elt["address"];
						$newAddress["addressCountry"] = "BE";
						$newAddress["codeInsee"] = substr($newAddress["codeInsee"], 0, 5)."*BE";

						$res = PHDB::update($type, 
							  	array("_id"=>new MongoId($key)),
		                        array('$set' => array(	"address" => $newAddress ))
		                    );
					}
					
				}
			}
			echo "good" ;
			
		}
	}


	public function actionCheckNameBelgique(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$cities = PHDB::find(City::COLLECTION, array("country" => "BE"));
			$nbcities = 0 ;
			foreach ($cities as $key => $city) {
				$name = $city["name"];
				$find = false ;
				if(count($city["postalCodes"]) == 1){
					

					foreach ($city["postalCodes"] as $keyCP => $cp) {
						if(trim($cp["name"]) != trim($name)){
							$find =true;
							$cp["name"] = $name ;
							$postalCodes[$keyCP] =  $cp ;
						}


					}

					if($find == true){
						$nbcities ++ ;
						$res = PHDB::update( City::COLLECTION, 
						  	array("_id"=>new MongoId($key)),
	                        array('$set' => array(	"postalCodes" => $postalCodes ))

	                    );
					}
				}			
			}
			echo  "NB Cities : " .$nbcities."<br>" ;

		}
	}


	public function actionAddGeoPosition(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {

				$elements = PHDB::find($type, array("geoPosition" => array('$exists' => 0), "geo" => array('$exists' => 1)));
				foreach ($elements as $key => $elt) {
					if(!empty($elt["geo"])){
						if(!empty($elt["geo"]["longitude"]) && !empty($elt["geo"]["latitude"])){
							$geoPosition = array("type"=>"Point", 
											"coordinates" => array(floatval($elt["geo"]["longitude"]), floatval($elt["geo"]["latitude"])));
							$elt["modifiedByBatch"][] = array("addGeoPosition" => new MongoDate(time()));
							$res = PHDB::update( $type, 
							  	array("_id"=>new MongoId($key)),
		                        array('$set' => array(	"geoPosition" => $geoPosition,
		                        						"modifiedByBatch" => $elt["modifiedByBatch"])), 
		                        array('upsert' => true ));
		                    $nbelement ++ ;
						}else{
							echo  $type." id : " .$key." : pas de longitude ou de latitude<br>" ;
						}	
					}else{
						echo  $type." id : " .$key." : pas de geo <br>" ;
					}


				}

			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;

		}
	}


	public function actionDeleteLinksHimSelf(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {
				$elements = PHDB::find($type, array("links" => array('$exists' => 1)));
				foreach ($elements as $keyElt => $elt) {
					if(!empty($elt["links"])){
						$find = false;
						$newLinks = array();
						foreach(@$elt["links"] as $typeLinks => $links){
							if(array_key_exists ($keyElt , $links)){
								$find = true;
			                    unset($links[$keyElt]);
							}
							$newLinks[$typeLinks] = $links;
						}

						if($find == true){
							$nbelement ++ ;
							$elt["modifiedByBatch"][] = array("deleteLinksHimSelf" => new MongoDate(time()));
							$res = PHDB::update( $type, 
							  	array("_id"=>new MongoId($keyElt)),
		                        array('$set' => array(	"links" => $newLinks,
		                        						"modifiedByBatch" => $elt["modifiedByBatch"])));
							echo "Suppression du link pour le type : ".$type." et l'id ".$keyElt;
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}


	public function actionUpdateCitiesBelgiqueGeo() {
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$cities = PHDB::find(City::COLLECTION, array("country" => "BE"));
			$nbelement= 0 ;
			foreach ($cities as $key => $city) {
				$find = false ;
				$newCPs = array();
				foreach ($city["postalCodes"] as $keyPC => $cp) {
					if(empty($cp["geo"])){
						$find = true ;
						$cp["geo"] = $city["geo"];
						$cp["geoPosition"] = $city["geoPosition"];
					}
					$newCPs[] = $cp;
				}
				if($find == true){
					$nbelement ++ ;
					$res = PHDB::update( City::COLLECTION, 
				  		array("_id"=>new MongoId($key)),
	                	array('$set' => array("postalCodes" => $newCPs)));
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}


	public function actionDeleteLinksDeprecated(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {
				$elements = PHDB::find($type, array("links" => array('$exists' => 1)));
				foreach (@$elements as $keyElt => $elt) {
					if(!empty($elt["links"])){
						$find = false;
						$newLinks = array();
						foreach(@$elt["links"] as $typeLinks => $links){

							foreach(@$links as $keyLink => $link){
								if(!empty($link["type"])){
									$eltL = PHDB::find($link["type"], array("_id"=>new MongoId($keyLink)));
									if(empty($eltL)){
										$find = true;
					                    unset($links[$keyLink]);
									}
									$newLinks[$typeLinks] = $links;
								}
							}
						}
						if($find == true){
							$nbelement ++ ;
							$elt["modifiedByBatch"][] = array("deleteLinksDeprecated" => new MongoDate(time()));
							$res = PHDB::update( $type, 
							  	array("_id"=>new MongoId($keyElt)),
		                        array('$set' => array(	"links" => $newLinks,
		                        						"modifiedByBatch" => $elt["modifiedByBatch"])));
							echo "Suppression de link  deprecated pour le type : ".$type." et l'id ".$keyElt."<br>" ;
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	public function actionRefactorChartProjectData(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$projects = PHDB::find(Project::COLLECTION, array("properties.chart" => array('$exists' => 1)));
			foreach($projects as $data){
				echo "////////// <br/>";
				echo (string)$data["_id"]."<br/>";
				$chart=array();
				$chart["open"]=array();
				foreach($data["properties"]["chart"] as $key => $value){
					$values=array("description"=>"", "value" => $value);
					$chart["open"][$key]=array();
					$chart["open"][$key]=$values;
					//echo $value."<br/>";
				}
				echo "NEW OBJECT<br/>";
				print_r($chart);
				PHDB::update(Project::COLLECTION,
					array("_id" => new MongoId((string)$data["_id"])),
					array('$set' => array("properties.chart"=> $chart))
				);

				echo "////////// <br/>";
			}
		}
	}

	public function actionRemovePropertiesOfOrganizations(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$organizations = PHDB::find(Organization::COLLECTION, array("properties.chart" => array('$exists' => 1)));
			$nbOrgaDealWith=0;
			foreach($organizations as $data){
				PHDB::update(Organization::COLLECTION,
					array("_id" => new MongoId((string)$data["_id"])),
					array('$unset' => array("properties"=> ""))
				);
				$nbOrgaDealWith++;
			}	
			echo "nombre d'organizations traitées : ".$nbOrgaDealWith;
		}
	}

	public function actionFixBugCoutryReunion(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$nbelement = 0 ;
			$elements = PHDB::find(Organization::COLLECTION, array("address.addressCountry" => "Réunion"));
			foreach (@$elements as $keyElt => $elt) {
				if(!empty($elt["address"]["postalCode"]) || !empty($elt["address"]["cp"])){
					$cpElt = (!empty($elt["address"]["postalCode"])?$elt["address"]["postalCode"]:$elt["address"]["cp"]);
					$where = array("postalCodes.postalCode" => $cpElt);
					$cities = PHDB::find("cities",$where);
					foreach (@$cities as $keyCity => $city) {
							$address = array(
						        "@type" => "PostalAddress",
						        "codeInsee" => $city["insee"],
						        "addressCountry" => $city["country"],
						        "postalCode" => $cpElt,
						        "streetAddress" => ((@$elt["address"]["streetAddress"])?trim(@$fieldValue["address"]["streetAddress"]):""),
						        "depName" => $city["depName"],
						        "regionName" => $city["regionName"],
						    	);

							$find = false;
					   		foreach ($city["postalCodes"] as $keyCp => $cp) {
					   			if($cp["postalCode"] == $cpElt){
					   				$address["addressLocality"] = $cp["name"];
					   				$geo = $cp["geo"];
					   				$geoPosition = $cp["geoPosition"];
					   				$find = true;
					   				break;
					   			}
					   		}

					   		if($find == false){
					   			$address["addressLocality"] = $city["alternateName"];
					   			$geo = $city["geo"];
					   			$geoPosition = $city["geoPosition"];
					   		}
						break;  	
					}
					
					$nbelement ++ ;
					$elt["modifiedByBatch"][] = array("fixBugCoutryReunion" => new MongoDate(time()));
					$res = PHDB::update( Organization::COLLECTION, 
					  	array("_id"=>new MongoId($keyElt)),
	                    array('$set' => array(	"address" => $address,
	                    						"geo" => $geo,
	                    						"geoPosition" => $geoPosition,
	                    						"modifiedByBatch" => $elt["modifiedByBatch"])));
					echo "Update orga : l'id ".$keyElt."<br>" ;
					
				}else{
					$nbelement ++ ;
					$elt["modifiedByBatch"][] = array("fixBugCoutryReunion" => new MongoDate(time()));
					$res = PHDB::update( Organization::COLLECTION, 
					  	array("_id"=>new MongoId($keyElt)),
	                    array('$unset' => array("address" => ""),
	                    		'$set' => array( "modifiedByBatch" => $elt["modifiedByBatch"])));
					echo "Update orga : l'id ".$keyElt."<br>" ;
				}
				
			
			}
					
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}


	public function actionRefactorSource(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {
				$elements = PHDB::find($type, array("source" => array('$exists' => 1)));
				if(!empty($elements)){
					foreach (@$elements as $keyElt => $elt) {

						if(!empty($elt["source"])){
							$newsource = array();
							if(!empty($elt["source"]["key"]) && empty($elt["source"]["keys"])){
								$newsource["insertOrign"] = "import" ;
								$newsource["key"] = $elt["source"]["key"];
								$newsource["keys"][] = $elt["source"]["key"];

								if(!empty($elt["source"]["url"]))
									$newsource["url"] = $elt["source"]["url"];
								if(!empty($elt["source"]["id"])){
									if(!empty($elt["source"]["id"]['$numberLong']))

										$newsource["id"] = $elt["source"]["id"]['$numberLong'];

									else
										$newsource["id"] = $elt["source"]["id"];
								}
								if(!empty($elt["source"]["update"]))
									$newsource["update"] = $elt["source"]["update"];
								
								$nbelement ++ ;
								$elt["modifiedByBatch"][] = array("RefactorSource" => new MongoDate(time()));

								try {
									$res = PHDB::update( $type, 
								  		array("_id"=>new MongoId($keyElt)),
			                        	array('$set' => array(	"source" => $newsource,
			                        							"modifiedByBatch" => $elt["modifiedByBatch"])));
								} catch (MongoWriteConcernException $e) {
									echo("Erreur à la mise à jour de l'élément ".$type." avec l'id ".$keyElt);
									die();
								}
								echo "Elt mis a jour : ".$type." et l'id ".$keyElt."<br>" ;


							}
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	/**
	 * Refactor events with no timezone depending on country
	 * Must be launch only once !
	 */
	public function actionAddTZOnEventDates(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$nbelement = 0 ;
			$nbelementPassed = 0 ;
			$nbelementRE = 0 ;
			$nbelementBE = 0 ;
			$nbelementFR = 0 ;
			$nbelementNC = 0 ;
			$nbelementUnknown = 0 ;
			$nbelementDateString = 0 ;
			$timezoneArray = array("RE" => 4, "FR" => 1, "NC" => 11, "BE" => 1);

			$elements = PHDB::find(Event::COLLECTION, array());
			foreach (@$elements as $keyElt => $elt) {
				if (isset($elt["modifiedByBatch"])) {
					$alreadyUpdated = false;
					foreach ($elt["modifiedByBatch"] as $value) {
						if (isset($value["addTZOnEventDates"])) {
							$nbelementPassed++;
							$alreadyUpdated = true;
							break;
						}
					}
					if ($alreadyUpdated) continue;
				}
				if(empty($elt["address"]["addressCountry"]) || 
				   empty($timezoneArray[$elt["address"]["addressCountry"]])) {
					echo "Pas de country ou country inconnu pour l'événement : ".$keyElt."</br>";
					$nbelementUnknown++;
					continue;
				}
				$timezone = $timezoneArray[$elt["address"]["addressCountry"]];
				if (isset($elt["startDate"]) && isset($elt["endDate"]) && (gettype($elt["startDate"]) == "object" && gettype($elt["endDate"]) == "object")) {
					//Set TZ to UTC in order to be the same than Mongo
					$startDate = new DateTime(date(DateTime::ISO8601, $elt["startDate"]->sec));
					$startDate = $startDate->sub(new DateInterval("PT".$timezone."H"));
					$endDate = new DateTime(date(DateTime::ISO8601, $elt["endDate"]->sec));
					$endDate = $endDate->sub(new DateInterval("PT".$timezone."H"));
					//$startDate = $elt["startDate"]->toDateTime()->sub(new DateInterval("PT".$timezone."H"));
					//$endDate = $elt["endDate"]->toDateTime()->sub(new DateInterval("PT".$timezone."H"));
					${'nbelement'.$elt["address"]["addressCountry"]}++;
				//On en profite pour revoir les dates des événements qui sont en string ou sans date
				} else {
					$nbelementDateString++;
					$startDate = new DateTime();
					$startDate->sub(new DateInterval("P1D"));
					$endDate = new DateTime();
					$endDate->sub(new DateInterval("P2D"));
				}
				//update the event
				$elt["modifiedByBatch"][] = array("addTZOnEventDates" => new MongoDate(time()));
				PHDB::update( Event::COLLECTION, array("_id" => new MongoId($keyElt)), 
			                          array('$set' => array(
			                          		"startDate" => new MongoDate($startDate->getTimestamp()), 
			                          		"endDate" => new MongoDate($endDate->getTimestamp()),
			                        		"modifiedByBatch" => $elt["modifiedByBatch"])));
				$nbelement++;
			}
					
			echo  "Event Reunion mis à jours: " .$nbelementRE."<br>" ;
			echo  "Event France mis à jours: " .$nbelementFR."<br>" ;
			echo  "Event Belgique mis à jours: " .$nbelementBE."<br>" ;
			echo  "Event NC mis à jours: " .$nbelementNC."<br>" ;
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
			echo  "NB Element passé : " .$nbelementPassed."<br>" ;
			echo  "NB Element inconnu : " .$nbelementUnknown."<br>" ;
			echo  "NB Element date en string : " .$nbelementDateString."<br>" ;
		}
	}


	/*public function actionNameHtmlSpecialCaractere(){
	if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);
		$nbelement = 0 ;
		foreach ($types as $keyType => $type) {
			$elements = PHDB::find($type, array("name" => array('$exists' => 1)));
			if(!empty($elements)){
				foreach (@$elements as $keyElt => $elt) {
					if(!empty($elt["name"])){
						$nbelement ++ ;
						$elt["modifiedByBatch"][] = array("NameHtmlSpecialCaractere" => new MongoDate(time()));
						try {
							$res = PHDB::update( $type, 
						  		array("_id"=>new MongoId($keyElt)),
	                        	array('$set' => array(	"name" => htmlspecialchars($elt["name"]),
	                        							"modifiedByBatch" => $elt["modifiedByBatch"])));
						} catch (MongoWriteConcernException $e) {
							echo("Erreur à la mise à jour de l'élément ".$type." avec l'id ".$keyElt);
							die();
						}
						echo "Elt mis a jour : ".$type." et l'id ".$keyElt."<br>" ;
					}
				}
			}
		}		
		echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}}*/


	public function actionNameHtmlSpecialCharsDecode(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {
				$elements = PHDB::find($type, array("name" => array('$exists' => 1)));
				if(!empty($elements)){
					foreach (@$elements as $keyElt => $elt) {
						if(!empty($elt["name"])){
							$nbelement ++ ;
							$elt["modifiedByBatch"][] = array("NameHtmlSpecialCharsDecode" => new MongoDate(time()));
							try {
								$res = PHDB::update( $type, 
							  		array("_id"=>new MongoId($keyElt)),
		                        	array('$set' => array(	"name" => htmlspecialchars_decode($elt["name"]),
		                        							"modifiedByBatch" => $elt["modifiedByBatch"])));
							} catch (MongoWriteConcernException $e) {
								echo("Erreur à la mise à jour de l'élément ".$type." avec l'id ".$keyElt);
								die();
							}
							echo "Elt mis a jour : ".$type." et l'id ".$keyElt."<br>" ;
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	public function actionAddDepAndRegionAndCountryInAddress(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){


			$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);
			$nbelement = 0 ;
			$arrayDep = array("address.depName" => array('$exists' => 0));
			$arrayRegion = array("address.regionName" => array('$exists' => 0));
			$arrayCountry = array("address.addressCountry" => array('$exists' => 0));
			$arrayStreet = array("address.streetAddress" => array('$exists' => 0));
			$where = array('$and' => array(
							array("address" => array('$exists' => 1)), 
							array('$or' => array($arrayDep, $arrayRegion, $arrayCountry, $arrayStreet))
						));
			
			foreach ($types as $keyType => $type) {
				
				$elements = PHDB::find($type, $where);
				
				if(!empty($elements)){
					foreach (@$elements as $keyElt => $elt) {
						if(!empty($elt["name"])){
							$nbelement ++ ;
							$elt["modifiedByBatch"][] = array("AddDepAndRegionAndCountryInAddress" => new MongoDate(time()));
							$address = $elt["address"];

							if (isset($address["codeInsee"])) {
								$depAndRegion = City::getDepAndRegionByInsee($address["codeInsee"]);

								$address["depName"] = (empty($depAndRegion["depName"]) ? "" : $depAndRegion["depName"]);
								$address["regionName"] = (empty($depAndRegion["regionName"]) ? "" : $depAndRegion["regionName"]);
								$address["addressCountry"] = (empty($depAndRegion["country"]) ? "" : $depAndRegion["country"]);
								$address["streetAddress"] = (empty($elt["address"]["streetAddress"]) ? "" : $elt["address"]["streetAddress"]);
								try {
									$res = PHDB::update( $type, 
								  		array("_id"=>new MongoId($keyElt)),
			                        	array('$set' => array(	"address" => $address,
			                        							"modifiedByBatch" => $elt["modifiedByBatch"])));
								} catch (MongoWriteConcernException $e) {
									echo("Erreur à la mise à jour de l'élément ".$type." avec l'id ".$keyElt);
									die();
								}
								echo "Elt mis a jour : ".$type." et l'id ".$keyElt."<br>" ;
							} else {
								echo "Pas de mise a jour : ".$type." et l'id ".$keyElt."<br>" ;
							}
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	public function actionHtmlToMarkdown(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$html = "<h3> TEst </h3>
					<p>Welcome to the demo:</p>
					<ol>
					<li>Write Markdown text on the left</li>
					<li>Hit the <strong>Parse</strong> button or <code>⌘ + Enter</code></li>
					<li>See the result to on the right</li>
					</ol>" ;

			echo $html ;

			echo "<br/><br/><br/><br/>";

			
			

			try {
	            //$mailError = new MailError($_POST);
	            $converter = new Htmlconverter();
				$mark = $converter->convert($html);
	        } catch (CTKException $e) {
	            Rest::sendResponse(450, "Webhook : ".$e->getMessage());
	            die;
	        }
			echo $mark;
		}
	}

	public function actionDescInHtml(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION, Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {
				$elements = PHDB::find($type, array("description" => array('$exists' => 1)));
				if(!empty($elements)){
					foreach (@$elements as $keyElt => $elt) {
						if(!empty($elt["name"])){
							$nbelement ++ ;
							$elt["modifiedByBatch"][] = array("DescInHtml" => new MongoDate(time()));
							try {
								$res = PHDB::update( $type, 
							  		array("_id"=>new MongoId($keyElt)),
		                        	array('$set' => array(	"descriptionHTML" => true,
		                        							"modifiedByBatch" => $elt["modifiedByBatch"])));
							} catch (MongoWriteConcernException $e) {
								echo("Erreur à la mise à jour de l'élément ".$type." avec l'id ".$keyElt);
								die();
							}
							echo "Elt mis a jour : ".$type." et l'id ".$keyElt."<br>" ;
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	public function actionChangePhoneObjectToArray(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION, Organization::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {
				$elements = PHDB::find($type, array("telephone" => array('$exists' => 1)));
				if(!empty($elements)){
					foreach (@$elements as $keyElt => $elt) {
						if(!empty($elt["name"])){
							$nbelement ++ ;
							$elt["modifiedByBatch"][] = array("ChangePhoneObjectToArray" => new MongoDate(time()));
							
							if(!empty($elt["telephone"]["fixe"])) {
								$elt["telephone"]["fixe"] = json_decode(json_encode($elt["telephone"]["fixe"]), true);
							}

							if(!empty($elt["telephone"]["mobile"])){
								$elt["telephone"]["fixe"] = json_decode(json_encode($elt["telephone"]["mobile"]), true);
							}

							if(!empty($elt["telephone"]["fax"]) ){
								$elt["telephone"]["fax"] = json_decode(json_encode($elt["telephone"]["fax"]), true);
							}

							try {
								$res = PHDB::update( $type, 
							  		array("_id"=>new MongoId($keyElt)),
		                        	array('$set' => array(	"telephone" => $elt["telephone"],
		                        							"modifiedByBatch" => $elt["modifiedByBatch"])));
							} catch (MongoWriteConcernException $e) {
								echo("Erreur à la mise à jour de l'élément ".$type." avec l'id ".$keyElt);
								die();
							}
							echo "Elt mis a jour : ".$type." et l'id ".$keyElt."<br>" ;
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	public function actionAddGeoShapeMissing(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$cities = PHDB::find(City::COLLECTION, array("geoShape" => array('$exists' => 0)));

			foreach ($cities as $key => $city) {
				$name = str_replace(" ", "+", trim($city["name"]));
				$url = "http://nominatim.openstreetmap.org/search?format=json&addressdetails=1&city=".$name."&countrycodes=FR&polygon_geojson=1&extratags=1" ;
				$nominatim = json_decode(file_get_contents($url), true);
				$find = false ;
				if(!empty($nominatim)){
					foreach ($nominatim as $key => $value) {
						if($value["osm_type"] == "relation" && !empty($value["geojson"]) && $find == false){
							echo $city["insee"]." : ". $city["name"]." : ".$value["osm_id"]."<br/>";
							$find = true ;

							$city["modifiedByBatch"][] = array("AddGeoShapeMissing" => new MongoDate(time()));
							try {
								$res = PHDB::update( City::COLLECTION, 
							  		array("_id"=>new MongoId((String)$city["_id"])),
		                        	array('$set' => array(	"geoShape" => $value["geojson"],
		                        							"osmID" => $value["osm_id"],
		                        							"modifiedByBatch" => $city["modifiedByBatch"])));
							} catch (MongoWriteConcernException $e) {
								echo("Erreur à la mise à jour de l'élément ".City::COLLECTION." avec l'id ".$key);
								die();
							}
						}
					}
				}
			}
		}
	}


	public function actionChangePrefObjectToArray(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {
				$elements = PHDB::find($type, array("preferences" => array('$exists' => 1)));
				if(!empty($elements)){
					foreach (@$elements as $keyElt => $elt) {
						if(!empty($elt["name"])){
							$nbelement ++ ;
							$elt["modifiedByBatch"][] = array("ChangePrefObjectToArray" => new MongoDate(time()));
							
							if(!empty($elt["preferences"]["publicFields"])) {
								$elt["preferences"]["publicFields"] = json_decode(json_encode($elt["preferences"]["publicFields"]), true);
							}

							if(!empty($elt["preferences"]["privateFields"])){
								$elt["preferences"]["privateFields"] = json_decode(json_encode($elt["preferences"]["privateFields"]), true);
							}

							try {
								$res = PHDB::update( $type, 
							  		array("_id"=>new MongoId($keyElt)),
		                        	array('$set' => array(	"preferences" => $elt["preferences"],
		                        							"modifiedByBatch" => $elt["modifiedByBatch"])));
							} catch (MongoWriteConcernException $e) {
								echo("Erreur à la mise à jour de l'élément ".$type." avec l'id ".$keyElt);
								die();
							}
							echo "Elt mis a jour : ".$type." et l'id ".$keyElt."<br>" ;
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	public function actionInitMultiScope(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$types = array(Person::COLLECTION);
			$nbelement = 0 ;
			foreach ($types as $keyType => $type) {
				$elements = PHDB::find($type, array("multiscopes" => array('$exists' => 1)));
				if(!empty($elements)){
					foreach (@$elements as $keyElt => $elt) {
						if(!empty($elt["name"])){
							$nbelement ++ ;
							$elt["modifiedByBatch"][] = array("InitMultiScope" => new MongoDate(time()));
							
							try {
								$res = PHDB::update( $type, 
							  		array("_id"=>new MongoId($keyElt)),
		                        	array(	'$unset' 	=> array(	"multiscopes" => null),
		                        			'$set' 		=> array(	"modifiedByBatch" => $elt["modifiedByBatch"])));
							} catch (MongoWriteConcernException $e) {
								echo("Erreur à la mise à jour de l'élément ".$type." avec l'id ".$keyElt);
								die();
							}
							echo "Elt mis a jour : ".$type." et l'id ".$keyElt."<br>" ;
						}
					}
				}
			}		
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	public function actionObjectObjectTypeNewsToObjectType(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  	// Check in mongoDB
		  	//// db.getCollection('news').find({"object.objectType": {'$exists':true}})
		  	// Check number of news to formated
		  	//// db.getCollection('news').find({"object.objectType": {'$exists':true}}).count()
		  	$news=PHDB::find(News::COLLECTION,array("object.objectType"=>array('$exists'=>true)));
		  	$nbNews=0;
		  	foreach($news as $key => $data){
		  		$newObject=array("id"=>$data["object"]["id"], "type"=> $data["object"]["objectType"]);
				PHDB::update(News::COLLECTION,
					array("_id" => $data["_id"]) , 
					array('$set' => array("object" => $newObject))
				);
		  		$nbNews++;
		  	}
		  	echo "nombre de news traitées:".$nbNews." news";
		}
	}


	public function actionUpOldNotifications(){
	  	if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
	  	// Update notify.id 
	  	$notifications=PHDB::find(ActivityStream::COLLECTION,array("notify.id"=>array('$exists'=>true)));
	  	$nbNotifications=0;
	  	//print_r($notifications);
	  	foreach($notifications as $key => $data){
	  		//print_r($data["notify"]["id"]);
	  		$update=false;
	  		$newArrayId=array();
	  		foreach($data["notify"]["id"] as $val){
				if(gettype($val)=="string"){
					//echo($val);
	  				$newArrayId[$val]=array("isUnsee"=>true,"isUnread"=>true);
	  				$update=true;
	  			}
	  		}
	  		if($update){
	  			//print_r($newArrayId);
				PHDB::update(ActivityStream::COLLECTION,
					array("_id" => $data["_id"]) , 
					array('$set' => array("notify.id" => $newArrayId))
				);
				$nbNotifications++;
			}
	  	}
	  	echo "nombre de notifs traitées:".$nbNotifications." notifs";
	  }
	}


  	public function actionSharedByRefactor(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
		  	// Check in mongoDB
		  	//// db.getCollection('news').find({"object.objectType": {'$exists':true}})
		  	// Check number of news to formated
		  	//// db.getCollection('news').find({"object.objectType": {'$exists':true}}).count()
		  	$news=PHDB::find(News::COLLECTION,array());
		  	$nbNews=0;
		  	foreach($news as $key => $data){
		  		if(@$data["targetIsAuthor"] && $data["targetIsAuthor"] == true ){
					PHDB::update(News::COLLECTION,
						array("_id" => $data["_id"]) , 
						array('$set' => array("sharedBy" => array(array('id'=> $data["target"]["id"],
	        					'type'=>$data["target"]["type"],
	        					'updated'=> $data["created"]))))
					);
				} else {
					PHDB::update(News::COLLECTION,
						array("_id" => $data["_id"]) , 
						array('$set' => array("sharedBy" => array(array('id'=> $data["author"],
	        					'type'=>"citoyens",
	        					'updated'=> $data["created"]))))
					);
				}
		  		$nbNews++;
		  	}
		  	echo "nombre de news traitées:".$nbNews." news";
	  		
	  	}
	 }
	public function actionChangeEventFrenchType(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			echo "Traitement des événements avec le type 'exposition' ou 'concours'";
		  	$events=PHDB::find(Event::COLLECTION,array('$or' => array( array('type' => 'concours'), array('type' => 'exposition') )));
		  	$nbEvents=0;
		  	
		  	foreach($events as $key => $data){
		  		if($data["type"]=="exposition")
		  			$newType="exhibition";
		  		else if($data["type"]=="concours")
		  			$newType="contest";
				PHDB::update(Event::COLLECTION,
						array("_id" => $data["_id"]) , 
						array('$set' => array('type'=> $newType)));
				$nbEvents++;
				
		  	}
		  	echo "nombre de events traités:".$nbEvents." events";
	  		
	  	}
	 }
	 public function actionChangePoiType(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			echo "Traitement des p(zéro)is<br/>";
		  	$pois=PHDB::find(Poi::COLLECTION);
		  	$nbPois=0;
		  	
		  	foreach($pois as $key => $data){
		  		if(!@$data["type"]){
		  			$newType="other";
		  		}else{
			  		if($data["type"]=="poi")
			  			$newType="other";
			  		else if($data["type"]=="streetArts")
			  			$newType="streetArt";
			  		else if($data["type"]=="ficheBlanche")
			  			$newType="documentation";
			  		else if($data["type"]=="RessourceMaterielle")
			  			$newType="materialRessource";
			  		else
			  			$newType=$data["type"];
		  		}
				PHDB::update(Poi::COLLECTION,
						array("_id" => $data["_id"]) , 
						array('$set' => array('type'=> $newType)));
				$nbPois++;
				
		  	}
		  	echo "nombre de p0is traités:".$nbPois." pois";
	  		
	  	}else
	  		echo "jajajajajja: Tu as volé trop près du soleil Icare";
	 }

	public function actionCreatorUpdatedOnNotifications(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			echo "nombre de notifs attendus = environs 15.3k";
		  	$notifications=PHDB::find(ActivityStream::COLLECTION,array("notify"=>array('$exists'=>true),"updated"=>array('$exists'=>false)));
		  	$nbNotifs=0;
		  	$nbNotifsDeleted=0;
		  	foreach($notifications as $key => $data){
		  		if(!@$data["created"] ){
		  			PHDB::remove(ActivityStream::COLLECTION, array("_id"=>new MongoId($key)));
		  			$nbNotifsDeleted++;
		  		}
		  		if(!@$data["updated"] && @$data["created"] ){
					PHDB::update(ActivityStream::COLLECTION,
						array("_id" => $data["_id"]) , 
						array('$set' => array('updated'=> $data["created"])));
					$nbNotifs++;
				}
				
		  	}
		  	echo "Nombre de notifs deleted car pas de created (normalement 383):".$nbNotifsDeleted." notifs<br/>";
		  	echo "nombre de notifications traitées:".$nbNotifs." notifs";
	  		
	  	}
	 }


  	public function actionUpdateRegion(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){

			$newsRegions = array(
							//array("new_code","new_name","former_code","former_name"),
							array("01","Guadeloupe","01","Guadeloupe"),
							array("02","Martinique","02","Martinique"),
							array("03","Guyane","03","Guyane"),
							array("04","La Réunion","04","La Réunion"),
							array("06","Mayotte","06","Mayotte"),
							array("11","Île-de-France","11","Île-de-France"),
							array("24","Centre-Val de Loire","24","Centre"),
							array("27","Bourgogne-Franche-Comté","26","Bourgogne"),
							array("27","Bourgogne-Franche-Comté","43","Franche-Comté"),
							array("28","Normandie","23","Haute-Normandie"),
							array("28","Normandie","25","Basse-Normandie"),
							array("32","Nord-Pas-de-Calais-Picardie","31","Nord-Pas-de-Calais"),
							array("32","Nord-Pas-de-Calais-Picardie","22","Picardie"),
							array("44","Alsace-Champagne-Ardenne-Lorraine","41","Lorraine"),
							array("44","Alsace-Champagne-Ardenne-Lorraine","42","Alsace"),
							array("44","Alsace-Champagne-Ardenne-Lorraine","21","Champagne-Ardenne"),
							array("52","Pays de la Loire","52","Pays de la Loire"),
							array("53","Bretagne","53","Bretagne"),
							array("75","Aquitaine-Limousin-Poitou-Charentes","72","Aquitaine"),
							array("75","Aquitaine-Limousin-Poitou-Charentes","54","Poitou-Charentes"),
							array("75","Aquitaine-Limousin-Poitou-Charentes","74","Limousin"),
							array("76","Languedoc-Roussillon-Midi-Pyrénées","73","Midi-Pyrénées"),
							array("76","Languedoc-Roussillon-Midi-Pyrénées","91","Languedoc-Roussillon"),
							array("84","Auvergne-Rhône-Alpes","82","Rhône-Alpes"),
							array("84","Auvergne-Rhône-Alpes","83","Auvergne"),
							array("93","Provence-Alpes-Côte d'Azur","93","Provence-Alpes-Côte d'Azur"),
							array("94","Corse","94","Corse")
						);

			foreach ($newsRegions as $key => $region){

				echo "News : (".$region[0].") ".$region[1]." ---- Ancien : (".$region[2].") ".$region[3]."</br>" ;

				$cities = PHDB::find(City::COLLECTION,array("region" => $region[2]));
				$res = array("result" => false , "msg" => "La région (".$region[0].") ".$region[1]." n'existe pas");
				
				if(!empty($cities)){
					foreach ($cities as $key => $city) {
						$res = PHDB::update( City::COLLECTION, 
										  	array("_id"=>new MongoId($key)),
					                        array('$set' => array(	"region" => $region[0],
					                        						"regionName" => $region[1]))
					                    );
					}
					echo "</br></br></br>";
					echo "Result : ".$res["result"]." | ".$res["msg"]."</br></br></br>";
				}
				else
					echo "Result : ".$res["result"]." | ".$res["msg"]."</br></br></br>";

			}

		}
	}

	public function actionDepRefactorCitiesZones(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			$dep = array();
			$cities = PHDB::find(City::COLLECTION, array("depName" => array('$exists' => 1)));
			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					if(!empty($city["depName"]) && trim($city["depName"]) != "" && !in_array($city["depName"], $dep)){
						$dep[] = $city["depName"];
						$zone = Zone::createLevel($city["depName"], $city["country"], "4");
						if(!empty($zone)){
							$nbelement++;
							Zone::save($zone);
						}
					}
				}
			}
			
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}


	public function actionAddZeroPostalCode(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			$where = array( '$and' => array(
										array("address.postalCode" => array('$exists' => 1)),
										array("address.addressCountry" => array('$ne' => "BE") ) ),
							'$where' => "this.address.postalCode.length == 4" );

			$orgs = PHDB::find(Organization::COLLECTION, $where);

			if(!empty($orgs)){
				foreach (@$orgs as $keyElt => $org) {
					$res = PHDB::update( Organization::COLLECTION, 
										  	array("_id"=>new MongoId($keyElt)),
					                        array('$set' => array(	"address.postalCode" => "0".$org["address"]["postalCode"]))
					                    );
					echo $org["name"]." : ".$org["address"]["postalCode"]." > 0".$org["address"]["postalCode"]."<br>" ;
					$nbelement++;
				}
			}
			
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}
	//Bash on document used for profil and banner of element
	//Used for delete in gallery to know directly when a current doc is used as profil and banner  
	//find doc used current for profil and banner
	public function actionAddCurrentToDoc(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$docs=PHDB::find(Document::COLLECTION, array(
				'$or'=>array(
					array("contentKey"=>"banner"),
					array("contentKey"=>"profil")
					)));
			$totalProfil=0;
			$totalBanner=0;
			foreach($docs as $key => $data){
				if(@$data["id"] && $data["type"]!="city"){
					$element=Element::getElementSimpleById($data["id"], $data["type"],null,array("profilImageUrl","profilBannerUrl"));
					$docProfilUrl=Document::getDocumentFolderUrl($data)."/".$data["name"];
					if(!empty($element["profilImageUrl"]) && @$docProfilUrl && $docProfilUrl==$element["profilImageUrl"]){
						echo "Profil:".$key."<br>";
						PHDB::update(Document::COLLECTION,array("_id"=>new MongoId($key)),array('$set'=>array("current"=>true)));
						$totalProfil++;
					}
					if(!empty($element["profilBannerUrl"]) && @$docProfilUrl && $docProfilUrl==$element["profilBannerUrl"]){
						echo "banner:".$key."<br>";
						PHDB::update(Document::COLLECTION,array("_id"=>new MongoId($key)),array('$set'=>array("current"=>true)));
						$totalBanner++;
					}
				}
			}
			echo "Nombre de profil used actually by element:".$totalProfil."<br>";
			echo "Nombre de banner used actually by element:".$totalBanner;
		}else
			echo "connectoi crétin";
	}
	
	// -------------------- Fonction pour le refactor Cities/zones
	public function actionRegionBERefactorCitiesZones(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			$region = array();
			$cities = PHDB::find(City::COLLECTION, array("regionNameBel" => array('$exists' => 1)));
			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					if(!empty($city["regionNameBel"]) && trim($city["regionNameBel"]) != "" && !in_array($city["regionNameBel"], $region)){
						
						$zone = Zone::createLevel($city["regionNameBel"], $city["country"], "2");

						
						if(!empty($zone)){
							$region[] = $city["regionNameBel"];
							$nbelement++;
							Zone::save($zone);
						}else{
							echo  "Erreur: " .$city["regionNameBel"]." : City :".(String)$city["_id"]."<br>" ;

						}
					}
				}
			}
			
			foreach (@$region as $k => $v) {
				echo  "Good: " .$v."<br>" ;
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}



	public function actionRegionRefactorCitiesZones(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			$erreur = array();
			$region = array();
			$aggregate = array(
			    array(
			        '$group' => array(
			            "_id" => array(	"regionName" => '$regionName', 
			            				"country" => '$country',
			            				"regionNameBel" => '$regionNameBel' ),
			        ),
			    ),
			);

			$cities = PHDB::aggregate( City::COLLECTION, $aggregate);
			

			if(!empty($cities["result"])){
				foreach (@$cities["result"] as $keyElt => $city) {				
					if(!empty($city["_id"]["regionName"]) && trim($city["_id"]["regionName"]) != ""){
						
						$exists = PHDB::findOne(Zone::COLLECTION, array('$and' => array(
													array("name" => $city["_id"]["regionName"] ) , 
													 array("level" => "3" ) ) ) );
						if($exists== null){
							$zone = Zone::createLevel($city["_id"]["regionName"], $city["_id"]["country"], "3", ((!empty($city["_id"]["regionNameBel"])) ? $city["_id"]["regionNameBel"] : null));
							if(!empty($zone)){
								$region[] = $city["_id"]["regionName"];
								$nbelement++;
								Zone::save($zone);
							}else{
								$erreur[] = $city["_id"]["regionName"];
							}
						}
						
					}
				}
			}

			foreach (@$region as $k => $v) {
				echo  "Good: " .$v."<br>" ;
			}
			
			foreach (@$erreur as $k => $v) {
				echo  "Erreur: " .$v." : City :".$k."<br>" ;
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}

	public function actionDepRefactorCitiesZones2(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			$erreur = array();
			$region = array();
			$aggregate = array(
			    array(
			        '$group' => array(
			            "_id" => array(	"depName" => '$depName', 
			            				"country" => '$country',
			            				"regionNameBel" => '$regionNameBel',
			            				"regionName" => '$regionName', ),
			        ),
			    ),
			);

			$cities = PHDB::aggregate( City::COLLECTION, $aggregate);
			

			if(!empty($cities["result"])){
				foreach (@$cities["result"] as $keyElt => $city) {				
					if( !empty($city["_id"]["depName"]) && trim($city["_id"]["depName"]) != ""){
						
						$exists = PHDB::findOne(Zone::COLLECTION, array('$and' => array(
													array("name" => $city["_id"]["depName"] ) , 
													 array("level" => "4" ) ) ) );
						if($exists== null){
							$zone = Zone::createLevel($city["_id"]["depName"], $city["_id"]["country"], "4", ((!empty($city["_id"]["regionNameBel"])) ? $city["_id"]["regionNameBel"] : null), ((!empty($city["_id"]["regionName"])) ? $city["_id"]["regionName"] : null));
							if(!empty($zone)){
								$region[] = $city["_id"]["depName"];
								$nbelement++;
								Zone::save($zone);
							}else{
								$erreur[] = $city["_id"]["depName"];
							}
						}
						
					}
				}
			}

			foreach (@$region as $k => $v) {
				echo  "Good: " .$v."<br>" ;
			}
			
			foreach (@$erreur as $k => $v) {
				echo  "Erreur: " .$v." : City :".$k."<br>" ;
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}


	public function actionAddDepName(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			$region = array();
			$cities = PHDB::find(City::COLLECTION, array("depName" => array('$exists' => 0) ) );
			if(!empty($cities)){
				foreach (@$cities as $key => $city) {
					if(!empty($city["dep"])){
						$depName = PHDB::findOne(City::COLLECTION, array( '$and' => array( 
																			array( "dep" => $city["dep"] ),

																			array( '$or' => array(
																				array("depName" => array('$exists' => 1) ),
																				array("regionName" => array('$exists' => 1) ) ) ) 
																		) ) );
						if(!empty($depName)){
							$name = "";
							if(!empty($depName["depName"])){
								$name = $depName["depName"] ;
							}else if(!empty($depName["regionName"])){
							
								$name = ucfirst(strtolower($depName["regionName"])) ;
							}

							$res = PHDB::update( City::COLLECTION, 
										  	array("_id"=>new MongoId($key)),
					                        array('$set' => array(	"depName" => $name ))
					                    );
							echo  "Good: ".$city["name"]." ".$name."<br>" ;
							$nbelement++;
							
						}
						else
							echo  "Erreur: ".$city["name"]." ".$depName["depName"]."<br>" ;
					}

				}
			}

			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}



	public function actionLinkCityAndZone(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			ini_set('max_execution_time', 300);
			$nbelement = 0 ;
			$erreur = array();
			$region = array();
			$cities = PHDB::find(City::COLLECTION, array("modifiedByBatch.LinkCityAndZone" => 
															array('$exists' => 0)) );

			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					//if($nbelement == 0){
						$set = array();			
						if(!empty($city["dep"]) && !empty($city["depName"])){
							$city["dep"] = Zone::getIdLevelByNameAndCountry($city["depName"], "4", $city["country"]);
							$set["dep"] = $city["dep"];
						}

						if(!empty($city["region"]) && !empty($city["regionName"])){
							$city["region"] = Zone::getIdLevelByNameAndCountry($city["regionName"], "3", $city["country"]);
							$set["region"] = $city["region"];
						}

						if(!empty($city["regionBel"])){
							$city["regionBel"] = Zone::getIdLevelByNameAndCountry($city["regionNameBel"], "2", $city["country"]);
							$set["regionBel"] = $city["regionBel"];
						}


						if($set ==  true){
							$city["modifiedByBatch"][] = array("LinkCityAndZone" => new MongoDate(time()));

							//var_dump($keyElt);
							if($city["country"] == "BE"){
								$res = PHDB::update( City::COLLECTION, 
										  	array("_id"=>new MongoId($keyElt)),
					                        array('$set' => array(	"dep" => $city["dep"],
					                        						"region" => $city["region"],
					                        						"regionBel" => $city["regionBel"],
					                        						"modifiedByBatch" => $city["modifiedByBatch"]))
					                    );
							}else{
								$res = PHDB::update( City::COLLECTION, 
										  	array("_id"=>new MongoId($keyElt)),
					                        array('$set' => array(	"dep" => $city["dep"],
					                        						"region" => $city["region"],
					                        						"modifiedByBatch" => $city["modifiedByBatch"]))
					                    );
							}
							
							echo  "Good: ".$city["name"]." ".$city["country"]." : ".$keyElt."<br>" ;
							$nbelement++;
						}
						else
							echo  "Erreur: ".$city["name"]." ".$city["country"]." : ".$keyElt."<br>" ;
					//}
					
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}




	// -------------------- Fonction pour le refactor Cities/zones
	public function actionFinalisation(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			$region = array();
			$zones = PHDB::find(Zone::COLLECTION, array('$and' => array(
															array("level" => "3"),
															array("countryCode" => "FR",
															/*array("level2" => array('$exists' => 0)*/)
														)));
			if(!empty($zones)){
				foreach (@$zones as $keyElt => $zone) {
					echo  "Good: ".$zone["name"]." ".$zone["level"]."<br>" ;
						$nbelement++;
				}
			}

			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}

	

	// -------------------- Fonction pour le refactor Cities/zones
	public function actionRenameRegion(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			$regionName = array("Alsace-Champagne-Ardenne-Lorraine" => "Grand Est",
							"Nord-Pas-de-Calais-Picardie" => "Hauts-de-France",
							"Aquitaine-Limousin-Poitou-Charentes" => "Nouvelle-Aquitaine",
							"Languedoc-Roussillon-Midi-Pyrénées" => "Occitanie");
			
			foreach (@$regionName as $old => $new) {
				$zones = PHDB::find(Zone::COLLECTION, array("name" => $old));
				if(!empty($zones)){
					foreach (@$zones as $keyElt => $zone) {
						$res = PHDB::update( Zone::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
				                        array('$set' => array("name" => $new))
				        );
						echo  "Good: ".$zone["name"]." ".$zone["level"]."<br>" ;
							$nbelement++;
					}
				}

				$cities = PHDB::find(City::COLLECTION, array("regionName" => $old));
				if(!empty($cities)){
					foreach (@$cities as $keyElt => $city) {
						$res = PHDB::update( City::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
				                        array('$set' => array("regionName" => $new))
				        );
						echo  "Good: ".$city["name"]."<br>" ;
							$nbelement++;
					}
				}
			}

			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}



	// -------------------- Fonction pour le refactor Cities/zones
	public function actionLevelStringToArray(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			
			$zones = PHDB::find(Zone::COLLECTION, array());
			if(!empty($zones)){
				foreach (@$zones as $keyElt => $zone) {

					if(is_string($zone["level"])){
						$levels = array($zone["level"]);

						$res = PHDB::update( Zone::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
										array('$set' => array("level" => $levels))
						);

						echo  "Good: ".$zone["name"]."<br>" ;
							$nbelement++;
					}
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}


	public function actionCreateKeyZone(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			ini_set('max_execution_time', 300);
			$nbelement = 0 ;
			$erreur = array();
			$region = array();
			$zones = PHDB::find(Zone::COLLECTION, array("key" => array('$exists' => 0)) );

			if(!empty($zones)){
				foreach (@$zones as $keyElt => $zone) {
					//if($nbelement == 0){
						
						$key = Zone::createKey($zone);
						$res = PHDB::update( Zone::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
				                        array('$set' => array(	"key" => $key))
				        );
							
						echo  "Good: ".$zone["name"]." ".$zone["level"][0]." : ".$key."<br>" ;
						$nbelement++;
						
						
					//}
					
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}

	public function actionCreateKeyCity(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			ini_set('max_execution_time', 300);
			$nbelement = 0 ;
			$erreur = array();
			$region = array();
			$cities = PHDB::find(City::COLLECTION, 
				array( '$and' => array(
					array("dep" => array('$exists' => 1)),
					array("key" => array('$exists' => 0)))
				));

			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					if(!empty($city["dep"]) && strlen($city["dep"]) > 3){
						$zone=PHDB::findOne(Zone::COLLECTION, array("_id"=>new MongoId($city["dep"])));
						if(!empty($zone)){
							
							$key = $zone["key"]."@".$keyElt;
							$res = PHDB::update( City::COLLECTION, 
										  	array("_id"=>new MongoId($keyElt)),
					                        array('$set' => array(	"key" => $key))
					        );
								
							echo  "Good: ".$zone["name"]." ".$zone["level"][0]." : ".$key."<br>" ;
							$nbelement++;
							
							
						}
					}
					
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}


	public function actionAddLevel3ToLevel4(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			
			$zones = PHDB::find(Zone::COLLECTION, array('$and' => array(
															array("level" => "4" ),
															array("level3" =>  array('$exists' => 0)) )));
			if(!empty($zones)){
				foreach (@$zones as $keyElt => $zone) {
					$city=PHDB::findOne( City::COLLECTION, array( "dep"=> $keyElt ) );

					if(!empty($city["region"]) && !empty($city["regionName"])) {
						//$levels = array($zone["level"]);

						$res = PHDB::update( Zone::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
										array('$set' => array("level3" => $city["region"]))
						);

						echo  "Good: ".$zone["name"]." " .$city["regionName"] . " " .$city["region"] . "<br>" ;
							$nbelement++;
					}
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}


	public function actionOccitanie(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			
			$cities = PHDB::find(City::COLLECTION, array("depName" => "Phillippeville" ));
			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					$res = PHDB::update( City::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
										array('$set' => array("depName" => "Philippeville"))
						);

					echo  "Good: ".$city["name"]." " .$city["depName"] . " Philippeville <br>" ;
							$nbelement++;
					
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}

	public function actionAddIdDep(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			
			$cities = PHDB::find(City::COLLECTION, array("dep" => null ));
			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					$zone=PHDB::findOne( Zone::COLLECTION, array( "name"=>  $city["depName"]));

					if( !empty($zone)){
						$res = PHDB::update( City::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
										array('$set' => array("dep" => (String)$zone["_id"],
															"depName" => $zone["name"]))
						);

						echo  "Good: ".$city["name"]." " . $city["depName"] . "<br>" ;
							$nbelement++;
					}else{
						echo  "Error: ".$city["name"]." " . $city["depName"]. "<br>" ;
					}
					
					
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}

	public function actionAddIdRegion(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			
			$cities = PHDB::find(City::COLLECTION, array("region" => null ));
			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					$zone=PHDB::findOne( Zone::COLLECTION, array( "name"=>  $city["depName"]));

					if( !empty($zone)){
						$res = PHDB::update( City::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
										array('$set' => array("region" => (String)$zone["_id"],
															"regionName" => $zone["name"]))
						);

						echo  "Good: ".$city["name"]." " . $city["regionName"] . "<br>" ;
							$nbelement++;
					}else{
						echo  "Error: ".$city["name"]." " . $city["regionName"]. "<br>" ;
					}
					
					
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}

	public function actionReunion(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			
			$cities = PHDB::find(City::COLLECTION, array("depName" => "REUNION" ));
			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					
						$res = PHDB::update( City::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
										array('$set' => array(	"region" => "58be4af494ef47df1d0ddbcc",
																"regionName" => "Réunion",
																"dep" => "58be4af494ef47df1d0ddbcc",
																"depName" => "Réunion"))
						);

						echo  "Good: ".$city["name"]." " . $city["regionName"] . "<br>" ;
							$nbelement++;
					
					
					
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}

	public function actionBatchCities2(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			
			$cities = PHDB::find(City::COLLECTION, array("key" => array('$exists' => 1) ));

			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
						$set = array();
						$newInfos = City::detailKeysLevels($city["key"]);
						
						if(!empty($newInfos)){
							$set["level1"] = $newInfos["level1"];
							$zone = Zone::getById($newInfos["level1"],array("name"));
							$set["level1Name"] = $zone["name"];
						}

						$unset = array( "key" => "",
										"depName" => "",
										"regionName" => "",
										"regionNameBel" => "",
										"dep" => "",
										"region" => "",
										"regionBel" => "",
						);

						$res = PHDB::update( City::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
										array(	'$unset' => $unset,
	                    						'$set' => $set)
						);

						echo  "Good: ".$city["name"]." " . $keyElt . "<br>" ;
							$nbelement++;			
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}

	public function actionBatchTranslate(){
		ini_set('memory_limit', '-1');
		$nbelement = 0 ;
		
		$cities = PHDB::find(Zone::TRANSLATE, array("parentKey" => array('$exists' => 1) ));
		if(!empty($cities)){
			foreach (@$cities as $keyElt => $city) {
					$unset = array( "parentKey" => "");
					$res = PHDB::update( Zone::TRANSLATE, 
								  	array("_id"=>new MongoId($keyElt)),
									array('$unset' => $unset)
					);
					echo  "Good: ".$keyElt."<br>" ;
						$nbelement++;
			}
		}
		echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}

	public function actionBatchInterRemoveGeoShapeZone() {
		ini_set('memory_limit', '-1');
		$zones = PHDB::find(Zone::COLLECTION, array("geoShape" => array('$exists' => 1) ));
		$nbelement = 0 ;
		foreach ($zones as $key => $zone) {
			$res = PHDB::update( Zone::COLLECTION, 
								  	array("_id"=>new MongoId($key)),
									array('$unset' => array("geoShape" =>  ""))
					);
			$nbelement++;
						
		}
		echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}

	public function actionBatchInterCountry() {
		ini_set('memory_limit', '-1');
		$where = array(	"level" => "1");
		$zones = PHDB::find(Zone::COLLECTION, $where);
		$nbelement = 0 ;
		foreach ($zones as $key => $zone) {
			$city = PHDB::findOne(City::COLLECTION, array("country" => $zone["countryCode"]));

			if(!empty($city)){
				$res = PHDB::update( Zone::COLLECTION, 
								  	array("_id"=>new MongoId($key)),
									array('$set' => array("ownACity" =>  true))
					);
				$nbelement++;
			}			
		}
		echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}

	public function actionBatchZoneUnsetKey(){
		ini_set('memory_limit', '-1');
		$nbelement = 0 ;
		
		$cities = PHDB::find(Zone::COLLECTION, array("key" => array('$exists' => 1) ));
		if(!empty($cities)){
			foreach (@$cities as $keyElt => $city) {
					$unset = array( "key" => "");
					$res = PHDB::update( Zone::COLLECTION, 
								  	array("_id"=>new MongoId($keyElt)),
									array('$unset' => $unset)
					);
					echo  "Good: ".$keyElt."<br>" ;
						$nbelement++;
			}
		}
		echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}

	public function actionBatchTranslateTypeZone(){
		ini_set('memory_limit', '-1');
		$nbelement = 0 ;
		
		$zones = PHDB::find(Zone::COLLECTION, array("translateId" => array('$exists' => 1) ));
		if(!empty($zones)){
			foreach (@$zones as $keyElt => $zone) {
					$set = array( "parentType" => Zone::COLLECTION);
					$res = PHDB::update( Zone::TRANSLATE, 
								  	array("_id"=>new MongoId($zone["translateId"])),
									array('$set' => $set)
					);
					echo  "Good: ".$keyElt."<br>" ;
						$nbelement++;
			}
		}
		echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}


	public function actionBatchTranslateMissing(){
		ini_set('memory_limit', '-1');
		$nbelement = 0 ;
		
		$cities = PHDB::find(City::COLLECTION, array("translateId" => array('$exists' => 0) ));
		if(!empty($cities)){
			foreach (@$cities as $keyElt => $city) {
				Zone::insertTranslate(	( String ) $city["_id"], City::COLLECTION, $city["country"], $city["name"], 
										(!empty($city["osmID"]) ? $city["osmID"] : null ), 
										(!empty($city["wikidataID"]) ? $city["wikidataID"] : null ) ) ;
				$nbelement++;
			}	
		}
		echo  "NB City mis à jours: " .$nbelement."<br>" ;

		$nbelement = 0 ;
		
		$zones = PHDB::find(Zone::COLLECTION, array("translateId" => array('$exists' => 0) ));
		if(!empty($zones)){
			foreach (@$zones as $keyElt => $zone) {
				Zone::insertTranslate(	( String ) $zone["_id"], Zone::COLLECTION, $zone["countryCode"], $zone["name"], 
										(!empty($zone["osmID"]) ? $zone["osmID"] : null ), 
										(!empty($zone["wikidataID"]) ? $zone["wikidataID"] : null ) ) ;
				$nbelement++;
			}
		}
		echo  "NB Zones mis à jours: " .$nbelement."<br>" ;
	}

	public function actionBatchInterElementCorrection() {
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$nbelement = 0 ;
			$types = array(Person::COLLECTION , Organization::COLLECTION, Project::COLLECTION, 
							Event::COLLECTION, Poi::COLLECTION);

			foreach ($types as $keyType => $type) {
				$elts = PHDB::find($type, array('$and' => array(
									array("address" => array('$exists' => 1)),
									array("address.localityId" => array('$exists' => 1)),
									array("address.level1" => array('$exists' => 0))
						)));

				foreach ($elts as $key => $elt) {
					$newAddress = $elt["address"];
					unset($newAddress["localityId"]);
					$res = PHDB::update($type, 
							array("_id"=>new MongoId($key)),
							array('$set' => array("address" => $newAddress))
					);
					$nbelement++;
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
			
		//}
	}

	public function actionBatchInterElement() {
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$nbelement = 0 ;
			$types = array(Person::COLLECTION , Organization::COLLECTION, Project::COLLECTION, 
							Event::COLLECTION, Poi::COLLECTION);

			foreach ($types as $keyType => $type) {
				$elts = PHDB::find($type, array('$and' => array(
									array("address" => array('$exists' => 1)),
									array("address.localityId" => array('$exists' => 0))
						)));

				foreach ($elts as $key => $elt) {
					if(!empty($elt["address"]["codeInsee"]) || !empty($elt["address"]["postalCode"])){

						if( !empty($elt["address"]["codeInsee"]) )
							$city = PHDB::findOne(City::COLLECTION, array("insee" => $elt["address"]["codeInsee"]));
						else
							$city = PHDB::findOne(City::COLLECTION, array("postalCodes.postalCode" => $elt["address"]["postalCode"]));
						//var_dump($city);
						if(!empty($city)){
							$newAddress = $elt["address"];

							if(empty($elt["address"]["codeInsee"])){
								$newAddress["codeInsee"] = $city["insee"];
								$newAddress["addressCountry"] = $city["country"];
								$newAddress["streetAddress"] = "";
								if(!empty($city["postalCodes"]))
									foreach ($city["postalCodes"] as $keycp => $valuecp) {
										if($valuecp["postalCode"] == $elt["address"]["postalCode"])
											$newAddress["addressLocality"] = $valuecp["name"];
									}

								if(!empty($newAddress["addressLocality"]))
									$newAddress["addressLocality"] = $city["name"];
							}

							if(!empty($city["level1"])){
								$newAddress["level1"] = $city["level1"];
								$newAddress["level1Name"] = $city["level1Name"];
							}

							if(!empty($city["level2"])){
								$newAddress["level2"] = $city["level2"];
								$newAddress["level2Name"] = $city["level2Name"];
							}

							if(!empty($city["level3"])){
								$newAddress["level3"] = $city["level3"];
								$newAddress["level3Name"] = @$city["level3Name"];
							}

							if(!empty($city["level4"])){
								$newAddress["level4"] = $city["level4"];
								$newAddress["level4Name"] = @$city["level4Name"];
							}

							$newAddress["localityId"] = (String)$city["_id"];
							unset($newAddress["key"]);
							unset($newAddress["depName"]);
							unset($newAddress["regionName"]);
							unset($newAddress["regionNameBel"]);

							$set = array("address" => $newAddress);

							if(!empty($elt["addresses"])){
								$newAdd = array();
								foreach ($elt["addresses"] as $keyAddresses => $address) {

									if(!empty($address["address"]["codeInsee"])){
										$cityAdd = PHDB::findOne(City::COLLECTION, array("insee" => $address["address"]["codeInsee"]));
										if(!empty($city)){
											if(!empty($cityAdd["level1"])){
												$address["address"]["level1"] = $cityAdd["level1"];
												$address["address"]["level1Name"] = $cityAdd["level1Name"];
											}

											if(!empty($cityAdd["level2"])){
												$address["address"]["level2"] = $cityAdd["level2"];
												$address["address"]["level2Name"] = $cityAdd["level2Name"];
											}

											if(!empty($cityAdd["level3"])){
												$address["address"]["level3"] = $cityAdd["level3"];
												$address["address"]["level3Name"] = $cityAdd["level3Name"];
											}

											if(!empty($cityAdd["level4"])){
												$address["address"]["level4"] = $cityAdd["level4"];
												$address["address"]["level4Name"] = $cityAdd["level4Name"];
											}
											$address["localityId"] = (String)$cityAdd["_id"];
											unset($address["key"]);
											unset($address["depName"]);
											unset($address["regionName"]);
											unset($address["regionNameBel"]);
											$newAdd[] = $address;
										}else{
											echo  "Error addresses: ".$elt["name"]." " . $type. " " . $key. "<br>" ;
										}

									}else{
										echo  "Error Insee: ".$elt["name"]." " . $type. " " . $key. "<br>" ;
									}
									
								}
								if(!empty($newAdd))
									$set["addresses"] = $newAdd;
							}
							if(!empty($newAddress['localityId'])){
								$res = PHDB::update($type, 
										array("_id"=>new MongoId($key)),
										array('$set' => $set)
								);
							}
							$nbelement++;
						}
					}else{
						$res = PHDB::update($type, 
									array("_id"=>new MongoId($key)),
									array('$unset' => array("address" => ""))
							);
						$nbelement++;
					}					
				}
			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
			
		//}
	}


	public function actionBatchInterMultiScope() {

		$elts = PHDB::find(Person::COLLECTION, array('$and' => array(
									array("multiscopes" => array('$exists' => 1)))
						));
		$nbelement = 0 ;
		if(!empty($elts)){
			foreach ($elts as $key => $value) {
				$res = PHDB::update(Person::COLLECTION, 
						array("_id"=>new MongoId($key)),
						array(	'$unset' 	=> array(	"multiscopes" => null),
	                			'$set' 		=> array(	"inter" => true) ) );
				$nbelement++;
			}
		}
		
		echo  "NB Element mis à jours: " .$nbelement."<br>" ;			
					
	}


	public function actionBatchInterNews() {
		ini_set('memory_limit', '-1');
		//$news = PHDB::find(News::COLLECTION, array("scope" => array('$exists' => 1)));

		$news = PHDB::find(News::COLLECTION, array('$and' => array(
									array("scope" => array('$exists' => 1)),
									array("scope.localities" => array('$exists' => 0)))
						));


		$nbelement = 0 ;
		foreach ($news as $key => $new) {
			if(!empty($new["scope"])){
				
				$listKey = array();

				if(!empty($new["scope"]["cities"])){

					foreach ($new["scope"]["cities"] as $keyS => $valueS) {
						$newsKey = array();

						if(!empty($valueS["codeInsee"])){
							$city = PHDB::findOne(City::COLLECTION, array("insee" => $valueS["codeInsee"]));
							if(!empty($city)){
								$newsKey["parentId"] = (String) $city["_id"] ;
								$newsKey["parentType"] = City::COLLECTION ;

								if(!empty($valueS["postalCode"])){
									$newsKey["postalCode"] = $valueS["postalCode"];
								}else{
									$newsKey["name"] = $valueS["addressLocality"];
								}

								if(!empty($valueS["geo"]))
									$newsKey["geo"] = $valueS["geo"];

								$newsKey = array_merge($newsKey, Zone::getLevelIdById((String) $city["_id"], $city, City::COLLECTION) ) ;
							}
						}

						if(!empty($newsKey))
							$listKey[] = $newsKey;
					}
				}

				if(!empty($new["scope"]["departements"])){

					foreach ($new["scope"]["departements"] as $keyS => $valueS) {

						$renameDep = array(	"REUNION" => "Réunion",
											"Phillippeville" => "Philippeville" );

						$nameD = (!empty($renameDep[$valueS["name"]])? $renameDep[$valueS["name"]] : $valueS["name"] ) ;

						$zone = PHDB::findOne(Zone::COLLECTION, array("name" => $nameD));
						$newsKey = array();
						if(!empty($zone)){
							$newsKey["name"] = $zone["name"];
							$newsKey["parentId"] = (String) $zone["_id"] ;
							$newsKey["parentType"] = Zone::COLLECTION ;
							if(!empty($zone["geo"]))
									$newsKey["geo"] = $zone["geo"];
							$newsKey = array_merge($newsKey, Zone::getLevelIdById((String) $zone["_id"], $zone, Zone::COLLECTION) ) ;
							$listKey[] = $newsKey;
						}
					}
				}

				if(!empty($new["scope"]["regions"])){

					foreach ($new["scope"]["regions"] as $keyS => $valueS) {

						$renameRegion = array(	"Alsace-Champagne-Ardenne-Lorraine" => "Grand Est",
												'Nord-Pas-de-Calais-Picardie' => "Hauts-de-France",
												"Aquitaine-Limousin-Poitou-Charentes" => "Nouvelle-Aquitaine",
												"Languedoc-Roussillon-Midi-Pyrénées" => "Occitanie",
												"La Réunion" => "Réunion" );

						$nameR = (!empty($renameRegion[$valueS["name"]])? $renameRegion[$valueS["name"]] : $valueS["name"] ) ;

						$zone = PHDB::findOne(Zone::COLLECTION, array("name" => $nameR));
						$newsKey = array();
						if(!empty($zone)){
							$newsKey["parentId"] = (String) $zone["_id"] ;
							$newsKey["parentType"] = Zone::COLLECTION ;
							$newsKey["name"] = $zone["name"];
							if(!empty($zone["geo"]))
									$newsKey["geo"] = $zone["geo"];
							$newsKey = array_merge($newsKey, Zone::getLevelIdById((String) $zone["_id"], $zone, Zone::COLLECTION) ) ;
							$listKey[] = $newsKey;
						}
					}
				}
				$newscope = array("type" => $new["scope"]["type"], "localities" => $listKey);
				$set = array("scope" => $newscope);
				$res = PHDB::update(News::COLLECTION, 
						array("_id"=>new MongoId($key)),
						array('$set' => $set)
				);
				$nbelement++;
			}else{
				echo  "Error: ". $key. "<br>" ;
			}
		}

		echo  "NB Element mis à jours: " .$nbelement."<br>" ;
	}



	public function actionBatchInterInit() {
		ini_set('memory_limit', '-1');
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$nbelement = 0 ;
			$types = array(Person::COLLECTION , Organization::COLLECTION, Project::COLLECTION, Event::COLLECTION, Poi::COLLECTION);

			foreach ($types as $keyType => $type) {
				$elts = PHDB::find($type, array('$and' => array(
												array("address" => array('$exists' => 1)),
												array("address.addressCountry" => 
														array('$nin' => array("PM", "MQ", "YT", "GP", "GF", "RE", "FR", "NC", "BE") ) )
						) ) );

				foreach ($elts as $key => $elt) {
					if(!empty($elt["address"]["codeInsee"])){
						
							$unset = array("address" => "");
							if(!empty($elt["addresses"]))
								$unset["addresses"] = "";
							if(!empty($elt["multiscopes"]))
								$unset["multiscopes"] = "";	
							
							// $res = PHDB::update($type, 
							// 		array("_id"=>new MongoId($key)),
							// 		array('$unset' => $unset)
							// );
							$nbelement++;
					}else{
						echo  "Error: ".$elt["name"]." " . $type. " " . $key. "<br>" ;
					}
					
				}
			}

			echo  "NB Element mis à jours: " .$nbelement."<br>" ;

			$zones = PHDB::find(Zone::COLLECTION, array("countryCode" => 
															array('$nin' => 
																	array("PM", "MQ", "YT", "GP", "GF", "RE", "FR", "NC", "BE"))));
			$nbelement = 0 ;
			$nbelementNew = 0 ;
			foreach ($zones as $key => $value) {
				$news = PHDB::find(News::COLLECTION, array('$and' => array(
													array("scope.localities" => array('$exists' => 1)),
													array("scope.localities.parentId" => $key))));


				foreach ($news as $keyNew => $valueNew) {
					// $res = PHDB::update(News::COLLECTION, 
					// 				array("_id"=>new MongoId($keyNew)),
					// 				array('$set' => array("scope.localities" => array() ) )

					// 		);
					$nbelementNew++;

				}
				echo  "Good: zone " . $key. "<br>" ;
				//PHDB::remove(Zone::COLLECTION, array("_id"=>new MongoId($key)));
				$nbelement++;
			}

			echo  "NB Zone mis à jours: " .$nbelement."<br>" ;
			$cities = PHDB::find(City::COLLECTION, array("country" => array('$nin' => array("PM", "MQ", "YT", "GP", "GF", "RE", "FR", "NC", "BE"))));

			$nbelement = 0 ;
			foreach ($cities as $key => $value) {
				$news = PHDB::find(News::COLLECTION, array('$and' => array(
													array("scope.localities" => array('$exists' => 1)),
													array("scope.localities.parentId" => $key))));


				foreach ($news as $keyNew => $valueNew) {
					// $res = PHDB::update(News::COLLECTION, 
					// 				array("_id"=>new MongoId($keyNew)),
					// 				array('$set' => array("scope.localities" => array()))
					// 		);
					$nbelementNew++;
				}
				echo  "Good: cities " . $key. "<br>" ;
				//PHDB::remove(City::COLLECTION, array("_id"=>new MongoId($key)));
				$nbelement++;
			}

			echo  "NB City mis à jours: " .$nbelement."<br>" ;
			
			echo  "NB New mis à jours: " .$nbelementNew."<br>" ;
		//}
	}




	public function actionLevel234(){
		//if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			$nbelement = 0 ;
			
			$cities = PHDB::find(City::COLLECTION, array('$or' => array(
														array('level2' => array('$exists' => 0)),
														array('level3' => array('$exists' => 0)),
														array('level4' => array('$exists' => 0))
												)));
			//$cities = PHDB::find(City::COLLECTION, array('level3' => array('exists' => 0)));
			//var_dump($cities);
			if(!empty($cities)){
				foreach (@$cities as $keyElt => $city) {
					$set = array();
					if(empty($city["level2"]) && !empty($city["regionBel"])){
						$set["level2"] = $city["regionBel"];
						if(!empty($city["regionNameBel"]))
							$set["level2Name"] = $city["regionNameBel"];
					}

					if(empty($city["level3"]) && !empty($city["region"])){
						$set["level3"] = $city["region"];

						if(!empty($city["regionName"]))
							$set["level3Name"] = $city["regionName"];
					}

					if(empty($city["level4"]) && !empty($city["dep"])){
						$set["level4"] = $city["dep"];
						if(!empty($city["depName"]))
							$set["level4Name"] = $city["depName"];
					}

					if(!empty($set)){
						$res = PHDB::update( City::COLLECTION, 
									  	array("_id"=>new MongoId($keyElt)),
										array('$set' => $set)
						);

						echo  "Good: ".$city["name"]." <br>" ;
						$nbelement++;
					}
				}
			}else{
				echo  "Error" ;

			}
			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		//}
	}


	public function actionNamePays(){
		ini_set('memory_limit', '-1');
		$nbelement = 0 ;
		
		$zones = PHDB::find(City::COLLECTION, array('$and' => array(
													array('translateId' => array('$exists' => 0)),
													array('$or' => array(
														array('osmID' => array('$exists' => 1)),
														array('wikidataID' => array('$exists' => 1)))))));
		// $zones = PHDB::find(Zone::COLLECTION, array('$and' => array(
		// 											array('translateId' => array('$exists' => 0)),
		// 											array('$or' => array(
		// 												array('osmID' => array('$exists' => 1)),
		// 												array('wikidataID' => array('$exists' => 1)))))));
		
		if(!empty($zones)){

			foreach ($zones as $key => $zone) {
				
				$translate = array();
				$info = array();
				if(!empty($zone["osmID"])){
					$zoneNominatim =  json_decode(file_get_contents("http://nominatim.openstreetmap.org/lookup?format=json&namedetails=1&osm_ids=R".$zone["osmID"]), true);
				
					if(!empty($zoneNominatim) && !empty($zoneNominatim[0]["namedetails"])){
						
						
						foreach ($zoneNominatim[0]["namedetails"] as $keyName => $valueName) {
							$arrayName = explode(":", $keyName);
							if(!empty($arrayName[1]) && $arrayName[0] == "name" && strlen($arrayName[1]) == 2){
								$translate[strtoupper($arrayName[1])] = $valueName;
							}
						}
					}
				}

				if(!empty($zone["wikidataID"])){

					$zoneWiki =  json_decode(file_get_contents("https://www.wikidata.org/wiki/Special:EntityData/".$zone["wikidataID"].".json"), true);
					
					if(!empty($zoneWiki) && !empty($zoneWiki["entities"][$zone["wikidataID"]]["labels"])){
						foreach ($zoneWiki["entities"][$zone["wikidataID"]]["labels"] as $keyName => $valueName) {
							
							if(strlen($keyName) == 2){
								$translate[strtoupper($keyName)] = $valueName["value"];
							}
						}
					}
				}

				if(!empty($translate)){
					$info["countryCode"] = $zone["country"];
					//$info["countryCode"] = $zone["countryCode"];
					$info["parentId"] = $key;
					$info["parentType"] = City::COLLECTION;
					//$info["parentType"] = Zone::COLLECTION;
					$info["parentKey"] = $zone["key"];
					$info["translates"] = $translate;
					PHDB::insert("translates", $info);
					PHDB::update(City::COLLECTION, 
								array("_id"=>new MongoId($key)),
								array('$set' => array("translateId" => (string)$info["_id"]))
					);

					$nbelement++;
				}else {
					echo  "Error ".$zone["name"]." ".$key." <br/>" ;
				}
			}

			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}

	public function actionRemoveTrans(){
		ini_set('memory_limit', '-1');
		$nbelement = 0 ;
		
		//$zones = PHDB::find(City::COLLECTION, array('translateId' => array('$exists' => 0)));
		$zones = PHDB::find(Zone::COLLECTION, array('translateId' => array('$exists' => 1)));
		
		if(!empty($zones)){

			foreach ($zones as $key => $zone) {
				
					PHDB::update(Zone::COLLECTION, 
								array("_id"=>new MongoId($key)),
								array('$unset' => array("translateId" => ""))
					);

					$nbelement++;
				
			}

			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}


	public function actionRefactorTranslate(){
		ini_set('memory_limit', '-1');
		$nbelement = 0 ;
		
		$translates = PHDB::find(Zone::TRANSLATE, array('origin' => array('$exists' => 0)));
		
		if(!empty($translates)){

			foreach ($translates as $key => $translate) {

				$countries = array("MQ", "YT", "GP", "GF", "RE", "NC");
				
				if( in_array($translate["countryCode"], $countries))
					$origin = $translate["translates"]["FR"] ;
				else if (!empty($translate["translates"][$translate["countryCode"]]))
					$origin = $translate["translates"][$translate["countryCode"]] ;
				else if (!empty($translate["translates"]["EN"]))
					$origin = $translate["translates"]["EN"] ;
				else if (!empty($translate["translates"]["FR"]))
					$origin = $translate["translates"]["FR"] ;

				if(!empty($origin)){
					$newsT = array();
					foreach ($translate["translates"] as $keyT => $valueT) {
						if($valueT != $origin)
							$newsT[$keyT] = $valueT;
					}

					PHDB::update(Zone::TRANSLATE, 
								array("_id"=>new MongoId($key)),
								array('$set' => array(	"origin" => $origin,
														"translates" => $newsT))
					);

					$nbelement++;
				}
				
				//break;
			}

			echo  "NB Element mis à jours: " .$nbelement."<br>" ;
		}
	}


	public function actionRefactorCountries(){
		ini_set('memory_limit', '-1');
		$nbelementUpdate = 0 ;
		$nbelementCreate= 0 ;
		$nbelementError = 0 ;
		$countries = json_decode(file_get_contents("../../modules/co2/data/countries.json", FILE_USE_INCLUDE_PATH), true );
		//var_dump($countries);
		foreach ($countries as $key => $value) {
			//var_dump(json_encode($value));
			//echo json_encode($value);

			$zone = PHDB::findOne(Zone::COLLECTION, array('$and' => array(
														array('countryCode' => $value["cca2"]),
														array('level' => "1") ) ) );

			if(!empty($zone)){
				// $set = array();
				// if(!empty($value["cca3"]))
				// 	$set["cca3"] = $value["cca3"];
				// if(!empty($value["callingCode"]))
				// 	$set["callingCode"] = $value["callingCode"];

				// if(!empty($set)){
				// 	PHDB::update(Zone::TRANSLATE, 
				// 					array("_id"=>new MongoId((String) $zone["_id"])),
				// 					array('$set' => $set)
				// 		);
				// 	$nbelementUpdate++;
				// }

			} else {
				echo  "todo: " .$value["cca2"]." : ".$value["name"]["common"]."<br>" ;
				// $level1 = Zone::createLevel($value["name"]["common"], $value["cca2"], "1");

				// if(!empty($level1)){
				// 	if(!empty($value["cca3"]))
				// 	$level1["cca3"] = $value["cca3"];
				// 	if(!empty($value["callingCode"]))
				// 		$level1["callingCode"] = $value["callingCode"];
				// 	//echo json_encode($level1 );
				// 	$savelevel1 = Zone::save($level1);
		  //   		if($savelevel1["result"] == true)
		  //   			$nbelementCreate++;
		  //   		else{
		  //   			$nbelementError++;
		  //   			echo  "Error1: " .$value["cca2"]."<br>" ;
		  //   		}
				// }else{
				// 	$nbelementError++;
		  //    			echo  "Error2: " .$value["cca2"]."<br>" ;
				// }
				
			}

			//break;
		}

		echo  "NB Element mis à jours: " .$nbelementUpdate."<br>" ;
		echo  "NB Element created: " .$nbelementCreate."<br>" ;
		echo  "NB Element error: " .$nbelementError."<br>" ;

	}

	// -------------------- Fin des foncction pour le refactor Cities/zones
		// -------------------- Slugify everything
	public function actionSlugifyCitoyens(){
		ini_set('memory_limit', '-1');
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$slugExist=array();
			$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
			//foreach($typeEl as $type){
				
				$res=PHDB::find(Person::COLLECTION);
				echo "//////////".count($res)." Citoyens/////////////////<br>";
				$count=0;
				$del=0;
				foreach ($res as $key => $value) {
					if((@$value["username"] && !empty($value["username"])) || (@$value["name"] && !empty($value["name"]))){
						// replace non letter or digits by -
						if(@$value["username"]){
							$string=$value["username"];
							$createUsername=false;
						}else{
							$string=$value["name"];
							$createUsername=true;
						}
						$str="";
						$value=explode(" ",$string);
						$i=0;
						foreach($value as $v){
							$text = strtr( $v, $unwanted_array );
							//$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
			  				$text = preg_replace('~[^\\pL\d]+~u', '', $text);

				  			// trim
				  			$text = trim($text, '-');

				 			// transliterate
				  			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

				  			// lowercase
				  			$text = strtolower($text);
				  			if($i>0)
				  				$text = ucfirst($text);

				  			// remove unwanted characters
				  			$text = preg_replace('~[^-\w]+~', '', $text);
				  			$str.=$text;
				  			$i++;
			  			}	
			  			if(in_array($str, $slugExist)){
			 				$v = 1; // $i est un nombre que l'on incrémentera. 
			 				$inc=true;
							while($inc==true) 
							{ 
							  	$inc=in_array($str.$v, $slugExist);
							  	//echo $inc;
								if(!$inc)
									$str=$str.$v;
								else
							  		$v ++ ;
							}
						}
						if(@$createUsername && $createUsername==true){
							echo "doooooooit entry username////";
							PHDB::update(
							Person::COLLECTION,
							array("_id"=>new MongoId($key)),
							array('$set'=>array("username"=>$str)));
						}
						array_push($slugExist, $str);
						echo  $str."<br>";
						//INSERT IN SLUG COLLECTION
						PHDB::insert(Slug::COLLECTION,array("name"=>$str,"id"=>$key,"type"=>Person::COLLECTION));
						//INSERT SLUG ENTRY IN ELEMENT
						PHDB::update(
							Person::COLLECTION,
							array("_id"=>new MongoId($key)),
							array('$set'=>array("slug"=>$str)));
						$count++;
					} else {
						PHDB::remove(
							Person::COLLECTION,
							array("_id"=>new MongoId($key)));
						$del++;
					}
		 		}
		 		echo "/////////////".$count." citoyens traités (comme des sauvages)//////////<br>";
		 		echo "/////////////".$del." citoyens zigouillés, lapidés, déchiquetés, oubliés, mis au bucher //////////<br>";
		}else 
			echo "Bois du rebBull t'auras des ailles";
	}
	public function actionSlugifyElement(){
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			ini_set('memory_limit', '-1');
			ini_set('max_execution_time', 300);
			$slugcitoyens=PHDB::find(Slug::COLLECTION);
			$typeEl=array("organizations","projects","events");
			$slugExist=array();
			foreach($slugcitoyens as $data){
				array_push($slugExist,$data["name"]);
			}
			$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
			foreach($typeEl as $type){
				
				$res=PHDB::find($type);
				echo "//////////".count($res)." ".$type."/////////////////<br>";
				$count=0;
				foreach ($res as $key => $value) {
					if(@$value["name"] && !empty($value["name"])){
						// replace non letter or digits by -
						$str="";
						if(strlen($value["name"])>50)
							substr($value["name"],50);
						
						$value=explode(" ",$value["name"]);
						$i=0;
						foreach($value as $v){
							$text = strtr( $v, $unwanted_array );
							//$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
			  				$text = preg_replace('~[^\\pL\d]+~u', '', $text);

				  			// trim
				  			$text = trim($text, '-');

				 			// transliterate
				  			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

				  			// lowercase
				  			$text = strtolower($text);
				  			if($i>0)
				  				$text = ucfirst($text);

				  			// remove unwanted characters
				  			$text = preg_replace('~[^-\w]+~', '', $text);
				  			$str.=$text;
				  			$i++;
			  			}	
			  			if(in_array($str, $slugExist)){
			 			//if(!Slug::check(array("slug"=>$str,"type"=>Organization::COLLECTION,"id"=>$key))){
			 				$v = 1; // $i est un nombre que l'on incrémentera. 
			 				$inc=true;
			 				//echo "ouuuuuuuuuiiii";
							while($inc==true) 
							{ 
								//$inc=Slug::check(array("slug"=>$str.$i,"type"=>Organization::COLLECTION,"id"=>$key));
							  	//echo $i . "<br />";
							  	$inc=in_array($str.$v, $slugExist);
							  	//echo $inc;
							  	echo "ca bloque la ".$str.$v;
								if(!$inc)
									$str=$str.$v;
								else
							  		$v ++ ;
							}
						}
						array_push($slugExist, $str);
						echo  $key."////".$type."/////".$str."<br>";
						//INSERT IN SLUG COLLECTION
						PHDB::insert(Slug::COLLECTION,array("name"=>$str,"id"=>$key,"type"=>$type));
						//INSERT SLUG ENTRY IN ELEMENT
						PHDB::update(
							$type,
							array("_id"=>new MongoId($key)),
							array('$set'=>array("slug"=>$str)));
						$count++;
					}
		 		}
		 		echo "////////////////".$count." ".$type." traités (comme des animaux) ///////";
			}
		}else 
			echo "Tout le monde t'as vu !! reste bien tranquille";
	}
	public function actionRelaunchInvitation(){
		ini_set('memory_limit', '-1');
		if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){		
			$res=PHDB::find(Person::COLLECTION,array("pending"=>array('$exists'=>true)));
			$i=0;
			$v=0;
			foreach($res as $key => $value){
				if(DataValidator::email($value["email"])==""){
					Mail::relaunchInvitePerson($value);
					$i++;
				}else{
					$v++;
				}
			}
			echo $i." mails envoyé pour relancer l'inscription<br>";
			echo $v." utilisateur non inscrit (validé) qui ont un mail de marde<br>";
		}else 
			echo "Pas d'envoie pour toi ma cocote !! Tu vas aller au four plutot";
	}
}

