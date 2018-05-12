<?php
namespace StoreCore\Types;

/**
 * Unsigned Tiny Integer
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class TinyintUnsigned implements StringableInterface, TypeInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '1.0.0';

    /**
     * @var string $Value
     *   Current value of the value object.
     */
    protected $Value;

    /**
     * @param int $initial_value
     * @param bool $strict
     * @return void
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    public function __construct($initial_value, $strict = true)
    {
        if ($strict && !is_int($initial_value)) {
            throw new \InvalidArgumentException();
        } elseif (!is_numeric($initial_value)) {
            throw new \InvalidArgumentException();
        }

        if ($initial_value < 0) {
            throw new \DomainException();
        } elseif ($initial_value > 255) {
            throw new \DomainException();
        }

        $this->Value = (int)$initial_value;
    }

    /**
     * Convert the data object to a string.
     *
     * @param void
     *
     * @return string
     *   Returns the unsigned integer as a numeric string.  This basic
     *   implementation of the `StringableInterface` for casting data objects
     *   to strings MAY be overwritten by extending classes.
     */
    public function __toString()
    {
        return (string)$this->Value;
    }
}
