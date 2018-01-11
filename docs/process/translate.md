# creating new translations / convertsions

/api/person/get/id/xxx/format/xx
- add type entry ctk/controllers/$element/GetAction.php
- any specific processing can be added in Api::getData
    + contains Translate::convert 
        * contains self::bindData
        * uses mapping definitions from here ctk/models/TranslateXX.php
