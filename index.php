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

define('PRIVACY_VERSION', '@PRIVACY_VERSION@');

/**
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
 * @param string $func
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

Privacy\Controller::dispatch();
