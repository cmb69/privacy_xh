<?php

/**
 * Copyright 2011-2017 Christoph M. Becker
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

class Controller
{
    /**
     * @return void
     */
    public static function dispatch()
    {
        if (XH_ADM) {
            if (self::isAdministrationRequested()) {
                self::handleAdministration();
            }
        }
    }

    /**
     * @return bool
     */
    private static function isAdministrationRequested()
    {
        global $privacy;

        return function_exists('XH_wantsPluginAdministration') && XH_wantsPluginAdministration('privacy')
            || isset($privacy) && $privacy == 'true';
    }

    /**
     * @return void
     */
    private static function handleAdministration()
    {
        global $admin, $action, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
            case '':
                $o .= self::renderInfoView();
                break;
            default:
                $o .= plugin_admin_common($action, $admin, 'privacy');
        }
    }

    /**
     * @return string
     */
    private static function renderInfoView()
    {
        global $pth;

        $view = new View('info');
        $view->logo = "{$pth['folder']['plugins']}privacy/privacy.png";
        $view->version = PRIVACY_VERSION;
        $view->checks = (new SystemCheckService)->getChecks();
        return (string) $view;
    }

    /**
     * @return mixed
     */
    public static function main()
    {
        if (XH_ADM) {
            return;
        }
        $action = isset($_POST['privacy_submit']) ? 'submitAction' : 'defaultAction';
        ob_start();
        (new MainController)->$action();
        return ob_get_clean();
    }
}
