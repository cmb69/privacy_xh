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

namespace Privacy;

class ShowInfo
{
    /** @var string */
    private $pluginFolder;

    /** @var array<string> */
    private $lang;

    /**
     * @param array<string> $lang
     */
    public function __construct(string $pluginFolder, array $lang)
    {
        $this->pluginFolder = $pluginFolder;
        $this->lang = $lang;
    }

    public function __invoke(): string
    {
        $view = new View("{$this->pluginFolder}views", $this->lang);
        $systemCheckService = new SystemCheckService($this->pluginFolder, $this->lang);
        return $view->render("info", [
            "version" => Plugin::VERSION,
            "checks" => $systemCheckService->getChecks(),
        ]);
    }
}
