<?php
namespace StoreCore\Database;

/**
 * Currencies
 *
 * @author    Ward van der Put <Ward.van.der.Put@gmail.com>
 * @copyright Copyright © 2017 StoreCore
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\Core
 * @version   0.1.0
 */
class Currencies extends AbstractModel
{
    /** @var string VERSION Semantic Version (SemVer) */
    const VERSION = '0.1.0';

    /**
     * Check whether a currency exists.
     *
     * @param int|string $iso_currency_code
     *
     * @return
     *   Returns true if the currency code exists or false if it does not.
     */
    public function exists($iso_currency_code)
    {
        if (is_string($iso_currency_code) && strlen($iso_currency_code) !== 3) {
            return false;
        }

        if (is_int($iso_currency_code) && $iso_currency_code > 999) {
            return false;
        }

        $stmt = $this->Connection->prepare('
            SELECT COUNT(currency_id)
              FROM sc_currencies
             WHERE currency_id = ' . intval($iso_currency_code) . '
                OR currency_code = :currency_code
        ');
        $stmt->bindValue(':currency_code', $iso_currency_code, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() === 1 ? true : false;
    }

    /**
     * Get the default store currency for a given store.
     *
     * @param \StoreCore\Types\StoreID $store_id
     *
     * @return array|null
     *   Returns an indexed array with the ISO currency number as the numeric
     *   key and a \StoreCore\Currency object as the value.  If a store has no
     *   default currency, null is returned.
     */
    public function getDefaultStoreCurrency(\StoreCore\Types\StoreID $store_id)
    {
        $stmt = $this->Connection->prepare('
               SELECT s.currency_id, c.currency_code, c.digits, c.currency_symbol
                 FROM sc_store_currencies s
            LEFT JOIN sc_currencies c
                   ON s.currency_id = c.currency_id
                WHERE default_flag = 1
                  AND s.store_id = :store_id
        ');
        $stmt->bindValue(':store_id', (string)$store_id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);

        if ($result === false || empty($result)) {
            return null;
        }

        $result = $result[0];
        $currency = new \StoreCore\Currency($this->Registry);
        $currency_id = $result['currency_id'];
        $currency->setCurrencyCode($result['currency_code']);
        $currency->setCurrencyID($currency_id);
        $currency->setCurrencySymbol($result['currency_symbol']);
        $currency->setPrecision($result['digits']);
        return $currency;
    }

    /**
     * Get all currencies for a given store.
     *
     * @param \StoreCore\Types\StoreID $store_id
     *
     * @return array
     *   Returns an indexed array of \StoreCore\Currency objects with the
     *   currency ID (and numeric ISO currency code) as the key.  If the store
     *   has a default currency, it is returned as the first array element.
     *   If the store has no currencies at all, this method returns an array
     *   with the euro as the system default.
     */
    public function getStoreCurrencies(\StoreCore\Types\StoreID $store_id)
    {
        $stmt = $this->Connection->prepare('
               SELECT s.currency_id, c.currency_code, c.digits, c.currency_symbol
                 FROM sc_store_currencies s
            LEFT JOIN sc_currencies c
                   ON s.currency_id = c.currency_id
                WHERE s.store_id = :store_id
             ORDER BY default_flag DESC, currency_code ASC
        ');
        $stmt->bindValue(':store_id', (string)$store_id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);

        if ($result === false || empty($result)) {
            $default_currency = new \StoreCore\Currency($this->Registry);
            return array($default_currency->getCurrencyID() => $default_currency);
        }

        $store_currencies = array();
        foreach ($result as $row) {
            $currency = new \StoreCore\Currency($this->Registry);
            $currency_id = $row['currency_id'];
            $currency->setCurrencyCode($row['currency_code']);
            $currency->setCurrencyID($currency_id);
            $currency->setCurrencySymbol($row['currency_symbol']);
            $currency->setPrecision($row['digits']);
            $store_currencies[$currency_id] = $currency;
        }
        return $store_currencies;
    }

    /**
     * List all currently available currencies.
     *
     * @param void
     *
     * @return array
     *   Returns an indexed array with the ISO currency number as the key and
     *   a string with the currency name and ISO currency code as the value,
     *   sorted by the currency name in alphabetical order.
     */
    public function listAllCurrencies()
    {
        $stmt = $this->Connection->prepare("
              SELECT currency_id, CONCAT(currency_name, ' (', currency_code, ')') AS currency
                FROM sc_currencies
            ORDER BY currency_name ASC
        ");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_NUM);
        $stmt = null;

        $currencies = array();
        foreach ($result as $currency) {
            $currencies[$currency[0]] = $currency[1];
        }
        return $currencies;
    }
}
