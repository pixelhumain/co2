# Internationnalisation / refactor cities/Zone

## Lien utile

* https://docs.google.com/document/d/12bO0BGOy-YBboe2AXSTwJen7iNp6y4EGDa3fRkfoUk4/edit#heading=h.gqj7abdamv9q

## Road Map

    [ ] Création des zones administrative supèrieur à 5 (Commune)
        [X] Niveau 1 ( Pays et DOMTOM) 
        [X] Niveau 2 ( Region belgique )
        [99%] Niveau 3 ( Région France et Canton belge)
        [99%] Niveau 4 ( Département France et Arrondissement belge)
    [X] Batch pour renommer les regions de France
    [X] Batch pour créer le lien entre cities / zones
        [X] departement -> level4
        [X] region -> level3
        [X] regionBel -> level2
    [ ] Batch pour crée la clé unique pour
        [99%] Les zones
        [99%] les villes 
        [40%] les éléments possédants une adresse
    [ ] Batch qui supprime “*BE“ dans les insee des communes de la belgique
    [X] Batch pour remplacer dans les addresses (vérifier que c'est la même chose pour la belgique: 
        [X] departement -> level4
        [X] region -> level3
        [X] regionBel -> level2
    [ ] Traduction en Fonction du pays
        [ ] géré le process
        [ ] “insee“  -> “INSEE”, “INS” (etc …)
        [ ] "level4" -> “département”, “préfecture” etc ...
        [ ] "level3" -> “région”, “canton” etc ...
        [ ] "level2" -> “région”, etc …
    [ ] Création automatique des nouvelles communes 
        [95%] Via le formInMap
        [ ] Via l'import
        [95%] Création des zones liers
        [X] Ajout des wikiID et osm ID
        [95%] Ajout des CP
    [ ] Update Commune 
        [ 50% ] Création d'un formulaire pour permettre de modifier les communes
    [ ] Page admin pour géré les villes 
    [X] Modification dans le code
        [X] Gestion des scopes
        [X] Géré la recherche sur la localité
        [ ] Network :
        	[X] Géré l'ancien format
        	[ ] Nouveau format
        [X] Activité du territoire
        [X] Communexion

## Process passage à l'internationnalisation 

- Sauvegarder l'actuelle base de données
- Supprimer cities
- Importer cities, zones et translates :
    + Déziper les fichiers puis exécuter les commandes suivants
```
mongoimport --db communecter --collection zones --file zones.json
```

```
mongoimport --db communecter --collection translate --file translate.json
```

```
mongoimport --db communecter --collection cities --file cities.json
```

- Passer les batchs
    - co2/datamigration/BatchInterElement
    - co2/datamigration/BatchInterNews


## Changements

### Données

#### Citoyen, orga , event et project

On a enlevé depName et regionName 

On a rajouté localityId qui correspond au Mongo ID de la commune, level et levelName de 1 à 4

level1 : Mongo ID de la zone
level1Name : Nom de la zone

``` 
"address" : {
        "@type" : "PostalAddress",
        "codeInsee" : "37131",
        "addressCountry" : "FR",
        "postalCode" : "37530",
        "addressLocality" : "LIMERAY",
        "streetAddress" : "",
        "localityId" : "54c09644f6b95c1418004eb4",
        "level1" : "58bd5d6494ef471f218b4588",
        "level1Name" : "France",
        "level3" : "5979d1cd6ff9925a108b4572",
        "level3Name" : "Centre-Val de Loire",
        "level4" : "597b1cff6ff992f0038b45fd",
        "level4Name" : "INDRE-ET-LOIRE"
    }
```

#### Cities

On a enlevé dep, depName, region et regionName 

On a rajouté localityId qui correspond au Mongo ID de la commune, level et levelName de 1 à 4

#### Zone 

Ajout d'une collection Zone, qui va contenir l'ensembles des zones adminstratifs, c'est a dire 
- Pays
- Canton
- Région
- Departement 
- Agglo

En fonction du Pays

####Translate

Va contenir l'ensemble des Traduction pour les cities et les zones

```
{
    "_id" : ObjectId("5991803c6ff992ed1203d53b"),
    "countryCode" : "FR",
    "parentId" : "54c09634f6b95c141800151d",
    "parentType" : "cities",
    "translates" : {
        "PL" : "Genouilleux",
        "EU" : "Genouilleux"
    }
}

```

# A tester

- Ajout d'element avec une adresses
- Modification d'addresse
- Suppression d'adresse
- Communexion 
- Scope dans Search / Live / Agenda
- Activité du térritoire
- Network 
- Import


## A Faire

### API 

Géré la recherche par ville

### Import 

Géré la recherche par ville

### File

ProfilSocial.js : Géré le loadLiveNow avec les zones
cities.js : Refaire le formulaire des cities
co2/assets/js/menus/multiscopes.js : nettoyer le code inutile (postalCode, dep etc )
newsHtml.js : Nettoyage
co2/assets/js/sig/map_popupContent.js : Nettoyage
CO2.php : getCitiesNewCaledonia() : Voir avec Tango

### Erreur
- dans tranlates remplace les types cities par zones pour les zones.
- tranlates -> translate

### Communexion
    - Ajouter la key à la communexion

### Gestion des zones level 3

Erreur: POLYNESIE : City :3

### Gestion des zones level 4

Les niveaux 3 n'apparait pas 

Erreur: Polynesie : City :6

http://nominatim.openstreetmap.org/lookup?osm_ids=R3412620&polygon_geojson=1&extratags=1&format=json

### Traduction 
Error Nouvelle-Calédonie 58be4bd194ef47e31d0ddbcb
Error Dendermonde 597b1b456ff992f0038b4588
Error Maaseik 597b1b506ff992f0038b458c
Error Sint-Niklaas 597b1b556ff992f0038b458e
Error Neufchâteau 597b1b5e6ff992f0038b4592
Error Nivelles 2 597b1b666ff992f0038b4595
Error Aalst 597b1b6c6ff992f0038b4597
Error Mechelen 597b1b716ff992f0038b4599
Error Kortrijk 597b1bbb6ff992f0038b45ab
Error Île-de-france 597b1bd16ff992f0038b45b1
Error Nivelles 1 597b1c0c6ff992f0038b45bf
Error Tielt 597b1d1e6ff992f0038b4602
NB Element mis à jours: 160

## Test

keyCommunexion=FR@58bd5d6494ef471f218b4588@@5979d1cd6ff9925a108b4572@597b1cff6ff992f0038b45fd@54c09644f6b95c1418004eb2@37530

checker 




mongoimport --host c19.lamppost.17.mongolayer.com --port 10019 --username devCommunecter --password 2210wtfmongo$ --db dev-communecter --collection zones --file zones.json
      
mongoimport --host c19.lamppost.17.mongolayer.com --port 10019 --username devCommunecter --password 2210wtfmongo$ --db dev-communecter --collection translate --file translate.json

mongoimport --host c19.lamppost.17.mongolayer.com --port 10019 --username devCommunecter --password 2210wtfmongo$ --db dev-communecter --collection cities --file cities.json