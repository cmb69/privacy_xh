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
    const OKAY = 0;

    const WARN = 1;

    const FAIL = 2;

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
                $o .= self::renderAboutView() . self::renderSystemCheck();
                break;
            default:
                $o .= plugin_admin_common($action, $admin, 'privacy');
        }
    }

    /**
     * @return string
     */
    private static function renderAboutView()
    {
        global $pth;

        $view = new View('about');
        $view->logo = "{$pth['folder']['plugins']}privacy/privacy.png";
        $view->version = PRIVACY_VERSION;
        return (string) $view;
    }

    /**
     * @return string
     */
    private static function renderSystemCheck()
    {
        global $plugin_tx;

        $checks = self::systemChecks();
        $o = '<h4>' . $plugin_tx['privacy']['syscheck_title'] . '</h4>';
        foreach ($checks as $label => $status) {
            $o .= self::renderStatusIcon($status) . '&nbsp;&nbsp;' . $label
                . tag('br');
        }
        return $o;
    }

    /**
     * @param int $status
     * @return string
     */
    private static function renderStatusIcon($status)
    {
        global $pth;

        switch ($status) {
            case self::OKAY:
                $filename = 'ok';
                $alt = 'ok';
                break;
            case self::WARN:
                $filename = 'warn';
                $alt = 'warning';
                break;
            case self::FAIL:
                $filename = 'fail';
                $alt = 'failure';
                break;
        }
        return tag(
            'img src="' . $pth['folder']['plugins'] . 'privacy/images/'
            . $filename . '.png" alt="' . $alt . '"'
        );
    }

    /**
     * @return array<string, int>
     */
    private static function systemChecks()
    {
        global $tx, $plugin_tx;

        $ptx = $plugin_tx['privacy'];
        $requiredPHPVersion = '5.4.0';
        $res = array();
        $res[sprintf($ptx['syscheck_phpversion'], $requiredPHPVersion)]
            = version_compare(PHP_VERSION, $requiredPHPVersion) >= 0
                ? self::OKAY
                : self::FAIL;
        foreach (array('pcre') as $ext) {
            $res[sprintf($ptx['syscheck_extension'], $ext)]
                = extension_loaded($ext) ? self::OKAY : self::FAIL;
        }
        $res[$ptx['syscheck_magic_quotes']]
            = !get_magic_quotes_runtime() ? self::OKAY : self::FAIL;
        foreach (self::getWritableFolders() as $folder) {
            $res[sprintf($ptx['syscheck_writable'], $folder)]
                = is_writable($folder) ? self::OKAY : self::WARN;
        }
        return $res;
    }

    /**
     * @return string[]
     */
    private static function getWritableFolders()
    {
        global $pth;

        $folders = array();
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $pth['folder']['plugins'] . 'privacy/' . $folder;
        }
        return $folders;
    }

    /**
     * @return mixed
     */
    public static function main()
    {
        if (XH_ADM) {
            return;
        }
        if (isset($_POST['privacy_submit'])) {
            if (isset($_POST['privacy_agree'])) {
                setcookie('privacy_agreed', 'yes', self::getExpirationTime(), CMSIMPLE_ROOT);
            }
            header('Location: ' . self::getLocationURL(), true, 303);
            exit;
        }
        if (!isset($_COOKIE['privacy_agreed'])) {
            return self::renderPrivacyForm();
        }
    }

    /**
     * @return int
     */
    private static function getExpirationTime()
    {
        global $plugin_cf;

        return !empty($plugin_cf['privacy']['duration'])
            ? time() + 24 * 60 * 60 * $plugin_cf['privacy']['duration']
            : 0;
    }

    /**
     * @return string
     */
    private static function getLocationURL()
    {
        $url = CMSIMPLE_URL;
        if ($_SERVER['QUERY_STRING'] != '') {
            $url .= '?';
        }
        $url .= $_SERVER['QUERY_STRING'];
        return $url;
    }

    /**
     * @return string
     */
    private static function renderPrivacyForm()
    {
        global $plugin_tx;

        $view = new View('privacy');
        $view->message = new HtmlString($plugin_tx['privacy']['message']);
        return (string) $view;
    }
}
