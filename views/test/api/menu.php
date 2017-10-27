<?php

$GLOBALS['MangoPay_Demo_Menu'] = array(
    
    'Users' => array(
        'Create natural user' => 'UserNatural_Users_Create',
        'Create legal user' => 'UserLegal_Users_Create',
        'Get user' => 'User_Users_Get',
        'Get all users' => 'User_Users_All___$Sort',
        'Save natural user' => 'UserNatural_Users_Save',
        'Save legal user' => 'UserLegal_Users_Save',
        'Save legal user' => 'UserLegal_Users_Save',
    ),
    'Bank accounts' => array(
        'Create IBAN account' => 'User_Users_CreateSubEntity_BankAccount_:IBAN',
        'Create GB account' => 'User_Users_CreateSubEntity_BankAccount_:GB',
        'Create US account' => 'User_Users_CreateSubEntity_BankAccount_:US',
        'Create CA account' => 'User_Users_CreateSubEntity_BankAccount_:CA',
        'Create OTHER account' => 'User_Users_CreateSubEntity_BankAccount_:OTHER',
        'Get bank account for user' => 'User_Users_GetSubEntity_BankAccount',
        'List bank accounts for user' => 'User_Users_ListSubEntity_GetBankAccounts__$Sort',
    ),
    'Wallets' => array(
        'Create wallet' => 'Wallet_Wallets_Create',
        'Get wallet' => 'Wallet_Wallets_Get',
        'Save wallet' => 'Wallet_Wallets_Save',
        'List wallets for user' => 'User_Users_ListSubEntity_GetWallets__$Sort',
    ),
    'Transactions' => array(
        'List transactions for user' => 'User_Users_ListSubEntity_GetTransactions_FilterTransactions__$Sort',
        'List transactions for wallet' => 'Wallet_Wallets_ListSubEntity_GetTransactions_FilterTransactions__$Sort',
    ),
    'Transfers' => array(
        'Create transfer' => 'Transfer_Transfers_Create',
        'Get transfer' => 'Transfer_Transfers_Get',
    ),
    'Pay-ins' => array(
        'Create pay-in web card' => 'PayIn_PayIns_Create_:CARD:WEB',
        'Create pay-in direct card' => 'PayIn_PayIns_Create_:CARD:DIRECT',
        'Create pay-in direct pre-authorized' => 'PayIn_PayIns_Create_:PREAUTHORIZED:DIRECT',
        'Create pay-in direct bank wire' => 'PayIn_PayIns_Create_:BANK_WIRE:DIRECT',
        'Create pay-in direct debit web' => 'PayIn_PayIns_Create_:DIRECT_DEBIT:WEB',
        'Create pay-in direct debit direct' => 'PayIn_PayIns_Create_:DIRECT_DEBIT:DIRECT',
        'Create pay-in PayPal' => 'PayIn_PayIns_Create_:PAYPAL:WEB',
        'Get pay-in' => 'PayIn_PayIns_Get',
    ),
    'Pay-outs' => array(
        'Create pay-out bank wire' => 'PayOut_PayOuts_Create_:BANK_WIRE',
        'Get pay-out bank wire' => 'PayOut_PayOuts_Get_:BANK_WIRE',
    ),
    'Refunds' => array(
        'Create refund for transfer' => 'Transfer_Transfers_CreateSubEntity_Refund',
        'Create refund for pay-in' => 'PayIn_PayIns_CreateSubEntity_Refund',
        'Get refund' => 'Refund_Refunds_Get',
    ),
    'Card registration' => array(
        'Create card registration' => 'CardRegistration_CardRegistrations_Create',
        'Get card registration' => 'CardRegistration_CardRegistrations_Get',
        'Update card registration' => 'CardRegistration_CardRegistrations_Save',
    ),
    'Card pre-authorization' => array(
        'Create pre-authorization' => 'CardPreAuthorization_CardPreAuthorizations_Create',
        'Get pre-authorization' => 'CardPreAuthorization_CardPreAuthorizations_Get',
        'Update pre-authorization' => 'CardPreAuthorization_CardPreAuthorizations_Save',
    ),
    'Card' => array(
        'Get card' => 'Card_Cards_Get',
        'Save card' => 'Card_Cards_Save',
        'List cards for user' => 'User_Users_ListSubEntity_GetCards__$Sort',
    ),
    'Event' => array(
        'List events' => 'Event_Events_All__FilterEvents__$Sort',
    ),
    'Hooks' => array(
        'Create hook' => 'Hook_Hooks_Create',
        'Get hook' => 'Hook_Hooks_Get',
        'Save hook' => 'Hook_Hooks_Save',
        'List of hooks' => 'Hook_Hooks_All',
    ),
    'KYC' => array(
        'Create KYC document' => 'User_Users_CreateSubEntity_KycDocument',
        'Get KYC document' => 'User_Users_GetSubEntity_KycDocument',
        'Save KYC document' => 'User_Users_SaveSubEntity_KycDocument',
        'Create page for KYC from base64' => 'User_Users_CreateSubSubEntity_KycPage__KycDocument',
        'Create page for KYC from file' => 'User_Users_CreatePageByFile_KycPage__KycDocument',
        'List KYC documents for user' => 'User_Users_ListSubEntity_GetKycDocuments__$Sort',
        'List all KYC documents' => 'KycDocument_KycDocuments_All___$Sort',
    ),
    'Disputes' => array(
        'Get dispute' => 'Dispute_Disputes_Get',
        'Get all disputes' => 'Dispute_Disputes_All___$Sort',
        'Save tag disputes' => 'Dispute_Disputes_Save',
        'Save contest dispute' => 'Dispute_Disputes_ContestDispute_Money',
        'Close dispute' => 'Dispute_Disputes_CloseDispute',
        'Get transactions' => 'Dispute_Disputes_ListSubEntity_GetTransactions__$Sort',
        'Get disputes for wallet' => 'Wallet_Disputes_ListSubEntity_GetDisputesForWallet__$Sort',
        'Get disputes for user' => 'User_Disputes_ListSubEntity_GetDisputesForUser__$Sort',
    ),
    'Dispute documents' => array(
        'Create dispute document' => 'Dispute_Disputes_CreateSubEntity_DisputeDocument',
        'Get dispute document' => 'DisputeDocument_DisputeDocuments_Get',
        'Save dispute document' => 'Dispute_Disputes_SaveSubEntity_DisputeDocument',
        'Create page for dispute document from base64' => 'Dispute_Disputes_CreateSubSubEntity_DisputeDocumentPage__DisputeDocument',
        'Create page for dispute document from file' => 'Dispute_Disputes_CreatePageByFile_DisputeDocumentPage__DisputeDocument',
        'List all dispute documents' => 'DisputeDocument_DisputeDocuments_All___$Sort',
        'List dispute documents for dispute' => 'Dispute_Disputes_ListSubEntity_GetDocumentsForDispute__$Sort',
    ),
    'Mandates' => array(
         'Create mandate' => 'Mandate_Mandates_Create',
         'Get mandate' => 'Mandate_Mandates_Get',
         'Cancel mandate' => 'Mandate_Mandates_Cancel',
         'List of mandates' => 'Mandate_Mandates_All__FilterTransactions___$Sort',
         'List mandate for user' => 'User_Users_ListSubEntity_GetMandates_FilterTransactions_$Sort',
         'List mandate for user and for bank account' => 'User_Users_ListSubSubEntity_GetMandatesForBankAccount_FilterTransactions_BankAccount___$Sort',
     ),
    'Client' => array(
        'Get client information' => 'Client_Clients_|NoParams|_Get',
        'Update client' => 'Client_Clients_SaveNoId',
        'Upload logo from base64' => 'Client_Clients_Upload_ClientLogoUpload__UploadLogo',
        'Upload logo from file' => 'Client_Clients_UploadFromFile___UploadLogoFromFile',
        'View your client wallets' => 'Wallet_Clients_|NoParams|_GetWallets',
        'View your fees/credit wallets for each currency' => 'Wallet_Clients_|EnumParams|_GetWallets__FundsType',
        'View one wallets (fees or credit) with a particular currency' => 'Wallet_Clients_|EnumParams|_GetWallet__FundsType$CurrencyIso',
        'View the transactions linked to your client wallets (fees and credit)' => 'Wallet_Clients_|GetWalletTransactions|',
        'View the transactions linked to one of your client wallets (fees or credit) with a particular currency' => 'Wallet_Clients_|EnumParamsList|_GetWalletTransactions_FilterTransactions_FundsType$CurrencyIso',
     ),
    'Reports' => array(
        'Create report request' => 'ReportRequest_Reports_Create',
        'Get report request' => 'ReportRequest_Reports_Get',
        'List all report request' => 'ReportRequest_Reports_All__FilterReports__$Sort',
        //'List transactions for wallet' => 'Wallet_Wallets_ListSubEntity_GetTransactions_FilterTransactions__$Sort',
    ),
    'Responses' => array(
        'Get responses' => 'Response_Responses_Get'
    ),
);

?>

<div id="menu">
<?php

$moduleIndex = 0;
$selectedModuleIndex = -1;

foreach ($GLOBALS['MangoPay_Demo_Menu'] as $moduleText => $subMenu) {
    
    echo '<h3>' . $moduleText . '</h3><ul>';
    foreach ($subMenu as $menuText => $file) {
        echo '<li><a href="index.php?module=' . $file . '" >' . $menuText . '</a></li>';
        if( @$_GET['module'] == $file ) $selectedModuleIndex = $moduleIndex;
    }
    echo '</ul>';
    
    $moduleIndex ++;
}

?>
</div>
<script type="text/javascript">var selectedModuleIndex = <?php echo $selectedModuleIndex ?>; </script>