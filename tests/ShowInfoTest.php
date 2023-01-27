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

use function XH_includeVar;

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;

class ShowInfoTest extends TestCase
{
    public function testRendersPluginInfo(): void
    {
        $systemChecker = $this->createStub(SystemChecker::class);
        $systemChecker->method('checkVersion')->willReturn(true);
        $systemChecker->method('checkWritability')->willReturn(true);
        $plugin_tx = XH_includeVar("./languages/en.php", "plugin_tx");
        assert(is_array($plugin_tx));
        $subject = new ShowInfo("./", $plugin_tx['privacy'], $systemChecker);

        $response = $subject();

        Approvals::verifyString($response);
    }
}
