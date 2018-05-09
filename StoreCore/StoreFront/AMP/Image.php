<?php
namespace StoreCore\StoreFront\AMP;

/**
 * AMP Image <amp-img>
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://www.ampproject.org/docs/reference/components/amp-img
 * @version   0.1.0
 */
class Image extends \StoreCore\StoreFront\Image implements LayoutInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var \StoreCore\StoreFront\AMP\FallbackImage|null $Fallback
     *   Optional AMP fallback image.
     */
    private $Fallback;

    /**
     * @var string $Layout
     *   The `layout` attribute of the `<amp-img>` element.
     */
    protected $Layout = LayoutInterface::LAYOUT_RESPONSIVE;

    /**
     * @var array $SupportedLayouts
     *   Layouts supported by the `<amp-img>` element.
     */
    protected $SupportedLayouts = array(
        LayoutInterface::LAYOUT_FILL,
        LayoutInterface::LAYOUT_FIXED,
        LayoutInterface::LAYOUT_FIXED_HEIGHT,
        LayoutInterface::LAYOUT_FLEX_ITEM,
        LayoutInterface::LAYOUT_NODISPLAY,
        LayoutInterface::LAYOUT_RESPONSIVE,
    );

    /**
     * Get the <amp-img> AMP image element.
     *
     * @param void
     *
     * @return string
     *   Returns the AMP tag `<amp-img …>…</amp-img>` as a string.
     */
    public function __toString()
    {
        $str = '<amp-img alt="' . $this->getAlt() . '" layout="'. $this->getLayout()
            . '" height="' . $this->getHeight() . '" src="' . $this->Source . '" width="'
            . $this->getWidth() . '">';

        if ($this->Fallback !== null) {
            $str .= (string)$this->Fallback;
        }

        $str .= '</amp-img>';
        return $str;
    }

    /**
     * Get the layout attribute.
     *
     * @param void
     *
     * @return string
     *   Returns the string value of the AMP `layout` attribute.  Defaults to
     *   `responsive`: photos and other images are set to `layout="responsive"`
     *   in AMP by default for responsive web design (RWD).
     */
    public function getLayout()
    {
        return $this->Layout;
    }

    /**
     * Add a fallback image.
     *
     * @param \StoreCore\StoreFront\AMP\FallbackImage $amp_fallback_image
     *   AMP fallback image.
     *
     * @return void
     */
    public function setFallback(FallbackImage $amp_fallback_image)
    {
        $this->Fallback = $amp_fallback_image;
    }

    /**
     * Set the layout attribute.
     *
     * @param string $layout
     *   String value for the AMP `layout` attribute.  Must be one of the values
     *   in the `$SupportedLayouts` array.
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
