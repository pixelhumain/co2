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

            
# Architecture et Templates

## Layout 
le décor est poser par le ph/themes/CO2 
- views/layouts/mainSearch.php			
    + body > div.mainMap : mapEnd
	+ body > div.main-container : front End
```
        +-------------------------------------------------+
        |                                                 
        |              layouts/menu/CO2.php <nav #mainNav
        +------------------------------------------------->
        |                                                 
        |              layouts/header/CO2.php <header.main-menu-app             
        +------------------------------------------------->
        |                                                 
        |              layouts/header/CO2.php <header.container
        +------------------------------------------------->
        |              div #content-social .pageContent         				
        |                                                 
        |                                                 
        |                                                 
        |                                                 
        |                                                 
        |                                                 
        |                                                 
        |                                                 
        |                                                 
        +-------------------------------------------------+
```
*hidden* 
- layouts/notifications.php
	+ div.notificationPanelSearch
- layouts/formCreateElement.php
	+ div.ajax-modal
- div #floopDrawerDirectory .floopDrawer
- layouts/modals/CO2/mainMenu.php
	+div #openModal 
	+ div #modalMainMenu
	+ div #rocketchatModal
- scopes/CO2/multi_scope