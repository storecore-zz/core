<?php
namespace StoreCore\Types;

/**
 * Schema.org Entry Point
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @see       https://schema.org/EntryPoint
 * @version   0.1.0
 */
class EntryPoint extends Intangible
{
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->setType('EntryPoint');
    }
}
