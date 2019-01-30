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
    const VERSION = '@PRIVACY_VERSION@';

    /**
     * @return void
     */
    public function run()
    {
        if (XH_ADM) {
            XH_registerStandardPluginMenuItems(false);
            if (XH_wantsPluginAdministration('privacy')) {
                $this->handleAdministration();
            }
        }
    }

    /**
     * @return void
     */
    private function handleAdministration()
    {
        global $admin, $action, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
            case '':
                $o .= $this->renderInfoView();
                break;
            default:
                $o .= plugin_admin_common($action, $admin, 'privacy');
        }
    }

    /**
     * @return View
     */
    private function renderInfoView()
    {
        global $pth;

        $view = new View('info');
        $view->logo = "{$pth['folder']['plugins']}privacy/privacy.png";
        $view->version = PRIVACY_VERSION;
        $view->checks = (new SystemCheckService)->getChecks();
        return $view;
    }
}
