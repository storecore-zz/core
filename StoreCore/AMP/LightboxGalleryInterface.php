<?php
namespace StoreCore\AMP;

/**
 * AMP Lightbox Gallery Interface
 *
 * The AMP HTML `lightbox` attribute allows for AMP components like `<amp-img>`
 * and `<amp-carousel>` to be used as an image lightbox or image gallery.  This
 * interface implements a `setLightbox()` method to enable or disable the
 * `lightbox` attribute and a boolean `isLightbox()` method to check the
 * current state.
 *
 * @api
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://amp.dev/documentation/components/amp-lightbox-gallery
 * @version   1.0.0
 */
interface LightboxGalleryInterface
{
    /**
     * Check the AMP lightbox attribute.
     *
     * @param void
     *
     * @return bool
     *   Returns true if the AMP `lightbox` attribute is set, otherwise false.
     */
    public function isLightbox();

    /**
     * Set the AMP lightbox attribute.
     *
     * @param bool $lightbox
     *   Enable the AMP `lightbox` attribute (default true) or disable the
     *   `lightbox` attribute (false).
     *
     * @return void
     */
    public function setLightbox($lightbox = true);
}
