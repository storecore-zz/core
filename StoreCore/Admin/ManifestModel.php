<?php
namespace StoreCore\Admin;

/**
 * Administration Web App Manifest Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 *
 * @see https://www.w3.org/TR/appmanifest/
 *      W3C Web App Manifest
 *
 * @see https://developer.chrome.com/extensions/manifest
 *      Google Chrome Manifest File Format
 */
class ManifestModel extends \StoreCore\AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var int MANIFEST_VERSION
     *   Required `manifest_version` manifest field.  Defaults to 2.
     */
    const MANIFEST_VERSION = 2;

    /**
     * @var string $BackgroundColor
     *   Background color the web app.  Defaults to #9ccc65 for Material Design
     *   Light Green 400.
     */
    private $BackgroundColor = '#9ccc65';

    /**
     * @var string $Name
     *   Name of the web app, defaults to 'StoreCore'.
     */
    private $Name = 'StoreCore';

    /**
     * @var string|null $ShortName
     *   Optional short name of the web app.
     */
    private $ShortName;

    /**
     * @var string $ThemeColor
     *   Default theme color for an application context.  Defaults to #33691e
     *   for Material Design Light Green 900.
     */
    private $ThemeColor = '#33691e';

    /**
     * Get the splash screen background color.
     *
     * @param void
     *
     * @return void
     *   Returns the background color as a CSS color string value.
     */
    public function getBackgroundColor()
    {
        return $this->BackgroundColor;
    }

    /**
     * Get the name of the web app.
     *
     * @param void
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Get the short name of the web app.
     *
     * @param void
     * @return string
     */
    public function getShortName()
    {
        return (string)$this->ShortName;
    }

    /**
     * Get the main theme color of the web app.
     *
     * @param void
     * @return string
     */
    public function getThemeColor()
    {
        return $this->ThemeColor;
    }

    /**
     * Set the splash screen background color.
     *
     * @param string $background_color
     *   Temporary CSS color value.
     *
     * @return void
     */
    public function setBackgroundColor($background_color)
    {
        $this->BackgroundColor = $background_color;
    }

    /**
     * Set the web app name and an optional short name.
     *
     * @param string $name
     *   Name of the web app.

     * @param string|null $short_name
     *   Optional short name of the web app.
     *
     * @return void
     */
    public function setName($name, $short_name = null)
    {
        $this->Name = $name;
        if ($short_name !== null) {
            $this->ShortName = $short_name;
        }
    }

    /**
     * Set web app theme color.
     *
     * @param string $theme_color
     *   CSS color value.
     *
     * @return void
     */
    public function setThemeColor($theme_color)
    {
        $this->ThemeColor = $theme_color;
    }
}
