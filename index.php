<?php

/**
 * Back-end of Schedule_XH.
 *
 * PHP versions 4 and 5
 *
 * @category  CMSimple_XH
 * @package   Privacy
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2014 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Privacy_XH
 */

if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * The plugin version number.
 */
define('PRIVACY_VERSION', '1beta1');

if (!defined('XH_ADM')) {
    define('XH_ADM', $adm);
}

if (!defined('CMSIMPLE_URL')) {
    define(
        'CMSIMPLE_URL', 'http'
        . (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 's' : '')
        . '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']
        . preg_replace('/index.php$/', '', $_SERVER['PHP_SELF'])
    );
}

/**
 * Handles the privacy agreement.
 *
 * @return mixed
 *
 * @global array The configuration of the core.
 * @global array The configuration of the plugins.
 */
function privacy()
{
    global $plugin_cf, $plugin_tx;
    
    if (XH_ADM) {
        return;
    }
    
    $pcf = $plugin_cf['privacy'];
    $ptx = $plugin_tx['privacy'];
    
    if (isset($_POST['privacy_submit'])) {
        if (isset($_POST['privacy_agree'])) {
            $duration = !empty($pcf['duration'])
                ? time() + 24 * 60 * 60 * $pcf['duration']
                : 0;
            setcookie('privacy_agreed', 'yes', $duration, CMSIMPLE_ROOT);
        }
        $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
        header('Location: ' . CMSIMPLE_URL . $qs, true, 303);
        exit;
    }
    
    if (!isset($_COOKIE['privacy_agreed'])) {
        return '<form id="privacy" name="privacy" action="" method="POST">'
            . $ptx['message']
            . tag('input type="checkbox" id="privacy_agree" name="privacy_agree"')
            . '<label for="privacy_agree">' . $ptx['checkbox'] . '</label>'
            . tag(
                'input type="submit" class="submit" name="privacy_submit" value="'
                . $ptx['button'] . '"'
            )
            . '</form>'
            . '<script type="text/javascript">/* <![CDATA[ */'
            . 'if (typeof navigator.cookieEnabled != "undefined"'
            . ' && !navigator.cookieEnabled)'
            . ' document.forms.privacy.style.display="none"'
            . '/* ]]> */</script>';
    }
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

?>
