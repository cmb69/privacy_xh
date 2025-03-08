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
use PHPUnit\Framework\MockObject;
use PHPUnit\Framework\TestCase;
use Plib\Request;
use Plib\Url;
use Plib\View;

class PrivacyTest extends TestCase
{
    public function testRendersPrivacyForm(): void
    {
        $sut = $this->sut($this->conf(), $this->view());
        $response = $sut($this->request());
        Approvals::verifyHtml($response->output());
    }

    public function testRenderPrivacyFormWithNewsboxContent(): void
    {
        $conf = $this->conf();
        $conf["newsbox"] = "Privacy_Message";
        $sut = $this->sut($conf, $this->view());
        $sut->expects($this->once())->method("newsbox")->with("Privacy_Message")
            ->willReturn("<p>some more <b>or</b> less fancy HTML</p>");
        $response = $sut($this->request());
        Approvals::verifyHtml($response->output());
    }

    public function testRendersLinkIfAlreadyAgreed(): void
    {
        $sut = $this->sut($this->conf(), $this->view());
        $request = $this->request();
        $request->method("cookie")->willReturn("yes");
        $response = $sut($request);
        Approvals::verifyHtml($response->output());
    }

    public function testRendersPrivacyFormIfAlreadyAgreedButExplicitlyRequested(): void
    {
        $sut = $this->sut($this->conf(), $this->view());
        $request = $this->request(null, true);
        $request->method("cookie")->willReturn(null);
        $response = $sut($request);
        $this->assertStringEqualsFile(
            __DIR__ . "/approvals/PrivacyTest.testRendersPrivacyForm.approved.html",
            $response->output()
        );
    }

    public function testUserAgrees(): void
    {
        $sut = $this->sut($this->conf(1), $this->view());
        $request = $this->request("yes");
        $response = $sut($request);
        $this->assertEquals(["privacy_agreed", "yes", 86400], $response->cookie());
        $this->assertEquals("http://example.com/?some+query+string", $response->location());
    }

    public function testUserDisagrees(): void
    {
        $sut = $this->sut($this->conf(), $this->view());
        $response = $sut($this->request("decline"));
        $this->assertEquals(["privacy_agreed", "no", 0], $response->cookie());
        $this->assertEquals("http://example.com/?some+query+string", $response->location());
    }

    public function testDoesNothingIfAdmin(): void
    {
        $sut = $this->sut($this->conf(), $this->view());
        $request = $this->request();
        $request->method("admin")->willReturn(true);
        $response = $sut($request);
        $this->assertEquals("", $response->output());
    }

    /** @return Request&MockObject */
    private function request(?string $privacyAgreed = null, $show = false)
    {
        $request = $this->createMock(Request::class);
        $request->method("url")->willReturn(new Url("http://example.com/", "some+query+string", []));
        $request->method("post")->willReturn($privacyAgreed);
        $request->method("get")->willReturn($show ? "" : null);
        return $request;
    }

    private function sut(array $conf, View $view)
    {
        return $this->getMockBuilder(Privacy::class)
            ->setConstructorArgs([$conf, $view])
            ->onlyMethods(["newsbox"])
            ->getMock();
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
