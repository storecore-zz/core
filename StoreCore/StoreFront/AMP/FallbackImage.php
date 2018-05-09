<?php
namespace StoreCore\StoreFront\AMP;

/**
 * AMP Fallback Image
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://www.ampproject.org/docs/guides/responsive/placeholders
 * @version   0.1.0
 */
class FallbackImage extends Image
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Get the AMP fallback image tag.
     *
     * @param void
     *
     * @return string
     *   Returns the string `<amp-img fallback …></amp-img>` for a fallback
     *   image.  A common use case is adding a JPEG fallback image to a WebP
     *   image for browsers that do not support the WebP image file format.
     */
    public function __toString()
    {
        return str_replace('<amp-img ', '<amp-img fallback ', parent::__toString());
    }
}
