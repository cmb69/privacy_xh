<?php

/**
 * Front-End of Privacy_XH.
 *
 * Copyright (c) 2012 Christoph M. Becker (see license.txt)
 */


if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}


define('PRIVACY_VERSION', '1beta1');


if (!defined('XH_ADM')) {
    define('XH_ADM', $adm);
}

if (!defined('CMSIMPLE_URL')) {
    define('CMSIMPLE_URL', 'http'
        . (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 's' : '')
        . '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']
        . preg_replace('/index.php$/', '', $_SERVER['PHP_SELF']));
}


/**
 * Handles the privacy agreement.
 *
 * @return  mixed
 */
function Privacy()
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
            . tag('input type="submit" class="submit" name="privacy_submit" value="'
                  . $ptx['button'] . '"')
            . '</form>'
            . '<script type="text/javascript">/* <![CDATA[ */'
            . 'if (typeof navigator.cookieEnabled != "undefined" && !navigator.cookieEnabled)'
            . ' document.forms.privacy.style.display="none"'
            . '/* ]]> */</script>';
    }
}


/**
 * Returns the result of calling $func with the variable arguments,
 * if the user already opted in. Otherwise doesn't call $func and returns ''.
 *
 * @param   string  $func  The name of the function.
 * @return  mixed
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
