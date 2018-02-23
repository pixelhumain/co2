unzip cities.json.zip
unzip zones.json.zip
unzip translate.json.zip
mongoimport --db pixelhumain --collection cities --file cities.json --journal 
mongoimport --db pixelhumain --collection translate --file translate.json --journal 
mongoimport --db pixelhumain --collection zones --file zones.json --journal 
rm cities.json zones.json translate.json