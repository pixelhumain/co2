# Découpage module


## Fichier 

### protected/config/overwrite.php

```
$overwriteList = array(
        "modules" => array("terla"),
);
```

Listes des modules dont il y a des fichiers a surcharger


### modules/nomModule/config/overwrite.php

toutes les informations concernant la surcharge des fichiers
```
$overWrite = array(
        "name" => "nomModule",
        "assets" => array(
                'js/directory.js',),
        "views" => array(
                "directoryjs" => "default/directoryjs"),
    );
```

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