<?php
namespace StoreCore\Database;

use StoreCore\Database\AbstractModel;
use StoreCore\Database\Order;
use StoreCore\Database\OrderMapper;
use StoreCore\Database\WishList;

use StoreCore\Types\CartID;
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
     * Create a new cart.
     *
     * @param \StoreCore\Types\StoreID|null $store_id
     *   Optional store identifier.  If omitted, the default store is used.
     *
     * @return \StoreCore\Database\Cart
     *   Returns a Cart data object for a new and empty cart.
     */
    public function createCart($store_id = null)
    {
        $order = $this->createOrder($store_id);
        $order_id = $order->getOrderID();
        unset($order);

        $cart_id = new CartID();
        $cart_token = $cart_id->getToken();
        unset($cart_id);

        $stmt = $this->Database->prepare(' UPDATE sc_orders SET cart_uuid = UUID(), cart_rand = :cart_token WHERE order_id = :order_id');
        $stmt->bindParam(':cart_token', $cart_token, \PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        $mapper = new OrderMapper($this->Registry);
        return $mapper->getOrder($order_id);
    }

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
        } elseif (!$store_id instanceof StoreID) {
            throw new \InvalidArgumentException(
                __METHOD__ . ' expects parameter 1 to be \StoreCore\Types\StoreID, '
                . gettype($store_id) . ' given.'
            );
        }

        $order_id = $this->getRandomOrderID();
        $store_id = (int) (string) $store_id;

        try {
            $mapper = new OrderMapper($this->Registry);
            $mapper->create(['order_id' => $order_id, 'store_id' => $store_id]);
        } catch (\Exception $e) {
            $this->Logger->error('Error creating new order: ' . $e->getMessage());
        }

        $order = new Order($this->Registry);
        $order->setOrderID($order_id);
        $order->setStoreID($store_id);
        return $order;
    }

    /**
     * Create a new wish list.
     *
     * @param \StoreCore\Types\StoreID|null $store_id
     *   Optional store identifier.  If omitted, the default store is used.
     * 
     * @return \StoreCore\Database\WishList
     *   Returns a wish list data object.
     */
    public function createWishList($store_id = null)
    {
        $order = $this->createOrder($store_id);

        $wish_list = new WishList($this->Registry);
        $wish_list->setOrderID($order->getOrderID());
        $wish_list->setStoreID($order->getStoreID());

        $sql = 'UPDATE sc_orders SET wishlist_flag = 1 WHERE order_id = ?';
        $this->Database->prepare($sql)->execute([$wish_list->getOrderID()]);

        return $wish_list;
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
