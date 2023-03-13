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
        return new self;
    }

    public function privacyAction(): string
    {
        $post = $this->post();
        if (!isset($post["privacy_agree"]) || !is_string($post["privacy_agree"])) {
            return "";
        }
        if ($post["privacy_agree"] === "yes") {
            return "consent";
        }
        return "decline";
    }

    /** @codeCoverageIgnore */
    public function isCookieSet(): bool
    {
        return isset($_COOKIE['privacy_agreed']);
    }

    /** @codeCoverageIgnore */
    public function queryString(): string
    {
        return $_SERVER["QUERY_STRING"];
    }

    /** @codeCoverageIgnore */
    public function time(): int
    {
        return (int) $_SERVER["REQUEST_TIME"];
    }

    /**
     * @return array<string,string|array<string>>
     * @codeCoverageIgnore
     */
    protected function post(): array
    {
        return $_POST;
    }

    /** @codeCoverageIgnore */
    public function adm(): bool
    {
        return defined("XH_ADM") && XH_ADM;
    }
}
