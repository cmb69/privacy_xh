<?php

/**
 * Copyright 2011-2017 Christoph M. Becker
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

class View
{
    /**
     * @var string
     */
    private $templateFolder;

    /**
     * @var string
     */
    private $templateName;

    /**
     * @var string
     */
    private $templateExt;

    /**
     * @var string
     */
    private $logoPath;

    /**
     * @var bool
     */
    private $xhtml;

    /**
     * @var array
     */
    private $l10n;

    /**
     * @param string $templateName
     */
    public function __construct($templateName)
    {
        global $pth, $cf, $plugin_tx;

        $this->templateFolder = $pth['folder']['plugins'] . 'privacy/views/';
        $this->templateName = $templateName;
        $this->templateExt = '.php';
        $this->logoPath = $pth['folder']['plugins'] . 'privacy/privacy.png';
        $this->imagePath = $pth['folder']['plugins'] . 'privacy/images/';
        $this->xhtml = (bool) $cf['xhtml']['endtags'];
        $this->l10n = $plugin_tx['privacy'];
    }

    /**
     * @return string
     */
    public function render()
    {
        ob_start();
        include $this->getTemplatePath();
        $html = ob_get_clean();
        if (!$this->xhtml) {
            $html = str_replace(' />', '>', $html);
        }
        return $html;
    }

    /**
     * @return string
     */
    private function getTemplatePath()
    {
        return $this->templateFolder . $this->templateName . $this->templateExt;
    }

    /**
     * @param string $key
     * @return string
     */
    private function localize($key)
    {
        return $this->l10n[$key];
    }
}
