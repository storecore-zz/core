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
     * @var int $Height
     *   Required AMP carousel `height` attribute, specifies the carousel
     *   height in pixels.
     */
    private $Height;

    /**
     * @var string $Type
     *   AMP carousel `type` HTML attribute, defaults to `carousel`.
     */
    private $Type = self::TYPE_CAROUSEL;

    /**
     * @var int|null $Width
     *   Optional carousel `width` attribute for a fixed width in pixels.
     *   If the width is not specified, the carousel fills the full width
     *   of the parent container.
     */
    private $Width;

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
     * Set the carousel height.
     *
     * @param int $height_in_pixels
     *   Carousel height in pixels (px).
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the height is not a number.
     *
     * @throws \DomainException
     *   Throws a domain exception if the height is smaller than 1.
     */
    public function setHeight($height_in_pixels)
    {
        if (!is_int($height_in_pixels)) {
            if (is_numeric($height_in_pixels)) {
                $height_in_pixels = (int)$height_in_pixels;
            } else {
                throw new \InvalidArgumentException();
            }
        }

        if ($height_in_pixels < 1) {
            throw new \DomainException();
        }
        $this->Height = $height_in_pixels;
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

    /**
     * Set the carousel width.
     *
     * @param int $width_in_pixels
     *   Carousel width in pixels (px).
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the width is not a number.
     *
     * @throws \DomainException
     *   Throws a domain exception if the width is smaller than 1.
     */
    public function setWidth($width_in_pixels)
    {
        if (!is_int($width_in_pixels)) {
            if (is_numeric($width_in_pixels)) {
                $width_in_pixels = (int)$width_in_pixels;
            } else {
                throw new \InvalidArgumentException();
            }
        }

        if ($width_in_pixels < 1) {
            throw new \DomainException();
        }

        $this->Width = $width_in_pixels;
    }
}
