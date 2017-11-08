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
    /**
     * @var string VERSION
     *   Semantic Version (SemVer)
     */
    const VERSION = '0.1.0';

    /**
     * @var string REQUIRED_SCRIPT
     *   JavaScript source code that MUST be imported in the header for a carousel component.
     */
    const REQUIRED_SCRIPT = '<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>';

    /**
     * @var string TYPE_CAROUSEL
     *   AMP carousel `type="carousel"` attribute (default).
     */
    const TYPE_CAROUSEL = 'carousel';

    /**
     * @var string TYPE_SLIDER
     *   AMP `type="slides"` attribute turns a carousel into a slider.
     */
    const TYPE_SLIDES = 'slides';

    /**
     * @var string $Type
     *   AMP carousel `type` HTML attribute, defaults to `carousel`.
     */
    private $Type = self::TYPE_CAROUSEL;

    /**
     * Create a carousel or slider.
     *
     * @param string $amp_carousel_type
     *   Optional parameter to create a slider instead of a carousel (default).
     *   If set to 'slides' a slider is created, otherwise a 'carousel'.  
     *
     * @return self
     */
    public function __construct($amp_carousel_type = self::TYPE_CAROUSEL)
    {
        $this->setType($amp_carousel_type);
    }
    
    /**
     * Set the carousel type.
     *
     * @param string $amp_carousel_type
     *   Case-insensitive AMP carousel type `carousel` (default) or `slides`.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the carousel type is not
     *   the string value `carousel` or `slides`.
     */
    public function setType($amp_carousel_type)
    {
        if (!is_string($amp_carousel_type)) {
            throw new \InvalidArgumentException();
        }
        $amp_carousel_type = strtolower($amp_carousel_type);

        if ($amp_carousel_type === self::TYPE_CAROUSEL || $amp_carousel_type === self::TYPE_SLIDES) {
            $this->Type = $amp_carousel_type;
        } else {
            throw new \InvalidArgumentException();
        }
    }
}
