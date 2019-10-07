<?php
namespace StoreCore\Database;

use StoreCore\Database\AbstractDataAccessObject;
use StoreCore\Database\CRUDInterface;

/**
 * Order Mapper
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\OML
 * @version   0.1.0
 */
class OrderMapper extends AbstractDataAccessObject implements CRUDInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var string PRIMARY_KEY DAO database table primary key.
     * @var string TABLE_NAME  DAO database table name.
     */
    const PRIMARY_KEY = 'order_id';
    const TABLE_NAME  = 'sc_orders';
}
