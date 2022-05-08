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

function privacy(): string
{
    if (XH_ADM) { // @phpstan-ignore-line
        return "";
    }
    $action = isset($_POST['privacy_agree']) ? 'submitAction' : 'defaultAction';
    ob_start();
    (new Privacy\MainController)->$action();
    return (string) ob_get_clean();
}

/**
 * Returns the result of calling $func with the variable arguments,
 * if the user already opted in. Otherwise doesn't call $func and returns ''.
 *
 * @return mixed
 */
function Privacy_guard(string $func)
{
    if (!privacy_agreed()) {
        return '';
    }
    $args = func_get_args();
    $func = array_shift($args);
    return call_user_func_array($func, $args);
}

function privacy_agreed(): bool
{
    return isset($_COOKIE['privacy_agreed']) && $_COOKIE['privacy_agreed'] === 'yes';
}

(new Privacy\Plugin)->run();
