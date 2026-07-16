<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

global $USER;

unset(
    $adminMenu->aGlobalMenu["global_menu_marketplace"],
    $adminMenu->aGlobalMenu["global_menu_services"],
    $adminMenu->aGlobalMenu["global_menu_crm_site_master"],
    $adminMenu->aGlobalMenu["global_menu_b24connector"],
    $adminMenu->aGlobalMenu["global_menu_landing"],
    // $adminMenu->aGlobalMenu["global_menu_settings"],
);

foreach ($adminMenu->aGlobalMenu["global_menu_content"]['items'] as $key => $item) {
    if (
        $item['title']      == 'Настройка информационных блоков'
        || $item['section'] == 'highloadblock'
        || $item['section'] == 'fileman'
    ) {
        // unset($adminMenu->aGlobalMenu["global_menu_content"]['items'][$key]);
    }
}

foreach ($adminMenu->aGlobalMenu["global_menu_store"]['items'] as $key => $item) {
    if (
        $item['items_id']    == 'update_system_market'
        || $item['items_id'] == 'menu_sale_affiliates'
        || $item['items_id'] == 'menu_sale_stat'
        || $item['items_id'] == 'sale_crm'
    ) {
        // unset($adminMenu->aGlobalMenu["global_menu_store"]['items'][$key]);
    }
}
