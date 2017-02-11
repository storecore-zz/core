<?php
namespace StoreCore\Types;

/**
 * Schema.org Barcode Image Object
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Barcode
 * @version   0.1.0
 */
class Barcode extends ImageObject
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'barcode' => 'Barcode',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('Barcode');
    }
}
