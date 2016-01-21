<?php
namespace StoreCore\Types;

/**
 * Unsigned Tiny Integer
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class TinyintUnsigned implements TypeInterface
{
    const VERSION = '0.1.0';

    /** @var string $Value */
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
     * @param void
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Value;
    }
}
