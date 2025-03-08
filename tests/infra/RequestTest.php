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

    /** @dataProvider getData */
    public function testGet(string $name, $value, ?string $expected): void
    {
        $_GET = [$name => $value];
        $sut = $this->sut();
        $this->assertEquals($expected, $sut->get($name));
    }

    public function getData(): array
    {
        return [
            ["foo", "bar", "bar"],
            ["foo", null, null],
            ["foo", [], null],
        ];
    }

    /** @dataProvider postData */
    public function testPost(string $name, $value, ?string $expected): void
    {
        $_POST = [$name => $value];
        $sut = $this->sut();
        $this->assertEquals($expected, $sut->post($name));
    }

    public function postData(): array
    {
        return [
            ["foo", "bar", "bar"],
            ["foo", null, null],
            ["foo", [], null],
        ];
    }

    private function sut(): Request
    {
        return $this->getMockBuilder(Request::class)
        ->disableOriginalConstructor()
        ->disableOriginalClone()
        ->disableArgumentCloning()
        ->disallowMockingUnknownTypes()
        ->onlyMethods(["queryString", "sn"])
        ->getMock();
    }
}
