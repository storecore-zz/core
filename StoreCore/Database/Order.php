<?php
namespace StoreCore\Database;

/**
 * Order Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Order extends \StoreCore\Database\AbstractModel
{
    const VERSION = '0.1.0';

    /**
     * @var \StoreCore\Types\CartID|null $CartID
     *   Shopping cart identifier or null if the cart or order does not exist.
     */
    private $CartID;

    /**
     * @var int|null $CustomerID
     *   Customer identifier or null if the order does not (or not yet) have
     *   a known customer.
     */
    private $CustomerID;

    /**
     * @var int|null $OrderID
     *   Order number, handled as an integer in both SQL and PHP.
     */
    private $OrderID;

    /**
     * @var int $StoreID
     *   Store identifier, defaults to 1 for the default store if no other
     *   store is set.
     */
    private $StoreID = 1;

    /**
     * Count the total number of items in the order or cart.
     *
     * @param void
     * @return int
     */
    public function count()
    {
        if ($this->OrderID === null) {
            return 0;
        }

        $stmt = $this->Connection->prepare('SELECT SUM(units) FROM sc_order_products WHERE order_id = :order_id');
        $stmt->bindParam(':order_id', $this->OrderID, \PDO::PARAM_INT);
        if ($stmt->execute()) {
            $number_of_units = $stmt->fetchColumn();
            return (int)$number_of_units;
        } else {
            return 0;
        }
    }

    /**
     * Create and save a new order.
     *
     * @param int|null $store_id
     * @param int|null $customer_id
     * @return int
     */
    public function create($store_id = null, $customer_id = null)
    {
        if ($store_id !== null) {
            $this->setStoreID($store_id);
        }

        if ($customer_id !== null) {
            $this->setCustomerID($customer_id);
        }

        $cart_id = new \StoreCore\Types\CartID();

        $sql = 'INSERT INTO sc_orders (order_id, store_id, cart_uuid, cart_rand, date_created, customer_id) VALUES (:order_id, :store_id, UUID(), :cart_rand, UTC_TIMESTAMP(), :customer_id)';
        $stmt = $this->Connection->prepare($sql);

        $stmt->bindParam(':store_id', $this->StoreID, \PDO::PARAM_INT);
        $stmt->bindParam(':cart_rand', $cart_id->getToken(), \PDO::PARAM_STR);

        if ($this->CustomerID === null) {
            $stmt->bindParam(':customer_id', $this->CustomerID, \PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':customer_id', $this->CustomerID, \PDO::PARAM_INT);
        }

        $order_id = $this->getRandomOrderID();
        $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
        $stmt->execute();

        $this->OrderID = $order_id;
        $this->CartID = null;

        return $order_id;
    }

    /**
     * Check if an order exists.
     *
     * @param int|null $order_id
     * @return bool
     */
    public function exists($order_id = null)
    {
        if ($order_id !== null) {
            $this->setOrderID($order_id);
        }

        if ($this->OrderID === null) {
            return false;
        }

        $stmt = $this->Connection->prepare('SELECT COUNT(*) FROM sc_orders WHERE order_id = :order_id');
        $stmt->bindParam(':order_id', $this->OrderID, \PDO::PARAM_INT);
        if ($stmt->execute()) {
            $number_of_rows = $stmt->fetchColumn();
            if ($number_of_rows == 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the order number.
     *
     * @param void
     * @return int|null
     */
    public function getOrderID()
    {
        return $this->OrderID;
    }

    /**
     * Get the store identifier.
     *
     * @param void
     * @return \StoreCore\Types\StoreID
     */
    public function getStoreID()
    {
        return new \StoreCore\Types\StoreID($this->StoreID);
    }

    /**
     * Get a new pseudo-random order number.
     *
     * @param void
     * @return int
     */
    private function getRandomOrderID()
    {
        // The INT(10) UNSIGNED maximum is 4294967295 in MySQL
        // and 42949 67295 when split down the middle.
        $new_order_id = mt_rand(0, 42948) . sprintf('%05d', mt_rand(0, 99999));
        $new_order_id = ltrim($new_order_id, '0');
        $new_order_id = (int)$new_order_id;

        if ($this->exists($new_order_id)) {
            $new_order_id = $this->getRandomOrderID();
        }
        return $new_order_id;
    }

    /**
     * Get the shopping cart ID.
     *
     * @param void
     * @return \StoreCore\Types\CartID|null
     */
    public function getCartID()
    {
        if ($this->OrderID === null) {
            return null;
        }

        if ($this->CartID !== null) {
            return $this->CartID;
        }

        $stmt = $this->Connection->prepare('SELECT cart_uuid, cart_rand FROM sc_orders WHERE order_id = :order_id');
        $stmt->bindParam(':order_id', $this->OrderID, \PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->CartID = new \StoreCore\Types\CartID($row['cart_uuid'], $row['cart_rand']);
        return $this->CartID;
    }

    /**
     * Set the customer identifier.
     *
     * @param int $customer_id
     * @return void
     */
    public function setCustomerID($customer_id)
    {
        $this->CustomerID = $customer_id;
    }

    /**
     * Set the order number.
     *
     * @param int $order_id
     * @return void
     */
    public function setOrderID($order_id)
    {
        $this->OrderID = $order_id;
    }

    /**
     * Set the store identifier.
     *
     * @param \StoreCore\Types\StoreID $order_id
     * @return void
     */
    public function setStoreID(\StoreCore\Types\StoreID $store_id)
    {
        $store_id = (string)$store_id;
        $this->StoreID = (int)$store_id;
    }
}
