<?php

/**
 * Copyright 20122017 Christoph M. Becker
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
    /**
     * @return void
     */
    public function defaultAction()
    {
        global $plugin_tx;

        if (!isset($_COOKIE['privacy_agreed'])) {
            $view = new View('privacy');
            $view->message = new HtmlString($plugin_tx['privacy']['message']);
            $view->render();
        }
    }

    /**
     * @return void
     */
    public function submitAction()
    {
        if (isset($_POST['privacy_agree'])) {
            setcookie('privacy_agreed', 'yes', $this->getExpirationTime(), CMSIMPLE_ROOT);
        }
        header('Location: ' . $this->getLocationURL(), true, 303);
        exit;
    }

    /**
     * @return int
     */
    private function getExpirationTime()
    {
        global $plugin_cf;

        return !empty($plugin_cf['privacy']['duration'])
            ? time() + 24 * 60 * 60 * $plugin_cf['privacy']['duration']
            : 0;
    }

    /**
     * @return string
     */
    private function getLocationURL()
    {
        $url = CMSIMPLE_URL;
        if ($_SERVER['QUERY_STRING'] != '') {
            $url .= "?{$_SERVER['QUERY_STRING']}";
        }
        return $url;
    }
}
