<?php
namespace StoreCore\AMP;

/**
 * AMP Layout Interface
 *
 * This interface describes the Accelerated Mobile Pages (AMP) `layout`
 * attribute for view models.  The interface constants are values that can be
 * used in the `layout` attribute.  The attribute MUST be accessed through the
 * setter and getter `setLayout()` and `getLayout()`.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2017–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://amp.dev/documentation/guides-and-tutorials/develop/style_and_layout/control_layout
 * @see       https://amp.dev/documentation/guides-and-tutorials/learn/amp-html-layout/layouts_demonstrated
 * @version   1.0.0
 */
interface LayoutInterface
{
    /**
     * @var string LAYOUT_CONTAINER
     * @var string LAYOUT_FILL
     * @var string LAYOUT_FIXED
     * @var string LAYOUT_FIXED_HEIGHT
     * @var string LAYOUT_FLEX_ITEM
     * @var string LAYOUT_INTRINSIC
     * @var string LAYOUT_NODISPLAY
     * @var string LAYOUT_RESPONSIVE
     */
    const LAYOUT_CONTAINER    = 'container';
    const LAYOUT_FILL         = 'fill';
    const LAYOUT_FIXED        = 'fixed';
    const LAYOUT_FIXED_HEIGHT = 'fixed-height';
    const LAYOUT_FLEX_ITEM    = 'flex-item';
    const LAYOUT_INTRINSIC    = 'intrinsic';
    const LAYOUT_NODISPLAY    = 'nodisplay';
    const LAYOUT_RESPONSIVE   = 'responsive';

    /**
     * Get the AMP layout attribute.
     *
     * @param void
     *
     * @return string|null
     *   Returns the currently set AMP `layout` attribute as a string.  This
     *   method MAY return null if the `layout` attribute of an AMP component
     *   is not yet set, but MUST return a string if the component has a
     *   default `layout`.
     */
    public function getlayout();

    /**
     * Set the AMP layout attribute.
     *
     * @param string $layout
     *   String value for the AMP layout attribute.
     *
     * @return void
     */
    public function setLayout($layout);
}
