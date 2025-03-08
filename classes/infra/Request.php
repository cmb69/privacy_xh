<?php

/**
 * Copyright 2023 Christoph M. Becker
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

namespace Privacy\Infra;

use Plib\Url;

class Request
{
    /** @var Url */
    private $url;

    public static function current(): self
    {
        $that = new self();
        $that->url = new Url(CMSIMPLE_URL, "", []);
        return $that;
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function get(string $key): ?string
    {
        if (!isset($_GET[$key]) || !is_string($_GET[$key])) {
            return null;
        }
        return $_GET[$key];
    }

    public function cookie(string $key): ?string
    {
        if (!isset($_COOKIE[$key]) || !is_string($_COOKIE[$key])) {
            return null;
        }
        return $_COOKIE[$key];
    }

    public function post(string $key): ?string
    {
        if (!isset($_POST[$key]) || !is_string($_POST[$key])) {
            return null;
        }
        return $_POST[$key];
    }

    public function time(): int
    {
        return (int) $_SERVER["REQUEST_TIME"];
    }

    public function admin(): bool
    {
        return defined("XH_ADM") && XH_ADM;
    }
}
