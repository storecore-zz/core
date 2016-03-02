<?php
namespace StoreCore\Types;

/**
 * E-mail Address
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0-alpha.1
 */
class EmailAddress extends Varchar implements TypeInterface
{
    const VERSION = '0.1.0-alpha.1';

    /**
     * @param string $initial_value
     * @param bool $strict
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function __construct($initial_value, $strict = true)
    {
        parent::__construct($initial_value, $strict);

        // Assume we need at least 3 characters for an 'x@y' string
        if (mb_strlen($this->Value) < 3) {
            throw new \DomainException();
        }

        // Check for the last '@' at-sign position
        $pos = mb_strrpos($this->Value, '@');
        if ($pos === false) {
            throw new \InvalidArgumentException();
        }

        if (!filter_var($this->Value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException();
        }

        $local_address  = mb_substr($this->Value, 0, $pos);
        $server_address = mb_substr($this->Value, $pos + 1);
        $server_address = mb_strtolower($server_address);

        if ($strict) {
            $strlen = mb_strlen($local_address);
            if ($strlen < 1 || $strlen > 64) {
                throw new \UnexpectedValueException();
            }

            $strlen = mb_strlen($server_address);
            if ($strlen < 1 || $strlen > 255) {
                throw new \UnexpectedValueException();
            }
        }

        $this->Value = $local_address . '@' . $server_address;
    }
}
