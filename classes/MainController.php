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
    /** @var array<string,string> */
    private $conf;

    /** @var string */
    private $message;

    /** @var View */
    private $view;

    /** @param array<string,string> $conf */
    public function __construct(array $conf, string $message, View $view)
    {
        $this->conf = $conf;
        $this->message = $message;
        $this->view = $view;
    }

    public function __invoke(Request $request): Response
    {
        if ($request->adm()) {
            return Response::create();
        }
        switch ($request->privacyAction()) {
            default:
                return $this->show($request);
            case "consent":
                return $this->consent($request);
            case "decline":
                return $this->decline($request);
        }
    }

    private function show(Request $request): Response
    {
        if ($request->isCookieSet()) {
            return Response::create();
        }
        return Response::create($this->view->render("privacy", ["message" => Html::from($this->message)]));
    }

    private function consent(Request $request): Response
    {
        $response = Response::redirect($this->getLocationURL($request->queryString()));
        $response = $response->withCookie("privacy_agreed", "yes", $this->getExpirationTime($request->time()));
        return $response;
    }

    private function decline(Request $request): Response
    {
        $response = Response::redirect($this->getLocationURL($request->queryString()));
        $response = $response->withCookie("privacy_agreed", "no", 0);
        return $response;
    }

    private function getExpirationTime(int $now): int
    {
        return (int) $this->conf["duration"] > 0
            ? $now + 24 * 60 * 60 * (int) $this->conf["duration"]
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
