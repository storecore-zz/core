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

    /**
     * Check if an order exists.
     *
     * @param int $order_id
     *   Order number as an integer.
     *
     * @return bool
     *   Returns true if the order exists, otherwise false.
     */
    public function exists($order_id)
    {
        if (!is_int($order_id)) {
            if (ctype_digit($order_id)) {
                $order_id = intval($order_id);
            } else {
                return false;
            }
        }

        if ($order_id < 1) {
            return false;
        }

        $stmt = $this->Database->prepare('SELECT COUNT(order_id) FROM sc_orders WHERE order_id = :order_id');
        $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
        if ($stmt->execute()) {
            $count = $stmt->fetchColumn();
            if ($count == 1) {
                return true;
            }
        }

        return false;
    }
}
