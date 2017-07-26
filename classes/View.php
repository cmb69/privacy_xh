<?php

/**
 * The view classes.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Privacy
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2017 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Privacy_XH
 */

namespace Privacy;

/**
 * The view classes.
 *
 * @category CMSimple_XH
 * @package  Privacy
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Privacy_XH
 */
class View
{
    /**
     * The path of the template folder.
     *
     * @var string
     */
    protected $templateFolder;

    /**
     * The name of the template.
     *
     * @var string
     */
    protected $templateName;

    /**
     * The extension of the template.
     *
     * @var string
     */
    protected $templateExt;

    /**
     * The path of the logo.
     *
     * @var string
     */
    protected $logoPath;

    /**
     * Whether to render XHTML (or HTML).
     *
     * @var bool
     */
    protected $xhtml;

    /**
     * The localization of the plugin.
     *
     * @var array
     */
    protected $l10n;

    /**
     * Initializes a new instance.
     *
     * @param string $templateName A template name.
     *
     * @global array The paths of system files and folders.
     * @global array The configuration of the core.
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
     * Renders the template.
     *
     * @return string (X)HTML.
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
     * Returns the template path.
     *
     * @return string
     */
    protected function getTemplatePath()
    {
        return $this->templateFolder . $this->templateName . $this->templateExt;
    }

    /**
     * Returns the localization of a key.
     *
     * @param string $key A key.
     *
     * @return string
     */
    protected function localize($key)
    {
        return $this->l10n[$key];
    }
}

?>
