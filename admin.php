<?php

use Privacy\ShowInfo;
use Privacy\SystemChecker;

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
            $controller = new ShowInfo(
                "{$pth['folder']['plugins']}privacy/",
                $plugin_tx['privacy'],
                new SystemChecker()
            );
            $o .= $controller();
            break;
        default:
            $o .= plugin_admin_common();
    }
}
