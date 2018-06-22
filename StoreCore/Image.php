<?php
namespace StoreCore;

/**
 * HTML Image.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2017–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class Image
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var string $Alt
     *   Alternative text for the `alt` attribute of an `<img>` tag.
     *   Defaults to an empty string.
     */
    private $Alt = '';

    /**
     * @var int|null $Height
     *   Image height in pixels.
     */
    private $Height;

    /**
     * @var string $Source
     *   Image file URL for the `src` attribute of the `<img>`.  Defaults to
     *   a data URI for a 1×1 transparent pixel.
     */
    protected $Source = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    /**
     * @var int|null $Width
     *   Image width in pixels.
     */
    private $Width;

    /**
     * Convert the image object to an image HTML tag.
     *
     * @param void
     *
     * @return string
     *   Returns the image as a string with an HTML5 `<img>` tag.
     */
    public function __toString()
    {
        $str  = '<img';
        $str .= ' alt="'. htmlentities($this->getAlt()) . '"';

        if ($this->getHeight() !== null) {
            $str .= ' height="' . $this->getHeight() . '"';
        }

        $str .= ' src="' . $this->Source . '"';

        if ($this->getWidth() !== null) {
            $str .= ' width="' . $this->getWidth() . '"';
        }

        $str .= '>';
        return $str;
    }

    /**
     * Get the image alt attribute.
     *
     * @param void
     *
     * @return string
     *   Returns the alternative text from the `alt` attribute of an image.
     */
    public function getAlt()
    {
        return $this->Alt;
    }

    /**
     * Get the image height.
     *
     * @param void
     *
     * @return int|null
     *   Returns the image height in pixel as an integer or null if the image
     *   height was not set.
     */
    public function getHeight()
    {
        return $this->Height;
    }

    /**
     * Get the image width.
     *
     * @param void
     *
     * @return int|null
     *   Returns the image width in pixels as an integer or null if the image
     *   width was not set.
     */
    public function getWidth()
    {
        return $this->Width;
    }

    /**
     * Set the image alt attribute.
     *
     * @param string $alternative_text
     *   Alternative text for the `alt` attribute.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws a Standard PHP Library (SPL) invalid argument logic exception
     *   if the alternative text is not a string.
     */
    public function setAlt($alternative_text)
    {
        if (!is_string($alternative_text)) {
            throw new \InvalidArgumentException();
        }

        $alternative_text = strip_tags($alternative_text);
        $alternative_text = trim($alternative_text);
        $this->Alt = $alternative_text;
    }

    /**
     * Set the image height.
     *
     * @param int $height_in_pixels
     *   Image height in pixels (px).
     *
     * @return void
     *
     * @throws \DomainException
     *   Throws a domain exception if the height is smaller than 1 or greater
     *   than 2160, the default height of a 3840 × 2160 Ultra HD (UHD-1) or
     *   “4K” image.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the height is not a number.
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

        if ($height_in_pixels < 1 || $height_in_pixels > 2160) {
            throw new \DomainException();
        }

        $this->Height = $height_in_pixels;
    }

    /**
     * Set the image URL.
     *
     * @param $image_url
     *   URL of the image file for the `src` attribute.
     *
     * @return void
     */
    public function setSource($image_url)
    {
        if (!is_string($image_url)) {
            throw new \InvalidArgumentException();
        }

        $image_url = filter_var($image_url, FILTER_SANITIZE_URL);
        $this->Source = $image_url;
    }
    
    /**
     * Set the image width.
     *
     * @param int $width_in_pixels
     *   Image width in pixels (px).
     *
     * @return void
     *
     * @throws \DomainException
     *   Throws a domain exception if the width is smaller than 1 or greater
     *   than 3840, the default width of a 3840 × 2160 Ultra HD image.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the width is not a number.
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

        if ($width_in_pixels < 1 || $width_in_pixels > 3840) {
            throw new \DomainException();
        }

        $this->Width = $width_in_pixels;
    }
}
