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
 * @see       https://www.php-fig.org/psr/psr-13/ PSR-13: Link definition interfaces
 * @version   0.1.0
 */
class Link implements LinkInterface
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
            $this->set('href', $href);
            if ($rel !== null) {
                $this->set('rel', $href);
                if ($attributes !== null) {
                    $this->set('rel', $href);
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
     * @uses set()
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
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
     *   Value of the attribute to set.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the attribute name is not a
     *   a string or an empty string.
     */
    public function set($name, $value)
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
            $relations = explode(' ', $value);
            foreach ($relations as $relation) {
                $this->Relations[] = $relation;
            }
        } else {
            $this->$Attributes[$name] = $value;
        }
    }
}
