<?php
namespace StoreCore\Database;

use StoreCore\Database\AbstractDataAccessObject;
use StoreCore\Database\CRUDInterface;
use StoreCore\Database\Order;
use StoreCore\Database\WishList;

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
        if (!\is_int($order_id)) {
            if (ctype_digit($order_id)) {
                $order_id = \intval($order_id);
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

    /**
     * Get an existing order.
     *
     * @param int $order_id
     *   Unique order number.
     *
     * @return \StoreCore\Database\Order|\StoreCore\Database\WishList|null
     *   Returns an order data object or null if the order does not exist.
     *   This method MAY return a wish list data object for incomplete orders.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument logic exception if the `$order_id`
     *   parameter is not an integer.
     * 
     * @throws \DomainException
     *   Throws a domain exception if the `$order_id` is less than 1.
     */
    public function getOrder($order_id)
    {
        if (!\is_int($order_id)) {
            throw new \InvalidArgumentException();
        }

        if ($order_id < 1) {
            throw new \DomainException();
        }

        $order_data = $this->read($order_id);
        if ($order_data !== false) {
            $order_data = $order_data[0];
            return $this->getOrderObject($order_data);
        } else {
            return null;
        }
    }

    /**
     * Map order data to an order object.
     *
     * @param array $order_data
     *
     * @return \StoreCore\Database\Order|\StoreCore\Database\WishList
     *   Returns a StoreCore order model or wish list model as a data model
     *   object.
     */
    private function getOrderObject(array $order_data)
    {
        if (array_key_exists('wishlist_flag', $order_data) && $order_data['wishlist_flag'] == 1) {
            $object = new WishList($this->Registry);
        } else {
            $object = new Order($this->Registry);
        }

        $object->setOrderID($order_data['order_id']);
        $object->setStoreID($order_data['store_id']);

        return $object;
    }
}
