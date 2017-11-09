<?php
namespace MangoPay\Demo;

class HtmlHelper {
    
    public static function getHeader($module) {
        foreach ($GLOBALS['MangoPay_Demo_Menu'] as $moduleText => $subMenu) {
            $key = array_search($module, $subMenu);
            if ($key) {
                echo '<h2 style="margin: 0 0 20px 0;">' . $key . '</h2>';
                return;
            }
        }
    }
    
    public static function renderForm($entityName, $operation, $subEntityName, $filterName) {
        
        echo '<form name="input" action="" method="post" enctype="multipart/form-data">';
        echo '<table>';
        
        switch ($operation) {
            case '|EnumParams|':
            case '|EnumParamsList|':
                $enums = explode('$', $subEntityName[1]);
                foreach ($enums as $enum) {
                    echo '<tr><td>';
                    echo $enum;
                    echo '</td>';
                    echo '<td>';
                    self::renderEnum('\MangoPay\\' . $enum, $enum, "");
                    echo '</td></tr>';
                }
                if ($operation == '|EnumParams|'){
                    break;
                }                
            case 'All':
            case '|GetWalletTransactions|':
                if (isset($filterName) && $filterName != "") {
                    self::renderFormRow('<i>Optional filters:</i>');
                    self::renderEntity($filterName);
                }
                
                self::renderFormRow('<i>Pagination:</i>');
                self::renderEntity('Pagination');
                break;
            case 'Create':
                self::renderEntity($entityName);
                break;
            case 'Get':
            case 'CloseDispute':
			case 'Cancel':
                self::renderId($entityName);
                break;
            case 'Save':
                self::renderId($entityName);
                self::renderEntity($entityName);
                break;
            case 'SaveNoId':
                self::renderEntity($entityName);
                break;
            case 'CreateSubEntity':
                self::renderId($entityName);
                self::renderEntity($subEntityName[0]);
                break;
            case 'CreateSubSubEntity':
                self::renderId($entityName);
                self::renderId($subEntityName[1], 'IdSubEntity');
                self::renderEntity($subEntityName[0]);
                break;
            case 'GetSubEntity':
                self::renderId($entityName);
                self::renderId($subEntityName[0], 'IdSubEntity');
                break;
            case 'SaveSubEntity':
                self::renderId($entityName, 'IdSubEntity');
                self::renderId($subEntityName[0]);
                self::renderEntity($subEntityName[0]);
                break;
            case 'ListSubEntity':
                self::renderId($entityName);
                if (isset($filterName) && $filterName != "") {
                    self::renderFormRow('<i>Optional filters:</i>');
                    self::renderEntity($filterName);
                }
                
                self::renderFormRow('<i>Pagination:</i>');
                self::renderEntity('Pagination');
                break;
			case 'ListSubSubEntity':
                self::renderId($entityName);
                self::renderId($subEntityName[1], 'IdSubEntity');
                if (isset($filterName) && $filterName != "") {
                    self::renderFormRow('<i>Optional filters:</i>');
                    self::renderEntity($filterName);
                }
                
                self::renderFormRow('<i>Pagination:</i>');
                self::renderEntity('Pagination');
                break;
            case 'CreatePageByFile':
                self::renderId($entityName);
                self::renderId($subEntityName[1], 'IdSubEntity');
                self::renderFormRow('<tr><td></td><td><input type="file" name="page_file" /></td></tr>');
                break;
            case 'ContestDispute':
                self::renderId($entityName, 'IdSubEntity');
                self::renderEntity($subEntityName[0]);
                break;
             case 'Upload':
                self::renderEntity($subEntityName[0]);
                break;
             case 'UploadFromFile':
                self::renderFormRow('<tr><td></td><td><input type="file" name="page_file" /></td></tr>');
                break;
        }
        
        $module = @$_GET['module'];
        if (isset($module) && strpos($module, '$Sort')) {
            self::renderSort();
        }
        
        $buttonText = $operation;
        if ($operation == "|NoParams|" || $operation == "|EnumParams|"){
            $buttonText = $subEntityName[0];
        } else if ($operation == "SaveNoId"){
            $buttonText = "Save";
        }
        
        echo '<tr><td></td><td><input type="submit" value="' . $buttonText . '" /></td></tr>';
        echo '</table>';
        echo '<input type="hidden" name="_postback" value="1"/>';
        echo '</form>';
    }
    
    public static function renderEntity($entityName, $prefix = '') {

        $className = '\\MangoPay\\' . $entityName;
        $entity = new $className();
        $blackList = $entity->GetReadOnlyProperties();
        $entityObject = new \ReflectionObject($entity);
        
        $module = @$_GET['module'];
        $subObjects = $entity->GetSubObjects();
        $dependsObjects = $entity->GetDependsObjects();
        $depTypesInModule = explode(':', $module);

        $properties = $entityObject->getProperties();
        foreach ($properties as $property) {

            $name = $property->getName();
            
            if (in_array($name, $blackList))
                continue;
            
            // is sub object?
            $cls = @$subObjects[$name];
            if ($cls) {
                self::renderEntity(str_replace('\\MangoPay\\', '', $cls), "$name:");
                continue;
            }

            // is dependent object?
            $handled = false;
            foreach ($dependsObjects as $dep) {
                if ($dep['_property_name'] == $name) {
                    foreach ($depTypesInModule as $dt) {
                        $cls = @$dep[$dt];
                        if ($cls) {
                            self::renderEntity(str_replace('\\MangoPay\\', '', $cls), "$name:");
                            $handled = true;
                            break;
                        }
                    }
                    break;
                }
            }
            if ($handled) continue;

            // special fields
            if ($entityName == 'Pagination' && in_array($name, array('Links', 'TotalPages', 'TotalItems')))
                    continue;
            
            // normal fields
            $value = '';
            if (isset($entity->$name))
                $value = $entity->$name;
            
            echo '<tr><td>';
            echo $prefix . $name . ':</td><td>';
            if ($className == "\\MangoPay\\Hook" && $name == "EventType"){
                self::renderEnum("\\MangoPay\\EventType", $name, $prefix);
            } elseif ($className == "\\MangoPay\\FilterEvents" && $name == "EventType"){
                self::renderEnum("\\MangoPay\\EventType", $name, $prefix);
            } elseif ($className == "\\MangoPay\\KycDocument" && $name == "Type") {
                self::renderEnum("\\MangoPay\\KycDocumentType", $name, $prefix);
            } elseif ($className == "\\MangoPay\\KycDocument" && $name == "Status") {
                self::renderEnum("\\MangoPay\\KycDocumentStatus", $name, $prefix);
            } elseif ($className == "\\MangoPay\\Card" && $name == "Validity") {
                self::renderEnum("\\MangoPay\\CardValidity", $name, $prefix);
            } elseif ($className == "\\MangoPay\\DisputeDocument" && $name == "Type") {
                self::renderEnum("\\MangoPay\\DisputeDocumentType", $name, $prefix);
            } elseif ($className == "\\MangoPay\\DisputeDocument" && $name == "Status") {
                self::renderEnum("\\MangoPay\\DisputeDocumentStatus", $name, $prefix);
            } elseif ($className == "\\MangoPay\\ReportRequest" && $name == "ReportType") {
                self::renderEnum("\\MangoPay\\ReportType", $name, $prefix);
            } elseif ($className == "\\MangoPay\\Client" && $name == "PlatformType") {
                self::renderEnum("\\MangoPay\\PlatformType", $name, $prefix);
            }
            else
                echo '<input type="text" name="' . $prefix . $name . '" value="' . $value . '"/>';
            echo '</td></tr>';
        }
    }
    
    public static function renderEnum($enumClassName, $name, $prefix) {

        $enum = new $enumClassName();
        $enumObject = new \ReflectionObject($enum);
        $constants = $enumObject->getConstants();
        
        echo '<select name="' . $prefix . $name . '">';
        foreach ($constants as $constant) {
            echo '<option value="' . $constant . '">' . $constant . '</option>';
        }
        echo '</select>';
    }
    
    public static function renderFormRow($label = null, $field = null) {
        
        echo '<tr><td>';
        echo $label ? $label : '&nbsp;';
        echo '</td><td>';
        echo $field ? $field : '&nbsp;';
        echo '</td></tr>';
    }

    public static function renderId($entityName, $fieldName = 'Id') {
        
        $value = '';
        if (isset($_POST[$fieldName]))
            $value = $_POST[$fieldName];
        
        echo '<tr><td>';
        echo $entityName . ' Id:</td><td>';
        echo '<input type="text" name="' . $fieldName . '" value="' . $value . '"/></td></tr>';
    }
    
    public static function renderSort(){
        
        $value = '';
        if (isset($_POST["_sort_"]))
            $value = $_POST["_sort_"];
        
        echo '<tr><td>';
        echo 'Sort:</td><td>';
        echo '<input type="text" name="_sort_" value="' . $value . '" style="width:176px;"/>';
        
        echo '&nbsp;<select name="_sort_direction_" style="width:70px;">';
        echo '<option value="' . \MangoPay\SortDirection::ASC . '">' .  strtoupper(\MangoPay\SortDirection::ASC) . '</option>';
        echo '<option value="' . \MangoPay\SortDirection::DESC . '">' . strtoupper(\MangoPay\SortDirection::DESC) . '</option>';
        echo '</select></td></tr>';
    }
    
    public static function getEntity($entityName, $entityId = 0, $returnNullIfNoPropertyTouched = false, $prefix = '') {
        $touchedAnyProp = false;

        $className = '\\MangoPay\\' . $entityName;
        $entity = new $className($entityId);
        
        $entityObject = new \ReflectionObject($entity);
        $properties = $entityObject->getProperties();

        $module = @$_GET['module'];
        $subObjects = $entity->GetSubObjects();
        $dependsObjects = $entity->GetDependsObjects();
        $depTypesInModule = explode(':', $module);

        foreach ($properties as $property) {
            if (!$property->isPublic())
                continue;
            
            $name = $property->getName();

            $frmName = $prefix . $name;
            if (isset($_POST[$frmName]) && strlen($_POST[$frmName]) > 0) {

                // special fields for Owners property
                if ($entityName == 'Wallet' && $name == 'Owners'
                    || $entityName == 'Client' && $name == 'TechEmails'
                    || $entityName == 'Client' && $name == 'AdminEmails'
                    || $entityName == 'Client' && $name == 'FraudEmails'
                    || $entityName == 'Client' && $name == 'BillingEmails'){
                    
                    $entity->$name = explode(';', $_POST[$frmName]);
                }
                // special cast to int for Birthday property in UserNatural 
                // and UserLegal class
                elseif (($entityName == 'UserNatural' && $name == 'Birthday')
                    || ($entityName == 'UserLegal' && $name == 'LegalRepresentativeBirthday'))
                {
                    $entity->$name = (float)$_POST[$frmName];
                }
                // normal fields
                else
                    $entity->$name = $_POST[$frmName];

                $touchedAnyProp = true;
            }
        }

        // sub objects
        foreach ($subObjects as $name => $cls) {
            $entity->$name = self::getEntity(str_replace('\\MangoPay\\', '', $cls), 0, true, "$name:");
        }

        // dependent objects
        foreach ($dependsObjects as $dep) {
            $name = $dep['_property_name'];
            foreach ($depTypesInModule as $dt) {
                $cls = @$dep[$dt];
                if ($cls) {
                    $entity->$name = self::getEntity(str_replace('\\MangoPay\\', '', $cls), 0, false, "$name:");
                    break;
                }
            }
        }

        if ($returnNullIfNoPropertyTouched && !$touchedAnyProp)
            return null;

        return $entity;
    }
}