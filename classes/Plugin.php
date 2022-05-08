<?php

/**
 * Copyright (C) Christoph M. Becker
 *
 * This file is part of Privacy_XH.
 *
 * Privacy_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Privacy_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Privacy_XH.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Privacy;

class Plugin
{
    const VERSION = '1.0beta3';

    public function run(): void
    {
        if (XH_ADM) { // @phpstan-ignore-line
            XH_registerStandardPluginMenuItems(false);
            if (XH_wantsPluginAdministration('privacy')) {
                $this->handleAdministration();
            }
        }
    }

    private function handleAdministration(): void
    {
        global $admin, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
            case '':
                $o .= $this->renderInfoView();
                break;
            default:
                $o .= plugin_admin_common();
        }
    }

    private function renderInfoView(): string
    {
        global $pth, $plugin_tx;

        $view = new View("{$pth['folder']['plugins']}privacy/views", $plugin_tx["privacy"]);
        ob_start();
        $view->render("info", [
            "logo" => "{$pth['folder']['plugins']}privacy/privacy.png",
            "version" => self::VERSION,
            "checks" => (new SystemCheckService)->getChecks(),
        ]);
        return (string) ob_get_clean();
    }
}
