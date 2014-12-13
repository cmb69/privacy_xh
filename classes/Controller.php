<?php

/**
 * The privacy controller.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Privacy
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2014 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Privacy_XH
 */

/**
 * The privacy controller.
 *
 * @category CMSimple_XH
 * @package  Privacy
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Privacy_XH
 */
class Privacy_Controller
{
    /**
     * Dispatches on plugin related requests.
     *
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
     * Returns whether the plugin administration is requested.
     *
     * @return bool
     *
     * @global string Whether the plugin administration is requested.
     */
    protected static function isAdministrationRequested()
    {
        global $privacy;

        return isset($privacy) && $privacy == 'true';
    }

    /**
     * Handles the plugin administration.
     *
     * @return void
     *
     * @global string The value of the <var>admin</var> GP parameter.
     * @global string The value of the <var>action</var> GP parameter.
     * @global string The (X)HTML fragment of the contents area.
     */
    protected static function handleAdministration()
    {
        global $admin, $action, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
        case '':
            $o .= self::version() . tag('hr') . self::systemCheck();
            break;
        default:
            $o .= plugin_admin_common($action, $admin, 'privacy');
        }
    }

    /**
     * Returns the plugin version information view.
     *
     * Must be called in plugin loading stage only.
     *
     * @return string (X)HTML.
     */
    protected static function version()
    {
        global $pth;

        return '<h1><a href="http://3-magi.net/?CMSimple_XH/Privacy_XH">Privacy_XH'
            . '</a></h1>'
            . tag(
                'img src="' . $pth['folder']['plugin'] . 'privacy.png"'
                . ' style="float:left"'
            )
            . '<p>Version: ' . PRIVACY_VERSION . '</p>'
            . '<p>Copyright &copy; 2012-2014 <a href="http://3-magi.net">Christoph'
            . ' M. Becker</a></p>'
            . '<p style="text-align:justify">This program is free software: you can'
            . ' redistribute it and/or modify'
            . ' it under the terms of the GNU General Public License as published by'
            . ' the Free Software Foundation, either version 3 of the License, or'
            . ' (at your option) any later version.</p>'
            . '<p style="text-align:justify">This program is distributed in the hope'
            . ' that it will be useful,'
            . ' but WITHOUT ANY WARRANTY; without even the implied warranty of'
            . ' MERCHAN&shy;TABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the'
            . ' GNU General Public License for more details.</p>'
            . '<p style="text-align:justify">You should have received a copy of the'
            . ' GNU General Public License'
            . ' along with this program.  If not, see'
            . ' <a href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/'
            . '</a>.</p>';
    }

    /**
     * Returns the requirements information view.
     *
     * Must be called in plugin loading stage only.
     *
     * @return string (X)HTML.
     *
     * @global array The paths of system files and folders.
     * @global array The localization of the core.
     * @global array The localization of the plugins.
     */
    protected static function systemCheck()
    {
        global $pth, $tx, $plugin_tx;

        define('PRIVACY_PHP_VERSION', '4.0.7');
        $ptx = $plugin_tx['privacy'];
        $imgdir = $pth['folder']['plugin'] . 'images/';
        $ok = tag('img src="' . $imgdir . 'ok.png" alt="ok"');
        $warn = tag('img src="' . $imgdir . 'warn.png" alt="warning"');
        $fail = tag('img src="' . $imgdir . 'fail.png" alt="failure"');
        $o = '<h4>' . $ptx['syscheck_title'] . '</h4>'
            . (version_compare(PHP_VERSION, PRIVACY_PHP_VERSION) >= 0 ? $ok : $fail)
            . '&nbsp;&nbsp;'
            . sprintf($ptx['syscheck_phpversion'], PRIVACY_PHP_VERSION) . tag('br');
        foreach (array('date', 'pcre') as $ext) {
            $o .= (extension_loaded($ext) ? $ok : $fail)
                . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_extension'], $ext)
                . tag('br');
        }
        $o .= (!get_magic_quotes_runtime() ? $ok : $fail)
            . '&nbsp;&nbsp;' . $ptx['syscheck_magic_quotes'] . tag('br') . tag('br');
        $o .= (strtoupper($tx['meta']['codepage']) == 'UTF-8' ? $ok : $fail)
            . '&nbsp;&nbsp;' . $ptx['syscheck_encoding'] . tag('br');
        $folders = array();
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $pth['folder']['plugin'] . $folder;
        }
        foreach ($folders as $folder) {
            $o .= (is_writable($folder) ? $ok : $warn)
                . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_writable'], $folder)
                . tag('br');
        }
        return $o;
    }

}

?>