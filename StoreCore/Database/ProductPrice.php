<?php
namespace StoreCore\Database;

/**
 * Product Price
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright (c) 2015 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Catalog
 * @version   0.0.1
 */
class ProductPrice extends \StoreCore\Database\AbstractModel
{
    const VERSION = '0.0.1';

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

        // First set the list price to the base price
        $base_price = $this->PriceComponents[0][978];
        $list_price = $base_price;

        // Plus fixed surcharge
        if (array_key_exists(12, $this->PriceComponents)) {
            if (array_key_exists(978, $this->PriceComponents[12])) {
                $list_price += $this->PriceComponents[12][978];
            }
        }

        // Plus variable surcharge
        if (
            array_key_exists(13, $this->PriceComponents)
            && array_key_exists(978, $this->PriceComponents[13])
        ) {
            $list_price += $this->PriceComponents[13][978] * $base_price;
        }

        // Minus fixed discount
        if (
            array_key_exists(14, $this->PriceComponents)
            && array_key_exists(978, $this->PriceComponents[14])
        ) {
            $list_price -= $this->PriceComponents[14][978];
        }

        // Minus variable discount
        if (
            array_key_exists(15, $this->PriceComponents)
            && array_key_exists(978, $this->PriceComponents[15])
        ) {
            $list_price -= $this->PriceComponents[15][978] * $base_price;
        }

        // Round calculated list price
        $list_price = round($list_price, $this->Precision);

        // Check minimum and maximum price
        if (
            array_key_exists(10, $this->PriceComponents)
            && array_key_exists(978, $this->PriceComponents[10])
            && $list_price < $this->PriceComponents[10]
        ) {
            $list_price = $this->PriceComponents[10];
        } elseif (
            array_key_exists(11, $this->PriceComponents)
            && array_key_exists(978, $this->PriceComponents[11])
            && $list_price > $this->PriceComponents[11]
        ) {
            $list_price = $this->PriceComponents[11];
        }

        // Store the calculated list price
        $this->PriceComponents[254][978] = $list_price;

        return true;
    }

    /**
     * Fetch all price components.
     *
     * @internal
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
                   AND ( from_date = '0000-00-00 00:00:00'
                          OR from_date <= UTC_TIMESTAMP() )
                   AND ( thru_date = '0000-00-00 00:00:00'
                          OR thru_date > UTC_TIMESTAMP() )
         */
        $stmt = $this->Connection->prepare("SELECT price_component_id, currency_id, price_or_factor FROM sc_product_prices WHERE product_id = :product_id AND (from_date = '0000-00-00 00:00:00' OR from_date <= UTC_TIMESTAMP()) AND (thru_date = '0000-00-00 00:00:00' OR thru_date > UTC_TIMESTAMP())");
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
         * MSRP (Manufacturer's Suggested Retail Price) or RRP (Recommended
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
     * @api
     * @param int $product_id
     * @return void
     */
    public function setProductID($product_id)
    {
        $this->ProductID = $product_id;
    }
}
