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

namespace Privacy\Infra;

use Privacy\Value\Html;

class View
{
    /** @var string */
    private $templateFolder;

    /** @var array<string,string> */
    private $lang;

    /**
     * @param array<string,string> $lang
     */
    public function __construct(string $templateFolder, array $lang)
    {
        $this->templateFolder = $templateFolder;
        $this->lang = $lang;
    }

    /**
     * @param mixed $args
     */
    public function text(string $key, ...$args): Html
    {
        return $this->escape(vsprintf($this->lang[$key], $args));
    }

    /**
     * @param array<string,mixed> $data
     */
    public function render(string $template, array $data): string
    {
        extract($data);
        ob_start();
        echo "<!-- {$template} -->", PHP_EOL;
        include "{$this->templateFolder}/{$template}.php";
        return (string) ob_get_clean();
    }

    /**
     * @param Html|scalar $value
     */
    public function escape($value): Html
    {
        if ($value instanceof Html) {
            return $value;
        } else {
            return Html::from(XH_hsc((string) $value));
        }
    }
}
