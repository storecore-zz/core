<?php
namespace StoreCore\Database;

use StoreCore\Database\AbstractModel;

use StoreCore\Types\CartID;
use StoreCore\Types\StoreID;

/**
 * Order Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2015–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Order extends AbstractModel implements \Countable
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
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
     * @var StoreCore\Types\StoreID $StoreID
     *   Store identifier.
     */
    private $StoreID;

    /**
     * @var bool $IsWishList
     *   This data model is a wishlist (true) or not (default false).
     */
    protected $IsWishList = false;

    /**
     * Count the total number of items in the order or cart.
     *
     * @param void
     *
     * @return int
     *   Number of distinct items in the cart or order.  If a cart or order
     *   contains 2 apples and 3 bananas, this method will return the
     *   integer 5.
     */
    public function count()
    {
        if ($this->OrderID === null) {
            return 0;
        }

        $stmt = $this->Database->prepare('SELECT SUM(units) FROM sc_order_products WHERE order_id = :order_id');
        $stmt->bindParam(':order_id', $this->OrderID, \PDO::PARAM_INT);
        if ($stmt->execute()) {
            $number_of_units = $stmt->fetchColumn();
            return (int) $number_of_units;
        } else {
            return 0;
        }
    }

    /**
     * Get the shopping cart ID.
     *
     * @param void
     *
     * @return \StoreCore\Types\CartID|null
     *   Returns a cart identifier data object or null if the order has no cart
     *   identifier.
     */
    public function getCartID()
    {
        if ($this->OrderID === null) {
            return null;
        }

        if ($this->CartID !== null) {
            return $this->CartID;
        }

        $stmt = $this->Database->prepare('SELECT cart_uuid, cart_rand FROM sc_orders WHERE order_id = :order_id');
        $stmt->bindParam(':order_id', $this->OrderID, \PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->CartID = new CartID($row['cart_uuid'], $row['cart_rand']);
        return $this->CartID;
    }

    /**
     * Get the order number.
     *
     * @param void
     *
     * @return int|null
     *   Returns the unique order number as an integer or null if the order
     *   does not yet have a number.
     */
    public function getOrderID()
    {
        return $this->OrderID;
    }

    /**
     * Get the store identifier.
     *
     * @param void
     *
     * @return \StoreCore\Types\StoreID
     *   Returns a store identifier data object.
     */
    public function getStoreID()
    {
        if ($this->StoreID === null) {
            $this->setStoreID(new StoreID());
        }
        return $this->StoreID;
    }

    /**
     * Check if this is a wish list.
     *
     * @param void
     * 
     * @return bool
     *   Returns true if this incomplete order is a wishlist, otherwse false.
     */
    public function isWishList()
    {
        return $this->IsWishList();
    }

    /**
     * Set the customer identifier.
     *
     * @param int|string|null $customer_id
     *   Unique customer identifier and customer number.
     *
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
     *   Unique order identifier, used as the primary key for orders.
     *
     * @return void
     */
    public function setOrderID($order_id)
    {
        $this->OrderID = $order_id;
    }

    /**
     * Set the store identifier.
     *
     * @param \StoreCore\Types\StoreID|int $store_id
     *   Store identifier as a data object or integer.
     *
     * @return void
     */
    public function setStoreID($store_id)
    {
        if (!$store_id instanceof StoreID) {
            $store_id = (int) $store_id;
            $store_id = new StoreID($store_id);
        }
        $this->StoreID = $store_id;
    }

    /**
     * Handle the order as a wishlist or not.
     *
     * @param bool $is_wish_list
     *   Turns the order into a wish list (default true) or turns a wish list
     *   into a plain order (false).
     */
    public function setWishList($is_wish_list = true)
    {
        $this->IsWishList = (bool) $is_wish_list;
    }
}
