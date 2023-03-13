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

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /** @dataProvider privacyActions */
    public function testPrivacyAction(array $post, string $expected): void
    {
        $sut = $this->sut();
        $sut->method("post")->willReturn($post);
        $action = $sut->privacyAction();
        $this->assertEquals($expected, $action);
    }

    public function privacyActions(): array
    {
        return [
            [[], ""],
            [["privacy_agree" => []], ""],
            [["privacy_agree" => "yes"], "consent"],
            [["privacy_agree" => "no"], "decline"],
        ];
    }

    /** @dataProvider privacyRedirectUrls */
    public function testPrivacyRedirectUrl(string $queryString, string $expected): void
    {
        $sut = $this->sut();
        $sut->method("queryString")->willReturn($queryString);
        $url = $sut->privacyRedirectUrl();
        $this->assertEquals($expected, $url);
    }

    public function privacyRedirectUrls(): array
    {
        return [
            ["", "http://example.com/"],
            ["Page", "http://example.com/?Page"],
            ["Page&privacy_show", "http://example.com/?Page"],
        ];
    }

    public function testPrivacyFormUrl(): void
    {
        $sut = $this->sut();
        $sut->method("sn")->willReturn("/");
        $sut->method("queryString")->willReturn("Page&foo=bar");
        $url = $sut->privacyFormUrl();
        $this->assertEquals("/?Page&foo=bar&privacy_show", $url);
    }

    private function sut(): Request
    {
        return $this->getMockBuilder(Request::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->onlyMethods(["queryString", "post", "sn"])
        ->getMock();
    }
}
