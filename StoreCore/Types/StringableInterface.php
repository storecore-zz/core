<?php
namespace StoreCore\Types;

/**
 * StringableInterface
 *
 * The StoreCore `StringableInterface` core interface is used when an object
 * MAY be represented by a non-empty string.  Implementing classes MUST support
 * the magic method `__toString()` for the string conversion.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2018 StoreCore
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
interface StringableInterface
{
    /**
     * Get a string representation of the object.
     *
     * @param void
     * @return string
     */
    public function __toString();
}
