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

namespace Privacy;

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;
use Privacy\Infra\Request;
use Privacy\Infra\View;

class MainControllerTest extends TestCase
{
    public function testRendersPrivacyForm(): void
    {
        $sut = new MainController($this->conf(), $this->message(), $this->view());
        $response = $sut($this->request());
        Approvals::verifyHtml($response->output());
    }

    public function testDoesNothingIfAlreadyAgreed(): void
    {
        $sut = new MainController($this->conf(), $this->message(), $this->view());
        $request = $this->request();
        $request->method("isCookieSet")->willReturn(true);
        $response = $sut($request);
        $this->assertEquals("", $response->output());
    }

    public function testUserAgrees(): void
    {
        $sut = new MainController($this->conf(1), $this->message(), $this->view());
        $request = $this->request("consent");
        $request->method("queryString")->willReturn("some+query+string");
        $response = $sut($request);
        $this->assertEquals(["privacy_agreed", "yes", 86400], $response->cookie());
        $this->assertEquals("http://example.com?some+query+string", $response->location());
    }

    public function testUserDisagrees(): void
    {
        $sut = new MainController($this->conf(), $this->message(), $this->view());
        $response = $sut($this->request("decline"));
        $this->assertEquals(["privacy_agreed", "no", 0], $response->cookie());
        $this->assertEquals("http://example.com", $response->location());
    }

    public function testDoesNothingIfAdmin(): void
    {
        $sut = new MainController($this->conf(), $this->message(), $this->view());
        $request = $this->request();
        $request->method("adm")->willReturn(true);
        $response = $sut($request);
        $this->assertEquals("", $response->output());
    }

    private function request(string $action = ""): Request
    {
        $request = $this->createMock(Request::class);
        $request->method("privacyAction")->willReturn($action);
        return $request;
    }

    private function message(): string
    {
        return XH_includeVar("./languages/en.php", "plugin_tx")["privacy"]["message"];
    }

    private function view(): View
    {
        return new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["privacy"]);
    }

    private function conf(int $duration = 0): array
    {
        return ["duration" => (string) $duration] + XH_includeVar("./config/config.php", "plugin_cf")["privacy"];
    }
}
