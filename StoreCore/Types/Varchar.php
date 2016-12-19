<?php
namespace StoreCore\Types;

/**
 * Generic VARCHAR(255) data object.
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class Varchar implements TypeInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

    /** @var string $Value */
    protected $Value;

    /**
     * @param string|mixed $initial_value
     * @param bool $strict
     * @throws \InvalidArgumentException
     * @throws \DomainException
     */
    public function __construct($initial_value, $strict = true)
    {
        if ($strict && !is_string($initial_value)) {
            throw new \InvalidArgumentException();
        } elseif (!is_string($initial_value)) {
            $initial_value = strval($initial_value);
        }

        mb_internal_encoding('UTF-8');
        if (mb_strlen($initial_value) > 255) {
            throw new \DomainException();
        }

        $this->Value = $initial_value;
    }

    /**
     * @param void
     * @return string
     */
    public function __toString()
    {
        return $this->Value;
    }
}
