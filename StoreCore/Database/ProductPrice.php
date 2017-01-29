<?php
namespace StoreCore\Database;

/**
 * Product Price
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015-2016 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 *
 * @method bool calculate ( [ int $currency_id = 978 ] )
 * @method void setPrecision ( int $precision )
 * @method void setProductID ( int $product_id )
 */
class ProductPrice extends \StoreCore\Database\AbstractModel
{
    const VERSION = '0.1.0';

    /**
     * @var int $Precision
     *   The number of digits after the decimal place in a price.
     */
    private $Precision = 2;

    /**
     * @var array|null $PriceComponents
     */
    private $PriceComponents;

    /**
     * @var int|null $ProductID
     *   Unique product identifier, used as primary key and foreign key.
     */
    private $ProductID;

    /**
     * Calculate or recalculate the product prices.
     *
     * @param int $currency_id
     *   ISO 4217 currency identifier.  Defaults to 978 for EUR (euro).  This
     *   method only calculates prices using price rules with the same
     *   currency.  For example, it will not subtract a €2 discount in euros
     *   from a $10 base price in dollars.
     *
     * @return bool
     *   Returns true if the product prices were calculated or false if they
     *   were not.
     */
    public function calculate($currency_id = 978)
    {
        if ($this->ProductID === null) {
            return false;
        }

        if ($this->PriceComponents === null) {
            $this->read();
        }

        // Establish a base price and set the list price to the base price.
        $currency_id = (int)$currency_id;
        if (!isset($this->PriceComponents[0][$currency_id])) {
            return false;
        }
        $base_price = $this->PriceComponents[0][$currency_id];
        $list_price = $base_price;

        // Base price plus fixed surcharge
        if (isset($this->PriceComponents[12][$currency_id])) {
            $list_price += $this->PriceComponents[12][$currency_id];
        }

        // Base price plus variable surcharge
        if (isset($this->PriceComponents[13][$currency_id])) {
            $list_price += $this->PriceComponents[13][$currency_id] * $base_price;
        }

        // Base price minus fixed discount
        if (isset($this->PriceComponents[14][$currency_id])) {
            $list_price -= $this->PriceComponents[14][$currency_id];
        }

        // Base price minus variable discount
        if (isset($this->PriceComponents[15][$currency_id])) {
            $list_price -= $this->PriceComponents[15][$currency_id] * $base_price;
        }

        // Check minimum and maximum price
        if (
            isset($this->PriceComponents[10][$currency_id])
            && $list_price < $this->PriceComponents[10][$currency_id]
        ) {
            $list_price = $this->PriceComponents[10][$currency_id];
        } elseif (
            isset($this->PriceComponents[11][$currency_id])
            && $list_price < $this->PriceComponents[11][$currency_id]
        ) {
            $list_price = $this->PriceComponents[11];
        }

        // Store the calculated list price
        $list_price = round($list_price, $this->Precision);
        $this->PriceComponents[254][$currency_id] = $list_price;

        // Calculate an ON SALE price
        if (isset($this->PriceComponents[240][$currency_id])) {
            $this->PriceComponents[255][$currency_id] = $list_price - $this->PriceComponents[240][$currency_id];
        } elseif (isset($this->PriceComponents[241][$currency_id])) {
            $this->PriceComponents[255][$currency_id] = (1 - $this->PriceComponents[241][$currency_id]) * $list_price;
        }

        return true;
    }

    /**
     * Fetch all price components.
     *
     * @param void
     * @return void
     */
    private function read()
    {
        if ($this->ProductID === null) {
            return;
        }

        /*
            SELECT price_component_id,
                   currency_id,
                   price_or_factor
            FROM   sc_product_prices
            WHERE  product_id = :product_id
                   AND ( from_date IS NULL
                          OR from_date <= UTC_TIMESTAMP() )
                   AND ( thru_date IS NULL
                          OR thru_date > UTC_TIMESTAMP() )
         */
        $stmt = $this->Connection->prepare('SELECT price_component_id, currency_id, price_or_factor FROM sc_product_prices WHERE product_id = :product_id AND (from_date IS NULL OR from_date <= UTC_TIMESTAMP()) AND (thru_date IS NULL OR thru_date > UTC_TIMESTAMP())');
        $stmt->bindParam(':product_id', $this->ProductID, \PDO::PARAM_INT);
        $stmt->execute();

        $rows = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rows[$row['price_component_id']] = array($row['currency_id'] => $row['price_or_factor']);
        }
        $stmt->closeCursor();

        /*
         * Establish a base price (component key 0).  The base price is used in
         * price calculations.  If no base price was set, it defaults to the
         * recommended price (key 1), which in B2C e-commerce usually is the
         * MSRP (Manufacturer’s Suggested Retail Price) or RRP (Recommended
         * Retail Price).
         */
        if (!array_key_exists(0, $rows)) {
            if (array_key_exists(1, $rows)) {
                $rows[0] = $rows[1];
            }
        }

        $this->PriceComponents = $rows;
    }

    /**
     * Set the default precision.
     *
     * @param int $precision
     *   Number of digits from 0 up to and including 4.
     *
     * @return void
     */
    public function setPrecision($precision)
    {
        if (!is_int($precision)) {
            if (ctype_digit($precision)) {
                $precision = (int)$precision;
            } else {
                throw new \InvalidArgumentException(
                    __METHOD__ . ' expects parameter 1 to be integer, '
                    . gettype($precision) .' given.'
                );
            }
        }

        if ($precision < 0) {
            $precision = 0;
        } elseif ($precision > 4) {
            $precision = 4;
        }
        $this->Precision = $precision;
    }

    /**
     * @param int $product_id
     * @return void
     */
    public function setProductID($product_id)
    {
        $this->ProductID = $product_id;
    }
}
