# Architecture et Templates

## Layout 
le décor est poser par le ph/themes/CO2 
- le point d'entrée est views/layouts/mainSearch.php
- header/CO2.php <header> :: contient le menu 
- menu/CO2.php <nav id="mainNav" >
- scopes/CO2/multi_scope

## Element Detail Page Architecture and Process
- left Menu : menuLeftElement.php
    + build with if conditions
    + ex : POI 
        * exec displayInTheContainer
            * http://127.0.0.1/ph/co2/element/getdatadetail/type/place/id/58d7e06e539f221b3d09bba7/dataName/poi?tpl=json 
            * GetDataDetailAction
        * then builds the correspondign directory.js 

            