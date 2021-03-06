<?php
namespace Google\Analytics;

/**
 * Google Analytics E-commerce Item Hit
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @version   0.1.0
 */
class EcommerceItemHit extends Hit
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @param void
     * @return self
     */
    public function __construct()
    {
        $this->setHitType(parent::HIT_TYPE_ITEM);
    }

    /**
     * Set the item category (iv).
     *
     * @param string $item_category
     *   The category that the item belongs to.  Hits may also be assigned to
     *   hierarchical content groups with an optional group index through the
     *   parent GoogleAnalyticsHit::setContentGroup() method.
     *
     * @return void
     */
    public function setItemCategory($item_category)
    {
        $this->Data['iv'] = $item_category;
    }

    /**
     * Set the SKU or item code (ic).
     *
     * @param string $item_code
     *
     * @return void
     */
    public function setItemCode($item_code)
    {
        $this->Data['ic'] = $item_code;
    }

    /**
     * Set the item name (in).
     *
     * @param string $item_name
     *   The name of the product or service.  This is the only parameter that
     *   is required for the 'item' hit type.
     *
     * @return void
     */
    public function setItemName($item_name)
    {
        $this->Data['in'] = $item_name;
    }

    /**
     * Set the item price (ip).
     *
     * @param float $item_price
     *
     * @return void
     */
    public function setItemPrice($item_price)
    {
        $this->Data['ip'] = $item_price;
    }

    /**
     * Set the item quantity (iq).
     *
     * @param int $item_quantity
     *
     * @return void
     */
    public function setItemQuantity($item_quantity)
    {
        $this->Data['iq'] = $item_quantity;
    }
}
