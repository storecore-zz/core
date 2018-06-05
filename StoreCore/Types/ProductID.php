<?php
namespace StoreCore\Types;

/**
 * Product ID
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   1.0.0
 */
class ProductID extends MediumintUnsigned
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '1.0.0';

    /**
     * @inheritDoc
     */
    public function __construct($initial_value, $strict = true)
    {
        parent::__construct($initial_value, $strict);
        if ($this->Value < 1) {
            throw new \DomainException();
        }
    }
}
