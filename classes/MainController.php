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

use Privacy\Infra\Request;
use Privacy\Infra\Response;
use Privacy\Infra\View;
use Privacy\Value\Html;

class MainController
{
    /** @var int */
    private $duration;

    /** @var string */
    private $message;

    /** @var View */
    private $view;

    public function __construct(int $duration, string $message, View $view)
    {
        $this->duration = $duration;
        $this->message = $message;
        $this->view = $view;
    }

    public function __invoke(Request $request): Response
    {
        if (isset($_POST["privacy_agree"])) {
            return $this->submitAction($request);
        } else {
            return $this->defaultAction($request);
        }
    }

    private function defaultAction(Request $request): Response
    {
        if (!isset($_COOKIE['privacy_agreed'])) {
            return Response::create($this->view->render("privacy", ["message" => Html::from($this->message)]));
        }
        return Response::create();
    }

    private function submitAction(Request $request): Response
    {
        $response = Response::redirect($this->getLocationURL($request->queryString()));
        if ($_POST['privacy_agree'] === 'yes') {
            $response = $response->withCookie("privacy_agreed", "yes", $this->getExpirationTime($request->time()));
        } else {
            $response = $response->withCookie("privacy_agreed", "no", 0);
        }
        return $response;
    }

    private function getExpirationTime(int $now): int
    {
        return $this->duration > 0
            ? $now + 24 * 60 * 60 * $this->duration
            : 0;
    }

    private function getLocationURL(string $queryString): string
    {
        $url = CMSIMPLE_URL;
        if ($queryString !== "") {
            $url .= "?" . $queryString;
        }
        return $url;
    }
}
