<?php
namespace StoreCore\StoreFront;

/**
 * Store Front Product Image
 *
 * @author    Ward van der Put <ward@storecore.org>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class Image
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @var string $Alt
     *   Alternative text for the `alt` attribute of an `<img>` tag.
     *   Defaults to an empty string.
     */
    private $Alt = '';

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
}
