<?php
namespace StoreCore\Types;

/**
 * Store Identifier
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class StoreID extends TinyintUnsigned implements TypeInterface
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function __construct($initial_value = 1, $strict = true)
    {
        parent::__construct($initial_value, $strict);
        if ($initial_value < 1) {
            throw new \DomainException();
        }
    }
}
