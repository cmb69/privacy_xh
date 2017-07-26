<?php

/**
 * The plugin controller.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Privacy
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2017 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Privacy_XH
 */

/**
 * The plugin controller.
 *
 * @category CMSimple_XH
 * @package  Privacy
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Privacy_XH
 */
class Privacy_Controller
{
    const OKAY = 0;

    const WARN = 1;

    const FAIL = 2;

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
            $o .= self::renderAboutView() . self::renderSystemCheck();
            break;
        default:
            $o .= plugin_admin_common($action, $admin, 'privacy');
        }
    }

    /**
     * Returns the about information view.
     *
     * @return string (X)HTML.
     */
    protected static function renderAboutView()
    {
        $view = new Privacy_View('about');
        return $view->render();
    }

    /**
     * Returns the requirements information view.
     *
     * @return string (X)HTML.
     *
     * @global array The localization of the plugins.
     */
    protected static function renderSystemCheck()
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
     * Renders a status icon.
     *
     * @param int $status A status.
     *
     * @return string (X)HTML.
     *
     * @global array The paths of system files and folders.
     */
    protected static function renderStatusIcon($status)
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
     * Returns the system checks.
     *
     * @return array<string, int>
     *
     * @global array The localization of the core.
     * @global array The localization of the plugins.
     */
    protected static function systemChecks()
    {
        global $tx, $plugin_tx;

        $ptx = $plugin_tx['privacy'];
        $requiredPHPVersion = '5.1.2';
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
     * Returns the folders which should be writable.
     *
     * @return array<string>
     *
     * @global array The paths of system files and folders.
     */
    protected static function getWritableFolders()
    {
        global $pth;

        $folders = array();
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $pth['folder']['plugins'] . 'privacy/' . $folder;
        }
        return $folders;
    }

    /**
     * Handles the privacy agreement.
     *
     * @return mixed
     */
    public static function main()
    {
        if (XH_ADM) {
            return;
        }
        if (isset($_POST['privacy_submit'])) {
            if (isset($_POST['privacy_agree'])) {
                setcookie(
                    'privacy_agreed', 'yes',
                    self::getExpirationTime(), CMSIMPLE_ROOT
                );
            }
            header('Location: ' . self::getLocationURL(), true, 303);
            exit;
        }
        if (!isset($_COOKIE['privacy_agreed'])) {
            return self::renderPrivacyForm();
        }
    }

    /**
     * Returns the expiration time of the cookie.
     *
     * @return int
     *
     * @global array The configuration of the plugins.
     */
    protected static function getExpirationTime()
    {
        global $plugin_cf;

        return !empty($plugin_cf['privacy']['duration'])
            ? time() + 24 * 60 * 60 * $plugin_cf['privacy']['duration']
            : 0;
    }

    /**
     * Returns the URL to relocate after submission of the privacy form.
     *
     * @return string
     */
    protected static function getLocationURL()
    {
        $url = CMSIMPLE_URL;
        if ($_SERVER['QUERY_STRING'] != '') {
            $url .= '?';
        }
        $url .= $_SERVER['QUERY_STRING'];
        return $url;
    }

    /**
     * Renders the privacy form.
     *
     * @return string (X)HTML.
     */
    protected static function renderPrivacyForm()
    {
        $view = new Privacy_View('privacy');
        return $view->render();
    }
}

?>
