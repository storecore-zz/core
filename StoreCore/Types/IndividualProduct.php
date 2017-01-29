<?php
namespace StoreCore\Types;

/**
 * Schema.org Product
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/IndividualProduct
 * @version   0.1.0
 */
class IndividualProduct extends Product
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('IndividualProduct');
    }

    /**
     * Set the product's serial number.
     *
     * @param string $serial_number
     * @return $this
     * @see http://schema.org/serialNumber
     */
    public function setSerialNumber($serial_number)
    {
        $this->Data['serialNumber'] = $serial_number;
        return $this;
    }
}
