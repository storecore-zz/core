<?php
namespace StoreCore\Database;

/**
 * Order Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0-alpha.1
 */
class Order extends \StoreCore\Database\AbstractModel
{
    const VERSION = '0.1.0-alpha.1';

    /**
     * @var int|null $CustomerID
     *   Customer identifier or null if the order does not (or not yet) have
     *   a known customer.
     */
    private $CustomerID;

    /**
     * @var int|null $OrderID
     *   Order number, handled as an integer in both MySQL and PHP.
     */
    private $OrderID;

    /**
     * @var int $StoreID
     *   Store identifier, defaults to 1 for the default store if no other
     *   store is set.
     */
    private $StoreID = 1;

    /**
     * @var string|null $Token
     *   Globally unique identifier consisting of a version ID, a UUID
     *   (universally unique identifier) and a random string.
     */
    private $Token;

    /**
     * Count the total number of items in the order or cart.
     *
     * @api
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
     * @api
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

        $sql = 'INSERT INTO sc_orders (order_id, store_id, cart_uuid, cart_rand, date_created, customer_id) VALUES (:order_id, :store_id, UUID(), :cart_rand, UTC_TIMESTAMP(), :customer_id)';
        $stmt = $this->Connection->prepare($sql);

        $stmt->bindParam(':store_id', $this->StoreID, \PDO::PARAM_INT);

        $cart_rand = $this->getRandomCartString();
        $stmt->bindParam(':cart_rand', $cart_rand, \PDO::PARAM_STR);

        if ($this->CustomerID === null) {
            $stmt->bindParam(':customer_id', $this->CustomerID, \PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':customer_id', $this->CustomerID, \PDO::PARAM_INT);
        }

        $order_id = $this->getRandomOrderID();
        $stmt->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
        $stmt->execute();

        $this->OrderID = $order_id;
        $this->Token = null;
        return $order_id;
    }

    /**
     * Check if an order exists.
     *
     * @api
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
     * @api
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
     * @api
     * @param void
     * @return int|null
     */
    public function getStoreID()
    {
        return $this->StoreID;
    }

    /**
     * Get a random UUID add-on.
     *
     * @internal
     * @param void
     * @return string
     */
    private function getRandomCartString()
    {
        return base_convert(bin2hex(openssl_random_pseudo_bytes(128)), 16, 36);
    }

    /**
     * Get a new random order number.
     *
     * @internal
     * @param void
     * @return int
     */
    private function getRandomOrderID()
    {
        // MySQL INT(11) UNSIGNED maximum is 4294967295
        $max = mt_getrandmax();
        if ($max > 4294967295) {
            $max = 4294967295;
        }

        $new_order_id = mt_rand(1, $max);
        if ($this->exists($new_order_id)) {
            $new_order_id = $this->getRandomOrderID();
        }
        return $new_order_id;
    }

    /**
     * Get the cart token.
     *
     * @api
     * @param void
     * @return string
     */
    public function getToken()
    {
        if ($this->OrderID === null) {
            return null;
        }

        if ($this->Token !== null) {
            return $this->Token;
        }

        $stmt = $this->Connection->prepare('SELECT cart_uuid, cart_rand FROM sc_orders WHERE order_id = :order_id');
        $stmt->bindParam(':order_id', $this->OrderID, \PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        $token = array(
            0 => self::VERSION,
            1 => $row['cart_uuid'],
            2 => $row['cart_rand']
        );
        $token = json_encode($token);
        $token = base64_encode($token);
        $this->Token = $token;
        return $token;
    }

    /**
     * Set the customer identifier.
     *
     * @api
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
     * @api
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
     * @api
     * @param int $order_id
     * @return void
     */
    public function setStoreID($store_id)
    {
        $this->StoreID = $store_id;
    }
}
