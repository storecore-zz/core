<?php
namespace StoreCore\Types;

/**
 * Schema.org Person
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/Person
 * @version   0.1.0
 */
class Person extends Thing
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $SupportedTypes = array(
        'patient' => 'Patient',
        'person' => 'Person',
    );

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('Person');
    }
}
