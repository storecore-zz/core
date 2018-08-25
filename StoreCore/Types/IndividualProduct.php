<?php
namespace StoreCore\Types;

/**
 * Schema.org Product
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/IndividualProduct
 * @version   0.1.0
 */
class IndividualProduct extends Product
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('IndividualProduct');
    }

    /**
     * Set the product’s serial number.
     *
     * @param string|mixed $serial_number
     *   The serial number or any alphanumeric identifier of a particular
     *   product.  If the provided serial number is not a string (but an
     *   integer for example), it is converted to a string.
     *
     * @return void
     *
     * @see https://schema.org/serialNumber
     */
    public function setSerialNumber($serial_number)
    {
        if (!is_string($serial_number)) {
            $serial_number = strval($serial_number);
        }
        $this->Data['serialNumber'] = $serial_number;
    }
}
