<?php
namespace StoreCore\Types;

/**
 * Store Identifier
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2015-2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class StoreID extends TinyintUnsigned implements TypeInterface
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '1.0.0';

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
