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

class MainController
{
    /** @var int */
    private $duration;

    /** @var View */
    private $view;

    public function __construct(int $duration, View $view)
    {
        $this->duration = $duration;
        $this->view = $view;
    }

    public function defaultAction(): void
    {
        global $plugin_tx;

        if (!isset($_COOKIE['privacy_agreed'])) {
            echo $this->view->render("privacy", ["message" => new HtmlString($plugin_tx['privacy']['message'])]);
        }
    }

    public function submitAction(): void
    {
        if ($_POST['privacy_agree'] === 'yes') {
            setcookie('privacy_agreed', 'yes', $this->getExpirationTime(), CMSIMPLE_ROOT);
        } else {
            setcookie('privacy_agreed', 'no', 0, CMSIMPLE_ROOT);
        }
        header('Location: ' . $this->getLocationURL(), true, 303);
        exit;
    }

    private function getExpirationTime(): int
    {
        return $this->duration > 0
            ? time() + 24 * 60 * 60 * $this->duration
            : 0;
    }

    private function getLocationURL(): string
    {
        $url = CMSIMPLE_URL;
        if ($_SERVER['QUERY_STRING'] != '') {
            $url .= "?{$_SERVER['QUERY_STRING']}";
        }
        return $url;
    }
}
