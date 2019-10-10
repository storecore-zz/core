<?php
namespace StoreCore\Database;

use StoreCore\Types\CartID;
use StoreCore\Database\Order;

/**
 * Cart Model
 *
 * In the StoreCore business logic, a shopping cart is an incomplete order.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Cart extends Order
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var \StoreCore\Types\CartID|null $CartID
     *   Shopping cart identifier or null if the cart identifier does not exist.
     */
    protected $CartID;

    /**
     * Get the shopping cart ID.
     *
     * @param void
     *
     * @return \StoreCore\Types\CartID|null
     *   Returns a cart identifier data object or null if the cart has no cart
     *   identifier.
     */
    public function getCartID()
    {
        return $this->CartID;
    }

    /**
     * Set the shopping cart ID.
     *
     * @param \StoreCore\Types\CartID|null
     *   Cart identifier data object.
     *
     * @return void
     */
    public function setCartID(CartID $cart_id)
    {
        $this->CartID = $cart_id;
    }
}
