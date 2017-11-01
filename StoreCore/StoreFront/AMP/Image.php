<?php
namespace StoreCore\StoreFront\AMP;

/**
 * AMP Image <amp-img>
 *
 * @author    Ward van der Put <ward@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://www.ampproject.org/docs/reference/components/amp-img
 * @version   0.1.0
 */
class Image extends \StoreCore\StoreFront\Image
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string $Layout
     *   The `layout` attribute of the `<amp-img>` element.
     */
    private $Layout = 'responsive';

    /**
     * @var array $SupportedLayouts
     */
    private $SupportedLayouts = array(
        'fill',
        'fixed',
        'fixed-height',
        'flex-item',
        'nodisplay',
        'responsive',
    );

    /**
     * Get the <amp-img> AMP image element.
     *
     * @param void
     * @return string
     */
    public function __toString()
    {
        $str = '<amp-img alt="' . $this->getAlt() . '" layout="'. $this->Layout
            . '" height="' . $this->getHeight() . '" src="' . $this->Source . '" width="'
            . $this->getWidth() . '">';
        return $str;
    }

    /**
     * Set the layout attribute.
     *
     * @param string $layout
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$layout` parameter is not
     *   a string or an unsupported layout.
     */
    public function setLayout($layout)
    {
        if (!is_string($layout)) {
            throw new \InvalidArgumentException();
        }
        $layout = strtolower($layout);

        if (!in_array($layout, $this->SupportedLayouts)) {
            throw new \InvalidArgumentException();
        }

        $this->Layout = $layout;
    }
}
