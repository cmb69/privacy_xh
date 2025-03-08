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

class Response
{
    /** @var string */
    private $output = "";

    /** @var string|null */
    private $location = null;

    /** @var string|null */
    private $title = null;

    /** @var array{string,string,int}|null */
    private $cookie = null;

    public static function create(string $output = ""): self
    {
        $that = new self();
        $that->output = $output;
        return $that;
    }

    public static function redirect(string $location): self
    {
        $that = new self();
        $that->location = $location;
        return $that;
    }

    /** @return string|never */
    public function __invoke()
    {
        global $title;

        if ($this->cookie() !== null) {
            [$name, $value, $expires] = $this->cookie();
            setcookie($name, $value, $expires, CMSIMPLE_ROOT);
        }
        if ($this->location() !== null) {
            while (ob_get_level()) {
                ob_end_clean();
            }
            header("Location: " . $this->location(), true, 303);
            exit;
        }
        if ($this->title() !== null) {
            $title = $this->title();
        }
        return $this->output();
    }

    public function withTitle(string $title): self
    {
        $that = clone $this;
        $that->title = $title;
        return $that;
    }

    public function withCookie(string $name, string $value, int $expires): self
    {
        $that = clone $this;
        $that->cookie = [$name, $value, $expires];
        return $that;
    }

    public function output(): string
    {
        return $this->output;
    }

    public function location(): ?string
    {
        return $this->location;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    /** @return array{string,string,int}|null */
    public function cookie(): ?array
    {
        return $this->cookie;
    }
}
