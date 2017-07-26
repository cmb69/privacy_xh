<?php

/**
 * Back-end of Schedule_XH.
 *
 * PHP versions 4 and 5
 *
 * @category  CMSimple_XH
 * @package   Privacy
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2017 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Privacy_XH
 */

/*
 * Prevent direct access and usage from unsupported CMSimple_XH versions.
 */
if (!defined('CMSIMPLE_XH_VERSION')
    || strpos(CMSIMPLE_XH_VERSION, 'CMSimple_XH') !== 0
    || version_compare(CMSIMPLE_XH_VERSION, 'CMSimple_XH 1.6', 'lt')
) {
    header('HTTP/1.1 403 Forbidden');
    header('Content-Type: text/plain; charset=UTF-8');
    die(<<<EOT
Privacy_XH detected an unsupported CMSimple_XH version.
Uninstall Privacy_XH or upgrade to a supported CMSimple_XH version!
EOT
    );
}

/**
 * The plugin version number.
 */
define('PRIVACY_VERSION', '@PRIVACY_VERSION@');

/**
 * Autoloads the plugin classes.
 *
 * @param string $class A class name.
 *
 * @return void
 *
 * @global array The paths of system files and folders.
 */
function Privacy_autoload($class)
{
    global $pth;

    $parts = explode('\\', $class, 2);
    if ($parts[0] == 'Privacy') {
        include_once $pth['folder']['plugins'] . 'privacy/classes/'
            . $parts[1] . '.php';
    }
}

/**
 * Handles the privacy agreement.
 *
 * @return mixed
 */
function privacy()
{
    return Privacy\Controller::main();
}

/**
 * Returns the result of calling $func with the variable arguments,
 * if the user already opted in. Otherwise doesn't call $func and returns ''.
 *
 * @param string $func A function name.
 *
 * @return mixed
 */
function Privacy_guard($func)
{
    if (!isset($_COOKIE['privacy_agreed'])) {
        return '';
    }
    $args = func_get_args();
    $func = array_shift($args);
    return call_user_func_array($func, $args);
}

spl_autoload_register('Privacy_autoload');
Privacy\Controller::dispatch();

?>
