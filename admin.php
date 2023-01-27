<?php

use Privacy\Dic;

/**
 * @var array<array<string>> $pth
 * @var array<array<string>> $plugin_tx
 * @var string $admin
 * @var string $o
 */

XH_registerStandardPluginMenuItems(false);

if (XH_wantsPluginAdministration('privacy')) {
    $o .= print_plugin_admin('off');
    switch ($admin) {
        case '':
            $o .= Dic::makeShowInfo()();
            break;
        default:
            $o .= plugin_admin_common();
    }
}
