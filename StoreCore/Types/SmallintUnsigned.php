<?php
namespace StoreCore\Types;

/**
 * Unsigned Small Integer
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015, 2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 *
 * @see https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
 *      Integer Types (Exact Value) in the MySQL 8.0 Reference Manual 
 */
class SmallintUnsigned implements TypeInterface, StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var int $Value
     *   Current value of the integer.
     */
    protected $Value;

    /**
     * Construct an unsigned small integer.
     *
     * @param int|mixed $initial_value
     *   Initial value of the integer.
     *
     * @param bool $strict
     *   Enforce strict type handling (default true) or not (false).
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the initial value is not
     *   an integer (in strict mode) or cannot be converted to an integer (if
     *   the strict mode is disabled).
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
        } elseif ($initial_value > 65535) {
            throw new \DomainException();
        }

        $this->Value = (int)$initial_value;
    }

    /**
     * Convert the data object to a numeric string.
     *
     * @param void
     *
     * @return string
     *   Returns the current integer value as a numeric string.
     */
    public function __toString()
    {
        return (string)$this->Value;
    }
}
