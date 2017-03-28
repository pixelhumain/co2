# Thing
Au delà des Smart-Citizen-Kit, thing pourrrait permettre d'intégrer les objets connecté à CO2.

Un point d'entrée est disponible à coté du bouton "actus", il est nommé "Objet connectés" (on peut renommer en IoT ou Objets Connectés), l'icone est un database.

## Smart-Citizen-Kit
La view index permet d'accéder 
	* à deux vue différentre : 
		* Les graphes (encore du developpement à finir)
		* Les dernières valeurs enregistrés
	* à une page de gestion (travaux en cours):
		* première fonctionnalité de la page ajouter l'adresse mac correspondant au device (en cours de finalisation)

### Double push 

Le kit pourrait être utilisé exclusivement avec Communecter, un serveur de temps pour sck est ajouter dans l'API, la reception simple fonctionne déjà, et la réception batch (plusieurs enregistrements en même temps) est en cours de développement. Ces fonctionnalités peuvent permettre une redondance, si on développe tous les fonctions nécessaire. 

#### Firmware 
Le firmware sck double push a été développé par Nicolas Grondin en s'inspirant des débuts de travaux de Jean Daniel CAZAL (Stagiaire). 
Nicolas Grondin a par la suite amélioré la gestion de la FIFO (écriture et lectur en EEPROM) et la stabilité du firmware. 
Avec le double push nous devons choisir une période d'envoi des enregistrements adéquat pour ne pas surcharger la base de données, pour l'instant ce "time update" est de 5 minutes (300 secondes). 

#### Coté serveur
Un outil datetime dans l'API de communecter, permet de fournir l'heure au SCK.
Pour les enregistrements on passe par element/save, avec un traitement grace au fonction dans le model thing. 


### Graphe (#thing.graph)

Les données sont récupérer via l'API de Smartcitizen (api.smartcitizen.me/v0), la version de l'api est succeptible de changer, il faudra alors changer la constante Thing::URL_API_SC. 
Les devices possèdent 9 sensors, pour obtenir les enregistrements (Température, Humidité, CO, NO2, Lumière, Bruit, Nombre de réseaux WLAN environnant, Batterie, et Panneau Photo-Voltaïque).
Le nombre de réseaux WIFI environnant n'est pas utilisé. 

#### Les requetes sur l'API

Il faut faire une requete par sensor avec un rollup (temps séparant 2 enregistrement), une date de début et une date de fin.
La date de fin est l'heure actuelle en GMT.
La date de début est calculer, si le paramètre nbDays est utilisé dans la requète pour afficher la page graphe (par exemple : #thing.graphe?nbDays=20 , il y a une limite à 31 jours), sinon c'est un graphe sur une journée. C'est une fonctionnalité de substitution aux datepickers.  


La page graphe utilise D3.js pour construire les graphes. Chaque sensor a son SVG dédié, si plusieurs devices sont dans la même zone, les données sont afficher sur le mème graphe. Pour l'instant la zone c'est même code postale et même country, on devra faire un filtrage par niveau par la suite (Région département).

#### Bouton de selection de graphe
Tous les graphes sont construit une seul fois au chargement de la page. Les boutons cache les graphes et montre ceux qui sont selectionnés, le dernier bouton affiche tous les graphes.

#### Légende
La légende permet d'être redirigé vers le device sur site officiel des SCK : smartcitizen.me/kits/[deviceId]


### Page des dernières valeur enregistré 
Affiche les dernièrs enregistrement du SCK.

Fonctionnalité qui pourra permettre d'ajouter valeurs dans des POD.


### Page de gestion (#thing.manage)

Cette page à pour but de faire la liaison entre les enregistrements reçu dans notre base, et le device qui les envois. En effet, les devices n'ont pas connaissance de leur deviceId. Sur smartcitizen, cette liaison est faite lors de l'enregistrement du kit sur la plateforme.
Nous avons besoin de la même liaison dans notre base de données, celà permet au utilisateurs ou nous même (si on limite l'accès au administrateurs) de renseigné l'adresse mac du kit. 


### Base de données 

[Une estimation de la capacité nécessaire](https://docs.google.com/spreadsheets/d/1E5_lm-dEw28Vq176nwduC9KgFOfZzYbgjU2mWfJxYRo/edit?usp=sharing)

