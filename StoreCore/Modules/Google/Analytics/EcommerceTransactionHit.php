<?php
namespace Google\Analytics;

/**
 * Google Analytics E-commerce Transaction Hit
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2016–2018 StoreCore™
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\BI
 * @version   0.1.0
 */
class EcommerceTransactionHit extends Hit
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
        $this->setHitType(parent::HIT_TYPE_TRANSACTION);
    }

    /**
     * Set the transaction affiliation (ta).
     *
     * @param mixed $transaction_affiliation
     *   Affiliation or store name.
     *
     * @return void
     */
    public function setTransactionAffiliation($transaction_affiliation)
    {
        $this->Data['ta'] = $transaction_affiliation;
    }

    /**
     * Set the transaction ID (ti).
     *
     * @param mixed $transaction_id
     *
     * @return void
     */
    public function setTransactionID($transaction_id)
    {
        $this->Data['ti'] = strval($transaction_id);
    }

    /**
     * Set the total transaction revenue (tr).
     *
     * @param float $transaction_revenue
     *   The total revenue associated with the transaction.  This value SHOULD
     *   include any shipping or tax costs.
     *
     * @return void
     */
    public function setTransactionRevenue($transaction_revenue)
    {
        $this->Data['tr'] = strval($transaction_id);
    }

    /**
     * Set the transaction shipping costs (ts).
     *
     * @param float $transaction_revenue
     *   The total shipping cost of the transaction.
     *
     * @return void
     */
    public function setTransactionShipping($transaction_shipping)
    {
        $this->Data['ts'] = $transaction_shipping;
    }

    /**
     * Set the transaction tax (tt).
     *
     * @param float $transaction_revenue
     *   The total tax of the transaction.
     *
     * @return void
     */
    public function setTransactionTax($transaction_tax)
    {
        $this->Data['tt'] = $transaction_tax;
    }
}
