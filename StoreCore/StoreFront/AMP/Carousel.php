<?php
namespace StoreCore\StoreFront\AMP;

/**
 * AMP Carousel <amp-carousel>
 *
 * @author    Ward van der Put <ward@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @see       https://www.ampproject.org/docs/reference/components/amp-carousel
 * @see       https://ampbyexample.com/components/amp-carousel/
 * @version   0.1.0
 */
class Carousel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string REQUIRED_SCRIPT
     *   JavaScript source code that MUST be imported in the header for a carousel component.
     */
    const REQUIRED_SCRIPT = '<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>';
}
