<?php
namespace StoreCore\StoreFront;

/**
 * Google Analytics E-commerce Item Hit
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @version   0.1.0
 */
class GoogleAnalyticsEcommerceItemHit extends GoogleAnalyticsHit
{
    /** @var string VERSION Semantic Version (SemVer) */
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
     * @return $this
     */
    public function setItemCategory($item_category)
    {
        $this->Data['iv'] = $item_category;
        return $this;
    }

    /**
     * Set the SKU or item code (ic).
     *
     * @param string $item_code
     * @return $this
     */
    public function setItemCode($item_code)
    {
        $this->Data['ic'] = $item_code;
        return $this;
    }

    /**
     * Set the item name (in).
     *
     * @param string $item_name
     *   The name of the product or service.  This is the only parameter that
     *   is required for the 'item' hit type.
     *
     * @return $this
     */
    public function setItemName($item_name)
    {
        $this->Data['in'] = $item_name;
        return $this;
    }

    /**
     * Set the item price (ip).
     *
     * @param float $item_price
     * @return $this
     */
    public function setItemPrice($item_price)
    {
        $this->Data['ip'] = $item_price;
        return $this;
    }

    /**
     * Set the item quantity (iq).
     *
     * @param int $item_quantity
     * @return $this
     */
    public function setItemQuantity($item_quantity)
    {
        $this->Data['iq'] = $item_quantity;
        return $this;
    }
}
