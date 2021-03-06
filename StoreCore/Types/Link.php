<?php
namespace StoreCore\Types;

use \Psr\Link\LinkInterface as LinkInterface;

/**
 * PSR-13 compliant readable link object.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://www.w3.org/TR/html5/links.html Links in HTML 5.2
 * @see       https://developer.mozilla.org/en-US/docs/Web/HTML/Element/link <link>: The External Resource Link element
 * @see       https://www.php-fig.org/psr/psr-13/ PSR-13: Link definition interfaces
 * @version   0.1.0
 */
class Link implements LinkInterface, StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var array $Attributes
     *   A key-value list of attributes, where the key is a string and the
     *   value is either a PHP primitive or an array of PHP strings.
     */
    protected $Attributes = array();

    /**
     * @var string $HypertextReference
     *   The address or location this link is pointing to.  In this StoreCore
     *   implementation a link defaults to '.' assuming that an object in
     *   hypertext initially points to its own relative location if no other
     *   location is explicitly set.
     */
    protected $HypertextReference = '.';

    /**
     * @var bool $IsTemplated
     *   True if this link object is templated, otherwise false (default).
     */
    protected $IsTemplated = false;

    /**
     * @var array $Relations
     *   Zero or more relationship types for a link, expressed as an array of
     *   strings.
     */
    protected $Relations = array();

    /**
     * Construct a link object.
     *
     * @param string|null $href
     *   Optional address or location of this link as a string.
     *
     * @param string|rel $href
     *   Optional relation type of this link as a string.
     *
     * @param array|null $attributes
     *   Optional additional attributes of this link as an array.
     */
    public function __construct($href = null, $rel = null, $attributes = null)
    {
        if ($href !== null) {
            $this->setAttribute('href', $href);
            if ($rel !== null) {
                $this->setAttribute('rel', $rel);
                if ($attributes !== null) {
                    foreach ($attributes as $name => $value) {
                        $this->setAttribute($name, $value);
                    }
                }
            }
        }
    }

    /**
     * Generic property setter.
     *
     * @param string $name
     *   Name of the property to set.
     *
     * @param string $name
     *   Value of the property to set.
     *
     * @return void
     *
     * @uses setAttribute()
     */
    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    /**
     * Convert link object to HTML <link> tag.
     *
     * @param void
     *
     * @return string
     *   Converts this Link data object to an HTML `<link>` resource link.
     */
    public function __toString()
    {
        $link = '<link href="' . $this->getHref() . '"';

        if (!empty($this->getRels())) {
            $link .= ' rel="' . implode(' ', $this->getRels()) . '"';
        }

        if (!empty($this->getAttributes())) {
            foreach ($this->getAttributes() as $attribute => $value) {
                $link .= ' ' . $attribute;
                if ($value !== '') {
                    $link .= '="' . (string)$value . '"';
                }
            }
        }

        $link .= '>';
        return $link;
    }

    /**
     * @inheritDoc
     */
    public function getAttributes()
    {
        return $this->Attributes;
    }

    /**
     * @inheritDoc
     */
    public function getHref()
    {
        return $this->HypertextReference;
    }

    /**
     * @inheritDoc
     */
    public function getRels()
    {
        return $this->Relations;
    }

    /**
     * @inheritDoc
     */
    public function isTemplated()
    {
        return $this->IsTemplated;
    }

    /**
     * Generic property setter.
     *
     * @param string $name
     *   Case-insensitive name of the attribute to set.
     *
     * @param mixed $value
     *   Value of the attribute to set.  This parameter MAY explicitly be set
     *   to an empty string for HTML link attributes without values, like
     *   `crossorigin` in conjunction with `rel="preconnect"`.
     *
     * @return void
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/API/Element/setAttribute
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the attribute name is not a
     *   a string or an empty string.
     */
    public function setAttribute($name, $value)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException();
        }

        $name = trim($name);
        if (empty($name)) {
            throw new \InvalidArgumentException();
        }

        $name = strtolower($name);
        if ($name === 'href') {
            $this->HypertextReference = $value;
        } elseif ($name === 'rel') {
            $relations = trim($value);
            $relations = preg_replace('!\s+!', ' ', $relations);
            $relations = explode(' ', $relations);
            foreach ($relations as $relation) {
                $this->Relations[] = $relation;
            }
            $this->Relations = array_unique($this->Relations);
        } else {
            $this->Attributes[$name] = $value;
        }
    }
}
