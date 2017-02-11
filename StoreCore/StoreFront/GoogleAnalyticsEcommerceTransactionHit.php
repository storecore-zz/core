<?php
namespace StoreCore\StoreFront;

/**
 * Google Analytics E-commerce Transaction Hit
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @version   0.1.0
 */
class GoogleAnalyticsEcommerceTransactionHit extends GoogleAnalyticsHit
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * @param void
     * @return self
     */
    public function __construct()
    {
        $this->setHitType(parent::HIT_TYPE_TRANSACTION);
    }

    /**
     * Set the transaction affiliation (ta).
     *
     * @param mixed $transaction_affiliation
     *   Affiliation or store name.
     *
     * @return $this
     */
    public function setTransactionAffiliation($transaction_affiliation)
    {
        $this->Data['ta'] = $transaction_affiliation;
        return $this;
    }

    /**
     * Set the transaction ID (ti).
     *
     * @param mixed $transaction_id
     * @return $this
     */
    public function setTransactionID($transaction_id)
    {
        $this->Data['ti'] = strval($transaction_id);
        return $this;
    }

    /**
     * Set the total transaction revenue (tr).
     *
     * @param float $transaction_revenue
     *   The total revenue associated with the transaction.  This value SHOULD
     *   include any shipping or tax costs.
     *
     * @return $this
     */
    public function setTransactionRevenue($transaction_revenue)
    {
        $this->Data['tr'] = strval($transaction_id);
        return $this;
    }

    /**
     * Set the transaction shipping costs (ts).
     *
     * @param float $transaction_revenue
     *   The total shipping cost of the transaction.
     *
     * @return $this
     */
    public function setTransactionShipping($transaction_shipping)
    {
        $this->Data['ts'] = $transaction_shipping;
        return $this;
    }

    /**
     * Set the transaction tax (tt).
     *
     * @param float $transaction_revenue
     *   The total tax of the transaction.
     *
     * @return $this
     */
    public function setTransactionTax($transaction_tax)
    {
        $this->Data['tt'] = $transaction_tax;
        return $this;
    }
}
