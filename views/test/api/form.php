<?php
namespace MangoPay\Demo;
//require_once '../../vendor/autoload.php';
require_once 'htmlHelper.php';
require_once 'config.php';

$module = @$_GET['module'];
if (!isset($module))
    return;

HtmlHelper::getHeader($module);

$details = explode('_', $module);
$entityName = @$details[0];
$subApiName = @$details[1];
$operation = @$details[2];
$subEntityName = @$details[3];
$filterName = @$details[4];
$subSubEntityName = @$details[5];
$entityId = @$_POST['Id'];
$subEntityId = @$_POST['IdSubEntity'];

if (isset($_POST['_postback']) && $_POST['_postback'] == '1') {

    try {
        $api = new \MangoPay\MangoPayApi();
		$api->Config->BaseUrl = MangoPayDemo_BaseUrl;
        $api->Config->ClientId = MangoPayDemo_ClientId;
        $api->Config->ClientPassword = MangoPayDemo_ClientPassword;
        $api->Config->TemporaryFolder = TemporaryFolder;

        $module = @$_GET['module'];
        if (isset($module) && strpos($module, '$Sort') !== false) {
            if (isset($_POST["_sort_"]) && !empty($_POST["_sort_"])){
                $sortFieldName = $_POST["_sort_"];
                $sortDirection = $_POST["_sort_direction_"];
                if (!isset($sortDirection)) {
                    $sortDirection = \MangoPay\SortDirection::ASC;
                }
                
                $sorting = new \MangoPay\Sorting();
                $sorting->AddField($sortFieldName, $sortDirection);
            }
        }
        
        // normal cases
        switch ($operation) {
             case '|NoParams|':
                $methodName = $subEntityName;
                $apiResult = $api->$subApiName->$methodName();
                break;
            case '|GetWalletTransactions|':
                $pagination = HtmlHelper::getEntity('Pagination');
                $filter = null;
                if (isset($filterName) && $filterName != ""){
                    $filter = HtmlHelper::getEntity($filterName);
                }
                $apiResult = $api->$subApiName->GetWalletTransactions(null, null, $pagination, $filter);
                
                print '<pre>';print_r($pagination);print '</pre>';
                
                break;
            case '|EnumParams|':
                $methodName = $subEntityName;
                $enums = explode('$', $subSubEntityName);
                if (count($enums) == 1){
                    $apiResult = $api->$subApiName->$methodName($_POST[$enums[0]]);
                } else if (count($enums) == 2) {
                    $apiResult = $api->$subApiName->$methodName($_POST[$enums[0]], $_POST[$enums[1]]);
                }
                break;
            case '|EnumParamsList|':
                $pagination = HtmlHelper::getEntity('Pagination');
                $filter = null;
                if (isset($filterName) && $filterName != ""){
                    $filter = HtmlHelper::getEntity($filterName);
                }
                $methodName = $subEntityName;
                $enums = explode('$', $subSubEntityName);
                if (count($enums) == 1){
                    $apiResult = $api->$subApiName->$methodName($_POST[$enums[0]], $pagination, $filter);
                } else if (count($enums) == 2) {
                    $apiResult = $api->$subApiName->$methodName($_POST[$enums[0]], $_POST[$enums[1]], $pagination, $filter);
                }
                break;
            case 'Create':
                $entity = HtmlHelper::getEntity($entityName);
                $apiResult = $api->$subApiName->Create($entity);
                break;
            case 'Get':
                $apiResult = $api->$subApiName->Get($entityId);
                break;           
            case 'Save':
                $entity = HtmlHelper::getEntity($entityName, $entityId);
                $apiResult = $api->$subApiName->Update($entity);
                break;
            case 'SaveNoId':
                $entity = HtmlHelper::getEntity($entityName);
                $apiResult = $api->$subApiName->Update($entity);
                break;
            case 'All':
                $pagination = HtmlHelper::getEntity('Pagination');
                $filter = null;
                if (isset($filterName) && $filterName != "")
                    $filter = HtmlHelper::getEntity($filterName);

                if (isset($filter) && !isset($sorting))
                    $apiResult = $api->$subApiName->GetAll($pagination, $filter);
                else if (!isset($filter) && isset($sorting))
                    $apiResult = $api->$subApiName->GetAll($pagination, $sorting);
                else if (isset($filter) && isset($sorting))
                    $apiResult = $api->$subApiName->GetAll($pagination, $filter, $sorting);
                else
                    $apiResult = $api->$subApiName->GetAll($pagination);

                print '<pre>';print_r($pagination);print '</pre>';
                if (isset($sorting)) {
                    print '<pre>Sort: ';print_r($sorting);print '</pre>';
                }
                break;
            case 'CreateSubEntity':
                $entity = HtmlHelper::getEntity($subEntityName);
                $methodName = 'Create'. $subEntityName;
                $apiResult = $api->$subApiName->$methodName($entityId, $entity);
                break;
            case 'CreateSubSubEntity':
                $entity = HtmlHelper::getEntity($subEntityName);
                $methodName = 'Create' . $subEntityName;
                $apiResult = $api->$subApiName->$methodName($entityId, $subEntityId, $entity);
                break;
            case 'GetSubEntity':
                $methodName = 'Get' . $subEntityName;
                $apiResult = $api->$subApiName->$methodName($entityId, $subEntityId);
                break;
            case 'SaveSubEntity':
                $entity = HtmlHelper::getEntity($subEntityName);
                $methodName = 'Update' . $subEntityName;
                $apiResult = $api->$subApiName->$methodName($subEntityId, $entity);
                break;
            case 'ListSubEntity':
            case 'ListSubSubEntity':
                $pagination = HtmlHelper::getEntity('Pagination');
                $methodName = $subEntityName;
                $filter = null;
                if (isset($filterName) && $filterName != "")
                    $filter = HtmlHelper::getEntity($filterName);

                if ($operation == 'ListSubSubEntity') {
                     if (isset($filter) && !isset($sorting))
                         $apiResult = $api->$subApiName->$methodName($entityId, $subEntityId, $pagination, $filter);
                     else if (!isset($filter) && isset($sorting))
                         $apiResult = $api->$subApiName->$methodName($entityId, $subEntityId, $pagination, null, $sorting);
                     else if (isset($filter) && isset($sorting))
                         $apiResult = $api->$subApiName->$methodName($entityId, $subEntityId, $pagination, $filter, $sorting);
                     else
                         $apiResult = $api->$subApiName->$methodName($entityId, $subEntityId, $pagination);
                }else{
                     if (isset($filter) && !isset($sorting))
                         $apiResult = $api->$subApiName->$methodName($entityId, $pagination, $filter);
                     else if (!isset($filter) && isset($sorting))
                         $apiResult = $api->$subApiName->$methodName($entityId, $pagination, null, $sorting);
                     else if (isset($filter) && isset($sorting))
                         $apiResult = $api->$subApiName->$methodName($entityId, $pagination, $filter, $sorting);
                     else
                         $apiResult = $api->$subApiName->$methodName($entityId, $pagination);
                }
                
                print '<pre>';print_r($pagination);print '</pre>';
                if (isset($sorting))
                    print '<pre>Sort: ';print_r($_POST["_sort_"]);print '</pre>';
                    
                break;
            case 'CreatePageByFile':
                $methodName = 'Create' . $subEntityName . 'FromFile';
                $apiResult = $api->$subApiName->$methodName($entityId, $subEntityId, $_FILES['page_file']);
                break;
            case 'ContestDispute':
                $entity = HtmlHelper::getEntity($subEntityName);
                $apiResult = $api->$subApiName->$operation($entityId, $entity);
                break;
            case 'CloseDispute':
                $apiResult = $api->$subApiName->$operation($entityId);
                break;
            case 'Upload':
                $entity = HtmlHelper::getEntity($subEntityName);
                $apiResult = $api->$subApiName->$subSubEntityName($entity);
                break;
             case 'UploadFromFile':
                $apiResult = $api->$subApiName->$subSubEntityName($_FILES['page_file']);
                break;
        }
        
        print '<pre>';print_r($apiResult);print '</pre>';

    } catch (\MangoPay\Libraries\ResponseException $e) {
        
        echo '<div style="color: red;">\MangoPay\ResponseException: Code: ' . $e->getCode();
        echo '<br/>Message: ' . $e->getMessage();
        
       $details = $e->GetErrorDetails();
        if (!is_null($details))
            echo '<br/><br/>Details: '; print_r($details);
        echo '</div>';

    } catch (\MangoPay\Libraries\Exception $e) {
        
        echo '<div style="color: red;">\MangoPay\Exception: ' . $e->getMessage() . '</div>';
        
    }

} else {
    HtmlHelper::renderForm($entityName, $operation, array($subEntityName, $subSubEntityName), $filterName);
}