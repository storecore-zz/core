<?php
namespace StoreCore\StoreFront\AMP;

/**
 * AMP Placeholder Image
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://www.ampproject.org/docs/guides/responsive/placeholders
 * @version   0.1.0
 */
class PlaceholderImage extends Image
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string $Layout
     *   The `layout` attribute of a placeholder image in AMP always is `fill`.
     */
    protected $Layout = LayoutInterface::LAYOUT_FILL;

    /**
     * @var array $SupportedLayouts
     *   An AMP placeholder image always fills the parent, so the only supported
     *   layout is `fill`.
     */
    protected $SupportedLayouts = array(
        LayoutInterface::LAYOUT_FILL,
    );

    /**
     * Get the AMP placeholder image tag.
     *
     * @param void
     *
     * @return string
     *   Returns the string `<amp-img placeholder src="…" layout="fill"></amp-img>`
     *   for a placeholder image.  An AMP placeholder image has no `alt` text
     *   and no `width` and `height` dimensions.
     */
    public function __toString()
    {
        return
            '<amp-img placeholder src="' . $this->Source 
            . '" layout="' . $this->getLayout() . '"></amp-img>';
    }
}
