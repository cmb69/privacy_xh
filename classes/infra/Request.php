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

class Request
{
    /** @codeCoverageIgnore */
    public static function current(): self
    {
        return new self();
    }

    public function privacyRedirectUrl(): string
    {
        $url = CMSIMPLE_URL;
        $queryString = preg_replace('/&privacy_show(=[^&]*)?/', "", $this->queryString());
        if ($queryString !== "") {
            $url .= "?" . $queryString;
        }
        return $url;
    }

    public function privacyFormUrl(): string
    {
        return $this->sn() . "?" . $this->queryString() . "&privacy_show";
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

    /** @codeCoverageIgnore */
    protected function sn(): string
    {
        global $sn;
        return $sn;
    }

    /** @codeCoverageIgnore */
    protected function queryString(): string
    {
        return $_SERVER["QUERY_STRING"];
    }

    /** @codeCoverageIgnore */
    public function time(): int
    {
        return (int) $_SERVER["REQUEST_TIME"];
    }

    public function post(string $key): ?string
    {
        if (!isset($_POST[$key]) || !is_string($_POST[$key])) {
            return null;
        }
        return $_POST[$key];
    }

    /** @codeCoverageIgnore */
    public function adm(): bool
    {
        return defined("XH_ADM") && XH_ADM;
    }
}
