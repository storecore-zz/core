<?php
namespace StoreCore\Database;

use StoreCore\Database\Order;

/**
 * Wish List Model
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2018–2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class WishList extends Order
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @inheritDoc
     */
    protected $IsWishList = true;
}
