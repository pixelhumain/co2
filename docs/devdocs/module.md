# Découpage module

##Description 
Un fichier ` config/overwrite.php ` va être mis dans chaque nouveau module. Ce fichier contiendra l'ensemble des vues, js et css qui surchargeront ceux de Communecter.

## Comment faire ?

1) Crée un nouveau module sur github pixelhumain/newmod
2) Crée les fichiers suivants (voir dans la partie fichier pour les details)
    - NewmodModule.php
    - config/overwrite.php
3) Ajouter dans pixelhumain/ph/protected/config/overwrite.php le nouveau module dans la liste 


## Fichier 

### modules/nomModule/config/overwrite.php

toutes les informations concernant la surcharge des fichiers
```
$overWrite = array(
        "name" => "newmod",
        "assets" => array(
                'js/example.js',),
        "views" => array(
                "example" => "default/example"),
    );
```


### NewmodModule.php

```
class NewmodModule extends CWebModule {

    public function init(){}

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
    private $_assetsUrl;

    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias($this->id.'.assets') );
        return $this->_assetsUrl;
    }
}

```

### protected/config/overwrite.php

```
$overwriteList = array(
        "modules" => array("terla"),
);
```

Listes des modules dont il y a des fichiers a surcharger

### protected/config/paramsconfig.php

Ajout du code qui permet de charger le overwrite d'un module
```
if( !empty($overwriteList) && in_array($params["theme"], $overwriteList["modules"])){
    $pathOverwrite = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR.$params["theme"]. '/config/overwrite.php';
    require_once($pathOverwrite);
    $params["overWrite"] = $overWrite;
}
```

### HTMLHelper.php

```
if( !empty($overwriteList) && in_array($params["theme"], $overwriteList["modules"])){
    $pathOverwrite = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR.$params["theme"]. '/config/overwrite.php';
    require_once($pathOverwrite);
    $params["overWrite"] = $overWrite;
}
```


