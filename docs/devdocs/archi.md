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