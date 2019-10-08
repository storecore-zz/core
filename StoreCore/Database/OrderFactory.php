<?php
namespace StoreCore\Database;

use StoreCore\Database\AbstractModel;
use StoreCore\Database\Order;
use StoreCore\Database\OrderMapper;

use StoreCore\Types\StoreID;

/**
 * Order Factory
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class OrderFactory extends AbstractModel
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * Create a new order.
     *
     * @param \StoreCore\Types\StoreID|null $store_id
     *   Optional store identifier.  If omitted, the default store is used.
     *
     * @return \StoreCore\Database\Order
     *   Returns an Order data object for a new order.
     *
     * @throws \InvalidArgumentException
     *   Throws an invalid argument exception if the `$store_id` parameter
     *   is not an instance of \StoreCore\Types\StoreID.
     */
    public function createOrder($store_id = null)
    {
        if ($store_id === null) {
            $store_id = new StoreID();
        }

        if (!$store_id instanceof StoreID) {
            throw new \InvalidArgumentException(
                __METHOD__ . ' expects parameter 1 to be \StoreCore\Types\StoreID, '
                . gettype($store_id) .' given.'
            );
        }

        $order_data = array(
            'order_id' => $this->getRandomOrderID(),
            'store_id' => (int) (string) $store_id,
        );
        $order_mapper = new OrderMapper($this->Registry);
        $order_mapper->create($order_data);
        $order_mapper = null;

        $order = new Order($this->Registry);
        $order->setOrderID($order_data['order_id']);
        $order->setStoreID($order_data['store_id']);

        return $order;
    }

    /**
     * Get a new pseudo-random order number.
     *
     * @param void
     *
     * @return int
     *   Returns a new order number as a random integer that does not yet exist.
     *
     * @uses \StoreCore\Database\OrderMapper::exists()
     *   Uses the `OrderMapper::exists()` method to test if a randomly generated
     *   integer already exists as an order ID in the database.
     */
    private function getRandomOrderID()
    {
        // The INT(10) UNSIGNED maximum is 4294967295 in MySQL
        // and 42949 67295 when split down the middle.
        $new_order_id = mt_rand(0, 42948) . sprintf('%05d', mt_rand(0, 99999));
        $new_order_id = ltrim($new_order_id, '0');
        $new_order_id = (int) $new_order_id;

        $order_mapper = new OrderMapper($this->Registry);
        if ($order_mapper->exists($new_order_id)) {
            $new_order_id = $this->getRandomOrderID();
        }
        return $new_order_id;
    }
}
